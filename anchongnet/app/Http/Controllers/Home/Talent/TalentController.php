<?php

namespace App\Http\Controllers\Home\Talent;
use App\Auth;
use App\Business;
use App\Http\Controllers\Home\CommonController;
use App\Tag;
use App\Users;
use Cache;
use Illuminate\Support\Facades\Input;

class TalentController extends CommonController
{
    public function index()
    {
        $ser =Cache::remember('stalenttype1',10,function(){
            return  Tag::where('type_id',0)->orderBy('id','asc')->get();
        }) ;
        $adrcate =$ser->take(7);
        $num = count($ser);
        $lastnum = $num - 7;
        $addcate = Cache::remember('stalenttype2',10,function() use($lastnum){
            return   Tag::where('type_id',0)->orderBy('id','desc')->take($lastnum)->get();
        });
        $page = Input::get(['page']);
        $data = Cache::remember('talentfirstdetail'.$page,10,function(){
            return Business::where('type', 3)->orderBy('created_at', 'desc')->paginate(15);
        });
        $sercate = Cache::remember('talenttypefirst',10,function(){
            return Tag::where('type_id',3)->orderBy('id','asc')->get();
        });

        return view('home.talent.talentlist', compact('data','adrcate','addcate','sercate'));
    }

    public function create()
    {
        return view('/home.release.releasetalent');
    }

    public function store()
    {

    }

    public function show($bid)
    {
        $data = Business::find($bid);
        $data->content = str_replace("\n", "<br>", $data->content);
        return view('home.talent.talentmain', compact('data'));
    }

}
