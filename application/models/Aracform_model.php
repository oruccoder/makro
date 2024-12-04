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





class Aracform_model extends CI_Model
{
    var $table_news = 'araclar ';

    var $column_order = array('araclar.code', 'araclar.plaka', 'araclar.name', 'arac_form.code');

    var $column_search = array('araclar.code', 'araclar.plaka', 'araclar.name', 'arac_form.code');

    var $order = array('id' => 'DESC');


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Personelgidertalep_model', 'model');

    }


    public function get_ajax_list_details()

    {
        $this->_get_ajax_list_details();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _get_ajax_list_details()

    {

        $this->db->select('araclar.code,araclar.name,araclar.plaka,araclar.image_text,arac_form.*');
        $this->db->from('arac_form');
        $this->db->join('araclar','arac_form.arac_id=araclar.id');
        $this->db->where('arac_form.deleted_at is NULL');
        if($this->session->userdata('set_firma_id')){
            $this->db->where('araclar.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        $this->db->where('arac_form.arac_id',  $this->input->post('arac_id'));

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
        $this->db->order_by('`arac_form`.`id` DESC');

    }


    public function ajax_count_filtered_details()
    {
        $this->_get_ajax_list_details();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function ajax_count_all_details()
    {
        $this->_get_ajax_list_details();
        return $this->db->count_all_results();
    }

    public function get_ajax_list_details_surucu()

    {
        $this->_get_ajax_list_details_surucu();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _get_ajax_list_details_surucu()

    {

        $arac_id = $this->input->post('arac_id');
        $this->db->select('arac_suruculeri.*,geopos_employees.name as pers_name,geopos_employees.id as pers_id');
        $this->db->from('arac_suruculeri');
        $this->db->join('geopos_employees','arac_suruculeri.user_id=geopos_employees.id');
        $this->db->where('arac_suruculeri.arac_id',$arac_id);
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
        $this->db->order_by('`arac_suruculeri`.`status` ASC');

    }


    public function ajax_count_filtered_details_surucu()
    {
        $this->_get_ajax_list_details_surucu();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function ajax_count_all_details_surucu()
    {
        $this->_get_ajax_list_details_surucu();
        return $this->db->count_all_results();
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

        $this->db->select('araclar.code,araclar.name,araclar.plaka,araclar.image_text,arac_form.*');
        $this->db->from('arac_form');
        $this->db->join('araclar','arac_form.arac_id=araclar.id','Left');
        $this->db->where('arac_form.deleted_at is NULL');
        if($this->session->userdata('set_firma_id')){
            $this->db->where('araclar.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(arac_form.start_date) >=', datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where('DATE(arac_form.end_date) <=', datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
        }

        if ($this->input->post('proje_id')) // if datatable send POST for search
        {
            $this->db->where('proje_id =', $this->input->post('proje_id')); //2019-11-23 14:28:57
        }
        if ($this->input->post('arac_id')) // if datatable send POST for search
        {
            $this->db->where('arac_id =', $this->input->post('arac_id')); //2019-11-23 14:28:57
        }

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
        $this->db->order_by('`arac_form`.`id` DESC');

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


    public function get_datatables_details_bekleyen()

    {
        $this->_get_datatables_query_details_bekleyen();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _get_datatables_query_details_bekleyen()
    {

        $user_id = $this->aauth->get_user()->id;


        $this->db->select('araclar.code,araclar.name,araclar.plaka,araclar.image_text,arac_form.*');
        $this->db->from('arac_form');
        $this->db->join('araclar','arac_form.arac_id=araclar.id','left');
        $this->db->join('aracform_step','arac_form.id=aracform_step.form_id');


        $this->db->where('arac_form.deleted_at is NULL');
        $this->db->where('aracform_step.user_id',$user_id);
        $this->db->where('arac_form.bildirim_durumu',1);

        $this->db->where('aracform_step.step',1);

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
        $this->db->order_by('`arac_form`.`id` DESC');

    }


    public function count_filtered_bekleyen()
    {
        $this->_get_datatables_query_details_bekleyen();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_bekleyen()
    {
        $this->_get_datatables_query_details_bekleyen();
        return $this->db->count_all_results();
    }

    public function create_driver(){
        $surucu_id = $this->input->post('surucu_id');
        $desc = $this->input->post('desc');
        $arac_id = $this->input->post('arac_id');
        $data = array(
            'desc' => $desc,
            'arac_id' => $arac_id,
            'aauth_id' => $this->aauth->get_user()->id,
            'user_id' => $surucu_id
        );
        if ($this->db->insert('arac_suruculeri', $data)) {
            return [
                'status'=>1,
                'messages'=>'Başarılı Bir Şekilde Sürücü Eklendi.Aktif Ediniz'
            ];
        }
        else {
            return [
                'status'=>0,
                'messages'=>'Hata Aldınız'
            ];
        }
    }

    public function create_save(){
        $lokasyon = $this->input->post('lokasyon');
        $gorev_sebebi = $this->input->post('gorev_sebebi');
        $proje_id = $this->input->post('proje_id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $proje_muduru_id = $this->input->post('proje_muduru_id');
        $teknika_sorumlu_id = $this->input->post('teknika_sorumlu_id');
        $genel_mudur_id = $this->input->post('genel_mudur_id');
        $benzin_talebi = $this->input->post('benzin_talebi');
        $benzin_miktari = $this->input->post('benzin_miktari');
        $yemek_talebi = $this->input->post('yemek_talebi');
        $yemek_tutari = $this->input->post('yemek_tutari');
        $arac_id = $this->input->post('arac_id');
        $surucu_sms_status = $this->input->post('surucu_sms_status');
        $surucu_sms_text = $this->input->post('surucu_sms_text');
        $pers_id = $this->input->post('pers_id');
        $talep_no = numaric(20);
        $start_date = dateformat_local($start_date);
        $end_date = dateformat_local($end_date);

        $data_user=[$proje_muduru_id,$genel_mudur_id,$teknika_sorumlu_id];

        $arac_details = $this->db->query("SELECT * From araclar Where id=$arac_id")->row();
        if($arac_details->active_surucu_id){
            $data = array(
                'lokasyon' => $lokasyon,
                'arac_id' => $arac_id,
                'gorev_sebebi' => $gorev_sebebi,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'benzin_talebi' => $benzin_talebi,
                'benzin_miktari' => $benzin_miktari,
                'yemek_talebi' => $yemek_talebi,
                'proje_id' => $proje_id,
                'yemek_tutari' => $yemek_tutari,
                'surucu_sms_text' => $surucu_sms_text,
                'surucu_sms_status' => $surucu_sms_status,
                'status' => 0,
                'bildirim_durumu' => 0,
                'user_id' => $pers_id,
                'aauth_id' => $this->aauth->get_user()->id,
                'code' => $talep_no,
            );
            if ($this->db->insert('arac_form', $data)) {

                $last_id = $this->db->insert_id();
                //step table
                $i=0;
                foreach ($data_user as $user_id){
                    $step=0;
                    if($i==0){
                        $step=1;
                    }
                    $data_step = array(
                        'user_id' => $user_id,
                        'step' => $step,
                        'form_id' => $last_id,
                    );
                    $this->db->insert('aracform_step', $data_step);
                    $i++;
                }
                //step table

                $this->db->set('deger', "deger+1",FALSE);
                $this->db->where('tip', 20);
                $this->db->update('numaric');

                $this->aauth->applog("Araç Talebi Oluşturuldu  : Talep No : ".$talep_no, $this->aauth->get_user()->username);
                return [
                    'status'=>1,
                    'messages'=>'Başarılı Bir Şekilde Form Oluşturuldu'
                ];
            }
            else {
                return [
                    'status'=>0,
                    'messages'=>'Hata Aldınız.'
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'messages'=>'Seçilen Araçta Aktif Sürücü Bulunmamaktadır.'
            ];
        }


    }

    public function status_change_yonetim(){
        $talep_id = $this->input->post('talep_id');
        $status = $this->input->post('status');
        $status_desc = $this->input->post('status_desc');
        $proje_id = $this->input->post('proje_id');

        $details = $this->db->query("SELECT * FROM `arac_form` Where id=$talep_id")->row();

        $new_id=0;
        $new_id_control = $this->db->query("SELECT * FROM `aracform_step` Where form_id=$talep_id and step=0 and status is Null ORDER BY `aracform_step`.`id` ASC LIMIT 1");
        if($new_id_control->num_rows()){
            $new_id = $new_id_control->row()->id;
        }

        $data=array(
            'step'=>0,
            'status'=>$status,
            'desc'=>$status_desc,
        );
        $this->db->where('user_id',$this->aauth->get_user()->id);
        $this->db->where('step',1);
        $this->db->set($data);
        $this->db->where('form_id', $talep_id);
        if ($this->db->update('aracform_step', $data)) {
            if($status==1){

                $data_form=array('proje_id'=>$proje_id);
                $this->db->where('id', $talep_id);
                $this->db->set($data_form);
                $this->db->update('arac_form',$data_form);


                if($new_id){
                    // Bir Sonraki Onay
                    $data_new=array(
                        'step'=>1,
                    );
                    $this->db->where('id',$new_id);
                    $this->db->set($data_new);
                    $this->db->update('aracform_step', $data_new);
                    // Bir Sonraki Onay
                }
                else {
                    //Onay İşlemi Tamalandı
                    $data_form=array('status'=>$status);
                    $this->db->where('id', $talep_id);
                    $this->db->set($data_form);
                    $this->db->update('arac_form',$data_form);
                    //Onay İşlemi Tamalandı

                    // Gider varsa gider talebi oluştur

                    $benzin_tutari=0;
                    $yemek_tutari=0;
                    $data_product=[];


                    if($details->benzin_talebi){

                        $arac_details = $this->db->query("SELECT * From araclar Where id=$details->arac_id")->row();
                        $benzin_cost_id =$arac_details->benzin_cost_id;
                        $benzin_tutari =$details->benzin_miktari;
                        $cost_details = cost_details($benzin_cost_id);

                        $data_product[]=['id'=>$benzin_cost_id,'name'=>$cost_details->name,'tutar'=>$benzin_tutari,'unit_id'=>$cost_details->unit];
                    }
                    if($details->yemek_talebi){
                        $arac_details = $this->db->query("SELECT * From araclar Where id=$details->arac_id")->row();
                        $yemek_cost_id =$arac_details->yemek_cost_id;
                        $yemek_tutari =$details->yemek_tutari;
                        $cost_details_yemek = cost_details($yemek_cost_id);
                        $data_product[]=['id'=>$yemek_cost_id,'name'=>$cost_details_yemek->name,'tutar'=>$yemek_tutari,'unit_id'=>$cost_details_yemek->unit];
                    }

                    if($details->benzin_talebi || $details->yemek_talebi){



                        //$all_users = $this->input->post('all_users');


                        $progress_status_id = 1;
                        $talep_eden_user_id = $details->user_id;
                        $proje_id = $this->db->query("SELECT * FROM personel_salary Where personel_id=$details->user_id and status=1")->row()->proje_id;
                        $method = 1;
                        $personel_id = $details->user_id;
                        $desc = $details->code.' İstinaden Gider Talebi';


                        $talep_no = numaric(1);
                        $data = array(
                            'code' => $talep_no,
                            'progress_status_id' => $progress_status_id,
                            'talep_eden_user_id' => $talep_eden_user_id,
                            'personel_id' => $personel_id,
                            'method' => $method,
                            'proje_id' => $proje_id,
                            'desc' => $desc,
                            'loc' =>  $this->session->userdata('set_firma_id'),
                            'aauth' =>  $details->user_id
                        );
                        if ($this->db->insert('talep_form_personel', $data)) {
                            $last_id = $this->db->insert_id();
                            numaric_update(1);
                            $this->cost_item_update($data_product,$last_id);
                            $this->aauth->applog("Gider Talebi Oluşturuldu  : Talep No : ".$talep_no, $this->aauth->get_user()->username);

                            $this->form_bildirim_olustur($last_id,1);
                        }


                    }
                    // Gider varsa gider talebi oluştur


                    // sms var ise gönder
                    $code = $details->code;
                    if($details->surucu_sms_status){
                        $messages=$details->start_date.' Tarihi  ile '.$details->end_date.' Tarihi arasında '.$details->gorev_sebebi.' Sebebi ile size görev atanmisir.Lokasyon '.$details->lokasyon.' Talep Kodu : '.$code;
                        if($details->surucu_sms_text){
                            $messages=$details->start_date.' Tarihi  ile '.$details->end_date.' Tarihi arasında '.$details->gorev_sebebi.' Sebebi ile size görev atanmisir.Lokasyon '.$details->lokasyon.'.'.$details->surucu_sms_text.' Talep Kodu : '.$code;
                        }
                        $arac_details = $this->db->query("SELECT * From araclar Where id=$details->arac_id")->row();
                        $phone=personel_details_full($arac_details->active_surucu_id)['phone'];
                        $this->mesaj_gonder($phone,$messages);
                    }
                    // sms var ise gönder

                    // Bekleyen Sürücülere ekle
                    //$this->surucu_atama($talep_id);
                    // Bekleyen Sürücülere ekle
                }
            }
            else {
                //Onay İşlemi Tamalandı
                    $data_form=array('status'=>$status);
                    $this->db->where('id', $talep_id);
                    $this->db->set($data_form);
                    $this->db->update('arac_form',$data_form);
                //Onay İşlemi Tamalandı

            }

            $this->aauth->applog("Araç Talep Formu Durumu Güncellendi  : Talep ID : ".$talep_id, $this->aauth->get_user()->username);
            return ['status'=>1,'messages'=>'Başarıyla Durumunuz Güncellendi'];

        }
        else {
            return ['status'=>0,'messages'=>'Hata Aldınız Yöneticiye Başvurun'];
        }
    }

    //personel Gider Talep
    public function cost_item_update($data_product,$talep_id)
    {

        $product_list=[];
        $index=0;
        foreach ($data_product as $item){
            $product_id = $item['id'];
            $product_desc = $item['name'];
            $product_kullanim_yeri = '';
            $product_temin_date=date('Y-m-d');
            $progress_status_id = 1;
            $unit_id = $item['unit_id'];
            $product_qty = 1;
            $product_price =$item['tutar'];
            $form_id = $talep_id;


            $data_new_update = array(
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

            $product_list[$index]=$data_new_update;
            $this->model->talep_history($form_id,$this->aauth->get_user()->id,'Gider Eklendi : '.$product_desc.' | '.$product_qty.' '.units_($unit_id)['name']);
            $index++;

        }
        if ($index) {
            if ($this->db->insert_batch('talep_form_personel_products', $product_list)) {
                return [
                    'status'=>1,
                ];
            }
            return [
                'status'=>0,
                'id'=>0
            ];

        }
        else {
            return [
                'status'=>0,
                'id'=>0
            ];
        }

    }
    public function form_bildirim_olustur($id,$type){
        $this->db->trans_start();
        $user_id=$this->aauth->get_user()->id;
        if($type==1){
            $talep_kontrol  = $this->db->query("SELECT * FROM `talep_form_personel` where id=$id and aauth=$user_id")->num_rows();
            if($talep_kontrol){
                $details = $this->model->details($id);
                $data = array(
                    'bildirim_durumu' => 1,
                );
                $this->db->set($data);
                $this->db->where('id', $id);
                if ($this->db->update('talep_form_personel', $data)) {

                    $users_ =   onay_sort(3,$details->proje_id,$details->personel_id);
                    if($users_){
                        foreach ($users_ as $items){
                            $staff=0;
                            if($items['sort']==1){
                                // bildirim maili at
                                $mesaj=$details->code.' Numaralı Gider Talep Formu Onayınızı Beklemektedir';
                                $this->model->send_mail($items['user_id'],' Gider Talep Onayı',$mesaj);
                                // bildirim maili at
                                $staff=1;
                            }
                            $data_onay = array(
                                'talep_id' => $id,
                                'type' => $type,
                                'staff' => $staff,
                                'sort' => $items['sort'],
                                'user_id' => $items['user_id'],
                            );
                            $this->db->insert('talep_onay_personel_new', $data_onay);
                        }

                        $this->model->talep_history($id,$this->aauth->get_user()->id,'Onay İşlemi Başlatıldı');
                        $this->aauth->applog("Gider Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);
                        $this->db->trans_complete();


                    }
                    else {

                        $this->db->trans_rollback();

                    }



                }
                else {

                    $this->db->trans_rollback();

                }

            }
            else {
                $this->db->trans_rollback();

            }
        }


    }
    //personel Gider Talep



    public function update_save(){
        $talep_id = $this->input->post('talep_id');
        $details = $this->details();
        $details_step = $this->step_user_id_control($talep_id,$this->aauth->get_user()->id);

        if(!$details_step){
            if($details->bildirim_durumu){
                return ['status'=>0,'messages'=>'Onaya Sunulmuş Talepler Güncellenemez! Yazılım Ekibine Başvurunuz'];
            }
        }
        $lokasyon = $this->input->post('lokasyon');
        $gorev_sebebi = $this->input->post('gorev_sebebi');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $proje_muduru_id = $this->input->post('proje_muduru_id');
        $teknika_sorumlu_id = $this->input->post('teknika_sorumlu_id');
        $genel_mudur_id = $this->input->post('genel_mudur_id');
        $benzin_talebi = $this->input->post('benzin_talebi');
        $benzin_miktari = $this->input->post('benzin_miktari');
        $yemek_talebi = $this->input->post('yemek_talebi');
        $yemek_tutari = $this->input->post('yemek_tutari');
        $arac_id = $this->input->post('arac_id');
        $surucu_sms_text = $this->input->post('surucu_sms_text');
        $surucu_sms_status = $this->input->post('surucu_sms_status');
        $pers_id = $this->input->post('pers_id');
        $proje_id = $this->input->post('proje_id');
        $start_date = dateformat_local($start_date);
        $end_date = dateformat_local($end_date);

        $data_user=[$proje_muduru_id,$genel_mudur_id,$teknika_sorumlu_id];

        $data = array(
            'lokasyon' => $lokasyon,
            'arac_id' => $arac_id,
            'proje_id' => $proje_id,
            'gorev_sebebi' => $gorev_sebebi,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'benzin_talebi' => $benzin_talebi,
            'benzin_miktari' => $benzin_miktari,
            'yemek_talebi' => $yemek_talebi,
            'yemek_tutari' => $yemek_tutari,
            'surucu_sms_text' => $surucu_sms_text,
            'user_id' => $pers_id,
            'surucu_sms_status' => $surucu_sms_status,
            'status' => 0,
        );
            $this->db->set($data);
            $this->db->where('id', $talep_id);
        if ($this->db->update('arac_form', $data)) {

            if($details->bildirim_durumu==0){
                //delete step
                $this->db->delete('aracform_step', array('form_id' => $talep_id));
                //delete step

                //step table
                $i=0;
                foreach ($data_user as $user_id){
                    $step=0;
                    if($i==0){
                        $step=1;
                    }
                    $data_step = array(
                        'user_id' => $user_id,
                        'step' => $step,
                        'form_id' => $talep_id,
                    );
                    $this->db->insert('aracform_step', $data_step);
                    $i++;
                }
            }

            //step table
            $this->aauth->applog("Araç Talebi Güncellendi  : Talep ID : ".$talep_id, $this->aauth->get_user()->username);
            return ['status'=>1,'messages'=>'Başarıyla Talebiniz Güncellendi'];
        }
        else {
            return ['status'=>0,'messages'=>'Hata Aldınız Yöneticiye Başvurun'];
        }
    }

    public function bildirim_olustur(){
        $talep_id = $this->input->post('talep_id');
        $this->db->set('bildirim_durumu',1);
        $this->db->where('id', $talep_id);
        if($this->db->update('arac_form')){
            $this->aauth->applog("Araç Talep Bildirimi Oluşturuldu  : Talep ID : ".$talep_id, $this->aauth->get_user()->username);
            return 1;
        }
        else {
            return 0;
        }


    }

    public function iptal_et(){
        $talep_id = $this->input->post('talep_id');
        $desc = $this->input->post('desc');
        $this->db->set('status',2); // iptal
        $this->db->where('id', $talep_id);
        if($this->db->update('arac_form')){
            $this->aauth->applog("Araç Talep İptal Edildi Oluşturuldu  : Talep ID : ".$talep_id, $this->aauth->get_user()->username);
            return 1;
        }
        else {
            return 0;
        }


    }

    public function details(){
        $talep_id = $this->input->post('talep_id');
        $this->db->select('arac_form.*,araclar.name as arac_name,araclar.plaka');
        $this->db->from('arac_form');
        $this->db->join('araclar','arac_form.arac_id=araclar.id','Left');
        $this->db->where('arac_form.id',$talep_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function details_print($talep_id){
        $this->db->select('arac_form.*,araclar.name as arac_name');
        $this->db->from('arac_form');
        $this->db->join('araclar','arac_form.arac_id=araclar.id');
        $this->db->where('arac_form.id',$talep_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function step_user_id_control($talep_id,$user_id){
        $this->db->select('*');
        $this->db->from('aracform_step');
        $this->db->where('form_id',$talep_id);
        $this->db->where('user_id',$user_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function beklyenaracform(){
        $user_id = $this->aauth->get_user()->id;
        $this->db->select('aracform_step.*');
        $this->db->from('aracform_step');
        $this->db->join('arac_form','aracform_step.form_id=arac_form.id');
        $this->db->where('aracform_step.user_id',$user_id);
        $this->db->where('aracform_step.step',1);
        $this->db->where('arac_form.deleted_at is NULL');
        $this->db->where('aracform_step.status is NULL');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function users(){
        $talep_id = $this->input->post('talep_id');
        $this->db->select('*');
        $this->db->from('aracform_step');
        $this->db->where('aracform_step.form_id',$talep_id);
        $this->db->order_by('`aracform_step`.`id` ASC');
        $query = $this->db->get();
        return $query->result();
    }
    public function users_print($talep_id){
        $this->db->select('*');
        $this->db->from('aracform_step');
        $this->db->where('aracform_step.form_id',$talep_id);
        $this->db->order_by('`aracform_step`.`id` ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function arac_ekipmanlari($id){
        $this->db->select('ekipmanlar.*');
        $this->db->from('arac_ekipmanlari');
        $this->db->join('ekipmanlar','arac_ekipmanlari.ekipman_id=ekipmanlar.id');
        $this->db->where('arac_ekipmanlari.arac_id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function surucu_atama($talep_id){
        $details = $this->details_print($talep_id);

        $arac_details = $this->db->query("SELECT * FROM araclar Where id = $details->arac_id")->row();
        $this->db->set('status', 3,FALSE);
        $this->db->where('arac_id', $details->arac_id);
        $this->db->where('status', 2);
        $this->db->update('arac_suruculeri');

        $data=
            [
                'arac_id'=>$details->arac_id,
                'status'=>1,
                'user_id'=>$arac_details->active_surucu_id,
                'aauth_id'=>$this->aauth->get_user()->id,
                'talep_id'=>$talep_id,
            ];
        if ($this->db->insert('arac_suruculeri', $data)) {
            $this->aauth->applog("Araca Sürücü Ataması Yapıldı: Talep ID : ".$talep_id.' Araç ID : '.$details->arac_id, $this->aauth->get_user()->username);
        }
    }
    public function mesaj_gonder($proje_sorumlusu_no,$mesaj)
    {
        $result='';




        $tel=str_replace(" ","",$proje_sorumlusu_no);

        $domain="https://sms.atatexnologiya.az/bulksms/api";
        $operation='submit';
        $login='makro2000';
        $password="makro!sms";
        $title='MAKRO2000';
        $bulkmessage=$mesaj;
        $scheduled='now';
        $isbulk='true';
        $msisdn='994'.$tel;

        $cont_id=rand(1,999999999);



        $input_xml = "<?xml version='1.0' encoding='UTF-8'?>
               <request>
                <head>
                    <operation>$operation</operation>
                    <login>$login</login>
                    <password>$password</password>
                    <title>$title</title>
                    <bulkmessage>$bulkmessage</bulkmessage>
                    <scheduled>$scheduled</scheduled>
                    <isbulk>$isbulk</isbulk>
                    <controlid>$cont_id</controlid>
                </head>
                    <body>
                    <msisdn>$msisdn</msisdn>
                    </body>
                </request>";



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $domain);

        // For xml, change the content-type.
        curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

        // Send to remote and return data to caller.
        $result = curl_exec($ch);

        curl_close($ch);


        return 1;




    }
}
