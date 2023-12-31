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
    <title>Education</title>
    <style>
        body {
            font-family: dubai;
        }
    </style>
</head>
<body>


<?php include 'includes/header.php'; ?>

<div class="container-fluid">
<div class="row">
    <div class="col-md-12 px-0">
        <img class="w-100" src="<?= base_url()?>assets/home/img/new-png/banner-slider-1.png" alt="banner image">
    </div>
</div>
</div>
<!-- Section 1 -->
<div class="container terms-container-padding pb-md-5 pt-0">
    <div class="row text-center">
        <div class="col-md-12 pb-md-5">
            <h2 class="font-dubai-bold ds-clr ds-h2-height">EDUCATION</h2>
            <p class="fdl dsp">Our education program has 4 levels</p>
        </div>

        <div class="col-md-3 px-md-0">
            <a href="<?= base_url('education/5') ?>" class="text-decoration-none">
            <img class="img-fluid" src="<?= base_url()?>assets/home/img/new-png/primary-level.png" alt="primary level">
            <h4 class="fdm ds-clr">Primary Level</h4>
        </a>
        </div>
        <div class="col-md-3 px-md-0">
            <a href="<?= base_url('education/7') ?>" class="text-decoration-none">
            <img class="img-fluid" src="<?= base_url()?>assets/home/img/new-png/secondary-level.png" alt="secondary level">
            <h4 class="fdm ds-clr">Secondary Level</h4>
            </a>
        </div>
        <div class="col-md-3 px-md-0">
            <a href="<?= base_url('education/6')?>" class="text-decoration-none">
            <img class="img-fluid" src="<?= base_url()?>assets/home/img/new-png/high-level.png" alt="high level">
            <h4 class="fdm ds-clr">Highschool Level</h4>
            </a>
        </div>
        <div class="col-md-3 px-md-0">
            <a href="<?= base_url('education/8')?>" class="text-decoration-none">
            <img class="img-fluid" src="<?= base_url()?>assets/home/img/new-png/university-level.png" alt="University level">
            <h4 class="fdm ds-clr">University Level</h4>
            </a>
        </div>

    </div>
</div>

<div class="ds-primary-level">
    <div class="container">
        <div class="row">
            <div class="col-md-5 pr-md-0 pt-md-5">
                <img class="img-fluid" src="<?= base_url()?>assets/home/img/new-png/pl.png" alt="primary level">
            </div>

            <div class="row pb-4 ds-spl-padding mx-0 mx-md-1">
                <?php foreach($primary as $key => $pr): ?>
                <div class="col-md-4 col-6 px-md-0 text-center">
                    <a href="<?= base_url('instructors/'.$pr->id) ?>" class="text-decoration-none">
                    <img class="w-50 ds-w100p" src="<?php echo base_url('uploads/thumbnails/category_thumbnails/'.$pr->thumbnail); ?>" alt="">
                    <p class="ds-clr fdm dsfontp"><?= $pr->name?></p>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        
        </div>
    </div>
</div>


<div class="ds-secondary-level">
    <div class="container">
        <div class="row">
            <div class="col-md-5 pr-md-0 pt-md-5">
                <img class="img-fluid" src="<?= base_url()?>assets/home/img/new-png/sl.png" alt="primary level">
            </div>

            <div class="col-md-12">
                <div class="ds-dis-flex">
                     <?php foreach($secondary as $key => $sl): ?>
                    <div class="ds-grid">
                         <a href="<?= base_url('instructors/'.$sl->id) ?>" class="text-decoration-none">
                        <img class="img-fluid" src="<?php echo base_url('uploads/thumbnails/category_thumbnails/'.$sl->thumbnail); ?>" alt="">
                        <p class="ds-clr fdm dsfontp"><?= $sl->name?></p>
                    </a>
                    </div>
                <?php endforeach; ?>
                   
                </div>

            </div>
        </div>
    </div>
</div>


<div class="ds-high-level">
    <div class="container">
        <div class="row">
            <div class="col-md-5 pr-md-0 pt-md-5">
                <img class="img-fluid" src="<?= base_url()?>assets/home/img/new-png/hl/hl.png" alt="primary level">
            </div>

            <div class="col-md-12">
                <div class="ds-dis-flex">
                    <?php foreach($high as $key => $hl): ?>
                    <div class="ds-grid">
                         <a href="<?= base_url('instructors/'.$hl->id) ?>" class="text-decoration-none">
                        <img class="img-fluid" src="<?php echo base_url('uploads/thumbnails/category_thumbnails/'.$hl->thumbnail); ?>" alt="">
                        <p class="ds-clr fdm dsfontp"><?= $hl->name?></p>
                    </a>
                    </div>
                   <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="ds-university-level">
    <div class="container">
        <div class="row">
            <div class="col-md-5 pr-md-0 pt-md-5">
                <img class="img-fluid" src="<?= base_url()?>assets/home/img/new-png/ul/ul-university.png" alt="primary level">
            </div>

            <div class="row pb-4 ds-spl-padding mx-0 mx-md-1">
                <?php foreach($university as $ukey => $univ): ?>
                <div class="col-md-4 col-6 px-md-0 text-center">
                     <a href="<?= base_url('instructors/'.$univ->id) ?>" class="text-decoration-none">
                    <img class="w-50 ds-w100p" src="<?php echo base_url('uploads/thumbnails/category_thumbnails/'.$univ->thumbnail); ?>" alt="">
                    <p class="ds-clr fdm dsfontp"><?= $univ->name ?></p>
                </a>
                </div>
               <?php endforeach; ?>
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