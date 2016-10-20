<?php

namespace App\Http\Controllers\Api\Live;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Qiniu\Utils;
use Qiniu\Auth;
use Validator;
use DB;
use Cache;

/*
*   该控制器包含了互动直播模块的操作
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

    /*
    *   过滤sql注入(考虑到关键字因素暂不使用)
    */
    private function filtrate($str)
    {
        array('`','(','"',"'",'union','select','where','and','or','delete','update');
        $num=count($filt_arr);
        for($i=0;$i<$num;$i++){
             if(strstr($str,$filt_arr[$i])){
                 return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData' => ['Message'=>'非法输入']]);
             }
        }
        $str_arr=explode(' ',$str);
        for ($i=0; $i < count($str_arr); $i++) {
            //判断是否是非法字符
            switch ($str_arr[$i]) {
                case 'select':
                    # code...
                    break;
                case 'delete':
                    break;
                case 'and':
                    break;
                case 'or':
                    break;
                case 'union':
                    break;
                case 'where':
                    break;
                case 'update':
                    break;
                case "'":
                    break;
                case '"':
                    break;
                case '#':
                    break;
                case '(':
                    break;
                default:
                    return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData' => ['Message'=>'请改变搜索内容']]);
                    break;
            }
        }

    }

    /*
    *   判断是否目前是否有直播
    */
    public function isliving(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request->all();
        //尝试运行开启七牛直播，并看该用户是否已开启直播
        try {
            //查出用户的直播ID
            $zb=DB::table('v_start')->where('users_id',$data['guid'])->select('zb_id','room_id','title','images','topic')->first();
            if(!$zb){
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['isliving'=>0,'stream'=>"",'zb_id'=>"",'roomid'=>"",'title'=>"",'images'=>"",'topic'=>""]]);
            }
            //如果该用户已生成了直播就直接获取
            $stream=$this->hub->getStream("z1.chongzai.".md5($data['guid']));
            $PublishUrl=$stream->rtmpPublishUrl();
            $streams=$stream->toJSONString();
            // var_dump($stream->rtmpLiveUrls());
            // echo $stream->rtmpPublishUrl();
            // //清空当前所有流
            // $stream=$this->hub->listStreams();
            // foreach ($stream['items'] as $StreamObj) {
            //     $StreamObj->delete();
            // }
            // exit;
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['isliving'=>1,'stream'=>$streams,'zb_id'=>$zb->zb_id,'roomid'=>$zb->room_id,'title'=>$zb->title,'images'=>$zb->images,'topic'=>$zb->topic]]);
        } catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['isliving'=>0,'stream'=>"",'zb_id'=>"",'roomid'=>"",'title'=>"",'images'=>"",'topic'=>""]]);
        }
    }

    /*
    *   生成七牛直播对象
    */
    public function createlive(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request->all();
        $param=json_decode($data['param'],true);
        //对接收的数据进行验证
        $validator = Validator::make($param,
            [
                'title' => 'required|between:2,120'
            ]
        );
        //验证失败时返回错误信息
		if ($validator->fails()) {
			$messages = $validator->errors();
			if ($messages->has('title')) {
			    return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData' => ['Message'=>'直播标题不能超过60个汉字起不小于2个字！']]);
			}
		}

        //开启直播
        try{
            //如果该用户已生成了直播就直接获取
            $stream=$this->hub->getStream("z1.chongzai.".md5($data['guid']));
        } catch (\Exception $e) {
            //假如用户未开始直播，尝试生成新直播
            try{
                //定义直播生成的数据
                $title           = md5($data['guid']);     // 选填，默认自动生成，定义为用户的ID
                $publishKey      = "anchongnet2016";     // 选填，默认自动生成
                $publishSecurity = 'dynamic';     // 选填, 可以为 "dynamic" 或 "static", 默认为 "dynamic"
                //生成Stream Object
                $stream = $this->hub->createStream($title, $publishKey, $publishSecurity);
            } catch (\Exception $e) {
                return response()->json(['serverTime'=>time(),'ServerNo'=>20,'ResultData'=>['Message'=>"直播开启失败"]]);
            }
        }
        //将stream转成json
        $streams=$stream->toJSONString();
        //获取查看直播的地址
        $urls = $stream->rtmpLiveUrls();
        //判断是否有查看直播的地址
        if(!empty($urls) && $urls['ORIGIN']){
            $PublishUrl=$urls['ORIGIN'];
            //网易云信
            $url  = "https://api.netease.im/nimserver/chatroom/create.action";
            $datas="creator=".$param['phone']."&name=".$param['nick']."的直播间";
            list($return_code, $return_content) = $this->JsonPost->http_post_data($url, $datas);
            //将字符串形式的json解析为数组
            $result=json_decode($return_content,true);
            //判断是否请求成功
            if($return_code != 200){
                return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData'=>['Message'=>"直播聊天室开启失败"]]);
            }
            $room_id=$result['chatroom']['roomid'];
            //将数据插入表中
            $zb_id=DB::table('v_start')->insertGetId(
                [
                    'users_id' => $data['guid'],
                    'room_url' => $PublishUrl,
                    'title'    => $param['title'],
                    'images'   => str_replace('.oss-','.img-',$param['images']),
                    'topic'    => $param['topic'],
                    'room_id' => $result['chatroom']['roomid'],
                    'nick' => $param['nick'],
                    'header' => $param['header']
                ]
            );
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData'=>['Message'=>"直播开启失败"]]);
        }
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['stream'=>$streams,'zb_id'=>$zb_id,'roomid'=>$room_id]]);
    }

    /*
    *   直播间头像
    */
    public function livepic(Request $request)
    {
        //定义图片数组
        $pic_arr=NULL;
        $pic_result=NULL;
        //定义取多少张图片
        $num=10;
        //判断缓存
        $pic_arr_cache=Cache::get('live_livepic_pic_arr');
        if($pic_arr_cache){
            //将缓存取出来赋值给变量
            $pic_arr=$pic_arr_cache;
        }else{
            //从数据库查出数据
            $pic_data=DB::table('anchong_usermessages')->lists('headpic');
            //检索出所有不为空的图片地址
            foreach ($pic_data as $pic) {
                if($pic != NULL){
                    $pic_arr[]=$pic;
                }
            }
            //将查询结果加入缓存
            Cache::add('live_livepic_pic_arr', $pic_arr, 600);
        }
        //统计一共有多少张图片
        $pic_num=count($pic_arr);
        //生成随机的数组
        $number=range(1,$pic_num);
        //打乱数组数据
        shuffle($number);
        $result = array_slice($number,5,$num);
        //进行遍历循环
        for($i=0;$i<$num;$i++){
            $pic_result[]=$pic_arr[$result[$i]];
        }
        //判断是否获取图片
        if(!$pic_result){
            return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData'=>['Message'=>"图片获取失败"]]);
        }
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$pic_result]);
    }

    /*
    *   网易云信(一些操作使用)
    */
    public function createroom(Request $request)
    {
        $stream=$this->hub->listStreams();
        foreach ($stream['items'] as $StreamObj) {
            $StreamObj->delete();
        }
        exit;
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request->all();
        $param=json_decode($data['param'],true);
            //网易云信
            $url  = "https://api.netease.im/nimserver/user/unblock.action";
            $datas="creator=".$param['phone'];
            list($return_code, $return_content) = $this->JsonPost->http_post_data($url, $datas);
            //将字符串形式的json解析为数组
            $result=json_decode($return_content,true);
            //判断是否请求成功
            if($return_code != 200){
                return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData'=>['Message'=>"直播聊天开启失败"]]);
            }
    }

    /*
    *   关闭直播
    */
    public function endlive(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request->all();
        $param=json_decode($data['param'],true);
        //从直播里面删除该数据
        $del=DB::table('v_start')->where('zb_id',$param['zb_id'])->delete();
        //判断是否成功关闭直播数据
        if($del){
            try{
                //如果该用户已生成了直播就直接获取
                $stream=$this->hub->getStream("z1.chongzai.".md5($data['guid']));
                $stream->delete();
                //网易云信
                $url  = "https://api.netease.im/nimserver/chatroom/toggleCloseStat.action";
                $datas="operator=".$param['phone']."&roomid=".$param['roomid'].'&valid=false';
                list($return_code, $return_content) = $this->JsonPost->http_post_data($url, $datas);
                //将字符串形式的json解析为数组
                $result=json_decode($return_content,true);
                //判断是否请求成功
                if($return_code != 200){
                    try{
                        //网易云信
                        $url  = "https://api.netease.im/nimserver/chatroom/toggleCloseStat.action";
                        $datas="operator=".$param['phone']."&roomid=".$param['roomid'].'&valid=false';
                        list($return_code, $return_content) = $this->JsonPost->http_post_data($url, $datas);
                        //将字符串形式的json解析为数组
                        $result=json_decode($return_content,true);
                        if($return_code != 200){
                            return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData'=>['Message'=>"聊天室关闭失败"]]);
                        }
                    } catch (\Exception $e) {
                        return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData' => ['Message'=>'关闭失败']]);
                    }
                }
            } catch (\Exception $e) {
                return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData' => ['Message'=>'关闭失败']]);
            }
            //返回结果
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['Message'=>'关闭成功']]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData' => ['Message'=>'关闭失败']]);
        }
    }

    /*
    *   保存直播
    */
    public function savelive(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request->all();
        $param=json_decode($data['param'],true);
        //保存七牛流
        try {

            $name      = $data['guid'].time().'.mp4'; // 必填
            $format    = 'mp4';           // 必填
            $start     = $param['start_time'];      // 必填, 单位为秒, 为UNIX时间戳
            $end       = $param['end_time'];      // 必填, 单位为秒, 为UNIX时间戳
            $notifyUrl = NULL;            // 选填

            //如果该用户已生成了直播就直接获取
            $stream=$this->hub->getStream("z1.chongzai.".md5($data['guid']));
            $result = $stream->saveAs($name, $format, $start, $end, $notifyUrl = NULL); # => Array
            //判断是否有数据
            if(!$result){
                return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData' => ['Message'=>'保存失败']]);
            }
        } catch (\Exception $e) {
            return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData' => ['Message'=>'保存失败']]);
        }
        //开启事务处理
        DB::beginTransaction();
        //插入重播表
        $restart_id=DB::table('v_restart')->insertGetId(
            [
                'title' => $param['title'],
                'room_id' => $param['room_id'],
                'header' => $param['header'],
                'nick' => $param['nickname'],
                'sum' => $param['sum'],
                'users_id' => $data['guid'],
                'room_url' => $result['targetUrl'],
                'm3u8_url' => $result['url'],
                'live_time' => $param['live_time'],
                'images' => str_replace('.oss-','.img-',$param['images'])
            ]
        );
        //插入搜索表
        $restart_search=DB::table('v_restart_search')->insertGetId(
            [
                'title' => $param['title'],
                'cb_id' => $restart_id,
                'sum' => $param['sum'],
                'users_id' => $data['guid'],
            ]
        );
        //判断两个表是否插入成功并关闭直播数据
        if($restart_id && $restart_search){
            //进行提交
            DB::commit();
            //返回结果
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=> ['Message'=>'保存成功']]);
        }else{
            //假如失败就回滚
            DB::rollback();
            //返回结果
            return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData' => ['Message'=>'保存失败']]);
        }
    }

    /*
    *   直播列表
    */
    public function livelist(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request->all();
        $param=json_decode($data['param'],true);
        //默认每页数量
        $limit=5;
        //定义查询数据
        $live_data=['room_id','room_url','title','users_id','header','nick','images'];
        //统计数量
        $live_count=$this->Live_Start->Live()->count();
        $live_list=$this->Live_Start->Live()->select($live_data)->skip(($param['page']-1)*$limit)->take($limit)->orderBy('zb_id','DESC')->get();
        //判断是否有人直播
        if($live_count>0 && $live_list){
            //返回结果
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$live_count,'list'=>$live_list]]);
        }else{
            //返回结果
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>0,'list'=>[]]]);
        }
    }

    /*
    *   重播列表
    */
    public function relivelist(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request->all();
        $param=json_decode($data['param'],true);
        //默认每页数量
        $limit=5;
        //定义查询数据
        $live_data=['room_id','room_url','title','users_id','images','header','nick','sum','m3u8_url'];
        //统计数量
        $live_count=$this->Live_Restart->Live()->count();
        $live_list=$this->Live_Restart->Live()->select($live_data)->skip(($param['page']-1)*$limit)->take($limit)->orderBy('cb_id','DESC')->get();
        //判断是否有人直播
        if($live_count>0 && $live_list){
            //返回结果
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>$live_count,'list'=>$live_list]]);
        }else{
            //返回结果
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>0,'list'=>[]]]);
        }
    }

    /*
    *   直播搜索功能
    */
    public function livesearch(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request->all();
        $param=json_decode($data['param'],true);
        //对接收的数据进行验证
        $validator = Validator::make($param,
            [
                'search' => 'required|between:2,40'
            ]
        );
        //验证失败时返回错误信息
		if ($validator->fails()) {
			$messages = $validator->errors();
			if ($messages->has('search')) {
			    return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData' => ['Message'=>'搜索内容不能小于2个字符']]);
			}
		}
        //取出搜索内容
        $search=$param['search'];
        //定义查询数据
        $live_data=['room_id','room_url','title','users_id','header','nick','images'];
        //查出数据
        DB::connection()->enableQueryLog(); // 开启查询日志
        DB::table('v_start'); // 要查看的sql
        $live_list=$this->Live_Start->Live()->select($live_data)->where("title", "like", "%$search%")->get();
        $queries = DB::getQueryLog();
        var_dump($queries);
        //返回结果
        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => $live_list]);
    }

    /*
    *   主播搜索功能
    */
    public function anchorsearch(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request->all();
        $param=json_decode($data['param'],true);
        //对接收的数据进行验证
        $validator = Validator::make($param,
            [
                'search' => 'required|between:2,40'
            ]
        );
        //验证失败时返回错误信息
		if ($validator->fails()) {
			$messages = $validator->errors();
			if ($messages->has('search')) {
			    return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData' => ['Message'=>'搜索内容不能小于2个字符']]);
			}
		}
        //取出搜索内容
        $search=$param['search'];
        //判断用户传入的是数字还是其他的
        if(is_numeric($search)){
            $search=ltrim($search,0);
            $anchors=DB::table('anchong_usermessages')->where('users_id',$search)->select('headpic','users_id','nickname')->get();
            //返回结果
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => $anchors]);
        }else{
            // DB::connection()->enableQueryLog(); // 开启查询日志
            // DB::table('anchong_usermessages'); // 要查看的sql
            $anchors=DB::table('anchong_usermessages')->where('nickname',$search)->select('headpic','users_id','nickname')->get();
            // $queries = DB::getQueryLog();
            // var_dump($queries);
            //返回结果
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => $anchors]);
        }
    }

    /*
    *   重播搜索功能
    */
    public function relivesearch(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request->all();
        $param=json_decode($data['param'],true);
        //默认每页数量
        $limit=5;
        //对接收的数据进行验证
        $validator = Validator::make($param,
            [
                'search' => 'required|between:2,40'
            ]
        );
        //验证失败时返回错误信息
		if ($validator->fails()) {
			$messages = $validator->errors();
			if ($messages->has('search')) {
			    return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData' => ['Message'=>'搜索内容不能小于2个字符']]);
			}
		}
        //取出搜索内容
        $search=$param['search'];
        $count=DB::table('v_restart_search')->where("title", "like", "%$search%")->count();
        $cb_arr=DB::table('v_restart_search')->select('cb_id')->where("title", "like", "%$search%")->skip(($param['page']-1)*$limit)->take($limit)->orderBy('sum','DESC')->get();
        if($count == 0 && empty($cb_arr)){
            //返回结果
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['total'=>0,'list'=>[]]]);
        }
        //定义重播的ID数组
        $cb_id_arr=[];
        foreach ($cb_arr as $cb_id) {
            $cb_id_arr[]=$cb_id->cb_id;
        }
        //定义查询数据
        $live_data=['room_id','room_url','title','users_id','header','nick','images','sum','m3u8_url'];
        $live_list=DB::table('v_restart')->whereIn('cb_id',$cb_id_arr)->select($live_data)->get();

        return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['total'=>$count,'list'=>$live_list]]);
    }

    /*
    *   个人重播列表
    */
    public function mylivelist(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request->all();
        $param=json_decode($data['param'],true);
        //默认每页数量
        $limit=5;
        $user_data=DB::table('anchong_usermessages')->where('users_id',$param['guid'])->select('nickname','headpic')->get();
        //定义查询数据
        $live_data=['cb_id','room_id','room_url','title','users_id','images','sum','m3u8_url'];
        $living=DB::table('v_start')->where('users_id',$param['guid'])->select('zb_id','room_id','room_url','title','users_id','images')->get();
        //统计数量
        $live_count=$this->Live_Restart->Live()->where('users_id',$param['guid'])->count();
        $live_list=$this->Live_Restart->Live()->where('users_id',$param['guid'])->select($live_data)->skip(($param['page']-1)*$limit)->take($limit)->orderBy('cb_id','DESC')->get()->toArray();
        //如果该人在直播就把正在直播的信息放到第一位
        if(count($living) >0){
            $living[0]->sum=null;
            if($param['page'] == 1){
                array_unshift($live_list,$living[0]);
            }
            $live_count +=1;
        }
        //判断是否有往日的重播
        if($live_count>0 && $live_list){
            //返回结果
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['nickname'=>$user_data[0]->nickname,'headpic'=>$user_data[0]->headpic,'total'=>$live_count,'list'=>$live_list]]);
        }else{
            //返回结果
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['nickname'=>$user_data[0]->nickname,'headpic'=>$user_data[0]->headpic,'total'=>0,'list'=>[]]]);
        }
    }

    /*
    *   个人重播删除
    */
    public function dellive(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request->all();
        $param=json_decode($data['param'],true);
        //从重播里面删除该数据
        $del=$this->Live_Restart->destroy($param['cb_id']);
        $search_del=DB::table('v_restart_search')->where('cb_id',$param['cb_id'])->delete();
        //判断是否成功删除
        if($del && $search_del){
            //返回结果
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=> ['Message'=>'删除成功']]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>18,'ResultData' => ['Message'=>'删除失败']]);
        }
    }

    /*
    *   网易云信脚本注册器
    *   用完删除
    */
    public function regnetease(Request $request)
    {
        $users=DB::table('anchong_users_login')->select('username','users_id')->where('netease_token',"")->get();
        // //var_dump($users);
        foreach ($users as $users_info) {
            //网易云信
            $url  = "https://api.netease.im/nimserver/user/create.action";
            $datas = 'accid='.($users_info->username).'&name='.($users_info->username).'&icon=http://anchongres.oss-cn-hangzhou.aliyuncs.com/headpic/placeholder120@3x.png&token=3c374b5bc7a7d5235cde6426487d8a3c';
            list($return_code, $return_content) = $this->JsonPost->http_post_data($url, $datas);
            //判断是否请求成功
            if($return_code != 200){
                echo $users_info->account.'====';
            }else {
                $result=DB::table('anchong_users_login')->where('users_id',$users_info->users_id)->update(['netease_token'=>'3c374b5bc7a7d5235cde6426487d8a3c']);
                if(!$result){
                    echo $users_info->account.'====';
                }
            }

        }
    }
}
