//热键绑定代码
(function(jQuery){
	
	jQuery.hotkeys = {
		version: "0.8",

		specialKeys: {
			8: "backspace", 9: "tab", 13: "return", 16: "shift", 17: "ctrl", 18: "alt", 19: "pause",
			20: "capslock", 27: "esc", 32: "space", 33: "pageup", 34: "pagedown", 35: "end", 36: "home",
			37: "left", 38: "up", 39: "right", 40: "down", 45: "insert", 46: "del", 
			96: "0", 97: "1", 98: "2", 99: "3", 100: "4", 101: "5", 102: "6", 103: "7",
			104: "8", 105: "9", 106: "*", 107: "+", 109: "-", 110: ".", 111 : "/", 
			112: "f1", 113: "f2", 114: "f3", 115: "f4", 116: "f5", 117: "f6", 118: "f7", 119: "f8", 
			120: "f9", 121: "f10", 122: "f11", 123: "f12", 144: "numlock", 145: "scroll", 191: "/", 224: "meta"
		},
	
		shiftNums: {
			"`": "~", "1": "!", "2": "@", "3": "#", "4": "$", "5": "%", "6": "^", "7": "&", 
			"8": "*", "9": "(", "0": ")", "-": "_", "=": "+", ";": ": ", "'": "\"", ",": "<", 
			".": ">",  "/": "?",  "\\": "|"
		}
	};

	function keyHandler( handleObj ) {
		// Only care when a possible input has been specified
		if ( typeof handleObj.data !== "string" ) {
			return;
		}
		
		var origHandler = handleObj.handler,
			keys = handleObj.data.toLowerCase().split(" ");
	
		handleObj.handler = function( event ) {
			// Don't fire in text-accepting inputs that we didn't directly bind to
			if ( this !== event.target && (/textarea|select/i.test( event.target.nodeName ) ||
				 event.target.type === "text") ) {
				return;
			}
			
			// Keypress represents characters, not special keys
			var special = event.type !== "keypress" && jQuery.hotkeys.specialKeys[ event.which ],
				character = String.fromCharCode( event.which ).toLowerCase(),
				key, modif = "", possible = {};

			// check combinations (alt|ctrl|shift+anything)
			if ( event.altKey && special !== "alt" ) {
				modif += "alt+";
			}

			if ( event.ctrlKey && special !== "ctrl" ) {
				modif += "ctrl+";
			}
			
			// TODO: Need to make sure this works consistently across platforms
			if ( event.metaKey && !event.ctrlKey && special !== "meta" ) {
				modif += "meta+";
			}

			if ( event.shiftKey && special !== "shift" ) {
				modif += "shift+";
			}

			if ( special ) {
				possible[ modif + special ] = true;

			} else {
				possible[ modif + character ] = true;
				possible[ modif + jQuery.hotkeys.shiftNums[ character ] ] = true;

				// "$" can be triggered as "Shift+4" or "Shift+$" or just "$"
				if ( modif === "shift+" ) {
					possible[ jQuery.hotkeys.shiftNums[ character ] ] = true;
				}
			}

			for ( var i = 0, l = keys.length; i < l; i++ ) {
				if ( possible[ keys[i] ] ) {
					return origHandler.apply( this, arguments );
				}
			}
		};
	}

	jQuery.each([ "keydown", "keyup", "keypress" ], function() {
		jQuery.event.special[ this ] = { add: keyHandler };
	});

})( jQuery );
//用户表单验证相关
$(document).ready(function(){
			   
						   
	//$(".prevIndex").val("0");
	//默认-1	
	var DdSize=$(".maillist li").size();
	//.maillist中li的数量	
	$(".do_input").focus(function(){		
  		$(this).addClass("on_input");
	}); 
	$(".do_input").blur(function(){
  		$(this).removeClass("on_input");
	}); 
	$(".uemail").focus(function(){								
  		$(this).parent().find('.maillist').find('li:first').attr("id","dd_0").attr("index",'0').addClass('mail_on');		
		if($(this).val() =="")
		{							
			$(this).parents('td').next().find("span").removeClass().empty();			
			if($(this).hasClass('popemail'))
			{
				$(this).parents('td').next().find("span").addClass('oked_txt').html("请使用有效邮箱<b></b>");
				
			}
			else
			{
				$(this).parents('td').next().find("span").addClass('oked_txt').html("登录彼岸吉他网，订阅《彼岸吉他》杂志，以及找回密码时要用到。<b></b>");
			}
			return (false);
		}
		
	}); 


	$(".account").focus(function(){								
  		$(this).parent().find('.maillist').find('li:first').attr("id","dd_0").attr("index",'0').addClass('mail_on');		
		if($(this).val() =="")
		{							
			$(this).parents('td').next().find("span").removeClass().empty();			
			if($(this).hasClass('popaccount'))
			{
				$(this).parents('td').next().find("span").addClass('oked_txt').html("Email或用户名登录<b></b>");
				
			}
			else
			{
				$(this).parents('td').next().find("span").addClass('oked_txt').html("请用Email或用户名登录彼岸吉他网。<b></b>");
			}
			return (false);
		}
		
	}); 
	 
	 $(".uemail").blur(function(){		
  		CheckEmail($(this));		
	}); 	
	
	$("#nick").focus(function(){
	    $(this).select();	
		if($(this).val() =="")
		{   $(this).parents('td').next().find("span").removeClass().addClass('oked_txt').html("字母,数字,下划线,汉字<b></b>");
			return (false);
		}  
	}); 
	 $("#nick").blur(function(){		
  		CheckNick($(this));
	}); 
	 
	
	$("#password,#confirm_password,#login_psword").focus(function(){
		if($(this).val() =="")
		{   $(this).parents('td').next().find("span").removeClass().empty();
			if($(this).attr('id')=="login_psword")
			{
				$(this).parents('td').next().find("span").removeClass().html("<a class='qing' href='/public/resetpassword/'>忘记密码了？</a>");
			}
			else
			{
				$(this).parents('td').next().find("span").addClass('oked_txt').html("不能少于6位字符<b></b>");
			}
			
			
			
			return (false);
		}  
	}); 
	$("#password,#login_psword").focus(function(){
		$(this).select();									  	
		
	}); 	
	$("#password,#login_psword,#nick").select(function(){							  	
		$('.maillist').hide();
	});
	
	
	
	$("#password,#confirm_password,#login_psword").blur(function(){
		CheckPassword($(this));
	});
	
	$("#confirm_password").focus(function(){
		if($(this).val() =="")
		{   $(this).parents('td').next().find("span").removeClass().addClass('oked_txt').html("请再次输入密码<b></b>");
			return (false);
		}  
	}); 
	$("#confirm_password").blur(function(){								 
		ComparePassword($(this).parents('tr').prev().find("input"),$(this));
	}); 
	
	
	$("#captcha").focus(function(){
		if($(this).val() =="")
		{   $(this).parents('td').next().find("span").removeClass().html("");
			return (false);
		}  
	});
	
	$("#captcha").blur(function(){
		CheckYzm($(this));
	}); 
	
	
	
	
	$(".maillist").hover(function(){  		
	}, function(){			
		$(this).hide();	
	});
	
	$(".uemail").mousedown(function(){
  		$(this).parent().find('.maillist').hide();
	});
	
	//email的keyup事件操作						
	$(".uemail").keyup(function(event){	
	//过滤回车键	
	//if (window.event.keyCode==13) window.event.keyCode=9;
	if((event.keyCode !=13))
	{
  		$(this).parent().find('.maillist').show();		
		$(this).parent().find('.maillist').find('li').eq(0).html($(this).val());		
		var mtxt="";
		mtxt=$(this).val().split("@");
		var mailregu=$(this).val(); 		 
		var mailre=new RegExp(mailregu);
		var sort=1;			
		$(this).parent().find('.maillist').find('li').not(':first').each(function(index) { 
			$(this).html(mtxt[0]+"@"+$(this).attr('addr'));					
			if($(this).text().search(mailre)!=-1)
			{
				$(this).show();	
				$(this).attr("id","dd_"+sort).attr("index",sort);	
				sort++;
			}     
			else     
			{   
				$(this).hide();
				$(this).attr("id","").attr("index","");	
			} 
		DdSize=sort;		
		});	
		if($(this).parent().find(".prevIndex").val()>sort)
		{
			$(this).parent().find(".prevIndex").val(0);		
		}	
	}
	else
	{	
		$(this).parent().find(".prevIndex").val(0);
		$(this).parent().find('.maillist').find('li').eq(0).addClass('mail_on').siblings().removeClass('mail_on');		
		$(this).blur();		
		$(this).parents('tr').next().find("input").select();
		$(this).parents('tr').next().find("input").focus();
		//checkLoginForm($('#loginForm'));
	}
	}); 	
	
	//得到焦点文本框光标在最后位置函数
	function setinputfocus(input)
	{  		
		input.blur();		
		input.parents('tr').next().find("input").select();
		input.parents('tr').next().find("input").focus();

		//checkLoginForm($('#loginForm'));
	}
	//回车相应函数
	function clickDd(currIndex,isme) {
		var prevIndex=isme.parent().find(".prevIndex").val();
		
		isme.parent().find('.maillist').find("#dd_0").remove("mail_on");
		if(currIndex>-1) {
			isme.parent().find('.maillist').find("#dd_"+currIndex).addClass("mail_on").siblings().removeClass('mail_on');
		}
		isme.parent().find('.maillist').find("#dd_"+prevIndex).removeClass("mail_on");
		isme.parent().find(".prevIndex").val(currIndex);
	}
	
	$(".maillist li").mouseover(function () {
		//鼠标滑过
		$(this).addClass("mail_on");
		//$(this).parents('td').find('.uemail').val($(this).html());
	}).mouseout(function () {
		//鼠标滑出
		$(this).removeClass("mail_on");
	}).click(function () {
		//鼠标单击		
		var prevIndex=parseInt($(this).parent().find(".prevIndex").val());
		$(this).parents('td').find('.uemail').val($(this).html());
		$(this).parents('td').find('.maillist').hide();
		var emailinput=$(this).parents('td').find('.uemail').eq(0);		
		setinputfocus(emailinput);	
	});	
	
	//email输入框绑定键盘上下回车键事件
	$(".uemail").bind('keydown','up',function (evt) {
		//↑
		//alert($(this).attr('id'));
		var prevIndex=parseInt($(this).parent().find(".prevIndex").val());
		if(prevIndex==-1||prevIndex==0) {
			clickDd(DdSize-1,$(this));
		}else if(prevIndex>0) {
			clickDd(prevIndex-1,$(this));
		}
		return false;
	}).bind('keydown','down',function (evt) {
		//↓
		var prevIndex=parseInt($(this).parent().find(".prevIndex").val());
		if(prevIndex==-1||prevIndex==(DdSize-1)) {
			clickDd(0,$(this));
		}else if(prevIndex<(DdSize-1)) {
			clickDd(prevIndex+1,$(this));
		}
		return false;
	}).bind('keydown','return',function (evt) {
		//↙
		var prevIndex=parseInt($(this).parent().find(".prevIndex").val());
		$(this).focus();
		$(this).val($(this).parent().find('.maillist').find("#dd_"+prevIndex).html());
		$(this).parent().find('.maillist').hide();
		return false;
	});
	
	//clickDd(0);	
	$('#loginForm').keydown(function(event){
		if((event.keyCode ==13))
		{
			checkLoginForm();
		}
	});
	$('#formUser').keydown(function(event){
		if((event.keyCode ==13))
		{			
			checkSignupForm();
		}		
	});
	/*
	$('#formReset').keydown(function(event){
		if((event.keyCode ==13))
		{			
			checkResetForm();
		}		
	});
	*/
 	$('.login_btn').click(function(){
		checkLoginForm();
	});
	
	$('.reg_btn').click(function(){
		checkSignupForm();
	});

	$('.reset_btn').click(function(){
		checkResetForm();
	});

	$('.set_btn').click(function(){
		checkSetForm();
	});
	
	
	/*
	//登录注册Tab切换
	$('.setbars').click(function(){
		$(this).addClass('setbars_on').siblings().removeClass('setbars_on');	
		$('.regbox').find('dd').hide();
		$('.regbox').find('dd').eq($('.regbar_box').find('li').index(this)).show();			
	});
	//登录注册Tab切换
	$('.regbar_box').find('li').click(function(){
		$(this).addClass('regbar_on').siblings().removeClass('regbar_on');	
		$('.regbox').find('dd').hide();
		$('.regbox').find('dd').eq($('.regbar_box').find('li').index(this)).show();			
	});*/
	
	//内部邮件列表hover效果操作
	$('.mailtab_tr').hover(function(){	
		$(this).addClass('mailtab_on');		
	}, function(){
		$(this).removeClass('mailtab_on');			
	});
	
	//发内部邮件按钮操作
	$('.mailto_btn').click(function(){	
	if($(this).prev().val()=="")
	{	$(this).prev().addClass('mailtxt_on');
	$(this).prev().fadeOut().fadeIn().fadeOut().fadeIn().fadeOut().fadeIn('fast', function(){$(this).prev().focus();});				
	}
	});
	$('.mailtxt').focus(function(){	
	$(this).removeClass('mailtxt_on');
	});
	
});	


