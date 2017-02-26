<?php

class User extends Model
{

    public function emailExcist($email)
    {
        $sql = "select email from users where email = '{$email}'";
        $result = $this->db->query($sql);

        if (isset($result[0]['email'])) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    public function loginExcist($login)
    {
        $sql = "select login from users where login = '{$login}'";
        $result = $this->db->query($sql);

        if (isset($result[0]['login'])) {
            $result = false;
        } else {
            $result = true;
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
        if (isset($data['login']) && isset($data['password']) && isset($data['password2']) && isset($data['email'])) {
            if ($data['password'] !== $data['password2']) {
                Session::setFlash('Пароли не совпадают');
                return false;
            }

            $login = $this->db->escape($data['login']);
            $password = $this->db->escape($data['password']);
            $email = $this->db->escape($data['email']);

            if ($this->emailExcist($email) == false) {
                Session::setFlash('Пользователь с такой електронной почтой уже существует!');
                return false;
            }

            if ($this->loginExcist($login) == false) {
                Session::setFlash('Пользователь с таким логином уже существует!');
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
                echo "Что-то пошло, не так, попробуйте еще раз<br>";
                return false;
            }

            return $this->db->insertId();

        } else {
            Session::setFlash('Заполните все необходимые поля для регистрации');
            return false;
        }
    }
}