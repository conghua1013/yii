(function($){
    $.fn.hoverDelay = function(options){
        var defaults = {
            hoverDuring: 200,
            outDuring: 200,
            hoverEvent: function(){
                $.noop();
            },
            outEvent: function(){
                $.noop();    
            }
        };
        var sets = $.extend(defaults,options || {});
        var hoverTimer, outTimer;
        return $(this).each(function(){
            $(this).hover(function(){
                clearTimeout(outTimer);
                hoverTimer = setTimeout(sets.hoverEvent, sets.hoverDuring);
            },function(){
                clearTimeout(hoverTimer);
                outTimer = setTimeout(sets.outEvent, sets.outDuring);
            });    
        });
    }      
})(jQuery);

$(document).ready(function(){
	
	
	$('.allcat').hover(function(){	
		$(this).addClass('allcat_on');	
		$('#catlist').show();	
	}, function(){
		$(this).removeClass('allcat_on');	
		$('#catlist').hide();		
	});
	
	/*
	$('#catlist').find('li').hover(function(){	
		$(this).find('h3').addClass('catitem_on');	
		$(this).find('.subcatlist').show();	
	}, function(){
		$(this).find('h3').removeClass('catitem_on');	
		$(this).find('.subcatlist').hide();		
	});

	//菜单悬浮hover延时弹出
	$('#catlist').find('li').hoverDelay({
		outDuring: 1000,
		hoverEvent: function(){
			console.log(this);
			$(this).find('h3').addClass('catitem_on');	
			$(this).find('.subcatlist').show();      
		},
		outEvent: function(){
			$(this).find('h3').removeClass('catitem_on');	
			$(this).find('.subcatlist').hide();	
		}
	});
	*/


	//菜单悬浮hover延时弹出
	$('#catlist').find('li').each(function(){
		var that = $(this);
		that.hoverDelay({
			outDuring: 300,
			hoverEvent: function(){
				that.find('h3').addClass('catitem_on');	
				that.find('.subcatlist').show();  
			},
			outEvent: function(){
				that.find('h3').removeClass('catitem_on');	
				that.find('.subcatlist').hide();	
			}
		});
	});

	
	
	//4个商品主图轮播事件
	$('.pic_index').find('li').hover(function(){
		$(this).addClass('pic_on').siblings().removeClass('pic_on');									  
		$('#pic_box').find('a').eq($('.pic_index').find('li').index(this)).parent().fadeIn().siblings().hide();	
	}, function(){			
	});
	

	//商品规格选择事件
	$('.guige').click(function(){
		if($(this).attr('quantity') <= 0){
			$('.guige').removeClass('guige_on');
			$('#error-style').html("此规格没有库存了！").show();
		}else{
			$('.guige').removeClass('guige_on');
			$(this).addClass('guige_on');
			$('#error-style').html("");
		}
	});


	
	//同款商品hover显示效果事件
	$('.mates').find('img').hover(function(){
		$(this).addClass('mates_on');
	}, function(){	
		if(!$(this).hasClass('mateson'))
		$(this).removeClass('mates_on');	
	});
	

	//商品详情，评论，服务3个部分的tab bar点击事件
	$('.pbar').find('li').click(function(){
		$(this).addClass('pbars_on').siblings().removeClass('pbars_on');	
		//$('.pdetail').hide()								  
		//$('.pdetail').eq($('.pbar').find('li').index(this)).fadeIn();
	});
	

	//商品评论和咨询列表选择事件
	$('.askbar').find('li').click(function(){
		$(this).addClass('askbar_on').siblings().removeClass('askbar_on');	
		$('#zping').find('dd').hide()								  
		$('#zping').find('dd').eq($('.askbar').find('li').index(this)).fadeIn();
	});
	

	// $('#comment_btn').click(function(){
	// 	var comment_content = $.trim($('#comment').val());
	// 	if(!comment_content){
	// 		alert('品论内容不能为空！');
	// 	}

	// 	var data = 'id='+$('#pInfo').attr('pid')+'content'+comment_content;
	// 	$.ajax({
	// 		type: "POST",
	// 		url: "/shop/item/addComment",
	// 		dataType:"json",
	// 		cache: false,
	// 		data: data+"&m=" + Math.random(),
	// 		success:function(re){
	// 			if(re.status == 1){
	// 				alert('成功操作！');
	// 			}else if(re.status == 2){
	// 				popdiv("#login_pop","570","auto",0.2);
	// 			}else{
	// 				alert(re.msg);
	// 			}
	// 		},error:function(){
	// 				return;
	// 		}
	// 	});
	// })


	//立即购买按钮事件
	$('.pbtn-buy').click(function(){
		var guige 	= $('.guige_on');

		if(guige.length==0){
			$('#error-style').html('请选择规格').fadeOut().fadeIn().fadeOut().fadeIn(); return;
		} 

		var pid 	= $('#pInfo').attr('pid');
		var size 	= guige.eq(0).attr('size');
		var num 	= parseInt($('#buynum').val());
		var buynow 	= 1;
		var ptype 	= "product";
		if(num<=0){
			$('#error-nums').html('请选数量').fadeOut().fadeIn().fadeOut().fadeIn(); return;
		}

		if(num > parseInt(guige.eq(0).attr('quantity'))){
			$('#error-nums').html('数量超过所需规格的库存').fadeOut().fadeIn().fadeOut().fadeIn();
			return;
		}
		addToCart(pid, num, size, buynow,ptype);
		//popdiv("#buy_pop","570","auto",0.2);
	});
	
	//加入购物车按钮事件
	$('.pbtn-shopping').click(function(){											  
		var guige 	= $('.guige_on');
		if(guige.length==0){
			$('#error-style').html('请选择规格').fadeOut().fadeIn().fadeOut().fadeIn(); return;
		} 

		var pid 	= $('#pInfo').attr('pid');
		var size 	= guige.eq(0).attr('size');
		var num 	= parseInt($('#buynum').val());
		var buynow 	= 0;
		var ptype 	= "product";

		if(num<=0){
			$('#error-nums').html('请选数量').fadeOut().fadeIn().fadeOut().fadeIn(); return;
		}

		if(num > parseInt(guige.eq(0).attr('quantity'))){
			$('#error-nums').html('数量超过所需规格的库存').fadeOut().fadeIn().fadeOut().fadeIn(); return;
		}
		addToCart(pid, num, size, buynow,ptype);
	});
	


	//商品列表页喜欢按钮事件
	$('.pinlike').click(function(){
		var likeItem = $(this);
		if(likeItem.hasClass('xinon')){ return;}

		var id = likeItem.attr('pid');
		
		addLike(id,likeItem,1);
		
	});
		
	

	//商品列表页喜欢按钮hover事件
	$('.pinlike').hover(function(){											  
		$(this).addClass('pinlike_on');			
	}, function(){	
		if($(this).hasClass('xinon')) {
			$(this).addClass('pinlike_on');
		} else {
			$(this).removeClass('pinlike_on');
		}	
	});


	
	//商品详情页喜欢按钮事件
	$('.pbtn-like').click(function(){
		var like_btn = $(this);//喜欢按钮
		if(like_btn.hasClass('xinon')){ return; }

		var id = $('#pInfo').attr('pid');

		addLike(id,like_btn,0);
		
	});
	


	//商品详情页喜欢按钮hover事件
	$('.pbtn-like').hover(function(){
		$(this).addClass('pbtn-like_on');			
	}, function(){	
		if($(this).hasClass('xinon')) {
			$(this).addClass('pbtn-like_on');
		} else {
			$(this).removeClass('pbtn-like_on');
		}	
	});


	
	//商品数量更改事件
	$('#buynum').keyup(function(){		
		$(this).val($(this).val().replace(/[^0-9]/g,''));
		if($(this).val()=='0' || $(this).val()=='')$(this).val('1');

		var guige 	= $('.guige_on');
		if(guige.length==0){
			$('#error-style').html('请选择规格').fadeOut().fadeIn().fadeOut().fadeIn();
			$(this).val('1');
			return;
		}

		var nums = guige.eq(0).attr('quantity');
		if(parseInt($(this).val())>nums)
		{		
			$(this).val(nums);				
			$('#error-nums').html("数量已达库存上限").show();
			return;
		}
				
	});


	//商品数量-事件
	$('#mins').click(function(){	
		
		var guige 	= $('.guige_on');
		if(guige.length==0){
			$('#error-style').html('请选择规格').fadeOut().fadeIn().fadeOut().fadeIn();return;
		}

		var nums = guige.eq(0).attr('quantity');
		if(parseInt($(this).next().val())>1) {
			$(this).next().val(parseInt($(this).next().val())-1);
		}
		if(parseInt($(this).next().val())< nums) {
			$('#error-nums').hide();
		}
	});	


	//商品数量+事件
	$('#plus').click(function(){	
		var guige 	= $('.guige_on');
		if(guige.length==0){
			$('#error-style').html('请选择规格').fadeOut().fadeIn().fadeOut().fadeIn(); return;
		} 

		var nums = guige.eq(0).attr('quantity');
		if(parseInt($(this).prev().val())<nums) {						
			$(this).prev().val(parseInt($(this).prev().val())+1);
		} else {	
			$('#error-nums').html("数量已达库存上限").show();
		}
	});	
	


	//详情，评论，服务tabbar悬停浏览器上方的事件
	if($('#pbarbox').length){
		var win = $(window),
				pbarbox = $('#pbarbox'),
				scrollRange = pbarbox.offset().top,
				scrollTop;

		win.bind('scroll', function(){
			scrollTop = win.scrollTop();
			if(scrollTop > scrollRange){
				pbarbox.addClass('pbarbox_fixed');
			} else {
				pbarbox.removeClass('pbarbox_fixed');
			}
		});
	}



	//商品评论，咨询-事件-评论和咨询写到一起了
	$('.zp_btn').click(function(){	
		//ajax需要区分哪个是评论，哪个是咨询，pform的值1表示评论，1表示咨询
		var pparent =$(this).parents('.zpform'),
			pform =pparent.find('.pfrom'),
			pid =pparent.find('.pid'),
			pcomment=pparent.find('.comment');
		
		if(pform.val()=='1'){
			var action = 'addComment';
		}else{
			var action = 'addConsultation';	
		}
						
		if($(this).prev().val()=="") {	
			$(this).prev().addClass('zpinput_on');
			$(this).prev().fadeOut().fadeIn().fadeOut().fadeIn('fast', function(){$(this).prev().focus();});
			return false;				
		} else if ($(this).prev().val().length>200) {	
			pparent.find('.zpltip').html("不能超过200个字符。");
			return false;
		} else {   //alert($('input[name=__hash__]').val()+'地方sss');return;
			$.ajax({
				   type: "post",
				   url: "/shop/item/"+action,
				   data: 'comment=' + pcomment.val() + "&id=" + pid.val() + "&type=" + pform.val() + "&__hash__=" + $('input[name=__hash__]').val(),
				   dataType: 'json',
				   success:function(msg){
					   
				   if ( msg.status == 4 ){
					   //没登陆状态弹出登录框
					   popdiv("#login_pop","570","auto",0.2);
					} else if(msg.status == 0) {
						//添加过了提示不能频繁添加
						pparent.find('.zpltip').html(msg.info);	
					} else if(msg.status == 2) {
						pparent.find('.zpltip').html(msg.info);	
					} else if(msg.status == 3) {
						//添加失败
						pparent.find('.zpltip').html(msg.info);	
					} else {
						pparent.find('.zpltip').html(msg.info);						
						//更新页面评论列表						
						pdata = msg.data;	
						
						if(pform.val()=="1") {					
							var html ='<ul class="zpbox zplist"><li class="zp_face"><a title="'+pdata.uname+'" href="/player/'+pdata.uid+'"><img src="/Public/Images/avatar/small/'+pdata.uavatar+'" width="45" height="45"  alt="'+pdata.uname+'" /></a><b></b></li><li class="zp_txt zplist_txt"><a title="'+pdata.uname+'" class="zp_name" href="/player/'+pdata.uid+'">'+pdata.uname+'</a><b>'+pdata.pldate+'</b><p>'+pdata.comment+'</p></li><div class="clear"></div></ul>';           			
							$('#pllist').find('.zpcount').prepend(html);
							pparent.find('.comment').val('');	
							$('#pllist').find('.zpsum').text(parseInt($('#pllist').find('.zpsum').text())+1);
						} else if(pform.val()=="2") {
							var html ='<ul class="zpbox zplist"><li class="zp_face"><a title="'+pdata.uname+'" href="/player/'+pdata.uid+'"><img src="/Public/Images/avatar/small/'+pdata.uavatar+'" width="45" height="45"  alt="'+pdata.uname+'" /></a><b></b></li><li class="zp_txt zplist_txt"><a title="'+pdata.uname+'" class="zp_name" href="/player/'+pdata.uid+'">'+pdata.uname+'</a><b>'+pdata.pldate+'</b><p>'+pdata.comment+'</p></li><div class="clear"></div></ul>';          			
							$('#cslist').find('.zpcount').prepend(html);
							pparent.find('.comment').val('');	
							$('#cslist').find('.zpsum').text(parseInt($('#pllist').find('.zpsum').text())+1);
						}
					}
				}
			});
		}
	});

	
	getMiniCart();//头部购物车加载


	$('#gotocart').live('click',function(){
		checkSelectProduct();
		window.location.href= "/cart";
	})

	$('.minicart_li').live('click',function(){
		var del_this = $(this); 
		var cid = $(this).attr('cid');
		var data = 'id='+cid
		$.ajax({
			type: "POST",
			url: "/cart/delCart",
			dataType:"json",
			cache: false,
			data: data+"&ajax=1&m=" + Math.random(),
			success:function(re){
				if(re.status == 1 ){ //直接购买成功后 跳转到结账页面
					getMiniCart();
				}else if(re.status == 2){
					//window.location.href= "/public/login"; 
					popdiv("#login_pop","570","auto",0.2);
				}else{
					alert(re.msg);
				}
				//2 卖完;0 不足;-2 货品不可买;1购入OK
			},error:function(){
					return;
			}
		});
	})
	
});


