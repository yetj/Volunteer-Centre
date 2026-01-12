<?php

class VC {
	private static $config = null;
	private static $db = null;

	/**
	 * Get app config
	 */
	public static function config() {
		if(is_null(self::$config)) {
			self::$config = (object) parse_ini_file(ROOT . 'app/config/settings.ini');
		}

		return self::$config;
	}
	
	/**
	 * Get db access
	 */
	public static function db() {
		if(is_null(self::$db)) {
			try {
				self::$db = new PDO(
					'mysql:host=' . self::config()->db_host . ';dbname=' . self::config()->db_db . ';charset=utf8',
					'' . self::config()->db_user . '',
					'' . self::config()->db_password . '', [
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
					]
				);
			}
			catch (Exception $e) {
				echo 'Wystąpił problem podczas łączenia się z bazą danych.';
				die();
			}
		}
		
		return self::$db;
	}
	
	/**
	 * Load all needed classes
	 */
	public static function loadClasses() {
		spl_autoload_extensions('.php');
		spl_autoload_register(function($class_name){
			$dirs = [
				ROOT . '/app/includes/mvc/',
				ROOT . '/app/models/',
				ROOT . '/app/controllers/admin/',
				ROOT . '/app/controllers/public/',
				ROOT . '/app/view/',
				ROOT . '/libs/',
			];
			
			foreach( $dirs as $dir ) {
				if (file_exists($dir.$class_name.'.php')) {
					require_once($dir.$class_name.'.php');
					return;
				}
			}
		});
	}
}