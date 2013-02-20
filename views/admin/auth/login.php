<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="ru" />
		<link rel="shortcut icon" href="/favicon.png" type="image/png">
		<title>Вход в админку</title>
		<style>
			.login {
				margin: 60px;
			}
			.login td {
				text-align: left;
			}
			.login td.c {
				text-align: center;
			}
			.login td.r {
				text-align: right;
			}
			label {
				user-select: none;
				-webkit-user-select: none;
				-moz-user-select: none;
				-khtml-user-select: none;
			}
		</style>
		<?=Assets::group('head');?>

	</head>
	<body>
		<div id="container">
			<div align="center" class="login">
				<strong>Оставь надежду, всяк сюда входящий</strong>
				<?
					echo Form::open(
						Route::get('admin/auth')->uri(),
						array('name' => 'admin/auth', 'id' => 'login')
					);
					echo Form::hidden('ciphertext', '', array('id'=>'ciphertext'));
					echo Form::hidden('B', '', array('id'=>'B'));
				?>
				<table border="0" cellspacing="0" cellpadding="2">
					<tr>
						<td class="r"><small><?=Form::label('user', 'Имя');?></small></td>
						<td><?=Form::input('user', $user, array('id'=>'user','required', 'placeholder'=>'admin'));?></td>
					</tr>
					<tr>
						<td class="r"><small><?=Form::label('pass', 'Пароль');?></small></td>
						<td><?=Form::password('pass', $pass, array('id'=>'pass','required', 'placeholder'=>'1234'));?></td>
					</tr>
					<tr>
						<td class="r"><small><?=Form::label('cipher', 'Шифровать');?></small></td>
						<td><?=Form::checkbox('cipher', 1, TRUE, array('id'=>'cipher'));?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><?=Form::submit('submit', 'Поехали', array('id'=>'submit'));?></td>
					</tr>
				</table>
				<?php echo Form::close(); ?>
			</div>
		</div>
	</body>
</html>
