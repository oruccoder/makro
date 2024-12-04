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





class Projestoklari_model extends CI_Model
{
    var $table_news = 'proje_stoklari ';

    var $column_order = array('id', 'geopos_project_bolum.name', 'geopos_milestones.name', 'geopos_products.product_name',null,'proje_stoklari.qty','proje_stoklari.unit_price','proje_stoklari_tipi.name',null);

    var $column_search = array('geopos_project_bolum.name', 'geopos_milestones.name', 'geopos_products.product_name','proje_stoklari.qty','proje_stoklari.unit_price','proje_stoklari_tipi.name');


    var $column_search_stock_p = array('geopos_products.product_name', 'stock.qty',);
    var $column_order_stock_p = array('stock.id', 'stock.qty', 'geopos_units.name');

    var $order = array('id' => 'DESC');

    var $column_order_fis = array('stock_io.id','type','stock_io.code','geopos_projects.code','geopos_warehouse.title');

    var $column_search_fis = array('stock_io.code','IF(type="0","ÇIXIŞ","GİRİŞ")','geopos_projects.code','geopos_warehouse.title');

    var $column_search_stock = array('geopos_products.product_name','stock_io_products.qty','geopos_units.name', 'geopos_project_bolum.name', 'geopos_milestones.name', 'geopos_employees.name', 'stock_io.aauth_id', 'stock_io.code', 'stock_io.created_at', 'stock_io.id');

    var $column_order_stock = array('geopos_products.product_name','stock_io_products.qty','geopos_units.name', 'geopos_project_bolum.name', 'geopos_milestones.name', 'geopos_employees.name', 'stock_io.aauth_id', 'stock_io.code', 'stock_io.created_at', 'stock_io.id');
    var $order_stock = array('stock_io.id' => 'DESC');
    var $order_stock_p = array('stock.id' => 'DESC');



    var $column_order_fis_file = array('stock_io_file.id','stock_io_id.file_name','geopos_employees.name','stock_io_id.created_date','stock_io_id.file',null);

    var $column_search_fis_file = array('stock_io_id.file_name','geopos_employees.name','stock_io_id.created_date','stock_io_id.file');



    public function __construct()
    {
        parent::__construct();

    }
    function datatables($proje_id)

    {
        $this->_datatables($proje_id);
        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }

    private function _datatables($proje_id)

