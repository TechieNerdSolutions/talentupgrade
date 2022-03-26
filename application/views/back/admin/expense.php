<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				NEW EXPENSE
					<div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="fa fa-plus"></i>&nbsp;&nbsp;
						ADD NEW EXPENSE HERE<i class="btn btn-info btn-xs"></i></a> <a href="#" data-perform="panel-dismiss"></a> </div>
					</div>
					<div class="panel-wrapper collapse out" aria-expanded="true">
					<div class="panel-body">
                		<?php echo form_open(base_url() . 'expense/expense/insert/' , 
						array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
						<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('title');?></label>
                    		<div class="col-sm-12">
								<input type="text" class="form-control" name="title" / required >
                   		 	</div>
                		</div>

               			<div class="form-group">
                 			<label class="col-md-12" for="example-text"><?php echo translate('category');?></label>
                    		<div class="col-sm-12">
								<select name="expense_category_id" class="form-control" / required>
									<option value=""><?php echo translate('select_expense_category');?></option>
									<?php 
										$categories = $this->db->get('expense_category')->result_array();
										foreach ($categories as $row):
									?>
									<option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
								<?php endforeach;?>
								</select>
                    		</div> 
               		 	</div>
				
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('description');?></label>
							<div class="col-sm-12">
								<textarea class="form-control textarea_editor" rows="5" name="description" class="form-control"></textarea>
							</div> 
						</div>
				
						<div class="form-group">
                 			<label class="col-md-12" for="example-text"><?php echo translate('amount');?></label>
                    		<div class="col-sm-12">
                                <input type="number" class="form-control" name="amount" min="0" value="" / required>
                            </div>
                        </div>
				
	
						<div class="form-group">
                 			<label class="col-md-12" for="example-text"><?php echo translate('method');?></label>
                    		<div class="col-sm-12">
							<select name="method" class="form-control" / required>
                                <option value="1"><?php echo translate('cash');?></option>
                                <option value="2"><?php echo translate('cheque');?></option>
                                <option value="3"><?php echo translate('card');?></option>
                            </select>
							</div>
						</div>
							
							
						<div class="form-group">
                 			<label class="col-md-12" for="example-text"><?php echo translate('date');?></label>
                    		<div class="col-sm-12">
								<input class="form-control m-r-10" name="date_added" type="date" value="<?php echo date('Y-m-d'); ?>" id="example-date-input" / required>
							</div>
						</div>

                    
						<div class="form-group">
								<button type="submit" class="btn btn-info btn-rounded btn-block btn-sm"> <i class="fa fa-plus"></i>
								&nbsp;<?php echo translate('save');?></button>
						</div>
						<br>
                		<?php echo form_close();?>	
									
									
				</div>
			</div>
		</div>
	</div>
</div>  

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
			<div class="panel-heading"> <i class="fa fa-list"></i>&nbsp;&nbsp;<?php echo translate('list_expenses');?></div>
				<div class="panel-body table-responsive">
								
						<table id="example23" class="display nowrap" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><div><?php echo translate('title');?></div></th>
									<th><div><?php echo translate('category');?></div></th>
									<th><div><?php echo translate('method');?></div></th>
									<th><div><?php echo translate('amount');?></div></th>
									<th><div><?php echo translate('date');?></div></th>
									<th><div><?php echo translate('options');?></div></th>
								</tr>
							</thead>
						<tbody>
			
						<?php 
                        $select_expense = $this->db->get_where('payment', array('payment_type' => 'expense'))->result_array();
                        $count = 1; foreach ($select_expense as $key => $expense): ?>
				
						<tr>
							<td><?php echo $expense['title'];?></td>
							
							<td>
							<?php 
							if($expense['expense_category_id'] != 0 || $expense['expense_category_id'] != null)
							echo $this->db->get_where('expense_category', array('id' => $expense['expense_category_id']))->row()->name;
							?>
							</td>
			
							<td>
							
							<?php 
				
								if($expense['method'] == 1)
								echo translate('cash');   
								if($expense['method'] == 2)
								echo translate('cheque'); 
								if($expense['method'] == 3)
								echo translate('card');           
							?>
							
							</td>
			
							<td><?php echo currency ($expense['amount']);?></td>
							<td><?php echo date('d M, Y', $expense['date_added']);?></td>
							<td>
								<a onclick="showAjaxModal('<?php echo base_url();?>modal/popup/edit_expense/<?php echo $expense['id'];?>')" 
								class="btn btn-info btn-circle btn-xs"><i class="fa fa-edit"></i></a>
								<a onclick="confirm_modal('<?php echo base_url();?>expense/expense/delete/<?php echo $expense['id'];?>')" 
								class="btn btn-danger btn-circle btn-xs" style="color:white"><i class="fa fa-times"></i></a>
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
