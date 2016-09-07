<?php

class Product extends Model
{

	public function getMainList()
	{
		$sql = "select id, title from categories WHERE parent_id is null";
		return $this->db->query($sql);
	}

	public function getAll()
	{
		$sql = "select * from categories where parent_id is not null";
		return $this->db->query($sql);
	}

	public function getByCategory($category_id)
	{
		$sql = "select * from products where category = '{$category_id}'";
		return $this->db->query($sql);
	}


	public function getByAlias($alias)
	{
		// Получаем товар по алиасу
		$alias = $this->db->escape($alias);
		$sql = "select * from products where alias = '{$alias}'";
		// Если нужна только одна строка
		if ($result = $this->db->query($sql)) {
			return $result[0];
		}
		return null;
	}

	public function getByID($id)
	{
		$id = (int)$id;
		$sql = "select * from products where id = '{$id}' limit 1";
		$result = $this->db->query($sql);
		return isset($result[0]) ? $result[0] : null;
	}

	public function getList($is_active = false)
	{
		$sql = "select * from products where 1";
		if ($is_active) {
			$sql .= " and is_active = 1";
		}
		return $this->db->query($sql);
	}

	public function getTop3()
	{
		// Получаем ТОП3 дорогих товаров
		$sql = "
          select * from products
          order by price desc
          limit 3
        ";
		return $this->db->query($sql);
	}


	public function save($data, $id = null)
	{

		if (!isset($data['alias']) || !isset($data['title']) || !isset($data['description'])) {
			return false;
		}
		$id = (int)$id;
		$alias = $this->db->escape($data['alias']);
		$title = $this->db->escape($data['title']);
		$photo = $title.'.jpg';
		$price = $this->db->escape($data['price']);
		$description = $this->db->escape($data['description']);
		$category = $this->db->escape($data['category']);
		$rate = $this->db->escape($data['rate']);
		$is_active = isset($data['is_active']) ? 1 : 0;

		if (!$id) {//Add new record;
			$sql = "
				insert into products
					set alias = '{$alias}',
			  		 	title = '{$title}',
			  		 	photo = '{$photo}',
			  		 	price = '{$price}',
				  	 	description = '{$description}',
				  	 	category = '{$category}',
				  	 	rate = '{$rate}',
				  	 	is_active = '{$is_active}'
			";
		} else {// Update exsisting record;
			$sql = "
				update products  
					set alias = '{$alias}',
			  		 	title = '{$title}',
				  	 	photo = '{$photo}',
			  		 	price = '{$price}',
				  	 	description = '{$description}',
				  	 	category = '{$category}',
				  	 	rate = '{$rate}',
				  	 	is_active = '{$is_active}'
				  	WHERE id = {$id}
			";
		}
		return $this->db->query($sql);
	}

	public function delete($id)
	{
		$id = (int)$id;
		$sql = "delete from products where id = {$id}";
		return $this->db->query($sql);
	}

	public function showNotActive(){
		$sql = "select * from products where is_active = '0'";
		return $this->db->query($sql);
	}

	public function image(){
		if (isset($_FILES['pic']['name'])) {

			$file_name = $_FILES['pic']['name'];
			$filetype = substr($file_name, strlen($file_name) - 3);
			if ($filetype == "jpg" ||
				$filetype == "jpeg" ||
				$filetype == "gif" ||
				$filetype == "bmp" ||
				$filetype == "png"
			) {
				if ($_FILES['pic']['size'] != 0
					AND $_FILES['pic']['size'] <= 819200
				) {
					echo $_FILES['pic']['tmp_name'];
					if (is_uploaded_file($_FILES['pic']['tmp_name'])) {

						if (move_uploaded_file($_FILES['pic']['tmp_name'],
							'img'.DS.  $_POST['title'].'.jpg')) {

							echo 'Файл ' . basename($_FILES['pic']['name']) .
								' был успешно загружен в ';
						} else {
							echo basename($_FILES['pic']['name']) . " NOT!";
						}
					}
				}
			}
		}

	}
}