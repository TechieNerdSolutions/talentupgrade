<div class="row">
     <div class="col-sm-12">
		<div class="panel panel-info">
            <div class="panel-heading"> <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo translate('add'); ?></div>
                <form action="<?php echo site_url('user/sections/'.$param2.'/add'); ?>" method="post">
					<div class="panel-body table-responsive">
					
                        <div class="form-group">
                            <label class="col-md-12" for="example-text"><?php echo translate('name');?></label>
                                <div class="col-sm-12">
                                    <input name="title" id="title" type="text" class="form-control"/ required>
                                </div>
                            </div>
							
						
                           <div class="form-group">
                                  <button type="submit" class="btn btn-block btn-info btn-rounded btn-sm "><i class="fa fa-plus"></i>&nbsp;<?php echo translate('add');?></button>
							</div>
                <?php echo form_close();?>
                </div>                
			</div>
		</div>
<!----CREATION FORM ENDS-->