<?php if (!isset($message_thread_code)): ?>
    <div class="text-center empty-box"><?php echo translate('select_a_message_thread_to_read_it_here'); ?>.</div>
<?php endif; ?>
<?php
    if (isset($message_thread_code)):
    $message_thread_details = $this->db->get_where('message_thread', array('message_thread_code' => $message_thread_code))->row_array();
    if ($this->session->userdata('user_id') == $message_thread_details['sender']){
        $user_to_show_id = $message_thread_details['receiver'];
    }
    else{
        $user_to_show_id = $message_thread_details['sender'];
    }
    $user_to_show_details = $this->user_model->get_all_user($user_to_show_id)->row_array();
    $messages = $this->db->get_where('message', array('message_thread_code' => $message_thread_code))->result_array();?>
    <div class="message-details d-show ">
        <div class="message-header">
            <a href="<?php echo site_url('home/instructor_page'); ?>">
                <span class="sender-info userload">
                    <span class="d-inline-block">
                        <img src="<?php echo $this->user_model->get_user_image_url($user_to_show_id);?>" alt="">
                    </span>
                    <span class="d-inline-block">
                    <?php echo $user_to_show_details['first_name'].' '.$user_to_show_details['last_name']; ?>
                </span>
                </span>
            </a>
        </div>
        <div class="message-content">
            <span class="sender-info rachamvsoftlab">
			<?php foreach ($messages as $message): ?>
                <?php if ($message['sender'] == $this->session->userdata('user_id')): ?>
                    <div class="message-box-wrap me">
                        <div class="message-box">
                            <div class="time"><?php echo date('D, d-M-Y', $message['timestamp']); ?></div>
                            <div class="message"><?php echo $message['message']; ?></div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="message-box-wrap">
                        <div class="message-box">
                            <div class="time"><?php echo date('D, d-M-Y', $message['timestamp']); ?></div>
                            <div class="message"><?php echo $message['message']; ?></div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
		</span>
			
        </div>
		
        <div class="message-footer">
                <textarea class="form-control" id="message" name="message" placeholder="<?php echo translate('type_your_message_and_hit_enter'); ?>..."></textarea>
        </div>
    </div>
<?php endif; ?>

				<script>
				setInterval(function() {
				  $('.userload').load(location.href + ' .userload');
				}, 2000); // 60000 = 1 minute
				</script>
				
				<script>
				setInterval(function() {
				  $('.rachamvsoftlab').load(location.href + ' .rachamvsoftlab');
				}, 2000); // 60000 = 1 minute
				</script>
				
				
				<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
			<script src="<?php echo base_url(); ?>vendors/js/optimumajax.js"></script>
            <script language="javascript">
            $(function() {
                $("#message").keypress(function (e) {
                    if(e.which == 13) {
                        //submit form via ajax, this is not JS but server side scripting so not showing here
                        var message = $("textarea#message").val();
						 if (message == "") {
									Lobibox.notify('error', {
									pauseDelayOnHover: true,
									continueDelayOnInactiveTab: false,
									icon: 'fa fa-times-circle',
									position: 'bottom right',
									showClass: 'lightSpeedIn',
									hideClass: 'lightSpeedOut',
									width: 600,
									msg: 'Message textfield can not be empty, please type something and press enter on the keyboard'
									})
									
									return false;
        						}
								
                            jQuery.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>" + "home/my_messages/send_reply/<?=$message_thread_code?>",
                            dataType: 'json',
                            data: {message: message},
                                success: function(res) {
                                    if (res)
                                    {
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
