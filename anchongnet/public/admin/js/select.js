/**
 * Created by lengxue on 2016/4/18.
 */
$(function() {
   $("#mainselect").click(function(){
       var pid=parseInt($(this).attr('data-pid'));
       $.get("/goods/cate",{pid:pid},function(data,status){
           alert(data.length);
       });
   })
});