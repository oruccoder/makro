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





class Lojistiks_model extends CI_Model
{
    var $table_news = 'geopos_talep ';

    var $column_order = array('lojistik_talep.created_at', 'lojistik_talep.talep_no', 'lojistik_talep.description');

    var $column_search = array('lojistik_talep.created_at', 'lojistik_talep.talep_no','lojistik_talep.description');

    var $order = array('id' => 'DESC');



    public function __construct()
    {
        parent::__construct();

    }

    public function proje_to_sf($id){
        $this->db->select('geopos_talep.*');
        $this->db->from('geopos_talep');
        $this->db->where('geopos_talep.proje_id',$id);
        $this->db->where('geopos_talep.tip',2);
        $query = $this->db->get();
        return $query->result();
    }
    public function details($id){
        $this->db->select('lojistik_talep.*');
        $this->db->from('lojistik_talep');
        $this->db->join('lojistik_status', 'lojistik_talep.status=lojistik_status.id ');
        $this->db->where('lojistik_talep.id',$id);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('lojistik_talep.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $query = $this->db->get();
        return $query->row();
    }
    public function item_details($id){
        $this->db->select('lojistik_talep_item.*,geopos_projects.name as proje_name,araclar.name as arac_name,geopos_units.name as unit_name');
        $this->db->from('lojistik_talep_item');
        $this->db->join('geopos_projects','lojistik_talep_item.proje_id=geopos_projects.id');
        $this->db->join('araclar','lojistik_talep_item.arac_id=araclar.id');
        $this->db->join('geopos_units','lojistik_talep_item.unit_id=geopos_units.id');
        $this->db->where('lojistik_talep_item.lojistik_id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_datatables_details()

    {
        $this->_get_datatables_query_details();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _get_datatables_query_details()

    {

        $this->db->select('lojistik_talep.*,geopos_employees.name as pers_name,lojistik_status.name as status_name');
        $this->db->from('lojistik_talep');
        $this->db->join('geopos_employees','lojistik_talep.user_id=geopos_employees.id');
        $this->db->join('lojistik_status','lojistik_talep.status=lojistik_status.id','LEFT');
        if($this->session->userdata('set_firma_id')){
            $this->db->where('lojistik_talep.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
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
        $this->db->order_by('`lojistik_talep`.`id` DESC');

    }


    public function count_filtered()
    {
        $this->_get_datatables_query_details();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_get_datatables_query_details();
        return $this->db->count_all_results();
    }

    public function ajax_list_onay_bekleyen()

    {



        $this->_ajax_list_onay_bekleyen();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _ajax_list_onay_bekleyen()

    {

        $user_id = $this->aauth->get_user()->id;
        $this->db->select('lojistik_talep.*');
        $this->db->from('lojistik_talep');
        //$this->db->join('lojistik_onay','lojistik_talep.id = lojistik_onay.talep_id','LEFT');
        $this->db->where('lojistik_talep.bildirim_durumu=1');
        $this->db->where("(lojistik_talep.lojistik_muduru=$user_id or lojistik_talep.proje_muduru=$user_id or  lojistik_talep.genel_mudur=$user_id)");
        //$this->db->where('lojistik_onay.status is null');
        $this->db->where('lojistik_talep.status=1');

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

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        $this->db->order_by('`lojistik_talep`.`id` DESC');





    }
    public function count_filtered_bekleyen()

    {

        $this->_get_datatables_query_details();

        $query = $this->db->get();



        return $query->num_rows();

    }
    public function count_all_bekleyen()

    {

        $this->_get_datatables_query_details();



        return $this->db->count_all_results();

    }
}
