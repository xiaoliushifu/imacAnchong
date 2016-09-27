<?php

namespace App\Http\Controllers\Home\project;

use App\Business;
use App\Http\Controllers\Home\CommonController;
use Illuminate\Http\Request;
use App\Http\Requests;

class ProjectController extends CommonController
{
    public function Index()
    {
        $data = Business::where('type', 1)->orderBy('created_at', 'asc')->paginate(15);

        return view('home.project.projectlist', compact('data'));
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
        return view('home.project.projectdetail', compact('data'));
}











}