    {

        $this->db->select('proje_stoklari.*,proje_stoklari_tipi.name as tip_name, geopos_products.product_name, geopos_milestones.name as asama_adi, geopos_project_bolum.name as bolum_adi');
        $this->db->from('proje_stoklari');
        $this->db->join('geopos_products','proje_stoklari.product_id=geopos_products.pid');
        $this->db->join('geopos_milestones','proje_stoklari.asama_id=geopos_milestones.id','LEFT');
        $this->db->join('geopos_project_bolum','proje_stoklari.bolum_id=geopos_project_bolum.id');
        $this->db->join('proje_stoklari_tipi','proje_stoklari.tip=proje_stoklari_tipi.id');
        $this->db->where('proje_id',$proje_id);

        $i = 0;

        foreach ($this->column_search as $item) // loop column

        {

            $search = $this->input->post('search');

            $value = $search['value'];

            if ($value) {



                if ($i === 0) {

                    $this->db->group_start();

                    $this->db->like($item, $value);

                } else {

                    $this->db->or_like($item, $value);

                }



                if (count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_search[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }

    function count_filtered($proje_id)

    {

        $this->_datatables($proje_id);
        $query = $this->db->get();
        return $query->num_rows();

    }
    public function count_all($proje_id)

    {

        $this->_datatables($proje_id);


        $query = $this->db->get();

        return $query->num_rows();

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
        $this->db->where('stock_io.fis_tur',2);

        if($this->session->userdata('set_firma_id')){
            $this->db->where('stock_io.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

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


    function datatables_stok_takibi_list()

    {
        $this->_datatables_stok_takibi_list();
        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }
    private function _datatables_stok_takibi_list()

    {

        $proje_id =  $this->input->post('pid');
        $this->db->select('geopos_products.product_name,
            geopos_products.pid as product_id,
            stock_io_products.option_id,
            stock_io_products.product_stock_code_id,
            stock_io_products.option_value_id,
            stock_io_products.qty,
            geopos_units.name as birim_name,
            geopos_project_bolum.name as bolum_name,
            geopos_milestones.name as asama_name,
            stock_io.aauth_id,
            stock_io.cari_pers_type,
            stock_io.pers_id,
            stock_io.fis_tur,
            stock_io.code,
            stock_io.created_at,
            stock_io.id,
            stock_io.type,
            stock_io_products.description,
        ');
        $this->db->from('stock_io');
        $this->db->join('stock_io_products', 'stock_io.id = stock_io_products.stock_io_id');
        $this->db->join('geopos_units', 'stock_io_products.unit_id=geopos_units.id');
        $this->db->join('geopos_products', 'stock_io_products.product_id=geopos_products.pid');
        $this->db->join('geopos_project_bolum', 'stock_io_products.bolum_id = geopos_project_bolum.id');
        $this->db->join('geopos_milestones', 'stock_io_products.asama_id=geopos_milestones.id','left');
        $this->db->where('stock_io.fis_tur IN (2,3)');
        $this->db->where('stock_io_products.proje_id',$proje_id);
        $i = 0;

        foreach ($this->column_search_stock as $item) // loop column

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

                if (count($this->column_search_stock) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order_stock[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->order_stock)) {

            $order = $this->order_stock;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }
    function count_filtered_stok_takibi_list()

    {

        $this->_datatables_stok_takibi_list();
        $query = $this->db->get();
        return $query->num_rows();

    }
    public function count_all_stok_takibi_list()

    {

        $this->_datatables_stok_takibi_list();


        $query = $this->db->get();

        return $query->num_rows();

    }


    function datatables_depo_takibi_list()

    {
        $this->_datatables_depo_takibi_list();
        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }
    private function _datatables_depo_takibi_list()

    {

        $proje_id =  $this->input->post('pid');
        $depo_id = $proje_details = project_to_depo($proje_id)->id;
        $this->db->select('geopos_products.product_name,
        stock_to_options.option_id,
        stock_to_options.option_value_id,
    (SUM(IF(types=1,stock.qty,0)) - SUM(IF(types=0,stock.qty,0)) ) as kalan,
       geopos_units.name as birim,
        stock.types,
        stock.mt_id,
        stock.proje_stoklari_id,
        stock.aauth_id,
        stock.created_at,
        stock.product_id
        ');
        $this->db->from('stock');
        $this->db->join('stock_to_options', 'stock.id = stock_to_options.stock_id','LEFT');
        $this->db->join('geopos_products', 'stock.product_id = geopos_products.pid');
        $this->db->join('geopos_units', 'stock.unit =geopos_units.id');
        $this->db->where('stock.warehouse_id',$depo_id);
        $i = 0;

        foreach ($this->column_search_stock_p as $item) // loop column

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

                if (count($this->column_search_stock) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->group_by("stock_to_options.option_id,stock_to_options.option_value_id");
        $this->db->order_by('geopos_products.pid');

    }
    function count_filtered_depo_takibi_list()

    {

        $this->_datatables_depo_takibi_list();
        $query = $this->db->get();
        return $query->num_rows();

    }
    public function count_all_depo_takibi_list()

    {

        $this->_datatables_depo_takibi_list();


        $query = $this->db->get();

        return $query->num_rows();

    }



    public function talep_list_create(){
        $stok_id = $this->input->post('stok_id');
        $user_id = $this->aauth->get_user()->id;
        $kontrol = $this->db->query("SELECT * FROM talep_list_proje Where proje_stoklari_id=$stok_id and aauth_id=$user_id");
        if($kontrol->num_rows()){
            $this->db->where('proje_stoklari_id',$stok_id);
            $this->db->where('aauth_id', $user_id);
            $this->db->delete('talep_list_proje');
            return [
                'status'=>1,
                'message'=>'Talep Listenizden Bu Ürün Kaldırıldı',
            ];

        }
        else {

            $data = array(
                'proje_stoklari_id' => $stok_id,
                'aauth_id' => $user_id
            );
            if ($this->db->insert('talep_list_proje', $data)) {
                $this->aauth->applog("Malzeme Listesinden Talep Listesine Ürün Eklendi: Stok ID".$stok_id, $this->aauth->get_user()->username);
                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde Stok Eklendi'
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                ];
            }
        }

    }

    public function talep_list_create_toplu(){
        $stok_id_details = $this->input->post('stok_id');
        $user_id = $this->aauth->get_user()->id;

        $update=0;
        $insert=0;
        foreach ($stok_id_details as $items){
            $stok_id = $items['id'];
            $kontrol = $this->db->query("SELECT * FROM talep_list_proje Where proje_stoklari_id=$stok_id and aauth_id=$user_id");
            if($kontrol->num_rows()){
                $this->db->where('proje_stoklari_id',$stok_id);
                $this->db->where('aauth_id', $user_id);
                $this->db->delete('talep_list_proje');
                $update++;

            }
            else {

                $data = array(
                    'proje_stoklari_id' => $stok_id,
                    'aauth_id' => $user_id
                );
                if ($this->db->insert('talep_list_proje', $data)) {
                    $this->aauth->applog("Malzeme Listesinden Talep Listesine Ürün Eklendi: Stok ID".$stok_id, $this->aauth->get_user()->username);
                    $insert++;
                }
            }
        }

        if($update || $insert){
            $message='';
            if($update){
                $message='<p>Bazı Stoklar Talep Listenizden Kaldırıldı</p>';
            }
            if($insert){
                $message.='<p>Bazı Stoklar Talep Listenize Eklendi</p>';
            }
            return [
                'status'=>1,
                'message'=>$message,
                'id'=>0
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız Yöneticiye Başvurunuz',
                'id'=>0
            ];
        }




    }

    public function talep_list_toplu_onaya_sun(){
        $stok_id_details = $this->input->post('stok_id');
        $user_id = $this->aauth->get_user()->id;
        $insert=0;
        $staff_not=0;
        foreach ($stok_id_details as $items){
            $stok_id = $items['id'];
            $stock_details = $this->details($stok_id);
            $category_id = product_details($stock_details->product_id)->pcat;
            $proje_id = $stock_details->proje_id;
            if(!$category_id){

                $name = product_details($stock_details->product_id)->product_name;
                return [
                    'status'=>0,
                    'message'=>$name.' Üründe Kategori Yoktur.Önce Kategori Bağlayınız',
                    'id'=>0
                ];
                exit();
            }
            else {
                $staff_id = category_details($category_id)->sorumlu_perid;
                if(!$staff_id){

                    return [
                        'status'=>0,
                        'message'=>category_details($category_id)->title.' Kategorisinde Yetkili Yoktur',
                        'id'=>0
                    ];
                    exit();

                }
                else {
                    $data_update = [
                        'onay_durumu'=>1
                    ];
                    $this->db->where('id',$stok_id);
                    $this->db->set($data_update);
                    $this->db->update('proje_stoklari', $data_update);
                    $data = array(
                        'proje_stok_id' => $stok_id,
                        'aauth_id' => $user_id,
                        'staff_id' => $staff_id,
                        'staff_status' => 0,
                        'sort' => 0,
                    );
                    if ($this->db->insert('proje_stoklari_onay_list', $data)) {
                        $this->aauth->applog("Malzeme Listesinden Talep Listesine Ürün Eklendi: Stok ID".$stok_id, $this->aauth->get_user()->username);
                        $insert++;
                    }
                    $users_ = onay_sort(6,$proje_id);
                    if($users_){
                        foreach ($users_ as $items){
                            $staff=0;
                            $data_onay = array(
                                'proje_stok_id' => $stok_id,
                                'aauth_id' => $user_id,
                                'staff_id' => $items['user_id'],
                                'sort' => $items['sort'],
                            );
                            $this->db->insert('proje_stoklari_onay_list', $data_onay);
                            $insert++;
                        }
                    }
                    else {
                        return [
                            'status'=>0,
                            'message'=>'Projenizin Sorumluları Atanmamıştır.',
                            'id'=>0
                        ];
                    }
                }

            }

        }

        if($insert){
            $message='<p>Seçilmiş Stoklar Onaya Sunuldu</p>';
            return [
                'status'=>1,
                'message'=>$message,
                'id'=>0
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız Yöneticiye Başvurunuz',
                'id'=>0
            ];
        }




    }


    public function create()
    {
        $not_i=0;
        $user_id = $this->aauth->get_user()->id;
        $proje_id = $this->input->post('proje_id');
        $product_id = $this->input->post('product_id');
        $name=product_full_details($product_id)['product_name'];
        $product_code=product_full_details($product_id)['product_code'];
        $array_items=[];
        $tip = $this->input->post('tip');
        $options_details_res = $this->input->post('option_details');
        $yetkili_kontrol = $this->db->query("SELECT * FROM `geopos_projects` where id = $proje_id and (  proje_sorumlusu_id=$user_id or proje_muduru_id=$user_id or muhasebe_muduru_id=$user_id or genel_mudur_id=$user_id)")->num_rows();

        if ($tip == 2 || $tip == 3) {
            if ($yetkili_kontrol) {
                if ($options_details_res) {

                } else {

                }
            } else {
                return [
                    'status' => 0,
                    'message' => 'Elave Stok veya Artıq Stok Eklemek İçin Yetkiniz Mevcut Değildir.',
                    'id' => 0
                ];
            }
        } else {


            $product_desc = $this->input->post('product_desc');
            $product_price = $this->input->post('product_price');
            $bolum_id_product = $this->input->post('bolum_id_product');
            $asama_id_product = $this->input->post('asama_id_product');
            $unit_id = $this->input->post('unit_id');
            $product_qty = $this->input->post('product_qty');

            if($options_details_res){
                //multi ürün Ekleme
                $productlist = array();
                $prodindex = 0;
                $i=0;
                foreach ($options_details_res as $options_details){
                    $product_stock_code_id=$options_details['stock_code_id'];
                    $product_code=$this->db->query("SELECT * FROM product_stock_code Where id=$product_stock_code_id")->row()->code;
                    $product_kontrol=$this->db->query("SELECT * FROM proje_stoklari WHERE product_id = $product_id and proje_id = $proje_id and product_stock_code_id=$product_stock_code_id and asama_id=$asama_id_product");
                    if(!$product_kontrol->num_rows()){
                        $data = array(
                            'proje_id' => $proje_id,
                            'product_id' => $product_id,
                            'product_stock_code_id'=>$product_stock_code_id,
                            'product_desc'=>$product_desc,
                            'unit_id' => $unit_id,
                            'qty' => $product_qty,
                            'unit_price' => $product_price,
                            'bolum_id' => $bolum_id_product,
                            'asama_id' => $asama_id_product,
                            'tip' => $tip,
                            'aauth_id' => $user_id
                        );

                        $this->db->insert('proje_stoklari', $data);
                        $last_id = $this->db->insert_id();
                        $i++;
                        $prodindex++;
                        $array_items[]=
                            [
                                'item_id' => $last_id,
                                'product_name' => $name,
                                'qyt_birim' => $product_qty . ' ' . units_($unit_id)['name'],
                                'option_html' => $product_code
                            ];
                    }
                    else {
                        $not_i++;
                    }
                }
                if($prodindex){
                    $this->aauth->applog("Projeye Stok Eklendi ID: " . $proje_id, $this->aauth->get_user()->username);
                    return [
                        'status' => 1,
                        'message' => $i.'Adet Ürün Başarılı Bir Şekilde Eklendi',
                        'array_items' => $array_items
                    ];
                }
                else {
                    if($not_i){
                        return [
                            'status' => 0,
                            'message' => $not_i.' Adet Ürün Daha Önce Eklenmiştir. Miktar Artırınız',
                        ];
                    }
                }
            }
            else {
                $product_code=$this->db->query("SELECT * FROM geopos_products Where pid=$product_id")->row()->product_code;
                $data = array(
                    'proje_id' => $proje_id,
                    'product_id' => $product_id,
                    'product_desc'=>$product_desc,
                    'product_stock_code_id'=>0,
                    'unit_id' => $unit_id,
                    'qty' => $product_qty,
                    'unit_price' => $product_price,
                    'bolum_id' => $bolum_id_product,
                    'asama_id' => $asama_id_product,
                    'tip' => $tip,
                    'aauth_id' => $user_id
                );
                if ($this->db->insert('proje_stoklari', $data)) {
                    $last_id = $this->db->insert_id();
                    $array_items[]=
                        [
                            'item_id' => $last_id,
                            'product_name' => $name,
                            'qyt_birim' => $product_qty . ' ' . units_($unit_id)['name'],
                            'option_html' => $product_code
                        ];

                    return [
                        'status' => 1,
                        'message' => 'Ürün Başarılı Bir Şekilde Eklendi',
                        'array_items' => $array_items
                    ];
                }
            }
        }
    }

    public function post_create()
    {

        $options_details_res= $this->input->post('option_details');
        $product_id= $this->input->post('product_id');
        $product_desc= '';
        $bolum_id_product= $this->input->post('bolum_id');
        $asama_id_product= $this->input->post('asama_id');
        $unit_id= $this->input->post('proje_unit');
        $product_qty= $this->input->post('proje_qty');
        $proje_id= $this->input->post('proje_id');


        $not_i=0;
        $user_id = $this->aauth->get_user()->id;
        $name=product_full_details($product_id)['product_name'];
        $product_code=product_full_details($product_id)['product_code'];
        $array_items=[];
        $tip = 1;
        $yetkili_kontrol = $this->db->query("SELECT * FROM `geopos_projects` where id = $proje_id and (  proje_sorumlusu_id=$user_id or proje_muduru_id=$user_id or muhasebe_muduru_id=$user_id or genel_mudur_id=$user_id)")->num_rows();

         if($options_details_res){
             //multi ürün Ekleme
             $productlist = array();
             $prodindex = 0;
             $i=0;
             foreach ($options_details_res as $options_details){
                 $product_stock_code_id=$options_details['stock_code_id'];
                 $product_code=$this->db->query("SELECT * FROM product_stock_code Where id=$product_stock_code_id")->row()->code;
                 $product_kontrol=$this->db->query("SELECT * FROM proje_stoklari WHERE product_id = $product_id and proje_id = $proje_id and product_stock_code_id=$product_stock_code_id and asama_id=$asama_id_product and bolum_id=$bolum_id_product");
                 if(!$product_kontrol->num_rows()){
                     $data = array(
                         'proje_id' => $proje_id,
                         'product_id' => $product_id,
                         'product_stock_code_id'=>$product_stock_code_id,
                         'product_desc'=>$product_desc,
                         'unit_id' => $unit_id,
                         'qty' => $product_qty,
                         'unit_price' => 0,
                         'bolum_id' => $bolum_id_product,
                         'asama_id' => $asama_id_product,
                         'tip' => $tip,
                         'aauth_id' => $user_id
                     );

                     $this->db->insert('proje_stoklari', $data);
                     $last_id = $this->db->insert_id();
                     $i++;
                     $prodindex++;
                     $array_items[]=
                         [
                             'item_id' => $last_id,
                             'product_name' => $name,
                             'qyt_birim' => $product_qty . ' ' . units_($unit_id)['name'],
                             'option_html' => $product_code
                         ];
                 }
                 else {
                     $not_i++;
                 }
             }
             if($prodindex){
                 $this->aauth->applog("Projeye Stok Eklendi ID: " . $proje_id, $this->aauth->get_user()->username);
                 return [
                     'status' => 1,
                     'message' => $i.'Adet Ürün Başarılı Bir Şekilde Eklendi',
                     'array_items' => $array_items
                 ];
             }
             else {
                 if($not_i){
                     return [
                         'status' => 0,
                         'message' => $not_i.' Adet Ürün Daha Önce Eklenmiştir. Miktar Artırmak İçin Baş Ofise Müracaat Ediniz.',
                     ];
                 }
             }
         }
         else {
             $product_code=$this->db->query("SELECT * FROM geopos_products Where pid=$product_id")->row()->product_code;
             $data = array(
                 'proje_id' => $proje_id,
                 'product_id' => $product_id,
                 'product_desc'=>$product_desc,
                 'product_stock_code_id'=>0,
                 'unit_id' => $unit_id,
                 'qty' => $product_qty,
                 'unit_price' => 0,
                 'bolum_id' => $bolum_id_product,
                 'asama_id' => $asama_id_product,
                 'tip' => $tip,
                 'aauth_id' => $user_id
             );
             if ($this->db->insert('proje_stoklari', $data)) {
                 $last_id = $this->db->insert_id();
                 $array_items[]=
                     [
                         'item_id' => $last_id,
                         'product_name' => $name,
                         'qyt_birim' => $product_qty . ' ' . units_($unit_id)['name'],
                         'option_html' => $product_code
                     ];

                 return [
                     'status' => 1,
                     'message' => 'Ürün Başarılı Bir Şekilde Eklendi',
                     'array_items' => $array_items
                 ];
             }
         }
    }



    public function create_parent(){



        $proje_stoklari_id = $this->input->post('proje_stoklari_id');
        $this->db->delete('proje_stoktlari_parent', array('proje_stoklari_id' => $proje_stoklari_id));
        $collection = $this->input->post('collection');
        $index=0;
        $product_list=[];
        foreach ($collection as $items){
            $product_id = $items['product_id'];
            $value_id =  $items['value_id'];
            $unit_id = $items['unit_id'];
            $price = $items['price'];
            $qty = $items['qty'];
            $options_id='';
            $i=0;
            if($value_id){
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
            }


            $data= array(
                'proje_stoklari_id' => $proje_stoklari_id,
                'product_id' => $product_id,
                'option_id' => option_sort($options_id),
                'option_value_id' => option_sort($value_id),
                'unit_id' => $unit_id,
                'qty' => $qty,
                'unit_price' => $price,
                'aauth_id' => $this->aauth->get_user()->id
            );
            $product_list[$index]=$data;
            $index++;
        }
        if($index){
            if ($this->db->insert_batch('proje_stoktlari_parent', $product_list)) {
                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde Stok Eklendi',
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Ürün eklenirken Hata Aldınız',
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız',
            ];
        }

    }

    public function details_update($stok_id,$tip){

        $html = '';
        $title = '';
        $details = $this->details($stok_id);
        if($tip=='table_bolum_update'){
            $title='Bölüm Düzenle';
            $html='<form id="update_form">
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="name">Bölümler</label>
                                      <select name="line_bolum_id" class="form-control select-box"  id="line_bolum_id">
                                      <option value="0">Seçiniz</option>';
            foreach (all_bolum_proje($details->proje_id) as $blm)
            {
                $id=$blm->id;
                $name=$blm->name;
                if($details->bolum_id==$id){
                    $html.='<option selected value='.$id.'>'.$name.'</option>';
                }
                else {
                    $html.='<option value='.$id.'>'.$name.'</option>';
                }

            }

            $html.='</select>
                                    </div>
                                </div>
                            ';
        }
        elseif($tip=='table_asama_update'){
            $title='Aşama Düzenle';
            $html='<form id="update_form">
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="name">Proje Aşamaları</label>
                                      <select name="line_asama_id" class="form-control select-box" id="line_asama_id">
                                      <option value="0">Seçiniz</option>';
            foreach (asama_list_rows($details->proje_id,$details->bolum_id) as $blm)
            {
                $id=$blm['id'];
                $name=$blm['name'];
                if($details->asama_id==$id){
                    $html.='<option selected value='.$id.'>'.$name.'</option>';
                }
                else {
                    $html.='<option value='.$id.'>'.$name.'</option>';
                }

            }
            $html.='</select>
                                    </div>
                                </div>
                           ';
        }
        elseif($tip=='table_qty_update'){
            $title='Miktar ve Birim Düzenle';
            $proje_id = $details->proje_id;
            $artiq='';
            $proje_details = $this->db->query("SELECT * FROM geopos_projects Where id = $proje_id and stok_giris_durumu=1");
            if($proje_details->num_rows()){
                $artiq='<div class="form-group col-md-12">
                                    <label for="name">Artıq Stok </label><br><span>(artırdığınız miktar kadar artık stoq kaydı olacaktır)</span>
                                    <input type="checkbox"  checked class="form-control" name="line_artiq_stok" id="line_artiq_stok">
                                    </div>';
            }
            $html='<form id="update_form">
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="name">Stok Birimi</label>
                                      <select name="line_unit_id" class="form-control select-box" id="line_unit_id">
                                      <option value="0">Seçiniz</option>';
            foreach (units() as $blm)
            {
                $id=$blm['id'];
                $name=$blm['name'];
                if($details->unit_id==$id){
                    $html.='<option selected value='.$id.'>'.$name.'</option>';
                }
                else {
                    $html.='<option value='.$id.'>'.$name.'</option>';
                }

            }
            $html.='</select>
                                    </div>
                                    <div class="form-group col-md-12">
                                    <label for="name">Miktar</label>
                                    <input type="number" value="'.$details->qty.'" class="form-control" name="line_qty">
                                    </div>
                                       <div class="form-group col-md-12">
                                    <label for="name">Açıklama</label>
                                    <input type="text" value="" class="form-control" name="line_description">
                                    </div>
                                    ';
            $html.=$artiq;
                                $html.='</div>
                           ';
        }

        elseif($tip=='table_product_update'){
            $title='Ürün Düzenle';
            $product_name = product_name($details->product_id);
            $html='<form id="update_form">
                              <div class="form-row">
                                    <div class="form-group col-md-12">
                                    <label for="name">Stok Kartı</label>
                                             <select name="line_product_id" class="form-control" id="line_product_id">
                                                    <option value="'.$details->product_id.'">'.$product_name.'</option>
                                                </select>
                                    </div>
                                    <input type="hidden" name="line_option_id" id="line_option_id" value="">
                                    <input type="hidden" name="line_option_value_id" id="line_option_value_id" value="">
                                </div>
                           ';
        }
        elseif($tip=='table_price_update'){
            $title='Fiyat Düzenle';
            $html='<form id="update_form">
                              <div class="form-row">
                                    <div class="form-group col-md-12">
                                    <label for="name">Birim Fiyatı</label>
                                    <input type="number" value="'.$details->unit_price.'" class="form-control" name="line_price">
                                    </div>
                                </div>
                           ';
        }
        elseif($tip=='table_product_stock_code_update'){

            $title='Varyant Düzenle';
            $html.='<form id="update_form">';
            $html.=product_to_option_html_news_radio($details->product_id)['html'];
            $html.="</form>";
        }

        $html.='<input type="hidden" name="stok_id" value="'.$stok_id.'">';
        $html.='<input type="hidden" name="tip" value="'.$tip.'"> </form>';
        return [
            'status'=>1,
            'message'=>'Başarılı Bir Şekilde Veri Bulundu',
            'content'=>$html,
            'title'=>$title,
            'id'=>$stok_id
        ];
    }

    public function update(){

        $tip = $this->input->post('tip');
        $stok_id = $this->input->post('stok_id');
        $stock_code_id = $this->input->post('stock_code_id');
        $details = $this->details($stok_id);
        $proje_id = $details->proje_id;
        $user_id = $this->aauth->get_user()->id;
        $stok_kontrol = $this->db->query("SELECT * FROM geopos_projects Where id = $proje_id and stok_giris_durumu=0");
        if($stok_kontrol->num_rows()){
            if($tip=='table_bolum_update'){
                $new_bolum_id = $this->input->post('line_bolum_id');
                $data = [
                    'bolum_id'=>$new_bolum_id
                ];
                $this->db->where('id',$stok_id);
                $this->db->set($data);
                if ($this->db->update('proje_stoklari', $data)) {
                    $asama_kontrol = $this->db->query("SELECT * FROM geopos_milestones Where bolum_id = $new_bolum_id and id = $details->asama_id");
                    if(!$asama_kontrol->num_rows()){
                        // eski aşama yeni bölüme ait değilse asama boşa düşürülmelidir.
                        $data_asama = [
                            'asama_id'=>0
                        ];
                        $this->db->where('id',$stok_id);
                        $this->db->set($data_asama);
                        $this->db->update('proje_stoklari', $data);
                        // eski aşama yeni bölüme ait değilse asama boşa düşürülmelidir.
                    }
                    $title = 'Stoğun Bölümü Değiştirldi Stok_ID  ' . $stok_id;
                    $this->add_activity($title, $details->proje_id);
                    $this->aauth->applog("Stoğun Bölümü Değiştirldi Stok_ID: ".$stok_id, $this->aauth->get_user()->username);

                    return [
                        'status'=>1,
                        'message'=>'Başarılı Bir Şekilde Stok Güncellendi'
                    ];

                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                    ];
                }
            }
            elseif($tip=='table_asama_update'){
                $new_asama_id = $this->input->post('line_asama_id');
                $data = [
                    'asama_id'=>$new_asama_id
                ];
                $this->db->where('id',$stok_id);
                $this->db->set($data);
                if ($this->db->update('proje_stoklari', $data)) {
                    $title = 'Stoğun Aşaması Değiştirldi Stok_ID  ' . $stok_id;
                    $this->add_activity($title, $details->proje_id);
                    $this->aauth->applog("Stoğun Aşaması Değiştirldi Stok_ID: ".$stok_id, $this->aauth->get_user()->username);

                    return [
                        'status'=>1,
                        'message'=>'Başarılı Bir Şekilde Stok Güncellendi'
                    ];

                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                    ];
                }
            }
            elseif($tip=='table_qty_update'){
                $line_artiq_stok = $this->input->post('line_artiq_stok');
                $new_qty = $this->input->post('line_qty');
                $line_description = $this->input->post('line_description');

                if($line_artiq_stok=='on'){
                    $eski_stoq = $details->qty;
                    if($eski_stoq < $new_qty){
                        $artiq_stoq_qty = floatval($new_qty)-$eski_stoq;
                        $data_artiq = [
                          'stok_id'=>$stok_id,
                          'qty'=>$artiq_stoq_qty,
                          'old_qty'=>$eski_stoq,
                          'new_qty'=>$new_qty,
                          'description'=>$line_description,
                        ];
                        $this->db->insert('proje_stoklari_artiq_stok', $data_artiq);
                    }
                }



                $new_unit_id = $this->input->post('line_unit_id');
                $data = [
                    'qty'=>$new_qty,
                    'unit_id'=>$new_unit_id,
                ];
                $this->db->where('id',$stok_id);
                $this->db->set($data);
                if ($this->db->update('proje_stoklari', $data)) {
                    $title = 'Stoğun Miktar ve Birim Güncellendi Stok_ID  ' . $stok_id;
                    $this->add_activity($title, $details->proje_id);
                    $this->aauth->applog("Stoğun Miktar ve Birim Güncellendi Stok_ID: ".$stok_id, $this->aauth->get_user()->username);

                    return [
                        'status'=>1,
                        'message'=>'Başarılı Bir Şekilde Stok Güncellendi'
                    ];

                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                    ];
                }
            }
            elseif($tip=='table_price_update'){
                $new_price = $this->input->post('line_price');
                $data = [
                    'unit_price'=>$new_price
                ];
                $this->db->where('id',$stok_id);
                $this->db->set($data);
                if ($this->db->update('proje_stoklari', $data)) {
                    $title = 'Stoğun Birim Fiyatı Güncellendi Stok_ID  ' . $stok_id;
                    $this->add_activity($title, $details->proje_id);
                    $this->aauth->applog("Stoğun Birim Fiyatı Güncellendi Stok_ID: ".$stok_id, $this->aauth->get_user()->username);

                    return [
                        'status'=>1,
                        'message'=>'Başarılı Bir Şekilde Stok Güncellendi'
                    ];

                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                    ];
                }
            }
            elseif($tip=='table_product_update'){
                $new_product_id = $this->input->post('line_product_id');
                $new_option_id = $this->input->post('line_option_id');
                $new_option_value_id = $this->input->post('line_option_value_id');
                $data = [
                    'product_id'=>$new_product_id,
                    'option_id'=>$new_option_id,
                    'option_value_id'=>$new_option_value_id,
                ];
                $this->db->where('id',$stok_id);
                $this->db->set($data);
                if ($this->db->update('proje_stoklari', $data)) {
                    $title = 'Stok Güncellendi Stok_ID  ' . $stok_id;
                    $this->add_activity($title, $details->proje_id);
                    $this->aauth->applog("Stok Güncellendi Stok_ID: ".$stok_id, $this->aauth->get_user()->username);

                    return [
                        'status'=>1,
                        'message'=>'Başarılı Bir Şekilde Stok Güncellendi'
                    ];

                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                    ];
                }
            }
            elseif($tip=='table_product_stock_code_update'){
                $data = [
                    'product_stock_code_id'=>$stock_code_id,
                ];
                $this->db->where('id',$stok_id);
                $this->db->set($data);
                if ($this->db->update('proje_stoklari', $data)) {

                    // Onaylanmamış Taleplerde Ürün Değiştirme
                    $talepKontrol = $this->db->query("SELECT talep_form_products.id as id FROM talep_form_products INNER JOIN talep_form ON talep_form.id =talep_form_products.form_id  Where talep_form_products.proje_stoklari_id=$stok_id and talep_form.status IN (17,1) and bildirim_durumu=0");
                    if($talepKontrol->num_rows()){
                        foreach ($talepKontrol->result() as $itemValues){
                            $talep_form_products_id = $itemValues->id;
                            $dataPost = [
                                'product_stock_code_id'=>$stock_code_id,
                            ];
                            $this->db->where('id',$talep_form_products_id);
                            $this->db->set($dataPost);
                            $this->db->update('talep_form_products', $dataPost);
                        }
                    }
                    // Onaylanmamış Taleplerde Ürün Değiştirme
                    $title = 'Stok Varyant Güncellendi Stok_ID  ' . $stok_id;
                    $this->add_activity($title, $details->proje_id);
                    $this->aauth->applog("Stok Varyant Güncellendi Stok_ID: ".$stok_id, $this->aauth->get_user()->username);

                    return [
                        'status'=>1,
                        'message'=>'Başarılı Bir Şekilde Stok Güncellendi'
                    ];

                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                    ];
                }
            }
        }
        else {
            if($tip=='table_qty_update'){
                $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $proje_id and (  proje_sorumlusu_id=$user_id or proje_muduru_id=$user_id or muhasebe_muduru_id=$user_id or genel_mudur_id=$user_id)")->num_rows();

                if($yetkili_kontrol){
                    $line_artiq_stok = $this->input->post('line_artiq_stok');
                    $new_qty = $this->input->post('line_qty');
                    $line_description = $this->input->post('line_description');


                    if($line_artiq_stok=='on'){
                        $eski_stoq = $details->qty;
                        if($eski_stoq < $new_qty){
                            $artiq_stoq_qty = floatval($new_qty)-$eski_stoq;
                            $data_artiq = [
                                'stok_id'=>$stok_id,
                                'qty'=>$artiq_stoq_qty,
                                'old_qty'=>$eski_stoq,
                                'new_qty'=>$new_qty,
                                'description'=>$line_description,
                            ];
                            $this->db->insert('proje_stoklari_artiq_stok', $data_artiq);
                        }
                    }



                    $new_unit_id = $this->input->post('line_unit_id');
                    $data = [
                        'qty'=>$new_qty,
                        'unit_id'=>$new_unit_id,
                        'description'=>$line_description,
                    ];
                    $this->db->where('id',$stok_id);
                    $this->db->set($data);
                    if ($this->db->update('proje_stoklari', $data)) {
                        $title = 'Stoğun Miktar ve Birim Güncellendi Stok_ID  ' . $stok_id;
                        $this->add_activity($title, $details->proje_id);
                        $this->aauth->applog("Stoğun Miktar ve Birim Güncellendi Stok_ID: ".$stok_id, $this->aauth->get_user()->username);

                        return [
                            'status'=>1,
                            'message'=>'Başarılı Bir Şekilde Stok Güncellendi'
                        ];

                    }
                    else {
                        return [
                            'status'=>0,
                            'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                        ];
                    }
                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Projenin Stok Girişi ve Düzenleme Durumu Kapatılmıştır.Artık Stok Girişini Ancak Yetkililer Yapabilir',
                        'id'=>0
                    ];
                }
            }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Projenin Stok Girişi ve Düzenleme Durumu Kapatılmıştır.İlave Stok Girişi Yapınız',
                        'id'=>0
                    ];
                }

        }
    }

    public function talep_list_clear(){
        $user_id= $this->aauth->get_user()->id;
        if($this->db->delete('talep_list_proje', array('aauth_id' => $user_id))){
            $this->aauth->applog("Talep Listesi Silindi: ", $this->aauth->get_user()->username);
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Talep Listeniz Boşaltıldı'
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız. Yöneticiye Başvurun'
            ];
        }
    }

    public function delete(){

        $stok_id = $this->input->post('stok_id');
        $details = $this->details($stok_id);
        $sayi=0;
        $array=[];
        $name = product_full_details($details->product_id)['product_name'];
        $talep_details = $this->db->query("Select * From talep_form Where asama_id=$details->asama_id and bolum_id=$details->bolum_id and proje_id = $details->proje_id and status IN(1,2,3,4,5,6,7,8,9,11,17)");
        if($talep_details->num_rows()){
            foreach ($talep_details->result() as $talep){
                $item_details = $this->db->query("Select * From talep_form_products 
                Where talep_form_products.form_id = $talep->id and talep_form_products.product_id = $details->product_id
                and talep_form_products.product_stock_code_id = $details->product_stock_code_id");
                if($item_details->num_rows()){


                    if($sayi===(count($talep_details->result()))-1){

                        $array[]=$talep->code.',';
                    }
                    else {
                        $array[]=$talep->code;
                    }

                    $sayi++;


                }

            }

        }

        if(!$sayi){

            if($this->db->delete('proje_stoklari', array('id' => $stok_id))){
                $title = 'Silindi [Stok Adı] ' . $name.' | Personel'.$this->aauth->get_user()->username;;
                $this->add_activity($title, $details->proje_id);
                $this->aauth->applog("Stok Silindi ID: ".$details->proje_id, $this->aauth->get_user()->username);
                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde Stok Silindi',
                    'id'=>$stok_id
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                    'id'=>0
                ];
            }
        }
        else {
            $id_str = implode(',',$array);
            return [
                'status'=>0,
                'message'=>'Bu Ürün Malzeme Talebinde Geçmektedir.Bu sebeple Silinemez.TALEP KODLARI : '.$id_str,
                'id'=>0
            ];
        }

    }


    public function details($id){
        $this->db->select('*');
        $this->db->from('proje_stoklari');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function stokdetails($id){
        $this->db->select('*');
        $this->db->from('stock_io');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function stokfiledetails($id){
        $this->db->select('*');
        $this->db->from('stock_io_file');
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


    public function stock_parent($id){
        $this->db->select('proje_stoktlari_parent.*,geopos_products.product_name,geopos_units.name as unit_name');
        $this->db->from('proje_stoktlari_parent');
        $this->db->join('geopos_products','proje_stoktlari_parent.product_id=geopos_products.pid');
        $this->db->join('geopos_units', 'proje_stoktlari_parent.unit_id=geopos_units.id');
        $this->db->where('proje_stoklari_id', $id);
        $query = $this->db->get();
        return $query->result();
    }


    public function add_activity($name, $prid,$key3='',$tutar=0)

    {
        $data = array('key3'=>$key3,'pid' => $prid, 'meta_key' => 12, 'value' => $name . ' @' . date('Y-m-d H:i:s'),'total'=>$tutar);

        if ($prid) {

            return $this->db->insert('geopos_project_meta', $data);

        } else {

            return 0;
        }

    }

    public function create_fis_cloud(){
        $post_data = $this->input->post("collection");
        if(isset($post_data)){

            $warehouse_list = [];
            foreach ($post_data as $items){
                $warehouse_list[]=$items['warehouse_id'];
            }
            $uniq_ = array_unique($warehouse_list);
            if(count($uniq_) > 1){
                return [
                    'status'=>0,
                    'message'=>'Farklı Depolardan Çıkışı Aynı Anda Oluşturamazsınız!',
                    'id'=>0
                ];
            }
            else {
                $code = numaric(9);
                $data_items = array(
                    'pers_id'      => $this->input->post("pers_id"),
                    'cari_pers_type'      => $this->input->post("cari_pers_type"),
                    'aauth_id'      => $this->aauth->get_user()->id,
                    'code'         => $code ,
                    'warehouse_id'     => $uniq_[0],
                    'type'     => '0',
                    'fis_tur'     => 2
                );

                if($this->db->insert('stock_io', $data_items)){
                    $stock_io_id = $this->db->insert_id();
                    $index=0;
                    $product_list=[];
                    foreach ($post_data as $items){
                        //stok çıkış /giriş
                        $stock_id = stock_update_new($items['product_id'],$items['unit_id'],$items['qty'],$items['fis_type'],$items['warehouse_id'],$this->aauth->get_user()->id,$stock_io_id,3);
                        //stok çıkış /giriş

                        $value_id= $items['product_stock_code_id'];
                        $options_id='';
                        $i=0;
                        if($value_id){
//                            $option_details = $this->db->query("select * from product_option_value Where id  IN ($value_id)")->result();
//                            foreach ($option_details as $option_items){
//                                if ($i === array_key_last($option_details)) {// first loop
//                                    $options_id.=$option_items->product_option_id;
//                                }
//                                else {
//                                    $options_id.=$option_items->product_option_id.',';
//                                }
//                                $i++;
//                            }
                            stock_update_options_new($stock_id,$value_id);
                        }




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
                            'product_stock_code_id'      => $items['product_stock_code_id'],
                            'product_desc'      => isEmptyFunction($items['product_desc'],''),
                            'description' => $items['product_desc'],
                        );
                        $product_list[$index]=$data;
                        $index++;
                        cloud_stock_update($stock_io_id,$items['cloud_stock_id']);
                    }
                    if($index){
                        if ($this->db->insert_batch('stock_io_products', $product_list)) {
                            $operator= "deger+1";
                            $this->db->set('deger', "$operator", FALSE);
                            $this->db->where('tip', 9);
                            $this->db->update('numaric');
                            $last_id = $this->db->insert_id();
                            $this->aauth->applog("Proje Stok ÇIKIŞ / Giriş Fişi Oluşturuldu: Talep ID : ".$stock_io_id, $this->aauth->get_user()->username);

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


        }
        else {
            return [
                'status'=>0,
                'message'=>'Herhangi Bir Veri Gönderilmemiştir',
                'id'=>0
            ];
        }
    }

    public function create_fis(){
        $post_data = $this->input->post("collection");
        if(isset($post_data)){

            $code = numaric(9);
            $data_items = array(
                'pers_id'      => $post_data[0]['personel_id'],
                'cari_pers_type'      => $post_data[0]['cari_pers_type'],
                'aauth_id'      => $this->aauth->get_user()->id,
                'code'         => $code ,
                'warehouse_id'     => $post_data[0]['warehouse_id'],
                'type'     => $post_data[0]['fis_type'],
                'fis_tur'     => 2
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
                    if($value_id){
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
                    }




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
                        $this->aauth->applog("Proje Stok ÇIKIŞ / Giriş Fişi Oluşturuldu: Talep ID : ".$stock_io_id, $this->aauth->get_user()->username);

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
                            $this->aauth->applog("Proje Stok ÇIKIŞ / Giriş Fişi güncellendi: Talep ID : ".$stock_io_id, $this->aauth->get_user()->username);
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

    public function insert_file_fis(){
        $stock_io_id = $this->input->post('stock_io_id');
        $file_name = $this->input->post('file_name');
        $file = $this->input->post('file');
        $user_id = $this->aauth->get_user()->id;

        $data = array(
            'stock_io_id' => $stock_io_id,
            'file_name' => $file_name,
            'file' => $file,
            'user_id' => $user_id,
        );
        if ($this->db->insert('stock_io_file', $data)) {
            $this->aauth->applog("Stok Fişine Dosya Eklendi".$stock_io_id, $this->aauth->get_user()->username);
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Dosya Eklendi'
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız.Yöneticiye Başvurun',
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
                   $this->aauth->applog("Proje Stok ÇIKIŞ / Giriş Fişi Silindi: Talep Code : ".$code, $this->aauth->get_user()->username);
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

    public function delete_fis_file(){
        $id = $this->input->post('stok_id');
        $details = $this->stokfiledetails($id);
        $user_id = $this->aauth->get_user()->id;
        if($user_id==$details->user_id){

               if( $this->db->delete('stock_io_file', array('id' => $id))){
                   $this->aauth->applog("Proje Stok ÇIKIŞ / Giriş Fişinden File Silindi: Fiş ID : ".$details->stock_io_id, $this->aauth->get_user()->username);
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
                'message'=>'Silmek için Yetkiniz Bulunmamaktadır.Dosyayı Yükleyen Silebilir',
                'id'=>0
            ];
        }
    }


    function datatables_stok_fis_list_file()

    {
        $this->_datatable_fis_list_file();
        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }

    private function _datatable_fis_list_file()

    {

        $id = $this->input->post('stok_id');
        $this->db->select('stock_io_file.*,geopos_employees.name as user_name');
        $this->db->from('stock_io_file');
        $this->db->join('geopos_employees', 'geopos_employees.id = stock_io_file.user_id');
        $this->db->where('stock_io_file.stock_io_id',$id);
        $i = 0;

        foreach ($this->column_search_fis_file as $item) // loop column

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

                if (count($this->column_search_fis_file) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order_fis_file[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }

    function count_filtered_fis_list_file()

    {

        $this->_datatable_fis_list_file();
        $query = $this->db->get();
        return $query->num_rows();

    }
    public function count_all_fis_list_file()

    {

        $this->_datatable_fis_list_file();


        $query = $this->db->get();

        return $query->num_rows();

    }

}