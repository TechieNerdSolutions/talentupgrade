<?php if (!defined('BASEPATH'))exit('No direct script access allowed');


class Auth extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        
    }


    public function index() {
        if($this->session->userdata('admin_login') == true) redirect(base_url(). 'admin/dashboard', 'refresh');
        if($this->session->userdata('user_login') == true) redirect(base_url(). 'user/dashboard', 'refresh');

        $this->load->view('back/account/login');
    }

    
    //>>>>>> Function to validate user login  <<<<<<<<
    function validate_login(){
        $email = html_escape($this->input->post('email'));
        $password = html_escape($this->input->post('password'));
        $this->login_model->loginFunctionForAllUsers($email, $password);
    }


    function newRegistration(){
        $this->load->view('back/account/newRegistration');
    }


    //>>>>>> Function to to register users  <<<<<<<<
    function register() {

        $data['first_name'] = html_escape($this->input->post('first_name'));
        $data['last_name']  = html_escape($this->input->post('last_name'));
        $data['email']      = html_escape($this->input->post('email'));
        $data['password']   = sha1($this->input->post('password'));
    
        $verification_code  = md5(rand(10000, 50000));
        $data['verification_code'] = $verification_code;

        if (get_settings('student_email_verification') == 'enable') {
            $data['status'] = 0;
        }else {
            $data['status'] = 1;
        }

        $data['wishlist'] = json_encode(array());
        $data['watch_history'] = json_encode(array());
        $data['date_added'] = strtotime(date("Y-m-d H:i:s"));
        $social_links = array(
            'facebook' => "",
            'twitter'  => "",
            'linkedin' => ""
        );
        $data['social_links'] = json_encode($social_links);
        $data['role_id']  = 2;

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

        $validity = $this->user_model->check_duplication('on_create', $data['email']);
        if ($validity) {
            $user_id = $this->user_model->register_user($data);
            if (get_settings('student_email_verification') == 'enable') {
                $this->email_model->send_email_verification_mail($data['email'], $verification_code);
                $this->session->set_flashdata('flash_message', translate('your_registration_is_successful').'. '.translate('please_check_your_email_to_verify_your_account').'.');
            }else {
                $this->session->set_flashdata('flash_message', translate('your_registration_is_successful'));
            }

        }else {
            $this->session->set_flashdata('error_message', translate('email_already_exist_,_please_use_another_email'));
        }
        //redirect(base_url(). 'auth/index', 'refresh');
        redirect(site_url('auth/index'), 'refresh');
    }

    //>>>>>> Function to verify account email  <<<<<<<<
    function verify_email_address($verification_code = "") {
        $user_details = $this->db->get_where('users', array('verification_code' => $verification_code));
        if($user_details->num_rows() == 0) {
            $this->session->set_flashdata('error_message', translate('email_duplication'));
        }else {
            $user_details = $user_details->row_array();
            $updater = array(
                'status' => 1
            );
            $this->db->where('id', $user_details['id']);
            $this->db->update('users', $updater);
            $this->session->set_flashdata('flash_message', translate('congratulations').'!'.translate('your_email_address_has_been_successfully_verified').'.');
        }
        redirect(site_url('auth/index'), 'refresh');
    }



   function logout($from = ""){

    // destroy sessions of specific userdata. We have done this so as to remove the cart sesssion.
    $this->session_destroy();
    $sdata = array();
    $sdata['page'] = 'login';
    $this->load->view('back/account/login', $sdata);
	redirect(site_url('home'), 'refresh');
   
   }


   function session_destroy(){
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('is_instructor');
        if($this->session->userdata('admin_login') == true){
            $this->session->unset_userdata('admin_login');
        }
        else{
            $this->session->unset_userdata('user_login');
        }

    }


    function resetPassword($from = ""){

        $email = $this->input->post('email');
        // resetting user password here and generate random numbers.
        $new_password = substr( md5 (rand(1000000, 2000000)) , 0, 7);
        // checking user crediential
        $query = $this->db->get_where('users', array('email' => $email));
        if($query->num_rows() > 0 ){
            $this->db->where('email', $email);
            $this->db->update('users', array('password' => sha1($new_password)));

            // sending the new password to the users email address
            $this->email_model->password_reset_email($new_password, $email);
            $this->session->set_flashdata('flash_message', translate('please_check_your_email_address_for_new_password'));
            if($from == 'backend'){
                redirect(site_url('auth/index'), 'refresh');
            }else{
                redirect(site_url('home'), 'refresh');
            }
            
        }else{

            $this->session->set_flashdata('error_message', translate('password_reset_failed'));
            if($from == 'backend'){
                redirect(site_url('auth/index'), 'refresh');
            }else{
                redirect(site_url('home'), 'refresh');
            }

        }

        
        


    }






    
}
