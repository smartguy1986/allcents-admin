<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller
{

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
	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('is_logged_in') == 0) {
			redirect('/');
		}
		$this->load->model('AdminModel');
		// ============= Loading Language ==================
		// if (empty($this->session->userdata('site_lang'))) {
		//     $language = "english";
		//     $siteLang = $this->session->set_userdata('site_lang', $language);
		//     $lang = 'en';
		//     $this->lang->load('homecont', $language);
		// }
		// if ($this->session->userdata('site_lang') == 'en') {
		// 	$language = "english";
		//     $lang = 'en';
		//     $this->lang->load('homecont', $language);
		// }
		// if ($this->session->userdata('site_lang') == 'zu') {
		// 	$language = "zulu";
		//     $lang = 'zu';
		//     $this->lang->load('homecont', $language);
		// }
		// if ($this->session->userdata('site_lang') == 'xh') {
		// 	$language = "xhosa";
		//     $lang = 'xh';
		//     $this->lang->load('homecont', $language);
		// }

		$this->maincolor = array(
			'rgba(240,128,128,0.4)',
			'rgba(205,92,92,0.4)',
			'rgba(220,20,60,0.4)',
			'rgba(178,34,34,0.4)',
			'rgba(255,0,0,0.4)',
			'rgba(139,0,0,0.4)',
			'rgba(255,127,80,0.4)',
			'rgba(255,99,71,0.4)',
			'rgba(255,69,0,0.4)',
			'rgba(255,215,0,0.4)',
			'rgba(255,165,0,0.4)',
			'rgba(255,140,0,0.4)',
			'rgba(50,205,50,0.4)',
			'rgba(34,139,34,0.4)',
			'rgba(0,128,0,0.4)',
			'rgba(0,100,0,0.4)',
			'rgba(60,179,113,0.4)',
			'rgba(46,139,87,0.4)',
			'rgba(128,128,0,0.4)',
			'rgba(107,142,35,0.4)',
			'rgba(102,205,170,0.4)',
			'rgba(32,178,170,0.4)',
			'rgba(0,139,139,0.4)',
			'rgba(0,128,128,0.4)',
			'rgba(0,191,255,0.4)',
			'rgba(30,144,255,0.4)',
			'rgba(100,149,237,0.4)',
			'rgba(65,105,225,0.4)',
			'rgba(0,0,255,0.4)',
			'rgba(0,0,205,0.4)',
			'rgba(123,104,238,0.4)',
			'rgba(106,90,205,0.4)',
			'rgba(238,130,238,0.4)',
			'rgba(218,112,214,0.4)',
			'rgba(255,0,255,0.4)',
			'rgba(186,85,211,0.4)',
			'rgba(147,112,219,0.4)',
			'rgba(138,43,226,0.4)',
			'rgba(148,0,211,0.4)',
			'rgba(153,50,204,0.4)',
			'rgba(139,0,139,0.4)',
			'rgba(128,0,128,0.4)',
			'rgba(75,0,130,0.4)',
			'rgba(255,105,180,0.4)',
			'rgba(255,20,147,0.4)',
			'rgba(219,112,147,0.4)',
			'rgba(199,21,133,0.4)',
			'rgba(222,184,135,0.4)',
			'rgba(210,180,140,0.4)',
			'rgba(188,143,143,0.4)',
			'rgba(244,164,96,0.4)',
			'rgba(218,165,32,0.4)',
			'rgba(205,133,63,0.4)',
			'rgba(210,105,30,0.4)',
			'rgba(139,69,19,0.4)',
			'rgba(160,82,45,0.4)',
			'rgba(165,42,42,0.4)',
			'rgba(128,0,0,0.4)'
		);

		$this->borderColor = array(
			'rgba(240,128,128,1)',
			'rgba(205,92,92,1)',
			'rgba(220,20,60,1)',
			'rgba(178,34,34,1)',
			'rgba(255,0,0,1)',
			'rgba(139,0,0,1)',
			'rgba(255,127,80,1)',
			'rgba(255,99,71,1)',
			'rgba(255,69,0,1)',
			'rgba(255,215,0,1)',
			'rgba(255,165,0,1)',
			'rgba(255,140,0,1)',
			'rgba(50,205,50,1)',
			'rgba(34,139,34,1)',
			'rgba(0,128,0,1)',
			'rgba(0,100,0,1)',
			'rgba(60,179,113,1)',
			'rgba(46,139,87,1)',
			'rgba(128,128,0,1)',
			'rgba(107,142,35,1)',
			'rgba(102,205,170,1)',
			'rgba(32,178,170,1)',
			'rgba(0,139,139,1)',
			'rgba(0,128,128,1)',
			'rgba(0,191,255,1)',
			'rgba(30,144,255,1)',
			'rgba(100,149,237,1)',
			'rgba(65,105,225,1)',
			'rgba(0,0,255,1)',
			'rgba(0,0,205,1)',
			'rgba(123,104,238,1)',
			'rgba(106,90,205,1)',
			'rgba(238,130,238,1)',
			'rgba(218,112,214,1)',
			'rgba(255,0,255,1)',
			'rgba(186,85,211,1)',
			'rgba(147,112,219,1)',
			'rgba(138,43,226,1)',
			'rgba(148,0,211,1)',
			'rgba(153,50,204,1)',
			'rgba(139,0,139,1)',
			'rgba(128,0,128,1)',
			'rgba(75,0,130,1)',
			'rgba(255,105,180,1)',
			'rgba(255,20,147,1)',
			'rgba(219,112,147,1)',
			'rgba(199,21,133,1)',
			'rgba(222,184,135,1)',
			'rgba(210,180,140,1)',
			'rgba(188,143,143,1)',
			'rgba(244,164,96,1)',
			'rgba(218,165,32,1)',
			'rgba(205,133,63,1)',
			'rgba(210,105,30,1)',
			'rgba(139,69,19,1)',
			'rgba(160,82,45,1)',
			'rgba(165,42,42,1)',
			'rgba(128,0,0,1)'
		);
	}

	public function index()
	{
		$data['provinces'] = $this->AdminModel->get_province_info();
		$data['company_info'] = $this->AdminModel->get_settings_info();
		$this->load->view('admin/dashboard', $data);
	}

	public function update_company()
	{
		if (!empty($_FILES['company_logo']['name'])) {
			$this->load->library('upload');

			$filename = sha1(time() . $_FILES['company_logo']['name']);
			$config['upload_path'] = FCPATH . '/uploads/company/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '409600';
			$config['file_name'] = $filename;
			$config['create_thumb'] = TRUE;

			$this->upload->initialize($config);

			if ($this->upload->do_upload('company_logo')) {
				$imageDetailArray = $this->upload->data();
				$image = $imageDetailArray['file_name'];
			}

			if (!empty($this->input->post('company_logo_old'))) {
				$path = FCPATH . 'uploads/company/' . $this->input->post('company_logo_old');
				if (file_exists($path)) {
					unlink($path);
				}
			}

		} else {
			$image = $this->input->post('company_logo_old');
		}

		$data = array(
			"company_logo" => $image,
			"company_name" => $this->input->post('company_name'),
			"company_email" => $this->input->post('company_email'),
			"company_address" => $this->input->post('company_address'),
			"company_phone" => $this->input->post('company_phone'),
			"company_fax" => $this->input->post('company_fax'),
			"company_city" => $this->input->post('company_city'),
			"company_state" => $this->input->post('company_state'),
			"company_zip" => $this->input->post('company_zip'),
		);

		$id = $this->AdminModel->update_company_info($data);
		if ($id) {
			redirect('dashboard');
		}
	}

	public function displayapis()
	{
		$data['company_info'] = $this->AdminModel->get_settings_info();
		$this->load->view('admin/apilists', $data);
	}

	public function displayapisnew()
	{
		$data['company_info'] = $this->AdminModel->get_settings_info();
		$this->load->view('admin/apilistsnew', $data);
	}

	public function api_call_logs()
	{
		$data['api_calls'] = $this->AdminModel->get_call_logs();
		$this->load->view('admin/apicalllogs', $data);
	}

	public function admindetails()
	{
		$data['admin_details'] = $this->AdminModel->getadmindetails();
		$this->load->view('admin/admindetails', $data);
	}

	public function calendar()
	{
		$data['calendar_details'] = $this->AdminModel->getcalendardetails();
		$this->load->view('admin/calendardetails', $data);
	}

	public function updateadmin()
	{
		if (!empty($_FILES['admin_image']['name'])) {
			$this->load->library('upload');

			$filename = sha1(time() . $_FILES['admin_image']['name']);
			$config['upload_path'] = FCPATH . '/uploads/admin/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '409600';
			$config['file_name'] = $filename;
			$config['create_thumb'] = TRUE;

			$this->upload->initialize($config);

			if ($this->upload->do_upload('admin_image')) {
				$imageDetailArray = $this->upload->data();
				$image = $imageDetailArray['file_name'];
			}

			if (!empty($this->input->post('admin_oldimage'))) {
				$path = FCPATH . 'uploads/admin/' . $this->input->post('admin_oldimage');
				if (file_exists($path)) {
					unlink($path);
				}
			}

		} else {
			$image = $this->input->post('admin_oldimage');
		}

		$data = array(
			"admin_image" => $image,
			"admin_name" => $this->input->post('admin_name'),
			"highlight_section_en" => $this->input->post('highlight_section_en'),
			"admin_bio_en" => $this->input->post('admin_bio_en'),
			"highlight_section_zu" => $this->input->post('highlight_section_zu'),
			"admin_bio_zu" => $this->input->post('admin_bio_zu'),
			"highlight_section_st" => $this->input->post('highlight_section_st'),
			"admin_bio_st" => $this->input->post('admin_bio_st'),
		);

		$id = $this->AdminModel->update_admin($data, $this->input->post('admin_id'));
		if ($id) {
			$this->session->set_flashdata('success', 'Admin updated successfully!');
			redirect('details');
		} else {
			$this->session->set_flashdata('error', 'Admin data not updated. Please try again!');
			redirect('details');
		}
	}

	public function updatecalendarimage()
	{
		if (!empty($_FILES['calendar_image']['name'])) {
			$this->load->library('upload');

			$filename = sha1(time() . $_FILES['calendar_image']['name']);
			$config['upload_path'] = FCPATH . '/uploads/admin/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '409600';
			$config['file_name'] = $filename;
			$config['create_thumb'] = TRUE;

			$this->upload->initialize($config);

			if ($this->upload->do_upload('calendar_image')) {
				$imageDetailArray = $this->upload->data();
				$image = $imageDetailArray['file_name'];
			}

			if (!empty($this->input->post('calendar_oldimage'))) {
				$path = FCPATH . 'uploads/admin/' . $this->input->post('calendar_oldimage');
				if (file_exists($path)) {
					unlink($path);
				}
			}

		} else {
			$image = $this->input->post('calendar_oldimage');
		}

		$data = array(
			"calendar_image" => $image,
		);

		$id = $this->AdminModel->update_calendar($data, $this->input->post('calendar_id'));
		if ($id) {
			$this->session->set_flashdata('success', 'Calendar image updated successfully!');
			redirect('calendar');
		} else {
			$this->session->set_flashdata('error', 'Calendar image not updated. Please try again!');
			redirect('calendar');
		}
	}

	public function getapidata()
	{
		$apiid = $this->input->post('aid');
		$data = $this->AdminModel->get_api_info($apiid);
		// print_r($data);
		$htmltosend = '';
		$htmltosend .= '<div class="card">
		<div class="card-header bg-primary">
			<h5 class="card-title text-white text-uppercase text-center">' . $data->api_name . '</h5>
		</div>
		<div class="card-body">
			<div class="input-group mb-3">
				<span class="input-group-text bg-warning" id="basic-addon1">' . $data->api_method . '</span>
				<input type="text" class="form-control" value="' . $data->api_path . '"
					readonly>
				<table class="table striped">
					<thead>
						<th>Parameters</th>
					</thead>
					<tbody>
						<tr>
							<td>' . $data->api_parameter . '</td>
						</tr>
					</tbody>
				</table>
				<div style="clear:both;"></div>
				<br>
				<div class="divdisplay">
				' . $data->api_response . '
				</div>
			</div>
		</div>
	</div>';
		echo $htmltosend;
	}

	public function showmonthlyuserchartall()
	{
		$stime = $this->input->post('timeperiod');
		$getmonthlyuser = getmonthlyuser($stime);

		// echo "<pre>";
		// print_r($getmonthlyuser);
		// echo "</pre>";		

		$datausers = array();
		$datalabels = array();

		$colorseta = $this->maincolor;
		$borderseta = $this->borderColor;

		// $pntr = rand(0,56);

		// shuffle($colorset);
		// shuffle($borderset);

		$datasets = array();
		$i = 0;

		// echo "<pre>";
		// print_r($getmonthlyuser);
		// echo "</pre>";
		$mainlabel = array();
		foreach ($getmonthlyuser as $mnthu2) {
			$datausers = array();
			$datalabels = array();

			// echo "<pre>";
			// print_r($mnthu2);
			// echo "</pre>";

			foreach ($mnthu2 as $mnthu) {
				array_push($datausers, $mnthu['total']);
				if ($stime == 1) {
					array_push($datalabels, $mnthu['mnth']);
				} else if ($stime == 3) {
					$date_string = date("Y") . 'W' . sprintf('%02d', $mnthu['week_number']);
					$week = date('d M', strtotime($date_string));
					array_push($datalabels, $week);
				} else if ($stime == 4) {
					array_push($datalabels, date("jS-M", strtotime($mnthu['mnth'])));
				} else {
					array_push($datalabels, date("F", mktime(null, null, null, $mnthu['idMonth'])) . ', ' . date("Y"));
				}
			}
			$pntr = rand(0, 56);

			$datasets[$i]['label'] = 'All Users';
			$datasets[$i]['data'] = $datausers;
			$datasets[$i]['borderColor'] = $borderseta[$pntr];
			$datasets[$i]['backgroundColor'] = $colorseta[$pntr];
			$datasets[$i]['fill'] = 'false';

			$mainlabel = $datalabels;
			$i++;
		}
		// echo "<pre>";
		// print_r($datalabels);
		// echo "</pre>";
		?>
		<script>
			var ctx = document.getElementById('monthlyusersall').getContext('2d');

			//ctx.clearRect(0, 0, ctx.width, ctx.height);

			if (userChartdn) {
				userChartdn.destroy();
			}
			//ctx.style.backgroundColor = 'rgba(255,0,0,255)';
			var userChartdn = new Chart(ctx, {
				type: 'line',
				data: {
					labels: <?php echo json_encode($mainlabel); ?>,
					datasets: <?php echo json_encode($datasets); ?>
				},
				options: {
					animations: {
						radius: {
							duration: 4000,
							easing: 'linear',
							loop: (context) => context.active
						}
					},
					hoverRadius: 12,
					hoverBackgroundColor: 'yellow',
					interaction: {
						mode: 'nearest',
						intersect: false,
						axis: 'x'
					},
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					},
					plugins: {
						title: {
							display: true,
							text: 'All User Registration'
						},
						legend: {
							display: false,
						}
					},
					chartArea: {
						backgroundColor: 'rgba(78,55,5,1)'
					}
				},
				style: {
					backgroundColor: 'rgba(255,0,0,255)'
				}
			});
		</script>
		<?php
	}

	public function showmonthlydonatechartall()
	{
		$stime = $this->input->post('timeperiodn');
		$getmonthlydonation = getmonthlydonation($stime);

		// echo "<pre>";
		// print_r($getmonthlyuser);
		// echo "</pre>";		

		$datausers = array();
		$datalabels = array();

		$colorseta = $this->maincolor;
		$borderseta = $this->borderColor;

		// $pntr = rand(0,56);

		// shuffle($colorset);
		// shuffle($borderset);

		$datasets = array();
		$i = 0;

		// echo "<pre>";
		// print_r($getmonthlyuser);
		// echo "</pre>";
		$mainlabel = array();
		foreach ($getmonthlydonation as $mnthu2) {
			$datausers = array();
			$datalabels = array();

			// echo "<pre>";
			// print_r($mnthu2);
			// echo "</pre>";

			foreach ($mnthu2 as $mnthu) {
				array_push($datausers, $mnthu['total']);
				if ($stime == 1) {
					array_push($datalabels, $mnthu['mnth']);
				} else if ($stime == 3) {
					$date_string = date("Y") . 'W' . sprintf('%02d', $mnthu['mnth']);
					$week = date('d M', strtotime($date_string));
					array_push($datalabels, $week);
				} else if ($stime == 4) {
					array_push($datalabels, date("jS-M", strtotime($mnthu['mnth'])));
				} else {
					array_push($datalabels, date("F", mktime(null, null, null, $mnthu['idMonth'])) . ', ' . date("Y"));
				}
			}
			$pntr = rand(0, 56);

			$datasets[$i]['label'] = 'All Donations';
			$datasets[$i]['data'] = $datausers;
			$datasets[$i]['borderColor'] = $borderseta[$pntr];
			$datasets[$i]['backgroundColor'] = $colorseta[$pntr];
			$datasets[$i]['fill'] = 'false';

			$mainlabel = $datalabels;
			$i++;
		}

		?>
		<script>
			var ctxd = document.getElementById('monthlydonateall').getContext('2d');

			//ctx.clearRect(0, 0, ctx.width, ctx.height);

			if (userChart) {
				userChart.destroy();
			}
			//ctx.style.backgroundColor = 'rgba(255,0,0,255)';
			var userChart = new Chart(ctxd, {
				type: 'bar',
				data: {
					labels: <?php echo json_encode($mainlabel); ?>,
					datasets: <?php echo json_encode($datasets); ?>
				},
				options: {
					animations: {
						radius: {
							duration: 4000,
							easing: 'linear',
							loop: (context) => context.active
						}
					},
					hoverRadius: 12,
					hoverBackgroundColor: 'yellow',
					interaction: {
						mode: 'nearest',
						intersect: false,
						axis: 'x'
					},
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					},
					plugins: {
						title: {
							display: true,
							text: 'All User Donations'
						},
						legend: {
							display: false,
						}
					},
					chartArea: {
						backgroundColor: 'rgba(78,55,5,1)'
					}
				},
				style: {
					backgroundColor: 'rgba(255,0,0,255)'
				}
			});
		</script>
		<?php
	}

	public function showmonthlyuserchartemail()
	{
		$stime = $this->input->post('timeperiod');
		$getmonthlyuser = getmonthlyuseremail($stime);

		// echo "<pre>";
		// print_r($getmonthlyuser);
		// echo "</pre>";		

		$datausers = array();
		$datalabels = array();

		$colorset2 = $this->maincolor;
		$borderset2 = $this->borderColor;

		// shuffle($colorset);
		// shuffle($borderset);

		$datasets = array();
		$i = 0;

		// echo "<pre>";
		// print_r($getmonthlyuser);
		// echo "</pre>";
		$mainlabel = array();
		foreach ($getmonthlyuser as $mnthu2) {
			$datausers = array();
			$datalabels = array();

			// echo "<pre>";
			// print_r($mnthu2);
			// echo "</pre>";

			foreach ($mnthu2 as $mnthu) {
				array_push($datausers, $mnthu['total']);
				if ($stime == 1) {
					array_push($datalabels, $mnthu['mnth']);
				} else if ($stime == 3) {
					array_push($datalabels, "Week " . $mnthu['mnth']);
				} else {
					array_push($datalabels, $mnthu['mnth'] . ', ' . date("Y"));
				}
			}
			$pntr = rand(0, 56);

			$datasets[$i]['label'] = 'Email Users';
			$datasets[$i]['data'] = $datausers;
			$datasets[$i]['borderColor'] = $borderset2[$pntr];
			$datasets[$i]['backgroundColor'] = $colorset2[$pntr];
			$datasets[$i]['fill'] = 'false';

			$mainlabel = $datalabels;
			$i++;
		}

		?>
		<script>
			var ctx22 = document.getElementById('monthlyusersemail').getContext('2d');

			//ctx.clearRect(0, 0, ctx.width, ctx.height);

			if (userChart22) {
				userChart22.destroy();
			}
			//ctx.style.backgroundColor = 'rgba(255,0,0,255)';
			var userChart22 = new Chart(ctx22, {
				type: 'bar',
				data: {
					labels: <?php echo json_encode($mainlabel); ?>,
					datasets: <?php echo json_encode($datasets); ?>
				},
				options: {
					animations: {
						radius: {
							duration: 4000,
							easing: 'linear',
							loop: (context) => context.active
						}
					},
					hoverRadius: 12,
					hoverBackgroundColor: 'yellow',
					interaction: {
						mode: 'nearest',
						intersect: false,
						axis: 'x'
					},
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					},
					plugins: {
						title: {
							display: true,
							text: 'Email Registration'
						},
						legend: {
							display: false,
						}
					},
					chartArea: {
						backgroundColor: 'rgba(78,55,5,1)'
					}
				},
				style: {
					backgroundColor: 'rgba(255,0,0,255)'
				}
			});
		</script>
		<?php
	}

	public function showmonthlyuserchartsocial()
	{
		$stime = $this->input->post('timeperiod');
		$getmonthlyuser = getmonthlyusersocial($stime);

		// echo "<pre>";
		// print_r($getmonthlyuser);
		// echo "</pre>";		

		$datausers = array();
		$datalabels = array();

		$colorset3 = $this->maincolor;
		$borderset3 = $this->borderColor;

		// shuffle($colorset);
		// shuffle($borderset);

		$datasets = array();
		$i = 0;

		// echo "<pre>";
		// print_r($getmonthlyuser);
		// echo "</pre>";
		$mainlabel = array();
		foreach ($getmonthlyuser as $mnthu2) {
			$datausers = array();
			$datalabels = array();

			// echo "<pre>";
			// print_r($mnthu2);
			// echo "</pre>";

			foreach ($mnthu2 as $mnthu) {
				array_push($datausers, $mnthu['total']);
				if ($stime == 1) {
					array_push($datalabels, $mnthu['mnth']);
				} else if ($stime == 3) {
					array_push($datalabels, "Week " . $mnthu['mnth']);
				} else {
					array_push($datalabels, $mnthu['mnth'] . ', ' . date("Y"));
				}
			}
			$pntr = rand(0, 56);

			$datasets[$i]['label'] = 'Email Users';
			$datasets[$i]['data'] = $datausers;
			$datasets[$i]['borderColor'] = $borderset3[$pntr];
			$datasets[$i]['backgroundColor'] = $colorset3[$pntr];
			$datasets[$i]['fill'] = 'false';

			$mainlabel = $datalabels;
			$i++;
		}

		?>
		<script>
			var ctx23 = document.getElementById('monthlyuserssocial').getContext('2d');

			//ctx.clearRect(0, 0, ctx.width, ctx.height);

			if (userChart23) {
				userChart23.destroy();
			}
			//ctx.style.backgroundColor = 'rgba(255,0,0,255)';
			var userChart23 = new Chart(ctx23, {
				type: 'bar',
				data: {
					labels: <?php echo json_encode($mainlabel); ?>,
					datasets: <?php echo json_encode($datasets); ?>
				},
				options: {
					animations: {
						radius: {
							duration: 4000,
							easing: 'linear',
							loop: (context) => context.active
						}
					},
					hoverRadius: 12,
					hoverBackgroundColor: 'yellow',
					interaction: {
						mode: 'nearest',
						intersect: false,
						axis: 'x'
					},
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					},
					plugins: {
						title: {
							display: true,
							text: 'Email Registration'
						},
						legend: {
							display: false,
						}
					},
					chartArea: {
						backgroundColor: 'rgba(78,55,5,1)'
					}
				},
				style: {
					backgroundColor: 'rgba(255,0,0,255)'
				}
			});
		</script>
		<?php
	}

	public function showbookingcomparechart()
	{
		$stime = $this->input->post('timeperiod');
		$getbookingcompare = getbookingcompare($stime);

		// echo "<pre>";
		// print_r($getbookingcompare);
		// echo "</pre>";

		// die();

		$colorset4 = $this->maincolor;
		$borderset4 = $this->borderColor;

		$datausers6 = array();
		$datalabels6 = array();

		$datasets6 = array();
		$i6 = 0;

		$mainlabel6 = array();
		foreach ($getbookingcompare as $mnthu6) {
			$datausers6 = array();
			$datalabels6 = array();

			// echo "<pre>";
			// print_r($mnthu2);
			// echo "</pre>";

			foreach ($mnthu6 as $mnthu) {
				array_push($datausers6, $mnthu['total']);
				if ($stime == 2 || $stime == 0) {
					array_push($datalabels6, $mnthu['mnth'] . ', ' . date("Y"));
				} else {
					array_push($datalabels6, date("F", mktime(0, 0, 0, $mnthu['mnth'], 10)));
				}

				//array_push($datalabels6, $mnthu['mnth']);
			}

			if ($i6 == 0) {
				$datasets6[$i6]['label'] = 'Booking Received';
			}
			if ($i6 == 1) {
				$datasets6[$i6]['label'] = 'Booking Confirmed';
			}

			$pntr = rand(0, 56);

			$datasets6[$i6]['data'] = $datausers6;
			$datasets6[$i6]['borderColor'] = $borderset4[$pntr];
			$datasets6[$i6]['backgroundColor'] = $colorset4[$pntr];
			$datasets6[$i6]['fill'] = 'false';

			$mainlabel6 = $datalabels6;
			$i6++;
		}

		// echo "<pre>";
		// print_r($mainlabel);
		// echo "</pre>";
		// echo "<pre>";
		// print_r($datasets);
		// echo "</pre>";

		?>
		<script>
			var ctx6 = document.getElementById('bookingcompare').getContext('2d');

			//ctx.clearRect(0, 0, ctx.width, ctx.height);

			if (userChart6) {
				userChart6.destroy();
			}
			//ctx.style.backgroundColor = 'rgba(255,0,0,255)';
			var userChart6 = new Chart(ctx6, {
				type: 'line',
				data: {
					labels: <?php echo json_encode($mainlabel6); ?>,
					datasets: <?php echo json_encode($datasets6); ?>
				},
				options: {
					animations: {
						radius: {
							duration: 4000,
							easing: 'linear',
							loop: (context) => context.active
						}
					},
					hoverRadius: 12,
					hoverBackgroundColor: 'yellow',
					interaction: {
						mode: 'nearest',
						intersect: false,
						axis: 'x'
					},
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					},
					plugins: {
						title: {
							display: true,
							text: 'Booking Received vs Confirmed'
						},
						legend: {
							display: false,
						}
					},
					chartArea: {
						backgroundColor: 'rgba(78,55,5,1)'
					}
				},
				style: {
					backgroundColor: 'rgba(255,0,0,255)'
				}
			});
		</script>
		<?php
	}

	public function showmonthlybookingchartall()
	{
		$stime = $this->input->post('timeperiod');
		$getmonthlyuser = getmonthlybookingall($stime);

		// echo "<pre>";
		// print_r($getmonthlyuser);
		// echo "</pre>";		

		$datausers = array();
		$datalabels = array();

		$colorset5 = $this->maincolor;
		$borderset5 = $this->borderColor;

		// shuffle($colorset);
		// shuffle($borderset);

		$datasets = array();
		$i = 0;

		// echo "<pre>";
		// print_r($getmonthlyuser);
		// echo "</pre>";
		$mainlabel = array();
		foreach ($getmonthlyuser as $mnthu2) {
			$datausers = array();
			$datalabels = array();

			// echo "<pre>";
			// print_r($mnthu2);
			// echo "</pre>";

			foreach ($mnthu2 as $mnthu) {
				array_push($datausers, $mnthu['total']);
				if ($stime == 1) {
					array_push($datalabels, $mnthu['mnth']);
				} else if ($stime == 3) {
					$date_string = date("Y") . 'W' . sprintf('%02d', $mnthu['mnth']);
					$week = date('d M', strtotime($date_string));
					array_push($datalabels, $week);
					//array_push($datalabels, "Week ".$mnthu['mnth']);
				} else if ($stime == 4) {
					array_push($datalabels, date("jS-M", strtotime($mnthu['mnth'])));
				} else {
					array_push($datalabels, $mnthu['mnth'] . ', ' . date("Y"));
				}
			}

			$pntr = rand(0, 56);

			$datasets[$i]['label'] = 'All Booking';
			$datasets[$i]['data'] = $datausers;
			$datasets[$i]['borderColor'] = $borderset5[$pntr];
			$datasets[$i]['backgroundColor'] = $colorset5[$pntr];
			$datasets[$i]['fill'] = 'false';

			$mainlabel = $datalabels;
			$i++;
		}

		?>
		<script>
			var ctx31 = document.getElementById('bookingtotal').getContext('2d');

			//ctx.clearRect(0, 0, ctx.width, ctx.height);

			if (userChart31) {
				userChart31.destroy();
			}
			//ctx.style.backgroundColor = 'rgba(255,0,0,255)';
			var userChart31 = new Chart(ctx31, {
				type: 'bar',
				data: {
					labels: <?php echo json_encode($mainlabel); ?>,
					datasets: <?php echo json_encode($datasets); ?>
				},
				options: {
					animations: {
						radius: {
							duration: 4000,
							easing: 'linear',
							loop: (context) => context.active
						}
					},
					hoverRadius: 12,
					hoverBackgroundColor: 'yellow',
					interaction: {
						mode: 'nearest',
						intersect: false,
						axis: 'x'
					},
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					},
					plugins: {
						title: {
							display: true,
							text: 'All Booking'
						},
						legend: {
							display: false,
						}
					},
					chartArea: {
						backgroundColor: 'rgba(78,55,5,1)'
					}
				},
				style: {
					backgroundColor: 'rgba(255,0,0,255)'
				}
			});
		</script>
		<?php
	}

	public function showmonthlybookingchartprovince()
	{
		$stime = $this->input->post('timeperiod');
		$prid = $this->input->post('provinceid');
		$getmonthlyuser = getmonthlybookingprovince($stime, $prid);

		// echo "<pre>";
		// print_r($getmonthlyuser);
		// echo "</pre>";		

		$datausers = array();
		$datalabels = array();

		$colorset6 = $this->maincolor;
		$borderset6 = $this->borderColor;

		// shuffle($colorset);
		// shuffle($borderset);

		$datasets = array();
		$i = 0;
		$mainlabel = array();
		foreach ($getmonthlyuser as $mnthu2) {
			$datausers = array();
			$datalabels = array();

			// echo "<pre>";
			// print_r($mnthu2);
			// echo "</pre>";
			if ($prid == 0) {
				foreach ($mnthu2 as $mnthu) {
					array_push($datausers, $mnthu['total']);
					array_push($datalabels, $mnthu['province']);
				}
			} else {
				foreach ($mnthu2 as $mnthu) {
					array_push($datausers, $mnthu['total']);
					array_push($datalabels, $mnthu['mnth']);
				}
			}
			$pntr = rand(0, 56);

			$datasets[$i]['label'] = 'All Booking';
			$datasets[$i]['data'] = $datausers;
			$datasets[$i]['borderColor'] = $borderset6[$pntr];
			$datasets[$i]['backgroundColor'] = $colorset6[$pntr];
			$datasets[$i]['fill'] = 'false';

			$mainlabel = $datalabels;
			$i++;
		}

		?>
		<script>
			var ctx32 = document.getElementById('bookingprovince').getContext('2d');

			//ctx.clearRect(0, 0, ctx.width, ctx.height);

			if (userChart32) {
				userChart32.destroy();
			}
			//ctx.style.backgroundColor = 'rgba(255,0,0,255)';
			var userChart32 = new Chart(ctx32, {
				type: 'bar',
				data: {
					labels: <?php echo json_encode($mainlabel); ?>,
					datasets: <?php echo json_encode($datasets); ?>
				},
				options: {
					animations: {
						radius: {
							duration: 4000,
							easing: 'linear',
							loop: (context) => context.active
						}
					},
					hoverRadius: 12,
					hoverBackgroundColor: 'yellow',
					interaction: {
						mode: 'nearest',
						intersect: false,
						axis: 'x'
					},
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					},
					plugins: {
						title: {
							display: true,
							text: 'Booking by Province'
						},
						legend: {
							display: false,
						}
					},
					chartArea: {
						backgroundColor: 'rgba(78,55,5,1)'
					}
				},
				style: {
					backgroundColor: 'rgba(255,0,0,255)'
				}
			});
		</script>
		<?php
	}

	public function showmonthlybookingcharttype()
	{
		$stime = $this->input->post('timeperiod');
		$btype = $this->input->post('booktype');

		$getmonthlyuser = getmonthlybookingtype($stime, $btype);

		// echo "<pre>";
		// print_r($getmonthlyuser);
		// echo "</pre>";		

		$datausers = array();
		$datalabels = array();

		$colorset7 = $this->maincolor;
		$borderset7 = $this->borderColor;

		// shuffle($colorset);
		// shuffle($borderset);

		$datasets = array();
		$i = 0;
		$mainlabel = array();
		foreach ($getmonthlyuser as $mnthu2) {
			$datausers = array();
			$datalabels = array();

			// echo "<pre>";
			// print_r($mnthu2);
			// echo "</pre>";

			foreach ($mnthu2 as $mnthu) {
				array_push($datausers, $mnthu['total']);
				if ($stime == 1) {
					array_push($datalabels, $mnthu['mnth']);
				} else if ($stime == 3) {
					$date_string = date("Y") . 'W' . sprintf('%02d', $mnthu['mnth']);
					$week = date('d M', strtotime($date_string));
					array_push($datalabels, $week);
					//array_push($datalabels, "Week ".$mnthu['mnth']);
				} else if ($stime == 4) {
					array_push($datalabels, date("jS-M", strtotime($mnthu['mnth'])));
				} else {
					array_push($datalabels, $mnthu['mnth'] . ', ' . date("Y"));
				}

				// array_push($datausers, $mnthu['total']);
				// array_push($datalabels, $mnthu['mnth']);
			}

			$pntr = rand(0, 56);

			$datasets[$i]['label'] = 'All Booking';
			$datasets[$i]['data'] = $datausers;
			$datasets[$i]['borderColor'] = $borderset7[$pntr];
			$datasets[$i]['backgroundColor'] = $colorset7[$pntr];
			$datasets[$i]['fill'] = 'false';

			$mainlabel = $datalabels;
			$i++;
		}

		?>
		<script>
			var ctx33 = document.getElementById('bookingtype').getContext('2d');

			//ctx.clearRect(0, 0, ctx.width, ctx.height);

			if (userChart33) {
				userChart33.destroy();
			}
			//ctx.style.backgroundColor = 'rgba(255,0,0,255)';
			var userChart33 = new Chart(ctx33, {
				type: 'bar',
				data: {
					labels: <?php echo json_encode($mainlabel); ?>,
					datasets: <?php echo json_encode($datasets); ?>
				},
				options: {
					animations: {
						radius: {
							duration: 4000,
							easing: 'linear',
							loop: (context) => context.active
						}
					},
					hoverRadius: 12,
					hoverBackgroundColor: 'yellow',
					interaction: {
						mode: 'nearest',
						intersect: false,
						axis: 'x'
					},
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							}
						}]
					},
					plugins: {
						title: {
							display: true,
							text: 'Booking by Province'
						},
						legend: {
							display: false,
						}
					},
					chartArea: {
						backgroundColor: 'rgba(78,55,5,1)'
					}
				},
				style: {
					backgroundColor: 'rgba(255,0,0,255)'
				}
			});
		</script>
		<?php
	}

	public function showmonthlycategorychart()
	{
		$stime = $this->input->post('timeperiod');

		$getmonthlyuser = getmonthlycategory($stime);

		// echo "<pre>";
		// print_r($getmonthlyuser[0]);
		// echo "</pre>";

		if ($stime == 1) {
			echo "<table class='table table-striped table-bordered align-middle mb-0 tabledata' id='tabledata'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Year</th>";
			echo "<th>Category Name</th>";
			echo "<th>Views</th>";
			echo "</tr>";
			echo "<thead>";

			echo "<tbody>";
			$m = 0;
			foreach ($getmonthlyuser[0] as $catchart) {
				echo "<tr>";
				echo "<td>" . $catchart['mnth'] . "</td>";
				echo "<td>";
				echo $catchart['cat_name_en'];
				echo "</td>";
				echo "<td>";
				echo $catchart['total'] . " Views";
				echo "</td>";
				echo "</tr>";
			}
			$m++;
			echo "<tbody>";
			echo "</table>";
		} else {
			echo "<table class='table table-striped table-bordered align-middle mb-0 tabledata' id='tabledata'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Month</th>";
			echo "<th>Category Name</th>";
			echo "<th></th>";
			echo "</tr>";
			echo "<thead>";

			echo "<tbody>";
			for ($j = 1; $j < 13; $j++) {
				$m = 0;
				if (isset($getmonthlyuser[0][$j])) {
					foreach ($getmonthlyuser[0][$j] as $catchart) {
						echo "<tr>";
						echo "<td>" . date('F', mktime(0, 0, 0, $getmonthlyuser[0][$j][$m]['mnth'], 10)) . "</td>";
						echo "<td>";
						echo $catchart['cat_name_en'];
						echo "</td>";
						echo "<td>";
						echo $catchart['total'] . " Views";
						echo "</td>";
						echo "</tr>";
					}
					$m++;
				}
			}

			echo "<tbody>";
			echo "</table>";
		}
	}

	public function toparticlechart()
	{
		$stime = $this->input->post('timeperiod');

		$getmonthlyuser = last10_articles($stime);

		// echo "<pre>";
		// print_r($getmonthlyuser[0]);
		// echo "</pre>";

		if ($stime == 1) {
			echo "<table class='table table-striped table-bordered align-middle mb-0 tabledata' id='tabledata'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Year</th>";
			echo "<th>Category Name</th>";
			echo "<th>Views</th>";
			echo "</tr>";
			echo "<thead>";

			echo "<tbody>";
			$m = 0;
			foreach ($getmonthlyuser[0] as $catchart) {
				echo "<tr>";
				echo "<td>" . $catchart['mnth'] . "</td>";
				echo "<td>";
				echo $catchart['title_en'];
				echo "</td>";
				echo "<td>";
				echo $catchart['total'] . " Views";
				echo "</td>";
				echo "</tr>";
			}
			$m++;
			echo "<tbody>";
			echo "</table>";
		} else {
			echo "<table class='table table-striped table-bordered align-middle mb-0 tabledata' id='tabledata'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Month</th>";
			echo "<th>Category Name</th>";
			echo "<th></th>";
			echo "</tr>";
			echo "<thead>";

			echo "<tbody>";
			for ($j = 1; $j < 13; $j++) {
				$m = 0;
				if (isset($getmonthlyuser[0][$j])) {
					foreach ($getmonthlyuser[0][$j] as $catchart) {
						echo "<tr>";
						echo "<td>" . date('F', mktime(0, 0, 0, $getmonthlyuser[0][$j][$m]['mnth'], 10)) . "</td>";
						echo "<td>";
						echo $catchart['title_en'];
						echo "</td>";
						echo "<td>";
						echo $catchart['total'] . " Views";
						echo "</td>";
						echo "</tr>";
					}
					$m++;
				}
			}

			echo "<tbody>";
			echo "</table>";
		}
	}

	public function topprovincechart()
	{
		$stime = $this->input->post('timeperiod');

		$getmonthlyuser = topprovince($stime);

		// echo "<pre>";
		// print_r($getmonthlyuser[0]);
		// echo "</pre>";

		if ($stime == 1) {
			echo "<table class='table table-striped table-bordered align-middle mb-0 tabledata' id='tabledata'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Year</th>";
			echo "<th>Province Name</th>";
			echo "<th>Views</th>";
			echo "</tr>";
			echo "<thead>";

			echo "<tbody>";
			$m = 0;
			foreach ($getmonthlyuser[0] as $catchart) {
				echo "<tr>";
				echo "<td>" . $catchart['mnth'] . "</td>";
				echo "<td>";
				echo $catchart['ProvinceName'];
				echo "</td>";
				echo "<td>";
				echo $catchart['total'] . " Views";
				echo "</td>";
				echo "</tr>";
			}
			$m++;
			echo "<tbody>";
			echo "</table>";
		} else {
			echo "<table class='table table-striped table-bordered align-middle mb-0 tabledata' id='tabledata'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Month</th>";
			echo "<th>Province Name</th>";
			echo "<th></th>";
			echo "</tr>";
			echo "<thead>";

			echo "<tbody>";
			for ($j = 1; $j < 13; $j++) {
				$m = 0;
				if (isset($getmonthlyuser[0][$j])) {
					foreach ($getmonthlyuser[0][$j] as $catchart) {
						echo "<tr>";
						echo "<td>" . date('F', mktime(0, 0, 0, $getmonthlyuser[0][$j][$m]['mnth'], 10)) . "</td>";
						echo "<td>";
						echo $catchart['ProvinceName'];
						echo "</td>";
						echo "<td>";
						echo $catchart['total'] . " Views";
						echo "</td>";
						echo "</tr>";
					}
					$m++;
				}
			}

			echo "<tbody>";
			echo "</table>";
		}
	}

	public function topcitychart()
	{
		$stime = $this->input->post('timeperiod');

		$getmonthlyuser = topcities($stime);

		// echo "<pre>";
		// print_r($getmonthlyuser[0]);
		// echo "</pre>";

		if ($stime == 1) {
			echo "<table class='table table-striped table-bordered align-middle mb-0 tabledata' id='tabledata'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Year</th>";
			echo "<th>City Name</th>";
			echo "<th>Views</th>";
			echo "</tr>";
			echo "<thead>";

			echo "<tbody>";
			$m = 0;
			foreach ($getmonthlyuser[0] as $catchart) {
				echo "<tr>";
				echo "<td>" . $catchart['mnth'] . "</td>";
				echo "<td>";
				echo $catchart['RegionName'];
				echo "</td>";
				echo "<td>";
				echo $catchart['total'] . " Views";
				echo "</td>";
				echo "</tr>";
			}
			$m++;
			echo "<tbody>";
			echo "</table>";
		} else {
			echo "<table class='table table-striped table-bordered align-middle mb-0 tabledata' id='tabledata'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Month</th>";
			echo "<th>City Name</th>";
			echo "<th></th>";
			echo "</tr>";
			echo "<thead>";

			echo "<tbody>";
			for ($j = 1; $j < 13; $j++) {
				$m = 0;
				if (isset($getmonthlyuser[0][$j])) {
					foreach ($getmonthlyuser[0][$j] as $catchart) {
						echo "<tr>";
						echo "<td>" . date('F', mktime(0, 0, 0, $getmonthlyuser[0][$j][$m]['mnth'], 10)) . "</td>";
						echo "<td>";
						echo $catchart['RegionName'];
						echo "</td>";
						echo "<td>";
						echo $catchart['total'] . " Views";
						echo "</td>";
						echo "</tr>";
					}
					$m++;
				}
			}

			echo "<tbody>";
			echo "</table>";
		}
	}
}