
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
			<div class="panel-body table-responsive">

                    <form action="<?php echo site_url('admin/sections/' . $param2. '/add')?>" method="post">
                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo translate('add_new_section');?></label>
                            <div class="col-sm-12">
								<input type="text" name = "title" id = "title" class="form-control" value="" / required>
							</div>
					</div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-rounded btn-block btn-sm"><i class="fa fa-plus"></i>  <?php echo translate('add');?></button>
                    </div>

                    </form>


            </div>
        </div>
    </div>
</div>