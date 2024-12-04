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





class Kasatalep_model extends CI_Model
{
    var $table_news = 'talep_form_personel ';

    var $column_search = array('talep_form_personel.code', 'talep_form_personel.desc', 'geopos_employees.name', 'progress_status.name','geopos_projects.code','talep_form_status.name');

    var $column_order = array('talep_form_personel.code', 'geopos_customers.company','talep_form_personel.desc', 'geopos_employees.name', 'progress_status.name','geopos_projects.code');


    var $order = array('id' => 'DESC');


    public function __construct()
    {
        parent::__construct();
        $this->load->model('communication_model');

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
        $aauth_id = $this->aauth->get_user()->id;

        $this->db->select('talep_form_personel.*,geopos_employees.name as pers_name,progress_status.name as progress_name,talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name');
        $this->db->from('talep_form_personel');
        $this->db->join('geopos_employees','talep_form_personel.talep_eden_user_id=geopos_employees.id');
        $this->db->join('progress_status','talep_form_personel.progress_status_id=progress_status.id','LEFT');
        $this->db->join('geopos_projects','talep_form_personel.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_personel.status=talep_form_status.id');
        $i = 0;
        if($this->input->post('status_id')!=0){
            $this->db->where('talep_form_personel.status',$this->input->post('status_id'));
        }

        if(!$this->input->post('yetki')){
            $this->db->where('talep_form_personel.aauth',$aauth_id);
        }

        $this->db->where('talep_form_personel.tip',2);


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
        $this->db->order_by('`talep_form_personel`.`id` DESC');

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

    public function create_save(){
        //$all_users = $this->input->post('all_users');
        $progress_status_id = $this->input->post('progress_status_id');
        $talep_eden_user_id = $this->aauth->get_user()->id;
        $proje_id  = $this->db->query("SELECT * FROM personel_salary Where personel_id=$talep_eden_user_id and status=1")->row()->proje_id;
        $method = $this->input->post('method');
        $personel_id = $this->aauth->get_user()->id;
        $desc = $this->input->post('desc');
        $image_text = $this->input->post('image_text');


        $talep_no = numaric(5);
        $data = array(
            'code' => $talep_no,
            'progress_status_id' => $progress_status_id,
            'talep_eden_user_id' => $talep_eden_user_id,
            'personel_id' => $personel_id,
            'method' => $method,
            'proje_id' => $proje_id,
            'desc' => $desc,
            'tip' => 2,
            'aauth' => $this->aauth->get_user()->id
        );
        if ($this->db->insert('talep_form_personel', $data)) {
            $last_id = $this->db->insert_id();
            numaric_update(5);

            $data_images = array(
                'image_text' => $image_text,
                'form_id' => $last_id,
            );
            $this->db->insert('talep_form_personel_files', $data_images);
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
        $personel_id = $this->input->post('personel_id');
        $desc = $this->input->post('desc');
        $image_text = $this->input->post('image_text');
        $file_id = $this->input->post('file_id');

        $data = array(
            'progress_status_id' => $progress_status_id,
            'talep_eden_user_id' => $talep_eden_user_id,
            'personel_id' => $personel_id,
            'method' => $method,
            'proje_id' => $proje_id,
            'desc' => $desc,
            'aauth' => $this->aauth->get_user()->id
        );
        $this->db->set($data);
        $this->db->where('id', $file_id);
        if ($this->db->update('talep_form_personel', $data)) {

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
        $this->db->from('talep_form_personel_files');
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function details($id){
        $this->db->select('*');
        $this->db->from('talep_form_personel');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function create_form_items(){

        $product_id = $this->input->post('product_id');
        $product_desc = $this->input->post('product_desc');
        $product_kullanim_yeri = $this->input->post('product_kullanim_yeri');
        $product_temin_date = $this->input->post('product_temin_date');
        $progress_status_id = $this->input->post('progress_status_id');
        $unit_id = $this->input->post('unit_id');
        $product_qty = $this->input->post('product_qty');
        $product_price = $this->input->post('product_price');
        $form_id = $this->input->post('form_id');

        if($product_temin_date==''){
            $product_temin_date=date('Y-m-d');
        }
        $data = array(
            'cost_id' => $product_id,
            'progress_status_id' => $progress_status_id,
            'product_desc' => $product_desc,
            'product_kullanim_yeri' => $product_kullanim_yeri,
            'product_temin_date' => $product_temin_date,
            'unit_id' => $unit_id,
            'product_qty' => $product_qty,
            'price' => $product_price,
            'total' => floatval($product_price)*floatval(($product_qty)),
            'form_id' => $form_id,
            'aauth' => $this->aauth->get_user()->id
        );
        if ($this->db->insert('talep_form_personel_products', $data)) {
            $talep_form_products_id = $this->db->insert_id();

            $product_name= cost_details($product_id)->name;
            $unit_name = units_($unit_id)['name'];
            $this->talep_history($form_id,$this->aauth->get_user()->id,'Gider Eklendi : '.$product_name.' | '.$product_qty.' '.$unit_name);
            $last_id = $this->db->insert_id();
            $this->aauth->applog("Malzeme Talebine Ürünler Eklendi  : Talep ID : ".$form_id, $this->aauth->get_user()->username);

            return [
                'status'=>1,
                'id'=>$last_id,
                'talep_form_products_id'=>$talep_form_products_id,
                'product_name'=>cost_details($product_id)->name,
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

    public function talep_history($id,$user_id,$desc){
        date_default_timezone_set('Asia/Baku');
        $data_step = array(
            'talep_id' => $id,
            'user_id' => $user_id,
            'desc' => $desc,
        );
        $this->db->insert('personel_talep_history', $data_step);

    }

    public function product_details($id){
        $this->db->select('talep_form_personel_products.*,geopos_cost.name,geopos_units.name as unit_name');
        $this->db->from('talep_form_personel_products');
        $this->db->join('geopos_cost','talep_form_personel_products.cost_id=geopos_cost.id');
        $this->db->join('geopos_units','talep_form_personel_products.unit_id=geopos_units.id');
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        return $query->result();
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
        if ($this->db->update('talep_form_personel', $data)) {

            if($status==10) // İptal ise Qaime var ise iptal et ve stok hareketlerini iptal et
            {

                $data_iptal = array(
                    'iptal_status' => $now_status,
                );
                $this->db->set($data_iptal);
                $this->db->where('id', $file_id);
                $this->db->update('talep_form_personel', $data_iptal);


                $desc = $this->input->post('desc');
                $this->talep_history($file_id,$this->aauth->get_user()->id,'Talep İptal Edildi.Açıklama : '.$desc);

            }
            $this->aauth->applog("Personel Avans Talebi Güncellendi  : Talep No : ".$file_id, $this->aauth->get_user()->username);
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


}