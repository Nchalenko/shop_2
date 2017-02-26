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
            if (isset($params[1])) {
                $this->model->deleteProduct($id, 1);
            } else {
                $this->model->deleteProduct($id);
            }
        }
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
		$this->index();

		$order = $this->model->checkout($_POST);
		if (intval($order)) {
			$this->deleteAll();//todo Доработать еще отправку уведомления пользователю
			Router::redirect('/');
			Session::setFlash('Ваш номе заказа ' . $order);
		} else {
            Session::setFlash('Что-то пошло не так, попробуйте еще раз');
        }

	}

	public function admin_index()
	{
		$this->data['orders'] = $this->model->getOrders();
	}

	public function admin_changeOrderStatus()
	{
		$params = App::getRouter()->getParams();
		if (isset($params)) {
			$id = $params[0];
			$status = $params[1];
			$this->model->changeOrderStatus($id, $status);
		}
		$referrer = $_SERVER['HTTP_REFERER'];
		header("Location: $referrer");
		return true;
	}

	public function deleteAll()
	{
		$this->model->deleteAll();

		Session::flash('success', '');
		$referrer = $_SERVER['HTTP_REFERER'];
		header("Location: $referrer");
		return true;
	}
}
