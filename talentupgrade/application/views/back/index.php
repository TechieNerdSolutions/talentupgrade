<?php $loginType      = strtolower($this->session->userdata('role'));?>
<?php include 'css.php'; ?>

    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
    

	<?php include 'header.php'; ?>
	<?php include $loginType.'/navigation.php';?>
	<?php include 'page_info.php';?>
	<?php include $loginType.'/'.$page_name.'.php';?>				
				
                
				
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title">Some Navbar Info...<span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                          
                            <ul class="m-t-20 chatonline">
					
									<li>
	
									</li>
								
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.right-sidebar -->
            </div>
            <!-- /.container-fluid -->
         <?php include 'footer.php'; ?>
        </div>
        <!-- /#page-wrapper -->
    </div>
 <?php include 'modal.php'; ?>
 <?php include 'js.php'; ?>