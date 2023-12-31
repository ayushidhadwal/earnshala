<style type="text/css">
    .field-icon {
      float: right;
      margin-left: -25px;
      margin-top: -25px;
      position: relative;
      z-index: 2;
      padding-right: 15px;
    }
</style>
<section class="page-header-area my-course-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="page-title">Account</h1>
                <ul>
                    <li><a href="<?php echo site_url('home/my_courses'); ?>"><?php echo site_phrase('all_courses'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_wishlist'); ?>"><?php echo site_phrase('wishlists'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_messages'); ?>"><?php echo site_phrase('my_messages'); ?></a></li>
                    <li><a href="<?php echo site_url('home/purchase_history'); ?>"><?php echo site_phrase('purchase_history'); ?></a></li>
                    <li class="active"><a href=""><?php echo site_phrase('user_profile'); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="user-dashboard-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="user-dashboard-box">
                    <div class="user-dashboard-sidebar">
                         <?php $userd = $this->user_model->getUserd($this->session->userdata('user_id')); 

                                    if($userd->social_login)
                                    {
                                       

                                        if(!empty($userd->image))
                                        {
                                            
                                            $image = $this->user_model->get_user_image_url($this->session->userdata('user_id'));
                                        }
                                        else
                                        {

                                            $image = $userd->profile_picture;
                                        }
                                    }
                                        ?>
                        <div class="user-box">
                            <img src="<?php echo $image; ?>" alt="" class="img-fluid">
                            <div class="name"><?php echo $user_details['first_name'].' '.$user_details['last_name']; ?></div>
                        </div>
                        <?php include 'include_sidebar.php'; ?>
                    </div>
                    <div class="user-dashboard-content">
                        <div class="content-title-box">
                            <div class="title"><?php echo site_phrase('account'); ?></div>
                            <div class="subtitle"><?php echo site_phrase('edit_your_account_settings'); ?>.</div>
                        </div>
                        <form action="<?php echo site_url('home/update_profile/update_credentials'); ?>" method="post">
                            <div class="content-box">
                                <div class="email-group">
                                    <div class="form-group">
                                        <label for="email"><?php echo site_phrase('email'); ?>:</label>
                                        <input type="email" class="form-control" name = "email" id="email" placeholder="<?php echo site_phrase('email'); ?>" value="<?php echo $user_details['email']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="password-group">
                                    <div class="form-group">
                                        <label for="password"><?php echo site_phrase('password'); ?>:</label>
                                        <input type="password" class="form-control psbtn" id="current_password" name = "current_password" placeholder="<?php echo site_phrase('enter_current_password'); ?>">
                                        <span  class="fa fa-eye toggle-password cyan-text field-icon" style="cursor: pointer;"></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control psbtn" name = "new_password" placeholder="<?php echo site_phrase('enter_new_password'); ?>">
                                        <span  class="fa fa-eye toggle-passwordr field-icon" style="cursor: pointer;"></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control psbtn" name = "confirm_password" placeholder="<?php echo site_phrase('re-type_your_password'); ?>">
                                        <span  class="fa fa-eye toggle-passwords field-icon" style="cursor: pointer;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="content-update-box">
                                <button type="submit" class="btn"><?php echo site_phrase('save'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){

        $('.toggle-password,.toggle-passwordr,.toggle-passwords').click(function(){

            $(this).toggleClass("fas fa-eye-slash");
            var input = $(this).parent().children('.psbtn');

            if (input.attr("type") == "password") {
                input.attr("type", "text");
              } else {
                input.attr("type", "password");
              }

        })
    })
</script>
