/**
 * Created by lengxue on 2016/4/19.
 */
$(function(){
    $(".edit").click(function(){
        var id=parseInt($(this).attr("data-id"));
        $("#myform").attr("action","/goodcatetype/"+id);
        $.get("/goodcatetype/"+id+"/edit",function(data,status){
            $("#catname").val(data.cat_name);
            $("#keyword").val(data.keyword);
            $("#description").val(data.cat_desc);
            switch (data.is_show){
                case 0:
                    document.getElementById("show0").checked=true;
                    break;
                case 1:
                    document.getElementById("show1").checked=true;
                    break;
            };
            $("#img0").attr("src",data.pic);
        })
    });
    $(".edit").click(function(){
        $("#par0").empty();
        var opt;
        var pid=$(this).attr("data-pid");
        $.get("/getlevel2",function(data,status){
            for(var i=0;i<data.length;i++){
                opt="<option class='opt'  value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
                $("#par0").append(opt);
            }
            $(".opt[value='" + pid + "']").attr("id","cur");
            document.getElementById("cur").selected=true;
        });
    });
    $(".del").click(function(){
        if(confirm('确定要删除吗？')){
            var id=$(this).attr("data-id");
            $.ajax({
                url: "/goodcatetype/"+id,
                type: 'DELETE',
                success: function(result) {
                    // Do something with the result
                    alert(result);
                    setTimeout(function(){location.reload()},500);
                }
            })
        }
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