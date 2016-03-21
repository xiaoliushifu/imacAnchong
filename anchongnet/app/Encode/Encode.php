<?php
namespace App\Encode;
/*
*   提供Api接口签名验证的的加密算法
*/
class Encode{
    /*
    *   这个方法是Api接口签名验证的算法，提供一个参数，传入md5的加密，输出加密过的token
    */
    public function encodeToken($user_token){
        $token=$user_token;
        $encodetoken="";
        $encodenum=(hexdec(substr($token,2,1).substr($token,5,1).substr($token,8,1))%8);
        $encode=[[2,3,1,17,22,28],[0,8,19,23,30,31],[9,15,31,1,5,7],[11,21,31,10,12,16],[30,1,12,18,25,28],[8,14,17,27,1,4],[2,8,13,19,20,24],[5,16,20,29,18,22],];
        for($i=0;$i<6;$i++){
            $encodetoken .= substr($token,$encode[$encodenum][$i],1);
        }
           return $encodetoken;
    }
}
