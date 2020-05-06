<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adjustments extends Model
{
    //
  public function order(){
    return $this->belongsTo('App\Models\Order', 'order_id');
  }
}
