<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class CentreController extends CI_Controller {

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
		$data['centres'] = $this->AdminModel->get_centres();
		$this->load->view('admin/centre/centrelist', $data);
	}

    public function addcentre()
	{
        $city_info = array();
        $provinceinfo = $this->AdminModel->get_province_info();
        $data['province'] = $provinceinfo;
		$this->load->view('admin/centre/addcentre', $data);
	}

    public function getcity()
    {
        $pid = $this->input->post('pid');
        $conditions = array("ProvinceID" => $pid);
        $cities = $this->AdminModel->get_city_list($conditions);
        //print_r($cities);
        echo "<select id='centre_city' class='form-select text-dr-val' name='centre_city' data-error2='Please Select City'>";
        if(!empty($cities))
        {
            foreach($cities as $sct)
            {
                echo "<option value='".$sct->RegionID."'>".$sct->RegionName."</option>";
            }
        }
        else
        {
            echo "<option value=''>No Cities found</option>";
        }
        echo "</select>";
    }

	public function getcity2()
    {
        $pid = $this->input->post('pid');
		$cid = $this->input->post('cid');
        $conditions = array("ProvinceID" => $pid);
        $cities = $this->AdminModel->get_city_list($conditions);
        //print_r($cities);
        echo "<select id='centre_city' class='form-select text-dr-val' name='centre_city' data-error2='Please Select City'>";
        if(!empty($cities))
        {
            foreach($cities as $sct)
            {
				echo $sct->RegionID;
				if($sct->RegionID==$cid)
				{
                	echo "<option value='".$sct->RegionID."' selected>".$sct->RegionName."</option>";
				}
				else
				{
					echo "<option value='".$sct->RegionID."'>".$sct->RegionName."</option>";
				}
            }
        }
        else
        {
            echo "<option value=''>No Cities found</option>";
        }
        echo "</select>";
    }
    
	public function savecentre()
	{
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";

        $addr = urlencode($this->input->post('centre_address'));

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$addr."&key=AIzaSyB7MVcJaZu-shdyU_dZzAx1vl2zX_MYJ9k";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $request = curl_exec($ch);
        curl_close($ch);

        //echo "<pre>";
        $centregeo = json_decode($request);
        // print_r($centregeo);
        $clat = $centregeo->results[0]->geometry->location->lat;
        //echo "<br>";
        $clng = $centregeo->results[0]->geometry->location->lng;
        //echo "</pre>";

        //die();

		if(!empty($_FILES['banner_image']['name']))
        {
            $this->load->library('upload');

            $filename = sha1(time().$_FILES['banner_image']['name']);
            $config['upload_path'] = FCPATH.'/uploads/centre/banner/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '409600';
            $config['file_name'] = $filename;
            $config['create_thumb'] = FALSE;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('banner_image')) {
                $imageDetailArray = $this->upload->data();
                $banner_image = $imageDetailArray['file_name'];
            }

            if (!empty($this->input->post('oldbanner_image'))) {
                $path = FCPATH.'uploads/centre/banner/' . $this->input->post('oldbanner_image');
                if (file_exists($path)) {
                    unlink($path);
                }
            }

        }
        else
        {
            $banner_image = $this->input->post('oldbanner_image');
        }

		if(!empty($_FILES['centre_logo']['name']))
        {
            $this->load->library('upload');

            $filename = sha1(time().$_FILES['centre_logo']['name']);
            $config['upload_path'] = FCPATH.'/uploads/centre/logo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '409600';
            $config['file_name'] = $filename;
            $config['create_thumb'] = FALSE;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('centre_logo')) {
                $imageDetailArray = $this->upload->data();
                $centre_logo = $imageDetailArray['file_name'];
            }

            if (!empty($this->input->post('oldcentre_logo'))) {
                $path = FCPATH.'uploads/centre/logo/' . $this->input->post('oldcentre_logo');
                if (file_exists($path)) {
                    unlink($path);
                }
            }

        }
        else
        {
            $centre_logo = $this->input->post('oldcentre_logo');
        }

		$day = $this->input->post('day');
		$start = $this->input->post('start_time');
		$close = $this->input->post('closing_time');
		$timing = array();

		// echo "<pre>";
		// print_r($timing);
		// echo "</pre>";

		$data = array(
			"centre_name" => $this->input->post('centre_name'),
			"centre_bio" => $this->input->post('centre_bio'),
			"centre_address" => $this->input->post('centre_address'),
			"centre_province" => $this->input->post('centre_province'),
			"centre_city" => $this->input->post('centre_city'),
			"centre_email" => $this->input->post('centre_email'),
			"centre_phone" => $this->input->post('country_code')."-".$this->input->post('centre_phone'),
			"centre_fax" => $this->input->post('country_code')."-".$this->input->post('centre_fax'),
			"centre_banner" => $banner_image,
			"centre_logo" => $centre_logo,
			"centre_contact" => $this->input->post('centre_contact'),
            "centre_category" => json_encode($this->input->post('centre_category')),
            "centre_lat" => $clat,
            "centre_long" => $clng
		);

		$id = $this->AdminModel->save_centre($data);
        if($id)
        {
			for($m=0; $m<count($day); $m++)
			{
				$timedata = array("centre_id" => $id, "day_name" => $day[$m], "start_time" => $start[$m], "closing_time" => $close[$m]);
				$this->AdminModel->save_timing($timedata);
			}
            $this->session->set_flashdata('success', 'Centre added successfully!');
            redirect('centres');
        }
        else
        {
            $this->session->set_flashdata('error', 'Centre not added. Please try again!');
            redirect('centres');
        }
	}

	public function details()
	{
		$cid = $this->input->post('cid');

		$conditions = array('id' => $cid);
		$centredata = $this->AdminModel->get_centres($conditions);

		// echo "<pre>";
		// print_r($centredata);
		// echo "</pre>";

		echo json_encode($centredata);
		
	}

	public function getprovincename()
	{
		$pid = $this->input->post('pid');
		echo get_province_name($pid)->ProvinceName;
	}

	public function getcityname()
	{
		$cid = $this->input->post('cid');
		echo city_name($cid)->RegionName;
	}

	public function showtiming()
	{
		$show = $this->AdminModel->getShow($this->input->post('show'));
		// echo "<pre>";
		// print_r($show);
		// echo "</pre>";
		foreach($show as $tm)
		{
			echo "<tr>";
			echo "<td>".$tm->day_name."</td>";
			if($tm->start_time=='0:00')
			{
				echo "<td>Closed</td>";
			}
			else
			{
				echo "<td>".$tm->start_time."</td>";
			}
			if($tm->closing_time=='0:00')
			{
				echo "<td>Closed</td>";
			}
			else
			{
				echo "<td>".$tm->closing_time."</td>";
			}
			echo "</tr>";
		}
	}

	public function editcentre($cid)
	{
		$city_info = array();
        $provinceinfo = $this->AdminModel->get_province_info();
        $data['province'] = $provinceinfo;
		$conditions = array("id"=> $cid);
		$data['centredetails'] = $this->AdminModel->get_centres($conditions);
		$data['centretiming'] = $this->AdminModel->getShow($cid);
		$this->load->view('admin/centre/editcentre', $data);
	}

	public function updatecentre()
	{
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";

		$cid = $this->input->post('centre_id');

		if(!empty($_FILES['banner_image']['name']))
        {
            $this->load->library('upload');

            $filename = sha1(time().$_FILES['banner_image']['name']);
            $config['upload_path'] = FCPATH.'/uploads/centre/banner/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '409600';
            $config['file_name'] = $filename;
            $config['create_thumb'] = FALSE;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('banner_image')) {
                $imageDetailArray = $this->upload->data();
                $banner_image = $imageDetailArray['file_name'];
            }

            if (!empty($this->input->post('old_banner_image'))) {
                $path = FCPATH.'uploads/centre/banner/' . $this->input->post('old_banner_image');
                if (file_exists($path)) {
                    unlink($path);
                }
            }

        }
        else
        {
            $banner_image = $this->input->post('old_banner_image');
        }

		if(!empty($_FILES['centre_logo']['name']))
        {
            $this->load->library('upload');

            $filename = sha1(time().$_FILES['centre_logo']['name']);
            $config['upload_path'] = FCPATH.'/uploads/centre/logo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '409600';
            $config['file_name'] = $filename;
            $config['create_thumb'] = FALSE;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('centre_logo')) {
                $imageDetailArray = $this->upload->data();
                $centre_logo = $imageDetailArray['file_name'];
            }

            if (!empty($this->input->post('old_centre_logo'))) {
                $path = FCPATH.'uploads/centre/logo/' . $this->input->post('old_centre_logo');
                if (file_exists($path)) {
                    unlink($path);
                }
            }

        }
        else
        {
            $centre_logo = $this->input->post('old_centre_logo');
        }

		$tid = $this->input->post('tid');
		$day = $this->input->post('day');
		$start = $this->input->post('start_time');
		$close = $this->input->post('closing_time');
		$timing = array();

        $old_add = centre_info('centre_address', $cid)->centre_address;

        if($old_add!=$this->input->post('centre_address'))
        {
            $addr = urlencode($this->input->post('centre_address'));

            $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$addr."&key=AIzaSyB7MVcJaZu-shdyU_dZzAx1vl2zX_MYJ9k";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            $request = curl_exec($ch);
            curl_close($ch);

            $centregeo = json_decode($request);
            $clat = $centregeo->results[0]->geometry->location->lat;
            $clng = $centregeo->results[0]->geometry->location->lng;

            $data = array(
                "centre_name" => $this->input->post('centre_name'),
                "centre_bio" => $this->input->post('centre_bio'),
                "centre_address" => $this->input->post('centre_address'),
                "centre_province" => $this->input->post('centre_province'),
                "centre_city" => $this->input->post('centre_city'),
                "centre_email" => $this->input->post('centre_email'),
                "centre_phone" => $this->input->post('centre_phone'),
                "centre_fax" => $this->input->post('centre_fax'),
                "centre_banner" => $banner_image,
                "centre_logo" => $centre_logo,
                "centre_contact" => $this->input->post('centre_contact'),
                "centre_category" => json_encode($this->input->post('centre_category')),
                "centre_lat" => $clat,
                "centre_long" => $clng
            );

        }
        else
        {
            $data = array(
                "centre_name" => $this->input->post('centre_name'),
                "centre_bio" => $this->input->post('centre_bio'),
                "centre_address" => $this->input->post('centre_address'),
                "centre_province" => $this->input->post('centre_province'),
                "centre_city" => $this->input->post('centre_city'),
                "centre_email" => $this->input->post('centre_email'),
                "centre_phone" => $this->input->post('centre_phone'),
                "centre_fax" => $this->input->post('centre_fax'),
                "centre_banner" => $banner_image,
                "centre_logo" => $centre_logo,
                "centre_contact" => $this->input->post('centre_contact'),
                "centre_category" => json_encode($this->input->post('centre_category')),
            );
        }

		$id = $this->AdminModel->update_centre($data, $cid);
        if($id)
        {
			for($m=0; $m<count($day); $m++)
			{
				$timedata = array("day_name" => $day[$m], "start_time" => $start[$m], "closing_time" => $close[$m]);
				$conditions = array('id'=> $tid[$m], 'centre_id' => $cid);
				$this->AdminModel->update_timing($timedata, $conditions);
			}
            $this->session->set_flashdata('update', 'Centre updated successfully!');
            redirect('centres');
        }
        else
        {
            $this->session->set_flashdata('error', 'Centre not updated. Please try again!');
            redirect('centres');
        }
	}

	public function disable($uid)
    {
        $val = array("status" => '0');
        $id = $this->AdminModel->changecentrestatus($val, $uid);

        if($id)
        {
            $this->session->set_flashdata('success', 'Centre disabled successfully!');
            redirect('centres');
        }
        else
        {
            $this->session->set_flashdata('error', 'Centre not disabled. Please try again!');
            redirect('centres');
        }
    }


    public function enable($uid)
    {
        $val = array("status" => '1');
        $id = $this->AdminModel->changecentrestatus($val, $uid);

        if($id)
        {
            $this->session->set_flashdata('success', 'Centre enabled successfully!');
            redirect('centres');
        }
        else
        {
            $this->session->set_flashdata('error', 'Centre not enabled. Please try again!');
            redirect('centres');
        }
    }

    public function importFile()
    {
        require_once APPPATH . "/third_party/PHPExcel.php";

        // echo "<pre>";
		// print_r($_POST);
        // print_r($_FILES);
		// echo "</pre>";

        if($this->input->post('addcat'))
        {
            $this->load->library('upload');
            $filename = sha1(time().$_FILES['import_file']['name']);
            $config['upload_path'] = FCPATH.'/uploads/excelsample/';
            $config['allowed_types'] = 'xlsx|xls|csv';
            $config['remove_spaces'] = TRUE;
            
            $this->upload->initialize($config);            
        
            if(!$this->upload->do_upload('import_file'))
            {
                $error = array('error' => $this->upload->display_errors());
            } 
            else
            {
                $data = array('upload_data' => $this->upload->data());
            }
            if(empty($error))
            {
                if (!empty($data['upload_data']['file_name']))
                {
                    $import_xls_file = $data['upload_data']['file_name'];
                } 
                else
                {
                    $import_xls_file = 0;
                }
                $inputFileName = FCPATH.'/uploads/excelsample/'.$import_xls_file;
                try
                {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $flag = true;
                    $i=0;
                    foreach ($allDataInSheet as $value)
                    {
                        if($flag)
                        {
                            $flag =false;
                            continue;
                        }
                        $inserdata[$i]['centre_name'] = $value['A'];
                        $inserdata[$i]['centre_address'] = $value['B'];

                        $addr = urlencode($value['B']);

                        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$addr."&key=AIzaSyB7MVcJaZu-shdyU_dZzAx1vl2zX_MYJ9k";
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        $request = curl_exec($ch);
                        curl_close($ch);

                        $centregeo = json_decode($request);
                        $clat = $centregeo->results[0]->geometry->location->lat;
                        $clng = $centregeo->results[0]->geometry->location->lng;

                        $inserdata[$i]['centre_province'] = $value['C'];

                        $ccity = explode(',', $value['D']);

                        $rid = $this->AdminModel->get_region_id($ccity[0]);
                        
                        if(!empty($rid->RegionID))
                        {
                            $city_id = $rid->RegionID;
                        }
                        else
                        {
                            $data = array(
                                "RegionName" => $ccity[0],
                                "ProvinceID" => $value['C'],
                                "status" => '1'
                            );
                            $city_id = $this->AdminModel->save_city($data);
                        }

                        //echo $city_id."<br>"; 
                        $inserdata[$i]['centre_city'] = $city_id;

                        $inserdata[$i]['centre_email'] = $value['E'];
                        $inserdata[$i]['centre_phone'] = $value['F'];
                        $inserdata[$i]['centre_fax'] = $value['G'];
                        $inserdata[$i]['centre_contact'] = $value['H'];
                        $inserdata[$i]['status'] = $value['I'];
                        $inserdata[$i]['centre_bio'] = $value['X'];
                        $inserdata[$i]['centre_lat'] = $clat;
                        $inserdata[$i]['centre_long'] = $clng;
                        $inserdata[$i]['status'] = '1';

                        $id = $this->AdminModel->save_centre($inserdata[$i]);
                        if($id)
                        {
                            $timedata1 = array("centre_id" => $id, "day_name" => 'Monday', "start_time" => $value['J'], "closing_time" => $value['K']);
                            $this->AdminModel->save_timing($timedata1);

                            $timedata2 = array("centre_id" => $id, "day_name" => 'Tuesday', "start_time" => $value['L'], "closing_time" => $value['M']);
                            $this->AdminModel->save_timing($timedata2);

                            $timedata3 = array("centre_id" => $id, "day_name" => 'Wednesday', "start_time" => $value['N'], "closing_time" => $value['O']);
                            $this->AdminModel->save_timing($timedata3);

                            $timedata4 = array("centre_id" => $id, "day_name" => 'Thursday', "start_time" => $value['P'], "closing_time" => $value['Q']);
                            $this->AdminModel->save_timing($timedata4);

                            $timedata5 = array("centre_id" => $id, "day_name" => 'Friday', "start_time" => $value['R'], "closing_time" => $value['S']);
                            $this->AdminModel->save_timing($timedata5);

                            $timedata6 = array("centre_id" => $id, "day_name" => 'Saturday', "start_time" => $value['T'], "closing_time" => $value['U']);
                            $this->AdminModel->save_timing($timedata6);

                            $timedata7 = array("centre_id" => $id, "day_name" => 'Sunday', "start_time" => $value['V'], "closing_time" => $value['W']);
                            $this->AdminModel->save_timing($timedata7);
                        }
                        $i++;
                    }       
                    $this->session->set_flashdata('success', 'Centre imported successfully!');
                    redirect('centres');
                } 
                catch (Exception $e)
                {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' .$e->getMessage());
                }
            }
            else
            {
                echo $error['error'];
            }
        }
    }

    public function restrict_columna()
    {
        $cid = $this->input->post('centreid');
        $rdata = $this->AdminModel->restrict_column_a_status($cid);
        if($rdata->column_a==0)
        {
            $data = array("column_a" => '1');
            $this->AdminModel->change_restriction_a($data, $cid);
            echo "Centre Column A Restricted successfully";
        }
        if($rdata->column_a==1)
        {
            $data = array("column_a" => '0');
            $this->AdminModel->change_restriction_a($data, $cid);
            echo "Centre Column A Unrestricted successfully";
        }
    }

    public function restrict_columnb()
    {
        $cid = $this->input->post('centreid');
        $rdata = $this->AdminModel->restrict_column_b_status($cid);
        if($rdata->column_b==0)
        {
            $data = array("column_b" => '1');
            $this->AdminModel->change_restriction_b($data, $cid);
            echo "Centre Column B Restricted successfully";
        }
        if($rdata->column_b==1)
        {
            $data = array("column_b" => '0');
            $this->AdminModel->change_restriction_b($data, $cid);
            echo "Centre Column B Unrestricted successfully";
        }
    }

}
