<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/home/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>assets/home/css/ds.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/home/css/js.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/home/css/nav-style.css">
    <?php include 'includes/favicon.php'; ?>


    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/home/css/slick.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/home/css/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/home/css/toast.css">
    <style type="text/css">
        html, body {
            margin: 0;
            padding: 0;
        }

        * {
            box-sizing: border-box;
        }

        .slider {
            width: 100%;
            margin: 100px auto;
        }

        .slick-slide {
            margin: 0px 20px;
        }

        .slick-slide img {
            width: 100%;
        }

        .slick-prev:before,
        .slick-next:before {
            color: black;
        }


        .slick-slide {
            transition: all ease-in-out .3s;
        }


        .slick-current {
            opacity: 1;
        }

        .slick-prev, .slick-next {
            top: -28px !important;
        }

        .slick-prev {
            left: unset;
            right: 100px;
            bottom: 10px;
        }

        .slick-next {
            left: unset;
            right: 50px;
            bottom: 10px;
        }

        .ds-flexx {
            display: flex;
        }

        .ds-col-1 {
            flex: 1;
        }

        .ds-col-2 {
            flex: 3;
        }


    </style>

    <title>LYVYO</title>
</head>
<body>

<!--mobile ipad-->
<div class="ds-nav-clr hidemeee">
    <div class="container py-sm-1">
        <div class="row align-items-center">
            <div class="col-md-6 col-8">
                <ul class="ds-ul-top">
                    <li class="">
                        <a href="#" class="text-decoration-none text-white">
                            <img class="img-fluid ds-si-a" src="<?= base_url() ?>assets/home/img/icon/phone.svg" alt="">
                        </a>
                    </li>
                    <li class="pl-3">
                        <a class="text-decoration-none text-white" href="#">
                            <img class="img-fluid ds-si-a" src="<?= base_url() ?>assets/home/img/icon/mail.svg" alt=""></a>
                    </li>

                </ul>


            </div>
            <div class="col-md-6 col-4">
                <div class="d-flex justify-content-end align-items-center">
                    <a href="#"><img class="ds-si-new" src="<?= base_url() ?>assets/home/img/icon/social/TW.png" alt=""></a>
                    <a href="#"><img class="ds-si-new" src="<?= base_url() ?>assets/home/img/icon/social/YT.png" alt=""></a>
                    <a href="#"><img class="ds-si-new" src="<?= base_url() ?>assets/home/img/icon/social/S.png" alt=""></a>
                    <a href="#"><img class="ds-si-new" src="<?= base_url() ?>assets/home/img/icon/social/INS.png"
                                     alt=""></a>
                    <a href="https://www.facebook.com/LYVYO.UAE"><img class="ds-si-new ds-mr-36px"
                                                                      src="<?= base_url() ?>assets/home/img/icon/social/FB.png"
                                                                      alt=""></a>
                    <a href="#" class="ds-onclick-e"><span class="ds-po-relative"><img class="ds-po-absolute"
                                                                  src="<?= base_url() ?>assets/home/img/icon/top-menu.svg"
                                                                  alt="">
                            <ul class="ds-lang-d" style="display: none;">
                                <?php foreach($countrys as $cey => $cntry): ?>
                        <li><?= $cntry->countries_name ?></li>
                        <?php endforeach; ?>
                    </ul></span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<nav class="navbar navbar-expand-lg hidemeee navbar-dark ds-bg-primary">
    <div class="container">
        <a class="navbar-brand py-md-3 ds-w-180 ds-z-index" href="<?= base_url() ?>">
        <!-- <img class="img-fluid" src="<?= base_url() ?>assets/home/img/vector/lyvyo-logo.svg" alt=""> -->
        <img class="img-fluid" src="<?= base_url('assets/home/')?>img/logo/EarnShalaAdmin.png" alt="" height="60">                                                                                            
        </a>

        <a class="navbar-brand py-md-3 ds-w-180 ds-z-index" href="<?= base_url() ?>">
        <!-- <img class="img-fluid" src="<?= base_url() ?>assets/home/img/vector/lyvyo-logo.svg" alt=""> -->
        <img class="img-fluid" src="<?= base_url('assets/home/')?>img/logo/EarnShalaAdmin.png" alt="" height="60">                                                                                            
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav align-items-lg-center mx-auto">
                <!--                <li class="nav-item">-->
                <!--                    <a class="nav-link" href="#">Category</a>-->
                <!--                </li>-->
                <li class="nav-item dropdown">
                    <a class="nav-link ds-link-clr " href="<?= base_url('education') ?>" id="navbarDropdown"
                       role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Education
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">


                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase active"
                                               href="<?= base_url('education/5') ?>#primary-level">Primary Level</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase"
                                               href="<?= base_url('education/7') ?>#secondary-level">Secondary Level</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('education/6') ?>#high-school-level">Highschool
                                                Level</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('education/8') ?>#university-level">University
                                                Level</a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <!--  /.container  -->


                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link ds-link-clr " href="<?= base_url('self-improvement') ?>" id="navbarDropdown"
                       role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        SELF IMPROVEMENT
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">


                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase active"
                                               href="<?= base_url('instructors/64') ?>">Life Coaching</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" href="<?= base_url('instructors/65') ?>">Business
                                                Coaching</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" href="<?= base_url('instructors/66') ?>">Family/Marriage
                                                Counselling</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" href="<?= base_url('instructors/67') ?>">Substance
                                                Abuse Counselling</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" href="<?= base_url('instructors/68') ?>">Mindfulness
                                                Based
                                                Counselling</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.col-md-4  -->


                            </div>
                        </div>
                        <!--  /.container  -->


                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link ds-link-clr " href="<?= base_url('fitness') ?>" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        FITNESS
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">


                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase active"
                                               href="<?= base_url('instructors/11') ?>">Yoga</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" href="<?= base_url('instructors/12') ?>">Zumba</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" href="<?= base_url('instructors/13') ?>">Aerobics</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" href="<?= base_url('instructors/14') ?>">H.I.I.T</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase" href="<?= base_url('instructors/15') ?>">Circuit
                                                Training</a>
                                        </li>

                                    </ul>
                                </div>

                            </div>
                        </div>
                        <!--  /.container  -->


                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link ds-link-clr " href="<?= base_url('courses') ?>" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        COURSES
                    </a>

                </li>

                <li class="nav-item dropdown ">
                    <a class="nav-link ds-link-clr border-right-js" href="<?= base_url('faq') ?>" id="navbarDropdown"
                       role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        FAQ
                    </a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <!--                   <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">-->
                <!--                   <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>-->
                <!--                hellow-->
                <?php if ($this->session->userdata('user_login')) {
                    $userd = $this->user_model->getUserd($this->session->userdata('user_id'));
                    if ($userd->social_login) {
                        if (!empty($userd->image)) {
                            $image = $this->user_model->get_user_image_url($this->session->userdata('user_id'));
                        } else {
                            $image = $userd->profile_picture;
                        }
                    } else {
                        $image = $this->user_model->get_user_image_url($this->session->userdata('user_id'));
                    }

                    ?>
                    <div class="d-flex posre ds-bdr-left">
                        <img class="ds-user-login" src="<?php echo $image; ?>" alt="loggedin user">
                        <div class="form-group mb-0">
                            <select class="form-control ds-select-user ds-outline-warning-btn"
                                    onchange="location = this.value;">
                                <option value=""><?= $this->session->userdata('name') ?></option>
                                <option value="<?= base_url('home/profile/user_profile') ?>">User Profile</option>
                                <option value="<?= base_url('home/profile/user_credentials') ?>">Account</option>
                                <option>Notifications</option>
                                <option value="<? -base_url('home/profile/user_credentials') ?>">Settings</option>
                                <option value="<?= base_url('login/logout') ?>">Logout</option>
                            </select>
                        </div>
                    </div>
                <?php } else { ?>

                    <button type="button" class="ds-warning-white-btn btn text-uppercase text-white"
                            onclick="window.location.href='<?= base_url('login') ?>'">Log In
                    </button>
                <?php } ?>
            </form>
        </div>
    </div>
