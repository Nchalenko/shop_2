<?php

class Basket_Page extends Model
{

	private $products;

	public function __construct()
	{
		$this->products = Session::get('products') == null ?
			array()
			:
			unserialize(Session::get('products'));
	}

	public function getProducts()
	{
		return $this->products;
	}

	public function addProduct($id)
	{
		$id = (int)$id;

		if (!in_array($id, $this->products)) {
			array_push($this->products, $id);
		}

		Session::set('products', serialize($this->products));
	}

	public function deleteProduct($id)
	{
		$id = (int)$id;

		$key = array_search($id, $this->products);
		if ($key !== false){
			unset($this->products[$key]);
		}

		Session::set('products', serialize($this->products));
	}

	public function clear()
	{
		Session::delete('products');
	}

	public function isEmpty()
	{
		return !$this->products;
	}
}