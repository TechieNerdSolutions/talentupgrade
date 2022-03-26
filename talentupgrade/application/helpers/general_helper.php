<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('get_settings')) {
    function get_settings($type = '') {
        $CI	=&	get_instance();
        $CI->load->database();  

        $CI->db->where('type', $type);
        $result = $CI->db->get('settings')->row()->description;
        return $result;
    }
}

if (! function_exists('timezone')) {
  function timezone($type = '') {
    $CI	=&	get_instance();
    $CI->load->database();
    $result = $CI->db->get_where('settings', array('type' => 'timezone'))->row_array();
    date_default_timezone_set($result['timezone']);
  }
}


if ( ! function_exists('trimmer')){
    function trimmer($text) {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text))
        return 'n-a';
        return $text;
    }
}

if ( ! function_exists('lesson_progress'))
{
    function lesson_progress($lesson_id = "", $user_id = "") {
        $CI	=&	get_instance();
        $CI->load->database();
        if ($user_id == "") {
            $user_id = $CI->session->userdata('user_id');
        }
        $user_details = $CI->user_model->get_all_user($user_id)->row_array();
        $watch_history_array = json_decode($user_details['watch_history'], true);
        for ($i = 0; $i < count($watch_history_array); $i++) {
          $watch_history_for_each_lesson = $watch_history_array[$i];
          if ($watch_history_for_each_lesson['lesson_id'] == $lesson_id) {
              return $watch_history_for_each_lesson['progress'];
          }
        }
        return 0;
    }
}



if ( ! function_exists('course_progress'))
{
    function course_progress($course_id = "", $user_id = "") {
        $CI	=&	get_instance();
        $CI->load->database();
        if ($user_id == "") {
            $user_id = $CI->session->userdata('user_id');
        }
        $user_details = $CI->user_model->get_all_user($user_id)->row_array();

        // this array will contain all the completed lessons from different different courses by a user
        $completed_lessons_ids = array();

        // this variable will contain number of completed lessons for a certain course. Like for this one the course_id
        $lesson_completed = 0;

        // User's watch history
        $watch_history_array = json_decode($user_details['watch_history'], true);
        // desired course's lessons
        $lessons_for_that_course = $CI->crud_model->get_lessons('course', $course_id);
        // total number of lessons for that course
        $total_number_of_lessons = $lessons_for_that_course->num_rows();
        // arranging completed lesson ids
        for ($i = 0; $i < count($watch_history_array); $i++) {
          $watch_history_for_each_lesson = $watch_history_array[$i];
          if ($watch_history_for_each_lesson['progress'] == 1) {
              array_push($completed_lessons_ids, $watch_history_for_each_lesson['lesson_id']);
          }
        }

        foreach ($lessons_for_that_course->result_array() as $row) {
          if (in_array($row['id'], $completed_lessons_ids)) {
              $lesson_completed++;
          }
        }

        // calculate the percantage of progress
        $course_progress = ($lesson_completed / $total_number_of_lessons) * 100;
        return $course_progress;
    }
}

// Human readable time
if ( ! function_exists('readable_time_for_humans')){
    function readable_time_for_humans($duration) {
        if ($duration) {
            $duration_array = explode(':', $duration);
            $hour   = $duration_array[0];
            $minute = $duration_array[1];
            $second = $duration_array[2];
            if ($hour > 0) {
                $duration = $hour.' '.translate('hr').' '.$minute.' '.translate('min');
            }elseif ($minute > 0) {
                if ($second > 0) {
                    $duration = ($minute+1).' '.translate('min');
                }else{
                    $duration = $minute.' '.translate('min');
                }
            }elseif ($second > 0){
                $duration = $second.' '.translate('sec');
            }else {
                $duration = '00:00';
            }
        }else {
            $duration = '00:00';
        }
        return $duration;
    }
}

if ( ! function_exists('slugify')){
    function slugify($text) {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        //$text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text))
        return 'n-a';
        return $text;
    }
}

