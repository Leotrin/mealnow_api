<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class OrderController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }
    public function orders(){
      if( auth()->user()->group_id == 1 ){
        $myorders = [];
        $neworders = Order::all();
        foreach ($neworders as $item){
          $item->shop->isShopWorking();
        }
      }else{
        $myorders = Order::where('assigned_user_id', '=', auth()->user()->id)
          ->whereIn('status',[0,3,4,6,8])->get();
        foreach ($myorders as $item){
          $item->shop->isShopWorking();
        }

        $neworders = Order::where('assigned_user_id', '=', null)
          ->whereIn('status',[0,3,4,6,8])->get();
        foreach ($neworders as $item){
          $item->shop->isShopWorking();
        }
      }


        //$myOrders = Order::where('status', '!=', 10)->where('assigned_user_id', '=', auth()->user()->id)->get();

        return view('new_backend.orders.list',compact('myorders', 'neworders'));
    }
    public function order($id){
      try {
        $order = Order::findOrFail($id);
        $order->shop->isShopWorking();
        if ($order->assigned_user_id == null) {
          if (auth()->user()->group_id != 1) {
            $order->assigned_user_id = auth()->user()->id;
            $order->save();
            $this->order_log($order->id, auth()->user()->id, 'Assign User', 'Assigned Order to ' . auth()->user()->email . ' (' . auth()->user()->id . ')');
          }
        }
        return view('new_backend.orders.details', compact('order'));
      }catch (Exception $e){
        Log::emergency($e->getMessage());
        return redirect('admin/orders')->withErrors('error', 'could not release. something wrong happened');
      }

    }
    public function call($id){
      try {
        $order = Order::findOrFail($id);
        if ($order->status == 0 && $order->called < 3) {
          $order->called = $order->called + 1;
          $order->save();
          $this->order_log($order->id, auth()->user()->id, 'Called ' . $order->called, 'Called Shop manager for confirmation..');
          return redirect('/admin/order/view/'.$order->id);
        } else {
          return redirect('/admin/order/view/'.$order->id)->withErrors('error', 'something wrong happened');
        }
      }catch (Exception $e){
        Log::emergency($e->getMessage());
        return redirect('/admin/orders')->withErrors('error', 'something wrong happened');
      }

    }
    public function reject($id){
      try {
        $order = Order::find($id);
        if ($order->status == 0) {
          $order->status = 2;
          $order->save();
          $this->order_log($order->id, auth()->user()->id, 'Rejected by Melanow Order Manager', 'Changed status to Rejected (2)');
          return redirect('admin/orders');
        }
      }catch(Exception $e){
        Log::emergency($e->getMessage());
          return redirect('admin/orders')->withErrors('error', 'something wrong hapened');
      }

    }
    public function phone_confirmation($id){
      try {
        $order = Order::where('id', $id)->where('pin', request('pin'))->first();
        if ($order != null && ($order->status == 0 || $order->status == 1)) {
          $order->status = 4;
          $order->pin = 600000;
          $order->save();
          $this->order_log($order->id, auth()->user()->id, 'Phone call confirmation.', 'Changed status to Shop Confirmed (4).');
            return redirect('admin/order/view/' . $id);
        } else {
          return redirect('admin/order/view/' . $id)->withErrors('error', 'could not confirm. user may have rejected');
        }
      }catch(Exception $e){
        Log::emergency($e->getMessage());
        return redirect('admin/order/view/' . $id)->withErrors('error', 'something wrong happened');
      }
    }
    public function release($id){
      try {
        $order = Order::where('id', $id)
          ->where('assigned_user_id', '=', auth()->user()->id)
          ->whereIn('status', [0, 3, 4, 6, 8])
          ->first();
        if ($order != null) {
          $order->assigned_user_id = null;
          $order->save();
          $this->order_log($order->id, auth()->user()->id, 'Release order', 'Released order: '.\auth()->user()->email . ' (' . \auth()->user()->id . ')');
          return redirect('admin/orders');
        }else{
          return redirect('admin/orders')->withErrors('error', 'could not release. something wrong happened');
        }
      }catch (Exception $e){
        Log::emergency($e->getMessage());
       return redirect('admin/orders')->withErrors('error', 'could not release. something wrong happened');
      }
    }
    public function complete($id){
      try {
        $order = Order::where('id', $id)
          ->where('assigned_user_id', '=', auth()->user()->id)
          ->whereIn('status', [3, 4, 8])->first();

        if ($order != null) {
          $order->status = 9;
          $order->save();
          $this->order_log($order->id, auth()->user()->id,'Complete order','Order manager '.auth()->user()->email. '('.auth()->user()->id.')'.' completed order ' . $id);
          return redirect('admin/order/'.$id)->withErrors('error', 'something wrong happened');
        }else{
          return redirect('admin/orders')->withErrors('error', 'something wrong happened');
        }

      }catch (Exception $e){
        Log::emergency($e->getMessage());
        return redirect('admin/orders')->withErrors('error', 'could not release. something wrong happened');
      }
  }
  //    public function shop_confirmation($id){
//        $order = Order::where('id',$id)->where('pin',request('pin'))->first();
//        if($order!=null && ($order->status==0 || $order->status==1)){
//            $order->status = 3;
//            $order->pin = 600000;
//            $order->save();
//            $log = new OrderLog();
//            $log->order_id = $order->id;
//            $log->user_id  = auth()->user()->id;
//            $log->action   = 'Shop confirmation.';
//            $log->value    = 'Changed status to 3.';
//            $log->save();
//            return redirect('admin/orders/view/'.$id);
//        }
//    }
}
