<?php

namespace App\Models;

//use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'username' , 'name' , 'email' , 'password' , 'gender' ,
        'birthday' , 'city' , 'address' , 'zip' , 'tel' , 'profile_picture' , 'group_id' , 'status'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function group(){
        return $this->belongsTo('App\Models\Groups');
    }
    public function shop(){
        return $this->hasOne('App\Models\Shop','user_id');
    }
    public function orders(){
        return $this->hasMany('App\Models\Order','user_id');
    }
}
