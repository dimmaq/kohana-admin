<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Auth extends Controller_Admin {

	protected $auth_needed = FALSE;

	public $template = 'admin/auth/login';

	public function action_login() {

		// If user is already logged in, redirect to admin main
		if ($this->auth->logged_in())
		{
			$this->go_to();
		}

		if (Arr::get($_POST, 'cipher'))
			Nossl::decipher();

		$user = Arr::get($_POST, 'user');
		$pass = Arr::get($_POST, 'pass');

		if (!empty($user) AND !empty($pass))
		{
			if (Kohana::$environment == Kohana::PRODUCTION)
			{
				sleep(rand(2,10));
			}
			if ($this->auth->login($user, $pass))
			{
				Kohana::$log->add(Log::INFO, 'access to admin from :ip :user::pass', array(
					':ip'   => $_SERVER['REMOTE_ADDR'],
					':user' => $user,
					':pass' => $pass,
				));
				$ref = Session::instance()->get_once('referer');
				if ($ref)
				{
					$this->redirect($ref);
				}
				else
				{
					$this->go_to();
				}
			};
			Kohana::$log->add(Log::INFO, 'fail admin login from :ip :user::pass', array(
				':ip'   => $_SERVER['REMOTE_ADDR'],
				':user' => $user,
				':pass' => $pass,
			));
		}

		Nossl::init();
		$pass = '';
		$this->template->set('user', $user)->set('pass', $pass);
	}

	public function action_logout() {
		$url = parse_url($this->request->referrer());
		$ref_host = Arr::get($url, 'host');
		if ($ref_host !== $_SERVER['HTTP_HOST'])
		{
			$this->redirect('/');
		}
		else
		{
			$this->auth->logout(TRUE, TRUE);
			$this->redirect('admin/login');
		}
	}
}

