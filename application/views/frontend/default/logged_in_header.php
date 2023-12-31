<?php
$user_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
?>
<div class="dsu-bg-percentage"></div>
<div class="dsu-height">

    <div class="dsu-container-fluid py-1">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="<?= base_url() ?>"><img src="<?= base_url('assets/home/')?>img/logo/EarnShalaAdmin.png" class="img-fluid dsu-w-218"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navbar-nav align-items-baseline mr-auto">
                    <li class="nav-item">
                        <a class="nav-link dsu-link-clr dsu-use-offset" href="<?= base_url('courses') ?>"> <button type="button" class="ds-login-header-btn">Home</button></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dsu-link-clr pr-md-4 ds-onclick-e" href="javascript:void(0)"> <img src="<?= base_url('assets/home/')?>img/courses/grid.svg" class="mr-lg-2 img-fluid">Courses</a>
                        <ul class="ds-course-sub-menu" style="display: none;">
                            <?php foreach($latestcourse as $ltcourse): ?>
                            <li><a href="<?php echo site_url('home/course/'.rawurlencode(slugify($ltcourse['title'])).'/'.$ltcourse['id']); ?>"><?= $ltcourse['title']?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <form class="form-inline">
                            <input class="dsu-form-control-login dsu-py-2 form-control" type="search" placeholder="Search for courses" id="search" aria-label="Search">
                            <span class="fa fa-search dsu-py-2 form-control-feedback dsu-position-relative search"></span>
                        </form>
                    </li>
                    <?php if (get_settings('allow_instructor') == 1): ?>
                    <li class="nav-item">
                        <a class="nav-link dsu-link-clr" href="<?php echo site_url('user'); ?>">Instructor</a>
                    </li>
                <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link dsu-link-clr" href="<?php echo site_url('home/my_courses'); ?>">My Courses</a>
                    </li>
                </div>
                <div class="ds-fl-r">
                    <a href="<?php echo site_url('home/my_wishlist'); ?>" class="dsu-pr">
                        <img src="<?= base_url('assets/home/')?>img/courses/heart.svg" class="img-fluid dsu-w-35">
                        <span class="dsu-cart-items-login-h"><?php echo sizeof($this->crud_model->getWishLists()); ?></span>
                    </a>
                    <a href="<?php echo site_url('home/shopping_cart'); ?>" class="dsu-pr mr-4 ml-2">
                        <img src="<?= base_url('assets/home/')?>img/courses/cart.svg" class="img-fluid dsu-w-35">
                        <span class="dsu-cart-items-login-c"><?php echo sizeof($this->session->userdata('cart_items')); ?></span>
                    </a>
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
                                    else
                                    {
                                        $image = $this->user_model->get_user_image_url($this->session->userdata('user_id'));
                                    } 

                                        ?>
                    <a href="#"><img src="<?= $image ?>" style="height: 58px; object-fit: cover; border-radius: 50%;" class="img-fluid dsu-hs dsu-w-58" alt="image"></a>
                    <ul class="dsu-toggle" style="display: none;">
                        <li><a href="<?= base_url('home/profile/user_profile') ?>">User Profile</a></li>
                        <li><a href="<?= base_url('home/profile/user_credentials') ?>">Account</a></li>
                        <li><a href="#">Notifications</a></li>
                        <li><a href="<?= base_url('home/profile/user_credentials') ?>">Settings</a></li>
                        <li><a href="<?= base_url('login/logout') ?>">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>





