<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') or exit('No direct script access allowed');

class TopicController extends CI_Controller
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
    }

    public function index($term = null)
    {
        $data['topics'] = $this->AdminModel->get_topics_list();
        $this->load->view('admin/topics/topiclists', $data);
    }

    public function addtopic()
    {
        if ($this->session->userdata('logged_in_info')->userrole != 1) {
            redirect('admin');
        }
        $data['country_info'] = $this->AdminModel->get_country_info();
        $data['branch_info'] = $this->AdminModel->get_branch_info();
        $data['cell_info'] = $this->AdminModel->get_cell_info();
        $data['categories'] = $this->AdminModel->get_category_info();
        $this->load->view('admin/topics/createtopic', $data);
    }

    public function getsubcat()
    {
        $conditions = array("cat_id" => $this->input->post('cid'));
        $subcat = $this->AdminModel->getsubcats($conditions);

        echo "<select id='subcategory' class='form-select' name='subcategory' data-error2='Please Select City'>";
        if (!empty($subcat)) {
            echo "<option value=''>Choose...</option>";
            foreach ($subcat as $sct) {
                echo "<option value='" . $sct->id . "'>" . $sct->subcat_name_en . "</option>";
            }
        } else {
            echo "<option value=''>No Subcategories found</option>";
        }
        echo "</select>";
    }

    public function getsubcat2()
    {
        $conditions = array("cat_id" => $this->input->post('cid'));
        $subcat = $this->AdminModel->getsubcats($conditions);

        echo "<select id='subcategory' class='form-select' name='subcategory' data-error2='Please Select City'>";
        if (!empty($subcat)) {
            echo "<option value=''>Choose...</option>";
            foreach ($subcat as $sct) {
                if ($this->input->post('scid') == $sct->id) {
                    echo "<option value='" . $sct->id . "' selected>" . $sct->subcat_name_en . "</option>";
                } else {
                    echo "<option value='" . $sct->id . "'>" . $sct->subcat_name_en . "</option>";
                }
            }
        } else {
            echo "<option value=''>No Subcategories found</option>";
        }
        echo "</select>";
    }

    public function savetopic()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        // die();

        $category = $this->input->post('category');
        $title = $this->input->post('title');
        $topic_content = $this->input->post('topiccontent');
        $topic_excerpt = $this->input->post('topic_excerpt');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $event_address = $this->input->post('event_address');
        $event_country = $this->input->post('event_country');
        $event_province = $this->input->post('event_province');
        $event_district = $this->input->post('event_district');
        $event_branch = $this->input->post('event_branch');
        $event_cell = $this->input->post('event_cell');
        $slug = slugify($title);

        $conditions = array('slug' => $slug);
        $result = $this->AdminModel->checkslug($conditions);
        if ($result > 0) {
            $slug = $slug . '-' . ($result + 1);
        }

        $data = array(
            "title" => $title,
            "slug" => $slug,
            "start_date" => $start_date,
            "end_date" => $end_date,
            "topic_content" => $topic_content,
            "topic_excerpt" => $topic_excerpt,
            "event_address" => $event_address,
            "event_country" => $event_country,
            "event_province" => $event_province,
            "event_district" => $event_district,
            "event_branch" => $event_branch,
            "event_cell" => $event_cell,
            "category" => $category,
            "topic_author" => $this->session->userdata('logged_in_info')->id,
        );

        $id = $this->AdminModel->savetopic($data);

        if ($id) {
            $this->session->set_flashdata('success', 'Event published successfully!');
            redirect('events');
        } else {
            $this->session->set_flashdata('error', 'Event not published. Please try again!');
            redirect('events');
        }
    }

    public function getarticle()
    {
        $articleid = $this->input->post('aid');
        $conditions = array("id" => $articleid);
        $articlecontent = $this->AdminModel->getmyarticle($conditions);
        echo json_encode($articlecontent);
    }

    public function edit($aid)
    {
        //echo $aid;
        $conditions = array('id' => $aid);
        $data['categories'] = $this->AdminModel->get_category_info();
        $data['topics'] = $this->AdminModel->get_topics_byid($conditions);
        $this->load->view('admin/topics/edittopic', $data);
    }

    public function update()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        // die();

        $id = $this->input->post('articleid');
        $category = $this->input->post('category');
        $title = $this->input->post('title');
        $topic_content = $this->input->post('topic_content');
        $topic_excerpt = $this->input->post('topic_excerpt');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $event_address = $this->input->post('event_address');
        $event_country = $this->input->post('event_country');
        $event_province = $this->input->post('event_province');
        $event_district = $this->input->post('event_district');
        $event_branch = $this->input->post('event_branch');
        $event_cell = $this->input->post('event_cell');
        $slug = slugify($title);

        if ($this->input->post('oldslug') != $slug) {
            $conditions = array('slug' => $slug);
            $result = $this->AdminModel->checkslug($conditions);
            if ($result > 0) {
                $slug = $slug . '-' . ($result + 1);
            }
        }

        $data = array(
            "title" => $title,
            "slug" => $slug,
            "start_date" => $start_date,
            "end_date" => $end_date,
            "topic_content" => $topic_content,
            "topic_excerpt" => $topic_excerpt,
            "event_address" => $event_address,
            "event_country" => $event_country,
            "event_province" => $event_province,
            "event_district" => $event_district,
            "event_branch" => $event_branch,
            "event_cell" => $event_cell,
            "category" => $category,
            "topic_author" => $this->session->userdata('logged_in_info')->id,
        );

        $uid = $this->AdminModel->updatetopic($data, $id);
        if ($uid) {
            $this->session->set_flashdata('update', 'Event updated successfully!');
            redirect('events');
        } else {
            $this->session->set_flashdata('error', 'Event not updated. Please try again!');
            redirect('events');
        }
    }

    public function disable($uid)
    {
        $val = array("status" => '0');
        $id = $this->AdminModel->changetopicstatus($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Event disabled successfully!');
            redirect('events');
        } else {
            $this->session->set_flashdata('error', 'Event not disabled. Please try again!');
            redirect('events');
        }
    }

    public function enable($uid)
    {
        $val = array("status" => '1');
        $id = $this->AdminModel->changetopicstatus($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Event Enabled successfully!');
            redirect('events');
        } else {
            $this->session->set_flashdata('error', 'Event not enabled. Please try again!');
            redirect('events');
        }
    }
}