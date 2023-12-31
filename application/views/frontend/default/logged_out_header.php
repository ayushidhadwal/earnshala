<div class="dsu-bg-percentage"></div>
<div class="dsu-height">

    <div class="dsu-container-fluid py-1">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="#">
                <img src="<?= base_url('assets/home/')?>img/logo/EarnShalaAdmin.png" class="img-fluid dsu-dv dsu-w-218">
                <img src="<?= base_url('assets/home/')?>img/logo/EarnShala.png" class="img-fluid dsu-mv dsu-w-218">
            </a>
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
                            <input class="dsu-form-control dsu-py-2 form-control" type="search" placeholder="Search for courses" id="search" aria-label="Search">
                            <span class="fa fa-search dsu-py-2 form-control-feedback dsu-position-relative searchbtn"></span>
                        </form>
                    </li>
                </div>
                <div class="ds-fl-r">
                    <a href="<?php echo site_url('home/shopping_cart'); ?>" class="dsu-pr">
                        <img src="<?= base_url('assets/home/')?>img/courses/cart.svg" class="img-fluid dsu-cart-img">
                        <span class="dsu-cart-items"><?php echo sizeof($this->session->userdata('cart_items')); ?></span>
                    </a>
                    <button class="dsu-btn-login ml-3 mr-2" onclick="window.location.href='<?= base_url('login') ?>'">Login</button>
                    <button class="dsu-btn-register" onclick="window.location.href='<?= base_url('register') ?>'">Register</button>
                </div>
            </div>
        </nav>
    </div>
</div>


