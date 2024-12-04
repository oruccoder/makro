<?php

/**
 * İtalic Soft Yazılım  ERP - CRM - HRM
 * Copyright (c) İtalic Soft Yazılım. Tüm Hakları Saklıdır.
 * ***********************************************************************
 *
 *  Email: info@italicsoft.com
 *  Website: https://www.italicsoft.com
 *  Tel: 0850 317 41 44
 *  ************************************************************************
 */


if (!defined('BASEPATH')) exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;

class Ultimatemailer

{



    public function __construct()

    {

        //$CI = &get_instance();

        //  log_message('Debug', 'mailer class is loaded.');



    }


    function onay_mail($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotilte, $subject, $message, $attachmenttrue, $attachment)

    {

        //include_once APPPATH . '/third_party/PHPMailer/vendor/autoload.php';

        include_once APPPATH . '/libraries/mail.php';
        $mail = new Mail();
        $mail->protocol = 'smtp';
        //$mail->parameter = $this->config->get('config_mail_parameter');
        $mail->smtp_hostname = 'ssl://smtp.yandex.com';
        $mail->smtp_username = 'info@makropro.az';
        $mail->smtp_password = 'bulut220618';
        $mail->smtp_port = '465';
        //$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

        $mail->setTo($mailto);
        $mail->setFrom('info@makropro.az');
        $mail->setSender($subject);
        $mail->setSubject($subject);
        $mail->setHtml($message);
        $mail->send();





    }

    function send_general_crm($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotilte, $subject, $message, $attachmenttrue, $attachment)

    {

        include_once APPPATH . '/third_party/PHPMailer/vendor/autoload.php';

        //Create a new PHPMailer instance

        $mail = new PHPMailer;

        $mail->CharSet = "UTF-8";



        $mail->isSMTP();

//Enable SMTP debugging

// 0 = off (for production use)

// 1 = client messages

// 2 = client and server messages

        $mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output

        $mail->Debugoutput = 'html';



        $mail->Host = $host;



        $mail->Port = $port;



        $mail->SMTPAuth = $auth;



        if($auth_type!='none') { $mail->SMTPSecure = $auth_type; }



        $mail->Username = $username;

//Password to use for SMTP authentication

        $mail->Password = $password;

//Set who the message is to be sent from

        $mail->setFrom($mailfrom, $mailfromtilte);

//Set an alternative reply-to address

//$mail->addReplyTo('replyto@example.com', 'First Last');

//Set who the message is to be sent to

        $mail->addAddress($mailto, $mailtotilte);

//Set the subject line

        $mail->Subject = $subject;

//Read an HTML message body from an external file, convert referenced images to embedded,

//convert HTML into a basic plain-text alternative body

        $mail->msgHTML($message);

//Replace the plain text body with one created manually

        $mail->AltBody = 'This is a html email';

//Attach an image file

        if ($attachmenttrue == true) {

            $mail->addAttachment($attachment);

        }



//send the message, check for errors

        if (!$mail->send()) {

            echo json_encode(array('status' => 'Error', 'message' => $mail->ErrorInfo));

        } else {

            echo json_encode(array('status' => 'Başarılı', 'message' => 'Email Başarılı Bir Şekilde İletildi!'));

        }





    }



    function load($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotilte, $subject, $message, $attachmenttrue, $attachment)

    {

        include_once APPPATH . '/third_party/PHPMailer/vendor/autoload.php';

        //Create a new PHPMailer instance

        $mail = new PHPMailer;

        $mail->CharSet = "UTF-8";



        $mail->isSMTP();

//Enable SMTP debugging

// 0 = off (for production use)

// 1 = client messages

// 2 = client and server messages

        $mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output

        $mail->Debugoutput = 'html';



        $mail->Host = $host;



        $mail->Port = $port;



        $mail->SMTPAuth = $auth;



        if($auth_type!='none') { $mail->SMTPSecure = $auth_type; }



        $mail->Username = $username;

//Password to use for SMTP authentication

        $mail->Password = $password;

//Set who the message is to be sent from

        $mail->setFrom($mailfrom, $mailfromtilte);

//Set an alternative reply-to address

//$mail->addReplyTo('replyto@example.com', 'First Last');

//Set who the message is to be sent to

        $mail->addAddress($mailto, $mailtotilte);

//Set the subject line

        $mail->Subject = $subject;

//Read an HTML message body from an external file, convert referenced images to embedded,

//convert HTML into a basic plain-text alternative body

        $mail->msgHTML($message);

//Replace the plain text body with one created manually

        $mail->AltBody = 'This is a html email';

//Attach an image file

        if ($attachmenttrue == true) {

            $mail->addAttachment($attachment);

        }



//send the message, check for errors

        if (!$mail->send()) {

            echo json_encode(array('status' => 'Error', 'message' => $mail->ErrorInfo));

        } else {

            echo json_encode(array('status' => 'Başarılı', 'message' => 'Email Başarılı Bir Şekilde İletildi!'));

        }





    }



