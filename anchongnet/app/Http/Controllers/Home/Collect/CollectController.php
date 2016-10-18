<?php

namespace App\Http\Controllers\Home\Collect;

use App\Collection;
use App\Http\Controllers\Home\CommonController;
use Illuminate\Support\Facades\Input;

class CollectController extends CommonController
{
    /*
     * 收藏店铺
     */
    public function collectShop()
    {
        $input = Input::except('_token');
        $date = date('Y-m-d H:i:s');
        $input['created_at'] = $date;
        $collect = Collection::where('coll_id',$input['coll_id'])->where('users_id',$input['users_id'])->count();
        if ($collect){
            $msg=[
                'status' => 0,
                'msg'    => '店铺已收藏，请勿重复收藏'
            ];
        }else{
            $re= Collection::create($input);
            if($re){
                $msg =[
                    'status' => 0,
                    'msg'    => '店铺收藏成功'
                ];
            }else{
                $msg =[
                'status' => 1,
                'msg'    => '收藏失败，请稍后再试'
                ];
            }
        }
        return $msg;
        }
}
