<style>
	.activecard{
		border: 6px solid green;
	}
</style>
<div class="row">
	<!-- <div class="col-md-12 my-4">
		<button class="btn btn-info" data-toggle="modal" data-target="#newsletterFormat">Add Newsletter</button>
	</div> -->
	
	<div id="newsletterFormat" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	      	<h4 class="modal-title">Add newsletter</h4>
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>
	      <div class="modal-body">
	        <p>Some text in the modal.</p>
	      </div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-success btn-sm" >Close</button>
	        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	
	  </div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header text-center">
				 Title of the Email
			</div>
			<div class="card-body">
				<img src="https://i.imgur.com/XoXUafe.png?1" class="img-fluid" alt="template-image">
			</div>
			<div class="card-footer text-center">
				<!-- <button class="btn btn-success btn-sm">Set as Active</button> -->
				<a href="<?php echo site_url('admin/newsletterview'); ?>" target="_blank" class="btn btn-info btn-sm">View</a>
				<a href="<?php echo site_url('admin/newsletteredit/1'); ?>" target="_blank" class="btn btn-warning btn-sm">Edit</a>
				<button class="btn btn-danger btn-sm">Delete</button>
			</div>
		</div>
	</div>
</div>