<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->database();
        $this->load->library('session');
        // $this->load->library('stripe');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');

         $latestcourse = $this->crud_model->get_latest_10_course();
        $countrys = $this->crud_model->get_countries()->result();   
        $this->load->vars(compact('countrys','latestcourse'));

        // CHECK CUSTOM SESSION DATA
        // $this->session_data();
    }

    public function login()
    {
        if ($this->session->userdata('admin_login')) {
            redirect(site_url('admin'), 'refresh');
        } elseif ($this->session->userdata('user_login')) {
            redirect(site_url('user'), 'refresh');
        } else {
            $this->load->library('facebook');
            $data['authURL'] =  $this->facebook->login_url(); 

            $this->load->config('google'); 
              // $this->load->helper('url');

       
                $client_id = $this->config->item('CLIENT_ID');

                $client_redirect_url = $this->config->item('CLIENT_REDIRECT_URL');
                // $this->config->item('CLIENT_REDIRECT_URL'); 
            


            $data['login_url'] = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode($client_redirect_url) . '&response_type=code&client_id=' . $client_id . '&access_type=online';

            $this->load->view('home/login',$data);
        }
    }

    public function privacyPolicy()
    {
        $this->load->view('home/privacy');
    }
    
    public function termsOfUse()
    {
        $this->load->view('home/terms_of_use');
    }

    // //index page
    // public function index() 
    // {    

    //     $this->load->model('Lyvyo_model', 'lyvyo_model');

    //     $data['categories'] = $this->lyvyo_model->get_categories()->result();
        
    //     $this->load->view('home/index',$data);
    // }

    // //faq
    // public function faq()
    // {
    //     $this->load->view('home/faq');
    // }

    //login
    

    //register as selection
    // public function register()
    // {
    //     if ($this->session->userdata('admin_login')) {
    //         redirect(site_url('admin'), 'refresh');
    //     }elseif ($this->session->userdata('user_login')) {
    //         redirect(site_url('user'), 'refresh');
    //     }else {
    //         $this->load->view('home/register');
    //     }
        
    // }

    //register as instructor
    // public function registerAsInstructor()
    // {   
    //     if ($this->session->userdata('admin_login')) {
    //         redirect(site_url('admin'), 'refresh');
    //     }elseif ($this->session->userdata('user_login')) {
    //         redirect(site_url('user'), 'refresh');
    //     }else {
    //        $this->load->model('Lyvyo_model', 'lyvyo_model');
    //        $data['countries'] = $this->lyvyo_model->get_countries()->result();
    //        $data['languages']  = $this->crud_model->get_all_languages();
    //        $this->load->library('facebook');

    //         $data['authURL'] =  $this->facebook->login_url(); 

    //          $this->load->config('google'); 
    //           // $this->load->helper('url');

       
    //             $client_id = $this->config->item('CLIENT_ID');

    //             $client_redirect_url = $this->config->item('CLIENT_REDIRECT_URL');
    //             // $this->config->item('CLIENT_REDIRECT_URL'); 
            


    //         $data['login_url'] = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode($client_redirect_url) . '&response_type=code&client_id=' . $client_id . '&access_type=online';
          
    //         $this->load->view('home/register_as_instructor',$data);
    //     }
        
    // }

    //register as student
    // public function registerAsLearner()
    // { 
    //     if ($this->session->userdata('admin_login')) {
    //         redirect(site_url('admin'), 'refresh');
    //     }elseif ($this->session->userdata('user_login')) {
    //         redirect(site_url('user'), 'refresh');
    //     }else {
    //         $this->load->model('Lyvyo_model', 'lyvyo_model');
    //        $data['countries'] = $this->lyvyo_model->get_countries()->result();

    //        $this->load->library('facebook');

    //         $data['authURL'] =  $this->facebook->login_url(); 

    //          $this->load->config('google'); 
    //           // $this->load->helper('url');

       
    //             $client_id = $this->config->item('CLIENT_ID');

    //             $client_redirect_url = $this->config->item('CLIENT_REDIRECT_URL');
    //             // $this->config->item('CLIENT_REDIRECT_URL'); 
            


    //         $data['login_url'] = 'https://accounts.google.com/o/oauth2/v2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode($client_redirect_url) . '&response_type=code&client_id=' . $client_id . '&access_type=online';
    //         $this->load->view('home/register_as_learner',$data);
    //     }  
        
    // }

    //Privacy
    

     //Privacy
    // public function aboutUs()
    // {
    //     $this->load->view('home/about-us');
    // }

    //faqs general 
    // public function faqsGeneral($type)
    // {
    //     $this->load->view('home/faqs_general',compact('type'));
    // }

    //terms of use

    //Guide Agreement
    // public function guideAgreement()
    // {
    //     $this->load->view('home/guide_agreement');
    // }

    //Instructor Agreement
    // public function instructorAgreement()
    // {
    //     $this->load->view('home/instructor_agreement');
    // }

    //Instructors
    // public function instructors($csat)
    // {

    //     $this->load->model('Lyvyo_model', 'lyvyo_model');
        
    //     $data['instructors'] = $this->lyvyo_model->getInstructorForCourseCategory($csat);
    //     $data['languages'] = $this->crud_model->get_all_languages();
    //     $data['coursescat'] = $this->lyvyo_model->getCourseCategoryWithParent();

    //     $this->load->view('home/instructors',$data);
    // }

    //self-improvement
    // public function selfImprovement()
    // {
    //     $this->load->view('home/self_improvement');
    // }

    //self-improvement
    // public function selfImprovementone()
    // {
    //     $this->load->view('home/self_improvementone');
    // }

    //self-improvement
    // public function fitness()
    // {
    //     $this->load->view('home/fitness');
    // }

    //fetch state by country
    // public function fetchStateByCountry($id)
    // {

    //     $this->load->model('Lyvyo_model', 'lyvyo_model');
    //        $sate = $this->lyvyo_model->get_state_by_country($id)->result();
    //        echo json_encode($sate);
    // }

    //Education 
    // public function educations()
    // {
    //      $this->load->model('Lyvyo_model', 'lyvyo_model');
            
            
    //         $data['primary'] = $this->lyvyo_model->getChildCategoryBySubCategoryId(5)->result();
    //         $data['secondary'] = $this->lyvyo_model->getChildCategoryBySubCategoryId(7)->result();
    //         $data['high'] = $this->lyvyo_model->getChildCategoryBySubCategoryId(6)->result();
    //         $data['university'] = $this->lyvyo_model->getChildCategoryBySubCategoryId(8)->result();
     
    //         $this->load->view('home/education',$data);
    // }

    //Education by subcategory
    // public function education($subid = null)
    // {

    
    //     $this->load->model('Lyvyo_model', 'lyvyo_model');
       
    //     $data['subcategory'] = $this->lyvyo_model->getSubcategoryByCategory($subid)->row();  
    //     $data['childcat'] = $this->lyvyo_model->getChildCategoryBySubCategoryId($subid)->result(); 


    //     $this->load->view('home/education-sub',$data);
    // }

    //Courses
    // public function courses()
    // {
    //     $data['top_courses'] = $this->crud_model->get_top_courses()->result_array();
    //     $data['latest'] = $this->crud_model->get_latest_10_course();

    //     $this->load->view('home/course',$data);
    // }

    //fetch instructor by filter
    // public function fetchInstructorByFilter()
    // {

    //     $this->load->model('Lyvyo_model', 'lyvyo_model');

    //     $data = [];

    //     // echo json_encode($_POST);
    //     // exit;

    //     if(!empty($this->input->post('cscat')))
    //     {
    //         $data['cscat'] = $this->input->post('cscat');
    //     }

    //     if(!empty($this->input->post('langauge')))
    //     {
           
    //         $data['langauge'] = $this->input->post('langauge');
    //     }

    //      if(!empty($this->input->post('minprice')))
    //     {
    //         $data['minprice'] = $this->input->post('minprice');
    //     }

    //     if(!empty($this->input->post('maxprice')))
    //     {
    //         $data['maxprice'] = $this->input->post('maxprice');
    //     }
    //     if(!empty($this->input->post('sortby')))
    //     {

    //         $data['sortby'] = $this->input->post('sortby');
    //     }

    //     $instructors = $this->lyvyo_model->getInstructorForCourseCategorys($data);
       

    //     if($instructors)
    //     {
    //         $data = [];
    //         foreach($instructors as $key => $val){

    //             $item['instructor'] = $val;
                
    //             $item['instructor']->language = ucfirst($val->language);
                      
    //             $item['courses'] = fetchCourses($val->id);
    //             $item['skills'] = $this->lyvyo_model->fetchInstuctorSkills($val->instructor_skills);


                

    //             array_push($data,$item);

    //         }

    //         echo json_encode($data);
    //         exit;
    //     }
        
    //     echo json_encode($instructors);
    //     exit;
    // }

    //submit newsletter subscription

