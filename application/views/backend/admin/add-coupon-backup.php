<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" />
    <style>
        
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
                        <form>
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
                                        <input type="text" class="form-control" name="coupon_discount_percentage">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Coupon Maximum Discount <em class="text-danger">Rs</em></label>
                                        <input type="text" class="form-control" name="coupon_max_discount">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Start Date</label>
                                        <input type="text" class="form-control satrt_date" name="satrt_date">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">End Date</label>
                                        <input type="text" class="form-control end_date" name="end_date">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Number of times this coupon can be used</label>
                                        <input type="text" class="form-control" name="no_of_times" min=1>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Courses</label>
                                        <select class="courses form-control" name="courses[]" multiple="multiple">
                                            <!-- <?php foreach ($users as $key => $value): ?>
                                                <option value="<?php echo $value->id; ?>"><?php echo $value->first_name.' '.$value->last_name; ?></option>
                                            <?php endforeach ?> -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Users</label>
                                        <select class="users form-control" name="courses[]" multiple="multiple">
                                          <option value="AL">Alabama</option>
                                          <option value="WY">Wyoming</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input id="test" style="width:100%;" placeholder="type a number, scroll for more results" />
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
        $.map(JSON.parse(dat), function(elem, index) {
            console.log(elem)
        })
        console.log(JSON.parse(dat))
    })

    var dat = '<?php echo json_encode($users) ?>'

    // Function to shuffle the demo data
    function shuffle(str) {
      return str
        .split('')
        .sort(function() {
          return 0.5 - Math.random();
        })
        .join('');
    }

    // For demonstration purposes we first make
    // a huge array of demo data (20 000 items)
    // HEADS UP; for the _.map function i use underscore (actually lo-dash) here
    function mockData() {
        alert()
      // return _.map(_.range(1, 20000), function(i) {
      //   return {
      //     id: i,
      //     text: shuffle('te ststr ing to shuffle') + ' ' + i,
      //   };
      // });
      return _.map(JSON.parse(dat), function(elem, index) {
          return {
            id: elem.id,
            text: elem.name,
          };
      })
    }
    (function() {
      // init select 2
      $('#test').select2({
        data: mockData(),
        placeholder: 'search',
        multiple: true,
        // query with pagination
        query: function(q) {
          var pageSize,
            results,
            that = this;
          pageSize = 20; // or whatever pagesize
          results = [];
          if (q.term && q.term !== '') {
            // HEADS UP; for the _.filter function i use underscore (actually lo-dash) here
            results = _.filter(that.data, function(e) {
              return e.text.toUpperCase().indexOf(q.term.toUpperCase()) >= 0;
            });
          } else if (q.term === '') {
            results = that.data;
          }
          q.callback({
            results: results.slice((q.page - 1) * pageSize, q.page * pageSize),
            more: results.length >= q.page * pageSize,
          });
        },
      });
    })();

</script>