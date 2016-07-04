<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use App\Users;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

class PermissionController extends Controller
{
	private $role;
	private $user;
	private $permission;
	public function __construct(){
	    
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
     *执行 权限添加 的提交处理 insert permission
     * @param Request $req
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
     *
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
        //来个用户模型
            
        $this->user = new Users();
        $datas=$this->user->paginate(8);
        $args=array("phone"=>1);
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
        foreach($res1 as $v)
            $tmp[]=$v->id;
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
        
        DB::beginTransaction();
        //先删除，后插入
        DB::table('anchong_permission_role')->where('role_id',$rid)->delete();
        DB::table('anchong_permission_role')->insert($data);
        DB::commit();
       //给个提示
       echo "权限分配成功";
    }
    
    /**
     * 更新某个用户的全部角色,由ajax调用
     * @param Request $req
     */
    public function postAddrole(Request $req)
    {
        $uid=$req->get('uid');
        $data=array();
        foreach(explode(',',$req->get('roles')) as $v){
            if($v)
                $data[] = ['role_id'=>$v,'user_id'=>$uid];
        }
        DB::beginTransaction();
        //先删除，后插入
        DB::table('anchong_role_user')->where('user_id',$uid)->delete();
        DB::table('anchong_role_user')->insert($data);
        DB::commit();
        echo "角色设置成功";
    }
}
