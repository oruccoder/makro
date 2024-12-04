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





class Prim_model extends CI_Model
{
    var $table_news = 'personel_prim ';

    var $column_order = array('personel_prim.id', 'geopos_employees.name','personel_prim.aciklama','personel_prim.created_at','personel_prim.hesaplanan_ay', 'personel_prim.type', 'personel_prim.tutar');

    var $column_search = array( 'geopos_employees.name','personel_prim.aciklama','personel_prim.created_at','personel_prim.hesaplanan_ay', 'personel_prim.tutar');

    var $order = array('personel_prim.id' => 'DESC');
    public function __construct()
    {
        parent::__construct();

    }
    public function ajax_list()

    {
        $this->_ajax_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _ajax_list()

    {

        $this->db->select('personel_prim.*,geopos_employees.name as personel_name');
        $this->db->from('personel_prim');
        $this->db->join('geopos_employees','personel_prim.personel_id=geopos_employees.id');
        if($this->session->userdata('set_firma_id')){
            $this->db->where('personel_prim.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $i = 0;

        foreach ($this->column_search as $item) // loop column

        {
            if ($_POST['search']['value']) // if datatable send POST for search

            {
                if ($i === 0) // first loop

                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, $_POST['search']['value']);

                } else {

                    $this->db->or_like($item, $_POST['search']['value']);

                }

                if (count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }

    }


    public function count_filtered()
    {
        $this->_ajax_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_ajax_list();
        return $this->db->count_all_results();
    }

    public function get_info_prim_confirm($id){
        $this->db->select('personel_prim_onay.*,personel_prim.created_at,personel_prim.aciklama,personel_prim.hesaplanan_ay,geopos_employees.name as name');
        $this->db->from('personel_prim_onay');
        $this->db->join('personel_prim','personel_prim_onay.personel_prim_id=personel_prim.id');
        $this->db->join('geopos_employees','personel_prim_onay.staff_id=geopos_employees.id');
        $this->db->where('personel_prim_onay.personel_prim_id', $id);
        $query = $this->db->get();
        return $query->result();
    }
}