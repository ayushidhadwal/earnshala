<div class="row ">
	<div class="col-xl-12">
		<div class="card">
			<div class="card-body">
				<h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('manage_profile'); ?></h4>
			</div> <!-- end card body-->
		</div> <!-- end card -->
	</div><!-- end col-->
</div>

<div class="row ">
	<div class="col-xl-7">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title mb-3"><?php echo get_phrase('basic_info'); ?></h4>
				<?php
				foreach($edit_data as $row):
					$social_links = json_decode($row['social_links'], true);?>
					<?php echo form_open(site_url('admin/manage_profile/update_profile_info/'.$row['id']) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top' , 'enctype' => 'multipart/form-data'));?>

					<div class="form-group">
						<label><?php echo get_phrase('first_name');?></label>
						<input type="text" class="form-control" name="first_name" value="<?php echo $row['first_name'];?>" required/>
					</div>

					<div class="form-group">
						<label><?php echo get_phrase('last_name');?></label>
						<input type="text" class="form-control" name="last_name" value="<?php echo $row['last_name'];?>" required/>
					</div>

					<div class="form-group">
						<label><?php echo get_phrase('email');?></label>
						<input type="email" class="form-control" name="email" value="<?php echo $row['email'];?>" required/>
					</div>

					<div class="row justify-content-center">
						<button type="submit" class="btn btn-primary"><?php echo get_phrase('update_profile');?></button>
					</div>
				</form>
				<?php
			endforeach;
			?>
		</form>
	</div> <!-- end card body-->
</div> <!-- end card -->
</div>
<div class="col-xl-5">
	<div class="card">
		<div class="card-body">
			<?php foreach($edit_data as $row): ?>
				<?php echo form_open(site_url('admin/manage_profile/change_password/'.$row['id']) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
				<div class="form-group">
					<label><?php echo get_phrase('current_password');?></label>
					<input type="password" class="form-control" name="current_password" value="" required/>
				</div>
				<div class="form-group">
					<label><?php echo get_phrase('new_password');?></label>
					<input type="password" class="form-control" name="new_password" value="" required/>
				</div>
				<div class="form-group">
					<label><?php echo get_phrase('confirm_new_password');?></label>
					<input type="password" class="form-control" name="confirm_password" value="" required/>
				</div>
				<div class="row justify-content-center">
					<button type="submit" class="btn btn-info"><?php echo get_phrase('update_password');?></button>
				</div>
			</form>
		<?php endforeach; ?>
	</div>
</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function () {
	initSummerNote(['#biography']);
});
</script>
