<!doctype html>
<html lang="en">
<head>
  
  <meta charset="utf-8" />
  <title><?=App::get('app_name')?></title>
  
  <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

  <script src="/public/js/jquery-1.7.1.min.js"></script>
  <script src="/public/js/jquery.isotope.min.js"></script>
  <script src="/public/js/jquery.ba-bbq.min.js"></script>
  <script type="text/javascript" src="/public/js/dmuploader.min.js"></script>
  <script type="text/javascript" src="/public/js/jquery.reveal.js"></script> 
  <script type="text/javascript" src="/public/js/jquery.jscroll.min.js"></script>
  <script type="text/javascript" src="/public/js/jquery.form.min.js"></script>
  <script type="text/javascript" src="/public/js/jquery.fancybox.js"></script>
  <script type="text/javascript" src="/public/js/main.js"></script>

  <link type="text/css" rel="stylesheet" href="/public/css/style.css">
  <link type="text/css" rel="stylesheet" href="/public/css/reveal.css">
  <link type="text/css" rel="stylesheet" href="/public/css/fancybox/jquery.fancybox.css">
</head>
<body>
<div class="header option-set">
	<div>
		<div class="title-app">Gallery</div>
		<div class="btns">
		<div class="sort-date"><a href="#sortBy=date">Дата загрузки</a></div>
		<div class="sort-size"><a href="#sortBy=size">Размер файла</a></div>
		<div class="upload-image">
			<a href="#" data-reveal-id="myModal" data-animation="fadeAndPop" 
				data-animationspeed="300" data-closeonbackgroundclick="true" 
				data-dismissmodalclass="close-reveal-modal">
					Загрузить изображение
			</a>
		</div>
		</div>
	</div>
</div>
<div id="myModal" class="reveal-modal">
	<h1>Загрузить изображение</h1>

	<div id='preview' style="text-align: center;padding: 10px;">
	</div>
	<form id="send_file_form" method="post" enctype="multipart/form-data" action='?controller=image&action=save' style="clear:both">

		<div id='imageloadstatus' style='display:none;text-align: center;margin-top: 10px;'>
		<div>Подождите файл загружается</div>
		<div style="margin-top: 10px;text-align: center;"><img src="public/img/loader.gif" alt="Uploading...." style="margin: auto;border: 1px solid #D8D8D8;" /></div>

		</div>

		<div id='imageloadbutton' style="text-align: center;margin-top: 15px;">
		<input type="file" name="file" id="file_input"/>
		<div class="textarea">
			<textarea name="comment"></textarea>
		</div>
		<div style="text-align: center;margin-top: 15px;"><input type="button" id="sendfile" class="btn" value="Загрузить файл"></div>
		</div>

	</form>
     <a class="close-reveal-modal">&#215;</a>
</div>
	
	<?=$content?>

</body>
</html>