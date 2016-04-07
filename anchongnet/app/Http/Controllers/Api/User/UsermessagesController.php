<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Usermessages;
use App\Users;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

use OSS\OssClient;
use OSS\Core\OssException;

class UsermessagesController extends Controller
{
	private $usermessages;
	private $user;
	public function __construct(){
		$this->usermessages=new usermessages();
		$this->user=new Users();
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show(Request $request)
    {
		//通过guid获取用户实例
		$id=$request['guid'];
		$person=Users::Ids($id)->first();
		switch($person->certification){
			case 0:
			$status="未提交认证";
			break;
			case 1:
			$status="认证待审核";
			break;
			case 2:
			$status="审核未通过";
			break;
			case 3:
			$status="审核已通过";
			break;
		};
        $data=Usermessages::Message($id)->take(1)->get();

		if(count($data)==0){
			return response()->json(
			[
				'serverTime'=>time(),
				'ServerNo'=>0,
				'ResultData'=>[
					'contact' => "",
					'nickname'=>"",
					'account'=>"",
					'qq'=>"",
					'email'=>"",
					'headpic'=>"",
					'authStatus'=>$status,
					'authNum'=>$person->certification,
				],
			]);
		}else{
			$user=Usermessages::where('users_id', '=', $id)->first();
	        return response()->json(
			[
				'serverTime'=>time(),
				'ServerNo'=>0,
				'ResultData'=>[
					'contact' => $user->contact,
					'nickname'=>$user->nickname,
					'account'=>$user->account,
					'qq'=>$user->qq,
					'email'=>$user->email,
					'headpic'=>$user->headpic,
					'authStatus'=>$status,
					'authNum'=>$person->certification,
				],
			]);
		}

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view("admin/users/edit");
    }

    /**
     * 	用户资料修改
     */
    public function update(Request $request)
    {
		//通过guid获取用户实例
		$id=$request['guid'];
        $data=Usermessages::Message($id)->take(1)->get();

		$param=json_decode($request['param'],true);
		$validator = Validator::make($param,
            [
                'qq' => 'digits_between:5,11',
                'email' => 'email|unique:anchong_usermessages',
            ]
        );
		if ($validator->fails()){
			$messages = $validator->errors();
			if ($messages->has('qq')) {
				//如果验证失败,返回验证失败的信息
			    return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData' => ['Message'=>'qq格式不正确']]);
			}else if($messages->has('email')){
				return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData' => ['Message'=>'email格式不正确或该邮箱已经被注册']]);
			}
		}else{
			if(count($data)==0){
				//向数据库插入内容
				$this->usermessages->users_id = $id;
				if($param['nickname']!=null){
					$this->usermessages->nickname = $param['nickname'];
				}
				if($param['qq']!=null){
					$this->usermessages->qq = $param['qq'];
				}
				if($param['email']!=null){
					$this->usermessages->email = $param['email'];
				}
				$result=$this->usermessages->save();
			}else{
				$user=usermessages::where('users_id', '=', $id)->first();
				if($param['nickname']!=null){
					$user->nickname = $param['nickname'];
				}
				if($param['qq']!=null){
					$user->qq = $param['qq'];
				}
				if($param['email']!=null){
					$user->email = $param['email'];
				}
				$result=$user->save();
			}

			//返回给客户端数据
			if($result){
				return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['Message'=>'更新成功']]);
			}else{
				return response()->json(['serverTime'=>time(),'ServerNo'=>1,'ResultData' => ['Message'=>'更新失败']]);
			}
		}
    }

	public function setUserHead(Request $request){
		//通过guid获取用户实例
		$id=$request['guid'];
        $data=Usermessages::Message($id)->take(1)->get();
		$param=json_decode($request['param'],true);

		//配置阿里云oss配置
		$accessKeyId = "HJjYLnySPG4TBdFp";
		$accessKeySecret = "Ifv0SNWwch5sgFcrM1bDthqyy4BmOa";
		$endpoint = "oss-cn-hangzhou.aliyuncs.com";
		$bucket="anchongres";

		//设置上传到阿里云oss的对象的键名
		switch ($_FILES["headpic"]["type"]){
			case "image/png":
			$object="headpic/".time().".png";
			break;
			case "image/jpeg":
			$object="headpic/".time().".jpg";
			break;
			case "image/jpg":
			$object="headpic/".time().".jpg";
			break;
			case "image/gif":
			$object="headpic/".time().".gif";
			break;
			default:
			$object="headpic/".time().".jpg";
		}

		$filePath = $request['headpic'];
		try {
			//实例化一�?ossClient对象
			$ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
			//上传文件
			$ossClient->uploadFile($bucket, $object, $filePath);
			//获取到上传文件的路径
			$signedUrl = $ossClient->signUrl($bucket, $object);
			$pos=strpos($signedUrl,"?");
			$url=substr($signedUrl,0,$pos);
			//将上传的文件的路径保存到数据库中
			if(count($data)==0){
				//向数据库插入内容
				$this->usermessages->headpic = $url;
				$this->usermessages->save();
			}else{
				$user=Usermessages::where('users_id', '=', $id)->first();
				$user->headpic = $url;
				$user->save();
			}
			//返回数据
			return response()->json(["serverTime"=>time(),"ServerNo"=>0,"ResultData" => [
				    'isSuccesss'=>0,
					'Message'=>'上传成功',
					'headPicUrl' => $url
				]]);
		} catch (OssException $e) {
			print $e->getMessage();
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
