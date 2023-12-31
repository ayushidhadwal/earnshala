<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('Quizes'); ?>
                  
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- 
<div class="row">
    <div class="col-12">
        <div class="card widget-inline">
            <div class="card-body p-0">
                <div class="row no-gutters">
                    <div class="col-sm-6 col-xl-3">
                        <a href="<?php echo site_url('admin/courses'); ?>" class="text-secondary">
                            <div class="card shadow-none m-0">
                                <div class="card-body text-center">
                                    <i class="dripicons-link text-muted" style="font-size: 24px;"></i>
                                    <h3><span><?php echo $status_wise_courses['active']->num_rows(); ?></span></h3>
                                    <p class="text-muted font-15 mb-0"><?php echo get_phrase('active_courses'); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <a href="<?php echo site_url('admin/courses'); ?>" class="text-secondary">
                            <div class="card shadow-none m-0 border-left">
                                <div class="card-body text-center">
                                    <i class="dripicons-link-broken text-muted" style="font-size: 24px;"></i>
                                    <h3><span><?php echo $status_wise_courses['pending']->num_rows(); ?></span></h3>
                                    <p class="text-muted font-15 mb-0"><?php echo get_phrase('pending_courses'); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <a href="<?php echo site_url('admin/courses'); ?>" class="text-secondary">
                            <div class="card shadow-none m-0 border-left">
                                <div class="card-body text-center">
                                    <i class="dripicons-star text-muted" style="font-size: 24px;"></i>
                                    <h3><span><?php echo $this->crud_model->get_free_and_paid_courses('free')->num_rows(); ?></span></h3>
                                    <p class="text-muted font-15 mb-0"><?php echo get_phrase('free_courses'); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <a href="<?php echo site_url('admin/courses'); ?>" class="text-secondary">
                            <div class="card shadow-none m-0 border-left">
                                <div class="card-body text-center">
                                    <i class="dripicons-tags text-muted" style="font-size: 24px;"></i>
                                    <h3><span><?php echo $this->crud_model->get_free_and_paid_courses('paid')->num_rows(); ?></span></h3>
                                    <p class="text-muted font-15 mb-0"><?php echo get_phrase('paid_courses'); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>

                </div> <!-- end row
            </div>
        </div> <!-- end card-box
    </div> <!-- end col
</div> -->

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('add_quiz'); ?></h4>

              <form action="<?php echo site_url('admin/quizes_new/add'); ?>" method="post">
                <div class="form-group">
                    <label for="title"><?php echo get_phrase('quiz_title'); ?></label>
                    <input class="form-control" type="text" name="title" id="title" required>
                </div>
               <!--  <div class="form-group">
                    <label for="section_id"><?php echo get_phrase('section'); ?></label>
                    <select class="form-control select2" data-toggle="select2" name="section_id" id="section_id" required>
                        <?php foreach ($sections as $section): ?>
                            <option value="<?php echo $section['id']; ?>"><?php echo $section['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div> -->
                <div class="form-group">
                    <label><?php echo get_phrase('instruction'); ?></label>
                    <textarea name="summary" class="form-control"></textarea>
                </div>
                <div class="text-center">
                    <button class = "btn btn-success" type="submit" name="submit"><?php echo get_phrase('submit'); ?></button>
                </div>
            </form>

        </div>
    </div>
</div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('quizes_list'); ?></h4>

				<div class="table-responsive-sm mt-4">
				    <?php if (count($quizes) > 0): ?>
				        <table id="course-datatable-server-side" class="table table-striped dt-responsive nowrap" width="100%" data-page-length='25'>
				            <thead>
				                <tr>
				                    <th>#</th>
				                    <th><?php echo get_phrase('quiz_title'); ?></th>
				                    <th><?php echo get_phrase('instruction'); ?></th>
				                    <th><?php echo get_phrase('actions'); ?></th>
				                </tr>
				            </thead>
				            <tbody>
				            	<?php foreach ($quizes as $key => $value): ?>
				            	<tr>
				            	    <td><?php echo ++$key; ?></td>
				            	    <td><?php echo $value->q_title; ?></td>
				            	    <td><?php echo $value->q_summary; ?></td>
				            	    <td>
				            	        <div class="dropright dropright">
    				            	          <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    				            	              <i class="mdi mdi-dots-vertical"></i>
    				            	          </button>
				            	          <ul class="dropdown-menu">
				            	               <li>
                                                   <a href="javascript::" class="dropdown-item" onclick="showLargeModal('<?php echo site_url('modal/popup/quiz_questions_new/'.$value->q_id); ?>', '<?php echo get_phrase('manage_quiz_questions'); ?>')"><?php echo get_phrase('add_quiz_questions'); ?></a>
                                               </li> 
                                              <li>
                                                <a href="javascript::void(0)" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/quiz_edit_new/'.$value->q_id); ?>', '<?php echo get_phrase('update_quiz_information'); ?>')"> <?php echo get_phrase('edit_quiz'); ?></a>
                                              </li>
				            	              <li>
                                                <a href="javascript::" class="dropdown-item" onclick="confirm_modal('<?php echo site_url('admin/quizes_new/delete'.'/'.$value->q_id); ?>');"><?php echo get_phrase('delete'); ?></a>
                                                
                                              </li>
				            	          </ul>
				            	      </div>
				            	    </td>
				            	</tr>
				            	<?php endforeach ?>
				            </tbody>
				        </table>
				    <?php endif; ?>
				    <?php if (count($quizes) == 0): ?>
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




