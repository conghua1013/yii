(function ($) {
$.fn._delay = $.fn.delay;
	$.fn.delay = function () {
		var arg = arguments,
			tid = '${tid}';
 
		this._hover = this.hover;
 
		this.hover = function (over, out) {
			over = over || $.noop;
			out = out || $.noop;
			this._hover(function (event) {
				var elem = this;
 
				elem[tid] && clearTimeout(elem[tid]);
				elem[tid] = setTimeout(function () {
					over.call(elem, event);
				}, arg[0]);
 
			}, function (event) {
				var elem = this;
 
				elem[tid] && clearTimeout(elem[tid]);
				elem[tid] = setTimeout(function () {
					out.call(elem, event);
				}, arg[0]);
			});
 
			return this;
		};
 
		return this._delay.apply(this, arg);
	};
})(jQuery);
$(document).ready(function(){

	
	$('.close').click(function(){											  
		
		$(this).parent().hide();		
		
	});
	
	$(".pop_x").live("click", function(){		
		$(this).parent().fadeOut();
		$("#popbg").fadeOut();
	});		
	
	
	

	
	$('.input').focus(function(){
					
		$(this).removeClass('input-on');	
				
	});
	
	$('.input').blur(function(){
					
		$(this).addClass('input-on');	
				
	});	
	
	$('.like').live("click",function(){	
		
		$(this).addClass('like-on');
		$(this).unbind('click');	
	});
	
	$('.like-on').live("click",function(){	
		
		$(this).removeClass('like-on');
		$(this).unbind('click');	
	});
	
	
	/*$('.xin').live("mouseenter",function(){											  
		
		$(this).addClass('xin_on xin_ons');		
				
	});
	$('.xin').live("mouseleave",function(){
	
		if($('.xin').hasClass('xinon'))
		{
			$(this).addClass('xin_on');
		}
		else
		{
			$(this).removeClass('xin_on');
		}	
				
	});
	
	$('.xin_btn').live("click",function(){	
		
		$(this).addClass('xinon');
		$(this).unbind('click');	
	});
	
	
	
	
	$('.toshow dd').hover(function(){											  
		
		$(this).addClass('toshow_on');		
		
	}, function(){	
	
		$(this).removeClass('toshow_on');
				
	});
		*/
	
	
	
		
	$('#plog_btn').click(function(){											  
		
		$('.popbox').hide();
		popdiv("#login_pop","665","auto",0.4);		
		
	});
	
	$('#preg_btn').click(function(){											  
		
		$('.popbox').hide();
		popdiv("#reg_pop","665","auto",0.4);
		
	});	
	
	//pops页弹出层弹出范例
	$('.regpopbox').click(function(){											  
		
		$('.popbox').hide();
		popdiv("#reg_pop","665","auto",0.4);		
		
	});
	
	$('.loginpopbox').click(function(){											  
		
		$('.popbox').hide();
		popdiv("#login_pop","665","auto",0.4);		
		
	});
	
	$('.wbpopbox').click(function(){											  
		
		$('.popbox').hide();
		popdiv("#wb_pop","665","auto",0.4);		
		
	});
	$('.resetpopbox1').click(function(){											  
		
		$('.popbox').hide();
		popdiv("#reset1_pop","665","auto",0.4);		
		
	});
	$('.resetpopbox2').click(function(){											  
		
		$('.popbox').hide();
		popdiv("#reset2_pop","665","auto",0.4);		
		
	});
	$('.resetpopbox3').click(function(){											  
		
		$('.popbox').hide();
		popdiv("#reset3_pop","665","auto",0.4);		
		
	});
	
	
	

	
});

function popdiv(popdiv,width,height,alpha){
	
	var A = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0; 
	var D = 0;
	D = Math.min(document.body.clientHeight, document.documentElement.clientHeight);
	if (D == 0) {
	D = Math.max(document.body.clientHeight, document.documentElement.clientHeight)
	} 
	var topheight = (A + (D - 300) / 2)+100 + "px"; 	
	$("#popbg").css({height:$(document).height(),width:$(document).width(),filter:"alpha(opacity="+alpha+")",opacity:alpha})
	$("#popbg").show();	
	$(popdiv).css({left:(($(document).width())/2-(parseInt(width)/2))+"px",top:topheight});
	$(popdiv).show();
}