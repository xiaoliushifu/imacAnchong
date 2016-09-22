<?php
namespace App\JsonPost;

/*
*   提供HTTPJSON发送请求服务
*/
class JsonPost
{
    //定义变量
    private $AppKey;
    private $AppSecret;

    //初始化orm
    public function __construct(){
		$this->AppKey='84d534824dad63f32935708bea55a434';
		$this->AppSecret='aa2a4af56756';
	}

    /*
    *   这个方法是提供http发包请求
    */
    public function http_post_data($url, $data_string) {
        $Nonce=rand(10,99);
        $CurTime=time();
        $CheckSum=sha1($this->AppSecret.$Nonce.$CurTime);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'AppKey: '.$this->AppKey,
            'Nonce: '.$Nonce,
            'CurTime: '.$CurTime,
            'CheckSum: '.$CheckSum,
            'Content-Type:application/x-www-form-urlencoded;charset=utf-8application/json; charset=utf-8',
            'Content-Length: '. strlen($data_string))
        );
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();

        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return array($return_code, $return_content);
    }
}
