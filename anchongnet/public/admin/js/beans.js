/**
 * Created by
 */
$(function(){
    //数据保存
    $("body").on("click",'.savebeans',function(){
        var beans_id=$(this).attr('data-id');
        //找出所有上级td的所有DOM对象
        var tds=$(this).parent().siblings();
        var beans=tds.find(".beans").val();
        var money=tds.find(".money").val();
        $.ajax({
            url: '/beans/'+beans_id,
            data:{beans:beans,money:money},
            type:'PUT',
            success:function(result){
                alert(result);
                location.reload();
            }
        });
    });

    //增加条目
    $("body").on("click",'.addcuspro',function(){
        //获得兄弟节点
        var sbl=$(this).parent().parent().siblings().length;
        //获得最大的兑换条目的ID
        //var lastid=parseInt(sbl.last().find('.savebeans').attr('data-id'))+1;
        var lastid=sbl+2;
        //定义标签
        var line='<tr class="line"><td><input type="number" class="beans form-control" value=""/></td><td><input type="number" min="0" class="money form-control" value=""/></td><td><button type="button" class="addcuspro btn-sm btn-link" title="添加" data-id="'+lastid+'"><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="savebeans btn-sm btn-link" title="保存" data-id="'+lastid+'"><span class="glyphicon glyphicon-save"></span></button><button type="button" class="delcuspro btn-sm btn-link" title="删除" data-id="'+lastid+'"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
        $("#beanslist").append(line);
    });

    //删成条目
    $("body").on("click",'.delcuspro',function(){
        //拿到ID
        var beans_id=$(this).attr('data-id');
        //进行ajax删除
        $.ajax({
            url: '/beans/'+beans_id,
            type:'DELETE',
            success:function(result){
                alert(result);
                location.reload();
            }
        });
    });
});
