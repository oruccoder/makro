<?php
/**
 * İtalic Soft Yazılım  ERP - CRM - HRM
 * Copyright (c) İtalic Soft Yazılım. Tüm Hakları Saklıdır.
 * ***********************************************************************
 *
 *  Email: info@italicsoft.com
 *  Website: https://www.italicsoft.com
 *  Tel: 0850 317 41 44
 *  ******************************************tedtst***************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Lojistik Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model');
        $this->load->model('invoices_model');
        $this->load->model('communication_model');
        $this->load->model('lojistiks_model','lojistik');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        if (!$this->aauth->premission(32)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Lojistik Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('lojistik/index');
        $this->load->view('fixed/footer');
    }

    public function create()
    {
        if (!$this->aauth->premission(32)->write) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Yeni Lojistik Talebi';
        $this->load->view('fixed/header', $head);
        $this->load->view('lojistik/create');
        $this->load->view('fixed/footer');
    }
    public function create_save(){
        $lojistik_muduru = $this->input->post('lojistik_muduru');
        $proje_muduru = $this->input->post('proje_muduru');
        $genel_mudur_id = $this->input->post('genel_mudur_id');
        $desc = $this->input->post('desc');

        $talep_no = numaric(14);
        $this->db->trans_start();
        $data = array(
            'lojistik_muduru' => $lojistik_muduru,
            'proje_muduru' => $proje_muduru,
            'genel_mudur' => $genel_mudur_id,
            'description' => $desc,
            'user_id' => $this->aauth->get_user()->id,
            'talep_no' => $talep_no,
            'loc' => $this->session->userdata('set_firma_id'),
        );
        if ($this->db->insert('lojistik_talep', $data)) {
            $last_id = $this->db->insert_id();
            $operator= "deger+1";
            $this->db->set('deger', "$operator", FALSE);
            $this->db->where('tip', 14);
            $this->db->update('numaric');


            $product_details = $this->input->post('product_details');
            $prodindex = 0;
            $insert_count = count($product_details);
            if(count($product_details)){
                foreach ($product_details as $key=> $items){
                    $data_inser=[
                        'lojistik_id'=>$last_id,
                        'proje_id'=>$items['proje_id'],
                        'arac_id'=>$items['arac_id'],
                        'qty'=>$items['qty'],
                        'desc'=>$items['desc'],
                        'unit_id'=>$items['unit_id'],
                    ];

                    $this->db->insert('lojistik_talep_item', $data_inser);
                    $item_id = $this->db->insert_id();


                    foreach ($items['location'] as $values){
                        $data_location=[
                            'lojistik_id'=>$last_id,
                            'item_id'=>$item_id,
                            'location '=>$values,
                            'type '=>1,
                        ];
                        $this->db->insert('locations', $data_location);
                    }
                        if(isset($items['sf_no'])){
                            foreach ($items['sf_no'] as $values){
                                $data_sf=[
                                    'lojistik_id'=>$last_id,
                                    'item_id'=>$item_id,
                                    'sf_id '=>$values,
                                    'type '=>1,
                                ];
                                $this->db->insert('lojistik_sf', $data_sf);
                        }

                    }
                    $prodindex++;
                }
                if ($prodindex == $insert_count) {
                        $this->aauth->applog("Lojistik Talep Formu Eklendi : " . $last_id.' Talep No : '.$talep_no, $this->aauth->get_user()->username);
                        echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Talep Oluşturuldu",'view'=>'/lojistik/view/'.$last_id));
                        $this->db->trans_complete();
                    }
                    else {
                        $this->db->trans_rollback();
                        echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
                    }
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }

    public function view($id){

        if (!$this->aauth->premission(32)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $data['details']= $this->lojistik->details($id);

        if (!$data['details']) {
            exit('<h3>Talep Bulunamadı</h3>');
        }
        $data['items']= $this->lojistik->item_details($id);
        $head['title']= 'Lojistik Talep Görüntüleme';
        $this->load->view('fixed/header',$head);
        $this->load->view('lojistik/view', $data);
        $this->load->view('fixed/footer');
    }

    public function talep_onay_start(){
        $talep_id = $this->input->post('talep_id');
        $this->db->set('bildirim_durumu', 1);
        $this->db->where('id', $talep_id);
       if( $this->db->update('lojistik_talep')){
           $details = $this->lojistik->details($talep_id);
           $data = array(
               'file_id' => $talep_id,
               'type' => 11
           );
           if ($this->db->insert('geopos_onay', $data)) {
               $subject = 'Lojistik Talep Formu Onayı';
               $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Talep Formu Oluşturuldu. Onay İşleminiz Beklenmektedir.';
               $message .= "<br><br><br><br>";

               $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

               $proje_sorumlusu_email = personel_detailsa($details->lojistik_muduru)['email'];
               $recipients = array($proje_sorumlusu_email);
               if($this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$talep_id)){
                   $this->aauth->applog("Lojistik Talep Formu Onaya Sunuldu : " . $talep_id, $this->aauth->get_user()->username);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Onaya Sunuldu"));
               }
           }
           else {
               echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız"));
           }

       }
    }

    public function talep_onay(){
        $talep_id = $this->input->post('talep_id');
        $status = $this->input->post('status');
        $desc = $this->input->post('desc');
        $user_id = $this->aauth->get_user()->id;


        $details = $this->lojistik->details($talep_id);
        if($user_id==$details->lojistik_muduru || $user_id==$details->proje_muduru || $user_id==$details->genel_mudur)
        {

            $data = array(
                'talep_id' => $talep_id,
                'user_id' => $user_id,
                'status' => 2,
                'desc' => $desc

            );
            $this->db->insert('lojistik_onay', $data);
            if($user_id==$details->lojistik_muduru){

                $this->db->set('proje_sorumlusu_status', $status);
                $this->db->set('proje_sorumlusu_status_note', $desc);
                $this->db->where('file_id', $talep_id);
                $this->db->where('type', 11);
                $this->db->update('geopos_onay');

                $subject = 'Lojistik Talep Formu Onayı';
                $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Talep Formu Lojistik Müdürü Tarafından Onaylandı.Sizin Onayınız Beklemektedir.';
                $message .= "<br><br><br><br>";

                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $proje_sorumlusu_email = personel_detailsa($details->proje_muduru)['email'];
                $recipients = array($proje_sorumlusu_email);
                $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$talep_id);
            }
            if($user_id==$details->proje_muduru){
                $this->db->set('proje_muduru_status', $status);
                $this->db->set('proje_muduru_status_note', $desc);
                $this->db->where('file_id', $talep_id);
                $this->db->where('type', 11);
                $this->db->update('geopos_onay');


                $subject = 'Lojistik Talep Formu Onayı';
                $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Talep Formu Proje Müdürü Tarafından Onaylandı.Sizin Onayınız Beklemektedir.';
                $message .= "<br><br><br><br>";

                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $proje_sorumlusu_email = personel_detailsa($details->genel_mudur)['email'];
                $recipients = array($proje_sorumlusu_email);
                $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$talep_id);

                // Genel Müdüre Mail
            }
            if($user_id==$details->genel_mudur){
                // Kullanici ID gidecek
                $this->db->set('genel_mudur_status', $status);
                $this->db->set('genel_mudur_status_note', $desc);
                $this->db->where('file_id', $talep_id);
                $this->db->where('type', 11);
                $this->db->update('geopos_onay');


                $this->db->set('status', 2);
                $this->db->where('id', $talep_id);
                $this->db->update('lojistik_talep');

                $subject = 'Lojistik Talep Formu Onayı';
                $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Talep Formu Genel Müdürü Tarafından Onaylandı.Fiyat Araştırması Yapabilirsiniz.';
                $message .= "<br><br><br><br>";

                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $proje_sorumlusu_email = personel_detailsa($details->user_id)['email'];
                $recipients = array($proje_sorumlusu_email);
                $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$talep_id);
            }

            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Onaylandı"));
        }
        else {
            echo json_encode(array('status' => 'Error', 'message' =>"Yetkiniz Bulunmamaktadır."));
        }




    }

    public function talep_iptal(){

            $talep_id = $this->input->post('talep_id');
            $status = $this->input->post('status');
            $desc = $this->input->post('desc');
            $user_id = $this->aauth->get_user()->id;
            $details = $this->lojistik->details($talep_id);

            $data = array(
                'talep_id' => $talep_id,
                'user_id' => $user_id,
                'status' => 3,
                'desc' => $desc

            );
            $this->db->insert('lojistik_onay', $data);

            $this->db->set('status', 3);
            $this->db->where('id', $talep_id);
            $this->db->update('lojistik_talep');

            if($user_id == 21 || $user_id == $details->proje_muduru || $user_id == $details->genel_mudur){
                if($user_id==21){

                    $this->db->set('proje_sorumlusu_status', $status);
                    $this->db->set('proje_sorumlusu_status_note', $desc);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 11);
                    $this->db->update('geopos_onay');

                    $subject = 'Lojistik Talep Formu Onayı';
                    $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Talep Formu Lojistik Müdürü Tarafından İptal Edildi.';
                    $message .= "Açıklama : ".$desc."<br><br><br><br>";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $proje_sorumlusu_email = personel_detailsa($details->user_id)['email'];
                    $recipients = array($proje_sorumlusu_email);
                    $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$talep_id);
                }
                if($user_id==$details->proje_muduru){
                    $this->db->set('proje_muduru_status', $status);
                    $this->db->set('proje_muduru_status_note', $desc);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 11);
                    $this->db->update('geopos_onay');


                    $subject = 'Lojistik Talep Formu Onayı';
                    $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Talep Formu Proje Müdürü Tarafından İptal Edildi.';
                    $message .= "Açıklama : ".$desc."<br><br><br><br>";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $proje_sorumlusu_email = personel_detailsa($details->user_id)['email'];
                    $recipients = array($proje_sorumlusu_email);
                    $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$talep_id);

                    // Genel Müdüre Mail
                }
                if($user_id==$details->genel_mudur){
                    // Kullanici ID gidecek
                    $this->db->set('genel_mudur_status', $status);
                    $this->db->set('genel_mudur_status_note', $desc);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 11);
                    $this->db->update('geopos_onay');




                    $subject = 'Lojistik Talep Formu Onayı';
                    $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Talep Formu Genel Müdür Tarafından İptal Edildi.';
                    $message .= "Açıklama : ".$desc."<br><br><br><br>";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $proje_sorumlusu_email = personel_detailsa($details->user_id)['email'];
                    $recipients = array($proje_sorumlusu_email);
                    $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$talep_id);

                }
                echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde İptal Edildi"));
            }
            else {
                echo json_encode(array('status' => 'Error', 'message' =>"Yetkiniz Bulunmamaktadır."));
            }


    }
    public function onay_mailleri($subject, $message, $recipients, $tip)
    {

        $attachmenttrue = false;
        $attachment = '';


        $this->communication_model->onay_mail($recipients, $subject, $message, $attachmenttrue, $attachment, $tip);
        return 1;

    }

    public function ajax_list(){

        $list = $this->lojistik->get_datatables_details();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $button='';
            $sf='';
            $sf_item=$this->db->query("SELECT * FROM `lojistik_to_satinalma` where l_id=$prd->id GROUP BY sf_id");
            if($sf_item->num_rows()){
                $sf_id = $sf_item->row()->sf_id;
                $sf="<a href='/logistics/view/$sf_id' class='btn btn-info btn-sm'>SF Görüntüle</a>";
            }
            $edit = "<a class='btn btn-warning' href='/lojistik/edit/$prd->id'><i class='fa fa-pen'></i></a>&nbsp;";
            $view = "<a class='btn btn-info' href='/lojistik/view/$prd->id'><i class='fa fa-eye'></i></a>&nbsp;";
            //$cancel ="<button class='btn btn-danger talep_iptal' talep_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
            $cancel ="";
            if($prd->bildirim_durumu == 0){ // Bekliyor
                $button=$edit.$view.$cancel;
            }
            else if($prd->status == 1 ){
                $button=$view.$cancel;
            }
            else if($prd->status == 2 ){
                $button=$view.$cancel;
            }
            else if($prd->status == 3 ){
                $button=$view;
            }
            $no++;
            $row = array();
            $row[] = $prd->created_at;
            $row[] = $prd->talep_no;
            $row[] = $prd->status_name;
            $row[] = $prd->pers_name;
            $row[] =$sf;
            $row[] =$button;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->lojistik->count_all(),
            "recordsFiltered" => $this->lojistik->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function ajax_list_onay_bekleyen(){
        $user_id = $this->aauth->get_user()->id;
        $list = $this->lojistik->ajax_list_onay_bekleyen();
        $data = array();
        $no = $this->input->post('start');

        //$new_list = $list;
        $new_list = [];
        foreach ($list as $prd) {

            $lojistik_muduru = $prd->lojistik_muduru;
            $proje_muduru = $prd->proje_muduru;
            $genel_mudur = $prd->genel_mudur;

            if($user_id == $lojistik_muduru){
                $kontol = $this->db->query("SELECT * FROM lojistik_onay Where talep_id = $prd->id and  type=1")->num_rows();
                if(!$kontol){
                    $new_list[]=$prd;
                }
            }
            elseif($user_id == $proje_muduru){
                $kontol = $this->db->query("SELECT * FROM lojistik_onay Where talep_id = $prd->id and type=1 and user_id=$lojistik_muduru")->num_rows();
                if($kontol){
                    $new_list[]=$prd;
                }
            }
            elseif($user_id == $genel_mudur){

                $kontol = $this->db->query("SELECT * FROM lojistik_onay Where talep_id = $prd->id and type=1 and user_id=$proje_muduru")->num_rows();
                if($kontol){
                    $new_list[]=$prd;
                }
            }
        }

        foreach ($new_list as $prd) {

            $id = $prd->id;
            $view = "<a class='btn btn-info' href='/lojistik/view/$id'><i class='fa fa-eye'></i></a>&nbsp;";

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->created_at;
            $row[] = personel_details_full($prd->user_id)['name'];
            $row[] = $prd->talep_no;
            $row[] = 'Bekliyor';
            $row[] =$view;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => count($new_list),
            "recordsFiltered" => count($new_list),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        if (!$this->aauth->premission(32)->update) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Lojistik Düzenleme';
        $data['details']= $this->lojistik->details($id);
        $data['items']= $this->lojistik->item_details($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('lojistik/edit',$data);
        $this->load->view('fixed/footer');
    }

    public function update_save(){
        $lojistik_id = $this->input->post('lojistik_id');
        $lojistik_muduru = $this->input->post('lojistik_muduru');
        $proje_muduru = $this->input->post('proje_muduru');
        $genel_mudur_id = $this->input->post('genel_mudur_id');
        $desc = $this->input->post('desc');

        $this->db->trans_start();
        $data = array(
            'lojistik_muduru' => $lojistik_muduru,
            'proje_muduru' => $proje_muduru,
            'genel_mudur' => $genel_mudur_id,
            'description' => $desc,
        );

        $this->db->set($data);
        $this->db->where('id',$lojistik_id);
        if ($this->db->update('lojistik_talep', $data)) {
            $last_id = $lojistik_id;

            $this->db->delete('lojistik_talep_item', array('lojistik_id' => $lojistik_id));
            $this->db->delete('locations', array('lojistik_id' => $lojistik_id));
            $this->db->delete('lojistik_sf', array('lojistik_id' => $lojistik_id));
            $product_details = $this->input->post('product_details');
            $productlist = [];
            $prodindex = 0;

            $insert_count = count($product_details);
            if(count($product_details)){
                foreach ($product_details as $key=> $items){
                    $data_inser=[
                        'lojistik_id'=>$last_id,
                        'proje_id'=>$items['proje_id'],
                        'arac_id'=>$items['arac_id'],
                        'qty'=>$items['qty'],
                        'desc'=>$items['desc'],
                        'unit_id'=>$items['unit_id'],
                    ];

                    $this->db->insert('lojistik_talep_item', $data_inser);
                    $item_id = $this->db->insert_id();


                    foreach ($items['location'] as $values){
                        $data_location=[
                            'lojistik_id'=>$last_id,
                            'item_id'=>$item_id,
                            'location '=>$values,
                            'type '=>1,
                        ];
                        $this->db->insert('locations', $data_location);
                    }
                    foreach ($items['sf_no'] as $values){
                        $data_sf=[
                            'lojistik_id'=>$last_id,
                            'item_id'=>$item_id,
                            'sf_id '=>$values,
                            'type '=>1,
                        ];
                        $this->db->insert('lojistik_sf', $data_sf);
                    }
                    $prodindex++;
                }
                if ($prodindex == $insert_count) {
                    $this->aauth->applog("Lojistik Talep Formu Düzenlendi : " . $last_id, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Talep Oluşturuldu",'view'=>'/lojistik/view/'.$last_id));
                    $this->db->trans_complete();
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
                }
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
            }
        }
    }

    public function proje_to_sf(){
        $proje_id = $this->input->post('proje_id');
        $items= $this->lojistik->proje_to_sf($proje_id);
        echo json_encode(array('status' => 'Success', 'items' =>$items));

    }

   public function print($tid){

    $data['id'] = $tid;
    $data['details']= $this->lojistik->details($tid);
    $data['items']= $this->lojistik->item_details($tid);


    ini_set('memory_limit', '64M');
    $html = $this->load->view('lojistik/view-print', $data, true);
    $header = $this->load->view('lojistik/header-print', $data, true);
    $footer = $this->load->view('lojistik/footer-print', $data, true);



    //PDF Rendering
    $this->load->library('pdf');

    $pdf = $this->pdf->load_split();

    $pdf->SetHTMLHeader($header);

    $pdf->SetHTMLFooter($footer);
    $pdf->AddPage(
        'L', // L - landscape, P - portrait
        '', '', '', '',
        '', // margin_left
        '', // margin right
        50, // margin top
        '72', // margin bottom
        5, 2, 0, 0, // margin header
        'auto'); // margin footer

    $pdf->WriteHTML($html);


    $file_name ="Talep__";


    $pdf->Output($file_name . '.pdf', 'I');

}


}
