<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
			<div class="panel-body table-responsive">
				
				<div class="row">
					<div class="col-sm-6">
                    <form class="" action="<?php echo site_url('admin/profile/update'); ?>" method="post" enctype="multipart/form-data">	
						<div class="panel-heading"><i class="fa fa-plus"></i>  <?php echo translate('edit_details');?></div>
						

                        <?php 
                        
                        foreach($select as $row) :
                        
                        $social_links = json_decode($row['social_links'], true);
                            
                        ?>
								<div class="form-group">
									<label class="col-md-12" for="example-text"><?=translate('first_name');?></label>
									<div class="col-sm-12">
										<input type="text" class="form-control" name="first_name" value="<?=$row['first_name']?>" required/>
										<input type="hidden" class="form-control" name="param2" value="<?=$row['id']?>" required/>
									</div>
								</div>


								<div class="form-group">
									<label class="col-md-12" for="example-text"><?=translate('last_name');?></label>
									<div class="col-sm-12">
										<input type="text" class="form-control" name="last_name" value="<?=$row['last_name']?>" required/>
									</div>
								</div>
				
								<div class="form-group">
									<label class="col-md-12" for="example-text"><?=translate('email');?></label>
									<div class="col-sm-12">
										<input type="email" class="form-control" name="email" value="<?=$row['email']?>" required/>
									</div>
								</div>
								
								
								<div class="form-group">
									<label class="col-md-12" for="example-text"><?=translate('facebook');?></label>
									<div class="col-sm-12">
										<input type="text" class="form-control" name="facebook" value="<?=$social_links['facebook']?>" required/>
									</div>
								</div>
				
								<div class="form-group">
									<label class="col-md-12" for="example-text"><?=translate('twitter');?></label>
									<div class="col-sm-12">
										<input type="text" class="form-control" name="twitter" value="<?=$social_links['twitter']?>" required/>
									</div>
								</div>
				
								<div class="form-group">
									<label class="col-md-12" for="example-text"><?=translate('linkedin');?></label>
									<div class="col-sm-12">
										<input type="text" class="form-control" name="linkedin" value="<?=$social_links['linkedin']?>" required/>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-12" for="example-text"><?=translate('brief_info_about_yourself');?></label>
									<div class="col-sm-12">
										<textarea rows="5" id="short-title" class="form-control" name="title" placeholder="<?=translate('brief_info_about_yourself'); ?>" required><?=$row['title']?></textarea>
									</div>
								</div>
				
								<div class="form-group">
									<label class="col-md-12" for="example-text"><?=translate('biography');?></label>
									<div class="col-sm-12">
									
										<textarea  name="biography" id="mymce" placeholder="<?=translate('biography'); ?>"><?=$row['biography']?></textarea>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-12" for="example-text"><?=translate('image');?></label>
									<div class="col-sm-12">
										<input type='file' class="form-control" name="user_image" onChange="readURL(this);" accept="image/*">
                                        <img src="<?=$this->user_model->get_user_image_url($this->session->userdata('user_id'))?>" alt="User Image" height="200" width="200">
                                    </div>
								</div>
								
							
								<div class="form-group">
									<button type="submit" class="btn btn-info btn-rounded btn-block btn-sm"><i class="fa fa-plus"></i>  <?=translate('save');?></button>
								</div>

                            </form>

                        <?php endforeach;?>
								

					


				
			</div>



		<div class="col-sm-6">
				<div class="panel-heading"> <i class="fa fa-key"></i>&nbsp;&nbsp;<?php echo translate('change_password'); ?></div>
				
                <form class="" action="<?php echo site_url('admin/profile/password/'); ?>" method="post" enctype="multipart/form-data">	
                <?php foreach($select as $row) : ?>
					
                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo translate('current_password');?></label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" name="current_password" value="">
                            <input type="hidden" class="form-control" name="param2" value="<?=$row['id'];?>" required/>
                        </div>
                    </div>
                    


				<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo translate('new_password');?></label>
					<div class="col-sm-12">
						<input type="password" class="form-control" name="new_password" value="">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-12" for="example-text"><?php echo translate('confirm_password');?></label>
					<div class="col-sm-12">
						<input type="password" class="form-control" name="confirm_password" value="">
					</div>
				</div>
				
					

				<div class="form-group">
					<button type="submit" class="btn btn-info btn-rounded btn-block btn-sm"><i class="fa fa-plus"></i>  <?php echo translate('save');?></button>
				</div>

                        <?php endforeach;?>
            </form>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>