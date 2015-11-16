$(document).ready(function(){
	
	//登陆
	$('#nowlogin_btn').click(function(){
		$('.popbox').hide();
		popdiv("#login_pop","500","auto",0.4);						 
	});

	$('#tocheck,#tocheck-1').click(function(){
		// window.location.href= "/shop/cart/checkout";			 
	});


	
	//放入购物车
	$('.puttocart').click(function(){
		$(this).parent().parent().find('.putpop').fadeIn(300).delay(1000).fadeOut(400);								 
	});	
	
	//组合销售hover显示
	$('.combin_img').hover(function(){											  
		$(this).parent().next().find('.packed_list').show();	
		$(this).parent().next().find('.packed_list').width($(this).parent().next().find('ul').length*$(this).parent().next().find('.packed_ul').width()+($(this).parent().next().find('.add').length*50));								
		$(this).parent().next().find('.packed_list').height($(this).parent().next().find('.packed_ul').height()+15);	
	}, function(){											  
		$(this).parent().next().find('.packed_list').hide();	
	});
	
	//组合销售hover显示
	$('.packed').hover(function(){		
		$(this).find('.packed_list').show();
		$(this).find('.packed_list').width($(this).find('ul').length*$(this).find('.packed_ul').width()+($(this).find('.add').length*50));								
		$(this).find('.packed_list').height($(this).find('.packed_ul').height()+15);		
	}, function(){											  
		$(this).find('.packed_list').hide();	
	});


	
	//商品数量直接修改事件
	$('.num_input').keyup(function(){
					
		$(this).val($(this).val().replace(/[^0-9]/g,''));
		if($(this).val()=='0' || $(this).val()=='')$(this).val('1');
		
		// if(parseInt($(this).val())>10){	
		// 	$(this).parent().find('.num_tip').remove();
		// 	$(this).next().after("<span class='num_tip'>数量已达库存上限</span>");
		// }
		var cid = $(this).parent().parent().parent().attr('cid');
		var num = $(this).parent().find('.num_input').val();
		var action = 'edit'
		upCartNum(cid,num,action)
				
	});

	
	//商品数量减
	$('.num_down').click(function(){	
		// if(parseInt($(this).next().val())<10){
		// 	$(this).parent().find('.num_tip').remove();
		// }
		var cid = $(this).parent().parent().parent().attr('cid');
		var num = $(this).parent().find('.num_input').val();
		var action = $(this).hasClass('num_down') ? 'reduse' : 'plus';
		num = parseInt(num) - 1;
		upCartNum(cid,num,action);

		// if(parseInt($(this).next().val())>1){
		// 	$(this).next().val(parseInt($(this).next().val())-1);
		// }
	});

	
	//商品数量加
	$('.num_up').click(function(){	
		// if(parseInt($(this).prev().val())<10){						
			//$(this).prev().val(parseInt($(this).prev().val())+1);
		// }
		// else{	
		// 	$(this).parent().find('.num_tip').remove();
		// 	$(this).after("<span class='num_tip'>数量已达库存上限</span>");
		// }
		var cid = $(this).parent().parent().parent().attr('cid');
		var num = $(this).parent().find('.num_input').val();
		var action = $(this).hasClass('num_down') ? 'reduse' : 'plus';
		num = parseInt(num) + 1;
		upCartNum(cid,num,action);
	});

	
	//使用优惠券按钮事件
	$('#useyhq_btn').click(function(){
		var sn = $('#coupon_number').val();	

        $.ajax({
            type: "POST",
            url: "/cart/checkCoupon",
            dataType:"json",
            cache: false,
            data: "sn="+sn+"&m=" + Math.random(),
            success:function(re){
                if(re.status == 1){
					couponListHtml = getCouponList(re.couponlist,sn);
                    $('#couponAmount').html('-¥' +re.couponAmount);
                    $('#finalAmount').html('¥' +re.finalAmount);
                    $('.yhq_list').eq(0).html(couponListHtml);
                    $('#yhq_input').val($('.yhq_selected').html()); 
                    $('#yhqbox1').hide();
                    $('#yhqbox2').show();
                }else if(re.status == 2){
                    window.location.href= "/public/login";
                }else{
                    $('#useyhq_btn').next().html(re.msg).show();
                }
            },error:function(){
                return;
            }
        });
	});


	//输入优惠券代码与选择优惠券切换显示
	$('#useryhq1').click(function(){	
		$('#yhqbox1').hide();
		$('#yhqbox2').show();
		//IE7下解决优惠券列表不能自适应宽度的问题
		if($.browser.msie){ 
			$('.yhq_list').show();
			var yhq_listmax = $('.yhq_list').find('li').eq(0).width(); 
			$('.yhq_list li').each(function(){
	
				if ($(this).width() > yhq_listmax) { 
					yhq_listmax = $(this).width(); 
				}
		
			});
			$('.yhq_list li').width(yhq_listmax);
			if($('.yhq_list').find('li').length>=10){
				$('.yhq_list').width(yhq_listmax+30);
			}
			$('.yhq_list').hide();
		}
	});	
	
	//输入优惠券代码与选择优惠券切换显示
	$('#useryhq2').click(function(){	
		$('#yhqbox2').hide();
		$('#yhqbox1').show();
	});	
	
	//展开优惠券列表事件
	$('.yhq_select').click(function(){
		if($('.yhq_list').css("display")=="none"){
			if($('.yhq_list').find('li').length>=10){
				$('.yhq_list').addClass('maxyhq');
			}else{
				$('.yhq_list').removeClass('maxyhq');
			}
			$('.yhq_list').show();	
			$('.yhq_selected').addClass('yhq_hover');
		}	
		return false;
	});

	
	//优惠券列表展开后hover效果
	$('.yhq_list').find('li').hover(function(){											  
			$(this).addClass('yhq_hover').siblings().removeClass('yhq_hover');;											  
		}, function(){		
			$(this).removeClass('yhq_hover');		
		});
	
	//选取优惠券操作触发-只能选可用的，不可用的选不中	
	$('.yhq_list').find('li').not('.yhq_off').click(function(){	
		$('#yhq_input').val($(this).html());
		$(this).addClass('yhq_selected').siblings().removeClass('yhq_selected');
		$(this).parent().hide();

		var couponsn = $(this).attr('couponsn');
		var data =  "sn="+couponsn;
		$.ajax({
			type: "POST",
			url: "/cart/checkCoupon",
			dataType:"json",
			cache: false,
			data: data+"&ajax=1&m=" + Math.random(),
			success:function(re){
				if(re.status == 1){
					//$('#productAmount').html(re.);
					//$('#shippingFee').html(re.);
					$('#couponAmount').html('-¥' + re.couponAmount);
					//$('#reduceAmount').html(re.);
					$('#finalAmount').html('¥' + re.finalAmount);
				}else if(re.status == 2){
                    window.location.href= "/public/login";
                }else{
                    $('#useyhq_btn').next().html(re.msg).show();
				}
			},error:function(){
					return;
			}
		  });

		return false;
	});	
	
	//优惠券列表展开后点击其他区域消失隐藏的事件
	$("body").bind("click", function(){		
		if($('.yhq_list').css("display")=="block"){			
			$('.yhq_list').hide();					 
		}	
	}); 
	
	//删除购物车商品弹出层触发
	$('.del_opt').click(function(){
		var id = $(this).parent().parent().attr('cid');
		popdiv("#del_pop","500","auto",0.4);
		$('#del_confirm_btn').attr('cid',id);
		$('#pImg').attr('src',$('#pimg_'+id).attr('src'));
		$('#pName').html($('#pname_'+id).html());
		$('#pNum').html($('#pnum_'+id).val());
		$('#pPrice').html($('#pprice_'+id).html());

		//$('#cart-'+cid).find('.num_tip').remove();
		//deleteCart(id);
	});

	//确认隐藏弹出层
	$('#del_confirm_btn').click(function(){
		var id = $(this).attr('cid');
		deleteCart(id);
			
		
	});



	//支付方式点击选择
	$('.bank_box').find('label').click(function(){	
		$('.bank_box').find('label').removeClass('bank_on');
		$(this).addClass('bank_on');
		$(this).prev().click();
	});	
	
	
	//地址列表项目的选择操作
	$('.addr_list').find('li').live('click',function(){	
		
		//点击后项目加边框操		
		$(this).find("input[name='addr']").eq(0).attr('checked','checked');
		$('.addr_list').find('li').removeClass('addr_on');
		$(this).addClass('addr_on');	
	});
	
	
	/*/使用新地址点击的显示与隐藏事件
	$('#addr_modify').click(function(){
			  
		$('#addnewaddrs').toggle();
		//alert('验证通过写入ajax提交表单代码');
		
	});	*/
		
	//添加新地址按钮事件	
	$('#addr_btn').click(function(){
		if(checkaddr())			  
		{	
			//判断地址个数
			if($('#addr_list').find('li').length>=6){
				$(this).next().addClass('alert').html("最多只能保存6个地址！");
				return;
			}
			//以下代码需要放在ajax的success里执行
			//地区的代号值->$('#usprovince').val(),$('#uscity').val(),$('#usdistrict').val()
			// var addr_id=1232323,
			// addr_name=$('#usname').val(),
			// addr_mob=$('#usmob').val(),
			// addr_region=[$('#usprovince').find("option:selected").text(),$('#uscity').find("option:selected").text(),$('#usdistrict').find("option:selected").text()].join("-"),
			// addr_addrs=$('#usaddr').val();		
			// var newaddhtml='<li class="addr_on"><div><input checked="checked" type="radio" name="addr" id="addr_s'+addr_id+'" value="'+addr_id+'" /><p><span><b>'+addr_name+'</b></span><span>'+addr_mob+'</span></p><p><span>'+addr_region+'</span><span>'+addr_addrs+'</span></p></div></li>';
			
			// $('#addr_list').find('li').removeClass('addr_on');
			// $('#addr_list').prepend(newaddhtml);
			

			var data =  "usname="+$('#usname').val()+
						"&usmob="+$('#usmob').val()+
						"&usprovince="+$('#usprovince').val()+
						"&uscity="+$('#uscity').val()+
						"&usdistrict="+$('#usdistrict').val()+
						"&usaddr="+$('#usaddr').val();
			var addressHtml = '';
			$.ajax({
				type: "POST",
				url: "/user/saveAddress",
				dataType:"json",
				cache: false,
				data: data+"&ajax=1&m=" + Math.random(),
				success:function(re){
					if(re.status != 1){
						$('#modaddr_alert').html(re.msg);
					}else{
						addressHtml = getAddressHtml(re.list);
						$('#usname').val('');
						$('#usmob').val('');
						$('#usprovince').val(0);
						$('#uscity').val(0);
						$('#usdistrict').val(0);
						$('#usaddr').val('');
						$('#addr_list').html(addressHtml);
						//$('#addr_list').find('li:last').after(addressHtml);
						//$('#addr_list').append();
					}
				},error:function(){
						return;
				}
			});
		}
	});
		

	//确认订单按钮事件
	$('#postorder_btn').click(function(){
		if($('#addr_editbox').attr('isshow')=="on"){
			$('#post_alert').removeClass().addClass('alert').html('确认收货人信息，再提交订单');
		}		
		//$('#post_alert').removeClass().addClass('alert').html('确认后，再提交订单');
		//alert('验证通过写入ajax提交表单代码');
		checkout();//提交订单操作
	});
	
	//立即支付按钮弹出层触发
	$('#pay_btn').click(function(){	
		popdiv("#pay_pop","500","auto",0.4);
	});		
	
});

