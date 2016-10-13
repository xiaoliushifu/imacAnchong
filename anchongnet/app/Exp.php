<?php
namespace App;
/**
 * 物流下单及查询统一操作类
 * @author 
 *
 */
class Exp
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
            'dtype' =>'json',
            'key' => $this->skey,
            //订单编号（由下单方指定，非快递公司的运单号，用于和聚合沟通)
            //下单成功只是说明这个信息存储成功,并且会推送到快递公司,会有快递员取件或事先电话联系,这个时候并没有产生物流信息,在快递公司肯定查不到
            'order_no'=>$orderinfo['order_num'],
            'isWaybill'=>1,
            'send_method'=>'addOrderInfoMes',
            //快递公司编码
            'carrier_code'=>$comno,
            
            //发件人信息部分
            'sender_name'=>'公茂通',
            'sender_telphone'=>'18600818638',
           // 'sender_phone'=>$orderinfo['order_num'],//固话
            'sender_province_name'=>'北京',
            'sender_city_name'=>'北京市',
            'sender_district_name'=>'昌平',
            'sender_address'=>'北京市昌平区发展路8号院',
            'sender_post_code'=>'102204',
            //收件人信息部分
            'receiver_name'=>$orderinfo['name'],
            'receiver_telphone'=>$orderinfo['phone'],
            'receiver_province_name'=>$orderinfo['receiver_province_name'],
            'receiver_city_name'=>$orderinfo['receiver_city_name'],
            'receiver_district_name'=>$orderinfo['receiver_district_name'],
            'receiver_address'=>$orderinfo['address'],
            'receiver_post_code'=>'215000',
            //'receiver_org_name'=>$orderinfo['order_num'],
            //其他信息部分
            'remark'=>'聚合下单接口测试，此单勿扰',
            'item_name'=>'安虫商品',//货物名称
            'send_start_time'=>$orderinfo['send_start_time'],
            'send_end_time'=>$orderinfo['send_end_time'],
        );
        //return print_r($params,true);
        \Log::info(print_r($params,true),['下单数据详情']);
        $content = $this->juhecurl($this->sendUrl,$params,1);
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
            'order_no'=>$para['onum'],
        );
        //return $params;
        $content = $this->juhecurl($this->cancelUrl,$params,1);
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