<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('sndsmstouser')) {
   function sndsmstousertest($code, $number, $message)
   {
      $curl = curl_init();

      curl_setopt_array(
         $curl,
         array(
            CURLOPT_URL => 'https://api.sandbox.africastalking.com/restless/send?username=sandbox&Apikey=e2263d244c6c8422596bf81091cba132f29b72b3b864fe41c9da5cf93f0f839b&to=+' . $code . $number . '&message=' . urlencode($message),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
         )
      );

      $response = curl_exec($curl);

      curl_close($curl);
   }
}

if (!function_exists('sndsmstouserlive')) {
   function sndsmstouserlive($number, $message, $user)
   {
      $curl = curl_init();

      curl_setopt_array(
         $curl,
         array(
            CURLOPT_URL => 'https://api.africastalking.com/restless/send?username=allcents263&Apikey=56a336084dec36719f09392a483777541642c4ad09fb77db26c9d6ef5ebeeb0a&to=+'.$number.'&message='.urlencode($message),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
         )
      );

      $response = curl_exec($curl);

      curl_close($curl);

      $CI = &get_instance();
      $smsArray = array("user_id"=> $user, "number" => $number, "message" => $message, "response" => json_encode($response));
      $CI->AdminModel->savesmsdata($smsArray);

   }
}