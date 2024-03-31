<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') or exit ('No direct script access allowed');

class NotificationController extends CI_Controller
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

        if ($this->session->userdata('is_logged_in') == 0) {
            redirect('/');
        }
        $this->load->model('AdminModel');
        $this->load->model('ActivityLogModel');
    }

    public function index()
    {
        $data['notice_data'] = $this->AdminModel->get_all_notification();
        $this->load->view('admin/notifications/notificationlist', $data);
    }

    public function addnotice()
    {
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";

        $data = array(
            "not_title" => $this->input->post('not_title'),
            "not_msg" => $this->input->post('not_msg'),
            "not_branch" => $this->input->post('userbranch'),
            "not_cell" => $this->input->post('usercell'),
            "not_status" => '1'
        );
        $id = $this->AdminModel->save_notification($data);
        if ($id) {
            $this->session->set_flashdata('success', 'Notification added successfully!');
            redirect('notifications');
        } else {
            $this->session->set_flashdata('error', 'Notification not added. Please try again!');
            redirect('notifications');
        }
    }

    public function disable($uid)
    {
        $val = array("not_status" => '0');
        $id = $this->AdminModel->changenotificationstatus($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Notification disabled successfully!');
            redirect('notifications');
        } else {
            $this->session->set_flashdata('error', 'Notification not disabled. Please try again!');
            redirect('notifications');
        }
    }

    public function enable($uid)
    {
        $val = array("not_status" => '1');
        $id = $this->AdminModel->changenotificationstatus($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Notification Enabled successfully!');
            redirect('notifications');
        } else {
            $this->session->set_flashdata('error', 'Notification not enabled. Please try again!');
            redirect('notifications');
        }
    }

    public function announcementlist()
    {
        $data['notice_data'] = $this->AdminModel->get_all_announcements();
        $this->load->view('admin/announcement/announcementlist', $data);
    }

    public function addannouncement()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        $data = array(
            "title" => $this->input->post('title'),
            "message" => $this->input->post('message'),
            "branch" => $this->input->post('userbranch'),
            "cell" => $this->input->post('usercell'),
            "status" => '1'
        );
        $id = $this->AdminModel->save_announcement($data);
        if ($id) {
            $this->session->set_flashdata('success', 'Announcement added successfully!');
            redirect('announcements');
        } else {
            $this->session->set_flashdata('error', 'Announcement not added. Please try again!');
            redirect('announcements');
        }
    }

    public function announcementdisable($uid)
    {
        $val = array("status" => '0');
        $id = $this->AdminModel->update_announcement($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Announcement disabled successfully!');
            redirect('announcements');
        } else {
            $this->session->set_flashdata('error', 'Announcement not disabled. Please try again!');
            redirect('announcements');
        }
    }

    public function announcementenable($uid)
    {
        $val = array("status" => '1');
        $id = $this->AdminModel->update_announcement($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Announcement Enabled successfully!');
            redirect('announcements');
        } else {
            $this->session->set_flashdata('error', 'Announcement not enabled. Please try again!');
            redirect('announcements');
        }
    }


}