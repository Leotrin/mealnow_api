<?php

namespace App\Http\Controllers;

use App\Library\WorkingTImeHeper;
use App\Models\Shop;
use Session;

class ShopController extends Controller
{
    public function new_list(){
        $restaurants = Shop::all();
        return view('backend.shop.list',compact('restaurants'));
    }

    // public function shops(){
    //   $player = User::where('id',Auth::user()->id)->with('player')->first();
    //   \request()->request->add(['token' => $player->token]);
    //   \request()->request->add(['id' => $tId]);
    //   $transfers = app(\App\Http\Controllers\ApiV1\ClubController::class)->deleteTransfer();
    //   if($transfers->original['status'] == false)
    //       $msg = "error";
    //   else
    //       $msg = "success";
    //   return back()->with($msg,$transfers->original['message']);
    // }

    public function shops(){
        $location = request('location');
        $shops = Shop::where('search_city','like','%'.$location.'%')->get();

        //dd($today);
        $now = strtotime('now');

        foreach ($shops as $shop) {
            WorkingTImeHeper::openTill($shop);
        }
        $service = 'pickup';
        if(request('pickup_delivery')!=null){
            $service = request('pickup_delivery');
        }
        session(['service'=>$service]);
        $service = session('service');
        return view('frontend.shop.list',compact('shops','service','location'));
    }
    public function shop($id){
        $shop = Shop::findOrFail($id);
        WorkingTImeHeper::openTill($shop);

        $wh = json_decode($shop->working_hours, true);
        if(!$shop->isOpen){
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

//        $workingDays = json_decode($shop->working_hours);
//        $disabledDays = [1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7];
//        foreach ($workingDays as $key=>$hours){
//            unset($disabledDays[$this->getDay($key)]);
//        }
//
//        $shop->disabledDays = array_keys($disabledDays);
        $menu = null;
        if(isset($shop->menu->menu)){
            $menu = json_decode($shop->menu->menu,true);
        }

        if (session('schedule') != null) {
          $schedule = session('schedule');
          $schedule = [
            'date'      => $schedule['date'],
            'time'      => $schedule['time'],
            'service'   => $schedule['service'],
            'name'      => $schedule['name'],
            'address'   => $schedule['address']
          ];
          session(['schedule' => $schedule]);
        }else{
          $schedule = [
            'date'      => date('d-m-Y H:i'),
            'time'      => 'now',
            'service'   => 'pickup',
            'name'      => '',
            'address'   => ''
          ];
          session(['schedule' => $schedule]);
        }

        $price = 0;
        if($schedule['service'] == 'delivery'){
          $price = $shop->delivery_price;
        }

        if (session('cart') != null) {
            $cart = session('cart');
            if($id != $cart['shop_id']){
                //Session::flush();
                $cart = [
                    'shop_id'           => $id,
                    'special'           => false,
                    'specialInstruction'=> null,
                    'cupon'             => null,
                    'products'          => [],
                    'service'           => [
                        'type'  => $schedule['service'],
                        'price' => $price
                    ],
                    'time'=>$schedule['time'],
                    'total'             => 0.00
                ];
                session(['cart' => $cart]);
            }else{
                $cart['service'] = [
                                    'type'  => $schedule['service'],
                                    'price' => $shop->delivery_price
                                ];
                session(['cart' => $cart]);
            }
        }else{
            $cart = [
                'shop_id'           => $id,
                'special'           => false,
                'specialInstruction'=> null,
                'cupon'             => null,
                'products'          => [],
                'service'           => [
                    'type'  => $schedule['service'],
                    'price' => $shop->delivery_price
                ],
                'time'=>$schedule['time'],
                'total'             => 0.00
            ];
            session(['cart' => $cart]);
        }
        $schedule = null;
        if (session('schedule') != null) {
            $schedule = session('schedule');
        }
        return  view('frontend.shop.single', compact('shop','menu','cart','schedule'));
    }

  function getDay($day){
    $dowMap = ['sunday'=>7, 'monday'=>1, 'tuesday'=>2, 'wednesday'=>3, 'thursday'=>4, 'friday'=>5, 'saturday'=>6];
    return $dowMap[$day];
  }

}
