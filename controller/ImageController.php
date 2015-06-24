<?php
	
	//Класс для работы с изображениями
	class ImageController extends Controller{

		public $defaultAction = 'save';

		public function saveAction(){

			if($this->request->isFile()){

				$ds = DIRECTORY_SEPARATOR;
				$uploadDirFull = App::get('base_path').'image'.$ds.'full'.$ds;
				$uploadDirSmall= App::get('base_path').'image'.$ds.'small'.$ds;

				$file = $this->request->getParamFile('file');
				$format = Helper::getFormatFile($file);

				$size = getimagesize($file['tmp_name']);
				list($widthImage,$heightImage) = $size;
				$factor = App::get('width_thumbs') / $widthImage;

				$uniqId = uniqid();
				$newFileName = $uniqId.'.'.$format;
				
				$comment = '';
				if($this->request->isPost()){
					$comment = $this->request->get('comment');
				}

				$this->ensure($file,$format,$comment);

				if(!move_uploaded_file(
					$file['tmp_name'],
					$uploadDirFull.$newFileName
				)){
					throw new Exception("Изображение не сохранилось");
				}

				//Делаем мини копию изображения
				if(!Helper::img_resize(
					$uploadDirFull.$newFileName,
					$uploadDirSmall.$newFileName,
					App::get('width_thumbs'),
					(int)($heightImage*$factor),
					60
				)){
					throw new Exception("Изображение не сохранилось");
				}

				$this->saveDb($newFileName,$file['size'],time(),$comment);
				echo "Файл успешно загружен";
			}else{
				throw new Exception("Не обнаружено изображение");
			}
		}

		//Проверка данных
		public function ensure($file,$format,$comment){

			if($file['size'] >1024*1024){
				throw new Exception("Изображение больше 1мб");
			}

			if(($format != 'png')&&($format != 'jpg')&&($format != 'jpeg')){
				throw new Exception("Неверный формат изображение");
			}

			if($file['size'] >1024*1024){
				throw new Exception("Изображение больше 1мб");
			}

			if(strlen($comment)>200){
				throw new Exception("Комментарий должен быть не больше 200 символов");
			}
		}

		//Вывести картинки по критерию, и обернуть в представление
		public function getAction(){
			$str = '';
			$obj = $this->selectAll(
						$this->request->get('from'),
						$this->request->get('to'),
						$this->request->get('type'),
						$this->request->get('asc')
					);
			foreach($obj as $k=>$v){
				$str .= $this->render('main.item',['item'=>$v],false,false);
			}
			echo $str;
		}

		//Сохранить информацию о картинке
		function saveDb($name,$size,$ts,$comment){
			$STH = Model::getDBHandler()->prepare("INSERT INTO tbl_image (name,size,ts,comment)
												values (:name,:size,:ts,:comment)");
			if($STH->execute([':name'=>$name,':size'=>(int)$size,':ts'=>(int)$ts,':comment'=>$comment])){
				return true;
			}else{
				return false;
			}
		}

		function saveCommentAction(){
			$id = $this->request->get('id');
			$comment = $this->request->get('comment');
			$STH = Model::getDBHandler()->prepare("UPDATE tbl_image SET comment = :comment WHERE id = :id");
			if($STH->execute([':id'=>$id,':comment'=>$comment])){
				echo 'true';
			}else{
				echo 'false';
			}
		}

		//Вывести строки по критерию
		function selectAll($from,$to,$type,$asc){
			$asc = $asc ? 'ASC' : 'DESC';
			$STH = Model::getDBHandler()->prepare("SELECT tbl_image.* FROM tbl_image ORDER BY $type $asc LIMIT $from,$to");
			$STH->execute();
			$STH->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'tbl_image');  
			return Model::fetchAndGetObj($STH);
		}

		//Колличество строк в таблице
		function countAction(){
			$STH = Model::getDBHandler()->prepare("SELECT count(*) FROM `tbl_image`");
			$STH->execute();
			echo $STH->fetchColumn();
		}
	}