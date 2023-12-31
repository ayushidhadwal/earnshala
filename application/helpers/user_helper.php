<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */


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

if ( ! function_exists('is_purchased_by_user_id'))
{
	function is_purchased_by_user_id($course_id = "", $user_id = "") {
		$CI	=&	get_instance();
		$CI->load->database();
        $enrolled_history = $CI->db->get_where('enrol' , array('user_id' => $user_id, 'course_id' => $course_id, 'status' => 1))->num_rows();
        if ($enrolled_history > 0) {
            return true;
        }else {
            return false;
        }
	}
}

if ( ! function_exists('is_purchased_by_user_id_data'))
{
	function is_purchased_by_user_id_data($course_id = "", $user_id = "") {
		$CI	=&	get_instance();
		$CI->load->database();
        $enrolled_history = $CI->db->get_where('enrol' , array('user_id' => $user_id, 'course_id' => $course_id, 'status' => 1));
        if ($enrolled_history->num_rows() > 0) {
            return $enrolled_history->row();
        }else {
            return false;
        }
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

function getUserData($userId = ""){

    $CI	=&	get_instance();
    $CI->load->database();
    return $CI->db->get_where('users' , array('id' => $userId))->row();
}

function getUserPaymentData($userId = "",$type){

    $CI	=&	get_instance();
    $CI->load->database();
	$CI->db->select('users.*, payment.date_added as pdate, payment_type');
    $CI->db->from('users');
    $CI->db->join('payment','payment.instructor_id=users.id');
    $CI->db->where('users.id',$userId);
    $CI->db->where('payment.course_type',$type);
    return $CI->db->get()->row();
}


function getTeacherPaymentData($userId = ""){

    $CI	=&	get_instance();
    $CI->load->database();

    $CI->db->from('live_class_time_new');
	$CI->db->join('users','users.id=live_class_time_new.instructor_id','inner');
	$CI->db->join('payment','payment.course_id=live_class_time_new.live_id');
    $CI->db->where('live_class_time_new.live_id',$userId);
	$CI->db->where('payment.course_type','live');

    return $CI->db->get()->row();
}

function getPaymentDetails($userId = "", $course_id = ""){

    $CI =&  get_instance();
    $CI->load->database();

    $CI->db->from('payment');
    $CI->db->where('user_id',$userId);
    $CI->db->where('course_id',$course_id);

    return $CI->db->get()->row();
}

// ------------------------------------------------------------------------
/* End of file user_helper.php */
/* Location: ./system/helpers/user_helper.php */
