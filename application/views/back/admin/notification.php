<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
		<div class="panel-body table-responsive">
		
			<?php echo translate('promotion_settings'); ?>
			<hr class="sep-2">

				<form action="<?php echo site_url('admin/notification/update'); ?>" method="post" enctype="multipart/form-data">
				
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('promotion_colour');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">
								<select class="form-control select2"  name="noti_colour" required>
									<option value="green" <?php if(get_settings('noti_colour') == 'green') echo 'selected'; ?>><?php echo translate('colour_green'); ?></option>
									<option value="red" <?php if(get_settings('noti_colour') == 'red') echo 'selected'; ?>><?php echo translate('colour_red'); ?></option>
                                    <option value="purple" <?php if(get_settings('noti_colour') == 'purple') echo 'selected'; ?>><?php echo translate('colour_purple'); ?></option>
								</select>
							</div>
					</div>


					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('promotion_message');?></label>
                    		<div class="col-sm-12">
                                 <textarea class="form-control" name="noti_message" rows="5"><?php echo get_settings('noti_message'); ?></textarea>
							</div>
					</div>

					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('running_date');?></label>
                    		<div class="col-sm-12">
                                 <input class="form-control" name="noti_date" type="date" value="<?php echo get_settings('noti_date'); ?>">
							</div>
					</div>
					
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('promotion_status');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">
								<select class="form-control select2"  name="noti_status" required>
									<option value="1" <?php if(get_settings('noti_status') == 1) echo 'selected'; ?>><?php echo translate('running_promotion'); ?></option>
									<option value="2" <?php if(get_settings('noti_status') == 2) echo 'selected'; ?>><?php echo translate('not_running'); ?></option>
								</select>
							</div>
					</div>
							

					
					
					<div class="form-group">
						<button type="submit" class="btn btn-block btn-info btn-rounded btn-sm" id="add"><i class="fa fa-plus"></i>&nbsp;
						<?php echo translate('save');?></button>
					</div>
                <?php echo form_close();?>
			</div>	
		</div>		
	</div>
</div>
            <!----TABLE LISTING ENDS--->