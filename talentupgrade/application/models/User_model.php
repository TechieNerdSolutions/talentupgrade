<?php if (!defined('BASEPATH'))exit('No direct script access allowed');


class User_model extends CI_Model {

    function __construct() {
        parent::__construct();

    }



    //>>>>>>Function to check for email duplication  <<<<<<<<
    function check_duplication($action = "", $email = "", $user_id = ""){
        $duplicate_email_check = $this->db->get_where('users', array('email' => $email));
        if($action == 'on_create'){
            if($duplicate_email_check->num_rows() > 0 ) {
                return false;
            }else{
                return true;
            }
        }elseif($action == 'on_update'){
            if($duplicate_email_check->num_rows() > 0 ) {
                if($duplicate_email_check->row()->id == $user_id){
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
            
        }

    }


    //>>>>>>Function to register new account  <<<<<<<<
    function register_user($data){
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }


    function get_user($user_id = 0){

        if($user_id > 0){
            $this->db->where('id', $user_id);
        }
        $this->db->where('role_id', 2);
        return $this->db->get('users');
    }



    function get_user_image_url($user_id){

        if(file_exists('uploads/user_image/'. $user_id. '.jpg'))
            return base_url(). 'uploads/user_image/'. $user_id. '.jpg';
        else
        return base_url(). 'uploads/user_image/default_image.png';

    }


    function get_all_users($user_id = 0){

        if($user_id > 0){
            $this->db->where('id', $user_id);
        }
        return $this->db->get('users');

    }

    function get_instructor($id = 0){
        if($id > 0){
            return $this->db->get_where('users', array('id' => $id, 'is_instructor' => 1));
        }else{
            return $this->db->get_where('users', array('is_instructor' => 1));
        }

    }



    function get_admin_details(){

        return $this->db->get_where('users', array('role_id' => 1));

    }

    function selectUserWithId(){

        $sql = $this->db->get_where('users', array('id' => $this->session->userdata('user_id')))->result_array();
        return $sql;

    }


    function add_user($is_instructor = false){
        $validity = $this->check_duplication('on_create', $this->input->post('email'));
        if($validity == false){
            $this->session->set_flashdata('error_message', translate('email_already_exist'));
        }else{
            $data['first_name'] = html_escape($this->input->post('first_name'));
            $data['last_name']  = html_escape($this->input->post('last_name')); 
            $data['email']      = html_escape($this->input->post('email'));
            $data['password']   = sha1($this->input->post('password'));  
            $data['biography']  = html_escape($this->input->post('biography'));
            $data['role_id']    = 2;
            $data['date_added'] = strtotime(date("Y-m-d H:i:s"));
            $data['wishlist']   = json_encode(array());
            $data['status']     = 1;
            $social_link['facebook']    = html_escape($this->input->post('facebook_link'));
            $social_link['twitter']     = html_escape($this->input->post('twitter_link'));
            $social_link['linkedin']    = html_escape($this->input->post('linkedin_link'));
            $data['social_links ']      = json_encode($social_link);
            $data['watch_history']      = json_encode(array());

             //>>>>>> Adding paypal keys  <<<<<<<<
             $paypal_info = array();
             $paypal['production_client_id']    = html_escape($this->input->post('paypal_client_id'));
             $paypal['production_secret_key']   = html_escape($this->input->post('paypal_secret_key'));
             array_push($paypal_info, $paypal);
             $data['paypal_keys']               = json_encode($paypal_info);

             //>>>>>> Adding stripe keys  <<<<<<<<
             $stripe_info = array();
             $stripe['public_live_key'] = html_escape($this->input->post('stripe_public_key'));
             $stripe['secret_live_key'] = html_escape($this->input->post('stripe_secret_key'));
             array_push($stripe_info, $stripe);
             $data['stripe_keys ']      = json_encode($stripe_info);


            if($is_instructor){
                $data['is_instructor']  = 1;
            }

                $sql = "select * from users order by id desc limit 1";
                $return_query = $this->db->query($sql)->row()->id + 1;
                $data['id'] = $return_query;

            if($this->db->insert('users', $data)){
                $user_id = $this->db->insert_id();
                $this->upload_user_image($user_id);
                return true;
            }
            else{ 
                return false;
            }
        }


    }



    function edit_user($user_id = ""){
        $validity = $this->check_duplication('on_update', $this->input->post('email'), $user_id);
        if($validity){
            $data['first_name'] = html_escape($this->input->post('first_name'));
            $data['last_name']  = html_escape($this->input->post('last_name'));

            if(isset($_POST['email'])){
                $data['email']  = html_escape($this->input->post('email'));
            }
            $social_links['facebook']   = html_escape($this->input->post('facebook_link'));
            $social_links['twitter']    = html_escape($this->input->post('twitter_link'));
            $social_links['linkedin']   = html_escape($this->input->post('linkedin_link'));
            $data['social_links'] = json_encode($social_links);
            $data['biography']  = html_escape($this->input->post('biography'));
            $data['title']  = html_escape($this->input->post('title'));
            $data['last_modified']  = strtotime(date("Y-m-d H:i:s"));


             //>>>>>> Updating paypal keys  <<<<<<<<
             $paypal_info = array();
             $paypal['production_client_id']    = html_escape($this->input->post('paypal_client_id'));
             $paypal['production_secret_key']   = html_escape($this->input->post('paypal_secret_key'));
             array_push($paypal_info, $paypal);
             $data['paypal_keys']               = json_encode($paypal_info);

             //>>>>>> Updating stripe keys  <<<<<<<<
             $stripe_info = array();
             $stripe['public_live_key'] = html_escape($this->input->post('stripe_public_key'));
             $stripe['secret_live_key'] = html_escape($this->input->post('stripe_secret_key'));
             array_push($stripe_info, $stripe);
             $data['stripe_keys ']      = json_encode($stripe_info);


            $this->db->where('id', $user_id);
           if($this->db->update('users', $data))
           
            $this->upload_user_image($user_id);
            return true;


        }else{
            return false;
        }
        $this->upload_user_image($user_id);
    }


    function delete_user($user_id = ""){
        $this->db->where('id', $user_id);
        if ($this->db->delete('users'))
        return true;
        else 
        return false;
    }


    function edit_profile($user_id){

        $validity = $this->check_duplication('on_update', $this->input->post('email'), $user_id);
        if($validity){
            $data['first_name'] = html_escape($this->input->post('first_name'));
            $data['last_name']  = html_escape($this->input->post('last_name'));

            if(isset($_POST['email'])){
                $data['email']  = html_escape($this->input->post('email'));
            }
            $social_links['facebook']   = html_escape($this->input->post('facebook'));
            $social_links['twitter']    = html_escape($this->input->post('twitter'));
            $social_links['linkedin']   = html_escape($this->input->post('linkedin'));
            $data['social_links'] = json_encode($social_links);
            $data['biography']  = html_escape($this->input->post('biography'));
            $data['title']  = html_escape($this->input->post('title'));
            $data['last_modified']  = strtotime(date("Y-m-d H:i:s"));


            //>>>>>> Adding paypal keys  <<<<<<<<
            $paypal_info = array();
            $paypal['production_client_id'] = "";
            array_push($paypal_info, $paypal);
            $data['paypal_keys'] = json_encode($paypal_info);
            
            //>>>>>> Adding stripe keys  <<<<<<<<
            $stripe_info = array();
            $stripe_keys = array(
                'public_live_key' => "",
                'secret_live_key' => ""
            );
            array_push($stripe_info, $stripe_keys);
            $data['stripe_keys'] = json_encode($stripe_info);


            $this->db->where('id', $user_id);
           if($this->db->update('users', $data))
           
            $this->upload_user_image($user_id);
            return true;


        }else{
            return false;
        }
        $this->upload_user_image($user_id);

    }



    function upload_user_image($user_id){
        if(isset($_FILES['user_image']) && $_FILES['user_image']['tmp_name'] != ""){
            move_uploaded_file($_FILES['user_image']['tmp_name'], 'uploads/user_image/' . $user_id. '.jpg');
            $this->session->set_flashdata('flash_message', translate('user_updated_successfully'));

        }
    }



    function change_password($user_id){
        $data = array();
        if(!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])){
            $user_detail = $this->
            rs($user_id)->row_array();
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');

            if($user_detail['password'] == sha1($current_password) && $new_password == $confirm_password){
                $data['password'] = sha1($new_password);
            }else{
                $this->session->set_flashdata('error_message', translate('password_mismatch'));
                return;
            }

        }

        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
        $this->session->set_flashdata('flash_message', translate('password_changede_successfully'));

    }


