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





class Warehouse_model extends CI_Model
{
    var $table_news = 'geopos_warehouse';

    var $column_order = array('title', 'extra');

    var $column_search = array('title', 'extra');

    var $column_search_product = array('geopos_products.product_name','geopos_products.product_code');

    var $column_order_product =  array('geopos_products.product_name','geopos_products.product_code');

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

        $this->db->select('*');
        $this->db->from('geopos_warehouse');
        $i = 0;

        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_warehouse.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
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
        $this->db->order_by('`geopos_warehouse`.`id` DESC');

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


    public function get_datatables_details_details()

    {
        $this->_get_datatables_query_details_details();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _get_datatables_query_details_details()

    {
        $id = $this->input->post('id');
        $this->db->select('stock.*,geopos_products.product_name');
        $this->db->from('stock');
        $this->db->join('geopos_products','stock.product_id=geopos_products.pid','Left');
        $this->db->where('stock.warehouse_id',$id);
        //$this->db->where('geopos_products.deleted_at is null');
        $i = 0;
        $this->db->where('stock.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57


        foreach ($this->column_search_product as $item) // loop column

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

                if (count($this->column_search_product) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`stock`.`id` DESC');
        $this->db->group_by('`stock`.`product_id`');

    }


    public function count_filtered_details()
    {
        $this->_get_datatables_query_details_details();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_details()
    {
        $this->_get_datatables_query_details_details();
        return $this->db->count_all_results();
    }



    public function get_datatables_details_product_details()

    {
        $this->_get_datatables_query_details_product_details();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _get_datatables_query_details_product_details()

    {
        $id = $this->input->post('id');
        $product_id = $this->input->post('product_id');
        $this->db->select('stock.*,geopos_employees.name as pers_name,stock_to_options.option_id,stock_to_options.option_value_id,stock_to_options.product_stock_code_id');
        $this->db->from('stock');
        $this->db->join('geopos_employees','stock.aauth_id=geopos_employees.id');
        $this->db->join('stock_to_options','stock.id=stock_to_options.stock_id','LEFT');
        $this->db->where('stock.warehouse_id',$id);
        $this->db->where('stock.product_id',$product_id);
        $i = 0;

        if($this->session->userdata('set_firma_id')){
            $this->db->where('stock.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
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
        $this->db->order_by('`stock`.`id` DESC');
    }


    public function count_filtered_product_details()
    {
        $this->_get_datatables_query_details_product_details();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_product_details()
    {
        $this->_get_datatables_query_details_product_details();
        return $this->db->count_all_results();
    }


    //varyant toplam stok

    public function get_ajax_list_product_varyant_details()

    {
        $query = $this->_get_ajax_list_product_varyant_details();

//        if ($_POST['length'] != -1)
//
//            $this->db->limit($_POST['length'], $_POST['start']);
//
//        $query = $this->db->get();

        return $query->result();

    }

    private function _get_ajax_list_product_varyant_details()

    {

        $warehouse_id = $this->input->post('warehouse_id');
        $product_id = $this->input->post('product_id');

        $loc = $this->session->userdata('set_firma_id');
            return $this->db->query("SELECT  stock_to_options.product_stock_code_id, sum(stock.qty) as total, `stock`.*, 
       IF(`stock_to_options`.`option_id`,`stock_to_options`.`option_id`,NULL) as option_id,
       IF(`stock_to_options`.`option_value_id`,`stock_to_options`.`option_value_id`,NULL) as option_value_id,
       IF(`stock_to_options`.`option_value_id`,`stock_to_options`.`option_value_id`,NULL) as s_option_value_id
       FROM `stock` LEFT JOIN `stock_to_options` ON `stock`.`id`=`stock_to_options`.`stock_id`
        WHERE `stock`.`warehouse_id` = $warehouse_id AND `stock`.`product_id` = $product_id AND `stock`.`loc` = $loc 
          and types=1
        group by stock_to_options.product_stock_code_id
        UNION ALL
        SELECT stock_to_options.product_stock_code_id, sum(stock.qty) as total, `stock`.*, IF(`stock_to_options`.`option_id`,`stock_to_options`.`option_id`,NULL) as option_id,
       IF(`stock_to_options`.`option_value_id`,`stock_to_options`.`option_value_id`,NULL) as option_value_id,
         IF(`stock_to_options`.`option_value_id`,`stock_to_options`.`option_value_id`,NULL) as s_option_value_id        
               FROM `stock` LEFT JOIN `stock_to_options` ON `stock`.`id`=`stock_to_options`.`stock_id`
        WHERE `stock`.`warehouse_id` = $warehouse_id AND `stock`.`product_id` = $product_id AND `stock`.`loc` = $loc
          and types=0
        group by stock_to_options.product_stock_code_id
        ");


    }


    public function count_filtered_product_varyant_details()
    {
        $this->_get_ajax_list_product_varyant_details();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_product_varyant_details()
    {
        $this->_get_ajax_list_product_varyant_details();
        return $this->db->count_all_results();
    }

    //varyant toplam stok




    public function details($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_warehouse');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function create_save(){
        $name = $this->input->post('name');
        $desc = $this->input->post('desc');
        $proje_id = $this->input->post('proje_id');
        $pers_id = $this->input->post('pers_id');
        $data=[
            'title'=>$name,
            'extra'=>$desc,
            'proje_id'=>$proje_id,
            'pers_id'=>$pers_id,
            'loc'=>$this->session->userdata('set_firma_id'),
            'aauth_id'=>$this->aauth->get_user()->id,
        ];
        if($this->db->insert('geopos_warehouse',$data)){
            $last_id = $this->db->insert_id();
            $this->aauth->applog("Depo Oluşturuldu  : Depo ID : ".$last_id, $this->aauth->get_user()->username);

            return [
                'status'=>1,
            ];
        }
        else {
            return [
                'status'=>0,
            ];
        }
    }


    public function update_warehouse(){
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $desc = $this->input->post('desc');
        $proje_id = $this->input->post('proje_id');
        $pers_id = $this->input->post('pers_id');
        $data=[
            'title'=>$name,
            'extra'=>$desc,
            'proje_id'=>$proje_id,
            'pers_id'=>$pers_id,
            'loc'=>$this->session->userdata('set_firma_id'),
            'aauth_id'=>$this->aauth->get_user()->id,
        ];
        $this->db->set($data);
        $this->db->where('id', $id);
        if($this->db->update('geopos_warehouse',$data)){
            $this->aauth->applog("Depo Güncellendi  : Depo ID : ".$id, $this->aauth->get_user()->username);
            return [
                'status'=>1,
            ];
        }
        else {
            return [
                'status'=>0,
            ];
        }
    }
    public function add_cloud_stock(){

        $user_id = $this->aauth->get_user()->id;
        $details = $this->input->post('details');
        $tip = $details['tip'];
        $option_id = $details['option_id'];
        $option_value_id = $details['option_value_id'];
        $warehouse_id = $details['warehouse_id'];
        $product_id = $details['product_id'];
        $unit_id = $details['unit'];
        $product_stock_code_id = $details['product_stock_code_id'];
        $qty = $this->input->post('qty');
        $update = $this->input->post('update');
        $option_where='';
        if(isset($product_stock_code_id)){
            $option_where = " and product_stock_code_id = '$product_stock_code_id'";
        }

        $kontrol = $this->db->query("SELECT * FROM cloud_stock Where 
                                    product_id = $product_id
                                    $option_where and
                                    user_id =$user_id and
                                    warehouse_id =$warehouse_id and
                                    tip =$tip and
                                    durum = 0
                                    ");
        if($kontrol->num_rows()){
            if($update){
                $old_qty=$kontrol->row()->qty;
                $data=[
                    'product_id'=>$product_id,
                    'unit_id'=>$unit_id,
                    'qty'=>floatval($qty)+floatval($old_qty),
                    'option_id'=>$option_id,
                    'option_value_id'=>$option_value_id,
                    'user_id'=>$this->aauth->get_user()->id,
                    'tip'=>$tip,
                    'warehouse_id'=>$warehouse_id,
                    'product_stock_code_id'=>$product_stock_code_id,
                ];
                $this->db->set($data);
                $this->db->where('id', $kontrol->row()->id);
                if($this->db->update('cloud_stock',$data)){
                    return [
                        'status'=>1,
                        'code'=>200,
                        'message'=>'Başarıyla Güncelleme Yapılmıştır'
                    ];
                }
                else {
                    return [
                        'status'=>0,
                        'code'=>410,
                        'message'=>'Ürün Eklenirken Hata Aldınız'
                    ];
                }
            }
            else {
                return [
                    'status'=>1,
                    'code'=>100,
                    'message'=>'Daha Önceden Eklenmiştir.Yeni Eklediğiniz Miktarı Artırarak Güncelleme Yapılsın Mı?'
                ];
            }

        }
        else {
            // insert
            $data=[
                'product_id'=>$product_id,
                'unit_id'=>$unit_id,
                'qty'=>$qty,
                'option_id'=>$option_id,
                'option_value_id'=>$option_value_id,
                'user_id'=>$this->aauth->get_user()->id,
                'tip'=>$tip,
                'warehouse_id'=>$warehouse_id,
                'product_stock_code_id'=>$product_stock_code_id,
                'loc'=>$this->session->userdata('set_firma_id'),
            ];
            if($this->db->insert('cloud_stock',$data)){
                return [
                    'status'=>1,
                    'code'=>200,
                    'message'=>'Başarıyla Ekleme Yapılmıştır'
                ];
            }
            else {
                return [
                    'status'=>0,
                    'code'=>410,
                    'message'=>'Ürün Eklenirken Hata Aldınız'
                ];
            }
        }

    }
}