//     public function submitNewsletterSubcription()
//     {
      
//         $this->form_validation->set_rules('email','Email','trim|required');

//         if($this->form_validation->run() == false)
//         {
//             $output['status'] = false;
//             $output['msg'] = "Email is required";
            
//         }
//         else
//         {
//             $this->load->model('Lyvyo_model', 'lyvyo_model');
//             $check = $this->lyvyo_model->checkSubscribedOrNot($this->input->post('email',true));

//             if($check)
//             {
//                 $res = $this->lyvyo_model->insertSubscribeNewsletter();

//                 if($res)
//                 {
//                     $output['status'] = true;
//                     $output['msg'] = "Subscribed Successfully";

//                     $newsletterDetails = $this->lyvyo_model->getnewsletterDetails()->row();

//                     $countCourse = json_decode($newsletterDetails->newsletter_courses);

//                     $courses = [];

//                     for($i = 0; $i < count($countCourse); $i++)
//                     {
//                         $course = $this->lyvyo_model->getCourseDetailById($countCourse[$i]);

//                         array_push($courses, $course);


//                     }

//                    $content = "<!DOCTYPE html> <html><style>
//     html {
//         width:100%
//     }
//     ::-moz-selection {
//     background:#fd4326;
//     color:#fff;
//     text-shadow:1px 1px 0 #f22b0e
//     }
//     ::selection {
//     background:#fd4326;
//     color:#fff;
//     text-shadow:1px 1px 0 #f22b0e
//     }
//     body {
//         background-color:#fff;
//         margin:0;
//         padding:0
//     }
//     .ReadMsgBody {
//         width:100%;
//         background-color:#fff
//     }
//     .ExternalClass {
//         width:100%;
//         background-color:#fff
//     }
//     a {
//         color:#fd4326;
//         text-decoration:none;
//         font-weight:400;
//         font-style:normal
//     }
//     a:hover {
//         color:#262626;
//         text-decoration:none;
//         font-weight:400;
//         font-style:normal
//     }
//     p, div {
//         margin:0!important
//     }
//     table {
//         border-collapse:collapse
//     }
//     @media only screen and (max-width:640px) {
//     body {
//     width:auto!important
//     }
//     table table {
//     width:100%!important
//     }
//     td[class=full_width] {
//     width:100%!important
//     }
//     td[class=spacer] {
//     width:30px!important
//     }
//     td[class=spacer_spec] {
//     display:none!important
//     }
//     div[class=div_scale] {
//     width:440px!important;
//     margin:0 auto!important
//     }
//     table[class=table_scale] {
//     width:440px!important;
//     margin:0 auto!important
//     }
//     td[class=td_scale] {
//     width:440px!important;
//     margin:0 auto!important
//     }
//     img[class=img_scale] {
//     width:100%!important;
//     height:auto!important
//     }
//     img[class=divider] {
//     width:100%!important;
//     height:2px!important
//     }
//     td[class=divider] {
//     width:100%!important;
//     display:block!important;
//     float:left;
//     text-align:inherit!important
//     }
//     }
//     @media only screen and (max-width:479px) {
//     body {
//     width:auto!important
//     }
//     table table {
//     width:100%!important
//     }
//     td[class=full_width] {
//     width:100%!important
//     }
//     div[class=div_scale] {
//     width:280px!important;
//     margin:0 auto!important
//     }
//     table[class=table_scale] {
//     width:280px!important;
//     margin:0 auto!important
//     }
//     td[class=td_scale] {
//     width:280px!important;
//     margin:0 auto!important
//     }
//     img[class=img_scale] {
//     width:100%!important;
//     height:auto!important
//     }
//     img[class=divider] {
//     width:100%!important;
//     height:2px!important
//     }
//     td[class=spacer] {
//     display:none!important
//     }
//     td[class=spacer_spec] {
//     display:none!important
//     }
//     td[class=divider] {
//     width:100%!important;
//     display:block!important;
//     float:left;
//     text-align:inherit!important
//     }
//     td[class=center] {
//     text-align:center!important
//     }
//     td[class=subject_line] {
//     float:left;
//     width:240px;
//     display:block!important;
//     text-align:left!important;
//     padding:15px 20px!important
//     }
//     td[class=contact] {
//     float:left;
//     width:240px;
//     display:block!important;
//     text-align:left!important;
//     padding:0 20px 15px!important;
//     padding-bottom:20px!important
//     }
//     td[class=social_left] {
//     float:left;
//     width:240px;
//     display:block!important;
//     text-align:center!important;
//     padding:20px 20px 0!important
//     }
//     td[class=social_right] {
//     float:left;
//     width:240px;
//     display:block!important;
//     text-align:center!important;
//     padding:0 20px!important
//     }
//     td[class=one_one] {
//     width:240px!important;
//     display:block!important;
//     float:left;
//     padding-left:20px!important;
//     padding-right:20px!important;
//     text-align:inherit!important
//     }
//     td[class=one_half] {
//     width:240px!important;
//     padding-bottom:0!important;
//     display:block!important;
//     float:left;
//     padding-left:20px!important;
//     text-align:inherit!important
//     }
//     td[class=one_half_last] {
//     width:240px!important;
//     margin-top:40px!important;
//     display:block!important;
//     float:left;
//     padding-left:20px!important;
//     text-align:inherit!important;
//     padding-top:0!important
//     }
//     td[class=one_third_fed] {
//     width:240px!important;
//     display:block!important;
//     float:left;
//     padding-left:20px!important;
//     text-align:inherit!important
//     }
//     td[class=one_third_fed_sec] {
//     width:240px!important;
//     margin-top:20px!important;
//     display:block!important;
//     float:left;
//     padding-left:20px!important;
//     text-align:inherit!important
//     }
//     td[class=one_third_fed_last] {
//     width:240px!important;
//     margin-top:20px!important;
//     display:block!important;
//     float:left;
//     padding-left:20px!important;
//     text-align:inherit!important
//     }
//     td[class=one_third] {
//     width:240px!important;
//     display:block!important;
//     float:left;
//     padding-left:20px!important;
//     text-align:inherit!important
//     }
//     td[class=one_third_sec] {
//     width:240px!important;
//     margin-top:40px!important;
//     display:block!important;
//     float:left;
//     padding-left:20px!important;
//     text-align:inherit!important
//     }
//     td[class=two_third_last] {
//     width:240px!important;
//     margin-top:40px!important;
//     display:block!important;
//     float:left;
//     padding-left:20px!important;
//     text-align:inherit!important
//     }
//     td[class=two_third] {
//     width:240px!important;
//     display:block!important;
//     float:left;
//     margin-left:20px!important;
//     text-align:inherit!important
//     }
//     td[class=one_third_last] {
//     width:240px!important;
//     margin-top:40px!important;
//     display:block!important;
//     float:left;
//     margin-left:20px!important;
//     text-align:inherit!important
//     }
//     td[class=one_fourth] {
//     width:110px!important;
//     display:block!important;
//     float:left;
//     margin-left:20px!important;
//     text-align:inherit!important
//     }
//     td[class=one_fourth_last] {
//     width:110px!important;
//     margin-top:20px!important;
//     display:block!important;
//     float:left;
//     margin-left:20px!important;
//     text-align:inherit!important
//     }
//     }
// </style> <body><div class='row'>
//     <div class='col-md-12'>
        

