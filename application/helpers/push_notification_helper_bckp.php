<?php
defined('BASEPATH') or exit('No direct script access allowed');

if(!function_exists('get_device_type')) {
    function get_device_type($regId_1)
    {
        $CI = & get_instance();
        $CI->db->select('devicetype');
        $CI->db->where('deviceid', $regId_1);
        $query = $CI->db->get('snr_users');
        return $query->row();
    }
}

if(!function_exists('send_push')) {
    function send_push($regId_1, $title_1, $message_1, $push_type_1, $not_id, $dtype)
    {
        $CI = & get_instance();
        error_reporting(-1);
        ini_set('display_errors', 'On');
 
        // require_once('../firebase/firebase.php');
        require_once('../firebase/push.php');
 
        //$firebase = new Firebase();
        $push = new Push();
        $stat_s =0;
 
        // optional payload
        $title = isset($title_1) ? $title_1 : '';
        $message = isset($message_1) ? $message_1 : '';
        $push_type = isset($push_type_1) ? $push_type_1 : '';

        $payload = array();
        $payload['page_name'] = '';
        $payload['pageData'] = '';     

        // //$regId = isset($regId_1) ? $regId_1 : '';
        // $response = $firebase->send($regId_1, $json);

        // print_r(json_encode($json));
        // die();
        // $resp = json_decode($response);

        // print_r(json_decode($response));
        

        // if($resp->success==1)
        // {
        //     echo $stat_s = 1;
        // }
        // // else
        // // {
        // //     echo $stat = 0;
        // // }
        // $val = array("not_status" => $stat_s, "not_response" => $response, "deviceid" => $regId_1);
        // $CI->db->where('id', $not_id);
        // $CI->db->update('snr_notifications', $val);
        
        // return $stat_s;

        $url = 'https://fcm.googleapis.com/fcm/send';
        if($dtype == "android"){    
            $push->setTitle($title);
            $push->setMessage($message);
            $push->setImage('http://localhost/arijit/allcents/admin/resources/appicons/pushbackimage.jpg');
            $push->setIsBackground(TRUE);
            $push->setPayload($payload);

            $stat_s = 0;
            $json = '';
            $response = '';
    
            $json = $push->getPush();
            $fields = array(
                'to' => $regId_1,
                'data' => $json,
                'priority' => 1,
            );
        }
        else {        
            $notification= array("title"=> $title_1, "body" => $message_1, "icon" => "http://localhost/arijit/allcents/admin/resources/appicons/pushbackimage.jpg", "sound" => "default", "image" => "http://localhost/arijit/allcents/admin/resources/appicons/pushbackimage.jpg");
            $fields = array(
                'to' => $regId_1,
                'notification' => $notification,
                'image' => 'http://localhost/arijit/allcents/admin/resources/appicons/pushbackimage.jpg',
                'priority' => 1,
                'payload' => $payload
            );
        }
        // Firebase API Key
        $headers = array('Authorization:key=AAAAJoEQkfs:APA91bFuX0RIbi3MgAQMzpPjuJM2GXRVnmfxwrzxttFJCNNCjpgs0MlGjOzQhpOPJt7RpRN_BzJqOZpk_I4yoOnWwH5_HGZH3Hz7AqFB6pArNhR_2EBGZXS8divqAk2fy_1BMEMKEbMC','Content-Type:application/json');
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
            $stat_s = 0;
            $val = array("not_status" => $stat_s, "not_response" => $result, "deviceid" => $regId_1);
            $CI->db->where('id', $not_id);
            $CI->db->update('snr_notifications', $val);
        }
        else
        {
            $stat_s = 1;
            $val = array("not_status" => $stat_s, "not_response" => $result, "deviceid" => $regId_1);
            $CI->db->where('id', $not_id);
            $CI->db->update('snr_notifications', $val);
        }
        curl_close($ch);

        $resp = json_decode($result);   

        if($resp->success==1)
        {
            echo $stat_s = 1;
        }
        // else
        // {
        //     echo $stat = 0;
        // }
        print_r(json_decode($result));

        return $stat_s;
    }
}

