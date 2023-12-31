<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/hr.css">
    <link rel="icon" type="image/png" href="<?= base_url()?>assets/home/img/logo/favicon.png">
    <title>Register</title>
</head>
<body>
<!-- Section 1 -->
<div class="container pt-5">
    <div class="row">
        <div class="col-md-4 col-5">
            <img src="<?= base_url() ?>assets/home/img/png/Logo.svg" class="img-fluid">
        </div>
        <div class="col-md-8 pt-md-2 col-7 js-footer-p text-right">
            <h6 class="hr-font-size hr-text-primary font-dubai">Already a member?</h6>
            <a href="<?= base_url('login') ?>">
                <button class="btn hr-blue-btn font-dubai">LOG IN</button>
            </a>
        </div>
    </div>
    <div class=" text-center pt-5">
        <h2 class="hr-ch-register new-clr dshrlh font-dubai-bold">CHOOSE YOUR ACCOUNT</h2>
        <h6 class="text-secondary hr-ch-register-sub fdl">Register as instructor or learner</h6>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6 pr-0 text-center ">
                    <a href="<?= base_url('register-as-instructor')?>">
                        <img src="<?= base_url()?>assets/home/img/png/instructor.svg"
                                                               class="hr-img-width instructorHover"
                                                               data-src="<?= base_url()?>assets/home/img/png/register/hoverins.svg"></a>
                    <h4 class="hr-footer posreten new-lh fdm mr-md-3">INSTRUCTOR</h4>
                </div>
                <div class="col-md-6 pl-0 text-center">
                    <a href="<?= base_url('register-as-learner')?>"><img src="<?= base_url()?>assets/home/img/png/learner.svg"
                                                            class="hr-img-width instructorHover"
                                                            data-src="<?= base_url()?>assets/home/img/png/register/hoverlearn.svg"></a>
                    <h4 class="hr-footer posreten new-lh fdm mr-md-3">
                        LEARNER
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="hr-reg-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h6 class="text-white h6-js-footer font-dubai">Copyright © 2020 <span
                        class="aristotelica">LYVYO.COM</span> All rights reserved.</h6>
            </div>
            <div class="col-md-3">
                <div class="float-right">
                    <a href="javascript:void(0)" class="text-white font-dubai" style="text-decoration: none"> Terms of
                        use</a>&nbsp;
                    <a href="javascript:void(0)" class="text-white font-dubai" style="cursor:auto">|</a>&nbsp;
                    <a href="javascript:void(0)" class="text-white font-dubai" style="text-decoration: none">Privacy
                        Policy</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="<?= base_url()?>assets/home/js/bootstrap.bundle.js"></script>
<script>
    $(document).ready(function () {
        let img = ''
        let src = ''
        $(".instructorHover").hover(function () {
            img = $(this).attr('data-src')
            src = $(this).attr('src')
            $(this).attr('src', img);
        }, function () {
            $(this).attr('src', src);
        });
    });
</script>
</body>
</html>