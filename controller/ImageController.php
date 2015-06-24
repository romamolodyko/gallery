<?php
	
	//Класс для работы с изображениями
	class ImageController extends Controller{

		public $defaultAction = 'save';

		public function __construct($request){
			parent::__construct($request);
			$this->model = new ImageModel();
		}

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

				$this->model->saveDb($newFileName,$file['size'],time(),$comment);
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

		function removeAction(){
			$id = $this->request->get('id');
			$name = $this->request->get('name');
			if($this->model->remove($id)){

				$ds = DIRECTORY_SEPARATOR;
				$uploadDirFull = App::get('base_path').'image'.$ds.'full'.$ds;
				$uploadDirSmall= App::get('base_path').'image'.$ds.'small'.$ds;

				unlink($uploadDirFull.$name);
				unlink($uploadDirSmall.$name);

				echo 'true';
			}else{
				echo 'false';
			}
		}

		//Вывести картинки по критерию, и обернуть в представление
		public function getAction(){
			$str = '';
			$obj = $this->model->selectAll(
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

		function saveCommentAction(){
			$id = $this->request->get('id');
			$comment = $this->request->get('comment');
			if($this->model->saveComment($id,$comment)){
				echo 'true';
			}else{
				echo 'false';
			}
		}

		//Колличество строк в таблице
		function countAction(){
			echo $this->model->count();
		}
	}