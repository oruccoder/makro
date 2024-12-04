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

class Lojistikgider Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('communication_model');
        $this->load->model('lojistikgider_model', 'lojistik');
        $this->load->model('lojistikcar_model', 'lojistik_car');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function ajax_list(){

        $lojistik_id = $this->input->post('id');
        $list = $this->lojistik->get_datatables_details($lojistik_id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $islem = "";
            $onay_details = $this->lojistik->lojistik_gider_onay($prd->id);
            if($onay_details->status==0){
                if($onay_details->user_id == $this->aauth->get_user()->id){
                    $islem = "<button class='btn btn-success gider_onay' onay_id='$onay_details->id' type='button'><i class='fa fa-check'></i></button>&nbsp;";
                    $islem.= "<button class='btn btn-danger gider_iptal' onay_id='$onay_details->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";

                }
                else {


                    if($onay_details->status==0) {
                        $islem.= 'Onay Bekliyor';
                    }
                    else {
                        if($onay_details->status==1){
                            $islem .= "<button class='btn btn-success rey_details' onay_id='$onay_details->id' type='button'>Onaylandı</button>&nbsp;";
                        }
                        else if($onay_details->status=2){
                            $islem .= "<button class='btn btn-danger rey_details' onay_id='$onay_details->id' type='button'>İptal Edildi</button>&nbsp;";
                        }

                    }
                }

            }
            else {
                if($onay_details->status==1){
                    $islem .= "<button class='btn btn-primary rey_details' onay_id='$onay_details->id' type='button'><i class='fa fa-check'></i></button>&nbsp;";
                }
                else if($onay_details->status=2){
                    $islem .= "<button class='btn btn-dark rey_details' onay_id='$onay_details->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
                }
            }

            $m_id = $this->db->query("Select * From lojistik_satinalma_talep Where id = $lojistik_id")->row()->lojistik_muduru;
            if($m_id==$this->aauth->get_user()->id){
                $islem.= "&nbsp;<button class='btn btn-warning gider_duzenle' lojistik_id ='$lojistik_id'  gider_id='$prd->id' type='button'><i class='fa fa-edit'></i></button>&nbsp;";
                $islem.= "&nbsp;<button class='btn btn-danger gider_sil'  lojistik_id ='$lojistik_id'  gider_id='$prd->id' type='button'><i class='fa fa-trash'></i></button>&nbsp;";
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->arac_name;
            $row[] = $prd->cost_name;
            $row[] = $prd->qty;
            $row[] =  units_($prd->unit_id)['name'];
            $row[] = amountFormat($prd->price);
            $row[] = amountFormat($prd->total_price);
            $row[] = $prd->desc;
            $row[] = isset(location_name_sorgu($prd->satinalma_location_id)->location)?location_name_sorgu($prd->satinalma_location_id)->location:'';
            $row[] =$islem;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->lojistik->count_all($lojistik_id),
            "recordsFiltered" => $this->lojistik->count_filtered($lojistik_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function cost_get_info(){
        $lojistik_id = $this->input->post('lojistik_id');
        $location_details = $this->lojistik_car->satinalma_location($lojistik_id);
        $cost = $this->lojistik->cost();
        $unit = $this->lojistik->unit();
        $araclar = $this->lojistik->satinalma_araclar($lojistik_id);
        echo json_encode((array('status'=>'Status','items'=>$location_details,'unit'=>$unit,'cost'=>$cost,'araclar'=>$araclar)));
    }
    public function create_cost(){
        $lojistik_id = $this->input->post('lojistik_id');
        $arac_id = $this->input->post('arac_id');
        $sf_lokasyon_id = $this->input->post('sf_lokasyon_id');
        $cost_id = $this->input->post('cost_id');
        $desc = $this->input->post('desc');
        $unit_id = $this->input->post('unit_id');
        $qty = $this->input->post('qty');
        $price = $this->input->post('price');
        $this->db->trans_start();

        $total_price = floatval($price)*floatval($qty);
        $data = array(
            'lojistik_id' => $lojistik_id,
            'gider_id' => $cost_id,
            'qty' => $qty,
            'unit_id' => $unit_id,
            'price' => $price,
            'total_price' => $total_price,
            'desc' => $desc,
            'satinalma_location_id' => $sf_lokasyon_id,
            'arac_id' => $arac_id,
            'user_id' => $this->aauth->get_user()->id,
        );
        if($this->db->insert('lojistik_to_gider', $data)){
            $last_id = $this->db->insert_id();

            $details = $this->db->query("SELECT * FROM lojistik_satinalma_talep Where id=$lojistik_id")->row();
            // Genel Müdüre Bilgi Maili

            $data = array(
                'lojistik_gider_id' =>$last_id,
                'status' => 0,
                'user_id' => $details->genel_mudur,
            );
             if(   $this->db->insert('lojistik_gider_onay', $data)){
                 $subject = 'Lojistik Gider Form Onayı';
                 $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Formuna Gider Oluşturuldu. Onay İşleminiz Beklenmektedir.';
                 $message .= "<br><br><br><br>";
                 $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
                         <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                      ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                 $proje_sorumlusu_email = personel_detailsa($details->lojistik_muduru)['email'];
                 $recipients = array($proje_sorumlusu_email);
                 $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$lojistik_id);
             }
             // Genel Müdüre Bilgi Maili
            $this->aauth->applog("Lojistik Gideri Oluşturuldu : " . $last_id.' Lojistik ID : '.$lojistik_id, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Bilgiler Eklendi"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }

    }

    public function update_cost(){
        $gider_id = $this->input->post('gider_id');
        $lojistik_id = $this->input->post('lojistik_id');
        $arac_id = $this->input->post('arac_id');
        $sf_lokasyon_id = $this->input->post('sf_lokasyon_id');
        $cost_id = $this->input->post('cost_id');
        $desc = $this->input->post('desc');
        $unit_id = $this->input->post('unit_id');
        $qty = $this->input->post('qty');
        $price = $this->input->post('price');
        $this->db->trans_start();
        $total_price = floatval($price)*floatval($qty);
        $data = array(
            'lojistik_id' => $lojistik_id,
            'gider_id' => $cost_id,
            'qty' => $qty,
            'unit_id' => $unit_id,
            'price' => $price,
            'total_price' => $total_price,
            'desc' => $desc,
            'satinalma_location_id' => $sf_lokasyon_id,
            'arac_id' => $arac_id,
            'user_id' => $this->aauth->get_user()->id,
        );
        $this->db->set($data);
        $this->db->where('id',$gider_id);
        if($this->db->update('lojistik_to_gider', $data)){
            $last_id = $gider_id;
            $this->aauth->applog("Lojistik Gideri Düzenlendi : " . $last_id.' Lojistik ID : '.$lojistik_id, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Bilgiler Düzenlendi"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }

    }

    public function onay_mailleri($subject, $message, $recipients, $tip)
    {

        $attachmenttrue = false;
        $attachment = '';
        $this->communication_model->onay_mail($recipients, $subject, $message, $attachmenttrue, $attachment, $tip);
        return 1;

    }

    public function gider_onay_iptal()
    {
        $desc = $this->input->post('desc');
        $onay_id = $this->input->post('onay_id');
        $status = $this->input->post('status');
        $this->db->trans_start();
        $data = array(
            'desc' => $desc,
            'status' => $status,
        );
        $this->db->set($data);
        $this->db->where('id',$onay_id);
        if ($this->db->update('lojistik_gider_onay', $data)) {
            $last_id = $onay_id;
            $this->aauth->applog("Lojistik Giderine Durum Verildi : " . $last_id.'StatusID : '.$status, $this->aauth->get_user()->username);
            $mes="Başarılı Bir Şekilde İptal Verildi";
            if($status==1){
                $mes="Başarılı Bir Şekilde Onay Verildi";
            }
            echo json_encode(array('status' => 'Success', 'message' =>$mes));
            $this->db->trans_complete();
        }
        else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
            }


    }
    public function rey_details()
    {
        $onay_id = $this->input->post('onay_id');
        $rey_details = $this->lojistik->rey_details($onay_id);
        echo json_encode(array('status' => 'Success', 'details' =>$rey_details));
    }
    public function cost_get_info_edit(){
        $lojistik_id = $this->input->post('lojistik_id');
        $cost_id = $this->input->post('gider_id');
        $location_details = $this->lojistik_car->satinalma_location($lojistik_id);
        $cost = $this->lojistik->cost();
        $unit = $this->lojistik->unit();
        $cost_details = $this->lojistik->cost_details($cost_id);
        $araclar = $this->lojistik->satinalma_araclar($lojistik_id);
        echo json_encode((array('status'=>'Status','items'=>$location_details,'unit'=>$unit,'cost'=>$cost,'araclar'=>$araclar,'cost_details'=>$cost_details)));
    }
    public function gider_sil(){
        $lojistik_id = $this->input->post('lojistik_id');
        $cost_id = $this->input->post('gider_id');
        if( $this->db->delete('lojistik_to_gider', array('id' => $cost_id)))
        {
            $this->aauth->applog("Lojistik Gideri Silindi : " . $cost_id.' Lojistik ID : '.$lojistik_id, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Silindi"));
        }
    }

    public function bekleyenlojistikgideri(){
        $user_id = $this->aauth->get_user()->id;
        $count = $this->lojistik->bekleyenlojistikgideri($user_id);
        echo json_encode(array('status' => 'Success', 'count' =>$count));
    }



    public function bekleyen_list()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Lojistik Gider Onay Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('lojistikgider/bekleyen_list');
        $this->load->view('fixed/footer');
    }

    public function ajax_list_bekleyen(){

        $list = $this->lojistik->get_datatables_details_bekleyen($this->aauth->get_user()->id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $lojistik_id = $prd->lojistik_id;


            $islem = "<button class='btn btn-success gider_onay' onay_id='$prd->onay_id' type='button'><i class='fa fa-check'></i></button>&nbsp;";
            $islem.= "<button class='btn btn-danger gider_iptal' onay_id='$prd->onay_id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";


            $no++;
            $row = array();
            $row[] = $prd->arac_name;
            $row[] = $prd->cost_name;
            $row[] = $prd->qty;
            $row[] =  units_($prd->unit_id)['name'];
            $row[] = amountFormat($prd->price);
            $row[] = amountFormat($prd->total_price);
            $row[] = $prd->desc;
            $row[] = "<a  class='btn btn-info' target='_blank' href='/logistics/view/$prd->lojistik_id'>Detayları Görüntüle</a>";
            $row[] =$islem;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->lojistik->count_all_bekleyen($this->aauth->get_user()->id),
            "recordsFiltered" => $this->lojistik->count_filtered_bekleyen($this->aauth->get_user()->id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
}
