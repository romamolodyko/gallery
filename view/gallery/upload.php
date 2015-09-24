<div class="site">
    <form action="<?=App::get("prefix")?>/?controller=upload&action=save" method="POST" enctype="multipart/form-data">
        <input type="file" name="pictures"><br>
        <p>Write the comments</p>
        <input type="text" name="comments">
        <input type="submit" value="send">
    </form>
</div>