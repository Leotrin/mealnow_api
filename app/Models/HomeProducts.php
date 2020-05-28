<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeProducts extends Model
{
    public function shop(){
        return $this->belongsTo(Shop::class,'shop_id');
    }
}