if(!function_exists('send_push_centre')) {
    function send_push_centre($regId_1, $title_1, $message_1, $push_type_1, $not_id, $centredata)
    {
        $CI = & get_instance();
        error_reporting(-1);
        ini_set('display_errors', 'On');
 
        require_once('../firebase/firebase.php');
        require_once('../firebase/push.php');
 
        $firebase = new Firebase();
        $push = new Push();
 
        // optional payload
        $payload = array();
        $payload['page_name'] = 'centerDetails';
        $payload['pageData'] = $centredata;
 
        // notification title
        $title = isset($title_1) ? $title_1 : '';
         
        // notification message
        $message = isset($message_1) ? $message_1 : '';
         
        // push type - single user / topic
        $push_type = isset($push_type_1) ? $push_type_1 : '';
         
        // whether to include to image or not
        // $include_image = isset($include_image_1) ? TRUE : FALSE;
 
 
        $push->setTitle($title);
        $push->setMessage($message);
        // if($include_image) {
        $push->setImage('http://localhost/arijit/allcents/admin/resources/appicons/pushbackimage-centre.jpg');
        // } else {
        //     $push->setimage('');
        // }
        $push->setIsBackground(TRUE);
        $push->setPayload($payload);
 
 
        $json = '';
        $response = '';
 
        $json = $push->getPush();
        $regId = isset($regId_1) ? $regId_1 : '';
        $response = $firebase->send($regId, $json);

        // print_r(json_encode($json));
        // die();
        $resp = json_decode($response);
        if($resp->success==1)
        {
            $stat = 1;
        }
        else
        {
            $stat = 0;
        }
        $val = array("not_status" => $stat, "not_response" => $response);
        $CI->db->where('id', $not_id);
        $CI->db->update('snr_notifications', $val);
        
        return $stat;
    }
}


if(!function_exists('send_profile_push')) {
    function send_profile_push($regId_1, $title_1, $message_1, $push_type_1, $not_id)
    {
        $CI = & get_instance();
        error_reporting(-1);
        ini_set('display_errors', 'On');
 
        require_once('../firebase/firebase.php');
        require_once('../firebase/push.php');
 
        $firebase = new Firebase();
        $push = new Push();
 
        // optional payload
        $payload = array();
        $payload['page_name'] = 'profile';
        $payload['pageData'] = '';
 
        // notification title
        $title = isset($title_1) ? $title_1 : '';
         
        // notification message
        $message = isset($message_1) ? $message_1 : '';
         
        // push type - single user / topic
        $push_type = isset($push_type_1) ? $push_type_1 : '';
         
        // whether to include to image or not
        // $include_image = isset($include_image_1) ? TRUE : FALSE;
 
 
        $push->setTitle($title);
        $push->setMessage($message);
        // if($include_image) {
        $push->setImage('http://localhost/arijit/allcents/admin/resources/appicons/pushbackimage-profile.jpg');
        // } else {
        //     $push->setimage('');
        // }
        $push->setIsBackground(TRUE);
        $push->setPayload($payload);
 
 
        $json = '';
        $response = '';
 
        $json = $push->getPush();
        $regId = isset($regId_1) ? $regId_1 : '';
        $response = $firebase->send($regId, $json);

        // print_r(json_encode($json));
        // die();
        $resp = json_decode($response);
        if($resp->success==1)
        {
            $stat = 1;
        }
        else
        {
            $stat = 0;
        }
        $val = array("not_status" => $stat, "not_response" => $response);
        $CI->db->where('id', $not_id);
        $CI->db->update('snr_notifications', $val);
        
        return $stat;
    }
}

if(!function_exists('send_booking_push')) {
    function send_booking_push($regId_1, $title_1, $message_1, $push_type_1, $not_id)
    {
        $CI = & get_instance();
        error_reporting(-1);
        ini_set('display_errors', 'On');
 
        require_once('../firebase/firebase.php');
        require_once('../firebase/push.php');
 
        $firebase = new Firebase();
        $push = new Push();
 
        // optional payload
        $payload = array();
        $payload['page_name'] = 'bookingHistory';
        $payload['pageData'] = '';
 
        // notification title
        $title = isset($title_1) ? $title_1 : '';
         
        // notification message
        $message = isset($message_1) ? $message_1 : '';
         
        // push type - single user / topic
        $push_type = isset($push_type_1) ? $push_type_1 : '';
         
        // whether to include to image or not
        // $include_image = isset($include_image_1) ? TRUE : FALSE;
 
        $push->setTitle($title);
        $push->setMessage($message);
        // if($include_image) {
        $push->setImage('http://localhost/arijit/allcents/admin/resources/appicons/pushbackimage-booking.jpg');
        // } else {
        //     $push->setimage('');
        // }
        $push->setIsBackground(TRUE);
        $push->setPayload($payload);
 
        $json = '';
        $response = '';
 
        $json = $push->getPush();
        $regId = isset($regId_1) ? $regId_1 : '';
        $response = $firebase->send($regId, $json);

        // print_r(json_encode($json));
        // die();
        $resp = json_decode($response);
        if($resp->success==1)
        {
            $stat = 1;
        }
        else
        {
            $stat = 0;
        }
        $val = array("not_status" => $stat, "not_response" => $response);
        $CI->db->where('id', $not_id);
        $CI->db->update('snr_notifications', $val);
        
        return $stat;
    }
}

