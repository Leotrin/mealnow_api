<?php
/*
 * CustomDesignHelper
 * Helper to be used for generating printable value
 */
namespace App\Library;
use Faker\Provider\DateTime;
use File;
use function GuzzleHttp\Psr7\str;

class CustomDesignHelper
{
    static function status($status){
        if($status==1){ return 'Active'; }
        if($status==0){ return 'Inactive'; }
        if($status==3){ return 'Finished'; }
        return 'Undefined';
    }

    static function statusTicket($status){
        if($status==2){ return '<span class="label label-success">Completed</span>'; }
        if($status==1){ return '<span class="label label-info">Answered</span>'; }
        if($status==0){ return '<span class="label label-danger">Unanswered</span>'; }
        return 'Undefined';
    }

    static function orderStatus($status){
        if($status==0){ return '<span class="label label-warning">NEW</span>'; }
        if($status==1){ return '<span class="label label-info">UNCONFIRMED</span>'; }
        if($status==2){ return '<span class="label label-danger">ADMIN REJECTED</span>'; }
        if($status==3){ return '<span class="label label-success">SHOP CONFIRMED</span>'; }
        if($status==4){ return '<span class="label label-primary">PHONE CALL CONFIRMED</span>'; }
        if($status==5){ return '<span class="label label-danger">SHOP REJECTED</span>'; }
        if($status==6){ return '<span class="label label-info">ADJUSTMENTS</span>'; }
        if($status==7){ return '<span class="label label-danger">CUSTOMER REJECTED</span>'; }
        if($status==8){ return '<span class="label label-info">IN PROCESS</span>'; }
        if($status==9){ return '<span class="label label-success">COMPLETED</span>'; }
        if($status==10){ return '<span class="label label-danger">NOT PROCESSED</span>'; }
        if($status==11){ return '<span class="label label-success">CUSTOMER COMPLETED</span>'; }
        return 'Undefined';
    }
    static function orderStatusSPAN($status, $datetime){
      $d1 = new \DateTime(date('Y-m-d'));
      $d2 = new \DateTime(date('Y-m-d', strtotime($datetime)));
      $t1 = new \DateTime(date("H:i"));
      $t2 = new \DateTime(date("H:i", strtotime($datetime)));

      $t_diff= $t1->diff($t2);
      if($status == 0){
        if($d2 > $d1){
          return '<span class="label label-future myTippy" title="Please confirm future order" style="border:2px solid green;">'.$datetime.'</span>';
        }elseif($d1 == $d2){
          if($t_diff->format('%r%h') == 0 && $t_diff->format('%r%i') <= 0){
            if($t_diff->format('%r%i') >= -5) {
              return '<span class="label myTippy" title="les than 5" style="border:2px solid green;">' . $datetime . '</span>';
            }elseif($t_diff->format('%r%i') < -5 && $t_diff->format('%r%i') > -10) {
              return '<span class="label label-yellow myTippy" title="more than 5" style="border:2px solid yellow;">'.$datetime.'</span>';
            }else{
              return '<span class="label label-danger myTippy" title="more than 10 min" >'.$datetime.'</span>';
            }
          }elseif($t_diff->format('%r%h') == 0 && $t_diff->format('%r%i') > 0){
            return '<span class="label myTippy" title="Today at '.date('H:i', strtotime($datetime)).'" >'.$datetime.'</span>';
          }elseif($t_diff->format('%r%h') < 0){
            return '<span class="label label-danger myTippy" title="may be to late" >'.$datetime.'</span>';
          }
        }else{
          return '<span class="label label-danger myTippy" title="may be to late" >'.$datetime.'</span>';
        }
      }
      elseif(in_array($status, [3,4,8]) && $d1 == $d2){
        if((int)$t_diff->format('%r%h') > 0 ){
          return '<span class="label myTippy" title="Today at '.date('H:i', strtotime($datetime)).'" style="border:2px solid green;">'.$datetime.'</span>';
        }elseif((int)abs($t_diff->format('%r%h')) == 0){
          if((int)$t_diff->format('%r%i') <= 0 && (int)$t_diff->format('%r%i') >= -5) {
            return '<span class="label  myTippy" title="Process ASAP" style="border:2px solid green;">' . $datetime . '</span>';
          }elseif((int)$t_diff->format('%r%i') <= -6 && (int)$t_diff->format('%r%i') >= -10) {
            return '<span class="label  myTippy" title="more than 5" style="border:2px solid yellow;">' . $datetime . '</span>';
          }elseif((int)$t_diff->format('%r%i') < -10 ) {
            return '<span class="label label-danger myTippy" title="more than 10" >' . $datetime . '</span>';
          }elseif((int)$t_diff->format('%r%i') > 0){
            return '<span class="label label myTippy" title="Soon">' . $datetime . '</span>';
          }
        }else{
          return '<span class="label label-danger myTippy" title="Please Complete" >' . $datetime . '</span>';
        }
      }elseif($status == 6){
        return '<span class="label label-info myTippy" title="Under Adjustment" >' . $datetime . '</span>';
      }
    }