function CheckEmail(Email)
{	//Email.parent().parent().next().find(".do_tip").remove();
	Email.parents('td').next().find("span").removeClass().empty();
	if(Email.val() =="")
	{		
		//Email.parent().parent().next().find(".do_tip").show();
		Email.parents('td').next().find("span").addClass('alert_txt').html("不能为空<b></b>");
	    return (false);
	}    
	var filter=/^\s*([A-Za-z0-9_-]+(\.\w+)*@(\w+\.)+\w{2,3})\s*$/;
    if (!filter.test(Email.val())) 
	{ 
		Email.parents('td').next().find("span").addClass('alert_txt').html("格式有误<b></b>");
       	return (false); 
   	}
	else
	{	
		if($(Email).attr('id')=="login_user")
			{
				Email.parents('td').next().find("span").html("");
			}
			else
			{	Email.parents('td').next().find("span").addClass('oked_txt').html("邮件验证中...<b></b>");		
				$.ajax({
				   type: "post",
				   url: "/user/checkmail",
				   data: 'email=' + Email.val() + "&m=" + Math.random(),
				   success:function(msg){
				   if ( msg == 'ok' ){
				   		Email.attr('cked','true');
					   Email.parents('td').next().find("span").removeClass().addClass('ok_txt').html("&nbsp;");
					}
					else
					{	Email.attr('cked','false');
						Email.parents('td').next().find("span").removeClass().addClass('alert_txt').html("已被注册<b></b>");
					}
				   }
				  });
			}
			return (false);
		
	    
	}
}


