<?php

namespace App\Http\Controllers\ApiV1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shop;

class ShopController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurants = Shop::all();
        /** Processing the work hours */
        
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
              $menu = null;
            if(isset($restaurant->menu->menu)){
              $menu = json_decode($restaurant->menu->menu,true);
          }

        }
        return $this->returnData(true,'All restaurants',$restaurants);
    }
    public function searchRestaurants(){
        $restaurants = Shop::where('city','like',"%".request('name')."%")->get();
        /** Processing the work hours */
        
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
        return $this->returnData(true,'Filtered',$restaurants);
    }

    public function singleRestaurant(){
        
        $restaurants = Shop::where('id','like','%'.request('id').'%')->get();
        /** Processing the work hours */
        
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
              $menu = null;
            if(isset($restaurant->menu->menu)){
              $menu = json_decode($restaurant->menu->menu,true);
          }
         
        }
        return $this->returnData(true,'All restaurants',$restaurants);
    }

    public function checkProduct(){
      $id = request('id');
      $shop = Shop::find($id);
      $product= json_decode(request('product'));
      $catKey = request('category');
      $menu = null;
      $specialProduct = false;
      if(isset($shop->menu->menu)){
          $menu = json_decode($shop->menu->menu,true);
      }
      $productToCheck = null;
        foreach($menu['items'] as $categoryKey=>$category){ 
            if($catKey==$categoryKey) {
                foreach ($category['products'] as $productKey => $prod) {
                    if ($prod != null && $productKey == $product->order) {
                        // if (isset($prod['isSpecial']) && $prod['isSpecial'] == true) {
                        //     $specialProduct = true;
                        // }
                        $productToCheck = $prod;
                    }
                }
            }
        }if($productToCheck!=null) {
          $test=null;
          $qty = $product->qty;
          $productForCart = array('name'=>$productToCheck['name'],'description'=> $qty.' <b>x</b> ','price'=>0.00);
          $extraConditions = [];
          if($product->option != null) {
              if ($productToCheck['type'] != null){
                  foreach($productToCheck['type'] as $key=>$value){
                      if($product->option->type == $key) {
                        $test=$key;
                          $print_type = $value['name'];
                          if($key==0){
                              $print_type = 'Normal';
                          }
                          $productForCart['description'] .= $print_type.'<br />';
                          $productForCart['price'] = $productForCart['price'] + (float)$value['price'];
                      }
                  }
              }
          }
        }
        if($product->items != null)
            {
              //dd($product->items);

                foreach($product->items as $itemKey=>$item){
                  if($item!=null){
                    if (!is_numeric($item->group) && $item->group == 'topings'){

                        $nr = 0;
                        if(isset($productToCheck['topings']['nr']))
                        {
                            $nr = $productToCheck['topings']['nr'];
                        }
                        $extraConditions['topings'] = [
                            'name'  =>'topings',
                            'min'   =>$productToCheck['topings']['min'],
                            'max'   =>$productToCheck['topings']['max'],
                            'nr'    => $nr
                        ];
                        $toping =$productToCheck['topings']['options'][$item->topingKey];
                        if($item->name == $toping['name']) {
                            if($item->size == '1half'){
                                $productForCart['price'] = $productForCart['price'] + (float)$toping['prices'][$product->option->type]['half_price'];
                                $productForCart['description'] .= 'Left Half '.$toping['name'].' ,';
                            }elseif($item->size == '2half'){
                                $productForCart['price'] = $productForCart['price'] + (float)$toping['prices'][$product->option->type]['half_price'];
                                $productForCart['description'] .= 'Right Half '.$toping['name'].' ,';
                            }else{
                                $productForCart['price'] = $productForCart['price'] + (float)$toping['prices'][$product->option->type]['whole_price'];
                                $productForCart['description'] .= 'Whole '.$toping['name'].' ,';
                            }
                            $extraConditions['topings']['nr'] =  $extraConditions['topings']['nr']+1;
                        }

                    }else{
                       $productForCart='is else';
                    }
                }}

            }
      return $this->returnData(true,'Product check',$productForCart);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
