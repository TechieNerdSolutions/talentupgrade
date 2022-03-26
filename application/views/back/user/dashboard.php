 <!--row -->
 <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="white-box bg-danger">
                            <div class="r-icon-stats">
                                <i class="fa fa-laptop bg-danger"></i>
                                <div class="bodystate">
                                    <h4 style="color:white">
                                        <?php
                                            $active_courses = $this->crud_model->get_status_wise_courses_for_instructor('active');
                                            echo $active_courses->num_rows();
                                         ?>
									</h4>
                                    <span class="text-muted"><a href="javascripts::" style="color:white"><?=translate('active_courses');?></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="col-md-3 col-sm-6">
                        <div class="white-box bg-success">
                            <div class="r-icon-stats">
                                <i class="fa fa-laptop bg-success"></i>
                                <div class="bodystate">
                                    <h4 style="color:white">
                                        <?php
                                            $pending_courses = $this->crud_model->get_status_wise_courses_for_instructor('pending');
                                            echo $pending_courses->num_rows();
                                         ?>
									</h4>
                                    <span class="text-muted"><a href="javascripts::" style="color:white"><?=translate('pending_courses');?></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="col-md-3 col-sm-6">
                        <div class="white-box bg-info">
                            <div class="r-icon-stats">
                                <i class="fa fa-laptop bg-info"></i>
                                <div class="bodystate">
                                    <h4 style="color:white">
                                        <?php
                                            $draft_courses = $this->crud_model->get_status_wise_courses_for_instructor('draft');
                                            echo $draft_courses->num_rows();
                                         ?>
									</h4>
                                    <span class="text-muted"><a href="javascripts::" style="color:white"><?=translate('draft_courses');?></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="col-md-3 col-sm-6">
                        <div class="white-box bg-purple">
                            <div class="r-icon-stats">
                                <i class="fa fa-laptop bg-purple"></i>
                                <div class="bodystate">
                                    <h4 style="color:white">
										<?=$this->crud_model->get_free_and_paid_courses('free', $this->session->userdata('user_id'))->num_rows(); ?>
									</h4>
                                    <span class="text-muted"><a href="javascripts::" style="color:white"><?=translate('free_courses');?></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4 col-sm-6">
                        <div class="white-box bg-default">
                            <div class="r-icon-stats">
                                <i class="fa fa-credit-card bg-success"></i>
                                <div class="bodystate">
                                    <h4 style="color:gray">
                                         <?=$total_payout_amount > 0 ? currency($total_payout_amount) : currency_code_and_symbol().''.$total_payout_amount; ?>
									</h4>
                                    <span class="text-muted"><a href="javascripts::" style="color:gray"><?=translate('total_payout_amount');?></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="col-md-4 col-sm-6">
                        <div class="white-box bg-default">
                            <div class="r-icon-stats">
                                <i class="fa fa-arrow-down bg-info"></i>
                                <div class="bodystate">
                                    <h4 style="color:gray">
                                         <?=$total_pending_amount > 0 ? currency($total_pending_amount) : currency_code_and_symbol().''.$total_pending_amount; ?>
									</h4>
                                    <span class="text-muted"><a href="javascripts::" style="color:gray"><?php echo translate('pending_amount'); ?></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="col-md-4 col-sm-6">
                        <div class="white-box bg-default">
                            <div class="r-icon-stats">
                                <i class="fa fa-arrow-down bg-danger"></i>
                                
								 <?php if ($requested_withdrawal_amount > 0): ?>
								 
								<div class="bodystate">
                                    <h4 style="color:gray">
                                      <?=currency($requested_withdrawal_amount); ?>
									</h4>
                                    <span class="text-muted"><a href="javascripts::" style="color:white" onclick="confirm_modal('<?php echo site_url('user/withdrawal/delete'); ?>');" style="float: right; margin-top: -18px;"><?=translate('delete_requested_amount');?></a></span>
                                </div>
								 
								 <?php else: ?>
									<div class="bodystate">
										<h4 style="color:gray">
										<?=currency_code_and_symbol().''.$requested_withdrawal_amount; ?>
										</h4>
										<span class="text-muted"><a href="javascripts::" style="color:gray"><?=translate('requested_amount');?></a></span>
                                	</div>
								 <?php endif;?>
                            </div>
                        </div>
                    </div>


