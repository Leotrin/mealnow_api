<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function shop(){
        return $this->belongsTo('App\Models\Shop','client_id');
    }
}
