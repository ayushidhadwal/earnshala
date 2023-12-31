<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_user extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Crud_model');
        $this->load->model('NewApiModel');
        $this->load->library('session');
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

 private function sendResponse_forum_detail($status, $message = '', $data=[])
     {
         header('Content-Type: application/json');
         echo json_encode([
             'status' => $status,
             'data' => $data['forum_details'],
             'message' => $message
         ]);
         exit();
     }

 private function request($type, $url = '')
 {
     if($_SERVER['REQUEST_METHOD'] !== $type) {
         return $this->sendResponse(false, "Cannot " . $_SERVER['REQUEST_METHOD'] .' '. $url);
     }
     return true;
 }

 public function validate_login($from = "") {
  	 
  	  $this->request('POST', '/api_user/validate_login/');
  	  // $this->form_validation->set_rules('email','Email','trim|required|valid_email');
      $this->form_validation->set_rules('email','Email','trim|required');
  	  $this->form_validation->set_rules('password','Password','trim|required'); 
  	  

  	  if($this->form_validation->run() == false)
  	  { 
  	  	return $this->sendResponse(false, strip_tags(validation_errors()));
  	  } else {

      $email = $this->input->post('email');
      $password = $this->input->post('password');
      $credential_email = array('email' => $email, 'password' => sha1($password), 'status' => 1);
      $credential_phone = array('phone' => $email, 'password' => sha1($password), 'status' => 1);
      $query1 = $this->Api_user_model->login_check('users', $credential_email);
      $query2 = $this->Api_user_model->login_check('users', $credential_phone);
      if($query1->num_rows() > 0){
        $query = $query1;
      } else if($query2->num_rows() > 0){
        $query = $query2;
      }

      if (!empty($query)) {
        $this->session->set_userdata('user_id',$query->row('id'));
        $row = $query->row();
          if($row->role_id == 2) {
           	return $this->sendResponse(true, LOGIN_SUCCESS_MSG , [
          		'userId' => $query->row('id')
          	]);
          }
      } else {
       		return $this->sendResponse(false, LOGIN_FAILED_MSG);
      }

	  } // Something validation ends

  }



   public function register_user($from = "") {
    	 
    	  $this->request('POST', '/api_user/register_user/');
    	  $this->form_validation->set_rules('name','Name','trim|required');
    	  // $this->form_validation->set_rules('last_name','Last Name','trim|required');
    	  $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[users.email]');
          $this->form_validation->set_rules('phone','Phone','trim|required|is_unique[users.phone]|exact_length[10]');
          $this->form_validation->set_rules('password','Password','trim|required');
    	  // $this->form_validation->set_rules('phone','Mobile','trim|required|numeric|is_unique[users.phone]');
    	  $this->form_validation->set_rules('state','State','trim|required');
    	  

    	  if($this->form_validation->run() == false)
    	  { 
    	  	return $this->sendResponse(false, strip_tags(validation_errors()));
    	  } else {
            $state = $this->input->post('state');

           if(!is_numeric($state)){
             return $this->sendResponse(false,  STATE_NOT_EXIST );
             exit();
           }

           $phone = $this->input->post('phone');
           if(!is_numeric($phone)){
             return $this->sendResponse(false,  PHONE_MUST_NUMBER );
             exit();
           }

           $state_exist = $this->Api_user_model->check_id_exist('states',['state_id'=>$state]);

           if($state_exist->num_rows() === 0 ) {
                return $this->sendResponse(false,  STATE_NOT_EXIST );
                exit();
           }

    	  	$data = [
	        'first_name' => $this->input->post('name'),
	        // 'last_name'  => $this->input->post('last_name'),
	        'email'   => $this->input->post('email'),
            'password'   => sha1($this->input->post('password')),
	        'phone'   => $phone,
	        'state'   => $state,
	        'role_id' => 2,
	        'is_instructor' =>0,
	        'status' =>1
		    ];

        $query = $this->Api_user_model->register_user('users', $data);
        if($query){
             	return $this->sendResponse(true, REGISTER_SUCCESS_MSG , [
            		'userId' => $query
            	]);
        } else {
         		return $this->sendResponse(false, REGISTER_FAILED_MSG);
        }

  	  } // Something validation ends

    }

    public function get_user_profile($user_id = "") {
    	 
    	$this->request('GET', '/api_user/get_user_profile/');
    	   if(!is_numeric($user_id)){
             return $this->sendResponse(false,  USER_NONEXIST_ERROR );
             exit();
           }

           // $userId = $this->session->userdata('user_id');
          
        $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id]);

        if($user->num_rows() === 0 ) {
             return $this->sendResponse(false,  USER_NONEXIST_ERROR );
             exit();
        }

        // if($userId !== $user_id){
        //         return $this->sendResponse(false, USER_NOT_LOGIN );
        //         exit();
        // }   
       
    	$condition = array('id'=>$user_id,'role_id' => 2, 'is_instructor' => 0, 'status' => 1);  
        $query = $this->Api_user_model->get_user_profile('users', $condition);

        if($query->num_rows() > 0) {
          $row = $query->row();
             	return $this->sendResponse(true, SUCCESS_MSG , [
                    'user_profile' => $row
            	]);
        } else {
         		return $this->sendResponse(false, ERROR_MSG);
        }

    }   

    public function get_states() {
         
        $this->request('GET', '/api_user/get_states/');
          
        $query = $this->Api_user_model->get_states();

        if(count($query) > 0) {
                return $this->sendResponse(true, SUCCESS_MSG , [
                    'states' => $query,
                ]);
        } else {
                return $this->sendResponse(false, NO_STATE);
        }

    }
 

 	public function update_user_profile() {
 		 
 		$this->request('POST', '/api_user/update_user_profile/');
          

		 // $this->form_validation->set_rules('name','Name','trim');
     // $this->form_validation->set_rules('last_name','Last Name','trim');
     // $this->form_validation->set_rules('email','Email','trim|valid_email|is_unique[users.email]');
     // $this->form_validation->set_rules('phone','Mobile','trim|numeric|is_unique[users.phone]');
        $this->form_validation->set_rules('state','State','trim|required');
        $this->form_validation->set_rules('user_id','User ID','trim|required');

         if($this->form_validation->run() == false)
         { 
            return $this->sendResponse(false, strip_tags(validation_errors()));
         } else { 

        $user_id = $this->input->post('user_id');
            // $userId = $this->session->userdata('user_id');
             
         if(!is_numeric($user_id)){
           return $this->sendResponse(false,  USER_NONEXIST_ERROR );
           exit();
         }   
           
         $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id]);
         if($user->num_rows() === 0 ) {
              return $this->sendResponse(false,  USER_NONEXIST_ERROR );
              exit();
         }

         // if($userId !== $user_id){
         //         return $this->sendResponse(false, USER_NOT_LOGIN );
         //         exit();
         // }   

         $state = $this->input->post('state');

         if(!is_numeric($state)){
           return $this->sendResponse(false,  STATE_NOT_EXIST );
           exit();
         }

         $state_exist = $this->Api_user_model->check_id_exist('states',['state_id'=>$state]);

         if($state_exist->num_rows() === 0 ) {
              return $this->sendResponse(false,  STATE_NOT_EXIST );
              exit();
         }


	  	    $data = [];
	  	if(!empty($this->input->post('name'))):
	  		$data += ['first_name' => $this->input->post('name')];
        // array_push($data,['first_name' => $this->input->post('first_name')]);
		 endif;

	     // if(!empty($this->input->post('last_name'))):
         // $data += ['last_name' => $this->input->post('last_name')];
    	 // endif;


	     if(!empty($this->input->post('email'))):
            $data += ['email' => $this->input->post('email')];
                    
                $result = $this->Api_user_model->check_unique_user_email($user_id,'email', $this->input->post('email'));
                if($result > 0){
                    return $this->sendResponse(false, EMAIL_ALREADY);
                }
                
	  	 endif; 

         // if(!empty($this->input->post('password'))):
         //    $data += ['password' => sha1($this->input->post('password'))];
         // endif;

	     if(!empty($state)):
            $data += ['state' => $state];
	  	 endif;
         $phone = $this->input->post('phone');
	     if(!empty($phone)){

            if(!is_numeric($phone)){
              return $this->sendResponse(false,  PHONE_NOT_EXIST );
              exit();
            }

            if(strlen($phone) > 10 || strlen($phone) < 10 ){
              return $this->sendResponse(false,  PHONE_CHARACTOR_MAX );
              exit();
            }

            $data += ['phone' => $phone];
            $result2 = $this->Api_user_model->check_unique_user_email($user_id, 'phone',$phone);
            if($result2 > 0){
                return $this->sendResponse(false, PHONE_UNIQUE);
            }
            
	     }

	   // echo json_encode($data);
     // exit();
 		$user_id_condition = array('id'=>$this->input->post('user_id'));  

 	    $query = $this->Api_user_model->update_user_profile('users',$user_id_condition,$data);
 	   
 	    if($query) {
 	         	return $this->sendResponse(true, SUCCESS_UPDATED, [
                    'user_profile'=>$data
                ]);
 	    } else {
 	     		return $this->sendResponse(false, NO_UPDATE_MSG);
 	    }

        } // Validation Ends
 	}

       public function send_otp($from = "") {
             
              $this->request('POST', '/api_user/forget_password_send_otp/');
              $this->form_validation->set_rules('email','Email','trim|required|valid_email');
             
              if($this->form_validation->run() == false)
              { 
                  return $this->sendResponse(false, strip_tags(validation_errors()));
              } else {
                $data = [
                'email'   => $this->input->post('email'),
                'role_id' => 2,
                'is_instructor' => 0,
                'status' =>1
                ];
               
            $query = $this->Api_user_model->forget_password('users', $data);
            if($query->num_rows() > 0){
                         $otp = rand(100000,999999);
                         $otp_updated = $this->Api_user_model->update_table('users',['verification_code' => $otp], $data);  
                                if($otp_updated) {
                                     return $this->sendResponse(true, OTP_SENT_MSG,[
                                'user_id' => $query->row('id'),
                                'otp' => $otp
                            ]);   
                                }
                    
            } else {
                    return $this->sendResponse(false, EMAIL_INCORRECT);
            }

          } // Something validation ends

        } 

        public function verify_otp($from = "") {
             
              $this->request('POST', '/api_user/verify_otp/');
              
              if(!is_numeric($this->input->post('user_id'))){
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
              }

              $user = $this->Api_user_model->check_id_exist('users',['id'=>$this->input->post('user_id')]);
                 if($user->num_rows() === 0) {
                     return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                     exit();
                 } 

              $this->form_validation->set_rules('user_id','User Id','trim|required');
              $this->form_validation->set_rules('otp','OTP','trim|required');
             
              if($this->form_validation->run() == false)
              { 
                return $this->sendResponse(false, strip_tags(validation_errors()));
              } else {
                $data = [
                'id'   => $this->input->post('user_id'),
                'role_id' => 2,
                'is_instructor' => 0,
                'status' =>1
                ];
               
            $query = $this->Api_user_model->forget_password('users', $data);
            
            if($query->num_rows() > 0){
                    if(!empty($this->input->post('otp'))):
                        $data += ['verification_code' => $this->input->post('otp')];
                        $otpchecked = $this->Api_user_model->otp_check('users', $data);
                        if($otpchecked){
                            return $this->sendResponse(true, VERIFY_SUCCESS_MSG);
                        } else {
                            return $this->sendResponse(false, OTP_ERROR_MSG);    
                        }
                    else:
                          return $this->sendResponse(true, ENTER_OTP_MSG,[
                            'user_id' => $query->row('id')
                          ]);   
                    endif;
            } else {
                    return $this->sendResponse(false, USER_NONEXIST_ERROR);
            }

          } // Something validation ends

        } 


        public function new_password($from = "") {
             
              $this->request('POST', '/api_user/new_password/');
              if(!is_numeric($this->input->post('user_id'))){
                return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                exit();
              }
              $user = $this->Api_user_model->check_id_exist('users',['id'=>$this->input->post('user_id')]);
             if($user->num_rows() === 0) {
                 return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                 exit();
             }  

              $this->form_validation->set_rules('user_id','User Id','trim|required');
             
              if($this->form_validation->run() == false)
              { 
                return $this->sendResponse(false, strip_tags(validation_errors()));
              } else {
                $new_password = $this->input->post('new_password');
                $confirm_password = $this->input->post('confirm_password');

                $data = [
                'id'   => $this->input->post('user_id'),
                'role_id' => 2,
                'is_instructor' => 0,
                'status' => 1
                ];
               
            $query = $this->Api_user_model->forget_password('users', $data);

            if($query->num_rows() > 0){
                   if(!empty($new_password)){
                           if(!empty($confirm_password)){
                        if($new_password === $confirm_password){
                                    $new_password_updated = $this->Api_user_model->update_table('users',['password' => sha1($new_password)], $data); 
                                                   if($new_password_updated){
                                                       return $this->sendResponse(true, NEW_PASS_SUCCESS_MSG);
                                                   } else {
                                                       return $this->sendResponse(true, NO_CHANGES);
                                                   }

                                    } else {
                                       return $this->sendResponse(false, CONFIRM_PASS_ERR);
                                    }
                             } else {
                               return $this->sendResponse(true, CONFIRM_PASS_REQ);
                             }                      
                   } else {
                       return $this->sendResponse(true, ENTER_NEW_PASS);
                   }
            } else {
                    return $this->sendResponse(false, USER_NONEXIST_ERROR);
            }

          } // Something validation ends

        } 

       public function reset_password($from = "") {
             
              $this->request('POST', '/api_user/reset_password/');
              $this->form_validation->set_rules('user_id','User ID','trim|required');
              $this->form_validation->set_rules('otp','OTP','trim|required');
              // $this->form_validation->set_rules('new_password','New Password','trim');
              // $this->form_validation->set_rules('confirm_password','Confirm Password','trim|matches[new_password]');
             
              if($this->form_validation->run() == false)
              { 
                return $this->sendResponse(false, strip_tags(validation_errors()));
              } else {
                $otpInput = $this->input->post('otp');
                $new_password = $this->input->post('new_password');
                $confirm_password = $this->input->post('confirm_password');

                $data = [
                'id'   => $this->input->post('user_id'),
                'verification_code' => $otpInput,
                'role_id' => 2,
                'is_instructor' =>0,
                'status' =>1
                ];
               
            $otpchecked = $this->Api_user_model->otp_check('users', $data);
            if($otpchecked){
                 if(!empty($new_password)){
                            if(!empty($confirm_password)){
                         if($new_password === $confirm_password){
                                     $new_password_updated = $this->Api_user_model->update_table('users',['password' => sha1($new_password)], $data);  
                                                    if($new_password_updated){
                                                        return $this->sendResponse(true, NEW_PASS_SUCCESS_MSG);
                                                    } else {
                                                        return $this->sendResponse(true, NO_CHANGES);
                                                    }
                                     } else {
                                        return $this->sendResponse(false, CONFIRM_PASS_ERR);
                                     }
                              } else {
                                return $this->sendResponse(true, CONFIRM_PASS_REQ);
                              }                      
                    } else {
                        return $this->sendResponse(true, VERIFY_SUCCESS_MSG);
                    }
            } else {
                    return $this->sendResponse(false, OTP_ERROR_MSG);    
            }

          } // Something validation ends

        }
       


       public function change_password($from = "") {
             
              $this->request('POST', '/api_user/change_password/');
              
              $user = $this->Api_user_model->check_id_exist('users',['id'=>$this->input->post('user_id')]);
              if($user->num_rows() === 0) {
                  return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                  exit();
              }  
         
              $this->form_validation->set_rules('user_id','User ID','trim|required');
              $this->form_validation->set_rules('old_password','Old Password','trim|required');
              
             
              if($this->form_validation->run() == false)
              { 
                return $this->sendResponse(false, strip_tags(validation_errors()));
              } else {
                $old_password = $this->input->post('old_password');
                $new_password = $this->input->post('new_password');
                $confirm_password = $this->input->post('confirm_password');

                $data = [
                'id'   => $this->input->post('user_id'),
                'role_id' => 2,
                'is_instructor' =>0,
                'status' =>1
                ];
               
            $db_password = $this->Api_user_model->get_db_password('users', $data);
            // $password_verfiy = $this->Api_user_model->verify_password('users', $db_password, $old_password);
            // echo json_encode($old_password);
            // exit();
            if(sha1($old_password) === $db_password){
                 if(!empty($new_password)){
                            if(!empty($confirm_password)){
                         if($new_password === $confirm_password){
                                     $new_password_updated = $this->Api_user_model->update_table('users',['password' => sha1($new_password)], $data);  
                                                    if($new_password_updated) {
                                                        return $this->sendResponse(true, NEW_PASS_SUCCESS_MSG);
                                                    } else {
                                                        return $this->sendResponse(true, NO_CHANGES);
                                                    }
                                     } else {
                                        return $this->sendResponse(false, CONFIRM_PASS_ERR);
                                     }
                              } else {
                                return $this->sendResponse(true, CONFIRM_PASS_REQ);
                              }                      
                    } else {
                        return $this->sendResponse(true, OLD_PASS_VERIFIED);
                    }
            } else {
                    return $this->sendResponse(false, OLD_PASS_ERR);    
            }

          } // Something validation ends

        }

       
       public function insert_course_review()
       {
           $this->request('POST', '/api_user/insert_course_review/');

           $this->form_validation->set_rules('user_id','User ID','trim|required');
           $this->form_validation->set_rules('course_id','Course ID','trim|required');
           $this->form_validation->set_rules('starRating','Star Rating','trim|required');
           $this->form_validation->set_rules('review','Review','trim|required');
           
           
           if($this->form_validation->run() == false)
           { 
             return $this->sendResponse(false, strip_tags(validation_errors()));
           } else {
             $user_id = $this->input->post('user_id');
             $course_id = $this->input->post('course_id');
             $starRating = $this->input->post('starRating');
             $review = $this->input->post('review');

             $data['review'] = $review;
             $data['ratable_id'] = $course_id;
             $data['ratable_type'] = 'course';
             $data['rating'] = $starRating;
             $data['date_added'] = strtotime(date('D, d-M-Y'));
             $data['user_id'] = $user_id;

             if(!is_numeric($user_id)){
               return $this->sendResponse(false,  USER_NONEXIST_ERROR );
               exit();
             }
             if(!is_numeric($course_id)){
               return $this->sendResponse(false,  COURSE_NONEXIST_ERROR );
               exit();
             }

             if(!is_numeric($starRating)){
               return $this->sendResponse(false,  STAR_NUMBERIC_ERROR );
               exit();
             }

             $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id]);
             $course = $this->Api_user_model->check_id_exist('course',['id'=>$course_id]);

             if($user->num_rows() === 0) {
                 return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                 exit();
             }
             if($course->num_rows() === 0) {
                 return $this->sendResponse(false,  COURSE_NONEXIST_ERROR );
                 exit();
             }

             $query = $this->Api_user_model->rate($data);
           
             if($query === 'INSERTED') {
                      return $this->sendResponse(true, SUCCESS_REVIEW_INSERTED , [
                     ]);
             } elseif($query === 'INSERTED_FAILED') {
                      return $this->sendResponse(false, FAILED_REVIEW_INSERTED);
             } elseif($query === 'UPDATED'){
                      return $this->sendResponse(false, SUCCESS_REVIEW_UPDATED);
             } else {
                      return $this->sendResponse(false, FAILED_REVIEW_UPDATED);
             }
             
           }  

       }   


       public function get_my_review($user_id="",$course_id="")
       {
           $this->request('GET', '/api_user/get_my_review/');
           
             if(empty($user_id)){
                return $this->sendResponse(false,  USER_ID_REQUIRED );
                exit();
             }

             if(empty($course_id)){
                return $this->sendResponse(false,  COURSE_ID_REQUIRED );
                exit();
             }

             if(!is_numeric($user_id)){
               return $this->sendResponse(false,  USER_NONEXIST_ERROR );
               exit();
             }

             if(!is_numeric($course_id)){
               return $this->sendResponse(false,  COURSE_NONEXIST_ERROR );
               exit();
             }

             $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id]);
             $course = $this->Api_user_model->check_id_exist('course',['id'=>$course_id]);

             if($user->num_rows() === 0) {
                 return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                 exit();
             }
             if($course->num_rows() === 0) {
                 return $this->sendResponse(false,  COURSE_NONEXIST_ERROR );
                 exit();
             }

             $query = $this->Api_user_model->get_rate(['user_id'=>$user_id,'ratable_id'=>$course_id]);
             

             foreach ($query->result() as $key => $value) {
                 $value->date_added = date('d-M-Y h:i A',$value->date_added);
             }



            
            if($query->num_rows() > 0) {
                    return $this->sendResponse(true, SUCCESS_MSG , [
                        'reviews' => $query->result()
                        ]
                    );
            } else {
                    return $this->sendResponse(true, NO_REVIEW);
            }
             
        

       }   

        // public function get_free_courses($price_status = "", $instructor_id = "")
       public function get_free_and_paid_courses($price_status = "", $user_id="")
       {
           $this->request('GET', '/api_user/get_free_and_paid_courses/');

           if(!empty($user_id)){
               $user = $this->Api_user_model->check_id_exist('users',['id'=> $user_id]);
            if($user->num_rows() === 0){
                return $this->sendResponse(false,  USER_NONEXIST_ERROR);
                exit();
            }
               $query = $this->Api_user_model->get_free_and_paid_courses($price_status,['user_id'=>$user_id]);
           } else {
               $query = $this->Api_user_model->get_free_and_paid_courses($price_status);
           }

           $courses = $query->result(); 
           foreach ($courses as $key => $value) {
               $value->website_name = 'Earnshala';
                if($price_status === 'paid'){       
                    $value->course_price = (int) $value->course_price;
                 }
              
               $course_rating = $this->Api_user_model->get_course_review(['ratable_id'=>$value->course_id])->result();
              
                     if(count($course_rating) == 0){
                            $value->average_rating = 0; 
                            } else {
                                $total_rating = 0;
                                foreach ($course_rating  as $key2 => $value2) {
                                    $total_rating += $value2->rating;
                                }
                                $value->average_rating =  floor($total_rating/count($course_rating));
                    }
               // echo $value->course_thumbnail;
               // exit();
           }

           // echo '<pre>';
           // print_r($courses);
           // exit();

           if($query->num_rows() > 0) {
                   return $this->sendResponse(true, SUCCESS_MSG , [
                       !empty($user_id)?'my_'.$price_status.'_course':$price_status.'_course' => $courses
                   ]);
           } else {
                   return $this->sendResponse(false, NO_COURSE);
           }
       }



        public function get_free_and_paid_course_details($course_id = "")
        {
            $this->request('GET', '/api_user/get_free_and_paid_course_details/');

            if(!is_numeric($course_id)){
              return $this->sendResponse(false,  COURSE_NONEXIST_ERROR );
              exit();
            }    

            $course = $this->Api_user_model->check_id_exist('course',['id'=>$course_id]);

            if($course->num_rows() === 0) {
                return $this->sendResponse(false,  COURSE_NONEXIST_ERROR );
                exit();
            } 


            $query = $this->Api_user_model->get_free_and_paid_course_details($course_id);


            if($query->num_rows() > 0) {
              $courses = $query->result();
              // echo '<pre>';
              // print_r($courses[0]);
              // exit();

              // ecsh.gov.in
              $courses[0]->last_modified = date('d M Y' , strtotime($courses[0]->last_modified));

              $sections = $this->Api_user_model->get_section('course', $course_id)->result();
              $courses[0]->is_free_course = ($courses[0]->is_free_course == 1) ? 'free' : 'paid';
              $courses[0]->outcomes = json_decode($courses[0]->outcomes);
              $courses[0]->requirements = json_decode($courses[0]->requirements);
              $courses[0]->no_of_section = count($sections);

              $course_rating = $this->Api_user_model->get_course_review(['ratable_id'=>$course_id])->result();
              
                             if(count($course_rating) == 0){
              $courses[0]->average_rating = 0; 
                             } else {
                               $total_rating = 0;
                               foreach ($course_rating  as $key2 => $value2) {
                                   $total_rating += $value2->rating;
                                   $value2->date_added = date('d-M-Y h:i A', $value2->date_added);
                             }
              $courses[0]->average_rating  =  floor($total_rating/count($course_rating));
             
                           }  
              $review = array_slice($course_rating, 0, 3);               

              $courses[0]->review = $review;

              $sections = array_slice($sections, 0, 3);

              
              foreach ($sections  as $key => $section):
                // echo $key;
                 $lesson = $this->Api_user_model->get_course_lesson($section->id,$course_id)->result();
                 $section->lesson = $lesson;
            
              endforeach;
                
              $courses[0]->total_time_duration = $this->crud_model->get_total_duration_of_lesson_by_course_id($courses[0]->course_id);
              $courses[0]->no_of_lesson = $this->crud_model->get_lessons('course', $courses[0]->course_id)->num_rows();
              $courses[0]->section = $sections;
                    return $this->sendResponse(true, SUCCESS_MSG, [
                        // $price_status.'_course' => $courses
                        'course_detail' => $courses
                    ]);
            } else {
                    return $this->sendResponse(false, COURSE_NONEXIST_ERROR);
            }

        }


        public function get_more_section_of_course_detail($course_id = "")
        {
            $this->request('GET', '/api_user/get_more_section_of_course_detail/');
            if(!is_numeric($course_id)){
              return $this->sendResponse(false,  COURSE_NONEXIST_ERROR );
              exit();
            }    

            $course = $this->Api_user_model->check_id_exist('course',['id'=>$course_id]);

            if($course->num_rows() === 0) {
                return $this->sendResponse(false,  COURSE_NONEXIST_ERROR );
                exit();
            } 

            $sections = $this->Api_user_model->get_section('course', $course_id)->result();

            foreach ($sections  as $key => $section):
            // echo $key;
            
                 $lesson = $this->Api_user_model->get_course_lesson($section->id,$course_id)->result();
                 $section->lesson = $lesson;
        
            endforeach;
                
              $total_time_duration = $this->crud_model->get_total_duration_of_lesson_by_course_id($course_id);
              $no_of_lesson = $this->crud_model->get_lessons('course', $course_id)->num_rows();
              
            if(count($sections) > 0){
                    return $this->sendResponse(true, SUCCESS_MSG, [
                        // $price_status.'_course' => $courses
                        'more_section_of_course_detail' => $sections,
                        'total_time_duration'=>$total_time_duration,
                        'no_of_section' => count($sections),
                        'no_of_lesson' => $no_of_lesson,

                    ]);
            } else {
                    return $this->sendResponse(true, NO_SECTION);
            }



        }

        public function get_more_review_on_course_detail($course_id = "")
        {
            $this->request('GET', '/api_user/get_more_review_on_course_detail/');
            if(!is_numeric($course_id)){
              return $this->sendResponse(false,  COURSE_NONEXIST_ERROR );
              exit();
            }    

            $course = $this->Api_user_model->check_id_exist('course',['id'=>$course_id]);

            if($course->num_rows() === 0) {
                return $this->sendResponse(false,  COURSE_NONEXIST_ERROR );
                exit();
            } 

           $course_rating = $this->Api_user_model->get_course_review(['ratable_id'=>$course_id])->result();
                         
                        
                             
                        
                              if(count($course_rating) == 0){
                         $avarage_rating = 0; 
                                        } else {
                                          $total_rating = 0;
                                          foreach ($course_rating  as $key2 => $value2) {
                                              $total_rating += $value2->rating;
                                              $value2->date_added = date('d-M-Y h:i A', $value2->date_added);
                                          }
                        $avarage_rating  =  floor($total_rating/count($course_rating));
                                       }  

                          

                        
                
              
            if(count($course_rating) > 0){
                    return $this->sendResponse(true, SUCCESS_MSG, [
                        // $price_status.'_course' => $courses
                        'more_review_on_course_detail' => $course_rating,
                        'average_rating' => $avarage_rating
                    ]);
            } else {
                    return $this->sendResponse(true, NO_REVIEW);
            }



        }


        // Lesson id is Quiz id
        public function quiz_list()
        {
            $this->request('GET', '/api_user/quiz_list/');

            $query = $this->user_model->get_quiz_new();
            $quizes = $query->result();

            if($query->num_rows() > 0) {

                foreach ($quizes  as $key => $quiz):

                   $quiz->q_date_added = date('d M Y, h:i A',$quiz->q_date_added);
                
                endforeach;
                
                    return $this->sendResponse(true, SUCCESS_MSG, [
                        'quiz_list' => $quizes
                    ]);
            } else {
                    return $this->sendResponse(true, NO_QUIZ);
            }

        }


        public function quiz_questions_by_quizid($quiz_id)
        {
            $this->request('GET', '/api_user/quiz_questions_by_quizid/');

              if(!is_numeric($quiz_id)){
                 return $this->sendResponse(false,  QUIZ_NONEXIST_ERROR );
                 exit();
               }

              $quiz = $this->Api_user_model->check_id_exist('quiz',['q_id'=> $quiz_id]);
              if($quiz->num_rows() === 0){
                  return $this->sendResponse(true,  QUIZ_NONEXIST_ERROR);
                  exit();
              }  

              $question_option = $this->Api_user_model->get_quiz_questions($quiz_id)->result();

               if(count($question_option) > 0) { 

                  foreach($question_option as $key => $val)
                  {
                    
                    // for($i=1;$i<=4;$i++){
                    //     if(str_replace(['[',']','"'] , '' , $val->correct_answers) == $i){
                    //         $val->correct_answers = json_decode($val->options)[$i-1];
                    //     }
                    // }

                    $val->options = json_decode($val->options);
                  }


                    return $this->sendResponse(true, SUCCESS_MSG, [
                        'question' => $question_option
                    ]);
            } else {
                    return $this->sendResponse(true, NO_QUIZ_QUESTION);
            }

        }


        public function attemptedQuiz($from = "") {
                 
                  $this->request('POST', '/api_user/attemptedQuiz/');
                  $this->form_validation->set_rules('quiz_id','Quiz Id','trim|required');
                  $this->form_validation->set_rules('quiz_question[]','Quiz Questions','trim|required');
                  $this->form_validation->set_rules('choosen_answer[]','Choosen Answer','trim|required');
                  $this->form_validation->set_rules('user_id','User Id','trim|required');
                  
                
                  if($this->form_validation->run() == false)
                  { 
                    return $this->sendResponse(false, strip_tags(validation_errors()));
                  } else {

                    $user_id = $this->input->post('user_id');
                    $quiz_id = $this->input->post('quiz_id');
                    $quiz_question = $this->input->post('quiz_question[]');
                    $choosed_answer = $this->input->post('choosen_answer[]');


                    if(!is_numeric($user_id)){
                       return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                       exit();
                     }

                     if(!is_numeric($quiz_id)){
                       return $this->sendResponse(false,  QUIZ_NONEXIST_ERROR );
                       exit();
                     }

                    $user_id = $this->Api_user_model->check_id_exist('users',['id'=> $user_id]);
                    if($user_id->num_rows() === 0){
                        return $this->sendResponse(true,  USER_NONEXIST_ERROR);
                        exit();
                    } 

                    $quiz = $this->Api_user_model->check_id_exist('quiz',['q_id'=> $quiz_id]);
                    if($quiz->num_rows() === 0){
                        return $this->sendResponse(true,  QUIZ_NONEXIST_ERROR);
                        exit();
                    }  


                    foreach (json_decode($quiz_question) as $key => $qq) {
                        if(!is_numeric($qq)){
                             return $this->sendResponse(false,  QUIZ_QUESTION_NUMBERIC_ERROR );
                             exit();        
                        } else {

                            $question_exists = $this->Api_user_model->check_id_exist('question',['id'=> $qq,'quiz_id'=>$quiz_id]);
                            if($question_exists->num_rows() === 0){
                                return $this->sendResponse(true,  QUIZ_QUESTION_NONEXIST_ERROR.' '.$qq);
                                exit();
                            }
                        }
                    }

                    foreach (json_decode($choosed_answer) as $key => $ca) {
                        if(!is_numeric($ca)){
                             return $this->sendResponse(false,  ATTEMPED_ANSWER_NUMBERIC_ERROR );
                             exit();        
                        }
                    }
                    

                $correct_answers = $this->Api_user_model->check_correct_anser('question', $quiz_id, $quiz_question, $choosed_answer);
                // echo $correct_answers;
                // exit();
                $total_questions = count(json_decode($quiz_question));
                if(!empty($correct_answers)) {
                        // $quizs = $this->Api_user_model->insertQuizQuestionResult($quiz_id,$user_id,$correct_answers,$total_questions);
                        return $this->sendResponse(true, SUCCESS_MSG , [
                            'quesResult' => [
                                'total_correct_answers'=>$correct_answers,
                                'total_questions'=>$total_questions
                                ]
                        ]);
                } else {
                        return $this->sendResponse(false,  ERROR_MSG );
                }

              } // Something validation ends

            }


            public function insert_forum($from = "") {
                    
                  $this->request('POST', '/api_user/insert_forum/');
                  $this->form_validation->set_rules('user_id','User Id','trim|required');
                  $this->form_validation->set_rules('query_question','Quiz Questions','trim|required');
                  $this->form_validation->set_rules('query_brief','Quiz Brief','trim|required');
                  $this->form_validation->set_rules('add_tags','Add Tags','trim|required');
        
                  if($this->form_validation->run() == false)
                  { 
                    return $this->sendResponse(false, strip_tags(validation_errors()));
                  } else {

                    $data = [
                    'f_user_id' => $this->input->post('user_id'),
                    'f_query_question' => $this->input->post('query_question'),
                    'f_query_brief' => $this->input->post('query_brief'),
                    'f_add_tags' => $this->input->post('add_tags')
                   ];

                   if(!is_numeric($this->input->post('user_id'))){
                      return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                      exit();
                    }

                   $user = $this->Api_user_model->check_id_exist('users',['id'=>$data['f_user_id']]);
                    if($user->num_rows() === 0){
                        return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                        exit();
                    }

                // $condition1 = ['f_user_id'=>$data['f_user_id']];
                // $forum_ids = $this->Api_user_model->get_table_by_id('forum',$condition1,['f_id']);
                // $query2 = $forum_ids->result('array');
                    
                $query = $this->Api_user_model->insert_table('forum', $data);
               
                if($query) {
                        return $this->sendResponse(true, SUCCESS_INSERTED_FORUM , [
                            
                        ]);
                } else {
                        return $this->sendResponse(false,  ERROR_MSG );
                }

              } // Something validation ends
            }


            public function update_forum() {
                    
              $this->request('POST', '/api_user/update_forum/');

              $this->form_validation->set_rules('user_id','User Id','trim|required');
              $this->form_validation->set_rules('forum_id','Forum Id','trim|required');
              $this->form_validation->set_rules('query_question','Quiz Questions','trim|required');
              $this->form_validation->set_rules('query_brief','Quiz Brief','trim|required');
              $this->form_validation->set_rules('add_tags','Add Tags','trim|required');
            
                  if($this->form_validation->run() == false)
                  { 
                    return $this->sendResponse(false, strip_tags(validation_errors()));
                  } else {
                    if(!is_numeric($this->input->post('user_id'))){
                       return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                       exit();
                     }

                    if(!is_numeric($this->input->post('forum_id'))){
                       return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                       exit();
                     } 
                    $data = [
                    'f_query_question' => $this->input->post('query_question'),
                    'f_query_brief' => $this->input->post('query_brief'),
                    'f_add_tags' => $this->input->post('add_tags')
                   ];

                   $condition = [
                    'f_user_id' => $this->input->post('user_id'),
                    'f_id' => $this->input->post('forum_id')
                   ];

           $user = $this->Api_user_model->check_id_exist('users',['id'=>$condition['f_user_id']]);
           $forum = $this->Api_user_model->check_id_exist('forum',['f_id'=>$condition['f_id']]);

                    if($user->num_rows() === 0){
                        return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                        exit();
                    }
                    if($forum->num_rows() === 0){
                        return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                        exit();
                    } 

                    $query = $this->Api_user_model->update_table('forum',$data,$condition);
                // echo json_encode($query);
                // exit();
                if($query) {
                        return $this->sendResponse(true, SUCCESS_UPDATED,[
                            
                        ]);
                } else {
                        return $this->sendResponse(false,  NO_UPDATE_MSG );
                }

              } // Something validation ends
            }

           
       
            public function get_forum_list()
            {
                $this->request('GET', '/api_user/get_forum_list/');

                       // $forum_list = $this->Api_user_model->get_table('forum');
                $forum_list = $this->Api_user_model->get_table_by_id('forum',['f_status'=>1],['forum.f_id','forum.f_query_question','forum.f_query_brief','forum.f_created_date','users.first_name as user_name']);
                       
                if($forum_list->num_rows() > 0) { 
                        $forum_reply_by_id = $forum_list->result();

                        foreach ($forum_reply_by_id as $key => $value) {
                            $condition3 = [
                                'fr_forum_id'=> $value->f_id,
                            ];
                            $query3 = $this->Api_user_model->get_replies_on_reply_id('forum_reply',$condition3);
                            $forum_reply_by_id[$key]->no_of_replies = $query3->num_rows();
                            $forum_reply_by_id[$key]->f_created_date = date('d M Y, h:i A', strtotime($value->f_created_date));
                        }

                        return $this->sendResponse(true, SUCCESS_MSG, [
                            'forum_list' => $forum_reply_by_id
                        ]);
                       
                } else {
                        return $this->sendResponse(true, NO_FORUM);
                }

            }


            public function insert_forum_reply_by_id($from = "") {
                    
                  $this->request('POST', '/api_user/insert_forum_reply_by_id/');
                  $this->form_validation->set_rules('forum_id','Forum Id','trim|required');
                  $this->form_validation->set_rules('user_id','User Id','trim|required');
                  $this->form_validation->set_rules('forum_reply','Forum Reply','trim|required');
            
                  if($this->form_validation->run() == false)
                  { 
                    return $this->sendResponse(false, strip_tags(validation_errors()));
                  } else {
                    $data = [
                    'fr_forum_id' => $this->input->post('forum_id'),
                    'fr_user_id' => $this->input->post('user_id'),
                    'fr_reply' => $this->input->post('forum_reply')
                   ];

                   if(!is_numeric($data['fr_user_id'])){
                     return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                     exit();
                   }
                   
                   if(!is_numeric($data['fr_forum_id'])){
                     return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                     exit();
                   } 

           $forum = $this->Api_user_model->check_id_exist('forum',['f_id'=>$data['fr_forum_id']]);
           $user = $this->Api_user_model->check_id_exist('users',['id'=>$data['fr_user_id']]);
               

                           if($user->num_rows() === 0) {
                               return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                               exit();
                           }

                           if($forum->num_rows() === 0) {
                               return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                               exit();
                           }
                           

                $query = $this->Api_user_model->insert_table('forum_reply', $data);
                
                 $condition1 = ['fr_id'=> $query];
                
                $forum_ids = $this->Api_user_model->get_table_by_id('forum_reply' , $condition1,['fr_id' , 'fr_forum_id' , 'fr_forum_reply_id' , 'fr_user_id' , 'fr_reply' , 'fr_created_date'  , 'users.first_name' , 'users.last_name' , 'users.image']);
                
                $replyData = $forum_ids->row();
                
                $replyData->no_of_replies = 0;
                $replyData->replies = []; 

                //  $query2 = $this->Api_user_model->get_table_by_id('forum_reply',['fr_forum_id'=>$data['fr_forum_id'],'fr_forum_reply_id'=>null],['forum_reply.*' , 'users.first_name' , 'users.last_name' , 'users.image']);

                //       $forum_reply_by_id = $query2->result();

                //       foreach ($forum_reply_by_id as $key => $value) {
                           
                //             $condition3 = [
                //                 'fr_forum_id'=>$data['fr_forum_id'],
                //                 'fr_forum_reply_id' => $value->fr_id,
                //             ];
                            
                //             $query3 = $this->Api_user_model->get_replies_on_reply_id('forum_reply' , $condition3);
                            
                                                     
                //       }
                       
                

                if($query > 0) {
                        return $this->sendResponse(true, SUCCESS_MSG , [
                            
                        ]);
                } else {
                        return $this->sendResponse(false,  ERROR_MSG );
                }

              } // Something validation ends
            }

            public function update_forum_reply_by_id() {
                
              $this->request('POST', '/api_user/update_forum_reply_by_id/');
              $this->form_validation->set_rules('forum_reply_id','Forum Reply Id','trim|required');
              $this->form_validation->set_rules('forum_id','Forum Id','trim|required');
              $this->form_validation->set_rules('user_id','User Id','trim|required');
              $this->form_validation->set_rules('forum_reply','Forum Reply','trim|required');
            
                  if($this->form_validation->run() == false)
                  { 
                    return $this->sendResponse(false, strip_tags(validation_errors()));
                  } else {
                    $data = [
                    'fr_reply' => $this->input->post('forum_reply'),
                   ];

                   $condition = [
                    'fr_id' => $this->input->post('forum_reply_id'),
                    'fr_forum_id' => $this->input->post('forum_id'),
                    'fr_user_id' => $this->input->post('user_id')
                   ];

$forum = $this->Api_user_model->check_id_exist('forum',['f_id'=>$condition['fr_forum_id']]);
$forum_reply = $this->Api_user_model->check_id_exist('forum_reply',['fr_id'=>$condition['fr_id']]);
$user = $this->Api_user_model->check_id_exist('users',['id'=>$condition['fr_user_id']]);
               

                           if($forum->num_rows() === 0){
                               return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                               exit();
                           }

                           if($forum_reply->num_rows() === 0){
                               return $this->sendResponse(false,  FORUM_REPLY_NONEXIST_ERROR);
                               exit();
                           }
                          
                           if($user->num_rows() === 0){
                               return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                               exit();
                           }
                   
                    $query = $this->Api_user_model->update_table('forum_reply',$data,$condition);
                
                if($query) {
                        return $this->sendResponse(true, SUCCESS_UPDATED , [
                            'user_id' => $condition['fr_user_id']
                        ]);
                } else {
                        return $this->sendResponse(false,  NO_UPDATE_MSG );
                }

              } // Something validation ends
            }


            public function insert_reply_on_forum_reply_by_id($from = "") {
                    
              $this->request('POST', '/api_user/insert_reply_on_forum_reply_by_id/');
              $this->form_validation->set_rules('forum_id','Forum Id','trim|required');
              $this->form_validation->set_rules('forum_reply_id','Forum Reply Id','trim|required');
              $this->form_validation->set_rules('user_id','User Id','trim|required');
              $this->form_validation->set_rules('forum_reply_on_reply','Forum Reply','trim|required');
            
                  if($this->form_validation->run() == false)
                  { 
                    return $this->sendResponse(false, strip_tags(validation_errors()));
                  } else {
                    $data = [
                    'fr_forum_id' => $this->input->post('forum_id'),
                    'fr_forum_reply_id' => $this->input->post('forum_reply_id'),    
                    'fr_user_id' => $this->input->post('user_id'),
                    'fr_reply' => $this->input->post('forum_reply_on_reply'),
                   ];

                  if(!is_numeric($data['fr_user_id'])){
                    return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                    exit();
                  }
                  
                  if(!is_numeric($data['fr_forum_id'])){
                    return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                    exit();
                  } 
                  
                  if(!is_numeric($data['fr_forum_reply_id'])){
                    return $this->sendResponse(false,  FORUM_REPLY_NONEXIST_ERROR );
                    exit();
                  } 
 
                   
                $forum = $this->Api_user_model->check_id_exist('forum',['f_id'=>$data['fr_forum_id']]);
                $user = $this->Api_user_model->check_id_exist('users',['id'=>$data['fr_user_id']]);
                $forum_reply = $this->Api_user_model->check_id_exist('forum_reply',['fr_id'=>$data['fr_forum_reply_id']]);

                    if($forum->num_rows() === 0){
                        return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                        exit();
                    }
                    
                    if($forum_reply->num_rows() === 0){
                        return $this->sendResponse(false,  FORUM_REPLY_NONEXIST_ERROR );
                        exit();
                    }

                    if($user->num_rows() === 0) {
                        return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                        exit();
                    }
                   
                    
                
                    $query = $this->Api_user_model->insert_table('forum_reply', $data);
                
                // $condition1 = ['fr_id'=> $query];
                
                //   $forum_ids = $this->Api_user_model->get_table_by_id('forum_reply' , $condition1,['fr_id' , 'fr_forum_id' , 'fr_forum_reply_id' , 'fr_user_id' , 'fr_reply' , 'fr_created_date'  , 'users.first_name' , 'users.last_name' , 'users.image']);
                
                // $replyData = $forum_ids->row();
                
                if($query > 0) {
                        return $this->sendResponse(true, SUCCESS_MSG, [
                        ]);
                } else {
                        return $this->sendResponse(false,  ERROR_MSG );
                }


              } // Something validation ends
            }

            public function update_reply_on_forum_reply_by_id() {
                    
              $this->request('POST', '/api_user/update_reply_on_forum_reply_by_id/');
              $this->form_validation->set_rules('forum_reply_id','Forum Reply Id','trim|required');
              $this->form_validation->set_rules('forum_id','Forum Id','trim|required');
              $this->form_validation->set_rules('forum_reply_id','Forum Reply Id','trim|required');
              $this->form_validation->set_rules('user_id','User Id','trim|required');
              $this->form_validation->set_rules('forum_reply_on_reply','Forum Reply','trim|required');
            
                  if($this->form_validation->run() == false)
                  { 
                    return $this->sendResponse(false, strip_tags(validation_errors()));
                  } else {
                   $data = ['fr_reply' => $this->input->post('forum_reply_on_reply')];
                   $condition = [
                    'fr_id' => $this->input->post('forum_reply_id'),
                    'fr_forum_id' => $this->input->post('forum_id'),
                    'fr_forum_reply_id' => $this->input->post('forum_reply_id'),    
                    'fr_user_id' => $this->input->post('user_id')
                   ];
                   
                    $forum = $this->Api_user_model->check_id_exist('forum',['f_id'=>$condition['fr_forum_id']]);
                    $user = $this->Api_user_model->check_id_exist('users',['id'=>$condition['fr_user_id']]);
                    $forum_reply = $this->Api_user_model->check_id_exist('forum_reply',['fr_id'=>$condition['fr_forum_reply_id']]);

                    if($forum->num_rows() === 0){
                        return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                        exit();
                    }
                    
                    if($forum_reply->num_rows() === 0){
                        return $this->sendResponse(false,  FORUM_REPLY_NONEXIST_ERROR );
                        exit();
                    }

                    if($user->num_rows() === 0) {
                        return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                        exit();
                    }
                   
                    $query = $this->Api_user_model->update_table('forum_reply', $data, $condition);
                
                if($query) {
                        return $this->sendResponse(true, SUCCESS_UPDATED , [
                            'user_id' => $condition['fr_user_id']
                        ]);
                } else {
                        return $this->sendResponse(false,  NO_UPDATE_MSG );
                }

              } // Something validation ends
            }

            // //insert_question_detail_view by Forum_id
            // public function insert_question_detail_view($forum_id = "")
            // {
            //          $this->request('GET', '/api_user/insert_question_detail_view/');

            //          if(!is_numeric($forum_id)){
            //            return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
            //            exit();
            //          }

            //          $condition = [
            //           'f_id' => $forum_id,
            //          ];

            //          $views = $this->Api_user_model->get_forum_by_id('forum', $condition)->row('f_views');
                     
            //          $update_views = $this->Api_user_model->update_table('forum', ['f_views' => ++$views],$condition);

            //          if($update_views) {
            //                  return $this->sendResponse(true, SUCCESS_MSG , [
            //                      'status'=>true
            //                  ]);
            //          } else {
            //                  return $this->sendResponse(false,  ERROR_MSG );
            //          }
            // }    

                 
             

            //Get Forum Reply by Forum_id
            public function get_forum_reply($forum_id='')
            {
                     $this->request('GET', '/api_user/get_forum_reply/');
                     if(!is_numeric($forum_id)){
                       return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                       exit();
                     }
                   
                    $forum = $this->Api_user_model->check_id_exist('forum',['f_id'=>$forum_id]);
                     if($forum->num_rows() === 0){
                         return $this->sendResponse(false,  FORUM_NONEXIST_ERROR);
                         exit();
                     }

                    $query = $this->Api_user_model->get_table_by_id('forum' , ['f_id'=>$forum_id] , ['f_id as question_id','f_query_question as question','f_query_brief as question_description','f_add_tags as question_tags' , 'f_created_date as created_date_time','f_views as views' ]);

                    $forum_by_id = $query->row();

                    $query2 = $this->Api_user_model->get_table_by_id('forum_reply',['fr_forum_id'=>$forum_id,'fr_forum_reply_id'=>null],['forum_reply.fr_id as comment_id','forum_reply.fr_user_id as user_id','forum_reply.fr_reply as comment','forum_reply.fr_created_date as created_date_time' ,'users.first_name as user_name' , 'users.image as user_image']);



                    $forum_reply_by_id = $query2->result();

                    foreach ($forum_reply_by_id as $key => $value) {
                       
                            $condition3 = [
                                'fr_forum_id'=>$forum_id,
                                'fr_forum_reply_id' => $value->comment_id,
                            ];
                            
                            $query3 = $this->Api_user_model->get_replies_on_reply_id('forum_reply' , $condition3);
                            
                            $forum_reply_by_id[$key]->no_of_replies = $query3->num_rows();
                            $forum_reply_by_id[$key]->replies = $query3->result();
                            $forum_reply_by_id[$key]->user_image = $this->user_model->get_user_image_url_for_api($value->user_id);

                            foreach ($forum_reply_by_id[$key]->replies as $key2 => $value2) {
                                $value2->user_image = $this->user_model->get_user_image_url_for_api($value2->user_id);
                            }
                            

                    }

                       
                       $forum_by_id->created_date_time = date('d M Y h:i A', strtotime($forum_by_id->created_date_time));  

                       $update_views = $this->Api_user_model->update_table('forum', ['f_views' => ++$forum_by_id->views],['f_id'=>$forum_id]); 
                       // $forum_by_id->views = ++$forum_by_id->views;
                       
                       $forum_by_id->question_tags = explode(',' , $forum_by_id->question_tags);
                       $forum_by_id->no_of_replies = $query2->num_rows();
                       $forum_by_id->comments = $forum_reply_by_id;
                       

                if($query->num_rows() > 0) { 
                        return $this->sendResponse_forum_detail(true, SUCCESS_MSG, [
                            'forum_details' => $forum_by_id
                        ]);
                } else {
                        return $this->sendResponse_forum_detail(false, ERROR_MSG);
                }

            }


            // My Forum
            public function get_my_forum_list($user_id='')
            {
                $this->request('GET', '/api_user/get_my_forum_list/');
                if(!is_numeric($user_id)){
                  return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                  exit();
                }

                    $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id]);
                     if($user->num_rows() === 0) {
                        return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                        exit();
                    }
                    $forum_list = $this->Api_user_model->get_table_by_id('forum',['f_user_id'=>$user_id],['forum.f_id','forum.f_query_question','forum.f_query_brief','forum.f_created_date','users.first_name as user_name']);
                       
                   if($forum_list->num_rows() > 0) { 
                       $forum_reply_by_id = $forum_list->result();
                        foreach ($forum_reply_by_id as $key => $value) {
                            
                            $condition3 = [
                                'fr_forum_id'=> $value->f_id,
                            ];
                            $query3 = $this->Api_user_model->get_replies_on_reply_id('forum_reply',$condition3);
                    
                            $forum_reply_by_id[$key]->no_of_replies = $query3->num_rows();
                            $forum_reply_by_id[$key]->f_created_date = date('d M Y, h:i A', strtotime($value->f_created_date));
                                          
                       }

                        return $this->sendResponse(true, SUCCESS_MSG, [
                            'forum_list' => $forum_reply_by_id
                        ]);
                } else {
                        return $this->sendResponse(false, NO_FORUM);
                }

            }


            //Get Forum Reply by Forum_id and User_id
            public function get_my_forum_reply($user_id='',$forum_id='')
            {
                     $this->request('GET', '/api_user/get_my_forum_reply/');
                        $forum = $this->Api_user_modeldel->check_id_exist('forum',['f_id'=>$forum_id]);
                        $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id]);
                         
                         if($forum->num_rows() === 0){
                             return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                             exit();
                         }

                         if($user->num_rows() === 0) {
                             return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                             exit();
                         }

                       $condition1 = [
                                    'f_id'=>$forum_id,
                                    'f_user_id'=>$user_id
                                    ];
                       $query = $this->Api_user_model->get_table_by_id('forum',$condition1,['f_id','f_user_id','f_query_question','f_query_brief','f_add_tags']);

                       $forum_by_id = $query->result();
                       $condition2 = [
                        'fr_forum_id'=>$forum_id,
                        'fr_forum_reply_id'=>null,
                        'fr_user_id'=>$user_id
                        ];

                       $query2 = $this->Api_user_model->get_table_by_id('forum_reply',$condition2,['forum_reply.*']);

                       $forum_reply_by_id = $query2->result();

                       foreach ($forum_reply_by_id as $key => $value) {
                            $condition3 = [
                                'fr_forum_id' => $forum_id,
                                'fr_forum_reply_id' => $value->fr_id,
                                'fr_user_id' => $user_id
                            ];

                            $query3 = $this->Api_user_model->get_replies_on_reply_id('forum_reply',$condition3);
                            $value->no_of_replies = $query3->num_rows();
                            $value->replies = $query3->result();                           
                       }

                       $forum_by_id[0]->no_of_replies = $query2->num_rows();
                       $forum_by_id[0]->replies = $forum_reply_by_id;

                if($query->num_rows() > 0) { 
                        return $this->sendResponse(true, SUCCESS_MSG, [
                            'my_forum_replies' => $forum_by_id
                        ]);
                } else {
                        return $this->sendResponse(false, ERROR_MSG);
                }

            }



            // Delete My Forum
            public function delete_my_forum_list($user_id='',$forum_id='')
            {
                $this->request('GET', '/api_user/delete_my_forum_list/');
                 
                if(!is_numeric($user_id)){
                  return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                  exit();
                }
                
                if(!is_numeric($forum_id)){
                  return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                  exit();
                }    


                $forum = $this->Api_user_model->check_id_exist('forum',['f_id'=>$forum_id]);
                $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id]);

                 if($user->num_rows() === 0) {
                     return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                     exit();
                 }   

                 if($forum->num_rows() === 0){
                     return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                     exit();
                 }

                
                 
                $deleteMyForum = $this->Api_user_model->delete_table_where('forum',['f_user_id'=>$user_id,'f_id'=>$forum_id]);

                if($deleteMyForum) { 
                    return $this->sendResponse(true, SUCCESS_DELETED_FORUM);
                } else {
                    return $this->sendResponse(false, ERROR_MSG);
                }

            }
            
              // Delete My Forum
            public function details_my_forum_id($user_id='',$forum_id='')
            {
                $this->request('GET', '/api_user/details_my_forum_id/');
                  
                $forum = $this->Api_user_model->check_id_exist('forum',['f_id'=>$forum_id]);
                $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id]);

                 if($user->num_rows() === 0) {
                     return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                     exit();
                 }   

                 if($forum->num_rows() === 0){
                     return $this->sendResponse(false,  FORUM_NONEXIST_ERROR );
                     exit();
                 }

                
                 
                $detailsMyForum = $this->Api_user_model->get_forum_by_id('forum',['f_user_id'=>$user_id,'f_id'=>$forum_id]);
                

                if($detailsMyForum) { 
                    return $this->sendResponse(true, SUCCESS_MSG ,[
                            'forum_details' => $detailsMyForum->row()
                        ] );
                } else {
                    return $this->sendResponse(false, ERROR_MSG);
                }

            }


            // My Live Class
            public function get_live_class_list($user_id='')
            {
                $this->request('GET', '/api_user/get_live_class_list/');
                    if(!empty($user_id)){
                       $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id]);
                       if($user->num_rows() === 0) {
                           return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                           exit();
                       }
                    $condition = ["sc_user_id"=>$user_id,"live_date >="=>date('Y-m-d')];  
                    } else {
                    $condition = ["live_date >="=>date('Y-m-d')];
                    }

                    $live_class_list = $this->Crud_model->fetchLiveClassList('lctn.*, u.first_name as tutor, u.biography' , $condition);
                     
                    // $live_class_list = $this->Api_user_model->get_table_by_id('live_class_time_new',["live_date >="=>date('Y-m-d')],['live_class_time_new.*']);
                       
                if($live_class_list->num_rows() > 0) { 
                        return $this->sendResponse(true, SUCCESS_MSG, [
                            !empty($user_id)?'my_live_class_list':'live_class_list' => $live_class_list->result()
                        ]);
                } else {
                        return $this->sendResponse(true, NO_LIVE_ClASS);
                }

            }


            // My Live Class Detail
            public function get_live_class_detail($live_id='')
            {
                $this->request('GET', '/api_user/get_live_class_detail/');
                    
                       $live_class = $this->Api_user_model->check_id_exist('live_class_time_new',['live_id'=>$live_id]);
                       if($live_class->num_rows() === 0) {
                           return $this->sendResponse(false,  LIVE_UNAVAILABLE);
                           exit();
                       }

                    $condition = ["live_id"=>$live_id,"live_date >="=>date('Y-m-d')];  
                    $live_class_list = $this->Crud_model->fetchLiveClassList('lctn.*, u.first_name as tutor, u.biography' , $condition);
                     
                    // $live_class_list = $this->Api_user_model->get_table_by_id('live_class_time_new',["live_date >="=>date('Y-m-d')],['live_class_time_new.*']);
                       
                   if($live_class_list->num_rows() > 0) { 
                        return $this->sendResponse(true, SUCCESS_MSG, [
                            'get_live_class_detail' => $live_class_list->result()
                        ]);
                } else {
                        return $this->sendResponse(false, ERROR_MSG);
                }

            }




             public function insert_my_subscription_on_live_class($from = "") {
                     
                  $this->request('POST', '/api_user/insert_my_subscription_on_live_class/');
                  $this->form_validation->set_rules('user_id','User Id','trim|required');
                  $this->form_validation->set_rules('live_id','Live Id','trim|required');
                  $this->form_validation->set_rules('payment_type','Payment Type','trim|required');
                  $this->form_validation->set_rules('payment_status','Payment Status','trim|required');
                  $this->form_validation->set_rules('txn_id','Transaction Id','trim|required');
                  $this->form_validation->set_rules('payment_date','Payment Date','trim|required');
                  
                  
             
                   if($this->form_validation->run() == false)
                   { 
                     return $this->sendResponse(false, strip_tags(validation_errors()));
                   } else {
                    $user = $this->Api_user_model->check_id_exist('users',['id'=>$this->input->post('user_id')]);
                     if($user->num_rows() === 0){
                         return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                         exit();
                    }

                    $live_class = $this->Api_user_model->check_id_exist('live_class_time_new',['live_id'=>$this->input->post('live_id')]);
                     if($live_class->num_rows() === 0){
                         return $this->sendResponse(false,  LIVE_CLASS_NOT_EXIST );
                         exit();
                    }

                    if($this->input->post('payment_status') != 'Completed'){
                         return $this->sendResponse(false,  LIVE_CLASS_NOT_EXIST );
                         exit();
                    }
                    $data = [
                        'sc_user_id'=>$this->input->post('user_id'),
                        'sc_live_id'=>$this->input->post('live_id'),
                        'sc_user_id'=>$this->input->post('user_id'),
                        'payment_type'=>$this->input->post('payment_type'),
                        'payment_status'=>$this->input->post('payment_status'),
                        'txn_id'=>$this->input->post('txn_id'),
                        'payment_date'=>$this->input->post('payment_date'),
                        'subscription_date'=>date('m/d/Y')
                    ];

                    if($this->input->post('payment_status') == 'Completed'){
                        $data += ['status'=>'active'];
                        $query = $this->Api_user_model->update_table('live_class_time_new', ['live_subscription'=>1],['live_id'=>$data['sc_live_id']]);
                    }

                    $query = $this->Api_user_model->insert_table('subscription_class', $data);                
                 if($query) {
                         return $this->sendResponse(true, SUCCESS_MSG);
                 } else {
                         return $this->sendResponse(false,  ERROR_MSG );
                 }

               } // Something validation ends
             }

            // My Counselling Session
                        public function get_counselling_session_list($user_id='')
                        {
                            $this->request('GET', '/api_user/get_counselling_session_list/');

                               if(!empty($user_id)){
                                $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id]);
                                    if($user->num_rows() === 0) {
                                        return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                                        exit();
                                    }
                                $condition = ["sc_user_id"=>$user_id,"cs_date >="=>date('Y-m-d')];
                                } else {
                                $condition = ["cs_date >="=>date('Y-m-d')];
                                } 
                                $counselling_session_list = $this->Crud_model->fetchCounsellingSessionList('cs.*, u.first_name as tutor, u.biography',$condition);
                                 
                                // $counselling_session_list = $this->Api_user_model->get_table_by_id('counselling_session_time_new',["cs_date >="=>date('Y-m-d')],['counselling_session_time_new.*']);
                                   
                               if($counselling_session_list->num_rows() > 0) { 
                                    return $this->sendResponse(true, SUCCESS_MSG, [
                                        !empty($user_id)?'my_counselling_session_list':'counselling_session_list' => $counselling_session_list->result()
                                    ]);
                            } else {
                                    return $this->sendResponse(false, NO_COUNCELLING);
                            }

                        } 

                        // My Counselling Session Detail
                        public function get_counselling_session_detail($cs_id='')
                        {
                            $this->request('GET', '/api_user/get_counselling_session_detail/');

                               
                                $cs = $this->Api_user_model->check_id_exist('counselling_session',['cs_id'=>$cs_id]);
                                    if($cs->num_rows() === 0) {
                                        return $this->sendResponse(false,  COUNCELLING_UNAVAILABLE );
                                        exit();
                                    }
                                $condition = ["cs_id"=>$cs_id,"cs_date >="=>date('Y-m-d')];
                                 
                                $counselling_session_detail = $this->Crud_model->fetchCounsellingSessionList('cs.*, u.first_name as tutor, u.biography',$condition);
                                 
                                // $counselling_session_list = $this->Api_user_model->get_table_by_id('counselling_session_time_new',["cs_date >="=>date('Y-m-d')],['counselling_session_time_new.*']);
                                   
                               if($counselling_session_detail->num_rows() > 0) { 
                                    return $this->sendResponse(true, SUCCESS_MSG, [
                                        'counselling_session_detail' => $counselling_session_detail->result()
                                    ]);
                            } else {
                                    return $this->sendResponse(false, NO_COUNCELLING);
                            }

                }





             
             public function insert_my_subscription_on_counselling_session($from = "") {
                     
                  $this->request('POST', '/api_user/insert_my_subscription_on_counselling_session/');
                  $this->form_validation->set_rules('user_id','User Id','trim|required');
                  $this->form_validation->set_rules('cs_id','Counselling Session Id','trim|required');
                  $this->form_validation->set_rules('payment_type','Payment Type','trim|required');
                  $this->form_validation->set_rules('payment_status','Payment Status','trim|required');
                  $this->form_validation->set_rules('txn_id','Transaction Id','trim|required');
                  $this->form_validation->set_rules('payment_date','Payment Date','trim|required');
                  
                  
             
                   if($this->form_validation->run() == false)
                   { 
                     return $this->sendResponse(false, strip_tags(validation_errors()));
                   } else {
                    $user = $this->Api_user_model->check_id_exist('users',['id'=>$this->input->post('user_id')]);
                     if($user->num_rows() === 0){
                         return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                         exit();
                    }

                    $counselling_session = $this->Api_user_model->check_id_exist('counselling_session',['cs_id'=>$this->input->post('cs_id')]);
                     if($counselling_session->num_rows() === 0){
                         return $this->sendResponse(false,  CS_NOT_EXIST );
                         exit();
                    }

                    if($this->input->post('payment_status') != 'Completed'){
                         return $this->sendResponse(false,  PAYMENT_NOT_DONE);
                         exit();
                    }
                    
                    $data = [
                        'sc_user_id'=>$this->input->post('user_id'),
                        'sc_cs_id'=>$this->input->post('cs_id'),
                        'sc_user_id'=>$this->input->post('user_id'),
                        'payment_type'=>$this->input->post('payment_type'),
                        'payment_status'=>$this->input->post('payment_status'),
                        'txn_id'=>$this->input->post('txn_id'),
                        'payment_date'=>$this->input->post('payment_date'),
                        'subscription_date'=>date('m/d/Y')
                    ];

                    if($this->input->post('payment_status') == 'Completed'){
                        $data += ['status'=>'active'];
                        $query = $this->Api_user_model->update_table('counselling_session', ['cs_subscription'=>1],['cs_id'=>$data['sc_cs_id']]);
                    }

                    $query = $this->Api_user_model->insert_table('subscription_counselling_session', $data);                
                 if($query) {                                               
                         return $this->sendResponse(true, SUCCESS_MSG);
                 } else {                                            
                         return $this->sendResponse(false,  ERROR_MSG );
                 }

               } // Something validation ends
             }




            // public function insert_my_subscription_on_live_class_post($tutor_id){
            //  $this->form_validation->set_rules('user_id','User Id','trim|required');
            //  $this->form_validation->set_rules('live_id','Live Id','trim|required');
            //  $this->form_validation->set_rules('payment_type','Payment Type','trim|required');
            //  $this->form_validation->set_rules('payment_status','Payment Status','trim|required');
            //  $this->form_validation->set_rules('txn_id','Transaction Id','trim|required');
            //  $this->form_validation->set_rules('payment_date','Payment Date','trim|required');

            //  if($this->form_validation->run() == false)
            //  {
            //       $status = false;
            //       $message = 'Validation errors';
            //       $data = validation_errors();
            //       $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
            //  }
            //  else
            //  {
            //        $tutor = $this->Educator_model->check_id_exist('live_class_time_new',['instructor_id'=>$tutor_id]);
            //         if($tutor->num_rows() === 0){
            //             $status = false;
            //             $message = 'The Tutor doesn\'t exist.';
            //             $data = validation_errors();
            //             $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
            //        } else {

            //           $live_class = $this->Educator_model->check_id_exist('live_class_time_new',['live_id'=>$this->input->post('live_id')]);
            //                if($live_class->num_rows() === 0){
            //                   $status = false;
            //                   $message = 'This Live Class is not Available.';
            //                   $data = validation_errors();
            //                   $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
            //               } else {

            //               if($this->input->post('payment_status') != 'Completed'){
            //                    $status = false;
            //                    $message = 'This Live Class is not Available.';
            //                    $data = validation_errors();
            //                    $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
            //               } else {
            //               $data = [
            //                   'is_instructor'=>1,
            //                   'sc_live_id'=>$this->input->post('live_id'),
            //                   'sc_user_id'=>$this->input->post('user_id'),
            //                   'payment_type'=>$this->input->post('payment_type'),
            //                   'payment_status'=>$this->input->post('payment_status'),
            //                   'txn_id'=>$this->input->post('txn_id'),
            //                   'payment_date'=>$this->input->post('payment_date'),
            //                   'subscription_date'=>date('m/d/Y')
            //               ];

            //               if($this->input->post('payment_status') == 'Completed'){
            //                   $data += ['status'=>'active'];
            //                   $query = $this->Educator_model->update_table('live_class_time_new', ['live_subscription'=>1],['live_id'=>$data['sc_live_id']]);
            //               }
            //               if($query){
            //                   $query2 = $this->Educator_model->insert_table('subscription_class', $data);
            //               }                
            //            if($query2) {
            //                    $status = true;
            //                    $message = 'Subscription detail added successfully.';
            //                    $data = null;
            //                    $requestType = 'REST_Controller::HTTP_OK';
            //            } else {
            //                    $status = false;
            //                    $message = ERROR_MSG;
            //                    $data = null;
            //                    $requestType = 'REST_Controller::HTTP_BAD_REQUEST';
            //            }
            //                  }

            //                  }

            //                } 
            //          } // Something validation ends
             
            //  $this->response([
            //              'status' => $status,
            //              'message' => $message,
            //              'data' => $data
            //          ], $requestType);
            // }




             public function get_coupon_list($user_id='')
             {
                 $this->request('GET', '/api_user/get_coupon_list/');
                     if(!empty($user_id)){
                        $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id]);
                        if($user->num_rows() === 0) {
                            return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                            exit();
                        }
                     }

                     $coupon = $this->Api_user_model->get_coupons_by_user($user_id);

                 if(count($coupon) > 0) {
                         return $this->sendResponse(true, SUCCESS_MSG, $coupon);
                 } else {
                         return $this->sendResponse(true, NO_COUPONS);
                 }

             }

             public function add_to_cart()
             {
                 $this->request('POST', '/api_user/add_to_cart/');

                     $this->form_validation->set_rules('user_id', 'User ID', 'required|trim|xss_clean');
                     $this->form_validation->set_rules('courses[]', 'Course ID', 'required|trim|xss_clean');
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
                        // print_r($_POST);exit;
                        if(!empty($this->input->post('user_id'))){
                           $user = $this->Api_user_model->check_id_exist('users',['id'=>$this->input->post('user_id')]);
                           if($user->num_rows() === 0) {
                               return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                               exit();
                           }
                        }

                             $result = $this->crud_model->insert_cart();
                             if ($result) {
                                 $output = array(
                                     'status' => true,
                                     'msg' => 'Courses added in your cart',
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

             public function get_cart($user_id)
              {
                  $this->request('POST', '/api_user/get_cart/');
                      if(!empty($user_id)){
                         $user = $this->Api_user_model->check_id_exist('users',['id'=>$user_id]);
                         if($user->num_rows() === 0) {
                             return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                             exit();
                         }
                      }

                      $result = $this->crud_model->get_cart($user_id);
                      if ($result) {
                         $allData = [];
                         foreach ($result as $key => $value) {
                             $allData[$key]['cart_id'] = $value->id;
                             $allData[$key]['user_id'] = $value->user_id;
                             $allData[$key]['course_id'] = $value->course_id;
                             $allData[$key]['course_name'] = $this->crud_model->getCourseDetails($value->course_id)->title;
                             $allData[$key]['thumbnail'] = $this->crud_model->getCourseDetails($value->course_id)->thumbnail;
                             $allData[$key]['price'] = $this->crud_model->getCourseDetails($value->course_id)->price;
                         }
                          $output = array(
                              'status' => true,
                              'msg' => 'Cart data found',
                              'data' => $allData,
                          );
                      }else{
                        $output = array(
                            'status' => true,
                            'msg' => 'Cart',
                            'data' => [],
                        );
                      }
                      echo json_encode($output);
                      exit;

              }

             public function delete_course_from_cart($cart_id)
             {
                 $this->request('POST', '/api_user/delete_course_from_cart/');

                     $result = $this->crud_model->delete_cart($cart_id);
                     if ($result) {
                         $output = array(
                             'status' => true,
                             'msg' => 'Course removed',
                             'data' => $result,
                         );
                     }else{
                         $output = array(
                             'status' => false,
                             'msg' => 'No course found in cart',
                             'data' => null,
                         );
                     }
                     echo json_encode($output);
                     exit;

             }

             public function checkout(){
                            
                           $this->request('POST', '/api_user/checkout');
                           $this->form_validation->set_rules('user_id', 'User ID', 'required|trim|xss_clean');
                           $this->form_validation->set_rules('coupon_id', 'Coupon ID', 'trim|xss_clean');
                           // $this->form_validation->set_rules('cart_id[]', 'Cart', 'required');


                           if($this->form_validation->run() == false)
                           {
                               $message = explode("\n",strip_tags($this->form_validation->error_string()));
                               return $this->sendResponse(false, $message[0],[]);
                           }
                           else
                           {
                               // $cart_id = $this->input->post('cart_id');
                               $user_id = $this->input->post('user_id');

                               $user = $this->Api_user_model->check_id_exist('users',['id' => $user_id, 'role_id' => 2, 'is_instructor' => 0]);
                               if($user->num_rows() === 0) {
                                   return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                                   exit();
                               }

                               $cart = $this->crud_model->get_cart($user_id);
                               if (count($cart) == 0) {
                                   return $this->sendResponse(false, "No course added in cart.");
                               }

                               foreach ($cart as $key => $value) {
                                   $isEnrolled = $this->NewApiModel->isEnrolledtCourse($user_id, $value->course_id);
                                   if($isEnrolled)
                                   {
                                       $this->crud_model->delete_cart($value->id);
                                   }
                               }


                               $cart_after_deleting_enrolled_course = $this->crud_model->get_cart($user_id);
                               if (count($cart) == 0) {
                                   return $this->sendResponse(false, "No course added in cart.");
                               }

                               $course_ids = [];
                               $total_price = 0;

                               foreach ($cart as $key => $value) {
                                   $course_ids[] = $value->course_id;
                                   $total_price += $this->NewApiModel->getCourseDetails($value->course_id)->price;
                               }

                               if (!empty($this->input->post('coupon_id'))) {
                                   $coupon = $this->NewApiModel->getCouponDetails($this->input->post('coupon_id'));
                                   if(!empty($coupon)){
                                       if ($coupon->users != 'all') {
                                       if (in_array($user_id, json_decode($coupon->users)))
                                         {
                                           $currentDate = time();
                                           $contractDateBegin = strtotime($coupon->cpn_start_date);
                                           $contractDateEnd = strtotime($coupon->cpn_end_date);

                                           if ($currentDate < $contractDateBegin) {
                                                return $this->sendResponse(false, "Coupon is not available!");
                                           }

                                           if ($currentDate > $contractDateEnd) {
                                                return $this->sendResponse(false, "Coupon code is expired!");   
                                           }

                                        //    if($coupon->cpn_no_of_times_used == 0) {
                                        //     return $this->sendResponse(false, "Coupon code usage is expired!");
                                        //    }
                                         }
                                         else
                                         {
                                           return $this->sendResponse(false, "Coupon code is invalid!");
                                         }
                                   }
                                 
                                   
                                   $dicount_percentage = $coupon->cpn_percent;
                                   $max_discount = $coupon->cpn_max;

                                   $discount_price = ($dicount_percentage / 100) * (float)$total_price;
                                   
                                   if ($discount_price > $max_discount) {
                                       $discount_price = $max_discount;
                                   }

                                   $final_price_after_discount = $total_price - $discount_price;

                                   } else {
                                    $final_price_after_discount = $total_price;   
                                   }
                               } else {
                                   $final_price_after_discount = $total_price;
                               }
                               
                               // print_r($final_price_after_discount);exit;

                               // $course = $this->NewApiModel->getCourseDetails($course_id);

                               // if(empty($course))
                               // {
                               //     $this->sendResponse(false, "Course not found");
                               // }

                               // if($course->is_free_course == 1)
                               // {
                               //     $this->sendResponse(false, "This course is free");
                               // }


                               try {
                                   $receipt = 'TXN'.time();
                                   $inramount = (float)$final_price_after_discount;
                                   $amount = $inramount * 100;

                                   $url = "https://api.razorpay.com/v1/orders";

                                   $curl = curl_init($url);
                                   curl_setopt($curl, CURLOPT_URL, $url);
                                   curl_setopt($curl, CURLOPT_POST, true);
                                   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                                   $rezorkey = RAZOR_LKEY;

                                   $headers = array(
                                   "content-type: application/json",
                                   "Authorization: Basic ".$rezorkey,
                                   );
                                   curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

                                   $data = '{"amount": "'.$amount.'", "currency": "INR", "receipt": "'.$receipt.'"}';

                                   curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

                                   //for debug only!
                                   curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                                   curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                                   $resp = curl_exec($curl);
                                   // print_r($resp);exit;
                                   curl_close($curl);
                                   // var_dump($resp);
                                   // return json_encode($resp);
                                   $respData = json_decode($resp);
                                   $pdata = [
                                       'po_user_id' => $user_id,
                                       'po_course_id' => json_encode($course_ids),
                                       'po_price' => $inramount,
                                       'po_order_id' => $respData->id,
                                       'po_type' => "course",
                                       'po_coupon_id' => $this->input->post('coupon_id')
                                   ];

                                   $this->NewApiModel->saveOrderId($pdata);

                                   $this->sendResponse(true, "Success",$respData);
                               }
                               catch(Exception $e)
                               {
                                   $this->sendResponse(false, $e->getMessage());
                               }
                           }
                        }

             public function verify_payment() {
                $this->request('POST','api_user/verify_payment');
                
                $this->form_validation->set_rules('razorpay_payment_id', 'Payment ID', 'required');
                $this->form_validation->set_rules('razorpay_order_id', 'Order ID', 'required');
                $this->form_validation->set_rules('razorpay_signature', 'Signature', 'required');

                if($this->form_validation->run() == false)
                {
                    $message = explode("\n",strip_tags($this->form_validation->error_string()));
                    return $this->sendResponse(false, $message[0],[]);
                }
                else
                {
                    $paymetOrderDetails = $this->NewApiModel->getPaymentOrderDetails2($this->input->post('razorpay_order_id'));

                    $user_id = $paymetOrderDetails->po_user_id;
                    $po_id = $paymetOrderDetails->po_id;
                    $course_id = $paymetOrderDetails->po_course_id;
                    $price = $paymetOrderDetails->po_price;
                    $order_id = $this->input->post('razorpay_order_id');
                    $payment_id = $this->input->post('razorpay_payment_id');
                    $signature = $this->input->post('razorpay_signature');

                    $where = [
                        'po_id' => $po_id,
                        'po_user_id' => $user_id,
                        'po_price' => $price,
                        'po_order_id' => $order_id,
                        'po_type' => "course",
                        'po_status' => '0'
                    ];

                    $check = $this->NewApiModel->checkPayOrder($where);

                    if($check <= 0)
                    {
                        return $this->sendResponse(false, "Invalid Request",[]);
                    }

                    $secrect_key_razor = RAZOR_KEY_SECRET;

                    $sig = hash_hmac('sha256', "$order_id|$payment_id", $secrect_key_razor);

                    if($sig == $signature)
                    {
                        foreach (json_decode($course_id) as $key => $value) {
                            $paydata = [
                                'user_id' => $user_id,
                                'payment_type' => "razorpay",
                                'course_id' => $value,
                                'amount' => $price,
                                'admin_revenue' => $price,
                                'transaction_id' => $order_id,
                                'razor_payment_id' => $payment_id,
                                'razor_signature' => $signature
                            ];
                            $this->NewApiModel->enrol_student($user_id,$value);
                            $this->NewApiModel->course_purchase($paydata);
                        }
                        $this->NewApiModel->emptyCart($user_id);
                        $this->NewApiModel->updatePayOrder($where);
                        return $this->sendResponse(true, "Payment is successful.",[]);
                    }
                    else
                    {
                        return $this->sendResponse(false, "Payment Failed",[]);
                    }


                }
             }

             public function get_social_links()
             {
                 $this->request('GET', '/api_user/get_social_links');

                     $links = $this->user_model->solcial_links_get();

                 if(count($links) > 0) {
                         return $this->sendResponse(true, SUCCESS_MSG, $links);
                 } else {
                         return $this->sendResponse(true, 'No links found');
                 }

             }

             public function partial_payment_checkout(){
                try{
                    $this->request('POST','api_user/partial_payment_checkout');
                    $this->form_validation->set_rules('user_id', 'User ID', 'required');
                    $this->form_validation->set_rules('course_id', 'Course ID', 'required');
                    $this->form_validation->set_rules('installments[]', 'Installments', 'required');

                    if($this->form_validation->run() == false)
                    {
                        $message = explode("\n",strip_tags($this->form_validation->error_string()));
                        return $this->sendResponse(false, $message[0],[]);
                    }
                    else
                    {
                        $user = $this->Api_user_model->check_id_exist('users',['id' => $this->input->post('user_id'), 'role_id' => 2, 'is_instructor' => 0]);
                        if($user->num_rows() === 0) {
                            return $this->sendResponse(false,  USER_NONEXIST_ERROR );
                            exit();
                        }

                        $course = $this->Api_user_model->check_id_exist('course',['id' => $this->input->post('course_id')]);
                        if($course->num_rows() === 0) {
                            return $this->sendResponse(false,  'Course not exist!' );
                            exit();
                        }else{
                            $partial_course = $this->Api_user_model->check_id_exist('partial_payment_courses',['course_id' => $this->input->post('course_id')]);
                            // echo json_encode($partial_course);exit;
                            if($partial_course->num_rows() === 0) {
                                return $this->sendResponse(false,  'Partial payment option not found for this course!' );
                                exit();
                            }else{
                                $total_price_after_installments = 0;
                                $total_price = $partial_course->row('price_per_installments');
                                foreach($this->input->post('installments') as $key => $value){
                                    if ($value > $partial_course->row('no_of_installments')) {
                                        return $this->sendResponse(false,  'Installments exceeds!');
                                        exit();
                                    }
                                    $e_i = $this->NewApiModel->get_enroll_by_installment($this->input->post('user_id'), $this->input->post('course_id'), $value);
                                    if ($e_i->num_rows() > 0) {
                                        return $this->sendResponse(false,  'Installment '.$value.' already present!');
                                        exit();
                                    }
                                    // echo json_encode($e_i);exit;

                                    $total_price_after_installments += $total_price;
                                }
                            }
                        }

                        $isEnrolled = $this->NewApiModel->isEnrolledtCourse($this->input->post('user_id'), $this->input->post('course_id'));
                        if($isEnrolled)
                        {
                            return $this->sendResponse(false,  'You are already enrolled for this course!');
                            exit();
                        }

                        $receipt = 'TXN'.time();
                        $inramount = (int)$total_price_after_installments;
                        $amount = $inramount * 100;

                        $url = "https://api.razorpay.com/v1/orders";

                        $curl = curl_init($url);
                        curl_setopt($curl, CURLOPT_URL, $url);
                        curl_setopt($curl, CURLOPT_POST, true);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                        $rezorkey = RAZOR_LKEY;

                        $headers = array(
                        "content-type: application/json",
                        "Authorization: Basic ".$rezorkey,
                        );
                        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

                        $data = '{"amount": "'.$amount.'", "currency": "INR", "receipt": "'.$receipt.'"}';

                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

                        //for debug only!
                        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                        $resp = curl_exec($curl);
                        // print_r($resp);exit;
                        curl_close($curl);
                        // var_dump($resp);
                        // return json_encode($resp);
                        $respData = json_decode($resp);
                        $course_ids = [$this->input->post('course_id')];
                        $pdata = [
                            'po_user_id' => $this->input->post('user_id'),
                            'po_course_id' => json_encode($course_ids),
                            'po_price' => $inramount,
                            'po_order_id' => $respData->id,
                            'po_type' => "course",
                            'payment_option' => 'partial_course',
                            'installments' => json_encode($this->input->post('installments')),
                        ];
                        $this->NewApiModel->saveOrderId($pdata);

                        $this->sendResponse(true, "Success",$respData);


                    }
                    $this->sendResponse(true, "Success");
                }
                catch(Exception $e)
                {
                    $this->sendResponse(false, $e->getMessage());
                }
             }


             public function verify_partial_payment(){
                $this->request('POST','api_user/verify_payment');
                // $this->form_validation->set_rules('po_id', 'Payment order ID', 'required');
                $this->form_validation->set_rules('razorpay_payment_id', 'Payment ID', 'required');
                $this->form_validation->set_rules('razorpay_order_id', 'Order ID', 'required');
                $this->form_validation->set_rules('razorpay_signature', 'Signature', 'required');

                if($this->form_validation->run() == false)
                {
                    $message = explode("\n",strip_tags($this->form_validation->error_string()));
                    return $this->sendResponse(false, $message[0],[]);
                }
                else
                {
                    $paymetOrderDetails = $this->NewApiModel->getPaymentOrderDetails2($this->input->post('razorpay_order_id'));
                    if (!$paymetOrderDetails) {
                        return $this->sendResponse(false, "No order found with this Order ID",[]);
                    }else{
                        if ($paymetOrderDetails->payment_option != 'partial_course') {
                            return $this->sendResponse(false, "This order doesnot support partial payment option.",[]);
                        }
                    }

                    $user_id = $paymetOrderDetails->po_user_id;
                    $po_id = $paymetOrderDetails->po_id;
                    $course_id = $paymetOrderDetails->po_course_id;
                    $price = $paymetOrderDetails->po_price;
                    $order_id = $this->input->post('razorpay_order_id');
                    $payment_id = $this->input->post('razorpay_payment_id');
                    $signature = $this->input->post('razorpay_signature');

                    $where = [
                        'po_id' => $po_id,
                        'po_user_id' => $user_id,
                        'po_price' => $price,
                        'po_order_id' => $order_id,
                        'po_type' => "course",
                        'po_status' => '0',
                        'payment_option' => 'partial_course',
                        'installments' => $paymetOrderDetails->installments
                    ];

                    $check = $this->NewApiModel->checkPayOrder($where);

                    if($check <= 0)
                    {
                        return $this->sendResponse(false, "Invalid Request",[]);
                    }

                    // echo json_encode($check);exit;

                    $secrect_key_razor = RAZOR_KEY_SECRET;

                    $sig = hash_hmac('sha256', "$order_id|$payment_id", $secrect_key_razor);

                    if($sig == $signature)
                    {
                        $c_id = '';
                        foreach (json_decode($course_id) as $key => $value) {
                            $c_id = $value;
                        }
                            $paydata = [
                                'user_id' => $user_id,
                                'payment_type' => "razorpay",
                                'course_id' => $c_id,
                                'amount' => $price,
                                'admin_revenue' => $price,
                                'transaction_id' => $order_id,
                                'razor_payment_id' => $payment_id,
                                'razor_signature' => $signature,
                                'type_of_pay' => 'partial_course',
                                'installments' => $paymetOrderDetails->installments
                            ];
                            $this->NewApiModel->enrol_student_installments($user_id,$c_id,$paymetOrderDetails->installments);
                            $this->NewApiModel->course_purchase($paydata);
                        $this->NewApiModel->updatePayOrder($where);
                        return $this->sendResponse(true, "Payment is successful.",[]);
                    }
                    else
                    {
                        return $this->sendResponse(false, "Payment Failed",[]);
                    }


                }
             }


             public function get_course_installments($course_id, $user_id){
                try{
                    $partial_course = $this->Api_user_model->check_id_exist('partial_payment_courses',['course_id' => $course_id]);
                    if($partial_course->num_rows() === 0) {
                        return $this->sendResponse(false,  'Partial payment option not found for this course!' );
                        exit();
                    }else{
                        $partial_course_sections = $this->Api_user_model->check_id_exist('partial_payments_sections',['course_id' => $course_id, 'partial_payment_id' => $partial_course->row('id')]);
                        $data = [];
                        $datas = [];
                        $data['id'] = $partial_course->row('id');
                        $data['course_id'] = $partial_course->row('course_id');
                        $data['no_of_installments'] = $partial_course->row('no_of_installments');
                        $data['price_per_installments'] = $partial_course->row('price_per_installments');
                        $data['created_at'] = $partial_course->row('price_per_installments');
                        $data['installments'] = $this->NewApiModel->isInstallmentPaidDetails($user_id,$course_id);

                        foreach ($partial_course_sections->result() as $key => $value) {
                            $datas[$key]['installments_id'] = $value->id;
                            $datas[$key]['installments_section_id'] = $value->section_id;
                            $datas[$key]['access_after_installment'] = $value->access;
                            $section = $this->NewApiModel->section_details($course_id,$value->section_id);
                            $lessons = $this->crud_model->get_lessons('section', $section->id)->result_array();
                            $datas[$key]['sections'] = array('id' => $section->id,'title'=>$section->title, 'lessons'=> $lessons);
                        }
                        $data['installments_details'] = $datas;
                        return $this->sendResponse(true,  'Installments found!', $data );
                        exit();
                    }
                   }
                   catch(Exception $e)
                   {
                       $this->sendResponse(false, $e->getMessage());
                   }
                }


}

