<?php
	
	class InitController extends Controller{

		public $defaultAction = 'show';

		public function showAction(){

			$str = '';
			foreach ($this->selectAll(0,4) as $k=>$v){
				$str .= $this->render('main.item',['item'=>$v],false,false);
			}
			$this->render('main.content',['images'=>$str]);
		}


		public function moreAction(){
			$str = '<div class="onload">';
			foreach ($this->selectAll($this->request->get('from'),$this->request->get('to')) as $k=>$v){
				$str .= $this->render('main.item',['item'=>$v],false,false);
			}
			echo $str."</div><script>loadItems()</script>";
		}

		function selectAll($from,$to){
			$STH = Model::getDBHandler()->prepare("SELECT tbl_image.* FROM tbl_image LIMIT $from,$to");
			$STH->execute();
			$STH->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'tbl_image');  
			return $this->fetchAndGetObj($STH);
		}

		function fetchAndGetObj($STH){
			$mw = [];
			while($obj = $STH->fetch()){
				$mw[] = $obj;
			}
			return $mw;
		}
	}