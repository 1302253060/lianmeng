function setMainNavLine(){
    if($(".main_nav").length == 0) return;
	var pos = $(".main_nav li.active").offset();
    if (pos) {
        $(".main_nav .underline").offset({left:pos.left});
    }
}

function setSubNavLine(){
    if($(".sidebar").length == 0) return;
	var pos = $(".sidebar li.active").offset();
	$(".sidebar .gapline").offset({top:pos.top});
	$(".sidebar .mergeline").offset({top:pos.top});
}

function clickPage(anchor){
    if($(".page").length == 0) return;
    $(".page").delegate("a", "click", function(){
        $(this).attr("href", $(this).attr("href")+anchor);
    });
}

function setHintPos(){
    if($("#hint").length == 0 && $(".info_hint").length == 0) return;

    var left = parseInt(($(window).width() - $("#hint").outerWidth())/2),
        top = parseInt(($(window).height() - $("#hint").outerHeight())/2);

    $("#hint").css({"left":left+"px", "top":top+"px"});
    $(".regContainer").css({"left":0, "top":top+"px"});
    $(".info_hint").css({"left":left+"px", "top":top+"px"});
    $(".freeze_hint").css({"left":left+"px", "top":top+"px"});
}

function initPage(showNum, currP, totalP, baseURL){
    var pageArr = computePage(showNum, currP, totalP, baseURL);

    var fPage = '<span>'+pageArr.splice(0, 1)+'</span>',
        lPage = '<span>'+pageArr.splice(pageArr.length - 1, 1)+'</span>',
        mPage = '<span class="pageList">'+pageArr.join("")+'</span>';

    if(totalP == 0){
        $(".page").html((mPage));
    }else if(totalP == 1){
        $(".page").html("");
    }else{
        $(".page").html((fPage+mPage+lPage));
    }


}

//页面计算逻辑
function computePage(showNum, currP, totalP, baseURL){
    var pageArr = new Array();

    //总页数小于等于展示页数
    if(totalP <= showNum){
        loopPage(1, totalP, currP, baseURL, pageArr);
    //总页数大于展示页数
    }else{
        var gap = (showNum - 1)/2,
            lRealGap = currP - 1,
            rRealGap = totalP - currP;

        //当前页偏左
        if(lRealGap <= gap){
            loopPage(1, 2+gap, currP, baseURL, pageArr);
            pageArr.push("...");
            pageArr.push('<a href="'+baseURL+totalP+'" target="_self">'+totalP+'</a>');

        //当前页偏右
        }else if(rRealGap <= gap){
            loopPage(totalP-gap-1, totalP, currP, baseURL, pageArr);
            pageArr.unshift("...");
            pageArr.unshift('<a href="'+baseURL+'1" target="_self">1</a>');

        //当前页居中
        }else{
            pageArr.push('<a href="'+baseURL+'1" target="_self">1</a>');
            pageArr.push('...');
            var tGap = (gap - 1)/2;
            loopPage(currP-tGap, currP-tGap+gap-1, currP, baseURL, pageArr);
            pageArr.push('...');
            pageArr.push('<a href="'+baseURL+totalP+'" target="_self">'+totalP+'</a>');
        }


    }

    //上一页、下一页逻辑
    if(currP == 1){
            pageArr.unshift('<a class="quiet" href="javascript:void(0)"  target="_self">上一页</a>');
        }else{
            pageArr.unshift('<a href="'+baseURL+(currP-1)+'" target="_self">上一页</a>');
        }
    if(currP == totalP){
            pageArr.push('<a class="quiet" href="javascript:void(0)"  target="_self">下一页</a>');
        }else{
            pageArr.push('<a href="'+baseURL+(currP+1)+'" target="_self">下一页</a>');
    }

    return pageArr;

}

function loopPage(start, end, currP, baseURL, pageArr){
    for(var i=start; i<=end; i++){
        if(i == currP){
            pageArr.push('<a class="active" href="javascript:void(0)"  target="_self">'+i+'</a>');
        }else{
            pageArr.push('<a href="'+baseURL+i+'" target="_self">'+i+'</a>');
        }
    }
}


