<?php

namespace App\Http\Controllers\Home\project;

use App\Business;
use App\Http\Controllers\Home\CommonController;
use App\Http\Requests;
use App\Tag;

class SerproController extends CommonController
{

    public function getLepro()
    {
        $ser = Tag::where('type_id',0)->orderBy('id','asc')->get();
        $serpro = $ser->take(7);
        $num = count($ser);
        $lastnum = $num - 7;
        $lastserpro = Tag::where('type_id',0)->orderBy('id','desc')->take($lastnum)->get();
        $addpro = Tag::where('type_id',2)->orderBy('id','asc')->get();
        $serprocate = $addpro->take(7);
        $adnum = count($addpro);
        $adlastnum = $adnum - 7;
        $lastadpro = Tag::where('type_id',2)->orderBy('id','desc')->take($adlastnum)->get();
        $lepro =  Business::where('type', 2)->orderBy('created_at', 'asc')->paginate(15);

        return view('home.project.projectlist2', compact('lepro','serprocate','serpro','lastserpro','lastadpro'));
    }

    public function getListcate($id)
    {
        $ser = Tag::where('type_id',0)->orderBy('id','asc')->get();
        $serpro = $ser->take(7);
        $num = count($ser);
        $lastnum = $num - 7;
        $lastserpro = Tag::where('type_id',0)->orderBy('id','desc')->take($lastnum)->get();
        $addpro = Tag::where('type_id',1)->orderBy('id','asc')->get();
        $serprocate = $addpro->take(7);
        $adnum = count($addpro);
        $adlastnum = $adnum - 7;
        $lastadpro = Tag::where('type_id',1)->orderBy('id','desc')->take($adlastnum)->get();
        $pro = Tag::where('id',$id)->first();
        $prodetail = Business::where('tag',$pro->tag)->where('type',1)->paginate(10);
        return view('home.project.projectlistcate',compact('prodetail','serprocate','serpro','lastserpro','lastadpro'));
    }

    public function getListcate2($id)
    {
        $ser = Tag::where('type_id',0)->orderBy('id','asc')->get();
        $serpro = $ser->take(7);
        $num = count($ser);
        $lastnum = $num - 7;
        $lastserpro = Tag::where('type_id',0)->orderBy('id','desc')->take($lastnum)->get();
        $addpro = Tag::where('type_id',2)->orderBy('id','asc')->get();
        $serprocate = $addpro->take(7);
        $adnum = count($addpro);
        $adlastnum = $adnum - 7;
        $lastadpro = Tag::where('type_id',2)->orderBy('id','desc')->take($adlastnum)->get();
        $pro = Tag::where('id',$id)->first();
        $prodetail2 = Business::where('tag',$pro->tag)->where('type',2)->paginate(10);
        return view('home.project.projectlist2cate',compact('prodetail2','serprocate','serpro','lastserpro','lastadpro'));
    }
}
