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

class Virman Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('Virman_model', 'model');
    }
    public function index()
    {
        if (!$this->aauth->premission(28)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Kasalar Arası Virman';
        $this->load->view('fixed/header', $head);
        $this->load->view('virman/index');
        $this->load->view('fixed/footer');
    }

    public function list()
    {
        if (!$this->aauth->premission(28)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen Virmanlar';
        $this->load->view('fixed/header', $head);
        $this->load->view('virman/list');
        $this->load->view('fixed/footer');
    }
    public function ajax_list(){
        $list = $this->model->list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {


            $bildirim_durumu='';
            $disabled='';
            $view='';
            if($prd->bildirim_durumu==0){
                $bildirim_durumu = "<button class='btn btn-info bildirim_olustur' talep_id='$prd->id'><i class='fa fa-bell'></i></button>&nbsp;";
            }
            else {
                $disabled='disabled';
                $view = "<button class='btn btn-success view' talep_id='$prd->id' type='button'><i class='fa fa-eye'></i></button>&nbsp;";

            }
            $cancel = "<button class='btn btn-danger talep_sil' talep_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
            $edit = "<button $disabled class='btn btn-warning edit' talep_id='$prd->id'><i class='fa fa-pen'></i></button>&nbsp;";

            $no++;
            $row = array();
            $row[] = $prd->code;
            $row[] = account_details($prd->in_account_id)->holder;
            $row[] = account_details($prd->out_account_id)->holder;
            $row[] = $prd->created_at;
            $row[] = $prd->desc;
            $row[] = $bildirim_durumu.$edit.$cancel.$view;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all(),
            "recordsFiltered" => $this->model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_bekleyen(){
        $list = $this->model->list_bekleyen();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $view = "<button class='btn btn-success view' talep_id='$prd->id' type='button'><i class='fa fa-eye'></i></button>&nbsp;";

            $talep_eden_kasa=account_details($prd->in_account_id)->holder;
            if($prd->in_account_id!=50){
                $talep_eden_kasa='<span class="badge badge-success">'.account_details($prd->in_account_id)->holder.'</span>';
            }

            $no++;
            $row = array();
            $row[] = $prd->code;
            $row[] = $talep_eden_kasa;
            $row[] = account_details($prd->out_account_id)->holder;
            $row[] = $prd->created_at;
            $row[] = $prd->desc;
            $row[] = $view;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_bekleyen(),
            "recordsFiltered" => $this->model->count_filtered_bekleyen(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function create_save(){
        if (!$this->aauth->premission(28)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->create_save();
            if($result['status']){
                echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Talep Oluşturuldu"));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
            }
        }
    }

    public function update(){
        if (!$this->aauth->premission(28)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->update();
            if($result['status']){
                echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Talep Güncellendi"));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
            }
        }
    }

    public function delete(){
        if (!$this->aauth->premission(28)->delete) {
            echo json_encode(array('status' => 410, 'message' =>'Silmek İçin Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->delete();
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

    public function info(){
        $id=$this->input->post('id');
        $details = $this->model->details($id);
        echo json_encode(array('status' => 200, 'items' =>$details));
    }

    public function bildirim_olustur(){
        if (!$this->aauth->premission(28)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Bildirim Oluşturmak İçin Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->bildirim_olustur();
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


    public function info_onay(){
        $id=$this->input->post('id');
        $details = $this->model->details($id);
        $details_onay = $this->model->details_onay($id);

        $details_items=[];
        foreach ($details_onay as $items){

            $out_para_birimi_id  = isset($items->out_account_id)?account_details($items->out_account_id)->para_birimi:0;
            $in_para_birimi_id  = isset($items->in_account_id)?account_details($items->in_account_id)->para_birimi:0;

            $onaylanan_price_out=0;
            $onaylanan_price_in=0;
            if($items->out_account_id){
                $onaylanan_price_out=$items->onaylanan_price;
            }

            if($items->in_account_id){
                $onaylanan_price_in=$items->onaylanan_price;
            }
            $details_items[]=[
                'id'=>$items->id,
                'virman_id'=>$items->virman_id,
                'sort'=>$items->sort,
                'user_id'=>personel_details_full($items->user_id)['name'],
                'us_id'=>$items->user_id,
                'aauth_id'=>$this->aauth->get_user()->id,
                'staff'=>$items->staff,
                'status'=>$items->status,
                'desc'=>isset($items->desc)?$items->desc:'',
                'created_at'=>$items->created_at,
                'update_at'=>$items->update_at,
                'out_account_id'=>isset($items->out_account_id)?account_details($items->out_account_id)->holder:'',
                'in_account_id'=>isset($items->in_account_id)?account_details($items->in_account_id)->holder:'',
                'in_price'=>$items->in_price,$in_para_birimi_id,
                'out_price'=>$items->out_price,$out_para_birimi_id,
                'in_price_text'=>amountFormat($items->in_price,$in_para_birimi_id),
                'out_price_text'=>amountFormat($items->out_price,$out_para_birimi_id),
                'account_out_price'=>$items->account_out_price,
                'account_in_price'=>$items->account_in_price,
                'onaylanan_price'=>$items->onaylanan_price,
                'onaylanan_price_out'=>$onaylanan_price_out,
                'onaylanan_price_in'=>$onaylanan_price_in,
                'onaylanan_price_out_text'=>amountFormat($onaylanan_price_out,$out_para_birimi_id),
                'onaylanan_price_in_text'=>amountFormat($onaylanan_price_in,$in_para_birimi_id),
            ];
        }
        echo json_encode(array('status' => 200, 'items' =>$details,'items_onay'=>$details_items));
    }

    public function talep_change(){
        if (!$this->aauth->premission(28)->write) {
            echo json_encode(array('status' => 410, 'message' =>'İşlemi Yapmak İçin Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->talep_change();
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


}
