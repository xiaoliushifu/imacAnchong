<?php

namespace App\Http\Controllers\Home\Talent;

use App\Business;
use App\Http\Controllers\Home\CommonController;
use App\Http\Requests;
use App\Tag;

class ServerController extends CommonController
{
    public function getSertalent($id)
    {
         $sert = Tag::where('id',$id)->first();
        $serbus = Business::where('tag',$sert->tag)->where('type',3)->paginate(10);

        $adrcate = Tag::where('type_id',0)->orderBy('id','asc')->take(7)->get();
        $addcate = Tag::where('type_id',0)->orderBy('id','desc')->take(20)->get();
        $sercate = Tag::where('type_id',3)->orderBy('id','asc')->get();
        return view('home.talent.talentcatelist',compact('serbus','adrcate','addcate','sercate'));
    }


    public function getTalentjoin()
    {
        $join = Business::where('type', 4)->orderBy('created_at', 'desc')->paginate(15);
        $adrcate = Tag::where('type_id',0)->orderBy('id','asc')->take(7)->get();
        $addcate = Tag::where('type_id',0)->orderBy('id','desc')->take(20)->get();
        $sercate = Tag::where('type_id',4)->orderBy('id','asc')->get();

        return view('home.talent.talentjoinlist',compact('join','adrcate','addcate','sercate'));
    }

    public function getTaljoin($id)
    {
        $join = Business::where('type', 4)->orderBy('created_at', 'desc')->paginate(15);
        $adrcate = Tag::where('type_id',0)->orderBy('id','asc')->take(7)->get();
        $addcate = Tag::where('type_id',0)->orderBy('id','desc')->take(20)->get();
        $sercate = Tag::where('type_id',4)->orderBy('id','asc')->get();
        $sert = Tag::where('id',$id)->first();
        $joinbus = Business::where('tag',$sert->tag)->where('type',4)->paginate(10);
        return view('home.talent.talentjoinlist',compact('join','adrcate','addcate','sercate','joinbus'));
    }
}
