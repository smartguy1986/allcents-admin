<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class MailTestController extends CI_Controller {

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
	public function __construct(){
		parent::__construct();

		// if($this->session->userdata('is_logged_in')==0){
		// 	redirect('/'); 
		// }        
		$this->load->model('AdminModel');
		// ============= Loading Language ==================
        if (empty($this->session->userdata('site_lang'))) {
            $language = "english";
            $siteLang = $this->session->set_userdata('site_lang', $language);
            $lang = 'en';
            $this->lang->load('homecont', $language);
        }
        if ($this->session->userdata('site_lang') == 'en') {
			$language = "english";
            $lang = 'en';
            $this->lang->load('homecont', $language);
        }
		if ($this->session->userdata('site_lang') == 'zu') {
			$language = "zulu";
            $lang = 'zu';
            $this->lang->load('homecont', $language);
        }
		if ($this->session->userdata('site_lang') == 'xh') {
			$language = "xhosa";
            $lang = 'xh';
            $this->lang->load('homecont', $language);
        }
	}

	public function index()
	{

        $this->load->view('admin/mailtestpage');
	}

    public function sendmailfunc()
    {
        $umail = $this->input->post('usermail');
        $mailtype = $this->input->post('mailtype');

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'allcents.tech',
            'smtp_port' => 465,
            'smtp_user' => 'info@allcents.tech', // change it to yours
            'smtp_pass' => 'Snt@2021#', // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );
        $this->load->library('email');
        // $this->email->set_header('MIME-Version', '1.0; charset=iso-8859-1');
        // $this->email->set_header('Content-type', 'text/html');
        // $this->email->set_newline("\r\n");        
        // $this->email->from('info@allcents.tech', "Admin Team");
        // $this->email->to($umail);  
        // $this->email->subject("Email Verification");
        // //$this->email->message($this->load->view('admin/emailTemplate/testmail', '', true));
        // $htmlContent ='<html><head><title>Welcome to CodexWorld</title></head><body><h1>Thanks you for joining with us!</h1><table cellspacing="0" style="border: 2px dashed #FB4314; width: 100%;"><tr><th>Name:</th><td>CodexWorld</td></tr><tr style="background-color: #e0e0e0;"><th>Email:</th><td>contact@codexworld.com</td></tr><tr><th>Website:</th><td><a href="http://www.codexworld.com">www.codexworld.com</a></td></tr></table></body></html>'; 
        // $this->email->message($htmlContent);


        $to = $umail;
        $subject = "Welcome to Sentebale";

        $message = file_get_contents(base_url().'resources/admin/emailTemplate/'.$mailtype.'.php');
        //$this->load->view('admin/emailTemplate/'.$mailtype);

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <info@allcents.tech>' . "\r\n";

        if(mail($to, $subject, $message, $headers))
        {
            $data['status']="Mail Sent - ".date("d-m-y H:i:s");
        }
        else
        {
            $data['status']="Mail not sent";
        }

        $this->load->view('admin/mailtestpage', $data);
    }
	
}
