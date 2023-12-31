<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH .'vendor/autoload.php';



class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->database();
        $this->load->library('session');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');


    }

    public function index() {
        if ($this->session->userdata('admin_login')) {
            redirect(site_url('admin'), 'refresh');
        } elseif ($this->session->userdata('user_login')) {
            redirect(site_url('home/profile/user_profile'), 'refresh');
        } else {
            redirect(base_url('login'), 'refresh');
        }
    }

    public function validate_login($from = "") {
        // if($this->crud_model->check_recaptcha() == false && get_frontend_settings('recaptcha_status') == true){
        //     $this->session->set_flashdata('error_message',get_phrase('recaptcha_verification_failed'));
        //     redirect(site_url('home/login'), 'refresh');
        // } 5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8

        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $credential = array('email' => $email, 'password' => sha1($password), 'status' => 1, 'role_id' => 1);
        // if(sha1($password) === 'f2c57870308dc87f432e5912d4de6f8e322721ba'){
        //     echo 'hohioo';
        // }

        // Checking login credential for admin
        $query = $this->db->get_where('users', $credential);

        

        // print_r($query->num_rows());
        // exit();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('user_id', $row->id);
            $this->session->set_userdata('role_id', $row->role_id);
            $this->session->set_userdata('role', get_user_role('user_role', $row->id));
            $this->session->set_userdata('name', $row->first_name.' '.$row->last_name);
            $this->session->set_userdata('is_instructor', $row->is_instructor);
            $this->session->set_flashdata('flash_message', get_phrase('welcome').' '.$row->first_name.' '.$row->last_name);
            if ($row->role_id == 1) {
                $this->session->set_userdata('admin_login', '1');
                redirect(site_url('admin/dashboard'), 'refresh');
            }else if($row->role_id == 2){
                $this->session->set_userdata('user_login', '1');
                redirect(site_url('welcome'), 'refresh');
            }
        }else {
            $this->session->set_flashdata('error_message',get_phrase('invalid_login_credentials'));
            redirect(base_url('login'), 'refresh');
        }
    }

    public function accountVerfiy()
    {

       $this->form_validation->set_rules('first_name',"First Name","trim|required");
       $this->form_validation->set_rules('last_name',"Last Name","trim|required");
       $this->form_validation->set_rules('country',"Country","trim|required");
       $this->form_validation->set_rules('city',"City","trim|required");
       $this->form_validation->set_rules('email',"Email","trim|valid_email|is_unique[users.email]|required");
       $this->form_validation->set_rules('phone',"Mobile Number","trim|numeric|required");
       $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
       $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[8]|matches[password]');

       if($this->form_validation->run() === false){

            $output['status'] = false;
            $output['msg'] = validation_errors();
            $output['data'] = '';

       } else {

        $data['first_name'] = html_escape($this->input->post('first_name'));
        $data['last_name']  = html_escape($this->input->post('last_name'));
        $data['email']  = html_escape($this->input->post('email'));
        $data['password']  = sha1($this->input->post('password'));
        $data['phone'] =  html_escape($this->input->post('phone'));
        $data['country']  = html_escape($this->input->post('country'));
        $data['city']  = html_escape($this->input->post('city'));
        $data['language'] = html_escape($this->input->post('language'));
        $data['is_instructor'] = html_escape($this->input->post('instructor'));
        $data['otp'] =  rand(111111, 999999);

        $this->load->model('Lyvyo_model', 'lyvyo_model');

        $register_id = $this->lyvyo_model->insert_register_user($data);

        $resp = $this->emailVerificationMail($data['email'], $data['otp']);

          if ($resp) {

              $output['status'] = true;
              $output['msg'] = "OTP Sent";
              $output['data'] =  $register_id;

          } else {

              $output['status'] = false;
              $output['msg'] = "Something went wrong";
              $output['data'] =  '';

          }

       }
        echo json_encode($output);
        exit;
    }

    //OTP Verify View
    public function otpVerify($register_id)
    {
        if ($this->session->userdata('admin_login')) {
            redirect(site_url('admin'), 'refresh');
        }elseif ($this->session->userdata('user_login')) {
            redirect(site_url('home/profile/user_profile'), 'refresh');
        }else {
            $this->load->view('home/otpverify',compact('register_id'));
        }

    }

    //otp verification
    public function otp_verify()
    {

        $this->form_validation->set_rules('otp','OTP','trim|required|numeric');

        if($this->form_validation->run() == false)
        {
            $output['status'] = false;
            $output['msg'] = "OTP Field is required";

        }
        else
        {
            $this->load->model('Lyvyo_model','lyvyo_model');
            $reg_data = $this->lyvyo_model->getRegisterData($this->input->post('register_id'));

            if($reg_data->otp == $this->input->post('otp'))
            {

                $data['first_name'] = $reg_data->first_name;
                $data['last_name']  = $reg_data->last_name;
                $data['email']  = $reg_data->email;
                $data['password']  = $reg_data->password;
                $data['phone'] =  $reg_data->phone;
                $data['country']  = $reg_data->country;
                $data['city']  = $reg_data->city;
                $data['language'] = $reg_data->language;
                $data['is_instructor'] = $reg_data->is_instructor;
                $data['status'] = 1;
                $data['wishlist'] = json_encode(array());
                $data['watch_history'] = json_encode(array());
                $data['date_added'] = strtotime(date("Y-m-d H:i:s"));
                $social_links = array(
                    'facebook' => "",
                    'twitter'  => "",
                    'linkedin' => ""
                );
                $data['social_links'] = json_encode($social_links);
                $data['role_id']  = 2;
                $data['is_instructor'] = $this->input->post('instructor');

                // Add paypal keys
                $paypal_info = array();
                $paypal['production_client_id'] = "";
                array_push($paypal_info, $paypal);
                $data['paypal_keys'] = json_encode($paypal_info);
                // Add Stripe keys
                $stripe_info = array();
                $stripe_keys = array(
                    'public_live_key' => "",
                    'secret_live_key' => ""
                );
                array_push($stripe_info, $stripe_keys);
                $data['stripe_keys'] = json_encode($stripe_info);

                $res = $this->user_model->register_user($data);

                if($res)
                {
                    $this->session->set_userdata('user_id', $res);
                    $this->session->set_userdata('role_id', $data['role_id']);
                    $this->session->set_userdata('role', get_user_role('user_role', $res));
                    $this->session->set_userdata('name', $data['first_name'].' '.$data['last_name']);
                    $this->session->set_userdata('is_instructor', $data['is_instructor']);
                    $this->session->set_flashdata('flash_message', get_phrase('welcome').' '.$data['first_name'].' '.$data['is_instructor']);
                     $this->session->set_userdata('user_login', '1');
                    $this->session->set_flashdata('flash_message', get_phrase('your_registration_has_been_successfully_done'));
                    // redirect(base_url('login'), 'refresh');
                    $output['status'] = true;
                    $output['msg'] = "Registered successfully";
                    $output['location'] = base_url('');

                }
                else
                {
                    // $this->session->set_flashdata('error_message', "Error occurred, please try again");
                    // redirect(base_url('login'), 'refresh');
                    $output['status'] = false;
                    $output['msg'] = "Error occurred, please try again";
                }

            }
            else
            {
                $this->session->set_flashdata('error_message',"Incorrect OTP");
                // redirect(base_url('user-otp-verify/').$this->input->post('register_id'), 'refresh');
                    $output['status'] = false;
                    $output['msg'] = "Incorrect OTP";

            }

        }

        echo json_encode($output);
        exit;
    }

    //Resend OTP
    public function resendOtp()
    {

        $this->load->model('Lyvyo_model','lyvyo_model');
         $reg_data = $this->lyvyo_model->getRegisterData($this->input->post('register_id'));

         $otp =  rand(111111, 999999);
         $email = $reg_data->email;

         $resp = $this->emailVerificationMail($email, $otp);

         if($resp)
         {

            $this->lyvyo_model->updateRegisterUserOtp($reg_data->id, $otp);

            $output['status'] = true;
            $output['msg'] = "OTP sent";
         }
         else
         {
            $output['status'] = false;
            $output['msg'] = "Some problem occurred, please try again";
         }

         echo json_encode($output);
         exit;
    }

    public function emailVerificationMail($email, $otp)
    {

             $random = $otp;
             $post = [
                 "htmlContent" => "<!DOCTYPE html> <html> <body> <h1>Verify your account</h1> <p>Dear User,<br/>Thanks for choosing Earnshala.<br/>To confirm your email, please copy the below code and paste the code.</p> <h1>OTP: $random</h1> <p>If the above code doesn't work please try again after a minute or contact us at support@earnshalaadmin.com</p></body></html>",
                 "subject" => "Verify your account.",
                 "sender" => [
                     "name" => "EarnShala",
                     "email" => "support@earnshalaadmin.com"
                 ],
                 'to' => [
                     [
                         "email" => $email
                     ]
                 ],
                 "replyTo" => [
                     "name" => "EarnShala",
                     "email" => "support@earnshalaadmin.com"
                 ]
             ];

             $curl = curl_init();

             curl_setopt_array($curl, [
                 CURLOPT_URL => "https://api.sendinblue.com/v3/smtp/email",
                 CURLOPT_RETURNTRANSFER => true,
                 CURLOPT_ENCODING => "",
                 CURLOPT_MAXREDIRS => 10,
                 CURLOPT_TIMEOUT => 30,
                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                 CURLOPT_CUSTOMREQUEST => "POST",
                 CURLOPT_POSTFIELDS => json_encode($post),
                 CURLOPT_HTTPHEADER => [
                     "Accept: application/json",
                     "Content-Type: application/json",
                     "api-key: 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"
                 ],
             ]);

             $response = curl_exec($curl);
             $err = curl_error($curl);

             curl_close($curl);

             if($curl)
             {
                return true;
             }
             else
             {
                return false;
             }
    }




    public function register() {

       $this->form_validation->set_rules('first_name',"First Name","trim|required");
       $this->form_validation->set_rules('last_name',"Last Name","trim|required");
       $this->form_validation->set_rules('country',"Country","trim|required");
       $this->form_validation->set_rules('state',"State","trim|required");
       $this->form_validation->set_rules('email',"Email","trim|valid_email|is_unique[users.email]|required");
       $this->form_validation->set_rules('phone',"Mobile Number","trim|numeric|required");
       $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
       $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[8]|matches[password]');

       if($this->form_validation->run() === false){


             $path = $this->input->post('path');
             $this->session->set_flashdata('error_message',validation_errors());
             redirect(base_url().$path, 'refresh');

       }
       else
       {

            $data['first_name'] = html_escape($this->input->post('first_name'));
            $data['last_name']  = html_escape($this->input->post('last_name'));
            $data['email']  = html_escape($this->input->post('email'));
            $data['password']  = sha1($this->input->post('password'));
            $data['phone'] =  html_escape($this->input->post('phone'));
            $data['country']  = html_escape($this->input->post('country'));
            $data['state']  = html_escape($this->input->post('state'));
            $data['language'] = html_escape($this->input->post('language'));
            $verification_code =  rand(100000, 200000);
            $data['verification_code'] = $verification_code;

            if (get_settings('student_email_verification') == 'enable') {
                $data['status'] = 0;
            }else {
                $data['status'] = 1;
            }

            $data['wishlist'] = json_encode(array());
            $data['watch_history'] = json_encode(array());
            $data['date_added'] = strtotime(date("Y-m-d H:i:s"));
            $social_links = array(
                'facebook' => "",
                'twitter'  => "",
                'linkedin' => ""
            );
            $data['social_links'] = json_encode($social_links);
            $data['role_id']  = 2;
            $data['is_instructor'] = $this->input->post('instructor');

            // Add paypal keys
            $paypal_info = array();
            $paypal['production_client_id'] = "";
            array_push($paypal_info, $paypal);
            $data['paypal_keys'] = json_encode($paypal_info);
            // Add Stripe keys
            $stripe_info = array();
            $stripe_keys = array(
                'public_live_key' => "",
                'secret_live_key' => ""
            );
            array_push($stripe_info, $stripe_keys);
            $data['stripe_keys'] = json_encode($stripe_info);

            $validity = $this->user_model->check_duplication('on_create', $data['email']);

            if($validity === 'unverified_user' || $validity == true) {
                if($validity === true){
                    $this->user_model->register_user($data);
                }else{
                    $this->user_model->register_user_update_code($data);
                }

                if (get_settings('student_email_verification') == 'enable') {
                    $this->email_model->send_email_verification_mail($data['email'], $verification_code);

                    if($validity === 'unverified_user'){
                        $this->session->set_flashdata('info_message', get_phrase('you_have_already_registered').'. '.get_phrase('please_verify_your_email_address'));
                    }else{
                        $this->session->set_flashdata('flash_message', get_phrase('your_registration_has_been_successfully_done').'. '.get_phrase('please_check_your_mail_inbox_to_verify_your_email_address').'.');
                    }
                    $this->session->set_userdata('register_email', $this->input->post('email'));
                    redirect(site_url('home/verification_code'), 'refresh');
                }else {
                    $this->session->set_flashdata('flash_message', get_phrase('your_registration_has_been_successfully_done'));
                    redirect(site_url('home/login'), 'refresh');
                }

            }else {
                $this->session->set_flashdata('error_message', get_phrase('you_have_already_registered'));
                redirect(site_url('home/login'), 'refresh');
            }
       }




        // if($this->crud_model->check_recaptcha() == false && get_frontend_settings('recaptcha_status') == true){
        //     $this->session->set_flashdata('error_message',get_phrase('recaptcha_verification_failed'));
        //     redirect(site_url('home/login'), 'refresh');
        // }


        // $data['first_name'] = html_escape($this->input->post('first_name'));
        // $data['last_name']  = html_escape($this->input->post('last_name'));
        // $data['email']  = html_escape($this->input->post('email'));
        // $data['password']  = sha1($this->input->post('password'));

        // if(empty($data['first_name']) || empty($data['last_name']) || empty($data['email']) || empty($data['password'])){
        //     $this->session->set_flashdata('error_message',site_phrase('your_sign_up_form_is_empty').'. '.site_phrase('fill_out_the_form with_your_valid_data'));
        //     redirect(site_url('home/sign_up'), 'refresh');
        // }


    }

    public function logout($from = "") {
        //destroy sessions of specific userdata. We've done this for not removing the cart session
        $this->session->sess_destroy();

        redirect(base_url('login'), 'refresh');
    }

    public function session_destroy() {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('is_instructor');
        if ($this->session->userdata('admin_login') == 1) {
            $this->session->unset_userdata('admin_login');
        } else {
            $this->session->unset_userdata('user_login');
        }
    }

    function forgot_password($from = "") {
        if($this->crud_model->check_recaptcha() == false && get_frontend_settings('recaptcha_status') == true){
            $this->session->set_flashdata('error_message',get_phrase('recaptcha_verification_failed'));
            redirect(site_url('home/login'), 'refresh');
        }
        $email = $this->input->post('email');
        //resetting user password here
        $new_password = substr( md5( rand(100000000,20000000000) ) , 0,7);

        // Checking credential for admin
        $query = $this->db->get_where('users' , array('email' => $email));
        if ($query->num_rows() > 0)
        {
            $this->db->where('email' , $email);
            $this->db->update('users' , array('password' => sha1($new_password)));
            // send new password to user email
            $this->email_model->password_reset_email($new_password, $email);
            $this->session->set_flashdata('flash_message', get_phrase('please_check_your_email_for_new_password'));
            if ($from == 'backend') {
                redirect(site_url('login'), 'refresh');
            }else {
                redirect(site_url('home'), 'refresh');
            }
        }else {
            $this->session->set_flashdata('error_message', get_phrase('password_reset_failed'));
            if ($from == 'backend') {
                redirect(site_url('login'), 'refresh');
            }else {
                redirect(site_url('home'), 'refresh');
            }
        }
    }

    public function resend_verification_code(){
        $email = $this->input->post('email');
        $verification_code = $this->db->get_where('users', array('email' => $email))->row('verification_code');
        $this->email_model->send_email_verification_mail($email, $verification_code);

        return true;
    }

    public function verify_email_address() {
        $email = $this->input->post('email');
        $verification_code = $this->input->post('verification_code');
        $user_details = $this->db->get_where('users', array('email' => $email, 'verification_code' => $verification_code));
        if($user_details->num_rows() > 0) {
            $user_details = $user_details->row_array();
            $updater = array(
                'status' => 1
            );
            $this->db->where('id', $user_details['id']);
            $this->db->update('users', $updater);
            $this->session->set_flashdata('flash_message', get_phrase('congratulations').'!'.get_phrase('your_email_address_has_been_successfully_verified').'.');
            $this->session->set_userdata('register_email', null);
            echo true;
        }else{
            $this->session->set_flashdata('error_message', get_phrase('the_verification_code_is_wrong').'.');
            echo false;
        }
    }


    function check_recaptcha_with_ajax(){
        if($this->crud_model->check_recaptcha()){
           echo true;
        }else{
            echo false;
        }
    }

    //google login
    public function googleLogin()
    {

        if(isset($_GET['code'])) {
            try {

                $this->load->config('google');

                $client_id = $this->config->item('CLIENT_ID');
                $client_secret = $this->config->item('CLIENT_SECRET');
                $client_redirect_url = $this->config->item('CLIENT_REDIRECT_URL');
                // Get the access token
                $data = $this->GetAccessToken($client_id, $client_redirect_url, $client_secret, $_GET['code']);

                // Access Token
                $access_token = $data['access_token'];

                // Get user information
                $user_info = $this->GetUserProfileInfo($access_token);

                $this->load->model('Lyvyo_model','lyvyo_model');

                // var_dump($user_info);



                if($this->lyvyo_model->Is_already_register($user_info['id']))
                    {
                     //update data
                     $user_data = array(
                      'login_oauth_uid' => $user_info['id'],
                      'provider' => "google",
                      'first_name'  => $user_info['given_name'],
                      'last_name'   => $user_info['family_name'],
                      'email'  => $user_info['email'],
                      'profile_picture' => $user_info['picture'],
                     );


                     $this->lyvyo_model->Update_user_data($user_data, $user_info['id']);
                     $userd = $this->lyvyo_model->getUserDetailByOauth($user_data['login_oauth_uid']);
                     $this->session->set_userdata('user_id', $userd->id);
                     $this->session->set_userdata('role_id', $userd->role_id);
                     $this->session->set_userdata('role', get_user_role('user_role', $id));
                     $this->session->set_userdata('name', $user_data['first_name'].' '.$user_data['last_name']);
                     $this->session->set_userdata('is_instructor', $user_data['is_instructor']);
                     $this->session->set_userdata('user_login', '1');

                    }
                    else
                    {
                     //insert data
                    $user_data = array(
                      'login_oauth_uid' => $user_info['id'],
                      'provider' => "google",
                      'first_name'  => $user_info['given_name'],
                      'last_name'   => $user_info['family_name'],
                      'email'  => $user_info['email'],
                      'profile_picture' => $user_info['picture'],
                      'social_login' => 1,
                      'role_id'  => 2,
                      'is_instructor' => 0
                     );

                    $paypal_info = array();
                    $paypal['production_client_id'] = "";
                    array_push($paypal_info, $paypal);
                    $user_data['paypal_keys'] = json_encode($paypal_info);
                    // Add Stripe keys
                    $stripe_info = array();
                    $stripe_keys = array(
                        'public_live_key' => "",
                        'secret_live_key' => ""
                    );
                    array_push($stripe_info, $stripe_keys);
                    $user_data['stripe_keys'] = json_encode($stripe_info);
                    $user_data['wishlist'] = json_encode(array());
                    $user_data['watch_history'] = json_encode(array());
                    $user_data['date_added'] = strtotime(date("Y-m-d H:i:s"));
                    $social_links = array(
                        'facebook' => "",
                        'twitter'  => "",
                        'linkedin' => ""
                    );
                    $user_data['social_links'] = json_encode($social_links);

                     $id = $this->lyvyo_model->Insert_user_data($user_data);
                     $this->session->set_userdata('user_id', $id);
                     $this->session->set_userdata('role_id', $user_data['role_id']);
                     $this->session->set_userdata('role', get_user_role('user_role', $id));
                     $this->session->set_userdata('name', $user_data['first_name'].' '.$user_data['last_name']);
                     $this->session->set_userdata('is_instructor', $user_data['is_instructor']);
                     $this->session->set_userdata('user_login', '1');
                    }


                   redirect(base_url(''),'refresh');




                // $this->lyvyo_model->insertUserData($user_data);

            }
            catch(Exception $e) {
                $this->session->set_flashdata('error_message',$e->getMessage());
            redirect(site_url('login'), 'refresh');

            }
        }

    }



    public function GetAccessToken($client_id, $redirect_uri, $client_secret, $code)
    {
        $url = 'https://www.googleapis.com/oauth2/v4/token';

        $curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code='. $code . '&grant_type=authorization_code';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        if($http_code != 200)
            throw new Exception('Error : Failed to receieve access token');

        return $data;
    }

    function GetUserProfileInfo($access_token)
    {
        $url = 'https://www.googleapis.com/oauth2/v2/userinfo?fields=name,email,gender,id,picture,verified_email,given_name,family_name';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token));
        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($http_code != 200)
            throw new Exception('Error : Failed to get user information');

        return $data;
    }

    //facebook login
    public function facebookLogin()
    {

        $userData = array();
        $this->load->library('facebook');
        $this->load->model('Lyvyo_model','lyvyo_model');



                // Authenticate user with facebook
                if($this->facebook->is_authenticated()){
                    // Get user info from facebook
                    $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture');

                    // Preparing data for database insertion
                    $userData['provider'] = 'facebook';
                    $userData['login_oauth_uid']    = !empty($fbUser['id'])?$fbUser['id']:'';;
                    $userData['first_name']    = !empty($fbUser['first_name'])?$fbUser['first_name']:'';
                    $userData['last_name']    = !empty($fbUser['last_name'])?$fbUser['last_name']:'';
                    $userData['email']        = !empty($fbUser['email'])?$fbUser['email']:'';
                    $userData['gender']        = !empty($fbUser['gender'])?$fbUser['gender']:'';
                    $userData['profile_picture']    = !empty($fbUser['picture']['data']['url'])?$fbUser['picture']['data']['url']:'';

                    // $userData['link']        = !empty($fbUser['link'])?$fbUser['link']:'https://www.facebook.com/';

                     if($this->lyvyo_model->Is_already_register($userData['login_oauth_uid']))
                    {
                    //update data
                     $this->lyvyo_model->Update_user_data($userData, $userData['login_oauth_uid']);

                     $userd = $this->lyvyo_model->getUserDetailByOauth($userData['login_oauth_uid']);

                     $this->session->set_userdata('user_id', $userd->id);
                     $this->session->set_userdata('role_id', $userd->role_id);
                     $this->session->set_userdata('role', get_user_role('user_role', $userd->id));
                     $this->session->set_userdata('name', $userData['first_name'].' '.$userData['last_name']);
                     $this->session->set_userdata('is_instructor', $userd->is_instructor);
                     $this->session->set_userdata('user_login', '1');
                    }
                    else
                    {
                     //insert data
                        $userData['wishlist'] = json_encode(array());
                        $userData['watch_history'] = json_encode(array());
                        $userData['date_added'] = strtotime(date("Y-m-d H:i:s"));
                        $social_links = array(
                            'facebook' => "",
                            'twitter'  => "",
                            'linkedin' => ""
                        );
                        $userData['social_links'] = json_encode($social_links);


            // Add paypal keys

                        $userData['social_login'] = 1;
                        $userData['role_id'] = 2;
                        $userData['is_instructor'] = 0;
                        $paypal_info = array();
                        $paypal['production_client_id'] = "";
                        array_push($paypal_info, $paypal);
                        $userData['paypal_keys'] = json_encode($paypal_info);
                        // Add Stripe keys
                        $stripe_info = array();
                        $stripe_keys = array(
                            'public_live_key' => "",
                            'secret_live_key' => ""
                        );
                        array_push($stripe_info, $stripe_keys);
                        $userData['stripe_keys'] = json_encode($stripe_info);

                        $id = $this->lyvyo_model->Insert_user_data($userData);
                        $this->session->set_userdata('user_id', $id);
                        $this->session->set_userdata('role_id', $userData['role_id']);
                        $this->session->set_userdata('role', get_user_role('user_role', $id));
                        $this->session->set_userdata('name', $userData['first_name'].' '.$userData['last_name']);
                        $this->session->set_userdata('is_instructor', $userData['is_instructor']);
                        $this->session->set_userdata('user_login', '1');
                    }


                  redirect(base_url(''),'refresh');


    }
    else
    {
         $this->session->set_flashdata('error_message',get_phrase('invalid_login_credentials'));
            redirect(site_url('login'), 'refresh');
    }


}

}
