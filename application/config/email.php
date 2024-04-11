<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'smtp.hostinger.com', 
    'smtp_port' => 587,
    'smtp_user' => 'admin@zopzoi.in',
    'smtp_pass' => '1qaz2wsx#EDC',
    //'smtp_crypto' => 'ssl', //use only is ssl is applicable can be 'ssl' or 'tls' for example
    'mailtype' => 'text', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4', //in seconds
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE
);