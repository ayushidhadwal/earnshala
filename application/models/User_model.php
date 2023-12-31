<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function get_admin_details()
    {
        return $this->db->get_where('users', array('role_id' => 1));
    }

    public function get_user($limit = '', $offset = '', $search = '', $user_id = 0, $timestamp_start = "", $timestamp_end = "")
    {
        // $limit = 10;
        // $offset = 0;
        // $course_ids = [];
        // $user_ids = [];
        // $search = 'Dec';
        // if ($search != '') {
        //     $this->db->like('title', $search);
        //     $courses = $this->db->get('course');
        //     if($courses->num_rows() > 0){
        //         foreach($courses->result() as $cc){
        //             $course_ids[] = $cc->id;
        //         }

        //         $this->db->where_in('course_id', $course_ids);
        //         $enroll = $this->db->get('enrol');
        //         if($enroll->num_rows() > 0){
        //             foreach($enroll->result() as $uc){
        //                 $user_ids[] = $uc->user_id;
        //             }
        //         }
        //     }
        // }
        // $new_user_ids = array_unique($user_ids);
        // print_r($new_user_ids);exit;

        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('countries', 'countries.countries_id = users.country', 'left');
        $this->db->join('states', 'states.state_id = users.state', 'left');
        
        if ($user_id > 0) {
            $this->db->where('users.id', $user_id);
        }

        if (!empty($timestamp_start) && !empty($timestamp_end)) {
            $this->db->where('created_at >=', $timestamp_start);
            $this->db->where('created_at <=', $timestamp_end);
        }

        $this->db->order_by("created_at", "desc");
        // $this->db->limit($limit, $offset);

        if ($limit != '' && $offset != '') {
           $this->db->limit($limit, $offset);
        }

        if ($search != '') {
            $this->db->or_like('first_name', $search);
            $this->db->or_like('phone', $search);
            $this->db->or_like('states.state_name', $search);
            $this->db->or_like('email', $search);
            // $this->db->or_where_in('id', $new_user_ids);
        }

        // $this->db->where('users.role_id', 2);
        $this->db->where('users.is_instructor', 0);
        // echo "<pre>";
        // print_r($this->db->get()->result());exit;
        return $this->db->get();
    }

    public function get_user2($limit = '', $offset = '', $search = '', $user_id = 0, $timestamp_start = "", $timestamp_end = "")
    {
        // $limit = 10;
        // $offset = 0;
        // $course_ids = [];
        // $user_ids = [];
        // $search = 'Dec';
        // if ($search != '') {
        //     $this->db->like('title', $search);
        //     $courses = $this->db->get('course');
        //     if($courses->num_rows() > 0){
        //         foreach($courses->result() as $cc){
        //             $course_ids[] = $cc->id;
        //         }

        //         $this->db->where_in('course_id', $course_ids);
        //         $enroll = $this->db->get('enrol');
        //         if($enroll->num_rows() > 0){
        //             foreach($enroll->result() as $uc){
        //                 $user_ids[] = $uc->user_id;
        //             }
        //         }
        //     }
        // }
        // $new_user_ids = array_unique($user_ids);
        // print_r($new_user_ids);exit;

        $this->db->select('users.*,countries.*,states.*');
        $this->db->from('users');
        $this->db->join('countries', 'countries.countries_id = users.country', 'left');
        $this->db->join('states', 'states.state_id = users.state', 'left');
        $this->db->join('enrol', 'enrol.user_id = users.id', 'left');
        $this->db->join('course', 'course.id = enrol.course_id', 'left');
        $this->db->group_by('users.id');
        
        if ($user_id > 0) {
            $this->db->where('users.id', $user_id);
        }

        if (!empty($timestamp_start) && !empty($timestamp_end)) {
            $this->db->where('created_at >=', $timestamp_start);
            $this->db->where('created_at <=', $timestamp_end);
        }

        $this->db->order_by("created_at", "desc");
        // $this->db->limit($limit, $offset);

        if ($limit != '' && $offset != '') {
           $this->db->limit($limit, $offset);
        }

        if ($search != '') {
            $this->db->or_like('first_name', $search);
            $this->db->or_like('phone', $search);
            $this->db->or_like('states.state_name', $search);
            $this->db->or_like('email', $search);
            // $this->db->or_where_in('id', $new_user_ids);
            $this->db->or_like('course.title', $search);
        }

        $this->db->where('users.role_id', 2);
        $this->db->where('users.is_instructor', 0);
        // echo "<pre>";
        // print_r($this->db->get()->result());exit;
        return $this->db->get();
    }

    public function get_all_user($user_id = 0)
    {
        if ($user_id > 0) {
            $this->db->where('id', $user_id);
        }
        return $this->db->get('users');
    }

    public function get_admins($id = 0)
    {
        if ($id > 0) {
            return $this->db->get_where('users', array('id' => $id, 'role_id' => 1));
        } else {
            return $this->db->get_where('users', array('role_id' => 1));
        }
    }

