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
 <h3>
 	<i class="icon <?php if(ACTION_NAME != 'mydocument' and ACTION_NAME != 'draftbox'): ?>icon-fold<?php endif; ?>"></i>
 	个人中心
 </h3>
 	<ul class="side-sub-menu <?php if(ACTION_NAME != 'mydocument' and ACTION_NAME != 'draftbox'): ?>subnav-off<?php endif; ?>">
 		<li <?php if(ACTION_NAME == 'mydocument'): ?>class="current"<?php endif; ?>><a class="item" href="<?php echo U('article/mydocument');?>">我的商品</a></li>
 		<?php if(($show_draftbox) == "1"): ?><li <?php if(ACTION_NAME == 'draftbox'): ?>class="current"<?php endif; ?>><a class="item" href="<?php echo U('article/draftbox');?>">草稿箱</a></li><?php endif; ?>
 	</ul>
    <?php if(is_array($nodes)): $i = 0; $__LIST__ = $nodes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
        <?php if(!empty($sub_menu)): ?><h3>
            	<i class="icon <?php if(($sub_menu['current']) != "1"): ?>icon-fold<?php endif; ?>"></i>
            	<?php if(($sub_menu['allow_publish']) == "1"): ?><a class="item" href="<?php echo (u($sub_menu["url"])); ?>"><?php echo ($sub_menu["title"]); ?></a><?php else: echo ($sub_menu["title"]); endif; ?>
            </h3>
            <ul class="side-sub-menu <?php if(($sub_menu["current"]) != "1"): ?>subnav-off<?php endif; ?>">
                <?php if(is_array($sub_menu['_child'])): $i = 0; $__LIST__ = $sub_menu['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li <?php if($menu['id'] == $cate_id or $menu['current'] == 1): ?>class="current"<?php endif; ?>>
                        <?php if(($menu['allow_publish']) == "1"): ?><a class="item" href="<?php echo (u($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a><?php else: echo ($menu["title"]); endif; ?>

                        <!-- 一级子菜单 -->
                        <?php if(isset($menu['_child'])): ?><ul class="subitem">
                        	<?php if(is_array($menu['_child'])): foreach($menu['_child'] as $key=>$three_menu): ?><li>
                                <?php if(($three_menu['allow_publish']) == "1"): ?><a class="item" href="<?php echo (u($three_menu["url"])); ?>"><?php echo ($three_menu["title"]); ?></a><?php else: echo ($three_menu["title"]); endif; ?>
                                <!-- 二级子菜单 -->
                                <?php if(isset($three_menu['_child'])): ?><ul class="subitem">
                                	<?php if(is_array($three_menu['_child'])): foreach($three_menu['_child'] as $key=>$four_menu): ?><li>
                                        <?php if(($four_menu['allow_publish']) == "1"): ?><a class="item" href="<?php echo (u($four_menu["url"])); ?>"><?php echo ($four_menu["title"]); ?></a><?php else: echo ($four_menu["title"]); endif; ?>
                                        <!-- 三级子菜单 -->
                                        <?php if(isset($four_menu['_child'])): ?><ul class="subitem">
                                        	<?php if(is_array($four_menu['_child'])): $i = 0; $__LIST__ = $four_menu['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$five_menu): $mod = ($i % 2 );++$i;?><li>
                                            	<?php if(($five_menu['allow_publish']) == "1"): ?><a class="item" href="<?php echo (u($five_menu["url"])); ?>"><?php echo ($five_menu["title"]); ?></a><?php else: echo ($five_menu["title"]); endif; ?>
                                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </ul><?php endif; ?>
                                        <!-- end 三级子菜单 -->
                                    </li><?php endforeach; endif; ?>
                                </ul><?php endif; ?>
                                <!-- end 二级子菜单 -->
                            </li><?php endforeach; endif; ?>
                        </ul><?php endif; ?>
                        <!-- end 一级子菜单 -->
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul><?php endif; ?>
        <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>
    <!-- 回收站 -->
	<?php if(($show_recycle) == "1"): ?><h3>
        <em class="recycle"></em>
        <a href="<?php echo U('article/recycle');?>">回收站</a>
    </h3><?php endif; ?>
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
            

            
	<div class="main-title cf">
		<h2>
			<?php if(ACTION_NAME == 'add'): ?>新增<?php else: ?>编辑<?php endif; echo (get_document_model($info["model_id"],'title')); ?> [
			<?php if(is_array($rightNav)): $i = 0; $__LIST__ = $rightNav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?><a href="<?php echo U('article/index','cate_id='.$nav['id']);?>"><?php echo ($nav["title"]); ?></a>
			<?php if(count($rightNav) > $i): ?><i class="ca"></i><?php endif; endforeach; endif; else: echo "" ;endif; ?>
			<?php if(isset($article)): ?>：<a href="<?php echo U('article/index','cate_id='.$info['category_id'].'&pid='.$article['id']);?>"><?php echo ($article["title"]); ?></a><?php endif; ?>
			]
		</h2>
	</div>
	<!-- 标签页导航 -->
<div class="tab-wrap">
	<ul class="tab-nav nav">
		<li data-tab="tab1" class="current"><a href="javascript:void(0);">基 础</a></li>
		<li data-tab="tab2"><a href="javascript:void(0);">高 级</a></li>
		<li data-tab="tab3"><a href="javascript:void(0);">扩 展</a></li>
	</ul>
	<div class="tab-content">
	<!-- 表单 -->
	<form id="form" action="<?php echo U('update');?>" method="post" class="form-horizontal">
		<!-- 基础文档模型 -->
		<div id="tab1" class="tab-pane in tab1">

			<div class="form-item cf">
				<label class="item-label">商品名称<span class="check-tips">（请输入商品名称）</span></label>
				<div class="controls">
					<input type="text" class="text input-large" name="title" value="<?php echo ($info["title"]); ?>">
				</div>
			</div>
			<div class="form-item cf">
				<label class="item-label">商品价格<span class="check-tips"></span></label>
				<div class="controls">
					<input type="text" class="text input-large" name="price" value="<?php echo ($info["price"]); ?>">
				</div>
			</div>
			<div class="form-item cf">
				<label class="item-label">商品库存<span class="check-tips"></span></label>
				<div class="controls">
					<input type="text" class="text input-large" name="stock" value="<?php echo ($info["stock"]); ?>">
				</div>
			</div>
			<div class="form-item cf">
				<label class="item-label">商品标识<span class="check-tips">（商品标识主要用于URL优化，对商品的URL没有要求则可不填）</span></label>
				<div class="controls">
					<input type="text" class="text input-large" name="name" value="<?php echo ($info["name"]); ?>">
				</div>
			</div>
			<div class="form-item cf">
				<label class="item-label">商品类型<span class="check-tips">（商品类型标识了商品的显示结构，一般普通商品选择主题）</span></label>
				<div class="controls">
					<select name="type">
						<?php if(is_array($type_list)): $i = 0; $__LIST__ = $type_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($type); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
			</div>
			<div class="form-item cf">
				<label class="item-label">商品摘要<span class="check-tips">（请输入简介）</span></label>
				<div class="controls">
					<label class="textarea input-large">
						<textarea name="description"><?php echo ($info["description"]); ?></textarea>
					</label>
				</div>
			</div>
		</div>

		<div id="tab2" class="tab-pane tab2">
			<div class="form-item cf">
				<label class="item-label">优先级<span class="check-tips">（数字越大，排序越靠前）</span></label>
				<div class="controls">
					<input type="text" class="text input-large" name="level" value="<?php echo ((isset($info["level"]) && ($info["level"] !== ""))?($info["level"]):0); ?>">
				</div>
			</div>
			<div class="form-item cf">
				<label class="item-label">外链地址</label>
				<div class="controls">
					<input type="text" class="text input-large" name="link_id" value="<?php echo (get_link($info["link_id"])); ?>">
				</div>
			</div>
			<div class="form-item cf">
				<label class="item-label">发布时间<span class="check-tips">（格式: yyyy-mm-dd hh:ii）</span></label>
				<div class="controls">
					<input id="create_time" type="text" class="text input-large" name="create_time" value="<?php echo ($info["create_time"]); ?>" />
				</div>
			</div>
			<div class="form-item cf">
				<label class="item-label">截止时间<span class="check-tips">（格式: yyyy-mm-dd hh:ii）</span></label>
				<div class="controls">
					<input id="dateline" type="text" class="text input-large" name="dateline" value="<?php echo ($info["dateline"]); ?>" />
				</div>
			</div>
			<div class="form-item cf">
				<label class="item-label">推荐位置</label>
				<div class="controls">
					<?php $_result=C('DOCUMENT_POSITION');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$position): $mod = ($i % 2 );++$i;?><label class="checkbox"><input type="checkbox" name="position[]" value="<?php echo ($key); ?>" <?php if(check_document_position($info['position'],$key)): ?>checked="checked"<?php endif; ?>><?php echo ($position); ?></label><?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
			</div>
			<div class="form-item cf">
				<label class="item-label">可见性</label>
				<div class="controls">
					<?php $_result=C('DOCUMENT_DISPLAY');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$title): $mod = ($i % 2 );++$i;?><label class="radio"><input type="radio" name="display" value="<?php echo ($key); ?>"><?php echo ($title); ?></label><?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
			</div>
			<div class="form-item cf">
				<label class="item-label">封面图片</label>
				<div class="controls">
					<input type="file" id="upload_picture">
					<input type="hidden" id="cover_id" name="cover_id" value="<?php echo ($info["cover_id"]); ?>"/>
					<div class="upload-img-box">
					<?php if(!empty($info['cover_id'])): ?><div class="upload-pre-item"><img src="<?php echo (get_cover($info["cover_id"],'path')); ?>"/></div><?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<div id="tab3" class="tab-pane tab3">
			<!-- 引入扩展文档模型 -->
			<?php echo ($extend); ?>
		</div>

		<div class="form-item cf">
			<button class="btn submit-btn" id="submit-next" type="button">下一步</button>
			<button class="btn submit-btn ajax-post hidden" id="submit" type="submit" target-form="form-horizontal">确 定</button>
			<a class="btn btn-return" href="<?php echo U('article/index?cate_id='.$cate_id);?>">返 回</a>
			<?php if(C('OPEN_DRAFTBOX') and (ACTION_NAME == 'add' or $info['status'] == 3)): ?><button class="btn save-btn" url="<?php echo U('article/autoSave');?>" target-form="form-horizontal" id="autoSave">
				存草稿
			</button><?php endif; ?>
			<input type="hidden" name="id" value="<?php echo ($info["id"]); ?>"/>
			<input type="hidden" name="pid" value="<?php echo ($info["pid"]); ?>"/>
			<input type="hidden" name="model_id" value="<?php echo ($info["model_id"]); ?>"/>
			<input type="hidden" name="category_id" value="<?php echo ($info["category_id"]); ?>">
		</div>
	</form>
	</div>
