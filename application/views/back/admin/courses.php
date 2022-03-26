<div class="row">
                    <div class="col-sm-12">
				  	<div class="panel panel-info">
					<div class="panel-body table-responsive">
                           	<a href="<?php echo base_url();?>admin/new_course" 
                     			class="btn btn-default btn-xs pull-right"><i class="fa fa-plus"></i>&nbsp;<?=translate('new_course')?>
                    		</a>
					<hr class="sep-2">
					
					
                        <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><?php echo translate('title'); ?></th>
                                <th><?php echo translate('category'); ?></th>
                                <th><?php echo translate('lesson_and_section'); ?></th>
                                <th><?php echo translate('enrolled_student'); ?></th>
                                <th><?php echo translate('status'); ?></th>
                                <th><?php echo translate('price'); ?></th>
                                <th><?php echo translate('actions'); ?></th>
                            </tr>
                        </thead>
								
                        <tbody>
                           <?php 

                           foreach ($courses as $key => $course) : 
                            $instructor_details = $this->user_model->get_all_users($course['user_id'])->row_array();
                            $category_details = $this->crud_model->get_category_details_by_id($course['sub_category_id'])->row_array();
                            $enroll_history = $this->crud_model->enrol_history($course['id']);
                            $sections = $this->crud_model->get_section('course', $course['id']);
                            $lessons = $this->crud_model->get_lessons('course', $course['id']);
                            if ($course['status'] == 'draft') {
                                continue;
                            }
                           ?>
                                <tr>
                                    <td>
                                    <b><?php echo $course['title']?></b><br>
                                    <small class="text-muted"><?php echo translate('instructor').': <b>'.$instructor_details['first_name'].' '.$instructor_details['last_name'].'</b>'; ?></small>
                                    </td>
                                    <td>
                                        <span class="label label-success"><?php echo $category_details['name']; ?></span>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?php echo '<b>'.translate('total_section').'</b>: '.$sections->num_rows(); ?></small><br>
                                        <small class="text-muted"><?php echo '<b>'.translate('total_lesson').'</b>: '.$lessons->num_rows(); ?></small><br>
                                    </td>

                                    <td>
                                        <small class="text-muted"><?php echo '<b>'.translate('total_enrolment').'</b>: '.$enroll_history->num_rows(); ?></small>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($course['status'] == 'pending'): ?>
                                           
											<span class="label label-red"><?php echo translate($course['status']); ?></span>

                                        <?php elseif ($course['status'] == 'active'):?>
											<span class="label label-success"><?php echo translate($course['status']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($course['is_free_course'] == 0): ?>
                                            <?php if ($course['discount_flag'] == 1): ?>
                                                <span class="badge badge-info"><?php echo currency($course['discounted_price']); ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-primary"><?php echo currency($course['price']); ?></span>
                                            <?php endif; ?>
                                        <?php elseif ($course['is_free_course'] == 1):?>
                                            <span class="badge badge-success"><?php echo translate('free'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo site_url('home/course/'.slugify($course['title']).'/'.$course['id']); ?>"><button class="btn btn-info btn-circle btn-sm"><i class="fa fa-link"></i></button></a>
                                        <a href="<?php echo site_url('admin/edit_course/'.$course['id']); ?>"><button class="btn btn-primary btn-circle btn-sm"><i class="fa fa-edit"></i></button></a>
                                        <a href="#" onclick="confirm_modal('<?php echo site_url('admin/courses/delete/'.$course['id']); ?>');"><button class="btn btn-danger btn-circle btn-sm"><i class="fa fa-times"></i></button></a>
                                    </td>
                                </tr>
                        <?php endforeach;?>
                           

                        </tbody>
                    </table>
					
			</div>                
		</div>
	</div>
</div>
    