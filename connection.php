<?php
	/**
	* Se crea la conexión a la base de datos
	* Autor: Carmen Moreno de Vega
	*/
	class Db {
		private static $instance=NULL;
		
		private function __construct() {}

		private function __clone() {}
		
		public static function getConnect() {
			if (!isset(self::$instance)) {
				$pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
				self::$instance= new PDO('mysql:host= ; dbname=','','',$pdo_options);
			}
			return self::$instance;
		}
	}
?>