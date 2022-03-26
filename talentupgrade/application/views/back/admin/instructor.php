<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">&nbsp;
				<div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="fa fa-plus"></i>&nbsp;&nbsp;
					<?=translate('add_new_instructor');?> </a> <a href="#" data-perform="panel-dismiss"></a> 
				</div>
			</div>
			<div class="panel-wrapper collapse out" aria-expanded="true">
				<div class="panel-body">
								
								
			<form class="required-form" action="<?=site_url('admin/instructor/add'); ?>" enctype="multipart/form-data" method="post">
					<div class="row">
                    <div class="col-sm-6">
	
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?=translate('first_name');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">
								<input type="text" class="form-control" id="first_name" name="first_name" required>
							</div>
					</div>
							
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?=translate('last_name');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">
                               <input type="text" class="form-control" id="last_name" name="last_name" required>
							</div>
					</div>
					
					
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?=translate('biography');?></label>
                    		<div class="col-sm-12">
                               <textarea name="biography" class="form-control"></textarea>
							</div>
					</div>
					
					
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?=translate('facebook_link');?></label>
                    		<div class="col-sm-12">
                              <input type="text" id="facebook_link" name="facebook_link" class="form-control">
							</div>
					</div>
					
					
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?=translate('twitter_link');?></label>
                    		<div class="col-sm-12">
                               <input type="text" id="twitter_link" name="twitter_link" class="form-control">
							</div>
					</div>
					
					
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?=translate('linkedin_link');?></label>
                    		<div class="col-sm-12">
                               <input type="text" id="linkedin_link" name="linkedin_link" class="form-control">
							</div>
					</div>
				</div>	
				
					
					 <div class="col-sm-6">
					 
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?=translate('email');?> <b style="color:red">*</b></label>
								<div class="col-sm-12">
								   <input type="email" id="email" name="email" class="form-control" required>
								</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?=translate('password');?> <b style="color:red">*</b></label>
								<div class="col-sm-12">
								   <input type="password" id="password" name="password" class="form-control" required>
								</div>
						</div>
						 
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?=translate('paypal_client_id');?></label>
								<div class="col-sm-12">
								   <input type="text" id="paypal_client_id" name="paypal_client_id" class="form-control">
								   <small><?php echo translate("required_for_instructor"); ?></small>
								</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?=translate('paypal_secret_key');?> </label>
								<div class="col-sm-12">
								   <input type="text" id="paypal_secret_key"  name="paypal_secret_key" class="form-control">
								   <small><?=translate("required_for_instructor"); ?></small>
								</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?=translate('stripe_public_key');?> </label>
								<div class="col-sm-12">
								   <input type="text" id="stripe_public_key" name="stripe_public_key" class="form-control">
								   <small><?=translate("required_for_instructor"); ?></small>
								</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?=translate('stripe_secret_key');?> </label>
								<div class="col-sm-12">
								   <input type="text" id="stripe_secret_key"  name="stripe_secret_key" class="form-control">
								   <small><?=translate("required_for_instructor"); ?></small>
								</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?=translate('browse_image');?></label>
								<div class="col-sm-12">
									  <input type='file' id="user_image" name="user_image" accept="image/*" onChange="readURL(this);">
									 <img id="blah"  src="<?=base_url();?>uploads/demo.png" alt="your image" height="150" width="150"/ style="border:1px dotted red">
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
</div>
					
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">              
			<div class="panel-body table-responsive"><?=translate('list_instructors');?>
			
			<hr class="sep-2">
				<table id="example23" class="display nowrap" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th><?=translate('photo'); ?></th>
                      <th><?=translate('name'); ?></th>
                      <th><?=translate('email'); ?></th>
                      <th><?=translate('number_of_active_courses'); ?></th>
                      <th><?=translate('actions'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
							<?php foreach($instructors as $key => $instructor) : ?>	
                          <tr>
                              <td><img src="<?=$this->user_model->get_user_image_url($instructor['id']);?>" alt="User Image" width="40" height="40" class="img-circle" ></td>
                              <td><?=$instructor['first_name'] . ' ' .$instructor['last_name']?><br>
							  <?php if($instructor['status'] != 1) : ?>
							  <small><?php echo translate('status');?> : <span class="label label-danger"> <?php echo translate('unverified');?></span></small>
							  <?php endif;?>

							  <?php if($instructor['status'] == 1) : ?>
							  <small><?php echo translate('status')?> : <span class="label label-success"> <?php echo translate('verified')?></span></small>
							  <?php endif;?>
							  
							  </td>
                              <td><?=$instructor['email']?></td>

                              <td>
							  
                                 <?php echo $this->user_model->get_number_of_active_courses_of_instructor($instructor['id']) . ' ' . strtolower(translate('active_courses')); ?>  
							  
							  </td>

                              <td>
							
                                    <a href="javascript:;" onclick="showAjaxModal('<?=base_url()?>modal/popup/edit_instructor/<?=$instructor['id']?>');">
                                        <button type="button" class="btn btn-rounded btn-sm btn-success"><i class="fa fa-edit"></i>&nbsp;<?=translate('edit_instructor');?></button>
                                    </a>
                                    
                                
                                    <a href="#" onclick="confirm_modal('<?=base_url()?>admin/instructor/delete/<?=$instructor['id']?>');">
                                        <button type="button" class="btn btn-danger btn-rounded btn-sm"><i class="fa fa-times"></i> <?=translate('delete_instructor');?></button>
                                    </a>

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