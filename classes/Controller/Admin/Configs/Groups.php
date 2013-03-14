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
		$cfg = Kohana::$config->load('configs');
		$groups = $cfg->get('groups');
		$titles = $cfg->get('titles');
		$group = $this->request->param('id');
		$configs = Kohana::$config->load($group)->as_array();
		$items = array();
		foreach($configs as $key => $value)
		{
			$item = array(
				'type' => gettype($value),
				'name' => $key,
				'value' => $value,
			);
			if (is_array($value))
			{
				$item['value'] = Arr::to_editable_string($item['value']);
			}
			$items[] = $item;
		}
		$view_data = array(
				'items'=> $items,
				'configs' => $configs,
				'groups' => $groups,
				'group' => $group,
				'titles'=> $titles,
		);
		$this->template->content = View::factory('admin/configs/edit', $view_data);
		$this->template->title[] = 'Группы';
		Assets::css('admin-form-add-edit', '/static/css/admin/form-add-edit.css');
		//---
		if (Kohana::$environment >= Kohana::TESTING)
		{
			$this->Debug_vars($items, '$items');
			$this->Debug_vars($configs, '$configs');
			$this->Debug_vars($groups, '$groups');
			$this->Debug_vars($titles, '$titles');
		}
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

	public function action_save_options()
	{
		//echo Debug::vars($_POST); exit;
		$items = Arr::get($_POST, 'items');
		$types = Arr::get($_POST, 'types');
		$group = $this->request->param('id');
		if (!$items OR !$types OR !$group OR !is_array($types) OR !is_array($items))
		{
			$this->go_back();
		}
		$config = Kohana::$config->load($group);
		foreach($items as $key => $value)
		{
			if (Arr::get($types, $key) == 'array')
				$value = Arr::from_editable_string($value);
			else
			{
				$int = (int) $value;
				if ($value === (string) $int)
					$value = $int;
			}
			$config->set($key, $value);
		}
		$this->go_back();
	}

	public function action_new_option()
	{
		$name = Arr::get($_POST, 'name');
		$type = Arr::get($_POST, 'type');
		$title = Arr::get($_POST, 'title');
		$group = $this->request->param('id');
		if (!$name OR !$title OR !$group)
		{
			$this->go_back();
		}
		$config = Kohana::$config->load($group);
		$config->set($name, $type=='array'?array():'');

		$configs = Kohana::$config->load('configs');
		$titles = $configs->get('titles', array());
		$titles[$group.'.'.$name] = $title;
		$configs->set('titles', $titles);
		$this->go_back();
	}
}

