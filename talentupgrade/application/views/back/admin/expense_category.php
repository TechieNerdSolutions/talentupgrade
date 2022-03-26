<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
			<div class="panel-body table-responsive">
				
				<div class="row">
					<div class="col-sm-6">
                    <i class="fa fa-plus"></i>  
                    <br><br>
                    <form class="" action="<?php echo site_url('expense/expense_category/insert'); ?>" method="post" enctype="multipart/form-data">	
								<div class="form-group">
									<label class="col-md-12" for="example-text"><?=translate('expense_category_title');?></label>
									<div class="col-sm-12">

                                       <input type="text" name="name" class="form-control">

									</div>
								</div>


								
							
								<div class="form-group">
									<button type="submit" class="btn btn-info btn-rounded btn-block btn-sm"><i class="fa fa-plus"></i>  <?=translate('save');?></button>
								</div>

                            </form>
			    </div>



                    <div class="col-sm-6">
                        <?php echo translate('all_categories');?>
                        <br><br>
				
                        <table id="example23" class="display nowrap" cellspacing="0" width="100%">
						<thead>
	
					
							<tr>
								<th><div><?php echo translate('name');?></div></th>
                                <th><div><?php echo translate('action');?></div></th>
							</tr>
					  
						</thead>
                    	<tbody>
						
					
                            <?php
                                $expense_categories = $this->db->get('expense_category')->result_array();
							foreach ($expense_categories as $expense_category) : 
								
							?>
                            
							<tr>
								
								<td><?=$expense_category['name']?></td>
                                <td>
                                <a href="javascript::" class="btn btn-success btn-sm btn-rounded" onclick="showAjaxModal('<?php echo site_url('modal/popup/update_expense_category/'.$expense_category['id']); ?>')" style="color:white"><i class="fa fa-edit"></i></a>
								    <a onclick="confirm_modal('<?=base_url()?>expense/expense_category/delete/<?=$expense_category['id']?>')" class="btn btn-danger btn-circle btn-xs" style="color:white"><i class="fa fa-times"></i></a>
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
</div>