<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NewApiModel extends CI_Model
{
    //Get All States
    public function getAllState()
    {
        $this->db->where('country_id',101);
        $res = $this->db->get('states')->result();
        return $res;
    }

    //Register New Student
    public function registerUser($table, $data){
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

    //Login
    public function loginCheck($table, $email, $password)
    {
        $array = array('role_id' => 2, 'is_instructor' => 0, 'password' => sha1($password));
        if(is_numeric($email)){
            $where = array_merge($array,array('phone' => $email));
        }else{
            $where = array_merge($array,array('email' => $email));
        }
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();

        return $query;
    }

    //Get Free Courses
    public function getFreeCourses($limit, $start)
    {
        $this->db->limit($limit);
        $this->db->where('id >', $start);
        $this->db->where('is_free_course',1);
        $this->db->where('is_upcoming_course','0');
        $query = $this->db->get("course");
        return $query->result();
    }

    //Get Paid Courses
    public function getPaidCourses($limit, $start)
    {
        $this->db->limit($limit);
        $this->db->where('id >', $start);
        $this->db->where_in('is_free_course', [null, 0]);
        $this->db->where('is_upcoming_course','0');
        $query = $this->db->get("course");
        return $query->result();
    }

    //Course Details
    public function getCourseDetails($course_id)
    {
        $this->db->where('id',$course_id);
        $query = $this->db->get("course");
        return $query->row();
    }

    //Reviews
    public function getLimitedReviews($course_id)
    {
        $this->db->select('u.first_name, u.last_name, rating.*');
        $this->db->join('users u','u.id=rating.user_id','inner');
        $this->db->limit(3);
        return $this->db->get_where('rating', array('ratable_type' => "course", 'ratable_id' => $course_id));
    }

    public function getAllReviews($course_id)
    {
        $this->db->select('u.first_name, u.last_name, rating.*');
        $this->db->join('users u','u.id=rating.user_id','inner');
        return $this->db->get_where('rating', array('ratable_type' => "course", 'ratable_id' => $course_id));
    }

    public function setCourseClick($course_id, $user_id){
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $enroll = $this->db->get('enrol');
        if ($enroll->num_rows() == 0) {
            $this->db->where('user_id', $user_id);
            $this->db->where('course_id', $course_id);
            $clicks = $this->db->get('user_clicks');
            if ($clicks->num_rows() > 0) {
                $this->db->where('user_id', $user_id);
                $this->db->where('course_id', $course_id);
                $this->db->delete('user_clicks');
            }
            $this->db->set('user_id', $user_id);
            $this->db->set('course_id', $course_id);
            $this->db->insert('user_clicks');
        }
        return true;
    }

    //Get Sections
    public function getLimitedSection($id)
    {
        // $this->db->limit(3);
        return $this->db->get_where('section', array('course_id' => $id));
    }

    //Get All Section By Course
    public function getAllSection($id)
    {
        return $this->db->get_where('section', array('course_id' => $id));
    }

    //Update Password
    public function updatePassword($userid, $oldPassword, $newPassword)
    {
        $this->db->where('id', $userid);
        $this->db->where('is_instructor', 0);
		$user = $this->db->get('users')->row();

		if (!empty($user)) {

			if (sha1($oldPassword) === $user->password) {

				$this->db->set('password', password_hash($newPassword, PASSWORD_BCRYPT));
				$this->db->where('id', $userid);
				$this->db->update('users');
				return $this->db->affected_rows() === 1;
			}
			return false;
		}
		return false;
    }

    //Check Email
    public function checkEmail($userid, $email)
    {
        $this->db->where('email', $email);
        $this->db->where('is_instructor', 0);
        $this->db->where('id !=', $userid);
        $query = $this->db->get('users');

        return $query->num_rows();
    }

    //Check Mobile
    public function checkPhone($userid, $mobile)
    {
        $this->db->where('phone', $mobile);
        $this->db->where('is_instructor', 0);
        $this->db->where('id !=', $userid);
        $query = $this->db->get('users');

        return $query->num_rows();
    }

    //Update Profile
    public function updateProfile($userid, $data)
    {
        $this->db->where('id',$userid);
        $this->db->where('is_instructor', 0);
	    $this->db->update('users', $data);

        if($this->db->affected_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    //Check Email or Phone Number Exist
    public function checkEmailExist($email)
    {
        $array = array('role_id' => 2, 'is_instructor' => 0);
        if(is_numeric($email)){
            $where = array_merge($array,array('phone' => $email));
        }else{
            $where = array_merge($array,array('email' => $email));
        }
        $this->db->select('*');

        $this->db->where($where);
        $query = $this->db->get('users');

        return $query;
    }

    //Update Forget Password Status
    public function updateForgetPasswordStatus($email)
    {
        $this->db->where('email', $email);
        $this->db->or_where('phone', $email);
        $this->db->where('is_instructor', 0);
        $this->db->update('users',['password_reset_status' => 1]);

        if($this->db->affected_rows() > 0)
        {
            return true;
        }
    }

    //Reset Password
    public function resetPassword($email, $password)
    {
        $this->db->where('password_reset_status',1);
        $this->db->where('email', $email);
        $this->db->or_where('phone', $email);
        $this->db->where('is_instructor', 0);
        $this->db->update('users',['password' => sha1($password),'password_reset_status' => 0]);

        if($this->db->affected_rows() > 0)
        {
            return true;
        }
    }

    //Add To Wishlist
    public function addToWishlist($userid, $course_id)
    {
        $wishlists = array();
        $user_details = $this->user_model->get_user('','','',$userid)->row_array();
        if ($user_details['wishlist'] == "") {
            array_push($wishlists, $course_id);
            $msg = "Added to Wishlist";
        } else {
            $wishlists = json_decode($user_details['wishlist']);
            if (in_array($course_id, $wishlists)) {
                $container = array();
                foreach ($wishlists as $key) {
                    if ($key != $course_id) {
                        array_push($container, $key);
                    }
                    else
                    {

                    }

                }
                $wishlists = $container;
                // $key = array_search($course_id, $wishlists);
                // unset($wishlists[$key]);
                $msg = "Removed from Wishlist";
            } else {
                array_push($wishlists, $course_id);
                $msg = "Added to Wishlist";
            }
        }

        $updater['wishlist'] = json_encode($wishlists);
        $this->db->where('id', $userid);
        $this->db->update('users', $updater);

        return $msg;
    }

    //Is added to wishlist
    public function is_added_to_wishlist($course_id = "", $user_id = "")
    {
        $wishlists = array();
        $user_details = $this->user_model->get_user('', '', '', $user_id)->row_array();

        $wishlists = json_decode($user_details['wishlist']);

        if($wishlists)
        {
            if (in_array($course_id, $wishlists)) {
                return true;
            } else {
                return false;
            }
        }
        else
        {
            return false;
        }

    }

    public function get_courses_by_wishlists($user_id)
    {
        $wishlists = $this->getWishLists($user_id);
        if (empty($wishlists)) {
            return [];
        }
        if (sizeof($wishlists) > 0) {
            $this->db->where_in('id', $wishlists);
            return $this->db->get('course')->result_array();
        } else {
            return array();
        }
    }

    //Get Wishlist
    public function getWishLists($user_id = "")
    {
        $user_details = $this->user_model->get_user('','','',$user_id)->row_array();
        return json_decode($user_details['wishlist']);
    }

    //Enrol to free course
    public function enrol_to_free_course($course_id = "", $user_id = "")
    {

        $course_details = $this->get_course_by_id($course_id)->row_array();
        if ($course_details['is_free_course'] == 1) {
            $data['course_id'] = $course_id;
            $data['user_id']   = $user_id;
            if ($this->db->get_where('enrol', $data)->num_rows() > 0) {

                $returnStatus = ['status' => true, "message" => "You are already enrolled to this course"];
            } else {
                $data['date_added'] = strtotime(date('D, d-M-Y'));
                $data['date_expire'] = strtotime(date('D, d-M-Y',strtotime('+'.$course_details['duration'].'days')));
                $this->db->insert('enrol', $data);

                $returnStatus = ['status' => true, "message" => "Successfully Enrolled"];
            }
        } else {

            $returnStatus = ['status' => true, "message" => "This course is not free"];
        }

        return $returnStatus;
    }

    //Course by ID
    public function get_course_by_id($course_id = "")
    {
        $this->db->select('id, title, thumbnail, is_free_course, duration');
        return $this->db->get_where('course', array('id' => $course_id));
    }

    //Enrolled courses
    public function my_courses($user_id = "") {
        return $this->db->get_where('enrol', array('user_id' => $user_id, 'status' => 1));
    }

    public function my_courses_installment($user_id = "") {
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 1);
        $this->db->group_by('course_id');
        return $this->db->get('enrol_by_installments');
    }

    public function get_course_installments_details($course_id){
        $this->db->where('course_id ', $course_id);
        $this->db->where('status', 1);
        return $this->db->get('enrol_by_installments');
    }

    //Save Payment Order
    public function saveOrderId($data)
    {
        $this->db->insert('payments_orders', $data);

        if($this->db->affected_rows() > 0)
        {
            return true;
        }
    }

    //Check Pay Order
    public function checkPayOrder($where)
    {
        $this->db->where($where);
        $query = $this->db->get('payments_orders');
        return $query->num_rows();
    }

      //Check Pay Order
      public function updatePayOrder($where)
      {
          $this->db->set('po_status','1');
          $this->db->where($where);
          $this->db->update('payments_orders');
         if($this->db->affected_rows() > 0)
         {
             return true;
         }
      }

      public function get_enroll_by_installment($user_id, $course_id, $installment){
        $where['user_id'] = $user_id;
        $where['course_id'] = $course_id;
        $where['installments'] = $installment;
        $this->db->where($where);
        $query = $this->db->get('enrol_by_installments');
        return $query;
      }

    //Enrol Student to paid course
    public function enrol_student($user_id, $course_id)
    {
        $course_details = $this->get_course_by_id($course_id)->row_array();

        $data['course_id'] = $course_id;
        $data['user_id']   = $user_id;
        $data['date_added'] = strtotime(date('D, d-M-Y'));
        $data['date_expire'] = strtotime(date('D, d-M-Y',strtotime('+'.$course_details['duration'].'days')));
        $this->db->insert('enrol', $data);

        return true;
    }

    public function enrol_student_installments($user_id, $course_id, $installment)
    {
        foreach (json_decode($installment) as $key => $value) {
            $course_details = $this->get_course_by_id($course_id)->row_array();

            $data['course_id'] = $course_id;
            $data['user_id']   = $user_id;
            $data['date_added'] = strtotime(date('D, d-M-Y'));
            $data['installments'] = $value;
            $data['date_expire'] = strtotime(date('D, d-M-Y',strtotime('+'.$course_details['duration'].'days')));
            $this->db->insert('enrol_by_installments', $data);
        }

        return true;
    }

    //Course Purchased
    public function course_purchase($data)
    {
        $data['date_added'] = strtotime(date('D, d-M-Y'));
        $data['month'] = date('m');
        $data['year'] = date('Y');
        $this->db->insert('payment', $data);
        return true;
    }

    //Get All Quiz
    public function getAllQuiz()
    {
        $this->db->select('quiz.*');
        $this->db->join('question','question.quiz_id = quiz.q_id','inner');
        $this->db->distinct('quiz.q_id');
        $this->db->order_by('quiz.q_id',"desc");
        return $this->db->get('quiz');
    }

    //Get Question by ID
    public function getQuestion($id)
    {
        $this->db->where('id',$id);
        return $this->db->get('question')->row();
    }

    //Save quiz submit
    public function quiz_histories($data)
    {
        return $this->db->insert('quiz_histories',$data);
    }

    //Get Forum List
    public function getForumList($table,array $condition=[],array $columns=[]){

		$this->db->select($columns);
		$this->db->from($table);
		if($table === 'forum'){
		    $this->db->join('users','users.id = forum.f_user_id','right');
		}
		elseif($table === 'forum_reply') {
		    $this->db->join('users','users.id = forum_reply.fr_user_id','right');
		}
		$this->db->where($condition);
        $this->db->order_by('f_id',"desc");
        return $this->db->get();
	}

    //Get Forum Details by ID
    public function getForumDetailById($where)
    {
        $this->db->select('u.first_name, u.last_name, forum.*');
        $this->db->join('users u','u.id=forum.f_user_id','inner');
        return $this->db->get_where('forum', $where);
    }

    //Get Forum Replies
    public function getForumReplies($forum_id)
    {
        $this->db->select('u.first_name, u.last_name, forum_reply.*');
        $this->db->join('users u','u.id=forum_reply.fr_user_id','inner');
        return $this->db->get_where('forum_reply', ['fr_forum_id' => $forum_id,'fr_forum_reply_id' => null]);
    }

    //Get Forum Reply Replies
    public function getForumReplyReplies($forum_id)
    {
        $this->db->select('u.first_name, u.last_name, forum_reply.*');
        $this->db->join('users u','u.id=forum_reply.fr_user_id','inner');
        $query = $this->db->get_where('forum_reply', ['fr_forum_reply_id' => $forum_id]);

        return $query->result();
    }

    //Delete Forum
    public function deleteForum($forum_id)
    {
        $this->db->where('f_id',$forum_id);
        $this->db->delete('forum');

        $this->deleteForumReply($forum_id);
        return true;
    }

    //Delete Forum Reply
    public function deleteForumReply($forum_id)
    {
        $this->db->where('fr_forum_id',$forum_id);
        $this->db->delete('forum_reply');

        return true;
    }

    //Update Forum View
    public function updateForumView($where,$data)
    {
        $this->db->where($where);
        $this->db->update('forum',$data);
        // if($this->db->affected_rows() > 0)
        // {
        //     return true;
        // }

        return true;
    }

    //fetch live class list
    public function fetchLiveClassList($select2='', array $condition=[],$limit)
    {
       $this->db->select($select2);
       $this->db->from('live_class_time_new lctn');
       $this->db->join('users u','u.id=lctn.instructor_id','inner');
       $this->db->limit($limit);
       $this->db->where($condition);
       $this->db->order_by('live_date',"ASC");
       $this->db->order_by('live_start_time',"ASC");
       return $this->db->get();
    }

    //Get Live Class Details
    public function getLiveClassDetails($where)
    {
        $this->db->where($where);
        $query = $this->db->get("live_class_time_new");
        return $query->row();
    }

    //Check Student Enrol for live class or not
    public function isEnrolledtLive($live_id, $user_id)
    {
        $this->db->where('el_live_id',$live_id);
        $this->db->where('el_user_id',$user_id);
        $q = $this->db->get('enroll_live');

        if($q->num_rows() > 0)
        {
            $data = $q->row();
            if(strtotime($data->el_date." ".$data->el_time) < strtotime(date('Y-m-d H:i:00')))
            {
                return true;
            }
            return true;
        }

       return false;
    }

    //Enrol to free course
    public function enrolToFreeLiveClass($course_id = "", $user_id = "")
    {
        $course_details = $this->getLiveClassDetails(['live_id' => $course_id]);
        if ($course_details->live_payment_type == "free") {
            $data['el_live_id'] = $course_id;
            $data['el_user_id']   = $user_id;
            if ($this->db->get_where('enroll_live', $data)->num_rows() > 0) {

                $returnStatus = ['status' => true, "message" => "You are already enrolled to this course"];
            } else {
                // $data['date_added'] = strtotime(date('D, d-M-Y'));
                // $data['date_expire'] = strtotime(date('D, d-M-Y',strtotime('+'.$course_details['duration'].'days')));
                $this->db->insert('enroll_live', $data);

                $returnStatus = ['status' => true, "message" => "Successfully Enrolled"];
            }
        } else {

            $returnStatus = ['status' => true, "message" => "This course is not free"];
        }

        return $returnStatus;
    }

    //Enrolled courses
    public function my_liveclass($user_id = "") {
        return $this->db->get_where('enroll_live', array('el_user_id' => $user_id));
    }

    //Enrol for live class
    public function enrol_student_live($data)
    {
        // $data['el_live_id'] = $course_id;
        // $data['el_user_id']   = $user_id;
        $this->db->insert('enroll_live', $data);

        return true;
    }

     //Enrol to free course
     public function isEnrolCourse($course_id = "", $user_id = "")
     {
        $data['course_id'] = $course_id;
        $data['user_id']   = $user_id;
        $data['status'] = 1;
        if ($this->db->get_where('enrol', $data)->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
     }


    //Add To Wishlist
    public function addLiveClassToWishlist($userid, $course_id)
    {

        $wishlists = array();
        $user_details = $this->user_model->get_user('','','',$userid)->row_array();


        if ($user_details['live_wishlist'] == "") {
            array_push($wishlists, $course_id);

            $msg = "Added to Wishlist";
        } else {
            $wishlists = json_decode($user_details['live_wishlist']);
            if (in_array($course_id, $wishlists)) {
                $container = array();
                foreach ($wishlists as $key) {
                    if ($key != $course_id) {
                        array_push($container, $key);
                    }
                    else
                    {

                    }

                }
                $wishlists = $container;
                // $key = array_search($course_id, $wishlists);
                // unset($wishlists[$key]);
                $msg = "Removed from Wishlist";
            } else {
                array_push($wishlists, $course_id);
                $msg = "Added to Wishlist";
            }
        }

        $updater['live_wishlist'] = json_encode($wishlists);
        $this->db->where('id', $userid);
        $this->db->update('users', $updater);

        return $msg;
    }

    public function get_courses_by_live_wishlists($user_id)
    {
        $wishlists = $this->getLiveClassWishLists($user_id);

        if (empty($wishlists)) {
            return [];
        }

        if (sizeof($wishlists) > 0) {
            $this->db->select('live_class_time_new.*,users.first_name, users.last_name');
            $this->db->join('users','users.id = live_class_time_new.instructor_id','inner');
            $this->db->where_in('live_id', $wishlists);
            return $this->db->get('live_class_time_new')->result_array();
        } else {
            return array();
        }
    }

    public function getLiveClassWishLists($user_id = "")
    {
        $user_details = $this->user_model->get_user('','','',$user_id)->row_array();
        return json_decode($user_details['live_wishlist']);
    }

     //Get Upcoming Courses
     public function getUpcomingCourses($limit, $start)
     {
         $this->db->limit($limit);
         $this->db->where('id >', $start);
         $this->db->where('is_upcoming_course','1');
         $query = $this->db->get("course");
         return $query->result();
     }

     //Get Counsellor
     public function getCounsellor($limit)
     {
         $this->db->select('users.id,users.first_name,users.last_name,profile_picture,half_price,hour_price,rating');
         $this->db->join('schedules','schedules.teacher_id = users.id','inner');
         $this->db->limit($limit);
         $this->db->where('users.status',1);

         $query = $this->db->get('users');

         return $query->result();
     }

     //Add To Wishlist
    public function addCounsellingSessionToWishlist($userid, $teacher_id)
    {

        $wishlists = array();
        $user_details = $this->user_model->get_user('','','',$userid)->row_array();


        if ($user_details['session_wishlist'] == "") {
            array_push($wishlists, $teacher_id);

            $msg = "Added to Wishlist";
        } else {
            $wishlists = json_decode($user_details['session_wishlist']);
            if (in_array($teacher_id, $wishlists)) {
                $container = array();
                foreach ($wishlists as $key) {
                    if ($key != $teacher_id) {
                        array_push($container, $key);
                    }
                    else
                    {

                    }

                }
                $wishlists = $container;
                // $key = array_search($course_id, $wishlists);
                // unset($wishlists[$key]);
                $msg = "Removed from Wishlist";
            } else {
                array_push($wishlists, $teacher_id);
                $msg = "Added to Wishlist";
            }
        }

        $updater['session_wishlist'] = json_encode($wishlists);
        $this->db->where('id', $userid);
        $this->db->update('users', $updater);

        return $msg;
    }

    public function get_courses_by_counselling_wishlists($user_id)
    {
        $wishlists = $this->getLiveCounsellingWishLists($user_id);
        if (empty($wishlists)) {
            return [];
        }

        if (sizeof($wishlists) > 0) {
            $this->db->select('users.id,users.first_name,users.last_name,profile_picture,half_price,hour_price,rating');
            $this->db->where_in('id', $wishlists);
            return $this->db->get('users')->result();
        } else {
            return array();
        }
    }

    public function getLiveCounsellingWishLists($user_id = "")
    {
        $user_details = $this->user_model->get_user('','','',$user_id)->row_array();
        return json_decode($user_details['session_wishlist']);
    }

    //get Teacher details
    public function getTeacherDetails($table, $where)
    {
        $this->db->select('users.id, users.first_name, users.last_name, users.half_price, users.hour_price,language,rating');
        $this->db->where($where);
        $query = $this->db->get($table);

        return $query->row();

    }

    public function getTeacherDetailss($table, $where)
    {
        $this->db->select('users.id, users.first_name, users.last_name, users.half_price, users.hour_price,language,rating,biography');
        $this->db->where($where);
        $query = $this->db->get($table);

        return $query->row();

    }

    //Enrol for counselling class
    public function enrol_student_counselling($data)
    {

        $this->db->insert('enroll_counselling', $data);

        return true;
    }

    //IS Wishlist Live
    public function isWishlistLive($userid, $live_id)
    {
        $user_details = $this->user_model->get_user('','','',$userid)->row_array();

        $wishlists = json_decode($user_details['live_wishlist']);

        if($wishlists)
        {
            if (in_array($live_id, $wishlists)) {

                return true;
            }
            else
            {
                return false;
            }
        }

        return false;

    }

    //IS Enrolled Live
    // public function isEnrolledtLive($userid, $live_id)
    // {

    //     $check = $this->db->get_where('enroll_live', array('el_user_id' => $userid, 'el_live_id' => $live_id));

    //     if ($check) {

    //         return true;
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }

    //IS Wishlist Counselling
    public function isWishlistCounselling($userid, $teacher_id)
    {
        $user_details = $this->user_model->get_user('','','',$userid)->row_array();

        $wishlists = json_decode($user_details['session_wishlist']);

        if($wishlists)
        {
            if (in_array($teacher_id, $wishlists)) {

                return true;
            }
            else
            {
                return false;
            }
        }
        return false;

    }

    //IS Enrolled Live
    public function isEnrolledCounselling($userid, $teacher_id)
    {
        $check = $this->db->get_where('enroll_counselling', array('ec_user_id' => $userid, 'ec_teacher_id' => $teacher_id));

        if ($check) {

            return true;
        }
        else
        {
            return false;
        }
    }

    //IS Wishlist Counselling
    public function isWishlistCourse($userid, $course_id)
    {
        $user_details = $this->user_model->get_user('','','',$userid)->row_array();

        $wishlists = json_decode($user_details['wishlist']);

        if($wishlists)
        {
            if (in_array($course_id, $wishlists)) {

                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }

    }

    //IS Enrolled Live
    public function isEnrolledtCourse($userid, $course_id)
    {
        $check = $this->db->order_by('id','DESC')-> get_where('enrol', array('user_id' => $userid, 'course_id' => $course_id, 'status' => 1))->row();

        if($check)
        {
            if ($check->date_expire > strtotime(date('D, d-M-Y'))) {

                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }

    }

    public function isEnrolledtCourseByInstallment($userid, $course_id)
    {
        $check = $this->db->order_by('id','DESC')-> get_where('enrol_by_installments', array('user_id' => $userid, 'course_id' => $course_id, 'status' => 1))->row();

        if($check)
        {
            if ($check->date_expire > strtotime(date('D, d-M-Y'))) {

                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }

    }

    public function isCourseInCart($userid, $course_id)
    {
        $check = $this->db->get_where('cart', array('user_id' => $userid, 'course_id' => $course_id))->row();

        if($check)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    public function isInstallmentEnebaled($userid, $course_id)
    {
        $check = $this->db->get_where('partial_payment_courses', array('course_id' => $course_id))->row();

        if($check)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    public function isInstallmentPaidDetails($userid, $course_id)
    {
        $check = $this->db->get_where('partial_payment_courses', array('course_id' => $course_id))->row();

        $array = [];

        if($check)
        {
            for ($i=1; $i < $check->no_of_installments+1 ; $i++) {
                $array[$i]['installment'] = $i;
                $check2 = $this->db->get_where('enrol_by_installments', array('course_id' => $course_id, 'user_id' => $userid, 'installments' => $i))->row();
                if ($check2) {
                    $array[$i]['isInstallmentPaid'] = true;
                }else{
                    $array[$i]['isInstallmentPaid'] = false;
                }
            }
            return $arr = $array;
        }
        else
        {
            return $arr = [];
        }

    }

    public function installment_section_access($user_id,$course_id,$sec){
        $check = $this->db->get_where('enrol_by_installments', array('user_id' => $user_id, 'course_id' => $course_id, 'status' => 1))->result();
        $ins = [];
        foreach ($check as $key => $value) {
            $ins[] = $value->installments;
        }
        $this->db->where('section_id', $sec);
        $this->db->where('course_id', $course_id);
        $this->db->where_in('access', $ins);
        $section = $this->db->get('partial_payments_sections');
        if ($section->num_rows() > 0) {
            return true;
        }else{
            return false;
        }
    }

    public function section_details($course_id,$section_id){
        $this->db->where('id', $section_id);
        $this->db->where('course_id', $course_id);
        $section = $this->db->get('section');
        return $section->row();
    }

    public function isExpiredLive($live_id, $user_id)
    {
        $this->db->where('el_live_id',$live_id);
        $this->db->where('el_user_id',$user_id);
        $q = $this->db->get('enroll_live');

        if($q->num_rows() > 0)
        {
            $data = $q->row();
            if(strtotime($data->el_date." ".$data->el_time) < strtotime(date('Y-m-d H:i:00')))
            {
                return true;
            }
            return false;
        }

       return true;
    }

    //Enrolled Counselling
    public function myCounsellingSession($user_id = "") {
        return $this->db->get_where('enroll_counselling', array('ec_user_id' => $user_id));
    }

    //Check Day Availability
    public function getTeacherSlotsAvail($where = [])
    {

        $this->db->where($where);
        $q = $this->db->get('schedules');
        return $q->row();
    }

    //Get Slots for day
    public function getSlotsForDay($teacher_id, $date)
    {
        $this->db->where('ec_teacher_id',$teacher_id);
        $this->db->where('ec_date', $date);
        $q = $this->db->get('enroll_counselling');

        return $q->result();

    }

    //get total enrol student
    public function totalEnrolStudent($live_id)
    {
        $this->db->where('el_live_id', $live_id);
        $q = $this->db->get('enroll_live');

        return $q->num_rows();
    }

    // register check

    public function socialCheck($type,$socialId)
    {
        $this->db->where('socialId', $socialId);
        $this->db->where('socialType', $type);
        $q = $this->db->get('users');

        return $q->num_rows();
    }

    // Social Login

    public function socialLogin($condition)
    {

        $this->db->select('*');
        $this->db->from('users');
        $this->db->where($condition);
        $query = $this->db->get()->row('id');

        if(!empty($query)){

            $this->db->where($condition);
            $this->db->set('platform',$this->input->post('platform'));
            $this->db->set('firebase_token',$this->input->post('firebase_token'));
            $this->db->update('users');
            return $query;
        }
    }

    //live class enrolled
    public function liveClassEnrolled($live_id, $user_id)
    {
        $this->db->where('el_live_id',$live_id);
        $this->db->where('el_user_id',$user_id);
        $q =  $this->db->get('enroll_live');

        return $q->row();
    }


    //Send Message
    public function sendMessage($data)
    {
        $this->db->insert('class_chat',$data);

        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }


    }

    //Get Messgage
    public function getMessage($classId)
    {
        $this->db->select('cc.cc_id as id, cc.cc_message as message, u.first_name as name');
        $this->db->from('class_chat as cc');
        $this->db->join('users u','u.id=cc.cc_user_id','inner');
        $this->db->limit(10);
        $this->db->order_by('cc.created_at',"desc");
        $this->db->where('cc.cc_class_id', $classId);
        $q = $this->db->get();

        return $q->result();

    }

    //Add Review
    public function addUpdateReview($course_id, $user_id, $action)
    {
        if($action === "insert")
        {
            $this->db->set('ratable_id',$course_id);
            $this->db->set('user_id',$user_id);
            $this->db->set('rating',$this->input->post('star',true));
            $this->db->set('review',$this->input->post('comment',true));
            $this->db->insert('rating');
        }
        else
        {
            $this->db->where('ratable_id',$course_id);
            $this->db->where('user_id',$user_id);
            $this->db->set('rating',$this->input->post('star',true));
            $this->db->set('review',$this->input->post('comment',true));
            $this->db->update('rating');
        }

        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

     //live class enrolled
     public function checkReviewExist($course_id, $user_id)
     {
         $this->db->where('ratable_id',$course_id);
         $this->db->where('user_id',$user_id);
         $q =  $this->db->get('rating');
 
         return $q->row();
     }

      //live class enrolled
      public function deleteReview($review_id, $user_id)
      {
          $this->db->where('rv_id',$review_id);
          $this->db->where('rv_user_id',$user_id);
          $this->db->delete('reviews');
  
          if($this->db->affected_rows() > 0)
          {
              return true;
          }
          else{
              return false;
          }
      }

      //Add Notification
      public function addNotification($data)
      {
          $this->db->insert('notifications',$data);
          if($this->db->affected_rows() > 0)
          {
            return true;
          }
          else
          {
            return false;
          }
      }

      //Get Notifcation
      public function getNotification($userid)
      {
          $this->db->where('notf_user_id',$userid);
          $this->db->limit(50);
          $this->db->order_by('id','desc');
          return $this->db->get('notifications')->result();
      }


    public function getCurrentLiveClasses($start = false)
    {
        $students = $this->db
            ->select('users.id as user_id, firebase_token, live_class_name, is_instructor, live_date, live_start_time, live_duration')
            ->from('enroll_live')
            ->join('live_class_time_new', 'live_class_time_new.live_id = enroll_live.el_live_id', 'inner')
            ->join('users', 'users.id = enroll_live.el_user_id', 'inner')
            ->where('users.role_id', 2)
            ->where('users.is_instructor', 0)
            ->where('live_class_time_new.live_date', date('Y-m-d'))
            ->get()
            ->result_array();

        $teachers = $this->db
            ->select('users.id as user_id, firebase_token, live_class_name, is_instructor, live_date, live_start_time, live_duration')
            ->from('enroll_live')
            ->join('live_class_time_new', 'live_class_time_new.live_id = enroll_live.el_live_id', 'inner')
            ->join('users', 'users.id = live_class_time_new.instructor_id', 'inner')
            ->where('users.role_id', 2)
            ->where('users.is_instructor', 1)
            ->where('live_class_time_new.live_date', date('Y-m-d'))
            ->get()
            ->result_array();

        $users = array_merge($teachers, $students);

        $finalArr = [];
        foreach ($users as $user) {
            // check if class is about to start or not.
            $currentTime = date( 'Y-m-d H:i');
            $datetime = $user['live_date'] . ' ' . $user['live_start_time'];

            if ($start) {
                if ($currentTime === date('Y-m-d H:i', strtotime($datetime))) {
                    if (!empty($user['firebase_token'])) {
                        $className = ucfirst($user['live_class_name']);
                        $title = 'Live Class';
                        $message = "$className class is now live, Please join.";

                        array_push($finalArr, [
                            'token' => $user['firebase_token'],
                            'title' => $title,
                            'message' => $message
                        ]);
                    }
                }
            } else {
                $minutes_to_minus = 10;

                $time = new DateTime(date( 'Y-m-d H:i:s', strtotime($datetime)));
                $time->sub(new DateInterval('PT' . $minutes_to_minus . 'M'));

                $subtractedTime = $time->format('Y-m-d H:i');

                if ($currentTime === $subtractedTime) {
                    if (!empty($user['firebase_token'])) {
                        $className = $user['live_class_name'];
                        $title = 'Live Class Reminder';
                        $message = "You have an upcoming live class($className) in 10 minutes";

                        array_push($finalArr, [
                            'token' => $user['firebase_token'],
                            'title' => $title,
                            'message' => $message
                        ]);
                    }
                }
            }
        }

        return $finalArr;
    }

    public function getCurrentSessions($start = false)
    {
        $students = $this->db
            ->select('users.id as user_id, firebase_token, is_instructor, ec_date, ec_time, ec_end_time')
            ->from('enroll_counselling')
            ->join('users', 'users.id = enroll_counselling.ec_user_id', 'inner')
            ->where('users.role_id', 2)
            ->where('users.is_instructor', 0)
            ->where('enroll_counselling.ec_date', date('Y-m-d'))
            ->get()
            ->result_array();

        $teachers = $this->db
            ->select('users.id as user_id, firebase_token, is_instructor, ec_date, ec_time, ec_end_time')
            ->from('enroll_counselling')
            ->join('users', 'users.id = enroll_counselling.ec_teacher_id', 'inner')
            ->where('users.role_id', 2)
            ->where('users.is_instructor', 1)
            ->where('enroll_counselling.ec_date', date('Y-m-d'))
            ->get()
            ->result_array();

        $users = array_merge($teachers, $students);

        $finalArr = [];
        foreach ($users as $user) {
            // check if class is about to start or not.
            $firebaseToken = $user['firebase_token'];
            $datetime = $user['ec_date'] . ' ' . $user['ec_time'];
            $currentTime = date( 'Y-m-d H:i');

            if ($start) {
                if ($currentTime === date('Y-m-d H:i', strtotime($datetime))) {
                    if (!empty($firebaseToken)) {
                        $title = 'Counselling Session';
                        $message = "Your counselling session is started, Please join.";

                        array_push($finalArr, [
                            'token' => $firebaseToken,
                            'title' => $title,
                            'message' => $message
                        ]);
                    }
                }
            } else {
                $minutes_to_minus = 10;

                $time = new DateTime(date( 'Y-m-d H:i:s', strtotime($datetime)));
                $time->sub(new DateInterval('PT' . $minutes_to_minus . 'M'));

                $subtractedTime = $time->format('Y-m-d H:i');

                if ($currentTime === $subtractedTime) {
                    if (!empty($firebaseToken)) {
                        $title = 'Counselling Session Reminder';
                        $message = "You have an upcoming counselling session in 10 minutes";

                        array_push($finalArr, [
                            'token' => $firebaseToken,
                            'title' => $title,
                            'message' => $message
                        ]);
                    }
                }
            }
        }

        return $finalArr;
    }

    public function checkUniqueEmail($email, $userId = '')
    {
        if (!empty($userId)) {
            $this->db->where('id !=', $userId);
        }
        $this->db->where('email', $email);
        return $this->db->get('users')->row();
    }

    public function checkUniqueMobile($mobile, $userId = '')
    {
        if (!empty($userId)) {
            $this->db->where('id !=', $userId);
        }
        $this->db->where('phone', $mobile);
        return $this->db->get('users')->row();
    }

    public function updateLiveStudentCount($classId, $count)
    {
        $this->db
            ->set('count', $count)
            ->where('live_id', $classId)
            ->update('live_class_time_new');
    }

    public function getLiveStudentCount($classId)
    {
        return $this->db
            ->where('live_id', $classId)
            ->get('live_class_time_new')->row('count');
    }

    public function getCouponDetails($coupon_id){
        $this->db->where('id', $coupon_id);
        $coupon = $this->db->get('coupon');
        return $coupon->row();
    }

    public function getPaymentOrderDetails($po_id){
        $this->db->where('po_id', $po_id);
        $po = $this->db->get('payments_orders');
        return $po->row();
    }

    public function getPaymentOrderDetails2($po_order_id) {
        $this->db->where('po_order_id', $po_order_id);
        $po = $this->db->get('payments_orders');
        return $po->row();
    }

    public function emptyCart($userid){
        $this->db->where('user_id', $userid);
        $po = $this->db->delete('cart');
        return true;
    }
}
