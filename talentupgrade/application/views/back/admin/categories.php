<div class="row">
<div class="col-sm-12">
		<div class="panel panel-default">
			
				<div class="panel-body table-responsive">
				
				
			
				
				<?php echo translate('list_categories'); ?>
				<hr>
					
					<table id="example23" class="display nowrap" cellspacing="0" width="100%">
						<thead>
	
					
							<tr>
								<th><div><?php echo translate('name');?></div></th>
								<th><div><?php echo translate('sub_category');?></div></th>
								<th><div><?php echo translate('date_added');?></div></th>
								<th><div><?php echo translate('actions');?></div></th>
							</tr>
					  
						</thead>
                    	<tbody>
						
					
                            <?php foreach ($categories->result_array() as $category) : 
                                
                                if($category['parent'] > 0)
                                continue;
                                $sub_categories = $this->crud_model->get_sub_categories($category['id']);
                            ?>
                            <?php foreach ($sub_categories as $sub_category) : ?>
							<tr>
								<td>
								<i class="<?=$category['font_awesome_class']?>"></i> 
								<strong><?=$category['name']?></strong><br>
								<?=count($sub_categories) . ' ' . translate('sub_categories')?>
								</td>

								<td><?=$sub_category['name']?></td>
								<td><?=date('d, M Y', $sub_category['date_added'])?></td>
								<td>
								<a href="<?=base_url()?>admin/add_categories/select/<?=$sub_category['id']?>" class="btn btn-info btn-circle btn-xs" style="color:white"><i class="fa fa-edit"></i></a>
							
								<a onclick="confirm_modal('<?=base_url()?>admin/categories/delete/<?=$sub_category['id']?>')" class="btn btn-danger btn-circle btn-xs" style="color:white"><i class="fa fa-times"></i></a>
							
							
								</td>
							</tr>
                            <?php endforeach;?>
                            <?php endforeach;?>
							
                    </tbody>
                </table>
			
				
				
				
				
				</div>
			</div>
		</div>
	</div>