<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContactMethod;
use App\Models\Menu;
use App\Models\Shop;
use App\Library\CustomDesignHelper as CD;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }
    public function new_list(){
        $shops = Shop::all();
        $users = User::where('group_id',7)->pluck('name','id');
        if(request()->isMethod('post')){
            $this->rules(request()->all());
            $rest = new Shop();
            $this->registration($rest);
            return redirect('admin/shops');
        }

        $times = array(
            '0 - 15'  => '0 - 15 min',
            '15 - 30' => '15 - 30 min',
            '30 - 45' => '30 - 45 min',
            '45 - 60' => '45 - 60 min'
        );
        return view('new_backend.shop.list',compact('shops', 'times','users'));
    }
    public function edit_shop($id){
        $shops = Shop::all();
        $shop = Shop::find($id);
        $users = User::where('group_id',7)->pluck('name','id');


        if(request()->isMethod('post')){
            $this->rules(request()->all());
            $this->registration($shop);
            return redirect('admin/shops');
        }


        $times = array(
            '0 - 15'  => '0 - 15 min',
            '15 - 30' => '15 - 30 min',
            '30 - 45' => '30 - 45 min',
            '45 - 60' => '45 - 60 min'
        );
        return view('new_backend.shop.list',compact('shops', 'shop', 'times','users'));
    }
    public function rules($request){
        $validation = Validator::make($request, [
            'name' => 'required',
            'description' => 'required',
            'city' => 'required',
            'search_city'       => 'required',
            'address' => 'required',
            'lat_long' => 'required',
            'tel' => 'required',
            'fax' => 'required',
            'email' => 'required',
            'delivery_time' => 'required',
            'delivery_price' => 'required',
            'min_price_order' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validation->fails()){
            return back()->withInput()->withErrors($validation);
        }
    }
    public function registration($rest){
        $lat_long = str_replace('(','',request('lat_long'));
        $lat_long = str_replace(')','',$lat_long);
        $lat_long = str_replace(' ','',$lat_long);
        $rest->name             = request('name');
        $rest->description      = request('description');
        $rest->city             = request('city');
        $rest->search_city      = request('search_city');
        $rest->address          = request('address');
        $rest->lat_long         = $lat_long;
        $rest->delivery_time    = request('delivery_time');
        $rest->delivery_price   = request('delivery_price');
        $rest->min_price_order  = request('min_price_order');
        $rest->tel              = request('tel');
        $rest->fax              = request('fax');
        $rest->email            = request('email');
        $rest->user_id          = request('user_id');
        $rest->representative_id= request('representative_id');
        $rest->sales_id         = request('sales_id');
        $rest->register_id      = auth()->user()->id;
        $rest->save();

        $path = base_path().'/public/images/shops/'.$rest->id;
        CD::checkPath($path);
        $file = request()->file('logo');
        if($file!=null) {
            $filename = 'shop_' . $file->getClientOriginalName();
            $upload_success = $file->move($path, $filename);
            if ($upload_success) {
                $rest->logo = $filename;
                $rest->save();
            }
        }
    }

    public function shop_menu($id){
        if(!CD::checkPermission('MenuManagement')){
            return redirect(route('admin'));
        }
        $shop = Shop::find($id);
        $ourShops = Shop::all();
        return view('new_backend.shop.menu.create',compact('shop','ourShops'));
    }
    public function shop_menu_clone($id){
        if(!CD::checkPermission('MenuManagement')){
            return redirect(route('admin'));
        }
        $cloneFrom = Menu::where('client_id',request('clone_from_shop'))->first();
        if($cloneFrom!=null){
            $menu = Menu::where('client_id',$id)->first();
            if($menu==null){
                $menu = new Menu();
                $menu->client_id        = $id;
                $menu->menu             = $cloneFrom->menu;
                $menu->categories       = $cloneFrom->categories;
                $menu->products         = $cloneFrom->products;
                $menu->element_ids      = $cloneFrom->element_ids;
                $menu->element_count    = $cloneFrom->element_count;
                $menu->status           = $cloneFrom->status;
                $menu->save();
                return redirect('admin/shop/'.$id.'/menu/create');
            }
        }
        return redirect('admin/shop/'.$id.'/menu/create');

        return view('backend.shop.menu.create',compact('shop','ourShops'));
    }
    public function shop_menu_save($id){
        dd(request()->all());
        //dd(request('menuJson'));
        $shop = Shop::find($id);
        if(isset($shop->menu) && $shop->menu !=null){
            $menu = Menu::where('client_id',$id)->first();
        }else{
            $menu = new Menu();
            $menu->client_id    = request('shop_id');
        }

        $menu_json = $this->sortMenu(request('menuJson'));

        $menu->menu         = $menu_json;
        $menu->categories   = request('categoriesJson');
        $menu->products     = request('productsJson');
        $menu->element_ids  = request('element_ids');
        $menu->element_count= request('element_count');
        $menu->save();
        return redirect('admin/shop/'.$id.'/menu/create');
    }

    public function sortMenu($menu){
      $menu_before_sort = json_decode($menu, true);

      //remove null elements since they leed to errors
      $menu_before_sort['items'] =   array_filter($menu_before_sort['items']);

      //dd($menu_before_sort);
      $menu_before_sort['items'] = $this->sortItems($menu_before_sort['items']);
      for($i=0; $i<count($menu_before_sort['items']);$i++){
        if($menu_before_sort['items'][$i] != null && count($menu_before_sort['items'][$i])>0){
            $menu_before_sort['items'][$i]['products'] =   array_filter($menu_before_sort['items'][$i]['products']);
            $menu_before_sort['items'][$i]['products'] = $this->sortItems($menu_before_sort['items'][$i]['products']);

            for ($j=0; $j<count($menu_before_sort['items'][$i]['products']); $j++){
                if($menu_before_sort['items'][$i]['products'][$j]['topings'] != null && count($menu_before_sort['items'][$i]['products'][$j]['topings']['options'])>0) {
                    $menu_before_sort['items'][$i]['products'][$j]['topings']['options'] = array_filter($menu_before_sort['items'][$i]['products'][$j]['topings']['options']);
                    $menu_before_sort['items'][$i]['products'][$j]['topings']['options'] = $this->sortItems($menu_before_sort['items'][$i]['products'][$j]['topings']['options']);
                }
                if($menu_before_sort['items'][$i]['products'][$j]['properties']!=null && count($menu_before_sort['items'][$i]['products'][$j]['properties'])>0) {
                    $menu_before_sort['items'][$i]['products'][$j]['properties'] = array_filter($menu_before_sort['items'][$i]['products'][$j]['properties']);
                    $menu_before_sort['items'][$i]['products'][$j]['properties'] = $this->sortItems($menu_before_sort['items'][$i]['products'][$j]['properties']);

                    for ($k=0; $k<count($menu_before_sort['items'][$i]['products'][$j]['properties']); $k++){
                        if($menu_before_sort['items'][$i]['products'][$j]['properties'][$k]['options']!=null){
                          $menu_before_sort['items'][$i]['products'][$j]['properties'][$k]['options'] = $this->sortItems($menu_before_sort['items'][$i]['products'][$j]['properties'][$k]['options']);
                        }
                    }
                }
            }

        }
      }
      //dd($menu_before_sort);
      return json_encode($menu_before_sort);
    }
    public function sortItems($items){
        if($items !=null ) {
            usort($items, function ($a, $b) {
                if($a!=null && $b != null) {
                    return $a['order'] >= $b['order'];
                }
            });
        }
      return $items;
    }
    public function contact_methods($id){
        if(request()->isMethod('post')){
            $contactMethod = new ContactMethod();
            $contactMethod->shop_id = $id;
            $contactMethod->method  = request('method');
            $contactMethod->contact = request('contact');
            $contactMethod->priority= request('priority');
            $contactMethod->save();
            return redirect('admin/shop/'.$id.'/contact_methods');
        }
        $shop = Shop::find($id);
        return view('new_backend.shop.contact.list',compact('shop'));
    }
    public function contact_methods_edit($id, $cm_id){
        $contact_method = ContactMethod::find($cm_id);
        if(request()->isMethod('post') && $contact_method!=null){
            $contact_method->method  = request('method');
            $contact_method->contact = request('contact');
            $contact_method->priority= request('priority');
            $contact_method->save();
            return redirect('admin/shop/'.$id.'/contact_methods');
        }
        $shop = Shop::find($id);
        return view('new_backend.shop.contact.list',compact('shop','contact_method'));
    }
    public function contact_methods_delete($id, $cm_id){
        $contact_method = ContactMethod::find($cm_id);
        $contact_method->delete();
        return redirect('admin/shop/'.$id.'/contact_methods');
    }
    public function availability($id){

        $shop = Shop::find($id);

        $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
        $availability = [];
        foreach($days as $day){
            if(request($day)!=null) {
                $availability[$day] = [
                    'hours_from' => request($day . '_hours_from'),
                    'hours_to' => request($day . '_hours_to')
                ];
            }
        }
        $shop->working_hours = json_encode($availability);
        $shop->save();
        return redirect('admin/shops');
    }

    public function media_upload(){

    }
}
