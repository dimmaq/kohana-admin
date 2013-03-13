<?php defined('SYSPATH') OR die('No direct script access.');

class Controller_Admin_Configs_Groups extends Controller_Admin_Configs {

	protected $submenu_cur = 'groups';

	public function go_home()
	{
		parent::go_to($this->mmenu_cur, $this->submenu_cur);
	}

	public function action_index()
	{
		$this->template->title[] = 'Группы';
		//---
		$config = Kohana::$config->load('configs');
		$groups = $config->get('groups');
		$view_data = array(
				'groups' => $groups,
		);
		$this->template->content = View::factory('admin/configs/groups', $view_data);
	}

	public function action_edit()
	{
		$groups = Kohana::$config->load('configs.groups');
		$group = $this->request->param('id');
		$configs = Kohana::$config->load($group);
		$view_data = array(
				'configs' => $configs,
				'groups' => $groups,
		);
		$this->template->content = View::factory('admin/configs/edit', $view_data);
		$this->template->title[] = 'Группы';
	}

	public function action_add()
	{
		$name = Arr::get($_POST, 'name');
		$title = Arr::get($_POST, 'title');
		if (!$name OR !$title)
		{
			$this->go_back();
		}
		$config = Kohana::$config->load('configs');
		$groups = $config->get('groups');
		$groups[$name] = $title;
		$config->set('groups', $groups);
		$this->go_back();
	}

}

