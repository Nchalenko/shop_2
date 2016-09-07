<?php

class BasketController extends Controller
{

	public function __construct($data = array())
	{
		parent::__construct($data);
		$this->model = new Basket_Page;
	}

	public function add()
	{
		$params = App::getRouter()->getParams();
		if (isset($params)) {
			$id = $params[0];
		}
		Basket_Page::addProduct($id);//Добавляем в корзину
		$referrer = $_SERVER['HTTP_REFERER'];
		header("Location: $referrer");
		return true;
	}

	public function delete()
	{
		$params = App::getRouter()->getParams();
		if (isset($params)) {
			$id = $params[0];
		}
		$this->model->deleteProduct($id);
		$referrer = $_SERVER['HTTP_REFERER'];
		header("Location: $referrer");
		return true;

	}

	public function index()
	{
		$productsInBasket = false;
		$productsInBasket = $this->model->getProducts();
		$this->data['productsInBasket'] = $productsInBasket;
		if ($productsInBasket) {
			$productsByIds = array_keys($productsInBasket);
			$this->data['productsbyid'] = $this->model->getProductsByIds($productsByIds);
			$this->data['total_price'] = $this->model->getTotal($this->data['productsbyid']);
		}
	}

	public function checkout()
	{
		$productsInBasket = false;
		$productsInBasket = $this->model->getProducts();
		$this->data['productsInBasket'] = $productsInBasket;
		if ($productsInBasket) {
			$productsByIds = array_keys($productsInBasket);
			$this->data['productsbyid'] = $this->model->getProductsByIds($productsByIds);
			$this->data['total_price'] = $this->model->getTotal($this->data['productsbyid']);
		}

		$this->model->checkout($_POST);
	}

}