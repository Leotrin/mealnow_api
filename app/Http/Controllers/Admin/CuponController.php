<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cupon;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CuponController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }
    public function cupons(){
        if(request()->isMethod('post')){
            $validation = Validator::make(request()->all(), [
                'sum' => 'required|numeric',
                'type' => 'required',
                'key' => 'required|alpha_num',
                'limit' => 'required|numeric',
            ]);

            if($validation->fails()){
                return back()->withInput()->withErrors($validation);
            }
            $cupon = new Cupon();
            $cupon->sum     = request('sum');
            $cupon->type    = request('type');
            $cupon->key     = request('key');
            $cupon->limit   = request('limit');
            $cupon->save();
            $this->log('Cupon',$cupon->id,'Insert new cupon', 'INSERT', null, json_encode($cupon));
            return redirect('admin/cupons');
        }
        $cupons = Cupon::all();
        return view('new_backend.cupons.list',compact('cupons'));
    }
    public function delete_cupons($id){
        $cupon = Cupon::find($id);
        $cupon->delete();
        $this->log('Cupon',$cupon->id,'Delete cupon', 'DELETE', json_encode($cupon), null);
        return redirect('admin/cupons');
    }
}
