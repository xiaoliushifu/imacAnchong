<?php

namespace App\Http\Controllers\Api\User;

//use Illuminate\Http\Request;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redis;
use Validator;
use Hash;
use Auth;

/*
*   该类是手机Api接口的用户相关的控制器
*/
class UserController extends Controller
{
    /*
    *   该方法是用户注册时的手机验证的接口
    */
    public function smsauth(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //new一个短信的对象
        $smsauth=new \App\SMS\smsAuth();
        $result=$smsauth->smsAuth('注册验证',$param['phone']);
        //判断短信是否发送成功并且插入Redis
        if($result[0]){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>$result[1]]);
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData'=>['Message'=>$result[1]]]);
        }
    }

    /*
    *   用户注册
    */
    public function register(Request $request)
    {
        //获得app端传过来的json格式的数据转换成数组格式
        $data=$request::all();
        $param=json_decode($data['param'],true);
        if(isset($param['phone'])){
            $data=$request::all();
            $param=json_decode($data['param'],true);
            //验证用户传过来的数据是否合法
            $validator = Validator::make($param,
            [
                'password' => 'required|min:6',
                'phone' => 'required|min:11|unique:anchong_users_login,username',
                'phonecode' => 'required',
            ]
            );
            //如果出错返回出错信息，如果正确执行下面的操作
            if ($validator->fails())
            {
                return response()->json(['serverTime'=>time(),'ServerNo'=>2,'ResultData'=>['Message'=>'账号已注册或密码小于六位']]);
            }else{
                //从Redis里面取出验证码
                $redis = Redis::connection();
                if($redis->get($param['phone']) == $param['phonecode']){
                    $redis->del($param['phone']);
                    //像users表中插的数据
                    $users_data=[
                        'phone' => $param['phone'],
                        'ctime' => $data['time'],
                    ];
                    //向users表中插数据
                    $users=new \App\Users();
                    $usersid=$users->add($users_data);
                    //判断是否插入成功
                    if(!empty($usersid)){
                        //向users_login表中插的数据
                        $users_login_data=[
                            'users_id' => $usersid,
                            'password' => Hash::make($param['password']),
                            'username' => $param['phone'],
                            'token' => md5($param['phone']),
                        ];
                        $users_login=new \App\Users_login();
                        //假如插入成功
                        if($users_login->add($users_login_data)){
                            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['certification'=>0,'users_rank'=>1,'token'=>$user_data['token'],'guid'=> $user_data['users_id']]]);
                        }elseif($users_login->add($users_login_data) == 2){
                            return response()->json(['serverTime'=>time(),'ServerNo'=>3,'ResultData'=>['Message'=>'为了您的安全，请重新注册']]);
                        }else{
                            return response()->json(['serverTime'=>time(),'ServerNo'=>3,'ResultData'=>['Message'=>'服务器内部错误，请联系管理员并换账号注册']]);
                        }
                    }else{
                        return response()->json(['serverTime'=>time(),'ServerNo'=>3,'ResultData'=>['Message'=>'为了您的安全，请重新注册']]);
                    }
                }else{
                    return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData'=>['Message'=>'手机验证错误']]);
                }
            }
        }elseif(isset($param['email'])) {
            //将来邮箱注册的时候预留的接口
        }else {
            //将来用户名注册的时候预留的接口
        }
    }

    /*
    *   用户登录
    */
    public function login(Request $request)
    {
        $data=$request::all();
        $param=json_decode($data['param'],true);
        //提取username和password
        $username=$param['username'];
        $password=$param['password'];
        //使用laravel集成的验证方法来验证
        if (Auth::attempt(['username' => $username, 'password' => $password]))
        {
            $users_login = new \App\Users_login();
            //生成随机Token
            $token=md5($username.time());
            //登录以后通过账号查询用户ID
            $user_data = $users_login->quer(['users_id'],['username' =>$username])->toArray();
            //插入新TOKEN
            if($users_login->addToken(['token'=>$token],$user_data[0]['users_id'])){
                //创建用户表对象
                $users=new \App\Users();
                //通过用户ID查出来用户权限等级和商家认证
                $users_info=$users->quer(['users_rank','certification'],['users_id'=>$user_data[0]['users_id']]);
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['certification'=>$users_info[0]['certification'],'users_rank'=>$users_info[0]['users_rank'],'token'=>$token,'guid'=> $user_data[0]['users_id']]]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>6,'ResultData'=>['Message'=>'当前Token已过期']]);
            }
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>4,'ResultData'=>['Message'=>'账号密码错误']]);
        }
    }
}
