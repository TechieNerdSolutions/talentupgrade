<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			
				<div class="panel-body">
								
            <?php $selectFromUserTableWithId = $this->db->get_where('users', array('id' => $param2))->row_array();
                  $studentSocialLinks = json_decode($selectFromUserTableWithId['social_links'], true);
            ?>			
			<form class="required-form" action="<?=site_url('admin/student/edit/'. $param2); ?>" enctype="multipart/form-data" method="post">
					<div class="row">
                    <div class="col-sm-6">
	
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?=translate('first_name');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">
								<input type="text" class="form-control" id="first_name" name="first_name" value="<?=$selectFromUserTableWithId['first_name']?>" required>
							</div>
					</div>
							
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?=translate('last_name');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">
                               <input type="text" class="form-control" id="last_name" name="last_name" value="<?=$selectFromUserTableWithId['last_name']?>" required>
							</div>
					</div>
					
					
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?=translate('biography');?></label>
                    		<div class="col-sm-12">
                               <textarea name="biography" class="form-control"><?=$selectFromUserTableWithId['biography']?></textarea>
							</div>
					</div>
					
					
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?=translate('facebook_link');?></label>
                    		<div class="col-sm-12">
                              <input type="text" id="facebook_link" name="facebook_link" value="<?=$studentSocialLinks['facebook']?>" class="form-control">
							</div>
					</div>
					
					
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?=translate('twitter_link');?></label>
                    		<div class="col-sm-12">
                               <input type="text" id="twitter_link" name="twitter_link" value="<?=$studentSocialLinks['twitter']?>" class="form-control">
							</div>
					</div>
					
					
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?=translate('linkedin_link');?></label>
                    		<div class="col-sm-12">
                               <input type="text" id="linkedin_link" name="linkedin_link" value="<?=$studentSocialLinks['linkedin']?>" class="form-control">
							</div>
					</div>


                    <div class="form-group">
							<label class="col-md-12" for="example-text"><?=translate('email');?> <b style="color:red">*</b></label>
								<div class="col-sm-12">
								   <input type="email" id="email" name="email" value="<?=$selectFromUserTableWithId['email']?>" class="form-control" required>
								</div>
					</div>


				</div>	
				
					
					 <div class="col-sm-6">
					 

						

                         <?php 
                         $paypal_keys = json_decode($selectFromUserTableWithId['paypal_keys'], true);
                         $stripe_keys = json_decode($selectFromUserTableWithId['stripe_keys'], true);
                         ?>
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?=translate('paypal_client_id');?></label>
								<div class="col-sm-12">
								   <input type="text" id="paypal_client_id" name="paypal_client_id" value="<?=$paypal_keys[0]['production_client_id']?>" class="form-control">
								   <small><?php echo translate("required_for_instructor"); ?></small>
								</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?=translate('paypal_secret_key');?> </label>
								<div class="col-sm-12">
								   <input type="text" id="paypal_secret_key"  name="paypal_secret_key" value="<?=$paypal_keys[0]['production_secret_key']?>" class="form-control">
								   <small><?=translate("required_for_instructor"); ?></small>
								</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?=translate('stripe_public_key');?> </label>
								<div class="col-sm-12">
								   <input type="text" id="stripe_public_key" name="stripe_public_key" value="<?=$stripe_keys[0]['public_live_key']?>" class="form-control">
								   <small><?=translate("required_for_instructor"); ?></small>
								</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?=translate('stripe_secret_key');?> </label>
								<div class="col-sm-12">
								   <input type="text" id="stripe_secret_key"  name="stripe_secret_key" value="<?=$stripe_keys[0]['secret_live_key']?>" class="form-control">
								   <small><?=translate("required_for_instructor"); ?></small>
								</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?=translate('browse_image');?></label>
								<div class="col-sm-12">
									  <input type='file' id="user_image" name="user_image" accept="image/*" onChange="readURL(this);">
									 <img id="blah"  src="<?=$this->user_model->get_user_image_url($param2);?>" alt="your image" height="150" width="150"/ style="border:1px dotted red">
								</div>
						</div>
					</div>
				</div>
					
					<input type="submit" class="btn btn-success btn-rounded btn-block btn-sm" value="<?=translate('save');?>">               
                    
                <?=form_close();?>						
			</div>
		</div>
	</div>
</div>