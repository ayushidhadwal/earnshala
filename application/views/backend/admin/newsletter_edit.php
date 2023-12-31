<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="row">
	<!-- <div class="col-md-12 my-4">
		<button class="btn btn-info" data-toggle="modal" data-target="#newsletterFormat">Add Newsletter</button>
	</div> -->
	<div class="offset-1 col-md-10">
		<div class="card">
			<div class="card-header text-center">
				 Edit email Template
				

				<!--  <?php
				 	$arrayName = array('2','3');

				  echo	json_encode($arrayName);

				 ?> -->

			</div>
			<form action="<?php echo base_url();?>admin/updatenewsletter/1" method="post" enctype="multipart/form-data">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="">Add Website Name</label>
								<input type="text" name="website_name" class="form-control" placeholder="Website name" value="<?php echo $newsletterDetails->newsletter_website_name; ?>">
							</div>

							<div class="form-group">
								<label for="">Add Your Email</label>
								<input type="text" name="email" class="form-control" placeholder="Your Email" value="<?php echo $newsletterDetails->newsletter_email; ?>">
							</div>

							<div class="form-group">
								<label for="">Banner Image</label>
								<input type="file" name="banner_image" class="form-control-file" placeholder="Banner Image">
								<input type="hidden" name="banner_image_old" class="form-control" placeholder="Banner Image" value="<?php echo $newsletterDetails->newsletter_image; ?>">
							</div>

							<div class="form-group">
								<label for="">Email Title</label>
								<input type="text" name="email_title" class="form-control" placeholder="Email Title" value="<?php echo $newsletterDetails->newsletter_title; ?>">
							</div>

							<div class="form-group">
								<label for="">Email Description</label>
								<textarea name="email_description" id="email_description" class="form-control" cols="30" rows="4"><?php echo $newsletterDetails->newsletter_description; ?></textarea>
							</div>

							<div class="form-group">
								<label for="">Select Courses</label>
								<select name="select_courses[]" class="form-control selectCourses" multiple>
									<?php foreach ($courses as $key => $value): ?>
										<option value="<?php echo $value->id; ?>" <?php
											if (in_array($value->id, json_decode($newsletterDetails->newsletter_courses), TRUE)){echo "selected = ''";}
											?>>
											<?php echo $value->title; ?>
										</option>
									<?php endforeach ?>
								</select>
							</div>
							<div class="form-group">
								<label for="">Footer Text</label>
								<input type="text" name="footer_text" class="form-control" placeholder="Footer text" value="<?php echo $newsletterDetails->newsletter_footer_text; ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-success btn-sm">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
	$(document).ready(function() {
		initSummerNote(['#email_description']);
	    $('.selectCourses').select2({
	        maximumSelectionLength: 2
	    });
	});
</script>