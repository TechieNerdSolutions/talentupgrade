<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
			<div class="panel-body table-responsive">
				
				
                  <?php $select = $this->db->get_where('expense_category', array('id' => $param2))->result_array(); 
                        foreach ($select as $key => $value) {
                           
                    ?>
                    <form class="" action="<?php echo site_url('expense/expense_category/update/' . $param2); ?>" method="post" enctype="multipart/form-data">	
								<div class="form-group">
									<label class="col-md-12" for="example-text"><?=translate('expense_category_title');?></label>
									<div class="col-sm-12">

                                       <input type="text" name="name" value="<?php echo $value['name'];?>" class="form-control">

									</div>
								</div>


								
							
								<div class="form-group">
									<button type="submit" class="btn btn-info btn-rounded btn-block btn-sm"><i class="fa fa-edit"></i>  <?=translate('update');?></button>
								</div>

                            </form>
                            <?php } ?>
			</div>
        </div>
    </div>
</div>