<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?>
                    <a href="<?php echo site_url('admin/admin_form/add_admin_form'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"><i class="mdi mdi-plus"></i><?php echo get_phrase('add_admin'); ?></a>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('admins'); ?></h4>

                <div class="row">
                    <div class="col-md-12">
                        <?php if (!empty($this->session->flashdata('educators_msg'))) { ?>
                            <div class="alert alert-danger">
                                <?php echo  $this->session->flashdata('educators_msg'); ?>
                            </div>
                        <?php }  ?>

                        <?php if (!empty($this->session->flashdata('educators_msg_success'))) { ?>
                            <div class="alert alert-success">
                                <?php echo  $this->session->flashdata('educators_msg_success'); ?>
                            </div>
                        <?php }  ?>
                    </div>
                </div>

                <div class="table-responsive-sm mt-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <img style="height: 350px;width: 300px;" src="<?php echo $educator_by_id->image; ?>" class="img-fluid" alt="">
                                        </div>
                                        <div class="col-md-7">
                                            <p><span style="font-size: 20px">Name: </span><span style="font-size: 18px"><?php echo $educator_by_id->first_name.' '.$educator_by_id->last_name; ?></span></p>
                                            <p><span style="font-size: 20px">Email: </span><span style="font-size: 18px"><?php echo $educator_by_id->email; ?></span></p>
                                            <p><span style="font-size: 20px">Biography: </span><span style="font-size: 18px"><?php echo html_entity_decode($educator_by_id->biography); ?></span></p>
                                            <p><span style="font-size: 20px">Password: </span><span style="font-size: 18px"><?php echo $educator_by_id->password_without_enc; ?></span></p>
                                            <p><span style="font-size: 20px">Facebook: </span><span style="font-size: 18px"><a href="<?php echo $educator_by_id->facebook_link; ?>" target="_blank" class="btn btn-primary btn-sm">Facebook</a></span></p>
                                            <p><span style="font-size: 20px">Twitter: </span><span style="font-size: 18px"><a href="<?php echo $educator_by_id->twitter_link; ?>" target="_blank" class="btn btn-primary btn-sm">Twitter</a></span></p>
                                            <p><span style="font-size: 20px">Linkedin: </span><span style="font-size: 18px"><a href="<?php echo $educator_by_id->linkedin_link; ?>" target="_blank" class="btn btn-primary btn-sm">Linkedin</a></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table id="basic-datatable" class="table table-striped table-centered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo get_phrase('Qualification'); ?></th>
                                <th><?php echo get_phrase('Proof'); ?></th>
                                <th><?php echo get_phrase('actions'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($educator_qualifications as $key => $educator) : ?>
                            	<tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo html_entity_decode($educator->qualification); ?></td>
                                    <td><a href="<?php echo $educator->qualification_file; ?>" target="_blank" class="btn btn-primary btn-sm">Download</a></td>
                                    <td>
                                        <div class="dropright dropright">
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#edit-<?php echo $educator->id; ?>"><?php echo get_phrase('edit'); ?></a></li>
                                                <li><a class="dropdown-item" href="#" onclick="confirm_modal('<?php echo site_url('admin/educatorsFunc/deleteQulifications/' . $educator->id); ?>');"><?php echo get_phrase('delete'); ?></a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Modal -->
                                <div id="edit-<?php echo $educator->id; ?>" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h4 class="modal-title">Edit Qualifications</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>
                                      <form class="required-form" action="<?php echo site_url('admin/educatorsFunc/update_qualification'); ?>" enctype="multipart/form-data" method="post">
                                          <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Qualifications</label>
                                                <textarea name="edu_qulification" class="form-control summernote-basic"><?php echo $educator->qualification; ?></textarea>
                                                <input type="text" name="qulification_id" value="<?php echo $educator->id; ?>">
                                                <input type="text" name="educator_id" value="<?php echo $educator_by_id->id; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Qualifications Certificate</label>
                                                <input type="file" name="quli_certify" class="form-control-file">
                                                <input type="text" name="quli_certify_old" value="<?php echo $educator->qualification_file; ?>">
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="submit" class="btn btn-success btn-sm">Submit</button>
                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                          </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>