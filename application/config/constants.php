
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/

defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// Puhupwas Starts
define('ERROR_MSG', 'Something went wrong, please try again later.');
define('SUCCESS_MSG', 'Success.');
define('SUCCESS_UPDATED', 'Successfully Updated.');
define('NO_UPDATE_MSG', 'No Changes Made.');
define('NOT_UPDATE_MSG', 'You have not made any changes.');
define('LOGIN_FAILED_MSG', 'Invalid Credentials.');
define('LOGIN_SUCCESS_MSG', 'Successfully Login.');
define('REGISTER_FAILED_MSG', 'Register Failed.');
define('REGISTER_SUCCESS_MSG', 'Successfully Register.');
define('OTP_ERROR_MSG', 'OTP is wrong.');
define('OTP_SENT_MSG', 'OTP sent Successfully.');
define('NEW_PASS_SUCCESS_MSG', 'New Password Successfully Changed.');
define('VERIFY_SUCCESS_MSG', 'OTP Successfully Verified.');
define('CONFIRM_PASS_ERR', 'The Confirm Password field does not match the New Password field.');
define('CONFIRM_PASS_REQ', 'The Confirm Password field is required.');
define('EMAIL_INCORRECT', 'The Email is incorrect please try again.');
define('OLD_PASS_ERR', 'The Old Password is Incorrect.');
define('OLD_PASS_VERIFIED', 'The Old Password is correct Enter New Password.');
define('EMAIL_CORR_NEW_PASS', 'The Email is correct Enter New Password.');
define('ENTER_NEW_PASS', 'Enter New Password');
define('ENTER_OTP_MSG', 'Please Enter Your OTP.');
define('NO_CHANGES', 'No Changes Made.');
define('USER_NONEXIST_ERROR',  'This User doesn\'t exist');
define('FORUM_NONEXIST_ERROR', 'This Forum doesn\'t exist');
define('FORUM_REPLY_NONEXIST_ERROR', 'This Forum Reply Id doesn\'t exist');
define('EMAIL_ALREADY', 'This Email already exist');
define('PHONE_UNIQUE', 'This Phone Number already exist');
define('LIVE_CLASS_NOT_EXIST', 'This Live Class Doesn\'t Exist');
define('PAYMENT_NOT_DONE', 'The Payment is not done.');
define('CS_NOT_EXIST', 'This Counselling Session Doesn\'t Exist');
define('USER_NOT_LOGIN', 'The User is not Logged In.');
define('NO_COUNCELLING', 'No Counselling Session available.');
define('LIVE_UNAVAILABLE', 'This Live class not available.');
define('COUNCELLING_UNAVAILABLE', 'This Counselling class not available.');


define('COURSE_NONEXIST_ERROR', 'This Course doesn\'s exist');
define('STAR_NUMBERIC_ERROR', 'Rating must be in number.');
define('SUCCESS_REVIEW_INSERTED', 'Successfully inserted review.');
define('FAILED_REVIEW_INSERTED', 'Insertion Failed.');
define('SUCCESS_REVIEW_UPDATED', 'Successfully updated review.');
define('FAILED_REVIEW_UPDATED', 'No Changes Made.');

define('USER_ID_REQUIRED', 'The User id is required.');
define('COURSE_ID_REQUIRED', 'The Course id is required.');
define('NO_REVIEW', 'No Review Found.');
define('NO_QUIZ', 'No Quiz Exist.');
define('QUIZ_NONEXIST_ERROR', 'The Quiz doesn\'t exist.');
define('NO_QUIZ_QUESTION', 'No Quiz Question found.');
define('QUIZ_QUESTION_NUMBERIC_ERROR', 'The Quiz Question must be a number.');
define('QUIZ_QUESTION_NONEXIST_ERROR', 'The Quiz Question doesn\'t exist : ');
define('ATTEMPED_ANSWER_NUMBERIC_ERROR', 'The Attempted answer must be a number.');

define('NO_FORUM', 'No Forum Found.');
define('USER_AS_NUMBER', 'The user id must be a number.');
define('FORUM_AS_NUMBER', 'The forum id must be a number.');
define('SUCCESS_DELETED_FORUM', 'Successfully deleted forum.');
define('SUCCESS_INSERTED_FORUM', 'Successfully inserted forum.');
define('NO_COURSE', 'No Course Found.');
define('NO_LIVE_ClASS', 'No Live Class Found.');

define('NO_SECTION', 'No Section Found.');
define('NO_STATE', 'No State Found.');
define('STATE_NOT_EXIST', 'The State doesn\'t exist');
define('PHONE_NOT_EXIST', 'The Phone doesn\'t exist');
define('PHONE_MUST_NUMBER', 'The Phone must be a number.');
define('PHONE_CHARACTOR_MAX', 'The Phone field must be exactly 10 characters in length.');
define('NO_COUPONS', 'Sorry, No coupons are available now.');







define('RAZOR_KEY_ID', 'rzp_live_RsMKGB1c2snvjP');
define('RAZOR_KEY_SECRET', 'Y3jN86IGSeCtorC92K2VfBVW');

define('RAZOR_KEY_SECRET_TEST', 'RmCo2dHMFXzijgrhxNVIzybK'); // TEST SECRET

define('RAZOR_LKEY', 'cnpwX2xpdmVfUnNNS0dCMWMyc252alA6WTNqTjg2SUdTZUN0b3JDOTJLMlZmQlZX'); // LIVE KEY

define('RAZOR_TKEY', 'cnpwX3Rlc3RfU0NwUjRkNERiVTZEZTI6Um1DbzJkSE1GWHppamdyaHhOVkl6eWJL'); // TEST KEY