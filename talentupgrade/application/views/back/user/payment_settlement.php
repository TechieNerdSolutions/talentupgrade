 <!--row -->
 <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="white-box bg-success">
                            <div class="r-icon-stats">
                                <i class="fa fa-credit-card bg-success"></i>
                                <div class="bodystate">
                                    <h4 style="color:white">
                                         <?=$total_payout_amount > 0 ? currency($total_payout_amount) : currency_code_and_symbol().''.$total_payout_amount; ?>
									</h4>
                                    <span class="text-muted"><a href="javascripts::" style="color:white"><?=translate('total_payout_amount');?></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="col-md-4 col-sm-6">
                        <div class="white-box bg-danger">
                            <div class="r-icon-stats">
                                <i class="fa fa-arrow-down bg-danger"></i>
                                <div class="bodystate">
                                    <h4 style="color:white">
                                         <?=$total_pending_amount > 0 ? currency($total_pending_amount) : currency_code_and_symbol().''.$total_pending_amount; ?>
									</h4>
                                    <span class="text-muted"><a href="javascripts::" style="color:white"><?php echo translate('pending_amount'); ?></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="col-md-4 col-sm-6">
                        <div class="white-box bg-info">
                            <div class="r-icon-stats">
                                <i class="fa fa-arrow-down bg-info"></i>
                                
								 <?php if ($requested_withdrawal_amount > 0): ?>
								 
								<div class="bodystate">
                                    <h4 style="color:white">
                                      <?=currency($requested_withdrawal_amount); ?>
									</h4>
                                    <span class="text-muted"><a href="javascripts::" style="color:white" onclick="confirm_modal('<?php echo site_url('user/withdrawal/delete'); ?>');" style="float: right; margin-top: -18px;"><?=translate('delete_requested_amount');?></a></span>
                                </div>
								 
								 <?php else: ?>
									<div class="bodystate">
										<h4 style="color:white">
										<?=currency_code_and_symbol().''.$requested_withdrawal_amount; ?>
										</h4>
										<span class="text-muted"><a href="javascripts::" style="color:white"><?=translate('requested_amount');?></a></span>
                                	</div>
								 <?php endif;?>
                            </div>
                        </div>
                    </div>

</div>


 				<!--row -->
                <div class="row">
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<div class="white-box">
					
					
					
					
<a href = "javascript:void(0)" class="btn btn-primary btn-rounded btn-sm" onclick="showAjaxModal('<?php echo site_url('modal/popup/request_withdrawal'); ?>', '<?=translate('request_a_new_withdrawal'); ?>')"><i class="mdi mdi-plus"></i><?=translate('request_a_new_withdrawal'); ?></a>
					<hr class="sep-2">
					
					
					<table id="myTable" class="">
                        <thead>
                            <tr>
                                <th><?php echo translate('payout_amount'); ?></th>
                                <th><?php echo translate('payment_type'); ?></th>
                                <th><?php echo translate('date_processed'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payouts->result_array() as $key => $payout):?>
                                <tr>
                                    <td>
                                        <?php echo currency($payout['amount']); ?>
                                        <?php if (!$payout['status']): ?>
                                            <br><small class="label label-success"><strong><?php echo translate('requested_at'); ?> :</strong> <?php echo date('D, d M Y', $payout['date_added']); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($payout['status']): ?>
                                            <?php echo ucfirst($payout['payment_type']); ?>
                                        <?php else: ?>
                                            <span class="label label-warning"><?php echo translate('pending'); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($payout['status'] && !empty($payout['last_modified'])): ?>
                                            <?php echo date('D, d M Y', $payout['last_modified']); ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
								
							</div>
						</div>

						
                </div>
                <!-- row -->