// P Starts
    // academy fun
    public function add_user($is_instructor = false, $is_admin = false)
    {

        $validity = $this->check_duplication('on_create', $this->input->post('email'));
        if ($validity == false) {
            $this->session->set_flashdata('error_message', get_phrase('email_duplication'));
        } else {
            $data['first_name'] = html_escape($this->input->post('first_name'));
            $data['last_name'] = html_escape($this->input->post('last_name'));
            $data['language'] = $this->input->post('language');
            $data['email'] = html_escape($this->input->post('email'));
            $data['password'] = sha1(html_escape($this->input->post('password')));
            $social_link['facebook'] = html_escape($this->input->post('facebook_link'));
            $social_link['twitter'] = html_escape($this->input->post('twitter_link'));
            $social_link['linkedin'] = html_escape($this->input->post('linkedin_link'));
            $data['social_links'] = json_encode($social_link);
            $data['biography'] = $this->input->post('biography');
            $data['half_price'] = $this->input->post('half_price');
            $data['hour_price'] = $this->input->post('hour_price');
            $data['rating'] = $this->input->post('rating');

            if ($is_admin) {
                $data['role_id'] = 1;
                $data['is_instructor'] = 0;
            } else {
                $data['role_id'] = 2;
            }

            $data['date_added'] = strtotime(date("Y-m-d H:i:s"));
            $data['wishlist'] = json_encode(array());
            $data['watch_history'] = json_encode(array());
            $data['status'] = 1;
            $data['image'] = md5(rand(10000, 10000000));

            // Add paypal keys
            $paypal_info = array();
            $paypal['production_client_id'] = html_escape($this->input->post('paypal_client_id'));
            $paypal['production_secret_key'] = html_escape($this->input->post('paypal_secret_key'));
            array_push($paypal_info, $paypal);
            $data['paypal_keys'] = json_encode($paypal_info);

            // Add Stripe keys
            $stripe_info = array();
            $stripe_keys = array(
                'public_live_key' => html_escape($this->input->post('stripe_public_key')),
                'secret_live_key' => html_escape($this->input->post('stripe_secret_key'))
            );
            array_push($stripe_info, $stripe_keys);
            $data['stripe_keys'] = json_encode($stripe_info);

            if ($is_instructor) {
                $data['is_instructor'] = 1;
            }


            $this->db->insert('users', $data);
            $user_id = $this->db->insert_id();

            if ($is_instructor) {
                $tmp = array();

                if (!empty($_FILES['quli_certify']['name'][0])) {

                    if (is_uploaded_file($_FILES['quli_certify']['tmp_name'][0])) {


                        for ($i = 0; $i < count($_FILES['quli_certify']['name']); $i++) {


                            $_FILES['quli_certifyM']['name'] = $_FILES['quli_certify']['name'][$i];
                            $_FILES['quli_certifyM']['type'] = $_FILES['quli_certify']['type'][$i];
                            $_FILES['quli_certifyM']['tmp_name'] = $_FILES['quli_certify']['tmp_name'][$i];
                            $_FILES['quli_certifyM']['error'] = $_FILES['quli_certify']['error'][$i];
                            $_FILES['quli_certifyM']['size'] = $_FILES['quli_certify']['size'][$i];

                            $attachment = 'CC_' . $this->input->post('first_name') . '_' . $this->input->post('last_name') . date('ymdhis') . rand(0, 99);
                            $path = $_FILES['quli_certifyM']['name'];
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $tmp[$i] = base_url() . "uploads/educator_qualifications/" . $attachment . '.' . $ext;

                            $config['upload_path'] = './uploads/educator_qualifications/';
                            $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc';
                            $config['file_name'] = $attachment . '.' . $ext;
                            $config['overwrite'] = 0;
                            $config['max_size'] = 0;
                            $config['max_width'] = 0;
                            $config['max_height'] = 0;
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload('quli_certifyM')) {
                                $this->session->set_flashdata('educators_msg', $this->upload->display_errors());
                                redirect(site_url('admin/educators/add_educators'), 'refresh');
                            }
                        }
                    }

                }
                // else{
                //   $tmp = $this->input->post('quli_certify_old');
                // }

                $this->db->where('educators_id', $user_id);
                $this->db->delete('educators_qualifications');


                if (!empty($this->input->post('edu_qulification')[0])) {
                    foreach ($this->input->post('edu_qulification') as $key => $value) {
                        $this->db->set('educators_id', $user_id);
                        $this->db->set('qualification', html_escape($value));
                        $this->db->set('qualification_file', $tmp[$key]);
                        $this->db->insert('educators_qualifications');
                    }
                }


            }

            // IF THIS IS A USER THEN INSERT BLANK VALUE IN PERMISSION TABLE AS WELL
            if ($is_admin) {
                $permission_data['admin_id'] = $user_id;
                $permission_data['permissions'] = json_encode(array());
                $this->db->insert('permissions', $permission_data);
            }

            $this->upload_user_image($data['image']);
            $this->session->set_flashdata('flash_message', get_phrase('user_added_successfully'));
        }
    }


    // public function add_user($is_instructor = false) {
    //     $validity = $this->check_duplication('on_create', $this->input->post('email'));
    //     if ($validity == false) {
    //         $this->session->set_flashdata('error_message', get_phrase('email_duplication'));
    //     }else {
    //         $data['first_name'] = html_escape($this->input->post('first_name'));
    //         $data['last_name'] = html_escape($this->input->post('last_name'));
    //         $data['email'] = html_escape($this->input->post('email'));
    //         $data['password'] = sha1(html_escape($this->input->post('password')));
    //         $social_link['facebook'] = html_escape($this->input->post('facebook_link'));
    //         $social_link['twitter'] = html_escape($this->input->post('twitter_link'));
    //         $social_link['linkedin'] = html_escape($this->input->post('linkedin_link'));
    //         $data['social_links'] = json_encode($social_link);
    //         $data['biography'] = $this->input->post('biography');
    //         $data['role_id'] = 2;
    //         $data['date_added'] = strtotime(date("Y-m-d H:i:s"));
    //         $data['wishlist'] = json_encode(array());
    //         $data['watch_history'] = json_encode(array());
    //         $data['status'] = 1;
    //         $data['image'] = md5(rand(10000, 10000000));

    //         // Add paypal keys
    //         $paypal_info = array();
    //         $paypal['production_client_id']  = html_escape($this->input->post('paypal_client_id'));
    //         $paypal['production_secret_key'] = html_escape($this->input->post('paypal_secret_key'));
    //         array_push($paypal_info, $paypal);
    //         $data['paypal_keys'] = json_encode($paypal_info);

    //         // Add Stripe keys
    //         $stripe_info = array();
    //         $stripe_keys = array(
    //             'public_live_key' => html_escape($this->input->post('stripe_public_key')),
    //             'secret_live_key' => html_escape($this->input->post('stripe_secret_key'))
    //         );
    //         array_push($stripe_info, $stripe_keys);
    //         $data['stripe_keys'] = json_encode($stripe_info);

    //         if ($is_instructor) {
    //             $data['is_instructor'] = 1;
    //         }

    //         $this->db->insert('users', $data);
    //         $user_id = $this->db->insert_id();
    //         $this->upload_user_image($data['image']);
    //         $this->session->set_flashdata('flash_message', get_phrase('user_added_successfully'));
    //     }
    // }

    // ASSIGN PERMISSION
    public function assign_permission()
    {
        $argument = html_escape($this->input->post('arg'));
        $argument = explode('-', $argument);
        $admin_id = $argument[0];
        $module = $argument[1];

        // CHECK IF IT IS A ROOT ADMIN
        if (is_root_admin($admin_id)) {
            return false;
        }

        $permission_data['admin_id'] = $admin_id;
        $previous_permissions = json_decode($this->get_admins_permission_json($permission_data['admin_id']), TRUE);

        if (in_array($module, $previous_permissions)) {
            $new_permission = array();
            foreach ($previous_permissions as $permission) {
                if ($permission != $module) {
                    array_push($new_permission, $permission);
                }
            }
        } else {
            array_push($previous_permissions, $module);
            $new_permission = $previous_permissions;
        }

        $permission_data['permissions'] = json_encode($new_permission);

        $this->db->where('admin_id', $admin_id);
        $this->db->update('permissions', $permission_data);
        return true;
    }

    // GET ADMIN'S PERMISSION JSON
    public function get_admins_permission_json($admin_id)
    {
        $admins_permissions = $this->db->get_where('permissions', ['admin_id' => $admin_id])->row_array();
        return $admins_permissions['permissions'];
    }

