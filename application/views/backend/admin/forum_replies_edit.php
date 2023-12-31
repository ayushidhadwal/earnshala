<?php $reply = $this->crud_model->get_forum_reply($param2)->row('fr_reply'); ?>

<form action="<?php echo site_url('admin/forum_replies_manage/update/'.$param2.'/'.$param3); ?>" method="post">
    <div class="form-group">
        <label for="reply"><?php echo get_phrase('forum_reply'); ?></label>
        <textarea name="reply" rows="5" cols="5" class="form-control"><?= $reply ?></textarea>
    </div>
    <div class="text-center">
        <button class = "btn btn-success" type="submit" name="button"><?php echo get_phrase('update'); ?></button>
    </div>
</form>

