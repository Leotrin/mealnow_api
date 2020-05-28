<?php

namespace App\Http\Controllers\ApiV1;

use App\Models\HomeProducts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop;

class ShopController extends BaseController
{
    public function homeProducts(){
        $products = HomeProducts::where('status',1)->get();
        return $this->returnData(true,null,$products);
    }
    public function homeShops(){
        $shops = Shop::inRandomOrder()->limit(6)->get();
        return $this->returnData(true,null,$shops);
    }
    public function restaurants()
    {

        if(\request('name') != null){
            $restaurants = Shop::where('city','like',"%".request('name')."%")->get();
        }else{
            $restaurants = Shop::all();
        }
        $today = strtolower(date('l'));
        $now = strtotime('now');

        foreach($restaurants as $restaurant){
            $wh = json_decode($restaurant->working_hours, true);
            $restaurant->working_hours = json_decode($restaurant->working_hours);
            $restaurant['isOpen'] = false;
            if(isset($restaurant->logo)){$restaurant['logoUrl']='http://localhost:8000/images/shops/'.$restaurant->id.'/'.$restaurant->logo;}
            if(isset($wh[$today])){
                if($now > strtotime($wh[$today]['hours_from'])  && $now < strtotime($wh[$today]['hours_to'])){
                    $restaurant->isOpen = true;
                    $restaurant->openTill = $wh[$today]['hours_to'];
                }
            }
        }
        return $this->returnData(true,null,$restaurants);
    }
    public function restaurant(){
        $restaurant = Shop::with('menu')->findOrFail(\request('id'));

        $today = strtolower(date('l'));
        $now = strtotime('now');

        $wh = json_decode($restaurant->working_hours, true);
        $restaurant->working_hours = json_decode($restaurant->working_hours);
        $restaurant['isOpen'] = false;
        if(isset($restaurant->logo)){$restaurant['logoUrl']='http://localhost:8000/images/shops/'.$restaurant->id.'/'.$restaurant->logo;}
        if(isset($wh[$today])){
            if($now > strtotime($wh[$today]['hours_from'])  && $now < strtotime($wh[$today]['hours_to'])){
                $restaurant->isOpen = true;
                $restaurant->openTill = $wh[$today]['hours_to'];
            }
        }

        //dd(json_decode($restaurant->menu->menu));

        return $this->returnData(true,null, $restaurant);
    }
}
