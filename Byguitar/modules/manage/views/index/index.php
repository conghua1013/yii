<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>测试后台</title>

<link href="css/dwz/themes/default/style.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="css/dwz/themes/css/core.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="css/dwz/themes/css/print.css" rel="stylesheet" type="text/css" media="print"/>
<link href="js/dwz/uploadify/css/uploadify.css" rel="stylesheet" type="text/css" media="screen"/>
<!--[if IE]>
<link href="themes/css/ieHack.css" rel="stylesheet" type="text/css" media="screen"/>
<![endif]-->

<!--[if lte IE 9]>
<script src="js/speedup.js" type="text/javascript"></script>
<![endif]-->

<script src="js/dwz/jquery-1.7.2.js" type="text/javascript"></script>
<script src="js/dwz/jquery.cookie.js" type="text/javascript"></script>
<script src="js/dwz/jquery.validate.js" type="text/javascript"></script>
<script src="js/dwz/jquery.bgiframe.js" type="text/javascript"></script>
<script src="js/dwz/xheditor/xheditor-1.2.1.min.js" type="text/javascript"></script>
<script src="js/dwz/xheditor/xheditor_lang/zh-cn.js" type="text/javascript"></script>
<script src="js/dwz/uploadify/scripts/jquery.uploadify.js" type="text/javascript"></script>

<!-- svg图表  supports Firefox 3.0+, Safari 3.0+, Chrome 5.0+, Opera 9.5+ and Internet Explorer 6.0+ -->
<script type="text/javascript" src="js/dwz/chart/raphael.js"></script>
<script type="text/javascript" src="js/dwz/chart/g.raphael.js"></script>
<script type="text/javascript" src="js/dwz/chart/g.bar.js"></script>
<script type="text/javascript" src="js/dwz/chart/g.line.js"></script>
<script type="text/javascript" src="js/dwz/chart/g.pie.js"></script>
<script type="text/javascript" src="js/dwz/chart/g.dot.js"></script>

<script src="js/dwz/dwz.core.js" type="text/javascript"></script>
<script src="js/dwz/dwz.util.date.js" type="text/javascript"></script>
<script src="js/dwz/dwz.validate.method.js" type="text/javascript"></script>
<script src="js/dwz/dwz.barDrag.js" type="text/javascript"></script>
<script src="js/dwz/dwz.drag.js" type="text/javascript"></script>
<script src="js/dwz/dwz.tree.js" type="text/javascript"></script>
<script src="js/dwz/dwz.accordion.js" type="text/javascript"></script>
<script src="js/dwz/dwz.ui.js" type="text/javascript"></script>
<script src="js/dwz/dwz.theme.js" type="text/javascript"></script>
<script src="js/dwz/dwz.switchEnv.js" type="text/javascript"></script>
<script src="js/dwz/dwz.alertMsg.js" type="text/javascript"></script>
<script src="js/dwz/dwz.contextmenu.js" type="text/javascript"></script>
<script src="js/dwz/dwz.navTab.js" type="text/javascript"></script>
<script src="js/dwz/dwz.tab.js" type="text/javascript"></script>
<script src="js/dwz/dwz.resize.js" type="text/javascript"></script>
<script src="js/dwz/dwz.dialog.js" type="text/javascript"></script>
<script src="js/dwz/dwz.dialogDrag.js" type="text/javascript"></script>
<script src="js/dwz/dwz.sortDrag.js" type="text/javascript"></script>
<script src="js/dwz/dwz.cssTable.js" type="text/javascript"></script>
<script src="js/dwz/dwz.stable.js" type="text/javascript"></script>
<script src="js/dwz/dwz.taskBar.js" type="text/javascript"></script>
<script src="js/dwz/dwz.ajax.js" type="text/javascript"></script>
<script src="js/dwz/dwz.pagination.js" type="text/javascript"></script>
<script src="js/dwz/dwz.database.js" type="text/javascript"></script>
<script src="js/dwz/dwz.datepicker.js" type="text/javascript"></script>
<script src="js/dwz/dwz.effects.js" type="text/javascript"></script>
<script src="js/dwz/dwz.panel.js" type="text/javascript"></script>
<script src="js/dwz/dwz.checkbox.js" type="text/javascript"></script>
<script src="js/dwz/dwz.history.js" type="text/javascript"></script>
<script src="js/dwz/dwz.combox.js" type="text/javascript"></script>
<script src="js/dwz/dwz.print.js" type="text/javascript"></script>

