<style>
	.s-d{
		display: none;
	}
</style>
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('partial_payment'); ?>
                  
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>



<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('partial_payment'); ?></h4>

				<div class="mt-4">

					<?php $total_intallment = 0; $price = 0; foreach ($ps as $key => $value){
						$total_intallment = $value->no_of_installments;
						$price = $value->price_per_installments;
					} ?>

					<form class="row payment-form">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Total installment </label>
										<select name="total_installment" class="form-control total_installment">
											<option value="" selected style="display:none">Select Installment</option>
											<option value="2" <?php if ($total_intallment == 2) {
												echo "selected";
											} ?>>2</option>
											<option value="3" <?php if ($total_intallment == 3) {
												echo "selected";
											} ?>>3</option>
											<option value="4" <?php if ($total_intallment == 4) {
												echo "selected";
											} ?>>4</option>
										</select>
									</div>
								</div>
								<div class="col-md-6 s-d">
									<div class="form-group">
										<label for=""> Price for each installment </label>
										<input type="text" class="form-control installment_price" name="installment_price" required>
										<input type="hidden" class="form-control" name="course_id" value="<?php echo $course_id; ?>" required>
									</div>
								</div>
							</div>

							
								<?php if (count($ps) == 0) {?>
									<div class="row">
									<?php foreach ($sections as $key => $value) {?>
									
										<div class="col-md-6 s-d">
											<div class="form-group">
												<label for=""> Sections </label>
												<input type="text" class="form-control" name="section_tilte[]" readonly value="<?php echo $value->title; ?>">
												<input type="hidden" class="form-control" name="section_id[]" readonly value="<?php echo $value->id; ?>">
											</div>
										</div>
										<div class="col-md-6 s-d">
											<div class="form-group">
												<label for="">Access in installmets </label>
												<select name="section_access[]" class="form-control section_access" required>
													<option value="" selected style="display:none">Select access</option>
												</select>
											</div>
										</div>
									
									<?php }?>
									</div>
								<?php }else{?>
									<div class="row append-here">
										
									</div>
								<?php } ?>
							<div class="row s-d">
								<div class="col-md-12">
									<button type="submit" class="btn btn-success">Submit</button>
								</div>
							</div>
						</div>
					</form>

				</div>             

        </div>
    </div>
</div>
</div>

<script>
	$(function(){
		var installment = $('.total_installment').val().trim()
		$('.installment_price').val('<?php echo $price; ?>')
		if (installment != '') {
			  $.ajax({
			      url: '<?php echo base_url().'admin/ajax_partial_payment/'.$course_id.'/';?>'+installment,
			      type: 'POST',
			      dataType: 'json',
			  })
			  .done(function(result) {
			      // console.log(result);
			      $('.append-here').html(result)
			      $('.s-d').show('slow/400/fast');
			  })
			  .fail(function(jqXHR,exception) {
			  console.log(jqXHR.responseText);
			})
		}

		$('.total_installment').change(function (e) {
			e.preventDefault();
			var installment = $(this).val().trim()
			var price = '<?php echo $forum->price ?>'
			$('.section_access').html(`<option value="" selected style="display:none">Select access</option>`)
			if (installment == 2) {
				$('.s-d').show('slow/400/fast');
				$('.installment_price').val((price/2).toFixed(2))
				$('.section_access').append(`<option value="1">After first installment</option>
									<option value="2">After second installment</option>`)
			}else if (installment == 3) {
				$('.s-d').show('slow/400/fast');
				$('.installment_price').val((price/3).toFixed(2))
				$('.section_access').append(`<option value="1">After first installment</option>
									<option value="2">After second installment</option>
									<option value="3">After third installment</option>`)
			}else if (installment == 4) {
				$('.s-d').show('slow/400/fast');
				$('.installment_price').val((price/4).toFixed(2))
				$('.section_access').append(`<option value="1">After first installment</option>
									<option value="2">After second installment</option>
									<option value="3">After third installment</option>
									<option value="4">After fourth installment</option>`)
			}
		});

		$('.payment-form').submit(function(e){
			e.preventDefault()
			var data = $(this).serializeArray()
			  $.ajax({
			      url: '<?php echo base_url().'admin/add_partial_payment';?>',
			      type: 'POST',
			      dataType: 'json',
			      data: data,
			  })
			  .done(function(result) {
			      console.log(result);
			      if (result.status) {
			          success_notify(result.msg)
			      }else{
			          error_notify(result.msg)
			      }
			      setTimeout(()=>{
			          location.replace("<?php echo base_url().'admin/enable_partial_payment/'.$course_id; ?>");
			      }, 2500)
			  })
			  .fail(function(jqXHR,exception) {
			  console.log(jqXHR.responseText);
			})
		})
	})
</script>




