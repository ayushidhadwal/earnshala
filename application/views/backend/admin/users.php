<link rel="stylesheet" src="<?php echo base_url('assets/custom/bundles/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" src="<?php echo base_url('assets/custom/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css'); ?>">
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
                <h4 class="mb-3 header-title"><?php echo get_phrase('student'); ?></h4>
                <div class="row justify-content-md-center">
                    <div class="col-xl-6">
                        <form class="form-inline"
                              action="" method="get">
                            <div class="col-xl-10">
                                <div class="form-group">
                                    <div id="reportrange" class="form-control" data-toggle="date-picker-range"
                                         data-target-display="#selectedValue" data-cancel-class="btn-light"
                                         style="width: 100%;">
                                        <i class="mdi mdi-calendar"></i>&nbsp;
                                        <span id="selectedValue"><?php echo date("F d, Y", $timestamp_start) . " - " . date("F d, Y", $timestamp_end); ?></span>
                                        <i class="mdi mdi-menu-down"></i>
                                    </div>
                                    <input id="date_range" type="hidden" name="date_range"
                                           value="<?php echo date("d F, Y", $timestamp_start) . " - " . date("d F, Y", $timestamp_end); ?>">
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <button type="button" class="btn btn-info" id="submit-button"
                                        onclick="update_date_range();"> <?php echo get_phrase('filter'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <?php $permission_check = get_permission_status('student_export'); ?>
                    <table id="student_list" class="table table-striped table-centered mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>State</th>
                            <th>Register Date</th>
                            <th>Enrolled courses</th>
                            <th>Enrolled Live Class</th>
                            <th>Manual Access</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<script src="<?php echo base_url('assets/custom/bundles/datatables/datatables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/custom/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/custom/bundles/jquery-ui/jquery-ui.min.js'); ?>"></script>
<!-- Page Specific JS File -->
<script src="<?php echo base_url('assets/custom/js/page/datatables.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" integrity="sha512-CryKbMe7sjSCDPl18jtJI5DR5jtkUWxPXWaLCst6QjH8wxDexfRJic2WRmRXmstr2Y8SxDDWuBO6CQC6IE4KTA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    $(document).ready(function() {
        dataTableAjax()
    });

    function dataTableAjax(dateRange1 = '', dateRange2 = ''){
        // alert("<?php echo base_url('admin/users_list/'); ?>"+dateRange1+"/"+dateRange2)
        $('#student_list').DataTable({
            "processing": true,
            pageLength: 10,
            "serverSide": true,
            "bDestroy": true,
            "ajax": {
                // url: "<?php echo base_url('admin/users_list/'); ?>"+encodeURIComponent(date),
                url: "<?php echo base_url('admin/users_list/'); ?>"+dateRange1+"/"+dateRange2,
                dataFilter: function(data) {
                    // console.log(data);
                    var json = jQuery.parseJSON(data);
                    json.recordsTotal = json.recordsTotal;
                    json.recordsFiltered = json.recordsFiltered;
                    json.data = json.data;
                    return JSON.stringify(json); // return JSON string
                }
            },
            "drawCallback": function (settings) { 
                    // Here the response
                    var response = settings.json;
                    // console.log(response);
                },
            "initComplete": function(settings, json) {
            },
            'columnDefs': [
                {
                    'targets': 0,
                    'searchable': false,
                    'orderable': false,
                },
                {
                    "targets": 1,
                    "name": "name",
                    'searchable': false,
                    'orderable': true
                },

                {
                    "targets": 2,
                    "name": "image",
                    'searchable': false,
                    'orderable': true
                },
                {
                    "targets": 3,
                    "name": "allot_date",
                    'searchable': true,
                    'orderable': true
                },
                {
                    "targets": 4,
                    "name": "action",
                    'searchable': false,
                    'orderable': false
                },
                {
                    "targets": 5,
                    "name": "action",
                    'searchable': false,
                    'orderable': false
                },
                {
                    "targets": 6,
                    "name": "action",
                    'searchable': false,
                    'orderable': false
                },
                {
                    "targets": 7,
                    "name": "action",
                    'searchable': false,
                    'orderable': false
                },
                {
                    "targets": 8,
                    "name": "action",
                    'searchable': false,
                    'orderable': false
                },
                // {
                //     "targets": 9,
                //     "name": "action",
                //     'searchable': false,
                //     'orderable': false
                // },
            ],
            'order': [
                [1, 'desc']
            ],
        });
    }

    function update_date_range() {
        var x = $("#selectedValue").html();
        $("#date_range").val(x);
        const myArray = x.split(" - ");
        let start1 = moment(myArray[0]).format('YYYY-MM-DD');
        let start2 = moment(myArray[1]).format('YYYY-MM-DD');
        dataTableAjax(start1, start2)
    }
</script>