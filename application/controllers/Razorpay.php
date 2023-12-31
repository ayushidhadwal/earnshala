<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Razorpay extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        /*cache control*/
        $this->load->model('NewApiModel');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function callbackUrl(){

        $razorpayPaymentId = $_GET['razorpay_payment_id'];
        $razorpayPaymentLinkId = $_GET['razorpay_payment_link_id'];
        $razorpaySignature = $_GET['razorpay_signature'];

        $result = $this->crud_model->updatePayment($razorpayPaymentId,$razorpayPaymentLinkId,$razorpaySignature);
        if($result){
            $res = $this->db->where('transaction_id',$razorpayPaymentLinkId)->get('payment')->row();
            $this->NewApiModel->enrol_student($res->user_id,$res->course_id);
            return redirect($res->short_url);
        }

    }

}