    function get_number_of_active_courses_of_instructor($instructor_id){

        $checker = array(
            'user_id' => $instructor_id,
            'status'  => 'active'
        );
        $result = $this->db->get_where('course', $checker)->num_rows();
        return $result;

    }

    //  get approved applications 
    function get_approved_applications(){
        $applications = $this->db->get_where('applications', array('status' => 1));
        return $applications;
    }

    //  get pending applications 
    function get_pending_applications(){
        $applications = $this->db->get_where('applications', array('status' => 0));
        return $applications;
    }


    public function get_applications($id = "", $type = "") {
        if ($id > 0 && !empty($type)) {
            if ($type == 'user') {
                $applications = $this->db->get_where('applications', array('user_id' => $id));
                return $applications;
            }else {
                $applications = $this->db->get_where('applications', array('id' => $id));
                return $applications;
            }
        }else{
            $this->db->order_by("id", "DESC");
            $applications = $this->db->get_where('applications');
            return $applications;
        }
    }


    function update_status_of_applications($status, $application_id){
        $application_details = $this->get_applications($application_id, 'application');
        if($application_details->num_rows() > 0 ) { 
            $application_details = $application_details->row_array();
            if($status == 'approve'){
                $application_data['status'] = 1;
                $this->db->where('id', $application_id);
                $this->db->update('applications', $application_data);


                $instructor_data['is_instructor'] = 1;
                $this->db->where('id', $application_details['user_id']);
                $this->db->update('users', $instructor_data);

                $this->session->set_flashdata('flash_message', translate('application_approved_successfully'));  
                redirect(base_url(). 'admin/pending_instructor', 'refresh');
            }else{
                $this->db->where('id', $application_id);
                $this->db->delete('applications'); 
                
                $this->session->set_flashdata('flash_message', translate('application_deleted_successfully'));  
                redirect(base_url(). 'admin/pending_instructor', 'refresh');
            }
        }else{
            $this->session->set_flashdata('error_message', translate('invalid_application'));  
            redirect(base_url(). 'admin/pending_instructor', 'refresh'); 
        }
    }
	
	
	/*****  New functions for user page and front end page settings starts fromn here  ******/

