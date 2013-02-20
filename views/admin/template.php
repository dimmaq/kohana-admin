<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="ru" />
		<link rel="shortcut icon" href="/favicon.png" type="image/png">
		<title><?=is_array($title)?implode(' - ', array_reverse($title)):$title;?></title>
		<?= Assets::group('head'); ?>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<!-- главное меню -->
				<div id="mmenu">
					<?=admin_draw_menu_items($mmenu, $mmenu_cur, 'admin/');?>
					<span class="right"><?= HTML::anchor('admin/logout', __('Выход')); ?></span>
					<span class="right">&nbsp;|&nbsp;</span>
					<span class="right"><?= HTML::anchor('/', 'Переход к сайту', array('target'=>'_blank')); ?></span>
				</div>
				<?php
					if (!empty($submenu))
					{
						echo '<div id="submenu">';
						admin_draw_menu_items($submenu, $submenu_cur, 'admin/'.$submenu_prefix);
						echo '</div>';
					}
				?>
			</div>
			<div id="content">
				<?=$content;?>
			</div>
		</div>
	<br class="clearfloat" />
	<br class="clearfloat" />
<?=$debug?>
	<br class="clearfloat" />
	<div>
		<?=View::factory('profiler/stats');?>
	</div>
	</body>
</html>
