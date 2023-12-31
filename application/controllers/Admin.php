<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        if (!$this->session->userdata('cart_items')) {
            $this->session->set_userdata('cart_items', array());
        }
    }

    public function index()
    {
        if ($this->session->userdata('admin_login') == true) {
            $this->dashboard();
        } else {
            redirect(base_url('login'), 'refresh');
        }
    }

    public function dashboard()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        $permission_check = get_permission_status('dashboard');
        if ($permission_check) {
            $page_data['page_name'] = 'dashboard';
        } else {
            $page_data['page_name'] = 'dashboard_subadmin';
        }
        $page_data['page_title'] = get_phrase('dashboard');
        $this->load->view('backend/index.php', $page_data);
    }

    public function banner()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        check_permission('banner');

        $page_data['page_name'] = 'banner';
        $page_data['page_title'] = 'Banner';
        $page_data['banners'] = $this->crud_model->getBanners();
        $page_data['courses'] = $this->crud_model->getActiveCourses();
        $this->load->view('backend/index.php', $page_data);
    }

    public function banner_actions($action = 'add', $banner_id = '') {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($action == 'add') {
            $this->crud_model->addBanner();
            $this->session->set_flashdata('flash_message', "Banner added successfully.");
        } elseif ($action == 'delete') {
            $this->crud_model->deleteBanner($banner_id);
            $this->session->set_flashdata('flash_message', "Banner removed successfully.");
        }
        redirect(site_url('admin/banner'));
    }

    public function blank_template()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name'] = 'blank_template';
        $this->load->view('backend/index.php', $page_data);
    }

    public function categories($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        check_permission('category');

        if ($param1 == 'add') {
            $response = $this->crud_model->add_category();
            if ($response) {
                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            } else {
                $this->session->set_flashdata('error_message', get_phrase('category_name_already_exists'));
            }
            redirect(site_url('admin/categories'), 'refresh');
        } elseif ($param1 == "edit") {
            $response = $this->crud_model->edit_category($param2);
            if ($response) {
                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            } else {
                $this->session->set_flashdata('error_message', get_phrase('category_name_already_exists'));
            }
            redirect(site_url('admin/categories'), 'refresh');
        } elseif ($param1 == "delete") {
            $this->crud_model->delete_category($param2);
            $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
            redirect(site_url('admin/categories'), 'refresh');
        }
        $page_data['page_name'] = 'categories';
        $page_data['page_title'] = get_phrase('categories');
        $page_data['categories'] = $this->crud_model->get_categories($param2);
        $this->load->view('backend/index', $page_data);
    }

    public function category_form($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        check_permission('category');

        if ($param1 == "add_category") {
            $page_data['page_name'] = 'category_add';
            $page_data['categories'] = $this->crud_model->get_categories()->result_array();
            $page_data['page_title'] = get_phrase('add_category');
        }
        if ($param1 == "edit_category") {
            $page_data['page_name'] = 'category_edit';
            $page_data['page_title'] = get_phrase('edit_category');
            $page_data['categories'] = $this->crud_model->get_categories()->result_array();
            $page_data['category_id'] = $param2;
        }

        $this->load->view('backend/index', $page_data);
    }

    public function sub_categories_by_category_id($category_id = 0)
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        $category_id = $this->input->post('category_id');
        redirect(site_url("admin/sub_categories/$category_id"), 'refresh');
    }

    public function sub_category_form($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'add_sub_category') {
            $page_data['page_name'] = 'sub_category_add';
            $page_data['page_title'] = get_phrase('add_sub_category');
        } elseif ($param1 == 'edit_sub_category') {
            $page_data['page_name'] = 'sub_category_edit';
            $page_data['page_title'] = get_phrase('edit_sub_category');
            $page_data['sub_category_id'] = $param2;
        }
        $page_data['categories'] = $this->crud_model->get_categories();
        $this->load->view('backend/index', $page_data);
    }

    // P Starts


    // ADMINS SECTION STARTS
    public function admins($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        // CHECK ACCESS PERMISSION
        check_permission('admin');

        if ($param1 == "add") {
            // CHECK ACCESS PERMISSION
            check_permission('admin');
            $this->user_model->add_user(false, true); // PROVIDING TRUE FOR INSTRUCTOR
            redirect(site_url('admin/admins'), 'refresh');
        } elseif ($param1 == "edit") {
            // CHECK ACCESS PERMISSION
            check_permission('admin');
            $this->user_model->edit_user($param2);
            redirect(site_url('admin/admins'), 'refresh');
        } elseif ($param1 == "delete") {
            // CHECK ACCESS PERMISSION
            check_permission('admin');
            $this->user_model->delete_user($param2);
            redirect(site_url('admin/admins'), 'refresh');
        }
        $page_data['page_name'] = 'admins';
        $page_data['page_title'] = get_phrase('admins');
        $page_data['admins'] = $this->user_model->get_admins()->result_array();
        $this->load->view('backend/index', $page_data);
    }

    public function admin_form($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        check_permission('admin');

        if ($param1 == 'add_admin_form') {
            // CHECK ACCESS PERMISSION
            $page_data['page_name'] = 'admin_add';
            $page_data['page_title'] = get_phrase('admin_add');
            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == 'edit_admin_form') {
            // CHECK ACCESS PERMISSION
            $page_data['page_name'] = 'admin_edit';
            $page_data['user_id'] = $param2;
            $page_data['page_title'] = get_phrase('admin_edit');
            $this->load->view('backend/index', $page_data);
        }
    }


    public function permissions()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        // CHECK ACCESS PERMISSION
        check_permission('admin');

        if (!isset($_GET['permission_assing_to']) || empty($_GET['permission_assing_to'])) {
            $this->session->set_flashdata('error_message', get_phrase('you_have_select_an_admin_first'));
            redirect(site_url('admin/admins'), 'refresh');
        }

        $page_data['permission_assing_to'] = $this->input->get('permission_assing_to');
        $user_details = $this->user_model->get_all_user($page_data['permission_assing_to']);
        if ($user_details->num_rows() == 0) {
            $this->session->set_flashdata('error_message', get_phrase('invalid_admin'));
            redirect(site_url('admin/admins'), 'refresh');
        } else {
            $user_details = $user_details->row_array();
            if ($user_details['role_id'] != 1) {
                $this->session->set_flashdata('error_message', get_phrase('invalid_admin'));
                redirect(site_url('admin/admins'), 'refresh');
            }
            if (is_root_admin($user_details['id'])) {
                $this->session->set_flashdata('error_message', get_phrase('you_can_not_set_permission_to_the_root_admin'));
                redirect(site_url('admin/admins'), 'refresh');
            }
        }

        $page_data['permission_assign_to'] = $user_details;
        $page_data['page_name'] = 'admin_permission';
        $page_data['page_title'] = get_phrase('assign_permission');
        $this->load->view('backend/index', $page_data);
    }

    // ASSIGN PERMISSION TO ADMIN
    public function assign_permission()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        // CHECK ACCESS PERMISSION
        check_permission('admin');

        echo $this->user_model->assign_permission();
    }

