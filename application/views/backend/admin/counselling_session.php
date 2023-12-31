<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('counselling_session'); ?>

                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('counselling_session_list'); ?></h4>

				<div class="table-responsive-sm mt-4" style="overflow-x:scroll;">
				    <?php if (count($counselling_session_list) > 0): ?>
				        <table id="basic-datatable" class="table table-striped text-center" data-page-length='25' >
				            <thead>
				                <tr>
				                    <th>#</th>
				                    <th>Counsellor Name</th>
                                    <th>Date & Time</th>
                                    <th>Price</th>
                                    <th>User Name</th>
				                </tr>
				            </thead>
				            <tbody>
				            	<?php foreach ($counselling_session_list as $key => $value):
                                    $d = getUserData($value->ec_teacher_id) ?>
				            	<tr>
				            	    <td><?php echo ++$key; ?></td>
				            	    <td>
                                        <img src="<?php echo site_url('uploads/user_image/'.$d->image.'.jpg')?>" alt="" height="50" width="50" class="img-fluid rounded-circle img-thumbnail">
                                        <br>
                                        <?php echo $d->first_name.' '.$d->last_name ?></td>
                                    <td><?php echo date('d-M-Y',strtotime($value->ec_date)).'<br>'.date('h:i A',strtotime($value->ec_time)); ?></td>
				            	    <td>₹ <?php echo $value->ec_price ?> /<?php echo $value->ec_type===1 ? " Half Hour":" Hour"; ?></td>
				            	    <td>
                                        <img src="<?php echo $this->user_model->get_user_image_url($value->ec_user_id);?>" alt="" height="50" width="50" class="img-fluid rounded-circle img-thumbnail">
                                        <br>
                                        <?php echo $value->first_name.' '.$value->last_name; ?></td>
				            	</tr>
				            	<?php endforeach ?>
				            </tbody>
				        </table>
				    <?php endif; ?>
				    <?php if (count($counselling_session_list) == 0): ?>
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
	var today = new Date().toISOString().split('T')[0];
	document.getElementsByName("date")[0].setAttribute('min', today);
</script>