if ( ! function_exists('get_video_extension')){
    // Checks if a video is youtube, vimeo or any other
    function get_video_extension($url) {
        if (strpos($url, '.mp4') > 0) {
            return 'mp4';
        } elseif (strpos($url, '.webm') > 0) {
            return 'webm';
        } else {
            return 'unknown';
        }
    }
}

	// Sanitize input fields
	if (! function_exists('sanitizer')) {
	  function sanitizer($string = "") {
		//$sanitized_string = preg_replace("/[^@ -.a-zA-Z0-9]+/", "", html_escape($string));
		$sanitized_string = html_escape($string);
		return $sanitized_string;
	  }
	}
	
	
	
	if ( ! function_exists('ellipsis')){
    // Checks if a video is youtube, vimeo or any other
    function ellipsis($long_string, $max_character = 30) {
        $short_string = strlen($long_string) > $max_character ? substr($long_string, 0, $max_character)."..." : $long_string;
        return $short_string;
    }
}
	
	
if ( ! function_exists('is_purchased'))
{
	function is_purchased($course_id = "") {
		$CI	=&	get_instance();
		$CI->load->library('session');
		$CI->load->database();
		if ($CI->session->userdata('user_login')) {
			$enrolled_history = $CI->db->get_where('enrol' , array('user_id' => $CI->session->userdata('user_id'), 'course_id' => $course_id))->num_rows();
			if ($enrolled_history > 0) {
				return true;
			}else {
				return false;
			}
		}else {
			return false;
		}
	}
}


if ( ! function_exists('get_user_role'))
{
	function get_user_role($type = "", $user_id = '') {
		$CI	=&	get_instance();
		$CI->load->database();

        $role_id	=	$CI->db->get_where('users' , array('id' => $user_id))->row()->role_id;
        $user_role	=	$CI->db->get_where('role' , array('id' => $role_id))->row()->name;

        if ($type == "user_role") {
            return $user_role;
        }else {
            return $role_id;
        }
	}
}


// RANDOM NUMBER GENERATOR FOR ELSEWHERE
if (! function_exists('random')) {
    function random($length_of_string) {
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shufle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }
}

// RANDOM NUMBER GENERATOR FOR ELSEWHERE
if (! function_exists('phpFileUploadErrors')) {
    function phpFileUploadErrors($error_code) {
        $phpFileUploadErrorsArray = array(
            0 => 'There is no error, the file uploaded with success',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk.',
            8 => 'A PHP extension stopped the file upload.',
        );
        return $phpFileUploadErrorsArray[$error_code];
    }
}



	
if ( ! function_exists('pagintaion')){
    function pagintaion($total_rows, $per_page_item){
        $config['per_page']        = $per_page_item;
        $config['num_links']       = 2;
        $config['total_rows']      = $total_rows;
        $config['full_tag_open']   = '<ul class="pagination justify-content-center">';
        $config['full_tag_close']  = '</ul>';
        $config['prev_link']       = '<i class="fas fa-chevron-left"></i>';
        $config['prev_tag_open']   = '<li class="page-item">';
        $config['prev_tag_close']  = '</li>';
        $config['next_link']       = '<i class="fas fa-chevron-right"></i>';
        $config['next_tag_open']   = '<li class="page-item">';
        $config['next_tag_close']  = '</li>';
        $config['cur_tag_open']    = '<li class="page-item active disabled"> <span class="page-link">';
        $config['cur_tag_close']   = '</span></li>';
        $config['num_tag_open']    = '<li class="page-item">';
        $config['num_tag_close']   = '</li>';
        $config['first_tag_open']  = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open']   = '<li class="page-item">';
        $config['last_tag_close']  = '</li>';
        return $config;
    }
}





if (! function_exists('get_frontend_settings')) {
    function get_frontend_settings($key = '') {
        $CI	=&	get_instance();
        $CI->load->database();

        $CI->db->where('key', $key);
        $result = $CI->db->get('frontend_settings')->row()->value;
        return $result;
    }
}


if (! function_exists('currency')) {
    function currency($price = "") {
        $CI	=&	get_instance();
        $CI->load->database();
        if ($price != "") {
            $CI->db->where('type', 'system_currency');
            $currency_code = $CI->db->get('settings')->row()->description;

            $CI->db->where('code', $currency_code);
            $symbol = $CI->db->get('currency')->row()->symbol;

            $CI->db->where('type', 'currency_position');
            $position = $CI->db->get('settings')->row()->description;

            if ($position == 'right') {
                return $price.$symbol;
            }elseif ($position == 'right-space') {
                return $price.' '.$symbol;
            }elseif ($position == 'left') {
                return $symbol.$price;
            }elseif ($position == 'left-space') {
                return $symbol.' '.$price;
            }
        }
    }
}

if (! function_exists('currency_code_and_symbol')) {
    function currency_code_and_symbol($type = "") {
        $CI	=&	get_instance();
        $CI->load->database();
        $CI->db->where('type', 'system_currency');
        $currency_code = $CI->db->get('settings')->row()->description;

        $CI->db->where('code', $currency_code);
        $symbol = $CI->db->get('currency')->row()->symbol;
        if ($type == "") {
            return $symbol;
        }else {
            return $currency_code;
        }

    }
}


