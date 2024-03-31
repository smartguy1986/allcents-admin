<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') or exit('No direct script access allowed');

class ResetController extends CI_Controller
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
        // if($this->session->userdata('is_logged_in')==1){
        // 	redirect('dashboard'); 
        // }
        $this->load->model('AdminModel');
    }

    public function index($userphone, $utoken)
    {
        $data = array();
        $conditions = array("userphone" => $userphone, "usertoken" => $utoken);
        $udata = $this->AdminModel->find_user($conditions);
        if (!empty($udata)) {
            $data['udata'] = $udata;
            $data['umail'] = $udata->usermail;
            $data['msg'] = "Please enter new password";
        } else {
            $data['umail'] = '';
            $data['msg'] = "Either this email does not exist or the link has expired. Please try again.";

        }
        $this->load->view('admin/passwordresetpage', $data);
    }

    public function passwordreset()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        // die();

        $usermail = $this->input->post('usermail');
        $userid = $this->input->post('userid');
        $newpass = $this->input->post('newpass');
        $cnfpass = $this->input->post('confirmpass');

        $token = substr(time(), -6) . openssl_random_pseudo_bytes(16);
        $token = bin2hex($token);

        if ($newpass == $cnfpass) {
            $hashedpass = MD5($newpass);
            $data = array(
                "userpassword" => $hashedpass,
                "usertoken" => $token
            );

            $id = $this->AdminModel->update_user($data, $userid);
            if ($id > 0) {
                //$this->session->set_flashdata('success', 'Password Reset successfully!');                
                $conditions = array('id' => $userid);
                $userdata = $this->AdminModel->get_user_info($conditions);
                $data['msg'] = "Your password has been reset successfully. Please login to the app.";
                //print_r($userdata);
                // send_push($userdata->deviceid, "Congratulations " . $userdata->userfname, "Your password has been reset successfully", "individual", $id, $userdata->devicetype);
                $this->load->view('admin/verifypage', $data);
            }
        } else {
            $data['msg'] = "There is a problem with confirm password, please try again.";
            //$this->session->set_flashdata('error', 'Confirm password did not match with New Password!');
            $this->load->view('admin/verifypage', $data);
        }
    }

}