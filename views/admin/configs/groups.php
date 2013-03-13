<h1>Группы настроек</h1>
<ul>
<?php
foreach($groups as $key => $value)
{
	echo "<li>", HTML::anchor(_ar('configs', 'groups', 'edit', $key), "$value ($key)"), "</li>";
}
?>
</ul>

<hr class="" />

<?php
	echo Form::open(_ar('configs', 'groups', 'add')),
					'<b>Добавить:</b>&nbsp;',
					Form::input('name', '', array('required', 'placeholder' => 'Имя', 'pattern' => '[A-Za-z]+')), '&nbsp;',
					Form::input('title', '', array('required', 'placeholder' => 'Описание')), '&nbsp;',
					Form::submit('submit', 'OK'),
					Form::close();
?>
