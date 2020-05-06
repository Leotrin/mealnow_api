<?php

namespace App\Http\Controllers;
use App\Models\Shop;
use Session;
use Auth;

class OrderController extends Controller
{
    private function responseToApp($status, $message,$val,$error){
        $values = [
            'status'=>$status,
            'message'=>$message,
            'values'=> $val,
            'error'=>$error
        ];
        return $values;
    }
    public function clear_session(){
        Session::flush();
    }
    public function addToCart($id){

        $product = json_decode(request('product'));
        $catKey = $product->category;
        $shop = Shop::find($id);
        $menu = null;
        $specialProduct = false;
        if(isset($shop->menu->menu)){
            $menu = json_decode($shop->menu->menu,true);
        }
        $productToCheck = null;
        foreach($menu['items'] as $categoryKey=>$category){
            if($catKey==$categoryKey) {
                foreach ($category['products'] as $productKey => $prod) {
                    if ($prod != null && $productKey == $product->name) {
                        if (isset($prod['isSpecial']) && $prod['isSpecial'] == true) {
                            $specialProduct = true;
                        }
                        $productToCheck = $prod;
                    }
                }
            }
        }

        if (session('cart') != null) {
            $cart = session('cart');
            if($cart['special'] == true && $specialProduct==true){
                return response()->json($this->responseToApp(false,'',null,'You can add only one special product to your shopping cart !'));
            }
            if($id != $cart['shop_id']){
                Session::flush();
            }
        }
        if($productToCheck!=null) {
            $qty = $product->qty;
            $productForCart = array('name'=>$productToCheck['name'],'description'=> $qty.' <b>x</b> ','price'=>0.00);
            $extraConditions = [];
            if($product->option != null) {
                if ($productToCheck['type'] != null){
                    foreach($productToCheck['type'] as $key=>$value){
                        if($product->option->type == $key) {

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
                        foreach($productToCheck['properties'] as $propertyKey=>$property){
                            if($item->group == $propertyKey){
                                $nr = 0;
                                if(isset($extraConditions[$property['name']]['nr']))
                                {
                                    $nr = $extraConditions[$property['name']]['nr'];
                                }
                                $extraConditions[$property['name']] = [
                                    'name'  =>$property['name'],
                                    'min'   =>$property['min'],
                                    'max'   =>$property['max'],
                                    'nr'    => $nr
                                ];
                                foreach($property['options'] as $option){
                                    if($item->name == $option['name']) {
                                        $productForCart['description'] .= $option['name'].' ,';
                                        $productForCart['price'] = $productForCart['price'] + (float)$option['prices'][$product->option->type]['price'];
                                        $extraConditions[$property['name']]['nr'] = $extraConditions[$property['name']]['nr'] + 1;
                                    }
                                }
                            }
                        }
                    }
                }}

            }




            foreach($extraConditions as $eCondition){
                if($eCondition['min'] > $eCondition['nr'] || $eCondition['max'] < $eCondition['nr'] ){
                    return response()->json($this->responseToApp(false,'',$eCondition,str_replace('_',' ',$eCondition['name']).' does not meet the minimum and maximum requirements !'));
                }
            }

            $productForCart['price'] = $productForCart['price'] * $qty;
            $productForCart['special'] = $specialProduct;

            if (session('cart') != null) {
                $cart = session('cart');
                if($specialProduct==true){
                    $cart['special'] = $specialProduct;
                }
                array_push($cart['products'],  $productForCart);
                $cart['total'] = $cart['total'] + $productForCart['price'];
                $cart['total'] = number_format($cart['total'],2);
                $cart['specialInstruction'] = request('specialInstruction');
                session(['cart' => $cart]);
            } else {
                $cart = [
                    'shop_id'           => $id,
                    'special'           => $specialProduct,
                    'specialInstruction'=> request('specialInstruction'),
                    'cupon'             => null,
                    'products'          => [],
                    'service'           => [],
                    'total'             => number_format($productForCart['price'],2)
                ];
                array_push($cart['products'], $productForCart);
                session(['cart' => $cart]);
            }
        }
        return response()->json($this->responseToApp(true,'',session('cart'),null));
    }
    public function changeService($id, $service){
        $shop = Shop::find($id);
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
                    'service'           => [],
                    'total'             => 0.00
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
                'service'           => [],
                'total'             => 0.00
            ];
            session(['cart' => $cart]);
        }

        $cart = session('cart');
        $price = 0;
        if($service=="delivery"){
            $price = $shop->delivery_price;
        }

        $cart['service'] = [
            'type'  => $service,
            'price' => $price
        ];
        $schedule = session('schedule');
        if($schedule != null){
          $schedule['service'] = $service;
        }
        session(['schedule' => $schedule,'cart' => $cart]);
        return response()->json($this->responseToApp(true,'',session('cart'),null));
    }
    public function changeTime($id, $time){

      //$shop = Shop::find($id);
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
                    'service'           => $cart['service'],
                    'time'              => null,
                    'total'             => 0.00
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
                'service'           => [],
                'time'              => null,
                'total'             => 0.00
            ];
            session(['cart' => $cart]);
        }



        $cart = session('cart');
        $cart['time'] = $time;
        session(['time'=>$time]);
        session(['cart' => $cart]);

        return response()->json($this->responseToApp(true,'',session('cart'),null));
    }
    public function deleteProduct($id, $key){
        $shop = Shop::find($id);
        $cart = session('cart');
        $product = $cart['products'][$key];
        $cart['total'] = $cart['total']-$product['price'];
        if($product['special']==true){
            $cart['special'] = false;
        }
        unset($cart['products'][$key]);
        session(['cart' => $cart]);
        return response()->json($this->responseToApp(true,'',session('cart'),null));
    }
    public function scheduleOrder($id){
        //$shop = Shop::find($id);

        //if (session('schedule') != null) {
            $schedule = session('schedule');
            //dd($schedule);
            $schedule = [
                'date'      => date('Y-m-d H:i', strtotime(request('date').' '.request('time'))),
                'time'      => 'later',
                'service'   => $schedule['service'],
                'name'      => $schedule['name'],
                'address'   => $schedule['address']
            ];
            session(['schedule' => $schedule]);
        //}
//        else{
//            $address = '';
//            $name = '';
//            if(Auth::check()){
//                $address = auth()->user()->address;
//                $name = auth()->user()->name;
//            }
//            $schedule = [
//                'date'      => request('date'), //AS SOON AS POSSIBLE
//                'time'      => request('time'),
//                'service'   => 'pickup',
//                'address'   => $address,
//                'name'      => $name
//            ];
//            session(['schedule' => $schedule]);
//        }
        return response()->json($this->responseToApp(true,'',session('schedule'),null));
    }
    public function changeAddress(){
//        $shop = Shop::find($id);

        if (session('schedule') != null) {
            $schedule = session('schedule');
            $schedule = [
                'date'      => $schedule['date'],
                'time'      => $schedule['time'],
                'service'   => session('service'),
                'name'      => request('name'),
                'address'   => request('address')
            ];
            session(['schedule' => $schedule]);
        }else{
            $schedule = [
                'date'      => 'asap', //AS SOON AS POSSIBLE
                'time'      => null,
                'service'   => session('service'),
                'name'      => request('name'),
                'address'   => request('address')
            ];
            session(['schedule' => $schedule]);
        }
        return response()->json($this->responseToApp(true,'',session('schedule'),null));
    }
    public function cart($id){
        $shop = Shop::find($id);
        $products = [];
        if(session('cart')!=null){
            $cart = session('cart');
            $products = $cart['products'];
        }
        if(count($products)<=0){
            return response()->json($this->responseToApp(false,'',null,'You can not checkout for nothing !'));
        }
        $return = ['url'=>url('frontend/shop/'.$id.'/checkout/register')];
        if(Auth::check()){
            $return = ['url'=>url('frontend/shop/'.$id.'/checkout/payment')];
        }
        return response()->json($this->responseToApp(true,'',$return,null));
    }
}
