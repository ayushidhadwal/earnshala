<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/home/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/home/css/js.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/home/css/ds.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/home/css/courses.css')?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/home/css/slick.css')?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/home/css/slick-theme.css')?>">
    <link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/dsu.css'; ?>">
    <?php include 'includes/favicon.php'; ?>
    <title>Courses</title>
</head>
<style>
    body {
        font-family: dubai;
    }

    .course-img{

        height: 205px;
        max-height: 205px;
        min-height: 205px;

    }

    @media(max-width: 700px){
        .course-img{

            width: 350x;
            max-height: 350px;
            min-height: 350px;

        }
    }

        .search::placeholder{
            color:red;
        }
    

</style>
<body>
<!--<div class="bg-percentage"></div>-->
 <?php if($this->session->userdata('user_login')){ 
    
    include 'includes/coursehead-loggedin.php'; 
    }
    else
    { 
       include 'includes/coursehead.php';
      } ?>


<div class="cou-img">
    <div class="over">
        <div class="px-md-4 px-lg-4 js-new-container">
            <div class="row m-0">
                <div class="js-new-container">
                    <div class="col-xl-7  p-md-0 c-m-h c-ph">
                        <h1 class="c-h font-dubai-bold">Learn on your schedule</h1>
                        <h1 class="c-h2 fdl">Study any topic, anytime. Explore thousands of courses for the lowest price
                            ever!</h1>
                            
                    </div>
                </div>
            </div>
            <div class="row m-0 ">
                <div class="js-new-container">
                    <div class="col-xl-7 p-md-0 ml-1">
                        <div class="form-group has-search pt-lg-5 pt-md-3 mr-4">
                            <div class="c-ab">
                                <span class="fa fa-search form-control-feedback"></span>
                            </div>
                            <input type="text" class="form-control py-lg-4 c-ip fdl py-md-4"
                                   placeholder="What do you want to learn?">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section 2 -->

<div class="js-bg-gradient counterHeight">

    <div class="container">
        <div class="row ds-text-center pt-md-3 pb-md-2 mx-md-2 py-4 py-md-5 py-lg-4">
            <div class="col-lg-3 disflexmd col-6">
                <div class="row">
                    <div class="col-md-3"><img src="<?= base_url('assets/home/')?>img/vector/instructor.svg" alt="instructor" class="c4">
                    </div>
                    <div class="col-md-9 pl-md-4 text-white">
                        <h1 class="font-dubai-bold count">500</h1>
                        <h5 class="font-dubai">Instructors</h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 disflexmd col-6 ">
                <div class="row">
                    <div class="col-md-3"><img src="<?= base_url('assets/home/')?>img/vector/trainer.svg" alt="instructor" class="c4" class="c4">
                    </div>
                    <div class="col-md-9 pl-md-4 text-white">
                        <h1 class="font-dubai-bold count">250</h1>
                        <h5 class="font-dubai">Trainers</h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 disflexmd col-6 ">
                <div class="row">
                    <div class="col-md-3"><img src="<?= base_url('assets/home/')?>img/vector/student.svg" alt="instructor" class="c4">
                    </div>
                    <div class="col-md-9 pl-md-4 text-white">
                        <h1 class="font-dubai-bold count">1004</h1>
                        <h5 class="font-dubai">Students</h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 disflexmd col-6 ">
                <div class="row">
                    <div class="col-md-3"><img src="<?= base_url('assets/home/')?>img/vector/subjects.svg" alt="instructor" class="c4">
                    </div>
                    <div class="col-md-9 pl-md-4 text-white">
                        <h1 class="font-dubai-bold count">55</h1>
                        <h5 class="font-dubai">Subjects</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section 4 -->

