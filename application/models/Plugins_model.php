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





class Plugins_model extends CI_Model

{





    public function recaptcha($captcha, $public_key, $private_key)

    {

        $data = array(

            'key1' => $public_key,

            'key2' => $captcha,

            'url' => $private_key

        );



        $this->db->set($data);

        $this->db->where('id', 53);



        if ($this->db->update('univarsal_api', $data)) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }



    public function config_general()

    {

        $this->db->select('key1 AS recaptcha_p,key2 AS captcha,url AS recaptcha_s,method AS bank,other AS acid,active AS ext1');

        $this->db->from('univarsal_api');

        $this->db->where('id', 53);

        $query = $this->db->get();

        return $query->row_array();

    }



    public function universal_api($id)

    {

        $this->db->select('*');

        $this->db->from('univarsal_api');

        $this->db->where('id', $id);

        $query = $this->db->get();

        return $query->row_array();

    }



    public function update_api($id, $key1, $key2, $enable, $url = '', $other = '')

    {

        $data = array(

            'key1' => $key1,

            'key2' => $key2,

            'url' => $url,

            'active' => $enable,

            'other' => $other

        );



        $this->db->set($data);

        $this->db->where('id', $id);



        if ($this->db->update('univarsal_api', $data)) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }





}