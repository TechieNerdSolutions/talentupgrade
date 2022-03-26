<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<div class="panel-heading"> <i class="fa fa-list"></i>&nbsp;&nbsp;<?php echo translate('all_messages');?>							
				<a href="<?php echo base_url(); ?>admin/message" class="btn btn-info btn-rounded btn-sm pull-right"> <i class="fa fa-angle-double-left"></i>
					 <?php echo translate('back'); ?>
				   
				</a>
			</div>
			<div class="panel-body table-responsive">
    		<?php echo form_open(base_url() . 'user/message/send_new/', array('class' => 'form', 'enctype' => 'multipart/form-data')); ?>
			<?php $student_list = $this->user_model->get_user()->result_array();?>
			<div class="form-group">
				<label class="col-md-12" for="example-text"><?php echo translate('select_message_destination');?></label>
                    <div class="col-sm-12">
                                <select class="form-control select2" name = "receiver">
                                    <?php foreach ($instructor_list as $instructor):
                                        if ($instructor['id'] == $this->session->userdata('user_id'))
                                            continue;
                                        ?>
                                        <option value="<?php echo $instructor['id']; ?>"><?php echo $instructor['first_name'].' '.$instructor['last_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
    				</div>
			</div>

	
		
			<div class="form-group">
				<label class="col-md-12" for="example-text"><?php echo translate('select_message_destination');?></label>
					<div class="col-sm-12">
						<textarea  class="form-control" name="message" rows="5"><?php echo translate('write_new_message'); ?></textarea>
					</div>
			</div>

    		<button type="submit" class="btn btn-info btn-block btn-rounded btn-sm"><?php echo translate('send'); ?></button>
		</form>

			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	function check_receiver() {
		var check_receiver = $('#receiver').val();
		if (check_receiver == '' || check_receiver == 0) {
			toastr.error("Please select a receiver", "Error");
            return false;
		}
	}
</script>