<?php if (!defined('THINK_PATH')) exit();?><div class="form-item cf">
	<label class="item-label">详细内容</label>
	<div class="controls">
		<label class="textarea">
			<textarea name="content" id="content"><?php echo ($info["content"]); ?></textarea>
			<?php echo hooks('adminSecondHandArticleEdit', array('name'=>'content','value'=>$content));?>
		</label>
	</div>
</div>