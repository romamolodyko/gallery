<?php
	include "controller.php";
	$img_name = new OutImg;
	//$id_im = new OutId;
	if (!empty($_GET["page"])){
		$pages=$_GET["page"];}
	else{
		$pages = 1;}//// Узнаём номер страницы 
	$count = 6;// Количество записей на странице
	
	$shift = $count * ($pages-1);// Смещение в LIMIT. Те записи, порядковый номер которого больше этого числа, будут выводиться.
	$name = $img_name->out_in_db($shift, $count);
?>