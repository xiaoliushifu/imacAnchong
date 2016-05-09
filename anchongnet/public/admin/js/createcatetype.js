/**
 * Created by lengxue on 2016/4/20.
 */
$(function(){
    var opt;
    var one0=0;
    $.get("/getlevel",{pid:one0},function(data,status){
        for(var i=0;i<data.length;i++){
            opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
            $("#par0").append(opt);
        }
        var two0=data[0].cat_id;
        $.get("/getlevel",{pid:two0},function(data,status){
            for(var i=0;i<data.length;i++){
                opt="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
                $("#par1").append(opt);
            }
        });
    });

    $("#par0").change(function(){
        $("#par1").empty();
        var val=parseInt($(this).val());
        var opt1;
        $.get("/getlevel",{pid:val},function(data,status){
            for(var i=0;i<data.length;i++){
                opt1="<option  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
                $("#par1").append(opt1);
            }
        });
    });

    $(".gallery").click(function(){
        $("#pic").click();
    });

    $("#pic").change(function(){
        var objUrl = getObjectURL(this.files[0]) ;
        console.log("objUrl = "+objUrl) ;
        if (objUrl) {
            $("#img0").attr("src", objUrl) ;
        }
    }) ;
    //建立一個可存取到該file的url
    function getObjectURL(file) {
        var url = null ;
        if (window.createObjectURL!=undefined) { // basic
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }
});