function CheckNick(Nick)
{
	
	var filter=/^[\u4e00-\u9fa5a-zA-Z0-9_]+$/;
	var nicklen =nanmelen(Nick.val());
    if(nicklen>0)
	{

		if(nicklen>3&&nicklen<18){

			if (!filter.test(Nick.val())) 
			{ 
				Nick.parents('td').next().find("span").removeClass().addClass('alert_txt').html("有非法字符<b></b>");
				return (false); 
			}
			else
			{
				//Nick.parents('td').next().find("span").removeClass().addClass('ok_txt').html("&nbsp;");
				Nick.parents('td').next().find("span").addClass('oked_txt').html("验证中...<b></b>");		
				$.ajax({
				   type: "post",
				   url: "/user/checkname",
				   data: 'name=' + Nick.val() + "&m=" + Math.random(),
				   success:function(msg){
				   if ( msg == 'ok' ){
				   		Nick.attr('cked','true');
					   Nick.parents('td').next().find("span").removeClass().addClass('ok_txt').html("&nbsp;");
					}
					else
					{	Nick.attr('cked','false');
						Nick.parents('td').next().find("span").removeClass().addClass('alert_txt').html("已被占用<b></b>");
					}
				   }
				  });
			}
		}
		else 
		{
			
			Nick.parents('td').next().find("span").removeClass().addClass('alert_txt').html("4-18个字符<b></b>");
			return (false);
		}
	}
	else
	{
		Nick.parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");
		return (false);
		
    }
}

