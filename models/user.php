<?php

class User extends Model
{

	public function emailExcist($email)
	{
		$email = $this->db->escape($email);
		$sql = "select email from users where `email` = '{$email}'";
		$result = $this->db->query($sql);
		if ($result[0]['email'] == $email) {
			$result = false;
		}
		return $result;
	}

	public function getByLogin($login)
	{
		$login = $this->db->escape($login);
		$sql = "select * from users where login = '{$login}' limit 1";
		$result = $this->db->query($sql);
		if (isset($result[0])) {
			return $result[0];
		}
		return false;
	}


	public function isLoggedIn()
	{
		if (isset($_SESSION['login'])) {
			return $_SESSION['login'];
		} else {
			return false;
		}
	}

	public function getHashFromPassword($password)
	{
		return md5(Config::get('salt') . $password);
	}

	public function register($data)
	{
		if (!isset($data['login']) || !isset($data['password']) || !isset($data['password2']) || !isset($data['email'])) {
			return false;
		}


		if ($data['password'] !== $data['password2']) {
			return false;
		}
		$login = $data['login'];
		$password = $data['password'];
		$email = $data['email'];

		if ($this->emailExcist($email) == false) {
			Session::setFlash('Пользователь с такой електронной почтой уже существует!');
			return false;
		}

		if (strlen($login) < 4) {
			Session::setFlash('Логин должен быть больше 4 символов!');
			return false;
		}

		if (strlen($password < 6)) {
			Session::setFlash('Пароль должен быть больше 6 символов!');
			return false;
		}

		$hash = self::getHashFromPassword($password);

		$sql = "
            insert into users
               set login = '{$login}',
               	   email = '{$email}',
                   role = 'user',
                   password = '{$hash}'
        ";
		try {
			$this->db->query($sql);
		} catch (Exception $e) {
			echo "Не получилось вас зарегать МУХАХАХАХХАХА<br>";
			return false;
		}

		return $this->db->insertId();
	}

}