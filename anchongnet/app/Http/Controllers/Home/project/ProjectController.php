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
    /*
     * 发包工程的列表
     */
    public function Index()
    {
        //区域，服务类型的筛选
        $ser =Cache::remember('protype',10,function(){
           return  Tag::where('type_id',0)->orderBy('id','asc')->get();
        });
        $serpro = $ser->take(7);
        //除去显示的7个，也查询出来，放在隐藏的ul里
        $num = count($ser);
        $lastnum = $num - 7;
        $lastserpro = Cache::remember('protype2',10,function() use($lastnum){
           return  Tag::where('type_id',0)->orderBy('id','desc')->take($lastnum)->get();
        });
        $addpro =Cache::remember('protype3',10,function(){
            return   Tag::where('type_id',1)->orderBy('id','asc')->get();
        });
        $serprocate = $addpro->take(7);
        $adnum = count($addpro);
        $adlastnum = $adnum - 7;
        $lastadpro = Cache::remember('protype4',10,function() use($adlastnum){
           return  Tag::where('type_id',1)->orderBy('id','desc')->take($adlastnum)->get();
        });
        //发包工程列表内容
        $page = Input::get(['page']);
        $projectlist =Cache::remember('protypedetail'.$page,10,function(){
           return  Business::where('type', 1)->orderBy('created_at', 'asc')->paginate(15);
        });

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
        return view('home.project.projectdetail', compact('data'));
    }


}
