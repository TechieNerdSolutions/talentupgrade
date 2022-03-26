<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct(){
        parent::__construct();
  
        $this->load->database();
        $this->load->library('session');
		
		
        // $this->load->library('stripe');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');

        /*>>>>>>> { Check session info here }  >>>>>>>>>>>>*/
        $this->session_data();
    }
	
	
	

	/*>>>>>>> { Method for home index }  >>>>>>>>>>>>*/
    public function index() {
        $this->home();
    }




	/*>>>>>>> { Method for home page }  >>>>>>>>>>>>*/
    public function home() {
        $page_data['page_name'] = "home";
        $page_data['page_title'] = translate('home');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
	
    public function news() {
	
		$count_notice = $this->db->get('news')->num_rows();
		$config = array();
		$config = pagintaion($count_notice, 3 );
		$config['base_url']  = base_url().'home/news/';
		$this->pagination->initialize($config);
		$page_data['per_page']    = $config['per_page'];

        $page_data['page_name'] = "all_news";
        $page_data['page_title'] = translate('all_news');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
	
    public function news_details($slug) {
        $page_data['page_name'] 	= "news_details";
		$page_data['load_data'] 	= $slug;
        $page_data['page_title'] 	= translate('news_details');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
	
	
	public function subscriber(){
        $this->crud_model->work_on_user_email_subscription();
    }
	
	
	
	/*>>>>>>> { Function to manage shopping cart }  >>>>>>>>>>>>*/
    public function shopping_cart() {
        if (!$this->session->userdata('cart_items')) {
            $this->session->set_userdata('cart_items', array());
        }
        $page_data['page_name'] = "shopping_cart";
        $page_data['page_title'] = translate('shopping_cart');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
	
	
	
	
	/*>>>>>>> { Function to manage courses  }  >>>>>>>>>>>>*/
    public function courses() {
        if (!$this->session->userdata('layout')) {
            $this->session->set_userdata('layout', 'list');
        }
        $layout = $this->session->userdata('layout');
        $selected_category_id = "all";
        $selected_price = "all";
        $selected_level = "all";
        $selected_language = "all";
        $selected_rating = "all";
        // Get the category ids
        if (isset($_GET['category']) && !empty($_GET['category'] && $_GET['category'] != "all")) {
            $selected_category_id = $this->crud_model->get_category_id($_GET['category']);
        }

        // Get the selected price
        if (isset($_GET['price']) && !empty($_GET['price'])) {
            $selected_price = $_GET['price'];
        }

        // Get the selected level
        if (isset($_GET['level']) && !empty($_GET['level'])) {
            $selected_level = $_GET['level'];
        }

        // Get the selected language
        if (isset($_GET['language']) && !empty($_GET['language'])) {
            $selected_language = $_GET['language'];
        }

        // Get the selected rating
        if (isset($_GET['rating']) && !empty($_GET['rating'])) {
            $selected_rating = $_GET['rating'];
        }


        if ($selected_category_id == "all" && $selected_price == "all" && $selected_level == 'all' && $selected_language == 'all' && $selected_rating == 'all') {
            $this->db->where('status', 'active');
            $total_rows = $this->db->get('course')->num_rows();
            $config = array();
            $config = pagintaion($total_rows, 6);
            $config['base_url']  = site_url('home/courses/');
            $this->pagination->initialize($config);
            $this->db->where('status', 'active');
            $page_data['courses'] = $this->db->get('course', $config['per_page'], $this->uri->segment(3))->result_array();
        }else {
            $courses = $this->crud_model->filter_course($selected_category_id, $selected_price, $selected_level, $selected_language, $selected_rating);
            $page_data['courses'] = $courses;
        }

        $page_data['page_name']  				= "courses_page";
        $page_data['page_title'] 				= translate('courses');
        $page_data['layout']     				= $layout;
        $page_data['selected_category_id']     	= $selected_category_id;
        $page_data['selected_price']     		= $selected_price;
        $page_data['selected_level']     		= $selected_level;
        $page_data['selected_language']     	= $selected_language;
        $page_data['selected_rating']     		= $selected_rating;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
	
	
	
	/*>>>>>>> { Function to set layout session }  >>>>>>>>>>>>*/
    public function set_layout_to_session() {
        $layout = $this->input->post('layout');
        $this->session->set_userdata('layout', $layout);
    }
	
	
	
	/*>>>>>>> { Function to manage course slug }  >>>>>>>>>>>>*/
    public function course($slug = "", $course_id = "") {
        $this->access_denied_courses($course_id);
        $page_data['course_id'] = $course_id;
        $page_data['page_name'] = "course_page";
        $page_data['page_title'] = translate('course');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }




	/*>>>>>>> { Function to manage instructor page }  >>>>>>>>>>>>*/
    public function instructor_page($instructor_id = "") {
        $page_data['page_name'] = "instructor_page";
        $page_data['page_title'] = translate('instructor_page');
        $page_data['instructor_id'] = $instructor_id;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
	
	
	
	/*>>>>>>> { Function to manage my courses }  >>>>>>>>>>>>*/
    public function my_courses() {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('home'), 'refresh');
        }

        $page_data['page_name'] = "my_courses";
        $page_data['page_title'] = translate("my_courses");
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
	
	
	
	/*>>>>>>> { Function to manage student and instructor message }  >>>>>>>>>>>>*/
    public function my_messages($param1 = "", $param2 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('home'), 'refresh');
        }
        if ($param1 == 'read_message') {
            $page_data['message_thread_code'] = $param2;
        }
        elseif ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', translate('message_sent'));
            redirect(site_url('home/my_messages/read_message/' . $message_thread_code), 'refresh');
        }
        elseif ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message($param2); //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', translate('message_sent'));
            redirect(site_url('home/my_messages/read_message/' . $param2), 'refresh');
        }
        $page_data['page_name'] = "my_messages";
        $page_data['page_title'] = translate('my_messages');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
	
	
	
	
	/*>>>>>>> { Function to manage notifications }  >>>>>>>>>>>>*/
    public function my_notifications() {
        $page_data['page_name'] = "my_notifications";
        $page_data['page_title'] = translate('my_notifications');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
	
	
	
	/*>>>>>>> { Function to manage student wishlist }  >>>>>>>>>>>>*/
    public function my_wishlist() {
        if (!$this->session->userdata('cart_items')) {
            $this->session->set_userdata('cart_items', array());
        }
        $my_courses = $this->crud_model->get_courses_by_wishlists();
        $page_data['my_courses'] = $my_courses;
        $page_data['page_name'] = "my_wishlist";
        $page_data['page_title'] = translate('my_wishlist');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
	
	
	
	
	/*>>>>>>> { Function for purchase history }  >>>>>>>>>>>>*/
    public function purchase_history() {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('home'), 'refresh');
        }

        $total_rows = $this->crud_model->purchase_history($this->session->userdata('user_id'))->num_rows();
        $config = array();
        $config = pagintaion($total_rows, 10);
        $config['base_url']  = site_url('home/purchase_history');
        $this->pagination->initialize($config);
        $page_data['per_page']   = $config['per_page'];

        $page_data['page_name']  = "purchase_history";
        $page_data['page_title'] = translate('purchase_history');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
	
	
	
	
	/*>>>>>>> { Function for student's profile }  >>>>>>>>>>>>*/
    public function profile($param1 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('home'), 'refresh');
        }

        if ($param1 == 'user_profile') {
            $page_data['page_name'] = "user_profile";
            $page_data['page_title'] = translate('user_profile');
        }elseif ($param1 == 'user_credentials') {
            $page_data['page_name'] = "user_credentials";
            $page_data['page_title'] = translate('credentials');
        }elseif ($param1 == 'user_photo') {
            $page_data['page_name'] = "update_user_photo";
            $page_data['page_title'] = translate('update_user_photo');
        }
        $page_data['user_details'] = $this->user_model->get_user($this->session->userdata('user_id'));
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
	
	
	
	/*>>>>>>> { Function for updating student's profile }  >>>>>>>>>>>>*/
    public function update_profile($param1 = "") {
        if ($param1 == 'update_basics') {
            $this->user_model->edit_user($this->session->userdata('user_id'));
            redirect(site_url('home/profile/user_profile'), 'refresh');
        }elseif ($param1 == "update_credentials") {
            $this->user_model->update_account_settings($this->session->userdata('user_id'));
            redirect(site_url('home/profile/user_credentials'), 'refresh');
        }elseif ($param1 == "update_photo") {
            $this->user_model->upload_user_image($this->session->userdata('user_id'));
            $this->session->set_flashdata('flash_message', translate('updated_successfully'));
            redirect(site_url('home/profile/user_photo'), 'refresh');
        }

    }


	/*>>>>>>> { Function that handles student wishlist }  >>>>>>>>>>>>*/
    public function handleWishList($return_number = "") {
        if ($this->session->userdata('user_login') != 1) {
            echo false;
        }else {
            if (isset($_POST['course_id'])) {
                $course_id = $this->input->post('course_id');
                $this->crud_model->handleWishList($course_id);
            }
            if($return_number == 'true'){
                echo sizeof($this->crud_model->getWishLists());
            }else{
                $this->load->view('frontend/'.get_frontend_settings('theme').'/wishlist_items');
            }
        }
    }
	
	
	
	/*>>>>>>> { Function that handle CartItems }  >>>>>>>>>>>>*/
    public function handleCartItems($return_number = "") {
        if (!$this->session->userdata('cart_items')) {
            $this->session->set_userdata('cart_items', array());
        }

        $course_id = $this->input->post('course_id');
        $previous_cart_items = $this->session->userdata('cart_items');
        if (in_array($course_id, $previous_cart_items)) {
            $key = array_search($course_id, $previous_cart_items);
            unset($previous_cart_items[$key]);
        }else {
            array_push($previous_cart_items, $course_id);
        }

        $this->session->set_userdata('cart_items', $previous_cart_items);
        if($return_number == 'true'){
            echo sizeof($previous_cart_items);
        }else{
            $this->load->view('frontend/'.get_frontend_settings('theme').'/cart_items');
        }
    }



	/*>>>>>>> { Function that handle cart items by buttons click  }  >>>>>>>>>>>>*/
    public function handleCartItemForBuyNowButton() {
        if (!$this->session->userdata('cart_items')) {
            $this->session->set_userdata('cart_items', array());
        }

        $course_id = $this->input->post('course_id');
        $previous_cart_items = $this->session->userdata('cart_items');
        if (!in_array($course_id, $previous_cart_items)) {
            array_push($previous_cart_items, $course_id);
        }
        $this->session->set_userdata('cart_items', $previous_cart_items);
        $this->load->view('frontend/'.get_frontend_settings('theme').'/cart_items');
    }
	
	
	
	/*>>>>>>> { Function to refresh wishlist  }  >>>>>>>>>>>>*/
    public function refreshWishList() {
        $this->load->view('frontend/'.get_frontend_settings('theme').'/wishlist_items');
    }




	/*>>>>>>> { Function that refreshes shopping cart  }  >>>>>>>>>>>>*/
    public function refreshShoppingCart() {
        $this->load->view('frontend/'.get_frontend_settings('theme').'/shopping_cart_inner_view');
    }



	/*>>>>>>> { Function that checks if user is login  }  >>>>>>>>>>>>*/
    public function isLoggedIn() {
        if ($this->session->userdata('user_login') == 1)
        echo true;
        else
        echo false;
    }
	
	

   /*>>>>>>> { Function that helps to chose a payment gateway  }  >>>>>>>>>>>>*/
    public function payment(){
        if ($this->session->userdata('user_login') != 1)
        redirect('login', 'refresh');

        $page_data['total_price_of_checking_out'] = $this->session->userdata('total_price_of_checking_out');
        $page_data['page_title'] = translate("payment_gateway");
        $this->load->view('payment/index', $page_data);
    }
	
	
	

	
	

	 /*>>>>>>> { Function for managing lesson  }  >>>>>>>>>>>>*/
    public function lesson($slug = "", $course_id = "", $lesson_id = "") {
        if ($this->session->userdata('user_login') != 1){
            if ($this->session->userdata('admin_login') != 1){
                redirect('home', 'refresh');
            }
        }

        $course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
        $sections = $this->crud_model->get_section('course', $course_id);
        if ($sections->num_rows() > 0) {
            $page_data['sections'] = $sections->result_array();
            if ($lesson_id == "") {
                $default_section = $sections->row_array();
                $page_data['section_id'] = $default_section['id'];
                $lessons = $this->crud_model->get_lessons('section', $default_section['id']);
                if ($lessons->num_rows() > 0) {
                    $default_lesson = $lessons->row_array();
                    $lesson_id = $default_lesson['id'];
                    $page_data['lesson_id']  = $default_lesson['id'];
                }else {
                    $page_data['page_name'] = 'empty';
                    $page_data['page_title'] = translate('no_lesson_found');
                    $page_data['page_body'] = translate('no_lesson_found');
                }
            }else {
                $page_data['lesson_id']  = $lesson_id;
                $section_id = $this->db->get_where('lesson', array('id' => $lesson_id))->row()->section_id;
                $page_data['section_id'] = $section_id;
            }

        }else {
            $page_data['sections'] = array();
            $page_data['page_name'] = 'empty';
            $page_data['page_title'] = translate('no_section_found');
            $page_data['page_body'] = translate('no_section_found');
        }

        // Check if the lesson contained course is purchased by the user
        if (isset($page_data['lesson_id']) && $page_data['lesson_id'] > 0) {
            $lesson_details = $this->crud_model->get_lessons('lesson', $page_data['lesson_id'])->row_array();
            $lesson_id_wise_course_details = $this->crud_model->get_course_by_id($lesson_details['course_id'])->row_array();
            if ($this->session->userdata('role_id') != 1 && $lesson_id_wise_course_details['user_id'] != $this->session->userdata('user_id')) {
                if (!is_purchased($lesson_details['course_id'])) {
                    redirect(site_url('home/course/'.slugify($course_details['title']).'/'.$course_details['id']), 'refresh');
                }
            }
        }else {
            if (!is_purchased($course_id)) {
                redirect(site_url('home/course/'.slugify($course_details['title']).'/'.$course_details['id']), 'refresh');
            }
        }

        $page_data['course_id']  = $course_id;
        $page_data['page_name']  = 'lessons';
        $page_data['page_title'] = $course_details['title'];
        $this->load->view('lessons/index', $page_data);
    }
	
	
	
	
	 /*>>>>>>> { Function to manage course by category }  >>>>>>>>>>>>*/
    public function my_courses_by_category() {
        $category_id = $this->input->post('category_id');
        $course_details = $this->crud_model->get_my_courses_by_category_id($category_id)->result_array();
        $page_data['my_courses'] = $course_details;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/reload_my_courses', $page_data);
    }




	 /*>>>>>>> { Function for searching courses  }  >>>>>>>>>>>>*/
    public function search($search_string = "") {
        if (isset($_GET['query']) && !empty($_GET['query'])) {
            $search_string = $_GET['query'];
            $page_data['courses'] = $this->crud_model->get_courses_by_search_string($search_string)->result_array();
        }else {
            $this->session->set_flashdata('error_message', translate('no_search_value_found'));
            redirect(site_url(), 'refresh');
        }

        if (!$this->session->userdata('layout')) {
            $this->session->set_userdata('layout', 'list');
        }
        $page_data['layout']     = $this->session->userdata('layout');
        $page_data['page_name'] = 'courses_page';
        $page_data['search_string'] = $search_string;
        $page_data['page_title'] = translate('search_results');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
	
	
	
	
	
	/*>>>>>>> { Function for searching courses  }  >>>>>>>>>>>>*/
    public function my_courses_by_search_string() {
        $search_string = $this->input->post('search_string');
        $course_details = $this->crud_model->get_my_courses_by_search_string($search_string)->result_array();
        $page_data['my_courses'] = $course_details;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/reload_my_courses', $page_data);
    }



	 /*>>>>>>> { Function for searching courses  }  >>>>>>>>>>>>*/
    public function get_my_wishlists_by_search_string() {
        $search_string = $this->input->post('search_string');
        $course_details = $this->crud_model->get_courses_of_wishlists_by_search_string($search_string);
        $page_data['my_courses'] = $course_details;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/reload_my_wishlists', $page_data);
    }



	 /*>>>>>>> { Function for searching courses  }  >>>>>>>>>>>>*/
    public function reload_my_wishlists() {
        $my_courses = $this->crud_model->get_courses_by_wishlists();
        $page_data['my_courses'] = $my_courses;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/reload_my_wishlists', $page_data);
    }



	 /*>>>>>>> { Function to get course details  }  >>>>>>>>>>>>*/
    public function get_course_details() {
        $course_id = $this->input->post('course_id');
        $course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
        echo $course_details['title'];
    }


	 /*>>>>>>> { Function to reate instructor course  }  >>>>>>>>>>>>*/
    public function rate_course() {
        $data['review'] = $this->input->post('review');
        $data['ratable_id'] = $this->input->post('course_id');
        $data['ratable_type'] = 'course';
        $data['rating'] = $this->input->post('starRating');
        $data['date_added'] = strtotime(date('D, d-M-Y'));
        $data['user_id'] = $this->session->userdata('user_id');
        $this->crud_model->rate($data);
    }



	/*>>>>>>> { Function for managing about us  }  >>>>>>>>>>>>*/
    public function about_us() {
        $page_data['page_name'] = 'about_us';
        $page_data['page_title'] = translate('about_us');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }





	/*>>>>>>> { Function for managing terms and condition  }  >>>>>>>>>>>>*/
    public function terms_and_condition() {
        $page_data['page_name'] = 'terms_and_condition';
        $page_data['page_title'] = translate('terms_and_condition');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
	
	
	
	
	/*>>>>>>> { Function for managing privacy policy  }  >>>>>>>>>>>>*/
    public function privacy_policy() {
        $page_data['page_name'] = 'privacy_policy';
        $page_data['page_title'] = translate('privacy_policy');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
	
	
	
	
	/*>>>>>>> { Function for managing cookie policy  }  >>>>>>>>>>>>*/
    public function cookie_policy() {
        $page_data['page_name'] = 'cookie_policy';
        $page_data['page_title'] = translate('cookie_policy');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }





    /*>>>>>>> { Function helps to load instructor dashboard }  >>>>>>>>>>>>*/
    public function dashboard($param1 = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }

        if ($param1 == "") {
            $page_data['type'] = 'active';
        }else {
            $page_data['type'] = $param1;
        }

        $page_data['page_name']  = 'instructor_dashboard';
        $page_data['page_title'] = translate('instructor_dashboard');
        $page_data['user_id']    = $this->session->userdata('user_id');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
	
	
	
	
	
	/*>>>>>>> { Function that helps to create course  }  >>>>>>>>>>>>*/
    public function create_course() {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }

        $page_data['page_name'] = 'create_course';
        $page_data['page_title'] = translate('create_course');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }




	/*>>>>>>> { Function that helps to edit course  }  >>>>>>>>>>>>*/
    public function edit_course($param1 = "", $param2 = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }

        if ($param2 == "") {
            $page_data['type']   = 'edit_course';
        }else {
            $page_data['type']   = $param2;
        }
        $page_data['page_name']  = 'manage_course_details';
        $page_data['course_id']  = $param1;
        $page_data['page_title'] = translate('edit_course');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }
	
	
	
	
	
	
	/*>>>>>>> { Function that helps to create section  }  >>>>>>>>>>>>*/
    public function course_action($param1 = "", $param2 = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }

        if ($param1 == 'create') {
            if (isset($_POST['create_course'])) {
                $this->crud_model->add_course();
                redirect(site_url('home/create_course'), 'refresh');
            }else {
                $this->crud_model->add_course('save_to_draft');
                redirect(site_url('home/create_course'), 'refresh');
            }
        }elseif ($param1 == 'edit') {
            if (isset($_POST['publish'])) {
                $this->crud_model->update_course($param2, 'publish');
                redirect(site_url('home/dashboard'), 'refresh');
            }else {
                $this->crud_model->update_course($param2, 'save_to_draft');
                redirect(site_url('home/dashboard'), 'refresh');
            }
        }
    }
	
	
	
	
	/*>>>>>>> { Function that helps to manage sections  }  >>>>>>>>>>>>*/
    public function sections($action = "", $course_id = "", $section_id = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }

        if ($action == "add") {
            $this->crud_model->add_section($course_id);

        }elseif ($action == "edit") {
            $this->crud_model->edit_section($section_id);

        }elseif ($action == "delete") {
            $this->crud_model->delete_section($course_id, $section_id);
            $this->session->set_flashdata('flash_message', translate('section_deleted'));
            redirect(site_url("home/edit_course/$course_id/manage_section"), 'refresh');

        }elseif ($action == "serialize_section") {
            $container = array();
            $serialization = json_decode($this->input->post('updatedSerialization'));
            foreach ($serialization as $key) {
                array_push($container, $key->id);
            }
            $json = json_encode($container);
            $this->crud_model->serialize_section($course_id, $json);
        }
        $page_data['course_id'] = $course_id;
        $page_data['course_details'] = $this->crud_model->get_course_by_id($course_id)->row_array();
        return $this->load->view('frontend/'.get_frontend_settings('theme').'/reload_section', $page_data);
    }



	/*>>>>>>> { Function that helps to manage sections  }  >>>>>>>>>>>>*/
    public function manage_lessons($action = "", $course_id = "", $lesson_id = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }
        if ($action == 'add') {
            $this->crud_model->add_lesson();
            $this->session->set_flashdata('flash_message', translate('lesson_added'));
        }
        elseif ($action == 'edit') {
            $this->crud_model->edit_lesson($lesson_id);
            $this->session->set_flashdata('flash_message', translate('lesson_updated'));
        }
        elseif ($action == 'delete') {
            $this->crud_model->delete_lesson($lesson_id);
            $this->session->set_flashdata('flash_message', translate('lesson_deleted'));
        }
        redirect('home/edit_course/'.$course_id.'/manage_lesson');
    }



	/*>>>>>>> { Function that helps to edit lessons  }  >>>>>>>>>>>>*/
    public function lesson_editing_form($lesson_id = "", $course_id = "") {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }
        $page_data['type']      = 'manage_lesson';
        $page_data['course_id'] = $course_id;
        $page_data['lesson_id'] = $lesson_id;
        $page_data['page_name']  = 'lesson_edit';
        $page_data['page_title'] = translate('update_lesson');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }




	/*>>>>>>> { Function that helps to download file  }  >>>>>>>>>>>>*/
    public function download($filename = "") {
        $tmp           = explode('.', $filename);
        $fileExtension = strtolower(end($tmp));
        $yourFile = base_url().'uploads/lesson_files/'.$filename;
        $file = @fopen($yourFile, "rb");

        header('Content-Description: File Transfer');
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename='.$filename);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($yourFile));
        while (!feof($file)) {
            print(@fread($file, 1024 * 8));
            ob_flush();
            flush();
        }
    }





	/*>>>>>>> { Function that helps to submit set quiz questions  }  >>>>>>>>>>>>*/
    public function submit_quiz($from = "") {
        $submitted_quiz_info = array();
        $container = array();
        $quiz_id = $this->input->post('lesson_id');
        $quiz_questions = $this->crud_model->get_quiz_questions($quiz_id)->result_array();
        $total_correct_answers = 0;
        foreach ($quiz_questions as $quiz_question) {
            $submitted_answer_status = 0;
            $correct_answers = json_decode($quiz_question['correct_answers']);
            $submitted_answers = array();
            foreach ($this->input->post($quiz_question['id']) as $each_submission) {
                if (isset($each_submission)) {
                    array_push($submitted_answers, $each_submission);
                }
            }
            sort($correct_answers);
            sort($submitted_answers);
            if ($correct_answers == $submitted_answers) {
                $submitted_answer_status = 1;
                $total_correct_answers++;
            }
            $container = array(
                "question_id" => $quiz_question['id'],
                'submitted_answer_status' => $submitted_answer_status,
                "submitted_answers" => json_encode($submitted_answers),
                "correct_answers"  => json_encode($correct_answers),
            );
            array_push($submitted_quiz_info, $container);
        }
        $page_data['submitted_quiz_info']   = $submitted_quiz_info;
        $page_data['total_correct_answers'] = $total_correct_answers;
        $page_data['total_questions'] = count($quiz_questions);
        if ($from == 'mobile') {
            $this->load->view('mobile/quiz_result', $page_data);
        }else{
            $this->load->view('lessons/quiz_result', $page_data);
        }
    }





	/*>>>>>>> { Function that helps to denied courses  }  >>>>>>>>>>>>*/
    private function access_denied_courses($course_id){
        $course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
        if ($course_details['status'] == 'draft' && $course_details['user_id'] != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error_message', translate('you_do_not_have_permission_to_access_this_course'));
            redirect(site_url('home'), 'refresh');
        }elseif ($course_details['status'] == 'pending') {
            if ($course_details['user_id'] != $this->session->userdata('user_id') && $this->session->userdata('role_id') != 1) {
                $this->session->set_flashdata('error_message', translate('you_do_not_have_permission_to_access_this_course'));
                redirect(site_url('home'), 'refresh');
            }
        }
    }




	/*>>>>>>> { Function that helps to manage invoice  }  >>>>>>>>>>>>*/
    public function invoice($purchase_history_id = '') {
        if ($this->session->userdata('user_login') != 1){
            redirect('home', 'refresh');
        }
        $purchase_history = $this->crud_model->get_payment_details_by_id($purchase_history_id);
        if ($purchase_history['user_id'] != $this->session->userdata('user_id')) {
            redirect('home', 'refresh');
        }
        $page_data['payment_info'] = $purchase_history;
        $page_data['page_name'] = 'invoice';
        $page_data['page_title'] = 'invoice';
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }






	/*>>>>>>> { Function that helps to load ERROR 404 Page not found  }  >>>>>>>>>>>>*/
    public function page_not_found() {
        $page_data['page_name'] = '404';
        $page_data['page_title'] = translate('404_page_not_found');
        $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    }





	/*>>>>>>> { Function that helps to check for course progress  }  >>>>>>>>>>>>*/
    function check_course_progress($course_id) {
        echo course_progress($course_id);
    }
	
	
	
	

	/*>>>>>>> { This is the function for rendering quiz web view for mobile }  >>>>>>>>>>>>*/
    public function quiz_mobile_web_view($lesson_id = "") {
        $data['lesson_details'] = $this->crud_model->get_lessons('lesson', $lesson_id)->row_array();
        $data['page_name'] = 'quiz';
        $this->load->view('mobile/index', $data);
    }


    // CHECK CUSTOM SESSION DATA
    public function session_data() {
        // SESSION DATA FOR CART
        if (!$this->session->userdata('cart_items')) {
            $this->session->set_userdata('cart_items', array());
        }

        // SESSION DATA FOR FRONTEND LANGUAGE
        if (!$this->session->userdata('language')) {
            $this->session->set_userdata('language', get_settings('language'));
        }

    }

    // SETTING FRONTEND LANGUAGE
    public function site_language() {
        $selected_language = $this->input->post('language');
        $this->session->set_userdata('language', $selected_language);
        echo true;
    }
	
	
	
	
 /*>>>>>>> { Function that show stripe payment gateway  }  >>>>>>>>>>>>*/
    public function stripe_checkout($payment_request = "") {
        if ($this->session->userdata('user_login') != 1 && $payment_request != 'true')
        redirect('home', 'refresh');

        //checking price
        if($this->session->userdata('total_price_of_checking_out') == $this->input->post('total_price_of_checking_out')):
            $total_price_of_checking_out = $this->input->post('total_price_of_checking_out');
        else:
            $total_price_of_checking_out = $this->session->userdata('total_price_of_checking_out');
        endif;
        $page_data['payment_request'] = $payment_request;
        $page_data['user_details']    = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
        $page_data['amount_to_pay']   = $total_price_of_checking_out;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/stripe_checkout', $page_data);
    }
	
	
	




    /*>>>>>>> { Function for stripe checkout action  }  >>>>>>>>>>>>*/
    public function stripe_payment($user_id = "", $amount_paid = "", $payment_request_mobile = "") {

        $token_id = $this->input->post('stripeToken');
        $stripe_keys = get_settings('stripe_keys');
        $values = json_decode($stripe_keys);
        if ($values[0]->testmode == 'on') {
            $public_key = $values[0]->public_key;
            $secret_key = $values[0]->secret_key;
        } else {
            $public_key = $values[0]->public_live_key;
            $secret_key = $values[0]->secret_live_key;
        }

        //THIS IS HOW I CHECKED THE STRIPE PAYMENT STATUS
        $status = $this->payment_model->stripe_payment($token_id, $user_id, $amount_paid, $secret_key);
        if (!$status) {
            $this->session->set_flashdata('error_message', translate('an_error_occurred_during_payment'));
            redirect('home', 'refresh');
        }

        $this->crud_model->enrol_student($user_id);
        $this->crud_model->course_purchase($user_id, 'stripe', $amount_paid);
        $this->email_model->course_purchase_notification($user_id, 'stripe', $amount_paid);
		$this->session->unset_userdata('cart_items');
		$this->session->set_flashdata('flash_message', translate('payment_successfully_done'));
		redirect('home/my_courses', 'refresh');
    }
	
	
	
	
	
	