    function corn_mail($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotilte, $subject, $message, $attachmenttrue, $attachment)

    {

        include_once APPPATH . '/third_party/PHPMailer/vendor/autoload.php';

        //Create a new PHPMailer instance

        $mail = new PHPMailer;

        $mail->CharSet = "UTF-8";



        $mail->isSMTP();

//Enable SMTP debugging

// 0 = off (for production use)

// 1 = client messages

// 2 = client and server messages

        $mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output

        $mail->Debugoutput = 'html';



        $mail->Host = $host;



        $mail->Port = $port;



        $mail->SMTPAuth = $auth;

        if($auth_type!='none') { $mail->SMTPSecure = $auth_type; }



        $mail->Username = $username;

//Password to use for SMTP authentication

        $mail->Password = $password;

//Set who the message is to be sent from

        $mail->setFrom($mailfrom, $mailfromtilte);

//Set an alternative reply-to address

//$mail->addReplyTo('replyto@example.com', 'First Last');

//Set who the message is to be sent to

        $mail->addAddress($mailto, $mailtotilte);

//Set the subject line

        $mail->Subject = $subject;

//Read an HTML message body from an external file, convert referenced images to embedded,

//convert HTML into a basic plain-text alternative body

        $mail->msgHTML($message);

//Replace the plain text body with one created manually

        $mail->AltBody = 'This is a html email';

//Attach an image file

        if ($attachmenttrue == true) {

            $mail->addAttachment($attachment);

        }



//send the message, check for errors

        if (!$mail->send()) {

            return false;

        } else {

            return true;

        }





    }



    function group_load($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $recipients, $subject, $message, $attachmenttrue, $attachment)

    {

        include_once APPPATH . '/third_party/PHPMailer/vendor/autoload.php';



        $mail = new PHPMailer;

        $mail->CharSet = "UTF-8";



        $mail->isSMTP();

//Enable SMTP debugging

// 0 = off (for production use)

// 1 = client messages

// 2 = client and server messages

        $mail->SMTPDebug = 0;



        $mail->Debugoutput = 'html';



        $mail->Host = $host;



        $mail->Port = $port;



        $mail->SMTPAuth = $auth;

        if($auth_type!='none') { $mail->SMTPSecure = $auth_type; }



        $mail->Username = $username;



        $mail->Password = $password;



        $mail->setFrom($mailfrom, $mailfromtilte);

        $mail->addAddress($mailfrom, $mailfromtilte);



        foreach ($recipients as $row) {



            $mail->setTo($row['email']);


        }



        $mail->Subject = $subject;



        $mail->msgHTML($message);



        $mail->AltBody = 'This is a html email';



        if ($attachmenttrue == true) {

            $mail->addAttachment($attachment);

        }





        if (!$mail->send()) {

            echo json_encode(array('status' => 'Error', 'message' => $mail->ErrorInfo));

        } else {

            echo json_encode(array('status' => 'Başarılı', 'message' => 'Başarıyla Mail İletildi!'));

        }





    }



    function bin_send($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotilte, $subject, $message, $attachmenttrue, $attachment)

    {

        include_once APPPATH . '/third_party/PHPMailer/vendor/autoload.php';

        //Create a new PHPMailer instance

        $mail = new PHPMailer;



//Tell PHPMailer to use SMTP

        $mail->isSMTP();

//Enable SMTP debugging

// 0 = off (for production use)

// 1 = client messages

// 2 = client and server messages

        $mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output

        $mail->Debugoutput = 'html';

//Set the hostname of the mail server

        $mail->Host = $host;

//Set the SMTP port number - likely to be 25, 465 or 587

        $mail->Port = $port;

//Whether to use SMTP authentication

        $mail->SMTPAuth = $auth;



//Username to use for SMTP authentication

        if($auth_type!='none') { $mail->SMTPSecure = $auth_type; }

        $mail->Username = $username;

//Password to use for SMTP authentication

        $mail->Password = $password;

//Set who the message is to be sent from

        $mail->setFrom($mailfrom, $mailfromtilte);

//Set an alternative reply-to address

//$mail->addReplyTo('replyto@example.com', 'First Last');

//Set who the message is to be sent to

        $mail->addAddress($mailto, $mailtotilte);

//Set the subject line

        $mail->Subject = $subject;

//Read an HTML message body from an external file, convert referenced images to embedded,

//convert HTML into a basic plain-text alternative body

        $mail->msgHTML($message);

//Replace the plain text body with one created manually

        $mail->AltBody = 'This is a html email';

//Attach an image file

        if ($attachmenttrue == true) {

            $mail->addAttachment($attachment);

        }



//send the message, check for errors

        if (!$mail->send()) {

            return 0;

        } else {

            return 1;

        }





    }


