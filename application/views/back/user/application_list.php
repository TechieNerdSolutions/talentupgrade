<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-info">
			<div class="panel-body table-responsive">
		
				<?php echo translate('become_an_instructor'); ?>
				<hr class="sep-2">
				
				
				
				
 <table id="example23" class="table table-striped">
        <thead>
            <tr>
                <th><?php echo translate('name'); ?></th>
                <th><?php echo translate('document'); ?></th>
                <th><?php echo translate('details'); ?></th>
                <th><?php echo translate('status'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($applications->result_array() as $key => $application):
                $user_data = $this->user_model->get_all_user($application['user_id'])->row_array();?>
                <tr class="gradeU">
                   
                    <td>
                        <?php echo $user_data['first_name'].' '.$user_data['last_name']; ?>
                    </td>
                    <td>
                        <a href="javascript::" class="btn btn-info btn-sm btn-rounded" onclick="showAjaxModal('<?php echo site_url('modal/popup/application_details/'.$application['id']); ?>', '<?php echo translate('applicant_details'); ?>')" style="color:white">
                            <i class="fa fa-info-circle"></i> <?php echo translate('application_details'); ?>
                        </a>
                    </td>
                    <td>
                        <?php if (!empty($application['document'])): ?>
                            <a href="<?php echo base_url().'uploads/document/'.$application['document']; ?>" class="btn btn-info btn-sm btn-rounded" style="color:white" download >
                                <i class="fa fa-download"></i> <?php echo translate('download'); ?>
                            </a>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center;">
                        <?php if ($application['status'] == 0): ?>
                            <div class="badge badge-danger"><?php echo translate('pending'); ?></div>
                        <?php elseif($application['status'] == 1): ?>
                            <div class="badge badge-success"><?php echo translate('approved'); ?></div>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
				
		
			</div>
		</div>
	</div>
</div>
	