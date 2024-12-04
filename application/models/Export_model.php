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



class Export_model extends CI_Model

{





    public function customers()

    {





        $this->db->select('*');

        $this->db->from('geopos_customers');



        $query = $this->db->get();

        $result = $query->result_array();

        return $result;



    }





}