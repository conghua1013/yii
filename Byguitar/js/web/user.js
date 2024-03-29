﻿$(document).ready(function(){ 

	//绑定优惠券事件
	$('#bandcoupon-btn').click(function(){			  
		var sn = $('#input_name1').val();
		var this_hander = $(this);
		$.ajax({
			type: "POST",
			url: "/user/couponBand",
			dataType:"json",
			cache: false,
			data: "sn="+sn+"&m=" + Math.random(),
			success:function(re){
				if(re.status == 1){
					this_hander.prev().html('绑定成功').show();
					setTimeout("location.reload()",3000);
				}else if(re.status == 2){
					popdiv("#login_pop","570","auto",0.2);
				}else{
					this_hander.prev().html(re.msg).show();
				}
			},error:function(){
					return;
			}
		  });
	});	 
	
	//商品列表页喜欢按钮事件-将来放到common.js做为公共方法
	$('.del_like').live('click',function(){
		//$(this).removeClass('pinlike_on');
		var id = $(this).parent().parent().attr('pid');
		delLike(id);
		$(this).parent().parent().remove();
	});
	

	$('.manyi').click(function(){					   
		alert('获得id='+$(this).attr('id')+'参数，执行满意代码');		
	});

	
	$('.bumanyi').click(function(){	
		alert('获得id='+$(this).attr('id')+'参数，执行不满意代码');
				
	});

	$('.cancel_btn').click(function(){
		var orderSn = $('#orderInfo').attr('ordersn');
		cancel_order(orderSn);		
	});

	
	
	$('.uplbtn').live('click',function(){	
		$('.pingvar').val(0);
		$('.popbox').hide();
		$('#goodsid').val($(this).attr('pid'));
		popdiv("#upl_pop","500","auto",0.4);
				
	});
	
	$('#upl_btn').click(function(){	
		
		if($('#pltxt').val()=="")
		{
			$(this).next().removeClass().addClass('alert').html('请先填写评论内容');
		}
		else if($('#pltxt').val().length>500)
		{
			$(this).next().removeClass().addClass('alert').html('评论内容不能超过500个字符');
		}
								 
		alert('写入提交评论代码');
		
		
		var newplhtml='<ul class="fl uplbox" id="'+$('#goodsid').val()+'"><li>评论发表于 刚刚</li><li class="uwen">“'+$('#pltxt').val()+'”</li><li class="ustar"><div>商品星评：<span class="star s'+$('#pingvar').val()+'"></span></div></li><li><span class="fr gray delpl-btn" pid="'+$('#goodsid').val()+'">删除评论</span></li></ul>';
		$('#'+$('#goodsid').val()).replaceWith(newplhtml);		
		$('#pingvar').val(0);
		$('#goodsid').val('');	
		$('#pltxt').val('');
		
	});
	
	
	$('.delpl-btn').live('click',function(){
		
		
		if(confirm("确定删除此评论?")){
	
			var pid=$(this).attr('pid');
			var newplhtml='<ul class="fl uplbox" id="'+pid+'"><li>还未评论</li><li><div class="fl btn btn-primary uplbtn" pid="'+pid+'">发表评价</div></li></ul>';		
			$('#'+pid).replaceWith(newplhtml);		
			
			alert('删除评论ajax');
		}	
			
	});
	
	
	$('.addr_list').find('li').live({ mouseenter: function () {
			$(this).find('.addr_operate').fadeIn();	           
		}, mouseleave: function () {
			$(this).find('.addr_operate').fadeOut();	
		}
     });
	
	//设为默认地址
	$('.addr_set').live('click',function(){	
		$('#addr_list').find('li').removeClass('addr_on');		
		$(this).parent().parent().parent().addClass('addr_on');
		$(this).find("input[name='addr']").eq(0).attr('checked','checked');
		var addId = $(this).parent().parent().parent().attr('id');
		setDefaultAddress(addId);	
	});
	
	$('.addr_edit').live('click',function(){
			
			$('#new_addr_btn').html('编辑此地址');
			$('#addr_modify').find('span').html('编辑所选地址');
			
			
			$('#usaddrid').val($(this).parents('li').attr('id'));
			$('#usname').val($(this).parents('li').find('span').eq(0).find('b').html());
			$('#usmob').val($(this).parents('li').find('span').eq(1).html());
				
			
			if($(this).parents('li').hasClass('addr_on')){
				$('#isdefaultaddr').val(1);
			}
			
			var reginvalue=$(this).parents('li').find('span').eq(2).attr('id');
			reginvalue=reginvalue.split('-');
			showprovince(1,reginvalue[0]);
			showCity(reginvalue[0],reginvalue[1]);
			showArea(reginvalue[1],reginvalue[2]);
			$('#usaddr').val($(this).parents('li').find('span').eq(3).html());	

			var addr_id=$('#usaddrid').val();
			saveAddress(addr_id);//保存修改或新添加的内容
	});
	
	//删除地址操作
	$('.addr_del').live('click',function(){	
		if(confirm("确定删除此地址?")){
			var addId = $(this).parent().parent().parent().attr('id');
			delAddress(addId)
			$(this).parent().parent().parent().remove();
		}	
	});
	
	//使用新地址点击的显示与隐藏事件
	$('#addr_modify').click(function(){  
		$('#addnewaddrs').toggle();
		//alert('验证通过写入ajax提交表单代码');
	});	
		
	//添加新地址按钮事件	
	$('#new_addr_btn').click(function(){
		if(checkaddr())			  
		{	
			//判断地址个数
			if($('#addr_list').find('li').length>=6){
				$(this).next().addClass('alert').html("最多只能保存6个地址！");
				return;
			}

			var addr_id=$('#usaddrid').val();
			var resData = ''
			resData = saveAddress(addr_id);//保存修改或新添加的内容

			//alert('验证通过写入ajax提交表单代码');
			//以下代码需要放在ajax的success里执行
			//地区的代号值->$('#usprovince').val(),$('#uscity').val(),$('#usdistrict').val()
			//return;
			addr_name=$('#usname').val();
			addr_mob=$('#usmob').val();
			addr_region=[$('#usprovince').find("option:selected").text(),$('#uscity').find("option:selected").text(),$('#usdistrict').find("option:selected").text()].join("-");
			addr_regionvalue=[$('#usprovince').val(),$('#uscity').val(),$('#usdistrict').val()].join("-");
			addr_addrs=$('#usaddr').val();
			addr_isdefault= $('#isdefaultaddr').val()=='1' ? 'class="addr_on"':'';	
			
						
			if(addr_id==""){
				//添加新地址的ajax接口
				//$('#addr_list').find('li').removeClass('addr_on');
				var newaddhtml='<li '+addr_isdefault+' id="23434444444"><div><input checked="checked" type="radio" name="addr" id="addr_s'+addr_id+'" value="'+addr_id+'" /><p><span><b>'+addr_name+'</b></span><span>'+addr_mob+'</span></p><p><span id="'+addr_regionvalue+'">'+addr_region+'</span><span>'+addr_addrs+'</span></p><p class="addr_operate"><b class="qing addr_set">设为默认</b><b class="qing addr_edit">编辑</b><b class="brown  addr_del">删除</b></p></div></li>';
				$('#addr_list').prepend(newaddhtml);			
			}else{
				//编辑地址的ajax接口
				var newaddhtml='<li '+addr_isdefault+' id="'+addr_id+'"><div><input checked="checked" type="radio" name="addr" id="addr_s'+addr_id+'" value="'+addr_id+'" /><p><span><b>'+addr_name+'</b></span><span>'+addr_mob+'</span></p><p><span id="'+addr_regionvalue+'">'+addr_region+'</span><span>'+addr_addrs+'</span></p><p class="addr_operate"><b class="qing addr_set">设为默认</b><b class="qing addr_edit">编辑</b><b class="brown  addr_del">删除</b></p></div></li>';
				$('#'+addr_id).replaceWith(newaddhtml);
				$('#addr_btn').html('添加新地址');
				$('#addr_modify').find('span').html('添加新地址');
				 
			}

			$('#usaddrid').val('');
			$('#isdefaultaddr').val(0);
			$('#usname').val('');
			$('#usmob').val('');
			$('#usprovince').val(0);  
			$('#uscity').val(0);
			$('#usdistrict').val(0);
			$('#usaddr').val('');
		}
	});

	$('.combin_img').hover(function(){											  
	$(this).parent().next().find('.packed_list').show();	
	$(this).parent().next().find('.packed_list').width($(this).parent().next().find('ul').length*$(this).parent().next().find('.packed_ul').width()+($(this).parent().next().find('.add').length*50));								
	$(this).parent().next().find('.packed_list').height($(this).parent().next().find('.packed_ul').height()+15);	
	}, function(){											  
	$(this).parent().next().find('.packed_list').hide();	
	});
	
	$('.packed').hover(function(){		
	$(this).find('.packed_list').show();
	$(this).find('.packed_list').width($(this).find('ul').length*$(this).find('.packed_ul').width()+($(this).find('.add').length*50));								
	$(this).find('.packed_list').height($(this).find('.packed_ul').height()+15);		
	}, function(){											  
	$(this).find('.packed_list').hide();	
	});

	
	var pingarr=['','很不满意','不满意','一般','满意','很满意'];

	 $('.starp').find('a').hover(function(){	
		$(this).parent().removeClass();
		$(this).parent().addClass('starp');
		$(this).parent().addClass('star');
		$(this).parent().addClass('stars'+$(this).parent().find('.pingvar').eq(0).val());
		$(this).parent().addClass('s'+($(this).index()+1));
		$(this).parent().find('.pingarr').eq(0).html(pingarr[$(this).index()+1]);		
	}, function(){	
		{
		$(this).parent().removeClass();
		$(this).parent().addClass('starp');
		$(this).parent().addClass('star');
		$(this).parent().addClass('stars'+$(this).parent().find('.pingvar').eq(0).val());
		$(this).parent().find('.pingarr').eq(0).html(pingarr[$(this).index()+1]);		
		}	
	}); 
	$('.starp').find('a').click(function(){		
	$(this).parent().removeClass();
	$(this).parent().addClass('starp');
	$(this).parent().addClass('star');
	$(this).parent().addClass('s'+($(this).index()+1));
	$(this).parent().addClass('stars'+($(this).index()+1));
	$(this).parent().find('.pingvar').eq(0).val($(this).index()+1);
	});	
	
	$('.starp').hover(function(){							   
	}, function(){
		if($(this).find('.pingvar').eq(0).val()!='0')
		{
		if($(this).hasClass('stars'+$(this).find('.pingvar').eq(0).val()))	
		{$(this).addClass('s'+$(this).find('.pingvar').eq(0).val());
		$(this).find('.pingarr').eq(0).html(pingarr[$(this).find('.pingvar').eq(0).val()]);
		}
		}
		else
		{
			$(this).find('.pingarr').eq(0).html('');
		}
	});	





	if($("#province").length>0){
	//-出始化年
	var dDate = new Date();
	var dCurYear = dDate.getFullYear();
	var str="";
	for(var i=dCurYear-60;i<dCurYear-5;i++)
	{
		  if(i==dCurYear)
		  {
		  str="<option value="+i+" selected=true>"+i+"</option>";
		  }else{
		  str="<option value="+i+">"+i+"</option>";
	   }
		  $("#year").append(str);
	}
   
	   //出始化月
	for(var i=1;i<=12;i++)
	{
	   
		//if(i==(dDate.getMonth()+1))
		//{
		//	 str="<option value="+i+" selected=true>"+i+"</option>";
		//}else{
		  str="<option value="+i+">"+i+"</option>";
		//}
		$("#month").append(str);
	}
	
	//调用函数出始化日
	TUpdateCal($("#year").val(),$("#month").val());
	
	$("#year").change(function(){	
		TUpdateCal($(this).val(),$("#month").val());  
	});         
     
	$("#month").change(function(){	
		TUpdateCal($("#year").val(),$(this).val());
	});
	
	getProvinces();
	if($("#province1").val()!="")
		{
			$("#province").append("<option value="+$("#province1").val()+" selected=true>"+$("#province1").val()+"</option>");
		}
		if($("#city1").val()!="")
		{
			$("#city").append("<option value="+$("#city1").val()+" selected=true>"+$("#city1").val()+"</option>");
		}
		if($("#county1").val()!="")
		{
			$("#county").append("<option value="+$("#county1").val()+" selected=true>"+$("#county1").val()+"</option>");
		}
		
	$("#province").live('change',function(){	
		getCities();
		
	});
	$("#city").live('change',function(){	
		getCounties();
	});

	}

	if($("#delmails").length>0){

		$('#delmails').click(function(){
			var pmid=[],removeline=[];
			$('.mailtab_tr').find("input[type='checkbox']").each(function(){
			if($(this).attr("checked") == 'checked'){
			    pmid.push($(this).val());
			    removeline.push('#mailine'+$(this).val());
			}
			});
			pmid=pmid.join(',');
			$.ajax({
			   type: "post",
			   url: "/user/maildelmore",
			   data: 'pmid=' + pmid,
			   dataType: 'json',
			   success:function(msg){
			   
			    if ( msg.status == 0 ){
			        //错误
			        alert(msg.info);

			    }          
			    else{
					// 成功 
					alert(msg.info); 
			        $.each(removeline,function(key,val){
			        	$(val).slideUp(500,function(){
			        		$(val).remove();
			        	});
			        });   
			    }
			   
			   }
			});
		});

		// 全选
		$("#allselmail").click(function(){
		$('.mailtab').find("input[type='checkbox']").attr('checked', $(this).is(':checked'));   
		});

		$('.maillink').click(function(){
			$(this).removeClass('qing');  
			$(this).parents('tr').removeClass('mailtab_on');
		});

	}

	if($('#mailto_btn').length>0){

		$('#mailto_btn').click(function(){
			var mailto =$('#mailto');
			var mailsub =$('#mailsub');
			var mailtxt =$('#mailtxt');
			if(mailto.val() =="")
			{		
				mailto.parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");
				mailto.select();
				mailto.focus();
		        return false;
			}    
			var filter=/^[\u4e00-\u9fa5a-zA-Z0-9_]+$/;
		    if (!filter.test(mailto.val())) 
			{ 
				mailto.parents('td').next().find("span").removeClass().addClass('alert_txt').html("格式有误<b></b>");
				mailto.select();
				mailto.focus();
		        return false; 
		   	}

		   	if(mailsub.val() ==""){
		   		mailsub.parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");
		   		mailsub.select();
				mailsub.focus();
		   		return false; 
		   	}


		   	if(mailtxt.val() ==""){
		   		mailtxt.parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");
		   		mailtxt.select();
				mailtxt.focus();
		   		return false; 
		   	}

		   	if(mailtxt.val().length>=500){
		   		mailtxt.parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能超过500个字符<b></b>");
		   		mailtxt.select();
				mailtxt.focus();
		   		return false; 
		   	}
		   	$('#formSend').submit();

		});
	}


	$('#receiveBtn').click(function(){
		var data = 'orderSn='+ $('#orderInfo').attr('orderSn');
		$.ajax({
			type: "POST",
			url: "/user/receivedOrder",
			dataType:"json",
			cache: false,
			data: data+"&ajax=1&m=" + Math.random(),
			success:function(re){
				if(re.status == 1) {
					location.reload();
				}else if(re.status == 2){
					popdiv("#login_pop","570","auto",0.2);
				}else{
					alert(re.msg +' 请联系客服处理！');
				}
			},error:function(){
					return;
			}
		});
	})
	

});


