<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Welcome/login';
$route['404_override'] =  null;
$route['translate_uri_dashes'] = FALSE;

// $route['certificate/(:any)'] = "addons/certificate/generate_certificate/$1";

// //course bundles
// $route['course_bundles/(:any)']								= "addons/course_bundles/index/$1";
// $route['course_bundles']									= "addons/course_bundles";
// $route['course_bundles/search/(:any)']						= "addons/course_bundles/search/$1";
// $route['course_bundles/search/(:any)/(:any)']				= "addons/course_bundles/search/$1/$1";
// $route['bundle_details/(:any)/(:any)']  					= "addons/course_bundles/bundle_details/$1";
// $route['bundle_details/(:any)']  							= "addons/course_bundles/bundle_details/$1/$1";
// $route['course_bundles/buy/(:any)']  						= "addons/course_bundles/buy/$1";
// $route['home/my_bundles']  									= "addons/course_bundles/my_bundles";
// $route['home/bundle_invoice/(:any)']  						= "addons/course_bundles/invoice/$1";
//end course bundles

//Welcome Routes
// $route['faq']									   = "welcome/faq";
// $route['faqs/(:any)']							   = "welcome/faqsGeneral/$1";
// $route['about-us']                                 = "welcome/aboutUs";
// $route['guide-agreement']                          = "welcome/guideAgreement";
// $route['instructor-agreement']                     = "welcome/instructorAgreement";
// $route['instructors/(:num)']                	   = "welcome/instructors/$1";
// $route['self-improvement']                     	   = "welcome/selfImprovement";
// $route['self-improvement-1']                       = "welcome/selfImprovementone";
// $route['fitness']                     	           = "welcome/fitness";

//Education
// $route['education']                                = "welcome/educations";
// $route['education/(:num)']                         = "welcome/education/$1";

//API route
// $route['fetch-state/(:num)']                       = "welcome/fetchStateByCountry/$1";
// $route['fetch-cities/(:num)']                      = "welcome/fetchCitiesByCountry/$1";
// $route['fetch-instructor-by-filter']        	   = "welcome/fetchInstructorByFilter";


//login and register
$route['privacy-policy'] = "welcome/privacyPolicy";
$route['eua'] = "welcome/termsOfUse";
$route['login'] = 'welcome/login';
// $route['register'] = 'welcome/register';
// $route['account-verify'] = 'login/accountVerfiy';
// $route['user-otp-verify/(:num)'] = 'login/otpVerify/$1';
// $route['register-as-instructor'] = 'welcome/registerAsInstructor';
// $route['register-as-learner'] = 'welcome/registerAsLearner';
// $route['otp-verify'] = 'login/otp_verify';
// $route['resend-otp'] = 'login/resendOtp';

//Social Login
// $route['google/login'] = 'login/googleLogin';
// $route['facebook/login'] = 'login/facebookLogin';



//courses
// $route['courses'] = 'welcome/courses';

//instructor
// $route['instructor/live-class-time'] = 'Home/addLiveClassDateTimeView';
// $route['instructor/add-live-class-time'] = 'Home/addLiveClassDateTime';
// $route['instructor/live-class-time-list'] = "Home/liveClassList";

//API
// $route['get-subcategory-by-category-id'] = 'Admin/getSubCategoryByCategoryId';
// $route['subscribe-newsletter'] = "Welcome/submitNewsletterSubcription";
// $route['get-sub-child-by-category-id'] = 'Home/getSubChildCatgeory';

//Razorpay
// $route['myaccount'] = "Home/myaccount";
// $route['home/pay'] = "Home/pay";
// $route['payment/success'] = "Home/success";


//-----------------APIs-----------------------------

//Main APIs
$route['api/get-state'] = "Apis/getAllState";
$route['api/get-free-courses'] = "Apis/getFreeCourses";
$route['api/get-paid-courses'] = "Apis/getPaidCourses";
$route['api/user/get-upcoming-courses'] = "Apis/getUpcomingCourses";

//Student APIs
$route['api/user/register'] = "Apis/register";
$route['api/user/login'] = "Apis/login";
$route['api/user/update-password'] = "Apis/updatePassword";
$route['api/user/verification-otp/(:any)'] = "Apis/sendOtpForVerification/$1";

$route['api/user/get-profile/(:num)'] = "Apis/getProfile/$1";
$route['api/user/update-profile'] = "Apis/updateProfile";
$route['api/user/forget-password'] = "Apis/forgetPassword";
$route['api/user/reset-password'] = "Apis/resetPassword";

$route['api/user/get-course-details'] =  "Apis/getCourseDetails";
$route['api/user/get-course-sections'] =  "Apis/getCourseSections";
$route['api/user/get-course-reviews'] =  "Apis/getCourseReviews";
$route['api/user/add-to-wishlist'] = "Apis/addToWishlist";
$route['api/user/get-wishlist/(:num)'] = "Apis/getWishlist/$1";
$route['api/user/search'] = "Apis/search";
$route['api/user/add-live-class-to-wishlist'] = "Apis/addLiveClasstoWishlist";
$route['api/user/get-live-wishlist/(:num)'] = "Apis/getLiveClassWishlist/$1";
$route['api/user/add-counselling-session-to-wishlist'] = "Apis/addCounsellingtoWishlist";
$route['api/user/get-counsellor-wishlist/(:num)'] = "Apis/getCounsellorWishlist/$1";

