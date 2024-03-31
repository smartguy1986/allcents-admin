<?php
if (!defined('BASEPATH'))
    exit('Direct access allowed');

class Languageswitcher extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('url');
        $this->load->library('user_agent');
        $this->load->library('session');
    }

    function switchlang($language = NULL) {
        //echo $language;
        // if (!empty($language)) {
        //     $this->session->set_userdata('site_lang', $language);
        //     redirect($this->agent->referrer(), 'refresh');
        // } else {
            $language = 'en';
            $this->session->set_userdata('site_lang', $language);
            redirect($this->agent->referrer(), 'refresh');
        // }
    }

}
