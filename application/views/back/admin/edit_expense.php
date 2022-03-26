<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
            <div class="panel-body table-responsive">


            <?php 
                        $select_expense = $this->db->get_where('payment', array('id' => $param2))->result_array();
                        foreach ($select_expense as $key => $expense) : ?>

                		<?php echo form_open(base_url() . 'expense/expense/update/' . $param2 , 
						array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
						<div class="form-group">
                 		<label class="col-md-12" for="example-text"><?php echo translate('title');?></label>
                    		<div class="col-sm-12">
								<input type="text" class="form-control" value="<?php echo $expense['title'];?>" name="title" / required >
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
									<option value="<?php echo $row['id'];?>" <?php if ($row['id'] == $expense['expense_category_id']) echo 'selected="selected"';?>><?php echo $row['name'];?></option>
								<?php endforeach;?>
								</select>
                    		</div> 
               		 	</div>
				
						<div class="form-group">
							<label class="col-md-12" for="example-text"><?php echo translate('description');?></label>
							<div class="col-sm-12">
								<textarea class="form-control textarea_editor" rows="5" name="description" class="form-control"><?php echo $expense['description'];?></textarea>
							</div> 
						</div>
				
						<div class="form-group">
                 			<label class="col-md-12" for="example-text"><?php echo translate('amount');?></label>
                    		<div class="col-sm-12">
                                <input type="number" class="form-control" name="amount" min="0" value="<?php echo $expense['amount'];?>" / required>
                            </div>
                        </div>
				
	
						<div class="form-group">
                 			<label class="col-md-12" for="example-text"><?php echo translate('method');?></label>
                    		<div class="col-sm-12">
							<select name="method" class="form-control" / required>
                                <option value="1" <?php if($expense['method'] == 1) echo 'selected';?>><?php echo translate('cash');?></option>
                                <option value="2" <?php if($expense['method'] == 2) echo 'selected';?>><?php echo translate('cheque');?></option>
                                <option value="3" <?php if($expense['method'] == 3) echo 'selected';?>><?php echo translate('card');?></option>
                            </select>
							</div>
						</div>
							
							
						<div class="form-group">
                 			<label class="col-md-12" for="example-text"><?php echo translate('date');?></label>
                    		<div class="col-sm-12">
								<input class="form-control m-r-10" name="date_added" type="date" value="<?php echo date('Y-m-d', $expense['date_added']);?>" id="example-date-input" / required>
							</div>
						</div>

                    
						<div class="form-group">
								<button type="submit" class="btn btn-info btn-rounded btn-block btn-sm"> <i class="fa fa-plus"></i>
								&nbsp;<?php echo translate('save');?></button>
						</div>
						<br>
                		<?php echo form_close();?>	
                    <?php endforeach;?>
									
									
			</div>
		</div>
	</div>
</div> 