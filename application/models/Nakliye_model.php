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





class Nakliye_model extends CI_Model
{
    var $table_news = 'talep_form_nakliye ';

    var $column_search = array('talep_form_nakliye.code', 'talep_form_nakliye.desc', 'geopos_employees.name', 'progress_status.name', 'geopos_projects.code', 'talep_form_status.name', 'geopos_customers.company');

    var $column_order = array('talep_form_nakliye.id', 'geopos_customers.company', 'progress_status.name', 'geopos_customers.created_at', 'geopos_customers.aauth', 'geopos_customers.proje_id', null, 'talep_form_nakliye.status', 'talep_form_nakliye.desc',  NULL);
    var $column_order_n = array('talep_form_nakliye.id', 'geopos_customers.company', 'progress_status.name',  null, 'talep_form_nakliye.status', 'talep_form_nakliye.desc',  NULL);


    var $column_search_notes = array('desc', 'created_at', 'geopos_employees.name');


    var $column_order_item = array(
        null,
        'talep_form_nakliye.id',
        'talep_form_nakliye.created_at',
        'talep_form_nakliye_products.aauth',
        'talep_form_nakliye.desc',
        'talep_form_nakliye_products.code',
        'talep_form_nakliye.proje_id',
        'talep_form_nakliye_products.cari_id',
        'talep_form_nakliye_products.price',
        'talep_form_nakliye_products.product_qty',
        'talep_form_nakliye_products.total',
        'talep_form_nakliye_products.status',
        'talep_form_nakliye_products.lokasyon'
    );

    var $column_search_item = array(
        'talep_form_nakliye.code',
        'talep_form_nakliye.created_at',
        'geopos_employees.name',
        'talep_form_nakliye.desc',
        'talep_form_nakliye_products.code',
        'geopos_projects.name',
        'geopos_projects.code',
        'geopos_customers.company',
        'talep_form_nakliye_products.price',
        'talep_form_nakliye_products.product_qty',
        'talep_form_nakliye_products.total',
        'talep_form_status.name',
        'talep_form_nakliye_products.lokasyon'
    );


    var $order = array('id' => 'DESC');

    var $column_search_history = array('desc', 'created_at', 'geopos_employees.name');


    public function __construct()
    {
        parent::__construct();
        $this->load->model('communication_model');

    }

    public function details($id){
        $this->db->select('*');
        $this->db->from('talep_form_nakliye');
        $this->db->where('id',$id);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_nakliye.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        $query = $this->db->get();
        return $query->row();
    }

