<?php
$user_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
?>
<div class="dsu-bg-percentage"></div>
<div class="dsu-height">

    <div class="dsu-container-fluid py-1">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="<?= base_url() ?>"><img src="<?= base_url('assets/home/')?>img/vector/lyvyo-logo.svg" class="img-fluid dsu-dv dsu-w-218">
                <img src="<?= base_url('assets/home/')?>img/logo/EarnShala.png" class="img-fluid dsu-mv dsu-w-218"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navbar-nav align-items-baseline mr-auto">
                    <li class="nav-item">
                        <a class="nav-link dsu-link-clr dsu-use-offset" href="<?= base_url('courses') ?>"> <button type="button" class="ds-login-header-btn">Home</button></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dsu-link-clr pr-md-4 ds-onclick-e" href="#"> <img src="<?= base_url('assets/home/')?>img/courses/grid.svg" class="mr-lg-2 img-fluid">Courses</a>
                        <ul class="ds-course-sub-menu" style="display: none;">
                            <?php foreach($latestcourse as $ltcourse): ?>
                            <li><a href="<?php echo site_url('home/course/'.rawurlencode(slugify($ltcourse['title'])).'/'.$ltcourse['id']); ?>"><?= $ltcourse['title']?></a></li>
                            <?php endforeach; ?>
                           
                        </ul>
                    </li>

                    <li class="nav-item dsu-hi">
                        <form class="form-inline">
                            <input class="dsu-form-control-login dsu-py-2 form-control" type="search" placeholder="Search for courses" id="search" aria-label="Search">
                            <span class="fa fa-search dsu-py-2 form-control-feedback dsu-position-relative searchbtn" style="cursor: pointer:"></span>
                        </form>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dsu-link-clr" href="<?php echo site_url('user'); ?>">Instructor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dsu-link-clr" href="<?php echo site_url('home/my_courses'); ?>">My Courses</a>
                    </li>
                </div>
                <div class="ds-fl-r">
                    <a href="<?= base_url('home/my_wishlist') ?>" class="dsu-pr text-decoration-none">
                        <img src="<?= base_url('assets/home/')?>img/courses/heart.svg" class="img-fluid dsu-w-35">
                        <span class="dsu-cart-items-login-h"><?php echo sizeof($this->crud_model->getWishLists()); ?></span>
                    </a>
                    <a href="<?php echo site_url('home/shopping_cart'); ?>" class="dsu-pr text-decoration-none mr-4 ml-2">
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
                    <a href="#"><img src="<?= $image ?>" class="img-fluid dsu-hs dsu-w-58"  style="height: 58px; object-fit: cover; border-radius: 50%;" alt="image">

                        <ul class="dsu-toggle" style="display: none;">
                            <li><a href="<?= base_url('home/profile/user_profile') ?>">User Profile</a></li>
                            <li><a href="<?= base_url('home/profile/user_credentials') ?>">Account</a></li>
                            <li><a href="#">Notifications</a></li>
                            <li><a href="<?= base_url('home/profile/user_credentials') ?>">Settings</a></li>
                            <li><a href="<?= base_url('login/logout') ?>">Logout</a></li>
                        </ul>
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>


