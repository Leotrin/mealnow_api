<?php

namespace App\Http\Controllers\ApiV1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
   
    public function __construct(){
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials: true");
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
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

//    public function login(){
//        auth()->attempt(['email'=>request('email'),'password'=>request('password'), 'status' => 1]);
//        if(auth()->check()){
//            if(auth()->check() != null){
//                $u = User::find(auth()->user()->id);
//                $u->token = md5(uniqid());
//                $u->save();
//            }
//            return $this->returnData(true,null, $u);
//        }else{
//            return $this->returnData(false, 'Credentials are not valid.',request()->all());
//        }
//    }
}
