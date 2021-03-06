<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
<title><?php echo C('WEB_SITE_TITLE');?></title>
<link href="/Public/static/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/Public/static/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link href="/Public/static/bootstrap/css/docs.css" rel="stylesheet">
<link href="/Public/static/bootstrap/css/onethink.css" rel="stylesheet">

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="/Public/static/bootstrap/js/html5shiv.js"></script>
<![endif]-->

<!--[if lt IE 9]>
<script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="/Public/static/bootstrap/js/bootstrap.min.js"></script>
<!--<![endif]-->
<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hooks('pageHeader');?>

</head>
<body>
	<!-- 头部 -->
	<!-- 导航条
================================================== -->

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="<?php echo U('index/index');?>">56大学网</a>
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <?php $__NAV__ = D('Channel')->lists(); if(is_array($__NAV__)): $i = 0; $__LIST__ = $__NAV__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?><li>
                            <a href="<?php echo (get_nav_url($nav["url"])); ?>"><?php echo ($nav["title"]); ?></a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
            <div class="nav-collapse collapse pull-right">

  
<ul class="nav" style="margin-right:0">
<li>
    <div class="btn-group">
  <button class="btn"><?php if(is_login()): ?>我在：<?php endif; echo ($schoolName); ?></button>
  <?php if(!is_login()): ?><button class="btn dropdown-toggle" data-toggle="dropdown">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <?php if(is_array($school)): $i = 0; $__LIST__ = $school;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Index/index?sid='.$data['id']);?>"><?php echo ($data["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
    
  </ul><?php endif; ?>
</div>
</li>
                <?php if(is_login()): ?><li>
                            <a href="<?php echo U('Cart/index');?>"><i class="icon-shopping-cart"></i> 购物车</a>
                        </li>
                        <li>
                            <a href="<?php echo U('Orderform/index');?>"><i class="icon-th-list"></i> 我的订单</a>
                        </li>
                        <li>
                            <a href="<?php echo U('/Admin/index');?>" data-toggle="tooltip" data-placement="bottom" data-title="登陆我的网店后台，免费发布二手商品" id="myShow"><i class="icon-home" id="myShow"></i> 我的店铺</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:0;padding-right:0"><i class="icon-user"></i> <?php echo get_username();?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo U('User/profile');?>"><i class="icon-asterisk"></i> 修改密码</a></li>
                                <li><a href="<?php echo U('User/logout');?>"><i class="icon-off"></i> 退出</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php else: ?>
                        <li>
                            <a href="<?php echo U('Cart/index');?>"><i class="icon-shopping-cart"></i> 购物车</a>
                        </li>
                        <li>
                            <a href="<?php echo U('Orderform/index');?>"><i class="icon-th-list"></i> 我的订单</a>
                        </li>
                        <li>
                            <a href="<?php echo U('/Admin/index');?>" data-toggle="tooltip"  data-title="登陆我的网店后台，免费发布二手商品" id="myShop"><i class="icon-home"></i> 我的店铺</a>
                        </li>
                        <li>
                            <a href="<?php echo U('User/login');?>"><i class="icon-lock"></i> 登录</a>
                        </li>
                        <li>
                            <a href="<?php echo U('User/register');?>" style="padding-left:0;padding-right:0"><i class="icon-plus"></i> 注册</a>
                        </li>
                    </ul><?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#myShow').tooltip()
</script>

	<!-- /头部 -->

	<!-- 主体 -->
	
	<header class="jumbotron subhead" id="overview">
		<div class="container">
			<h2><span class="text-info">"<?php echo ($keyword); ?>"</span> 的搜索结果：<span class="text-error"><?php echo ($error); ?></span></h2>
			<p class="lead"></p>
		</div>
	</header>

<div id="main-container" class="container">
    <div class="row">
        
        
      <div class="span12">
        <!-- Contents
        ================================================== -->
        <section id="contents">
        <ul class="thumbnails">
        	<?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li class="span2" style="height:280px;">
	        		<div class="thumbnail" data-toggle="popover" data-title="商品简介" data-content="<?php echo ($list["description"]); ?>" data-trigger="hover focus" data-placement="top">
                        <a target="_blank" href="<?php echo U('Article/detail?id='.$data['id']);?>" title="<?php echo ($data["describe"]); ?>"><img src="<?php echo ($data["pic"]); ?>" alt="<?php echo ($data["title"]); ?>" style="height:160px; width:170px"></a>
                        <p class="mod_goods_price" style="width:170px">
                            <span class="mod_price"><i class="icon-shopping-cart"></i> <i><span class="text-info">¥</span> </i><span class="text-success lead"><?php echo ($data["price"]); ?></span><span class="text-error" style="position:relative;float:right;top:5px;"><i class="icon-ok"></i> 已售：<?php echo ($data["sold"]); ?>&nbsp;&nbsp;&nbsp;</span></span>
                        </p>
                        <p>
                            <a target="_blank" href="<?php echo U('Article/detail?id='.$data['id']);?>" title="<?php echo ($data["title"]); ?>"><?php echo ($data["title"]); ?></a>
                        </p>
                    </div>
	  			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
            <div class="onethink pagination pagination-right pagination-large">
                <?php $__PAGE__ = new \COM\Page(get_list_count($category['id']), $category['list_row']);echo $__PAGE__->show(); ?>
            </div>
        </section>
      </div>
    </div>
    <script type="text/javascript">
        $('.thumbnail').popover()
    </script>

    </div>
</div>

<script type="text/javascript">
    $(function(){
        $(window).resize(function(){
            $("#main-container").css("min-height", $(window).height() - 343);
        }).resize();
    })
</script>
	<!-- /主体 -->

	<!-- 底部 -->
	
    <!-- 底部
    ================================================== -->
    <footer class="footer">
      <div class="container">
          <p> 技术支持 <strong><a href="http://www.yekezhong.com" target="_blank">叶科忠</a></strong></p>
      </div>
    </footer>

<script type="text/javascript">
(function(){
	var ThinkPHP = window.Think = {
		"ROOT"   : "", //当前网站地址
		"APP"    : "/index.php?s=", //当前项目地址
		"PUBLIC" : "/Public", //项目公共目录地址
		"DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
		"MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
		"VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
	}
})();
</script>
 <!-- 用于加载js代码 -->
<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hooks('pageFooter', 'widget');?>
<div class="hidden"><!-- 用于加载统计代码等隐藏元素 -->
	
</div>

	<!-- /底部 -->
</body>
</html>