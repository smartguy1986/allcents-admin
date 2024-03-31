<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class CalendarController extends CI_Controller {

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
		$this->load->view('admin/periodcalendar/perioddatalist', $data);
	}

    
    public function getuserperioddetails()
	{       
		echo $this->input->post('uid');
		?>
		<div class="row">
			<div class="col-12 col-lg-8">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<h6 class="mb-0">Period Calendar</h6>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-lg-4">
				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<h6 class="mb-0">User Overview</h6>
							</div>
						</div>	
					</div>			
				</div>
				<div class="card">
					<div class="card-body">
						<div class="d-flex flex-column align-items-center text-center">
							<img class="rounded-circle p-1 bg-primary" alt="user avatar" src="http://localhost/arijit/allcents/admin/uploads/avatar/male-avatar.jpg" width="110">											<div class="mt-3">
								<h4>Ayan Chakraborty </h4>
								<!-- <p class="text-secondary mb-1">Full Stack Developer</p>
								<p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p> -->
								<!-- <button class="btn btn-primary">Disable</button> -->
								<!-- <button class="btn btn-outline-primary">Message</button> -->
							</div>
						</div>
						<hr class="my-4">
						<ul class="list-group list-group-flush">
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Role</h6>
								<span class="text-secondary">Users</span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Email</h6>
								<span class="text-secondary">ayan480@gmail.com</span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Phone</h6>
								<span class="text-secondary">9126720548</span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Gender</h6>
								<span class="text-secondary">Male</span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Address</h6>
								<span class="text-secondary"></span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">City</h6>
								<span class="text-secondary">Cape Town</span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Zip</h6>
								<span class="text-secondary"></span>
							</li>
							<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
								<h6 class="mb-0">Member Since</h6>
								<span class="text-secondary">06-Sep-2021</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	public function calendargenerate($uid)
	{
		$conditions = array("id" => $uid);
		$data['user_data'] = $this->AdminModel->get_user_info($conditions);

		// ================================================================
		$events = array();
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
							$dd2 = array("date"=>$srt_dt, "color"=>"#D3D4D7", "note" => $periodNote);
							//array_push($ovulationdata2, $dd2);
							array_push($dateval, $dd2); 
							array_push($events, array("title" => "Period", "start" => $srt_dt, "color"=>"#D3D4D7"));
						}
						else
						{
							$dd2 = array("date"=>$srt_dt, "color"=>"#B01A80", "note" => $periodNote);
							//array_push($ovulationdata2, $dd2);
							array_push($dateval, $dd2); 
							array_push($events, array("title" => "Ovulation", "start" => $srt_dt, "color"=>"#B01A80"));
						}
					}
					else if(in_array($srt_dt, $np)) 
					{
						if($srt_dt<$now)
						{
							$dd2 = array("date"=>$srt_dt, "color"=>"#D3D4D7", "note" => $periodNote);
							//array_push($period2, $dd2);
							array_push($dateval, $dd2); 
							array_push($events, array("title" => "Period", "start" => $srt_dt, "color"=>"#D3D4D7"));
						}
						else
						{
							$dd2 = array("date"=>$srt_dt, "color"=>"#1AB04A", "note" => $periodNote);
							//array_push($period2, $dd2);
							array_push($dateval, $dd2); 
							array_push($events, array("title" => "Period", "start" => $srt_dt, "color"=>"#1AB04A"));
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
							$dd2 = array("date"=>$srt_dt, "color"=>"#D3D4D7", "note" => $periodNote);
							//array_push($ovulationdata2, $dd2);
							array_push($dateval, $dd2); 
							array_push($events, array("title" => "Period", "start" => $srt_dt, "color"=>"#D3D4D7"));
						}
						else
						{
							$dd2 = array("date"=>$srt_dt, "color"=>"#B01A80", "note" => $periodNote);
							//array_push($ovulationdata2, $dd2);
							array_push($dateval, $dd2); 
							array_push($events, array("title" => "Ovulation", "start" => $srt_dt, "color"=>"#B01A80"));
						}
					}
					else if(in_array($srt_dt, $np)) 
					{
						if($srt_dt<$now)
						{
							$dd2 = array("date"=>$srt_dt, "color"=>"#D3D4D7", "note" => $periodNote);
							//array_push($period2, $dd2);
							array_push($dateval, $dd2); 
							array_push($events, array("title" => "Period", "start" => $srt_dt, "color"=>"#D3D4D7"));
						}
						else
						{
							$dd2 = array("date"=>$srt_dt, "color"=>"#1AB04A", "note" => $periodNote);
							//array_push($period2, $dd2);
							array_push($dateval, $dd2); 
							array_push($events, array("title" => "Period", "start" => $srt_dt, "color"=>"#1AB04A"));
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
			$first_heading = round($datediff / (60 * 60 * 24))." Days left for Next Period.";
			$second_heading = (round($datediff2 / (60 * 60 * 24))<1) ? " Your Ovulation date passed already." : round($datediff2 / (60 * 60 * 24))." Days left for next Ovulation.";			
		}
		$data['periods'] = $events;
		$data['next_date'] = round($datediff / (60 * 60 * 24));
		$data['ovulation'] = round($datediff2 / (60 * 60 * 24));

		$data['period_note'] = $this->AdminModel->getperiodnotedata($uid);
		$data['booking_history'] = $this->AdminModel->getbookinglist($uid);
		// ================================================================
		$this->load->view('admin/periodcalendar/perioddetails', $data);
	}

}
