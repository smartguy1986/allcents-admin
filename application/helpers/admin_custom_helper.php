<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('company_info')) {
    function company_info($field = '')
    {
        $CI = &get_instance();
        $CI->db->select($field);
        $query = $CI->db->get('snr_company_info');
        return $query->row();
    }
}

if (!function_exists('centre_info')) {
    function centre_info($field = '', $id = null)
    {
        $CI = &get_instance();
        $CI->db->select($field);
        $CI->db->where('id', $id);
        $query = $CI->db->get('snr_centres');
        return $query->row();
    }
}

if (!function_exists('policy_info')) {
    function policy_info($pid = null)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('id', $pid);
        $query = $CI->db->get('snr_policies');
        return $query->row();
    }
}

if (!function_exists('company_details')) {
    function company_details()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $query = $CI->db->get('snr_company_info');
        return $query->row();
    }
}

if (!function_exists('check_user')) {
    function check_user($id = null, $token = null)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('id', $id);
        $CI->db->where('usertoken', $token);
        $query = $CI->db->get('snr_users');
        return $query->num_rows();
    }
}

if (!function_exists('checkpolicypurchase')) {
    function checkpolicypurchase($condition)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where($condition);
        $query = $CI->db->get('snr_policypurchase');
        return $query->row();
    }
}

if (!function_exists('get_policy_files')) {
    function get_policy_files($id = null)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('policy_id', $id);
        $query = $CI->db->get('snr_policyfiles');
        return $query->result();
    }
}

if (!function_exists('check_phone')) {
    function check_phone($phone = null)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('userphone', $phone);
        $query = $CI->db->get('snr_users');
        return $query->row();
    }
}

if (!function_exists('city_name')) {
    function city_name($cid = '')
    {
        $CI = &get_instance();
        $CI->db->select('RegionName');
        $CI->db->where('RegionID', $cid);
        $query = $CI->db->get('snr_region');
        return $query->row();
    }
}

if (!function_exists('country_name')) {
    function country_name($cid = '')
    {
        $CI = &get_instance();
        $CI->db->select('country_name');
        $CI->db->where('id', $cid);
        $query = $CI->db->get('snr_countries');
        return $query->row();
    }
}

if (!function_exists('province_name')) {
    function province_name($cid = '')
    {
        $CI = &get_instance();
        $CI->db->select('provincename');
        $CI->db->where('provinceid', $cid);
        $query = $CI->db->get('snr_province');
        return $query->row();
    }
}

if (!function_exists('district_name')) {
    function district_name($cid = '')
    {
        $CI = &get_instance();
        $CI->db->select('district_name');
        $CI->db->where('id', $cid);
        $query = $CI->db->get('snr_districts');
        return $query->row();
    }
}

if (!function_exists('branch_name')) {
    function branch_name($cid = '')
    {
        $CI = &get_instance();
        $CI->db->select('branch_name');
        $CI->db->where('id', $cid);
        $query = $CI->db->get('snr_branches');
        return $query->row();
    }
}

if (!function_exists('cell_name')) {
    function cell_name($cid = '')
    {
        $CI = &get_instance();
        $CI->db->select('cell_name');
        $CI->db->where('id', $cid);
        $query = $CI->db->get('snr_cells');
        return $query->row();
    }
}

if (!function_exists('policy_list_homepage')) {
    function policy_list_homepage()
    {
        $CI = &get_instance();
        $CI->db->select('id, policy_title');
        $query = $CI->db->get('snr_policies');
        return $query->result();
    }
}

if (!function_exists('country_list')) {
    function country_list()
    {
        $CI = &get_instance();
        $country_info = $CI->AdminModel->get_country_lists();
        return $country_info;
    }
}

if (!function_exists('province_list')) {
    function province_list()
    {
        $CI = &get_instance();
        $province_info = $CI->AdminModel->get_province_lists();
        return $province_info;
    }
}

if (!function_exists('district_list')) {
    function district_list()
    {
        $CI = &get_instance();
        $district_info = $CI->AdminModel->get_district_lists();
        return $district_info;
    }
}

if (!function_exists('branch_list')) {
    function branch_list()
    {
        $CI = &get_instance();
        $branch_info = $CI->AdminModel->get_branch_lists();
        return $branch_info;
    }
}

if (!function_exists('cell_list')) {
    function cell_list()
    {
        $CI = &get_instance();
        $cell_info = $CI->AdminModel->get_cell_lists();
        return $cell_info;
    }
}

if (!function_exists('city_lists')) {
    function city_lists()
    {
        $CI = &get_instance();
        $city_info = array();
        $provinceinfo = $CI->AdminModel->get_province_info();
        foreach ($provinceinfo as $province) {
            $aa['province'] = $province->provincename;
            $city_list = $CI->AdminModel->get_city_info($province->ProvinceID);
            $aa['city_list'] = $city_list;
            array_push($city_info, $aa);
        }
        return $city_info;
    }
}

if (!function_exists('policy_lists')) {
    function policy_lists()
    {
        $CI = &get_instance();
        $policylist = $CI->AdminModel->get_policies_list();
        return $policylist;
    }
}

if (!function_exists('get_recent_users')) {
    function get_recent_users()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('userrole', '3');
        $CI->db->order_by('userregistered', 'DESC');
        $CI->db->limit(7);
        $query = $CI->db->get('snr_users');
        return $query->result();
    }
}

if (!function_exists('get_recent_trasurer')) {
    function get_recent_trasurer()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('userrole', '2');
        $CI->db->order_by('userregistered', 'DESC');
        $CI->db->limit(7);
        $query = $CI->db->get('snr_users');
        return $query->result();
    }
}

if (!function_exists('get_user_info')) {
    function get_user_info($uid)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('id', $uid);
        $query = $CI->db->get('snr_users');
        return $query->result();
    }
}

if (!function_exists('get_user_number')) {
    function get_user_number($uid)
    {
        $CI = &get_instance();
        $CI->db->select('snr_users.userphone, snr_countries.country_code');
        $CI->db->join('snr_countries', 'snr_countries.id = snr_users.usercountry');
        $CI->db->where('snr_users.id', $uid);
        $query = $CI->db->get('snr_users');
        return $query->row();
    }
}
if (!function_exists('get_province_id')) {
    function get_province_id($cid)
    {
        $CI = &get_instance();
        $CI->db->select('ProvinceID');
        $CI->db->where('RegionID', $cid);
        $query = $CI->db->get('snr_region');
        return $query->row();
    }
}

if (!function_exists('get_total_user')) {
    function get_total_user()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('userrole', '3');
        $CI->db->order_by('userregistered', 'DESC');
        $query = $CI->db->get('snr_users');
        return $query->num_rows();
    }
}

if (!function_exists('get_total_donation')) {
    function get_total_donation($uid)
    {
        $CI = &get_instance();
        $CI->db->select('SUM(donation_amount) as totdon');
        $CI->db->where('final_status', '1');
        $CI->db->where('donation_by', $uid);
        $query = $CI->db->get('snr_donation');
        return $query->row();
    }
}

if (!function_exists('get_total_donation_home')) {
    function get_total_donation_home()
    {
        $CI = &get_instance();
        $CI->db->select('SUM(donation_amount) as totdon');
        $CI->db->where('final_status', '1');
        $query = $CI->db->get('snr_donation');
        return $query->row();
    }
}

if (!function_exists('get_total_policy')) {
    function get_total_policy($uid)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('status', '1');
        $CI->db->where('user_id', $uid);
        $query = $CI->db->get('snr_policypurchase');
        return $query->num_rows();
    }
}

if (!function_exists('get_province_name')) {
    function get_province_name($pid = null)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('ProvinceID', $pid);
        $query = $CI->db->get('snr_province');
        return $query->row();
    }
}

if (!function_exists('get_province_list')) {
    function get_province_list()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('status', '1');
        $CI->db->order_by('ProvinceID', 'ASC');
        $query = $CI->db->get('snr_province');
        return $query->result();
    }
}

if (!function_exists('get_category_list')) {
    function get_category_list()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->order_by('id', 'ASC');
        $query = $CI->db->get('snr_category');
        return $query->result();
    }
}

if (!function_exists('get_categoryies')) {
    function get_categoryies()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('status', '1');
        $CI->db->order_by('cat_name_en', 'ASC');
        $query = $CI->db->get('snr_category');
        return $query->result();
    }
}

