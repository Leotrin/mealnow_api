<?php

namespace App\Http\Controllers\ApiV1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserCallController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeUsers= User::where('status','1')->get();
        $inactiveUsers= User::where('status','0')->get();
        $users = ["activeUser" => $activeUsers,'inactive_user' =>$inactiveUsers];
        return $this->returnData(true,'All Users',$users);
    }
    public function activeUsers()
    {
        $activeUsers= User::where('status','1')->get();
        return $this->returnData(true,'Active Users',$activeUsers);
    }
    public function inactiveUsers()
    {
        $inactiveUsers= User::where('status','0')->get();
        return $this->returnData(true,'Inactive Users',$inactiveUsers);
    }
    public function deleteUser(){
        $delete = User::where('id',request('id'))->delete();
        $users = User::all();
        return $this->returnData(true,'klient deleted',$users);
    }
    public function insertUser(){
      
       if (request('id')==0) {
           $user = new User; 
       }
       else {
           $user = User::find(request('id'));
           if ($user==null) {
               return $this->returnData(false,'user not foudn',null);
           }
       }
       $user->name = request('name');
       $user->username = request('username');
       $user->password = bcrypt(request('password'));
       $user->email = request('email');
       $user->gender = request('gender');
       $user->birthday = date("Y-m-d", strtotime(request('birthday')));
       $user->city = request('city');
       $user->address = request('address');
       $user->zip = request('zip');
       $user->tel = request('tel');
       $user->group_id = request('group_id');
       
       
        $user->save();
        return $this->returnData(true,'klient created',$user);
    }
    public function updatePassword(){
        $user = User::find(request('id'));
        $new_pw = request('new_password');
        $conf_pw = request('confirm_password');
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials)) {
            return $this->returnData(false, 'You entered a wrong password.', null);
        }
        if ($new_pw == $conf_pw) {
            $user->password= bcrypt(request('new_password'));
            $user->save();
            return $this->returnData(true,'Password changed',null);
        } else {
            return $this->returnData(false, 'Please confirm your new password.', null);
        }

    }
    public function setAddress(){
        $user = User::find(request('id'));
        $addressData = request('addressData');
        $user->city = $addressData['city'];
        $user->zip = $addressData['zipCode'];
        $user->address = $addressData['streetName'];
        $user->tel = $addressData['mobileNumber'];
        $user->save();
        return $this->returnData(true,'Address changed',$addressData);
    }
    public function getUserWithOrders(){
        $userX = auth()->guard('api')->user();
        $user = User::where('id',$userX->id)->with('orders')->first();
        return $this->returnData(true,null ,$user );
    }

   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = User::where('id',request('id'))->first();
        $user->status=9;
        $user->save();
        
        return $this->returnData(true,'User Deleted',$user);
    }
    public function deactivateUser()
    {
       $user = User::where('id',request('id'))
        ->update(['status'=>'0']);
        
        return $this->returnData(true,'User Deactivated',$user);
    }
}