function nanmelen(str) {
  var len = 0;
  for (var i = 0; i < str.length; i++) {
    len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (document.charset == 'utf-8' ? 3 : 2) : 1;
  }
  return len;
}


function CheckPassword(password)
{	
	if(password.val().length>0)
	{
		if(password.attr('id')!="login_psword")			
			{
				if(password.val().length<6)
				{	password.parents('td').next().find("span").removeClass().addClass('alert_txt').html("密码太短<b></b>");
					return false;
				}				
			}		
			
	}
	else
	{
		password.parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");
		return false;
	}
	if(password.attr('id')!="login_psword")			
	{
		password.parents('td').next().find("span").removeClass().addClass('ok_txt').html("&nbsp;");
		return false;
	}	
	
	
}


function ComparePassword(password1,password2)
{	
	
	if(password2.val().length>0)
	{
		if (password1.val()!=password2.val())
		{
			password2.parents('td').next().find("span").removeClass().addClass('alert_txt').html("确认有误<b></b>");
			return false;
		} 
		else
		{
			password2.parents('td').next().find("span").removeClass().addClass('ok_txt').html("&nbsp;");
		}
	}
	else
	{
		password2.parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");
		return false;
	}
	
}


function CheckYzm(yzm)
{	
	if(yzm.val().length==0)
	{
		yzm.parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");
		return false;
	}
		
}