if (!function_exists('get_cat_name')) {
    function get_cat_name($cid = null)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('id', $cid);
        $query = $CI->db->get('snr_category');
        return $query->row();
    }
}

if (!function_exists('get_notice_cat_name')) {
    function get_notice_cat_name($cid = null)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('id', $cid);
        $query = $CI->db->get('snr_category_notice');
        return $query->row();
    }
}

if (!function_exists('get_subcat_name')) {
    function get_subcat_name($sid = null)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('id', $sid);
        $query = $CI->db->get('snr_subcategory');
        return $query->row();
    }
}

if (!function_exists('slugify')) {
    function slugify($string)
    {
        // Get an instance of $this
        $CI = &get_instance();

        $CI->load->helper('text');
        $CI->load->helper('url');

        // Replace unsupported characters (add your owns if necessary)
        $string = str_replace("'", '-', $string);
        $string = str_replace(".", '-', $string);
        $string = str_replace("²", '2', $string);

        // Slugify and return the string
        return url_title(convert_accented_characters($string), 'dash', true);
    }
}

if (!function_exists('total_user')) {
    function total_user()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('userrole<>', '1');
        $CI->db->where('userstatus<>', '0');
        $query = $CI->db->get('snr_users');
        return $query->num_rows();
    }
}

if (!function_exists('total_programme')) {
    function total_programme()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('status', '1');
        $query = $CI->db->get('snr_topics');
        return $query->num_rows();
    }
}

if (!function_exists('get_programme')) {
    function get_programme($pid)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('id', $pid);
        $CI->db->where('status', '1');
        $query = $CI->db->get('snr_topics');
        return $query->row();
    }
}

if (!function_exists('get_total_donation')) {
    function get_total_donation($uid)
    {
        $CI = &get_instance();
        $CI->db->select('SUM(`donation_amount`) as totdonation');
        $CI->db->where('donation_by', $uid);
        $CI->db->where('final_status', '1');
        $query = $CI->db->get('snr_donation');
        return $query->row();
    }
}

if (!function_exists('total_cell')) {
    function total_cell()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('status', '1');
        $query = $CI->db->get('snr_cells');
        return $query->num_rows();
    }
}

if (!function_exists('total_branch')) {
    function total_branch()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('status', '1');
        $query = $CI->db->get('snr_branches');
        return $query->num_rows();
    }
}

if (!function_exists('total_centre')) {
    function total_centre()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('status', '1');
        $query = $CI->db->get('snr_centres');
        return $query->num_rows();
    }
}

if (!function_exists('health_centres')) {
    function health_centres()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('status', '1');
        $query = $CI->db->get('snr_centres');
        return $query->result();
    }
}

if (!function_exists('total_booking')) {
    function total_booking()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $query = $CI->db->get('snr_booking');
        return $query->num_rows();
    }
}

if (!function_exists('total_review')) {
    function total_review()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $query = $CI->db->get('snr_reviews');
        return $query->num_rows();
    }
}

if (!function_exists('last4_booking')) {
    function last4_booking()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->order_by('id', 'DESC');
        $CI->db->limit(4);
        $query = $CI->db->get('snr_booking');
        return $query->result();
    }
}



if (!function_exists('getcategoryinitials')) {
    function getcategoryinitials($cid)
    {
        $CI = &get_instance();
        $CI->db->select('cat_name_en');
        $CI->db->where('id', $cid);
        $query = $CI->db->get('snr_category');
        return $query->row();
    }
}

if (!function_exists('getcentreinitials')) {
    function getcentreinitials($cid)
    {
        $CI = &get_instance();
        $CI->db->select('centre_name');
        $CI->db->where('id', $cid);
        $query = $CI->db->get('snr_centres');
        return $query->row();
    }
}

if (!function_exists('getusername')) {
    function getusername($uid)
    {
        $CI = &get_instance();
        $CI->db->select('usertitle, userfname, userlname');
        $CI->db->where('id', $uid);
        $query = $CI->db->get('snr_users');
        return $query->row();
    }
}

if (!function_exists('getuserdata')) {
    function getuserdata($uid)
    {
        $CI = &get_instance();
        $CI->db->select('usertitle, userfname, userlname, userbranch, usercell');
        $CI->db->where('id', $uid);
        $query = $CI->db->get('snr_users');
        return $query->row();
    }
}

if (!function_exists('getuserphone')) {
    function getuserphone($uid)
    {
        $CI = &get_instance();
        $CI->db->select('userphone');
        $CI->db->where('id', $uid);
        $query = $CI->db->get('snr_users');
        return $query->row();
    }
}

if (!function_exists('getusername2')) {
    function getusername2($umail)
    {
        $CI = &get_instance();
        $CI->db->select('userfname');
        $CI->db->where('usermail', $umail);
        $query = $CI->db->get('snr_users');
        return $query->row();
    }
}

if (!function_exists('getusermail')) {
    function getusermail($uid)
    {
        $CI = &get_instance();
        $CI->db->select('usermail');
        $CI->db->where('id', $uid);
        $query = $CI->db->get('snr_users');
        return $query->row();
    }
}

if (!function_exists('checkperioddata')) {
    function checkperioddata($uid)
    {
        $CI = &get_instance();
        $CI->db->select('id');
        $CI->db->where('user_id', $uid);
        $query = $CI->db->get('snr_period');
        return $query->num_rows();
    }
}

if (!function_exists('checknotedata')) {
    function checknotedata($note_date, $uid)
    {
        $CI = &get_instance();
        $CI->db->select('id');
        $CI->db->where('note_date', $note_date);
        $CI->db->where('user_id', $uid);
        $query = $CI->db->get('snr_period_note');
        return $query->num_rows();
    }
}

if (!function_exists('getallperioddata')) {
    function getallperioddata()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->order_by('id', 'DESC');
        $query = $CI->db->get('snr_period');
        return $query->result();
    }
}

if (!function_exists('getperioddata')) {
    function getperioddata($uid)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('user_id', $uid);
        $CI->db->where('status', '1');
        $query = $CI->db->get('snr_period');
        return $query->row();
    }
}

if (!function_exists('getperiodnote')) {
    function getperiodnote($pdate, $uid)
    {
        $CI = &get_instance();
        $CI->db->select('id, user_id, note_date, note, flow');
        $CI->db->where('user_id', $uid);
        $CI->db->where('note_date', $pdate);
        $query = $CI->db->get('snr_period_note');
        return $query->row();
    }
}

if (!function_exists('getprovinceid')) {
    function getprovinceid($pname)
    {
        $CI = &get_instance();
        $CI->db->select('ProvinceID');
        $CI->db->like('provincename', $pname);
        $query = $CI->db->get('snr_province');
        return $query->row();
    }
}

if (!function_exists('geteventname')) {
    function geteventname($eid)
    {
        $CI = &get_instance();
        $CI->db->select('title');
        $CI->db->where('id', $eid);
        $query = $CI->db->get('snr_topics');
        return $query->row();
    }
}

if (!function_exists('storemylog')) {
    function storemylog($a = null, $b = null, $c = null, $d = null, $e = null, $f = null, $g = null)
    {
        $log_array = array(
            "api_name" => $a,
            "api_url" => $b,
            "api_method" => $c,
            "api_data" => $d,
            "api_status" => $e,
            "ip_addr" => $f,
            "api_response" => $g
        );
        $CI = &get_instance();
        $CI->db->insert('snr_api_call_log', $log_array);
        return null;
    }
}


