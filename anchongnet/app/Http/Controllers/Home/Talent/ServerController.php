<?php

namespace App\Http\Controllers\Home\Talent;

use App\Business;
use App\Http\Controllers\Home\CommonController;
use App\Http\Requests;
use App\Tag;
use Cache;
use Illuminate\Support\Facades\Input;

class ServerController extends CommonController
{
      /*
       * 人才发布二级分类
       */
    public function getSertalent($id)
    {
        //对区域，服务类型筛选
        $ser =Cache::remember('talenttype1',10,function(){
            return  Tag::where('type_id',0)->orderBy('id','asc')->get();
        }) ;
        $adrcate =$ser->take(7);
        $num = count($ser);
        $lastnum = $num - 7;
        $addcate = Cache::remember('talenttype2',10,function() use($lastnum){
            return   Tag::where('type_id',0)->orderBy('id','desc')->take($lastnum)->get();
        });
        //根据传入的ID，找到tag，通过tag查询内容
        $page = Input::get(['page']);
        $serbus = Cache::remember('talentdetail'.$id.$page,10,function() use($id){
             $sert =Tag::where('id',$id)->first();
            return  Business::where('tag',$sert->tag)->where('type',3)->paginate(10);
         });
        $sercate = Cache::remember('talenttype',10,function(){
            return Tag::where('type_id',3)->orderBy('id','asc')->get();
        });
        return view('home.talent.talentcatelist',compact('serbus','adrcate','addcate','sercate','id'));
    }

      /*
       * 人才招聘列表
       */
    public function getTalentjoin()
    {
        //对区域，服务类型筛选
        $ser =Cache::remember('2talenttype1',10,function(){
            return  Tag::where('type_id',0)->orderBy('id','asc')->get();
        }) ;
        $adrcate =$ser->take(7);
        $num = count($ser);
        $lastnum = $num - 7;
        $addcate = Cache::remember('2talenttype2',10,function() use($lastnum){
            return   Tag::where('type_id',0)->orderBy('id','desc')->take($lastnum)->get();
        });
        //人才招聘的列表内容
        $page = Input::get(['page']);
        $join = Cache::remember('talenjoindetail'.$page,10,function(){
           return  Business::where('type', 4)->orderBy('bid', 'desc')->paginate(12);
        });
        $sercate =Cache::remember('talentjoin',10,function(){
            return Tag::where('type_id',4)->orderBy('id','asc')->get();
        });

        return view('home.talent.talentjoinlist',compact('join','adrcate','addcate','sercate'));
    }

      /*
       * 人才招聘的二级分类
       */
    public function getTaljoin($id)
    {
        //对区域，服务类型筛选
        $ser =Cache::remember('3talenttype1',10,function(){
            return  Tag::where('type_id',0)->orderBy('id','asc')->get();
        }) ;
        $adrcate =$ser->take(7);
        $num = count($ser);
        $lastnum = $num - 7;
        $addcate = Cache::remember('3talenttype2',10,function() use($lastnum){
            return   Tag::where('type_id',0)->orderBy('id','desc')->take($lastnum)->get();
        });
        $page = Input::get(['page']);
        $join = Cache::remember('talenjoindetail'.$page,10,function(){
            return  Business::where('type', 4)->orderBy('created_at', 'desc')->paginate(12);
        });

        $sercate = Cache::remember('3talentype3',10,function(){
           return   Tag::where('type_id',4)->orderBy('id','asc')->get();
        });
        //根据传入的ID，找到tag，通过tag查询内容
        $joinbus = Cache::remember('talentdetailtype'.$page.$id,10,function() use($id){
            $sert = Tag::where('id',$id)->first();
            return Business::where('tag',$sert->tag)->where('type',4)->paginate(10);
        });

        return view('home.talent.talentjoinlist',compact('join','adrcate','addcate','sercate','joinbus','id'));
    }
}
