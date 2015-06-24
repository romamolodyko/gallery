<div class="item" data-id="<?=$data['item']['id']?>" data-name="<?=$data['item']['name']?>" data-ts="<?=date("d.m.Y H:i:s",$data['item']['ts'])?>">
  <a class="fancybox" rel="gallery1" href="<?=App::get('prefix')?>/image/full/<?=$data['item']['name']?>#id=<?=$data['item']['id']?>" 
  	title="<?=!$data['item']['comment']?'Добавить комментарий':$data['item']['comment']?>">
	<img src="<?=App::get('prefix')?>/image/small/<?=$data['item']['name']?>" >
  </a>
</div>