// P Ends

    public function instructors($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        check_permission('instructor');

        if ($param1 == "add") {
            $this->user_model->add_user(true); // PROVIDING TRUE FOR INSTRUCTOR
            redirect(site_url('admin/instructors'), 'refresh');
        } elseif ($param1 == "edit") {
            $this->user_model->edit_user($param2);
            redirect(site_url('admin/instructors'), 'refresh');
        } elseif ($param1 == "delete") {
            $this->user_model->delete_user($param2);
            redirect(site_url('admin/instructors'), 'refresh');
        }

        $page_data['page_name'] = 'instructors';
        $page_data['page_title'] = get_phrase('instructor');
        $page_data['instructors'] = $this->user_model->get_instructor()->result_array();
        $this->load->view('backend/index', $page_data);
    }

    public function instructor_form($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        if ($param1 == 'add_instructor_form') {
            $page_data['page_name'] = 'instructor_add';
            $page_data['page_title'] = get_phrase('instructor_add');
            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == 'edit_instructor_form') {
            $page_data['page_name'] = 'instructor_edit';
            $page_data['user_id'] = $param2;
            $page_data['educator_qualifications'] = $this->Educator_model->Get_educator_qualifications($param2);
            $page_data['page_title'] = get_phrase('instructor_edit');
            $this->load->view('backend/index', $page_data);
        }
    }

    public function coupons()
    {
        $page_data['page_name'] = 'coupon';
        $page_data['page_title'] = get_phrase('coupon');
        $this->load->view('backend/index', $page_data);
    }

    public function coupon_add()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        $page_data['page_name'] = 'add-coupon';
        $page_data['page_title'] = get_phrase('add_coupon');
        $this->load->view('backend/index', $page_data);
    }

    public function user_all(){
        $search = $this->input->post('q');
        $users = [];
        $us = $this->user_model->get_user('', '', $search, '', '', '')->result_array();
        foreach ($us as $key => $value) {
            $users[$key]['id'] = $value['id'];
            $users[$key]['text'] = $value['first_name'].' '.$value['last_name'].'('.$value['phone'].' / '.$value['email'].')';
        }
        echo json_encode($users);exit;
    }

    public function course_all(){
        $search = $this->input->post('q');
        $users = [];
        $us = $this->crud_model->filter_course_for_backend('all', 'all', 'all', 'all');
        foreach ($us as $key => $value) {
            $users[$key]['id'] = $value['id'];
            $users[$key]['text'] = $value['title'];
        }
        echo json_encode($users);exit;
    }

    public function coupon_submit(){
        $this->form_validation->set_rules('coupon_name', 'Coupon name', 'required|is_unique[coupon.cpn_name]');
        $this->form_validation->set_rules('coupon_discount_percentage', 'Coupon discount percentage', 'required|numeric');
        $this->form_validation->set_rules('coupon_max_discount', 'Coupon maximum discount', 'required|numeric');
        $this->form_validation->set_rules('satrt_date', 'Start date', 'required');
        $this->form_validation->set_rules('end_date', 'End date', 'required');
        $this->form_validation->set_rules('short_description', 'Short description', 'required');
        // $this->form_validation->set_rules('email', 'Email', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $output = array(
                'status' => false,
                'msg' => validation_errors(),
                'data' => null,
            );
        }
        else
        {
                $result = $this->crud_model->insert_coupons();
                if ($result) {
                    $output = array(
                        'status' => true,
                        'msg' => 'Coupon successfully created',
                        'data' => null,
                    );
                }else{
                    $output = array(
                        'status' => false,
                        'msg' => 'An error occured, please try again after some time',
                        'data' => null,
                    );
                }
        }
        echo json_encode($output);
        exit;
    }

    public function coupon_list(){
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        check_permission('coupon');

        if (isset($_GET['search']['value'])) {
            $search = $_GET['search']['value'];
        } else {
            $search = '';
        }
        if (isset($_GET['length'])) {
            $limit = $_GET['length'];
        } else {
            $limit = 10;
        }

        if (isset($_GET['start'])) {
            $ofset = $_GET['start'];
        } else {
            $ofset = 0;
        }

        $users = $this->user_model->get_coupons($limit, $ofset, $search, '', '')->result();
        // print_r($users);exit;

        $total = count($this->user_model->get_coupons('', '', $search, '', '')->result());
        // print_r($total);exit;

        $i = 1 + $ofset;
        $data = [];

        foreach ($users as $key => $user) {

            if ($user->cpn_no_of_times_used == 0){
                $vf = '<small><p>'.get_phrase('limit').': <span
                                class="badge badge-danger-lighten">'.get_phrase('no_limit').'</span>
                    </p></small>';
            }else{
                $vf = $user->cpn_no_of_times_used;
            }
            if ($user->single_user_limit == 0){
                $sf = '<small><p>'.get_phrase('limit').': <span
                                class="badge badge-danger-lighten">'.get_phrase('no_limit').'</span>
                    </p></small>';
            }else{
                $sf = $user->single_user_limit;
            }
            if ($user->courses != 'all') {
                $ecourse = '<ul>';
                    foreach (json_decode($user->courses) as $enrolled_course) {
                        $course_details = $this->crud_model->get_course_by_id($enrolled_course)->row_array();
                        $ecourse .= '<li>'.$course_details['title'].'</li>';
                    }
                $ecourse .= '</ul>';
            }else{
                $ecourse = 'All courses';
            }
            if ($user->users != 'all') {
                $userssss = '<ul>';
                    foreach (json_decode($user->users) as $uu) {
                        $user_details = $this->crud_model->get_user_by_id($uu)->row_array();
                        if (!empty($user_details)) {
                            $userssss .= '<li>'.$user_details['first_name'].'</li>';
                        } else {
                            $userssss .= '<li>---</li>';
                        }
                    }
                $userssss .= '</ul>';
            }else{
                $userssss = 'All users';
            }

            $data[] = array(
                $key + 1,
                $user->cpn_name,
                $user->cpn_percent,
                $user->cpn_max,
                date('d-m-Y', strtotime($user->cpn_start_date)),
                date('d-m-Y', strtotime($user->cpn_end_date)),
                $vf,
                $sf,
                $ecourse,
                $userssss,
                $user->short_description,
                date('d-m-Y', strtotime($user->created_at)),
                '<div class="dropright dropright">
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary btn-rounded btn-icon"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item delete-coupon" data-id="'.$user->id.'" href="javascript:void(0)">'.get_phrase("delete").'</a>
                                            </li>
                                        </ul>
                                    </div>',
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function delete_coupons($cpn_id){
        $result = $this->crud_model->delete_coupons($cpn_id);
        if ($result) {
            $output = array(
                'status' => true,
                'msg' => 'Coupon successfully deleted',
                'data' => null,
            );
            $this->session->set_flashdata('flash_message', get_phrase('coupon_successfully_deleted'));
            redirect(base_url().'admin/coupons', 'refresh');
        }else{
            $output = array(
                'status' => false,
                'msg' => 'An error occured, please try again after some time',
                'data' => null,
            );
        }
        echo json_encode($output);
        exit;
    }

    public function users($param1 = "", $param2 = "")
    {
        if (isset($_GET['date_range'])) {
            $date_range = $this->input->get('date_range');
            $date_range = explode(" - ", $date_range);

            $page_data['filter_date_start'] = date('Y-m-d H:i:s', strtotime($date_range[0] . ' 00:00:00'));
            $page_data['filter_date_end'] = date('Y-m-d H:i:s', strtotime($date_range[1] . ' 23:59:59'));

            $page_data['timestamp_start'] = strtotime($date_range[0] . ' 00:00:00');
            $page_data['timestamp_end'] = strtotime($date_range[1] . ' 23:59:59');
        } else {
            $page_data['timestamp_start'] = strtotime(date("m/01/Y 00:00:00"));
            $page_data['timestamp_end'] = strtotime(date("m/t/Y 23:59:59"));

            $page_data['filter_date_start'] = '';
            $page_data['filter_date_end'] = '';
        }

        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        check_permission('student');

        if ($param1 == "courses") {
            $page_data['page_name'] = 'selectcourses';
            $page_data['page_title'] = 'Courses List';
            $page_data['courses'] = $this->crud_model->fetch_courses();
            $this->load->view('backend/index', $page_data);
        }

        if ($param1 == "add") {
            $this->user_model->add_user();
            redirect(site_url('admin/users'), 'refresh');
        } elseif ($param1 == "edit") {
            $this->user_model->edit_user($param2);
            redirect(site_url('admin/users'), 'refresh');
        } elseif ($param1 == "delete") {
            $this->user_model->delete_user($param2);
            redirect(site_url('admin/users'), 'refresh');
        }

        $page_data['page_name'] = 'users';
        $page_data['page_title'] = get_phrase('student');
        $page_data['users'] = $this->user_model->get_user($param2, $page_data['filter_date_start'], $page_data['filter_date_end']);
        $this->load->view('backend/index', $page_data);
    }

    public function users_list($dateRange1 = '', $dateRange2 = ''){

        // echo json_encode($dateRange1.'-'.$dateRange2);exit;
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        check_permission('student');

        if (isset($_GET['search']['value'])) {
            $search = $_GET['search']['value'];
        } else {
            $search = '';
        }
        if (isset($_GET['length'])) {
            $limit = $_GET['length'];
        } else {
            $limit = 10;
        }

        if (isset($_GET['start'])) {
            $ofset = $_GET['start'];
        } else {
            $ofset = 0;
        }

        if (!empty($dateRange1)) {
            $sday = date('Y-m-d H:i:s', strtotime($dateRange1. ' 00:00:00'));
        }else{
            $sday = '';
        }

        if (!empty($dateRange2)) {
            $eday = date('Y-m-d H:i:s', strtotime($dateRange2 . ' 23:59:59'));
        }else{
            $eday = '';
        }

        $users = $this->user_model->get_user2($limit, $ofset, $search, '', $sday, $eday)->result();

        $total = count($this->user_model->get_user2('', '', $search, '', $sday, $eday)->result());
        // print_r($total);
        // echo json_encode($users);exit;

        $i = 1 + $ofset;
        $data = [];

        foreach ($users as $key => $user) {
            if ($user->status != 1){
                $vf = '<small><p>'.get_phrase('status').': <span
                                class="badge badge-danger-lighten">'.get_phrase('unverified').'</span>
                    </p></small>';
            }else{
                $vf = '';
            }

            $enrolled_courses = $this->crud_model->enrol_history_by_user_id($user->id);
            // print_r($enrolled_courses);exit;
            $ecourse = '<ul>';
                foreach ($enrolled_courses->result_array() as $enrolled_course) {
                    $course_details = $this->crud_model->get_course_by_id($enrolled_course['course_id'])->row_array();
                    $ecourse .= '<li>'.$course_details['title'].'</li>';
                }
            $ecourse .= '</ul>';

            $liveClass = $this->crud_model->enroll_live_classes_by_user_id($user->id);
            $lclass = '<ul>';
                foreach ($liveClass->result_array() as $getLiveClass){
                    $live_details = $this->crud_model->get_live_class_by_id($getLiveClass['el_live_id'])->row_array();
                    $lclass .= '<li>'.$live_details['live_class_name'].'</li>';
                }
            $lclass .= '</ul>';
            $data[] = array(
                $key + 1,
                $user->first_name.' '.$user->last_name.$vf,
                $user->email.$dateRange1.'-'.$dateRange2,
                $user->phone,
                $user->state_name,
                date('d-m-Y H:i A', strtotime($user->created_at)),
                $ecourse,
                $lclass,
                '<a href="'.base_url("admin/userSelectCourses/".$user->id).'" class="btn btn-success">
                                        Select Courses
                                    </a>',
                '<div class="dropright dropright">
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary btn-rounded btn-icon"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                   onclick=confirm_modal("'.site_url("admin/users/delete/" . $user->id).'")>'.get_phrase("delete").'</a>
                                            </li>
                                            <li><a class="dropdown-item" href="'.site_url("admin/student_enrolled_courses/" . $user->id).'">'.get_phrase("all_enrolled_courses").'</a>
                                            </li>
                                            <li><a class="dropdown-item" href="'.site_url("admin/allow_free_course/" . $user->id).'">Allow free course access</a>
                                            </li>
                                        </ul>
                                    </div>',
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function allow_free_course($userId){
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        // $page_data['forum'] = $this->user_model->get_cart()->result();
        $page_data['all_course'] =$this->crud_model->all_courses()->result();
        // echo "<pre>";
        // print_r($page_data['all_course']);exit;
        $page_data['page_name'] = 'allow_free_courses_access';
        $page_data['page_title'] = 'Allow free course access';
        $page_data['user_id'] = $userId;
        $this->load->view('backend/index', $page_data);
    }

    public function student_enrolled_courses($userId){
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        // $page_data['forum'] = $this->user_model->get_cart()->result();
        $page_data['enrolled_course'] =$this->user_model->all_enrolled_courses($userId)->result();
        // print_r($page_data['enrolled_course']);exit;
        $page_data['page_name'] = 'all_enrolled_courses';
        $page_data['page_title'] = get_phrase('all_enrolled_courses');
        $page_data['user_id'] = $userId;
        $this->load->view('backend/index', $page_data);
    }

    public function change_enroll_access(){
        // echo json_encode($_POST);exit;
        $settings = $this->user_model->change_enroll_access();
        if ($settings) {
            $array = array(
                'status' => true,
                'msg' => 'Access changed'
            );
        }else{
            $array = array(
                'status' => false,
                'msg' => 'Some error occured, please try again later'
            );
        }
        echo json_encode($array);exit;
    }

    public function change_enroll_access_by_user(){
        // echo json_encode($_POST);exit;
        $settings = $this->user_model->change_enroll_access_by_user_id();
        if ($settings) {
            $array = array(
                'status' => true,
                'msg' => 'Access changed'
            );
        }else{
            $array = array(
                'status' => false,
                'msg' => 'Some error occured, please try again later'
            );
        }
        echo json_encode($array);exit;
    }


    public function add_shortcut_student()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $is_instructor = 0;
        echo $this->user_model->add_shortcut_user($is_instructor);
    }

    public function user_form($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'add_user_form') {
            $page_data['page_name'] = 'user_add';
            $page_data['page_title'] = get_phrase('student_add');
            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == 'edit_user_form') {
            $page_data['page_name'] = 'user_edit';
            $page_data['user_id'] = $param2;
            $page_data['page_title'] = get_phrase('student_edit');
            $this->load->view('backend/index', $page_data);
        }
    }

    public function enrol_history($param1 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 != "") {
            $date_range = $this->input->get('date_range');
            $date_range = explode(" - ", $date_range);
            $page_data['timestamp_start'] = strtotime($date_range[0]);
            $page_data['timestamp_end'] = strtotime($date_range[1]);
        } else {
            $first_day_of_month = "1 " . date("M") . " " . date("Y") . ' 00:00:00';
            $last_day_of_month = date("t") . " " . date("M") . " " . date("Y") . ' 23:59:59';
            $page_data['timestamp_start'] = strtotime($first_day_of_month);
            $page_data['timestamp_end'] = strtotime($last_day_of_month);
        }
        $page_data['page_name'] = 'enrol_history';
        $page_data['enrol_history'] = $this->crud_model->enrol_history_by_date_range($page_data['timestamp_start'], $page_data['timestamp_end']);
        $page_data['page_title'] = get_phrase('enrol_history');
        $this->load->view('backend/index', $page_data);
    }

    public function enrol_student($param1 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        if ($param1 == 'enrol') {
            $this->crud_model->enrol_a_student_manually();
            redirect(site_url('admin/enrol_history'), 'refresh');
        }
        $page_data['page_name'] = 'enrol_student';
        $page_data['page_title'] = get_phrase('enrol_a_student');
        $this->load->view('backend/index', $page_data);
    }

    public function shortcut_enrol_student()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        echo $this->crud_model->shortcut_enrol_a_student_manually();
    }

    public function admin_revenue($param1 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        check_permission('revenue');

        if ($param1 != "") {
            $date_range = $this->input->get('date_range');
            $date_range = explode(" - ", $date_range);
            $page_data['timestamp_start'] = strtotime($date_range[0] . ' 00:00:00');
            $page_data['timestamp_end'] = strtotime($date_range[1] . ' 23:59:59');

        } else {
            $page_data['timestamp_start'] = strtotime(date("m/01/Y 00:00:00"));
            $page_data['timestamp_end'] = strtotime(date("m/t/Y 23:59:59"));
        }

        $page_data['page_name'] = 'admin_revenue';
        $page_data['payment_history'] = $this->crud_model->get_revenue_by_user_type($page_data['timestamp_start'], $page_data['timestamp_end'], 'admin_revenue');
        // print_r($page_data['payment_history']);exit;
        $page_data['page_title'] = get_phrase('admin_revenue');

        $this->load->view('backend/index', $page_data);
    }

    public function admin_revenue_partial_course($param1 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        check_permission('revenue');

        if ($param1 != "") {
            $date_range = $this->input->get('date_range');
            $date_range = explode(" - ", $date_range);
            $page_data['timestamp_start'] = strtotime($date_range[0] . ' 00:00:00');
            $page_data['timestamp_end'] = strtotime($date_range[1] . ' 23:59:59');

        } else {
            $page_data['timestamp_start'] = strtotime(date("m/01/Y 00:00:00"));
            $page_data['timestamp_end'] = strtotime(date("m/t/Y 23:59:59"));
        }

        $page_data['page_name'] = 'admin_revenue_partial_course';
        $page_data['payment_history'] = $this->crud_model->get_revenue_by_user_type_partitial($page_data['timestamp_start'], $page_data['timestamp_end'], 'admin_revenue');
        // print_r($page_data['payment_history']);exit;
        $page_data['page_title'] = get_phrase('admin_revenue_partial_course');

        $this->load->view('backend/index', $page_data);
    }

    public function instructor_revenue($param1 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        check_permission('revenue');

        $page_data['page_name'] = 'instructor_revenue';
        $page_data['payment_history'] = $this->crud_model->get_revenue_by_user_type("", "", 'instructor_revenue');
        $page_data['page_title'] = get_phrase('instructor_revenue');


        $this->load->view('backend/index', $page_data);
    }

    function invoice($payout_id = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name'] = 'invoice';
        $page_data['payout_id'] = $payout_id;
        $page_data['page_title'] = get_phrase('invoice');
        $this->load->view('backend/index', $page_data);
    }

    public function payment_history_delete($param1 = "", $redirect_to = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $this->crud_model->delete_payment_history($param1);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted_successfully'));
        redirect(site_url('admin/' . $redirect_to), 'refresh');
    }

    public function enrol_history_delete($param1 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $this->crud_model->delete_enrol_history($param1);
        $this->session->set_flashdata('flash_message', get_phrase('data_deleted_successfully'));
        redirect(site_url('admin/enrol_history'), 'refresh');
    }

    public function purchase_history()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name'] = 'purchase_history';
        $page_data['purchase_history'] = $this->crud_model->purchase_history();
        $page_data['page_title'] = get_phrase('purchase_history');
        $this->load->view('backend/index', $page_data);
    }

    public function system_settings($param1 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'system_update') {
            $this->crud_model->update_system_settings();
            $this->session->set_flashdata('flash_message', get_phrase('system_settings_updated'));
            redirect(site_url('admin/system_settings'), 'refresh');
        }

        if ($param1 == 'logo_upload') {
            move_uploaded_file($_FILES['logo']['tmp_name'], 'assets/backend/logo.png');
            $this->session->set_flashdata('flash_message', get_phrase('backend_logo_updated'));
            redirect(site_url('admin/system_settings'), 'refresh');
        }

        if ($param1 == 'favicon_upload') {
            move_uploaded_file($_FILES['favicon']['tmp_name'], 'assets/favicon.png');
            $this->session->set_flashdata('flash_message', get_phrase('favicon_updated'));
            redirect(site_url('admin/system_settings'), 'refresh');
        }

        $page_data['languages'] = $this->crud_model->get_all_languages();
        $page_data['page_name'] = 'system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $this->load->view('backend/index', $page_data);
    }

    public function frontend_settings($param1 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'frontend_update') {
            $this->crud_model->update_frontend_settings();
            $this->session->set_flashdata('flash_message', get_phrase('frontend_settings_updated'));
            redirect(site_url('admin/frontend_settings'), 'refresh');
        }

        if ($param1 == 'recaptcha_update') {
            $this->crud_model->update_recaptcha_settings();
            $this->session->set_flashdata('flash_message', get_phrase('recaptcha_settings_updated'));
            redirect(site_url('admin/frontend_settings'), 'refresh');
        }

        if ($param1 == 'banner_image_update') {
            $this->crud_model->update_frontend_banner();
            $this->session->set_flashdata('flash_message', get_phrase('banner_image_update'));
            redirect(site_url('admin/frontend_settings'), 'refresh');
        }
        if ($param1 == 'light_logo') {
            $this->crud_model->update_light_logo();
            $this->session->set_flashdata('flash_message', get_phrase('logo_updated'));
            redirect(site_url('admin/frontend_settings'), 'refresh');
        }
        if ($param1 == 'dark_logo') {
            $this->crud_model->update_dark_logo();
            $this->session->set_flashdata('flash_message', get_phrase('logo_updated'));
            redirect(site_url('admin/frontend_settings'), 'refresh');
        }
        if ($param1 == 'small_logo') {
            $this->crud_model->update_small_logo();
            $this->session->set_flashdata('flash_message', get_phrase('logo_updated'));
            redirect(site_url('admin/frontend_settings'), 'refresh');
        }
        if ($param1 == 'favicon') {
            $this->crud_model->update_favicon();
            $this->session->set_flashdata('flash_message', get_phrase('favicon_updated'));
            redirect(site_url('admin/frontend_settings'), 'refresh');
        }

        $page_data['page_name'] = 'frontend_settings';
        $page_data['page_title'] = get_phrase('frontend_settings');
        $this->load->view('backend/index', $page_data);
    }

    public function payment_settings($param1 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'system_currency') {
            $this->crud_model->update_system_currency();
            redirect(site_url('admin/payment_settings'), 'refresh');
        }
        if ($param1 == 'paypal_settings') {
            $this->crud_model->update_paypal_settings();
            redirect(site_url('admin/payment_settings'), 'refresh');
        }
        if ($param1 == 'stripe_settings') {
            $this->crud_model->update_stripe_settings();
            redirect(site_url('admin/payment_settings'), 'refresh');
        }

        $page_data['page_name'] = 'payment_settings';
        $page_data['page_title'] = get_phrase('payment_settings');
        $this->load->view('backend/index', $page_data);
    }

    public function smtp_settings($param1 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'update') {
            $this->crud_model->update_smtp_settings();
            $this->session->set_flashdata('flash_message', get_phrase('smtp_settings_updated_successfully'));
            redirect(site_url('admin/smtp_settings'), 'refresh');
        }

        $page_data['page_name'] = 'smtp_settings';
        $page_data['page_title'] = get_phrase('smtp_settings');
        $this->load->view('backend/index', $page_data);
    }

    public function instructor_settings($param1 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        check_permission('instructor');
        if ($param1 == 'update') {
            $this->crud_model->update_instructor_settings();
            $this->session->set_flashdata('flash_message', get_phrase('instructor_settings_updated'));
            redirect(site_url('admin/instructor_settings'), 'refresh');
        }

        $page_data['page_name'] = 'instructor_settings';
        $page_data['page_title'] = get_phrase('instructor_settings');
        $this->load->view('backend/index', $page_data);
    }

    public function theme_settings($action = '')
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name'] = 'theme_settings';
        $page_data['page_title'] = get_phrase('theme_settings');
        $this->load->view('backend/index', $page_data);
    }

    public function theme_actions($action = "", $theme = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($action == 'activate') {
            $theme_to_active = $this->input->post('theme');
            $installed_themes = $this->crud_model->get_installed_themes();
            if (in_array($theme_to_active, $installed_themes)) {
                $this->crud_model->activate_theme($theme_to_active);
                echo true;
            } else {
                echo false;
            }
        } elseif ($action == 'remove') {
            if ($theme == get_frontend_settings('theme')) {
                $this->session->set_flashdata('error_message', get_phrase('activate_a_theme_first'));
            } else {
                $this->crud_model->remove_files_and_folders(APPPATH . '/views/frontend/' . $theme);
                $this->crud_model->remove_files_and_folders(FCPATH . '/assets/frontend/' . $theme);
                $this->session->set_flashdata('flash_message', $theme . ' ' . get_phrase('theme_removed_successfully'));
            }
            redirect(site_url('admin/theme_settings'), 'refresh');
        }

    }

    public function courses()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        // CHECK ACCESS PERMISSION
        check_permission('course');

