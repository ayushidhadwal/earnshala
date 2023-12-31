<?php
$live_class_detail = $this->crud_model->fetchLiveClassList('lctn.*, u.first_name as tutor, u.biography', ['live_id' => $param2])->row();
$enrollStudent = $this->crud_model->enroll_live_student($live_class_detail->live_id)->result();
?>

<div class="row">
    <div class="form-group col-md-4">
        <label for="class_name"><b><?php echo get_phrase('class_name'); ?> :</b></label>
    </div>
    <div class="form-group col-md-8">
        <?= $live_class_detail->live_class_name ?>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="description"><b><?php echo get_phrase('description'); ?> :</b></label>
    </div>
    <div class="form-group col-md-8">
        <?= $live_class_detail->description ?>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="tutors"><b><?php echo get_phrase('tutors'); ?> :</b></label>
    </div>
    <div class="form-group col-md-8">
        <?= $live_class_detail->tutor ?>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-4">
        <label for="payment_type"><b><?php echo get_phrase('payment_type'); ?> :</b></label>
    </div>
    <div class="form-group col-md-8">
        <?= $live_class_detail->live_payment_type ?>
    </div>
</div>

<?php if($live_class_detail->live_payment_type==="paid"): ?>

<div class="row">
    <div class="form-group col-md-4">
        <label for="price"><b><?php echo get_phrase('price'); ?> :</b></label>
    </div>
    <div class="form-group col-md-8">
        <?= $live_class_detail->price ?>
    </div>
</div>

<?php endif; ?>

<div class="row">
    <div class="form-group col-md-4">
        <label for="number_of_students"><b><?php echo get_phrase('number_of_students'); ?> :</b></label>
    </div>
    <div class="form-group col-md-8">
        <?= $live_class_detail->number_of_students ?>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="date"><b><?php echo get_phrase('date'); ?> :</b></label>
    </div>
    <div class="form-group col-md-8">
        <?= date('d-m-Y',strtotime($live_class_detail->live_date)) ?>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="start_time"><b><?php echo get_phrase('start_time'); ?> :</b></label>
    </div>
    <div class="form-group col-md-8">
        <?= date('h:i A', strtotime($live_class_detail->live_start_time)) ?>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="end_time"><b><?php echo get_phrase('end_time'); ?> :</b></label>
    </div>
    <div class="form-group col-md-8">
        <?= date('h:i A', strtotime("+ $live_class_detail->live_duration minutes", strtotime($live_class_detail->live_start_time))) ?>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="start_time"><b>Time Duration :</b></label>
    </div>
    <div class="form-group col-md-8">
        <?= $live_class_detail->live_duration.' minutes' ?>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="start_time"><b>Created At :</b></label>
    </div>
    <div class="form-group col-md-8">
        <?= date('d-m-Y h:i A',strtotime($live_class_detail->live_created_at)) ?>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="start_time"><b>Updated At :</b></label>
    </div>
    <div class="form-group col-md-8">
        <?= date('d-m-Y h:i A',strtotime($live_class_detail->live_updated_at)) ?>
    </div>
</div>


<?php
if (!empty($enrollStudent)) {
    ?>
    <div class="row">
        <table class="table table-bordered text-center">
            <thead>
            <tr>
                <th>Student Id</th>
                <th>Student Name</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($enrollStudent as $key => $getData) { ?>
                <tr>
                    <td><?= $getData->el_user_id ?></td>
                    <td><?= $getData->first_name . ' ' . $getData->last_name ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>





