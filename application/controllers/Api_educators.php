<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require APPPATH . '/libraries/TokenHandler.php';
//include Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';

class Api_educators extends REST_Controller {

  function __construct(){
       parent:: __construct();
   }

   public function educators_post($param = ''){

    if (empty($param) || $param == '' || $param == 'all') {
        $buku = $this->Educator_model->Get_instructor();
    }else{
        $buku = $this->Educator_model->Get_instructor_by_id($param);
    }

    if (!empty($buku)) {
        $status = true;
        $message = 'Data found';
        $data = $buku;
        $requestType = 'REST_Controller::HTTP_OK';
    }else{
        $status = false;
        $message = 'Data not found';
        $data = null;
        $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
    }

    $this->response([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], $requestType);
   }

   public function educators_login_post(){
    $this->form_validation->set_rules('email','Email','trim|required|valid_email');
    $this->form_validation->set_rules('password','Password','trim|required');

    if($this->form_validation->run() == false)
    {
         $status = false;
         $message = 'Validation errors';
         $data = validation_errors();
         $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
    }
    else
    {
        $emailCheck = $this->Educator_model->Check_Instructur_email();
        if (!empty($emailCheck)) {
            if (sha1(html_escape($this->input->post('password'))) === $emailCheck->password) {
                $status = true;
                $message = 'Login Successfull';
                $data = $emailCheck;
                $requestType = 'REST_Controller::HTTP_OK';
            }else{
                $status = false;
                $message = 'Wrong Password';
                $data = null;
                $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
            }
        }else{
            $status = false;
            $message = 'Email not found';
            $data = null;
            $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
        }

    }

    $this->response([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], $requestType);
   }

   public function forget_password_post(){
    $this->form_validation->set_rules('email','Email or Phone Number','trim|required');

    if($this->form_validation->run() == false)
    {
         $status = false;
         $message = 'Validation errors';
         $data = validation_errors();
         $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
    }
    else
    {
        $emailCheck = $this->Educator_model->Check_Instructur_email();
        if (!empty($emailCheck)) {
            $otp = $this->sendOtpForChangePassword($emailCheck->id);
            $status = true;
            $message = 'Otp sent successfully';
            $data = $otp;
            $requestType = 'REST_Controller::HTTP_OK';
        }else{
            $phoneCheck = $this->Educator_model->Check_Instructur_phone();
            if (!empty($phoneCheck)) {
                $otp = $this->sendOtpForChangePassword($phoneCheck->id);
                $status = true;
                $message = 'Otp sent successfully';
                $data = $otp;
                $requestType = 'REST_Controller::HTTP_OK';
            }else{
                $status = false;
                $message = 'Email or Phone number not found.';
                $data = null;
                $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
            }
        }

    }
    $this->response([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], $requestType);
   }


   public function sendOtpForChangePassword($userid) {
        $string = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string_shuffled = str_shuffle($string);
        $otp = substr($string_shuffled, 1, 6);
        $result = $this->Educator_model->sendOtpForChangePassword($userid, $otp);
        return $result;
   }

   public function CheckPasswordOtp_post($userid){
    $this->form_validation->set_rules('otp','OTP','trim|required|exact_length[6]');
    $this->form_validation->set_rules('otp_validate_seconds','OTP validation seconds','trim|required|numeric');

    if($this->form_validation->run() == false)
    {
         $status = false;
         $message = 'Validation errors';
         $data = validation_errors();
         $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
    }
    else
    {
        $emailCheck = $this->Educator_model->CheckPasswordOtp($userid);
        if (!empty($emailCheck)) {
            if ($emailCheck === 'time-exceed') {
                $status = false;
                $message = 'OTP time exceeded';
                $data = null;
                $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
            }else{
                $status = true;
                $message = 'OTP verified';
                $data = $emailCheck;
                $requestType = 'REST_Controller::HTTP_OK';
            }
        }else{
            $status = false;
            $message = 'Wrong Otp';
            $data = null;
            $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
        }

    }
    $this->response([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], $requestType);
   }