<!-- 可以用dwz.min.js替换前面全部dwz.*.js (注意：替换是下面dwz.regional.zh.js还需要引入)
<script src="bin/dwz.min.js" type="text/javascript"></script>
-->
<script src="js/dwz/dwz.regional.zh.js" type="text/javascript"></script>

<script type="text/javascript">
$(function(){
	DWZ.init("dwz.frag.xml", {
		loginUrl:"login_dialog.html", loginTitle:"登录",	// 弹出登录对话框
//		loginUrl:"login.html",	// 跳到登录页面
		statusCode:{ok:200, error:300, timeout:301}, //【可选】
		pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"orderField", orderDirection:"orderDirection"}, //【可选】
		keys: {statusCode:"statusCode", message:"message"}, //【可选】
		ui:{hideMode:'offsets'}, //【可选】hideMode:navTab组件切换的隐藏方式，支持的值有’display’，’offsets’负数偏移位置的值，默认值为’display’
		debug:false,	// 调试模式 【true|false】
		callback:function(){
			initEnv();
			$("#themeList").theme({themeBase:"css/dwz/themes"}); // themeBase 相对于index页面的主题base路径
		}
	});
});

</script>
</head>

<body scroll="no">
	<div id="layout">
		<div id="header">
			<div class="headerNav">
				<a class="logo" href="http://j-ui.com">标志</a>
				<ul class="nav">
					<li id="switchEnvBox"><a href="javascript:">（<span>北京</span>）切换城市</a>
						<ul>
							<li><a href="sidebar_1.html">北京</a></li>
							<li><a href="sidebar_2.html">上海</a></li>
							<li><a href="sidebar_2.html">南京</a></li>
							<li><a href="sidebar_2.html">深圳</a></li>
							<li><a href="sidebar_2.html">广州</a></li>
							<li><a href="sidebar_2.html">天津</a></li>
							<li><a href="sidebar_2.html">杭州</a></li>
						</ul>
					</li>
					<li><a href="https://me.alipay.com/dwzteam" target="_blank">捐赠</a></li>
					<li><a href="changepwd.html" target="dialog" width="600">设置</a></li>
					<li><a href="http://www.cnblogs.com/dwzjs" target="_blank">博客</a></li>
					<li><a href="http://weibo.com/dwzui" target="_blank">微博</a></li>
					<li><a href="login.html">退出</a></li>
				</ul>
				<ul class="themeList" id="themeList">
					<li theme="default"><div class="selected">蓝色</div></li>
					<li theme="green"><div>绿色</div></li>
					<li theme="purple"><div>紫色</div></li>
					<li theme="silver"><div>银色</div></li>
					<li theme="azure"><div>天蓝</div></li>
				</ul>
			</div>

			<!-- navMenu -->
			
		</div>

		<div id="leftside">
			<div id="sidebar_s">
				<div class="collapse">
					<div class="toggleCollapse"><div></div></div>
				</div>
			</div>
			<div id="sidebar">
				<div class="toggleCollapse"><h2>主菜单</h2><div>收缩</div></div>

				<div class="accordion" fillSpace="sidebar">
					<?php if($list): ?>
					<?php foreach($list as $row):?>
					<div class="accordionHeader">
						<h2><span>Folder</span><?php echo $row['title'];?></h2>
					</div>
					<div class="accordionContent">
						<ul class="tree treeFolder">
							<?php foreach($row['child'] as $child):?>
							<li><a href="tabsPage.html" target="navTab"><?php echo $child['title']; ?></a>
								<ul>
									<?php foreach($child['child'] as $childRow):?>
									<li><a href="main.html" target="navTab" rel="main"><?php echo $childRow['title']; ?></a></li>
									<?php endforeach;?>
								</ul>
							</li>
							<?php endforeach;?>
						</ul>
					</div>
					<?php endforeach;?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div id="container">
			<div id="navTab" class="tabsPage">
				<div class="tabsPageHeader">
					<div class="tabsPageHeaderContent"><!-- 显示左右控制时添加 class="tabsPageHeaderMargin" -->
						<ul class="navTab-tab">
							<li tabid="main" class="main"><a href="javascript:;"><span><span class="home_icon">我的主页</span></span></a></li>
						</ul>
					</div>
					<div class="tabsLeft">left</div><!-- 禁用只需要添加一个样式 class="tabsLeft tabsLeftDisabled" -->
					<div class="tabsRight">right</div><!-- 禁用只需要添加一个样式 class="tabsRight tabsRightDisabled" -->
					<div class="tabsMore">more</div>
				</div>
				<ul class="tabsMoreList">
					<li><a href="javascript:;">我的主页</a></li>
				</ul>
				<div class="navTab-panel tabsPageContent layoutBox">
					<div class="page unitBox">
						<div class="accountInfo">
							<div class="alertInfo">
								<p><a href="https://code.csdn.net/dwzteam/dwz_jui/tree/master/doc" target="_blank" style="line-height:19px"><span>DWZ框架使用手册</span></a></p>
								<p><a href="http://pan.baidu.com/s/18Bb8Z" target="_blank" style="line-height:19px">DWZ框架开发视频教材</a></p>
							</div>
							<div class="right">
								<p style="color:red">DWZ官方微博 <a href="http://weibo.com/dwzui" target="_blank">http://weibo.com/dwzui</a></p>
							</div>
							<p><span>DWZ富客户端框架</span></p>
							<p>DWZ官方微博:<a href="http://weibo.com/dwzui" target="_blank">http://weibo.com/dwzui</a></p>
						</div>
						<div class="pageFormContent" layoutH="80" style="margin-right:230px">
							