if (!function_exists('byid_post')) {
    function byid_post($cid)
    {
        $CI = &get_instance();
        $CI->db->select("*");
        $CI->db->where('id', $cid);
        $centres = $CI->db->get_where("snr_centres", ['status' => '1'])->result();
        $lang = "en";
        if (!empty($centres)) {
            $data = array();
            foreach ($centres as $cnt) {
                if ($cnt->centre_banner) {
                    $bannerimage = base_url() . 'uploads/centre/banner/' . $cnt->centre_banner;
                } else {
                    $bannerimage = base_url() . "uploads/defaults/default_banner.jpg";
                }
                if ($cnt->centre_logo) {
                    $logoimage = base_url() . 'uploads/centre/logo/' . $cnt->centre_logo;
                } else {
                    $logoimage = base_url() . 'uploads/defaults/default_logo.jpg';
                }

                $cityname = city_name($cnt->centre_city)->RegionName;

                $ratings = getcentrerating($cnt->id);
                $star_rating = 0;
                $totr = 0;
                $x = 0;
                if (!empty($ratings)) {
                    foreach ($ratings as $rat) {
                        $totr = $totr + $rat->centre_rating;
                        $x++;
                    }
                    $star_rating = ($totr / $x);
                }

                $time_slots = array();
                for ($i = 0; $i < 15; $i++) {
                    $date = date("Y-m-d", strtotime("+" . $i . " day"));
                    $weekday = date('D', strtotime($date));

                    $abcd = array();
                    $abcd = array(
                        "id" => 1,
                        "date" => $date,
                        "date_name" => $weekday,
                        "time" => "9am - 6pm",
                        "location" => $cnt->centre_city,
                        "location_name" => $cityname,
                        "contact_no" => $cnt->centre_contact
                    );
                    array_push($time_slots, $abcd);
                }

                $review_lists = $CI->db->query("SELECT snr_reviews.*, snr_users.userfname FROM `snr_reviews` JOIN snr_users ON snr_reviews.user_id=snr_users.id WHERE snr_reviews.centre_id='" . $cid . "' AND snr_reviews.status='1' ORDER BY snr_reviews.added_on DESC")->result();

                $reviews = array();
                foreach ($review_lists as $rev) {
                    $rv = array("user_name" => $rev->userfname, "review" => $rev->review_text);
                    array_push($reviews, $rv);
                }

                $georestrict = getgeorestrict($cnt->centre_province)->geo_restriction;

                if ($georestrict == 0) {
                    if ($cnt->column_a == 0) {
                        if ($cnt->column_b = 0) {
                            if ($lang == 'en') {
                                $buttons = array(
                                    array(
                                        "id" => '3',
                                        "button_name" => "Make Enquiry",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Book Tele Consult",
                                    ),
                                );
                            }
                            if ($lang == 'zu') {
                                $buttons = array(
                                    array(
                                        "id" => '3',
                                        "button_name" => "Yenza Uphenyo",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Incwadi Tele Consult",
                                    ),
                                );
                            }
                            if ($lang == 'st') {
                                $buttons = array(
                                    array(
                                        "id" => '3',
                                        "button_name" => "Etsa Patlisiso",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Buka ea Tele Consult",
                                    ),
                                );
                            }
                        } else {
                            if ($lang == 'en') {
                                $buttons = array(
                                    array(
                                        "id" => '3',
                                        "button_name" => "Make Enquiry",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Book Tele Consult with Sentebale Advisor",
                                    ),
                                );
                            }
                            if ($lang == 'zu') {
                                $buttons = array(
                                    array(
                                        "id" => '3',
                                        "button_name" => "Yenza Uphenyo",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Incwadi Tele Xhumana noMeluleki weSentebale",
                                    ),
                                );
                            }
                            if ($lang == 'st') {
                                $buttons = array(
                                    array(
                                        "id" => '3',
                                        "button_name" => "Etsa Patlisiso",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Book Tele Consult le Sentebale Advisor",
                                    ),
                                );
                            }
                        }
                    } else {
                        if ($cnt->column_b = 0) {
                            if ($lang == 'en') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Book Appointment",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Make Enquiry",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Book Tele Consult",
                                    ),
                                );
                            }
                            if ($lang == 'zu') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Ukuqokwa Kwencwadi",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Yenza Uphenyo",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Book Tele Consult",
                                    ),
                                );
                            }
                            if ($lang == 'st') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Ho khethoa ha buka",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Incwadi Tele Consult",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Buka ea Tele Consult",
                                    ),
                                );
                            }
                        } else {
                            if ($lang == 'en') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Book Sentebale Advisor Appointment",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Make Enquiry",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Book Tele Consult with Sentebale Advisor",
                                    ),
                                );
                            }
                            if ($lang == 'zu') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Ukuqokwa Kwabeluleki Bencwadi Sentebale",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Yenza Uphenyo",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Incwadi Tele Xhumana noMeluleki weSentebale",
                                    ),
                                );
                            }
                            if ($lang == 'st') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Khetho ea Buka ea Sentebale",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Etsa Patlisiso",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Book Tele Consult le Sentebale Advisor",
                                    ),
                                );
                            }
                        }
                    }
                } else {
                    if ($cnt->column_a == 0) {
                        if ($cnt->column_b = 0) {
                            if ($lang == 'en') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Book Appointment",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Make Enquiry",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Book Tele Consult",
                                    ),
                                );
                            }
                            if ($lang == 'zu') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Ukuqokwa Kwencwadi",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Yenza Uphenyo",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Incwadi Tele Consult",
                                    ),
                                );
                            }
                            if ($lang == 'st') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Ho khethoa ha buka",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Etsa Patlisiso",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Buka ea Tele Consult",
                                    ),
                                );
                            }
                        } else {
                            if ($lang == 'en') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Book Sentebale Advisor Appointment",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Make Enquiry",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Book Tele Consult with Sentebale Advisor",
                                    ),
                                );
                            }
                            if ($lang == 'zu') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Ukuqokwa Kwabeluleki Bencwadi Sentebale",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Yenza Uphenyo",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Incwadi Tele Xhumana noMeluleki weSentebale",
                                    ),
                                );
                            }
                            if ($lang == 'st') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Khetho ea Buka ea Sentebale",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Etsa Patlisiso",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Book Tele Consult le Sentebale Advisor",
                                    ),
                                );
                            }
                        }
                    } else {
                        if ($cnt->column_b = 0) {
                            if ($lang == 'en') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Book Appointment",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Make Enquiry",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Book Tele Consult",
                                    ),
                                );
                            }
                            if ($lang == 'zu') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Ukuqokwa Kwencwadi",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Yenza Uphenyo",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Incwadi Tele Consult",
                                    ),
                                );
                            }
                            if ($lang == 'st') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Ho khethoa ha buka",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Etsa Patlisiso",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Buka ea Tele Consult",
                                    ),
                                );
                            }
                        } else {
                            if ($lang == 'en') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Book Appointment",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Make Enquiry",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Book Tele Consult",
                                    ),
                                );
                            }
                            if ($lang == 'zu') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Ukuqokwa Kwencwadi",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Yenza Uphenyo",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Incwadi Tele Consult",
                                    ),
                                );
                            }
                            if ($lang == 'st') {
                                $buttons = array(
                                    array(
                                        "id" => '1',
                                        "button_name" => "Ho khethoa ha buka",
                                    ),
                                    array(
                                        "id" => '3',
                                        "button_name" => "Etsa Patlisiso",
                                    ),
                                    array(
                                        "id" => '2',
                                        "button_name" => "Buka ea Tele Consult",
                                    ),
                                );
                            }
                        }
                    }
                }

                $data[] = array(
                    'id' => $cnt->id,
                    'centre_name' => $cnt->centre_name,
                    'centre_bio' => $cnt->centre_bio,
                    'centre_address' => $cnt->centre_address,
                    'centre_province' => $cnt->centre_province,
                    'centre_city' => $cnt->centre_city,
                    'centre_email' => $cnt->centre_email,
                    'centre_phone' => $cnt->centre_phone,
                    'centre_fax' => $cnt->centre_fax,
                    'centre_timing' => $cnt->centre_timing,
                    'centre_banner' => $bannerimage,
                    'centre_logo' => $logoimage,
                    'centre_contact' => $cnt->centre_contact,
                    'centre_lat' => $cnt->centre_lat,
                    'centre_long' => $cnt->centre_long,
                    "center_sub_heading" => $cityname,
                    "time_slots" => $time_slots,
                    "reviews" => $reviews,
                    "booking" => $buttons,
                    'added_on' => $cnt->added_on,
                    'updated_on' => $cnt->updated_on,
                    'status' => $cnt->status,
                    'star_rating' => round($star_rating),
                );
            }
        }
        return $data;
    }
}

if (!function_exists('getuserdata')) {
    function getuserdata($uid)
    {
        $CI = &get_instance();
        $CI->db->select('userfname, deviceid');
        $CI->db->where('id', $uid);
        $query = $CI->db->get('snr_users');
        return $query->row();
    }
}

if (!function_exists('setfootercopyrightdata')) {
    function setfootercopyrightdata()
    {
        return "<p class='mb-0'>Copyright © " . date("Y") . " | All rights reserved by <a href='https://www.allcents.tech' target='_blank'>AllCents App.</a></p>";
    }
}

