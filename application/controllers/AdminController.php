<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') or exit('No direct script access allowed');

class AdminController extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
        // if ($this->session->userdata('is_logged_in') == 1) {
        //     redirect('dashboard');
        // }
        $this->load->model('AdminModel');
    }

    public function index()
    {
        $this->load->view('admin/loginpage');
    }

    public function logout()
    {
        $this->clear_cache();
        $this->session->sess_destroy();
        redirect('/');
    }

    public function checkcredentialsAdmin()
    {
        $adminemail = $this->input->post('adminemail');
        $adminpass = $this->input->post('adminpass');

        $newpass = MD5($adminpass);

        $conditions = array("usermail" => $adminemail, "userpassword" => $newpass, "userstatus" => '1', "userrole<>" => 3);
        $resultcheck = $this->AdminModel->checkuserAdmin($conditions);
        if (!empty($resultcheck)) {
            $this->session->set_userdata('logged_in_info', $resultcheck);
            $this->session->set_userdata('is_logged_in', '1');
            $language = 'en';
            $this->session->set_userdata('site_lang', $language);
            echo "success";
        } else {
            echo "fail";
        }
    }

    public function paymentresponse($uid)
    {
        $conditions = array("user_id" => $uid);
        $temptransdata = $this->AdminModel->get_tem_trans_data($conditions);

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://www.paynow.co.zw/Interface/CheckPayment/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => explode("?", $temptransdata->pollurl)[1],
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);

        $resparray = array();
        $breakresponse = explode("&", $response);
        foreach ($breakresponse as $resp) {
            $againbreak = explode("=", $resp);
            $resparray[$againbreak[0]] = urldecode($againbreak[1]);
        }

        $udata = get_user_info($uid);
        $ddata = check_donation($temptransdata->transactionid);
        if ($ddata->transaction_id === $temptransdata->transactionid) {
            $data['donation'] = $ddata;
        } else {
            $donationArray = array(
                "branch" => $udata[0]->userbranch,
                "cell" => $udata[0]->usercell,
                "church_title" => $udata[0]->userchurchtitle,
                "currency" => "ZWL",
                "donation_by" => $uid,
                "donation_amount" => $temptransdata->amount,
                "donation_mode" => $temptransdata->payment_mode,
                "transaction_id" => $temptransdata->transactionid,
                "event_id" => $temptransdata->programmeid,
                "paynowreference" => $resparray['paynowreference'],
                "description" => $temptransdata->description,
                "status" => $resparray['status'],
                "pollurl" => $resparray['pollurl'],
                "hash" => $resparray['hash'],
                "final_status" => 1
            );
            $this->db->insert('snr_donation', $donationArray);
            $data['donation'] = $donationArray;
        }

        $data['pdata'] = $resparray;

        $this->load->view('admin/paymentsuccess', $data);
    }

    public function paymentresponsepolicy($uid, $referenceid, $purchaseid)
    {
        $conditions = array("user_id" => $uid, "transaction_id" => $referenceid, "purchase_id" => $purchaseid);
        $transdata = $this->AdminModel->get_trans_data($conditions);

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://www.paynow.co.zw/Interface/CheckPayment/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => explode("?", $transdata->poll_url)[1],
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);

        $resparray = array();
        $breakresponse = explode("&", $response);
        foreach ($breakresponse as $resp) {
            $againbreak = explode("=", $resp);
            $resparray[$againbreak[0]] = urldecode($againbreak[1]);
        }

        $transactionArray = array(
            "final_status" => "1",
            "reference_num" => $resparray['paynowreference']
        );
        $this->db->where("id", $transdata->id);
        $this->db->update('snr_transactions', $transactionArray);

        $transactionArray2 = array(
            "status" => "1",
        );
        $this->db->where("id", $purchaseid);
        $this->db->update('snr_policypurchase', $transactionArray2);


        $transdatafinal = $this->AdminModel->get_trans_data($conditions);

        $donationArray = array(
            "not_title" => 'Payment Successful',
            "not_msg" => 'You have successfully purchased policy ' . policy_info($transdatafinal->policy_id)->policy_title . ' for next ' . $transdatafinal->payment_frequency . 'Month(s). Your next payment date is ' . $transdatafinal->next_date,
            "not_uid" => $uid,
            "is_read" => '0'
        );
        $this->db->insert('snr_notifications', $donationArray);

        $data['transaction'] = $transdatafinal;

        $data['pdata'] = $resparray;

        $this->load->view('admin/paymentsuccesspolicy', $data);
    }
}