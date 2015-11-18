<div class="head" id="bg_{*MODULE_NAME}">
	<div class="headbox">
    	<div class="fl logo">
            <a href="<?php echo Yii::app()->params['url']['web_url'];?>" title="彼岸吉他">
                <img src="/images/public/web/logo.png" width="115" height="45" />
            </a>
        </div>
        <div class="fl header">
            <ul class="fl menu">
                <li class="nav "><a href="/zine" title="杂志" hidefocus="true">杂志</a><span></span></li>
                <li class="nav "><a href="/tab" title="谱库" hidefocus="true">谱库</a><span></span></li>
                <li class="nav "><a href="/shop" title="TAO" hidefocus="true">TAO</a><span></span><div class="shopnewtip"></div></li>
            </ul>
            <ul class="fl menu">
                <li class="nav "><a href="/player" title="同学" hidefocus="true">同学</a><span></span></li>
                <li class="nav "><a href="/bbs" title="论坛" hidefocus="true">论坛</a><span></span></li>
            </ul>
            <ul class="fl menu">
                <li class="nav "><a href="/help" title="帮助" hidefocus="true">帮助</a><span></span></li>
                <li class="nav "><a href="/tool" title="工具" hidefocus="true">工具</a><span></span></li>
            </ul>
            <ul class="fl sobox">
                <li>
                    <form action="/search" method="get">
                        <input class="fl soinput soinput_on" name="q" value="学吉他、求谱、买吉他..." type="text">
                        <input class="fl sobtn" name="" value="" type="submit">
                    </form>
                    <div class="clear"></div>
                </li>
            </ul>
            <div class="clear"></div>
        </div>

        <?php if(isset($this->user_id) && $this->user_id): ?>
        	<div class="fr info">
                <div class="mface">
                	<?php if(!Yii::app()->session['face']): ?>
                        <a class="qing" href="/user/"><img src="/images/avatar/small/0.jpg" width="45" height="45" /></a>
                    <?php else: ?>
						<a class="qing" href="/user/"><img src="/images/avatar/small/<?php echo Yii::app()->session['face'];?>" width="45" height="45" /></a>
                     <?php endif; ?>
				</div>
                <ul class="uinfolist shadow">
                    <li><a class="qing" href="/user/"><?php echo strchr(Yii::app()->session['loginUserName'],'@',true) ; ?></a></li>
                    <li>
                        <?php if(Yii::app()->session['msg'] > 0): ?>
                            <b><a class="qing" href="/user/mailspull/">
                                <span class="hasmsgs">
                                    <?php echo Yii::app()->session['msg'];?>
                                </span>条消息</a>
                            </b>
                        <?php endif;?>
                    </li>
                    <li><a class="brown" href="/player/<?php echo $this->user_id;?>">我的主页</a></li>
                    <li><a class="brown" href="/user/orderlist/">我的订单</a></li>
                    <li><a class="brown" href="/user/set/">设置中心</a></li>
                    <li><a class="brown" href="/user/setface/">头像设置</a></li>
                    <li></li>
                    <li><a class="gray" href="/user/logout">退出</a></li>
                </ul>
                <?php if(Yii::app()->session['msg'] > 0): ?><div class="hasmsg-tip"></div><?php endif;?>
        	</div>
            <div class="fr navcart"> 
                <a class="navcart_a" title="点击进入购物车" href="/cart"><img src="/images/public/cart_empty.gif"></a>
                <span class="navcartnum" id="navcartnum"></span>
                <div class="navcartpop" id="navcartpop">
                    <p class="empty">您的购物车中还没有商品！<a class="qing" href="/">去商城逛逛！</a></p>
                    <dl></dl>
                    <p class="cart_count">共<font>0</font>件商品<br/>
                      金额总计：<font>¥0.00</font></p>
                    <div class="gotocart"><a class="btn btn-large btn-primary" id="gotocart">去购物车并结算</a></div>
                </div>
            </div>           
        <?php else: ?>
        	<div class="fr info">
                <span class="minfo">
                    <span>欢迎来到彼岸吉他!</span>
                    <a class="qing" href="/user/login">登录</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="brown" href="/user/reg">注册</a>
                </span>
        	</div>
        <?php endif; ?>
        <div class="clear"></div>
    </div>
</div>

