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
        if(!Auth::check()){
            return redirect('/user/login');
        }
        return view('/home.project.releaseeg');
    }

    public function store()
    {
        //dd(Input::all());
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
        $result=DB::table('anchong_business')->insertGetId(
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
