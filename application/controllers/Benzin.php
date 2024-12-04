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

class Benzin Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('benzin_model', 'model');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        if (!$this->aauth->premission(86)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Benzin Çeni Kontrol Paneli';
            $this->load->view('fixed/header', $head);
            $this->load->view('benzin/index');
            $this->load->view('fixed/footer');
        }
    }

    public function benzin_type_quantity(){
        $result = $this->model->benzin_type_quantity();
        if($result['status']){
            echo json_encode(array('status' => 200, 'kalan' =>$result['kalan']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function benzin_bakiye_cen(){
        $cen_id = $this->input->post('cen_id');
        $kalan = benzin_bakiye_cen($cen_id);
        if($kalan){
            echo json_encode(array('status' => 200, 'kalan' =>$kalan['kalan'],'kalan_num' =>$kalan['kalan_num']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>'Yanacaq Bulunamadı'));
        }
    }
    public function create_save(){
        if (!$this->aauth->premission(86)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->create_save();
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

    public function create_save_cen(){
        if (!$this->aauth->premission(86)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->create_save_cen();
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

    public function update_balanca_cen(){
        if (!$this->aauth->premission(86)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->update_balanca_cen();
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

    public function update_bakiye_benzin_type(){
        if (!$this->aauth->premission(76)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->update_bakiye_benzin_type();
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

    public function update_car_cen(){
        if (!$this->aauth->premission(86)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->update_car_cen();
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

    public function delete_cen(){
        if (!$this->aauth->premission(76)->delete) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->delete_cen();
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
        public function cari_borclandir(){
        if (!$this->aauth->premission(76)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->cari_borclandir();
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

    public function get_info_benzin_cari(){
        if (!$this->aauth->premission(76)->read) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->get_info_benzin_cari();
            if($result['status']){
                echo json_encode(array('status' => 200, 'details' =>$result['details']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }
    }

    public function ajax_list_bakiye(){
        $list = $this->model->ajax_list_bakiye();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $tip='<span class="badge badge-warning">Çıkış</span>';
            if($prd->tip==1){
                $tip='<span class="badge badge-success">Giriş</span>';
            }
            $no++;
            $row = array();
            $row[] = $prd->created_at;
            $row[] = $prd->pers_name;
            $row[] = $prd->code;
            $row[] = isset(benzin_type_who($prd->benzin_type_id)->name)?benzin_type_who($prd->benzin_type_id)->name:'<button type="button" bakiye_id="'.$prd->id.'" class="btn btn-info benzin_type_change"><i class="fa fa-check"></i></button>';
            $row[] = $prd->arac_kodu.' | '.$prd->plaka;
            $row[] = $tip;
            $row[] = amountFormat_s($prd->quantity);
            $row[] = $prd->desc;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_bakiye(),
            "recordsFiltered" => $this->model->count_filtered_bakiye(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_kart_bakiye(){
        $list = $this->model->ajax_list_kart_bakiye();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $tip='Çıkış';
            if($prd->tip==1){
                $tip='Giriş';
            }
            $no++;
            $row = array();
            $row[] = $prd->created_at;
            $row[] = $prd->code;
            $row[] = benzin_type_who($prd->benzin_type_id)->name;
            $row[] = $prd->pers_name;
            $row[] = $tip;
            $row[] = amountFormat_s($prd->quantity);
            $row[] = $prd->desc;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_bakiye_kart(),
            "recordsFiltered" => $this->model->count_filtered_bakiye_kart(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_kart_arac(){
        $list = $this->model->ajax_list_kart_arac();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $tip='Çıkış';
            if($prd->tip==1){
                $tip='Giriş';
            }
            $cari_durum='-';
            if($prd->firma_id){
                $text='';
                if(!$prd->cari_status){
                    $bc_id=$prd->benzin_cari_durumu_id;
                    $text=' - <button type="button" class="btn btn-danger cari_borclandir" tip="1" benzin_cari_durumu_id="'.$bc_id.'">Borçlandırılmamış</button>';
                }
                else {
                    $text=' - <a target="_blank" class="btn btn-success" href="/transactions/view?id='.$prd->transaction_id.'"><i class="fa fa-eye"></i> Borçalandırılmış</button>';
                }
                $cari_durum=$prd->company.$text;

            }
            $no++;
            $row = array();
            $row[] = "<a class='btn btn-info' href='/benzin/print_arac_tehvil/$prd->bb_id' target='_blank'><i class='fa fa-print'></i>&nbsp;$prd->created_at</a>";
            $row[] = $prd->cen_code;
            $row[] = $prd->code.' | '.$prd->plaka;
            $row[] = $prd->pers_name;
            $row[] = $tip;
            $row[] = amountFormat_s($prd->quantity);
            $row[] = $prd->desc;
            $row[] = $cari_durum;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_arac(),
            "recordsFiltered" => $this->model->count_filtered_arac(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function print_arac_tehvil($id){
        $data['details']= $this->model->bakiye_details($id);
        ini_set('memory_limit', '999M');


        $html = $this->load->view('fileprint/b_arac_print_view', $data, true);

        $header = $this->load->view('fileprint/b_arac_print_header', $data, true);

        $footer = $this->load->view('fileprint/b_arac_print_footer', $data, true);

        $this->load->library('pdf');

        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter($footer);
        $pdf->AddPage(
            'L', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            75, // margin top
            '72', // margin bottom
            5, 2, 0, 0, // margin header
            'auto'); // margin footer


        $pdf->WriteHTML($html);


        $file_name ="Teklif__";


        $pdf->Output($file_name . '.pdf', 'I');
    }
}