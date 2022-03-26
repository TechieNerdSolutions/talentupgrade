<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
		<div class="panel-body table-responsive">
		
			<?php echo translate('instructor_settings'); ?>
			<hr class="sep-2">

				<form action="<?php echo site_url('admin/instructor_settings/save'); ?>" method="post" enctype="multipart/form-data">
				
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('allow_website_registration');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">
								<select class="form-control select2"  name="allow_instructor" required>
									<option value="1" <?php if(get_settings('allow_instructor') == 1) echo 'selected'; ?>><?php echo translate('yes'); ?></option>
									<option value="0" <?php if(get_settings('allow_instructor') == 0) echo 'selected'; ?>><?php echo translate('no'); ?></option>
								</select>
							</div>
					</div>
					
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('verification_type');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">
								<select class="form-control select2"  name="verification_type" required>
									<option value="video" <?php if(get_settings('verification_type') == 'video') echo 'selected'; ?>><?php echo translate('video_verification'); ?></option>
									<option value="document" <?php if(get_settings('verification_type') == 'document') echo 'selected'; ?>><?php echo translate('document_verification'); ?></option>
									<option value="image" <?php if(get_settings('verification_type') == 'image') echo 'selected'; ?>><?php echo translate('image_verification'); ?></option>
								</select>
							</div>
					</div>
							
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('instructor_application_note');?></label>
                    		<div class="col-sm-12">
                                 <textarea class="form-control" name="instructor_application_note" rows="5"><?php echo get_settings('instructor_application_note'); ?></textarea>
							</div>
					</div>
					<style>
					.alert-red{
					background-color:red;
					color:white;
					}
					</style>
					<div class="alert alert-red">Instructor and Admin Revenue Settings</div>
					
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('instructor_revenue');?></label>
                    		<div class="col-sm-12">
                              <input type="number" name = "instructor_revenue" id = "instructor_revenue" class="form-control" onkeyup="calculateAdminRevenue(this.value)" min="0" max="100" value="<?php echo get_settings('instructor_revenue'); ?>">
							</div>
					</div>	
					
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('admin_revenue');?></label>
                    		<div class="col-sm-12">
                              <input type="number" name = "admin_revenue" id = "admin_revenue" class="form-control" value="0" disabled style="background: none; cursor: default;">
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
			
	<script type="text/javascript">
    $(document).ready(function() {
        var instructor_revenue = $('#instructor_revenue').val();
        calculateAdminRevenue(instructor_revenue);
    });
    function calculateAdminRevenue(instructor_revenue) {
        if(instructor_revenue <= 100){
            var admin_revenue = 100 - instructor_revenue;
            $('#admin_revenue').val(admin_revenue);
        }else {
            $('#admin_revenue').val(0);
        }
    }
</script>		
			