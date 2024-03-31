<?php
header('Access-Control-Allow-Origin: *');

require APPPATH . 'libraries/REST_Controller.php';

class Notices extends REST_Controller
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
        $category = $this->db->get_where("snr_category_notice", ['status' => '1'])->result();

        $main_arr['info']['description'] = 'Notices Category Details';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        if (!empty($category)) {
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['message'] = '';
            $main_arr['info']['response']['data'] = $category;
            $this->db->select("*");
            $this->db->order_by('created_at', 'DESC');
            $announcement = $this->db->get_where("snr_announcement", ['status' => '1'])->result();

            $ann_array = array();
            foreach ($announcement as $ann) {
                array_push($ann_array, array("title" => $ann->title, "description" => $ann->message));
            }

            $main_arr['info']['response']['announcement'] = $ann_array;

            storemylog("Notices Category Details", "api/v2/notices/getcategories", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($category));
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['message'] = '';
            $main_arr['info']['response']['data'] = 'No categories Found.';
            $main_arr['info']['response']['announcement'] = 'No announcement found.';

            storemylog("Notices Category Details", "api/v2/notices/getcategories", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'No categories Found.');
        }
        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function getnotices_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $cid = $this->input->post('categoryid');

        $this->db->select("*");
        $this->db->from('snr_notices');
        $this->db->where(array('category' => $cid, 'status' => '1'));
        $this->db->order_by('added_on', 'DESC');
        $topics = $this->db->get()->result();

        $main_arr['info']['description'] = 'Notices Lists by Category';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        foreach ($topics as $tp) {
            $tp->notice_content = substr(strip_tags($tp->notice_excerpt), 0, 200);
        }

        if (count($topics) > 0) {
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['message'] = '';
            $main_arr['info']['response']['data'] = $topics;

            storemylog("Notices Lists by Category", "api/v2/notices/getnotices", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], json_encode($topics));
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['message'] = '';
            $main_arr['info']['response']['data'] = 'No Notices Found.';

            storemylog("Notices Lists by Category", "api/v2/notices/getnotices", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'No Notices Found.');
        }
        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function getnoticedetails_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $cid = $this->input->post('postid');

        $this->db->select("*");
        $this->db->from('snr_notices');
        $this->db->where(array('id' => $cid, 'status' => '1'));
        $topics = $this->db->get()->result();

        $event = array(
            "id" => $topics[0]->id,
            "title" => $topics[0]->title,
            "slug" => $topics[0]->slug,
            "notice_content" => $topics[0]->notice_content,
            "category" => $topics[0]->category,
            "category_name" => get_notice_cat_name($topics[0]->category)->cat_name,
            "added_on" => date("jS F, Y", strtotime($topics[0]->added_on)),
            "status" => $topics[0]->status
        );

        $main_arr['info']['description'] = 'Notice Details by Id';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        if (count($topics) > 0) {
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['message'] = '';
            $main_arr['info']['response']['data'] = $event;

            storemylog("Notice Details by Id", "api/v2/notices/getnoticedetails", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($event));
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['message'] = '';
            $main_arr['info']['response']['data'] = 'No Programmes Found.';

            storemylog("Notice Details by Id", "api/v2/notices/getnoticedetails", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'No Programmes Found.');
        }
        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function notifications_post()
    {
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral Policy';

        $uid = $this->input->post('userid');
        $is_read = $this->input->post('is_Read');

        if (empty($uid)) {
            $main_arr['info']['response']['status'] = 0;
            $main_arr['info']['response']['message'] = '';
            $main_arr['info']['response']['unread'] = 0;
            $main_arr['info']['response']['data'] = 'User id is empty';

            storemylog("Notifications List", "api/v2/notices/notifications", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'User id is empty');
        } else {
            $this->db->select("*");
            $this->db->from('snr_notifications');
            $this->db->where('not_uid', $uid);
            $this->db->order_by('created_at', 'DESC');
            $topics = $this->db->get()->result();

            $new_array = array();
            $readCount = 0;
            foreach ($topics as $tp) {
                array_push(
                    $new_array,
                    array(
                        "id" => $tp->id,
                        "not_title" => $tp->not_title,
                        "not_msg" => $tp->not_msg,
                        "not_uid" => $tp->not_uid,
                        "not_branch" => 0,
                        "not_cell" => 0,
                        "not_status" => 1,
                        "is_read" => $tp->is_read,
                        "created_at" => date("jS M, Y h:i A", strtotime($tp->created_at))
                    )
                );
                if ($tp->is_read == 0) {
                    $readCount++;
                }
            }

            if ($is_read == 1) {
                $this->db->where('not_uid', $uid);
                $this->db->update('snr_notifications', array('is_read' => 1));
            }

            $main_arr['info']['description'] = 'Notifications List';
            $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
            $main_arr['info']['method'] = 'POST';

            if (count($topics) > 0) {
                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['message'] = '';
                $main_arr['info']['response']['unread'] = $readCount;
                $main_arr['info']['response']['data'] = $new_array;

                storemylog("Notifications List", "api/v2/notices/notifications", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($new_array));
            } else {
                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['message'] = 'No Notifications Found.';
                $main_arr['info']['response']['unread'] = 0;
                $main_arr['info']['response']['data'] = $new_array;

                storemylog("Notifications List", "api/v2/notices/notifications", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], json_encode($new_array));
            }
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }
}