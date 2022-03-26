<!-- .row -->

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
			<div class="panel-body table-responsive">
			
						<section>
                                <div class="sttabs tabs-style-bar">
                                    <nav>
                                        <ul>
                                            <li><a href="#section-bar-1" class="sticon ti-angle-double-right"><span><?=translate('system_settings')?></span></a></li>
                                            <li><a href="#section-bar-2" class="sticon ti-angle-double-right"><span><?=translate('language_settings')?></span></a></li>
                                            <li><a href="#section-bar-3" class="sticon ti-angle-double-right"><span><?=translate('payment_settings')?></span></a></li>
                                            <li><a href="#section-bar-4" class="sticon ti-angle-double-right"><span><?=translate('website_settings')?></span></a></li>
                                            <li><a href="#section-bar-5" class="sticon ti-angle-double-right"><span><?=translate('images')?></span></a></li>
                                        </ul>
                                    </nav>
                                    <div class="content-wrap">
                                        <section id="section-bar-1">
                                            <h3>Fill neccessary information for general settins : </h3>
                                         
												
					<div class="row">
					
						
                        <div class="col-sm-6">
                        <form action="<?=base_url()?>admin/settings/general" method="post" class="form-horizontal form-groups-bordered">
					
							<div class="form-group">
								<label class="col-md-12" for="example-text"><?php echo translate('system_name');?></label>
								<div class="col-sm-12">
									<input type="text" name = "system_name" id = "system_name" class="form-control" value="<?=get_settings('system_name')?>" required>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-12" for="example-text"><?php echo translate('website_keywords');?></label>
								<div class="col-sm-12">
									 <input type="text" class="form-control bootstrap-tag-input" id = "website_keywords" name="website_keywords" 
									 data-role="tagsinput" style="width: 100%;" value="<?=get_settings('website_keywords')?>"/>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-12" for="example-text"><?php echo translate('author');?></label>
								<div class="col-sm-12">
									 <input type="text" name = "author" id = "author" class="form-control" value="<?=get_settings('author')?>">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-12" for="example-text"><?php echo translate('system_email');?></label>
								<div class="col-sm-12">
									  <input type="text" name = "system_email" id = "system_email" class="form-control" value="<?=get_settings('system_email')?>" required>
								</div>
							</div>
						
							<div class="form-group">
								<label class="col-md-12" for="example-text"><?php echo translate('phone');?></label>
								<div class="col-sm-12">
									 <input type="text" name = "phone" id = "phone" class="form-control" value="<?=get_settings('phone')?>">
								</div>
							</div>
							
							
							<div class="form-group">
								<label class="col-md-12" for="example-text"><?php echo translate('vimeo_api_key');?></label>
								<div class="col-sm-12">
									 <input type="password" name = "vimeo_api_key" id = "vimeo_api_key" class="form-control" value="<?=get_settings('vimeo_api_key')?>" required>
									<a href= "https://www.youtube.com/watch?v=Wwy9aibAd54" target = "_blank" style="color:red"><?php echo translate('get_api_key');?></a>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-12" for="example-text"><?php echo translate('student_email_verification');?></label>
								<div class="col-sm-12">

								<select class="form-control select2" data-toggle="select2" name="student_email_verification" id="student_email_verification">
									<option value="enable"<?php if(get_settings('student_email_verification') == 'enable') echo 'selected="selected"';?>><?php echo translate('enable'); ?></option>
									<option value="disable"<?php if(get_settings('student_email_verification') == 'disable') echo 'selected="selected"';?>><?php echo translate('disable'); ?></option>
								</select>
								</div>
							</div>
						
						
							<div class="form-group">
								<label class="col-md-12" for="example-text"><?php echo translate('footer_link');?></label>
								<div class="col-sm-12">
									 <input type="text" name = "footer_link" id = "footer_link" class="form-control" value="<?=get_settings('footer_link')?>">
								</div>
							</div>
							
							
							<div class="form-group">
								<label class="col-md-12" for="example-text"><?php echo translate('timezone');?></label>
								<div class="col-sm-12">
									<select name="timezone" class="form-control" >
										 <?php $timezone = get_settings('timezone'); ?>
										   <?php $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL); ?>
										  <?php foreach ($tzlist as $tz): ?>
											<option value="<?php echo $tz ;?>"<?php if($tz == $timezone) echo 'selected';?>><?php echo $tz ;?></option>
										  <?php endforeach; ?>
									</select>
								</div>
							</div>
							
							
								<div class="form-group">
									<label class="col-md-12" for="example-text"><?php echo translate('tawk_to_code');?></label>
									<div class="col-sm-12">
										<textarea class="form-control" name="tawkto"><?=get_settings('tawkto')?></textarea>
									</div>
								</div>
								
								
						
					  
					  
							<div class="form-group">
								<label class="col-md-12" for="example-text"><?php echo translate('currency_position');?></label>
								<div class="col-sm-12">
									<select class="form-control select2" data-toggle="select2" id = "currency_position" name="currency_position">
										<option value="left"<?php if(get_settings('currency_position') == 'left') echo 'selected="selected"';?>><?php echo translate('left'); ?></option>
										<option value="right"<?php if(get_settings('currency_position') == 'right') echo 'selected="selected"';?>><?php echo translate('right'); ?></option>
										<option value="left-space"<?php if(get_settings('currency_position') == 'left-space') echo 'selected="selected"';?>><?php echo translate('left_with_a_space'); ?></option>
										<option value="right-space"<?php if(get_settings('currency_position') == 'right-space') echo 'selected="selected"';?>><?php echo translate('right_with_a_space'); ?></option>
									</select>
								</div>
							</div>
							
						
						</div>
					
					
					
					
					
					<div class="col-sm-6">
					
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('system_title');?></label>
							<div class="col-sm-12">
								<input type="text" name= "system_title" id= "system_title" class="form-control" value="<?=get_settings('system_title')?>" required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('website_description');?></label>
							<div class="col-sm-12">
								<input type="text" name= "website_description" id= "website_description" class="form-control" 
								value="<?=get_settings('website_description')?>" required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('slogan');?></label>
							<div class="col-sm-12">
								<input type="text" name = "slogan" id = "slogan" class="form-control" value="<?=get_settings('slogan')?>" required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('address');?></label>
							<div class="col-sm-12">
								<textarea name="address" id = "address" class="form-control"><?=get_settings('address')?></textarea>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('youtube_api_key');?></label>
							<div class="col-sm-12">
								<input type="password" name = "youtube_api_key" id = "youtube_api_key" class="form-control" 
								value="<?=get_settings('youtube_api_key')?>" required>
								<a href = "https://developers.google.com/youtube/v3/getting-started" target = "_blank" style="color:red"><?php echo translate('get_api_key'); ?></a>

							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('language');?></label>
							<div class="col-sm-12">
								<select name="language" class="form-control select2">
						
                        <?php 
                        
                        $fields = $this->db->list_fields('language');
                        foreach($fields as $key => $field){
                            if($field == 'phrase_id' || $field == 'phrase')
                            continue;
                            $current_defualt_system_language = get_settings('language');
                       
                        ?>
                                	<option value="<?=$field?>"<?php if($current_defualt_system_language == $field) echo 'selected';?>><?=$field?></option>
                        <?php } ?>
                        		</select>

							</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('footer_text');?></label>
							<div class="col-sm-12">
								<input type="text" name = "footer" id = "footer" class="form-control" value="<?=get_settings('footer');?>">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('text_align');?></label>
							<div class="col-sm-12">
								<select name="text_align" class="form-control">
										
										<option value="left-to-right" <?php if(get_settings('text_align') == 'left-to-right') echo 'selected="selected"';?>><?php echo translate('left_to_right');?></option>
										<option value="right-to-left" <?php if(get_settings('text_align') == 'right-to-left') echo 'selected="selected"';?>><?php echo translate('right_to_left');?></option>
								</select>
							</div>
						</div>	
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('software_abbreviation');?></label>
							<div class="col-sm-12">
								<input type="text" class="form-control" name="app_abbr" value="<?=get_settings('app_abbr')?>">
							</div>
						</div>	
						
						
						  
						  
						  
							<div class="form-group">
								<label class="col-md-12" for="example-text"><?php echo translate('system_currency');?></label>
								<div class="col-sm-12">
									<select class="form-control select2" id = "system_currency" name="system_currency">
										<option value=""><?=translate('select_system_currency'); ?></option>
                                        <?php 
                                        $currencies = $this->crud_model->get_currencies();
                                            foreach($currencies as $currency){
                                            
                                                $current_defualt_system_currency = get_settings('system_currency');
                                        ?>
                                        <option value="<?=$currency['code']?>"<?php if($current_defualt_system_currency == $currency['code']) echo 'selected';?>><?=$currency['name']?></option>
                                        <?php } ?>
									
								</select>
								</div>
							</div>	
							
							
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('theme');?></label>
							<div class="col-sm-12">
                            <select class="form-control select2" data-toggle="select2" name="skin_colour" id="skin_color">
                                <option value="default" <?php if(get_settings('skin_colour') == 'default') echo 'selected="selected"';?>><?php echo translate('default'); ?></option>
                                <option value="green"<?php if(get_settings('skin_colour') == 'green') echo 'selected="selected"';?>><?php echo translate('green'); ?></option>
								<option value="gray" <?php if(get_settings('skin_colour') == 'grey') echo 'selected="selected"';?>><?php echo translate('gray'); ?></option>
								<option value="dark" <?php if(get_settings('skin_colour') == 'dark') echo 'selected="selected"';?>><?php echo translate('dark'); ?></option>
								<option value="purple"<?php if(get_settings('skin_colour') == 'purple') echo 'selected="selected"';?>><?php echo translate('purple'); ?></option>
								<option value="blue"<?php if(get_settings('skin_colour') == 'blue') echo 'selected="selected"';?>><?php echo translate('blue'); ?></option>
                            </select>
							</div>
						</div>	

						
					</div>
				</div>
				
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-rounded btn-block btn-sm"><i class="fa fa-plus"></i>  <?php echo translate('save');?></button>
                    </div>	

                    </form>			
										   
										</section>












										
										
										
                                        <section id="section-bar-2">
                                        <h3>Fill neccessary information for language settings : </h3>
								
					<?php if (isset($translate_language)) : ?>
					
					<?php 
						$current_editing_language = $translate_language;
						echo form_open(base_url() . 'admin/manage_language/update_phrase/'. $current_editing_language);
						$count = 1;
						$language_phrases = $this->db->query("SELECT `phrase_id`, `phrase`, `$current_editing_language` FROM `language`")->result_array();
						foreach($language_phrases as $key => $row){
							$phrase_id = $row['phrase_id'];
							$phrase = $row['phrase'];
							$phrase_language = $row[$current_editing_language];
					?>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="panel panel-info">
                          
                           <div class="row panel-body">
						   <?=$counter++;?>. <?=$phrase;?>
						   <hr class="sep-2">
							
							 <div class="col-sm-10">
 								<input type="text" name="phrase<?=$phrase_id;?>" 
								 id="phrase-<?=$phrase_id;?>" value="<?=$phrase_language;?>"
								  onkeyup="enableUpdateButton(<?=$phrase_id;?>)" class="form-control"/>
 							</div>
 
 							<div class="col-sm-2">
								<button type="button" name="button" class = "btn btn-xs btn-success pull-right" 
								id="button-<?=$phrase_id;?>" disabled onclick="updatePhrase(<?=$phrase_id;?>)">  
									<i class="fa fa-check"></i>
								</button>
							</div>
									  
                            </div>
                        </div>
                    </div>
				<?php } ?>
				<?php echo form_close();?>
				<?php endif;?>
					
				<?php if(!isset($translate_language)) : ?>							
				<div class="panel-body table-responsive">
						 
						
						<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/add_language/');">
							<button type="button" class="btn btn-sm btn-default pull-right"><i class="fa fa-plus"></i>&nbsp;<?php echo translate('add_language');?>
						</button></a>
						
						<a href="javascript:;" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/add_phrase/');">
							<button type="button" class="btn btn-default btn-sm pull-right"><i class="fa fa-plus"></i>&nbsp;<?php echo translate('add_string');?>
						</button></a>
						<br>
						<hr class="sep-2">
						
                	<table id="example23" class="display nowrap" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th><?php echo translate('all_languages');?> </th>
								<th><div align="right"><?php echo translate('actions');?></div></th>
							</tr>
						</thead>
                    <tbody>



						<?php

						$fields = $this->db->list_fields('language');
						foreach($fields as $key => $field) { 

							if($field == 'phrase_id' || $field == 'phrase')
							continue;

						?>
                    			
                    	<tr>
                        	<td> <?= ucwords($field);?> </td>
								<td>
									<div align="right">
										<a href="<?php echo base_url();?>admin/settings/edit_phrase/<?=$field;?>">
										<button type="button" class="btn btn-info btn-rounded btn-sm"><i class="fa fa-edit"></i> <?php echo translate('translate');?>
										</button></a>
										
										<a href="#" onclick="confirm_modal('<?php echo base_url();?>admin/language/delete_language/<?=$field;?>')">
										<button type="button" class="btn btn-danger btn-rounded btn-sm"><i class="fa fa-times" onclick="return confirm('Delete Language ?');"></i>
										<?php echo translate('delete');?></button></a></div>		
									</div>
								</td>
                       	 	</tr>
						<?php }  ?>



						</tbody>
					</table>
				</div>   
				<?php endif;?> 
											
											
											
											
										</section>














										
										
                                        <section id="section-bar-3">
                                        <h3>Fill neccessary information for payment settins : </h3>
											
            <form class="" action="<?php echo site_url('admin/settings/paypal'); ?>" method="post" enctype="multipart/form-data">		
				<div class="row">
					<div class="col-sm-6">


					<?php

							$paypal_settings = get_settings('paypal');
							$paypal = json_decode($paypal_settings);
							$stripe_settings = get_settings('stripe');
							$stripe = json_decode($stripe_settings);

					
					?>
					
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('paypal_status');?></label>
							<div class="col-sm-12">
								<select class="form-control select2" data-toggle="select2" id = "paypal_active" name="paypal_active">
									<option value="0" <?php if($paypal[0]->active == 0) echo 'selected';?>> <?php echo translate('no');?></option>
									<option value="1" <?php if($paypal[0]->active == 1) echo 'selected';?>> <?php echo translate('yes');?></option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('paypal_mode');?></label>
							<div class="col-sm-12">
								<select class="form-control select2" data-toggle="select2" id = "paypal_mode" name="paypal_mode">
									<option value="sandbox" <?php if($paypal[0]->mode == 'sandbox') echo 'selected';?>> <?php echo translate('sandbox');?></option>
									<option value="production" <?php if($paypal[0]->mode == 'production') echo 'selected';?>> <?php echo translate('production');?></option>
								</select>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('paypal_currency');?></label>
							<div class="col-sm-12">
								<select class="form-control select2" data-toggle="select2" id = "paypal_currency" name="paypal_currency" required>
									<option value=""><?=translate('select_paypal_currency'); ?></option>
									
									<?php 
											$currencies = $this->crud_model->get_paypal_supported_currency();
											foreach($currencies as $currency) {
									?>
										<option value="<?php echo $currency['code'];?>"
										<?php if(get_settings('paypal_currency') == $currency['code']) echo 'selected';?>><?php echo $currency['code'];?></option>

									<?php } ?>
								
							</select>
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('client_id').' ('.translate('sandbox').')'; ?></label>
							<div class="col-sm-12">
                    			<input type="text" name="sandbox_client_id" class="form-control" value="<?=$paypal[0]->sandbox_client_id?>" required />
                			</div>
						</div>

						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('secret_key').' ('.translate('sandbox').')'; ?></label>
							<div class="col-sm-12">
							<?php if(isset($paypal[0]->sandbox_secret_key)) : ?>	
									<input type="text" name="sandbox_secret_key" class="form-control" value="<?=$paypal[0]->sandbox_secret_key?>" required />
							<?php else : ?>
									<input type="text" name="sandbox_secret_key" class="form-control" placeholder="<?php echo translate('no_secret_key_found'); ?>" required />
							<?php endif;?>
                			</div>
						</div>
						

                <div class="form-group">
                   <label class="col-md-12" for="example-text"><?php echo translate('client_id').' ('.translate('production').')'; ?></label>
				    <div class="col-sm-12">
                    	<input type="text" name="production_client_id" class="form-control" value="<?=$paypal[0]->production_client_id?>" required />
                	</div>
				</div>

                <div class="form-group">
                   <label class="col-md-12" for="example-text"><?php echo translate('secret_key').' ('.translate('production').')'; ?></label>
				   <div class="col-sm-12">
						
						<?php if(isset($paypal[0]->production_secret_key)) : ?>
							<input type="text" name="production_secret_key" class="form-control" value="<?=$paypal[0]->production_secret_key?>" required />
						<?php else : ?>
							<input type="text" name="production_secret_key" class="form-control" placeholder="<?php echo translate('no_secret_key_found'); ?>" required />
						<?php endif;?>
                 </div>
				</div>
				
					<div class="form-group">
						<button type="submit" class="btn btn-success btn-rounded btn-block btn-sm"><i class="fa fa-plus"></i>  <?php echo translate('save');?></button>
					</div>
					
					
			</form>
						
						
					</div>
					
					<div class="col-sm-6">
					<form class="" action="<?php echo site_url('admin/settings/stripe'); ?>" method="post" enctype="multipart/form-data">	
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('stripe_status'); ?></label>
							<div class="col-sm-12">
							
								<select class="form-control select2" data-toggle="select2" id = "stripe_active" name="stripe_active">
									<option value="0" <?php if($stripe[0]->active == 0) echo 'selected' ;?>> <?php echo translate('no');?></option>
									<option value="1" <?php if($stripe[0]->active == 1) echo 'selected' ;?>> <?php echo translate('yes');?></option>
								</select>
								
                			</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('test_mode'); ?></label>
							<div class="col-sm-12">
								<select class="form-control select2" data-toggle="select2" id = "testmode" name="testmode">
									<option value="on" <?php if($stripe[0]->testmode == 'on') echo 'selected' ;?>> <?php echo translate('on');?></option>
									<option value="off"<?php if($stripe[0]->testmode == 'off') echo 'selected' ;?>> <?php echo translate('off');?></option>
								</select>
                			</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('stripe_currency'); ?></label>
							<div class="col-sm-12">
								<select class="form-control select2" data-toggle="select2" id = "stripe_currency" name="stripe_currency" required>
									<option value=""><?php echo translate('select_stripe_currency'); ?></option>
									
									<?php 
											$currencies = $this->crud_model->get_stripe_supported_currency();
											foreach($currencies as $currency) {
									?>
										<option value="<?php echo $currency['code'];?>"
										<?php if(get_settings('stripe_currency') == $currency['code']) echo 'selected';?>><?php echo $currency['code'];?></option>

									<?php } ?>
								
							</select>
                			</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('test_secret_key'); ?></label>
							<div class="col-sm-12">
                    			<input type="text" name="secret_key" class="form-control" value="<?=$stripe[0]->secret_key;?>" required />
                			</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('test_public_key'); ?></label>
							<div class="col-sm-12">
                    			<input type="text" name="public_key" class="form-control" value="<?=$stripe[0]->public_key;?>" required />
                			</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('live_secret_key'); ?></label>
							<div class="col-sm-12">
                    			<input type="text" name="secret_live_key" class="form-control" value="<?=$stripe[0]->secret_live_key;?>" required />
                			</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('live_public_key'); ?></label>
							<div class="col-sm-12">
                    			 <input type="text" name="public_live_key" class="form-control" value="<?=$stripe[0]->public_live_key;?>" required />
                			</div>
						</div>
						
							
							<div class="form-group">
								<button type="submit" class="btn btn-success btn-rounded btn-block btn-sm"><i class="fa fa-plus"></i>  <?php echo translate('save');?></button>
							</div>
							

					</form>
					</div>
					
					
					
				</div>


		
				<?php echo form_close(); ?>				
										
										</section>








                                        <section id="section-bar-4">
                                        <h3>Fill neccessary information for website settins : </h3>
											
			<form class="" action="<?php echo site_url('admin/settings/website_settings'); ?>" method="post" enctype="multipart/form-data">	
        		<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo translate('banner_title');?></label>
					<div class="col-sm-12">
						<input type="text" name = "banner_title" id = "banner_title" class="form-control" value="<?=get_frontend_settings('banner_title')?>" required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo translate('banner_sub_title');?></label>
					<div class="col-sm-12">
						<input type="text" name = "banner_sub_title" id = "banner_sub_title" class="form-control" value="<?=get_frontend_settings('banner_sub_title')?>" required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo translate('cookie_status');?></label>
					<div class="col-sm-12">
						<input type="radio" value="active" name="cookie_status" <?php if(get_frontend_settings('cookie_status') == 'active') echo 'checked';?>> <?php echo translate('active'); ?>
                        &nbsp;&nbsp;
                        <input type="radio" value="inactive" name="cookie_status" <?php if(get_frontend_settings('cookie_status') == 'inactive') echo 'checked';?>> <?php echo translate('inactive'); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo translate('cookie_note');?></label>
					<div class="col-sm-12">
						<textarea name="cookie_note" id = "cookie_note" class="form-control" rows="5"><?=get_frontend_settings('cookie_note')?></textarea>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo translate('cookie_policy');?></label>
					<div class="col-sm-12">
						<textarea name="cookie_policy" id = "mymce" class="form-control" rows="5"><?=get_frontend_settings('cookie_policy')?></textarea>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo translate('about_us');?></label>
					<div class="col-sm-12">
						<textarea name="about_us" id = "mymce" class="form-control" rows="5"><?=get_frontend_settings('about_us')?></textarea>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo translate('terms_and_condition');?></label>
					<div class="col-sm-12">
						<textarea name="terms_and_condition" id ="mymce" class="form-control" rows="5"><?=get_frontend_settings('terms_and_condition')?></textarea>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo translate('privacy_policy');?></label>
					<div class="col-sm-12">
						<textarea name="privacy_policy" id = "mymce" class="form-control" rows="5"><?=get_frontend_settings('privacy_policy')?></textarea>
					</div>
				</div>
				
				
				<div class="form-group">
					<button type="submit" class="btn btn-success btn-rounded btn-block btn-sm"><i class="fa fa-plus"></i>  <?php echo translate('save');?></button>
				</div>
			<?php echo form_close();?>
		
			
											
										</section>



















                                        <section id="section-bar-5">
                                        <h3>Please upload neccessary images here : </h3>
											
                                    <div class="row">
                                    
                                        <div class="col-sm-6">			
										<form class="" action="<?php echo site_url('admin/settings/system_image'); ?>" method="post" enctype="multipart/form-data">	

											<div class="form-group">
                                                <label class="col-md-12" for="example-text"><?php echo translate('system_logo');?></label>
                                                <div class="col-sm-12">
                                                    <input type="file" class="form-control" name="light_logo" value="">
													<img src="<?php echo base_url()?>uploads/system/logo-light.png" height="50" width="150">
												</div>
                                            </div>
											

				
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success btn-rounded btn-block btn-sm"><i class="fa fa-plus"></i>  <?php echo translate('save');?></button>
                                            </div>
											<?php echo form_close();?>
                                        </div>



                                        <div class="col-sm-6">			
										<form class="" action="<?php echo site_url('admin/settings/favicon'); ?>" method="post" enctype="multipart/form-data">	

											<div class="form-group">
                                                <label class="col-md-12" for="example-text"><?php echo translate('favicon_image');?></label>
                                                <div class="col-sm-12">
                                                    <input type="file" class="form-control" name="favicon" value="">
													<img src="<?php echo base_url()?>uploads/system/favicon.png" height="50" width="150">
												</div>
                                            </div>
											

				
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success btn-rounded btn-block btn-sm"><i class="fa fa-plus"></i>  <?php echo translate('save');?></button>
                                            </div>
											<?php echo form_close();?>
                                        </div>
									


                                        <div class="col-sm-6">	
										<form class="" action="<?php echo site_url('admin/settings/banner_image'); ?>" method="post" enctype="multipart/form-data">			
                                            <div class="form-group">
                                                <label class="col-md-12" for="example-text"><?php echo translate('banner_image');?></label>
                                                <div class="col-sm-12">
                                                    <input type="file" class="form-control" name="banner_image" value="">
													<img src="<?php echo base_url()?>uploads/system/home-banner.jpg" height="50" width="150">
                                                </div>
                                            </div>
											

                                            
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-success btn-rounded btn-block btn-sm"><i class="fa fa-plus"></i>  <?php echo translate('save');?></button>
                                            </div>

											<?php echo form_close();?>
                                        </div>



                                    </div>

										</section>
										
										
                                       
                                    </div>
                                    <!-- /content -->
									
                                </div>
                                <!-- /tabs -->
                            </section>
							

					

					
					
					
					

                
			</div>                
		</div>
	</div>
</div>


<script  type="text/javascript">
function enableUpdateButton(id){
	$('#button-'+id).prop('disabled', false);
}

function updatePhrase(phraseId) {
	$('#button-'+phraseId).text('...');
		var updatedValue = $('#phrase-'+phraseId).val();
		var currentEditingLanguage = '<?php echo $current_editing_language; ?>';
			$.ajax({
				type : "POST",
				url  : "<?=site_url('admin/updatePhraseWithAjax/'); ?>",
				data : {updatedValue : updatedValue, currentEditingLanguage : currentEditingLanguage, phraseId : phraseId},
				success : function(response) {

					$(document).ready(function() {
						$.toast({
							heading: 'Congratulations!!!',
							text: 'phrase successfully updated...',
							position: 'bottom-right',
							loaderBg: '#ff6849',
							icon: 'success',
							hideAfter: 3500,
							stack: 6
						})
					});

				}
			});
} 




</script>


    