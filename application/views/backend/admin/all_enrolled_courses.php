<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<style>
	.btn-primary {
	    color: #fff;
	    background-color: #47a72b;
	    border-color: #47a72b;
	}
	.btn.btn-default.active.toggle-off{
		background-color: #fd5a5a;
		color: #fff;
		border-color: #fd5a5a;
	}
</style>
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('all_enrolled_courses'); ?>
                  
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>



<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('all_enrolled_courses'); ?></h4>

				<div class="table-responsive-sm mt-4">
				    <?php if (count($enrolled_course) > 0): ?>
				        <table id="course-datatable-server-side" class="table table-striped dt-responsive nowrap" width="100%" data-page-length='25'>
				            <thead>
				                <tr>
				                    <th>#</th>
				                    <th><?php echo get_phrase('serial_no'); ?></th>
				                    <th><?php echo get_phrase('course_name'); ?></th>
				                    <th><?php echo get_phrase('enroll_date'); ?></th>
				                    <th><?php echo get_phrase('access_status'); ?></th>
                                    <th><?php echo get_phrase('payment_status'); ?></th>
                                    <th><?php echo get_phrase('select_multiple_courses'); ?></th>
                                    <th><?php echo get_phrase('course_price'); ?></th>
				                </tr>
				            </thead>
				            <tbody>
				            	<?php foreach ($enrolled_course as $key => $value): ?>
				            	<tr>
				            	    <td><?php echo ++$key; ?></td>
				            	    <td><?php echo $value->first_name.' '.$value->last_name; ?></td>
				            	    <td><?php echo $value->title; ?></td>
				            	    <td><?php echo date('d-M-Y', $value->date_added); ?></td>
				            	    <td><input class="access_button" type="checkbox" <?php if ($value->status == 1) {
				            	    	echo "checked";
				            	    } ?> data-toggle="toggle" data-on="Enabled" data-off="Disabled" data-id="<?php echo $value->id; ?>" data-value="<?php if ($value->status == 1) {
				            	    	echo "0";
				            	    }else{
				            	    	echo "1";
				            	    } ?>"></td>
                                    <td><?php if (!empty(getPaymentDetails($value->user_id, $value->course_id))) { ?>
                                    	<span class="badge badge-success">Done</span>
                                    	<p><em class="text-muted">Type: <?php echo getPaymentDetails($value->user_id, $value->course_id)->payment_type; ?></em></p>
                                    	<p><em class="text-muted">TXN Id: <?php echo getPaymentDetails($value->user_id, $value->course_id)->transaction_id; ?></em></p>
                                    <?php }else{?>
                                    	<span class="badge badge-pill badge-dark">Not</span>
                                    <?php } ?></td>
                                    <td><input type="checkbox" class="form-control" readonly disabled checked></td>
                                    <td><p><?php if ($value->price != 0): ?>
		                                    	&#8377 <?php echo $value->price; ?>
		                                    <?php endif ?>
                                    	<?php if ($value->price == 0): ?>
	                                    	<span class="badge badge-pill badge-dark">Free</span>
	                                    <?php endif ?>
                                    </p></td>
                                </tr>
				            	<?php endforeach ?>
				            </tbody>
				        </table>
				    <?php endif; ?>
				    <?php if (count($enrolled_course) == 0): ?>
				        <div class="img-fluid w-100 text-center">
				          <img style="opacity: 1; width: 100px;" src="<?php echo base_url('assets/backend/images/file-search.svg'); ?>"><br>
				          <?php echo get_phrase('no_data_found'); ?>
				        </div>
				    <?php endif; ?>
				</div>             

        </div>
    </div>
</div>
</div>

<script>
	$(function(){
		$('.access_button').parent('.toggle').click(function (e) {
			e.preventDefault();
			var id = $(this).children('input').attr('data-id')
			var value = $(this).children('input').attr('data-value')
			  $.ajax({
			      url: '<?php echo base_url().'admin/change_enroll_access';?>',
			      type: 'POST',
			      dataType: 'json',
			      data: {'id': id, 'value': value},
			  })
			  .done(function(result) {
			      console.log(result);
			      if (result.status) {
			          success_notify(result.msg)
			      }else{
			          error_notify(result.msg)
			      }
			      setTimeout(()=>{
			          location.replace("<?php echo base_url().'admin/student_enrolled_courses/'.$user_id; ?>");
			      }, 2500)
			  })
			  .fail(function(jqXHR,exception) {
			  console.log(jqXHR.responseText);
			})
		});
	})
</script>