</div>

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
    
<link href="/Public/static/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
<link href="/Public/static/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/Public/static/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript" src="/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript">

Think.setValue("type", <?php echo ((isset($info["type"]) && ($info["type"] !== ""))?($info["type"]):'""'); ?>);
Think.setValue("display", <?php echo ((isset($info["display"]) && ($info["display"] !== ""))?($info["display"]):0); ?>);

$('#submit').click(function(){
	$('#form').submit();
});

(function($){
	//上传文件
	/* 初始化上传插件 */
	$("#download-file").uploadify({
        "height"          : 30,
        "swf"             : "/Public/static/uploadify/uploadify.swf",
        "fileObjName"     : "download",
        "buttonText"      : "上传文件",
        "uploader"        : "<?php echo U('File/upload',array('session_id'=>session_id()));?>",
        "width"           : 120,
        'removeTimeout'   : 1,
        "onUploadSuccess" : uploadSuccess
    });

	/* 文件上传成功回调函数 */
    function uploadSuccess(file, data){
    	var data = $.parseJSON(data);
        if(data.status){
        	$("input[name=file]").val(data.data);
        	$("input[name=file]").parent().find('.upload-img-box').html(
        		"<div class=\"uplaod-pre-file\">" + data.info + "</div>"
        	);
        } else {
        	updateAlert(data.info);
        }
    }

  	//上传图片
    /* 初始化上传插件 */
	$("#upload_picture").uploadify({
        "height"          : 30,
        "swf"             : "/Public/static/uploadify/uploadify.swf",
        "fileObjName"     : "download",
        "buttonText"      : "上传图片",
        "uploader"        : "<?php echo U('File/uploadPicture',array('session_id'=>session_id()));?>",
        "width"           : 120,
        'removeTimeout'	  : 1,
        'fileTypeExts'	  : '*.jpg; *.png; *.gif;',
        "onUploadSuccess" : uploadPicture
    });
	function uploadPicture(file, data){
    	var data = $.parseJSON(data);
        if(data.status){
        	$("#cover_id").val(data.id);
        	$("#cover_id").parent().find('.upload-img-box').html(
        		'<div class="upload-pre-item"><img src="' + data.path + '"/></div>'
        	);
        } else {
        	updateAlert(data.info);
        }
    }
})(jQuery);
$(function(){
    $('#dateline').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
	    language:"zh-CN",
	    minView:2,
	    autoclose:true
    });
    $('#create_time').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
	    language:"zh-CN",
	    minView:2,
	    autoclose:true
    });
	nextTab();

	<?php if(C('OPEN_DRAFTBOX') and (ACTION_NAME == 'add' or $info['status'] == 3)): ?>//保存草稿
	var interval;
	$('#autoSave').click(function(){
        var target_form = $(this).attr('target-form');
        var target = $(this).attr('url')
        var form = $('.'+target_form);
        var query = form.serialize();
        var that = this;

        $(that).addClass('disabled').attr('autocomplete','off').prop('disabled',true);
        $.post(target,query).success(function(data){
            if (data.status==1) {
                updateAlert(data.info ,'alert-success');
                $('input[name=id]').val(data.data.id);
            }else{
                updateAlert(data.info);
            }
            setTimeout(function(){
                $('#top-alert').find('button').click();
                $(that).removeClass('disabled').prop('disabled',false);
            },1500);
        })

        //重新开始定时器
        clearInterval(interval);
        autoSaveDraft();
        return false;
    });

	//Ctrl+S保存草稿
	$('body').keydown(function(e){
		if(e.ctrlKey && e.which == 83){
			$('#autoSave').click();
			return false;
		}
	});

	//每隔一段时间保存草稿
	function autoSaveDraft(){
		interval = setInterval(function(){
			//只有基础信息填写了，才会触发
			var title = $('input[name=title]').val();
			var name = $('input[name=name]').val();
			var des = $('textarea[name=description]').val();
			if(title != '' || name != '' || des != ''){
				$('#autoSave').click();
			}
		}, 1000*parseInt(<?php echo C('AOTUSAVE_DRAFT');?>));
	}
	autoSaveDraft();<?php endif; ?>
});
</script>

</body>
</html>