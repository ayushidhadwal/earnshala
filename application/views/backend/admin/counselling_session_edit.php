<?php
     $counselling_session_detail = $this->crud_model->fetchCounsellingSessionList('cs.*, u.first_name as tutor, u.biography' ,['cs_id'=>$param2])->row();
     $instructors       = $this->user_model->get_instructor()->result_array();
?>

        <form action="<?php echo site_url('admin/counselling_session_manage/edit/'.$param2); ?>" method="post">
                    <div class="row">
                        <div class="form-group col-md-6">
                        <label for="counselling_name"><?php echo get_phrase('counselling_name'); ?></label>
                        <input class="form-control" type="text" name="counselling_name" id="counselling_name" value="<?= $counselling_session_detail->cs_name ?>" required>
                        </div>

                        <div class="form-group col-md-6">
                        <label for="date"><?php echo get_phrase('date'); ?></label>
                        <input class="form-control" type="date" value="<?= $counselling_session_detail->cs_date ?>" name="date" id="date" required>
                        </div>
                     </div>  

                    <div class="form-group">
                        <label><?php echo get_phrase('description'); ?></label>
                        <textarea name="description" class="form-control"><?= $counselling_session_detail->description ?></textarea>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="payment_type"><?php echo get_phrase('payment_type'); ?></label>
                            <select class="form-control select2" data-toggle="select2" name="payment_type" id="payment_type" required>
                                    <option value="paid" selected="selected">Paid</option>
                                    <option value="free" >Free</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price"><?php echo get_phrase('price'); ?></label>
                            <input class="form-control" step="any" value="<?= $counselling_session_detail->price ?>" type="number" min="0"  name="price" id="price" required>
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="section_id"><?php echo get_phrase('tutors'); ?></label>
                            <select class="form-control select2" data-toggle="select2" name="instructor" id="instructor_id" required>
                                <?php foreach ($instructors as $instructor): ?>
                                    <option <?= ($instructor['id'] == $counselling_session_detail->instructor_id)?'SELECTED':'' ?> value="<?php echo $instructor['id']; ?>"><?php echo $instructor['first_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="start_time"><?php echo get_phrase('start_time'); ?></label>
                            <input class="form-control" type="time" value="<?= $counselling_session_detail->cs_start_time ?>" name="start_time" id="start_time" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_time"><?php echo get_phrase('end_time'); ?></label>
                            <input class="form-control" type="time" value="<?= $counselling_session_detail->cs_end_time ?>" name="end_time" id="end_time" required>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class = "btn btn-success" type="submit" name="submit"><?php echo get_phrase('update'); ?></button>
                    </div>
             

    
    
</form>
<script type="text/javascript">
$(document).ready(function() {
    initSelect2(['#section_id']);
});
</script>