//         <table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#d0d0d0' style='padding: 0; margin: 0;'>
//           <!-- START OF TOP BAR-->
//           <tr>
//             <td class='full_width' align='center' width='100%' bgcolor='#d0d0d0' style=''><div class='div_scale' style='width:600px;'>
//                 <table class='table_scale' width='600' HEIGHT='42' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#494949' style='padding:0; margin: 0;'>
//                   <tr>
//                     <td class='spacer' width='20' align='left' valign='top' bgcolor='#494949' style='margin: 0 !important; padding: 0 !important; line-height: 0 !important;'>&nbsp;</td>
//                     <!-- START OF SUBJECT LINE-->
//                     <td class='subject_line' align='left' valign='middle' width='270' bgcolor='#494949' style='padding-top: 10px; padding-bottom: 10px;'><table width='100%'>
//                         <tr>
//                           <td class='center' align='' valign='' style='font-family:Arial, sans-serif; font-style: italic; color:#d8d8d8; font-size:11px; line-height:18px;'>".$newsletterDetails->newsletter_website_name."</td>
//                         </tr>
//                       </table></td>
//                     <!-- END OF SUBJECT LINE-->
//                     <td class='spacer' width='20' align='left' valign='top' bgcolor='#494949' style='margin: 0 !important; padding: 0 !important; line-height: 0 !important;'>&nbsp;</td>
//                     <!-- START OF CONTACT-->
//                     <td class='contact' align='right' valign='middle' width='270' bgcolor='#494949' style='padding: 0px;'><table width='100%'>
//                         <tr>
//                           <td class='center' align='' valign='' style='text-align: right; font-family:Arial, sans-serif; font-style: italic; color:#d8d8d8; font-size:11px; line-height:100%;'><img src='https://i.imgur.com/RxR11qU.png?1' alt='email' width='20' height='11' style='display: inline; vertical-align: middle;' />".$newsletterDetails->newsletter_email." </td>
//                         </tr>
//                       </table></td>
//                     <!-- END OF CONTACT-->
//                     <td class='spacer' width='20' align='left' valign='top' bgcolor='#494949' style='margin: 0 !important; padding: 0 !important; line-height: 0 !important;'>&nbsp;</td>
//                   </tr>
//                 </table>
//               </div></td>
//           </tr>
//           <tr>
//             <td class='full_width' align='center' width='100%' bgcolor='#d0d0d0' style=''><div class='div_scale' style='width:600px;'>
//                 <table class='table_scale' width='600' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#f0f0f0' style='padding:0; margin: 0;'>
//                   <tr>
//                     <!-- START OF LEFT COLUMN-->
//                     <td class='td_scale' width='600' bgcolor='#fd4326' align='center' valign='top' style='padding: 0px; font-size:14px ; color:#959595; font-family: Arial,sans-serif; line-height: 24px; '><table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#fd4326' style='margin: 0;'>
//                         <!-- START OF BANNER-->
//                         <tr>