    static function orderStatusAdminSPAN($status, $datetime){
    $d1 = new \DateTime(date('Y-m-d'));
    $d2 = new \DateTime(date('Y-m-d', strtotime($datetime)));
    $t1 = new \DateTime(date("H:i"));
    $t2 = new \DateTime(date("H:i", strtotime($datetime)));
    $d_diff = $d1->diff($d2);
    $class = ''; $title='';$style='';

    $t_diff= $t1->diff($t2);
    if($status == 0){
      if($d2 > $d1){
        return '<span class="label label-future myTippy" title="Please Process future order" style="border:2px solid green;">'.$datetime.'</span>';
      }elseif($d1 == $d2){
        if($t_diff->format('%r%h') <= 0 && $t_diff->format('%r%i') <= 0){
          if($t_diff->format('%r%h') < 0){
            return '<span class="label label-danger myTippy" title="more than 10 min" style="">'.$datetime.'</span>';
          }else{
            if($t_diff->format('%r%i') >= -5) {
              return '<span class="label myTippy" title="les than 5" style="border:2px solid green;">' . $datetime . '</span>';
            }elseif($t_diff->format('%r%i') < -5 && $t_diff->format('%r%i') > -10) {
              return '<span class="label label-yellow myTippy" title="more than 5" style="border:2px solid yellow;">'.$datetime.'</span>';
            }else{
              return '<span class="label label-danger myTippy" title="more than 10 min" style="">'.$datetime.'</span>';
            }
          }
        }

      }else{
        return '<span class="label label-danger myTippy" title="may be to late" style="">'.$datetime.'</span>';
      }
    }elseif($status == 6){
      return '<span class="label label-info myTippy" title="Under Adjustment. Please check Order" >'.$datetime.'</span>';
    }
//    elseif(in_array($status, [3,4,8]) && $d1 == $d2){
//      if((int)$t_diff->format('%r%h') > 0 ){
//        $class = '';
//        $title = 'Today at '.date('H:i', strtotime($datetime));
//        $style='border:2px solid green;';
//        return '<span class="'.$class.'" title="'.$title.'" style="'.$style.'">'.$datetime.'</span>';
//      }elseif((int)abs($t_diff->format('%r%h')) == 0){
//        if((int)$t_diff->format('%r%i') <= 0 && (int)$t_diff->format('%r%i') >= -5) {
//          $class = 'label  myTippy';
//          $title = 'Process ASAP';
//          $style = 'border:2px solid green;';
//          return '<span class="' . $class . '" title="' . $title . '" style="' . $style . '">' . $datetime . '</span>';
//        }elseif((int)$t_diff->format('%r%i') <= -6 && (int)$t_diff->format('%r%i') >= -10) {
//          $class = 'label  myTippy';
//          $title = 'more than 5';
//          $style = 'border:2px solid yellow;';
//          return '<span class="' . $class . '" title="' . $title . '" style="' . $style . '">' . $datetime . '</span>';
//        }elseif((int)$t_diff->format('%r%i') < -10 ) {
//          $class = 'label label-danger myTippy';
//          $title = 'more than 10';
//          return '<span class="' . $class . '" title="' . $title . '" style="' . $style . '">' . $datetime . '</span>';
//        }elseif((int)$t_diff->format('%r%i') > 0){
//          $class = 'label label myTippy';
//          $title = 'Soon ';
//          return '<span class="' . $class . '" title="' . $title . '" style="' . $style . '">' . $datetime . '</span>';
//        }
//      }else{
//        $class = 'label label-danger myTippy';
//        $title = 'Please Complete';
//        return '<span class="' . $class . '" title="' . $title . '" style="' . $style . '">' . $datetime . '</span>';
//      }
//    }
  }
    static function gender($gender){
        if($gender==1){ return 'Male'; }
        if($gender==2){ return 'Female'; }
        return 'Undefined';
    }
    static function perm($perm){
        if($perm==1){ return 'Allowed'; }
        if($perm==0){ return 'Denied'; }
        return 'Undefined';
    }

    static function checkPermission($function){
        if(auth()->check()){
            $permissions = auth()->user()->group;
            if(isset($permissions->roles) && count($permissions->roles)>0) {
                foreach ($permissions->roles as $p) {
                    if ($p->function == $function && $p->permission == 1) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
    static function checkPath($path){
        if (!file_exists($path)) {
            mkdir($path,0755, true);
        }
        return true;
    }

    static function generatePassword()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $randstring = '';
        for ($i = 0; $i < 6; $i++) {
            $randstring .= $characters[rand(0, strlen($characters))];
        }
        return $randstring;
    }
    static function processDate($status, $type, $datetime){

      $d1 = new \DateTime(date('Y-m-d'));
      $d2 = new \DateTime(date('Y-m-d', strtotime($datetime)));
      $t1 = new \DateTime(date("H:i"));
      $t2 = new \DateTime(date("H:i", strtotime($datetime)));
      $d_diff = $d1->diff($d2);
      $t_diff= $t1->diff($t2);
      //return $d1->diff($d2)->d;

      if( (int)$d_diff->format('%r%d') > 0) {
        return 'In Upcoming Days';
      }
      if((int)$d_diff->format('%r%d') == 0) {
        if (in_array($status, [3, 4, 8])) {
          if ((int)$t_diff->format('%r%h') == 0 && (int)$t_diff->format('%r%i') > 0) {
            if ($type == 'delivery') {
              return 'Delivery after '.(int)$t_diff->format('%r%i').' min';
            } else {
              return 'Pickup in '.(int)$t_diff->format('%r%i').' min';
            }
          }else if((int)$t_diff->format('%r%i') < 0) {
            return 'Please Complete';
          }else{
            return 'Today at ' . date('H:i', strtotime($datetime));
          }
        }elseif($status == 0){
          return 'Please Confirm';
        }elseif($status == 6){
          return 'Under Adjustment';
        }
      }else{
        return 'Past Order. Please Complete';
      }
    }
}