<?php

	//Класс для работы с запросом
	class Request{

		private $returnUrl;

		private $params;

		private $file;

		private $feedBack;

		function __construct(){
			$this->isGet = !empty($_GET);
			$this->isPost = !empty($_POST);
			$this->isFile = !empty($_FILES);
			$this->params = array_merge($_GET,$_POST);
			$this->file = isset($_FILES)?$_FILES:null;
			$this->returnUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
		}

		public function get($k){
			if(isset($this->params[$k]))
				return $this->params[$k];
			return null;
		}

		public function set($k,$v){
			return $this->params[$k] = $v;
		}

		public function isGet(){
			return $this->isGet;
		}

		public function isPost(){
			return $this->isPost;
		}

		public function isFile(){
			return !empty($this->file);
		}

		public function returnUrl(){
			return $this->returnUrl;
		}

		public function getParamFile($k){
			if(isset($this->file[$k]))
				return $this->file[$k];
			return null;
		}

		public function setFeedBack($str){
			$this->feedBack = $str;
		}

		public function getFeedBack(){
			return $this->feedBack;
		}

		//Добавить массив зачений
		public function addProp(array $data){
			$this->params = array_merge($data,$this->params);
		}
	}