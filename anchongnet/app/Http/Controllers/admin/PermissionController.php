<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use App\Users;
use DB;
use App\Http\Controllers\Controller;

/**
*   该控制器包含了权限模块的操作
*/
class PermissionController extends Controller
{
	private $role;
	private $user;
	private $permission;
	public function __construct()
	{
	    //为指定控制器指定中间件
	    $this->middleware('permission');
	}
    /**
     * 权限分配页
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $req)
    {
        //来个角色模型
        $this->role=new Role();
        $nm=$req->input("nm");
        if($nm==""){
		    $datas=$this->role->paginate(6);
		}else{
			$datas = $this->role->where('label','like',"%".$nm."%")->paginate(6);
		}
		$args=array("nm"=>$nm);
		return view('admin/permission/p',array("datacol"=>compact("args","datas")));
    }

    /**
     * 创建新权限页面 create permission
     *
     * @return \Illuminate\Http\Response
     */
    public function getCp(Request $req)
    {
        //来个用户模型
        $this->permission = new Permission();
        $datas=$this->permission->paginate(8);
        $args=array("phone"=>1);
        return view('admin/permission/createperm',array("datacol"=>compact("datas","args")));
    }

    /**
     *执行 权限 添加的提交处理 insert permission
     *创建完权限需要把权限授予某个角色才能使用。
     * @param $request('label'分类,'name'名字,'description'描述)
     */

    public function postIp(Request $req)
    {
        //来个权限模型
        $this->permission = new Permission();

        $this->permission->label=$req->label;
        $this->permission->name=$req->name;
        $this->permission->description=$req->description;
        $this->permission->save();
        echo "OK";
    }

    /**
     * 创建新角色页面 create role
     *创建完角色需要为其分配权限后才能使用
     * @return \Illuminate\Http\Response
     */
    public function getCr(Request $req)
    {
        //来个用户模型
        $this->role = new Role();
        $datas=$this->role->paginate(8);
        $args=array("phone"=>1);
        return view('admin/permission/createrole',array("datacol"=>compact("datas","args")));
    }

    /**
     * 执行 新角色添加 insert role
     *
     * @return \Illuminate\Http\Response
     */
    public function postIr(Request $req)
    {
        //来个角色模型
        $this->role = new Role();
        $this->role->label=$req->label;
        $this->role->name=$req->name;
        $this->role->description=$req->description;
        $this->role->save();
        echo "OK";
    }

    /**
     * 角色设置页
     *
     * @return \Illuminate\Http\Response
     */
    public function getRole(Request $req)
    {
        $this->user = new Users();
        $phone = $req->get('phone');
        $ur = $req->get('ur');
        if ($phone) {
            //sid=0代表尚未开通商铺的用户
            $datas=$this->user->where('sid',0)->Phone($phone)->orderby('users_rank','desc')->paginate(8);
        } elseif (in_array($ur,[1,2,3])) {
            $datas=$this->user->where('sid',0)->where('users_rank',$ur)->orderby('users_rank','desc')->paginate(8);
        } else {
            $datas=$this->user->orderby('users_rank','desc')->paginate(8);
        }
        $args=array("phone"=>$phone);
        return view('admin/permission/r',array("datacol"=>compact("datas","args")));
    }

    /**
     * ajax获得全部权限待编辑
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * $users = DB::table('users')->select('name as user_name')->get();
     */
    public function getPerm($rid)
    {
        $tmp=array();
        //获取指定角色的权限,默认选中
        $res1 = DB::table('anchong_permission_role as pr')->join('anchong_permissions as p','pr.permission_id','=','p.id')->where('pr.role_id','=',$rid)->get(array('p.id','p.label'));
        foreach ($res1 as $v) {
            $tmp[]=$v->id;
        }
        //其他权限,用于待选
       $res2 = DB::table('anchong_permissions')->whereNotIn('id',$tmp)->get(array('id','label'));
       return array($res1,$res2);
    }

    /**
     * ajax获得全部角色待编辑
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * $users = DB::table('users')->select('name as user_name')->get();
     */
    public function getAllrole($uid)
    {
        $tmp=array();
        //获取指定用户的角色
        $res1 = DB::table('anchong_role_user as ru')->join('anchong_roles as r','ru.role_id','=','r.id')->where('ru.user_id','=',$uid)->get(array('r.id','r.label'));
        foreach($res1 as $v)
            $tmp[]=$v->id;
        //其它的角色
        $res2 = DB::table('anchong_roles')->whereNotIn('id',$tmp)->get(array('id','label'));
        return array($res1,$res2);
    }

    /**
     * 更新某个角色的全部权限
     * @param Request $req
     */
    public function postAddperm(Request $req)
    {
        $rid=$req->get('rid');
        $data=array();
        foreach(explode(',',$req->get('perms')) as $v){
            if($v)
                $data[] = ['permission_id'=>$v,'role_id'=>$rid];
        }
        try{
            DB::beginTransaction();
            //先删除，后插入
            DB::table('anchong_permission_role')->where('role_id',$rid)->delete();
            DB::table('anchong_permission_role')->insert($data);
            DB::commit();
           //给个提示
           echo "权限分配成功";
           \Cache::forget('pcall');
        }catch(\Exception $e) {
            exit("权限设置有误");
        }

    }

    /**
     * 更新某个用户的全部角色,由ajax调用
     * @param Request $req
     */
    public function postAddrole(Request $req)
    {
        $uid=$req->get('uid');
        //设置为管理员身份,不能是申请了店铺的人。
        $res = DB::table('anchong_shops')->where('users_id',$uid)->first();
        if ($res) {
            return '该用户已申请商铺，不可设置为管理员';
        }
        $data=array();
        foreach (explode(',',$req->get('roles')) as $v) {
            if ($v) {
                $data[] = ['role_id'=>$v,'user_id'=>$uid];
            }
        }
        try{
            DB::beginTransaction();
            //先删除，后插入
            DB::table('anchong_role_user')->where('user_id',$uid)->delete();
            DB::table('anchong_role_user')->insert($data);
            //有角色设置，则设置为管理员
            if ($data) {
                DB::table('anchong_users_login')->where('users_id',$uid)->update(['user_rank'=>3]);
                DB::table('anchong_users')->where('users_id',$uid)->update(['users_rank'=>3]);
            } else {
                //撤销管理员身份时，查看作为普通用户时是否已经认证
                $cert = DB::table('anchong_users')->where('users_id',$uid)->pluck('certification');
                if ($cert && $cert[0]==3){
                    DB::table('anchong_users_login')->where('users_id',$uid)->update(['user_rank'=>2]);
                    DB::table('anchong_users')->where('users_id',$uid)->update(['users_rank'=>2]);
                } else {
                    DB::table('anchong_users_login')->where('users_id',$uid)->update(['user_rank'=>1]);
                    DB::table('anchong_users')->where('users_id',$uid)->update(['users_rank'=>1]);
                }
                //登出$uid
            }
            DB::commit();
           return "角色设置成功";
            \Cache::forget('pcall');
        }catch (\Exception $e){
            return "角色设置有误".$e->getMessage();
        }
    }
}
