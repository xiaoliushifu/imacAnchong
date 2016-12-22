<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Session,Redirect,Request,Auth;
use DB;
use App\Shop;

/**
*   该控制器包含了后台主页模块的操作
*/
class indexController extends Controller
{

     /**
     *  后台首页
     *
     * @param  无
     * @return \Illuminate\Http\Response
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

    /**
    *   验证登陆
    *
    * @param  $request('username'用户账号,'captchapic'验证码,'password'用户密码)
    * @return \Illuminate\Http\Response
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
                if ($rank[0]['users_rank'] == 3) {
                    $users_login=new \App\Users_login();
                    $users_login->addToken(['last_login'=>Auth::user()['new_login']],Auth::user()['users_id']);
                    $users_login->addToken(['new_login'=>time()],Auth::user()['users_id']);
                    return Redirect::intended('/');
                //会员认证通过users_rank是2，但认证通过不代表开通商铺,仍拒绝。
                } elseif ($rank[0]['users_rank'] == 2) {
                    $res = DB::table('anchong_shops')->where('users_id',Auth::user()['users_id'])->where('audit',2)->first();
                    if (!$res) {
                        Auth::logout();
                        return Redirect::back();
                    }
                    $users_login=new \App\Users_login();
                    $users_login->addToken(['last_login'=>Auth::user()['new_login']],Auth::user()['users_id']);
                    $users_login->addToken(['new_login'=>time()],Auth::user()['users_id']);
                    return Redirect::intended('/');
                } else {
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

    /**
    *   登出
    *
    * @param  无
    * @return \Illuminate\Http\Response
    */
    public function logout()
    {
        //清除登录状态
        Auth::logout();
        return Redirect::intended('/');
    }
}
