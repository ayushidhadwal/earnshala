<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('all_enrolled_courses'); ?>
                  
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>



<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('all_enrolled_courses'); ?></h4>

				<form id="add-social_links" class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Facebook Link</label>
							<input type="text" class="form-control" name="facebook" value="<?php echo $forum['facebook']->value; ?>">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Twitter Link</label>
							<input type="text" class="form-control" name="twitter" value="<?php echo $forum['twitter']->value; ?>">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Linkdin Link</label>
							<input type="text" class="form-control" name="linkdin" value="<?php echo $forum['linkdin']->value; ?>">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Instagram Link</label>
							<input type="text" class="form-control" name="instagram" value="<?php echo $forum['instagram']->value; ?>">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Whatsapp Link</label>
							<input type="text" class="form-control" name="whatsapp" value="<?php echo $forum['whatsapp']->value; ?>">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label for="">Youtube Link</label>
							<input type="text" class="form-control" name="youtube" value="<?php echo $forum['youtube']->value; ?>">
						</div>
					</div>
					<div class="col-md-12">
						<button class="btn btn-success"> Submit </button>
					</div>
				</form>

        </div>
    </div>
</div>
</div>

<script>
	$(function(){
		$('#add-social_links').submit(function(e){
		    e.preventDefault();
		    var datas = $(this).serializeArray()
		    $.ajax({
		        url: '<?php echo base_url().'admin/solcial_links_update';?>',
		        type: 'POST',
		        dataType: 'json',
		        data: datas,
		    })
		    .done(function(result) {
		        // console.log(result);
		        if (result.status) {
		            success_notify(result.msg)
		        }else{
		            error_notify(result.msg)
		        }
		        setTimeout(()=>{
		            location.replace("<?php echo base_url().'admin/social_links' ?>");
		        }, 2500)
		    })
		    .fail(function(jqXHR,exception) {
		    console.log(jqXHR.responseText);
		  })
		})
	})
</script>




