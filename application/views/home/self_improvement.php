<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/js.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/ds.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/nav-style.css">
    <?php include 'includes/favicon.php'; ?>

    <title>Self Improvement</title>
    <style>
        body {
            font-family: dubai;
        }

        .content:hover .content-overlay {
            opacity: unset !important;
        }

        .content:hover .content-details {
            top: 50%;
            left: 50%;
            opacity: unset;
        }

        .content {
            max-width: 90% !important;
            /*margin: unset;*/
            width: 90% !important;
            height: 80% !important;
        }

        .content-details h3 {
            color: #fff;
            font-weight: 500;
            letter-spacing: 0.15em;
            font-size: 30px;
            margin-bottom: 0;
            border-bottom: 3px solid #FDE205;
            display: inline-block;
            text-transform: unset;
        }
    </style>
</head>
<body>


<?php include 'includes/header.php'; ?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 px-0">
            <img class="w-100" src="<?= base_url()?>assets/home/img/new-png/si/banner-img.png" alt="banner image">
        </div>
    </div>
</div>

<!-- Section 1 -->
<div class="container pb-md-5 px-md-4 pt-0">
    <div class="row text-center" id="coaching">
        <div class="col-md-12 pb-md-5">
            <h1 class="font-dubai-bold text-uppercase ds-h1-ht ds-clr">Coaching</h1>
            <img class="ds-w10" src="<?= base_url()?>assets/home/img/new-png/si/sign.png" alt="">
        </div>
        <div class="col-md-6 mx-0" id="lifecoaching">
            <div class="content">
                <a href="<?= base_url('instructors/64')?>" target="_blank">
                    <div class="content-overlay"></div>
                    <img class="content-image" src="<?= base_url()?>assets/home/img/new-png/si/diverse-startup-team-consulting-coach.png"
                         alt="Education">
                    <div class="content-details fadeIn-bottom">
                        <h3 class="content-title">Life Coaching</h3>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-6 mx-0" id="businesscoaching">
            <div class="content text-right">
                <a href="<?= base_url('instructors/65')?>" target="_blank">
                    <div class="content-overlay"></div>
                    <img class="content-image" src="<?= base_url()?>assets/home/img/new-png/si/group-people-working-out-business-plan-office.png"
                         alt="Education">
                    <div class="content-details fadeIn-bottom">
                        <h3 class="content-title">Business Coaching</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>


    <div class="row pb-3 text-center">
        <div class="col-md-12 pb-md-5">
            <h1 class="font-dubai-bold text-uppercase ds-h1-ht ds-clr">Counselling</h1>
            <img class="ds-w10" src="<?= base_url()?>assets/home/img/new-png/si/sign.png" alt="">
        </div>
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="content">
                <a href="<?= base_url('instructors/66')?>" target="_blank">
                    <div class="content-overlay"></div>
                    <img class="content-image" src="<?= base_url()?>assets/home/img/new-png/si/happy-smiling.png" alt="Education">
                    <div class="content-details fadeIn-bottom">
                        <h3 class="content-title">Family/Marriage</h3>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="content text-right">
                <a href="<?= base_url('instructors/67')?>" target="_blank">
                    <div class="content-overlay"></div>
                    <img class="content-image" src="<?= base_url()?>assets/home/img/new-png/si/young-slim.png" alt="Education">
                    <div class="content-details fadeIn-bottom">
                        <h3 class="content-title">Mindfulness Based</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>




    <div class="row py-3 mb-custom text-center">

        <div class="col-md-12 pb-md-5">
            <div class="content" style="max-width: 95% !important; width: 95% !important;">
                <a href="<?= base_url('instructors/68')?>" target="_blank">
                    <div class="content-overlay"></div>
                    <img class="content-image" src="<?= base_url()?>assets/home/img/new-png/si/sad-man.png" alt="Education">
                    <div class="content-details fadeIn-bottom">
                        <h3 class="content-title">Substance Abuse Counselling</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>


<!--footer section-->
<?php include 'includes/footer.php'; ?>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH 0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php include 'includes/footer-links.php'; ?>
<?php include 'includes/subscribe-newsletter.php'; ?>

<script>
    $('.count').each(function () {
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

            $(".fixmi").hover(function () {
                $(this).prev().css({
                    'background' : '#1339BE',
                    'color' : '#fff',
                })
            }, function () {
                $(this).prev().css({
                    'color' : '#1339BE',
                    'background' : '#fff',
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
        } else {
            $head.removeClass('fixed-top shadow navbar-white bg-white');
        }
    });
</script>
</body>
</html>