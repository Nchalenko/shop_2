<?php

class SalesController extends Controller{

	public function __construct($data = array())
	{
		parent::__construct($data);
		$this->model = new Sale;
	}

	public function index()
	{
		$this->data['sales'] = $this->model->getInfo();
	}

	public function admin_index()
	{
		$this->data['sales'] = $this->model->getInfo();
	}

	public function admin_edit()
	{
		$this->data['sales'] = $this->model->getInfo();
		if ($_POST) {
			$sales = isset($_POST['edited']) ? $_POST['edited'] : null;
			$result = $this->model->editInfo($sales);
			if ($result) {
				Session::setFlash('Page was saved');
			} else {
				Session::setFlash('Error.');
			}
			Router::redirect('/admin/sales/');
		}
	}
}
