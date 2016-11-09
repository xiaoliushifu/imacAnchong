<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

/**
*   该控制器包含了后台直播管理模块的操作
*/
class LiveController extends Controller
{
    //定义变量
    private $JsonPost;
    //七牛云直播公私钥
    private $ACCESS_KEY;
    private $SECRET_KEY;
    //定义七牛云空间实例化的对象
    private $hub;
    //定义ORM模型
    private $Live_Start;
    private $Live_Restart;

    /*
    *   执行构造方法将orm模型初始化
    */
    public function __construct()
    {
        $this->JsonPost=new \App\JsonPost\JsonPost();
        $this->SECRET_KEY="X8fxGoXHSIyvt-H0k9kRWqvZjE5COGqQzMp_UJGD";
        $this->ACCESS_KEY="G4vcc2JpeWnVVYu4RIJhCWHb8Ck8zMfyDlB0k2mw";
        //创建七牛云直播的对象
        $credentials = new \Qiniu\Credentials($this->ACCESS_KEY, $this->SECRET_KEY);
        //实例化他的推流空间对象
        $this->hub = new \Pili\Hub($credentials, "chongzai");
        //实例化orm
        $this->Live_Start =new \App\Live_Start();
        $this->Live_Restart=new \App\Live_Restart();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas=DB::table('v_start')->select('zb_id','room_id','room_url','title','users_id','header','nick','images','state')->paginate(8);
        return view('admin/live/index',array("datacol"=>compact("datas")));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //看是否是关闭操作
        if($request->type == 'close'){
            try {
                //如果该用户已生成了直播就直接获取
                $stream=$this->hub->getStream("z1.chongzai.".md5($request->users_id));
                $stream=$stream->disable(-1);
                //判断是否关闭成功
                if(!$stream){
                    $state=DB::table('v_start')->where('zb_id',$id)->update(['state'=>2]);
                    if($state){
                        return "强制关闭成功";
                    }else{
                        return "该直播已强制关闭";
                    }
                }else{
                    return "强制关闭失败";
                }
            } catch (\Exception $e) {
                return "强制关闭失败，可能该直播已结束";
            }
        }elseif($request->type == 'open'){
            try {
                //如果该用户已生成了直播就直接获取
                $stream=$this->hub->getStream("z1.chongzai.".md5($request->users_id));
                $stream=$stream->enable();
                //判断是否关闭成功
                if(!$stream){
                    $state=DB::table('v_start')->where('zb_id',$id)->update(['state'=>1]);
                    if($state){
                        return "直播开启成功";
                    }else{
                        return "该直播已开启";
                    }
                }else{
                    return "直播开启失败";
                }
            } catch (\Exception $e) {
                return "重新开启失败，可能该直播已结束";
            }
        }elseif($request->type == 'recommend'){
            $result=$state=DB::table('v_start')->where('zb_id',$id)->update(['recommend'=>time()]);
            if(!$result){
                return "顶置失败，请重新操作";
            }
            return "该直播已顶置";
        }elseif($request->type == 'cancel'){
            $result=$state=DB::table('v_start')->where('zb_id',$id)->update(['recommend'=>0]);
            if(!$result){
                return "取消失败，请重新操作";
            }
            return "直播顶置已取消";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
