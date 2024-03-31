<?php
header('Access-Control-Allow-Origin: *');

require APPPATH . 'libraries/REST_Controller.php';

class Locations extends REST_Controller  {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

	public function index_post()
	{
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
               
        $this->db->select("*");
        $this->db->order_by("ProvinceName", "ASC");
        $data = $this->db->get_where("snr_province", ['status' => '1'])->result();      
            
        $main_arr['info']['description']='Province Lists';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/locations']['POST']['summary']='Get Province List';
        $main_arr['paths']['api/v1/locations']['POST']['description']='All the list of Provinces';
        $main_arr['paths']['api/v1/locations']['POST']['parameters']='';
        if(!empty($data))
        {
            $location_data = array();
            foreach($data as $sdata)
            {
                $this->db->order_by('city_order DESC, RegionName');
                $cdata = $this->db->get_where("snr_region", ['ProvinceID' => $sdata->ProvinceID, 'status' => '1'])->result();    
                $newarray = array("id"=>$sdata->ProvinceID, "state_name"=> $sdata->ProvinceName, "cities" => $cdata);
                array_push($location_data, $newarray);
            }

            // echo "<pre>";
            // print_r($location_data);
            // echo "</pre>";

            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $location_data;

            $log_array = array(
                "api_name" => "Province List",
                "api_method" => "POST",
                "api_data" => json_encode($_POST),
                "api_lang" => $lang,
                "api_status" => 1,
                "ip_addr" => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('snr_api_call_log', $log_array);
        }
        else{
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = '';

            $log_array = array(
                "api_name" => "Province List",
                "api_method" => "POST",
                "api_data" => json_encode($_POST),
                "api_lang" => $lang,
                "api_status" => 0,
                "ip_addr" => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('snr_api_call_log', $log_array);
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function cities_post()
	{
        $pid = $this->input->post('pid');
        $lang = $this->input->post('lang');

        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
               
        $this->db->select("*");
        $this->db->order_by("city_order desc, RegionName asc");
        $data = $this->db->get_where("snr_region", ['ProvinceID' => $pid, 'status' => '1'])->result();          
        $main_arr['info']['description']='Particular City details';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/locations/cities']['POST']['summary']='Get all cities by Province ID';
        $main_arr['paths']['api/v1/locations/cities']['POST']['description']='All the list of cities by Give Province ID';
        $main_arr['paths']['api/v1/locations/cities']['POST']['parameters']='pid';
        if(!empty($data))
        {
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $data;

            $log_array = array(
                "api_name" => "All Cities by Province",
                "api_method" => "POST",
                "api_data" => json_encode($_POST),
                "api_lang" => $lang,
                "api_status" => 1,
                "ip_addr" => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('snr_api_call_log', $log_array);
        }
        else{
            $main_arr['info']['response']['status'] = '0';
            if($lang=='en')
            {
                $main_arr['info']['response']['data'] = 'No Cities listed under this Region';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'Awekho amadolobha abhalwe ngaphansi kwalesi sifunda.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Ha ho na Metse e thathamisitsoeng tlasa Setereke sena.';
            }     
            //$main_arr['info']['response']['data'] = 'No Cities listed under this Region';

            $log_array = array(
                "api_name" => "All Cities by Province",
                "api_method" => "POST",
                "api_data" => json_encode($_POST),
                "api_lang" => $lang,
                "api_status" => 0,
                "ip_addr" => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('snr_api_call_log', $log_array);
        }
        
        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function allcities_post()
	{
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';

        $lang = $this->input->post('lang');
        $uid = $this->input->post('user_id');
               
        $this->db->select("*");
        $this->db->from('snr_region');
        $this->db->where('status','1');
        $this->db->order_by("city_order desc, RegionName");
        $qry = $this->db->get();
        $data = $qry->result();

        $main_arr['info']['description']='All City details';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/locations/allcities']['POST']['summary']='Get all cities list';
        $main_arr['paths']['api/v1/locations/allcities']['POST']['description']='List of all the cities';
        $main_arr['paths']['api/v1/locations/allcities']['POST']['parameters']='';
        if(!empty($data))
        {
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $data;

            $log_array = array(
                "api_name" => "All Cities List",
                "api_method" => "POST",
                "api_data" => json_encode($_POST),
                "api_lang" => $lang,
                "api_status" => 1,
                "ip_addr" => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('snr_api_call_log', $log_array);
        }
        else{
            $main_arr['info']['response']['status'] = '0';
            if($lang=='en')
            {
                $main_arr['info']['response']['data'] = 'No Cities listed.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'Awekho amadolobha afakwe kuhlu.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Ha ho Metse e thathamisitsoeng.';
            } 
            //$main_arr['info']['response']['data'] = 'No Cities listed';

            $log_array = array(
                "api_name" => "All Cities List",
                "api_method" => "POST",
                "api_data" => json_encode($_POST),
                "api_lang" => $lang,
                "api_status" => 0,
                "ip_addr" => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('snr_api_call_log', $log_array);
        }
        
        $this->response($main_arr, REST_Controller::HTTP_OK);
	}
}
