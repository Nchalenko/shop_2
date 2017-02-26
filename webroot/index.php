<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('VIEWS_PATH', ROOT . DS . 'views');
define('IMG_PATH', DS . 'img');
define('MAIN', DS);

require_once(ROOT . DS . 'lib' . DS . 'init.php');

require_once ROOT.DS. 'webroot' . DS .'vendor'.DS.'autoload.php';

session_start();

App::run($_SERVER['REQUEST_URI']);

