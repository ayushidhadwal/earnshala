<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/js.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/hr.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/ds.css">
    <link rel="icon" type="image/png" href="<?= base_url()?>assets/home/img/logo/favicon.png">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Email Verify</title>
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
<body>
<div class="row mx-0 flex-column-reverse flex-lg-row justify-content-center">
    <div class="col-md-12 col-lg-6 ds-100vh">
        <div class="row text-center pt-xl-5">
            <div class="col-md-12">
                <h1 class="text-white mb-0 ds-text-shadow aristotelica font-weight-bold">WELCOME TO <span class="aristotelica">LYVYO</span></h1>
                <h4 class="text-white aristotelica-text font-weight-light">Connecting Minds</h4>
            </div>
        </div>
        <div class="text-center"><img src="<?= base_url()?>assets/home/img/png/Account.png" class="img-fluid" style="height: 70%;width: 75%;"></div>
    </div>
    <div class="col-md-12 col-lg-6 height-100vh">
        <img src="<?= base_url()?>assets/home/img/png/Add.png" class="mx-auto d-block" style="width: 30%;height: 27%">
        <h3 class="text-center hr-text-dark aristotelica">LYVYO</h3>
        <h6 class="text-center text-secondary font-weight-normal">Please login to continue using our services</h6>
        <div class="container pt-xl-2" style="padding-left: 15%;padding-right: 15%">
          <div class="row">
            <div class="col-md-12">
              <!-- <?php print_r($_SESSION); ?> -->
              
                <div class="errorAlert" style="padding: 0.35rem 1.25rem;">
                  
                </div>
              
            </div>
          </div>
         
            
           
            
            <div class="row justify-content-center mt-4 dsd-mt-4">
              <div class="col-md-12">
                <div class="card shadow" style="border: 1px solid whitesmoke;padding: 0 20px;box-shadow: 10px 10px 0px 0px whitesmoke;">
                    <div class="card-header">
                      <h3>Verify Your Email Account</h3>
                    </div>
                    <div class="card-body">
                        <form class="otpverify">
                            <div class="form-group text-left">
                                <label for="username">OTP:</label>
                                <input type="number" class="form-control" maxlength="6" minlength="6" id="otp" name="otp" placeholder="Enter OTP" />
                                <input type="hidden" name="register_id" value="<?= $register_id ?>">
                            </div>
                            <div class="form-group">
                                <button class="btn hr-btn-primary btn-block" type="submit">
                                <span class="js-reigster">Verify</span>
                            </button>
                            </div>
                             

                            <a href="javascript:void(0)" class="text-right resendOtp" data-id="<?= $register_id ?>"><small
                                                style="float: right">Resend OTP</small></a>
                        </form>
                    </div>
                </div>
              </div>
               
                </div>
            </div>
       
        </div>
    </div>
</div>
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- <script>
  $(function() {
    setTimeout(() => {
      $('.alert-remove').hide('slow/400/fast');
    }, 2500)
  })
</script> -->
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
<script type="text/javascript">
  $(document).ready(function(){

      $('.otpverify').on('submit', function(e){

          e.preventDefault()

          let fd = new FormData(this)

          $.ajax({
                  url: "<?= base_url('otp-verify') ?>",
                  type: "POST",
                  processData: false,
                  contentType: false,
                  dataType: "json",
                  data: fd,
                  success: function (result) {

                        if(result.status)
                        {
                          window.location.href = result.location;
                        }
                        else
                        {
                          $('.errorAlert').html(`<span class="alert alert-danger alert-remove">${result.msg}</span>`);
                          setTimeout(() => {
                            $('.errorAlert').html('');
                          }, 3000)

                        }
                        
                     
                  }, error: function (jqXHR, exception) {
                      console.log(jqXHR.responseText)
                  }
              })



      })

      $('.resendOtp').on('click', function(e){

          e.preventDefault()

         

          let register_id = $(this).attr('data-id');

          $.ajax({
                  url: "<?= base_url('resend-otp') ?>",
                  type: "POST",
                  dataType: "json",
                  data: {'register_id':register_id},
                  success: function (result) {

                        if(result.status)
                        {
                          $('.errorAlert').html(`<span class="alert alert-success">${result.msg}</span>`);
                        }
                        else
                        {
                          $('.errorAlert').html(`<span class="alert alert-danger">${result.msg}</span>`);
                         
                        }
                         setTimeout(() => {
                            $('.errorAlert').html('');
                          }, 3000)
                        
                     
                  }, error: function (jqXHR, exception) {
                      console.log(jqXHR.responseText)
                  }
              })



      })


  })
</script>

<!-- <?php if ($this->session->flashdata('error_message')): ?>
  <script>
  $(function() {
    $('.alert-success').hide('slow/400/fast');
    $('.alert-alert').show('slow/400/fast');
  })
</script>
<?php endif ?>
<?php if ($this->session->flashdata('flash_message')): ?>
  <script>
  $(function() {
    $('.alert-success').show('slow/400/fast');
    $('.alert-alert').hide('slow/400/fast');
  })
</script>
<?php endif ?> -->