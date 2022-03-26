<?php

// $param 2 is the quiz id
$quiz_details = $this->crud_model->get_lessons('lesson', $param2)->row_array();
$questions = $this->crud_model->get_quiz_questions($param2)->result_array();

?>

<?php if(count($quiz_details)) : ?>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
			
			<div class="panel-body table-responsive">
				<?php echo translate('question_for') . ': ' . $quiz_details['title'];?>
				<button type="button" class="btn btn-outline-primary btn-sm btn-rounded alignToTitle pull-right" onclick="showAjaxModal('<?php echo site_url('modal/popup/question_add/'.$param2) ?>', '<?php echo translate('add_new_question'); ?>')" name="button" data-dismiss="modal"><?php echo translate('add_question'); ?></button>
								

				
				<hr class="sep-2">


   
   
   								<table class="table table-hover">
                                    <thead>
									<?php foreach ($questions as $key => $question) { ?>
									
									
                                        <tr>
                                            <th class="text-left"><?php echo $question['title'];?></th>
                                            <th class="text-right">
											
											
											<a href="javascript::" class="btn btn-danger btn-sm btn-circle" onclick="deleteQuizQuestionAndReloadModal('<?php echo $param2;?>', '<?php echo $question['id'];?>')" data-dismiss="modal" style="color:white"><i class="fa fa-times"></i></a>
											
                                            <a href="javascript::" class="btn btn-primary btn-sm btn-circle" onclick="showAjaxModal('<?php echo site_url('modal/popup/question_edit/' . $question['id'] . '/' . $param2);?>', '<?php echo translate('update_quiz_question'); ?>')" data-dismiss="modal" style="color:white"><i class="fa fa-edit"></i></a>
											
											</th>
                                        </tr>
									<?php } ?>
										
										
                                    </thead>
                                   
                                </table>

			</div>
		</div>
	</div>
</div>
<?php endif;?>


	<script type="text/javascript">

		function deleteQuizQuestionAndReloadModal(quizdID, questionID){
			var deletionURL = '<?php echo site_url();?>' + 'admin/quiz_questions/' + quizdID + '/delete/' + questionID;
			var reloadURL = '<?php echo site_url();?>' + 'modal/popup/quiz_questions/' + quizdID;
			confirm_modal(deletionURL);

		}

	</script>

