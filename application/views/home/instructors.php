<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/js.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/ds.css">
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/home/css/slick.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/home/css/slick-theme.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/nav-style.css">
    <?php include 'includes/favicon.php'; ?>


    <!--    CALENDAR CSS-->

    <link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/home/dist/css/pignose.calendar.min.css"/>
    <title>Instructors</title>
    <style>
        .slider {
            width: 100%;
            margin: 100px auto;
        }

        .slick-slider {
            right: 12px;
        }

        .slick-slide {
            margin: 0 0;
        }

        .slick-slide img {
            width: 0;
        }

        .slick-initialized .slick-slide {
            display: block;
            width: 115px !important;
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
            top: -20px !important;
        }

        .slick-prev {
            left: unset;
            right: 60px;
            bottom: 10px;
        }

        .slick-next {
            left: unset;
            right: 20px;
            bottom: 10px;
        }

        .ui-slider-track .ui-btn.ui-slider-handle {
            background: #09106B;
            width: 18px;
            border: none !important;
        }

        .ds-ins-bg {
            background: rgb(19, 57, 190);
            background: linear-gradient(90deg, rgba(19, 57, 190, 1) 35%, rgba(6, 16, 149, 1) 100%);
        }

        .dsfont45 {
            font-size: 45px;
        }

        .ds-rounded {
            border-radius: 28px;
        }

        .ui-page {
            min-height: unset !important;
            position: unset !important;
        }

        .ui-overlay-a, .ui-page-theme-a, .ui-page-theme-a .ui-panel-wrapper {
            background-color: #f9f9f900 !important;
        }

        .ds-bgt {
            background-color: transparent;
            color: #FDE205;
            position: relative;
            bottom: 9px;
            font-size: 1.2rem;
            left: 10px;
        }

        .ds-sort-by {
            font-size: 1.2rem;
        }

        .ds-clear-search {
            border: 3px solid #FDE205;
            color: #09106B;
            background-color: #fff;
            padding: .6rem 1.8rem;
            border-radius: 14px;
        }

        .ds-fi {
            border: 3px solid #FDE205;
            color: #fff;
            background-color: #FDE205;
            padding: .6rem .8rem;
            margin-left: .8rem;
            border-radius: 14px;
        }

        .card-ins {
            background-color: #F8F8F8;
            border-top-right-radius: 110px;
            border-bottom-left-radius: 110px;
            /*padding: 1rem;*/
        }

        .ds-ins-img {
            border: 4px solid #FDE205;
            border-bottom-left-radius: 80px;

        }

        .ds-ins-title {
            height: 40px;
            font-size: 2.2rem;
        }

        .ds-ins-font {
            font-size: 1.2rem;
        }

        .ds-w-cus {
            width: 15%;
            padding-right: .4rem;
        }

        .ds-ins-pos {
            position: relative;
            bottom: 11px;
            right: 9px;
        }

        .ds-font-clr {
            color: #FDE205;
            font-size: 1.4rem;
            position: relative;
            top: 3px;
            left: 5px;
        }

        .ds-imgg {
            width: 18px;
        }

        .ds-ewn-span {
            font-size: 1.3rem;
        }

        .ds-margin {
            margin-top: .2rem !important;
        }

        .ds-spl-crd {
            padding: 10px;
            background-color: #fff;
            margin: 0;
            border-radius: 20px;
            box-shadow: 4px 15px 14px #c6c6c6;
            width: 80px;

        }

        .ds-crsl-img {
            width: 80px !important;
        }

        .when {
            width: 53% !important;
        }

        .slick-track {
            /*width: 631px !important;*/
            margin-left: 1rem;

        }


        /*checkbox*/
        /* The container */
        .container-dd {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default checkbox */
        .container-dd input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }


        /* Create a custom checkbox */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #061095;
            border: 3px solid #fff;
            border-radius: 4px;

        }

        /* On mouse-over, add a grey background color */
        .container-dd:hover input ~ .checkmark {
        }

        /* When the checkbox is checked, add a blue background */
        .container-dd input:checked ~ .checkmark {
            background-color: #061095;
            border: 3px solid #fff;
            border-radius: 4px;
        }

        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark when checked */
        .container-dd input:checked ~ .checkmark:after {
            display: block;
        }

        /* Style the checkmark/indicator */
        .container-dd .checkmark:after {
            left: 7px;
            top: 4px;
            width: 5px;
            height: 10px;
            border: solid #fff;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .dd-fonts {
            font-size: 20px !important;
        }
        .pignose-calendar-top-year {
            display: none !important;
        }
        .pignose-calendar-top {
            padding: 10px 0 !important;
        }
        .pignose-calendar .pignose-calendar-top .pignose-calendar-top-month {
            position: relative;
            bottom: 20px;
        }
        .pignose-calendar-header {
            margin-top: 0 !important;
            padding: 0 0 8px 0 !important;
            border-bottom: 1px solid #000;
            margin-left: 4px;
            margin-right: 4px;
        }
        .pignose-calendar-body {
            padding: 2px 0 !important;
        }
        .pignose-calendar .pignose-calendar-header .pignose-calendar-week {
            height: 1.8em !important;
            font-family: dubai;
        }
        .pignose-calendar .pignose-calendar-unit {
            height: 2.6em !important;
        }
        .pignose-calendar .pignose-calendar-unit a {
            width: 2.2em !important;
            font-family: dubai;
            height: 2.2em !important;
        }
        .pignose-calendar .pignose-calendar-top {
            background-color: transparent !important;
            box-shadow: none !important;
            border-bottom: 0 !important;
        }
        .pignose-calendar {
            border: 0 !important;
            border-radius: 20px;
            margin: 0 auto 57px auto !important;
        }
        .pignose-calendar .pignose-calendar-header .pignose-calendar-week.pignose-calendar-week-sun {
            color: #FDE205 !important;
        }
        .pignose-calendar .pignose-calendar-header .pignose-calendar-week.pignose-calendar-week-sat{
            color: #000000 !important;
        }
         .pignose-calendar .pignose-calendar-unit.pignose-calendar-unit-sun a {
            color: #FDE205 !important;
            font-family: dubai-medium;
        }
        .pignose-calendar .pignose-calendar-unit.pignose-calendar-unit-sat a{
            color: #000000 !important;
            font-family: dubai-medium;
        }
        .pignose-calendar .pignose-calendar-top .pignose-calendar-top-month {
            font-family: dubai-bold;
            color: #061095;
        }
        .mbpp {
            margin-bottom: 11px !important;
        }
        .pignose-calendar .pignose-calendar-unit a {
            color: #000 !important;
            font-family: dubai-medium;
        }
        .pignose-calendar .pignose-calendar-unit.pignose-calendar-unit-active a {
            color: #fff !important;
            background-color: #061095 !important;
        }
        .shadow-md {
            box-shadow: 10px 20px 20px #d4d4d4;
        }
        .dsmy-md-4 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        .ds-uln {
            outline: none !important;
        }
        .ui-rangeslider .ui-rangeslider-sliders{
            margin-right: 5px;
            margin-left: 15px;
        }
    </style>
