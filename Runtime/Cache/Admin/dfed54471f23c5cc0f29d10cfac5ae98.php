<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>|56大学网</title>
    <link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
    <!--<![endif]-->
    
</head>
<body>
    <!-- 头部 -->
    <?php $__base_menu__ = $__controller__->getMenus(); ?>
    <div class="header">
        <!-- Logo -->
        <span class="logo"></span>
        <!-- /Logo -->

        <!-- 主导航 -->
        <ul class="main-nav">
            <?php if(is_array($__base_menu__["main"])): $i = 0; $__LIST__ = $__base_menu__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- /主导航 -->

        <!-- 用户栏 -->
        <div class="user-bar">
            <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu hidden">
                <li class="manager">你好，<em title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></li>
                <li><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li>
                <li><a href="<?php echo U('Index/logout');?>">退出</a></li>
            </ul>
        </div>
    </div>
    <!-- /头部 -->

    <!-- 边栏 -->
    <div class="sidebar">
        <!-- 子导航 -->
        
            <div id="subnav" class="subnav">
                <?php if(!empty($_extra_menu)): ?>
                    <?php echo extra_menu($_extra_menu,$__base_menu__); endif; ?>
                <?php if(is_array($__base_menu__["child"])): $i = 0; $__LIST__ = $__base_menu__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
                    <?php if(!empty($sub_menu)): ?><h3><i class="icon icon-unfold"></i><?php echo ($key); ?></h3>
                        <ul class="side-sub-menu">
                            <?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                                    <a class="item" href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul><?php endif; ?>
                    <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        
        <!-- /子导航 -->
    </div>
    <!-- /边栏 -->

    <!-- 内容区 -->
    <div id="main-content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div id="main" class="main">
            
            <!-- nav -->
            <?php if(!empty($_show_nav)): ?><div class="breadcrumb">
                <span>您的位置:</span>
                <?php $i = '1'; ?>
                <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
                    <?php else: ?>
                    <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
                    <?php $i = $i+1; endforeach; endif; ?>
            </div><?php endif; ?>
            <!-- nav -->
            

            
	<div class="main-title">
		<h2><?php echo ($info['id']?'编辑':'新增'); ?>分类</h2>
	</div>
	<div class="tab-wrap">
		<ul class="tab-nav nav">
			<li data-tab="tab1" class="current"><a href="javascript:void(0);">基 础</a></li>
			<li data-tab="tab2"><a href="javascript:void(0);">高 级</a></li>
		</ul>
		<div class="tab-content">
			<form action="/index.php?s=/admin/category/add.html" method="post" class="form-horizontal">
				<!-- 基础 -->
				<div id="tab1" class="tab-pane in tab1">
					<div class="form-item">
						<label class="item-label">上级分类<span class="check-tips"></span></label>
						<div class="controls">
							<input type="text" class="text input-large" disabled="disabled" value="<?php echo ((isset($category['title']) && ($category['title'] !== ""))?($category['title']):'无'); ?>"/>
						</div>
					</div>

					<div class="form-item">
						<label class="item-label">
							<em class="must">*</em>分类名称<span class="check-tips">（名称不能为空）</span>
						</label>
						<div class="controls">
							<input type="text" name="title" class="text input-large" value="<?php echo ((isset($info["title"]) && ($info["title"] !== ""))?($info["title"]):''); ?>">
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">
							<em class="must">*</em>二手商品分类
						</label>
						<div class="controls">
							<label class="inline radio"><input type="radio" name="secondhand" value="0" checked>否</label>
							<label class="inline radio"><input type="radio" name="secondhand" value="1">是</label>
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">
							<em class="must">*</em>分类标识
						</label>
						<div class="controls">
							<input type="text" name="name" class="text input-large" value="<?php echo ((isset($info["name"]) && ($info["name"] !== ""))?($info["name"]):''); ?>">
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">
							<em class="must">*</em>发布内容
						</label>
						<div class="controls">
							<label class="inline radio"><input type="radio" name="allow_publish" value="1" checked>允许</label>
							<label class="inline radio"><input type="radio" name="allow_publish" value="0">不允许</label>
						</div>
					</div>
					<div class="form-item">
						<label class="item-label"><em class="must">*</em>绑定文档模型</label>
						<div class="controls">
							<?php $_result=get_document_model();if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><label class="checkbox">
									<input type="checkbox" name="model[]" value="<?php echo ($list["id"]); ?>"><?php echo ($list["title"]); ?>
								</label><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div>
					<div class="form-item">
						<label class="item-label"><em class="must">*</em>允许文档类型</label>
						<div class="controls">
							<?php $_result=C('DOCUMENT_MODEL_TYPE');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?><label class="checkbox">
									<input type="checkbox" name="type[]" value="<?php echo ($key); ?>"><?php echo ($type); ?>
								</label><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div>
				</div>

				<!-- 高级 -->
				<div id="tab2" class="tab-pane tab2">
					<div class="form-item">
						<label class="item-label">
							回复<span class="check-tips">（是否允许对内容进行回复，需要详情页模板支持回复显示与提交）</span>
						</label>
						<div class="controls">
							<label class="inline radio"><input type="radio" name="reply" value="1" checked>允许</label>
							<label class="inline radio"><input type="radio" name="reply" value="0">不允许</label>
						</div>
					</div>
					<div class="form-item reply hidden">
						<label class="item-label">回复绑定的文档模型</label>
						<div class="controls">
							<?php $_result=get_document_model();if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><label class="checkbox">
									<input type="checkbox" name="reply_model[]" value="<?php echo ($list["id"]); ?>"><?php echo ($list["title"]); ?>
								</label><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div>
					<div class="form-item reply hidden">
						<label class="item-label">回复允许的文档类型</label>
						<div class="controls">
							<?php $_result=C('DOCUMENT_MODEL_TYPE');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?><label class="checkbox">
									<input type="checkbox" name="reply_type[]" value="<?php echo ($key); ?>"><?php echo ($type); ?>
								</label><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">
							排序<span class="check-tips">（仅对当前层级分类有效）</span>
						</label>
						<div class="controls">
							<input type="text" name="sort" class="text input-large" value="<?php echo ((isset($info["sort"]) && ($info["sort"] !== ""))?($info["sort"]):0); ?>">
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">
							列表行数
						</label>
						<div class="controls">
							<input type="text" name="list_row" class="text input-large" value="<?php echo ((isset($info["list_row"]) && ($info["list_row"] !== ""))?($info["list_row"]):10); ?>">
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">可见性</label>
						<div class="controls">
							<select name="display">
								<option value="0">不可见</option>
								<option value="1" selected="selected">所有人可见</option>
								<option value="2">管理员可见</option>
							</select>
						</div>
					</div>
				</div>

				<!-- 高级 -->
				<div id="tab2" class="tab-pane tab2">
					<div class="form-item">
						<label class="item-label">网页标题</label>
						<div class="controls">
							<input type="text" name="meta_title" class="text input-large" value="<?php echo ((isset($info["meta_title"]) && ($info["meta_title"] !== ""))?($info["meta_title"]):''); ?>">
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">关键字</label>
						<div class="controls">
							<label class="textarea input-large">
								<textarea name="keywords"><?php echo ((isset($info["keywords"]) && ($info["keywords"] !== ""))?($info["keywords"]):''); ?></textarea>
							</label>
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">描述</label>
						<div class="controls">
							<label class="textarea input-large">
								<textarea name="description"><?php echo ((isset($info["description"]) && ($info["description"] !== ""))?($info["description"]):''); ?></textarea>
							</label>
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">频道模板</label>
						<div class="controls">
							<input type="text" name="template_index" class="text input-large" value="<?php echo ((isset($info["template_index"]) && ($info["template_index"] !== ""))?($info["template_index"]):''); ?>">
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">列表模板</label>
						<div class="controls">
							<input type="text" name="template_lists" class="text input-large" value="<?php echo ((isset($info["template_lists"]) && ($info["template_lists"] !== ""))?($info["template_lists"]):''); ?>">
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">详情模板</label>
						<div class="controls">
							<input type="text" name="template_detail" class="text input-large" value="<?php echo ((isset($info["template_detail"]) && ($info["template_detail"] !== ""))?($info["template_detail"]):''); ?>">
						</div>
					</div>
					<div class="form-item">
						<label class="item-label">编辑模板</label>
						<div class="controls">
							<input type="text" name="template_edit" class="text input-large" value="<?php echo ((isset($info["template_edit"]) && ($info["template_edit"] !== ""))?($info["template_edit"]):''); ?>">
						</div>
					</div>
				</div>

				<div class="form-item">
					<input type="hidden" name="id" value="<?php echo ((isset($info["id"]) && ($info["id"] !== ""))?($info["id"]):''); ?>">
					<input type="hidden" name="pid" value="<?php echo ($category['id']?$category['id']:$info['pid']); ?>">
					<button type="submit" id="submit" class="btn submit-btn ajax-post" target-form="form-horizontal">确 定</button>
					<button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
				</div>
			</form>
		</div>
	</div>
	<!-- <form action="<?php echo U('edit');?>" method="post" class="form-horizontal">
		<div class="form-item">
			<label class="item-label"><em class="must">*</em>附件类型：</label>
			<div class="controls">
				<label class="inline radio">
					<input type="radio" name="" value="">1
				</label>
				<label class="inline radio">
					<input type="radio" name="" value="">2
				</label>
			</div>
		</div>
		<div class="form-item">
			<label class="item-label"><em class="must">*</em>上传后缀：</label>
			<div class="controls">
				<label class="inline radio">
					<input type="radio" name="" value="">1
				</label>
				<label class="inline radio">
					<input type="radio" name="" value="">2
				</label>
			</div>
		</div>
		<div class="form-item">
			<label class="item-label"><em class="must">*</em>附件大小：</label>
			<div class="controls">
				<input type="text" name="" class="input-medium" value="1G">
			</div>
		</div>
		<div class="form-item">
			<label class="item-label"><em class="must">*</em>上传驱动：</label>
			<div class="controls">
				<input type="file" name="" id="">
			</div>
		</div>

	</form> -->

        </div>
        <div class="cont-ft">
            <div class="copyright">
                <div class="fl"><a href="http://www.56daxue.com" target="_blank">56大学网</a>版权所有</div>
            </div>
        </div>
    </div>
    <!-- /内容区 -->
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
    <script type="text/javascript" src="/Public/static/think.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/common.js"></script>
    <script type="text/javascript">
        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            $subnav.find("a[href='" + url + "']").parent().addClass("current");

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });

            $("#subnav h3 a").click(function(e){e.stopPropagation()});

            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

	        /* 表单获取焦点变色 */
	        $("form").on("focus", "input", function(){
		        $(this).addClass('focus');
	        }).on("blur","input",function(){
				        $(this).removeClass('focus');
			        });
		    $("form").on("focus", "textarea", function(){
			    $(this).closest('label').addClass('focus');
		    }).on("blur","textarea",function(){
					    $(this).closest('label').removeClass('focus');
				    });
        }();
    </script>
    
	<script type="text/javascript">
		Think.setValue("allow_publish", <?php echo ((isset($info["allow_publish"]) && ($info["allow_publish"] !== ""))?($info["allow_publish"]):1); ?>);
		Think.setValue("model[]", <?php echo (json_encode($info["model"])); ?> || [1]);
		Think.setValue("type[]", <?php echo (json_encode($info["type"])); ?> || [2]);
		Think.setValue("display", <?php echo ((isset($info["display"]) && ($info["display"] !== ""))?($info["display"]):0); ?>);
		Think.setValue("reply", <?php echo ((isset($info["reply"]) && ($info["reply"] !== ""))?($info["reply"]):0); ?>);
		Think.setValue("reply_model[]", <?php echo (json_encode($info["reply_model"])); ?> || [1]);
		Think.setValue("reply_type[]", <?php echo (json_encode($info["reply_type"])); ?> || [2]);
		$(function(){
			showTab();
			$("input[name=reply]").change(function(){
				var $reply = $(".form-item.reply");
				parseInt(this.value) ? $reply.show() : $reply.hide();
			}).filter(":checked").change();
		});
		//导航高亮
		$('.side-sub-menu').find('a[href="<?php echo U('Category/index');?>"]').closest('li').addClass('current');
	</script>

</body>
</html>