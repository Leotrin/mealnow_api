<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTickets extends Model
{
    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function to_user(){
        return $this->belongsTo('App\Models\User','to_user_id');
    }
}
