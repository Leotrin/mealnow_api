<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdjustmentController extends Controller
{
    //

  public function adjustment()
  {
    dd(\request()->all());
//    $app = app();
//    $billing = $app->make('App\Acme\Billing\BillingInterface');
//    $b = $billing->charge([
//      'amount' => 20,
//      'description' => 'new order',
//      'token' => request('stripeToken')
//    ]);
//    $transaction = new Transaction();
//    $transaction->trans_id = $b->id;
//    $transaction->trans_data = json_encode($b);
//    $transaction->save();
//
//    if ($b->status == 'succeeded' && $b->paid = true) {
//
//    }
  }
}
