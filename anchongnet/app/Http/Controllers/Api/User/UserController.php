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
            return response()->json(['serverTime'=>time(),'ServerNo'=>$result[1],'ResultData'=>'']);
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
            $validator = Validator::make($param,
            [
                'password' => 'required|min:6',
                'phone' => 'required|min:11|unique:anchong_users_login,username',
                'phonecode' => 'required',
            ]
            );
            if ($validator->fails())
            {
                return response()->json(['serverTime'=>time(),'ServerNo'=>'账号已注册或密码小于六位','ResultData'=>""]);
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
                        return $users_login->add($users_login_data);
                    }else{
                        return response()->json(['serverTime'=>time(),'ServerNo'=>'为了保证您的安全,请重新注册','ResultData'=>""]);
                    }
                }else{
                    return response()->json(['serverTime'=>time(),'ServerNo'=>'手机验证码错误','ResultData'=>""]);
                }
            }
        }elseif(isset($param['email'])) {

        }else {

        }
    }

    /*
    *   用户登录
    */
    public function login(Request $request)
    {
        $data=$request::all();
        $param=json_decode($data['param'],true);
        $username=$param['username'];
        $password=$param['password'];
        if (Auth::attempt(['username' => $username, 'password' => $password]))
        {
            $users_login = new \App\Users_login();
            $token=md5($username.time());
            //登录以后通过账号查询用户ID
            $user_data = $users_login->quer(['users_id'],['username' =>$username])->toArray();
            //插入新TOKEN
            if($users_login->addToken(['token'=>$token],$user_data[0]['users_id'])){
                //创建用户表对象
                $users=new \App\Users();
                //通过用户ID查出来用户权限等级
                $users_rank=$users->quer('users_rank',['users_id'=>$user_data[0]['users_id']]);
                return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['users_rank'=>$users_rank[0]['users_rank'],'token'=>$token,'guid'=> $user_data[0]['users_id']]]);
            }else{
                return response()->json(['serverTime'=>time(),'当前用户Token已过期','ResultData'=>""]);
            }
        }else{
            return response()->json(['serverTime'=>time(),'ServerNo'=>'账号密码错误','ResultData'=>""]);
        }
    }
}
