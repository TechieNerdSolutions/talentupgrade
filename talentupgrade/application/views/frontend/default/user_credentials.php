<section class="page-header-area my-course-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="page-title"><?php echo translate('purchase_history'); ?></h1>
                <ul>
                    <li><a href="<?php echo site_url('home/my_courses'); ?>"><?php echo translate('all_courses'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_wishlist'); ?>"><?php echo translate('wishlists'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_messages'); ?>"><?php echo translate('my_messages'); ?></a></li>
                    <li><a href="<?php echo site_url('home/purchase_history'); ?>"><?php echo translate('purchase_history'); ?></a></li>
                    <li class="active"><a href=""><?php echo translate('user_profile'); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="user-dashboard-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="user-dashboard-box">
                    <div class="user-dashboard-sidebar">
                        <div class="user-box">
                            <img src="<?php echo base_url().'uploads/user_image/'.$this->session->userdata('user_id').'.jpg';?>" alt="" class="img-fluid">
                            <div class="name"><?php echo $user_details['first_name'].' '.$user_details['last_name']; ?></div>
                        </div>
                        <div class="user-dashboard-menu">
                            <ul>
                                <li><a href="<?php echo site_url('home/profile/user_profile'); ?>"><?php echo translate('profile'); ?></a></li>
                                <li class="active"><a href="<?php echo site_url('home/profile/user_credentials'); ?>"><?php echo translate('account'); ?></a></li>
                                <li><a href="<?php echo site_url('home/profile/user_photo'); ?>"><?php echo translate('photo'); ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="user-dashboard-content">
                        <div class="content-title-box">
                            <div class="title"><?php echo translate('account'); ?></div>
                            <div class="subtitle"><?php echo translate('edit_your_account_settings'); ?>.</div>
                        </div>
                        <form action="<?php echo site_url('home/update_profile/update_credentials'); ?>" method="post">
                            <div class="content-box">
                                <div class="email-group">
                                    <div class="form-group">
                                        <label for="email"><?php echo translate('email'); ?>:</label>
                                        <input type="email" class="form-control" name = "email" id="email" placeholder="<?php echo translate('email'); ?>" value="<?php echo $user_details['email']; ?>">
                                    </div>
                                </div>
                                <div class="password-group">
                                    <div class="form-group">
                                        <label for="password"><?php echo translate('password'); ?>:</label>
                                        <input type="password" class="form-control" id="current_password" name = "current_password" placeholder="<?php echo translate('enter_current_password'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name = "new_password" placeholder="<?php echo translate('enter_new_password'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name = "confirm_password" placeholder="<?php echo translate('re-type_your_password'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="content-update-box">
                                <button type="submit" class="btn"><?php echo translate('save'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