<div class="ds-grey">
    <div class="container-fluid js-new-container">
        <!--    our latest services-->
        <div class="row py-md-3 mx-md-0">

            <div class="col-md-12 py-md-5">
                <h3 class=" ds-pt-5 ds-section-sub-tilte c-sl font-dubai mb-0">Top courses</h3>
                <section class="responsive slider">
                    <?php foreach($top_courses as $key => $top){ ?>
                    <div>
                        <div class="card  c-card  mb-5">
                            <a href="<?php echo site_url('home/course/'.rawurlencode(slugify($top['title'])).'/'.$top['id']); ?>">
                            <img src="<?php echo $this->crud_model->get_course_thumbnail_url($top['id']); ?>" class="m-auto card-img-top course-img" alt="...">
                            </a>
                            <div class="card-body px-3">
                                <div class="card-title c-h5 font-dubai js-line-hi">
                                    <a href="<?php echo site_url('home/course/'.rawurlencode(slugify($top['title'])).'/'.$top['id']); ?>">
                                    <?= $top['title'] ?>
                                    </a>
                                </div>
                                <div class="card-text">
                                    <span class="csli-c small"><?= substr($top['short_description'], 0,50)."..." ?></span>
                                </div>
                                <div class="d-flex py-2">
                                    <img src="<?= base_url('assets/home/')?>img/courses/r-star.svg" class="img-fluid c-w50">
                                    <img src="<?= base_url('assets/home/')?>img/courses/r-star.svg" class="img-fluid c-w50">
                                    <img src="<?= base_url('assets/home/')?>img/courses/r-star.svg" class="img-fluid c-w50">
                                    <img src="<?= base_url('assets/home/')?>img/courses/r-star.svg" class="img-fluid c-w50">
                                    <img src="<?= base_url('assets/home/')?>img/courses/b-star.svg" class="img-fluid c-w50">
                                    <span class="font-dubai js-small">4.0</span>
                                </div>
                                <div class=" text-right   mt-md-3 font-dubai">
                                    <?php if($top['discounted_price'] > 0){ ?>
                                    <span class="small fdl"><s style="color: #919191"><?= $top['price'] ?> AED</s></span>
                                    <div class="d-inline m-1">
                                      <span class=" ds-clr h5 font-dubai-bold"><?= $top['discounted_price'] ?></span>
                                  <span class="h6 font-dubai-bold">AED</span>

                                    </div>
                                    <?php }elseif($top['price'] == 0){ ?>
                                         <div class="d-inline m-1">
                                      <!-- <span class=" ds-clr h5 font-dubai-bold"><?= $top['price'] ?></span> -->
                                  <span class="h6 font-dubai-bold">FREE</span>

                                    </div>
                              <?php }else{ ?>
                                           <div class="d-inline m-1">
                                        <span class=" ds-clr h5 font-dubai-bold"><?= $top['price'] ?></span>
                                    <span class="h6 font-dubai-bold">AED</span>

                                      </div>
                              <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                   <?php } ?>
                </section>
            </div>
        </div>
    </div>
</div>


<div class="ds-grey">
    <div class="container-fluid js-new-container">
        <!--    our latest services-->
        <div class="row pb-md-5 mx-md-0">
            <div class="col-md-12">
                <h2 class=" ds-pt-5 ds-section-sub-tilte c-sl font-dubai mb-0">Latest courses</h2>
                <section class="responsive slider">
                    <?php foreach ($latest as $key => $lat) { ?>
                    <div>
                        <div class="card  c-card  mb-5">
                            <a href="<?php echo site_url('home/course/'.rawurlencode(slugify($lat['title'])).'/'.$lat['id']); ?>">
                            <img src="<?php echo $this->crud_model->get_course_thumbnail_url($lat['id']); ?>" class="m-auto card-img-top course-img" class="m-auto card-img-top" alt="...">
                        </a>

                            <div class="card-body px-3">
                                <div class="card-title c-h5 font-dubai js-line-hi">
                                    <a href="<?php echo site_url('home/course/'.rawurlencode(slugify($lat['title'])).'/'.$lat['id']); ?>">
                                    <?= $lat['title'] ?>
                                </a>
                                </div>
                                <div class="card-text">
                                    <span class="csli-c small"><?= substr($lat['short_description'], 0,50)."..." ?></span>
                                </div>
                                <div class="d-flex py-2">
                                    <img src="<?= base_url('assets/home/')?>img/courses/r-star.svg" class="img-fluid c-w50">
                                    <img src="<?= base_url('assets/home/')?>img/courses/r-star.svg" class="img-fluid c-w50">
                                    <img src="<?= base_url('assets/home/')?>img/courses/r-star.svg" class="img-fluid c-w50">
                                    <img src="<?= base_url('assets/home/')?>img/courses/r-star.svg" class="img-fluid c-w50">
                                    <img src="<?= base_url('assets/home/')?>img/courses/b-star.svg" class="img-fluid c-w50">
                                    <span class="font-dubai js-small">4.0</span>
                                </div>
                               <div class=" text-right   mt-md-3 font-dubai">
                                    <?php if($lat['discounted_price'] > 0){ ?>
                                    <span class="small fdl"><s style="color: #919191"><?= $lat['price'] ?> AED</s></span>
                                    <div class="d-inline m-1">
                                      <span class=" ds-clr h5 font-dubai-bold"><?= $lat['discounted_price'] ?></span>
                                  <span class="h6 font-dubai-bold">AED</span>

                                    </div>
                                    <?php }elseif($lat['price'] == 0){ ?>
                                         <div class="d-inline m-1">
                                      <!-- <span class=" ds-clr h5 font-dubai-bold"><?= $top['price'] ?></span> -->
                                  <span class="h6 font-dubai-bold">FREE</span>

                                    </div>
                              <?php }else{ ?>
                                           <div class="d-inline m-1">
                                        <span class=" ds-clr h5 font-dubai-bold"><?= $lat['price'] ?></span>
                                    <span class="h6 font-dubai-bold">AED</span>

                                      </div>
                              <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                   
                </section>
            </div>
        </div>
        <!--   &  our latest services-->


    </div>
</div>

<!--    testimonial-->

<div class=" py-md-5 py-5 ds-grey">

</div>

<!--& testimonial-->

<!--footer section-->
<?php include 'includes/footer.php'; ?>
<!-- & footer section-->


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH 0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="<?= base_url('assets/home/js/bootstrap.bundle.min.js')?>"></script>
<script type="javascript" src="<?= base_url('assets/home/js/ds.js')?>"></script>
<script src="<?= base_url('assets/home/js/slick.js')?>" type="text/javascript" charset="utf-8"></script>
<?php include 'includes/subscribe-newsletter.php'; ?>
<script>

    $('.responsive').slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 5,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1050,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
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

    $(function () {
        $(window).resize(function () {
            onResize()
            callmelater()
        });

        function onResize() {
            $(function () {
                const setNewHeight = $('.dsu-height').outerHeight(true)
                const setbg = $('.dsu-use-offset').offset().left -5;
                $('.dsu-bg-percentage').css({background: '#1339BE', width: setbg, height: setNewHeight})
              })
        }

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

        onResize()
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


    $(function () {
        let loginToggle = $('.dsu-toggle')
        $('.dsu-hs').click(function () {
            loginToggle.toggle()
        })
    })

    
    $('.searchbtn').click(function(e){

        e.preventDefault()

        var search = $('#search').val()

        if(search !== '')
        {
            window.location.href = "<?= base_url('home/search')?>"+"?query="+search
        }
        else
        {
            $("#search").attr('placeholder',"Please fill this field").addClass('search')

            setTimeout(function(){ 
                $("#search").attr('placeholder',"Search for courses").removeClass('search') 
            }, 3000);
        }
    })


    // manage language
    $(document).mouseup(function(e)
    {

        $('.ds-onclick-e').click(function (e) {
            $('.ds-course-sub-menu').toggle()
        })

        var container = $(".ds-course-sub-menu");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0)
        {
            container.hide();
        }
    });

</script>


</body>
</html>



