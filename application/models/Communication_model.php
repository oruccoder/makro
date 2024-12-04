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



defined('BASEPATH') OR exit('No direct script access allowed');





class Communication_model extends CI_Model

{



    public function __construct()

    {

        // parent::__construct();

    }



    public function send_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue = false, $attachment = '')

    {

        $this->load->library('ultimatemailer');

        $this->db->select('host,port,auth,auth_type,username,password,sender');

        $this->db->from('geopos_smtp');

        $query = $this->db->get();

        $smtpresult = $query->row_array();

        $host = $smtpresult['host'];

        $port = $smtpresult['port'];

        $auth = $smtpresult['auth'];

		$auth_type = $smtpresult['auth_type'];

        $username = $smtpresult['username'];;

        $password = $smtpresult['password'];

        $mailfrom = $smtpresult['sender'];

        $mailfromtilte = $this->config->item('ctitle');

        $this->ultimatemailer->onay_mail($host, $port, $auth, $auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);



    }

    public function send_general_crm($mailto, $mailtotitle, $subject, $message, $attachmenttrue = false, $attachment = '')

    {

        $this->load->library('ultimatemailer');

        $this->db->select('host,port,auth,auth_type,username,password,sender');

        $this->db->from('geopos_smtp');

        $query = $this->db->get();

        $smtpresult = $query->row_array();

        $host = $smtpresult['host'];

        $port = $smtpresult['port'];

        $auth = $smtpresult['auth'];

		$auth_type = $smtpresult['auth_type'];

        $username = $smtpresult['username'];;

        $password = $smtpresult['password'];

        $mailfrom = $smtpresult['sender'];

        $mailfromtilte = $this->config->item('ctitle');

        $this->ultimatemailer->send_general_crm($host, $port, $auth, $auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);



    }
    public function send_email_new($mailto, $mailtotitle, $subject, $message, $attachmenttrue = false, $attachment = '')

    {

        $this->load->library('ultimatemailer');

        $this->db->select('host,port,auth,auth_type,username,password,sender');

        $this->db->from('geopos_smtp');

        $query = $this->db->get();

        $smtpresult = $query->row_array();

        $host = $smtpresult['host'];

        $port = $smtpresult['port'];

        $auth = $smtpresult['auth'];

		$auth_type = $smtpresult['auth_type'];

        $username = $smtpresult['username'];;

        $password = $smtpresult['password'];

        $mailfrom = $smtpresult['sender'];

        $mailfromtilte = $this->config->item('ctitle');

        $this->ultimatemailer->load($host, $port, $auth, $auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);



    }

    public function send_email_eksik_siparis($recipients, $subject, $message, $attachmenttrue, $attachment)

    {

        $this->load->library('ultimatemailer');

        $this->db->select('host,port,auth,auth_type,username,password,sender');

        $this->db->from('geopos_smtp');

        $query = $this->db->get();

        $smtpresult = $query->row_array();

        $host = $smtpresult['host'];

        $port = $smtpresult['port'];

        $auth = $smtpresult['auth'];

        $auth_type = $smtpresult['auth_type'];

        $username = $smtpresult['username'];;

        $password = $smtpresult['password'];

        $mailfrom = $smtpresult['sender'];

        $mailfromtilte = $this->config->item('ctitle');

        $this->ultimatemailer->eksik_siparis_maili($host, $port, $auth, $auth_type, $username, $password, $mailfrom, $mailfromtilte, $recipients, $subject, $message, $attachmenttrue, $attachment);



    }


    public function onay_mail($recipients, $subject, $message, $attachmenttrue, $attachment,$tip)

    {

        $this->load->library('ultimatemailer');
        $this->db->select('host,port,auth,auth_type,username,password,sender');
        $this->db->from('geopos_smtp');
        $query = $this->db->get();

        $smtpresult = $query->row_array();

        $host = $smtpresult['host'];

        $port = $smtpresult['port'];

        $auth = $smtpresult['auth'];

        $auth_type = $smtpresult['auth_type'];

        $username = $smtpresult['username'];;

        $password = $smtpresult['password'];

        $mailfrom = $smtpresult['sender'];

        $mailfromtilte = $this->config->item('ctitle');

        $this->ultimatemailer->$tip($host, $port, $auth, $auth_type, $username, $password, $mailfrom, $mailfromtilte, $recipients, $subject, $message, $attachmenttrue, $attachment);



    }







    public function send_corn_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue = false, $attachment = '')

    {

        $this->load->library('ultimatemailer');

        $this->db->select('host,port,auth,auth_type,username,password,sender');

        $this->db->from('geopos_smtp');

        $query = $this->db->get();

        $smtpresult = $query->row_array();

        $host = $smtpresult['host'];

        $port = $smtpresult['port'];

        $auth = $smtpresult['auth'];

		$auth_type = $smtpresult['auth_type'];

        $username = $smtpresult['username'];;

        $password = $smtpresult['password'];

        $mailfrom = $smtpresult['sender'];

        $mailfromtilte = $this->config->item('ctitle');

        return $this->ultimatemailer->corn_mail($host, $port, $auth, $auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);



    }



    public function group_email($recipients, $subject, $message, $attachmenttrue, $attachment)

    {

        $this->load->library('ultimatemailer');

        $this->db->select('host,port,auth,auth_type,username,password,sender');

        $this->db->from('geopos_smtp');

        $query = $this->db->get();

        $smtpresult = $query->row_array();

        $host = $smtpresult['host'];

        $port = $smtpresult['port'];

        $auth = $smtpresult['auth'];

		$auth_type = $smtpresult['auth_type'];

        $username = $smtpresult['username'];;

        $password = $smtpresult['password'];

        $mailfrom = $smtpresult['sender'];

        $mailfromtilte = $this->config->item('ctitle');

        $this->ultimatemailer->group_load($host, $port, $auth, $auth_type, $username, $password, $mailfrom, $mailfromtilte, $recipients, $subject, $message, $attachmenttrue, $attachment);



    }

}