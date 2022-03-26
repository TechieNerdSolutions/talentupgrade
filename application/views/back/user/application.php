<?php $applications = $this->user_model->get_applications($this->session->userdata('user_id'), 'user');?>

			
				<?php if ($this->session->userdata('is_instructor') != 1): ?>
				
                    <?php if ($applications->num_rows() == 0): ?>
                        <?php include 'application_form.php'; ?>
                    <?php else: ?>
                        <?php include 'application_list.php'; ?>
                    <?php endif; ?>
					
				<?php else: ?>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
		<div class="panel-body table-responsive">
		
			<?php echo translate('become_an_instructor'); ?>
			<hr class="sep-2">
			
					<div class="alert alert-info" role="">
						<h4 class="alert-heading"><?php echo translate('congratulations'); ?>!</h4>
						<p><?php echo translate('you_are_already_an_instructor'); ?></p>
					</div>
			</div>	
		</div>		
	</div>
</div>
				<?php endif; ?>

			