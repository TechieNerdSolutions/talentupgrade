<form action="<?php echo site_url('admin/quiz_questions/'.$param2.'/add'); ?>" method="post" id = 'mcq_form'>
    <input type="hidden" name="question_type" value="mcq">
    <div class="form-group">
        <label for="title"><?php echo translate('question_title'); ?></label>
        <input class="form-control" type="text" name="title" id="title" required>
    </div>
    <div class="form-group" id='multiple_choice_question'>
        <label for="number_of_options"><?php echo translate('number_of_options'); ?></label>
        <div class="input-group">
            <input type="number" class="form-control" name="number_of_options" id="number_of_options" data-validate="required" data-message-required="Value Required" min="0">
            <div class="input-group-append" style="padding: 0px"><button type="button" class="btn btn-primary btn-sm pull-right" name="button" onclick="showOptions(jQuery('#number_of_options').val())" style="border-radius: 0px;"><i class="fa fa-check"></i></button></div>
        </div>
    </div>
	
		<div class="form-group">
			<button type="button" name="button" id = "submitButton"  data-dismiss="modal"class="btn btn-block btn-info btn-rounded btn-sm "><i class="fa fa-plus"></i>&nbsp;<?php echo translate('save');?></button>
		</div>
		
</form>
<script type="text/javascript">
function showOptions(number_of_options){
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
    $.ajax({
        url: '<?php echo site_url('admin/quiz_questions/'.$param2.'/add'); ?>',
        type: 'post',
        data: $('form#mcq_form').serialize(),
        success: function(response) {
           if (response == 1) {
                    $(document).ready(function() {
						$.toast({
							heading: 'Congratulations!!!',
							text: '<?php echo translate('question_has_been_added'); ?>',
							position: 'bottom-right',
							loaderBg: '#ff6849',
							icon: 'success',
							hideAfter: 3500,
							stack: 6
						})
					});
           }else {
                     $(document).ready(function() {
						$.toast({
							heading: 'Error !!!',
							text: '<?php echo translate('no_options_can_be_blank_and_there_has_to_be_atleast_one_answer'); ?>',
							position: 'bottom-right',
							loaderBg: '#ff6849',
							icon: 'error',
							hideAfter: 3500,
							stack: 6
						})
					});
           }
         }
    });
    showAjaxModal('<?php echo site_url('modal/popup/quiz_questions/'.$param2); ?>', '<?php echo translate('manage_quiz_questions'); ?>');
});
</script>
