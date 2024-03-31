<?php
header('Access-Control-Allow-Origin: *');
require APPPATH . 'libraries/REST_Controller.php';
class General extends REST_Controller  {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function index_get($lang = null)
	{
        
	}
    public function homepage2_post()
	{
        $lang = $this->input->post('lang');
        $u_lat = $this->input->post('lat');
        $u_long = $this->input->post('long');
        $uid = $this->input->post('user_id');
        //$city = $this->input->post('city');

        if($this->input->post('device_id'))
        {
            $deviceid = $this->input->post('device_id');
            $val = array("user_lat" => $u_lat, "user_long" => $u_long, "deviceid" => $deviceid);
            if($uid)
            {
                $this->db->where('id', $uid);
                $this->db->update('snr_users', $val); 

                $this->db->where('deviceid', $deviceid);
                $this->db->delete('snr_deviceid_lists');
            }
            else
            {
                $val2 = array("deviceid" => $deviceid);
                $this->db->insert('snr_deviceid_lists', $val2);
            } 
        }
        else
        {
            if($uid)
            {
                $val = array("user_lat" => $u_lat, "user_long" => $u_long);
                $this->db->where('id', $uid);
                $this->db->update('snr_users', $val); 
            }
        }   
           
        $insertId = '';
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
        
        $main_arr['info']['description']='Content Details of APP\'s home page';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        
        if($lang=='en')
        {
            $main_arr['info']['language']='English';
            $main_heading = "Welcome to Sentebale";
            $sub_heading = "<div style='color:#EFEFEF; text-align:center !important; margin:0px auto;'>powered by <span style='color:#fc894a;'><u>Dr. Tlaleng Mofokeng</u></span> (MBChB)</div>";
            // $main_text = "Providing stigma-free, evidence-based and comprehensive information about sexual and reproductive health (SRH).";
            $main_text = "Your personal Sexual and Reproductive health guide.";
            $button_text = "Explore Sentebale";
        }
        if($lang=='zu')
        {
            $main_arr['info']['language']='Zulu';
            $main_heading = "Uyemukelwa e-Sentebale";
            $sub_heading = "<div style='color:#EFEFEF; text-align:center !important; margin:0px auto;'>inikezwe amandla yi <span style='color:#fc894a;'>Dr. Tlaleng Mofokeng</span> (MBChB)</div>";
            //$main_text = "Ukuhlinzeka ngolwazi olungenabandlululo, olususelwa ebufakazini nolubanzi mayelana nempilo yezocansi nokuzala (i-SRH).";
            $main_text = "Igayidi yakho yezempilo yezocansi kanye nokuzala.";
            $button_text = "Hlola i-Sentebale";
        }
        if($lang=='st')
        {
            $main_arr['info']['language']='Sesotho';
            $main_heading = "O amoheleile ho Sentebale";
            $sub_heading = "<div style='color:#EFEFEF; text-align:center !important; margin:0px auto;'>E tshehetswa ke <span style='color:#fc894a;'>Dr. Tlaleng Mofokeng</span> (MBChB)</div>";
            //$main_text = "Ho fana ho senang sekgobo, ho thehilweng ka bopaki le";
            $main_text = "Tataiso ea hau ea bophelo bo botle ba Thobalano le Pelehi.";
            $button_text = "Hlahloba Sentebale";
        }
        $main_arr['paths']['api/v1/general/homepage']['POST']['summary']='Home Page content the app';
        $main_arr['paths']['api/v1/general/homepage']['POST']['description']='This API will return all the contents required for the Home Page of the APP';
        $main_arr['paths']['api/v1/general/homepage']['POST']['parameters']='lang';        
        
        $this->db->select('company_logo');
        $qr = $this->db->get('snr_company_info');
        $logo_link = $qr->row();
        $data = array(
            "logo_link" => base_url()."uploads/company/".$logo_link->company_logo,
            "main_heading" => $main_heading,
            "sub_heading" => $sub_heading,
            "main_text" => $main_text,
            "button_text" => $button_text
        );

        /* ====================================== */

        // $this->db->select('RegionID, ProvinceID, RegionName');
        // $this->db->like('RegionName', $city);
        // $qry = $this->db->get('snr_region')->result();

        // // echo "<pre>";
        // // print_r($qry);
        // // echo "</pre>";

        // if($city && (count($qry)>0))
        // {
            // $qry2 = $this->db->query("SELECT RegionID, ProvinceID, RegionName FROM `snr_region` WHERE `status`='1' ORDER BY `RegionName`='".$city."' DESC, `city_order` DESC, `RegionName` ASC");
            // $datalc = $qry2->result();
        // }
        // else
        // {
        //     $qry2 = $this->db->query("SELECT RegionID, ProvinceID, RegionName FROM `snr_region` WHERE `status`='1' ORDER BY `city_order` DESC, `RegionName` ASC");
        //     $datalc = $qry2->result();
        // }

        // echo "<pre>";
        // print_r($datalc);
        // echo "</pre>";
        
        /* ====================================== */

        $main_arr['info']['response']['status'] = '1';
        $main_arr['info']['response']['data'] = $data;
        $main_arr['info']['response']['data']['locations'] = "";

        $log_array = array(
            "api_name" => "Home Page 2",
            "api_method" => "POST",
            "api_data" => json_encode($_POST),
            "api_lang" => $lang,
            "api_status" => 1,
            "ip_addr" => $_SERVER['REMOTE_ADDR']
        );
        $this->db->insert('snr_api_call_log', $log_array);
        
        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function homepage_post()
	{
        $lang = $this->input->post('lang');
        $u_lat = $this->input->post('lat');
        $u_long = $this->input->post('long');
        $uid = $this->input->post('user_id');
        
        $deviceid = $this->input->post('device_id');
        $devicetype = $this->input->post('devicetype');

        if($uid)
        {
            $val = array("deviceid" => $deviceid, "devicetype" => $devicetype);
            $this->db->where('id', $uid);
            $this->db->update('snr_users', $val);

            $this->db->where('deviceid', $deviceid);
            $this->db->delete('snr_deviceid_lists');
        }
        // else
        // {
        //     $val2 = array("deviceid" => $deviceid, "devicetype" => $devicetype);
        //     $this->db->insert('snr_deviceid_lists', $val2);
        // }
           
        $insertId = '';
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
        
        $main_arr['info']['description']='Content Details of APP\'s home page';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        
        if($lang=='en')
        {
            $main_arr['info']['language']='English';
            $main_heading = "Welcome to Sentebale";
            $sub_heading = "<div style='color:#EFEFEF; text-align:center !important; margin:0px auto;'>powered by <span style='color:#fc894a;'><u>Dr. Tlaleng Mofokeng</u></span> (MBChB)</div>";
            //$main_text = "Providing stigma-free, evidence-based and comprehensive information about sexual and reproductive health (SRH).";
            $main_text = "Your personal Sexual and Reproductive health guide.";
            $button_text = "Explore Sentebale";
        }
        if($lang=='zu')
        {
            $main_arr['info']['language']='Zulu';
            $main_heading = "Uyemukelwa e-Sentebale";
            $sub_heading = "<div style='color:#EFEFEF; text-align:center !important; margin:0px auto;'>inikezwe amandla yi <span style='color:#fc894a;'>Dr. Tlaleng Mofokeng</span> (MBChB)</div>";
            // $main_text = "Ukuhlinzeka ngolwazi olungenabandlululo, olususelwa ebufakazini nolubanzi mayelana nempilo yezocansi nokuzala (i-SRH).";
            $main_text = "Igayidi yakho yezempilo yezocansi kanye nokuzala.";
            $button_text = "Hlola i-Sentebale";
        }
        if($lang=='st')
        {
            $main_arr['info']['language']='Sesotho';
            $main_heading = "O amoheleile ho Sentebale";
            $sub_heading = "<div style='color:#EFEFEF; text-align:center !important; margin:0px auto;'>E tshehetswa ke <span style='color:#fc894a;'>Dr. Tlaleng Mofokeng</span> (MBChB)</div>";
            //$main_text = "Ho fana ho senang sekgobo, ho thehilweng ka bopaki le";
            $main_text = "Tataiso ea hau ea bophelo bo botle ba Thobalano le Pelehi.";
            $button_text = "Hlahloba Sentebale";
        }
        $main_arr['paths']['api/v1/general/homepage']['POST']['summary']='Home Page content the app';
        $main_arr['paths']['api/v1/general/homepage']['POST']['description']='This API will return all the contents required for the Home Page of the APP';
        $main_arr['paths']['api/v1/general/homepage']['POST']['parameters']='lang';        
        
        $this->db->select('company_logo');
        $qr = $this->db->get('snr_company_info');
        $logo_link = $qr->row();
        $data = array(
            "logo_link" => base_url()."uploads/company/".$logo_link->company_logo,
            "main_heading" => $main_heading,
            "sub_heading" => $sub_heading,
            "main_text" => $main_text,
            "button_text" => $button_text
        );

        $main_arr['info']['response']['status'] = '1';
        $main_arr['info']['response']['data'] = $data;        

        $this->db->select('id, user_id, status');
        $this->db->where('user_id', $uid);
        $this->db->where('status', '1');
        $pd = $this->db->get('snr_period')->result();
        if(count($pd)>0)
        {
            $main_arr['info']['response']['data']['is_period'] = '1';
        }
        else
        {
            $main_arr['info']['response']['data']['is_period'] = '0';
        }

        if(empty($this->input->post('city')) || empty($this->input->post('lat')) || empty($this->input->post('long')))
        {
            $city = 'Johannesburg';
            $qry2 = $this->db->query("SELECT `RegionID`, `ProvinceID`, `RegionName` FROM `snr_region` WHERE `RegionID`='159' LIMIT 0,1");
            $datalc = $qry2->result();
            $main_arr['info']['response']['data']['locations'] = $datalc;
        }
        else
        {
            $city = $this->input->post('city');
        }

        if($uid)
        {
            $city_array = array('current_city' => $city, 'user_lat' => $this->input->post('lat'), 'user_long' => $this->input->post('long'));
            $this->db->where('id', $uid);
            $this->db->update('snr_users', $city_array);
        }
        /* ====================================== */
        // if(empty($this->input->post('city')))
        // {
        //     $qry2 = $this->db->query("SELECT `RegionID`, `ProvinceID`, `RegionName` FROM `snr_region` WHERE `RegionID`='159' LIMIT 0,1");
        //     $datalc = $qry2->result();
        //     $main_arr['info']['response']['data']['locations'] = $datalc;
        // }
        /* ====================================== */
        // $main_arr['info']['response']['data']['locations'] = $datalc;
        //$main_arr['info']['response']['data']['locations'] = "";

        $log_array = array(
            "api_name" => "Home Page",
            "api_method" => "POST",
            "api_data" => json_encode($_POST),
            "api_lang" => $lang,
            "api_status" => 1,
            "ip_addr" => $_SERVER['REMOTE_ADDR']
        );
        $this->db->insert('snr_api_call_log', $log_array);
        
        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function homepage2021_post()
	{
        $lang = $this->input->post('lang');
        $u_lat = $this->input->post('lat');
        $u_long = $this->input->post('long');
        $uid = $this->input->post('user_id');
        $city = $this->input->post('city');
        $deviceid = $this->input->post('device_id');

        $ch = curl_init('http://api.positionstack.com/v1/reverse?access_key=802f594dca38113840966e22061f8fe4&query='.$u_lat.','.$u_long.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $json = curl_exec($ch);
        
        curl_close($ch);
        
        $apiResult = json_decode($json, true);
        
        $province = $apiResult['data'][0]['region'];
        $pid = getprovinceid($province)->ProvinceID;
          
        if($uid)
        {
            $val = array("user_lat" => $u_lat, "user_long" => $u_long, "deviceid" => $deviceid);
            $this->db->where('id', $uid);
            $this->db->update('snr_users', $val);

            $this->db->where('deviceid', $deviceid);
            $this->db->delete('snr_deviceid_lists');
        }
        else
        {
            $val2 = array("deviceid" => $deviceid);
            $this->db->insert('snr_deviceid_lists', $val2);
        }
           
        $insertId = '';
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
        
        $main_arr['info']['description']='Content Details of APP\'s home page';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        
        if($lang=='en')
        {
            $main_arr['info']['language']='English';
            $main_heading = "Welcome to Sentebale";
            $sub_heading = "<div style='color:#EFEFEF; text-align:center !important; margin:0px auto;'>powered by <span style='color:#fc894a;'><u>Dr. Tlaleng Mofokeng</u></span> (MBChB)</div>";
            $main_text = "Providing stigma-free, evidence-based and comprehensive information about sexual and reproductive health (SRH).";
            $button_text = "Explore Sentebale";
        }
        if($lang=='zu')
        {
            $main_arr['info']['language']='Zulu';
            $main_heading = "Uyemukelwa e-Sentebale";
            $sub_heading = "<div style='color:#EFEFEF; text-align:center !important; margin:0px auto;'>inikezwe amandla yi <span style='color:#fc894a;'>Dr. Tlaleng Mofokeng</span> (MBChB)</div>";
            $main_text = "Ukuhlinzeka ngolwazi olungenabandlululo, olususelwa ebufakazini nolubanzi mayelana nempilo yezocansi nokuzala (i-SRH).";
            $button_text = "Hlola i-Sentebale";
        }
        if($lang=='st')
        {
            $main_arr['info']['language']='Sesotho';
            $main_heading = "O amoheleile ho Sentebale";
            $sub_heading = "<div style='color:#EFEFEF; text-align:center !important; margin:0px auto;'>E tshehetswa ke <span style='color:#fc894a;'>Dr. Tlaleng Mofokeng</span> (MBChB)</div>";
            $main_text = "Ho fana ho senang sekgobo, ho thehilweng ka bopaki le";
            $button_text = "Hlahloba Sentebale";
        }
        $main_arr['paths']['api/v1/general/homepage']['POST']['summary']='Home Page content the app';
        $main_arr['paths']['api/v1/general/homepage']['POST']['description']='This API will return all the contents required for the Home Page of the APP';
        $main_arr['paths']['api/v1/general/homepage']['POST']['parameters']='lang';        
        
        $this->db->select('company_logo');
        $qr = $this->db->get('snr_company_info');
        $logo_link = $qr->row();
        $data = array(
            "logo_link" => base_url()."uploads/company/".$logo_link->company_logo,
            "main_heading" => $main_heading,
            "sub_heading" => $sub_heading,
            "main_text" => $main_text,
            "button_text" => $button_text
        );

        /* ====================================== */
        // $qry2 = $this->db->query("SELECT `ProvinceID`, `ProvinceName` FROM `snr_province` WHERE `status`='1' ORDER BY (`ProvinceName` LIKE '%".$province."%') DESC,`ProvinceName` ASC");
        // $datalc = $qry2->result();   
        $qry2 = $this->db->query("SELECT `RegionID`, `ProvinceID`, `RegionName` FROM `snr_region` WHERE `ProvinceID`='".$pid."' ORDER BY (`RegionName` LIKE '%".$city."%') DESC,`city_order` DESC");
        $datalc = $qry2->result();     
        /* ====================================== */

        $main_arr['info']['response']['status'] = '1';
        $main_arr['info']['response']['data'] = $data;
        $main_arr['info']['response']['data']['locations'] = $datalc;
        
        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function admindetails_post()
	{
        $lang = $this->input->post('lang');

        $insertId = '';
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
        
        $main_arr['info']['description']='Content Details of Admin';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        if($lang=='en')
        {
            $main_arr['info']['language']='English';
        }
        if($lang=='zu')
        {
            $main_arr['info']['language']='Zulu';
        }
        if($lang=='st')
        {
            $main_arr['info']['language']='Sesotho';
        }
        $main_arr['paths']['api/v1/general/admindetails']['POST']['summary']='Admin content of the app';
        $main_arr['paths']['api/v1/general/admindetails']['POST']['description']='This API will return all the admin contents required for Admin Page of the APP';
        $main_arr['paths']['api/v1/general/admindetails']['POST']['parameters']='lang';
        $this->db->select('*');
        $qr = $this->db->get('snr_admin');
        $admin = $qr->row();
        $rght = "highlight_section_".$lang;
        $varbl = "admin_bio_".$lang;
        $data = array(
            "admin_image" => base_url()."uploads/admin/".$admin->admin_image,
            "admin_name" => $admin->admin_name,
            "admin_right_section" => $admin->$rght,
            "admin_bio" => $admin->$varbl,
        );
        $main_arr['info']['response']['status'] = '1';
        $main_arr['info']['response']['data'] = $data;

        $log_array = array(
            "api_name" => "Admin Details",
            "api_method" => "POST",
            "api_data" => json_encode($_POST),
            "api_lang" => $lang,
            "api_status" => 1,
            "ip_addr" => $_SERVER['REMOTE_ADDR']
        );
        $this->db->insert('snr_api_call_log', $log_array);
        
        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function save_userlocation_post()
	{
        $lang = $this->input->post('lang');
        $uid = $this->input->post('user_id');
        $u_lat = $this->input->post('user_lat');
        $u_long = $this->input->post('user_long');
        
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
        
        $main_arr['info']['description']='Saving User Locations';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        if($lang=='en')
        {
            $main_arr['info']['language']='English';
        }
        if($lang=='zu')
        {
            $main_arr['info']['language']='Zulu';
        }
        if($lang=='st')
        {
            $main_arr['info']['language']='Sesotho';
        }
        $main_arr['paths']['api/v1/general/admindetails']['POST']['summary']='Admin content of the app';
        $main_arr['paths']['api/v1/general/admindetails']['POST']['description']='This API will return all the admin contents required for Admin Page of the APP';
        $main_arr['paths']['api/v1/general/admindetails']['POST']['parameters']='lang';
        
        $val = array("user_lat" => $u_lat, "user_long" => $u_long);
        $this->db->where('id', $uid);
        $this->db->update('snr_users', $val);
        
        $main_arr['info']['response']['status'] = '1';
        $main_arr['info']['response']['data'] = "User Location updated";

        $log_array = array(
            "api_name" => "Save User Location",
            "api_method" => "POST",
            "api_data" => json_encode($_POST),
            "api_lang" => $lang,
            "api_status" => 1,
            "ip_addr" => $_SERVER['REMOTE_ADDR']
        );
        $this->db->insert('snr_api_call_log', $log_array);
        
        $this->response($main_arr, REST_Controller::HTTP_OK);
	}
}
