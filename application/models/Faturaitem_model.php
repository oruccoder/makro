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


defined('BASEPATH') or exit('No direct script access allowed');


class Faturaitem_model extends CI_Model

{
    var $table_news = 'stock_io ';

    var $column_order = array(null, 'fatura_item.name', 'fatura_item.code');

    var $column_search = array('fatura_item.name', 'fatura_item.code');

    var $urun = array('fatura_item.id', 'DESC');

    // var $urun = array('geopos_product_cat.id', 'DESC');
    // var $column_search_transfer = [
    //     'stock_transfer.code',
    //     'stock_transfer.out_warehouse_id',
    //     'stock_transfer.in_warehouse_id',
    //     'geopos_geopos_products.product_name',
    //     'stock_transfer_items.qty',
    //     'fatura_item.name',
    //     'stock_transfer_item_notification.new_qty',
    //     'stock_transfer_items.desc',
    //     'geopos_employees.name'
    // ];

    // var $order = array('stock_transfer.id' => 'DESC');
    // var $mahsul = array('geopos_products.id' => 'DESC');


    public function __construct()
    {
        parent::__construct();
    }


    public function get_datatables_query_details_list()
    {

        $this->_get_datatables_query_details_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();
    }


    private function _get_datatables_query_details_list()
    {
        $this->db->select('*');
        $this->db->from('fatura_item');
        $this->db->where('fatura_item.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
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
        } else if (isset($this->urun)) {
            $order = $this->urun;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }


    public function count_filtered()
    {
        $this->_get_datatables_query_details_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_get_datatables_query_details_list();
        return $this->db->count_all_results();
    }

    public function create_save()
    {
        $taleno = numaric(40);
        $data = array(
            'name' =>  $this->input->post('name'),
            'proje_id' => $this->input->post('proje_id'),
            'demirbas_id' => $this->input->post('demirbas_id'),
            'code'=>$taleno,
            'loc' => $this->session->userdata('set_firma_id')
        );

        if ($this->db->insert('fatura_item', $data)) {
            numaric_update(40);
            return [
                'status' => 1,
            ];
        } else {
            return [
                'status' => 0,
            ];
        }
    }



    public function update()
    {
        $unit_id =  $this->input->post('unit_id');
        $units = array(
            'name' =>  $this->input->post('name'),
            'proje_id' => $this->input->post('proje_id'),
            'demirbas_id' => $this->input->post('demirbas_id'),

        );

        if ($this->db->where(['id' => $unit_id])->update('fatura_item', $units)) {
            return [
                'status' => 1,
            ];
        } else {
            return [
                'status' => 0,
            ];
        }
    }


    public function delete()
    {
        $unit_id =  $this->input->post('unit_id');

        if ($this->db->where(['id' => $unit_id])->delete('fatura_item')) {
            return [
                'status' => 1,
                'messages' => 'Başarıyla Silindi'
            ];
        } else {
            return [
                'status' => 0,
                'messages' => 'Hata Aldınız. Yöneticiye Başvurun'
            ];
        }
    }



    public function details_item($unit_id)
    {
        $this->db->select('*');
        $this->db->from('fatura_item');
        $this->db->where('id', $unit_id);
        $query = $this->db->get();
        return $query->result();
    }


    public function details($unit_id)
    {
        $this->db->select('*');
        $this->db->from('fatura_item');
        $this->db->where('id', $unit_id);
        $query = $this->db->get();
        return $query->row();
    }
}