//                           <td class='center' align='center' valign='top' bgcolor='#fd4326' style='padding:0; font-size: 16px; line-height: 24px; font-family:Lucida Sans Unicode; color:#262626; margin: 0 !important;'><a href='#' style='font-style: normal;'> <img class='img_scale' src=".base_url($newsletterDetails->newsletter_image)." width='600' height='240' alt='featured banner' border='0' style='display: block;' /> </a></td>
//                         </tr>
//                         <!-- END OF BANNER-->
//                         <!-- START OF VERTICAL SPACER-->
//                         <tr>
//                           <td height='20' bgcolor='#f0f0f0' style='padding:0; line-height: 0;'>&nbsp;</td>
//                         </tr>
//                         <!-- END OF VERTICAL SPACER-->
//                         <!-- START OF HEADING TITLE-->
//                         <tr>
//                           <td class='center' align='center' valign='top' bgcolor='#f0f0f0' style='padding: 0px 20px;  text-shadow: 1px 1px 0px #ffffff;font-size:24px ; color:#444444; font-family: Lucida Sans Unicode; line-height: 34px; '>".$newsletterDetails->newsletter_title."</td>
//                         </tr>
//                         <!-- END OF HEADING TITLE-->
//                         <!-- START OF VERTICAL SPACER-->
//                         <tr>
//                           <td height='10' bgcolor='#f0f0f0' style='padding:0; line-height: 0;'>&nbsp;</td>
//                         </tr>
//                         <!-- END OF VERTICAL SPACER-->
//                         <!-- START OF TEXT-->
//                         <tr>
//                           <td class='center' align='center' valign='top' bgcolor='#f0f0f0' style='padding: 0px 20px;  text-shadow: 1px 1px 0px #ffffff;font-size:13px ; color:#727272; font-family: Arial,sans-serif; line-height: 23px; '>".$newsletterDetails->newsletter_description."<a href='#' style='color:#fd4326; font-weight: bold; text-decoration: none; font-style: normal;'></a></td>
//                         </tr>
//                         <!-- END OF TEXT-->
//                         <!-- START OF VERTICAL SPACER-->
//                         <tr>
//                           <td height='20' bgcolor='#f0f0f0' style='padding:0; line-height: 0;'>&nbsp;</td>
//                         </tr>
//                         <!-- END OF VERTICAL SPACER-->
//                       </table></td>
//           </tr>
//           <!-- END OF 3 COL FEATURED PRODUCT OR GALLERY-->
//           <!-- START OF 1/2 COL WITH IMAGE ON TOP-->
//           <tr>
//             <td class='full_width' align='center' width='100%' bgcolor='#d0d0d0' style=''><div class='div_scale' style='width:600px;'>
//                 <table class='table_scale' width='100%' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#f0f0f0' style='padding:0; margin: 0;'>
//                   <tr>
//                     <td class='spacer' width='20' align='left' valign='top' bgcolor='#f0f0f0' style='margin: 0 !important; padding: 0 !important; line-height: 0 !important;'>&nbsp;</td>
//                     <!-- START OF LEFT COLUMN-->";
//                      foreach($courses as $key => $val) {  
//                 $content .=   "<td class='one_half' align='left' valign='top' width='270' bgcolor='#f0f0f0' style=''><table width='100%'>
//                             <!-- START OF IMAGE-->
//                             <tr>
//                               <td valign='top' align='center' style='padding: 0px; font-size:13px ; color:#727272; font-family: Arial,sans-serif; line-height: 23px; '><a href='#' style='font-style: normal;'> <img class='img_scale' src=".$this->crud_model->get_course_thumbnail_url($val->id)." width='270' height='180' alt='image' border='0' style='display: block;' /> </a></td>
//                             </tr>
//                             <!-- END OF IMAGE-->
//                             <tr>
//                               <td height='12' bgcolor='#f0f0f0' style='padding:0; line-height: 0;'>&nbsp;</td>
//                             </tr>
//                             <!-- START OF HEADING-->
//                             <tr>
//                               <td valign='top' align='center' style='padding: 0px; text-shadow: 1px 1px 0px #ffffff;font-size:16px ; color:#262626; font-family: Lucida Sans Unicode; line-height: 26px; '><a href='#' style='font-weight: normal; color:#262626; text-decoration: none;'>".$val->title."</a></td>
//                             </tr>
//                             <!-- END OF HEADING-->
//                             <tr>
//                               <td height='10' bgcolor='#f0f0f0' style='padding:0; line-height: 0;'>&nbsp;</td>
//                             </tr>
//                             <!-- START OF TEXT-->
//                             <tr>
//                               <td valign='top' align='center'  style='padding: 0px; text-shadow: 1px 1px 0px #ffffff;font-size:13px ; color:#727272; font-family: Arial,sans-serif; line-height: 23px; '>".$val->short_description." </td>
//                             </tr>
//                             <!-- END OF TEXT-->
//                             <tr>
//                               <td height='20' bgcolor='#f0f0f0' style='padding:0; line-height: 0;'>&nbsp;</td>
//                             </tr>
//                             <!-- START OF BUTTON-->
//                             <tr>
//                               <td align='center' width='' valign='top' style=' padding: 0px; font-size:14px ; color:#ffffff; font-family: Arial,sans-serif; line-height: 24px;'><table border='0' width='' align='center' cellpadding='0' cellspacing='0' bgcolor='#fd4326' style='margin: 0;'>
//                                   <tr>
//                                     <td align='center' valign='middle' bgcolor='#ffffff' style='padding: 7px 15px; border:1px solid #d0d0d0; font-size: 13px; line-height: 18px; font-family: Arial,sans-serif; color:#ffffff; margin: 0 !important; '><a href=".base_url('home/course/'.rawurlencode(slugify($val->title)).'/'.$val->id)." style='font-weight: bold; color:#fd4326; text-decoration: none;'> Show </a></td>
//                                   </tr>
//                                 </table></td>
//                             </tr>
//                             <!-- END OF BUTTON-->
//                           </table></td>
//                         <!-- END OF LEFT COLUMN-->
//                         <td class='spacer' width='20' align='left' valign='top' bgcolor='#f0f0f0' style='margin: 0 !important; padding: 0 !important; line-height: 0 !important;'>&nbsp;</td>";
//                     }

