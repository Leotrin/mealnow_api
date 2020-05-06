<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdjustmentsController extends Controller
{
    //

  public function adjustment($id)
  {

    if(\request()->isMethod('post')) {
      $order = Order::find($id);
      $app = app();
      $billing = $app->make('App\Acme\Billing\BillingInterface');
      $b = $billing->charge([
        'amount' => $order->adjustment->amount,
        'description' => 'Order ' . $order->id . ' Adjustment',
        'token' => request('stripeToken')
      ]);
      $transaction = new Transaction();
      $transaction->trans_id = $b->id;
      $transaction->trans_data = json_encode($b);
      $transaction->save();

      if ($b->status == 'succeeded' && $b->paid = true) {
        $order->adjustment->status = 1;
        $order->status = 3;
        $order->save();
        $order->adjustment->save();


        $log = new OrderLog();
        $log->order_id = $order->id;
        $log->user_id = auth()->user()->id;
        $log->action = 'Adjustment Paid';
        $log->value = 'Changed Adjustment status to paid';
        $log->save();
        $log = new OrderLog();
        $log->order_id = $order->id;
        $log->user_id = auth()->user()->id;
        $log->action = 'Order Auto Confirmed';
        $log->value = 'Change order status adjustment => confirmed';
        $log->save();

        return redirect('customer/order/'.$id);
      }else{
        return redirect('customer/order/'.$id)->withErrors('error', 'payment unsucesfull');
      }
    }
  }
}