</nav>
<!-- & mobile ipad-->


<div class="ds-nav-clr dis-none-me py-1">
    <div class="container">
        <div class="row">
            <div class="col-md-3 dddddd ds-col-md-3">
                <img class="img-fluid ds-si-a" src="<?= base_url() ?>assets/home/img/icon/phone.svg" alt="">
                <img class="img-fluid ml-md-3 ds-si-a dskkiii" src="<?= base_url() ?>assets/home/img/icon/mail.svg"
                     alt="">
            </div>
            <div class="col-md-3 pl-0">

            </div>
            <div class="col-md-6 pr-0 text-right">
                <a href="#"><img class="ds-si-new" src="<?= base_url() ?>assets/home/img/icon/social/TW.png" alt=""></a>
                <a href="#"><img class="ds-si-new" src="<?= base_url() ?>assets/home/img/icon/social/YT.png" alt=""></a>
                <a href="#"><img class="ds-si-new" src="<?= base_url() ?>assets/home/img/icon/social/S.png" alt=""></a>
                <a href="#"><img class="ds-si-new" src="<?= base_url() ?>assets/home/img/icon/social/INS.png"
                                 alt=""></a>
                <a href="https://www.facebook.com/LYVYO.UAE"><img class="ds-si-new ds-mr-36px"
                                                                  src="<?= base_url() ?>assets/home/img/icon/social/FB.png"
                                                                  alt=""></a>
                <a href="#" class="ds-onclick-e"><span class="ds-po-relative"><img class="ds-po-absolute"
                                                                                   src="<?= base_url() ?>assets/home/img/icon/top-menu.svg"
                                                                                   alt="">
                    <ul class="ds-lang-d" style="display: none;">
                       <?php foreach($countrys as $cey => $cntry): ?>
                        <li><?= $cntry->countries_name ?></li>
                        <?php endforeach; ?>
                    </ul>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="ds-banner-img dis-none-me">
    <ul id="justhead" class="ull-me">
        <div class="ds-posabs"></div>
        <div class="container ">
            <div class="row">
                <div class="col-md-3 ds-col-md-3 my-auto">
                    <a href="<?= base_url() ?>"><img class="img-fluid pr-1 dspt-2"
                                                     src="<?= base_url() ?>img/logo/EarnShalaAdmin.png"
                                                     alt=""></a>
                </div>
                <div class="col-md-9 sdfdsfds ds-col-md-9 pl-0 text-right">
                    <li class="ds-add-cw">
                        <a href="<?= base_url('education') ?>" class="ds-header-top-font">Education</a>
                        <ul class="dropdown py-5 ull-me dsspll">
                            <div class="container">
                                <div class="row mx-0 applyme text-left">
                                    <div class="col-md-12 px-0 ds-border-btm pb-2"><a
                                                href="<?= base_url('education') ?>"
                                                class="font-dubai-bold ds-align">Education</a>
                                    </div>
                                    <div class="col-md-12 pt-4 pb-5 px-0">
                                        <div class="row pb-5">
                                            <div class="col-md-3"><a href="<?= base_url('education/5') ?>#primary-level"
                                                                     class="ds-align">Primary Level</a></div>
                                            <div class="col-md-3"><a
                                                        href="<?= base_url('education/7') ?>#secondary-level"
                                                        class="ds-align">Secondary Level</a></div>
                                            <div class="col-md-3"><a
                                                        href="<?= base_url('education/6') ?>#high-school-level"
                                                        class="ds-align">Highschool Level</a>
                                            </div>
                                            <div class="col-md-3 text-right" class="ds-align"><a
                                                        href="<?= base_url('education/8') ?>#university-level"
                                                        class="ds-align">University
                                                    Level</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= base_url('self-improvement') ?>" class="ds-header-top-font">Self Improvement</a>
                        <ul class="dropdown py-5 ull-me">
                            <div class="container">
                                <div class="row mx-0 applyme">
                                    <div class="col-md-12 px-0 ds-border-btm pb-2">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <a href="<?= base_url('self-improvement') ?>"
                                                   class="font-dubai-bold font-weight-bold ds-align">Self
                                                    Improvement</a></div>
                                            <div class="col-md-4">
                                                <a href="<?= base_url('self-improvement') ?>"
                                                   class="font-dubai-bold font-weight-bold ds-align">Counselling</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 pt-4 pb-5 px-0">
                                        <div class="row pb-5">
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-8 ds-height-120 border-right">
                                                        <div class="row">
                                                            <div class="col-md-12 pb-4"><a
                                                                        href="<?= base_url('instructors/64') ?>"
                                                                        class="ds-align">Life Coaching</a>
                                                            </div>
                                                            <div class="col-md-12 pb-4"><a
                                                                        href="<?= base_url('instructors/65') ?>"
                                                                        class="ds-align">Business
                                                                    Coaching</a></div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-12 pb-4"><a
                                                                href="<?= base_url('instructors/66') ?>"
                                                                class="ds-align">Family/Marriage
                                                            Counselling</a></div>
                                                    <div class="col-md-12 pb-4"><a
                                                                href="<?= base_url('instructors/67') ?>"
                                                                class="ds-align">Substance Abuse
                                                            Counselling</a></div>
                                                    <div class="col-md-12 pb-4"><a
                                                                href="<?= base_url('instructors/68') ?>"
                                                                class="ds-align">Mindfulness Based
                                                            Counselling</a></div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= base_url('fitness') ?>" class="ds-header-top-font">Fitness</a>
                        <ul class="dropdown py-5 ull-me">
                            <div class="container">
                                <div class="row mx-0 applyme">
                                    <div class="col-md-12 px-0 ds-border-btm pb-2"><a href="<?= base_url('fitness') ?>"
                                                                                      class="font-dubai-bold ds-align">Fitness</a>
                                    </div>
                                    <div class="col-md-12 pt-4 pb-5 px-0">
                                        <div class="row pb-5">
                                            <div class="col-md-2 pb-4"><a href="<?= base_url('instructors/11') ?>"
                                                                          class="ds-align">Yoga</a></div>
                                            <div class="col-md-2 pb-4"><a href="<?= base_url('instructors/12') ?>"
                                                                          class="ds-align">Zumba</a></div>
                                            <div class="col-md-2 pb-4"><a href="<?= base_url('instructors/13') ?>"
                                                                          class="ds-align">Aerobics</a></div>
                                            <div class="col-md-2 pb-4"><a href="<?= base_url('instructors/14') ?>"
                                                                          class="ds-align">H.I.I.T</a></div>
                                            <div class="col-md-2 pb-4"><a href="<?= base_url('instructors/15') ?>"
                                                                          class="ds-align">Circuit Training</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= base_url('courses') ?>" class="ds-header-top-font ds-course-eff"
                           style="color: #1339BE !important;">Courses</a>

                    </li>

                    <li><a href="<?= base_url('faq') ?>" class="ds-header-top-font ds-faq">faq</a></li>
                    <?php

                    if ($this->session->userdata('user_login')) { ?>
                        <li class="">
                            <div class="d-flex posre ds-bdr-left">

                                <img class="ds-user-login" src="<?php echo $image; ?>" alt="loggedin user">
                                <div class="form-group mb-0">
                                    <select class="form-control ds-select-user ds-outline-warning-btn" id=""
                                            onchange="location = this.value;">
                                        <option value=""><?= $this->session->userdata('name') ?></option>
                                        <option value="<?= base_url('home/profile/user_profile') ?>">User Profile
                                        </option>
                                        <option value="<?= base_url('home/profile/user_credentials') ?>">Account
                                        </option>
                                        <option>Notifications</option>
                                        <option value="<?= base_url('home/profile/user_credentials') ?>">Settings
                                        </option>
                                        <option value="<?= base_url('login/logout') ?>">Logout</option>
                                    </select>
                                </div>
                            </div>
                        </li>

                    <?php } else { ?>

                        <li class="ds-target-me">
                            <button type="button" class="ds-warning-white-btn btn text-uppercase text-white"
                                    onclick="window.location.href='<?= base_url('login') ?>'">Log In
                            </button>
                        </li>
                    <?php } ?>

                </div>


            </div>
        </div>

    </ul>
    <div class="container">
        <div class="row mx-0">
            <div class="col-6 ds-transform align-self-center">
                <h4 class="ds-section-tilte mmtsdr ds-h4-height">Share Skills</h4>
                <h1 class="text-uppercase mb-0 ds-learnmore">Learn More</h1>
                <p class="ds-p-text"><span class="aristotelica"> LYVYO</span> aims to connect Instructors of different
                    fields with a wide range of learners online. Whether it is
                    Education, Counselling or Fitness. <span class="aristotelica"> LYVYO</span> is the place to be to
                    connect great minds alike.</p>
                <a href="<?= base_url('register') ?>" class="btn text-white text-uppercase ds-warning-btn">Join <span
                            class="aristotelica-bold">LYVYO</span></a>
            </div>
            <div class="col-6">
                <img class="img-fluid ds-relative-r-71" src="<?= base_url() ?>assets/home/img/png/HPI1.png" alt="">
            </div>
        </div>
    </div>
