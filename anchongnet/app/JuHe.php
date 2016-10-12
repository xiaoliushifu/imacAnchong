<?php
namespace App;
/**
 * 物流下单及查询统一操作类
 * @author 
 *
 */
class exp
{
    
    private $qkey = '0abb2cf879a118af49c5e0308b4aea41';
    
    //查询物流状态接口
    private $queryUrl = 'http://v.juhe.cn/exp/index';
    private $qcomarr =[
        ['no'=>'zjs','com'=>'宅急送'],
        ['no'=>'ems','com'=>'EMS'],
        ['no'=>'yt','com'=>'圆通'],
        ['no'=>'zto','com'=>'中通'],
        ['no'=>'sf','com'=>'顺丰'],
    ];
    //获得物流公司列表的接口,暂用开发文档中列出的即可
    //private $comUrl = 'http://v.juhe.cn/exp/com';
    
    //下单及取消的key
    private $skey = '5fc2ea5424749a5bc3aa6e7fd1b1acfa';
    private $scomarr =[
        ['carrier_code'=>'zjs','carrier_phone'=>'11183','carrier_name'=>'宅急送'],
        ['carrier_code'=>'yuantong','carrier_phone'=>'11183','carrier_name'=>'圆通速递'],
        ['carrier_code'=>'ems','carrier_phone'=>'11183','carrier_name'=>'EMS'],
        ['carrier_code'=>'zhongtong','carrier_phone'=>'11183','carrier_name'=>'中通快递'],
        ['carrier_code'=>'shunfeng','carrier_phone'=>'11183','carrier_name'=>'顺丰速运'],
    ];
    //下单接口
    private $sendUrl = 'http://v.juhe.cn/expressonline/test/expressSend.php';
    //取消已经发出的订单接口
    private $cancelUrl = 'http://v.juhe.cn/expressonline/test/cancleSend.php';
    

    public function __construct($qdata=null,$sdata=null){
        //$this->appkey = $appkey;
    }
//     /**
//      * 返回支持的快递公司公司列表
//      * @return array
//      */
//     public function getComs(){
//         $params = 'key='.$this->qkey;
//         $content = $this->juhecurl($this->comUrl,$params);
//         return $this->_returnArray($content);
//     }
    /**
     * 向物流公司下单
     * @param unknown $param 具体参数
     * @param unknown $no   公司代号
     */
    public function sendOrder($orderinfo,$comno='zjs'){
        $params = array(
            'key' => $this->skey,
            //订单编号（由下单方指定)
            'order_no'=>$order_num,
            'isWaybill'=>$order_num,
            //快递公司编码
            'carrier_code'=>$comno,
            
            //发件人信息部分
            'sender_name'=>$order_num,
            'sender_telphone'=>$order_num,
            'sender_phone'=>$order_num,
            'sender_province_name'=>$order_num,
            'sender_city_name'=>$order_num,
            'sender_district_name'=>$order_num,
            'sender_address'=>$order_num,
            'sender_post_code'=>$order_num,
            //收件人信息部分
            'receiver_name'=>$order_num,
            'receiver_telphone'=>$order_num,
            'receiver_province_name'=>$order_num,
            'receiver_city_name'=>$order_num,
            'receiver_district_name'=>$order_num,
            'receiver_address'=>$order_num,
            'receiver_org_name'=>$order_num,
            //其他信息部分
            'remark'=>$order_num,
            'item_name'=>$order_num,
            'send_start_time'=>$order_num,
            'send_end_time'=>$order_num,
        );
        $content = $this->juhecurl($this->queryUrl,$params,1);
        return $this->_returnArray($content);
    }

    /**
     * 取消订单
     * @param unknown $para
     * @param unknown $no
     */
    public function cancelOrder($para,$comno='zjs'){
        $params = array(
            'key' => $this->skey,
            'carrier_code'  => $comno,
            'order_no'=>$para['order_num'],
        );
        $content = $this->juhecurl($this->queryUrl,$params,1);
        return $this->_returnArray($content);
    }
    
    /**
     * 查看快递状态
     * @param string $com
     * @param string $no
     * @return array
     */
    public function query($com,$no){
        $params = array(
            'key' => $this->qkey,
            'com'  => $com,
            'no' => $no
        );
        $content = $this->juhecurl($this->queryUrl,$params,1);
        return $this->_returnArray($content);
    }
    
    /**
     * 将JSON内容转为数组数据，并返回
     * @param string $content [内容]
     * @return array
     */
    private function _returnArray($content) {
        return json_decode($content,true);
    }

    /**
     * 请求接口返回内容
     * @param  string $url [请求的URL地址]
     * @param  string $params [请求的参数]
     * @param  int $ipost [是否采用POST形式]
     * @return  string
     */
    private function juhecurl($url,$params=false,$ispost=0){
        $httpInfo = array();
        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        if ( $ispost ) {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        } else {
            if ($params) {
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            } else {
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        //$httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        //$httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;
    }
}