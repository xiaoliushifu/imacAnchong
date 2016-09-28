<?php

namespace App\Http\Controllers\Home\Pcenter;

use App\Collection;
use App\Goods_type;
use App\Shop;
use App\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Home\CommonController;
use App\Http\Requests;


class CollectionController extends CommonController
{
    //收藏商品
    public function colgoods()
    {

        $user =Users::where('phone',[session('user')])->first();
        $col = Collection::where(['users_id'=>$user->users_id,'coll_type'=>1])->get(['coll_id'])->toArray();


            $colg= Goods_type::wherein('gid',$col)->get();


        return view('home.pcenter.minecollect.collectgoods',compact('colg'));
    }
//    收藏商铺
    public function colshop()
    {
        $user =Users::where('phone',[session('user')])->first();
        $col = Collection::where(['users_id'=>$user->users_id,'coll_type'=>2])->get(['coll_id'])->toArray();
             $shop = Shop::wherein('sid',$col)->get();

        return view('home.pcenter.minecollect.collectshop',compact('shop'));
    }
//    收藏社区
    public function colcommunity()
    {
        return view('home.pcenter.minecollect.collectcommunity');
    }

}
