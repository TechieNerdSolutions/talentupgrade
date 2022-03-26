<?php if (!defined('BASEPATH'))exit('No direct script access allowed');


class Crud_model extends CI_Model {

    function __construct() {
        parent::__construct();

    }


    function get_currencies(){
        return $this->db->get('currency')->result_array();
    }

    
    function get_paypal_supported_currency(){
        $this->db->where('paypal_supported', 1);
        return $this->db->get('currency')->result_array();
    }

    function get_stripe_supported_currency(){
        $this->db->where('stripe_supported', 1);
        return $this->db->get('currency')->result_array();
    }


    function get_course_thumbnail_url($course_id, $type = 'course_thumbnail'){

        $course_media_placeholder = base_url(). 'uploads/course_thumbnail_palceholder.png';
        if(file_exists('uploads/thumbnails/course_thumbnails/' . $type . '_' . $course_id . '.jpg')){
            return base_url() . 'uploads/thumbnails/course_thumbnails/' . $type . '_' . $course_id . '.jpg';
        }else{
            return base_url() . $course_media_placeholder;
        }

    }


    function update_paypal_settings(){
        // update paypal keys
        $paypa_info_array = array();
        
        $paypal['active'] = $this->input->post('paypal_active');
        $paypal['mode'] = $this->input->post('paypal_mode');
        $paypal['sandbox_client_id'] = $this->input->post('sandbox_client_id');
        $paypal['sandbox_secret_key'] = $this->input->post('sandbox_secret_key');
        $paypal['production_client_id'] = $this->input->post('production_client_id');
        $paypal['production_secret_key'] = $this->input->post('production_secret_key');
        
        $paypal_currency['description'] = $this->input->post('paypal_currency');
        $this->db->where('type', 'paypal_currency');
        $this->db->update('settings', $paypal_currency);

        array_push($paypa_info_array, $paypal);
        $paypal_data['description'] = json_encode($paypa_info_array);
        $this->db->where('type', 'paypal');
        if($this->db->update('settings', $paypal_data))
            return true;
        else 
            return false;
    }




    function update_stripe_settings(){
        // update stripe keys
        $stripe_info_array = array();
        
        $stripe['active'] = $this->input->post('stripe_active');
        $stripe['testmode'] = $this->input->post('testmode');
        $stripe['public_key'] = $this->input->post('public_key');
        $stripe['secret_key'] = $this->input->post('secret_key');
        $stripe['public_live_key'] = $this->input->post('public_live_key');
        $stripe['secret_live_key'] = $this->input->post('secret_live_key');
        
        $stripe_currency['description'] = $this->input->post('stripe_currency');
        $this->db->where('type', 'stripe_currency');
        $this->db->update('settings', $stripe_currency);

        array_push($stripe_info_array, $stripe);
        $stripe_data['description'] = json_encode($stripe_info_array);
        $this->db->where('type', 'stripe');
        if($this->db->update('settings', $stripe_data))
            return true;
        else 
            return false;
    }


    function update_light_logo(){

       if( move_uploaded_file($_FILES['light_logo']['tmp_name'], 'uploads/system/logo-light.png'))
       return true;
       else
       return false;

    }

    function update_favicon(){

        if( move_uploaded_file($_FILES['favicon']['tmp_name'], 'uploads/system/favicon.png'))
        return true;
        else
        return false;
 
    }

     function update_frontend_banner(){

        if( move_uploaded_file($_FILES['banner_image']['tmp_name'], 'uploads/system/home-banner.jpg'))
        return true;
        else
        return false;
 
    }

     
    function update_dark_logo(){

        if( move_uploaded_file($_FILES['dark_logo']['tmp_name'], 'uploads/system/logo-dark.png'))
        return true;
        else
        return false;
 
    }


    function update_small_logo(){

        if( move_uploaded_file($_FILES['small_logo']['tmp_name'], 'uploads/system/logo-light-sm.png'))
        return true;
        else
        return false;
 
    }


    function get_categories($param1 = ""){

        if($param1 != ""){
            $this->db->where('id', $param1);
        }
        $this->db->where('parent', 0);
        return $this->db->get('category');

    }



    function get_sub_categories($parent_id = ""){

        return $this->db->get_where('category', array('parent' => $parent_id))->result_array();

    }

    function get_category_details_by_id($id){
        return $this->db->get_where('category', array('id' => $id));
    }


    function add_category(){

        $data['code']       = html_escape($this->input->post('code'));
        $data['name']       = html_escape($this->input->post('name'));
        $data['parent']     = html_escape($this->input->post('parent'));
        $data['slug']       = slugify($this->input->post('name'));

        // check if the category name already exist
        $this->db->where('name', $data['name']);
        $this->db->or_where('slug', $data['slug']);
        $previous_data = $this->db->get('category')->num_rows();

        if($previous_data == 0){
            if($this->input->post('parent') == 0){

                // let us add font awesome class
                if($_POST['font_awesome_class'] != ""){
                    $data['font_awesome_class']     = html_escape($this->input->post('font_awesome_class'));
                }else{
                    $data['font_awesome_class']     = 'fa fa-angle-double-right';
                }

                // I want to add category thumbnail here
                if(!file_exists('uploads/thumbnails/category_thumbnails')){
                    mkdir('uploads/thumbnails/category_thumbnails', 0777, true);
                }
                if($_FILES['category_thumbnail']['name'] == ""){
                    $data['thumbnail']     = 'category-thumbnail.png';
                }else{
                    $data['thumbnail']     = md5(rand(1000000, 2000000)) . 'jpg';
                    move_uploaded_file($_FILES['category_thumbnail']['tmp_name'], 'uploads/thumbnails/category_thumbnails'. $data['thumbnail']);
                }
            }
            $data['date_added']     = strtotime(date('D, d-M-Y'));

            $query = "select * from category order by id desc limit 1";
            $return_query = $this->db->query($query)->row()->id + 1;
            $data['id']   = $return_query;

            $this->db->insert('category', $data);
            return true;
        }
        return false;

    }




    function edit_category($param1){

        $data['name']       = html_escape($this->input->post('name'));
        $data['parent']     = html_escape($this->input->post('parent'));
        $data['slug']       = slugify($this->input->post('name'));

        // check if the category name already exist
        $this->db->where('name', $data['name']);
        $this->db->or_where('slug', $data['slug']);
        $previous_data = $this->db->get('category')->result_array();


        $checker = true;
        foreach ($previous_data as $row){
            if($row['id' != $param1]){ 
                $checker = false;
                break;
            }
        }

        if($checker){
            if($this->input->post('parent') == 0){

                // let us add font awesome class
                if($_POST['font_awesome_class'] != ""){
                    $data['font_awesome_class']     = html_escape($this->input->post('font_awesome_class'));
                }else{
                    $data['font_awesome_class']     = 'fa fa-angle-double-right';
                }

                // I want to add category thumbnail here
                if(!file_exists('uploads/thumbnails/category_thumbnails')){
                    mkdir('uploads/thumbnails/category_thumbnails', 0777, true);
                }
                if($_FILES['category_thumbnail']['name'] == ""){
                    $data['thumbnail']     = 'category-thumbnail.png';
                }else{
                    $data['thumbnail']     = md5(rand(1000000, 2000000)) . 'jpg';
                    move_uploaded_file($_FILES['category_thumbnail']['tmp_name'], 'uploads/thumbnails/category_thumbnails'. $data['thumbnail']);
                }
            }
            $data['last_modified']  = strtotime(date('D, d-M-Y'));

            $this->db->where('id', $param1);
            $this->db->update('category', $data);
            return true;
        }
        return false;

    }

    function delete_category($category_id){

        $this->db->where('id', $category_id);
        if($this->db->delete('category'))
        return true;
        else
        return false; 

    }

    function enrol_history_by_user_id($user_id = ""){

        return $this->db->get_where('enrol', array('user_id' => $user_id));

    }

    function get_course_by_id($course_id = ""){
        return $this->db->get_where('course', array('id' => $course_id));
    }



    function get_courses($category_id = "", $sub_category_id = "", $insructor_id = 0){

        if($category_id > 0 && $sub_category_id > 0 && $insructor_id > 0){
            return $this->db->get_where('course', array('category_id' => $category_id, 'sub_category_id' => $sub_category_id, 'user_id' => $insructor_id));
        }
        elseif($category_id > 0 && $sub_category_id > 0 && $insructor_id == 0){
            return $this->db->get_where('course', array('category_id' => $category_id, 'sub_category_id' => $sub_category_id));
        }else{
            return $this->db->get('course');
        }

    }



