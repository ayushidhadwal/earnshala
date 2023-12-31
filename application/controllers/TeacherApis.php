<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TeacherApis extends MY_Controller
{

    public function __construct()
    {

        date_default_timezone_set('Asia/Kolkata');

        parent::__construct();
        $this->load->database();
        $this->load->model('TeacherApiModel');
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


    private function request($type, $url = '')
    {
        if ($_SERVER['REQUEST_METHOD'] !== $type) {
            return $this->sendResponse(false, "Cannot " . $_SERVER['REQUEST_METHOD'] . ' ' . $url);
        }
        return true;
    }

    //Login SUbmit
    public function login()
    {
        $this->request('POST', 'teacher/login');

       

        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $message = explode("\n", strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0]);
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $query = $this->TeacherApiModel->loginCheck('users', $email, $password);

            if(!empty($query)){
                $this->db->where('id',$query->id)->update('users',['firebase_token' => $this->input->post('firebase_token',true)]);
                return $this->sendResponse(true, LOGIN_SUCCESS_MSG, [
                    'userId' => $query->id
                ]);
            }else{
                return $this->sendResponse(false, LOGIN_FAILED_MSG);
            }

        }
    }

    //Update Password
    public function updatePassword()
    {
        $this->request('POST', '/teacher/update-password');
        $this->form_validation->set_rules('user_id', 'User ID is required', 'required');
        $this->form_validation->set_rules('old_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

        if ($this->form_validation->run() === false) {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else{

            $user = $this->TeacherApiModel->check_id_exist('users',['id'=>$this->input->post('user_id')]);
            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
            }

            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('new_password');

            $data = [
                'id'   => $this->input->post('user_id'),
                'role_id' => 2,
                'is_instructor' =>1,
                'status' =>1
            ];

            $db_password = $this->TeacherApiModel->get_db_password('users', $data);

            if(sha1($old_password) === $db_password){

                $new_password_updated = $this->TeacherApiModel->update_table('users',['password' => sha1($new_password)], $data);
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
        $this->request('GET', '/teacher/get-profile/'.$user_id);

        $data = [
            'id'   => $user_id,
            'role_id' => 2,
            'is_instructor' =>1,
            'status' =>1
        ];

        $user = $this->TeacherApiModel->check_id_exist('users',$data);
        if($user->num_rows() === 0) {
            return $this->sendResponse(false,  USER_NONEXIST_ERROR );
        }
        else
        {
            $userData = $this->TeacherApiModel->check_id_exist('users',$data)->row();

            return $this->sendResponse(true,"Success",['userData' => $userData]);
        }

    }

    //Get Teacher Schedule
    public function getSchedule($user_id)
    {

        $this->request('GET', '/teacher/get-schedule/'.$user_id);
        $data = [
            'id'   => $user_id,
            'role_id' => 2,
            'is_instructor' =>1,
            'status' =>1
        ];

        $user = $this->TeacherApiModel->check_id_exist('users',$data);
        if($user->num_rows() === 0) {
            return $this->sendResponse(false,  USER_NONEXIST_ERROR );
        }
        else
        {

            $userData = $this->TeacherApiModel->getSchedule('schedules',$user_id)->row();
            return $this->sendResponse(true,"Success",['schedule' => $userData]);
        }
    }

    //Update Teacher Schedule
    public function updateSchedule()
    {
        $this->request('POST',"teacher/update-schedule");
        $this->form_validation->set_rules('user_id', 'User ID is required', 'required');

        if ($this->form_validation->run() === false) {
            $message = explode("\n",strip_tags($this->form_validation->error_string()));
            return $this->sendResponse(false, $message[0],[]);
        }
        else
        {
            $user_id = $this->input->post('user_id');
            $udata = [
                'id'   => $user_id,
                'role_id' => 2,
                'is_instructor' =>1,
                'status' =>1
            ];

            $user = $this->TeacherApiModel->check_id_exist('users',$udata);
            if($user->num_rows() === 0) {
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
            }

            $checkSchedule = $this->TeacherApiModel->checkSchedule($user_id);

            $data['sunday'] = $this->input->post('sunday') ? "1" : '0';
            $data['sunday_start'] = $this->input->post('sunday_start');
            $data['sunday_end'] = $this->input->post('sunday_end');
            $data['sunday_start_two'] = $this->input->post('sunday_start_two');
            $data['sunday_end_two'] = $this->input->post('sunday_end_two');

            $data['monday'] = $this->input->post('monday') ? "1" : '0';
            $data['monday_start'] = $this->input->post('monday_start');
            $data['monday_end'] = $this->input->post('monday_end');
            $data['monday_start_two'] = $this->input->post('monday_start_two');
            $data['monday_end_two'] = $this->input->post('monday_end_two');

            $data['tuesday'] = $this->input->post('tuesday') ? "1" : '0';
            $data['tuesday_start'] = $this->input->post('tuesday_start');
            $data['tuesday_end'] = $this->input->post('tuesday_end');
            $data['tuesday_start_two'] = $this->input->post('tuesday_start_two');
            $data['tuesday_end_two'] = $this->input->post('tuesday_end_two');

            $data['wednesday'] = $this->input->post('wednesday') ? "1" : '0';
            $data['wednesday_start'] = $this->input->post('wednesday_start');
            $data['wednesday_end'] = $this->input->post('wednesday_end');
            $data['wednesday_start_two'] = $this->input->post('wednesday_start_two');
            $data['wednesday_end_two'] = $this->input->post('wednesday_end_two');

            $data['thursday'] = $this->input->post('thursday') ? "1" : '0';
            $data['thursday_start'] = $this->input->post('thursday_start');
            $data['thursday_end'] = $this->input->post('thursday_end');
            $data['thursday_start_two'] = $this->input->post('thursday_start_two');
            $data['thursday_end_two'] = $this->input->post('thursday_end_two');

            $data['friday'] = $this->input->post('friday') ? "1" : '0';
            $data['friday_start'] = $this->input->post('friday_start');
            $data['friday_end'] = $this->input->post('friday_end');
            $data['friday_start_two'] = $this->input->post('friday_start_two');
            $data['friday_end_two'] = $this->input->post('friday_end_two');

            $data['saturday'] = $this->input->post('saturday') ? "1" : '0';
            $data['saturday_start'] = $this->input->post('saturday_start');
            $data['saturday_end'] = $this->input->post('saturday_end');
            $data['saturday_start_two'] = $this->input->post('saturday_start_two');
            $data['saturday_end_two'] = $this->input->post('saturday_end_two');

            if($checkSchedule->num_rows() > 0)
            {
                $update = $this->TeacherApiModel->insertUpdateSchedule('update',$user_id, $data);

                if($update)
                {
                    $this->sendResponse(true,"Updated Successfully");
                }
                else
                {
                    $this->sendResponse(false,"You have not made any changes");
                }
            }
            else
            {
                $insert = $this->TeacherApiModel->insertUpdateSchedule('insert',$user_id,$data);

                if($insert)
                {
                    $this->sendResponse(true,"Added Successfully");
                }
                else
                {
                    $this->sendResponse(false,"Something went wrong, please try again");
                }
            }
        }
    }

    //Get Upcoming Class
    public function getUpcomingClass($user_id)
    {
        $this->request('GET',"teacher/get-upcoming-classes/".$user_id);
        // $this->form_validation->set_rules('user_id', 'Teacher ID', 'trim|required');

        // if ($this->form_validation->run() == false) {
        //     $message = explode("\n", strip_tags($this->form_validation->error_string()));
        //     return $this->sendResponse(false, $message[0]);
        // }

        // $user_id = $this->input->post('user_id');
        $udata = [
            'id'   => $user_id,
            'role_id' => 2,
            'is_instructor' =>1,
            'status' =>1
        ];

        $user = $this->TeacherApiModel->check_id_exist('users',$udata);
        if($user->num_rows() === 0) {
            return $this->sendResponse(false,  USER_NONEXIST_ERROR );
        }

        $limit = 100;
        $date = $this->input->post('date') ? date('Y-m-d',strtotime($this->input->post('date'))) : date('Y-m-d');
        $time = $this->input->post('time') ? $this->input->post('time') :  "00:00";
        $data = $this->NewApiModel->fetchLiveClassList('lctn.* , u.first_name , u.last_name',['live_date >='=> $date, 'live_start_time >' => $time, 'instructor_id' => $user_id],$limit)->result();

        $this->sendResponse(true,"Success",['classes' => $data]);
    }

    //Get Finished Live Class
    public function getFinishedClass($user_id)
    {
        $this->request('GET',"teacher/get-finished-live-class/".$user_id);
        $data = [
            'id'   => $user_id,
            'role_id' => 2,
            'is_instructor' =>1,
            'status' =>1
        ];

        $user = $this->TeacherApiModel->check_id_exist('users',$data);
        if($user->num_rows() === 0) {
            return $this->sendResponse(false,  USER_NONEXIST_ERROR );
        }
        else
        {
            $limit = 100;
            $date = date('Y-m-d');
            $time = $this->input->post('time') ? $this->input->post('time') :  "00:00";
            $data = $this->NewApiModel->fetchLiveClassList('lctn.* , u.first_name , u.last_name',['live_date <'=> $date, 'instructor_id' => $user_id],$limit)->result();

            $this->sendResponse(true,"Success",['classes' => $data]);
        }
    }

    //get Upcoming Counselling Session
    public function getUpcomingCounsellingSession($user_id)
    {
        $this->request("GET","user/get-upcoming-counselling-session/".$user_id);

        $user = $this->Api_user_model->check_id_exist('users',['id' => $user_id, 'role_id' => 2, 'is_instructor' => 1]);
        if($user->num_rows() === 0) {
            return $this->sendResponse(false,  USER_NONEXIST_ERROR );
            exit();
        }

        $date = date('Y-m-d');

        $userData = $user->row();

        $my_courses = $this->TeacherApiModel->myCounsellingSession(['ec_teacher_id' => $user_id,'ec_date >='=> $date])->result();

        $data = [];

        foreach($my_courses as $key => $val)
        {
            $teacher = $this->TeacherApiModel->getStudentDetails('users',['id'=>$val->ec_user_id, 'is_instructor' => 0]);
            $teacher->teacher_id = $user_id;
            $teacher->id = $val->ec_id;

            // $teacher->isWishlist = $this->NewApiModel->isWishlistCounselling($user_id,$val->ec_teacher_id);
            $teacher->classtime = date('d M Y',strtotime($val->ec_date))." ".date('h:i A',strtotime($val->ec_time));
            array_push($data, $teacher);
        }

        $this->sendResponse(true,"Success",['classes' => $data]);
    }

    //get Upcoming Counselling Session
    public function getFinishedCounsellingSession($user_id)
    {
        $this->request("GET","user/get-finished-counselling-session/".$user_id);

        $user = $this->Api_user_model->check_id_exist('users',['id' => $user_id, 'role_id' => 2, 'is_instructor' => 1]);
        if($user->num_rows() === 0) {
            return $this->sendResponse(false,  USER_NONEXIST_ERROR );
            exit();
        }

        $date = date('Y-m-d');

        $userData = $user->row();

        $my_courses = $this->TeacherApiModel->myCounsellingSession(['ec_teacher_id' => $user_id,'ec_date <'=> $date])->result();
        $data = [];

        foreach($my_courses as $key => $val)
        {
            $teacher = $this->TeacherApiModel->getStudentDetails('users',['id'=>$val->ec_user_id, 'is_instructor' => 0]);
            $teacher->teacher_id = $user_id;
            $teacher->id = $val->ec_id;
            // $teacher->isWishlist = $this->NewApiModel->isWishlistCounselling($user_id,$val->ec_teacher_id);
            $teacher->classtime = date('d M Y',strtotime($val->ec_date))." ".date('h:i A',strtotime($val->ec_time));
            array_push($data, $teacher);
        }

        $this->sendResponse(true,"Success",['classes' => $data]);
    }

    //Update Profile
    public function updateProfile()
    {
        $this->request('POST', '/user/update-profile');
        $this->form_validation->set_rules('firstName','Name','trim|required');
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
            $name = $this->input->post('firstName');
            $lastname = $this->input->post('lastName');

            $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 1]);
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
                'last_name' => $lastname,
                'email'   => $email,
                'phone'   => $mobile,
                'state'   => $state,
            ];

            $update = $this->TeacherApiModel->updateProfile($user_id, $data);

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
            $emailExist = $this->TeacherApiModel->checkEmailExist($email, 1);

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
        $this->form_validation->set_rules('email', 'Email or Mobile Number', 'required');
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

    //get Notification
    public function getNotification($user_id)
    {
        $this->request('GET',"user/get-notification/".$user_id);

        $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id, 'role_id' => 2, 'is_instructor' => 1]);
        if($user->num_rows() === 0) {
            return $this->sendResponse(false,  USER_NONEXIST_ERROR );
        }

        $data = $this->NewApiModel->getNotification($user_id);
        $this->sendResponse(true,"Success", $data);
    }


    public function validateCounselling($channelId = "", $userId = "", $type = "")
    {

        if ($type === "user") {
            $condition = array(
                'ec_id' => $channelId,
                'ec_user_id' => $userId
            );
        } else {
            $condition = array(
                'ec_id' => $channelId,
                'ec_teacher_id' => $userId
            );
        }

        $response = $this->TeacherApiModel->teacherCounsellingValidate($condition);
        if (empty($response)) {
            $this->sendResponse(false, 'USER ID NOT MATCHED', []);
        } else {
            $date = $response->ec_date;

            $startDate = strtotime($date . $response->ec_time);
            $endDate = strtotime($date . $response->ec_end_time);
            $currentDate = strtotime(date('Y-m-d H:i:s'));
            $remoteId = $type === "user" ? $response->ec_teacher_id : $response->ec_user_id;

            $expiredTimeRemaining = $endDate-$currentDate;

            if ($currentDate >= $startDate && $currentDate <= $endDate) {
                $this->tokenGenerate($channelId, $userId, $type,$expiredTimeRemaining,$remoteId);
            } elseif ($currentDate < $startDate) {
                $this->sendResponse(true, 'TOO EARLY', [
                    'status' => 'TOO EARLY',
                    'token' => '',
                    'channelName' => '',
                    'remainingTime' => '',
                    'remoteId' => ''
                ]);
            } elseif ($currentDate > $endDate) {
                $this->sendResponse(true, 'EXPIRED', [
                    'status' => 'EXPIRED',
                    'token' => '',
                    'channelName' => '',
                    'remainingTime' => '',
                    'remoteId' => ''
                ]);
            } else {
                $this->sendResponse(true, 'EXPIRED', [
                    'status' => 'EXPIRED',
                    'token' => '',
                    'channelName' => '',
                    'remainingTime' => '',
                    'remoteId' => ''
                ]);
            }
        }
    }

    public function tokenGenerate($channelId, $userId, $type, $time, $remoteId)
    {
        $this->load->library('RtcToken');

        $appID = "0b314b7e46a2424d9f3607557791fd47";
        $appCertificate = "281af61348bc4aa58942da40060403fb";
        $role = $type === "user" ? RtcTokenBuilder::RoleSubscriber : RtcTokenBuilder::RolePublisher;
        $rtmRole = RtmTokenBuilder::RoleRtmUser;
        $expireTimeInSeconds = max($time,0);
        $currentTimestamp = time();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

        $token = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelId, $userId, $role, $privilegeExpiredTs);
        $rtmToken = RtmTokenBuilder::buildToken($appID, $appCertificate, $userId, $rtmRole, $privilegeExpiredTs);

        $this->sendResponse(true, 'JOIN', [
            'status' => 'JOIN',
            'token' => $token,
            'rtmToken' => $rtmToken,
            'channelName' => $channelId,
            'remainingTime' => $privilegeExpiredTs,
            'remoteId' => $remoteId
        ]);
    }

    public function validateLiveClass($channelId = "", $userId = "", $type = "")
    {

        if ($type === "user") {
            $condition = array(
                'el_live_id' => $channelId,
                'el_user_id' => $userId
            );
            $response = $this->TeacherApiModel->userLiveClassValidate($condition);
        } else {
            $condition = array(
                'live_id' => $channelId,
                'instructor_id' => $userId
            );
            $response = $this->TeacherApiModel->teacherLiveClassValidate($condition);
        }

        if (empty($response)) {
            $this->sendResponse(false, 'USER ID NOT MATCHED',[]);
        } else {
            $date = $response->live_date;

            $startDate = strtotime($date . $response->live_start_time);
            $endDate = strtotime($date . date("H:i",strtotime("+ $response->live_duration minutes",strtotime($response->live_start_time))));
            $currentDate = strtotime(date('Y-m-d H:i:s'));

            $expiredTimeRemaining = $endDate-$currentDate;

            if ($currentDate >= $startDate && $currentDate <= $endDate) {
                $this->tokenGenerate($channelId, $userId, $type, $expiredTimeRemaining, $response->instructor_id);
            } elseif ($currentDate < $startDate) {
                $this->sendResponse(true, 'TOO EARLY', [
                    'status' => 'TOO EARLY',
                    'token' => '',
                    'rtmToken' => '',
                    'channelName' => '',
                    'remainingTime' => '',
                    'remoteId' => ''
                ]);
            } elseif ($currentDate > $endDate) {
                $this->sendResponse(true, 'EXPIRED', [
                    'status' => 'EXPIRED',
                    'token' => '',
                    'rtmToken' => '',
                    'channelName' => '',
                    'remainingTime' => '',
                    'remoteId' => ''
                ]);
            } else {
                $this->sendResponse(true, 'EXPIRED', [
                    'status' => 'EXPIRED',
                    'token' => '',
                    'rtmToken' => '',
                    'channelName' => '',
                    'remainingTime' => '',
                    'remoteId' => ''
                ]);
            }
        }

    }
}
