<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
		<div class="panel-body table-responsive">
		

			<?php if(!isset($edit_category)) : ?>
			<?php echo translate('new_category'); ?>
			<hr class="sep-2">

				<form class="" action="<?php echo site_url('admin/add_categories/add'); ?>" method="post" enctype="multipart/form-data">
				
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('code');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">
								<input type="text" class="form-control" id="code" name = "code" value="<?= substr(md5(rand(0, 4000000)), 0, 10) ?>" readonly>
							</div>
					</div>
							
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('title');?></label>
                    		<div class="col-sm-12">
                                  <input type="text" class="form-control" id="name" name = "name" required>
							</div>
					</div>
							
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('parrent');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">

								<select class="form-control select2" data-toggle="select2" name="parent" id="parent" onchange="checkCategoryType(this.value)">
								  	<option value="0"><?=translate('none')?></option>
									  <?php foreach ($categories as $category) : ?>
										<?php if($category['parent'] == 0) : ?>
										<option value="<?=$category['id']?>"><?=$category['name']?></option>	
										<?php endif;?>
									  <?php endforeach;?>	

								</select>
							</div>
					</div>
					
					<div class="form-group" id = "icon-picker-area">
                 		<label class="col-md-12" for="example-text"><?php echo translate('icon_picker');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">
 								<input type="text" id ="font_awesome_class" name="font_awesome_class" class="form-control" value="fa fa-angle-double-right">
							</div>
					</div>
					
					<div class="form-group" id = "thumbnail-picker-area">
                 		<label class="col-md-12" for="example-text"><?php echo translate('image');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">
 								<input type="file" id ="category_thumbnail" name="category_thumbnail" class="form-control" autocomplete="off">
							</div>
					</div>
					
					
					<div class="form-group" id="is_popular">
							<div class="col-sm-12">
								<input type="checkbox" class="js-switch" value="1" name="is_popular"> <i></i> <?=translate('is_popular')?>
							</div>
					</div>
					
					
                            
					<div class="form-group">
						<button type="submit" class="btn btn-block btn-info btn-rounded btn-sm" id="add"><i class="fa fa-plus"></i>&nbsp;
						<?php echo translate('save');?></button>
					</div>
                <?php echo form_close();?>
				<?php endif;?>



				<?php if(isset($edit_category)) : ?>
				<?php echo translate('edit_category'); ?>
				<hr class="sep-2">

				<?php
					$category_id = $edit_category;
					$category_details = $this->crud_model->get_category_details_by_id($category_id)->row_array();
				?>

				<form class="" action="<?php echo site_url('admin/add_categories/edit/'. $category_id); ?>" method="post" enctype="multipart/form-data">
				
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('code');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">
								<input type="text" class="form-control" id="code" name = "code" value="<?=$category_details['code']?>" readonly>
							</div>
					</div>
							
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('title');?></label>
                    		<div class="col-sm-12">
                                  <input type="text" class="form-control" id="name" name = "name" value="<?=$category_details['name']?>" required>
							</div>
					</div>
							
					<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('parrent');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">

								<select class="form-control select2" data-toggle="select2" name="parent" id="parent" onchange="checkCategoryType(this.value)">
								  	<option value="0"><?=translate('none')?></option>
									  <?php 
									  $categories = $this->crud_model->get_categories()->result_array();
									  foreach ($categories as $category) : ?>
										<?php if($category['parent'] == 0) : ?>
										<option value="<?=$category['id']?>"
										<?php if($category_details['parent'] == $category['id']) echo 'selected';?>><?=$category['name']?></option>	
										<?php endif;?>
									  <?php endforeach;?>	

								</select>
							</div>
					</div>
					
					<div class="form-group" id = "icon-picker-area">
                 		<label class="col-md-12" for="example-text"><?php echo translate('icon_picker');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">
 								<input type="text" id ="font_awesome_class" name="font_awesome_class" class="form-control" value="<?=$category_details['font_awesome_class']?>">
							</div>
					</div>
					
					<div class="form-group" id = "thumbnail-picker-area">
                 		<label class="col-md-12" for="example-text"><?php echo translate('image');?> <b style="color:red">*</b></label>
                    		<div class="col-sm-12">
 								<input type="file" id ="category_thumbnail" name="category_thumbnail" class="form-control" autocomplete="off">
							</div>
					</div>
					
					
					<div class="form-group" id="is_popular">
							<div class="col-sm-12">
								<input type="checkbox" class="js-switch" value="1" name="is_popular"> <i></i> <?=translate('is_popular')?>
							</div>
					</div>
					
					
                            
					<div class="form-group">
						<button type="submit" class="btn btn-block btn-info btn-rounded btn-sm" id="add"><i class="fa fa-plus"></i>&nbsp;
						<?php echo translate('save');?></button>
					</div>
                <?php echo form_close();?>
				<?php endif;?>


                </div>                
			</div>
		</div>	
</div>


<script type="text/javascript">

	function checkCategoryType(category_type)	{
		if(category_type > 0){
			$('#thumbnail-picker-area').hide();
			$('#icon-picker-area').hide();
			$('#is_popular').hide();
		}else{
			$('#thumbnail-picker-area').show();
			$('#icon-picker-area').show();
			$('#is_popular').show();	
		}
	}									

</script>

