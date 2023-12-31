<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> Banners</h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title">Add Banner</h4>

                <form action="<?php echo site_url('admin/banner_actions/add'); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file">Image</label>
                        <input class="form-control-file" type="file" name="file" id="file" required>
                    </div>
                    <div class="form-group">
                        <label for="link">Select Course</label>
                        <select name="link" id="link" class="form-control">
                            <option value="">--Select--</option>
                            <?php foreach ($courses as $course) : ?>
                                <option value="<?= $course->id ?>"><?= $course->title ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="text-center">
                        <button class = "btn btn-success" type="submit" name="submit"><?php echo get_phrase('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-3 header-title">Banners</h4>

                    <div class="table-responsive mt-4">
                        <?php if (count($banners) > 0): ?>
                            <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%" data-page-length='25'>
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Course Link</th>
                                    <th><?php echo get_phrase('actions'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($banners as $key => $value): ?>
                                    <tr>
                                        <td><?php echo ++$key; ?></td>
                                        <td>
                                            <a href="<?php echo base_url($value->banner_image); ?>" target="_blank">
                                                <img src="<?php echo base_url($value->banner_image); ?>" alt="image" class="img-fluid" width="50" height="50">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?php echo base_url("admin/course_form/course_edit/$value->banner_link"); ?>" class="btn btn-primary btn-sm" target="_blank">
                                                Open Course
                                            </a>
                                        </td>
                                        <td>
                                            <div class="dropright dropright">
                                                <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="javascript::" class="dropdown-item" onclick="confirm_modal('<?php echo site_url('admin/banner_actions/delete'.'/'.$value->banner_id); ?>');"><?php echo get_phrase('delete'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                        <?php if (count($banners) == 0): ?>
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




