<?php 

	class ImageModel extends Model{

		//Сохранить информацию о картинке
		function saveDb($name,$ts,$comment){
			$STH = Model::getDBHandler()->prepare("INSERT INTO image (image_name,date,comments)
												values (:name,:ts,:comment)");
			if($STH->execute([':name'=>$name,':ts'=>(int)$ts,':comment'=>$comment])){
				return true;
			}else{
				return false;
			}
		}

		function saveComment($id,$comment){
			$STH = Model::getDBHandler()->prepare("UPDATE tbl_image SET comment = :comment WHERE id = :id");
			if($STH->execute([':id'=>$id,':comment'=>$comment])){
				return true;
			}else{
				return false;
			}
		}

		//Вывести строки по критерию
		function selectAll($from,$to){
			//$asc = $asc ? 'ASC' : 'DESC';
			$STH = Model::getDBHandler()->prepare("SELECT * FROM image LIMIT $from,$to");
			$STH->execute();
			$STH->setFetchMode(PDO::FETCH_ASSOC);
			return Model::fetchAndGetObj($STH);
		}

		//Колличество строк в таблице
		function count(){
			$STH = Model::getDBHandler()->prepare("SELECT count(*) FROM image");
			$STH->execute();
			return $STH->fetchColumn();
		}

		//Колличество строк в таблице
		function remove($id){
			$STH = self::getDBHandler()->prepare("DELETE FROM tbl_image WHERE id = :id");
			return $STH->execute([':id'=>$id]);
		}

	}