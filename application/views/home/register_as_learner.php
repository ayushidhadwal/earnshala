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
    <title>Register as Learner</title>
    <style>
        body {
            font-family: dubai;
        }
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
<div class="row mx-0 flex-column-reverse flex-lg-row">
    <div class="col-md-12 col-lg-7 pt-4 height-100vh">
        <h1 class="text-center hr-heading font-weight-bold">Create Account</h1>
        <h5 class="text-center hr-subHeading">create your account now and start learning</h5>
       <div class="row">
            <div class="col-md-12">
              
                <div class="errorAlert" style="padding: 0.35rem 1.25rem;">
                  
                </div>
              
            </div>
          </div>
        <div class="container pt-xl-4 px-5">
            <form class="registerFormSubmit" method="post">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <select name="country" class="form-control custom-select hr-select-control" id="country" required>
                            <option value="" selected disabled>Country*</option>
                            <?php foreach($countries as $key => $val): ?>
                                <option value="<?= $val->countries_id?>"><?= $val->countries_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select name="city" class="form-control custom-select hr-select-control" id="state" required>
                            <option value="" selected disabled>City*</option>
                            
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="gender" class="form-control custom-select hr-select-control" required="">
                            <option value="" selected disabled>Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" placeholder="First Name*" name="first_name" class="hr-input-control form-control" required="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" placeholder="Last Name*" name="last_name" class="hr-input-control form-control" required="">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="email" placeholder="Email ID*" name="email" class="hr-input-control form-control" required="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="number" placeholder="Mobile Number*" name="phone" class="hr-input-control form-control" required="">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="password" placeholder="Create Password" name="password" class="hr-input-control form-control psbtn" required="">
                       <span  class="fa fa-eye toggle-password field-icon" style="cursor: pointer;"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="password" placeholder="Confirm Password" name="confirm_password" class="hr-input-control form-control psbtn" required="">
                        <span  class="fa fa-eye toggle-password field-icon" style="cursor: pointer;"></span>
                    </div>
                </div>
                
                <input type="hidden" name="path" value="register-as-learner">
                <input type="hidden" name="instructor" value="0">
            </div>
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-12 dsmt">
                            <button class="btn hr-btn-primary btn-block" type="submit">
                                <span class="js-reigster">REGISTER</span>
                            </button>
                        </div>
                    </div>

                    <svg class="ds-my-3" xmlns="http://www.w3.org/2000/svg" width="auto" height="42" viewBox="0 0 543 42">
                        <g id="Group_1363" data-name="Group 1363" transform="translate(-289.5 -200)">
                            <line id="Line_28" data-name="Line 28" x2="180" transform="translate(289.5 220.5)" fill="none" stroke="#707070" stroke-width="1"/>
                            <line id="Line_29" data-name="Line 29" x2="180" transform="translate(652.5 220.5)" fill="none" stroke="#707070" stroke-width="1"/>
                            <text id="Or_register_with" data-name="Or register with" transform="translate(481 228)" fill="#717070" font-size="25" font-family="Dubai-Regular, Dubai"><tspan x="0" y="0">Or register with</tspan></text>
                        </g>
                    </svg>

