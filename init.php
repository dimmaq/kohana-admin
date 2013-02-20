<?php defined('SYSPATH') or die('No direct script access.');


Route::set('admin/auth', 'admin/<action>', array(
	'action' => 'login|logout',
	))
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'auth',
		'action'     => 'login',
	));

Route::set('admin', 'admin(/<directory>(/<controller>(/<action>(/<id>))))')
	->filter(function($route, $params, $request)
	{
		Kohana::$log->add(Log::DEBUG, Debug::vars($params));
		if (empty($params['directory']))
			$params['directory'] = 'Admin';
		else
			$params['directory'] = 'Admin/'.$params['directory'];
		return $params;
	})
	->defaults(array(
		'directory'  => '',
		'controller' => 'welcome',
		'action'     => 'index',
	));

/**
 * Возвращает ссылку в админке
 * @param string $directory
 * @param string $controller
 * @param string $action
 * @param string $id
 * @param array $params
 * @return string
 */
function _ar($directory, $controller = '', $action = '', $id = '', $params = array())
{
	$params['directory'] = $directory;
	//---
	return _r('admin', $controller, $action, $id, $params);
}

function admin_draw_menu_items($items, $cur, $prefix = '')
{
	$k = 0;
	foreach ($items as $text => $link)
	{
		$k++;
		if ($k > 1)	echo '&nbsp;|&nbsp;'.PHP_EOL;
		if ($link == $cur)
			echo '<i>'.HTML::anchor($prefix.$link, $text, array('class' => 'cur')).'</i>'.PHP_EOL;
		else
			echo HTML::anchor($prefix.$link, $text).PHP_EOL;
	}
}
