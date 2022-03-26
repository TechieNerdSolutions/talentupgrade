<?php if (!defined('BASEPATH'))exit('No direct script access allowed');


class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
    }

    function index(){
        if($this->session->userdata('admin_login') != true) redirect(base_url(). 'auth/index', 'refresh');
        if($this->session->userdata('admin_login') == true) redirect(base_url(). 'admin/dashboard', 'refresh');
    }


    //>>>>>> Admin Welcome Dashboard Function  <<<<<<<<
    function dashboard(){
        if($this->session->userdata('admin_login') != true) redirect(base_url(). 'auth/index', 'refresh');
        $page_info['page_name'] = 'dashboard';
        $page_info['page_title'] = translate('welcome_dashbaord');
        $this->load->view('back/index', $page_info);
    }




    function settings($param1 = "", $param2 = "", $param3 = ""){

        if($param1 == "general"){


            $data = array();

            $inputs = $this->input->post();

            foreach($inputs as $name => $value){

                $page_data['description'] = $value;

                $this->db->where('type', $name);

                $this->db->update('settings', $page_data);
            }

            $this->session->set_flashdata('flash_message', translate('successfully_updated'));
            redirect(base_url(). 'admin/settings', 'refresh');


        }

        if($param1 == "edit_phrase"){

            $page_info['translate_language'] = $param2;

        }

        
        if($param1 == "paypal"){
            $updatePaypal = $this->crud_model->update_paypal_settings();
            if($updatePaypal) { 
                $this->session->set_flashdata('flash_message', translate('paypal_settings_updated'));
                redirect(base_url(). 'admin/settings', 'refresh');
            }
    
            else { 
                $this->session->set_flashdata('error_message', translate('paypal_not_updated'));
                redirect(base_url(). 'admin/settings', 'refresh');
            }

        }


        if($param1 == "stripe"){
            $updateStripe = $this->crud_model->update_stripe_settings();
            if($updateStripe) { 
                $this->session->set_flashdata('flash_message', translate('stripe_settings_updated'));
                redirect(base_url(). 'admin/settings', 'refresh');
            }
    
            else { 
                $this->session->set_flashdata('error_message', translate('stripe_not_updated'));
                redirect(base_url(). 'admin/settings', 'refresh');
            }

        }


        if($param1 == "website_settings"){

            $data = array();

            $inputs = $this->input->post();

            foreach($inputs as $name => $value){

                $page_data['value'] = $value;

                $this->db->where('key', $name);

                $this->db->update('frontend_settings', $page_data);
            }

            $this->session->set_flashdata('flash_message', translate('successfully_updated'));
            redirect(base_url(). 'admin/settings', 'refresh');

        }



        if($param1 == "system_image"){
            $uploadSystemImage = $this->crud_model->update_light_logo();
            if($updateStripe) { 
                $this->session->set_flashdata('flash_message', translate('logo_uploaded_successfully'));
                redirect(base_url(). 'admin/settings', 'refresh');
            }
    
            else { 
                $this->session->set_flashdata('error_message', translate('logo_not_uploaded_successfully'));
                redirect(base_url(). 'admin/settings', 'refresh');
            }

        }



        if($param1 == "favicon"){
            $uploadFaviconLogo = $this->crud_model->update_favicon();
            if($uploadFaviconLogo) { 
                $this->session->set_flashdata('flash_message', translate('favicon_uploaded_successfully'));
                redirect(base_url(). 'admin/settings', 'refresh');
            }
    
            else { 
                $this->session->set_flashdata('error_message', translate('favicon_not_uploaded_successfully'));
                redirect(base_url(). 'admin/settings', 'refresh');
            }

        }


        if($param1 == "banner_image"){
            $uploadFrontendBanner = $this->crud_model->update_frontend_banner();
            if($uploadFrontendBanner) { 
                $this->session->set_flashdata('flash_message', translate('banner_uploaded_successfully'));
                redirect(base_url(). 'admin/settings', 'refresh');
            }
    
            else { 
                $this->session->set_flashdata('error_message', translate('banner_not_uploaded_successfully'));
                redirect(base_url(). 'admin/settings', 'refresh');
            }

        }


        $page_info['page_name'] = 'settings';
        $page_info['page_title'] = translate('system_settings');
        $this->load->view('back/index', $page_info);    
    }



    function language($param1 = "", $param2 = "", $param3 = ""){

        if($param1 == "add_language"){

            $language = $this->language_model->createNewLanguage();
            if($language) { 
                $this->session->set_flashdata('flash_message', translate('language_added_successfully'));
                redirect(base_url(). 'admin/settings', 'refresh');
            }
            else { 
                $this->session->set_flashdata('error_message', translate('language_not_added'));
                redirect(base_url(). 'admin/settings', 'refresh');
            }


        }



        if($param1 == "add_phrase"){

            $language = $this->language_model->createNewLanguagePhrase();
            if($language) { 
                $this->session->set_flashdata('flash_message', translate('phrase_added_successfully'));
                redirect(base_url(). 'admin/settings', 'refresh');
            }
            else { 
                $this->session->set_flashdata('error_message', translate('phrase_not_added'));
                redirect(base_url(). 'admin/settings', 'refresh');
            }


        }


        if($param1 == "delete_language"){

            $language = $this->language_model->deleteAlreadyAddedLanguage($param2);
            if($language) { 
                $this->session->set_flashdata('flash_message', translate('deleted_successfully'));
                redirect(base_url(). 'admin/settings', 'refresh');
            }
            else { 
                $this->session->set_flashdata('error_message', translate('delete_not_successful'));
                redirect(base_url(). 'admin/settings', 'refresh');
            }


        }


    }



    function updatePhraseWithAjax(){

        $checker['phrase_id']   =   $this->input->post('phraseId');
        $updater[$this->input->post('currentEditingLanguage')]  =   $this->input->post('updatedValue');

        $this->db->where('phrase_id', $checker['phrase_id'] );
        $this->db->update('language', $updater);

        echo $checker['phrase_id']. ' '. $this->input->post('currentEditingLanguage'). ' '. $this->input->post('updatedValue');

    }


    function profile($param1 = "", $param2 = "", $param3 = ""){


        if($param1 == "update"){
            $id = $this->input->post('param2');
            $updateAdminInfo = $this->user_model->edit_profile($id);
            if($updateAdminInfo) { 
                $this->session->set_flashdata('flash_message', translate('updated_successfully'));
                redirect(base_url(). 'admin/profile', 'refresh');
            }
    
            else { 
                $this->session->set_flashdata('error_message', translate('not_updated_successfully'));
                redirect(base_url(). 'admin/profile', 'refresh');
            }

        }


        if($param1 == 'password'){
            $id = $this->input->post('param2');
            $this->user_model->change_password($id);
            redirect(base_url(). 'admin/profile', 'refresh');
        }

        $page_data['select'] = $this->user_model->selectUserWithId();
        $page_data['page_name'] = 'profile';
        $page_data['page_title'] = translate('manage_profile');
        $this->load->view('back/index', $page_data);

    }




    function add_categories($param1 = "", $param2 = "", $param3 = ""){

        if($param1 == 'select'){
            $page_data['edit_category'] = $param2;
        }

        if($param1 == 'add'){
            $response = $this->crud_model->add_category();
            if($response){
                $this->session->set_flashdata('flash_message', translate('data_saved_successfully'));
            }else{
                $this->session->set_flashdata('error_message', translate('data_not_saved_successfully'));  
            }
            redirect(base_url(). 'admin/categories', 'refresh');
        }


        if($param1 == 'edit'){
            $response = $this->crud_model->edit_category($param2);
            if($response){
                $this->session->set_flashdata('flash_message', translate('data_editted_successfully'));
            }else{
                $this->session->set_flashdata('error_message', translate('data_not_editted_successfully'));  
            }
            redirect(base_url(). 'admin/categories', 'refresh');
        }

        $page_data['page_name'] = 'add_categories';
        $page_data['page_title'] = translate('add_categories');
        $page_data['categories'] = $this->crud_model->get_categories()->result_array();
        $this->load->view('back/index', $page_data);   

    }




    function categories($param1 = "", $param2 = "", $param3 = ""){

        if($param1 == 'delete'){
            $response = $this->crud_model->delete_category($param2);
            if($response){
                $this->session->set_flashdata('flash_message', translate('data_deleted_successfully'));
            }else{
                $this->session->set_flashdata('error_message', translate('data_not_deleted_successfully'));  
            }
            redirect(base_url(). 'admin/categories', 'refresh');
        }
        $page_data['page_name'] = 'categories';
        $page_data['page_title'] = translate('list_categories');
        $page_data['categories'] = $this->crud_model->get_categories($param2);
        $this->load->view('back/index', $page_data);   
    }


    function student($param1 = "", $param2 = "", $param3 = ""){

        if($param1 == 'add'){
            $response = $this->user_model->add_user();
            if($response){
                $this->session->set_flashdata('flash_message', translate('data_saved_successfully'));
            }else{
                $this->session->set_flashdata('error_message', translate('data_not_saved_successfully'));  
            }
            redirect(base_url(). 'admin/student', 'refresh');
        }


        if($param1 == 'edit'){
            $response = $this->user_model->edit_user($param2);
            if($response){
                $this->session->set_flashdata('flash_message', translate('data_updated_successfully'));
            }else{
                $this->session->set_flashdata('error_message', translate('data_not_updated_successfully'));  
            }
            redirect(base_url(). 'admin/student', 'refresh');
        }


        if($param1 == 'delete'){
            $response = $this->user_model->delete_user($param2);
            if($response){
                $this->session->set_flashdata('flash_message', translate('data_deleted_successfully'));
            }else{
                $this->session->set_flashdata('error_message', translate('data_not_deleted_successfully'));  
            }
            redirect(base_url(). 'admin/student', 'refresh');
        }

        $page_data['page_name'] = 'student';
        $page_data['page_title'] = translate('manage_student');
        $page_data['users']= $this->user_model->get_user($param2);
        $this->load->view('back/index', $page_data);  
    }



    function enrol_student ($param1 = "", $param2 = "", $param3 = ""){
       
        if($param1 == 'enrol'){
            $response = $this->crud_model->enrol_a_student_manually();
            if($response){
                $this->session->set_flashdata('flash_message', translate('student_enrolled_successfully'));
            }else{
                $this->session->set_flashdata('error_message', translate('student_has_been_enrolled_to_this_course'));  
            }
            redirect(base_url(). 'admin/enrol_student', 'refresh');
        }   


        if($param1 == 'delete'){
            $response = $this->crud_model->delete_enrol_history($param2);
            if($response){
                $this->session->set_flashdata('flash_message', translate('deleted_successfully'));
            }else{
                $this->session->set_flashdata('error_message', translate('not_deleted_successfully'));  
            }
            redirect(base_url(). 'admin/enrol_student', 'refresh');
        }  
       
        $page_data['page_name'] = 'student_enrolment';
        $page_data['page_title'] = translate('student_enrolment');
        $page_data['enrol_history']= $this->crud_model->enrol_history();
        $this->load->view('back/index', $page_data); 
    }




	/*>>>>>>> Function to add, edit and list all courses >>>>>>>>>>>>*/
    function courses($param1 = null, $param2 = null, $param3 = null){
	
      

        $data['selected_category_id'] 	        = isset($_GET['category_id']) ? $_GET['category_id'] : "all";
        $data['selected_instructor_id'] 		= isset($_GET['instructor_id']) ? $_GET['instructor_id'] : "all";
        $data['selected_price'] 			    = isset($_GET['price']) ? $_GET['price'] : "all";
        $data['selected_status']               = isset($_GET['status']) ? $_GET['status'] : "all";
        
		if ($param1 == "add") {
            $course_id = $this->crud_model->add_course();
            redirect(site_url('admin/edit_course/'.$course_id), 'refresh');

        }

        if ($param1 == "delete") {
            $response = $this->crud_model->delete_course($param2);
            $this->session->set_flashdata('flash_message', translate('deleted_successfully'));
            redirect(site_url('admin/courses/'), 'refresh');

        }

        if ($param1 == "edit") {
            $response = $this->crud_model->update_courses($param2);
            $this->session->set_flashdata('flash_message', translate('deleted_successfully'));
            redirect(site_url('admin/courses/'), 'refresh');

        }
		
        $data['courses'] = $this->crud_model->filter_course_for_backend($data['selected_category_id'], $data['selected_instructor_id'], $data['selected_price'], $data['selected_status']);
		
		$data['page_name']              = 'courses';
        $data['page_title']             = translate('list_courses');
        $data['status_wise_courses']    = $this->crud_model->get_status_wise_courses();
        $data['instructors']            = $this->user_model->get_instructor()->result_array();
		$data['categories']             = $this->crud_model->get_categories();
        $this->load->view('back/index', $data);
			
    }


    function new_course($param1 = "", $param2 = "", $param3 = ""){


        $page_data['page_name']     = 'new_course';
        $page_data['page_title']    = translate('create_course');
        $page_data['categories']    = $this->crud_model->get_categories();
        $this->load->view('back/index', $page_data); 
    }


    
    function edit_course($param1 = "", $param2 = "", $param3 = ""){

        $this->is_drafted_course($param2);

        $page_data['page_name']     = 'edit_course';
        $page_data['course_id']     = $param1;
        $page_data['page_title']    = translate('edit_course');
        $page_data['categories']    = $this->crud_model->get_categories();
        $this->load->view('back/index', $page_data); 
    }


    function is_drafted_course($course_id){


        $course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
        if($course_details['status'] == 'draft'){

            $this->session->set_flashdata('error_message', translate('you_do_not_have_right_to_access_this_Course'));  
            redirect(base_url(). 'admin/courses/' . $course_id, 'refresh');
        }
    }


    function sections($param1 = null, $param2 = null, $param3 = null){

		if ($param2 == "add") {
            $this->crud_model->add_section($param1);
            $this->session->set_flashdata('flash_message', translate('section_added_successfully'));  
        }elseif($param2 == 'edit'){
            $this->crud_model->edit_section($param3);
            $this->session->set_flashdata('flash_message', translate('data_edited_successfully'));  
        }elseif($param2 == 'delete'){
            $this->crud_model->delete_section($param1, $param3);
            $this->session->set_flashdata('flash_message', translate('data_deleted_successfully'));  
        }
        redirect(site_url('admin/edit_course/'.$param1), 'refresh');

    }


    function ajax_get_video_details() {

        $video_details = $this->video_model->getVideoDetails($_POST['video_url']);
        echo $video_details['duration'];
    }

    

    function lessons($course_id = null, $param1 = null, $param2 = null){

        if($param1 == 'add'){
            $this->crud_model->add_lesson();
            $this->session->set_flashdata('flash_message', translate('lesson_added_successfully'));  
            redirect(site_url('admin/edit_course/'.$course_id), 'refresh');
        }

        elseif($param1 == 'edit'){
            $this->crud_model->edit_lesson($param2);
            $this->session->set_flashdata('flash_message', translate('lesson_edited_successfully'));  
            redirect(site_url('admin/edit_course/'.$course_id), 'refresh');
        }

        elseif($param1 == 'delete'){
            $this->crud_model->delete_lesson($param2);
            $this->session->set_flashdata('flash_message', translate('lesson_deleted_successfully'));  
            redirect(site_url('admin/edit_course/'.$course_id), 'refresh');
        }


    }


    function quizes($course_id = null, $action = null, $quiz_id = null){

        if($action == 'add'){
            $this->crud_model->add_quiz($course_id);
            $this->session->set_flashdata('flash_message', translate('quiz_added_successfully'));  
        }

        elseif($action == 'edit'){
            $this->crud_model->edit_quiz($quiz_id);
            $this->session->set_flashdata('flash_message', translate('quiz_edited_successfully'));  
        }

        elseif($action == 'delete'){
            $this->crud_model->delete_section($course_id, $quiz_id);
            $this->session->set_flashdata('flash_message', translate('quiz_deleted_successfully'));  
            
        }
        redirect(site_url('admin/edit_course/'.$course_id), 'refresh');


    }


    function manage_multiple_choices_options() {
        $page_data['number_of_options'] = $this->input->post('number_of_options');
        $this->load->view('back/admin/manage_multiple_choices_options', $page_data);
    }


    public function quiz_questions($quiz_id = null, $action = null, $question_id = null) {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $quiz_details = $this->crud_model->get_lessons('lesson', $quiz_id)->row_array();

        if ($action == 'add') {
            $response = $this->crud_model->add_quiz_questions($quiz_id);
            echo $response;
        }

        elseif ($action == 'edit') {
            $response = $this->crud_model->update_quiz_questions($question_id);
            echo $response;
        }

        elseif ($action == 'delete') {
            $response = $this->crud_model->delete_quiz_question($question_id);
            $this->session->set_flashdata('flash_message', translate('question_has_been_deleted'));
			redirect(site_url('admin/edit_course/'.$quiz_details['course_id']));
        }
    }




    function instructor($param1 = "", $param2 = "", $param3 = ""){

        if($param1 == 'add'){
            $response = $this->user_model->add_user(true);
            if($response){
                $this->session->set_flashdata('flash_message', translate('data_saved_successfully'));
            }else{
                $this->session->set_flashdata('error_message', translate('data_not_saved_successfully'));  
            }
            redirect(base_url(). 'admin/instructor', 'refresh');
        }


        if($param1 == 'edit'){
            $response = $this->user_model->edit_user($param2);
            if($response){
                $this->session->set_flashdata('flash_message', translate('data_updated_successfully'));
            }else{
                $this->session->set_flashdata('error_message', translate('data_not_updated_successfully'));  
            }
            redirect(base_url(). 'admin/instructor', 'refresh');
        }


        if($param1 == 'delete'){
            $response = $this->user_model->delete_user($param2);
            if($response){
                $this->session->set_flashdata('flash_message', translate('data_deleted_successfully'));
            }else{
                $this->session->set_flashdata('error_message', translate('data_not_deleted_successfully'));  
            }
            redirect(base_url(). 'admin/instructor', 'refresh');
        }

        $page_data['page_name'] = 'instructor';
        $page_data['page_title'] = translate('manage_instructor');
        $page_data['instructors']= $this->user_model->get_instructor()->result_array();
        $this->load->view('back/index', $page_data);  
    }






    function instructor_payment($param1 = "", $param2 = "", $param3 = ""){

        $page_data['timestamp_start'] = strtotime(date('m/01/Y'));
        $page_data['timestamp_end'] = strtotime(date('m/t/Y'));


        $page_data['completed_payouts'] = $this->crud_model->get_completed_payouts_by_date_range($page_data['timestamp_start'], $page_data['timestamp_end']);
        $page_data['pending_payouts'] = $this->crud_model->get_pending_payouts();
        $page_data['page_name'] = 'instructor_payment';
        $page_data['page_title'] = translate('instructor_payment');
        $this->load->view('back/index', $page_data);  
    }



    function paypal_checkout_for_instructor_revenue(){

        $page_data['amount_to_pay']         =   $this->input->post('amount_to_pay');
        $page_data['payout_id']             =   $this->input->post('payout_id');
        $page_data['instructor_name']       =   $this->input->post('instructor_name');
        $page_data['production_client_id']  =   $this->input->post('production_client_id');

        // check if payout amount is valid
        $payout_details = $this->crud_model->get_payouts($page_data['payout_id'], 'payout')->row_array();
        if($payout_details['amount'] == $page_data['amount_to_pay'] && $payout_details['status'] == 0){
            $this->load->view('back/admin/paypal_checkout_for_instructor_revenue', $page_data);
        }else{
            $this->session->set_flashdata('error_message', translate('invalid_payout_data'));  
            redirect(base_url(). 'admin/instructor_payment', 'refresh');
        }
    }



    function paypal_payment($payout_id = "", $paypalPaymentID = "", $paypalPaymentToken = "", $paypalPayerID = ""){

        $payout_details = $this->crud_model->get_payouts($payout_id, 'payout')->row_array();
        $intructor_id = $payout_details['user_id'];
        $intructor_data = $this->db->get_where('users', array('id' => $intructor_id))->row_array();
        $paypal_keys = json_decode($intructor_data['paypal_keys'], true);
        $production_client_id = $paypal_keys[0]['production_client_id'];
        $production_secret_key = $paypal_keys[0]['production_secret_key'];

        //Let us check paypal payment status...
        $status = $this->payment_model->paypal_payment($paypalPaymentID, $paypalPaymentToken, $paypalPayerID, $production_client_id, $production_secret_key);
        if(!$status){
            $this->session->set_flashdata('error_message', translate('an_error_occur_during_payment'));  
            redirect(base_url(). 'admin/instructor_payment', 'refresh');
        }

        $this->crud_model->update_payout_status($payout_id, 'paypal');
        $this->session->set_flashdata('flash_message', translate('payout_successfully_updated'));  
        redirect(base_url(). 'admin/instructor_payment', 'refresh');

    }


    function stripe_checkout_for_instructor_revenue(){
        $page_data['amount_to_pay']         =   $this->input->post('amount_to_pay');
        $page_data['payout_id']             =   $this->input->post('payout_id');
        $page_data['instructor_name']       =   $this->input->post('instructor_name');
        $page_data['public_live_key']       =   $this->input->post('public_live_key');
        $page_data['secret_live_key']       =   $this->input->post('secret_live_key');

        // check if payout amount is valid
        $payout_details = $this->crud_model->get_payouts($page_data['payout_id'], 'payout')->row_array();
        if($payout_details['amount'] == $page_data['amount_to_pay'] && $payout_details['status'] == 0){
            $this->load->view('back/admin/stripe_checkout_for_instructor_revenue', $page_data);
        }else{
            $this->session->set_flashdata('error_message', translate('invalid_payout_data'));  
            redirect(base_url(). 'admin/instructor_payment', 'refresh');
        }

    }


    public function stripe_payment($payout_id = ""){
        
        $token_id = $this->input->post('stripeToken');
        $payout_details = $this->crud_model->get_payouts($payout_id, 'payout')->row_array();
        $intructor_id = $payout_details['user_id'];
        $intructor_data = $this->db->get_where('users', array('id' => $intructor_id))->row_array();
        $stripe_keys = json_decode($intructor_data['stripe_keys'], true);
        
        // $production_client_id = $paypal_keys[0]['production_client_id'];
        // $production_secret_key = $paypal_keys[0]['production_secret_key'];

        //Let us check paypal payment status...
        $status = $this->payment_model->stripe_payment($token_id, $this->session->userdata('user_id'), $payout_details['amount'], $stripe_keys[0]['secret_live_key']);
        if(!$status){
            $this->session->set_flashdata('error_message', translate('an_error_occur_during_payment'));  
            redirect(base_url(). 'admin/instructor_payment', 'refresh');
        }

        $this->crud_model->update_payout_status($payout_id, 'stripe');
        $this->session->set_flashdata('flash_message', translate('payout_successfully_updated'));  
        redirect(base_url(). 'admin/instructor_payment', 'refresh');
    }


    function instructor_settings($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'save'){
            $this->crud_model->instructorApplicationAndRevenueSettings();
            $this->session->set_flashdata('flash_message', translate('settings_updated_successfully'));  
            redirect(base_url(). 'admin/instructor_settings', 'refresh');

        }

        $page_data['page_name'] = 'instructor_settings';
        $page_data['page_title'] = translate('instructor_settings');
        $this->load->view('back/index', $page_data);  
    }


    function pending_instructor($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'approve' || $param1 == 'delete'){
           $this->user_model->update_status_of_applications($param1, $param2);
        }

        $page_data['approved_applications'] = $this->user_model->get_approved_applications();
        $page_data['pending_applications']  = $this->user_model->get_pending_applications();
        $page_data['page_name'] = 'pending_instructor';
        $page_data['page_title'] = translate('pending_instructor');
        $this->load->view('back/index', $page_data); 
    }


    function notification($param1 = null, $param2 = null, $param3 = null){

        if($param1 == 'update'){
            $this->crud_model->updatePromotionalMessageSettings();
            $this->session->set_flashdata('flash_message', translate('settings_updated_successfully'));  
            redirect(base_url(). 'admin/notification', 'refresh');
        }

        
        $page_data['page_name'] = 'notification';
        $page_data['page_title'] = translate('promotion_settings');
        $this->load->view('back/index', $page_data); 
    }



    function message($param1 = "message_home", $param2 = null, $param3 = null){

        if($param1 == 'send_new'){
            
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', translate('message_sent_successfully'));  
            redirect(base_url(). 'admin/message/message_read/' . $message_thread_code, 'refresh');
        }

        if($param1 == 'send_reply'){
            
            $this->crud_model->send_reply_message($param2); // $param2 = $message_thread_code
            $this->session->set_flashdata('flash_message', translate('message_sent_successfully'));  
            redirect(base_url(). 'admin/message/message_read' . $param2, 'refresh');
        }

        if($param1 == 'message_read'){
            
            $page_data['current_message_thread_code']   = $param2; // $param2 = $message_thread_code
            $this->crud_model->mark_thread_messages_read($param2);
           
        }

        $page_data['message_inner_page_name'] = $param1;
        $page_data['page_name'] = 'message';
        $page_data['page_title'] = translate('chat_app');
        $this->load->view('back/index', $page_data); 
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









}