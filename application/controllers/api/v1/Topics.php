<?php
header('Access-Control-Allow-Origin: *');

require APPPATH . 'libraries/REST_Controller.php';

class Topics extends REST_Controller  {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

	public function index_post()
	{
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
               
        $lang = $this->input->post('lang');
        $this->db->select("*");
        $this->db->order_by("featured", "DESC");
        $data = $this->db->get_where("snr_topics", ['status' => '1'])->result();

        $main_arr['info']['description']='All Topics List';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/topics/']['POST']['summary']='Get list of all the topics';
        $main_arr['paths']['api/v1/topics/']['POST']['description']='All the active topics list';
        $main_arr['paths']['api/v1/topics/']['POST']['parameters']='';
        if(!empty($data))
        {
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $data;

            $log_array = array(
                "api_name" => "All Topics",
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
                $main_arr['info']['response']['data'] = 'No topics Found.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'Azikho izihloko ezitholakele.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Ha ho lihlooho tse fumanoeng.';
            }     
            // $main_arr['info']['response']['data'] = 'No topics Found';

            $log_array = array(
                "api_name" => "All Topics",
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

    
    public function bysubcategory_post()
	{
        $lang = $this->input->post('lang');
        $sid = $this->input->post('sid');

        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';

        $this->db->select("*");
        $this->db->order_by("featured", "DESC");
        $this->db->where("subcategory", $sid);
        $data = $this->db->get_where("snr_topics", ['status' => '1'])->result();

        $newdata = array();
        $i=0;
        foreach($data as $datadata)
        {
            if($lang=='en')
            {
                $newdata[$i] = array(
                    "id" => $datadata->id, 
                    "title_en" => "<strong>".$datadata->title_en."</strong>", 
                    "slug_en" => $datadata->title_en, 
                    "topic_content_en" => substr(strip_tags($datadata->topic_content_en),0,100).'...',  
                );           
            }
            if($lang=='zu')
            {
                $newdata[$i] = array(
                    "id" => $datadata->id, 
                    "title_en" => $datadata->title_zu, 
                    "slug_en" => $datadata->title_zu, 
                    "topic_content_en" => substr(strip_tags($datadata->topic_content_zu),0,100).'...', 
                );           
            }
            if($lang=='st')
            {
                $newdata[$i] = array(
                    "id" => $datadata->id, 
                    "title_en" => $datadata->title_st, 
                    "slug_en" => $datadata->title_st, 
                    "topic_content_en" => substr(strip_tags($datadata->topic_content_st),0,100).'...'
                );           
            }
            $i++;
        }

        $main_arr['info']['description']='All Topics List by subcategory';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/topics/bycategory/(:num)']['POST']['summary']='Get list of all the topics by subcategory';
        $main_arr['paths']['api/v1/topics/bycategory/(:num)']['POST']['description']='All the active topics list belongs to a partcular subcategory';
        $main_arr['paths']['api/v1/topics/bycategory/(:num)']['POST']['parameters']='sid';
        if(!empty($data))
        {
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $newdata;

            $log_array = array(
                "api_name" => "All Topics by Subcat",
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
                $main_arr['info']['response']['data'] = 'No topics Found.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'Azikho izihloko ezitholakele.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Ha ho lihlooho tse fumanoeng.';
            }     
            //$main_arr['info']['response']['data'] = 'No topics Found';

            $log_array = array(
                "api_name" => "All Topics by subcat",
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

    public function byid_post()
	{
        $topic_id = $this->input->post('tid');
        $lang = $this->input->post('lang');

        // $this->db->where('id', $topic_id);
        // $this->db->set('topic_view', 'topic_view+1', FALSE);
        // $this->db->update('snr_topics');
        /* =================================== */
        $yr = date("Y");
        $mn = date("m");
        $this->db->select('*');
        $this->db->where(array("topic_id"=> $topic_id, "year"=>$yr, "month"=>$mn));
        $ctr = $this->db->get('snr_article_tracker')->result();
        if(count($ctr)>0)
        {
            $this->db->where(array('topic_id'=>$topic_id, "year"=>$yr, "month"=>$mn));
            $this->db->set('views', 'views+1', FALSE);
            $this->db->update('snr_article_tracker');
        }
        else
        {
            $val = array("topic_id"=>$topic_id, "year"=>$yr, "month"=>$mn,"views"=>1);
            $this->db->insert('snr_article_tracker',$val);
        }        
        /* =================================== */


        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';

        $newdata = array();

        if($lang=='en')
        {
            $this->db->select("*");
            $this->db->order_by("featured", "DESC");
            $this->db->where("id", $topic_id);
            $data = $this->db->get_where("snr_topics", ['status' => '1'])->result();
            $newdata = array(
                "id"=> $data[0]->id,
                "title_en"=> $data[0]->title_en,
                "slug_en"=> $data[0]->slug_en,
                "topic_content_en"=> $data[0]->topic_content_en,
                "category"=> $data[0]->category,
                "subcategory"=> $data[0]->subcategory,
                "topic_author"=> $data[0]->topic_author,
                "topic_view"=> $data[0]->topic_view,
                "topic_share"=> $data[0]->topic_share,
                "added_on"=> $data[0]->added_on,
                "updated_on"=> $data[0]->updated_on,
                "featured"=> $data[0]->featured,
                "status"=> $data[0]->status,
            );
        }
        if($lang=='zu')
        {
            $this->db->select("*");
            $this->db->order_by("featured", "DESC");
            $this->db->where("id", $topic_id);
            $data = $this->db->get_where("snr_topics", ['status' => '1'])->result();
            $newdata = array(
                "id"=> $data[0]->id,
                "title_en"=> $data[0]->title_zu,
                "slug_en"=> $data[0]->slug_zu,
                "topic_content_en"=> $data[0]->topic_content_zu,
                "category"=> $data[0]->category,
                "subcategory"=> $data[0]->subcategory,
                "topic_author"=> $data[0]->topic_author,
                "topic_view"=> $data[0]->topic_view,
                "topic_share"=> $data[0]->topic_share,
                "added_on"=> $data[0]->added_on,
                "updated_on"=> $data[0]->updated_on,
                "featured"=> $data[0]->featured,
                "status"=> $data[0]->status,
            );
        }
        if($lang=='st')
        {
            $this->db->select("*");
            $this->db->order_by("featured", "DESC");
            $this->db->where("id", $topic_id);
            $data = $this->db->get_where("snr_topics", ['status' => '1'])->result();
            $newdata = array(
                "id"=> $data[0]->id,
                "title_en"=> $data[0]->title_st,
                "slug_en"=> $data[0]->slug_st,
                "topic_content_en"=> $data[0]->topic_content_st,
                "category"=> $data[0]->category,
                "subcategory"=> $data[0]->subcategory,
                "topic_author"=> $data[0]->topic_author,
                "topic_view"=> $data[0]->topic_view,
                "topic_share"=> $data[0]->topic_share,
                "added_on"=> $data[0]->added_on,
                "updated_on"=> $data[0]->updated_on,
                "featured"=> $data[0]->featured,
                "status"=> $data[0]->status,
            );
        }

        // $this->db->select("*");
        // $this->db->order_by("featured", "DESC");
        // $this->db->where("id", $topic_id);
        // $data = $this->db->get_where("snr_topics", ['status' => '1'])->result();

        $main_arr['info']['description']='Topics by id';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/topics/byid/(:num)']['POST']['summary']='Get topics by id';
        $main_arr['paths']['api/v1/topics/byid/(:num)']['POST']['description']='Details of topics belongs to a partcular id';
        $main_arr['paths']['api/v1/topics/byid/(:num)']['POST']['parameters']='tid';
        if(!empty($newdata))
        {
            $datadata = array();
            //echo $data[0]->id;
            updatetopicview($newdata['id']);
            $this->db->select('*');
            $this->db->where('id<>',$newdata['id']);
            $this->db->where('status','1');
            $this->db->order_by('id','RANDOM');
            $this->db->limit(2);
            $qqrryy = $this->db->get('snr_topics');
            $related_topics = $qqrryy->result();

            if($lang=='en')
            {
                $rltp = array();
                $c=0;
                foreach($related_topics as $rlt)
                {
                    $rltp[$c]['id']=$rlt->id;
                    $rltp[$c]['cat_name_en']=$rlt->title_en;
                    $c++;
                }
            }
            if($lang=='zu')
            {
                $rltp = array();
                $c=0;
                foreach($related_topics as $rlt)
                {
                    $rltp[$c]['id']=$rlt->id;
                    $rltp[$c]['cat_name_en']=$rlt->title_zu;
                    $c++;
                }
            }
            if($lang=='st')
            {
                $rltp = array();
                $c=0;
                foreach($related_topics as $rlt)
                {
                    $rltp[$c]['id']=$rlt->id;
                    $rltp[$c]['cat_name_en']=$rlt->title_st;
                    $c++;
                }
            }

            // echo "<pre>";
            // print_r($related_topics);
            // echo "</pre>";
            $newdata['related_topics']=$rltp;
            array_push($datadata, $newdata);
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $datadata;

            $log_array = array(
                "api_name" => "Topic Details",
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
                $main_arr['info']['response']['data'] = 'No topics Found.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'Azikho izihloko ezitholakele.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Ha ho lihlooho tse fumanoeng.';
            }     
            //$main_arr['info']['response']['data'] = 'No topics Found';

            $log_array = array(
                "api_name" => "Topic Details",
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
