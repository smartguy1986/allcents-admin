<?php
header('Access-Control-Allow-Origin: *');
require APPPATH . 'libraries/REST_Controller.php';
class Payments extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function index_get($lang = null)
    {

    }
    public function requestpayment_post()
    {
        $amount = $this->input->post('amount');
        $userid = $this->input->post('userid');
        $paymentmode = $this->input->post('paymentmode');
        $programmeid = $this->input->post('programmeid');
        $udata = getuserdata($userid);
        $additionalinfo = $udata->usertitle . ' ' . $udata->userfname . ' ' . $udata->userlname . ' making a payment of ' . $amount . ' via ' . $paymentmode;
        $reference = substr(time(), -6) . openssl_random_pseudo_bytes(8);
        $reference = substr(bin2hex($reference), 8);

        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral App';

        $main_arr['info']['description'] = 'Payment Gateway URL Generation for donation';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        if (strtolower($paymentmode) == 'cash') {
            $log_array = array(
                "user_id" => $userid,
                "tohash" => "",
                "hash" => "",
                "status" => "Ok",
                "browserurl" => "",
                "pollurl" => "",
                "programmeid" => $programmeid,
                "payment_mode" => $paymentmode,
                "amount" => $amount,
                "transactionid" => "AB" . strtoupper($reference),
                "description" => $additionalinfo
            );
            $this->db->insert('snr_temp_trans', $log_array);

            $udata = get_user_info($userid);
            $donationArray = array(
                "branch" => $udata[0]->userbranch,
                "cell" => $udata[0]->usercell,
                "church_title" => $udata[0]->userchurchtitle,
                "currency" => "ZWL",
                "donation_by" => $userid,
                "donation_amount" => $amount,
                "donation_mode" => $paymentmode,
                "transaction_id" => "AB" . strtoupper($reference),
                "event_id" => $programmeid,
                "paynowreference" => "",
                "description" => $additionalinfo,
                "status" => "Cash Payment",
                "pollurl" => "",
                "hash" => "",
                "final_status" => 0
            );
            $this->db->insert('snr_donation', $donationArray);

            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['message'] = 'You have selected Cash mode for your donation of $ ' . $amount . '. Please donate the amount to your Church treasurer. Once your payment is recognised and registered you will get a SMS confirming the same. Thank You.';
            $main_arr['info']['response']['data'] = '';
        } else if (strtolower($paymentmode) == 'card') {
            $returnurl = "https://www.allcents.tech/demo/backend/admin/paymentresponse/" . $userid;
            $tohash = "15802" . "AB" . strtoupper($reference) . $amount . $additionalinfo . $returnurl . $returnurl . 'message370b867c-4805-4841-8335-01447a3f9c63';
            $hashkey = strtoupper(hash('sha512', $tohash));

            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => 'https://www.paynow.co.zw/interface/initiatetransaction',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => 'id=15802&reference=AB' . strtoupper($reference) . '&amount=' . $amount . '&additionalinfo=' . urlencode($additionalinfo) . '&returnurl=' . urlencode($returnurl) . '&resulturl=' . urlencode($returnurl) . '&status=message&hash=' . $hashkey,
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
                array_push($resparray, array($againbreak[0] => urldecode($againbreak[1])));
            }

            if (strtolower($resparray[0]['status']) == 'ok') {
                $log_array = array(
                    "user_id" => $userid,
                    "tohash" => $tohash,
                    "hash" => $hashkey,
                    "status" => $resparray[0]['status'],
                    "browserurl" => $resparray[1]['browserurl'],
                    "pollurl" => $resparray[2]['pollurl'],
                    "programmeid" => $programmeid,
                    "payment_mode" => $paymentmode,
                    "amount" => $amount,
                    "transactionid" => "AB" . strtoupper($reference),
                    "description" => $additionalinfo
                );
                $this->db->insert('snr_temp_trans', $log_array);

                $val['tohash'] = $tohash;
                $val['hash'] = $hashkey;
                $val['apidata'] = $resparray;

                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['data'] = $val;
                $main_arr['info']['response']['message'] = '';

                storemylog("Payment Gateway URL Generation for donation", "api/v1/payments/requestpayments", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($val));
            } else {
                $main_arr['info']['response']['status'] = '0';
                $main_arr['info']['response']['data'] = '';
                $main_arr['info']['response']['message'] = 'Payment was not successful. Please try again.';

                storemylog("Payment Gateway URL Generation for donation", "api/v1/payments/requestpayments", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'Payment was not successful. Please try again.');
            }
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = '';
            $main_arr['info']['response']['message'] = 'Payment mode not supported';

            storemylog("Payment Gateway URL Generation for donation", "api/v1/payments/requestpayments", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'Payment mode not supported');
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function makecashpayment_post()
    {
        $userid = $this->input->post('treasurerid');
        $treasurerid = $this->input->post('userid');
        $amount = $this->input->post('cashamount');

        $udata = getuserdata($userid);
        $udata2 = getuserdata($treasurerid);
        $additionalinfo = 'Treasurer ' . $udata2->usertitle . ' ' . $udata2->userfname . ' ' . $udata2->userlname . ' is registering a cash payment on behalf of ' . $udata->usertitle . ' ' . $udata->userfname . ' ' . $udata->userlname . ' of amount ' . $amount;
        $reference = substr(time(), -6) . openssl_random_pseudo_bytes(8);
        $reference = substr(bin2hex($reference), 8);

        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral App';

        $main_arr['info']['description'] = 'Cash Payment by Treasurer on behalf of User';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $log_array = array(
            "user_id" => $userid,
            "tohash" => "",
            "hash" => "",
            "status" => "Ok",
            "browserurl" => "",
            "pollurl" => "",
            "programmeid" => "Cash",
            "payment_mode" => "",
            "amount" => $amount,
            "transactionid" => "AB" . strtoupper($reference),
            "description" => $additionalinfo
        );
        $this->db->insert('snr_temp_trans', $log_array);

        $udata3 = get_user_info($userid);
        $donationArray = array(
            "treasurer" => $treasurerid,
            "branch" => $udata3[0]->userbranch,
            "cell" => $udata3[0]->usercell,
            "church_title" => $udata3[0]->userchurchtitle,
            "currency" => "ZWL",
            "donation_by" => $userid,
            "donation_amount" => $amount,
            "donation_mode" => "Cash",
            "transaction_id" => "AB" . strtoupper($reference),
            "event_id" => "",
            "paynowreference" => "",
            "description" => $additionalinfo,
            "status" => "Cash Payment",
            "pollurl" => "",
            "hash" => "",
            "final_status" => 1
        );
        $this->db->insert('snr_donation', $donationArray);

        $main_arr['info']['response']['status'] = '1';
        $main_arr['info']['response']['message'] = 'Thank you for registering cash donation on behalf of ' . $udata->usertitle . ' ' . $udata->userfname . ' ' . $udata->userlname;
        $main_arr['info']['response']['data'] = '';

        storemylog("Cash Payment by Treasurer on behalf of User", "api/v1/payments/makecashpayment", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], 'Thank you for registering cash donation on behalf of ' . $udata->usertitle . ' ' . $udata->userfname . ' ' . $udata->userlname);

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }
}