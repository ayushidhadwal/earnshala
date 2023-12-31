<?php
$live_class_detail = $this->crud_model->fetchLiveClassList('lctn.*, u.first_name as tutor, u.biography', ['live_id' => $param2])->row();
$instructors = $this->user_model->get_instructor()->result_array();
?>

<form action="<?php echo site_url('admin/live_class_manage/edit/' . $param2); ?>" method="post"
      enctype="multipart/form-data">

    <div class="row">
        <div class="form-group col-md-6">
            <label for="class_name"><?php echo get_phrase('class_name'); ?></label>
            <input class="form-control" type="text" name="class_name" id="class_name"
                   value="<?= $live_class_detail->live_class_name ?>" required>
        </div>

        <div class="form-group col-md-6">
            <label for="date"><?php echo get_phrase('date'); ?></label>
            <input class="form-control" type="date" value="<?= $live_class_detail->live_date ?>" name="date" id="date"
                   required>
        </div>
    </div>

    <div class="form-group">
        <label><?php echo get_phrase('description'); ?></label>
        <textarea name="description" class="form-control"><?= $live_class_detail->description ?></textarea>
    </div>

    <div class="row">
        <div class="form-group col-md-6">
            <label for="payment_type"><?php echo get_phrase('payment_type'); ?></label>
            <select class="form-control select2" data-toggle="select2" name="payment_type" id="payment_type"
                    onchange="getVal(this);" required>
                <option value="paid" <?= ($live_class_detail->live_payment_type === 'paid') ? 'selected' : '' ?>>Paid
                </option>
                <option value="free" <?= ($live_class_detail->live_payment_type === 'free') ? 'selected' : '' ?>>Free
                </option>
            </select>
        </div>
        <div class="form-group col-md-6 pricing <?= $live_class_detail->live_payment_type === "free" ? 'd-none' : '' ?>">
            <label for="price"><?php echo get_phrase('price'); ?></label>
            <input class="form-control" step="any" type="number" min="0" value="<?= $live_class_detail->price ?>"
                   name="price" id="prices" required>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-6 ">
            <label for="section_id"><?php echo get_phrase('tutors'); ?></label>
            <select class="form-control select2" data-toggle="select2" name="instructor" id="instructor_id" required>
                <?php foreach ($instructors as $instructor): ?>
                    <option <?= ($instructor['id'] == $live_class_detail->instructor_id) ? 'SELECTED' : '' ?>
                            value="<?php echo $instructor['id']; ?>"><?php echo $instructor['first_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="number_of_students"><?php echo get_phrase('number_of_students'); ?></label>
            <input class="form-control" type="number" min="0" value="<?= $live_class_detail->number_of_students ?>"
                   name="number_of_students" id="number_of_students" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="start_time"><?php echo get_phrase('start_time'); ?></label>
            <input class="form-control" type="time" value="<?= $live_class_detail->live_start_time ?>" name="start_time"
                   id="start_time" required>
        </div>
        <div class="form-group col-md-6">
            <label for="end_time">Duration (in Minutes)</label>
            <input class="form-control" type="number" value="<?= $live_class_detail->live_duration ?>" name="duration"
                   id="dur" required>
        </div>
    </div>
    <div class="row">
        <!--        <div class="form-group col-md-6">-->
        <!--            <label for="end_time">Language</label>-->
        <!--            <input class="form-control" type="text" value="--><? //=  ?><!--" name="language"-->
        <!--                   id="lang" required>-->
        <!--        </div>-->

        <div class="form-group col-md-6">
            <label for="end_time">Language</label>
            <select class="form-control select2" data-toggle="select2" name="language"
                    id="language" required>
                <option value="English" <?php if ($live_class_detail->live_lang === "English") echo "selected"; ?>>
                    English
                </option>
                <option value="Hindi" <?php if ($live_class_detail->live_lang === "Hindi") echo "selected"; ?>>Hindi
                </option>
            </select>
        </div>

    </div>
    <div class="text-center">
        <button class="btn btn-success" type="submit" name="submit"><?php echo get_phrase('update'); ?></button>
    </div>

</form>
<script type="text/javascript">
    $(document).ready(function () {
        initSelect2(['#section_id']);
    });

    function getVal(sel) {
        const storeVal = sel.value;
        if (storeVal === "free") {
            $('.pricing').addClass('d-none')
        } else {
            $('.pricing').removeClass('d-none')
        }

    }
</script>
