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





class Benzin_model extends CI_Model
{


    var $column_order = array('benzin_bakiye.created_at', 'benzin_bakiye.user_id','benzin_cen.code','benzin_bakiye.benzin_type_id' ,'araclar.plaka' ,'benzin_bakiye.tip', 'benzin_bakiye.quantity','benzin_bakiye.desc');

    var $column_search = array('benzin_bakiye.created_at', 'geopos_employees.name as pers_name','benzin_cen.code','araclar.plaka','araclar.code', 'benzin_bakiye.tip', 'benzin_bakiye.quantity','benzin_bakiye.desc');


    var $column_search_kart = array('benzin_bakiye.created_at', 'benzin_cen.code','benzin_type.name','geopos_employees.name as pers_name', 'benzin_bakiye.tip', 'benzin_bakiye.quantity','benzin_bakiye.desc');
    var $column_order_cart = array('benzin_bakiye.created_at', 'benzin_cen.code','benzin_type.name','geopos_employees.name', 'benzin_bakiye.tip', 'benzin_bakiye.quantity','benzin_bakiye.desc');



    var $column_search_arac = array('benzin_bakiye.created_at', 'benzin_cen.code', 'araclar.plaka','araclar.code', 'benzin_bakiye.tip', 'benzin_bakiye.quantity','benzin_bakiye.desc','geopos_customers.company');



    var $column_search_bezin = array('benzin_bakiye.created_at', 'benzin_cen.code', 'araclar.plaka','araclar.code', 'benzin_bakiye.tip', 'benzin_bakiye.quantity','benzin_bakiye.desc');


    var $column_order_arac = array('benzin_bakiye.created_at',  'benzin_cen.code','araclar.plaka','geopos_employees.name', 'benzin_bakiye.tip', 'benzin_bakiye.quantity','benzin_bakiye.desc','geopos_customers.company');


    public function __construct()
    {
        parent::__construct();

    }

    public function create_save(){
        $amounth = $this->input->post('amounth');
        $desc = $this->input->post('desc');
        $benzin_type_id = $this->input->post('benzin_type_id');
        $data = array(
            'invoice_id'=>0,
            'quantity'=>$amounth,
            'benzin_type_id'=>$benzin_type_id,
            'tip'=>1,
            'desc'=>$desc,
            'unit_id'=>12,
            'user_id' => $this->aauth->get_user()->id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        $index=0;
        if ($this->db->insert('benzin_bakiye', $data)) {
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Litr Eklendi',
            ];
        }
        else{
            return [
                'status'=>0,
                'message'=>'Litr Eklenirken Hata Aldınız',
            ];
        }
    }

    public function create_save_cen(){

        $talep_no = numaric(36);
        $proje_id = $this->input->post('proje_id');
        $benzin_type_id = $this->input->post('benzin_type_id');
        $desc = $this->input->post('desc');

        $data = array(
            'code'=>$talep_no,
            'proje_id'=>$proje_id,
            'benzin_type_id'=>$benzin_type_id,
            'desc'=>$desc,
            'user_id' => $this->aauth->get_user()->id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        $index=0;
        if ($this->db->insert('benzin_cen', $data)) {

            numaric_update(36);

            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Cen Eklendi',
            ];
        }
        else{
            return [
                'status'=>0,
                'message'=>'Cen Eklenirken Hata Aldınız',
            ];
        }
    }

    public function benzin_type_quantity(){
        $benzin_type_id = $this->input->post('benzin_type_id');
        $kalan=0;
        $giren = $this->db->query("SELECT SUM(quantity) as total FROM benzin_bakiye Where cen_id=0 and benzin_type_id=$benzin_type_id and tip=1")->row()->total;
        $cikan = $this->db->query("SELECT SUM(quantity) as total FROM benzin_bakiye Where cen_id=0 and benzin_type_id=$benzin_type_id and tip=0")->row()->total;
        $kalan = $giren-$cikan;
        if($kalan){
            return [
                'status'=>1,
                'kalan'=>$kalan
            ];
        }
        else{
            return [
                'status'=>0,
                'message'=>'Bu Yanacaq Növünde Bulunamadı',
            ];
        }

    }

