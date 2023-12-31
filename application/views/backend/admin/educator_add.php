<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?>
                    <a href="<?php echo site_url('admin/admins'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"> <i class="mdi mdi-arrow-left"></i> <?php echo get_phrase('back_to_admins'); ?></a>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title mb-3"><?php echo get_phrase('educator_add_form'); ?></h4>

                <div class="row">
                    <div class="col-md-12">
                        <?php if (!empty($this->session->flashdata('educators_msg'))) { ?>
                            <div class="alert alert-danger">
                                <?php echo  $this->session->flashdata('educators_msg'); ?>
                            </div>
                        <?php }  ?>

                        <?php if (!empty($this->session->flashdata('educators_msg_success'))) { ?>
                            <div class="alert alert-success">
                                <?php echo  $this->session->flashdata('educators_msg_success'); ?>
                            </div>
                        <?php }  ?>
                    </div>
                </div>

                <form class="required-form" action="<?php echo site_url('admin/educatorsFunc/add'); ?>" enctype="multipart/form-data" method="post">
                    <div id="progressbarwizard">
                        <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                            <li class="nav-item">
                                <a href="#basic_info" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                    <i class="mdi mdi-face-profile mr-1"></i>
                                    <span class="d-none d-sm-inline"><?php echo get_phrase('basic_info'); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#login_credentials" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                    <i class="mdi mdi-lock mr-1"></i>
                                    <span class="d-none d-sm-inline"><?php echo get_phrase('login_credentials'); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#social_information" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                    <i class="mdi mdi-wifi mr-1"></i>
                                    <span class="d-none d-sm-inline"><?php echo get_phrase('social_information'); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#finish" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                    <i class="mdi mdi-checkbox-marked-circle-outline mr-1"></i>
                                    <span class="d-none d-sm-inline"><?php echo get_phrase('finish'); ?></span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content b-0 mb-0">

                            <div id="bar" class="progress mb-3" style="height: 7px;">
                                <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"></div>
                            </div>

                            <div class="tab-pane" id="basic_info">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="first_name"><?php echo get_phrase('first_name'); ?><span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" value="<?php if(isset($educator_by_id->id)){ echo $educator_by_id->id; } ?>" class="form-control"  name="educator_id" required>
                                                <input type="text" value="<?php if(isset($educator_by_id->first_name)){ echo $educator_by_id->first_name; } ?>" class="form-control" id="first_name" name="first_name" required>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="last_name"><?php echo get_phrase('last_name'); ?><span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="<?php if(isset($educator_by_id->last_name)){ echo $educator_by_id->last_name; } ?>" id="last_name" name="last_name" required>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="linkedin_link"><?php echo get_phrase('biography'); ?></label>
                                            <div class="col-md-9">
                                                <textarea name="biography" id="summernote-basic" class="form-control"><?php if(isset($educator_by_id->biography)){ echo $educator_by_id->biography; } ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="user_image"><?php echo get_phrase('user_image'); ?></label>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="user_image" name="user_image" accept="image/*" onchange="changeTitleOfImageUploader(this)">
                                                        <label class="custom-file-label" for="user_image"><?php echo get_phrase('choose_user_image'); ?></label>
                                                    </div>
                                                    <input type="text" name="user_image_old" value="<?php if(isset($educator_by_id->image)){ echo $educator_by_id->image; } ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <div class="col-md-12 text-right mb-3">
                                                <button class="btn btn-default btn-sm text-white add-more-quli">Add more qualifications</button>
                                            </div>
                                            <div class="col-md-12 append-quli-here">

                                                <?php if (isset($educator_qualifications)){ ?>
                                                    <?php foreach ($educator_qualifications as $key => $value): ?>
                                                        <div class="row">
                                                            <div class="col-md-12 text-right mb-3">
                                                                <button class="btn btn-danger btn-sm text-white delete-quli" style="background-color: #fa5c7c !important;">Delete</button>
                                                            </div>
                                                            <label class="col-md-3 col-form-label" for=""><?php echo get_phrase('Education Qualifications'); ?></label>
                                                            <div class="col-md-9">
                                                                <textarea name="edu_qulification[]" class="form-control summernote-basic"><?php if(isset($value->qualification)){ echo $value->qualification; } ?></textarea>
                                                            </div>

                                                            <label class="col-md-3 col-form-label mt-3" for=""><?php echo get_phrase('Education Qualification Certificate'); ?></label>
                                                            <div class="col-md-9 mt-3">
                                                                <input type="file" class="form-control-file" name="quli_certify[]">
                                                                <input type="text" name="quli_certify_old[]" value="<?php if(isset($value->qualification_file)){ echo $value->qualification_file; } ?>">
                                                            </div>
                                                        </div>
                                                    <?php endforeach ?>
                                                <?php }else{ ?>

                                                    <div class="row">
                                                        <div class="col-md-12 text-right mb-3">
                                                            <button class="btn btn-danger btn-sm text-white delete-quli" style="background-color: #fa5c7c !important;">Delete</button>
                                                        </div>
                                                        <label class="col-md-3 col-form-label" for=""><?php echo get_phrase('Education Qualifications'); ?></label>
                                                        <div class="col-md-9">
                                                            <textarea name="edu_qulification[]" class="form-control summernote-basic"></textarea>
                                                        </div>

                                                        <label class="col-md-3 col-form-label mt-3" for=""><?php echo get_phrase('Education Qualification Certificate'); ?></label>
                                                        <div class="col-md-9 mt-3">
                                                            <input type="file" class="form-control-file" name="quli_certify[]">
                                                        </div>
                                                    </div>

                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>

                            <div class="tab-pane" id="login_credentials">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="email"><?php echo get_phrase('email'); ?><span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="email" id="email" name="email" value="<?php if(isset($educator_by_id->email)){ echo $educator_by_id->email; } ?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="password"><?php echo get_phrase('password'); ?><span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="password" id="password" name="password" value="<?php if(isset($educator_by_id->password_without_enc)){ echo $educator_by_id->password_without_enc; } ?>" class="form-control" required>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>

                            <div class="tab-pane" id="social_information">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="facebook_link"> <?php echo get_phrase('facebook'); ?></label>
                                            <div class="col-md-9">
                                                <input type="text" id="facebook_link" value="<?php if(isset($educator_by_id->facebook_link)){ echo $educator_by_id->facebook_link; } ?>" name="facebook_link" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="twitter_link"><?php echo get_phrase('twitter'); ?></label>
                                            <div class="col-md-9">
                                                <input type="text" id="twitter_link" value="<?php if(isset($educator_by_id->twitter_link)){ echo $educator_by_id->twitter_link; } ?>" name="twitter_link" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="linkedin_link"><?php echo get_phrase('linkedin'); ?></label>
                                            <div class="col-md-9">
                                                <input type="text" id="linkedin_link" value="<?php if(isset($educator_by_id->linkedin_link)){ echo $educator_by_id->linkedin_link; } ?>" name="linkedin_link" class="form-control">
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>
                            <div class="tab-pane" id="finish">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-center">
                                            <h2 class="mt-0"><i class="mdi mdi-check-all"></i></h2>
                                            <h3 class="mt-0"><?php echo get_phrase('thank_you'); ?> !</h3>

                                            <p class="w-75 mb-2 mx-auto"><?php echo get_phrase('you_are_just_one_click_away'); ?></p>

                                            <div class="mb-3">
                                                <button type="button" class="btn btn-primary" onclick="checkRequiredFields()" name="button"><?php echo get_phrase('submit'); ?></button>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>

                            <ul class="list-inline mb-0 wizard text-center">
                                <li class="previous list-inline-item">
                                    <a href="javascript::" class="btn btn-info"> <i class="mdi mdi-arrow-left-bold"></i> </a>
                                </li>
                                <li class="next list-inline-item">
                                    <a href="javascript::" class="btn btn-info"> <i class="mdi mdi-arrow-right-bold"></i> </a>
                                </li>
                            </ul>

                        </div> <!-- tab-content -->
                    </div> <!-- end #progressbarwizard-->
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div>
</div>

<script>
    $(function(){
        $('.add-more-quli').click(function (e) {
            e.preventDefault();
            $('.append-quli-here').append(`<div class="row">
                                                <div class="col-md-12 text-right mb-3">
                                                    <button class="btn btn-danger btn-sm text-white delete-quli" style="background-color: #fa5c7c !important;">Delete</button>
                                                </div>
                                                <label class="col-md-3 col-form-label" for=""><?php echo get_phrase('Education Qualifications'); ?></label>
                                                <div class="col-md-9">
                                                    <textarea name="edu_qulification[]" class="form-control summernote-basic"></textarea>
                                                </div>

                                                <label class="col-md-3 col-form-label mt-3" for=""><?php echo get_phrase('Education Qualification Certificate'); ?></label>
                                                <div class="col-md-9 mt-3">
                                                    <input type="file" class="form-control-file" name="quli_certify[]">
                                                </div>
                                            </div>`)
            $(".summernote-basic").summernote(
                {
                placeholder:"Write something...",
                height:200
                }
            )
            RemoveQuli()
        });

        RemoveQuli()
    })

    function RemoveQuli() {
        $('.delete-quli').click(function (e) {
            e.preventDefault();
            $(this).parent().parent('.row').remove()
        });
    }
</script>
