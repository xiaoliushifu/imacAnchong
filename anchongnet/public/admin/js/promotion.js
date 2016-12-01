/**
 * Created by
 */
$(function(){
    //数据保存
    $("body").on("click",'.savepromotion',function(){
        var promotion_id=$(this).attr('data-id');
        //找出所有上级td的所有DOM对象
        var tds=$(this).parent().siblings();
        var starttime=tds.find(".starttime").val();
        var endtime=tds.find(".endtime").val();
        $.ajax({
            url: '/promotion/'+promotion_id,
            data:{start_time:starttime,end_time:endtime},
            type:'PUT',
            success:function(result){
                alert(result);
                if(result != "促销时间冲突，请检测重试"){
                    //location.reload();
                }
            }
        });
    });

    //增加条目
    $("body").on("click",'.addcuspro',function(){
        //定义标签
        var line='<tr class="line"><td><input type="text" class="starttime form-control" placeholder="格式2017-01-30" value=""/></td><td><input type="text" min="0" class="endtime form-control" placeholder="格式2017-01-30" value=""/></td><td><button type="button" class="addcuspro btn-sm btn-link" title="添加" data-id="0"><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="savepromotion btn-sm btn-link" title="保存" data-id="0"><span class="glyphicon glyphicon-save"></span></button><button type="button" class="delcuspro btn-sm btn-link" title="删除" data-id="0"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
        $("#promotionlist").append(line);
    });

    //删成条目
    $("body").on("click",'.delcuspro',function(){
        if(confirm('确定要删除该时段吗？')){
            //拿到ID
            var promotion_id=$(this).attr('data-id');
            //进行ajax删除
            $.ajax({
                url: '/promotion/'+promotion_id,
                type:'DELETE',
                success:function(result){
                    alert(result);
                    location.reload();
                }
            });
        }
    });
});
