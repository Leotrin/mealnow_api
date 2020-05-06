<?php

namespace App\Http\Controllers;
use App\Mail\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
//        $six_digit_random_number = mt_rand(100000, 999999);
        $user = new User();
        $user->name = request('name');
        $user->email = request('email');
        $user->password = bcrypt(request('password'));
        $user->city = request('city');
        $user->zip = request('zipCode');
        $user->address = request('streetName');
        $user->tel = request('mobileNumber');
//        $user->code = $six_digit_random_number;
//        $user->save();
//        Mail::to($user->email)->send(new EmailVerification($six_digit_random_number));
        return $this->returnData(true, 'Account Created', $user->id);
    }

    public function login(Request $request)
    {
        return 'test';
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ]);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ]);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function getUserWithOrders(){
        $userX = auth()->guard('api')->user();
        $user = User::where('id',$userX->id)->with('orders')->first();
        return $this->returnData(true,'User orders' ,$user );
    }
    public function verifyCode(){
        $user = User::find(\request('id'));
        $user_code = $user->verification_code;
        $code_from_webiste = request('code');
            if ($user_code === $code_from_webiste){
                $user->verified =1;
                $user->save();
            }else{
                return $this->returnData(false,'Code doesnt match',null);
            }
        return $this->returnData(true,'Code Verified Successfully',$user);
    }

    public function reSendCode() {
        $code = mt_rand(100000, 999999);
        $user = User::find(\request('id'));
        $user->verification_code = $code;
        $user->save();
        Mail::to($user->email)->send(new EmailVerification($code));
        if (Mail::failures()){
            return $this->returnData(false,'Sending email occured error',null);
        }
        return $this->returnData(true,'Action performed succesfully',$user);
    }
}
