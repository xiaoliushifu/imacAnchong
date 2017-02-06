<?php
    //定义一个维护数组
    $str=["serverTime"=>time(),"ServerNo"=>10,"ResultData"=>["Message"=> "维护中，维护时间30~60分钟"]];
    //将其转换成json发到客户端
    $json=json_encode($str);
    echo $json;
?>
