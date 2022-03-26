    <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
				
                   
                    <li class="user-pro">
                        <a href="#" class="">
                        
                        <img src="<?php echo $this->user_model->get_user_image_url($this->session->userdata('user_id')); ?>" alt="user-img" class="img-circle"> 
                        
                        <span class="hide-menu">
						<?php
                    		$logged_in_user_details = $this->user_model->get_all_user($this->session->userdata('user_id'))->row_array();
							echo $logged_in_user_details['first_name'];// .' '. $logged_in_user_details['last_name'];
                    	?>
                       </span>
                        </a>
                       
                    </li>
                   
                    <li class="<?php if($page_name == 'dashboard') echo 'active'; ?>"> <a href="<?php echo base_url();?>user/dashboard" class="">
						<i class="ti-dashboard p-r-10"></i> <span class="hide-menu"><?php echo translate('dashboard');?></span></a> 
					</li>
					
					
						<?php if ($this->session->userdata('is_instructor')): ?>
							
						<li class="<?php if($page_name == 'courses') echo 'active'; ?>"><a href="<?php echo base_url();?>user/courses/" class="">
							<i class="fa fa-laptop p-r-10"></i> <span class="hide-menu"><?php echo translate('manage_courses');?></span></a>
						</li>

					
						<li class="<?php if($page_name == 'payment_settings') echo 'active'; ?>"><a href="<?php echo base_url();?>user/payment_settings/" class="">
							<i class="fa fa-plus p-r-10"></i> <span class="hide-menu"><?php echo translate('payment_settings');?></span></a>
						</li>
						
						<li class="<?php if($page_name == 'payment_settlement') echo 'active'; ?>"><a href="<?php echo base_url();?>user/payment_settlement/">
							<i class="fa fa-credit-card p-r-10"></i> <span class="hide-menu"><?php echo translate('payout_settlement');?></span></a>
						</li>	
						
							
						<?php else: ?>
						
									<li class="<?php if ($page_name == 'application') echo 'active'; ?> ">
										<a href="<?php echo base_url(); ?>user/application">
										<i class="fa fa-angle-double-right p-r-10"></i>
											<span class="hide-menu"><?php echo translate('application_form'); ?></span>
										</a>
									</li>
						
						<?php endif; ?>
								
					
					
                    <li><a href="<?php echo base_url();?>login/logout/" class=""><i class="fa fa-sign-out p-r-10"></i> 
						<span class="hide-menu"><?php echo translate('logout');?></span></a>
					</li>
                    
                </ul>
            </div>
        </div>
        <!-- Left navbar-header end -->