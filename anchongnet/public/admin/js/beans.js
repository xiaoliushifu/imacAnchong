/**
 * Created by
 */
$(function(){
    //数据保存
    $(".savebeans").click(function(){
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
    $(".addcuspro").click(function(){
        //获得最大的兑换条目的ID
        var lastid=parseInt($(this).parent().parent().siblings().last().find('.savebeans').attr('data-id'))+1;
        //定义标签
        var line='<tr class="line"><td><input type="number" class="beans form-control" value=""/></td><td><input type="number" min="0" class="money form-control" value="{{$data->money}}"/></td><td><button type="button" class="addcuspro btn-sm btn-link" title="添加" data-id="'+lastid+'"><span class="glyphicon glyphicon-plus"></span></button><button type="button" class="savebeans btn-sm btn-link" title="保存" data-id="'+lastid+'"><span class="glyphicon glyphicon-save"></span></button><button type="button" class="delcuspro btn-sm btn-link" title="删除" data-id="'+lastid+'"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
        $("#beanslist").append(line);
    });
});