function saveAddress(id){
	var data =  "usname="+$('#usname').val()+
				"&usmob="+$('#usmob').val()+
				"&usprovince="+$('#usprovince').val()+
				"&uscity="+$('#uscity').val()+
				"&usdistrict="+$('#usdistrict').val()+
				"&usaddr="+$('#usaddr').val()+
				"&id="+id;
	var resData = '';
	$.ajax({
		type: "POST",
		url: "/user/saveAddress",
		dataType:"json",
		cache: false,
		data: data+"&ajax=1&m=" + Math.random(),
		success:function(re){
			resData = re;
		},error:function(){
				return;
		}
	});
	return resData;
}


function delAddress(id){
	var data ="id="+id;
	var resData = '';
	$.ajax({
		type: "POST",
		url: "/user/delAddress",
		dataType:"json",
		cache: false,
		data: data+"&ajax=1&m=" + Math.random(),
		success:function(re){
			resData = re;
		},error:function(){
				return;
		}
	});
	return true;
}


function setDefaultAddress(id){
	var data ="id="+id;
	var resData = '';
	$.ajax({
		type: "POST",
		url: "/user/setDefaultAddress",
		dataType:"json",
		cache: false,
		data: data+"&ajax=1&m=" + Math.random(),
		success:function(re){
			resData = re;
		},error:function(){
				return;
		}
	});
	return true;

}







function TGetDaysInMonth(iMonth, iYear) {
	var dPrevDate = new Date(iYear, iMonth, 0);
	return dPrevDate.getDate();
}

function TUpdateCal(iYear, iMonth) {
	var dDate=new Date();
	daysInMonth = TGetDaysInMonth(iMonth, iYear);
	$("#day").empty();
	for (d = 1; d <= parseInt(daysInMonth); d++) {
	
	if(d==dDate.getDate())
	{
	   str="<option value="+d+" selected=true>"+d+"</option>";
	}else{
		   str="<option value="+d+">"+d+"</option>";
	}
	$("#day").append(str);
	}
}