//地址信息填写验证函数
function checkaddr()
{
	//判断收货人姓名填写
	if($.trim($('#usname').val())==""){			
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
	if($.trim($('#usaddr').val())==""){
		$('#usaddr').next().addClass('alert').html("请填写详细准确的收货地址！");	
		$('#usaddr').focus();
		return false; 
	}else{
		var filter=/^[\u4e00-\u9fa5a-zA-Z0-9_]+$/;
		if (!filter.test($('#usaddr').val())) {
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





// cid购物车id num 商品个数 加or减
function upCartNum(cid,num,action){
	var data =  "id="+cid+
				"&num="+num+
				"&action="+action;
	$.ajax({
		type: "POST",
		url: "/cart/upCartNum",
		dataType:"json",
		cache: false,
		data: data+"&ajax=1&m=" + Math.random(),
		success:function(re){
			if(re.status != 1){
				$('#cart-'+cid).find('.num_tip').remove();
				$('#cart-'+cid).find('.num_up').after("<span class='num_tip'>"+re.msg+"</span>");
				return false;
			}else{
				$('#pnum_'+cid).val(parseInt(num));
				$('#cart-'+cid).find('.num_tip').remove();
				var eachPrice = $('#pnum_'+cid).parent().parent().prev().html().replace('¥','');
				var updatePrice = eachPrice*num;
				updatePrice = parseFloat(updatePrice).toFixed(2);
				$('#pprice_'+cid).html('¥'+updatePrice);
				//同时更新 应付商品金额 部分的金额    
				updatetotalPrice();
				
			}
		},error:function(){
				return;
		}
	  });

	return true;
}


function updatetotalPrice(){
	var totalprice=0;
	$('.itemprice').each(function(){
		totalprice=totalprice+parseFloat(parseFloat($(this).html().replace('¥','')).toFixed(2));

	});

	$('#cart_sumnum').html('¥'+totalprice.toFixed(2));
	$('#sum_num').html('¥'+totalprice.toFixed(2));
}

function deleteCart(cid){
	var data =  "id="+cid
	$.ajax({
		type: "POST",
		url: "/cart/delCart",
		dataType:"json",
		cache: false,
		async:false,
		data: data+"&ajax=1&m=" + Math.random(),
		success:function(re){
			if(re.status != 1){
				//购物车列表写入 返回的错误信息
				//$('#cart-'+cid).find('.num_tip').remove();
				//$('#cart-'+cid).find('.num_up').after("<span class='num_tip'>"+re.msg+"</span>");
			} else {

				$(".head,.main,.foot").removeClass('blur');
				$('#del_pop').fadeOut();
				$('#popbg').fadeOut();
				$('#pops').fadeOut();
				if($('#cart-'+cid).parent().find("tr").length <= 2){ location.reload(); }//只有一个商品的时候 删除后要刷新页面
				$('#cart-'+cid).find('.num_tip').remove();
				$('#cart-'+cid).remove();
				//同时更新 应付商品金额 部分的金额
				updatetotalPrice();
			}
		},error:function(){
				//操作失败要有alert;
				alert('操作失败');
		}
	});
}


function checkout(){
	var addrid 	= $('.addr_on').eq(0).attr('aid'); //选中该属性的id
	var payid 	= $('input[name="pay_id"]:checked').val();
	var couponsn = '';
	if($('.yhq_selected').length > 0){
		couponsn = $('.yhq_selected').attr('couponsn');
	}
	var invoiceid = 0;
	var data =  "addrid="+addrid+
				"&couponsn="+couponsn+
				'&invoiceid='+invoiceid+
				'&payid='+payid+
				'&remark='+ $('#ordermsginput').val();

	if(addrid == undefined || !addrid){
		$('#post_alert').removeClass().addClass('alert').html('请点击、选择收货地址后再提交！');
		return;
	}

	$.ajax({
		type: "POST",
		url: "/cart/createOrder",
		dataType:"json",
		cache: false,
		data: data+"&ajax=1&m=" + Math.random(),
		success:function(re){
			if(re.status == 1){
				$('#post_alert').removeClass().addClass('alert').html('提交成功！');
				window.location.href= "/order/"+re.ordersn;
			}else{
				$('#post_alert').removeClass().addClass('alert').html(re.msg);
			}
		},error:function(){
				return;
		}
	  });

}

function getAddressHtml(list){
	if(!list){return '';}
	var addressHtml = '';
	for (x in list)
	{
		addressHtml += '<li ' + (list[x].is_default == 1 ? 'class="addr_on"' : '') + 'id="addr-'+list[x].id +'" aid="'+list[x].id +'" >';
		addressHtml += '<div>';
		addressHtml += '<input checked="checked" type="radio" name="addr" id="addr_'+list[x].id +'" value="'+list[x].id +'" />';
		addressHtml += '<p><span><b>'+list[x].consignee +'</b></span><span>'+list[x].mobile +'</span></p>';
		addressHtml += '<p><span>'+list[x].province_name +'-'+list[x].city_name +'-'+list[x].district_name +'</span>';
		addressHtml += '<span>'+list[x].address +'</span></p>';
		addressHtml += '</div>';
		addressHtml += '</li>';
	}
	return addressHtml;
}

function getCouponList(list,coupon_sn){
	if(!list){return '';}
	var couponHtml = '';
	for (x in list)
	{
		couponHtml += '<li class="yhq_on '+ (coupon_sn && coupon_sn == list[x].coupon_sn ? 'yhq_selected' : '') +'" couponsn="'+list[x].coupon_sn +'"'+
			+ (list[x].coupon_type ? 'type="'+list[x].coupon_type+'"' : '')+' >¥'+list[x].coupon_amount+'（满¥'+list[x].satisfied_amount+'可用）有效期至'+list[x].end_time+'['+list[x].coupon_name+']</li>';
	}
	return couponHtml;
}
