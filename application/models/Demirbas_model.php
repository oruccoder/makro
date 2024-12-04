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





class Demirbas_model extends CI_Model
{


    var $column_order = array('demirbas_group.id','demirbas_group.code', 'demirbas_group.name', 'demirbas_group.desc',null);

    var $column_search = array('firma_gider.created_at','firma_gider.item_name','firma_gider.item_desc','firma_gider_products.product_qty','firma_gider_products.unit_id','firma_gider_products.price',
        'firma_gider.code','talep_form_status.name');

    var $column_search_d = array('demirbas_group.name','demirbas_group.code','demirbas_group.desc');
    var $column_order_d = array(null,'demirbas_group.code','demirbas_group.name',null,null);

    var $column_order_gider = array('firma_gider.created_at','firma_gider.item_name','firma_gider_products.product_qty','firma_gider_products.unit_id','firma_gider_products.price',
        'firma_gider.code','talep_form_status.name');

    var $column_order_personel = array('talep_form_personel.created_at','demirbas_firma.table_name','talep_form_personel_products.product_qty','talep_form_personel_products.unit_id','talep_form_personel_products.price',
        'talep_form_personel.code','talep_form_status.name');

    public function __construct()
    {
        parent::__construct();

    }


    public function ajax_list(){
        $this->_ajax_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _ajax_list()
    {

        $this->db->select('*');
        $this->db->from('demirbas_group');
        $this->db->where('type',1);
        $i = 0;
        foreach ($this->column_search_d as $item) // loop column
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

                if (count($this->column_search_d) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order_d[$search['0']['column']], $search['0']['dir']);

        }
        else {
            $this->db->order_by('`demirbas_group`.`id` DESC');
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



    public function ajax_list_view(){
        $this->_ajax_list_view();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _ajax_list_view()
    {

        $demirbas_group_id = $this->input->post("demisbas_id");
        $this->db->select('demirbas_group.*');
        $this->db->from('demirbas_group');
        $this->db->join('demirbas_parent','demirbas_parent.demirbas_group_id=demirbas_group.id','LEFT');
        $this->db->where('demirbas_group.demirbas_id',$demirbas_group_id);
        $i = 0;
        foreach ($this->column_search_d as $item) // loop column
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

                if (count($this->column_search_d) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);

        }
        else {
            $this->db->order_by('`demirbas_group`.`id` DESC');
        }
        $this->db->group_by('demirbas_group.name');

    }
    public function count_filtered_view()
    {
        $this->_ajax_list_view();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_view()
    {
        $this->_ajax_list_view();
        return $this->db->count_all_results();
    }




    public function ajax_list_gider(){
        $this->_ajax_list_gider();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _ajax_list_gider()
    {

        $firma_demirbas_id = $this->input->post("demisbas_id"); //38
        $ana_grup_who_id=0;


        $parent_kontrol = $this->db->query("SELECT * FROM demirbas_parent Where parent_id=$firma_demirbas_id");

        if($parent_kontrol->num_rows())// true ise
        {
            $ana_id = $parent_kontrol->row()->demirbas_group_id;

            $ana_grup_who_srg = $this->db->query("SELECT * FROM demirbas_parent Where parent_id=$ana_id");
            if($ana_grup_who_srg->num_rows()){
                $ana_grup_who_id=$ana_grup_who_srg->row()->demirbas_group_id;
                $ana_grup_who_new = $this->db->query("SELECT * FROM demirbas_parent Where parent_id=$ana_grup_who_id");
                if($ana_grup_who_new->num_rows()){
                    $ana_grup_who_id=$ana_grup_who_new->row()->demirbas_group_id;
                }
                else {
                    $ana_grup_who_id = $this->details($ana_grup_who_id)->demirbas_id;
                }

            }
            else {
                $ana_grup_who_id = $this->details($ana_id)->demirbas_id;
            }
        }
        else {
            $ana_grup_who_id = $this->details($firma_demirbas_id)->demirbas_id;
        }



        $table_name = $this->db->query("SELECT * FROM demirbas_firma Where demirbas_id=$ana_grup_who_id")->row()->table_name;

        $this->db->select('
        firma_gider.type,
        firma_gider.talep_id,
        firma_gider.created_at,
        firma_gider.item_name,
        firma_gider.item_desc,
        firma_gider_products.product_qty,
        firma_gider_products.unit_id,
        firma_gider_products.price,
       firma_gider.code,
       firma_gider.firma_demirbas_id,
       talep_form_status.name as status_name');
        $this->db->from('firma_gider_products');
        $this->db->join('firma_gider',' firma_gider_products.form_id=firma_gider.id');
        $this->db->join('talep_form_status','firma_gider.status=talep_form_status.id');
        $this->db->where('firma_gider_products.cost_id',$firma_demirbas_id);
        $i = 0;

        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(firma_gider_products.created_at) >=', datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where('DATE(firma_gider_products.created_at) <=', datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
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

            $this->db->order_by($this->column_order_gider[$search['0']['column']], $search['0']['dir']);

        }
        else {
            $this->db->order_by('`firma_gider`.`id` DESC');
        }




    }
    public function count_filtered_gider()
    {
        $this->_ajax_list_gider();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_gider()
    {
        $this->_ajax_list_gider();
        return $this->db->count_all_results();
    }

    public function ajax_list_gider_firma(){
        $this->_ajax_list_gider_firma();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _ajax_list_gider_firma()
    {

        $firma_demirbas_id = $this->input->post("demisbas_id");
        $table_name = $this->input->post("table_name");

        $this->db->select('
        firma_gider.type,
        firma_gider.talep_id,
        firma_gider.created_at,
        firma_gider.item_name,
        firma_gider.item_desc,
        demirbas_group.name as dg_name,
        firma_gider_products.product_qty,
        firma_gider_products.unit_id,
        firma_gider_products.price,
       firma_gider.code,
       firma_gider.firma_demirbas_id,
       talep_form_status.name as status_name');
        $this->db->from('firma_gider_products');
        $this->db->join('firma_gider',' firma_gider_products.form_id=firma_gider.id');
        $this->db->join('demirbas_group','firma_gider_products.cost_id=demirbas_group.id');
        $this->db->join('talep_form_status','firma_gider.status=talep_form_status.id');
        $this->db->where('firma_gider.firma_demirbas_id',$firma_demirbas_id);
        $this->db->where('firma_gider.table_name',$table_name);
        $i = 0;

        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(firma_gider_products.created_at) >=', datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where('DATE(firma_gider_products.created_at) <=', datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
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

//        if ($search) {
//
//            $this->db->order_by($this->column_order_gider[$search['0']['column']], $search['0']['dir']);
//
//        }
//        else {
//
//        }

        $this->db->order_by('`firma_gider`.`id` DESC');





    }
    public function count_filtered_gider_firma()
    {
        $this->_ajax_list_gider_firma();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_gider_firma()
    {
        $this->_ajax_list_gider_firma();
        return $this->db->count_all_results();
    }



    public function ajax_list_view_alt(){
        $this->_ajax_list_view_alt();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _ajax_list_view_alt()
    {

        $demirbas_group_id = $this->input->post("demisbas_id");
        $this->db->select('demirbas_group.*');
        $this->db->from('demirbas_parent');
        $this->db->join('demirbas_group','demirbas_parent.parent_id = demirbas_group.id');
        $this->db->where('demirbas_group_id',$demirbas_group_id);
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

        }
        else {
            $this->db->order_by('`demirbas_group`.`id` DESC');
        }

    }
    public function count_filtered_view_alt()
    {
        $this->_ajax_list_view_alt();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_view_alt()
    {
        $this->_ajax_list_view_alt();
        return $this->db->count_all_results();
    }

    public function create_save(){


        $group_id_arr = $this->input->post('group_id');
        $group_id=0;
        if($group_id_arr){
            $group_id = $group_id_arr[array_key_last($group_id_arr)];
            $ar_count=count($group_id_arr);
            if($group_id==0){
                $eq = intval($ar_count)-1;
                if($eq<=0){
                    $group_id=0;
                }
                else {
                    $eq=$eq-1;
                    $group_id=$group_id_arr[$eq];
                }
            }
        }




        $desc = $this->input->post('desc');
        $name = $this->input->post('name');
        $table_name = $this->input->post('table_name');
        $talep_no = numaric(37);
        $data = array(
            'code'=>$talep_no,
            'name'=>$name,
            'desc'=>$desc,
            'user_id' => $this->aauth->get_user()->id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        $index=0;
        if ($this->db->insert('demirbas_group', $data)) {
            $last_id = $this->db->insert_id();
            numaric_update(37);
            if($group_id){
                $data_parent = array(
                    'demirbas_group_id'=>$group_id,
                    'parent_id'=>$last_id,

                );
                $this->db->insert('demirbas_parent', $data_parent);


            }

            $data_table = array(
                'demirbas_id'=>$last_id,
                'table_name'=>$table_name,

            );
            $this->db->insert('demirbas_firma', $data_table);


            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Grup Eklendi',
            ];
        }
        else{
            return [
                'status'=>0,
                'message'=>'Litr Eklenirken Hata Aldınız',
            ];
        }
    }


    public function gider_create_form($file_id,$type){


        if($type==1){
            $details = $this->db->query("SELECT * FROM talep_form_customer_new Where id=$file_id")->row();
            $details_items = $this->db->query("SELECT * FROM talep_form_customer_products_new Where form_id=$file_id");
            if($details_items->num_rows()){
                $d_items =$details_items->result();
                if($details->demirbas_id==-1){
                    $say=0;
                    foreach ($d_items as $d_item_value){
                        $connect_details  = $this->db->query("SELECT * FROM gider_sepet_connect Where item_id = $d_item_value->id")->row();
                        $item_firma_demirbas_id = $connect_details->firma_demirbas_id;
                        $item_demirbas_id = $connect_details->demirbas_id;
                        $table_name='';
                        $item_name='';
                        $item_desc='';
                        $item_image='';

                        $table_name_ = $this->db->query("SELECT * FROM demirbas_firma Where demirbas_id = $item_demirbas_id")->row()->table_name;
                        if($table_name_=='araclar'){
                            $table_name='araclar';
                            $item_details = $this->db->query("SELECT * FROM araclar Where id = $item_firma_demirbas_id")->row();
                            $item_name = $item_details->plaka;
                            $item_desc = $item_details->code;
                            $item_image = $item_details->image_text;
                        }
                        elseif($table_name_=='geopos_employees'){
                            $table_name='geopos_employees';
                            $item_details = $this->db->query("SELECT * FROM geopos_employees Where id = $item_firma_demirbas_id")->row();
                            $item_name = $item_details->name;
                            $item_desc = $item_details->id;
                            $item_image = $item_details->picture;
                        }
                        else{

                            $item_details = $this->db->query("SELECT * FROM $table_name_ Where id = $item_firma_demirbas_id")->row();
                            $item_name = $item_details->name;
                            $item_desc = $item_details->id;
                            $item_image = '';
                        }

                        $talep_no = numaric(39);
                        $data = array(
                            'code' => $talep_no,
                            'progress_status_id' => $details->progress_status_id,
                            'talep_eden_user_id' => $details->talep_eden_user_id,
                            'cari_id' => $details->cari_id,
                            'method' => $details->method,
                            'proje_id' => $details->proje_id,
                            'desc' => $details->desc,
                            'demirbas_id' => $item_demirbas_id,
                            'firma_demirbas_id' => $item_firma_demirbas_id,
                            'loc' =>  $details->loc,
                            'aauth' => $this->aauth->get_user()->id,
                            'table_name' => $table_name_,
                            'item_name' => $item_name,
                            'item_desc' => $item_desc,
                            'item_image' => $item_image,
                            'talep_id' => $file_id,
                            'type' => $type,
                        );
                        if ($this->db->insert('firma_gider', $data)) {
                            $last_id = $this->db->insert_id();
                            numaric_update(39);

                            $data_items = array(
                                'cost_id' => $d_item_value->cost_id,
                                'product_desc' => $d_item_value->product_desc,
                                'unit_id' => $d_item_value->unit_id,
                                'product_qty' => $d_item_value->product_qty,
                                'price' => $d_item_value->price,
                                'total' => $d_item_value->total,
                                'form_id' => $last_id,
                                'aauth' => $this->aauth->get_user()->id
                            );
                            if($this->db->insert('firma_gider_products', $data_items)){

                                $say++;
                            }

                        }
                    }

                    if($say==$details_items->num_rows()){

                        $data_update = array(
                            'gider_durumu' => 1,
                            'gider_id' => $last_id,
                        );
                        $this->db->set($data_update);
                        $this->db->where('id', $file_id);
                        $this->db->update('talep_form_customer_new', $data_update);

                        return [
                            'status'=>1,
                            'message'=>'Başarıyla Oluşturuldu'
                        ];
                    }
                    else {
                        return [
                            'status'=>0,
                            'message'=>'Hata Aldınız'
                        ];
                    }
                }
                else {
                    $table_name='';
                    $item_name='';
                    $item_desc='';
                    $item_image='';
                    $table_name_ = $this->db->query("SELECT * FROM demirbas_firma Where demirbas_id = $details->demirbas_id")->row()->table_name;
                    if($table_name_=='araclar'){
                        $table_name='araclar';
                        $item_details = $this->db->query("SELECT * FROM araclar Where id = $details->firma_demirbas_id")->row();
                        $item_name = $item_details->plaka;
                        $item_desc = $item_details->code;
                        $item_image = $item_details->image_text;
                    }
                    elseif($table_name_=='geopos_employees'){
                        $table_name='geopos_employees';
                        $item_details = $this->db->query("SELECT * FROM geopos_employees Where id = $details->firma_demirbas_id")->row();
                        $item_name = $item_details->name;
                        $item_desc = $item_details->id;
                        $item_image = $item_details->picture;
                    }
                    else{

                        $item_details = $this->db->query("SELECT * FROM $table_name_ Where id = $details->firma_demirbas_id")->row();
                        $item_name = $item_details->name;
                        $item_desc = $item_details->id;
                        $item_image = '';
                    }


                    $talep_no = numaric(39);
                    $data = array(
                        'code' => $talep_no,
                        'progress_status_id' => $details->progress_status_id,
                        'talep_eden_user_id' => $details->talep_eden_user_id,
                        'cari_id' => $details->cari_id,
                        'method' => $details->method,
                        'proje_id' => $details->proje_id,
                        'desc' => $details->desc,
                        'demirbas_id' => $details->demirbas_id,
                        'firma_demirbas_id' => $details->firma_demirbas_id,
                        'loc' =>  $details->loc,
                        'aauth' => $this->aauth->get_user()->id,
                        'table_name' => $table_name_,
                        'item_name' => $item_name,
                        'item_desc' => $item_desc,
                        'item_image' => $item_image,
                        'talep_id' => $file_id,
                        'type' => $type,
                    );
                    if ($this->db->insert('firma_gider', $data)) {
                        $last_id = $this->db->insert_id();
                        numaric_update(39);
                        foreach ($d_items as $items){
                            $data_items = array(
                                'cost_id' => $items->cost_id,
                                'product_desc' => $items->product_desc,
                                'unit_id' => $items->unit_id,
                                'product_qty' => $items->product_qty,
                                'price' => $items->price,
                                'total' => $items->total,
                                'form_id' => $last_id,
                                'aauth' => $this->aauth->get_user()->id
                            );
                            $this->db->insert('firma_gider_products', $data_items);
                        }

                        $data_update = array(
                            'gider_durumu' => 1,
                            'gider_id' => $last_id,
                        );
                        $this->db->set($data_update);
                        $this->db->where('id', $file_id);
                        $this->db->update('talep_form_customer_new', $data_update);


                        return [
                            'status'=>1,
                            'message'=>'Başarıyla Oluşturuldu'
                        ];
                    }
                    else {
                        return [
                            'status'=>0,
                            'id'=>0
                        ];
                    }

                }



            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Talep Formunda Gider Kalemleri Bulunmamaktadır',
                ];
            }

        } //cari Gider Talebi
        elseif($type==2){
            $details = $this->db->query("SELECT * FROM talep_form_personel Where id=$file_id")->row();
            $details_items = $this->db->query("SELECT * FROM talep_form_personel_products Where form_id=$file_id");
            if($details_items->num_rows()){
                $d_items =$details_items->result();

                $table_name='';
                $item_name='';
                $item_desc='';
                $item_image='';
                $table_name_ = $this->db->query("SELECT * FROM demirbas_firma Where demirbas_id = $details->demirbas_id")->row()->table_name;
                if($table_name_=='araclar'){
                    $table_name='araclar';
                    $item_details = $this->db->query("SELECT * FROM araclar Where id = $details->firma_demirbas_id")->row();
                    $item_name = $item_details->plaka;
                    $item_desc = $item_details->code;
                    $item_image = $item_details->image_text;
                }
                elseif($table_name_=='geopos_employees'){
                    $table_name='geopos_employees';
                    $item_details = $this->db->query("SELECT * FROM geopos_employees Where id = $details->firma_demirbas_id")->row();
                    $item_name = $item_details->name;
                    $item_desc = $item_details->id;
                    $item_image = $item_details->picture;
                }


                $talep_no = numaric(39);
                $data = array(
                    'code' => $talep_no,
                    'progress_status_id' => $details->progress_status_id,
                    'talep_eden_user_id' => $details->talep_eden_user_id,
                    'cari_id' => $details->talep_eden_user_id,
                    'method' => $details->method,
                    'proje_id' => $details->proje_id,
                    'desc' => $details->desc,
                    'demirbas_id' => $details->demirbas_id,
                    'firma_demirbas_id' => $details->firma_demirbas_id,
                    'loc' =>  $details->loc,
                    'aauth' => $this->aauth->get_user()->id,
                    'table_name' => $table_name,
                    'item_name' => $item_name,
                    'item_desc' => $item_desc,
                    'item_image' => $item_image,
                    'talep_id' => $file_id,
                    'type' => $type,
                );
                if ($this->db->insert('firma_gider', $data)) {
                    $last_id = $this->db->insert_id();
                    numaric_update(39);
                    foreach ($d_items as $items){
                        $data_items = array(
                            'cost_id' => $items->cost_id,
                            'product_desc' => $items->product_desc,
                            'unit_id' => $items->unit_id,
                            'product_qty' => $items->product_qty,
                            'price' => $items->price,
                            'total' => $items->total,
                            'form_id' => $last_id,
                            'aauth' => $this->aauth->get_user()->id
                        );
                        $this->db->insert('firma_gider_products', $data_items);
                    }

                    $data_update = array(
                        'gider_durumu' => 1,
                        'gider_id' => $last_id,
                    );
                    $this->db->set($data_update);
                    $this->db->where('id', $file_id);
                    $this->db->update('talep_form_personel', $data_update);


                    return [
                        'status'=>1,
                        'message'=>'Başarıyla Oluşturuldu'
                    ];
                }
                else {
                    return [
                        'status'=>0,
                        'id'=>0
                    ];
                }


            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Talep Formunda Gider Kalemleri Bulunmamaktadır',
                ];
            }
        } // Personel Gider Talebi
        elseif($type==3){
            $gider_kalemi_id = $this->input->post('group_id');
            $product_details = $this->input->post('product_details');
            $demirbas_id = $this->input->post('demirbas_id');
            $_firma_demirbas_id = $this->input->post('firma_demirbas_id');

            $details = $this->db->query("SELECT * FROM talep_form Where id=$file_id")->row();

            $table_name_='geopos_products';

            $say = count($product_details);
            $i=0;
            foreach ($product_details as $items){


                $product_id = $items['product_id'];


                $item_name='';
                $item_desc='';
                $item_image='';
                $table_name_ = $this->db->query("SELECT * FROM demirbas_firma Where demirbas_id = $demirbas_id")->row()->table_name;
                if($table_name_=='araclar'){
                    $table_name='araclar';
                    $item_details = $this->db->query("SELECT * FROM araclar Where id = $_firma_demirbas_id")->row();
                    $item_name = $item_details->plaka;
                    $item_desc = $item_details->code;
                    $item_image = $item_details->image_text;
                }
                elseif($table_name_=='geopos_employees'){
                    $table_name='geopos_employees';
                    $item_details = $this->db->query("SELECT * FROM geopos_employees Where id = $_firma_demirbas_id")->row();
                    $item_name = $item_details->name;
                    $item_desc = $item_details->id;
                    $item_image = $item_details->picture;
                }
                else{

                    $item_details = $this->db->query("SELECT * FROM $table_name_ Where id = $_firma_demirbas_id")->row();
                    $item_name = $item_details->name;
                    $item_desc = $item_details->id;
                    $item_image = '';
                }


                $talep_no = numaric(39);
                $data = array(
                    'code' => $talep_no,
                    'progress_status_id' => $details->progress_status_id,
                    'talep_eden_user_id' => $details->talep_eden_user_id,
                    'cari_id' => 0,
                    'method' => 0,
                    'proje_id' => $details->proje_id,
                    'desc' => $details->desc,
                    'demirbas_id' => $demirbas_id,
                    'firma_demirbas_id' => $_firma_demirbas_id,
                    'loc' =>  $details->loc,
                    'aauth' => $this->aauth->get_user()->id,
                    'table_name' => $table_name_,
                    'item_name' => $item_name,
                    'item_desc' => $item_desc,
                    'item_image' => $item_image,
                    'talep_id' => $file_id,
                    'type' => $type,
                );
                if ($this->db->insert('firma_gider', $data)) {
                    $last_id = $this->db->insert_id();
                    numaric_update(39);

                    $data_items = array(
                        'cost_id' => $gider_kalemi_id,
                        'product_desc' => '',
                        'unit_id' => $items['new_unit_id'],
                        'product_qty' => $items['new_item_qty'],
                        'price' => $items['new_item_price'],
                        'total' => $items['item_umumi_cemi_hidden'],
                        'form_id' => $last_id,
                        'aauth' => $this->aauth->get_user()->id
                    );
                    $this->db->insert('firma_gider_products', $data_items);

                    $data_update = array(
                        'gider_durumu' => 1,
                        'gider_id' => $last_id,
                    );
                    $this->db->set($data_update);
                    $this->db->where('id', $items['talep_form_product_id']);
                    $this->db->update('talep_form_products', $data_update);
                    $i++;



                }

            }

            if($say==$i){
                return [
                    'status'=>1,
                    'message'=>'Başarıyla Oluşturuldu'
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız'
                ];
            }






        } // Malzeme Talep Gideri
        elseif($type==4){ //faturalaştırma
            $details = $this->db->query("SELECT * FROM talep_form_customer_new Where id=$file_id")->row();
            if($details->method==3){
                $details_items = $this->db->query("SELECT * FROM talep_form_customer_products_new Where form_id=$file_id");
                if($details_items->num_rows()){
                    $d_items =$details_items->result();

                    $table_name='';
                    $item_name='';
                    $item_desc='';
                    $item_image='';
                    $table_name_ = $this->db->query("SELECT * FROM demirbas_firma Where demirbas_id = $details->demirbas_id")->row()->table_name;
                    if($table_name_=='araclar'){
                        $table_name='araclar';
                        $item_details = $this->db->query("SELECT * FROM araclar Where id = $details->firma_demirbas_id")->row();
                        $item_name = $item_details->plaka;
                        $item_desc = $item_details->code;
                        $item_image = $item_details->image_text;
                    }
                    elseif($table_name_=='geopos_employees'){
                        $table_name='geopos_employees';
                        $item_details = $this->db->query("SELECT * FROM geopos_employees Where id = $details->firma_demirbas_id")->row();
                        $item_name = $item_details->name;
                        $item_desc = $item_details->id;
                        $item_image = $item_details->picture;
                    }
                    else{

                        $item_details = $this->db->query("SELECT * FROM $table_name_ Where id = $details->firma_demirbas_id")->row();
                        $item_name = $item_details->name;
                        $item_desc = $item_details->id;
                        $item_image = '';
                    }


                    $subtotal=0;
                    $total=0;
                    $data = array(
                        'invoice_no' => $details->code,
                        'invoicedate' => $details->created_at,
                        'invoiceduedate' => $details->created_at,
                        'subtotal' => 0,
                        'shipping' => 0,
                        'ship_tax' => 0,
                        'invoice_type_id' => 24,
                        'invoice_type_desc' => invoice_type_id(24),
                        'ship_tax_type' => 0,
                        'total' => $total,
                        'notes' => $details->desc,
                        'csd' => $details->cari_id,
                        'eid' => $this->aauth->get_user()->id,
                        'loc' => $this->aauth->get_user()->loc,
                        'proje_id' => $details->proje_id,
                        'method' => $details->method,
                    );
                    if ($this->db->insert('geopos_invoices', $data)) {
                        $last_id = $this->db->insert_id();
                        $totals=0;
                        foreach ($d_items as $items){

                            $data_items = array(

                                'tid' => $last_id,
                                'pid' => $items->cost_id,
                                'product' => who_demirbas($items->cost_id)->name,
                                'qty' => $items->product_qty,
                                'price' => $items->price,
                                'subtotal' => $items->total,
                                'unit' => $items->unit_id,
                                'invoice_type_id' => 24,
                                'proje_id' => $details->proje_id,
                                'invoice_type_desc' => invoice_type_id(24)
                            );

                            $this->db->insert('geopos_invoice_items', $data_items);
                            $totals+=$items->total;
                        }

                        $data_update = array(
                            'invoice_durumu' => 1,
                            'invoice_id' => $last_id,
                            'alacak_durum' => 1,
                        );
                        $this->db->set($data_update);
                        $this->db->where('id', $file_id);
                        $this->db->update('talep_form_customer_new', $data_update);


                        $this->db->set(array(
                                'subtotal' => $totals,
                                'total' => $totals,

                            )
                        );

                        $this->db->where('id', $last_id);

                        $this->db->update('geopos_invoices');


                        return [
                            'status'=>1,
                            'message'=>'Başarıyla Oluşturuldu'
                        ];
                    }
                    else {
                        return [
                            'status'=>0,
                            'id'=>0
                        ];
                    }


                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Talep Formunda Gider Kalemleri Bulunmamaktadır',
                    ];
                }
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Ödeme Metodu Bank Olmalıdır!',
                ];
            }

        } // Cari gider talebi faturalaştırma
        elseif($type==5){
            $gider_kalemi_id = $this->input->post('group_id');
            $product_details = $this->input->post('product_details');
            $demirbas_id = $this->input->post('demirbas_id');
            $firma_demirbas_id = $this->input->post('firma_demirbas_id');
            $details = $this->db->query("SELECT * FROM geopos_invoices Where id=$file_id")->row();

            $table_name_ = $this->db->query("SELECT * FROM demirbas_firma Where demirbas_id = $demirbas_id")->row()->table_name;

            $item_name='';
            $item_desc='';
            $item_image='';
            if($table_name_=='araclar'){
                $table_name='araclar';
                $item_details = $this->db->query("SELECT * FROM araclar Where id = $firma_demirbas_id")->row();
                $item_name = $item_details->plaka;
                $item_desc = $item_details->code;
                $item_image = $item_details->image_text;
            }
            elseif($table_name_=='geopos_employees'){
                $table_name='geopos_employees';
                $item_details = $this->db->query("SELECT * FROM geopos_employees Where id = $firma_demirbas_id")->row();
                $item_name = $item_details->name;
                $item_desc = $item_details->id;
                $item_image = $item_details->picture;
            }
            else{

                $item_details = $this->db->query("SELECT * FROM $table_name_ Where id = $firma_demirbas_id")->row();
                $item_name = $item_details->name;
                $item_desc = $item_details->id;
                $item_image = '';
            }

            $say = count($product_details);
            $i=0;
            foreach ($product_details as $items){


                $product_id = $items['product_id'];

                $talep_no = numaric(39);
                $data = array(
                    'code' => $talep_no,
                    'progress_status_id' => 0,
                    'talep_eden_user_id' => 0,
                    'cari_id' => $details->csd,
                    'method' => $details->method,
                    'proje_id' => $details->proje_id,
                    'desc' => $details->notes,
                    'demirbas_id' => $demirbas_id,
                    'firma_demirbas_id' => $firma_demirbas_id,
                    'loc' =>  $details->loc,
                    'aauth' => $this->aauth->get_user()->id,
                    'table_name' => $table_name_,
                    'item_name' => $item_name,
                    'item_desc' => $item_desc,
                    'item_image' => $item_image,
                    'talep_id' => $file_id,
                    'type' => $type,
                );
                if ($this->db->insert('firma_gider', $data)) {
                    $last_id = $this->db->insert_id();
                    numaric_update(39);

                    $data_items = array(
                        'cost_id' => $gider_kalemi_id,
                        'product_desc' => '',
                        'unit_id' => $items['new_unit_id'],
                        'product_qty' => $items['new_item_qty'],
                        'price' => $items['new_item_price'],
                        'total' => $items['item_umumi_cemi_hidden'],
                        'form_id' => $last_id,
                        'aauth' => $this->aauth->get_user()->id
                    );
                    $this->db->insert('firma_gider_products', $data_items);

                    $data_update = array(
                        'gider_durumu' => 1,
                        'gider_id' => $last_id,
                    );
                    $this->db->set($data_update);
                    $this->db->where('id', $items['invoice_items_id']);
                    $this->db->update('geopos_invoice_items', $data_update);
                    $i++;



                }

            }

            if($say==$i){
                return [
                    'status'=>1,
                    'message'=>'Başarıyla Oluşturuldu'
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız'
                ];
            }






        } // Forma 2 İşleme
        elseif($type==6){
            $gider_kalemi_id = $this->input->post('group_id');
            $product_details = $this->input->post('product_details');
            $demirbas_id = $this->input->post('demirbas_id');
            $firma_demirbas_id = $this->input->post('firma_demirbas_id');

            $details = $this->db->query("SELECT * FROM geopos_invoices Where id=$file_id")->row();


            $table_name_ = $this->db->query("SELECT * FROM demirbas_firma Where demirbas_id = $demirbas_id")->row()->table_name;

            $item_name='';
            $item_desc='';
            $item_image='';
            if($table_name_=='araclar'){
                $table_name='araclar';
                $item_details = $this->db->query("SELECT * FROM araclar Where id = $firma_demirbas_id")->row();
                $item_name = $item_details->plaka;
                $item_desc = $item_details->code;
                $item_image = $item_details->image_text;
            }
            elseif($table_name_=='geopos_employees'){
                $table_name='geopos_employees';
                $item_details = $this->db->query("SELECT * FROM geopos_employees Where id = $firma_demirbas_id")->row();
                $item_name = $item_details->name;
                $item_desc = $item_details->id;
                $item_image = $item_details->picture;
            }
            else{

                $item_details = $this->db->query("SELECT * FROM $table_name_ Where id = $firma_demirbas_id")->row();
                $item_name = $item_details->name;
                $item_desc = $item_details->id;
                $item_image = '';
            }


            $say = count($product_details);
            $i=0;
            foreach ($product_details as $items){


                $product_id = $items['product_id'];

                $talep_no = numaric(39);
                $data = array(
                    'code' => $talep_no,
                    'progress_status_id' => 0,
                    'talep_eden_user_id' => 0,
                    'cari_id' => $details->csd,
                    'method' => $details->method,
                    'proje_id' => $details->proje_id,
                    'desc' => $details->notes,
                    'demirbas_id' => $demirbas_id,
                    'firma_demirbas_id' => $firma_demirbas_id,
                    'loc' =>  $details->loc,
                    'aauth' => $this->aauth->get_user()->id,
                    'table_name' => $table_name_,
                    'item_name' => $item_name,
                    'item_desc' => $item_desc,
                    'item_image' => $item_image,
                    'talep_id' => $file_id,
                    'type' => $type,
                );
                if ($this->db->insert('firma_gider', $data)) {
                    $last_id = $this->db->insert_id();
                    numaric_update(39);

                    $data_items = array(
                        'cost_id' => $gider_kalemi_id,
                        'product_desc' => '',
                        'unit_id' => $items['new_unit_id'],
                        'product_qty' => $items['new_item_qty'],
                        'price' => $items['new_item_price'],
                        'total' => $items['item_umumi_cemi_hidden'],
                        'form_id' => $last_id,
                        'aauth' => $this->aauth->get_user()->id
                    );
                    $this->db->insert('firma_gider_products', $data_items);

                    $data_update = array(
                        'gider_durumu' => 1,
                        'gider_id' => $last_id,
                    );
                    $this->db->set($data_update);
                    $this->db->where('id', $items['invoice_items_id']);
                    $this->db->update('geopos_invoice_items', $data_update);
                    $i++;



                }

            }

            if($say==$i){
                return [
                    'status'=>1,
                    'message'=>'Başarıyla Oluşturuldu'
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız'
                ];
            }






        } // Fatura İşleme
        elseif($type==7){

            $details = $this->db->query("SELECT * FROM geopos_invoices Where id=$file_id")->row();
            $details2 = $this->db->query("SELECT * FROM demirbas_group Where id = $details->multi")->row();
            $product_id = $details->multi;
            $table_name='';
            $item_name='';
            $item_desc='';
            $item_image='';
            $demirbas_id=$details->csd;
            $table_name_ = $this->db->query("SELECT * FROM demirbas_firma Where demirbas_id = $demirbas_id")->row()->table_name;

            if($table_name_=='araclar'){
                $table_name='araclar';
                $item_details = $this->db->query("SELECT * FROM araclar Where id = $details->term")->row();
                $item_name = $item_details->plaka;
                $item_desc = $item_details->code;
                $item_image = $item_details->image_text;
            }
            elseif($table_name_=='geopos_employees'){
                $table_name='geopos_employees';
                $item_details = $this->db->query("SELECT * FROM geopos_employees Where id = $details->term")->row();
                $item_name = $item_details->name;
                $item_desc = $item_details->id;
                $item_image = $item_details->picture;
            }
            else{

                $item_details = $this->db->query("SELECT * FROM $table_name_ Where id = $details->term")->row();
                $item_name = $item_details->name;
                $item_desc = $item_details->id;
                $item_image = '';
            }


            $talep_no = numaric(39);
            $data = array(
                'code' => $talep_no,
                'progress_status_id' => 0,
                'talep_eden_user_id' => 0,
                'cari_id' => 0,
                'method' => $details->method,
                'proje_id' => $details->proje_id,
                'desc' => $details->notes,
                'demirbas_id' => $details->csd,
                'firma_demirbas_id' => $details->term,
                'loc' =>  $details->loc,
                'aauth' => $this->aauth->get_user()->id,
                'table_name' => $table_name_,
                'item_name' => $item_name,
                'item_desc' => $item_desc,
                'item_image' => $item_image,
                'talep_id' => $file_id,
                'type' => $type,
            );
            if ($this->db->insert('firma_gider', $data)) {
                $last_id = $this->db->insert_id();
                numaric_update(39);

                $data_items = array(
                    'cost_id' => $product_id,
                    'product_desc' => '',
                    'unit_id' => 9,
                    'product_qty' => 1,
                    'price' => $details->total,
                    'total' => $details->total,
                    'form_id' => $last_id,
                    'aauth' => $this->aauth->get_user()->id
                );
                $this->db->insert('firma_gider_products', $data_items);


                return [
                    'status'=>1,
                    'message'=>'Başarıyla Oluşturuldu'
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız'
                ];
            }

        } // yeni İşlemden Gider İşleme
        elseif($type==8)//Maaş gideri ekleme
        {
            $loc_id= $this->session->userdata('set_firma_id');
            $locations_deger = $this->db->query("SELECT * FROM geopos_locations WHERE id = $loc_id");
            if($locations_deger->num_rows()){
                $maas_firma_demirbas_id = $locations_deger->row()->maas_firma_demirbas_id;
                if($maas_firma_demirbas_id){
                    $demirbas_id=$locations_deger->row()->maas_demirbas_id;

                    $details = $this->db->query("SELECT * FROM new_bordro_item Where id = $file_id")->row();

                    $table_name_='geopos_employees';



                    $product_id = $details->pers_id;
                    $item_name = personel_details_full($details->pers_id)['name'];
                    $item_image = personel_details_full($details->pers_id)['picture'];
                    $item_desc='';


                    $talep_no = numaric(39);
                    $data = array(
                        'code' => $talep_no,
                        'progress_status_id' => 0,
                        'talep_eden_user_id' => 0,
                        'cari_id' => 0,
                        'method' => 3,
                        'proje_id' => $details->proje_id,
                        'desc' => '',
                        'demirbas_id' => $demirbas_id,
                        'firma_demirbas_id' => $product_id,
                        'loc' =>  $loc_id,
                        'aauth' => $this->aauth->get_user()->id,
                        'table_name' => $table_name_,
                        'item_name' => $item_name,
                        'item_desc' => $item_desc,
                        'item_image' => $item_image,
                        'talep_id' => $file_id,
                        'type' => $type,
                    );
                    if ($this->db->insert('firma_gider', $data)) {
                        $last_id = $this->db->insert_id();
                        numaric_update(39);

                        $array_gider_type =  [
                            [
                                'id'=>171,'desc'=>'odenilecek_meblaq'
                            ],
                            [
                                'id'=>166,'desc'=>'gelir_vergisi'
                            ],
                            [
                                'id'=>167,'desc'=>'icbari_sigorta_isci'
                            ],
                            [
                                'id'=>169,'desc'=>'issizlik_isci'
                            ],
                            [
                                'id'=>165,'desc'=>'dsmf_isci'
                            ],
                            [
                                'id'=>168,'desc'=>'icbari_sigorta_isveren'
                            ],
                            [
                                'id'=>170,'desc'=>'issizlik_isveren'
                            ],
                            [
                                'id'=>164,'desc'=>'dsmf_isveren'
                            ]

                        ];
                        foreach ($array_gider_type as $items){
                            $desc=$items['desc'];
                            if($details->$desc > 0){
                                $data_items = array(
                                    'cost_id' => $items['id'],
                                    'product_desc' => '',
                                    'unit_id' => 9,
                                    'product_qty' => 1,
                                    'price' => $details->$desc,
                                    'total' => $details->$desc,
                                    'form_id' => $last_id,
                                    'aauth' => $this->aauth->get_user()->id
                                );
                                $this->db->insert('firma_gider_products', $data_items);
                            }

                        }

                        $data_update = array(
                            'gider_durumu' => 1,
                        );
                        $this->db->set($data_update);
                        $this->db->where('id', $file_id);
                        $this->db->update('new_bordro_item', $data_update);


                        return [
                            'status'=>1,
                            'message'=>'Başarıyla Oluşturuldu'
                        ];
                    }
                    else {
                        return [
                            'status'=>0,
                            'message'=>'Hata Aldınız'
                        ];
                    }

                }
            }
        }
        elseif($type==9){

            $kontrol = $this->db->query("SELECT * FROM firma_gider Where transaction_id=$file_id")->num_rows();
            if(!$kontrol){
                $tutar = $this->input->post('tutar');
                $details = $this->db->query("SELECT * FROM geopos_invoices Where id=$file_id")->row();


                $details_1 = $this->db->query("SELECT * FROM demirbas_group Where id = 34")->row();
                $details2 = $this->db->query("SELECT * FROM demirbas_group Where id = 152")->row();
                $payer_name= $details2->name.' | '.$details_1->name;


                //kasadan çıkış
                $hesap_id = $this->input->post('hesap_id');
                $holder=account_method_ogren($hesap_id)['holder'];
                $data_nakit = array(
                    'total' =>$tutar,
                    'payer' =>$payer_name,
                    'notes' => $file_id.' ID li işlemin KOMİSYON ÖDEMESİ',
                    'csd'=>34,
                    'loc' => $this->session->userdata('set_firma_id'),
                    'eid'=>$this->aauth->get_user()->id,
                    'invoice_type_id'=>4,
                    'invoice_type_desc' => 'MƏXARİC',
                    'cari_pers_type'=>7,
                    'method'=>3,
                    'acid' => $hesap_id,
                    'proje_id' => $details->proje_id,
                    'account' => $holder,
                    'multi' => 152,
                    'term' => 59,
                );
                $this->db->insert('geopos_invoices', $data_nakit);
                $islem_id = $this->db->insert_id();
                //kasadan çıkış

                $talep_no = numaric(39);
                $data = array(
                    'code' => $talep_no,
                    'progress_status_id' => 0,
                    'talep_eden_user_id' => 0,
                    'cari_id' => 0,
                    'method' => $details->method,
                    'proje_id' => $details->proje_id,
                    'desc' => $details->notes,
                    'demirbas_id' => 34,
                    'firma_demirbas_id' => 59,
                    'loc' =>  $details->loc,
                    'aauth' => $this->aauth->get_user()->id,
                    'table_name' => 'items',
                    'item_name' => 'komisyon giderleri',
                    'item_desc' => '59 '.$file_id.' ID li işlemin Komisyon Ödemesi',
                    'item_image' => '',
                    'talep_id' => $islem_id,
                    'transaction_id' => $file_id,
                    'type' => $type,
                );
                if ($this->db->insert('firma_gider', $data)) {
                    $last_id = $this->db->insert_id();
                    numaric_update(39);

                    $data_items = array(
                        'cost_id' => 152,
                        'product_desc' => '',
                        'unit_id' => 9,
                        'product_qty' => 1,
                        'price' => $tutar,
                        'total' => $tutar,
                        'form_id' => $last_id,
                        'aauth' => $this->aauth->get_user()->id
                    );
                    $this->db->insert('firma_gider_products', $data_items);
                    return [
                        'status'=>1,
                        'message'=>'Başarıyla Oluşturuldu'
                    ];
                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız'
                    ];
                }
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Daha Önceden Bu İşleme Gider Eklenmiştir.Bu sebeple Eklenemez!'
                ];
            }


        } // Komisyon gideri ekleme
        elseif($type==10){


            $say = 0;
            $talep_id = $file_id;
//            $talep_items_details = $this->db->query("SELECT * FROM talep_form_products Where form_id=$talep_id")->result();

            $details = $this->db->query("SELECT * FROM talep_form Where id=$talep_id")->row();
            $demirbas_id=$details->demirbas_id;
            $firma_demirbas_id=$details->firma_demirbas_id;


            $firmma_gider_details=[];

            foreach (tehvil_products($talep_id) as $product_items){

                $item_name='';
                $item_desc='';
                $item_image='';
                $cari_id=$product_items->cari_id;
                $tf_p_id=$product_items->talep_form_product_id;

                $teslim_alinmis = hizmet_teslim_alinmis($talep_id,$product_items->product_id,$tf_p_id)['alinan_miktar'];
                $table_name_ = $this->db->query("SELECT * FROM demirbas_firma Where demirbas_id = $demirbas_id")->row()->table_name; //items
                if($table_name_=='araclar'){
                    $table_name='araclar';
                    $item_details = $this->db->query("SELECT * FROM araclar Where id = $firma_demirbas_id")->row();
                    $item_name = $item_details->plaka;
                    $item_desc = $item_details->code;
                    $item_image = $item_details->image_text;
                }
                elseif($table_name_=='geopos_employees'){
                    $table_name='geopos_employees';
                    $item_details = $this->db->query("SELECT * FROM geopos_employees Where id = $firma_demirbas_id")->row();
                    $item_name = $item_details->name;
                    $item_desc = $item_details->id;
                    $item_image = $item_details->picture;
                }
                else{

                    $item_details = $this->db->query("SELECT * FROM $table_name_ Where id = $firma_demirbas_id")->row();
                    $item_name = $item_details->name;
                    $item_desc = $item_details->id;
                    $item_image = '';
                }


                $tf_teklif_id = $this->db->query("SELECT * FROM talep_form_teklifler where form_id=$talep_id and cari_id=$cari_id")->row()->id;//12
                $odenis_bilgileri = $this->db->query("SELECT * FROM talep_form_teklifler_details where tf_teklif_id=$tf_teklif_id")->row();

                $siparis_son = $this->db->query("SELECT * FROM siparis_list_form_new where talep_form_product_id=$tf_p_id")->row();


                $method = $odenis_bilgileri->method; //3
                $tax_status =  $odenis_bilgileri->edv_durum;
                $tax_oran =  $odenis_bilgileri->kdv_oran;

                $talep_no = numaric(39);
                $data = array(
                    'code' => $talep_no,
                    'progress_status_id' => 0,
                    'talep_eden_user_id' => 0,
                    'cari_id' => 0,
                    'method' => $method,
                    'proje_id' => $details->proje_id,
                    'desc' => $details->desc,
                    'demirbas_id' => $demirbas_id,
                    'firma_demirbas_id' => $firma_demirbas_id,
                    'loc' =>  $details->loc,
                    'aauth' => $this->aauth->get_user()->id,
                    'table_name' => $table_name_,
                    'item_name' => $item_name,
                    'item_desc' => $item_desc,
                    'item_image' => $item_image,
                    'talep_id' => $file_id,
                    'type' => $type,
                );
                if ($this->db->insert('firma_gider', $data)) {
                    $last_id = $this->db->insert_id();
                    numaric_update(39);
                    $total = floatval($siparis_son->new_item_price)*floatval($product_items->qty);
                    $firmma_gider_details[]=[
                        'cost_id' => $product_items->product_id,
                        'unit_id' => $product_items->unit_id,
                        'product_qty' => $product_items->qty,
                        'price' => $siparis_son->new_item_price,
                        'total' => $total,
                        'form_id' => $last_id,
                        'aauth' => $this->aauth->get_user()->id
                    ];

                    $say++;
                }

            }
            if($say){
                $j=0;
                foreach ($firmma_gider_details as $firma_gider_items){
                    $data_items = array(
                        'cost_id' => $firma_gider_items['cost_id'],
                        'product_desc' => '',
                        'unit_id' => $firma_gider_items['unit_id'],
                        'product_qty' => $firma_gider_items['product_qty'],
                        'price' => $firma_gider_items['price'],
                        'total' => $firma_gider_items['total'],
                        'form_id' => $firma_gider_items['form_id'],
                        'aauth' => $firma_gider_items['aauth']
                    );
                   if( $this->db->insert('firma_gider_products', $data_items)){
                       $j++;
                   }
                }

                if($j==count($firmma_gider_details)){
                    return [
                        'status'=>1,
                        'message'=>'Başarıyla Oluşturuldu'
                    ];
                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız'
                    ];
                }

            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız'
                ];
            }

        } // Hizmet Talebinden Gider Ekleme

    }
    public function gider_create_save(){


        $group_id_arr = $this->input->post('group_id');
        $group_id = $group_id_arr[array_key_last($group_id_arr)];
        $ar_count=count($group_id_arr);


        if($group_id==0){
            $eq = intval($ar_count)-1;
            if($eq<=0){
                $group_id=0;
            }
            else {
                $eq=$eq-1;
                $group_id=$group_id_arr[$eq];
            }
        }
        $desc = $this->input->post('desc');
        $name = $this->input->post('name');
        $demirbas_id = $this->input->post('demirbas_id');

        if($group_id!=0){
            $demirbas_id=0;
        }
        $talep_no = numaric(38);
        $data = array(
            'code'=>$talep_no,
            'name'=>$name,
            'type'=>2,
            'desc'=>$desc,
            'demirbas_id'=>$demirbas_id,
            'user_id' => $this->aauth->get_user()->id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        $index=0;
        if ($this->db->insert('demirbas_group', $data)) {
            $last_id = $this->db->insert_id();
            numaric_update(38);
            if($group_id){
                $data_parent = array(
                    'demirbas_group_id'=>$group_id,
                    'parent_id'=>$last_id,

                );
                $this->db->insert('demirbas_parent', $data_parent);
            }
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Grup Eklendi',
            ];
        }
        else{
            return [
                'status'=>0,
                'message'=>'Eklenirken Hata Aldınız',
            ];
        }
    }

    public function get_parent_kontrol(){

        $group_id = $this->input->post('group_id');
        $result = $this->db->query("SELECT demirbas_group.* FROM demirbas_parent INNER JOIN demirbas_group On demirbas_parent.parent_id = demirbas_group.id Where demirbas_parent.demirbas_group_id=$group_id ");
        if($result->num_rows()){
            return [
                'status'=>1,
                'items'=>$result->result(),
            ];
        }
        else{
            return [
                'status'=>0,
                'message'=>'Alt Group Bulunamadı',
            ];
        }
    }

    public function get_firma_demirbas(){

        $group_id = $this->input->post('group_id');
        $result = $this->db->query("Select* From demirbas_firma Where demirbas_id=$group_id ");
        if($result->num_rows()){
            $table_name = $result->row()->table_name;
            if($table_name){
                $where='';
                if($table_name=='geopos_employees'){
                    $loc=$this->session->userdata('set_firma_id');
                    $where="and loc=$loc";
                }
                $result_tables = $this->db->query("Select * From $table_name Where demirbas_id=$group_id $where ");

                if($result_tables->num_rows()){

                    $items = [];
                    foreach ($result_tables->result() as $values){
                        if($table_name=="talep_form_nakliye_products"){
                            $items[]=['id'=>$values->id,'name'=>$values->code];
                        }
                        else {
                            $items[]=['id'=>$values->id,'name'=>$values->name.' '.$values->code];
                        }

                    }

                    return [
                        'status'=>1,
                        'tip'=>$table_name,
                        'items'=>$items,
                    ];
                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Tanımlanmış İtem Bulunamadı',
                    ];
                }

            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Tanımlanmış İtem Bulunamadı',
                ];
            }

        }
        else{
            return [
                'status'=>0,
                'message'=>'Gruba Atamnmış Firma Demirbaşı Bulunamadı',
            ];
        }
    }

    public function get_parent_list(){

        $group_id = $this->input->post('group_id');
        $result = $this->db->query("Select* From demirbas_group Where demirbas_id=$group_id and type=2");
        $items = [];
        $firma_item_list_durum=false;
        if($result->num_rows()){

            $result_firmalist = $this->db->query("Select* From demirbas_firma Where demirbas_id=$group_id ");
            if($result_firmalist->num_rows()){
                $table_name = $result_firmalist->row()->table_name;
                if($table_name){
                    $result_tables = $this->db->query("Select * From $table_name Where demirbas_id=$group_id ");

                    if($result_tables->num_rows()){

                        $firma_item_list_durum=true;

                        foreach ($result_tables->result() as $values){


                            if($table_name=="talep_form_nakliye_products"){
                                $items[]=['id'=>$values->id,'name'=>$values->code];
                            }
                            else {
                                $items[]=['id'=>$values->id,'name'=>$values->name.' '.$values->code];
                            }

                        }
                    }
                    else {
                        $firma_item_list_durum=false;
                    }
                }
                else {
                    $firma_item_list_durum=false;
                }


            }

            return [
                'status'=>1,
                'items'=>$result->result(),
                'firma_item_list'=>$items,
                'firma_item_list_durum'=>$firma_item_list_durum
            ];

        }
        else{
            return [
                'status'=>0,
                'message'=>'Gruba Atamnmış Alt Bulunamadı',
            ];
        }
    }

    public function details($id){
        $this->db->select('*');
        $this->db->from('demirbas_group');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function update()
    {
        $demirbas_id =  $this->input->post('demirbas_id');

        $units = array(
            'name' =>  $this->input->post('name'),
            'desc' =>  $this->input->post('desc')

        );

        if ($this->db->where(['id' => $demirbas_id])->update('demirbas_group', $units)) {
            return [
                'status' => 1,
            ];
        } else {
            return [
                'status' => 0,
            ];
        }
    }
}