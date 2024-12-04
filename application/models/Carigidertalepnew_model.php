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





class Carigidertalepnew_model extends CI_Model
{
    var $table_news = 'talep_form_customer_new ';

    var $column_search = array('talep_form_customer_new.code', 'talep_form_customer_new.desc', 'geopos_employees.name', 'progress_status.name','geopos_projects.code','talep_form_status.name','geopos_customers.company');

    var $column_order = array('talep_form_customer_new.id', 'geopos_customers.company','progress_status.name','geopos_customers.created_at', 'geopos_customers.aauth', 'geopos_customers.proje_id',null,'talep_form_customer_new.status','talep_form_customer_new.gider_durumu','talep_form_customer_new.invoice_durumu',NULL);

    var $order = array('id' => 'DESC');

    var $column_search_notes = array('desc', 'created_at', 'geopos_employees.name');
    var $column_search_history = array('desc', 'created_at', 'geopos_employees.name');


    public function __construct()
    {
        parent::__construct();
        $this->load->model('communication_model');
        $this->load->model('Demirbas_model', 'dmodel');

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

        $this->db->select('talep_form_customer_new.*,geopos_employees.name as pers_name,progress_status.name as progress_name,talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name,geopos_customers.company');
        $this->db->from('talep_form_customer_new');
        $this->db->join('geopos_employees','talep_form_customer_new.talep_eden_user_id=geopos_employees.id');
        $this->db->join('progress_status','talep_form_customer_new.progress_status_id=progress_status.id','LEFT');
        $this->db->join('geopos_projects','talep_form_customer_new.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_customer_new.status=talep_form_status.id');
        $this->db->join('geopos_customers','talep_form_customer_new.cari_id=geopos_customers.id','LEft');
        $i = 0;
        if($this->input->post('status_id')!=0){
            $this->db->where('talep_form_customer_new.status',$this->input->post('status_id'));
        }

        $this->db->where('talep_form_customer_new.type',1);

        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_customer_new.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        if($this->input->post('aauth')=='aauth'){
            $user_id  = $this->aauth->get_user()->id;
            $this->db->where('talep_form_customer_new.aauth', $user_id); //2019-11-23 14:28:57
        }
        if($this->input->post('aauth')=='paylist'){
            $this->db->join('talep_form_customer_new_payment','talep_form_customer_new.id =talep_form_customer_new_payment.form_id');
            $this->db->where('talep_form_customer_new.alacak_durum ', 0); //2019-11-23 14:28:57
            $this->db->where('talep_form_customer_new.status ', 9); //2019-11-23 14:28:57
            $this->db->group_by('`talep_form_customer_new`.`id`');
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
            $this->db->order_by('`talep_form_customer_new`.`id` DESC');
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





    public function giderhizmetbekleyenlist()

    {
        $this->_giderhizmetbekleyenlist();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }


    private function _giderhizmetbekleyenlist()

    {

        $this->db->select('talep_form_customer_new.*,geopos_employees.name as pers_name,progress_status.name as progress_name,talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name,geopos_customers.company');
        $this->db->from('talep_form_customer_new');
        $this->db->join('geopos_employees','talep_form_customer_new.talep_eden_user_id=geopos_employees.id');
        $this->db->join('progress_status','talep_form_customer_new.progress_status_id=progress_status.id','LEFT');
        $this->db->join('geopos_projects','talep_form_customer_new.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_customer_new.status=talep_form_status.id');
        $this->db->join('geopos_customers','talep_form_customer_new.cari_id=geopos_customers.id','LEFT');
        $i = 0;

        $this->db->where('talep_form_customer_new.type',1);

        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_customer_new.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        $user_id  = $this->aauth->get_user()->id;
        $this->db->where('talep_form_customer_new.talep_eden_user_id', $user_id); //2019-11-23 14:28:57
        $this->db->where('talep_form_customer_new.alacak_durum', 0);
        $this->db->where('talep_form_customer_new.status', 9);


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
            $this->db->order_by('`talep_form_customer_new`.`id` DESC');
        }


    }


    public function count_filtered_hizmet()
    {
        $this->_giderhizmetbekleyenlist();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_hizmet()
    {
        $this->_giderhizmetbekleyenlist();
        return $this->db->count_all_results();
    }

    public function _count_gider_hizmet(){
        $this->db->select('talep_form_customer_new.*,geopos_employees.name as pers_name,progress_status.name as progress_name,talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name,geopos_customers.company');
        $this->db->from('talep_form_customer_new');
        $this->db->join('geopos_employees','talep_form_customer_new.talep_eden_user_id=geopos_employees.id','LEFT');
        $this->db->join('progress_status','talep_form_customer_new.progress_status_id=progress_status.id','LEFT');
        $this->db->join('geopos_projects','talep_form_customer_new.proje_id=geopos_projects.id','LEFT');
        $this->db->join('talep_form_status','talep_form_customer_new.status=talep_form_status.id','LEFT');
        $this->db->join('geopos_customers','talep_form_customer_new.cari_id=geopos_customers.id','LEft');
        $i = 0;
        $this->db->where('talep_form_customer_new.type',1);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_customer_new.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $user_id  = $this->aauth->get_user()->id;
        $this->db->where('talep_form_customer_new.talep_eden_user_id', $user_id); //2019-11-23 14:28:57
        $this->db->where('talep_form_customer_new.alacak_durum', 0);
        $this->db->where('talep_form_customer_new.status', 9);
        $query = $this->db->get();

        return [
            'status'=>1,
            'count'=>$query->num_rows()
        ];
    }


    public function create_save_cart(){
        //$all_users = $this->input->post('all_users');
        $progress_status_id = $this->input->post('progress_status_id');
        $talep_eden_user_id = $this->input->post('talep_eden_user_id');
        $proje_id = $this->input->post('proje_id');
        $method = $this->input->post('method');
        $cari_id = $this->input->post('cari_id');
        $desc = $this->input->post('desc');
        $image_text = $this->input->post('image_text');
        $talep_no = numaric(1);
        $data = array(
            'code' => $talep_no,
            'progress_status_id' => $progress_status_id,
            'talep_eden_user_id' => $talep_eden_user_id,
            'cari_id' => $cari_id,
            'method' => $method,
            'proje_id' => $proje_id,
            'desc' => $desc,
            'demirbas_id' => -1,
            'loc' =>  $this->session->userdata('set_firma_id'),
            'aauth' => $this->aauth->get_user()->id
        );
        if ($this->db->insert('talep_form_customer_new', $data)) {
            $last_id = $this->db->insert_id();

            //items

            $user_id = $this->aauth->get_user()->id;
            $products_list = $this->db->query("SELECT * FROM talep_form_customer_products_new Where cloud=1 and aauth = $user_id");
            if($products_list->num_rows()){
                numaric_update(1);
                if($image_text){
                    $data_images = array(
                        'image_text' => $image_text,
                        'form_id' => $last_id,
                    );
                    $this->db->insert('talep_form_customer_files', $data_images);
                }
                //all_user
                $this->aauth->applog("Gider Talebi Oluşturuldu  : Talep No : ".$talep_no, $this->aauth->get_user()->username);

                $say = 0;
                foreach ($products_list->result() as $items_val){
                    $id = $items_val->id;
                    $update_data = [
                        'form_id'=>$last_id,
                        'cloud'=>0
                    ];
                    $this->db->set($update_data);
                    $this->db->where('id', $id);
                    if($this->db->update('talep_form_customer_products_new', $update_data)){
                        $say++;
                    }
                }

                if($say==$products_list->num_rows()){
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
                //

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
                'id'=>0
            ];
        }
    }

    public function create_cart()
    {

        $firma_demirbas_id = $this->input->post('firma_demirbas_id');
        $demirbas_id = $this->input->post('demirbas_id');
        $cost_id = $this->input->post('cost_id');
        $item_qty = $this->input->post('item_qty');
        $item_price = $this->input->post('item_price');
        $item_desc = $this->input->post('item_desc');
        $item_unit = $this->input->post('item_unit');
        $total = $item_price*$item_qty;


        $data = array(
            'cost_id' => $cost_id,
            'progress_status_id' => 1,
            'product_desc' => $item_desc,
            'product_kullanim_yeri' => '',
            'unit_id' => $item_unit,
            'product_qty' => $item_qty,
            'price' => $item_price,
            'total' => $total,
            'form_id' => 0,
            'cloud' => 1,
            'aauth' => $this->aauth->get_user()->id
        );

        if($this->db->insert('talep_form_customer_products_new', $data)) {
            $last_id = $this->db->insert_id();
            $data_item = array(
              'firma_demirbas_id'=>$firma_demirbas_id,
              'demirbas_id'=>$demirbas_id,
              'item_id'=>$last_id,
            );
            $this->db->insert("gider_sepet_connect",$data_item);
            $this->aauth->applog("Gider Sepetine Gider Atıldı  : ", $this->aauth->get_user()->username);
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


        $talep_no = numaric(1);
        $data = array(
            'code' => $talep_no,
            'progress_status_id' => $progress_status_id,
            'talep_eden_user_id' => $talep_eden_user_id,
            'cari_id' => $cari_id,
            'method' => $method,
            'proje_id' => $proje_id,
            'desc' => $desc,
            'demirbas_id' => $demirbas_id,
            'firma_demirbas_id' => $firma_demirbas_id,
            'loc' =>  $this->session->userdata('set_firma_id'),
            'aauth' => $this->aauth->get_user()->id
        );
        if ($this->db->insert('talep_form_customer_new', $data)) {
            $last_id = $this->db->insert_id();
            numaric_update(1);

            $data_images = array(
                'image_text' => $image_text,
                'form_id' => $last_id,
            );
            $this->db->insert('talep_form_customer_files', $data_images);
            //all_user

            $this->aauth->applog("Gider Talebi Oluşturuldu  : Talep No : ".$talep_no, $this->aauth->get_user()->username);

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

    public function update_form(){

        $progress_status_id = $this->input->post('progress_status_id');
        $talep_eden_user_id = $this->input->post('talep_eden_user_id');
        $proje_id = $this->input->post('proje_id');
        $method = $this->input->post('method');
        $cari_id = $this->input->post('cari_id');
        $desc = $this->input->post('desc');
        $image_text = $this->input->post('image_text');
        $file_id = $this->input->post('file_id');

        $data = array(
            'progress_status_id' => $progress_status_id,
            'talep_eden_user_id' => $talep_eden_user_id,
            'cari_id' => $cari_id,
            'method' => $method,
            'proje_id' => $proje_id,
            'desc' => $desc,
            'aauth' => $this->aauth->get_user()->id
        );
        $this->db->set($data);
        $this->db->where('id', $file_id);
        if ($this->db->update('talep_form_customer_new', $data)) {

            $this->aauth->applog("Gider Talebi Güncellendi  : Talep No : ".$file_id, $this->aauth->get_user()->username);
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

    public function file_details($id){
        $this->db->select('*');
        $this->db->from('talep_form_customer_files');
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function details($id){
        $this->db->select('*');
        $this->db->from('talep_form_customer_new');
        $this->db->where('id',$id);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_customer_new.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        $query = $this->db->get();
        return $query->row();
    }

    public function create_form_items(){


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


        $product_id = $group_id;
        $product_desc = $this->input->post('product_desc');
        $unit_id = $this->input->post('unit_id');
        $product_qty = $this->input->post('product_qty');
        $product_price = $this->input->post('product_price');
        $form_id = $this->input->post('form_id');

        $data = array(
            'cost_id' => $product_id,
            'product_desc' => $product_desc,
            'unit_id' => $unit_id,
            'product_qty' => $product_qty,
            'price' => $product_price,
            'total' => floatval($product_price)*floatval(($product_qty)),
            'form_id' => $form_id,
            'aauth' => $this->aauth->get_user()->id
        );
        if ($this->db->insert('talep_form_customer_products_new', $data)) {
            $talep_form_products_id = $this->db->insert_id();

            $product_name= who_demirbas($product_id)->name;
            $unit_name = units_($unit_id)['name'];
            $this->talep_history($form_id,$this->aauth->get_user()->id,'Gider Eklendi : '.$product_name.' | '.$product_qty.' '.$unit_name);
            $last_id = $this->db->insert_id();
            $this->aauth->applog("Gider Talebine Ürünler Eklendi  : Talep ID : ".$form_id, $this->aauth->get_user()->username);

            return [
                'status'=>1,
                'id'=>$last_id,
                'talep_form_products_id'=>$talep_form_products_id,
                'product_name'=>who_demirbas($product_id)->name,
                'qyt_birim'=>$product_qty.' '.units_($unit_id)['name'],
            ];
        }
        else {
            return [
                'status'=>0,
                'id'=>0
            ];
        }
    }

    public function talep_history($id,$user_id,$desc,$tip=2){
        date_default_timezone_set('Asia/Baku');
        $data_step = [
            'talep_id' => $id,
            'user_id' => $user_id,
            'desc' => $desc,
            'tip' => $tip,
        ];
        $this->db->insert('customer_talep_history', $data_step);

    }

    public function product_details($id){
        $this->db->select('talep_form_customer_products_new.*,demirbas_group.name,geopos_units.name as unit_name');
        $this->db->from('talep_form_customer_products_new');
        $this->db->join('demirbas_group','talep_form_customer_products_new.cost_id=demirbas_group.id');
        $this->db->join('geopos_units','talep_form_customer_products_new.unit_id=geopos_units.id');
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        return $query->result();
    }
    public function product_details2($id){
        $this->db->select('*');
        $this->db->from('talep_form_customer_products');
        $this->db->join('geopos_units','talep_form_customer_products.unit_id=geopos_units.id');
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function form_total($id){
        $this->db->select('SUM(total) as total');
        $this->db->from('talep_form_customer_products_new');
        $this->db->where('cost_id!=',0);
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        return $query->row()->total;
    }

    public function form_total_bekleyen(){
        $this->db->select('SUM(total) as total');
        $this->db->from('talep_form_customer_products_new');
        $this->db->where('cost_id!=',0);
        $this->db->join('talep_form_customer_new','talep_form_customer_products_new.form_id=talep_form_customer_new.id');
        $this->db->where_in('talep_form_customer_new.status',[12]);
        $query = $this->db->get();
        return $query->row()->total;
    }
    public function form_total_bekleyen_method($method){
        $this->db->select('SUM(total) as total');
        $this->db->from('talep_form_customer_products_new');
        $this->db->where('cost_id!=',0);
        $this->db->join('talep_form_customer_new','talep_form_customer_products_new.form_id=talep_form_customer_new.id');
        $this->db->where_in('talep_form_customer_new.status',[12]);
        $this->db->where('talep_form_customer_new.method',$method);
        $query = $this->db->get();
        return $query->row()->total;
    }

    public function odeme_total($id){
        $this->db->select('SUM(total) as total');
        $this->db->from('talep_form_customer_new_payment');
        $this->db->where('form_id',$id);
        $this->db->where('tip',1);
        $query = $this->db->get();
        return $query->row()->total;
    }

    public function send_mail($user_id,$subject,$message){
        $message .= "<br><br><br><br>";
        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
        $proje_sorumlusu_email = personel_detailsa($user_id)['email'];
        $recipients = array($proje_sorumlusu_email);
        $this->communication_model->onay_mail($recipients, $subject, $message, false,'', 'gider_talep_onay_maili');
        return 1;
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
        if ($this->db->update('talep_form_customer_new', $data)) {

            if($status==10) // İptal ise Qaime var ise iptal et ve stok hareketlerini iptal et
            {

                $data_iptal = array(
                    'iptal_status' => $now_status,
                );
                $this->db->set($data_iptal);
                $this->db->where('id', $file_id);
                $this->db->update('talep_form_customer_new', $data_iptal);


                $desc = $this->input->post('desc');
                $this->talep_history($file_id,$this->aauth->get_user()->id,'Talep İptal Edildi.Açıklama : '.$desc);
                $this->aauth->applog("Cari Gider Talebi İptal Edildi  : Talep No : ".$file_id, $this->aauth->get_user()->username);
                $talep_form_customer_new_payment = $this->db->query("SELECT * FROM talep_form_customer_new_payment Where form_id=$file_id and tip=1");
                if($talep_form_customer_new_payment->num_rows()){
                    foreach ($talep_form_customer_new_payment->result() as $values){
                        // Odemeleri Sil
                        $this->db->delete('geopos_invoices', array('id' => $values->transaction_id));
                    }

                    $this->db->delete('talep_form_customer_new_payment', array('form_id' => $file_id,'tip'=>1));
                }
                if($details_->gider_durumu){
                    //giderlerden sil
                    $this->db->delete('firma_gider', array('type' => 1,'talep_id'=>$file_id));


                }
                if($details_->invoice_durumu){
                    //faturayı iptal et
                    $invoice_id = $details_->invoice_id;
                    $data_iptal_invoice = array(
                        'status' => 3,
                    );
                    $this->db->set($data_iptal_invoice);
                    $this->db->where('id', $invoice_id);
                    $this->db->update('geopos_invoices', $data_iptal_invoice);
                }



                $mesaj=$details_->code.' Numaralı Gider Talep Formu İptal Edilmiştir.';
                $this->send_mail($details_->aauth,'Gider Talep İptali',$mesaj);

            }
            elseif($status < 0){

                $data_iptal = array(
                    'status' => $details_->iptal_status,
                );
                $this->db->set($data_iptal);
                $this->db->where('id', $file_id);
                $this->db->update('talep_form_customer_new', $data_iptal);


                $desc = $this->input->post('desc');
                $this->talep_history($file_id,$this->aauth->get_user()->id,'Talep İptal Geri Alındı.Açıklama : '.$desc);
                $this->aauth->applog("Cari Gider Talebi İptal Edildi  : Talep No : ".$file_id, $this->aauth->get_user()->username);


            }
            else {
                $desc = $this->input->post('desc');
                $st_name = talep_form_status_details($now_status)->name;
                $this->talep_history($file_id,$this->aauth->get_user()->id,'Durum Güncellendi.Status :'.$st_name.' .Açıklama : '.$desc);
                $this->aauth->applog("Cari Gider Talebi Durum Güncellendi  : Talep No : ".$file_id, $this->aauth->get_user()->username);

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


        $this->db->select('talep_form_customer_notes.*,geopos_employees.name as pers_name');
        $this->db->from('talep_form_customer_notes');
        $this->db->join('geopos_employees','talep_form_customer_notes.aaut_id=geopos_employees.id');
        $this->db->where('talep_form_customer_notes.talep_id',$id);
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
        $this->db->order_by('`talep_form_customer_notes`.`id` DESC');

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
        if ($this->db->insert('talep_form_customer_notes', $data)) {
            $this->aauth->applog("Gider Talebine Not Eklendi  : Talep No : ".$talep_no, $this->aauth->get_user()->username);

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

    public function hizmetconfirm(){

        $message='';
        $error=0;
        $ids = $this->input->post('product_details');
        foreach ($ids as $items){
            $talep_id = $items['id'];
            $details = $this->details($talep_id);
            $code="<b>$details->code</b>";
            $details_items = $this->product_details2($talep_id);
            $alacak_tutar=$this->form_total($talep_id);


            if(floatval($alacak_tutar)>0){
                if(!$details->gider_durumu){
                    $res = $this->dmodel->gider_create_form($talep_id,1);
                }
                if($details->cari_id){
                    $not = $details->code.' İstinaden Alacaklandırma';
                    $data = array(
                        'csd' => $details->cari_id,
                        'payer' => customer_details($details->cari_id)['company'],
                        'acid' => 0, //hesapID ekleneck
                        'account' => 'Kasasız İşlem',
                        'total' => $alacak_tutar,
                        'invoice_type_id'=>39,
                        'invoice_type_desc'=>invoice_type_desc(39),
                        'method' => $details->method,
                        'eid' => $this->aauth->get_user()->id, //user_id
                        'notes' => $not,
                        'proje_id' => $details->proje_id,
                    );
                    if($this->db->insert('geopos_invoices', $data)) {
                        $data_talep_updata =
                            [
                                'alacak_durum' => 1,
                            ];
                        $this->db->where('id', $talep_id);
                        $this->db->set($data_talep_updata);
                        if ($this->db->update('talep_form_customer_new', $data_talep_updata)) {
                            $message.="<br>$code Bu Talep Başarıyla Güncellendi";
                        }
                    }
                }
                else {
                    $message.="<br>$code Bu Talepde Cari Seçilmemiştir!Lütfen Cari Bilgileri Güncelleyin";

                }


            }
            else {
                $message.="<br>$code Bu Talepde Herhangi Bir Tutar Belirlenmemiştir.Lütfen Tutar Belirlensin";

            }
        }

        return [
            'status'=>200,
            'message'=>$message
        ];

    }
}