    public function get_all_user($user_id = 0) {
        if ($user_id > 0) {
            $this->db->where('id', $user_id);
        }
        return $this->db->get('users');
    }
	
	
	function selectallUserwithId(){
		$sql = $this->db->get_where('users', array( 'id' => $this->session->userdata('user_id')))->result_array();
		return $sql;
	}

   

    public function unlock_screen_by_password($password = "") {
        $password = sha1($password);
        return $this->db->get_where('users', array('id' => $this->session->userdata('user_id'), 'password' => $password))->num_rows();
    }

   
    public function my_courses($user_id = "") {
        if ($user_id == "") {
            $user_id = $this->session->userdata('user_id');
        }
        return $this->db->get_where('enrol', array('user_id' => $user_id));
    }

   

    public function update_account_settings($user_id) {
        $validity = $this->check_duplication('on_update', $this->input->post('email'), $user_id);
        if ($validity) {
            if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
                $user_details = $this->get_user($user_id)->row_array();
                $current_password = $this->input->post('current_password');
                $new_password = $this->input->post('new_password');
                $confirm_password = $this->input->post('confirm_password');
                if ($user_details['password'] == sha1($current_password) && $new_password == $confirm_password) {
                    $data['password'] = sha1($new_password);
                }else {
                    $this->session->set_flashdata('error_message', translate('mismatch_password'));
                    return;
                }
            }
            $data['email'] = html_escape($this->input->post('email'));
            $this->db->where('id', $user_id);
            $this->db->update('users', $data);
            $this->session->set_flashdata('flash_message', translate('updated_successfully'));
        }else {
            $this->session->set_flashdata('error_message', translate('email_duplication'));
        }
    }

   

   
    public function get_instructor_list() {
        $query1 = $this->db->get_where('course', array('status' => 'active'))->result_array();
        $instructor_ids = array();
        $query_result = array();
        foreach ($query1 as $row1) {
            if (!in_array($row1['user_id'], $instructor_ids) && $row1['user_id'] != "") {
                array_push($instructor_ids, $row1['user_id']);
            }
        }
        if (count($instructor_ids) > 0) {
            $this->db->where_in('id', $instructor_ids);
            $query_result = $this->db->get('users');
        }else {
            $query_result = $this->get_admin_details();
        }

        return $query_result;
    }

    public function update_instructor_payment_settings($user_id = '') {
        // Update paypal keys
        $paypal_info = array();
        $paypal['production_client_id'] = html_escape($this->input->post('paypal_client_id'));
        $paypal['production_secret_key'] = html_escape($this->input->post('paypal_secret_key'));
		array_push($paypal_info, $paypal);
		
		$stripe_info = array();
		$stripe_keys = array(
            'public_live_key' => html_escape($this->input->post('stripe_public_key')),
            'secret_live_key' => html_escape($this->input->post('stripe_secret_key'))
        );
        array_push($stripe_info, $stripe_keys);
		
		
        $data['paypal_keys'] = json_encode($paypal_info);
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
		
        array_push($stripe_info, $stripe_keys);
        $data['stripe_keys'] = json_encode($stripe_info);
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
    }
   

    // POST INSTRUCTOR APPLICATION FORM AND INSERT INTO DATABASE IF EVERYTHING IS OKAY
    public function post_instructor_application() {
        // FIRST GET THE USER DETAILS
        $user_details = $this->get_all_user($this->input->post('id'))->row_array();

        // CHECK IF THE PROVIDED ID AND EMAIL ARE COMING FROM VALID USER
        if ($user_details['email'] == $this->input->post('email')) {

            // GET PREVIOUS DATA FROM APPLICATION TABLE
            $previous_data = $this->get_applications($user_details['id'], 'user')->num_rows();
            // CHECK IF THE USER HAS SUBMITTED FORM BEFORE
            if($previous_data > 0) {
                $this->session->set_flashdata('error_message', translate('already_submitted'));
                redirect(site_url('user/application'), 'refresh');
            }
            $data['user_id'] 		= $this->input->post('id');
            $data['address'] 		= $this->input->post('address');
            $data['phone'] 			= $this->input->post('phone');
            $data['message'] 		= $this->input->post('message');
			$data['country_id'] 	= $this->input->post('country_id');
			$data['state_id'] 		= $this->input->post('state_id');
			$data['city_id'] 		= $this->input->post('city_id');
            if (isset($_FILES['document']) && $_FILES['document']['name'] != "") {
                if (!file_exists('uploads/document')) {
                    mkdir('uploads/document', 0777, true);
                }
                $accepted_ext = array('doc', 'docs', 'pdf', 'txt', 'png', 'jpg', 'jpeg', 'mp4');
                $path = $_FILES['document']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                if (in_array(strtolower($ext), $accepted_ext)) {
                    $document_custom_name = random(15).'.'.$ext;
                    $data['document'] = $document_custom_name;
                    move_uploaded_file($_FILES['document']['tmp_name'], 'uploads/document/'.$document_custom_name);
                }else{
                    $this->session->set_flashdata('error_message', translate('invalide_file'));
                    redirect(site_url('user/application'), 'refresh');
                }

            }
            $this->db->insert('applications', $data);
            $this->session->set_flashdata('flash_message', translate('application_submitted_successfully'));
            redirect(site_url('user/application'), 'refresh');
        }else{
            $this->session->set_flashdata('error_message', translate('user_not_found'));
            redirect(site_url('user/application'), 'refresh');
        }
    }



    //either approving or declining pending intructos
    public function update_status_of_application($status, $application_id) {
        $application_details = $this->get_applications($application_id, 'application');
        if ($application_details->num_rows() > 0) {
            $application_details = $application_details->row_array();
            if ($status == 'approve') {
                $application_data['status'] = 1;
                $this->db->where('id', $application_id);
                $this->db->update('applications', $application_data);

                $instructor_data['is_instructor'] = 1;
                $this->db->where('id', $application_details['user_id']);
                $this->db->update('users', $instructor_data);

                $this->session->set_flashdata('flash_message', translate('application_approved_successfully'));
                redirect(site_url('admin/pending_instructor'), 'refresh');
            }else{
                $this->db->where('id', $application_id);
                $this->db->delete('applications');
                $this->session->set_flashdata('flash_message', translate('application_deleted_successfully'));
                redirect(site_url('admin/pending_instructor'), 'refresh');
            }
        }else{
            $this->session->set_flashdata('error_message', translate('invalid_application'));
            redirect(site_url('admin/pending_instructor'), 'refresh');
        }
    }

    





    



    





}