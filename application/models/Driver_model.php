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





class Driver_model extends CI_Model
{
    var $table_news = 'araclar ';

    var $column_order = array('code', 'plaka', 'araclar.name', 'firma_id','geopos_customers.company');

    var $column_search = array('code', 'plaka', 'araclar.name', 'firma_id','geopos_customers.company');


    var $column_search_surucu_notes = array('lokasyon', 'desc', 'geopos_employees.name', 'surucu_notes_status.name');
    var $column_search_surucu_files = array('desc', 'file_name', 'islem_date', 'created_at');

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

        $arac_id = $this->input->post('arac_id');
        $this->db->select('arac_suruculeri.*,arac_form.code,geopos_employees.name as pers_name,geopos_employees.id as pers_id');
        $this->db->from('arac_suruculeri');

        $this->db->join('arac_form','arac_suruculeri.talep_id=arac_form.id','LEFT');
        $this->db->join('geopos_employees','arac_form.user_id=geopos_employees.id','LEFT');
        $this->db->where('arac_suruculeri.arac_id',$arac_id);
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
        $this->db->order_by('`arac_suruculeri`.`status` ASC');

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



    public function get_datatables_details_notes()

    {
        $this->_get_datatables_query_details_notes();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _get_datatables_query_details_notes()

    {

        $arac_id = $this->input->post('arac_id');
        $this->db->select('surucu_notes.*,geopos_employees.name as pers_name,surucu_notes_status.name as status_name');
        $this->db->from('surucu_notes');

        $this->db->join('surucu_notes_status','surucu_notes.surucu_notes_status_id=surucu_notes_status.id');
        $this->db->join('geopos_employees','surucu_notes.user_id=geopos_employees.id','LEFT');
        $this->db->where('surucu_notes.arac_id',$arac_id);
        $i = 0;

        foreach ($this->column_search_surucu_notes as $item) // loop column

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

                if (count($this->column_search_surucu_notes) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`surucu_notes`.`id` DESC');

    }


    public function count_filtered_notes()
    {
        $this->_get_datatables_query_details_notes();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_notes()
    {
        $this->_get_datatables_query_details_notes();
        return $this->db->count_all_results();
    }



    public function get_datatables_details_files()

    {
        $this->_get_datatables_query_details_files();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _get_datatables_query_details_files()

    {

        $arac_id = $this->input->post('arac_id');
        $this->db->select('surucu_files.*');
        $this->db->from('surucu_files');
        $this->db->where('surucu_files.arac_id',$arac_id);
        $i = 0;

        foreach ($this->column_search_surucu_files as $item) // loop column

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

                if (count($this->column_search_surucu_files) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`surucu_files`.`id` DESC');

    }


    public function count_filtered_files()
    {
        $this->_get_datatables_query_details_notes();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_files()
    {
        $this->_get_datatables_query_details_notes();
        return $this->db->count_all_results();
    }

    public function form_details($id){
        $this->db->select('arac_form.*');
        $this->db->from('arac_suruculeri');
        $this->db->join('arac_form','arac_suruculeri.talep_id=arac_form.id');
        $this->db->where('arac_suruculeri.id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function details($id){
        $this->db->select('*');
        $this->db->from('arac_suruculeri');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function status_change(){
        $talep_id = $this->input->post('talep_id');
        $status = $this->input->post('status');




        $details = $this->db->query("SELECT * FROM arac_suruculeri Where id = $talep_id")->row();

        $data=array(
            'active_surucu_id'=>0,
        );
        $this->db->set($data);
        $this->db->where('id', $details->arac_id);
        $this->db->update('araclar', $data);

        $data_update=array(
            'status'=>3,
        );
        if($status==2) // Aktif ise
        {
            $data=array(
                'active_surucu_id'=>$details->user_id,
            );
            $this->db->set($data);
            $this->db->where('id', $details->arac_id);
            $this->db->update('araclar', $data);
            $this->db->set('aktive_date', 'NOW()', FALSE);



        }
        elseif($status==3){
            $this->db->set('passive_date', 'NOW()', FALSE);
        }

        // Aktif Olan Sürücüleri Pasif Moduna Alma

        $this->db->set($data_update);
        $this->db->set('passive_date', 'NOW()', FALSE);
        $this->db->where('arac_id', $details->arac_id);
        $this->db->where('status', 2);
        $this->db->update('arac_suruculeri', $data_update);
        // Aktif Olan Sürücüleri Pasif Moduna Alma


        $data=array(
            'status'=>$status,
        );
        $this->db->set($data);
        $this->db->where('id', $talep_id);
        if ($this->db->update('arac_suruculeri', $data)) {

            $this->aauth->applog("Araç Durumu Değiştirildi : sürücü_list_id ID : ".$talep_id, $this->aauth->get_user()->username);
            return ['status'=>1,'messages'=>'Başarıyla Durumunuz Güncellendi'];

        }
        else {
            return ['status'=>0,'messages'=>'Hata Aldınız Yöneticiye Başvurun'];
        }
    }

    public function arac_change(){
        $talep_id = $this->input->post('talep_id');
        $arac_id = $this->input->post('arac_id');


        $data=array(
            'arac_id'=>$arac_id,
        );
        $this->db->set($data);
        $this->db->where('id', $talep_id);
        if ($this->db->update('arac_suruculeri', $data)) {

            $this->aauth->applog("Talep  Başka Araca Aktarıldı : sürücü_list_id ID : ".$talep_id, $this->aauth->get_user()->username);
            return ['status'=>1,'messages'=>'Başarıyla Durumunuz Güncellendi'];

        }
        else {
            return ['status'=>0,'messages'=>'Hata Aldınız Yöneticiye Başvurun'];
        }
    }
}