    public function update_balanca_cen(){
        $amounth = $this->input->post('amounth');
        $desc = $this->input->post('desc');
        $cen_id = $this->input->post('cen_id');
        $benzin_type_id = $this->input->post('benzin_type_id');
        $tip = 1;
        $data = array(
            'invoice_id'=>0,
            'quantity'=>$amounth,
            'cen_id'=>$cen_id,
            'tip'=>$tip,
            'desc'=>$desc,
            'unit_id'=>12,
            'benzin_type_id'=>$benzin_type_id,
            'user_id' => $this->aauth->get_user()->id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        $index=0;
        if ($this->db->insert('benzin_bakiye', $data)) {
            $new_tip = 0;
            if($tip==0){
                $new_tip=1;
            }
            if($tip==1){
                $data = array(
                    'invoice_id'=>0,
                    'quantity'=>$amounth,
                    'tip'=>$new_tip,
                    'desc'=>$desc,
                    'unit_id'=>12,
                    'benzin_type_id'=>$benzin_type_id,
                    'user_id' => $this->aauth->get_user()->id,
                    'loc' =>  $this->session->userdata('set_firma_id'),
                );
                $this->db->insert('benzin_bakiye', $data);
            }



            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Litr Güncellendi',
            ];
        }
        else{
            return [
                'status'=>0,
                'message'=>'Litr Eklenirken Hata Aldınız',
            ];
        }
    }

    public function update_car_cen(){
        $cen_id = $this->input->post('cen_id');
        $car_id = $this->input->post('car_id');
        $amounth = $this->input->post('amounth');
        $desc = $this->input->post('desc');

        $cen_details = $this->db->query("Select * from benzin_cen where id=$cen_id")->row();
        $data = array(
            'invoice_id'=>0,
            'quantity'=>$amounth,
            'cen_id'=>$cen_id,
            'car_id'=>$car_id,
            'benzin_type_id'=>$cen_details->benzin_type_id,
            'tip'=>0,
            'desc'=>$desc,
            'unit_id'=>12,
            'user_id' => $this->aauth->get_user()->id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        $index=0;
        if ($this->db->insert('benzin_bakiye', $data)) {
            $last_id=$this->db->insert_id();

            $firma_id = $this->db->query("Select * From araclar where id = $car_id")->row()->firma_id;
            if($firma_id){
                $data_cari = array(
                    'benzin_bakiye_id'=>$last_id,
                    'benzin_litre'=>$amounth,
                    'status'=>0,
                    'borc_tutar'=>$amounth,
                    'firma_id'=>$firma_id,
                );
                $this->db->insert('benzin_cari_durumu', $data_cari);
            }
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Litr Eklendi',
            ];
        }
        else{
            return [
                'status'=>0,
                'message'=>'Litr Eklenirken Hata Aldınız',
            ];
        }
    }

