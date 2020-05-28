<?php

namespace App\Http\Controllers;

use App\Models\HomeProducts;
use App\Models\Shop;
use Session;

class HomeController extends Controller
{
    public function __construct()
    {
        //Checks for active logged in users only for index function
        $this->middleware('auth',['only'=>['home']]);
    }
    public function index()
    {
        return view('welcome');
    }
    public function home(){
        if(auth()->user()->group_id==7){
            return redirect('/shop');
        }elseif(auth()->user()->group_id==4){
            return redirect('/customer');
        }else{
            return redirect('/admin');
        }
    }
    public function notAllowed(){

        return view('errors.not-allowed');
    }
    public function frontend()
    {
        $products = HomeProducts::where('status',1)->get();
        $shops = Shop::inRandomOrder()->limit(6)->get();
        $service = 'pickup';
        if(session('service')!='pickup'){
            $service = session('service');
        }
        //dd($shops);
        return view('frontend.dashboard',compact('service','products','shops'));
    }
    public function about(){
        return view('frontend.about');
    }
    public function contact(){
        return view('frontend.contact');
    }
    public function joinNow(){
        return view('frontend.joinNow');
    }
}