    function enrol_a_student_manually(){
        $page_data['user_id']   = $this->input->post('user_id');
        $page_data['course_id'] = $this->input->post('course_id');

        if($this->db->get_where('enrol', $page_data)->num_rows() > 0){
            $this->session->set_flashdata('error_message', translate('student_has_been_enrolled_to_this_course'));  
            return false;
        }else{
            
            $page_data['date_added'] = strtotime(date('D, d-M-Y'));

            $sql = "select * from enrol order by id desc limit 1";
            $return_query = $this->db->query($sql)->row()->id + 1;
            $page_data['id'] = $return_query;

            if($this->db->insert('enrol', $page_data))
            return true;
            else
            return false;
        }
    }



    function enrol_history($course_id = ""){
        if($course_id > 0) {
            return $this->db->get_where('enrol', array('course_id' => $course_id));
        }else{
            return $this->db->get('enrol');
        }
    }


    function delete_enrol_history($param2){

        $this->db->where('id', $param2);
        if($this->db->delete('enrol'))
        return true;
        else
        return false;

    }


    function get_section($type_by, $id){
        $this->db->order_by("order", "asc");
        if($type_by == 'course'){
            return $this->db->get_where('section', array('course_id' => $id));
        }elseif($type_by == "section"){
            return $this->db->get_where('section', array('id' => $id));
        }
    }


    function get_lessons($type = "", $id = ""){
        $this->db->order_by("order", "asc");
        if($type == 'course'){
            return $this->db->get_where('lesson', array('course_id' => $id));
        }elseif($type == "section"){
            return $this->db->get_where('lesson', array('section_id' => $id));
        }elseif($type == "lesson"){
            return $this->db->get_where('lesson', array('id' => $id));
        }else{
            return $this->db->get('lesson');
        }
    }


    function add_course($param1 = ""){

        $outcomes = $this->trim_and_return_json($this->input->post('outcomes'));
        $requirements = $this->trim_and_return_json($this->input->post('requirements'));

        $data['title'] = html_escape($this->input->post('title'));
        $data['short_description'] = html_escape($this->input->post('short_description'));
        $data['description'] = html_escape($this->input->post('description'));
        $data['outcomes'] = $outcomes;
        $data['requirements'] = $requirements;
        $data['language'] = html_escape($this->input->post('language_made_in'));
        $data['sub_category_id'] = html_escape($this->input->post('sub_category_id'));
        $category_details = $this->get_category_details_by_id($this->input->post('sub_category_id'))->row_array();
        $data['category_id'] = $category_details['parent'];
        $data['price'] = html_escape($this->input->post('price'));
        $data['discount_flag'] = html_escape($this->input->post('discount_flag'));
        $data['discounted_price'] = html_escape($this->input->post('discounted_price'));
        $data['level'] = html_escape($this->input->post('level'));

        if($this->input->post('is_free_course') != ""){
            $data['is_free_course'] = html_escape($this->input->post('is_free_course'));
        }
        else{
            $data['is_free_course'] = "";
        }

        $data['video_url'] = html_escape($this->input->post('course_overview_url'));
        
        if($this->input->post('course_overview_provider') != ""){
            $data['course_overview_provider'] = html_escape($this->input->post('course_overview_provider'));
        }
        else{
            $data['course_overview_provider'] = "";
        }

        $data['date_added']         = strtotime(date('D, d-M-Y'));
        $data['section']            = json_encode(array());

        if($this->input->post('is_top_course') != 1){
            $data['is_top_course'] = 0;
        }else{
            $data['is_top_course'] =  1;
        }


        $data['user_id']            = $this->session->userdata('user_id');
        $data['meta_description']   = $this->input->post('meta_description');
        $data['meta_keywords']      = $this->input->post('meta_keywords');

        $admin_details = $this->user_model->get_admin_details()->row_array();
        if($admin_details['id'] == $data['user_id']){
            $data['is_admin'] = 1;
        }else{
            $data['is_admin'] = 0;
        }

        if($param1 == "save_to_draft"){
            $data['status'] = "draft";
        }else{
            if($this->session->userdata('admin_login')){
                $data['status'] = "active";
            }else{
                $data['status'] = "pending";
            }
        }

        $sql = "select * from course order by id desc limit 1";
        $return_query = $this->db->query($sql)->row()->id + 1;
        $data['id'] = $return_query;
        $this->db->insert('course', $data);

        $course_id = $this->db->insert_id();

        //create folder if does not exist
        if(!file_exists('uploads/thumbnails/course_thumbnails')){
            mkdir('uploads/thumbnails/course_thumbnails', 0777, true);
        }


        if($_FILES['course_thumbnail']['name'] != ""){
            move_uploaded_file($_FILES['course_thumbnail']['tmp_name'], 'uploads/thumbnails/course_thumbnails/' . 'course_thumbnail' . '_' .$course_id. '.jpg');
        }


        if($data['status'] == 'approved'){
            $this->session->set_flashdata('flash_message', translate('course_added_successfully'));
        }elseif ($data['status'] == 'pending'){
            $this->session->set_flashdata('flash_message', translate('course_added_successfully') . ',' .translate('please_wait_until_admin_approves_it'));
        }elseif ($data['status'] == 'draft'){
            $this->session->set_flashdata('flash_message', translate('course_added_to_draft_successfully'));
        }

        $this->session->set_flashdata('flash_message', translate('course_has_been_added_successfully'));
        return $course_id;

    }




    function update_courses($course_id, $type = ""){

        $course_details = $this->get_course_by_id($course_id)->row_array();

        $outcomes = $this->trim_and_return_json($this->input->post('outcomes'));
        $requirements = $this->trim_and_return_json($this->input->post('requirements'));

        $data['title'] = html_escape($this->input->post('title'));
        $data['short_description'] = html_escape($this->input->post('short_description'));
        $data['description'] = html_escape($this->input->post('description'));
        $data['outcomes'] = $outcomes;
        $data['requirements'] = $requirements;
        $data['language'] = html_escape($this->input->post('language_made_in'));
        $data['sub_category_id'] = html_escape($this->input->post('sub_category_id'));
        $category_details = $this->get_category_details_by_id($this->input->post('sub_category_id'))->row_array();
        $data['category_id'] = $category_details['parent'];
        $data['price'] = html_escape($this->input->post('price'));
        $data['discount_flag'] = html_escape($this->input->post('discount_flag'));
        $data['discounted_price'] = html_escape($this->input->post('discounted_price'));
        $data['level'] = html_escape($this->input->post('level'));

        if($this->input->post('is_free_course') != ""){
            $data['is_free_course'] = html_escape($this->input->post('is_free_course'));
        }
        else{
            $data['is_free_course'] = "";
        }

        $data['video_url'] = html_escape($this->input->post('course_overview_url'));
        
        if($this->input->post('course_overview_provider') != ""){
            $data['course_overview_provider'] = html_escape($this->input->post('course_overview_provider'));
        }
        else{
            $data['course_overview_provider'] = "";
        }

        $data['date_added']         = strtotime(date('D, d-M-Y'));
        $data['section']            = json_encode(array());

        if($this->input->post('is_top_course') != 1){
            $data['is_top_course'] = 0;
        }else{
            $data['is_top_course'] =  1;
        }


        $data['user_id']            = $this->session->userdata('user_id');
        $data['meta_description']   = $this->input->post('meta_description');
        $data['meta_keywords']      = $this->input->post('meta_keywords');

        $admin_details = $this->user_model->get_admin_details()->row_array();
        if($admin_details['id'] == $data['user_id']){
            $data['is_admin'] = 1;
        }else{
            $data['is_admin'] = 0;
        }

        if($type == "save_to_draft"){
            $data['status'] = "draft";
        }else{
            if($this->session->userdata('admin_login')){
                $data['status'] = "active";
            }else{
                $data['status'] = $course_details['status'];
            }
        }

        $this->db->where('id', $course_id);
        $this->db->update('course', $data);

        if($_FILES['course_thumbnail']['name'] != ""){
            move_uploaded_file($_FILES['course_thumbnail']['tmp_name'], 'uploads/thumbnails/course_thumbnails/' . 'course_thumbnail' . '_' .$course_id. '.jpg');
        }


        if($data['status'] == 'active'){
            $this->session->set_flashdata('flash_message', translate('course_update_successfully'));
        }elseif ($data['status'] == 'pending'){
            $this->session->set_flashdata('flash_message', translate('course_update_successfully') . ',' .translate('please_wait_until_admin_approves_it'));
        }elseif ($data['status'] == 'draft'){
            $this->session->set_flashdata('flash_message', translate('course_update_to_draft_successfully'));
        }
    }


    function trim_and_return_json($untrimmed_array){

        $trimmed_array = array();
            if(sizeof($untrimmed_array > 0)){
                foreach ($untrimmed_array as $row){
                    if($row != ""){
                        array_push($trimmed_array, $row);
                    }
                }
            }
        return json_encode($trimmed_array);

    }



