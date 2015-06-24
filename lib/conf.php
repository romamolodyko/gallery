<?php

	return [
			'path_init_db'=>'mysql:host=localhost;dbname=gallery',
			'user_db'=>'root',
			'password_db'=>'muha1990',
			'app_name'=>'Gallery',
			'default_controller'=>'init',
			'base_path'=>$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR,
			'include_path'=>['lib','controller','model','component'], //В каких дирректориях искать классы
			'width_thumbs'=>200,
		];