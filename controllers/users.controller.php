<?php

class UsersController extends Controller
{
	public function __construct($data = array())
	{
		parent::__construct($data);
		$this->model = new User();
	}

	public function admin_login()
	{
		if ($_POST && isset($_POST['login']) && isset($_POST['password'])) {
			$user = $this->model->getByLogin($_POST['login']);
			$hash = md5(Config::get('salt') . $_POST['password']);
			if ($user && $user['is_active'] && $hash == $user['password']) {
				Session::set('login', $user['login']);
				Session::set('role', $user['role']);
			}
			Router::redirect('/admin/basket/');
		}
	}

	public function admin_logout()
	{
		Session::destroy();
		Router::redirect('/admin/');
	}

	public function logout()
	{
		Session::destroy();
		Router::redirect('/users/');
	}

	public function index()
	{

		if ($_POST && isset($_POST['login']) && isset($_POST['password'])) {
			$user = $this->model->getByLogin($_POST['login']);
			$hash = md5(Config::get('salt') . $_POST['password']);
			if ($user && $user['is_active'] && $hash == $user['password']) {
				Session::set('id', $user['id']);
				Session::set('login', $user['login']);
				Router::redirect('/');

			} else {
				Session::setFlash('Неправильный логин или пароль');
			}
		}
	}


	public function reg()
	{
		if ($_POST && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['email'])) {
            $id = $this->model->register($_POST);
            if (isset($id) && intval($id)) {
                Session::set('id', $id);
                Session::set('login', $_POST['login']);
                Router::redirect('/');
            }
		}
	}
}