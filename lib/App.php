<?php

	//Клас для доступа к конфигурационным параметрам
	class App{

		static private $instance = null;

		private $params = [];

		private function __construct(){}

		static function getInstance(){
			if(!self::$instance)
				self::$instance = new self();
			return self::$instance;
		}

		static function get($k){
			$o = self::getInstance();
			if(isset($o->params[$k])){
				return $o->params[$k];
			}
			throw new Exception("Неопределенная переменная {$k}");
		}

		function init(){
			//Подключаем файл конфигурации
			$params = include_once('conf.php');
			$this->params = $params;
		}
	}