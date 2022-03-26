<!-- .row -->

<div class="row">
                    <div class="col-sm-12">
				  	<div class="panel panel-info">
					<div class="panel-body table-responsive">
							
							
							
							<style>
							.badge-danger{
							background-color:red;
							color:white;
							}
							</style>
								
                                <div class="sttabs tabs-style-bar">
                                    <nav>
                                        <ul>
                                            <li><a href="#section-bar-1" class="sticon ti-angle-double-left"><span><?=translate('terms_&_condition')?></span></a></li>
                                            <li><a href="#section-bar-2" class="sticon ti-angle-double-right"><span><?=translate('application_form')?></span></a></li>
                                        </ul>
                                    </nav>
									
                                    <div class="content-wrap">
                                        <section id="section-bar-1">
					
										<?=get_frontend_settings('terms_and_condition'); ?>
										
                                        </section>
										
												
                                        <section id="section-bar-2">
										<form class="required-form" action="<?php echo site_url('user/application'); ?>" method="post" enctype="multipart/form-data">
											<input type="hidden" name="id" value="<?php echo $this->session->userdata('user_id'); ?>">
				
											<div class="form-group">
												<label class="col-md-12" for="example-text"><?php echo translate('name');?> <b style="color:red">*</b></label>
													<div class="col-sm-12">
															<input type="text" class="form-control" name="name" id="name" aria-describedby="name-help" 
															placeholder="<?php echo translate('your_name_will_go_here'); ?>" 
															value="<?php echo $user_details['first_name'].' '.$user_details['last_name']; ?>" readonly required>
													</div>
											</div>
					
							
											<div class="form-group">
												<label class="col-md-12" for="example-text"><?php echo translate('email');?> <b style="color:red">*</b></label>
													<div class="col-sm-12">
														 <input type="email" class="form-control" name="email" id="email" aria-describedby="email-help" 
														 placeholder="<?php echo translate('your_email_will_go_here'); ?>" value="<?php echo $user_details['email']; ?>" readonly required>
													</div>
											</div>
											
											
											
											<div class="form-group">
												<label class="col-md-12" for="example-text"><?php echo translate('select_country');?> <b style="color:red">*</b></label>
													<div class="col-sm-12">
														 <select name="country_id" id="country_id" class="form-control select2" onchange="return get_country_state(this.value)" required>
														 <option><?php echo translate('select_country'); ?></option>
														 <?php $select_country_from_country_table = $this->db->get('countries')->result_array();
																foreach ($select_country_from_country_table as $key => $selected_country_from_table):?>
														 <option value="<?php echo $selected_country_from_table['country_id'];?>"><?php echo $selected_country_from_table['name'];?></option>
														 <?php endforeach;?>
														 
														 </select>
										  			</div>
										  </div>
										  
										  
											<div class="form-group">
												<label class="col-md-12" for="example-text"><?php echo translate('state');?> <b style="color:red">*</b></label>
													<div class="col-sm-12">
														 <select name="state_id" class="form-control" id="state_selector_holder" onchange="return get_state_city(this.value)" /required>
															<option value=""><?php echo translate('select_state');?></option>
														</select>  
										  			</div>
										  	</div>
										  
										  
						
											<div class="form-group">
												<label class="col-md-12" for="example-text"><?php echo translate('city');?> <b style="color:red">*</b></label>
													<div class="col-sm-12">
														<select name="city_id" class="form-control" id="city_selector_holder" /required>
															<option value=""><?php echo translate('select_city');?></option>
														</select>   
										  </div>
										  </div>
											
											<div class="form-group">
												<label class="col-md-12" for="example-text"><?php echo translate('full_address');?> <b style="color:red">*</b></label>
													<div class="col-sm-12">
														<textarea name="address" id = "address" class="form-control" required></textarea>
													</div>
											</div>
											
											
											<div class="form-group">
												<label class="col-md-12" for="example-text"><?php echo translate('mobile_number');?> <b style="color:red">*</b></label>
													<div class="col-sm-12">
													   <input type="text" class="form-control" name="phone" id="phone" aria-describedby="phone-help" 
													   placeholder="<?php echo translate('your_mobile_number'); ?>" required>
													</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-12" for="example-text"><?php echo translate('other_information');?> <b style="color:red">*</b></label>
													<div class="col-sm-12">
														<textarea name="message" id = "message" class="form-control"></textarea>
													</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-12" for="example-text"><?php echo translate('relevant_document');?> - <?=ucfirst(get_settings('verification_type'))?> <b style="color:red">*</b></label>
													<div class="col-sm-12">
														<input type="file" class="form-control" id="document" name="document" onchange="changeTitleOfImageUploader(this)">
														<hr>
						
														<div class="alert alert-danger">
														<h5 class="alert-red">Expected Document: <?=ucfirst(get_settings('verification_type'))?></h5>
														<h5 class="alert-red"><?=get_settings('instructor_application_note')?></h5>
														</div>
														
														
													</div>
											</div>
										
											
											<div class="form-group">
												<button type="submit" class="btn btn-block btn-info btn-rounded btn-sm"><i class="fa fa-plus"></i>&nbsp;
												<?php echo translate('save');?></button>
											</div>
                							<?php echo form_close();?>
										</section>              
                  	</div>
                <!-- /content -->
              	</div>
               <!-- /tabs -->			
			</div>                
		</div>
	</div>
</div>


	<script type="text/javascript">
		function get_country_state(country_id){
			$.ajax({
				url:        '<?php echo base_url();?>admin/get_country_state/' + country_id,
				success:    function(response){
					jQuery('#state_selector_holder').html(response);
				} 
		
			});
		}
		</script>

	<script type="text/javascript">
	 function get_state_city(state_id){
		 $.ajax({
			 url: '<?php echo base_url();?>admin/get_state_city/' + state_id,
			 success: function(response){
				jQuery('#city_selector_holder').html(response);
			 }
		 });
	 }
	
	</script>