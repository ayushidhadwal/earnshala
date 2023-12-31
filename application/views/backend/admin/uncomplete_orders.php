<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('incomplete_orders'); ?>
                  
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>



<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('incomplete_orders'); ?></h4>
                <div class="row" style="display: flex; align-items:flex-end;">
                	<div class="col-md-4">
                		<label for="">Date </label>
                		<input class="form-control" type="text" name="daterange" placeholder="01/01/2023 - <?php echo date('m/d/Y'); ?>" value="" />
                	</div>
                </div>

				<div class="table-responsive-sm mt-4">
				    <?php if (count($forum) > 0): ?>
				        <table id="course-datatable-server-side" class="table table-striped dt-responsive nowrap" width="100%" data-page-length='25'>
				            <thead>
				                <tr>
				                    <th>#</th>
				                    <th><?php echo get_phrase('user_name'); ?></th>
				                    <th><?php echo get_phrase('couse'); ?></th>
				                    <th><?php echo get_phrase('email'); ?></th>
				                    <th><?php echo get_phrase('phone'); ?></th>
                                    <th><?php echo get_phrase('date'); ?></th>
				                </tr>
				            </thead>
				            <tbody>
				            	<?php foreach ($forum as $key => $value): ?>
				            	<tr>
				            	    <td><?php echo ++$key; ?></td>
				            	    <td><?php echo $value->first_name.' '.$value->last_name; ?></td>
				            	    <td><?php echo $value->title; ?></td>
				            	    <td><?php echo $value->email; ?></td>
				            	    <td><?php echo $value->phone; ?></td>
                                    <td><p><?php echo $value->created_at; ?></p></td>
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

<script>
	$(function(){
		$('#course-datatable-server-side').DataTable();
		$('input[name="daterange"]').daterangepicker({
		   opens: 'left'
		 }, function(start, end, label) {
		   // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
		   window.location.href = "<?php echo base_url();?>admin/uncomplete_orders/"+start.format('YYYY-MM-DD')+"/"+end.format('YYYY-MM-DD');
		 });
	})
</script>




