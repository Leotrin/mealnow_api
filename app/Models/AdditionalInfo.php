<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionalInfo extends Model
{
    public function shop(){
        return $this->belongsTo('App\Models\Shop', 'shop_id');
    }
    public function manager(){
        return $this->belongsTo('App\Models\User', 'manager');
    }
    public function menu_representativ(){
        return $this->belongsTo('App\Models\User', 'menu_representativ');
    }
}
