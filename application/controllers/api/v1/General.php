<?php
header('Access-Control-Allow-Origin: *');
require APPPATH . 'libraries/REST_Controller.php';
class General extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function index_get($lang = null)
    {

    }

    public function homepage_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'Content Details of APP\'s home page';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $this->db->select('*');
        $qr = $this->db->get('snr_admin');
        $admin_cont = $qr->row();

        $main_arr['info']['language'] = 'English';

        $data = array(
            "logo_link" => base_url() . "uploads/admin/" . $admin_cont->admin_image,
            "main_heading" => $admin_cont->admin_name,
            "main_text" => $admin_cont->admin_bio_en,
            "button_text" => "Login",
        );

        $main_arr['info']['response']['status'] = '1';
        $main_arr['info']['response']['message'] = 'Executed Successfully';
        $main_arr['info']['response']['data'] = $data;

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function loginpage_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'Content Details of APP\'s login page';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $this->db->select('*');
        $qr = $this->db->get('snr_admin');
        $admin_cont = $qr->row();

        $main_arr['info']['language'] = 'English';

        $data = array(
            "logo_link" => base_url() . "uploads/admin/" . $admin_cont->admin_image,
            "main_heading" => "Login with your registered phone number and password",
            "button_text" => "Login",
        );

        $main_arr['info']['response']['status'] = '1';
        $main_arr['info']['response']['message'] = 'Executed Successfully';
        $main_arr['info']['response']['data'] = $data;

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function countries_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'Country and Province Details';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $this->db->select('*');
        $qr = $this->db->get('snr_countries');
        $data = $qr->result();

        $i = 0;
        foreach ($data as $country) {
            $this->db->select('*');
            $this->db->where('country', $country->id);
            $cqr = $this->db->get('snr_province');
            $cdata = $cqr->result();
            $j = 0;
            foreach ($cdata as $province) {
                $this->db->select('*');
                $this->db->where('province_name', $province->provincename);
                $dqr = $this->db->get('snr_districts');
                $dddata = $dqr->result();
                $cdata[$j]->district = $dddata;
                $j++;
            }
            $data[$i]->province = $cdata;
            $i++;
        }

        $main_arr['info']['response']['status'] = '1';
        $main_arr['info']['response']['message'] = 'Executed Successfully';
        $main_arr['info']['response']['data'] = $data;

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function createuserpage_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'Country, Province, District and Branch, Cell Lists';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $this->db->select('*');
        $qr = $this->db->get('snr_countries');
        $countrylist = $qr->result();

        $i = 0;
        foreach ($countrylist as $country) {
            $this->db->select('*');
            $this->db->where('country', $country->id);
            $cqr = $this->db->get('snr_province');
            $cprovince = $cqr->result();
            $j = 0;
            foreach ($cprovince as $province) {
                $this->db->select('*');
                $this->db->where('province_name', $province->provincename);
                $dqr = $this->db->get('snr_districts');
                $cdistrict = $dqr->result();
                $cprovince[$j]->district = $cdistrict;
                $j++;
            }
            $countrylist[$i]->province = $cprovince;
            $i++;
        }

        $this->db->select('*');
        $qr2 = $this->db->get('snr_branches');
        $cbranch = $qr2->result();

        $this->db->select('*');
        $qr3 = $this->db->get('snr_cells');
        $ccell = $qr3->result();

        $data['branches'] = $cbranch;
        $data['cells'] = $ccell;
        $data['countries'] = $countrylist;

        $main_arr['info']['response']['status'] = '1';
        $main_arr['info']['response']['message'] = 'Executed Successfully';
        $main_arr['info']['response']['data'] = $data;

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function dashboard_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'Content Details of user\'s Dashboard page';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $this->db->select('*');
        $qr = $this->db->get('snr_admin');
        $admin_cont = $qr->row();

        $this->db->select('*');
        $qrc = $this->db->get('snr_calendar');
        $calendar = $qrc->row();

        $usertoken = $this->input->post('usertoken');

        $this->db->select('*');
        $this->db->where('usertoken', $usertoken);
        $qr = $this->db->get('snr_users');
        $userdata = $qr->row();

        if (empty($userdata)) {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['message'] = 'Token Mismatch';
            $main_arr['info']['response']['data'] = '';

            storemylog("Content Details of user\'s Dashboard page", "api/v1/general/dashboard", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'Token Mismatch');
        } else {
            if ($userdata->userrole == 2) {
                $data = array(
                    "logo_link" => base_url() . "uploads/admin/" . $admin_cont->admin_image,
                    "main_image" => base_url() . "uploads/admin/church_bishop.jpg",
                    "main_heading" => $admin_cont->admin_name,
                    "options" => array(
                        array("title" => "Membership", "tagline" => "View membership details."),
                        array("title" => "Church Calendar", "tagline" => "All Church meetings schedule", "image" => base_url('uploads/admin/') . $calendar->calendar_image),
                        array("title" => "Donations", "tagline" => "View church programmes and participate."),
                        array("title" => "Funeral Fund", "tagline" => "View church funeral plan options, pay premiums and view policies."),
                        array("title" => "Notices", "tagline" => "View church news and updates."),
                    ),
                    "userdata" => array(
                        "title" => $userdata->usertitle,
                        "first_name" => $userdata->userfname,
                        "last_name" => $userdata->userlname,
                    )
                );
            }
            if ($userdata->userrole == 3) {
                $data = array(
                    "logo_link" => base_url() . "uploads/admin/" . $admin_cont->admin_image,
                    "main_image" => base_url() . "uploads/admin/church_bishop.jpg",
                    "main_heading" => $admin_cont->admin_name,
                    "options" => array(
                        array("title" => "Membership", "tagline" => "View membership details."),
                        array("title" => "Church Calendar", "tagline" => "All Church meetings schedule", "image" => base_url('uploads/admin/') . $calendar->calendar_image),
                        array("title" => "Projects", "tagline" => "View church programmes and participate."),
                        array("title" => "Funeral Fund", "tagline" => "View church funeral plan options, pay premiums and view policies."),
                        array("title" => "Notices", "tagline" => "View church news and updates."),
                    ),
                    "userdata" => array(
                        "title" => $userdata->usertitle,
                        "first_name" => $userdata->userfname,
                        "last_name" => $userdata->userlname,
                    )
                );
            }


            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['message'] = 'Executed Successfully';
            $main_arr['info']['response']['data'] = $data;

            storemylog("Content Details of user\'s Dashboard page", "api/v1/general/dashboard", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($data));
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function donationpage_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $main_arr['info']['description'] = 'Content Details of Donation page';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $userid = $this->input->post('userid');
        $udata = get_user_info($userid);

        if (!empty($udata)) {
            $val['branch'] = branch_name($udata[0]->userbranch)->branch_name;
            $val['cell'] = cell_name($udata[0]->usercell)->cell_name;
            $val['amount'] = array(5, 10, 20, 35, 50);

            $this->db->select("*");
            $this->db->from('snr_donation');
            $this->db->where('donation_by', $userid);
            $this->db->order_by('added_on', 'DESC');
            $qry = $this->db->get();
            $donation = $qry->result();

            $donatearray = array();
            $this->db->select('*');
            $qr = $this->db->get('snr_admin');
            $admin_cont = $qr->row();

            if (count($donation) > 0) {
                foreach ($donation as $dn) {
                    $infoarray = array(
                        "logoimage" => base_url() . "uploads/admin/" . $admin_cont->admin_image,
                        "date" => date("jS F, Y", strtotime($dn->added_on)),
                        "transaction_id" => $dn->transaction_id,
                        "amount" => $dn->donation_amount,
                        "paymentmode" => $dn->donation_mode
                    );
                    array_push($donatearray, $infoarray);
                }
                $val['donation'] = $donatearray;
                $val['message'] = '';
            } else {
                $val['donation'] = '';
                $val['message'] = 'No donation records found';
            }

            $data['userinfo'] = $val;

            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['message'] = 'Executed Successfully';
            $main_arr['info']['response']['data'] = $data;
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['message'] = 'User Data not found';
            $main_arr['info']['response']['data'] = '';
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }
}