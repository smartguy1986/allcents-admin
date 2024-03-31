<?php
header('Access-Control-Allow-Origin: *');

require APPPATH . 'libraries/REST_Controller.php';

class Programme extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index_post()
    {

    }

    public function getcategories_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $this->db->select("id, cat_name, added_on, updated_on, status");
        $this->db->order_by('cat_order', 'ASC');
        $category = $this->db->get_where("snr_category", ['status' => '1'])->result();

        $main_arr['info']['description'] = 'Programme Category Details';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        if (!empty($category)) {
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['message'] = '';
            $main_arr['info']['response']['data'] = $category;

            storemylog("Programme Category Details", "api/v2/programme/getcategories", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($category));
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['message'] = '';
            $main_arr['info']['response']['data'] = 'No categories Found.';

            storemylog("Programme Category Details", "api/v2/programme/getcategories", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'No categories Found.');
        }
        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function getprogramme_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $cid = $this->input->post('categoryid');
        $sdate = $this->input->post('start_date');
        if (empty($sdate)) {
            $sdate = date("Y-m-d", strtotime(''));
        } else {
            $date = DateTime::createFromFormat("m-d-Y", $sdate);
            $sdate = $date->format('Y-m-d');
        }
        $edate = $this->input->post('end_date');
        if (empty($edate)) {
            $edate = date("Y-12-31");
        } else {
            $date2 = DateTime::createFromFormat("m-d-Y", $edate);
            $edate = $date2->format('Y-m-d');
        }

        $this->db->select("id, title, slug, topic_content, topic_excerpt, category, start_date, end_date, status");
        $this->db->from('snr_topics');
        if ($sdate && $edate) {
            $this->db->where(array('category' => $cid, 'start_date>=' => $sdate, 'start_date<=' => $edate, 'status' => '1'));
        }
        $this->db->order_by('start_date', 'DESC');
        $topics = $this->db->get()->result();

        $topicArray = array();
        foreach ($topics as $tp) {
            // $new_text = str_replace("\r\n",'', strip_tags($tp->topic_content));
            array_push($topicArray, array(
                "id" => $tp->id,
                "title" => $tp->title,
                "slug" => $tp->slug,
                // "topic_content" => substr($new_text, 0, strpos($new_text, '.', 250)),
                "topic_content" => $tp->topic_excerpt,
                "category" => $tp->category,
                "start_date" => $tp->start_date,
                "end_date" => $tp->end_date,
                "status" => $tp->status,
            )
            );
        }

        $main_arr['info']['description'] = 'Programme Lists by Category';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        if (count($topics) > 0) {
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['message'] = '';
            $main_arr['info']['response']['data'] = $topicArray;

            storemylog("Programme Lists by Category", "api/v2/programme/getprogramme", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($topicArray));
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['message'] = '';
            $main_arr['info']['response']['data'] = 'No Programmes Found.';

            storemylog("Programme Lists by Category", "api/v2/programme/getprogramme", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'No Programmes Found.');
        }
        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function getprogrammedetails_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $cid = $this->input->post('postid');

        $this->db->select("id, title, slug, topic_content, category, start_date, end_date, event_address, event_country, event_province, event_district, event_branch, event_cell, added_on, status");
        $this->db->from('snr_topics');
        $this->db->where(array('id' => $cid, 'status' => '1'));
        $topics = $this->db->get()->result();

        $event = array(
            "id" => $topics[0]->id,
            "title" => $topics[0]->title,
            "slug" => $topics[0]->slug,
            "topic_content" => $topics[0]->topic_content,
            "category" => $topics[0]->category,
            "category_name" => get_cat_name($topics[0]->category)->cat_name,
            "start_date" => $topics[0]->start_date,
            "end_date" => $topics[0]->end_date,
            "event_address" => $topics[0]->event_address,
            "event_country" => $topics[0]->event_country,
            "event_country_name" => country_name($topics[0]->event_country)->country_name,
            "event_province" => $topics[0]->event_province,
            "event_province_name" => province_name($topics[0]->event_province)->provincename,
            "event_district" => $topics[0]->event_district,
            "event_district_name" => district_name($topics[0]->event_district)->district_name,
            "event_branch" => $topics[0]->event_branch,
            "event_branch_name" => branch_name($topics[0]->event_branch)->branch_name,
            "event_cell" => $topics[0]->event_cell,
            "event_cell_name" => cell_name($topics[0]->event_cell)->cell_name,
            "added_on" => $topics[0]->added_on,
            "status" => $topics[0]->status
        );

        $main_arr['info']['description'] = 'Programme Details by Id';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        if (count($topics) > 0) {
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['message'] = '';
            $main_arr['info']['response']['data'] = $event;

            storemylog("Programme Details by Id", "api/v2/programme/getprogrammedetails", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($event));
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['message'] = '';
            $main_arr['info']['response']['data'] = 'No Programmes Found.';

            storemylog("Programme Details by Id", "api/v2/programme/getprogrammedetails", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'No Programmes Found.');
        }
        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

}