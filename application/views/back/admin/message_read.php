<!-- .chat-row -->

<?php
    $message_thread_details = $this->db->get_where('message_thread', array('message_thread_code' => $current_message_thread_code))->row_array();
    $first_sender = $message_thread_details['sender'];
?>
                <div class="chat-main-box">
                    <!-- .chat-left-panel -->
                    <div class="chat-left-aside">
                        <div class="open-panel"><i class="ti-angle-right"></i></div>
                        <div class="chat-left-inner">
                            <div class="form-material">
                                <input class="form-control p-20" id="filter" type="text" placeholder="Search Contact">
                            </div>
                            <ul class="chatonline style-none ">
							<div class="userload" id="results">
							
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
							
							<style>
							.label-info{
							background-color:red;
							color:white;
							}
							</style>
							<span class="label label-red text-uppercase">
							You are chatting with : 
							<?php 
							$selectUser = $this->db->get_where('users', array('id' => $message_thread_details['receiver']))->row();
							echo $selectUser->first_name . ' ' .$selectUser->last_name;
							?>
							
							  </span>
								<div class="btn-group pull-right">
									<button class="btn btn-small btn-outline" data-toggle="dropdown"> <i class="icon-options-vertical"></i></button>
									<ul class="dropdown-menu">
										<li><a href="<?php echo base_url(); ?>admin/message/message_new">New Message</a> 
										</li>
									</ul>
								</div><br>
                        	</div>
                        </div>
                         <div class="chat-box">
                             <ul class="chat-list slimscroll" style="overflow: hidden;" tabindex="5005">   
							    <div class="view">

                                <?php
                                
                                $sql = "select * from message where message_thread_code = '".$current_message_thread_code."' order by message_id asc";
                                //$this->db->get_where('message', array('message_thread_code' => $current_message_thread_code))->result_array();
                                $messages = $this->db->query($sql)->result_array();
                                foreach ($messages as $key => $row) : 

                                $sender_details = $this->user_model->get_all_users($row['sender'])->row_array();
                                $sender_id = $row['sender'];
                                $data['message_thread_code'] = $message_thread_code;
                                  
                                ?>

								
								<?php if($sender_id == $this->session->userdata('user_id')) : ?>
								<li class="odd">
                                    <div class="chat-image"> <img src="" class="img-circle" draggable="false"/> </div>
                                    <div class="chat-body">
                                        <div class="chat-text" style="border:-moz-border-radius: 1em 4em 1em 4em;border-radius: 1em 4em 1em 4em;display:inline-block;">
                                            <h4>
                                            
                                            <?php 
                                                $selectUser = $this->db->get_where('users', array('id' => $sender_id))->row();
                                                echo $selectUser->first_name . ' ' .$selectUser->last_name;
                                            ?>
                                            
                                            </h4>

                                            <p><?php echo $row['message'];?> </p>
                                            <b> <?php echo date('d, M Y', $row['timestamp']);?><span class="tick"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck-ack" x="2063" y="2076"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#4fc3f7"/></svg></span></b> 
                                        </div>
                                    </div>
                                </li>
                                <?php endif;?>
								
								
								<?php if($sender_id != $this->session->userdata('user_id')) : ?>
                                <li>
                                    <div class="chat-image"> <img src="" class="img-circle" draggable="false"/> </div>
                                    <div class="chat-body">
                                        <div class="chat-text" style="border:-moz-border-radius: 1em 4em 1em 4em;border-radius: 1em 4em 1em 4em;display:inline-block;">
                                        <h4>
                                            
                                            <?php 
                                                $selectUser = $this->db->get_where('users', array('id' => $sender_id))->row();
                                                echo $selectUser->first_name . ' ' .$selectUser->last_name;
                                            ?>
                                            
                                        </h4>
                                            <p><?php echo $row['message'];?> </p>
                                            <b><?php echo date('d, M Y', $row['timestamp']);?></b> 
										</div>
                                    </div>
                                </li>
                                <?php endif;?>
                                <?php endforeach;?>
								
							
								
								
								
								
							  </div>
                            </ul>
							
                            <div class="row send-chat-box">  
                                <div class="col-sm-12">  
									<form method="post" class="form-horizontal form-groups-bordered validate" accept-charset="utf-8" enctype="multipart/form-data">
                                    <textarea class="form-control" name="message" id="message" placeholder="Type your message and hit enter on the keyboard"></textarea>
									 <hr>
                                   
									<?php echo form_close(); ?> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- .chat-right-panel -->
                </div>
                <!-- /.chat-row -->


	<script>
		setInterval(function() {
			$('.view').load(location.href + ' .view');
		}, 5000); // 60000 = 1 minute
	</script>
	
	<script>
		setInterval(function() {
			$('.userload').load(location.href + ' .userload');
		}, 5000); // 60000 = 1 minute
	</script>

			<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
			<script src="<?php echo base_url(); ?>assets/js/optimumajax.js"></script>
            <script language="javascript">
            $(function() {
                $("#message").keypress(function (e) {
                    if(e.which == 13) {
                        //submit form via ajax, this is not JS but server side scripting so not showing here
                        var message = $("textarea#message").val();
						 if (message == "") {
                            
                            $(document).ready(function() {
                                $.toast({
                                    heading: 'Error !!!',
                                    text: '<?php echo translate('no_options_can_be_blank_and_there_has_to_be_atleast_one_answer'); ?>',
                                    position: 'bottom-right',
                                    loaderBg: '#ff6849',
                                    icon: 'error',
                                    hideAfter: 3500,
                                    stack: 6
                                })
                            });
									
									return false;
        						}
								
                            jQuery.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>" + "admin/message/send_reply/<?php echo $current_message_thread_code?>",
                            dataType: 'json',
                            data: {message: message},
                                success: function(res) {
                                    if (res){
                                    // echo some message here
                                    }
                                }
                            });
                        $("#ok").append($(this).val());
                        $(this).val("");
                        e.preventDefault();
                    }
                });
            });
    </script>