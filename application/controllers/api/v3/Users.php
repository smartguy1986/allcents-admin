<?php
header('Access-Control-Allow-Origin: *');
require APPPATH . 'libraries/REST_Controller.php';
class Users extends REST_Controller  {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	
    public function index_post()
	{
        $lang = $this->input->post('lang');
        $uid = $this->input->post('uid');

        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
               
        if(!empty($uid)){
            $this->db->select("id,userfname,userlname,usermail,userphone,usergender_new AS usergender,userdob,useraddress,usercity,userzip,userimage,userstatus,userregistered,last_updated,usertoken,social_login,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
            $data = $this->db->get_where("snr_users", ['id' => $uid, 'userrole' => '3', 'userstatus' => '1', 'userdeleted' => '0'])->row_array();

            $now = date('Y-m-d H:i:s');
            $this->db->select("COUNT(id) as tot");
            $total_booking = $this->db->get_where("snr_booking", ['user_id' => $uid])->result();
            $data['total_booking'] = $total_booking[0]->tot;
            
            $this->db->select("COUNT(schedule_date) as tot");
            $upcoming_booking = $this->db->get_where("snr_booking", ['user_id' => $uid, 'schedule_date<' => $now])->result();
            $data['upcoming_booking'] = $upcoming_booking[0]->tot;

            // if($data['usergender']=='M')
            // {
            //     $data['userimage']=base_url().'/uploads/avatar/male-avatar-new2.jpg';
            // }
            // else if($data['usergender']=='F')
            // {
            //     $data['userimage']=base_url().'/uploads/avatar/female-avatar-new2.jpg';
            // }
            // else
            // {
            $data['userimage']=base_url().'/uploads/avatar/avatar2.jpg';
            // }

            $main_arr['info']['description']='User Details for Particular ID';
            $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
            $main_arr['info']['method']='POST';
            $main_arr['paths']['api/v1/users/(:num)']['POST']['summary']='Get details of a particular user';
            $main_arr['paths']['api/v1/users/(:num)']['POST']['description']='All the data of a particular user will be fetched based on the given id';
            $main_arr['paths']['api/v1/users/(:num)']['POST']['parameters']='';
            if(!empty($data))
            {
                $this->db->select("COUNT(id) as tot");
                $period = $this->db->get_where("snr_period", ['user_id' => $uid])->result();
                if($period[0]->tot > 0)
                {
                    $data['is_perioddata']='1';
                }
                else
                {
                    $data['is_perioddata']='0';
                }

                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['data'] = $data;

            }
            else{
                $main_arr['info']['response']['status'] = '0';
                if($lang=='en')
                {
                    $main_arr['info']['response']['data'] = 'No App user found with this id';
                }
                if($lang=='zu')
                {
                    $main_arr['info']['response']['data'] = 'Akekho umsebenzisi wohlelo lokusebenza otholakele nale id';
                }
                if($lang=='st')
                {
                    $main_arr['info']['response']['data'] = 'Ha ho mosebelisi oa App ea fumanoeng ka id ena';
                }     
            }
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function login_post()
	{
        $lang = $this->input->post('lang');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $deviceid = $this->input->post('deviceid');
        $devicetype = $this->input->post('devicetype');
        
        $log_array = array(
            "api_name" => "User Login",
            "api_method" => "POST",
            "api_lang" => '',
            "api_status" => 0,
            "ip_addr" => $_SERVER['REMOTE_ADDR']
        );
        $this->db->insert('snr_api_call_log', $log_array);

        $hashedpass = MD5($password);
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
               
        $this->db->select("id,userrole,userfname,userlname,usermail,userphone,usergender_new AS usergender,userdob,useraddress,usercity,userzip,userimage,userstatus,user_verified,userregistered,last_updated,usertoken,social_login,deviceid,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
        $data = $this->db->get_where("snr_users", ['usermail' => $username, 'userpassword' => $hashedpass])->result();

        $main_arr['info']['description']='User Login via email and password';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/users/login']['POST']['summary']='User Login';
        $main_arr['paths']['api/v1/users/login']['POST']['description']='User login and all details via email and password';
        $main_arr['paths']['api/v1/users/login']['POST']['parameters']='username (email), password (user registered password)';
        if(!empty($data))
        {
            // if($data[0]->usergender=='M')
            // {
            //     $data[0]->userimage=base_url().'/uploads/avatar/male-avatar-new2.jpg';
            // }
            // else if($data[0]->usergender=='F')
            // {
            //     $data[0]->userimage=base_url().'/uploads/avatar/female-avatar-new2.jpg';
            // }
            // else
            // {
                $data[0]->userimage=base_url().'/uploads/avatar/avatar2.jpg';
            // }

            $uid = $data[0]->id;
            $now = date('Y-m-d H:i:s');
            $this->db->select("COUNT(id) as tot");
            $total_booking = $this->db->get_where("snr_booking", ['user_id' => $uid])->result();
            $data[0]->total_booking = $total_booking[0]->tot;
            
            $this->db->select("COUNT(schedule_date) as tot");
            $upcoming_booking = $this->db->get_where("snr_booking", ['user_id' => $uid, 'schedule_date<' => $now])->result();
            $data[0]->upcoming_booking = $upcoming_booking[0]->tot;

            // --------------------
            if($deviceid)
            {
                $vallue = array("deviceid" => $deviceid, "devicetype" => $devicetype);
                $this->db->where('id',$data[0]->id);
                $this->db->update('snr_users', $vallue);
            }
            // --------------------

            if($data[0]->userstatus==0 || $data[0]->user_verified==0)
            {
                $main_arr['info']['response']['status'] = '0';
                if($lang=='en')
                {
                    $main_arr['info']['response']['data'] = 'Please activate your account. Check your mail for the link.';
                    $main_arr['info']['response']['message'] = 'Please activate your account. Check your mail for the link.';
                }
                if($lang=='zu')
                {
                    $main_arr['info']['response']['data'] = 'Sicela wenze i-akhawunti yakho isebenze. Bheka imeyili yakho ukuthola isixhumanisi.';
                    $main_arr['info']['response']['message'] = 'Sicela wenze i-akhawunti yakho isebenze. Bheka imeyili yakho ukuthola isixhumanisi.';
                }
                if($lang=='st')
                {
                    $main_arr['info']['response']['data'] = 'Ka kopo kenya ak\'haonte ea hau. Lekola mangolo a hau bakeng sa sehokela.';
                    $main_arr['info']['response']['message'] = 'Ka kopo kenya ak\'haonte ea hau. Lekola mangolo a hau bakeng sa sehokela.';
                }     
                //$main_arr['info']['response']['data'] = 'Please activate your account. Check your mail for the link.';

                $log_array = array(
                    "api_name" => "User Login",
                    "api_method" => "POST",
                    "api_lang" => '',
                    "api_status" => 0,
                    "api_response" => json_encode($main_arr),
                    "ip_addr" => $_SERVER['REMOTE_ADDR']
                );
                $this->db->insert('snr_api_call_log', $log_array);
            }
            else if($data[0]->userrole!=3)
            {
                $main_arr['info']['response']['status'] = '0';
                if($lang=='en')
                {
                    $main_arr['info']['response']['data'] = 'Only user can access the app.';
                    $main_arr['info']['response']['message'] = 'Only user can access the app.';
                }
                if($lang=='zu')
                {
                    $main_arr['info']['response']['data'] = 'Umsebenzisi kuphela ongafinyelela kuhlelo lokusebenza.';
                    $main_arr['info']['response']['message'] = 'Umsebenzisi kuphela ongafinyelela kuhlelo lokusebenza.';
                }
                if($lang=='st')
                {
                    $main_arr['info']['response']['data'] = 'Ke mosebelisi feela ea ka fihlelang sesebelisoa.';
                    $main_arr['info']['response']['message'] = 'Ke mosebelisi feela ea ka fihlelang sesebelisoa.';
                }     
                //$main_arr['info']['response']['data'] = 'Only user can access the app.';

                $log_array = array(
                    "api_name" => "User Login",
                    "api_method" => "POST",
                    "api_lang" => '',
                    "api_status" => 0,
                    "api_response" => json_encode($main_arr),
                    "ip_addr" => $_SERVER['REMOTE_ADDR']
                );
                $this->db->insert('snr_api_call_log', $log_array);
            }
            else
            {
                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['data'] = $data;
                if($lang=='en')
                {
                    $main_arr['info']['response']['message'] = 'You have logged in successfully..';
                    $not_msg = "You have successfully logged in. Please explore Sentebale.";
                }
                if($lang=='zu')
                {
                    $main_arr['info']['response']['message'] = 'Ungene ngempumelelo.';
                    $not_msg = "Ungene ngempumelelo. Sicela uhlole i-Sentebale.";
                }
                if($lang=='st')
                {
                    $main_arr['info']['response']['message'] = 'U kene ka katleho.';
                    $not_msg = "U kene ka katleho. Ke kopa u hlahlobe Sentebale.";
                }     
                
                $log_array = array(
                    "api_name" => "User Login",
                    "api_method" => "POST",
                    "api_data" => json_encode($_POST),
                    "api_lang" => $lang,
                    "api_status" => 1,
                    "api_response" => json_encode($main_arr),
                    "ip_addr" => $_SERVER['REMOTE_ADDR']
                );
                $this->db->insert('snr_api_call_log', $log_array);

                if($deviceid)
                {
                    $val = array("not_type"=> "Notification", "not_title" => "Hello ".$data[0]->userfname, "not_msg" => $not_msg, "not_uid" => $deviceid); 
                    $this->db->insert('snr_notifications', $val);
                    $not_id = $this->db->insert_id();
                    
                    //$dtype = get_device_type($data[0]->deviceid);
                    // $dtype->devicetype
                    send_push($deviceid, "Hello ".$data[0]->userfname, $not_msg, "individual", $not_id, $devicetype);
                }
            }
        }
        else{
            $main_arr['info']['response']['status'] = '0';
            if($lang=='en')
            {
                $main_arr['info']['response']['message'] = 'No Data Found. Please check Email and Password Again.';
                $main_arr['info']['response']['data'] = 'No Data Found. Please check Email and Password Again.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['message'] = 'Ayikho Idatha Etholiwe. Sicela uhlole I-imeyili Nephasiwedi Futhi.';
                $main_arr['info']['response']['data'] = 'Ayikho Idatha Etholiwe. Sicela uhlole I-imeyili Nephasiwedi Futhi.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['message'] = 'Ha ho Lintlha Tse Fumanehileng. Ka kopo sheba Email le Password hape.';
                $main_arr['info']['response']['data'] = 'Ha ho Lintlha Tse Fumanehileng. Ka kopo sheba Email le Password hape.';
            }     
            //$main_arr['info']['response']['data'] = 'No Data Found. Please check Username and Password Again';

            $log_array = array(
                "api_name" => "User Login",
                "api_method" => "POST",
                "api_data" => json_encode($_POST),
                "api_lang" => $lang,
                "api_status" => 0,
                "api_response" => json_encode($main_arr),
                "ip_addr" => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('snr_api_call_log', $log_array);
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function create_post()
	{
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // die();

        $fullname = $this->input->post('fullname');
        $usermail = strtolower(trim($this->input->post('usermail')));
        $devicetype = $this->input->post('devicetype');
        
        $lang = $this->input->post('lang');

        if(empty($usermail) || empty($fullname))
        {
            $main_arr['info']['description']='User registration via email and password';
            $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
            $main_arr['info']['method']='POST';
            $main_arr['paths']['api/v1/users/create']['POST']['summary']='User Registration';
            $main_arr['paths']['api/v1/users/create']['POST']['description']='User registration from app';
            $main_arr['paths']['api/v1/users/create']['POST']['parameters']='fullname, usermail, userpassword, location';

            $main_arr['info']['response']['status'] = '0';
            if($lang=='en')
            {
                $main_arr['info']['response']['data'] = 'User Not Registered.';
                $main_arr['info']['response']['message'] = 'Registration unsuccessful. Either name or email is empty.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'Umsebenzisi Akabhalisiwe.';
                $main_arr['info']['response']['message'] = 'Ukubhalisa akuphumelelanga. Igama noma i-imeyili ayinalutho.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Mosebelisi Ha A ngolisoa.';
                $main_arr['info']['response']['message'] = 'Ngoliso ha e ea atleha. Lebitso kapa imeile ha e na letho.';
            }            

            $log_array = array(
                "api_name" => "Create User",
                "api_method" => "POST",
                "api_data" => json_encode($_POST),
                "api_lang" => $lang,
                "api_status" => 0,
                "api_response" => json_encode($main_arr),
                    "ip_addr" => $_SERVER['REMOTE_ADDR']
            );
            $this->db->insert('snr_api_call_log', $log_array);
        }
        else
        {
            $userpassword = $this->input->post('userpassword');
            $usergender = $this->input->post('usergender');
            $userdob = $this->input->post('userdob');
            $userphone = $this->input->post('userphone');
            if($this->input->post('deviceid'))
            {
                $deviceid = $this->input->post('deviceid');
            }
            else
            {
                $deviceid="";
            }
            
            // $userstate = $this->input->post('state');
            // $usercity = $this->input->post('city');

            $hashedpass = MD5($userpassword);
            $udata = $this->db->get_where("snr_users", ['usermail' => $usermail, 'userpassword' => $hashedpass])->result();
            if(empty($udata))
            {
                $token = substr(time(), -6).openssl_random_pseudo_bytes(16);
                $token = bin2hex($token);
                $data = array(
                    "userrole" => '3',
                    "userfname" => $fullname,
                    "userpassword" => $hashedpass,
                    "usermail" => $usermail,
                    "userphone" => $userphone,
                    "usergender_new" => $usergender,
                    "userdob" => $userdob,
                    "userstate" => "",
                    "usercity" => "",
                    "user_verified" => '0',
                    "language" => 'en',
                    "userstatus" => '1',
                    "usertoken" => $token,
                    "usersource" => '0',
                    "deviceid" => $deviceid,
                    "devicetype" => $devicetype
                );
                $this->db->insert('snr_users', $data);
                $insertId = $this->db->insert_id();
                $main_arr['api_version']='1.0';
                $main_arr['info']['title']='Sentebale health App';
                    
                if(!empty($insertId))
                {
                    $this->db->select("id,userrole,userfname,userlname,usermail,userphone,usergender_new AS usergender,userdob,useraddress,userstate,usercity,userzip,userimage,userstatus,user_verified,userregistered,last_updated,usertoken,social_login,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
                    $data = $this->db->get_where("snr_users", ['usermail' => $usermail, 'userpassword' => $hashedpass])->result();
                    $main_arr['info']['description']='User registration via email and password';

                    // echo "<pre>";
                    // print_r($data);
                    // echo "</pre>";
                    // if($data[0]->usergender=='M')
                    // {
                    //     $data[0]->userimage=base_url().'/uploads/avatar/male-avatar-new2.jpg';
                    // }
                    // else if($data[0]->usergender=='F')
                    // {
                    //     $data[0]->userimage=base_url().'/uploads/avatar/female-avatar-new2.jpg';
                    // }
                    // else
                    // {
                        $data[0]->userimage=base_url().'/uploads/avatar/avatar2.jpg';
                    // }
                    $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
                    $main_arr['info']['method']='POST';
                    $main_arr['paths']['api/v1/users/create']['POST']['summary']='User Registration';
                    $main_arr['paths']['api/v1/users/create']['POST']['description']='User registration from app';
                    $main_arr['paths']['api/v1/users/create']['POST']['parameters']='firstname, lastname, usermail, userpassword, location';
                    if(!empty($data))
                    {
                        $urllink = base_url()."verifyuser/".urlencode($insertId)."/".urlencode($token)."/".urlencode($lang);
                        $status = sendpromotionalmail($usermail, 'verifymail', 'Verify your Sentebale account email', $urllink, $lang);
                        
                        $main_arr['info']['response']['status'] = '1';
                        $main_arr['info']['response']['data'] = $data;
                        // if($lang=='en')
                        // {
                        //     $main_arr['info']['response']['message'] = 'You have successfully registered. Please check your mail (including junk) for verification link.';
                        // }
                        // if($lang=='zu')
                        // {
                        //     $main_arr['info']['response']['message'] = 'Ubhalise ngempumelelo. Sicela uhlole imeyili yakho ukuthola isixhumanisi sokuqinisekisa.';
                        // }
                        // if($lang=='st')
                        // {
                        //     $main_arr['info']['response']['message'] = 'U ngolisitse ka katleho. Ka kopo lekola lengolo-tsoibila la hau bakeng sa sehokela sa netefatso.';
                        // }

                        if($lang=='en')
                        {
                            $main_arr['info']['response']['message'] = 'Please check your email and remember to also check your spam folder for link to access the app.';
                        }
                        if($lang=='zu')
                        {
                            $main_arr['info']['response']['message'] = 'Sicela uhlole i-imeyili yakho futhi ukhumbule ukuhlola futhi ifolda yogaxekile yakho ukuze uthole isixhumanisi sokufinyelela uhlelo lokusebenza.';
                        }
                        if($lang=='st')
                        {
                            $main_arr['info']['response']['message'] = 'Ka kopo, sheba lengolo-tsoibila la hau me u hopole ho sheba foldara ea hau ea spam bakeng sa sehokelo sa ho fihlella sesebelisoa.';
                        }
                       
                        $log_array = array(
                            "api_name" => "Create User",
                            "api_method" => "POST",
                            "api_data" => json_encode($_POST),
                            "api_lang" => $lang,
                            "api_status" => 1,
                            "api_response" => json_encode($main_arr),
                    "ip_addr" => $_SERVER['REMOTE_ADDR']
                        );
                        $this->db->insert('snr_api_call_log', $log_array);

                        if(!empty($deviceid))
                        {
                            //$dtype = get_device_type($deviceid);
                            // $dtype->devicetype
                            if($lang=='en')
                            {
                                send_push($deviceid, "Congrats! You've successfully registered.", "Please check email (including junk) for activation", "individual", 0, $devicetype);
                            }
                            if($lang=='zu')
                            {
                                send_push($deviceid, "Halala! Ubhalise ngempumelelo.", "Sicela uhlole i-imeyili (kuhlanganise nodoti) ukuze isebenze", "individual", 0, $devicetype);
                            }
                            if($lang=='st')
                            {
                                send_push($deviceid, "Kea leboha! U ngolisitse ka katleho.", "Ka kopo, sheba lengolo-tsoibila (ho kenyeletsoa le litšila) bakeng sa ho kenya tšebetsong", "individual", 0, $devicetype);
                            }        
                            
                        }
                    }
                    else
                    {
                        $main_arr['info']['response']['status'] = '0';
                        if($lang=='en')
                        {
                            $main_arr['info']['response']['data'] = 'User Not Active.';
                            $main_arr['info']['response']['message'] = 'Registration unsuccessful. Please Try again.';
                        }
                        if($lang=='zu')
                        {
                            $main_arr['info']['response']['data'] = 'Umsebenzisi Akasebenzi.';
                            $main_arr['info']['response']['message'] = 'Ukubhalisa akuphumelelanga. Ngicela uzame futhi.';
                        }
                        if($lang=='st')
                        {
                            $main_arr['info']['response']['data'] = 'Mosebelisi Ha A sebetse.';
                            $main_arr['info']['response']['message'] = 'Ngoliso ha e ea atleha. Ka kopo leka hape.';
                        }
                        
                        $log_array = array(
                            "api_name" => "Create User",
                            "api_method" => "POST",
                            "api_data" => json_encode($_POST),
                            "api_lang" => $lang,
                            "api_status" => 0,
                            "api_response" => json_encode($main_arr),
                    "ip_addr" => $_SERVER['REMOTE_ADDR']
                        );
                        $this->db->insert('snr_api_call_log', $log_array);
                    }
                }
            }
            else
            {
                $main_arr['info']['description']='User registration via email and password';
                $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
                $main_arr['info']['method']='POST';
                $main_arr['paths']['api/v1/users/create']['POST']['summary']='User Registration';
                $main_arr['paths']['api/v1/users/create']['POST']['description']='User registration from app';
                $main_arr['paths']['api/v1/users/create']['POST']['parameters']='firstname, lastname, usermail, userpassword, location';
                $main_arr['info']['response']['status'] = '0';
                if($lang=='en')
                {
                    $main_arr['info']['response']['data'] = 'User Already Exists.';
                    $main_arr['info']['response']['message'] = 'User Already Exists.';
                }
                if($lang=='zu')
                {
                    $main_arr['info']['response']['data'] = 'Umsebenzisi Usuvele Ukhona.';
                    $main_arr['info']['response']['message'] = 'Umsebenzisi Usuvele Ukhona.';
                }
                if($lang=='st')
                {
                    $main_arr['info']['response']['data'] = 'Mosebedisi o se a le teng.';
                    $main_arr['info']['response']['message'] = 'Mosebedisi o se a le teng.';
                }

                $log_array = array(
                    "api_name" => "Create User",
                    "api_method" => "POST",
                    "api_data" => json_encode($_POST),
                    "api_lang" => $lang,
                    "api_status" => 0,
                    "api_response" => json_encode($main_arr),
                    "ip_addr" => $_SERVER['REMOTE_ADDR']
                );
                $this->db->insert('snr_api_call_log', $log_array);
            }
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function socialcreate_post()
	{
        $lang = $this->input->post('lang');
        $fullname = $this->input->post('fullname');
        $usermail = $this->input->post('usermail');
        
        if(!empty($this->input->post('devicetype')))
        {
            $devicetype = $this->input->post('devicetype');
        }
        else
        {
            $devicetype = "";
        }

        $log_array = array(
            "api_name" => "User Social Login - Social Create",
            "api_method" => "POST",
            "api_lang" => '',
            "api_status" => 1,
            "api_data" => json_encode($_POST),
                     "ip_addr" => $_SERVER['REMOTE_ADDR']
        );
        $this->db->insert('snr_api_call_log', $log_array);

        if(empty($usermail) || empty($fullname))
        {
            $main_arr['info']['description']='User registration via social network';
            $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
            $main_arr['info']['method']='POST';
            $main_arr['paths']['api/v1/users/socialcreate']['POST']['summary']='User Registration';
            $main_arr['paths']['api/v1/users/socialcreate']['POST']['description']='User registration from app via social network';
            $main_arr['paths']['api/v1/users/socialcreate']['POST']['parameters']='fullname, usermail, location, network, social_id';

            $main_arr['info']['response']['status'] = '0';
            if($lang=='en')
            {
                $main_arr['info']['response']['data'] = 'User Not Registered.';
                $main_arr['info']['response']['message'] = 'Registration unsuccessful. Either name or email is empty.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'Umsebenzisi Akabhalisiwe.';
                $main_arr['info']['response']['message'] = 'Ukubhalisa akuphumelelanga. Igama noma i-imeyili ayinalutho.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Mosebelisi Ha A ngolisoa.';
                $main_arr['info']['response']['message'] = 'Ngoliso ha e ea atleha. Lebitso kapa imeile ha e na letho.';
            }
            
            // $log_array = array(
            //     "api_name" => "User Social Login",
            //     "api_method" => "POST",
            //     "api_lang" => '',
            //     "api_status" => 1,
            //     "ip_addr" => $_SERVER['REMOTE_ADDR']
            // );
            // $this->db->insert('snr_api_call_log', $log_array);
        }
        else
        {           
            $userstate = '3';
            $usercity = '159';
            
            if($this->input->post('deviceid'))
            {
                $deviceid = $this->input->post('deviceid');
            }
            else
            {
                $deviceid="";
            }
            
            $network = $this->input->post('network');

            if($network=='fa')
            {
                $facebook_code = $this->input->post('social_id');
            }
            else
            {
                $facebook_code = '';
            }

            if($network=='go')
            {
                $google_code = $this->input->post('social_id');
            }
            else
            {
                $google_code = '';
            }

            if($network=='in')
            {
                $instagram_code = $this->input->post('social_id');
            }
            else
            {
                $instagram_code = '';
            }

            if($network=='apple')
            {
                $apple_code = $this->input->post('social_id');
            }
            else
            {
                $apple_code = '';
            }

            if(isset($facebook_code) || isset($google_code) || isset($instagram_code) ||  isset($apple_code))
            {
                $usersource = '1';
                $social_login = '1';
            }
            else
            {
                $usersource = '0';
                $social_login = '0';
            }

            $device_type = $this->input->post('devicetype');

            //$hashedpass = MD5($userpassword);
            $this->db->select("*,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
            $udata = $this->db->get_where("snr_users", ['usermail' => $usermail])->result();
            if(empty($udata))
            {
                $token = substr(time(), -6).openssl_random_pseudo_bytes(16);
                $token = bin2hex($token);
                $data = array(
                    "userrole" => '3',
                    "userfname" => $fullname,
                    "usermail" => $usermail,
                    "userstate" => $userstate,
                    "usercity" => $usercity,
                    "user_verified" => '1',
                    "social_login" => $social_login,
                    "facebook_code" => $facebook_code,
                    "google_code" => $google_code,
                    "instagram_code" => $instagram_code,
                    "apple_code" => $apple_code,
                    "language" => 'en',
                    "userstatus" => '1',
                    "usertoken" => $token,
                    "usersource" => '1',
                    "deviceid" => $deviceid,
                    "devicetype" => $devicetype
                );
                $this->db->insert('snr_users', $data);
                $insertId = $this->db->insert_id();
                $main_arr['api_version']='1.0';
                $main_arr['info']['title']='Sentebale health App';
                    
                if(!empty($insertId))
                {
                    $this->db->select("*,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
                    $data_usr = $this->db->get_where("snr_users", ['usermail' => $usermail])->result();

                    // if($data_usr[0]->usergender=='M')
                    // {
                    //     $data_usr[0]->userimage=base_url().'/uploads/avatar/male-avatar-new2.jpg';
                    // }
                    // else if($data_usr[0]->usergender=='F')
                    // {
                    //     $data_usr[0]->userimage=base_url().'/uploads/avatar/female-avatar-new2.jpg';
                    // }
                    // else
                    // {
                        $data_usr[0]->userimage=base_url().'/uploads/avatar/avatar2.jpg';
                    // }

                    $main_arr['info']['description']='User registration via social network';
                    $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
                    $main_arr['info']['method']='POST';
                    $main_arr['paths']['api/v1/users/socialcreate']['POST']['summary']='User Registration';
                    $main_arr['paths']['api/v1/users/socialcreate']['POST']['description']='User registration from app via social network';
                    $main_arr['paths']['api/v1/users/socialcreate']['POST']['parameters']='fullname, usermail, location, network, social_id';
                    if(!empty($data_usr))
                    {                
                        $status = sendpromotionalmail($usermail, 'welcomemail', 'Welcome to Sentebale Health App', '', $lang);

                        $main_arr['info']['response']['status'] = '1';
                        $main_arr['info']['response']['data'] = $data_usr;
                        if($lang=='en')
                        {
                            //$main_arr['info']['response']['data'] = 'You have successfully registered.';
                            $main_arr['info']['response']['message'] = 'You have successfully registered.';
                        }
                        if($lang=='zu')
                        {
                            // $main_arr['info']['response']['data'] = 'Ubhalise ngempumelelo.';
                            $main_arr['info']['response']['message'] = 'Ubhalise ngempumelelo.';
                        }
                        if($lang=='st')
                        {
                            // $main_arr['info']['response']['data'] = 'U ngolisitse ka katleho.';
                            $main_arr['info']['response']['message'] = 'U ngolisitse ka katleho.';
                        }

                        $log_array = array(
                            "api_name" => "Social User Create - SOCIALCREATE",
                            "api_method" => "POST",
                            "api_data" => json_encode($_POST),
                            "api_lang" => $lang,
                            "api_status" => 1,
                            "api_response" => json_encode($main_arr),
                    "ip_addr" => $_SERVER['REMOTE_ADDR']
                        );
                        $this->db->insert('snr_api_call_log', $log_array);

                        if(!empty($deviceid))
                        {
                            //$dtype = get_device_type($data_usr[0]->deviceid);
                            // $dtype->devicetype
                            if($lang=='en')
                            {
                                send_profile_push($deviceid, "Congrats! You've successfully registered.", "Please don't forget to fill up Phone, Gender & DOB in your profile.", "individual", 0, $devicetype);
                            }
                            if($lang=='zu')
                            {
                                send_profile_push($deviceid, "Halala! Ubhalise ngempumelelo.", "Sicela ungakhohlwa ukugcwalisa Ucingo, Ubulili & DOB kuphrofayela yakho.", "individual", 0, $devicetype);
                            }
                            if($lang=='st')
                            {
                                send_profile_push($deviceid, "Kea leboha! U ngolisitse ka katleho.", "Ka kopo u seke oa lebala ho tlatsa Fono, Tekano le DOB profaeleng ea hau.", "individual", 0, $devicetype);
                            }
                            

                            // send_push($data[0]->deviceid, "Hello ".$data[0]->userfname.", Welcome to Sentebale", "Explore our health care facilities around you", "individual", 0);
                        }
                    }
                    else
                    {
                        $main_arr['info']['response']['status'] = '0';
                        if($lang=='en')
                        {
                            $main_arr['info']['response']['data'] = 'User Not Active.';
                            $main_arr['info']['response']['message'] = 'Registration unsuccessful. Please Try again.';
                        }
                        if($lang=='zu')
                        {
                            $main_arr['info']['response']['data'] = 'Umsebenzisi Akasebenzi.';
                            $main_arr['info']['response']['message'] = 'Ukubhalisa akuphumelelanga. Ngicela uzame futhi.';
                        }
                        if($lang=='st')
                        {
                            $main_arr['info']['response']['data'] = 'Mosebelisi Ha A sebetse.';
                            $main_arr['info']['response']['message'] = 'Ngoliso ha e ea atleha. Ka kopo leka hape.';
                        }
                        // $main_arr['info']['response']['data'] = 'User Not Active.';
                        // $main_arr['info']['response']['message'] = 'Registration unsuccessful. Please Try again.';

                        $log_array = array(
                            "api_name" => "Social User Create - SOCIALCREATE",
                            "api_method" => "POST",
                            "api_data" => json_encode($_POST),
                            "api_lang" => $lang,
                            "api_status" => 0,
                            "api_response" => json_encode($main_arr),
                    "ip_addr" => $_SERVER['REMOTE_ADDR']
                        );
                        $this->db->insert('snr_api_call_log', $log_array);
                    }
                }
            }
            else
            {
                $this->db->select("*,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
                $data_usr = $this->db->get_where("snr_users", ['usermail' => $usermail])->result();
                $main_arr['info']['description']='User Login via social network';
                $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
                $main_arr['info']['method']='POST';
                $main_arr['paths']['api/v1/users/socialcreate']['POST']['summary']='User Registration';
                $main_arr['paths']['api/v1/users/socialcreate']['POST']['description']='User login from app via social network';
                $main_arr['paths']['api/v1/users/socialcreate']['POST']['parameters']='fullname, usermail, location, network, social_id';
                if(!empty($data_usr))
                {                       
                    $main_arr['info']['response']['status'] = '1';
                    $main_arr['info']['response']['data'] = $data_usr;
                    if($lang=='en')
                    {
                        //$main_arr['info']['response']['data'] = 'You have successfully logged in.';
                        $main_arr['info']['response']['message'] = 'You have successfully logged in.';
                    }
                    if($lang=='zu')
                    {
                        //$main_arr['info']['response']['data'] = 'Ungene ngemvume ngempumelelo.';
                        $main_arr['info']['response']['message'] = 'Ungene ngemvume ngempumelelo.';
                    }
                    if($lang=='st')
                    {
                        //$main_arr['info']['response']['data'] = 'O kene ka katleho.';
                        $main_arr['info']['response']['message'] = 'O kene ka katleho.';
                    }   
                    
                    $log_array = array(
                        "api_name" => "Social User Login - SOCIALCREATE",
                        "api_method" => "POST",
                        "api_data" => json_encode($_POST),
                        "api_lang" => $lang,
                        "api_status" => 1,
                        "api_response" => json_encode($main_arr),
                    "ip_addr" => $_SERVER['REMOTE_ADDR']
                    );
                    $this->db->insert('snr_api_call_log', $log_array);

                    if(!empty($deviceid))
                    {
                        //$dtype = get_device_type($deviceid);
                        // $dtype->devicetype
                        if($lang=='en')
                        {
                            send_push($deviceid, "Congrats!", "You've successfully Logged in.", "individual", 0, $devicetype);
                        }
                        if($lang=='zu')
                        {
                            send_push($deviceid, "Halala!", "Ungene ngemvume ngempumelelo.", "individual", 0, $devicetype);
                        }
                        if($lang=='st')
                        {
                            send_push($deviceid, "Kea leboha!", "O kene ka katleho.", "individual", 0, $devicetype);
                        }                        
                    }
                }
            }
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function resetpassword_post()
	{
        $usermail = $this->input->post('usermail');
        $lang = $this->input->post('lang');
        if(empty($usermail))
        {
            $main_arr['info']['description']='Password Reset';
            $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
            $main_arr['info']['method']='POST';
            $main_arr['paths']['api/v1/users/resetpass']['POST']['summary']='User Password Reset';
            $main_arr['paths']['api/v1/users/resetpass']['POST']['description']='User reset password from app';
            $main_arr['paths']['api/v1/users/resetpass']['POST']['parameters']='usermail';

            $main_arr['info']['response']['status'] = '0';
            if($lang=='en')
            {
                $main_arr['info']['response']['data'] = 'Email is empty';
                $main_arr['info']['response']['message'] = 'Email is empty.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'I-imeyili ayinalutho';
                $main_arr['info']['response']['message'] = 'I-imeyili ayinalutho';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Imeile ha e na letho';
                $main_arr['info']['response']['message'] = 'Imeile ha e na letho';
            }

            // $log_array = array(
            //     "api_name" => "User Password Reset",
            //     "api_method" => "POST",
            //     "api_lang" => '',
            //     "api_status" => 1,
            //     "ip_addr" => $_SERVER['REMOTE_ADDR']
            // );
            // $this->db->insert('snr_api_call_log', $log_array);

        }
        else
        {
            $this->db->select("*,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
            $udata = $this->db->get_where("snr_users", ['usermail' => $usermail])->row();
            //echo $udata->usertoken;
            if(!empty($udata))
            {          

                ////////////////////////////////////////////////////////////////
                $urllink = base_url()."resetuser/".urlencode($usermail)."/".urlencode($udata->usertoken)."/".urlencode($lang);
                $status = sendpromotionalmail($usermail, 'resetmail', 'Reset Your Sentebale App Password', $urllink, $lang);
                ////////////////////////////////////////////////////////////////
                
                $main_arr['info']['description']='User Password Reset';
                $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
                $main_arr['info']['method']='POST';
                $main_arr['paths']['api/v1/users/resetpass']['POST']['summary']='Password Reset';
                $main_arr['paths']['api/v1/users/resetpass']['POST']['description']='User Password Reset';
                $main_arr['paths']['api/v1/users/resetpass']['POST']['parameters']='usermail';                 
                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['data'] = '';
                if($lang=='en')
                {
                    $main_arr['info']['response']['message'] = 'Please check your registered email for password reset link.';
                }
                if($lang=='zu')
                {
                    $main_arr['info']['response']['message'] = 'Sicela uhlole i-imeyili yakho ebhalisiwe ukuthola isixhumanisi sokusetha kabusha iphasiwedi.';
                }
                if($lang=='st')
                {
                    $main_arr['info']['response']['message'] = 'Ka kopo sheba lengolo-tsoibila le ngolisitsoeng bakeng sa sehokelo sa ho seta phasewete.';
                }
            }
            else
            {
                $main_arr['info']['description']='User Password Reset';
                $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
                $main_arr['info']['method']='POST';
                $main_arr['paths']['api/v1/users/resetpass']['POST']['summary']='Password Reset';
                $main_arr['paths']['api/v1/users/resetpass']['POST']['description']='User Password Reset';
                $main_arr['paths']['api/v1/users/resetpass']['POST']['parameters']='usermail';
                $main_arr['info']['response']['status'] = '0';
                if($lang=='en')
                {
                    $main_arr['info']['response']['data'] = 'Email does not Exist.';
                    $main_arr['info']['response']['message'] = 'Email does not Exist.';
                }
                if($lang=='zu')
                {
                    $main_arr['info']['response']['data'] = 'I-imeyili ayikho.';
                    $main_arr['info']['response']['message'] = 'I-imeyili ayikho.';
                }
                if($lang=='st')
                {
                    $main_arr['info']['response']['data'] = 'Imeile ha e eo.';
                    $main_arr['info']['response']['message'] = 'Imeile ha e eo.';
                }

            }
        }
        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function resetpass_post()
	{
        $usermail = $this->input->post('usermail');
        $lang = $this->input->post('lang');
        if(empty($usermail))
        {
            $main_arr['info']['description']='Password Reset';
            $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
            $main_arr['info']['method']='POST';
            $main_arr['paths']['api/v1/users/resetpass']['POST']['summary']='User Password Reset';
            $main_arr['paths']['api/v1/users/resetpass']['POST']['description']='User reset password from app';
            $main_arr['paths']['api/v1/users/resetpass']['POST']['parameters']='usermail';

            $main_arr['info']['response']['status'] = '0';
            if($lang=='en')
            {
                $main_arr['info']['response']['data'] = 'Email is empty';
                $main_arr['info']['response']['message'] = 'Email is empty.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'I-imeyili ayinalutho';
                $main_arr['info']['response']['message'] = 'I-imeyili ayinalutho';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Imeile ha e na letho';
                $main_arr['info']['response']['message'] = 'Imeile ha e na letho';
            }
            
        }
        else
        {
            $this->db->select("*,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
            $udata = $this->db->get_where("snr_users", ['usermail' => $usermail])->row();
            // echo "<pre>";
            // print_r($udata);
            // echo "</pre>";
            // if($udata->usergender=='M')
            // {
            //     $udata->userimage=base_url().'/uploads/avatar/male-avatar-new2.jpg';
            // }
            // else if($udata->usergender=='F')
            // {
            //     $udata->userimage=base_url().'/uploads/avatar/female-avatar-new2.jpg';
            // }
            // else
            // {
                $udata->userimage=base_url().'/uploads/avatar/avatar2.jpg';
            // }

            if(!empty($udata))
            {          

                $urllink = base_url()."resetuser/".urlencode($usermail)."/".urlencode($udata->usertoken)."/".urlencode($lang);
                $status = sendpromotionalmail($usermail, 'resetmail', 'Reset Your Sentebale App Password', $urllink, $lang);

                $main_arr['info']['description']='User Password Reset';
                $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
                $main_arr['info']['method']='POST';
                $main_arr['paths']['api/v1/users/resetpass']['POST']['summary']='Password Reset';
                $main_arr['paths']['api/v1/users/resetpass']['POST']['description']='User Password Reset';
                $main_arr['paths']['api/v1/users/resetpass']['POST']['parameters']='usermail';                 
                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['data'] = '';
                if($lang=='en')
                {
                    $main_arr['info']['response']['data'] = $udata;
                    $main_arr['info']['response']['message'] = 'Please check your registered email for password reset link.';
                }
                if($lang=='zu')
                {
                    $main_arr['info']['response']['data'] = $udata;
                    $main_arr['info']['response']['message'] = 'Sicela uhlole i-imeyili yakho ebhalisiwe ukuthola isixhumanisi sokusetha kabusha iphasiwedi.';
                }
                if($lang=='st')
                {
                    $main_arr['info']['response']['data'] = $udata;
                    $main_arr['info']['response']['message'] = 'Ka kopo sheba lengolo-tsoibila le ngolisitsoeng bakeng sa sehokelo sa ho seta phasewete.';
                }
            }
            else
            {
                $main_arr['info']['description']='User Password Reset';
                $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
                $main_arr['info']['method']='POST';
                $main_arr['paths']['api/v1/users/resetpass']['POST']['summary']='Password Reset';
                $main_arr['paths']['api/v1/users/resetpass']['POST']['description']='User Password Reset';
                $main_arr['paths']['api/v1/users/resetpass']['POST']['parameters']='usermail';
                $main_arr['info']['response']['status'] = '0';
                if($lang=='en')
                {
                    $main_arr['info']['response']['data'] = 'Email does not Exist.';
                    $main_arr['info']['response']['message'] = 'Email does not Exist.';
                }
                if($lang=='zu')
                {
                    $main_arr['info']['response']['data'] = 'I-imeyili ayikho.';
                    $main_arr['info']['response']['message'] = 'I-imeyili ayikho.';
                }
                if($lang=='st')
                {
                    $main_arr['info']['response']['data'] = 'Imeile ha e eo.';
                    $main_arr['info']['response']['message'] = 'Imeile ha e eo.';
                }
            }
        }
        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function updateuser_post()
	{
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        $lang = $this->input->post('lang');
        $uid = $this->input->post('user_id');
        if(empty($uid))
        {
            $main_arr['api_version']='1.0';
            $main_arr['info']['title']='Sentebale health App';

            $main_arr['info']['description']='User data update via app';
            $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
            $main_arr['info']['method']='POST';
            $main_arr['paths']['api/v1/users/updateuser']['POST']['summary']='User Info Update';
            $main_arr['paths']['api/v1/users/updateuser']['POST']['description']='User update from app';
            $main_arr['paths']['api/v1/users/updateuser']['POST']['parameters']='user_id, username, userpassword, userphone, usergender, userdob, usercity';
        
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = '';
            $main_arr['info']['response']['message'] = 'Please send valid User ID to verify details';
        }
        else
        {
            $this->db->select("*,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
            $udata = $this->db->get_where("snr_users", ['id' => $uid])->result();

            // echo "<pre>";
            // print_r($udata);
            // echo "</pre>";

            $val = array();

            if(!empty($this->input->post('username')))
            {
                $val['userfname'] = $this->input->post('username');
            }
            if(!empty($this->input->post('userpassword')))
            {
                $hashedpass = MD5($this->input->post('userpassword'));
                $val['userpassword'] = $hashedpass;
            }
            if(!empty($this->input->post('userphone')))
            {
                $val['userphone'] = $this->input->post('userphone');
            }
            if(!empty($this->input->post('usergender')))
            {
                $val['usergender_new'] = $this->input->post('usergender');
            }
            if(!empty($this->input->post('userdob')))
            {
                $val['userdob'] = $this->input->post('userdob');
            }
            if(!empty($this->input->post('usercity')))
            {
                $val['usercity'] = $this->input->post('usercity');
            }

            $this->db->where('id', $uid);
            $this->db->update('snr_users', $val);
            $updateID = $this->db->affected_rows();

            $main_arr['api_version']='1.0';
            $main_arr['info']['title']='Sentebale health App';
                        
            if(!empty($updateID))
            {
                $this->db->select("id,userrole,userfname,userlname,usermail,userphone,usergender_new AS usergender,userdob,useraddress,userstate,usercity,userzip,userimage,userstatus,user_verified,userregistered,last_updated,usertoken,social_login,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
                $data = $this->db->get_where("snr_users", ['usermail' => $udata[0]->usermail, 'id' => $uid])->result();
                // if($data[0]->usergender=='M')
                // {
                //     $data[0]->userimage=base_url().'/uploads/avatar/male-avatar-new2.jpg';
                // }
                // else if($data[0]->usergender=='F')
                // {
                //     $data[0]->userimage=base_url().'/uploads/avatar/female-avatar-new2.jpg';
                // }
                // else
                // {
                    $data[0]->userimage=base_url().'/uploads/avatar/avatar2.jpg';
                // }

                $this->db->select("COUNT(id) as tot");
                $period = $this->db->get_where("snr_period", ['user_id' => $uid])->result();
                if($period[0]->tot > 0)
                {
                    $data[0]->is_perioddata='1';
                }
                else
                {
                    $data[0]->is_perioddata='0';
                }

                $main_arr['info']['description']='User data update via app';
                $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
                $main_arr['info']['method']='POST';
                $main_arr['paths']['api/v1/users/updateuser']['POST']['summary']='User Info Update';
                $main_arr['paths']['api/v1/users/updateuser']['POST']['description']='User update from app';
                $main_arr['paths']['api/v1/users/updateuser']['POST']['parameters']='user_id, username, userpassword, userphone, usergender, userdob, usercity';
            
                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['data'] = $data;
                if($lang=='en')
                {
                    $main_arr['info']['response']['message'] = 'Your profile has been updated successfully';
                }
                if($lang=='zu')
                {
                    $main_arr['info']['response']['message'] = 'Iphrofayela yakho ibuyekezwe ngempumelelo';
                }
                if($lang=='st')
                {
                    $main_arr['info']['response']['message'] = 'Boemo ba hau bo ntlafalitsoe ka katleho';
                }    
                
                $log_array = array(
                    "api_name" => "User Update",
                    "api_method" => "POST",
                    "api_data" => json_encode($_POST),
                    "api_lang" => $lang,
                    "api_status" => 1,
                    "api_response" => json_encode($main_arr),
                    "ip_addr" => $_SERVER['REMOTE_ADDR']
                );
                $this->db->insert('snr_api_call_log', $log_array);

                if(!empty($data[0]->deviceid))
                {
                    //$dtype = get_device_type($data[0]->devicetype);
                    // $dtype->devicetype
                    if($lang=='en')
                    {
                        send_profile_push($data[0]->deviceid, "Congrats! Your profile is updated now.", "Your profile details updated successfully.", "individual", 0, $data[0]->devicetype);
                    }
                    if($lang=='zu')
                    {
                        send_profile_push($data[0]->deviceid, "Halala! Iphrofayela yakho ibuyekeziwe manje.", "Imininingwane yephrofayela yakho ibuyekezwe ngempumelelo.", "individual", 0, $data[0]->devicetype);
                    }
                    if($lang=='st')
                    {
                        send_profile_push($data[0]->deviceid, "Kea leboha! Boemo ba hau bo nchafalitsoe hona joale.", "Lintlha tsa boemo ba hau li ntlafalitsoe ka katleho.", "individual", 0, $data[0]->devicetype);
                    }                      

                    // send_push($data[0]->deviceid, "Hello ".$data[0]->userfname.", Welcome to Sentebale", "Explore our health care facilities around you", "individual", 0);
                }
            }
            else
            {                
                $this->db->select("id,userrole,userfname,userlname,usermail,userphone,usergender_new AS usergender,userdob,useraddress,userstate,usercity,userzip,userimage,userstatus,user_verified,userregistered,last_updated,usertoken,social_login,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
                $data = $this->db->get_where("snr_users", ['usermail' => $udata[0]->usermail, 'id' => $uid])->result();
                // if($data[0]->usergender=='M')
                // {
                //     $data[0]->userimage=base_url().'/uploads/avatar/male-avatar-new2.jpg';
                // }
                // else if($data[0]->usergender=='F')
                // {
                //     $data[0]->userimage=base_url().'/uploads/avatar/female-avatar-new2.jpg';
                // }
                // else
                // {
                    $data[0]->userimage=base_url().'/uploads/avatar/avatar2.jpg';
                // }

                $this->db->select("COUNT(id) as tot");
                $period = $this->db->get_where("snr_period", ['user_id' => $uid])->result();
                if($period[0]->tot > 0)
                {
                    $data[0]->is_perioddata='1';
                }
                else
                {
                    $data[0]->is_perioddata='0';
                }
                
                $main_arr['info']['description']='User data update via app';
                $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
                $main_arr['info']['method']='POST';
                $main_arr['paths']['api/v1/users/updateuser']['POST']['summary']='User Info Update';
                $main_arr['paths']['api/v1/users/updateuser']['POST']['description']='User update from app';
                $main_arr['paths']['api/v1/users/updateuser']['POST']['parameters']='user_id, username, userpassword, userphone, usergender, userdob, usercity';
            
                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['data'] = $data;
                if($lang=='en')
                {
                    $main_arr['info']['response']['message'] = 'Your profile has been updated successfully';
                }
                if($lang=='zu')
                {
                    $main_arr['info']['response']['message'] = 'Iphrofayela yakho ibuyekezwe ngempumelelo';
                }
                if($lang=='st')
                {
                    $main_arr['info']['response']['message'] = 'Boemo ba hau bo ntlafalitsoe ka katleho';
                }

                $log_array = array(
                    "api_name" => "User Update",
                    "api_method" => "POST",
                    "api_data" => json_encode($_POST),
                    "api_lang" => $lang,
                    "api_status" => 1,
                    "api_response" => json_encode($main_arr),
                    "ip_addr" => $_SERVER['REMOTE_ADDR']
                );
                $this->db->insert('snr_api_call_log', $log_array);

                if(!empty($data[0]->deviceid))
                {
                    //$dtype = get_device_type($data[0]->deviceid);
                    // $dtype->devicetype
                    if($lang=='en')
                    {
                        send_profile_push($data[0]->deviceid, "Congrats! Your profile is updated now.", "Your profile details upldated successfully.", "individual", 0, $data[0]->devicetype);
                    }
                    if($lang=='zu')
                    {
                        send_profile_push($data[0]->deviceid, "Halala! Iphrofayela yakho ibuyekeziwe manje.", "Imininingwane yephrofayela yakho ibuyekezwe ngempumelelo.", "individual", 0, $data[0]->devicetype);
                    }
                    if($lang=='st')
                    {
                        send_profile_push($data[0]->deviceid, "Kea leboha! Boemo ba hau bo nchafalitsoe hona joale.", "Lintlha tsa boemo ba hau li ntlafalitsoe ka katleho.", "individual", 0, $data[0]->devicetype);
                    }   

                    //send_push($data[0]->deviceid, "Hello ".$data[0]->userfname.", Your profile is updated now.", "Your profile details upldated successfully.", "individual", 0);

                    // send_push($data[0]->deviceid, "Hello ".$data[0]->userfname.", Welcome to Sentebale", "Explore our health care facilities around you", "individual", 0);
                }
            }
        }

        

        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function upcoming_post()
	{
        $lang = $this->input->post('lang');
        $uid = $this->input->post('uid');
        
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
        $data = array();
        $data['user_id']=$uid;
        $now = date('Y-m-d H:i:s');
        //SELECT COUNT(id) as tot FROM `snr_booking` WHERE `user_id`='71'
        $this->db->select("COUNT(id) as tot");
        $total_booking = $this->db->get_where("snr_booking", ['user_id' => $uid])->result();
        $data['total_booking'] = $total_booking[0]->tot;
        
        $this->db->select("COUNT(schedule_date) as tot");
        $upcoming_booking = $this->db->get_where("snr_booking", ['user_id' => $uid, 'schedule_date<' => $now])->result();
        $data['upcoming_booking'] = $upcoming_booking[0]->tot;

        //print_r($data);

        $main_arr['info']['description']='User Upcoming and Total Booking';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/users/upcoming']['POST']['summary']='User Booking Count';
        $main_arr['paths']['api/v1/users/upcoming']['POST']['description']='User upcoming and total booking number';
        $main_arr['paths']['api/v1/users/upcoming']['POST']['parameters']='uid';
        if(($total_booking[0]->tot)>0)
        {
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $data;
        }
        else{
            $main_arr['info']['response']['status'] = '0';
            if($lang=='en')
            {
                $main_arr['info']['response']['data'] = 'No Booking Data Found.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'Ayikho idatha yokubhuka etholakele.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Ha ho Boitsebiso ba ho Boloka bo Fumanoeng.';
            }
        }
        $this->response($main_arr, REST_Controller::HTTP_OK);
	}

    public function deleteuser_post()
	{
        $lang = $this->input->post('lang');
        $uid = $this->input->post('userid');
        
        $main_arr['api_version']='1.0';
        $main_arr['info']['title']='Sentebale health App';
        
        $main_arr['info']['description']='User Account Delete';
        $main_arr['info']['generate_time']=date('d-m-Y H:i:s');
        $main_arr['info']['method']='POST';
        $main_arr['paths']['api/v1/users/deleteuser']['POST']['summary']='User Account Delete';
        $main_arr['paths']['api/v1/users/deleteuser']['POST']['description']='Delete user account by providing the user id';
        $main_arr['paths']['api/v1/users/deleteuser']['POST']['parameters']='lang, userid';

        $this->db->select("*");
        $uddata = $this->db->get_where("snr_users", ['id' => $uid])->result();
        
        // echo "<pre>";
        // print_r($uddata);
        // echo "</pre>";
        
        if(count($uddata)>0)
        {
            $delete_user = $this->db->insert('snr_deleted_users', $uddata[0]);
            $this->db->where('id', $uid);
            $this->db->delete('snr_users');

            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = array("user" => $uid);

            if($lang=='en')
            {
                $main_arr['info']['response']['data'] = 'Your account successfully deleted.';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'I-akhawunti yakho isuswe ngempumelelo.';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Ak\'haonte ea hau e hlakotsoe ka katleho.';
            }
        }
        else
        {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = array("user" => $uid);

            if($lang=='en')
            {
                $main_arr['info']['response']['data'] = 'No User found with this ID';
            }
            if($lang=='zu')
            {
                $main_arr['info']['response']['data'] = 'Akekho Umsebenzisi otholakele onale ID';
            }
            if($lang=='st')
            {
                $main_arr['info']['response']['data'] = 'Ha ho mosebelisi ea fumanoeng ea nang le ID ena';
            }
        }

        $log_array = array(
            "api_name" => "User Delete",
            "api_method" => "POST",
            "api_data" => json_encode($_POST),
            "api_lang" => $lang,
            "api_status" => 1,
            "api_response" => json_encode($main_arr),
            "ip_addr" => $_SERVER['REMOTE_ADDR']
        );
        $this->db->insert('snr_api_call_log', $log_array);

        $this->response($main_arr, REST_Controller::HTTP_OK);
	}
}
