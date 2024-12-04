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





class Hizmet_model extends CI_Model
{
    var $table_news = 'araclar ';

    var $column_order = array('talep_form.code', 'talep_form.desc', 'geopos_employees.name', 'progress_status.name','geopos_projects.code','talep_form_status.name');

    var $column_search = array('talep_form.code', 'talep_form.desc', 'geopos_employees.name', 'progress_status.name','geopos_projects.code','talep_form_status.name');

    var $column_search_notes = array('desc', 'created_at', 'geopos_employees.name');
    var $column_search_history = array('desc', 'created_at', 'geopos_employees.name');

    var $order = array('id' => 'DESC');


    public function __construct()
    {
        parent::__construct();

    }


    public function get_datatables_query_details_talep_list()

    {
        $this->_get_datatables_query_details_talep_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _get_datatables_query_details_talep_list()
    {

        $t_status  = $this->input->post('transfer_status');
        $this->db->select('talep_form.*,geopos_employees.name as pers_name,progress_status.name as progress_name,talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.sort_name as st_name');
        $this->db->from('talep_form');
        $this->db->join('geopos_employees','talep_form.talep_eden_user_id=geopos_employees.id');
        $this->db->join('progress_status','talep_form.progress_status_id=progress_status.id','LEFT');
        $this->db->join('geopos_projects','talep_form.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form.status=talep_form_status.id');
        $i = 0;
        if($this->input->post('status_id')!=0){
            $this->db->where('talep_form.status',$this->input->post('status_id'));
        }
        if($t_status!=-1){
            $this->db->where('talep_form.transfer_status',$this->input->post('transfer_status'));
        }

        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        $this->db->where('talep_form.talep_type',2);


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
        $this->db->order_by('`talep_form`.`id` DESC');

    }


    public function count_filtered_talep()
    {
        $this->_get_datatables_query_details_talep_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_talep()
    {
        $this->_get_datatables_query_details_talep_list();
        return $this->db->count_all_results();
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


        $this->db->select('talep_form_notes.*,geopos_employees.name as pers_name');
        $this->db->from('talep_form_notes');
        $this->db->join('geopos_employees','talep_form_notes.aaut_id=geopos_employees.id');
        $this->db->where('talep_form_notes.talep_id',$id);
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
        $this->db->order_by('`talep_form_notes`.`id` DESC');

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



    public function ajax_list_history($id)

    {
        $this->_ajax_list_history($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _ajax_list_history($id)

    {



        if($_SERVER['SERVER_NAME']=='localhost'){
            $table="talep_history";
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where('talep_id',$id);
        }
        else {
            $table="talep_history";
            if($id <= 3134){
                $table="talep_history_v1";
            }
            $this->db->select('*');
            $this->db->from($table);
            $this->db->where('talep_id',$id);
        }





        $i = 0;
        foreach ($this->column_search_history as $item) // loop column
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
        $this->db->order_by('id` DESC');

    }


    public function count_filtered_talep_history($id)
    {
        $this->_ajax_list_history($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_talep_history($id)
    {
        $this->_ajax_list_history($id);
        return $this->db->count_all_results();
    }



    public function create_save(){
        //$all_users = $this->input->post('all_users');
        $progress_status_id = $this->input->post('progress_status_id');
        $talep_eden_user_id = $this->input->post('talep_eden_user_id');
        $proje_id = $this->input->post('proje_id');
        $bolum_id = $this->input->post('bolum_id');
        $asama_id = $this->input->post('asama_id');
        $transfer_status = $this->input->post('transfer_status');
        $desc = $this->input->post('desc');
        $image_text = $this->input->post('image_text');
        $talep_type = $this->input->post('talep_type');
        $gider_durumu = $this->input->post('gider_durumu');
        $demirbas_id=0;
        $firma_demirbas_id=0;

        $gider_durumu=1;
        $demirbas_id = $this->input->post('demirbas_id');
        $firma_demirbas_id = $this->input->post('firma_demirbas_id');



        $talep_no = numaric(50);
        $data = array(
            'code' => $talep_no,
            'progress_status_id' => $progress_status_id,
            'talep_type' => $talep_type,
            'talep_eden_user_id' => $talep_eden_user_id,
            'bolum_id' => $bolum_id,
            'asama_id' => $asama_id,
            'proje_id' => $proje_id,
            'desc' => $desc,
            'transfer_status' => $transfer_status,
            'firma_demirbas_id' => $firma_demirbas_id,
            'demirbas_id' => $demirbas_id,
            'gider_durumu' => intval($gider_durumu),
            'aauth' => $this->aauth->get_user()->id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        if ($this->db->insert('talep_form', $data)) {
            $last_id = $this->db->insert_id();


            $this->db->set('deger', "deger+1",FALSE);
            $this->db->where('tip', 50);
            $this->db->update('numaric');

            if(time_day_get(1)){

                $data_time=
                    [
                        'mt_id'=>$last_id,
                        'status'=>1,
                        'start_time'=>n_gun_sonra(time_day_get(1))['start_date'],
                        'end_time'=>n_gun_sonra(time_day_get(1))['end_date'],

                    ];

                $this->db->insert('talep_time', $data_time);
            }




            //all_users
//            foreach ($all_users as $user_id){
//                $data_step = array(
//                    'user_id' => $user_id,
//                    'form_id' => $last_id,
//                );
//                $this->db->insert('talep_form_users', $data_step);
//            }
            //all_user
            //images
            $data_images = array(
                'image_text' => $image_text,
                'form_id' => $last_id,
            );
            $this->db->insert('talep_form_files', $data_images);
            //all_user

            $this->aauth->applog("Malzame Talebi Oluşturuldu  : Talep No : ".$talep_no, $this->aauth->get_user()->username);

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
        if ($this->db->insert('talep_form_notes', $data)) {
            $this->aauth->applog("Malzame Talebine Not Eklendi  : Talep No : ".$talep_no, $this->aauth->get_user()->username);

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


    public function transaction_create(){

        $talep_id = $this->input->post('talep_id');
        $cari_pers_type = $this->input->post('cari_pers_type');
        $account_id = $this->input->post('account_id');
        $proje_id_pay = $this->input->post('proje_id_pay');
        $pay_type = $this->input->post('pay_type');
        $method_id = $this->input->post('method_id');
        $para_birimi_id = $this->input->post('para_birimi_id');
        $kur_degeri = $this->input->post('kur_degeri');
        $notes = $this->input->post('notes');
        $cari_id = $this->input->post('cari_id');
        $talep_form_avans_id = $this->input->post('talep_form_avans_id');
        $amount = $this->input->post('amount');
        $talep_no = $this->details($talep_id)->code;
        $user_id= $this->aauth->get_user()->id;

        $data_insert = array(
            'csd' => $cari_id,
            'invoice_no'=>$talep_no,
            'payer' => customer_details($cari_id)['company'],
            'acid' => $account_id, //hesapID ekleneck
            'account' => account_details($account_id)->holder, //hesap adı ekelenecek
            'debit' => 0, // eklenecek
            'credit' => 0, //eklenecek
            'total' => $amount,
            'invoice_type_id'=>$pay_type,
            'invoice_type_desc'=>invoice_type_desc($pay_type),
            'method' => $method_id, //ödeme metodu ekelenecek
            'eid' => $user_id,
            'notes' => $notes,
            'loc' => $this->session->userdata('set_firma_id'),
            'para_birimi' => $para_birimi_id,
            'kur_degeri' => $kur_degeri,
            'masraf_id' => 0,
            'dosya_id'=>0,
            'ithalat_ihracat_tip'=>0,
            'proje_id'=>$proje_id_pay,
            'cari_pers_type'=>$cari_pers_type,
            'maas_ay'=>0,
            'maas_yil'=>0,
            'bolum_id'=>1

        );

        if ($this->db->insert('geopos_invoices', $data_insert)) {
            $invoice_id = $this->db->insert_id();
            $ret =  $this->transaction_add($invoice_id,1,$talep_id,$talep_form_avans_id);

            $data_update_avans=array(
                'status_id' => 5, //ödendi
            );
            $this->db->set($data_update_avans);
            $this->db->where('id', $talep_form_avans_id);
            $this->db->update('talep_form_avans', $data_update_avans);
            $this->talep_history($talep_id,$this->aauth->get_user()->id,'Malzame Talebine Ödeme Yapıldı.Cari Adı: '.customer_details($cari_id)['company'].' Tutar : '.amountFormat($amount,$para_birimi_id));
            $this->aauth->applog("Malzame Talebine Ödeme Tapıldı: Talep No : ".$talep_no, $this->aauth->get_user()->username);
            return [
                'status'=>1,
                'messages'=>'Başarılı Bir Şekilde Ödeme Yapıldı',
                'id'=>$talep_id
            ];
        }
        else {
            return [
                'status'=>0,
                'messages'=>'Hata Aldınız.Yöneticiye Başvurun',
                'id'=>0
            ];
        }
    }

    public function transaction_add($invoice_id,$tip,$form_id,$talep_form_avans_id){

        $data_insert = array(
            'form_id' => $form_id,
            'tip'=>$tip,
            'islem_id'=>$invoice_id,
            'talep_form_avans_id'=>$talep_form_avans_id,

        );
        return $this->db->insert('talep_form_transaction', $data_insert);
    }


    public function avans_create(){

        //$all_users = $this->input->post('all_users');
        $avans_details = $this->input->post('avans_details');
        $talep_id = $this->input->post('talep_id');
        $talep_details = $this->details($talep_id);
        $talep_no = $talep_details->code;
        $proje_id = $talep_details->proje_id;
        $i=0;
        $users_id = proje_yetkilileri($proje_id,4);
        $senet_sorgu =$this->db->query("SELECT * FROm talep_senet Where talep_id = $talep_id");
        if($senet_sorgu->num_rows()){
            if($senet_sorgu->row()->muqavele && $senet_sorgu->row()->razilastirma){
                if($avans_details) {
                    foreach ($avans_details as $items) {
                        $cari_name = customer_details($items['cari_id'])['company'];
                        $data = array(
                            'talep_form_teklifler_id' => $items['talep_form_teklifler_id'],
                            'talep_forn_teklifler_details_id' => $items['talep_form_teklifler_details_id'],
                            'cari_id' => $items['cari_id'],
                            'method_id' => $items['method_id'],
                            'para_birimi' => $items['para_birimi'],
                            'avans_price' => $items['avans_tutari'],
                            'total_price' => $items['toplam_tutar'],
                            'status_id' => 1, // Bekliyor
                            'type' => 1, //avans talebi
                            'talep_id' => $talep_id,
                            'aauth_id' => $this->aauth->get_user()->id
                        );
                        $this->db->insert('talep_form_avans', $data);
                        $last_id = $this->db->insert_id();
                        // staff tablosuna ekleme

                        $this->talep_form_avans_sort($last_id,$users_id,1);
                        $this->talep_history($talep_id,$this->aauth->get_user()->id,'Malzame Talebine Avans Talebi Eklendi.Cari Adı: '.$cari_name);
                        // staff tablosuna ekleme

                        //Avans Aşamasına alındı
                        $data_update=array(
                            'status' => 18
                        );
                        $this->db->set($data_update);
                        $this->db->where('id', $talep_id);
                        $this->db->update('talep_form', $data_update);
                        //Avans Aşamasına alındı

                        $this->aauth->applog("Malzame Talebine Avans Talebi Eklendi  : Talep No : " . $talep_no . ' Cari Adı : ' . $cari_name, $this->aauth->get_user()->username);
                        $i++;

                    }
                }

                if($i){

                    return [
                        'status'=>1,
                        'id'=>$talep_id,
                        'message'=>'Başarılı Bir Şekilde Talep Oluşturuldu'
                    ];
                }
                else {
                    return [
                        'status'=>0,
                        'id'=>0,
                        'message'=>'Hata Aldınız.Lütfen Yöneyiciye Başvurun'
                    ];
                }
            }
            else {
                return [
                    'status'=>0,
                    'id'=>0,
                    'message'=>'SENET İŞLEMLERİ EKSİK'
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'id'=>0,
                'message'=>'SENET İŞLEMLERİNİ TAMAMLAYINIZ'
            ];
        }

    }

    public function odeme_create(){
        //$all_users = $this->input->post('all_users');
        $avans_details = $this->input->post('avans_details');
        $talep_id = $this->input->post('talep_id');
        $talep_details = $this->details($talep_id);
        $talep_no = $talep_details->code;
        $proje_id = $talep_details->proje_id;
        $i=0;
        $users_id = proje_yetkilileri($proje_id,5);
        if($avans_details) {
            foreach ($avans_details as $items) {
                $cari_name = customer_details($items['cari_id'])['company'];
                $data = array(
                    'talep_form_teklifler_id' => $items['talep_form_teklifler_id'],
                    'talep_forn_teklifler_details_id' => $items['talep_form_teklifler_details_id'],
                    'cari_id' => $items['cari_id'],
                    'method_id' => $items['method_id'],
                    'para_birimi' => $items['para_birimi'],
                    'avans_price' => $items['avans_tutari'],
                    'total_price' => $items['toplam_tutar'],
                    'status_id' => 3, // Bekliyor
                    'type' => 2, //ödeme talebi
                    'talep_id' => $talep_id,
                    'aauth_id' => $this->aauth->get_user()->id
                );
                $this->db->insert('talep_form_avans', $data);
                $last_id = $this->db->insert_id();
                // staff tablosuna ekleme

                $this->talep_form_avans_sort($last_id,$users_id,2);
                $this->talep_history($talep_id,$this->aauth->get_user()->id,'Malzame Talebine Ödeme Talebi Eklendi.Cari Adı: '.$cari_name);
                // staff tablosuna ekleme

                //Ödeme Aşamasına alındı
                $data_update=array(
                    'status' => 20
                );
                $this->db->set($data_update);
                $this->db->where('id', $talep_id);
                $this->db->update('talep_form', $data_update);
                //Ödee Aşamasına alındı

                $this->aauth->applog("Malzame Talebine Ödeme Talebi Eklendi  : Talep No : " . $talep_no . ' Cari Adı : ' . $cari_name, $this->aauth->get_user()->username);
                $i++;

            }
        }

        if($i){

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

    public function avans_onay_iptal(){

        $form_id=$this->input->post('talep_id');
        $cari_id=$this->input->post('cari_id');
        $cari_name=customer_details($cari_id)['company'];
        $desc=$this->input->post('desc');
        $talep_form_avans_id=$this->input->post('talep_form_avans_id');
        $tip=$this->input->post('tip');
        $user_id= $this->aauth->get_user()->id;

        if($tip==1) // Onay Verildiyse
        {
            $sort_kontrol = $this->db->query("SELECT * FROM talep_form_avans_sort Where talep_form_avans_id = $talep_form_avans_id and staff_id=$user_id and status is null and type=1 and staff=1");
            if($sort_kontrol->num_rows()){
                $data_update=array(
                    'staff_status' => 2,
                    'status' => 2,
                    'staff' => 0,
                    'updated_at' => 'NOW()',
                );
                $this->db->set($data_update);
                $this->db->where('id', $sort_kontrol->row()->id);
                $this->db->update('talep_form_avans_sort', $data_update);

                $sort = floatval($sort_kontrol->row()->sort)+1;
                $staff_kontrol = $this->db->query("SELECT * FROM talep_form_avans_sort Where talep_form_avans_id = $talep_form_avans_id and staff_status=0 and type=1 and sort=$sort");
                $new_id=0;
                $new_user_id=0;
                $new_id_control = $this->db->query("SELECT * FROM `talep_form_avans_sort` Where type=1 and talep_form_avans_id = $talep_form_avans_id  and staff=0 and status is Null ORDER BY `talep_form_avans_sort`.`sort` ASC LIMIT 1");
                if($new_id_control->num_rows()){
                    $new_id = $new_id_control->row()->id;
                    //$new_user_id = $new_id_control->row()->user_id;

                    $this->db->set('staff',1);
                    $this->db->where('id',$new_id);
                    $this->db->update('talep_form_avans_sort');


                    $this->talep_history($form_id,$this->aauth->get_user()->id,'Avans Talebi Onaylandı : '.$cari_name);
                    return [
                        'status'=>1,
                        'message'=>'Başarıyla Onayınız Verilidi'
                    ];
                }
                else {


                    //Ödeme Aşamasına alındı
                    $data_update=array(
                        'status' => 19
                    );
                    $this->db->set($data_update);
                    $this->db->where('id', $form_id);
                    $this->db->update('talep_form', $data_update);
                    //Ödeme Aşamasına alındı


                    $data_update_avans=array(
                        'status_id' => 2
                    );
                    $this->db->set($data_update_avans);
                    $this->db->where('id', $talep_form_avans_id);
                    if($this->db->update('talep_form_avans', $data_update_avans)){
                        $this->talep_history($form_id,$this->aauth->get_user()->id,'Avans Talebi Onaylandı : '.$cari_name);
                        return [
                            'status'=>1,
                            'message'=>'Başarıyla Onayınız Verilidi'
                        ];
                    }
                    else {
                        return [
                            'status'=>0,
                            'message'=>'Güncelleme Olurken Hata Aldınız Yöneticiye Başvurun'
                        ];
                    }
                }
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Yetkiniz Bulunmamaktadır'
                ];
            }
        }
        else {
            $data_update=array(
                'status_id' => 6
            );
            $this->db->set($data_update);
            $this->db->where('id', $talep_form_avans_id);
            if($this->db->update('talep_form_avans', $data_update)){
                $this->talep_history($form_id,$this->aauth->get_user()->id,'Avans Talebi İptal Edildi : '.$cari_name.' Açıklama : '.$desc);

                return [
                    'status'=>1,
                    'message'=>'Başarıyla İptal Edildi'
                ];
            }


        }
    }

    public function odeme_onay_iptal(){
        $form_id=$this->input->post('talep_id');
        $cari_id=$this->input->post('cari_id');
        $cari_name=customer_details($cari_id)['company'];
        $desc=$this->input->post('desc');
        $talep_form_avans_id=$this->input->post('talep_form_avans_id');
        $muhasebe_id=$this->input->post('muhasebe_id');
        $tip=$this->input->post('tip');
        $user_id= $this->aauth->get_user()->id;

        if($tip==1) // Onay Verildiyse
        {
            $sort_kontrol = $this->db->query("SELECT * FROM talep_form_avans_sort Where talep_form_avans_id = $talep_form_avans_id and staff_id=$user_id and staff_status=0 and type=2");
            if($sort_kontrol->num_rows()){
                $data_update=array(
                    'staff_status' => 4,
                    'muhasebe_id' => $muhasebe_id,
                    'updated_at' => 'NOW()',
                );
                $this->db->set($data_update,false);
                $this->db->where('id', $sort_kontrol->row()->id);
                $this->db->update('talep_form_avans_sort', $data_update);
                $sort = floatval($sort_kontrol->row()->sort)+1;

                $staff_kontrol = $this->db->query("SELECT * FROM talep_form_avans_sort Where talep_form_avans_id = $talep_form_avans_id and staff_status=0 and type=2 and sort=$sort");

                $new_id=0;
                $new_user_id=0;
                $new_id_control = $this->db->query("SELECT * FROM `talep_form_avans_sort` Where type=2 and talep_form_avans_id = $talep_form_avans_id  and staff=0 and status is Null ORDER BY `talep_form_avans_sort`.`sort` ASC LIMIT 1");
                if($new_id_control->num_rows()){
                    $new_id = $new_id_control->row()->id;
                    //$new_user_id = $new_id_control->row()->user_id;

                    $this->db->set('staff',1);
                    $this->db->where('id',$new_id);
                    $this->db->update('talep_form_avans_sort');
                    $emp_name = personel_details_full($muhasebe_id)['name'];
                    $this->talep_history($form_id,$this->aauth->get_user()->id,'Ödeme Emri Verildi Ödeme Yapacak Personel : '.$emp_name.' Ödeme Yapılacak Cari : '.$cari_name);
                    return [
                        'status'=>1,
                        'message'=>'Başarıyla Onayınız Verilidi'
                    ];

                }
                else {

                    //Ödeme Emri alındı
                    $data_update=array(
                        'status' => 12
                    );
                    $this->db->set($data_update);
                    $this->db->where('id', $form_id);
                    $this->db->update('talep_form', $data_update);
                    //Ödeme Emri alındı



                    $data_update_avans=array(
                        'status_id' => 4
                    );
                    $this->db->set($data_update_avans);
                    $this->db->where('id', $talep_form_avans_id);
                    if($this->db->update('talep_form_avans', $data_update_avans)){
                        $emp_name = personel_details_full($muhasebe_id)['name'];
                        $this->talep_history($form_id,$this->aauth->get_user()->id,'Ödeme Emri Verildi Ödeme Yapacak Personel : '.$emp_name.' Ödeme Yapılacak Cari : '.$cari_name);
                        return [
                            'status'=>1,
                            'message'=>'Başarıyla Onayınız Verilidi'
                        ];
                    }
                }

//
//
//                if(!$staff_kontrol->num_rows()){
//                    // Son kişi
//                    $data_update_avans=array(
//                        'status_id' => 4
//                    );
//                    $this->db->set($data_update_avans);
//                    $this->db->where('id', $talep_form_avans_id);
//                    if($this->db->update('talep_form_avans', $data_update_avans)){
//                        $emp_name = personel_details_full($muhasebe_id)['name'];
//                        $this->talep_history($form_id,$this->aauth->get_user()->id,'Ödeme Emri Verildi Ödeme Yapacak Personel : '.$emp_name.' Ödeme Yapılacak Cari : '.$cari_name);
//                        return [
//                            'status'=>1,
//                            'message'=>'Başarıyla Onayınız Verilidi'
//                        ];
//                    }
//                    else {
//                        return [
//                            'status'=>0,
//                            'message'=>'Güncelleme Olurken Hata Aldınız Yöneticiye Başvurun'
//                        ];
//                    }
//                }
//                else {
//                    $this->talep_history($form_id,$this->aauth->get_user()->id,'Ödeme Talebi Onaylandı : '.$cari_name);
//                    return [
//                        'status'=>1,
//                        'message'=>'Başarıyla Onayınız Verilidi'
//                    ];
//                }
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Yetkiniz Bulunmamaktadır'
                ];
            }
        }
        else {
            $data_update=array(
                'status_id' => 6
            );
            $this->db->set($data_update);
            $this->db->where('id', $talep_form_avans_id);
            if($this->db->update('talep_form_avans', $data_update)){
                $this->talep_history($form_id,$this->aauth->get_user()->id,'Ödeme Talebi İptal Edildi : '.$cari_name.' Açıklama : '.$desc);

                return [
                    'status'=>1,
                    'message'=>'Başarıyla İptal Edildi'
                ];
            }


        }
    }

    public function talep_form_avans_sort($talep_form_avans_id,$users_id,$type){

        $product_list = [];
        $index = 0;
        foreach ($users_id as $user_id_items){

            $staff=0;
            if($user_id_items['sort']==1){

                $staff=1;
            }
            $data = array(
                'talep_form_avans_id' => $talep_form_avans_id,
                'staff_id' => $user_id_items['user_id'],
                'type' => $type,
                'staff' => $staff,
                'staff_status' => 0,
                'sort' => $user_id_items['sort']
            );

            $product_list[$index]=$data;
            $index++;
        }
        if($index){
            $this->db->insert_batch('talep_form_avans_sort', $product_list);
        }

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
        $form_id = $this->input->post('form_id');
        $product_temin_date=date('Y-m-d');


        $data = array(
            'product_id' => $product_id,
            'progress_status_id' => 1,
            'product_desc' => $product_desc,
            'product_kullanim_yeri' => '',
            'product_temin_date' => $product_temin_date,
            'unit_id' => $unit_id,
            'product_qty' => $product_qty,
            'form_id' => $form_id,
            'aauth' => $this->aauth->get_user()->id
        );
        if ($this->db->insert('talep_form_products', $data)) {
            $talep_form_products_id = $this->db->insert_id();

            $product_name= who_demirbas($product_id)->name;
            $unit_name = units_($unit_id)['name'];
            $this->talep_history($form_id,$this->aauth->get_user()->id,'Gider Eklendi : '.$product_name.' | '.$product_qty.' '.$unit_name);
            $last_id = $this->db->insert_id();
            $this->aauth->applog("Hizmet Talebine Ürünler Eklendi  : Talep ID : ".$form_id, $this->aauth->get_user()->username);

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

    public function create_form_items_gider(){


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
        $form_id = $this->input->post('form_id');
        $product_temin_date=date('Y-m-d');


        $data = array(
            'product_id' => $product_id,
            'progress_status_id' => 1,
            'product_desc' => $product_desc,
            'product_kullanim_yeri' => '',
            'product_temin_date' => $product_temin_date,
            'unit_id' => $unit_id,
            'product_qty' => $product_qty,
            'form_id' => $form_id,
            'aauth' => $this->aauth->get_user()->id
        );
        if ($this->db->insert('talep_form_products', $data)) {
            $talep_form_products_id = $this->db->insert_id();

            $product_name= who_demirbas($product_id)->name;
            $unit_name = units_($unit_id)['name'];
            $this->talep_history($form_id,$this->aauth->get_user()->id,'Gider Eklendi : '.$product_name.' | '.$product_qty.' '.$unit_name);
            $last_id = $this->db->insert_id();
            $this->aauth->applog("Hizmet Talebine Ürünler Eklendi  : Talep ID : ".$form_id, $this->aauth->get_user()->username);

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




    public function form_cari_list_create(){
        $item_id = $this->input->post('item_id');
        $form_id = $this->input->post('form_id');
        $cari_id = $this->input->post('cari_id');
        $prodindex=0;
        $productlist=[];

        $cari_kontrol = $this->db->query("SELECT * FROM talep_form_cari Where talep_id = $form_id and cari_id=$cari_id")->num_rows();
        if($cari_kontrol){
            return [
                'status'=>0,
                'messages'=>"Daha Önce Atanmış Cari!",
                'id'=>0
            ];
        }
        else {
            foreach ($item_id as $items){
                $data = array(
                    'item_id' => $items,
                    'cari_id' => $cari_id,
                    'talep_id' => $form_id,
                    'aauth' => $this->aauth->get_user()->id
                );

                $productlist[$prodindex] = $data;
                $prodindex++;
            }

            if ($this->db->insert_batch('talep_form_cari', $productlist)) {
                $this->aauth->applog("Malzeme Talebine Cariler Eklendi  : Talep ID : ".$form_id, $this->aauth->get_user()->username);

                $data_update=array(
                    'status' => 3
                );
                $this->db->set($data_update);
                $this->db->where('id', $form_id);
                $this->db->update('talep_form', $data_update);

                $this->talep_history($form_id,$this->aauth->get_user()->id,customer_details($cari_id)['company'].' Carisi Talebe Atandı');

                return [
                    'status'=>1,
                    'cari_id'=>$cari_id,
                    'messages'=>"Başarılı Bir Şekilde Eklendi",
                    'cari_name'=>customer_details($cari_id)['company'],
                    'cari_phone'=>customer_details($cari_id)['phone'],
                ];
            }
            else {
                return [
                    'status'=>0,
                    'messages'=>"Hata Oluştu!",
                    'id'=>0
                ];
            }
        }

    }

    public function product_price_details_add(){
        $item_id = $this->input->post('item_id');
        $talep_id = $this->input->post('talep_id');
        $price = $this->input->post('price');

        $product_id = $this->db->query("SELECT * FROM talep_form_products Where id = $item_id")->row()->product_id;

        $data = array(
            'price' => $price,
            'talep_id' => $talep_id,
            'item_id' => $item_id,
            'product_id' => $product_id,
            'user_id' => $this->aauth->get_user()->id
        );
        if ($this->db->insert('product_price_details', $data)) {
            $last_id = $this->db->insert_id();
            $options = talep_form_product_options_teklif_values($item_id);
            if($options){
                foreach ($options as $options_details){
                    $data_options = array(
                        'product_price_id' => $last_id,
                        'option_id' => option_sort($options_details['option_id']),
                        'option_value_id' => option_sort($options_details['option_value_id']),
                    );
                    $this->db->insert('product_price_options', $data_options);
                }
            }
            $this->aauth->applog("Malzeme Talebindeki Ürüne tahmini fiyat eklendi  : ITEM ID : ".$item_id, $this->aauth->get_user()->username);

            return [
                'status'=>1,
                'id'=>$last_id,
            ];
        }
        else {
            return [
                'status'=>0,
                'id'=>0
            ];
        }
    }

    public function product_price_details_add_func($item_id,$talep_id,$price){

        $product_id = $this->db->query("SELECT * FROM talep_form_products Where id = $item_id")->row()->product_id;

        $data = array(
            'price' => $price,
            'talep_id' => $talep_id,
            'item_id' => $item_id,
            'product_id' => $product_id,
            'user_id' => $this->aauth->get_user()->id
        );
        if ($this->db->insert('product_price_details', $data)) {
            $last_id = $this->db->insert_id();
            $options = talep_form_product_options_teklif_values($item_id);
            if($options){
                $options_id='';
                $option_value_id='';
                $i=0;
//                foreach ($options as $options_details){
//
//                    if ($i === array_key_last($options)) {// first loop
//                        $options_id.=$options_details['option_id'];
//                        $option_value_id.=$options_details['option_value_id'];
//                    }
//                    else {
//                        $options_id.=$options_details['option_id'].',';
//                        $option_value_id.=$options_details['option_value_id'].',';
//                    }
//                    $i++;
//                }
//                $data_options = array(
//                    'product_price_id' => $last_id,
//                    'option_id' => option_sort($options_id),
//                    'option_value_id' => option_sort($option_value_id),
//                );

                $data_options = array(
                    'product_price_id' => $last_id,
                    'product_stock_code_id' => $options
                );
                $this->db->insert('product_price_options', $data_options);
            }
            $this->aauth->applog("Malzeme Talebindeki Ürüne Son fiyat eklendi  : ITEM ID : ".$item_id, $this->aauth->get_user()->username);

            return [
                'status'=>1,
                'id'=>$last_id,
            ];
        }
        else {
            return [
                'status'=>0,
                'id'=>0
            ];
        }
    }

    public function status_upda(){
        $status = $this->input->post('status');
        $file_id = $this->input->post('file_id');

        $new_status = $status;
        $details_ = $this->talep->details($file_id);
        $now_status = $details_->status;
        if($status < 0){
            $now_status = $details_->iptal_status;
            $new_status = $now_status;
        }

        $data = array(
            'status' => $new_status,
        );
        $this->db->set($data);
        $this->db->where('id', $file_id);
        if ($this->db->update('talep_form', $data)) {

            if($new_status==10) // İptal ise Qaime var ise iptal et ve stok hareketlerini iptal et
            {

                $data_iptal = array(
                    'iptal_status' => $now_status,
                );
                $this->db->set($data_iptal);
                $this->db->where('id', $file_id);
                $this->db->update('talep_form', $data_iptal);


                $query2 = $this->db->query("SELECT * FROM `talep_to_invoice` Where talep_id=$file_id");
                if($query2->num_rows()){
                    foreach ($query2->result() as $items){
                        $invoice_id = $items->invoice_id;
                        $data_invoice_update = array(
                            'status' => 3,
                        );
                        $this->db->set($data_invoice_update);
                        $this->db->where('id', $invoice_id);
                        $this->db->update('geopos_invoices', $data_invoice_update);

                    }
                }

                $stock_kontrol = $this->db->query("SELECT * FROM `stock` Where form_type = 1 and mt_id=$file_id");
                if($stock_kontrol->num_rows()){
                    foreach ($stock_kontrol->result() as $items){
                        stock_update_new($items->product_id,$items->unit,$items->qty,0,$items->warehouse_id,$this->aauth->get_user()->id,$file_id,1);

                    }
                }

                $desc = $this->input->post('desc');
                $this->db->delete('firma_gider', array('talep_id' => $file_id,'type'=>3));
                $this->talep_history($file_id,$this->aauth->get_user()->id,'Talep İptal Edildi.Açıklama : '.$desc);

            }
            if($status < 0){
                $query2 = $this->db->query("SELECT * FROM `talep_to_invoice` Where talep_id=$file_id");
                if($query2->num_rows()){
                    foreach ($query2->result() as $items){
                        $invoice_id = $items->invoice_id;
                        $data_invoice_update = array(
                            'status' => 1,
                        );
                        $this->db->set($data_invoice_update);
                        $this->db->where('id', $invoice_id);
                        $this->db->update('geopos_invoices', $data_invoice_update);

                    }
                }
                $desc = $this->input->post('desc');
                $this->talep_history($file_id,$this->aauth->get_user()->id,'Talep İptal Aşamasından Geri Alındı.Açıklama : '.$desc);
            }
            $this->aauth->applog("Malzame Talebi Güncellendi  : Talep No : ".$desc, $this->aauth->get_user()->username);
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

    public function update_form(){
        // $all_users = $this->input->post('all_users');
        $progress_status_id = $this->input->post('progress_status_id');
        $talep_eden_user_id = $this->input->post('talep_eden_user_id');
        $proje_id = $this->input->post('proje_id');
        $transfer_status = $this->input->post('transfer_status');
        $bolum_id = $this->input->post('bolum_id');
        $asama_id = $this->input->post('asama_id');
        $desc = $this->input->post('desc');
        $file_id = $this->input->post('file_id');
        $talep_type = $this->input->post('talep_type');
        $gider_durumu = $this->input->post('gider_durumu');

        $data = array(
            'progress_status_id' => $progress_status_id,
            'talep_eden_user_id' => $talep_eden_user_id,
            'proje_id' => $proje_id,
            'talep_type' => $talep_type,
            'transfer_status' => $transfer_status,
            'gider_durumu' => intval($gider_durumu),
            'bolum_id' => $bolum_id,
            'asama_id' => $asama_id,
            'desc' => $desc,
            'aauth' => $this->aauth->get_user()->id
        );
        $this->db->set($data);
        $this->db->where('id', $file_id);
        if ($this->db->update('talep_form', $data)) {
            //all_users

//            if($this->db->delete('talep_form_users', array('form_id' => $file_id))){
//            foreach ($all_users as $user_id){
//                $data_step = array(
//                    'user_id' => $user_id,
//                    'form_id' => $file_id,
//                );
//                $this->db->insert('talep_form_users', $data_step);
//            }
//            //all_user


            $this->aauth->applog("Malzame Talebi Güncellendi  : Talep No : ".$file_id, $this->aauth->get_user()->username);
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

    public function details($id){
        $this->db->select('*');
        $this->db->from('talep_form');
        $this->db->where('talep_form.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function details_items($id){
        $this->db->select('*');
        $this->db->from('talep_form_products');
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        return $query->result();
    }
    public function ihale_time($id){
        $this->db->select('*');
        $this->db->from('teklif_counter');
        $this->db->where('talep_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    public function teklif_details($id){
        $this->db->select('*');
        $this->db->from('talep_form_teklifler');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    public function teklif_details_items($id){
        $this->db->select('*');
        $this->db->from('talep_form_teklifler_details');
        $this->db->where('tf_teklif_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    public function talep_user_satinalma($id){
        $this->db->select('*');
        $this->db->from('talep_user_satinalma');
        $this->db->where('talep_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    public function product_details($id){
        $talep_type = $this->details($id)->talep_type;
        $this->db->select('talep_form_products.*,demirbas_group.name as product_name,geopos_units.name as unit_name');
        $this->db->from('talep_form_products');
        $this->db->join('demirbas_group','talep_form_products.product_id=demirbas_group.id');
        $this->db->join('geopos_units','talep_form_products.unit_id=geopos_units.id','LEFT');
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        return $query->result();
        $this->db->select('talep_form_products.*,geopos_products.product_name,geopos_units.name as unit_name');
        $this->db->from('talep_form_products');
        $this->db->join('geopos_products','talep_form_products.product_id=geopos_products.pid');
        $this->db->join('geopos_units','talep_form_products.unit_id=geopos_units.id');
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function file_details($id){
        $this->db->select('*');
        $this->db->from('talep_form_files');
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function talep_form_users($id){
        $this->db->select('*,geopos_employees.name');
        $this->db->from('talep_form_users');
        $this->db->join('geopos_employees','talep_form_users.user_id=geopos_employees.id','lEFT');
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        return $query->result();
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

        $this->db->select('araclar.*,geopos_customers.company as company');
        $this->db->from('araclar');

        $this->db->join('geopos_customers','araclar.firma_id=geopos_customers.id','lEFT');
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
        $this->db->order_by('`araclar`.`id` DESC');

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



    public function arac_ekipmanlari($id){
        $this->db->select('ekipmanlar.*');
        $this->db->from('arac_ekipmanlari');
        $this->db->join('ekipmanlar','arac_ekipmanlari.ekipman_id=ekipmanlar.id');
        $this->db->where('arac_ekipmanlari.arac_id',$id);
        $query = $this->db->get();
        return $query->result();
    }
    public function ekipmanlar(){
        $this->db->select('*');
        $this->db->from('ekipmanlar');
        $query = $this->db->get();
        return $query->result();
    }


    public function arac_bakimlari($id){
        $this->db->select('arac_bakimlari.*');
        $this->db->from('arac_bakimlari');
        $this->db->join('bakimlar','arac_bakimlari.bakim_id=bakimlar.id');
        $this->db->where('arac_bakimlari.arac_id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function bakimlar(){
        $this->db->select('*');
        $this->db->from('bakimlar');
        $query = $this->db->get();
        return $query->result();
    }

    public function arac_icazeleri($id){
        $this->db->select('arac_icazeleri.*');
        $this->db->from('arac_icazeleri');
        $this->db->join('icazeler','arac_icazeleri.icaze_id=icazeler.id');
        $this->db->where('arac_icazeleri.arac_id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function trafik_cezalari(){
        $this->db->select('*');
        $this->db->from('trafil_cezalari');
        $query = $this->db->get();
        return $query->result();
    }

    public function arac_cezalari($id){
        $this->db->select('arac_cezalari.*');
        $this->db->from('arac_cezalari');
        $this->db->join('trafil_cezalari','arac_cezalari.ceza_id=trafil_cezalari.id');
        $this->db->where('arac_cezalari.arac_id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function icazeler(){
        $this->db->select('*');
        $this->db->from('icazeler');
        $query = $this->db->get();
        return $query->result();
    }

    public function mk_list(){
        $this->db->select('araclar.*');
        $this->db->from('araclar');
        $this->db->where('araclar.kiralik_demirbas',3);
        $query = $this->db->get();
        return $query->result();
    }
    public function arac_oil($id){
        $this->db->select('*');
        $this->db->from('arac_benzin_kart');
        $this->db->where('arac_benzin_kart.arac_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    public function pedding_driver($id){
        $this->db->select('*');
        $this->db->from('arac_suruculeri');
        $this->db->where('arac_id',$id);
        $this->db->where('status',1);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function talep_form_teklif_cari_details($id){
        $this->db->select('talep_form_cari.*,geopos_customers.company');
        $this->db->from('talep_form_cari');
        $this->db->join('geopos_customers','geopos_customers.id=talep_form_cari.cari_id');
        $this->db->where('talep_form_cari.talep_id',$id);
        $this->db->group_by('talep_form_cari.cari_id');
        $query = $this->db->get();
        return $query->result();
    }


    public function talep_history($id,$user_id,$desc){

        $data_step = array(
            'talep_id' => $id,
            'user_id' => $user_id,
            'desc' => $desc,
        );
        $this->db->insert('talep_history', $data_step);
    }
    public function transfer_bildirimi(){
        date_default_timezone_set('Asia/Baku');
        $talep_id = $this->input->post('talep_id');
        $data_item_update = [
            'transfer_bildirim'=>1
        ];
        $this->db->where('id',$talep_id);
        $this->db->set($data_item_update);
        if($this->db->update('talep_form', $data_item_update)){
            $this->talep_history($talep_id,$this->aauth->get_user()->id,'Transfer İşlemi Başlatıldı');

            //stok transfer fişi oluşturma
            $transfer = $this->stoktransfer_olustur($talep_id);
            return [
                'status'=>$transfer['status'],
                'message'=>$transfer['message']
            ];
            //stok transfer fişi oluşturma


        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }
    }
    public function transfer_status_change(){
        date_default_timezone_set('Asia/Baku');
        $talep_id = $this->input->post('talep_id');
        $data_item_update = [
            'transfer_status'=>2
        ];
        $this->db->where('id',$talep_id);
        $this->db->set($data_item_update);
        if($this->db->update('talep_form', $data_item_update)){
            $this->talep_history($talep_id,$this->aauth->get_user()->id,'Transfer İşlemi Tamamlandı');

            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Bildirim Oluşturuldu'
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }
    }

    public function mt_cari_update(){
        $product_details = $this->input->post('product_details');
        $talep_id = $this->input->post('talep_id');
        $kontrol=false;
        foreach ($product_details as $prd){
            $new_firma_id=$prd['old_cari'];
            if($prd['firma_id']){
                $new_firma_id =$prd['firma_id'];
                $old_cari_name = customer_details($prd['old_cari'])['company'];
                $new_cari_name = customer_details($prd['firma_id'])['company'];

                $this->talep_history($talep_id,$this->aauth->get_user()->id,'Cari Değiştirildi. Eski Cari : '.$old_cari_name.' Yeni Cari Adı : '.$new_cari_name);

            }
            try {

                $kontrol=false;
                $data_item_update = [
                    'cari_id'=>$new_firma_id
                ];
                $this->db->where('cari_id',$prd['old_cari']);
                $this->db->where('talep_id',$talep_id);
                $this->db->set($data_item_update);
                $this->db->update('talep_form_cari', $data_item_update);

                // teklif_id
                $old_cari=$prd['old_cari'];
                $teklif_id = $this->db->query("SELECT * FROM talep_form_teklifler Where form_id=$talep_id and cari_id = $old_cari");
                // teklif_id

                $this->db->where('cari_id',$prd['old_cari']);
                $this->db->where('form_id',$talep_id);
                $this->db->set($data_item_update);
                $this->db->update('talep_form_teklifler', $data_item_update);
                if($teklif_id->num_rows()){
                    $data_item_update = [
                        'cari_id'=>$new_firma_id
                    ];
                    $this->db->where('teklif_id',$teklif_id->row()->id);
                    $this->db->set($data_item_update);
                    $this->db->update('talep_form_teklif_cari_details', $data_item_update);


                }

                $this->db->where('cari_id',$prd['old_cari']);
                $this->db->where('form_id',$talep_id);
                $this->db->set($data_item_update);
                $this->db->update('warehouse_teslimat', $data_item_update);

                $data_item_update = [
                    'cari_id'=>$new_firma_id
                ];
                $this->db->where('cari_id',$prd['old_cari']);
                $this->db->where('talep_id',$talep_id);
                $this->db->set($data_item_update);
                $this->db->update('siparis_list_form', $data_item_update);


                //sened
                $data_item_update = [
                    'cari_id'=>$new_firma_id
                ];
                $this->db->where('cari_id',$prd['old_cari']);
                $this->db->where('talep_id',$talep_id);
                $this->db->set($data_item_update);
                $this->db->update('talep_senet', $data_item_update);
                //
            } catch (PhpParser\Error $error) {
                $kontrol=true;
                exit();
            }


        }
        if($kontrol){
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];

        }
        else{
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Bildirim Oluşturuldu'
            ];
        }

    }

    public function stoktransfer_olustur($talep_id){
        $code = numaric(25);
        $details = $this->details($talep_id);
        $out_warehouse = $details->warehouse_id;
        $in_warehouse = $details->transfer_warehouse_id;
        $product_details=$this->db->query("SELECT * FROM stock LEFT JOIN stock_to_options ON stock.id = stock_to_options.stock_id Where stock.mt_id=$talep_id and stock.form_type =1 and qty>0");
        if($product_details->num_rows()){
            $data = array(
                'code' => $code,
                'out_warehouse_id' => $out_warehouse,
                'bildirim_durumu' => 1,
                'in_warehouse_id' => $in_warehouse,
                'loc' =>  $this->session->userdata('set_firma_id'),
                'aauth_id' => $this->aauth->get_user()->id
            );
            if ($this->db->insert('stock_transfer', $data)) {
                $last_id = $this->db->insert_id();
                $this->db->set('deger', "deger+1",FALSE);
                $this->db->where('tip', 25);
                $this->db->update('numaric');
                $product_list=[];
                $index=0;
                foreach ($product_details->result() as $items){

                    $options_id='';
                    $value_id='';
                    $i=0;
                    $data_item_insert = [
                        'stock_transfer_id'=>$last_id,
                        'unit_id'=>$items->unit,
                        'qty'=>$items->qty,
                        'product_id'=>$items->product_id,
                        'desc'=>$details->code.' İstinaden Transfer Talebi',
                        'option_id' => $items->option_id,
                        'option_value_id'=> $items->option_value_id,

                    ];
                    $product_list[$index]=$data_item_insert;
                    $index++;
                }
                $this->db->insert_batch('stock_transfer_items', $product_list);
                if($index){


                    $this->stocktransfer_bildirim_olustur($last_id);
                    $this->aauth->applog("Stok Transfer Talebi Yapıldı ".$code, $this->aauth->get_user()->username);
                    return [
                        'status'=>1,
                        'message'=>'Başarıyla Stok Transfer Talebiniz Oluşutuldu. Stok Transfer Bildirimlerimlerinizden Onaylama Yapınız'
                    ];

                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız. Yöneticiye Başvurun'
                    ];
                }

            }
        }
        else{
            return [
                'status'=>0,
                'message'=>'İlk Depoya Ürünler Giriş Yapmadığından Transfer İşlemi Başlatılamaz'
            ];
        }



    }

    public function stocktransfer_bildirim_olustur($stock_id){
        $talep_id =$stock_id;
        $this->db->set('bildirim_durumu',1);
        $this->db->where('id', $talep_id);
        if($this->db->update('stock_transfer')){
            $this->aauth->applog("Stok Transfer Talep Bildirimi Oluşturuldu  : Talep ID : ".$talep_id, $this->aauth->get_user()->username);

            // Mail ile Bildirime
            $transfer_id = $stock_id;
            $details = $this->stock_transfer_details($transfer_id);
            $cikis_depo_details = warehouse_details($details->out_warehouse_id);
            $giris_depo_details = warehouse_details($details->in_warehouse_id);
            $cikis_depo=$cikis_depo_details->title;
            $giris_depo=$giris_depo_details->title;

            $staff_id_cikis =  $cikis_depo_details->pers_id;
            $staff_id_giris =  $giris_depo_details->pers_id;
            if($staff_id_cikis==0 || $staff_id_giris==0){
                $depo_message='';
                if($staff_id_cikis==0){
                    $depo_message= 'Seçilen Çıkış Deposunun Sorumlu Personeli Mevcut değildir';
                }
                else if($staff_id_giris==0){
                    $depo_message= 'Seçilen Giriş Deposunun Sorumlu Personeli Mevcut değildir';
                }
                return [
                    'status'=>410,
                    'message'=>$depo_message
                ];
            }
            else
            {
                //first out warehouse
                $this->send_mail($staff_id_cikis,'Mahsul Çıxış Talebi','Yeni Bir Çıkış Talebi Oluşturuldu İncelemek İçin Bildirimler Bölümüne Bakınız');
                //first out warehous
                $result = $this->stock_transfer_notification_create($transfer_id,1,0,0,$staff_id_cikis,1);
                if($result['status']){
                    //giriş için kayıt
                    $response = $this->stock_transfer_notification_create($transfer_id,2,0,0,$staff_id_giris);
                    //giriş için kayıt

                    return [
                        'status'=>200,
                        'message'=>"Başarılı Bir Şekilde Stok Bildirimi Oluşturuldu"
                    ];

                }
                else {
                    return [
                        'status'=>410,
                        'message'=>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."
                    ];
                }
            }

            // Mail ile Bildirime
        }
        else {
            return [
                'status'=>410,
                'message'=>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."
            ];
        }
    }

    public function stock_transfer_details($transfer_id){
        $this->db->select('*');
        $this->db->from('stock_transfer');
        $this->db->where('id',$transfer_id);
        $query = $this->db->get();
        return $query->row();
    }
    public function stock_transfer_details_item($transfer_id){
        $this->db->select('*');
        $this->db->from('stock_transfer_items');
        $this->db->where('stock_transfer_id',$transfer_id);
        $query = $this->db->get();
        return $query->result();
    }
    public function stock_transfer_notification_create($stock_id,$type,$new_qty=0,$status=0,$staff_id,$staff_status=null)
    {
        $item_details = $this->stock_transfer_details_item($stock_id);
        $details = $this->stock_transfer_details($stock_id);
        $product_list=[];
        $i=0;
        foreach ($item_details as $value){
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
            $product_list[$i]=$data;
            $i++;
        }

        if($i){
            $this->db->insert_batch('stock_transfer_item_notification', $product_list);
            $this->aauth->applog("Stok Bildirimi OLuşturuldu  ".$details->code, $this->aauth->get_user()->username);
            return [
                'status'=>1,
                'id'=>$stock_id
            ];

        }
        else {
            return [
                'status'=>0,
                'id'=>0
            ];
        }
    }
    public function send_mail($user_id,$subject,$message){

        $message .= "<br><br><br><br>";
        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
        $proje_sorumlusu_email = personel_detailsa($user_id)['email'];
        //$recipients = array($proje_sorumlusu_email);
        //$this->communication_model->onay_mail($recipients, $subject, $message, false,'', 'gider_talep_onay_maili');
        $config=[
            'protocol'=>'smtp',
            'smtp_host'=>'ssl://smtp.yandex.com',
            'smtp_port'=>465,
            'smtp_user'=>'Makro2000 ERP',
            'smtp_pass'=>'bulut220618',
            'mailtype'=>'html',
            'charset'=>'iso-8859-1',
            'wordwrap'=>true,
        ];
        $this->load->library('Email',$config);
        $message .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


        $this->email->from('info@makropro.az');
        $this->email->to($proje_sorumlusu_email);
        $this->email->subject($subject);
        $this->email->message($message);

        if( $this->email->send()){
            return true;
        }
        else {
            return false;
        }



//        include_once APPPATH . '/libraries/PHPMailer/vendor/autoload.php';
//        $alt_body = "\n\n\n\n\n";
//        $alt_body .= '\n<h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
// <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
//              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
//
//        //Create a new PHPMailer instance
//        $mail = new PHPMailer;
//        $mail->CharSet = "UTF-8";
//
//        $mail->isSMTP();
//        $mail->SMTPDebug = 0;
//        $mail->Debugoutput = 'html';
//        $mail->Host ='ssl://smtp.yandex.com';
//        $mail->Port = 465;
//        $mail->SMTPAuth = true;
//        if($auth_type!='none') { $mail->SMTPSecure = $auth_type; }
//
//        $mail->Username = 'Makro2000 ERP';
//        $mail->Password = 'bulut220618';
//        $mail->setFrom('info@makropro.az', 'Makro2000 ERP');
//        $mail->addAddress($proje_sorumlusu_email, 'Makro2000 ERP');
//        $mail->Subject = $subject;
//        $mail->IsHTML(true);
//        $mail->msgHTML(html_entity_decode($message.$alt_body));
//
//        if (!$mail->send()) {
//            return false;
//        } else {
//            return true;
//        }


    }


    public function talep_pay(){

        $form_id = $this->input->post('talep_id');
        $islem_id = $this->input->post('transaction_id');
        $cari_id = $this->input->post('cari_id_pay');

        if($this->transaction_add($islem_id,1,$form_id,0)){
            return [
                'status'=>1,
                'message'=>"Başarılı Bir Şekilde Ödeme Eklendi"
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>"Hata Aldınız"
            ];
        }

    }

    public function invoice_pay_mt(){

        $mt_id = $this->input->post('mt_id');
        $aciklama = $this->input->post('aciklama');
        $pay_id = $this->input->post('pay_id');
        $kontrol = $this->db->query("SELECT * FROM talep_form_transaction Where form_id=$mt_id and islem_id=$pay_id and tip=1")->num_rows();
        if(!$kontrol){
            $data_insert = array(
                'form_id' => $mt_id,
                'tip'=>1,
                'islem_id'=>$pay_id,
                'talep_form_avans_id'=>0,

            );

            if($this->db->insert('talep_form_transaction', $data_insert)){
                $this->talep_history($mt_id,$this->aauth->get_user()->id,'Malzame Talebine Ödeme Eklendi.Açıklama: '.$aciklama);

                return [
                    'status'=>1,
                    'message'=>"Başarılı Bir Şekilde Ödeme Eklendi"
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>"Hata Aldınız"
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>"Daha Önceden Bu MT ye bu Ödeme Bağlanmıştır"
            ];
        }


    }


    public function get_datatables_query_details_talep_all_list($iptal_id)

    {
        $user_id = $this->aauth->get_user()->id;
        $this->_get_datatables_query_details_talep_all_list($iptal_id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
//        if($user_id==21){
//                    $query=$query->result();
//        echo $this->db->last_query();
//        }




        return $query->result();

    }

    public function tirnak_replace ($par)
    {
        return  str_replace(
            array("'", ""),
            array("\"", ""),
            $par
        );


    }

    private function _get_datatables_query_details_talep_all_list($iptal_id)
    {

        $user_id = $this->aauth->get_user()->id;
        $array_default=[1,2,3,4,5,6,7,8,12,10,13,14,15,16,17,18,19,20,21];



        $t_status  = $this->input->post('transfer_status');
        $this->db->select('talep_form.*,geopos_employees.name as pers_name,progress_status.name as progress_name,talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.sort_name as st_name');
        $this->db->from('talep_form');
        $this->db->join('geopos_employees','talep_form.talep_eden_user_id=geopos_employees.id');
        $this->db->join('progress_status','talep_form.progress_status_id=progress_status.id','LEFT');
        $this->db->join('geopos_projects','talep_form.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form.status=talep_form_status.id');
        $this->db->where_in('talep_form.status',$array_default);




        $i = 0;
        if($t_status!=-1){
            $this->db->where('talep_form.transfer_status',$this->input->post('transfer_status'));
        }

        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }


        $this->db->group_start();
        $this->db->where('talep_form.talep_eden_user_id',$user_id);
        $this->db->or_where('talep_form.aauth',$user_id);
        $this->db->group_end();


        if($iptal_id){
            $iptal_id_ = array_unique($iptal_id);

            $this->db->where_not_in("talep_form.id",$iptal_id_,FALSE);
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
        $this->db->order_by('`talep_form`.`id` DESC');

    }


    public function count_filtered_talep_all_list($iptal_id)
    {
        $this->_get_datatables_query_details_talep_all_list($iptal_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_talep_all_list($iptal_id)
    {
        $this->_get_datatables_query_details_talep_all_list($iptal_id);
        return $this->db->count_all_results();
    }
    public function stok_kontrol_list()
    {

        $where_talep_form='';
        if($this->session->userdata('set_firma_id')){
            $where_talep_form.='and talep_form.loc='.$this->session->userdata('set_firma_id');
        }
        $aauth_id = $this->aauth->get_user()->id;
        $count = $this->db->query("SELECT * FROM `talep_onay_new` 
INNER JOIN talep_form On talep_onay_new.talep_id=talep_form.id
WHERE talep_onay_new.type = 3 AND  talep_form.status=17 and talep_form.talep_type=2 and talep_onay_new.user_id = $aauth_id AND `staff` = 1 $where_talep_form
")->num_rows();

        return [
            'status'=>1,
            'count'=>$count
        ];

    }

    public function bekleyen_hizmet_count_func()
    {
        $where_talep_form='';
        if($this->session->userdata('set_firma_id')){
            $where_talep_form.='and talep_form.loc='.$this->session->userdata('set_firma_id');
            //$this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $aauth_id = $this->aauth->get_user()->id;
        $count = $this->db->query("SELECT * FROM `talep_onay_new` 
INNER JOIN talep_form On talep_onay_new.talep_id=talep_form.id
WHERE talep_onay_new.type = 1 AND  talep_form.status=1 and talep_form.talep_type=2 and talep_onay_new.user_id = $aauth_id AND `staff` = 1 $where_talep_form
")->num_rows();

        return [
            'status'=>1,
            'count'=>$count
        ];

    }

    public function personelsatinalmalistcount(){


//        $siparis_finish = $this->db->query("SELECT * FROM `siparis_list_form`
//         INNER JOIN talep_form On siparis_list_form.talep_id=talep_form.id
//         WHERE  siparis_list_form.staff_id = $aauth_id AND siparis_list_form.staf_status = 1 and talep_form.status=5  and siparis_list_form.deleted_at is NULL
//
//                                  GROUP BY siparis_list_form.talep_id")->num_rows();


        $aauth_id = $this->aauth->get_user()->id;
        $count = $this->db->query("SELECT * FROM `talep_user_satinalma` INNER JOIN  talep_form ON talep_user_satinalma.talep_id=talep_form.id WHERE talep_form.talep_type=2 and talep_user_satinalma.status IN(1,2) AND  talep_form.status IN(2,3)  AND talep_user_satinalma.user_id = $aauth_id")->num_rows();
        return [
            'status'=>1,
            'count'=>$count
        ];


    }

    public function ihalelistcount(){

        $where_talep_form='';
        if($this->session->userdata('set_firma_id')){
            $where_talep_form.='and talep_form.loc='.$this->session->userdata('set_firma_id');
            //$this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $aauth_id = $this->aauth->get_user()->id;
        $count = $this->db->query("SELECT * FROM `talep_onay_new` INNER JOIN talep_form On talep_onay_new.talep_id=talep_form.id WHERE 
                                            talep_onay_new.type = 2 AND talep_onay_new.user_id = $aauth_id 
                                        AND talep_form.status=4 and talep_form.talep_type=2 and talep_onay_new.staff = 1 $where_talep_form")->num_rows();
        return [
            'status'=>1,
            'count'=>$count
        ];
    }

    public function siparislistcount(){
        $where_talep_form='';
        if($this->session->userdata('set_firma_id')){
            $where_talep_form.='and talep_form.loc='.$this->session->userdata('set_firma_id');
            //$this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $aauth_id = $this->aauth->get_user()->id;
        $count = $this->db->query("SELECT * FROM `talep_form`  INNER JOIN talep_user_satinalma ON 
    talep_form.id = talep_user_satinalma.talep_id WHERE talep_form.status = 5  AND talep_form.talep_type = 2 AND
                                                        talep_user_satinalma.user_id = $aauth_id  $where_talep_form")->num_rows();
        return [
            'status'=>1,
            'count'=>$count
        ];
    }
    public function siparis_finist_list_count(){
        $aauth_id = $this->aauth->get_user()->id;
        $count = $this->db->query("SELECT * FROM `siparis_list_form`
         INNER JOIN talep_form On siparis_list_form.talep_id=talep_form.id
         WHERE  siparis_list_form.staff_id = $aauth_id AND siparis_list_form.staf_status = 1 and talep_form.status=5 and talep_form.talep_type=2  and siparis_list_form.deleted_at is NULL  
                                  
                                  GROUP BY siparis_list_form.talep_id")->num_rows();
        return [
            'status'=>1,
            'count'=>$count
        ];


    }

    public function tehvil_list_count(){
        $where_talep_form='';
        if($this->session->userdata('set_firma_id')){
            $where_talep_form.='and talep_form.loc='.$this->session->userdata('set_firma_id');
            //$this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $aauth_id = $this->aauth->get_user()->id;
        $count = $this->db->query("SELECT * FROM `talep_form`  WHERE talep_form.status = 7 
                              and talep_form.talep_type = 2 and talep_form.warehouse_id=$aauth_id   $where_talep_form")->num_rows();
        return [
            'status'=>1,
            'count'=>$count
        ];


    }

    public function bekleyen_sened_list_count(){

        $where_talep_form='';
        if($this->session->userdata('set_firma_id')){
            $where_talep_form.='and talep_form.loc='.$this->session->userdata('set_firma_id');
            //$this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $aauth_id = $this->aauth->get_user()->id;
        $count = $this->db->query("SELECT * FROM `talep_form`  INNER JOIN talep_user_satinalma
    ON talep_form.id = talep_user_satinalma.talep_id WHERE talep_form.status = 6 and talep_form.talep_type=2 AND 
                                       talep_user_satinalma.user_id = $aauth_id  $where_talep_form")->num_rows();
        return [
            'status'=>1,
            'count'=>$count
        ];


    }

    public function qaimelistcount(){
        $where_talep_form='';
        $count=0;
        if($this->session->userdata('set_firma_id')){
            $where_talep_form.='and talep_form.loc='.$this->session->userdata('set_firma_id');
            //$this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $aauth_id = $this->aauth->get_user()->id;
        if($aauth_id==39){
            $count = $this->db->query("SELECT * FROM `talep_form` INNER JOIN 
geopos_projects On talep_form.proje_id =geopos_projects.id  WHERE talep_form.status = 8 and talep_form.talep_type =2  $where_talep_form")->num_rows();
            return [
                'status'=>1,
                'count'=>$count
            ];
        }
        else {
            return [
                'status'=>1,
                'count'=>0
            ];
        }




    }



}