//设置最小高度
function setMainHeight(d_height){
    var w_height = $(window).height() - d_height;

    w_height = w_height<0?0:w_height;

    $(".main_content").css({"min-height":w_height+"px", "height":"100%", "_height":w_height+"px"})
}

function checkInfo(){
	$('#bankname').change(function(){
		$("#wholeBname").val("");
		$("#cardnum").val("");
		$("#recardnum").val("");
		$("#cardnum").parent().find(".warning").html("");
		$("#recardnum").parent().find(".warning").html("");
		$("#wholeBname").parent().find(".warning").html("");
	})
    $(".applyAccount input").each(function(i, e){
        $(e).blur(function(){
            checkValue.call(this, e.name,e.value)
        });
    });
    $(".applyAccount form").submit(function(e){
        var inputs = $(".applyAccount input");
            inputs_name = ['realname', 'ID', 'qq', 'tel', 'addr','wholeBname','cardnum','recardnum','payee']

        for(var i=0; i<inputs.length; i++){
            if(inputs_name.join(",").indexOf($(inputs[i]).attr("id")) == -1) return;
            if(!nullVerify.call(inputs[i], "不能为空！")){
                 e.preventDefault();
                 break;
            }
        }

		if($("#cardnum").val()!=$("#recardnum").val()){
			$("#recardnum").parent().find(".warning").html("两次输入银行卡号不符！");
			e.preventDefault();
		}
		else{
			$("#recardnum").parent().find(".warning").html("");
		}


    });
}



function nullVerify(str){
	var value = $(this).val();
	var chk_str=$(this).parent().find(".warning").html();
	if(chk_str!=""){
		return false;
	}
	if($.trim(value).length ==0){
		$(this).parent().find(".warning").html(str);
		return false;
	}else{
		$(this).parent().find(".warning").html("");
	return true;
	}
}


function checkValue(t,v){
	var value = $(this).val();
    if(this.id=='recardnum' || this.id=="cardnum"){
	var bank_reg = new RegExp("^\[0-9]{1,20}$");
       if(!bank_reg.test($("#cardnum").val())){
			$("#cardnum").parent().find(".warning").html("请正确输入银行卡号！");
			return;
		}
		else{
			$("#cardnum").parent().find(".warning").html('');
		}
         if($("#cardnum").val()!=$("#recardnum").val()){
             $("#recardnum").parent().find(".warning").html("请确认银行卡号！");
          }
          else{
              $("#recardnum").parent().find(".warning").html("");
          }

     return;
  }


	if(this.id=='realname'){ //真实姓名
		var re = /^[\u4e00-\u9fa5a-z]+$/gi;
        if (!re.test($("#realname").val()) || $("#realname").val().length<2) {
             $("#realname").parent().find(".warning").html("请正确输入真实姓名！");
			 return;
          }
          else{
              $("#realname").parent().find(".warning").html("");
          }

    }

	if(this.id=='addr'){ //真实通讯地址
        if ($("#addr").val().length<5) {
             $("#addr").parent().find(".warning").html("请正确输入通讯地址！");
			 return;
          }
          else{
              $("#addr").parent().find(".warning").html("");
          }

    }

	var xmlhttp;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var chkstr=xmlhttp.responseText;
			var json = eval('(' + chkstr + ')');

			if(json.text!="ok"){
			$("#"+json.type).parent().find(".warning").html(json.text);
			}
			else{
			$("#"+json.type).parent().find(".warning").html("");
			}
		}
	}
	xmlhttp.open("GET","/user/check_value_ajax?type="+t+"&value="+v,true);
	xmlhttp.send();
}

function upinfo(){
	//checkInfo();
	$("#tel").removeAttr("disabled");
	$("#addr").removeAttr("disabled");
	$("#submit").css("display","");
}

$(function(){
    $yj = $('.YeJiHeader');
    $yj.find('.level').change(function(){
        $yj.find('.form').submit();
    });
});
