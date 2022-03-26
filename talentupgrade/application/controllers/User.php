<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');


		// Session information from the login page
        if (!$this->session->userdata('is_instructor')) {
            $logged_in_user_details = $this->user_model->get_all_user($this->session->userdata('user_id'))->row_array();
            $this->session->set_userdata('is_instructor', $logged_in_user_details['is_instructor']);
        }

		// Check if the route is required for public instructor
        $this->get_protected_routes($this->router->method);

        // This checks if users is trying to access intructor featuers 
        $this->instructor_authorization($this->router->method);

    }


    public function get_protected_routes($method) {
        // method that does not require a must for instructor
        $unprotected_routes = ['save_course_progress'];

        if (!in_array($method, $unprotected_routes)) {
            if (get_settings('allow_instructor') != 1){
                redirect(site_url('home'), 'refresh');
            }
        }
    }

    public function instructor_authorization($method) {
        // never have access to instructor features
        if ($this->session->userdata('is_instructor') != 1) {
            $unprotected_routes = ['application'];

            if (!in_array($method, $unprotected_routes)) {
                redirect(site_url('user/application'), 'refresh');
            }
        }
    }
	
	
	
    function application() {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('auth'), 'refresh');
        }
        // You need to check if applicaton has been submitted or now
        if (isset($_POST) && !empty($_POST)) {
            $this->user_model->post_instructor_application();
        }

        //is User Available
        $user_details = $this->user_model->get_all_user($this->session->userdata('user_id'));
        if ($user_details->num_rows() > 0) {
            $page_data['user_details'] = $user_details->row_array();
        }else{
            $this->session->set_flashdata('error_message', translate('user_not_found'));
            $this->load->view('back/index', $page_data);
        }
        $page_data['page_name'] = 'application';
        $page_data['page_title'] = translate('instructor_application');
        $this->load->view('back/index', $page_data);
    }
	
	
    /*
	function profile() {
        redirect(site_url('home/profile/user_profile'), 'refresh');
    }
	*/
	
	
