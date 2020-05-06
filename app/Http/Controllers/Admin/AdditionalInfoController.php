<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdditionalInfo;
use App\Models\Shop;
use App\Http\Controllers\Controller;
use App\Library\CustomDesignHelper as CD;
use App\Models\User;

class AdditionalInfoController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
    }
    public function moreInfo($id){
        $shops = Shop::pluck('name','id');
        $shop = Shop::find($id);
        $users = User::where('group_id',7)->pluck('name','id');
        if(request()->isMethod('post')){
            $addInfo = AdditionalInfo::where('shop_id',$shop->id)->first();
            if($addInfo==null){
                $addInfo = new AdditionalInfo();
                $addInfo->shop_id = $shop->id;
            }

            $path = base_path().'/public/images/shops/'.$shop->id.'/banners';
            CD::checkPath($path);
            $file = request()->file('banner');
            if($file!=null) {
                $filename = 'shop_banner_' . $file->getClientOriginalName();
                $upload_success = $file->move($path, $filename);
                if ($upload_success) {
                    $addInfo->banner = $filename;
                }
            }

            $addInfo->subdomain             = request('subdomain');
            $addInfo->account               = request('account');
            $addInfo->keywords              = request('keywords');
            $addInfo->description           = request('description');
            $addInfo->seo_meta_tags         = request('seo_meta_tags');
            $addInfo->more_info             = request('more_info');
            $addInfo->chain                 = request('chain');
            $addInfo->banner_text           = request('banner_text');
            $addInfo->manager               = request('manager');
            $addInfo->menu_representativ    = request('menu_representativ');
            $addInfo->processing_fee        = request('processing_fee');
            $addInfo->my_business_domain    = request('my_business_domain');
            $addInfo->account_password      = request('account_password');
            $addInfo->mailing_address       = request('mailing_address');
            $addInfo->pickup_estimate       = request('pickup_estimate');
            $addInfo->payment_type          = request('payment_type');
            $addInfo->payment_frequency     = request('payment_frequency');
            $addInfo->save();
            return redirect('admin/shop/'.$shop->id.'/additional_information');
        }
        return view('new_backend.shop.moreInfo',compact('shop','users','shops'));
    }
}
