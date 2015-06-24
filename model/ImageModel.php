<?php 

	class ImageModel extends Model{

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

		function saveComment($id,$comment){
			$STH = Model::getDBHandler()->prepare("UPDATE tbl_image SET comment = :comment WHERE id = :id");
			if($STH->execute([':id'=>$id,':comment'=>$comment])){
				return true;
			}else{
				return false;
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
		function count(){
			$STH = Model::getDBHandler()->prepare("SELECT count(*) FROM `tbl_image`");
			$STH->execute();
			return $STH->fetchColumn();
		}

		//Колличество строк в таблице
		function remove($id){
			$STH = self::getDBHandler()->prepare("DELETE FROM tbl_image WHERE id = :id");
			return $STH->execute([':id'=>$id]);
		}

	}