//        echo $this->user_model->assign_permission();

        $page_data['selected_category_id'] = isset($_GET['category_id']) ? $_GET['category_id'] : "all";
        $page_data['selected_instructor_id'] = isset($_GET['instructor_id']) ? $_GET['instructor_id'] : "all";
        $page_data['selected_price'] = isset($_GET['price']) ? $_GET['price'] : "all";
        $page_data['selected_status'] = isset($_GET['status']) ? $_GET['status'] : "all";

        // Courses query is used for deciding if there is any course or not. Check the view you will get it
        $page_data['courses'] = $this->crud_model->filter_course_for_backend($page_data['selected_category_id'], $page_data['selected_instructor_id'], $page_data['selected_price'], $page_data['selected_status']);
        $page_data['status_wise_courses'] = $this->crud_model->get_status_wise_courses();
        $page_data['instructors'] = $this->user_model->get_instructor()->result_array();
        $page_data['page_name'] = 'courses';
        $page_data['categories'] = $this->crud_model->get_categories();
        $page_data['page_title'] = get_phrase('active_courses');
        $this->load->view('backend/index', $page_data);
    }

    public function ajax_partial_payment($course_id, $no_of_installments){
        $ps = $this->user_model->partial_course($course_id);
        $html = '';
        foreach ($ps as $key => $value) {
            $sections = $this->user_model->getSections($value->ps_section_id);
            if ($value->access  == 1) {
                $one =  "selected";
            }else{
                $one = '';
            }
            if ($value->access  == 2) {
                $two =  "selected";
            }else{
                $two = '';
            }
            if ($value->access  == 3) {
                $three =  "selected";
            }else{
                $three = '';
            }
            if ($value->access  == 4) {
                $four =  "selected";
            }else{
                $four = '';
            }
            if ($no_of_installments == 2) {
                $html2 = '<option value="1" '.$one.'>After first installment</option>
                                    <option value="2" '.$two.'>After second installment</option>';
            }elseif ($no_of_installments == 3) {
                $html2 = '<option value="1" '.$one.'>After first installment</option>
                                    <option value="2" '.$two.'>After second installment</option>
                                    <option value="3" '.$three.'>After third installment</option>';
            }elseif ($no_of_installments == 4) {
                $html2 = '<option value="1" '.$one.'>After first installment</option>
                                    <option value="2" '.$two.'>After second installment</option>
                                    <option value="3" '.$three.'>After third installment</option>
                                    <option value="4" '.$four.'>After fourth installment</option>';
            }
            $html .= '<div class="col-md-6 s-d">
                                        <div class="form-group">
                                            <label for=""> Sections </label>
                                            <input type="text" class="form-control" name="section_tilte[]" readonly value="'.$sections->title.'">
                                            <input type="hidden" class="form-control" name="section_id[]" readonly value="'.$value->ps_section_id.'">
                                        </div>
                                    </div>
                                    <div class="col-md-6 s-d">
                                        <div class="form-group">
                                            <label for="">Access in installmets </label>
                                            <select name="section_access[]" class="form-control section_access" required>
                                                <option value="" selected style="display:none">Select access</option>
                                                '.$html2.'
                                            </select>
                                        </div>
                                    </div>';
        }
        echo json_encode($html);exit;
    }

    public function enable_partial_payment($course_id){
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        check_permission('enable_partial_payment');
        $page_data['forum'] = $this->user_model->course_details($course_id);
        $page_data['sections'] = $this->user_model->course_sections($course_id);
        $page_data['ps'] = $this->user_model->partial_course($course_id);
        // echo "<pre>";
        // print_r($page_data['ps']);exit;
        $page_data['page_name'] = 'enable_partial_payment';
        $page_data['page_title'] = get_phrase('enable_partial_payment');
        $page_data['course_id'] = $course_id;
        $this->load->view('backend/index', $page_data);
    }

    public function add_partial_payment(){
        $add = $this->user_model->add_partial_payment();
        if ($add) {
            $array = array(
                'status' => true,
                'msg' => "Successfully created"
            );
        }else{
            $array = array(
                'status' => false,
                'msg' => "Some error occured, please try agian after some time"
            );
        }
        echo json_encode($array);exit;
    }

