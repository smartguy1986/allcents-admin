<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| EMAIL CONFING
| -------------------------------------------------------------------
| Configuration of outgoing mail server.
| */ 

$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'ssl://smtp.googlemail.com', 
    'smtp_port' => '465',
    'smtp_user' => 'scriptech.codes@gmail.com',
    'smtp_pass' => 'Abracadabra_86',
    'mailtype' => 'html', //plaintext 'text' mails or 'html'
    'charset' => 'iso-8859-1'
);

// $config = array(
//     'protocol' => 'sendmail', // 'mail', 'sendmail', or 'smtp'
//     'smtp_host' => 'localhost',
//     'smtp_port' => 25,
//     'smtp_user' => 'info@allcents.tech',
//     'smtp_pass' => 'Snt@2021#',
//     'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
//     'mailtype' => 'html', //plaintext 'text' mails or 'html'
//     'smtp_timeout' => '4', //in seconds
//     'charset' => 'utf-8',
//     'wordwrap' => TRUE
// );

/* End of file email.php */
/* Location: ./system/application/config/email.php */