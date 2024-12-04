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



class General_model extends CI_Model

{

    public function __construct()

    {

        parent::__construct();

    }



    public function public_key()

    {

        $this->db->select('key1 AS recaptcha_p,key2 AS captcha,url AS recaptcha_s');

        $this->db->from('univarsal_api');

        $query = $this->db->get();

        $this->db->where('id', 53);

        return $query->row();

    }



    public function reset($key = '')

    {

        $file = APPPATH . "config/lic.php";

        $key_o = file_get_contents($file);

        if ($key == (string)$key_o) {

            file_put_contents($file, " ");

        }

    }



}