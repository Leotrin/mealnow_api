<?php

namespace App\Http\Controllers;

use App\Models\OrderLog;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
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

class CheckoutController extends Controller
{


    public function register($id){
        if(Auth::check()){
            return redirect('frontend/shop/'.$id.'/checkout/payment');
        }
        $shop = Shop::find($id);

        if(request()->isMethod('post')){
            try {
                DB::beginTransaction();
                $validation = $this->validator(request()->all());

                if ($validation->fails()) {
                    return redirect()->back()->withErrors($validation->errors()); // will return only the errors
                }

                $pass = CD::generatePassword();
                $user = new User();
                $user->gender = request('gender');
                $user->name = request('name');
                $user->email = request('email');
                $user->city = request('city');
                $user->address = request('address');
                $user->zip = request('zip');
                $user->tel = request('tel');
                $user->password = bcrypt($pass);
                $user->group_id = 4;
                $user->remember_token = $pass;
                $user->save();

                DB::commit();
                $schedule = session('schedule');
                $schedule['address'] = $user->address;
                session(['schedule' => $schedule]);
                auth()->login($user);
                Mail::to($user->email)->send(new NewRegisterOrder($user, $pass));
                return redirect('frontend/shop/'.$id.'/checkout/payment');
            }catch (\Throwable $e){
                report($e);
                DB::rollBack();
                return redirect('frontend/shop/'.$id.'/checkout/payment')->with('error', 'something_wrong happened.');
            }
        }

        $cart = session('cart');
        if($cart['shop_id']!=$id){
            return redirect('frontend/shop/'.$id);
        }
        $service = session('service');
        $schedule = session('schedule');
        return view('frontend.shop.register_new',compact('shop','cart','schedule','service'));

    }

    protected function validator(array $data){
        return Validator::make($data,[
            'name'=> 'required|string|max:191',
            'gender'=>'required',
            'email'=>'required|email|unique:users|string|max:255',
            'city'=>'required',
            'address'=>'required',
            'zip'=>'required',
            'tel'=>'required',
        ]);
    }

    public function payment($id){
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
            $cart       = session('cart');
            $schedule   = session('schedule');

            if($cart['shop_id']==$id) {
                $totali = $cart['total'] + $cart['service']['price'];
                $discount = null;
                if($cart['cupon'] != null){
                    if($cart['cupon']['type']=="Fixed"){
                        $totali = $totali - $cart['cupon']['price'];
                        $discount = $cart['cupon']['price'];
                    }else{
                        $discount = ($totali/100)*$cart['cupon']['price'];
                        $totali = $totali - $discount;
                    }
                    $cupon = Cupon::where('key',$cart['cupon']['key'])->first();
                    $cupon->limit = $cupon->limit-1;
                    $cupon->save();
                }

                $app = app();
                $billing = $app->make('App\Acme\Billing\BillingInterface');

                $b = $billing->charge([
                    'amount'        => $totali,
                    "number"        => request('card_no'),
                    "exp_month"     => request('ccExpiryMonth'),
                    "exp_year"      => request('ccExpiryYear'),
                    "cvc"           => request('cvvNumber'),
                    'description'   => 'new order',
                    'source'        => request('stripeToken')
                ]);
                $transaction = new Transaction();
                $transaction->trans_id = $b->id;
                $transaction->trans_data =json_encode($b);
                $transaction->save();

                if ($b->status == 'succeeded' && $b->paid=true) {

                  $order = new Order();
                  $order->shop_id         = $id;
                  $order->user_id         = auth()->user()->id;
                  $order->guest           = auth()->user()->name;
                  $order->session         = json_encode(array('cart'=>$cart, 'schedule'=>$schedule));
                  $order->type            = $schedule['service'];

                  if($schedule['time'] == 'later'){
                    $order->scheduled     = true;
                    $order->date          = $schedule['date'];
                  }else{
                    $order->scheduled     = false;
                    $order->date          = date('Y-m-d H:i');
                  }
                  $address = $schedule['address'];
                  if($schedule['address']==null || $schedule['address'] == ''){
                    $address = auth()->user()->address;
                  }
                  $order->address         = $address;
                  $order->delivery_price  = $cart['service']['price'];
                  if(isset($cart['cupon']) && $cart['cupon' != null]){
                      $order->cupon_code      = $cart['cupon']['key'];
                  }



                  $order->discount        = $discount;
                  $order->sum             = $totali;
                  $order->tax             = 0;
                  $order->sum_without_cupon= $cart['total'] + $cart['service']['price'];
                  $order->order           = json_encode($cart['products']);
                  $order->user_ip_address = request()->ip();
                  $order->user_browser    = request()->header('User-Agent');
                  $order->pin             = rand(1000,9999);
                  $order->transaction_id  = $b->id;

                  $order->save();

                  $log = new OrderLog();
                  $log->order_id = $order->id;
                  $log->user_id  = auth()->user()->id;
                  $log->action   = 'Order Created.';
                  $log->value    = 'New order.';
                  $log->save();

                  //send thank you email to client

                  //foreach shop conntact method notify him
                  //Mail::to($order->shop->email)->send(new NewOrder($order));
                  //Twilio::message($order->shop->tel,$order->pin);

                  request()->session()->forget('schedule');
                  request()->session()->forget('cart');

                  //auth()->login($user);
                  return redirect('frontend/payment/processed');
                }

              //return to fail page


            }else{
                return redirect('frontend/shop/'.$id);
            }
        }
        //$shop = Shop::find($id);
        $cart = session('cart');
        if($cart['shop_id']!=$id){
            return redirect('frontend/shop/'.$id);
        }
        $service = session('service');
        $schedule = session('schedule');
        return view('frontend.shop.payment',compact('shop','cart','schedule','service'));
    }
    public function processed(){
        $service = 'pickup';
        if(session('service')!='pickup'){
            $service = session('service');
        }
        return view('frontend.pages.processed',compact('service'));
    }
}
