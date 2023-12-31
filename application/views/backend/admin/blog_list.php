<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?>
                <a href = "<?php echo site_url('admin/blogs_form/add_blog'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"><i class="mdi mdi-plus"></i>Add Blog</a>
            </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
              <h4 class="mb-3 header-title">Blogs</h4>
             
              <div class="table-responsive-sm mt-4">
                <table id="basic-datatable" class="table table-striped table-centered mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Title</th>
                      <th>Blogger Name</th>
                      <th>Short Description</th>
                      <th><?php echo get_phrase('actions'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($blogs as $key => $val): ?>
                      <tr id="blogid_<?= $val->blog_id ?>">
                        <td><?= ++$key ?></td>
                        <td><?= $val->blog_title ?></td>
                        <td><?= $val->blog_author ?></td>
                        <td width="40%"><?= $val->blog_short_desc ?></td>
                        <td><a href="<?= base_url('admin/blogs_form/edit_blog/'.$val->blog_id)?>"><i class="fa fa-edit"></i> Edit</a>&emsp;|&emsp;<a href="#" class="delete-blog" data-id="<?= $val->blog_id ?>"><i class="fa fa-trash"></i> Delete</a></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
              </table>
              </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body p-4">
              <form class="delete-blog-form-submit">
                <div class="text-center">
                    <i class="dripicons-information h1 text-info"></i>
                    <h4 class="mt-2"><?php echo get_phrase("heads_up"); ?>!</h4>
                    <p class="mt-3">Are you sure, you want to delete this ?</p>
                    <input type="hidden" name="blog_id" id="blog_id">
                    <button type="button" class="btn btn-info my-2" data-dismiss="modal"><?php echo get_phrase("cancel"); ?></button>
                    <button id="update_link" class="btn btn-danger my-2" type="submit"><?php echo get_phrase("continue"); ?></button>
                </div>
              </form>
                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
  $(document).ready(function(){

      $('.delete-blog').on('click', function(e){

        e.preventDefault()

          $('#delete-modal').modal('show');
          $('#blog_id').val($(this).attr('data-id'));
      })


      $('.delete-blog-form-submit').on('submit', function(e){



          let fd = new FormData(this)

         $.ajax({

        type       : 'POST',
        url        : '<?php echo site_url() ?>admin/delete_blog',
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
  })
</script>


