<!-- .row -->

<div class="row">
                    <div class="col-sm-12">
				  	<div class="panel panel-info">
					<div class="panel-body table-responsive">
							
							
							
							<style>
							.badge-danger{
							background-color:red;
							color:white;
							}
							</style>
								
                                <div class="sttabs tabs-style-bar">
                                    <nav>
                                        <ul>
                                            <li><a href="#section-bar-1" class="sticon ti-angle-double-left"><span><?=translate('pending_application')?></span></a></li>
                                            <li><a href="#section-bar-2" class="sticon ti-angle-double-right"><span><?=translate('approve_application')?></span></a></li>
                                        </ul>
                                    </nav>
									
                                    <div class="content-wrap">
                                        <section id="section-bar-1">
											<table id="example23" class="completed-payout" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?=translate('name'); ?></th>
                                        <th><?=translate('document'); ?></th>
                                        <th><?=translate('details'); ?></th>
                                        <th><?=translate('status'); ?></th>
                                        <th><?=translate('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pending_applications->result_array() as $key => $pending_application):
                                        $user_data = $this->user_model->get_all_user($pending_application['user_id'])->row_array();?>
                                        <tr class="gradeU">
                                            
                                            <td>
                                                <?=$user_data['first_name'].' '.$user_data['last_name']; ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($pending_application['document'])): ?>
                                                    <a href="<?=base_url().'uploads/document/'.$pending_application['document']; ?>" class="btn btn-info btn-sm btn-rounded" style="color:white" download>
                                                        <i class="fa fa-download"></i> <?=translate('download'); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
											
                                            <td>
                                                <a href="javascript::" class="btn btn-info btn-sm btn-rounded" style="color:white" onclick="showAjaxModal('<?=site_url('modal/popup/application_details/'.$pending_application['id']); ?>', '<?=translate('applicant_details'); ?>')">
                                                    <i class="fa fa-info-circle"></i> <?=translate('application_details'); ?>
                                                </a>
                                            </td>
											
                                            <td style="text-align: center;">
                                                <?php if ($pending_application['status'] == 0): ?>
                                                    <div class="badge badge-danger"><?=translate('pending'); ?></div>
                                                <?php elseif($pending_application['status'] == 1): ?>
                                                    <div class="badge badge-success"><?=translate('approved'); ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
							
                            <a href="#" onclick="confirm_modal('<?php echo site_url();?>admin/pending_instructor/approve/<?php echo $pending_application['id']; ?>');">
							<button type="button" class="btn btn-info btn-rounded btn-sm"><i class="fa fa-check"></i> <?=translate('approve');?></button></a>
							
						
                            <a href="#" onclick="confirm_modal('<?php echo site_url();?>admin/pending_instructor/delete/<?php echo $pending_application['id']; ?>');">
							<button type="button" class="btn btn-danger btn-rounded btn-sm"><i class="fa fa-times"></i> <?=translate('delete');?></button></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
							
                                        </section>
                                        <section id="section-bar-2">
                                           
												
								<table id="myTable" class="pending-payout" cellspacing="0" width="100%">
                                <thead>
                                    
                                    <tr>
                                        <th><?=translate('name'); ?></th>
                                        <th><?=translate('document'); ?></th>
                                        <th><?=translate('details'); ?></th>
                                        <th><?=translate('status'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($approved_applications->result_array() as $key => $approved_application):
                                        $user_data = $this->user_model->get_all_user($approved_application['user_id'])->row_array();?>
                                        <tr class="">
                                            
                                            <td>
                                                <?php echo $user_data['first_name'].' '.$user_data['last_name']; ?>
                                            </td>

                                            <td>
                                                <?php if (!empty($approved_application['document'])): ?>
                                                    <a href="<?php echo base_url().'uploads/document/'.$approved_application['document']; ?>" class="btn btn-info btn-sm btn-rounded" style="color:white" download>
                                                        <i class="fa fa-download"></i> <?php echo translate('download'); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
											
                                            <td>
                                                <a href="javascript::" class="btn btn-info btn-sm btn-rounded" style="color:white" onclick="showAjaxModal('<?php echo site_url('modal/popup/application_details/'.$approved_application['id']); ?>', '<?php echo translate('applicant_details'); ?>')">
                                                    <i class="fa fa-info-circle"></i> <?php echo translate('application_details'); ?>
                                                </a>
                                            </td>
											
                                            <td style="text-align: center;">
                                                <?php if ($approved_application['status'] == 0): ?>
                                                    <div class="badge badge-danger"><?php echo translate('pending'); ?></div>
                                                <?php elseif($approved_application['status'] == 1): ?>
                                                    <div class="badge badge-success"><?php echo translate('approved'); ?></div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
											
						</section>              
                  	</div>
                <!-- /content -->
              	</div>
               <!-- /tabs -->			
			</div>                
		</div>
	</div>
</div>