
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
			<div class="panel-body table-responsive">


                    <?php 

                    $course_details = $this->crud_model->get_course_by_id($param3)->row_array();
                    $section_details = $this->crud_model->get_section('section', $param2)->row_array();



                    ?>




                    <form action="<?php echo site_url('admin/sections/' . $param3. '/edit/'. $param2)?>" method="post">
                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo translate('edit_section');?></label>
                            <div class="col-sm-12">
								<input type="text" name = "title" id = "title" class="form-control" value="<?php echo $section_details['title']?>" / required>
							</div>
					</div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-rounded btn-block btn-sm"><i class="fa fa-edit"></i>  <?php echo translate('edit');?></button>
                    </div>

                    </form>


            </div>
        </div>
    </div>
</div>