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



class Units_model extends CI_Model

{





    public function units_list()

    {

        $query = $this->db->query("SELECT * FROM geopos_units WHERE type=0 ORDER BY id DESC");

        return $query->result_array();

    }





    public function view($id)

    {



        $this->db->from('geopos_units');

        $this->db->where('id', $id);



        $query = $this->db->get();

        $result = $query->row_array();

        return $result;





    }



    public function create($name,$code)

    {

        $data = array(

            'name' => $name,

            'code' => $code

        );



        if ($this->db->insert('geopos_units', $data)) {

            $unit_id = $this->db->insert_id();
            $this->aauth->applog("Birim Oluşturuldu $unit_id ID ".$unit_id,$this->aauth->get_user()->username);
            kont_kayit(9,$unit_id);

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('ADDED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }



    public function edit($id,$name,$code)

    {

        $data = array(

            'name' => $name,

            'code' => $code

        );



        $this->db->set($data);

        $this->db->where('id', $id);



        if ($this->db->update('geopos_units')) {

            $this->aauth->applog("Birim Düzenlendi $id ID ",$this->aauth->get_user()->username);
            kont_kayit(10,$id);
            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }



    public function variations_list()

    {

        $query = $this->db->query("SELECT * FROM geopos_units WHERE type=1 ORDER BY id DESC");

        return $query->result_array();

    }



    public function create_va($name,$type=0)

    {

        $data = array(

            'name' => $name,

            'type' => $type,
            'loc' => $this->session->userdata('set_firma_id')

        );



        if ($this->db->insert('geopos_units', $data)) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('ADDED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }



    public function edit_va($id,$name)

    {

        $data = array(

            'name' => $name

        );



        $this->db->set($data);

        $this->db->where('id', $id);



        if ($this->db->update('geopos_units')) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }

    public function variables_list()

    {

        //   $query = $this->db->query("SELECT * FROM geopos_units WHERE type=2 ORDER BY id DESC");

        //    return $query->result_array();

        $this->db->select('u.id,u.name,u2.name AS variation');

        $this->db->join('geopos_units u2', 'u.rid = u2.id', 'left');

        $this->db->where('u.type', 2);

        $this->db->order_by('u.name', 'asc');

        $query = $this->db->get('geopos_units u');

        return $query->result_array();

    }

    public function create_vb($name,$var_id)

    {

        $data = array(

            'name' => $name,

            'type' => 2,

            'rid' => $var_id

        );



        if ($this->db->insert('geopos_units', $data)) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('ADDED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }



    public function edit_vb($id,$name,$var_id)

    {

        $data = array(

            'name' => $name,

            'rid' => $var_id

        );



        $this->db->set($data);

        $this->db->where('id', $id);



        if ($this->db->update('geopos_units')) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }





}