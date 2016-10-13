<?php

namespace App\Http\Controllers\Home\project;
use App\Business;
use App\Http\Controllers\Home\CommonController;
use App\Tag;
use Cache;
use App\Users;
use App\Auth;
use Illuminate\Support\Facades\Input;
class ProjectController extends CommonController
{
    public function Index()
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
        $projectlist = Business::where('type', 1)->orderBy('created_at', 'asc')->paginate(15);

        return view('home.project.projectlist', compact('projectlist','serprocate','serpro','lastserpro','lastadpro'));
    }
    public function create()
    {
        return view('/home.release.releaseeg');
    }

    public function store()
    {
        
    }
    public function show($bid)
    {
        $data = Business::find($bid);
        $data->content = str_replace("\n", "<br>", $data->content);
        if(session('user')){
            $phone  =Users::where('phone',[session('user')])->first();
            $status =Auth::where("users_id",$phone->users_id)->get(['auth_status']);
        }else{
            $status = [];
        }
        return view('home.project.projectdetail', compact('data','status'));
    }


}
