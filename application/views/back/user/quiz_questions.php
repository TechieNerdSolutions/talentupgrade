<?php
// $param2 is Quiz id
$quiz_details = $this->crud_model->get_lessons('lesson', $param2)->row_array();
$questions = $this->crud_model->get_quiz_questions($param2)->result_array();
?>
<?php if (count($quiz_details)): ?>
<div class="row">
<div class="col-sm-12">
		<div class="panel panel-info">
			
				<div class="panel-body table-responsive">
				<?php echo translate('questions_for').': '.$quiz_details['title']; ?>
				<button type="button" class="btn btn-outline-primary btn-sm btn-rounded alignToTitle pull-right" style="color:white" onclick="showAjaxModal('<?php echo site_url('modal/popup/question_add/'.$param2) ?>', '<?php echo translate('add_new_question'); ?>')" name="button" data-dismiss="modal"><?php echo translate('add_question'); ?></button>
				

				
				<hr class="sep-2">


   
   
   								<table class="table table-hover">
                                    <thead>
									 <?php foreach ($questions as $question): ?>
                                        <tr>
                                            <th class="text-left"><?php echo $question['title']; ?></th>
                                            <th class="text-right">
											
											
											<a href="javascript::" class="btn btn-danger btn-sm btn-circle" onclick="deleteQuizQuestionAndReloadModal('<?php echo $param2; ?>', '<?php echo $question['id']; ?>')" data-dismiss="modal" style="color:white"><i class="fa fa-times"></i></a>
											
                                            <a href="javascript::" class="btn btn-primary btn-sm btn-circle" onclick="showAjaxModal('<?php echo site_url('modal/popup/question_edit/'.$question['id'].'/'.$param2); ?>', '<?php echo translate('update_quiz_question'); ?>')" data-dismiss="modal" style="color:white"><i class="fa fa-edit"></i></a>
											
											</th>
                                        </tr>
										 <?php endforeach; ?>
										
                                    </thead>
                                   
                                </table>
   
   

			</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
            <!----TABLE LISTING ENDS--->

<!-- Init Dragula -->
<script type="text/javascript">
! function(r) {
    "use strict";
    var a = function() {
        this.$body = r("body")
    };
    a.prototype.init = function() {
        r('[data-plugin="dragula"]').each(function() {
            var a = r(this).data("containers"),
            t = [];
            if (a)
            for (var n = 0; n < a.length; n++) t.push(r("#" + a[n])[0]);
            else t = [r(this)[0]];
            var i = r(this).data("handleclass");
            i ? dragula(t, {
                moves: function(a, t, n) {
                    return n.classList.contains(i)
                }
            }) : dragula(t)
        })
    }, r.Dragula = new a, r.Dragula.Constructor = a
}(window.jQuery),
function(a) {
    "use strict";
    window.jQuery.Dragula.init()
}();
</script>

<script type="text/javascript">
jQuery(document).ready(function() {
    $('.widgets-of-quiz-question').hide();
});

$('.on-hover-action').mouseenter(function() {
    var id = this.id;
    $('#widgets-of-'+id).show();
});
$('.on-hover-action').mouseleave(function() {
    var id = this.id;
    $('#widgets-of-'+id).hide();
});

function deleteQuizQuestionAndReloadModal(quizID, questionID) {
    var deletionURL = '<?php echo site_url(); ?>'+'user/quiz_questions/'+quizID+'/delete/'+questionID;
    var reloadURL = '<?php echo site_url(); ?>'+'modal/popup/quiz_questions/'+quizID;
    confirm_modal(deletionURL);
}
</script>
