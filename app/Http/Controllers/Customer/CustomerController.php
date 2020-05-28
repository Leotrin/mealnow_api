<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer');
    }

    public function index(){
      try{
        $orders = Order::where('user_id',auth()->user()->id)
                        ->whereIn('status', [0,3,4,8,6])->orderBy('id', 'desc')->get();
        return view('customer.orders',compact('orders'));
      }catch (Exception $e){
        Log::error($e->getMessage());
        return redirect('customer')->withErrors(['error' => 'You have no rights to do this action !']);
      }
    }

    public function previous(){
      try{
          $orders = Order::with('shop')->where('user_id',auth()->user()->id)
            ->whereIn('status', [1,2,5,7,9,10,11])->orderBy('id', 'desc')->get();

          return view('customer.orders',compact('orders'));
      }catch (Exception $e){
        Log::error($e->getMessage());
        return redirect('customer')->withErrors(['error' => 'You have no rights to do this action !']);
      }
    }
    public function reject($id){
      try{
        $order = Order::where('id',$id)->where('user_id',auth()->user()->shop->id)->first();
        if($order!=null && ($order->status==0 || $order->status==1)){
            $order->status = 7;
            $order->pin = 600000;
            $order->save();

            $log = new OrderLog();
            $log->order_id = $order->id;
            $log->user_id  = auth()->user()->id;
            $log->action   = 'Customer Rejected order.';
            $log->value    = 'Changed status to 7.';
            $log->save();
            return redirect('customer');
        }else{
            return redirect()->back()->withErrors(['error'=>'You have no rights to do this action !']);
        }
      }catch (Exception $e){
        Log::error($e->getMessage());
        return redirect('customer')->withErrors(['error' => 'You have no rights to do this action !']);
      }
    }
    public function complete($id){
      try {
        $order = Order::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();

        if ($order != null && in_array($order->status, [3, 4, 8])) {
          $order->status = 11;
          $order->pin = 600000;
          $order->save();

          $this->order_log($order->id, auth()->user()->id, 'Completed by Customer.', 'Changed status to Completed By Customer (11).');
          return redirect('customer/order/' . $id);
        } else {
          return redirect()->back()->withErrors(['error' => 'You have no rights to do this action !']);
        }
      }catch (Exception $e){
        Log::error($e->getMessage());
        return redirect('customer')->withErrors(['error' => 'You have no rights to do this action !']);
      }
    }
    public function order($id){
      try {
        $order = Order::where('id', $id)->where('user_id', auth()->user()->id)->first();
        return view('customer.details', compact('order'));
      }catch (Exception $e){
        Log::error($e->getMessage());
        return redirect('customer')->withErrors(['error' => 'You have no rights to do this action !']);
      }
    }
}
