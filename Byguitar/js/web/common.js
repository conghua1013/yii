$(document).ready(function(){
	if($('#fbox').length>0) {
		$('#fbox').switchboxaction({Time:5000,SwitchTime:2000,switchindex:'#fbar',onclass:'fbar_on',SwitchMode:'Hover',AutoStart:true,SwitchEffect:'show'});
	}
	
	//搜索文本框得到焦点事件
	$('.soinput').click(function(){	
		if($(this).val()=="学吉他、求谱、买吉他...")
		{
			$(this).removeClass('soinput_on');
			$(this).val("");
		}
	});
	
	//搜索文本框失去焦点事件
	$('.soinput').blur(function(){	
		if($(this).val()=="")
		{
			$(this).addClass('soinput_on');
			$(this).val("学吉他、求谱、买吉他...");
		}
	});
	
	//搜索文本框点回车事件
	
	$(".soinput").keydown(function(event){	
		//过滤回车键	
		if((event.keyCode ==13))	
		{	
			//alert($(this).val());
			if($(this).val()=="")
			{
				
				$(this).addClass('soinput_on');
				$(this).focus().fadeOut().fadeIn().fadeOut().fadeIn();
			}
			else
			{
				//alert($(this).val());	
				//在这里写入提交表单代码;
			}
			
		}
	}); 
	$('.sobtn').click(function(){
							   
		if($(".soinput").val()==""||$(".soinput").val()=="学吉他、求谱、买吉他...")
			{
				$(".soinput").val("");
				$(".soinput").focus().fadeOut().fadeIn().fadeOut().fadeIn();
				return false;
				//$(".soinput").fadeOut().fadeIn().fadeOut().fadeIn().fadeOut().fadeIn();
				//$(".soinput").focus();
			}
			else
			{
				//alert($(this).val());	
				//在这里写入提交表单代码;
			}	
	});
	
	$(".info").hover(function(){
		$('.uinfolist').fadeIn();		
	}, function(){			
		$('.uinfolist').fadeOut();	
	});

	$('.navcart').hover(function(){											  
		
		$(this).addClass('carta_on');
		$('.cartnum').addClass('cartnum_on');			
		$('.navcartpop').show();
		
	}, function(){	
	
		$(this).removeClass('carta_on');	
		$('.cartnum').removeClass('cartnum_on');		
		$('.navcartpop').hide();
		
	});


    $('#gotocart').live('click',function(){
        window.location.href= "/cart";
    })


	$(window).scroll(function(event){
		var scrollTop = $(document).scrollTop();
		scrollTop += 150;
		//$('.pop').css({top: scrollTop});
		$('#pops').css({top: scrollTop});
	});

	//弹出登录层操作
	$('#loginpop_btn').click(function(){
		popdiv("#login_pop","570","auto",0.2);
	});
	
	//弹出注册操作
	$('#regpop_btn').click(function(){
		popdiv("#reg_pop","570","auto",0.2);
	});
	

	//弹出sns绑定操作
	//$('#snsband_btn').click(function(){
	if($('#sns_pop').length!=0){
		popdiv("#sns_pop","570","auto",0.2);
	}
	//});
	
	
	$('.sns_popbar').click(function(){
		if($(this).index()==1){
			$(this).removeClass('pop_top_off');
			$('.sns_popbar').eq(1).addClass('pop_top_off');
			$('#sns_pop dd').eq(0).show();
			$('#sns_pop dd').eq(1).hide();
		}else {
			$(this).removeClass('pop_top_off');
			$('.sns_popbar').eq(0).addClass('pop_top_off');
			$('#sns_pop dd').eq(1).show();
			$('#sns_pop dd').eq(0).hide();
		}
	});

	//绑定新账号按钮操作
	$('.newbandsns_btn').click(function(){

		if($(this).hasClass('disabled')){
			return false;
		}

		if($.trim($('#email').val()) == ''){
			$('#email').parent().parent().next().find('span').removeClass().addClass('alert_txt').html('邮箱不能为空！<b></b>');
			return false ;
		}else if($.trim($('#nick').val()) == ''){
			$('#nick').parent().next().find('span').removeClass().addClass('alert_txt').html('昵称不能为空！<b></b>');
			return false ;
		}

		var filter=/^\s*([A-Za-z0-9_-]+(\.\w+)*@(\w+\.)+\w{2,3})\s*$/;
	    if (!filter.test($('#email').val())) 
		{ 
			$('#email').parents('td').next().find("span").removeClass().addClass('alert_txt').html("格式有误<b></b>");
	        return false; 
	   	}

	   	var filters=/^[\u4e00-\u9fa5a-zA-Z0-9_]+$/;
		var nicklen =nanmelen($('#nick').val());
	    if(nicklen>0)
		{

			if(nicklen>3&&nicklen<18){

				if (!filters.test($('#nick').val())) 
				{ 
					$('#nick').parents('td').next().find("span").removeClass().addClass('alert_txt').html("有非法字符<b></b>");
					return (false); 
				}
				else
				{
					if($('#nick').attr('cked')=="flase"){
	     			//$('#email').focus();
		 			//$('#email').select();
	     			return false;	}
				}
			}
			else 
			{
				
				$('#nick').parents('td').next().find("span").removeClass().addClass('alert_txt').html("4-18个字符<b></b>");
				return (false);
			}
		}
		else
		{
			$('#nick').parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");
			return (false);
			
	    }

	    var agreement = $("#agree");
		  var agreementV = '';
		  if(agreement.length)
		  {
		       if(!agreement[0].checked){
		        $("#agree").parents('td').next().find("span").removeClass().addClass('alert_txt').html("需同意协议<b></b>");
		       return false;
		     }else{
		        agreementV = agreement[0].value;	
				$("#agree").parents('td').next().find("span").removeClass().html("");
		     }
		  }
		//CheckEmail($('#email'));
		//CheckNick($('#nick'));

		$('#email').parent().parent().next().find('span').removeClass().html('');
		$('#nick').parent().next().find('span').removeClass().html('');
		$(this).parents('td').next().find("span").removeClass().html("");

		$(this).addClass('disabled').html("账号绑定中...");

		$.ajax({
				type: "post",
				url: "/public/unionLogin",
				data: 'email=' + $('#email').val() + '&nick_name='+ $('#nick').val() + '&type=new',
				dataType: 'json',
				success:function(msg){
					 if ( msg.status == 0 ){
						 //alert(msg.info);//错误
						 $('.newbandsns_btn').parents('td').next().find("span").removeClass().addClass('alert_txt').html(msg.info+"<b></b>");
					 	 $('.newbandsns_btn').removeClass('disabled').html("完成绑定");
					 }else{
					 	 $('.newbandsns_btn').parents('td').next().find("span").removeClass().html("");
						 $('.close').click();
						 location.reload();
					 }
				}
		});
	});
	
	//绑定已有账号按钮操作
	$('.bandsns_btn').click(function(){

		if($(this).hasClass('disabled')){
			return false;
		}

		if($.trim($('#login_user').val()) == ''){
			$('#login_user').parent().parent().next().find('span').removeClass().addClass('alert_txt').html('邮箱不能为空！<b></b>');
			return false ;
		}else if($.trim($('#login_password').val()) == ''){
			$('#login_password').parent().parent().next().next().find('span').removeClass().addClass('alert_txt').html('密码不能为空！<b></b>');
			return false ;
		}
		$('#login_user').parent().parent().next().find('span').removeClass().html('');
		$('#login_password').parent().parent().next().next().find('span').removeClass().html('');
		$(this).parents('td').next().find("span").removeClass().html("");
		$(this).addClass('disabled').html("账号绑定中...");

		$.ajax({
				type: "post",
				url: "/public/unionLogin",
				data: 'account=' + $('#login_user').val()+'&password='+$('#login_password').val()+'&type=old' ,
				dataType: 'json',
				success:function(msg){
					 if ( msg.status == 0 ){
						 //alert(msg.info);//错误
						 $('.bandsns_btn').parents('td').next().find("span").removeClass().addClass('alert_txt').html(msg.info+"<b></b>");
						 $('.bandsns_btn').removeClass('disabled').html("绑&nbsp;&nbsp;定");
					 }else{
					 	 $('.bandsns_btn').parents('td').next().find("span").removeClass().html("");
						 $('.close').click();
						 location.reload();
					 }
				}
		});
	});


	//关闭弹出层操作
	$('.close').click(function(){	 					   
		 $(this).parents('dl').fadeOut();
		 $(".head,.main,.foot").removeClass('blur');
		 $('#popbg').fadeOut(); 
		 $("#pops").fadeOut();	
		 if ($.browser.webkit && (popdiv=="#login_pop"||popdiv=="#reg_pop")) {
			$('#login_pop').css({webkitTransform:'rotateY(0deg)'});
			$('#reg_pop').css({webkitTransform:'rotateY(180deg)'});
		}
	});

	//弹出注册层中点击去登录链接操作
	$('#pop_tolog').click(function(){
		if ($.browser.webkit) {
			$('#login_pop').css({webkitTransform:'rotateY(0deg)','z-index':'999999'});
		 	$('#reg_pop').css({webkitTransform:'rotateY(180deg)','z-index':'999998',height:'363px',overflow:'hidden'});
		}else{				   
		 $('#reg_pop').hide();
		 $('#popbg').hide();
		 $("#pops").hide();
		 popdiv("#login_pop","570","auto",0.2);
		};  
		 
	});
	
	//弹出登录层中点击去注册链接操作
	$('#pop_toreg').click(function(){	 					   
		 //$('#login_pop').hide();
		 //$('#popbg').hide();
		 //popdiv("#reg_pop","570","auto",0.2);
		 if ($.browser.webkit) {
		 	$('#login_pop').css({webkitTransform:'rotateY(-180deg)','z-index':'999998'});
		 	$('#reg_pop').css({webkitTransform:'rotateY(0deg)','z-index':'999999',height:'513px',overflow:'hidden'});
		 }else{
		 	$('#login_pop').hide();
		 	$('#popbg').hide();
		 	$("#pops").hide();
		 	popdiv("#reg_pop","570","auto",0.2);
		 };
	});
	
	//验证码操作部分
	$('.yzmimg').click(function(){	 					   
		var timenow = new Date().getTime();
		$(this).attr('src','/public/verify/'+timenow);
		
	});		
	//验证码操作部分
	$('#yzmimglook').click(function(){	
								
		$('.yzmimg').click();		
	});
	
	//订阅杂志操作
	$('#order_btn').click(function(){									
		
		if($('#order_txt').val() =="")
		{
		//$(this).parents('td').next().find("span").addClass('alert_txt').html("不能为空<b></b>");
			alert('请填写邮箱！');
			$('#order_txt').focus();
			return (false);
		}    
		var filter=/^\s*([A-Za-z0-9_-]+(\.\w+)*@(\w+\.)+\w{2,3})\s*$/;
		if (!filter.test($('#order_txt').val())) 
		{ 
			//Email.parents('td').next().find("span").addClass('alert_txt').html("格式有误<b></b>");
			alert('邮箱格式有误！');
			$('#order_txt').focus();
			return (false); 
		}
		else
		{	
			$.ajax({
				   type: "post",
				   url: "/public/orderzine",
				   data: 'email=' + $('#order_txt').val() ,
				   dataType: 'json',
				   success:function(msg){
					 
						if ( msg.status == 0 ){
					   		//错误
					  	 	alert(msg.info);
						}					 
						else
						{
							alert(msg.info);	
						}
				   
				   }
				  });
		}
	});
	
	//点配歌曲操作
	$('#ordsong_btn').click(function(){	
								
		
		if($('#song_txt').val() =="")
		{
			//$(this).parents('td').next().find("span").addClass('alert_txt').html("不能为空<b></b>");
			alert('请填写歌曲名！');
			$('#song_txt').focus();
			return (false);
		} 
		else if($('#sing_txt').val() =="")
		{
			//$(this).parents('td').next().find("span").addClass('alert_txt').html("不能为空<b></b>");
			alert('请填写歌曲演唱者！');
			$('#sing_txt').focus(); 
			return (false);
		} 
		else
		{	
			$.ajax({
				   type: "post",
				   url: "/public/ordersong",
				   data: 'song=' + $('#song_txt').val() + '&singer=' + $('#sing_txt').val(), 
				   dataType: 'json',
				   success:function(msg){
					
						
						if ( msg.status == 0 ){
							//错误
							alert(msg.info);
						}
						else 
						{
							alert(msg.info);	
						}
										
				   
				   }
				  });
		}
		
	});
	
	//左右栏高度平衡
	if(!$('#tabzone').hasClass('tabbox1')){
	$('.left').height()>$('.right').height()?$('.right').height($('.left').height()):$('.left').height($('.right').height());
	}
	//报告错误提交建议操作
	//点配歌曲操作
	$('#report_btn').click(function(){	
								
		
		if($('#reportinput').val() =="")
		{
			//$(this).parents('td').next().find("span").addClass('alert_txt').html("不能为空<b></b>");
			//alert('请填写提交内容！');
			$('#reporttip').html('请填写提交内容！');
			$('#reportinput').focus();
			return (false);
		} 
		else if($('#reportinput').val().length>500)
		{
			//$(this).parents('td').next().find("span").addClass('alert_txt').html("不能为空<b></b>");
			//alert('内容不能超过500字！');
			$('#reporttip').html('内容不能超过500字！');
			$('#reportinput').focus(); 
			return (false);
		} 
		else
		{	
			$.ajax({
				   type: "post",
				   url: "/public/addreport",
				   data: 'type=' + $('#typeinput').val() + '&report=' + $('#reportinput').val(), 
				   dataType: 'json',
				   success:function(msg){
					
						
						if ( msg.status == 0 ){
							//错误
							$('#reporttip').html(msg.info);
						}		 
						else
						{	$('.reportform').fadeOut();
							$('#reportform').prepend("<p>"+msg.info+"</p>")
							//$('#reporttip').html(msg.info);	
						}
										
				   
				   }
				  });
		}
		
	});

	if (isInMobile.any()) {

		connectWebViewJavascriptBridge(function(bridge) {
	      var uniqueId = 1
	      
	      bridge.init(function(data, responseCallback) {
	          if (responseCallback) {
	              responseCallback(data);
	          }
	      })
	      
	      $('.openuserpage').live("click",function(){  
	        //e.preventDefault()
	        var userdata = {'uid':$(this).attr('uid')};
	        //alert(userdata);

	        bridge.callHandler('profile', userdata, function(response) {
	          //log('JS got response', response)
	        });
	        // bridge.send(userdata, function(responseData) {
	        //   //log('JS got response', responseData)
	        // })
	      });


	      $('a').live("click",function(event){

	          var url= $(this).attr('href');
	          var title= $(this).attr('title');
	          var userfilter=/^\/player\/(\d+).*$/i;
	          var zinefilter=/^http\:\/\/www.byguitar.com\/zine\/(\d+).*$/i;
	          var singerfilter=/^http:\/\/www.byguitar.com\/tab\/singer\/(\d+).*$/i;
	          var albumfilter=/^http:\/\/www.byguitar.com\/tab\/album\/(\d+).*$/i;
	          var tabfilter=/^http:\/\/www.byguitar.com\/tab\/(\d+).*$/i;
	          var postfilter=/^http:\/\/www.byguitar.com\/bbs\/viewthread\/(\d+).*$/i;

	         // var filter=/^\s*([A-Za-z0-9_-]+(\.\w+)*@(\w+\.)+\w{2,3})\s*$/;


	          if (userfilter.test(url)) 
	          { 

	            var r = url.match(userfilter); 
	            var urldata = {'uid':r[1]};
	            bridge.callHandler('profile', urldata, function(response) {
	              //处理回调
	            });
	            return false;
	            event.preventDefault();
	          }

	          if (zinefilter.test(url)) 
	          { 

	            var r = url.match(zinefilter); 
	            var urldata = {'id':r[1]};
	            bridge.callHandler('zine', urldata, function(response) {
	              //处理回调
	            });
	            return false;
	            event.preventDefault();
	          }

	          if (singerfilter.test(url)) 
	          { 
	            var r = url.match(singerfilter); 
	            var urldata = {'id':r[1]};
	            bridge.callHandler('singer', urldata, function(response) {
	              //处理回调
	            });
	            return false;
	            event.preventDefault();
	          }

	          if (albumfilter.test(url)) 
	          { 
	            var r = url.match(albumfilter); 
	            var urldata = {'id':r[1]};
	            bridge.callHandler('album', urldata, function(response) {
	              //处理回调
	            });
	            return false;
	            event.preventDefault();
	          }

	          if (tabfilter.test(url)) 
	          { 
	            var r = url.match(tabfilter); 
	            var urldata = {'id':r[1]};
	            bridge.callHandler('tab', urldata, function(response) {
	              //处理回调
	            });
	            return false;
	            event.preventDefault();
	          }

	          if (postfilter.test(url)) 
	          { 
	            var r = url.match(postfilter); 
	            var urldata = {'tid':r[1]};
	            bridge.callHandler('thread', urldata, function(response) {
	              //处理回调
	            });
	            return false;
	            event.preventDefault();
	          }
	          if (isInMobile.byguitar()) {
	          	var urlreg=/^(http)/;
	          	 if(!urlreg.test(url)){
	          	 	url="http://www.byguitar.com"+url;
	          	 };
		          var urldata = {'url':url,'title':title};
		          bridge.callHandler('openweb', urldata, function(response) {
		              //处理回调 
		          });
		          return false;
	          };
	          //event.stopPropagation(); 
	      });

	    });
	}
	
});


