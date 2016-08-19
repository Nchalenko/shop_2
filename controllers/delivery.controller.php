<?php

class DeliveryController extends Controller{

	public function __construct($data = array())
	{
		parent::__construct($data);
		$this->model = new Delivery_info;
	}

	public function index()
	{
		$this->data['delivery'] = $this->model->getInfo();
	}

	public function admin_index()
	{
		$this->data['delivery'] = $this->model->getInfo();
	}

	public function admin_edit()
	{
		$this->data['delivery'] = $this->model->getInfo();
		if ($_POST) {
			$delivery = isset($_POST['edited']) ? $_POST['edited'] : null;
			$result = $this->model->editInfo($delivery);
			if ($result) {
				Session::setFlash('Page was saved');
			} else {
				Session::setFlash('Error.');
			}
			Router::redirect('/admin/delivery/');
		}
	}
}