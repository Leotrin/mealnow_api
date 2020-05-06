<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function shop(){
        return $this->belongsTo('App\Models\Shop','shop_id');
    }
    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function logs(){
        return $this->hasMany('App\Models\OrderLog');
    }

    public function adjustment(){
      return $this->hasOne('App\Models\Adjustments', 'order_id');
    }

  public function assigned_user(){
    return $this->belongsTo('App\Models\User','assigned_user_id');
  }
}
