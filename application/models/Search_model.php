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



class Search_model extends CI_Model

{



    public function autoSearch($name)

    {





        $query = $this->db->query("SELECT pid,product_name,product_price FROM geopos_products WHERE UPPER(product_name) LIKE '" . strtoupper($name) . "%'");



        $result = $query->result_array();



        return $result;

    }

}



