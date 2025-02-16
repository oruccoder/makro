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



class Barcode_model extends CI_Model

{





    public function locations_list()

    {

        $query = $this->db->query("SELECT * FROM geopos_locations ORDER BY id DESC");

        return $query->result_array();

    }





  public function view($id)

    {



        $this->db->from('locations');

        $this->db->where('id', $id);



        $query = $this->db->get();

        $result = $query->row_array();

        return $result;





    }



    public function create($name,$address,$city,$region,$country,$postbox,$phone,$email,$taxid,$image)

    {

        $data = array(

            'cname' => $name,

             'address' => $address,

            'city' => $city,

               'region' => $region,

             'country' => $country,

             'postbox' => $postbox,

            'phone' => $phone,

               'email' => $email,

             'taxid' => $taxid,

            'logo' => $image

        );



        if ($this->db->insert('locations', $data)) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('ADDED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }



        public function edit($id,$name,$address,$city,$region,$country,$postbox,$phone,$email,$taxid,$image)

    {

        $data = array(

            'cname' => $name,

             'address' => $address,

            'city' => $city,

               'region' => $region,

             'country' => $country,

             'postbox' => $postbox,

            'phone' => $phone,

               'email' => $email,

             'taxid' => $taxid,

            'logo' => $image

        );



    $this->db->set($data);

        $this->db->where('id', $id);



        if ($this->db->update('locations')) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }



    public function addwarehouse($cat_name, $cat_desc)

    {

        $data = array(

            'title' => $cat_name,

            'extra' => $cat_desc

        );



        if ($this->db->insert('geopos_warehouse', $data)) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('ADDED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }





    public function editwarehouse($catid, $product_cat_name, $product_cat_desc)

    {

        $data = array(

            'title' => $product_cat_name,

            'extra' => $product_cat_desc

        );





        $this->db->set($data);

        $this->db->where('id', $catid);



        if ($this->db->update('geopos_warehouse')) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }





}