<!-- .chat-row -->
<div class="chat-main-box">
	<!-- .chat-left-panel -->
	<div class="chat-left-aside">
		<div class="open-panel"><i class="ti-angle-right"></i></div>
			<div class="chat-left-inner">
				<div class="form-material">
					<input class="form-control p-20" type="text" placeholder="Search Contact">
				</div>
				<ul class="chatonline style-none ">

                    <?php 
                        $current_user = $this->session->userdata('user_id');
                        $this->db->where('sender', $current_user);
                        $this->db->or_where('receiver', $current_user);
                        $message_threads = $this->db->get('message_thread')->result_array();
                        foreach ($message_threads as $key => $row)  :     
                            
                        // defining the user to show
                        if($row['sender'] == $current_user)
                            $user_to_show_id = $row['receiver'];
                        if($row['receiver'] == $current_user)
                            $user_to_show_id = $row['sender'];

                        $unread_message_number = $this->crud_model->count_unread_message_of_thread($row['message_thread_code']);
                    ?>
                   
					<li>
						<a href="<?php echo site_url('admin/message/message_read/' . $row['message_thread_code']);?>" class="<?php if(isset($current_message_thread_code) && $current_message_thread_code == $row['message_thread_code']) echo 'actie' ;?>">
                            <img src="<?php echo $this->user_model->get_user_image_url($user_to_show_id); ;?>" class="img-circle" draggable="false"/> 
                            <span>
                            <?php 
                            $user_details = $this->db->get_where('users', array('id' => $user_to_show_id))->row_array() ;
                            echo $user_details['first_name'] .'  '. $user_details['last_name'];
                            ?>
                                <span class="pull-right">
                            
                                </span>
                            
                                <small class="text-success">
                                    <?php if($unread_message_number > 0 ) : ?>
                                    <?php echo $unread_message_number . ' ' . 'Messages(s)';?>
                                    <?php endif;?>
                                    <?php if($unread_message_number == 0 ) : ?>
                                    <?php echo 'No message for now';?>
                                    <?php endif;?>
                                </small>
                            </span>
                        </a> 
                    </li>
                    <?php endforeach;?>
						<?php if($row['message_thread_code'] == "") : ?>
						    <div class="alert alert-danger" align="center">No message for you, Please check back later !</div>
                        <?php endif;?>
                     <li class="p-20"></li>
                            </ul>
                        </div>
                    </div>
                    <!-- .chat-left-panel -->
                    <!-- .chat-right-panel -->
                    <div class="chat-right-aside">
                        <div class="chat-main-header">
                            <div class="p-20 b-b">
                                <h3 class="box-title">Chat Message
									 <div class="btn-group pull-right">
										<button class="btn btn-small btn-outline" data-toggle="dropdown"> <i class="icon-options-vertical"></i></button>
										<ul class="dropdown-menu">
											<li><a href="<?php echo base_url(); ?>admin/message/message_new">New Message</a> </li>
                                        </ul>
									 </div>
								</h3>
                            </div>
                        </div>
                        <div class="chat-box">
                            <ul class="chat-list slimscroll p-t-30">
                              Welcome To <?php echo get_settings('system_name');?>&nbsp;Chat Application<br><br>
								
                              <?php echo get_settings('system_name');?> Chat Application is quite hot and easy-to-use for internal communication, at the moment it offers only private messages.<br><br>

								To get started, select a user from the left tab.

								Chat immediately as you start your work day. You can use private messages for direct, one-on-one communication
                            </ul>
                            <div class="row send-chat-box">
                                <div class="col-sm-12">
                                    
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- .chat-right-panel -->
                </div>
                <!-- /.chat-row -->
