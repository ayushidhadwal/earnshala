<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lyvyo_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }


    //fetch country
    public function get_countries() {

        $this->db->where('gcc_countries',1);
        $result = $this->db->get('countries');
        return $result;
    }

    //fetch state by country
    public function get_state_by_country($id)
    {
        $this->db->where('country_id',$id);
        $res = $this->db->get('states');
        return $res;
    }

    //get Instructor
    public function getInstructor()
    {
        $this->db->where('is_instructor',1);
        $this->db->where('status', 1);
        $result = $this->db->get('users');

        return $result;
    }

    //get Category
    public function get_categories()
    {
       
        $this->db->where('parent', 0);
        return $this->db->get('category');
    }

    //get education subcategory
    public function getSubcategoryByCategory($id)
    {
        $this->db->where('id',$id);
        $result = $this->db->get('category');

        return $result;
    }

    //get Subcategory By CategoryId
    public function getSubcategoryByCategoryId($id)
    {
        $this->db->where('parent',$id);
        $result = $this->db->get('category');

        return $result;
    }

    // get courses by sub-category
    public function getCoursesBySubCategory($id)
    {   
        $this->db->select('*');
        $this->db->from('course');
        $this->db->join('category','category.id = course.sub_category_id','inner');
        $this->db->where('course.sub_category_id',$id);
        $result = $this->db->get();

        return $result;
    }

    //get childcategory By Subcategory ID
    public function getChildCategoryBySubCategoryId($id)
    {
        $this->db->where('parent',$id);
        $result = $this->db->get('category');

        return $result;
    }

    //get subcategory id by category id
    // public function getSubCategoryByCategoryId($cat_id)
    // {
    //     $this->db->where('parent',$cat_id);
    //     $result = $this->db->get('category');

    //     return $result;
    // }

    //get instructors id by course subcategory and subcategory
    public function getInstructorForCourseCategory($csat)
    {  

        $response = $this->checkCategoryIsChildOrNot($csat);

       if($response){
        $this->db->where('child_category_id',$csat);
       }else{
        $this->db->where('sub_category_id',$csat);
       }

        $this->db->distinct();
        $this->db->select('user_id');
       
      
       
       $instructors = $this->db->get('course');
       $arr =[];
       foreach ($instructors->result() as $key => $val) {
           
           array_push($arr, $val->user_id);
       }


       if(!empty($arr))
       {

              $result = $this->getInstructorByCourse($arr);
              return $result->result();
       }
       else
       {
             return false;
       }
     
    } 

    //get instructor details by ids
    public function getInstructorByCourse($instructor)
    {
        $this->db->where_in('id',$instructor);
        return $this->db->get('users');
    }

    //get course category with parent
    public function getCourseCategoryWithParent()
    {
        // $this->db->where('parent !=',0);
        $result = $this->db->get('category');

        return $result->result();
    }


    //get instructors id by course subcategory and subcategory
    public function getInstructorForCourseCategorys($data)
    {  

         if(!empty($data['cscat']))
       {

            $response = $this->checkCategoryIsChildOrNot($data['cscat']);

            if($response)
            {
                $this->db->where('child_category_id',$data['cscat']);
            }
            else
            {
                $this->db->where('sub_category_id',$data['cscat']);
            }
            
            
       }

        $this->db->distinct();
       $this->db->select('user_id'); 



       if(!empty($data['langauge']))
       {

            $this->db->where('language',$data['langauge']);
       }


       if(!empty($data['minprice']))
       {
            $this->db->where('price >=',(float)$data['minprice']);
       }

       if(!empty($data['maxprice']))
       {
            $this->db->where('price <=',(float)$data['maxprice']);
       }
       

       if(!empty($data['sortby']))
       {
          if($data['sortby'] == "asc" || $data['sortby'] == "desc")
          {
           
                $this->db->order_by('price',$data['sortby']);
          }
            
       }
       
        // $this->db->where('price >=',(float)$data['minprice']);
        // $this->db->where('price <=',(float)$data['maxprice']);
        // $this->db->where('child_category_id',$data['cscat']);
       
     
       $instructors = $this->db->get('course');

    
       $arr =[];
       foreach ($instructors->result() as $key => $val) {
           
           array_push($arr, $val->user_id);
       }

       if(!empty($arr))
       {
              $result = $this->getInstructorByCourses($arr);
              return $result;
       }
       else
       {
             return false;
       }
     
    } 

    //get instructor details by ids
    public function getInstructorByCourses($instructor)
    {
        $data = [];
        for($i = 0;$i < count($instructor);$i++)
        {
            $this->db->where('id',$instructor[$i]);
            array_push($data, $this->db->get('users')->row());
        }

        return $data;

        // $this->db->where_in('id',$instructor);

       
        // return $this->db->get('users');
    }

    //get category id detail 
    public function checkCategoryIsChildOrNot($cat)
    {   


        $this->db->where('id',$cat);
        $res = $this->db->get('category')->row('childcategory');

       

        if($res == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //Social login
    function Is_already_register($id)
     {
      $this->db->where('login_oauth_uid', $id);
      $query = $this->db->get('users');
      if($query->num_rows() > 0)
      {
       return true;
      }
      else
      {
       return false;
      }
     }

     function Update_user_data($data, $id)
     {
      $this->db->where('login_oauth_uid', $id);
      $this->db->update('users', $data);
     }

     function Insert_user_data($data)
     {
      $this->db->insert('users', $data);

      return $this->db->insert_id();
     }

      function getUserDetailByOauth($id)
     {
        $this->db->select('id, role_id, is_instructor');
      $this->db->where('login_oauth_uid', $id);
      $query = $this->db->get('users');
      if($query->num_rows() > 0)
      {
       return $query->row();
      }
      else
      {
       return false;
      }
     }

     // dev code

     public function getAllCourses() {
      $this->db->select('*');
      $this->db->from('course');
      $result = $this->db->get();
      return $result;
     }

     public function getnewsletterDetails() {
      $this->db->select('*');
      $this->db->from('newsletter');
     
      $result = $this->db->get();
      return $result;
     }

     //check whether requested email subscribed or not for newsletter
     public function checkSubscribedOrNot($email)
     {
        $this->db->where('sn_email',$email);
        $get = $this->db->get('subscribe_newsletter');

        if($get->num_rows() > 0)
        {
            return false;
        }
        else
        {
            return true;
        }
     }


     //insert newsletter subscriber
     public function insertSubscribeNewsletter()
     {
        $this->db->set('sn_email',$this->input->post('email'));
        $this->db->insert('subscribe_newsletter');

        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
     }

     //update newsletter format
     public function updateNewsLetter()
     {
        $data['newsletter_website_name'] = html_escape($this->input->post('website_name'));
        $data['newsletter_email'] = html_escape($this->input->post('email'));
        $data['newsletter_title'] = html_escape($this->input->post('email_title'));
        $data['newsletter_description'] = $this->input->post('email_description',true);
        $data['newsletter_courses'] = json_encode($this->input->post('select_courses'));
        $data['newsletter_footer_text'] = html_escape($this->input->post('footer_text'));

        

         if (!file_exists('uploads/newsletter/')) {
                    mkdir('uploads/newsletter/', 0777, true);
                }

        if ($_FILES['banner_image']['name'] != "") {

                    $data['newsletter_image'] = "uploads/newsletter/".md5(rand(10000000, 20000000)) . '.jpg';
                    move_uploaded_file($_FILES['banner_image']['tmp_name'], $data['newsletter_image']);
          }

        $this->db->update('newsletter',$data);

        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
     }

     //get course detail by ID
     public function getCourseDetailById($id)
     {
        $this->db->where('id', $id);
        $res = $this->db->get('course');

        return $res->row();

     }

     //insert register user data and return id
     public function insert_register_user($data)
     {
        $this->db->insert('register_user',$data);

        if($this->db->affected_rows() > 0)
        {
          return $this->db->insert_id();
        }
        else
        {
          return false;
        }
     }

     //get register data
     public function getRegisterData($id)
     {
        $this->db->where('id',$id);
        $res = $this->db->get('register_user');

        return $res->row();
     }

     //update register user OTP
     public function updateRegisterUserOtp($id, $otp)
     {  
        $this->db->set('otp',$otp);
        $this->db->where('id',$id);
        $this->db->update('register_user');


     }

     //fetch states id by country id
     public function fetchStates($country_id)
     {
        $this->db->select('state_id');
        $this->db->where('country_id',$country_id);
        $data = $this->db->get('states');

        return $data->result();
     }

     //fetch cities by states id
     public function fetchCities($states)
     {
        $this->db->where_in('state_id',$states);
        $res = $this->db->get('cities');

        return $res->result();

     }

     //get parent categories
     public function fetchParentCategories()
     {
        $this->db->where('parent',0);
        $result = $this->db->get('category');

        return $result->result();
     }

     //fetch sub child category
     public function fetchSubChildCategory($categoryId)
     {

        $this->db->where('parent',$categoryId);
        $res = $this->db->get('category');



        if($res->num_rows() > 0)
        {
            $data = $this->checkChildCategoryData($res->result());

            if(count($data) > 0)
            {
              $result['status'] = 100;
              $result['data'] = $data;
              return $result;
            }
            else
            {
              $result['status'] = 200;
              $result['data'] = $res->result();;
              return $result;
              
            }

        }
     }


     // if child category data exist than return 
     public function checkChildCategoryData($subcat)
     {

        $arr = [];
        foreach($subcat as $key => $sub)
        {
            $this->db->select('category.name as subcat, child_category.*');
            $this->db->from('child_category');
            $this->db->join('category','category.id = child_category.parent','inner');
            $this->db->where('child_category.parent',$sub->id);
            $child = $this->db->get();

            if($child->num_rows() > 0)
            {
              
                foreach($child->result() as $val)
                {
                     array_push($arr, $val);
                }
               
            }   
            
        }

        return $arr;


     }

     //fetch instructors skills
     public function fetchInstuctorSkills($skills)
     {
        $iskills = explode('-',$skills);

        $this->db->where_in('id', $iskills);
        $res = $this->db->get('category');

        return $res->result();
     }

     //add blog
     public function add_blog()
     {
        $data['blog_title'] = html_escape($this->input->post('title'));
        $data['blog_author'] = html_escape($this->input->post('blogger_name'));
        $data['blog_short_desc'] = html_escape($this->input->post('shortdesc'));
        $data['blog_description'] = $this->input->post('description',true);
        
        if (!file_exists('uploads/blog/')) {
                    mkdir('uploads/blog/', 0777, true);
                }

        if ($_FILES['image']['name'] != "") {

                    $data['blog_image'] = "uploads/blog/".md5(rand(10000000, 20000000)) . '.jpg';
                    move_uploaded_file($_FILES['image']['tmp_name'], $data['blog_image']);
          }

        $this->db->insert('blogs',$data);

        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
     }

     //fetch all blogs
     public function fetch_all_blogs()
     {
        $res = $this->db->get('blogs');

        return $res;
     }

     //fetch blog by id
     public function fetch_blog_by_Id($blog_id)
     {
        $this->db->where('blog_id',$blog_id);
        $res = $this->db->get('blogs');

        return $res;
     }

     //edit blog
     public function edit_blog()
     {
        $data['blog_title'] = html_escape($this->input->post('title'));
        $data['blog_author'] = html_escape($this->input->post('blogger_name'));
        $data['blog_short_desc'] = html_escape($this->input->post('shortdesc'));
        $data['blog_description'] = $this->input->post('description',true);
        
        if (!file_exists('uploads/blog/')) {
                    mkdir('uploads/blog/', 0777, true);
                }

        if ($_FILES['image']['name'] != "") {

                    $data['blog_image'] = "uploads/blog/".md5(rand(10000000, 20000000)) . '.jpg';
                    move_uploaded_file($_FILES['image']['tmp_name'], $data['blog_image']);

                    @unlink($this->input->post('oldimage'));
          }

        $this->db->where('blog_id',$this->input->post('blog_id'));
        $this->db->update('blogs',$data);

        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
     }

     //delete blog
     public function delete_blog()
     {
        $this->db->where('blog_id',$this->input->post('blog_id'));
        $this->db->delete('blogs');

        if($this->db->affected_rows() > 0)
        {
          return true;
        }
        else
        {
          return false;
        }
     }

     //add live class
     public function addLiveClassTime()
     {
        $this->db->set('instructor_id', $this->session->userdata('user_id'));
        $this->db->set('live_category', $this->input->post('parent_category'));
        $this->db->set('live_subcategory', $this->input->post('subcategory'));
        $this->db->set('live_date', $this->input->post('date'));
        // $this->db->set('live_start_time', $this->input->post('start_time')); 
        // $this->db->set('live_end_time', $this->input->post('end_time'));
        $this->db->set('live_time',json_encode($this->input->post('time')));

        $this->db->insert('live_class_time');

        if($this->db->affected_rows() > 0)
        {
          return true;
        }
        else
        {
          return false;
        }
     }

     //fetch live class list 
     public function fetchLiveClassListByInstructorId()
     {
        
        $this->db->where('instructor_id',$this->session->userdata('user_id'));
        $this->db->where('live_date >=',date('Y-m-d'));
        $this->db->order_by('live_date ASC, live_start_time DESC');
        $res = $this->db->get('live_class_time');

        return $res->result();

     }

     //time
     public function fetchTime()
     {
        $res = $this->db->get('time');
        return $res->result();
     }


}
