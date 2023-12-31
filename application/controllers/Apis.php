<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apis extends MY_Controller {

    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
        parent::__construct();
        $this->load->database();
        $this->load->model('NewApiModel');

        // $this->load->library('session');
    }

    private function sendResponse($status, $message = '', $data = [])
        {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => $status,
                'data' => $data,
                'message' => $message
            ]);
            exit();
        }

    private function sendResponse_forum_detail($status, $message = '', $data=[])
        {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => $status,
                'data' => $data['forum_details'],
                'message' => $message
            ]);
            exit();
        }

    private function request($type, $url = '')
    {
        if($_SERVER['REQUEST_METHOD'] !== $type) {
            return $this->sendResponse(false, "Cannot " . $_SERVER['REQUEST_METHOD'] .' '. $url);
        }
        return true;
    }

    public function getAllState(){

        $state = $this->NewApiModel->getAllState();
        $this->sendResponse(true,"Success",['states' => $state]);

    }

    public function register(){

        $this->request('POST', 'user/register');
        $this->form_validation->set_rules('name','Name','trim|required');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('mobile','Mobile Number','trim|required|numeric|is_unique[users.phone]|exact_length[10]');
        $this->form_validation->set_rules('password','Password','trim|required');
        $this->form_validation->set_rules('state','State','trim|required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $state = $this->input->post('state');

           if(!is_numeric($state)){
             return $this->sendResponse(false,  STATE_NOT_EXIST);
             exit();
           }


           $state_exist = $this->Api_user_model->check_id_exist('states',['state_id'=>$state]);

           if($state_exist->num_rows() === 0 ) {
                return $this->sendResponse(false,  STATE_NOT_EXIST );
                exit();
           }

    	  	$data = [
	        'first_name' => $this->input->post('name'),
	        // 'last_name'  => $this->input->post('last_name'),
	        'email'   => $this->input->post('email'),
            'password'   => sha1($this->input->post('password')),
	        'phone'   => $this->input->post('mobile'),
	        'state'   => $state,
	        'role_id' => 2,
	        'is_instructor' =>0,
	        'status' =>1,
            'firebase_token' => $this->input->post('firebase_token',true)
		    ];

        $query = $this->NewApiModel->registerUser('users', $data);
        if($query){
             	return $this->sendResponse(true, "Successfully Registered", [
            		'userId' => $query
            	]);
        } else {
         		return $this->sendResponse(false, "Something went wrong, please try again");
        }
        }

    }

    //Login SUbmit
    public function login()
    {
        $this->request('POST', 'user/login');
        $this->form_validation->set_rules('email','Email','trim|required');
        $this->form_validation->set_rules('password','Password','trim|required');


        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0]);
        }
        else
        {

            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $query = $this->NewApiModel->loginCheck('users', $email, $password);

            if(!empty($query->row()))
            {
                $row = $query->row();
                if($row->role_id == 2) {
                    $this->db->where('id',$query->row('id'))->update('users',['firebase_token' => $this->input->post('firebase_token')]);
                    return $this->sendResponse(true, LOGIN_SUCCESS_MSG , [
                        'userId' => $query->row('id')
                    ]);
                }
            }
            else
            {
                return $this->sendResponse(false, LOGIN_FAILED_MSG);
            }

        }
    }

    //Get Free Course
    public function getFreeCourses()
    {
        $this->request('POST', 'get-free-courses');
        $limit = $this->input->post('limit');
        $start = $this->input->post('start') ? $this->input->post('start') : 0;
        $data = $this->NewApiModel->getFreeCourses($limit, $start);
        $user_id = $this->input->post('user_id');


        foreach($data as $key => $val)
        {
            $total_rating =  $this->crud_model->get_ratings('course', $val->id, true)->row()->rating;
            $number_of_ratings = $this->crud_model->get_ratings('course', $val->id)->num_rows();
            if ($number_of_ratings > 0) {
                $average_ceil_rating = round($total_rating / $number_of_ratings);
              } else {
                $average_ceil_rating = 0;
              }
            $data[$key]->is_enrol = $this->NewApiModel->isEnrolCourse($val->id, $user_id);
            $data[$key]->ratings =  $average_ceil_rating;
            $data[$key]->thumbnail = base_url($val->thumbnail);
        }

        $this->sendResponse(true,"Success",['courses' => $data]);
    }

    public function getPaidCourses()
    {
        $this->request('POST', 'get-paid-courses');
        $limit = $this->input->post('limit');
        $start = $this->input->post('start') ? $this->input->post('start') : 0;
        $data = $this->NewApiModel->getPaidCourses($limit, $start);
        $user_id = $this->input->post('user_id');

        foreach($data as $key => $val)
        {
            $total_rating =  $this->crud_model->get_ratings('course', $val->id, true)->row()->rating;
            $number_of_ratings = $this->crud_model->get_ratings('course', $val->id)->num_rows();
            if ($number_of_ratings > 0) {
                $average_ceil_rating = round($total_rating / $number_of_ratings);
              } else {
                $average_ceil_rating = 0;
              }

            $data[$key]->is_enrol = $this->NewApiModel->isEnrolCourse($val->id, $user_id);
            $data[$key]->ratings =  $average_ceil_rating;
            $data[$key]->thumbnail = base_url($val->thumbnail);

        }

        $this->sendResponse(true,"Success",['courses' => $data]);
    }

    //Course Details
    public function getCourseDetails()
    {
        $this->request('POST', 'user/get-course-details');
        $course_id = $this->input->post('course_id');
        $user_id = $this->input->post('user_id');
        $course = $this->NewApiModel->getCourseDetails($course_id);

        $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 0]);
            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

        $sections = [];
        if($course)
        {
            $clicks = $this->NewApiModel->setCourseClick($course_id, $user_id);
            // echo json_encode($clicks);exit;

            $section = $this->NewApiModel->getLimitedSection($course_id)->result_array();
            $sections['sections'] = [];
            foreach($section as $sec)
            {
                if ($this->NewApiModel->isEnrolledtCourse($user_id,$course_id)) {
                    $access = true;
                }else{
                    if($this->NewApiModel->isEnrolledtCourseByInstallment($user_id,$course_id)){
                        if ($this->NewApiModel->installment_section_access($user_id,$course_id,$sec['id'])) {
                            $access = true;
                        }else{
                            $access = false;
                        }
                    }else{
                        $access = false;
                    }
                }

                $lessons = $this->crud_model->get_lessons('section', $sec['id'])->result_array();
                $sections['sections'][] = array('id' => $sec['id'],'title'=>$sec['title'], 'sections_access' => $access, 'lessons'=> $lessons);
            }

            $course->outcomes = json_decode($course->outcomes);
            $course->requirements = json_decode($course->requirements);

            $total_rating =  $this->crud_model->get_ratings('course', $course->id, true)->row()->rating;
            $number_of_ratings = $this->crud_model->get_ratings('course', $course->id)->num_rows();
            if ($number_of_ratings > 0) {
                $average_ceil_rating = round($total_rating / $number_of_ratings);
              } else {
                $average_ceil_rating = 0;
            }
            $course->addWish = $this->NewApiModel->is_added_to_wishlist($course->id, $user_id);

            $course->ratings =  $average_ceil_rating;
            $ratings = $this->NewApiModel->getLimitedReviews($course_id)->result_array();

            foreach($ratings as $key => $va)
            {
                $ratings[$key]['date_added'] = date('d M, Y',strtotime($va['date_added']));

            }

            $course->totalSections = $this->NewApiModel->getAllSection($course_id)->num_rows();
            $course->totalLessons = $this->crud_model->get_lessons('course', $course->id)->num_rows();
            $course->courseLength = $this->crud_model->get_total_duration_of_lesson_by_course_id($course_id);
            // $course->isWishlist = false;
            $course->isWishlist = $this->NewApiModel->isWishlistCourse($user_id,$course_id);
            // $course->isEnrolled = false;
            $course->isEnrolled = $this->NewApiModel->isEnrolledtCourse($user_id,$course_id);
            $course->isEnrolledByInstallment = $this->NewApiModel->isEnrolledtCourseByInstallment($user_id,$course_id);
            $course->isCourseInCart = $this->NewApiModel->isCourseInCart($user_id,$course_id);
            $course->isInstallmentEnebaled = $this->NewApiModel->isInstallmentEnebaled($user_id,$course_id);
            $this->sendResponse(true, "Success",['courseDetails' => $course, 'courseData' => $sections, 'reviews' => $ratings]);

        }
        else
        {
            $this->sendResponse(false, "Course not found");
        }
    }

    //Get Course All Sections
    public function getCourseSections()
    {
        $this->request('POST', 'user/get-course-sections');

        $course_id = $this->input->post('course_id');
        $user_id = $this->input->post('user_id');
        $course = $this->NewApiModel->getCourseDetails($course_id);
        $totalSections = $this->NewApiModel->getAllSection($course_id)->num_rows();
        $totalLessons = $this->crud_model->get_lessons('course', $course->id)->num_rows();
        $courseLength = $this->crud_model->get_total_duration_of_lesson_by_course_id($course_id);
        $sections['totalSections'] = $totalSections;
        $sections['totalLessons'] = $totalLessons;
        $sections['courseLength'] = $courseLength;
        $sections['sections'] = [];
        if($course)
        {
            $section = $this->NewApiModel->getAllSection($course_id)->result_array();

            foreach($section as $sec)
            {
                if ($this->NewApiModel->isEnrolledtCourse($user_id,$course_id)) {
                    $access = true;
                }else{
                    if($this->NewApiModel->isEnrolledtCourseByInstallment($user_id,$course_id)){
                        if ($this->NewApiModel->installment_section_access($user_id,$course_id,$sec['id'])) {
                            $access = true;
                        }else{
                            $access = false;
                        }
                    }else{
                        $access = false;
                    }
                }
                $lessons = $this->crud_model->get_lessons('section', $sec['id'])->result_array();
                $sections['sections'][] = array('id' => $sec['id'],'title'=>$sec['title'],'sections_access' => $access,'lessons'=> $lessons);
            }

            $this->sendResponse(true, "Success",$sections);
        }
        else
        {
            $this->sendResponse(false, "Course not found");
        }
    }

    //Get Course All Reviews
    public function getCourseReviews()
    {
        $this->request('POST', 'user/get-course-reviews');
        $course_id = $this->input->post('course_id');
        $course = $this->NewApiModel->getCourseDetails($course_id);

        if($course)
        {
            $total_rating =  $this->crud_model->get_ratings('course', $course->id, true)->row()->rating;
            $number_of_ratings = $this->crud_model->get_ratings('course', $course->id)->num_rows();
            if ($number_of_ratings > 0) {
                $average_ceil_rating = ceil($total_rating / $number_of_ratings);
              } else {
                $average_ceil_rating = 0;
              }

            $ratings =  $average_ceil_rating;
            $reviews = $this->NewApiModel->getAllReviews($course_id)->result_array();

            $this->sendResponse(true, "Success",['rating' => $ratings, 'reviews' => $reviews]);

        }
        else
        {
            $this->sendResponse(false, "Course not found");
        }
    }

    //Update Password
    public function updatePassword()
    {
        $this->request('POST', '/api_user/change_password/');

              $user = $this->Api_user_model->check_id_exist('users',['id' => $this->input->post('user_id'), 'role_id' => 2, 'is_instructor' => 0]);

              if($user->num_rows() === 0) {
                  return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                  exit();
              }

                $this->request('POST', 'user/update-password');
                $this->form_validation->set_rules('user_id', 'User ID is required', 'required');
                $this->form_validation->set_rules('old_password', 'Current Password', 'required');
                $this->form_validation->set_rules('new_password', 'New Password', 'required');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

                if ($this->form_validation->run() === false) {
                    $message = explode("\n",strip_tags($this->form_validation->error_string()));
                    return $this->sendResponse(false, $message[0],[]);
                }
                else{
                $old_password = $this->input->post('old_password');
                $new_password = $this->input->post('new_password');

                $data = [
                'id'   => $this->input->post('user_id'),
                'role_id' => 2,
                'is_instructor' =>0,
                'status' =>1
                ];

            $db_password = $this->Api_user_model->get_db_password('users', $data);

            if(sha1($old_password) === $db_password){

                $new_password_updated = $this->Api_user_model->update_table('users',['password' => sha1($new_password)], $data);
                if($new_password_updated) {
                    return $this->sendResponse(true, "Password Updated Successfully");
                } else {
                    return $this->sendResponse(true, "You have not made any changes");
                }

            } else {
                return $this->sendResponse(false, OLD_PASS_ERR);
            }

          }

    }

    //Get Profile
    public function getProfile($user_id)
    {
        $this->request('GET', '/user/get-profile/'.$user_id);
        $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 0]);

        if($user->num_rows() === 0) {
            return $this->sendResponse(false,  USER_NONEXIST_ERROR );
            exit();
        }
        else
        {
            $userData = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 0])->row();

            return $this->sendResponse(true,"Success",['userData' => $userData]);
            exit();
        }

    }

    //Update Profile
    public function updateProfile()
    {

        $this->request('POST', '/user/update-profile');
        $this->form_validation->set_rules('name','Name','trim|required');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');
        $this->form_validation->set_rules('mobile','Mobile Number','trim|required|numeric|exact_length[10]');
        $this->form_validation->set_rules('state','State','trim|required');
        $this->form_validation->set_rules('user_id','User ID','trim|required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $user_id = $this->input->post('user_id');
            $email = $this->input->post('email');
            $mobile = $this->input->post('mobile');
            $state = $this->input->post('state');
            $name = $this->input->post('name');

            $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 0]);
            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

            $checkEmail = $this->NewApiModel->checkEmail($user_id, $email);
            $checkPhone = $this->NewApiModel->checkPhone($user_id, $mobile);

            if($checkEmail > 0)
            {
                return $this->sendResponse(false, "Email already exist");
                exit();
            }

            if($checkPhone > 0)
            {
                return $this->sendResponse(false, "Mobile Number already exist");
                exit();
            }

            $state_exist = $this->Api_user_model->check_id_exist('states',['state_id'=>$state]);

           if($state_exist->num_rows() === 0 ) {
                return $this->sendResponse(false,  STATE_NOT_EXIST );
                exit();
           }

            $data = [
                'first_name' => $name,
                'email'   => $email,
                'phone'   => $mobile,
                'state'   => $state,
            ];

            $update = $this->NewApiModel->updateProfile($user_id, $data);

            if($update)
            {
                return $this->sendResponse(true, "Updated Successfully");
                exit();
            }
            else
            {
                return $this->sendResponse(true, "You have not made any changes");
                exit();
            }

        }
    }

    //forget Password
    public function forgetPassword()
    {
        $this->request('POST', '/user/forget-password');
        $this->form_validation->set_rules('email','Email or Mobile Number','trim|required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $email = $this->input->post('email');
            $emailExist = $this->NewApiModel->checkEmailExist($email);

            if($emailExist->num_rows() === 1)
            {
                $this->NewApiModel->updateForgetPasswordStatus($email);
                $otp = rand(1111, 9999);
                $user = $emailExist->row();
                //Send OTP to email API
                if (!empty($user->email)) {

                    $subject = 'Reset Password';
                    $to_name = $user->first_name . ' ' . $user->last_name;
                    $message = "Dear user, Your OTP for Reset Password is $otp. Do not share OTP with anyone.";

                    $msg = $this->load->view('email/common_template', [
                        'subject' => $subject,
                        'to_name' => $to_name,
                        'message' => $message,
                    ], true);
                    $this->sendEmail($to_name, $user->email, $subject, $msg);
                }

                //Send OTP to Mobile API
                if (!empty($user->phone)) {
                    $this->sendBulkSms('Reset', $user->phone, $otp);
                }

                $this->sendResponse(true,"OTP Send Successfully",['otp' => $otp]);

            }
            else
            {
                return $this->sendResponse(false, "Email or Mobile Number does not exist",[]);
            }
        }
    }

    //Reset Password
    public function resetPassword()
    {
        $this->request('POST', '/user/reset-password');
        $this->form_validation->set_rules('email', 'Email or Password', 'required');
        $this->form_validation->set_rules('password', 'New Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if($this->form_validation->run() === false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $update = $this->NewApiModel->resetPassword($email, $password);

            if($update)
            {
                return $this->sendResponse(true, "Password has been reset successfully",[]);
            }
            else
            {
                return $this->sendResponse(false, "Invalid Request",[]);
            }
        }
    }

    //Add To Wishlist
    public function addToWishlist()
    {
        $this->request('POST', '/user/add-to-wishlist');
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('course_id', 'Course', 'required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $course_id = $this->input->post('course_id');
            $user_id = $this->input->post('user_id');
            $course = $this->NewApiModel->getCourseDetails($course_id);

            $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 0]);
            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

            if(empty($course))
            {
                $this->sendResponse(false, "Course not found");
            }

            $addWishlist = $this->NewApiModel->addToWishlist($user_id, $course_id);

            $this->sendResponse(true, $addWishlist);

        }
    }

    //Get Wishlist
    public function getWishlist($user_id)
    {
        $this->request("GET","/user/get-wishlist/".$user_id);

        $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 0]);
        if($user->num_rows() === 0) {
            return $this->sendResponse(false,  USER_NONEXIST_ERROR );
            exit();
        }

        $my_courses = $this->NewApiModel->get_courses_by_wishlists($user_id);

        $this->sendResponse(true,"Success",['courses' => $my_courses]);

    }

    //Search Courses
    public function search()
    {
        $this->request("POST","user/search");
        if (isset($_POST['query']) && !empty($_POST['query'])) {
            $search_string = $_POST['query'];
            $courses = $this->crud_model->get_courses_by_search_string($search_string)->result_array();

            $this->sendResponse(true,"Success",['courses' => $courses]);
        }else {
            $this->sendResponse(false,"No Search Value Found");
        }

    }

    //Enroll for free course
    public function enrollFreeCourse()
    {
        $this->request("POST","user/enroll-for-free-course");
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('course_id', 'Course', 'required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $course_id = $this->input->post('course_id');
            $user_id = $this->input->post('user_id');
            $course = $this->NewApiModel->getCourseDetails($course_id);

            $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 0]);
            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

            if(empty($course))
            {
                $this->sendResponse(false, "Course not found");
            }

            $enrol = $this->NewApiModel->enrol_to_free_course($course_id, $user_id);

            if($enrol['status'])
            {
                $this->sendResponse(true,$enrol['message']);
            }
            else
            {
                $this->sendResponse(false,$enrol['message']);
            }
        }
    }

    //Get Enrolled Courses
    public function getEnrolledCourses($user_id)
    {
        $this->request('GET',"user/get-enrolled-courses/".$user_id);
        $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id,'role_id' => 2, 'is_instructor' => 0]);
        if($user->num_rows() === 0) {
            $this->sendResponse(false,  USER_NONEXIST_ERROR);
        }

        $my_courses = $this->NewApiModel->my_courses($user_id)->result();

        $data = [];

        foreach($my_courses as $key => $val)
        {
            $course_details = $this->NewApiModel->get_course_by_id($val->course_id)->row();

            $total_rating =  $this->crud_model->get_ratings('course', $course_details->id, true)->row()->rating;
            $number_of_ratings = $this->crud_model->get_ratings('course', $course_details->id)->num_rows();
            if ($number_of_ratings > 0) {
                $average_ceil_rating = round($total_rating / $number_of_ratings);
              } else {
                $average_ceil_rating = 0;
            }

            if(strtotime(date('D, d-M-Y')) > $val->date_expire)
            {
                $course_details->is_expired = true;
            }
            else
            {
                $course_details->is_expired = false;
            }
            $course_details->is_installment = false;
            $course_details->installments =  [];
            $course_details->ratings =  $average_ceil_rating;
            array_push($data, $course_details);
        }


        $my_courses_install = $this->NewApiModel->my_courses_installment($user_id)->result();

        foreach($my_courses_install as $key => $val)
        {
            $course_details = $this->NewApiModel->get_course_by_id($val->course_id)->row();

            $total_rating =  $this->crud_model->get_ratings('course', $course_details->id, true)->row()->rating;
            $number_of_ratings = $this->crud_model->get_ratings('course', $course_details->id)->num_rows();
            if ($number_of_ratings > 0) {
                $average_ceil_rating = round($total_rating / $number_of_ratings);
              } else {
                $average_ceil_rating = 0;
            }

            if(strtotime(date('D, d-M-Y')) > $val->date_expire)
            {
                $course_details->is_expired = true;
            }
            else
            {
                $course_details->is_expired = false;
            }
            $course_details->is_installment = true;
            $course_installments = $this->NewApiModel->get_course_installments_details($val->course_id)->result();
            $installments = [];
            foreach ($course_installments as $keyi => $valueI) {
                $installments[$keyi] = $valueI->installments;
            }
            $course_details->installments =  $installments;
            $course_details->ratings =  $average_ceil_rating;
            array_push($data, $course_details);
        }

        $this->sendResponse(true,"Success",['courses' => $data]);

    }

    //Generate Order ID
    public function generateOrder()
    {
        $this->request('POST', '/user/generate-order');
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('course_id', 'Course', 'required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $course_id = $this->input->post('course_id');
            $user_id = $this->input->post('user_id');

            $user = $this->Api_user_model->check_id_exist('users',['id' => $user_id, 'role_id' => 2, 'is_instructor' => 0]);
            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

            $course = $this->NewApiModel->getCourseDetails($course_id);

            if(empty($course))
            {
                $this->sendResponse(false, "Course not found");
            }

            if($course->is_free_course == 1)
            {
                $this->sendResponse(false, "This course is free");
            }

            $isEnrolled = $this->NewApiModel->isEnrolledtCourse($user_id, $course_id);

            if($isEnrolled)
            {
                $this->sendResponse(false, "You are already enrolled to this course");
            }

            try{
                $receipt = 'TXN'.time();
                $inramount = $course->price;
                $amount = $inramount * 100;

                $url = "https://api.razorpay.com/v1/orders";

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $RAZOR_KEY = RAZOR_LKEY;

                $headers = array(
                "content-type: application/json",
                "Authorization: Basic $RAZOR_KEY",
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

                $data = '{"amount": "'.$amount.'", "currency": "INR", "receipt": "'.$receipt.'"}';

                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

                //for debug only!
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                $resp = curl_exec($curl);
                curl_close($curl);
                // var_dump($resp);
                // return json_encode($resp);
                $respData = json_decode($resp);
                $pdata = [
                    'po_user_id' => $user_id,
                    'po_course_id' => $course_id,
                    'po_price' => $inramount,
                    'po_order_id' => $respData->id,
                    'po_type' => "course"
                ];
                $this->NewApiModel->saveOrderId($pdata);
                $this->sendResponse(true, "Success",$respData);
            }
            catch(Exception $e)
            {
                $this->sendResponse(false, $e->getMessage());
            }
        }


    }

    //Verify Signature
    public function verifySignature()
    {
        $this->request('POST','user/verify-signature');
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('course_id', 'Course', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');
        $this->form_validation->set_rules('razorpay_payment_id', 'Payment ID', 'required');
        $this->form_validation->set_rules('razorpay_order_id', 'Order ID', 'required');
        $this->form_validation->set_rules('razorpay_signature', 'Signature', 'required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $user_id = $this->input->post('user_id');
            $course_id = $this->input->post('course_id');
            $price = $this->input->post('price');
            $order_id = $this->input->post('razorpay_order_id');
            $payment_id = $this->input->post('razorpay_payment_id');
            $signature = $this->input->post('razorpay_signature');

            $where = [
                'po_user_id' => $user_id,
                'po_course_id' => $course_id,
                'po_price' => $price,
                'po_order_id' => $order_id,
                'po_type' => "course",
                'po_status' => '0'
            ];

            $check = $this->NewApiModel->checkPayOrder($where);

            if($check <= 0)
            {
                return $this->sendResponse(false, "Invalid Request",[]);
            }

            $sig = hash_hmac('sha256', "$order_id|$payment_id", RAZOR_KEY_SECRET);

            if($sig == $signature)
            {
                $paydata = [
                    'user_id' => $user_id,
                    'payment_type' => "razorpay",
                    'course_id' => $course_id,
                    'amount' => $price,
                    'admin_revenue' => $price,
                    'transaction_id' => $order_id,
                    'razor_payment_id' => $payment_id,
                    'razor_signature' => $signature
                ];
                $this->NewApiModel->enrol_student($user_id,$course_id);
                $this->NewApiModel->course_purchase($paydata);
                $this->NewApiModel->updatePayOrder($where);
                return $this->sendResponse(true, "Payment is successful.",[]);
            }
            else
            {
                return $this->sendResponse(false, "Payment Failed",[]);
            }


        }
    }

    public function getAllQuizList()
    {
        $this->request('GET', '/api//user/get-all-quiz/');

        $quizes = $this->NewApiModel->getAllQuiz()->result();


        foreach ($quizes  as $key => $quiz){

            $quiz->q_date_added = date('d M Y, h:i A',$quiz->q_date_added);

        }

        return $this->sendResponse(true, SUCCESS_MSG, [
            'quiz_list' => $quizes
        ]);

    }

    public function getAllQuestionByQuiz($quizid)
    {
        $this->request('GET', '/api/get-all-question-by-quiz/'.$quizid);

        if(!is_numeric($quizid)){
            return $this->sendResponse(false,  QUIZ_NONEXIST_ERROR );
            exit();
          }

         $quiz = $this->Api_user_model->check_id_exist('quiz',['q_id'=> $quizid]);
         if($quiz->num_rows() === 0){
             return $this->sendResponse(false,  QUIZ_NONEXIST_ERROR);
             exit();
         }

         $question_option = $this->Api_user_model->get_quiz_questions($quizid)->result();

          if(count($question_option) > 0) {

            foreach($question_option as $key => $val)
            {
               $val->options = json_decode($val->options);
            }

            return $this->sendResponse(true, SUCCESS_MSG, [
                'question' => $question_option
            ]);
       } else {
               return $this->sendResponse(true, NO_QUIZ_QUESTION);
       }
    }

    //SUbmit Quiz
    public function submitQuiz()
    {
        $this->request('POST','user/submit-quiz');
        $this->form_validation->set_rules('quiz_id','Quiz Id','trim|required');
        $this->form_validation->set_rules('questions[]','Quiz Questions','trim|required');
        $this->form_validation->set_rules('answer[]','Quiz Answer','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $user_id = $this->input->post('user_id');
            $quizid = $this->input->post('quiz_id');
            $quiz_question = json_decode($this->input->post('questions[]'));
            $quiz_answer = json_decode($this->input->post('answer[]'));

            $user = $this->Api_user_model->check_id_exist('users',['id' => $user_id, 'role_id' => 2, 'is_instructor' => 0]);
            if($user->num_rows() === 0){
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

            $quiz = $this->Api_user_model->check_id_exist('quiz',['q_id'=> $quizid]);
            if($quiz->num_rows() === 0){
                return $this->sendResponse(false,  QUIZ_NONEXIST_ERROR);
                exit();
            }

            $countQue = $this->Api_user_model->check_id_exist('question',['quiz_id'=>$quizid]);

            $total = $countQue->num_rows();
            $correct = 0;
            $wrong = 0;

            foreach ($quiz_question as $key => $qq)
            {
                if(!is_numeric($qq))
                {
                     return $this->sendResponse(false,  QUIZ_QUESTION_NUMBERIC_ERROR );
                     exit();
                }
                else
                {
                    $question_exists = $this->Api_user_model->check_id_exist('question',['id'=> $qq,'quiz_id'=>$quizid]);
                    if($question_exists->num_rows() === 0){
                        return $this->sendResponse(true,  QUIZ_QUESTION_NONEXIST_ERROR.' '.$qq);
                        exit();
                    }

                    $questions = $this->NewApiModel->getQuestion($qq);

                    if($questions->correct_answers == $quiz_answer[$key])
                    {
                        $correct += 1;
                    }
                    else
                    {
                        $wrong += 1;
                    }
                }
            }

            $quizHist = [
                'user_id' => $user_id,
                'quiz_id' => $quizid,
                'questions' => $this->input->post('questions[]'),
                'answer' => $this->input->post('answer[]'),
                'totals' => $total,
                'correct' => $correct,
                'wrong' => $wrong,
                'not_attempt' => $total - ($correct + $wrong),

            ];
            $this->NewApiModel->quiz_histories($quizHist);

            return $this->sendResponse(true,"Success",[
                'total' => $total,
                'correct' => $correct,
                'wrong' => $wrong,
                'not_attempted' => $total - ($correct + $wrong),
            ]);

        }
    }

    //Submit Forum
    public function submitForum() {

        $this->request('POST', '/api_user/insert_forum/');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('query_question','Quiz Questions','trim|required');
        $this->form_validation->set_rules('query_brief','Quiz Brief','trim|required');
        $this->form_validation->set_rules('add_tags','Add Tags','trim|required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else{

          $data = [
          'f_user_id' => $this->input->post('user_id'),
          'f_query_question' => $this->input->post('query_question'),
          'f_query_brief' => $this->input->post('query_brief'),
          'f_add_tags' => $this->input->post('add_tags')
         ];

         if(!is_numeric($this->input->post('user_id'))){
            return $this->sendResponse(false,  USER_NONEXIST_ERROR);
            exit();
          }

         $user = $this->Api_user_model->check_id_exist('users',['id'=>$data['f_user_id'], 'role_id' => 2, 'is_instructor' => 0]);
          if($user->num_rows() === 0){
            return $this->sendResponse(false,  USER_NONEXIST_ERROR);
            exit();
          }

      $query = $this->Api_user_model->insert_table('forum', $data);

      if($query) {
        return $this->sendResponse(true, "Added Successfully");
      } else {
        return $this->sendResponse(false,  ERROR_MSG);
      }

    }


  }

    //Update Forum
    public function updateForum()
    {
        $this->request('POST', '/user/update-forum/');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('forum_id','Forum ID','trim|required');
        $this->form_validation->set_rules('query_question','Quiz Questions','trim|required');
        $this->form_validation->set_rules('query_brief','Quiz Brief','trim|required');
        $this->form_validation->set_rules('add_tags','Add Tags','trim|required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else{

            if(!is_numeric($this->input->post('user_id'))){
                       return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                       exit();
                     }

            if(!is_numeric($this->input->post('forum_id'))){
                return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                exit();
                }
            $data = [
            'f_query_question' => $this->input->post('query_question'),
            'f_query_brief' => $this->input->post('query_brief'),
            'f_add_tags' => $this->input->post('add_tags')
            ];

            $condition = [
            'f_user_id' => $this->input->post('user_id'),
            'f_id' => $this->input->post('forum_id')
            ];

            $user = $this->Api_user_model->check_id_exist('users',['id'=>$condition['f_user_id'], 'role_id' => 2, 'is_instructor' => 0]);

            if($user->num_rows() === 0){
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

            $forum = $this->Api_user_model->check_id_exist('forum',['f_id'=>$condition['f_id'], 'f_user_id' => $condition['f_user_id']]);
            if($forum->num_rows() === 0){
                return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                exit();
            }

            $query = $this->Api_user_model->update_table('forum',$data,$condition);

            if($query) {
                    return $this->sendResponse(true, SUCCESS_UPDATED,[

                    ]);
            } else {
                    return $this->sendResponse(true,  NO_UPDATE_MSG );
            }

        }
    }

    //Get Forum List
    public function getForumList()
    {
        $this->request('GET', '/user/get-forum-list/');
        $forum_list = $this->NewApiModel->getForumList('forum',['f_status'=>1],['forum.f_id','forum.f_query_question','forum.f_query_brief', 'forum.f_add_tags','forum.f_created_date','users.first_name as user_name']);

        if($forum_list->num_rows() > 0) {
            $forum_reply_by_id = $forum_list->result();

            foreach ($forum_reply_by_id as $key => $value) {
                $condition3 = [
                    'fr_forum_id'=> $value->f_id,
                ];
                $query3 = $this->Api_user_model->get_replies_on_reply_id('forum_reply',$condition3);
                $forum_reply_by_id[$key]->no_of_replies = $query3->num_rows();
                $forum_reply_by_id[$key]->f_created_date = date('d M Y, h:i A', strtotime($value->f_created_date));
            }

            return $this->sendResponse(true, SUCCESS_MSG, [
                'forum_list' => $forum_reply_by_id
            ]);

        } else {
                return $this->sendResponse(true, NO_FORUM);
        }
    }

    //Get Forum by User ID
    public function getForumByUser($user_id)
    {
        $this->request('GET',"user/get-forum-by-user/".$user_id);
        if(!is_numeric($user_id)){
            return $this->sendResponse(false,  USER_NONEXIST_ERROR );
            exit();
          }

            $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 0]);
            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }
            $forum_list = $this->NewApiModel->getForumList('forum',['f_status'=>1,'f_user_id'=>$user_id],['forum.f_id','forum.f_query_question', 'forum.f_add_tags','forum.f_query_brief','forum.f_created_date','users.first_name as user_name']);


            if($forum_list->num_rows() > 0) {
                $forum_reply_by_id = $forum_list->result();
                foreach ($forum_reply_by_id as $key => $value) {

                    $condition3 = [
                        'fr_forum_id'=> $value->f_id,
                    ];
                    $query3 = $this->Api_user_model->get_replies_on_reply_id('forum_reply',$condition3);

                    $forum_reply_by_id[$key]->no_of_replies = $query3->num_rows();
                    $forum_reply_by_id[$key]->f_created_date = date('d M Y, h:i A', strtotime($value->f_created_date));

                }

                return $this->sendResponse(true, SUCCESS_MSG, [
                    'forum_list' => $forum_reply_by_id
                ]);
        } else {
            return $this->sendResponse(true, NO_FORUM);
        }

    }

    //Get Forum Details By ID
    public function getForumDetailById($forum_id)
    {
        $this->request('GET',"user/get-forum-details/".$forum_id);

        $forum = $this->Api_user_model->check_id_exist('forum',['f_id'=>$forum_id,'f_status'=> 1]);

        if($forum->num_rows() === 0){
            return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
            exit();
        }
        $this->updateView($forum_id);
        $detailsMyForum = $this->NewApiModel->getForumDetailById(['f_status'=> 1,'f_id'=>$forum_id])->row();

        $detailsMyForum->f_created_date = date('d M Y, h:i A',strtotime($detailsMyForum->f_created_date));
        $replies = $this->NewApiModel->getForumReplies($forum_id);

        $detailsMyForum->total_replies = $replies->num_rows();

        foreach($replies->result() as $key => $val)
        {
            $val->reply = $this->NewApiModel->getForumReplyReplies($val->fr_id);;
        }

        return $this->sendResponse(true, SUCCESS_MSG ,[
            'forum_details' => $detailsMyForum,
            'replies' => $replies->result()
        ] );
    }

    //Update Views Number
    public function updateView($forum_id)
    {
        $details = $this->NewApiModel->getForumDetailById(['f_status'=> 1,'f_id'=>$forum_id])->row();

        $update = $this->NewApiModel->updateForumView(['f_id' => $forum_id],['f_views' => $details->f_views+1]);

        return $update;
    }

    //Add Reply to Forum
    public function addReplyToForum()
    {
        $this->request('POST', '/user/add-reply-to-forum');
        $this->form_validation->set_rules('forum_id','Forum Id','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('forum_reply','Forum Reply','trim|required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $data = [
                'fr_forum_id' => $this->input->post('forum_id'),
                'fr_user_id' => $this->input->post('user_id'),
                'fr_reply' => $this->input->post('forum_reply')
                ];

            if(!is_numeric($data['fr_user_id'])){
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

            if(!is_numeric($data['fr_forum_id'])){
                return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                exit();
            }

            $forum = $this->Api_user_model->check_id_exist('forum',['f_id'=>$data['fr_forum_id']]);
            $user = $this->Api_user_model->check_id_exist('users',['id'=>$data['fr_user_id']]);

            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

            if($forum->num_rows() === 0) {
                return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                exit();
            }

            $query = $this->Api_user_model->insert_table('forum_reply', $data);

            $condition1 = ['fr_id'=> $query];

            $forum_ids = $this->Api_user_model->get_table_by_id('forum_reply' , $condition1,['fr_id' , 'fr_forum_id' , 'fr_forum_reply_id' , 'fr_user_id' , 'fr_reply' , 'fr_created_date'  , 'users.first_name' , 'users.last_name' , 'users.image']);

            $replyData = $forum_ids->row();

            $replyData->no_of_replies = 0;
            $replyData->replies = [];

            if($query > 0) {
                return $this->sendResponse(true, SUCCESS_MSG , []);
            } else {
                return $this->sendResponse(false,  ERROR_MSG );
            }

        }

    }

    //Add Reply to Forum Reply
    public function addReplyToForumReply()
    {
        $this->request('POST', '/user/add-reply-to-forum-reply');
        $this->form_validation->set_rules('forum_id','Forum Id','trim|required');
        $this->form_validation->set_rules('reply_id','Reply Id','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');
        $this->form_validation->set_rules('reply','Reply','trim|required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $data = [
            'fr_forum_id' => $this->input->post('forum_id'),
            'fr_forum_reply_id' => $this->input->post('reply_id'),
            'fr_user_id' => $this->input->post('user_id'),
            'fr_reply' => $this->input->post('reply'),
            ];

            if(!is_numeric($data['fr_user_id'])){
            return $this->sendResponse(false,  USER_NONEXIST_ERROR );
            exit();
            }

            if(!is_numeric($data['fr_forum_id'])){
            return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
            exit();
            }

            if(!is_numeric($data['fr_forum_reply_id'])){
            return $this->sendResponse(false,  FORUM_REPLY_NONEXIST_ERROR );
            exit();
            }

            $forum = $this->Api_user_model->check_id_exist('forum',['f_id'=>$data['fr_forum_id']]);
            $user = $this->Api_user_model->check_id_exist('users',['id'=>$data['fr_user_id']]);
            $forum_reply = $this->Api_user_model->check_id_exist('forum_reply',['fr_id'=>$data['fr_forum_reply_id']]);

            if($forum->num_rows() === 0){
                return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                exit();
            }

            if($forum_reply->num_rows() === 0){
                return $this->sendResponse(false,  FORUM_REPLY_NONEXIST_ERROR );
                exit();
            }

            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

            $query = $this->Api_user_model->insert_table('forum_reply', $data);

            if($query > 0) {
                return $this->sendResponse(true, SUCCESS_MSG, [
                    ]);
            } else {
                return $this->sendResponse(false,  ERROR_MSG );
            }

        }
    }

    //Delete Forum
    public function deleteForum()
    {
        $this->request('POST',"user/delete-forum");
        $this->form_validation->set_rules('forum_id','Forum Id','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $user_id = $this->input->post('user_id');
            $forum_id = $this->input->post('forum_id');

            $user = $this->Api_user_model->check_id_exist('users',['id'=> $user_id]);

            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

            $forum = $this->Api_user_model->check_id_exist('forum',['f_id'=> $forum_id, 'f_user_id' => $user_id]);

            if($forum->num_rows() === 0)
            {
                return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                exit();
            }

            $this->NewApiModel->deleteForum($forum_id);

            $this->sendResponse(true,"Successfully Deleted",[]);
        }
    }

    //Get Live Free Class
    public function getLiveFreeClass()
    {
        $this->request('POST',"user/get-free-live-class");
        $limit = $this->input->post('limit');
        $date = $this->input->post('date') ? date('Y-m-d',strtotime($this->input->post('date'))) : date('Y-m-d');
        $time = $this->input->post('time') ? $this->input->post('time') :  "00:00";
        $data = $this->NewApiModel->fetchLiveClassList('lctn.* , u.first_name , u.last_name',['live_date >='=> $date, 'live_start_time >' => $time, 'live_payment_type' => "free"],$limit)->result();

        $this->sendResponse(true,"Success",$data);

    }

    //Get Live Paid Class
    public function getLivePaidClass()
    {
        $this->request('POST',"user/get-paid-live-class");
        $limit = $this->input->post('limit');
        $date = $this->input->post('date') ? date('Y-m-d',strtotime($this->input->post('date'))) : date('Y-m-d');
        $time = $this->input->post('time') ? $this->input->post('time') :  "00:00";
        $data = $this->NewApiModel->fetchLiveClassList('lctn.* , u.first_name , u.last_name',['live_date >='=> $date, 'live_start_time >' => $time, 'live_payment_type' => "paid"],$limit)->result();

        $this->sendResponse(true,"Success",$data);

    }

    //Get Live Class Details
    public function getLiveClassDetails()
    {
        $this->request('POST',"user/get-live-class-details");
        $this->form_validation->set_rules('liveclass_id','Forum Id','trim|required');
        $this->form_validation->set_rules('user_id','User Id','trim|required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $user_id = $this->input->post('user_id');
            $live_id = $this->input->post('liveclass_id');

            $user = $this->Api_user_model->check_id_exist('users',['id'=> $user_id]);

            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

            $classLive = $this->Api_user_model->check_id_exist('live_class_time_new',['live_id'=> $live_id]);

            if($classLive->num_rows() === 0)
            {
                return $this->sendResponse(false, "Class Does not exist");
                exit();
            }

            $data = $classLive->row();

            $teacher = $this->Api_user_model->check_id_exist('users',['id'=>$data->instructor_id,'role_id' => 2, 'is_instructor' => 1])->row();

            $data->class_time = date('d M Y',strtotime($data->live_date)).', '.date('h:i A',strtotime($data->live_start_time));

            $data->first_name = $teacher->first_name;
            $data->last_name = $teacher->last_name;
            $data->isWishlist = $this->NewApiModel->isWishlistLive($user_id,$live_id);
            $data->isEnrolled = $this->NewApiModel->isEnrolledtLive($live_id, $user_id);
            $data->isExpired = $this->NewApiModel->isExpiredLive($user_id,$live_id);
            // $data->isEnrolled = false;

            $this->sendResponse(true,"Success",['details' => $data]);

        }

    }

    //Enrol For Free Live Course
    public function enrollForFreeLiveClass()
    {
        $this->request("POST","user/enroll-for-free-live-class");
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('live_id', 'Live Class', 'required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $course_id = $this->input->post('live_id');
            $user_id = $this->input->post('user_id');

            $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 0]);
            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
            }

            $course = $this->NewApiModel->getLiveClassDetails(['live_id' => $course_id, 'live_payment_type' => "free"]);

            if(empty($course))
            {
                $this->sendResponse(false, "Live class not found");
            }

            $totalEnroll = $this->NewApiModel->totalEnrolStudent($course_id);

            if($totalEnroll < $course->number_of_students)
            {
                $check = $this->NewApiModel->liveClassEnrolled($course_id, $user_id);

                if($check)
                {
                    $this->sendResponse(false, "Already Enrolled for this class");
                }

                $enrol = $this->NewApiModel->enrolToFreeLiveClass($course_id, $user_id);


                if($enrol['status'])
                {
                    $title = "Live Class"; 
                    $msg = "A student has enrolled for Live Class."; 
                    $this->NewApiModel->addNotification(['notf_user_id' => $course->instructor_id, 'heading' => $title, 'description' => $msg]);
                    $this->sendNotification($course->instructor_id, $title, $msg);
                    $this->sendResponse(true,$enrol['message']);
                }
                else
                {
                    $this->sendResponse(false,$enrol['message']);
                }
            }
            else
            {
                $this->sendResponse(false,"Class is full");
            }

        }
    }

    //Get Enrolled Free Live Classes by User
    public function getEnrolledLiveClasses($user_id)
    {
        $this->request('GET',"user/get-enrolled-live-class/".$user_id);
        $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id,'role_id' => 2, 'is_instructor' => 0]);
        if($user->num_rows() === 0) {
            $this->sendResponse(false,  USER_NONEXIST_ERROR );

        }

        $my_courses = $this->NewApiModel->my_liveclass($user_id)->result();

        $data = [];

        foreach($my_courses as $key => $val)
        {
            $course_details = $this->Api_user_model->check_id_exist('live_class_time_new',['live_id'=> $val->el_live_id])->row();
            $course_details->class_time = date('d M Y',strtotime($course_details->live_date)).', '.date('h:i A',strtotime($course_details->live_start_time));
            $teacher = $this->Api_user_model->check_id_exist('users',['id'=>$course_details->instructor_id,'role_id' => 2, 'is_instructor' => 1])->row();

            $course_details->first_name = $teacher->first_name;
            $course_details->last_name = $teacher->last_name;
            array_push($data, $course_details);
        }


        $this->sendResponse(true,"Success",['classes' => $data]);
    }

    //Generate Order for Live Class
    public function generateOrderForLiveClass()
    {
        $this->request('POST', '/user/generate-order-for-live-class');
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('live_id', 'Course', 'required');


        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $course_id = $this->input->post('live_id');
            $user_id = $this->input->post('user_id');

            $user = $this->Api_user_model->check_id_exist('users',['id' => $user_id, 'role_id' => 2, 'is_instructor' => 0]);
            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

            $course = $this->NewApiModel->getLiveClassDetails(['live_id' => $course_id]);

            if(empty($course))
            {
                $this->sendResponse(false, "Course not found");
            }

            if($course->live_payment_type == "free")
            {
                $this->sendResponse(false, "This course is free");
            }

            $totalEnroll = $this->NewApiModel->totalEnrolStudent($course_id);

            if($totalEnroll < $course->number_of_students)
            {
            // $check = $this->NewApiModel->liveClassEnrolled($course_id, $user_id);

            // if($check)
            // {
            //     $this->sendResponse(false, "Already Enrolled for this class");
            // }
            // if($course->price != $this->input->post('price'))
            // {
            //     $this->sendResponse(false, "Course price does not match");
            // }

            try{
                $receipt = 'TXN'.time();
                $inramount = $course->price;
                $amount = $inramount * 100;

                $url = "https://api.razorpay.com/v1/orders";

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $RAZOR_KEY = RAZOR_LKEY;

                $headers = array(
                "content-type: application/json",
                "Authorization: Basic $RAZOR_KEY",
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

                $data = '{"amount": "'.$amount.'",
                    "currency": "INR",
                    "receipt": "'.$receipt.'",
                    "partial_payment": false,
                    "first_payment_min_amount": "'.$amount.'"}';

                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

                //for debug only!
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                $resp = curl_exec($curl);
                curl_close($curl);
                // var_dump($resp);
                // return json_encode($resp);
                $respData = json_decode($resp);
                $pdata = [
                    'po_user_id' => $user_id,
                    'po_course_id' => $course_id,
                    'po_price' => $course->price,
                    'po_order_id' => $respData->id,
                    'po_type' => "live",
                ];
                $this->NewApiModel->saveOrderId($pdata);
                $this->sendResponse(true, "Success",$respData);
            }
            catch(Exception $e)
            {
                $this->sendResponse(false, $e->getMessage());
            }

        }
        else
        {
            $this->sendResponse(false, "Class is full");
        }
        }
    }

    //Verify Signature
    public function verifySignatureLive()
    {
        $this->request('POST','user/verify-signature');
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('live_id', 'Course', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');
        $this->form_validation->set_rules('razorpay_payment_id', 'Payment ID', 'required');
        $this->form_validation->set_rules('razorpay_order_id', 'Order ID', 'required');
        $this->form_validation->set_rules('razorpay_signature', 'Signature', 'required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $user_id = $this->input->post('user_id');
            $course_id = $this->input->post('live_id');
            $price = $this->input->post('price');
            $order_id = $this->input->post('razorpay_order_id');
            $payment_id = $this->input->post('razorpay_payment_id');
            $signature = $this->input->post('razorpay_signature');

            $where = [
                'po_user_id' => $user_id,
                'po_course_id' => $course_id,
                'po_price' => $price,
                'po_order_id' => $order_id,
                'po_type' => "live",
                'po_status' => '0'
            ];

            $check = $this->NewApiModel->checkPayOrder($where);

            if($check <= 0)
            {
                return $this->sendResponse(false, "Invalid Request",[]);
            }

            $sig = hash_hmac('sha256', "$order_id|$payment_id", RAZOR_KEY_SECRET);
            $revenue_percentage = get_settings('instructor_revenue');
            if($sig == $signature)
            {

                $instructorData = $this->NewApiModel->getLiveClassDetails(['live_id' => $course_id]);

                $paydata = [
                    'user_id' => $user_id,
                    'payment_type' => "razorpay",
                    'course_id' => $course_id,
                    'amount' => $price,
                    'admin_revenue' => $price,
                    'transaction_id' => $order_id,
                    'razor_payment_id' => $payment_id,
                    'razor_signature' => $signature,
                    'course_type' => "live",
                    'revenue_percentage' => $revenue_percentage,
                    'instructor_id' => $instructorData->instructor_id
                ];

                $course = $this->NewApiModel->getLiveClassDetails(['live_id' => $course_id]);

                $enrollLive = [
                    'el_live_id' => $course_id,
                    'el_user_id' => $user_id,
                    'el_date' => $course->live_date,
                    'el_time' => $course->live_start_time,
                ];

                $this->NewApiModel->enrol_student_live($enrollLive);
                $this->NewApiModel->course_purchase($paydata);
                $this->NewApiModel->updatePayOrder($where);
                $title = "Live Class"; 
                $msg = "A student has enrolled for Live Class."; 
                $this->NewApiModel->addNotification(['notf_user_id' => $instructorData->instructor_id, 'heading' => $title, 'description' => $msg]);
                $this->sendNotification($instructorData->instructor_id, $title, $msg);
                return $this->sendResponse(true, "Payment is successful.",[]);
            }
            else
            {
                return $this->sendResponse(false, "Payment Failed",[]);
            }

        }
    }

    //add live class to wishlist
    //Add To Wishlist
    public function addLiveClasstoWishlist()
    {
        $this->request('POST', '/user/add-live-class-to-wishlist');
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('live_id', 'Class ID', 'required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $course_id = $this->input->post('live_id');
            $user_id = $this->input->post('user_id');

            $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 0]);
            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

            $course = $this->NewApiModel->getLiveClassDetails(['live_id' => $course_id]);

            if(empty($course))
            {
                $this->sendResponse(false, "Live Class not found");
            }

            $addWishlist = $this->NewApiModel->addLiveClassToWishlist($user_id, $course_id);

            $this->sendResponse(true, $addWishlist);

        }
    }

    //Get Wishlist
    public function getLiveClassWishlist($user_id)
    {
        $this->request("GET","/user/get-live-wishlist/".$user_id);

        $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 0]);
        if($user->num_rows() === 0) {
            return $this->sendResponse(false,  USER_NONEXIST_ERROR );
            exit();
        }

        $my_courses = $this->NewApiModel->get_courses_by_live_wishlists($user_id);

        $this->sendResponse(true,"Success",['liveclass' => $my_courses]);

    }

    //get Upcoming Courses
    public function getUpcomingCourses()
    {
        $this->request('POST', 'get-upcoming-courses');
        $limit = $this->input->post('limit');
        $start = $this->input->post('start') ? $this->input->post('start') : 0;
        $data = $this->NewApiModel->getUpcomingCourses($limit, $start);
        // $user_id = $this->input->post('user_id');

        $this->sendResponse(true,"Success",['courses' => $data]);
    }

    //get Notification
    public function getNotification($user_id)
    {
        $this->request('GET',"user/get-notification/".$user_id);

        $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 0]);
        if($user->num_rows() === 0) {
            return $this->sendResponse(false,  USER_NONEXIST_ERROR );
            exit();
        }

        $data = $this->NewApiModel->getNotification($user_id);
        $this->sendResponse(true,"Success", $data);
    }

    //Get Counselling Session
    public function getCounsellingSession()
    {
        $this->request('POST',"get-counselling-session");

        $limit = $this->input->post('limit');
        $data = $this->NewApiModel->getCounsellor($limit);

        foreach($data as $key => $val)
        {
            $val->profile_picture = $this->user_model->get_user_image_url($val->id);
        }

        $this->sendResponse(true,"Success",['counsellor' => $data]);
    }

    //Get Counselling Session Details
    public function getCounsellingSessionDetails()
    {
        $this->request('POST', '/user/get-counselling-session-details');
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('teacher_id', 'Teacher ID', 'required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $user_id = $this->input->post('user_id');
            $teacher_id = $this->input->post('teacher_id');

            $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 0]);
            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

            $teacher = $this->NewApiModel->getTeacherDetailss('users',['id'=>$teacher_id, 'is_instructor' => 1]);

            if(empty($teacher))
            {
                $this->sendResponse(false, "Teacher Does Not Exist");
            }
            $teacher->biography = strip_tags($teacher->biography);
            $teacher->profile_picture = $this->user_model->get_user_image_url($teacher->id);
            $teacher->isWishlist = $this->NewApiModel->isWishlistCounselling($user_id,$teacher->id);
            $teacher->isEnrolled = $this->NewApiModel->isEnrolledCounselling($user_id,$teacher->id);

            $this->sendResponse(true, "Success",['details' => $teacher]);

        }
    }

    //Get Counselling Session Wishlist
    public function addCounsellingtoWishlist()
    {
        $this->request('POST', '/user/add-live-class-to-wishlist');
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('teacher_id', 'Teacher ID', 'required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $user_id = $this->input->post('user_id');
            $teacher_id = $this->input->post('teacher_id');

            $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 0]);
            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

            $teacher = $this->Api_user_model->check_id_exist('users',['id'=>$teacher_id, 'role_id' => 2, 'is_instructor' => 1]);

            if(empty($teacher))
            {
                $this->sendResponse(false, "Teacher Does Not Exist");
            }

            $addWishlist = $this->NewApiModel->addCounsellingSessionToWishlist($user_id, $teacher_id);

            $this->sendResponse(true, $addWishlist);

        }
    }

    //Get Wishlist
    public function getCounsellorWishlist($user_id)
    {
        $this->request("GET","/user/get-counsellor-wishlist/".$user_id);

        $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 0]);
        if($user->num_rows() === 0) {
            return $this->sendResponse(false,  USER_NONEXIST_ERROR );
            exit();
        }

        $my_courses = $this->NewApiModel->get_courses_by_counselling_wishlists($user_id);


        foreach($my_courses as $key => $val)
        {
            $val->profile_picture = $this->user_model->get_user_image_url($val->id);
        }
        $this->sendResponse(true,"Success",['counsellors' => $my_courses]);

    }

    //Get Counselor Slots
    public function getCounsellorSlots()
    {
        $this->request("POST","/user/get-slots/");

        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('teacher_id', 'Teacher ID', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('duration', 'Duration', 'required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $currdate = strtotime(date('Y-m-d'));
            $date = strtotime($this->input->post('date'));

            if($date < $currdate)
            {
                $this->sendResponse(false, "Date cannot be less than the current date");
            }
            else
            {

                $timestamp = strtotime($this->input->post('date'));
                $day = date('l', $timestamp);
                $lowerDay = strtolower($day);
                $teacherId = $this->input->post('teacher_id');
                $tSlotsAvail = $this->NewApiModel->getTeacherSlotsAvail(['teacher_id' => $teacherId, $lowerDay => '1']);


                $data = [];
                $rangeArr = [];

              if($tSlotsAvail)
              {
                  $startT = $lowerDay."_start";
                  $endT = $lowerDay."_end";
                  $startTwo = $lowerDay."_start_two";
                  $endTwo = $lowerDay."_end_two";

                  if($tSlotsAvail->$startT)
                {
                    $startTime = date('H:i',strtotime($tSlotsAvail->$startT));
                    $endtime = date('H:i',strtotime($tSlotsAvail->$endT));

                    $gap = ($this->input->post('duration') == 1) ? 30 : 60;

                    $range = range(strtotime($startTime),strtotime($endtime),$gap*60);


                }

                if($tSlotsAvail->$startTwo)
                {
                    $startTimes = date('H:i',strtotime($tSlotsAvail->$startTwo));
                    $endtimes = date('H:i',strtotime($tSlotsAvail->$endTwo));

                    $gaps = ($this->input->post('duration') == 1) ? 30 : 60;

                    $ranges = range(strtotime($startTimes),strtotime($endtimes),$gaps*60);
                }

                $rangeArr = array_merge($range,$ranges);


                foreach($rangeArr as  $key => $time)
                {

                    $data[$key]['vtime'] = date("H:i:00",$time);
                    $data[$key]['stime'] = date("h:i A",$time);
                    $data[$key]['booked'] = $this->checkIfSlotBooked($teacherId, $this->input->post('date'), $time);
                }
                $this->sendResponse(true, "Success",['slots' => $data]);
              }
              else
              {
                $this->sendResponse(true, "No Slots Available",['slots' => $data]);
              }

            }
        }

    }

    public function checkIfSlotBooked($teacherId, $date, $time)
    {

        $data = $this->NewApiModel->getSlotsForDay($teacherId, $date);

        foreach($data as $getTime){
            $current_time = date('h:i a',$time);
            // echo json_encode($current_time);

            $sunrise = date('h:i a',strtotime($getTime->ec_time));
            $sunset = date('h:i a',strtotime($getTime->ec_end_time));
            $date1 = DateTime::createFromFormat('h:i a', $current_time);


            $date2 = DateTime::createFromFormat('h:i a', $sunrise);
            $date3 = DateTime::createFromFormat('h:i a', $sunset);


            if ($date1 >= $date2 && $date1 <= $date3)
            {
                return 1;
            }

            // if($time > strtotime($getTime->ec_time) && $time < strtotime($getTime->ec_end_time)){
            //     return 1;
            // }
        }

        return 0;
    }

    //Generator Order for Counselling Session
    public function generateOrderForCounselling()
    {
        $this->request('POST', '/user/generate-order');
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('teacher_id', 'Teacher ID', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('duration', 'Duration', 'required');
        $this->form_validation->set_rules('time', 'Time', 'required');


        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $teacher_id = $this->input->post('teacher_id');
            $user_id = $this->input->post('user_id');
            $date = $this->input->post('date');
            $duration = $this->input->post('duration');
            $time = $this->input->post('time');

            $user = $this->Api_user_model->check_id_exist('users',['id' => $user_id, 'role_id' => 2, 'is_instructor' => 0]);
            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

            $teacher = $this->Api_user_model->check_id_exist('users',['id' => $teacher_id, 'role_id' => 2, 'is_instructor' => 1])->row();

            if(empty($teacher))
            {
                $this->sendResponse(false, "Course not found");
            }

            try{
                $receipt = 'TXN'.time();
                $inramount = ($this->input->post('duration') == 2) ? $teacher->hour_price : $teacher->half_price;
                $amount = $inramount * 100;

                $url = "https://api.razorpay.com/v1/orders";

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $RAZOR_KEY = RAZOR_LKEY;

                $headers = array(
                "content-type: application/json",
                "Authorization: Basic $RAZOR_KEY",
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

                $data = '{"amount": "'.$amount.'",
                    "currency": "INR",
                    "receipt": "'.$receipt.'",
                    "partial_payment": false,
                    "first_payment_min_amount": "'.$amount.'"}';

                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

                //for debug only!
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                $resp = curl_exec($curl);
                curl_close($curl);
                // var_dump($resp);
                // return json_encode($resp);
                $respData = json_decode($resp);
                $pdata = [
                    'po_user_id' => $user_id,
                    'po_course_id' => $teacher_id,
                    'po_price' => $inramount,
                    'po_order_id' => $respData->id,
                    'po_type' => "counselling"
                ];
                $this->NewApiModel->saveOrderId($pdata);
                $this->sendResponse(true, "Success",$respData);
            }
            catch(Exception $e)
            {
                $this->sendResponse(false, $e->getMessage());
            }
        }
    }

    //Verify SIgntaure for counselling
    public function verifySignatureCounselling()
    {
        $this->request('POST','user/verify-signature');
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('teacher_id', 'Course', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');
        $this->form_validation->set_rules('razorpay_payment_id', 'Payment ID', 'required');
        $this->form_validation->set_rules('razorpay_order_id', 'Order ID', 'required');
        $this->form_validation->set_rules('razorpay_signature', 'Signature', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('time', 'Time', 'required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $user_id = $this->input->post('user_id');
            $teacher_id = $this->input->post('teacher_id');
            $price = $this->input->post('price');
            $order_id = $this->input->post('razorpay_order_id');
            $payment_id = $this->input->post('razorpay_payment_id');
            $signature = $this->input->post('razorpay_signature');
            $date = $this->input->post('date');
            $time = $this->input->post('time');
            $duration = $this->input->post('duration');


            $where = [
                'po_user_id' => $user_id,
                'po_course_id' => $teacher_id,
                'po_price' => $price,
                'po_order_id' => $order_id,
                'po_type' => "counselling",
                'po_status' => '0'
            ];

            $check = $this->NewApiModel->checkPayOrder($where);

            if($check <= 0)
            {
                return $this->sendResponse(false, "Invalid Request",[]);
            }

            $sig = hash_hmac('sha256', "$order_id|$payment_id", RAZOR_KEY_SECRET);
            $revenue_percentage = get_settings('instructor_revenue');
            if($sig == $signature)
            {
                $paydata = [
                    'user_id' => $user_id,
                    'payment_type' => "razorpay",
                    'course_id' => $teacher_id,
                    'amount' => $price,
                    'admin_revenue' => $price,
                    'transaction_id' => $order_id,
                    'razor_payment_id' => $payment_id,
                    'razor_signature' => $signature,
                    'course_type' => "counselling",
                    'revenue_percentage' => $revenue_percentage,
                    'instructor_id' => $teacher_id
                ];

                if($duration==="1"){
			$endTime = date('H:i', strtotime('+30 minutes',strtotime($time)));
                }else{
			$endTime = date('H:i', strtotime('+1 hour',strtotime($time)));
                }

                $ec = [
                    'ec_teacher_id' => $teacher_id,
                    'ec_user_id' => $user_id,
                    'ec_date' => $date,
                    'ec_time' => $time,
		            'ec_end_time' => $endTime,
                    'ec_price' => $price,
                    'ec_type' => $duration,

                ];

                $this->NewApiModel->enrol_student_counselling($ec);
                $this->NewApiModel->course_purchase($paydata);
                $this->NewApiModel->updatePayOrder($where);
                $title = "Counselling Session"; 
                $msg = "A student has enrolled for counselling session."; 
                $this->NewApiModel->addNotification(['notf_user_id' => $teacher_id, 'heading' => $title, 'description' => $msg]);
                $this->sendNotification($teacher_id, $title, $msg);
                return $this->sendResponse(true, "Payment is successful.",[]);
            }
            else
            {
                return $this->sendResponse(false, "Payment Failed",[]);
            }

        }
    }

    //Get Enrolled Counselling Session
    public function getEnrolledCounselling($user_id)
    {
        $this->request("GET","user/get-enrolled-counselling/".$user_id);

        $user = $this->Api_user_model->check_id_exist('users',['id' => $user_id, 'role_id' => 2, 'is_instructor' => 0]);
        if($user->num_rows() === 0) {
            return $this->sendResponse(false,  USER_NONEXIST_ERROR );
            exit();
        }

        $my_courses = $this->NewApiModel->myCounsellingSession($user_id)->result();

        $data = [];

        foreach($my_courses as $key => $val)
        {
            $teacher = $this->NewApiModel->getTeacherDetails('users',['id'=>$val->ec_teacher_id, 'is_instructor' => 1]);
            $teacher->enrol_id = $val->ec_id;
            $teacher->profile_picture = $this->user_model->get_user_image_url($val->ec_teacher_id);
            // $teacher->isWishlist = $this->NewApiModel->isWishlistCounselling($user_id,$val->ec_teacher_id);
            $teacher->isEnrolled = $this->NewApiModel->isEnrolledCounselling($user_id,$val->ec_teacher_id);
            $teacher->isExpired = $this->NewApiModel->isEnrolledCounselling($user_id,$val->ec_teacher_id);

            $teacher->classtime = date('d M Y',strtotime($val->ec_date))." ".date('h:i A',strtotime($val->ec_time));
            array_push($data, $teacher);
        }

        $this->sendResponse(true,"Success",['classes' => $data]);
    }


    public function socialLogin() {

        $this->request('POST', 'user/socialLogin');

        $this->form_validation->set_rules('socialType','Type','trim|required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0], []);
        } else {
            $type = $this->input->post('socialType');
            $socialId = $this->input->post('socialId');

            $check = $this->NewApiModel->socialCheck($type, $socialId);

            if(!empty($check)){
                $data = [
                    'socialType'   => $this->input->post('socialType'),
                    'socialId'   => $this->input->post('socialId'),
                ];

                $query = $this->NewApiModel->socialLogin($data);

                if($query) {
                    return $this->sendResponse(true, "Successfully Login", [
                        'userId' => $query
                    ]);
                } else {
                    return $this->sendResponse(false, "Something went wrong, please try again");
                }

            } else {

                $firstName = $this->input->post('first_name');

                if (empty(trim($firstName))) {
                    $this->sendResponse(false, "Account not found, Please register.");
                }

                $data = [
                    'first_name' => $this->input->post('first_name') . ' ' . $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'socialType' => $this->input->post('socialType'),
                    'socialId' => $this->input->post('socialId'),
                    'firebase_token' => $this->input->post('firebase_token'),
                    'platform' => $this->input->post('platform'),
                    'role_id' => 2,
                    'is_instructor' => 0,
                    'status' => 1
                ];

                $query = $this->NewApiModel->registerUser('users', $data);

                if($query) {
                    return $this->sendResponse(true, "Successfully Registered", [
                        'userId' => $query
                    ]);
                } else {
                    return $this->sendResponse(false, "Something went wrong, please try again");
                }
            }
        }

    }

    //send message
    public function sendMessage()
    {
        $this->request('POST', 'user/send-mesasge');

        $this->form_validation->set_rules('userId', 'User ID', 'required');
        $this->form_validation->set_rules('classId', 'User ID', 'required');
        $this->form_validation->set_rules('message', 'User ID', 'required');
        $this->form_validation->set_rules('type', 'User ID', 'required');
       
        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {

            $data = [

                'cc_user_id' => $this->input->post('userId',true),
                'cc_class_id' => $this->input->post('classId',true),
                'cc_message' => $this->input->post('message',true),
                'cc_type' => $this->input->post('type',true),
            ];

            $query = $this->NewApiModel->sendMessage($data);

           if($query){
               return $this->sendResponse(true, "Success");
           } else {
               return $this->sendResponse(false, "Something went wrong, please try again");
           }
        }
    }

    //Get Live Class message
    public function getMessage($classId)
    {
        $data = $this->NewApiModel->getMessage($classId);

        $this->sendResponse(true,"Success",$data);
    }

    //Add Review 
    public function addReview()
    {
        $this->request("POST","user/add-review");
        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('course_id', 'Course', 'required');

        if($this->form_validation->run() == false)
        {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $course_id = $this->input->post('course_id');
            $user_id = $this->input->post('user_id');
            $course = $this->NewApiModel->getCourseDetails($course_id);

            $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 0]);
            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }

            if(empty($course))
            {
                $this->sendResponse(false, "Course not found");
            }

            $review = $this->NewApiModel->checkReviewExist($course_id,$user_id);

            if($review)
            {   
                $enrol = $this->NewApiModel->addUpdateReview($course_id, $user_id,"update");
                $msg2 = "You have not made any changes";
            }
            else
            {
                $enrol = $this->NewApiModel->addUpdateReview($course_id, $user_id,"insert");
                $msg2 = "Something went wrong, please try again";
            }

            
            $this->sendResponse(true,"Review Added Successfully");
           
        }
    }

    //Delete Review
    public function deleteReview($reviewId, $user_id)
    {
       
            $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 0]);
            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
            }
            $review = $this->NewApiModel->checkReviewExist($reviewId,$user_id);

            if(!$review) {
                return $this->sendResponse(false,  "Review doesn't exist");
                exit();
            }
           
            $enrol = $this->NewApiModel->deleteReview($reviewId, $user_id);

            if($enrol)
            {
            $this->sendResponse(true,"Deleted Successfully");
            }
            else
            {
                $this->sendResponse(false,"Something went wrong, please try again");
            }
    }

    //Get User Review
    public function getUserReview($user,$courseid)
    {
         $data = $this->db->where(['ratable_id' => $courseid, 'user_id' => $user])->get('rating')->row();
         
         $this->sendResponse(true,"Success",[
             'review' => ($data) ? $data->review : "",
             'courseId' => $courseid,
             'rating' => ($data) ? (int)$data->rating : ""
         ]);
    }
    
    public function sendOtpForVerification($type = 'Verify')
    {
        $name = isset($_GET['name']) ? $_GET['name'] : null;
        $email = isset($_GET['email']) ? $_GET['email'] : null;
        $mobile = isset($_GET['mobile']) ? $_GET['mobile'] : null;
        $userId = isset($_GET['userId']) ? $_GET['userId'] : null;
        $otp = rand(1111, 9999);

        if (!empty($userId)) {
            $type = 'Change';
        }

        if (!empty($email)) {
            $checkEmail = $this->NewApiModel->checkUniqueEmail($email, $userId);
            if (!empty($checkEmail)) {
                $this->sendResponse(false, 'Email is already registered.');
            }
        }

        if (!empty($mobile)) {
            $checkMobile = $this->NewApiModel->checkUniqueMobile($mobile, $userId);
            if (!empty($checkMobile)) {
                $this->sendResponse(false, 'Mobile number is already registered.');
            }
        }

        if ($type === 'Verify') {
            $subject = 'Update Credentials';
            $message = "Dear user, Your OTP to update credentials is $otp. Do not share OTP with anyone";
        } else {
            $subject = 'Account Verification';
            $message = "Dear user, Your OTP for registration is $otp Use this password to validate your Login. Do Not Share OTP with anyone";
        }

        // send OTP and return OTP in response.
        if (!empty($email)) {
            $msg = $this->load->view('email/common_template', [
                'subject' => $subject,
                'to_name' => $name,
                'message' => $message,
            ], true);
            $this->sendEmail($name, $email, $subject, $msg);
        }

        if (!empty($mobile)) {
            $this->sendBulkSms(ucfirst($type), $mobile, $otp);
        }

        $this->sendResponse(true, ucfirst($type), [
            'otp' => $otp
        ]);
    }

    public function getBanners()
    {
        $result = $this->crud_model->getBanners();
        $this->sendResponse(true, 'Banners', $result);
    }

    /* ===============CRON JOBS=============== */

    /* Send notification to all users and teachers in a live class before 10 min */
    public function liveClassWarning()
    {
        $liveClasses = $this->NewApiModel->getCurrentLiveClasses();
        foreach ($liveClasses as $liveClass) {
            $this->firebaseNotification($liveClass['user_id'], $liveClass['token'], $liveClass['title'], $liveClass['message']);
        }
        echo json_encode([
            'notifications_sent' => count($liveClasses)
        ]);
    }

    /* Send notification to all users and teachers in a live class when class starts */
    public function liveClassStart()
    {
        $liveClasses = $this->NewApiModel->getCurrentLiveClasses(true);
        foreach ($liveClasses as $liveClass) {
            $this->firebaseNotification($liveClass['user_id'], $liveClass['token'], $liveClass['title'], $liveClass['message']);
        }
        echo json_encode([
            'notifications_sent' => count($liveClasses)
        ]);
    }

    /* send notification to user and teacher in a counselling session before 10 min */
    public function counsellingSessionWarning()
    {
        $notifications = $this->NewApiModel->getCurrentSessions();
        foreach ($notifications as $notification) {
            $this->firebaseNotification($notification['user_id'], $notification['token'], $notification['title'], $notification['message']);
        }

        echo json_encode([
            'notifications_sent' => count($notifications)
        ]);
    }

    /* send notification to user and teacher in a counselling session when class starts */
    public function counsellingSessionStart()
    {
        $notifications = $this->NewApiModel->getCurrentSessions(true);
        foreach ($notifications as $notification) {
            $this->firebaseNotification($notification['user_id'], $notification['token'], $notification['title'], $notification['message']);
        }

        echo json_encode([
            'notifications_sent' => count($notifications)
        ]);
    }

    /* ===============CRON JOBS ENDS=============== */


    public function updateClassStudentCount()
    {
        $classId = $this->input->post('classId', true);
        $count = $this->input->post('count', true);

        $this->NewApiModel->updateLiveStudentCount($classId, $count);
    }

    public function getClassStudentCount($classId)
    {
        $count = $this->NewApiModel->getLiveStudentCount($classId);
        $this->sendResponse(true, 'count', [
            'count' => $count
        ]);
    }
}