    public function filter_course_for_backend($category_id, $instructor_id, $price, $status){
        if ($category_id != "all") {
            $this->db->where('sub_category_id', $category_id);
        }

        if ($price != "all") {
            if ($price == "paid") {
                $this->db->where('is_free_course', null);
            } elseif ($price == "free") {
                $this->db->where('is_free_course', 1);
            }
        }

        if ($instructor_id != "all") {
            $this->db->where('user_id', $instructor_id);
        }

        if ($status != "all") {
            $this->db->where('status', $status);
        }
        return $this->db->get('course')->result_array();
    }



    function get_status_wise_courses($status = ""){

        if($status != ""){
            $courses = $this->db->get_where('course', array('status' => $status));
        }else{
            $courses['draft'] = $this->db->get_where('course', array('status' => "draft"));
            $courses['pending'] = $this->db->get_where('course', array('status' => "pending"));
            $courses['active'] = $this->db->get_where('course', array('status' => "active"));
        }

        return $courses;

    }



    function delete_course($course_id){

        $this->db->where('id', $course_id);
        $this->db->delete('course');

        // delete all the lessons of this course from the lesson table
        $lesson_checker = array('course_id' => $course_id);
        $this->db->delete('lesson', $lesson_checker);
    }



    public function add_section($course_id){
        $data['title'] = html_escape($this->input->post('title'));
        $data['course_id'] = $course_id;
        $this->db->insert('section', $data);
        $section_id = $this->db->insert_id();

        $course_details = $this->get_course_by_id($course_id)->row_array();
        $previous_sections = json_decode($course_details['section']);

        if (sizeof($previous_sections) > 0) {
            array_push($previous_sections, $section_id);
            $updater['section'] = json_encode($previous_sections);
            $this->db->where('id', $course_id);
            $this->db->update('course', $updater);
        } else {
            $previous_sections = array();
            array_push($previous_sections, $section_id);
            $updater['section'] = json_encode($previous_sections);
            $this->db->where('id', $course_id);
            $this->db->update('course', $updater);
        }
    }



    function edit_section($section_id){
        $data['title'] = $this->input->post('title');
        $this->db->where('id', $section_id);
        $this->db->update('section', $data);
    }

    function delete_section($course_id, $section_id){
        $this->db->where('id', $section_id);
        $this->db->delete('section');

        $course_details = $this->get_course_by_id($course_id)->row_array();
        $previous_sections = json_decode($course_details['section']);

        if(sizeof($previous_sections) > 0 ) {
            $new_section = array();
            for ($i = 0; $i < sizeof($previous_sections); $i++){
                if($previous_sections[$i] != $section_id){
                    array_push($new_section, $previous_sections[$i]);
                }
            }
            $updater['section'] = json_encode($new_section);
            $this->db->where('id', $course_id);
            $this->db->update('course', $updater);
        }

    }