<!--                    <img src="img/svg/log-in.svg" alt="Register" style="width: 100%" >-->
                </div>
                <div class="col-md-12">
                    <div class="text-center">
                        <span>
                            <a href="<?= $login_url ?>">
                           <svg class="js-reg-google" xmlns="http://www.w3.org/2000/svg" width="80.051" height="80.051" viewBox="0 0 88.051 88.051">
                              <g id="Group_1353" data-name="Group 1353" transform="translate(0 0)">
                                 <g id="Group_1341" data-name="Group 1341" transform="translate(0 0)">
                                    <path id="Path_2217" data-name="Path 2217" d="M31.131,0A31.131,31.131,0,1,1,0,31.131,31.131,31.131,0,0,1,31.131,0Z" transform="translate(0 44.025) rotate(-45)" fill="#f43d25"/>
                                    <path id="Path_2206" data-name="Path 2206" d="M61.047,280.376a.649.649,0,0,1,0-1.3,35.134,35.134,0,0,0,5.551-.445.649.649,0,0,1,.206,1.281,36.544,36.544,0,0,1-5.756.463Zm11.164-1.8a.649.649,0,0,1-.2-1.264,34.774,34.774,0,0,0,7.544-3.557.648.648,0,1,1,.69,1.1,36.08,36.08,0,0,1-7.827,3.691A.678.678,0,0,1,72.211,278.576Zm-30.819-4.1a.645.645,0,0,1-.358-.108,36.2,36.2,0,0,1-13.368-16.063.648.648,0,1,1,1.194-.507A34.9,34.9,0,0,0,41.751,273.29a.649.649,0,0,1-.359,1.19Zm49.264-10.018a.639.639,0,0,1-.358-.108.647.647,0,0,1-.182-.9,34.767,34.767,0,0,0,5.807-19.29.648.648,0,1,1,1.3,0A36.05,36.05,0,0,1,91.2,264.171.649.649,0,0,1,90.656,264.461Zm-65.2-20.519h-.016a.649.649,0,0,1-.633-.664,36.259,36.259,0,0,1,1.235-8.563.649.649,0,1,1,1.253.338,34.905,34.905,0,0,0-1.191,8.256A.648.648,0,0,1,25.459,243.942Zm68.269-13.087a.649.649,0,0,1-.6-.393,34.709,34.709,0,0,0-2.587-4.927.648.648,0,1,1,1.1-.692,36.06,36.06,0,0,1,2.686,5.11.649.649,0,0,1-.342.852A.657.657,0,0,1,93.728,230.855Zm-65.145-.664a.641.641,0,0,1-.267-.058.648.648,0,0,1-.323-.858,36.365,36.365,0,0,1,2.791-5.058.649.649,0,0,1,1.083.715,34.905,34.905,0,0,0-2.692,4.877A.653.653,0,0,1,28.583,230.191ZM87.69,221.3a.647.647,0,0,1-.487-.22,35.2,35.2,0,0,0-6.221-5.556.648.648,0,0,1,.742-1.063,36.4,36.4,0,0,1,6.453,5.761.649.649,0,0,1-.058.915A.64.64,0,0,1,87.69,221.3Zm-40.6-9.22a.649.649,0,0,1-.254-1.246,35.981,35.981,0,0,1,14.174-2.879,36.521,36.521,0,0,1,6.6.6.648.648,0,0,1-.234,1.276,35.293,35.293,0,0,0-6.362-.578,34.713,34.713,0,0,0-13.666,2.776A.635.635,0,0,1,47.09,212.078Z" transform="translate(-16.985 -200.139)" fill="#f43d25"/>
                                 </g>
                                 <g id="Group_1342" data-name="Group 1342" transform="translate(22.582 29.867)">
                                    <path id="Path_2207" data-name="Path 2207" d="M50.824,237.007c-.006.086-.014.157-.014.225,0,1.728,0,5.466,0,5.466H58.4a6.436,6.436,0,0,1-2.784,4.262,8.139,8.139,0,0,1-4.118,1.323,8.318,8.318,0,0,1-3.071-.357,8.53,8.53,0,0,1-5.839-7.363,8.111,8.111,0,0,1,.172-2.567,8.364,8.364,0,0,1,9.315-6.519,7.643,7.643,0,0,1,4.161,2.007c1.369-1.371,2.725-2.727,4.119-4.124a17.481,17.481,0,0,0-2.508-1.841,13.473,13.473,0,0,0-6.72-1.826c-.451-.007-.9.02-1.354.039a11.141,11.141,0,0,0-2.334.364,14.193,14.193,0,0,0-10.731,12.937,13.384,13.384,0,0,0,.3,3.813,14.018,14.018,0,0,0,5.54,8.464,13.827,13.827,0,0,0,7.56,2.677,14.992,14.992,0,0,0,4.641-.458,12.336,12.336,0,0,0,6.967-4.58,15.187,15.187,0,0,0,2.428-11.941Z" transform="translate(-36.679 -225.69)" fill="#fff"/>
                                    <path id="Path_2208" data-name="Path 2208" d="M75.207,235.909h-4.8v-4.941H66.543v4.941H61.6v3.865h4.939v4.94h3.866v-4.94H75.35v-3.865Z" transform="translate(-30.615 -224.406)" fill="#fff"/>
                                 </g>
                              </g>
                           </svg>
                       </a>
                        </span>
                        <span class="mx-xl-3 mx-1">
                            <a href="<?= $authURL ?>">
                           <svg class="js-reg-face" xmlns="http://www.w3.org/2000/svg" width="80.418" height="80.418" viewBox="0 0 72.418 72.418">
                              <g id="Group_1532" data-name="Group 1532" transform="translate(0 6)">
                                 <g id="Group_1331" data-name="Group 1331" transform="translate(0 -6)">
                                    <path id="Path_2194" data-name="Path 2194" d="M91.148,85.29a31.109,31.109,0,0,1-23.828,30.248,30.152,30.152,0,0,1-7.3.883c-.7,0-1.388-.026-2.075-.078A31.127,31.127,0,1,1,91.148,85.29Z" transform="translate(-23.815 -49.074)" fill="#1e4fad"/>
                                    <path id="Path_2195" data-name="Path 2195" d="M67.6,50.666a37.167,37.167,0,0,0-6.589-.6,36.087,36.087,0,0,0-14.177,2.879.653.653,0,0,0-.337.857.635.635,0,0,0,.6.389.567.567,0,0,0,.246-.052A34.989,34.989,0,0,1,67.366,51.95a.653.653,0,1,0,.234-1.284ZM88.172,62.34a36.283,36.283,0,0,0-6.446-5.76.649.649,0,0,0-.909.157.633.633,0,0,0,.169.9A35.683,35.683,0,0,1,87.2,63.2a.673.673,0,0,0,.494.221.618.618,0,0,0,.428-.169A.627.627,0,0,0,88.172,62.34ZM31.683,66.154a.635.635,0,0,0-.9.182A34.879,34.879,0,0,0,28,71.394a.633.633,0,0,0,.311.855.663.663,0,0,0,.272.052.673.673,0,0,0,.6-.375,33.6,33.6,0,0,1,2.686-4.877A.647.647,0,0,0,31.683,66.154Zm62.637,5.914a34.812,34.812,0,0,0-2.686-5.11.659.659,0,0,0-.9-.208.65.65,0,0,0-.194.9,34.246,34.246,0,0,1,2.581,4.928.677.677,0,0,0,.6.4.84.84,0,0,0,.26-.052A.658.658,0,0,0,94.321,72.068ZM26.845,76.375a.658.658,0,0,0-.8.454,37.44,37.44,0,0,0-1.232,8.561.661.661,0,0,0,.637.674h.012a.657.657,0,0,0,.649-.635A34.741,34.741,0,0,1,27.3,77.165.654.654,0,0,0,26.845,76.375Zm69.733,9.261a.642.642,0,0,0-.648.649,34.764,34.764,0,0,1-5.811,19.287.646.646,0,0,0,.182.9.578.578,0,0,0,.349.1.613.613,0,0,0,.546-.286,36.028,36.028,0,0,0,6.031-20A.651.651,0,0,0,96.577,85.636ZM41.749,115.4A34.911,34.911,0,0,1,28.855,99.918a.643.643,0,0,0-.843-.351.665.665,0,0,0-.351.857,36.309,36.309,0,0,0,13.374,16.071.7.7,0,0,0,.363.1.618.618,0,0,0,.532-.3A.635.635,0,0,0,41.749,115.4Zm38.693.675a.638.638,0,0,0-.9-.208,34.818,34.818,0,0,1-7.537,3.555.649.649,0,0,0-.414.817.665.665,0,0,0,.622.454.515.515,0,0,0,.2-.039,36.359,36.359,0,0,0,7.834-3.684A.651.651,0,0,0,80.442,116.079Zm-13.84,4.67a34.343,34.343,0,0,1-5.551.441.65.65,0,0,0-.649.648.643.643,0,0,0,.649.649,37.072,37.072,0,0,0,5.759-.454.651.651,0,0,0-.208-1.284Z" transform="translate(-24.808 -50.069)" fill="#1e4fad"/>
                                 </g>
                                 <path id="Path_2196" data-name="Path 2196" d="M63.149,76.921c-.052,1.932-.078,6.408-.078,6.408h8.9c-.4,3.087-.792,6.057-1.181,9.04H63.135v20.547a30.152,30.152,0,0,1-7.3.883c-.7,0-1.388-.026-2.075-.078V92.344H46.091V83.329h7.718v-.675c0-1.815-.04-3.619,0-5.434a25.838,25.838,0,0,1,.285-3.464,10.11,10.11,0,0,1,4.047-6.731,11.709,11.709,0,0,1,6.745-2.076c1.6-.039,3.179.04,4.774.1.869.052,1.738.169,2.555.246v8.068H71.58c-1.557,0-3.1-.039-4.657.014C64.8,73.457,63.226,74.262,63.149,76.921Z" transform="translate(-19.631 -52.451)" fill="#fff" fill-rule="evenodd"/>
                              </g>
                           </svg>
                       </a>
                       
                        </span>
                        <span class="mx-1">
                           <svg class="js-reg-link" xmlns="http://www.w3.org/2000/svg" width="80.765" height="80.868" viewBox="0 0 74.765 74.868">
                              <g id="Group_1532" data-name="Group 1532" transform="translate(-3.978 -8.033)">
                                 <g id="Group_1356" data-name="Group 1356" transform="translate(4.203 7.801)">
                                    <g id="Group_1344" data-name="Group 1344">
                                       <path id="Path_2218" data-name="Path 2218" d="M30.957-.186A31.061,31.061,0,1,1-.19,30.892,31.054,31.054,0,0,1,30.957-.186Z" transform="matrix(0.23, -0.973, 0.973, 0.23, 0, 60.685)" fill="#007ab5"/>
                                       <path id="Path_2209" data-name="Path 2209" d="M151.033,280.416a.649.649,0,0,1,0-1.3,34.942,34.942,0,0,0,5.538-.445.649.649,0,0,1,.206,1.281,36.343,36.343,0,0,1-5.743.463Zm11.137-1.8a.649.649,0,0,1-.2-1.265,34.64,34.64,0,0,0,7.525-3.559.648.648,0,0,1,.69,1.1,35.979,35.979,0,0,1-7.808,3.693A.688.688,0,0,1,162.171,278.614Zm-30.748-4.1a.639.639,0,0,1-.356-.108,36.2,36.2,0,0,1-13.338-16.072.648.648,0,1,1,1.192-.508,34.893,34.893,0,0,0,12.86,15.5.649.649,0,0,1-.358,1.19Zm49.149-10.024a.642.642,0,0,1-.357-.108.649.649,0,0,1-.181-.9,34.848,34.848,0,0,0,5.794-19.3.647.647,0,1,1,1.295,0,36.146,36.146,0,0,1-6.011,20.018A.645.645,0,0,1,180.572,264.492Zm-65.044-20.531h-.016a.65.65,0,0,1-.631-.664,36.439,36.439,0,0,1,1.232-8.567.648.648,0,1,1,1.25.338,35.083,35.083,0,0,0-1.187,8.26A.648.648,0,0,1,115.527,243.961Zm68.11-13.094a.645.645,0,0,1-.6-.393,34.9,34.9,0,0,0-2.582-4.93.647.647,0,1,1,1.093-.693,35.991,35.991,0,0,1,2.679,5.113.646.646,0,0,1-.594.9Zm-64.993-.664a.628.628,0,0,1-.265-.058.649.649,0,0,1-.324-.858,36.3,36.3,0,0,1,2.786-5.061.647.647,0,1,1,1.079.715,35.089,35.089,0,0,0-2.685,4.88A.649.649,0,0,1,118.645,230.2Zm58.967-8.9a.642.642,0,0,1-.485-.22,35.153,35.153,0,0,0-6.208-5.559.648.648,0,0,1,.741-1.064,36.348,36.348,0,0,1,6.438,5.765.649.649,0,0,1-.057.916A.642.642,0,0,1,177.612,221.306Zm-40.5-9.225a.649.649,0,0,1-.253-1.246A35.809,35.809,0,0,1,151,207.953a36.331,36.331,0,0,1,6.58.6.649.649,0,0,1-.234,1.276A35.109,35.109,0,0,0,151,209.25a34.547,34.547,0,0,0-13.635,2.778A.627.627,0,0,1,137.108,212.08Z" transform="translate(-113.838 -206.518)" fill="#007ab5"/>
                                    </g>
                                    <g id="Group_1345" data-name="Group 1345" transform="translate(21.831 20.276)">
                                       <path id="Path_2210" data-name="Path 2210" d="M132.176,233.909h6.8v21.834h-6.8Zm3.4-10.85a3.935,3.935,0,1,1-3.94,3.932,3.935,3.935,0,0,1,3.94-3.932" transform="translate(-131.637 -223.059)" fill="#fff"/>
                                       <path id="Path_2211" data-name="Path 2211" d="M140.987,231.913H147.5V234.9h.088a7.134,7.134,0,0,1,6.428-3.527c6.87,0,8.138,4.519,8.138,10.4v11.975h-6.782V243.131c0-2.534-.05-5.79-3.527-5.79-3.533,0-4.071,2.758-4.071,5.605v10.8h-6.783Z" transform="translate(-129.392 -221.063)" fill="#fff"/>
                                    </g>
                                 </g>
                              </g>
                           </svg>
                        </span>
                        <p style="font-size: 14px" class="hr-text-secondary">By joining, I agree to the <a href="<?= base_url('terms-of-use')?>" class="hr-link">Terms & Conditions</a> of <span class="aristotelica">LYVYO</span> and <a href="<?= base_url('privacy-policy')?>" class="hr-link">Privacy</a> <br> Copyright © 2020 <span class="aristotelica">LYVYO.COM</span> All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-5 ds-100vh">
        <div class="pt-xl-5 pt-4">
            <div class="row text-center">
                <div class="col-md-12">
                    <h6 class="text-white hr-font-size">Already a member?</h6>
                    &nbsp;
                    <a href="<?= base_url('login') ?>" class="btn btn-sm hr-btn px-4">LOG IN</a>
                </div>
                <span class="py-xl-5"></span>
            </div>
            <div class="hr-img-margin">
                <img src="<?= base_url()?>assets/home/img/png/reg-as-inst.svg" class="img-fluid px-4">
            </div>
            <h2 class="text-white text-center aristotelica-text-bold py-4 hr-connect-text">Connecting Minds</h2>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $('#country').on('change', function(e){

       var country_id = $('#country').val();
       var url = "<?= base_url() ?>";
       var uri = "fetch-cities/"+country_id

       $.ajax({
                  url: url+uri,
                  method: "GET",
                  dataType: "JSON",
                  cache: false,
                  success: function(results){
                    
                        let select = "<option value=''>City*</option>"
                                       
                                        $.each(results, function(results, vals) {
                                            select += '<option value="'+vals['id']+'">'+vals['city_name']+'</option>'
                                        })
                                        $('#state').html(select)
                  }
                });
      
    })

   
