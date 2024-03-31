<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class ReviewController extends CI_Controller {

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

		if($this->session->userdata('is_logged_in')==0){
			redirect('/'); 
		}
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

	public function index($term=null)
	{       
		$data['review_data'] = $this->AdminModel->get_all_reviews();
		$this->load->view('admin/reviews/reviewlist', $data);
	}

    public function appropve($rid)
    {
        //echo $rid;
        $val = array("status"=>'1');
        $udata = get_device_type_by_rid($rid);
        $lang = $udata[0]['language'];
        // echo "<pre>";
        // print_r($udata);
        // echo "</pre>";
        
        $id = $this->AdminModel->approve_review($val, $rid);
        if($id)
        {
            $this->session->set_flashdata('success', 'Review approved successfully!');
            //$dtype = get_device_type($udata[0]['deviceid']);
            // $dtype->devicetype
            if($lang=='en')
            {
                send_push($udata[0]['deviceid'], "Congrats!", "Your Review has been approved successfully", "individual", 0, $udata[0]['devicetype']);
            }
            if($lang=='zu')
            {
                send_push($udata[0]['deviceid'], "Halala!", "Ukubuyekeza kwakho kuvunywe ngempumelelo", "individual", 0, $udata[0]['devicetype']);
            }
            if($lang=='st')
            {
                send_push($udata[0]['deviceid'], "Kea leboha!", "Tlhahlobo ea hau e amohetsoe ka katleho", "individual", 0, $udata[0]['devicetype']);
            }
            //die();
            redirect('reviews');
        }
        else
        {
            $this->session->set_flashdata('error', 'Technical Error. Please try again!');
            redirect('reviews');
        }
    }

    public function disappropve($rid)
    {
        // echo $rid;
        $val = array("status"=>'0');

        $id = $this->AdminModel->approve_review($val, $rid);
        $udata = get_device_type_by_rid($rid);
        $lang = $udata[0]['language'];
        if($id)
        {
            $this->session->set_flashdata('success', 'Review disapproved successfully!');
            //$dtype = get_device_type($udata[0]['deviceid']);
            // $dtype->devicetype
            if($lang=='en')
            {
                send_push($udata[0]['deviceid'], "Oops!", "Your Review disapproved due to review policy", "individual", 0, $udata[0]['devicetype']);
            }
            if($lang=='zu')
            {
                send_push($udata[0]['deviceid'], "Oops!", "Isibuyekezo sakho asigunyazwanga ngenxa yenqubomgomo yokubuyekeza", "individual", 0, $udata[0]['devicetype']);
            }
            if($lang=='st')
            {
                send_push($udata[0]['deviceid'], "Oops!", "Maikutlo a hau ha a amoheloe ka lebaka la leano la tlhahlobo", "individual", 0, $udata[0]['devicetype']);
            }
            redirect('reviews');
        }
        else
        {
            $this->session->set_flashdata('error', 'Technical Error. Please try again!');
            redirect('reviews');
        }
    }
}
