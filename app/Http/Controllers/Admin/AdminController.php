<?php

namespace App\Http\Controllers\Admin;

use App\Library\CustomDesignHelper as CD;
use App\Models\HomeProducts;
use App\Models\Order;
use App\Models\Shop;
use App\Models\User;
use App\Models\Groups;
use App\Models\Roles;
use App\Models\Permissions;
use App\Models\SupportTickets;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }
    public function home_products(){

        if(request()->isMethod('post')){
            request()->validate([
                'shop_id'=>'required',
                'image'=>'required',
                'name'=>'required',
                'price'=>'required',
            ]);

            $prod = new HomeProducts();
            $prod->shop_id = request('shop_id');
            $prod->name = request('name');
            $prod->price = request('price');
            $prod->image = url('/images/noImg.png');
            $prod->save();
            $path = base_path().'/public/images/home/'.$prod->id;
            CD::checkPath($path);
            $file = request()->file('image');
            if($file!=null) {
                $filename = 'home_' . $file->getClientOriginalName();
                $upload_success = $file->move($path, $filename);
                if ($upload_success) {
                    $prod->image = url('/images/home/'.$prod->id.'/'.$filename);
                    $prod->save();
                }
            }
            return redirect('/admin/home/products');
        }
        $products = HomeProducts::where('status','<',2)->paginate(30);
        $shops = Shop::where('status',1)->get();
        return view('new_backend.home.products',compact('products','shops'));
    }
    public function home_products_activate($id){
        $product = HomeProducts::findOrFail($id);
        $product->status = 1;
        $product->save();
        return redirect('/admin/home/products');
    }
    public function home_products_deactivate($id){
        $product = HomeProducts::findOrFail($id);
        $product->status = 0;
        $product->save();
        return redirect('/admin/home/products');
    }
    public function home_products_delete($id){
        $product = HomeProducts::findOrFail($id);
        $product->status = 2;
        $product->save();
        return redirect('/admin/home/products');
    }
    public function index(){
        if(auth()->user()->group_id==4){
            return redirect('customer');
        }
        if(auth()->user()->group_id==7){
            return redirect('shop');
        }
        if(auth()->user()->group_id == 2){
            return redirect('admin/shops');
        }
        $tickets = SupportTickets::where('parent',0)->whereHas('user', function($query){
            $query->where('to_user_id', auth()->user()->id);
            $query->orWhere('to_user_id',0);
            $query->orWhere('user_id',auth()->user()->id);
        })->where('status',0)->get();

        $latestOrders = Order::where('status','!=',2)
            ->where('status','!=',5)
            ->where('status','!=',7)
            ->where('status','!=',9)
            ->where('status','!=',10)
            ->where('status','!=',11)
            ->limit(15)
            ->orderByDesc('created_at')->get();
        $unprocessedOrder = Order::where('status',0)->orWhere('status',1)->count();
        $inprocessOrder = Order::where('status',3)->orWhere('status',4)->orWhere('status',6)->orWhere('status',8)->count();
        $finished = Order::where('status',9)->orWhere('status',11)->count();
        $notFinished = Order::where('status',2)->orWhere('status',7)->orWhere('status',10)->count();

        return view('new_backend.admin.home',compact('tickets','latestOrders','unprocessedOrder','inprocessOrder','finished','notFinished'));
    }
    public function users(){

        if (request()->isMethod('post')) {
            $validation = Validator::make(request()->all(), [
                'name' => 'required',
                'username' => 'required|unique:users,username',
                'email' => 'required|unique:users,email',
                'password' => 'required',
                'gender' => 'required',
            ]);

            if($validation->fails()){
                return back()->withInput()->withErrors($validation);
            }


            $user = new User();
            $user->name     = request('name');
            $user->username = request('username');
            $user->password = bcrypt(request('password'));
            $user->email    = request('email');
            $user->gender   = request('gender');
            $user->birthday = request('birthday');
            $user->city     = request('city');
            $user->address  = request('address');
            $user->zip      = request('zip');
            $user->tel      = request('tel');
            $user->group_id = request('group_id');
            $user->status   = 1;
            $user->save();

            $this->log('User',$user->id,'New user register', 'INSERT', null, json_encode($user));
            return redirect('admin/users');
        }


        $users = User::where('status',1)->orderBy('id','desc')->get();
        $inActiveUsers = User::where('status',0)->orderBy('id','desc')->get();
        $groups = Groups::pluck('name', 'id');
        return view('new_backend.userManagement.user-list',compact('users','groups','inActiveUsers'));
    }
    function change_password($id){
        $validation = Validator::make(request()->all(), [
            'password' => 'required|confirmed|min:6',
        ]);
        if($validation->fails()){
            return back()->withInput()->withErrors($validation);
        }
        $user = User::find($id);
        $oldUser = $user;
        $user->password = bcrypt(request('password'));
        $user->save();
        $this->log('User',$user->id,'Change Password', 'UPDATE', json_encode($oldUser), json_encode($user));
        return redirect('admin/users');
    }
    public function edit_users($id){

        if (request()->isMethod('post')) {
            $user = User::find($id);
            if($user!=null){
                $oldUser = $user;
                $user->name     = request('name');
                $user->username = request('username');
                $user->email    = request('email');
                $user->gender   = request('gender');
                $user->birthday = request('birthday');
                $user->city     = request('city');
                $user->address  = request('address');
                $user->zip      = request('zip');
                $user->tel      = request('tel');
                $user->group_id = request('group_id');
                $user->status   = 1;
                $user->save();

                $this->log('User',$user->id,'Update user data', 'UPDATE', json_encode($oldUser), json_encode($user));
            }
        }


        $users = User::where('status',1)->orderBy('id','desc')->get();
        $inActiveUsers = User::where('status',0)->orderBy('id','desc')->get();
        $user = User::find($id);
        $groups = Groups::pluck('name', 'id');

        return view('new_backend.userManagement.user-list',compact('users','user','groups','inActiveUsers'));
    }
    public function delete_users($id){
        $user = User::find($id);
        $oldUser        = $user;
        $user->status   = 0;
        $user->save();
        $this->log('User',$user->id,'Update user status', 'UPDATE', json_encode($oldUser), json_encode($user));
        return redirect('admin/users');
    }
    public function activate_users($id){
        $user = User::find($id);
        $oldUser        = $user;
        $user->status   = 1;
        $user->save();
        $this->log('User',$user->id,'Update user status', 'UPDATE', json_encode($oldUser), json_encode($user));
        return redirect('admin/users');
    }
    public function group(){

        if (request()->isMethod('post')) {
            $group = Groups::where('name',request('name'))->first();
            if($group==null){
                $group = new Groups();
                $group->name    = request('name');
                $group->status  = 0;
                if(request('status')!=null){
                    $group->status  = 1;
                }
                $group->save();
                $this->log('Group',$group->id,'Register new group', 'INSERT', null, json_encode($group));
            }else{
                $group = Groups::where('name',request('name'))->first();
                $oldGroup = $group;
                $group->name    = request('name');
                $group->status  = 0;
                if(request('status')!=null){
                    $group->status  = 1;
                }
                $group->save();
                $this->log('Group',$group->id,'Update group', 'UPDATE', json_encode($oldGroup), json_encode($group));
            }
        }

        $groups = Groups::all();
        return view('new_backend.userManagement.groups',compact('groups'));
    }
    public function edit_group($id){

        if (request()->isMethod('post')) {
            $group = Groups::find($id);
            $oldGroup = $group;
            $group->name = request('name');
            $group->status = 0;
            if(request('status')!=null){
                $group->status = 1;
            }
            $group->save();
            $this->log('Group',$group->id,'Update group', 'UPDATE', json_encode($oldGroup), json_encode($group));
        }

        $groups = Groups::all();
        $group = Groups::find($id);
        return view('new_backend.userManagement.groups',compact('groups','group'));
    }
    public function delete_group($id){
        $group = Groups::find($id);
        $oldGroup = $group;
        if(count($group->users)<=0){
            $group->delete();
            $this->log('Group',$group->id,'Delete group', 'DELETE', json_encode($oldGroup),null);
        }
        return redirect('admin/user/groups');
    }
    public function group_permission($id){

        if (request()->isMethod('post')) {
            $role = Roles::where('function',request('function'))->where('groups_id',$id)->first();
            $oldRole = $role;
            if($role!=null){
                if(request('permission') != null){
                    $role->permission = 1;
                    $role->save();
                }else{
                    $role->permission = 0;
                    $role->save();
                }
                $this->log('Role',$role->id,'Assign permission to role', 'UPDATE', json_encode($oldRole), json_encode($role));
            }else{
                $role = new Roles();
                $role->groups_id = $id;
                $role->function = request('function');

                if(request('permission') != null){
                    $role->permission = 1;
                }else{
                    $role->permission = 0;
                }
                $role->save();
                $this->log('Role',$role->id,'Insert new permission to role', 'INSERT', null, json_encode($role));
            }

            return redirect('/admin/user/group/'.$id);
            //return redirect(route('update_group_permission'));
        }


        $group = Groups::find($id);
        $permissions = Permissions::all();
        $functions = array();
        foreach($permissions as $p){
            $functions[$p->function_name] = $p->function_name;
        }


        return view('new_backend.userManagement.group-permission',compact('group','permissions','functions'));
    }
    public function group_function(){

        if (request()->isMethod('post')) {
            $function = Permissions::where('function_name',request('function'))->first();
            if($function==null){
                $function = new Permissions();
                $function->function_name = request('function');
                $function->save();
                $this->log('Permission',$function->id,'Insert new permission', 'INSERT', null, json_encode($function));
            }
        }
        $permissions = Permissions::all();
        return view('new_backend.userManagement.group-function', compact('permissions'));
    }
    public function group_function_delete($id){
        $permissions = Permissions::find($id);
        $permissions->delete();
        $this->log('Permission',$permissions->id,'Delete permission', 'DELETE', null, json_encode($permissions));
        return redirect('/admin/user/groups/function');
    }
    public function assign_permissions(){

        $permissions = Permissions::all();
        $groups = Groups::all();
        if(request()->isMethod('post')){
            //dd(request()->all());

            foreach($groups as $gr):
                foreach($permissions as $permission):
                    $checked = request(str_replace(' ','_',$gr->name).'_'.str_replace(' ','_',$permission->function_name));
                    if($checked==null){
                        $checked = 0;
                    }
                    $role = Roles::where('groups_id',$gr->id)->where('function',$permission->function_name)->first();
                    $oldRole = $role;
                    if($role==null){
                        $role = new Roles();
                        $role->groups_id    = $gr->id;
                        $role->function     = $permission->function_name;
                        $role->permission   = $checked;
                        $role->save();
                        $this->log('Role',$role->id,'Register role', 'INSERT', null, json_encode($role));
                    }else{
                        $role->groups_id    = $gr->id;
                        $role->function     = $permission->function_name;
                        $role->permission   = $checked;
                        $role->save();
                        $this->log('Role',$role->id,'Update role', 'UPDATE', json_encode($oldRole), json_encode($role));
                    }
                endforeach;
            endforeach;
            return redirect('/admin/user/assign');
        }
        return view('new_backend.userManagement.assign', compact('permissions','groups'));
    }
}
