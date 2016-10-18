<?php

namespace App\Http\Controllers\Home\project;

use App\Business;
use App\Http\Controllers\Home\CommonController;
use App\Http\Requests;
use App\Tag;
use Cache;
use Illuminate\Support\Facades\Input;

class SerproController extends CommonController
{
     /*
      * 承接工程列表
      */
    public function getLepro()
    {
        //区域分类选取
        $ser =Cache::remember('chengpro',10,function(){
            return  Tag::where('type_id',0)->orderBy('id','asc')->get();
        }) ;
        //显示的选7个，隐藏的剩余的
        $serpro =$ser->take(7);
        $num = count($ser);
        $lastnum = $num - 7;
        $lastserpro = Cache::remember('chengpro2',10,function() use($lastnum){
         return   Tag::where('type_id',0)->orderBy('id','desc')->take($lastnum)->get();
        });

        //服务类型的选取，显示7个，其余的隐藏
        $addpro = Cache::remember('chengprotype',10,function(){
            return Tag::where('type_id',2)->orderBy('id','asc')->get();
        });
        $serprocate = $addpro->take(7);
        $adnum = count($addpro);
        $adlastnum = $adnum - 7;
        $lastadpro = Cache::remember('chengprotype2',10,function() use($adlastnum){
            return Tag::where('type_id',2)->orderBy('id','desc')->take($adlastnum)->get();
        });
        //承接工程的全部列表
        $page = Input::get(['page']);
        $lepro = Cache::remember('chengprototle'.$page,10,function(){
            return  Business::where('type', 2)->orderBy('created_at', 'asc')->paginate(15);
        });

        return view('home.project.projectlist2', compact('lepro','serprocate','serpro','lastserpro','lastadpro'));
    }
        /*
         * 发包工程的二级分类
         */
    public function getListcate($id)
    {
        //区域和服务类型的筛选
        $ser = Cache::remember('typedetail',10,function(){
           return  Tag::where('type_id',0)->orderBy('id','asc')->get();
        });
        $serpro = $ser->take(7);
        $num = count($ser);
        $lastnum = $num - 7;
        $lastserpro = Cache::remember('typelist',10,function() use($lastnum){
            return Tag::where('type_id',0)->orderBy('id','desc')->take($lastnum)->get();
        });
        $addpro =Cache::remember('typelist2',10,function(){
           return  Tag::where('type_id',1)->orderBy('id','asc')->get();
        });
        $serprocate = $addpro->take(7);
        $adnum = count($addpro);
        $adlastnum = $adnum - 7;
        $lastadpro = Cache::remember('typelist3',10,function() use($adlastnum){
             return  Tag::where('type_id',1)->orderBy('id','desc')->take($adlastnum)->get();
        });
        //传入的id根据标签搜索下面的内容
        $page =Input::get(['page']);
        $prodetail = Cache::remember('typedetail2'.$id.$page,10,function() use($id){
        $pro=  Tag::where('id',$id)->first();
           return  Business::where('tag',$pro->tag)->where('type',1)->paginate(10);
        });

        return view('home.project.projectlistcate',compact('prodetail','serprocate','serpro','lastserpro','lastadpro','id'));
    }
        /*
         * 承接工程的二级分类
         */
    public function getListcate2($id)
    {
        //区域，服务类型 筛选
        $ser = Cache::remember('listype',10,function(){
           return  Tag::where('type_id',0)->orderBy('id','asc')->get();
        });
        $serpro = $ser->take(7);
        $num = count($ser);
        $lastnum = $num - 7;
        $lastserpro = Cache::remember('listtype2',10,function() use($lastnum){
            return Tag::where('type_id',0)->orderBy('id','desc')->take($lastnum)->get();
        });
        $addpro = Cache::remember('listtype3',10,function(){
           return  Tag::where('type_id',2)->orderBy('id','asc')->get();
        });
        $serprocate = $addpro->take(7);
        $adnum = count($addpro);
        $adlastnum = $adnum - 7;
        $lastadpro =Cache::remember('listtype4',10,function() use($adlastnum){
           return  Tag::where('type_id',2)->orderBy('id','desc')->take($adlastnum)->get();
        });
        //传入的id根据标签搜索下面的内容
        $page = Input::get(['page']);
        $prodetail2 = Cache::remember('listdetaill'.$page.$id,10,function() use($id){
            $pro = Tag::where('id',$id)->first();
           return Business::where('tag',$pro->tag)->where('type',2)->paginate(10);
        });

        return view('home.project.projectlist2cate',compact('prodetail2','serprocate','serpro','lastserpro','lastadpro','id'));
    }
}
