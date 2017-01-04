<?php

namespace App\Http\Controllers\Home\Collect;

use App\Collection;
use App\Http\Controllers\Home\CommonController;
use Illuminate\Support\Facades\Input;
use Auth;

class CollectController extends CommonController
{
    public function index()
    {

    }

    /*
     * 收藏店铺或货品
     */
    public function store()
    {
        $user = Auth::user();
        if(!$user) {
            return  ['status' => 0 ,'msg' => '登陆后才可以收藏哦'];
        }
        $input = Input::all();
        $input['users_id'] = $user['users_id'];
        if (!in_array($input['coll_type'],['1','2'])) {
            return  ['status' =>0 ,'msg' => '无此收藏的类型'];
        }
        $remsg[1] = ['status'=> 0,'msg' => '商品已收藏，请勿重复收藏'];
        $remsg[2] = ['status'=> 0,'msg' => '店铺已收藏，请勿重复收藏'];
        $item = Collection::where('users_id', $input['users_id'])->where('coll_id', $input['coll_id'])->where('coll_type', $input['coll_type'])->first();
        //没有时直接收藏即可
        if (!$item) {
            if(Collection::create($input)) {
                return ['status'=> 1,'msg' => '收藏成功'];
            }else{
                return ['status'=> 0,'msg' => '收藏失败'];
            }
        } else {
            return $remsg[$input['coll_type']];
        }
    }
}