//地区联动
var provinces = new Array('北京市','上海市','云南省','内蒙古自治区','台湾省','吉林省','四川省','天津市','宁夏回族自治区','安徽省','山东省','山西省','广东省','广西壮族自治区','新疆维吾尔自治区','江苏省','江西省','河北省','河南省','浙江省','海南省','湖北省','湖南省','澳门特别行政区','甘肃省','福建省','西藏自治区','贵州省','辽宁省','重庆市','陕西省','青海省','香港特别行政区','黑龙江省');
var cities = new Array(34);
cities[0] = new Array('市辖区','县');
cities[1] = new Array('市辖区','县');
cities[2] = new Array('临沧市','丽江市','保山市','大理白族自治州','德宏傣族景颇族自治州','怒江傈僳族自治州','文山壮族苗族自治州','昆明市','昭通市','普洱市','曲靖市','楚雄彝族自治州','玉溪市','红河哈尼族彝族自治州','西双版纳傣族自治州','迪庆藏族自治州');
cities[3] = new Array('乌兰察布市','乌海市','兴安盟','包头市','呼伦贝尔市','呼和浩特市','巴彦淖尔市','赤峰市','通辽市','鄂尔多斯市','锡林郭勒盟','阿拉善盟');
cities[4] = new Array();
cities[5] = new Array('吉林市','四平市','延边朝鲜族自治州','松原市','白城市','白山市','辽源市','通化市','长春市');
cities[6] = new Array('乐山市','内江市','凉山彝族自治州','南充市','宜宾市','巴中市','广元市','广安市','德阳市','成都市','攀枝花市','泸州市','甘孜藏族自治州','眉山市','绵阳市','自贡市','资阳市','达州市','遂宁市','阿坝藏族羌族自治州','雅安市');
cities[7] = new Array('市辖区','县');
cities[8] = new Array('中卫市','吴忠市','固原市','石嘴山市','银川市');
cities[9] = new Array('亳州市','六安市','合肥市','安庆市','宣城市','宿州市','巢湖市','池州市','淮北市','淮南市','滁州市','芜湖市','蚌埠市','铜陵市','阜阳市','马鞍山市','黄山市');
cities[10] = new Array('东营市','临沂市','威海市','德州市','日照市','枣庄市','泰安市','济南市','济宁市','淄博市','滨州市','潍坊市','烟台市','聊城市','莱芜市','菏泽市','青岛市');
cities[11] = new Array('临汾市','吕梁市','大同市','太原市','忻州市','晋中市','晋城市','朔州市','运城市','长治市','阳泉市');
cities[12] = new Array('东莞市','中山市','云浮市','佛山市','广州市','惠州市','揭阳市','梅州市','汕头市','汕尾市','江门市','河源市','深圳市','清远市','湛江市','潮州市','珠海市','肇庆市','茂名市','阳江市','韶关市');
cities[13] = new Array('北海市','南宁市','崇左市','来宾市','柳州市','桂林市','梧州市','河池市','玉林市','百色市','贵港市','贺州市','钦州市','防城港市');
cities[14] = new Array('乌鲁木齐市','伊犁哈萨克自治州','克孜勒苏柯尔克孜自治州','克拉玛依市','博尔塔拉蒙古自治州','吐鲁番地区','和田地区','哈密地区','喀什地区','塔城地区','巴音郭楞蒙古自治州','昌吉回族自治州','自治区直辖县级行政单位','阿克苏地区','阿勒泰地区');
cities[15] = new Array('南京市','南通市','宿迁市','常州市','徐州市','扬州市','无锡市','泰州市','淮安市','盐城市','苏州市','连云港市','镇江市');
cities[16] = new Array('上饶市','九江市','南昌市','吉安市','宜春市','抚州市','新余市','景德镇市','萍乡市','赣州市','鹰潭市');
cities[17] = new Array('保定市','唐山市','廊坊市','张家口市','承德市','沧州市','石家庄市','秦皇岛市','衡水市','邢台市','邯郸市');
cities[18] = new Array('三门峡市','信阳市','南阳市','周口市','商丘市','安阳市','平顶山市','开封市','新乡市','洛阳市','漯河市','濮阳市','焦作市','许昌市','郑州市','驻马店市','鹤壁市');
cities[19] = new Array('丽水市','台州市','嘉兴市','宁波市','杭州市','温州市','湖州市','绍兴市','舟山市','衢州市','金华市');
cities[20] = new Array('三亚市','海口市','省直辖县级行政单位');
cities[21] = new Array('十堰市','咸宁市','孝感市','宜昌市','恩施土家族苗族自治州','武汉市','省直辖县级行政单位','荆州市','荆门市','襄樊市','鄂州市','随州市','黄冈市','黄石市');
cities[22] = new Array('娄底市','岳阳市','常德市','张家界市','怀化市','株洲市','永州市','湘潭市','湘西土家族苗族自治州','益阳市','衡阳市','邵阳市','郴州市','长沙市');
cities[23] = new Array();
cities[24] = new Array('临夏回族自治州','兰州市','嘉峪关市','天水市','定西市','平凉市','庆阳市','张掖市','武威市','甘南藏族自治州','白银市','酒泉市','金昌市','陇南市');
cities[25] = new Array('三明市','南平市','厦门市','宁德市','泉州市','漳州市','福州市','莆田市','龙岩市');
cities[26] = new Array('山南地区','拉萨市','日喀则地区','昌都地区','林芝地区','那曲地区','阿里地区');
cities[27] = new Array('六盘水市','安顺市','毕节地区','贵阳市','遵义市','铜仁地区','黔东南苗族侗族自治州','黔南布依族苗族自治州','黔西南布依族苗族自治州');
cities[28] = new Array('丹东市','大连市','抚顺市','朝阳市','本溪市','沈阳市','盘锦市','营口市','葫芦岛市','辽阳市','铁岭市','锦州市','阜新市','鞍山市');
cities[29] = new Array('市辖区','县');
cities[30] = new Array('咸阳市','商洛市','安康市','宝鸡市','延安市','榆林市','汉中市','渭南市','西安市','铜川市');
cities[31] = new Array('果洛藏族自治州','海东地区','海北藏族自治州','海南藏族自治州','海西蒙古族藏族自治州','玉树藏族自治州','西宁市','黄南藏族自治州');
cities[32] = new Array();
cities[33] = new Array('七台河市','伊春市','佳木斯市','双鸭山市','哈尔滨市','大兴安岭地区','大庆市','牡丹江市','绥化市','鸡西市','鹤岗市','黑河市','齐齐哈尔市');
var counties = new Array(34);
counties[0] = new Array(2);
counties[1] = new Array(2);
counties[2] = new Array(16);
counties[3] = new Array(12);
counties[4] = new Array();
counties[5] = new Array(9);
counties[6] = new Array(21);
counties[7] = new Array(2);
counties[8] = new Array(5);
counties[9] = new Array(17);
counties[10] = new Array(17);
counties[11] = new Array(11);
counties[12] = new Array(21);
counties[13] = new Array(14);
counties[14] = new Array(15);
counties[15] = new Array(13);
counties[16] = new Array(11);
counties[17] = new Array(11);
counties[18] = new Array(17);
counties[19] = new Array(11);
counties[20] = new Array(3);
counties[21] = new Array(14);
counties[22] = new Array(14);
counties[23] = new Array();
counties[24] = new Array(14);
counties[25] = new Array(9);
counties[26] = new Array(7);
counties[27] = new Array(9);
counties[28] = new Array(14);
counties[29] = new Array(2);
counties[30] = new Array(10);
counties[31] = new Array(8);
counties[32] = new Array();
counties[33] = new Array(13);
counties[0][0] = new Array('东城区','丰台区','大兴区','宣武区','崇文区','平谷区','怀柔区','房山区','昌平区','朝阳区','海淀区','石景山区','西城区','通州区','门头沟区','顺义区');
counties[0][1] = new Array('密云县','延庆县');
counties[1][0] = new Array('南汇区','卢湾区','嘉定区','奉贤区','宝山区','徐汇区','普陀区','杨浦区','松江区','浦东新区','虹口区','金山区','长宁区','闵行区','闸北区','青浦区','静安区','黄浦区');
counties[1][1] = new Array('崇明县');
counties[2][0] = new Array('云县','凤庆县','双江拉祜族佤族布朗族傣族自治县','市辖区','永德县','沧源佤族自治县','耿马傣族佤族自治县','镇康县');
counties[2][1] = new Array('华坪县','宁蒗彝族自治县','市辖区','永胜县','玉龙纳西族自治县');
counties[2][2] = new Array('市辖区','施甸县','昌宁县','腾冲县','龙陵县');
counties[2][3] = new Array('云龙县','剑川县','南涧彝族自治县','大理市','宾川县','巍山彝族回族自治县','弥渡县','永平县','洱源县','漾濞彝族自治县','祥云县','鹤庆县');
counties[2][4] = new Array('梁河县','潞西市','瑞丽市','盈江县','陇川县');
counties[2][5] = new Array('兰坪白族普米族自治县','泸水县','福贡县','贡山独龙族怒族自治县');
counties[2][6] = new Array('丘北县','富宁县','广南县','文山县','砚山县','西畴县','马关县','麻栗坡县');
counties[2][7] = new Array('呈贡县','安宁市','宜良县','富民县','寻甸回族彝族自治县','嵩明县','市辖区','晋宁县','石林彝族自治县','禄劝彝族苗族自治县');
counties[2][8] = new Array('大关县','威信县','巧家县','市辖区','彝良县','水富县','永善县','盐津县','绥江县','镇雄县','鲁甸县');
counties[2][9] = new Array('墨江哈尼族自治县','孟连傣族拉祜族佤族自治县','宁洱哈尼族彝族自治县','市辖区','景东彝族自治县','景谷傣族彝族自治县','江城哈尼族彝族自治县','澜沧拉祜族自治县','西盟佤族自治县','镇沅彝族哈尼族拉祜族自治县');
counties[2][10] = new Array('会泽县','宣威市','富源县','市辖区','师宗县','沾益县','罗平县','陆良县','马龙县');
counties[2][11] = new Array('元谋县','南华县','双柏县','大姚县','姚安县','楚雄市','武定县','永仁县','牟定县','禄丰县');
counties[2][12] = new Array('元江哈尼族彝族傣族自治县','华宁县','峨山彝族自治县','市辖区','新平彝族傣族自治县','易门县','江川县','澄江县','通海县');
counties[2][13] = new Array('个旧市','元阳县','屏边苗族自治县','建水县','开远市','弥勒县','河口瑶族自治县','泸西县','石屏县','红河县','绿春县','蒙自县','金平苗族瑶族傣族自治县');
counties[2][14] = new Array('勐海县','勐腊县','景洪市');
counties[2][15] = new Array('德钦县','维西傈僳族自治县','香格里拉县');
counties[3][0] = new Array('丰镇市','兴和县','凉城县','化德县','卓资县','商都县','四子王旗','察哈尔右翼中旗','察哈尔右翼前旗','察哈尔右翼后旗','市辖区');
counties[3][1] = new Array('市辖区');
counties[3][2] = new Array('乌兰浩特市','扎赉特旗','科尔沁右翼中旗','科尔沁右翼前旗','突泉县','阿尔山市');
counties[3][3] = new Array('固阳县','土默特右旗','市辖区','达尔罕茂明安联合旗');
counties[3][4] = new Array('市辖区','扎兰屯市','新巴尔虎右旗','新巴尔虎左旗','根河市','满洲里市','牙克石市','莫力达瓦达斡尔族自治旗','鄂伦春自治旗','鄂温克族自治旗','阿荣旗','陈巴尔虎旗','额尔古纳市');
counties[3][5] = new Array('和林格尔县','土默特左旗','市辖区','托克托县','武川县','清水河县');
counties[3][6] = new Array('乌拉特中旗','乌拉特前旗','乌拉特后旗','五原县','市辖区','杭锦后旗','磴口县');
counties[3][7] = new Array('克什克腾旗','喀喇沁旗','宁城县','巴林右旗','巴林左旗','市辖区','敖汉旗','林西县','翁牛特旗','阿鲁科尔沁旗');
counties[3][8] = new Array('奈曼旗','市辖区','库伦旗','开鲁县','扎鲁特旗','科尔沁左翼中旗','科尔沁左翼后旗','霍林郭勒市');
counties[3][9] = new Array('乌审旗','伊金霍洛旗','准格尔旗','市辖区','杭锦旗','达拉特旗','鄂托克前旗','鄂托克旗');
counties[3][10] = new Array('东乌珠穆沁旗','二连浩特市','多伦县','太仆寺旗','正蓝旗','正镶白旗','苏尼特右旗','苏尼特左旗','西乌珠穆沁旗','锡林浩特市','镶黄旗','阿巴嘎旗');
counties[3][11] = new Array('阿拉善右旗','阿拉善左旗','额济纳旗');
counties[5][0] = new Array('市辖区','桦甸市','永吉县','磐石市','舒兰市','蛟河市');
counties[5][1] = new Array('伊通满族自治县','公主岭市','双辽市','市辖区','梨树县');
counties[5][2] = new Array('和龙市','图们市','安图县','延吉市','敦化市','汪清县','珲春市','龙井市');
counties[5][3] = new Array('乾安县','前郭尔罗斯蒙古族自治县','市辖区','扶余县','长岭县');
counties[5][4] = new Array('大安市','市辖区','洮南市','通榆县','镇赉县');
counties[5][5] = new Array('临江市','市辖区','抚松县','长白朝鲜族自治县','靖宇县');
counties[5][6] = new Array('东丰县','东辽县','市辖区');
counties[5][7] = new Array('市辖区','柳河县','梅河口市','辉南县','通化县','集安市');
counties[5][8] = new Array('九台市','农安县','市辖区','德惠市','榆树市');
counties[6][0] = new Array('井研县','夹江县','峨眉山市','峨边彝族自治县','市辖区','沐川县','犍为县','马边彝族自治县');
counties[6][1] = new Array('威远县','市辖区','资中县','隆昌县');
counties[6][2] = new Array('会东县','会理县','冕宁县','喜德县','宁南县','布拖县','德昌县','昭觉县','普格县','木里藏族自治县','甘洛县','盐源县','美姑县','西昌市','越西县','金阳县','雷波县');
counties[6][3] = new Array('仪陇县','南部县','市辖区','营山县','蓬安县','西充县','阆中市');
counties[6][4] = new Array('兴文县','南溪县','宜宾县','屏山县','市辖区','江安县','珙县','筠连县','长宁县','高县');
counties[6][5] = new Array('南江县','市辖区','平昌县','通江县');
counties[6][6] = new Array('剑阁县','市辖区','旺苍县','苍溪县','青川县');
counties[6][7] = new Array('华蓥市','岳池县','市辖区','武胜县','邻水县');
counties[6][8] = new Array('中江县','什邡市','市辖区','广汉市','绵竹市','罗江县');
counties[6][9] = new Array('双流县','大邑县','崇州市','市辖区','彭州市','新津县','蒲江县','邛崃市','郫县','都江堰市','金堂县');
counties[6][10] = new Array('市辖区','盐边县','米易县');
counties[6][11] = new Array('叙永县','古蔺县','合江县','市辖区','泸县');
counties[6][12] = new Array('丹巴县','九龙县','乡城县','巴塘县','康定县','得荣县','德格县','新龙县','泸定县','炉霍县','理塘县','甘孜县','白玉县','石渠县','稻城县','色达县','道孚县','雅江县');
counties[6][13] = new Array('丹棱县','仁寿县','市辖区','彭山县','洪雅县','青神县');
counties[6][14] = new Array('三台县','北川羌族自治县','安县','市辖区','平武县','梓潼县','江油市','盐亭县');
counties[6][15] = new Array('富顺县','市辖区','荣县');
counties[6][16] = new Array('乐至县','安岳县','市辖区','简阳市');
counties[6][17] = new Array('万源市','大竹县','宣汉县','市辖区','开江县','渠县','达县');
counties[6][18] = new Array('大英县','射洪县','市辖区','蓬溪县');
counties[6][19] = new Array('九寨沟县','壤塘县','小金县','松潘县','汶川县','理县','红原县','若尔盖县','茂县','金川县','阿坝县','马尔康县','黑水县');
counties[6][20] = new Array('名山县','天全县','宝兴县','市辖区','汉源县','石棉县','芦山县','荥经县');
counties[7][0] = new Array('东丽区','北辰区','南开区','和平区','塘沽区','大港区','宝坻区','武清区','汉沽区','河东区','河北区','河西区','津南区','红桥区','西青区');
counties[7][1] = new Array('宁河县','蓟县','静海县');
counties[8][0] = new Array('中宁县','市辖区','海原县');
counties[8][1] = new Array('同心县','市辖区','盐池县','青铜峡市');
counties[8][2] = new Array('市辖区','彭阳县','泾源县','西吉县','隆德县');
counties[8][3] = new Array('市辖区','平罗县');
counties[8][4] = new Array('市辖区','永宁县','灵武市','贺兰县');
counties[9][0] = new Array('利辛县','市辖区','涡阳县','蒙城县');
counties[9][1] = new Array('寿县','市辖区','舒城县','金寨县','霍山县','霍邱县');
counties[9][2] = new Array('市辖区','肥东县','肥西县','长丰县');
counties[9][3] = new Array('太湖县','宿松县','岳西县','市辖区','怀宁县','望江县','枞阳县','桐城市','潜山县');
counties[9][4] = new Array('宁国市','市辖区','广德县','旌德县','泾县','绩溪县','郎溪县');
counties[9][5] = new Array('市辖区','泗县','灵璧县','砀山县','萧县');
counties[9][6] = new Array('含山县','和县','市辖区','庐江县','无为县');
counties[9][7] = new Array('东至县','市辖区','石台县','青阳县');
counties[9][8] = new Array('市辖区','濉溪县');
counties[9][9] = new Array('凤台县','市辖区');
counties[9][10] = new Array('全椒县','凤阳县','天长市','定远县','市辖区','明光市','来安县');
counties[9][11] = new Array('南陵县','市辖区','繁昌县','芜湖县');
counties[9][12] = new Array('五河县','固镇县','市辖区','怀远县');
counties[9][13] = new Array('市辖区','铜陵县');
counties[9][14] = new Array('临泉县','太和县','市辖区','界首市','阜南县','颍上县');
counties[9][15] = new Array('市辖区','当涂县');
counties[9][16] = new Array('休宁县','市辖区','歙县','祁门县','黟县');
counties[10][0] = new Array('利津县','垦利县','市辖区','广饶县');
counties[10][1] = new Array('临沭县','市辖区','平邑县','沂南县','沂水县','苍山县','莒南县','蒙阴县','费县','郯城县');
counties[10][2] = new Array('乳山市','市辖区','文登市','荣成市');
counties[10][3] = new Array('临邑县','乐陵市','夏津县','宁津县','市辖区','平原县','庆云县','武城县','禹城市','陵县','齐河县');
counties[10][4] = new Array('五莲县','市辖区','莒县');
counties[10][5] = new Array('市辖区','滕州市');
counties[10][6] = new Array('东平县','宁阳县','市辖区','新泰市','肥城市');
counties[10][7] = new Array('商河县','市辖区','平阴县','济阳县','章丘市');
counties[10][8] = new Array('兖州市','嘉祥县','市辖区','微山县','曲阜市','梁山县','汶上县','泗水县','邹城市','金乡县','鱼台县');
counties[10][9] = new Array('市辖区','桓台县','沂源县','高青县');
counties[10][10] = new Array('博兴县','市辖区','惠民县','无棣县','沾化县','邹平县','阳信县');
counties[10][11] = new Array('临朐县','安丘市','寿光市','市辖区','昌乐县','昌邑市','诸城市','青州市','高密市');
counties[10][12] = new Array('市辖区','招远市','栖霞市','海阳市','莱州市','莱阳市','蓬莱市','长岛县','龙口市');
counties[10][13] = new Array('东阿县','临清市','冠县','市辖区','茌平县','莘县','阳谷县','高唐县');
counties[10][14] = new Array('市辖区');
counties[10][15] = new Array('东明县','单县','定陶县','巨野县','市辖区','成武县','曹县','郓城县','鄄城县');
counties[10][16] = new Array('即墨市','市辖区','平度市','胶南市','胶州市','莱西市');
counties[11][0] = new Array('乡宁县','侯马市','古县','吉县','大宁县','安泽县','市辖区','曲沃县','永和县','汾西县','洪洞县','浮山县','翼城县','蒲县','襄汾县','隰县','霍州市');
counties[11][1] = new Array('中阳县','临县','交口县','交城县','兴县','孝义市','岚县','市辖区','文水县','方山县','柳林县','汾阳市','石楼县');
counties[11][2] = new Array('大同县','天镇县','左云县','市辖区','广灵县','浑源县','灵丘县','阳高县');
counties[11][3] = new Array('古交市','娄烦县','市辖区','清徐县','阳曲县');
counties[11][4] = new Array('五台县','五寨县','代县','保德县','偏关县','原平市','宁武县','定襄县','岢岚县','市辖区','河曲县','神池县','繁峙县','静乐县');
counties[11][5] = new Array('介休市','和顺县','太谷县','寿阳县','左权县','市辖区','平遥县','昔阳县','榆社县','灵石县','祁县');
counties[11][6] = new Array('市辖区','沁水县','泽州县','阳城县','陵川县','高平市');
counties[11][7] = new Array('右玉县','山阴县','市辖区','应县','怀仁县');
counties[11][8] = new Array('万荣县','临猗县','垣曲县','夏县','市辖区','平陆县','新绛县','永济市','河津市','稷山县','绛县','芮城县','闻喜县');
counties[11][9] = new Array('壶关县','屯留县','市辖区','平顺县','武乡县','沁县','沁源县','潞城市','襄垣县','长子县','长治县','黎城县');
counties[11][10] = new Array('市辖区','平定县','盂县');
counties[12][0] = new Array();
counties[12][1] = new Array();
counties[12][2] = new Array('云安县','市辖区','新兴县','罗定市','郁南县');
counties[12][3] = new Array('市辖区');
counties[12][4] = new Array('从化市','增城市','市辖区');
counties[12][5] = new Array('博罗县','市辖区','惠东县','龙门县');
counties[12][6] = new Array('市辖区','惠来县','揭东县','揭西县','普宁市');
counties[12][7] = new Array('丰顺县','五华县','兴宁市','大埔县','市辖区','平远县','梅县','蕉岭县');
counties[12][8] = new Array('南澳县','市辖区');
counties[12][9] = new Array('市辖区','海丰县','陆丰市','陆河县');
counties[12][10] = new Array('台山市','市辖区','开平市','恩平市','鹤山市');
counties[12][11] = new Array('东源县','和平县','市辖区','紫金县','连平县','龙川县');
counties[12][12] = new Array('市辖区');
counties[12][13] = new Array('佛冈县','市辖区','清新县','英德市','连南瑶族自治县','连山壮族瑶族自治县','连州市','阳山县');
counties[12][14] = new Array('吴川市','市辖区','廉江市','徐闻县','遂溪县','雷州市');
counties[12][15] = new Array('市辖区','潮安县','饶平县');
counties[12][16] = new Array('市辖区');
counties[12][17] = new Array('四会市','封开县','市辖区','广宁县','德庆县','怀集县','高要市');
counties[12][18] = new Array('信宜市','化州市','市辖区','电白县','高州市');
counties[12][19] = new Array('市辖区','阳东县','阳春市','阳西县');
counties[12][20] = new Array('乐昌市','乳源瑶族自治县','仁化县','南雄市','始兴县','市辖区','新丰县','翁源县');
counties[13][0] = new Array('合浦县','市辖区');
counties[13][1] = new Array('上林县','宾阳县','市辖区','横县','武鸣县','隆安县','马山县');
counties[13][2] = new Array('凭祥市','大新县','天等县','宁明县','市辖区','扶绥县','龙州县');
counties[13][3] = new Array('合山市','市辖区','忻城县','武宣县','象州县','金秀瑶族自治县');
counties[13][4] = new Array('三江侗族自治县','市辖区','柳城县','柳江县','融安县','融水苗族自治县','鹿寨县');
counties[13][5] = new Array('临桂县','全州县','兴安县','市辖区','平乐县','恭城瑶族自治县','永福县','灌阳县','灵川县','荔蒲县','资源县','阳朔县','龙胜各族自治县');
counties[13][6] = new Array('岑溪市','市辖区','苍梧县','蒙山县','藤县');
counties[13][7] = new Array('东兰县','凤山县','南丹县','大化瑶族自治县','天峨县','宜州市','巴马瑶族自治县','市辖区','环江毛南族自治县','罗城仫佬族自治县','都安瑶族自治县');
counties[13][8] = new Array('兴业县','北流市','博白县','容县','市辖区','陆川县');
counties[13][9] = new Array('乐业县','凌云县','市辖区','平果县','德保县','田东县','田林县','田阳县','西林县','那坡县','隆林各族自治县','靖西县');
counties[13][10] = new Array('市辖区','平南县','桂平市');
counties[13][11] = new Array('富川瑶族自治县','市辖区','昭平县','钟山县');
counties[13][12] = new Array('市辖区','浦北县','灵山县');
counties[13][13] = new Array('上思县','东兴市','市辖区');
counties[14][0] = new Array('乌鲁木齐县','市辖区');
counties[14][1] = new Array('伊宁县','伊宁市','奎屯市','察布查尔锡伯自治县','尼勒克县','巩留县','新源县','昭苏县','特克斯县','霍城县');
counties[14][2] = new Array('乌恰县','阿克陶县','阿合奇县','阿图什市');
counties[14][3] = new Array('市辖区');
counties[14][4] = new Array('博乐市','温泉县','精河县');
counties[14][5] = new Array('吐鲁番市','托克逊县','鄯善县');
counties[14][6] = new Array('于田县','和田县','和田市','墨玉县','民丰县','洛浦县','皮山县','策勒县');
counties[14][7] = new Array('伊吾县','哈密市','巴里坤哈萨克自治县');
counties[14][8] = new Array('伽师县','叶城县','喀什市','塔什库尔干塔吉克自治县','岳普湖县','巴楚县','泽普县','疏勒县','疏附县','英吉沙县','莎车县','麦盖提县');
counties[14][9] = new Array('乌苏市','和布克赛尔蒙古自治县','塔城市','托里县','沙湾县','裕民县','额敏县');
counties[14][10] = new Array('且末县','博湖县','和硕县','和静县','尉犁县','库尔勒市','焉耆回族自治县','若羌县','轮台县');
counties[14][11] = new Array('吉木萨尔县','呼图壁县','奇台县','昌吉市','木垒哈萨克自治县','玛纳斯县','阜康市');
counties[14][12] = new Array('五家渠市','图木舒克市','石河子市','阿拉尔市');
counties[14][13] = new Array('乌什县','库车县','拜城县','新和县','柯坪县','沙雅县','温宿县','阿克苏市','阿瓦提县');
counties[14][14] = new Array('吉木乃县','哈巴河县','富蕴县','布尔津县','福海县','阿勒泰市','青河县');
counties[15][0] = new Array('市辖区','溧水县','高淳县');
counties[15][1] = new Array('启东市','如东县','如皋市','市辖区','海安县','海门市','通州市');
counties[15][2] = new Array('市辖区','沭阳县','泗洪县','泗阳县');
counties[15][3] = new Array('市辖区','溧阳市','金坛市');
counties[15][4] = new Array('丰县','市辖区','新沂市','沛县','睢宁县','邳州市','铜山县');
counties[15][5] = new Array('仪征市','宝应县','市辖区','江都市','高邮市');
counties[15][6] = new Array('宜兴市','市辖区','江阴市');
counties[15][7] = new Array('兴化市','姜堰市','市辖区','泰兴市','靖江市');
counties[15][8] = new Array('市辖区','洪泽县','涟水县','盱眙县','金湖县');
counties[15][9] = new Array('东台市','响水县','大丰市','射阳县','市辖区','建湖县','滨海县','阜宁县');
counties[15][10] = new Array('吴江市','太仓市','市辖区','常熟市','张家港市','昆山市');
counties[15][11] = new Array('东海县','市辖区','灌云县','灌南县','赣榆县');
counties[15][12] = new Array('丹阳市','句容市','市辖区','扬中市');
counties[16][0] = new Array('万年县','上饶县','余干县','婺源县','市辖区','广丰县','弋阳县','德兴市','横峰县','玉山县','鄱阳县','铅山县');
counties[16][1] = new Array('九江县','修水县','市辖区','彭泽县','德安县','星子县','武宁县','永修县','湖口县','瑞昌市','都昌县');
counties[16][2] = new Array('南昌县','安义县','市辖区','新建县','进贤县');
counties[16][3] = new Array('万安县','井冈山市','吉安县','吉水县','安福县','峡江县','市辖区','新干县','永丰县','永新县','泰和县','遂川县');
counties[16][4] = new Array('万载县','上高县','丰城市','奉新县','宜丰县','市辖区','樟树市','铜鼓县','靖安县','高安市');
counties[16][5] = new Array('东乡县','乐安县','南丰县','南城县','宜黄县','崇仁县','市辖区','广昌县','资溪县','金溪县','黎川县');
counties[16][6] = new Array('分宜县','市辖区');
counties[16][7] = new Array('乐平市','市辖区','浮梁县');
counties[16][8] = new Array('上栗县','市辖区','芦溪县','莲花县');
counties[16][9] = new Array('上犹县','于都县','会昌县','信丰县','全南县','兴国县','南康市','大余县','宁都县','安远县','定南县','寻乌县','崇义县','市辖区','瑞金市','石城县','赣县','龙南县');
counties[16][10] = new Array('余江县','市辖区','贵溪市');
counties[17][0] = new Array('博野县','唐县','安国市','安新县','定兴县','定州市','容城县','市辖区','徐水县','易县','曲阳县','望都县','涞水县','涞源县','涿州市','清苑县','满城县','蠡县','阜平县','雄县','顺平县','高碑店市','高阳县');
counties[17][1] = new Array('乐亭县','唐海县','市辖区','滦南县','滦县','玉田县','迁安市','迁西县','遵化市');
counties[17][2] = new Array('三河市','固安县','大厂回族自治县','大城县','市辖区','文安县','永清县','霸州市','香河县');
counties[17][3] = new Array('万全县','宣化县','尚义县','崇礼县','市辖区','康保县','张北县','怀安县','怀来县','沽源县','涿鹿县','蔚县','赤城县','阳原县');
counties[17][4] = new Array('丰宁满族自治县','兴隆县','围场满族蒙古族自治县','宽城满族自治县','市辖区','平泉县','承德县','滦平县','隆化县');
counties[17][5] = new Array('东光县','任丘市','南皮县','吴桥县','孟村回族自治县','市辖区','沧县','河间市','泊头市','海兴县','献县','盐山县','肃宁县','青县','黄骅市');
counties[17][6] = new Array('井陉县','元氏县','市辖区','平山县','新乐市','无极县','晋州市','栾城县','正定县','深泽县','灵寿县','藁城市','行唐县','赞皇县','赵县','辛集市','高邑县','鹿泉市');
counties[17][7] = new Array('卢龙县','市辖区','抚宁县','昌黎县','青龙满族自治县');
counties[17][8] = new Array('冀州市','安平县','市辖区','故城县','景县','枣强县','武强县','武邑县','深州市','阜城县','饶阳县');
counties[17][9] = new Array('临城县','临西县','任县','内丘县','南和县','南宫市','威县','宁晋县','巨鹿县','市辖区','平乡县','广宗县','新河县','柏乡县','沙河市','清河县','邢台县','隆尧县');
counties[17][10] = new Array('临漳县','大名县','市辖区','广平县','成安县','曲周县','武安市','永年县','涉县','磁县','肥乡县','邯郸县','邱县','馆陶县','魏县','鸡泽县');
counties[18][0] = new Array('义马市','卢氏县','市辖区','渑池县','灵宝市','陕县');
counties[18][1] = new Array('光山县','商城县','固始县','市辖区','息县','新县','淮滨县','潢川县','罗山县');
counties[18][2] = new Array('内乡县','南召县','唐河县','市辖区','新野县','方城县','桐柏县','淅川县','社旗县','西峡县','邓州市','镇平县');
counties[18][3] = new Array('商水县','太康县','市辖区','扶沟县','沈丘县','淮阳县','西华县','郸城县','项城市','鹿邑县');
counties[18][4] = new Array('夏邑县','宁陵县','市辖区','柘城县','民权县','永城市','睢县','虞城县');
counties[18][5] = new Array('内黄县','安阳县','市辖区','林州市','汤阴县','滑县');
counties[18][6] = new Array('叶县','宝丰县','市辖区','汝州市','舞钢市','郏县','鲁山县');
counties[18][7] = new Array('兰考县','尉氏县','市辖区','开封县','杞县','通许县');
counties[18][8] = new Array('卫辉市','原阳县','封丘县','市辖区','延津县','新乡县','获嘉县','辉县市','长垣县');
counties[18][9] = new Array('伊川县','偃师市','孟津县','宜阳县','嵩县','市辖区','新安县','栾川县','汝阳县','洛宁县');
counties[18][10] = new Array('临颍县','市辖区','舞阳县');
counties[18][11] = new Array('南乐县','台前县','市辖区','清丰县','濮阳县','范县');
counties[18][12] = new Array('修武县','博爱县','孟州市','市辖区','武陟县','沁阳市','济源市','温县');
counties[18][13] = new Array('市辖区','禹州市','襄城县','许昌县','鄢陵县','长葛市');
counties[18][14] = new Array('中牟县','巩义市','市辖区','新密市','新郑市','登封市','荥阳市');
counties[18][15] = new Array('上蔡县','市辖区','平舆县','新蔡县','正阳县','汝南县','泌阳县','确山县','西平县','遂平县');
counties[18][16] = new Array('市辖区','浚县','淇县');
counties[19][0] = new Array('云和县','市辖区','庆元县','景宁畲族自治县','松阳县','缙云县','遂昌县','青田县','龙泉市');
counties[19][1] = new Array('三门县','临海市','仙居县','天台县','市辖区','温岭市','玉环县');
counties[19][2] = new Array('嘉善县','市辖区','平湖市','桐乡市','海宁市','海盐县');
counties[19][3] = new Array('余姚市','奉化市','宁海县','市辖区','慈溪市','象山县');
counties[19][4] = new Array('临安市','富阳市','市辖区','建德市','桐庐县','淳安县');
counties[19][5] = new Array('乐清市','市辖区','平阳县','文成县','永嘉县','泰顺县','洞头县','瑞安市','苍南县');
counties[19][6] = new Array('安吉县','市辖区','德清县','长兴县');
counties[19][7] = new Array('上虞市','嵊州市','市辖区','新昌县','绍兴县','诸暨市');
counties[19][8] = new Array('岱山县','嵊泗县','市辖区');
counties[19][9] = new Array('市辖区','常山县','开化县','江山市','龙游县');
counties[19][10] = new Array('东阳市','义乌市','兰溪市','市辖区','武义县','永康市','浦江县','磐安县');
counties[20][0] = new Array('市辖区');
counties[20][1] = new Array('市辖区');
counties[20][2] = new Array('万宁市','东方市','中沙群岛的岛礁及其海域','临高县','乐东黎族自治县','五指山市','保亭黎族苗族自治县','儋州市','南沙群岛','定安县','屯昌县','文昌市','昌江黎族自治县','澄迈县','琼中黎族苗族自治县','琼海市','白沙黎族自治县','西沙群岛','陵水黎族自治县');
counties[21][0] = new Array('丹江口市','市辖区','房县','竹山县','竹溪县','郧县','郧西县');
counties[21][1] = new Array('嘉鱼县','崇阳县','市辖区','赤壁市','通城县','通山县');
counties[21][2] = new Array('云梦县','大悟县','孝昌县','安陆市','市辖区','应城市','汉川市');
counties[21][3] = new Array('五峰土家族自治县','兴山县','宜都市','市辖区','当阳市','枝江市','秭归县','远安县','长阳土家族自治县');
counties[21][4] = new Array('利川市','咸丰县','宣恩县','巴东县','建始县','恩施市','来凤县','鹤峰县');
counties[21][5] = new Array('市辖区');
counties[21][6] = new Array('仙桃市','天门市','潜江市','神农架林区');
counties[21][7] = new Array('公安县','市辖区','松滋市','江陵县','洪湖市','监利县','石首市');
counties[21][8] = new Array('京山县','市辖区','沙洋县','钟祥市');
counties[21][9] = new Array('保康县','南漳县','宜城市','市辖区','枣阳市','老河口市','谷城县');
counties[21][10] = new Array('市辖区');
counties[21][11] = new Array('市辖区','广水市');
counties[21][12] = new Array('团风县','市辖区','武穴市','浠水县','红安县','罗田县','英山县','蕲春县','麻城市','黄梅县');
counties[21][13] = new Array('大冶市','市辖区','阳新县');
counties[22][0] = new Array('冷水江市','双峰县','市辖区','新化县','涟源市');
counties[22][1] = new Array('临湘市','华容县','岳阳县','市辖区','平江县','汨罗市','湘阴县');
counties[22][2] = new Array('临澧县','安乡县','市辖区','桃源县','汉寿县','津市市','澧县','石门县');
counties[22][3] = new Array('市辖区','慈利县','桑植县');
counties[22][4] = new Array('中方县','会同县','市辖区','新晃侗族自治县','沅陵县','洪江市','溆浦县','芷江侗族自治县','辰溪县','通道侗族自治县','靖州苗族侗族自治县','麻阳苗族自治县');
counties[22][5] = new Array('市辖区','攸县','株洲县','炎陵县','茶陵县','醴陵市');
counties[22][6] = new Array('东安县','双牌县','宁远县','市辖区','新田县','江华瑶族自治县','江永县','祁阳县','蓝山县','道县');
counties[22][7] = new Array('市辖区','湘乡市','湘潭县','韶山市');
counties[22][8] = new Array('保靖县','凤凰县','古丈县','吉首市','永顺县','泸溪县','花垣县','龙山县');
counties[22][9] = new Array('南县','安化县','市辖区','桃江县','沅江市');
counties[22][10] = new Array('市辖区','常宁市','祁东县','耒阳市','衡东县','衡南县','衡山县','衡阳县');
counties[22][11] = new Array('城步苗族自治县','市辖区','新宁县','新邵县','武冈市','洞口县','绥宁县','邵东县','邵阳县','隆回县');
counties[22][12] = new Array('临武县','嘉禾县','安仁县','宜章县','市辖区','桂东县','桂阳县','永兴县','汝城县','资兴市');
counties[22][13] = new Array('宁乡县','市辖区','望城县','浏阳市','长沙县');
counties[24][0] = new Array('东乡族自治县','临夏县','临夏市','和政县','广河县','康乐县','永靖县','积石山保安族东乡族撒拉族自治县');
counties[24][1] = new Array('市辖区','榆中县','永登县','皋兰县');
counties[24][2] = new Array('市辖区');
counties[24][3] = new Array('市辖区','张家川回族自治县','武山县','清水县','甘谷县','秦安县');
counties[24][4] = new Array('临洮县','岷县','市辖区','渭源县','漳县','通渭县','陇西县');
counties[24][5] = new Array('华亭县','崇信县','市辖区','庄浪县','泾川县','灵台县','静宁县');
counties[24][6] = new Array('华池县','合水县','宁县','市辖区','庆城县','正宁县','环县','镇原县');
counties[24][7] = new Array('临泽县','山丹县','市辖区','民乐县','肃南裕固族自治县','高台县');
counties[24][8] = new Array('古浪县','天祝藏族自治县','市辖区','民勤县');
counties[24][9] = new Array('临潭县','卓尼县','合作市','夏河县','玛曲县','碌曲县','舟曲县','迭部县');
counties[24][10] = new Array('会宁县','市辖区','景泰县','靖远县');
counties[24][11] = new Array('市辖区','敦煌市','玉门市','瓜州县','肃北蒙古族自治县','金塔县','阿克塞哈萨克族自治县');
counties[24][12] = new Array('市辖区','永昌县');
counties[24][13] = new Array('两当县','宕昌县','市辖区','康县','徽县','成县','文县','礼县','西和县');
counties[25][0] = new Array('大田县','宁化县','将乐县','尤溪县','市辖区','建宁县','明溪县','永安市','沙县','泰宁县','清流县');
counties[25][1] = new Array('光泽县','市辖区','建瓯市','建阳市','政和县','松溪县','武夷山市','浦城县','邵武市','顺昌县');
counties[25][2] = new Array('市辖区');
counties[25][3] = new Array('古田县','周宁县','寿宁县','屏南县','市辖区','柘荣县','福安市','福鼎市','霞浦县');
counties[25][4] = new Array('南安市','安溪县','市辖区','德化县','惠安县','晋江市','永春县','石狮市','金门县');
counties[25][5] = new Array('东山县','云霄县','华安县','南靖县','市辖区','平和县','漳浦县','诏安县','长泰县','龙海市');
counties[25][6] = new Array('市辖区','平潭县','永泰县','福清市','罗源县','连江县','长乐市','闽侯县','闽清县');
counties[25][7] = new Array('仙游县','市辖区');
counties[25][8] = new Array('上杭县','市辖区','武平县','永定县','漳平市','连城县','长汀县');
counties[26][0] = new Array('乃东县','加查县','扎囊县','措美县','曲松县','桑日县','洛扎县','浪卡子县','琼结县','贡嘎县','错那县','隆子县');
counties[26][1] = new Array('堆龙德庆县','墨竹工卡县','尼木县','市辖区','当雄县','曲水县','林周县','达孜县');
counties[26][2] = new Array('亚东县','仁布县','仲巴县','南木林县','吉隆县','定日县','定结县','岗巴县','康马县','拉孜县','日喀则市','昂仁县','江孜县','白朗县','聂拉木县','萨嘎县','萨迦县','谢通门县');
counties[26][3] = new Array('丁青县','八宿县','察雅县','左贡县','昌都县','江达县','洛隆县','类乌齐县','芒康县','贡觉县','边坝县');
counties[26][4] = new Array('墨脱县','察隅县','工布江达县','朗县','林芝县','波密县','米林县');
counties[26][5] = new Array('嘉黎县','安多县','尼玛县','巴青县','比如县','班戈县','申扎县','索县','聂荣县','那曲县');
counties[26][6] = new Array('噶尔县','措勤县','改则县','日土县','普兰县','札达县','革吉县');
counties[27][0] = new Array('六枝特区','水城县','盘县','钟山区');
counties[27][1] = new Array('关岭布依族苗族自治县','市辖区','平坝县','普定县','紫云苗族布依族自治县','镇宁布依族苗族自治县');
counties[27][2] = new Array('大方县','威宁彝族回族苗族自治县','毕节市','纳雍县','织金县','赫章县','金沙县','黔西县');
counties[27][3] = new Array('修文县','市辖区','开阳县','息烽县','清镇市');
counties[27][4] = new Array('习水县','仁怀市','余庆县','凤冈县','务川仡佬族苗族自治县','市辖区','桐梓县','正安县','湄潭县','绥阳县','赤水市','道真仡佬族苗族自治县','遵义县');
counties[27][5] = new Array('万山特区','印江土家族苗族自治县','德江县','思南县','松桃苗族自治县','江口县','沿河土家族自治县','玉屏侗族自治县','石阡县','铜仁市');
counties[27][6] = new Array('三穗县','丹寨县','从江县','凯里市','剑河县','台江县','天柱县','岑巩县','施秉县','榕江县','锦屏县','镇远县','雷山县','麻江县','黄平县','黎平县');
counties[27][7] = new Array('三都水族自治县','平塘县','惠水县','独山县','瓮安县','福泉市','罗甸县','荔波县','贵定县','都匀市','长顺县','龙里县');
counties[27][8] = new Array('兴义市','兴仁县','册亨县','安龙县','普安县','晴隆县','望谟县','贞丰县');
counties[28][0] = new Array('东港市','凤城市','宽甸满族自治县','市辖区');
counties[28][1] = new Array('市辖区','庄河市','普兰店市','瓦房店市','长海县');
counties[28][2] = new Array('市辖区','抚顺县','新宾满族自治县','清原满族自治县');
counties[28][3] = new Array('凌源市','北票市','喀喇沁左翼蒙古族自治县','市辖区','建平县','朝阳县');
counties[28][4] = new Array('市辖区','本溪满族自治县','桓仁满族自治县');
counties[28][5] = new Array('市辖区','康平县','新民市','法库县','辽中县');
counties[28][6] = new Array('大洼县','市辖区','盘山县');
counties[28][7] = new Array('大石桥市','市辖区','盖州市');
counties[28][8] = new Array('兴城市','市辖区','建昌县','绥中县');
counties[28][9] = new Array('市辖区','灯塔市','辽阳县');
counties[28][10] = new Array('市辖区','开原市','昌图县','西丰县','调兵山市','铁岭县');
counties[28][11] = new Array('义县','凌海市','北镇市','市辖区','黑山县');
counties[28][12] = new Array('市辖区','彰武县','阜新蒙古族自治县');
counties[28][13] = new Array('台安县','岫岩满族自治县','市辖区','海城市');
counties[29][0] = new Array('万州区','万盛区','九龙坡区','北碚区','南岸区','南川区','双桥区','合川区','大渡口区','巴南区','永川区','江北区','江津区','沙坪坝区','涪陵区','渝中区','渝北区','长寿区','黔江区');
counties[29][1] = new Array('丰都县','云阳县','垫江县','城口县','大足县','奉节县','巫山县','巫溪县','开县','彭水苗族土家族自治县','忠县','梁平县','武隆县','潼南县','璧山县','石柱土家族自治县','秀山土家族苗族自治县','綦江县','荣昌县','酉阳土家族苗族自治县','铜梁县');
counties[30][0] = new Array('三原县','乾县','兴平市','市辖区','彬县','旬邑县','武功县','永寿县','泾阳县','淳化县','礼泉县','长武县');
counties[30][1] = new Array('丹凤县','商南县','山阳县','市辖区','柞水县','洛南县','镇安县');
counties[30][2] = new Array('宁陕县','岚皋县','市辖区','平利县','旬阳县','汉阴县','白河县','石泉县','紫阳县','镇坪县');
counties[30][3] = new Array('凤县','凤翔县','千阳县','太白县','岐山县','市辖区','扶风县','眉县','陇县','麟游县');
counties[30][4] = new Array('吴起县','子长县','安塞县','宜川县','富县','市辖区','延川县','延长县','志丹县','洛川县','甘泉县','黄陵县','黄龙县');
counties[30][5] = new Array('佳县','吴堡县','子洲县','定边县','市辖区','府谷县','横山县','清涧县','神木县','米脂县','绥德县','靖边县');
counties[30][6] = new Array('佛坪县','勉县','南郑县','城固县','宁强县','市辖区','洋县','留坝县','略阳县','西乡县','镇巴县');
counties[30][7] = new Array('华县','华阴市','合阳县','大荔县','富平县','市辖区','潼关县','澄城县','白水县','蒲城县','韩城市');
counties[30][8] = new Array('周至县','市辖区','户县','蓝田县','高陵县');
counties[30][9] = new Array('宜君县','市辖区');
counties[31][0] = new Array('久治县','玛多县','玛沁县','班玛县','甘德县','达日县');
counties[31][1] = new Array('乐都县','互助土族自治县','化隆回族自治县','平安县','循化撒拉族自治县','民和回族土族自治县');
counties[31][2] = new Array('刚察县','海晏县','祁连县','门源回族自治县');
counties[31][3] = new Array('共和县','兴海县','同德县','贵南县','贵德县');
counties[31][4] = new Array('乌兰县','天峻县','德令哈市','格尔木市','都兰县');
counties[31][5] = new Array('囊谦县','曲麻莱县','杂多县','治多县','玉树县','称多县');
counties[31][6] = new Array('大通回族土族自治县','市辖区','湟中县','湟源县');
counties[31][7] = new Array('同仁县','尖扎县','河南蒙古族自治县','泽库县');
counties[33][0] = new Array('勃利县','市辖区');
counties[33][1] = new Array('嘉荫县','市辖区','铁力市');
counties[33][2] = new Array('同江市','富锦市','市辖区','抚远县','桦南县','桦川县','汤原县');
counties[33][3] = new Array('友谊县','宝清县','市辖区','集贤县','饶河县');
counties[33][4] = new Array('五常市','依兰县','双城市','宾县','尚志市','巴彦县','市辖区','延寿县','方正县','木兰县','通河县');
counties[33][5] = new Array('加格达奇区','呼中区','呼玛县','塔河县','新林区','松岭区','漠河县');
counties[33][6] = new Array('市辖区','杜尔伯特蒙古族自治县','林甸县','肇州县','肇源县');
counties[33][7] = new Array('东宁县','宁安市','市辖区','林口县','海林市','穆棱市','绥芬河市');
counties[33][8] = new Array('兰西县','安达市','市辖区','庆安县','明水县','望奎县','海伦市','绥棱县','肇东市','青冈县');
counties[33][9] = new Array('密山市','市辖区','虎林市','鸡东县');
counties[33][10] = new Array('市辖区','绥滨县','萝北县');
counties[33][11] = new Array('五大连池市','北安市','嫩江县','孙吴县','市辖区','逊克县');
counties[33][12] = new Array('依安县','克东县','克山县','富裕县','市辖区','拜泉县','泰来县','甘南县','讷河市','龙江县');