</head>
<body>


<?php include 'includes/header.php'; ?>

<div class="ds-ins-bg py-3 py-md-0 mb-md-5">
    <div class="container py-md-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center font-dubai-bold dsfont45 guide-ag text-white">Find an Instructor</h1>
            </div>
        </div>

        <div class="row py-md-4">
            <div class="col-md-4">
                <div class="card mb-2 ds-rounded">
                    <div class="card-body py-1">
                        <p class="fdl text-uppercase mb-4">Choose Course</p>
                        <select class="form-select font-dubai-bold ds-uln ds-clr w-100 border-0" aria-label="Default select example" id="coursescat">
                            <option value="">Any</option>
                            <?php foreach($coursescat as $cey => $cat){ 

                                foreach ($coursescat as $ceys => $cor) { 

                                    if($cor->parent == $cat->id && $cor->parent != 0){ ?>

                                        <option value="<?= $cor->id?>" <?= ($cor->id == $this->uri->segment(2))?"selected":""?>><?= $cor->name?> - <?= $cat->name ?></option>
                              <?php  } }
                                
                                 } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card my-3 my-md-0 ds-rounded">
                    <div class="card-body py-1">
                        <p class="fdl text-uppercase mb-4">Choose INSTRUCTOR LANGUAGE</p>
                        <select class="form-select font-dubai-bold ds-uln ds-clr w-100 border-0" aria-label="Default select example" id="language">
                            <option value="">---Choose Instructor Language---</option>
                             <?php foreach ($languages as $language): ?>
                            <option value="<?php echo $language; ?>"><?php echo ucfirst($language); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card ds-rounded">
                    <div class="card-body py-1">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="fdl mb-0 text-uppercase">PRICE PER HOUR</p>
                            </div>
                            <div class="col-md-6 text-right">
                                <p class="fdm mb-0 text-uppercase ds-clr">
                                    <span id="first"></span>
                                    <span id="last"></span>
                                </p>
                            </div>
                        </div>
                        <div data-role="page" class="mb-0">
                            <div data-role="main" class="">
                                <form method="post" action="">
                                    <div data-role="rangeslider">
                                        <input type="range" name="price-min" id="price-min" value="50" min="50"
                                               max="200">
                                        <input type="range" name="price-max" id="price-max" value="200" min="50"
                                               max="200">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-3 my-md-0">
            <div class="col-md-12 py-md-3">
                <label class="container-dd dd-fonts font-dubai-bold text-white">FREE TRIAL SESSION
                    <input type="checkbox" id="freetrial">
                    <span class="checkmark"></span>
                </label>
            </div>
            <div class="col-md-6">
                <div class="d-flex">
                    <p class="text-white text-uppercase ds-sort-by font-dubai-bold">Sort By</p>
                    <select class="form-select border-0 font-dubai-bold ds-bgt" aria-label="Default select example" id="sortby">
                        <option value="desc" selected>PRICE HIGH - LOW</option>
                        <option value="asc">LOW - HIGH</option>
                        <option value="desc">HIGH - LOW</option>
                        <option value="rating">Rating HIGH - LOW</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn fdm  ds-clear-search">Clear Search</button>
                <button type="button" class="btn fdm  ds-fi" onclick="fetchInstructorByCourseCategory()">Find an Instructor</button>
            </div>
        </div>
    </div>
