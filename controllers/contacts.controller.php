<?php

class ContactsController extends Controller
{

	public function __construct($data = array())
	{
		parent::__construct($data);
		$this->model = new Message();
	}

	public function index()
	{

		if ($_POST) {
			if ($this->model->save($_POST)) {
				Session::setFlash('Спасибо, ваше сообщение было отправлено!');
			}
		}
	}

	public function admin_index()
	{
		$this->data = $this->model->getList();
	}

	public function admin_delete()
	{
		$params = App::getRouter()->getParams();
		if (isset($params)) {
			$id = $params[0];
			$this->model->delete($id);
			Router::redirect($_SERVER['HTTP_REFERER']);
		}
	}

}