function checkLoginForm() 
{		
	
	if($('#login_user').val() =="")
	{		
		$('#login_user').parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");
        return false;
	}    
	var filter=/^\s*([A-Za-z0-9_-]+(\.\w+)*@(\w+\.)+\w{2,3})\s*$/;
    if (!filter.test($('#login_user').val())) 
	{ 	
		var nfilter=/^[\u4e00-\u9fa5a-zA-Z0-9_]+$/;
		if (!nfilter.test($('#login_user').val())) {

			$('#login_user').parents('td').next().find("span").removeClass().addClass('alert_txt').html("有非法字符<b></b>");
        	return false;
		}


   	} 
		$('#login_user').parents('td').next().find("span").removeClass().html("");


	
	if($('#login_psword').val().length<=0)	
	{
		$('#login_psword').parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");
		return false;
	}
		$('#login_psword').parents('td').next().find("span").removeClass().html("");
		
	var remember = '';
	if($('#remember').checked){remember = $('#remember').value;}
	$('#loginForm').submit();
	/*$.ajax({
	   type: "POST",
	   url: "user.php",
	   data: 'act=check_login_info&username=' + $('#login_user').val() + '&password=' + $('#login_psword').val() + '&m=' + Math.random(),
	   success:function(msg){
    	    if(msg == 0)
    	    {
    	        //alert('用户名或密码错误');
				thisform.find('input:button').eq(0).parent().find("span").eq(0).removeClass('').addClass('alert_txt').html("Email或密码错误！<b></b>");
    	    }
    	    else
    	    {
				thisform.find('input:button').eq(0).parent().find("span").eq(0).removeClass().addClass('ok_txt').html("&nbsp;");
    	        //document.loginForm.submit();
				$('#loginForm').submit();
    	    }
	   }
	  });
	*/
	
}


