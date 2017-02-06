<?php

namespace App\Http\Controllers\Home\Talent;
use App\Business;
use App\Http\Controllers\Home\CommonController;
use App\Tag;
use Cache;
use Auth;
use Illuminate\Support\Facades\Input;

class TalentController extends CommonController
{
    public function index()
    {
        //区域类别
        $ser =Cache::remember('stalenttype0',1440,function(){
            return  Tag::where('type_id',0)->take(26)->get(['id','tag']);
        }) ;
        $adrcate =$ser->take(8);
        $addcate = $ser->slice(8);
        
        //服务类别
        $serall = Cache::remember('talenttype3',10,function(){
            return Tag::where('type_id',3)->take(26)->get();
        });
        $sercate =$serall->take(8);
        $asercate = $serall->slice(8);
        
        $page = Input::get(['page']);
        $data = Cache::remember('talentfirstdetail'.$page,10,function(){
            return Business::where('type', 3)->orderBy('created_at', 'desc')->paginate(15);
        });
        return view('home.talent.talentlist', compact('data','adrcate','addcate','sercate','asercate'));
    }

    public function create()
    {
        if(!Auth::check()){
            return redirect('/user/login');
        }
        return view('/home.release.releasetalent');
    }

    public function store()
    {

    }

    public function show($bid)
    {
        $data = Business::find($bid);
        if (!$data) {
            abort(404);
        }
        $data->content = str_replace("\n", "<br>", $data->content);
        return view('home.talent.talentmain', compact('data'));
    }

}
