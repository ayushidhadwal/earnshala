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
                <h4 class="mb-3 header-title"><?php echo get_phrase('Coupons'); ?></h4>
                <div class="table-responsive mt-4">
                    <?php $permission_check = get_permission_status('student_export'); ?>
                    <table id="student_list" class="table table-striped table-centered mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Coupon Name</th>
                            <th>Coupon Percentage</th>
                            <th>Coupon Max Discount</th>
                            <th>Coupon start date</th>
                            <th>Coupon end date</th>
                            <th>Total limit</th>
                            <th>Single user limit</th>
                            <th>Users</th>
                            <th>Courses</th>
                            <th>Short description</th>
                            <th>Created at</th>
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

<script type="text/javascript">
    $(document).ready(function() {



        // var date = $('#date_range').val()
        // alert("<?php echo base_url('admin/users_list/'); ?>"+encodeURIComponent(date))
        // return false;
        $('#student_list').DataTable({
            "processing": false,
            pageLength: 10,
            "serverSide": true,
            "ajax": {
                // url: "<?php echo base_url('admin/users_list/'); ?>"+encodeURIComponent(date),
                url: "<?php echo base_url('admin/coupon_list'); ?>",
                dataFilter: function(data) {
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
                    console.log(response);
                    delete_coupon()
                },
            "initComplete": function(settings, json) {
                delete_coupon()
            },
            'columnDefs': [{
                'targets': 0,
                'searchable': false,
                'orderable': false,
            },
                {
                    "targets": 1,
                    "name": "tag",
                    'searchable': true,
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
                    'searchable': false,
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
                {
                    "targets": 9,
                    "name": "action",
                    'searchable': false,
                    'orderable': false
                },
                {
                    "targets": 10,
                    "name": "action",
                    'searchable': false,
                    'orderable': false
                },
                {
                    "targets": 11,
                    "name": "action",
                    'searchable': false,
                    'orderable': false
                },
            ],
            'order': [
                [1, 'desc']
            ],
        });




    });

    function delete_coupon(){
        $('.delete-coupon').click(function(e){
            e.preventDefault()
            var id = $(this).attr('data-id')
            var result = confirm_modal("<?php echo base_url().'admin/delete_coupons/' ?>"+id)
            if (result.status) {
                success_notify(result.msg)
            }else{
                error_notify(result.msg)
            }
            setTimeout(()=>{
                location.replace("<?php echo base_url().'admin/coupons' ?>");
            }, 2500)
        })
    }

    function update_date_range() {
        var x = $("#selectedValue").html();
        $("#date_range").val(x);
    }
</script>