</script>

<script type="text/javascript">
    $(document).ready(function(){

            setTimeout(function() {
            $(".alert-remove").hide('blind', {}, 500)
        }, 5000);


            $(".toggle-password").click(function() {

              $(this).toggleClass("fas fa-eye-slash");
              var input = $(this).parent().children('.psbtn');
              if (input.attr("type") == "password") {
                input.attr("type", "text");
              } else {
                input.attr("type", "password");
              }
            });


         $('.registerFormSubmit').on('submit', function(e){

                e.preventDefault()

                let fd = new FormData(this)

                $.ajax({
                        url: "<?= base_url('account-verify') ?>",
                        type: "POST",
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        data: fd,
                        success: function (result) {

                        
                            if(result.status)
                            {
                                 // $('.resendSpin').hide()
                            window.location.href = `<?= base_url('user-otp-verify')?>/${result.data}`;
                            }
                            else
                            {
                                $('.errorAlert').html(`<div class="alert alert-danger alert-remove">${result.msg}</div>`);
                                   setTimeout(() => {
                                     $('.errorAlert').html('');
                                   }, 4000)
                            }
                           
                                
                         
                        }, error: function (jqXHR, exception) {
                            console.log(jqXHR.responseText)
                        }
                    })

         })   
    })
</script>
</body>
</html>