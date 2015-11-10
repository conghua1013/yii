<div id="pops">

    <!-- 加入购物车弹出层 -->
    <dl class="pop bup_pup" id="buy_pop" style="display:none">
        <dt>
        <div class="fl pop_top">商品已加入购物车</div>
        <div class="fr pop_close close"><img alt="关闭" src="__PUBLIC__/Images/ucenter/pop_close.gif" width="21" height="20"></div>
        <div class="clear"></div>
        </dt>
        <dd>
            <div class="goinfo clearfix">
                <a class="fl" href="" id="pop_product_href">
                    <img width="160" id="pop_product_img" src="__PUBLIC__/Images/shop/bpic-1.jpg" class="switch_item">
                </a>
                <p class="fl"> <b id="pop_product_name"></b><br />
                    <br />
                    数量：<span id="pop_product_num"></span><br />
                    <br />
                    总金额：<span id="pop_product_price"></span> </p>
            </div>
            <div class="gobtn clearfix"> <span class="btn btn-large btn-brown close">继续逛</span> <a class="btn btn-large btn-primary white" href="/cart/index">去结算</a> </div>
        </dd>
    </dl>


    <!-- 删除购物车弹出层 -->
    <dl class="pop del_pop" id="del_pop">
        <dt>
        <div class="fl pop_top">要删除该商品吗？</div>
        <div class="fr pop_close close"><img alt="关闭" src="/images/ucenter/pop_close.gif" width="21" height="20"></div>
        <div class="clear"></div>
        </dt>
        <dd>
            <div class="goinfo clearfix">
                <a class="fl" href=""><img width="160" height="160" src="Images/shop/bpic-1.jpg" id="pImg" class="switch_item"></a>
                <p class="fl">
                    <b id="pName"></b><br /><br />
                    数量：<span id="pNum"></span><br /><br />
                    总金额：<span id="pPrice"></span>
                </p>
            </div>
            <div class="gobtn clearfix">
                <a class="btn btn-large btn-primary white" id="del_confirm_btn" href="javascript:void(0);">删除</a>
                <span class="btn btn-large btn-brown close">取消</span>
            </div>
        </dd>
    </dl>


    <!-- 支付提示弹出层 -->
    <dl class="pop pay_pop" id="pay_pop">
        <dt>
        <div class="fl pop_top">支付提示</div>
        <div class="fr pop_close close"><img alt="关闭" src="/Public/Images/ucenter/pop_close.gif" width="21" height="20"></div>
        <div class="clear"></div>
        </dt>
        <dd>
            <div class="goinfo">
                <p class=""> <b>请您在新打开的网上银行页面进行支付</b><br />
                    支付完成前请不要关闭该窗口</p>
            </div>
            <div class="gobtn clearfix">
                <span class="btn btn-large close">支付遇到问题</span>
                <a class="btn btn-large btn-primary white" href="/user/orderlist">完成支付了</a></div>
        </dd>
    </dl>


    <dl class="pop card back" id="reg_pop">
        <dt>
        <div class="fl pop_top">注册为彼岸用户</div>
        <div class="fr pop_close close"><img alt="关闭" src="__PUBLIC__/Images/ucenter/pop_close.gif" width="21" height="20" /></div>
        <div class="clear"></div>
        </dt>
        <dd>
            <div class="pop_regform">
                <form name="formUser" method="post" action="__ROOT__/public/insert" id="formUser">
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="dotab">
                        <tr>
                            <td height="50" align="right" valign="middle"><strong>E-mail:</strong></td>
                            <td width="305" valign="middle">
                                <div class="mailline">
                                    <input type="text" class="do_input uemail popemail" id="email" autocomplete="off" value="" name="email" />
                                    <ul class="maillist">
                                        <span>请选择邮箱类型-支持键盘↑↓键选取</span>
                                        <li class="inputmail"></li>
                                        <li addr="163.com">@163.com</li>
                                        <li addr="126.com">@126.com</li>
                                        <li addr="263.com">@263.com</li>
                                        <li addr="qq.com">@qq.com</li>
                                        <li addr="hotmail.com">@hotmail.com</li>
                                        <li addr="gmail.com">@gmail.com</li>
                                        <li addr="sohu.com">@sohu.com</li>
                                        <li addr="chinaren.com">@chinaren.com</li>
                                        <li addr="yahoo.com.cn">@yahoo.com.cn</li>
                                    </ul>
                                    <input type="hidden" class="prevIndex" name="prevIndex"  value="-1" />
                                </div>
                            </td>
                            <td width="140" align="left" valign="middle"><span></span></td>
                        </tr>
                        <tr>
                            <td height="50" align="right" valign="middle"><strong>昵称:</strong></td>
                            <td valign="middle"><input type="text" class="do_input psd_input" id="nick" name="username"  /></td>
                            <td align="left" valign="middle"><span></span></td>
                        </tr>
                        <tr>
                            <td height="50" align="right" valign="middle"><strong>密码:</strong></td>
                            <td valign="middle"><input type="password" class="do_input psd_input" id="password" name="password" /></td>
                            <td align="left" valign="middle"><span></span></td>
                        </tr>
                        <tr>
                            <td height="50" align="right" valign="middle"><strong>确认密码:</strong></td>
                            <td valign="middle"><input type="password" class="do_input psd_input" id="confirm_password" name="confirm_password" /></td>
                            <td align="left" valign="middle"><span></span></td>
                        </tr>
                        <tr>
                            <td height="50" align="right" valign="middle"><strong>验证码:</strong></td>
                            <td valign="middle"><span class="yzm_box"><input type="text" class="do_input yzm_input" id="captcha" name="verify" /></span><img class="yzmimg" src="__ROOT__/public/verify/" width="50" height="26" /><a tabindex="-1" class="qing cursor" id="yzmimglook">看不清？换一张</a></td>
                            <td align="left" valign="middle"><span></span></td>
                        </tr>
                        <tr>
                            <td height="25" align="right" valign="middle">&nbsp;</td>
                            <td valign="middle"><label for="agree"><input type="checkbox" class="autologin" id="agree" checked="checked" name="agree" />
                                    我同意</label> <a class="brown" tabindex="-1" href="__ROOT__/public/agreement">《彼岸网使用协议》</a></td>
                            <td align="left" valign="middle"><span></span></td>
                        </tr>
                        <tr>
                            <td height="56" align="right" valign="middle">&nbsp;</td>
                            <td valign="middle">
                                <button type="button" class="btn btn-primary btn-large reg_btn" name="reg_btn">注&nbsp;&nbsp;册</button>已注册？<a class="brown" id="pop_tolog">登录</a></td>
                            <td valign="middle"><span></span>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="regs_intro pop_intro">
                <!--<p>注册会员，您可分享更多的吉他资讯，谱子，视频等服务，结交新朋友，享受我们《彼岸吉他》杂志的订阅服务，和更多不断开发的新服务，彼岸欢迎您的参与。</p>
                -->
                <b></b>
                <p class="snsbtn snsloginbtn snspopbtn">
                    <span class="fl">便捷登录:</span>
                    <a class="qq qq_on" href="{$qqh_url}" title="用QQ账号登陆">QQ登录</a>
                    <a class="sina sina_on" href="{$sina_weibo_url}" title="用新浪微博账号登陆">微博登录</a>
                <div class="clear"></div>
                </p>
            </div>
        </dd>
    </dl>

    <dl class="pop card front eff" id="login_pop">
        <dt>
        <div class="fl pop_top">登录彼岸吉他网</div>
        <div class="fr pop_close close"><img alt="关闭" src="__PUBLIC__/Images/ucenter/pop_close.gif" width="21" height="20" /></div>
        <div class="clear"></div>
        </dt>
        <dd>
            <div class="pop_regform">
                <form method="post" action="__ROOT__/public/checklogin" name="loginForm" id="loginForm">
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="dotab">
                        <tr>
                            <td height="50" align="right" valign="middle"><strong>账号:</strong></td>
                            <td width="305" valign="middle">
                                <div class="mailline">
                                    <input type="text" class="do_input account popaccount" id="login_user" autocomplete="off" value="" name="account" />
                                    <!--
                                    <input type="text" class="do_input uemail popemail" id="login_user" autocomplete="off" value=""/>
                                    <ul class="maillist">
                                        <span>请选择邮箱类型-支持键盘↑↓键选取</span>
                                        <li class="inputmail"></li>
                                        <li addr="163.com">@163.com</li>
                                        <li addr="126.com">@126.com</li>
                                        <li addr="263.com">@263.com</li>
                                        <li addr="qq.com">@qq.com</li>
                                        <li addr="hotmail.com">@hotmail.com</li>
                                        <li addr="gmail.com">@gmail.com</li>
                                        <li addr="sohu.com">@sohu.com</li>
                                        <li addr="chinaren.com">@chinaren.com</li>
                                        <li addr="yahoo.com.cn">@yahoo.com.cn</li>
                                    </ul>
                                    <input type="hidden" class="prevIndex" name="prevIndex"  value="-1" />
                                    -->
                                </div>
                            </td>
                            <td width="140" align="left" valign="middle"><span></span></td>
                        </tr>
                        <tr>
                            <td height="50" align="right" valign="middle"><strong>密码:</strong></td>
                            <td valign="middle"><input type="password" class="do_input psd_input" id="login_psword" name="password" /></td>
                            <td align="left" valign="middle"><span><a class="qing" href="/public/resetpassword/">忘记密码了？</a></span></td>
                        </tr>
                        <tr>
                            <td height="25" align="right" valign="middle">&nbsp;</td>
                            <td valign="middle"><input id="remember"  name="remember" checked="checked" type="checkbox" value="1" /><label title="如果您在公共场合使用，请勿选择此项！" for="remember">下次自动登录</label></td>
                            <td align="left" valign="middle"><span></span></td>
                        </tr>
                        <tr>
                            <td height="56" align="right" valign="middle">&nbsp;</td>
                            <td valign="middle">
                                <button type="button" class="btn btn-primary btn-large login_btn" name="login_btn">登&nbsp;&nbsp;录</button>没注册？<a class="brown" id="pop_toreg">注册</a></td>
                            <td valign="middle"><span></span>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="regs_intro pop_intro">
                <!--<p>请用您注册的Email或用户名来登录网站。您将享受《彼岸吉他》杂志的免费下载，谱库，讨论等服务。以及更多不断开发的新服务。彼岸吉他欢迎您的参与。</p>
                -->
                <b></b>
                <p class="snsbtn snsloginbtn snspopbtn">
                    <span class="fl">便捷登录:</span>
                    <a class="qq qq_on" href="{$qqh_url}" title="用QQ账号登陆">QQ登录</a>
                    <a class="sina sina_on" href="{$sina_weibo_url}" title="用新浪微博账号登陆">微博登录</a>
                <div class="clear"></div>
                </p>
            </div>
        </dd>
    </dl>
</div>
<div id="popbg"></div>