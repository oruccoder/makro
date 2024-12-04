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





class Arac_model extends CI_Model
{
    var $table_news = 'araclar ';

    var $column_order = array('code', 'plaka', 'araclar.name', 'firma_id','geopos_customers.company');

    var $column_search = array('code', 'plaka', 'araclar.name', 'firma_id','geopos_customers.company');

    var $order = array('id' => 'DESC');


    public function __construct()
    {
        parent::__construct();

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

        $this->db->select('araclar.*,geopos_customers.company as company');
        $this->db->from('araclar');

        $this->db->join('geopos_customers','araclar.firma_id=geopos_customers.id','lEFT');

        if($this->session->userdata('set_firma_id')){
            $this->db->where('araclar.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
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
        $this->db->order_by('`araclar`.`id` DESC');

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

    public function details($id){
        $this->db->select('*');
        $this->db->from('araclar');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function arac_ekipmanlari($id){
        $this->db->select('ekipmanlar.*');
        $this->db->from('arac_ekipmanlari');
        $this->db->join('ekipmanlar','arac_ekipmanlari.ekipman_id=ekipmanlar.id');
        $this->db->where('arac_ekipmanlari.arac_id',$id);
        $query = $this->db->get();
        return $query->result();
    }
    public function ekipmanlar(){
        $this->db->select('*');
        $this->db->from('ekipmanlar');
        $query = $this->db->get();
        return $query->result();
    }


    public function arac_bakimlari($id){
        $this->db->select('arac_bakimlari.*');
        $this->db->from('arac_bakimlari');
        $this->db->join('bakimlar','arac_bakimlari.bakim_id=bakimlar.id');
        $this->db->where('arac_bakimlari.arac_id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function bakimlar(){
        $this->db->select('*');
        $this->db->from('bakimlar');
        $query = $this->db->get();
        return $query->result();
    }

    public function arac_icazeleri($id){
        $this->db->select('arac_icazeleri.*');
        $this->db->from('arac_icazeleri');
        $this->db->join('icazeler','arac_icazeleri.icaze_id=icazeler.id');
        $this->db->where('arac_icazeleri.arac_id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function trafik_cezalari(){
        $this->db->select('*');
        $this->db->from('trafil_cezalari');
        $query = $this->db->get();
        return $query->result();
    }

    public function arac_cezalari($id){
        $this->db->select('arac_cezalari.*');
        $this->db->from('arac_cezalari');
        $this->db->join('trafil_cezalari','arac_cezalari.ceza_id=trafil_cezalari.id');
        $this->db->where('arac_cezalari.arac_id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function icazeler(){
        $this->db->select('*');
        $this->db->from('icazeler');
        $query = $this->db->get();
        return $query->result();
    }

    public function mk_list(){
        $this->db->select('araclar.*');
        $this->db->from('araclar');
        $this->db->where('araclar.kiralik_demirbas',3);
        $query = $this->db->get();
        return $query->result();
    }
    public function arac_oil($id){
        $this->db->select('*');
        $this->db->from('arac_benzin_kart');
        $this->db->where('arac_benzin_kart.arac_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    public function pedding_driver($id){
        $this->db->select('*');
        $this->db->from('arac_suruculeri');
        $this->db->where('arac_id',$id);
        $this->db->where('status',1);
        $query = $this->db->get();
        return $query->num_rows();
    }
}
