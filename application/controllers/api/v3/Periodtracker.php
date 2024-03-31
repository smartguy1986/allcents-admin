<?php
header('Access-Control-Allow-Origin: *');

require APPPATH . 'libraries/REST_Controller.php';

class Periodtracker extends REST_Controller  {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

	public function index_post()
	{
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
               
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        $main_arr['info']['description']='Period Tracker Entry';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/periodtracker/']['POST']['summary']='Enter period details of an user';
        $main_arr['paths']['api/v1/periodtracker/']['POST']['description']='All the period related details of a user';
        $main_arr['paths']['api/v1/periodtracker/']['POST']['parameters']='';
        
        $lang = $this->input->post('lang');

        if(!empty($this->input->post('user_id')))
        {
            $uid = $this->input->post('user_id');
            $udata = checkperioddata($uid);
            if($udata>0)
            {
                $val = array(
                    "status" => '0'
                );

                $this->db->where('user_id', $uid);
                $this->db->update('snr_period', $val);
                $insertId2 = $this->db->affected_rows();
            }

            $val = array(
                "user_id" => $this->input->post('user_id'),
                "last_day" => $this->input->post('last_day'),
                "cycle_days" => $this->input->post('cycle_days'),
                "menstrual_type" => $this->input->post('menstrual_type'),
                "question1" => $this->input->post('question'),
                "answer1" => $this->input->post('answer'),
                "status" => '1'
            );

            $this->db->insert('snr_period', $val);
            $insertId = $this->db->insert_id();

            
            if($insertId)
            {
                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['data'] = 'Your Info addedd successfully';
                $main_arr['info']['response']['message'] = 'Your Info addedd successfully';

                $log_array = array(
                    "api_name" => "Period Data Entry",
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
                $main_arr['info']['response']['data'] = 'Please try again!!';
                $main_arr['info']['response']['message'] = 'Please try again!!';
            }
        }
        else{
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = 'User ID can not be blank!';

            $log_array = array(
                "api_name" => "Period Data Entry",
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

    public function calendartest_post()
	{
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
               
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        $main_arr['info']['description']='Period Calendar Generator';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/periodtracker/']['POST']['summary']='Period dates calculator';
        $main_arr['paths']['api/v1/periodtracker/']['POST']['description']='Generate calendar format of the upcoming dates with period data';
        $main_arr['paths']['api/v1/periodtracker/']['POST']['parameters']='';
        
        $lang = $this->input->post('lang');

        if(!empty($this->input->post('user_id')))
        {
            $uid = $this->input->post('user_id');
            $udata = getperioddata($uid);
            if($udata)
            {
                $last_day = $udata->last_day;
                $cycle = $udata->cycle_days;
               
                $next_period = date('Y-m-d', strtotime($last_day .' +'.$cycle.' day'));
                $firstday = date('Y-m-d', strtotime($last_day .' +'.$cycle.' day'));
                //$firstday=date('Y-m-d', strtotime($last_day .' +17 day'));
                $lastday=date('Y-m-d', strtotime($firstday .' +7 day'));   
                $ovulation = date('Y-m-d', strtotime('+6 days', strtotime($firstday)));

                $now = time(); // or your date as well
                if($firstday<=$now)
                {
                    $datediff = 0;       
                }
                else
                {
                    $datediff = strtotime($firstday) - $now;       
                }
                $datediff2 = strtotime($ovulation) - $now;
                
                $dateval = array();
                $period = array();
                $ovulationdata = array();
                $normalDays = array();
                // for each day in the month
                
                $first_day_this_month = date('Y-m-01'); // hard-coded '01' for first day
                $last_day_this_month  = date('Y-m-t');

                for($i = 1; $i <=  date('t'); $i++)
                {
                    $ndate = date('Y') . "-" . date('m') . "-" . str_pad($i, 2, '0', STR_PAD_LEFT);
                    $periodNote = getperiodnote($ndate, $uid);

                    // echo "<pre>";
                    // print_r($periodNote);
                    // echo "</pre>";

                    if($ndate==$ovulation)
                    {                  
                        $dd = array("date"=>$ndate, "color"=>"#B01A80", "note" => $periodNote);
                        array_push($dateval, $dd);
                        //array_push($ovulationdata, $dd);
                    }
                    else if($ndate>=$firstday && $ndate <=$lastday)
                    {
                        $dd = array("date"=>$ndate, "color"=>"#1AB04A", "note" => $periodNote);
                        array_push($dateval, $dd);
                        //array_push($period, $dd);
                    }                        
                    else
                    {
                        $dd = array("date"=>$ndate, "color"=>"#ffffff", "note" => $periodNote);
                        //array_push($normalDays, $dd);
                        array_push($dateval, $dd);
                    }
                }

                // $sumup = array("month1" => array("normal_days" => $normalDays, "ovulation_days" => $ovulationdata, "period_days" => $period));
                // array_push($dateval, $sumup); 

                // ======================================================================= Next Month ============================================
                if(date('m')==12)
                {
                    $cy=date("Y", strtotime("+1 year"));
                    //echo $cy;
                }
                else
                {
                    $cy = date("Y");
                }


                $last_day2 = $firstday;
              
                $next_period2 = date('Y-m-d', strtotime($last_day2 .' +'.$cycle.' day'));
                $firstday2=date('Y-m-d', strtotime($last_day2 .' +'.$cycle.' day'));
                $lastday2=date('Y-m-d', strtotime($firstday2 .' +7 day'));   
                $ovulation2 = date('Y-m-d', strtotime('+6 days', strtotime($firstday2)));
              
                $first_day_this_month2 = date('Y-m-d', strtotime('first day of next month')); // hard-coded '01' for first day
                $last_day_this_month2  = date('Y-m-d', strtotime('last day of next month'));

                for($i2 = 1; $i2 <=  date('t'); $i2++)
                {
                    $ndate2 = $cy . "-" . date('m', strtotime(' +1 month')) . "-" . str_pad($i2, 2, '0', STR_PAD_LEFT);
                    if($ndate2==$ovulation2 || $ndate2==$ovulation)
                    {
                        $dd2 = array("date"=>$ndate2, "color"=>"#B01A80");
                        //array_push($ovulationdata2, $dd2);
                        array_push($dateval, $dd2); 
                    }
                    else if(($ndate2>=$firstday2 && $ndate2 <=$lastday2) || ($ndate2>=$firstday && $ndate2 <=$lastday)) 
                    {
                        $dd2 = array("date"=>$ndate2, "color"=>"#1AB04A");
                        //array_push($period2, $dd2);
                        array_push($dateval, $dd2); 
                    }                        
                    else
                    {
                        $dd2 = array("date"=>$ndate2, "color"=>"#ffffff");
                        //array_push($normalDays2, $dd2);
                        array_push($dateval, $dd2); 
                    }
                }

                // $sumup2 = array("month2" => array("normal_days" => $normalDays2, "ovulation_days" => $ovulationdata2, "period_days" => $period2));
                // array_push($dateval, $sumup); 


                $data = array(
                    "last_date" => $last_day,
                    "icon1" => "http://localhost/arijit/allcents/admin/resources/appicons/doctor.png",
                    "icon2" => "http://localhost/arijit/allcents/admin/resources/appicons/calendar.png",
                    "start_date" => date('Y-m-01'),
                    "end_date" => date("Y-m-t", strtotime("+1 month")),
                    "first_heading" => round($datediff / (60 * 60 * 24))." Days left for Next Period.",
                    "second_heading" => (round($datediff2 / (60 * 60 * 24))<1) ? " Your Ovulation date passed already." : round($datediff2 / (60 * 60 * 24))." Days left for next Ovulation.",
                    "calendar_data" => $dateval,
                );

                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['data'] = $data;
                $main_arr['info']['response']['message'] = '';

                $log_array = array(
                    "api_name" => "Period Calendar",
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
                $main_arr['info']['response']['data'] = 'No period data available wih this user';
                $main_arr['info']['response']['message'] = 'No period data available wih this user';
                
                $log_array = array(
                    "api_name" => "Period Calendar",
                    "api_method" => "POST",
                    "api_data" => json_encode($_POST),
                    "api_lang" => $lang,
                    "api_status" => 0,
                    "ip_addr" => $_SERVER['REMOTE_ADDR']
                );
                $this->db->insert('snr_api_call_log', $log_array);
            }
        }
        else{
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = 'User ID can not be blank!';
            $main_arr['info']['response']['message'] = 'User ID can not be blank!';

            $log_array = array(
                "api_name" => "Period Calendar",
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

    public function calendar_post()
	{
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
               
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        $main_arr['info']['description']='Period Calendar Generator';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/periodtracker/']['POST']['summary']='Period dates calculator';
        $main_arr['paths']['api/v1/periodtracker/']['POST']['description']='Generate calendar format of the upcoming dates with period data';
        $main_arr['paths']['api/v1/periodtracker/']['POST']['parameters']='';
        
        $lang = $this->input->post('lang');

        if(!empty($this->input->post('user_id')))
        {
            $uid = $this->input->post('user_id');
            $udata = getperioddata($uid);
            if($udata)
            {
                // echo "<pre>";
                // print_r($udata);
                // echo "</pre>";
                
                $dateval = array();
                $now = date("Y-m-d");
                
                $month_1_start = date('Y-m-01', strtotime('-3 month'));
                $month_1_end  = date('Y-m-t', strtotime('-3 month'));
                $month_2_start = date('Y-m-01', strtotime('-2 month'));
                $month_2_end  = date('Y-m-t', strtotime('-2 month'));
                $month_3_start = date('Y-m-01', strtotime('-1 month'));
                $month_3_end  = date('Y-m-t', strtotime('-1 month'));
                $month_4_start = date('Y-m-01');
                $month_4_end  = date('Y-m-t');
                $month_5_start = date('Y-m-01', strtotime('+1 month'));
                $month_5_end  = date('Y-m-t', strtotime('+1 month'));
                $month_6_start = date('Y-m-01', strtotime('+2 month'));
                $month_6_end  = date('Y-m-t', strtotime('+2 month'));         

                $last_day = $udata->last_day;
                $cycle = $udata->cycle_days;
                
                $time=strtotime($last_day);
                $month=date("m",$time);
                $year=date("Y",$time);

                $start_time = date($year.'-'.$month.'-01');

                $date1 = $start_time;
                $date2 = $month_4_end;
                $d1=new DateTime($date2); 
                $d2=new DateTime($date1);                                  
                $Months = $d2->diff($d1); 
                $howeverManyMonths = (($Months->y) * 12) + ($Months->m);
                
                $fdays = array();
                $ldays = array();
                $odays = array();
                // $npday = array();
                // $noday = array();

                if($howeverManyMonths>3)
                {
                    $lpcnt = 3;
                    while(strtotime($last_day)<strtotime($month_1_start))
                    {
                        $last_day = date('Y-m-d', strtotime($last_day .' +'.$cycle.' day'));
                    }
                    $last_dayn= $last_day;                 
                    $start_dt = $month_1_start;
                    
                    while(date("Y-m", strtotime($last_day))<date("Y-m", strtotime($month_6_end)))
                    {
                        $fday = $last_day;
                        $lday = date('Y-m-d', strtotime($last_day .' +5 day'));
                        $oday = date('Y-m-d', strtotime($last_day .' +13 day'));
                        
                        array_push($fdays, $fday);
                        array_push($ldays, $lday);
                        array_push($odays, $oday);

                        
                        $last_day = date('Y-m-d', strtotime($last_day .' +'.$cycle.' day'));
                    }
                }
                else
                {
                    $lpcnt = $howeverManyMonths;
                    if($lpcnt==3)
                    {
                        $start_dt = $month_1_start;
                    }
                    if($lpcnt==2)
                    {
                        $start_dt = $month_2_start;
                    }
                    if($lpcnt==1)
                    {
                        $start_dt = $month_3_start;
                    }
                    if($lpcnt==0)
                    {
                        $start_dt = $month_4_start;
                    }

                    $last_daycl = $last_day; 
                    while(date("Y-m", strtotime($last_daycl))<=date("Y-m", strtotime($month_6_end)))
                    {
                        array_push($fdays, $last_daycl);
                        array_push($ldays, date('Y-m-d', strtotime($last_daycl .' +5 day')));
                        array_push($odays, date('Y-m-d', strtotime($last_daycl .' +13 day')));

                        $last_daycl = date('Y-m-d', strtotime($last_daycl .' +'.$cycle.' day'));
                    }  
                }
                
                foreach($fdays as $day1)
                {
                    if($day1>date("Y-m-d"))
                    {
                        $npday = $day1;
                        break;
                    }
                }
                foreach($odays as $day2)
                {
                    if($day2>date("Y-m-d"))
                    {
                        $opday = $day2;
                        break;
                    }
                }

                // echo "<pre>";
                // print_r($fdays);
                // print_r($ldays);
                // print_r($odays);
                // echo "</pre>";
                $np = array();
                $xx = count($fdays);
                for($kk=0; $kk<$xx; $kk++)
                {
                    $n_dt = $fdays[$kk];
                    while (strtotime($n_dt) <= strtotime($ldays[$kk])) {
                        array_push($np, $n_dt);
                        $n_dt = date ("Y-m-d", strtotime("+1 days", strtotime($n_dt)));
                    }
                }
                // echo "<pre>";
                // print_r($np);
                // echo "</pre>";

                // ==================  calculation of Months ==================== 
                if($start_time<$month_1_start)
                {   
                    $srt_dt =  $month_1_start;
                    while (strtotime($srt_dt) <= strtotime($month_6_end)) {
                        //echo $srt_dt;
                        $periodNote = getperiodnote($srt_dt, $uid);
                        if(in_array($srt_dt, $odays))
                        {
                            if($srt_dt<$now)
                            {
                                $dd2 = array("date"=>$srt_dt, "color"=>"#efefef", "note" => $periodNote);
                                //array_push($ovulationdata2, $dd2);
                                array_push($dateval, $dd2); 
                            }
                            else
                            {
                                $dd2 = array("date"=>$srt_dt, "color"=>"#B01A80", "note" => $periodNote);
                                //array_push($ovulationdata2, $dd2);
                                array_push($dateval, $dd2); 
                            }
                        }
                        else if(in_array($srt_dt, $np)) 
                        {
                            if($srt_dt<$now)
                            {
                                $dd2 = array("date"=>$srt_dt, "color"=>"#efefef", "note" => $periodNote);
                                //array_push($period2, $dd2);
                                array_push($dateval, $dd2); 
                            }
                            else
                            {
                                $dd2 = array("date"=>$srt_dt, "color"=>"#1AB04A", "note" => $periodNote);
                                //array_push($period2, $dd2);
                                array_push($dateval, $dd2); 
                            }
                            
                        }                        
                        else
                        {
                            $dd2 = array("date"=>$srt_dt, "color"=>"#ffffff", "note" => $periodNote);
                            //array_push($normalDays2, $dd2);
                            array_push($dateval, $dd2);
                        }
                        $srt_dt = date ("Y-m-d", strtotime("+1 days", strtotime($srt_dt)));
                    }
                }
                else
                {
                    $time=strtotime($last_day);
                    $month=date("m",$time);
                    $year=date("Y",$time);

                    $srt_dt =  date($year.'-'.$month.'-01');
                    while (strtotime($srt_dt) <= strtotime($month_6_end)) {
                        //echo $srt_dt;
                        $periodNote = getperiodnote($srt_dt, $uid);
                        if(in_array($srt_dt, $odays))
                        {
                            if($srt_dt<$now)
                            {
                                $dd2 = array("date"=>$srt_dt, "color"=>"#efefef", "note" => $periodNote);
                                //array_push($ovulationdata2, $dd2);
                                array_push($dateval, $dd2); 
                            }
                            else
                            {
                                $dd2 = array("date"=>$srt_dt, "color"=>"#B01A80", "note" => $periodNote);
                                //array_push($ovulationdata2, $dd2);
                                array_push($dateval, $dd2); 
                            }
                        }
                        else if(in_array($srt_dt, $np)) 
                        {
                            if($srt_dt<$now)
                            {
                                $dd2 = array("date"=>$srt_dt, "color"=>"#efefef", "note" => $periodNote);
                                //array_push($period2, $dd2);
                                array_push($dateval, $dd2); 
                            }
                            else
                            {
                                $dd2 = array("date"=>$srt_dt, "color"=>"#1AB04A", "note" => $periodNote);
                                //array_push($period2, $dd2);
                                array_push($dateval, $dd2); 
                            }
                            
                        }              
                        else
                        {
                            $dd2 = array("date"=>$srt_dt, "color"=>"#ffffff", "note" => $periodNote);
                            //array_push($normalDays2, $dd2);
                            array_push($dateval, $dd2);
                        }
                        $srt_dt = date ("Y-m-d", strtotime("+1 days", strtotime($srt_dt)));
                    }
                }

                $now = time(); // or your date as well
                if(strtotime($npday)<=$now)
                {
                    $datediff = 0;       
                }
                else
                {
                    $datediff = strtotime($npday) - $now;       
                }
                $datediff2 = strtotime($opday) - $now;

                if($lang=='en')
                {
                    $first_heading = round($datediff / (60 * 60 * 24))." Days left for Next Period.";
                    $second_heading = (round($datediff2 / (60 * 60 * 24))<1) ? " Your Ovulation date passed already." : round($datediff2 / (60 * 60 * 24))." Days left for next Ovulation.";
                }
                if($lang=='zu')
                {
                    $first_heading = "Izinsuku ezi-".round($datediff / (60 * 60 * 24))." ezisele zenkathi elandelayo";
                    $second_heading = (round($datediff2 / (60 * 60 * 24))<1) ? " Idethi yakho ye-Ovulation isivele isidlulile." : "Izinsuku eziyi-".round($datediff2 / (60 * 60 * 24))." ezisele ze-Ovulation elandelayo.";
                }
                if($lang=='st')
                {
                    $first_heading = "Matsatsi a ".round($datediff / (60 * 60 * 24))." a setseng bakeng sa Nako e Tlang";
                    $second_heading = (round($datediff2 / (60 * 60 * 24))<1) ? " Letsatsi la hau la Ovulation le se le fetile." : "Matsatsi a ".round($datediff2 / (60 * 60 * 24))." a setseng bakeng sa Ovulation e latelang";
                }

                if($lang=='en')
                {
                    $disclimer = "Disclaimer : This is not diagnostic but is a tool to assist you to record and monitor your cycle. You may share this with your nurse or doctor if you are worried.";
                }
                if($lang=='zu')
                {
                    $disclimer = "Umshwana wokuzihlangula : Lokhu akukona ukuxilonga kodwa kuyithuluzi lokukusiza ukurekhoda nokuqapha umjikelezo wakho. Ungabelana ngalokhu nomhlengikazi noma udokotela wakho uma ukhathazekile.";
                }
                if($lang=='st')
                {
                    $disclimer = "Boitlhotlhollo : Sena ha se tlhahlobo empa ke sesebelisoa sa ho u thusa ho rekota le ho beha leihlo potoloho ea hau. U ka arolelana sena le mooki kapa ngaka ea hau haeba u tšoenyehile.";
                }

                $data = array(
                    "last_date" => $udata->last_day,
                    "icon1" => "http://localhost/arijit/allcents/admin/resources/appicons/doctor.png",
                    "icon2" => "http://localhost/arijit/allcents/admin/resources/appicons/calendar.png",
                    "disclimer" => $disclimer,
                    "start_date" => $start_dt,
                    "end_date" => $month_6_end,
                    "first_heading" => $first_heading,
                    "second_heading" => $second_heading,
                    "calendar_data" => $dateval,
                );

                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['data'] = $data;
                $main_arr['info']['response']['message'] = '';   

                $log_array = array(
                    "api_name" => "Period Calendar",
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
                $main_arr['info']['response']['data'] = 'No period data available wih this user';
                $main_arr['info']['response']['message'] = 'No period data available wih this user';

                $log_array = array(
                    "api_name" => "Period Calendar",
                    "api_method" => "POST",
                    "api_data" => json_encode($_POST),
                    "api_lang" => $lang,
                    "api_status" => 0,
                    "ip_addr" => $_SERVER['REMOTE_ADDR']
                );
                $this->db->insert('snr_api_call_log', $log_array);
            }
        }
        else{
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = 'User ID can not be blank!';
            $main_arr['info']['response']['message'] = 'User ID can not be blank!';

            $log_array = array(
                "api_name" => "Period Calendar",
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

    public function dailydata_post()
	{
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
               
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        $main_arr['info']['description']='Period Tracker Note Entry';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/periodtracker/dailydata/']['POST']['summary']='Enter period note for a day details of an user';
        $main_arr['paths']['api/v1/periodtracker/dailydata/']['POST']['description']='Entry of a period note for a particular day';
        $main_arr['paths']['api/v1/periodtracker/dailydata/']['POST']['parameters']='';
        
        $lang = $this->input->post('lang');

        if(!empty($this->input->post('user_id')))
        {
            $note_date = $this->input->post('note_date');
            //$period_id = $this->input->post('period_id');
            $uid = $this->input->post('user_id');

            $this->input->post('user_id');
            $udata = checkperioddata($uid);
            if($udata>0)
            {
                $notedata = checknotedata($note_date, $uid);
                if($notedata>0)
                {
                    $val = array(
                        "note" => $this->input->post('note'),
                        "flow" => $this->input->post('flow')
                    );
    
                    $this->db->where('user_id', $uid);
                    $this->db->where('note_date', $note_date);
                    $this->db->update('snr_period_note', $val);
                    $insertId = $this->db->affected_rows();

                    $main_arr['info']['response']['status'] = '1';
                    $main_arr['info']['response']['data'] = 'Period Note updated successfully';
                    $main_arr['info']['response']['message'] = 'Period Note updated successfully';

                    $log_array = array(
                        "api_name" => "Period Note Update",
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
                    $val = array(
                        //"period_id" => $this->input->post('period_id'),
                        "note_date" => $this->input->post('note_date'),
                        "user_id" => $this->input->post('user_id'),
                        "note" => $this->input->post('note'),
                        "flow" => $this->input->post('flow')
                    );
    
                    $this->db->insert('snr_period_note', $val);
                    $insertId = $this->db->insert_id();

                    $main_arr['info']['response']['status'] = '1';
                    $main_arr['info']['response']['data'] = 'Period Note added successfully';
                    $main_arr['info']['response']['message'] = 'Period Note added successfully';

                    $log_array = array(
                        "api_name" => "Period Note Add",
                        "api_method" => "POST",
                        "api_data" => json_encode($_POST),
                        "api_lang" => $lang,
                        "api_status" => 1,
                        "ip_addr" => $_SERVER['REMOTE_ADDR']
                    );
                    $this->db->insert('snr_api_call_log', $log_array);
                }
            }
            else
            {
                $main_arr['info']['response']['status'] = '0';
                $main_arr['info']['response']['data'] = 'No period Data available with this user';
                $main_arr['info']['response']['message'] = 'No period Data available with this user';

                $log_array = array(
                    "api_name" => "Period Note",
                    "api_method" => "POST",
                    "api_data" => json_encode($_POST),
                    "api_lang" => $lang,
                    "api_status" => 0,
                    "ip_addr" => $_SERVER['REMOTE_ADDR']
                );
                $this->db->insert('snr_api_call_log', $log_array);
            }
        }
        else{
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = 'User ID can not be blank!';
            $main_arr['info']['response']['message'] = 'User ID can not be blank!';

            $log_array = array(
                "api_name" => "Period Calendar",
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
