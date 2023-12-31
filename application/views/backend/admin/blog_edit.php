<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> Edit Blog</h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">

              <!--   <h4 class="header-title mb-3"><?php echo get_phrase('course_adding_form'); ?>
                    <a href="<?php echo site_url('admin/courses'); ?>" class="alignToTitle btn btn-outline-secondary btn-rounded btn-sm"> <i class=" mdi mdi-keyboard-backspace"></i> <?php echo get_phrase('back_to_course_list'); ?></a>
                </h4> -->

                <div class="row w-100">
                    <div class="col-xl-12">
                        <div id="testss">
                            aidjjdidaijda
                        </div>
                        <div id="errorMsg">
                            
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <form class="blog-submit"  method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Title" required="" value="<?= $blog->blog_title ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>Blogger Name</label>
                                    <input type="text" name="blogger_name" class="form-control" placeholder="Blogger Name" required="" value="<?= $blog->blog_author ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Short Description</label>
                                <textarea class="form-control" name="shortdesc" required="" rows="3" placeholder="Short Description Type here..."><?= $blog->blog_short_desc ?></textarea>
                            </div>
                             <div class="form-group">
                                <label>Image</label>
                                <br>
                                <img src="<?= base_url($blog->blog_image)?>" class="img-fluid mb-3" style="width: 300px;">
                                <input type="file" name="image" class="form-control" accept="image/*">
                                <input type="hidden" name="oldimage" value="<?= $blog->blog_image ?>">
                                <input type="hidden" name="blog_id" value="<?= $blog_id ?>">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="description"><?php echo get_phrase('description'); ?></label>
                                    <textarea name="description" id = "description" class="form-control">
                                        <?= $blog->blog_description ?>
                                    </textarea>
                            </div>
                             <div class="form-group float-right">
                                <!-- <button class="btn btn-warning btn-sm" type="reset">Reset</button>&nbsp; -->
                                <button class="btn btn-success btn-sm" type="submit">Submit</button>
                            </div>
                    </form>
                </div>
            </div><!-- end row-->
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div>
</div>

<script type="text/javascript">
  $(document).ready(function () {
    initSummerNote(['#description']);

   

  });
</script>

<script type="text/javascript">
    $('.blog-submit').on('submit', function(e){

        e.preventDefault()

        let fd = new FormData(this)

        $.ajax({

        type       : 'POST',
        url        : '<?php echo site_url() ?>admin/blog_edit',
        dataType   : 'JSON',
        data       : fd,
        processData: false,
        contentType: false,
        success    : function(result) {


            // console.log(result)
            // return false 

            if(result.status)
            {
                window.location.reload()
                // window.location.href = "<?=  base_url('admin/blog_form/blog_list') ?>"
            }
            else
            {
                $('#errorMsg').html(`<div class="alert alert-danger">${result.msg}</div>`);

                setTimeout(function() {
                    $("#errorMsg").html('')
                }, 3000);

            }


        },error: function(jqXHR, exception) {
            console.log(jqXHR.responseText);
            console.log('bye');
        }
    })
    })
</script>

<style media="screen">
body {
  overflow-x: hidden;
}
</style>
