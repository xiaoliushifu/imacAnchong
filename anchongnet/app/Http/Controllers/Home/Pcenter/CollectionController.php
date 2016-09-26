<?php

namespace App\Http\Controllers\Home\Pcenter;

use App\Collection;
use App\Goods_type;
use App\Users;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CollectionController extends Controller
{
    //收藏商品
    public function colgoods()
    {

        $user =Users::where('phone',[session('user')])->get();
        $col = Collection::where(['users_id'=>$user[0]->users_id,'coll_type'=>1])->get();
        foreach($col as $b){
            $sss = Goods_type::where('gid',$b->coll_id)->get();
        }

        return view('home.pcenter.collectgoods');
    }
//    收藏商铺
    public function colshop()
    {
        return view('home.pcenter.collectshop');
    }
//    收藏社区
    public function colcommunity()
    {
        return view('home.pcenter.collectcommunity');
    }

}
