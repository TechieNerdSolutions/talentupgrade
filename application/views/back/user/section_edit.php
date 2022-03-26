<?php
    $course_details = $this->crud_model->get_course_by_id($param3)->row_array();
    $section_details = $this->crud_model->get_section('section', $param2)->row_array();
?>

<div class="row">
     <div class="col-sm-12">
		<div class="panel panel-info">
            <div class="panel-heading"> <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo translate('edit'); ?></div>
                <form action="<?php echo site_url('user/sections/'.$param3.'/edit/'.$param2); ?>" method="post">
					<div class="panel-body table-responsive">
					
                        <div class="form-group">
                            <label class="col-md-12" for="example-text"><?php echo translate('name');?></label>
                                <div class="col-sm-12">
                                    <input name="title" id="title" type="text" class="form-control" value="<?php echo $section_details['title']; ?>"/ required>
                                </div>
                            </div>
							
						
                           <div class="form-group">
                                  <button type="submit" class="btn btn-block btn-info btn-rounded btn-sm "><i class="fa fa-plus"></i>&nbsp;<?php echo translate('save');?></button>
							</div>
                <?php echo form_close();?>
                </div>                
			</div>
		</div>
<!----CREATION FORM ENDS-->
