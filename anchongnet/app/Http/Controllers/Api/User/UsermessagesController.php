<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Usermessages;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use OSS\OssClient;
use OSS\Core\OssException;


class UsermessagesController extends Controller
{
	private $usermessages;
	public function __construct(){
		$this->usermessages=new usermessages();
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
		    return response()->json(['serverTime'=>time(),'ServerNo'=>0,'ResultData' => ['isSuccess'=>0,'Message'=>'更新成功']]);
		}else{
			return response()->json(['serverTime'=>time(),'ServerNo'=>3,'ResultData' => ['isSuccess'=>1,'Message'=>'更新失败']]);
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
			//实例化一个$ossClient对象
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