//添加到购物车
function addToCart(pid, num, size, buynow,type){
	var data = "id="+pid+
		"&size="+size+
		"&buynow="+buynow+
		"&num="+num+
		'&type='+type;
	$.ajax({
		type: "POST",
		url: "/cart/addCart",
		dataType:"json",
		cache: false,
		data: data+"&ajax=1&m=" + Math.random(),
		success:function(re){
			if(re.status == 1 && re.buynow == '1'){ //直接购买成功后 跳转到结账页面
				window.location.href= "/shop/cart/checkout";
			}else if(re.status == 1){
				var sell_price = $('#sell_price').html();
				var price_amount = num * (sell_price.substring(1,sell_price.length-1));
				$('#pop_product_href').attr('href',document.location);
				$('#pop_product_img').attr('src',$('#first_img').attr('src'));
				$('#pop_product_name').html($('#pInfo').html());
				$('#pop_product_num').html(num);
				$('#pop_product_price').html('￥'+price_amount);
				popdiv("#buy_pop","570","auto",0.2);	//添加购物车后弹出层
				getMiniCart();//头部购物车加载
			}else if(re.status == 2){
				//window.location.href= "/public/login"; 
				popdiv("#login_pop","570","auto",0.2);
			}else{
				alert(re.msg);
			}
			//2 卖完;0 不足;-2 货品不可买;1购入OK
		},error:function(){
				return;
		}
	});

}



