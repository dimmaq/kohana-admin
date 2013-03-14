<h1>Группа настроек &laquo;<?="{$groups[$group]} ($group)"?>&raquo;</h1>
<a href="<?=_ar('configs', 'groups')?>">←&nbsp;Назад к списку</a>
<?php if ($items):
	echo Form::open(_ar('configs', 'groups', 'save_options', $group), ['class' => 'form-add-edit confirm']);
?>
<table class="form-table">
	<?php
	foreach($items as $val)
	{
		$name = $val['name'];
		$name_text = Arr::get($titles, $group.'.'.$name);
		if ($name_text)
			$name_text .= " / <b>$name</b>";
		else
			$name_text = "<b>$name</b>";
		if ($val['type']=='array')
			echo '<tr><td class="form-desc">', $name_text, '<br ><i class="form-hint">(список)</i></td>',
							'<td><textarea name="items[', $name,']">', HTML::entities($val['value']), '</textarea></td></tr>';
		else
			echo '<tr><td class="form-desc">', $name_text, '<br ><i class="form-hint"></i></td>',
							'<td><input type="text" name="items[', $name, ']" value="', HTML::entities($val['value']), '" /></td></tr>';

		echo Form::hidden("types[$name]", $val['type']);
	}
	?>
	<tr>
		<td colspan="2" align="right"><input type="submit" name="save" value="Cохранить" /></td>
	</tr>
</table>
<?php
	echo Form::close();
	else:
		echo "<h2>Пусто</h2>";
	endif;
?>

<hr class="" />

<?php
	echo Form::open(_ar('configs', 'groups', 'new_option', $group)),
					'<b>Добавить настройку:</b>&nbsp;',
					Form::input('name', '', array('required', 'placeholder' => 'Имя')), '&nbsp;',
					Form::select('type', array('string' => 'Строка', 'array' => 'Список'), NULL, array('required')), '&nbsp;',
					Form::input('title', '', array('placeholder' => 'Описание')), '&nbsp;',
					Form::submit('submit', 'OK'),
					Form::close();
?>
