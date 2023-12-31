<!-- $param2 is a quiz_id from lesson table as id as quiz id bcos lesson type is quiz -->
<form action="<?php echo site_url('admin/quiz_questions_new/'.$param2.'/add'); ?>" method="post" id = 'mcq_form'>
    <input type="hidden" name="question_type" value="mcq">
    
    <div class="form-group">
        <label for="title"><?php echo get_phrase('question_title'); ?></label>
        <input class="form-control" type="text" name="title" id="title" required>
    </div>

    <div class="form-group" id='multiple_choice_question'>
        <label for="number_of_options"><?php echo get_phrase('options'); ?></label>
        <div class="input-group">
            <input type="hidden" placeholder="Check tick to add questions" class="form-control" name="number_of_options" id="number_of_options" data-validate="required" data-message-required="Value Required" value="4" min="0" max="4" readonly="">
            <!-- <div class="input-group-append" style="padding: 0px"><button type="button" class="btn btn-secondary btn-sm pull-right" name="button" onclick="showOptions(4)" style="border-radius: 0px;"><i class="fa fa-check"></i></button></div> -->
        </div>
    </div>

    <div class="text-center">
        <button class = "btn btn-success" id = "submitButton" type="button" name="button" data-dismiss="modal"><?php echo get_phrase('submit'); ?></button>
    </div>
</form>
<script type="text/javascript">

showOptions(4)
function showOptions(number_of_options){
    // alert(number_of_options);
    $.ajax({
        type: "POST",
        url: "<?php echo site_url('admin/manage_multiple_choices_options'); ?>",
        data: {number_of_options : number_of_options},
        success: function(response){
            jQuery('.options').remove();
            jQuery('#multiple_choice_question').after(response);
        }
    });
}

$('#submitButton').click( function(event) {
    // console.log($('form#mcq_form').serialize());
    // return false;
    $.ajax({
        url: '<?php echo site_url('admin/quiz_questions_new/'.$param2.'/add'); ?>',
        type: 'post',
        data: $('form#mcq_form').serialize(),
        success: function(response) {
            
           if (response == 1) {
               success_notify('<?php echo get_phrase('question_has_been_added'); ?>');
           } else {
               error_notify('<?php echo get_phrase('no_options_can_be_blank_and_there_has_to_be_atleast_one_answer'); ?>');
           }
         }
    });
    showLargeModal('<?php echo site_url('modal/popup/quiz_questions_new/'.$param2); ?>', '<?php echo get_phrase('manage_quiz_questions'); ?>');
});
</script>
