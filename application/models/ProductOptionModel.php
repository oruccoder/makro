<?php

use Mpdf\Tag\Input;

defined('BASEPATH') or exit('No direct script access allowed');


class ProductOptionModel extends CI_Model
{

    var $column_order = array('product_options.name', 'product_options.description');

    var $column_search = array('product_options.name', 'product_options.description');

    // var $column_search_transfer = [
    //     'stock_transfer.code',
    //     'stock_transfer.out_warehouse_id',
    //     'stock_transfer.in_warehouse_id',
    //     'geopos_products.product_name',
    //     'stock_transfer_items.qty',
    //     'geopos_units.name',
    //     'stock_transfer_item_notification.new_qty',
    //     'stock_transfer_items.desc',
    //     'geopos_employees.name'
    // ];

    // var $order = array('stock_transfer.id' => 'DESC');
    // var $mahsul = array('products.id' => 'DESC');


    public function __construct()
    {
        parent::__construct();
    }


    public function get_datatables_query_details_list()
    {
        $this->_get_datatables_query_details_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();
    }


    private function _get_datatables_query_details_list()
    {

        // $this->db->where('deleted_at', NULL, FALSE)->get('product_options');

        $this->db->select('*');
        $this->db->from('product_options');
        $this->db->where('deleted_at', NULL, FALSE);
        // $this->db->join('geopos_product_cat', 'products.category_id=geopos_product_cat.id');
        // $this->db->join('geopos_product_type', 'products.type=geopos_product_type.id');
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
        } else if (isset($this->urun)) {

            $this->db->order_by($this->urun);
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


    public function get_datatables_query_transfer_list()
    {
        $this->_get_datatables_query_transfer_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();
    }


    private function _get_datatables_query_transfer_list()
    {

        $this->db->select('stock_transfer_items.id as item_id,stock_transfer.id as stock_id,stock_transfer_item_notification.type,stock_transfer_item_notification.id,stock_transfer.code,stock_transfer.out_warehouse_id,stock_transfer.in_warehouse_id,geopos_products.product_name,stock_transfer_items.qty,geopos_units.name as unit_name,stock_transfer_item_notification.new_qty,stock_transfer_items.`desc`,geopos_employees.name as pers_name');
        $this->db->from('stock_transfer_item_notification');
        $this->db->join('stock_transfer', 'stock_transfer_item_notification.stock_id=stock_transfer.id');
        $this->db->join('stock_transfer_items', 'stock_transfer_item_notification.stock_item_id=stock_transfer_items.id');
        $this->db->join('geopos_units', 'stock_transfer_items.unit_id=geopos_units.id');
        $this->db->join('geopos_products', 'stock_transfer_items.product_id=geopos_products.pid');
        $this->db->join('geopos_employees', 'stock_transfer.aauth_id = geopos_employees.id');
        $this->db->where('stock_transfer_item_notification.staff_id', $this->aauth->get_user()->id);
        $this->db->where('stock_transfer_item_notification.staff_status', 1);
        $this->db->where('stock_transfer_item_notification.status', 0);
        $i = 0;

        foreach ($this->column_search_transfer as $item) // loop column

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

                if (count($this->column_search_transfer) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;
        }
        $this->db->order_by('`stock_transfer_item_notification`.`id` DESC');
    }


    public function count_all_transfer()
    {
        $this->_get_datatables_query_transfer_list();
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_filtered_transfer()
    {
        $this->_get_datatables_query_transfer_list();
        return $this->db->count_all_results();
    }


    public function stock_transfer_notification_create($stock_id, $type, $new_qty = 0, $status = 0, $staff_id, $staff_status = null)
    {
        $item_details = $this->details_item($stock_id);
        $details = $this->details($stock_id);
        $product_list = [];
        $i = 0;
        foreach ($item_details as $value) {
            $data = array(
                'stock_id' => $stock_id,
                'stock_item_id' => $value->id,
                'type' => $type,
                'new_qty' => $new_qty,
                'status' => $status,
                'staff_status' => $staff_status,
                'staff_id' => $staff_id,
                'aauth_id' => $this->aauth->get_user()->id
            );
            $product_list[$i] = $data;
            $i++;
        }

        if ($i) {
            $this->db->insert_batch('stock_transfer_item_notification', $product_list);
            $this->aauth->applog("Stok Bildirimi OLuşturuldu  " . $details->code, $this->aauth->get_user()->username);
            return [
                'status' => 1,
                'id' => $stock_id
            ];
        } else {
            return [
                'status' => 0,
                'id' => 0
            ];
        }
    }


    public function create_save()
    {
        $this->load->model('UrunModel', 'product');
        $value_details = $this->input->post('value_details');
        $parent_options=$this->input->post('parent_option');
        $product=$this->input->post('product');
        if($value_details){
            $data = array(
                'name' =>  $this->input->post('name'),
                'description' => $this->input->post('description'),
                'created_at' => date('Y-m-d H:i:s'),
                'parent_option' => $parent_options,
                'aauth_id' => $this->aauth->get_user()->id,
            );
            if ($this->db->insert('product_options', $data)) {
                $last_id = $this->db->insert_id();

                $product_list=[];
                $index=0;
                $count = count($value_details);
                foreach ($value_details as $items){
                    $data_option = array(
                        'name' =>  $items['value_name'],
                        'description' => $items['value_desc'],
                        'product_option_id' => $last_id,
                        'created_at' => date('Y-m-d H:i:s'),
                    );

                    $this->db->insert('product_option_value',$data_option);
                    $last_id_value_id = $this->db->insert_id();
                    //Parent
                    //$this->db->delete('value_parent_options', array('product_option_value_id' => $items['value_id']));
                    if($parent_options){
                        foreach ($items['parent_value_id'] as $values){
                            $data_option_parent = array(
                                'product_option_value_id' =>  $last_id_value_id,
                                'value_id' => $values,
                            );
                            $this->db->insert('value_parent_options',$data_option_parent);
                        }
                    }
                    //Parent
                $index++;


                }

                if($product){
                    foreach ($product as $pid){
                        $option_details[]=
                            [
                                'option_id' =>$last_id,
                                'sort'=>1,
                            ];
                        $this->product->product_to_option_create_post($pid,$option_details);
                    }

                }
                if($index==$count){
                    return [
                        'status' => 1,
                        'messages' => 'Başarılı Bir Şekilde kayıt Oluştu',
                    ];
                }
                else {
                    return [
                        'status' => 0,
                        'messages' => 'Hata Oluştu. Yöneticiye Başvurun',
                    ];
                }


            } else {
                return [
                    'status' => 0,
                    'messages' => 'Hata Oluştu. Yöneticiye Başvurun',
                ];
            }
        }
        else {
            return [
                'status' => 0,
                'messages' => 'Seçenek Değeri Zorunludur',
            ];
        }

    }


    public function update()
    {
        $this->load->model('UrunModel', 'product');
        $id =  $this->input->post('id');
        $value_details =  $this->input->post('value_details');
        $product=$this->input->post('product');

        //value delete
        // $this->db->delete('product_option_value', array('product_option_id' => $id));
        //value delete
        $parent_options=$this->input->post('parent_option');
        $data = array(
            'name' =>  $this->input->post('name'),
            'description' => $this->input->post('description'),
            'parent_option' => $parent_options,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        if ($this->db->where(['id' => $id])->update('product_options', $data)) {
            $product_list=[];
            $index=0;
            foreach ($value_details as $items){
                //id ye göre update
                if($items['value_id']){
                    //update
                    $data_option = array(
                        'name' =>  $items['value_name'],
                        'description' => $items['value_desc'],
                        'product_option_id' => $id,
                    );
                    $index++;
                    $this->db->set($data_option);
                    $this->db->where('id', $items['value_id']);
                    $this->db->update('product_option_value', $data_option);
                    //Parent
                    $this->db->delete('value_parent_options', array('product_option_value_id' => $items['value_id']));
                    if($parent_options){
                        foreach ($items['parent_value_id'] as $values){
                            $data_option_parent = array(
                                'product_option_value_id' =>  $items['value_id'],
                                'value_id' => $values,
                            );
                            $this->db->insert('value_parent_options',$data_option_parent);
                        }
                    }
                    //Parent

                }
                else {
                    //insert
                    $data_option = array(
                        'name' =>  $items['value_name'],
                        'description' => $items['value_desc'],
                        'product_option_id' => $id,
                        'created_at' => date('Y-m-d H:i:s'),
                    );
                    $index++;
                    $this->db->insert('product_option_value',$data_option);
                    $last_id = $this->db->insert_id();
                    if($parent_options){
                        foreach ($items['parent_value_id'] as $values){
                            $data_option_parent = array(
                                'product_option_value_id' =>  $last_id,
                                'value_id' => $values,
                            );
                            $this->db->insert('value_parent_options',$data_option_parent);
                        }
                    }
                }
                //id ye göre update


            }
            if($product){
                foreach ($product as $pid){
                    $option_details[]=
                        [
                            'option_id' =>$id,
                            'sort'=>1,
                        ];
                    $this->product->product_to_option_create_post($pid,$option_details);
                }

            }
            if($index){
                return [
                    'status' => 1,
                    'messages' => 'Başarılı Bir Şekilde kayıt Oluştu',
                ];
            }
            else {
                return [
                    'status' => 0,
                    'messages' => 'Hata Aldınız. Yöneticiye Başvurun',
                ];
            }

        } else {
            return [
                'status' => 0,
                'messages' => 'Hata Aldınız. Yöneticiye Başvurun',
            ];
        }




    }


    public function delete()
    {
        $id =  $this->input->post('id');

        $kontol= $this->db->query("SELECT * FROM product_to_options Where option_id=$id");
        if($kontol->num_rows()){
            return [
                'status' => 0,
                'messages' => 'Bu Varyasyonu Kullanan Ürünler Mevcuttur',
            ];
        }
        else {
            if ($this->db->where(['id' => $id])->update('product_options', ['deleted_at' => date('Y-m-d H:i:s')]) and $this->db->where(['product_option_id' => $id])->update('product_option_value', ['deleted_at' => date('Y-m-d H:i:s')])) {
                return [
                    'status' => 1,
                    'messages' => 'Başarılı Bir Şekilde İşleminiz Gerçekleştirdi.',
                ];
            } else {
                return [
                    'status' => 0,
                    'messages' => 'Hata Aldınız Yöneticiye Başvurunuz',
                ];
            }
        }


    }

    public function delete_value()
    {
        $id =  $this->input->post('delete_id');

        $kontol= $this->db->query("SELECT * FROM product_to_options_value Where option_value_id=$id");
        if($kontol->num_rows()){
            return [
                'status' => 0,
                'messages' => 'Bu Varyasyonu Kullanan Ürünler Mevcuttur',
            ];
        }
        else {
            if ( $this->db->delete('product_option_value', array('id' => $id))) {
                return [
                    'status' => 1,
                    'messages' => 'Başarılı Bir Şekilde İşleminiz Gerçekleştirdi.',
                ];
            } else {
                return [
                    'status' => 0,
                    'messages' => 'Hata Aldınız Yöneticiye Başvurunuz',
                ];
            }
        }


    }


    public function details_item($id)
    {
        $this->db->select('*');
        $this->db->from('product_options');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    public function details_option($id)
    {
        $this->db->select('*');
        $this->db->from('product_options');
        $this->db->where('id', $id);
        $this->db->order_by('product_options.id', 'ASC');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_product_option($id)
    {
        $this->db->select('*');
        $this->db->from('product_to_options');
        $this->db->where('product_id', $id);
        $this->db->where('deleted_at', NULL, FALSE);
        $query = $this->db->get();
        return $query->result();
    }


    public function details($id)
    {
        $this->db->select('*');
        $this->db->from('product_options');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function list_options()
    {
        $this->db->select('*');
        $this->db->from('product_options');
        $this->db->where('deleted_at', NULL, FALSE);
        $query = $this->db->get();
        return $query->result();
    }



    public function getValue($id)
    {

        $this->db->select('product_options.* , product_option_value.id as value_id , product_option_value.name as value_name , product_option_value.description as value_description');
        $this->db->from('product_options');
        $this->db->where('product_options.id', $id);
        $this->db->join('product_option_value', 'product_options.id = product_option_value.product_option_id', 'left');
        $this->db->where('product_option_value.deleted_at', NULL, FALSE);

        $query = $this->db->get();
        return $query->result();
    }

    public function get_details(){
        $this->db->select('*');
        $this->db->from('product_options');
        $this->db->where('product_options.deleted_at', NULL, FALSE);
        $query = $this->db->get();
        return $query->result();
    }

    public function parent_value_get($id){
        $this->db->select('value_parent_options.*,product_option_value.name');
        $this->db->from('value_parent_options');
        $this->db->where('value_parent_options.product_option_value_id', $id);
        $this->db->join('product_option_value', 'product_option_value.id = value_parent_options.value_id');
        $query = $this->db->get();
        return $query->result();
    }

}