//                    $content .= "<td class='spacer' width='20' align='left' valign='top' bgcolor='#f0f0f0' style='margin: 0 !important; padding: 0 !important; line-height: 0 !important;'>&nbsp;</td>
//                   </tr>
//                   <tr>
//                     <td height='20' bgcolor='#f0f0f0' style='padding:0; line-height: 0;'>&nbsp;</td>
//                   </tr>
//                 </table>
//               </div>

//               </td>
//           </tr>
//           <!-- END OF DIVIDER WITH HEADING-->
//           <!-- START OF FOOTER-->
//           <tr>
//             <td class='full_width' align='center' width='100%' bgcolor='#d0d0d0' style=''><div class='div_scale' style='width:600px;'>
//                 <table class='table_scale' width='' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#353535' style='padding:0; margin: 0;'>
//                   <tr>
//                     <td class='' align='center' valign='top' width='600' bgcolor='#353535' style=''><table align='center' width='100%'>
//                           <!-- START OF TEXT-->
//                         <tr>
//                           <td align='center' valign='top' style='border-top: 1px solid #2b2b2b; padding: 40px 20px; font-size:13px ; color:#bbbbbb; font-family: Arial,sans-serif; line-height: 23px; '>".$newsletterDetails->newsletter_footer_text."<br />
//                             <!-- <span style='color:#ffffff;'> <a href='https://www.mercadolivre.com.br/' style='color:#ffffff; font-style: normal; text-decoration: none; '> Course1 </a> &nbsp;|&nbsp;<a href='https://perfil.mercadolivre.com.br/AURORA+STORE' style='color:#ffffff; font-style: normal; text-decoration: none;'> Course2 </a> &nbsp;|&nbsp;<a href='https://www.mercadopago.com.br/' style='color:#ffffff; font-style: normal; text-decoration: none;'> Course3 </a> &nbsp;&nbsp;<a href='#' style='color:#ffffff; font-style: normal; text-decoration: none; '>  </a> </span> --></td>
//                         </tr>
//                         <!-- END OF TEXT-->
//                         <!-- START OF LOGO-->
//                         <tr>
//                           <td align='center' valign='top' style='border-top: 1px solid #484848; padding: 20px; font-size:13px ; color:#bbbbbb; font-family: Arial,sans-serif; line-height: 23px; '><a href='#' style='font-style: normal;'> <img src=".base_url('assets/home/img/vector/lyvyo-logo.svg')." width='200' height='60' alt='logo' border='0' style='display: inline-block;' /> </a></td>
//                         </tr>
//                         <!-- END OF LOGO-->
//                       </table></td>
//                   </tr>
//                 </table>
//               </div></td>
//           </tr>
//           <!-- END OF FOOTER-->
//           <!-- START OF VERTIXAL SPACER BLOCK-->
//           <tr>
//             <td class='full_width' align='center' width='100%' bgcolor='#d0d0d0' style=''><div class='div_scale' style='width:600px;'>
//                 <table class='table_scale' width='600' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#d0d0d0' style='padding:0; margin: 0;'>
//                   <tr>
//                     <td class='td_scale' width='600' height='40' bgcolor='#d0d0d0' align='center' valign='middle' style='height: 40px; padding: 0px; font-size:0 ; color:#686868; font-family: Arial,sans-serif; line-height: 0; '>&nbsp;</td>
//                   </tr>
//                 </table>
//               </div></td>
//           </tr>
//           <!-- END OF VERTIXAL SPACER BLOCK-->
//         </table>
//     </div>
// </div> </body> </html>";


