<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {
	
	function __construct(){
    
	    parent::__construct();
    
	}

	//>>>>>>>>>>>Login Function for all users >>>>>>>>>>>>>>>
    function loginFunctionForAllUsers ($email, $password){
        	
        $credential = array('email' => $email, 'password' => sha1($password), 'status' => 1);	
  		
		//>>>>>>>>>>>Login with User Credentials >>>>>>>>>>>>>>>
        $query = $this->db->get_where('users', $credential);

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('user_id', $row->id);
            $this->session->set_userdata('role_id', $row->role_id);
            $this->session->set_userdata('role', get_user_role('user_role', $row->id));
            $this->session->set_userdata('name', $row->first_name.' '.$row->last_name);
            $this->session->set_userdata('is_instructor', $row->is_instructor);
            $this->session->set_flashdata('flash_message', translate('welcome').' '.$row->first_name.' '.$row->last_name);
            if ($row->role_id == 1) {
                $this->session->set_userdata('admin_login', true);
                redirect(site_url('admin/dashboard'), 'refresh');
            }else if($row->role_id == 2){
                $this->session->set_userdata('user_login', true);
                redirect(site_url('home'), 'refresh');
            }
        }else {
            $this->session->set_flashdata('error_message',translate('invalid_login_credentials'));
            redirect(site_url('auth/index'), 'refresh');
        }
    }
	
	
	
	

	
	
}