    public function update_bakiye_benzin_type(){
        $bakiye_id = $this->input->post('bakiye_id');
        $benzin_type_id = $this->input->post('benzin_type_id');


        $car_update = array(
            'benzin_type_id' => $benzin_type_id,
        );
        $this->db->set($car_update);
        $this->db->where('id', $bakiye_id);

        if($this->db->update('benzin_bakiye')) {
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Yanacaq Növü Güncellendi',
            ];
        }
        else{
            return [
                'status'=>0,
                'message'=>'Güncellenirken Hata Aldınız',
            ];
        }
    }


    public function ajax_list_bakiye(){
        $this->_ajax_list_bakiye();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _ajax_list_bakiye()
    {

        $tip  = $this->input->post('tip');


        $this->db->select('benzin_bakiye.*,geopos_employees.name as pers_name,benzin_cen.code,araclar.plaka,araclar.code as arac_kodu');
        $this->db->from('benzin_bakiye');
        $this->db->join('geopos_employees','benzin_bakiye.user_id=geopos_employees.id');
        $this->db->join('araclar','benzin_bakiye.car_id=araclar.id','LEFT');
        $this->db->join('benzin_cen','benzin_bakiye.cen_id=benzin_cen.id','LEFT');
        $i = 0;
        //$this->db->where('benzin_bakiye.cen_id',0);
        foreach ($this->column_search_bezin as $item) // loop column
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

                if (count($this->column_search_bezin) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);

        }
        else {
            $this->db->order_by('`benzin_bakiye`.`id` DESC');
        }

    }
    public function count_filtered_bakiye()
    {
        $this->_ajax_list_bakiye();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_bakiye()
    {
        $this->_ajax_list_bakiye();
        return $this->db->count_all_results();
    }


    public function ajax_list_kart_bakiye(){
        $this->_ajax_list_kart_bakiye();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _ajax_list_kart_bakiye()
    {

        $tip  = $this->input->post('tip');


        $this->db->select('benzin_bakiye.*,geopos_employees.name as pers_name,benzin_cen.code,geopos_projects.code as p_code');
        $this->db->from('benzin_bakiye');
        $this->db->join('geopos_employees','benzin_bakiye.user_id=geopos_employees.id');
        $this->db->join('benzin_cen','benzin_bakiye.cen_id=benzin_cen.id');
        $this->db->join('geopos_projects','benzin_cen.proje_id=geopos_projects.id');
        $this->db->join('benzin_type','benzin_cen.benzin_type_id=benzin_type.id');
        $i = 0;
        $this->db->where('benzin_bakiye.cen_id!=',0);
        foreach ($this->column_search_kart as $item) // loop column
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

                if (count($this->column_search_kart) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }


        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order_cart[$search['0']['column']], $search['0']['dir']);

        }
        else {
            $this->db->order_by('`benzin_bakiye`.`id` DESC');
        }


    }
    public function count_filtered_bakiye_kart()
    {
        $this->_ajax_list_kart_bakiye();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_bakiye_kart()
    {
        $this->_ajax_list_kart_bakiye();
        return $this->db->count_all_results();
    }

    public function ajax_list_kart_arac(){
        $this->_ajax_list_kart_arac();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _ajax_list_kart_arac()
    {

        $this->db->select('araclar.*,geopos_employees.name as pers_name,benzin_cen.code as cen_code,benzin_bakiye.tip,benzin_bakiye.id as bb_id,
        benzin_bakiye.quantity,benzin_bakiye.desc,benzin_cari_durumu.transaction_id,benzin_cari_durumu.firma_id,benzin_cari_durumu.id as benzin_cari_durumu_id,benzin_cari_durumu.status as cari_status,benzin_cari_durumu.benzin_litre,benzin_cari_durumu.borc_tutar,geopos_customers.company');
        $this->db->from('araclar');
        $this->db->join('benzin_bakiye','benzin_bakiye.car_id=araclar.id');
        $this->db->join('benzin_cen','benzin_bakiye.cen_id=benzin_cen.id');
        $this->db->join('geopos_employees','benzin_bakiye.user_id=geopos_employees.id');
        $this->db->join('benzin_cari_durumu','benzin_bakiye.id=benzin_cari_durumu.benzin_bakiye_id','LEFT');
        $this->db->join('geopos_customers','benzin_cari_durumu.firma_id=geopos_customers.id','LEFT');
        $i = 0;
        foreach ($this->column_search_arac as $item) // loop column
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

                if (count($this->column_search_arac) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }


        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order_arac[$search['0']['column']], $search['0']['dir']);

        }
        else {
            $this->db->order_by('`benzin_bakiye`.`id` DESC');
        }


    }
    public function count_filtered_arac()
    {
        $this->_ajax_list_kart_arac();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_arac()
    {
        $this->_ajax_list_kart_arac();
        return $this->db->count_all_results();
    }

    public function delete_cen(){
        $cen_id = $this->input->post('cen_id');

        $car_update = array(
            'status' => 0,
        );
        $this->db->set($car_update);
        $this->db->where('id', $cen_id);

        if($this->db->update('benzin_cen')) {
            $this->aauth->applog("Çen PAsifleştirildi : " . $cen_id, $this->aauth->get_user()->username);

            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Çen PAsifleştirildi',
            ];
        }
        else{
            return [
                'status'=>0,
                'message'=>'Çen Silinirken Hata Aldınız',
            ];
        }
    }

    public function bakiye_details($id){
        $this->db->select('*');
        $this->db->from('benzin_bakiye');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function benzin_cari_durumu($id){
        $this->db->select('*');
        $this->db->from('benzin_cari_durumu');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_info_benzin_cari(){
        $benzin_cari_durumu_id = $this->input->post('benzin_cari_durumu_id');


        $this->db->select('araclar.*,geopos_employees.name as pers_name,benzin_cen.code as cen_code,benzin_bakiye.tip,benzin_bakiye.id as bb_id,
        benzin_bakiye.quantity,benzin_bakiye.desc,benzin_cari_durumu.firma_id,benzin_cari_durumu.id as benzin_cari_durumu_id,benzin_cari_durumu.status as cari_status,benzin_cari_durumu.benzin_litre,benzin_cari_durumu.borc_tutar,geopos_customers.company');
        $this->db->from('araclar');
        $this->db->join('benzin_bakiye','benzin_bakiye.car_id=araclar.id');
        $this->db->join('benzin_cen','benzin_bakiye.cen_id=benzin_cen.id');
        $this->db->join('geopos_employees','benzin_bakiye.user_id=geopos_employees.id');
        $this->db->join('benzin_cari_durumu','benzin_bakiye.id=benzin_cari_durumu.benzin_bakiye_id');
        $this->db->join('geopos_customers','benzin_cari_durumu.firma_id=geopos_customers.id','LEFT');
        $this->db->where('benzin_cari_durumu.id',$benzin_cari_durumu_id);
        $query = $this->db->get();
        if($query->row()){
            return [
                'status'=>1,
                'details'=>$query->row(),
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Detay Bulunamadı',
            ];
        }
    }
    public function cari_borclandir(){
        $benzin_cari_durumu_id=$this->input->post('benzin_cari_durumu_id');
        $proje_id=$this->input->post('proje_id');
        $yanacaq_litre=$this->input->post('yanacaq_litre');
        $firma_name=$this->input->post('firma_name');
        $firma_id=$this->input->post('firma_id');
        $amounth=$this->input->post('amounth');
        $desc=$this->input->post('desc');

        $data = array(

            'csd' => $firma_id,
            'payer' => customer_details($firma_id)['company'],
            'acid' => 0,
            'account' => '',
            'total' => $amounth,
            'invoice_type_id'=>40,
            'invoice_type_desc'=>invoice_type_desc(40),
            'method' => 1, //ödeme metodu ekelenecek
            'eid' => $this->aauth->get_user()->id, //user_id
            'notes' => $desc.' | '.$yanacaq_litre.' LITR YANACAĞA İSTİNADEN',
            'proje_id' => $proje_id,
            'loc' => $this->aauth->get_user()->loc

        );

        if($this->db->insert('geopos_invoices', $data)){

            $last_id=$this->db->insert_id();
            $car_update = array(
                'status' => 1,
                'borc_tutar' => $amounth,
                'transaction_id' => $last_id,
            );
            $this->db->set($car_update);
            $this->db->where('id', $benzin_cari_durumu_id);
            $this->db->update('benzin_cari_durumu');

            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Borçlandırıldı',
            ];
        }
        else{
            return [
                'status'=>0,
                'message'=>'Hata Aldınız',
            ];
        }
    }
}