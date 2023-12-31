<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" />
    <style>
        .datepicker{
            z-index: 99999 !important;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #5897fb !important;
            color: #fff;
        }
    </style>

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"><i class="mdi mdi-apple-keyboard-command title_icon"></i>
                    <?php echo $page_title; ?>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('add_coupon'); ?></h4>
                <div class="row justify-content-md-center">
                    <div class="col-xl-12">
                        <form id="add-coupon">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Coupon Name</label>
                                        <input type="text" class="form-control" name="coupon_name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Coupon Discount Percentage <em class="text-danger">%</em></label>
                                        <input type="number" class="form-control" name="coupon_discount_percentage">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Coupon Maximum Discount <em class="text-danger">Rs</em></label>
                                        <input type="number" class="form-control" name="coupon_max_discount">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Start Date</label>
                                        <input type="text" class="form-control satrt_date" name="satrt_date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">End Date</label>
                                        <input type="text" class="form-control end_date" name="end_date">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Total number of times this coupon can be used</label>
                                        <em class="text-danger">For no limit leave the field blank</em>
                                        <input type="text" class="form-control" name="no_of_times" min=1>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Number of times a single user can use this coupon</label>
                                        <em class="text-danger">For no limit leave the field blank</em>
                                        <input type="text" class="form-control" name="no_of_times_single_user" min=1>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Courses</label>
                                        <em class="text-danger">All couses leave the field blank</em>
                                        <select class="courses form-control" name="courses[]" multiple="multiple">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Users</label>
                                        <em class="text-danger">All users leave the field blank</em>
                                        <select class="users form-control" name="users[]" multiple="multiple">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Short Description</label>
                                        <textarea name="short_description" class="form-control" cols="30" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class ="btn btn-success" type="submit" >Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<script type="text/javascript" src='//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <!--<![endif]-->
    <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        var dateToday = new Date();
        $('.satrt_date, .end_date').datepicker()

        $('.users').select2({
            minimumInputLength: 2,
            allowClear: true,
            placeholder: 'Type first name or last name',
            ajax:{
                url: "<?php echo base_url().'admin/user_all' ?>",
                dataType: "json",
                type: "POST",
                delay: 250,
                data: function(params){
                    return {
                        q: params.term,
                    };
                },
                processResults: function(data){
                    return {
                        results: data,
                    };
                },
                cache: true
            }
        });

        $('.courses').select2({
            minimumInputLength: 2,
            allowClear: true,
            placeholder: 'Type course name',
            ajax:{
                url: "<?php echo base_url().'admin/course_all' ?>",
                dataType: "json",
                type: "POST",
                delay: 250,
                data: function(params){
                    return {
                        q: params.term,
                    };
                },
                processResults: function(data){
                    return {
                        results: data,
                    };
                },
                cache: true
            }
        });

        $('#add-coupon').submit(function(e){
            e.preventDefault();
            var datas = $(this).serializeArray()
            $.ajax({
                url: '<?php echo base_url().'admin/coupon_submit';?>',
                type: 'POST',
                dataType: 'json',
                data: datas,
            })
            .done(function(result) {
                // console.log(result);
                if (result.status) {
                    success_notify(result.msg)
                }else{
                    error_notify(result.msg)
                }
                setTimeout(()=>{
                    location.replace("<?php echo base_url().'admin/coupons' ?>");
                }, 2500)
            })
            .fail(function(jqXHR,exception) {
            console.log(jqXHR.responseText);
          })
        })

    });


</script>