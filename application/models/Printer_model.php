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





class Printer_model extends CI_Model

{

    var $table = 'geopos_config';



    public function __construct()

    {

        parent::__construct();

    }



    public function printers_list()

    {

        $this->db->select('*');

        $this->db->from('geopos_config');

          $this->db->where('type', 1);

        $query = $this->db->get();

        return $query->result_array();

    }

    public function printers_list_bilgi(){
         $pid = $this->input->post('id');
        $this->db->select('geopos_products.* , geopos_product_type.name AS type, geopos_product_cat.title AS category, geopos_warehouse.title AS warehouse,geopos_paketleme_tipi.name AS paketleme,
           geopos_units.name AS units');

        $this->db->from('geopos_products');
        $this->db->join('geopos_product_type', 'geopos_products.product_type = geopos_product_type.id');
        $this->db->join('geopos_product_cat', 'geopos_products.pcat = geopos_product_cat.id');
        $this->db->join('geopos_warehouse', 'geopos_products.warehouse   = geopos_warehouse.id');
        $this->db->join('geopos_paketleme_tipi', 'geopos_products.paketleme_tipi   = geopos_paketleme_tipi.id');
        $this->db->join('geopos_units','geopos_products.unit   = geopos_units.code');

        $this->db->where('geopos_products.pid', $pid);

        

        $query = $this->db->get();
        //$data = [];

        $this->db->select('*');
        $this->db->from('geopos_products');
        $this->db->where('parent_id', $pid);

        $query2 = $this->db->get();

        $data['product']  = $query->row_array();
        $data['children'] = $query2->result() ?? [];
       
        //var_dump($data);exit;
        
    }














      public function printer_details($id)

    {

        $this->db->select('*');

        $this->db->from('geopos_config');

          $this->db->where('id', $id);

          $this->db->where('type', 1);

        $query = $this->db->get();

        return $query->row_array();

    }





    public function create($p_name, $p_type, $p_connect, $lid,$mode)

    {

        $data = array(

            'type' => 1,

            'val1' => $p_name,

            'val2' => $p_type,

            'val3' => $p_connect,

            'val4' => $lid,

            'other' => $mode

        );

        if ($this->db->insert('geopos_config', $data)) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('ADDED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }

    }



    public function edit($id,$p_name, $p_type, $p_connect, $lid,$mode)

    {

         $data = array(

            'type' => 1,

            'val1' => $p_name,

            'val2' => $p_type,

            'val3' => $p_connect,

            'val4' => $lid,

             'other' => $mode

        );





        $this->db->set($data);

        $this->db->where('id', $id);



        if ($this->db->update('geopos_config')) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }





}