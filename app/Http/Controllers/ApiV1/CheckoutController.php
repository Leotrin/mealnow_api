<?php

namespace App\Http\Controllers\ApiV1;

use App\Models\OrderLog;
use App\Models\Transaction;
use function GuzzleHttp\Psr7\str;
use Twilio;
use App\Mail\NewRegisterOrder;
use App\Mail\NewOrder;
use App\Models\Cupon;
use App\Models\Order;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Session;
use Illuminate\Support\Facades\Validator;
use App\Library\CustomDesignHelper as CD;

class CheckoutController extends BaseController
{

    public function payment(){
      $id = request('id');
      $shop = Shop::find($id);
      //process working time
      $today = strtolower(date('l'));
      $now = strtotime('now');
      $shop['isOpen'] = false;
      $wh = json_decode($shop->working_hours, true);
      if(isset($wh[$today])){
        if($now > strtotime($wh[$today]['hours_from'])  && $now < strtotime($wh[$today]['hours_to'])){
          $shop->isOpen = true;
          $shop->openTill = $wh[$today]['hours_to'];
        }
      }

      if(!$shop->isOpen){
        $shop->isOpen = false;
        $shop->nextOpen = 'test';
        $todayDate = date('d-m-Y');
        $notFound = true;
        $i=0;
        while($i <= 7 && $notFound){
          if( isset($wh[strtolower(date('l', strtotime($todayDate. '+'.$i.' days')))]) ){

            $notFound = false;
            $shop->nextOpen = [
              'day'=>date('d-m-Y', strtotime($todayDate. ' +'.$i.' days')),
              'start'=> $wh[strtolower(date('l', strtotime($todayDate. '+'.$i.' days')))]['hours_from']
            ];
          }
          $i++;
        }
      }

      $dates = [];
      $today = date('Y-m-d');
      for($i=0; $i<7; $i++){
        $dateToAdd = date('d-m-Y', strtotime($today .' +'.$i.' days'));
        if(isset( $wh[ strtolower(date('l', strtotime($dateToAdd))) ] )){
          array_push($dates, $dateToAdd);
        }
      }
      $shop->workingDays = $dates;

      if(request()->isMethod('post')){
            $cart       = json_decode(request('cart'));
            $schedule   = json_decode(request('schedule'));
            $user       = json_decode(request('user'));
//            dd(request('stripeToken'));
            if($cart->shop_id==$id) {
                $totali = $cart->total+ $cart->service_price;
                $discount = null;
                if($cart->cupon!=null){
                    if($cart->cupon_type=="Fixed"){
                        $totali = $totali - $cart->cupon_price;
                        $discount = $cart->cupon_price;
                    }else{
                        $discount = ($totali/100)*$cart->cupon_price;
                        $totali = $totali - $discount;
                    }
                    $cupon = Cupon::where('key',$cart->cupon_key)->first();
                    $cupon->limit = $cupon->limit-1;
                    $cupon->save();
                }}

                  $order = new Order();
                  $order->shop_id         = $id;
                  if($schedule->logged){
                      $order->user_id         = $user->id;
                  }else{
                      $order->guest           = $user->name;
                  }

                  $order->session         = json_encode(array('cart'=>$cart, 'schedule'=>$schedule));
                  $order->type            = $schedule->type;

                  if($schedule->time == 'later'){
                      $order->scheduled     = true;
                      $order->date          = $schedule->date;
                  }else{
                      $order->scheduled     = false;
                      $order->date          = date('Y-m-d H:i');
                  }
                  if(isset($schedule->address->streetName)){
                      $address = $schedule->address->streetName.', '.$schedule->address->zipCode.' '.$schedule->address->city;
                  } else {
                      $address = 'Address not set by user.';
                  }

                if ($schedule->method === 'card') {

                    $cards = json_decode(request('card_details'));
                    $app = app();
                    $billing = $app->make('App\Acme\Billing\BillingInterface');
                    $b = $billing->charge([
                        'amount' => $totali,
                        "number" => $cards['number'],
                        "number" => $cards['exp_month'],
                        "number" => $cards['exp_year'],
                        "number" => $cards['cvc'],
                        'description' => 'new order',
                        'token' => request('stripeToken')
                    ]);

                    $transaction = new Transaction();
                    $transaction->trans_id = $b->id;
                    $transaction->trans_data = json_encode($b);
                    $transaction->save();

                    if ($b->status == 'succeeded' && $b->paid=true) {
                        $order->transaction_id  = $b->id;
                    } else {
                        return $this->returnData(false, 'Transaction could not be completed.', null);
                    }
                } else {
                    $order->transaction_id  = 'cash';
                }
                  $order->address         = $address;
                  $order->delivery_price  = $cart->service_price;
                  $order->cupon_code      = $cart->cupon_key;
                  $order->discount        = $discount;
                  $order->sum             = $totali;
                  $order->tax             = 0;
                  $order->sum_without_cupon= $cart->total + $cart->service_price;
//                  dd($cart);
                  $order->order           = json_encode($cart->products);
                  $order->user_ip_address = request()->ip();
                  $order->user_browser    = request()->header('User-Agent');
                  $order->pin             = rand(1000,9999);
//                  dd($order);
                  $order->save();

                  $log = new OrderLog();
                  $log->order_id = $order->id;
                  if($schedule->logged){
                      $log->user_id  = $user->id;
                  } else {
                      $log->user_id = 0;
                  }
                  $log->action   = 'Order Created.';
                  $log->value    = 'New order.';
                  $log->save();
                  return $this->returnData(true,'Pass',$order);

                  // //send thank you email to client

                  // //foreach shop conntact method notify him
                  // //Mail::to($order->shop->email)->send(new NewOrder($order));
                  // //Twilio::message($order->shop->tel,$order->pin);

                  // request()->session()->forget('schedule');
                  // request()->session()->forget('cart');

                  // //auth()->login($user);
                  // return redirect('frontend/payment/processed');
                }


            //  // return to fail page


      //       }else{
      //           return redirect('frontend/shop/'.$id);
      //       }
      //   }
      //   //$shop = Shop::find($id);
      //   $cart = session('cart');
      //   if($cart['shop_id']!=$id){
      //       return redirect('frontend/shop/'.$id);
      //   }
      //   $service = session('service');
      //   $schedule = session('schedule');
      //   return view('frontend.shop.payment',compact('shop','cart','schedule','service'));
    }


    // public function processed(){
    //     $service = 'pickup';
    //     if(session('service')!='pickup'){
    //         $service = session('service');
    //     }
    //     return view('frontend.pages.processed',compact('service'));
    // }
}