// if(!function_exists('getmonthlyuser')) {
//     function getmonthlyuser()
//     {
//         $yr = date("Y");
//         $CI = & get_instance();
//         $CI->db->select('year(userregistered),month(userregistered) AS mnt,COUNT(userfname) AS tot');
//         $CI->db->where('userrole<>', '1');
//         $CI->db->where('YEAR(userregistered)',$yr);
//         $CI->db->group_by('year(userregistered),month(userregistered)');
//         $CI->db->order_by('year(userregistered),month(userregistered)','ASC');
//         $query = $CI->db->get('snr_users');
//         return $query->result();
//     }
// }

if (!function_exists('getmonthlyuser')) {
    function getmonthlyuser($stime)
    {
        $CI = &get_instance();
        $cyr = date("Y");

        if ($stime == 1) {
            $query = $CI->db->query("
            SELECT YEAR(`userregistered`) as mnth, IFNULL(count(`userfname`), 0) as total
            FROM snr_users
            WHERE userrole='3'
            GROUP BY YEAR(`userregistered`)
        ")->result_array();
        } else if ($stime == 2) {
            $query = $CI->db->query("
            SELECT
                idMonth,
                MONTHNAME(STR_TO_DATE(idMonth, '%m')) AS mnth,
                IFNULL(COUNT(userfname), 0) AS total
            FROM (
                SELECT 1 AS idMonth
                UNION SELECT 2 AS idMonth
                UNION SELECT 3 AS idMonth
                UNION SELECT 4 AS idMonth
                UNION SELECT 5 AS idMonth
                UNION SELECT 6 AS idMonth
                UNION SELECT 7 AS idMonth
                UNION SELECT 8 AS idMonth
                UNION SELECT 9 AS idMonth
                UNION SELECT 10 AS idMonth
                UNION SELECT 11 AS idMonth
                UNION SELECT 12 AS idMonth
            ) AS Month
            LEFT JOIN snr_users ON Month.idMonth = MONTH(userregistered)
                                AND YEAR(userregistered) = " . $cyr . "
                                AND userrole = '3'
            WHERE Month.idMonth <= MONTH(CURDATE())
            GROUP BY idMonth, mnth")->result_array();
        } else if ($stime == 3) {
            $query = $CI->db->query("
            SELECT 
                YEAR(`userregistered`) AS reg_year,
                WEEK(`userregistered`, 1) AS week_number,
                COUNT(`userfname`) AS total
            FROM 
                snr_users
            WHERE 
                `userregistered` >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
                AND YEAR(`userregistered`) = " . $cyr . "
                AND userrole = '3'
            GROUP BY 
                reg_year, week_number
            HAVING 
                total > 0")->result_array();
        } else if ($stime == 4) {
            $query = $CI->db->query("
            SELECT DATE(`userregistered`) as mnth, IFNULL(count(`userfname`), 0) as total
            FROM snr_users
            WHERE YEAR(`userregistered`) = $cyr
            AND userrole='3'
            GROUP BY DATE(`userregistered`)
        ")->result_array();
        } else {
            $query = $CI->db->query("
            SELECT
                idMonth,
                MONTHNAME(STR_TO_DATE(`idMonth`, '%m')) as mnth,
                IFNULL(count(`userfname`), 0) as total
            FROM snr_users
            RIGHT JOIN (
                SELECT 1 as idMonth
                UNION SELECT 2 as idMonth
                UNION SELECT 3 as idMonth
                UNION SELECT 4 as idMonth
                UNION SELECT 5 as idMonth
                UNION SELECT 6 as idMonth
                UNION SELECT 7 as idMonth
                UNION SELECT 8 as idMonth
                UNION SELECT 9 as idMonth
                UNION SELECT 10 as idMonth
                UNION SELECT 11 as idMonth
                UNION SELECT 12 as idMonth
            ) as Month
            ON Month.idMonth = month(`userregistered`) 
            WHERE YEAR(`userregistered`) = $cyr
            AND userrole='3'
            GROUP BY Month(`userregistered`)
        ")->result_array();
        }
        $data = array($query);
        return $data;
    }
}
if (!function_exists('getmonthlydonation')) {
    function getmonthlydonation($stime)
    {
        $CI = &get_instance();
        $cyr = date("Y");

        if ($stime == 1) {
            $pyr = date("Y", strtotime("-1 year")); //last year "2013"
            $query = $CI->db->query("
            SELECT YEAR(`added_on`) as mnth, IFNULL(SUM(`donation_amount`), 0) as total
            FROM snr_donation
            WHERE (YEAR(`added_on`) BETWEEN " . $pyr . " AND " . $cyr . ") AND final_status='1'
            GROUP BY YEAR(`added_on`)
        ")->result_array();
        } else if ($stime == 2) {
            $query = $CI->db->query("
            SELECT
                idMonth,
                MONTHNAME(STR_TO_DATE(`idMonth`, '%m')) as mnth,
                IFNULL(SUM(`donation_amount`), 0) as total
            FROM snr_donation
            LEFT JOIN (
                SELECT 1 as idMonth
                UNION SELECT 2 as idMonth
                UNION SELECT 3 as idMonth
                UNION SELECT 4 as idMonth
                UNION SELECT 5 as idMonth
                UNION SELECT 6 as idMonth
                UNION SELECT 7 as idMonth
                UNION SELECT 8 as idMonth
                UNION SELECT 9 as idMonth
                UNION SELECT 10 as idMonth
                UNION SELECT 11 as idMonth
                UNION SELECT 12 as idMonth
            ) as Month
            ON Month.idMonth = month(`added_on`) 
            WHERE YEAR(`added_on`) = $cyr
            AND final_status='1'
            GROUP BY Month(`added_on`)
        ")->result_array();
        } else if ($stime == 3) {
            $query = $CI->db->query("
            SELECT WEEK(`added_on`) as mnth, IFNULL(SUM(`donation_amount`), 0) as total
            FROM snr_donation
            WHERE YEAR(`added_on`) = $cyr
            AND final_status='1'
            GROUP BY WEEK(`added_on`)
        ")->result_array();
        } else if ($stime == 4) {
            $query = $CI->db->query("
            SELECT DATE(`added_on`) as mnth, IFNULL(SUM(`donation_amount`), 0) as total
            FROM snr_donation
            WHERE YEAR(`added_on`) = $cyr
            AND final_status='1'
            GROUP BY DATE(`added_on`)
        ")->result_array();
        } else {
            $query = $CI->db->query("
            SELECT
                idMonth,
                MONTHNAME(STR_TO_DATE(`idMonth`, '%m')) as mnth,
                IFNULL(SUM(`donation_amount`), 0) as total
            FROM snr_donation
            RIGHT JOIN (
                SELECT 1 as idMonth
                UNION SELECT 2 as idMonth
                UNION SELECT 3 as idMonth
                UNION SELECT 4 as idMonth
                UNION SELECT 5 as idMonth
                UNION SELECT 6 as idMonth
                UNION SELECT 7 as idMonth
                UNION SELECT 8 as idMonth
                UNION SELECT 9 as idMonth
                UNION SELECT 10 as idMonth
                UNION SELECT 11 as idMonth
                UNION SELECT 12 as idMonth
            ) as Month
            ON Month.idMonth = month(`added_on`) 
            WHERE YEAR(`added_on`) = $cyr
            AND final_status='1'
            GROUP BY Month(`added_on`)
        ")->result_array();
        }
        $data = array($query);
        return $data;
    }
}
if (!function_exists('getmonthlyuseremail')) {
    function getmonthlyuseremail($stime)
    {
        $CI = &get_instance();
        $pyr = date("Y", strtotime("-1 year")); //last year "2013"
        $cyr = date("Y");

        if ($stime == 1) {
            $query = $CI->db->query("
            SELECT YEAR(`userregistered`) as mnth, IFNULL(count(`userfname`), 0) as total
            FROM snr_users
            WHERE (YEAR(`userregistered`) BETWEEN " . $pyr . " AND " . $cyr . ") AND userrole='3' AND usersource='0' AND social_login='0'
            GROUP BY YEAR(`userregistered`)")->result_array();
        } else if ($stime == 2) {
            $query = $CI->db->query("
            SELECT
                idMonth,
                MONTHNAME(STR_TO_DATE(`idMonth`, '%m')) as mnth,
                IFNULL(count(`userfname`), 0) as total
            FROM snr_users
            LEFT JOIN (
                SELECT 1 as idMonth
                UNION SELECT 2 as idMonth
                UNION SELECT 3 as idMonth
                UNION SELECT 4 as idMonth
                UNION SELECT 5 as idMonth
                UNION SELECT 6 as idMonth
                UNION SELECT 7 as idMonth
                UNION SELECT 8 as idMonth
                UNION SELECT 9 as idMonth
                UNION SELECT 10 as idMonth
                UNION SELECT 11 as idMonth
                UNION SELECT 12 as idMonth
            ) as Month
            ON Month.idMonth = month(`userregistered`) 
            AND userrole='3' 
            WHERE usersource='0' AND social_login='0'
            GROUP BY Month(`userregistered`)")->result_array();
        } else {
            $query = $CI->db->query("
            SELECT
                idMonth,
                MONTHNAME(STR_TO_DATE(`idMonth`, '%m')) as mnth,
                IFNULL(count(`userfname`), 0) as total
            FROM snr_users
            RIGHT JOIN (
                SELECT 1 as idMonth
                UNION SELECT 2 as idMonth
                UNION SELECT 3 as idMonth
                UNION SELECT 4 as idMonth
                UNION SELECT 5 as idMonth
                UNION SELECT 6 as idMonth
                UNION SELECT 7 as idMonth
                UNION SELECT 8 as idMonth
                UNION SELECT 9 as idMonth
                UNION SELECT 10 as idMonth
                UNION SELECT 11 as idMonth
                UNION SELECT 12 as idMonth
            ) as Month
            ON Month.idMonth = month(`userregistered`) 
            AND userrole='3' AND usersource='0' AND social_login='0'
            GROUP BY Month(`userregistered`)")->result_array();
        }
        $data = array($query);
        return $data;
    }
}

if (!function_exists('getmonthlyusersocial')) {
    function getmonthlyusersocial($stime)
    {
        $CI = &get_instance();
        $pyr = date("Y", strtotime("-1 year")); //last year "2013"
        $cyr = date("Y");

        if ($stime == 1) {
            $query = $CI->db->query("
            SELECT YEAR(`userregistered`) as mnth, IFNULL(count(`userfname`), 0) as total
            FROM snr_users
            WHERE (YEAR(`userregistered`) BETWEEN " . $pyr . " AND " . $cyr . ") AND userrole='3' AND social_login='1'
            GROUP BY YEAR(`userregistered`)")->result_array();
        } else if ($stime == 2) {
            $query = $CI->db->query("
            SELECT
                idMonth,
                MONTHNAME(STR_TO_DATE(`idMonth`, '%m')) as mnth,
                IFNULL(count(`userfname`), 0) as total
            FROM snr_users
            LEFT JOIN (
                SELECT 1 as idMonth
                UNION SELECT 2 as idMonth
                UNION SELECT 3 as idMonth
                UNION SELECT 4 as idMonth
                UNION SELECT 5 as idMonth
                UNION SELECT 6 as idMonth
                UNION SELECT 7 as idMonth
                UNION SELECT 8 as idMonth
                UNION SELECT 9 as idMonth
                UNION SELECT 10 as idMonth
                UNION SELECT 11 as idMonth
                UNION SELECT 12 as idMonth
            ) as Month
            ON Month.idMonth = month(`userregistered`) 
            AND userrole='3' 
            WHERE social_login='0'
            GROUP BY Month(`userregistered`)")->result_array();
        } else {
            $query = $CI->db->query("
            SELECT
                idMonth,
                MONTHNAME(STR_TO_DATE(`idMonth`, '%m')) as mnth,
                IFNULL(count(`userfname`), 0) as total
            FROM snr_users
            RIGHT JOIN (
                SELECT 1 as idMonth
                UNION SELECT 2 as idMonth
                UNION SELECT 3 as idMonth
                UNION SELECT 4 as idMonth
                UNION SELECT 5 as idMonth
                UNION SELECT 6 as idMonth
                UNION SELECT 7 as idMonth
                UNION SELECT 8 as idMonth
                UNION SELECT 9 as idMonth
                UNION SELECT 10 as idMonth
                UNION SELECT 11 as idMonth
                UNION SELECT 12 as idMonth
            ) as Month
            ON Month.idMonth = month(`userregistered`) 
            AND userrole='3' 
            WHERE social_login='1'
            GROUP BY Month(`userregistered`)")->result_array();
        }
        $data = array($query);
        return $data;
    }
}

if (!function_exists('getmonthlybookingall')) {
    function getmonthlybookingall($stime)
    {
        $CI = &get_instance();
        $pyr = date("Y", strtotime("-1 year")); //last year "2013"
        $cyr = date("Y");

        if ($stime == 1) {
            $query = $CI->db->query("
            SELECT YEAR(`schedule_date`) as mnth, IFNULL(count(`id`), 0) as total
            FROM snr_booking
            WHERE (YEAR(`schedule_date`) BETWEEN " . $pyr . " AND " . $cyr . ")
            GROUP BY YEAR(`schedule_date`)")->result_array();
        } else if ($stime == 2) {
            $query = $CI->db->query("
            SELECT
                idMonth,
                MONTHNAME(STR_TO_DATE(`idMonth`, '%m')) as mnth,
                IFNULL(count(`id`), 0) as total
            FROM snr_booking
            LEFT JOIN (
                SELECT 1 as idMonth
                UNION SELECT 2 as idMonth
                UNION SELECT 3 as idMonth
                UNION SELECT 4 as idMonth
                UNION SELECT 5 as idMonth
                UNION SELECT 6 as idMonth
                UNION SELECT 7 as idMonth
                UNION SELECT 8 as idMonth
                UNION SELECT 9 as idMonth
                UNION SELECT 10 as idMonth
                UNION SELECT 11 as idMonth
                UNION SELECT 12 as idMonth
            ) as Month
            ON Month.idMonth = month(`schedule_date`)
            GROUP BY Month(`schedule_date`)")->result_array();
        } else if ($stime == 3) {
            $query = $CI->db->query("
            SELECT WEEK(`schedule_date`) as mnth, IFNULL(count(`id`), 0) as total
            FROM snr_booking
            GROUP BY WEEK(`schedule_date`)")->result_array();
        } else if ($stime == 4) {
            $query = $CI->db->query("
            SELECT DATE(`schedule_date`) as mnth, IFNULL(count(`id`), 0) as total
            FROM snr_booking
            GROUP BY DATE(`schedule_date`)")->result_array();
        } else {
            $query = $CI->db->query("
            SELECT
                idMonth,
                MONTHNAME(STR_TO_DATE(`idMonth`, '%m')) as mnth,
                IFNULL(count(`id`), 0) as total
            FROM snr_booking
            LEFT JOIN (
                SELECT 1 as idMonth
                UNION SELECT 2 as idMonth
                UNION SELECT 3 as idMonth
                UNION SELECT 4 as idMonth
                UNION SELECT 5 as idMonth
                UNION SELECT 6 as idMonth
                UNION SELECT 7 as idMonth
                UNION SELECT 8 as idMonth
                UNION SELECT 9 as idMonth
                UNION SELECT 10 as idMonth
                UNION SELECT 11 as idMonth
                UNION SELECT 12 as idMonth
            ) as Month
            ON Month.idMonth = month(`schedule_date`)
            GROUP BY Month(`schedule_date`)")->result_array();
        }
        $data = array($query);
        return $data;
    }
}

if (!function_exists('getmonthlybookingprovince')) {
    function getmonthlybookingprovince($stime, $pid)
    {
        $CI = &get_instance();
        $pyr = date("Y", strtotime("-1 year")); //last year "2013"
        $cyr = date("Y");

        if ($stime == 1) {
            if ($pid == 0) {
                $query = $CI->db->query("
                SELECT YEAR(`schedule_date`) as mnth, IFNULL(count(`unique_id`), 0) as total, snr_province.provincename AS province
                FROM snr_booking
                JOIN snr_centres ON snr_centres.id = snr_booking.centre_id
                JOIN snr_province ON snr_province.ProvinceID = snr_centres.centre_province
                WHERE (YEAR(`schedule_date`) BETWEEN " . $pyr . " AND " . $cyr . ")
                GROUP BY snr_centres.centre_province")->result_array();
            } else {
                $query = $CI->db->query("
                SELECT YEAR(`schedule_date`) as mnth, IFNULL(count(`unique_id`), 0) as total
                FROM snr_booking
                JOIN snr_centres ON snr_centres.id = snr_booking.centre_id
                WHERE (YEAR(`schedule_date`) BETWEEN " . $pyr . " AND " . $cyr . ") AND snr_centres.centre_province='" . $pid . "'
                GROUP BY YEAR(`schedule_date`)")->result_array();
            }
        } else if ($stime == 2) {
            $query = $CI->db->query("
            SELECT
                idMonth,
                MONTHNAME(STR_TO_DATE(`idMonth`, '%m')) as mnth,
                IFNULL(count(`unique_id`), 0) as total
            FROM snr_booking
            LEFT JOIN (
                SELECT 1 as idMonth
                UNION SELECT 2 as idMonth
                UNION SELECT 3 as idMonth
                UNION SELECT 4 as idMonth
                UNION SELECT 5 as idMonth
                UNION SELECT 6 as idMonth
                UNION SELECT 7 as idMonth
                UNION SELECT 8 as idMonth
                UNION SELECT 9 as idMonth
                UNION SELECT 10 as idMonth
                UNION SELECT 11 as idMonth
                UNION SELECT 12 as idMonth
            ) as Month
            ON Month.idMonth = month(`schedule_date`)
            JOIN snr_centres ON snr_centres.id = snr_booking.centre_id
            WHERE snr_centres.centre_province='" . $pid . "'
            GROUP BY Month(`schedule_date`)")->result_array();
        } else {
            if ($pid == 0) {
                $query = $CI->db->query("
                SELECT
                    idMonth,
                    snr_province.provincename AS province,
                    MONTHNAME(STR_TO_DATE(`idMonth`, '%m')) as mnth,
                    IFNULL(count(`unique_id`), 0) as total
                FROM snr_booking
                LEFT JOIN (
                    SELECT 1 as idMonth
                    UNION SELECT 2 as idMonth
                    UNION SELECT 3 as idMonth
                    UNION SELECT 4 as idMonth
                    UNION SELECT 5 as idMonth
                    UNION SELECT 6 as idMonth
                    UNION SELECT 7 as idMonth
                    UNION SELECT 8 as idMonth
                    UNION SELECT 9 as idMonth
                    UNION SELECT 10 as idMonth
                    UNION SELECT 11 as idMonth
                    UNION SELECT 12 as idMonth
                ) as Month
                ON Month.idMonth = month(`schedule_date`)
                JOIN snr_centres ON snr_centres.id = snr_booking.centre_id
                JOIN snr_province ON snr_province.ProvinceID = snr_centres.centre_province
                GROUP BY snr_centres.centre_province")->result_array();
            } else {
                $query = $CI->db->query("
                SELECT
                    idMonth,
                    MONTHNAME(STR_TO_DATE(`idMonth`, '%m')) as mnth,
                    IFNULL(count(`unique_id`), 0) as total
                FROM snr_booking
                LEFT JOIN (
                    SELECT 1 as idMonth
                    UNION SELECT 2 as idMonth
                    UNION SELECT 3 as idMonth
                    UNION SELECT 4 as idMonth
                    UNION SELECT 5 as idMonth
                    UNION SELECT 6 as idMonth
                    UNION SELECT 7 as idMonth
                    UNION SELECT 8 as idMonth
                    UNION SELECT 9 as idMonth
                    UNION SELECT 10 as idMonth
                    UNION SELECT 11 as idMonth
                    UNION SELECT 12 as idMonth
                ) as Month
                ON Month.idMonth = month(`schedule_date`)
                JOIN snr_centres ON snr_centres.id = snr_booking.centre_id
                WHERE snr_centres.centre_province='" . $pid . "'
                GROUP BY Month(`schedule_date`)")->result_array();
            }
        }
        $data = array($query);
        return $data;
    }
}

if (!function_exists('getmonthlybooking2')) {
    function getmonthlybooking2($mnth, $province)
    {
        // $yr = date("Y");
        $CI = &get_instance();
        // $CI->db->select('year(booking_date),month(booking_date) AS mnt,COUNT(unique_id) AS tot');
        // $CI->db->where('YEAR(booking_date)',$yr);
        // $CI->db->where($conditions);
        // $CI->db->group_by('year(booking_date),month(booking_date)');
        // $CI->db->order_by('year(booking_date),month(booking_date)','ASC');
        // $query = $CI->db->get('snr_booking');
        // return $query->result();
        if ($province != 0) {
            $query = $CI->db->query("
            SELECT booking_type as btype, IFNULL(count(unique_id), 1) as tot
            FROM snr_booking
            JOIN snr_centres ON snr_booking.centre_id=snr_centres.id
            WHERE snr_centres.centre_province='" . $province . "'
            AND month(snr_booking.schedule_date)='" . $mnth . "'
            GROUP BY booking_type")->result_array();
        } else {
            $query = $CI->db->query("
            SELECT snr_booking.booking_type as btype, IFNULL(count(snr_booking.unique_id), 1) as tot
            FROM snr_booking
            WHERE month(snr_booking.schedule_date)='" . $mnth . "'
            GROUP BY snr_booking.booking_type")->result_array();
        }
        return $query;
    }
}

if (!function_exists('getmonthlytopic')) {
    function getmonthlytopic()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        // $CI->db->where('topic_view<>','0');
        $CI->db->limit(5);
        $CI->db->order_by('topic_view', 'DESC');
        $query = $CI->db->get('snr_topics');
        return $query->result();
    }
}

if (!function_exists('get_notifications')) {
    function get_notifications()
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->order_by('id', 'DESC');
        $CI->db->limit(10);
        $query = $CI->db->get('snr_notifications');
        return $query->result();
    }
}

if (!function_exists('updatetopicview')) {
    function updatetopicview($tid)
    {
        $CI = &get_instance();
        $CI->db->set('topic_view', 'topic_view+1', FALSE);
        $CI->db->where('id', $tid);
        $CI->db->update('snr_topics');
    }
}

if (!function_exists('timeAgo')) {
    function timeAgo($time_ago)
    {
        $time_ago = strtotime($time_ago);
        $cur_time = time();
        $time_elapsed = $cur_time - $time_ago;
        $seconds = $time_elapsed;
        $minutes = round($time_elapsed / 60);
        $hours = round($time_elapsed / 3600);
        $days = round($time_elapsed / 86400);
        $weeks = round($time_elapsed / 604800);
        $months = round($time_elapsed / 2600640);
        $years = round($time_elapsed / 31207680);
        // Seconds
        if ($seconds <= 60) {
            return "just now";
        }
        //Minutes
        else if ($minutes <= 60) {
            if ($minutes == 1) {
                return "one minute ago";
            } else {
                return "$minutes minutes ago";
            }
        }
        //Hours
        else if ($hours <= 24) {
            if ($hours == 1) {
                return "an hour ago";
            } else {
                return "$hours hrs ago";
            }
        }
        //Days
        else if ($days <= 7) {
            if ($days == 1) {
                return "yesterday";
            } else {
                return "$days days ago";
            }
        }
        //Weeks
        else if ($weeks <= 4.3) {
            if ($weeks == 1) {
                return "a week ago";
            } else {
                return "$weeks weeks ago";
            }
        }
        //Months
        else if ($months <= 12) {
            if ($months == 1) {
                return "a month ago";
            } else {
                return "$months months ago";
            }
        }
        //Years
        else {
            if ($years == 1) {
                return "one year ago";
            } else {
                return "$years years ago";
            }
        }
    }
}

if (!function_exists('getgeorestrict')) {
    function getgeorestrict($pid)
    {
        $CI = &get_instance();
        $CI->db->select('geo_restriction');
        $CI->db->where('ProvinceID', $pid);
        $query = $CI->db->get('snr_province');
        return $query->row();
    }
}

if (!function_exists('checkallcolumna')) {
    function checkallcolumna()
    {
        $CI = &get_instance();
        $CI->db->select('column_a');
        $CI->db->where('column_a', '1');
        $CI->db->where('status', '1');
        $query = $CI->db->get('snr_centres');
        return $query->result();
    }
}

if (!function_exists('getcentreidbybooking')) {
    function getcentreidbybooking($bid)
    {
        $CI = &get_instance();
        $CI->db->select('centre_id');
        $CI->db->where('id', $bid);
        $query = $CI->db->get('snr_booking');
        return $query->row();
    }
}

if (!function_exists('getcentrerating')) {
    function getcentrerating($cid)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where('centre_id', $cid);
        $CI->db->where('status', '1');
        $query = $CI->db->get('snr_reviews');
        return $query->result();
    }
}

if (!function_exists('checkreview')) {
    function checkreview($bid, $uid)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where(array('booking_id' => $bid, 'user_id' => $uid));
        $query = $CI->db->get('snr_reviews');
        return $query->num_rows();
    }
}

if (!function_exists('getuser_cordinates')) {
    function getuser_cordinates($uid)
    {
        $CI = &get_instance();
        $CI->db->select('user_lat, user_long');
        $CI->db->where(array('id' => $uid));
        $query = $CI->db->get('snr_users');
        return $query->row();
    }
}

if (!function_exists('getuser_last_city')) {
    function getuser_last_city($uid)
    {
        $CI = &get_instance();
        $CI->db->select('current_city');
        $CI->db->where(array('id' => $uid));
        $query = $CI->db->get('snr_users');
        return $query->row();
    }
}

if (!function_exists('check_donation')) {
    function check_donation($tid)
    {
        $CI = &get_instance();
        $CI->db->select('*');
        $CI->db->where(array('transaction_id' => $tid));
        $query = $CI->db->get('snr_donation');
        return $query->row();
    }
}

function generate_string($input, $strength = 16)
{
    $input_length = strlen($input);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}


if (!function_exists('getmonthlycategory')) {
    function getmonthlycategory($stime)
    {
        $CI = &get_instance();
        $pyr = date("Y", strtotime("-1 year")); //last year "2013"
        $cyr = date("Y");

        if ($stime == 1) {
            $query = $CI->db->query("
            SELECT snr_category_tracker.cat_id, snr_category.cat_name_en, SUM(views) as total, snr_category_tracker.year as mnth FROM snr_category_tracker JOIN snr_category ON snr_category.id=snr_category_tracker.cat_id GROUP BY snr_category_tracker.cat_id, snr_category_tracker.year ORDER BY SUM(views) DESC LIMIT 0,3")->result_array();
        } else if ($stime == 2) {
            for ($i = 1; $i < 13; $i++) {
                $aaa = $CI->db->query("
                SELECT snr_category_tracker.cat_id, snr_category.cat_name_en, SUM(views) as total, snr_category_tracker.month as mnth FROM snr_category_tracker JOIN snr_category ON snr_category.id=snr_category_tracker.cat_id WHERE month='" . $i . "' GROUP BY snr_category_tracker.cat_id ORDER BY SUM(views) DESC LIMIT 0,3")->result_array();
                // if($aaa)
                // {
                $query[$i] = $aaa;
                // }
            }
        } else {
            for ($i = 1; $i < 13; $i++) {
                $aaa = $CI->db->query("
                SELECT snr_category_tracker.cat_id, snr_category.cat_name_en, SUM(views) as total, snr_category_tracker.month as mnth FROM snr_category_tracker JOIN snr_category ON snr_category.id=snr_category_tracker.cat_id WHERE month='" . $i . "' GROUP BY snr_category_tracker.cat_id ORDER BY SUM(views) DESC LIMIT 0,3")->result_array();
                // if($aaa)
                // {
                $query[$i] = $aaa;
                // }
            }
        }
        $data = array($query);
        return $data;
    }
}

if (!function_exists('last10_articles')) {
    function last10_articles($stime)
    {
        $CI = &get_instance();
        $pyr = date("Y", strtotime("-1 year")); //last year "2013"
        $cyr = date("Y");

        if ($stime == 1) {
            $query = $CI->db->query("
            SELECT snr_article_tracker.topic_id, snr_topics.title_en, SUM(views) as total, snr_article_tracker.year as mnth FROM snr_article_tracker JOIN snr_topics ON snr_topics.id=snr_article_tracker.topic_id GROUP BY snr_article_tracker.topic_id, snr_article_tracker.year ORDER BY SUM(views) DESC LIMIT 0,3")->result_array();
        } else if ($stime == 2) {
            for ($i = 1; $i < 13; $i++) {
                $aaa = $CI->db->query("
                SELECT snr_article_tracker.topic_id, snr_topics.title_en, SUM(views) as total, snr_article_tracker.month as mnth FROM snr_article_tracker JOIN snr_topics ON snr_topics.id=snr_article_tracker.topic_id WHERE month='" . $i . "' GROUP BY snr_article_tracker.topic_id ORDER BY SUM(views) DESC LIMIT 0,3")->result_array();
                // if($aaa)
                // {
                $query[$i] = $aaa;
                // }
            }
        } else {
            for ($i = 1; $i < 13; $i++) {
                $aaa = $CI->db->query("
                SELECT snr_article_tracker.topic_id, snr_topics.title_en, SUM(views) as total, snr_article_tracker.month as mnth FROM snr_article_tracker JOIN snr_topics ON snr_topics.id=snr_article_tracker.topic_id WHERE month='" . $i . "' GROUP BY snr_article_tracker.topic_id ORDER BY SUM(views) DESC LIMIT 0,3")->result_array();
                // if($aaa)
                // {
                $query[$i] = $aaa;
                // }
            }
        }
        $data = array($query);
        return $data;
    }
}

if (!function_exists('topprovince')) {
    function topprovince($stime)
    {
        $CI = &get_instance();
        $pyr = date("Y", strtotime("-1 year")); //last year "2013"
        $cyr = date("Y");

        if ($stime == 1) {
            $query = $CI->db->query("
            SELECT snr_location_tracker.province_id, snr_province.provincename, SUM(views) as total, snr_location_tracker.year as mnth FROM snr_location_tracker JOIN snr_province ON snr_province.ProvinceID=snr_location_tracker.province_id GROUP BY snr_location_tracker.province_id, snr_location_tracker.year ORDER BY SUM(views) DESC LIMIT 0,3")->result_array();
        } else if ($stime == 2) {
            for ($i = 1; $i < 13; $i++) {
                $aaa = $CI->db->query("
                SELECT snr_location_tracker.province_id, snr_province.provincename, SUM(views) as total, snr_location_tracker.month as mnth FROM snr_location_tracker JOIN snr_province ON snr_province.ProvinceID=snr_location_tracker.province_id WHERE month='" . $i . "' GROUP BY snr_location_tracker.province_id ORDER BY SUM(views) DESC LIMIT 0,3")->result_array();
                if ($aaa) {
                    $query[$i] = $aaa;
                }
            }
        } else {
            for ($i = 1; $i < 13; $i++) {
                $aaa = $CI->db->query("
                SELECT snr_location_tracker.province_id, snr_province.provincename, SUM(views) as total, snr_location_tracker.month as mnth FROM snr_location_tracker JOIN snr_province ON snr_province.ProvinceID=snr_location_tracker.province_id WHERE month='" . $i . "' GROUP BY snr_location_tracker.province_id ORDER BY SUM(views) DESC LIMIT 0,3")->result_array();
                if ($aaa) {
                    $query[$i] = $aaa;
                }
            }
        }
        $data = array($query);
        return $data;
    }
}

if (!function_exists('topcities')) {
    function topcities($stime)
    {
        $CI = &get_instance();
        $pyr = date("Y", strtotime("-1 year")); //last year "2013"
        $cyr = date("Y");

        if ($stime == 1) {
            $query = $CI->db->query("
            SELECT snr_location_tracker.city_id, snr_region.RegionName, SUM(views) as total, snr_location_tracker.year as mnth FROM snr_location_tracker JOIN snr_region ON snr_region.RegionID=snr_location_tracker.city_id GROUP BY snr_location_tracker.city_id, snr_location_tracker.year ORDER BY SUM(views) DESC LIMIT 0,3")->result_array();
        } else if ($stime == 2) {
            for ($i = 1; $i < 13; $i++) {
                $aaa = $CI->db->query("
                SELECT snr_location_tracker.city_id, snr_region.RegionName, SUM(views) as total, snr_location_tracker.month as mnth FROM snr_location_tracker JOIN snr_region ON snr_region.RegionID=snr_location_tracker.city_id WHERE month='" . $i . "' GROUP BY snr_location_tracker.city_id ORDER BY SUM(views) DESC LIMIT 0,3")->result_array();
                if ($aaa) {
                    $query[$i] = $aaa;
                }
            }
        } else {
            for ($i = 1; $i < 13; $i++) {
                $aaa = $CI->db->query("
                SELECT snr_location_tracker.city_id, snr_region.RegionName, SUM(views) as total, snr_location_tracker.month as mnth FROM snr_location_tracker JOIN snr_region ON snr_region.RegionID=snr_location_tracker.city_id WHERE month='" . $i . "' GROUP BY snr_location_tracker.city_id ORDER BY SUM(views) DESC LIMIT 0,3")->result_array();
                if ($aaa) {
                    $query[$i] = $aaa;
                }
            }
        }
        $data = array($query);
        return $data;
    }
}

if (!function_exists('get_not_users')) {
    function get_not_users()
    {
        $CI = &get_instance();
        $CI->db->select('id, userfname, usermail, deviceid, devicetype');
        $CI->db->where('deviceid<>', '');
        $CI->db->order_by('userfname', 'ASC');
        $query = $CI->db->get('snr_users');
        return $query->result();
    }
}

if (!function_exists('haversineGreatCircleDistance')) {
    function haversineGreatCircleDistance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}



if (!function_exists('getbookingcompare')) {
    function getbookingcompare($stime)
    {
        $CI = &get_instance();

        if ($stime == 1) {
            $query = $CI->db->query("
            SELECT  Months.m AS mnth, COUNT(snr_booking.schedule_date) AS total FROM 
            (
                SELECT 1 as m 
                UNION SELECT 2 as m 
                UNION SELECT 3 as m 
                UNION SELECT 4 as m 
                UNION SELECT 5 as m 
                UNION SELECT 6 as m 
                UNION SELECT 7 as m 
                UNION SELECT 8 as m 
                UNION SELECT 9 as m 
                UNION SELECT 10 as m 
                UNION SELECT 11 as m 
                UNION SELECT 12 as m
            ) as Months
            LEFT JOIN snr_booking  on Months.m = MONTH(snr_booking.schedule_date)  
            AND (status='0' OR status='1') 
            GROUP BY
                Months.m")->result_array();

            $query2 = $CI->db->query("
            SELECT  Months.m AS mnth, COUNT(snr_booking.schedule_date) AS total FROM 
            (
                SELECT 1 as m 
                UNION SELECT 2 as m 
                UNION SELECT 3 as m 
                UNION SELECT 4 as m 
                UNION SELECT 5 as m 
                UNION SELECT 6 as m 
                UNION SELECT 7 as m 
                UNION SELECT 8 as m 
                UNION SELECT 9 as m 
                UNION SELECT 10 as m 
                UNION SELECT 11 as m 
                UNION SELECT 12 as m
            ) as Months
            LEFT JOIN snr_booking  on Months.m = MONTH(snr_booking.schedule_date)  
            AND (status='2' OR status='3') 
            GROUP BY
                Months.m")->result_array();
        } else if ($stime == 2) {
            $query = $CI->db->query("
            SELECT YEAR(schedule_date) AS mnth, COUNT(id) AS total FROM snr_booking WHERE status='0' OR status='1' GROUP BY YEAR(schedule_date)")->result_array();

            $query2 = $CI->db->query("
            SELECT YEAR(schedule_date) AS mnth, COUNT(id) AS total FROM snr_booking WHERE status='2' OR status='3' GROUP BY YEAR(schedule_date)")->result_array();
        } else {
            $query = $CI->db->query("
            SELECT
                idMonth,
                MONTHNAME(STR_TO_DATE(`idMonth`, '%m')) as mnth,
                IFNULL(count(`unique_id`), 0) as total
            FROM snr_booking
            RIGHT JOIN (
                SELECT 1 as idMonth
                UNION SELECT 2 as idMonth
                UNION SELECT 3 as idMonth
                UNION SELECT 4 as idMonth
                UNION SELECT 5 as idMonth
                UNION SELECT 6 as idMonth
                UNION SELECT 7 as idMonth
                UNION SELECT 8 as idMonth
                UNION SELECT 9 as idMonth
                UNION SELECT 10 as idMonth
                UNION SELECT 11 as idMonth
                UNION SELECT 12 as idMonth
            ) as Month
            ON Month.idMonth = Month('schedule_date') 
            AND status='0' OR status='1'
            GROUP BY Month('schedule_date')")->result_array();

            $query2 = $CI->db->query("
            SELECT
                idMonth,
                MONTHNAME(STR_TO_DATE(`idMonth`, '%m')) as mnth,
                IFNULL(count(`unique_id`), 0) as total
            FROM snr_booking
            RIGHT JOIN (
                SELECT 1 as idMonth
                UNION SELECT 2 as idMonth
                UNION SELECT 3 as idMonth
                UNION SELECT 4 as idMonth
                UNION SELECT 5 as idMonth
                UNION SELECT 6 as idMonth
                UNION SELECT 7 as idMonth
                UNION SELECT 8 as idMonth
                UNION SELECT 9 as idMonth
                UNION SELECT 10 as idMonth
                UNION SELECT 11 as idMonth
                UNION SELECT 12 as idMonth
            ) as Month
            ON Month.idMonth = month(`schedule_date`) 
            AND status='2' OR status='3'
            GROUP BY Month('schedule_date')")->result_array();
        }
        $data = array($query, $query2);
        return $data;
    }
}

if (!function_exists('getmonthlybookingtype')) {
    function getmonthlybookingtype($stime, $btype)
    {
        $CI = &get_instance();
        $pyr = date("Y", strtotime("-1 year")); //last year "2013"
        $cyr = date("Y");

        if ($stime == 1) {
            $query = $CI->db->query("
            SELECT YEAR(`schedule_date`) as mnth, IFNULL(count(`unique_id`), 0) as total
            FROM snr_booking
            WHERE (YEAR(`schedule_date`) BETWEEN " . $pyr . " AND " . $cyr . ") AND booking_type='" . $btype . "'
            GROUP BY YEAR(`schedule_date`)")->result_array();
        } else if ($stime == 2) {
            $query = $CI->db->query("
            SELECT
                idMonth,
                MONTHNAME(STR_TO_DATE(`idMonth`, '%m')) as mnth,
                IFNULL(count(`unique_id`), 0) as total
            FROM snr_booking
            LEFT JOIN (
                SELECT 1 as idMonth
                UNION SELECT 2 as idMonth
                UNION SELECT 3 as idMonth
                UNION SELECT 4 as idMonth
                UNION SELECT 5 as idMonth
                UNION SELECT 6 as idMonth
                UNION SELECT 7 as idMonth
                UNION SELECT 8 as idMonth
                UNION SELECT 9 as idMonth
                UNION SELECT 10 as idMonth
                UNION SELECT 11 as idMonth
                UNION SELECT 12 as idMonth
            ) as Month
            ON Month.idMonth = month(`schedule_date`)
            WHERE booking_type='" . $btype . "'
            GROUP BY Month(`schedule_date`)")->result_array();
        } else if ($stime == 3) {
            $query = $CI->db->query("
            SELECT WEEK(`schedule_date`) as mnth, IFNULL(count(`unique_id`), 0) as total
            FROM snr_booking WHERE booking_type='" . $btype . "'
            GROUP BY WEEK(`schedule_date`)")->result_array();
        } else if ($stime == 4) {
            $query = $CI->db->query("
            SELECT DATE(`schedule_date`) as mnth, IFNULL(count(`unique_id`), 0) as total
            FROM snr_booking WHERE booking_type='" . $btype . "'
            GROUP BY DATE(`schedule_date`)")->result_array();
        } else {
            $query = $CI->db->query("
            SELECT
                idMonth,
                MONTHNAME(STR_TO_DATE(`idMonth`, '%m')) as mnth,
                IFNULL(count(`unique_id`), 0) as total
            FROM snr_booking
            LEFT JOIN (
                SELECT 1 as idMonth
                UNION SELECT 2 as idMonth
                UNION SELECT 3 as idMonth
                UNION SELECT 4 as idMonth
                UNION SELECT 5 as idMonth
                UNION SELECT 6 as idMonth
                UNION SELECT 7 as idMonth
                UNION SELECT 8 as idMonth
                UNION SELECT 9 as idMonth
                UNION SELECT 10 as idMonth
                UNION SELECT 11 as idMonth
                UNION SELECT 12 as idMonth
            ) as Month
            ON Month.idMonth = month(`schedule_date`)
            WHERE booking_type='" . $btype . "'
            GROUP BY Month(`schedule_date`)")->result_array();
        }
        $data = array($query);
        return $data;
    }
}