/*>>>>>>> { Function that checks for paypal checkckout  }  >>>>>>>>>>>>*/
    public function paypal_checkout($payment_request = "") {
        if ($this->session->userdata('user_login') != 1 && $payment_request != 'true')
        redirect('home', 'refresh');

        //checking price
        if($this->session->userdata('total_price_of_checking_out') == $this->input->post('total_price_of_checking_out')):
            $total_price_of_checking_out = $this->input->post('total_price_of_checking_out');
        else:
            $total_price_of_checking_out = $this->session->userdata('total_price_of_checking_out');
        endif;
        $page_data['payment_request'] = $payment_request;
        $page_data['user_details']    = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
        $page_data['amount_to_pay']   = $total_price_of_checking_out;
        $this->load->view('frontend/'.get_frontend_settings('theme').'/paypal_checkout', $page_data);
    }
	
	
	

     /*>>>>>>> { Function for paypal payment actions  }  >>>>>>>>>>>>*/
    public function paypal_payment($user_id = "", $amount_paid = "", $paymentID = "", $paymentToken = "", $payerID = "", $payment_request_mobile = "") {
        $paypal_keys = get_settings('paypal');
        $paypal = json_decode($paypal_keys);

        if ($paypal[0]->mode == 'sandbox') {
            $paypalClientID = $paypal[0]->sandbox_client_id;
            $paypalSecret   = $paypal[0]->sandbox_secret_key;
        }else{
            $paypalClientID = $paypal[0]->production_client_id;
            $paypalSecret   = $paypal[0]->production_secret_key;
        }
		

        //Checking paypal payment status
        $status = $this->payment_model->paypal_payment($paymentID, $paymentToken, $payerID, $paypalClientID, $paypalSecret);
        if (!$status) {
            $this->session->set_flashdata('error_message', translate('an_error_occurred_during_payment'));
            redirect('home', 'refresh');
        }
        $this->crud_model->enrol_student($user_id);
        $this->crud_model->course_purchase($user_id, 'paypal', $amount_paid);
        $this->email_model->course_purchase_notification($user_id, 'paypal', $amount_paid);
		$this->session->unset_userdata('cart_items');
		$this->session->set_flashdata('flash_message', translate('payment_successfully_done'));
		redirect('home/my_courses', 'refresh');

    }

	
	
	
	
	
	
	
	function paystack_checkout($payment_request = ""){
	
        if ($this->session->userdata('user_login') != 1 && $payment_request != 'true')
        redirect('home', 'refresh');

        //checking price
        if($this->session->userdata('total_price_of_checking_out') == $this->input->post('total_price_of_checking_out')):
            $total_price_of_checking_out = $this->input->post('total_price_of_checking_out');
        else:
            $total_price_of_checking_out = $this->session->userdata('total_price_of_checking_out');
        endif;
		
			$PAYSTACK_SECRET_KEY = get_settings('paystack_secret_key');
			$userInfo = $this->user_model->get_all_user($this->session->userdata('user_id'))->row();
		
			$this->session->set_userdata('stu_id', $userInfo->id);
			$this->session->set_userdata('session_amount', $total_price_of_checking_out);
		

		
			if(isset($total_price_of_checking_out)) {
                $result = array();
                $amount = $total_price_of_checking_out * 100 * 386;
                $ref = rand(1000000, 9999999999);
                $callback_url = base_url().'home/paystackverify_payment/'.$ref;
                $postdata =  array('email' => $userInfo->email, 'amount' => $amount,"reference" => $ref, "callback_url" => $callback_url);
                //
                $url = "https://api.paystack.co/transaction/initialize";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postdata));  //Post Fields
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                //
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $headers = [
                    'Authorization: Bearer '.$PAYSTACK_SECRET_KEY,
                    'Content-Type: application/json',
                ];
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $request = curl_exec ($ch);
                curl_close ($ch);
                //
                if ($request) {
                    $result = json_decode($request, true);
                }

                 $redir = $result['data']['authorization_url'];
                 header("Location: ".$redir);


            }
	
	}
	
	
	
	/**************** Function to pay with verify paystack ******************/
	 public function paystackverify_payment($ref) {
		$sess_amount =   $this->session->userdata('session_amount');
		$currentUser_id  =   $this->session->userdata('stu_id');
		
	 	$PAYSTACK_SECRET_KEY = get_settings('paystack_secret_key');
        $result = array();
        $url = 'https://api.paystack.co/transaction/verify/'.$ref;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '.$PAYSTACK_SECRET_KEY]
        );
        $request = curl_exec($ch);
        curl_close($ch);
        //
        if ($request) {
            $result = json_decode($request, true);
            // print_r($result);
            if($result){
                if($result['data']){
                    //something came in
                    if($result['data']['status'] == 'success'){

                        
					$this->crud_model->enrol_student($currentUser_id);
					$this->crud_model->course_purchase($currentUser_id, 'paystack', $sess_amount);
					$this->email_model->course_purchase_notification($currentUser_id, 'paystack', $sess_amount);
					$this->session->unset_userdata('cart_items');
					
					$this->session->set_flashdata('flash_message', translate('payment_successfully_done'));
					redirect('home/my_courses', 'refresh');
					
                    }else{
						$this->session->set_flashdata('error_message', translate('an_error_occurred_during_payment'));
						redirect('home', 'refresh');
                    }
                }
                else{
						$this->session->set_flashdata('error_message', translate('an_error_occurred_during_payment'));
						redirect('home', 'refresh');
                }


            }else{
						$this->session->set_flashdata('error_message', translate('an_error_occurred_during_payment'));
						redirect('home', 'refresh');
						
            }
        }else{
						$this->session->set_flashdata('error_message', translate('an_error_occurred_during_payment'));
						redirect('home', 'refresh');
						
        }

    }
	
	
	
	
	
		function ajax_instructor_course() {
			if($_POST['b'] != ""){       
				$this->db->like('title' , $_POST['b']);
				$query = $this->db->get('course')->result_array();
				if(count($query) > 0){
					foreach ($query as $row) {
						echo '<p style="text-align: left; background-color:white; color:#000; padding-left:20px; margin:0; font-size:14px;"><a style="text-align: left; color:#000;" href="'.base_url().'home/course/'.rawurlencode(slugify($row['title'])).'/'.$row['id'].'">'. '<img src="'.$this->crud_model->get_course_thumbnail_url($row['id']).'" style="border-radius: 50%" width="15" height="15"/>'.'  '.$row['title'].'</a>'."</p>";
					}
				} else{
					echo '<p class="col-md-12" style="text-align: left; background-color:white; color: #000; font-weight: bold; ">No results.</p>';
				}
			}
		}
	
	
	
	
	
	
	
}
