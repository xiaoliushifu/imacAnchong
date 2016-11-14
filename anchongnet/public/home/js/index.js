/**
 * for the Home
 */
//加载函数
$(function(){
	/*start----智能提示*/
	function oSearchSuggest(searchFuc)
	{
	    //获得input框对象
	    var input = $('#gover_search_key');
	    //提示框对象
	    var suggestWrap = $('#gov_search_suggest');
	    var key = "";
	
	    var init = function(){
	        input.bind('keyup',sendKeyWord);
	        input.bind('blur',function(){setTimeout(hideSuggest,100);})
	    }
	
	    var hideSuggest = function(){
	        suggestWrap.hide();
	    }

	    //1 在input框里输入字符时。
	    //2 提示框已经显示，且 操作"上"或"下"键时
	    var sendKeyWord = function(event){
	        if (suggestWrap.css('display')=='block' && event.keyCode == 38 || event.keyCode == 40) {
	            var current = suggestWrap.find('li.hoveranchong');
	            //向上
	            if (event.keyCode == 38) {
	                if (current.length>0) {
	                    //获得此时的上一个。所以是prev
	                    var prevLi = current.removeClass('hoveranchong').prev();
	                    if(prevLi.length>0) {
	                        prevLi.addClass('hoveranchong');
	                        input.val(prevLi.html());
	                    }
	                } else {
	                    var last = suggestWrap.find('li:last');
	                    last.addClass('hoveranchong');
	                    input.val(last.html());
	                }
	            //向下
	            }else if(event.keyCode == 40) {
	                if (current.length>0) {
	                    var nextLi = current.removeClass('hoveranchong').next();
	                    if(nextLi.length>0) {
	                        nextLi.addClass('hoveranchong');
	                        input.val(nextLi.html());
	                    }
	                } else {
	                    var first = suggestWrap.find('li:first');
	                    first.addClass('hoveranchong');
	                    input.val(first.html());
	                }
	            }
	        //正在输入字符而不是按“上”或者“下”键时的情况。此时，应该根据已输入的数据去后台请求数据。
	        } else {
	            var valText = $.trim(input.val());
	            if(valText ==''|| valText==key) {
	                return;
	            }
	            searchFuc(valText);
	            key = valText;
	        }
	    }//sendkeyword匿名函数结束

		//用后端数据填充提示框
	    this.dataDisplay = function(data){
	        if(data.length<=0) {
	            suggestWrap.hide();
	            return;
	        }
			//开始添加li
	        var li;
	        //文档碎片
	        var tmpFrag = document.createDocumentFragment();
	        suggestWrap.find('ul').html('');
	        for(var i=0; i<data.length; i++) {
	            li = document.createElement('LI');
	            li.innerHTML = data[i];
	            tmpFrag.appendChild(li);
	        }
	        suggestWrap.find('ul').append(tmpFrag);
	
	        //suggestWrap.show();  //show方法在这里有冲突，故改用直接css方法。
	        suggestWrap.css('display','block');
	
	        //hover事件,通过bind('mouseover mouseout')来实现的。
	        suggestWrap.find('li').hover(function(){
	            suggestWrap.find('li').removeClass('hoveranchong');
	            $(this).addClass('hoveranchong');
	        },function(){
	            $(this).removeClass('hoveranchong');
	        //另外click事件
	        }).on('click',function(){
				//alert(this.innerHTML);
	            input.val(this.innerHTML);
	            suggestWrap.hide();
	        });
	    }//dataDisplay结束了

	    init();
	}//oSearchSuggest函数结束

	var searchSuggest = new oSearchSuggest(sendKeyWordToBack);

	//在input框输入字符时触发，不断地输入，就不断地触发。
	function sendKeyWordToBack(keyword){
	    var aData = [];
	    aData.push(keyword+'返回数据1');
	    aData.push(keyword+'返回数据2');
	    aData.push(keyword+'返回数据3');
	    aData.push(keyword+'返回数据4');
	    aData.push(keyword+'返回数据5');
	    aData.push(keyword+'返回数据6');
	    //将后端返回的数据传递到提示框
	    searchSuggest.dataDisplay(aData);
	}
	/*end-----智能提示*/
	
	
});