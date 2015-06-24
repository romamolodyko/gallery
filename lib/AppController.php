<?php
	require_once('App.php');

	//Класс входа в приложение
	class AppController{

		private static $instance = null;

		private function __constract(){}

		public static function getInstance(){
			if(empty(self::$instance))
				self::$instance = new self();
			return self::$instance;
		}

		//Запуск приложения
		public static function run(){
			$inst = self::getInstance();
			$inst->init();
			$inst->process();
		}

		//Инициализая 
		public function init(){
			$app = App::getInstance();
			$app->init();

			//Устанавливаем метод который будет подключать не подключенные классы
			spl_autoload_register(array('AppController','autoload_callback'));
		}

		//Подгружаем классы в случае необходимости
		static function autoload_callback($class_name){
			foreach(App::get('include_path') as $v){
				$pathToClass = App::get('base_path').$v.DIRECTORY_SEPARATOR.$class_name.'.php';
				if(file_exists($pathToClass)){
					require_once($pathToClass);
				}
			}
		}

		//Запускаем контроллер
		public function process(){
			try{
				$request = new Request();
				$action = ControllerFactory::runAction($request);
			}catch(Exception $e){
				echo '<strong>Произошла непредвиденная ошибка!</strong>'.$e->getMessage();
			}
		}
	}