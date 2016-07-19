/**
 * Created by lengxue on 2016/4/18.
 */
$(function(){
    $(".edit").click(function(){
        var id=parseInt($(this).attr("data-id"));
        $("#myform").attr("action","/goodcate/"+id);
        $.get("/goodcate/"+id+"/edit",function(data,status){
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
            }
        })
    });

    $(".edit").click(function(){
        $("#par0").empty();
        var defaultopt="<option value='0'>无</option>";
        $("#par0").append(defaultopt);
        var opt;
        var pid=$(this).attr("data-pid");
        var one0=0;
        $.get("/getlevel",{pid:one0},function(data,status){
            for(var i=0;i<data.length;i++){
                opt="<option class='opt' value="+data[i].cat_id+">"+data[i].cat_name+"</option>";
                $("#par0").append(opt);
            }
            $(".opt[value='" + pid + "']").attr("id","cur");
            document.getElementById("cur").selected=true;
        });
    });

    //点击查看子分类
    $(".view").click(function(){
        $("#soncate").empty();
        var id=parseInt($(this).attr("data-id"));
        var dt;
        //去掉getlevel3
        var url="/getlevel";
        $.get(url,{pid:id},function(data,status){
            for(var i=0;i<data.length;i++){
                dt="<dt class='son' data-id="+data[i].cat_id+">"+data[i].cat_name+"</dt>";
                $("#soncate").append(dt);
            }
        })
    });

    $(".del").click(function(){
        if(confirm('确定要删除吗？')){
            var id=$(this).attr("data-id");
            $.ajax({
                url: "/goodcate/"+id,
                type: 'DELETE',
                success: function(result) {
                    // Do something with the result
                    alert(result);
                    setTimeout(function(){location.reload()},500);
                }
            })
        }
    });
});