</div>

 
<div class="container py-md-5">


    <div class="text-center" id="loadingdata" style="display: none;">
            <img src="<?= base_url('assets/home/img/new-png/giphy.gif')?>">
        </div>
    <div class="row" id="fetchInstructor">

        
        
    </div>
</div>
<br><br><br><br>

<!--footer section-->
<?php include 'includes/footer.php'; ?>


<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<?php include 'includes/footer-links.php'; ?>
<?php include 'includes/subscribe-newsletter.php'; ?>


<script src="<?= base_url()?>assets/home/js/slick.js" type="text/javascript" charset="utf-8"></script>

<script>

    function slickslider() {
       
    
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
}

</script>
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


    $(window).scroll(function () {
        var $this = $(this),
            $head = $('#justhead');
        if ($this.scrollTop() > 120) {
            $head.addClass('fixed-top shadow navbar-white bg-white');
        } else {
            $head.removeClass('fixed-top shadow navbar-white bg-white');
        }

    });
    // width carousel of card
    $(".ds-spl-crd").parent().addClass('when');
</script>

<!--Calendar JS-->

<script type="text/javascript" src="<?= base_url()?>assets/home/dist/js/pignose.calendar.full.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

            fetchInstructorByCourseCategory();



    })

     function fetchInstructorByCourseCategory()
            {
                $('#loadingdata').show();
                var fd = new FormData()
                var cscat = $('#coursescat').val()
                var lang = $('#language').val()
                var minprice = $('#price-min').val()
                var maxprice = $('#price-max').val()
                var sortby = $('#sortby').val()

               
                fd.append("cscat",cscat)

               if(lang !== '')
               {    
                    fd.append('langauge',lang)
               }

               fd.append('minprice',minprice)
               fd.append('maxprice',maxprice)

               if(sortby !== '')
               {
                   fd.append('sortby',sortby)
               }
               
                $.ajax({

                        type       : 'POST',
                        url        : '<?php echo base_url('fetch-instructor-by-filter') ?>',
                        dataType   : 'json',
                        data       : fd,
                        processData: false,
                        contentType: false,
                        success    : function(result) {

                            // console.log(result)
                            // return false;
                            $('#loadingdata').hide();   
                            var instructors = ''
                            if(result.length > 0){
                                
                                             $.map( result, function( val, i ) {

                                                 instructors += `<div class="col-md-12 dsmy-md-4">
                                    <div class="card-ins shadow-md">
                                        <div class="card-body pb-0">
                                            <div class="row">
                                                <div class="col-md-3 col-6">
                                                    <img class="img-fluid ds-ins-img" src="<?= base_url('uploads/user_image/')?>${val.instructor.image}.jpg" style="height: 320px; max-height: 320px; min-height: 320px; width: 272px; max-width: 272px;" alt="Profile">
                                                </div>
                                                <div class="col-md-5 col-12">
                                                    <div class="row">
                                                        <div class="col-md-7">
                                                        <a href="<?= base_url('home/instructor_page/')?>${val.instructor.id}" class="text-decoration-none urlHit">
                                                            <h2 class="font-dubai-bold ds-clr ds-ins-title mb-0"> ${(val.instructor.gender == "Male")?"Mr.":"Ms."} ${val.instructor.first_name}</h2>
                                                            </a>
                                                            <p class="fdl ds-ins-font">
                                                                 ${val.instructor.language}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <img class="img-fluid ds-w-cus" src="<?= base_url('assets/home/')?>img/new-png/fitness/star.png" alt="">
                                                            <img class="img-fluid ds-w-cus" src="<?= base_url('assets/home/')?>img/new-png/fitness/star.png" alt="">
                                                            <img class="img-fluid ds-w-cus" src="<?= base_url('assets/home/')?>img/new-png/fitness/star.png" alt="">
                                                            <img class="img-fluid ds-w-cus" src="<?= base_url('assets/home/')?>img/new-png/fitness/star.png" alt="">
                                                            <img class="img-fluid ds-w-cus" src="<?= base_url('assets/home/')?>img/new-png/fitness/star.png" alt="">
                                                            <span class="small fdl ds-ins-pos">5.0</span>
                                                            <h3 class="font-dubai-bold pt-3 pl-4 ds-clr">50 <span
                                                                    class="ds-ewn-span">AED/Hr</span></h3>
                                                        </div>
                                                        <div class="col-md-12 pb-md-3 pt-md-2">
                                                            <img class="img-fluid ds-imgg" src="<?= base_url('assets/home/')?>img/new-png/fitness/tic.png" alt="">
                                                            <span class="font-dubai-bold ds-font-clr">FREE TRIAL LESSON</span>
                                                           
                                                        </div>
                                                         <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    <h4 class="font-dubai-bold pt-2 ds-clr ds-section-sub-tilte">Skills</h4>
                                                                    <section class="responsive slider ds-margin mb-0">`

                                                     $.each( val.skills, function( key, value ) {
                                                   instructors += `<div style="width: auto !important;">
                                                                            <div class="ds-spl-crd">
                                                                                <img class="img-fluid ds-crsl-img"
                                                                                     src="<?= base_url('uploads/thumbnails/category_thumbnails/')?>${value.thumbnail}" alt="">
                                                                            </div>
                                                                            <p class="ml-2 ds-clr fdl mbpp pl-md-1 mt-md-3">${value.name}</p>
                                                                        </div>`
                                                 });

                                                     instructors += `</section>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">

                                                    <div class="calendar"></div>
                                                   

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`
                                             
                                                 
                                             });
                                 $('#fetchInstructor').html(instructors)
                                slickslider()
                                calenderCall()
                                urlHit()
                            }
                            else
                            {
                                instructors += `<div class="col-md-12 dsmy-md-4">
                   <div class="card-ins shadow-md">
                       <div class="card-body pb-0">
                           <div class="row">
                           <div class="col-md-12 text-center">
                              <h2>No Data Found</h2>
                              </div>
                           </div>
                       </div>
                   </div>
               </div>`
               $('#fetchInstructor').html(instructors)
                            }
                            
                    
                
                        },error: function(jqXHR, exception) {
                            console.log('bye');
                            console.log(jqXHR.responseText);
                        }
                    })
            }
    
