<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Base extends Controller_Template_Base {

	/**
	 * @var  View
	 */
	public $template = 'admin/template';

	/**
	 * @var  Auth
	 **/
	protected $auth = NULL;
	/**
	 * @var  string
	 **/
	protected $user = FALSE;
	/**
	 * @var  Session
	 **/
	protected $session = NULL;

	/**
	 * Authentication needed to watch page
	 * @var  boolean
	 */
	protected $auth_needed = TRUE;

	/**
	 * @var string
	 */
	protected $submenu_cur = NULL;

/**
	 * @var string
	 */
	protected $submenu_prefix = '';


	/**
	 * Method which is executed before any action takes place
	 *
	 * @return  void
	 */
	public function before()
	{
		parent::before();
		//---
		$this->auth = Auth::instance();
		$this->user = $this->auth->get_user();
		$this->session = Session::instance();
		//---
		// If auth is needed: check if an admin is logged in
		if (($this->auth_needed === TRUE) AND (!$this->user))
		{
			Kohana::$log->add(Log::INFO, 'try admin access from :ip to :class :uri', array(
				':ip'    => Request::$client_ip,
				':class' => get_class($this),
				':uri'   => $_SERVER['REQUEST_URI'],
			));
			Session::instance()->set('referer', $_SERVER['REQUEST_URI']);
			$this->redirect('admin/login');
		}
		//---
		if ($this->auth_needed)
		{
			Secure_Session::check($this->session);
		}
		//---
		if ($this->auto_render)
		{
			$tpl = $this->template;
			$tpl->title[] = __('Админка');
			$tpl->mmenu = Kohana::$config->load('admin.mmenu');
			$tpl->submenu = NULL;
			$tpl->submenu_cur = strtolower($this->submenu_cur);
			$tpl->submenu_prefix = $this->submenu_prefix;
			$tpl->content = '';
			$tpl->is_admin = $this->user === 'admin'; //TODO: настроить роли
			//---
			Assets::css('admin_main', '/static/css/admin/main.css', NULL, array('media' => 'screen'));
			Assets::js('jquery', 'http://yandex.st/jquery/1.9.1/jquery.js');
			Assets::js('admin_main', '/static/js/admin/main.js', array('main'));
		}
	}


	/**
	 * Fill in default values for our properties before rendering the output.
	 */
	public function after()
	{
		$this->Debug_vars($this->template->submenu, 'submenu');
		$this->Debug_vars($this->template->submenu_cur, 'submenu_cur');
		$this->Debug_vars($this->template->submenu_prefix, 'submenu_prefix');
		//---
		parent::after();
	}

	/**
	* @param   string  Subdir admin route
	* @param   string  Request controller
	* @param   string  Request action
	* @param   string  ID
	* @param   array   Overflow (for instance: directory or id to be added to the uri)
	* @return  void
	*/
	protected function go_to($dir = '', $controller = NULL, $action = NULL, $id = NULL, $overflow = NULL)
	{
		if (!Arr::is_array($overflow))
			$overflow = array();
		$overflow['directory'] = $dir;
		$overflow['id'] = $id;
		Kohana::$log->add(Log::INFO, 'admin_go_to: ' . "$dir, $controller, $action, $id, " . print_r($overflow, TRUE));
		parent::go_to('admin', $controller, $action, $overflow);
	}

	public function go_home()
	{
		$this->go_to();
	}

}
