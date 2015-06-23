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
	<div id="header-container" class="container">
<div class="row">
    
        <div class="span3"><img src="/Public/Home/images/4.png"></div>
        <div class="span9">
            <div class="alert alert-success1">
                欢迎来到56大学！
            </div>
            <div class="input-append" >
              <input class="span5" type="text" id="searchkey">
              <button class="btn btn-success" type="button" id="search">搜索！</button>
            </div>
        </div>
    
    
    <!-- 左侧 nav
    ================================================== -->
        <div class="span3">
            <ul class="nav nav-list bs-docs-sidenav">
                <?php echo W('Category/lists', array($category['id'], ACTION_NAME == 'index'));?>
            </ul>
        </div>


  <div class="row-fluid hidden-phone">

    <div id="myCarousel" class="carousel slide span7" style="top:20px; left:10px">
                <ol class="carousel-indicators">
                  <li data-target="#myCarousel" data-slide-to="0" data-interval="2000" class="active"></li>
                  <li data-target="#myCarousel" data-slide-to="1" data-interval="2000" class=""></li>
                  <li data-target="#myCarousel" data-slide-to="2" data-interval="2000" class=""></li>
                </ol>
                <div class="carousel-inner">
                  <div class="item active">
                    <img src="/Public/Home/images/3.png" alt="" style="height:200px;width:100%;">
                    <div class="carousel-caption">
                      <h4>56大学网正式上线</h4>
                      <p>主要为在校大学生提供在线购物、二手信息发布、校园周边商铺入驻等服务。我们的目标是建立一个专业的校园综合性平台，为更多的在校大学生服务。</p>
                    </div>
                  </div>
                  <div class="item">
                    <img src="/Public/Home/images/2.png" alt="" style="height:200px;width:100%;">
                    <div class="carousel-caption">
                      <h4></h4>
                      <p>如果您所在大学还未开通，则可以申请开通您所在的大学并成为大学管理员负责所在大学的各项管理工作。</p>
                    </div>
                  </div>
                  <div class="item">
                    <img src="/Public/Home/images/1.png" alt="" style="height:200px;width:100%;">
                    <div class="carousel-caption">
                      <h4>商家合作</h4>
                      <p>如果您是校园周边商家，则可以申请开通您您商铺的购物频道。</p>
                    </div>
                  </div>
                </div>
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
    </div>
    <div class="span2" style="position:relative; top:20px">
      <img src="/Public/Home/images/erwei.png">
      <span class="label label-info" style="position:relative; left:px">扫一下，手机也能上56大学!</span>
    </div>
  </div>


</div>

<div id="main-container" class="container">
    <div class="row">
        
    <div class="span12">
        <!-- Contents
        ================================================== -->
        <section id="contents">
        <ul class="thumbnails">
            <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><li class="span2" title="<?php echo ($list["describe"]); ?>">
                    <div class="thumbnail" data-toggle="popover" data-title="商品简介" data-content="<?php echo ($list["description"]); ?>" data-trigger="hover focus" data-placement="top">
                        <a target="_blank" href="<?php echo U('Article/detail?id='.$list['id']);?>"><img src="<?php echo ($list["pic"]); ?>" alt="<?php echo ($list["title"]); ?>" style="height:160px; width:170px"></a>
                        <p class="mod_goods_price" style="width:170px">
                            <span class="mod_price"><i class="icon-shopping-cart"></i> <i><span class="text-info">¥</span> </i><span class="text-success lead"><?php echo ($list["price"]); ?></span><span class="text-error" style="position:relative;float:right;top:5px;">已售：<?php echo ($list["sold"]); ?>&nbsp;&nbsp;&nbsp;</span></span>
                        </p>
                        <p>
                            <a target="_blank" href="<?php echo U('Article/detail?id='.$list['id']);?>" title="<?php echo ($list["title"]); ?>"><?php echo ($list["title"]); ?></a>
                        </p>
                    </div>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <div class="onethink pagination pagination-right pagination-large">
            <?php echo ($page); ?>
        </div>
        </section>
    </div>
        </div>
        <script type="text/javascript">
          $('.carousel').carousel();
          $(".thumbnail").hover(function() {
          }, function() {
            /* Stuff to do when the mouse leaves the element */
          });
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
    $("#search").click(function(event) {
        $k = $("#searchkey").val();
        window.location.href="./index.php?s=/Home/search/index/k/"+ $k +".html"; 
    });
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