/*>>>>>>> Function to manage messages >>>>>>>>>>>>*/
	function message($param1 = 'message_home', $param2 = '', $param3 = ''){
        if ($this->session->userdata('user_login') != true)
        redirect(site_url('auth'), 'refresh');
        if ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', translate('message_sent'));
            redirect(site_url('user/message/message_read/' . $message_thread_code), 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message($param2); //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', translate('message_sent'));
            redirect(site_url('user/message/message_read/' . $param2), 'refresh');
        }

        if ($param1 == 'message_read') {
            $page_data['current_message_thread_code'] = $param2; // $param2 = message_thread_code
            $this->crud_model->mark_thread_messages_read($param2);
        }

        $page_data['message_inner_page_name'] = $param1;
        $page_data['page_name']               = 'message';
        $page_data['page_title']              = translate('private_messaging');
        $this->load->view('back/index', $page_data);
    }
	
	
	 /*>>>>>>> Function to Manage Admin Profile >>>>>>>>>>>>*/
    function profile($param1 = null, $param2 = null, $param3 = null){
        if ($this->session->userdata('user_login') != true) redirect(base_url() . 'auth', 'refresh');
        if ($param1 == 'update') {
			$id = $this->input->post('param2');
            $this->user_model->edit_user($id);
            redirect(site_url('user/profile'), 'refresh');
        }
		
        if ($param1 == 'change_password') {
			$id = $this->input->post('param2');
            $this->user_model->change_password($id);
            redirect(site_url('user/profile'), 'refresh');
        }
        $profile['page_name']  	= 'profile';
        $profile['page_title'] 	= translate('manage_profile');
        $profile['select']  	= $this->user_model->selectallUserwithId();
        $this->load->view('back/index', $profile);
    }
	
	function get_country_state($country_id){
        $states = $this->db->get_where('states', array('country_id' => $country_id))->result_array();
            foreach($states as $key => $state){
                echo '<option value="'.$state['state_id'].'">'.$state['name'].'</option>';
            }
			
    }
	
	function get_state_city($state_id){
        $cities = $this->db->get_where('cities', array('state_id' => $state_id))->result_array();
            foreach($cities as $key => $city){
                echo '<option value="'.$city['city_id'].'">'.$city['name'].'</option>';
            }
    }

    public function index() {
        if ($this->session->userdata('user_login') == true) {
            $this->dashboard();
        }else {
            redirect(site_url('login'), 'refresh');
        }
    }

    public function dashboard() {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('auth'), 'refresh');
        }
		
		
        $dashboard_data['payouts'] = $this->crud_model->get_payouts($this->session->userdata('user_id'), 'user');
        $dashboard_data['total_pending_amount'] = $this->crud_model->get_total_pending_amount($this->session->userdata('user_id'));
        $dashboard_data['total_payout_amount'] = $this->crud_model->get_total_payout_amount($this->session->userdata('user_id'));
        $dashboard_data['requested_withdrawal_amount'] = $this->crud_model->get_requested_withdrawal_amount($this->session->userdata('user_id'));

        $dashboard_data['page_name'] = 'dashboard';
        $dashboard_data['page_title'] = translate('dashboard');
        $this->load->view('back/index.php', $dashboard_data);
    }

    /*>>>>>>> Function to add, edit and list all courses >>>>>>>>>>>>*/
    function courses($param1 = null, $param2 = null, $param3 = null){
	
        $page_info['selected_category_id']   = isset($_GET['category_id']) ? $_GET['category_id'] : "all";
        $page_info['selected_instructor_id'] = $this->session->userdata('user_id');
        $page_info['selected_price']         = isset($_GET['price']) ? $_GET['price'] : "all";
        $page_info['selected_status']        = isset($_GET['status']) ? $_GET['status'] : "all";
		
		if ($param1 == "add") {
            $course_id = $this->crud_model->add_course();
            redirect(site_url('user/edit_course/'.$course_id), 'refresh');

        }
		
        if ($param1 == "edit") {
            $this->crud_model->update_course($param2);
            redirect(site_url('user/courses'), 'refresh');

        }
		
        if ($param1 == "draft") {
            $this->is_the_course_belongs_to_current_instructor($param2);
            $this->crud_model->change_course_status('draft', $param2);
			$this->session->set_flashdata('flash_message', translate('course_successfully_saved_as_draft'));
			redirect(site_url('user/courses'), 'refresh');

        }
		
        if ($param1 == "publish") {
            $this->is_the_course_belongs_to_current_instructor($param2);
            $this->crud_model->change_course_status('pending', $param2);
			$this->session->set_flashdata('flash_message', translate('course_successfully_published'));
            redirect(site_url('user/courses'), 'refresh');

        }
		
        if ($param1 == "delete") {
            $this->is_drafted_course($param2);
            $this->crud_model->delete_course($param2);
           redirect(site_url('user/courses'), 'refresh');

        }
		
		
       $page_info['courses'] = $this->crud_model->filter_course_for_backend($page_info['selected_category_id'], $page_info['selected_instructor_id'], $page_info['selected_price'], $page_info['selected_status']);
		
		$page_info['page_name'] 			 = 'courses';
        $page_info['page_title'] 			 = translate('list_courses');
        $page_info['status_wise_courses']    = $this->crud_model->get_status_wise_courses();
        $page_info['instructors']            = $this->user_model->get_instructor()->result_array();
		$page_info['categories'] 			 = $this->crud_model->get_categories();
        $this->load->view('back/index', $page_info);
			
    }
	
	
	
	/*>>>>>>> Function to add new courses >>>>>>>>>>>>*/
    function new_course($param1 = null, $param2 = null, $param3 = null){
	
		
		$page_info['page_name'] = 'new_course';
        $page_info['page_title'] = translate('add_new_course');
		$page_info['categories'] = $this->crud_model->get_categories();
        $this->load->view('back/index', $page_info);
			
    }
	
	
	
	
	/*>>>>>>> Function to edit new course >>>>>>>>>>>>*/
    function edit_course($param1 = null, $param2 = null, $param3 = null){
	
		
		$this->is_drafted_course($param2);
		$page_info['page_name'] = 'edit_course';
		$page_info['course_id'] =  $param1;
        $page_info['page_title'] = translate('edit_course');
		$page_info['categories'] = $this->crud_model->get_categories();
        $this->load->view('back/index', $page_info);
			
    }
	
	

	
	
	/*>>>>>>> { Function to save instructor payment settings } >>>>>>>>>>>>*/
    function payment_settings($param1 = null, $param2 = null, $param3 = null){
	
		
        if ($param1 == "save") {
            
            $this->user_model->update_instructor_payment_settings($this->session->userdata('user_id'));
			
			$this->session->set_flashdata('flash_message', translate('payment_settings_saved_successfully'));
            redirect(site_url('user/payment_settings'), 'refresh');

        }
		
		
		$page_info['page_name'] = 'payment_settings';
		$page_info['course_id'] =  $param1;
        $page_info['page_title'] = translate('payment_settings');
        $this->load->view('back/index', $page_info);
			
    }
	
	
	
	
	
	/*>>>>>>> Function to check if course is a drafted course or not >>>>>>>>>>>>*/
	 private function is_drafted_course($course_id){
       
        $course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
        if ($course_details['status'] == 'draft') {
            $this->session->set_flashdata('error_message', translate('you_do_not_have_right_to_access_this_course'));
            redirect(site_url('user/courses'), 'refresh');
        }
    }
	




   /*>>>>>>> Function for payment settings >>>>>>>>>>>>*/
    public function payout_settings($param1 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'paypal_settings') {
            $this->user_model->update_instructor_paypal_settings($this->session->userdata('user_id'));
            $this->session->set_flashdata('flash_message', translate('updated'));
            redirect(site_url('user/payout_settings'), 'refresh');
        }
        if ($param1 == 'stripe_settings') {
            $this->user_model->update_instructor_stripe_settings($this->session->userdata('user_id'));
            $this->session->set_flashdata('flash_message', translate('updated'));
            redirect(site_url('user/payout_settings'), 'refresh');
        }

        $page_data['page_name'] = 'payment_settings';
        $page_data['page_title'] = translate('payout_settings');
        $this->load->view('back/index', $page_data);
    }
	
	
	

	
	/*>>>>>>> Function to calculate instructor sales information  >>>>>>>>>>>>*/
	
	// ends here
    
	
	
	
	
	
	/*>>>>>>> Function to preview your course  >>>>>>>>>>>>*/
    public function preview($course_id = '') {
        if ($this->session->userdata('user_login') != 1)
        redirect(site_url('auth'), 'refresh');

        $this->is_the_course_belongs_to_current_instructor($course_id);
        if ($course_id > 0) {
            $courses = $this->crud_model->get_course_by_id($course_id);
            if ($courses->num_rows() > 0) {
                $course_details = $courses->row_array();
                redirect(site_url('home/lesson/'.rawurlencode(slugify($course_details['title'])).'/'.$course_details['id']), 'refresh');
            }
        }
        redirect(site_url('user/courses'), 'refresh');
    }
	
	
	
	/*>>>>>>> Function to manage sections  >>>>>>>>>>>>*/
    public function sections($param1 = "", $param2 = "", $param3 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('auth'), 'refresh');
        }

        if ($param2 == 'add') {
            $this->is_the_course_belongs_to_current_instructor($param1);
            $this->crud_model->add_section($param1);
            $this->session->set_flashdata('flash_message', translate('section_has_been_added_successfully'));
        }
        elseif ($param2 == 'edit') {
            $this->is_the_course_belongs_to_current_instructor($param1, $param3, 'section');
            $this->crud_model->edit_section($param3);
            $this->session->set_flashdata('flash_message', translate('section_has_been_updated_successfully'));
        }
        elseif ($param2 == 'delete') {
            $this->is_the_course_belongs_to_current_instructor($param1, $param3, 'section');
            $this->crud_model->delete_section($param1, $param3);
            $this->session->set_flashdata('flash_message', translate('section_has_been_deleted_successfully'));
        }
        redirect(site_url('user/edit_course/'.$param1));
    }
	
	
	
	/*>>>>>>> Function to manage lessons  >>>>>>>>>>>>*/
    public function lessons($course_id = "", $param1 = "", $param2 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('auth'), 'refresh');
        }
        if ($param1 == 'add') {
            $this->is_the_course_belongs_to_current_instructor($course_id);
            $this->crud_model->add_lesson();
            $this->session->set_flashdata('flash_message', translate('lesson_has_been_added_successfully'));
            redirect('user/edit_course/'.$course_id);
        }
        elseif ($param1 == 'edit') {
            $this->is_the_course_belongs_to_current_instructor($course_id, $param2, 'lesson');
            $this->crud_model->edit_lesson($param2);
            $this->session->set_flashdata('flash_message', translate('lesson_has_been_updated_successfully'));
            redirect('user/edit_course/'.$course_id);
        }
        elseif ($param1 == 'delete') {
            $this->is_the_course_belongs_to_current_instructor($course_id, $param2, 'lesson');
            $this->crud_model->delete_lesson($param2);
            $this->session->set_flashdata('flash_message', translate('lesson_has_been_deleted_successfully'));
            redirect('user/edit_course/'.$course_id);
        }
        elseif ($param1 == 'filter') {
            redirect('user/lessons/'.$this->input->post('course_id'));
        }
        $page_data['page_name'] = 'lessons';
        $page_data['lessons'] = $this->crud_model->get_lessons('course', $course_id);
        $page_data['course_id'] = $course_id;
        $page_data['page_title'] = translate('lessons');
        $this->load->view('back/index', $page_data);
    }
	
	
	
	

    /*>>>>>>> Function to manage quizes  >>>>>>>>>>>>*/
    public function quizes($course_id = "", $action = "", $quiz_id = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('auth'), 'refresh');
        }

        if ($action == 'add') {
            $this->is_the_course_belongs_to_current_instructor($course_id);
            $this->crud_model->add_quiz($course_id);
            $this->session->set_flashdata('flash_message', translate('quiz_has_been_added_successfully'));
        }
        elseif ($action == 'edit') {
            $this->is_the_course_belongs_to_current_instructor($course_id, $quiz_id, 'quize');
            $this->crud_model->edit_quiz($quiz_id);
            $this->session->set_flashdata('flash_message', translate('quiz_has_been_updated_successfully'));
        }
        elseif ($action == 'delete') {
            $this->is_the_course_belongs_to_current_instructor($course_id, $quiz_id, 'quize');
            $this->crud_model->delete_lesson($quiz_id);
            $this->session->set_flashdata('flash_message', translate('quiz_has_been_deleted_successfully'));
        }
        redirect('user/edit_course/'.$course_id);
    }
	
	
	
	
	

    /*>>>>>>> Function to manage quizes question  >>>>>>>>>>>>*/
    public function quiz_questions($quiz_id = "", $action = "", $question_id = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('auth'), 'refresh');
        }
        $quiz_details = $this->crud_model->get_lessons('lesson', $quiz_id)->row_array();

        if ($action == 'add') {
            $this->is_the_course_belongs_to_current_instructor($quiz_details['course_id'], $quiz_id, 'quize');
            $response = $this->crud_model->add_quiz_questions($quiz_id);
            echo $response;
        }

        elseif ($action == 'edit') {
            if($this->db->get_where('question', array('id' => $question_id, 'quiz_id' => $quiz_id))->num_rows() <= 0){
                $this->session->set_flashdata('error_message', translate('you_do_not_have_right_to_access_this_quiz_question'));
                redirect(site_url('user/courses'), 'refresh');
            }

            $response = $this->crud_model->update_quiz_questions($question_id);
            echo $response;
        }

        elseif ($action == 'delete') {
            if($this->db->get_where('question', array('id' => $question_id, 'quiz_id' => $quiz_id))->num_rows() <= 0){
                $this->session->set_flashdata('error_message', translate('you_do_not_have_right_to_access_this_quiz_question'));
                redirect(site_url('user/courses'), 'refresh');
            }

            $response = $this->crud_model->delete_quiz_question($question_id);
            $this->session->set_flashdata('flash_message', translate('question_has_been_deleted'));
            redirect(site_url('user/edit_course/'.$quiz_details['course_id']));
        }
    }
	
	
	
	

	/*>>>>>>> Function to to display invoice information   >>>>>>>>>>>>*/
    function invoice($payment_id = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('auth'), 'refresh');
        }
        $page_data['page_name'] = 'invoice';
        $page_data['payment_details'] = $this->crud_model->get_payment_details_by_id($payment_id);
        $page_data['page_title'] = translate('invoice');
        $this->load->view('back/index', $page_data);
    }
	
	
	

  
   	/*>>>>>>> Function to manage widthrawal request  >>>>>>>>>>>>*/
    public function withdrawal($action = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('auth'), 'refresh');
        }

        if ($action == 'request') {
            $this->crud_model->add_withdrawal_request();
        }

        if ($action == 'delete') {
            $this->crud_model->delete_withdrawal_request();
        }

        redirect(site_url('user/payout_report'), 'refresh');
    }
	
	
   /*>>>>>>> { Function to get video details }  >>>>>>>>>>>>*/
    public function ajax_get_video_details() {
        $video_details = $this->video_model->getVideoDetails($_POST['video_url']);
        echo $video_details['duration'];
    }
	
	
	

    // this function is responsible for managing multiple choice question
    function manage_multiple_choices_options() {
        $page_data['number_of_options'] = $this->input->post('number_of_options');
        $this->load->view('back/user/manage_multiple_choices_options', $page_data);
    }





    /*>>>>>>> { This function checks if this course belongs to current logged in instructor }  >>>>>>>>>>>>*/
    function is_the_course_belongs_to_current_instructor($course_id, $id = null, $type = null) {
        $course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
        if ($course_details['user_id'] != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error_message', translate('you_do_not_have_right_to_access_this_course'));
            redirect(site_url('user/courses'), 'refresh');
        }

        if($type == 'section' && $this->db->get_where('section', array('id' => $id, 'course_id' => $course_id))->num_rows() <= 0){
            $this->session->set_flashdata('error_message', translate('you_do_not_have_right_to_access_this_section'));
            redirect(site_url('user/courses'), 'refresh');
        }
        if($type == 'lesson' && $this->db->get_where('lesson', array('id' => $id, 'course_id' => $course_id))->num_rows() <= 0){
            $this->session->set_flashdata('error_message', translate('you_do_not_have_right_to_access_this_lesson'));
            redirect(site_url('user/courses'), 'refresh');
        }
        if($type == 'quize' && $this->db->get_where('lesson', array('id' => $id, 'course_id' => $course_id))->num_rows() <= 0){
            $this->session->set_flashdata('error_message', translate('you_do_not_have_right_to_access_this_quize'));
            redirect(site_url('user/courses'), 'refresh');
        }

    }
	

     /*>>>>>>> { Mark this lesson as completed codes }  >>>>>>>>>>>>*/
    function save_course_progress() {
        $response = $this->crud_model->save_course_progress();
        echo $response;
    }
	
	
	 /*>>>>>>> { Function to manage payment settlement }  >>>>>>>>>>>>*/
    public function payment_settlement() {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('auth'), 'refresh');
        }
		
		
        $settlement_data['payouts'] = $this->crud_model->get_payouts($this->session->userdata('user_id'), 'user');
        $settlement_data['total_pending_amount'] = $this->crud_model->get_total_pending_amount($this->session->userdata('user_id'));
        $settlement_data['total_payout_amount'] = $this->crud_model->get_total_payout_amount($this->session->userdata('user_id'));
        $settlement_data['requested_withdrawal_amount'] = $this->crud_model->get_requested_withdrawal_amount($this->session->userdata('user_id'));

        $settlement_data['page_name'] = 'payment_settlement';
        $settlement_data['page_title'] = translate('payment_settlement');
        $this->load->view('back/index.php', $settlement_data);
    }
	
	
	
	
	 function rating($param1 = null, $param2 = null, $param3 = null){

            if($param1 == 'save'){

                $select 	=    $this->db->get_where('student_feedback', array('user_id' => $this->session->userdata('user_id')))->row()->user_id;
				$page_data['user_id']   = $this->session->userdata('user_id');
				$page_data['comment']   =    html_escape($this->input->post('comment'));
				
				if($select == "" || $select == NULL){
					
					$page_data['user_id']   = $this->session->userdata('user_id');
					$this->db->insert('student_feedback', $page_data);
					
					$this->db->where('user_id', $this->session->userdata('user_id'));
					$this->db->update('student_feedback', $page_data);
				}
				
				if($select != "" || $select != NULL){

					$this->db->where('user_id', $this->session->userdata('user_id'));
					$this->db->update('student_feedback', $page_data);
				}
				
                $this->session->set_flashdata('flash_message', translate('feedback_submitted_successfully'));
                redirect(base_url() . 'user/rating', 'refresh');
            }


            $page_data['page_name']     = 'rating';
            $page_data['page_title']    = translate('submit_feedback');
            $this->load->view('back/index', $page_data);

        }
	
	
	
	
	
	
	
	
	
	
}
