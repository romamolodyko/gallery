<?php

	//Суперкласс для пользовательских контроллеров
	abstract class Controller{

		protected $request;

		public $layout = 'default';

		public $defaultAction = 'list';

		public $currentUri;


		function __construct(Request $request){
			//Сохраняем ссылку на запрос
			$this->request = $request;
			$this->currentUri = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}

		function getCurrentUri(){
			return $this->currentUri;
		}

		function getDefaultAction(){
			return $this->defaultAction.'Action';
		}

		function getRequest(){
			return $this->request;
		}


		//Вывод представления
		//$view - представление
		//$data - данные для представления
		//$output если true то вывести содержимое представления через echo
		//$output если false то возвратить содержимое представления из данной функции
		function render($view,$data = null,$output = true,$useLayout = true){
			try{
				$ds = DIRECTORY_SEPARATOR;
				$basePath = App::get('base_path').'view';
				$secondPartPath = preg_replace('/\./',$ds,$view);
				$fullPath = $basePath.$ds.$secondPartPath.'.php';
				if(file_exists($fullPath)){
					if($useLayout){
						ob_start();
							include $fullPath;
							$content = ob_get_contents();
						ob_end_clean();
						$pathToLayout = $basePath.$ds.'layouts'.$ds;
						$pathToLayout.= $this->layout.'.php';
						if(!file_exists($pathToLayout)){
							throw new Exception('Не найден макет'.$pathToLayout);
						}
						ob_start();
							include $pathToLayout;
							$return = ob_get_contents();
						ob_end_clean();
						
						if($output){
							echo $return;
						}else{
							return $return;
						}
					}else{
						if($output){
							include $fullPath;
						}else{
							ob_start();
								include $fullPath;
								$include = ob_get_contents();
							ob_end_clean();
							return $include;
						}
					}
				}else{
					throw new Exception('Представления не существует'.$fullPath);
				}
			}catch(Exception $e){
				echo $e->getMessage();
			}
		}

		//Переадресация
		//Если $url массив тогда первый елемент это контроллер второй action
		//Если $url строка то переадресация произойдет по этой строке
		//Если $url null тогда обновить страницу
		public function redirect($url){
			$str = '?';
			if(is_array($url)){
				if(isset($url[0]))
					$str .= 'controller='.$url[0].'&';
				if(isset($url[1]))
					$str .= 'action='.$url[1];
					$str ='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].$str;
			}else if($url){
				$str = $url;
			}else{
				$str = $_SERVER['HTTP_REFERER'];
			}
			if($this->getRequest()->getFeedBack()){
				$str .= '&feedback='.$this->getRequest()->getFeedBack();
			}
			header("Location: ".$str);
		}
	}