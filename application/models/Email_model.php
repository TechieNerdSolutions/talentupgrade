<?php if (!defined('BASEPATH'))exit('No direct script access allowed');


class Email_model extends CI_Model {

    function __construct() {
        parent::__construct();

    }



    function send_email_verification_mail($to = "", $verification_code = ""){

        $redirect_url = site_url('auth/verify_email_address/'. $verification_code);
        $subject    = "Verify your account";
        $email_msg  = "<b>Hello,</b>";
        $email_msg .= "<p>Please click the link below to verify your account with us.</p>";
        $email_msg .= "Verification Link: " . '<a href="'.$redirect_url.'">"'.$redirect_url.'"</a>';
        $email_to   = $to;

        $this->send_mail_using_mail_function($email_msg, $subject, $email_to);

    }


    function password_reset_email($new_password, $email){
        $query = $this->db->get_where('users', array('email' => $email));
        if($query->num_rows() > 0){
            $subject    = "Your New Password";
            $email_msg  = "<b>Hello,</b>";
            $email_msg .= "<p>Your password has been changed.</p>";
            $email_msg .= "Your new password is :  " . $new_password;
            $email_to   = $email;

            $this->send_mail_using_mail_function($email_msg, $subject, $email_to);
        }else{
            return false;
        }
    }

    function send_mail_using_mail_function($email_msg, $subject, $email_to){

        $to = $email_to;
        $email_sub = $subject;
        $message = $email_msg;
        $headers = "You have got new message";
        $headers .= "From: " . get_settings('system_name');

        mail($to, $email_sub, $message, $headers);
    }






}