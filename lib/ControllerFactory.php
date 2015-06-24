<?php

	//Клас для генерации и запуска экземпляра контроллера
	class ControllerFactory{

		static $dirToController = 'controller';

		//Получаем экземпляр контроллера на основании запроса
		static function getController(Request $request){
			$controller = ($request->get('controller')==null) ? App::get('default_controller') : $request->get('controller');
			if(!preg_match('/\W/',$controller)){
				if(!empty($controller)){
					$controller = UCFirst(strtolower($controller)).'Controller';
					$ds = DIRECTORY_SEPARATOR;
					$basePath = self::$dirToController.$ds.$controller.'.php';
					if(file_exists($basePath)){
						require_once($basePath);
						return new $controller($request);
					}
				}
			}
			throw new Exception("Контроллер {$controller} не найден");
		}

		//Запускаем action метод на основании запроса
		static function runAction(Request $request){
			$class = self::getController($request);
			$action = ($request->get('action')==null) ? $class->getDefaultAction() : strtolower($request->get('action')).'Action';
			if(!preg_match('/\W/',$action)){
				if(!empty($action)){
					$ref_class = new ReflectionClass($class);
					$ref_method = $ref_class->getMethod($action);
					if(!empty($ref_method)){
						return $class->$action();
					}
				}
			}
			throw new Exception("Action {$action} не найден");
		}
	}