<div class="item" data-id="<?=$data['item']['id']?>">
  <a class="fancybox" rel="gallery1" href="/image/full/<?=$data['item']['name']?>#id=<?=$data['item']['id']?>" 
  	title="<?=!$data['item']['comment']?'Добавить комментарий':$data['item']['comment']?>">
	<img src="/image/small/<?=$data['item']['name']?>" >
  </a>
</div>