function checkSignupForm() {    	
	if($('#email').val() =="")
	{		
		$('#email').parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");
		$('#email').select();
		$('#email').focus();
        return false;
	}    
	var filter=/^\s*([A-Za-z0-9_-]+(\.\w+)*@(\w+\.)+\w{2,3})\s*$/;
    if (!filter.test($('#email').val())) 
	{ 
		$('#email').parents('td').next().find("span").removeClass().addClass('alert_txt').html("格式有误<b></b>");
        return false; 
   	}
    if($('#email').attr('cked')=="false"){ 
     //$('#email').focus();
	 //$('#email').select();
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



	if($('#password').val().length>0)
	{
		
		if($('#password').val().length<6)
		{	$('#password').parents('td').next().find("span").removeClass().addClass('alert_txt').html("密码太短<b></b>");
			return false;
		}		
		else
		{
			$('#password').parents('td').next().find("span").removeClass().addClass('ok_txt').html("&nbsp;");
		}
	}
	else
	{
		$('#password').parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");	
		$('#password').select();
		$('#password').focus();
		return false;
	}
  
  if ($('#password').val() != $('#confirm_password').val()) {
		$('#confirm_password').parents('td').next().find("span").removeClass().addClass('alert_txt').html("确认有误<b></b>");
		return false;
  }   
  else
  {
	  	$('#confirm_password').parents('td').next().find("span").removeClass().addClass('ok_txt').html("&nbsp;");
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
		$("#agree").parents('td').next().find("span").removeClass().addClass('ok_txt').html("&nbsp;");
     }
  }
  if ($("#captcha").val() == '' )
  {
    $("#captcha").parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");
	$("#captcha").select();
	$("#captcha").focus();
    return false;
  }
  
  $.ajax({
	   type: "POST",
	   url: "/user/checkverify",
	   data: 'verify=' + $('#captcha').val() + '&m=' + Math.random(),
	   success:function(msg){
		  
    	    if(msg == 'error')
    	    {
    			$("#captcha").parents('td').next().find("span").removeClass().addClass('alert_txt').html("验证码不正确<b></b>");
    	        return false;
    	    } 
			/*else if(msg == -1)
    	    {
				$("#captcha").parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");
				$("#captcha").select();
				$("#captcha").focus();
				return false;
    	    }*/
    	    else
    	    {	
				$("#captcha").parents('td').next().find("span").removeClass().addClass('ok_txt').html("&nbsp;");
    	        //document.formUser.submit();
				$('#formUser').submit();
			   
    	    }
			
	   }
	  });
  
  
}

function checkResetForm() {    	
	if($('#login_user').val() =="")
	{		
		$('#login_user').parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");
		$('#login_user').select();
		$('#login_user').focus();
        return false;
	}    
	var filter=/^\s*([A-Za-z0-9_-]+(\.\w+)*@(\w+\.)+\w{2,3})\s*$/;
    if (!filter.test($('#login_user').val())) 
	{ 
		$('#login_user').parents('td').next().find("span").removeClass().addClass('alert_txt').html("格式有误<b></b>");
        return false; 
   	}

    if($('#login_user').attr('cked')=="flase"){
     //$('#email').focus();
	 //$('#email').select();
     return false;
  }



  
  if ($("#captcha").val() == '' )
  {
    $("#captcha").parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");
	$("#captcha").select();
	$("#captcha").focus();
    return false;
  }
  
  $.ajax({
	   type: "POST",
	   url: "/public/checkverify",
	   data: 'verify=' + $('#captcha').val() + '&m=' + Math.random(),
	   success:function(msg){
		  
    	    if(msg == 'error')
    	    {
				
    			$("#captcha").parents('td').next().find("span").removeClass().addClass('alert_txt').html("验证码不正确<b></b>");
    	        return false;
    	    } 
			/*else if(msg == -1)
    	    {
				$("#captcha").parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");
				$("#captcha").select();
				$("#captcha").focus();
				return false;
    	    }*/
    	    else
    	    {	
				$("#captcha").parents('td').next().find("span").removeClass().addClass('ok_txt').html("&nbsp;");
    	        //document.formUser.submit();
				$('#formReset').submit();
				$('#reset_btn').removeClass('reset_btn');
			   
    	    }
			
	   }
	  });
  
  
}

function checkSetForm() {    	
	if($('#password').val().length>0)
	{
		
		if($('#password').val().length<6)
		{	$('#password').parents('td').next().find("span").removeClass().addClass('alert_txt').html("密码太短<b></b>");
			return false;
		}		
		else
		{
			$('#password').parents('td').next().find("span").removeClass().addClass('ok_txt').html("&nbsp;");
		}
	}
	else
	{
		$('#password').parents('td').next().find("span").removeClass().addClass('alert_txt').html("不能为空<b></b>");	
		$('#password').select();
		$('#password').focus();
		return false;
	}
  
  if ($('#password').val() != $('#confirm_password').val()) {
		$('#confirm_password').parents('td').next().find("span").removeClass().addClass('alert_txt').html("确认有误<b></b>");
		return false;
  }   
  else
  {
	  	$('#confirm_password').parents('td').next().find("span").removeClass().addClass('ok_txt').html("&nbsp;");
	}

	$('#formSet').submit();
	$('#set_btn').removeClass('set_btn');

}


