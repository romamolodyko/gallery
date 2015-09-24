<div class="image <?=$data['countImage']?>">
    <a name="<?=$data['imageName']?>" data-lightbox='example' data-title='$textBlock' onclick=clickImg(name)>
        <img src="<?=App::get("uploads_dir_small").DIRECTORY_SEPARATOR.$data['imageName']?>">
    </a>
</div>