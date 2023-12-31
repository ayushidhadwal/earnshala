<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('reviews'); ?>
                  
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>



<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('reviews'); ?></h4>

				<div class="table-responsive-sm mt-4">
				    <?php if (count($forum) > 0): ?>
				        <table id="course-datatable-server-side" class="table table-striped dt-responsive nowrap" width="100%" data-page-length='25'>
				            <thead>
				                <tr>
				                    <th>#</th>
				                    <th><?php echo get_phrase('user_name'); ?></th>
				                    <th><?php echo get_phrase('couse'); ?></th>
				                    <th><?php echo get_phrase('reviews'); ?></th>
				                    <th><?php echo get_phrase('date'); ?></th>
                                    <th><?php echo get_phrase('action'); ?></th>
				                </tr>
				            </thead>
				            <tbody>
				            	<?php foreach ($forum as $key => $value): ?>
				            	<tr>
				            	    <td><?php echo ++$key; ?></td>
				            	    <td><?php echo $value->first_name.' '.$value->last_name; ?></td>
				            	    <td><?php echo $value->title; ?></td>
				            	    <td>
				            	    	<p><span>Review: </span><?php echo $value->rating; ?></p>
				            	    	<p><?php echo $value->review; ?></p>
				            	    </td>
				            	    <td><?php echo date('d-m-Y h:i a', strtotime($value->last_modified)); ?></td>
                                    <td><a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="confirm_modal('<?php echo site_url('admin/delete_review/'.$value->id.'/'.$value->ratable_id); ?>');">Delete</a></td>
                                </tr>
				            	<?php endforeach ?>
				            </tbody>
				        </table>
				    <?php endif; ?>
				    <?php if (count($forum) == 0): ?>
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




