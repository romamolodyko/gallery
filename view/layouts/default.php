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

  <link type="text/css" rel="stylesheet" href="/public/css/style.css">
    <link type="text/css" rel="stylesheet" href="/public/css/reveal.css">
</head>
<body>
<div class="header option-set">
	<div class="title-app">Gallery</div>
	<div class="sort-date"><a href="#sortBy=date">date</a></div>
	<div class="sort-size"><a href="#sortBy=size">size</a></div>
	<div class="upload-image">
		<a href="#" data-reveal-id="myModal" data-animation="fadeAndPop" 
			data-animationspeed="300" data-closeonbackgroundclick="true" 
			data-dismissmodalclass="close-reveal-modal">
				Загрузить изображение
		</a>
</div>
</div>
<div id="myModal" class="reveal-modal">
	<h1>Загрузить изображение</h1>
	<div id="drag-and-drop-zone" class="uploader">
		<label>
			<div>Drag &amp; Drop Images Here</div>
			<input type="file" name="files[]" multiple="multiple" title="Click to add Files">
		</label>
	</div>

	<div id="fileList">
	</div>
     <a class="close-reveal-modal">&#215;</a>
</div>

<?=$content?>

  <script>

    $(function(){
  	
		var $container = $('#container');
		$container.isotope({
			itemSelector: '.element',
			layoutMode: 'masonry',
			masonry : {
	          columnWidth : 200
	        },
			sortAscending: true,
			itemPositionDataEnabled: true,
			sortBy: 'original-order',
			getSortData : {
	          date : function( elem ) {
	            return $(elem).attr('data-date');
	          },
	          size: function( elem ) {
	            return $(elem).attr('data-size');
	          }
	        }
		});

		function addNextBlock(){
			$.ajax({
				url: '/?controller=image&action=count',
			}).done(function(response){
				var countItemsInTable = parseInt(response);
				var countItemsInPage = $container.find('div').length;
				console.log(countItemsInPage);
				var dif = countItemsInTable - countItemsInPage;
				if(dif > 0){
					var from = countItemsInPage;
					var to = 4;
					$('.next').off('click');
					$('.next').click(function(){
						console.log('/?controller=init&action=more&from='+from+'&to='+to);
						$.ajax({
							url: '/?controller=init&action=more&from='+from+'&to='+to,
						}).done(function(response){
							$(response).each(function(i,v){
								$container.isotope('insert',$(v));
								$container.isotope(currentSort);
							}).remove();
							//console.log(currentSort);
							$container.isotope(currentSort);
							$container.isotope( 'once', 'arrangeComplete',addNextBlock);
						});
					});
				}else{
					$('.next').off('click');
					$('.next').remove();
				}
			});
		}

		var ascending = {size:true,date:true};
		var currentSort = {};
		$('.option-set').find('a').click(function(){
			var $this = $(this);
			var href = $this.attr('href').replace( /^#/, '' ).split('=');
			var o = {};
			o[href[0]] = href[1];
			o['sortAscending'] = ascending[href[1]] = !ascending[href[1]];
			currentSort = o;
			$container.isotope(o);
		});

		addNextBlock();
    });
  </script>
<script type="text/javascript">

      function add_file(id, file){
        var template = '' +
          '<div class="file" id="uploadFile' + id + '">' +
            '<div class="info">' +
              '#'+(id + 1)+' - <span class="filename" title="Size: ' + file.size + 'bytes - Mimetype: ' + file.type + '">' + file.name + '</span><br /><small>Status: <span class="status">Waiting</span></small>' +
            '</div>' +
            '<div class="bar">' +
              '<div class="progress" style="width:0%"></div>' +
            '</div>' +
          '</div>';
          
          $('#fileList').prepend(template);
      }
      
      function update_file_status(id, status, message)
      {
        $('#uploadFile' + id).find('span.status').html(message).addClass(status);
      }
      
      function update_file_progress(id, percent)
      {
        $('#uploadFile' + id).find('div.progress').width(percent);
      }
      function add_log(t){
      	console.log(t);
      }
      // Upload Plugin itself
      $('#drag-and-drop-zone').dmUploader({
        url: '/?controller=image',
        dataType: 'json',
        allowedTypes: 'image/*',
        onInit: function(){
          add_log('Penguin initialized :)');
        },
        onBeforeUpload: function(id){
          add_log('Starting the upload of #' + id);
          
          update_file_status(id, 'uploading', 'Uploading...');
        },
        onNewFile: function(id, file){
          add_log('New file added to queue #' + id);
          
          add_file(id, file);
        },
        onComplete: function(){
          add_log('All pending tranfers finished');
        },
        onUploadProgress: function(id, percent){
          var percentStr = percent + '%';

          update_file_progress(id, percentStr);
        },
        onUploadSuccess: function(id, data){
          add_log('Upload of file #' + id + ' completed');
          
          add_log('Server Response for file #' + id + ': ' + JSON.stringify(data));
          
          update_file_status(id, 'success', 'Upload Complete');
          
          update_file_progress(id, '100%');
        },
        onUploadError: function(id, message){
          add_log('Failed to Upload file #' + id + ': ' + message);
          
          update_file_status(id, 'error', message);
        },
        onFileTypeError: function(file){
          add_log('File \'' + file.name + '\' cannot be added: must be an image');
          
        },
        onFileSizeError: function(file){
          add_log('File \'' + file.name + '\' cannot be added: size excess limit');
        },
        onFallbackMode: function(message){
          alert('Browser not supported(do something else here!): ' + message);
        }
      });



    </script>
</body>
</html>