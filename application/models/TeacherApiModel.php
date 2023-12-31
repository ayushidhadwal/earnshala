<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TeacherApiModel extends CI_Model
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
		$query = $this->db->insert($table, $data);
		return $this->db->insert_id();
	}

    //Login
    public function loginCheck($table, $email, $password)
    {
        $array = array('role_id' => 2, 'is_instructor' => 1, 'password' => sha1($password));
        if(is_numeric($email)){
            $where = array_merge($array,array('phone' => $email));
        }else{
            $where = array_merge($array,array('email' => $email));
        }

        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get()->row();

        return $query;
    }

    public function check_id_exist($table, array $condition=[]){
        $this->db->where($condition);
        return $this->db->get($table);
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

    //Get Teacher Schedule
    public function getSchedule($table, $user_id)
    {
        return $this->db->get_where($table, array('teacher_id' => $user_id));
    }

    //check Schedule
    public function checkSchedule($user_id)
    {
        $this->db->where('teacher_id',$user_id);
        return $this->db->get('schedules');
    }

    //Update Teached Schedule
    public function insertUpdateSchedule($type,$user_id, $data)
    {
        if($type == "insert")
        {
            $this->db->set('teacher_id',$user_id);
            $this->db->insert('schedules',$data);

            if($this->db->affected_rows() > 0)
            {
                return true;
            }

            return false;
        }
        else
        {
            $this->db->where('teacher_id',$user_id);
            $this->db->update('schedules',$data);

            if($this->db->affected_rows() > 0)
            {
                return true;
            }

            return false;
        }
    }

    //Upddate Password
    public function update_table($table, $data, $where)
    {
        $this->db->where($where);
        $this->db->update($table, $data);

        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        return false;
    }

    //Get My Counselling Session
    public function myCounsellingSession($where = []) {
        $this->db->order_by('ec_date',"ASC");
        $this->db->order_by('ec_date',"ASC");
        return $this->db->get_where('enroll_counselling', $where);
    }

    //get Student Details
    //get Teacher details
    public function getStudentDetails($table, $where)
    {
        $this->db->select('users.id, users.first_name');
        $this->db->where($where);
        $query = $this->db->get($table);

        return $query->row();

    }

    //Update Profile
    public function updateProfile($userid, $data)
    {
        $this->db->where('id',$userid);
        $this->db->where('is_instructor', 1);
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
        $array = array('role_id' => 2, 'is_instructor' => 1);
        if(is_numeric($email)){
            $where = array_merge($array,array('phone' => $email));
        }else{
            $where = array_merge($array,array('email' => $email));
        }
        $this->db->select('*');

        $this->db->where($where);
        return $this->db->get('users');
    }

    //Reset Password
    public function resetPassword($email, $password)
    {
        $this->db->where('password_reset_status',1);
        $this->db->where('email', $email);
        $this->db->or_where('phone', $email);
        $this->db->where('is_instructor', 1);
        $this->db->update('users',['password' => sha1($password),'password_reset_status' => 0]);

        if($this->db->affected_rows() > 0)
        {
            return true;
        }
    }

    //get single counselling data
    public function teacherCounsellingValidate($condition){

        $this->db->where($condition);
        return $this->db->get('enroll_counselling')->row();
    }

    //get single live class data for teacher
    public function teacherLiveClassValidate($condition){

        $this->db->where($condition);
        return $this->db->get('live_class_time_new')->row();
    }

    //get single live class data for user
    public function userLiveClassValidate($condition){


        $this->db->from('enroll_live');
        $this->db->join('live_class_time_new','live_class_time_new.live_id=enroll_live.el_live_id');
        $this->db->where($condition);
        return $this->db->get()->row();
    }

}
