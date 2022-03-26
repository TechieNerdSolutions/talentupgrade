    <!-- Left navbar-header -->
    <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                        <!-- input-group -->
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search..."> <span class="input-group-btn">
            <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
            </span> </div>
                        <!-- /input-group -->
                    </li>
                    <li class="user-pro">
                        <a href="#" class="waves-effect">
                        <img src="<?=$this->user_model->get_user_image_url($this->session->userdata('user_id'))?>" alt="user-img" class="img-circle"> 
                        <span class="hide-menu">
                        <?php

                        $logged_in_user_details =$this->user_model->get_all_users($this->session->userdata('user_id'))->row_array();
                        echo $logged_in_user_details['first_name']. ' ' . $logged_in_user_details['last_name'];
                        ?>
                        <!-- <span class="fa arrow"></span>--> </span>
                        </a>
                        <!-- <ul class="nav nav-second-level">
                            <li><a href="javascript:void(0)"><i class="ti-user"></i> My Profile</a></li>
                            <li><a href="javascript:void(0)"><i class="ti-email"></i> Inbox</a></li>
                            <li><a href="javascript:void(0)"><i class="ti-settings"></i> Account Setting</a></li>
                            <li><a href="<?php echo base_url()?>auth/logout"><i class="fa fa-power-off"></i> <?=translate('logout')?></a></li>
                        </ul> -->
                    </li>
                    
                    <li class="<?php if($page_name == 'dashboard') echo 'active';?>"> <a href="<?=base_url()?>admin/dashboard" class="waves-effect"><i class="ti-dashboard p-r-10"></i> <span class="hide-menu"><?=translate('dashboard')?></span></a> </li>
                   
                    <li class="ticket"> <a href="#" class=""><i data-icon="&#xe006;" class="fa fa-plus p-r-10"></i> 
						<span class="hide-menu"><?php echo translate('course_category');?><span class="fa arrow"></span></span></a>
							<ul class=" nav nav-second-level<?php
								if ($page_name == 'add_categories' || $page_name == 'categories') echo 'opened active';?>">
				
									<li class="<?php if ($page_name == 'add_categories') echo 'active'; ?> ">
										<a href="<?php echo base_url(); ?>admin/add_categories">
										<i class="fa fa-angle-double-right p-r-10"></i>
											<span class="hide-menu"><?php echo translate('add_categories'); ?></span>
										</a>
									</li>
				
									<li class="<?php if ($page_name == 'categories') echo 'active'; ?> ">
										<a href="<?php echo base_url(); ?>admin/categories">
										<i class="fa fa-angle-double-right p-r-10"></i>
											<span class="hide-menu"><?php echo translate('list_categories'); ?></span>
										</a>
									</li>
								</ul>
							</li>
							
							
                    <li class="<?php if($page_name == 'courses') echo 'active'; ?>"><a href="<?php echo base_url();?>admin/courses/" class="">
						<i class="fa fa-laptop p-r-10"></i> <span class="hide-menu"><?php echo translate('manage_courses');?></span></a>
					</li>
					
                    <li class="<?php if($page_name == 'student') echo 'active'; ?>"><a href="<?php echo base_url();?>admin/student/" class="">
						<i class="fa fa-users p-r-10"></i> <span class="hide-menu"><?php echo translate('manage_students');?></span></a>
					</li>
					
                    <li class="<?php if($page_name == 'enrol_student') echo 'active'; ?>"><a href="<?php echo base_url();?>admin/enrol_student" class="">
						<i class="fa fa-plus p-r-10"></i> <span class="hide-menu"><?php echo translate('student_enrolment');?></span></a>
					</li>
					
					<li> <a href="#" class=""><i data-icon="&#xe006;" class="fa fa-fax p-r-10"></i> <span class="hide-menu">
					<?php echo translate('expenses');?><span class="fa arrow"></span></span></a>
        
                        <ul class=" nav nav-second-level<?php if ($page_name == 'expense' || $page_name == 'expense_category' ) echo 'opened active';?> ">
                     
							<li class="<?php if ($page_name == 'expense') echo 'active'; ?> ">
								<a href="<?php echo base_url(); ?>expense/expense">
								<i class="fa fa-angle-double-right p-r-10"></i>
									 <span class="hide-menu"><?php echo translate('expense'); ?></span>
								</a>
							</li>
	
							<li class="<?php if ($page_name == 'expense_category') echo 'active'; ?> ">
								<a href="<?php echo base_url(); ?>expense/expense_category">
								<i class="fa fa-angle-double-right p-r-10"></i>
									 <span class="hide-menu"><?php echo translate('expense_category'); ?></span>
								</a>
							</li>
		 
                 		</ul>
                	</li>
					
					
						<li class="ticket"> <a href="#" class=""><i data-icon="&#xe006;" class="fa fa-users p-r-10"></i> 
						<span class="hide-menu"><?php echo translate('manage_instructor');?><span class="fa arrow"></span></span></a>
							<ul class=" nav nav-second-level<?php
								if ($page_name == 'instructor' || $page_name == 'instructor_payment'|| $page_name == 'instructor_settings' 
								|| $page_name == 'pending_instructor') echo 'opened active';?>">
								
								
									<li class="<?php if ($page_name == 'pending_instructor') echo 'active'; ?> ">
										<a href="<?php echo base_url(); ?>admin/pending_instructor">
										<i class="fa fa-angle-double-right p-r-10"></i>
											<span class="hide-menu"><?php echo translate('pending_instructor'); ?></span>
										</a>
									</li>
									
									<li class="<?php if ($page_name == 'instructor_settings') echo 'active'; ?> ">
										<a href="<?php echo base_url(); ?>admin/instructor_settings">
										<i class="fa fa-angle-double-right p-r-10"></i>
											<span class="hide-menu"><?php echo translate('instructor_settings'); ?></span>
										</a>
									</li>
									
									<li class="<?php if ($page_name == 'instructor') echo 'active'; ?> ">
										<a href="<?php echo base_url(); ?>admin/instructor">
										<i class="fa fa-angle-double-right p-r-10"></i>
											<span class="hide-menu"><?php echo translate('instructor'); ?></span>
										</a>
									</li>
									
				
									<li class="<?php if ($page_name == 'instructor_payment') echo 'active'; ?> ">
										<a href="<?php echo base_url(); ?>admin/instructor_payment">
										<i class="fa fa-angle-double-right p-r-10"></i>
											<span class="hide-menu"><?php echo translate('instructor_payment'); ?></span>
										</a>
									</li>
									

									
								</ul>
							</li>
							
							

						<li class="ticket"> <a href="#" class=""><i data-icon="&#xe006;" class="fa fa-plus p-r-10"></i> 
						<span class="hide-menu"><?php echo translate('message_&_promo');?><span class="fa arrow"></span></span></a>
							<ul class=" nav nav-second-level<?php
								if ($page_name == 'message' || $page_name == 'notification') echo 'opened active';?>">
				
									<li class="<?php if ($page_name == 'message') echo 'active'; ?> ">
										<a href="<?php echo base_url(); ?>admin/message">
										<i class="fa fa-angle-double-right p-r-10"></i>
											<span class="hide-menu"><?php echo translate('message'); ?></span>
										</a>
									</li>
				
									<li class="<?php if ($page_name == 'notification') echo 'active'; ?> ">
										<a href="<?php echo base_url(); ?>admin/notification">
										<i class="fa fa-angle-double-right p-r-10"></i>
											<span class="hide-menu"><?php echo translate('promotion'); ?></span>
										</a>
									</li>
								</ul>
							</li>
					
                    <li class="<?php if($page_name == 'settings') echo 'active'; ?>"><a href="<?php echo base_url();?>admin/settings" class="">
						<i class="fa fa-gears p-r-10"></i> <span class="hide-menu"><?php echo translate('general_settings');?></span></a>
					</li>
					
					
                    <li class="<?php if($page_name == 'profile') echo 'active'; ?>"><a href="<?php echo base_url();?>admin/profile" class="">
						<i class="fa fa-plus p-r-10"></i> <span class="hide-menu"><?php echo translate('manage_profile');?></span></a>
					</li>
					
                    <li><a href="<?php echo base_url();?>auth/logout/" class=""><i class="fa fa-sign-out p-r-10"></i> 
						<span class="hide-menu"><?php echo translate('logout');?></span></a>
					</li>
                    
                </ul>
            </div>
        </div>
        <!-- Left navbar-header end -->