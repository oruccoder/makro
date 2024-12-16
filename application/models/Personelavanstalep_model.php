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





class Personelavanstalep_model extends CI_Model
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


    public function form_total($id){
        $this->db->select('SUM(total) as total');
        $this->db->from('talep_form_personel_products');
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        return $query->row()->total;
    }

    public function odeme_total($id){
        $this->db->select('SUM(total) as total');
        $this->db->from('talep_form_customer_new_payment');
        $this->db->where('form_id',$id);
        $this->db->where('tip',2);
        $query = $this->db->get();
        return $query->row()->total;
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
        $role_id = $this->aauth->get_user()->roleid;
        $santiye_id = personel_salary_details_get($aauth_id)->proje_id;

        $this->db->select('talep_form_personel.*,geopos_employees.name as pers_name,progress_status.name as progress_name,talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name');
        $this->db->from('talep_form_personel');
        $this->db->join('geopos_employees','talep_form_personel.talep_eden_user_id=geopos_employees.id','LEFT');
        $this->db->join('progress_status','talep_form_personel.progress_status_id=progress_status.id','LEFT');
        $this->db->join('geopos_projects','talep_form_personel.proje_id=geopos_projects.id','LEFT');
        $this->db->join('talep_form_status','talep_form_personel.status=talep_form_status.id');
        $i = 0;


        if (!$this->aauth->premission(95)->read) {
            // Eğer kullanıcı tüm personelleri görme yetkisine sahip değilse
            if (in_array($role_id, personel_yetkileri())) {
                // Kullanıcının şantiyesine göre filtrele
                $this->db->where('talep_form_personel.proje_id', $santiye_id);
            } else {
                // Yetkisi olmayan kullanıcılar için boş sonuç
                $this->db->where('1', 0);
            }
        }


        if($this->input->post('status_id')!=0){
            $this->db->where('talep_form_personel.status',$this->input->post('status_id'));
        }

        if(!$this->input->post('yetki')){
            $this->db->where('talep_form_personel.aauth',$aauth_id);
        }

        $this->db->where('talep_form_personel.tip',2);


        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_personel.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
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
        $this->db->order_by('`talep_form_personel`.`id` DESC');

    }

    public function knt_aylik_kalan_tutar($person_id)
    {
        $net_maas = net_maas_hesaplama_number($person_id,30);

        //$max_tutar = ($net_maas / 100) * 70;
        $max_tutar = $net_maas/2;
        // echo $max_tutar;

        $date = new DateTime('now');
        $m=date('m');
        $y = date('Y');
        $total_ay_sayisi = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);



        $bitis_date = $y.'-'.$m.'-'.$total_ay_sayisi." 23:59:00";
        $baslangic_date = $y.'-'.$m."-1 08:00:00";

        $total_avans = $this->db->query("SELECT IF(SUM(total),SUM(total),0) as totals FROM `geopos_invoices` WHERE `csd` = $person_id AND `invoice_type_id` = 14 AND `create_date` BETWEEN '$baslangic_date' AND '$bitis_date' ORDER BY `create_date` ASC")->row()->totals;

        $bakiye=personel_bakiye_report_num($person_id)['bakiye'];
        $bakiye_durum=personel_bakiye_report_num($person_id)['durum']; // 1 alacaklı 0 borclu


        if($bakiye_durum){
            $total_avans = 0;
        }
        else {
            if($bakiye<$total_avans){
                $total_avans=$bakiye;
            }
        }

        if($max_tutar>$total_avans){

            $kalan = floatval($max_tutar)-floatval($total_avans);

            return array(
                'status'=>true,
                'tutar'=>$kalan,
                'mesaj'=>"Sizin bu aydan kalan maksimum çekebileceğiniz tutar.",
            );
        }
        else {

            return array(
                'status'=>false,
                'tutar'=>0,
                'mesaj'=>"Sizin Bu Ay Avans Hakkınız Bulunmamaktadır!.Lütfen Sorumlu Olduğunuz Kişilerden Onay Talep Ediniz",
            );
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

    public function create_save(){
        $talep_eden_user_id = $this->aauth->get_user()->id;
        $salary_details = personel_salary_details_get($talep_eden_user_id);
        $proje_id = $salary_details->proje_id;
        $method = $this->input->post('method');

        if(check_bordro_payment_status($talep_eden_user_id,$method,1)){
            $progress_status_id = $this->input->post('progress_status_id');

            $personel_id = $this->aauth->get_user()->id;
            $desc = $this->input->post('desc');
            $fiyat = $this->input->post('fiyat');
            $image_text = $this->input->post('image_text');

            if($talep_eden_user_id==522){ // Hacıali
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
                    'loc' =>  $this->session->userdata('set_firma_id'),
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

                    //items ekleme

                    $data = array(
                        'cost_id' => 1026,
                        'progress_status_id' => 3,
                        'product_desc' => "Maaş Talebi",
                        'product_kullanim_yeri' => "Maaş",
                        'product_temin_date'=> date('Y-m-d'),
                        'unit_id' => 9,
                        'product_qty' => 1,
                        'price' => $fiyat,
                        'total' => floatval($fiyat)*floatval((1)),
                        'form_id' => $last_id,
                        'aauth' => $this->aauth->get_user()->id
                    );
                    if ($this->db->insert('talep_form_personel_products', $data)) {
                        $product_name= cost_details(170)->name;
                        $unit_name = units_(9)['name'];
                        $this->talep_history($last_id,$this->aauth->get_user()->id,'Gider Eklendi : '.$product_name.' | 1 '.$unit_name);
                    }
                    //items ekleme

                    $this->aauth->applog("Gider Talebi Oluşturuldu  : Talep No : ".$talep_no, $this->aauth->get_user()->username);

                    return [
                        'status'=>1,
                        'id'=>$last_id,
                        'mesaj'=>"Başarılı Bir Şekilde Talep Oluşturuldu",
                    ];
                }
                else {
                    return [
                        'status'=>0,
                        'id'=>0,
                        'mesaj'=>"Hata Aldınız.",
                    ];
                }
            }
            else {
                $talep_kontrol = talep_avans_kontrol($personel_id);
                if($talep_kontrol['status']){
                    $aylik_tutar_kontrol=aylik_kalan_tutar($personel_id);
                    $tutar = $aylik_tutar_kontrol['tutar'];
                    if($aylik_tutar_kontrol['status']){
                        if($fiyat<=$tutar){
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
                                'loc' =>  $this->session->userdata('set_firma_id'),
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

                                //items ekleme

                                $data = array(
                                    'cost_id' => 1026,
                                    'progress_status_id' => 3,
                                    'product_desc' => "Maaş Talebi",
                                    'product_kullanim_yeri' => "Maaş",
                                    'product_temin_date'=> date('Y-m-d'),
                                    'unit_id' => 9,
                                    'product_qty' => 1,
                                    'price' => $fiyat,
                                    'total' => floatval($fiyat)*floatval((1)),
                                    'form_id' => $last_id,
                                    'aauth' => $this->aauth->get_user()->id
                                );
                                if ($this->db->insert('talep_form_personel_products', $data)) {
                                    $product_name= cost_details(170)->name;
                                    $unit_name = units_(9)['name'];
                                    $this->talep_history($last_id,$this->aauth->get_user()->id,'Gider Eklendi : '.$product_name.' | 1 '.$unit_name);
                                }
                                //items ekleme

                                $this->aauth->applog("Gider Talebi Oluşturuldu  : Talep No : ".$talep_no, $this->aauth->get_user()->username);

                                return [
                                    'status'=>1,
                                    'id'=>$last_id,
                                    'mesaj'=>"Başarılı Bir Şekilde Talep Oluşturuldu",
                                ];
                            }
                            else {
                                return [
                                    'status'=>0,
                                    'id'=>0,
                                    'mesaj'=>"Hata Aldınız.",
                                ];
                            }
                        }
                        else {
                            return [
                                'status'=>0,
                                'id'=>0,
                                'mesaj'=>$aylik_tutar_kontrol['mesaj'].' : '.$aylik_tutar_kontrol['tutar']
                            ];
                        }
                    }
                    else {
                        return [
                            'status'=>0,
                            'id'=>0,
                            'mesaj'=>'Artık Siz Talep Oluşturamazsınız! Sorumlu Personelizden İzin Talep Ediniz.Sonra IT Destek Alınız'
                        ];
                    }

                }
                else {
                    return [
                        'status'=>0,
                        'id'=>0,
                        'mesaj'=>$talep_kontrol['message']
                    ];
                }
            }
        }
        else {
            return [
                'status'=>0,
                'mesaj'=>"Oluşmuş Bir Bordro Bulunamadı",
            ];
        }

    }

    public function create_save_yetki(){
        $progress_status_id = $this->input->post('progress_status_id');
        $talep_eden_user_id = $this->input->post('cach_personel');
        $method = $this->input->post('method');

        if(check_bordro_payment_status($talep_eden_user_id,$method,1)){
            $proje_id  = $this->db->query("SELECT * FROM personel_salary Where personel_id=$talep_eden_user_id and status=1")->row()->proje_id;
            $personel_id =$talep_eden_user_id;
            $desc = $this->input->post('desc');
            $fiyat = $this->input->post('fiyat');
            $image_text = $this->input->post('image_text');

            if($talep_eden_user_id==522){ // Hacıali
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
                    'loc' =>  $this->session->userdata('set_firma_id'),
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

                    //items ekleme

                    $data = array(
                        'cost_id' => 1026,
                        'progress_status_id' => 3,
                        'product_desc' => "Maaş Talebi",
                        'product_kullanim_yeri' => "Maaş",
                        'product_temin_date'=> date('Y-m-d'),
                        'unit_id' => 9,
                        'product_qty' => 1,
                        'price' => $fiyat,
                        'total' => floatval($fiyat)*floatval((1)),
                        'form_id' => $last_id,
                        'aauth' => $this->aauth->get_user()->id
                    );
                    if ($this->db->insert('talep_form_personel_products', $data)) {
                        $product_name= cost_details(170)->name;
                        $unit_name = units_(9)['name'];
                        $this->talep_history($last_id,$this->aauth->get_user()->id,'Gider Eklendi : '.$product_name.' | 1 '.$unit_name);
                    }
                    //items ekleme

                    $this->aauth->applog("Gider Talebi Oluşturuldu  : Talep No : ".$talep_no, $this->aauth->get_user()->username);

                    return [
                        'status'=>1,
                        'id'=>$last_id,
                        'mesaj'=>"Başarılı Bir Şekilde Talep Oluşturuldu",
                    ];
                }
                else {
                    return [
                        'status'=>0,
                        'id'=>0,
                        'mesaj'=>"Hata Aldınız.",
                    ];
                }
            }
            else {
                $talep_kontrol = talep_avans_kontrol($personel_id);
                if($talep_kontrol['status']){
                    $aylik_tutar_kontrol=aylik_kalan_tutar($personel_id);
                    $tutar = $aylik_tutar_kontrol['tutar'];
                    if($aylik_tutar_kontrol['status']){
                        if($fiyat<=$tutar){
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
                                'loc' =>  $this->session->userdata('set_firma_id'),
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

                                //items ekleme

                                $data = array(
                                    'cost_id' => 1026,
                                    'progress_status_id' => 3,
                                    'product_desc' => "Maaş Talebi",
                                    'product_kullanim_yeri' => "Maaş",
                                    'product_temin_date'=> date('Y-m-d'),
                                    'unit_id' => 9,
                                    'product_qty' => 1,
                                    'price' => $fiyat,
                                    'total' => floatval($fiyat)*floatval((1)),
                                    'form_id' => $last_id,
                                    'aauth' => $this->aauth->get_user()->id
                                );
                                if ($this->db->insert('talep_form_personel_products', $data)) {
                                    $product_name= cost_details(170)->name;
                                    $unit_name = units_(9)['name'];
                                    $this->talep_history($last_id,$this->aauth->get_user()->id,'Gider Eklendi : '.$product_name.' | 1 '.$unit_name);
                                }
                                //items ekleme

                                $this->aauth->applog("Gider Talebi Oluşturuldu  : Talep No : ".$talep_no, $this->aauth->get_user()->username);

                                return [
                                    'status'=>1,
                                    'id'=>$last_id,
                                    'mesaj'=>"Başarılı Bir Şekilde Talep Oluşturuldu",
                                ];
                            }
                            else {
                                return [
                                    'status'=>0,
                                    'id'=>0,
                                    'mesaj'=>"Hata Aldınız.",
                                ];
                            }
                        }
                        else {
                            return [
                                'status'=>0,
                                'id'=>0,
                                'mesaj'=>$aylik_tutar_kontrol['mesaj'].' : '.$aylik_tutar_kontrol['tutar']
                            ];
                        }
                    }
                    else {
                        return [
                            'status'=>0,
                            'id'=>0,
                            'mesaj'=>'Artık Siz Talep Oluşturamazsınız! Sorumlu Personelizden İzin Talep Ediniz.Sonra IT Destek Alınız'
                        ];
                    }

                }
                else {
                    return [
                        'status'=>0,
                        'id'=>0,
                        'mesaj'=>$talep_kontrol['message']
                    ];
                }
            }
        }
        else {
            return [
                'status'=>0,
                'mesaj'=>"Oluşmuş Bir Bordro Bulunamadı",
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
        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_personel.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
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
            else {
                $desc = $this->input->post('desc');
                $st_name = talep_form_status_details($now_status)->name;
                $this->talep_history($file_id,$this->aauth->get_user()->id,'Durum Güncellendi.Status :'.$st_name.' .Açıklama : '.$desc);
                $this->aauth->applog("Pesonel Avans Talebi Durum Güncellendi  : Talep No : ".$file_id, $this->aauth->get_user()->username);

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


    public function onay_olustur(){
        $id = $this->input->post('talep_id');
        $progress_status_id = $this->input->post('progress_status_id');
        $details = $this->model->details($id);
        $type = $this->input->post('type');
        $status = $this->input->post('status');
        $aauth_sort_id = $this->input->post('aauth_sort_id');
        $desc = $this->input->post('desc');
        $product_details = $this->input->post('product_details');
        if($status== -1 ) // talebi geri alma
        {
            $durum=false;
            $kontrol = $this->db->query("Select talep_onay_personel_new.*,
LAG(talep_onay_personel_new.id) OVER(ORDER BY talep_onay_personel_new.sort) as bir_onceki
from talep_onay_personel_new where talep_id=$id LIMIT 6");
            if($kontrol->num_rows())
            {
                foreach ($kontrol->result() as $kontrol_item){
                    if($kontrol_item->id ==$aauth_sort_id){
                        if($kontrol_item->bir_onceki){
                            $bir_onceki_id = $kontrol_item->bir_onceki;
                            $data_item_update_now = [
                                'staff'=>0,
                                'status'=>null,
                            ];
                            $this->db->where('id',$aauth_sort_id);
                            $this->db->set($data_item_update_now);
                            $this->db->update('talep_onay_personel_new', $data_item_update_now);

                            $data_item_update = [
                                'staff'=>1,
                                'status'=>null,
                            ];
                            $this->db->where('id',$bir_onceki_id);
                            $this->db->set($data_item_update);
                            $this->db->update('talep_onay_personel_new', $data_item_update);
                            $durum=true;
                            break;
                        }
                        else {
                            $durum=false;
                            break;
                        }
                    }
                }

                if($durum){
                    $data_item_update_now = [
                        'staff'=>0,
                        'status'=>null,
                    ];
                    $this->db->where('id',$aauth_sort_id);
                    $this->db->set($data_item_update_now);
                    $this->db->update('talep_onay_personel_new', $data_item_update_now);


                    //Ödeme Bekliyor
                    $data_Form=array(
                        'status'=>1,
                        'bildirim_durumu'=>0,
                    );
                    //Ödeme Bekliyor
                    $this->db->set($data_Form);
                    $this->db->where('id', $id);
                    $this->db->update('talep_form_personel', $data_Form);
                    //
                    $this->talep_history($id,$this->aauth->get_user()->id,'Talep Bir Önceki Adıma Geri Alındı.Açıklama : '.$desc);
                    return [
                        'status'=>1,
                        'mesaj'=>"Talep Bir Önceki Adıma Geri Alındı.",
                    ];
                }
                else {
                    $this->talep_history($id,$this->aauth->get_user()->id,'Talep Aşamasına Geri Alınmıştır.Açıklama : '.$desc);
                    return [
                        'status'=>1,
                        'mesaj'=>"Talep Aşamasına Geri Alınmıştır",
                    ];
                }
            }

        }
        elseif($status==1) {
            //onay
            foreach ($product_details as $items){
                $item_id = $items['item_id'];
                $item_details=$this->db->query("SELECT * FROM  talep_form_personel_products where id =$item_id ")->row();
                $product_name = cost_details($item_details->cost_id)->name;
                $data_item_update = [
                    'product_qty'=>$items['item_qty'],
                    'price'=>$items['item_price'],
                    'total'=>floatval($items['item_price'])*floatval($items['item_qty']),
                ];
                $this->db->where('id',$items['item_id']);
                $this->db->set($data_item_update);
                $this->db->update('talep_form_personel_products', $data_item_update);

                $data_talep_updata=['progress_status_id'=>$progress_status_id];
                $this->db->where('id',$id);
                $this->db->set($data_talep_updata);
                $this->db->update('talep_form_personel', $data_talep_updata);

                $progress_status_details = progress_status_details($progress_status_id);
                $this->talep_history($id,$this->aauth->get_user()->id,$product_name.' Ürünü İçin Yeni Miktar : '.$items['item_qty'].' Yeni Durum : '.$progress_status_details->name);
            }


            $new_id=0;
            $new_user_id=0;
            $new_id_control = $this->db->query("SELECT * FROM `talep_onay_personel_new` Where type=$type and talep_id=$id and staff=0 and status is Null ORDER BY `talep_onay_personel_new`.`id` ASC LIMIT 1");
            if($new_id_control->num_rows()){
                $new_id = $new_id_control->row()->id;
                $new_user_id = $new_id_control->row()->user_id;
            }
            $data = array(
                'status' => 1,
                'staff' => 0,
            );

            $this->db->where('user_id',$this->aauth->get_user()->id);
            $this->db->where('staff',1);
            $this->db->where('type',$type);
            $this->db->set($data);
            $this->db->where('talep_id', $id);
            if ($this->db->update('talep_onay_personel_new', $data)) {

                $this->talep_history($id,$this->aauth->get_user()->id,'Onay Verildi');
                if($new_id){

                    $mesaj=$details->code.' Numaralı Avans Talep Formu Onayınızı Beklemektedir';
                    //$this->model->send_mail($new_user_id,'Avans Talep Onayı',$mesaj);

                    // Bir Sonraki Onay
                    $data_new=array(
                        'staff'=>1,
                    );
                    $this->db->where('id',$new_id);
                    $this->db->set($data_new);
                    $this->db->update('talep_onay_personel_new', $data_new);
                    // Bir Sonraki Onay
                }
                else {
//                $mesaj=$details->code.' Numaralı Avans Talep Formu Onaylanmıştır. İşleminiz Ödeme Emri Beklemektedir';
//                $this->model->send_mail($details->talep_eden_pers_id,'Avans Talep Formu',$mesaj);
                    //Ödeme Bekliyor
                    $data_Form=array(
                        'status'=>11,
                    );
                    //Ödeme Bekliyor
                    $this->db->set($data_Form);
                    $this->db->where('id', $id);
                    $this->db->update('talep_form_personel', $data_Form);
                    //Kontrol Bekliyor
                }
                $this->aauth->applog("Avans Talebine Onay Verildi :  ID : ".$id, $this->aauth->get_user()->username);
                return [
                    'status'=>1,
                    'mesaj'=>"Başarıyla Onay Verildi",
                ];
            }
            else {
                return [
                    'status'=>0,
                    'mesaj'=>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.",
                ];
            }
        }
        else {
            //iptal
        }
    }
}