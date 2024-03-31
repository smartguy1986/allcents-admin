<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') or exit('No direct script access allowed');

class UsersController extends CI_Controller
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
        if ($term == 'admin') {
            $conditions = array('userrole' => '1');
            $data['user_info'] = $this->AdminModel->get_admins_info($conditions);
        } else if ($term == 'treasurer') {
            $conditions = array('userrole' => '2');
            $data['user_info'] = $this->AdminModel->get_users_info($conditions);
        } else if ($term == 'user') {
            $conditions = array('userrole' => '3');
            $data['user_info'] = $this->AdminModel->get_users_info($conditions);
        } else {
            $conditions = array();
        }

        $data['term'] = $term;
        $this->load->view('admin/users/userlist', $data);
    }

    public function createuser()
    {
        $data['country_info'] = $this->AdminModel->get_country_info();
        $data['branch_info'] = $this->AdminModel->get_branch_info();
        $data['cell_info'] = $this->AdminModel->get_cell_info();
        $this->load->view('admin/users/createuser', $data);
    }

    public function resetpass($userphone, $usertoken)
    {
        $condition = array("userphone" => $userphone, "usertoken" => $usertoken);
        $data['udata'] = $this->AdminModel->get_user_info_resetpass($condition);
        $this->load->view('admin/passwordresetpage', $data);
    }


    public function add()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // die();
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = substr(time(), -6) . openssl_random_pseudo_bytes(16);
        $token = bin2hex($token);

        $data = array(
            "userrole" => $this->input->post('userrole'),
            "uniqueid" => strtoupper("AAC-" . generate_string($permitted_chars, 10)),
            "userchurchtitle" => $this->input->post('userchurchtitle'),
            "usertitle" => $this->input->post('usertitle'),
            "userfname" => $this->input->post('userfname'),
            "userlname" => $this->input->post('userlname'),
            "userpassword" => MD5($this->input->post('userpassword')),
            "usermail" => $this->input->post('usermail'),
            "userphone" => $this->input->post('userphone'),
            "usergender" => $this->input->post('usergender'),
            "userdob" => $this->input->post('userdob'),
            "useraddress" => $this->input->post('useraddress'),
            "usercountry" => $this->input->post('usercountry'),
            "userprovince" => $this->input->post('userprovince'),
            "userdistrict" => $this->input->post('userdistrict'),
            "userbranch" => $this->input->post('userbranch'),
            "usercell" => $this->input->post('usercell'),
            "user_verified" => '1',
            "usertoken" => $token,
            "userstatus" => $this->input->post('userstatus'),
        );

        if ($this->input->post('userrole') == 3) {
            $id = $this->AdminModel->save_user($data);
            if ($id) {
                $this->session->set_flashdata('success', 'User added successfully!');
                sendpromotionalmail($this->input->post('usermail'), 'welcomemail', '', '');
                redirect('users/filter/user');
            } else {
                $this->session->set_flashdata('error', 'User not added. Please try again!');
                redirect('users/filter/user');
            }
        } else if ($this->input->post('userrole') == 2) {
            $id = $this->AdminModel->save_user($data);
            if ($id) {
                $this->session->set_flashdata('success', 'Treasurer added successfully!');
                sendpromotionalmail($this->input->post('usermail'), 'welcomemail', '', '');
                redirect('users/filter/treasurer');
            } else {
                $this->session->set_flashdata('error', 'Treasurer not added. Please try again!');
                redirect('users/filter/treasurer');
            }
        } else {
            $id = $this->AdminModel->save_admin($data);
            if ($id) {
                $this->session->set_flashdata('success', 'Admin added successfully!');
                sendpromotionalmail($this->input->post('usermail'), 'welcomemail', '', '');
                redirect('users/filter/admin');
            } else {
                $this->session->set_flashdata('error', 'Admin not added. Please try again!');
                redirect('users/filter/admin');
            }
        }
    }

    public function import()
    {
        require_once APPPATH . "/third_party/PHPExcel.php";

        if ($this->input->post('importuser')) {

            $this->load->library('upload');
            $filename = sha1(time() . $_FILES['bulk_file_user']['name']);
            $config['upload_path'] = FCPATH . '/uploads/excelsample/';
            $config['allowed_types'] = 'xlsx|xls|csv';
            $config['remove_spaces'] = TRUE;

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('bulk_file_user')) {
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
                        $data = array();

                        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $token = substr(time(), -6) . openssl_random_pseudo_bytes(16);
                        $token = bin2hex($token);

                        $data = array(
                            "userrole" => $value['A'],
                            "uniqueid" => strtoupper("AAC-" . generate_string($permitted_chars, 10)),
                            "userchurchtitle" => $value['B'],
                            "usertitle" => $value['C'],
                            "userfname" => $value['D'],
                            "userlname" => $value['E'],
                            "userpassword" => MD5("p@ssw0rd"),
                            "usermail" => $value['F'],
                            "userphone" => $value['G'],
                            "usergender" => $value['H'],
                            "userdob" => $value['I'],
                            "useraddress" => $value['J'],
                            "usercountry" => $value['K'],
                            "userprovince" => $value['L'],
                            "userdistrict" => $value['M'],
                            "userbranch" => $value['N'],
                            "usercell" => $value['O'],
                            "user_verified" => "1",
                            "usertoken" => $token,
                            "userstatus" => "1",
                        );

                        if ($value['A'] == 3) {
                            $id = $this->AdminModel->save_user($data);
                        } else if ($value['A'] == 2) {
                            $id = $this->AdminModel->save_user($data);
                        } else {
                            $id = $this->AdminModel->save_admin($data);
                        }
                        $i++;
                    }
                    $this->session->set_flashdata('success', 'Users imported successfully!');
                    redirect('users/filter/user');
                } catch (Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                }
            } else {
                echo $error['error'];
            }
        } else {
            $this->session->set_flashdata('error', 'Import failed. Please try again!');
            redirect('users/filter/user');
        }
    }

    public function profile($uid = null, $term = null)
    {
        if (empty($uid)) {
            redirect('users/filter/admin');
        }

        $conditions = array('id' => $uid);
        if ($term == "admin") {
            $data['userdata'] = $this->AdminModel->get_admin_info($conditions);
        } else {
            $data['userdata'] = $this->AdminModel->get_user_info($conditions);
        }
        $data['term'] = $term;

        $this->load->view('admin/users/profile', $data);
    }

    public function adminprofile($uid = null)
    {
        if (empty($uid)) {
            redirect('users/filter/adminstaff');
        }

        $conditions = array('id' => $uid);
        $data['term'] = 'admin';
        $data['userdata'] = $this->AdminModel->get_admin_info($conditions);
        $this->load->view('admin/users/profile', $data);
    }

    public function update()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // die();

        $token = substr(time(), -6) . openssl_random_pseudo_bytes(16);
        $token = bin2hex($token);
        if (!empty($this->input->post('change_userpassword'))) {
            $data = array(
                "userchurchtitle" => $this->input->post('userchurchtitle'),
                "usertitle" => $this->input->post('usertitle'),
                "userfname" => $this->input->post('userfname'),
                "userlname" => $this->input->post('userlname'),
                "userpassword" => MD5($this->input->post('change_userpassword')),
                "userphone" => $this->input->post('userphone'),
                "usergender" => $this->input->post('usergender'),
                "userdob" => $this->input->post('userdob'),
                "useraddress" => $this->input->post('useraddress'),
                "usercountry" => $this->input->post('usercountry'),
                "userprovince" => $this->input->post('userprovince'),
                "userdistrict" => $this->input->post('userdistrict'),
                "userbranch" => $this->input->post('userbranch'),
                "usercell" => $this->input->post('usercell'),
                "usertoken" => $token,
                "userstatus" => $this->input->post('userstatus'),
            );
        } else {
            $data = array(
                "userchurchtitle" => $this->input->post('userchurchtitle'),
                "usertitle" => $this->input->post('usertitle'),
                "userfname" => $this->input->post('userfname'),
                "userlname" => $this->input->post('userlname'),
                "userphone" => $this->input->post('userphone'),
                "usergender" => $this->input->post('usergender'),
                "userdob" => $this->input->post('userdob'),
                "useraddress" => $this->input->post('useraddress'),
                "usercountry" => $this->input->post('usercountry'),
                "userprovince" => $this->input->post('userprovince'),
                "userdistrict" => $this->input->post('userdistrict'),
                "userbranch" => $this->input->post('userbranch'),
                "usercell" => $this->input->post('usercell'),
                "usertoken" => $token,
                "userstatus" => $this->input->post('userstatus'),
            );
        }
        if ($this->input->post('term') == 'User' || $this->input->post('term') == 'Treasurer') {
            $id = $this->AdminModel->update_user($data, $this->input->post('userid'));
        } else {
            $id = $this->AdminModel->update_adminprofile($data, $this->input->post('userid'));
        }

        if ($id > 0) {
            $this->session->set_flashdata('success', 'User Updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'User not updated!');
        }
        redirect('user/profile/' . $this->input->post('userid') . '/' . strtolower($this->input->post('term')));
    }

    public function disable($uid, $term, $role)
    {
        $val = array("userstatus" => '0');
        $id = $this->AdminModel->changeuserstatus($val, $uid, $role);

        if ($id) {
            $this->session->set_flashdata('success', 'User disabled successfully!');
            redirect('users/filter/' . $term);
        } else {
            $this->session->set_flashdata('error', 'User not disabled. Please try again!');
            redirect('users/filter/' . $term);
        }
    }


    public function enable($uid, $term, $role)
    {
        $val = array("userstatus" => '1');
        $id = $this->AdminModel->changeuserstatus($val, $uid, $role);

        if ($id) {
            $this->session->set_flashdata('success', 'User enabled successfully!');
            redirect('users/filter/' . $term);
        } else {
            $this->session->set_flashdata('error', 'User not enabled. Please try again!');
            redirect('users/filter/' . $term);
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