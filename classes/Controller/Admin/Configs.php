<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Admin_Configs extends Controller_Admin {

	protected $mmenu_cur = 'configs';

	public function go_home()
	{
		parent::go_to($this->mmenu_cur);
	}

	public function before()
	{
		parent::before();
		//---
		$tpl = $this->template;
		$tpl->title[] = 'Настройки';
//		$tpl->submenu = ;
		$tpl->submenu_prefix = 'configs/';
	}

}
