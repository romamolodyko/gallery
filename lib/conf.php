<?php

	return [
			'path_init_db'=>'mysql:host=localhost;dbname=gallery',
			'user_db'=>'root',
			'password_db'=>'',
			'app_name'=>'Gallery',
			'default_controller'=>'image',
			'base_path'=>$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'gallery'.DIRECTORY_SEPARATOR,
			'prefix'=>'/gallery',
			'include_path'=>['lib','controller','model','component'], //В каких дирректориях искать классы
			'width_thumbs'=>200,

			// User parameters
			'count_of_page'=>6, // Is the count of images on the one page
			'uploads_dir_original' => 'uploads'.DIRECTORY_SEPARATOR.'original',
			'uploads_dir_small' => 'uploads'.DIRECTORY_SEPARATOR.'small'

];