<?php

class User extends Model
{


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
		return md5(Config::get('salt').$password);
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


//todo добавить регистрацию и авторизацию