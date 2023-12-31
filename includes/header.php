<!--mobile ipad-->
<div class="ds-nav-clr hidemeee">
    <div class="container py-sm-1">
        <div class="row align-items-center">
            <div class="col-md-6 col-8">
                <ul class="ds-ul-top">
                    <li class="">
                        <a href="#" class="text-decoration-none text-white">
                            <img class="img-fluid ds-si-a" src="<?= base_url()?>assets/home/img/icon/phone.svg" alt=""> </a>
                    </li>
                    <li class="pl-3">
                        <a class="text-decoration-none text-white" href="#">
                            <img class="img-fluid ds-si-a" src="<?= base_url()?>assets/home/img/icon/mail.svg" alt=""></a>
                    </li>

                </ul>


            </div>
            <div class="col-md-6 col-4">
                <div class="d-flex justify-content-end align-items-center">
                    <a href="#"><img class="ds-si-new" src="<?= base_url()?>assets/home/img/icon/social/TW.png" alt=""></a>
                    <a href="#"><img class="ds-si-new" src="<?= base_url()?>assets/home/img/icon/social/YT.png" alt=""></a>
                    <a href="#"><img class="ds-si-new" src="<?= base_url()?>assets/home/img/icon/social/S.png" alt=""></a>
                    <a href="#"><img class="ds-si-new" src="<?= base_url()?>assets/home/img/icon/social/INS.png" alt=""></a>
                    <a href="https://www.facebook.com/LYVYO.UAE"><img class="ds-si-new ds-mr-36px" src="<?= base_url()?>assets/home/img/icon/social/FB.png" alt=""></a>
                    <a href="#" class="ds-onclick-e"><span class="ds-po-relative"><img class="ds-po-absolute" src="<?= base_url()?>assets/home/img/icon/top-menu.svg"
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
        <a class="navbar-brand py-md-3 ds-w-180 ds-z-index urlHit" href="<?= base_url('') ?>">

            <!-- <img class="img-fluid" src="<?= base_url()?>assets/home/img/vector/lyvyo-logo.svg" 
                alt=""> -->
             <img class="img-fluid" src="<?= base_url('assets/home/')?>img/logo/EarnShalaAdmin.png" alt="" height="60"> <img class="img-fluid" src="<?= base_url('assets/home/')?>img/logo/EarnShalaAdmin.png" alt="" height="60"> 
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
                    <a class="nav-link ds-link-clr urlHit" href="<?= base_url('education')?>" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Education
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">


                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase active urlHit" href="<?= base_url('education/5')?>#primary-level">Primary Level</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase urlHit" href="<?= base_url('education/7')?>#secondary-level">Secondary Level</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link urlHit" href="<?= base_url('education/6')?>#high-school-level">Highschool Level</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link urlHit" href="<?= base_url('education/8')?>#university-level">University Level</a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <!--  /.container  -->


                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link ds-link-clr urlHit" href="<?= base_url('self-improvement')?>" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        SELF IMPROVEMENT
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">


                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase active urlHit" href="<?= base_url('instructors/64')?>">Life Coaching</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase urlHit" href="<?= base_url('instructors/65')?>">Business Coaching</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase urlHit" href="<?= base_url('instructors/66')?>">Family/Marriage Counselling</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase urlHit" href="<?= base_url('instructors/67')?>">Substance Abuse Counselling</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase urlHit" href="<?= base_url('instructors/68')?>">Mindfulness Based
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
                    <a class="nav-link ds-link-clr urlHit" href="<?= base_url('fitness')?>" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        FITNESS
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">


                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase active urlHit" href="<?= base_url('instructors/11')?>">Yoga</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase urlHit" href="<?= base_url('instructors/12')?>">Zumba</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase urlHit" href="<?= base_url('instructors/13')?>">Aerobics</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase urlHit" href="<?= base_url('instructors/14')?>">H.I.I.T</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-uppercase urlHit" href="<?= base_url('instructors/15')?>">Circuit Training</a>
                                        </li>

                                    </ul>
                                </div>

                            </div>
                        </div>
                        <!--  /.container  -->


                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link ds-link-clr urlHit" href="<?= base_url('courses')?>">
                        COURSES
                    </a>
                    
                </li>

                <li class="nav-item dropdown ">
                    <a class="nav-link ds-link-clr border-right-js urlHit" href="<?= base_url('faq')?>" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        FAQ
                    </a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <!--                   <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">-->
                <!--                   <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>-->
                <!--                hellow-->
                <?php if($this->session->userdata('user')){ ?>
                    <div class="d-flex posre ds-bdr-left">
                    <img class="ds-user-login" src="<?php echo $this->user_model->get_user_image_url($this->session->userdata('user_id')); ?>" alt="loggedin user">
                    <div class="form-group mb-0">
                       <select class="form-control ds-select-user ds-outline-warning-btn" onchange="location = this.value;">
                            <option value=""><?= $this->session->userdata('name') ?></option>
                            <option value="<?= base_url('home/profile/user_profile') ?>">User Profile</option>
                            <option value="<?= base_url('home/profile/user_credentials') ?>">Account</option>
                            <option>Notifications</option>
                            <option value="<?- base_url('home/profile/user_credentials') ?>">Settings</option>
                            <option value="<?= base_url('login/logout') ?>">Logout</option>
                        </select>
                    </div>
                </div>
                <?php }else{ ?>

                <button type="button" class="ds-warning-white-btn btn text-uppercase text-white" onclick="window.location.href='<?= base_url('login') ?>'">Log In</button>
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
                <img class="img-fluid ds-si-a" src="<?= base_url()?>assets/home/img/icon/phone.svg" alt="">
                <img class="img-fluid ml-md-3 ds-si-a dskkiii" src="<?= base_url()?>assets/home/img/icon/mail.svg" alt="">
            </div>
            <div class="col-md-3 pl-0">

            </div>
            <div class="col-md-6 pr-0 text-right">
                <a href="#"><img class="ds-si-new" src="<?= base_url()?>assets/home/img/icon/social/TW.png" alt=""></a>
                <a href="#"><img class="ds-si-new" src="<?= base_url()?>assets/home/img/icon/social/YT.png" alt=""></a>
                <a href="#"><img class="ds-si-new" src="<?= base_url()?>assets/home/img/icon/social/S.png" alt=""></a>
                <a href="#"><img class="ds-si-new" src="<?= base_url()?>assets/home/img/icon/social/INS.png" alt=""></a>
                <a href="https://www.facebook.com/LYVYO.UAE"><img class="ds-si-new ds-mr-36px" src="<?= base_url()?>assets/home/img/icon/social/FB.png" alt=""></a>
                <a href="#"><span class="ds-po-relative"><img class="ds-po-absolute" src="<?= base_url()?>assets/home/img/icon/top-menu.svg"
                                                              alt="">
                    <a href="#" class="ds-onclick-e"><span class="ds-po-relative"><img class="ds-po-absolute"
                                                                                       src="<?= base_url() ?>assets/home/img/icon/top-menu.svg"
                                                                                       alt="">
                    <ul class="ds-lang-d" style="display: none;">
                       <?php foreach($countrys as $cey => $cntry): ?>
                        <li><?= $cntry->countries_name ?></li>
                        <?php endforeach; ?>
                    </ul>
                    </span>
                </a></span></a>
            </div>
        </div>
    </div>
</div>
<ul id="justhead" class="ull-me">
    <div class="ds-posabs"></div>
    <div class="container ">
        <div class="row">
            <div class="col-md-3 ds-col-md-3 my-auto">
                <a href="<?= base_url() ?>" class="urlHit"><img class="img-fluid pr-1 dspt-2" src="<?= base_url()?>assets/home/img/logo/EarnShalaAdmin.png" alt=""></a>
            </div>
            <div class="col-md-9 sdfdsfds ds-col-md-9 pl-0 text-right">
                <li class="ds-add-cw">
                    <a href="<?= base_url('education')?>" class="ds-header-top-font urlHit">Education</a>
                    <ul class="dropdown py-5 ull-me fixmi dsspll">
                        <div class="container">
                            <div class="row mx-0 applyme text-left">
                                <div class="col-md-12 px-0 ds-border-btm pb-2"><a href="<?= base_url('education')?>" class="font-dubai-bold ds-align urlHit">Education</a>
                                </div>
                                <div class="col-md-12 pt-4 pb-5 px-0">
                                    <div class="row pb-5">
                                        <div class="col-md-3"><a href="<?= base_url('education/5')?>#primary-level" class="ds-align urlHit">Primary Level</a></div>
                                        <div class="col-md-3"><a href="<?= base_url('education/7')?>#secondary-level" class="ds-align urlHit">Secondary Level</a></div>
                                        <div class="col-md-3"><a href="<?= base_url('education/6')?>#high-school-level" class="ds-align urlHit">Highschool Level</a>
                                        </div>
                                        <div class="col-md-3 text-right" class="ds-align"><a href="<?= base_url('education/8')?>#university-level" class="ds-align urlHit">University Level</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>
                </li>
                <li>
                    <a href="<?= base_url('self-improvement')?>" class="ds-header-top-font urlHit">Self Improvement</a>
                    <ul class="dropdown py-5 ull-me fixmi">
                        <div class="container">
                            <div class="row mx-0 applyme">
                                <div class="col-md-12 px-0 ds-border-btm pb-2">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <a href="<?= base_url('self-improvement')?>" class="font-dubai-bold font-weight-bold ds-align urlHit">Self
                                                Improvement</a></div>
                                        <div class="col-md-4">
                                            <a href="<?= base_url('self-improvement')?>" class="font-dubai-bold font-weight-bold ds-align urlHit">Counselling</a></div>
                                    </div>
                                </div>
                                <div class="col-md-12 pt-4 pb-5 px-0">
                                    <div class="row pb-5">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-8 ds-height-120 border-right">
                                                    <div class="row">
                                                        <div class="col-md-12 pb-4"><a href="<?= base_url('instructors/64')?>" class="ds-align urlHit">Life Coaching</a>
                                                        </div>
                                                        <div class="col-md-12 pb-4"><a href="<?= base_url('instructors/65')?>" class="ds-align urlHit">Business
                                                            Coaching</a></div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-12 pb-4"><a href="<?= base_url('instructors/66')?>" class="ds-align urlHit">Family/Marriage
                                                    Counselling</a></div>
                                                <div class="col-md-12 pb-4"><a href="<?= base_url('instructors/67')?>" class="ds-align urlHit">Substance Abuse
                                                    Counselling</a></div>
                                                <div class="col-md-12 pb-4"><a href="<?= base_url('instructors/68')?>" class="ds-align urlHit">Mindfulness Based
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
                    <a href="<?= base_url('fitness')?>" class="ds-header-top-font urlHit">Fitness</a>
                    <ul class="dropdown py-5 ull-me fixmi">
                        <div class="container">
                            <div class="row mx-0 applyme">
                                <div class="col-md-12 px-0 ds-border-btm pb-2"><a href="<?= base_url('fitness')?>"
                                                                                  class="font-dubai-bold ds-align urlHit">Fitness</a>
                                </div>
                                <div class="col-md-12 pt-4 pb-5 px-0">
                                    <div class="row pb-5">
                                        <div class="col-md-2 pb-4"><a href="<?= base_url('instructors/11')?>" class="ds-align urlHit">Yoga</a></div>
                                        <div class="col-md-2 pb-4"><a href="<?= base_url('instructors/12')?>" class="ds-align urlHit">Zumba</a></div>
                                        <div class="col-md-2 pb-4"><a href="<?= base_url('instructors/13')?>" class="ds-align urlHit">Aerobics</a></div>
                                        <div class="col-md-2 pb-4"><a href="<?= base_url('instructors/14')?>" class="ds-align urlHit">H.I.I.T</a></div>
                                        <div class="col-md-2 pb-4"><a href="<?= base_url('instructors/15')?>" class="ds-align urlHit">Circuit Training</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>
                </li>
                <li>
                    <a href="<?= base_url('courses') ?>" class="ds-header-top-font ds-course-eff urlHit" style="color: #1339BE !important;">Courses</a>
                    
                </li>

                <li><a href="<?= base_url('faq') ?>" class="ds-header-top-font ds-faq urlHit">faq</a></li>
               <?php
                        if ($this->session->userdata('user_login')) { ?>
                            <li class="">
                                <div class="d-flex posre ds-bdr-left">
                                    <img class="ds-user-login" src="<?php echo $this->user_model->get_user_image_url($this->session->userdata('user_id')); ?>" alt="loggedin user">
                                    <div class="form-group mb-0">
                                        <select class="form-control ds-select-user ds-outline-warning-btn" id=""  onchange="location = this.value;">
                                            <option value=""><?= $this->session->userdata('name') ?></option>
                                            <option value="<?= base_url('home/profile/user_profile') ?>">User Profile</option>
                                            <option value="<?= base_url('home/profile/user_credentials') ?>">Account</option>
                                            <option>Notifications</option>
                                            <option value="<?= base_url('home/profile/user_credentials') ?>">Settings</option>
                                            <option value="<?= base_url('login/logout') ?>">Logout</option>
                                        </select>
                                    </div>
                                </div>
                            </li>
                           
                      <?php  }else { ?>

                            <li class="ds-target-me">
                                <button type="button" class="ds-warning-white-btn btn text-uppercase text-white" onclick="window.location.href='<?= base_url('login') ?>'">Log In
                                </button>
                            </li>
                     <?php }   ?>
            </div>


        </div>
    </div>

</ul>

