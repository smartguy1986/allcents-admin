<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') or exit('No direct script access allowed');

class FuneralController extends CI_Controller
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
        $data['policies'] = $this->AdminModel->get_policies();
        $this->load->view('admin/funeral/policylist', $data);
    }

    public function createpolicy()
    {
        $this->load->view('admin/funeral/createpolicy');
    }

    public function add()
    {
        if (!empty($_FILES['policy_logo']['name'])) {
            $this->load->library('upload');

            $filename = sha1(time() . $_FILES['policy_logo']['name']);
            $config['upload_path'] = FCPATH . '/uploads/policies/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '409600';
            $config['file_name'] = $filename;
            $config['create_thumb'] = TRUE;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('policy_logo')) {
                $imageDetailArray = $this->upload->data();
                $image = $imageDetailArray['file_name'];
            }

        } else {
            $image = '';
        }

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = substr(time(), -6) . openssl_random_pseudo_bytes(16);
        $token = bin2hex($token);

        $data = array(
            "policy_id" => strtoupper("ACP-" . generate_string($permitted_chars, 8)),
            "policy_title" => $this->input->post('policy_title'),
            "policy_payout" => $this->input->post('policy_payout'),
            "policy_member" => $this->input->post('policy_member'),
            "policy_benifits" => $this->input->post('policy_benifits'),
            "policy_waiting" => $this->input->post('policy_waiting'),
            "policy_claim" => $this->input->post('policy_claim'),
            "policy_description" => $this->input->post('policy_description'),
            "policy_logo" => $image,
            "policy_premium" => $this->input->post('policy_premium'),
            "policy_status" => $this->input->post('policy_status'),
        );
        $id = $this->AdminModel->save_policy($data);

        if (!empty($_FILES['policy_files']['name']) && count(array_filter($_FILES['policy_files']['name'])) > 0) {
            $this->load->library('upload');
            echo $filesCount = count($_FILES['policy_files']['name']);
            echo "<pre>";
            print_r($_FILES['policy_files']);
            echo "</pre>";
            $files = $_FILES;
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['policy_files']['name'] = time() . $_FILES['policy_files']['name'][$i];
                $_FILES['policy_files']['type'] = $files['policy_files']['type'][$i];
                $_FILES['policy_files']['tmp_name'] = $files['policy_files']['tmp_name'][$i];
                $_FILES['policy_files']['error'] = $files['policy_files']['error'][$i];
                $_FILES['policy_files']['size'] = $files['policy_files']['size'][$i];

                $this->upload->initialize($this->set_upload_options());
                $this->upload->do_upload('policy_files');
                $fileData = $this->upload->data();
                $uploadData = array('file_name' => $fileData['file_name'], 'policy_id' => $id);
                $rid = $this->AdminModel->save_policy_files($uploadData);
            }
        }
        if ($id) {
            $this->session->set_flashdata('success', 'Policy added successfully!');
            redirect('policies');
        } else {
            $this->session->set_flashdata('error', 'Policy not added. Please try again!');
            redirect('policies');
        }
    }

    public function details($pid = null)
    {
        if (empty($pid)) {
            redirect('dashboard');
        }

        $conditions = array('id' => $pid);
        $data['policy_data'] = $this->AdminModel->get_policy_info($conditions);
        $this->load->view('admin/funeral/policies', $data);
    }

    public function update()
    {
        // echo "<pre>";
        // print_r($_POST);
        // print_r($_FILES);
        // echo "</pre>";
        // die();

        if (!empty($_FILES['policy_logo']['name'])) {
            $this->load->library('upload');

            $filename = sha1(time() . $_FILES['policy_logo']['name']);
            $config['upload_path'] = FCPATH . '/uploads/policies/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '409600';
            $config['file_name'] = $filename;
            $config['create_thumb'] = TRUE;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('policy_logo')) {
                $imageDetailArray = $this->upload->data();
                $image = $imageDetailArray['file_name'];
            }

            if (!empty($this->input->post('policy_logo_old'))) {
                $path = FCPATH . 'uploads/policies/' . $this->input->post('policy_logo_old');
                if (file_exists($path)) {
                    unlink($path);
                }
            }

        } else {
            $image = $this->input->post('policy_logo_old');
        }

        $pid = $this->input->post('id');
        $data = array(
            "policy_title" => $this->input->post('policy_title'),
            "policy_payout" => $this->input->post('policy_payout'),
            "policy_member" => $this->input->post('policy_member'),
            "policy_benifits" => $this->input->post('policy_benifits'),
            "policy_waiting" => $this->input->post('policy_waiting'),
            "policy_claim" => $this->input->post('policy_claim'),
            "policy_description" => $this->input->post('policy_description'),
            "policy_logo" => $image,
            "policy_premium" => $this->input->post('policy_premium'),
            "policy_status" => $this->input->post('policy_status'),
        );

        if (!empty($_FILES['policy_files']['name']) && count(array_filter($_FILES['policy_files']['name'])) > 0) {
            $this->load->library('upload');
            $filesCount = count($_FILES['policy_files']['name']);
            // echo "<pre>";
            // print_r($_FILES['policy_files']);
            // echo "</pre>";
            $files = $_FILES;
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['policy_files']['name'] = time() . $_FILES['policy_files']['name'][$i];
                $_FILES['policy_files']['type'] = $files['policy_files']['type'][$i];
                $_FILES['policy_files']['tmp_name'] = $files['policy_files']['tmp_name'][$i];
                $_FILES['policy_files']['error'] = $files['policy_files']['error'][$i];
                $_FILES['policy_files']['size'] = $files['policy_files']['size'][$i];

                $this->upload->initialize($this->set_upload_options());
                $this->upload->do_upload('policy_files');
                $fileData = $this->upload->data();
                $uploadData = array('file_name' => $fileData['file_name'], 'policy_id' => $this->input->post('id'));
                $rid = $this->AdminModel->save_policy_files($uploadData);
            }
        }

        $id = $this->AdminModel->update_policy($data, $this->input->post('id'));

        if ($id > 0) {
            $this->session->set_flashdata('success', 'Policy Updated successfully!');
            redirect('policies');
        } else {
            if ($rid > 0) {
                $this->session->set_flashdata('success', 'Policy Files Updated successfully!');
                redirect('policies');
            } else {
                $this->session->set_flashdata('error', 'Policy not updated!');
                redirect('policies');
            }
        }
    }

    private function set_upload_options()
    {
        //upload an image options
        $config = array();
        $config['upload_path'] = FCPATH . '/uploads/policies/';
        $config['allowed_types'] = 'doc|docx|pdf|ppt|pptx|txt';
        $config['max_size'] = '0';
        $config['overwrite'] = FALSE;

        return $config;
    }

    public function filedelete($fid, $pid)
    {
        $val = array("id" => $fid);
        $filedetails = $this->AdminModel->get_file_details($val);
        print_r($filedetails);
        if ($filedetails) {
            if (!empty($filedetails->file_name)) {
                $path = FCPATH . 'uploads/policies/' . $filedetails->file_name;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $id = $this->AdminModel->deletefile($val);
            if ($id) {
                $this->session->set_flashdata('success', 'File Deleted successfully!');
                redirect('policies/details/' . $pid);
            } else {
                $this->session->set_flashdata('error', 'File not deleted. Please try again!');
                redirect('policies/details/' . $pid);
            }
        } else {
            $this->session->set_flashdata('error', 'File dont exist. Please try again!');
            redirect('policies/details/' . $pid);
        }
    }

    public function disable($pid)
    {
        $val = array("policy_status" => '0');
        $id = $this->AdminModel->changepolicystatus($val, $pid);

        if ($id) {
            $this->session->set_flashdata('success', 'Policy disabled successfully!');
            redirect('policies');
        } else {
            $this->session->set_flashdata('error', 'Policy not disabled. Please try again!');
            redirect('policies');
        }
    }


    public function enable($pid)
    {
        $val = array("policy_status" => '1');
        $id = $this->AdminModel->changepolicystatus($val, $pid);

        if ($id) {
            $this->session->set_flashdata('success', 'Policy enabled successfully!');
            redirect('policies');
        } else {
            $this->session->set_flashdata('error', 'Policy not enabled. Please try again!');
            redirect('policies');
        }
    }

    public function getprovince()
    {
        $countryId = $this->input->post('cid');
        $conditions = array("country" => $countryId);
        $provinceLists = $this->AdminModel->getprovincelist($conditions);
        $htmlDatatoDisplay = "";
        $htmlDatatoDisplay .= "<option value=''>Select Province</option>";
        foreach ($provinceLists as $provinces) {
            $htmlDatatoDisplay .= "<option value='" . $provinces->provinceid . "'>" . $provinces->provincename . "</option>";
        }
        echo $htmlDatatoDisplay;
    }

    public function getdistrict()
    {
        $province_name = $this->input->post('pname');
        $districtLists = $this->AdminModel->getdistrictlist($province_name);
        $htmlDatatoDisplay2 = "";
        $htmlDatatoDisplay2 .= "<option value=''>Select District</option>";
        foreach ($districtLists as $districts) {
            $htmlDatatoDisplay2 .= "<option value='" . $districts->id . "'>" . $districts->district_name . "</option>";
        }
        echo $htmlDatatoDisplay2;
    }
}