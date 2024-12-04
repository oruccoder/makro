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

class Aracform Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('aracform_model', 'arac');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {


        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Araç Talep Form Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('aracform/index');
        $this->load->view('fixed/footer');
    }

    public function bekleyen_list()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Araç Talep Form Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('aracform/bekleyen_list');
        $this->load->view('fixed/footer');
    }

    public function ajax_list(){

        $list = $this->arac->get_datatables_details();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $button='';
            $bildirim_durumu='';
            $edit = "<button class='btn btn-warning edit' talep_id='$prd->id'><i class='fa fa-pen'></i></button>&nbsp;";
            if($prd->bildirim_durumu==0){
                $bildirim_durumu = "<button class='btn btn-info bildirim_olustur' talep_id='$prd->id'><i class='fa fa-bell'></i></button>&nbsp;";
            }
            $view = "<button class='btn btn-success view' talep_id='$prd->id' type='button'><i class='fa fa-eye'></i></button>&nbsp;";
            $cancel = "<button class='btn btn-danger talep_sil' talep_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
            $print = "<a class='btn btn-default print' href='/aracform/print/$prd->id' type='button'><i class='fa fa-print'></i></a>&nbsp;";


//            $cancel = "<button class='btn btn-danger talep_sil' talep_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
//            $ekipmanlar = "<button class='btn btn-info ekipmanlar' talep_id='$prd->id' type='button'><i class='fa fa-star'></i></button>&nbsp;";
//            $date = "<button class='btn btn-info date_sozlesme' talep_id='$prd->id' type='button'><i class='fa fa-calendar'></i></button>&nbsp;";
//            $icazeler = "<button class='btn btn-info icazeler' talep_id='$prd->id' type='button'><i class='fa fa-key'></i></button>&nbsp;";
//            $oil = "<button class='btn btn-info oil' talep_id='$prd->id' type='button'><i class='fa-solid fa-oil-can'></i></button>&nbsp;";
//            $drivers = "<button class='btn btn-info drivers' talep_id='$prd->id' type='button'><i class='fa-solid fa-id-card'></i></button>&nbsp;";
//            $traffic = "<button class='btn btn-info traffic' talep_id='$prd->id' type='button'><i class='fa-solid fa-traffic-light'></i></button>&nbsp;";
//            $view = "<button class='btn btn-success view' talep_id='$prd->id' type='button'><i class='fa fa-eye'></i></button>&nbsp;";

            $status='Bekliyor';
            if($prd->status==1){
                $status='Onaylandı';
            }
            elseif($prd->status==2){
                $status='İptal Edildi';
            }

            $no++;
            $row = array();
            $row[] = '<span class="avatar-lg align-baseline"><img class="myImg" resim_yolu="' . base_url() . 'userfiles/product/' . $prd->image_text . '" src="' . base_url() . 'userfiles/product/thumbnail/' . $prd->image_text . '" ></span>';
            $row[] = $prd->code;
            $row[] = $prd->plaka;
            $row[] = $prd->name;
            $row[] = personel_details($prd->user_id);
            $row[] = $prd->lokasyon;
            $row[] = $prd->start_date.' | '.$prd->end_date;
            $row[] = $status;
            //$row[] =$edit.$cancel.$ekipmanlar.$date.$icazeler.$oil.$drivers.$traffic.$view;
            $row[] =$edit.$bildirim_durumu.$view.$cancel.$print;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->arac->count_all(),
            "recordsFiltered" => $this->arac->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function ajax_list_details(){

        $list = $this->arac->get_ajax_list_details();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

           $print = "<a class='btn btn-default print' href='/aracform/print/$prd->id' type='button'><i class='fa fa-print'></i></a>&nbsp;";

            $status='Bekliyor';
            if($prd->status==1){
                $status='Onaylandı';
            }
            elseif($prd->status==2){
                $status='İptal Edildi';
            }

            $no++;
            $row = array();
            $row[] = $prd->code;
            $row[] = $prd->lokasyon;
            $row[] = $prd->gorev_sebebi;
            $row[] = $prd->start_date;
            $row[] = $prd->end_date;
            $row[] = $prd->benzin_miktari;
            $row[] = $prd->yemek_tutari;
            $row[] = personel_details($prd->user_id);
            $row[] = $status;
            $row[] =$print;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->arac->ajax_count_all_details(),
            "recordsFiltered" => $this->arac->ajax_count_filtered_details(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function ajax_list_details_surucu(){

        $list = $this->arac->get_ajax_list_details_surucu();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {


            $pers_id = $prd->pers_id;

            $pers_name = personel_details($pers_id);
            $etibarname = personel_belge_kontrol($pers_id,$prd->arac_id,9,$prd->id);
            $sürücülük = personel_belge_kontrol($pers_id,$prd->arac_id,8,$prd->id);
            $arac_muqavele = personel_belge_kontrol($pers_id,$prd->arac_id,10,$prd->id);

            $st = surucu_status($prd->status);

            $arac_degistir="<button class='btn btn-success arac_atama' talep_id='$prd->id' type='button'><i class='fa fa-truck'></i>&nbsp;Araç Değişikliği Yap</button>&nbsp;";
            $status_change="<button class='btn btn-success status_change' talep_id='$prd->id' type='button'><i class='fa fa-signal'></i>&nbsp;Durum Değiştir</button>&nbsp;";

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $pers_name;
            $row[] = $sürücülük;
            $row[] = $etibarname;
            $row[] = $arac_muqavele;
            $row[] = $prd->aktive_date;
            $row[] = $prd->passive_date;
            $row[] = $st;
            $row[] =$status_change;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->arac->ajax_count_all_details_surucu(),
            "recordsFiltered" => $this->arac->ajax_count_filtered_details_surucu(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }



    public function ajax_list_bekleyen(){

        $list = $this->arac->get_datatables_details_bekleyen();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $bildirim_durumu='';
            $edit = "<button class='btn btn-warning edit' talep_id='$prd->id'><i class='fa fa-pen'></i></button>&nbsp;";
            if($prd->bildirim_durumu==0){
                $bildirim_durumu = "<button class='btn btn-info bildirim_olustur' talep_id='$prd->id'><i class='fa fa-bell'></i></button>&nbsp;";
            }
            $view = "<button class='btn btn-success view' talep_id='$prd->id' type='button'><i class='fa fa-eye'></i></button>&nbsp;";
            $cancel = "<button class='btn btn-danger talep_sil' talep_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";

            $status='Bekliyor';
            if($prd->status==1){
                $status='Onaylandı';
            }
            elseif($prd->status==2){
                $status='İptal Edildi';
            }

            $no++;
            $row = array();
            $row[] = '<span class="avatar-lg align-baseline"><img class="myImg" resim_yolu="' . base_url() . 'userfiles/product/' . $prd->image_text . '" src="' . base_url() . 'userfiles/product/thumbnail/' . $prd->image_text . '" ></span>';
            $row[] = $prd->code;
            $row[] = $prd->plaka;
            $row[] = $prd->name;
            $row[] = personel_details($prd->user_id);
            $row[] = $status;
            //$row[] =$edit.$cancel.$ekipmanlar.$date.$icazeler.$oil.$drivers.$traffic.$view;
            $row[] =$edit.$bildirim_durumu.$view.$cancel;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->arac->count_all_bekleyen(),
            "recordsFiltered" => $this->arac->count_filtered_bekleyen(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function create_save(){
        if (!$this->aauth->premission(34)->write) {


            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->arac->create_save();
            if($result['status']){

                echo json_encode(array('status' => 'Success', 'message' =>$result['messages'],'index'=>'/arac/index'));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>$result['messages']));
            }
        }

    }

    public function create_driver(){
        if (!$this->aauth->premission(34)->write) {


            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->arac->create_driver();
            if($result['status']){

                echo json_encode(array('status' => 200, 'message' =>$result['messages']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['messages']));
            }
        }
    }

    public function update_save(){
        if (!$this->aauth->premission(34)->update) {


            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->arac->update_save();
            if($result['status']){
                echo json_encode(array('status' => 'Success', 'message' =>$result['messages'],'index'=>'/arac/index'));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>$result['messages']));
            }
        }

    }

    public function bildirim_olustur(){
        $this->db->trans_start();
        $result = $this->arac->bildirim_olustur();
        if($result){
            // Mail ile Bildirime
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Bildirim Oluşturuldu",'index'=>'/arac/index'));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }
    }

    public function iptal_et(){
        if (!$this->aauth->premission(34)->delete) {


            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->arac->iptal_et();
            if($result){
                echo json_encode(array('status' => 'Success', 'message' =>$result['messages']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>$result['messages']));
            }
        }

    }

    public function get_info(){
        if (!$this->aauth->premission(34)->read) {


            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $details = $this->arac->details();
            $users = $this->arac->users();
            echo json_encode(array(
                'status' => 'Success',
                'users' =>$users,
                'items' =>$details,
            ));
        }

    }

    public function beklyenaracform(){
        $count = $this->arac->beklyenaracform();
        echo json_encode(array('status' => 'Success', 'count' =>$count));
    }

    public function status_change_yonetim(){
        $this->db->trans_start();
        $result = $this->arac->status_change_yonetim();
        if($result['status']){
            echo json_encode(array('status' => 'Success', 'message' =>$result['messages']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>$result['messages']));
        }
    }
    public function print($tid){

        $data['id'] = $tid;
        $data['details']= $this->arac->details_print($tid);
        $data['users']=$this->arac->users_print($tid);




        ini_set('memory_limit', '64M');
        $html = $this->load->view('aracform/view-print', $data, true);
        $header = $this->load->view('aracform/header-print', $data, true);
        $footer = $this->load->view('aracform/footer-print', $data, true);



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
