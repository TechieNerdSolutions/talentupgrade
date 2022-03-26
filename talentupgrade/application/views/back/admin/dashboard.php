 <!--row -->

                <div class="row">

                    <div class="col-md-3 col-sm-6">
                        <div class="white-box">
                            <div class="r-icon-stats">
                                <i class="fa fa-users bg-megna"></i>
                                <div class="bodystate">
                                    <h4><?php echo $this->db->get_where('users', array('role_id' => 2 ))->num_rows();?></h4>
                                    <span class="text-muted"><?php echo translate('students');?></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3 col-sm-6">
                        <div class="white-box">
                            <div class="r-icon-stats">
                                <i class="fa fa-users bg-info"></i>
                                <div class="bodystate">
                                    <h4><?php echo $this->db->get_where('users', array('role_id' => 2, 'is_instructor' => 1 ))->num_rows();?></h4>
                                    <span class="text-muted"><?php echo translate('instructors');?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="white-box">
                            <div class="r-icon-stats">
                                <i class="fa fa-users bg-success"></i>
                                <div class="bodystate">
                                    <h4><?php echo $this->db->get_where('applications', array('status' => 0 ))->num_rows();?></h4>
                                    <span class="text-muted"><?php echo translate('pending_instruc');?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="white-box">
                            <div class="r-icon-stats">
                                <i class="ti-wallet bg-inverse"></i>
                                <div class="bodystate">
                                    <h4><?php echo $this->db->count_all('course');?></h4>
                                    <span class="text-muted"><?php echo translate('courses');?></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3 col-sm-6">
                        <div class="white-box">
                            <div class="r-icon-stats">
                                <i class="fa fa-credit-card bg-info"></i>
                                <div class="bodystate">
                                    <h4>
                                        <?php 
                                            $this->db->select_sum('amount');
                                            $this->db->where('payment_type', 'expense');
                                            $this->db->from('payment');
                                            $query = $this->db->get();
                                            $sum = $query->row()->amount;
                                            if($sum == 0 || $sum == "")
                                            echo '0';
                                            else
                                            echo $sum;
                                        ?>
                                    </h4>
                                    <span class="text-muted"><?php echo translate('Expense');?></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-3 col-sm-6">
                        <div class="white-box">
                            <div class="r-icon-stats">
                                <i class="fa fa-credit-card bg-magma"></i>
                                <div class="bodystate">
                                    <h4>
                                    <?php 
                                            $this->db->select_sum('amount');
                                            $this->db->where('payment_type', 'income');
                                            $this->db->from('payment');
                                            $query = $this->db->get();
                                            $sum = $query->row()->amount;
                                            if($sum == 0 || $sum == "")
                                            echo '0';
                                            else
                                            echo $sum;
                                        ?>
                                    
                                    </h4>
                                    <span class="text-muted"><?php echo translate('total_income');?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="white-box">
                            <div class="r-icon-stats">
                                <i class="fa fa-users bg-purple"></i>
                                <div class="bodystate">
                                    <h4><?php echo $this->crud_model->get_lessons()->num_rows();?></h4>
                                    <span class="text-muted"><?php echo translate('total_lessons');?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="white-box">
                            <div class="r-icon-stats">
                                <i class="fa fa-plus bg-danger"></i>
                                <div class="bodystate">
                                    <h4>
                                    <?php
                                        $numbers_of_enrolment = $this->crud_model->enrol_history()->num_rows();
                                        echo $numbers_of_enrolment;
                                    ?>
                                    
                                    </h4>
                                    <span class="text-muted"><?php echo translate('enrolments');?></span>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!--/row -->
                
                <!-- /row -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">last 5 <?php echo translate('active_courses');?></h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                        <th><?php echo translate('title'); ?></th>
                                        <th><?php echo translate('category'); ?></th>
                                        <th><?php echo translate('lesson_and_section'); ?></th>
                                        <th><?php echo translate('enrolled_student'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    <?php 
                                        $sql = "select * from course where status = 'active' order by id desc limit 5";
                                        $query = $this->db->query($sql)->result_array();
                                        foreach ($query as $key => $value) {
                                            $enroll_history = $this->crud_model->enrol_history($value['id']);
                                            $sections = $this->crud_model->get_section('course', $value['id']);
                                            $lessons = $this->crud_model->get_lessons('course', $value['id']);  
                                       
                                    ?>

                                        <tr>
                                            <td><?php echo substr($value['title'], 0, 15);?></td>
                                            <td><?php echo $this->db->get_where('category', array('id' => $value['category_id']))->row()->name;?> </td>
                                            <td>
                                                <small class="text-muted"><?php echo '<b>'.translate('total_section').'</b>: '.$sections->num_rows(); ?></small><br>
                                                <small class="text-muted"><?php echo '<b>'.translate('total_lesson').'</b>: '.$lessons->num_rows(); ?></small><br>
                                            </td>
                                            <td><small class="text-muted"><?php echo '<b>'.translate('total_enrolment').'</b>: '.$enroll_history->num_rows(); ?></small> </td>
                                        </tr>
                                        <?php } ?>
                                       
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Last 5 <?php echo translate('pending_courses');?></h3>
                            <div class="table-responsive">
                            <table class="table">
                            <thead>
                                        <tr>
                                        <th><?php echo translate('title'); ?></th>
                                        <th><?php echo translate('category'); ?></th>
                                        <th><?php echo translate('lesson_and_section'); ?></th>
                                        <th><?php echo translate('enrolled_student'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php 
                                        $sql = "select * from course where status = 'pending' order by id desc limit 5";
                                        $query = $this->db->query($sql)->result_array();
                                        foreach ($query as $key => $value) {
                                            $enroll_history = $this->crud_model->enrol_history($value['id']);
                                            $sections = $this->crud_model->get_section('course', $value['id']);
                                            $lessons = $this->crud_model->get_lessons('course', $value['id']);  
                                       
                                    ?>

                                        <tr>
                                            <td><?php echo substr($value['title'], 0, 15);?></td>
                                            <td><?php echo $this->db->get_where('category', array('id' => $value['category_id']))->row()->name;?> </td>
                                            <td>
                                                <small class="text-muted"><?php echo '<b>'.translate('total_section').'</b>: '.$sections->num_rows(); ?></small><br>
                                                <small class="text-muted"><?php echo '<b>'.translate('total_lesson').'</b>: '.$lessons->num_rows(); ?></small><br>
                                            </td>
                                            <td><small class="text-muted"><?php echo '<b>'.translate('total_enrolment').'</b>: '.$enroll_history->num_rows(); ?></small> </td>
                                        </tr>
                                        <?php } ?>

                                       
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->