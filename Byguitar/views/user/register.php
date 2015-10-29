<div class="tip">
	<div class="arrow"><?php echo $msg; ?></div>
</div>
<div class="main">
	<dl class="regbox">
		<dt>
		<ul class="regbar_box">
			<li class="fl regbar regbar_on">注册为彼岸用户</li>
			<li class="fl regbar"><a class="gray" href="/user/login">登录彼岸吉他网</a></li>
		</ul>
		</dt>
		<dd id="reg_box">
			<div class="regform">
				<form name="formUser" method="post" action="/user/register" id="formUser">
					<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="dotab">
						<tr>
							<td height="50" align="right" valign="middle"><strong>E-mail:</strong></td>
							<td width="305" valign="middle">
								<div class="mailline">
									<input type="text" class="do_input uemail" id="email" autocomplete="off" value="" name="email" />
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
							<td width="425" align="left" valign="middle"><span></span></td>
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
							<td valign="middle"><span class="yzm_box"><input type="text" class="do_input yzm_input" id="captcha" name="verify" /></span><img class="yzmimg" src="__URL__/verify/" width="50" height="26" /><a tabindex="-1"  class="qing cursor" id="yzmimglook">看不清？换一张</a></td>
							<td align="left" valign="middle"><span></span></td>
						</tr>
						<tr>
							<td height="25" align="right" valign="middle">&nbsp;</td>
							<td valign="middle"><label for="agree"><input type="checkbox" class="autologin" id="agree" checked="checked" name="agree" />
									我同意</label> <a class="brown" tabindex="-1" href="/user/agreement">《彼岸网使用协议》</a></td>
							<td align="left" valign="middle"><span></span></td>
						</tr>
						<tr>
							<td height="56" align="right" valign="middle">&nbsp;</td>
							<td valign="middle">
								<button type="button" class="btn btn-primary btn-large reg_btn" name="reg_btn">注&nbsp;&nbsp;册</button>
								已注册？<a class="brown" href="/user/login">登录</a></td>
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
				<p>注册会员，可分享更多的吉他资讯，谱子，视频等服务，结交新朋友，享受《彼岸吉他》杂志订阅服务，以及不断开发的新服务，彼岸欢迎您。<br/>SNS(微博，qq)账号登录，无需输入密码，一键登录彼岸。 </p><b></b>
			</div>
		</dd>
	</dl>
</div>