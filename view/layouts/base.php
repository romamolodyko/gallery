<!doctype html>
<html lang="en">
<head>
  
  <meta charset="utf-8" />
  <title><?=App::get('app_name')?></title>
  
  <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

  <script src="<?=App::get('prefix')?>/public/js/jquery-1.7.1.min.js"></script>
  <script src="<?=App::get('prefix')?>/public/js/jquery.isotope.min.js"></script>
  <script src="<?=App::get('prefix')?>/public/js/jquery.ba-bbq.min.js"></script>

  <!--
    <script type="text/javascript" src="<?=App::get('prefix')?>/public/js/lightbox.js"></script>
    <link type="text/css" rel="stylesheet" href="<?=App::get('prefix')?>/public/css/lightbox.css">
-->
  <script type="text/javascript" src="<?=App::get('prefix')?>/public/js/mylightbox.js"></script>
  <script type="text/javascript" src="<?=App::get('prefix')?>/public/js/dmuploader.min.js"></script>
  <script type="text/javascript" src="<?=App::get('prefix')?>/public/js/jquery.reveal.js"></script> 
  <script type="text/javascript" src="<?=App::get('prefix')?>/public/js/jquery.jscroll.min.js"></script>
  <script type="text/javascript" src="<?=App::get('prefix')?>/public/js/jquery.form.min.js"></script>
  <script type="text/javascript" src="<?=App::get('prefix')?>/public/js/jquery.fancybox.js"></script>
  <script type="text/javascript" src="<?=App::get('prefix')?>/public/js/main.js"></script>


  <link type="text/css" rel="stylesheet" href="<?=App::get('prefix')?>/public/css/style.css">
  <link type="text/css" rel="stylesheet" href="<?=App::get('prefix')?>/public/css/reveal.css">
  <link type="text/css" rel="stylesheet" href="<?=App::get('prefix')?>/public/css/fancybox/jquery.fancybox.css">
  <script>
  	window.prefix = '<?=App::get("prefix")?>';
  </script>
</head>
<body>
<div class="site">
<header>
    <ul>
        <li><a href="<?=App::get("prefix")?>">Gallery</a></li>
        <li><a href="<?=App::get("prefix")?>?controller=upload">Upload file</a></li>
    </ul>
</header>
	<?=$content?>
<div id ="eclipse">
</div>
<div id = "img"></div>

    <footer></footer>
</div>
</body>
</html>