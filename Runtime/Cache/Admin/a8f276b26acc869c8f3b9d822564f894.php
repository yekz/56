<?php if (!defined('THINK_PATH')) exit();?><div class="form-item cf">
	<label class="item-label">详细内容</label>
	<div class="controls">
		<label class="textarea">
            <textarea name="content" id="content"><?php echo ($info["content"]); ?></textarea>
            <?php echo hooks('adminArticleEdit', array('name'=>'content','value'=>$info['content']));?>
		</label>
	</div>
</div>
<div class="form-item cf">
	<label class="item-label">下载次数</label>
	<div class="controls">
		<input type="text" class="text input-large" name="download" value="<?php echo ($info["download"]); ?>">
	</div>
</div>
<div class="form-item cf">
	<label class="item-label">上传文件</label>
	<div class="controls">
		<input type="file" id="download-file">
		<input type="hidden" name="file" value="<?php echo ($info["file"]); ?>"/>
		<div class="upload-img-box">
			<div class="upload-pre-file"><?php echo ($info["file_id"]["name"]); ?></div>
		</div>
	</div>
</div>