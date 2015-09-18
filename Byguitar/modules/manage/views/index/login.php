<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>彼岸吉他-www.byguitar.com管理系统登录</title>
    <link rel="stylesheet" href="/css/admin.css" type="text/css" media="screen" />
    <script type="text/javascript" src="/js/dwz/jquery-1.7.2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
        //验证码操作部分
            $('.yzmimg').click(function(){                         
                var timenow = new Date().getTime();
                $(this).attr('src','/public/verify/'+timenow);
                
            });     
            //验证码操作部分
            $('#yzmimglook').click(function(){  
                                        
                $('.yzmimg').click();       
            });
        });   
    </script>
</head>
<body id="login">
    <div id="login-wrapper" class="png_bg">

        <div id="login-top">
            <h1>ByGuitar Admin</h1>
            <a href="http://www.byguitar.com" target="_blank"><img id="logo" src="/images/public/manage/logo.png" alt="byguitar Admin logo" /></a>
        </div>

        <div id="login-content">
            <form method="post" action="" name="loginForm" id="loginForm">
                <div class="notification information png_bg"><div> 填写登录信息，点击登录按钮即可登录后台 </div></div>
                <p><label>E-mail:</label><input type="text" class="text-input uemail" id="login_user" autocomplete="off" value="" name="email" /></p>
                <div class="clear"></div>

                <p><label>密码:</label><input type="password" class="text-input psd_input" id="login_psword" name="password" /></p>
                <div class="clear"></div>

                <p><label>验证码:</label><input type="text" class="text-input yzm_input" id="captcha" style="width:50px;margin-left:20px;float:left" name="verifyCode" />
                <?php $this->widget('CCaptcha',array('showRefreshButton'=>false,'clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'点击换图','style'=>'cursor:pointer;float:left;margin-left:20px;'))); ?>
                </p>
                <div class="clear"></div>

                <p id="remember-password"><input type="checkbox" name="is_remember" value="1"/>Remember me </p>
                <div class="clear"></div>

                <p><input class="button" type="submit" value="登录" /></p>
            </form>
        </div>
    </div>
</body>
</html>
