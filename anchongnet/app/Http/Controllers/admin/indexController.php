<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session,Redirect,Request,Hash,Auth;
use DB;
use App\Shop;
use Illuminate\Pagination\Paginator;

class indexController extends Controller
{

     /*
     *  后台首页
     */
    public function index()
    {
        //通过Auth获取当前登录用户的id
        $uid=Auth::user()['users_id'];
        if($uid != 1) {
            //页面后期再统一
            return view('admin.indexforVendor',["neworder"=>0,'feedback'=>0,'newshop'=>0,'newauth'=>0,'last_time'=>0,"datacol"=>0]);
        }
        //通过用户获取商铺id
        $sid=Shop::Uid($uid)->sid;
        //通过用户id获取上次登录时间
        $lasttime=Auth::user()['last_login']?Auth::user()['last_login']:Auth::user()['new_login'];
        //转换时间
        $datetime=date('Y-m-d H:i:s',$lasttime);
        //定义变量
        $neworder=0;
        $newuser=0;
        $newshop=0;
        $newauth=0;
        //创建ORM模型
        $order=new \App\Order();
        $feedback=new \App\Feedback();
        $shop=new \App\Shop();
        $auth=new \App\Auth();
        $community_release=new \App\Community_release();
        //查询相比于上次登录新增的订单数目
        $neworder=$order->ordercount('sid =1 and state in(2,4)');
        //查询新增的用户人数
        $newfeedback=$feedback->feedbackcount('state = 1');
        //查询新增商铺
        $newshop=$shop->shopcount('audit = 1');
        //查询新增认证
        $newauth=$auth->authcount('auth_status = 1');
        //查询聊聊
        $community_release_result=$community_release->indexquer(['chat_id','title','name','content','created_at','headpic','comnum'],'auth = 1')->orderBy("chat_id","desc")->paginate(5);
        $args=array("uid"=>$uid);
        return view('admin.index',['username' => Auth::user()['username'],"neworder"=>$neworder,'feedback'=>$newfeedback,'newshop'=>$newshop,'newauth'=>$newauth,'last_time'=>$datetime,"datacol"=>$community_release_result]);
    }

    /*
    *   验证登陆
    */
    public function checklogin(Request $request)
    {
        $data=$request::all();
        //判断验证码是否正确
        if ($data['captchapic'] == Session::get($data['captchanum'].'adminmilkcaptcha')) {
            //判断用户名密码是否正确
            if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
                $users=new \App\Users();
                $rank=$users->quer('users_rank',['users_id'=>Auth::user()['users_id']])->toArray();
                //判断会员的权限是否是管理员
                if ($rank[0]['users_rank'] == 3 || $rank[0]['users_rank']==2) {
                    //创建orm
                    $users_login=new \App\Users_login();
                    $users_login->addToken(['last_login'=>Auth::user()['new_login']],Auth::user()['users_id']);
                    $users_login->addToken(['new_login'=>time()],Auth::user()['users_id']);
                    return Redirect::intended('/');
                } else {
                    //假如会员权限不够就清除登录状态并退出
                    Auth::logout();
                    return Redirect::back();
                }
            } else {
                return Redirect::back()->withInput()->with('loginmes','账号或密码错误!');
            }
        } else {
            return Redirect::back()->withInput()->with('admincaptcha','请填写正确验证码');
        }
    }

    /*
    *   登出
    */
    public function logout()
    {
        //清除登录状态
        Auth::logout();
        return Redirect::intended('/');
    }

    /*
    *   注册
    */
    public function userregister(Request $request)
    {
        //开启事务处理
        DB::beginTransaction();
        $data=$request::all();
        //清除登录状态
        $users_login=new \App\Users_login();
        $users=new \App\Users();
        $users_data=[
            'phone' => $data['username'],
            'ctime' => time(),
        ];
        $usersid=$users->add($users_data);
        $users_login_data=[
            'users_id' => $usersid,
            'password' => Hash::make($data['password']),
            'username' => $data['username'],
            'token' => md5($data['username']),
            'user_rank' => 2,
        ];
        $result=$users_login->add($users_login_data);
        if ($result) {
            //假如成功就提交
            DB::commit();
            return '注册成功';
        } else {
            //假如失败就回滚
            DB::rollback();
            return '注册失败';
        }
    }
}
