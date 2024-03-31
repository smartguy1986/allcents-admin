<?php
header('Access-Control-Allow-Origin: *');

require APPPATH . 'libraries/REST_Controller.php';

class Centres extends REST_Controller  {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

	public function index_post()
	{
        $uid = $this->input->post('user_id');
        $lang = $this->input->post('lang');
        $pagecnt = $this->input->post('page_count');
        $limit_end = 10;
        $limit_start = (($pagecnt-1)*$limit_end);

        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
               
        // $this->db->select("*");
        // $this->db->order_by("id", "desc");
        // $this->db->limit($limit_start,3);
        // $this->db->where("status", "1");
        // $centres = $this->db->get("snr_centres")->result();

        // $centres = $this->db->query("SELECT * FROM `snr_centres` WHERE `status` = '1' ORDER BY `id` DESC LIMIT ".$limit_start.", ".$limit_end."")->result();
        $centres = $this->db->query("SELECT * FROM `snr_centres` WHERE `status` = '1' ORDER BY `id` DESC LIMIT ".$limit_start.",".$limit_end."")->result();

        $main_arr['info']['description']='All Centres List';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/centres/']['POST']['summary']='Get list of all the centres';
        $main_arr['paths']['api/v1/centres/']['POST']['description']='All the active centres list';
        $main_arr['paths']['api/v1/centres/']['POST']['parameters']='';
        if(!empty($centres))
        {   
            $data = array();
            foreach($centres as $cnt)
            {
                if($cnt->centre_banner)
                {
                    $bannerimage = base_url().'uploads/centre/banner/'.$cnt->centre_banner;
                }
                else
                {
                    $bannerimage = base_url()."uploads/defaults/default_banner.jpg";
                }
                if($cnt->centre_logo)
                {
                    $logoimage = base_url().'uploads/centre/logo/'.$cnt->centre_logo;
                }
                else
                {
                    $logoimage = base_url().'uploads/defaults/default_logo.jpg';
                }

                $cityname = city_name($cnt->centre_city)->RegionName;
                
                $ratings = getcentrerating($cnt->id);
                $star_rating = 0;
                $totr = 0;
                $x = 0;
                if(!empty($ratings))
                {
                    foreach($ratings as $rat)
                    {
                        $totr=$totr+$rat->centre_rating;
                        $x++;
                    }
                    $star_rating = ($totr/$x);
                }

                $time_slots = array();
                for($i=0;$i<15;$i++)
                {
                    $date = date("Y-m-d", strtotime("+".$i." day"));
                    $abcd = array();
                    $abcd = array(
                        "id"=>1,
                        "date"=>$date,
                        "date_name"=>date('D', strtotime($date)),
                        "time"=>"9am - 6pm",
                        "location"=>$cnt->centre_city,
                        "location_name"=>$cityname,
                        "contact_no"=>'');
                    array_push($time_slots, $abcd);
                }

                $review_lists = $this->db->query("SELECT snr_reviews.*, snr_users.userfname FROM `snr_reviews` JOIN snr_users ON snr_reviews.user_id=snr_users.id WHERE snr_reviews.centre_id='".$cnt->id."' AND snr_reviews.status='1' ORDER BY snr_reviews.added_on DESC")->result();
                
                $reviews = array();
                foreach($review_lists as $rev)
                {
                    $rv = array("user_name"=>$rev->userfname, "review"=>$rev->review_text);
                    array_push($reviews, $rv);
                }

                $data[] = array(
                    'id'                => $cnt->id,
                    'centre_name'       => $cnt->centre_name,
                    'centre_bio'        => $cnt->centre_bio,
                    'centre_address'    => $cnt->centre_address,
                    'centre_province'   => $cnt->centre_province,
                    'centre_city'       => $cnt->centre_city,
                    'centre_email'      => $cnt->centre_email,
                    'centre_phone'      => $cnt->centre_phone,
                    'centre_fax'        => $cnt->centre_fax,
                    'centre_timing'     => $cnt->centre_timing,
                    'centre_banner'     => $bannerimage,
                    'centre_logo'       => $logoimage,
                    'centre_contact'    => $cnt->centre_contact,
                    'centre_lat'        => $cnt->centre_lat,
                    'centre_long'       => $cnt->centre_long,
                    "center_sub_heading"=> $cityname,
                    "time_slots"        => $time_slots,
                    "reviews"           => $reviews,
                    'added_on'          => $cnt->added_on,
                    'updated_on'        => $cnt->updated_on,
                    'status'            => $cnt->status,
                    "star_rating"       => round($star_rating),
                );
            }
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $data;

            $log_array = array(
                "api_name" => "Centre List",
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
                $main_arr['info']['response']['data']='No centre Found.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data']='Asikho isikhungo esitholakele.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data']='Ha ho setsi se fumanoeng.';
            }
            //$main_arr['info']['response']['data'] = 'No centre Found';
            
