<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class VerifyController extends CI_Controller {

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
        // if($this->session->userdata('is_logged_in')==1){
		// 	redirect('dashboard'); 
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

	public function index($uid, $utoken, $lang)
	{
        // $usermail = $email;
        // echo "<br>";
        // echo $uid;
        // echo "<br>";
        // echo $utoken;

        //$conditions = array("usermail"=>urldecode($email), "id"=> $uid, "usertoken"=>$utoken);
        $conditions = array("id"=> $uid, "usertoken"=>$utoken);
        $udata = $this->AdminModel->find_user($conditions);
        // echo "<pre>";
        // print_r($udata);
        // echo "</pre>";
        if(!empty($udata))
        {
            $usermail = $udata->usermail;
            if($udata->user_verified==1)
            {
                if($lang=='en')
                {
                    $data['msg']="Your account is already verified. Please login via app and start exploring Sentebale.";
                }
                if($lang=='zu')
                {
                    $data['msg']="I-akhawunti yakho isivele iqinisekisiwe. Sicela ungene ngemvume ngohlelo lokusebenza bese uqala ukuhlola i-Sentebale.";
                }
                if($lang=='st')
                {
                    $data['msg']="Ak'haonte ea hau e se e netefalitsoe. Ka kopo, kena ka app 'me u qale ho hlahloba Sentebale.";
                }
            }
            else
            {
                $data = array("user_verified"=>'1');
                $this->AdminModel->verify_user($data, $uid);
                if($lang=='en')
                {
                    $data['msg']="Your account has been verified successfully. Please login to the app and start exploring Sentebale.";
                }
                if($lang=='zu')
                {
                    $data['msg']="I-akhawunti yakho iqinisekiswe ngempumelelo. Sicela ungene kuhlelo lokusebenza bese uqala ukuhlola i-Sentebale.";
                }
                if($lang=='st')
                {
                    $data['msg']="Ak'haonte ea hau e netefalitsoe ka katleho. Ka kopo, kena ho app 'me u qale ho hlahloba Sentebale.";
                }
                
                $status = sendpromotionalmail($usermail, 'verifiedmail', 'Your Sentebale Account Verified Successfully', '', $lang);

                $status2 = sendpromotionalmail($usermail, 'welcomemail', 'Welcome to Sentebale Health App', '', $lang);

                if(!empty($udata->deviceid))
                {
                    $dtype = get_device_type($udata->deviceid);
                    // $dtype->devicetype
                    if($lang=='en')
                    {
                        send_push($udata->deviceid, "Congrats! You're successfully Verified.", "Please login and explore Sentebale Health App", "individual", 0, $dtype->devicetype);
                    }
                    if($lang=='zu')
                    {
                        send_push($udata->deviceid, "Halala! Uqinisekiswe ngempumelelo.", "Sicela ungene ngemvume futhi uhlole i-Sentebale Health App", "individual", 0, $dtype->devicetype);
                    }
                    if($lang=='st')
                    {
                        send_push($udata->deviceid, "Kea leboha! O netefalitsoe ka katleho.", "Ka kopo, kena 'me u hlahlobe Sentebale Health App", "individual", 0, $dtype->devicetype);
                    }
                }
            }
        }
        else
        {
            if($lang=='en')
            {
                $data['msg']="Sorry!! Either this account does not exist or the link has expired. Please try again.";
            }
            if($lang=='zu')
            {
                $data['msg']="Uxolo!! Kungenzeka ukuthi le akhawunti ayikho noma isixhumanisi siphelelwe yisikhathi. Ngicela uzame futhi.";
            }
            if($lang=='st')
            {
                $data['msg']="Tshwarelo!! Mohlomong ak'haonte ena ha e eo kapa sehokelo se feletsoe ke nako. Ka kopo, leka hape.";
            }
            
        }
        $this->load->view('admin/verifypage', $data);
	}

    
}
