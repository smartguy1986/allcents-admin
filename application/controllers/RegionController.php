<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class RegionController extends CI_Controller {

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
		$data['province'] = $this->AdminModel->get_province_info();
		$this->load->view('admin/region/regionlist', $data);
	}

    public function addregion()
	{
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        $data = array(
            "ProvinceName" => $this->input->post('provincename'),
            "status" => '1'
        );
        $id = $this->AdminModel->save_region($data);
        if($id)
        {
            $not = array("not_type" => "A", "not_section" => "Province Added", "not_msg" => "<strong>".$this->input->post('provincename')."</strong> added as new entry", "not_status" => "0");
            $this->AdminModel->save_notification($not);

            $this->session->set_flashdata('success', 'Region added successfully!');
            redirect('region', $status);
        }
        else
        {
            $this->session->set_flashdata('error', 'Region not added. Please try again!');
            redirect('region', $status);
        }
	}

    public function getregiondetails()
    {
        $rid = $this->input->post('rid');
        $conditions = array('ProvinceID'=>$rid);
        $regiondetails = $this->AdminModel->get_province($conditions);
        // echo "<pre>";
        // print_r($regiondetails);
        // echo "</pre>";
        echo "<form class='row g-3' method='post' action='".base_url('region/update')."'>
                    <div class='col-md-6'>
                        <input type='hidden' name='rid' value='".$regiondetails->ProvinceID."'>
                        <label for='provincename' class='form-label'>Province Name</label>
                        <input type='text' class='form-control text-r' id=provincename' name='provincename' value='".$regiondetails->ProvinceName."' required>
                    </div>                    
                    <div class='col-12'>
                        <input type='submit' class='btn btn-primary px-5' value='Update' name='addregion'>
                    </div>
                </form>";
    }

    public function updateregion()
	{
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        $data = array(
            "ProvinceName" => $this->input->post('provincename')
        );
        $id = $this->AdminModel->update_region($data, $this->input->post('rid'));
        if($id)
        {
            $not = array("not_type" => "E", "not_section" => "Province Updated", "not_msg" => "<strong>".$this->input->post('provincename')."</strong> name was updated", "not_status" => "0");
            $this->AdminModel->save_notification($not);
            $this->session->set_flashdata('update', 'Region added successfully!');
            redirect('region', $status);
        }
        else
        {
            $this->session->set_flashdata('error', 'Region not added. Please try again!');
            redirect('region', $status);
        }
	}

    public function cities()
	{
		$data['cities'] = $this->AdminModel->get_cities();
		$this->load->view('admin/region/citylist', $data);
	}

    public function addcity()
	{
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        $data = array(
            "RegionName" => $this->input->post('cityname'),
            "ProvinceID" => $this->input->post('cityregion'),
            "status" => '1'
        );
        $id = $this->AdminModel->save_city($data);
        if($id)
        {
            $not = array("not_type" => "A", "not_section" => "City Add", "not_msg" => "<strong>".$this->input->post('cityname')."</strong> added as new entry", "not_status" => "0");
            $this->AdminModel->save_notification($not);
            $this->session->set_flashdata('success', 'City added successfully!');
            redirect('region/cities', $status);
        }
        else
        {
            $this->session->set_flashdata('error', 'City not added. Please try again!');
            redirect('region/cities', $status);
        }
	}

    public function getcitydetails()
    {
        $rid = $this->input->post('rid');
        $cid = $this->input->post('cid');
        $conditions = array('RegionID'=>$cid);
        $citydetails = $this->AdminModel->get_city($conditions);
        $province_list = get_province_list();
        // echo "<pre>";
        // print_r($citydetails);
        // echo "</pre>";
        $returndata = "<form class='row g-3' method='post' action='".base_url('region/updatecity')."'>
                    <div class='col-md-6'>
                        <input type='hidden' name='cid' value='".$citydetails->RegionID."'>
                        <label for='cityname' class='form-label'>City Name</label>
                        <input type='text' class='form-control text-r' id='cityname' name='cityname' value='".$citydetails->RegionName."' required>
                    </div>  
                    <div class='col-md-6'>
                        <label for='regionname' class='form-label'>Province</label>
                        <select class='form-control text-dr' name='regionname' required>";                              
                        foreach($province_list as $province)
                        {
                            if($province->ProvinceID==$rid)
                            {
                                $returndata .= "<option value='".$province->ProvinceID."' selected>".$province->ProvinceName."</option>";
                            }
                            else
                            {
                                $returndata .= "<option value='".$province->ProvinceID."'>".$province->ProvinceName."</option>";
                            }
                        }

        $returndata .= "</select>
                    </div>                   
                    <div class='col-12'>
                        <input type='submit' class='btn btn-primary px-5' value='Update' name='addregion'>
                    </div>
                </form>";

        echo $returndata;
    }

    public function updatecity()
	{
        $data = array(
            "ProvinceID" => $this->input->post('regionname'),
            "RegionName" => $this->input->post('cityname')
        );
        $id = $this->AdminModel->update_city($data, $this->input->post('cid'));
        if($id)
        {
            $not = array("not_type" => "E", "not_section" => "City Update", "not_msg" => "<strong>".$this->input->post('cityname')."</strong> details was updated", "not_status" => "0");
            $this->AdminModel->save_notification($not);
            $this->session->set_flashdata('update', 'City updated successfully!');
            redirect('region/cities', $status);
        }
        else
        {
            $this->session->set_flashdata('error', 'City not updated. Please try again!');
            redirect('region/cities', $status);
        }
	}

    public function disableprovince($uid)
    {
        $val = array("status" => '0');
        $id = $this->AdminModel->changeprovincestatus($val, $uid);

        if($id)
        {
            $provincename = get_province_name($uid);
            $not = array("not_type" => "O", "not_section" => "Province Disabled", "not_msg" => "<strong>".$provincename->ProvinceName."</strong> has been disabled", "not_status" => "0");
            $this->AdminModel->save_notification($not);
            $this->session->set_flashdata('success', 'Region disabled successfully!');
            redirect('region');
        }
        else
        {
            $this->session->set_flashdata('error', 'Region not disabled. Please try again!');
            redirect('region');
        }
    }


    public function enableprovince($uid)
    {
        $val = array("status" => '1');
        $id = $this->AdminModel->changeprovincestatus($val, $uid);

        if($id)
        {
            $provincename = get_province_name($uid);
            $not = array("not_type" => "O", "not_section" => "Province Enabled", "not_msg" => "<strong>".$provincename->ProvinceName."</strong> has been disabled", "not_status" => "0");
            $this->AdminModel->save_notification($not);
            $this->session->set_flashdata('success', 'Region enabled successfully!');
            redirect('region');
        }
        else
        {
            $this->session->set_flashdata('error', 'Region not enabled. Please try again!');
            redirect('region');
        }
    }

    public function disablecity($uid)
    {
        $val = array("status" => '0');
        $id = $this->AdminModel->changecitystatus($val, $uid);

        if($id)
        {
            $city_name = city_name($uid);
            $not = array("not_type" => "O", "not_section" => "City Disabled", "not_msg" => "<strong>".$city_name->RegionName."</strong> has been disabled", "not_status" => "0");
            $this->AdminModel->save_notification($not);
            $this->session->set_flashdata('success', 'City disabled successfully!');
            redirect('region/cities');
        }
        else
        {
            $this->session->set_flashdata('error', 'City not disabled. Please try again!');
            redirect('region/cities');
        }
    }


    public function enablecity($uid)
    {
        $val = array("status" => '1');
        $id = $this->AdminModel->changecitystatus($val, $uid);

        if($id)
        {
            $city_name = city_name($uid);
            $not = array("not_type" => "O", "not_section" => "City Enabled", "not_msg" => "<strong>".$city_name->RegionName."</strong> has been enabled", "not_status" => "0");
            $this->AdminModel->save_notification($not);
            $this->session->set_flashdata('success', 'City enabled successfully!');
            redirect('region/cities');
        }
        else
        {
            $this->session->set_flashdata('error', 'City not enabled. Please try again!');
            redirect('region/cities');
        }
    }

    public function restrict_region()
    {
        $pid = $this->input->post('provinceid');
        $rdata = $this->AdminModel->getregionrestrictstatus($pid);
        if($rdata->geo_restriction==0)
        {
            $not = array("not_type" => "O", "not_section" => "Province Geo-Restricted", "not_msg" => "", "not_status" => "0");
            $this->AdminModel->save_notification($not);
            $data = array("geo_restriction" => '1');
            $this->AdminModel->change_restriction($data, $pid);
            echo "Region Restricted successfully";
        }
        if($rdata->geo_restriction==1)
        {
            $not = array("not_type" => "O", "not_section" => "Province Geo-Restricted Lifted", "not_msg" => "", "not_status" => "0");
            $this->AdminModel->save_notification($not);
            $data = array("geo_restriction" => '0');
            $this->AdminModel->change_restriction($data, $pid);
            echo "Region Unrestricted successfully";
        }
    }
    
}
