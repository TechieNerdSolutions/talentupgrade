<!DOCTYPE html>  
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="We ddevelop creative software, eye catching software. We also train to become a creative thinker">
<meta name="author" content="RACHAMV SOFTLAB">
<link rel="icon"  sizes="16x16" href="<?php echo base_url() ?>uploads/logo.png">
<title><?=get_settings('system_name')?> | <?=translate('login_page')?> </title>
<!-- Bootstrap Core CSS -->
<link href="<?php echo base_url(); ?>rachamvsoftlab/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>rachamvsoftlab/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
<!-- animation CSS -->
<link href="<?php echo base_url(); ?>rachamvsoftlab/css/animate.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="<?php echo base_url(); ?>rachamvsoftlab/css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="<?php echo base_url(); ?>rachamvsoftlab/css/colors/megna.css" id="theme"  rel="stylesheet">
<link href="<?php echo base_url();?>rachamvsoftlab/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">


<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

	
</head>
<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>

		
<section id="wrapper" class="login-register">
  <div class="login-box login-sidebar">
    <div class="white-box">
	    <h4 class="box-title m-b-20" align="center">
	    <br><br><br>
            <img src="<?=base_url()?>uploads/logo.png" class="img-circle" width="70" height="70"/></h4>
            <h5 align="center"><a href="<?php echo base_url();?>"><?=get_settings('system_name')?></a></h5>
            <br>

            <?php if($this->session->flashdata('flash_message') != "") : ?>
            <div class="alert alert-success hide_message_notification"><?=$this->session->flashdata('flash_message')?></div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error_message') != "") : ?>
            <div class="alert alert-danger hide_message_notification"><?=$this->session->flashdata('error_message')?></div>
            <?php endif; ?>
					
					
	        <form method="post" role="form" id="loginform" class="form-horizontal form-material" action="<?=base_url()?>auth/validate_login">

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" name="email" required="" placeholder="email" / required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12" >
                            <input class="form-control" type="password" name="password" required="" placeholder="password" / required>
                        </div>
                    </div>
					
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="">
                            <a href="<?=base_url()?>auth/newRegistration" class="text-dark pull-left"><i class="fa fa-plus m-r-5"></i><?=translate('register_account')?></a> 
                            </div>
                            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i><?=translate('forgot_password')?></a> 
                        </div>
                    </div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-success btn-sm btn-rounded btn-block text-uppercase" type="submit" ><?=translate('login')?></button>
                        </div>
                    </div>
					
            </form>
        			
            <form method="post" role="form" id="recoverform" class="form-horizontal form-material"  action="<?php echo base_url();?>auth/resetPassword/backend">
                <input type="email" name="email" class="form-control" placeholder="email" / required>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-6">
		                    <a href="<?php echo base_url();?>"><button class="btn btn-info btn-rounded btn-sm text-uppercase" type="button" style="color:white"><i class="fa fa-mail-reply-all"></i>&nbsp;Login</button></a>
		                        <button class="btn btn-success btn-rounded btn-sm  text-uppercase" type="submit" style="color:white"><i class="fa fa-key"></i>&nbsp;Reset Password</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</section>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>rachamvsoftlab/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>rachamvsoftlab/bootstrap/dist/js/tether.min.js"></script>
    <script src="<?php echo base_url(); ?>rachamvsoftlab/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>rachamvsoftlab/plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="<?php echo base_url(); ?>rachamvsoftlab/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>


    <!--slimscroll JavaScript -->
    <script src="<?php echo base_url(); ?>rachamvsoftlab/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo base_url(); ?>rachamvsoftlab/js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url(); ?>rachamvsoftlab/js/custom.min.js"></script>
    <!--Style Switcher -->
    <script src="<?php echo base_url(); ?>rachamvsoftlab/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

    <script src="<?php echo base_url(); ?>rachamvsoftlab/plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    <script type="text/javascript">
        $( document ).ready(function(){

            $('.hide_message_notification').delay(3000).slideUp();

        });
    </script>





</body>

</html>
