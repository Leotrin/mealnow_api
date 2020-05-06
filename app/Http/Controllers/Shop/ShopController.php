<?php

namespace App\Http\Controllers\Shop;

use App\Models\Adjustments;
use App\Models\Order;
use App\Models\OrderLog;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
  public function __construct()
  {
      $this->middleware('shop');
  }
  public function index(){
      $neworders = Order::where('shop_id','=',auth()->user()->shop->id)
                      ->whereIn('status', [0,6])
                      ->get();
      $confirmedorders = Order::where('shop_id','=',auth()->user()->shop->id)
                            ->whereIn('status', [3,4,8])
                            ->get();
      return view('shop.orders',compact('neworders', 'confirmedorders'));
  }
  public function confirmation($id){
      $order = Order::where('id',$id)->where('shop_id',auth()->user()->shop->id)->where('pin',request('pin'))->first();

      if($order!=null && ($order->status==0 || $order->status==1)){
          $order->status = 3;
          $order->pin = 600000;
          $order->save();

          $log = new OrderLog();
          $log->order_id = $order->id;
          $log->user_id  = auth()->user()->id;
          $log->action   = 'Shop confirmation.';
          $log->value    = 'Changed status to 3.';
          $log->save();
          return redirect('shop');
      }else{
          return redirect()->back()->withErrors(['error'=>'The PIN is invalid !']);
      }
  }
  public function reject($id){
      $order = Order::where('id',$id)->where('shop_id',auth()->user()->shop->id)->first();

      if($order!=null && ($order->status==0 || $order->status==1)){
          $order->status = 5;
          $order->pin = 600000;
          $order->save();

          $log = new OrderLog();
          $log->order_id = $order->id;
          $log->user_id  = auth()->user()->id;
          $log->action   = 'Shop Rejected order.';
          $log->value    = 'Changed status to 5.';
          $log->save();
          //notify user for adjustments

          return redirect('shop');
      }else{
          return redirect()->back()->withErrors(['error'=>'You have no rights to do this action !']);
      }
  }
  public function order($id){
      $order = Order::where('id',$id)->where('shop_id',auth()->user()->shop->id)->firstOrFail();
      return view('shop.details',compact('order'));
  }
  public function completed(){
    $orders = Order::where('shop_id',auth()->user()->shop->id)
      ->whereIn('status', [1,2,5,7,9,10,11])->get();
    return view('shop.completedOrders',compact('orders'));
  }

  public function complete($id){
    $order = Order::where('id', '=',$id)
                  ->where('shop_id', '=', auth()->user()->shop->id)
                  ->whereIn('status',[3,4,8])->first();
    if($order){
      $order->status = 9;
      $order->save();

      $log = new OrderLog();
      $log->order_id = $order->id;
      $log->user_id  = auth()->user()->id;
      $log->action   = 'Order Completed from Shop.';
      $log->value    = 'Shop changed order status to 9.';
      $log->save();
      return redirect('shop');
    }
    return redirect('shop');
  }

  public function adjust($id){
    $order = Order::where('id','=', $id)->findorFail();
    if($order->status == 0){
      $adjust  = new Adjustments();
      $adjust->order_id = $id;
      $adjust->desc = request('adjust');
      $adjust->amount = request('amount');
      if($adjust->save()){
        $order->status = 6;
        $order->has_adjustment = true;
        $order->save();


        $log = new OrderLog();
        $log->order_id = $order->id;
        $log->user_id  = auth()->user()->id;
        $log->action   = 'Adjustment request.';
        $log->value    = 'Changed status to Under Adjustment.';
        $log->save();

        return redirect('shop/order/'.$id);

      }else{
        return redirect()->withErrors('error', 'Status has changes Order may be rejected');
      }

    }else{
      return redirect()->withErrors('error', 'Status has changes Order may be rejected');
    }


  }
}
