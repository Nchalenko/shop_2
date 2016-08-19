<?php

class CabinetController extends Controller{

	public function __construct($data = array())
	{
		parent::__construct($data);
		$this->model = new Cabina();
	}


	public function index(){

	}

}