//                     $post = [
//                 "htmlContent" => $content,
//                 "subject" => "Lyvyo Newsletter",
//                 "sender" => [
//                     "name"=> $newsletterDetails->newsletter_website_name,
//                     "email" => $newsletterDetails->newsletter_email
//                 ],
//                 "to" => [
//                     [
//                         "email" => $this->input->post('email')
//                     ]
//                 ],
//                 "replyTo" => [
//                     "name"=> "Lyvyo",
//                     "email" => "aryadeepak741@gmail.com"
//                 ]
//             ];

//             $curl = curl_init();

//             curl_setopt_array($curl, [
//                 CURLOPT_URL => 'https://api.sendinblue.com/v3/smtp/email',
//                 CURLOPT_RETURNTRANSFER => true,
//                 CURLOPT_ENCODING => '',
//                 CURLOPT_MAXREDIRS => 10,
//                 CURLOPT_TIMEOUT => 30,
//                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                 CURLOPT_CUSTOMREQUEST => 'POST',
//                 CURLOPT_POSTFIELDS => json_encode($post),
//                 CURLOPT_HTTPHEADER => [
//                     'Accept: application/json',
//                     'Content-Type: application/json',
//                     'api-key: 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'
//                 ],
//             ]);

//             $response = curl_exec($curl);
//             $err = curl_error($curl);

//             curl_close($curl);
                   
//                 }
//                 else
//                 {
//                     $output['status'] = false;
//                     $output['msg'] = "Error Occurred, please try again";

//                 }
 
//             }
//             else
//             {
//                 $output['status'] = false;
//                 $output['msg'] = "Already Subscribed";
//             }

//         }

//          echo json_encode($output);
//          exit;
//     }

//     //fetch cities by country id
//     public function fetchCitiesByCountry($country_id)
//     {



//         $this->load->model('Lyvyo_model','lyvyo_model');
//         $states = $this->lyvyo_model->fetchStates($country_id);


//         $state = [];

//         foreach($states as $key => $val)
//         {
//             array_push($state, $val->state_id);
//         }

       

//         $cities = $this->lyvyo_model->fetchCities($state);

        

//         echo json_encode($cities);


//     }

    



    
}
