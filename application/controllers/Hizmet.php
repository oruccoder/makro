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

class Hizmet Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('categories_model');
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('hizmet_model', 'talep');
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
        $this->load->view('hizmet/all_list');
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
        $this->load->view('hizmet/index');
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

            //Gidere İşleme
            $this->load->model('demirbas_model');
            $result = $this->demirbas_model->gider_create_form($form_id,10);
            if($result['status']){
                $this->db->trans_complete();
                $this->talep_history($form_id,$this->aauth->get_user()->id,'Talep Tamamlandı Aşamasına Alındı.');
                echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Tamamlandı"));

            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Gider Eklenirken Hata Aldınız."));
            }
            //Gidere İşleme
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Yetkiniz Bulunmamaktadır."));
        }


    }
    public function test3()
    {
        $talep_id = 24;
        $talep_items_details = $this->db->query("SELECT * FROM talep_form_products Where form_id=$talep_id")->result();

        $details = $this->db->query("SELECT * FROM talep_form Where id=$talep_id")->row();
        $demirbas_id=$details->demirbas_id;
        $firma_demirbas_id=$details->firma_demirbas_id;

        foreach (tehvil_products($talep_id) as $product_items){

            $talep_form_product_id=$product_items->talep_form_product_id;


            $teslim_alinmis = hizmet_teslim_alinmis($talep_id,$product_items->product_id,$talep_form_product_id)['alinan_miktar'];

            echo "<pre>";print_r($product_items);

            $table_name_ = $this->db->query("SELECT * FROM demirbas_firma Where demirbas_id = $demirbas_id")->row()->table_name;

            $item_details = $this->db->query("SELECT * FROM $table_name_ Where id = $firma_demirbas_id")->row();
            $item_name = $item_details->name;
            $item_desc = $item_details->id;
            $item_image = '';
            //echo $item_name."<br>";

        }
    }
    public function test()
    {

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
        $this->load->view('hizmet/test',$data);
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

        $view = $this->load->view('hizmet/qaime_view',$data);
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
            $view = "<a class='btn btn-success view' href='/hizmet/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";

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
            $view = "<a class='btn btn-success view' href='/hizmet/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";

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

        $view = $this->load->view('hizmet/teklif_incele',$data);
        echo json_encode(array('status' => 'Success', 'view' =>$view));

    }

    public function teklif_onay_proje_muduru_onayi(){
        $this->db->trans_start();
        $form_id=$this->input->post('form_id');
        $user_id= $this->aauth->get_user()->id;
        $details=$this->talep->details($form_id);
        $yetkili_kontrol  = $this->db->query("SELECT * FROM `talep_onay_new` where type=2 and  talep_id = $form_id and user_id=$user_id")->num_rows();
        if($yetkili_kontrol){

            $yetkili_kontrol_dublicate  = $this->db->query("SELECT * FROM `talep_onay_new` where type=2 and  talep_id = $form_id and user_id=$user_id and status is not null")->num_rows();

            if($yetkili_kontrol_dublicate){
//                $data_new=array(
//                    'staff'=>0,
//                    'status'=>null,
//                );
//                $this->db->where('talep_id',$form_id);
//                $this->db->where('type',2);
//                $this->db->where('user_id',$user_id);
//                $this->db->set($data_new);
//                $this->db->update('talep_onay_new', $data_new);


                $this->db->set('status',null);
                $this->db->set('staff',0);
                $this->db->set('updated_at', "NOW()", FALSE);
                $this->db->where('talep_id',$form_id);
                $this->db->where('type',2);
                $this->db->where('user_id',$user_id);
                $this->db->update('talep_onay_new');
            }

            $index=0;
            $p_m_onay_kontrol  = $this->db->query("SELECT * FROM `talep_onay_new` where  sort=2 and type=2 and  talep_id = " . $form_id);
            if($p_m_onay_kontrol->num_rows()){
                $this->db->delete('teklif_onay_list', array('form_id' => $form_id,'user_id'=>$this->aauth->get_user()->id));
                $this->db->delete('warehouse_teslimat', array('form_id' => $form_id,'aauth_id'=>$this->aauth->get_user()->id));
                //    Depo Seçilmiş mi KOntrol
                $pm_id2 = $p_m_onay_kontrol->row()->user_id;

                //formdan projenin proje müdürü bulunaca!
                $pm_id = 66;
                if($details->proje_id==35){
                    $pm_id = 62;
                }


                $depo_kontrol  = $this->db->query("SELECT * FROM `warehouse_teslimat` where  form_id = $form_id and aauth_id=$pm_id");
                if($depo_kontrol->num_rows()){
                    foreach ($depo_kontrol->result() as $depo_item){
                        $data_teslimat_warehouse = [
                            'form_id'=>$form_id,
                            'product_id'=>$depo_item->product_id,
                            'qty'=>isset($depo_item->qyt)?$depo_item->qyt:0,
                            'teslim_edilecek_warehouse_id'=>$depo_item->teslim_edilecek_warehouse_id,
                            'warehouse_desc'=>$depo_item->warehouse_desc,
                            'status'=>$depo_item->status,
                            'unit_id'=>$depo_item->unit_id,
                            'warehouse_id'=>$depo_item->warehouse_id,
                            'aauth_id'=>$this->aauth->get_user()->id,
                            'user_id'=>$depo_item->user_id,
                            'cari_id'=>$depo_item->cari_id,
                        ];
                        $this->db->insert('warehouse_teslimat', $data_teslimat_warehouse);
                    }
                }

                // Depo Seçilmiş mi KOntrol
                $teklif_onay_list_kontrol  = $this->db->query("SELECT * FROM teklif_onay_list WHERE form_id = $form_id and `user_id`=$pm_id ORDER BY `id` DESC");
                if($teklif_onay_list_kontrol->num_rows()){


                    foreach ($teklif_onay_list_kontrol->result() as $items){
                        $data_insert = [
                            'talep_form_teklifler_item_details_id'=>$items->talep_form_teklifler_item_details_id,
                            'warehouse_id'=>$items->warehouse_id,
                            'type'=>$items->type,
                            'user_id'=>$this->aauth->get_user()->id,
                            'form_id'=>$form_id,
                            'product_id'=>$items->product_id,
                        ];
                        $this->db->insert('teklif_onay_list', $data_insert);

//                        $return = teklif_onay_list_insert($items->talep_form_teklifler_item_details_id,$items->warehouse_id,$items->type,$this->aauth->get_user()->id,$form_id,$items->product_id);
//
//                            if($return){
//
//                            }
                        $index++;

                    }
                }
                if($index){

                    $this->talep_history($form_id,$this->aauth->get_user()->id,'Ihaleye Onay Verildi');
                    $new_id=0;
                    $new_user_id=0;
                    $new_id_control = $this->db->query("SELECT * FROM `talep_onay_new` Where type=2 and talep_id=$form_id and staff=0 and status is Null ORDER BY `talep_onay_new`.`id` ASC LIMIT 1");
                    if($new_id_control->num_rows()){
                        $new_id = $new_id_control->row()->id;
                        $new_user_id = $new_id_control->row()->user_id;
                    }
                    if($new_id){

                        //eğer 1. Tekrar Onay Verirse
//                    $onay_user_id = $this->db->query("SELECT * FROM talep_onay_new Where id=$new_id")->row()->user_id;
//                    $this->db->delete('teklif_onay_list', array('form_id' => $form_id,'user_id'=>$onay_user_id));
                        //
                        $mesaj=$details->code.' Numaralı Malzeme Talep Formu İhale Sonuçlanmıştır.Onayınız Beklemektedir';
                        //$this->send_mail($new_user_id,'İhale Onayı',$mesaj);

                        // Bir Sonraki Onay

                        $this->db->set('staff',1);
                        $this->db->where('id',$new_id);
                        $this->db->update('talep_onay_new');




                        // Bir Sonraki Onay
                    }
                    else {
                        $satinalma_personeli = $this->talep->talep_user_satinalma($form_id)->user_id;
                        $mesaj=$details->code.' Numaralı Malzeme Talep Formu Onaylanmıştır. Satınalma Formu Hazırlayıp Son Halini Onaya Sunabilirsiniz';
                        //$this->send_mail($satinalma_personeli,'Satınalma Emri',$mesaj);

                        $data_Form=array(
                            'status'=>5,
                        );
                        //satınalmaya geç
                        $this->db->set($data_Form);
                        $this->db->where('id', $form_id);
                        $this->db->update('talep_form', $data_Form);
                        //satınalmaya geç


                    }
//
//
//                    $data = array(
//                        'status' => 1,
//                        'staff' => 0,
//                    );
//
//                    $this->db->where('user_id',$this->aauth->get_user()->id);
//                    $this->db->where('staff',1);
//                    $this->db->where('type',2);
//                    $this->db->set($data);
//                    $this->db->where('talep_id', $form_id);
//                    $this->db->update('talep_onay_new', $data);


                    $this->db->set('staff',0);
                    $this->db->set('status',1);
                    $this->db->set('updated_at', "NOW()", FALSE);

                    $this->db->where('user_id',$this->aauth->get_user()->id);
                    $this->db->where('staff',1);
                    $this->db->where('type',2);
                    $this->db->where('talep_id', $form_id);
                    $this->db->update('talep_onay_new');

                    $this->db->trans_complete();
                    echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Onay Verildi"));

                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Proje Müdürü Onay Vermemiştir."));
                }


            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('code' => 410, 'message' =>'Proje Müdürü Onay Vermemiştir' ));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('code' => 410, 'message' =>'Yetkiniz Bulunmamaktadır' ));
        }

    }
    public function teklif_onay(){


        $this->db->trans_start();

        $form_id=$this->input->post('form_id');
        $data=$this->input->post('data');
        $user_id= $this->aauth->get_user()->id;
        $details=$this->talep->details($form_id);
        $yetkili_kontrol  = $this->db->query("SELECT * FROM `talep_onay_new` where type=2 and  talep_id = $form_id and user_id=$user_id")->num_rows();
        if($yetkili_kontrol){
            $index=0;
            $productlist = array();
            $product_list=[];
            $warehouse_pers_id=[];
            $cari_product_id=[];
            $this->db->delete('teklif_onay_list', array('form_id' => $form_id,'user_id'=>$this->aauth->get_user()->id));
            $this->db->delete('warehouse_teslimat', array('form_id' => $form_id,'aauth_id'=>$this->aauth->get_user()->id));



            $this->db->set('status',1);
            $this->db->set('staff',0);
            $this->db->set('updated_at', "NOW()", FALSE);
            $this->db->where('user_id',$this->aauth->get_user()->id);
            $this->db->where('staff',1);
            $this->db->where('type',2);
            $this->db->where('talep_id', $form_id);
            $this->db->update('talep_onay_new');


            foreach ($data as  $value){
                $talep_form_teklifler_item_details_id=$value['talep_form_teklifler_item_details_id'];
                $product_type = $this->db->query("SELECT talep_form_products.* FROM `talep_form_teklifler_item_details` INNER JOIN talep_form_products ON talep_form_teklifler_item_details.tfitem_id = talep_form_products.id Where talep_form_teklifler_item_details.id = $talep_form_teklifler_item_details_id")->row()->product_type;


                $product_id = $value['product_id'];
                $data_insert_d = [
                    'talep_form_teklifler_item_details_id'=>$talep_form_teklifler_item_details_id,
                    'user_id'=>$this->aauth->get_user()->id,
                    'type'=>1,
                    'form_id'=>$form_id,
                    'product_id'=>$product_id
                ];
                //  $this->db->insert('teklif_onay_list', $data_insert_d);

                $productlist[$index] = $data_insert_d;
                $index++;


            }
            if($index){



                $this->db->insert_batch('teklif_onay_list', $productlist);

                $this->talep_history($form_id,$this->aauth->get_user()->id,'Ihaleye Onay Verildi');
                $new_id=0;
                $new_user_id=0;
                $new_id_control = $this->db->query("SELECT * FROM `talep_onay_new` Where type=2 and talep_id=$form_id and (status is Null or staff=0) and status is Null ORDER BY `talep_onay_new`.`id` ASC LIMIT 1");
                if($new_id_control->num_rows()){

                    $new_id = $new_id_control->row()->id;
                    $new_user_id = $new_id_control->row()->user_id;
                }
                if($new_id){

                    //eğer 1. Tekrar Onay Verirse
//                    $onay_user_id = $this->db->query("SELECT * FROM talep_onay_new Where id=$new_id")->row()->user_id;
//                    $this->db->delete('teklif_onay_list', array('form_id' => $form_id,'user_id'=>$onay_user_id));
                    //
                    $mesaj=$details->code.' Numaralı Malzeme Talep Formu İhale Sonuçlanmıştır.Onayınız Beklemektedir';
                    // $this->send_mail($new_user_id,'İhale Onayı',$mesaj);

                    // Bir Sonraki Onay
//                    $data_new=array(
//                        'staff'=>1,
//                    );
//                    $this->db->where('id',$new_id);
//                    $this->db->set($data_new);
//                    $this->db->update('talep_onay_new', $data_new);

                    $this->db->set('staff',1);
                    $this->db->where('id',$new_id);
                    $this->db->update('talep_onay_new');




                    // Bir Sonraki Onay
                }
                else {
                    $satinalma_personeli = $this->talep->talep_user_satinalma($form_id)->user_id;
                    $mesaj=$details->code.' Numaralı Malzeme Talep Formu Onaylanmıştır. Satınalma Formu Hazırlayıp Son Halini Onaya Sunabilirsiniz';
                    // $this->send_mail($satinalma_personeli,'Satınalma Emri',$mesaj);

                    $data_Form=array(
                        'status'=>5,
                    );
                    //satınalmaya geç
                    $this->db->set($data_Form);
                    $this->db->where('id', $form_id);
                    $this->db->update('talep_form', $data_Form);
                    //satınalmaya geç

                    if($cari_product_id){
                        foreach ($cari_product_id as $pid){
                            $details_cari_prd = $this->db->query("SELECT * FROM `cari_products` Where id=$pid")->row();
                            $data_insert_products=[
                                'product_name'=>$details_cari_prd->product_name,
                                'unit'=>$details_cari_prd->unit_id,
                                'form_id'=>$form_id
                            ];
                            $this->db->insert('geopos_products', $data_insert_products);
                            $last_id = $this->db->insert_id();

                            $data_product_update=[
                                'new_product_id'=>$last_id,
                            ];
                            //satınalmaya geç
                            $this->db->set($data_product_update);
                            $this->db->where('product_id', $pid);
                            $this->db->where('product_type', 2);
                            $this->db->update('talep_form_products', $data_product_update);

                        }

                    }



                }



                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Onay Verildi"));

            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Onaylamak İçin Yetkiniz Bulunmamaktadır"));
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
        $this->load->view('hizmet/teklif_incele',$data);
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
        $this->load->view('hizmet/teklif_update_view',$data);
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
//        if (!$this->aauth->premission(31)->write) {
//            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
//
//        }
//        else {
//
//        }

        $this->db->trans_start();
        $result = $this->talep->create_save();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Talep Oluşturuldu",'index'=>'/hizmet/view/'.$result['id']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }

    }

    public function transfer_bildirimi(){
//        if (!$this->aauth->premission(31)->read) {
//            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
//
//        }
//        else {
//
//        }


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
        $this->load->view('hizmet/view',$data);
        $this->load->view('fixed/footer');
    }

    public function hizmet_view_yetki()
    {
        $cari_id = $this->input->post('cari_id');
        $id = $this->input->post('form_id');
        // yetkili
        $data['ihale_time_yetki']=$this->db->query("SELECT * FROM teklif_counter Where talep_id = $id")->row();

        $tid = $id; // FORM ID
        $teklif_details = $this->db->query("SELECT * FROM `talep_form_teklifler` where cari_id=$cari_id and form_id=$tid")->row();
        $teklif_details_cari = $this->db->query("SELECT * FROM `talep_form_teklif_cari_details` where cari_id=$cari_id and teklif_id=$teklif_details->id")->row();
        $tftcd_id = $teklif_details_cari->id; //
        $teklif_id = $teklif_details->id; //


        $kontrol = $this->db->query("SELECT * FROM `talep_form_teklif_cari_details` where teklif_id = $teklif_id and cari_id=$cari_id")->row();

        if($kontrol->status==1 || $kontrol->status==2){
            $data['status_yetki'] = 1;
            $details = $this->db->query("SELECT * FROM `talep_form_teklif_cari_details` where teklif_id = $teklif_id and status = 1  and cari_id=$cari_id")->num_rows();
            if($details){
                $this->db->set('status', "2", FALSE);
                $this->db->where('id', $tftcd_id);
                $this->db->update('talep_form_teklif_cari_details');
            }
        }
        else {
            $data['status_yetki'] = 0;

        }
        $data['cari_id']  = $cari_id;
        $data['teklif_id']  = $teklif_id;
        $data['tftcd_id'] = $tftcd_id;
        $data['form_id']  = $tid;
        $data['items_']   = techizatcilar_item($tid,$cari_id);
        $data['code']     = $this->db->query("SELECT * FROM talep_form Where id=$tid")->row()->code;
        $data['form_details']     = $this->db->query("SELECT * FROM talep_form Where id=$tid")->row();
        $data['satinalma_details']= $this->db->query("SELECT * FROM talep_user_satinalma Where talep_id=$tid")->row();




        $html='<div class="card" >';
        $html.='<input type="hidden" id="cari_id_hidden" value="'.$cari_id.'">';
        $html.='<input type="hidden" id="form_id_hidden" value="'.$tid.'">';
        $html.='<input type="hidden" id="tftcd_id_hidden" value="'.$tftcd_id.'">';
        $html.="<div style='overflow: auto;width: 100%;text-align: initial'>";
        $html.="<div class='row'>";
        $html.="<div class='col-md-12'><table class='table table-responsive table_carilist' style='width:100%;    display: inline-table;'>";
        $html.="<thead>";
        $html.="<tr>";
            $html.="<th>'#</th>";
            $html.="<th>Resim</th>";
            $html.="<th>Adı</th>";
            $html.="<th width='30%'>Marka</th>";
            $html.="<th width='10%'>Vahid Qiy.</th>";
            $html.="<th width='30%'>Not</th>";
        $html.="</tr>";
        $html.="</thead>";
        $html.="<tbody class='item_products'>";

        $i = 1;
        foreach (techizatcilar_item($tid,$cari_id) as $items) {
            $product_type = $items->product_type;
            $product_name = who_demirbas($items->product_id)->name;

            $unit = units_($items->unit_id)['name'];
            if ($product_type == 2) {
                $product_name = cari_product_details($items->product_id)->product_name;
                $unit = units_(cari_product_details($items->product_id)->unit_id)['name'];
            }
            $varyasyonlar = talep_form_product_options_teklif_html($items->id);

            $details_items = $this->db->query("SELECT * FROM talep_form_products Where id=$items->id")->row();
            $code_id = $details_items->product_stock_code_id;
            $image = product_full_details_parent($code_id, $items->product_id)['image'];
            $new_images = base_url().$image;
            $image_src = '<td width="100px"><img src="' . $new_images . '" alt="" style="max-width:100%" height="auto" class="img-fluid"></td>';


            $html.= "<tr>";
            $html.= "<td>$i</td>";
            $html.= "$image_src";
            $html.= "<td>$product_name<p class='text-muted'>$varyasyonlar</p><p style='font-size: 9px;color: gray'>$items->product_qty $unit</p><p style='font-size: 9px;color: gray'>Temin Tarixi : $items->product_temin_date</p></td>";
            $html.= "<td><input type='text' class='form-control new-input marka'></td>";
            $html.= "<td><input type='number' class='form-control new-input price' value='0'><input type='hidden' class='item_id' value='$items->id'></td>";
            $html.= "<td><input type='text' class='form-control new-input notes'></td>";
            $html.= "</tr>";

            $i++;
        }
        $html.="</tbody>";
        $html.="</table>";
        $html.="</div>";
        $html.="</div>";
        $html.="</div>";
        $html.="</div>";

        $data['html']=$html;
        // yetkili

        echo json_encode(array('status' => 'Success', 'details' =>$data));

    }


    public function yetki_teklif_olustur(){
        $this->db->trans_start();

        $user_id = $this->aauth->get_user()->id;

        $cari_id  = $this->input->post('cari_id'); //226
        $talep_id = $this->input->post('talep_id'); //20
        $tftcd_id = $this->input->post('tftcd_id'); //10
        $nakliye  = $this->input->post('nakliye'); //1
        $kdv      = $this->input->post('kdv'); //1
        $cari_name = customer_details($cari_id)['company'];
        $text = $cari_name.' Firma Teklif Verdi';

        $this->db->set('status', "3", FALSE);
        $this->db->where('id', $tftcd_id);
        $this->db->update('talep_form_teklif_cari_details');

        $details  = $this->db->query("SELECT * FROM `talep_form_teklif_cari_details` where id=$tftcd_id")->row();


        $product_details = $this->input->post('product_details');
        $total_price=0;
        $key = 0 ;

        foreach ($product_details as $items){
            $data_insert    = [
                'item_id'   => $items['item_id'],
                'marka'     => $items['marka'],
                'price'     => $items['price'],
                'notes'     =>  $items['notes'],
                'teklif_id' =>$details->teklif_id
            ];

            $details_products = $this->db->query("SELECT * FROM `talep_form_products` where id=".$items['item_id'])->row();
            $totals= floatval($items['price']) * floatval($details_products->product_qty);
            $total_price+=$totals;

            if($this->db->insert('talep_form_teklifler_item', $data_insert)){
                $key++;
            }
        }
        if($key==count($product_details)){
            $this->db->set('total', $total_price);
            $this->db->set('kdv', $kdv);
            $this->db->set('teslimat', $nakliye);
            $this->db->where('form_id', $talep_id);
            $this->db->where('cari_id', $cari_id);
            $this->db->update('talep_form_teklifler');
            //total update
            //$this->db->query("UPDATE `talep_form` SET `status` = '4' WHERE `talep_form`.`id` = $talep_id");
            $this->db->trans_complete();

            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Oluşturuldu'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
        }

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


        $product_name = who_demirbas($details->product_id)->name;


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
    public function test4()
    {
        $d=date('d');
        if(10>intval($d)){
            echo "false";
        }
        else{
            echo "true";
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
            if($details->warehouse_id==$user_id){
                echo json_encode(array('status' => 'Success','message'=>'Yetki MEvcut'));
            }
            else{
                echo json_encode(array('status' => 'Error', 'message' =>"Seçilen Depo Personeli Dışında Bu Aşamada Yetki Verilmemektedir"));
            }
        }

        elseif($type==5) //muhasebe kullanıcısı
        {
            $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $details->proje_id and  muhasebe_muduru_id=$user_id")->num_rows();
            if($yetkili_kontrol || $this->aauth->get_user()->id==39){
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

                    $users__talep = onay_sort(17,$details->proje_id,0,$id);

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
    public function onay_olustur(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $sort = $this->input->post('sort');
        $progress_status_id = $this->input->post('progress_status_id');
        $details = $this->talep->details($id);
        $type = $this->input->post('type');
        $product_details = $this->input->post('product_details');
        $auth_id = $this->aauth->get_user()->id;
        $sort_kontrol = $this->db->query("SELECT * FROM talep_onay_new Where talep_id=$id and  user_id=$auth_id and  status is null and staff=1 and sort=$sort and type=$type")->num_rows();
        if($sort_kontrol){
            foreach ($product_details as $items){
                $item_id = $items['item_id'];
                $item_details=$this->db->query("SELECT * FROM  talep_form_products where id =$item_id ")->row();


                $product_name= '';

                $product_name= who_demirbas($item_details->product_id)->name;


                $data_item_update = [
                    'product_qty'=>$items['item_qty']
                ];
                $this->db->where('id',$items['item_id']);
                $this->db->set($data_item_update);
                $this->db->update('talep_form_products', $data_item_update);

                $data_talep_updata=['progress_status_id'=>$progress_status_id];
                $this->db->where('id',$id);
                $this->db->set($data_talep_updata);
                $this->db->update('talep_form', $data_talep_updata);

                $progress_status_details = progress_status_details($progress_status_id);
                $this->talep_history($id,$this->aauth->get_user()->id,$product_name.' Ürünü İçin Yeni Miktar : '.$items['item_qty'].' Yeni Durum : '.$progress_status_details->name);
            }


            $sorts=$sort+1;
            $satinalma_personeli = $this->input->post('satinalma_personeli');
            $new_id=0;
            $new_user_id=0;
            $new_id_control = $this->db->query("SELECT * FROM `talep_onay_new` Where type=$type and talep_id=$id and sort=$sorts and status is Null ORDER BY `talep_onay_new`.`id` ASC LIMIT 1");
            if($new_id_control->num_rows()){
                $new_id = $new_id_control->row()->id;
                $new_user_id = $new_id_control->row()->user_id;
            }



            $this->db->delete('talep_user_satinalma', array('talep_id' => $id));
            $data_satinalma=[
                'user_id'=>$satinalma_personeli,
                'talep_id'=>$id,
            ];

            $this->db->insert('talep_user_satinalma', $data_satinalma);

            $data = array(
                'status' => 1,
                'staff' => 0,
            );

            $this->db->where('user_id',$this->aauth->get_user()->id);
            $this->db->where('staff',1);
            $this->db->where('status',null,false);
            $this->db->where('sort',$sort);
            $this->db->where('type',$type);
            $this->db->where('talep_id', $id);
            $this->db->set($data);
            if ($this->db->update('talep_onay_new', $data)) {

                $this->talep_history($id,$this->aauth->get_user()->id,'Onay Verildi');
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
                }
                else {

                    $mesaj=$details->code.' Numaralı Malzeme Talep Formu Onaylanmıştır. İhale İşlemlerine Başlayabilirsiniz';

                    if( $this->send_mail($satinalma_personeli,'İhale Emri',$mesaj)){
                        $user_phone = personel_details_full($satinalma_personeli)['phone'];
                        //$this->mesaj_gonder($user_phone,$details->code.' Numaralı Malzeme Talep Formu Onaylanmıştır. İhale İşlemlerine Başlayabilirsiniz.');

                        // satinalmaya bildirimini goster
                        $data_sf=array(
                            'status'=>1,
                        );
                        //satınalmaya geç
                        $this->db->set($data_sf);
                        $this->db->where('talep_id', $id);
                        $this->db->update('talep_user_satinalma', $data_sf);
                        // satinalmaya bildirimini goster
                        $data_Form=array(
                            'status'=>2,
                        );
                        //satınalmaya geç
                        $this->db->set($data_Form);
                        $this->db->where('id', $id);
                        $this->db->update('talep_form', $data_Form);
                        //satınalmaya geç
                    }


                }

                $this->aauth->applog("Malzame Talebine Onay Verildi :  ID : ".$id, $this->aauth->get_user()->username);
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success','message'=>'Başarıyla Onay Verildi'));

            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));

            }
        }

        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Doğru Tercih Yapmadınız Sayfa Yenilemesi Yapınız.".' Hata '));
        }


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

    public function form_bildirim_olustur(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $type = $this->input->post('type');
        $user_id=$this->aauth->get_user()->id;
        if($type==1){


            $talep_kontrol  = $this->db->query("SELECT * FROM `talep_form` where id=$id and aauth=$user_id")->num_rows();
            if($talep_kontrol){

                $bildirim_kontrol = $this->db->query("SELECT * FROM talep_form WHERE id=$id and status=17")->num_rows();
                if(!$bildirim_kontrol){
                    $details = $this->talep->details($id);

                    if(!isset($details->warehouse_id)){
                        $this->db->trans_rollback();
                        echo json_encode(array('status' => 'Error', 'message' =>"Depo Seçmeniz Gerekmektedir."));
                    }
                    else {

                        $products_items = $this->talep->details_items($id);
                        $sonuc=1;
//                    foreach ($products_items as $item_products){
//                       $val =  product_onay_kontrol($item_products->product_id);
//                       if(!$val){
//                           $sonuc++;
//                       }
//                    }
                        if($sonuc){
                            $data_update = array(
                                'status' => 17,
                            );
                            $this->db->set($data_update);
                            $this->db->where('id', $id);
                            if ($this->db->update('talep_form', $data_update)) {
                                $users_ = onay_sort(14,$details->proje_id,0,$id);

                                if($users_){
                                    foreach ($users_ as $items){
                                        $staff=0;
                                        if($items['sort']==1){

                                            $staff=1;
                                        }

                                        $data_onay = array(
                                            'talep_id' => $id,
                                            'type' => 3,
                                            'staff' => $staff,
                                            'sort' => $items['sort'],
                                            'user_id' => $items['user_id'],
                                        );
                                        $this->db->insert('talep_onay_new', $data_onay);
                                    }

                                    // bildirim maili at
                                    $mesaj=$details->code.' Numaralı Malzeme Talep Formu Stok Kontrol Onayınızı Beklemektedir';
                                    //$this->send_mail($items['user_id'],'Stok KOntrol Onayı',$mesaj);
                                    // bildirim maili at
                                    $user_phone = personel_details_full($items['user_id'])['phone'];
                                    //$this->mesaj_gonder($user_phone,$details->code.' Malzeme Talebi Onayınızı Beklemektedir.');

                                    $this->talep_history($id,$this->aauth->get_user()->id,'Onay İşlemi Başlatıldı');
                                    //kont_kayit(21,$id);
                                    $this->aauth->applog("Malzame Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);
                                    $this->db->trans_complete();
                                    echo json_encode(array('status' => 'Success','message'=>'Başarıyla Bildirim Başlatıldı'));

                                }
                                else {

                                    echo json_encode(array('status' => 'Error', 'message' =>"Projenize Yetkili Kişiler Atanmamıştır veya Seçilen Depoya Yetkili Tanımlanmamıştır.Bu Sebeple İşlem Yapamazsınız."));
                                    $this->db->trans_rollback();

                                }
                            }
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
                                    // $this->send_mail($items['user_id'],'Malzeme Talep Onayı',$mesaj);
                                    // bildirim maili at
                                    $user_phone = personel_details_full($items['user_id'])['phone'];
                                    //$this->mesaj_gonder($user_phone,$details->code.' Malzeme Talebi Onayınızı Beklemektedir.');

                                    $this->talep_history($id,$this->aauth->get_user()->id,'Onay İşlemi Başlatıldı');
                                    //kont_kayit(21,$id);
                                    $this->aauth->applog("Malzame Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);
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

                    }
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Bildirim Başlatılmıştır."));
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


    public function talep_history($id,$user_id,$desc,$type=1){

        $data_step = array(
            'talep_id' => $id,
            'user_id' => $user_id,
            'desc' => $desc,
            'type' => $type,
        );
        $this->db->insert('talep_history', $data_step);

    }
    public function search_products(){
        $where='';
        $data=[];
        $units=units();
        $cat_id = $this->input->post('cat_id');
        $proje_id = $this->input->post('proje_id');
        $bolum_id = $this->input->post('bolum_id');
        $asama_id = $this->input->post('asama_id');
        $keyword = $this->input->post('keyword');
        $talep_type = $this->input->post('talep_type');

        if($keyword && $cat_id){
            // $where = " (`product_name` LIKE '%$keyword%' or simeta_code LIKE '%$keyword%' or simeta_product_name LIKE '%$keyword%' or `product_code` LIKE '%$keyword%' or `barcode` LIKE '%$keyword%')  AND pcat=$cat_id";
            $where = " (geopos_products_parent.tag LIKE '%$keyword%' or  geopos_products.tag LIKE '%$keyword%' or `product_stock_code`.`code` LIKE '%$keyword%' or `geopos_products`.`product_name` LIKE '%$keyword%' or `geopos_products`.`product_code` LIKE '%$keyword%' or `geopos_products`.`barcode` LIKE '%$keyword%')  AND pcat=$cat_id";
        }
        else if($cat_id) {
            $where = "(geopos_products_parent.pcat=$cat_id or geopos_products.pcat=$cat_id)";
        }
        else if($keyword) {
            //$where = " `product_name` LIKE '%$keyword%' or simeta_code LIKE '%$keyword%' or simeta_product_name LIKE '%$keyword%' or `product_code` LIKE '%$keyword%' or `barcode` LIKE '%$keyword%' ";
            $where = " (geopos_products_parent.tag LIKE '%$keyword%' or geopos_products.tag LIKE '%$keyword%' or `product_stock_code`.`code` LIKE '%$keyword%' or `geopos_products`.`product_name` LIKE '%$keyword%' or `geopos_products`.`product_name_tr` LIKE '%$keyword%' or `geopos_products`.`product_name_en` LIKE '%$keyword%' or  `geopos_products`.`product_code` LIKE '%$keyword%' or `geopos_products`.`barcode` LIKE '%$keyword%' )";

        }

        $query = $this->db->query(" SELECT
    geopos_products.pid as product_id,
    geopos_products.image as images,
    CONCAT(geopos_products.product_name,
    ' ',geopos_products.product_name_tr,' ',geopos_products.product_name_en) 
        as product_name,
    IF(product_stock_code.id,product_stock_code.code,'varyasyon tanımlanmamış') as varyasyon,
    IF(product_stock_code.id,product_stock_code.id,0) as product_stock_code_id,
    product_stock_code.code
FROM geopos_products 
LEFT JOIN product_stock_code ON geopos_products.pid=product_stock_code.product_id
LEFT JOIN geopos_products_parent ON geopos_products_parent.product_stock_code_id=product_stock_code.id
WHERE  geopos_products.deleted_at is NULL and geopos_products.product_type = 7 and    $where GROUP BY product_stock_code.id
ORDER BY geopos_products.pid DESC LIMIT 100");
        if($query->num_rows()){
            foreach ($query->result() as $items){

                $varyasyon_name = $items->varyasyon;
                $product_id = $items->product_id;
                // $proje_qty_details =  proje_qty_function($proje_id,$product_id,$bolum_id,$asama_id,$items->option_id,$items->option_value_id);
                $proje_qty_details =  proje_qty_function_new($proje_id,$product_id,$bolum_id,$asama_id,null,null,$items->product_stock_code_id);

//
//                    if($proje_qty_details > 0){


                $fa_button="<i class='fas fa-info-circle' style='font-size: 25px; animation-name: flash;  animation-duration: 1s;animation-timing-function: linear;animation-iteration-count: infinite;color: #0497ab'></i>";

                if($items->product_stock_code_id){
                    $varyasyon_name="<span style='cursor:pointer' class='option_view_btn' stock_code_id='$items->product_stock_code_id'>$items->varyasyon</span>  ".$fa_button;

                }

                $images = $items->images;
                $stoc_code_id = $items->product_stock_code_id;
                $products_parent=$this->db->query("SELECT * FROM geopos_products_parent Where product_stock_code_id=$stoc_code_id");
                if($products_parent->num_rows()){
                    $images = $products_parent->row()->image;
                }
                $stock_qty = stock_qty($product_id);
                $data[]=[
                    'images'=>$images,
                    'product_id'=>$product_id,
                    'product_name'=>$items->product_name,
                    'proje_stoklari_id'=>0,
                    'unit_id'=>9,
                    'unit_name'=>units_(9)['name'],
                    'stock_qty'=>0,
                    'max_qty'=>99999999,
                    'option_id'=>null,
                    'option_value_id'=>null,
                    'p_unit_id'=>9,
                    'option_html'=>$varyasyon_name,
                    'product_stock_code_id'=>$items->product_stock_code_id,
                    'fa_button'=>$fa_button
                    //'option_html'=>varyasyon_string_name($items->option_id,$items->option_value_id)
                ];
//                    }

            }
            echo json_encode(array('status' => 'Success','products'=>$data,'units'=>$units));
        }
        else {
            echo json_encode(array('status' => 'Error', 'message' =>"Ürün Bulunamadı"));
        }



    }

//    public function search_products(){
//        $where='';
//        $data=[];
//        $units=units();
//        $cat_id = $this->input->post('cat_id');
//        $proje_id = $this->input->post('proje_id');
//        $bolum_id = $this->input->post('bolum_id');
//        $asama_id = $this->input->post('asama_id');
//        $keyword = $this->input->post('keyword');
//        $talep_type = $this->input->post('talep_type');
//
//        if($talep_type==1)
//        {
//            if($keyword && $cat_id){
//               // $where = " (`product_name` LIKE '%$keyword%' or simeta_code LIKE '%$keyword%' or simeta_product_name LIKE '%$keyword%' or `product_code` LIKE '%$keyword%' or `barcode` LIKE '%$keyword%')  AND pcat=$cat_id";
//                $where = " (`product_name` LIKE '%$keyword%' or `product_code` LIKE '%$keyword%' or `barcode` LIKE '%$keyword%')  AND pcat=$cat_id";
//            }
//            else if($cat_id) {
//                $where = "pcat=$cat_id";
//            }
//            else if($keyword) {
//                //$where = " `product_name` LIKE '%$keyword%' or simeta_code LIKE '%$keyword%' or simeta_product_name LIKE '%$keyword%' or `product_code` LIKE '%$keyword%' or `barcode` LIKE '%$keyword%' ";
//                $where = " `product_name` LIKE '%$keyword%' or `product_code` LIKE '%$keyword%' or `barcode` LIKE '%$keyword%' ";
//
//            }
//
//            $query = $this->db->query("SELECT geopos_products.*,proje_stoklari.product_stock_code_id,proje_stoklari.unit_id as p_unit_id,proje_stoklari.qty as max_qty,proje_stoklari.option_id,proje_stoklari.option_value_id,proje_stoklari.id as proje_stoklari_id FROM `geopos_products` INNER JOIN proje_stoklari ON geopos_products.pid=proje_stoklari.product_id
//            WHERE proje_stoklari.proje_id=$proje_id and proje_stoklari.bolum_id=$bolum_id and proje_stoklari.asama_id=$asama_id and $where GROUP BY proje_stoklari.product_stock_code_id   LIMIT 30");
//            if($query->num_rows()){
//                foreach ($query->result() as $items){
//
//                    $varyasyon_name='';
//                    if($items->product_stock_code_id){
//                        $stock_code=$this->db->query("SELECT * FROM product_stock_code Where id=$items->product_stock_code_id");
//                        if($stock_code->num_rows()){
//                            $varyasyon_name = $stock_code->row()->code;
//                        }
//                    }
//
//                    $product_id = $items->pid;
//                   // $proje_qty_details =  proje_qty_function($proje_id,$product_id,$bolum_id,$asama_id,$items->option_id,$items->option_value_id);
//                    $proje_qty_details =  proje_qty_function_new($proje_id,$items->pid,$bolum_id,$asama_id,$items->option_id,$items->option_value_id,$items->product_stock_code_id);
//
////
////                    if($proje_qty_details > 0){
//                        $stock_qty = stock_qty($items->pid);
//                        $data[]=[
//                            'product_id'=>$items->pid,
//                            'product_name'=>$items->product_name,
//                            'proje_stoklari_id'=>$items->proje_stoklari_id,
//                            'unit_id'=>$items->unit,
//                            'unit_name'=>units_($items->unit)['name'],
//                            'stock_qty'=>$stock_qty,
//                            'max_qty'=>$proje_qty_details,
//                            'option_id'=>$items->option_id,
//                            'option_value_id'=>$items->option_value_id,
//                            'p_unit_id'=>$items->p_unit_id,
//                            'option_html'=>$varyasyon_name,
//                            'product_stock_code_id'=>$items->product_stock_code_id
//                            //'option_html'=>varyasyon_string_name($items->option_id,$items->option_value_id)
//                        ];
////                    }
//
//                }
//                echo json_encode(array('status' => 'Success','products'=>$data,'units'=>$units));
//            }
//            else {
//                echo json_encode(array('status' => 'Error', 'message' =>"Ürün Bulunamadı"));
//            }
//        }
//        elseif($talep_type==2)
//        {
//
//        }
//        elseif($talep_type==3)
//        {
//            if($keyword && $cat_id){
//                $where = " (`name` LIKE '%$keyword%' )  AND parent_id=$cat_id";
//            }
//            else if($cat_id) {
//                $where = "parent_id=$cat_id";
//            }
//            else if($keyword) {
//                $where = " `name` LIKE '%$keyword%'";
//
//            }
//            $query = $this->db->query("SElECT
//       geopos_cost.id  as pid ,
//       geopos_cost.name as product_name,
//       geopos_cost.unit as unit,
//       geopos_cost.unit as p_unit_id
//
//FROM `geopos_cost`
//            WHERE $where   LIMIT 30");
//            if($query->num_rows()){
//                foreach ($query->result() as $items){
//
//
//                    $data[]=[
//                        'product_id'=>$items->pid,
//                        'product_name'=>$items->product_name,
//                        'unit_id'=>$items->unit,
//                        'unit_name'=>units_($items->unit)['name'],
//                        'stock_qty'=>0,
//                        'max_qty'=>9999999999,
//                        'option_id'=>0,
//                        'option_value_id'=>0,
//                        'p_unit_id'=>$items->p_unit_id,
//                        'option_html'=>''
//                    ];
//
//                }
//                echo json_encode(array('status' => 'Success','products'=>$data,'units'=>$units));
//            }
//            else {
//                echo json_encode(array('status' => 'Error', 'message' =>"Ürün Bulunamadı"));
//            }
//        }
//
//
//
//
//    }



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

    public function search_cari(){

        $data=[];
        $keyword = $this->input->post('keyword');
        $loc = $this->session->userdata('set_firma_id');
        $query = $this->db->query("SELECT * FROM `geopos_customers` WHERE  (`name` LIKE '%$keyword%' or `company` LIKE '%$keyword%' or `phone` LIKE '%$keyword%' or  `sektor` LIKE '%$keyword%' ) and loc=$loc");
        if($query->num_rows()){
            foreach ($query->result() as $items){
                $data[]=[
                    'cari_id'=>$items->id,
                    'name'=>$items->name,
                    'phone'=>$items->phone,
                    'email'=>$items->email,
                    'company'=>$items->company,
                    'sektor'=>$items->sektor,
                ];
            }
            echo json_encode(array('status' => 'Success','cari_list'=>$data));
        }
        else {
            echo json_encode(array('status' => 'Error', 'message' =>"Cari Bulunamadı"));
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

            $this->aauth->applog("Malzame Talebinde İşten Sorumlu Personel Seçildi Talep :  ID : ".$id, $this->aauth->get_user()->username);
            $this->talep_history($id,$this->aauth->get_user()->id,'İşiten Sorumlu Personel  Değiştildi. Eski Personel : '.personel_detailsa($warehouse_id)['name'].' Yeni Personel : '.personel_detailsa($warehouse_id)['name'] );
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
//        if($user_id==$proje_sorumlusu ||
//            $user_id==$proje_muhasebe_mudur_id ||
//            $user_id==$proje_muduru_id ||
//            $user_id==$genel_mudur_id ||
//            $user_id==$muhasebe_muduru_id ||
//            $user_id==1009 ||
//            $user_id==39 ||
//            $user_id==21
//        )
//        {

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
    public function teklif_create(){


        $this->db->trans_start();
        $i=0;
        $id = $this->input->post('talep_id');
        $cari_details = $this->input->post('cari_details');
        $ihale_suresi = $this->input->post('ihale_suresi');
        $details = $this->talep->details($id);
        foreach ($cari_details as $items){
            $cari_id =$items['cari_id'];
            $data_insert= [
                'form_id'=>$id,
                'cari_id'=>$cari_id,
                'aauth_id'=>$this->aauth->get_user()->id,
            ];
            if ($this->db->insert('talep_form_teklifler', $data_insert)) {
                $last_id = $this->db->insert_id();

                $teklif_id = $last_id;


                if($details->talep_type==3){
                    $product_details=$this->talep->product_details($id);
                    foreach ($product_details as $items_){
                        $data_insert    = [
                            'item_id'   => $items_->id,
                            'marka'     => '',
                            'price'     => 0,
                            'notes'     =>  '',
                            'teklif_id' =>$teklif_id
                        ];

                        $this->db->insert('talep_form_teklifler_item', $data_insert);
                    }

                    //total update
                    $this->db->set('total', 0);
                    $this->db->set('kdv', 0);
                    $this->db->set('teslimat', 0);
                    $this->db->where('form_id', $id);
                    $this->db->where('cari_id', $cari_id);
                    $this->db->update('talep_form_teklifler');
                    //total update
                }

                $split =explode(',',$items['cari_phone']);
                foreach ($split as $value){

                    $phone = $value;
                    $data_details_insert = [
                        'teklif_id'=>$last_id,
                        'cari_id'=>$cari_id,
                        'phone'=>$phone,
                    ];


                    $this->db->insert('talep_form_teklif_cari_details', $data_details_insert);
                    $tftcd_id = $this->db->insert_id();

                    if($details->talep_type==3) {
                        $this->db->set('status', "3", FALSE);
                        $this->db->where('id', $tftcd_id);
                        $this->db->update('talep_form_teklif_cari_details');
                    }

                    $firma_name=customer_details($cari_id)['company'];
                    $elega = personel_detailsa($this->aauth->get_user()->id)['phone'];
                    $yetkili_pers = personel_detailsa($this->aauth->get_user()->id)['name'];

//
//                    $username_details=$this->db->query("SELECT * FROM customer_info Where customer_id = $cari_id")->row();
//                    $username =$username_details->phone;
//                    $pass =$username_details->pass_num;

                    $href="https://customer.makro2000.com.tr";
                    $short_url = $this->getSmallLink($href);
                    $messages=$firma_name. ' - Makro2000 Qrup Sirketleri sizdən bir qiymət gozleyirler.Tender Süresi : '.$ihale_suresi.' Saat '.$yetkili_pers.' Elaqe nomrəmiz : '.$elega.'  Teklif göndermək ucun buraya vurun. '.$short_url;


                    $this->db->set('messages', "'$messages'", FALSE);
                    $this->db->where('id', $tftcd_id);
                    $this->db->update('talep_form_teklif_cari_details');


                    $this->mesaj_gonder($phone,$messages);

                }


            }

            $i++;
        }

        if($i){
            $this->db->set('status', 2, FALSE);
            $this->db->where('talep_id', $id);
            $this->db->update('talep_user_satinalma');

            $this->aauth->applog("Malzame Talebine Teklif Oluştuldu :  ID : ".$id, $this->aauth->get_user()->username);
            $this->talep_history($id,$this->aauth->get_user()->id,'Teklif Oluşturuldu');

            // İhale Süresi Kayıt
            date_default_timezone_set('Asia/Baku');
            $bZaman = date("Y-m-d H:i:s");
            $yeniTarih = date('Y-m-d H:i:s',strtotime('+'.intval($ihale_suresi).' hour',strtotime($bZaman)));


            $data_insert_counter= [
                'talep_id'=>$id,
                'durum'=>1,
                'hours'=>$ihale_suresi,
                'finish_date'=>$yeniTarih,
                'aauth_id'=>$this->aauth->get_user()->id,
            ];
            $this->db->insert('teklif_counter', $data_insert_counter);
            // İhale Süresi Kayıt



            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Oluşturuldu'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
        }

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



    public function teklif_update(){
        $this->db->trans_start();

        $form_id = $this->input->post('form_id');
        $details = $this->talep->details($form_id);
        if($details->status > 3){
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Bu Aşamada Güncelleme Yapamazsınız" ));
        }
        else {
            $user_id= $this->aauth->get_user()->id;

            $talep_kontrol  = $this->db->query("SELECT * FROM `talep_user_satinalma` where talep_id=$form_id and user_id=$user_id")->num_rows();
            if($talep_kontrol){
                $tf_teklif_id = $this->input->post('teklif_id');

                $kontrol  = $this->db->query("SELECT * FROM talep_form_teklifler_details Where tf_teklif_id = $tf_teklif_id");
                if($kontrol->num_rows()){
                    $this->db->delete('talep_form_teklifler_item_details', array('details_id' => $kontrol->row()->id));
                    $this->db->delete('talep_form_teklifler_details', array('tf_teklif_id' => $tf_teklif_id));
                }
                $product_details = $this->input->post('product_details');
                $method = $this->input->post('method');
                $discount_type = $this->input->post('discount_type');
                $teslimat = $this->input->post('teslimat');
                $teslimat_tutar = $this->input->post('teslimat_tutar');
                $edv_durum = $this->input->post('edv_durum');
                $avans_price = $this->input->post('avans_price');
                $para_birimi = $this->input->post('para_birimi');
                $alt_sub_total_val = $this->input->post('alt_sub_total_val');
                $alt_total_val = $this->input->post('alt_total_val');
                $alt_discount_total_val = $this->input->post('alt_discount_total_val');
                $kdv_oran = $this->input->post('edv_oran_form');
                $alt_edv_total_val = $this->input->post('alt_edv_total_val');
                $data_insert = [
                    'tf_teklif_id'=>$tf_teklif_id,
                    'method'=>$method,
                    'discount_type'=>$discount_type,
                    'teslimat'=>$teslimat,
                    'teslimat_tutar'=>$teslimat_tutar,
                    'edv_durum'=>$edv_durum,
                    'para_birimi'=>$para_birimi,
                    'alt_sub_total_val'=>$alt_sub_total_val,
                    'alt_total_val'=>$alt_total_val,
                    'alt_discount_total_val'=>$alt_discount_total_val,
                    'alt_edv_total_val'=>$alt_edv_total_val,
                    'avans_price'=>$avans_price,
                    'kdv_oran'=>$kdv_oran,
                    'aauth_id'=>$this->aauth->get_user()->id,
                ];
                if($this->db->insert('talep_form_teklifler_details', $data_insert)){
                    $last_id = $this->db->insert_id();
                    $product_list=[];
                    $index=0;

                    if($product_details){
                        foreach ($product_details as $items){
                            if($items['item_id']){
                                $item_id = $items['item_id'];
                                $item_details=$this->db->query("SELECT * FROM talep_form_products  WHERE id=$item_id")->row();

                                $old_miktar=$item_details->product_qty.' '.units_($item_details->unit_id)['name'];

                                if($items['new_unit_id']){
                                    $this->db->set('unit_id', $items['new_unit_id']);
                                    $this->db->set('product_qty', $items['item_qty']);
                                    $this->db->where('id', $items['item_id']);
                                    $this->db->update('talep_form_products');
                                }



                                    $product_name= who_demirbas($item_details->product_id)->name;


                                $this->talep_history($form_id,$this->aauth->get_user()->id,$product_name.'Eski Miktar:'.$old_miktar.' Ürünü İçin Yeni Miktar : '.$items['item_qty'].' Yeni Birim : '.units_($items['new_unit_id'])['name']);
                                $data_item_insert = [
                                    'details_id'=>$last_id,
                                    'tfitem_id'=>$items['item_id'],
                                    'qty'=>$items['item_qty'],
                                    'price'=>$items['item_price'],
                                    'discount_type'=>$discount_type,
                                    'discount'=>$items['item_discount'],
                                    'edv_oran'=>$items['item_kdv'],
                                    'edv_type'=>$edv_durum,
                                    'sub_total'=>$items['item_edvsiz'],
                                    'discount_total'=>$items['item_discount_umumi'],
                                    'kdv_total'=>$items['edv_tutari'],
                                    'total'=>$items['item_umumi_cemi'],
                                    'item_desc'=>$items['item_desc'],

                                ];

                                $product_list[$index]=$data_item_insert;
                                $index++;



                            }
                        }
                        $this->db->insert_batch('talep_form_teklifler_item_details', $product_list);
                    }
                    if($index){

                        $this->aauth->applog("Teklif Güncellendi  : Teklif ID : ".$tf_teklif_id, $this->aauth->get_user()->username);
                        $this->db->trans_complete();
                        echo json_encode(array('status' => 'Success','message'=>'Başarıyla Güncellendi'));

                    }
                    else {
                        $this->db->trans_rollback();
                        echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
                    }
                }
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Seçilen Satınalma Personeli Dışında Bu Aşamada Yetki Verilmemektedir"));
            }

        }



    }

    public function beklyen_malzeme_count(){


        $where_talep_form='';
        if($this->session->userdata('set_firma_id')){
            $where_talep_form.='and talep_form.loc='.$this->session->userdata('set_firma_id');
            //$this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $aauth_id = $this->aauth->get_user()->id;
        $count = $this->db->query("SELECT * FROM `talep_onay_new` 
INNER JOIN talep_form On talep_onay_new.talep_id=talep_form.id
WHERE talep_onay_new.type = 1 AND  talep_form.status=1 and talep_onay_new.user_id = $aauth_id AND `staff` = 1 $where_talep_form
")->num_rows();
        echo json_encode(array('status' => 'Success','count'=>$count));


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


        $aauth_id = $this->aauth->get_user()->id;
        $count=0;
        if($aauth_id==39){


            $count = $this->db->query("SELECT siparis_list_form_new.*,geopos_products.product_name,talep_form_products.product_id FROM siparis_list_form_new
                 INNER JOIN talep_form_products On siparis_list_form_new.talep_form_product_id = talep_form_products.id
                 INNER JOIN geopos_products ON talep_form_products.product_id =geopos_products.pid
                 INNER JOIN talep_form ON talep_form.id =talep_form_products.form_id
WHERE talep_form_products.gider_durumu=0 and talep_form.gider_durumu=1 group by talep_form.id")->num_rows();
        }
        echo json_encode(array('status' => 'Success','count'=>$count));


    }

    public function transfertaleplist(){
        $where_talep_form='';
        if($this->session->userdata('set_firma_id')){
            $where_talep_form.='and talep_form.loc='.$this->session->userdata('set_firma_id');
            //$this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $aauth_id = $this->aauth->get_user()->id;
        $count = $this->db->query("SELECT * FROM `talep_form` INNER JOIN geopos_warehouse On
    talep_form.transfer_warehouse_id = geopos_warehouse.id   WHERE talep_form.status = 8 
                   and talep_form.transfer_status=1  and talep_form.transfer_bildirim=1 and
                                                       geopos_warehouse.pers_id = $aauth_id $where_talep_form")->num_rows();
        echo json_encode(array('status' => 'Success','count'=>$count));


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
geopos_projects On talep_form.proje_id =geopos_projects.id  WHERE talep_form.status = 8 and talep_form.talep_type =1  $where_talep_form")->num_rows();
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
        $where_talep_form='';
        if($this->session->userdata('set_firma_id')){
            $where_talep_form.='and talep_form.loc='.$this->session->userdata('set_firma_id');
            //$this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $aauth_id = $this->aauth->get_user()->id;
        $count = $this->db->query("SELECT * FROM `talep_form`  INNER JOIN talep_user_satinalma ON
    talep_form.id = talep_user_satinalma.talep_id WHERE talep_form.status = 3 AND 
                                                        talep_user_satinalma.user_id = $aauth_id  $where_talep_form")->num_rows();
        echo json_encode(array('status' => 'Success','count'=>$count));


    }

    public function odemetalepcount(){
        $where_talep_form='';
        if($this->session->userdata('set_firma_id')){
            $where_talep_form.='and talep_form.loc='.$this->session->userdata('set_firma_id');
            //$this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $aauth_id = $this->aauth->get_user()->id;
        $count = $this->db->query("SELECT * FROM `talep_form`  INNER JOIN talep_user_satinalma ON 
    talep_form.id = talep_user_satinalma.talep_id WHERE talep_form.status IN (11,19) AND 
                                                        talep_user_satinalma.user_id = $aauth_id $where_talep_form ")->num_rows();
        echo json_encode(array('status' => 'Success','count'=>$count));


    }
    public function avanslistcount(){
        $where_talep_form='';
        if($this->session->userdata('set_firma_id')){
            $where_talep_form.='and talep_form.loc='.$this->session->userdata('set_firma_id');
            //$this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $aauth_id = $this->aauth->get_user()->id;
        $count = 0;
        $result = $this->db->query("SELECT * FROM talep_form Where talep_form.status = 18 $where_talep_form");
        if($result->num_rows()){
            foreach ($result->result() as $items){
                $avans_sorgu = $this->db->query("SELECT * FROM talep_form_avans Where talep_id = $items->id and type = 1 and status_id=1");
                if($avans_sorgu->num_rows()){
                    foreach ($avans_sorgu->result() as $values){
                        $avans_talep_id = $values->id;
                        if(talep_form_sort_why($avans_talep_id)){
                            if($aauth_id==talep_form_sort_why($avans_talep_id)->staff_id){
                                $count++;
                            }
                        }



                    }
                }
            }
        }
        echo json_encode(array('status' => 'Success','count'=>$count));


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
        $where_talep_form='';
        if($this->session->userdata('set_firma_id')){
            $where_talep_form.='and talep_form.loc='.$this->session->userdata('set_firma_id');
            //$this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $aauth_id = $this->aauth->get_user()->id;
        $count = 0;
        $result = $this->db->query("SELECT * FROM talep_form Where talep_form.status = 20 $where_talep_form");
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

    public function odemeemrilistcount(){
        $where_talep_form='';
        if($this->session->userdata('set_firma_id')){
            $where_talep_form.='and talep_form.loc='.$this->session->userdata('set_firma_id');
            //$this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $aauth_id = $this->aauth->get_user()->id;
        $count = 0;
        $avans_sorgu = $this->db->query("SELECT * FROM talep_form_avans_sort 
        INNER JOIN talep_form_avans ON talep_form_avans.id =talep_form_avans_sort.talep_form_avans_id
        INNER JOIN talep_form ON talep_form.id =talep_form_avans.talep_id
        Where talep_form_avans_sort.type = 2 and talep_form_avans_sort.staff_status=4 and  talep_form.status=12
      and talep_form_avans_sort.muhasebe_id=$aauth_id $where_talep_form GROUP BY talep_form_avans_sort.talep_form_avans_id");
        if($avans_sorgu->num_rows()){
            $count+=$avans_sorgu->num_rows();
        }
        echo json_encode(array('status' => 'Success','count'=>$count));
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

    public function siparis_finist_list_count(){


        $result = $this->talep->siparis_finist_list_count();
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

    public function siparis_create(){
        $this->db->trans_start();
        $talep_id=$this->input->post('talep_id');
        $product_details=$this->input->post('product_details');
        $product_list=[];
        $index=0;
        $talep_details = $this->talep->details($talep_id);
        $proje_id = $talep_details->proje_id;
        $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $proje_id")->row();
        $yetkili_id = $yetkili_kontrol->genel_mudur_id;

        foreach ($product_details as $items){
            $data=[
                'product_id'=>$items['product_id'],
                'talep_id'=>$items['talep_id'],
                'teklif_qty'=>$items['teklif_qty'],
                'unit_id'=>$items['unit_id'],
                'price'=>$items['price'],
                'discount'=>$items['discount'],
                'talep_form_product_id'=>$items['talep_form_product_id'],
                'edv_oran'=>$items['edv_oran'],
                'edv_type'=>$items['edv_type'],
                'cemi'=>$items['cemi'],
                'umumi_cemi'=>$items['umumi_cemi'],
                'not'=>$items['not'],
                'para_birimi'=>$items['para_birimi'],
                'cari_id'=>$items['cari_id'],
                'warehouse_id'=>$items['warehouse_id'],
                'onay_list_id'=>$items['onay_list_id'],
                'aauth_id'=>$this->aauth->get_user()->id,
                'staff_id'=>$yetkili_id
            ];
            $this->db->insert('siparis_list_form', $data);
            $last_id = $this->db->insert_id();
            $data_new=[
                'siparis_liste_form_id'=>$last_id,
                'new_item_qty'=>$items['new_item_qty'],
                'new_item_price'=>$items['new_item_price'],
                'new_item_discount'=>$items['new_item_discount'],
                'new_item_kdv'=>$items['new_item_kdv'],
                'new_item_edv_durum'=>$items['new_item_edv_durum'],
                'item_edvsiz_hidden'=>$items['item_edvsiz_hidden'],
                'edv_tutari_hidden'=>$items['edv_tutari_hidden'],
                'talep_form_product_id'=>$items['talep_form_product_id'],
                'discount_type'=>$items['discount_type'],
                'item_umumi_hidden'=>$items['item_umumi_hidden'],
                'item_umumi_cemi_hidden'=>$items['item_umumi_cemi_hidden'],
                'item_discount_hidden'=>$items['item_discount_hidden'],
                'new_unit_id'=>$items['new_unit_id'],
                'new_item_desc'=>$items['new_item_desc'],
                'aauth_id'=>$this->aauth->get_user()->id,
            ];
            $product_list[$index]=$data_new;
            $index++;
        }

        if($index){
            $this->db->insert_batch('siparis_list_form_new', $product_list);
            $mesaj=$talep_details->code.' Numaralı Malzeme Talep Formunun Sipariş İşlemleri Tamamlanmıştır.Son Olarak Onayınız Beklemektedir.';
            //$this->send_mail($yetkili_id,'Sipariş Onayı',$mesaj);
            $this->talep_history($talep_id,$this->aauth->get_user()->id,'Son Sipariş Bilgisi Onaya Sunuldu');
            $this->aauth->applog("Satınalma Yetkilisi Son Sipariş İçin Onay İstedi  : Talep KODU : ".$talep_details->code, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Güncellendi'));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
        }
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
                    'user_id'=>$talep_details->warehouse_id,
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

                    //Senet AŞamasına
                    $data_talep=array(
                        'status'=>6,
                    );
                    $this->db->set($data_talep);
                    $this->db->where('id', $talep_id);
                    $this->db->update('talep_form', $data_talep);
                    //Senet AŞamasına

                    $mesaj=$talep_details->code.' Numaralı Malzeme Talep Formunun Son Sipariş İşlemleri Tamamlanmıştır.Senedeler Aşamasından İşlemlerinize Devam edebilirsiniz.';

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
                $mesaj=$talep_details->code.' Numaralı Hizmet Talep Formundaki İşlemler Tamamlanmıştır. Sorumlu Oluğunuz İş İçin Forma2 Oluşturmak İçin Talebi Kontrol Ediniz';
                if(!$this->send_mail($warehouse_id,'Hizmet Talebi Üzerinden Forma2 Bilgilendirmesi',$mesaj)){
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
            $tehvil_teslim =  $items_['tehvil_teslim'];
            $data=[
                'tehvil_teslim'=>$tehvil_teslim,
            ];

            $this->db->set($data);
            $this->db->where('item_id', $id);
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
                $product_name = product_details_($product_id)->name;

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
            'notes' => $description.' Talep Üzre Qaime',
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


                $product_name = who_demirbas($items['product_id'])->name;





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
                    'depo_id' => 7,
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
                $this->talep->product_price_details_add_func($items['talep_form_item_id'],$mt_id,$price);

                //item Bazlı Forma2 Kontrolü
                //item Bazlı Forma2 Kontrolü

            }

            if ($prodindex > 0) {
                if($shipping > 0){
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


                    $product_name= who_demirbas($products->product_id)->name;



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
        $html = $this->load->view('fileprint/ht_list_print_view', $data, true);
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

            echo json_encode(array('code' => 200,'message'=>'PDF Dosyanız Hazırdır Açmak İçin Tamama Basınız', 'href' =>'/hizmet/tehvil_print_r' ));
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
        $html = $this->load->view('fileprint/ht_tehvil_print_view', $data, true);
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
           echo json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            echo json_encode(array('status' => 'Error','count'=>0));
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
    public function forma2_kontrol()
    {
        $this->db->trans_start();

        $bildirim_uyarisi = 0;
        $onay_bildirim_uyarisi = 0;
        $talep_id = $this->input->post('talep_id');
        $forma_2_list = $this->db->query("SELECT * FROM forma_2_to_ht Where muqavele_id = $talep_id");
        if($forma_2_list->num_rows()){
            foreach ($forma_2_list->result() as $items){
                $form_2_id = $items->forma_2_id;
                $forma_2_detils = $this->db->query("SELECT * FROM geopos_invoices Where id = $form_2_id and status!=3");
                if($forma_2_detils->num_rows()){
                    if(!$forma_2_detils->row()->bildirim_durumu){
                        $bildirim_uyarisi++;
                    }
                    $onay_sorgu = $this->db->query("SELECT * FROM invoices_onay_new Where invoices_id = $form_2_id and status is null")->num_rows();
                    if($onay_sorgu){
                        $onay_bildirim_uyarisi++;
                    }
                }

            }
            if($bildirim_uyarisi && $onay_bildirim_uyarisi){
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410,'message'=>'Bildirim Başlatılmamış ve Onay Bekleyen Forma2ler mevcut'));
            }
            elseif($bildirim_uyarisi){
                $this->db->trans_rollback();

                echo json_encode(array('status' => 410,'message'=>'Bildirim Başlatılmamış Forma2ler mevcut'));
            }
            elseif($onay_bildirim_uyarisi){
                echo json_encode(array('status' => 410,'message'=>'Onay Bekleyen Forma2ler mevcut'));
            }
            else {
                $data_Form=array(
                    'status'=>8,
                );
                $this->db->set($data_Form);
                $this->db->where('id', $talep_id);
                if( $this->db->update('talep_form', $data_Form)){
                    $this->talep_history($talep_id,$this->aauth->get_user()->id,'Talep Qaime  Aşamasına Alındı. Açıklama : ');
                    $this->db->trans_complete();
                    echo json_encode(array('status' => 200,'message'=>'Başarılı Bir Şekilde Qaime Aşamasına Alındı'));
                }
                else {
                    $this->db->trans_rollback();

                }
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410,'message'=>'Talep İle İlgili Kesilen Forma 2 Mevcut Değildir.'));

        }

    }
}