function getProvinces(){
	var pro = "";
	for(var i = 0 ; i < provinces.length; i++){
	pro += "<option selectedIndex="+i+">" + provinces[i] + "</option>";

	}
	$('#province').empty().append(pro);
	getCities();
}
function getCities(){
	var proIndex = $('#province option:selected').attr('selectedIndex');
	showCities(proIndex);
	getCounties();
}
function showCities(proIndex){
	var cit = "";
	if(cities[proIndex] == null){
	$('#city').empty();
	return;
	}
	for(var i = 0 ;i < cities[proIndex].length ; i++){
	cit += "<option pid="+proIndex+" selectedIndex="+i+">" + cities[proIndex][i] + "</option>";
	}
	$('#city').empty().append(cit);
}
function getCounties(){
	var proIndex = $('#city option:selected').attr('pid');
	var citIndex = $('#city option:selected').attr('selectedIndex');
	showCounties(proIndex,citIndex);
}
function showCounties(proIndex,citIndex){
	var cou = "";
	if(counties[proIndex][citIndex] == null){
		//console.log(counties);
	$('#county').empty();
	return;
	}
	for(var i = 0 ;i < counties[proIndex][citIndex].length;i++){
	cou += "<option>" + counties[proIndex][citIndex] [i] + "</option>";
	}
	$('#county').empty().append(cou);
}

