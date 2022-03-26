<?php if (!defined('BASEPATH'))exit('No direct script access allowed');


class Modal extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
    }





    function popup ($page_name = "", $param2 = "", $param3 = "", $param4 = "", $param5 = "", $param6 = "", $param7 = ""){

        $logged_in_user_role = strtolower($this->session->userdata('role'));
        $page_data['param2'] = $param2;
        $page_data['param3'] = $param3;
        $page_data['param4'] = $param4;
        $page_data['param5'] = $param5;
        $page_data['param6'] = $param6;
        $page_data['param7'] = $param7;

        $this->load->view('back/' . $logged_in_user_role . '/' . $page_name . '.php', $page_data );

    }






}