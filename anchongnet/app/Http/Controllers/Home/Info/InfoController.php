<?php

namespace App\Http\Controllers\Home\Info;

use App\Auth;
use App\Http\Controllers\Home\CommonController;
use App\Information;
use App\Users;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;

class InfoController extends CommonController
{
    /*
     * 资讯主页
     */
    public function index()
    {
        $page = Input::get(['page']);
        $info = Cache::tags('info')->remember('info'.$page,600,function (){
            return Information::orderBy('created_at','desc')->paginate(10);
        });
        //会员是否认证
        if(session('user')) {
            $phone = Users::where('phone', [session('user')])->first();
            $infoauth  = Auth::where("users_id",$phone->users_id)->get(['auth_status']);
        }else{
            $infoauth = [];
        }
        return view('home.info.index',compact('info','infoauth'));
    }
    /*
     * 资讯详情页
     */
    public function show($infor_id)
    {
        $information = Cache::tags('information')->remember('information'.$infor_id,600,function () use($infor_id){
            return Information::find($infor_id);
        });
        return view('home.info.info',compact('information'));
    }
    /*
     *
     */
    public function create()
    {
        return view('home.info.upload');
    }

    /*
     *
     */
    public function store()
    {

    }
    /*
     *
     */
    public function edit()
    {
        
    }
    /*
     *
     */
    public function save()
    {
        
    }
    /*
     *
     */
    public function destroy()
    {
        
    }
    /**
     * 用于web前端直传后的回调
     */
    public function osscall(Request $req)
    {
        $header = getallheaders();
        $body = file_get_contents('php://input');
        \Log::info("clientIP:".$req->ip().print_r($header,true).PHP_EOL.print_r($_SERVER,true).PHP_EOL.$body,['oss直传回调信息first']);
        //header("Content-Type: application/json");
        //$data = array("Status"=>"Ok");
        //return  json_encode($data);

        // 1.获取OSS的签名header和公钥url header
        $authorizationBase64 = "";
        $pubKeyUrlBase64 = "";
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authorizationBase64 = $_SERVER['HTTP_AUTHORIZATION'];
        }
        if (isset($_SERVER['HTTP_X_OSS_PUB_KEY_URL'])) {
            $pubKeyUrlBase64 = $_SERVER['HTTP_X_OSS_PUB_KEY_URL'];
        }
        if ($authorizationBase64 == '' || $pubKeyUrlBase64 == '') {
            header("http/1.1 403 Forbidden");
            exit();
        }
        // 2.获取OSS的签名
        $authorization = base64_decode($authorizationBase64);
        // 3.获取公钥
        $pubKeyUrl = base64_decode($pubKeyUrlBase64);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $pubKeyUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $pubKey = curl_exec($ch);
        if ($pubKey == "") {
            header("http/1.1 403 Forbidden");
            exit();
        }
        // 4.获取回调body
        $body = file_get_contents('php://input');
        // 5.拼接待签名字符串
        $authStr = '';
        $path = $_SERVER['REQUEST_URI'];
        $pos = strpos($path, '?');
        if ($pos === false) {
            $authStr = urldecode($path)."\n".$body;
        } else {
            $authStr = urldecode(substr($path, 0, $pos)).substr($path, $pos, strlen($path) - $pos)."\n".$body;
        }
        
        // 6.验证签名
        $ok = openssl_verify($authStr, $authorization, $pubKey, OPENSSL_ALGO_MD5);
        if ($ok == 1) {
            //$body入库
            parse_str(urldecode($body),$arr);
            $newid = DB::table('anchong_upfiles')->insertGetId($arr);
            \Log::info("newID:".$newid,['newID']);
            header("Content-Type: application/json");
            echo json_encode(["Status"=>"Ok"]);
        } else {
            header("http/1.1 403 Forbidden");
            exit();
        }
    }
    
    /**
     * 由web的ajax请求调用，为了获得js和oss交互的签名
     */
    public function getphp(Request $req)
    {
        //require_once 'App/STS/osscallbackphp\oss_php_sdk_20140625/sdk.class.php';
        $id= env('ALIOSS_ACCESSKEYId');
        $key= env('ALIOSS_ACCESSKEYSECRET');
        $host = 'http://anchongres.oss-cn-hangzhou.aliyuncs.com';
        $callback_body = '{"callbackUrl":"http://courier.anchong.net/osscall","callbackHost":"courier.anchong.net","callbackBody":"filename=${object}&size=${size}&mimetype=${mimeType}&height=${imageInfo.height}&width=${imageInfo.width}","callbackBodyType":"application/x-www-form-urlencoded"}';
        $base64_callback_body = base64_encode($callback_body);
        $now = time();
        $expire = 30; //设置该policy超时时间是30s. 即这个policy过了这个有效时间，将不能访问
        $end = $now + $expire;
        $expiration = $this->gmt_iso8601($end);
        
        //$oss_sdk_service = new alioss($id, $key, $host);
        $dir = 'ganhuo-dir/';
        
        //最大文件大小.用户可以自己设置
        $condition = array(0=>'content-length-range', 1=>0, 2=>1048576000);
        $conditions[] = $condition;
        
        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $start = array(0=>'starts-with', 1=>'$key', 2=>$dir);
        $conditions[] = $start;
        $arr = array('expiration'=>$expiration,'conditions'=>$conditions);
        //echo json_encode($arr);
        //return;
        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));
        
        $response = array();
        $response['accessid'] = $id;
        $response['host'] = $host;
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        $response['callback'] = $base64_callback_body;
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $dir;
        echo json_encode($response);
    }
    /**
     * 由上个方法内部调用
     * @param unknown $time
     */
    private function gmt_iso8601($time) 
    {
        $dtStr = date("c", $time);
        $mydatetime = new DateTime($dtStr);
        $expiration = $mydatetime->format(DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
    }
}