//地址信息填写验证函数
function checkaddr()
{
	//判断收货人姓名填写
	if($('#usname').val()==""){			
		$('#usname').next().addClass('alert').html("收货人姓名不能为空!");	
		$('#usname').focus();
		return false; 
	}else{

		var filter=/^[\u4e00-\u9fa5a-zA-Z0-9_]+$/;
		if (!filter.test($('#usname').val())) 
			{ 
				$('#usname').next().addClass('alert').html("输入了非法字符!");	
				$('#usname').focus();
				return (false); 
			}else {
				$('#usname').next().removeClass().empty();
			}
	}
	
	//判断省份填写
	if($('#usprovince').val()=="0"){
		$('#usdistrict').next().addClass('alert').html("请选择所在省份！");	
		$('#usprovince').focus();
		return false; 
	}else{
		$('#usdistrict').next().removeClass().empty();
	}
	
	//判断城市填写
	if($('#uscity').val()=="0"){
		$('#usdistrict').next().addClass('alert').html("请选择所在城市！");	
		$('#uscity').focus();
		return false; 
	}else{
		$('#usdistrict').next().removeClass().empty();
	}
	
	//判断市区填写
	if($('#usdistrict').val()=="0"){
		$('#usdistrict').next().addClass('alert').html("请选择所在市区！");	
		$('#usdistrict').focus();
		return false; 
	}else{
		$('#usdistrict').next().removeClass().empty();
	}
	
	//判断详细地址填写
	if($('#usaddr').val()==""){
		$('#usaddr').next().addClass('alert').html("请填写详细准确的收货地址！");	
		$('#usaddr').focus();
		return false; 
	}else{

		var filter=/^[\u4e00-\u9fa5a-zA-Z0-9_]+$/;
		if (!filter.test($('#usaddr').val())) 
			{ 
				$('#usaddr').next().addClass('alert').html("输入了非法字符!");	
				$('#usaddr').focus();
				return (false); 
			}else {
				$('#usaddr').next().removeClass().empty();
			}
	}
			
	//判断手机号码格式
	
	if($('#usmob').val()==""){
		$('#usmob').next().addClass('alert').html("请填写手机号码！");	
		$('#usmob').focus();
		return false; 
	}else{	
		//var filter=/^0{0,1}(13[4-9]|15[7-9]|15[0-2]|18[7-8])[0-9]{8}$/; 
		var filter=/^1\d{10}/;  	
		if (!filter.test($('#usmob').val())){ 
			
			$('#usmob').next().removeClass().addClass('alert').html("手机号码格式不正确！");					
			$('#usmob').focus();
			return false; 
		}else{
			$('#usmob').next().removeClass().empty();
		}
	}
	return true;
}



function delLike(id){
	var data = 'id='+ id;
	$.ajax({
		type: "POST",
		url: "/user/delLike",
		dataType:"json",
		cache: false,
		data: data+"&m=" + Math.random(),
		success:function(re){
			if(re.status == 1){
				return true;
			}else if(re.status == 2){
				popdiv("#login_pop","570","auto",0.2);
			}else{
				alert(re.msg);
			}
		},error:function(){

		}
	});
	return true;
}


function cancel_order(orderSn){
	var data = 'orderSn='+ orderSn;
	$.ajax({
		type: "POST",
		url: "/user/cancelOrder",
		dataType:"json",
		cache: false,
		data: data+"&m=" + Math.random(),
		success:function(re){
			if(re.status == 1){
				location.reload();
			}else if(re.status == 2){
				popdiv("#login_pop","570","auto",0.2);
			}else{
				alert(re.msg);
			}
		},error:function(){

		}
	});
	return true;
}