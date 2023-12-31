<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Educator_model extends CI_Model {

	public function Add_educator($tmp = '', $tmpuser = '') {

		// print_r($tmp);
		// exit;

		$this->db->set('first_name', html_escape($this->input->post('first_name')));
		$this->db->set('last_name', html_escape($this->input->post('last_name')));
		$this->db->set('image', html_escape($tmpuser));
		$this->db->set('email', html_escape($this->input->post('email')));
		$this->db->set('password', sha1(html_escape($this->input->post('password'))));
		$this->db->set('password_without_enc', html_escape($this->input->post('password')));
		$this->db->set('biography', html_escape($this->input->post('biography')));
		$this->db->set('facebook_link', html_escape($this->input->post('facebook_link')));
		$this->db->set('twitter_link', html_escape($this->input->post('twitter_link')));
		$this->db->set('linkedin_link', html_escape($this->input->post('linkedin_link')));
		if (!empty($this->input->post('educator_id'))) {
			$this->db->where('id', $this->input->post('educator_id'));
			$this->db->update('educators');
			$insert_id = $this->input->post('educator_id');
		}else{
			$this->db->insert('educators');
			$insert_id = $this->db->insert_id();
		}

		$this->db->where('educators_id', $insert_id);
		$this->db->delete('educators_qualifications');

		foreach ($this->input->post('edu_qulification') as $key => $value) {
			$this->db->set('educators_id', $insert_id);
			$this->db->set('qualification', html_escape($value));
			$this->db->set('qualification_file', $tmp[$key]);
			$this->db->insert('educators_qualifications');
		}

		return true;
	}


	public function Get_educator() {
		$this->db->where('account_status', '1');
		$this->db->order_by('id DESC');
		$query = $this->db->get('educators');
		$result = $query->result();
		return $result;
	}

	public function Get_educator_by_id($param2) {
		$this->db->where('account_status', '1');
		$this->db->where('id', $param2);
		$query = $this->db->get('educators');
		$result = $query->row();
		return $result;
	}

	public function Get_educator_qualifications($param) {
		$this->db->where('educators_id', $param);
		$query = $this->db->get('educators_qualifications');
		$result = $query->result();
		return $result;
	}

	public function updateQualification($tmpuser) {
		$this->db->set('qualification', html_escape($this->input->post('edu_qulification')));
		$this->db->set('qualification_file', $tmpuser);
		$this->db->where('id', $this->input->post('qulification_id'));
		$this->db->update('educators_qualifications');
		return true;
	}

	public function DeleteQualification($param2) {
		$this->db->where('id', $param2);
		$query = $this->db->get('educators_qualifications');
		$result = $query->row();
		$educators_id = $result->educators_id;

		$this->db->where('id', $param2);
		$this->db->delete('educators_qualifications');

		return $educators_id;
	}

	public function delete_educators($param2) {
		$this->db->set('account_status', '0');
		$this->db->where('id', $param2);
		$this->db->update('educators');

		return true;
	}

	public function Get_instructor() {
		$this->db->where('is_instructor', '1');
		$this->db->order_by('id DESC');
		$query = $this->db->get('users');
		$result = $query->result();
		return $result;
	}

	public function Get_instructor_by_id($param2) {
		$this->db->where('is_instructor', '1');
		$this->db->where('id', $param2);
		$query = $this->db->get('users');
		$result = $query->row();
		return $result;
	}

	public function Check_Instructur_email() {
		$this->db->where('is_instructor', '1');
		$this->db->where('email', $this->input->post('email'));
		$this->db->order_by('id DESC');
		$query = $this->db->get('users');
		$result = $query->row();
		return $result;
	}

	public function Check_Instructur_phone() {
		$this->db->where('is_instructor', '1');
		$this->db->where('phone', $this->input->post('email'));
		$this->db->order_by('id DESC');
		$query = $this->db->get('users');
		$result = $query->row();
		return $result;
	}

	public function sendOtpForChangePassword($userid, $otp) {
		$this->db->set('otp', $otp);
		$this->db->set('otp_last_updated', date('Y-m-d H:i:s'));
		$this->db->where('id', $userid);
		$this->db->update('users');
		
		$this->db->where('id', $userid);
		$query = $this->db->get('users');
		$result = $query->row();
		return $result;
	}

	public function CheckPasswordOtp($userid){
		$this->db->where('id', $userid);
		$this->db->where('otp', $this->input->post('otp'));
		$query = $this->db->get('users');
		if ($query->num_rows() > 0) {
			$diff = strtotime(date('Y-m-d H:i:s')) - strtotime($query->row('otp_last_updated'));
			if ((int)$this->input->post('otp_validate_seconds') >= $diff) {
				return $query->row();
			}else{
				return 'time-exceed';
			}
		}else{
			return false;
		}
	}

	public function ChangePassword($userid) {
		$this->db->set('password', sha1(html_escape($this->input->post('password'))));
		$this->db->where('id', $userid);
		$this->db->update('users');
		return true;
	}

	// public function PasswordCheck($userid) {
	// 	$this->db->where('id', $userid);
	// 	$query = $this->db->update('users');
	// 	$result = $query->row();

	// }


	// Puhupwas Starts
		public function check_id_exist($table, array $condition=[]){
			$this->db->where($condition);
			return $this->db->get($table);
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

		public function insert_table($table, $data){
			$this->db->insert($table,$data);
			if($this->db->affected_rows() === 1){
				return true;
			} else {
				return false;
			}
		}

		//fetch live class list of Educator 
		public function fetchLiveClassList($select2='', array $condition=[])
		{  
		   $this->db->select($select2);
		   $this->db->from('live_class_time_new lctn');
		   $this->db->join('users u','u.id=lctn.instructor_id','inner');
		   // $this->db->where('instructor_id',$this->session->userdata('user_id'));
		   $this->db->where($condition);
		   $this->db->order_by('live_date ASC, live_start_time DESC');
		   return $this->db->get();
		}


		//fetch counselling_session list 
		public function fetchCounsellingSessionList($select2='', array $condition=[])
		{  
		   $this->db->select($select2);
		   $this->db->from('counselling_session cs');
		   $this->db->join('users u','u.id=cs.instructor_id','inner');
		   // $this->db->where('instructor_id',$this->session->userdata('user_id'));
		   $this->db->where($condition);
		   $this->db->order_by('cs_date ASC, cs_start_time DESC');
		   return $this->db->get();
		}


	// Puhupwas Ends

}