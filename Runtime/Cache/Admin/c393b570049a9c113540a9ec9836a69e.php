<?php if (!defined('THINK_PATH')) exit(); switch($addons_config["editor_type"]): case "1": ?>
		<input type="hidden" name="parse" value="0"><?php break;?>
	<?php case "2": ?>
		<input type="hidden" name="parse" value="0">
		<?php if(($addons_config["editor_wysiwyg"]) == "1"): ?><link rel="stylesheet" href="/Public/static/kindeditor/default/default.css" />
			<script charset="utf-8" src="/Public/static/kindeditor/kindeditor-min.js"></script>
			<script charset="utf-8" src="/Public/static/kindeditor/zh_CN.js"></script>
			<script type="text/javascript">
				var editor;
				KindEditor.ready(function(K) {
					editor = K.create('textarea[name="<?php echo ($addons_data["name"]); ?>"]', {
						allowFileManager : false,
						themesPath: K.basePath,
						width: '100%',
						height: '<?php echo ($addons_config["editor_height"]); ?>',
						resizeType: <?php if(($addons_config["editor_resize_type"]) == "1"): ?>1<?php else: ?>0<?php endif; ?>,
						pasteType : 2,
						urlType : 'absolute',
						fileManagerJson : '<?php echo U('fileManagerJson');?>',
						items : ['title', 'fontname', 'fontsize', '|', 'textcolor', 'bgcolor', 'bold','italic', 'underline', 'strikethrough', 'removeformat', '|', 'image','hr', 'emoticons'],
						//uploadJson : '<?php echo U('uploadJson');?>' }
						uploadJson : '<?php echo addons_url("Editor://Upload/ke_upimg");?>'
					});
				});

				$(function(){
					$('textarea[name="<?php echo ($addons_data["name"]); ?>"]').closest('form').submit(function(){
						editor.sync();
					});
				})
			</script>

		<?php else: ?>
			<script type="text/javascript" charset="utf-8" src="/Public/static/ueditor/ueditor.config.js"></script>
			<script type="text/javascript" charset="utf-8" src="/Public/static/ueditor/ueditor.all.js"></script>
			<script type="text/javascript" charset="utf-8" src="/Public/static/ueditor/lang/zh-cn/zh-cn.js"></script>
			<script type="text/javascript">
				$('textarea[name="<?php echo ($addons_data["name"]); ?>"]').attr('id', 'editor_id_<?php echo ($addons_data["name"]); ?>');
				window.UEDITOR_HOME_URL = "/Public/static/ueditor";
				window.UEDITOR_CONFIG.initialFrameHeight = parseInt('<?php echo ($addons_config["editor_height"]); ?>');
				window.UEDITOR_CONFIG.scaleEnabled = <?php if(($addons_config["editor_resize_type"]) == "1"): ?>true<?php else: ?>false<?php endif; ?>;
				window.UEDITOR_CONFIG.imageUrl = '<?php echo addons_url("Editor://Upload/ue_upimg");?>';
				window.UEDITOR_CONFIG.imagePath = '';
				window.UEDITOR_CONFIG.imageFieldName = 'imgFile';
				UE.getEditor('editor_id_<?php echo ($addons_data["name"]); ?>');
			</script><?php endif; break;?>
	<?php case "3": ?>
		<script type="text/javascript" src="/Public/static/jquery-migrate-1.2.1.min.js"></script>
		<script charset="utf-8" src="/Public/static/xheditor/xheditor-1.2.1.min.js"></script>
		<script charset="utf-8" src="/Public/static/xheditor/xheditor_lang/zh-cn.js"></script>
		<script type="text/javascript" src="/Public/static/xheditor/xheditor_plugins/ubb.js"></script>
		<script type="text/javascript">
		var submitForm = function (){
			$('textarea[name="<?php echo ($addons_data["name"]); ?>"]').closest('form').submit();
		}
		$('textarea[name="<?php echo ($addons_data["name"]); ?>"]').attr('id', 'editor_id_<?php echo ($addons_data["name"]); ?>')
		$('#editor_id_<?php echo ($addons_data["name"]); ?>').xheditor({
			tools:'full',
			showBlocktag:false,
			forcePtag:false,
			beforeSetSource:ubb2html,
			beforeGetSource:html2ubb,
			shortcuts:{'ctrl+enter':submitForm},
			'height':'<?php echo ($addons_config["editor_height"]); ?>',
			'width' :'100%'
		});
		</script>
		<input type="hidden" name="parse" value="1"><?php break;?>
	<?php case "4": ?>
		<script type="text/javascript" src="/Public/static/jquery-migrate-1.2.1.min.js"></script>
		<script charset="utf-8" src="/Public/static/xheditor/xheditor-1.2.1.min.js"></script>
		<script charset="utf-8" src="/Public/static/xheditor/xheditor_lang/zh-cn.js"></script>
		<script type="text/javascript" src="/Public/static/xheditor/xheditor_plugins/showdown.js"></script>
		<script type="text/javascript" src="/Public/static/xheditor/xheditor_plugins/htmldomparser.js"></script>
		<script type="text/javascript" src="/Public/static/xheditor/xheditor_plugins/html2markdown.js"></script>
		<script type="text/javascript">
			$(function(){
				$('textarea[name="<?php echo ($addons_data["name"]); ?>"]').attr('id', 'editor_id_<?php echo ($addons_data["name"]); ?>').css(
					'height','<?php echo ($addons_config["editor_height"]); ?>'
				);
			})
			var markdownConverter = new Showdown.converter();
			function Md2HTML(md){
				return markdownConverter.makeHtml(md);
			}
			function HTML2Md(html){
				var md = HTML2Markdown(html);
				md = md.replace(/&(lt|gt|amp|quot);/ig,function(all, t){
					return {'lt':'<','gt':'>','amp':'&','quot':'"'}[t.toLowerCase()];
				});
				return md;
			}

			$(function(){
				var markdownCSS = '<style>*{margin:0;padding:0;}p {margin:1em 0;line-height:1.5em;}table {font-size:inherit;font:100%;margin:1em;}table th{border-bottom:1px solid #bbb;padding:.2em 1em;}table td{border-bottom:1px solid #ddd;padding:.2em 1em;}input[type=text],input[type=password],input[type=image],textarea{font:99% helvetica,arial,freesans,sans-serif;}select,option{padding:0 .25em;}optgroup{margin-top:.5em;}img{border:0;max-width:100%;}abbr{border-bottom:none;}a{color:#4183c4;text-decoration:none;}a:hover{text-decoration:underline;}a code,a:link code,a:visited code{color:#4183c4;}h2,h3{margin:1em 0;}h1,h2,h3,h4,h5,h6{border:0;}h1{font-size:170%;border-bottom:4px solid #aaa;padding-bottom:.5em;margin-top:1.5em;}h1:first-child{margin-top:0;padding-top:.25em;border-top:none;}h2{font-size:150%;margin-top:1.5em;border-bottom:4px solid #e0e0e0;padding-bottom:.5em;}h3{margin-top:1em;}hr{border:1px solid #ddd;}ul{margin:1em 0 1em 2em;}ol{margin:1em 0 1em 2em;}ul li,ol li{margin-top:.5em;margin-bottom:.5em;}ul ul,ul ol,ol ol,ol ul{margin-top:0;margin-bottom:0;}blockquote{margin:1em 0;border-left:5px solid #ddd;padding-left:.6em;color:#555;}dt{font-weight:bold;margin-left:1em;}dd{margin-left:2em;margin-bottom:1em;}pre{margin-left:2em;border-left:3px solid #CCC;padding:0 1em;}</style>';
				var plugins={
					Code:{c:'btnCode',t:'插入代码',h:1,e:function(){
						var _this=this;
						var htmlCode='<div><textarea id="xheCodeValue" wrap="soft" spellcheck="false" style="width:300px;height:100px;" /></div><div style="text-align:right;"><input type="button" id="xheSave" value="确定" /></div>';
						var jCode=$(htmlCode),
							jValue=$('#xheCodeValue',jCode),
							jSave=$('#xheSave',jCode);
						jSave.click(function(){
							_this.loadBookmark();
							_this.pasteHTML('<pre>'+_this.domEncode(jValue.val())+'</pre>');
							_this.hidePanel();
							return false;
						});
						_this.saveBookmark();
						_this.showDialog(jCode);
					}}
				};
				$('#editor_id_<?php echo ($addons_data["name"]); ?>').xheditor({
					'height':'<?php echo ($addons_config["editor_height"]); ?>',
					'tools':'Cut,Copy,Paste,Pastetext,|,Blocktag,Bold,Italic,SelectAll,Removeformat,|,List,Outdent,Indent,|,Link,Unlink,Img,Hr,Code,map,|,Source,Print,Fullscreen',
					'listBlocktag': [{n:'h1'},{n:'h2'},{n:'h3'},{n:'h4'},{n:'h5'},{n:'h6'}],
					'beforeSetSource': Md2HTML,
					'beforeGetSource': HTML2Md,
					'loadCSS': markdownCSS,
					'width' :'100%'
				});
			});
		</script>
		<input type="hidden" name="parse" value="2"><?php break; endswitch;?>