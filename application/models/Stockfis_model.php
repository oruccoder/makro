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





class Stockfis_model extends CI_Model
{
    var $column_order_fis = array('stock_io.id','type','stock_io.code','geopos_projects.code','geopos_warehouse.title');

    var $column_search_fis = array('stock_io.code','IF(type="0","ÇIXIŞ","GİRİŞ")','geopos_projects.code','geopos_warehouse.title');
    var $order = array('id' => 'DESC');

    var $column_search_stock = array('geopos_products.product_name','stock_io_products.qty','geopos_units.name', 'geopos_project_bolum.name', 'geopos_milestones.name', 'geopos_employees.name', 'stock_io.aauth_id', 'stock_io.code', 'stock_io.created_at', 'stock_io.id');

    var $column_order_stock = array('geopos_products.product_name','stock_io_products.qty','geopos_units.name', 'geopos_project_bolum.name', 'geopos_milestones.name', 'geopos_employees.name', 'stock_io.aauth_id', 'stock_io.code', 'stock_io.created_at', 'stock_io.id');
    var $order_stock = array('stock_io.id' => 'DESC');

    public function __construct()
    {
        parent::__construct();

    }
    function datatables_stok_fis_list()

    {
        $this->_datatable_fis_list();
        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }

    private function _datatable_fis_list()

