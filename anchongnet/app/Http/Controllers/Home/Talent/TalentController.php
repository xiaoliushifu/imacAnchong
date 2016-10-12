<?php

namespace App\Http\Controllers\Home\Talent;
use App\Auth;
use App\Business;
use App\Http\Controllers\Home\CommonController;
use App\Users;
class TalentController extends CommonController
{
    public function index()
    {
        $data = Business::where('type', 3)->orderBy('created_at', 'desc')->paginate(15);
        return view('home.talent.talentlist', compact('data'));
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
        if(session('user')){
            $phone  =Users::where('phone',[session('user')])->first();
            $status =Auth::where("users_id",$phone->users_id)->get(['auth_status']);
        }else{
            $status = [];
        }
        return view('home.talent.talentmain', compact('data','status'));
    }

}
