<?php if (!defined('THINK_PATH')) exit();?><div class="span<?php echo ($addons_config["width"]); ?>">
	<div class="columns-mod">
		<div class="hd cf">
			<h5><?php echo ($addons_config["title"]); ?></h5>
			<div class="title-opt">
			</div>
		</div>
		<div class="bd">
			<div class="sys-info">
				<table>
					<tr>
						<th>系统程序版本</th>
						<td>OneThink v<?php echo (ONETHINK_VERSION); ?></td>
					</tr>
					<tr>
						<th>服务器系统及PHP版本</th>
						<td>Linux/PHP v<?php echo (PHP_VERSION); ?></td>
					</tr>
					<tr>
						<th>ThinkPHP版本</th>
						<td>ThinkPHP <?php echo (THINK_VERSION); ?></td>
					</tr>
					<tr>
						<th>服务器软件</th>
						<td><?php echo ($_SERVER['SERVER_SOFTWARE']); ?></td>
					</tr>
					<tr>
						<th>服务器MySql版本</th>
						<?php $system_info_mysql = M()->query("select version() as v;"); ?>
						<td><?php echo ($system_info_mysql["0"]["v"]); ?></td>
					</tr>
					<tr>
						<th>上传许可</th>
						<td><?php echo ini_get('upload_max_filesize');?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>