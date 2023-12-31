<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/ds.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/js.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/home/css/nav-style.css">
    <?php include 'includes/favicon.php'; ?>

    <title>FAQS GENERAL</title>
    <style>
        body {
            font-family: dubai !important;
        }

        p {
            font-family: dubai !important;
        }
        .small{
            font-size: 90%;
        }

        @media (min-width: 1001px) and (max-width: 1100px) {

            .ds-subscribe-title {
                font-size: 26px;
            }
        }

        @media (min-width: 1225px) and (max-width: 1300px) {

            .ds-subscribe-title {
                font-size: 28px;
            }
        }

        @media (min-width: 1301px) {
            .container, .container-lg, .container-md, .container-sm, .container-xl {
                max-width: 1250px !important;
            }

            .ds-subscribe-title {
                font-size: 30px;
                padding-bottom: 6px;
            }
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>


<div class="container ds-mb-dsk ds-mb180">
    <div class="row pt-5">
        <div class="col-md-7 py-md-5">
            <h3 class="font-dubai-bold">Frequently Asked Questions</h3>
        </div>
        <div class="col-md-5 py-md-5">
            <div class="input-group mt-3 my-md-0 rounded">
                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                       aria-describedby="search-addon"/>
                <i class="fa p-0 ds-top-10  px-3 fa-search"></i>
            </div>
            <small class="font-dubai">Find topics by entering terms in the search box.</small>
        </div>

        <div class="col-md-4">
            <div class="card my-4 my-md-0 px-4 border-0 shadow ds-light-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex pb-3">
                                <img src="<?= base_url()?>assets/home/img/vector/info.svg" alt="">
                                <h5 class="pl-2 pt-1 font-dubai-bold">Table of contents</h5>
                            </div>
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                 aria-orientation="vertical">
                                <a class="mb-2 ds-sub-heading text-decoration-none <?= ($type == "general")?'active':'' ?>" href="<?= base_url('faqs/general')?>">
                                    <span class="pl-1 <?= ($type == "general")?'text-secondary':'' ?>"> <?= ($type == "general")?'<img src="'.base_url().'assets/home/img/vector/line-2.svg'.'" alt="">':''?> General</span></a>

                                <a class="mb-2 ds-sub-heading text-decoration-none <?= ($type == "instructors")?'active':'' ?>" href="<?= base_url('faqs/instructors')?>"><span class="pl-1 <?= ($type == "instructors")?'text-secondary':'' ?>"> <?= ($type == "instructors")?'<img src="'.base_url().'assets/home/img/vector/line-2.svg'.'" alt="">':''?> Instructor</span></a>
                                <a class="mb-2 ds-sub-heading text-decoration-none <?= ($type == "learners")?'active':'' ?>" href="<?= base_url('faqs/learners')?>"><span class="pl-1 <?= ($type == "learner")?'text-secondary':'' ?>"> <?= ($type == "learners")?'<img src="'.base_url().'assets/home/img/vector/line-2.svg'.'" alt="">':''?> Learner</span></a>
                                <a class="mb-2 ds-sub-heading text-decoration-none <?= ($type == "payments")?'active':'' ?>" href="<?= base_url('faqs/payments')?>"><span class="pl-1 <?= ($type == "payments")?'text-secondary':'' ?>"> <?= ($type == "payments")?'<img src="'.base_url().'assets/home/img/vector/line-2.svg'.'" alt="">':''?> Payment</span></a>
                                <a class="mb-2 ds-sub-heading text-decoration-none <?= ($type == "technical-issues")?'active':'' ?>"
                                   href="<?= base_url('faqs/technical-issues')?>"><span class="pl-1 <?= ($type == "technical-issues")?'text-secondary':'' ?>"> <?= ($type == "technical-issues")?'<img src="'.base_url().'assets/home/img/vector/line-2.svg'.'" alt="">':'' ?> Technical Issue</span></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="d-flex py-4">
                <div class="">
                    <img src="<?= base_url()?>assets/home/img/vector/star.svg" alt="">
                </div>
                <div class="">
                    <ul class="ds-faq-ul">
                        <h4 class="font-dubai-bold">Popular questions</h4>

                        <li>How many sessions are in a course?</li>
                        <li>How will the first lesson be arranged?</li>
                        <li>What is the Cancellation Policy?</li>
                        <li>Can my lessons get confirmed
                            automatically?
                        </li>
                        <li>Why should I trust <span class="font-dubai-bold">LYVYO</span> ?</li>
                        <li>Is it possible to place an advertisement
                            on <span class="font-dubai-bold">LYVYO</span> ?
                        </li>
                    </ul>
                </div>
            </div>

            <div class="d-flex">
                <div class=""><img src="<?= base_url()?>assets/home/img/vector/help-circle.svg" alt=""></div>
                <div class=""><h4 class="pl-3 font-dubai-bold">Can't find an answer?</h4>
                </div>
            </div>

            <div class="d-flex text-center justify-content-between">
                <div class="card border-0 mr-2 my-3 ds-fix-card shadow ds-light-card">
                    <img src="<?= base_url()?>assets/home/img/vector/mail.svg" class="pt-3 ds-w-17p m-auto" alt="...">
                    <div class="card-body pt-0">
                        <h4 class="ds-ec mb-0 pt-2">Email us</h4>
                    </div>
                </div>

                <div class="card border-0 ml-2 my-3 ds-fix-card shadow ds-light-card">
                    <img src="<?= base_url()?>assets/home/img/vector/phone.svg" class="pt-3 ds-w-18 m-auto" alt="...">
                    <div class="card-body pt-0">
                        <h4 class="ds-ec mb-0 pt-2">Call us</h4>
                    </div>
                </div>
            </div>


        </div>
        <div class="col-md-8">


            <div class="tab-content" id="v-pills-tabContent">

                <div class="tab-pane fade <?= ($type == "general")?'show active':'' ?>" id="v-pills-home" role="tabpanel"
                     aria-labelledby="v-pills-home-tab">
                    <span class="font-italic ds-text-disable">FAQs <img class="px-2" src="<?= base_url()?>assets/home/img/vector/chevron-right.svg"
                                                                        alt="chevron"></span>
                    <span class="font-italic">General</span>
                    <div class="row py-4">
                        <div class="col-md-6 col-6"><h3 class="ds-h3-clr">General</h3></div>
                        <div class="col-md-6 col-6 text-right"><a href="#"><img src="<?= base_url()?>assets/home/img/vector/share.svg" alt=""></a>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">1</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">How many sessions are in a
                                        course?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">After the first lesson, you will be able to decide a number of hours
                                        that you require and pay accordingly.
                                    </p>
                                    <p>
                                        Consult your mentor for more professional advice on how many hours are needed to
                                        reach your goal.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">2</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">How will the first lesson be
                                        arranged?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">We recommend coaches to offer an introductory session free of charge
                                        to get to know one another, ask questions and make sure that both parties’ needs
                                        and expectations are aligned before agreeing to "work" together.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">3</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">What are the platform
                                        guarantees?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">
                                        In case the coach doesn’t suit your needs, or your scheduled lesson doesn’t take
                                        place even if it was (accidentally) confirmed, you a can ask us to refund the
                                        full amount or transfer these funds to another coach/tutor within 3 (three) days
                                        of the scheduled lesson’s start time.
                                    </p>
                                    <p>
                                        In case you do not use these funds and/or hours acquired for those funds during
                                        the period of more than 90 (ninety) days starting from the date of provision of
                                        the funds, the balance will be irreversibly lost and will not be refunded.
                                    </p>
                                    <p>
                                        If you decide to exercise your right to change your coach after the first
                                        lesson, you can do so no more than 2 (two) times. However, if you decide to
                                        change coaches more than twice, the next first lesson with any new coach should
                                        be paid for. LYYOV is not responsible for any kind of fee charged by payment
                                        systems and will not cover it when initiating a refund. To the fullest extent
                                        permitted by law, any refunds at any time are at our sole discretion only.
                                    </p>

                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">4</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">What is the Cancellation
                                        Policy?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">If you plan to cancel a class, we require you to give your
                                        coach/mentor at least a 6-hours’ notice. Otherwise, you are liable to pay the
                                        full amount for the scheduled lesson, unless the coach agrees not to charge you.
                                        We reserve the right for every coach to charge the cost of the lesson that is
                                        cancelled less than 6 hours before its planned start time, without the
                                        possibility of this sum being refunded to the learner or transferred to other
                                        coaches.
                                    </p>
                                    <p>
                                        You can cancel/reschedule lessons through your <span class="font-dubai-bold">LYVYO</span>
                                        account easily by clicking
                                        the corresponding button in "My lessons" for the scheduled lesson anytime up to
                                        24 hours before your lesson. It’s a good practice to provide a reason for
                                        cancellation which, in most cases, will be forwarded to your coach.

                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">5</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">Why should I trust <span
                                            class="font-dubai-bold">LYVYO</span> ?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">LYVYO.com is a GCC company based in UAE. We are currently working
                                        tirelessly to build our competency and reputation in order to engage users from
                                        all around the GCC to take advantage of our services. It is in our best interest
                                        to make every single user satisfied with their <span class="font-dubai-bold">LYVYO</span>
                                        experience, and in turn
                                        recommend us to other learners. In short, good reputation is the key to our
                                        success!
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">6</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">Can my lessons get confirmed
                                        automatically?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">No. You will have to accept each session request from your potential
                                        learners. The learner may request several course sessions at one time so you can
                                        individually select and accept or decline each session booking request.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">7</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">How long do my lessons last?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">The duration of the lesson is one hour by default. It is not
                                        possible to split the duration of the lesson into 2 or more sessions.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">8</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">Is it possible to place an
                                        advertisement on <span class="font-dubai-bold">LYVYO</span>?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">The <span class="font-dubai-bold">LYVYO</span> platform was created
                                        to help coaches and learners connect.
                                        We do advertise other goods or services only if it is relevant to the LIVIO’s
                                        educational platform.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">9</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">How quickly do coaches respond?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">The response time for every coach is different. (aren’t they
                                        expected to reply within 24h?)
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">10</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">When can learners leave a
                                        review?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">After you have had a session with the coach you can leave a review
                                        and rate your coach and the session.
                                    </p>
                                </div>
                            </div>

                            <div class="card ds-light-card border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-6">
                                            <h6 class="ds-sspl">Was this article helpful?</h6>
                                        </div>
                                        <div class="col-md-6 col-6">

                                            <div class="row">
                                                <div class="col-md-10 col-6">
                                                    <div class="d-flex ds-flex-end">
                                                        <span>7</span>
                                                        <img class="img-fluid pl-2" src="<?= base_url()?>assets/home/img/vector/thumbs-down.svg"
                                                             alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-6">
                                                    <div class="d-flex ds-flex-end">
                                                        <span>185</span>
                                                        <img class="img-fluid pl-2" src="<?= base_url()?>assets/home/img/vector/thumbs-up.svg"
                                                             alt="">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade <?= ($type == "instructors")?'show active':'' ?>" id="v-pills-instructor" role="tabpanel"
                     aria-labelledby="v-pills-instructor-tab">
                   <span class="font-weight-bold ds-text-disable">FAQs <img src="<?= base_url()?>assets/home/img/vector/chevron-right.svg"
                                                                            alt="chevron"></span>
                    <span>Instructor</span>
                    <div class="row py-4">
                        <div class="col-md-6"><h3 class="ds-h3-clr">Instructor</h3></div>
                        <div class="col-md-6 text-right"><img src="<?= base_url()?>assets/home/img/vector/share.svg" alt=""></div>
                        <div class="col-md-12">
                            <hr>
                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">1</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">How much can I make as an
                                        Instructor?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">On <span class="font-dubai-bold">LYVYO</span> you decide your prices
                                        and rates for your services. The fee
                                        that <span class="font-dubai-bold">LYVYO</span> takes is 20%. But 20 % is split
                                        between the learners and Instructors.
                                        So, you as an Instructor will be paying only 10% of your fee. For your example
                                        if you are planning to charge 20AED per hour – you will receive 18 and the
                                        learner will pay 22 AED
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">2</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">When can I withdraw my money from
                                        <span class="font-dubai-bold">LYVYO</span>?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">After coaches complete their lessons, and learners confirm the
                                        lesson was completed, the funds will be automatically transferred to the
                                        coaches’ account on <span class="font-dubai-bold">LYVYO</span> platform. When
                                        the coach has accumulated AED 100 or
                                        more, the money can be withdrawn without any transfer charges (the coach will
                                        receive all AED 100 to his/her Paypal account).
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">3</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">Why do coaches have to have a
                                        minimum of AED 100 balance to withdraw their money from <span
                                                class="font-dubai-bold">LYVYO</span>?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">
                                        Every credit card charge, every transfer and every Paypal transaction is a cost.
                                        Therefore, the withdrawal limit has been set to AED100 or more to minimize the
                                        number of transactions, so that coaches are able to receive the full amount.
                                        <span class="font-dubai-bold">LYVYO </span>is committed to protect the coaches
                                        and pay for all the transactions to
                                        make sure that coaches receive the full amount they have been paid by the
                                        learners.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">4</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">Can I withdraw less than
                                        AED100?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">If you absolutely must withdraw your balance of AED 99.99 or less,
                                        you can submit a request to <span class="font-dubai-bold">LYVYO </span>at
                                        <a href="#">support@lyvyo.com</a> We will review your request and asses the fee
                                        that will be deducted from your balance to accommodate your request. Withdrawal
                                        will be arranged once you have been notified about the fees and submitted your
                                        agreement.
                                    </p>
                                    <p>
                                        *Note: AED 10 or less will not be eligible for withdrawal.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">5</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">How to make sure my profile shows
                                        up in the search?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">At times, when the account set up is left incomplete, your profile
                                        will not show up in the search results and you cannot get bookings. Please
                                        follow this
                                        <a href="#">step-by-step tutorial</a> to make sure your profile is properly set
                                        up and visible to potential learners.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">6</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">How to add a course?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">When you are registering your profile and cannot find the course
                                        that you want to coach in the menu, please send an email with a request to
                                        <a href="#">support@lyvyo.com</a> or get in touch through our <a href="#">Contact
                                            Us page.</a> We will review your request and add the course if it meets our
                                        policies. After it has been added we will notify you.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">7</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">What if I cannot attend a
                                        session?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">When you receive the booking confirmation email, you have 6 hours to
                                        confirm if you will attend the session. If you confirm but do not attend the
                                        session, the learner is entitled for a full refund or the option to reschedule
                                        with you or a different instructor.
                                    </p>
                                </div>
                            </div>

                            <div class="card ds-light-card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small>Was this article helpful?</small>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div class="d-flex ds-flex-end">
                                                        <span>7</span>
                                                        <img class="img-fluid pl-2" src="<?= base_url()?>assets/home/img/vector/thumbs-down.svg"
                                                             alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="d-flex ds-flex-end">
                                                        <span>185</span>
                                                        <img class="img-fluid pl-2" src="<?= base_url()?>assets/home/img/vector/thumbs-up.svg"
                                                             alt="">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade <?= ($type == "learners")?'show active':'' ?>" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <span class="font-weight-bold ds-text-disable">FAQs <img src="<?= base_url()?>assets/home/img/vector/chevron-right.svg"
                                                                             alt="chevron"></span>
                    <span>Learner</span>
                    <div class="row py-4">
                        <div class="col-md-6"><h3 class="ds-h3-clr">Learner</h3></div>
                        <div class="col-md-6 text-right"><img src="<?= base_url()?>assets/home/img/vector/share.svg" alt=""></div>
                        <div class="col-md-12">
                            <hr>
                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">1</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">How much does it cost to have a
                                        lesson with a coach?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">Every coach works as a contractor and charges the price he/she
                                        wishes. The <span class="font-dubai-bold">LYVYO </span>platform does not affect
                                        the coach’s decision on how much to
                                        charge for the course.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">2</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">Where can I find a coach’s contact
                                        information?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">You are not allowed to contact the coach outside the platform with
                                        regard of your sessions on LYVYO.com. There is an integrated message board that
                                        you can use to communicate with the coach and a file exchange platform to
                                        facilitate file exchange for the sessions.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">3</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">How can I find a coach?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">
                                        Type the subject in the “Find a Coach” section on the home page and take a look
                                        at the results based on your requirements, time availability and budget. The
                                        available filters on LYVYO.com will help you narrow down your search based on
                                        your preferred criteria. First choose the subject you are looking for then
                                        specify the price range and your preferred time. It is recommended that you use
                                        all the available filters to narrow down your search and save time in your
                                        search. Finally, take a look at the ratings and reviews when selecting the
                                        coach.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">4</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">Can I contact some coaches before I
                                        sign up for a class?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">If you need to speak to potential coaches before making a
                                        commitment, you may send a personal message directly from the search results.
                                        You must be registered on LYVYO.com to be able to contact with the coaches
                                        directly.
                                    </p>
                                    <p>
                                        According to our site rules, it is forbidden to share your contact information
                                        to negotiate course deals outside of the platform. Violation of this policy will
                                        result in your profile to be blocked, and <span
                                            class="font-dubai-bold">LYVYO </span>will not be responsible for any
                                        compensation in case you encounter a scam.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">5</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">What if I don’t like the coach
                                        after the first lesson?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">If the coach does not meet your requirements for any reason, and you
                                        decide not to continue with the lesson, you can simply let him/her know and
                                        explain the reasons if you chose to do so. If the session is not completed for
                                        this reason, you will not be charged for the course and the fees shall be
                                        transferred to another coach that meets your requirement, keeping in
                                        consideration that the price might vary from a coach to another.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">6</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">How do I pay for sessions?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">When you book a session, the amount that is due will be transferred
                                        to LYVYO.com to be held. After your session is complete, you will be prompted to
                                        confirm that the lesson actually took place and you were satisfied with the
                                        service. Once you do that, the coach will receive a payment to his/her account.
                                    </p>
                                    <p>
                                        If the lesson was not held, or you were not completely satisfied with it, please
                                        let us know within 72 hours after the lesson time so that we can take
                                        appropriate action.
                                    </p>
                                    <p>
                                        We recommend you to give an honest feedback about your coach. This will help our
                                        platform to rate the coaches accordingly and will help other learners in their
                                        search.
                                    </p>

                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">7</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">What if I cannot attend the planned
                                        session?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">When you become aware that you are not able to take part in a
                                        scheduled lesson, please try to inform your coach as far in advance as possible
                                        by rescheduling or cancelling your lesson. Note that you can cancel or
                                        reschedule lessons for free up to 6 hours in advance of the scheduled start
                                        time.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">7</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">What if my Instructor does not
                                        attend the session?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">If you attend your session and your instructor has not attended or
                                        shown up. You are entitled to report to us with your booking confirmation
                                        number. We will then reach out to your instructor to confirm. Once confirmed you
                                        are entitled to reschedule if you wish with the same or different instructor. Or
                                        request for a refund.
                                    </p>
                                </div>
                            </div>

                            <div class="card ds-light-card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small>Was this article helpful?</small>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div class="d-flex ds-flex-end">
                                                        <span>7</span>
                                                        <img class="img-fluid pl-2" src="<?= base_url()?>assets/home/img/vector/thumbs-down.svg"
                                                             alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="d-flex ds-flex-end">
                                                        <span>185</span>
                                                        <img class="img-fluid pl-2" src="<?= base_url()?>assets/home/img/vector/thumbs-up.svg"
                                                             alt="">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade <?= ($type == "payments")?'show active':'' ?>" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                    <span class="font-weight-bold ds-text-disable">FAQs <img src="<?= base_url()?>assets/home/img/vector/chevron-right.svg"
                                                                             alt="chevron"></span>
                    <span>Payment</span>
                    <div class="row py-4">
                        <div class="col-md-6"><h3 class="ds-h3-clr">Payment</h3></div>
                        <div class="col-md-6 text-right"><img src="<?= base_url()?>assets/home/img/vector/share.svg" alt=""></div>
                        <div class="col-md-12">
                            <hr>
                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">1</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">How do I pay for sessions?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">When you book a session, the amount that is due will be transferred
                                        to <span class="font-dubai-bold">LYVYO </span>to be held. After your session is
                                        complete, you will be prompted to
                                        confirm that the lesson actually took place and you were satisfied with the
                                        service. Once you do that, the coach will receive a payment to his/her account.
                                    </p>
                                    <p>
                                        If the lesson was not held, or you were not completely satisfied with it, please
                                        let us know within 48 hours after the lesson time so that we can take
                                        appropriate action.
                                    </p>
                                    <p>
                                        We recommend you to give an honest feedback about your coach. This will help our
                                        platform to rate the coaches accordingly and will help other learners in their
                                        search.
                                    </p>
                                    Payments on <span class="font-dubai-bold">LYVYO </span>will be through online
                                    transactions. Multiple options of payment
                                    gateways are integrated to facilitate flexible payment options. <span
                                        class="font-dubai-bold">LYVYO </span>allows
                                    transactions through Visa and Mastercard.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">2</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">How to get a Refund?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1"><span class="font-dubai-bold">LYVYO </span>does not process refunds
                                        unless under special circumstances. A
                                        refund can be processed if one of the following:
                                    </p>
                                    <p>
                                        Instructor does not attend his session. <br>
                                        Instructor does not abide with T&C, Privacy policy and Instructor agreement.<br>
                                        Instructor deviates from his session into different topics.<br>
                                        If Instructor / Learner cancels within 6 hours.</p>

                                    <span class="ds-main-clr"><span class="font-dubai-bold">LYVYO </span>is not required to refund a Learner if:</span>
                                    <p>
                                        Learner loses internet connectivity.<br>
                                        Learner does not attend a session.<br>
                                        Learner does not cancel his session within 6 hours.<br>
                                        Learner does not follow T&C, Privacy policy and Guide agreement.
                                    </p>
                                </div>
                            </div>

                            <div class="card ds-light-card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small>Was this article helpful?</small>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div class="d-flex ds-flex-end">
                                                        <span>7</span>
                                                        <img class="img-fluid pl-2" src="<?= base_url()?>assets/home/img/vector/thumbs-down.svg"
                                                             alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="d-flex ds-flex-end">
                                                        <span>185</span>
                                                        <img class="img-fluid pl-2" src="<?= base_url()?>assets/home/img/vector/thumbs-up.svg"
                                                             alt="">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade <?= ($type == "technical-issues")?'show active':'' ?>" id="v-pills-technical" role="tabpanel"
                     aria-labelledby="v-pills-technical-tab">
                    <span class="font-weight-bold ds-text-disable">FAQs <img src="<?= base_url()?>assets/home/img/vector/chevron-right.svg"
                                                                             alt="chevron"></span>
                    <span>Technical Issue</span>
                    <div class="row py-4">
                        <div class="col-md-6"><h3 class="ds-h3-clr">Technical Issue</h3></div>
                        <div class="col-md-6 text-right"><img src="<?= base_url()?>assets/home/img/vector/share.svg" alt=""></div>
                        <div class="col-md-12">
                            <hr>
                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">1</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">Forgot Password?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">If you can’t remember the password for your <span
                                            class="font-dubai-bold">LYVYO </span>account, you can
                                        request a reset password email from the login page:
                                    </p>
                                    <ol>
                                        <li> Move your cursor to the top right of Lyvyo's homepage, then click on Sign
                                            in
                                        </li>
                                        <li> Click Forgot Password</li>
                                        <li> Enter your email and click the I'm not a robot box</li>
                                        <li> Select the correct images and then click VERIFY</li>
                                        <li> Next, click on Reset Password</li>
                                        <li> Check your inbox for the reset password email and complete the steps to
                                            change your password.
                                        </li>
                                    </ol>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">2</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">Can’t find the reset password
                                        email? </a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">If you do not receive the password reset message within an hour,
                                        please check your spam folder. Also, please be sure the
                                        <a href="#">no-reply@lyvyo.com</a> email is added to your safe sender list.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">3</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">How to change your account’s
                                        password</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">

                                    <ul class="ds-ol mt-1">
                                        <li>You can change your password at any time by doing the following:</li>
                                        <li>Log in to your account</li>
                                        <li>Move your cursor to the top right of Lyvyo's homepage and click on your
                                            name
                                        </li>
                                        <li>Click Account on the left-hand side of the page</li>
                                        <li>Enter your current password, your new password, re-type your new password,
                                            then click on Change Password.
                                        </li>

                                    </ul>

                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">4</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">How to make sure my profile shows
                                        up in the search?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">At times, when the account set up is left incomplete, your profile
                                        will not show up in the search results and you cannot get bookings. Please
                                        follow this
                                        <a href="#">step-by-step tutorial</a> to make sure your profile is properly set
                                        up and visible to potential learners.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">5</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">Did you register on <span
                                            class="font-dubai-bold">LYVYO </span>using the
                                        Facebook, LinkedIn or Google option?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">
                                    <p class="mt-1">When you register using the LinkedIn, Google or Facebook option, no
                                        password is created for your Lyvyo account. If you wish to create a password for
                                        your Lyvyo account and log in with the same email address that’s registered with
                                        LinkedIn, Google or Facebook moving forward, please follow the steps outlined
                                        above to reset your password.
                                        You can access the email address that is registered for your Lyvyo account in
                                        your Account settings.
                                    </p>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="ds-num"><span class="text-warning font-weight-bold">6</span></div>
                                <div class="ds-text pl-3">
                                    <a href="#" class="ds-main-clr font-weight-bold">Common reasons for failed card
                                        payment issues?</a>
                                    <img class="img-fluid pl-3" src="<?= base_url()?>assets/home/img/vector/link.svg" alt="">

                                    <br>
                                    <a href="#" class="ds-main-clr font-weight-bold small">Incorrect CVC code: </a>
                                    <p class="mt-1">Please ensure you’re only entering numbers and that the code is
                                        correct, as listed on the back of the card.
                                    </p>


                                    <a href="#" class="ds-main-clr font-weight-bold small">Incorrect postal code or code
                                        is not applicable: </a>
                                    <p class="mt-1">If your payment failure states it is due to a zip code or postal
                                        code error, please contact your bank to ensure they have the right one on file.
                                        If zip codes aren't applicable in your country, however, and you still see a zip
                                        code field, please try entering all zeros (00000).
                                        Outdated saved payment method: if you’re encountering issues while trying to
                                        purchase with a saved payment method, try deleting it and re-adding it to ensure
                                        the details are correct and up to date. You can also add a new card.
                                    </p>


                                    <a href="#" class="ds-main-clr font-weight-bold small">Using a debit card not
                                        authorized for international purchases:</a>
                                    <p class="mt-1"><span class="font-dubai-bold">LYVYO </span>is based in the United
                                        States, and debit cards in many
                                        countries do not allow foreign transactions. If you do not see a local payment
                                        option when checking out on LYVYO, call your bank to ensure your card is
                                        authorized for international purchases. Please note that <span
                                                class="font-dubai-bold">LYVYO </span>is not able to
                                        remove these restrictions.
                                    </p>


                                    <a href="#" class="ds-main-clr font-weight-bold small">Issuing country for the card
                                        is different from country of residence: </a>
                                    <p class="mt-1">If the issuing country for your card is different from your country
                                        of residence, your card might not be approved. Try another payment method we
                                        offer, or contact your bank.
                                    </p>

                                    <a href="#" class="ds-main-clr font-weight-bold small">Attempting payments while
                                        using a VPN: </a>
                                    <p class="mt-1">Multiple IP addresses can result in authorization problems and
                                        failed transactions. We advise that you refrain from using a virtual private
                                        network (VPN) while making a purchase on LYVYO.
                                    </p>

                                    <a href="#" class="ds-main-clr font-weight-bold small">Too many payment attempts
                                        have been made in the last 24 hours: </a>
                                    <p class="mt-1">Some cards have usage limitations, and will automatically block
                                        payment attempts after a certain threshold has been reached. Try contacting your
                                        bank or using a different payment method.
                                    </p>

                                    <a href="#" class="ds-main-clr font-weight-bold small">Browser isn’t working
                                        correctly due to caching issues: </a>
                                    <p class="mt-1">If you’re seeing a notification your card number looks invalid or
                                        icons aren’t showing up, there may be a caching issue. Please clear your
                                        browser’s cache and try again.
                                    </p>

                                    <a href="#" class="ds-main-clr font-weight-bold small">Still Stuck? Your Bank Should
                                        Have More Information:</a>
                                    <p class="mt-1">
                                        Some of the most common reasons banks decline payments include insufficient
                                        funds, card purchase limitations, and card security policies, among other
                                        issues. Since <span class="font-dubai-bold">LYVYO </span>does not have detailed
                                        insights into why a payment is
                                        declined, we recommend contacting your financial institution directly to help
                                        solve the payment issue.
                                    </p>
                                    <p>
                                        It’s important to let your bank know that you would like to make a payment on
                                        lyvyo.com and that <span class="font-dubai-bold">LYVYO </span>is a company based
                                        in the United Arab Emirates.

                                    </p>

                                    <a href="#" class="ds-main-clr font-weight-bold small">Report a Security
                                        Vulnerability?</a>
                                    <p class="mt-1">If you've found a security vulnerability on the <span
                                            class="font-dubai-bold">LYVYO </span>site, please report it to
                                        <a href="#">support@lyvyo.com</a> Our security team will investigate all
                                        legitimate reports and will do their best to fix issues as quickly as possible.
                                    </p>


                                    <a href="#" class="ds-main-clr font-weight-bold small"> If you have not received
                                        your session link?</a>
                                    <p class="small">If you have booked a class and have not received a link for your
                                        live session with your instructor, we suggest the following...
                                    </p>
                                    <ol class="mt-1">

                                        <li>Check the you have completed the payment and it has not been declined</li>
                                        <li>Make sure you have received a confirmation email of your booking</li>
                                        <li>Give us a call where we will ask for your booking confirmation number or
                                            Invoice number
                                        </li>
                                        <li>Reach out to us on support@lyvyo.com or give us a call. Contact Us</li>


                                    </ol>

                                    <a href="#" class="ds-main-clr font-weight-bold small">What If my session
                                        disconnects due to Internet failure? </a>
                                    <p class="mt-1">
                                        If a session is cut short due to internet connectivity issues, <span
                                            class="font-dubai-bold">LYVYO </span>is not responsible to process any full
                                        or partial refunds. Partial refunds can be processed under special
                                        circumstances:
                                    </p>
                                    <p>
                                        1-If the instructor confirms that it is a fault of his/her internet connection
                                        then a partial refund will be returned to the student. It will include the
                                        amount paid minus Lyvyo’s service charge and commission.
                                    </p>
                                    <p>
                                        2-If the internet connection is lost from the Learners side, the learner is not
                                        eligible for a refund as this responsibility does not fall on <span
                                            class="font-dubai-bold">LYVYO </span>or the Instructor.

                                    </p>

                                </div>
                            </div>

                            <div class="card ds-light-card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small>Was this article helpful?</small>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div class="d-flex ds-flex-end">
                                                        <span>7</span>
                                                        <img class="img-fluid pl-2" src="<?= base_url()?>assets/home/img/vector/thumbs-down.svg"
                                                             alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="d-flex ds-flex-end">
                                                        <span>185</span>
                                                        <img class="img-fluid pl-2" src="<?= base_url()?>assets/home/img/vector/thumbs-up.svg"
                                                             alt="">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--footer section-->

<?php include 'includes/footer.php'; ?>

<!-- Optional JavaScript; choose one of the two! -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<?php include 'includes/footer-links.php'; ?>
<?php include 'includes/subscribe-newsletter.php'; ?>


<script>
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