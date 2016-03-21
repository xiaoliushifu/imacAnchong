<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Redirect;

class Users_login extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'anchong_users_login';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['user_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public  $timestamps=false;

    //添加用户
    public function add($user_data)
    {
        $this->fill($user_data);
        if($this->save()){
            return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData'=>['users_rank'=>0,'token'=>$user_data['token'],'guid'=> $user_data['users_id']]]);
        }else{
            $users=new \App\Users();
            if($users->del($user_data['users_id'])){
                return response()->json(['serverTime'=>time(),'ServerNo'=>'为了保证您的安全，请重新注册','ResultData'=>""]);
            }else{
                return response()->json(['serverTime'=>time(),'ServerNo'=>'服务器内部错误，请联系管理员并换账号注册','ResultData'=>""]);
            }

        }

    }

    //登陆时的显示
    public function quer($field,$quer_data)
    {
        return $this->select($field)->where($quer_data)->get();
    }

    //登陆是更新token
    public function addToken($user_data,$userid){
        $user=$this->find($userid);
        if($user->update($user_data)){
            return true;
        }else{
            return false;
        }

    }
    //获得token
    public function querToken($guid){
        return $this->select('token')->where('id',$guid)->get()->toArray();
    }
    //查看手机是否已注册
    public function querPhone($phone){
        return $this->select('phone')->where('phone',$phone)->get()->toArray();
    }
    //更新用户视频
    public function addcourse($user_data,$userid){
        $user=$this->find($userid);
        if($user->update($user_data)){
            return true;
        }else{
            return false;
        }
    }
	/*----按照名字进行匹配搜索----*/
	public function scopeKeyActive($query,$keyActive)
    {
        return $query->where('active', '=', "{$keyActive}");
    }
}