// Puhupwas Starts
    public function quiz_cat()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        check_permission('quiz');


        // $page_data['selected_category_id']   = isset($_GET['category_id']) ? $_GET['category_id'] : "all";
        // $page_data['selected_instructor_id'] = isset($_GET['instructor_id']) ? $_GET['instructor_id'] : "all";
        // $page_data['selected_price']         = isset($_GET['price']) ? $_GET['price'] : "all";
        // $page_data['selected_status']        = isset($_GET['status']) ? $_GET['status'] : "all";

        // Courses query is used for deciding if there is any course or not. Check the view you will get it
        // $page_data['courses']                = $this->crud_model->filter_course_for_backend($page_data['selected_category_id'], $page_data['selected_instructor_id'], $page_data['selected_price'], $page_data['selected_status']);
        // $page_data['status_wise_courses']    = $this->crud_model->get_status_wise_courses();
        $page_data['quizes'] = $this->user_model->get_quiz_new()->result();
        // print_r($page_data['quizes']);
        // exit();
        $page_data['page_name'] = 'quiz_page';
        // $page_data['categories']          = $this->crud_model->get_categories();
        $page_data['page_title'] = get_phrase('quiz');
        $this->load->view('backend/index', $page_data);
    }
    // Puhupwas Ends

    // This function is responsible for loading the course data from server side for datatable SILENTLY
    public function get_courses()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $courses = array();
        // Filter portion
        $filter_data['selected_category_id'] = $this->input->post('selected_category_id');
        $filter_data['selected_instructor_id'] = $this->input->post('selected_instructor_id');
        $filter_data['selected_price'] = $this->input->post('selected_price');
        $filter_data['selected_status'] = $this->input->post('selected_status');

        // Server side processing portion
        $columns = array(
            0 => '#',
            1 => 'title',
            2 => 'category',
            3 => 'lesson_and_section',
            4 => 'enrolled_student',
            5 => 'status',
            6 => 'price',
            7 => 'actions',
            8 => 'course_id'
        );

        // Coming from databale itself. Limit is the visible number of data
        $limit = html_escape($this->input->post('length'));
        $start = html_escape($this->input->post('start'));
        $order = "";
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->lazyload->count_all_courses($filter_data);
        $totalFiltered = $totalData;

        // This block of code is handling the search event of datatable
        if (empty($this->input->post('search')['value'])) {
            $courses = $this->lazyload->courses($limit, $start, $order, $dir, $filter_data);
        } else {
            $search = $this->input->post('search')['value'];
            $courses = $this->lazyload->course_search($limit, $start, $search, $order, $dir, $filter_data);
            $totalFiltered = $this->lazyload->course_search_count($search);
        }

        // Fetch the data and make it as JSON format and return it.
        $data = array();
        if (!empty($courses)) {
            foreach ($courses as $key => $row) {
                $instructor_details = $this->user_model->get_all_user($row->user_id)->row_array();
                $category_details = $this->crud_model->get_category_details_by_id($row->sub_category_id)->row_array();
                $sections = $this->crud_model->get_section('course', $row->id);
                $lessons = $this->crud_model->get_lessons('course', $row->id);
                $enroll_history = $this->crud_model->enrol_history($row->id);

                $status_badge = "badge-success-lighten";
                if ($row->status == 'pending') {
                    $status_badge = "badge-danger-lighten";
                } elseif ($row->status == 'draft') {
                    $status_badge = "badge-dark-lighten";
                }

                $price_badge = "badge-dark-lighten";
                $price = 0;
                if ($row->is_free_course == 0) {
                    if ($row->discount_flag == 1) {
                        $price = currency($row->discounted_price);
                    } else {
                        $price = currency($row->price);
                    }
                } elseif ($row->is_free_course == 1) {
                    $price_badge = "badge-success-lighten";
                    $price = get_phrase('free');
                }

                $view_course_on_frontend_url = site_url('home/course/' . rawurlencode(slugify($row->title)) . '/' . $row->id);
                $edit_this_course_url = site_url('admin/course_form/course_edit/' . $row->id);
                $section_and_lesson_url = site_url('admin/course_form/course_edit/' . $row->id);

                if ($row->status == 'active') {
                    $course_status_changing_message = get_phrase('mark_as_pending');
                    if ($row->user_id != $this->session->userdata('user_id')) {
                        $course_status_changing_action = "showAjaxModal('" . site_url('modal/popup/mail_on_course_status_changing_modal/pending/' . $row->id . '/' . $filter_data['selected_category_id'] . '/' . $filter_data['selected_instructor_id'] . '/' . $filter_data['selected_price'] . '/' . $filter_data['selected_status']) . "', '" . $course_status_changing_message . "')";
                    } else {
                        $course_status_changing_action = "confirm_modal('" . site_url('admin/change_course_status_for_admin/pending/' . $row->id . '/' . $filter_data['selected_category_id'] . '/' . $filter_data['selected_instructor_id'] . '/' . $filter_data['selected_price'] . '/' . $filter_data['selected_status']) . "')";
                    }
                } else {
                    $course_status_changing_message = get_phrase('mark_as_active');
                    if ($row->user_id != $this->session->userdata('user_id')) {
                        $course_status_changing_action = "showAjaxModal('" . site_url('modal/popup/mail_on_course_status_changing_modal/active/' . $row->id . '/' . $filter_data['selected_category_id'] . '/' . $filter_data['selected_instructor_id'] . '/' . $filter_data['selected_price'] . '/' . $filter_data['selected_status']) . "', '" . $course_status_changing_message . "')";
                    } else {
                        $course_status_changing_action = "confirm_modal('" . site_url('admin/change_course_status_for_admin/active/' . $row->id . '/' . $filter_data['selected_category_id'] . '/' . $filter_data['selected_instructor_id'] . '/' . $filter_data['selected_price'] . '/' . $filter_data['selected_status']) . "')";
                    }
                }


                $delete_course_url = "confirm_modal('" . site_url('admin/course_actions/delete/' . $row->id) . "')";

                if ($row->course_type != 'scorm') {
                    $section_and_lesson_menu = '<li><a class="dropdown-item" href="' . $section_and_lesson_url . '">' . get_phrase("section_and_lesson") . '</a></li>';
                } else {
                    $section_and_lesson_menu = "";
                }

                $action = '
                <div class="dropright dropright">
                <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="mdi mdi-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="' . $view_course_on_frontend_url . '" target="_blank">' . get_phrase("view_course_on_frontend") . '</a></li>
                <li><a class="dropdown-item" href="' . $edit_this_course_url . '">' . get_phrase("edit_this_course") . '</a></li>
                ' . $section_and_lesson_menu . '
                <li><a class="dropdown-item" href="javascript::" onclick="' . $course_status_changing_action . '">' . $course_status_changing_message . '</a></li>
                <li><a class="dropdown-item" href="javascript::" onclick="' . $delete_course_url . '">' . get_phrase("delete") . '</a></li>
                </ul>
                </div>
                ';

                $nestedData['#'] = $key + 1;

                $nestedData['title'] = '<strong><a href="' . site_url('admin/course_form/course_edit/' . $row->id) . '">' . $row->title . '</a></strong><br>
                <small class="text-muted">' . get_phrase('instructor') . ': <b>' . $instructor_details['first_name'] . ' ' . $instructor_details['last_name'] . '</b></small>';

                $nestedData['category'] = '<span class="badge badge-dark-lighten">' . $category_details['name'] . '</span>';

                if ($row->course_type == 'scorm') {
                    $nestedData['lesson_and_section'] = '<span class="badge badge-info-lighten">' . get_phrase('scorm_course') . '</span>';
                } elseif ($row->course_type == 'general') {
                    $nestedData['lesson_and_section'] = '
                    <small class="text-muted"><b>' . get_phrase('total_section') . '</b>: ' . $sections->num_rows() . '</small><br>
                    <small class="text-muted"><b>' . get_phrase('total_lesson') . '</b>: ' . $lessons->num_rows() . '</small>';
                }

                $nestedData['enrolled_student'] = '<small class="text-muted"><b>' . get_phrase('total_enrolment') . '</b>: ' . $enroll_history->num_rows() . '</small>';

                $nestedData['status'] = '<span class="badge ' . $status_badge . '">' . get_phrase($row->status) . '</span>';

                $nestedData['price'] = '<span class="badge ' . $price_badge . '">' . $price . '</span>';

                $nestedData['actions'] = $action;

                $nestedData['course_id'] = $row->id;

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function pending_courses()
    {

        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        $page_data['page_name'] = 'pending_courses';
        $page_data['page_title'] = get_phrase('pending_courses');
        $this->load->view('backend/index', $page_data);
    }

    public function course_actions($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == "add") {
            $isUpcomingCourse = $this->input->post('is_upcoming_course') ? 1 : 0;
            $isFreeCourse = $this->input->post('is_free_course') ? 1 : 0;

            if ($isUpcomingCourse === 1) {
                // NOTIFICATION: Upcoming course added
                $title = 'Upcoming Course';
                $message = 'A new upcoming course is available.';
            } else if ($isFreeCourse === 1) {
                // NOTIFICATION: free course added
                $title = 'Free Course';
                $message = 'A new free course is available.';
            } else {
                // NOTIFICATION: paid course added
                $title = 'Paid Course';
                $message = 'A new paid course is available.';
            }

            $this->sendNotificationToAllUsers($title, $message);

            $course_id = $this->crud_model->add_course();
            redirect(site_url('admin/course_form/course_edit/' . $course_id), 'refresh');

        } elseif ($param1 == 'add_shortcut') {
            echo $this->crud_model->add_shortcut_course();
        } elseif ($param1 == "edit") {

            $this->crud_model->update_course($param2);

            // CHECK IF LIVE CLASS ADDON EXISTS, ADD OR UPDATE IT TO ADDON MODEL
            // if (addon_status('live-class')) {
            //     $this->load->model('addons/Liveclass_model','liveclass_model');
            //     $this->liveclass_model->update_live_class($param2);
            // }

            redirect(site_url('admin/courses'), 'refresh');
        } elseif ($param1 == 'delete') {
            $this->is_drafted_course($param2);
            $this->crud_model->delete_course($param2);
            redirect(site_url('admin/courses'), 'refresh');
        }elseif ($param1 == 'reviews') {
            if ($this->session->userdata('admin_login') != true) {
                redirect(site_url('login'), 'refresh');
            }
            $page_data['forum'] = $this->user_model->get_reviews($param2)->result();
            $page_data['page_name'] = 'reviews';
            $page_data['page_title'] = get_phrase('reviews');
            $this->load->view('backend/index', $page_data);
        }
    }

    public function delete_review($reviewId, $courseId){
        $result = $this->user_model->delete_reviews($reviewId);
        redirect(site_url('admin/course_actions/reviews/'.$courseId), 'refresh');
    }

    public function courses_enrolled(){
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        // $page_data['forum'] = $this->user_model->get_enrolled_courses($dateStart = '', $dateEnd = '', $type = '')->result();
        $page_data['page_name'] = 'courses_enrolled';
        $page_data['page_title'] = get_phrase('courses_enrolled');
        $this->load->view('backend/index', $page_data);
    }

    // public function cc($type = '', $start = '', $end = ''){
    //     print_r
    //     print_r($this->user_model->get_enrolled_courses('', '', '', $start, $end, $type)->result());exit;
    // }

    public function courses_enrolled_list($type = '', $start = '', $end = ''){


        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        check_permission('student');

        if (isset($_GET['search']['value'])) {
            $search = $_GET['search']['value'];
        } else {
            $search = '';
        }
        if (isset($_GET['length'])) {
            $limit = $_GET['length'];
        } else {
            $limit = 10;
        }

        if (isset($_GET['start'])) {
            $ofset = $_GET['start'];
        } else {
            $ofset = 0;
        }

        $users = $this->user_model->get_enrolled_courses($limit, $ofset, $search, $start, $end, $type)->result();

        $total = count($this->user_model->get_enrolled_courses('', '', $search, $start, $end, $type)->result());
        // print_r($total);

        $i = 1 + $ofset;
        $data = [];

        foreach ($users as $key => $user) {
            $data[] = array(
                $key + 1,
                $user->first_name.' '.$user->last_name,
                $user->title,
                date('d-m-Y', $user->date_added),
                date('d-m-Y', $user->date_expire),
            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }


    public function course_form($param1 = "", $param2 = "")
    {

        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'add_course') {
            $page_data['languages'] = $this->crud_model->get_all_languages();
            $page_data['categories'] = $this->crud_model->get_categories();
            $page_data['page_name'] = 'course_add';
            $page_data['page_title'] = get_phrase('add_course');
            $this->load->view('backend/index', $page_data);

        } elseif ($param1 == 'add_course_shortcut') {
            $page_data['languages'] = $this->crud_model->get_all_languages();
            $page_data['categories'] = $this->crud_model->get_categories();
            $this->load->view('backend/admin/course_add_shortcut', $page_data);
        } elseif ($param1 == 'course_edit') {
            $this->is_drafted_course($param2);
            $page_data['page_name'] = 'course_edit';
            $page_data['course_id'] = $param2;
            $page_data['page_title'] = get_phrase('edit_course');
            $page_data['languages'] = $this->crud_model->get_all_languages();
            $page_data['categories'] = $this->crud_model->get_categories();
            $this->load->view('backend/index', $page_data);
        }
    }

// Puhupwas Starts
    public function quiz_page_form($param1 = "", $param2 = "")
    {

        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'add_quiz') {
            $page_data['languages'] = $this->crud_model->get_all_languages();
            $page_data['categories'] = $this->crud_model->get_categories();
            $page_data['page_name'] = 'course_add';
            $page_data['page_title'] = get_phrase('add_course');
            $this->load->view('backend/index', $page_data);

        } elseif ($param1 == 'quiz_edit') {
            $this->is_drafted_course($param2);
            $page_data['page_name'] = 'course_edit';
            $page_data['course_id'] = $param2;
            $page_data['page_title'] = get_phrase('edit_course');
            $page_data['languages'] = $this->crud_model->get_all_languages();
            $page_data['categories'] = $this->crud_model->get_categories();
            $this->load->view('backend/index', $page_data);
        }
    }

    // Puhupwas Ends


    private function is_drafted_course($course_id)
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
        if ($course_details['status'] == 'draft') {
            $this->session->set_flashdata('error_message', get_phrase('you_do_not_have_right_to_access_this_course'));
            redirect(site_url('admin/courses'), 'refresh');
        }
    }

    public function change_course_status($updated_status = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $course_id = $this->input->post('course_id');
        $category_id = $this->input->post('category_id');
        $instructor_id = $this->input->post('instructor_id');
        $price = $this->input->post('price');
        $status = $this->input->post('status');
        if (isset($_POST['mail_subject']) && isset($_POST['mail_body'])) {
            $mail_subject = $this->input->post('mail_subject');
            $mail_body = $this->input->post('mail_body');
            $this->email_model->send_mail_on_course_status_changing($course_id, $mail_subject, $mail_body);
        }
        $this->crud_model->change_course_status($updated_status, $course_id);
        $this->session->set_flashdata('flash_message', get_phrase('course_status_updated'));
        redirect(site_url('admin/courses?category_id=' . $category_id . '&status=' . $status . '&instructor_id=' . $instructor_id . '&price=' . $price), 'refresh');
    }

    public function change_course_status_for_admin($updated_status = "", $course_id = "", $category_id = "", $status = "", $instructor_id = "", $price = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $this->crud_model->change_course_status($updated_status, $course_id);
        $this->session->set_flashdata('flash_message', get_phrase('course_status_updated'));
        redirect(site_url('admin/courses?category_id=' . $category_id . '&status=' . $status . '&instructor_id=' . $instructor_id . '&price=' . $price), 'refresh');
    }

    public function sections($param1 = "", $param2 = "", $param3 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param2 == 'add') {
            $this->crud_model->add_section($param1);
            $this->session->set_flashdata('flash_message', get_phrase('section_has_been_added_successfully'));
        } elseif ($param2 == 'edit') {
            $this->crud_model->edit_section($param3);
            $this->session->set_flashdata('flash_message', get_phrase('section_has_been_updated_successfully'));
        } elseif ($param2 == 'delete') {
            $this->crud_model->delete_section($param1, $param3);
            $this->session->set_flashdata('flash_message', get_phrase('section_has_been_deleted_successfully'));
        }
        redirect(site_url('admin/course_form/course_edit/' . $param1));
    }

    public function lessons($course_id = "", $param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        if ($param1 == 'add') {
            $this->crud_model->add_lesson();
            $this->session->set_flashdata('flash_message', get_phrase('lesson_has_been_added_successfully'));
            redirect('admin/course_form/course_edit/' . $course_id);
        } elseif ($param1 == 'edit') {
            $this->crud_model->edit_lesson($param2);
            $this->session->set_flashdata('flash_message', get_phrase('lesson_has_been_updated_successfully'));
            redirect('admin/course_form/course_edit/' . $course_id);
        } elseif ($param1 == 'delete') {
            $this->crud_model->delete_lesson($param2);
            $this->session->set_flashdata('flash_message', get_phrase('lesson_has_been_deleted_successfully'));
            redirect('admin/course_form/course_edit/' . $course_id);
        } elseif ($param1 == 'filter') {
            redirect('admin/lessons/' . $this->input->post('course_id'));
        }
        $page_data['page_name'] = 'lessons';
        $page_data['lessons'] = $this->crud_model->get_lessons('course', $course_id);
        $page_data['course_id'] = $course_id;
        $page_data['page_title'] = get_phrase('lessons');
        $this->load->view('backend/index', $page_data);
    }


    public function watch_video($slugified_title = "", $lesson_id = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $lesson_details = $this->crud_model->get_lessons('lesson', $lesson_id)->row_array();
        $page_data['provider'] = $lesson_details['video_type'];
        $page_data['video_url'] = $lesson_details['video_url'];
        $page_data['lesson_id'] = $lesson_id;
        $page_data['page_name'] = 'video_player';
        $page_data['page_title'] = get_phrase('video_player');
        $this->load->view('backend/index', $page_data);
    }


    // Language Functions
    public function manage_language($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'add_language') {
            $language = trimmer($this->input->post('language'));
            if ($language == 'n-a') {
                $this->session->set_flashdata('error_message', get_phrase('language_name_can_not_be_empty_or_can_not_have_special_characters'));
                redirect(site_url('admin/manage_language'), 'refresh');
            }
            saveDefaultJSONFile($language);
            $this->session->set_flashdata('flash_message', get_phrase('language_added_successfully'));
            redirect(site_url('admin/manage_language'), 'refresh');
        }
        if ($param1 == 'add_phrase') {
            $new_phrase = get_phrase($this->input->post('phrase'));
            $this->session->set_flashdata('flash_message', $new_phrase . ' ' . get_phrase('has_been_added_successfully'));
            redirect(site_url('admin/manage_language'), 'refresh');
        }

        if ($param1 == 'edit_phrase') {
            $page_data['edit_profile'] = $param2;
        }

        if ($param1 == 'delete_language') {
            if (file_exists('application/language/' . $param2 . '.json')) {
                unlink('application/language/' . $param2 . '.json');
                $this->session->set_flashdata('flash_message', get_phrase('language_deleted_successfully'));
                redirect(site_url('admin/manage_language'), 'refresh');
            }
        }
        $page_data['languages'] = $this->crud_model->get_all_languages();
        $page_data['page_name'] = 'manage_language';
        $page_data['page_title'] = get_phrase('multi_language_settings');
        $this->load->view('backend/index', $page_data);
    }

    public function update_phrase_with_ajax()
    {
        $current_editing_language = $this->input->post('currentEditingLanguage');
        $updatedValue = $this->input->post('updatedValue');
        $key = $this->input->post('key');
        saveJSONFile($current_editing_language, $key, $updatedValue);
        echo $current_editing_language . ' ' . $key . ' ' . $updatedValue;
    }

    function message($param1 = 'message_home', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');
        if ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent'));
            redirect(site_url('admin/message/message_read/' . $message_thread_code), 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message($param2); //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent'));
            redirect(site_url('admin/message/message_read/' . $param2), 'refresh');
        }

        if ($param1 == 'message_read') {
            $page_data['current_message_thread_code'] = $param2; // $param2 = message_thread_code
            $this->crud_model->mark_thread_messages_read($param2);
        }

        $page_data['message_inner_page_name'] = $param1;
        $page_data['page_name'] = 'message';
        $page_data['page_title'] = get_phrase('private_messaging');
        $this->load->view('backend/index', $page_data);
    }

    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        check_permission('settings');

        if ($param1 == 'update_profile_info') {
            $this->user_model->edit_user($param2);
            redirect(site_url('admin/manage_profile'), 'refresh');
        }
        if ($param1 == 'change_password') {
            $this->user_model->change_password($param2);
            redirect(site_url('admin/manage_profile'), 'refresh');
        }
        $page_data['page_name'] = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data'] = $this->db->get_where('users', array(
            'id' => $this->session->userdata('user_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }

    public function paypal_checkout_for_instructor_revenue()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        $page_data['amount_to_pay'] = $this->input->post('amount_to_pay');
        $page_data['payout_id'] = $this->input->post('payout_id');
        $page_data['instructor_name'] = $this->input->post('instructor_name');
        $page_data['production_client_id'] = $this->input->post('production_client_id');

        // BEFORE, CHECK PAYOUT AMOUNTS ARE VALID
        $payout_details = $this->crud_model->get_payouts($page_data['payout_id'], 'payout')->row_array();
        if ($payout_details['amount'] == $page_data['amount_to_pay'] && $payout_details['status'] == 0) {
            $this->load->view('backend/admin/paypal_checkout_for_instructor_revenue', $page_data);
        } else {
            $this->session->set_flashdata('error_message', get_phrase('invalid_payout_data'));
            redirect(site_url('admin/instructor_payout'), 'refresh');
        }

    }


    // PAYPAL CHECKOUT ACTIONS
    public function paypal_payment($payout_id = "", $paypalPaymentID = "", $paypalPaymentToken = "", $paypalPayerID = "")
    {
        $payout_details = $this->crud_model->get_payouts($payout_id, 'payout')->row_array();
        $instructor_id = $payout_details['user_id'];
        $instructor_data = $this->db->get_where('users', array('id' => $instructor_id))->row_array();
        $paypal_keys = json_decode($instructor_data['paypal_keys'], true);
        $production_client_id = $paypal_keys[0]['production_client_id'];
        $production_secret_key = $paypal_keys[0]['production_secret_key'];
        // $production_client_id = 'AZDxjDScFpQtjWTOUtWKbyN_bDt4OgqaF4eYXlewfBP4-8aqX3PiV8e1GWU6liB2CUXlkA59kJXE7M6R';
        // $production_secret_key = 'EFI50pO1s1cV1cySQ85wg2Pncn4VOPxKvTLBhyeGtd1QHNac-OJFsQlS7GAwlXZSg2wtm-BOJ9Ar3XJy';

        //THIS IS HOW I CHECKED THE PAYPAL PAYMENT STATUS
        $status = $this->payment_model->paypal_payment($paypalPaymentID, $paypalPaymentToken, $paypalPayerID, $production_client_id, $production_secret_key);
        if (!$status) {
            $this->session->set_flashdata('error_message', get_phrase('an_error_occurred_during_payment'));
            redirect(site_url('admin/instructor_payout'), 'refresh');
        }
        $this->crud_model->update_payout_status($payout_id, 'paypal');
        $this->session->set_flashdata('flash_message', get_phrase('payout_updated_successfully'));
        redirect(site_url('admin/instructor_payout'), 'refresh');
    }

    public function stripe_checkout_for_instructor_revenue($payout_id)
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        // BEFORE, CHECK PAYOUT AMOUNTS ARE VALID
        $payout_details = $this->crud_model->get_payouts($payout_id, 'payout')->row_array();
        if ($payout_details['amount'] > 0 && $payout_details['status'] == 0) {
            $page_data['user_details'] = $this->user_model->get_user($payout_details['user_id'])->row_array();
            $page_data['amount_to_pay'] = $payout_details['amount'];
            $page_data['payout_id'] = $payout_details['id'];
            $this->load->view('backend/admin/stripe_checkout_for_instructor_revenue', $page_data);
        } else {
            $this->session->set_flashdata('error_message', get_phrase('invalid_payout_data'));
            redirect(site_url('admin/instructor_payout'), 'refresh');
        }
    }

    // STRIPE CHECKOUT ACTIONS
    public function stripe_payment($payout_id = "", $session_id = "")
    {
        $payout_details = $this->crud_model->get_payouts($payout_id, 'payout')->row_array();
        $instructor_id = $payout_details['user_id'];
        //THIS IS HOW I CHECKED THE STRIPE PAYMENT STATUS
        $response = $this->payment_model->stripe_payment($instructor_id, $session_id, true);

        if ($response['payment_status'] === 'succeeded') {
            $this->crud_model->update_payout_status($payout_id, 'stripe');
            $this->session->set_flashdata('flash_message', get_phrase('payout_updated_successfully'));
        } else {
            $this->session->set_flashdata('error_message', $response['status_msg']);
        }

        redirect(site_url('admin/instructor_payout'), 'refresh');
    }

    public function preview($course_id = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        $this->is_drafted_course($course_id);
        if ($course_id > 0) {
            $courses = $this->crud_model->get_course_by_id($course_id);
            if ($courses->num_rows() > 0) {
                $course_details = $courses->row_array();
                redirect(site_url('home/lesson/' . rawurlencode(slugify($course_details['title'])) . '/' . $course_details['id']), 'refresh');
            }
        }
        redirect(site_url('admin/courses'), 'refresh');
    }

    // Manage Quizes
    public function quizes($course_id = "", $action = "", $quiz_id = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($action == 'add') {
            $this->crud_model->add_quiz($course_id);
            $this->session->set_flashdata('flash_message', get_phrase('quiz_has_been_added_successfully'));
        } elseif ($action == 'edit') {
            $this->crud_model->edit_quiz($quiz_id);
            $this->session->set_flashdata('flash_message', get_phrase('quiz_has_been_updated_successfully'));
        } elseif ($action == 'delete') {
            $this->crud_model->delete_section($course_id, $quiz_id);
            $this->session->set_flashdata('flash_message', get_phrase('quiz_has_been_deleted_successfully'));
        }
        redirect(site_url('admin/course_form/course_edit/' . $course_id));
    }


    // Manage Quizes New
    public function quizes_new($action = "", $quiz_id = "")
    {
        // echo '<pre>';
        // print_r($_POST);
        // echo $action;
        // exit();
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($action == 'add') {
            // NOTIFICATION: Quiz Added.
            $title = 'Quiz';
            $message = 'A new Quiz is available.';
            $this->sendNotificationToAllUsers($title, $message);

            $this->crud_model->add_quiz_new();
            $this->session->set_flashdata('flash_message', get_phrase('quiz_has_been_added_successfully'));
        } elseif ($action == 'edit') {
            $this->crud_model->edit_quiz_new($quiz_id);
            $this->session->set_flashdata('flash_message', get_phrase('quiz_has_been_updated_successfully'));
        } elseif ($action == 'delete') {
            $this->crud_model->delete_quiz($quiz_id);
            $this->session->set_flashdata('flash_message', get_phrase('quiz_has_been_deleted_successfully'));
        }
        redirect(site_url('admin/quiz_cat'));
    }


    // Manage Quize Questions
    public function quiz_questions($quiz_id = "", $action = "", $question_id = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        $quiz_details = $this->crud_model->get_lessons('lesson', $quiz_id)->row_array();
        if ($action == 'add') {
            $response = $this->crud_model->add_quiz_questions($quiz_id);
            echo $response;
        } elseif ($action == 'edit') {
            $response = $this->crud_model->update_quiz_questions($question_id);
            echo $response;
        } elseif ($action == 'delete') {
            $response = $this->crud_model->delete_quiz_question($question_id);
            $this->session->set_flashdata('flash_message', get_phrase('question_has_been_deleted'));
            redirect(site_url('admin/course_form/course_edit/' . $quiz_details['course_id']));
        }

    }

    // Manage Quize Questions
    public function quiz_questions_new($quiz_id = "", $action = "", $question_id = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }


        if ($action == 'add') {


            $response = $this->crud_model->add_quiz_questions($quiz_id);
            echo $response;
        } elseif ($action == 'edit') {
            $response = $this->crud_model->update_quiz_questions($question_id);
            echo $response;
        } elseif ($action == 'delete') {
            $response = $this->crud_model->delete_quiz_question($question_id);
            $this->session->set_flashdata('flash_message', get_phrase('question_has_been_deleted'));
            redirect(site_url('admin/quiz_cat'));
        }
    }

    // software about page
    function about()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        $page_data['application_details'] = $this->crud_model->get_application_details();
        $page_data['page_name'] = 'about';
        $page_data['page_title'] = get_phrase('about');
        $this->load->view('backend/index', $page_data);
    }

    public function install_theme($theme_to_install = '')
    {

        if ($this->session->userdata('admin_login') != 1) {
            redirect(site_url('login'), 'refresh');
        }

        $uninstalled_themes = $this->crud_model->get_uninstalled_themes();
        if (!in_array($theme_to_install, $uninstalled_themes)) {
            $this->session->set_flashdata('error_message', get_phrase('this_theme_is_not_available'));
            redirect(site_url('admin/theme_settings'));
        }

        if (!class_exists('ZipArchive')) {
            $this->session->set_flashdata('error_message', get_phrase('your_server_is_unable_to_extract_the_zip_file') . '. ' . get_phrase('please_enable_the_zip_extension_on_your_server') . ', ' . get_phrase('then_try_again'));
            redirect(site_url('admin/theme_settings'));
        }

        $zipped_file_name = $theme_to_install;
        $unzipped_file_name = substr($zipped_file_name, 0, -4);
        // Create update directory.
        $views_directory = 'application/views/frontend';
        $assets_directory = 'assets/frontend';

        //Unzip theme zip file and remove zip file.
        $theme_path = 'themes/' . $zipped_file_name;
        $theme_zip = new ZipArchive;
        $theme_result = $theme_zip->open($theme_path);
        if ($theme_result === TRUE) {
            $theme_zip->extractTo('themes');
            $theme_zip->close();
        }

        // unzip the views zip file to the application>views folder
        $views_path = 'themes/' . $unzipped_file_name . '/views/' . $zipped_file_name;
        $views_zip = new ZipArchive;
        $views_result = $views_zip->open($views_path);
        if ($views_result === TRUE) {
            $views_zip->extractTo($views_directory);
            $views_zip->close();
        }

        // unzip the assets zip file to the assets/frontend folder
        $assets_path = 'themes/' . $unzipped_file_name . '/assets/' . $zipped_file_name;
        $assets_zip = new ZipArchive;
        $assets_result = $assets_zip->open($assets_path);
        if ($assets_result === TRUE) {
            $assets_zip->extractTo($assets_directory);
            $assets_zip->close();
        }

        unlink($theme_path);
        $this->crud_model->remove_files_and_folders('themes/' . $unzipped_file_name);
        $this->session->set_flashdata('flash_message', get_phrase('theme_imported_successfully'));
        redirect(site_url('admin/theme_settings'));
    }

    //ADDON MANAGER PORTION STARTS HERE
    public function addon($param1 = "", $param2 = "", $param3 = "")
    {
        if ($this->session->userdata('admin_login') != 1) {
            redirect(site_url('login'), 'refresh');
        }
        // ADD NEW ADDON FORM
        if ($param1 == 'add') {

            $page_data['page_name'] = 'addon_add';
            $page_data['page_title'] = get_phrase('add_addon');
        }

        if ($param1 == 'update') {

            $page_data['page_name'] = 'addon_update';
            $page_data['page_title'] = get_phrase('add_update');
        }

        // INSTALLING AN ADDON
        if ($param1 == 'install' || $param1 == 'version_update') {
            $this->addon_model->install_addon($param1);
        }

        // ACTIVATING AN ADDON
        if ($param1 == 'activate') {
            $update_message = $this->addon_model->addon_activate($param2);
            $this->session->set_flashdata('flash_message', get_phrase($update_message));
            redirect(site_url('admin/addon'), 'refresh');
        }

        // DEACTIVATING AN ADDON
        if ($param1 == 'deactivate') {
            $update_message = $this->addon_model->addon_deactivate($param2);
            $this->session->set_flashdata('flash_message', get_phrase($update_message));
            redirect(site_url('admin/addon'), 'refresh');
        }

        // REMOVING AN ADDON
        if ($param1 == 'delete') {
            $this->addon_model->addon_delete($param2);
            $this->session->set_flashdata('flash_message', get_phrase('addon_is_deleted_successfully'));
            redirect(site_url('admin/addon'), 'refresh');
        }

        // SHOWING LIST OF INSTALLED ADDONS
        if (empty($param1)) {
            $page_data['page_name'] = 'addons';
            $page_data['addons'] = $this->addon_model->addon_list()->result_array();
            $page_data['page_title'] = get_phrase('addon_manager');
        }
        $this->load->view('backend/index', $page_data);
    }

    //AVAILABLE_ADDONS
    public function available_addons()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        $page_data['page_name'] = 'available_addon';
        $page_data['page_title'] = get_phrase('available_addon');
        $this->load->view('backend/index', $page_data);
    }

    public function instructor_application($param1 = "", $param2 = "")
    { // param1 is the status and param2 is the application id
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        check_permission('instructor');

        if ($param1 == 'approve' || $param1 == 'delete') {
            $this->user_model->update_status_of_application($param1, $param2);
        }
        $page_data['page_name'] = 'application_list';
        $page_data['page_title'] = get_phrase('instructor_application');
        $page_data['approved_applications'] = $this->user_model->get_approved_applications();
        $page_data['pending_applications'] = $this->user_model->get_pending_applications();
        $this->load->view('backend/index', $page_data);
    }


    // INSTRUCTOR PAYOUT SECTION
    public function instructor_payout($param1 = "")
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        check_permission('instructor');

        if ($param1 != "") {
            $page_data['month'] = $this->input->get('month');
            $page_data['year'] = $this->input->get('year');
        } else {
            $page_data['month'] = date('m');
            $page_data['year'] = date('Y');
        }

        $page_data['page_name'] = 'instructor_payout';
        $page_data['page_title'] = get_phrase('instructor_payout');
        $page_data['completed_counselling_payouts'] = $this->crud_model->get_completed_counselling_payouts($page_data['month'], $page_data['year'], "counselling");
        $this->load->view('backend/index', $page_data);
    }

    public function pending_payout($param1 = "")
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        check_permission('instructor');

        if ($param1 != "") {
            $page_data['month'] = $this->input->get('month');
            $page_data['year'] = $this->input->get('year');
        } else {
            $page_data['month'] = date('m');
            $page_data['year'] = date('Y');
        }

        $page_data['page_name'] = 'instructor_pending_payout';
        $page_data['page_title'] = get_phrase('instructor_pending_payout');

        $page_data['pending_counselling_payouts'] = $this->crud_model->get_pending_counselling_payouts($page_data['month'], $page_data['year'], "counselling");

        $this->load->view('backend/index', $page_data);
    }

    public function settlement()
    {

        $response = $this->crud_model->adminSettlement();

        if ($response) {
            $this->session->set_flashdata('flash_message', 'Settlement successfully');
        } else {
            $this->session->set_flashdata('error_message', 'Something went wrong');
        }

        if ($this->input->post('type') === 'live') {
            redirect(site_url('admin/pending_payout_live_class'), 'refresh');
        } else {
            redirect(site_url('admin/pending_payout'), 'refresh');
        }

    }




    // AJAX PORTION
    // this function is responsible for managing multiple choice question
    function manage_multiple_choices_options()
    {
        $page_data['number_of_options'] = $this->input->post('number_of_options');
        $this->load->view('backend/admin/manage_multiple_choices_options', $page_data);
    }

    public function ajax_get_sub_category($category_id)
    {
        $page_data['sub_categories'] = $this->crud_model->get_sub_categories($category_id);

        return $this->load->view('backend/admin/ajax_get_sub_category', $page_data);
    }

    public function ajax_get_section($course_id)
    {
        $page_data['sections'] = $this->crud_model->get_section('course', $course_id)->result_array();
        return $this->load->view('backend/admin/ajax_get_section', $page_data);
    }

    public function ajax_get_video_details()
    {
        $video_details = $this->video_model->getVideoDetails($_POST['video_url']);
        echo $video_details['duration'];
    }

    public function ajax_sort_section()
    {
        $section_json = $this->input->post('itemJSON');
        $this->crud_model->sort_section($section_json);
    }

    public function ajax_sort_lesson()
    {
        $lesson_json = $this->input->post('itemJSON');
        $this->crud_model->sort_lesson($lesson_json);
    }

    public function ajax_sort_question()
    {
        $question_json = $this->input->post('itemJSON');
        $this->crud_model->sort_question($question_json);
    }

    //not script part
    //child category
    public function child_categories($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'add') {
            $response = $this->crud_model->add_category();
            if ($response) {
                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            } else {
                $this->session->set_flashdata('error_message', get_phrase('category_name_already_exists'));
            }
            redirect(site_url('admin/child_categories/view/' . $param2), 'refresh');
        } elseif ($param1 == "edit") {
            $response = $this->crud_model->edit_category($param2);
            if ($response) {
                $this->session->set_flashdata('flash_message', get_phrase('data_added_successfully'));
            } else {
                $this->session->set_flashdata('error_message', get_phrase('category_name_already_exists'));
            }
            redirect(site_url('admin/child_categories/view/' . $this->input->post('parent')), 'refresh');
        }
        // elseif ($param1 == "delete") {
        //     $this->crud_model->delete_category($param2);
        //     $this->session->set_flashdata('flash_message', get_phrase('data_deleted'));
        //     redirect(site_url('admin/categories'), 'refresh');
        // }
        $this->load->model('Lyvyo_model', 'lyvyo_model');
        $page_data['page_name'] = 'coursechildcategory';
        $page_data['page_title'] = "Child Category";
        $page_data['subcategory'] = $this->lyvyo_model->getSubcategoryByCategory($param2)->row();
        $page_data['childcategory'] = $this->lyvyo_model->getChildCategoryBySubCategoryId($param2)->result();
        $this->load->view('backend/index.php', $page_data);
    }

    public function childcategory_form($param1 = "", $param2 = "")
    {


        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $this->load->model('Lyvyo_model', 'lyvyo_model');
        if ($param1 == 'add_child_category') {
            $page_data['page_name'] = 'coursechildcategory_add';
            $page_data['page_title'] = "Add Child Category";
            $page_data['subcategory'] = $this->lyvyo_model->getSubcategoryByCategory($param2)->row();

            $this->load->view('backend/index', $page_data);

        } elseif ($param1 == 'edit_child_catgeory') {


            // $this->is_drafted_course($param2);
            $page_data['page_name'] = 'coursechildcategory_edit';
            $page_data['child_id'] = $param2;
            $page_data['page_title'] = "Edit Child Category";
            $page_data['category_details'] = $this->crud_model->get_category_details_by_id($param2)->row();

            $this->load->view('backend/index', $page_data);
        }
    }

    //fetch subcategory by category id
    public function getSubCategoryByCategoryId()
    {

        $this->load->model('Lyvyo_model', 'lyvyo_model');
        $catid = $this->input->post('cat');
        $subcategory = $this->lyvyo_model->getSubCategoryByCategoryId($catid)->result();
        echo json_encode($subcategory);
    }

    public function newsletter()
    {
        // $this->is_drafted_course($param2);
        $page_data['page_name'] = 'newsletter';
        $page_data['page_title'] = "Newsletter";
        $this->load->model('Lyvyo_model', 'lyvyo_model');
        $page_data['newsletterDetails'] = $this->lyvyo_model->getnewsletterDetails()->row();


        $this->load->view('backend/index', $page_data);
    }

    public function newsletterview()
    {
        // $this->is_drafted_course($param2);
        $page_data['page_name'] = 'newsletter_view';
        $page_data['page_title'] = "Newsletter View";
        $this->load->model('Lyvyo_model', 'lyvyo_model');
        $page_data['newsletterDetails'] = $this->lyvyo_model->getnewsletterDetails()->row();

        $countCourse = json_decode($page_data['newsletterDetails']->newsletter_courses);

        $courses = [];

        for ($i = 0; $i < count($countCourse); $i++) {
            $course = $this->lyvyo_model->getCourseDetailById($countCourse[$i]);

            array_push($courses, $course);


        }

        $page_data['courses'] = $courses;

        $this->load->view('backend/index', $page_data);


    }

    public function newsletteredit($newsletterId)
    {
        $this->load->model('Lyvyo_model', 'lyvyo_model');
        $page_data['courses'] = $this->lyvyo_model->getAllCourses()->result();
        $page_data['newsletterDetails'] = $this->lyvyo_model->getnewsletterDetails($newsletterId)->row();
        $page_data['page_name'] = 'newsletter_edit';
        $page_data['page_title'] = "Newsletter Edit";
        $this->load->view('backend/index', $page_data);
    }

    public function updatenewsletter($newsletterId)
    {

        $this->form_validation->set_rules('website_name', 'Add Website Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Add Your Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('email_title', 'Email Title', 'trim|required');
        $this->form_validation->set_rules('email_description', 'Email Description', 'trim|required');
        $this->form_validation->set_rules('select_courses[]', 'Select Courses', 'trim|required');
        $this->form_validation->set_rules('footer_text', 'Footer Text', 'trim|required');

        if ($this->form_validation->run() == false) {

            $this->session->set_flashdata('error_message', validation_errors());
            redirect(base_url('admin/newsletteredit/') . $newsletterId, 'refresh');
        } else {
            $this->load->model('Lyvyo_model', 'lyvyo_model');
            $res = $this->lyvyo_model->updateNewsLetter();

            if ($res) {
                $this->session->set_flashdata('flash_message', "Updated Successfully");
                redirect(base_url('admin/newsletteredit/' . $newsletterId, 'refresh'));
            } else {
                $this->session->set_flashdata('error_message', "You have not made any changes");
                redirect(base_url('admin/newsletteredit/' . $newsletterId, 'refresh'));
            }


        }

    }

    public function blogs_form($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $this->load->model('Lyvyo_model', 'lyvyo_model');
        if ($param1 == "add_blog") {
            $page_data['page_name'] = 'add_blogs';
            $page_data['page_title'] = "Add Blogs";
        }
        if ($param1 == "edit_blog") {
            $page_data['page_name'] = 'blog_edit';
            $page_data['page_title'] = "Blog Edit";
            $page_data['blog'] = $this->lyvyo_model->fetch_blog_by_Id($param2)->row();
            $page_data['blog_id'] = $param2;
        }
        if ($param1 == "blog_list") {
            $page_data['page_name'] = 'blog_list';
            $page_data['page_title'] = "Blog Lists";
            $page_data['blogs'] = $this->lyvyo_model->fetch_all_blogs()->result();

        }


        $this->load->view('backend/index', $page_data);
    }

    public function blog_add()
    {
        if ($this->session->userdata('admin_login') != true) {
            $output['status'] = false;
            $output['msg'] = "Unauthorised Access";

        } else {
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('blogger_name', 'Blogger Name', 'trim|required');
            $this->form_validation->set_rules('shortdesc', 'Short Description', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');

            if ($this->form_validation->run() == false) {
                $output['status'] = false;
                $output['msg'] = validation_errors();

            } else {
                $this->load->model('Lyvyo_model', 'lyvyo_model');
                $res = $this->lyvyo_model->add_blog();

                if ($res) {
                    $this->session->set_flashdata('flash_message', "Successfully Added");
                    $output['status'] = true;
                    $output['msg'] = "Successfully Added";

                } else {

                    $output['status'] = false;
                    $output['msg'] = "Error occurred, please try again";

                }
            }
        }

        echo json_encode($output);
        exit;

    }

    //blog edit form submit
    public function blog_edit()
    {

        if ($this->session->userdata('admin_login') != true) {
            $output['status'] = false;
            $output['msg'] = "Unauthorised Access";

        } else {
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('blogger_name', 'Blogger Name', 'trim|required');
            $this->form_validation->set_rules('shortdesc', 'Short Description', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');

            if ($this->form_validation->run() == false) {
                $output['status'] = false;
                $output['msg'] = validation_errors();

            } else {

                $this->load->model('Lyvyo_model', 'lyvyo_model');
                $res = $this->lyvyo_model->edit_blog();

                if ($res) {
                    $this->session->set_flashdata('flash_message', "Successfully Update");
                    $output['status'] = true;
                    $output['msg'] = "Successfully Updated";

                } else {

                    $output['status'] = false;
                    $output['msg'] = "You have not made any changes";

                }
            }
        }

        echo json_encode($output);
        exit;
    }

    //delete Blog
    public function delete_blog()
    {
        $this->load->model('Lyvyo_model', 'lyvyo_model');

        $res = $this->lyvyo_model->delete_blog();

        if ($res) {
            $this->session->set_flashdata('flash_message', "Successfully Update");
            $output['status'] = true;
            $output['msg'] = "Successfully Updated";
        } else {
            $output['status'] = false;
            $output['msg'] = "Errro occurred, please try again";
        }
    }


    public function educators($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        if ($param1 == 'add_educators') {
            // CHECK ACCESS PERMISSION
            check_permission('admin');
            $page_data['page_name'] = 'educator_add';
            $page_data['page_title'] = get_phrase('educator_add');
            if (!empty($param2)) {
                $page_data['educator_by_id'] = $this->Educator_model->Get_educator_by_id($param2);
                $page_data['educator_qualifications'] = $this->Educator_model->Get_educator_qualifications($param2);
            }
            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == 'manage_educators') {
            check_permission('admin');

            $page_data['page_name'] = 'educators';
            $page_data['user_id'] = $param2;
            $page_data['all_educators'] = $this->Educator_model->Get_educator();
            $page_data['page_title'] = get_phrase('educators');
            $this->load->view('backend/index', $page_data);
        } elseif ($param1 == 'educators_qualifications') {
            check_permission('admin');

            $page_data['page_name'] = 'educators_qualifications';
            $page_data['user_id'] = $param2;
            $page_data['all_educators'] = $this->Educator_model->Get_educator();
            if (!empty($param2)) {
                $page_data['educator_by_id'] = $this->Educator_model->Get_educator_by_id($param2);
                $page_data['educator_qualifications'] = $this->Educator_model->Get_educator_qualifications($param2);
            }
            $page_data['page_title'] = get_phrase('educators_qualifications');
            $this->load->view('backend/index', $page_data);
        }
    }

    // ADMINS SECTION STARTS
    public function educatorsFunc($param1 = "", $param2 = "")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        // CHECK ACCESS PERMISSION
        check_permission('admin');

        if ($param1 == "add") {
            // CHECK ACCESS PERMISSION
            check_permission('admin');

            $this->form_validation->set_rules('first_name', 'First name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('last_name', 'Last name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata('educators_msg', validation_errors());
                redirect(site_url('admin/educators/add_educators'), 'refresh');
            } else {

                if (!empty($_FILES['user_image']['name'])) {

                    $attachment = 'TM_' . $this->input->post('first_name') . '_' . $this->input->post('last_name') . date('ymdhis') . rand(0, 99);
                    $path = $_FILES['user_image']['name'];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $tmpuser = base_url() . "uploads/educators/" . $attachment . '.' . $ext;

                    $config['upload_path'] = './uploads/educators/';
                    $config['allowed_types'] = 'jpg|png|jpeg';
                    $config['file_name'] = $attachment . '.' . $ext;
                    $config['overwrite'] = 0;
                    $config['max_size'] = 0;
                    $config['max_width'] = 0;
                    $config['max_height'] = 0;

                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('user_image')) {
                        $this->session->set_flashdata('educators_msg', $this->upload->display_errors());
                        redirect(site_url('admin/educators/add_educators'), 'refresh');
                    }

                } else {
                    $tmpuser = $this->input->post('user_image_old');
                }

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

                // print_r($this->input->post('quli_certify_old'));
                // exit;

                $result_educator = $this->Educator_model->Add_educator($tmp, $tmpuser);
                if ($result_educator) {
                    $this->session->set_flashdata('educators_msg_success', $this->upload->display_errors());
                    redirect(site_url('admin/educators/manage_educators'), 'refresh');
                }
                exit;
            }
            exit;
            // redirect(site_url('admin/admins'), 'refresh');
        } elseif ($param1 == "update_qualification") {
            $educator_by_id = $this->Educator_model->Get_educator_by_id($this->input->post('educator_id'));
            if (!empty($_FILES['quli_certify']['name'])) {

                $attachment = 'CC_' . $educator_by_id->first_name . '_' . $educator_by_id->last_name . date('ymdhis') . rand(0, 99);
                $path = $_FILES['quli_certify']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $tmpuser = base_url() . "uploads/educator_qualifications/" . $attachment . '.' . $ext;

                $config['upload_path'] = './uploads/educator_qualifications/';
                $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc';
                $config['file_name'] = $attachment . '.' . $ext;
                $config['overwrite'] = 0;
                $config['max_size'] = 0;
                $config['max_width'] = 0;
                $config['max_height'] = 0;

                $this->upload->initialize($config);
                if (!$this->upload->do_upload('quli_certify')) {
                    $this->session->set_flashdata('educators_msg', $this->upload->display_errors());
                    redirect(site_url('admin/educators/educators_qualifications/' . $this->input->post('educator_id') . ''), 'refresh');
                }

            } else {
                $tmpuser = $this->input->post('quli_certify_old');
            }

            $result_educator_quli = $this->Educator_model->updateQualification($tmpuser);
            if ($result_educator_quli) {
                $this->session->set_flashdata('educators_msg_success', 'Updated successfully');
                redirect(site_url('admin/educators/educators_qualifications/' . $this->input->post('educator_id') . ''), 'refresh');
            }
        } elseif ($param1 == "deleteQulifications") {
            check_permission('admin');
            $result_educator_quli = $this->Educator_model->DeleteQualification($param2);
            if ($result_educator_quli) {
                $this->session->set_flashdata('educators_msg_success', 'Deleted successfully');
                redirect(site_url('admin/educators/educators_qualifications/' . $result_educator_quli . ''), 'refresh');
            }
        } elseif ($param1 == "deleteEducators") {
            check_permission('admin');
            $delete_educators = $this->Educator_model->delete_educators($param2);
            if ($delete_educators) {
                $this->session->set_flashdata('educators_msg_success', 'Deleted successfully');
                redirect(site_url('admin/educators/manage_educators'), 'refresh');
            }
        }
        $page_data['page_name'] = 'admins';
        $page_data['page_title'] = get_phrase('admins');
        $page_data['admins'] = $this->user_model->get_admins()->result_array();
        $this->load->view('backend/index', $page_data);
    }

    // Puhupwas Starts
    public function forum()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        check_permission('forum');
        $page_data['forum'] = $this->user_model->get_forum()->result();
        $page_data['page_name'] = 'forum';
        $page_data['page_title'] = get_phrase('forum');
        $this->load->view('backend/index', $page_data);
    }


    public function uncomplete_orders($start = "", $end ="")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        // print_r($this->session->userdata('user_id'));exit;
        check_permission('incomplete_orders');
        if (empty($start) || empty($end)) {
            $page_data['forum'] = $this->user_model->get_cart()->result();
        }else{
            $page_data['forum'] = $this->user_model->get_cart_by_date($start, $end)->result();
        }
        $page_data['page_name'] = 'uncomplete_orders';
        $page_data['page_title'] = get_phrase('incomplete_orders');
        $this->load->view('backend/index', $page_data);
    }

    public function user_clicks($start = "", $end ="")
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        check_permission('user_clicks');
        if (empty($start) || empty($end)) {
           $page_data['forum'] = $this->user_model->user_clicks()->result();
        }else{
           $page_data['forum'] = $this->user_model->user_clicks_by_date($start, $end)->result();
        }
        
        $page_data['page_name'] = 'user_clicks';
        $page_data['page_title'] = get_phrase('user_clicks');
        $this->load->view('backend/index', $page_data);
    }

    public function social_links()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        check_permission('social_links');
        $page_data['forum'] = $this->user_model->solcial_links_get();
        // print_r($page_data['forum']['facebook']->key);exit;
        $page_data['page_name'] = 'social_links';
        $page_data['page_title'] = get_phrase('social_links');
        $this->load->view('backend/index', $page_data);
    }

    public function solcial_links_update(){
        // echo json_encode($_POST);exit;
        $settings = $this->user_model->solcial_links_update();
        if ($settings) {
            $array = array(
                'status' => true,
                'msg' => 'Successfully Updated'
            );
        }else{
            $array = array(
                'status' => false,
                'msg' => 'Some error occured, please try again later'
            );
        }
        echo json_encode($array);exit;
    }


    // Manage Foram
    public function forum_manage($action = "", $forum_id = "", $status = "")
    {

        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }


        if ($action == 'update') {
            $this->crud_model->update_forum($forum_id, $status);
            $this->session->set_flashdata('flash_message', get_phrase('forum_has_been_updated_successfully'));

        }

        // elseif ($action == 'edit') {
        //     $this->crud_model->edit_quiz_new($forum_id);
        //     $this->session->set_flashdata('flash_message', get_phrase('quiz_has_been_updated_successfully'));
        // }

        elseif ($action == 'delete') {
            $this->crud_model->delete_forum($forum_id);
            $this->session->set_flashdata('flash_message', get_phrase('forum_has_been_deleted_successfully'));
        }
        // elseif ($action == 'reply') {
        //     $this->crud_model->forum_reply($forum_id);
        //     $this->session->set_flashdata('flash_message', get_phrase('successfully replied'));
        // }
        // elseif ($action == 'reply_on_reply') {
        //     $this->crud_model->forum_reply_on_reply($forum_id);
        //     $this->session->set_flashdata('flash_message', get_phrase('successfully replied'));
        // }
        redirect(site_url('admin/forum'));
    }

    // Manage Foram Reply
    public function forum_replies_manage($action = "", $forum_id = "", $forum_reply_id = "")
    {

        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }


        if ($action == 'update') {
            $this->crud_model->update_forum_reply($forum_reply_id, $forum_id);
            $this->session->set_flashdata('flash_message', get_phrase('forum_has_been_updated_successfully'));

        }

        // elseif ($action == 'edit') {
        //     $this->crud_model->edit_quiz_new($forum_id);
        //     $this->session->set_flashdata('flash_message', get_phrase('quiz_has_been_updated_successfully'));
        // }

        elseif ($action == 'delete') {
            $this->crud_model->delete_forum_reply($forum_reply_id);
            $this->session->set_flashdata('flash_message', get_phrase('forum_reply_has_been_deleted_successfully'));
        } elseif ($action == 'reply') {
            $this->crud_model->forum_reply($forum_id);
            $this->session->set_flashdata('flash_message', get_phrase('successfully replied'));
        } elseif ($action == 'reply_on_reply') {
            $this->crud_model->forum_reply_on_reply($forum_id);
            $this->session->set_flashdata('flash_message', get_phrase('successfully replied'));
        }

        redirect(site_url('admin/redirection/forum_replies/' . $forum_id));
    }


    public function redirection($action = "", $forum_id = "")
    {
        $page_data['page_name'] = $action;
        $page_data['page_title'] = get_phrase('forum_details');
        $page_data['forum_id'] = $forum_id;
        // $this->load->view('backend/admin/'.$action,compact('forum_id'));
        $this->load->view('backend/index', $page_data);
    }


    public function live_class()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        check_permission('live');

        if (isset($_GET['instructor_id'])) {
            $where = ['instructor_id' => $_GET['instructor_id']];
        } else {
            $where = [];
        }

        $page_data['live_class_list'] = $this->crud_model->fetchLiveClassList('lctn.* , u.first_name , u.last_name', $where)->result();
        $page_data['instructors'] = $this->user_model->get_instructor()->result_array();
        $page_data['page_name'] = 'live_class';
        $page_data['page_title'] = get_phrase('live_class');
        $this->load->view('backend/index', $page_data);
    }

    // Manage Foram Reply
    public function live_class_manage($action = "", $live_class_id = "")
    {

        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($action == 'add') {
            $this->form_validation->set_rules('class_name', 'Class Name', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('instructor', 'Instructor', 'trim|required');
            $this->form_validation->set_rules('payment_type', 'Payment Type', 'trim|required');
            $this->form_validation->set_rules('number_of_students', 'No. of Students', 'trim|required');
            $this->form_validation->set_rules('date', 'Date', 'trim|required');
            $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
            $this->form_validation->set_rules('duration', 'Duration', 'trim|required');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('flash_message', validation_errors());
            } else {
                $res = $this->crud_model->add_live_class();

                if ($res) {
                    $this->session->set_flashdata('flash_message', get_phrase('live_class_has_been_added_successfully'));

                } else {
                    $this->session->set_flashdata('flash_message', get_phrase('Error occurred, please try again'));

                }
            }


        } elseif ($action == 'edit') {
            $this->crud_model->edit_live_class_new($live_class_id);
            $this->session->set_flashdata('flash_message', get_phrase('live_class_has_been_updated_successfully'));
        } elseif ($action == 'delete') {
            $this->crud_model->delete_live_class($live_class_id);
            $this->session->set_flashdata('flash_message', get_phrase('live_class_has_been_deleted_successfully'));
        }

        redirect(site_url('admin/live_class'));
    }







    // //from home controller
    // //live course add view
    // public function addLiveClassDateTimeViewNew()
    // {
    //     $this->load->model('Lyvyo_model','lyvyo_model');
    //     $page_data['page_name'] = 'live_class_time_new';
    //     $page_data['page_title'] = 'Live Class Time';
    //     $page_data['time'] = $this->lyvyo_model->fetchTime();
    //     $page_data['categories'] = $this->lyvyo_model->fetchParentCategories();
    //     $this->load->view('backend/index', $page_data);
    // }


    // //add live class form submit
    // public function addLiveClassDateTimeNew()
    // {

    //     $this->form_validation->set_rules('date','Date','trim|required');
    //     // $this->form_validation->set_rules('start_time','Start Time','trim|required');
    //     // $this->form_validation->set_rules('end_time','End Time','trim|required');
    //     $this->form_validation->set_rules('time[]','Select Time Schedule','required');
    //     $this->form_validation->set_rules('parent_category','Category','trim|required');
    //     $this->form_validation->set_rules('subcategory','Sub Category','trim|required');

    //     if($this->form_validation->run() === false)
    //     {
    //         $output['status'] = false;
    //         $output['msg'] = validation_errors();
    //     }
    //     else
    //     {
    //         $this->load->model('Lyvyo_model','lyvyo_model');
    //         $res = $this->lyvyo_model->addLiveClassTime();

    //         if($res)
    //         {
    //              $this->session->set_flashdata('flash_message', "Successfully Added");
    //              $output['status'] = true;
    //              $output['msg'] = "Successfully Added";
    //         }
    //         else
    //         {
    //             $output['status'] = false;
    //             $output['msg'] = "Error occurred, please try again";
    //         }
    //     }

    //     echo json_encode($output);
    //     exit;

    // }

    // //show list live class
    // public function liveClassListNew()
    // {
    //     $this->load->model('Lyvyo_model','lyvyo_model');
    //     $page_data['page_name'] = 'live_class_time_list';
    //     $page_data['page_title'] = 'Live Class Time List';
    //     $page_data['class'] = $this->lyvyo_model->fetchLiveClassList();

    //     print_r($page_data['class']);
    //     exit;

    //     $this->load->view('frontend/'.get_frontend_settings('theme').'/index', $page_data);
    // }


    public function counselling_session()
    {
        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        check_permission('counselling');

        if (isset($_GET['instructor_id'])) {
            $where = ['ec_teacher_id' => $_GET['instructor_id']];
        } else {
            redirect(site_url('login'), 'refresh');
        }

        $page_data['counselling_session_list'] = $this->crud_model->enroll_counselling_session('enroll_counselling.* , users.first_name , users.last_name', $where)->result();
        $page_data['instructors'] = $this->user_model->get_instructor()->result_array();
        $page_data['page_name'] = 'counselling_session';
        $page_data['page_title'] = get_phrase('counselling_session');
        $this->load->view('backend/index', $page_data);
    }

    // Manage Foram Reply
    public function counselling_session_manage($action = "", $counselling_session_id = "")
    {

        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($action == 'add') {
            $this->form_validation->set_rules('counselling_name', 'Counselling Name', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('instructor', 'Instructor', 'trim|required');
            $this->form_validation->set_rules('payment_type', 'Payment Type', 'trim|required');
            $this->form_validation->set_rules('price', 'Price', 'trim|required');
            $this->form_validation->set_rules('date', 'Date', 'trim|required');
            $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
            $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');
            // $this->form_validation->set_rules('time[]','Select Time Schedule','required');
            // $this->form_validation->set_rules('parent_category','Category','trim|required');
            // $this->form_validation->set_rules('subcategory','Sub Category','trim|required');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('flash_message', validation_errors());
            } else {
                $res = $this->crud_model->add_counselling_session();

                if ($res) {
                    $this->session->set_flashdata('flash_message', get_phrase('counselling_session_has_been_added_successfully'));

                } else {
                    $this->session->set_flashdata('flash_message', get_phrase('Error occurred, please try again'));

                }
            }


        } elseif ($action == 'edit') {
            // echo '<pre>';
            // print_r($_POST);
            // exit();
            $this->crud_model->edit_counselling_session_new($counselling_session_id);
            $this->session->set_flashdata('flash_message', get_phrase('counselling_session_has_been_updated_successfully'));
        } elseif ($action == 'delete') {
            $this->crud_model->delete_counselling_session($counselling_session_id);
            $this->session->set_flashdata('flash_message', get_phrase('counselling_session_has_been_deleted_successfully'));
        }

        redirect(site_url('admin/counselling_session'));
    }


    // Puhupwas Ends

    //Get Pending Payouts for live
    public function pending_payout_live_class($param1 = "")
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        check_permission('instructor');

        if ($param1 != "") {
            $page_data['month'] = $this->input->get('month');
            $page_data['year'] = $this->input->get('year');
        } else {
            $page_data['month'] = date('m');
            $page_data['year'] = date('Y');
        }

        $page_data['page_name'] = 'instructor_pending_payout_live';
        $page_data['page_title'] = get_phrase('instructor_pending_payout');

        $page_data['pending_counselling_payouts'] = $this->crud_model->get_pending_counselling_payouts($page_data['month'], $page_data['year'], "live");

        $this->load->view('backend/index', $page_data);
    }

    // INSTRUCTOR PAYOUT SECTION
    public function instructor_payout_live($param1 = "")
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(site_url('login'), 'refresh');

        check_permission('instructor');

        if ($param1 != "") {
            $page_data['month'] = $this->input->get('month');
            $page_data['year'] = $this->input->get('year');
        } else {
            $page_data['month'] = date('m');
            $page_data['year'] = date('Y');
        }

        $page_data['page_name'] = 'instructor_payout_live';
        $page_data['page_title'] = get_phrase('instructor_payout_live');
        $page_data['completed_counselling_payouts'] = $this->crud_model->get_completed_counselling_payouts($page_data['month'], $page_data['year'], "live");


        $this->load->view('backend/index', $page_data);
    }

    public function userSelectCourses($userId)
    {

        if ($this->session->userdata('admin_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        check_permission('student');

        $page_data['page_name'] = 'selectcourses';
        $page_data['page_title'] = 'Courses List';
        $page_data['courses'] = $this->crud_model->fetch_courses();
        $page_data['userId'] = $userId;
        $page_data['user'] = $this->user_model->get_user($limit = '', $offset = '', $search = '', $userId)->row();
        // print_r($this->user_model->get_user($limit = '', $offset = '', $search = '', $userId));exit;
        $this->load->view('backend/index', $page_data);

    }

    public function sendRazorpayInviteLink() {
        $courseId = base64_decode($_POST['courseId']);
        $userId = base64_decode($_POST['userId']);
        $userDetails = $this->user_model->get_user('','','',$userId)->row();
        $courseDetails = $this->crud_model->getCourseDetails($courseId);
        $name = $userDetails->first_name.' '.$userDetails->last_name;
        $email = $userDetails->email; //$userDetails->email
        $phone = $userDetails->phone; //$userDetails->phone;
        $price = $_POST['coursePrice']*100;
        $discountedPrice = $_POST['discountedPrice'];
        $referenceId = 'ES'.date('ymdhis');
        $courseTitle = $courseDetails->title;
        $callBackUrl = site_url('razorpay/callbackUrl'); //site_url('razorpay/callbackUrl');
        $expiredAt = strtotime("+24 hours");

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/payment_links/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"amount\": $price,\"currency\": \"INR\",\"expire_by\": $expiredAt,\n\"reference_id\": \"$referenceId\",\"description\": \"Purchase this course is $courseTitle\",\"customer\": {\"name\": \"$name\",\"contact\": \"+91$phone\",\"email\": \"$email\"},\"notify\": {\"sms\": true,\"email\": true},\"reminder_enable\": true,\"notes\": {\"course_name\": \"$courseTitle\"},\"callback_url\": \"$callBackUrl\",\"callback_method\": \"get\"}");

        curl_setopt($ch, CURLOPT_USERPWD, RAZOR_KEY_ID . ':' . RAZOR_KEY_SECRET);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $response = json_decode($result);

        $data = [
            'user_id' => $userId,
            'payment_type' => 'razorpay',
            'course_id' => $courseId,
            'course_type' => 'course',
            'amount' => $_POST['coursePrice']+$discountedPrice,
            'discounted_price' => $discountedPrice,
            'date_added' => strtotime(date('D, d-M-Y')),
            'month' => date('m'),
            'year' => date('Y'),
            'admin_revenue'=>$_POST['coursePrice'],
            'transaction_id'=>$response->id,
            'isPaid'=>0,
            'short_url'=> $response->short_url
        ];

        $res = $this->crud_model->createPaymentLink($data);
        if($res){
            $this->session->set_flashdata('flash_message', 'Amount Link Sent');
            redirect(site_url("admin/userSelectCourses/$userId"));
        }else{
            $this->session->set_flashdata('flash_message', 'Something went wrong, lease try again');
            redirect(site_url("admin/userSelectCourses/$userId"));
        }
    }

    public function checkEnrolledCourse($userId, $courseId){

        $this->load->model('NewApiModel');

        $response = $this->NewApiModel->isEnrolledtCourse($userId, $courseId);

        if($response){
            $detail = $this->crud_model->getCoursePurchaseDetails($userId,$courseId);
            $output['status'] = true;
            $detail->courseAddDate = date('d-m-Y',$detail->courseAddDate);
            $detail->courseExpiredDate = date('d-m-Y',$detail->courseExpiredDate);
            $output['data'] = $detail;
        }else{
            $output['status'] = false;
            $output['data'] = "";
        }

        echo json_encode($output);

    }
}
