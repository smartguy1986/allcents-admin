<?php
header('Access-Control-Allow-Origin: *');
require APPPATH . 'libraries/REST_Controller.php';
class Bookings extends REST_Controller  {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	public function index_get($lang = null)
	{
        
	}
    public function new_booking_post()
	{
        $lang = $this->input->post('lang');
        $insertId = '';
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
        
        $main_arr['info']['description']='New Booking from App';
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
        $main_arr['paths']['api/v1/bookings/new_booking']['POST']['summary']='Create a new Booking from the app';
        $main_arr['paths']['api/v1/bookings/new_booking']['POST']['description']='Creation of a booking request via app';
        $main_arr['paths']['api/v1/bookings/new_booking']['POST']['parameters']='user_id(:num), centre_id(:num), booking_type(:num), booking_date(Y-m-d), status(0)';
        

        // $cat_name = getcategoryinitials($this->input->post('category_id'))->cat_name_en;
        // $words = explode(" ", $cat_name);
        // $acronym = "";
        // foreach ($words as $w) {
        //   $acronym .= $w[0];
        // }
        // echo strtoupper($acronym);
        
        if($this->input->post('centre_id')==1)
        {
            $acronym2 = "SHA";
        }
        else
        {
            $centre_name = getcentreinitials($this->input->post('centre_id'))->centre_name;
            $words2 = explode(" ", $centre_name);
            $acronym2 = "";
            foreach ($words2 as $w2) {
                $acronym2 .= substr($w2,0,1);
            }
        }
        //echo strtoupper($acronym2);

        $uqid = strtoupper($acronym2.'-'.date('m-Y-').substr(sha1(time()),0,6));
        //die();

        if(!empty($this->input->post('user_id')))
        {
            
            $data = array(
                "unique_id" => $uqid,
                "user_id" => $this->input->post('user_id'),
                // "category_id" => $this->input->post('category_id'),
                // "subcat_id" => $this->input->post('subcat_id'),
                "centre_id" => $this->input->post('centre_id'),
                "booking_type" => $this->input->post('booking_type'),
                "booking_date" => $this->input->post('booking_date'),
                "schedule_date" => $this->input->post('booking_date'),
                "booking_lang" => $lang,
                "status" => '0'
            );
            
            $this->db->insert('snr_booking', $data);
            $insertId = $this->db->insert_id();
        }

        if(!empty($insertId))
        {
            $usermail = getusermail($this->input->post('user_id'))->usermail;
            $userphone = getuserphone($this->input->post('user_id'))->userphone;
            $cntname = centre_info('centre_name',$this->input->post('centre_id'));
            //echo $cntname->centre_name;
            $status = sendbookingacceptmail($usermail, $cntname->centre_name, $this->input->post('booking_date'), $lang);
            sendbookingtodrtmail($usermail, $userphone, $cntname->centre_name, $this->input->post('booking_date'), $uqid, $this->input->post('booking_type'));

            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['booking_id'] = $uqid;
            if($lang=='en')
            {
                $main_arr['info']['response']['data'] = 'Thank you for choosing Sentebale. Your request has been passed onto an Advisor. Please check your email (including junk) for further information.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'Siyabonga ngokukhetha iSentebale. Isicelo sakho sidluliselwe kumeluleki. Sicela uhlole i-imeyili yakho (kufaka phakathi okungenamsoco) ukuthola eminye imininingwane.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Kea le leboha ka ho khetha Sentebale. Kopo ea hau e fetiselitsoe ho Moeletsi. Ka kopo sheba lengolo-tsoibila la hau (ho kenyeletsoa le senang thuso) ho fumana lintlha tse ling.';
            }            

            $this->db->select('userfname,deviceid');
            $udata = $this->db->get_where("snr_users", ['usermail' => $usermail])->result();
            if($udata[0]->deviceid)
            {
                $dtype = get_device_type($udata[0]->deviceid);
                // $dtype->devicetype
                if($lang=='en')
                {
                    send_booking_push($udata[0]->deviceid, "Received booking for ".$cntname->centre_name." on ".$this->input->post('booking_date')."", "Please check your email (including junk) for further information.", "individual", 0, $dtype->devicetype);
                }
                if($lang=='zu')
                {
                    send_booking_push($udata[0]->deviceid, "Kutholwe ukubhukha kwe ".$cntname->centre_name." kuvuliwe ".$this->input->post('booking_date')."", "Sicela uhlole i-imeyili yakho (kuhlanganise nodoti) ukuze uthole ulwazi olwengeziwe.", "individual", 0,$dtype->devicetype);
                }
                if($lang=='st')
                {
                    send_booking_push($udata[0]->deviceid, "E amohetse peeletso bakeng sa ".$cntname->centre_name." ka ".$this->input->post('booking_date')."", "Ka kopo, sheba lengolo-tsoibila la hau (ho kenyeletsoa le litšila) bakeng sa lintlha tse ling.", "individual", 0, $dtype->devicetype);
                }
            }
            
            $log_array = array(
                "api_name" => "New Booking",
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
                $main_arr['info']['response']['data'] = 'There is an error. Please try again.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'Kukhona iphutha. Ngicela uzame futhi.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Ho na le phoso. Ka kopo leka hape.';
            }     
            // $main_arr['info']['response']['data'] = 'Booking no created';

            $log_array = array(
                "api_name" => "New Booking",
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

    public function bookinglist_post()
	{
        $lang = $this->input->post('lang');
        $uid = $this->input->post('uid');

        $insertId = '';
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
        
        $main_arr['info']['description']='Booking list of an User';
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
        $main_arr['paths']['api/v1/bookings/bookinglist']['POST']['summary']='Get all booking of a User';
        $main_arr['paths']['api/v1/bookings/bookinglist']['POST']['description']='Get Booking lists of a particular user';
        $main_arr['paths']['api/v1/bookings/bookinglist']['POST']['parameters']='uid(:num), lang';
        
        $this->db->select('*');
        $this->db->where('user_id', $uid);
        // $this->db->where('status<>', '0');
        $this->db->order_by('booking_date', 'DESC');
        $qry = $this->db->get('snr_booking');
        $bookinglists = $qry->result();

        // echo "<pre>";
        // print_r($bookinglists);
        // echo "</pre>";

        if($bookinglists)
        {
            $data = array();
            $i=0;
            foreach($bookinglists as $booking)
            {
                // $ratings = getcentrerating($booking->centre_id);
                $data[$i]['id']=$booking->id;
                $data[$i]['unique_id']=$booking->unique_id;
                $data[$i]['user_id']=$booking->user_id;
                if($booking->centre_id==1)
                {
                    $data[$i]['centre_name']="Sentebale Advisor";
                    $data[$i]['centre_address']="Sentebale Health App";
                }
                else
                {
                    $data[$i]['centre_name']=centre_info('centre_name', $booking->centre_id)->centre_name;
                    $data[$i]['centre_address']=centre_info('centre_address', $booking->centre_id)->centre_address;
                }                
                $data[$i]['centre_id']=$booking->centre_id;
                if($lang=='en')
                {
                    $bookrc = "Booking Received";
                    if($booking->booking_type==0)
                    {
                        $data[$i]['booking_type']="Not Assigned";
                    }
                    if($booking->booking_type==1)
                    {
                        $data[$i]['booking_type']="Center Appointment";
                    }
                    if($booking->booking_type==2)
                    {
                        $data[$i]['booking_type']="Enquiry";
                    }
                    if($booking->booking_type==3)
                    {
                        $data[$i]['booking_type']="Tele Consultation";
                    }
                }
                if($lang=='zu')
                {
                    $bookrc = "Ukubhukha Kutholiwe";
                    if($booking->booking_type==0)
                    {
                        $data[$i]['booking_type']="Akwabelwe";
                    }
                    if($booking->booking_type==1)
                    {
                        $data[$i]['booking_type']="Ukuqokwa Kwesikhungo";
                    }
                    if($booking->booking_type==2)
                    {
                        $data[$i]['booking_type']="Uphenyo";
                    }
                    if($booking->booking_type==3)
                    {
                        $data[$i]['booking_type']="Ukuxhumana ngocingo";
                    }
                }
                if($lang=='st')
                {
                    $bookrc = "Booking Re Amohetse";
                    if($booking->booking_type==0)
                    {
                        $data[$i]['booking_type']="Ha ea Abela";
                    }
                    if($booking->booking_type==1)
                    {
                        $data[$i]['booking_type']="Khetho ea Setsi";
                    }
                    if($booking->booking_type==2)
                    {
                        $data[$i]['booking_type']="Patlisiso";
                    }
                    if($booking->booking_type==3)
                    {
                        $data[$i]['booking_type']="Tele consultation";
                    }
                }

                if($booking->status==0)
                {
                    $data[$i]['booking_date']="<span style='font-size:18px; line-height 1.5em; padding:0px; margin:0px;'><strong>".date("d M Y", strtotime($booking->schedule_date))." - ".$data[$i]['booking_type']." (".$bookrc.")</strong></span>";
                    $data[$i]['can_cancel']=0;
                    $data[$i]['can_review']=0;
                }
                else
                {
                    //$data[$i]['booking_type']=$booking->booking_type;
                    if(isset($booking->schedule_date))
                    {
                        if($booking->booking_time)
                        {
                            $data[$i]['booking_date']="<span style='font-size:18px; line-height 1.5em; padding:0px; margin:0px;'><strong>".date("d M Y", strtotime($booking->schedule_date))." @ ".$booking->booking_time." - ".$data[$i]['booking_type']."</strong></span>";
                        }
                        else
                        {
                            $data[$i]['booking_date']="<span style='font-size:18px; line-height 1.5em; padding:0px; margin:0px;'><strong>".date("d M Y", strtotime($booking->schedule_date))." - ".$data[$i]['booking_type']."</strong></span>";
                        }
                        $date_now = strtotime('now');
                        $date_book = strtotime('-1 day', strtotime($booking->schedule_date));
                        if($date_book>$date_now)
                        {
                            $data[$i]['can_cancel']=1;
                            $data[$i]['can_review']=0;
                        }
                        else
                        {
                            $data[$i]['can_cancel']=0;
                            $chkrv = checkreview($booking->id, $uid);
                            if($chkrv>0)
                            {
                                $data[$i]['can_review']=0;
                            }
                            else
                            {
                                if($booking->status==4)
                                {
                                    $data[$i]['can_review']=0;
                                }
                                else
                                {
                                    $data[$i]['can_review']=1;
                                }
                            }
                            // $data[$i]['can_review']=1;
                        }
                    }
                    else
                    {
                        if($booking->booking_time)
                        {
                            $data[$i]['booking_date']="<span style='font-size:18px; line-height 1.5em; padding:0px; margin:0px;'><strong>".date("d M Y", strtotime($booking->booking_date))." @ ".$booking->booking_time." - ".$data[$i]['booking_type']."</strong></span>";
                        }
                        else
                        {
                            $data[$i]['booking_date']="<span style='font-size:18px; line-height 1.5em; padding:0px; margin:0px;'><strong>".date("d M Y", strtotime($booking->booking_date))." - ".$data[$i]['booking_type']."</strong></span>";
                        }
                        $date_now = strtotime('now');
                        $date_book = strtotime('-1 day', strtotime($booking->booking_date));
                        if($date_book>$date_now)
                        {
                            $data[$i]['can_cancel']=1;
                            $data[$i]['can_review']=0;
                        }
                        else
                        {
                            $chkrv = checkreview($booking->id, $uid);
                            if($chkrv>0)
                            {
                                $data[$i]['can_review']=0;
                            }
                            else
                            {
                                $data[$i]['can_review']=1;
                            }
                            $data[$i]['can_cancel']=0;                        
                        }
                    }
                    if($booking->status==4)
                    {
                        $data[$i]['is_cancel']=1;
                    }
                    else
                    {
                        $data[$i]['is_cancel']=0;
                    }

                    $this->db->select('*');
                    $this->db->where(array("user_id"=>$booking->user_id, "booking_id"=>$booking->id));
                    $aabb = $this->db->get('snr_reviews')->result();

                    // echo "<pre>";
                    // print_r($aabb);
                    // echo "</pre>";
                    if(count($aabb)>0)
                    {
                        $data[$i]['is_review']=1;
                    }
                    else
                    {
                        $data[$i]['is_review']=0;
                    }
                }
                $i++;
            }

            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $data;
            $main_arr['info']['response']['message'] = '';

            $log_array = array(
                "api_name" => "Booking List",
                "api_method" => "POST",
                "api_data" => json_encode($_POST),
                "api_lang" => $lang,
                "api_status" => 1,
                "ip_addr" => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('snr_api_call_log', $log_array);
        }
        else
        {
            $main_arr['info']['response']['status'] = '0';
            if($lang=='en')
            {
                $main_arr['info']['response']['data'] = 'No Booking found with this User.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'Akukho Ukubhuka okutholakele ngalo Msebenzisi.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Ha ho peheletso e fumanoeng le mosebelisi enoa.';
            }     
            // $main_arr['info']['response']['data'] = 'No Booking found by this User.';

            $log_array = array(
                "api_name" => "Booking List",
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

    public function cancel_post()
	{
        $lang = $this->input->post('lang');
        $uid = $this->input->post('uid');
        $bid = $this->input->post('booking_id');

        $insertId = '';
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
        
        $main_arr['info']['description']='Booking cancel by User';
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
        $main_arr['paths']['api/v1/bookings/bookinglist']['POST']['summary']='Cancellation of Booking by User';
        $main_arr['paths']['api/v1/bookings/bookinglist']['POST']['description']='Cancellation of Booking by User from APP';
        $main_arr['paths']['api/v1/bookings/bookinglist']['POST']['parameters']='uid(:num), lang, booking_id(:num)';
        
        $this->db->select('*');
        $this->db->where('user_id', $uid);
        $this->db->where('id', $bid);
        $qry = $this->db->get('snr_booking');
        $bookinglists = $qry->row();

        $cntname = centre_info('centre_name',$bookinglists->centre_id);
        // echo "<pre>";
        // print_r($bookinglists);
        // echo "</pre>";

        // die();

        if(!empty($bookinglists))
        {
            $this->db->where('id', $bid);
            $this->db->where('user_id', $uid);
            $this->db->update('snr_booking', array('status'=> '4'));

            $main_arr['info']['response']['status'] = '1';
            if($lang=='en')
            {
                $main_arr['info']['response']['data'] = 'Your Booking cancelled successfully.';
                $main_arr['info']['response']['message'] = 'Your Booking cancelled successfully.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'Ukubhuka kwakho kukhanselwe ngempumelelo.';
                $main_arr['info']['response']['message'] = 'Ukubhuka kwakho kukhanselwe ngempumelelo.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Peeletso ya hao e hlakotswe ka katleho.';
                $main_arr['info']['response']['message'] = 'Peeletso ya hao e hlakotswe ka katleho.';
            }     

            $this->db->select('userfname, deviceid');
            $this->db->where('id', $uid);
            $udt = $this->db->get('snr_users')->result();
            $udevc = $udt[0]->deviceid;

            if($udevc)
            {
                $dtype = get_device_type($udevc);
                // $dtype->devicetype
                if($lang=='en')
                {
                    send_booking_push($udevc, "Your booking for ".$cntname->centre_name."", "On ".$bookinglists->schedule_date." cancelled successfully.", "individual", 0, $dtype->devicetype);
                }
                if($lang=='zu')
                {
                    send_booking_push($udevc, "Ukubhukha kwakho ".$cntname->centre_name."", "Vuliwe ".$bookinglists->schedule_date." kukhanselwe ngempumelelo.", "individual", 0,$dtype->devicetype);
                }
                if($lang=='st')
                {
                    send_booking_push($udevc, "Booking ea hau bakeng sa ".$cntname->centre_name."", "E butsoe ".$bookinglists->schedule_date." e hlakotsoe ka katleho.", "individual", 0, $dtype->devicetype);
                }
            }

            $usermail = getusermail($uid)->usermail;
            $cntname = centre_info('centre_name',$bookinglists->centre_id);
            $status = sendbookingcancelledmail($usermail, $cntname->centre_name, $bookinglists->schedule_date, $bookinglists->booking_time, $lang);

            $log_array = array(
                "api_name" => "Booking Cancel",
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
                $main_arr['info']['response']['data'] = 'No Booking found with this User.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'Akukho Ukubhuka okutholakele ngalo Msebenzisi.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Ha ho peheletso e fumanoeng le mosebelisi enoa.';
            }     
            //$main_arr['info']['response']['data'] = 'No Booking found for this user';

            $log_array = array(
                "api_name" => "Booking Cancel",
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

    public function review_post()
	{
        $lang = $this->input->post('lang');
        $uid = $this->input->post('uid');
        $bid = $this->input->post('booking_id');
        $rating = $this->input->post('star_rate');
        $review = $this->input->post('review_text');

        $insertId = '';
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
        
        $main_arr['info']['description']='Booking cancel by User';
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
        $main_arr['paths']['api/v1/bookings/bookinglist']['POST']['summary']='Cancellation of Booking by User';
        $main_arr['paths']['api/v1/bookings/bookinglist']['POST']['description']='Cancellation of Booking by User from APP';
        $main_arr['paths']['api/v1/bookings/bookinglist']['POST']['parameters']='uid(:num), lang, booking_id(:num)';
        
        $this->db->select('*');
        $this->db->where('user_id', $uid);
        $this->db->where('id', $bid);
        $qry = $this->db->get('snr_booking');
        $bookinglists = $qry->row();

        if(!empty($bookinglists))
        {
            $cid = getcentreidbybooking($bid)->centre_id;
            $val = array("booking_id" => $bid, "user_id" => $uid, "review_text" => $review, "language" => $lang, "centre_id" => $cid, "centre_rating"=>$rating);
            $this->db->insert('snr_reviews', $val);

            $main_arr['info']['response']['status'] = '1';
            if($lang=='en')
            {
                $main_arr['info']['response']['data'] = 'Your Review Submitted successfully.';
                $main_arr['info']['response']['message'] = 'Your Review Submitted successfully.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'Ukubuyekeza kwakho kuthunyelwe ngempumelelo.';
                $main_arr['info']['response']['message'] = 'Ukubuyekeza kwakho kuthunyelwe ngempumelelo.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Tlhahlobo ea hau e rometsoe ka katleho.';
                $main_arr['info']['response']['message'] = 'Tlhahlobo ea hau e rometsoe ka katleho.';
            }    
            // $main_arr['info']['response']['data'] = '';
            // $main_arr['info']['response']['message'] = 'Your Review Submitted successfully.';

            $log_array = array(
                "api_name" => "Booking Review",
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
                $main_arr['info']['response']['data'] = 'No Booking found.';
                $main_arr['info']['response']['message'] = 'No Booking found.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'Akukho ukubhuka okutholakele.';
                $main_arr['info']['response']['message'] = 'Akukho ukubhuka okutholakele.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Ha ho peheletso e fumanoeng.';
                $main_arr['info']['response']['message'] = 'Ha ho peheletso e fumanoeng.';
            }   
            //$main_arr['info']['response']['data'] = 'No Booking found';

            $log_array = array(
                "api_name" => "Booking Review",
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