   public function SetNewPassword_post($userid){
    $this->form_validation->set_rules('password','Password','trim|required');
    $this->form_validation->set_rules('confirm_password','Confirm password','trim|required');

    if($this->form_validation->run() == false)
    {
         $status = false;
         $message = 'Validation errors';
         $data = validation_errors();
         $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
    }
    else
    {
        if (html_escape($this->input->post('password')) === html_escape($this->input->post('confirm_password'))) {
            $emailCheck = $this->Educator_model->ChangePassword($userid);
            if (!empty($emailCheck)) {
                $status = true;
                $message = 'Password changed';
                $data = null;
                $requestType = 'REST_Controller::HTTP_OK';
            }else{
                $status = false;
                $message = 'Could\'nt change the password, please try again';
                $data = null;
                $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
            }
        }else{
            $status = false;
            $message = 'password and confirm password doesn\'t match';
            $data = null;
            $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
        }
    }
    $this->response([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], $requestType);
   }


   public function SetNewPasswordFromPanel_post($userid){
    $this->form_validation->set_rules('oldpassword','Old password','trim|required');
    $this->form_validation->set_rules('password','Password','trim|required');
    $this->form_validation->set_rules('confirm_password','Confirm password','trim|required');

    if($this->form_validation->run() == false)
    {
         $status = false;
         $message = 'Validation errors';
         $data = validation_errors();
         $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
    }
    else
    {
        $userCheck = $this->Educator_model->Get_instructor_by_id($userid);
        if (!empty($userCheck)) {
            $passwordOldDB = $userCheck->password;
            if (sha1(html_escape($this->input->post('oldpassword'))) === $passwordOldDB) {
                if ($passwordOldDB === sha1(html_escape($this->input->post('password')))) {
                    $status = false;
                    $message = 'Old password and New password can\'t be same.';
                    $data = null;
                    $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
                }else{
                    if (html_escape($this->input->post('password')) === html_escape($this->input->post('confirm_password'))) {
                        $emailCheck = $this->Educator_model->ChangePassword($userid);
                        if (!empty($emailCheck)) {
                            $status = true;
                            $message = 'Password changed';
                            $data = null;
                            $requestType = 'REST_Controller::HTTP_OK';
                        }else{
                            $status = false;
                            $message = 'Could\'nt change the password, please try again';
                            $data = null;
                            $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
                        }
                    }else{
                        $status = false;
                        $message = 'password and confirm password doesn\'t match';
                        $data = null;
                        $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
                    }
                }
            }else{
                $status = false;
                $message = 'Old password did\'nt match';
                $data = null;
                $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
            }
        }else{
            $status = false;
            $message = 'Wrong params passed';
            $data = null;
            $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
        }
    }
    $this->response([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], $requestType);
   }





   // Puhupwas starts
   public function get_live_class_list_get($tutor_id){
        $tutor = $this->Educator_model->check_id_exist('live_class_time_new',['instructor_id'=>$tutor_id]); 
        if($tutor->num_rows() === 0) {
           $status = false;
           $message = 'The Tutor doesn\'t exist.';
           $data = null;
           $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
        } else {

        $live_class_list = $this->Educator_model->fetchLiveClassList('lctn.*, u.first_name as tutor, u.biography' , ["live_date >="=>date('Y-m-d'),'instructor_id'=>$tutor_id]);

        if ($live_class_list->num_rows() > 0) {
              $status = true;
              $message = 'Available Live Classes';
              $data = ['tutor_live_classes'=>$live_class_list->result()];
              $requestType = 'REST_Controller::HTTP_OK';
        }else{
            $status = false;
            $message = 'No Live Class Available.';
            $data = null;
            $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
        }
    }
    
    $this->response([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], $requestType);
   }


   // Puhupwas starts
   public function get_counselling_session_list_get($tutor_id){



        $tutor = $this->Educator_model->check_id_exist('counselling_session',['instructor_id'=>$tutor_id]); 
        if($tutor->num_rows() === 0) {
           $status = false;
           $message = 'The Tutor doesn\'t exist.';
           $data = null;
           $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
        } else {

        $live_class_list = $this->Educator_model->fetchCounsellingSessionList('cs.*, u.first_name as tutor, u.biography' , ["cs_date >="=>date('Y-m-d'),'instructor_id'=>$tutor_id]);

        if ($live_class_list->num_rows() > 0) {
              $status = true;
              $message = 'Available Counselling Session';
              $data = ['tutor_live_classes'=>$live_class_list->result()];
              $requestType = 'REST_Controller::HTTP_OK';
        }else{
            $status = false;
            $message = 'No Counselling Session Available.';
            $data = null;
            $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
        }
    }
    
    $this->response([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], $requestType);
   }



   









   // Puhupwas Ends






}