<h2>DWZ系列开源项目:</h2>
<div class="unit"><a href="https://code.csdn.net/dwzteam/dwz_jui" target="_blank">dwz富客户端框架 - jUI</a></div>
<div class="unit"><a href="https://code.csdn.net/dwzteam/dwz_ssh2" target="_blank">dwz4j企业级Java Web快速开发框架(Hibernate+Spring+Struts2) + jUI整合应用</a></div>
<div class="unit"><a href="https://code.csdn.net/dwzteam/dwz_springmvc" target="_blank">dwz4j企业级Java Web快速开发框架(Mybatis + SpringMVC) + jUI整合应用</a></div>
<div class="unit"><a href="https://code.csdn.net/dwzteam/dwz_thinkphp" target="_blank">ThinkPHP + jUI整合应用</a></div>
<div class="unit"><a href="https://code.csdn.net/dwzteam/dwz_zendframework" target="_blank">Zend Framework + jUI整合应用</a></div>
<div class="unit"><a href="http://www.yiiframework.com/extension/dwzinterface/" target="_blank">YII + jUI整合应用</a></div>

<div class="divider"></div>
<h2>常见问题及解决:</h2>
<pre style="margin:5px;line-height:1.4em">
Error loading XML document: dwz.frag.xml
直接用IE打开index.html弹出一个对话框：Error loading XML document: dwz.frag.xml
原因：没有加载成功dwz.frag.xml。IE ajax laod本地文件有限制, 是ie安全级别的问题, 不是框架的问题。
解决方法：部署到apache 等 Web容器下。
</pre>

<div class="divider"></div>
<h2>有偿服务(<span style="color:red;">公司培训，技术支持，解决使用jUI过程中出现的全部疑难问题</span>):</h2><br/>
<pre style="margin:5px;line-height:1.4em;">
合作电话(杜权)：010-52897073 18600055221
邮箱：support@j-ui.com
来往：pinglive01(吴平)
</pre>
						</div>
						
						<div style="width:230px;position: absolute;top:60px;right:0;border-left:1px solid green;" layoutH="80">
							aaaaaaa
						</div>
					</div>
					
				</div>
			</div>
		</div>

	</div>

	<div id="footer">Copyright &copy; 2010 <a href="demo_page2.html" target="dialog">DWZ团队</a> 京ICP备05019125号-10</div>
</body>
</html>
