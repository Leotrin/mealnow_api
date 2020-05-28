<?php

namespace App\Http\Controllers\ApiV1;
use App\Models\Cupon;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\Shop;
use App\Models\Transaction;

class OrderController extends BaseController
{
    public function enterCoupon(){
        $cupon = request('cupon_code');
        $cupon = Cupon::where('key',$cupon)->first();
        if($cupon!=null && $cupon->limit>0){
            $cupon = [
                'price' => $cupon['sum'],
                'type'  => $cupon['type'],
                'key'   => $cupon['key']
            ];
            return $this->returnData(true,null,$cupon);
        }
        return $this->returnData(false,'No coupon for this Code is available.',null);

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
        } else {
            return $this->returnData(false, 'There is some kind of issue with the placement of your order.', null);
        }
        $productToCheck = null;
        //dd($menu['items']);
        foreach($menu['items'] as $categoryKey=>$category){
            if($catKey==$categoryKey) {
                if ($category != null) {
                foreach ($category['products'] as $productKey => $prod) {
                    if ($prod != null && $productKey == $product->order) {
                        if (isset($prod['isSpecial']) && $prod['isSpecial'] == true) {
                            $specialProduct = true;
                        }
                        $productToCheck = $prod;
                    }
                }
            }
            }
        }

        if($productToCheck!=null) {
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
        if(isset($extraConditions) && $extraConditions != null) {
            foreach ($extraConditions as $eCondition) {
                if ($eCondition['min'] > $eCondition['nr'] || $eCondition['max'] < $eCondition['nr']) {
                    //return response()->json($this->responseToApp(false,'',$eCondition,str_replace('_',' ',$eCondition['name']).' does not meet the minimum and maximum requirements !'));
                    return $this->returnData(false, 'Product check', $eCondition, str_replace('_', ' ', $eCondition['name']) . ' does not meet the minimum and maximum requirements !');
                }
            }
        }

        $productForCart['price'] = $productForCart['price'] * $qty;
        $productForCart['special'] = $specialProduct;
        $product->category = $catKey;
        $productForCart['orderProd']=json_encode($product);
        $productForCart['client_id']=$id;

        return $this->returnData(true,'Product check',$productForCart);
    }
    public function multipleProdCheck(){
        $id = request('id');
        $shop = Shop::find($id);
        $prods = json_decode(request('product'));
        $prodCheckOut = array('price'=>0.00);

        foreach($prods as $prod){
            $product= $prod;
            $catKey = $prod->category;
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
                            if (isset($prod['isSpecial']) && $prod['isSpecial'] == true) {
                                $specialProduct = true;
                            }
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
                    //return response()->json($this->responseToApp(false,'',$eCondition,str_replace('_',' ',$eCondition['name']).' does not meet the minimum and maximum requirements !'));
                    return $this->returnData(false,'Product check', $eCondition,str_replace('_',' ',$eCondition['name']).' does not meet the minimum and maximum requirements !');
                }
            }
            $productForCart['price'] = $productForCart['price'] * $qty;
            $prodCheckOut['client_id']=$id;
            $prodCheckOut['price'] += $productForCart['price'];
            $prodCheckOut['products'][] = $productForCart;
        }




        return $this->returnData(true,'Product check',$prodCheckOut);
    }
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
                $cards = json_decode(request('card_details'),true);
                $app = app();
                $billing = $app->make('App\Acme\Billing\BillingInterface');
                $b = $billing->charge([
                    'amount' => $totali,
                    "number" => $cards['number'],
                    "exp_month" => $cards['exp_month'],
                    "exp_year" => $cards['exp_year'],
                    "cvc" => $cards['cvc'],
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

}