<!--<section class="menu-area">-->
<!--    <div class="container-xl">-->
<!--        <div class="row">-->
<!--            <div class="col">-->
<!--                <nav class="navbar navbar-expand-lg navbar-light bg-light">-->
<!---->
<!--                    <ul class="mobile-header-buttons">-->
<!--                        <li><a class="mobile-nav-trigger" href="#mobile-primary-nav">Menu<span></span></a></li>-->
<!--                        <li><a class="mobile-search-trigger" href="#mobile-search">Search<span></span></a></li>-->
<!--                    </ul>-->
<!---->
<!--                    <a href="--><?php //echo site_url(''); ?><!--" class="navbar-brand" href="#">-->
<!--                        <img src="--><?//= base_url('assets/home/')?><!--img/courses/lyvyo-blue.png" alt="" height="35">-->
<!--                    </a>-->
<!---->
<!--                    --><?php //include 'menu.php'; ?>
<!---->
<!---->
<!--                    <form class="inline-form" action="--><?php //echo site_url('home/search'); ?><!--" method="get" style="width: 100%;">-->
<!--                        <div class="input-group search-box mobile-search">-->
<!--                            <input type="text" name = 'query' class="form-control" placeholder="--><?php //echo site_phrase('search_for_courses'); ?><!--">-->
<!--                            <div class="input-group-append">-->
<!--                                <button class="btn" type="submit"><i class="fas fa-search"></i></button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </form>-->
<!---->
<!--                    --><?php //if (get_settings('allow_instructor') == 1): ?>
<!--                        <div class="instructor-box menu-icon-box">-->
<!--                            <div class="icon">-->
<!--                                <a href="--><?php //echo site_url('user'); ?><!--" style="border: 1px solid transparent; margin: 10px 10px; font-size: 14px; width: 100%; border-radius: 0;">--><?php //echo site_phrase('instructor'); ?><!--</a>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    --><?php //endif; ?>
<!---->
<!--                    <div class="instructor-box menu-icon-box">-->
<!--                        <div class="icon">-->
<!--                            <a href="--><?php //echo site_url('home/my_courses'); ?><!--" style="border: 1px solid transparent; margin: 10px 10px; font-size: 14px; width: 100%; border-radius: 0; min-width: 100px;">--><?php //echo site_phrase('my_courses'); ?><!--</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                    <div class="wishlist-box menu-icon-box" id = "wishlist_items">-->
<!--                        --><?php //include 'wishlist_items.php'; ?>
<!--                    </div>-->
<!---->
<!--                    <div class="cart-box menu-icon-box" id = "cart_items">-->
<!--                        --><?php //include 'cart_items.php'; ?>
<!--                    </div>-->
<!---->
<!--                    --><?php ////include 'notifications.php'; ?>
<!---->
<!---->
<!--                    <div class="user-box menu-icon-box">-->
<!--                        <div class="icon">-->
<!--                            <a href="javascript::">-->
<!--                                <img src="--><?php //echo $this->user_model->get_user_image_url($this->session->userdata('user_id')); ?><!--" alt="" class="img-fluid">-->
<!--                            </a>-->
<!--                        </div>-->
<!--                        <div class="dropdown user-dropdown corner-triangle top-right">-->
<!--                            <ul class="user-dropdown-menu">-->
<!---->
<!--                                <li class="dropdown-user-info">-->
<!--                                    <a href="">-->
<!--                                        <div class="clearfix">-->
<!--                                            <div class="user-image float-left">-->
<!--                                                <img src="--><?php //echo $this->user_model->get_user_image_url($this->session->userdata('user_id')); ?><!--" alt="" >-->
<!--                                            </div>-->
<!--                                            <div class="user-details">-->
<!--                                                <div class="user-name">-->
<!--                                                    <span class="hi">--><?php //echo site_phrase('hi'); ?><!--,</span>-->
<!--                                                    --><?php //echo $user_details['first_name'].' '.$user_details['last_name']; ?>
<!--                                                </div>-->
<!--                                                <div class="user-email">-->
<!--                                                    <span class="email">--><?php //echo $user_details['email']; ?><!--</span>-->
<!--                                                    <span class="welcome">--><?php //echo site_phrase("welcome_back"); ?><!--</span>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </a>-->
<!--                                </li>-->
<!---->
<!--                                <li class="user-dropdown-menu-item"><a href="--><?php //echo site_url('home/my_courses'); ?><!--"><i class="far fa-gem"></i>--><?php //echo site_phrase('my_courses'); ?><!--</a></li>-->
<!--                                <li class="user-dropdown-menu-item"><a href="--><?php //echo site_url('home/my_wishlist'); ?><!--"><i class="far fa-heart"></i>--><?php //echo site_phrase('my_wishlist'); ?><!--</a></li>-->
<!--                                <li class="user-dropdown-menu-item"><a href="--><?php //echo site_url('home/my_messages'); ?><!--"><i class="far fa-envelope"></i>--><?php //echo site_phrase('my_messages'); ?><!--</a></li>-->
<!--                                <li class="user-dropdown-menu-item"><a href="--><?php //echo site_url('home/purchase_history'); ?><!--"><i class="fas fa-shopping-cart"></i>--><?php //echo site_phrase('purchase_history'); ?><!--</a></li>-->
<!--                                <li class="user-dropdown-menu-item"><a href="--><?php //echo site_url('home/profile/user_profile'); ?><!--"><i class="fas fa-user"></i>--><?php //echo site_phrase('user_profile'); ?><!--</a></li>-->
<!--                                <li class="dropdown-user-logout user-dropdown-menu-item"><a href="--><?php //echo site_url('login/logout/user'); ?><!--">--><?php //echo site_phrase('log_out'); ?><!--</a></li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!---->
<!---->
<!--                    <span class="signin-box-move-desktop-helper"></span>-->
<!--                    <div class="sign-in-box btn-group d-none">-->
<!---->
<!--                        <button type="button" class="btn btn-sign-in" data-toggle="modal" data-target="#signInModal">Log In</button>-->
<!---->
<!--                        <button type="button" class="btn btn-sign-up" data-toggle="modal" data-target="#signUpModal">Sign Up</button>-->
<!---->
<!--                    </div> sign-in-box end -->
<!---->
<!---->
<!--                </nav>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->


