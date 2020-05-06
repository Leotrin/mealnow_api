<?php

namespace App\Http\Controllers;

use App\Models\Cupon;
use App\Models\Shop;
use Session;

class CuponController extends Controller
{
    public function enter_cupon($id){
        $cupon = request('cupon_code');
        $shop = Shop::find($id);
        $cart = session('cart');
        if($cart['shop_id']!=$shop->id){
            //Session::flush();
            return redirect('frontend/shop/'.$id);
        }
        $cupon = Cupon::where('key',$cupon)->first();
        if($cupon!=null && $cupon->limit>0){
            $cart['cupon'] = [
                'price' => $cupon['sum'],
                'type'  => $cupon['type'],
                'key'   => $cupon['key']
            ];
            session(['cart'=>$cart]);
            return redirect('frontend/shop/'.$id.'/checkout/payment');
        }else{
          return redirect('frontend/shop/'.$id.'/checkout/payment')->withErrors('error', 'Not valid cupon');
        }
    }
}
