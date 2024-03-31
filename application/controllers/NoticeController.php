<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') or exit('No direct script access allowed');

class NoticeController extends CI_Controller
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

    public function index()
    {
        $data['categories'] = $this->AdminModel->get_notice_category_info($fulllist = true);
        $this->load->view('admin/noticecategory/categorylist', $data);
    }

    public function branchlist()
    {
        $data['branches'] = $this->AdminModel->get_branch_info();
        $this->load->view('admin/branch/branchlist', $data);
    }

    public function celllist()
    {
        $data['cells'] = $this->AdminModel->get_cell_info();
        $this->load->view('admin/cell/celllist', $data);
    }

    public function subcategories()
    {
        $data['subcategories'] = $this->AdminModel->get_subcategory_info();
        $this->load->view('admin/category/subcategorylist', $data);
    }

    public function add()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        $data = array(
            "cat_name" => $this->input->post('cat_name'),
            "status" => '1'
        );
        $id = $this->AdminModel->save_notice_category($data);
        if ($id) {
            $this->session->set_flashdata('success', 'Category added successfully!');
            redirect('noticecategories');
        } else {
            $this->session->set_flashdata('error', 'Category not added. Please try again!');
            redirect('noticecategories');
        }
    }

    public function edit($cid = null)
    {
        $conditions = array('id' => $cid, 'status' => '1');
        $data['categorydetails'] = $this->AdminModel->get_notice_category($conditions);
        $this->load->view('admin/noticecategory/editcategory', $data);
    }

    public function update()
    {
        // echo "<pre>";
        // print_r($categorydetails);
        // echo "</pre>";

        $data = array(
            "cat_name" => $this->input->post('cat_name'),
            "cat_desc" => $this->input->post('cat_desc'),
        );
        $id = $this->AdminModel->update_notice_category($data, $this->input->post('cid'));
        if ($id) {
            $this->session->set_flashdata('update', 'Category updated successfully!');
            redirect('noticecategories');
        } else {
            $this->session->set_flashdata('error', 'Category not updated. Please try again!');
            redirect('noticecategories');
        }
    }

    public function disablecat($uid)
    {
        $val = array("status" => '0');
        $id = $this->AdminModel->changecatstatus_notice($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Category disabled successfully!');
            redirect('noticecategories');
        } else {
            $this->session->set_flashdata('error', 'Category not disabled. Please try again!');
            redirect('noticecategories');
        }
    }

    public function deletecat($uid)
    {
        $id = $this->AdminModel->deletenoticecat($uid);

        $this->session->set_flashdata('success', 'Category disabled successfully!');
        redirect('noticecategories');
    }

    public function enablecat($uid)
    {
        $val = array("status" => '1');
        $id = $this->AdminModel->changecatstatus_notice($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Category enabled successfully!');
            redirect('noticecategories');
        } else {
            $this->session->set_flashdata('error', 'Category not enabled. Please try again!');
            redirect('noticecategories');
        }
    }

    public function noticelist()
    {
        $data['topics'] = $this->AdminModel->get_notice_list();
        $this->load->view('admin/notices/noticelists', $data);
    }

    public function addnotice()
    {
        if ($this->session->userdata('logged_in_info')->userrole != 1) {
            redirect('admin');
        }
        $data['categories'] = $this->AdminModel->get_notice_category_info();
        $this->load->view('admin/notices/createnotice', $data);
    }

    public function savenotice()
    {
        $category = $this->input->post('category');
        $title = $this->input->post('title');
        $topic_content = $this->input->post('topiccontent');
        $notice_excerpt = $this->input->post('notice_excerpt');
        $slug = slugify($title);

        $conditions = array('slug' => $slug);
        $result = $this->AdminModel->checkslug($conditions);
        if ($result > 0) {
            $slug = $slug . '-' . ($result + 1);
        }

        $data = array(
            "title" => $title,
            "slug" => $slug,
            "notice_content" => $topic_content,
            "notice_excerpt" => $notice_excerpt,
            "category" => $category
        );

        $id = $this->AdminModel->savenotice($data);

        if ($id) {
            $this->session->set_flashdata('success', 'Notice published successfully!');
            redirect('notices');
        } else {
            $this->session->set_flashdata('error', 'Notice not published. Please try again!');
            redirect('notices');
        }
    }

    public function getnotice()
    {
        $articleid = $this->input->post('aid');
        $conditions = array("id" => $articleid);
        $articlecontent = $this->AdminModel->getmynotice($conditions);
        echo json_encode($articlecontent);
    }

    public function editnotice($aid)
    {
        //echo $aid;
        $conditions = array('id' => $aid);
        $data['categories'] = $this->AdminModel->get_notice_category_info();
        $data['topics'] = $this->AdminModel->get_notice_byid($conditions);
        $this->load->view('admin/notices/editnotice', $data);
    }

    public function updatenotice()
    {
        $id = $this->input->post('articleid');
        $category = $this->input->post('category');
        $title = $this->input->post('title');
        $topic_content = $this->input->post('topic_content');
        $notice_excerpt = $this->input->post('notice_excerpt');
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
            "notice_content" => $topic_content,
            "notice_excerpt" => $notice_excerpt,
            "category" => $category
        );

        $uid = $this->AdminModel->updatenotice($data, $id);
        if ($uid) {
            $this->session->set_flashdata('update', 'Notice updated successfully!');
            redirect('notices');
        } else {
            $this->session->set_flashdata('error', 'Notice not updated. Please try again!');
            redirect('notices');
        }
    }

    public function disable($uid)
    {
        $val = array("status" => '0');
        $id = $this->AdminModel->changetopicstatus($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Notice disabled successfully!');
            redirect('events');
        } else {
            $this->session->set_flashdata('error', 'Notice not disabled. Please try again!');
            redirect('events');
        }
    }

    public function enable($uid)
    {
        $val = array("status" => '1');
        $id = $this->AdminModel->changetopicstatus($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Notice Enabled successfully!');
            redirect('events');
        } else {
            $this->session->set_flashdata('error', 'Notice not enabled. Please try again!');
            redirect('events');
        }
    }

    public function disablenotice($uid)
    {
        $val = array("status" => '0');
        $id = $this->AdminModel->updatenotice($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Notice disabled successfully!');
            redirect('notices');
        } else {
            $this->session->set_flashdata('error', 'Notice not disabled. Please try again!');
            redirect('notices');
        }
    }

    public function deletenotice($uid)
    {
        $id = $this->AdminModel->deletenotice($uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Notice deleted successfully!');
            redirect('notices');
        } else {
            $this->session->set_flashdata('error', 'Notice not deleted. Please try again!');
            redirect('notices');
        }
    }

    public function enablenotice($uid)
    {
        $val = array("status" => '1');
        $id = $this->AdminModel->updatenotice($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Notice Enabled successfully!');
            redirect('notices');
        } else {
            $this->session->set_flashdata('error', 'Notice not enabled. Please try again!');
            redirect('notices');
        }
    }
}
