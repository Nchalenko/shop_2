<?php

Config::set('site_name', 'Alex.shop');

Config::set('languages', array('en', 'fr'));

//Routes. Rout name => method prefix

Config::set('routes', array(
	'default' => '',
	'admin' => 'admin_',
));

Config::set('default_route', 'default');
Config::set('default_language', 'en');
Config::set('default_controller', 'products');
Config::set('default_action', 'index');

Config::set('db.host', 'localhost');
Config::set('db.user', 'root');
Config::set('db.password', '112233');
Config::set('db.db_name', 'alex.shop');

Config::set('salt', 'g347835ghr885hjr');
