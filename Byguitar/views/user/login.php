<link href="/css/web/user.css" type="text/css" rel="stylesheet">

<div class="tip">
	<div class="arrow"><?php echo $msg; ?></div>
</div>
<div class="main">
	<dl class="regbox">
		<dt>
		<ul class="regbar_box">
			<li class="fl regbar"><a class="gray" href="/user/register">注册为彼岸用户</a></li>
			<li class="fl regbar regbar_on">登录彼岸吉他网</li>
		</ul>
		</dt>
		<dd id="login_box">
			<div class="regform">
				<form method="post" action="/user/login" name="loginForm" id="loginForm">
					<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="dotab">
						<tr>
							<td height="50" align="right" valign="middle"><strong>账号:</strong></td>
							<td width="305" valign="middle">
								<div class="mailline">
									<input type="text" class="do_input account" id="login_user" autocomplete="off" value="" name="account" />
									<!--
                                    <input type="text" class="do_input uemail" id="login_user" autocomplete="off" value="" />
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
                                    <input type="hidden" class="prevIndex" name="prevIndex"  value="-1" /> -->
								</div>
							</td>
							<td width="425" align="left" valign="middle"><span></span></td>
						</tr>
						<tr>
							<td height="50" align="right" valign="middle"><strong>密码:</strong></td>
							<td valign="middle"><input type="password" class="do_input psd_input" id="login_psword" name="password" /></td>
							<td align="left" valign="middle"><span><a class="qing" href="/public/resetpassword/">忘记密码了？</a></span></td>
						</tr>
						<tr>
							<td height="25" align="right" valign="middle">&nbsp;</td>
							<td valign="middle"><label title="如果您在公共场合使用，请勿选择此项！" for="remember"><input id="remember"  name="remember" checked="checked" type="checkbox" value="1" />下次自动登录</label></td>
							<td align="left" valign="middle"><span></span></td>
						</tr>
						<tr>
							<td height="56" align="right" valign="middle">&nbsp;</td>
							<td valign="middle">
								<button type="button" class="btn btn-primary btn-large login_btn" name="login_btn">登&nbsp;&nbsp;录</button>
								<input type="button" class="do_btn login_btn" value="" name="login_btn" />
								没注册？<a class="brown" href="/user/register">注册</a></td>
							<td valign="middle"><span></span></td>
						</tr>
						<tr>
							<td height="10"></td>
							<td class="spline"></td>
							<td></td>
						</tr>
						<tr>
							<td height="70" align="right" valign="middle"><strong>便捷登录</strong></td>
							<td valign="middle">
								<p class="snsbtn snsloginbtn">
									<a class="qq qq_on" href="{$qqh_url}" title="用QQ账号登录">QQ登录</a>
									<a class="sina sina_on" href="{$sina_weibo_url}" title="用新浪微博账号登录">微博登录</a>
								<div class="clear"></div>
								</p>

							</td>
							<td align="left" valign="middle"></td>
						</tr>
					</table>
				</form>
			</div>
			<div class="regs_intro">
				<p>建议用Email进行登录！原论坛注册用户可以使用用户名进行登录！<br/>SNS(微博，qq)账号登录，无需输入密码，一键登录彼岸。</p><b></b>
			</div>
		</dd>
	</dl>
</div>