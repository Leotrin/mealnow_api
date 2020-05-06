<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMethod extends Model
{
    public function shop(){
        return $this->belongsTo('App\Models\Shop', 'shop_id');
    }
}
