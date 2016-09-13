<?php

class CabinetController extends Controller{

	public function __construct($data = array())
	{
		parent::__construct($data);
		$this->model = new Cabina();
	}


	public function index(){

	}

	public function info(){
		$id = $_SESSION['id'];
		$this->data['info'] = $this->model->info($id);
	}

}