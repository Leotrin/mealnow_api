<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    public function group(){
        return $this->belongsTo('App\Models\Groups');
    }
}
