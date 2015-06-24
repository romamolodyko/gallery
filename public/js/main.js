$(function(){

	var $container = $('#container');

	//Хранится тип сортировки для отправки на сервер
	var sortType = {'type':'ts','asc':true};

	$(".sort-date").click(function(){
		$('.next').off('click');
		$container.empty();
		sortType = {'type':'ts','asc':true};
		addNextBlock.first = true;
		addNextBlock();
		$('.next').click();
	});
	$(".sort-size").click(function(){
		$('.next').off('click');
		$container.empty();
		sortType = {'type':'size','asc':true};
		addNextBlock.first = true;
		addNextBlock();
		$('.next').click();
	});

	addNextBlock.first = true;
	addNextBlock();

	//Открыть следующую группу картинок
	function addNextBlock(){
		$.ajax({
			url: '/?controller=image&action=count',
		}).done(function(response){

			var countItemsInTable = parseInt(response);
			var countItemsInPage = $container.find('div').length;
			console.log(countItemsInPage,sortType);
			var dif = countItemsInTable - countItemsInPage;

			//Если на странице не все картинки
			if(dif > 0){
				$('.next').css('display','block');
				var from = countItemsInPage;
				var to = 25;
				$('.next').off('click');
				$('.next').click(update);
				function update(){
					$.ajax({
						url: '/?controller=image&action=get&from='+from+'&to='+to,
						data: sortType,
					}).done(function(response){
						$(response).each(function(i,e){
							var id = parseInt($(this).attr('data-id'));
							if(!$container.find('.item[data-id='+id+']').attr('class'))
								$container.append(e);
						})
						addNextBlock();
					});
				}
				if(addNextBlock.first){
					addNextBlock.first = false;
					$('.next').click();
				}
			}else{
				//$('.next').off('click');
				$('.next').css('display','none');
			}
		});
	}

	//lightbox на изображения
	$(".fancybox").fancybox({
		openEffect	: 'none',
		closeEffect	: 'none',
		helpers : {
			title : {
				type : 'inside'
			}
		},
		afterLoad: function(e){
			console.log('dd');
			var item = $(e.element).parent();
			var id = item.attr('data-id');
			var name =item.attr('data-name');
			var ts = item.attr('data-ts');
			$('.mdata').text(ts);
			$('.mremove').off('click');
			$('.mremove').click(function(){
				$.ajax({
					url: '/?controller=image&action=remove',
					data:{id:id,name:name}
				}).done(function(response){
					console.log(response);
					item.remove();
					$('.fancybox-close').click();
				});
			});
		}
	});

	$(".fancybox-title").live('click',editComment);

	function editComment(e){
		var elem = $(e.target);

		if(elem.attr('class') !== 'fancybox-title fancybox-title-inside-wrap') return;
		if(elem.find('button').attr('class')) return;

		var text = elem.text();
		elem.text('');
		if(text == 'Добавить комментарий')
			text = '';

		elem.append('<input type="text" value="'+text+'""><button class="btn-hidden">&nbsp;</button>');
		var input = elem.find('input');
		input.focus();

		elem.find('button').off('click');

		//Сохраняем комент
		elem.find('button').click(function(e){
			var newText = elem.find('input').val(); 
			if(newText != '')
			if(newText != text){
				var id = elem.parents('.fancybox-skin').find('.fancybox-image').attr('src').split('=')[1];
				$.ajax({
					url: '/?controller=image&action=savecomment',
					data:{id:id,comment:newText}
				}).done(function(response){
					$('.item[data-id='+id+']').find('a').attr('title',newText);
					elem.text(input.val());
				});
			}
		});
	}

	//Ставим обработчики на загрузку изображения
	$('#sendfile').click(function(){
		var A=$("#imageloadstatus");
		var B=$("#imageloadbutton");
		$("#send_file_form").ajaxForm({target: '#preview',
		    beforeSubmit:function(){
		        A.show();
		        B.hide();
		    },
		    success:function(){
		        A.hide();
		        B.show();

		        //Рисуем добавленное изображение
		        $('.next').click();
		        $("#myModal").find('form')[0].reset();
		    },
		    error:function(){
		        A.hide();
		        B.show();
		    }
		}).submit();
	});
});
