<?php $sections = $this->crud_model->get_section('course', $course_id)->result_array(); ?>

	<div align="center">
			<a href="javascript::void(0)" class="btn btn-info btn-rounded btn-sm" onclick="showAjaxModal('<?php echo site_url('modal/popup/add_section/'.$course_id); ?>', '<?php echo translate('add_new_section'); ?>')" style="color:white"><i class="fa fa-plus"></i> <?php echo translate('add_section'); ?></a>
			<a href="javascript::void(0)" class="btn btn-info btn-rounded btn-sm" onclick="showAjaxModal('<?php echo site_url('modal/popup/lesson_types/'.$course_id); ?>', '<?php echo translate('add_new_lesson'); ?>')" style="color:white"><i class="fa fa-plus"></i> <?php echo translate('add_lesson'); ?></a>
			<?php if (count($sections) > 0): ?>
				<a href="javascript::void(0)" class="btn btn-info btn-rounded btn-sm" onclick="showAjaxModal('<?php echo site_url('modal/popup/quiz_add/'.$course_id); ?>', '<?php echo translate('add_new_quiz'); ?>')" style="color:white"><i class="fa fa-plus"></i> <?php echo translate('add_quiz'); ?></a>
			<?php endif; ?>
	</div>
	<hr>
	
	
            <?php
            $lesson_counter = 0;
            $quiz_counter   = 0;
            foreach ($sections as $key => $section):?>

					<div class="col-sm-12" id = "section-<?php echo $section['id']; ?>">
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color:#ccc"><strong style="color:black"><?php echo translate('section').' '.++$key; ?></span>: <?php echo $section['title']; ?> </strong>
							      
								  <button type="button" class="btn btn-danger btn-rounded btn-sm pull-right" name="button" onclick="confirm_modal('<?php echo site_url('admin/sections/'.$course_id.'/delete'.'/'.$section['id']); ?>');"><i class="fa fa-times"></i> <?php echo translate('delete_section'); ?>
								  </button>
								  
								<button type="button" class="btn btn-info btn-rounded btn-sm pull-right" name="button" onclick="showAjaxModal('<?php echo site_url('modal/popup/section_edit/'.$section['id'].'/'.$course_id); ?>', '<?php echo translate('update_section'); ?>')" >
								<i class="fa fa-edit"></i> <?php echo translate('edit_section'); ?>
								</button>

							</div>
                            <div class="panel-wrapper collapse in">
                                <table class="table table-hover">
                                    <thead>
									
                        <?php
                        $lessons = $this->crud_model->get_lessons('section', $section['id'])->result_array();
                        foreach ($lessons as $index => $lesson):?>
                                        <tr>
                                            <th>
											
										<span class="font-weight-light">
                                            <?php
                                            if ($lesson['lesson_type'] == 'quiz') {
                                                $quiz_counter++; // Keeps track of number of quiz
                                                $lesson_type = $lesson['lesson_type'];
                                            }else {
                                                $lesson_counter++; // Keeps track of number of lesson
                                                if ($lesson['attachment_type'] == 'txt' || $lesson['attachment_type'] == 'pdf' || $lesson['attachment_type'] == 'doc' || $lesson['attachment_type'] == 'img') {
                                                    $lesson_type = $lesson['attachment_type'];
                                                }else {
                                                    $lesson_type = 'video';
                                                }
                                            }
                                            ?>
                                            <img src="<?php echo base_url('vendors/assets/backend/lesson_icon/'.$lesson_type.'.png'); ?>" alt="" height = "16">
                                            <?php echo $lesson['lesson_type'] == 'quiz' ? translate('quiz').' '.$quiz_counter : translate('lesson').' '.$lesson_counter; ?>
                                        </span>: <?php echo $lesson['title']; ?>
											
											</th>
											
                                            <th class="">
											
											<?php if ($lesson['lesson_type'] == 'quiz'): ?>
											
											
                                            <a href="javascript::" class="btn btn-success btn-sm btn-rounded" onclick="showAjaxModal('<?php echo site_url('modal/popup/quiz_questions/'.$lesson['id']); ?>')" style="color:white"><i class="fa fa-plus"></i></a>
											
                                            <a href="javascript::" class="btn btn-primary btn-sm btn-rounded" onclick="showAjaxModal('<?php echo site_url('modal/popup/quiz_edit/'.$lesson['id'].'/'.$course_id); ?>')" style="color:white"><i class="fa fa-edit"></i></a>
                                        <?php else: ?>
										
                                            <a href="javascript::" class="btn btn-primary btn-sm btn-rounded" onclick="showAjaxModal('<?php echo site_url('modal/popup/lesson_edit/'.$lesson['id'].'/'.$course_id); ?>')" style="color:white"><i class="fa fa-edit"></i></a>
                                        <?php endif; ?>
										
                                        <a href="javascript::" class="btn btn-danger btn-sm btn-rounded" onclick="confirm_modal('<?php echo site_url('admin/lessons/'.$course_id.'/delete'.'/'.$lesson['id']); ?>');" style="color:white"><i class="fa fa-times"></i></a>
											
											
											</th>
                                        </tr>
										 <?php endforeach; ?>
                                    </thead>
									
                                    
                                </table>
                            </div>
                        </div>
                    </div>
			  <?php endforeach; ?>