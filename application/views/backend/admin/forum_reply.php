

<form action="<?php echo site_url('admin/forum_replies_manage/reply/'.$param2.'/'.$param3); ?>" method="post">
    <div class="form-group">
        <label for="reply"><?php echo get_phrase('forum_reply'); ?></label>
        <input type="hidden" name="forum_id" value="<?= $param2 ?>">
        <input type="hidden" name="forum_reply_id" value="<?= $param3 ?>">

        <textarea name="forum_reply" rows="5" cols="5" class="form-control"></textarea>
    </div>
    <div class="text-center">
        <button class = "btn btn-success" type="submit" name="button"><?php echo get_phrase('submit'); ?></button>
    </div>
</form>

