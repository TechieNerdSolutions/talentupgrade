 <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                <div class="top-left-part"><a class="logo" href="#"><b><img src="<?php echo base_url();?>uploads/system/logo-light.png" width="50" height="50" alt="ERP" /></b><span class="hidden-xs"><strong></strong><?=get_settings('app_abbr')?></span></a></div>
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li><a href="javascript:void(0)" class="open-close hidden-xs "><i class="icon-arrow-left-circle ti-menu"></i></a></li>
                    <li>
                        <form role="search" class="app-search hidden-xs">
                            <input type="text" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i></a> </form>
                    </li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li class="dropdown"> <a class="dropdown-toggle " data-toggle="dropdown" href="#"><i class="icon-envelope"></i>
          <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
          </a>
                        <ul class="dropdown-menu mailbox animated bounceInDown">
                            <li>
                                <div class="drop-title">You have <?php echo $unread_message_counter;?> new messages</div>
                            </li>
                            <li>
                                <div class="message-center">
                                <?php 
                                    $current_user = $this->session->userdata('user_id');
                                    $this->db->where('sender !=', $current_user);
                                    $this->db->or_where('receiver !=', $current_user);
                                    $message_threads = $this->db->get('message_thread')->result_array();
                                    foreach ($message_threads as $key => $row)  :     
                                        
                                    // defining the user to show
                                    if($row['sender'] == $current_user)
                                        $user_to_show_id = $row['receiver'];
                                    if($row['receiver'] == $current_user)
                                        $user_to_show_id = $row['sender'];

                                ?>
                                    <a href="<?php echo base_url();?><?php echo strtolower($this->session->userdata('role'));?>/message/message_read/<?php echo $row['message_thread_code'];?>">
                                        <div class="user-img"> <img src="<?php echo $this->user_model->get_user_image_url($user_to_show_id); ;?>" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>

                                            <?php 
                                                $user_details = $this->db->get_where('users', array('id' => $user_to_show_id))->row_array() ;
                                                echo $user_details['first_name'] .'  '. $user_details['last_name'];
                                            ?>
                                            </h5> 
                                            
                                            <span class="mail-desc">
                                            <?php echo $this->db->get_where('message', array('message_thread_code' => $row['message_thread_code']))->row()->message;?>
                                            </span> <span class="time"><?php echo date('d, M Y',$this->db->get_where('message', array('message_thread_code' => $row['message_thread_code']))->row()->timestamp);?></span> </div>
                                    </a>
                                    <?php endforeach;?>
                                   
                                    
                                </div>
                            </li>

                            <li>
                                <a class="text-center" href="<?php echo base_url()?>admin/message"> <strong>See all messages</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-messages -->
                    </li>
                    

                    <!-- /.dropdown -->
                    <li class="dropdown">


                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> 
                        <img src="<?=$this->user_model->get_user_image_url($this->session->userdata('user_id'))?>" alt="user-img" width="36" class="img-circle"> 
                        <b class="hidden-xs">
                        
                        <?php

                        $logged_in_user_details =$this->user_model->get_all_users($this->session->userdata('user_id'))->row_array();
                        echo $logged_in_user_details['first_name'].' : ';
                        echo strtolower($this->session->userdata('role')) == 'user' ? translate('instructor') : translate('admin');

                        ?>

                        </b> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li><a href="<?=site_url(strtolower($this->session->userdata('role')).'/profile');?>"><i class="ti-user"></i> <?=translate('manage_profile')?></a></li>
                            
                            <?php if(strtolower($this->session->userdata('role')) == 'admin') : ?>
                            <li><a href="<?=base_url()?>admin/settings"><i class="fa fa-gear"></i>  <?=translate('general_settings')?></a></li>
                            <?php endif;?>

                            <li><a href="<?=base_url()?>auth/logout"><i class="fa fa-power-off"></i>  <?=translate('logout')?></a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <li class="right-side-toggle"> <a class="waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>