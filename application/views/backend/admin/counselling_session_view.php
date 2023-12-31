<?php
	 $counselling_session_detail =$this->crud_model->fetchCounsellingSessionList('cs.*, u.first_name as tutor, u.biography' ,['cs_id'=>$param2])->row();
?>

                    <div class="row">
    	                <div class="form-group col-md-4">
                           <label for="Counselling Name"><b><?php echo get_phrase('Counselling Name'); ?>     :</b></label>
                        </div>
                        <div class="form-group col-md-8">
                            <?= $counselling_session_detail->cs_name ?>
    	                </div>
    	             </div>
                     <div class="row">
                        <div class="form-group col-md-4">
                           <label for="date"><b><?php echo get_phrase('date'); ?>     :</b></label>
                        </div>
                        <div class="form-group col-md-8">
                            <?= $counselling_session_detail->cs_date ?>
                        </div>
                     </div>

                     <div class="row">
                        <div class="form-group col-md-4">
                           <label for="description"><b><?php echo get_phrase('description'); ?>     :</b></label>
                        </div>
                        <div class="form-group col-md-8">
                            <?= $counselling_session_detail->description ?>
                        </div>
                     </div>

                     <div class="row">
                        <div class="form-group col-md-4">
                           <label for="tutors"><b><?php echo get_phrase('tutors'); ?>     :</b></label>
                        </div>
                        <div class="form-group col-md-8">
                            <?= $counselling_session_detail->tutor ?>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-md-4">
                           <label for="payment_type"><b><?php echo get_phrase('payment_type'); ?>     :</b></label>
                        </div>
                        <div class="form-group col-md-8">
                            <?= $counselling_session_detail->cs_payment_type ?>
                        </div>
                     </div>

                      <div class="row">
                        <div class="form-group col-md-4">
                           <label for="price"><b><?php echo get_phrase('price'); ?>     :</b></label>
                        </div>
                        <div class="form-group col-md-8">
                            <?= '₹ '.$counselling_session_detail->price ?>
                        </div>
                     </div>


                     <div class="row">
                       <div class="form-group col-md-4">
                           <label for="start_time"><b><?php echo get_phrase('start_time'); ?>     :</b></label>
                        </div>
                        <div class="form-group col-md-8">
                            <?= $counselling_session_detail->cs_start_time ?>
                        </div>
                     </div>

                     <div class="row">
                        <div class="form-group col-md-4">
                           <label for="end_time"><b><?php echo get_phrase('end_time'); ?>     :</b></label>
                        </div>
                        <div class="form-group col-md-8">
                            <?= $counselling_session_detail->cs_end_time ?>
                        </div>
                     </div>





