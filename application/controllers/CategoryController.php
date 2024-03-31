<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') or exit('No direct script access allowed');

class CategoryController extends CI_Controller
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
        $data['categories'] = $this->AdminModel->get_category_info();
        $this->load->view('admin/category/categorylist', $data);
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
        $id = $this->AdminModel->save_category($data);
        if ($id) {
            $this->session->set_flashdata('success', 'Category added successfully!');
            redirect('categories');
        } else {
            $this->session->set_flashdata('error', 'Category not added. Please try again!');
            redirect('categories');
        }
    }

    public function branchadd()
    {
        // echo "<pre>";
        // print_r($_POST);
        // print_r($_FILES);
        // echo "</pre>";       

        if (!empty($_FILES['bulk_file_branch'])) {
            require_once APPPATH . "/third_party/PHPExcel.php";

            if ($this->input->post('addbranch')) {
                $this->load->library('upload');
                $filename = sha1(time() . $_FILES['bulk_file_branch']['name']);
                $config['upload_path'] = FCPATH . '/uploads/excelsample/';
                $config['allowed_types'] = 'xlsx|xls|csv';
                $config['remove_spaces'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('bulk_file_branch')) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $data = array('upload_data' => $this->upload->data());
                }
                if (empty($error)) {
                    if (!empty($data['upload_data']['file_name'])) {
                        $import_xls_file = $data['upload_data']['file_name'];
                    } else {
                        $import_xls_file = 0;
                    }
                    $inputFileName = FCPATH . '/uploads/excelsample/' . $import_xls_file;
                    try {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFileName);
                        $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                        $flag = true;
                        $i = 0;
                        foreach ($allDataInSheet as $value) {
                            if ($flag) {
                                $flag = false;
                                continue;
                            }
                            $inserdata[$i]['branch_name'] = $value['A'];
                            $inserdata[$i]['district_id'] = $value['B'];
                            $inserdata[$i]['status'] = '1';

                            // echo "<pre>";
                            // print_r($inserdata[$i]);
                            // echo "</pre>";                            

                            $id = $this->AdminModel->save_branch($inserdata[$i]);
                            $i++;
                        }
                        $this->session->set_flashdata('success', 'Branches imported successfully!');
                        redirect('branches');
                    } catch (Exception $e) {
                        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                    }
                } else {
                    echo $error['error'];
                }
            }
        } else {
            $data = array(
                "branch_name" => $this->input->post('branch_name'),
                "status" => '1'
            );
            $id = $this->AdminModel->save_branch($data);
            if ($id) {
                $this->session->set_flashdata('success', 'Branch added successfully!');
                redirect('branches');
            } else {
                $this->session->set_flashdata('error', 'Branch not added. Please try again!');
                redirect('branches');
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

    public function deletecat($uid)
    {
        $id = $this->AdminModel->deletecatandevent($uid);
        $this->session->set_flashdata('success', 'Category deleted successfully!');
        redirect('categories');
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

    public function deletebranch($uid)
    {
        $this->AdminModel->deletebranchentry($uid);
        $this->session->set_flashdata('success', 'Branch deleted successfully!');
        redirect('branches');
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

    public function deletecell($uid)
    {
        $id = $this->AdminModel->deletecellentry($uid);

        $this->session->set_flashdata('success', 'Cell deleted successfully!');
        redirect('cells');
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
