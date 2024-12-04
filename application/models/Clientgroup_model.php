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



class Clientgroup_model extends CI_Model

{





    public function details($id)

    {



        $this->db->select('*');

        $this->db->from('geopos_customer_type');

        $this->db->where('id', $id);

        $query = $this->db->get();

        return $query->row_array();

    }



    public function recipients($id)

    {



        $this->db->select('name,email');

        $this->db->from('geopos_customers');

        $this->db->where('gid', $id);

        $query = $this->db->get();

        return $query->result_array();

    }





    public function add($group_name, $group_desc)

    {

        $data = array(

            'name' => $group_name,

            'summary' => $group_desc,
            'loc' => $this->session->userdata('set_firma_id')

        );



        if ($this->db->insert('geopos_customer_type', $data)) {

              $this->aauth->applog("[Group Created] $group_name ID ".$this->db->insert_id(),$this->aauth->get_user()->username);

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('ADDED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }





    public function editgroupupdate($gid, $group_name, $group_desc)

    {

        $data = array(

            'name' => $group_name,

            'summary' => $group_desc

        );





        $this->db->set($data);

        $this->db->where('id', $gid);



        if ($this->db->update('geopos_customer_type')) {

            $this->aauth->applog("[Group updated] $group_name ID ".$gid,$this->aauth->get_user()->username);

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }

}