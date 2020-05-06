<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    public function menu(){
        return $this->hasOne('App\Models\Menu','client_id');
    }
    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function sale(){
        return $this->belongsTo('App\Models\User','sales_id');
    }
    public function representative(){
        return $this->belongsTo('App\Models\User','representative_id');
    }
    public function contact_methods(){
        return $this->hasMany('App\Models\ContactMethod')->orderBy('priority','asc');
    }
    public function moreInfo(){
        return $this->hasOne('App\Models\AdditionalInfo','shop_id');
    }

    public function isShopWorking(){
      //process working time
      $today = strtolower(date('l'));
      $now = strtotime('now');
      $this->attributes['isOpen'] = false;
      $wh = json_decode($this->working_hours, true);
      if(isset($wh[$today])){
        if($now > strtotime($wh[$today]['hours_from'])  && $now < strtotime($wh[$today]['hours_to'])){
          $this->attributes['isOpen'] = true;
          $this->attributes['openTill'] = $wh[$today]['hours_to'];
        }
      }

      if(!$this->attributes['isOpen']){
        $this->attributes['isOpen'] = false;
        $this->attributes['nextOpen'] = 'test';
        $todayDate = date('d-m-Y');
        $notFound = true;
        $i=0;
        while($i <= 7 && $notFound){
          if( isset($wh[strtolower(date('l', strtotime($todayDate. '+'.$i.' days')))]) ){
            $notFound = false;
            $this->attributes['nextOpen'] = [
              'day'=>date('d-m-Y', strtotime($todayDate. ' +'.$i.' days')),
              'start'=> $wh[strtolower(date('l', strtotime($todayDate. '+'.$i.' days')))]['hours_from']
            ];
          }
          $i++;
        }
      }
      return $this;
    }
}
