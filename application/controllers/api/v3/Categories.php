<?php
header('Access-Control-Allow-Origin: *');

require APPPATH . 'libraries/REST_Controller.php';

class Categories extends REST_Controller  {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

	public function index_post()
	{
        $lang = $this->input->post('lang');
        
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
               
        $this->db->select("id, cat_image, cat_name_".$lang.", cat_desc_".$lang.", added_on, updated_on, status");
        $category = $this->db->get_where("snr_category", ['status' => '1'])->result();

        $cname= "cat_name_".$lang;
        $cdesc= "cat_desc_".$lang;

        $ctg = array();
        foreach($category as $catdata)
        {
            $narr = array(
                "id" => $catdata->id,
                "cat_image"=> base_url().'uploads/categories/'.$catdata->cat_image,
                "cat_name_en"=> $catdata->$cname,
                "cat_desc_en"=> $catdata->$cdesc,
                "added_on"=> $catdata->added_on,
                "updated_on"=> $catdata->updated_on,
                "status"=> $catdata->status
            );
            array_push($ctg, $narr);
        }
        $data['category']['data']['category_data'] = $ctg;
        // $i=0;
        // foreach($category as $cat)
        // {
        //     $data['category']['data']['category_data'][$i]->cat_image = base_url().'uploads/categories/'.$cat->cat_image;
        //     $i++;
        // }

        $main_arr['info']['description']='Category Details';
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
        $main_arr['paths']['api/v1/categories/$lang']['POST']['summary']='Get list of all the categories';
        $main_arr['paths']['api/v1/categories/$lang']['POST']['description']='All the active Categories';
        $main_arr['paths']['api/v1/categories/$lang']['POST']['parameters']='';
        if(!empty($data))
        {
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $data;

            $log_array = array(
                "api_name" => "All categories",
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
                $main_arr['info']['response']['data']='No categories Found.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data']='Azikho izigaba ezitholakele.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data']='Ha ho mekhahlelo e Fumanweng.';
            }
            //$main_arr['info']['response']['data'] = 'No categories Found';

            $log_array = array(
                "api_name" => "All categories",
                "api_method" => "POST",
                "api_data" => json_encode($_POST),
                "api_lang" => $lang,
                "api_status" => 0,
                "ip_addr" => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('snr_api_call_log', $log_array);
        }
        
        //$this->db->insert('snr_api_call_log', $log_array);

        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function sublist_post()
	{
        $lang = $this->input->post('lang');

        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
        
        $cat_id = $this->input->post('cat_id');

//         SELECT * FROM `snr_subcategory` 
// JOIN `snr_topics` ON snr_topics.subcategory=snr_subcategory.id
// WHERE `cat_id`='1'


        $this->db->select("snr_subcategory.*");
        $this->db->from('snr_subcategory');
        $this->db->join('snr_topics', 'snr_topics.subcategory=snr_subcategory.id');
        $this->db->where('snr_subcategory.cat_id', $cat_id);
        $this->db->where('snr_subcategory.status', '1');
        $subdata = $this->db->get()->result();
        
        $cname= "subcat_name_".$lang;

        $ctg = array();
        foreach($subdata as $catdata)
        {
            $narr = array(
                "id" => $catdata->id,
                "cat_id"=> $catdata->cat_id,
                "subcat_name_en"=> $catdata->$cname,
                "added_on"=> $catdata->added_on,
                "updated_on"=> $catdata->updated_on,
                "status"=> $catdata->status
            );
            array_push($ctg, $narr);
        }
        $data['subcategory'] = $ctg;        

        $main_arr['info']['description']='Category and Subcategory Details';
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
        $main_arr['paths']['api/v1/categories/sublist/$lang']['POST']['summary']='Get list of all the subcategories based on category ID';
        $main_arr['paths']['api/v1/categories/sublist/$lang']['POST']['description']='All the active subCategories of a category';
        $main_arr['paths']['api/v1/categories/sublist/$lang']['POST']['parameters']='cat_id=2, lang=en';
        if(!empty($data))
        {
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $data;

            $log_array = array(
                "api_name" => "Subcat List",
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
                $main_arr['info']['response']['data']='No categories Found.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data']='Azikho izigaba ezitholakele.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data']='Ha ho mekhahlelo e Fumanweng.';
            }
            //$main_arr['info']['response']['data'] = 'No categories Found';

            $log_array = array(
                "api_name" => "Subcat List",
                "api_method" => "POST",
                "api_data" => json_encode($_POST),
                "api_lang" => $lang,
                "api_status" => 0,
                "ip_addr" => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('snr_api_call_log', $log_array);
        }
        
        //$this->db->insert('snr_api_call_log', $log_array);

        $this->response($main_arr, REST_Controller::HTTP_OK);
	}
}
