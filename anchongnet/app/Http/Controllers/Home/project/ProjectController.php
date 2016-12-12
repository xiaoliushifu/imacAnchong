<?php

namespace App\Http\Controllers\Home\project;
use App\Business;
use App\Http\Controllers\Home\CommonController;
use App\Tag;
use Cache;
use Auth;
use DB;
use Illuminate\Support\Facades\Input;
class ProjectController extends CommonController
{
    /*
     * 发布工程的列表
     */
    public function Index()
    {
        //区域标签
        $ser =Cache::remember('protype0',1440,function(){
           return  Tag::where('type_id',0)->get();
        });
        $serpro = $ser->take(7);
        $lastserpro = $ser->slice(7);

        //服务类别标签
        $addpro =Cache::remember('protype1',1440,function(){
            return   Tag::where('type_id',1)->get();
        });
        $serprocate = $addpro->take(7);
        $lastadpro = $addpro->slice(7);

        //发包工程列表数据
        $page = Input::get(['page']);
        $projectlist =Cache::remember('protypedetail'.$page,10,function(){
           return  Business::where('type', 1)->orderBy('id','desc')->paginate(15);
        });

        return view('home.project.projectlist', compact('projectlist','serprocate','serpro','lastserpro','lastadpro'));
    }

    public function create()
    {
        if(!Auth::check()){
            return redirect('/user/login');
        }
        return view('/home.project.releaseeg');
    }

    /**
     * 发布商机
     */
    public function store()
    {
        $data = Input::all();
        $data['tag'] = '安防设施';
        $data['area'] = '全国';
        if(!in_array($data['type'],['1','2','3','4','5'])){
            return back();
        }
        $user = Cache::remember('all',10,function (){
            return Usermessages::where('users_id', Auth::user()['users_id'])->first();
        });
        //定义图片变量
        $imgs="";
        //判断是否有图片
        if (isset($data['pic'])) {
            foreach ($data['pic'] as $pic) {
                $imgs.=$pic.'#@#';
            }
        }
        //向business表中插入数据
        DB::table('anchong_business')->insert(
            [
                'users_id' => $user['users_id'],
                'title' => $data['title'],
                'content'=>$data['content'],
                'tag'=>$data['tag'],
                'phone'=>$data['phone'],
                'contact'=>$data['contact'],
                'type'=>$data['type'],
                'business_status'=>1,
                'tags'=>$data['area'],
                'tags_match'=>bin2hex($data['area']),
                'endtime' => date('Y-m-d H:i:s',time()+86400*7),
                'created_at' => date('Y-m-d H:i:s',time()),
                'img' => $imgs,
            ]
        );
        return back();
    }
    /**
     * 查看商机
     * @param unknown $bid
     */
    public function show($bid)
    {
        $data = Business::find($bid);
        if (!$data) {
            abort(404);
        }
        $data->content = str_replace("\n", "<br>", $data->content);
        return view('home.project.projectdetail', compact('data'));
    }
}
