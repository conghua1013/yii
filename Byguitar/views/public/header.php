<div class="head" id="bg_{*MODULE_NAME}">
	<div class="headbox">
    	<div class="fl logo"><a href="{$Think.config.WEB}" title="彼岸吉他"><img src="__PUBLIC__/Images/public/logo.gif" width="115" height="45" /></a></div>
        <div class="fl header">  
          	<ul class="fl menu">            
            	 <volist name="nav" id="menu" offset="1" length='3'>
                    <li class="nav <eq name="Think.MODULE_NAME" value="$menu.name">nav_on</eq>"><a href="__APP__/{$menu.name|strtolower}" title="{$menu.title}" hidefocus="true">{$menu.title}</a><span></span>
                        <eq name="menu.name" value="Shop"><div class="shopnewtip"></div></eq>
                    </li>                         
            	</volist>                                      
            </ul>
            <ul class="fl menu">  
            	<volist name="nav" id="menu" offset="4" length='3'> 
                    <neq name="menu.name" value="Group">
                    <li class="nav <eq name="Think.MODULE_NAME" value="$menu.name">nav_on</eq>"><a href="__APP__/{$menu.name|strtolower}" title="{$menu.title}" hidefocus="true">{$menu.title}</a><span></span></li> 
                    </neq>
            	</volist>              
            </ul>
            <ul class="fl menu">  
            	<volist name="nav" id="menu" offset="7" length='2'> 
                    <li class="nav <eq name="Think.MODULE_NAME" value="$menu.name">nav_on</eq>"><a href="__APP__/{$menu.name|strtolower}" title="{$menu.title}" hidefocus="true">{$menu.title}</a><span></span></li>  
            	</volist> 
            </ul>
            <ul class="fl sobox">
                <li><form action="/search" method="get">
                    <input class="fl soinput soinput_on" name="q" <present name='q'> value="{$q}" <else/> value="学吉他、求谱、买吉他..."</present> type="text" />
                    <input class="fl sobtn" name="" value="" type="submit" />
                    </form>
                    <div class="clear"></div></li>
                <!--<dd></dd>-->
            </ul>
            <div class="clear"></div>
        </div>
        <present name="_SESSION['authId']">
        	<div class="fr info">
                <div class="mface">
                	<eq name="_SESSION['face']" value="0">
                        <a class="qing" href="__APP__/user/"><img src="__PUBLIC__/Images/avatar/small/0.jpg" width="45" height="45" /></a>
                    <else/>
						<a class="qing" href="__APP__/user/"><img src="__PUBLIC__/Images/avatar/small/{$_SESSION['face']}" width="45" height="45" /></a>
                     </eq>
				</div>
                <ul class="uinfolist shadow">
                    <li><a class="qing" href="__APP__/user/">{@loginUserName}</a></li>
                    <li><gt name="_SESSION['msg']" value="0"><b><a class="qing" href="__APP__/user/mailspull/"><span class="hasmsgs">{@msg}</span>条消息</a></b></gt></li>
                    <li><a class="brown" href="__APP__/player/{@authId}">我的主页</a></li>
                    <li><a class="brown" href="__APP__/shop/user/orderlist/">我的订单</a></li>
                    <li><a class="brown" href="__APP__/user/set/">设置中心</a></li>
                    <li><a class="brown" href="__APP__/user/setface/">头像设置</a></li>
                    <li></li>
                    <li><a class="gray" href="__APP__/public/logout">退出</a></li>
                </ul> 
                <gt name="_SESSION['msg']" value="0"><div class="hasmsg-tip"></div></gt>
        	</div>
            <div class="fr navcart"> 
              <a class="navcart_a" title="点击进入购物车" href="/shop/cart"><img src="__PUBLIC__/Images/public/cart_empty.gif"></a>
              <span class="navcartnum" id="navcartnum"></span>
              <div class="navcartpop" id="navcartpop">
                <p class="empty">您的购物车中还没有商品！<a class="qing" href="/shop/">去商城逛逛！</a></p>
                <dl>
                </dl>
                <p class="cart_count">共<font>0</font>件商品<br/>
                  金额总计：<font>¥0.00</font></p>
                <div class="gotocart"><a class="btn btn-large btn-primary" id="gotocart">去购物车并结算</a></div>
              </div>
            </div>           
        <else />
        	<div class="fr info">
                <span class="minfo"><span>欢迎来到彼岸吉他!</span><a class="qing" href="__APP__/public/login">登录</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="brown" href="__APP__/public/reg">注册</a></span>
        	</div>
        </present>
        <div class="clear"></div>
    </div>
</div>

