<?php

class ProductsController extends Controller
{

	public function __construct($data = array())
	{
		parent::__construct($data);
		$this->model = new Product();
	}


	public function index()
	{
		$this->data['products'] = $this->model->getList(true);
		$this->data['main_category'] = $this->model->getMainList();
		$this->data['category'] = $this->model->getAll();

	}

	public function category()
	{

		$params = App::getRouter()->getParams();

		if (isset($params[0])) {
			$id = strtolower($params[0]);
			$this->data['main_category'] = $this->model->getMainList();
			$this->data['products'] = $this->model->getByCategory($id);
			$this->data['category'] = $this->model->getAll();
			$this->data['checked_id'] = $params[0];
		} else {
			$this->data['products'] = $this->model->getList(true);
			$this->data['main_category'] = $this->model->getMainList();
			$this->data['category'] = $this->model->getAll();
		}
	}

	public function admin_category()
	{

		$params = App::getRouter()->getParams();

		if (isset($params[0])) {
			$id = strtolower($params[0]);
			$this->data['main_category'] = $this->model->getMainList();
			$this->data['products'] = $this->model->getByCategory($id);
			$this->data['category'] = $this->model->getAll();
			$this->data['checked_id'] = $params[0];
		} else {
			$this->data['products'] = $this->model->getList(true);
			$this->data['main_category'] = $this->model->getMainList();
			$this->data['category'] = $this->model->getAll();
		}
	}

	public function view()
	{
		$this->data['main_category'] = $this->model->getMainList();
		$this->data['category'] = $this->model->getAll();

		$params = App::getRouter()->getParams();

		if (isset($params[0])) {
			$alias = strtolower($params[0]);
			$this->data['product'] = $this->model->getByAlias($alias);
		}
	}

	public function admin_index()
	{
		$this->data['product'] = $this->model->getList();
		$this->data['main_category'] = $this->model->getMainList();
		$this->data['category'] = $this->model->getAll();
	}

	public function admin_add()
	{
		$this->data['category'] = $this->model->getAll();

		$this->model->image();

		if ($_POST) {
			$result = $this->model->save($_POST);
			if ($result) {
				Session::setFlash("Product was Added");
			} else {
				Session::setFlash('Error.');
			}
			Router::redirect('/admin/products/');
		}
	}

	public function admin_edit()
	{

		$this->data['category'] = $this->model->getAll();
		$this->model->image();
		if ($_POST) {
			$id = isset($_POST['id']) ? $_POST['id'] : null;
			$result = $this->model->save($_POST, $id);
			if ($result) {
				Session::setFlash('Product was saved');
			} else {
				Session::setFlash('Error.');
			}
			Router::redirect('/admin/products/');
		}

		if (isset($this->params[0])) {
			$this->data['product'] = $this->model->getByID($this->params[0]);
		} else {
			Session::setFlash('Wrong product ID.');
			Router::redirect('/admin/products/');
		}
	}

	public function admin_delete()
	{
		if (isset($this->params[0])) {
			$result = $this->model->delete($this->params[0]);
			if ($result) {
				Session::setFlash('Product was deleted');
			} else {
				Session::setFlash('Error.');
			}
		}
		Router::redirect('/admin/products/');
	}

	public function admin_shownotactive()
	{
		$this->data['notactive'] = $this->model->showNotActive();
	}


}
