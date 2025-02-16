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

class Malzemetalep Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $selected_db = $this->session->userdata('selected_db');
        if (!empty($selected_db)) {
            $this->db = $this->load->database($selected_db, TRUE);
        }
        $this->load->model('categories_model');
        $this->load->helper('cookie');
        $this->load->model('malzemetalep_model', 'talep');
        $this->load->model('stocktransfer_model', 'stocktransfer');
        $this->load->model('communication_model');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }




    public function all_list()
    {
        if (!$this->aauth->premission(31)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }



        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Malzame Talep Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('malzematalep/all_list');
        $this->load->view('fixed/footer');
    }
    public function index()
    {
        if (!$this->aauth->premission(31)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Malzame Talep Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('malzematalep/index');
        $this->load->view('fixed/footer');
    }

    public function talep_asama_update()
    {
        $this->db->trans_start();
        $user_id  = $this->aauth->get_user()->id;
        $form_id=$this->input->post('talep_id');
        $status=$this->input->post('status');
        $talep_kontrol  = $this->db->query("SELECT * FROM `talep_form` where id=$form_id and (  talep_eden_user_id=$user_id or aauth=$user_id)")->num_rows();

       $details = $this->talep->details($form_id);
       $proje_id = $details->proje_id;
       $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $proje_id and (  proje_sorumlusu_id=$user_id or proje_muduru_id=$user_id or muhasebe_muduru_id=$user_id or genel_mudur_id=$user_id)")->num_rows();

       $iptal_desc=$this->input->post('iptal_desc');
       $data_Form=array(
           'status'=>$status,
       );
       $this->db->set($data_Form);
       $this->db->where('id', $form_id);
       if( $this->db->update('talep_form', $data_Form)){
           $old_status_name = talep_form_status_details($details->status)->name;
           $new_status_name = talep_form_status_details($status)->name;
           $this->talep_history($form_id,$this->aauth->get_user()->id,'Talep '.$old_status_name.' Aşamasından, '.$new_status_name.' Aşamasına Alındı. Açıklama : '.$iptal_desc);

           if($status==1){
              if($details->status==7) // Depo
               {
                   $kotrol=$this->depo_alim_kontrol($form_id,0);
                   if($kotrol['status']==410){
                       $this->db->trans_rollback();
                       echo json_encode(array('status' => 'Error', 'message' =>$kotrol['message']));
                   }
                   else {
                       $this->depo_alim_kontrol($form_id,1);
                       $this->talep_senet_kontrol($form_id,1);
                       $this->odeme_kontrol($form_id,1);
                       $this->teklif_son_durum_kontrol($form_id);
                       $this->mukayese_kontrol($form_id);
                       $this->cari_sureci_kontrol($form_id);
                       $this->talep_surec_kontrol($form_id);
                       echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                       $this->db->trans_complete();

                   }
               }
               elseif($details->status==6) //Sened
               {
                   $this->talep_senet_kontrol($form_id,1);
                   $this->odeme_kontrol($form_id,1);
                   $this->teklif_son_durum_kontrol($form_id);
                   $this->mukayese_kontrol($form_id);
                   $this->cari_sureci_kontrol($form_id);
                   $this->talep_surec_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
               elseif($details->status==11) //Ön Ödeme
               {
                   $this->odeme_kontrol($form_id,1);
                   $this->teklif_son_durum_kontrol($form_id);
                   $this->mukayese_kontrol($form_id);
                   $this->cari_sureci_kontrol($form_id);
                   $this->talep_surec_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
               elseif($details->status==5) //siparis
               {
                   $this->teklif_son_durum_kontrol($form_id);
                   $this->mukayese_kontrol($form_id);
                   $this->cari_sureci_kontrol($form_id);
                   $this->talep_surec_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
               elseif($details->status==4) //Kıyaslama
               {
                   $this->mukayese_kontrol($form_id);
                   $this->cari_sureci_kontrol($form_id);
                   $this->talep_surec_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
               elseif($details->status==3) //Teklif
               {
                   $this->cari_sureci_kontrol($form_id);
                   $this->talep_surec_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
               elseif($details->status==2) //Cari
               {
                   $this->talep_surec_kontrol($form_id);
                   $this->talep_form_cari($form_id);
                   $data_Form=array(
                       'bildirim_durumu'=>0,
                   );
                   $this->db->set($data_Form);
                   $this->db->where('id', $form_id);
                   $this->db->update('talep_form', $data_Form);

                   //satinalmaupdate

                   $data_Form_s=array(
                       'status'=>1,
                   );
                   $this->db->set($data_Form_s);
                   $this->db->where('talep_id', $form_id);
                   $this->db->where('user_id', $user_id);
                   $this->db->update('talep_user_satinalma', $data_Form_s);

                   //satinalmaupdate



                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }

           }
           elseif($status==17){
               $this->talep_surec_kontrol($form_id);
               $this->db->delete('talep_onay_new', array('talep_id' => $form_id,'type'=>3));
               $users_ = onay_sort(14,0,0,$form_id);
               if($users_){
                   foreach ($users_ as $items){
                       $staff=0;
                       if($items['sort']==1){

                           $staff=1;
                       }

                       $data_onay = array(
                           'talep_id' => $form_id,
                           'type' => 3,
                           'staff' => $staff,
                           'sort' => $items['sort'],
                           'user_id' => $items['user_id'],
                       );
                       if($this->db->insert('talep_onay_new', $data_onay)){

                           $data_Form=array(
                               'status'=>17,
                           );
                           $this->db->set($data_Form);
                           $this->db->where('id', $form_id);
                           $this->db->update('talep_form', $data_Form);


                           echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                           $this->db->trans_complete();
                       }
                       else {
                           $this->db->trans_rollback();
                           echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
                       }
                   }

               }

           }
           elseif($status==2){
              if($details->status==7) // Depo
               {
                   $kotrol=$this->depo_alim_kontrol($form_id,0);
                   if($kotrol['status']==410){
                       $this->db->trans_rollback();
                       echo json_encode(array('status' => 'Error', 'message' =>$kotrol['message']));
                   }
                   else {
                       $this->depo_alim_kontrol($form_id,1);
                       $this->talep_senet_kontrol($form_id,1);
                       $this->odeme_kontrol($form_id,1);
                       $this->teklif_son_durum_kontrol($form_id);
                       $this->mukayese_kontrol($form_id);
                       $this->cari_sureci_kontrol($form_id);
                       echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                       $this->db->trans_complete();
                    }
               }
               elseif($details->status==6) //Sened
               {
                   $this->talep_senet_kontrol($form_id,1);
                   $this->odeme_kontrol($form_id,1);
                   $this->teklif_son_durum_kontrol($form_id);
                   $this->mukayese_kontrol($form_id);
                   $this->cari_sureci_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
               elseif($details->status==11) //Ön Ödeme
               {
                   $this->odeme_kontrol($form_id,1);
                   $this->teklif_son_durum_kontrol($form_id);
                   $this->mukayese_kontrol($form_id);
                   $this->cari_sureci_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
               elseif($details->status==5) //siparis
               {
                   $this->teklif_son_durum_kontrol($form_id);
                   $this->mukayese_kontrol($form_id);
                   $this->cari_sureci_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
               elseif($details->status==4) //Kıyaslama
               {
                   $this->mukayese_kontrol($form_id);
                   $this->cari_sureci_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
               elseif($details->status==3) //Teklif
               {

                   $this->cari_sureci_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
           }
           elseif($status==3){
               if($details->status==7) // Depo
               {
                   $kotrol=$this->depo_alim_kontrol($form_id,0);
                   if($kotrol['status']==410){
                       $this->db->trans_rollback();
                       echo json_encode(array('status' => 'Error', 'message' =>$kotrol['message']));
                   }
                   else {

                       $this->depo_alim_kontrol($form_id, 1);
                       $this->talep_senet_kontrol($form_id, 1);
                       $this->odeme_kontrol($form_id, 1);
                       $this->teklif_son_durum_kontrol($form_id);
                       $this->mukayese_kontrol($form_id);
                       $this->cari_sureci_kontrol($form_id);
                       echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde Aşamaya Alındı"));
                       $this->db->trans_complete();
                   }
               }
               elseif($details->status==6) //Sened
               {
                   $this->talep_senet_kontrol($form_id,1);
                   $this->odeme_kontrol($form_id,1);
                   $this->teklif_son_durum_kontrol($form_id);
                   $this->mukayese_kontrol($form_id);
                   $this->cari_sureci_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
               elseif($details->status==11) //Ön Ödeme
               {
                   $this->odeme_kontrol($form_id,1);
                   $this->teklif_son_durum_kontrol($form_id);
                   $this->cari_sureci_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
               elseif($details->status==5) //siparis
               {
                   $this->teklif_son_durum_kontrol($form_id);
                   $this->cari_sureci_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
               elseif($details->status==4) //Kıyaslama
               {
                   $this->teklif_son_durum_kontrol($form_id);
                   $this->mukayese_kontrol($form_id,2);
                   $this->onay_sil($form_id,2);
                   $this->cari_sureci_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
           }
           elseif($status==4){
                 if($details->status==7) // Depo
               {
                   $kotrol=$this->depo_alim_kontrol($form_id,0);
                   if($kotrol['status']==410){
                       $this->db->trans_rollback();
                       echo json_encode(array('status' => 'Error', 'message' =>$kotrol['message']));
                   }
                   else {
                       $this->depo_alim_kontrol($form_id,1);
                       $this->talep_senet_kontrol($form_id,1);
                       $this->odeme_kontrol($form_id,1);
                       $this->teklif_son_durum_kontrol($form_id);
                       $this->mukayese_kontrol($form_id);
//                       $this->cari_sureci_kontrol($form_id);
//                       $this->talep_surec_kontrol($form_id);
                       echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                       $this->db->trans_complete();

                   }
               }
                   elseif($details->status==6) //Sened
                   {
                       $this->talep_senet_kontrol($form_id,1);
                       $this->odeme_kontrol($form_id,1);
                       $this->teklif_son_durum_kontrol($form_id);
                       $this->mukayese_kontrol($form_id);
                       $this->cari_sureci_kontrol($form_id);
                       echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                       $this->db->trans_complete();
                   }
               elseif($details->status==11) //Ön Ödeme
               {
                   $this->odeme_kontrol($form_id,1);
                   $this->teklif_son_durum_kontrol($form_id);
                   $this->mukayese_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
               elseif($details->status==5) //siparis
               {
                   $this->teklif_son_durum_kontrol($form_id);
                   $this->mukayese_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
           }
           elseif($status==5){
              if($details->status==7) // Depo
               {
                   $kotrol=$this->depo_alim_kontrol($form_id,0);
                   if($kotrol['status']==410){
                       $this->db->trans_rollback();
                       echo json_encode(array('status' => 'Error', 'message' =>$kotrol['message']));
                   }
                   else {
                       $this->depo_alim_kontrol($form_id,1);
                       $this->talep_senet_kontrol($form_id,1);
                       $this->odeme_kontrol($form_id,1);
                       $this->teklif_son_durum_kontrol($form_id);
//                       $this->mukayese_kontrol($form_id);
//                       $this->cari_sureci_kontrol($form_id);
//                       $this->talep_surec_kontrol($form_id);
                       echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                       $this->db->trans_complete();

                   }
               }
                elseif($details->status==6) //Sened
               {
                   $this->talep_senet_kontrol($form_id,1);
                   $this->odeme_kontrol($form_id,1);
                   $this->teklif_son_durum_kontrol($form_id);
                   //$this->mukayese_kontrol($form_id);
                   //$this->cari_sureci_kontrol($form_id);
                   //$this->talep_surec_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
                elseif($details->status==11) //Ön Ödeme
               {

                   $odeme_kontrol = $this->odeme_kontrol($form_id,0);
                   if($odeme_kontrol){
                      $this->db->trans_rollback();
                       echo json_encode(array('status' => 'Error', 'message' =>'Ödeme Oluşturulmuş Talepte Aşama Değişemez'));
                       exit();

                   }
                   $this->odeme_kontrol($form_id, 1);
                   $this->depo_alim_kontrol($form_id, 1);
                   $this->teklif_son_durum_kontrol($form_id);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();

               }
           }
           elseif($status==11){
              if($details->status==7) // Depo
               {
                   $kotrol=$this->depo_alim_kontrol($form_id,0);
                   if($kotrol['status']==410){
                       $this->db->trans_rollback();
                       echo json_encode(array('status' => 'Error', 'message' =>$kotrol['message']));
                   }
                   else {
                       $this->depo_alim_kontrol($form_id, 1);
                       $this->talep_senet_kontrol($form_id, 1);
                       $this->odeme_kontrol($form_id, 1);
                       echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde Aşamaya Alındı"));
                       $this->db->trans_complete();
                   }


               }
               elseif($details->status==6) //Sened
               {

                   $this->talep_senet_kontrol($form_id,1);
                   $this->odeme_kontrol($form_id,1);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                   $this->db->trans_complete();

               }
           }
           elseif($status==6)
           {
              if($details->status==7) // Depo
               {
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Şekilde Bir Senet  Aşamaya Alındı"));
                   $this->db->trans_complete();
               }
               elseif($details->status==11) // Ön Ödeme
               {

                   $this->depo_alim_kontrol($form_id,1);
                   $this->talep_senet_kontrol($form_id,1);
                   $this->odeme_kontrol($form_id, 1);
                   echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Şekilde Bir Senet  Aşamaya Alındı"));
                   $this->db->trans_complete();
               }

           }
           elseif($status==7){
               if($details->status==8 || $details->status==9) // Qaime // Tamamandı
               {
                   $kotrol=$this->qaime_kontrol($form_id);
                   if($kotrol['status']==410){
                       $this->db->trans_rollback();
                       echo json_encode(array('status' => 'Error', 'message' =>$kotrol['message']));
                   }
                   else {
                       echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
                       $this->db->trans_complete();
                   }
               }
           } // Depo
           elseif($status==8)
           {
               echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Aşamaya Alındı"));
               $this->db->trans_complete();
           }
       }
           else {
               $this->db->trans_rollback();
               echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
           }




    }

    public function qaime_kontrol($form_id)
    {
        $qaime_list = $this->db->query("SELECT * FROM talep_to_invoice WHERE talep_id=$form_id");
        if($qaime_list->num_rows()){
            return array('status' => 410, 'message' =>"Qaimesi Oluşturulmuş Talep Aşama Değiştiremez.");
        }
        else {
            return array('status' => 200);
        }
    }

    public function depo_alim_kontrol($form_id,$tip=0)
    {

        $warehouse_list = $this->db->query("SELECT * FROM warehouse_teslimat WHERE form_id=$form_id");
       if($tip==0){
           if($warehouse_list->num_rows()){
               $array_id=[];
               foreach ($warehouse_list->result() as $list){
                   $array_id[]=$list->id;

               }
               $str =  implode(",", $array_id);
               $warehouse_list_teslimat = $this->db->query("SELECT * FROM teslimat_warehouse_item WHERE teslimat_warehouse_id IN ($str)");
               if($warehouse_list_teslimat->num_rows()){
                   return array('status' => 410, 'message' =>"Depoya Ürün Girişi Yapılmıştır.Talep Aşama Değiştiremez.");
               }
               else {
                   return array('status' => 200);
               }

           }
           else {
               return array('status' => 200);
           }

       }
       elseif($tip==1){
            $this->db->delete('warehouse_teslimat', array('form_id' => $form_id));
        }

    }

    public function talep_senet_kontrol($form_id,$tip=0)
    {
        if($tip==0){
            $talep_senet = $this->db->query("SELECT * FROM talep_senet WHERE talep_id=$form_id");
            if($talep_senet->num_rows()){
                return array('status' => 200);
            }
        }
        else {
            $this->db->delete('talep_senet', array('talep_id' => $form_id));
        }

    }

    public function odeme_kontrol($form_id,$tip=0)
    {
        $odeme_list = $this->db->query("SELECT * FROM talep_form_transaction WHERE form_id=$form_id");
        if($tip==0){
            if($odeme_list->num_rows()){
                return array('status' => 200);
            }
        }
        else {
            $this->db->delete('talep_form_transaction', array('form_id=' => $form_id,'tip'=>1));
            $this->db->delete('talep_form_avans', array('talep_id' => $form_id));
        }

    }

    public function teklif_son_durum_kontrol($form_id){

         $siparis_list = $this->db->query("SELECT * FROM siparis_list_form WHERE talep_id=$form_id");
         if($siparis_list->num_rows()){
             $array_id=[];
             foreach ($siparis_list->result() as $item){
                 $array_id[]=$item->id;
                 $this->db->delete('siparis_list_form_new', array('siparis_liste_form_id' => $item->id));
             }
             $this->db->delete('siparis_list_form', array('talep_id' => $form_id));
         }
    }

    public function mukayese_kontrol($form_id,$type=2){
        $siparis_list = $this->db->query("SELECT * FROM teklif_onay_list WHERE form_id=$form_id");
        if($siparis_list->num_rows()){
            $this->db->delete('teklif_onay_list', array('form_id' => $form_id));
            $this->db->delete('teklif_counter', array('talep_id' => $form_id));
            $this->db->delete('warehouse_teslimat', array('form_id' => $form_id));
            //$this->db->delete('talep_onay_new', array('talep_id' => $form_id,'type'=>2));

//            $data_Form=array(
//                'status'=>null,
//                'staff'=>0,
//            );
//            $this->db->set($data_Form);
//            $this->db->where('talep_id', $form_id);
//            $this->db->where('type', $type);

            $this->db->set('staff',0);
            $this->db->set('status',null);
            $this->db->set('updated_at', "NOW()", FALSE);
            $this->db->where('talep_id', $form_id);
            $this->db->where('type', $type);
            if($this->db->update('talep_onay_new')) {
//
//
//                $data_Form2=array(
//                    'staff'=>1,
//                );
//                $this->db->set($data_Form2);
//                $this->db->where('talep_id', $form_id);
//                $this->db->where('type', $type);
//                $this->db->where('sort', 1);
//                $this->db->update('talep_onay_new', $data_Form2);

                $this->db->set('staff',1);
                $this->db->where('talep_id', $form_id);
                $this->db->where('type', $type);
                $this->db->where('sort', 1);
                $this->db->update('talep_onay_new');

            }
        }
    }

    public function onay_sil($form_id,$type=2){
        $this->db->delete('talep_onay_new', array('talep_id' => $form_id,'type'=>2));
    }

    public function cari_sureci_kontrol($form_id){
        $this->db->delete('talep_form_teklifler', array('form_id' => $form_id));
        $this->db->delete('teklif_onay_list', array('form_id' => $form_id));
        $this->db->delete('teklif_counter', array('talep_id' => $form_id));
        $this->db->delete('talep_form_cari', array('talep_id' => $form_id));
    }

    public function talep_surec_kontrol($form_id){
        $this->db->delete('talep_onay_new', array('talep_id' => $form_id));
    }
    public function talep_form_cari($form_id){
        $this->db->delete('talep_form_cari', array('talep_id' => $form_id));
    }




    public function qaime_status()
    {
        $this->db->trans_start();

        $form_id=$this->input->post('talep_id');
        $senet_kontrol = $this->db->query("SELECT * FROM `talep_senet` Where talep_id = $form_id and (tehvil_teslim=0 or tehvil_teslim is NULL)")->num_rows();

        if(!$senet_kontrol){
            $data_Form=array(
                'status'=>8,
            );
            //talep aşamasına al
            $this->db->set($data_Form);
            $this->db->where('id', $form_id);
            //talep aşamasına al
            if( $this->db->update('talep_form', $data_Form)){
                $this->talep_history($form_id,$this->aauth->get_user()->id,'Talep Qaime Aşamasına Alındı.');
                echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Tamamlandı"));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Yetkiniz Bulunmamaktadır."));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Tehvil Teslim Aktı Gereklidir"));
        }



    }

    public function avans_update(){
        $this->db->trans_start();
        $avans_tutar=$this->input->post('avans_tutar');
        $form_id=$this->input->post('talep_id');
        $cari_id=$this->input->post('cari_id');
        $talep_form_teklifler_details_id=$this->input->post('talep_form_teklifler_details_id');

        $details = $this->db->query("Select * FROM talep_form_teklifler_details Where id = $talep_form_teklifler_details_id")->row();
        $talep_edilen=$details->avans_price;
        $cari_name = customer_details($cari_id)['company'];

        $data_Form=array(
            'avans_price'=>$avans_tutar,
        );
        //talep aşamasına al
        $this->db->set($data_Form);
        $this->db->where('id', $talep_form_teklifler_details_id);
        if( $this->db->update('talep_form_teklifler_details', $data_Form)){
            $this->talep_history($form_id,$this->aauth->get_user()->id,'Avans Güncellendi. Talep Edilen Avans : '.amountFormat($talep_edilen).' Güncellenen Avans : '.amountFormat($avans_tutar).' Cari Adı : '.$cari_name);
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Tamamlandı"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Yetkiniz Bulunmamaktadır."));
        }
    }

    public function sened_status()
    {
        $this->db->trans_start();
        $form_id=$this->input->post('talep_id');
        $user_id= $this->aauth->get_user()->id;
        $muhasebe_id=39;
        $muhasebe = $this->db->query("SELECT * FROM talep_form_avans Inner Join talep_form_avans_sort ON talep_form_avans.id=talep_form_avans_sort.talep_form_avans_id Where talep_form_avans.type = 2");
        if($muhasebe->num_rows()){
            $muhasebe_id = $muhasebe->row()->muhasebe_id;
        }


        $talep_kontrol  = $this->db->query("SELECT * FROM `talep_user_satinalma` where talep_id=$form_id and user_id=$user_id")->num_rows();
        if($talep_kontrol || $muhasebe_id==$user_id){
            $data_Form=array(
                'status'=>6,
            );
            //talep aşamasına al
            $this->db->set($data_Form);
            $this->db->where('id', $form_id);
            //talep aşamasına al
            if( $this->db->update('talep_form', $data_Form)){


                //satınalma personelini şukufe yap
                $data_satinalma=array(
                    'user_id'=>976
                );
                $this->db->set($data_satinalma);
                $this->db->where('talep_id', $form_id);
                $this->db->update('talep_user_satinalma', $data_satinalma);
                //satınalma personelini şukufe yap

                $this->talep_history($form_id,$this->aauth->get_user()->id,'Talep Sened Aşamasına Alındı.');
                echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Tamamlandı"));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Yetkiniz Bulunmamaktadır."));
            }
        }
        else{
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Seçilen Satınalma Personeli Dışında Bu Aşamada Yetki Verilmemektedir"));
        }
    }
    public function avans_onay_iptal(){
        $this->db->trans_start();
        $result = $this->talep->avans_onay_iptal();
        if($result['status']){

            echo json_encode(array('status' => 'Success', 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>$result['message']));
        }
    }

    public function odeme_onay_iptal(){
        $this->db->trans_start();
        $result = $this->talep->odeme_onay_iptal();
        if($result['status']){

            echo json_encode(array('status' => 'Success', 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>$result['message']));
        }
    }
    public function confirm_status()
    {
        $this->db->trans_start();
        $form_id=$this->input->post('talep_id');
        $data_Form=array(
            'status'=>9,
        );
        //talep aşamasına al
        $this->db->set($data_Form);
        $this->db->where('id', $form_id);
        //talep aşamasına al
        if( $this->db->update('talep_form', $data_Form)){
            $this->talep_history($form_id,$this->aauth->get_user()->id,'Talep Tamamlandı Aşamasına Alındı.');
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Tamamlandı"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Yetkiniz Bulunmamaktadır."));
        }


    }
    public function test()
    {

        echo "<pre>";print_r((onaylanan_firma_list(4533)));die();
        $form_id=6;
        $cari_id=26;
        $data['form_id']=$form_id;
        $data['cari_id']=$cari_id;
        $teklif_id=0;
        $teklif = cari_to_teklif($cari_id,$form_id);
        if($teklif){
            $teklif_id = $teklif->id;
        }
        $data['teklif_id']=$teklif_id;

        $data['teklif_details']= $this->talep->teklif_details($teklif_id);
        $data['teklif_details_items']= $this->talep->teklif_details_items($data['teklif_details']->id);
        $data['discount_type']=$data['teklif_details']->discount_type;
        $data['kdv']=$data['teklif_details']->kdv;
        $data['para_birimi']=$data['teklif_details']->para_birimi;
        $data['teslimat_tutar']=$data['teklif_details_items']->teslimat_tutar;
        $data['method_id']=$data['teklif_details_items']->method;

        $data['teklif_kontrol']=teklif_update_kontrol($teklif_id);
        $data['items_']=techizatcilar_item($form_id,$cari_id);
        $data['para_birimi_details']=geopos_currencies_details($data['para_birimi']);
        $data['details']= $this->talep->details($form_id);
        $data['data_products']= $this->talep->product_details($form_id);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Malzame Talep Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('malzematalep/test',$data);
        $this->load->view('fixed/footer');
    }

    public function qaime_ajax(){
        $form_id=$this->input->post('form_id');
        $cari_id=$this->input->post('cari_id')[0];
        $data['form_details']=$this->talep->details($form_id);
        $data['form_id']=$form_id;
        $data['cari_id']=$cari_id;
        $teklif_id=0;
        $teklif = cari_to_teklif($cari_id,$form_id);
        if($teklif){
            $teklif_id = $teklif->id;
        }
        $data['teklif_id']=$teklif_id;

        $data['teklif_details']= $this->talep->teklif_details($teklif_id);
        $data['product_id_arr']= $this->input->post('product_id');
        $data['talep_form_product_id_arr']= $this->input->post('talep_form_product_id');
        $data['teklif_details_items']= $this->talep->teklif_details_items($data['teklif_details']->id);
        $data['discount_type']=$data['teklif_details']->discount_type;
        $data['kdv']=$data['teklif_details']->kdv;
        $data['para_birimi']=$data['teklif_details']->para_birimi;
        $data['teslimat_tutar']=$data['teklif_details_items']->teslimat_tutar;
        $data['method_id']=$data['teklif_details_items']->method;

        $data['teklif_kontrol']=teklif_update_kontrol($teklif_id);
        $data['items_']=techizatcilar_item($form_id,$cari_id);
        $data['para_birimi_details']=geopos_currencies_details($data['para_birimi']);
        $data['details']= $this->talep->details($form_id);
        $data['data_products']= $this->talep->product_details($form_id);
        $head['usernm'] = $this->aauth->get_user()->username;

        $view = $this->load->view('malzematalep/qaime_view',$data);
        echo json_encode(array('status' => 'Success', 'view' =>$view));

    }

    public function ajax_list(){

        $list = $this->talep->get_datatables_query_details_talep_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $status_details =progress_status_details($prd->progress_status_id);
            $transfer_status = transfer_status($prd->transfer_status);

            if($prd->status==7){
                if($prd->transfer_status!=0){
                    if(!$prd->transfer_bildirim){
                        $transfer_status=' <button type="button" class="btn btn-secondary btn-labeled btn-labeled-left rounded-pill transfer_bildirim" talep_id='.$prd->id.'><b><i class="icon-reading"></i></b>Bildirim Başlat</button>';
                    }
                    else {
                            if($prd->transfer_status==1){
                                $transfer_status='Transfer Bildirimi Başlatıldı';
                            }
                            elseif($prd->transfer_status==2){
                                $transfer_status='Transfer Yapıldı';
                            }
                    }
                }
             }


            $color = $status_details->color;
            $text_color = $status_details->text_color;

            $style = "background-color:$color;color:$text_color";

            $cancel = "<button class='btn btn-danger talep_sil' talep_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
            $view = "<a class='btn btn-success view' href='/malzemetalep/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";

            $staff_personel=mt_onay_pers($prd->id,$prd->status)['personel_name'];
            $staf_tarih=mt_onay_pers($prd->id,$prd->status)['tarih'];;

            $no++;
            $row = array();
            $row[] = $prd->code;
            $row[] = $prd->progress_name;
            $row[] = $prd->created_at;
            $row[] = $prd->pers_name;
            $row[] = $prd->proje_name;
            $row[] = "<span class='badge text-status' style='color: white;background-color: $prd->color'>$prd->st_name</span>";
            $row[]=$transfer_status;
            $row[]=$staff_personel;
            $row[]=$staf_tarih;
            $row[] =$view;
            $row[] =$style;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->talep->count_all_talep(),
            "recordsFiltered" => $this->talep->count_filtered_talep(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    function daysBetween($dt1, $dt2) {
        return date_diff(
            date_create($dt2),
            date_create($dt1)
        )->format('%a');
    }


    public function ajax_list_all_list(){


        $iptal_id=[];
        $user_id = $this->aauth->get_user()->id;
        $iptal_kontrols = $this->db->query("SELECT * FROM iptal_visable Where user_id = $user_id  and visable_date")->result();

        if($iptal_kontrols){
            foreach ($iptal_kontrols as $iptal_items){
                $old_date = $iptal_items->created_at;
                $now = date('Y-m-d');
                $sonuc =  $this->daysBetween($old_date,$now);
                if($sonuc > 1){
                        $iptal_id[]=$iptal_items->talep_id;
                }
            }
        }





        $list = $this->talep->get_datatables_query_details_talep_all_list($iptal_id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $status_details =progress_status_details($prd->progress_status_id);
            $transfer_status = transfer_status($prd->transfer_status);

            if($prd->status==7){
                if($prd->transfer_status!=0){
                    if(!$prd->transfer_bildirim){
                        $transfer_status=' <button type="button" class="btn btn-secondary btn-labeled btn-labeled-left rounded-pill transfer_bildirim" talep_id='.$prd->id.'><b><i class="icon-reading"></i></b>Bildirim Başlat</button>';
                    }
                    else {
                        if($prd->transfer_status==1){
                            $transfer_status='Transfer Bildirimi Başlatıldı';
                        }
                        elseif($prd->transfer_status==2){
                            $transfer_status='Transfer Yapıldı';
                        }
                    }
                }
            }


            $color = $status_details->color;
            $text_color = $status_details->text_color;

            $style = "background-color:$color;color:$text_color";

            $cancel = "<button class='btn btn-danger talep_sil' talep_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
            $view = "<a class='btn btn-success view' href='/malzemetalep/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";

            $staff_personel=mt_onay_pers($prd->id,$prd->status)['personel_name'];
            $staf_tarih=mt_onay_pers($prd->id,$prd->status)['tarih'];;

            $no++;
            $row = array();
            $row[] = $prd->code;
            $row[] = $prd->progress_name;
            $row[] = $prd->created_at;
            $row[] = $prd->pers_name;
            $row[] = $prd->proje_name;
            $row[] = "<span class='badge text-status' style='color: white;background-color: $prd->color'>$prd->st_name</span>";
            $row[]=$transfer_status;
            $row[]=$staff_personel;
            $row[]=$staf_tarih;
            $row[] =$view;
            $row[] =$style;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->talep->count_all_talep_all_list($iptal_id),
            "recordsFiltered" => $this->talep->count_filtered_talep_all_list($iptal_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_notes(){

        $talep_id=$this->input->post('talep_id');

        $list = $this->talep->get_datatables_query_details_talep_list_notes($talep_id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $cancel = "<button class='btn btn-danger notes_sil' talep_id='$talep_id'  notes_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
            $no++;
            $row = array();
            $row[] = $prd->created_at;
            $row[] = $prd->desc;
            $row[] = $prd->pers_name;
            $row[] =$cancel;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->talep->count_all_talep_notes($talep_id),
            "recordsFiltered" => $this->talep->count_filtered_talep_notes($talep_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_history(){

        $talep_id=$this->input->post('talep_id');

        $list = $this->talep->ajax_list_history($talep_id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $pers_name='';
            if($prd->type==1){
                $pers_name=personel_details($prd->user_id);
            }
            else {
                $pers_name=customer_details($prd->user_id)['company'];
            }

            $no++;
            $row = array();
            $row[] = $pers_name;
            $row[] = $prd->desc;
            $row[] = $prd->created_at;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->talep->count_all_talep_history($talep_id),
            "recordsFiltered" => $this->talep->count_filtered_talep_history($talep_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function teklif_incele_ajax(){
        $form_id=$this->input->post('form_id');
        $data['form_id']=$form_id;
        $data['details']= $this->talep->details($form_id);
        $data['data_products']= $this->talep->product_details($form_id);

        $view = $this->load->view('malzematalep/teklif_incele',$data);
        echo json_encode(array('status' => 'Success', 'view' =>$view));

    }

    public function teklif_onay_proje_muduru_onayi()
    {
        $this->db->trans_start();

        $form_id = $this->input->post('form_id');
        $user_id = $this->aauth->get_user()->id;


        if ($user_id!=61) {
            $this->db->trans_rollback();
            echo json_encode(['status' => 'Error', 'message' => 'Genel Müdür İçin Yapıılmış Bölümdür']);
            return;
        }

        // Talep detaylarını al
        $details = $this->talep->details($form_id);
        if (!$details) {
            $this->db->trans_rollback();
            echo json_encode(['status' => 'Error', 'message' => 'Talep bulunamadı']);
            return;
        }

        // Yetkili kontrolü
        $yetkili_kontrol = $this->db->query("SELECT * FROM `talep_onay_new` WHERE type=2 AND talep_id = ? AND user_id = ?", [$form_id, $user_id])->num_rows();
        if (!$yetkili_kontrol) {
            $this->db->trans_rollback();
            echo json_encode(['code' => 410, 'message' => 'Yetkiniz bulunmamaktadır']);
            return;
        }

        // Daha önce onay verilmiş mi kontrol
        $yetkili_kontrol_dublicate = $this->db->query("SELECT * FROM `talep_onay_new` WHERE type=2 AND talep_id = ? AND user_id = ? AND status IS NOT NULL", [$form_id, $user_id])->num_rows();
        if ($yetkili_kontrol_dublicate) {
            $this->db->set('status', null);
            $this->db->set('staff', 0);
            $this->db->set('updated_at', 'NOW()', false);
            $this->db->where('talep_id', $form_id);
            $this->db->where('type', 2);
            $this->db->where('user_id', $user_id);
            $this->db->update('talep_onay_new');
        }

        // Proje Müdürü onay kontrolü

        $prj_id = $details->proje_id;
        $proje_user_id =  $this->db->query("SELECT * FROM geopos_projects Where id=$prj_id")->row()->proje_muduru_id;
        $p_m_onay_kontrol = $this->db->query("SELECT * FROM `talep_onay_new` WHERE status=1 and  type=2 and user_id= ?  AND talep_id = ? ", [$proje_user_id,$form_id]);
        if (!$p_m_onay_kontrol->num_rows()) {
            $this->db->trans_rollback();
            echo json_encode(['code' => 410, 'message' => 'Proje Müdürü Onay Vermemiştir']);
            return;
        }

        // Depo seçimi kontrolü
        $pm_id = ($details->proje_id == 35) ? 62 : 66;
        $depo_kontrol = $this->db->query("SELECT * FROM `warehouse_teslimat` WHERE form_id = ? AND aauth_id = ?", [$form_id, $pm_id]);
        if ($depo_kontrol->num_rows() > 0) {
            foreach ($depo_kontrol->result() as $depo_item) {
                $data_teslimat_warehouse = [
                    'form_id' => $form_id,
                    'product_id' => $depo_item->product_id,
                    'qty' => $depo_item->qty ?? 0,
                    'teslim_edilecek_warehouse_id' => $depo_item->teslim_edilecek_warehouse_id,
                    'warehouse_desc' => $depo_item->warehouse_desc,
                    'status' => $depo_item->status,
                    'unit_id' => $depo_item->unit_id,
                    'warehouse_id' => $depo_item->warehouse_id,
                    'aauth_id' => $user_id,
                    'user_id' => $depo_item->user_id,
                    'cari_id' => $depo_item->cari_id,
                ];
                $this->db->insert('warehouse_teslimat', $data_teslimat_warehouse);
            }
        }

        // Teklif onay listesi kontrolü ve ekleme
        $teklif_onay_list_kontrol = $this->db->query("SELECT * FROM teklif_onay_list WHERE form_id = ? AND user_id = ? ORDER BY id DESC", [$form_id, $pm_id]);
        $index = 0;

        foreach ($teklif_onay_list_kontrol->result() as $items) {
            $data_insert = [
                'talep_form_teklifler_item_details_id' => $items->talep_form_teklifler_item_details_id,
                'warehouse_id' => $items->warehouse_id,
                'type' => $items->type,
                'user_id' => $user_id,
                'form_id' => $form_id,
                'product_id' => $items->product_id,
            ];
            $this->db->insert('teklif_onay_list', $data_insert);
            $index++;
        }

        // Onay işlemleri
        if ($index > 0) {
            $this->talep_history($form_id, $user_id, 'Ihaleye Onay Verildi');

            $next_approval = $this->db->query("SELECT * FROM `talep_onay_new` WHERE type=2 AND talep_id=? AND staff=0 AND status IS NULL ORDER BY id ASC LIMIT 1", [$form_id]);
            if ($next_approval->num_rows() > 0) {
                $next_id = $next_approval->row()->id;
                $this->db->set('staff', 1);
                $this->db->where('id', $next_id);
                $this->db->update('talep_onay_new');
            } else {
                $satinalma_personeli = $this->talep->talep_user_satinalma($form_id)->user_id;
                $data_Form = ['status' => 5];
                $this->db->where('id', $form_id);
                $this->db->update('talep_form', $data_Form);
            }

            $this->db->set('staff', 0);
            $this->db->set('status', 1);
            $this->db->set('updated_at', 'NOW()', false);
            $this->db->where('user_id', $user_id);
            $this->db->where('staff', 1);
            $this->db->where('type', 2);
            $this->db->where('talep_id', $form_id);
            $this->db->update('talep_onay_new');

            $this->db->trans_complete();
            echo json_encode(['status' => 'Success', 'message' => "Başarılı Bir Şekilde Onay Verildi"]);
        } else {
            $this->db->trans_rollback();
            echo json_encode(['status' => 'Error', 'message' => "Proje Müdürü Onay Vermemiştir."]);
        }
    }

    public function teklif_onay()
    {
        $this->db->trans_start();
        $form_id = $this->input->post('form_id');
        $data = $this->input->post('data');
        $user_id = $this->aauth->get_user()->id;
        $details = $this->talep->details($form_id);

        $query = $this->db->query(
            "SELECT sort,id FROM talep_onay_new WHERE talep_id = ? AND user_id = ? AND status IS NULL AND staff = 1 AND type = 2",
            [$form_id, $user_id]
        );

        $sort = $query->row() ? $query->row()->sort : null;
        $onay_id = $query->row() ? $query->row()->id : null;



        // Yetki kontrolü
        $yetkili_kontrol = $this->db->query(
            "SELECT * FROM `talep_onay_new` WHERE  id = ?",
            [$onay_id]
        )->num_rows();

        if (!$yetkili_kontrol) {
            $this->db->trans_rollback();
            echo json_encode(['status' => 'Error', 'message' => "Onaylamak için yetkiniz bulunmamaktadır"]);
            return;
        }

        // Değişikliklerin temizlenmesi
        $this->clean_previous_approvals($form_id, $user_id,$onay_id,$sort);

        $index = 0;
        $productlist = [];
        $warehouse_pers_id = [];
        $cari_product_id = [];

        foreach ($data as $value) {
            $talep_form_teklifler_item_details_id = $value['talep_form_teklifler_item_details_id'];

            // Ürün tipi kontrolü
            $product_type = $this->get_product_type($talep_form_teklifler_item_details_id);

            if ($product_type == 2) { // Cari teklif ürünü
                $cari_product_id[] = $value['product_id'];
            }

            // Teklif onay listesi için veri hazırlama
            $productlist[$index] = [
                'talep_form_teklifler_item_details_id' => $talep_form_teklifler_item_details_id,
                'user_id' => $user_id,
                'type' => 1,
                'form_id' => $form_id,
                'product_id' => $value['product_id'],
            ];
            $index++;
        }

        // Teklif onay listesini ekle
        if ($index > 0) {
            $this->talep_history($form_id, $user_id, 'Ihaleye Onay Verildi');
            $this->db->insert_batch('teklif_onay_list', $productlist);

            // Depo bilgisi varsa mesaj gönder
            if ($warehouse_pers_id) {
                $mesaj = $details->code . ' Numaralı Malzeme Talep Formunun Bazı Ürünleri Depo Tarafından Verilecektir.';
                // $this->send_mail_arr($warehouse_pers_id, 'Depo Bilgilendirme', $mesaj);
            }

            $this->handle_next_approval($form_id, $details, $cari_product_id,$onay_id);
        } else {
            $this->db->trans_rollback();
            echo json_encode(['status' => 'Error', 'message' => "Hata Aldınız. Lütfen Yöneticiye Başvurun."]);
        }

        $this->db->trans_complete();
        echo json_encode(['status' => 'Success', 'message' => "Başarılı Bir Şekilde Onay Verildi"]);
    }

    private function clean_previous_approvals($form_id, $user_id,$onay_id,$sort)
    {
        $this->db->delete('teklif_onay_list', ['form_id' => $form_id, 'user_id' => $user_id]);
        $this->db->delete('warehouse_teslimat', ['form_id' => $form_id, 'aauth_id' => $user_id]);

// İlk sorgu: Mevcut onay işlemini güncelle
        $this->db->set('status', 1);
        $this->db->set('staff', 0);
        $this->db->set('updated_at', "NOW()", false);
        $this->db->where('id', $onay_id);
        $this->db->update('talep_onay_new');

// Güncellenen kaydın sort değerini al
        $current_sort_query = $this->db->query("SELECT sort FROM talep_onay_new WHERE id = ?", [$onay_id]);
        $current_sort = $current_sort_query->row() ? $current_sort_query->row()->sort : null;

        if ($current_sort !== null) {
            // Bir sonraki sort değerini kontrol et
            $next_sort = $current_sort + 1;
            $next_sort_query = $this->db->query(
                "SELECT id FROM talep_onay_new WHERE sort = ? AND talep_id = ? and sort = ?",
                [$next_sort, $form_id,$sort]
            );

            if ($next_sort_query->num_rows() > 0) {
                // Bir sonraki sort değeri varsa, staff değerini 1 olarak güncelle
                $next_id = $next_sort_query->row()->id;
                $this->db->set('staff', 1);
                $this->db->where('id', $next_id);
                $this->db->update('talep_onay_new');
            }
        }
    }

    private function get_product_type($talep_form_teklifler_item_details_id)
    {
        $query = $this->db->query(
            "SELECT talep_form_products.* 
        FROM `talep_form_teklifler_item_details` 
        INNER JOIN talep_form_products ON talep_form_teklifler_item_details.tfitem_id = talep_form_products.id 
        WHERE talep_form_teklifler_item_details.id = ?",
            [$talep_form_teklifler_item_details_id]
        );

        return $query->row()->product_type ?? null;
    }

    private function handle_next_approval($form_id, $details, $cari_product_id,$onay_id)
    {
        $new_id_control = $this->db->query(
            "SELECT * FROM `talep_onay_new` 
        WHERE type = 2 AND talep_id = ? AND (status IS NULL) 
        ORDER BY id ASC LIMIT 1",
            [$form_id]
        );

        if ($new_id_control->num_rows() > 0) {
            $new_id = $new_id_control->row()->id;
            $this->db->set('staff', 1);
            $this->db->where('id', $new_id);
            $this->db->update('talep_onay_new');
        } else {
            $this->db->set(['status' => 5]);
            $this->db->where('id', $form_id);
            $this->db->update('talep_form');

            if ($cari_product_id) {
                $this->insert_cari_products($form_id, $cari_product_id);
            }
        }
    }

    private function insert_cari_products($form_id, $cari_product_id)
    {
        foreach ($cari_product_id as $pid) {
            $details_cari_prd = $this->db->query("SELECT * FROM `cari_products` WHERE id = ?", [$pid])->row();
            $data_insert_products = [
                'product_name' => $details_cari_prd->product_name,
                'unit' => $details_cari_prd->unit_id,
                'form_id' => $form_id,
            ];

            $this->db->insert('geopos_products', $data_insert_products);
            $last_id = $this->db->insert_id();

            $data_product_update = ['new_product_id' => $last_id];
            $this->db->set($data_product_update);
            $this->db->where('product_id', $pid);
            $this->db->where('product_type', 2);
            $this->db->update('talep_form_products');
        }
    }


    public function teklif_incele($form_id)
    {
        $data['form_id']=$form_id;
        $data['details']= $this->talep->details($form_id);
        $data['data_products']= $this->talep->product_details($form_id);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Malzame Talep Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('malzematalep/teklif_incele',$data);
        $this->load->view('fixed/footer');
    }

    public function teklif_update_view()
    {
        $cari_id=$this->input->get('cari_id');
        $form_id=$this->input->get('form_id');
        $data['items_']=techizatcilar_item($form_id,$cari_id);
        $data['cari_id']=$cari_id;
        $data['form_id']=$form_id;
        $data['details']= $this->talep->details($form_id);

        $teklif_id=0;
        $details_id=0;
        $teklif = cari_to_teklif($cari_id,$form_id);
        if($teklif){
            $teklif_id = $teklif->id;

            $details_id_res =$this->db->query("Select * From talep_form_teklifler_details Where tf_teklif_id=$teklif_id");
            if($details_id_res->num_rows()){
                $details_id = $details_id_res->row()->id;
            }
        }

        $data['teklif_id']=$teklif_id;

        $data['teklif_details']= $this->talep->teklif_details($teklif_id);



        $data['teklif_kontrol']=teklif_update_kontrol($teklif_id);
        $data['details_id']=$details_id;




        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Malzame Talep Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('malzematalep/teklif_update_view',$data);
        $this->load->view('fixed/footer');
    }

    public function product_price_details_add(){
        $this->db->trans_start();
        $result = $this->talep->product_price_details_add();
        if($result['status']){
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Eklendi"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }
    }


    public function create_save(){
        //if ($this->aauth->get_user()->roleid == 2) {

        $user_id = $this->aauth->get_user()->id;
        $user_id_arr=[39,66,832,1096,1116,1149,900,664,75,522,603,820,1008];
        if (in_array($user_id, $user_id_arr)) {

            $this->db->trans_start();
            $result = $this->talep->create_save();
            if ($result['status']) {
                echo json_encode(array('status' => 200, 'message' => "Başarılı Bir Şekilde Talep Oluşturuldu", 'index' => '/malzemetalep/view/' . $result['id']));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun." . ' Hata '));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => "Yetkiniz Yoktur. Proje Yetkilileri Talep Açabilir."));
        }

//        else {
//            $this->db->trans_rollback();
//            echo json_encode(array('status' => 410, 'message' => "Talep Açma Yetkiniz Bulunmamaktadır."));
//        }

    }

    public function transfer_bildirimi(){
        $this->db->trans_start();
        $result = $this->talep->transfer_bildirimi();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }


    }

    public function transfer_status_change(){
        if (!$this->aauth->premission(31)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->talep->transfer_status_change();
            if($result['status']){
                echo json_encode(array('status' => 200, 'message' =>$result['message']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }


    }
    public function transaction_create(){
        $this->db->trans_start();
        $result = $this->talep->transaction_create();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['messages']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['messages']));
        }
    }

    public function avans_create(){
        $this->db->trans_start();
        $result = $this->talep->avans_create();
        if($result['status']){
            echo json_encode(array('status' => 'Success', 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>$result['message'].' Hata '));
        }
    }

    public function odeme_create(){
        $this->db->trans_start();
        $result = $this->talep->odeme_create();
        if($result['status']){
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Talep Oluşturuldu",));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }
    }
    public function create_save_notes(){
        $this->db->trans_start();
        $result = $this->talep->create_save_notes();
        if($result['status']){

            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Notunuz Oluşturuldu"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }
    public function create_form_items(){
        $this->db->trans_start();
        $result = $this->talep->create_form_items();
        if($result['status']){

            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Kayıt Edildi",'product_name'=>$result['product_name'],'qyt_birim'=>$result['qyt_birim'],'id'=>$result['id'],'option_html'=>$result['option_html'],'talep_form_products_id'=>$result['talep_form_products_id']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }
    }

    public function create_form_items_gider(){
        $this->db->trans_start();
        $result = $this->talep->create_form_items_gider();
        if($result['status']){

            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Kayıt Edildi",'product_name'=>$result['product_name'],'qyt_birim'=>$result['qyt_birim'],'id'=>$result['id'],'talep_form_products_id'=>$result['talep_form_products_id']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }
    }

    public function form_cari_list_create(){
        $this->db->trans_start();
        $result = $this->talep->form_cari_list_create();
        if($result['status']){

            echo json_encode(array('status' => 'Success', 'message' =>$result['messages'],'cari_phone'=>$result['cari_phone'],'cari_name'=>$result['cari_name'],'cari_id'=>$result['cari_id']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>$result['messages']));
        }
    }

    public function update_form(){
        if (!$this->aauth->premission(31)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->talep->update_form();
            if($result['status']){

                echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Güncellendi"));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
            }
        }

    }

    public function status_upda(){
        if (!$this->aauth->premission(31)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $file_id = $this->input->post('file_id');
            $desc = $this->input->post('desc');
            $details_ = $this->talep->details($file_id);

            $result = $this->talep->status_upda();
            if($result['status']){

                echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Güncellendi"));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
            }
        }



    }

    public function view($id)
    {
        if (!$this->aauth->premission(31)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }

        $data['details']= $this->talep->details($id);

        $data['note_list']=new_list_note(7,$id);
        if (! $data['details']) {

            exit('<h3>Talep Bulunamadı</h3>');

        }

        $data['talep_in']=$this->db->query("SELECT * FROM talep_form_products Where move_talep_id and form_id = $id")->num_rows();
        $data['talep_out']=$this->db->query("SELECT * FROM talep_form_products Where move_talep_id=$id")->num_rows();
        $data['cat'] = $this->categories_model->category_list();
        $data['ana_kategoriler'] = $this->categories_model->category_list_();
        $data['alt_kat'] = $this->categories_model->alt_kat();
        $users = $this->talep->talep_form_users($id);
        $user_=[];
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Malzame Talep Listesi';

        $data['items']= $this->talep->product_details($id);
        $data['data_products']= $this->talep->product_details($id);
        $data['ihale_time']= $this->talep->ihale_time($id);
        $data['talep_user_satinalma']= $this->talep->talep_user_satinalma($id);
        $data['file_details']= $this->talep->file_details($id);
        if($users){
            foreach ($users as $items){
                $user_[]=$items->user_id;
            }
        }
        $data['users_details']= $user_;
        $this->load->view('fixed/header', $head);
        $this->load->view('malzematalep/view',$data);
        $this->load->view('fixed/footer');
    }


    public function get_all_users(){
        $id = $this->input->post('talep_id');
        $users = $this->talep->talep_form_users($id);
        echo json_encode(array('status' => 'Success', 'users' =>$users));
    }

    public function upload_file(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $image_text = $this->input->post('image_text');
        $data_images = array(
            'user_id' => $this->aauth->get_user()->id,
            'image_text' => $image_text,
            'form_id' => $id,
        );
        if($this->db->insert('talep_form_files', $data_images)){
            $this->aauth->applog("Malzame Talebine File Yüklendi  : Talep ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Yüklendi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }

    }

    public function delete_file(){
        $this->db->trans_start();
        $id = $this->input->post('file_id');
        if($this->db->delete('talep_form_files', array('id' => $id))){
            $this->aauth->applog("Malzame Talebinden File Silindi  : File ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Silindi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }

    }

    public function notes_delete(){
        $this->db->trans_start();
        $id = $this->input->post('notes_id');
        $details = $this->db->query("SELECT * FROM talep_form_notes WHERE id=$id ");
        if($details->num_rows()){
            if($details->row()->aaut_id == $this->aauth->get_user()->id){
                if($this->db->delete('talep_form_notes', array('id' => $id))){
                    $this->aauth->applog("Malzame Talebinden Note Silindi  : File ID : ".$id, $this->aauth->get_user()->username);
                    $this->db->trans_complete();
                    echo json_encode(array('status' => 'Success','message'=>'Başarıyla Silindi'));
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
                }
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Notu Oluşturan Personelden Başkası Silemez!."));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Böyle Bir Not Bulunamadı."));
        }


    }

    public function delete_item_form(){
        $this->db->trans_start();
        $id = $this->input->post('item_id');
        $details = $this->db->query("SELECT * FROM talep_form_products Where id=$id")->row();
        $type = $this->input->post('type');
        $talep_type  = $this->talep->details($details->form_id)->talep_type;

        if($talep_type==3){
            $product_name = who_demirbas($details->product_id)->name;
        }
        else {
            $product_name = product_details_($details->product_id)->product_name;
        }

        if($type==1){
            $this->talep_history($details->form_id,$this->aauth->get_user()->id,$product_name.' Ürünü Kaldırıldı');
        }

        if($this->db->delete('talep_form_products', array('id' => $id))){

            $this->db->delete('talep_form_products_options', array('talep_form_product_id' => $id));
            $this->aauth->applog("Malzame Talebinden Ürün Silindi  :  ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Silindi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }

    }
    public function delete_cari_form(){
        $this->db->trans_start();
        $id = $this->input->post('item_id');
        $talep_id = $this->input->post('talep_id');
        $details = $this->talep->details($talep_id);

        $customer_details=customer_details($id);

        $this->talep_history($talep_id,$this->aauth->get_user()->id,$customer_details['company'].' Carisi Kaldırıldı');

        if($this->db->delete('talep_form_cari', array('cari_id' => $id,'talep_id'=>$talep_id))){
            $this->aauth->applog("Malzame Talebinden Cari Silindi  :  ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Silindi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }

    }

    public function yetkili_kontrol(){
        $id = $this->input->post('talep_id');
        $type = $this->input->post('type');
        $user_id = $this->aauth->get_user()->id;
        $roleid = $this->aauth->get_user()->roleid;
        $details = $this->talep->details($id);
        if($type==2) //satınalam için
        {
            $talep_kontrol  = $this->db->query("SELECT * FROM `talep_user_satinalma` where talep_id=$id and user_id=$user_id")->num_rows();
            if($talep_kontrol || $user_id==21){
                echo json_encode(array('status' => 'Success','message'=>'Yetki MEvcut'));
            }
            else{
                echo json_encode(array('status' => 'Error', 'message' =>"Seçilen Satınalma Personeli Dışında Bu Aşamada Yetki Verilmemektedir"));
            }
        }

        if($type==3) //sadece genel müdür kontrolü
        {

            $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $details->proje_id and  genel_mudur_id=$user_id")->num_rows();
            if($yetkili_kontrol){
                echo json_encode(array('status' => 'Success','message'=>'Yetki MEvcut'));
            }
            else{
                echo json_encode(array('status' => 'Error', 'message' =>"Seçilen Satınalma Personeli Dışında Bu Aşamada Yetki Verilmemektedir"));
            }
        }

        elseif($type==4) //sadece depo Kontrolü
        {
            $warehouse_details = talep_warehouse_details($id);

            if($warehouse_details->pers_id==$user_id){
                echo json_encode(array('status' => 'Success','message'=>'Yetki MEvcut'));
            }
            else{
                echo json_encode(array('status' => 'Error', 'message' =>"Seçilen Depo Personeli Dışında Bu Aşamada Yetki Verilmemektedir"));
            }
        }

        elseif($type==5) //muhasebe kullanıcısı
        {
            $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $details->proje_id and  muhasebe_muduru_id=$user_id")->num_rows();
            if($yetkili_kontrol || $this->aauth->get_user()->id==39 || $this->aauth->get_user()->id==21 || $this->aauth->get_user()->id==1135 || $this->aauth->get_user()->id==174){
            //if($roleid==1 || $roleid==2 || $roleid==4){
                echo json_encode(array('status' => 'Success','message'=>'Yetki MEvcut'));
            }
            else{
                echo json_encode(array('status' => 'Error', 'message' =>"Seçilen Muhasebe Personeli Dışında Bu Aşamada Yetki Verilmemektedir"));
            }
        }
    }

    public function onay_olustur_stok_kontrol(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $details = $this->talep->details($id);
        $type = $this->input->post('type');
        $onay_new_list = $this->input->post('onay_new_list');
        if($onay_new_list){
            $sort = $this->db->query("SELECT * FROM `talep_onay_new` Where type=3 and talep_id=$id  ORDER BY `sort` DESC LIMIT 1")->row()->sort;

            foreach ($onay_new_list as $items_users){
                $staff=0;
                $data_onay = array(
                    'talep_id' => $id,
                    'type' => 3,
                    'staff' => $staff,
                    'sort' => $sort,
                    'user_id' => $items_users,
                );
                $this->db->insert('talep_onay_new', $data_onay);
                $sort++;
            }
        }



        $new_id=0;
        $new_user_id=0;
        $new_id_control = $this->db->query("SELECT * FROM `talep_onay_new` Where type=$type and talep_id=$id and staff=0 and status is Null ORDER BY `talep_onay_new`.`id` ASC LIMIT 1");
        if($new_id_control->num_rows()){
            $new_id = $new_id_control->row()->id;
            $new_user_id = $new_id_control->row()->user_id;
        }


        $data_post = array(
            'status' => 1,
            'staff' => 0,
        );


        $this->db->where('user_id',$this->aauth->get_user()->id);
        $this->db->where('staff',1);
        $this->db->where('type',$this->input->post('type'));
        $this->db->set($data_post);
        $this->db->where('talep_id', $this->input->post('talep_id'));
        if ($this->db->update('talep_onay_new', $data_post)) {

            $this->talep_history($id,$this->aauth->get_user()->id,'Stok Kontrolüne Onay Verildi');
            if($new_id){

                // bildirim maili at
                $mesaj=$details->code.' Numaralı Malzeme Talep Formu Onayınızı Beklemektedir';
               // $this->send_mail($new_user_id,'Malzeme Talep Onayı',$mesaj);
                // bildirim maili at
                $user_phone = personel_details_full($new_user_id)['phone'];
                //$this->mesaj_gonder($user_phone,$details->code.' Malzeme Talebi Onayınızı Beklemektedir.');
                // Bir Sonraki Onay
                $data_new=array(
                    'staff'=>1,
                );
                $this->db->where('id',$new_id);
                $this->db->set($data_new);
                $this->db->update('talep_onay_new', $data_new);
                // Bir Sonraki Onay
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success','message'=>'Başarıyla Bildirim Başlatıldı'));

            }
            else {

                $data_form = array(
                    'bildirim_durumu' => 1,
                    'status' => 1,
                );
                $this->db->set($data_form);
                $this->db->where('id', $id);
                if ($this->db->update('talep_form', $data_form)) {

                    $users__talep = onay_sort(7,$details->proje_id,0,$id);

                    if($users__talep){
                        foreach ($users__talep as $items_talep){
                            $staff=0;
                            if($items_talep['sort']==1){

                                $staff=1;
                            }

                            $data_onay = array(
                                'talep_id' => $id,
                                'type' => 1,
                                'staff' => $staff,
                                'sort' => $items_talep['sort'],
                                'user_id' => $items_talep['user_id'],
                            );
                            $this->db->insert('talep_onay_new', $data_onay);
                        }

                        // bildirim maili at
                        $mesaj=$details->code.' Numaralı Malzeme Talep Formu Onayınızı Beklemektedir';
                       // $this->send_mail($items_talep['user_id'],'Malzeme Talep Onayı',$mesaj);
                        // bildirim maili at
                        $user_phone = personel_details_full($items_talep['user_id'])['phone'];
                        //$this->mesaj_gonder($user_phone,$details->code.' Malzeme Talebi Onayınızı Beklemektedir.');

                        $this->talep_history($id,$this->aauth->get_user()->id,'Onay İşlemi Başlatıldı');
                        //kont_kayit(21,$id);
                        $this->aauth->applog("Malzame Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);

                        //proje stoklarına ekle
                        $product_details_items = $this->talep->details_items($id);
                        if($product_details_items){
                            foreach ($product_details_items as $product){
                                if($details->talep_type!=3){
                                    $proje_stoklari_kontrol = $this->db->query("SELECT * FROM proje_stoklari Where product_id=$product->product_id and product_stock_code_id=$product->product_stock_code_id");
                                    if($proje_stoklari_kontrol->num_rows())
                                    {
                                        $proje_stoklari_id = $proje_stoklari_kontrol->row()->id;
                                        $talep_form_item= array(
                                            'proje_stoklari_id' => $proje_stoklari_id,
                                        );
                                        $this->db->set($talep_form_item);
                                        $this->db->where('id', $product->id);
                                        $this->db->update('talep_form_products', $talep_form_item);


                                        $talep_form_qty= array(
                                            'qty' => ($proje_stoklari_kontrol->row()->qty+$product->product_qty),
                                        );
                                        $this->db->set($talep_form_qty);
                                        $this->db->where('id', $proje_stoklari_id);
                                        $this->db->update('proje_stoklari', $talep_form_qty);

                                    }
                                    else {
                                        //yeni ürün eklnmiş demektir proje stoklarına insert
                                        $product_stock_code_id=$product->product_stock_code_id;
                                        $data = array(
                                            'proje_id' => $details->proje_id,
                                            'product_id' => $product->product_id,
                                            'product_stock_code_id'=>$product_stock_code_id,
                                            'product_desc'=>$product->product_desc,
                                            'unit_id' => $product->unit_id,
                                            'qty' => $product->product_qty,
                                            'unit_price' => 0,
                                            'bolum_id' => $details->bolum_id,
                                            'asama_id' => $details->asama_id,
                                            'tip' => 1,
                                            'aauth_id' => $this->aauth->get_user()->id
                                        );

                                        $this->db->insert('proje_stoklari', $data);
                                        $last_id = $this->db->insert_id();

                                        $talep_form_item= array(
                                            'proje_stoklari_id' => $last_id,
                                        );
                                        $this->db->set($talep_form_item);
                                        $this->db->where('id', $product->id);
                                        $this->db->update('talep_form_products', $talep_form_item);

                                        //yeni ürün eklnmiş demektir proje stoklarına insert
                                    }
                                }

                            }
                        }
                        //proje stoklarına ekle

                        $this->db->trans_complete();
                        echo json_encode(array('status' => 'Success','message'=>'Başarıyla Bildirim Başlatıldı'));

                    }
                    else {

                        echo json_encode(array('status' => 'Error', 'message' =>"Projenize Yetkili Kişiler Atanmamıştır veya Seçilen Depoya Yetkili Tanımlanmamıştır.Bu Sebeple İşlem Yapamazsınız."));
                        $this->db->trans_rollback();

                    }

                    //Satınalma İse

                    if($type==2){
                        $data_type= array(
                            'status' => 4,
                        );
                        $this->db->set($data_type);
                        $this->db->where('id', $id);
                        $this->db->update('talep_form', $data_type);

                        //Satınalma İse
                        $this->talep_history($id,$this->aauth->get_user()->id,'Onay İşlemi Başlatıldı');
                        $this->aauth->applog("Malzame Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);
                        $this->db->trans_complete();
                        echo json_encode(array('status' => 'Success','message'=>'Başarıyla Bildirim Başlatıldı'));
                    }


                }
                else {

                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
                }
            }

//            $this->aauth->applog("Malzame Talebine Onay Verildi :  ID : ".$id, $this->aauth->get_user()->username);
//            $this->db->trans_complete();
//            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Onay Verildi'));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));

        }

    }
    public function onay_olustur()
    {
        $this->db->trans_start();

        $id = $this->input->post('talep_id');
        $sort = $this->input->post('sort');
        $progress_status_id = $this->input->post('progress_status_id');
        $type = $this->input->post('type');
        $product_details = $this->input->post('product_details');
        $satinalma_personeli = $this->input->post('satinalma_personeli');
        $auth_id = $this->aauth->get_user()->id;

        // Kullanıcının onay yetkisini kontrol et
        if (!$this->checkSortPermission($id, $auth_id, $sort, $type)) {
            $this->errorResponse("Doğru Tercih Yapmadınız Sayfa Yenilemesi Yapınız.");
            return;
        }

        // Ürün miktarlarını ve talep durumunu güncelle
        foreach ($product_details as $item) {
            $this->updateProductDetails($item, $progress_status_id, $id);
        }

        // Satınalma personelini güncelle
        $this->updateSatinalmaPersoneli($satinalma_personeli, $id);

        // Mevcut onay adımını tamamla
        $this->completeCurrentSort($id, $auth_id, $sort, $type);

        // Bir sonraki onay adımını başlat
        $next_sort = $sort + 1;
        if ($this->startNextSort($id, $next_sort, $type)) {
            $this->successResponse("Başarıyla Onay Verildi");
        } else {
            $this->finalizeApproval($id, $satinalma_personeli);
            $this->successResponse("Başarıyla Onay Verildi");
        }

        $this->db->trans_complete();
    }

    private function checkSortPermission($id, $auth_id, $sort, $type)
    {
        $query = $this->db->query(
            "SELECT * FROM talep_onay_new WHERE talep_id = ? AND user_id = ? AND status IS NULL AND staff = 1 AND sort = ? AND type = ?",
            [$id, $auth_id, $sort, $type]
        );

        return $query->num_rows() > 0;
    }

    private function updateProductDetails($item, $progress_status_id, $id)
    {
        $item_id = $item['item_id'];
        $item_qty = $item['item_qty'];

        $data_item_update = ['product_qty' => $item_qty];
        $this->db->where('id', $item_id);
        $this->db->update('talep_form_products', $data_item_update);

        $progress_status_details = progress_status_details($progress_status_id);

        $data_talep_update = ['progress_status_id' => $progress_status_id];
        $this->db->where('id', $id);
        $this->db->update('talep_form', $data_talep_update);

        $this->talep_history($id, $this->aauth->get_user()->id, "Ürünün yeni miktarı: $item_qty, Yeni Durum: {$progress_status_details->name}");
    }

    private function updateSatinalmaPersoneli($satinalma_personeli, $id)
    {
        $this->db->delete('talep_user_satinalma', ['talep_id' => $id]);

        $data_satinalma = [
            'user_id' => $satinalma_personeli,
            'talep_id' => $id,
        ];
        $this->db->insert('talep_user_satinalma', $data_satinalma);
    }

    private function completeCurrentSort($id, $auth_id, $sort, $type)
    {
        $data = [
            'status' => 1,
            'staff' => 0,
        ];

        $this->db->where('user_id', $auth_id);
        $this->db->where('staff', 1);
        $this->db->where('status', null, false);
        $this->db->where('sort', $sort);
        $this->db->where('type', $type);
        $this->db->where('talep_id', $id);
        $this->db->update('talep_onay_new', $data);

        $this->talep_history($id, $auth_id, 'Onay Verildi');
    }

    private function startNextSort($id, $next_sort, $type)
    {
        $query = $this->db->query(
            "SELECT * FROM talep_onay_new WHERE type = ? AND talep_id = ? AND sort = ? AND status IS NULL ORDER BY id ASC LIMIT 1",
            [$type, $id, $next_sort]
        );

        if ($query->num_rows() > 0) {
            $next_sort_data = $query->row();

            $data_new = ['staff' => 1];
            $this->db->where('id', $next_sort_data->id);
            $this->db->update('talep_onay_new', $data_new);

            // Bildirim ve mail gönderme işlemi
            $details = $this->talep->details($id);
            $mesaj = "{$details->code} Numaralı Malzeme Talep Formu Onayınızı Beklemektedir.";
            // $this->send_mail($next_sort_data->user_id, 'Malzeme Talep Onayı', $mesaj);

            return true;
        }

        return false;
    }

    private function finalizeApproval($id, $satinalma_personeli)
    {
        $details = $this->talep->details($id);
        $mesaj = "{$details->code} Numaralı Malzeme Talep Formu Onaylanmıştır. İhale İşlemlerine Başlayabilirsiniz";

        if ($this->send_mail($satinalma_personeli, 'İhale Emri', $mesaj)) {
            $data_sf = ['status' => 1];
            $this->db->where('talep_id', $id);
            $this->db->update('talep_user_satinalma', $data_sf);

            $data_form = ['status' => 2];
            $this->db->where('id', $id);
            $this->db->update('talep_form', $data_form);
        }
    }

    private function errorResponse($message)
    {
        $this->db->trans_rollback();
        echo json_encode(['status' => 'Error', 'message' => $message]);
    }

    private function successResponse($message)
    {
        echo json_encode(['status' => 'Success', 'message' => $message]);
    }

    public function stock_qty_warehouse_products(){
       echo "<pre>"; print_r(stock_qty_warehouse_products(7));
    }

    public function new_form_bildirim_olustur(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $type = $this->input->post('type');
        $user_id=$this->aauth->get_user()->id;
        if($type==1){


            $talep_kontrol  = $this->db->query("SELECT * FROM `talep_form` where id=$id and aauth=$user_id")->num_rows();
            if($talep_kontrol){
                $details = $this->talep->details($id);

                if(!isset($details->warehouse_id)){
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Depo Seçmeniz Gerekmektedir."));
                }
                else {
                    $data = array(
                        'bildirim_durumu' => 1,
                    );
                    $this->db->set($data);
                    $this->db->where('id', $id);
                    if ($this->db->update('talep_form', $data)) {

                        $users_ = onay_sort(7,$details->proje_id,0,$id);

                        if($users_){
                            foreach ($users_ as $items){
                                $staff=0;
                                if($items['sort']==1){

                                    $staff=1;
                                }

                                $data_onay = array(
                                    'talep_id' => $id,
                                    'type' => $type,
                                    'staff' => $staff,
                                    'sort' => $items['sort'],
                                    'user_id' => $items['user_id'],
                                );
                                $this->db->insert('talep_onay_new', $data_onay);
                            }

                            // bildirim maili at
                            $mesaj=$details->code.' Numaralı Malzeme Talep Formu Onayınızı Beklemektedir';
                            //$this->send_mail($items['user_id'],'Malzeme Talep Onayı',$mesaj);
                            // bildirim maili at
                            $user_phone = personel_details_full($items['user_id'])['phone'];
                            //$this->mesaj_gonder($user_phone,$details->code.' Malzeme Talebi Onayınızı Beklemektedir.');

                            $this->talep_history($id,$this->aauth->get_user()->id,'Onay İşlemi Başlatıldı');
                            $this->aauth->applog("Malzame Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);
                            $this->db->trans_complete();

                            //kont_kayit(21,$id);
                            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Bildirim Başlatıldı'));

                        }
                        else {

                            echo json_encode(array('status' => 'Error', 'message' =>"Projenize Yetkili Kişiler Atanmamıştır veya Seçilen Depoya Yetkili Tanımlanmamıştır.Bu Sebeple İşlem Yapamazsınız."));
                            $this->db->trans_rollback();

                        }

                        //Satınalma İse

                        if($type==2){
                            $data_type= array(
                                'status' => 4,
                            );
                            $this->db->set($data_type);
                            $this->db->where('id', $id);
                            $this->db->update('talep_form', $data_type);

                            //Satınalma İse
                            $this->talep_history($id,$this->aauth->get_user()->id,'Onay İşlemi Başlatıldı');
                            $this->aauth->applog("Malzame Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);
                            $this->db->trans_complete();
                            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Bildirim Başlatıldı'));
                        }


                    }
                    else {

                        $this->db->trans_rollback();
                        echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
                    }
                }

            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Yetkiniz Bulunmamaktadır."));
            }
        }
        elseif($type==2){
            $talep_kontrol  = $this->db->query("SELECT * FROM `talep_user_satinalma` where talep_id=$id and user_id=$user_id")->num_rows();
            if($talep_kontrol){
                $details = $this->talep->details($id);
                $data = array(
                    'bildirim_durumu' => 1,
                );
                $this->db->set($data);
                $this->db->where('id', $id);
                if ($this->db->update('talep_form', $data)) {

                    $users_ = onay_sort(1,$details->proje_id,$id);
                    if(!$users_){
                        $this->db->trans_rollback();
                        echo json_encode(array('status' => 'Error', 'message' =>"Projenize Yetkili Kişiler Atanmamıştır.Bu Sebeple İşlem Yapamazsınız."));
                    }
                    else {
                        foreach ($users_ as $items){
                            $staff=0;
                            if($items['sort']==1){

                                $staff=1;
                            }
                            $data_onay = array(
                                'talep_id' => $id,
                                'type' => $type,
                                'staff' => $staff,
                                'sort' => $items['sort'],
                                'user_id' => $items['user_id'],
                            );
                            $this->db->insert('talep_onay_new', $data_onay);
                        }
                    }

                    //Satınalma İse

                    if($type==2){
                        $data_type= array(
                            'status' => 4,
                        );
                        $this->db->set($data_type);
                        $this->db->where('id', $id);
                        $this->db->update('talep_form', $data_type);
                    }

                    //Satınalma İse
                    $this->talep_history($id,$this->aauth->get_user()->id,'Onay İşlemi Başlatıldı');
                    $this->aauth->applog("Malzame Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);
                    $this->db->trans_complete();
                    echo json_encode(array('status' => 'Success','message'=>'Başarıyla Bildirim Başlatıldı'));
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
                }
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Yetkiniz Yoktur."));
            }
        }



    }

    public function form_bildirim_olustur()
    {
        $this->db->trans_start();

        $id = $this->input->post('talep_id');
        $type = $this->input->post('type');
        $user_id = $this->aauth->get_user()->id;

        if ($type == 1) {
            $this->handleType1Notification($id, $user_id);
        } elseif ($type == 2) {
            $this->handleType2Notification($id, $user_id);
        }

        $this->db->trans_complete();
    }

    private function handleType1Notification($id, $user_id)
    {
        $talep_kontrol = $this->db->query("SELECT * FROM `talep_form` WHERE id = ? AND aauth = ?", [$id, $user_id])->num_rows();

        if (!$talep_kontrol) {
            $this->errorResponse("Yetkiniz Bulunmamaktadır.");
            return;
        }

        $bildirim_kontrol = $this->db->query("SELECT * FROM talep_form WHERE id = ? AND status = 17", [$id])->num_rows();

        if ($bildirim_kontrol) {
            $this->errorResponse("Bildirim Başlatılmıştır.");
            return;
        }

        $details = $this->talep->details($id);

        if (!isset($details->warehouse_id)) {
            $this->errorResponse("Depo Seçmeniz Gerekmektedir.");
            return;
        }

        $products_items = $this->talep->details_items($id);
        $sonuc = $this->validateProducts($products_items);

        if ($sonuc) {
            $this->updateTalepFormStatus($id, 17);
            $users_ = onay_sort(14, 0, 0, $id);

            if ($users_) {
                $this->insertApprovalSteps($id, $users_, 3);
                $this->sendNotification($details, $users_);
                $this->successResponse("Başarıyla Bildirim Başlatıldı");
            } else {
                $this->errorResponse("Projenize Yetkili Kişiler Atanmamıştır veya Seçilen Depoya Yetkili Tanımlanmamıştır. Bu Sebeple İşlem Yapamazsınız.");
            }
        } else {
            $this->updateTalepFormStatus($id, 1);
            $users_ = onay_sort(7, $details->proje_id, 0, $id);

            if ($users_) {
                $this->insertApprovalSteps($id, $users_, $type);
                $this->sendNotification($details, $users_);
                $this->successResponse("Başarıyla Bildirim Başlatıldı");
            } else {
                $this->errorResponse("Projenize Yetkili Kişiler Atanmamıştır.");
            }
        }
    }

    private function handleType2Notification($id, $user_id)
    {
        $talep_kontrol = $this->db->query("SELECT * FROM `talep_user_satinalma` WHERE talep_id = ? AND user_id = ?", [$id, $user_id])->num_rows();

        if (!$talep_kontrol) {
            $this->errorResponse("Yetkiniz Yoktur.");
            return;
        }

        $details = $this->talep->details($id);
        $this->updateTalepFormStatus($id, 1);
        $users_ = onay_sort(1, $details->proje_id, $id);

        if ($users_) {
            $this->insertApprovalSteps($id, $users_, 2);
            $this->updateTalepFormStatus($id, 4);
            $this->successResponse("Başarıyla Bildirim Başlatıldı");
        } else {
            $this->errorResponse("Projenize Yetkili Kişiler Atanmamıştır. Bu Sebeple İşlem Yapamazsınız.");
        }
    }

    private function updateTalepFormStatus($id, $status)
    {
        $this->db->set(['status' => $status]);
        $this->db->where('id', $id);
        if (!$this->db->update('talep_form')) {
            $this->errorResponse("Hata Aldınız. Lütfen Yöneticiye Başvurun.");
        }
    }

    private function insertApprovalSteps($id, $users, $type)
    {
        foreach ($users as $items) {
            $staff = $items['sort'] == 1 ? 1 : 0;

            $data_onay = [
                'talep_id' => $id,
                'type' => $type,
                'staff' => $staff,
                'sort' => $items['sort'],
                'user_id' => $items['user_id'],
            ];

            $this->db->insert('talep_onay_new', $data_onay);
        }
    }

    private function sendNotification($details, $users)
    {
        $this->talep_history($details->id, $this->aauth->get_user()->id, 'Onay İşlemi Başlatıldı');
        $this->aauth->applog("Malzeme Talebinde Bildirim Başlatıldı: ID: " . $details->id, $this->aauth->get_user()->username);
    }

    private function validateProducts($products)
    {
        // Ürün doğrulama işlemi
        return 1; // Burada gerçek kontrol eklenmeli
    }





    public function talep_history($id,$user_id,$desc,$type=1){

        $data_step = array(
            'talep_id' => $id,
            'user_id' => $user_id,
            'desc' => $desc,
            'type' => $type,
        );
        $this->db->insert('talep_history', $data_step);

    }

    public function search_products()
    {
        $data = [];
        $units = units();
        $cat_id = $this->input->post('cat_id');
        $proje_id = $this->input->post('proje_id');
        $bolum_id = $this->input->post('bolum_id');
        $asama_id = $this->input->post('asama_id');
        $keyword = $this->input->post('keyword');
        $talep_type = $this->input->post('talep_type');

        if ($talep_type == 1) {
            $data = $this->search_type1($cat_id, $keyword, $proje_id, $bolum_id, $asama_id);
        } elseif ($talep_type == 3) {
            $data = $this->search_type3($cat_id, $keyword);
        }

        if (!empty($data)) {
            echo json_encode(['status' => 'Success', 'products' => $data, 'units' => $units]);
        } else {
            echo json_encode(['status' => 'Error', 'message' => "Ürün Bulunamadı"]);
        }
    }

    private function search_type1($cat_id, $keyword, $proje_id, $bolum_id, $asama_id)
    {
        $where = $this->build_type1_where_clause($cat_id, $keyword);
        $query = $this->db->query(
            "SELECT
            geopos_products.pid as product_id,
            geopos_products.image as images,
            CONCAT(geopos_products.product_name, ' ', geopos_products.product_name_tr, ' ', geopos_products.product_name_en) as product_name,
            IF(product_stock_code.id, product_stock_code.code, 'varyasyon tanımlanmamış') as varyasyon,
            IF(product_stock_code.id, product_stock_code.id, 0) as product_stock_code_id,
            product_stock_code.code
        FROM geopos_products
        LEFT JOIN product_stock_code ON geopos_products.pid = product_stock_code.product_id
        LEFT JOIN geopos_products_parent ON geopos_products_parent.product_stock_code_id = product_stock_code.id
        WHERE geopos_products.deleted_at IS NULL AND $where
        GROUP BY product_stock_code.id
        ORDER BY geopos_products.pid DESC
        LIMIT 100"
        );

        return $this->prepare_type1_data($query, $proje_id, $bolum_id, $asama_id);
    }

    private function build_type1_where_clause($cat_id, $keyword)
    {
        $conditions = [];
        if ($keyword) {
            $conditions[] = "(geopos_products_parent.tag LIKE '%$keyword%' OR geopos_products.tag LIKE '%$keyword%' OR 
            product_stock_code.code LIKE '%$keyword%' OR geopos_products.product_name LIKE '%$keyword%' OR 
            geopos_products.product_name_tr LIKE '%$keyword%' OR geopos_products.product_name_en LIKE '%$keyword%' OR 
            geopos_products.product_code LIKE '%$keyword%' OR geopos_products.barcode LIKE '%$keyword%')";
        }

        if ($cat_id) {
            $conditions[] = "(geopos_products_parent.pcat = $cat_id OR geopos_products.pcat = $cat_id)";
        }

        return !empty($conditions) ? implode(' AND ', $conditions) : '1=1';
    }

    private function prepare_type1_data($query, $proje_id, $bolum_id, $asama_id)
    {
        $data = [];
        if ($query->num_rows()) {
            foreach ($query->result() as $items) {
                $varyasyon_name = $items->varyasyon;
                $proje_qty_details = proje_qty_function_new($proje_id, $items->product_id, $bolum_id, $asama_id, null, null, $items->product_stock_code_id);

                if ($items->product_stock_code_id) {
                    $varyasyon_name = "<span style='cursor:pointer' class='option_view_btn' stock_code_id='$items->product_stock_code_id'>$items->varyasyon</span>";
                }

                $images = $items->images;
                $products_parent = $this->db->query("SELECT * FROM geopos_products_parent WHERE product_stock_code_id = ?", [$items->product_stock_code_id]);
                if ($products_parent->num_rows()) {
                    $images = $products_parent->row()->image;
                }

                $data[] = [
                    'images' => $images,
                    'product_id' => $items->product_id,
                    'product_name' => $items->product_name,
                    'unit_id' => 9,
                    'unit_name' => units_(9)['name'],
                    'stock_qty' => 0,
                    'max_qty' => 99999999,
                    'option_html' => $varyasyon_name,
                    'product_stock_code_id' => $items->product_stock_code_id,
                ];
            }
        }

        return $data;
    }

    private function search_type3($cat_id, $keyword)
    {
        $where = $this->build_type3_where_clause($cat_id, $keyword);
        $query = $this->db->query(
            "SELECT 
            geopos_cost.id as pid,
            geopos_cost.name as product_name,
            geopos_cost.unit as unit,
            geopos_cost.unit as p_unit_id
        FROM geopos_cost
        WHERE $where
        LIMIT 30"
        );

        return $this->prepare_type3_data($query);
    }

    private function build_type3_where_clause($cat_id, $keyword)
    {
        $conditions = [];
        if ($keyword) {
            $conditions[] = "`name` LIKE '%$keyword%'";
        }

        if ($cat_id) {
            $conditions[] = "parent_id = $cat_id";
        }

        return !empty($conditions) ? implode(' AND ', $conditions) : '1=1';
    }

    private function prepare_type3_data($query)
    {
        $data = [];
        if ($query->num_rows()) {
            foreach ($query->result() as $items) {
                $data[] = [
                    'product_id' => $items->pid,
                    'product_name' => $items->product_name,
                    'unit_id' => $items->unit,
                    'unit_name' => units_($items->unit)['name'],
                    'stock_qty' => 0,
                    'max_qty' => 9999999999,
                    'option_html' => '',
                ];
            }
        }

        return $data;
    }


    public function talep_list_get(){
        $data=[];
        $units=units();
        $proje_id = $this->input->post('proje_id');
        $bolum_id = $this->input->post('bolum_id');
        $asama_id = $this->input->post('asama_id');
        $user_id= $this->aauth->get_user()->id;

        //and proje_stoklari.asama_id=$asama_id
        $query = $this->db->query("SELECT geopos_products.*,proje_stoklari.product_desc as p_product_desc,proje_stoklari.unit_id as p_unit_id,proje_stoklari.product_stock_code_id,
       proje_stoklari.qty as max_qty,proje_stoklari.option_id,proje_stoklari.option_value_id,proje_stoklari.id as proje_stoklari_id 
FROM talep_list_proje
INNER JOIN proje_stoklari on talep_list_proje.proje_stoklari_id = proje_stoklari.id
INNER JOIN geopos_products ON geopos_products.pid=proje_stoklari.product_id
Where talep_list_proje.aauth_id=$user_id  and proje_stoklari.bolum_id=$bolum_id 
");
        if($query->num_rows()){
            foreach ($query->result() as $items){


                $varyasyon_name='';
                if($items->product_stock_code_id){
                    $stock_code=$this->db->query("SELECT * FROM product_stock_code Where id=$items->product_stock_code_id");
                    if($stock_code->num_rows()){
                        $varyasyon_name = $stock_code->row()->code;
                    }
                }
                $product_type =  product_full_details($items->pid)['product_type'];
                $proje_stoklari_id = $items->proje_stoklari_id;
                if($product_type==9){
                    $detaisl = $this->db->query("SELECT * FROM proje_stoktlari_parent Where proje_stoklari_id=$proje_stoklari_id GROUP BY product_stock_code_id");
                    if($detaisl->num_rows()){
                        foreach ($detaisl->result() as $items){
                            $stock_qty = stock_qty($items->product_id,0);
                            $data[]=[
                                'product_id'=>$items->product_id,
                                'product_name'=>product_full_details($items->product_id)['product_name'],
                                'product_desc'=>isset($items->p_product_desc)?$items->p_product_desc:product_full_details($items->product_id)['product_name'],
                                'unit_id'=>$items->unit_id,
                                'product_stock_code_id'=>$items->product_stock_code_id,
                                'unit_name'=>units_($items->unit_id)['name'],
                                'stock_qty'=>$stock_qty,
                                'max_qty'=>$items->qty,
                                'option_id'=>$items->option_id,
                                'option_value_id'=>$items->option_value_id,
                                'p_unit_id'=>$items->unit_id,
                                'proje_stoklari_id'=>$proje_stoklari_id,
                                //'option_html'=>varyasyon_string_name($items->option_id,$items->option_value_id)
                                'option_html'=>$varyasyon_name
                            ];
                        }
                    }
                }
                else{
                    //$proje_qty_details =  proje_qty_function($proje_id,$items->pid,$bolum_id,$asama_id,$items->option_id,$items->option_value_id);
                    $proje_qty_details =  proje_qty_function_new($proje_id,$items->pid,$bolum_id,$asama_id,$items->option_id,$items->option_value_id,$items->product_stock_code_id);

                    if($proje_qty_details > 0){
                        $stock_qty = stock_qty($items->pid,0);
                        $data[]=[
                            'product_id'=>$items->pid,
                            'product_desc'=>isset($items->p_product_desc)?$items->p_product_desc:$items->product_name,

                            'product_stock_code_id'=>$items->product_stock_code_id,
                            'product_name'=>$items->product_name,
                            'unit_id'=>$items->unit,
                            'unit_name'=>units_($items->unit)['name'],
                            'stock_qty'=>$stock_qty,
                            'max_qty'=>$proje_qty_details,
                            'option_id'=>$items->option_id,
                            'option_value_id'=>$items->option_value_id,
                            'p_unit_id'=>$items->p_unit_id,
                            'proje_stoklari_id'=>$proje_stoklari_id,
                            'option_html'=>$varyasyon_name
//                            'option_html'=>varyasyon_string_name($items->option_id,$items->option_value_id)
                        ];
                    }
                }


            }
            echo json_encode(array('status' => 'Success','products'=>$data,'units'=>$units));
        }
        else {
            echo json_encode(array('status' => 'Error', 'message' =>"Ürün Bulunamadı"));
        }
    }

    public function search_products_proje(){
        $where='';
        $data=[];
        $units=units();
        $cat_id = $this->input->post('cat_id');
        $keyword = $this->input->post('keyword');


         if($cat_id) {
            $where = "  pcat=$cat_id ";
        }
        else if($keyword) {
           // $where = " and `product_name` LIKE '%$keyword%'  or simeta_code LIKE '%$keyword%' or simeta_product_name LIKE '%$keyword%' or `product_code` LIKE '%$keyword%' or `barcode` LIKE '%$keyword%' ";
            $where = " `product_name` LIKE '%$keyword%'  or `product_name_en` LIKE '%$keyword%' or `product_name_tr` LIKE '%$keyword%' or `product_code` LIKE '%$keyword%' or `barcode` LIKE '%$keyword%' ";

        }
        if($keyword && $cat_id){
            //$where = " and (`product_name` LIKE '%$keyword%'  or simeta_code LIKE '%$keyword%' or simeta_product_name LIKE '%$keyword%' or `product_code` LIKE '%$keyword%' or `barcode` LIKE '%$keyword%')  AND pcat=$cat_id";
            $where = "  ( `product_name` LIKE '%$keyword%'  or `product_name_en` LIKE '%$keyword%' or `product_name_tr` LIKE '%$keyword%' or `product_code` LIKE '%$keyword%' or `barcode` LIKE '%$keyword%')  AND pcat=$cat_id   ";
        }
        $query = $this->db->query("SELECT geopos_products.* FROM `geopos_products`
            WHERE ($where) and geopos_products.deleted_at is null   GROUP BY geopos_products.pid LIMIT 30");



        if($query->num_rows()){
            foreach ($query->result() as $items){
                $stock_qty = stock_qty($items->pid,0);
                $data[]=[
                    'product_id'=>$items->pid,
                    'product_name'=>$items->product_name,
                    'unit_id'=>$items->unit,
                    'unit_name'=>units_($items->unit)['name'],
                    'stock_qty'=>$stock_qty,
                ];
            }
            echo json_encode(array('status' => 'Success','products'=>$data,'units'=>$units));
        }
        else {
            echo json_encode(array('status' => 'Error', 'message' =>"Ürün Bulunamadı"));
        }


    }

    public function search_cari()
    {
        $data = [];
        $keyword = $this->input->post('keyword', true);
        $loc = $this->session->userdata('set_firma_id');

        // Parametreli sorgu kullanarak SQL enjeksiyon riskini önleme
        $this->db->select('id as cari_id, name, phone, email, company, sektor');
        $this->db->from('geopos_customers');
        $this->db->where('loc', $loc);
        $this->db->group_start()
            ->like('name', $keyword)
            ->or_like('company', $keyword)
            ->or_like('phone', $keyword)
            ->or_like('sektor', $keyword)
            ->group_end();

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            echo json_encode(['status' => 'Success', 'cari_list' => $data]);
        } else {
            echo json_encode(['status' => 'Error', 'message' => "Cari Bulunamadı"]);
        }
    }



    public function warehouse_update()
    {
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $details = $this->talep->details($id);
        $warehouse_text = $this->input->post('warehouse_text');
        $warehouse_id = $this->input->post('warehouse_id');
        $tip = $this->input->post('tip');
        $data=[];
        if($tip==1){
            $data = array(
                'warehouse_id' => $warehouse_id,
                'warehouse_notes' => $warehouse_text,
            );
        }
        else {
            $data = array(
                'transfer_warehouse_id' => $warehouse_id,
                'transfer_warehouse_notes' => $warehouse_text,
            );
        }

        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('talep_form', $data)) {

            $miktar_kontrol = $this->db->query("Select * From warehouse_teslimat Where form_id = $id");
            if($miktar_kontrol->num_rows()){
                $update_data = array(
                    'teslim_edilecek_warehouse_id' => $warehouse_id,
                );
                $this->db->set($update_data);
                $this->db->where('form_id', $id);
                $this->db->update('warehouse_teslimat', $update_data);
            }

            $this->aauth->applog("Malzame Talebinde Depo Tanımlaması Yapıldı Talep :  ID : ".$id, $this->aauth->get_user()->username);
            $this->talep_history($id,$this->aauth->get_user()->id,'Depo Değiştildi. Eki Depo : '.warehouse_details($warehouse_id)->title.' Yeni Depo : '.warehouse_details($warehouse_id)->title );
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Güncellendi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
        }
    }

    public function sales_personel_update()
    {
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $details = $this->talep->details($id);
        $user_id = $this->aauth->get_user()->id;
        $proje_id = $details->proje_id;

        $old_pers_id = $this->db->query("SELECT * FROM talep_user_satinalma Where talep_id=$id")->row()->user_id;
        $sales_personel_id = $this->input->post('sales_personel_id');
        $proje_details = $this->db->query("SELECT * FROM geopos_projects Where id=$proje_id")->row();
        $proje_sorumlusu  = $proje_details->proje_sorumlusu_id;
        $proje_muhasebe_mudur_id  = $proje_details->muhasebe_muduru_id;
        $proje_muduru_id  = 66;
        $genel_mudur_id  = $proje_details->genel_mudur_id;
        $muhasebe_muduru_id  = $proje_details->muhasebe_muduru_id;
        if($user_id==$proje_sorumlusu ||
            $user_id==$proje_muhasebe_mudur_id ||
            $user_id==$proje_muduru_id ||
            $user_id==$genel_mudur_id ||
            $user_id==$muhasebe_muduru_id ||
            $user_id==1009 ||
            $user_id==39 ||
            $user_id==21
        )
        {

            $data=[];

            $data = array(
                'user_id' => $sales_personel_id,
            );


            $this->db->set($data);
            $this->db->where('talep_id', $id);
            if ($this->db->update('talep_user_satinalma', $data)) {
                $this->aauth->applog("Malzame Talebinde Satınalma Personeli Değiştirildi :  ID : ".$id, $this->aauth->get_user()->username);
                $this->talep_history($id,$this->aauth->get_user()->id,'Malzame Talebinde Satınalma Personeli Değiştirildi. Eski Personel: '.personel_details($old_pers_id).' Yeni Personel : '.personel_details($sales_personel_id));
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success','message'=>'Başarıyla Güncellendi'));
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
            }
        }
        else {
            $this->db->trans_rollback();
            $this->talep_history($id,$this->aauth->get_user()->id,'Malzame Talebinde Satınalma Personeli Değiştirilmeye Çalışıldı. Eski Personel: '.personel_details($old_pers_id).' Yeni Personel : '.personel_details($sales_personel_id));
            echo json_encode(array('status' => 'Error', 'message' =>"Yetkiniz Yoktur" ));
        }


    }

    public function payment_personel_update()
    {
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $staff_id = $this->input->post('staff_id');
        $payment_personel_id = $this->input->post('payment_personel_id');
        $sort_avans_id = $this->input->post('sort_avans_id');
        $details = $this->talep->details($id);
        $data=[];


        $data = array(
            'muhasebe_id' => $payment_personel_id,
        );
        $this->db->set($data);
        $this->db->where('talep_form_avans_id', $sort_avans_id);
        if ($this->db->update('talep_form_avans_sort', $data)) {
            $this->aauth->applog("talepte ödeme yapacak personel değiştirildi :  Eski Personel : ".  personel_details($staff_id).' Yeni Personel : '.personel_details($payment_personel_id), $this->aauth->get_user()->username);
            $this->talep_history($id,$this->aauth->get_user()->id,'talepte ödeme yapacak personel değiştirildi. Eski Personel: '.personel_details($staff_id).' Yeni Personel : '.personel_details($payment_personel_id));
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Güncellendi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
        }
    }

    public function get_all_cari_list(){
        $id = $this->input->post('talep_id');
        $cari_id = $this->input->post('cari_item_id');
        echo json_encode(array('status' => 'Success','items'=>techizatcilar_items($id,$cari_id)));
    }

    public function get_all_cari_sms()
    {
        $cari_id = $this->input->post('cari_id');
        $data[]=[
            'cari_name'=>customer_details($cari_id)['company'],
            'cari_phone'=>customer_details($cari_id)['phone'],
            'cari_email'=>customer_details($cari_id)['email'],
            'cari_id'=>$cari_id,
            'products'=>'',
        ];
        echo json_encode(array('status' => 'Success','items'=>$data));
    }
    public function hesap_faktura_sms()
    {
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $messages = $this->input->post('sms_mesaji');
        $cari_details = $this->input->post('cari_details');
        $cari_name='';
        if($cari_details){
            $i=0;
            foreach ($cari_details as $items){

                $split =explode(',',$items['cari_phone']);
                foreach ($split as $value) {
                    $phone = $value;
                    $this->mesaj_gonder($phone,$messages);
                    $i++;
                }
                $cari_name=customer_details($items['cari_id'])['company'];
            }
            if($i){
                $this->talep_history($id,$this->aauth->get_user()->id,'Sms Gönderildi.Cari Adı : '.$cari_name);
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success','message'=>'Başarıyla Sms İletildi.Sms Sayısı : '.$i));
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Sms Gönderilirken Hata Aldınız" ));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Cari Malumatı Bulunamadı" ));

        }

    }
    public function teklif_create()
    {
        $this->db->trans_start();

        $id = $this->input->post('talep_id');
        $cari_details = $this->input->post('cari_details');
        $ihale_suresi = $this->input->post('ihale_suresi');
        $details = $this->talep->details($id);

        foreach ($cari_details as $items) {
            $this->createCariTeklif($id, $items, $details, $ihale_suresi);
        }

        $this->finalizeTeklifCreation($id, $ihale_suresi);

        $this->db->trans_complete();
        echo json_encode(['status' => 'Success', 'message' => 'Başarıyla Oluşturuldu']);
    }

    private function createCariTeklif($id, $items, $details, $ihale_suresi)
    {
        $cari_id = $items['cari_id'];
        $data_insert = [
            'form_id' => $id,
            'cari_id' => $cari_id,
            'aauth_id' => $this->aauth->get_user()->id,
        ];

        if ($this->db->insert('talep_form_teklifler', $data_insert)) {
            $teklif_id = $this->db->insert_id();

            if ($details->talep_type == 3) {
                $this->insertProductDetails($id, $teklif_id);
            }

            $this->handleCariPhones($teklif_id, $cari_id, $items['cari_phone'], $details, $ihale_suresi);
        }
    }

    private function insertProductDetails($id, $teklif_id)
    {
        $product_details = $this->talep->product_details($id);

        foreach ($product_details as $product) {
            $data_insert = [
                'item_id' => $product->id,
                'marka' => '',
                'price' => 0,
                'notes' => '',
                'teklif_id' => $teklif_id,
            ];

            $this->db->insert('talep_form_teklifler_item', $data_insert);
        }

        $this->db->set(['total' => 0, 'kdv' => 0, 'teslimat' => 0]);
        $this->db->where('form_id', $id);
        $this->db->where('teklif_id', $teklif_id);
        $this->db->update('talep_form_teklifler');
    }

    private function handleCariPhones($teklif_id, $cari_id, $cari_phones, $details, $ihale_suresi)
    {
        $split_phones = explode(',', $cari_phones);

        foreach ($split_phones as $phone) {
            $data_details_insert = [
                'teklif_id' => $teklif_id,
                'cari_id' => $cari_id,
                'phone' => $phone,
            ];

            $this->db->insert('talep_form_teklif_cari_details', $data_details_insert);
            $tftcd_id = $this->db->insert_id();

            if ($details->talep_type == 3) {
                $this->db->set('status', 3);
                $this->db->where('id', $tftcd_id);
                $this->db->update('talep_form_teklif_cari_details');
            }

            $messages = $this->generateNotificationMessage($cari_id, $ihale_suresi);
            $this->db->set('messages', $messages);
            $this->db->where('id', $tftcd_id);
            $this->db->update('talep_form_teklif_cari_details');

            $this->mesaj_gonder($phone, $messages);
        }
    }

    private function generateNotificationMessage($cari_id, $ihale_suresi)
    {
        $firma_name = customer_details($cari_id)['company'];
        $contact_person = personel_detailsa($this->aauth->get_user()->id)['name'];
        $contact_phone = personel_detailsa($this->aauth->get_user()->id)['phone'];
        $short_url = $this->getSmallLink("https://customer.makro2000.com.tr");

        return "{$firma_name} - Makro2000 Qrup Şirketleri sizden bir fiyat bekliyor. İhale Süresi: {$ihale_suresi} saat. 
            İlgili kişi: {$contact_person}. İletişim: {$contact_phone}. Teklif göndermek için tıklayın: {$short_url}";
    }

    private function finalizeTeklifCreation($id, $ihale_suresi)
    {
        $this->db->set('status', 2);
        $this->db->where('talep_id', $id);
        $this->db->update('talep_user_satinalma');

        $this->aauth->applog("Malzeme Talebine Teklif Oluşturuldu: ID: {$id}", $this->aauth->get_user()->username);
        $this->talep_history($id, $this->aauth->get_user()->id, 'Teklif Oluşturuldu');

        $this->recordIhaleCounter($id, $ihale_suresi);
    }

    private function recordIhaleCounter($id, $ihale_suresi)
    {
        date_default_timezone_set('Asia/Baku');
        $current_time = date("Y-m-d H:i:s");
        $finish_time = date('Y-m-d H:i:s', strtotime("+{$ihale_suresi} hour", strtotime($current_time)));

        $data_insert_counter = [
            'talep_id' => $id,
            'durum' => 1,
            'hours' => $ihale_suresi,
            'finish_date' => $finish_time,
            'aauth_id' => $this->aauth->get_user()->id,
        ];

        $this->db->insert('teklif_counter', $data_insert_counter);
    }


    public function getSmallLink($longurl){


        $talep_no = numaric(23);

        $url = $longurl;
        $sort_url='https://makrolink.site/'.$talep_no;

        $data_items=array
        (
            'sort_link'=>$sort_url,
            'long_link'=>$url,
        );
        $this->db->insert('sort_link', $data_items);

        numaric_update(23);

        $db_details  = db_details(2); // Link DB Bilgileri
        //$firma = new mysqli('127.0.0.1', 'root', 'aa11bb22cc33Aa', 'link');
        $firma = new mysqli($db_details->ip, $db_details->db_user, $db_details->db_pass, $db_details->db_name);
        if ($firma->connect_error) {
            die("Connection failed: " . $firma->connect_error);
        }
        $sql="INSERT INTO `sort_link`(`sort_link`, `long_link`) VALUES ('$sort_url','$url')";
        if ($firma->query($sql) === TRUE) {
            return $sort_url;
        }
        else {
            echo "Error: " . $sql . "<br>" . $firma->error;
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



    public function teklif_update()
    {
        $this->db->trans_start();

        $form_id = $this->input->post('form_id');
        $details = $this->talep->details($form_id);

        // Talep durum kontrolü
        if ($details->status > 3) {
            $this->errorResponse("Bu Aşamada Güncelleme Yapamazsınız");
            return;
        }

        $user_id = $this->aauth->get_user()->id;
        $talep_kontrol = $this->checkUserPermission($form_id, $user_id);

        if (!$talep_kontrol) {
            $this->errorResponse("Seçilen Satınalma Personeli Dışında Bu Aşamada Yetki Verilmemektedir");
            return;
        }

        $tf_teklif_id = $this->input->post('teklif_id');

        // Mevcut teklif detaylarını sil
        $this->deleteExistingTeklifDetails($tf_teklif_id);

        // Yeni teklif detaylarını ekle
        $data_insert = $this->prepareTeklifDetailsData();
        if ($this->db->insert('talep_form_teklifler_details', $data_insert)) {
            $last_id = $this->db->insert_id();
            $this->processProductDetails($last_id, $details);
            $this->finalizeUpdate($tf_teklif_id);
        } else {
            $this->errorResponse("Hata Aldınız. Lütfen Yöneticiye Başvurun.");
        }

        $this->db->trans_complete();
    }

    private function checkUserPermission($form_id, $user_id)
    {
        return $this->db->query(
                "SELECT * FROM `talep_user_satinalma` WHERE talep_id = ? AND user_id = ?",
                [$form_id, $user_id]
            )->num_rows() > 0;
    }

    private function deleteExistingTeklifDetails($tf_teklif_id)
    {
        $kontrol = $this->db->query("SELECT * FROM talep_form_teklifler_details WHERE tf_teklif_id = ?", [$tf_teklif_id]);

        if ($kontrol->num_rows() > 0) {
            $details_id = $kontrol->row()->id;
            $this->db->delete('talep_form_teklifler_item_details', ['details_id' => $details_id]);
            $this->db->delete('talep_form_teklifler_details', ['tf_teklif_id' => $tf_teklif_id]);
        }
    }

    private function prepareTeklifDetailsData()
    {
        return [
            'tf_teklif_id' => $this->input->post('teklif_id'),
            'method' => $this->input->post('method'),
            'discount_type' => $this->input->post('discount_type'),
            'teslimat' => $this->input->post('teslimat'),
            'teslimat_tutar' => $this->input->post('teslimat_tutar'),
            'edv_durum' => $this->input->post('edv_durum'),
            'para_birimi' => $this->input->post('para_birimi'),
            'alt_sub_total_val' => $this->input->post('alt_sub_total_val'),
            'alt_total_val' => $this->input->post('alt_total_val'),
            'alt_discount_total_val' => $this->input->post('alt_discount_total_val'),
            'alt_edv_total_val' => $this->input->post('alt_edv_total_val'),
            'avans_price' => $this->input->post('avans_price'),
            'aauth_id' => $this->aauth->get_user()->id,
        ];
    }

    private function processProductDetails($details_id, $details)
    {
        $product_details = $this->input->post('product_details');
        $product_list = [];
        $index = 0;

        foreach ($product_details as $items) {
            if ($items['item_id']) {
                $product_list[$index] = $this->prepareProductDetailsData($items, $details_id, $details);
                $this->updateProductQuantity($items);
                $this->logProductHistory($items, $details);
                $index++;
            }
        }

        if (!empty($product_list)) {
            $this->db->insert_batch('talep_form_teklifler_item_details', $product_list);
        }
    }

    private function prepareProductDetailsData($items, $details_id, $details)
    {
        return [
            'details_id' => $details_id,
            'tfitem_id' => $items['item_id'],
            'qty' => $items['item_qty'],
            'price' => $items['item_price'],
            'discount_type' => $this->input->post('discount_type'),
            'discount' => $items['item_discount'],
            'edv_oran' => $items['item_kdv'],
            'edv_type' => $this->input->post('edv_durum'),
            'sub_total' => $items['item_edvsiz'],
            'discount_total' => $items['item_discount_umumi'],
            'kdv_total' => $items['edv_tutari'],
            'total' => $items['item_umumi_cemi'],
            'item_desc' => $items['item_desc'],
        ];
    }

    private function updateProductQuantity($items)
    {
        if ($items['new_unit_id']) {
            $this->db->set('unit_id', $items['new_unit_id']);
            $this->db->set('product_qty', $items['item_qty']);
            $this->db->where('id', $items['item_id']);
            $this->db->update('talep_form_products');
        }
    }

    private function logProductHistory($items, $details)
    {
        $item_details = $this->db->query("SELECT * FROM talep_form_products WHERE id = ?", [$items['item_id']])->row();
        $old_quantity = $item_details->product_qty . ' ' . units_($item_details->unit_id)['name'];
        $product_name = $this->getProductName($item_details, $details);

        $message = "{$product_name} Eski Miktar: {$old_quantity} Ürünü İçin Yeni Miktar: {$items['item_qty']} Yeni Birim: " . units_($items['new_unit_id'])['name'];
        $this->talep_history($this->input->post('form_id'), $this->aauth->get_user()->id, $message);
    }

    private function getProductName($item_details, $details)
    {
        if ($details->talep_type == 1 || $details->talep_type == 2) {
            return product_details_($item_details->product_id)->product_name;
        } elseif ($details->talep_type == 3) {
            return who_demirbas($item_details->product_id)->name;
        }

        return '';
    }

    private function finalizeUpdate($tf_teklif_id)
    {
        $this->aauth->applog("Teklif Güncellendi: Teklif ID: {$tf_teklif_id}", $this->aauth->get_user()->username);
        echo json_encode(['status' => 'Success', 'message' => 'Başarıyla Güncellendi']);
    }
    public function beklyen_malzeme_count(){
        $result = $this->talep->beklyen_malzeme_count();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }

    public function tehvil_list_count(){
        $result = $this->talep->tehvil_list_count();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }


    }

    public function count_gider_mt(){
        $result = $this->talep->count_gider_mt();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }

    public function transfertaleplist(){
        $result = $this->talep->transfertaleplist();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }



    }

    public function qaimelistcount(){
        $result = $this->talep->qaimelistcount();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }

    public function siparis_finist_list_count(){


        $result = $this->talep->siparis_finist_list_count();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }


    }

    public function bekleyen_sened_list_count(){

        $result = $this->talep->bekleyen_sened_list_count();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }

    public function ihalebeklyenlistcount(){
        $result = $this->talep->ihalebeklyenlistcount();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }


    }

    public function odemetalepcount(){
        $result = $this->talep->odemetalepcount();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }
    public function avanslistcount(){

        $result = $this->talep->avanslistcount();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }

    public function odemelistcount(){
        $where_talep_form='';
        if($this->session->userdata('set_firma_id')){
            $where_talep_form.='and talep_form.loc='.$this->session->userdata('set_firma_id');
            //$this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $aauth_id = $this->aauth->get_user()->id;
        $count = 0;
        $result = $this->db->query("SELECT * FROM talep_form Where talep_form.status = 11 $where_talep_form");
        if($result->num_rows()){
            foreach ($result->result() as $items){
                 $avans_sorgu = $this->db->query("SELECT * FROM talep_form_avans Where talep_id = $items->id and type = 2 and status_id=3");
                 if($avans_sorgu->num_rows()){
                        foreach ($avans_sorgu->result() as $values){
                            $avans_talep_id = $values->id;
                            if($aauth_id==talep_form_sort_why($avans_talep_id)->staff_id){
                                $count++;
                            }
                        }
                 }
            }
        }
        echo json_encode(array('status' => 'Success','count'=>$count));
    }

    public function odemelistcountnew(){
        $result = $this->talep->odemelistcountnew();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }

    public function odemeemrilistcount(){
        $result = $this->talep->odemeemrilistcount();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }
    public function personelsatinalmalistcount(){
        $result = $this->talep->personelsatinalmalistcount();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }

    }

    public function ihalelistcount(){

        $result = $this->talep->ihalelistcount();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }

    public function siparislistcount(){
        $result = $this->talep->siparislistcount();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }
    public function send_mail($user_id,$subject,$message){
                if(!$user_id){
                    return 0;
                }
                else {
                    $message .= "<br><br><br><br>";
                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
                    $proje_sorumlusu_email = personel_detailsa($user_id)['email'];
                    $recipients = array($proje_sorumlusu_email);
                    $this->communication_model->onay_mail($recipients, $subject, $message, false,'', 'gider_talep_onay_maili');
                    return 1;
                }

    }

    public function send_mail_arr($user_id,$subject,$message){
                 $message .= "<br><br><br><br>";
                 $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                 $recipients=[];
                 foreach ($user_id as $emails){
                     $recipients[]=personel_detailsa($emails)['email'];
                 }

                 $this->communication_model->onay_mail($recipients, $subject, $message, false,'', 'gider_talep_onay_maili');
                 return 1;
    }

    public function siparis_create()
    {
        $this->db->trans_start();

        $talep_id = $this->input->post('talep_id');
        $product_details = $this->input->post('product_details');
        $product_list = [];
        $index = 0;

        // Talep detaylarını al
        $talep_details = $this->talep->details($talep_id);
        if (!$talep_details) {
            $this->errorResponse("Talep detayları bulunamadı.");
            return;
        }

        $proje_id = $talep_details->proje_id;
        $yetkili_kontrol = $this->db->query("SELECT genel_mudur_id FROM `geopos_projects` WHERE id = ?", [$proje_id])->row();

        if (!$yetkili_kontrol) {
            $this->errorResponse("Proje yetkilisi bulunamadı.");
            return;
        }

        $yetkili_id = $yetkili_kontrol->genel_mudur_id;

        // Ürün detaylarını işleme al
        foreach ($product_details as $items) {
            $product_data = $this->prepareProductData($items, $talep_id, $yetkili_id);
            $this->db->insert('siparis_list_form', $product_data);
            $last_id = $this->db->insert_id();

            $product_list[$index] = $this->prepareProductNewData($items, $last_id);
            $index++;
        }

        if ($index) {
            $this->db->insert_batch('siparis_list_form_new', $product_list);
            $this->finalizeSiparis($talep_details, $yetkili_id, $talep_id);
            $this->successResponse("Başarıyla Güncellendi");
        } else {
            $this->errorResponse("Hata Aldınız. Lütfen Yöneticiye Başvurun.");
        }

        $this->db->trans_complete();
    }

    private function prepareProductData($items, $talep_id, $yetkili_id)
    {
        return [
            'product_id' => $items['product_id'],
            'talep_id' => $talep_id,
            'teklif_qty' => $items['teklif_qty'],
            'unit_id' => $items['unit_id'],
            'price' => $items['price'],
            'discount' => $items['discount'],
            'talep_form_product_id' => $items['talep_form_product_id'],
            'edv_oran' => $items['edv_oran'],
            'edv_type' => $items['edv_type'],
            'cemi' => $items['cemi'],
            'umumi_cemi' => $items['umumi_cemi'],
            'not' => $items['not'],
            'para_birimi' => $items['para_birimi'],
            'cari_id' => $items['cari_id'],
            'warehouse_id' => $items['warehouse_id'],
            'onay_list_id' => $items['onay_list_id'],
            'aauth_id' => $this->aauth->get_user()->id,
            'staff_id' => $yetkili_id,
        ];
    }

    private function prepareProductNewData($items, $last_id)
    {
        return [
            'siparis_liste_form_id' => $last_id,
            'new_item_qty' => $items['new_item_qty'],
            'new_item_price' => $items['new_item_price'],
            'new_item_discount' => $items['new_item_discount'],
            'new_item_kdv' => $items['new_item_kdv'],
            'new_item_edv_durum' => $items['new_item_edv_durum'],
            'item_edvsiz_hidden' => $items['item_edvsiz_hidden'],
            'edv_tutari_hidden' => $items['edv_tutari_hidden'],
            'talep_form_product_id' => $items['talep_form_product_id'],
            'discount_type' => $items['discount_type'],
            'item_umumi_hidden' => $items['item_umumi_hidden'],
            'item_umumi_cemi_hidden' => $items['item_umumi_cemi_hidden'],
            'item_discount_hidden' => $items['item_discount_hidden'],
            'new_unit_id' => $items['new_unit_id'],
            'new_item_desc' => $items['new_item_desc'],
            'aauth_id' => $this->aauth->get_user()->id,
        ];
    }

    private function finalizeSiparis($talep_details, $yetkili_id, $talep_id)
    {
        $mesaj = $talep_details->code . ' Numaralı Malzeme Talep Formunun Sipariş İşlemleri Tamamlanmıştır. Son Olarak Onayınız Beklemektedir.';
        // $this->send_mail($yetkili_id, 'Sipariş Onayı', $mesaj);
        $this->talep_history($talep_id, $this->aauth->get_user()->id, 'Son Sipariş Bilgisi Onaya Sunuldu');
        $this->aauth->applog("Satınalma Yetkilisi Son Sipariş İçin Onay İstedi: Talep KODU: " . $talep_details->code, $this->aauth->get_user()->username);
    }


    public function siparis_update(){


        $this->db->trans_start();
        $talep_id=$this->input->post('talep_id');
        $talep_details = $this->talep->details($talep_id);
        $product_details=$this->input->post('product_details');
        $tip=$this->input->post('tip');
        $desct=$this->input->post('desct');
        $product_list=[];
        $index=0;
        $staf_status=0;
        $durum='';
        $satinalma_id= $this->talep->talep_user_satinalma($talep_id)->user_id;
        if($tip==1){
            $this->db->delete('warehouse_teslimat', array('form_id' => $talep_id));
            $staf_status=2;
            $durum='Onaylandı';
        }
        elseif($tip==0){
            $staf_status=3;
            $durum='İptal Edildi. Açıklama '.$desct;
        }
        elseif($tip==2){
            $this->db->delete('warehouse_teslimat', array('form_id' => $talep_id));
            $staf_status=2;
            $durum='Düzeliş İstendi. Açıklama '.$desct;
        }

        if($tip==2){

            foreach ($product_details as $items_) {
                $id = $items_['id'];

                $this->db->set('deleted_at', "NOW()", FALSE);
                $this->db->where('id', $id);
                $this->db->update('siparis_list_form');


                $data_Form_new=array(
                    'status'=>0,
                );
                $this->db->set($data_Form_new);
                $this->db->where('siparis_liste_form_id', $id);
                $this->db->update('siparis_list_form_new', $data_Form_new);
                $index++;
            }
            if($index){
                $mesaj=$talep_details->code.' Numaralı Malzeme Talep Formununda Düzeliş İstedi.Siparişinize Bakabilirsiniz';
               // $this->send_mail($satinalma_id,'Sipariş Onayı',$mesaj);
                $this->talep_history($talep_id,$this->aauth->get_user()->id,'Son Sipariş Bilgisine Durum Bildirildi.Durum:'.$durum);
                $this->aauth->applog("Genel Müdür Son Sipariş İçin Durum Bildirdi  : Talep KODU : ".$talep_details->code, $this->aauth->get_user()->username);
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success','message'=>'Başarıyla Güncellendi'));
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
            }
        }
        else if($tip==0){
            $details_ = $this->talep->details($talep_id);
            if($details_->status==10){
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Daha Önceden İptal Edilmiş Form Tekrar İptal Edilemez"));
            }
            else {
                $result = $this->talep->status_upda();
                if($result['status']){
                    echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Güncellendi"));
                    $this->db->trans_complete();
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
                }
            }
        }
        else {

            foreach ($product_details as $items_){
                $id = $items_['id'];
                $items=$this->db->query("SELECT * FROM siparis_list_form Where id = $id")->row_array();
                $data=[
                    'product_id'=>$items['product_id'],
                    'talep_id'=>$items['talep_id'],
                    'teklif_qty'=>$items['teklif_qty'],
                    'unit_id'=>$items['unit_id'],
                    'price'=>$items['price'],
                    'discount'=>$items['discount'],
                    'edv_oran'=>$items['edv_oran'],
                    'edv_type'=>$items['edv_type'],
                    'cemi'=>$items['cemi'],
                    'umumi_cemi'=>$items['umumi_cemi'],
                    'talep_form_product_id'=>$items['talep_form_product_id'],
                    'not'=>$items['not'],
                    'para_birimi'=>$items['para_birimi'],
                    'cari_id'=>$items['cari_id'],
                    'warehouse_id'=>$items['warehouse_id'],
                    'onay_list_id'=>$items['onay_list_id'],
                    'aauth_id'=>$this->aauth->get_user()->id,
                    'staff_id'=>$this->aauth->get_user()->id,
                    'staf_status'=>$staf_status,
                    'file_status'=>$staf_status,
                ];

                $this->db->insert('siparis_list_form', $data);
                $last_id = $this->db->insert_id();
                $new_items=$this->db->query("SELECT * FROM siparis_list_form_new Where siparis_liste_form_id = $id")->row_array();

                // Depoya liste düşürme
                $onay_list_id = $items['onay_list_id'];

                $warehouse_details = warehouse_details($talep_details->warehouse_id);

                $data_teslimat_warehouse = [
                    'form_id'=>$items['talep_id'],
                    'product_id'=>$items['product_id'],
                    'qty'=>$new_items['new_item_qty'],
                    'talep_form_product_id'=>$new_items['talep_form_product_id'],
                    'teslim_edilecek_warehouse_id'=>$talep_details->warehouse_id,
                    'warehouse_desc'=>$talep_details->warehouse_notes,
                    'status'=>1,
                    'unit_id'=>$new_items['new_unit_id'],
                    'warehouse_id'=>0,
                    'aauth_id'=>$this->aauth->get_user()->id,
                    'user_id'=>$warehouse_details->pers_id,
                    'cari_id'=>$items['cari_id'],
                ];
                $this->db->insert('warehouse_teslimat', $data_teslimat_warehouse);


//                $product_type_kontrol =$this->db->query("SELECT * FROM `teklif_onay_list` Where id =$onay_list_id")->row()->type;
//                if($product_type_kontrol==1){
//
//                    $warehouse_details = warehouse_details($talep_details->warehouse_id);
//
//                    $data_teslimat_warehouse = [
//                        'form_id'=>$items['talep_id'],
//                        'product_id'=>$items['product_id'],
//                        'qty'=>$new_items['new_item_qty'],
//                        'talep_form_product_id'=>$new_items['talep_form_product_id'],
//                        'teslim_edilecek_warehouse_id'=>$talep_details->warehouse_id,
//                        'warehouse_desc'=>$talep_details->warehouse_notes,
//                        'status'=>1,
//                        'unit_id'=>$new_items['new_unit_id'],
//                        'warehouse_id'=>0,
//                        'aauth_id'=>$this->aauth->get_user()->id,
//                        'user_id'=>$warehouse_details->pers_id,
//                        'cari_id'=>$items['cari_id'],
//                    ];
//                    $this->db->insert('warehouse_teslimat', $data_teslimat_warehouse);
//                }
//                else {
//                    //eğer depodan gidecek ürün varsa transfer bildirimi
//                    $data_teslimat_warehouse = [
//                        'form_id'=>$items['talep_id'],
//                        'product_id'=>$items['product_id'],
//                        'qty'=>$new_items['new_item_qty'],
//                        'teslim_edilecek_warehouse_id'=>$talep_details->warehouse_id,
//                        'warehouse_desc'=>$talep_details->warehouse_notes,
//                        'status'=>0, // Bekliyor
//                        'unit_id'=>$new_items['new_unit_id'],
//                        'warehouse_id'=>$items['warehouse_id'],
//                        'aauth_id'=>$this->aauth->get_user()->id,
//                        'user_id'=>$warehouse_details->pers_id,
//                        'cari_id'=>0,
//                    ];
//                    $this->db->insert('warehouse_teslimat_transfer', $data_teslimat_warehouse);
//                    //eğer depodan gidecek ürün varsa transfer bildirimi
//                }

                // Depoya liste düşürme

                $data_new=[
                    'siparis_liste_form_id'=>$last_id,
                    'new_item_qty'=>$new_items['new_item_qty'],
                    'new_item_price'=>$new_items['new_item_price'],
                    'new_item_discount'=>$new_items['new_item_discount'],
                    'new_item_kdv'=>$new_items['new_item_kdv'],
                    'new_item_edv_durum'=>$new_items['new_item_edv_durum'],
                    'item_edvsiz_hidden'=>$new_items['item_edvsiz_hidden'],
                    'edv_tutari_hidden'=>$new_items['edv_tutari_hidden'],
                    'discount_type'=>$new_items['discount_type'],
                    'item_umumi_hidden'=>$new_items['item_umumi_hidden'],
                    'item_umumi_cemi_hidden'=>$new_items['item_umumi_cemi_hidden'],
                    'item_discount_hidden'=>$new_items['item_discount_hidden'],
                    'new_unit_id'=>$new_items['new_unit_id'],
                    'new_item_desc'=>$new_items['new_item_desc'],
                    'aauth_id'=>$this->aauth->get_user()->id,
                ];

                $product_list[$index]=$data_new;
                $index++;


                $this->db->set('deleted_at', "NOW()", FALSE);
                $this->db->where('id', $id);
                $this->db->update('siparis_list_form');


//                $data_Form=array(
//                    'deleted_at'=>'NOW()',
//                );
//                $this->db->set($data_Form);
//                $this->db->where('id', $id);
//                $this->db->update('siparis_list_form', $data_Form);

                $data_Form_new=array(
                    'status'=>0,
                );
                $this->db->set($data_Form_new);
                $this->db->where('siparis_liste_form_id', $id);
                $this->db->update('siparis_list_form_new', $data_Form_new);


                //onaylanan firmalarda ön Ödeme var ise ön ödeme bekleyenlerde

                //onaylanan firmalarda ön Ödeme var ise ön ödeme bekleyenlerde



            }
            if($index){
                $teklif_avans_kontrol = teklif_avans_kontrol($talep_id);

                $mesaj='';
                if($teklif_avans_kontrol){

                    //Ön Ödeme aşamasına al
                    $data_talep=array(
                        'status'=>11,
                    );
                    $this->db->set($data_talep);
                    $this->db->where('id', $talep_id);
                    $this->db->update('talep_form', $data_talep);
                    //Ön Ödeme aşamasına al

                    $mesaj=$talep_details->code.' Numaralı Malzeme Talep Formunun Son Sipariş İşlemleri Tamamlanmıştır.Avans İsteyen Firmalar İçin Avans Talebi Oluşturabilirsiniz veya Senedeler Aşamasına alabilirsiniz';

                }
                else {
                    $data_talep=array(
                        'status'=>6,
                    );
                    //Senedlerin Yüklenmesi aşamasına al
                    $this->db->set($data_talep);
                    $this->db->where('id', $talep_id);
                    //talep aşamasına al
                    $this->db->update('talep_form', $data_talep);
                    $mesaj=$talep_details->code.' Numaralı Malzeme Talep Formunun Son Sipariş İşlemleri Tamamlanmıştır.Siparişinize Bakabilirsiniz';

                    $this->talep_history($form_id,$this->aauth->get_user()->id,'Talep Sened Aşamasına Alındı.');
                }

                $this->db->insert_batch('siparis_list_form_new', $product_list);
                $mesaj=$talep_details->code.' Numaralı Malzeme Talep Formunun Son Sipariş İşlemleri Tamamlanmıştır.Siparişinize Bakabilirsiniz';
                //$this->send_mail($satinalma_id,'Sipariş Onayı',$mesaj);
                $this->talep_history($talep_id,$this->aauth->get_user()->id,'Son Sipariş Bilgisine Durum Bildirildi.Durum:'.$durum);
                $this->aauth->applog("Genel Müdür Son Sipariş İçin Durum Bildirdi  : Talep KODU : ".$talep_details->code, $this->aauth->get_user()->username);



                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success','message'=>'Başarıyla Güncellendi'));

            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
            }
        }
    }


    public function anbar_asama_update()
    {
        $this->db->trans_start();
        $talep_id=$this->input->post('talep_id');

        //talep Güncelle
        $data_Form=array(
            'status'=>7,
        );
        //depoya geç
        $this->db->set($data_Form);
        $this->db->where('id', $talep_id);

        if($this->db->update('talep_form', $data_Form)){
            $this->talep_history($talep_id,$this->aauth->get_user()->id,'Talep Çatdırılma Durumuna Alınmıştır');

            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Güncellendi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
        }
        //depoya geç
    }

    public function siparis_senet_update(){
        $this->db->trans_start();
        $talep_id=$this->input->post('talep_id');
        $talep_details = $this->talep->details($talep_id);
        $product_details=$this->input->post('product_details');
        $count=floatval(count($product_details))*3;
        $product_list=[];
        $index=0;
        $say=0;
        foreach ($product_details as $items_) {

            $id = $items_['item_id'];
            $cari_id =  $items_['cari_id'];
            $muqavele =  $items_['muqavele'];
            $razilastirma =  $items_['razilastirma'];
//            $tehvil_teslim =  $items_['tehvil_teslim'];
            $kontrol = $this->db->query("SELECT * FROM talep_senet Where item_id=$id and talep_id=$talep_id and cari_id=$cari_id")->num_rows();
            if($kontrol){
                $this->db->delete('talep_senet', array('talep_id' => $talep_id,'item_id'=>$id,'cari_id'=>$cari_id));
            }
            $data=[
                'item_id'=>$id,
                'talep_id'=>$talep_id,
                'muqavele'=>$muqavele,
                'razilastirma'=>$razilastirma,
//                'tehvil_teslim'=>$tehvil_teslim,
                'cari_id'=>$cari_id,
            ];
            $product_list[$index]=$data;
            $index++;
            $cari_name = customer_details($cari_id)['company'];
            $text='';
            if($muqavele){
                $text='Muqavele';
                $say++;
            }
            if($razilastirma){
                $text.=' ve Razılaştırma';
                $say++;
            }
//            if($tehvil_teslim){
//                $text.=' ve Tehvil Teslim Aktı';
//                $say++;
//            }
            $content=$cari_name.' Ait Senet Yüklemesi Yapılmıştır. Yüklenen Dosya Tipleri '.$text;
            $this->talep_history($talep_id,$this->aauth->get_user()->id,$content);
        }
        if($index){
            $this->db->insert_batch('talep_senet', $product_list);
            $senet_kontrol = $this->db->query("SELECT * FROM `talep_senet` Where talep_id = $talep_id and (muqavele = 0 or razilastirma = 0)")->num_rows();

            if(!$senet_kontrol){
//                //talep Güncelle
//                $data_Form=array(
//                    'status'=>7,
//                );
//                //depoya geç
//                $this->db->set($data_Form);
//                $this->db->where('id', $talep_id);
//                $this->db->update('talep_form', $data_Form);
//                //depoya geç

                //depocuya mail at
                $warehouse_id = $talep_details->warehouse_id;
                $warehouse_details = warehouse_details($warehouse_id);
                $mesaj=$talep_details->code.' Numaralı Malzeme Talep Formundaki Ürünler Sorumlu Oluğunuz Depoya Teslim Edilecektir.Teslim Almak İçin Sistemden Kontrol ediniz';
                if(!$this->send_mail($warehouse_details->pers_id,'Teslimat Bilgilendirmesi',$mesaj)){
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Depoda Sorumlu Kişi Atanmamış" ));
                    exit();
                }
                //depocuya mail at
            }
            $this->aauth->applog("Senet YÜklemesi Yapılmıştır: ".$talep_details->code, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Güncellendi'));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
        }
    }

    public function tehvil_senet_update(){
        $this->db->trans_start();
        $talep_id=$this->input->post('talep_id'); //4513
        $talep_details = $this->talep->details($talep_id);
        $product_details=$this->input->post('product_details');
        $count=floatval(count($product_details))*3;
        $product_list=[];
        $index=0;
        $say=0;
        foreach ($product_details as $items_) {

            $id = $items_['item_id']; //46407
            $cari_id =  $items_['cari_id']; //231
            $tehvil_teslim =  $items_['tehvil_teslim'];
            $data=[
                'tehvil_teslim'=>$tehvil_teslim,
            ];

            $this->db->set($data);
           // $this->db->where('item_id', $id);
            $this->db->where('talep_id', $talep_id);
            $this->db->where('cari_id', $cari_id);
            $this->db->update('talep_senet', $data);

            $product_list[$index]=$data;
            $index++;
            $cari_name = customer_details($cari_id)['company'];
            $text='';

            if($tehvil_teslim){
                $text.=' Tehvil Teslim Aktı';
                $say++;
            }
            $content=$cari_name.' Ait Senet Yüklemesi Yapılmıştır. Yüklenen Dosya Tipleri '.$text;
            $this->talep_history($talep_id,$this->aauth->get_user()->id,$content);


        }
        if($index){
            $this->aauth->applog("Senet YÜklemesi Yapılmıştır: ".$talep_details->code, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Güncellendi'));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
        }
    }

    public function warehouse_talep_stock_update(){
        $this->db->trans_start();
        $talep_id=$this->input->post('talep_id');
        $talep_details = $this->talep->details($talep_id);

        if($talep_details->talep_type==1 || $talep_details->talep_type==2){
            $product_details=$this->input->post('product_details');
            $index=0;
            $product_list=[];
            foreach ($product_details as $items_) {
                $product_id = $items_['product_id'];
                $teslimat_warehouse_id = $items_['teslimat_warehouse_id'];
                $warehouse_item_qty = $items_['warehouse_item_qty'];
                $warehouse_item_notes = $items_['warehouse_item_notes'];
                $talep_form_product_id=$this->db->query("SELECT * FROM warehouse_teslimat where id = $teslimat_warehouse_id")->row()->talep_form_product_id;
                $data=[
                    'teslimat_warehouse_id'=>$teslimat_warehouse_id,
                    'warehouse_item_qty'=>$warehouse_item_qty,
                    'warehouse_item_notes'=>$warehouse_item_notes,
                    'product_id'=>$product_id,
                    'talep_form_product_id'=>$talep_form_product_id,
                ];
                $product_list[$index]=$data;
                $index++;
                $product_name = product_details_($product_id)->product_name;
                $details_teslimat = $this->db->query("SELECT * FROM `warehouse_teslimat` Where id=$teslimat_warehouse_id")->row();
                $unit_id = $details_teslimat->unit_id;
                $warehouse_id = $details_teslimat->teslim_edilecek_warehouse_id;
                $unit_name = units_($unit_id)['name'];
                $this->talep_history($talep_id,$this->aauth->get_user()->id,'Depoya  '.$product_name.' Ürününden : '.$warehouse_item_qty .' '.$unit_name.' Giriş Yapılmıştır'.' Açıklama'.$warehouse_item_notes);

                $product_stock_code_id = talep_form_product_options_teklif_values($talep_form_product_id);

                $proje_stoklari_id = '';
                $proje_stoklari_details = $this->db->query("SELECT * FROM talep_form_products Where id = $talep_form_product_id and proje_stoklari_id is not null");
                if($proje_stoklari_details->num_rows()){
                    $proje_stoklari_id = $proje_stoklari_details->row()->proje_stoklari_id;
                }
                if($product_stock_code_id){
                    $stock_id = stock_update_new($product_id,$unit_id,$warehouse_item_qty,1,$warehouse_id,$this->aauth->get_user()->id,$talep_id,1,$proje_stoklari_id);
                    $options_id='';
                    $option_value_id='';
                    $i=0;
                    stock_update_options_new($stock_id,$product_stock_code_id);
                }
                else {
                    $stock_id = stock_update_new($product_id,$unit_id,$warehouse_item_qty,1,$warehouse_id,$this->aauth->get_user()->id,$talep_id,1,$proje_stoklari_id);

                }
                //numaric_update(28);


            }
            if($index){
                $this->db->insert_batch('teslimat_warehouse_item', $product_list);

                //tamamlama KOntrolü

                //tamamlama KOntrolü

                $this->aauth->applog("Depoya Mal Girişi Yapılmıştır: ".$talep_details->code, $this->aauth->get_user()->username);
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success','message'=>'Başarıyla Güncellendi'));
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
            }
        }
        elseif($talep_details->talep_type==3) {
            $product_details=$this->input->post('product_details');
            $index=0;
            $product_list=[];
            foreach ($product_details as $items_) {
                $product_id = $items_['product_id'];
                $teslimat_warehouse_id = $items_['teslimat_warehouse_id'];
                $warehouse_item_qty = $items_['warehouse_item_qty'];
                $warehouse_item_notes = $items_['warehouse_item_notes'];
                $talep_form_product_id = $this->db->query("SELECT * FROM warehouse_teslimat where id = $teslimat_warehouse_id")->row()->talep_form_product_id;
                $data = [
                    'teslimat_warehouse_id' => $teslimat_warehouse_id,
                    'warehouse_item_qty' => $warehouse_item_qty,
                    'warehouse_item_notes' => $warehouse_item_notes,
                    'product_id' => $product_id,
                    'talep_form_product_id' => $talep_form_product_id,
                ];
                $product_list[$index] = $data;
                $index++;

                $product_name = who_demirbas($product_id)->name;
                $details_teslimat = $this->db->query("SELECT * FROM `warehouse_teslimat` Where id=$teslimat_warehouse_id")->row();
                $unit_id = $details_teslimat->unit_id;
                $warehouse_id = $details_teslimat->teslim_edilecek_warehouse_id;
                $unit_name = units_($unit_id)['name'];
                $this->talep_history($talep_id, $this->aauth->get_user()->id, 'Depoya  ' . $product_name . ' Ürününden : ' . $warehouse_item_qty . ' ' . $unit_name . ' Giriş Yapılmıştır' . ' Açıklama' . $warehouse_item_notes);
                $stock_id = stock_update_new($product_id,$unit_id,$warehouse_item_qty,1,$warehouse_id,$this->aauth->get_user()->id,$talep_id,1);


            }
            if($index){
                $this->db->insert_batch('teslimat_warehouse_item', $product_list);

                $this->aauth->applog("Depoya Mal Girişi Yapılmıştır: ".$talep_details->code, $this->aauth->get_user()->username);
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success','message'=>'Başarıyla Güncellendi'));
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
            }
        }



    }

    public function qaime_create(){

        $this->db->trans_start();
        $concat_mt_id=$this->input->post('concat_mt_id');
        $talep_id=$this->input->post('talep_id');
        $subtotal=$this->input->post('subtotal');
        $shipping=$this->input->post('teslimat_tutar');
        $invoice_type=$this->input->post('invoice_type_id');
        $total=$this->input->post('total');
        $notes=$this->input->post('notes');
        $customer_id=$this->input->post('csd');
        $para_birimi=$this->input->post('para_birimi');
        $discount_type=$this->input->post('discount_type');
        $invoice_no=$this->input->post('invoice_no');
        $method=$this->input->post('method');
        $alt_cari_id=$this->input->post('alt_cari_id');
        $tax=$this->input->post('tax');
        $product_details=$this->input->post('product_details');
        $description=$this->input->post('description');
        $discountFormat='flat';
        if($discount_type==2){
            $discountFormat='%';
        }

        $bill_date = datefordatabase($this->input->post('invoicedate'));
        $bill_due_date = datefordatabase($this->input->post('invoiceduedate'));
        $talep_details = $this->talep->details($talep_id);
        $proje_id = $talep_details->proje_id;
        $warehouse_details = talep_warehouse_details($talep_id);
        $invoice_details = invoice_talep_details($talep_id);

        $item_array=[];
        if($invoice_details){
            foreach ($invoice_details as $items_invoices){
                $item_array[]=$items_invoices->item_id; //7364  7361 7363
                }
        }


        // Zorunlu alan kontrolü
        //if (empty($description) || empty($invoice_no) || empty($this->input->post('invoicedate')) || empty($this->input->post('invoiceduedate'))) {
        if (empty($invoice_no) || empty($this->input->post('invoicedate'))) {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>" Fatura No, Fatura Tarihi" ));
            return;
        }

        $data = array(
            'tid' => 1,
            'invoicedate' => $bill_date,
            'invoiceduedate' => $bill_due_date,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'ship_tax' => 0,
            'tax' =>$tax,
            'invoice_type_id' => $invoice_type,
            'invoice_type_desc' => invoice_type_id($invoice_type),
            'ship_tax_type' => 'incl',
            'total' => $total,
            'notes' => $notes,
            'csd' => $customer_id,
            'eid' => $this->aauth->get_user()->id,
            'taxstatus' => '',
            'discstatus' => 1,
            'format_discount' => $discountFormat,
            'discount_rate' => 0,
            'refer' => '',
            'term' => 1,
            'multi' => 0,
            'para_birimi' => $para_birimi,
            'kur_degeri' => 1,
            'invoice_no' => $invoice_no,
            'loc' => $this->aauth->get_user()->loc,
            'dosya_id' => 0,
            'ithalat_ihracat_tip' => 0,
            'asama_id' => 0,
            'alt_asama_id' => 0,
            'task_id' => 0,
            'bolum_id' => 0,
            'proje_id' => $proje_id,
            'method' => $method,
            'alt_cari_id' => $alt_cari_id,
            'notes' => $description,
            'stok_guncelle' => 0,

        );
        if ($this->db->insert('geopos_invoices', $data)) {
            $last_id = $this->db->insert_id();
            $productlist=[];
            $prodindex=0;

            foreach ($product_details as $items){
//                if(!in_array($items['item_id'],$item_array)){
                    $price=$items['item_price'];
                    if($items['item_edv_durum']==1){
                        $price=$items['item_price']/(1+(floatval($items['item_kdv'])/100));
                    }

                    if($talep_details->talep_type==1){
                        $product_name = product_name($items['product_id']);
                    }
                    elseif($talep_details->talep_type==2){
                        $product_name = product_name($items['product_id']);
                    }
                    elseif($talep_details->talep_type==3){
                        $product_name = who_demirbas($items['product_id'])->name;
                    }




                    $data_item = array(
                        'tid' => $last_id,
                        'pid' => $items['product_id'],
                        'product' =>  $product_name,
                        'code' => '',
                        'qty' => $items['item_qty'],
                        'price' => $price,
                        'tax' => $items['item_kdv'],
                        'tax_type' => $items['item_edv_durum'],
                        'discount' => $items['item_discount'],
                        'subtotal' => $items['item_umumi_hidden'],
                        'totaltax' => $items['edv_tutari_hidden'],
                        'totaldiscount' => $items['item_discount_hidden'],
                        'product_des' => '',
                        'unit' => $items['item_unit_id'],
                        'invoice_type_id' => $invoice_type,
                        'proje_id' => $proje_id,
                        'depo_id' => $warehouse_details->id,
                        'bolum_id' => $talep_details->bolum_id,
                        'asama_id' => $talep_details->asama_id,
                        'item_desc' => '',
                        'invoice_type_desc' => invoice_type_id($invoice_type)
                    );

                    $prodindex++;
                    $this->db->insert('geopos_invoice_items', $data_item);
                    $invoice_items_id = $this->db->insert_id();
                    $this->db->insert('geopos_project_items_gider', $data_item);

                    $talep_form_item_id = $items['talep_form_item_id'];

                    $mt_id = $this->db->query("SELECT * FROM `talep_form_products` Where id=$talep_form_item_id")->row()->form_id;
                    $options = talep_form_product_options_teklif_values($talep_form_item_id);

                    $data_invoice_to_talep=[
                        'talep_id'=>$mt_id,
                        'item_id'=>$items['item_id'],
                        'invoice_id'=>$last_id,
                    ];
                    $this->db->insert('talep_to_invoice',$data_invoice_to_talep);

                    if($options){
                        $varyasyon=[
                            'invoices_item_id'=>$invoice_items_id,
                            'product_stock_code_id'=>$options,
                        ];
                        $this->db->insert('invoices_item_to_option',$varyasyon);

                    }


                    $this->talep->product_price_details_add_func($items['talep_form_item_id'],$mt_id,$price);
//                }


            }

            if ($prodindex > 0) {
                if($shipping > 0){
//9386
                    $product_name = product_name(9386);
                    $data_item_ship = array(

                        'tid' => $last_id,

                        'pid' => 9386,

                        'product' =>  $product_name,

                        'code' => '',

                        'qty' => 1,

                        'price' => $shipping,

                        'tax' => 0,

                        'discount' => 0,

                        'subtotal' => $shipping,

                        'totaltax' => 0,

                        'totaldiscount' => 0,

                        'product_des' => '',

                        'unit' => 9,

                        'invoice_type_id' => $invoice_type,

                        'proje_id' => $proje_id,

                        'depo_id' => $warehouse_details->id,
                        'item_desc' => '',

                        'invoice_type_desc' => invoice_type_id($invoice_type)
                    );
                    $this->db->insert('geopos_invoice_items', $data_item_ship);
                }
                $this->talep_history($talep_id,$this->aauth->get_user()->id,'Qaime Oluşturulmuştur. Qaime No :'.$invoice_no);
                $this->aauth->applog("Qaime Oluştuldu: ".$talep_details->code, $this->aauth->get_user()->username);

                if($concat_mt_id) // Birleştirme Var İse
                {
                    foreach ($concat_mt_id as $mt_id){

                    }
                }


                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success','message'=>'Başarıyla Qaime Oluşturuldu'));
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun" ));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun" ));
        }
    }
    public function qaime_mt_app(){
        $mt_id_=$this->input->post('mt_id');
        $cari_id=$this->input->post('cari_id');

        $items=[];
        if($mt_id_){
            foreach ($mt_id_ as $mt_id){
                $details = $this->talep->details($mt_id);

                foreach (tehvil_products_cari($mt_id,$cari_id) as $products){


                    $talep_form_item_id = talep_form_item_id($products->onay_list_id);
                    $details_items = tehvil_products_cari_new($products->id);

                    if($details->talep_type==1){
                        $product_name= product_details_($products->product_id)->product_name;
                    }
                    elseif($details->talep_type==2) {
                        $product_name= product_details_($products->product_id)->product_name;
                    }
                    elseif($details->talep_type==3) {
                        $product_name= who_demirbas($products->product_id)->name;
                    }



                    $unit_name = units_($products->unit_id)['name'];
                    $qty = tehvil_cari_form_product($cari_id,$mt_id,$products->product_id,$products->talep_form_product_id)['alinan_miktar'];

                    $items[]= [
                        'details'=>tehvil_products_cari($mt_id, $cari_id),
                        'product_name'=>$product_name,
                        'talep_form_item_id'=>$talep_form_item_id,
                        'unit_name'=>$unit_name,
                        'details_items'=>$details_items,
                        'product_id'=>$products->product_id,
                        'unit_id'=>$products->unit_id,
                        'edv_type'=>$products->edv_type,
                        'qty'=>$qty,
                    ];
                }
            }
            if($items){
                echo json_encode(array('status' => 'Success','items'=>$items));
            }
            else {
                echo json_encode(array('status' => 'Error'));
            }
        }
        else {
            echo json_encode(array('status' => 'Error'));
        }


    }

    public function teklif_print(){
        $cari_id = $this->input->get('cari_id');
        $form_id = $this->input->get('form_id');

        $data['items_']=techizatcilar_item($form_id,$cari_id);
        $data['cari_id']=$cari_id;
        $data['form_id']=$form_id;
        $data['details']= $this->talep->details($form_id);
        $data['proje_code']=proje_code($data['details']->proje_id);

        $teklif_id=0;
        $details_id=0;
        $teklif = cari_to_teklif($cari_id,$form_id);
        if($teklif){
            $teklif_id = $teklif->id;
            $details_id_row =$this->db->query("Select * From talep_form_teklifler_details Where tf_teklif_id=$teklif_id");
            if($details_id_row->num_rows()){
                $details_id= $details_id_row->row()->id;
                $data['teklif_id']=$teklif_id;

                $data['teklif_details']= $this->talep->teklif_details($teklif_id);

                $data['details_id']=$details_id;

                $data['teklif_details_items']= $this->talep->teklif_details_items($data['teklif_details']->id);


                $data['teklif_kontrol']=teklif_update_kontrol($teklif_id);

                ini_set('memory_limit', '999M');
                $html = $this->load->view('fileprint/mt_teklif_print_view', $data, true);
                $header = $this->load->view('fileprint/mt_teklif_print_header', $data, true);
                $footer = $this->load->view('fileprint/mt_teklif_print_footer', $data, true);

                $this->load->library('pdf');

                $pdf = $this->pdf->load_split();

                $pdf->SetHTMLHeader($header);

                $pdf->SetHTMLFooter($footer);
                $pdf->AddPage(
                    'L', // L - landscape, P - portrait
                    '', '', '', '',
                    '', // margin_left
                    '', // margin right
                    55, // margin top
                    '72', // margin bottom
                    5, 2, 0, 0, // margin header
                    'auto'); // margin footer

                $pdf->WriteHTML($html);
                $file_name ="Teklif__";
                $pdf->Output($file_name . '.pdf', 'I');
            }
            else {
                echo "Teklif Oluşturunuz!";
            }
        }


    }

    public function talep_list_print($file_id){

        $data['items']= $this->talep->product_details($file_id);
        $data['details']= $this->talep->details($file_id);
        $data['siparis_list_kontrol']= siparis_list_kontrol($file_id);

        ini_set('memory_limit', '990999M');
        $html = $this->load->view('fileprint/mt_list_print_view', $data, true);
        $header = $this->load->view('fileprint/mt_list_print_header', $data, true);
        $footer = $this->load->view('fileprint/mt_siparis_print_footer', $data, true);

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
            '15', // margin bottom
            5, 2, 0, 0, // margin header
            'auto'); // margin footer


        $pdf->WriteHTML($html);


        $file_name ="Teklif__";


        $pdf->Output($file_name . '.pdf', 'I');
    }

    public function siparis_print($file_id){

        $data['siparis_list_kontrol']= siparis_list_kontrol($file_id);
        $data['details']= $this->talep->details($file_id);
        ini_set('memory_limit', '999M');
        $html = $this->load->view('fileprint/mt_siparis_print_view', $data, true);
        $header = $this->load->view('fileprint/mt_siparis_print_header', $data, true);
        $footer = $this->load->view('fileprint/mt_siparis_print_footer', $data, true);

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


        $file_name ="Teklif__";


        $pdf->Output($file_name . '.pdf', 'I');
    }

    public function ihale_open(){
        $this->db->trans_start();
        $form_id=$this->input->post('form_id');
        $tip=$this->input->post('tip');
        $details = $this->talep->details($form_id);
        $proje_id = $details->proje_id;
        $user_id  = $this->aauth->get_user()->id;
        if($tip==1){ //Eğer 1 ise sadece yetkililer açabilir ancak eğer 2 ise hem yetkili hemde satınalma personeli acabilir

            if($details->talep_type==1 || $details->talep_type==2){
//                $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $proje_id and (  proje_sorumlusu_id=$user_id or proje_muduru_id=$user_id or muhasebe_muduru_id=$user_id or genel_mudur_id=$user_id)")->num_rows();
//                if($yetkili_kontrol || $user_id==1009 || $user_id==21){
//                    $data_Form=array(
//                        'durum'=>2,
//                    );
//                    $this->db->set($data_Form);
//                    $this->db->where('talep_id', $form_id);
//                    $this->db->update('teklif_counter', $data_Form);
//                    $this->aauth->applog("İhale Açılmıştır: ".$details->code, $this->aauth->get_user()->username);
//                    $this->talep_history($form_id,$this->aauth->get_user()->id,'İhale Açılmıştır ');
//                    $this->db->trans_complete();
//                    echo json_encode(array('status' => 'Success','message'=>'Başarıyla İhale Açılmıştır'));
//                }
//                else {
//                    $this->db->trans_rollback();
//                    echo json_encode(array('status' => 'Error', 'message' =>"Yetkiniz Mevcut Değildir" ));
//                }

                $data_Form=array(
                    'durum'=>2,
                );
                $this->db->set($data_Form);
                $this->db->where('talep_id', $form_id);
                $this->db->update('teklif_counter', $data_Form);
                $this->aauth->applog("İhale Açılmıştır: ".$details->code, $this->aauth->get_user()->username);
                $this->talep_history($form_id,$this->aauth->get_user()->id,'İhale Açılmıştır ');
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success','message'=>'Başarıyla İhale Açılmıştır'));
            }
            else {
                $data_Form=array(
                    'durum'=>2,
                );
                $this->db->set($data_Form);
                $this->db->where('talep_id', $form_id);
                $this->db->update('teklif_counter', $data_Form);
                $this->aauth->applog("İhale Açılmıştır: ".$details->code, $this->aauth->get_user()->username);
                $this->talep_history($form_id,$this->aauth->get_user()->id,'İhale Açılmıştır ');
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success','message'=>'Başarıyla İhale Açılmıştır'));
            }



        }
        else if($tip==2){
            $satinalma_personeli = $this->talep->talep_user_satinalma($form_id)->user_id;
            $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $proje_id and (  proje_sorumlusu_id=$user_id or proje_muduru_id=$user_id or muhasebe_muduru_id=$user_id or genel_mudur_id=$user_id)")->num_rows();
            if($satinalma_personeli==$user_id || $yetkili_kontrol || $user_id==1009 || $user_id==21){
                $data_Form=array(
                    'durum'=>2,
                );
                $this->db->set($data_Form);
                $this->db->where('talep_id', $form_id);
                $this->db->update('teklif_counter', $data_Form);
                $this->aauth->applog("İhale Açılmıştır: ".$details->code, $this->aauth->get_user()->username);
                $this->talep_history($form_id,$this->aauth->get_user()->id,'İhale Açılmıştır ');
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success','message'=>'Başarıyla İhale Açılmıştır'));
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Yetkiniz Mevcut Değildir" ));
            }
        }
    }

    public function accountlist(){
        $user_id  = $this->aauth->get_user()->id;
        $aacount_list = personel_account($user_id);
        echo json_encode(array('status' => 200, 'account_list' =>$aacount_list));

    }

    public function talep_form_teklif_cari_details(){
        $talep_id=$this->input->post('talep_id');
        $details = $this->talep->talep_form_teklif_cari_details($talep_id);
        if(count($details)){
            echo json_encode(array('status' => 200, 'details' =>$details));
        }
        else {
            echo json_encode(array('status' => 410, 'messages' =>'Cari Belirlenmemiş'));
        }


    }

    public function mt_cari_update(){
        $this->db->trans_start();
        $result = $this->talep->mt_cari_update();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function invoice_pay_mt(){
        $this->db->trans_start();
        $result = $this->talep->invoice_pay_mt();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function get_product_to_value(){
        $product_id=$this->input->post('product_id');
        // $html = product_to_option_html($product_id);
        $html = product_to_option_html_news($product_id);
        if($html['status']){
            echo json_encode(array('code' => 200, 'html' =>$html['html'] ));
        }
        else {
            echo json_encode(array('code' => 410, 'html' =>'<h3>Herhangi Bir Varyasyon Bulunamadı</h3>' ));
        }
    }



    public function tehvil_print(){
        $tehvil_details = $this->input->post('tehvil_details');
        $talep_id = $this->input->post('talep_id');

        $id=[];
        foreach ($tehvil_details as $items){
            $id[]=$items['teslimat_warehouse_id'];
        }
        $id_str =  implode(',',$id);
        $this->session->set_userdata('id_str', $id_str);
        $this->session->set_userdata('talep_id', $talep_id);
        if($id_str){

            echo json_encode(array('code' => 200,'message'=>'PDF Dosyanız Hazırdır Açmak İçin Tamama Basınız', 'href' =>'/malzemetalep/tehvil_print_r' ));
        }
        else {
            echo json_encode(array('code' => 410, 'message' =>'Hata Aldınız Yöneticiye Başvurunuz' ));
        }


    }

    public function tehvil_print_r(){
        $id_str = $this->session->userdata('id_str');
        $file_id = $this->session->userdata('talep_id');
        $data['tehvil_products']= $this->db->query("SELECT * FROM `warehouse_teslimat` Where id IN ($id_str)")->result();
        $data['details']= $this->talep->details($file_id);
        ini_set('memory_limit', '999M');
        $html = $this->load->view('fileprint/mt_tehvil_print_view', $data, true);
        $header = $this->load->view('fileprint/mt_tehvil_print_header', $data, true);
        $footer = $this->load->view('fileprint/mt_tehvil_print_footer', $data, true);

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


        $file_name ="Teklif__";


        $pdf->Output($file_name . '.pdf', 'I');
    }



    public function test2(){
        $details = $this->db->query("SELECT * FROM talep_form_products_options Where talep_form_product_id=4283");

        if ($details->num_rows()) {
            $option_html = '';
            foreach ($details->result_array() as $options_items) {
                $option_id=numaric(28);
                $option_value_id=numaric(28);
                if($options_items['option_id']){
                    $option_id=$options_items['option_id'];
                }
                if($options_items['option_value_id']){
                    $option_value_id=$options_items['option_value_id'];
                }
                $array[] = [
                    'option_id' => $option_id,
                    'option_value_id' => $option_value_id,
                ];
                //$option_html.="<span style='font-size: 10px'> ".$options_items['option_name'].' : '.$options_items['option_value_name']."</span>";
            }
        }
        echo "<pre>";print_r($array);
    }


    public function talep_pay(){
        $this->db->trans_start();
        $result = $this->talep->talep_pay();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }
    public function talep_pay_info(){
       $id = $this->input->post('form_id');
        $cari_details = [];

        $teklif_details = $this->db->query("SELECT * FROM talep_form_teklifler  Where form_id=$id GROUP BY cari_id");
       if($teklif_details->num_rows()){
           foreach ($teklif_details->result() as $items){
               $cari_details[] = $this->db->query("select * from geopos_customers WHERE id=$items->cari_id")->row();
           }

           echo json_encode(array('status' => 200, 'cari_details' =>$cari_details));
       }
       else {
           echo json_encode(array('status'=> 410, 'message'=>'BU Talebe Ait Henüz Bir Cari Atanmamıştır'));
       }
    }

    public function talep_pay_cari_transactions(){
        $id = $this->input->post('cari_id');
        $transactions = [];
        $invoices_details = $this->db->query("SELECT * FROM geopos_invoices  Where csd=$id and invoice_type_id IN (4,14,43)");
       if($invoices_details->num_rows()){
           foreach ($invoices_details->result() as $items){
               $transactions[] = [
                   'id'=>$items->id,
                   'invoicedate'=>$items->invoicedate,
                   'notes'=>$items->notes,
                   'method'=>account_type_sorgu($items->method),
                   'total'=>amountFormat($items->total),
               ];
           }
           echo json_encode(array('status' => 200, 'transactions' =>$transactions));
       }
       else {
           echo json_encode(array('status'=> 410, 'message'=>'Bu Cariye Ait Henüz Bir Ödeme Yoktur'));
       }
    }

    public function transfer_details() {
        $id = $this->input->post('form_id');
        $details = $this->talep->details($id);
        $html='';
        if(!$details->transfer_status) // 1 == transferli demek
        {
            $html="<div class='form-group'>
                                <div class='row'>
                                    <div class='col-md-12'>
                                    <label>Depo Seçiniz</label>
                                    <select class='form-control select-box' id='warehouse_id'>
                                    ";
            foreach (all_warehouse(0) as  $items){
                $html.="<option value='$items->id'>$items->title</option>";
            }
            $html.="</select>
                                </div>
                                <div class='col-md-12'>
                                    <label>Transfer Deposu Seçiniz</label>
                                    <select class='form-control select-box' id='transfer_warehouse_id'>
                                    ";
            foreach (all_warehouse(0) as  $items){
                $html.="<option value='$items->id'>$items->title</option>";
            }
            $html.="</select>
                                </div>
                                </div>
                            </div>";

        }
        else { // transfersiz
            $html="<div class='form-group'>
                                <div class='row'>
                                    <div class='col-md-12'>
                                    <label>Depo Seçiniz</label>
                                    <select class='form-control select-box' id='warehouse_id'>
                                    ";
            foreach (all_warehouse(0) as  $items){
                $html.="<option value='$items->id'>$items->title</option>";
            }
            $html.="</select>
                                </div>
                                </div>
                            </div>";
        }

        echo json_encode(array('status' => 200, 'html' =>$html,'transfer_status'=>$details->transfer_status));



    }

    public function transfer_change_new(){

        $transfer_status=$this->input->post('transfer_status');
        $talep_id=$this->input->post('talep_id');
        $details = $this->talep->details($talep_id);
        $type=[1,2,3,4,7];
        if(in_array($details->status,$type)){
            if($transfer_status){
                $warehouse_id=$this->input->post('warehouse_id');

                $data_Form=array(
                    'transfer_status'=>0,
                    'warehouse_id'=>$warehouse_id,
                );
                $this->db->set($data_Form);
                $this->db->where('id', $talep_id);
                $this->db->update('talep_form', $data_Form);

                $data_Form_teslimat=array(
                    'teslim_edilecek_warehouse_id'=>$warehouse_id,
                );
                $this->db->set($data_Form_teslimat);
                $this->db->where('form_id', $talep_id);
                $this->db->update('warehouse_teslimat', $data_Form_teslimat);



            }
            else {
                $warehouse_id=$this->input->post('warehouse_id');
                $transfer_warehouse_id=$this->input->post('transfer_warehouse_id');

                $data_Form=array(
                    'transfer_status'=>1,
                    'warehouse_id'=>$warehouse_id,
                    'transfer_warehouse_id'=>$transfer_warehouse_id,
                );
                $this->db->set($data_Form);
                $this->db->where('id', $talep_id);
                $this->db->update('talep_form', $data_Form);

            }

            echo json_encode(array('status' => 200,'messages'=>'Başarılı İle Güncellendi'));
        }
        else {
            echo json_encode(array('status' => 410,'messages'=>'Talep Formun Durumu Bu Değişilkiğe Müsait Değildir. Yazılımcıya Başvurun'));
        }



    }

    public function dashboard_mail(){

        $id = $this->input->post('pers_id');
        $baslik = $this->input->post('baslik');
        $content_message = $this->input->post('content_message');
        $content_message.=' Mesajı Gönderen Kullanıcı : '.$this->aauth->get_user()->username;
        if($this->send_mail($id,$baslik,$content_message)){
            echo json_encode(array('status' => 200,'messages'=>'Başarılı İle Mail Gönderildi'));
        }
        else {
            echo json_encode(array('status' => 410,'messages'=>'Mail Gönderme Başarısız Oldu'));
        }
    }

    public function stok_kontrol_list()
    {
        $result = $this->talep->stok_kontrol_list();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }

    public function product_duzenle()
    {
        $talep_id = $this->input->post('talep_id');
        $details=$this->db->query("SELECT * FROM talep_form where id=$talep_id")->row();
        $product_id = $this->input->post('product_details')[0]['product_id'];
        $teslimat_warehouse_id = $this->input->post('product_details')[0]['teslimat_warehouse_id'];
        $yeni_miktar = $this->input->post('yeni_miktar');
        $new_unit_id = $this->input->post('new_unit_id');
        $aciklama = $this->input->post('aciklama');
        $birim_fiyati = $this->input->post('birim_fiyati');



        $talep_form_product_id=$this->db->query("SELECT * FROM warehouse_teslimat Where id = $teslimat_warehouse_id")->row()->talep_form_product_id;

        $item_details=$this->db->query("SELECT * FROM talep_form_products  WHERE id=$talep_form_product_id")->row();

        $old_miktar=$item_details->product_qty.' '.units_($item_details->unit_id)['name'];

        $product_name='';
        if($details->talep_type==1){
            $product_name= product_details_($item_details->product_id)->product_name;
        }
        elseif($details->talep_type==2) {
            $product_name= product_details_($item_details->product_id)->product_name;
        }
        elseif($details->talep_type==3) {
            $product_name= who_demirbas($item_details->product_id)->name;
        }


        //talep form products tablosunda değişiklik yapılıyor
        $this->db->set('unit_id', $new_unit_id);
        $this->db->set('product_qty', $yeni_miktar);
        $this->db->where('id', $talep_form_product_id);
        $this->db->update('talep_form_products');
        $this->talep_history($talep_id,$this->aauth->get_user()->id,$product_name.'Eski Miktar:'.$old_miktar.' Ürünü İçin Yeni Miktar : '.$yeni_miktar.' Yeni Birim : '.units_($new_unit_id)['name'].' Açıklama : '.$aciklama);
        //talep form products tablosunda değişiklik yapılıyor


        //talep_form_teklifler_item_details tablosunda değişiklik
        $total=floatval($yeni_miktar)*floatval($birim_fiyati);
        $talep_form_teklifler_item_details = $this->db->query("SELECT * FROM talep_form_teklifler_item_details Where tfitem_id=$talep_form_product_id")->row();
        $cemi=$total;
        $edv_tutari=0;
        if($talep_form_teklifler_item_details->edv_type){

            $cemi = floatval($total) / (1+ (floatval($talep_form_teklifler_item_details->edv_oran)/100));
            $edv_tutari = floatval($cemi) *(floatval($talep_form_teklifler_item_details->edv_oran)/100);
            $edv_tutari_price = floatval($cemi) * (floatval($talep_form_teklifler_item_details->edv_oran)/100);
        }
        else {
            $edv_tutari = $total *(floatval($talep_form_teklifler_item_details->edv_oran)/100);
            $total=floatval($cemi)+floatval($edv_tutari);
            $edv_tutari_price = 0;
        }



        $this->db->set('sub_total', $cemi);
        $this->db->set('kdv_total', $edv_tutari);
        $this->db->set('total', $total);
        $this->db->set('price', $birim_fiyati);
        $this->db->set('qty', $yeni_miktar);
        $this->db->where('tfitem_id', $talep_form_product_id);
        $this->db->update('talep_form_teklifler_item_details');

        //talep_form_teklifler_item_details tablosunda değişiklik

        $cari_id=$this->db->query("SELECT * FROM warehouse_teslimat Where id = $teslimat_warehouse_id")->row()->cari_id;
        $talep_form_teklifler_item_details = $this->db->query("SELECT * FROM talep_form_teklifler Where form_id=$talep_id and cari_id = $cari_id")->row();



        $tf_teklif_id=$talep_form_teklifler_item_details->id; //4259


        //muqayese edin aşaması

        $item_products_id = [];
        $item_products = $this->db->query("SELECT * FROM talep_form_products  WHERE form_id=$talep_id")->result();
        foreach ($item_products as $ip){
            $item_products_id[]=$ip->id;

            $this->db->delete('teslimat_warehouse_item', array('talep_form_product_id' => $ip->id));

        }
        $id_str = implode(',',$item_products_id);


        $talep_form_teklifler_item_details = $this->db->query("SELECT * FROM talep_form_teklifler_details Where tf_teklif_id=$tf_teklif_id")->row();

        $details_id = $talep_form_teklifler_item_details->id;

        $talep_form_teklifler_item_details_for = $this->db->query("SELECT * FROM talep_form_teklifler_item_details WHERE details_id = $details_id")->result();


        $alt_sub_total_val=0;
        $alt_edv_total_val=0;
        $alt_total_val=0;
        foreach ($talep_form_teklifler_item_details_for as $totals){
            $alt_sub_total_val+=$totals->sub_total;
            $alt_edv_total_val+=$totals->kdv_total;
            $alt_total_val+=$totals->total;
        }




        $this->db->set('alt_sub_total_val', $alt_sub_total_val);
        $this->db->set('alt_edv_total_val', $alt_edv_total_val);
        $this->db->set('alt_total_val', $alt_total_val);
        $this->db->where('tf_teklif_id', $tf_teklif_id);
        $this->db->update('talep_form_teklifler_details');


        //muqayese edin aşaması

        //Teklif Son DUrum

        $siparis_list_id=$this->db->query("SELECT * FROM `siparis_list_form` Where talep_form_product_id=$talep_form_product_id and deleted_at is Null")->row()->id;

        //talep_form_product_id IN (21428,21429)
        $this->db->set('new_unit_id', $new_unit_id);
        $this->db->set('new_item_qty', $yeni_miktar);
        $this->db->set('new_item_price', $birim_fiyati);
        $this->db->set('edv_tutari_hidden', $edv_tutari);
        $this->db->set('item_umumi_hidden', $cemi);
        $this->db->set('item_umumi_cemi_hidden', $cemi);
        $this->db->where('siparis_liste_form_id', $siparis_list_id);
        $this->db->update('siparis_list_form_new');
        //Teklif Son DUrum

        // Depo Durumu

        $this->db->set('qty', $yeni_miktar);
        $this->db->set('unit_id', $new_unit_id);
        $this->db->where('talep_form_product_id', $talep_form_product_id);
        $this->db->update('warehouse_teslimat');


        $this->db->delete('stock', array('mt_id' => $talep_id,'form_type' => 1));

        echo json_encode(array('status' => 'Success','message'=>'Tüm Değişiklikler Sağlandı'));
        // Depo Durumu
    }
    public function product_move()
    {
        $this->db->trans_start();
        $miktar_guncelleme=0;
        $move_product=0;
        $talep_id=$this->input->post('talep_id');
        $desc=$this->input->post('desc');
        $item_product_id=$this->input->post('item_product_id');
        $new_mt_id=$this->input->post('new_mt_id');
        if($item_product_id){
            foreach ($item_product_id as $item_products){
                $talep_form_product_id = $item_products;
                $item_details = $this->db->query("SELECT * FROM talep_form_products Where id =$talep_form_product_id")->row();

                $kontrol = $this->db->query("SELECT * FROM talep_form_products Where product_id=$item_details->product_id and product_stock_code_id=$item_details->product_stock_code_id and form_id = $new_mt_id");
                if(!$kontrol->num_rows()){
                    $data = array(
                        'product_id' => $item_details->product_id,
                        'progress_status_id' => $item_details->progress_status_id,
                        'product_desc' => $item_details->product_desc,
                        'product_kullanim_yeri' => $item_details->product_kullanim_yeri,
                        'product_temin_date' => $item_details->product_temin_date,
                        'unit_id' => $item_details->unit_id,
                        'product_qty' => $item_details->product_qty,
                        'form_id' => $new_mt_id,
                        'proje_stoklari_id' => $item_details->proje_stoklari_id,
                        'product_stock_code_id' => $item_details->product_stock_code_id,
                        'aauth' => $this->aauth->get_user()->id,
                        'move_talep_id' => $talep_id
                    );
                    if ($this->db->insert('talep_form_products', $data)) {

                        $old_talep_details=$this->talep->details($talep_id);
                        $product_name= product_details_($item_details->product_id)->product_name;
                        $unit_name = units_($item_details->unit_id)['name'];
                        $this->db->delete('talep_form_products', array('id' => $talep_form_product_id));
                        $this->talep_history($new_mt_id,$this->aauth->get_user()->id,$old_talep_details->code.' Kodlu MTden Ürün Transfer Edildi : '.$product_name.' | '.$item_details->product_qty.' '.$unit_name.' Personel Açıklama : '.$desc);
                        $move_product++;

                    }
                    else {
                        return [
                            'status'=>0,
                            'id'=>0
                        ];
                    }
                }
                else {
                    //Miktar artırma
                    $old_miktar = $kontrol->row()->product_qty;
                    $talep_form_old_product_id = $kontrol->row()->id;
                    $new_miktar = $old_miktar+$item_details->product_qty;
                    $this->db->set('product_qty', "$new_miktar", FALSE);
                    $this->db->set('move_talep_id', $talep_id);
                    $this->db->where('id', $talep_form_old_product_id);
                    if($this->db->update('talep_form_products')){
                        $old_talep_details=$this->talep->details($talep_id);
                        $product_name= product_details_($item_details->product_id)->product_name;
                        $unit_name = units_($item_details->unit_id)['name'];
                        $this->db->delete('talep_form_products', array('id' => $talep_form_product_id));
                        $this->talep_history($new_mt_id,$this->aauth->get_user()->id,$old_talep_details->code.' Kodlu MTden Ürün Transfer Edildi.Aynı Ürün Olduğundan Miktar Güncellendi: Eski Miktar '.$product_name.' | '.$item_details->product_qty.' '.$unit_name.' Yeni Miktar : '.$new_miktar.' '.$unit_name.'Personel Açıklama : '.$desc);
                        $miktar_guncelleme++;

                    }
                }


            }

            if($move_product){
                $this->db->trans_complete();
                $message='';
                if($miktar_guncelleme){
                  $message=$miktar_guncelleme.' Adet  Aynı Ürün Olduğundan Miktar Güncellendi.';
                }
                $message.=$move_product.' Adet Ürün Taşındı';
                echo json_encode(array('status' => 200,'message'=>$message));
            }
            else {
                $this->db->trans_complete();
                if($miktar_guncelleme){
                    echo json_encode(array('status' => 200,'message'=>$miktar_guncelleme.' Adet  Aynı Ürün Olduğundan Miktar Güncellendi'));
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 410,'message'=>'Hata Aldınız'));
                }
            }
        }
    }

    public function fiyat_listesi_getir()
    {
        $product_id = $this->input->post('product_id');
        $product_Stock_code_id = $this->input->post('product_Stock_code_id');
        echo fiyat_listesi_getir($product_id,$product_Stock_code_id);


    }
}
