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





class Logistics_model extends CI_Model
{
    var $table_news = 'geopos_talep ';

    var $column_order = array('created_at', 'talep_no', 'proje_name', 'description','muqavele_no');

    var $column_search = array('created_at', 'talep_no', 'proje_name', 'description','muqavele_no');
    var $column_search_ = array('created_at', 'talep_no', 'description');

    var $order = array('id' => 'DESC');


    var $column_order_sf = array('lojistik_satinalma_item.arac_id',
        'lojistik_satinalma_talep.id',
        'lojistik_satinalma_item.id',
        'lojistik_satinalma_talep.talep_no',
        'lojistik_satinalma_talep.created_at',
        'araclar.name',
        'geopos_customers.company',
        'geopos_account_type.name');

    var $column_search_sf = array('lojistik_satinalma_item.arac_id',
        'lojistik_satinalma_talep.id',
        'lojistik_satinalma_item.id',
        'lojistik_satinalma_talep.talep_no',
        'lojistik_satinalma_talep.created_at',
        'araclar.name',
        'geopos_customers.company',
        'geopos_account_type.name');



    public function __construct()
    {
        parent::__construct();

    }


    public function firma_to_protokol($id){
        $this->db->select('cari_razilastirma.*');
        $this->db->from('cari_razilastirma');
        $this->db->where('cari_razilastirma.cari_id',$id);
        $this->db->where('razi_status',1);
        $this->db->where('deleted_at',NULL);
        $query = $this->db->get();
        return $query->result();
    }
    public function lojistik_talep($id){
        $this->db->select('*');
        $this->db->from('lojistik_to_satinalma');
        $this->db->where('sf_id',$id);
        $query = $this->db->get();
        return $query->result();
    }
    public function details($id){
        $this->db->select('lojistik_satinalma_talep.*');
        $this->db->from('lojistik_satinalma_talep');
        $this->db->join('lojistik_status', 'lojistik_satinalma_talep.status=lojistik_status.id ');
        $this->db->where('lojistik_satinalma_talep.id',$id);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('lojistik_satinalma_talep.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $query = $this->db->get();
        return $query->row();
    }
    public function item_details($id){
        $this->db->select('lojistik_satinalma_item.*,geopos_projects.name as proje_name,araclar.name as arac_name,geopos_units.name as unit_name');
        $this->db->from('lojistik_satinalma_item');
        $this->db->join('geopos_projects','lojistik_satinalma_item.proje_id=geopos_projects.id');
        $this->db->join('araclar','lojistik_satinalma_item.arac_id=araclar.id');
        $this->db->join('geopos_units','lojistik_satinalma_item.unit_id=geopos_units.id');
        $this->db->where('lojistik_satinalma_item.lojistik_id',$id);
        $query = $this->db->get();
        return $query->result();
    }
    public function item_details_sf($id){
        $this->db->select('lojistik_satinalma_item.*,geopos_projects.name as proje_name,araclar.name as arac_name,geopos_units.name as unit_name,geopos_customers.company,locations.location as lokasyon,locations.id as location_id');
        $this->db->from('lojistik_satinalma_item');
        $this->db->join('locations','locations.item_id=lojistik_satinalma_item.id');
        $this->db->join('geopos_projects','lojistik_satinalma_item.proje_id=geopos_projects.id');
        $this->db->join('araclar','lojistik_satinalma_item.arac_id=araclar.id');
        $this->db->join('geopos_units','lojistik_satinalma_item.unit_id=geopos_units.id');
        $this->db->join('geopos_customers','lojistik_satinalma_item.firma_id=geopos_customers.id');
        $this->db->where('lojistik_satinalma_item.lojistik_id',$id);
        $this->db->where('locations.type',2);
        $this->db->group_by('lojistik_satinalma_item.id');
        $this->db->order_by('lojistik_satinalma_item.location', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function item_details_location($id){
        $this->db->select('satinalma_location.sf_item_id,location_id');
        $this->db->from('satinalma_location');
        $this->db->where('satinalma_location.lojistik_id',$id);
        $this->db->group_by('sf_item_id');
        $query = $this->db->get();
        return $query->result_array();
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

        $this->db->select('lojistik_satinalma_talep.*,geopos_employees.name as pers_name,lojistik_status.name as status_name');
        $this->db->from('lojistik_satinalma_talep');

        $this->db->join('geopos_employees','lojistik_satinalma_talep.user_id=geopos_employees.id');
        $this->db->join('lojistik_status','lojistik_satinalma_talep.status=lojistik_status.id','LEFT');
        if($this->session->userdata('set_firma_id')){
            $this->db->where('lojistik_satinalma_talep.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $i = 0;

        foreach ($this->column_search_ as $item) // loop column

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

                if (count($this->column_search_) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`lojistik_satinalma_talep`.`id` DESC');

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

    public function notes($lojistik_id)
    {
        $this->db->select('*');
        $this->db->from('lojistik_notes');
        $this->db->where('lojistik_notes.lojistik_id',$lojistik_id);
        $this->db->order_by('`lojistik_notes`.`created_at` DESC');
        $query = $this->db->get();
        return $query->result();
    }
    public function lojistikhizmetcount(){
        $user_id = $this->aauth->get_user()->id;
        $this->db->select('*');
        $this->db->from('lsf_table_file');
        $this->db->where('lsf_table_file.staff_id',$user_id); // Onay Kimde
        $this->db->where('lsf_table_file.status',1); // Bekliyor
        $this->db->where('lsf_table_file.staff_status',1); // Sıra Sende
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function ajax_lojistikhizmetlist()

    {
        $this->_ajax_lojistikhizmetlist();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _ajax_lojistikhizmetlist()

    {

        $this->db->select('lojistik_satinalma_talep.status,lojistik_satinalma_item.arac_id,lojistik_satinalma_talep.id as talep_id,
        lojistik_satinalma_item.id as lsf_id,lojistik_satinalma_talep.talep_no,
        lojistik_satinalma_talep.created_at,araclar.name,(lojistik_satinalma_item.qty*lojistik_satinalma_item.price) as teklif_tutari,
        geopos_customers.company,geopos_account_type.name as method_name,geopos_account_type.id as account_type_id,geopos_customers.id as customer_id');
        $this->db->from('lojistik_satinalma_talep');

        $this->db->join('lojistik_satinalma_item','lojistik_satinalma_talep.id=lojistik_satinalma_item.lojistik_id');
        $this->db->join('araclar','lojistik_satinalma_item.arac_id=araclar.id');
        $this->db->join('geopos_customers','lojistik_satinalma_item.firma_id=geopos_customers.id');
        $this->db->join('geopos_account_type','lojistik_satinalma_item.account_type=geopos_account_type.id');
//        $this->db->where('lojistik_satinalma_talep.status',2);

        $this->db->where('lojistik_satinalma_talep.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57


        $i = 0;

        foreach ($this->column_search_sf as $item) // loop column

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

                if (count($this->column_search_sf) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`lojistik_satinalma_talep`.`id` DESC');

    }


    public function ajax_lojistikhizmetlist_filter()
    {
        $this->_ajax_lojistikhizmetlist();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function ajax_lojistikhizmetlist_count()
    {
        $this->_ajax_lojistikhizmetlist();
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
        $this->db->select('lojistik_satinalma_talep.*');
        $this->db->from('lojistik_satinalma_talep');
        //$this->db->join('lojistik_onay','lojistik_satinalma_talep.id = lojistik_onay.talep_id','LEFT');
        $this->db->where('lojistik_satinalma_talep.bildirim_durumu=1');
        $this->db->where("(lojistik_satinalma_talep.lojistik_muduru=$user_id or lojistik_satinalma_talep.proje_muduru=$user_id or  lojistik_satinalma_talep.genel_mudur=$user_id)");
        //$this->db->where('lojistik_onay.status is null');
        $this->db->where('lojistik_satinalma_talep.status=1');
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

        $this->db->order_by('`lojistik_satinalma_talep`.`id` DESC');





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
