<div class="tab-pane" id="live-class">
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('live_class'); ?>

                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<?php if(!isset($_GET['instructor_id'])){ ?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('add_live_class'); ?></h4>

              <form action="<?php echo site_url('admin/live_class_manage/add'); ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                <div class="form-group col-md-6">
	                <label for="class_name"><?php echo get_phrase('class_name'); ?></label>
	                <input class="form-control" type="text" name="class_name" id="class_name" required>
                </div>

	             <div class="form-group col-md-6">
                    <label for="date"><?php echo get_phrase('date'); ?></label>
                    <input class="form-control" type="date" min="" name="date" id="date" required>
	              </div>
                </div>

                <div class="form-group">
                    <label><?php echo get_phrase('description'); ?></label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
                <div class="row">
	                <div class="form-group col-md-6">
	                    <label for="payment_types"><?php echo get_phrase('payment_type'); ?></label>
	                    <select class="form-control select2" data-toggle="select2" name="payment_type" id="payment_types" onchange="getVal(this);" required>
	                            <option value="paid" selected="selected">Paid</option>
	                            <option value="free" >Free</option>
	                    </select>
	                </div>
	                <div class="form-group col-md-6 pricing">
	                    <label for="prices"><?php echo get_phrase('price'); ?></label>
	                    <input class="form-control" step="any" type="number" min="0" name="price" id="prices" required>
	                </div>
                </div>
                <div class="row">
	                <div class="form-group col-md-6">
	                    <label for="section_id"><?php echo get_phrase('tutors'); ?></label>
	                    <select class="form-control select2" data-toggle="select2" name="instructor" id="instructor_id" required>
	                        <?php foreach ($instructors as $instructor): ?>
	                            <option value="<?php echo $instructor['id']; ?>"><?php echo $instructor['first_name']; ?></option>
	                        <?php endforeach; ?>
	                    </select>
	                </div>
	                <div class="form-group col-md-6">
	                    <label for="number_of_students"><?php echo get_phrase('number_of_students'); ?></label>
	                    <input class="form-control" type="number" min="0"  name="number_of_students" id="number_of_students" required>
	                </div>
                </div>
                <div class="row">
	                <div class="form-group col-md-6">
	                    <label for="start_time"><?php echo get_phrase('start_time'); ?></label>
	                    <input class="form-control" type="time" name="start_time" id="start_time" required>
	                </div>
	                <div class="form-group col-md-6">
	                    <label for="end_time">Duration (in Minutes)</label>
	                    <input class="form-control" type="number" name="duration" id="duration" required>
	                </div>
                </div>
				<div class="row">
					<div class="form-group col-md-6">
						<label for="end_time">Image</label>
	                    <input class="form-control" type="file" name="image" id="image" required>
					</div>
					<div class="form-group col-md-6">
	                    <label for="end_time">Language</label>
                        <select class="form-control select2" data-toggle="select2" name="language"
                                id="language" required>
                            <option value="English" selected>English</option>
                            <option value="Hindi">Hindi</option>
                        </select>
	                </div>
				</div>

                <div class="text-center">
                    <button class = "btn btn-success" type="submit" name="submit"><?php echo get_phrase('submit'); ?></button>
                </div>
            </form>

        </div>
    </div>
</div>
</div>
<?php } ?>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('live_class_list'); ?></h4>

				<div class="table-responsive-sm mt-4" style="overflow-x:scroll;">
				    <?php if (count($live_class_list) > 0): ?>
				        <table id="basic-datatable" class="table table-striped dt-responsive nowrap text-center" width="100%" data-page-length='25' >
				            <thead>
				                <tr>
				                    <th>#</th>
				                    <th><?php echo get_phrase('live_class'); ?></th>
				                    <th>Instructor Name</th>
				                    <th><?php echo get_phrase('payment_type'); ?></th>
				                    <th><?php echo get_phrase('price'); ?></th>
				                    <th><?php echo get_phrase('number_of_students'); ?></th>
				                    <th>Start Date & Time</th>
				                    <th>Duration</th>
				                    <th><?php echo get_phrase('actions'); ?></th>
				                </tr>
				            </thead>
				            <tbody>
				            	<?php foreach ($live_class_list as $key => $value): ?>
				            	<tr>
				            	    <td><?php echo ++$key; ?></td>
				            	    <td><?php echo $value->live_class_name; ?></td>
				            	    <td><?php echo $value->first_name; ?></td>
				            	    <td><?php echo $value->live_payment_type; ?></td>
				            	    <td><?php echo $value->live_payment_type==="paid" ? '₹ '.$value->price : "----"; ?></td>
				            	    <td><?php echo $value->number_of_students; ?></td>
				            	    <td><?php echo $value->live_date; ?><br/><?= date('h:i A',strtotime($value->live_start_time));?></td>
				            	    <td><?php echo $value->live_duration.' minutes'; ?></td>
				            	    <td>
				            	        <div class="dropright dropright">
    				            	          <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    				            	              <i class="mdi mdi-dots-vertical"></i>
    				            	          </button>
				            	          <ul class="dropdown-menu">
				            	               <li>
                                                   <a href="javascript::" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/live_class_view/'.$value->live_id); ?>', '<?php echo get_phrase('live_class_view'); ?>')"><?php echo get_phrase('view'); ?></a>
                                               </li>
                                               	<!-- showLargeModal() -->
                                              <li>
                                                <a href="javascript::void(0)" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/live_class_edit/'.$value->live_id); ?>', '<?php echo get_phrase('update_live_class_information'); ?>')"> <?php echo get_phrase('edit_live_class'); ?></a>
                                              </li>

				            	              <li>
                                                <a href="javascript::" class="dropdown-item" onclick="confirm_modal('<?php echo site_url('admin/live_class_manage/delete'.'/'.$value->live_id); ?>');"><?php echo get_phrase('delete'); ?></a>
                                              </li>
				            	          </ul>
				            	      </div>
				            	    </td>
				            	</tr>
				            	<?php endforeach ?>
				            </tbody>
				        </table>
				    <?php endif; ?>
				    <?php if (count($live_class_list) == 0): ?>
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
</div>




<script>
	let today = new Date().toISOString().split('T')[0];
	document.getElementsByName("date")[0].setAttribute('min', today);

    function getVal(sel)
    {
        const storeVal = sel.value;
        if(storeVal==="free"){
            $('.pricing').addClass('d-none')
            $('#prices').val('')
            $('#prices').prop('required',false)
        }else{
            $('.pricing').removeClass('d-none')
            $('#prices').prop('required',true)
        }

    }
</script>
