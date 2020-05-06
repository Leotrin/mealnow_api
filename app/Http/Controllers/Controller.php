<?php

namespace App\Http\Controllers;

use App\Models\OrderLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Logs;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function log($function,$id,$query=null,$action=null,$old_data=null,$new_data=null){
        $log = new Logs();
        $log->user_id = Auth::user()->id;
        $log->other_id  = $id;
        $log->function = $function;
        $log->query_sql = $query;
        $log->action = $action;
        $log->old_data = $old_data;
        $log->new_data = $new_data;
        $log->save();
    }

    public function exception_happened(){

    }

    public function order_log($order_id, $user_id, $action, $value){
      $log = new OrderLog();
      $log->order_id = $order_id;
      $log->user_id  = $user_id;
      $log->action   = $action;
      $log->value    = $value;
      $log->save();
  }
  
  public function returnData($status, $message, $values, $errors=null,$error=200,$action=null){
    return response()->json([
        'status'    =>$status,
        'message'   =>$message,
        'values'    =>$values,
        'errors'    =>$errors,
        'error'     =>$error,
        'action'    =>$action
    ]);
}
}
