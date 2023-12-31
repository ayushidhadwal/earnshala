<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/js.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/hr.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/ds.css">
    <link rel="icon" type="image/png" href="<?= base_url()?>assets/home/img/logo/EarnShalaSmall.png">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Login</title>
    <style type="text/css">
    .field-icon {
          float: right;
          margin-left: -25px;
          margin-top: -35px;
          position: relative;
          z-index: 2;
          padding-right: 19px;
          color: #817d7d;
    }
</style>
</head>
<body >
<div class="row mx-0 flex-column-reverse flex-lg-row justify-content-center">
    <!-- <div class="col-md-12 col-lg-6 ds-100vh" > -->
    <div class="col-md-12 col-lg-6 " style="background-color:#023548;" >
        <div class="row text-center pt-xl-5">
            <div class="col-md-12">
                <h1 class="text-white mb-0 ds-text-shadow aristotelica font-weight-bold">WELCOME TO <span class="aristotelica">EARN<span style="color:#DB9508;">SHALA</span></h1>
                <h4 class="text-white aristotelica-text font-weight-light">Connecting Minds</h4>
            </div>
        </div>
        <div class="text-center"><img src="<?= base_url()?>assets/home/img/png/Account.png" class="img-fluid" style="height: 70%;width: 75%;" /></div>
    </div>

    <div class="col-md-12 col-lg-6 height-100vh">
        <img src="<?= base_url('assets/home/')?>img/logo/EarnShalaAdmin.png" alt="" class="mx-auto d-block mt-2" style="width: 25%;height: 20%">
        <h3 class="text-center hr-text-dark aristotelicam mt-2">EARN<span style="color:#DB9508;">SHALA</span></h3>
        <h6 class="text-center text-secondary font-weight-normal">Please login to continue using our services</h6>
        <div class="container pt-xl-2" style="padding-left: 15%;padding-right: 15%">
          <div class="row">
            <div class="col-md-12 text-center">
              <!-- <?php print_r($_SESSION); ?> -->
              <?php if ($this->session->flashdata('error_message')): ?>
                <div class="alert alert-danger alert-remove" style="padding: 0.35rem 1.25rem;">
                  <?php echo $this->session->flashdata('error_message'); ?>
                </div>
              <?php endif ?>
              <?php if ($this->session->flashdata('flash_message')): ?>
                <div class="alert alert-success alert-remove" style="padding: 0.35rem 1.25rem;">
                  <?php echo $this->session->flashdata('flash_message'); ?>
                </div>
              <?php endif ?>

            </div>
          </div>
          <form action="<?php echo site_url('login/validate_login/user'); ?>" method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" placeholder="Email" name="email" class="hr-input-control form-control">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="password" placeholder="Password" name="password" class="hr-input-control form-control psbtn">
                        <span  class="fa fa-eye toggle-password field-icon" style="cursor: pointer;"></span>

                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-4 dsd-mt-4">
                <div class="col-md-12">
                    <button class="btn hr-btn-primary btn-block" type="submit" style="background-color:#023548;">
                        <span class="js-reigster">Log in</span>
                    </button>
                </div>
                <div class="col-md-12 text-center mt-3">
                    <h6 class="hr-text-secondary mt-3" style="font-size:12px">Copyright © 2022 <span class="">earnshalaadmin.com</span> All rights reserved.</h6>
                </div>
            </div>
          </form>
        </div>
    </div>
</div>
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  $(function() {
    setTimeout(() => {
      $('.alert-remove').hide('slow/400/fast');
    }, 2500)
  })
</script>
<script type="text/javascript">
    $(document).ready(function(){

            $(".toggle-password").click(function() {

              $(this).toggleClass("fas fa-eye-slash");
              var input = $('.psbtn');
              if (input.attr("type") == "password") {
                input.attr("type", "text");
              } else {
                input.attr("type", "password");
              }
            });
    })
</script>

