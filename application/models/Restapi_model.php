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





class Restapi_model extends CI_Model

{

    var $table = 'geopos_accounts';



    public function __construct()

    {

        parent::__construct();

    }



    public function keylist()

    {

        $this->db->select('*');

        $this->db->from('geopos_restkeys');

        $query = $this->db->get();

        return $query->result_array();

    }





    public function addnew()

    {



        $random = substr(md5(mt_rand()), 0, 24);

        $data = array(

            'user_id' => 0,

            'key' => $random,

            'level' => 0,

            'date_created' => date('Y-m-d')





        );



        if ($this->db->insert('geopos_restkeys', $data)) {

            return true;

        } else {

            return false;



        }



    }





}