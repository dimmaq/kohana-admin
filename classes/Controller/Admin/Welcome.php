<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Admin_Welcome extends Controller_Admin {

	protected $mmenu_cur = '';

	public function action_index() {
		$this->template->title[] = __($this->mmenu_cur);
		$this->template->content = View::factory('admin/main');
	}
}
/*
тест
*/