<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>欢迎您登录56大学网</title>
        <link rel="stylesheet" type="text/css" href="/Public/Admin/css/login.css" media="all">
       	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
    </head>
    <body id="login-page">
        <div id="main-content">

            <!-- 主体 -->
            <div class="login-body">
                <div class="login-main pr">
                    <form action="<?php echo U('login');?>" method="post" class="login-form">
                    <img src="/Public/Admin/images/login_logo.png" alt="" width="300px" height="100px">
                        <div id="itemBox" class="item-box">
                            <div class="item">
                                <i class="icon-login-user"></i>
                                <input type="text" name="username" placeholder="请填写用户名" autocomplete="off" />
                            </div>
                            <div class="item b0">
                                <i class="icon-login-pwd"></i>
                                <input type="password" name="password" placeholder="请填写密码" autocomplete="off" />
                            </div>
                            <div class="item verifycode">
                                <i class="icon-login-verifycode"></i>
                                <input type="text" name="verify" placeholder="请填写验证码" autocomplete="off">
                                <a class="reloadverify" title="换一张" href="javascript:void(0)">换一张？</a>
                            </div>
                            <div>
                                <img class="verifyimg reloadverify" alt="点击切换" src="<?php echo U('Index/verify');?>">
                            </div>
                        </div>
                        <div class="login_btn_panel">
                            <button class="login-btn" type="submit">
                                <span class="in"><i class="icon-loading"></i>登 录 中 ...</span>
                                <span class="on">登 录</span>
                            </button>
                            <div class="check-tips"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
	<!--[if lt IE 9]>
    <script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]-->
    <!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
    <!--<![endif]-->
    <script type="text/javascript">
    	/* 登陆表单获取焦点变色 */
    	$(".login-form").on("focus", "input", function(){
            $(this).closest('.item').addClass('focus');
        }).on("blur","input",function(){
            $(this).closest('.item').removeClass('focus');
        });

    	//表单提交
    	$(document)
	    	.ajaxStart(function(){
	    		$("button:submit").addClass("log-in").attr("disabled", true);
	    	})
	    	.ajaxStop(function(){
	    		$("button:submit").removeClass("log-in").attr("disabled", false);
	    	});

    	$("form").submit(function(){
    		var self = $(this);
    		$.post(self.attr("action"), self.serialize(), success, "json");
    		return false;

    		function success(data){
    			if(data.status){
    				window.location.href = data.url;
    			} else {
    				self.find(".check-tips").text(data.info);
    				//刷新验证码
    				$(".reloadverify").click();
    			}
    		}
    	});

		$(function(){
			//初始化选中用户名输入框
			$("#itemBox").find("input[name=username]").focus();
			//刷新验证码
			var verifyimg = $(".verifyimg").attr("src");
            $(".reloadverify").click(function(){
                if( verifyimg.indexOf('?')>0){
                    $(".verifyimg").attr("src", verifyimg+'&random='+Math.random());
                }else{
                    $(".verifyimg").attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
                }
            });
		});
    </script>
</body>
</html>