function connectWebViewJavascriptBridge(callback) {
	if (window.WebViewJavascriptBridge) {
	  callback(WebViewJavascriptBridge)
	} else {
	  document.addEventListener('WebViewJavascriptBridgeReady', function() {
	    callback(WebViewJavascriptBridge)
	  }, false)
	}
}

//弹出层弹出操作
function popdiv(popdiv,width,height,alpha){
	
	var A = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0; 
	var D = 0;
	D = Math.min(document.body.clientHeight, document.documentElement.clientHeight);
	if (D == 0) {
	D = Math.max(document.body.clientHeight, document.documentElement.clientHeight)
	} 
	var topheight = (A + (D - 300) / 2)-60 + "px"; 	
	$("#popbg").css({height:$(document).height(),width:document.documentElement.clientWidth,filter:"alpha(opacity="+alpha+")",opacity:alpha});
	$("#popbg").fadeIn();
	$("#pops").css({height:600,width:document.documentElement.clientWidth,top:topheight});
	$("#pops").fadeIn();
	//$(popdiv).removeClass();
	//$(popdiv).attr("class","pop_out ");
	$(".pop").css({left:(($(document).width())/2-(parseInt(width)/2))+"px",top:0});
	$(".head,.main,.foot").addClass('blur');
	$(popdiv).show();
	if ($.browser.webkit && (popdiv=="#login_pop"||popdiv=="#reg_pop")) {
		//$('#login_pop').show().css({webkitTransform:'rotateY(0deg)'});
		//$('#reg_pop').show().css({webkitTransform:'rotateY(180deg)'});
		$('#login_pop').show().css({webkitTransform:'rotateY(0deg)','z-index':'999999'});
		$('#reg_pop').show().css({webkitTransform:'rotateY(180deg)','z-index':'999998',height:'363px',overflow:'hidden'});
	} 
}

