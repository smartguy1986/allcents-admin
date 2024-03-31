<?php
header('Access-Control-Allow-Origin: *');
require APPPATH . 'libraries/REST_Controller.php';
class Funeral extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // public function index_post()
    // {

    // }

    public function funeralpage_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'Content Details of user\'s Funeral page';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $this->db->select('*');
        $qr = $this->db->get('snr_admin');
        $admin_cont = $qr->row();

        $usertoken = $this->input->post('usertoken');

        $this->db->select('*');
        $this->db->where('usertoken', $usertoken);
        $qr = $this->db->get('snr_users');
        $userdata = $qr->row();

        if (empty($userdata)) {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['message'] = 'Token Mismatch';
            $main_arr['info']['response']['data'] = '';
        } else {
            $data = array(
                "logo_link" => base_url() . "uploads/admin/" . $admin_cont->admin_image,
                "options" => array(
                    array("title" => "Activate", "tagline" => ""),
                    array("title" => "Fund Details", "tagline" => ""),
                    array("title" => "Transaction History", "tagline" => ""),
                    array("title" => "Claims", "tagline" => ""),
                ),
                "userdata" => array(
                    "title" => $userdata->usertitle,
                    "first_name" => $userdata->userfname,
                    "last_name" => $userdata->userlname,
                )
            );

            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['message'] = 'Executed Successfully';
            $main_arr['info']['response']['data'] = $data;

            storemylog("'Content Details of user\'s Funeral page'", "api/v2/funeral/funeralpage", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($data));
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function policylist_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'List of Funeral Policies';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $userid = $this->input->post('userid');

        $this->db->select('policy_id');
        $this->db->where('user_id', $userid);
        $this->db->where('status', '1');
        $qrp = $this->db->get('snr_shortlist');
        $shortlist = $qrp->result();
        $shortlist = array_column($shortlist, 'policy_id');

        $this->db->select('*');
        $this->db->where('policy_status', '1');
        $qr = $this->db->get('snr_policies');
        $policies = $qr->result();

        if (empty($policies)) {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['message'] = 'No Policy Found';
            $main_arr['info']['response']['data'] = '';

            storemylog("List of Funeral Policies", "api/v2/funeral/policylist",  "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'No Policy Found');
        } else {
            foreach ($policies as $policy) {
                if (in_array($policy->id, $shortlist, TRUE)) {
                    $policy->shortlist = "1";
                } else {
                    $policy->shortlist = "0";
                }
                $policy->currency_symbol = "$";
                $this->db->select('*');
                $this->db->where('policy_id', $policy->id);
                $qr2 = $this->db->get('snr_policyfiles');
                $policyfiles = $qr2->result();
                foreach ($policyfiles as $plf) {
                    $plf->filepath = base_url() . 'uploads/policies/' . $plf->file_name;
                }
                $policy->files = $policyfiles;
                $policy->policy_logo = base_url() . 'uploads/policies/' . $policy->policy_logo;

                // $policy->policy_premium = "$ " . $policy->policy_premium;
            }

            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['message'] = 'Executed Successfully';
            $main_arr['info']['response']['data'] = $policies;

            storemylog("List of Funeral Policies", "api/v2/funeral/policylist",  "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($policies));
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function policylist_treasurer_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'List of Funeral Policies for Treasurer';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $this->db->select('*');
        $this->db->where('policy_status', '1');
        $qr = $this->db->get('snr_policies');
        $policies = $qr->result();

        if (empty($policies)) {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['message'] = 'No Policy Found';
            $main_arr['info']['response']['data'] = '';

            storemylog("List of Funeral Policies for Treasure", "api/v2/funeral/policylist_treasurer", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'No Policy Found');
        } else {
            foreach ($policies as $policy) {
                $this->db->select('*');
                $this->db->where('policy_id', $policy->id);
                $qr2 = $this->db->get('snr_policyfiles');
                $policyfiles = $qr2->result();
                foreach ($policyfiles as $plf) {
                    $plf->filepath = base_url() . 'uploads/policies/' . $plf->file_name;
                }
                $policy->files = $policyfiles;
                $policy->policy_logo = base_url() . 'uploads/policies/' . $policy->policy_logo;
            }

            $userlist = get_recent_users();
            $udata = array();
            foreach ($userlist as $ulist) {
                array_push($udata, array("uid" => $ulist->id, "name" => $ulist->usertitle . ' ' . $ulist->userfname . ' ' . $ulist->userlname, "membershipid" => $ulist->uniqueid));
            }
            array_push($policies, array('userlist' => $udata));

            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['message'] = 'Executed Successfully';
            $main_arr['info']['response']['data'] = $policies;

            storemylog("List of Funeral Policies for Treasure", "api/v2/funeral/policylist_treasurer", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($policies));

        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function shortlist_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'Shortlist / Unshortlist of policy by User';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $userid = $this->input->post('userid');
        $policyid = $this->input->post('policyid');

        $this->db->select('*');
        $this->db->where(array("policy_id" => $policyid, "user_id" => $userid));
        $qr = $this->db->get('snr_shortlist');
        $shortlisted = $qr->row();

        if (empty($shortlisted)) {
            $val = array(
                "policy_id" => $policyid,
                "user_id" => $userid,
                "status" => '1'
            );

            $this->db->insert('snr_shortlist', $val);
            $res = $this->db->affected_rows();

            if ($res) {
                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['message'] = 'Policy shortlisted successfully';
                $main_arr['info']['response']['data'] = '';

                storemylog("Shortlist / Unshortlist of policy by User", "api/v2/funeral/shortlist", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], 'Policy shortlisted successfully');
            } else {
                $main_arr['info']['response']['status'] = '0';
                $main_arr['info']['response']['message'] = 'Policy not shortlisted. Try Again.';
                $main_arr['info']['response']['data'] = '';

                storemylog("Shortlist / Unshortlist of policy by User", "api/v2/funeral/shortlist", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'Policy not shortlisted. Try Again.');
            }

        } else {
            $val = array(
                "status" => ($shortlisted->status == '1') ? '0' : '1'
            );

            $this->db->where('id', $shortlisted->id);
            $this->db->update('snr_shortlist', $val);
            $res = $this->db->affected_rows();

            if ($res) {
                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['message'] = ($shortlisted->status == '1') ? 'Policy unshortlisted successfully' : 'Policy shortlisted successfully';
                $main_arr['info']['response']['data'] = '';
                storemylog("Shortlist / Unshortlist of policy by User", "api/v2/funeral/shortlist", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], ($shortlisted->status == '1') ? 'Policy unshortlisted successfully' : 'Policy shortlisted successfully');
            } else {
                $main_arr['info']['response']['status'] = '0';
                $main_arr['info']['response']['message'] = 'Technical problem. Try Again.';
                $main_arr['info']['response']['data'] = '';
                storemylog("Shortlist / Unshortlist of policy by User", "api/v2/funeral/shortlist", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'Policy not shortlisted. Try Again.');
            }
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function policydetails_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'Policy Details';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $userid = $this->input->post('userid');
        $userdata = get_user_info($userid);

        $policyid = $this->input->post('policyid');

        $this->db->select('*');
        $this->db->where('id', $policyid);
        $qr = $this->db->get('snr_policies');
        $policy_details = $qr->row();

        $this->db->select('*');
        $this->db->where('policy_id', $policyid);
        $this->db->order_by('added_on', 'DESC');
        $qr2 = $this->db->get('snr_policyfiles');
        $policy_files = $qr2->result();

        $pfarray = array();
        foreach ($policy_files as $pf) {
            array_push($pfarray, array("policy_file_path" => base_url() . 'uploads/policies/' . $pf->file_name));
        }

        $policy = array(
            "membership_id" => $userdata[0]->uniqueid,
            "policy_logo" => base_url() . 'uploads/policies/' . $policy_details->policy_logo,
            "policy_files" => $pfarray,
            "policy_title" => $policy_details->policy_title,
            "policy_payout" => '$ ' . $policy_details->policy_payout,
            "policy_covers" => $policy_details->policy_member,
            "policy_premium" => '$ ' . $policy_details->policy_premium,
            "policy_waiting" => $policy_details->policy_waiting . ' Months',
            "policy_claim" => '*' . $policy_details->policy_claim,
            "policy_description" => $policy_details->policy_description,
        );

        $data['policy_details'] = $policy;

        $this->db->select('*');
        $this->db->where(array("policy_id" => $policyid, "user_id" => $userid));
        $qr = $this->db->get('snr_shortlist');
        $shortlisted = $qr->row();

        if (empty($shortlisted->status)) {
            $data['shortlisted'] = '0';
        } else {
            ($shortlisted->status == '0') ? $data['shortlisted'] = '0' : $data['shortlisted'] = '1';
        }

        $main_arr['info']['response']['status'] = '1';
        $main_arr['info']['response']['message'] = 'Executed Successfully';
        $main_arr['info']['response']['data'] = $data;
        storemylog("Policy Details", "api/v2/funeral/policydetails", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($data));

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function policypurchase_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'Policy Purchase Page';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $userid = $this->input->post('userid');
        $userdata = get_user_info($userid);

        $policyid = $this->input->post('policyid');

        $this->db->select('*');
        $this->db->where('id', $policyid);
        $qr = $this->db->get('snr_policies');
        $policy_details = $qr->row();

        $policy = array(
            "membership_id" => $userdata[0]->uniqueid,
            "heading_text" => "You are paying for " . $policy_details->policy_title,
            "policy_logo" => base_url() . 'uploads/policies/' . $policy_details->policy_logo,
            "policy_title" => $policy_details->policy_title,
            "policy_payout" => '$ ' . $policy_details->policy_payout,
            "radio_buttons" => ($policy_details->single == 1) ? array("SELF") : array("SELF + SPOUSE", "FAMILY", "PARENTS", "CHILDREN"),
            "payment_frequency" => array("1", "3", "6", "12"),
            "policy_premium" => $policy_details->policy_premium,
            "policy_coverage" => $policy_details->policy_member,
            "currency_symbol" => "$",
        );

        $data['policy_details'] = $policy;

        $main_arr['info']['response']['status'] = '1';
        $main_arr['info']['response']['message'] = 'Executed Successfully';
        $main_arr['info']['response']['data'] = $data;
        storemylog("Policy Purchase Page", "api/v2/funeral/policypurchasepage", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($data));

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function policypayment_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'Policy Payment';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $insertId = 0;
        $userid = $this->input->post('userid');
        $policyid = $this->input->post('policyid');
        $amount = $this->input->post('amount');
        $frequency = $this->input->post('frequency');
        $purchase_for = $this->input->post('purchase_for');
        $payment_mode = $this->input->post('payment_mode');

        $checkPolicy_purchase = checkpolicypurchase(array("policy_id" => $policyid, "user_id" => $userid));

        if (empty($checkPolicy_purchase)) {
            $inserArray = array(
                "policy_id" => $policyid,
                "user_id" => $userid,
                "frequency" => $frequency
            );

            $this->db->insert('snr_policypurchase', $inserArray);
            $insertId = $this->db->insert_id();
        } else {
            $insertId = $checkPolicy_purchase->id;

        }
        $udata = get_user_info($userid);

        $this->db->select('*');
        $this->db->where('id', $policyid);
        $qr = $this->db->get('snr_policies');
        $policy_details = $qr->row();

        $reference = substr(time(), -6) . openssl_random_pseudo_bytes(8);
        $reference = substr(bin2hex($reference), 8);

        if (strtolower($payment_mode) == 'cash') {
            $transactionArray = array(
                "purchase_id" => $insertId,
                "policy_id" => $policyid,
                "user_id" => $userid,
                "gross_amount" => $amount,
                "next_date" => date("Y-m-d", strtotime("+" . $frequency . " months")),
                "payment_frequency" => $frequency,
                "payment_mode" => "Cash",
                "purchase_for" => $purchase_for,
                "policy_num" => $policy_details->policy_id,
                "premium_amount" => $amount,
                "transaction_id" => strtoupper($reference),
                "final_status" => "0"
            );
            $this->db->insert('snr_transactions', $transactionArray);

            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['message'] = 'You have selected Cash mode for your policy purchase of $' . $amount . '. Please donate the amount to your Church treasurer. Once your payment is registered by the treasurer you will get confirmation.';
            $main_arr['info']['response']['data'] = $transactionArray;

            storemylog("Policy Payment", "api/v2/funeral/policypayment", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($transactionArray));

        } else if (strtolower($payment_mode) == 'card') {
            $additionalinfo = $udata[0]->usertitle . ' ' . $udata[0]->userfname . ' ' . $udata[0]->userlname . ' making a payment of $' . $amount . ' via ' . $payment_mode;
            $returnurl = "https://www.allcents.tech/demo/backend/admin/paymentresponsepolicy/" . $userid . '/' . strtoupper($reference) . '/' . $insertId;
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
                $transactionArray = array(
                    "purchase_id" => $insertId,
                    "policy_id" => $policyid,
                    "user_id" => $userid,
                    "gross_amount" => $amount,
                    "next_date" => date("Y-m-d", strtotime("+" . $frequency . " months")),
                    "payment_frequency" => $frequency,
                    "payment_mode" => "Card",
                    "purchase_for" => $purchase_for,
                    "policy_num" => $policy_details->policy_id,
                    "premium_amount" => $amount,
                    "transaction_id" => strtoupper($reference),
                    "final_status" => "0",
                    "payment_url" => $resparray[1]['browserurl'],
                    "poll_url" => $resparray[2]['pollurl'],
                );
                $this->db->insert('snr_transactions', $transactionArray);

                $val['tohash'] = $tohash;
                $val['hash'] = $hashkey;
                $val['apidata'] = $resparray;

                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['data'] = $val;
                $main_arr['info']['response']['message'] = '';

                storemylog("Policy Payment", "api/v2/funeral/policypayment", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($val));
            } else {
                $main_arr['info']['response']['status'] = '0';
                $main_arr['info']['response']['data'] = '';
                $main_arr['info']['response']['message'] = 'Payment was not successful. please try again.';

                storemylog("Policy Payment", "api/v2/funeral/policypayment", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'Payment was not successful. please try again.');
            }
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = '';
            $main_arr['info']['response']['message'] = 'Payment mode not supported';

            storemylog("Policy Payment", "api/v2/funeral/policypayment", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'Payment mode not supported');
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function policypayment_treasurer_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'Policy Payment for Treasurer';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $treasurer = $this->input->post('treasurer');
        $userid = $this->input->post('userid');
        $udata = get_user_info($userid);

        $policyid = $this->input->post('policyid');

        $this->db->select('*');
        $this->db->where('id', $policyid);
        $qr = $this->db->get('snr_policies');
        $policy_details = $qr->row();

        $amount = $this->input->post('amount');
        $frequency = $this->input->post('frequency');
        $purchase_for = $this->input->post('purchase_for');
        $payment_mode = $this->input->post('payment_mode');

        $reference = substr(time(), -6) . openssl_random_pseudo_bytes(8);
        $reference = substr(bin2hex($reference), 8);

        if (strtolower($payment_mode) == 'cash') {
            $transactionArray = array(
                "policy_id" => $policyid,
                "user_id" => $userid,
                "gross_amount" => $amount,
                "next_date" => date("Y-m-d", strtotime("+" . $frequency . " months")),
                "payment_frequency" => $frequency,
                "payment_mode" => "Cash",
                "purchase_for" => $purchase_for,
                "policy_num" => $policy_details->policy_id,
                "premium_amount" => $amount,
                "transaction_id" => strtoupper($reference),
                "treasurer" => $treasurer,
                "final_status" => "0"
            );
            $this->db->insert('snr_transactions', $transactionArray);

            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['message'] = ($treasurer > 0) ? 'You have selected Cash mode for policy purchase of ' . $amount . ' on behalf of ' . $udata[0]->usertitle . ' ' . $udata[0]->userfname . ' ' . $udata[0]->userlname . '. Once your payment is recognised and registered user will get notifications confirming the same. Thank You.' : 'You have selected Cash mode for your policy purchase of ' . $amount . '. Please donate the amount to your Church treasurer. Once your payment is recognised and registered you will get notifications confirming the same. Thank You.';
            $main_arr['info']['response']['data'] = '';

        } else if (strtolower($payment_mode) == 'card') {
            $additionalinfo = $udata[0]->usertitle . ' ' . $udata[0]->userfname . ' ' . $udata[0]->userlname . ' making a payment of ' . $amount . ' via ' . $payment_mode;
            $returnurl = "https://www.allcents.tech/demo/backend/admin/paymentresponsepolicy/" . $userid;
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
                $transactionArray = array(
                    "policy_id" => $policyid,
                    "user_id" => $userid,
                    "gross_amount" => $amount,
                    "next_date" => date("Y-m-d", strtotime("+" . $frequency . " months")),
                    "payment_frequency" => $frequency,
                    "payment_mode" => "Card",
                    "purchase_for" => $purchase_for,
                    "policy_num" => $policy_details->policy_id,
                    "premium_amount" => $amount,
                    "transaction_id" => strtoupper($reference),
                    "treasurer" => $treasurer,
                    "final_status" => "0",
                    "payment_url" => $resparray[1]['browserurl'],
                    "poll_url" => $resparray[2]['pollurl'],
                );
                $this->db->insert('snr_transactions', $transactionArray);

                $val['tohash'] = $tohash;
                $val['hash'] = $hashkey;
                $val['apidata'] = $resparray;

                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['data'] = $val;
                $main_arr['info']['response']['message'] = '';
            } else {
                $main_arr['info']['response']['status'] = '0';
                $main_arr['info']['response']['data'] = '';
                $main_arr['info']['response']['message'] = 'Payment was not successful. Please try again.';
            }
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = '';
            $main_arr['info']['response']['message'] = 'Payment mode not supported';
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function activepolicy_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'Active Policy Lists';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $userid = $this->input->post('userid');

        $this->db->select('snr_policypurchase.*, snr_policies.policy_logo, snr_policies.policy_title, snr_policies.policy_title, snr_policies.policy_premium, snr_policies.policy_payout, snr_policies.policy_waiting, snr_policies.policy_description');
        $this->db->join('snr_policies', 'snr_policies.id = snr_policypurchase.policy_id');
        $this->db->where("snr_policypurchase.status", '1');
        $this->db->where("snr_policypurchase.user_id", $userid);
        $this->db->from('snr_policypurchase');
        $query = $this->db->get();
        $policy_list = $query->result();

        // print_r($policy_list);

        $policies = array();
        foreach ($policy_list as $pol) {
            $val = array();

            $this->db->select('*');
            $this->db->where('policy_id', $pol->policy_id);
            $this->db->order_by('added_on', 'DESC');
            $qr2 = $this->db->get('snr_policyfiles');
            $policy_files = $qr2->result();

            $pfarray = array();
            foreach ($policy_files as $pf) {
                array_push($pfarray, array("policy_file_path" => base_url() . 'uploads/policies/' . $pf->file_name));
            }

            $this->db->select('snr_transactions.next_date');
            $this->db->from('snr_transactions');
            $this->db->where(array('snr_transactions.purchase_id' => $pol->id, 'snr_transactions.user_id' => $pol->user_id));
            $this->db->order_by('added_on', 'DESC');
            $this->db->limit(1);
            $querypt = $this->db->get();
            $trans_list = $querypt->row();

            $val = array(
                "id" => $pol->id,
                "policy_logo" => base_url() . 'uploads/policies/' . $pol->policy_logo,
                "policy_title" => $pol->policy_title,
                "premium" => $pol->policy_premium,
                "last_payment" => substr($pol->updated_on, 0, 10),
                "next_date" => $trans_list->next_date,
                "payout" => $pol->policy_payout,
                "description" => $pol->policy_description,
                "waiting" => $pol->policy_waiting . " months",
                "currency_symbol" => "$",
                "policy_frequency" => $pol->frequency . " months",
                "files" => $pfarray
            );

            array_push($policies, $val);
        }

        $data['policy_list'] = $policies;

        $main_arr['info']['response']['status'] = '1';
        $main_arr['info']['response']['message'] = 'Executed Successfully';
        $main_arr['info']['response']['data'] = $data;

        storemylog("Active Policy Lists", "api/v2/funeral/activepolicy", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($data));

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function claimspolicy_list_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'Policy list for Claims';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $userid = $this->input->post('userid');

        $this->db->select('snr_transactions.*, snr_policies.*');
        $this->db->join('snr_policies', 'snr_policies.id = snr_transactions.policy_id');
        $this->db->where("snr_transactions.final_status", '1');
        $this->db->from('snr_transactions');
        $query = $this->db->get();
        $policy_list = $query->result();

        $policies = array();
        foreach ($policy_list as $pol) {
            $val = array(
                "id" => $pol->id,
                "policy_title" => $pol->policy_title,
                "policy_num" => $pol->policy_id
            );

            array_push($policies, $val);
        }

        $data['policy_list'] = $policies;

        $main_arr['info']['response']['status'] = '1';
        $main_arr['info']['response']['message'] = 'Executed Successfully';
        $main_arr['info']['response']['data'] = $data;

        storemylog("Policy list dropdown for Claims", "api/v2/funeral/claimpolicy_list", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($data));

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function raiseclaim_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'Raise Claims';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        if (!empty($_FILES['document_1']['name'])) {
            $this->load->library('upload');

            $filename = sha1(time() . $_FILES['document_1']['name']);
            $config['upload_path'] = FCPATH . '/uploads/claims/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|xls|xlsx|ppt|pptx';
            $config['max_size'] = '409600';
            $config['file_name'] = $filename;
            $config['create_thumb'] = TRUE;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('document_1')) {
                $imageDetailArray = $this->upload->data();
                $document_1 = $imageDetailArray['file_name'];
            }
        }

        if (!empty($_FILES['document_2']['name'])) {
            $this->load->library('upload');

            $filename = sha1(time() . $_FILES['document_2']['name']);
            $config['upload_path'] = FCPATH . '/uploads/claims/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|xls|xlsx|ppt|pptx';
            $config['max_size'] = '409600';
            $config['file_name'] = $filename;
            $config['create_thumb'] = TRUE;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('document_2')) {
                $imageDetailArray2 = $this->upload->data();
                $document_2 = $imageDetailArray2['file_name'];
            }
        }

        if (!empty($_FILES['document_3']['name'])) {
            $this->load->library('upload');

            $filename = sha1(time() . $_FILES['document_3']['name']);
            $config['upload_path'] = FCPATH . '/uploads/claims/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|xls|xlsx|ppt|pptx';
            $config['max_size'] = '409600';
            $config['file_name'] = $filename;
            $config['create_thumb'] = TRUE;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('document_3')) {
                $imageDetailArray3 = $this->upload->data();
                $document_3 = $imageDetailArray3['file_name'];
            }
        }

        $val = array(
            "userid" => $this->input->post('userid'),
            "policy_id" => $this->input->post('policy_id'),
            "policy_num" => $this->input->post('policy_num'),
            "name_of_deseased" => $this->input->post('name_of_deseased'),
            "cause_of_death" => $this->input->post('cause_of_death'),
            "dob" => $this->input->post('dob'),
            "dod" => $this->input->post('dod'),
            "document_1" => $document_1,
            "document_2" => $document_2,
            "document_3" => $document_3,
            "claimant_name" => $this->input->post('claimant_name'),
            "claimant_phone" => $this->input->post('claimant_phone'),
            "claimant_email" => $this->input->post('claimant_email'),
            "claimant_address" => $this->input->post('claimant_address')
        );

        $this->db->insert('snr_claims', $val);
        $res = $this->db->affected_rows();

        if ($res) {
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['message'] = 'Claim raised successfully';
            $main_arr['info']['response']['data'] = '';

            storemylog("Raise Claims", "api/v2/funeral/raiseclaim", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], 'Claim raised successfully');
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['message'] = 'Claim not raised. Try Again.';
            $main_arr['info']['response']['data'] = '';

            storemylog("Raise Claims", "api/v2/funeral/raiseclaim", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'Claim not raised. Try Again.');
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function claimlist_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'Claims List';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $userid = $this->input->post('userid');

        $this->db->select('*');
        $this->db->where('userid', $userid);
        $this->db->order_by('added_on', 'DESC');
        $qr2 = $this->db->get('snr_claims');
        $claimslist = $qr2->result();

        $claims = array();
        foreach ($claimslist as $clm) {
            array_push(
                $claims,
                array(
                    "policy_no" => $clm->policy_num,
                    "name_of_deseased" => $clm->name_of_deseased,
                    "dod" => $clm->dod,
                    "files" => array(base_url() . 'uploads/claims/' . $clm->document_1, base_url() . 'uploads/claims/' . $clm->document_2, base_url() . 'uploads/claims/' . $clm->document_3),
                    "raised_on" => $clm->added_on
                )
            );
        }

        if (!empty($claims)) {
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['message'] = '';
            $main_arr['info']['response']['data'] = $claims;

            storemylog("Claims List", "api/v2/funeral/claimlist", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($claims));
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['message'] = 'No claims raised.';
            $main_arr['info']['response']['data'] = $claims;

            storemylog("Claims List", "api/v2/funeral/claimlist", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'No claims found.');
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

}