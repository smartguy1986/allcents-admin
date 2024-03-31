<?php
header('Access-Control-Allow-Origin: *');
require APPPATH . 'libraries/REST_Controller.php';
class Users extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index_post()
    {
        $lang = $this->input->post('lang');
        $uid = $this->input->post('uid');

        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral App';

        if (!empty($uid)) {
            $this->db->select("id,userfname,userlname,usermail,userphone,usergender,userdob,useraddress,usercity,userzip,userimage,userstatus,userregistered,last_updated,usertoken,social_login,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
            $data = $this->db->get_where("snr_users", ['id' => $uid, 'userrole' => '3', 'userstatus' => '1', 'userdeleted' => '0'])->row_array();

            $now = date('Y-m-d H:i:s');
            $this->db->select("COUNT(id) as tot");
            $total_booking = $this->db->get_where("snr_booking", ['user_id' => $uid])->result();
            $data['total_booking'] = $total_booking[0]->tot;

            $this->db->select("COUNT(schedule_date) as tot");
            $upcoming_booking = $this->db->get_where("snr_booking", ['user_id' => $uid, 'schedule_date<' => $now])->result();
            $data['upcoming_booking'] = $upcoming_booking[0]->tot;

            if ($data['usergender'] == 'M') {
                $data['userimage'] = base_url() . '/uploads/avatar/male-avatar-new2.jpg';
            } else if ($data['usergender'] == 'F') {
                $data['userimage'] = base_url() . '/uploads/avatar/female-avatar-new2.jpg';
            } else {
                $data['userimage'] = base_url() . '/uploads/avatar/avatar.jpg';
            }

            $main_arr['info']['description'] = 'User Details for Particular ID';
            $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
            $main_arr['info']['method'] = 'POST';
            $main_arr['paths']['api/v1/users/(:num)']['POST']['summary'] = 'Get details of a particular user';
            $main_arr['paths']['api/v1/users/(:num)']['POST']['description'] = 'All the data of a particular user will be fetched based on the given id';
            $main_arr['paths']['api/v1/users/(:num)']['POST']['parameters'] = '';
            if (!empty($data)) {
                $this->db->select("COUNT(id) as tot");
                $period = $this->db->get_where("snr_period", ['user_id' => $uid])->result();
                if ($period[0]->tot > 0) {
                    $data['is_perioddata'] = '1';
                } else {
                    $data['is_perioddata'] = '0';
                }

                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['data'] = $data;

            } else {
                $main_arr['info']['response']['status'] = '0';
                if ($lang == 'en') {
                    $main_arr['info']['response']['data'] = 'No App user found with this id';
                }
                if ($lang == 'zu') {
                    $main_arr['info']['response']['data'] = 'Akekho umsebenzisi wohlelo lokusebenza otholakele nale id';
                }
                if ($lang == 'st') {
                    $main_arr['info']['response']['data'] = 'Ha ho mosebelisi oa App ea fumanoeng ka id ena';
                }
            }
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function login_post()
    {
        $userphone = $this->input->post('userphone');
        $password = $this->input->post('userpassword');

        $hashedpass = MD5($password);
        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral App';

        $main_arr['info']['description'] = 'User Login via phone and password';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $checkPhone = check_phone($userphone);
        if (isset($checkPhone->id)) {
            $this->db->select("id, uniqueid, userrole, usertitle, userfname, userlname, userchurchtitle, usermail, userphone, usergender, userdob, useraddress, usercountry, userprovince, userdistrict, userbranch, usercell, userstatus, user_verified, usertoken, userregistered, last_updated, DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
            $data = $this->db->get_where("snr_users", ['userphone' => $userphone, 'userpassword' => $hashedpass])->result();

            if (!empty($data)) {
                $uid = $data[0]->id;
                if ($data[0]->userstatus == 0 || $data[0]->user_verified == 0) {
                    $main_arr['info']['response']['status'] = '0';
                    $main_arr['info']['response']['data'] = '';
                    $main_arr['info']['response']['message'] = 'Please activate your account. Contact your branch Treasurer.';
                } else if ($data[0]->userrole != 3 && $data[0]->userrole != 2) {
                    $main_arr['info']['response']['status'] = '0';
                    $main_arr['info']['response']['data'] = '';
                    $main_arr['info']['response']['message'] = 'Only user can access the app.';
                } else {
                    $main_arr['info']['response']['status'] = '1';
                    $main_arr['info']['response']['data'] = $data;
                    $main_arr['info']['response']['message'] = 'You have logged in successfully.';
                }
            } else {
                $main_arr['info']['response']['status'] = '0';
                $main_arr['info']['response']['message'] = '';
                $main_arr['info']['response']['data'] = 'No Data Found. Please check Phone and Password Again.';
            }
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['message'] = '.';
            $main_arr['info']['response']['data'] = 'This phone number is not registered';
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function createuser_post()
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $usermail = strtolower(trim($this->input->post('usermail')));
        $userchurchtitle = $this->input->post('userchurchtitle');
        $usertitle = $this->input->post('usertitle');
        $userfname = $this->input->post('userfname');
        $userlname = $this->input->post('userlname');
        $userphone = $this->input->post('userphone');
        $userdob = $this->input->post('userdob');
        $usergender = $this->input->post('usergender');
        $useraddress = $this->input->post('useraddress');
        $usercountry = $this->input->post('usercountry');
        $userprovince = $this->input->post('userprovince');
        $userdistrict = $this->input->post('userdistrict');
        $userbranch = $this->input->post('userbranch');
        $usercell = $this->input->post('usercell');
        $userpassword = $this->input->post('userpassword');

        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral App';
        $main_arr['info']['description'] = 'User registration by Treasurer';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        if (empty($usermail) || empty($userchurchtitle) || empty($usertitle) || empty($userfname) || empty($userlname) || empty($usermail) || empty($userphone) || empty($userdob) || empty($usergender) || empty($useraddress) || empty($usercountry) || empty($userprovince) || empty($userdistrict) || empty($userbranch) || empty($usercell) || empty($userpassword)) {
            $main_arr['info']['response']['status'] = 0;
            $main_arr['info']['response']['data'] = '';
            $main_arr['info']['response']['message'] = 'Registration unsuccessful. Please check input parameters';
        } else {
            $hashedpass = MD5($userpassword);
            $udata = $this->db->get_where("snr_users", ['userphone' => $userphone, 'userpassword' => $hashedpass])->result();
            if (empty($udata)) {
                $token = substr(time(), -6) . openssl_random_pseudo_bytes(16);
                $token = bin2hex($token);
                $data = array(
                    "userrole" => '3',
                    "uniqueid" => strtoupper("AAC-" . generate_string($permitted_chars, 10)),
                    "userchurchtitle" => $userchurchtitle,
                    "usertitle" => $usertitle,
                    "userfname" => $userfname,
                    "userlname" => $userlname,
                    "userpassword" => $hashedpass,
                    "usermail" => $usermail,
                    "userphone" => $userphone,
                    "usergender" => $usergender,
                    "userdob" => $userdob,
                    "useraddress" => $useraddress,
                    "usercountry" => $usercountry,
                    "userprovince" => $userprovince,
                    "userdistrict" => $userdistrict,
                    "userbranch" => $userbranch,
                    "usercell" => $usercell,
                    "user_verified" => '1',
                    "userstatus" => '1',
                    "usertoken" => $token
                );
                $this->db->insert('snr_users', $data);
                $insertId = $this->db->insert_id();

                if (!empty($insertId)) {
                    $this->db->select("*,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
                    $data = $this->db->get_where("snr_users", ['userphone' => $userphone, 'userpassword' => $hashedpass])->result();
                    if (!empty($data)) {
                        $main_arr['info']['response']['status'] = 1;
                        $main_arr['info']['response']['data'] = $data;
                        $main_arr['info']['response']['message'] = 'User successfully registered';

                        storemylog("User registration by Treasurer", "api/v1/users/createuser", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($data));
                    } else {
                        $main_arr['info']['response']['status'] = 0;
                        $main_arr['info']['response']['data'] = '';
                        $main_arr['info']['response']['message'] = 'Registration unsuccessful. Please Try again.';
                        storemylog("User registration by Treasurer", "api/v1/users/createuser", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], "Registration unsuccessful. Please Try again.");
                    }
                }
            } else {
                $main_arr['info']['description'] = 'User registration via email and password';
                $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
                $main_arr['info']['method'] = 'POST';
                $main_arr['info']['response']['status'] = 0;
                $main_arr['info']['response']['data'] = '';
                $main_arr['info']['response']['message'] = 'User Already Exists.';
            }
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function resetpassword_post()
    {
        $userphone = $this->input->post('userphone');
        if (empty($userphone)) {
            $main_arr['info']['title'] = 'The Funeral Policy';
            $main_arr['info']['description'] = 'Password Reset';
            $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
            $main_arr['info']['method'] = 'POST';

            $main_arr['info']['response']['status'] = '0';

            $main_arr['info']['response']['data'] = 'Phone Number is empty';
            $main_arr['info']['response']['message'] = 'Phone Number is empty.';
        } else {
            $this->db->select("*,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
            $udata = $this->db->get_where("snr_users", ['userphone' => $userphone])->row();
            //echo $udata->usermail;
            if (!empty($udata)) {
                ////////////////////////////////////////////////////////////////
                $urllink = base_url() . "resetuser/" . urlencode($userphone) . "/" . urlencode($udata->usertoken);
                sendpromotionalmail($udata->usermail, 'resetmail', 'Reset Your AllCents App Password', $urllink);
                ////////////////////////////////////////////////////////////////
                $main_arr['info']['title'] = 'The Funeral Policy';
                $main_arr['info']['description'] = 'User Password Reset';
                $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
                $main_arr['info']['method'] = 'POST';
                $main_arr['info']['response']['status'] = '1';
                $main_arr['info']['response']['data'] = '';
                $main_arr['info']['response']['message'] = 'Please check your registered email for password reset link.';
            } else {
                $main_arr['info']['description'] = 'User Password Reset';
                $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
                $main_arr['info']['method'] = 'POST';
                $main_arr['info']['response']['status'] = '0';
                $main_arr['info']['response']['data'] = '';
                $main_arr['info']['response']['message'] = 'No account with this number exists.';
            }
        }
        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function updateuser_post()
    {
        $utoken = $this->input->post('usertoken');
        $uid = $this->input->post('userid');

        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral App';
        $main_arr['info']['description'] = 'User data update via app';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        if (empty($uid) || empty($utoken)) {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = '';
            $main_arr['info']['response']['message'] = 'Please send valid User ID and token to verify details';
            storemylog("User data update via app", "api/v1/users/updateuser", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'Please send valid User ID and token to verify details');
        } else {
            $check_user = check_user($uid, $utoken);
            if ($check_user > 0) {
                $this->db->select("*,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
                $udata = $this->db->get_where("snr_users", ['id' => $uid, 'usertoken' => $utoken])->result();

                $val = array();
                $token = substr(time(), -6) . openssl_random_pseudo_bytes(16);
                $token = bin2hex($token);

                if (!empty($this->input->post('title'))) {
                    $val['usertitle'] = $this->input->post('title');
                }
                if (!empty($this->input->post('firstname'))) {
                    $val['userfname'] = $this->input->post('firstname');
                }
                if (!empty($this->input->post('lastname'))) {
                    $val['userlname'] = $this->input->post('lastname');
                }
                if (!empty($this->input->post('churchtitle'))) {
                    $val['userchurchtitle'] = strtoupper($this->input->post('churchtitle'));
                }
                if (!empty($this->input->post('phone'))) {
                    $val['userphone'] = $this->input->post('phone');
                }
                if (!empty($this->input->post('gender'))) {
                    $val['usergender'] = $this->input->post('gender');
                }
                if (!empty($this->input->post('dob'))) {
                    $val['userdob'] = strtoupper($this->input->post('dob'));
                }
                if (!empty($this->input->post('address'))) {
                    $val['useraddress'] = $this->input->post('address');
                }
                if (!empty($this->input->post('country'))) {
                    $val['usercountry'] = $this->input->post('country');
                }
                if (!empty($this->input->post('province'))) {
                    $val['userprovince'] = $this->input->post('province');
                }
                if (!empty($this->input->post('district'))) {
                    $val['userdistrict'] = strtoupper($this->input->post('district'));
                }
                if (!empty($this->input->post('branch'))) {
                    $val['userbranch'] = $this->input->post('branch');
                }
                if (!empty($this->input->post('cell'))) {
                    $val['usercell'] = $this->input->post('cell');
                }
                $val['usertoken'] = $token;

                $this->db->where('id', $uid);
                $this->db->update('snr_users', $val);
                $updateID = $this->db->affected_rows();

                $main_arr['api_version'] = '1.0';
                $main_arr['info']['title'] = 'The Funeral App';

                if (!empty($updateID)) {
                    $this->db->select("*,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
                    $data = $this->db->get_where("snr_users", ['usermail' => $udata[0]->usermail, 'id' => $uid])->result();

                    $main_arr['info']['response']['status'] = '1';
                    $main_arr['info']['response']['data'] = $data;
                    $main_arr['info']['response']['message'] = "Your profile has been updated successfully";

                    storemylog("User data update via app", "api/v1/users/updateuser", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], "Your profile has been updated successfully");
                } else {
                    $this->db->select("*,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
                    $data = $this->db->get_where("snr_users", ['usermail' => $udata[0]->usermail, 'id' => $uid])->result();
                    $main_arr['info']['response']['status'] = '1';
                    $main_arr['info']['response']['data'] = $data;
                    $main_arr['info']['response']['message'] = 'Your profile has been updated successfully';

                    storemylog("User data update via app", "api/v1/users/updateuser", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], json_encode($data));
                }
            } else {
                $main_arr['info']['response']['status'] = '0';
                $main_arr['info']['response']['data'] = '';
                $main_arr['info']['response']['message'] = 'Either user do not exist or Token has been changed';

                storemylog("User data update via app", "api/v1/users/updateuser", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'Either user do not exist or Token has been changed');
            }

        }
        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function editpassword_post()
    {
        $userid = $this->input->post('userid');
        $usertoken = $this->input->post('usertoken');
        $oldpassword = $this->input->post('oldpassword');
        $newpassword = $this->input->post('newpassword');
        $confirmpassword = $this->input->post('confirmpassword');

        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral App';

        $main_arr['info']['description'] = 'User Password Edit';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        if (empty($oldpassword) || empty($newpassword) || empty($confirmpassword)) {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = '';
            $main_arr['info']['response']['message'] = 'Empty values not allowed, please check';

            storemylog("User Password Edit", "api/v1/users/editpassword", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'Empty values not allowed, please check');
        } else {
            $check_user = check_user($userid, $usertoken);
            if ($check_user > 0) {
                $udata = get_user_info($userid);
                // print_r($udata);
                if (MD5($oldpassword) === $udata[0]->userpassword) {
                    if ($newpassword === $confirmpassword) {
                        $hashedpas = MD5($newpassword);

                        $token = substr(time(), -6) . openssl_random_pseudo_bytes(16);
                        $token = bin2hex($token);
                        $val['usertoken'] = $token;
                        $val['userpassword'] = $hashedpas;

                        $this->db->where('id', $userid);
                        $this->db->update('snr_users', $val);
                        $updateID = $this->db->affected_rows();

                        if (!empty($updateID)) {
                            $this->db->select("*,DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(userdob, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(userdob, '00-%m-%d')) AS age");
                            $uddata = $this->db->get_where("snr_users", ['usermail' => $udata[0]->usermail, 'id' => $userid])->result();
                            $unewarray = array(
                                "id" => $uddata[0]->id,
                                "userrole" => $uddata[0]->userrole,
                                "uniqueid" => $uddata[0]->uniqueid,
                                "usertitle" => $uddata[0]->usertitle,
                                "userfname" => $uddata[0]->userfname,
                                "userlname" => $uddata[0]->userlname,
                                "userchurchtitle" => $uddata[0]->userchurchtitle,
                                "usermail" => $uddata[0]->usermail,
                                "userphone" => $uddata[0]->userphone,
                                "usergender" => $uddata[0]->usergender,
                                "userdob" => $uddata[0]->userdob,
                                "useraddress" => $uddata[0]->useraddress,
                                "usercountry" => $uddata[0]->usercountry,
                                "country_name" => country_name($uddata[0]->usercountry)->country_name,
                                "userprovince" => $uddata[0]->userprovince,
                                "province_name" => province_name($uddata[0]->userprovince)->provincename,
                                "userdistrict" => $uddata[0]->userdistrict,
                                "district_name" => district_name($uddata[0]->userdistrict)->district_name,
                                "userbranch" => $uddata[0]->userbranch,
                                "branch_name" => branch_name($uddata[0]->userbranch)->branch_name,
                                "usercell" => $uddata[0]->usercell,
                                "cell_name" => cell_name($uddata[0]->usercell)->cell_name,
                                "userstatus" => $uddata[0]->userstatus,
                                "userregistered" => $uddata[0]->id,
                                "usertoken" => $uddata[0]->usertoken
                            );
                            $main_arr['info']['response']['status'] = '1';
                            $main_arr['info']['response']['data'] = $unewarray;
                            $main_arr['info']['response']['message'] = "Your password has been changed successfully";

                            storemylog("User Password Edit", "api/v1/users/editpassword", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($unewarray));
                        } else {
                            $main_arr['info']['response']['status'] = '0';
                            $main_arr['info']['response']['data'] = '';
                            $main_arr['info']['response']['message'] = 'System Error, Please try again!';

                            storemylog("User Password Edit", "api/v1/users/editpassword", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'System Error, Please try again!');
                        }
                    } else {
                        $main_arr['info']['response']['status'] = '0';
                        $main_arr['info']['response']['data'] = '';
                        $main_arr['info']['response']['message'] = 'New Password and Confirm Password not matching';

                        storemylog("User Password Edit", "api/v1/users/editpassword", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'New Password and Confirm Password not matching');
                    }
                } else {
                    $main_arr['info']['response']['status'] = '0';
                    $main_arr['info']['response']['data'] = '';
                    $main_arr['info']['response']['message'] = 'Incorrect Old Password';

                    storemylog("User Password Edit", "api/v1/users/editpassword", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'Incorrect Old Password');
                }
            } else {
                $main_arr['info']['response']['status'] = '0';
                $main_arr['info']['response']['data'] = '';
                $main_arr['info']['response']['message'] = 'Either user do not exist or Token has been changed';

                storemylog("User Password Edit", "api/v1/users/editpassword", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'Either user do not exist or Token has been changed');
            }
        }
        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function getalluser_post()
    {
        $branch = $this->input->post('branchid');
        $cell = $this->input->post('cellid');
        $userid = $this->input->post('userid');

        $main_arr['info']['description'] = 'Get All User for Treasurer';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $this->db->select('id, usertitle, userfname, userlname, userregistered, userphone, useraddress, userbranch, usercell');
        $this->db->from('snr_users');
        $this->db->where(array("usercell" => $cell, "id<>" => $userid));
        $usersinfo = $this->db->get()->result();

        if (count($usersinfo) > 0) {
            $newuserarray = array();
            $i = 0;
            foreach ($usersinfo as $user) {
                $totaldonation = get_total_donation($user->id);
                $totalpolicy = get_total_policy($user->id);
                $userarray = array();
                $userarray = array(
                    "name" => $user->usertitle . ' ' . $user->userfname . ' ' . $user->userlname,
                    "joined" => date("jS M, Y", strtotime($user->userregistered)),
                    "phone" => $user->userphone,
                    "address" => $user->useraddress,
                    "branch" => branch_name($user->userbranch)->branch_name,
                    "cell" => cell_name($user->usercell)->cell_name,
                    "total_donation" => "$ " . $totaldonation->totdon,
                    "total_policy_purchased" => $totalpolicy
                );
                array_push($newuserarray, $userarray);
                $i++;
            }
            // $newuserarray['total_member'] = count($newuserarray);
            $main_arr['info']['response']['total_member'] = count($newuserarray);
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $newuserarray;
            $main_arr['info']['response']['message'] = "Executed Successfully";

            storemylog("Get All User for Treasurer", "api/v1/users/getallusers", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], "Executed Successfully");
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = "";
            $main_arr['info']['response']['message'] = "No user found in your cell, please try again";

            storemylog("Get All User for Treasurer", "api/v1/users/getallusers", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], "No user found, please try again");
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);

    }

    public function getuser_post()
    {
        $uid = $this->input->post('userid');
        $usertoken = $this->input->post('usertoken');

        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral App';

        $main_arr['info']['description'] = 'User Details';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $this->db->select("*");
        $uddata = $this->db->get_where("snr_users", ['id' => $uid, "usertoken" => $usertoken])->result();

        $unewarray = array(
            "id" => $uddata[0]->id,
            "userrole" => $uddata[0]->userrole,
            "uniqueid" => $uddata[0]->uniqueid,
            "usertitle" => $uddata[0]->usertitle,
            "userfname" => $uddata[0]->userfname,
            "userlname" => $uddata[0]->userlname,
            "userchurchtitle" => $uddata[0]->userchurchtitle,
            "usermail" => $uddata[0]->usermail,
            "userphone" => $uddata[0]->userphone,
            "usergender" => $uddata[0]->usergender,
            "userdob" => substr($uddata[0]->userdob, 0, 10),
            "useraddress" => $uddata[0]->useraddress,
            "usercountry" => $uddata[0]->usercountry,
            "country_name" => country_name($uddata[0]->usercountry)->country_name,
            "userprovince" => $uddata[0]->userprovince,
            "province_name" => province_name($uddata[0]->userprovince)->provincename,
            "userdistrict" => $uddata[0]->userdistrict,
            "district_name" => district_name($uddata[0]->userdistrict)->district_name,
            "userbranch" => $uddata[0]->userbranch,
            "branch_name" => branch_name($uddata[0]->userbranch)->branch_name,
            "usercell" => $uddata[0]->usercell,
            "cell_name" => cell_name($uddata[0]->usercell)->cell_name,
            "userstatus" => $uddata[0]->userstatus,
            "membersince" => $uddata[0]->userregistered,
            "usertoken" => $uddata[0]->usertoken
        );

        $data['userinfo'] = $unewarray;

        $this->db->select("*");
        $this->db->from('snr_donation');
        $this->db->where('donation_by', $uid);
        $this->db->where('final_status', '1');
        $this->db->order_by('added_on', 'DESC');
        $qry = $this->db->get();
        $donation = $qry->result();

        $donatearray = array();
        $this->db->select('*');
        $qr = $this->db->get('snr_admin');
        $admin_cont = $qr->row();

        $totaldonationpaid = 0;
        foreach ($donation as $dn) {
            $totaldonationpaid = $totaldonationpaid + $dn->donation_amount;
            $infoarray = array(
                "logoimage" => base_url() . "uploads/admin/" . $admin_cont->admin_image,
                "date" => date("jS M, Y", strtotime($dn->added_on)),
                "transactionid" => $dn->transaction_id,
                "amount" => "$ " . $dn->donation_amount,
                "paymentmode" => $dn->donation_mode
            );
            array_push($donatearray, $infoarray);
        }
        $data['donationinfo'] = $donatearray;

        $this->db->select('snr_policypurchase.*, snr_policies.policy_title, snr_policies.policy_id, snr_transactions.purchase_for, snr_transactions.gross_amount, snr_users.uniqueid');
        $this->db->from('snr_policypurchase');
        $this->db->join('snr_policies', 'snr_policies.id = snr_policypurchase.policy_id');
        $this->db->join('snr_users', 'snr_users.id = snr_policypurchase.user_id');
        $this->db->join('snr_transactions', 'snr_transactions.purchase_id = snr_policypurchase.id');
        $this->db->where('snr_policypurchase.user_id', $uid);
        $this->db->where('snr_policypurchase.status', '1');
        $this->db->order_by('snr_policypurchase.added_on', 'DESC');
        $qrypp = $this->db->get();
        $policypurchaseArray = $qrypp->result();

        // echo "<pre>";
        // print_r($policypurchaseArray);
        // echo "</pre>";

        $policyinfo = array();
        $totalpolicypaid = 0;
        foreach ($policypurchaseArray as $policypurchase) {
            $totalpolicypaid = $totalpolicypaid + $policypurchase->gross_amount;
            array_push(
                $policyinfo,
                array(
                    "policy_name" => $policypurchase->policy_title,
                    "logoimage" => base_url() . "uploads/admin/" . $admin_cont->admin_image,
                    "activesince" => date("jS M, Y", strtotime($policypurchase->added_on)),
                    "purchasefor" => $policypurchase->purchase_for,
                    "membershipid" => $uddata[0]->uniqueid,
                    "policyid" => $policypurchase->policy_id
                )
            );
        }

        $data['policyinfo'] = $policyinfo;


        $this->db->select('snr_transactions.`gross_amount`, snr_transactions.added_on, snr_users.uniqueid, snr_policies.policy_title');
        $this->db->from('snr_transactions');
        $this->db->join('snr_policies', 'snr_policies.id = snr_transactions.policy_id');
        $this->db->join('snr_policypurchase', 'snr_policypurchase.policy_id = snr_transactions.policy_id');
        $this->db->join('snr_users', 'snr_users.id = snr_transactions.user_id');
        $this->db->where('snr_transactions.user_id', $uid);
        $this->db->where('snr_policypurchase.status', '1');
        $this->db->order_by('snr_transactions.added_on', 'DESC');
        $qrytrxn = $this->db->get();
        $trxnArray = $qrytrxn->result();

        $transarray = array();

        foreach ($trxnArray as $trxn) {
            array_push(
                $transarray,
                array(
                    "policy_name" => $trxn->policy_title,
                    "logoimage" => base_url() . "uploads/admin/" . $admin_cont->admin_image,
                    "transactiondate" => date("Y-m-d", strtotime($trxn->added_on)),
                    "amountpaid" => "$ " . $trxn->gross_amount,
                    "membershipid" => $uddata[0]->uniqueid,
                )
            );
        }

        $data['transactioninfo'] = $transarray;

        $data['totalpolicypaid'] = (string) $totalpolicypaid;
        $data['totaldonationpaid'] = (string) $totaldonationpaid;

        $this->db->select('*');
        $qrb = $this->db->get('snr_branches');
        $branch_list = $qrb->result();

        $this->db->select('*');
        $qrc = $this->db->get('snr_cells');
        $cell_list = $qrc->result();

        $this->db->select('*');
        $qr = $this->db->get('snr_countries');
        $countries = $qr->result();

        $data['branches'] = $branch_list;
        $data['cells'] = $cell_list;

        $x = 0;
        foreach ($countries as $country) {
            $this->db->select('*');
            $this->db->where('country', $country->id);
            $cqr = $this->db->get('snr_province');
            $cdata = $cqr->result();
            $j = 0;
            foreach ($cdata as $province) {
                $this->db->select('*');
                $this->db->where('province_name', $province->provincename);
                $dqr = $this->db->get('snr_districts');
                $dddata = $dqr->result();
                $cdata[$j]->district = $dddata;
                $j++;
            }
            $countries[$x]->province = $cdata;
            $x++;
        }

        $data['countries'] = $countries;

        if (count($uddata) > 0) {

            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $data;
            $main_arr['info']['response']['message'] = "Executed Successfully";

            storemylog("User Details", "api/v1/users/getuser", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($data));
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = "No user found, please try again";
            $main_arr['info']['response']['message'] = "Error";

            storemylog("User Details", "api/v1/users/getuser", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], "No user found, please try again");
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function lastdonation_post()
    {
        $uid = $this->input->post('userid');

        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral App';

        $main_arr['info']['description'] = 'User Last Donation Details';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $this->db->select("*");
        $this->db->from('snr_donation');
        $this->db->where('donation_by', $uid);
        $this->db->order_by('added_on', 'DESC');
        $qry = $this->db->get();
        $donation = $qry->result();

        if (!empty($donation[0]->event_id)) {
            $event = get_programme($donation[0]->event_id)->title;
        } else {
            $event = "";
        }

        $unewarray = array(
            "id" => $donation[0]->id,
            "branch" => $donation[0]->branch,
            "branch_name" => branch_name($donation[0]->branch)->branch_name,
            "cell" => $donation[0]->cell,
            "cell_name" => cell_name($donation[0]->cell)->cell_name,
            "userchurchtitle" => $donation[0]->church_title,
            "currency" => $donation[0]->currency,
            "donation_amount" => $donation[0]->donation_amount,
            "donation_mode" => $donation[0]->donation_mode,
            "transaction_id" => $donation[0]->transaction_id,
            "payment_id" => $donation[0]->paynowreference,
            "event" => $event,
            "description" => $donation[0]->description,
            "status" => $donation[0]->status,
            "pollurl" => $donation[0]->pollurl,
            "hash" => $donation[0]->hash,
            "final_status" => $donation[0]->final_status,
            "transaction_date" => $donation[0]->added_on
        );

        if (count($donation) > 0) {

            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $unewarray;
            $main_arr['info']['response']['message'] = "Executed Successfully";

            storemylog("User Last Donation Details", "api/v1/users/lastdonation", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($unewarray));
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = "";
            $main_arr['info']['response']['message'] = "No donation found, please try again";

            storemylog("User Last Donation Details", "api/v1/users/lastdonation", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], "No donation found, please try again");
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function getdonation_post()
    {
        $uid = $this->input->post('userid');

        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral App';

        $main_arr['info']['description'] = 'User Donation History';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $this->db->select("*");
        $this->db->from('snr_donation');
        $this->db->where('donation_by', $uid);
        $this->db->order_by('added_on', 'DESC');
        $qry = $this->db->get();
        $donations = $qry->result();

        $newdonatearray = array();
        foreach ($donations as $donation) {

            if (!empty($donation->event_id)) {
                $event = get_programme($donation->event_id)->title;
            } else {
                $event = "";
            }
            $unewarray = array(
                "id" => $donation->id,
                "branch" => $donation->branch,
                "branch_name" => branch_name($donation->branch)->branch_name,
                "cell" => $donation->cell,
                "cell_name" => cell_name($donation->cell)->cell_name,
                "userchurchtitle" => $donation->church_title,
                "currency" => $donation->currency,
                "donation_amount" => $donation->donation_amount,
                "donation_mode" => $donation->donation_mode,
                "transaction_id" => $donation->transaction_id,
                "payment_id" => $donation->paynowreference,
                "event" => $event,
                "description" => $donation->description,
                "status" => $donation->status,
                "pollurl" => $donation->pollurl,
                "hash" => $donation->hash,
                "final_status" => $donation->final_status,
                "transaction_date" => $donation->added_on
            );
            array_push($newdonatearray, $unewarray);
        }

        if (count($donations) > 0) {

            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $newdonatearray;
            $main_arr['info']['response']['message'] = "Executed Successfully";

            storemylog("User Donation History", "api/v1/users/getdonation", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($newdonatearray));
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = "";
            $main_arr['info']['response']['message'] = "No donation found, please try again";


            storemylog("User Donation History", "api/v1/users/getdonation", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], "No donation found, please try again");
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function treasuretransactionhistory_post()
    {
        $uid = $this->input->post('userid');

        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral App';

        $main_arr['info']['description'] = 'Treasurer Transaction History (Self)';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $this->db->select("*");
        $uddata = $this->db->get_where("snr_users", ['id' => $uid])->result();

        $this->db->select("*");
        $this->db->from("snr_transactions");
        $this->db->where("treasurer", $uid);
        $this->db->order_by("next_date", "DESC");
        $qr = $this->db->get();
        $tdata = $qr->result();

        $tarray = array();
        if (!empty($tdata)) {            
            foreach ($tdata as $transdata) {
                array_push(
                    $tarray,
                    array(
                        "policy_name" => policy_info($transdata->policy_id)->policy_title,
                        "last_paid_date" => substr($transdata->added_on, 0, 10),
                        "next_date" => substr($transdata->next_date, 0, 10),
                        "paid_for" => $transdata->payment_frequency . " months",
                        "transaction_id" => $transdata->transaction_id,
                        "total_amount" => $transdata->gross_amount
                    )
                );
            }

            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $tarray;
            $main_arr['info']['response']['message'] = "";

            storemylog("Treasurer Transaction History (Self)", "api/v1/users/treasuretransactionhistory", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($tarray));

        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = $tarray;
            $main_arr['info']['response']['message'] = 'No transaction records found.';

            storemylog("Treasurer Transaction History (Self)", "api/v1/users/treasuretransactionhistory", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], 'No transaction records found.');
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function usertransactionhistory_post()
    {
        $uid = $this->input->post('userid');

        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral App';

        $main_arr['info']['description'] = 'User Transaction History (Self)';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $this->db->select("snr_transactions.*, snr_policypurchase.status");
        $this->db->from("snr_transactions");
        $this->db->join("snr_policypurchase", "snr_policypurchase.policy_id = snr_transactions.policy_id");
        $this->db->where("snr_transactions.user_id", $uid);
        $this->db->where("snr_policypurchase.status", "1");
        $this->db->order_by("snr_transactions.next_date", "DESC");
        $qr = $this->db->get();
        $tdata = $qr->result();

        if (!empty($tdata)) {
            $tarray = array();
            foreach ($tdata as $transdata) {
                array_push(
                    $tarray,
                    array(
                        "policy_name" => policy_info($transdata->policy_id)->policy_title,
                        "last_paid_date" => substr($transdata->added_on, 0, 10),
                        "next_date" => substr($transdata->next_date, 0, 10),
                        "paid_for" => $transdata->payment_frequency . " months",
                        "transaction_id" => $transdata->transaction_id,
                        "total_amount" => "$ " . $transdata->gross_amount
                    )
                );
            }
            $data['transaction_list'] = $tarray;
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $data;
            $main_arr['info']['response']['message'] = "";

            storemylog("User Transaction History (Self)", "api/v1/users/usertransactionhistory", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($data));
        } else {
            $data['transaction_list'] = array();
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = $data;
            $main_arr['info']['response']['message'] = "No transaction records found.";

            storemylog("User Transaction History (Self)", "api/v1/users/usertransactionhistory", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], "No transaction records found.");
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function treasuretransactionhistory_member_post()
    {
        $uid = $this->input->post('userid');
        $udata = get_user_info($uid);

        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral App';

        $main_arr['info']['description'] = 'Treasurer Transaction History (Member)';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $this->db->select("snr_transactions.*, snr_users.usertitle, snr_users.userfname, snr_users.userlname, snr_users.userbranch, snr_users.usercell, snr_users.uniqueid, snr_policies.*");
        $this->db->from('snr_transactions');
        $this->db->join('snr_users', 'snr_users.id = snr_transactions.user_id');
        $this->db->join('snr_policies', 'snr_policies.id = snr_transactions.policy_id');
        $this->db->where('snr_transactions.final_status', '1');
        $this->db->where('snr_users.usercell', $udata[0]->usercell);
        $qr = $this->db->get();
        $tdata = $qr->result();

        // echo "<pre>";
        // print_r($tdata);
        // echo "</pre>";

        $final_data = array();
        foreach ($tdata as $trans) {
            array_push(
                $final_data,
                array(
                    "policy_name" => $trans->policy_title,
                    "membership_id" => $trans->uniqueid,
                    "date" => date("jS F, Y", strtotime($trans->added_on)),
                    "full_name" => $trans->usertitle . ' ' . $trans->userfname . ' ' . $trans->userlname,
                    "cell" => cell_name($trans->usercell)->cell_name,
                    "branch" => branch_name($trans->userbranch)->branch_name,
                    "total_amount" => "$ " . $trans->gross_amount
                )
            );
        }

        $main_arr['info']['response']['status'] = '1';
        $main_arr['info']['response']['data'] = $final_data;
        $main_arr['info']['response']['message'] = "";

        storemylog("Treasurer Transaction History (Member)", "api/v1/users/treasuretransactionhistory_member", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($tdata));

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function treasurerdonation_post()
    {
        $uid = $this->input->post('userid');
        $udata = get_user_info($uid);

        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral App';

        $main_arr['info']['description'] = 'Treasurer Donation History (Member)';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $this->db->select('snr_donation.*, snr_users.uniqueid, snr_users.usertitle, snr_users.userfname, snr_users.userlname, snr_users.usercell');
        $this->db->from('snr_donation');
        $this->db->join('snr_users', 'snr_users.id=snr_donation.donation_by');
        $this->db->where(array('snr_donation.final_status' => '1', 'snr_users.usercell' => $udata[0]->usercell));
        $this->db->order_by('snr_donation.added_on', 'DESC');
        $qry = $this->db->get();
        $donatedata = $qry->result();

        $newarray = array();
        foreach ($donatedata as $donation) {
            array_push(
                $newarray,
                array(
                    "membership_id" => $donation->uniqueid,
                    "date" => date("j F, Y h:i:s A", strtotime($donation->added_on)),
                    "full_name" => $donation->usertitle . ' ' . $donation->userfname . ' ' . $donation->userlname,
                    "cell" => cell_name($donation->cell)->cell_name,
                    "branch" => branch_name($donation->branch)->branch_name,
                    "total_amount" => "$ " . $donation->donation_amount
                )
            );
        }

        if (count($donatedata) > 0) {
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $newarray;
            $main_arr['info']['response']['message'] = "";

            storemylog("Treasurer Donation History (Member)", "api/v1/users/treasurerdonation", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($newarray));
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = "";
            $main_arr['info']['response']['message'] = "No Donation Record Found.";

            storemylog("Treasurer Donation History (Member)", "api/v1/users/treasurerdonation", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], "No Donation Record Found.");
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

    public function userlist_post()
    {
        $uid = $this->input->post('userid');

        $main_arr['api_version'] = '1.0';
        $main_arr['info']['title'] = 'The Funeral App';

        $main_arr['info']['description'] = 'User List Dropdown for Treasurer Cash payment entry';
        $main_arr['info']['generate_time'] = date('d-m-Y H:i:s');
        $main_arr['info']['method'] = 'POST';

        $this->db->select('id, usertitle, userfname, userlname');
        $this->db->where('userrole', 3);
        $this->db->order_by('userfname', 'ASC');
        $this->db->from('snr_users');
        $qry = $this->db->get();
        $userdata = $qry->result();

        $newarray = array();
        foreach ($userdata as $users) {
            array_push(
                $newarray,
                array(
                    "id" => $users->id,
                    "full_name" => $users->usertitle . ' ' . $users->userfname . ' ' . $users->userlname,
                )
            );
        }

        if (count($userdata) > 0) {
            $main_arr['info']['response']['status'] = '1';
            $main_arr['info']['response']['data'] = $newarray;
            $main_arr['info']['response']['message'] = "";

            storemylog("User List Dropdown for Treasurer Cash payment entry", "api/v1/users/userlist", "POST", json_encode($_POST), "1", $_SERVER['REMOTE_ADDR'], json_encode($newarray));
        } else {
            $main_arr['info']['response']['status'] = '0';
            $main_arr['info']['response']['data'] = "";
            $main_arr['info']['response']['message'] = "No Donation Record Found.";

            storemylog("User List Dropdown for Treasurer Cash payment entry", "api/v1/users/userlist", "POST", json_encode($_POST), "0", $_SERVER['REMOTE_ADDR'], "No User Found.");
        }

        $this->response($main_arr, REST_Controller::HTTP_OK);
    }

}