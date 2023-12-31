<link rel="stylesheet" src="<?php echo base_url('assets/custom/bundles/datatables/datatables.min.css'); ?>">
<link rel="stylesheet" src="<?php echo base_url('assets/custom/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css'); ?>">
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('courses_enrolled'); ?>
                  
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>



<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('courses_enrolled'); ?></h4>

                <form class="row date-search" method="get">
                	<div class="col-md-2">
                		<label for="">Type</label>
                		<select name="type" class="form-control" id="Type">
                			<option value="start">Start Date</option>
                			<option value="end">End Date</option>
                		</select>
                	</div>
                	<div class="col-md-4">
                		<label for="">Start date</label>
                		<input type="text" class="form-control datepicker" id="start_date" name="start_date">
                	</div>
                	<div class="col-md-4">
                		<label for="">End date</label>
                		<input type="text" class="form-control datepicker" id="end_date" name="end_date">
                	</div>
                	<div class="col-md-2" style="display:flex; align-items: end; margin-bottom: 2px;">
                		<button type="submit" class="btn btn-success">Search</button>
                	</div>
                </form>

				<div class="table-responsive-sm mt-4">
			        <table id="student_list" class="table table-striped table-centered mb-0">
			            <thead>
			            <tr>
			                <th>#</th>
			                <th><?php echo get_phrase('user_name'); ?></th>
			                <th><?php echo get_phrase('course'); ?></th>
			                <th><?php echo get_phrase('date_of_add'); ?></th>
			                <th><?php echo get_phrase('date_of_expire'); ?></th>
			            </tr>
			            </thead>
			            <tbody>
			            </tbody>
			        </table>
				</div>

        </div>
    </div>
</div>
</div>

<script src="<?php echo base_url('assets/custom/bundles/datatables/datatables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/custom/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/custom/bundles/jquery-ui/jquery-ui.min.js'); ?>"></script>
<!-- Page Specific JS File -->
<script src="<?php echo base_url('assets/custom/js/page/datatables.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" integrity="sha512-CryKbMe7sjSCDPl18jtJI5DR5jtkUWxPXWaLCst6QjH8wxDexfRJic2WRmRXmstr2Y8SxDDWuBO6CQC6IE4KTA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    $(document).ready(function() {
    	$( ".datepicker" ).datepicker();
    	dataTable()
    	$('.date-search').submit(function(event) {
    		event.preventDefault()
    		dataTable($('#Type').val(), moment($('#start_date').val()).format('MM-DD-YYYY') , moment($('#end_date').val()).format('MM-DD-YYYY'))
    	});




    });

    function dataTable(type = '', start = '', end = ''){
    	// alert("<?php echo base_url('admin/courses_enrolled_list/'); ?>"+type+"/"+start+"/"+end)
    	$('#student_list').DataTable({
    	    "processing": false,
    	    pageLength: 10,
    	    "serverSide": true,
    	    paging : true,
    	    destroy : true,
    	    "ajax": {
    	        url: "<?php echo base_url('admin/courses_enrolled_list/'); ?>"+type+"/"+start+"/"+end,
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
    	        },
    	    "initComplete": function(settings, json) {
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
    	    ],
    	    'order': [
    	        [1, 'desc']
    	    ],
    	});
    }
</script>




