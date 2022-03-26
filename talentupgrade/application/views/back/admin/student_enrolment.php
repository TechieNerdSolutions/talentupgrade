<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
			<div class="panel-body table-responsive">
				
				<div class="row">
					<div class="col-sm-6">
                    <i class="fa fa-plus"></i>  <?php echo translate('enrol_student');?>
                    <br><br>
                    <form class="" action="<?php echo site_url('admin/enrol_student/enrol'); ?>" method="post" enctype="multipart/form-data">	
								<div class="form-group">
									<label class="col-md-12" for="example-text"><?=translate('select_user');?></label>
									<div class="col-sm-12">

                                        <select class="form-control" name="user_id" id="user_id" / required>
                                            <option><?=translate('select_user');?></option>
                                            <?php 
                                                $list_user = $this->user_model->get_user()->result_array();
                                                foreach($list_user as $user) : 
                                            ?>
                                            <option value="<?=$user['id']?>"><?=$user['first_name'] . ' ' .$user['last_name']?></option>
                                            <?php endforeach;?>
                                        </select>

									</div>
								</div>


								<div class="form-group">
									<label class="col-md-12" for="example-text"><?=translate('select_a_course');?></label>
									<div class="col-sm-12">

                                        <select class="form-control" name="course_id" id="course_id" / required>
                                            <option><?=translate('select_a_course');?></option>

                                            <?php 
                                                $list_course = $this->crud_model->get_courses()->result_array();
                                                foreach($list_course as $course) : 
                                                   
                                            ?>
											<?php if($course['status'] == 'active') { ?>
                                            <option value="<?=$course['id']?>"><?=$course['title']?></option>
                                            <?php } ?>
											<?php endforeach;?>

                                        </select>

									</div>
								</div>
							
								<div class="form-group">
									<button type="submit" class="btn btn-info btn-rounded btn-block btn-sm"><i class="fa fa-plus"></i>  <?=translate('save');?></button>
								</div>

                            </form>
			    </div>



                    <div class="col-sm-6">
                        <?php echo translate('list_enrol_student');?>
                        <br><br>
				
                        <table id="example23" class="display nowrap" cellspacing="0" width="100%">
						<thead>
	
					
							<tr>
								<th><div><?php echo translate('image');?></div></th>
								<th><div><?php echo translate('user_name');?></div></th>
								<th><div><?php echo translate('enrolled_courses');?></div></th>
								<th><div><?php echo translate('enrol_date');?></div></th>
                                <th><div><?php echo translate('action');?></div></th>
							</tr>
					  
						</thead>
                    	<tbody>
						
					
                            <?php

							foreach ($enrol_history->result_array() as $enrol) : 
								$user_data = $this->db->get_where('users', array('id' => $enrol['user_id']))->row_array();
								$course_data = $this->db->get_where('course', array('id' => $enrol['course_id']))->row_array();

							?>
                            
							<tr>
								<td><img src="<?=$this->user_model->get_user_image_url($enrol['user_id']);?>" alt="User Image" width="40" height="40" class="img-circle" ></td>
								<td>
								<?=$user_data['first_name'] . ' ' .$user_data['last_name']?><br>
								<small>
								<?php echo translate('email');?> : <?=$user_data['email']?>
								</small>
								
								</td>

								<td><?=$course_data['title']?></td>
								<td><?=date('d, M Y', $enrol['date_added'])?></td>
                                <td>
								<a onclick="confirm_modal('<?=base_url()?>admin/enrol_student/delete/<?=$enrol['id']?>')" class="btn btn-danger btn-circle btn-xs" style="color:white"><i class="fa fa-times"></i></a>
								</td>
							</tr>
							<?php endforeach;?>
                           
                    </tbody>
                </table>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>