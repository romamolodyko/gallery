<?php

class Model{

	//Получаем PDO объект
	static public function getDBHandler(){
		try{
			$DBH = new PDO(App::get('path_init_db'),App::get('user_db'),App::get('password_db'));
			$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			return $DBH;
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}

	//Розпарсить ответ
	static public function fetchAndGetObj($STH){
		$mw = [];
		while($obj = $STH->fetch()){
			$mw[] = $obj;
		}
		return $mw;
	}
}