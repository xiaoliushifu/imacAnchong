/**
 * Created by lengxue on 2016/4/18.
 */
$(function(){
	
	/**
	 * 获取当前分类信息
	 */
    $(".edit").click(function(){
        var id=parseInt($(this).attr("data-id"));
        $("#myform").attr("action","/goodcate/"+id);
        $.get("/goodcate/"+id+"/edit",function(data,status){
            $("#catname").val(data.cat_name);
            $("#keyword").val(data.keyword);
            $("#description").val(data.cat_desc);
            $("#sort").val(data.sort_order);
            switch (data.is_show){
                case 0:
                    $("#show0")[0].checked=true;
                    break;
                case 1:
                    $("#show1")[0].checked=true;
                    break;
            }
        })
    });

    /**
     * 当前分类的父级分类信息获取
     */
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
            //当前分类有父级时
            if (pid != one0) {
            	$(".opt[value='" + pid + "']").attr("id","cur");
                $("#cur")[0].selected=true;
            }
        });
    });

    /**
     * 点击查看子分类
     */
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
            var o=$(this);
            var id=o.attr("data-id");
            $.ajax({
                url: "/goodcate/"+id,
                type: 'DELETE',
                success: function(result) {
                    alert(result);
                    if (result.indexOf('成功') != -1) {
                    		o.parents('tr').remove();
                    }
                }
            })
        }
    });
});
