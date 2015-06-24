<?php

	return [
			'path_init_db'=>'mysql:host=localhost;dbname=',
			'user_db'=>'',
			'password_db'=>'',
			'app_name'=>'Gallery',
			'default_controller'=>'init',
			'base_path'=>$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'gallery'.DIRECTORY_SEPARATOR,
			'prefix'=>'/gallery',
			'include_path'=>['lib','controller','model','component'], //В каких дирректориях искать классы
			'width_thumbs'=>200,
		];