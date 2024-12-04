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





class Virman_model extends CI_Model
{
    var $table_news = 'virman ';

    var $column_search = array('virman.code', 'virman.desc', 'geopos_employees.name');

    var $column_order = array('virman.id','virman.code', 'virman.desc', 'geopos_employees.name');

    var $order = array('virman.id' => 'DESC');


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

        $this->db->select('virman.*,geopos_employees.name as pers_name');
        $this->db->from('virman');
        $this->db->join('geopos_employees','virman.aaut_id=geopos_employees.id');
        $i=0;

        if($this->session->userdata('set_firma_id')){
            $this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
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
        $this->db->order_by('`virman`.`id` DESC');

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
        $invoice_date = $this->input->post('invoice_date');
        $desc = $this->input->post('desc');
        $account_in_price = $this->input->post('account_in_price');
        $account_out_price = $this->input->post('account_out_price');
        $in_price = $this->input->post('in_price');
        $kur_degeri = $this->input->post('kur_degeri');
        $out_price = $this->input->post('out_price');
        $in_account = $this->input->post('in_account');
        $out_account = $this->input->post('out_account');


        $talep_no = numaric(29);
        $data = array(
            'code' => $talep_no,
            'out_account_id' => $out_account,
            'in_account_id' => $in_account,
            'kur_degeri' => $kur_degeri,
            'out_price' => $out_price,
            'in_price' => $in_price,
            'account_out_price' => $account_out_price,
            'account_in_price' => $account_in_price,
            'date' => $invoice_date,
            'desc' => $desc,
            'loc' => $this->session->userdata('set_firma_id'),
            'aaut_id' => $this->aauth->get_user()->id
        );
        if ($this->db->insert('virman', $data)) {
            $last_id = $this->db->insert_id();
            numaric_update(29);

            $this->aauth->applog("Transfer Talebi Oluşturuldu  : Talep No : ".$talep_no, $this->aauth->get_user()->username);

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

    public function update(){

        $id = $this->input->post('id');
        $details = $this->details($id);
        $invoice_date = $this->input->post('invoice_date');
        $desc = $this->input->post('desc');
        $account_in_price = $this->input->post('account_in_price');
        $account_out_price = $this->input->post('account_out_price');
        $in_price = $this->input->post('in_price');
        $kur_degeri = $this->input->post('kur_degeri');
        $out_price = $this->input->post('out_price');
        $in_account = $this->input->post('in_account');
        $out_account = $this->input->post('out_account');

        $data = array(
            'out_account_id' => $out_account,
            'in_account_id' => $in_account,
            'kur_degeri' => $kur_degeri,
            'out_price' => $out_price,
            'in_price' => $in_price,
            'account_out_price' => $account_out_price,
            'account_in_price' => $account_in_price,
            'date' => $invoice_date,
            'desc' => $desc,
            'aaut_id' => $this->aauth->get_user()->id
        );
        $this->db->set($data);
        $this->db->where('id',$id);
        if ($this->db->update('virman', $data)) {
            $this->aauth->applog("Transfer Talebi Güncellendi  : Talep No : ".$details->code, $this->aauth->get_user()->username);

            return [
                'status'=>1,
                'id'=>$id
            ];
        }
        else {
            return [
                'status'=>0,
                'id'=>0
            ];
        }
    }

    public function details($id){
        $this->db->select('*');
        $this->db->from('virman');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function details_onay($id){
        $this->db->select('*');
        $this->db->from('virman_onay');
        $this->db->where('virman_id',$id);
        $this->db->order_by('sort ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function delete(){
        $id = $this->input->post('talep_id');
        $talep_onay_details=$this->details_onay($id);
        $result=false;
        foreach ($talep_onay_details as $items){
            if($items->status){
                $result=true;
            }
        }
        if(!$result){
            if($this->db->delete('virman', array('id' => $id,'aaut_id'=>$this->aauth->get_user()->id))){

                $this->db->delete('virman_onay', array('virman_id' => $id));
                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde Silindi'
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Yetkiniz Bulunmamaktadır'
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Talep Kasalardan Herhangi Birinde Onay İşlemi Verilmiştir. Silme İşlemi Yapılamaz'
            ];
        }



    }
    public function bildirim_olustur(){
        $id = $this->input->post('talep_id');
        $user_id=$this->aauth->get_user()->id;
        $talep_kontrol  = $this->db->query("SELECT * FROM `virman` where id=$id and aaut_id=$user_id")->num_rows();
        if($talep_kontrol){
            $data = array(
                'bildirim_durumu' => 1,
            );
            $this->db->set($data);
            $this->db->where('id', $id);
            if ($this->db->update('virman', $data)) {
                $details = $this->details($id);

                $last_staff_user_id=account_details($details->in_account_id)->eid;
                $data_last = array(
                    'virman_id' => $id,
                    'sort' => 2,
                    'user_id' => $last_staff_user_id,
                    'in_account_id' => $details->in_account_id,
                    'in_price' => $details->in_price,
                    'account_in_price' => $details->account_in_price,
                    'staff' => 0,
                );
                $this->db->insert('virman_onay', $data_last);

                $first_staff_user_id=account_details($details->out_account_id)->eid;
                $data_first = array(
                    'virman_id' => $id,
                    'sort' => 1,
                    'user_id' => $first_staff_user_id,
                    'out_account_id' => $details->out_account_id,
                    'out_price' => $details->out_price,
                    'account_out_price' => $details->account_out_price,
                    'staff' => 1,
                );
                $this->db->insert('virman_onay', $data_first);
                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde Bildirim Başlatılmıştır'
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
                'message'=>'Talebi Oluşturan Dışında Talep Bildirime Başlatılamaz'
            ];
        }
    }
    public function list_bekleyen()

    {
        $this->_list_bekleyen();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _list_bekleyen()
    {

        $user_id = $this->aauth->get_user()->id;
        $this->db->select('v.*');
        $this->db->from('virman_onay');
        $this->db->join('virman v','virman_onay.virman_id = v.id');
        $this->db->where('virman_onay.user_id',$user_id);
        $this->db->where('virman_onay.staff',1);
        $this->db->where('virman_onay.status is null');
        $this->db->where('v.loc',$this->session->userdata('set_firma_id'));
        $i=0;
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
        $this->db->order_by('`v`.`id` DESC');


    }
    public function count_filtered_bekleyen()
    {
        $this->_list_bekleyen();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_bekleyen()
    {
        $this->_list_bekleyen();
        return $this->db->count_all_results();
    }

    public function talep_change(){
        date_default_timezone_set('Asia/Baku');
        $tip = $this->input->post('tip');
        $onaylanan_tutar = $this->input->post('onaylanan_tutar');
        $desc = $this->input->post('desc');
        $virman_onay_id = $this->input->post('virman_onay_id');

        $onay_details_count = $this->db->query("SELECT * FROM virman_onay Where id = $virman_onay_id");
        if($onay_details_count->num_rows()){
            $onay_details = $onay_details_count->row();
            $sort = $onay_details->sort;
            $virman_id = $onay_details->virman_id;
            if($tip==1) // Onay
            {
                $data = array(
                    'desc' => $desc,
                    'onaylanan_price' => $onaylanan_tutar,
                    'status' => $tip,
                    'staff' => 0,
                );
                $this->db->set('update_at', 'NOW()', FALSE);
                $this->db->set($data);
                $this->db->where('id',$virman_onay_id);
                $this->db->where('sort',$sort);
                if ($this->db->update('virman_onay', $data)) {
                    $new_sort=$sort+intval(1);
                    $new_onay_details_count = $this->db->query("SELECT * FROM virman_onay Where sort = $new_sort and virman_id=$virman_id");
                        if($new_onay_details_count->num_rows()){
                            $new_onay_details = $new_onay_details_count->row();
                            $data = array(
                                'staff' => 1,
                            );
                            $this->db->set($data);
                            $this->db->where('id',$new_onay_details->id);
                            if( $this->db->update('virman_onay', $data)){
                                return [
                                    'status'=>1,
                                    'message'=>'Başarılı Bir Şekilde Onayınız Verildi Ve Bir Sonraki Kasada İşlem Beklemektedir'
                                ];
                            }

                        }
                        else {
                            // Para Aktarımı Olacak

                            // Çıkış İşlemleri
                            $virma_details = $this->details($virman_id);
                            $details = $this->db->query("SELECT * FROM  virman_onay Where virman_id=$virman_id and out_account_id is not null");
                            if($details->num_rows()){
                                $data_cikis=[
                                    'invoice_no'=>$virma_details->code,
                                    'total'=>$details->row()->onaylanan_price,
                                    'notes'=>$virma_details->desc.' | '.$details->row()->desc,
                                    'eid'=>$details->row()->user_id,
                                    'invoice_type_id'=>28,
                                    'invoice_type_desc'=>invoice_type_desc(28),
                                    'payer'=>account_details($virma_details->out_account_id)->holder,
                                    'para_birimi'=>account_details($virma_details->out_account_id)->para_birimi,
                                    'acid'=>$virma_details->out_account_id,
                                    'acid_'=>$virma_details->in_account_id,
                                    'account'=>account_details($virma_details->in_account_id)->holder,
                                    'method'=>1,
                                    'loc'=>$this->session->userdata('set_firma_id'),
                                ];
                                $this->db->insert('geopos_invoices', $data_cikis);
                            }

                            // Çıkış İşlemleri

                            // Giriş İşlemleri
                            $details_giris = $this->db->query("SELECT * FROM  virman_onay Where virman_id=$virman_id and in_account_id is not null");
                            if($details_giris->num_rows()){
                                $data_cikis=[
                                    'invoice_no'=>$virma_details->code,
                                    'total'=>$details_giris->row()->onaylanan_price,
                                    'notes'=>$virma_details->desc.' | '.$details_giris->row()->desc,
                                    'eid'=>$details_giris->row()->user_id,
                                    'invoice_type_id'=>27,
                                    'invoice_type_desc'=>invoice_type_desc(27),
                                    'payer'=>account_details($virma_details->in_account_id)->holder,
                                    'para_birimi'=>account_details($virma_details->in_account_id)->para_birimi,
                                    'acid'=>$virma_details->in_account_id,
                                    'acid_'=>$virma_details->out_account_id,
                                    'account'=>account_details($virma_details->out_account_id)->holder,
                                    'method'=>1,
                                    'loc'=>$this->session->userdata('set_firma_id'),
                                ];
                                $this->db->insert('geopos_invoices', $data_cikis);
                            }
                            // Giriş İşlemleri
                            return [
                                'status'=>1,
                                'message'=>'Para Aktarımı Yapıldı'
                            ];
                        }
                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Onay Verilirken Hata Aldınız.'
                    ];
                }
            }
            else // İptal
            {
                $data = array(
                    'desc' => $desc,
                    'onaylanan_price' => $onaylanan_tutar,
                    'status' => $tip,
                    'staff' => 0,
                    'update_at' => 'NOW()',
                );
                $this->db->set($data);
                $this->db->where('id',$virman_onay_id);
                $this->db->where('sort',$sort);
                if ($this->db->update('virman_onay', $data)) {
                    return [
                        'status'=>1,
                        'message'=>'Başarılı Bir Şekilde İptal Edildi'
                    ];
                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'İptal Edilirken Hata Aldınız'
                    ];
                }
            }

        }

    }

}