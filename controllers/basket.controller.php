<?php

class BasketController extends Controller{

	public function __construct($data = array())
	{
		parent::__construct($data);
		$this->model = new Basket_Page();
	}

	public function add(){
		if ($action == 'add') {
			$id = $_GET['id'];
			$cart->addProduct($id);
			header('Location: index.php');
		}
	}





	public function index(){

	}

	public function admin_index(){
	}
}