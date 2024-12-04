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

class Driver Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('driver_model','driverm');
        $this->load->model('arac_model', 'arac');
        $this->load->model('communication_model');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index($arac_id)
    {
        $details = $this->arac->details($arac_id);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $details->name.' Sürücü Listesi';
        $data['name']=$details->name.' Sürücü Listesi';
        $data['id']=$arac_id;
        $this->load->view('fixed/header', $head);
        $this->load->view('driver/index',$data);
        $this->load->view('fixed/footer');
    }



    public function ajax_list(){

        $list = $this->driverm->get_datatables_details();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $view='';

            if($prd->talep_id){
                $view = "<button class='btn btn-success view_talep_form' talep_id='$prd->talep_id' type='button'><i class='fa fa-eye'></i>&nbsp$prd->code</button>&nbsp;";

            }


            $pers_id = $prd->pers_id;
            if(!$prd->pers_id){
                $pers_id = $prd->user_id;
            }

            $pers_name = personel_details($pers_id);
            $etibarname = personel_belge_kontrol($pers_id,$prd->arac_id,9,$prd->id);
            $sürücülük = personel_belge_kontrol($pers_id,$prd->arac_id,8,$prd->id);
            $arac_muqavele = personel_belge_kontrol($pers_id,$prd->arac_id,10,$prd->id);

            $st = surucu_status($prd->status);


            $arac_degistir="<button class='btn btn-success arac_atama' talep_id='$prd->id' type='button'><i class='fa fa-truck'></i>&nbsp;Araç Değişikliği Yap</button>&nbsp;";
            $status_change="<button class='btn btn-success status_change' talep_id='$prd->id' type='button'><i class='fa fa-signal'></i>&nbsp;Durum Değiştir</button>&nbsp;";

            $no++;
            $row = array();
            $row[] = $pers_name;
            $row[] = $view;
            $row[] = $etibarname;
            $row[] = $arac_muqavele;
            $row[] = $sürücülük;
            $row[] = $st;
            $row[] =$arac_degistir.$status_change;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->driverm->count_all(),
            "recordsFiltered" => $this->driverm->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function ajax_list_notes(){

        $list = $this->driverm->get_datatables_details_notes();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $islem="<button class='btn btn-danger delete_surucu_notes' talep_id='$prd->id' type='button'><i class='fa fa-trash'></i>&nbsp;Sil</button>&nbsp;";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->status_name;
            $row[] = $prd->lokasyon;
            $row[] = $prd->teslim_date;
            $row[] = $prd->tehvil_date;
            $row[] = $prd->pers_name;
            $row[] = $prd->desc;
            $row[] =$islem;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->driverm->count_all_notes(),
            "recordsFiltered" => $this->driverm->count_filtered_notes(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_files(){

        $list = $this->driverm->get_datatables_details_files();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $islem="<button class='btn btn-danger delete_surucu_files' talep_id='$prd->id' type='button'><i class='fa fa-trash'></i>&nbsp;Sil</button>&nbsp;";
            $file = "<a class='btn btn-success' href='".base_url() . 'userfiles/product/' . $prd->file ."' target='_blank'>Dosya Görüntüle</a>";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->file_name;
            $row[] = $prd->desc;
            $row[] = $prd->islem_date;
            $row[] = $prd->created_at;
            $row[] = personel_details($prd->teslim_user_id);
            $row[] = personel_details($prd->tehvil_user_id);
            $row[] = $file;
            $row[] =$islem;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->driverm->count_all_files(),
            "recordsFiltered" => $this->driverm->count_filtered_files(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function belge_bildirim_olustur(){
        $type = $this->input->post('type');
        $pers_id = $this->input->post('pers_id');
        $arac_suruculeri_id = $this->input->post('arac_suruculeri_id');
        $surucu_details = $this->driverm->details($arac_suruculeri_id);

        $form_details = $this->driverm->form_details($arac_suruculeri_id);

        $type_name = personel_file_type_id($type);


        $subject = 'Eksik Belge Tamamlama Bildirimi';
        $message = 'Sayın Yetkili ' . $form_details->code . ' Numaralı Araç Talep Formunuza İstinaden '.$type_name.' Belgeniz Eksiktir Bu sebeple araç ataması yapılamaz.Lütfen Eksik Belgenizi Tamamlayınız';

        $message .= "<br><br><br><br>";

        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
  ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

        $proje_sorumlusu_email = personel_detailsa($pers_id)['email'];
        $recipients = array($proje_sorumlusu_email);


        if($this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$arac_suruculeri_id)){

             $data=
                 [
                     'arac_suruculeri_id'=>$arac_suruculeri_id,
                     'type'=>$type,
                     'arac_id'=>$surucu_details->arac_id,
                     'user_id'=>$pers_id,
                     'status'=>1,
                     'aauth_id'=>$this->aauth->get_user()->id
                 ];
        if ($this->db->insert('belge_talep_kontrol', $data)) {
            $this->aauth->applog("Sürücüye Eksik belge Bildirimi Yapıldı: Talep ID : ".$arac_suruculeri_id.' Araç ID : '.$surucu_details->arac_id, $this->aauth->get_user()->username);
        }


            echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla İşlem Tamamlandı'));
        }


    }


    public function belge_bildirim_olustur_(){
        $type = $this->input->post('type');
        $pers_id = $this->input->post('pers_id');
        $arac_id = $this->input->post('arac_id');
        $arac_suruculeri_id = $this->input->post('arac_suruculeri_id');
        $arac_details = arac_details($arac_id);


        $type_name = personel_file_type_id($type);


        $subject = 'Eksik Belge Tamamlama Bildirimi';
        $message = 'Sayın Yetkili '.$arac_details->name.' Aracına İstinaden '.$type_name.' Belgeniz Eksiktir Bu sebeple araç ataması yapılamaz.Lütfen Eksik Belgenizi Tamamlayınız';

        $message .= "<br><br><br><br>";

        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
  ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

        $proje_sorumlusu_email = personel_detailsa($pers_id)['email'];
        $recipients = array($proje_sorumlusu_email);


        if($this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$arac_suruculeri_id)){

            $data=
                [
                    'arac_suruculeri_id'=>$arac_suruculeri_id,
                    'type'=>$type,
                    'arac_id'=>$arac_id,
                    'user_id'=>$pers_id,
                    'status'=>1,
                    'aauth_id'=>$this->aauth->get_user()->id
                ];
            if ($this->db->insert('belge_talep_kontrol', $data)) {
                $this->aauth->applog("Sürücüye Eksik belge Bildirimi Yapıldı: Talep ID : ".$arac_suruculeri_id.' Araç ID : '.$arac_id, $this->aauth->get_user()->username);
            }


            echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla İşlem Tamamlandı'));
        }


    }

    public function onay_mailleri($subject, $message, $recipients, $tip)
    {

        $attachmenttrue = false;
        $attachment = '';


        $this->communication_model->onay_mail($recipients, $subject, $message, $attachmenttrue, $attachment, $tip);
        return 1;

    }

    public function status_change(){
        $this->db->trans_start();
        $result = $this->driverm->status_change();
        if($result['status']){
            echo json_encode(array('status' => 'Success', 'message' =>$result['messages']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>$result['messages']));
        }
    } public function arac_change(){
        $this->db->trans_start();
        $result = $this->driverm->arac_change();
        if($result['status']){
            echo json_encode(array('status' => 'Success', 'message' =>$result['messages']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>$result['messages']));
        }
    }


    public function arac_details($arac_id)
    {
        $details = $this->arac->details($arac_id);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $details->name.' Detay Raporu';
        $data['name']=$details->name.' Detayları';
        $data['id']=$arac_id;
        $data['details']=$details;
        $this->load->view('fixed/header', $head);
        $this->load->view('driver/arac_details',$data);
        $this->load->view('fixed/footer');
    }

    public function tehvil_teslim_tutanagi(){


        $this->load->view('driver/view-print',true);
    }

    public function surucu_notes_create(){
        $location = $this->input->post('location');
        $active_surucu_id = $this->input->post('active_surucu_id');
        $desc = $this->input->post('desc');
        $teslim_date = $this->input->post('teslim_date');
        $tehvil_date = $this->input->post('tehvil_date');
        $status = $this->input->post('status');
        $arac_id = $this->input->post('arac_id');
        $aktive_pasive = $this->input->post('aktive_pasive');
        $this->db->trans_start();
        $teslim_d=Null;
        $tehvil_d=Null;
        if($teslim_date){
            $teslim_d=dateformat_local($teslim_date);
        }
        if($tehvil_date){
            $tehvil_d=dateformat_local($tehvil_date);
        }
        $data = array(
            'arac_id' => $arac_id,
            'user_id' => $active_surucu_id,
            'aauth_id' => $this->aauth->get_user()->id,
            'surucu_notes_status_id' => $status,
            'lokasyon' => $location,
            'teslim_date' => $teslim_d,
            'tehvil_date' => $tehvil_d,
            'desc' => $desc,
            'aktive_pasive' => $aktive_pasive,
        );
        if ($this->db->insert('surucu_notes', $data)) {

            if($aktive_pasive){
                //aktif sürücüleri pasif yap
                $this->db->query("UPDATE `arac_suruculeri` SET status = 3 WHERE arac_id=$arac_id");
                //aktif sürücüleri pasif yap
            }

            $last_id = $this->db->insert_id();
            $this->aauth->applog("Araç Sürücü Durumu Eklendi : Araç ID : ".$arac_id, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Talep Oluşturuldu"));

            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }

    public function surucu_notes_delete(){
        $id = $this->input->post('id');
        $this->db->trans_start();
        if($this->db->delete('surucu_notes', array('id' => $id))){
            $this->aauth->applog("Araç Sürücü Durumu Silindi : ID : ".$id, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Silindi"));

            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }

    public function surucu_files_delete(){
        $id = $this->input->post('id');
        $this->db->trans_start();
        if($this->db->delete('surucu_files', array('id' => $id))){
            $this->aauth->applog("Araç Sürücü Dosyasy Silindi : ID : ".$id, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Silindi"));

            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }

    public function surucu_files_create(){
        $file_name = $this->input->post('file_name');
        $desc = $this->input->post('desc');
        $islem_date = $this->input->post('islem_date');
        $teslim_user_id = $this->input->post('teslim_user_id');
        $tehvil_user_id = $this->input->post('tehvil_user_id');
        $image_text = $this->input->post('image_text');
        $arac_id = $this->input->post('arac_id');
        $this->db->trans_start();
        $islem_d=Null;

        if($islem_date){
            $islem_d=dateformat_local($islem_date);
        }

        $data = array(
            'arac_id' => $arac_id,
            'file_name' => $file_name,
            'aauth_id' => $this->aauth->get_user()->id,
            'islem_date' => $islem_d,
            'teslim_user_id' => $teslim_user_id,
            'tehvil_user_id' => $tehvil_user_id,
            'desc' => $desc,
            'file' => $image_text,
        );
        if ($this->db->insert('surucu_files', $data)) {

            $last_id = $this->db->insert_id();
            $this->aauth->applog("Araç Sürücü Dosya  Eklendi : Araç ID : ".$arac_id, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Eklendi"));

            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }

}