// P Start ends
    public function add_shortcut_user($is_instructor = false)
    {
        $validity = $this->check_duplication('on_create', $this->input->post('email'));
        if ($validity == false) {
            $response['status'] = 0;
            $response['message'] = get_phrase('this_email_already_exits') . '. ' . get_phrase('please_use_another_email');
            return json_encode($response);
        } else {
            $data['first_name'] = html_escape($this->input->post('first_name'));
            $data['last_name'] = html_escape($this->input->post('last_name'));
            $data['email'] = html_escape($this->input->post('email'));
            $data['password'] = sha1(html_escape($this->input->post('password')));
            $social_link['facebook'] = '';
            $social_link['twitter'] = '';
            $social_link['linkedin'] = '';
            $data['social_links'] = json_encode($social_link);
            $data['role_id'] = 2;
            $data['date_added'] = strtotime(date("Y-m-d H:i:s"));
            $data['wishlist'] = json_encode(array());
            $data['watch_history'] = json_encode(array());
            $data['status'] = 1;
            $data['image'] = md5(rand(10000, 10000000));

            // Add paypal keys
            $paypal_info = array();
            $paypal['production_client_id'] = '';
            $paypal['production_secret_key'] = '';
            array_push($paypal_info, $paypal);
            $data['paypal_keys'] = json_encode($paypal_info);

            // Add Stripe keys
            $stripe_info = array();
            $stripe_keys = array(
                'public_live_key' => '',
                'secret_live_key' => ''
            );
            array_push($stripe_info, $stripe_keys);
            $data['stripe_keys'] = json_encode($stripe_info);

            if ($is_instructor) {
                $data['is_instructor'] = 1;
            }
            $this->db->insert('users', $data);

            $this->session->set_flashdata('flash_message', get_phrase('user_added_successfully'));
            $response['status'] = 1;
            return json_encode($response);
        }
    }

    public function check_duplication($action = "", $email = "", $user_id = "")
    {
        $duplicate_email_check = $this->db->get_where('users', array('email' => $email));

        if ($action == 'on_create') {
            if ($duplicate_email_check->num_rows() > 0) {
                if ($duplicate_email_check->row()->status == 1) {
                    return false;
                } else {
                    return 'unverified_user';
                }
            } else {
                return true;
            }
        } elseif ($action == 'on_update') {
            if ($duplicate_email_check->num_rows() > 0) {
                if ($duplicate_email_check->row()->id == $user_id) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }
    }

    public function edit_user($user_id = "")
    { // Admin does this editing
        $validity = $this->check_duplication('on_update', $this->input->post('email'), $user_id);
        if ($validity) {
            $data['first_name'] = html_escape($this->input->post('first_name'));
            $data['last_name'] = html_escape($this->input->post('last_name'));

            if (isset($_POST['email'])) {
                $data['email'] = html_escape($this->input->post('email'));
            }
            $data['biography'] = $this->input->post('biography');
            $data['title'] = html_escape($this->input->post('title'));
            $data['phone'] = html_escape($this->input->post('phone'));
            $data['country'] = html_escape($this->input->post('country'));
            $data['city'] = html_escape($this->input->post('city'));
            $data['last_modified'] = strtotime(date("Y-m-d H:i:s"));
            $data['half_price'] = $this->input->post('half_price');
            $data['hour_price'] = $this->input->post('hour_price');
            $data['language'] = $this->input->post('language');
            $data['rating'] = $this->input->post('rating');

            //skills
            $data['skills'] = html_escape($this->input->post('skills'));
            // $data['instructor_skills'] = implode('-',$this->input->post('subcat'));

            if (isset($_FILES['user_image']) && $_FILES['user_image']['name'] != "") {
                if(file_exists('uploads/user_image/' . $this->db->get_where('users', array('id' => $user_id))->row('image') . '.jpg')){
                    unlink('uploads/user_image/' . $this->db->get_where('users', array('id' => $user_id))->row('image') . '.jpg');
                }
                $data['image'] = md5(rand(10000, 10000000));
            }

            // Update paypal keys
            $paypal_info = array();
            $paypal['production_client_id'] = html_escape($this->input->post('paypal_client_id'));
            $paypal['production_secret_key'] = html_escape($this->input->post('paypal_secret_key'));
            array_push($paypal_info, $paypal);
            $data['paypal_keys'] = json_encode($paypal_info);
            // Update Stripe keys
            $stripe_info = array();
            $stripe_keys = array(
                'public_live_key' => html_escape($this->input->post('stripe_public_key')),
                'secret_live_key' => html_escape($this->input->post('stripe_secret_key'))
            );
            array_push($stripe_info, $stripe_keys);
            $data['stripe_keys'] = json_encode($stripe_info);

            $this->db->where('id', $user_id);
            $this->db->update('users', $data);

            $tmp = array();

            if (!empty($_FILES['quli_certify']['name'][0])) {

                if (is_uploaded_file($_FILES['quli_certify']['tmp_name'][0])) {


                    for ($i = 0; $i < count($_FILES['quli_certify']['name']); $i++) {


                        $_FILES['quli_certifyM']['name'] = $_FILES['quli_certify']['name'][$i];
                        $_FILES['quli_certifyM']['type'] = $_FILES['quli_certify']['type'][$i];
                        $_FILES['quli_certifyM']['tmp_name'] = $_FILES['quli_certify']['tmp_name'][$i];
                        $_FILES['quli_certifyM']['error'] = $_FILES['quli_certify']['error'][$i];
                        $_FILES['quli_certifyM']['size'] = $_FILES['quli_certify']['size'][$i];

                        $attachment = 'CC_' . $this->input->post('first_name') . '_' . $this->input->post('last_name') . date('ymdhis') . rand(0, 99);
                        $path = $_FILES['quli_certifyM']['name'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $tmp[$i] = base_url() . "uploads/educator_qualifications/" . $attachment . '.' . $ext;

                        $config['upload_path'] = './uploads/educator_qualifications/';
                        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc';
                        $config['file_name'] = $attachment . '.' . $ext;
                        $config['overwrite'] = 0;
                        $config['max_size'] = 0;
                        $config['max_width'] = 0;
                        $config['max_height'] = 0;
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('quli_certifyM')) {
                            $this->session->set_flashdata('educators_msg', $this->upload->display_errors());
                            redirect(site_url('admin/educators/add_educators'), 'refresh');
                        }
                    }
                }

            } else {
                $tmp = $this->input->post('quli_certify_old');
            }

            $this->db->where('educators_id', $user_id);
            $this->db->delete('educators_qualifications');

            if (!empty($this->input->post('edu_qulification'[0]))) {
                foreach ($this->input->post('edu_qulification') as $key => $value) {
                    $this->db->set('educators_id', $user_id);
                    $this->db->set('qualification', html_escape($value));
                    $this->db->set('qualification_file', $tmp[$key]);
                    $this->db->insert('educators_qualifications');
                }
            }
            $this->upload_user_image($data['image']);
            $this->session->set_flashdata('flash_message', get_phrase('user_update_successfully'));
        } else {

            $this->session->set_flashdata('error_message', get_phrase('email_duplication'));
        }

    }

    public function delete_user($user_id = "")
    {
        $this->db->where('id', $user_id);
        $this->db->delete('users');
        $this->session->set_flashdata('flash_message', get_phrase('user_deleted_successfully'));
    }

    public function unlock_screen_by_password($password = "")
    {
        $password = sha1($password);
        return $this->db->get_where('users', array('id' => $this->session->userdata('user_id'), 'password' => $password))->num_rows();
    }

    public function register_user($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function register_user_update_code($data)
    {
        $update_code['verification_code'] = $data['verification_code'];
        $update_code['password'] = $data['password'];
        $this->db->where('email', $data['email']);
        $this->db->update('users', $update_code);
    }

    public function my_courses($user_id = "")
    {
        if ($user_id == "") {
            $user_id = $this->session->userdata('user_id');
        }
        return $this->db->get_where('enrol', array('user_id' => $user_id));
    }

    public function upload_user_image($image_code)
    {
        if (isset($_FILES['user_image']) && $_FILES['user_image']['name'] != "") {
            move_uploaded_file($_FILES['user_image']['tmp_name'], 'uploads/user_image/' . $image_code . '.jpg');
            $this->session->set_flashdata('flash_message', get_phrase('user_update_successfully'));
        }
    }

    public function update_account_settings($user_id)
    {
        $validity = $this->check_duplication('on_update', $this->input->post('email'), $user_id);
        if ($validity) {
            if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
                $user_details = $this->get_user($user_id)->row_array();
                $current_password = $this->input->post('current_password');
                $new_password = $this->input->post('new_password');
                $confirm_password = $this->input->post('confirm_password');
                if ($user_details['password'] == sha1($current_password) && $new_password == $confirm_password) {
                    $data['password'] = sha1($new_password);
                } else {
                    $this->session->set_flashdata('error_message', get_phrase('mismatch_password'));
                    return;
                }
            }
            $data['email'] = html_escape($this->input->post('email'));
            $this->db->where('id', $user_id);
            $this->db->update('users', $data);
            $this->session->set_flashdata('flash_message', get_phrase('updated_successfully'));
        } else {
            $this->session->set_flashdata('error_message', get_phrase('email_duplication'));
        }
    }

    public function change_password($user_id)
    {
        $data = array();
        if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
            $user_details = $this->get_all_user($user_id)->row_array();
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');

            if ($user_details['password'] == sha1($current_password) && $new_password == $confirm_password) {
                $data['password'] = sha1($new_password);
            } else {
                $this->session->set_flashdata('error_message', get_phrase('mismatch_password'));
                return;
            }
        }

        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
        $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
    }


    public function get_instructor($id = 0)
    {
        if ($id > 0) {
            return $this->db->get_where('users', array('id' => $id, 'is_instructor' => 1, 'role_id' => 2));
        } else {
            return $this->db->get_where('users', array('is_instructor' => 1, 'role_id' => 2));
        }
    }

    public function get_number_of_active_courses_of_instructor($instructor_id)
    {
        $checker = array(
            'user_id' => $instructor_id,
            'status' => 'active'
        );
        $result = $this->db->get_where('course', $checker)->num_rows();
        return $result;
    }

    public function get_user_image_url($user_id)
    {
        $user_profile_image = $this->db->get_where('users', array('id' => $user_id))->row('image');
        if (file_exists('uploads/user_image/' . $user_profile_image . '.jpg'))
            return base_url() . 'uploads/user_image/' . $user_profile_image . '.jpg';
        else
            return base_url() . 'uploads/user_image/placeholder.png';
    }

    // Puhupwas starts added for API
    public function get_user_image_url_for_api($user_id)
    {
        $user_profile_image = $this->db->get_where('users', array('id' => $user_id))->row('image');
        if (file_exists('uploads/user_image/' . $user_profile_image . '.jpg'))
            return 'uploads/user_image/' . $user_profile_image . '.jpg';
        else
            return 'uploads/user_image/placeholder.png';
    }

    // ends

    public function get_instructor_list()
    {
        $query1 = $this->db->get_where('course', array('status' => 'active'))->result_array();
        $instructor_ids = array();
        $query_result = array();
        foreach ($query1 as $row1) {
            if (!in_array($row1['user_id'], $instructor_ids) && $row1['user_id'] != "") {
                array_push($instructor_ids, $row1['user_id']);
            }
        }
        if (count($instructor_ids) > 0) {
            $this->db->where_in('id', $instructor_ids);
            $query_result = $this->db->get('users');
        } else {
            $query_result = $this->get_admin_details();
        }

        return $query_result;
    }

    public function update_instructor_paypal_settings($user_id = '')
    {
        // Update paypal keys
        $paypal_info = array();
        $paypal['production_client_id'] = html_escape($this->input->post('paypal_client_id'));
        $paypal['production_secret_key'] = html_escape($this->input->post('paypal_secret_key'));
        array_push($paypal_info, $paypal);
        $data['paypal_keys'] = json_encode($paypal_info);
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
    }

    public function update_instructor_stripe_settings($user_id = '')
    {
        // Update Stripe keys
        $stripe_info = array();
        $stripe_keys = array(
            'public_live_key' => html_escape($this->input->post('stripe_public_key')),
            'secret_live_key' => html_escape($this->input->post('stripe_secret_key'))
        );
        array_push($stripe_info, $stripe_keys);
        $data['stripe_keys'] = json_encode($stripe_info);
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
    }

    // POST INSTRUCTOR APPLICATION FORM AND INSERT INTO DATABASE IF EVERYTHING IS OKAY
    public function post_instructor_application()
    {
        // FIRST GET THE USER DETAILS
        $user_details = $this->get_all_user($this->input->post('id'))->row_array();

        // CHECK IF THE PROVIDED ID AND EMAIL ARE COMING FROM VALID USER
        if ($user_details['email'] == $this->input->post('email')) {

            // GET PREVIOUS DATA FROM APPLICATION TABLE
            $previous_data = $this->get_applications($user_details['id'], 'user')->num_rows();
            // CHECK IF THE USER HAS SUBMITTED FORM BEFORE
            if ($previous_data > 0) {
                $this->session->set_flashdata('error_message', get_phrase('already_submitted'));
                redirect(site_url('user/become_an_instructor'), 'refresh');
            }
            $data['user_id'] = $this->input->post('id');
            $data['address'] = $this->input->post('address');
            $data['phone'] = $this->input->post('phone');
            $data['message'] = $this->input->post('message');
            if (isset($_FILES['document']) && $_FILES['document']['name'] != "") {
                if (!file_exists('uploads/document')) {
                    mkdir('uploads/document', 0777, true);
                }
                $accepted_ext = array('doc', 'docs', 'pdf', 'txt', 'png', 'jpg', 'jpeg');
                $path = $_FILES['document']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                if (in_array(strtolower($ext), $accepted_ext)) {
                    $document_custom_name = random(15) . '.' . $ext;
                    $data['document'] = $document_custom_name;
                    move_uploaded_file($_FILES['document']['tmp_name'], 'uploads/document/' . $document_custom_name);
                } else {
                    $this->session->set_flashdata('error_message', get_phrase('invalide_file'));
                    redirect(site_url('user/become_an_instructor'), 'refresh');
                }

            }
            $this->db->insert('applications', $data);
            $this->session->set_flashdata('flash_message', get_phrase('application_submitted_successfully'));
            redirect(site_url('user/become_an_instructor'), 'refresh');
        } else {
            $this->session->set_flashdata('error_message', get_phrase('user_not_found'));
            redirect(site_url('user/become_an_instructor'), 'refresh');
        }
    }


    // GET INSTRUCTOR APPLICATIONS
    public function get_applications($id = "", $type = "")
    {
        if ($id > 0 && !empty($type)) {
            if ($type == 'user') {
                $applications = $this->db->get_where('applications', array('user_id' => $id));
                return $applications;
            } else {
                $applications = $this->db->get_where('applications', array('id' => $id));
                return $applications;
            }
        } else {
            $this->db->order_by("id", "DESC");
            $applications = $this->db->get_where('applications');
            return $applications;
        }
    }

    // GET APPROVED APPLICATIONS
    public function get_approved_applications()
    {
        $applications = $this->db->get_where('applications', array('status' => 1));
        return $applications;
    }

    // GET PENDING APPLICATIONS
    public function get_pending_applications()
    {
        $applications = $this->db->get_where('applications', array('status' => 0));
        return $applications;
    }

    //UPDATE STATUS OF INSTRUCTOR APPLICATION
    public function update_status_of_application($status, $application_id)
    {
        $application_details = $this->get_applications($application_id, 'application');
        if ($application_details->num_rows() > 0) {
            $application_details = $application_details->row_array();
            if ($status == 'approve') {
                $application_data['status'] = 1;
                $this->db->where('id', $application_id);
                $this->db->update('applications', $application_data);

                $instructor_data['is_instructor'] = 1;
                $this->db->where('id', $application_details['user_id']);
                $this->db->update('users', $instructor_data);

                $this->session->set_flashdata('flash_message', get_phrase('application_approved_successfully'));
                redirect(site_url('admin/instructor_application'), 'refresh');
            } else {
                $this->db->where('id', $application_id);
                $this->db->delete('applications');
                $this->session->set_flashdata('flash_message', get_phrase('application_deleted_successfully'));
                redirect(site_url('admin/instructor_application'), 'refresh');
            }
        } else {
            $this->session->set_flashdata('error_message', get_phrase('invalid_application'));
            redirect(site_url('admin/instructor_application'), 'refresh');
        }
    }

    //custom
    public function getUserd($user_id = 0)
    {

        $this->db->select('profile_picture, social_login, image');
        $this->db->where('id', $user_id);
        $this->db->where('role_id', 2);
        return $this->db->get('users')->row();
    }


    // Puhupwas Starts
    public function get_quiz_new()
    {
        $this->db->select('q_id,q_title,q_date_added,q_summary');
        return $this->db->get('quiz');
    }

    public function get_forum()
    {
        $this->db->select('f.*,u.first_name,u.last_name');
        $this->db->from('forum f');
        $this->db->join('users u', 'u.id = f.f_user_id', 'inner');
        return $this->db->get();
    }

    public function get_cart()
    {
        $this->db->select('c.*,u.first_name,u.last_name,u.email,u.phone,cu.title');
        $this->db->from('cart c');
        $this->db->join('users u', 'u.id = c.user_id', 'inner');
        $this->db->join('course cu', 'cu.id = c.course_id', 'inner');
        return $this->db->get();
    }
    public function get_cart_by_date($start, $end)
    {
        $this->db->select('c.*,u.first_name,u.last_name,u.email,u.phone,cu.title');
        $this->db->from('cart c');
        $this->db->where('c.created_at >=', $start);
        $this->db->where('c.created_at <=', $end);
        $this->db->join('users u', 'u.id = c.user_id', 'inner');
        $this->db->join('course cu', 'cu.id = c.course_id', 'inner');
        return $this->db->get();
    }
    public function user_clicks()
    {
        $this->db->select('c.*,u.first_name,u.last_name,u.email,u.phone,cu.title');
        $this->db->from('user_clicks c');
        $this->db->join('users u', 'u.id = c.user_id', 'inner');
        $this->db->join('course cu', 'cu.id = c.course_id', 'inner');
        $this->db->order_by('created_at DESC');
        return $this->db->get();
    }
    public function user_clicks_by_date($start, $end)
    {
        $this->db->select('c.*,u.first_name,u.last_name,u.email,u.phone,cu.title');
        $this->db->from('user_clicks c');
        $this->db->where('c.created_at >=', $start);
        $this->db->where('c.created_at <=', $end);
        $this->db->join('users u', 'u.id = c.user_id', 'inner');
        $this->db->join('course cu', 'cu.id = c.course_id', 'inner');
        $this->db->order_by('created_at DESC');
        return $this->db->get();
    }
    public function get_reviews($course_id)
    {
        $this->db->select('r.*,u.first_name,u.last_name,cu.title');
        $this->db->from('rating r');
        $this->db->join('users u', 'u.id = r.user_id', 'inner');
        $this->db->join('course cu', 'cu.id = r.ratable_id', 'inner');

        $this->db->where('r.ratable_id',$course_id);
        $q =  $this->db->get();
        
        return $q;
    }

    public function delete_reviews($review_id){
        $this->db->where('id',$review_id);
        $this->db->delete('rating');
        return true;
    }

    // public function get_enrolled_courses($start = '', $end = '', $type = ''){
    //     if (empty($start) && empty($end) && empty($type)) {
    //         $this->db->select('r.*,u.first_name,u.last_name,cu.title');
    //         $this->db->from('enrol r');
    //         $this->db->join('users u', 'u.id = r.user_id', 'inner');
    //         $this->db->join('course cu', 'cu.id = r.course_id ', 'inner');
    //         $q =  $this->db->get();
    //     }
    //     return $q;
    // }

    public function get_enrolled_courses($limit = '', $offset = '', $search = '', $timestamp_start = "", $timestamp_end = "", $type = '')
    {
        $this->db->select('r.*,u.first_name,u.last_name,cu.title');
        $this->db->from('enrol r');
        $this->db->join('users u', 'u.id = r.user_id', 'inner');
        $this->db->join('course cu', 'cu.id = r.course_id ', 'inner');

        if ($limit != '' && $offset != '') {
           $this->db->limit($limit, $offset);
        }

        if ($search != '') {
            $this->db->or_like('u.first_name', $search);
            $this->db->or_like('u.last_name', $search);
            $this->db->or_like('cu.title', $search);
        }
        if ($type == 'start') {
            $this->db->where('r.date_added >=', strtotime($timestamp_start));
            $this->db->where('r.date_added <=', strtotime($timestamp_end));
        }elseif ($type == 'end') {
            $this->db->where('r.date_expire >=', strtotime($timestamp_start));
            $this->db->where('r.date_expire <=', strtotime($timestamp_end));
        }
        return $this->db->get();
    }

    public function all_enrolled_courses($user_id)
    {
        $this->db->select('r.*,u.first_name,u.last_name,cu.title,cu.price');
        $this->db->from('enrol r');
        $this->db->join('users u', 'u.id = r.user_id', 'inner');
        $this->db->join('course cu', 'cu.id = r.course_id ', 'inner');
        $this->db->where('r.user_id', $user_id);
        return $this->db->get();
    }

    public function change_enroll_access(){
        $this->db->where('id', $this->input->post('id'));
        $this->db->set('status', $this->input->post('value'));
        $this->db->update('enrol');
        return true;
    }

    public function change_enroll_access_by_user_id(){
        $Today=strtotime(date('y:m:d'));
        $NewDate=strtotime('+1 year', $Today);
        
        $this->db->where('course_id', $this->input->post('id'));
        $this->db->where('user_id', $this->input->post('user_id'));
        $result = $this->db->get('enrol');
        if($result->num_rows() > 0){
            $this->db->where('course_id', $this->input->post('id'));
            $this->db->where('user_id', $this->input->post('user_id'));
            $this->db->set('status', $this->input->post('value'));
            // $this->db->set('date_added', $Today);
            // $this->db->set('date_expire', $NewDate);
            $this->db->update('enrol');
        }else{
            $this->db->set('course_id', $this->input->post('id'));
            $this->db->set('user_id', $this->input->post('user_id'));
            $this->db->set('status', $this->input->post('value'));
            $this->db->set('date_added', $Today);
            $this->db->set('date_expire', $NewDate);
            $this->db->insert('enrol');
        }
        
        return true;
    }

    public function course_details($course_id){
        $this->db->where('id', $course_id);
        $result = $this->db->get('course');
        return $result->row();
    }

    public function course_sections($course_id){
        $this->db->where('course_id', $course_id);
        $result = $this->db->get('section');
        return $result->result();
    }

    public function add_partial_payment(){
        $this->db->where('course_id', $this->input->post('course_id'));
        $check = $this->db->get('partial_payment_courses');
        if ($check->num_rows() > 0) {
            $this->db->where('course_id', $this->input->post('course_id'));
            $this->db->set('no_of_installments', $this->input->post('total_installment'));
            $this->db->set('price_per_installments', $this->input->post('installment_price'));
            $this->db->update('partial_payment_courses');
            $insert_id = $check->row('id');
        }else{
            $this->db->set('course_id', $this->input->post('course_id'));
            $this->db->set('no_of_installments', $this->input->post('total_installment'));
            $this->db->set('price_per_installments', $this->input->post('installment_price'));
            $this->db->insert('partial_payment_courses');
            $insert_id = $this->db->insert_id();
        }

        $this->db->where('partial_payment_id', $insert_id);
        $check2 = $this->db->get('partial_payments_sections');
        if ($check2->num_rows() > 0) {
            $this->db->where('partial_payment_id', $insert_id);
            $this->db->delete('partial_payments_sections');
        }

        foreach ($this->input->post('section_id') as $key => $value) {
            $this->db->set('section_id', $value);
            $this->db->set('access', $this->input->post('section_access')[$key]);
            $this->db->set('course_id', $this->input->post('course_id'));
            $this->db->set('partial_payment_id', $insert_id);
            $this->db->insert('partial_payments_sections');
        }
        return true;

    }

    public function partial_course($course_id){
        $this->db->select('partial_payment_courses.*, partial_payments_sections.id as ps_id,partial_payments_sections.access, partial_payments_sections.section_id as ps_section_id, partial_payments_sections.course_id as ps_course_id, partial_payments_sections.partial_payment_id');
        $this->db->from('partial_payment_courses');
        $this->db->where('partial_payment_courses.course_id', $course_id);
        $this->db->join('partial_payments_sections', 'partial_payments_sections.partial_payment_id = partial_payment_courses.id','inner');
        $check = $this->db->get();
        return $check->result();
    }

    public function getSections($section_id){
        $this->db->where('id', $section_id);
        $sections = $this->db->get('section');
        return $sections->row();
    }

    public function solcial_links_update(){
        $this->db->where('key', 'facebook');
        $fbresult = $this->db->get('settings');
        if ($fbresult->num_rows() > 0) {
            $this->db->set('value', $this->input->post('facebook'));
            $this->db->where('key', 'facebook');
            $this->db->update('settings');
        }else{
            $this->db->set('value', $this->input->post('facebook'));
            $this->db->set('key', 'facebook');
            $this->db->insert('settings');
        }


        $this->db->where('key', 'twitter');
        $twitterresult = $this->db->get('settings');
        if ($twitterresult->num_rows() > 0) {
            $this->db->set('value', $this->input->post('twitter'));
            $this->db->where('key', 'twitter');
            $this->db->update('settings');
        }else{
            $this->db->set('value', $this->input->post('twitter'));
            $this->db->set('key', 'twitter');
            $this->db->insert('settings');
        }

        $this->db->where('key', 'linkdin');
        $linkdinresult = $this->db->get('settings');
        if ($linkdinresult->num_rows() > 0) {
            $this->db->set('value', $this->input->post('linkdin'));
            $this->db->where('key', 'linkdin');
            $this->db->update('settings');
        }else{
            $this->db->set('value', $this->input->post('linkdin'));
            $this->db->set('key', 'linkdin');
            $this->db->insert('settings');
        }


        $this->db->where('key', 'instagram');
        $instagramresult = $this->db->get('settings');
        if ($instagramresult->num_rows() > 0) {
            $this->db->set('value', $this->input->post('instagram'));
            $this->db->where('key', 'instagram');
            $this->db->update('settings');
        }else{
            $this->db->set('value', $this->input->post('instagram'));
            $this->db->set('key', 'instagram');
            $this->db->insert('settings');
        }

        $this->db->where('key', 'whatsapp');
        $whatsappresult = $this->db->get('settings');
        if ($whatsappresult->num_rows() > 0) {
            $this->db->set('value', $this->input->post('whatsapp'));
            $this->db->where('key', 'whatsapp');
            $this->db->update('settings');
        }else{
            $this->db->set('value', $this->input->post('whatsapp'));
            $this->db->set('key', 'whatsapp');
            $this->db->insert('settings');
        }

        $this->db->where('key', 'youtube');
        $youtuberesult = $this->db->get('settings');
        if ($youtuberesult->num_rows() > 0) {
            $this->db->set('value', $this->input->post('youtube'));
            $this->db->where('key', 'youtube');
            $this->db->update('settings');
        }else{
            $this->db->set('value', $this->input->post('youtube'));
            $this->db->set('key', 'youtube');
            $this->db->insert('settings');
        }

        return true;

    }

    public function solcial_links_get(){
        $data = [];
        $this->db->where('key', 'facebook');
        $fbresult = $this->db->get('settings');
        $data['facebook'] = $fbresult->row();

        $this->db->where('key', 'twitter');
        $twitterresult = $this->db->get('settings');
        $data['twitter'] = $twitterresult->row();

        $this->db->where('key', 'linkdin');
        $linkdinresult = $this->db->get('settings');
        $data['linkdin'] = $linkdinresult->row();

        $this->db->where('key', 'instagram');
        $instagramresult = $this->db->get('settings');
        $data['instagram'] = $instagramresult->row();

        $this->db->where('key', 'whatsapp');
        $whatsappresult = $this->db->get('settings');
        $data['whatsapp'] = $whatsappresult->row();

        $this->db->where('key', 'youtube');
        $youtuberesult = $this->db->get('settings');
        $data['youtube'] = $youtuberesult->row();
        return $data;
    }

    public function get_forum_by_id($forum_id = "")
    {
        $this->db->select('f.*,u.first_name,u.last_name');
        $this->db->from('forum f');
        $this->db->join('users u', 'u.id = f.f_user_id', 'inner');
        $this->db->where('f_id', $forum_id);
        return $this->db->get();
    }

    public function saveNotification($userId, $heading, $desc)
    {
        $this->db->set('notf_user_id', $userId);
        $this->db->set('heading', $heading);
        $this->db->set('description', $desc);
        $this->db->insert('notifications');
    }

    public function get_coupons($limit = '', $offset = '', $search = '', $timestamp_start = "", $timestamp_end = "")
    {
        $this->db->select('*');
        $this->db->from('coupon');

        if (!empty($timestamp_start) && !empty($timestamp_end)) {
            $this->db->where('created_at >=', $timestamp_start);
            $this->db->where('created_at <=', $timestamp_end);
        }

        $this->db->order_by("id", "asc");
        // $this->db->limit($limit, $offset);

        if ($limit != '' && $offset != '') {
           $this->db->limit($limit, $offset);
        }

        if ($search != '') {
            $this->db->like('cpn_name', $search);
            $this->db->or_like('cpn_name', $search);
        }
        return $this->db->get();
    }
}