    {

        $this->db->select('stock_io.*,stock_io.id as stock_io_id_new,IF(type="0","ÇIXIŞ","GİRİŞ") as fis_type_name,geopos_warehouse.id as warehouse_id ,geopos_warehouse.title as warehouse ,geopos_projects.code as proje_code, geopos_projects.name as project_name ,stock_io.code as fis_code');
        $this->db->from('stock_io');
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = stock_io.warehouse_id','left');
        $this->db->join('geopos_projects', 'geopos_projects.id = stock_io.proje_id','left');
        $this->db->where('stock_io.fis_tur',1);
        $i = 0;

        foreach ($this->column_search_fis as $item) // loop column

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

                if (count($this->column_search_fis) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order_fis[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }

    function count_filtered_fis_list()

    {

        $this->_datatable_fis_list();
        $query = $this->db->get();
        return $query->num_rows();

    }
    public function count_all_fis_list()

    {

        $this->_datatable_fis_list();


        $query = $this->db->get();

        return $query->num_rows();

    }

    public function create_fis(){
        $post_data = $this->input->post("collection");
        if(isset($post_data)){

            $code = numaric(9);
            $data_items = array(
                'pers_id'      => $post_data[0]['personel_id'],
                'aauth_id'      => $this->aauth->get_user()->id,
                'code'         => $code ,
                'warehouse_id'     => $post_data[0]['warehouse_id'],
                'type'     => $post_data[0]['fis_type'],
                'fis_tur'     => 1
            );

            if($this->db->insert('stock_io', $data_items)){
                $stock_io_id = $this->db->insert_id();
                $index=0;
                $product_list=[];
                foreach ($post_data as $items){
                    //stok çıkış /giriş
                    $stock_id = stock_update_new($items['product_id'],$items['unit_id'],$items['qty'],$items['fis_type'],$items['warehouse_id'],$this->aauth->get_user()->id,$stock_io_id,3);
                    //stok çıkış /giriş

                    $value_id= $items['value_id'];
                    $options_id='';
                    $i=0;
                    $option_details = $this->db->query("select * from product_option_value Where id  IN ($value_id)")->result();
                    foreach ($option_details as $option_items){
                        if ($i === array_key_last($option_details)) {// first loop
                            $options_id.=$option_items->product_option_id;
                        }
                        else {
                            $options_id.=$option_items->product_option_id.',';
                        }
                        $i++;
                    }

                    stock_update_options_new($stock_id,$options_id,$value_id);

                    $data = array(
                        'stock_io_id' => $stock_io_id,
                        'stock_id' => $stock_id,
                        'product_id' => $items['product_id'],
                        'unit_id' => $items['unit_id'],
                        'qty' => $items['qty'],
                        'option_id' => option_sort($options_id),
                        'option_value_id' => option_sort($value_id),
                        'bolum_id' => $items['bolum_id'],
                        'asama_id' => $items['asama_id'],
                        'proje_id'      => $items['proje_id'],
                        'description' => $items['dec'],
                    );
                    $product_list[$index]=$data;
                    $index++;
                }
                if($index){
                    if ($this->db->insert_batch('stock_io_products', $product_list)) {
                        $operator= "deger+1";
                        $this->db->set('deger', "$operator", FALSE);
                        $this->db->where('tip', 9);
                        $this->db->update('numaric');
                        $last_id = $this->db->insert_id();
                        $this->aauth->applog("Stok ÇIKIŞ / Giriş Fişi Oluşturuldu: Talep ID : ".$stock_io_id, $this->aauth->get_user()->username);

                        return [
                            'status'=>1,
                            'message'=>'Başarıyla Oluşturulmuştur',
                            'id'=>0
                        ];
                    }
                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız',
                        'id'=>0
                    ];
                }
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız',
                    'id'=>0
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Herhangi Bir Veri Gönderilmemiştir',
                'id'=>0
            ];
        }
    }
    public function update_fis(){
        $stock_io_id = $this->input->post('stok_id');
        $details = $this->stokdetails($stock_io_id);
        $user_id = $this->aauth->get_user()->id;
        if($user_id==$details->aauth_id){
            $post_data = $this->input->post("collection");
            if(isset($post_data)){

                $code = numaric(9);
                $data_items = array(
                    'pers_id'      => $post_data[0]['personel_id'],
                    'warehouse_id'     => $post_data[0]['warehouse_id'],
                    'type'     => $post_data[0]['fis_type'],
                );

                $this->db->where('id',$stock_io_id);
                if($this->db->update('stock_io', $data_items)){
                    $this->db->delete('stock_io_products', array('stock_io_id' => $stock_io_id));
                    $this->db->delete('stock', array('mt_id' => $stock_io_id,'form_type'=>3));
                    $index=0;
                    $product_list=[];
                    foreach ($post_data as $items){
                        //stok çıkış /giriş
                        $stock_id = stock_update_new($items['product_id'],$items['unit_id'],$items['qty'],$items['fis_type'],$items['warehouse_id'],$this->aauth->get_user()->id,$stock_io_id,3);
                        //stok çıkış /giriş

                        $value_id= $items['value_id'];
                        $options_id='';
                        $i=0;
                        $option_details = $this->db->query("select * from product_option_value Where id  IN ($value_id)")->result();
                        foreach ($option_details as $option_items){
                            if ($i === array_key_last($option_details)) {// first loop
                                $options_id.=$option_items->product_option_id;
                            }
                            else {
                                $options_id.=$option_items->product_option_id.',';
                            }
                            $i++;
                        }
                        stock_update_options_new($stock_id,$options_id,$value_id);
                        $data = array(
                            'stock_io_id' => $stock_io_id,
                            'stock_id' => $stock_id,
                            'product_id' => $items['product_id'],
                            'unit_id' => $items['unit_id'],
                            'qty' => $items['qty'],
                            'option_id' => option_sort($options_id),
                            'option_value_id' => option_sort($value_id),
                            'bolum_id' => $items['bolum_id'],
                            'asama_id' => $items['asama_id'],
                            'description' => $items['dec'],
                            'proje_id'      => $items['proje_id'],
                        );
                        $product_list[$index]=$data;
                        $index++;
                    }
                    if($index){
                        if ($this->db->insert_batch('stock_io_products', $product_list)) {
                            $this->aauth->applog("Stok ÇIKIŞ / Giriş Fişi güncellendi: Talep ID : ".$stock_io_id, $this->aauth->get_user()->username);
                            return [
                                'status'=>1,
                                'message'=>'Başarıyla Güncellendi',
                                'id'=>0
                            ];
                        }
                    }
                    else {
                        return [
                            'status'=>0,
                            'message'=>'Hata Aldınız',
                            'id'=>0
                        ];
                    }
                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız',
                        'id'=>0
                    ];
                }
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Herhangi Bir Veri Gönderilmemiştir',
                    'id'=>0
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Değişiklik Yapmaya Yetkiniz Bulunmamaktadır.Yönetici İle İletişime Geçiniz',
                'id'=>0
            ];
        }

    }
    public function delete_fis(){
        $stock_io_id = $this->input->post('stok_id');
        $details = $this->stokdetails($stock_io_id);
        $code = $details->code;
        $user_id = $this->aauth->get_user()->id;
        if($user_id==$details->aauth_id){
            $this->db->delete('stock_io_products', array('stock_io_id' => $stock_io_id));
            $this->db->delete('stock', array('mt_id' => $stock_io_id,'form_type'=>3));
            if( $this->db->delete('stock_io', array('id' => $stock_io_id))){
                $this->aauth->applog("Stok ÇIKIŞ / Giriş Fişi Silindi: Talep Code : ".$code, $this->aauth->get_user()->username);
                return [
                    'status'=>1,
                    'message'=>'Başarıyla Silindi',
                    'id'=>0
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız',
                    'id'=>0
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Silmek için Yetkiniz Bulunmamaktadır.Yönetici İle İletişime Geçiniz',
                'id'=>0
            ];
        }
    }

    public function stokdetails($id){
        $this->db->select('*');
        $this->db->from('stock_io');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function stokitemdetails($id){
        $this->db->select('*');
        $this->db->from('stock_io_products');
        $this->db->where('stock_io_id', $id);
        $query = $this->db->get();
        return $query->result();
    }
}