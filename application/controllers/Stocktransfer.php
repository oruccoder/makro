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

class Stocktransfer Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('stocktransfer_model', 'stocktransfer');
        $this->load->model('malzemetalep_model', 'talep');
        $this->load->model('communication_model');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    { 
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Anbar Transferi';
        $this->load->view('fixed/header', $head);
        $this->load->view('stocktransfer/index');
        $this->load->view('fixed/footer');
    }

    public function ajax_list(){

        $list = $this->stocktransfer->get_datatables_query_details_list();
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $prd) {
            $bildirim_durumu="<button disabled class='btn btn-info bildirim_olustur' transfer_id='$prd->id'><i class='fa fa-bell'></i></button>&nbsp;";
            if($prd->bildirim_durumu==0){
                $bildirim_durumu = "<button  class='btn btn-info bildirim_olustur' transfer_id='$prd->id'><i class='fa fa-bell'></i></button>&nbsp;";
            }
            $edit = "<button class='btn btn-warning edit' transfer_id='$prd->id'><i class='fa fa-pen'></i></button>&nbsp;";
            $cancel = "<button class='btn btn-danger talep_sil' transfer_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
            $print = "<a href='/stocktransfer/print_page/?print=$prd->id' target='_blank' class='btn btn-danger print' transfer_id='$prd->id' type='button'><i class='fa fa-print'></i></a>&nbsp;";

            $cikis_depo=warehouse_details($prd->out_warehouse_id)->title;
            $giris_depo=warehouse_details($prd->in_warehouse_id)->title;

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->code;
            $row[] = $cikis_depo;
            $row[] = $giris_depo;
            $row[] =$edit.$cancel.$bildirim_durumu.$print;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->stocktransfer->count_all(),
            "recordsFiltered" => $this->stocktransfer->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function create(){

        //print_r($this->input->post('collection')); die();
        $this->db->trans_start();
        $result = $this->stocktransfer->create_save();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Stok Transfer Talebi Oluşturuldu"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }


    public function update(){
        $this->db->trans_start();
        $result = $this->stocktransfer->update();
        if($result['status']){
            echo json_encode(array('code' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('code' => 410, 'message' =>$result['message']));
        }
    }

    public function info(){
        $transfer_id = $this->input->post('transfer_id');
        $details = $this->stocktransfer->details($transfer_id);
        $details_items = $this->stocktransfer->details_item($transfer_id);

        $cikis_depo=warehouse_details($details->out_warehouse_id)->title;
        $giris_depo=warehouse_details($details->in_warehouse_id)->title;

        echo json_encode(array('status' => 'Success', 'details'=>$details,'details_items'=>$details_items,'out_warehouse_name'=>$cikis_depo,'in_warehouse_name'=>$giris_depo));

    }

    public function delete_file(){
        $this->db->trans_start();
        $transfer_id = $this->input->post('transfer_id');

        $details = $this->stocktransfer->details($transfer_id);
        if($details->bildirim_durumu){
            echo json_encode(array('code' => 410, 'message' =>"Bildirim Başlatılmış Talepte Silme Yapılamaz."));
        }
        else {
            if($this->db->delete('stock_transfer', array('id' => $transfer_id))){
                $this->db->delete('stock_transfer_items', array('stock_transfer_id' => $transfer_id));
                $this->aauth->applog("Stok Transfer Fişi Silindi  : File ID : ".$transfer_id, $this->aauth->get_user()->username);
                $this->db->trans_complete();
                echo json_encode(array('code' => 200,'message'=>'Başarıyla İptal Edildi'));
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('code' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
            }
        }



    }

    public function bildirim_olustur(){

        $this->db->trans_start();
        $result = $this->stocktransfer->bildirim_olustur();
        if($result['status'] == 410){
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
        else {
            $this->db->trans_complete();
            echo json_encode(array('status' => 200, 'message' =>$result['message']));
        }
    }


    public function transfer_update(){
        $this->db->trans_start();
        $result = $this->stocktransfer->transfer_update();
        if($result['status']){
            //mail Bildirimi
            //mail Bildirimi
            echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Durumunuz Bildirildi"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }
    public function transfer_onay_list(){
        $list = $this->stocktransfer->get_datatables_query_transfer_list();

        $data = array();
        $no = $this->input->post('start');

        $index=0;
        foreach ($list as $key=> $prd) {

            $kontrol=$this->db->query("SELECT * FROM stock_transfer_item_notification Where stock_transfer_item_notification.stock_item_id = $prd->item_id and type = 1");
            if($kontrol->num_rows()){
                if($kontrol->row()->status==1 || $kontrol->row()->status==0){
                    $cikis_depo=warehouse_details($prd->out_warehouse_id)->title;
                    $giris_depo=warehouse_details($prd->in_warehouse_id)->title;

                    $varyasyon=varyasyon_string_name($prd->option_id,$prd->option_value_id);

                    $no++;
                    $row = array();
                    $new=$prd->new_qty;
                    if($prd->new_qty==0){
                        $new=$prd->qty;
                    }
                    $disable='';
                    if($prd->type==1){ // Çıkış
                        $disable='disabled';
                    }
                    $row[] = "<label class='checkbox'><input stock_id='$prd->stock_id' type_id='$prd->type' type='checkbox' name='materialCheck' eq='$index' notifation_id='$prd->id' class='one_select'><i style='top: 12px;'></i></label>";
                    $row[] = $prd->code;
                    $row[] = $cikis_depo;
                    $row[] = $giris_depo;
                    $row[] = $prd->product_name;
                    $row[] = $varyasyon;
                    $row[] = $prd->qty;
                    $row[] = "<input $disable type='number' value='$new' class='form-control new_qty'>";
                    $row[] = $prd->unit_name;
                    $row[] = $prd->desc;
                    $row[] = $prd->pers_name;

                    $data[] = $row;
                    $index++;
                }

            }

        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->stocktransfer->count_all_transfer(),
            "recordsFiltered" => $this->stocktransfer->count_filtered_transfer(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function warehousetransfercount(){
        $result = $this->talep->warehousetransfercount();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }

    public function talepwarehousetransfercount(){
        $result = $this->talep->talepwarehousetransfercount();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }


    public function talep_transfer_onay_list(){
        $list = $this->stocktransfer->get_datatables_query_talep_transfer_list();

        $data = array();
        $no = $this->input->post('start');

        $index=0;
        foreach ($list as $key=> $prd) {
            $cikis_depo=warehouse_details($prd->teslim_edilecek_warehouse_id)->title;
            $giris_depo=warehouse_details($prd->warehouse_id)->title;

            $check='';
            $durum='';
            if($prd->status==0){
                $durum='Gözlemede';
                $check="<label class='checkbox'><input type='checkbox' wt_id='$prd->wt_id' name='materialCheck' eq='$index'  class='one_select'><i style='top: 12px;'></i></label>";
            }
            elseif($prd->status==1){
                $durum='Onaylandı';
                $check="<label class='checkbox'><input type='checkbox' wt_id='$prd->wt_id' name='materialCheck' eq='$index'  class='one_select'><i style='top: 12px;'></i></label>";
            }
            elseif($prd->status==2){
                $durum='İptal Edildi';
                $check="<label class='checkbox'><input type='checkbox' wt_id='$prd->wt_id' name='materialCheck' eq='$index'  class='one_select'><i style='top: 12px;'></i></label>";
            }
            $row[] = $check;
            $row[] = $prd->code;
            $row[] = $cikis_depo;
            $row[] = $giris_depo;
            $row[] = $prd->product_name;
            $row[] = $prd->qty;
            $row[] = $prd->unit_name;
            $row[] = $prd->pers_name;
            $row[] = $durum;
            $data[] = $row;
            $index++;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->stocktransfer->count_all_talep_transfer(),
            "recordsFiltered" => $this->stocktransfer->count_filtered_talep_transfer(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function talep_transfer_update(){
        $this->db->trans_start();
        $result = $this->stocktransfer->talep_transfer_update();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Durumunuz Bildirildi"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }


    public function print_page()
    {

        $id = (int) $_GET['print'];

        $data['details'] = $this->stocktransfer->get_trasnfers($id);
        $data['items'] = $this->stocktransfer->get_products($id);
        $data['in_warehouse_name'] = warehouse_details($data['details']->in_warehouse_id)->title;
        $data['out_warehouse_name'] = warehouse_details($data['details']->out_warehouse_id)->title;

        ini_set('memory_limit', '64M');

        $this->load->library('pdf');
        $pdf = $this->pdf->load_split();
        $pdf = $this->pdf->load();

        $html = $this->load->view('stocktransfer/print_page', $data, true);

        $pdf->WriteHTML($html);
        $pdf->Output();
    }


}