    function eksik_siparis_maili($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $recipients, $subject, $message, $attachmenttrue, $attachment)

    {

        include_once APPPATH . '/third_party/PHPMailer/vendor/autoload.php';



        $mail = new PHPMailer;

        $mail->CharSet = "UTF-8";



        $mail->isSMTP();

//Enable SMTP debugging

// 0 = off (for production use)

// 1 = client messages

// 2 = client and server messages

        $mail->SMTPDebug = 0;



        $mail->Debugoutput = 'html';



        $mail->Host = $host;



        $mail->Port = $port;



        $mail->SMTPAuth = $auth;

        if($auth_type!='none') { $mail->SMTPSecure = $auth_type; }



        $mail->Username = $username;



        $mail->Password = $password;



        $mail->setFrom($mailfrom, $mailfromtilte);

        $mail->addAddress($mailfrom, $mailfromtilte);



        foreach ($recipients as $row) {



            $mail->setTo($row['email']);

        }



        $mail->Subject = $subject;



        $mail->msgHTML($message);



        $mail->AltBody = 'This is a html email';



        if ($attachmenttrue == true) {

            $mail->addAttachment($attachment);

        }




        $mail->send();





    }

    function malzeme_talep_onay_maili($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $recipients, $subject, $message, $attachmenttrue, $attachment)

    {


        include_once APPPATH . '/libraries/mail.php';
        $mail = new Mail();
        $mail->protocol = 'smtp';
        //$mail->parameter = $this->config->get('config_mail_parameter');
        $mail->smtp_hostname = 'ssl://smtp.yandex.com';
        $mail->smtp_username = 'info@makropro.az';
        $mail->smtp_password = 'bulut220618';
        $mail->smtp_port = '465';
        //$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
        $mail->setFrom($mailfrom);

        foreach ($recipients as $row) {
            $mail->setTo($row);
        }
        $mail->setSender($subject);
        $mail->setSubject($subject);
        $mail->setHtml($message);
        $mail->send();




    }

    function avans_talep_onay_maili($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $recipients, $subject, $message, $attachmenttrue, $attachment)

    {

        include_once APPPATH . '/libraries/mail.php';
        $mail = new Mail();
        $mail->protocol = 'smtp';
        //$mail->parameter = $this->config->get('config_mail_parameter');
        $mail->smtp_hostname = 'ssl://smtp.yandex.com';
        $mail->smtp_username = 'info@makropro.az';
        $mail->smtp_password = 'bulut220618';
        $mail->smtp_port = '465';
        //$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
        $mail->setFrom($mailfrom);

        foreach ($recipients as $row) {



            $mail->setTo($row);

        }
        $mail->setSender($subject);
        $mail->setSubject($subject);
        $mail->setHtml($message);
        $mail->send();





    }


    function gider_talep_onay_maili($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $recipients, $subject, $message, $attachmenttrue, $attachment)

    {

        include_once APPPATH . '/libraries/mail.php';
        $mail = new Mail();
        $mail->protocol = 'smtp';
        //$mail->parameter = $this->config->get('config_mail_parameter');
        $mail->smtp_hostname = 'ssl://smtp.yandex.com';
        $mail->smtp_username = 'info@makropro.az';
        $mail->smtp_password = 'bulut220618';
        $mail->smtp_port = '465';

        if(!$mailfrom){
            $mailfrom='info@makropro.az';
        }
        //$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
        $mail->setFrom($mailfrom);

        foreach ($recipients as $row) {


        	$mail->setTo($row);

        }

        $mail->setSender($subject);
        $mail->setSubject($subject);
        $mail->setHtml($message);
        $mail->send();






    }

    function satin_alma_formu($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $recipients, $subject, $message, $attachmenttrue, $attachment)

    {

        include_once APPPATH . '/libraries/mail.php';
        $mail = new Mail();
        $mail->protocol = 'smtp';
        //$mail->parameter = $this->config->get('config_mail_parameter');
        $mail->smtp_hostname = 'ssl://smtp.yandex.com';
        $mail->smtp_username = 'info@makropro.az';
        $mail->smtp_password = 'bulut220618';
        $mail->smtp_port = '465';
        //$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
        $mail->setFrom($mailfrom);

        foreach ($recipients as $row) {

            $mail->setTo($row);

        }
        $mail->setSender($subject);
        $mail->setSubject($subject);
        $mail->setHtml($message);
        $mail->send();




    }


}