    public function product_details($id){
        $this->db->select('talep_form_nakliye_products.*,araclar.name,geopos_units.name as unit_name');
        $this->db->from('talep_form_nakliye_products');
        $this->db->join('araclar','talep_form_nakliye_products.arac_id=araclar.id','LEFT');
        $this->db->join('geopos_units','talep_form_nakliye_products.unit_id=geopos_units.id','LEFT');
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        return $query->result();
    }
    public function product_details_who($id){
        $this->db->select('talep_form_nakliye_products.*,araclar.name,geopos_units.name as unit_name');
        $this->db->from('talep_form_nakliye_products');
        $this->db->join('araclar','talep_form_nakliye_products.arac_id=araclar.id','LEFT');
        $this->db->join('geopos_units','talep_form_nakliye_products.unit_id=geopos_units.id','LEFT');
        $this->db->where('talep_form_nakliye_products.id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function atama_list()

    {
        $this->_atama_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _atama_list()

    {

        $this->db->select('nakliye_mt_talep.*,geopos_employees.name as talep_eden_pers_name,talep_form_nakliye.code');
        $this->db->from('nakliye_mt_talep');
        $this->db->join('talep_form_nakliye','talep_form_nakliye.id=nakliye_mt_talep.talep_id');
        $this->db->join('geopos_employees','nakliye_mt_talep.aauth_id=geopos_employees.id');
        $i = 0;
//        if($this->input->post('status_id')!=0){
//            $this->db->where('talep_form_nakliye.status',$this->input->post('status_id'));
//        }
        $this->db->where('nakliye_mt_talep.mt_id is NULL');
        $this->db->order_by('`nakliye_mt_talep`.`id` ASC');
    }


    public function atama_count_filtered()
    {
        $this->_atama_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function atama_count_all()
    {
        $this->_atama_list();
        return $this->db->count_all_results();
    }


   public function list()

    {
        $this->_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _list()

    {

        $this->db->select('talep_form_nakliye.*,geopos_employees.name as pers_name,progress_status.name as progress_name,talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name,geopos_customers.company');
        $this->db->from('talep_form_nakliye');
        $this->db->join('geopos_employees','talep_form_nakliye.talep_eden_user_id=geopos_employees.id','left');
        $this->db->join('progress_status','talep_form_nakliye.progress_status_id=progress_status.id','LEFT');
        $this->db->join('geopos_projects','talep_form_nakliye.proje_id=geopos_projects.id','LEFT');
        $this->db->join('talep_form_status','talep_form_nakliye.status=talep_form_status.id','LEft');
        $this->db->join('geopos_customers','talep_form_nakliye.cari_id=geopos_customers.id','LEft');
        $i = 0;
        if($this->input->post('status_id')!=0){
            $this->db->where('talep_form_nakliye.status',$this->input->post('status_id'));
        }

        $this->db->where('talep_form_nakliye.type',1);

        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_nakliye.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        if($this->input->post('aauth')=='aauth'){
            $user_id  = $this->aauth->get_user()->id;
            $this->db->where('talep_form_nakliye.aauth', $user_id); //2019-11-23 14:28:57
        }
        if($this->input->post('proje_id')){
            $proje_id  = $this->input->post('proje_id');
            $this->db->where('talep_form_nakliye.proje_id', $proje_id); //2019-11-23 14:28:57
        }

        if($this->input->post('aauth')=='paylist'){
            $this->db->join('talep_form_nakliye_payment','talep_form_nakliye.id =talep_form_nakliye_payment.form_id');
            $this->db->where('talep_form_nakliye.alacak_durum ', 0); //2019-11-23 14:28:57
            $this->db->where('talep_form_nakliye.status ', 9); //2019-11-23 14:28:57
            $this->db->group_by('`talep_form_nakliye`.`id`');
        }


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
        } else {
            $this->db->order_by('`talep_form_nakliye`.`id` DESC');
        }
    }


    public function count_filtered()
    {
        $this->_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_list();
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
        $type =$this->input->post('type');
        $auth_id = $this->aauth->get_user()->id;
        $this->db->select('talep_form_nakliye.*,geopos_employees.name as pers_name,progress_status.name as progress_name,talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name,geopos_customers.company');
        $this->db->from('talep_form_nakliye');
        $this->db->join('geopos_employees','talep_form_nakliye.talep_eden_user_id=geopos_employees.id','LEFT');
        $this->db->join('progress_status','talep_form_nakliye.progress_status_id=progress_status.id','LEFT');
        $this->db->join('geopos_projects','talep_form_nakliye.proje_id=geopos_projects.id','LEFT');
        $this->db->join('talep_form_status','talep_form_nakliye.status=talep_form_status.id','LEFT');
        $this->db->join('geopos_customers','talep_form_nakliye.cari_id=geopos_customers.id','LEft');
        $this->db->join('talep_onay_nakliye','talep_form_nakliye.id=talep_onay_nakliye.talep_id','LEFT');
        $i = 0;
        if($this->input->post('status_id')!=0){
            $this->db->where('talep_form_nakliye.status',$this->input->post('status_id'));
        }

        $this->db->where('talep_form_nakliye.type',1);

        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_nakliye.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }


        $this->db->where("talep_onay_nakliye.type",$type);
        $this->db->where("talep_onay_nakliye.staff",1);
        $this->db->where("talep_onay_nakliye.user_id",$auth_id);



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

            $this->db->order_by($this->column_order_n[$search['0']['column']], $search['0']['dir']);
        } else {
            $this->db->order_by('`talep_form_nakliye`.`id` DESC');
        }
    }


    public function count_filtered_bekleyen()
    {
        $this->_ajax_list_onay_bekleyen();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_bekleyen()
    {
        $this->_ajax_list_onay_bekleyen();
        return $this->db->count_all_results();
    }


    public function mt_info_list()

    {
        $this->_mt_info_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _mt_info_list()

    {

        $n_item_id=$this->input->post('n_item_id');
        $m_talep_id=$this->input->post('m_talep_id');
        $nakliye_id=$this->input->post('talep_id');

        $this->db->select('tpnpa.*, SUM(quantity) as total');
        $this->db->from('talep_form_nakliye_product_arac tpnpa');
        $i = 0;
        $this->db->where('tpnpa.n_item_id ', $n_item_id);
        $this->db->where('tpnpa.m_talep_id ', $m_talep_id);
        $this->db->group_by('`tpnpa`.`m_item_id`');

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

//        $search = $this->input->post('order');
//        if ($search) {
//
//            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
//        } else {
//            $this->db->order_by('`tpnpa`.`id` DESC');
//        }

        $this->db->order_by('`tpnpa`.`id` DESC');
    }


    public function mt_info_count_filtered()
    {
        $this->_mt_info_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function mt_info_count_all()
    {
        $this->_mt_info_list();
        return $this->db->count_all_results();
    }

    public function form_total($id){
        $this->db->select('SUM(total) as total');
        $this->db->from('talep_form_nakliye_products');
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        return $query->row()->total;
    }
    public function form_total_bekleyen(){
        $this->db->select('SUM(total) as total');
        $this->db->from('talep_form_nakliye_products');
        $this->db->where('cost_id!=',0);
        $this->db->join('talep_form_nakliye','talep_form_nakliye_products.form_id=talep_form_nakliye.id');
        $this->db->where_not_in('talep_form_nakliye.status',[10,9]);
        $query = $this->db->get();
        return $query->row()->total;
    }
    public function form_total_bekleyen_method($method){
        $this->db->select('SUM(total) as total');
        $this->db->from('talep_form_nakliye_products');
        $this->db->where('cost_id!=',0);
        $this->db->join('talep_form_nakliye','talep_form_nakliye_products.form_id=talep_form_nakliye.id');
        $this->db->where_not_in('talep_form_nakliye.status',[10,9]);
        $this->db->where('talep_form_nakliye.method',$method);
        $query = $this->db->get();
        return $query->row()->total;
    }

    public function odeme_total($id){
        $this->db->select('SUM(total) as total');
        $this->db->from('talep_form_nakliye_payment');
        $this->db->where('form_id',$id);
        $this->db->where('tip',1);
        $query = $this->db->get();
        return $query->row()->total;
    }
    public function odeme_total_item($id){
        $this->db->select('SUM(total) as total');
        $this->db->from('talep_form_nakliye_payment');
        $this->db->where('form_item_id',$id);
        $this->db->where('tip',1);
        $query = $this->db->get();
        return $query->row()->total;
    }

    public function create_save(){
        //$all_users = $this->input->post('all_users');
        $progress_status_id = $this->input->post('progress_status_id');
        $talep_eden_user_id = $this->input->post('talep_eden_user_id');
        $proje_id = $this->input->post('proje_id');
        $method = $this->input->post('method');
        $cari_id = $this->input->post('cari_id');
        $desc = $this->input->post('desc');
        $image_text = $this->input->post('image_text');
        $demirbas_id = $this->input->post('demirbas_id');
        $firma_demirbas_id = $this->input->post('firma_demirbas_id');


        $talep_no = numaric(14);
        $data = array(
            'code' => $talep_no,
            'progress_status_id' => $progress_status_id,
            'talep_eden_user_id' => $talep_eden_user_id,
            'cari_id' => $cari_id,
            'method' => $method,
            'proje_id' => $proje_id,
            'desc' => $desc,
            'loc' =>  $this->session->userdata('set_firma_id'),
            'aauth' => $this->aauth->get_user()->id
        );
        if ($this->db->insert('talep_form_nakliye', $data)) {
            $last_id = $this->db->insert_id();
            numaric_update(14);

            $data_images = array(
                'image_text' => $image_text,
                'form_id' => $last_id,
            );
            $this->db->insert('talep_form_customer_files', $data_images);
            //all_user

            $this->aauth->applog("Nakliye Talebi Oluşturuldu  : Talep No : ".$talep_no, $this->aauth->get_user()->username);

            return [
                'status'=>1,
                'id'=>$last_id
            ];
        }
        else {
            return [
                'status'=>0,
                'id'=>0
            ];
        }
    }


    public function file_details($id){
        $this->db->select('*');
        $this->db->from('talep_form_nakliye_files');
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        return $query->result();
    }


    public function save_items(){
        $nakliye_item_id = $this->input->post('nakliye_item_id');
        $form_id = $this->input->post('form_id');
         $mt_id=$this->input->post('mt_id');
         $yukleyen_pers_id=$this->input->post('yukleyen_pers_id');
         $tehvil_pers_id=$this->input->post('tehvil_pers_id');
        $urun_cinsi=$this->input->post('urun_cinsi');
        $urun_m3=$this->input->post('urun_m3');
        $urun_agirlik=$this->input->post('urun_agirlik');
        $urun_tonaj=$this->input->post('urun_tonaj');

        if($mt_id){
            foreach ($mt_id as $mt_items){
                    $date_items=array(
                        'talep_id'=>$form_id,
                        'urun_cinsi'=>$urun_cinsi,
                        'urun_m3'=>$urun_m3,
                        'urun_agirlik'=>$urun_agirlik,
                        'urun_tonaj'=>$urun_tonaj,
                        'talep_item_id'=>$nakliye_item_id,
    //                      'yukleyen_pers_id'=>$yukleyen_pers_id,
    //                      'tehvil_pers_id'=>$tehvil_pers_id,
                        'mt_id'=>$mt_items,
                    );
                    $this->db->insert('talep_form_nakliye_to_mt', $date_items);
                }
//
//                $data_Form_items=array(
//                    'status'=>13,
//                );
//                $this->db->set($data_Form_items);
//                $this->db->where('id', $nakliye_item_id);
//                if($this->db->update('talep_form_nakliye_products', $data_Form_items)){
//
//                    return [
//                        'status'=>200,
//                        'messages'=>'Başarıyla Atamalar Yapıldı'
//                    ];
//                }
//                else {
//                    return [
//                        'status'=>1,
//                        'messages'=>'Atamalar Yapılırken Hata Aldınız.'
//                    ];
//                }

            return [
                        'status'=>200,
                        'messages'=>'Başarıyla Atamalar Yapıldı'
                    ];

            }
            else {
                return [
                    'status'=>0,
                    'messages'=>'Mt Zorunlu Seçimdir'
                ];
            }



    }

    public function create_form_items_satinalma(){
        $product_desc = $this->input->post('product_desc');
        $lokasyon = $this->input->post('lokasyon');
        $form_id = $this->input->post('form_id');
        $yukleme_yapacak_cari_id = $this->input->post('yukleme_yapacak_cari_id');
        $method = $this->input->post('method');
        $nakliye_item_tip = $this->input->post('nakliye_item_tip');
        $cari_id = $this->input->post('cari_id');
        $arac_id = $this->input->post('arac_id');
        $product_qty = $this->input->post('product_qty');
        $product_price = $this->input->post('product_price');
        $unit_id = $this->input->post('unit_id');
        $data = array(
            'product_desc' => $product_desc,
            'code' => numaric(43),
            'lokasyon' => $lokasyon,
            'cari_id' => $cari_id,
            'arac_id' => $arac_id,
            'product_qty' => $product_qty,
            'price' => $product_price,
            'unit_id' => $unit_id,
            'total' => $product_price*$product_qty,
            'nakliye_item_tip' => $nakliye_item_tip,
            'yukleme_yapacak_cari_id' => $yukleme_yapacak_cari_id,
            'method' => $method,
            'form_id' => $form_id,
            'aauth' => $this->aauth->get_user()->id
        );
        if ($this->db->insert('talep_form_nakliye_products', $data)) {
            $talep_form_products_id = $this->db->insert_id();
            numaric_update(43);

            $this->talep_history($form_id,$this->aauth->get_user()->id,'İtem Eklendi. ');
            $last_id = $this->db->insert_id();
            $this->aauth->applog("Nakliye Talebine Ürünler Eklendi  : Talep ID : ".$form_id, $this->aauth->get_user()->username);

            return [
                'status'=>1,
                'id'=>$last_id,
                'talep_form_products_id'=>$talep_form_products_id,
            ];
        }
        else {
            return [
                'status'=>0,
                'id'=>0
            ];
        }
    }
    public function create_form_items() {
        $product_desc = $this->input->post('product_desc');
        $lokasyon = $this->input->post('lokasyon');
        $form_id = $this->input->post('form_id');
        $yukleme_yapacak_cari_id = $this->input->post('yukleme_yapacak_cari_id');
        $method = $this->input->post('method');
        $nakliye_item_tip = $this->input->post('nakliye_item_tip');
        $cari_pers_type = $this->input->post('cari_pers_type');

        // Zorunlu alanlar kontrolü
        if (empty($lokasyon) || empty($yukleme_yapacak_cari_id) || empty($nakliye_item_tip) || empty($cari_pers_type)) {
            return [
                'status' => 0,
                'message' => 'Lokasyon, Yükleme Yapacak Cari / Personel, Yükleme Tipi ve Talep Tipi alanları zorunludur.'
            ];
        }

        $data = array(
            'product_desc' => $product_desc,
            'code' => numaric(43),
            'lokasyon' => $lokasyon,
            'unit_id' => 9,
            'nakliye_item_tip' => $nakliye_item_tip,
            'yukleme_yapacak_cari_id' => $yukleme_yapacak_cari_id,
            'method' => $method,
            'form_id' => $form_id,
            'cari_pers_type' => $cari_pers_type,
            'aauth' => $this->aauth->get_user()->id
        );

        if ($this->db->insert('talep_form_nakliye_products', $data)) {
            $talep_form_products_id = $this->db->insert_id();
            numaric_update(43);

            $this->talep_history($form_id, $this->aauth->get_user()->id, 'İtem Eklendi.');
            $last_id = $this->db->insert_id();
            $this->aauth->applog("Nakliye Talebine Ürünler Eklendi  : Talep ID : " . $form_id, $this->aauth->get_user()->username);

            return [
                'status' => 1,
                'id' => $last_id,
                'message' => 'Başarıyla Ürünler Eklendi',
                'talep_form_products_id' => $talep_form_products_id,
            ];
        } else {
            return [
                'status' => 0,
                'message' => 'Ürünler Eklenirken Hata Aldınız',
                'id' => 0
            ];
        }
    }


    public function talep_history($id,$user_id,$desc){
        date_default_timezone_set('Asia/Baku');
        $data_step = [
            'talep_id' => $id,
            'user_id' => $user_id,
            'desc' => $desc,
        ];
        $this->db->insert('talep_form_nakliye_history', $data_step);

    }

    public function save_mt_talep(){
        $nakliye_item_id = $this->input->post('nakliye_item_id');
        $form_id = $this->input->post('form_id');
        $mt_talep_personel = $this->input->post('mt_talep_personel');
        $talep_text = $this->input->post('talep_text');
        $data_step = [
            'talep_id' => $form_id,
            'mt_talep_personel_id' => $mt_talep_personel,
            'talep_text' => $talep_text,
            'talep_item_id' => $nakliye_item_id,
            'aauth_id' => $this->aauth->get_user()->id
        ];
        if($this->db->insert('nakliye_mt_talep', $data_step)){
            return [
                'status'=>1
            ];
        }
        else {
            return [
                'status'=>0
            ];
        }

    }
    public function send_mail($user_id,$subject,$message){
        $message .= "<br><br><br><br>";
        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
        $proje_sorumlusu_email = personel_detailsa($user_id)['email'];
        //$recipients = array($proje_sorumlusu_email);
        //$this->communication_model->onay_mail($recipients, $subject, $message, false,'', 'gider_talep_onay_maili');
        $config=[
            'protocol'=>'smtp',
            'smtp_host'=>'ssl://smtp.yandex.com',
            'smtp_port'=>465,
            'smtp_user'=>'Makro2000 ERP',
            'smtp_pass'=>'bulut220618',
            'mailtype'=>'html',
            'charset'=>'iso-8859-1',
            'wordwrap'=>true,
        ];
        $this->load->library('Email',$config);

        $this->email->from('info@makropro.az');
        $this->email->to($proje_sorumlusu_email);
        $this->email->subject($subject);
        $this->email->message($message);

        if( $this->email->send()){
            return true;
        }
        else {
            return false;
        }

    }



    public function odeme_talep(){
        $nakliye_item_id = $this->input->post('nakliye_item_id');
        $form_id = $this->input->post('form_id');
        $data_Form_items=array(
            'status'=>11,
        );
        //Ödeme Bekliyor
        $this->db->set($data_Form_items);
        $this->db->where('id', $nakliye_item_id);
        if($this->db->update('talep_form_nakliye_products', $data_Form_items)){



            $details_items =$this->product_details_who($nakliye_item_id);
            $details =$this->details($details_items->form_id);

            if($details_items->method==1)// Nakit
            {
                // Cari Alacaklandır
                $not = $details->code.' İstinaden Alacaklandırma';
                $data = array(
                    'csd' => $details_items->cari_id,
                    'payer' => customer_details($details_items->cari_id)['company'],
                    'acid' => 0, //hesapID ekleneck
                    'account' => 'Kasasız İşlem',
                    'total' => $details_items->total,
                    'invoice_type_id'=>39,
                    'invoice_type_desc'=>invoice_type_desc(39),
                    'method' => $details_items->method,
                    'eid' => $this->aauth->get_user()->id, //user_id
                    'notes' => $not,
                    'proje_id' => $details->proje_id,
                );
                if($this->db->insert('geopos_invoices', $data)) {
                    $data_talep_updata =
                        [
                            'alacak_durum' => 1,
                        ];
                    $this->db->where('id', $nakliye_item_id);
                    $this->db->set($data_talep_updata);
                    $this->db->update('talep_form_nakliye_products', $data_talep_updata);
                }
                // Cari Alacaklandır
            }






            return [
                'status'=>200,
                'messages'=>'Başarıyla Durum Değiştirildi'
            ];
        }
        else {
            return [
                'status'=>1,
                'messages'=>'Hata Aldınız.'
            ];
        }

    }
    public function transfer_item_add(){
        $n_id = $this->input->post('n_id');
        $n_item_id = $this->input->post('n_item_id');
        $warehouse_id = $this->input->post('warehouse_id');
        $type = $this->input->post('type');
        $sort = $this->input->post('sort');
        $text = $this->input->post('text_desc');
        $last_id=0;

        $kontrol = $this->db->query("SELECT * FROM nakliye_talep_transfer Where n_item_id=$n_item_id and n_id=$n_id");
        if($kontrol->num_rows())
        {
            $last_id=$kontrol->row()->id;
        }
        else{
            $data = array(
                'n_item_id' => $n_item_id,
                'n_id' => $n_id,
                'status_id' => 0,//Bekliyor
                'auth_id' => $this->aauth->get_user()->id, //user_id

            );
            $this->db->insert('nakliye_talep_transfer', $data);
            $last_id = $this->db->insert_id();

            }
            $data_items = array(
                'ntt_id' => $last_id,
                'warehouse_id' => $warehouse_id,
                'type' => $type,
                'sort' => $sort,
                'n_item_id' => $n_item_id,
                'text_desc' => $text,
                'auth_id' => $this->aauth->get_user()->id

            );
            if($this->db->insert('nakliye_talep_transfer_item', $data_items)){
                $item_last_id = $this->db->insert_id();
                $type_text='Yükleme Yapacak Depo';
                if($type==2){
                    $type_text='Teslim Alacak Depo';
                }
                return [
                    'status'=>200,
                    'type_text'=>$type_text,
                    'sort' => $sort,
                    'text' => $text,
                    'id' => $item_last_id,
                    'warehose_name'=>warehouse_details($warehouse_id)->title,
                    'messages'=>'Başarıyla Depo Eklendi'
                ];
            }
            else {
                return [
                    'status'=>410,
                    'messages'=>'Hata Aldınız'
                ];
            }

    }

    public function status_upda(){
        $status = $this->input->post('status');
        $file_id = $this->input->post('file_id');

        $details_ = $this->details($file_id);
        $now_status = $details_->status;

        $data = array(
            'status' => $status,
        );
        $this->db->set($data);
        $this->db->where('id', $file_id);
        if ($this->db->update('talep_form_nakliye', $data)) {

            if($status==10) // İptal ise Qaime var ise iptal et ve stok hareketlerini iptal et
            {

                $data_iptal = array(
                    'iptal_status' => $now_status,
                );
                $this->db->set($data_iptal);
                $this->db->where('id', $file_id);
                $this->db->update('talep_form_nakliye', $data_iptal);


                $desc = $this->input->post('desc');
                $this->talep_history($file_id,$this->aauth->get_user()->id,'Talep İptal Edildi.Açıklama : '.$desc);
                $this->aauth->applog("Nakliye Talebi İptal Edildi  : Talep No : ".$file_id, $this->aauth->get_user()->username);

            }
            elseif($status < 0){

                $data_iptal = array(
                    'status' => $details_->iptal_status,
                );
                $this->db->set($data_iptal);
                $this->db->where('id', $file_id);
                $this->db->update('talep_form_nakliye', $data_iptal);


                $desc = $this->input->post('desc');
                $this->talep_history($file_id,$this->aauth->get_user()->id,'Talep İptal Geri Alındı.Açıklama : '.$desc);
                $this->aauth->applog("Nakliye İptal Edildi  : Talep No : ".$file_id, $this->aauth->get_user()->username);


            }
            else {
                $desc = $this->input->post('desc');
                $st_name = talep_form_status_details($now_status)->name;
                $this->talep_history($file_id,$this->aauth->get_user()->id,'Durum Güncellendi.Status :'.$st_name.' .Açıklama : '.$desc);
                $this->aauth->applog("Nakliye Talebi Durum Güncellendi  : Talep No : ".$file_id, $this->aauth->get_user()->username);

            }

            return [
                'status'=>1,
                'id'=>$file_id
            ];

        }
        else {
            return [
                'status'=>0,
                'id'=>0
            ];
        }
    }

    public function update_form(){


        $talep_eden_user_id = $this->input->post('talep_eden_user_id');
        $proje_id = $this->input->post('proje_id');
        $desc = $this->input->post('desc');
        $file_id = $this->input->post('file_id');


        $data = array(
            'talep_eden_user_id' => $talep_eden_user_id,
            'proje_id' => $proje_id,
            'desc' => $desc,
            'aauth' => $this->aauth->get_user()->id
        );
        $this->db->set($data);
        $this->db->where('id', $file_id);
        if ($this->db->update('talep_form_nakliye', $data)) {

            $this->aauth->applog("Nakliye Talebi Güncellendi  : Talep No : ".$file_id, $this->aauth->get_user()->username);
            return [
                'status'=>1,
                'id'=>$file_id
            ];

        }
        else {
            return [
                'status'=>0,
                'id'=>0
            ];
        }
    }


    public function list_report()

    {
        $this->_list_report();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _list_report()

    {

        $this->db->select('talep_form_nakliye.*,
        geopos_employees.name as pers_name,
        progress_status.name as progress_name,
        talep_form_status.color as color,
        geopos_projects.code as proje_name,
        talep_form_status.name as st_name,
        geopos_customers.company,
        talep_form_nakliye_products.code as p_code,
        talep_form_nakliye_products.price as p_price,
        talep_form_nakliye_products.product_qty as p_qty,
        talep_form_nakliye_products.total as p_total,
        talep_form_nakliye_products.lokasyon as p_lokasyon,
        talep_form_nakliye_products.unit_id as p_unit_id,
        ');
        $this->db->from('talep_form_nakliye');
        $this->db->join('talep_form_nakliye_products','talep_form_nakliye.id=talep_form_nakliye_products.form_id');
        $this->db->join('geopos_employees','talep_form_nakliye.talep_eden_user_id=geopos_employees.id','left');
        $this->db->join('progress_status','talep_form_nakliye.progress_status_id=progress_status.id','LEFT');
        $this->db->join('geopos_projects','talep_form_nakliye.proje_id=geopos_projects.id','LEFT');
        $this->db->join('talep_form_status','talep_form_nakliye_products.status=talep_form_status.id','LEft');
        $this->db->join('geopos_customers','talep_form_nakliye_products.cari_id=geopos_customers.id','LEft');
        $i = 0;
        if($this->input->post('status_id')!=0){
            $this->db->where('talep_form_nakliye.status',$this->input->post('status_id'));
        }

        $this->db->where('talep_form_nakliye.type',1);

        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_nakliye.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        if($this->input->post('aauth')=='aauth'){
            $user_id  = $this->aauth->get_user()->id;
            $this->db->where('talep_form_nakliye.aauth', $user_id); //2019-11-23 14:28:57
        }
        if($this->input->post('proje_id')){
            $proje_id  = $this->input->post('proje_id');
            $this->db->where('talep_form_nakliye.proje_id', $proje_id); //2019-11-23 14:28:57
        }

        if($this->input->post('cari_id')){
            $cari_id  = $this->input->post('cari_id');
            $this->db->where('talep_form_nakliye_products.cari_id', $cari_id); //2019-11-23 14:28:57
        }

        if($this->input->post('talep_tipi')){
            $talep_tipi  = $this->input->post('talep_tipi');
            $this->db->where('talep_form_nakliye_products.nakliye_item_tip', $talep_tipi); //2019-11-23 14:28:57
        }

        if($this->input->post('aauth')=='paylist'){
            $this->db->join('talep_form_nakliye_payment','talep_form_nakliye.id =talep_form_nakliye_payment.form_id');
            $this->db->where('talep_form_nakliye.alacak_durum ', 0); //2019-11-23 14:28:57
            $this->db->where('talep_form_nakliye.status ', 9); //2019-11-23 14:28:57
            $this->db->group_by('`talep_form_nakliye`.`id`');
        }


        foreach ($this->column_search_item as $item) // loop column

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

                if (count($this->column_search_item) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }

        $search = $this->input->post('order');
        if ($search) {

            $this->db->order_by($this->column_order_item[$search['0']['column']], $search['0']['dir']);
        } else {
            $this->db->order_by('`talep_form_nakliye`.`id` DESC');
        }
    }


    public function count_filtered_report()
    {
        $this->_list_report();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_report()
    {
        $this->_list_report();
        return $this->db->count_all_results();
    }



    public function get_datatables_query_details_talep_list_notes($id)

    {
        $this->_get_datatables_query_details_talep_list_notes($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _get_datatables_query_details_talep_list_notes($id)
    {

        $this->db->select('talep_form_notes_nakliye.*,geopos_employees.name as pers_name');
        $this->db->from('talep_form_notes_nakliye');
        $this->db->join('geopos_employees','talep_form_notes_nakliye.aaut_id=geopos_employees.id');
        $this->db->where('talep_form_notes_nakliye.talep_id',$id);
        $i = 0;
        foreach ($this->column_search_notes as $item) // loop column
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

                if (count($this->column_search_notes) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`talep_form_notes_nakliye`.`id` DESC');

    }


    public function count_filtered_talep_notes($id)
    {
        $this->_get_datatables_query_details_talep_list_notes($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_talep_notes($id)
    {
        $this->_get_datatables_query_details_talep_list_notes($id);
        return $this->db->count_all_results();
    }

    public function create_save_notes(){
        //$all_users = $this->input->post('all_users');
        $table_notes = $this->input->post('table_notes');
        $talep_id = $this->input->post('talep_id');
        $talep_no = $this->details($talep_id)->code;
        $data = array(
            'desc' => $table_notes,
            'talep_id' => $talep_id,
            'aaut_id' => $this->aauth->get_user()->id
        );
        if ($this->db->insert('talep_form_notes_nakliye', $data)) {
            $this->aauth->applog("Nakliye Talebine Not Eklendi  : Talep No : ".$talep_no, $this->aauth->get_user()->username);

            return [
                'status'=>1,
                'id'=>$talep_id
            ];
        }
        else {
            return [
                'status'=>0,
                'id'=>0
            ];
        }
    }

    public function nakliye_mt_talep(){
        $user_id= $this->aauth->get_user()->id;
        $mt_olusturma_bekleyen  = $this->db->query("SELECT * FROM nakliye_mt_talep Where mt_talep_personel_id = $user_id and mt_id is null")->num_rows();

        return [
            'status'=>1,
            'count'=>$mt_olusturma_bekleyen
        ];
    }

    public function nakliyeteklifbekleyen(){
        $user_id=$this->aauth->get_user()->id;
        $count = 0;
        //if($user_id==lojistik_yetkili_id()){
        if($user_id==lojistik_yetkili_id()){
            $count = $this->db->query("SELECT * FROM talep_form_nakliye Where status=3")->num_rows();
        }
        return [
            'status'=>1,
            'count'=>$count
        ];
    }
}