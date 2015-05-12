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
            <h2>购物车</h2>
            <p class="lead"></p>
        </div>
    </header>

<div id="main-container" class="container">
    <div class="row">
        
        <!-- 左侧 nav
        ================================================== -->
            <div class="span3 bs-docs-sidebar">
                
                <ul class="nav nav-list bs-docs-sidenav">
                    <?php echo W('Category/lists', array($category['id'], ACTION_NAME != 'lists'));?>
                </ul>
            </div>
        
        
    <div class="span9">
        <!-- Contents
        ================================================== -->
        <section id="contents">
        <div class="alert alert-error fade in <?php if(($schoolError) == "0"): ?>hide<?php endif; ?>">
            <span id="error-msg">购物车中有不是您注册学校（<?php echo ($schoolName); ?>）销售的商品，请先移除！</span>
        </div>
        <div class="alert alert-error fade in <?php if(($outOfStock) == "0"): ?>hide<?php endif; ?>">
            <span id="error-msg">部分商品超出库存，可能因为其它用户已购买了该商品，请修改数量或移除商品！</span>
        </div>
        <?php if(($empty) == "1"): ?><div class="alert alert-info">
            <span id="error-msg">购物车是空的，先去 <a href="<?php echo U('Index/index');?>">挑选</a> 点商品把！</span>
        </div>
  <?php else: ?>
        <table class="table table-striped">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>商品</th>
              <th>数量</th>
              <th>单价</th>
              <th>总价</th>
              <th>状态</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
        	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
                  <td><a target="_blank" href="<?php echo U('Article/detail?id='.$data['gid']);?>" title="<?php echo ($data["goodsName"]); ?>"><span class="span3"><?php echo ($data["goodsName"]); ?></span></a></td>
                  <td>
                  <form method="post" action="<?php echo U('Cart/changeNumber');?>">
                    <?php echo ($data["number"]); ?>&nbsp;&nbsp;
                    <?php if(($data["secondhand"]) == "0"): ?><select class="input-small" name="number">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                    <option>10</option>
                    </select>
                    <input type="hidden" name="gid" value="<?php echo ($data["gid"]); ?>">
                    <input type="submit" class="btn btn-info" value="修改" style="position:relative; top:-5px"><?php endif; ?>
                    </form>
                  </td>
                  <td><?php echo ($data["price"]); ?> 元</td>
                  <td><?php echo ($data['price'] * $data['number']); ?> 元</td>
                  <th>

                  <?php if($data["status"] == 2): ?><p class="text-error">超出库存</p>
 <?php elseif($data["status"] == 1): ?><p class="text-success">正常</p>
 <?php else: ?><p class="text-error">学校错误</p><?php endif; ?>
                  <td><a href="<?php echo U('Cart/remove?gid='.$data['gid']);?>" class="btn btn-error">移除</a></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
          </tbody>
        </table><?php endif; ?>
            <p class="text-right">订单总价：<span class="text-success lead"><?php echo ($total); ?></span> 元</p>
            <?php if(isset($_SESSION['onethink_home']['user_auth'])): ?><p class="text-right">收货信息：<br/>
            姓名 <span class="text-info" id="address-name"><?php echo ($address["realname"]); ?></span><br/>
            手机 <span class="text-info" id="address-phone"><?php echo ($address["mobile"]); ?></span><br/>
            地址 <span class="text-info" id="address-address"><?php echo ($address["address"]); ?></span><br/>
            <p class="text-error text-right">收货信息有误？ <a href="#myModal" role="button" class="btn" id="showAddressModal" data-toggle="modal">点此修改</a></p>
            <?php else: ?> <p class="text-right">请先 <a href="<?php echo U('User/login');?>" class="btn btn-info">登录</a> 或 <a href="<?php echo U('User/register');?>" class="btn btn-info">注册</a></p><?php endif; ?></p>
            <p class="text-right" id="submit-area"><a id="submitOrderform" href="<?php echo U('Orderform/submit');?>" class="btn btn-success" data-loading-text="提交中...">提交订单</a></p>
        </section>
    </div>
    <!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">修改收货信息</h3>
  </div>
  <div class="modal-body" id="address-form-box-success"></div>
  <div class="modal-body" id="address-form-box">
    
  <form class="form-horizontal" id="address-form">
    <fieldset>

    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">收货人姓名</label>
          <div class="controls">
            <input type="text" id="input-name" name="name" value="<?php echo ($address["realname"]); ?>" placeholder="请输入您的姓名" class="input-xlarge">
            <p class="help-block"></p>
          </div>
        </div>

    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">收货人电话</label>
          <div class="controls">
            <input type="text" id="input-phone" name="phone" value="<?php echo ($address["mobile"]); ?>" placeholder="请输入您的手机号码" class="input-xlarge">
            <p class="help-block"></p>
          </div>
        </div>

    <div class="control-group">

          <!-- Text input-->
          <label class="control-label" for="input01">收货人地址</label>
          <div class="controls">
            <input type="text" id="input-address" name="address" value="<?php echo ($address["address"]); ?>" placeholder="请输入您的地址" class="input-xlarge">
            <p class="help-block">如：四川理工学院汇北校区4-xxx</p>
          </div>
        </div>
    </fieldset>
  </form>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
    <button id="saveChange" class="btn btn-primary" data-loading-text="保存中...">保存</button>
  </div>
</div>

<script type="text/javascript">
  $('#submitOrderform').click(function() {
    $("#submitOrderform").button('loading');
  });
  $("#showAddressModal").click(function() {
        $("#address-form-box-success").hide();
        $("#address-form-box").show();
        $("#saveChange").show();
  });
  $("#saveChange").click(function(){
    $("#saveChange").button('loading');
    $.post("<?php echo U('user/address');?>", $("#address-form").serialize(), success, "json");
    return false;

    function success(data){
      $("#address-form-box-success").html(data.msg);
      if(data.success){
        $("#address-name").html($("input#input-name").val());
        $("#address-phone").html($("input#input-phone").val());
        $("#address-address").html($("input#input-address").val());
      }
      $("#address-form-box-success").show();
      $("#address-form-box").hide();
      $("#saveChange").hide();
      $("#saveChange").button('reset');
    }
  });
  <?php if(($outOfStock) == "1"): ?>$("#submit-area").html("<button class='btn btn-success' disabled='disabled'>提交订单</button>");<?php endif; ?>
  <?php if(($empty) == "1"): ?>$("#submit-area").html("<button class='btn btn-success' disabled='disabled'>提交订单</button>");<?php endif; ?>
  <?php if(($schoolError) == "1"): ?>$("#submit-area").html("<button class='btn btn-success' disabled='disabled'>提交订单</button>");<?php endif; ?>
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