            $log_array = array(
                "api_name" => "Centre List",
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

    public function centretest_post()
	{
        //{"lang":"en","city_id":"159","page_count":"5","latitude":"22.625339","longitude":"88.3837511","userId":"101"}

        $lang = $this->input->post('lang');
        $cid = $this->input->post('city_id');
        $uid = $this->input->post('user_id');
        
        // if($uid)
        // {
        //     $ucd = getuser_cordinates($uid);
        //     //print_r($ucd);
        // }
        $user_lat = $this->input->post('latitude');
        $user_long = $this->input->post('longitude');

        if($uid)
        {
            $curr_city = getuser_last_city($uid);
            //print_r($curr_city);
            $geocode_stats = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=AIzaSyBIaplg6psX4h-cbLHmmXV1M-bnUsxHYtw&address=".$curr_city->current_city."&sensor=false");
            $output_deals = json_decode($geocode_stats);
            $latLng = $output_deals->results[0]->geometry->location;
            if($latLng->lat<0) { $user_lat = -1 * abs($user_lat); }
            if($latLng->lng<0) { $user_long = -1 * abs($user_long); }
        }        

        $pagecnt = $this->input->post('page_count');
        $limit_end = 10;
        $limit_start = (($pagecnt-1)*$limit_end);   

        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
               
        $centres = $this->db->query("SELECT *, (  
            3959 * acos (
              cos ( radians(".$user_lat.") )
              * cos( radians( centre_lat ) )
              * cos( radians( centre_long ) - radians(".$user_long.") )
              + sin ( radians(".$user_lat.") )
              * sin( radians( centre_lat ) )
            )
          ) AS distance
        FROM snr_centres
        HAVING distance < 50
        ORDER BY distance;")->result();

        $main_arr['info']['description']='Centres by City';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/centres/bycity']['POST']['summary']='Get centres of a particular city';
        $main_arr['paths']['api/v1/centres/bycity']['POST']['description']='All the details of a particular centres by City';
        $main_arr['paths']['api/v1/centres/bycity']['POST']['parameters']='city_id';
        if(!empty($centres))
        {   
            $data = array();
            foreach($centres as $cnt)
            {
                if($cnt->centre_banner)
                {
                    $bannerimage = base_url().'uploads/centre/banner/'.$cnt->centre_banner;
                }
                else
                {
                    $bannerimage = base_url()."uploads/defaults/default_banner.jpg";
                }
                if($cnt->centre_logo)
                {
                    $logoimage = base_url().'uploads/centre/logo/'.$cnt->centre_logo;
                }
                else
                {
                    $logoimage = base_url().'uploads/defaults/default_logo.jpg';
                }
                
                $cityname = city_name($cnt->centre_city)->RegionName;

                $ratings = getcentrerating($cnt->id);
                $star_rating = 0;
                $totr = 0;
                $x = 0;
                if(!empty($ratings))
                {
                    foreach($ratings as $rat)
                    {
                        $totr=$totr+$rat->centre_rating;
                        $x++;
                    }
                    $star_rating = ($totr/$x);
                }

                $time_slots = array();
                for($i=0;$i<15;$i++)
                {
                    $date = date("Y-m-d", strtotime("+".$i." day"));
                    $abcd = array();
                    $abcd = array(
                        "id"=>1,
                        "date"=>$date,
                        "date_name"=>date('D', strtotime($date)),
                        "time"=>"9am - 6pm",
                        "location"=>$cnt->centre_city,
                        "location_name"=>$cityname,
                        "contact_no"=>'');
                    array_push($time_slots, $abcd);
                }

                $review_lists = $this->db->query("SELECT snr_reviews.*, snr_users.userfname FROM `snr_reviews` JOIN snr_users ON snr_reviews.user_id=snr_users.id WHERE snr_reviews.centre_id='".$cnt->id."' AND snr_reviews.status='1' ORDER BY snr_reviews.added_on DESC")->result();
                
                $reviews = array();
                foreach($review_lists as $rev)
                {
                    $rv = array("user_name"=>$rev->userfname, "review"=>$rev->review_text);
                    array_push($reviews, $rv);
                }

                $data[] = array(
                    'id'                => $cnt->id,
                    'centre_name'       => $cnt->centre_name,
                    'centre_bio'        => $cnt->centre_bio,
                    'centre_address'    => $cnt->centre_address,
                    'centre_province'   => $cnt->centre_province,
                    'centre_city'       => $cnt->centre_city,
                    'centre_email'      => $cnt->centre_email,
                    'centre_phone'      => $cnt->centre_phone,
                    'centre_fax'        => $cnt->centre_fax,
                    'centre_timing'     => $cnt->centre_timing,
                    'centre_banner'     => $bannerimage,
                    'centre_logo'       => $logoimage,
                    'centre_contact'    => $cnt->centre_contact,
                    'centre_lat'        => $cnt->centre_lat,
                    'centre_long'       => $cnt->centre_long,
                    "center_sub_heading"=> $cityname,
                    "time_slots"        => $time_slots,
                    "reviews"           => $reviews,
                    'added_on'          => $cnt->added_on,
                    'updated_on'        => $cnt->updated_on,
                    'status'            => $cnt->status,
                    'star_rating'       => round($star_rating),
                );
            }
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $data;

            $log_array = array(
                "api_name" => "Centre List by City",
                "api_method" => "POST",
                "api_data" => json_encode($_POST),
                "api_lang" => $lang,
                "api_status" => 0,
                "ip_addr" => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('snr_api_call_log', $log_array);
        }
        else{
            $main_arr['info']['response']['status'] = '0';
            if($lang=='en')
            {
                $main_arr['info']['response']['data']='No centre Found.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data']='Asikho isikhungo esitholakele.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data']='Ha ho setsi se fumanoeng.';
            }
            //$main_arr['info']['response']['data'] = 'No centre Found';

            $log_array = array(
                "api_name" => "Centre List by City",
                "api_method" => "POST",
                "api_data" => json_encode($_POST),
                "api_lang" => $lang,
                "api_status" => 0,
                "ip_addr" => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('snr_api_call_log', $log_array);
        }

        /* =================================== */
        // $yr = date("Y");
        // $mn = date("m");
        // $this->db->select('*');
        // $this->db->where(array("province_id"=> $cnt->centre_province, "city_id"=> $cnt->centre_city, "year"=>$yr, "month"=>$mn));
        // $ctr = $this->db->get('snr_location_tracker')->result();
        // if(count($ctr)>0)
        // {
        //     $this->db->where(array('province_id'=>$cnt->centre_province, "city_id"=> $cnt->centre_city, "year"=>$yr, "month"=>$mn));
        //     $this->db->set('views', 'views+1', FALSE);
        //     $this->db->update('snr_location_tracker');
        // }
        // else
        // {
        //     $val = array("province_id"=>$cnt->centre_province, "city_id"=> $cnt->centre_city, "year"=>$yr, "month"=>$mn,"views"=>1);
        //     $this->db->insert('snr_location_tracker',$val);
        // }        
        /* =================================== */
        
        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function byid_post()
	{
        $cid = $this->input->post('cid');
        $lang = $this->input->post('lang');
        
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
               
        $this->db->select("*");
        $this->db->where('id', $cid);
        $centres = $this->db->get_where("snr_centres", ['status' => '1'])->result();

        $main_arr['info']['description']='Centres by ID';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/centres/byid/(:num)']['POST']['summary']='Get centre of a particular id';
        $main_arr['paths']['api/v1/centres/byid/(:num)']['POST']['description']='All the details of a particular centres';
        $main_arr['paths']['api/v1/centres/byid/(:num)']['POST']['parameters']='cid';
        if(!empty($centres))
        {   
            $data = array();
            foreach($centres as $cnt)
            {
                if($cnt->centre_banner)
                {
                    $bannerimage = base_url().'uploads/centre/banner/'.$cnt->centre_banner;
                }
                else
                {
                    $bannerimage = base_url()."uploads/defaults/default_banner.jpg";
                }
                if($cnt->centre_logo)
                {
                    $logoimage = base_url().'uploads/centre/logo/'.$cnt->centre_logo;
                }
                else
                {
                    $logoimage = base_url().'uploads/defaults/default_logo.jpg';
                }

                $cityname = city_name($cnt->centre_city)->RegionName;

                $ratings = getcentrerating($cnt->id);
                $star_rating = 0;
                $totr = 0;
                $x = 0;
                if(!empty($ratings))
                {
                    foreach($ratings as $rat)
                    {
                        $totr=$totr+$rat->centre_rating;
                        $x++;
                    }
                    $star_rating = ($totr/$x);
                }

                $time_slots = array();
                for($i=0;$i<15;$i++)
                {
                    $date = date("Y-m-d", strtotime("+".$i." day"));
                    $weekday = date('D', strtotime($date));
                    
                    $abcd = array();
                    $abcd = array(
                        "id"=>1,
                        "date"=>$date,
                        "date_name"=>$weekday,
                        // "time"=>"9am - 6pm",
                        "location"=>$cnt->centre_city,
                        "location_name"=>$cityname,
                        "contact_no"=>'');
                    array_push($time_slots, $abcd);
                }

                $review_lists = $this->db->query("SELECT snr_reviews.*, snr_users.userfname FROM `snr_reviews` JOIN snr_users ON snr_reviews.user_id=snr_users.id WHERE snr_reviews.centre_id='".$cid."' AND snr_reviews.status='1' ORDER BY snr_reviews.added_on DESC")->result();
                
                $reviews = array();
                foreach($review_lists as $rev)
                {
                    $rv = array("user_name"=>$rev->userfname, "review"=>$rev->review_text);
                    array_push($reviews, $rv);
                }

                $georestrict = getgeorestrict($cnt->centre_province)->geo_restriction;

                if($georestrict==0)
                {
                    if($cnt->column_a==0)
                    {
                        if($cnt->column_b=0)
                        {
                            if($lang=='en')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Make Enquiry",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Book Tele Consult",
                                    ),
                                );
                            }
                            if($lang=='zu')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Yenza Uphenyo",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Incwadi Tele Consult",
                                    ),
                                );
                            }
                            if($lang=='st')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Etsa Patlisiso",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Buka ea Tele Consult",
                                    ),
                                );
                            }                            
                        }
                        else
                        {
                            if($lang=='en')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Make Enquiry",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Book Tele Consult with Sentebale Advisor",
                                    ),
                                );
                            }
                            if($lang=='zu')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Yenza Uphenyo",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Incwadi Tele Xhumana noMeluleki weSentebale",
                                    ),
                                );
                            }
                            if($lang=='st')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Etsa Patlisiso",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Book Tele Consult le Sentebale Advisor",
                                    ),
                                );
                            }
                        }
                    }
                    else
                    {
                        if($cnt->column_b=0)
                        {
                            if($lang=='en')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Book Appointment",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Make Enquiry",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Book Tele Consult",
                                    ),
                                );
                            }
                            if($lang=='zu')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Ukuqokwa Kwencwadi",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Yenza Uphenyo",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Book Tele Consult",
                                    ),
                                );
                            }
                            if($lang=='st')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Ho khethoa ha buka",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Incwadi Tele Consult",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Buka ea Tele Consult",
                                    ),
                                );
                            }                            
                        }
                        else
                        {
                            if($lang=='en')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Book Sentebale Advisor Appointment",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Make Enquiry",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Book Tele Consult with Sentebale Advisor",
                                    ),
                                );
                            }
                            if($lang=='zu')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Ukuqokwa Kwabeluleki Bencwadi Sentebale",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Yenza Uphenyo",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Incwadi Tele Xhumana noMeluleki weSentebale",
                                    ),
                                );
                            }
                            if($lang=='st')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Khetho ea Buka ea Sentebale",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Etsa Patlisiso",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Book Tele Consult le Sentebale Advisor",
                                    ),
                                );
                            }                           
                        }
                    }
                }
                else
                {
                    if($cnt->column_a==0)
                    {
                        if($cnt->column_b=0)
                        {
                            if($lang=='en')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Book Appointment",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Make Enquiry",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Book Tele Consult",
                                    ),
                                );
                            }
                            if($lang=='zu')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Ukuqokwa Kwencwadi",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Yenza Uphenyo",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Incwadi Tele Consult",
                                    ),
                                );
                            }
                            if($lang=='st')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Ho khethoa ha buka",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Etsa Patlisiso",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Buka ea Tele Consult",
                                    ),
                                );
                            }
                        }
                        else
                        {
                            if($lang=='en')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Book Sentebale Advisor Appointment",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Make Enquiry",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Book Tele Consult with Sentebale Advisor",
                                    ),
                                );
                            }
                            if($lang=='zu')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Ukuqokwa Kwabeluleki Bencwadi Sentebale",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Yenza Uphenyo",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Incwadi Tele Xhumana noMeluleki weSentebale",
                                    ),
                                );
                            }
                            if($lang=='st')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Khetho ea Buka ea Sentebale",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Etsa Patlisiso",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Book Tele Consult le Sentebale Advisor",
                                    ),
                                );
                            }  
                        }
                    }
                    else
                    {
                        if($cnt->column_b=0)
                        {
                            if($lang=='en')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Book Appointment",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Make Enquiry",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Book Tele Consult",
                                    ),
                                );
                            }
                            if($lang=='zu')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Ukuqokwa Kwencwadi",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Yenza Uphenyo",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Incwadi Tele Consult",
                                    ),
                                );
                            }
                            if($lang=='st')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Ho khethoa ha buka",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Etsa Patlisiso",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Buka ea Tele Consult",
                                    ),
                                );
                            } 
                        }
                        else
                        {
                            if($lang=='en')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Book Appointment",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Make Enquiry",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Book Tele Consult",
                                    ),
                                );
                            }
                            if($lang=='zu')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Ukuqokwa Kwencwadi",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Yenza Uphenyo",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Incwadi Tele Consult",
                                    ),
                                );
                            }
                            if($lang=='st')
                            {
                                $buttons = array(
                                    array(
                                        "id"    => '1',
                                        "button_name"   => "Ho khethoa ha buka",
                                    ),
                                    array(
                                        "id"    => '3',
                                        "button_name"   => "Etsa Patlisiso",
                                    ),
                                    array(
                                        "id"    => '2',
                                        "button_name"   => "Buka ea Tele Consult",
                                    ),
                                );
                            }  
                        }
                    }
                }

                if($lang=='en')
                {
                    $disclimer = "<strong>Disclaimer : We are growing the providers on the database. You may need to call or email your preferred provider for an appointment.</strong>";
                }
                if($lang=='zu')
                {
                    $disclimer = "<strong>Umusho wokuzihlangula : Sikhulisa abahlinzeki kusizindalwazi. Kungase kudingeke ukuthi ushayele noma u-imeyili umhlinzeki wakho omthandayo ukuze uthole isikhathi.</strong>";
                }
                if($lang=='st')
                {
                    $disclimer = "<strong>Boitlhotlhollo : Re ntse re holisa bafani ba lits'ebeletso ho database. U kanna ua hloka ho letsetsa kapa ho romella lengolo-tsoibila ho mofani oa hau eo u mo ratang bakeng sa kopano.</strong>";
                }

                $data[] = array(
                    'id'                => $cnt->id,
                    'disclimer'        => $disclimer,
                    'centre_name'       => $cnt->centre_name,
                    'centre_bio'        => $cnt->centre_bio,
                    'centre_address'    => $cnt->centre_address,
                    'centre_province'   => $cnt->centre_province,
                    'centre_city'       => $cnt->centre_city,
                    'centre_email'      => $cnt->centre_email,
                    'centre_phone'      => $cnt->centre_phone,
                    'centre_fax'        => $cnt->centre_fax,
                    'centre_timing'     => $cnt->centre_timing,
                    'centre_banner'     => $bannerimage,
                    'centre_logo'       => $logoimage,
                    'centre_contact'    => $cnt->centre_contact,
                    'centre_lat'        => $cnt->centre_lat,
                    'centre_long'       => $cnt->centre_long,
                    "center_sub_heading"=> $cityname,
                    "time_slots"        => $time_slots,
                    "reviews"           => $reviews,
                    "booking"           => $buttons,
                    'added_on'          => $cnt->added_on,
                    'updated_on'        => $cnt->updated_on,
                    'status'            => $cnt->status,
                    'star_rating'       => round($star_rating)
                );

            }

            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $data;
            
            $log_array = array(
                "api_name" => "Centre Details by ID",
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
                $main_arr['info']['response']['data']='No centre Found.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data']='Asikho isikhungo esitholakele.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data']='Ha ho setsi se fumanoeng.';
            }
            //$main_arr['info']['response']['data'] = 'No centre Found';
            $log_array = array(
                "api_name" => "Centre Details by ID",
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

    public function bycity_post()
	{
        $lang = $this->input->post('lang');
        //$cid = $this->input->post('city_id');
        $uid = $this->input->post('userId');

        //$province_id = get_province_id($cid)->ProvinceID;
        
        $user_lat = $this->input->post('latitude');
        $user_long = $this->input->post('longitude');

        if($uid)
        {
            // $curr_city = getuser_last_city($uid);
            // //print_r($curr_city);
            // if($curr_city->current_city)
            // {
            //     $geocode_stats = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=AIzaSyBIaplg6psX4h-cbLHmmXV1M-bnUsxHYtw&address=".urlencode($curr_city->current_city)."&sensor=false");
            //     $output_deals = json_decode($geocode_stats);
            //     $latLng = $output_deals->results[0]->geometry->location;
            //     if($latLng->lat<0) { $user_lat = -1 * abs($user_lat); }
            //     if($latLng->lng<0) { $user_long = -1 * abs($user_long); }

            //     $city_array = array('user_lat' => $user_lat, 'user_long' => $user_long);
            //     $this->db->where('id', $uid);
            //     $this->db->update('snr_users', $city_array);
            // }

            $city_array = array('user_lat' => $this->input->post('latitude'), 'user_long' => $this->input->post('longitude'));
            $this->db->where('id', $uid);
            $this->db->update('snr_users', $city_array);
        }        

        $pagecnt = $this->input->post('page_count');
        $limit_end = 10;
        $limit_start = (($pagecnt-1)*$limit_end);   

        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';

        if(empty($user_lat) || empty($user_long))
        {
            $province_id = 3;
            $centres = $this->db->query("SELECT id, centre_name, centre_address, centre_province, centre_city, centre_logo, centre_lat, centre_long
            FROM snr_centres
            WHERE centre_province='$province_id'
            ORDER BY centre_name ASC
            LIMIT $limit_start,$limit_end")->result();
        } 
        else
        {
            $centres = $this->db->query("SELECT id, centre_name, centre_address, centre_province, centre_city, centre_logo, centre_lat, centre_long, (  
                3959 * acos (
                  cos ( radians( $user_lat ) )
                  * cos( radians( centre_lat ) )
                  * cos( radians( centre_long ) - radians( $user_long ) )
                  + sin ( radians( $user_lat ) )
                  * sin( radians( centre_lat ) )
                )
              ) AS distance
            FROM snr_centres
            ORDER BY distance 
            LIMIT $limit_start,$limit_end")->result();
        }
        
        // $centres = $this->db->query("SELECT *, (((acos(sin((22.6253574*pi()/180)) * sin((`centre_lat`*pi()/180)) + cos((22.6253574*pi()/180)) * cos((`centre_lat`*pi()/180)) * cos(((88.3837537- `centre_long`) * pi()/180)))) * 180/pi()) * 60 * 1.1515 * 1.609344) as distance FROM snr_centres ORDER BY distance LIMIT $limit_start,$limit_end;")->result();

        //HAVING distance < 50

        $main_arr['info']['description']='Centres by City';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/centres/bycity']['POST']['summary']='Get centres of a particular city';
        $main_arr['paths']['api/v1/centres/bycity']['POST']['description']='All the details of a particular centres by City';
        $main_arr['paths']['api/v1/centres/bycity']['POST']['parameters']='city_id';
        if(!empty($centres))
        {   
            $data = array();
            foreach($centres as $cnt)
            {
                if($cnt->centre_logo)
                {
                    $logoimage = base_url().'uploads/centre/logo/'.$cnt->centre_logo;
                }
                else
                {
                    $logoimage = base_url().'uploads/defaults/default_logo.jpg';
                }
                
                $cityname = city_name($cnt->centre_city)->RegionName;
                $ratings = getcentrerating($cnt->id);
                
                $star_rating = 0;
                $totr = 0;
                $x = 0;
                if(!empty($ratings))
                {
                    foreach($ratings as $rat)
                    {
                        $totr=$totr+$rat->centre_rating;
                        $x++;
                    }
                    $star_rating = ($totr/$x);
                }

                // if($lang=='en')
                // {
                //     $disclimer = "Disclaimer : We are growing the providers on the database. You may need to call or email your preferred provider for an appointment.";
                // }
                // if($lang=='zu')
                // {
                //     $disclimer = "Umusho wokuzihlangula : Sikhulisa abahlinzeki kusizindalwazi. Kungase kudingeke ukuthi ushayele noma u-imeyili umhlinzeki wakho omthandayo ukuze uthole isikhathi.";
                // }
                // if($lang=='st')
                // {
                //     $disclimer = "Boitlhotlhollo : Re ntse re holisa bafani ba lits'ebeletso ho database. U kanna ua hloka ho letsetsa kapa ho romella lengolo-tsoibila ho mofani oa hau eo u mo ratang bakeng sa kopano.";
                // }
                if($lang=='en')
                {
                    $disclimer = "<strong>Disclaimer : We are growing the providers on the database. You may need to call or email your preferred provider for an appointment.</strong>";
                }
                if($lang=='zu')
                {
                    $disclimer = "<strong>Umusho wokuzihlangula : Sikhulisa abahlinzeki kusizindalwazi. Kungase kudingeke ukuthi ushayele noma u-imeyili umhlinzeki wakho omthandayo ukuze uthole isikhathi.</strong>";
                }
                if($lang=='st')
                {
                    $disclimer = "<strong>Boitlhotlhollo : Re ntse re holisa bafani ba lits'ebeletso ho database. U kanna ua hloka ho letsetsa kapa ho romella lengolo-tsoibila ho mofani oa hau eo u mo ratang bakeng sa kopano.</strong>";
                }

                $data[] = array(
                    'id'                => $cnt->id,
                    'disclimer'         => $disclimer,
                    'centre_name'       => $cnt->centre_name,
                    'centre_address'    => $cnt->centre_address,
                    'centre_province'   => $cnt->centre_province,
                    'centre_city'       => $cnt->centre_city,
                    'centre_logo'       => $logoimage,
                    'centre_lat'        => $cnt->centre_lat,
                    'centre_long'       => $cnt->centre_long,
                    "center_sub_heading"=> $cityname,
                    'star_rating'       => round($star_rating),
                    'centerDistance'    => number_format((float)($cnt->distance*1.609), 2, '.', '')." Km(s)",
                );
            }
            
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $data;

            $log_array = array(
                "api_name" => "Centre List by City",
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
                $main_arr['info']['response']['data']='No centre Found.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data']='Asikho isikhungo esitholakele.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data']='Ha ho setsi se fumanoeng.';
            }
            //$main_arr['info']['response']['data'] = 'No centre Found';

            $log_array = array(
                "api_name" => "Centre List by City",
                "api_method" => "POST",
                "api_data" => json_encode($_POST),
                "api_lang" => $lang,
                "api_status" => 0,
                "ip_addr" => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('snr_api_call_log', $log_array);
        }

        /* =================================== */
        if(isset($cnt))
        {
            $yr = date("Y");
            $mn = date("m");
            $this->db->select('*');
            $this->db->where(array("province_id"=> $cnt->centre_province, "city_id"=> $cnt->centre_city, "year"=>$yr, "month"=>$mn));
            $ctr = $this->db->get('snr_location_tracker')->result();
            if(count($ctr)>0)
            {
                $this->db->where(array('province_id'=>$cnt->centre_province, "city_id"=> $cnt->centre_city, "year"=>$yr, "month"=>$mn));
                $this->db->set('views', 'views+1', FALSE);
                $this->db->update('snr_location_tracker');
            }
            else
            {
                $val = array("province_id"=>$cnt->centre_province, "city_id"=> $cnt->centre_city, "year"=>$yr, "month"=>$mn,"views"=>1);
                $this->db->insert('snr_location_tracker',$val);
            }
        }
        /* =================================== */
        
        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function sentebale_post()
	{        
        $lang = $this->input->post('lang');

        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
               
        $this->db->select("*");
        $centres = $this->db->get_where("snr_admin")->result();
        $this->db->select("*");
        $centres2 = $this->db->get_where("snr_company_info")->result();

        $main_arr['info']['description']='Sentebale Details';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/centres/sentebale']['POST']['summary']='Book direct via Sentebale';
        $main_arr['paths']['api/v1/centres/sentebale']['POST']['description']='Book direct via Sentebale';
        $main_arr['paths']['api/v1/centres/sentebale']['POST']['parameters']='';
  
        // echo "<pre>";
        // //print_r($centres);
        // print_r($centres2);
        // echo "</pre>";
        if($lang=='en')
        {
            $bio_param = "Dr. Tlaleng Mofokeng (MBChB, UKZN), the United Nations Special Rapporteur on the right to health. In consulting rooms, I'm more affectionately referred to as \"Dr. T\" by some of my patients and I have forged strong doctor-patient relationships built on humanity, trust, compassion and mutual respect. More than a medical practitioner, my practice is an extension of my advocacy and activism for sexual and reproductive health rights. I believe people should have dignified and quality care to protect their dignity and bodily intergrity.";
        }
        if($lang=='zu')
        {
            //$bio_param = strip_tags($centres[0]->admin_bio_zu);
            $bio_param = "UDkt Tlaleng Mofokeng (MBChB, UKZN), uMphenyi Oyisipesheli we-UN wamalungelo ezempilo. Emagunjini okubonana neziguli, ngibizwa ngo \"Dr T\" ngezinye zeziguli zami ngenxa yokwakha ubudlelwane obuqinile phakathi kwami neziguli, obunobuntu,ukwethembana,uzwelo kanye nenhlonipho nhlangothi zombili. Ngaphezu kokuba udokoktela, umsebenzi wami ungukwelula isandla semsebenzini yami yobushoshovu namalungelo ezempilo zocansi nokuzala. Nginenkolelo ukuthi abantu kufanele babe nokunakekelwa okuhloniphekile nokunekhwalithi ukuvikela isithunzi nobuqotho bomzimba.";
        }
        if($lang=='st')
        {
            $bio_param = "Dr Tlaleng Mofokeng (MBChB, UKZN), Moqolotsi ya Kgethehileng wa Matjhaba a Kopaneng ho tsa tokelo ya bophelo. Diphaphusing tsa kokelo, ba bang ba bakudi ba ka ba nreneketsa ka \"Dr T\" mme ke thile dikamano tse matla tsa ngaka le mokudi, tse thehilweng ka botho, tshepo, kutlwelobohloko, le ho hlomphana. Ho feta ho ba ngaka e sebetsang ka tsa bongaka, ke boela ke le ngaka eo tshebetso ya yona e leng katoloso ya bobuelli le boitseki ba boemo ba bophelo le ditokelo tsa bong le boikatiso. Ke dumela hore batho ba tlameha ho fumantswa tlhokomelo e nang le seriti le boleng ho tshireletsa seriti sa bona le boitshepo ba mmele ya bona.";
        }
        

        $time_slots = array();
        for($i=0;$i<15;$i++)
        {
            $date = date("Y-m-d", strtotime("+".$i." day"));
            $weekday = date('D', strtotime($date));
            
            $abcd = array();
            $abcd = array(
                "id"=>1,
                "date"=>$date,
                "date_name"=>$weekday,
                "time"=>"",
                "location"=>22,
                "contact_no"=>"info@disaclinic.co.za");
            array_push($time_slots, $abcd);
        }

        $review_lists = $this->db->query("SELECT snr_reviews.*, snr_users.userfname FROM `snr_reviews` JOIN snr_users ON snr_reviews.user_id=snr_users.id WHERE snr_reviews.centre_id='".$centres[0]->id."' AND snr_reviews.status='1' ORDER BY snr_reviews.added_on DESC")->result();
                
        $reviews = array();
        foreach($review_lists as $rev)
        {
            $rv = array("user_name"=>$rev->userfname, "review"=>$rev->review_text);
            array_push($reviews, $rv);
        }

        if($lang=='en')
        {
            $buttons = array(
                array(
                    "id"    => '1',
                    "button_name"   => "Book Sentebale Advisor Appointment",
                ),
                array(
                    "id"    => '3',
                    "button_name"   => "Make Enquiry",
                ),
                array(
                    "id"    => '2',
                    "button_name"   => "Book Tele Consult with Sentebale Advisor",
                ),
            );      
        }
        if($lang=='zu')
        {
            $buttons = array(
                array(
                    "id"    => '1',
                    "button_name"   => "Ukuqokwa Kwabeluleki Bencwadi Sentebale",
                ),
                array(
                    "id"    => '3',
                    "button_name"   => "Yenza Uphenyo",
                ),
                array(
                    "id"    => '2',
                    "button_name"   => "Incwadi Tele Xhumana noMeluleki weSentebale",
                ),
            );      
        }
        if($lang=='st')
        {
            $buttons = array(
                array(
                    "id"    => '1',
                    "button_name"   => "Khetho ea Buka ea Sentebale",
                ),
                array(
                    "id"    => '3',
                    "button_name"   => "Etsa Patlisiso",
                ),
                array(
                    "id"    => '2',
                    "button_name"   => "Book Tele Consult le Sentebale Advisor",
                ),
            );      
        }   
        
        if($lang=='en')
        {
            $disclimer = "<strong>Disclaimer : We are growing the providers on the database. You may need to call or email your preferred provider for an appointment.</strong>";
        }
        if($lang=='zu')
        {
            $disclimer = "<strong>Umusho wokuzihlangula : Sikhulisa abahlinzeki kusizindalwazi. Kungase kudingeke ukuthi ushayele noma u-imeyili umhlinzeki wakho omthandayo ukuze uthole isikhathi.</strong>";
        }
        if($lang=='st')
        {
            $disclimer = "<strong>Boitlhotlhollo : Re ntse re holisa bafani ba lits'ebeletso ho database. U kanna ua hloka ho letsetsa kapa ho romella lengolo-tsoibila ho mofani oa hau eo u mo ratang bakeng sa kopano.</strong>";
        }

        $data = array(
            "id" => $centres[0]->id,
            "disclimer" => $disclimer,
            "centre_name" => $centres[0]->admin_name,
            "centre_bio" => $bio_param,
            "centre_address" => "15 Lebensraum Pl, Hurlingham Manor, Sandton, 2070, South Africa",
            "centre_province" => 3,
            "centre_city" => 22,
            "centre_email" => "info@disaclinic.co.za",
            "centre_phone" => $centres2[0]->company_phone,
            "centre_fax" => $centres2[0]->company_fax,
            "centre_timing" => '',
            "centre_banner" => base_url()."uploads/defaults/default_banner.jpg",
            "centre_logo" => base_url()."uploads/admin/".$centres[0]->admin_image,
            "centre_contact" => $centres[0]->id,
            "centre_lat" => "-26.0928011",
            "centre_long" => "28.0216301",
            "center_sub_heading"=> "Disa Health Care Clinic",
            "time_slots"        => $time_slots,
            "reviews"           => $reviews,
            "booking"           => $buttons,
            "added_on" => date("Y-m-d H:i:s"),
            "updated_on" => date("Y-m-d H:i:s"),
            "status" => "1"
        );

        $main_arr['info']['response']['status'] = '1';
        $main_arr['info']['response']['data'] = $data;
        
        $log_array = array(
            "api_name" => "Dr. T Page",
            "api_method" => "POST",
            "api_data" => json_encode($_POST),
            "api_lang" => $lang,
            "api_status" => 1,
            "ip_addr" => $_SERVER['REMOTE_ADDR']
        );
        $this->db->insert('snr_api_call_log', $log_array);
        
        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function bycity2_post()
	{
        $lang = $this->input->post('lang');
        //$cid = $this->input->post('city_id');
        $uid = $this->input->post('userId');

        //$province_id = get_province_id($cid)->ProvinceID;
        
        $user_lat = $this->input->post('latitude');
        $user_long = $this->input->post('longitude');

        $pagecnt = $this->input->post('page_count');
        $limit_end = 10;
        $limit_start = (($pagecnt-1)*$limit_end);   

        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';

        if(empty($user_lat) || empty($user_long))
        {
            $province_id = 3;
            $centres = $this->db->query("SELECT id, centre_name, centre_address, centre_province, centre_city, centre_logo, centre_lat, centre_long
            FROM snr_centres
            WHERE centre_province='$province_id'
            ORDER BY centre_name ASC
            LIMIT $limit_start,$limit_end")->result();
        } 
        else
        {
            $centres = $this->db->query("SELECT id, centre_name, centre_address, centre_province, centre_city, centre_logo, centre_lat, centre_long, (  
                3959 * acos (
                  cos ( radians( $user_lat ) )
                  * cos( radians( centre_lat ) )
                  * cos( radians( centre_long ) - radians( $user_long ) )
                  + sin ( radians( $user_lat ) )
                  * sin( radians( centre_lat ) )
                )
              ) AS distance
            FROM snr_centres
            ORDER BY distance 
            LIMIT $limit_start,$limit_end")->result();
        }
        
        // $centres = $this->db->query("SELECT *, (((acos(sin((22.6253574*pi()/180)) * sin((`centre_lat`*pi()/180)) + cos((22.6253574*pi()/180)) * cos((`centre_lat`*pi()/180)) * cos(((88.3837537- `centre_long`) * pi()/180)))) * 180/pi()) * 60 * 1.1515 * 1.609344) as distance FROM snr_centres ORDER BY distance LIMIT $limit_start,$limit_end;")->result();

        //HAVING distance < 50

        $main_arr['info']['description']='Centres by City';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/centres/bycity']['POST']['summary']='Get centres of a particular city';
        $main_arr['paths']['api/v1/centres/bycity']['POST']['description']='All the details of a particular centres by City';
        $main_arr['paths']['api/v1/centres/bycity']['POST']['parameters']='city_id';
        if(!empty($centres))
        {   
            $data = array();
            foreach($centres as $cnt)
            {
                if($cnt->centre_logo)
                {
                    $logoimage = base_url().'uploads/centre/logo/'.$cnt->centre_logo;
                }
                else
                {
                    $logoimage = base_url().'uploads/defaults/default_logo.jpg';
                }
                
                $cityname = city_name($cnt->centre_city)->RegionName;
                $ratings = getcentrerating($cnt->id);
                
                $star_rating = 0;
                $totr = 0;
                $x = 0;
                if(!empty($ratings))
                {
                    foreach($ratings as $rat)
                    {
                        $totr=$totr+$rat->centre_rating;
                        $x++;
                    }
                    $star_rating = ($totr/$x);
                }

                if($lang=='en')
                {
                    $disclimer = "<strong>Disclaimer : We are growing the providers on the database. You may need to call or email your preferred provider for an appointment.</strong>";
                }
                if($lang=='zu')
                {
                    $disclimer = "<strong>Umusho wokuzihlangula : Sikhulisa abahlinzeki kusizindalwazi. Kungase kudingeke ukuthi ushayele noma u-imeyili umhlinzeki wakho omthandayo ukuze uthole isikhathi.</strong>";
                }
                if($lang=='st')
                {
                    $disclimer = "<strong>Boitlhotlhollo : Re ntse re holisa bafani ba lits'ebeletso ho database. U kanna ua hloka ho letsetsa kapa ho romella lengolo-tsoibila ho mofani oa hau eo u mo ratang bakeng sa kopano.</strong>";
                }

                $data[] = array(
                    'id'                => $cnt->id,
                    'disclimer'         => $disclimer,
                    'centre_name'       => $cnt->centre_name,
                    'centre_address'    => $cnt->centre_address,
                    'centre_province'   => $cnt->centre_province,
                    'centre_city'       => $cnt->centre_city,
                    'centre_logo'       => $logoimage,
                    'centre_lat'        => $cnt->centre_lat,
                    'centre_long'       => $cnt->centre_long,
                    "center_sub_heading"=> $cityname,
                    'star_rating'       => round($star_rating),
                    'centerDistance'    => number_format((float)($cnt->distance*1.609), 2, '.', '')." Km(s)",
                );
            }
            
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $data;

            $log_array = array(
                "api_name" => "Centre List by City",
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
                $main_arr['info']['response']['data']='No centre Found.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data']='Asikho isikhungo esitholakele.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data']='Ha ho setsi se fumanoeng.';
            }
            //$main_arr['info']['response']['data'] = 'No centre Found';

            $log_array = array(
                "api_name" => "Centre List by City",
                "api_method" => "POST",
                "api_data" => json_encode($_POST),
                "api_lang" => $lang,
                "api_status" => 0,
                "ip_addr" => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('snr_api_call_log', $log_array);
        }

        /* =================================== */
        if(isset($cnt))
        {
            $yr = date("Y");
            $mn = date("m");
            $this->db->select('*');
            $this->db->where(array("province_id"=> $cnt->centre_province, "city_id"=> $cnt->centre_city, "year"=>$yr, "month"=>$mn));
            $ctr = $this->db->get('snr_location_tracker')->result();
            if(count($ctr)>0)
            {
                $this->db->where(array('province_id'=>$cnt->centre_province, "city_id"=> $cnt->centre_city, "year"=>$yr, "month"=>$mn));
                $this->db->set('views', 'views+1', FALSE);
                $this->db->update('snr_location_tracker');
            }
            else
            {
                $val = array("province_id"=>$cnt->centre_province, "city_id"=> $cnt->centre_city, "year"=>$yr, "month"=>$mn,"views"=>1);
                $this->db->insert('snr_location_tracker',$val);
            }
        }
        /* =================================== */
        
        $this->response($main_arr, REST_Controller::HTTP_OK);
	}
    
}
