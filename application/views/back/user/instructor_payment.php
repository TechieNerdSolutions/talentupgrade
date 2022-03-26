	<style>
	.badge-danger{
		background-color:red;
		color:white;
	}
	</style>
<div class="row"> 
	<div class="col-sm-12"> 
		<div class="panel panel-info"> 
			<div class="panel-body table-responsive"> 

                                <div class="sttabs tabs-style-bar"> 
                                    <nav>
                                        <ul>
                                            <li><a href="#section-bar-1" class="sticon ti-angle-double-left"><span><?=translate('complete_payment')?></span></a></li>
                                            <li><a href="#section-bar-2" class="sticon ti-angle-double-right"><span><?=translate('pending_payment')?></span>
											<span class="badge badge-danger"><?php echo $pending_payouts->num_rows(); ?></span></a></li>
                                        </ul>
                                    </nav>
									
                                    <div class="content-wrap">
                                        <section id="section-bar-1">
											<table id="example23" class="completed-payout" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th><?=translate('image'); ?></th>
													<th><?=translate('instructor'); ?></th>
													<th><?=translate('payout_amount'); ?></th>
													<th><?=translate('payment_type'); ?></th>
													<th><?=translate('payout_date'); ?></th>
													<th><?=translate('action'); ?></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($completed_payouts->result_array() as $key => $completed_payout):
													$completed_payout_user_data = $this->db->get_where('users', array('id' => $completed_payout['user_id']))->row_array(); ?>
													<tr class="gradeU">
														<td>
															<img src="<?php echo $this->user_model->get_user_image_url($completed_payout_user_data['id']);?>" alt="" height="50" width="50" class="img-fluid rounded-circle img-thumbnail">
														</td>
														<td>
															<strong><?php echo $completed_payout_user_data['first_name'].' '.$completed_payout_user_data['last_name']; ?></strong>
														</td>
														<td> <?php echo currency($completed_payout['amount']); ?> </td>
														<td> <?php echo ucfirst($completed_payout['payment_type']); ?> </td>
														<td> <?php echo date('D, d M Y', $completed_payout['date_added']); ?> </td>
														<td> <a href="<?php echo site_url('user/invoice/'.$completed_payout['id']); ?>" class="btn btn-outline-primary btn-rounded btn-sm"><i class="mdi mdi-printer-settings"></i></a> </td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>		
                                        </section>
                                        <section id="section-bar-2">
                                           
												
								<table id="myTable" class="pending-payout" role="grid" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo translate('image'); ?></th>
                                        <th><?php echo translate('instructor'); ?></th>
                                        <th><?php echo translate('payout_amount'); ?></th>
                                        <th><?php echo translate('payout_date'); ?></th>
                                        <th><?php echo translate('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pending_payouts->result_array() as $key => $pending_payout):
                                        $pending_payout_user_data = $this->db->get_where('users', array('id' => $pending_payout['user_id']))->row_array();
                                        $paypal_keys          = json_decode($pending_payout_user_data['paypal_keys'], true);
                                        $stripe_keys          = json_decode($pending_payout_user_data['stripe_keys'], true);
                                        ?>
                                        <tr class="gradeU">
                                            <td>
                                                <img src="<?php echo $this->user_model->get_user_image_url($pending_payout_user_data['id']);?>" alt="" height="50" width="50" class="img-fluid rounded-circle img-thumbnail">
                                            </td>
                                            <td>
                                                <strong><?php echo $pending_payout_user_data['first_name'].' '.$pending_payout_user_data['last_name']; ?></strong>
                                            </td>
                                            <td> <?php echo currency($pending_payout['amount']); ?> </td>
                                            <td> <?php echo date('D, d M Y', $pending_payout['date_added']); ?> </td>
                                            <td style="text-align: center;">
                                              <?php if ($pending_payout['status'] == 0): ?>
                                                <?php if ($paypal_keys[0]['production_client_id'] != ""): ?>
                                                  <form action="<?php echo site_url('user/paypal_checkout_for_instructor_revenue'); ?>" method="post">
                                                    <input type="hidden" name="amount_to_pay"        value="<?php echo $pending_payout['amount']; ?>">
                                                    <input type="hidden" name="payout_id"            value="<?php echo $pending_payout['id']; ?>">
                                                    <input type="hidden" name="instructor_name"      value="<?php echo $pending_payout_user_data['first_name'].' '.$pending_payout_user_data['last_name']; ?>">
                                                    <input type="hidden" name="production_client_id" value="<?php echo $paypal_keys[0]['production_client_id']; ?>">
                                                    <input type="submit" class="btn btn-outline-info btn-sm btn-rounded"        value="<?php echo translate('pay_with_paypal'); ?>">
                                                  </form>
                                                <?php else: ?>
                                                  <button type="button" class = "btn btn-outline-danger btn-sm btn-rounded" name="button" onclick="alert('<?php echo translate('this_instructor_has_not_provided_valid_paypal_client_id'); ?>')"><?php echo translate('pay_with_paypal'); ?></button>
                                                <?php endif; ?>
                                                <?php if ($stripe_keys[0]['public_live_key'] != "" && $stripe_keys[0]['secret_live_key']): ?>
                                                  <form action="<?php echo site_url('user/stripe_checkout_for_instructor_revenue'); ?>" method="post">
                                                    <input type="hidden" name="amount_to_pay"   value="<?php echo $pending_payout['amount']; ?>">
                                                    <input type="hidden" name="payout_id"      value="<?php echo  $pending_payout['id']; ?>">
                                                    <input type="hidden" name="instructor_name" value="<?php echo $pending_payout_user_data['first_name'].' '.$pending_payout_user_data['last_name']; ?>">
                                                    <input type="hidden" name="public_live_key" value="<?php echo $stripe_keys[0]['public_live_key']; ?>">
                                                    <input type="hidden" name="secret_live_key" value="<?php echo $stripe_keys[0]['secret_live_key']; ?>">
                                                    <input type="submit" class="btn btn-outline-info btn-sm btn-rounded"   value="<?php echo translate('pay_with_stripe'); ?>">
                                                  </form>
                                                <?php else: ?>
                                                  <button type="button" class = "btn btn-outline-danger btn-sm btn-rounded" name="button" onclick="alert('<?php echo translate('this_instructor_has_not_provided_valid_public_key_or_secret_key'); ?>')"><?php echo translate('pay_with_stripe'); ?></button>
                                                <?php endif; ?>
                                              <?php else: ?>
                                                <a href="<?php echo site_url('user/invoice/'.$pending_payout['id']); ?>" class="btn btn-outline-primary btn-rounded btn-sm"><i class="mdi mdi-printer-settings"></i></a>
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