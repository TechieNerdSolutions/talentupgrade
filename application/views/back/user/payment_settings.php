<?php
$user_data   = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
$paypal_keys = json_decode($user_data['paypal_keys'], true);
$stripe_keys = json_decode($user_data['stripe_keys'], true);
?>

					<style>
					.alert-red{
					background-color:red;
					color:white;
					}
					</style>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
		<div class="panel-body table-responsive">
		
			<?php echo translate('payment_settings'); ?>
			<hr class="sep-2">

				<form action="<?php echo site_url('user/payment_settings/save'); ?>" method="post" enctype="multipart/form-data">
				
					<div class="alert alert-red">{ Paypal settings below } </div>
				
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('paypal_client_id');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">
								<input type="text" name="paypal_client_id" class="form-control" value="<?php echo $paypal_keys[0]['production_client_id']; ?>" required />
							</div>
					</div>
					
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('production_secret_key');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">
							  <?php if (isset($paypal_keys[0]['production_secret_key'])): ?>
								  <input type="text" name="paypal_secret_key" class="form-control" value="<?php echo $paypal_keys[0]['production_secret_key']; ?>" required />
							  <?php else: ?>
								  <input type="text" name="paypal_secret_key" class="form-control" placeholder="<?php echo get_phrase('no_secret_key_found'); ?>" required />
							  <?php endif; ?>
							</div>
					</div>
					

					<div class="alert alert-red">{ Stripe settings below } </div>
							
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('stripe_secret_key');?></label>
                    		<div class="col-sm-12">
                                 <input type="text" name="stripe_secret_key" class="form-control" value="<?php echo $stripe_keys[0]['secret_live_key']; ?>" required />
							</div>
					</div>
					
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('stripe_public_key');?></label>
                    		<div class="col-sm-12">
                                 <input type="text" name="stripe_public_key" class="form-control" value="<?php echo $stripe_keys[0]['public_live_key']; ?>" required />
							</div>
					</div>
					

					<div class="alert alert-red">{ Amin & Instructor Revenue Share } </div>
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('instructor_revenue');?></label>
                    		<div class="col-sm-12">
                              <input type="number" disabled style="background: none; cursor: default;" onkeyup="calculateAdminRevenue(this.value)" class="form-control" 
							  min="0" max="100" value="<?php echo get_settings('instructor_revenue'); ?>">
							</div>
					</div>	
					
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('admin_revenue');?></label>
                    		<div class="col-sm-12">
                              <input type="number" class="form-control"  value="<?php echo get_settings('instructor_revenue'); ?>" 
							  disabled style="background: none; cursor: default;">
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
			