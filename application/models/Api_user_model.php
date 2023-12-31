<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (file_exists("application/aws-module/aws-autoloader.php")) {
    include APPPATH.'aws-module/aws-autoloader.php';
}

class Api_user_model extends CI_Model
{

	public function login_check($table,$credential){
		return $this->db->get_where($table, $credential);
	}

	public function register_user($table, $data){
		$query = $this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function get_user_profile($table, $condition){
		$this->db->select('first_name as name,email ,password, state , phone');
		$this->db->from($table);
		$this->db->where($condition);
		return $this->db->get();
	}

	public function update_user_profile($table,array $user_id=[],array $data=[]){
		$this->db->where($user_id);
		$query = $this->db->update($table, $data);
		if($this->db->affected_rows() === 1){
			return true;
		} else {
			return false;
		}
	}

	function check_unique_user_email($id,$column_name, $column) {
	       $this->db->where($column_name, $column);
	       if($id) {
	           $this->db->where_not_in('id', $id);
	       }
	       return $this->db->get('users')->num_rows();
	   }
	
	public function forget_password($table,$data){
		$this->db->where($data);
		return $this->db->get($table);
		
	}

	public function reset_password($table,$data){
		$this->db->where($data);
		$query = $this->db->get($table);
		if($query->num_rows() > 0){
			return true;
		} else {
			return false;
		}
	}
	public function otp_check($table,$data){
		$this->db->where($data);
		$query = $this->db->get($table);
		if($query->num_rows() > 0){
			return true;
		} else {
			return false;
		}
	}

	public function update_table($table, array $column=[],array $condition=[]){
		$this->db->where($condition);
		$query = $this->db->update($table,$column);
		if($this->db->affected_rows() > 0){
			return true;
		} else {
			return false;
		}
	}


	public function get_db_password($table,$data){
			$this->db->where($data);
			$query = $this->db->get($table);
			if($query->num_rows() > 0){
				return $query->row('password');
			} else {
				return false;
			}
	}

	// public function verify_password($table, $db_password, $old_password){
	// 	if (password_verify($old_password, $db_password)) {
	// 					return true;
	// 	           } else {
 // 						return false;
	// 	           }	

	// }


	// COURSES
	public function get_free_and_paid_courses($price_status, array $user_id = []){
		// if(!addon_status('scorm_course')){
		//     $this->db->where('course_type', 'general');
		// }
		if($price_status === 'paid'){
		$this->db->select('c.thumbnail as course_thumbnail,c.title as course_title,c.id as course_id,c.price as course_price');
		} else if($price_status === 'free') {
		$this->db->select('c.thumbnail as course_thumbnail,c.title as course_title,c.id as course_id');	
		}
		$this->db->from('course c');
		$this->db->join('users u','u.id = c.user_id','inner');
		$this->db->where('c.status', 'active');

		if(!empty($user_id)){
			$this->db->where($user_id);
		}
		
		if ($price_status == 'free') {
		    $this->db->where('c.is_free_course', 1);
		} else {
		    $this->db->where_in('c.is_free_course', [null, 0]);
		}

		// if ($instructor_id > 0) {	
		//     $this->db->where('user_id', $instructor_id);
		// }
		return $this->db->get();
	}

	public function get_free_and_paid_course_details($course_id){
		// if(!addon_status('scorm_course')){
		//     $this->db->where('course_type', 'general');
		// }
		$this->db->select('u.id as user_id,c.id as course_id,c.thumbnail,c.title,c.description,c.last_modified,c.language,c.outcomes,c.requirements,c.price,c.section,c.is_free_course');
		$this->db->from('course c');
		$this->db->join('users u','u.id = c.user_id','inner');
		$this->db->where('c.status', 'active');
		$this->db->where('c.id', $course_id);

		// if ($price_status == 'free') {
		//     $this->db->where('c.is_free_course', 1);
		// } else {
		//     $this->db->where('c.is_free_course', null);
		// }

		// if ($instructor_id > 0) {	
		//     $this->db->where('user_id', $instructor_id);
		// }
		return $this->db->get();
	}



	public function get_section($type_by, $id)
	{
	    $this->db->order_by("order", "asc");
	    if ($type_by == 'course') {
	        return $this->db->get_where('section', array('course_id' => $id));
	    } elseif ($type_by == 'section') {
	        return $this->db->get_where('section', array('id' => $id));
	    }
	}

	public function get_course_lesson($section_id,$course_id){
		$this->db->select('l.id as lesson_id, s.title as section_name, l.title as lesson_name, l.video_url, l.attachment,l.duration, l.summary');
		$this->db->from('lesson l');
		$this->db->join('section s','l.section_id = s.id','inner');
		$this->db->where('l.section_id',$section_id);
		$this->db->where('l.course_id',$course_id);
		return $this->db->get();
	}


	// public function get_lessons($type = "", $id = "")
	// {
	//     $this->db->order_by("order", "asc");
	//     if ($type == "course") {
	//         return $this->db->get_where('lesson', array('course_id' => $id));
	//     } elseif ($type == "section") {
	//         return $this->db->get_where('lesson', array('section_id' => $id));
	//     } elseif ($type == "lesson") {
	//         return $this->db->get_where('lesson', array('id' => $id));
	//     } else {
	//         return $this->db->get('lesson');
	//     }
	// }

	public function get_quiz_questions($quiz_id) {
		$this->db->select('id,title as question,options');
		$this->db->from('question');
		$this->db->where('quiz_id',$quiz_id);
		return $this->db->get();
	}

	public function check_correct_anser($table, $quiz_id, $quiz_question, $choosed_answer){
		
		// foreach ($data['quiz_question'] as $key => $ques_id) {
		// 	foreach ($data['choosed_answer'] as $key => $ans) {
		// 	}
		// }

		$res = 0;
		// return json_decode($quiz_question)[1];

		for($i=0; $i<count(json_decode($quiz_question));$i++){
				$this->db->where('quiz_id',$quiz_id);
				$this->db->where('id',json_decode($quiz_question)[$i]);
				// $this->db->where('correct_answers',json_decode($choosed_answer)[$i]);
				$query = $this->db->get('question')->row('correct_answers');

				// return json_decode($query);
				if($query){
						if(json_decode($query)[0] == json_decode($choosed_answer)[$i]){
							$res++;
						}
				}
		}
		return $res;

	}

	public function insertQuizQuestionResult($quiz_id,$user_id,$correct_answers,$total_questions){
		
		$query = $this->db->insert('question_result',['qr_quiz_id'=>$quiz_id,'qr_user_id'=>$user_id,'qr_correct_answer'=>$correct_answers,'qr_attempted_question'=>$total_questions]);
		if($this->db->affected_rows() == 1){
			echo 'hi';
			return $this->db->insert_id();
		} else {
			echo 'ss';
			return false;
		}
	}


	public function get_table($table){
		return $this->db->get($table);
	}


	public function check_id_exist($table, array $condition=[]){
		$this->db->where($condition);
		return $this->db->get($table);
	}

	public function insert_table($table, $data){
		$this->db->insert($table,$data);
		if($this->db->affected_rows() === 1){
			return $this->db->insert_id();
		} else {
			return 0;
		}
	}


	public function get_table_by_id($table,array $condition=[],array $columns=[]){

		$this->db->select($columns);
		$this->db->from($table);
		if($table === 'forum'){
		    $this->db->join('users','users.id = forum.f_user_id','right');
		}
		elseif($table === 'forum_reply') {
		    $this->db->join('users','users.id = forum_reply.fr_user_id','right');
		}
		$this->db->where($condition);
		return $this->db->get();
	}
	
	public function get_forum_by_id($table,array $condition=[]){

		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($condition);
		return $this->db->get();
	}

	

	public function get_replies_on_reply_id($table,array $condition=[]){
	   
		// $this->db->select(['forum_reply.*' , 'users.first_name' , 'users.last_name' , 'users.image']);
		$this->db->select(['forum_reply.fr_id as comment_id','forum_reply.fr_user_id as user_id','forum_reply.fr_reply as comment','forum_reply.fr_created_date as created_date_time' ,'users.first_name as user_name' , 'users.image as user_image']);
		$this->db->from($table);
		 $this->db->join('users','users.id = forum_reply.fr_user_id','right');
		$this->db->where($condition);
		// $this->db->where('fr_id',$forum_reply_id);
		// $this->db->where('fr_forum_reply_id',$forum_reply_id);
		
		return $this->db->get();
	}

	public function delete_table_where($table, array $condition=[])
	{
		$this->db->where($condition);
		$this->db->delete($table);
		if($this->db->affected_rows() === 1){
			return true;	
		} else {
			return false;
		}
		
	}



	public function rate($data)
	{
	    if ($this->db->get_where('rating', array('user_id' => $data['user_id'], 'ratable_id' => $data['ratable_id'], 'ratable_type' => $data['ratable_type']))->num_rows() == 0) {
	        $query = $this->db->insert('rating', $data);
	        if($this->db->affected_rows() > 0){
	        	return 'INSERTED';
	        } else {
	        	return 'INSERTED_FAILED';
	        }
	    } else {
	    	$checker = array('user_id' => $data['user_id'], 'ratable_id' => $data['ratable_id'], 'ratable_type' => $data['ratable_type']);
	        $this->db->where($checker);
	        $query2 = $this->db->update('rating', $data);
	        if($this->db->affected_rows() > 0){
	        	return 'UPDATED';
	        } else {
	        	return 'UPDATED_FAILED';
	        }
	    }
	}

	public function get_rate(array $condition = []){
		return $this->db->select('r.id,u.first_name as user_name,r.rating,r.review,r.date_added')->from('rating r')->join('users u','r.user_id = u.id','inner')->where($condition)->get();
	}

	public function get_course_review(array $condition=[]){

		$this->db->select('r.id,r.rating,r.review,r.date_added,u.first_name as user_name');
		$this->db->from('rating r');
		$this->db->join('users u','u.id = r.user_id','inner');
		$this->db->where($condition);
		return $this->db->get();
	}

	public function get_states(){
		return $this->db->select('state_id,state_name')->get('states')->result();
	}

	public function get_coupons_by_user($user_id){
		$coupon_ids = [];
		$dataArray = [];
		foreach ($this->db->get('coupon')->result() as $key => $value) {
			if ($value->users == 'all') {
				$coupon_ids[] = $value->id;
			}else{
				foreach (json_decode($value->users) as $key2 => $value2) {
					if ($value2 == $user_id ) {
						$coupon_ids[] = $value->id;
					}
				}
			}
		}
		$this->db->where_in('id', $coupon_ids);
		$result = $this->db->get('coupon')->result();
		foreach ($result as $key3 => $value3) {
			$dataArray[$key3]['id'] = $value3->id;
			$dataArray[$key3]['cpn_name'] = $value3->cpn_name;
			$dataArray[$key3]['cpn_percent'] = $value3->cpn_percent;
			$dataArray[$key3]['cpn_max'] = $value3->cpn_max;
			$dataArray[$key3]['cpn_start_date'] = $value3->cpn_start_date;
			$dataArray[$key3]['cpn_end_date'] = $value3->cpn_end_date;
			$dataArray[$key3]['cpn_no_of_times_used'] = $value3->cpn_no_of_times_used;
			$dataArray[$key3]['single_user_limit'] = $value3->single_user_limit;
			if ($value3->users != 'all') {
				$us = [];
				foreach (json_decode($value3->users) as $key => $value) {
					$this->db->where('id', $value);
					$us[] = $this->db->get('users')->row();
				}
			}else{
				$us = 'all';
			}
			$dataArray[$key3]['users'] = $us;
			if ($value3->courses != 'all') {
				$cs = [];
				foreach (json_decode($value3->courses) as $key => $value) {
					$this->db->where('id', $value);
					$cs[] = $this->db->get('course')->row();
				}
			}else{
				$cs = 'all';
			}
			$dataArray[$key3]['courses'] = $cs;
			$dataArray[$key3]['short_description'] = $value3->short_description;
			$dataArray[$key3]['created_at'] = $value3->created_at;
			$dataArray[$key3]['upadted_at'] = $value3->upadted_at;
		}
		return $dataArray;

	}

}

