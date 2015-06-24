<?php
	
	class ImageController extends Controller{

		public $defaultAction = 'show';

		public function showAction(){
			if($this->request->isFile()){

				$ds = DIRECTORY_SEPARATOR;
				$uploadDirFull = App::get('base_path').'image'.$ds.'full'.$ds;
				$uploadDirSmall= App::get('base_path').'image'.$ds.'small'.$ds;

				$file = $this->request->getParamFile('file');
				$format = $this->getFormatFile($file);

				$size = getimagesize($file['tmp_name']);
				list($widthImage,$heightImage) = $size;
				$factor = App::get('width_thumbs') / $widthImage;

				$uniqId = uniqid();
				$newFileName = $uniqId.'.'.$format;
				
				if(!move_uploaded_file(
					$file['tmp_name'],
					$uploadDirFull.$newFileName
				)){
					throw new Exception("Изображение не сохранилось");
				}

				if(!$this->img_resize(
					$uploadDirFull.$newFileName,
					$uploadDirSmall.$newFileName,
					App::get('width_thumbs'),
					(int)($heightImage*$factor),
					60
				)){
					throw new Exception("Изображение не сохранилось");
				}
				$this->save($newFileName,$file['size'],time());

			}else{
				throw new Exception("Не обнаружено изображение");
			}
		}

		function save($name,$size,$ts){
			$STH = Model::getDBHandler()->prepare("INSERT INTO tbl_image (name,size,ts)
																	values (:name,:size,:ts)");
			if($STH->execute([':name'=>$name,':size'=>(int)$size,':ts'=>(int)$ts])){
				return true;
			}else{
				return false;
			}
		}

		function countAction(){
			$STH = Model::getDBHandler()->prepare("SELECT count(*) FROM `tbl_image`");
			$STH->execute();
			echo $STH->fetchColumn();
		}

		function img_resize($src, $dest, $width, $height, $quality=100, $rgb=0xFFFFFF)
		{
			if (!file_exists($src)) return false;

			$size = getimagesize($src);

			if ($size === false) return false;

			$format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
			$icfunc = "imagecreatefrom" . $format;
			if (!function_exists($icfunc)) return false;

			$x_ratio = $width / $size[0];
			$y_ratio = $height / $size[1];

			$ratio       = min($x_ratio, $y_ratio);
			$use_x_ratio = ($x_ratio == $ratio);

			$new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
			$new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
			$new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
			$new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);

			$isrc = $icfunc($src);
			$idest = imagecreatetruecolor($width, $height);

			imagefill($idest, 0, 0, $rgb);
			imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, 
			$new_width, $new_height, $size[0], $size[1]);

			imagejpeg($idest, $dest, $quality);

			imagedestroy($isrc);
			imagedestroy($idest);

			return true;
		}

		public function getFormatFile($file){
			$size = getimagesize($file['tmp_name']);
			$format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
			return $format;
		}
	}