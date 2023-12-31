<?php

$forum_replies = $this->crud_model->get_forum_replies($forum_id)->result();
$forum = $this->user_model->get_forum_by_id($forum_id)->row();

$forum_comment = $this->crud_model->get_table_by_id('forum_reply',
    ['fr_forum_id' => $forum_id, 'fr_forum_reply_id' => null],
    ['forum_reply.fr_id', 'forum_reply.fr_user_id', 'forum_reply.fr_forum_id', 'forum_reply.fr_forum_reply_id', 'forum_reply.fr_reply', 'forum_reply.fr_created_date', 'users.first_name as user_name', 'users.image as user_image'])->result();

// echo '<pre>';
// print_r($forum_comment);

?>

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"><i
                            class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('forum_details'); ?>

                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>


<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><b><?= get_phrase('user_name') ?>
                            :</b> <?php echo $forum->first_name . ' ' . $forum->last_name; ?></div>
                    <div class="col-md-6"><b><?= get_phrase('tags') ?> :</b><?php echo $forum->f_add_tags; ?></div>

                </div>
                <div class="row">
                    <div class="col-md-12"><b><?= get_phrase('query') ?> :</b> <?php echo $forum->f_query_question; ?>
                    </div>
                    <div class="col-md-12"><p><b><?= get_phrase('brief') ?> :</b> <?php echo $forum->f_query_brief; ?>
                        </p></div>

                </div>

            </div>
        </div>
        <div class="card-body">
            <h4 class="mb-3 header-title"><?php echo get_phrase('comments'); ?></h4>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="<?php echo site_url('admin/forum_replies_manage/reply/'.$forum_id); ?>" method="post">
                                <div class="form-group">
                                    <input type="hidden" name="forum_id" value="<?= $forum_id ?>">
                                    <textarea name="forum_reply" id="forum_reply" class="form-control" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (count($forum_comment) > 0): ?>
                <?php foreach ($forum_comment as $key => $value): ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card" style="width:80%;">
                                <div class="card-header">

                                    <div class="row">

                                        <?php $user_image_path = $this->user_model->get_user_image_url($value->fr_user_id); ?>
                                        <div class="col-md-3"><img src="<?php echo $user_image_path; ?>" alt=""
                                                                   style="width:50px;height:50px;border-radius:50%;">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12"><b><?php echo $value->user_name; ?></b></div>
                                                <div class="col-md-12"><b><?php echo $value->fr_created_date; ?></b>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <a href="javascript::void(0)"
                                                       class="btn btn-sm btn-outline-primary btn-rounded btn-icon"
                                                       onclick="showAjaxModal('<?php echo site_url('modal/popup/forum_reply/' . $forum_id . '/' . $value->fr_id); ?>', '<?php echo get_phrase('user_forum'); ?>')"
                                                       style="background-color:skyblue!important;color:black;border:skyblue!important;"> <?php echo get_phrase('reply'); ?>
                                                    </a>
                                                </div>
                                                <div class="col-md-6">
                                                    <a href="javascript::void(0)"
                                                       class="btn btn-sm btn-outline-primary btn-rounded btn-icon"
                                                       onclick="confirm_modal('<?php echo site_url('admin/forum_replies_manage/delete' . '/' . $value->fr_forum_id . '/' . $value->fr_id); ?>');"
                                                       style="background-color:red!important;color:white;border:skyblue!important;"> <?php echo get_phrase('delete'); ?>
                                                    </a>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p><?php echo $value->fr_reply; ?></p>
                                </div>
                            </div>
                            <?php
                            $condition3 = [
                                'fr_forum_id' => $forum_id,
                                'fr_forum_reply_id' => $value->fr_id,
                            ];
                            $replies_on_replies = $this->crud_model->get_replies_on_reply_id('forum_reply', $condition3)->result();
                            if (!empty($replies_on_replies)):
                                foreach ($replies_on_replies as $key2 => $value2):

                                    // print_r($value2);
                                    // exit();
                                    ?>


                                    <div class="card float-right" style="width:80%;">
                                        <div class="card-header">

                                            <div class="row">
                                                <?php $replier_image_path = $this->user_model->get_user_image_url($value2->user_id);
                                                ?>
                                                <div class="col-md-3"><img src="<?php echo $replier_image_path ?>"
                                                                           alt=""
                                                                           style="width:50px;height:50px;border-radius:50%;">
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12"><b><?php echo $value2->user_name; ?></b>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <b><?php echo $value2->fr_created_date; ?></b></div>

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <a href="javascript::void(0)"
                                                               class="btn btn-sm btn-outline-primary btn-rounded btn-icon"
                                                               onclick="showAjaxModal('<?php echo site_url('modal/popup/forum_reply_on_reply/' . $forum_id . '/' . $value->fr_id); ?>', '<?php echo get_phrase('user_forum'); ?>')"
                                                               style="background-color:skyblue!important;color:black;border:skyblue!important;"> <?php echo get_phrase('reply'); ?>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <a href="javascript::void(0)"
                                                               class="btn btn-sm btn-outline-primary btn-rounded btn-icon"
                                                               onclick="confirm_modal('<?php echo site_url('admin/forum_replies_manage/delete' . '/' . $value2->fr_forum_id . '/' . $value2->fr_id); ?>');"
                                                               style="background-color:red!important;color:white;border:skyblue!important;"> <?php echo get_phrase('delete'); ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <?php echo $value2->fr_reply ?>
                                        </div>
                                    </div>

                                <?php
                                endforeach;
                            endif;
                            ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (count($forum_comment) == 0): ?>
                <div class="img-fluid w-100 text-center">
                    <img style="opacity: 1; width: 100px;"
                         src="<?php echo base_url('assets/backend/images/file-search.svg'); ?>"><br>
                    <?php echo get_phrase('no_data_found'); ?>
                </div>
            <?php endif; ?>


        </div>
    </div>
</div>
</div>