</div>

<div class="ds-banner-img" id="hideid">

    <div class="container">
        <div class="row mx-0">
            <div class="col-6 ds-transform align-self-center">
                <h4 class="ds-section-tilte mmtsdr">Share Skills</h4>
                <h1 class="text-uppercase ds-learnmore">Learn More</h1>
                <p class="ds-p-text"><span class="aristotelica"> LYVYO</span> aims to connect Instructors of different
                    fields with a wide range of learners
                    online. Whether
                    it is
                    Education, Counselling or Fitness. <span class="aristotelica"> LYVYO</span> is the place to be to
                    connect great minds alike.</p>
                <a href="<?= base_url('register') ?>" class="btn text-white text-uppercase ds-warning-btn">Join <span
                            class="aristotelica-bold">LYVYO</span></a>
            </div>
        </div>
    </div>
</div>


<div class="ds-net-img">
    <div class="ds-container ds-mt-20">
        <div class="row ds-pos-rell p mx-0">


            <?php foreach ($categories as $key => $cat) { ?>
                <div class="col-md-3 col-6 mb-2 px-0">
                    <div class="content">
                        <a href="<?= base_url() . $cat->slug ?>" target="_blank">
                            <div class="content-overlay"></div>
                            <img class="content-image"
                                 src="<?= base_url('uploads/thumbnails/category_thumbnails/' . $cat->thumbnail) ?>"
                                 alt="<?= $cat->name ?>" style="height: 195px; max-height: 195px; min-height: 195px;">
                            <div class="content-details fadeIn-bottom">
                                <h3 class="content-title"><?= $cat->name ?></h3>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>


            <div class="col-md-3 col-6 mb-2 px-0">
                <div class="content">
                    <a href="<?= base_url('courses') ?>" target="_blank">
                        <div class="content-overlay"></div>
                        <img class="content-image" src="<?= base_url() ?>assets/home/img/vector/online-school.svg"
                             alt="Courses" style="height: 195px; max-height: 195px; min-height: 195px;">
                        <div class="content-details fadeIn-bottom">
                            <h3 class="content-title">Courses</h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <!--    How it work-->
        <div class="row">
            <div class="col-md-12 ds-mtp text-center">
                <h1 class="text-uppercase mb-0 ds-h1-height ds-section-sub-tilte font-dubai-bold">How It Works</h1>
                <p class="ds-sub-heading ds-ilb ds-section-tilte ds-ybb">For Learners</p>
            </div>
            <div class="col-md-4 px-md-0 text-center">
                <img class="img-fluid pb-lg-2 mb-lg-3" src="<?= base_url() ?>assets/home/img/vector/find-2.svg"
                     alt="find">
                <h3 class="ds-h3-clr font-dubai-bold">Find The Perfect Coach</h3>
                <p class="font-dubai ds-font-p">Browse through the list of coaches or search <br>
                    for a course you are looking for.</p>
            </div>

            <div class="col-md-4 px-md-0 text-center">
                <img class="img-fluid pb-lg-2 mb-lg-3"
                     src="<?= base_url() ?>assets/home/img/vector/schedule-lesson-1.svg" alt="find">
                <h3 class="ds-h3-clr font-dubai-bold">Schedule Your Lessons</h3>
                <p class="font-dubai ds-font-p">See available time slots on the instructors
                    <br>schedule and book the time <br>
                    that works for you.</p>
            </div>


            <div class="col-md-4 px-md-0 text-center">
                <img class="img-fluid pb-lg-2 mb-lg-3" src="<?= base_url() ?>assets/home/img/vector/start-lesson.svg"
                     alt="ds">
                <h3 class="ds-h3-clr font-dubai-bold">Start Your Session!</h3>
                <p class="font-dubai ds-font-p">Once the booking is confirmed, you will <br>
                    receive an email with the online class <br>
                    link to start your class!</p>
            </div>
        </div>
        <!--    & How it work-->


        <!--    for instructor-->
        <div class="row">
            <div class="col-md-12 text-center ds-mtp">
                <p class="ds-sub-heading ds-for-ins">For Instructors</p>
            </div>
            <div class="col-md-4 px-0 text-center">
                <img class="img-fluid pb-lg-2 mb-lg-3" src="<?= base_url() ?>assets/home/img/vector/skills.svg"
                     alt="find">
                <h3 class="ds-h3-clr font-dubai-bold">Have Skills to Share?</h3>
                <p class="font-dubai ds-font-p">Let us know your skills <br>
                    by registering </p>
            </div>

            <div class="col-md-4 px-0 text-center">
                <img class="img-fluid pb-lg-2 mb-lg-3" src="<?= base_url() ?>assets/home/img/vector/submit.svg"
                     alt="find">
                <h3 class="ds-h3-clr font-dubai-bold">Submit Certifications</h3>
                <p class="font-dubai ds-font-p">Submitting certifications will allow us to verify <br>
                    that you are certified.</p>
            </div>


            <div class="col-md-4 px-0 text-center">
                <img class="img-fluid pb-lg-2 mb-lg-3" src="<?= base_url() ?>assets/home/img/vector/earn.svg" alt="ds">
                <h3 class="ds-h3-clr font-dubai-bold">Earn by Training Online</h3>
                <p class="font-dubai ds-font-p">After verification, your profile will be active <br>
                    and visible for the students and learners.</p>
            </div>
        </div>
        <!--    & for instructor-->

    </div>
    <div class="bg-light ds-md-5">
        <div class="container ds-py-5">
            <div class="row">
                <div class="col-md-6 text-center"><img class="ds-w90"
                                                       src="<?= base_url() ?>assets/home/img/vector/about-us-pic.svg"
                                                       alt=""></div>
                <div class="col-md-6">
                    <div class="ds-po-relative">
                        <img class="img-fluid mt-3 mt-md-0" src="<?= base_url() ?>assets/home/img/png/about-a.png"
                             alt="">
                    </div>
                    <p class="ds-p-text pt-3 pb-2 font-dubai">
                        <span class="aristotelica-bold">LYVYO</span> aims to connect you with qualified and skilled
                        instructors of different fields of
                        skills. whether you seek tutoring in certain subjects or a private workout, we make it happen by
                        connecting you virtually with your desired instructor online. check out below the range of
                        services
                        we provide. we are constantly growing and expanding our service options, so if you have
                        something in
                        mind that we don’t yet provide, we’d love to hear about it.
                    </p>
                    <a href="<?= base_url('about-us') ?>" class="btn text-white ds-warning-btn">Read More</a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="ds-bg-gradient ds-mt220 counterHeight">
    <div class="container py-4">
        <div class="row ds-text-center pt-md-5 pb-md-3">
            <div class="col-lg-3 disflexmd col-6 mb-4">
                <div class="row">
                    <div class="col-md-3"><img src="<?= base_url() ?>assets/home/img/vector/instructor.svg"
                                               alt="instructor">
                    </div>
                    <div class="col-md-9 pl-md-5  text-white">
                        <h1 class="font-dubai-bold count">500</h1>
                        <h5 class="font-dubai">Instructors</h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 disflexmd col-6 mb-4">
                <div class="row">
                    <div class="col-md-3"><img src="<?= base_url() ?>assets/home/img/vector/trainer.svg"
                                               alt="instructor">
                    </div>
                    <div class="col-md-9 pl-md-5  text-white">
                        <h1 class="font-dubai-bold count">250</h1>
                        <h5 class="font-dubai">Trainers</h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 disflexmd col-6 mb-4">
                <div class="row">
                    <div class="col-md-3"><img src="<?= base_url() ?>assets/home/img/vector/student.svg"
                                               alt="instructor">
                    </div>
                    <div class="col-md-9 pl-md-5  text-white">
                        <h1 class="font-dubai-bold count">1004</h1>
                        <h5 class="font-dubai">Students</h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 disflexmd col-6 mb-4">
                <div class="row">
                    <div class="col-md-3"><img src="<?= base_url() ?>assets/home/img/vector/subjects.svg"
                                               alt="instructor">
                    </div>
                    <div class="col-md-9 ds-pl-md-5  text-white">
                        <h1 class="font-dubai-bold count">55</h1>
                        <h5 class="font-dubai">Subjects</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="ds-grey">
    <div class="container">
        <!--    our latest services-->
        <div class="row py-md-3">
            <div class="col-md-12 text-center py-md-5">
                <h2 class="text-uppercase ds-pt-5 font-weight-bold ds-section-sub-tilte">OUR LATEST SERVICES</h2>
                <section class="responsive slider ds-margin">
                    <div>
                        <div class="card ds-card shadow ds-spl-radius mb-5">
                            <img src="<?= base_url() ?>assets/home/img/vector/conference-amico.svg"
                                 class="w-75 m-auto card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase ds-clr font-dubai-bold">Business Coaching</h5>
                                <button class="btn text-white text-uppercase ds-primary-btn mt-md-3 font-dubai">Book
                                    Now
                                </button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="card ds-card shadow ds-spl-radius mb-5">
                            <img src="<?= base_url() ?>assets/home/img/vector/learning-languages-pana.svg"
                                 class="w-75 m-auto card-img-top"
                                 alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase ds-clr font-dubai-bold">Languages</h5>
                                <button class="btn text-white text-uppercase ds-primary-btn mt-md-3 font-dubai">Book
                                    Now
                                </button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="card ds-card shadow ds-spl-radius mb-5">
                            <img src="<?= base_url() ?>assets/home/img/vector/mask-group-14.svg"
                                 class="w-75 m-auto card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase ds-new-padding ds-clr font-dubai-bold">Yoga</h5>
                                <button class="btn text-white text-uppercase ds-primary-btn mt-md-3 font-dubai">Book
                                    Now
                                </button>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="card ds-card shadow ds-spl-radius mb-5">
                            <img src="<?= base_url() ?>assets/home/img/vector/conference-amico.svg"
                                 class="w-75 m-auto card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase ds-clr font-dubai-bold">Business Coaching</h5>
                                <button class="btn text-white text-uppercase ds-primary-btn mt-md-3 font-dubai">Book
                                    Now
                                </button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="card ds-card shadow ds-spl-radius mb-5">
                            <img src="<?= base_url() ?>assets/home/img/vector/learning-languages-pana.svg"
                                 class="w-75 m-auto card-img-top"
                                 alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase ds-clr font-dubai-bold">Languages</h5>
                                <button class="btn text-white text-uppercase ds-primary-btn mt-md-3 font-dubai">Book
                                    Now
                                </button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="card ds-card shadow ds-spl-radius mb-5">
                            <img src="<?= base_url() ?>assets/home/img/vector/mask-group-14.svg"
                                 class="w-75 m-auto card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title ds-new-padding text-uppercase ds-clr font-dubai-bold">Yoga</h5>
                                <button class="btn text-white text-uppercase ds-primary-btn mt-md-3 font-dubai">Book
                                    Now
                                </button>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
        <!--   &  our latest services-->


    </div>
</div>
<div class="container">
    <!--    Instructors-->
    <div class="row my-5">
        <div class="col-md-12 text-center py-md-4">
            <h2 class="text-uppercase font-weight-bold ds-section-sub-tilte">Meet Our Instructors</h2>
            <section class="responsive slider ds-margin">
                <div>
                    <div class="card ds-card ds-ins-card mb-4 ds-spl-radius shadow-sm">
                        <img src="<?= base_url() ?>assets/home/img/raster/lina.svg" class="w-75 p-4 m-auto card-img-top"
                             alt="...">
                        <div class="card-body pt-0">
                            <h5 class="card-title ds-clr font-dubai-bold">Ms. Lina</h5>
                            <p class="font-dubai card-text">Fitness Trainer</p>
                            <button class="btn font-dubai ds-warning-read-btn mt-md-1">Read More</button>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card ds-card ds-ins-card mb-4 ds-spl-radius shadow-sm">
                        <img src="<?= base_url() ?>assets/home/img/raster/jone-lyvyo.svg"
                             class="w-75 p-4 m-auto card-img-top" alt="...">
                        <div class="card-body pt-0">
                            <h5 class="card-title ds-clr font-dubai-bold">Mr. Jone</h5>
                            <p class="font-dubai card-text">Math Teacher</p>
                            <button class="btn font-dubai ds-warning-read-btn mt-md-1">Read More</button>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card ds-card ds-ins-card mb-4 ds-spl-radius shadow-sm">
                        <img src="<?= base_url() ?>assets/home/img/raster/maria-lyvyo.svg"
                             class="w-75 p-4 m-auto card-img-top" alt="...">
                        <div class="card-body pt-0">
                            <h5 class="card-title ds-clr font-dubai-bold">Ms. Maria</h5>
                            <p class="font-dubai card-text">H.I.I.T Trainer</p>
                            <button class="btn font-dubai ds-warning-read-btn mt-md-1">Read More</button>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="card ds-card ds-ins-card mb-4 ds-spl-radius shadow-sm">
                        <img src="<?= base_url() ?>assets/home/img/raster/lina.svg" class="w-75 p-4 m-auto card-img-top"
                             alt="...">
                        <div class="card-body pt-0">
                            <h5 class="card-title ds-clr font-dubai-bold">Ms. Lina</h5>
                            <p class="font-dubai card-text">Fitness Trainer</p>
                            <button class="btn font-dubai ds-warning-read-btn mt-md-1">Read More</button>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card ds-card ds-ins-card mb-4 ds-spl-radius shadow-sm">
                        <img src="<?= base_url() ?>assets/home/img/raster/jone-lyvyo.svg"
                             class="w-75 p-4 m-auto card-img-top" alt="...">
                        <div class="card-body pt-0">
                            <h5 class="card-title ds-clr font-dubai-bold">Mr. Jone</h5>
                            <p class="font-dubai card-text">Math Teacher</p>
                            <button class="btn font-dubai ds-warning-read-btn mt-md-1">Read More</button>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card ds-card ds-ins-card mb-4 ds-spl-radius shadow-sm">
                        <img src="<?= base_url() ?>assets/home/img/raster/maria-lyvyo.svg"
                             class="w-75 p-4 m-auto card-img-top" alt="...">
                        <div class="card-body pt-0">
                            <h5 class="card-title ds-clr font-dubai-bold">Ms. Maria</h5>
                            <p class="font-dubai card-text">H.I.I.T Trainer</p>
                            <button class="btn font-dubai ds-warning-read-btn mt-md-1">Read More</button>
                        </div>
                    </div>
                </div>


            </section>
        </div>


    </div>
    <!--   &  Instructors-->
</div>


<!--    testimonial-->
<div class="ds-timg">
    <div class="container py-md-4">
        <div id="demo" class="carousel slide" data-ride="carousel">

            <div class="carousel-inner">
                <div class="row pt-5">
                    <div class="col-md-12 text-center text-white">
                        <h4 class="ds-letter-spacing font-dubai">What Our Happy Clients say about us</h4>
                        <h2 class="font-dubai-bold ds-mbl-font">WHAT OUR CLIENTS ARE SAYING</h2>
                        <img src="<?= base_url() ?>assets/home/img/png/carousel_inner.svg" alt="image">
                    </div>
                </div>
                <div class="carousel-item active">
                    <div class="carousel-caption">
                        <img class="my-3" src="<?= base_url() ?>assets/home/img/vector/testimonial.svg">
                        <p class="font-dubai">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua.
                            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                            commodo consequat.
                            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>
                        <div class="image-caption font-dubai-bold">Lena Jone
                        </div>
                        <p class="small font-dubai">Facebook</p>

                    </div>
                </div>

                <div class="carousel-item">
                    <div class="carousel-caption">
                        <img class="my-3" src="<?= base_url() ?>assets/home/img/vector/testimonial.svg">
                        <p class="font-dubai">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua.
                            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                            commodo consequat.
                            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>
                        <div class="image-caption font-dubai-bold">Lena Jone
                        </div>
                        <p class="small">Facebook</p>

                    </div>
                </div>

                <div class="carousel-item">
                    <div class="carousel-caption">
                        <img class="my-3" src="<?= base_url() ?>assets/home/img/vector/testimonial.svg">
                        <p class="font-dubai">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua.
                            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                            commodo consequat.
                            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>
                        <div class="image-caption font-dubai-bold">Lena Jone
                        </div>
                        <p class="small">Facebook</p>

                    </div>
                </div>

            </div>
            <a class="carousel-control-prev" href="#demo" data-slide="prev"> <i class='fa fa-arrow-left'></i> </a> <a
                    class="carousel-control-next" href="#demo" data-slide="next"> <i class='fa fa-arrow-right'></i> </a>
        </div>
    </div>
</div>
<!--& testimonial-->

<!--    blog-->
<div class="container">
    <div class="row ds-my-5">
        <div class="col-md-6">
            <span class="text-secondary font-dubai">From our news</span>
            <h3 class="ds-h3-clr font-dubai-bold pb-4">OUR LATEST NEWS</h3>

            <p class="bg-warning p-2 font-dubai text-white">NEWS TITLE</p>
            <a href="#"> <img class="img-fluid" src="<?= base_url() ?>assets/home/img/vector/business-coaching-2.svg"
                              alt="business coaching"></a>
            <div class="d-flex pt-3 pt-2s">
                <img class="ds-w16" src="<?= base_url() ?>assets/home/img/vector/calendar.svg" alt="calendar">
                <span class="pl-3 font-dubai">June 14, 2021</span>
            </div>

            <p class="small d-block font-dubai pt-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore
                et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor sit amet, consectetur adipiscing
                elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam. Lorem ipsum dolor
                sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                aliqua. sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. sed do eiusmod tempor
                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam..</p>
            <a href="#" class="ds-main-clr my-2 font-dubai">READ MORE <i class="fa pl-2 pt-0 fa-angle-double-right"
                                                                         aria-hidden="true"></i>
            </a>
        </div>
        <div class="col-md-6">
            <span class="text-secondary font-dubai">From our blog</span>
            <h3 class="ds-h3-clr pb-4 font-dubai-bold">RECENT POSTS</h3>
            <div class="card mt-0 border-0 mb-3 mb-md-0">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        <img src="<?= base_url() ?>assets/home/img/vector/online-yoga.svg"
                             class="img-fluid ds-height-100" alt="online yoga">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body pt-0 pl-0 pt-2 pt-md-0 pl-md-2">
                            <h5 class="card-title my-0 ds-post-title font-dubai-bold">YOGA SESSION</h5>
                            <div class="d-flex my-lg-2 pt-2s">
                                <img class="ds-w16" src="<?= base_url() ?>assets/home/img/vector/calendar.svg"
                                     alt="calendar">
                                <span class="font-dubai pl-3">June 14, 2021</span>
                            </div>
                            <p class="small font-dubai ds-mb0">Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
                            <a href="#" class="ds-main-clr my-2 font-dubai ">READ MORE <i
                                        class="fa pl-2 fa-angle-double-right pt-0" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-0 border-0 mb-3 mb-md-0">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        <img src="<?= base_url() ?>assets/home/img/icon/girl-workout.svg"
                             class="img-fluid ds-height-100" alt="online yoga">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body pt-0 pl-0 pt-2 pt-md-0 pl-md-2">
                            <h5 class="card-title my-0 ds-post-title font-dubai-bold">YOGA SESSION</h5>
                            <div class="d-flex my-lg-2 pt-2s">
                                <img class="ds-w16" src="<?= base_url() ?>assets/home/img/vector/calendar.svg"
                                     alt="calendar">
                                <span class="font-dubai pl-3">June 14, 2021</span>
                            </div>
                            <p class="small font-dubai ds-mb0">Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
                            <a href="#" class="ds-main-clr my-2 font-dubai">READ MORE <i
                                        class="fa pl-2 fa-angle-double-right pt-0" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-0 border-0 mb-3 mb-md-0">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        <img src="<?= base_url() ?>assets/home/img/icon/business-coaching.svg"
                             class="img-fluid ds-height-100" alt="online yoga">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body pt-0 pl-0 pt-2 pt-md-0 pl-md-2">
                            <h5 class="card-title my-0 ds-post-title font-dubai-bold">YOGA SESSION</h5>
                            <div class="d-flex my-lg-2 pt-2s">
                                <img class="ds-w16" src="<?= base_url() ?>assets/home/img/vector/calendar.svg"
                                     alt="calendar">
                                <span class="font-dubai pl-3">June 14, 2021</span>
                            </div>
                            <p class="small font-dubai ds-mb0">Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
                            <a href="#" class="ds-main-clr my-2 font-dubai">READ MORE <i
                                        class="fa pl-2 fa-angle-double-right pt-0" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<!-- & blog-->

<?php include 'includes/footer.php'; ?>


<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/home/js/toast.js">

<?php include 'includes/footer-links.php'; ?>
<?php include 'includes/subscribe-newsletter.php'; ?>

<script src="<?= base_url() ?>assets/home/js/slick.js" type="text/javascript" charset="utf-8"></script>

<script>
    $('.responsive').slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

</script>
<script>

    var a = 0;

    $(window).scroll(function () {
        var oTop = $('.counterHeight').offset().top - window.innerHeight;
        if (a == 0 && $(window).scrollTop() > oTop) {

            $('.count').each(function () {
                var countOnScroll = $(this).offset().top;
                console.log(countOnScroll)
                $(this).prop('Counter', 0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 4000,
                    easing: 'swing',
                    step: function (now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });
            a = 1;
        }
    })


    $(() => {
        let winw = $(window).width()
        // alert(winw)
    })


    $(function () {
        $(window).resize(function () {
            callmelater()
        });

        function callmelater() {
            var testd = $(".sdfdsfds").offset();
            var testdd = testd.left - 15
            $(".ds-posabs").css({"width": testdd})
            // alert(testdd)


            $(".ds-add-cw > a").hover(function () {
                var education = $(this).offset()
                var educationleft = education.left + 4
                $(".ds-posabs").css("width", educationleft)
            }, function () {
                $(".ds-posabs").css("width", testdd)

            })

            $(".ull-me").hover(function () {
                $(this).prev().css({
                    'background': '#1339BE',
                    'color': '#fff',
                })
            }, function () {
                $(this).prev().css({
                    'color': '#1339BE',
                    'background': '#fff',
                })
            })

            $(".dsspll").hover(function () {
                var education = $(this).prev().offset()
                var educationleft = education.left + 4
                $(".ds-posabs").css("width", educationleft)
            }, function () {
                $(".ds-posabs").css("width", testdd)
            })
        }

        callmelater()
    })


    $(window).scroll(function () {
        var $this = $(this),
            $head = $('#justhead');
        if ($this.scrollTop() > 120) {
            $head.addClass('fixed-top shadow navbar-white bg-white');
            $('.ds-relative-r-71').css("padding-top", "14%")
        } else {
            $head.removeClass('fixed-top shadow navbar-white bg-white');
            $('.ds-relative-r-71').css("padding-top", "unset")
        }
    });


</script>


</body>
</html>