</script>
<script type="text/javascript">
    //<![CDATA[

    function calenderCall()
    {
         $('#wrapper .version strong').text('v' + $.fn.pignoseCalendar.version);

          // Default Calendar
        $('.calendar').pignoseCalendar({
            select: onSelectHandler
        });
        

        // Input Calendar
        $('.input-calendar').pignoseCalendar({
            apply: onApplyHandler,
            buttons: true, // It means you can give bottom button controller to the modal which be opened when you click.
        });

        // Calendar modal
        var $btn = $('.btn-calendar').pignoseCalendar({
            apply: onApplyHandler,
            modal: true, // It means modal will be showed when you click the target button.
            buttons: true
        });

        // Color theme type Calendar
        $('.calendar-dark').pignoseCalendar({
            theme: 'dark', // light, dark, blue
            select: onSelectHandler
        });

        // Blue theme type Calendar
        $('.calendar-blue').pignoseCalendar({
            theme: 'blue', // light, dark, blue
            select: onSelectHandler
        });

        // Schedule Calendar
        $('.calendar-schedules').pignoseCalendar({
            scheduleOptions: {
                colors: {
                    holiday: '#2fabb7',
                    seminar: '#5c6270',
                    meetup: '#ef8080'
                }
            },
            schedules: [{
                name: 'holiday',
                date: '2021-04-14'
            }, {
                name: 'holiday',
                date: '2017-09-16'
            }, {
                name: 'holiday',
                date: '2017-10-01',
            }, {
                name: 'holiday',
                date: '2017-10-05'
            }, {
                name: 'holiday',
                date: '2017-10-18',
            }, {
                name: 'seminar',
                date: '2017-11-14'
            }, {
                name: 'seminar',
                date: '2017-12-01',
            }, {
                name: 'meetup',
                date: '2018-01-16'
            }, {
                name: 'meetup',
                date: '2018-02-01',
            }, {
                name: 'meetup',
                date: '2018-02-18'
            }, {
                name: 'meetup',
                date: '2018-03-04',
            }, {
                name: 'meetup',
                date: '2018-04-01'
            }, {
                name: 'meetup',
                date: '2018-04-19',
            }],
            select: function (date, context) {
                var message = `You selected ${(date[0] === null ? 'null' : date[0].format('YYYY-MM-DD'))}.
                               <br />
                               <br />
                               <strong>Events for this date</strong>
                               <br />
                               <br />
                               <div class="schedules-date"></div>`;
                var $target = context.calendar.parent().next().show().html(message);

                for (var idx in context.storage.schedules) {
                    var schedule = context.storage.schedules[idx];
                    if (typeof schedule !== 'object') {
                        continue;
                    }
                    $target.find('.schedules-date').append('<span class="ui label default">' + schedule.name + '</span>');
                }
            }
        });

        // Multiple picker type Calendar
        $('.multi-select-calendar').pignoseCalendar({
            multiple: true,
            select: onSelectHandler
        });

        // Toggle type Calendar
        $('.toggle-calendar').pignoseCalendar({
            toggle: true,
            select: function (date, context) {
                var message = `You selected ${(date[0] === null ? 'null' : date[0].format('YYYY-MM-DD'))}.
                                <br />
                                <br />
                                <strong>Events for this date</strong>
                                <br />
                                <br />
                                <div class="active-dates"></div>`;
                var $target = context.calendar.parent().next().show().html(message);

                for (var idx in context.storage.activeDates) {
                    var date = context.storage.activeDates[idx];
                    if (typeof date !== '<span class="ui label"><i class="fas fa-code"></i>string</span>') {
                        continue;
                    }
                    $target.find('.active-dates').append('<span class="ui label default">' + date + '</span>');
                }
            }
        });

        // Disabled date settings.
        (function () {
            // IIFE Closure
            var times = 30;
            var disabledDates = [];
            for (var i = 0; i < times; /* Do not increase index */) {
                var year = moment().year();
                var month = 0;
                var day = parseInt(Math.random() * 364 + 1);
                var date = moment().year(year).month(month).date(day).format('YYYY-MM-DD');
                if ($.inArray(date, disabledDates) === -1) {
                    disabledDates.push(date);
                    i++;
                }
            }

            disabledDates.sort();

            var $dates = $('.disabled-dates-calendar').siblings('.guide').find('.guide-dates');
            for (var idx in disabledDates) {
                $dates.append('<span>' + disabledDates[idx] + '</span>');
            }

            $('.disabled-dates-calendar').pignoseCalendar({
                select: onSelectHandler,
                disabledDates: disabledDates
            });
        }());

        // Disabled Weekdays Calendar.
        $('.disabled-weekdays-calendar').pignoseCalendar({
            select: onSelectHandler,
            disabledWeekdays: [0, 6]
        });

        // Disabled Range Calendar.
        var minDate = moment().set('dates', Math.min(moment().day(), 2 + 1)).format('YYYY-MM-DD');
        var maxDate = moment().set('dates', Math.max(moment().day(), 24 + 1)).format('YYYY-MM-DD');


        $('.disabled-range-calendar').pignoseCalendar({
            select: onSelectHandler,
            minDate: minDate,
            maxDate: maxDate
        });

        $('.calendar').pignoseCalendar({
            minDate: moment(new Date()).format("YYYY-MM-DD")
        });

        // moment.
        // $('.calendar').pignoseCalendar({
        //     minDate: moment(new Date()).format("YYYY-MM-DD")
        // });

        // Multiple Week Select
        $('.pick-weeks-calendar').pignoseCalendar({
            pickWeeks: true,
            multiple: true,
            select: onSelectHandler
        });

        // Disabled Ranges Calendar.
        $('.disabled-ranges-calendar').pignoseCalendar({
            select: onSelectHandler,
            disabledRanges: [
                ['2016-10-05', '2016-10-21'],
                ['2016-11-01', '2016-11-07'],
                ['2016-11-19', '2016-11-21'],
                ['2016-12-05', '2016-12-08'],
                ['2016-12-17', '2016-12-18'],
                ['2016-12-29', '2016-12-30'],
                ['2017-01-10', '2017-01-20'],
                ['2017-02-10', '2017-04-11'],
                ['2017-07-04', '2017-07-09'],
                ['2017-12-01', '2017-12-25'],
                ['2018-02-10', '2018-02-26'],
                ['2018-05-10', '2018-09-17'],
            ]
        });

        // I18N Calendar
        $('.language-calendar').each(function () {
            var $this = $(this);
            var lang = $this.data('lang');
            $this.pignoseCalendar({
                lang: lang
            });
        });

        // This use for DEMO page tab component.
        $('.menu .item').tab();
    }


     function onSelectHandler(date, context) {
            /**
             * @date is an array which be included dates(clicked date at first index)
             * @context is an object which stored calendar interal data.
             * @context.calendar is a root element reference.
             * @context.calendar is a calendar element reference.
             * @context.storage.activeDates is all toggled data, If you use toggle type calendar.
             * @context.storage.events is all events associated to this date
             */

            var $element = context.element;
            var $calendar = context.calendar;
            var $box = $element.siblings('.box').show();
            var text = 'You selected date ';

            if (date[0] !== null) {
                text += date[0].format('YYYY-MM-DD');
            }

            if (date[0] !== null && date[1] !== null) {
                text += ' ~ ';
            } else if (date[0] === null && date[1] == null) {
                text += 'nothing';
            }

            if (date[1] !== null) {
                text += date[1].format('YYYY-MM-DD');
            }

            $box.text(text);
        }

        function onApplyHandler(date, context) {
            /**
             * @date is an array which be included dates(clicked date at first index)
             * @context is an object which stored calendar interal data.
             * @context.calendar is a root element reference.
             * @context.calendar is a calendar element reference.
             * @context.storage.activeDates is all toggled data, If you use toggle type calendar.
             * @context.storage.events is all events associated to this date
             */

            var $element = context.element;
            var $calendar = context.calendar;
            var $box = $element.siblings('.box').show();
            var text = 'You applied date ';

            if (date[0] !== null) {
                text += date[0].format('YYYY-MM-DD');
            }

            if (date[0] !== null && date[1] !== null) {
                text += ' ~ ';
            } else if (date[0] === null && date[1] == null) {
                text += 'nothing';
            }

            if (date[1] !== null) {
                text += date[1].format('YYYY-MM-DD');
            }

            $box.text(text);
        }

   
    //]]>
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
                    'background' : '#1339BE',
                    'color' : '#fff',
                })
                $('.dis-none-me').css('background','#061095')
            }, function () {
                $(this).prev().css({
                    'color' : '#1339BE',
                    'background' : '#fff',
                })
                $('.dis-none-me').css('background','#061095')
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
        $('.pignose-calendar-week-sat').text('S')
        $('.pignose-calendar-week-sun').text('S')

    })

    $(function (){

        let first = $('.ui-rangeslider-first')
        let last = $('.ui-rangeslider-last')

        first.hide()
        last.hide()

        $('#first').html(`${first.val()} AED -`)
        $('#last').html(`${last.val()} AED`)


        $('.ui-slider-bg').css({"background-color":"#9DA4FE","border-color":"#9DA4FE"})

    })

</script>



<script type="text/javascript">
    $(document).ready(function(){
          $("#price-min").change(function(){
                 let first = $('.ui-rangeslider-first')
                 // let last = $('.ui-rangeslider-last')
                 let price = $('#price-min').val()
                $('#first').html(`${first.val()} AED -`)
          });

           $("#price-max").change(function(){
                 // let first = $('.ui-rangeslider-first')
                 let last = $('.ui-rangeslider-last')
                 let price = $('#price-min').val()
                $('#last').html(`${last.val()} AED`)
          });

        });

    function urlHit()
    {
        $('.urlHit').click(function(){


            let url = $(this).attr('href')

            window.location.href=url
        })
    }

    

    
</script>
</body>
</html>