var isInMobile = {
	Android: function() {
	return navigator.userAgent.match(/Android/i) ? true : false;
	},
	BlackBerry: function() {
	return navigator.userAgent.match(/BlackBerry/i) ? true : false;
	},
	iOS: function() {
	return navigator.userAgent.match(/iPhone|iPad|iPod/i) ? true : false;
	},
	Windows: function() {
	return navigator.userAgent.match(/IEMobile/i) ? true : false;
	},
	byguitar: function() {
	return navigator.userAgent.match(/Guitar/i) || navigator.userAgent.match(/BGIOSAPP/i) ? true : false;
	},

	any: function() {
	return (isInMobile.Android() || isInMobile.BlackBerry() || isInMobile.iOS() || isInMobile.Windows()|| isInMobile.byguitar());
	}
};

function bg_share(type){
	if (type == '') return false;
	var getway = null;
	var url = bgshare.url;
	var title = bgshare.title;
	var content = bgshare.content;
	var img = bgshare.img;
	var site ='彼岸吉他网';
	if (url == '') url = window.location.href;
	if (title == '') title = document.getElementsByTagName('title')[0].innerHTML;
	if (content == '') content = title;
	content += '（来自@彼岸吉他-Byguitar）';
	if (type == 'sina'){
		getway = 'http://v.t.sina.com.cn/share/share.php?appkey=3497732399';
		url += '?from=weibo';
		getway += "&title="+encodeURIComponent(content)+"&url="+encodeURIComponent(url);
		if (img != '') getway += "&pic="+encodeURIComponent(img);
	}
	if (type == 'qq'){
		getway = 'http://connect.qq.com/widget/shareqq/index.html?';
		url += '?from=qq';
		getway += "title="+encodeURIComponent(title)+"&desc="+encodeURIComponent(content)+"&url="+encodeURIComponent(url)+"&site="+encodeURIComponent(site);
		if (img != '') getway += "&pics="+encodeURIComponent(img);
	}
	if (type == 'qzone'){
		getway = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?';
		url += '?from=qzone';
		getway += "title="+encodeURIComponent(title)+"&desc="+encodeURIComponent(content)+"&url="+encodeURIComponent(url)+"&site="+encodeURIComponent(site);
		if (img != '') getway += "&pics="+encodeURIComponent(img);
	}
	
	if (type == 'qblog'){
		getway = 'http://v.t.qq.com/share/share.php?';
		url += '?from=qqblog';
		getway += "title="+encodeURI(title)+"&url="+encodeURIComponent(url)+"&appkey=f92ccbb0e5bd4fdd8cc4343602f4ef98"+"&site="+encodeURIComponent(url)+"&site="+encodeURIComponent(site);
		if (img != '') getway += "&pic="+encodeURI(img);
	}
	
	if (type == 'douban'){
		getway = 'http://www.douban.com/recommend/?';
		url += '?from=douban';
		getway += "title="+encodeURI(title)+"&sel="+encodeURI(content)+"&v=1&url="+encodeURIComponent(url);
		if (img != '') getway += "&icon="+encodeURI(img);
	}
	if (type == 'renren'){
		getway = 'http://share.renren.com/share/buttonshare/post/4001?';
		url += '?from=renren';
		getway += "title="+encodeURI(title)+"&content="+encodeURI(content)+"&url="+encodeURIComponent(url);
		if (img != '') getway += "&pic="+encodeURI(img);
	}
	if (type == 'tieba'){
		getway = 'http://tieba.baidu.com/f/commit/share/openShareApi?';
		//url += '?from=tieba';
		getway += "title="+encodeURI(title)+"&url="+encodeURIComponent(url);
	}

	if (getway == '') return false;
	window.open(getway, "", "height=500, width=600");
	return true;
}
var sakutakashiyi=true;