function getMiniCart(){
	$.ajax({
		type: "POST",
		url: "/cart/miniCart",
		dataType:"json",
		cache: false,
		data: "m=" + Math.random(),
		success:function(re){
			if(re.status == 1){
				//$('#navcartpop').html(re.html);
				if(re.total){
					$('#navcartnum').show().html(re.total.quantity);
				}else{
					$('#navcartnum').hide().html('');
				}
			}
		},error:function(){
				return;
		}
	  });

}


//检查提交要选中的商品到购物车
function checkSelectProduct(){
	var confirmCartIds = '';	//已选商品id
	$("input[type=checkbox]").each(function(i){
		if(this.checked){
            if(this.value != 1){
                confirmCartIds += this.value+',';
            }
		}			
	});
	confirmCartIds = confirmCartIds.replace(/^(\s*,)|,$/, "");	//去除开头结尾处逗号

 return true;
}


/* 喜欢按钮，id->商品id,btn->点击的按钮对象，typ->表明是那个页面的喜欢按钮，1=列表页，0=详情页*/
function addLike(id,btn,type) {
	var data = 'id='+ id;
	$.ajax({
		type: "POST",
		url: "/user/addLike",
		dataType:"json",
		cache: false,
		data: data+"&m=" + Math.random(),
		success:function(re){
			if(re.status == 1){
				
				if (type==1) {
					btn.addClass('xinon pinlike_on');
					$('#like_num_'+id).html(parseInt($('#like_num_'+id).html())+1)
				} else if( type==0){
					btn.addClass('xinon pbtn-like_on');
					btn.find('span').html(parseInt(btn.find('span').html())+1);
				};
				
				return true;
			}else if(re.status == 2){
				popdiv("#login_pop","570","auto",0.2);
			}else{
				alert(re.msg);
			}
		},error:function(){

		}
	});
}
