
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
			<div class="panel-body table-responsive">

                    <form action="<?=base_url()?>admin/language/add_phrase" method="post">
                    <div class="form-group">
                        <label class="col-md-12" for="example-text"><?php echo translate('new_phrase');?></label>
                            <div class="col-sm-12">
								<input type="text" name = "phrase" id = "phrase" class="form-control" value="">
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