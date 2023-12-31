<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('Forum'); ?>
                  
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>



<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('forum_list'); ?></h4>

				<div class="table-responsive-sm mt-4">
				    <?php if (count($forum) > 0): ?>
				        <table id="course-datatable-server-side" class="table table-striped dt-responsive nowrap" width="100%" data-page-length='25'>
				            <thead>
				                <tr>
				                    <th>#</th>
				                    <th><?php echo get_phrase('user_name'); ?></th>
				                    <th><?php echo get_phrase('query'); ?></th>
                                    <th><?php echo get_phrase('query_brief'); ?></th>
                                    <th><?php echo get_phrase('tags'); ?></th>
                                    <th><?php echo get_phrase('status'); ?></th>
                                    <!-- <th><?php echo get_phrase('replies'); ?></th> -->
                                    <th><?php echo get_phrase('created_date'); ?></th>
				                    <th><?php echo get_phrase('actions'); ?></th>
				                </tr>
				            </thead>
				            <tbody>
				            	<?php foreach ($forum as $key => $value): ?>
				            	<tr>
				            	    <td><?php echo ++$key; ?></td>
				            	    <td><?php echo $value->first_name.' '.$value->last_name; ?></td>
				            	    <td><?php echo $value->f_query_question; ?></td>
                                    <td><p><?php echo $value->f_query_brief; ?></p></td>
                                    <td><?php echo $value->f_add_tags; ?></td>
                                    <td><button type="button" class="btn btn-sm <?= ($value->f_status == 1)?'btn-outline-success':'btn-outline-warning' ?> btn-rounded btn-icon" data-toggle="dropdown" onclick="confirm_modal('<?php echo site_url('admin/forum_manage/update'.'/'.$value->f_id.'/'.$value->f_status); ?>');" aria-haspopup="true" aria-expanded="false"><?= ($value->f_status == 1)?'active':'inactive' ?></button>
                                      
                                    </td>
                                   <!--  <td> 
                                        <a href="javascript::void(0)" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" onclick="showAjaxModal('<?php echo site_url('modal/popup/forum_reply/'.$value->f_id); ?>', '<?php echo get_phrase('user_forum'); ?>')" style="background-color:skyblue!important;color:black;border:skyblue!important;"> <?php echo get_phrase('reply'); ?>
                                        </a>
                                    </td> -->
                                    <td><?php echo $value->f_created_date; ?></td>
				            	    <td>
				            	        <div class="dropright dropright">
    				            	          <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    				            	              <i class="mdi mdi-dots-vertical"></i>
    				            	          </button>
				            	          <ul class="dropdown-menu">
				            	              <li>
                                                <a href="<?php echo base_url('admin/redirection/forum_replies/'.$value->f_id); ?>"  class="dropdown-item"  > <?php echo get_phrase('view'); ?>
                                                </a>
                                                <a href="javascript::" class="dropdown-item" onclick="confirm_modal('<?php echo site_url('admin/forum_manage/delete'.'/'.$value->f_id); ?>');"><?php echo get_phrase('delete'); ?></a>
                                              </li>
				            	          </ul>
				            	         </div>
				            	    </td>
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




