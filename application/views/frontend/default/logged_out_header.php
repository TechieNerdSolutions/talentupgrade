
<?php if(get_settings('noti_status') == 1): ?>
<div class="alert alert-<?=get_settings('noti_colour')?> hide_msg" align="center"><?=get_settings('noti_message')?>
<h3 id="demo"></h3>
</div>
<?php endif;?>
<section class="menu-area">
  <div class="container-xl">
    <div class="row">
      <div class="col">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">

          <ul class="mobile-header-buttons">
            <li><a class="mobile-nav-trigger" href="#mobile-primary-nav">Menu<span></span></a></li>
            <li><a class="mobile-search-trigger" href="#mobile-search">Search<span></span></a></li>
          </ul>

          <a href="<?php echo site_url(''); ?>" class="navbar-brand" href="#"><img src="<?php echo base_url().'uploads/system/logo-dark.png'; ?>" alt="" height="35"></a>

          <?php include 'menu.php'; ?>

          <form class="inline-form" action="<?php echo site_url('home/search'); ?>" method="get" style="width: 100%;">
            <div class="input-group search-box mobile-search">
              <input type="text" id="search_input_course_header" name = 'query' class="form-control" placeholder="<?php echo translate('search_for_anything'); ?>">
              <div class="input-group-append pull-left">
                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
              </div>
				
            </div>
<?php if ($this->session->userdata('admin_login')): ?>
<li id="stu_course_header" style="list-style-type: none;margin-right:300px;z-index: 100;position: absolute;margin-top: -10px; width:800px; padding-left:20px;padding-top:10px;font-family:Georgia, Times, serif; font-size:1.6em; line-height:2.1em;"></li>
<?php endif; ?>
<?php if (!$this->session->userdata('admin_login')): ?>
<li id="stu_course_header" style="list-style-type: none;margin-right:300px;z-index: 100;position: absolute;margin-top: -10px; width:800px; padding-left:20px;padding-top:10px;font-family:Georgia, Times, serif; font-size:1.6em; line-height:2.1em;"></li>

<?php endif; ?>
          </form>
		 
          <?php if ($this->session->userdata('admin_login')): ?>
            <div class="instructor-box menu-icon-box">
              <div class="icon">
                <a href="<?php echo site_url('admin'); ?>" style="border: 1px solid transparent; margin: 10px 10px; font-size: 14px; width: 100%; border-radius: 0;"><?php echo translate('administrator'); ?></a>
              </div>
            </div>
          <?php endif; ?>
		 

          <div class="cart-box menu-icon-box" id = "cart_items">
            <?php include 'cart_items.php'; ?>
          </div>

		
          <span class="signin-box-move-desktop-helper"></span>
		   <?php if (!$this->session->userdata('admin_login')): ?>
          <div class="sign-in-box btn-group">
			
            <a href="<?php echo site_url('auth'); ?>" class="btn btn-sign-in"><?php echo translate('log_in'); ?></a>

            <a href="<?php echo site_url('auth/newRegistration'); ?>" class="btn btn-sign-up"><?php echo translate('sign_up'); ?></a>

          </div> <!--  sign-in-box end -->
		   <?php endif; ?>
		  
        </nav>
		
      </div>
	  
    </div>
	
  </div>
	  		
</section>

    <!-- auto hide message div-->
    <script type="text/javascript">
        $( document ).ready(function(){
           $('.hide_msg').delay(90000).slideUp();
        });
    </script>
	<script>
// Set the date we're counting down to
var countDownDate = new Date("<?=date('d M, Y', get_settings('noti_date'))?>").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>


		<script type="text/javascript">
            $(document).ready(function(){         
                var consulta;          
                    $("#search_input_course_header").keyup(function(e){
                    consulta = $("#search_input_course_header").val();
                    $("#stu_course_header").queue(function(n) {                     
                    $("#stu_course_header").html('<img src="<?php echo base_url();?>vendors/assets/images/loader-1.gif" />');            
                        $.ajax({
                              type: "POST",
                              url: '<?php echo base_url();?>home/ajax_instructor_course',
                              data: "b="+consulta,
                              dataType: "html",
                              error: function(){
                                    alert("Error");
                              },
                              success: function(data){                                                      
                                    $("#stu_course_header").html(data);
                                    n();
                              }
                  		});                           
             		});                       
      			});                       
			});
		</script>


