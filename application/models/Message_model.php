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



class Message_model extends CI_Model

{





    public function employee_details($id)

    {



        $this->db->select('geopos_employees.*');

        $this->db->from('geopos_employees');

        $this->db->where('geopos_pms.id', $id);

        $this->db->join('geopos_pms', 'geopos_employees.id = geopos_pms.sender_id', 'left');

        $query = $this->db->get();

        return $query->row_array();

    }





}