</div>


 				<!--row -->
                <div class="row">
						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
							<div class="white-box">
								<h3 class="box-title"><?php echo translate('income_expense_revenue');?></h3>
									<canvas id="log-stats" style="height: 130px;"></canvas>
							</div>
						</div>

						<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
							<div class="white-box">
								<h3 class="box-title"><?php echo translate('course_status');?></h3>
									
								   <canvas id="pieChart" style="height: 130px;"></canvas>
								
							</div>
						</div>
                </div>
                <!-- row -->
				
<script>
								var barChartData = {
								labels: [
									<?php
									$i = 1;
									while ($i <= 12) {
										$date = date('M', mktime(0, 0, 0, $i, 1));
										echo "'$date'";
										if ($i != 12) {
											echo ',';
										}
										$i++;
									}
									?>
												],
								datasets: [
								
								{
									label: 'Instructor Revenue',
									backgroundColor: '#28a745',
									stack: '2',
									data: [
										<?php
									$i = 1;
									while ($i <= 12) {
									$timestamp = date('M', mktime(0, 0, 0, $i, 1));
									$this->db->select_sum('instructor_revenue');
									$this->db->where('month', $timestamp);
									$this->db->where('user_id', $this->session->userdata('user_id'));
									$this->db->from('payment');
									$query = $this->db->get();
									$totalDue  = $query->row()->instructor_revenue;
													
									echo "'$totalDue'";
									
									if ($i != 12) {
											echo ',';
										}
									
									$i++;
									}
									
									?>
									]
								}, 
								
								{
									label: 'Admin Revenue',
									backgroundColor: '#5e72e4',
									stack: '1',
									data: [
									
									<?php
									$i = 1;
									while ($i <= 12) {
									$timestamp = date('M', mktime(0, 0, 0, $i, 1));
									$CurrentUserIDCourse = $this->db->get_where('course', array('user_id' => $this->session->userdata('user_id')))->row()->id;
									$this->db->select_sum('admin_revenue');
									$this->db->where('month', $timestamp);
									$this->db->where('course_id', $CurrentUserIDCourse);
									$this->db->where('user_id', $this->session->userdata('user_id'));
									$this->db->from('payment');
									$query = $this->db->get();
									$totalincome  = $query->row()->admin_revenue;
													
									echo "'$totalincome'";
									
									if ($i != 12) {
											echo ',';
										}
									
									$i++;
									}
									
									?>
									]
								}, 
		
								
								]
					
							};
							
							
							
						window.onload = function() {
							var ctx = document.getElementById('log-stats').getContext('2d');
							var ctx3 = document.getElementById("pieChart").getContext('2d');
				
							
							var myBar = new Chart(ctx, {
								type: 'bar',
								data: barChartData,
								options: {
									tooltips: {
										mode: 'index',
										intersect: false
									},
									responsive: true,
									scales: {

										xAxes: [{
											stacked: true,
										}],
										yAxes: [{
											stacked: true
										}]
									}
								}
							});
							
						// Pie chart information start from here
							var myPie = new Chart(ctx3, {
							type: 'pie',
							data: {
								labels: ["Paid Courses", "Active Courses", "Pending Courses"],
								datasets: [{
									backgroundColor: [
										"#2dce89",
										"#5e72e4",
										"#f12711",
									],
									data: [<?=$this->crud_model->get_free_and_paid_courses('paid', $this->session->userdata('user_id'))->num_rows()?>, <?=$active_courses->num_rows()?>, <?=$pending_courses->num_rows()?>]
								}]
							},
							options: {
								legend: {
								  position: 'bottom',
								  display: true,
								  labels: {
									boxWidth:40
								  }
								}
							}
						});
						
							

							
						};
						
						
				</script>
				


