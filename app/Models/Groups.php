<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    public function roles(){
        return $this->hasMany('App\Models\Roles');
    }
    public function users(){
        return $this->hasMany('App\Models\User', 'group_id');
    }
}
