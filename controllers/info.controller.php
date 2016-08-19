<?php

class InfoController extends Controller
{

	public function __construct($data = array())
	{
		parent::__construct($data);
		$this->model = new Infopage;
	}

	public function index()
	{
		$this->data['info'] = $this->model->getInfo();
	}

	public function admin_index()
	{
		$this->data['info'] = $this->model->getInfo();
	}

	public function admin_edit()
	{
		$this->data['info'] = $this->model->getInfo();
		if ($_POST) {
			$info = isset($_POST['edited']) ? $_POST['edited'] : null;
			$result = $this->model->editInfo($info);
			if ($result) {
				Session::setFlash('Page was saved');
			} else {
				Session::setFlash('Error.');
			}
			Router::redirect('/admin/info/');
		}
	}
}