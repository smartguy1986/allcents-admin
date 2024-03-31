<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') or exit('No direct script access allowed');

class DonationController extends CI_Controller
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
        $data['donations'] = $this->AdminModel->get_donation_info();
        $this->load->view('admin/donations/donationlist', $data);
    }

    public function add()
    {
        $data['donations'] = $this->AdminModel->get_donation_info();
        $this->load->view('admin/donations/makedonation', $data);
    }

    public function register()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        $transid = $this->input->post('transid');
        $donate_by = $this->input->post('donate_by');
        $donation_amount = $this->input->post('donation_amount');
        $agreecheck = $this->input->post('agreecheck');
        $treasurer = $this->input->post('treasurer');

        $udata = get_user_number($donate_by);

        if ($agreecheck) {
            $conditions = array("treasurer" => $treasurer, "final_status" => '1');

            $id = $this->AdminModel->update_donations($conditions, $transid);
            if ($id) {
                $this->session->set_flashdata('success', 'Donation registered successfully!');
                sndsmstouserlive($udata->country_code . $udata->userphone, 'Congratulations! Your donation of amount $ ' . $donation_amount . ' has been successfully submitted to church account.', $donate_by);
                $notArray = array(
                    "not_title" => "Payment Accepted",
                    "not_msg" => 'Congratulations! Your donation of amount $ ' . $donation_amount . ' has been successfully submitted to church account.',
                    "not_uid" => $donate_by,
                    "is_read" => "0"
                );
                $this->AdminModel->save_notification($notArray);
                redirect('donations');
            } else {
                $this->session->set_flashdata('error', 'Donation not registered. Please try again!');
                redirect('donations');
            }
        }
    }

    public function celladd()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        $data = array(
            "cell_name" => $this->input->post('cell_name'),
            "status" => '1'
        );
        $id = $this->AdminModel->save_cell($data);
        if ($id) {
            $this->session->set_flashdata('success', 'Cell added successfully!');
            redirect('cells');
        } else {
            $this->session->set_flashdata('error', 'Cell not added. Please try again!');
            redirect('cells');
        }
    }

    public function edit($cid = null)
    {
        $conditions = array('id' => $cid, 'status' => '1');
        $data['categorydetails'] = $this->AdminModel->get_category($conditions);
        $this->load->view('admin/category/editcategory', $data);

    }

    public function branchedit($cid = null)
    {
        $conditions = array('id' => $cid, 'status' => '1');
        $data['branchdetails'] = $this->AdminModel->get_branch($conditions);
        $this->load->view('admin/branch/editbranch', $data);

    }

    public function celledit($cid = null)
    {
        $conditions = array('id' => $cid, 'status' => '1');
        $data['celldetails'] = $this->AdminModel->get_cell($conditions);
        $this->load->view('admin/cell/editcell', $data);

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
        $id = $this->AdminModel->update_category($data, $this->input->post('cid'));
        if ($id) {
            $this->session->set_flashdata('update', 'Category updated successfully!');
            redirect('categories');
        } else {
            $this->session->set_flashdata('error', 'Category not updated. Please try again!');
            redirect('categories');
        }
    }

    public function branchupdate()
    {
        // echo "<pre>";
        // print_r($categorydetails);
        // echo "</pre>";

        $data = array(
            "branch_name" => $this->input->post('branch_name'),
        );
        $id = $this->AdminModel->update_branch($data, $this->input->post('cid'));
        if ($id) {
            $this->session->set_flashdata('update', 'Branch updated successfully!');
            redirect('branches');
        } else {
            $this->session->set_flashdata('error', 'Branch not updated. Please try again!');
            redirect('branches');
        }
    }

    public function cellupdate()
    {
        // echo "<pre>";
        // print_r($categorydetails);
        // echo "</pre>";

        $data = array(
            "cell_name" => $this->input->post('cell_name'),
        );
        $id = $this->AdminModel->update_cell($data, $this->input->post('cid'));
        if ($id) {
            $this->session->set_flashdata('update', 'Cell updated successfully!');
            redirect('cells');
        } else {
            $this->session->set_flashdata('error', 'Cell not updated. Please try again!');
            redirect('cells');
        }
    }

    public function disablecat($uid)
    {
        $val = array("status" => '0');
        $id = $this->AdminModel->changecatstatus($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Category disabled successfully!');
            redirect('categories');
        } else {
            $this->session->set_flashdata('error', 'Category not disabled. Please try again!');
            redirect('categories');
        }
    }

    public function disablebranch($uid)
    {
        $val = array("status" => '0');
        $id = $this->AdminModel->changebranchstatus($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Branch disabled successfully!');
            redirect('branches');
        } else {
            $this->session->set_flashdata('error', 'Branch not disabled. Please try again!');
            redirect('branches');
        }
    }

    public function disablecell($uid)
    {
        $val = array("status" => '0');
        $id = $this->AdminModel->changecellstatus($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Cell disabled successfully!');
            redirect('cells');
        } else {
            $this->session->set_flashdata('error', 'Cell not disabled. Please try again!');
            redirect('cells');
        }
    }

    public function enablecat($uid)
    {
        $val = array("status" => '1');
        $id = $this->AdminModel->changecatstatus($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Category enabled successfully!');
            redirect('categories');
        } else {
            $this->session->set_flashdata('error', 'Category not enabled. Please try again!');
            redirect('categories');
        }
    }

    public function enablebranch($uid)
    {
        $val = array("status" => '1');
        $id = $this->AdminModel->changebranchstatus($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Branch enabled successfully!');
            redirect('branches');
        } else {
            $this->session->set_flashdata('error', 'Branch not enabled. Please try again!');
            redirect('branches');
        }
    }

    public function enablecell($uid)
    {
        $val = array("status" => '1');
        $id = $this->AdminModel->changecellstatus($val, $uid);

        if ($id) {
            $this->session->set_flashdata('success', 'Cell enabled successfully!');
            redirect('cells');
        } else {
            $this->session->set_flashdata('error', 'Cell not enabled. Please try again!');
            redirect('cells');
        }
    }

}