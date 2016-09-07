<?php

class Basket_Page extends Model
{

	public static function addProduct($id)
	{
		$id = intval($id);
		$productsInBasket = array();

		if (isset($_SESSION['products'])) {
			$productsInBasket = $_SESSION['products'];
		}

		if (array_key_exists($id, $productsInBasket)) {
			$productsInBasket[$id]++;
		} else {
			$productsInBasket[$id] = 1;
		}

		$_SESSION['products'] = $productsInBasket;
		return self::countItems();
	}

	public function deleteProduct($id){
		$id = intval($id);

		unset($_SESSION['products'][$id]);
	}

	public function countItems()
	{
		if (isset($_SESSION['products'])) {
			unset($_SESSION['products']['0']);
			$count = 0;
			foreach ($_SESSION['products'] as $id => $qty) {
				$count = $count + $qty;
			}
			return $count;
		} else {
			return 0;
		}
	}

	public function getProducts()
	{
		if (isset($_SESSION['products'])) {
			return $_SESSION['products'];
		}
		return false;
	}

	public function getProductsByIds($id_arr)
	{
		$products = array();
		$idsString = implode(', ', $id_arr);
		$sql = "select * from products where id IN ($idsString)";
		$result = $this->db->query($sql);
		return $result;
	}

	public function getTotal($products)
	{
		$productsInCart = self::getProducts();
		$total = 0;
		if ($productsInCart){
			foreach ($products as $item){
				$total += $item['price'] * $productsInCart[$item['id']];
			}
		}
		return $total;
	}

	public function checkout($data){



		if (!isset($data['name']) || !isset($data['phone']) || !isset($data['email'])) {
			return false;
		}
		$productsInCart = self::getProducts();

		$order = serialize($productsInCart);
		$user_name = $this->db->escape($data['name']);
		$user_phone = $this->db->escape($data['phone']);
		$user_email = $this->db->escape($data['email']);
		$user_comment = $this->db->escape($data['comment']);

		$sql = "
				insert into orders 
						set user_name = '{$user_name}',
			  		 	user_phone = '{$user_phone}',
			  		 	user_email = '{$user_email}',
			  		 	user_comment = '{$user_comment}',
  				  	 	products = '{$order}'
				  	";

		return $this->db->query($sql);

	}

}