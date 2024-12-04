<?php

use Mpdf\Tag\Input;

defined('BASEPATH') or exit('No direct script access allowed');


class ProductCategoryModel extends CI_Model
{
    var $table_news = 'stock_io ';

    var $column_order = array(null,'geopos_product_cat.id', 'geopos_product_cat.title', 'geopos_product_cat.parent_id');

    var $column_search = array('geopos_product_cat.title','geopos_product_cat.code','geopos_product_cat.parent_id');

    var $urun = array('geopos_product_cat.id', 'DESC');

    // var $urun = array('geopos_product_cat.id', 'DESC');
    // var $column_search_transfer = [
    //     'stock_transfer.code',
    //     'stock_transfer.out_warehouse_id',
    //     'stock_transfer.in_warehouse_id',
    //     'geopos_geopos_products.product_name',
    //     'stock_transfer_items.qty',
    //     'geopos_units.name',
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
        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();
    }


    private function _get_datatables_query_details_list()
    {

        $this->db->select('*');
        $this->db->from('geopos_product_cat');
        $i = 0;

        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_product_cat.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
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
        $code_numaric =$this->input->post('num_code');
        $code_string = $this->input->post('code');

        $data = array(
            'parent_id' =>  $this->input->post('parent_id'),
            'code' =>  $code_string.$code_numaric,
            'code_numaric' =>  $code_numaric,
            'code_string' =>  $code_string,
            'sorumlu_perid' =>  $this->input->post('sorumlu_perid'),
            'cat_type' => '1', //$this->input->post('cat_type'),
            'title' => $this->input->post('title'),
            'tr_title' => $this->input->post('tr_title'),
            'en_title' => $this->input->post('en_title'),
            'product_varyant' => $this->input->post('product_varyant'),
            'extra' => $this->input->post('title'),
            'loc' => $this->session->userdata('set_firma_id')
        );

        if ($this->db->insert('geopos_product_cat', $data)) {
            $last_id=$this->db->insert_id();
//            $data_number=[
//                'cat_id'=>$last_id,
//                'numaric'=>$this->input->post('num_code')
//            ];
//            $this->db->insert('category_numaric', $data_number);

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
        $code_numaric = $this->input->post('num_code');
        $code_string = $this->input->post('code');
        $product_cat_id =  $this->input->post('product_cat_id');
        $product_cat = array(
            'parent_id' =>  $this->input->post('parent_id'),
            'sorumlu_perid' =>  $this->input->post('sorumlu_perid'),
            'product_varyant' =>  $this->input->post('product_varyant'),
            'code' =>  $code_string.$code_numaric,
            'code_numaric' =>  $code_numaric,
            'code_string' =>  $code_string,
            'cat_type' => '1',//$this->input->post('cat_type'),
            'title' => $this->input->post('title'),
            'tr_title' => $this->input->post('tr_title'),
            'en_title' => $this->input->post('en_title'),
            'extra' => $this->input->post('title'),
        );

        if ($this->db->where(['id' => $product_cat_id])->update('geopos_product_cat', $product_cat)) {
            $this->db->where(['id' => $product_cat_id])->delete('category_numaric');

            return [
                'status' => 1,
            ];
        } else {
            return [
                'status' => 0,
            ];
        }
    }

    public function numaric_insert()
    {
        $cat_id = $this->input->post('cat_id');
        $numaric_val = $this->input->post('numaric_val');

        $kontrol = $this->db->query("SELECT * FROM category_numaric Where cat_id=$cat_id");
        if(!$kontrol->num_rows()){
            $data_number=[
                'cat_id'=>$cat_id,
                'numaric'=>$numaric_val
            ];
            if($this->db->insert('category_numaric', $data_number))
            {
                return [
                    'status' => 1,
                    'messages' => "Başarıyla Eklendi",
                ];
            } else {
                return [
                    'status' => 0,
                    'messages' => "Eklenirken Hata Aldınız",
                ];
            }
        }
        else {
            $product_cat = array(
                'numaric' => $numaric_val
            );
            if ($this->db->where(['cat_id' => $cat_id])->update('category_numaric', $product_cat))
            {
                return [
                    'status' => 1,
                    'messages' => "Başarıyla Güncellendi",
                ];
            } else {
                return [
                    'status' => 0,
                    'messages' => "Güncellenirken Hata Aldınız",
                ];
            }
        }


    }


    public function delete()
    {
        $product_cat_id =  $this->input->post('product_cat_id');

        if ($this->db->where(['id' => $product_cat_id])->delete('geopos_product_cat')) {
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



    public function details_item($product_cat_id)
    {
        $this->db->select('*');
        $this->db->from('geopos_product_cat');
        $this->db->where('id', $product_cat_id);
        $query = $this->db->get();
        return $query->result();
    }


    public function details($product_cat_id)
    {
        $this->db->select('*');
        $this->db->from('geopos_product_cat');
        $this->db->where('id', $product_cat_id);
        $query = $this->db->get();
        return $query->row();
    }
}
