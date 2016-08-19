<?php


class Lang
{
	protected static $data;

	public static function load($lang_code){
		$lang_code_path = ROOT.DS.'lang'.DS.strtolower($lang_code).'.php';

		if (file_exists($lang_code_path)){
			self::$data = include ($lang_code_path);
			}else{
				throw new Exception('Lang file not found: '.$lang_code_path);
		}
	}

	public static function get($key, $default_value){
		return isset(self::$data[strtolower($key)]) ? self::$data[strtolower($key)] : $default_value;
	}

}