//Student Enroll
$route['api/user/enrol-for-free-course'] = "Apis/enrollFreeCourse";
$route['api/user/get-enrolled-courses/(:num)'] = "Apis/getEnrolledCourses/$1";
$route['api/user/generate-order'] = "Apis/generateOrder";
$route['api/user/verify-signature'] = "Apis/verifySignature";

//Student Quiz
$route['api/user/get-all-quiz'] = "Apis/getAllQuizList";
$route['api/user/get-all-question-by-quiz/(:num)'] = "Apis/getAllQuestionByQuiz/$1";
$route['api/user/submit-quiz'] = "Apis/submitQuiz";

//Student Forum
$route['api/user/create-forum'] = "Apis/submitForum";
$route['api/user/update-forum'] = "Apis/updateForum";
$route['api/user/get-forum-list'] = "Apis/getForumList";
$route['api/user/get-forum-by-user/(:num)'] = "Apis/getForumByUser/$1";
$route['api/user/get-forum-details/(:num)'] = "Apis/getForumDetailById/$1";
$route['api/user/add-reply-to-forum'] = "Apis/addReplyToForum";
$route['api/user/add-reply-to-forum-reply'] = "Apis/addReplyToForumReply";
$route['api/user/delete-forum'] = "Apis/deleteForum";

//Live Class
$route['api/user/get-free-live-class'] = "Apis/getLiveFreeClass";
$route['api/user/get-paid-live-class'] = "Apis/getLivePaidClass";
$route['api/user/get-live-class-details'] = "Apis/getLiveClassDetails";
$route['api/user/enrol-for-free-live-class'] = "Apis/enrollForFreeLiveClass";
$route['api/user/get-enrolled-live-class/(:num)'] = "Apis/getEnrolledLiveClasses/$1";
$route['api/user/generate-order-for-live-class'] = "Apis/generateOrderForLiveClass";
$route['api/user/verify-signature-live-class'] = "Apis/verifySignatureLive";

//Counselling
$route['api/user/get-counseling-session'] = "Apis/getCounsellingSession";
$route['api/user/get-counselling-session-details'] = "Apis/getCounsellingSessionDetails";
$route['api/user/get-slots'] = "Apis/getCounsellorSlots";
$route['api/user/generate-order-for-counselling'] = "Apis/generateOrderForCounselling";
$route['api/user/verify-signature-counselling'] = "Apis/verifySignatureCounselling";
$route['api/user/get-enrolled-counselling/(:num)'] = "Apis/getEnrolledCounselling/$1";


//Get Notification
$route['api/user/get-notification/(:num)'] = "Apis/getNotification/$1";

//chat
$route['api/user/send-message'] = "Apis/sendMessage";
$route['api/user/get-live-message/(:num)'] = "Apis/getMessage/$1";

// live class count
$route['api/user/live-class-count'] = "Apis/updateClassStudentCount";
$route['api/user/get-class-count/(:num)'] = "Apis/getClassStudentCount/$1";

//Teacher APIs
$route['api/teacher/login'] = "TeacherApis/login";
$route['api/teacher/update-password'] = "TeacherApis/updatePassword";
$route['api/teacher/get-profile/(:num)'] = "TeacherApis/getProfile/$1";
$route['api/teacher/update-profile'] = "TeacherApis/updateProfile";
$route['api/teacher/forgot-password'] = "TeacherApis/forgetPassword";
$route['api/teacher/reset-password'] = "TeacherApis/resetPassword";

//Teacher Schedule
$route['api/teacher/get-schedule/(:num)'] = "TeacherApis/getSchedule/$1";
$route['api/teacher/insert-update-schedule'] = "TeacherApis/updateSchedule";

//Classes
$route['api/teacher/get-upcoming-classes/(:num)'] = "TeacherApis/getUpcomingClass/$1";
$route['api/teacher/get-finished-live-class/(:num)'] = "TeacherApis/getFinishedClass/$1";

//Counselling
$route['api/teacher/get-upcoming-counselling-session/(:num)'] = "TeacherApis/getUpcomingCounsellingSession/$1";
$route['api/teacher/get-finished-counselling-session/(:num)'] = "TeacherApis/getFinishedCounsellingSession/$1";

//Get Notification
$route['api/teacher/get-notification/(:num)'] = "TeacherApis/getNotification/$1";

// Token Generate and Validate Counselling
$route['api/teacher/counselling-validate/(:any)/(:any)/(:any)'] = "TeacherApis/validateCounselling/$1/$2/$3";

// Token Generate and Validate live class
$route['api/teacher/live-class-validate/(:any)/(:any)/(:any)'] = "TeacherApis/validateLiveClass/$1/$2/$3";

// Social Login
$route['api/user/socialLogin'] = "Apis/socialLogin";

//Review
$route['api/user/add-review'] = "Apis/addReview";
$route['api/user/delete-review/(:num)/(:num)'] = "Apis/deleteReview/$1/$2";
$route['api/user/get-user-review/(:num)/(:num)'] = "Apis/getUserReview/$1/$2";

$route['api/user/banners'] = "Apis/getBanners";

// cron jobs
$route['api/cron/live-class-warning'] = "Apis/liveClassWarning";
$route['api/cron/live-class-start'] = "Apis/liveClassStart";
$route['api/cron/counselling-warning'] = "Apis/counsellingSessionWarning";
$route['api/cron/counselling-start'] = "Apis/counsellingSessionStart";