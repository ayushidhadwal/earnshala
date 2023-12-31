<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"><i class="mdi mdi-apple-keyboard-command title_icon"></i>
                    <?php echo $page_title; ?>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('student'); ?></h4>
                <div class="row justify-content-md-center">
                    <div class="col-xl-6">
                        <form class="form-inline"
                              action="" method="get">
                            <div class="col-xl-10">
                                <div class="form-group">
                                    <div id="reportrange" class="form-control" data-toggle="date-picker-range"
                                         data-target-display="#selectedValue" data-cancel-class="btn-light"
                                         style="width: 100%;">
                                        <i class="mdi mdi-calendar"></i>&nbsp;
                                        <span id="selectedValue"><?php echo date("F d, Y", $timestamp_start) . " - " . date("F d, Y", $timestamp_end); ?></span>
                                        <i class="mdi mdi-menu-down"></i>
                                    </div>
                                    <input id="date_range" type="hidden" name="date_range"
                                           value="<?php echo date("d F, Y", $timestamp_start) . " - " . date("d F, Y", $timestamp_end); ?>">
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <button type="submit" class="btn btn-info" id="submit-button"
                                        onclick="update_date_range();"> <?php echo get_phrase('filter'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <?php $permission_check = get_permission_status('student_export'); ?>
                    <table id="<?= $permission_check ? 'datatable-buttons' : 'basic-datatable'  ?>" class="table table-striped table-centered mb-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>State</th>
                            <th>Register Date</th>
                            <th>Enrolled Courses</th>
                            <th>Enrolled Live Class</th>
                            <th>Manual Access</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($users->result_array() as $key => $user):?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td>
                                    <img src="<?php echo $this->user_model->get_user_image_url($user['id']); ?>" alt=""
                                         height="50" width="50" class="img-fluid rounded-circle img-thumbnail">
                                </td>
                                <td><?php echo $user['first_name'] . ' ' . $user['last_name']; ?>
                                    <?php if ($user['status'] != 1): ?>
                                        <small><p><?php echo get_phrase('status'); ?>: <span
                                                        class="badge badge-danger-lighten"><?php echo get_phrase('unverified'); ?></span>
                                            </p></small>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['phone']; ?></td>
                                <td><?php echo $user['state_name']; ?></td>
                                <td><?php echo date('d-m-Y H:i A', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <?php
                                    $enrolled_courses = $this->crud_model->enrol_history_by_user_id($user['id']); ?>
                                    <ul>
                                        <?php foreach ($enrolled_courses->result_array() as $enrolled_course):
                                            $course_details = $this->crud_model->get_course_by_id($enrolled_course['course_id'])->row_array(); ?>
                                            <li><?php echo $course_details['title']; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td>
                                    <?php
                                    $liveClass = $this->crud_model->enroll_live_classes_by_user_id($user['id']); ?>
                                    <ul>
                                        <?php foreach ($liveClass->result_array() as $getLiveClass):
                                            $live_details = $this->crud_model->get_live_class_by_id($getLiveClass['el_live_id'])->row_array(); ?>
                                            <li><?php echo $live_details['live_class_name']; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/userSelectCourses/'.$user['id'])?>" class="btn btn-success">
                                        Select Courses
                                    </a>
                                </td>
                                <td>
                                    <div class="dropright dropright">
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary btn-rounded btn-icon"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"
                                                   onclick="confirm_modal('<?php echo site_url('admin/users/delete/' . $user['id']); ?>');"><?php echo get_phrase('delete'); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<script src="<?php base_url().'assets/custom/bundles/datatables/datatables.min.js' ?>"></script>
<script src="<?php base_url().'assets/custom/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js' ?>"></script>
<script src="<?php base_url().'assets/custom/bundles/jquery-ui/jquery-ui.min.js' ?>"></script>
<!-- Page Specific JS File -->
<script src="<?php base_url().'assets/custom/js/page/datatables.js' ?>"></script>

<script type="text/javascript">
    function update_date_range() {
        var x = $("#selectedValue").html();
        $("#date_range").val(x);
    }
</script>