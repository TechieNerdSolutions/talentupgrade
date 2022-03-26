
<div class="row">
    <div class="col-sm-12">
		<div class="panel panel-info">
			<div class="panel-body table-responsive">

                <?php echo form_open(base_url(). 'user/rating/save/' , array('class' => 'form-horizontal form-groups-bordered validate'));?>

                    <!----CREATION FORM STARTS---->             
                        <div class="form-group">
                                <label class="col-md-12" for="example-text"><?php echo translate('content');?></label>
                            <div class="col-sm-12">
                                    <textarea type="text" rows="6" class="form-control" name="comment" required ><?php echo $this->db->get_where('student_feedback', array('user_id' => $this->session->userdata('user_id')))->row()->comment;?></textarea>
                            </div>
                        </div>
                                
                            
                                
                    <div class="form-group">
                        <button type="submit" class="btn btn-info btn-sm btn-block btn-rounded"> <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo translate('save');?></button>
                    </div>
                <?php echo form_close();?>            
            </div> 
        </div>                
	</div>
</div>
			<!----CREATION FORM ENDS-->