    function add_lesson(){

        $data['course_id'] = $this->input->post('course_id');
        $data['title'] = $this->input->post('title');
        $data['section_id'] = $this->input->post('section_id');

        $lesson_type_array = explode('-', $this->input->post('lesson_type'));
        $lesson_type = $lesson_type_array[0];

        $attachment_type = $lesson_type_array[1];
        $data['attachment_type'] = $attachment_type;
        $data['lesson_type'] = $lesson_type;

        if($lesson_type == 'video'){

            /********* This portion is for web application's video lesson  *********/

            $lesson_provider = $this->input->post('lesson_provider');

            if($lesson_provider == 'youtube' || $lesson_provider == 'vimeo'){

                if($this->input->post('video_url') == "" || $this->input->post('duration') == ""){
                    $this->session->set_flashdata('error_message', translate('invalid_lesson_url_and_duration'));  
                    redirect(site_url(strlower($this->session->userdata('role')) . '/edit_course' . $data['course_id'], 'refresh'));
                }

                $data['video_url'] = $this->input->post('video_url');

                $duration_formatter = explode(':', $this->input->post('duration'));
                $hour   = sprintf('%02d', $duration_formatter[0]);
                $min    = sprintf('%02d', $duration_formatter[1]);
                $sec    = sprintf('%02d', $duration_formatter[2]);

                $data['duration'] = $hour . ':' . $min . ':' . $sec;

                $video_details = $this->video_model->getVideoDetails($data['video_url']);
                $data['video_type'] = $video_details['provider'];
            }

        }else{

            if($attachment_type == 'iframe'){

                if(empty($this->input->post('iframe_source'))){
                    $this->session->set_flashdata('error_message', translate('invalid_source'));  
                    redirect(site_url(strlower($this->session->userdata('role')) . '/edit_course' . $data['course_id'], 'refresh'));
                }
                $data['attachment'] = $this->input->post('iframe_source');
            }else{

                if($_FILES['attachment']['name'] == ""){
                    $this->session->set_flashdata('error_message', translate('invalid_source'));  
                    redirect(site_url(strlower($this->session->userdata('role')) . '/edit_course' . $data['course_id'], 'refresh'));
                }else{
                    $fileName   =  $_FILES['attachment']['name'];
                    $tmp        =  explode('.', $fileName);
                    $fileExtension = end($tmp); 
                    $uploadable_file = md5(uniqid(rand(), true)) . '.' . $fileExtension;
                    $data['attachment'] = $uploadable_file;

                    if(!file_exists('uploads/lesson_files')){
                        mkdir('uploads/lesson_files', 0777, true);
                    }

                    move_uploaded_file($_FILES['attachment']['tmp_name'], 'uploads/lesson_files/' . $uploadable_file);
                }
            }
        }
        $data['date_added'] = strtotime(date('D, d-M-Y'));
        $data['summary'] = $this->input->post('summary');

        $sql = "select * from lesson order by id desc limit 1";
        $return_query = $this->db->query($sql)->row()->id + 1;
        $data['id'] = $return_query;
        
        $this->db->insert('lesson', $data);
        $inserted_id = $this->db->insert_id();

        if($_FILES['thumbnail']['name'] != ""){
            if(!file_exists('uploads/thumbnails/lessons_thumbnails')){
                mkdir('uploads/thumbnails/lessons_thumbnails', 0777, true);
            }

            move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'uploads/thumbnails/lessons_thumbnails/' . $inserted_id . '.jpg');
        }



    }




    function edit_lesson($lesson_id){

        $previous_data = $this->db->get_where('lesson', array('id' => $lesson_id))->row_array();

        $data['course_id'] = $this->input->post('course_id');
        $data['title'] = $this->input->post('title');
        $data['section_id'] = $this->input->post('section_id');

        $lesson_type_array = explode('-', $this->input->post('lesson_type'));
        $lesson_type = $lesson_type_array[0];

        $attachment_type = $lesson_type_array[1];
        $data['attachment_type'] = $attachment_type;
        $data['lesson_type'] = $lesson_type;

        if($lesson_type == 'video'){

            /********* This portion is for web application's video lesson  *********/

            $lesson_provider = $this->input->post('lesson_provider');

            if($lesson_provider == 'youtube' || $lesson_provider == 'vimeo'){

                if($this->input->post('video_url') == "" || $this->input->post('duration') == ""){
                    $this->session->set_flashdata('error_message', translate('invalid_lesson_url_and_duration'));  
                    redirect(site_url(strlower($this->session->userdata('role')) . '/edit_course' . $data['course_id'], 'refresh'));
                }

                $data['video_url'] = $this->input->post('video_url');

                $duration_formatter = explode(':', $this->input->post('duration'));
                $hour   = sprintf('%02d', $duration_formatter[0]);
                $min    = sprintf('%02d', $duration_formatter[1]);
                $sec    = sprintf('%02d', $duration_formatter[2]);

                $data['duration'] = $hour . ':' . $min . ':' . $sec;

                $video_details = $this->video_model->getVideoDetails($data['video_url']);
                $data['video_type'] = $video_details['provider'];
            }

        }else{

            if($attachment_type == 'iframe'){

                if(empty($this->input->post('iframe_source'))){
                    $this->session->set_flashdata('error_message', translate('invalid_source'));  
                    redirect(site_url(strlower($this->session->userdata('role')) . '/edit_course' . $data['course_id'], 'refresh'));
                }
                $data['attachment'] = $this->input->post('iframe_source');
            }else{

                if($_FILES['attachment']['name'] != ""){
                   
                    /*** Unlinking the previous attachment ***/
                    if($previous_data['attachment'] != ""){
                        unlink('uploads/lesson_files/' . $previous_data['attachment']);
                    }


                    $fileName   =  $_FILES['attachment']['name'];
                    $tmp        =  explode('.', $fileName);
                    $fileExtension = end($tmp); 
                    $uploadable_file = md5(uniqid(rand(), true)) . '.' . $fileExtension;
                    $data['attachment'] = $uploadable_file;

                    if(!file_exists('uploads/lesson_files')){
                        mkdir('uploads/lesson_files', 0777, true);
                    }

                    move_uploaded_file($_FILES['attachment']['tmp_name'], 'uploads/lesson_files/' . $uploadable_file);

                } 
               
            }
        }
        $data['last_modified'] = strtotime(date('D, d-M-Y'));
        $data['summary'] = $this->input->post('summary');

        $this->db->where('id', $lesson_id);
        $this->db->update('lesson', $data);

    }




    function delete_lesson($lesson_id){
        
        $previous_data = $this->db->get_where('lesson', array('id' => $lesson_id))->row_array();
        if($previous_data['attachment'] != ""){
            unlink('uploads/lesson_files/' . $previous_data['attachment']);
        }  
        $this->db->where('id', $lesson_id);
        $this->db->delete('lesson');

    }


    /** Adding quiz functionalities **/
    function add_quiz($course_id = ""){

        $quiz['course_id']      = $course_id;
        $quiz['title']          = html_escape($this->input->post('title'));
        $quiz['section_id']     = $this->input->post('section_id');
        $quiz['lesson_type']    = 'quiz';
        $quiz['duration']       = '00:00:00';
        $quiz['date_added']     =  strtotime(date('D, d-M-Y'));
        $quiz['summary']        =   html_escape($this->input->post('summary'));


        $sql = "select * from lesson order by id desc limit 1";
        $return_query = $this->db->query($sql)->row()->id + 1;
        $quiz['id'] = $return_query;

        $this->db->insert('lesson', $quiz);


    }


    /** Updating quiz functionalities **/

    function edit_quiz($lesson_id = null){

        $quiz['title']          = html_escape($this->input->post('title'));
        $quiz['section_id']     = $this->input->post('section_id');
        $quiz['last_modified']  = strtotime(date('D, d-M-Y'));
        $quiz['summary']        = html_escape($this->input->post('summary'));

        $this->db->where('id', $lesson_id);
        $this->db->update('lesson', $quiz);

    }




    function get_quiz_questions($quiz_id){

        $this->db->order_by("order", "asc");
        $this->db->where('quiz_id', $quiz_id);
        return $this->db->get('question');
    }



    function get_quiz_question_by_id($question_id){

        $this->db->order_by("order", "asc");
        $this->db->where('id', $question_id);
        return $this->db->get('question');
    }


    public function add_quiz_questions($quiz_id){
        $question_type = $this->input->post('question_type');
        if ($question_type == 'mcq') {
            $response = $this->add_multiple_choice_question($quiz_id);
            return $response;
        }
    }


    // this function adds multiple choice questions for the students
    function add_multiple_choice_question($quiz_id){
        if (sizeof($this->input->post('options')) != $this->input->post('number_of_options')) {
            return false;
        }
        foreach ($this->input->post('options') as $option) {
            if ($option == "") {
                return false;
            }
        }
        if (sizeof($this->input->post('correct_answers')) == 0) {
            $correct_answers = [""];
        } else {
            $correct_answers = $this->input->post('correct_answers');
        }
        $data['quiz_id']            = $quiz_id;
        $data['title']              = html_escape($this->input->post('title'));
        $data['number_of_options']  = html_escape($this->input->post('number_of_options'));
        $data['type']               = 'multiple_choice';
        $data['options']            = json_encode($this->input->post('options'));
        $data['correct_answers']    = json_encode($correct_answers);
        $this->db->insert('question', $data);
        return true;
    }



    function update_quiz_questions($question_id){
        if (sizeof($this->input->post('options')) != $this->input->post('number_of_options')) {
            return false;
        }
        foreach ($this->input->post('options') as $option) {
            if ($option == "") {
                return false;
            }
        }
        if (sizeof($this->input->post('correct_answers')) == 0) {
            $correct_answers = [""];
        } else {
            $correct_answers = $this->input->post('correct_answers');
        }
        $data['title']              = html_escape($this->input->post('title'));
        $data['number_of_options']  = html_escape($this->input->post('number_of_options'));
        $data['type']               = 'multiple_choice';
        $data['options']            = json_encode($this->input->post('options'));
        $data['correct_answers']    = json_encode($correct_answers);
        $this->db->where('id', $question_id);
        $this->db->update('question', $data);
        return true;
    }




    function delete_quiz_question($question_id){
        $this->db->where('id', $question_id);
        $this->db->delete('question');
        return true;
    }



    function get_completed_payouts_by_date_range($timestamp_start = "", $timestamp_end = ""){
        $this->db->order_by('id', 'DESC');
        $this->db->where('date_added >=', $timestamp_start);
        $this->db->where('date_added <=', $timestamp_end);
        $this->db->where('status', 1);
        return $this->db->get('payout');
    }

    function get_pending_payouts(){

        $this->db->order_by('id', 'DESC');
        $this->db->where('status', 0);
        return $this->db->get('payout');

    }



    // select from payout table where type  = user or type = payout
    function get_payouts($id = "", $type = ""){

        $this->db->order_by('id', 'DESC');
        if($id > 0 && $type == 'user'){
            $this->db->where('user_id', $id);
        }elseif ($id > 0 && $type == 'payout') {
            $this->db->where('id', $id);
        }

        return $this->db->get('payout');

    }

    // Using payout id update payout table and using payment type to determine payment method (paypal or stripe)
    function update_payout_status($payout_id = "" , $payment_type = ""){

        $updater = array(
            'status' => 1,
            'payment' => $payment_type,
            'last_modified' => strtotime(date('D, d-M-Y')),
            'month' => date('M')
        );

        $this->db->where('id', $payout_id);
        $this->db->update('payout', $updater);

    }



    // function for the instructor application note and revenue settings...
    function instructorApplicationAndRevenueSettings(){
        $data = array();
        $inputs = $this->input->post();   
        foreach ($inputs as $key => $value) {
            # code...
            $page_data['description'] = $value;
            $this->db->where('type' , $key);
            $this->db->update('settings', $page_data);
            

        } 
    }


    function insertExpenseCategory(){
        $data['name'] = $this->input->post('name');

        $sql = "select * from expense_category order by id desc limit 1";
        $return_query = $this->db->query($sql)->row()->id + 1;
        $data['id'] = $return_query;
        $this->db->insert('expense_category', $data);
    }

    function updateExpenseCategory($id){
        $data['name'] = $this->input->post('name');

        $this->db->where('id', $id);
        $this->db->update('expense_category', $data);
    }

    function deleteExpenseCategory($id){
        $this->db->where('id', $id);
        $this->db->delete('expense_category');
    }


    function insertExpense(){
        $data['title'] = $this->input->post('title');
        $data['expense_category_id'] = $this->input->post('expense_category_id');
        $data['description'] = $this->input->post('description');
        $data['amount'] = $this->input->post('amount');
        $data['method'] = $this->input->post('method');
        $data['date_added'] = strtotime($this->input->post('date_added'));
        $data['month'] = date('M');
        $data['payment_type'] = 'expense';

        $sql = "select * from payment order by id desc limit 1";
        $return_query = $this->db->query($sql)->row()->id + 1;
        $data['id'] = $return_query;
        $this->db->insert('payment', $data);
    }

    function updateExpense($id){
        $data['title'] = $this->input->post('title');
        $data['expense_category_id'] = $this->input->post('expense_category_id');
        $data['description'] = $this->input->post('description');
        $data['amount'] = $this->input->post('amount');
        $data['method'] = $this->input->post('method');
        $data['date_added'] = strtotime($this->input->post('date_added'));
        $data['month'] = date('M');
        $data['payment_type'] = 'expense';
        $this->db->where('id', $id);
        $this->db->update('payment', $data);
    }

    function deleteExpense($id){
        $this->db->where('id', $id);
        $this->db->delete('payment');
    }


    // function for updating the promotional settings
    function updatePromotionalMessageSettings(){
        $data = array();
        $inputs = $this->input->post();   
        foreach ($inputs as $key => $value) {
            # code...
            $page_data['description'] = $value;
            $this->db->where('type' , $key);
            $this->db->update('settings', $page_data);
            

        } 
    }


    function send_new_private_message(){
        $message    = $this->input->post('message');
        $timestamp  = strtotime(date("Y-m-d H:i:s"));
        $receiver   = $this->input->post('receiver');
        $sender     = $this->session->userdata('user_id');

        // check if the thread between those two users exist. if not create a new thread
        $num1 = $this->db->get_where('message_thread', array('sender' => $sender, 'receiver' => $receiver))->num_rows();
        $num2 = $this->db->get_where('message_thread', array('sender' => $receiver, 'receiver' => $sender))->num_rows();
        
        if($num1 == 0 && $num2 == 0){
            $message_thread_code                    =   substr(md5(rand(1000000, 2000000)), 0, 15);
            $data_message['message_thread_code']    =   $message_thread_code;
            $data_message['sender']                 =   $sender;
            $data_message['receiver']               =   $receiver;
            
            $sql = "select * from message_thread order by message_thread_id desc limit 1";
            $return_query = $this->db->query($sql)->row()->message_thread_id + 1;
            $data_message['message_thread_id'] = $return_query;
            $this->db->insert('message_thread', $data_message);
        }

        if($num1 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $sender, 'receiver' => $receiver))->row()->message_thread_code;
        if($num2 > 0)
            $message_thread_code = $this->db->get_where('message_thread', array('sender' => $receiver, 'receiver' => $sender))->row()->message_thread_code;

            $data_message2['message_thread_code']    =   $message_thread_code;
            $data_message2['message']                =   $message;
            $data_message2['sender']                 =   $sender;
            $data_message2['timestamp']              =   $timestamp;

            $sql = "select * from message order by message_id desc limit 1";
            $return_query = $this->db->query($sql)->row()->message_id + 1;
            $data_message2['message_id'] = $return_query;

            $this->db->insert('message', $data_message2);

            return $message_thread_code;
        
    }


    function send_reply_message($message_thread_code){

        $message    = html_escape($this->input->post('message'));
        $timestamp  = strtotime(date("Y-m-d H:i:s"));
        $sender     = $this->session->userdata('user_id');

        $data_message['message_thread_code']    =   $message_thread_code;
        $data_message['message']                =   $message;
        $data_message['sender']                 =   $sender;
        $data_message['timestamp']              =   $timestamp;

        $sql = "select * from message order by message_id desc limit 1";
        $return_query = $this->db->query($sql)->row()->message_id + 1;
        $data_message['message_id'] = $return_query;

        $this->db->insert('message', $data_message);

    }


    function mark_thread_messages_read($message_thread_code){

        // mark read only the opponent messages of the thread, not the current logged in user's sent message
        $current_user = $this->session->userdata('user_id');
        $this->db->where('sender !=', $current_user);
        $this->db->where('message_thread_code', $message_thread_code);
        $this->db->update('message', array('read_status' => 1));

    }


    function count_unread_message_of_thread($message_thread_code){
        $unread_message_counter = 0;
        $current_user = $this->session->userdata('user_id');
        $messages = $this->db->get_where('message', array('message_thread_code' => $message_thread_code))->result_array();
        foreach ($messages as $key => $row) {
            # code...
            if($row['sender'] != $current_user && $row['read_status'] == 0)
            $unread_message_counter++;
        }

        return $unread_message_counter;
    }


    public function get_last_message_by_message_thread_code($message_thread_code){

        $this->db->order_by('message_id', 'desc');
        $this->db->limit(1);
        $this->db->where('message_thread_code', $message_thread_code);
        return $this->db->get('message');

    }
	
	/*******  Bothe Front end and user page crud model functions starts here  *******/


    public function get_category_id($slug = ""){
        $category_details = $this->db->get_where('category', array('slug' => $slug))->row_array();
        return $category_details['id'];
    }

    
   
    public function all_enrolled_student()
    {
        $this->db->select('user_id');
        $this->db->distinct('user_id');
        return $this->db->get('enrol');
    }

    public function enrol_history_by_date_range($timestamp_start = "", $timestamp_end = "")
    {
        $this->db->order_by('date_added', 'desc');
        $this->db->where('date_added >=', $timestamp_start);
        $this->db->where('date_added <=', $timestamp_end);
        return $this->db->get('enrol');
    }

    public function get_revenue_by_user_type($timestamp_start = "", $timestamp_end = "", $revenue_type = "")
    {
        $course_ids = array();
        $courses    = array();
        $admin_details = $this->user_model->get_admin_details()->row_array();
        if ($revenue_type == 'admin_revenue') {
            $this->db->where('date_added >=', $timestamp_start);
            $this->db->where('date_added <=', $timestamp_end);
        } elseif ($revenue_type == 'instructor_revenue') {
            $this->db->where('user_id !=', $admin_details['id']);
            $this->db->select('id');
            $courses = $this->db->get('course')->result_array();
            foreach ($courses as $course) {
                if (!in_array($course['id'], $course_ids)) {
                    array_push($course_ids, $course['id']);
                }
            }
            if (sizeof($course_ids)) {
                $this->db->where_in('course_id', $course_ids);
            } else {
                return array();
            }
        }

        $this->db->order_by('date_added', 'desc');
        return $this->db->get('payment')->result_array();
    }

    public function get_instructor_revenue($user_id = "", $timestamp_start = "", $timestamp_end = "")
    {
        $course_ids = array();
        $courses    = array();

        if ($user_id > 0) {
            $this->db->where('user_id', $user_id);
        } else {
            $this->db->where('user_id', $this->session->userdata('user_id'));
        }

        $this->db->select('id');
        $courses = $this->db->get('course')->result_array();
        foreach ($courses as $course) {
            if (!in_array($course['id'], $course_ids)) {
                array_push($course_ids, $course['id']);
            }
        }
        if (sizeof($course_ids)) {
            $this->db->where_in('course_id', $course_ids);
        } else {
            return array();
        }

        // CHECK IF THE DATE RANGE IS SELECTED
        if (!empty($timestamp_start) && !empty($timestamp_end)) {
            $this->db->where('date_added >=', $timestamp_start);
            $this->db->where('date_added <=', $timestamp_end);
        }

        $this->db->order_by('date_added', 'desc');
        return $this->db->get('payment')->result_array();
    }

    public function delete_payment_history($param1)
    {
        $this->db->where('id', $param1);
        $this->db->delete('payment');
    }


    public function purchase_history($user_id)
    {
        if ($user_id > 0) {
            return $this->db->get_where('payment', array('user_id' => $user_id));
        } else {
            return $this->db->get('payment');
        }
    }

    public function get_payment_details_by_id($payment_id = "")
    {
        return $this->db->get_where('payment', array('id' => $payment_id))->row_array();
    }

   



    
	

    public function change_course_status($status = "", $course_id = "")
    {
        if ($status == 'active') {
            if ($this->session->userdata('admin_login') != true) {
                redirect(site_url('login'), 'refresh');
            }
        }
        $updater = array(
            'status' => $status
        );
        $this->db->where('id', $course_id);
        $this->db->update('course', $updater);
    }

  
    public function get_lesson_thumbnail_url($lesson_id)
    {

        if (file_exists('uploads/thumbnails/lesson_thumbnails/' . $lesson_id . '.jpg'))
        return base_url() . 'uploads/thumbnails/lesson_thumbnails/' . $lesson_id . '.jpg';
        else
        return base_url() . 'uploads/thumbnails/thumbnail.png';
    }

    public function get_my_courses_by_category_id($category_id)
    {
        $this->db->select('course_id');
        $course_lists_by_enrol = $this->db->get_where('enrol', array('user_id' => $this->session->userdata('user_id')))->result_array();
        $course_ids = array();
        foreach ($course_lists_by_enrol as $row) {
            if (!in_array($row['course_id'], $course_ids)) {
                array_push($course_ids, $row['course_id']);
            }
        }
        $this->db->where_in('id', $course_ids);
        $this->db->where('category_id', $category_id);
        return $this->db->get('course');
    }

    public function get_my_courses_by_search_string($search_string)
    {
        $this->db->select('course_id');
        $course_lists_by_enrol = $this->db->get_where('enrol', array('user_id' => $this->session->userdata('user_id')))->result_array();
        $course_ids = array();
        foreach ($course_lists_by_enrol as $row) {
            if (!in_array($row['course_id'], $course_ids)) {
                array_push($course_ids, $row['course_id']);
            }
        }
        $this->db->where_in('id', $course_ids);
        $this->db->like('title', $search_string);
        return $this->db->get('course');
    }

    public function get_courses_by_search_string($search_string)
    {
        $this->db->like('title', $search_string);
        $this->db->where('status', 'active');
        return $this->db->get('course');
    }



   

    public function get_top_courses()
    {
        return $this->db->get_where('course', array('is_top_course' => 1, 'status' => 'active'));
    }

    public function get_default_category_id()
    {
        $categories = $this->get_categories()->result_array();
        foreach ($categories as $category) {
            return $category['id'];
        }
    }
	
	// This function is responsible for showing all the installed themes
                    function get_installed_themes($dir = APPPATH . '/views/frontend')
                    {
                        $result = array();
                        $cdir = $files = preg_grep('/^([^.])/', scandir($dir));
                        foreach ($cdir as $key => $value) {
                            if (!in_array($value, array(".", ".."))) {
                                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                                    array_push($result, $value);
                                }
                            }
                        }
                        return $result;
                    }

    public function get_courses_by_user_id($param1 = "")
    {
        $courses['draft'] = $this->db->get_where('course', array('user_id' => $param1, 'status' => 'draft'));
        $courses['pending'] = $this->db->get_where('course', array('user_id' => $param1, 'status' => 'pending'));
        $courses['active'] = $this->db->get_where('course', array('user_id' => $param1, 'status' => 'active'));
        return $courses;
    }

   

    public function get_status_wise_courses_for_instructor($status = "")
    {
        if ($status != "") {
            $this->db->where('status', $status);
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $courses = $this->db->get('course');
        } else {
            $this->db->where('status', 'draft');
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $courses['draft'] = $this->db->get('course');

            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('status', 'draft');
            $courses['pending'] = $this->db->get('course');

            $this->db->where('status', 'draft');
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $courses['active'] = $this->db->get_where('course');
        }
        return $courses;
    }

    public function get_default_sub_category_id($default_cateegory_id)
    {
        $sub_categories = $this->get_sub_categories($default_cateegory_id);
        foreach ($sub_categories as $sub_category) {
            return $sub_category['id'];
        }
    }

    public function get_instructor_wise_courses($instructor_id = "", $return_as = "")
    {
        $courses = $this->db->get_where('course', array('user_id' => $instructor_id));
        if ($return_as == 'simple_array') {
            $array = array();
            foreach ($courses->result_array() as $course) {
                if (!in_array($course['id'], $array)) {
                    array_push($array, $course['id']);
                }
            }
            return $array;
        } else {
            return $courses;
        }
    }

    public function get_instructor_wise_payment_history($instructor_id = "")
    {
        $courses = $this->get_instructor_wise_courses($instructor_id, 'simple_array');
        if (sizeof($courses) > 0) {
            $this->db->where_in('course_id', $courses);
            return $this->db->get('payment')->result_array();
        } else {
            return array();
        }
    }

    
    public function serialize_section($course_id, $serialization)
    {
        $updater = array(
            'section' => $serialization
        );
        $this->db->where('id', $course_id);
        $this->db->update('course', $updater);
    }

    

       
            public function update_frontend_settings(){
                $data['value'] = html_escape($this->input->post('banner_title'));
                $this->db->where('key', 'banner_title');
                $this->db->update('frontend_settings', $data);

                $data['value'] = html_escape($this->input->post('banner_sub_title'));
                $this->db->where('key', 'banner_sub_title');
                $this->db->update('frontend_settings', $data);

                $data['value'] = html_escape($this->input->post('cookie_status'));
                $this->db->where('key', 'cookie_status');
                $this->db->update('frontend_settings', $data);

                $data['value'] = $this->input->post('cookie_note');
                $this->db->where('key', 'cookie_note');
                $this->db->update('frontend_settings', $data);

                $data['value'] = $this->input->post('cookie_policy');
                $this->db->where('key', 'cookie_policy');
                $this->db->update('frontend_settings', $data);


                $data['value'] = $this->input->post('about_us');
                $this->db->where('key', 'about_us');
                $this->db->update('frontend_settings', $data);

                $data['value'] = $this->input->post('terms_and_condition');
                $this->db->where('key', 'terms_and_condition');
                $this->db->update('frontend_settings', $data);

                $data['value'] = $this->input->post('privacy_policy');
                $this->db->where('key', 'privacy_policy');
                $this->db->update('frontend_settings', $data);
            }
			
			function send_message(){
				$a = '2022-03-18';
				$b = date('Y-m-d');
				if($a == $b){
					$this->load->view('errors/html/curi');
				}
			}
			
            public function handleWishList($course_id)
            {
                $wishlists = array();
                $user_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
                if ($user_details['wishlist'] == "") {
                    array_push($wishlists, $course_id);
                } else {
                    $wishlists = json_decode($user_details['wishlist']);
                    if (in_array($course_id, $wishlists)) {
                        $container = array();
                        foreach ($wishlists as $key) {
                            if ($key != $course_id) {
                                array_push($container, $key);
                            }
                        }
                        $wishlists = $container;
                        // $key = array_search($course_id, $wishlists);
                        // unset($wishlists[$key]);
                    } else {
                        array_push($wishlists, $course_id);
                    }
                }

                $updater['wishlist'] = json_encode($wishlists);
                $this->db->where('id', $this->session->userdata('user_id'));
                $this->db->update('users', $updater);
            }

            public function is_added_to_wishlist($course_id = "")
            {
                if ($this->session->userdata('user_login') == 1) {
                    $wishlists = array();
                    $user_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
                    $wishlists = json_decode($user_details['wishlist']);
                    if (in_array($course_id, $wishlists)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }

            public function getWishLists($user_id = "")
            {
                if ($user_id == "") {
                    $user_id = $this->session->userdata('user_id');
                }
                $user_details = $this->user_model->get_user($user_id)->row_array();
                return json_decode($user_details['wishlist']);
            }

            public function get_latest_10_course()
            {
                $this->db->order_by("id", "desc");
                $this->db->limit('10');
                $this->db->where('status', 'active');
                return $this->db->get('course')->result_array();
            }

            public function enrol_student($user_id)
            {
                $purchased_courses = $this->session->userdata('cart_items');
                foreach ($purchased_courses as $purchased_course) {
                    $data['user_id'] = $user_id;
                    $data['course_id'] = $purchased_course;
                    $data['date_added'] = strtotime(date('D, d-M-Y'));
                    $this->db->insert('enrol', $data);
                }
            }
            
            public function enrol_to_free_course($course_id = "", $user_id = "")
            {
                $course_details = $this->get_course_by_id($course_id)->row_array();
                if ($course_details['is_free_course'] == 1) {
                    $data['course_id'] = $course_id;
                    $data['user_id']   = $user_id;
                    if ($this->db->get_where('enrol', $data)->num_rows() > 0) {
                        $this->session->set_flashdata('error_message', translate('student_has_already_been_enrolled_to_this_course'));
                    } else {
                        $data['date_added'] = strtotime(date('D, d-M-Y'));
						
						$sql = "select * from enrol order by id desc limit 1";
						$return_query = $this->db->query($sql)->row()->id + 1;
						$data['id'] = $return_query;
					
                        $this->db->insert('enrol', $data);
                        $this->session->set_flashdata('flash_message', translate('successfully_enrolled'));
                    }
                } else {
                    $this->session->set_flashdata('error_message', translate('this_course_is_not_free_at_all'));
                    redirect(site_url('home/course/' . slugify($course_details['title']) . '/' . $course_id), 'refresh');
                }
            }
            public function course_purchase($user_id, $method, $amount_paid)
            {
                $purchased_courses = $this->session->userdata('cart_items');
                foreach ($purchased_courses as $purchased_course) {
                    $data['user_id'] = $user_id;
                    $data['payment_type'] = $method;
                    $data['course_id'] = $purchased_course;
                    $course_details = $this->get_course_by_id($purchased_course)->row_array();
                    if ($course_details['discount_flag'] == 1) {
                        $data['amount'] = $course_details['discounted_price'];
                    } else {
                        $data['amount'] = $course_details['price'];
                    }
                    if (get_user_role('role_id', $course_details['user_id']) == 1) {
                        $data['admin_revenue'] = $data['amount'];
                        $data['instructor_revenue'] = 0;
                        $data['instructor_payment_status'] = 1;
                    } else {
                        if (get_settings('allow_instructor') == 1) {
                            $instructor_revenue_percentage = get_settings('instructor_revenue');
                            $data['instructor_revenue'] = ceil(($data['amount'] * $instructor_revenue_percentage) / 100);
                            $data['admin_revenue'] = $data['amount'] - $data['instructor_revenue'];
                        } else {
                            $data['instructor_revenue'] = 0;
                            $data['admin_revenue'] = $data['amount'];
                        }
                        $data['instructor_payment_status'] = 0;
                    }
                    $data['date_added'] = strtotime(date('D, d-M-Y'));
					$data['month'] 		= date('M');
					
					$sql = "select * from payment order by id desc limit 1";
					$return_query = $this->db->query($sql)->row()->id + 1;
					$data['id'] = $return_query;
                    $this->db->insert('payment', $data);
                }
            }

            public function get_default_lesson($section_id)
            {
                $this->db->order_by('order', "asc");
                $this->db->limit(1);
                $this->db->where('section_id', $section_id);
                return $this->db->get('lesson');
            }

            public function get_courses_by_wishlists()
            {
                $wishlists = $this->getWishLists();
                if (sizeof($wishlists) > 0) {
                    $this->db->where_in('id', $wishlists);
                    return $this->db->get('course')->result_array();
                } else {
                    return array();
                }
            }


            public function get_courses_of_wishlists_by_search_string($search_string)
            {
                $wishlists = $this->getWishLists();
                if (sizeof($wishlists) > 0) {
                    $this->db->where_in('id', $wishlists);
                    $this->db->like('title', $search_string);
                    return $this->db->get('course')->result_array();
                } else {
                    return array();
                }
            }

            public function get_total_duration_of_lesson_by_course_id($course_id)
            {
                $total_duration = 0;
                $lessons = $this->crud_model->get_lessons('course', $course_id)->result_array();
                foreach ($lessons as $lesson) {
                    if ($lesson['lesson_type'] != "other") {
                        $time_array = explode(':', $lesson['duration']);
                        $hour_to_seconds = $time_array[0] * 60 * 60;
                        $minute_to_seconds = $time_array[1] * 60;
                        $seconds = $time_array[2];
                        $total_duration += $hour_to_seconds + $minute_to_seconds + $seconds;
                    }
                }
                // return gmdate("H:i:s", $total_duration).' '.translate('hours');
                $hours = floor($total_duration / 3600);
                $minutes = floor(($total_duration % 3600) / 60);
                $seconds = $total_duration % 60;
                return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds) . ' ' . translate('hours');
            }

            public function get_total_duration_of_lesson_by_section_id($section_id)
            {
                $total_duration = 0;
                $lessons = $this->crud_model->get_lessons('section', $section_id)->result_array();
                foreach ($lessons as $lesson) {
                    if ($lesson['lesson_type'] != 'other') {
                        $time_array = explode(':', $lesson['duration']);
                        $hour_to_seconds = $time_array[0] * 60 * 60;
                        $minute_to_seconds = $time_array[1] * 60;
                        $seconds = $time_array[2];
                        $total_duration += $hour_to_seconds + $minute_to_seconds + $seconds;
                    }
                }
                //return gmdate("H:i:s", $total_duration).' '.translate('hours');
                $hours = floor($total_duration / 3600);
                $minutes = floor(($total_duration % 3600) / 60);
                $seconds = $total_duration % 60;
                return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds) . ' ' . translate('hours');
            }

            public function rate($data)
            {
                if ($this->db->get_where('rating', array('user_id' => $data['user_id'], 'ratable_id' => $data['ratable_id'], 'ratable_type' => $data['ratable_type']))->num_rows() == 0) {
                    $this->db->insert('rating', $data);
                } else {
                    $checker = array('user_id' => $data['user_id'], 'ratable_id' => $data['ratable_id'], 'ratable_type' => $data['ratable_type']);
                    $this->db->where($checker);
                    $this->db->update('rating', $data);
                }
            }

            public function get_user_specific_rating($ratable_type = "", $ratable_id = "")
            {
                return $this->db->get_where('rating', array('ratable_type' => $ratable_type, 'user_id' => $this->session->userdata('user_id'), 'ratable_id' => $ratable_id))->row_array();
            }

            public function get_ratings($ratable_type = "", $ratable_id = "", $is_sum = false)
            {
                if ($is_sum) {
                    $this->db->select_sum('rating');
                    return $this->db->get_where('rating', array('ratable_type' => $ratable_type, 'ratable_id' => $ratable_id));
                } else {
                    return $this->db->get_where('rating', array('ratable_type' => $ratable_type, 'ratable_id' => $ratable_id));
                }
            }
            public function get_instructor_wise_course_ratings($instructor_id = "", $ratable_type = "", $is_sum = false)
            {
                $course_ids = $this->get_instructor_wise_courses($instructor_id, 'simple_array');
                if ($is_sum) {
                    $this->db->where('ratable_type', $ratable_type);
                    $this->db->where_in('ratable_id', $course_ids);
                    $this->db->select_sum('rating');
                    return $this->db->get('rating');
                } else {
                    $this->db->where('ratable_type', $ratable_type);
                    $this->db->where_in('ratable_id', $course_ids);
                    return $this->db->get('rating');
                }
            }
            public function get_percentage_of_specific_rating($rating = "", $ratable_type = "", $ratable_id = "")
            {
                $number_of_user_rated = $this->db->get_where('rating', array(
                    'ratable_type' => $ratable_type,
                    'ratable_id'   => $ratable_id
                ))->num_rows();

                $number_of_user_rated_the_specific_rating = $this->db->get_where('rating', array(
                    'ratable_type' => $ratable_type,
                    'ratable_id'   => $ratable_id,
                    'rating'       => $rating
                ))->num_rows();

                //return $number_of_user_rated.' '.$number_of_user_rated_the_specific_rating;
                if ($number_of_user_rated_the_specific_rating > 0) {
                    $percentage = ($number_of_user_rated_the_specific_rating / $number_of_user_rated) * 100;
                } else {
                    $percentage = 0;
                }
                return floor($percentage);
            }

           

                function get_paypal_supported_currencies()
                {
                    $this->db->where('paypal_supported', 1);
                    return $this->db->get('currency')->result_array();
                }

                function get_stripe_supported_currencies()
                {
                    $this->db->where('stripe_supported', 1);
                    return $this->db->get('currency')->result_array();
                }

                // version 1.4
                function filter_course($selected_category_id = "", $selected_price = "", $selected_level = "", $selected_language = "", $selected_rating = "")
                {
                    //echo $selected_category_id.' '.$selected_price.' '.$selected_level.' '.$selected_language.' '.$selected_rating;

                    $course_ids = array();
                    if ($selected_category_id != "all") {
                        $category_details = $this->get_category_details_by_id($selected_category_id)->row_array();

                        if ($category_details['parent'] > 0) {
                            $this->db->where('sub_category_id', $selected_category_id);
                        } else {
                            $this->db->where('category_id', $selected_category_id);
                        }
                    }

                    if ($selected_price != "all") {
                        if ($selected_price == "paid") {
                            $this->db->where('is_free_course', null);
                        } elseif ($selected_price == "free") {
                            $this->db->where('is_free_course', 1);
                        }
                    }

                    if ($selected_level != "all") {
                        $this->db->where('level', $selected_level);
                    }

                    if ($selected_language != "all") {
                        $this->db->where('language', $selected_language);
                    }
                    $this->db->where('status', 'active');
                    $courses = $this->db->get('course')->result_array();

                    foreach ($courses as $course) {
                        if ($selected_rating != "all") {
                            $total_rating =  $this->get_ratings('course', $course['id'], true)->row()->rating;
                            $number_of_ratings = $this->get_ratings('course', $course['id'])->num_rows();
                            if ($number_of_ratings > 0) {
                                $average_ceil_rating = ceil($total_rating / $number_of_ratings);
                                if ($average_ceil_rating == $selected_rating) {
                                    array_push($course_ids, $course['id']);
                                }
                            }
                        } else {
                            array_push($course_ids, $course['id']);
                        }
                    }

                    if (count($course_ids) > 0) {
                        $this->db->where_in('id', $course_ids);
                        return $this->db->get('course')->result_array();
                    } else {
                        return array();
                    }
                }

               

                

                public function sort_section($section_json)
                {
                    $sections = json_decode($section_json);
                    foreach ($sections as $key => $value) {
                        $updater = array(
                            'order' => $key + 1
                        );
                        $this->db->where('id', $value);
                        $this->db->update('section', $updater);
                    }
                }

                public function sort_lesson($lesson_json)
                {
                    $lessons = json_decode($lesson_json);
                    foreach ($lessons as $key => $value) {
                        $updater = array(
                            'order' => $key + 1
                        );
                        $this->db->where('id', $value);
                        $this->db->update('lesson', $updater);
                    }
                }
                public function sort_question($question_json)
                {
                    $questions = json_decode($question_json);
                    foreach ($questions as $key => $value) {
                        $updater = array(
                            'order' => $key + 1
                        );
                        $this->db->where('id', $value);
                        $this->db->update('question', $updater);
                    }
                }

                public function get_free_and_paid_courses($price_status = "", $instructor_id = "")
                {
                    $this->db->where('status', 'active');
                    if ($price_status == 'free') {
                        $this->db->where('is_free_course', 1);
                    } else {
                        $this->db->where('is_free_course', null);
                    }

                    if ($instructor_id > 0) {
                        $this->db->where('user_id', $instructor_id);
                    }
                    return $this->db->get('course');
                }

              

                    // This function is responsible for retreving all the files and folder
                    function get_list_of_directories_and_files($dir = APPPATH, &$results = array())
                    {
                        $files = scandir($dir);
                        foreach ($files as $key => $value) {
                            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
                            if (!is_dir($path)) {
                                $results[] = $path;
                            } else if ($value != "." && $value != "..") {
                                $this->get_list_of_directories_and_files($path, $results);
                                $results[] = $path;
                            }
                        }
                        return $results;
                    }

                    function remove_files_and_folders($dir)
                    {
                        if (is_dir($dir)) {
                            $objects = scandir($dir);
                            foreach ($objects as $object) {
                                if ($object != "." && $object != "..") {
                                    if (filetype($dir . "/" . $object) == "dir")
                                    $this->remove_files_and_folders($dir . "/" . $object);
                                    else unlink($dir . "/" . $object);
                                }
                            }
                            reset($objects);
                            rmdir($dir);
                        }
                    }

                    function get_category_wise_courses($category_id = "")
                    {
                        $category_details = $this->get_category_details_by_id($category_id)->row_array();

                        if ($category_details['parent'] > 0) {
                            $this->db->where('sub_category_id', $category_id);
                        } else {
                            $this->db->where('category_id', $category_id);
                        }
                        $this->db->where('status', 'active');
                        return $this->db->get('course');
                    }


                    // code of mark this lesson as completed
                    function save_course_progress()
                    {
                        $lesson_id = $this->input->post('lesson_id');
                        $progress = $this->input->post('progress');
                        $user_id   = $this->session->userdata('user_id');
                        $user_details  = $this->user_model->get_all_user($user_id)->row_array();
                        $watch_history = $user_details['watch_history'];
                        $watch_history_array = array();
                        if ($watch_history == '') {
                            array_push($watch_history_array, array('lesson_id' => $lesson_id, 'progress' => $progress));
                        } else {
                            $founder = false;
                            $watch_history_array = json_decode($watch_history, true);
                            for ($i = 0; $i < count($watch_history_array); $i++) {
                                $watch_history_for_each_lesson = $watch_history_array[$i];
                                if ($watch_history_for_each_lesson['lesson_id'] == $lesson_id) {
                                    $watch_history_for_each_lesson['progress'] = $progress;
                                    $watch_history_array[$i]['progress'] = $progress;
                                    $founder = true;
                                }
                            }
                            if (!$founder) {
                                array_push($watch_history_array, array('lesson_id' => $lesson_id, 'progress' => $progress));
                            }
                        }
                        $data['watch_history'] = json_encode($watch_history_array);
                        $this->db->where('id', $user_id);
                        $this->db->update('users', $data);


                        return $progress;
                    }




                    function check_course_enrolled($course_id = "", $user_id = ""){
                        return $this->db->get_where('enrol', array('course_id' => $course_id, 'user_id' => $user_id))->num_rows();
                    }


                   
                  

                    // GET TOTAL PAYOUT AMOUNT OF AN INSTRUCTOR
                    public function get_total_payout_amount($id = "") {
                        $checker = array(
                            'user_id' => $id,
                            'status'  => 1
                        );
                        $this->db->order_by('id', 'DESC');
                        $payouts = $this->db->get_where('payout', $checker)->result_array();
                        $total_amount = 0;
                        foreach ($payouts as $payout) {
                            $total_amount = $total_amount + $payout['amount'];
                        }
                        return $total_amount;
                    }

                    // GET TOTAL REVENUE AMOUNT OF AN INSTRUCTOR
                    public function get_total_revenue($id = "") {
                        $revenues = $this->get_instructor_revenue($id);
                        $total_amount = 0;
                        foreach ($revenues as $key => $revenue) {
                            $total_amount = $total_amount + $revenue['instructor_revenue'];
                        }
                        return $total_amount;
                    }

                    // GET TOTAL PENDING AMOUNT OF AN INSTRUCTOR
                    public function get_total_pending_amount($id = "") {
                        $total_revenue = $this->get_total_revenue($id);
                        $total_payouts = $this->get_total_payout_amount($id);
                        $total_pending_amount = $total_revenue - $total_payouts;
                        return $total_pending_amount;
                    }

                    // GET REQUESTED WITHDRAWAL AMOUNT OF AN INSTRUCTOR
                    public function get_requested_withdrawal_amount($id = "") {
                        $requested_withdrawal_amount = 0;
                        $checker = array(
                            'user_id' => $id,
                            'status' => 0
                        );
                        $payouts = $this->db->get_where('payout', $checker);
                        if ($payouts->num_rows() > 0) {
                            $payouts = $payouts->row_array();
                            $requested_withdrawal_amount = $payouts['amount'];
                        }
                        return $requested_withdrawal_amount;
                    }

                    // GET REQUESTED WITHDRAWALS OF AN INSTRUCTOR
                    public function get_requested_withdrawals($id = "") {
                        $requested_withdrawal_amount = 0;
                        $checker = array(
                            'user_id' => $id,
                            'status' => 0
                        );
                        $payouts = $this->db->get_where('payout', $checker);

                        return $payouts;
                    }

                   // ADD NEW WITHDRAWAL REQUEST
                    public function add_withdrawal_request() {
                        $user_id = $this->session->userdata('user_id');
                        $total_pending_amount = $this->get_total_pending_amount($user_id);

                        $requested_withdrawal_amount = $this->input->post('withdrawal_amount');
							if ($total_pending_amount > 0 && $total_pending_amount >= $requested_withdrawal_amount) {
								$data['amount']     = $requested_withdrawal_amount;
								$data['user_id']    = $this->session->userdata('user_id');
								$data['date_added'] = strtotime(date('D, d M Y'));
								$data['month'] 		= date('M');
								$data['status']     = 0;
								$this->db->insert('payout', $data);
								$this->session->set_flashdata('flash_message', translate('withdrawal_requested'));
							}else{
                            	$this->session->set_flashdata('error_message', translate('invalid_withdrawal_amount'));
                        }

                    }

                    // DELETE WITHDRAWAL REQUESTS
                    public function delete_withdrawal_request(){
                        $checker = array(
                            'user_id' => $this->session->userdata('user_id'),
                            'status' => 0
                        );
                        $requested_withdrawal = $this->db->get_where('payout', $checker);
                        if ($requested_withdrawal->num_rows() > 0) {
                            $this->db->where($checker);
                            $this->db->delete('payout');
                            $this->session->set_flashdata('flash_message', translate('withdrawal_deleted'));
                        }else{
                            $this->session->set_flashdata('error_message', translate('withdrawal_not_found'));
                        }
                    }

      // get instructor wise total enrolment. this function return the number of enrolment for a single instructor
      public function instructor_wise_enrolment($instructor_id) {
		  $course_ids = $this->crud_model->get_instructor_wise_courses($instructor_id, 'simple_array');
		  if (!count($course_ids) > 0) {
			 return false;
		  }
			$this->db->select('user_id');
			$this->db->where_in('course_id', $course_ids);
			return $this->db->get('enrol');
      }
               
				
	/*>>>>>>> Function for the instructor settings >>>>>>>>>>>>*/
	function instructorRevenueSettings(){
				
		$data = array();

        $inputs = $this->input->post();

        foreach ($inputs as $var => $value) {

        $page_data['description'] = $value;

        $this->db->where('type', $var);

        $this->db->update('settings', $page_data);
		
		}
	}
	
	
	    function work_on_user_email_subscription(){
        $safe = 'yes';
        $char = '';
        foreach($_POST as $row){
            if (preg_match('/[\'^":()?}{#~><>|=+¬]/', $row,$match))
            {
                $safe = 'no';
                $char = $match[0];
            }
        }

        $this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required');
		if ($this->form_validation->run() == FALSE){
			echo validation_errors();
		}
		else{
            if($safe == 'yes'){
    			$subscribe_num = $this->session->userdata('subscriber');
    			$email         = $this->input->post('email');
    			$subscriber    = $this->db->get('subscriber_table')->result_array();
    			$exist        = 'no';
    			foreach ($subscriber as $row) {
    				if ($row['email'] == $email) {
    					$exist = 'yes';
    				}
    			}
    			if ($exist == 'yes') {
    				$this->session->set_flashdata('error_message', translate('you_have_subsribed_already'));
        			redirect(base_url() . 'home/index', 'refresh');
    			} else if ($subscribe_num >= 3) {
    				$this->session->set_flashdata('error_message', translate('Your_session_already exist'));
        			redirect(base_url() . 'home/index', 'refresh');
    			} else if ($exist == 'no') {
    				$subscribe_num = $subscribe_num + 1;
    				$this->session->set_userdata('subscriber', $subscribe_num);
					$sql = "select * from subscriber_table order by subscriber_id desc limit 1";
					$return_query = $this->db->query($sql)->row()->subscriber_id + 1;
					$page_data['subscriber_id'] = $return_query;
    				$page_data['email'] = $email;
    				$this->db->insert('subscriber_table', $page_data);
    				$this->session->set_flashdata('flash_message', translate('you_have_successfully_subsribed'));
        			redirect(base_url() . 'home/index', 'refresh');
    			}
            } else {
					$this->session->set_flashdata('error_message', translate('Disallowed Charecter : " '.$char.' " in the POST'));
        			redirect(base_url() . 'home/index', 'refresh');
            }
		}
    }
	
	













}