
<!-- start page title -->
<div class="row">
  <div class="col-12">
    <div class="page-title-box ">
      <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> Edit Child Category</h4>
    </div>
  </div>
</div>

<div class="row justify-content-md-center">
  <div class="col-xl-6">
    <div class="card">
      <div class="card-body">
        <div class="col-lg-12">
          <h4 class="mb-3 header-title">Edit Child Category</h4>

          <form class="required-form" action="<?php echo site_url('admin/child_categories/edit/'.$category_details->id); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="code">Child Category Code</label>
              <input type="text" class="form-control" id="code" name = "code" value="<?php echo $category_details->code; ?>" readonly>
            </div>

            <div class="form-group">
              <label for="name">Child Category Title<span class="required">*</span></label>
              <input type="text" class="form-control" id="name" name = "name" value="<?php echo $category_details->name; ?>" required>
               <input type="hidden" name="parent" value="<?= $category_details->parent ?>">
               
            </div>

            <div class="form-group" id = "thumbnail-picker-area">
              <label><?php echo get_phrase('category_thumbnail'); ?> <small>(<?php echo get_phrase('the_image_size_should_be'); ?>: 200 X 200)</small> </label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="category_thumbnail" name="category_thumbnail" accept="image/*" onchange="changeTitleOfImageUploader(this)">
                  <label class="custom-file-label" for="category_thumbnail"><?php echo get_phrase('choose_thumbnail'); ?></label>
                </div>
              </div>
            </div>

            <button type="button" class="btn btn-primary" onclick="checkRequiredFields()"><?php echo get_phrase("submit"); ?></button>
          </form>
        </div>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<script type="text/javascript">
function checkCategoryType(category_type) {
  if (category_type > 0) {
    $('#thumbnail-picker-area').hide();
    $('#icon-picker-area').hide();
  }else {
    $('#thumbnail-picker-area').show();
    $('#icon-picker-area').show();
  }
}

$(document).ready(function () {
  var parent_category = $('#parent').val();
  checkCategoryType(parent_category);
});
</script>
