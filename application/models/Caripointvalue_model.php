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


class Caripointvalue_model extends CI_Model

{

    var $table = 'cari_point_value';

    var $column_order = array('cari_point_value.id', 'cari_point_value.name', 'geopos_employees.name', 'cari_point_value.created_at');

    var $column_search = array('cari_point_value.name', 'geopos_employees.name', 'cari_point_value.created_at');

    var $porder = array('cari_point_value.id' => 'desc');

    public function list(){
        $this->_list();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function _list(){

        $this->db->select('cari_point_value.*,geopos_employees.`name` as personel_name');
        $this->db->from('cari_point_value');
        $this->db->join('geopos_employees','cari_point_value.auth_id=geopos_employees.id');
        $this->db->where('cari_point_value.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        $i = 0;

        foreach ($this->column_search as $item)
        {
            if ($_POST['search']['value'])
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }



        if (isset($_POST['order']))
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }

    function count_filtered($id = '')
    {
        $this->_list();
        $query = $this->db->get();
        return $query->num_rows($id = '');
    }

    public function count_all($id = '')
    {
        $this->_list();
        $query = $this->db->get();
        return $query->num_rows($id = '');

    }

}