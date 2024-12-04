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

class Disablepersonel Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('Disablepersonel_model', 'model');
    }

    public function index()
    {
        if (!$this->aauth->premission(59)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Pasif Personel Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('disablepersonel/index');
        $this->load->view('fixed/footer');
    }
    public function ajax_list(){
        $list = $this->model->list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {



            $bakiye=personel_bakiye_report($prd->id);
            $btn='';
            $edit = "<button class='btn btn-warning edit' pers_id='$prd->id'><i class='fa fa-pen'></i></button>&nbsp;";
            $view = "<button class='btn btn-success view' pers_id='$prd->id' type='button'><i class='fa fa-eye'></i></button>&nbsp;";
            $disable= "<button pers_id='$prd->id' class='btn btn-success disabled_button' ><i class='fa fa-chain-broken'></i>Aktifleştir</button>&nbsp;";
            //$maas_proje= "<button  data-object-id='" . $prd->id . "' class='btn btn-info  maas_pers' title='Maas Düzenleme'><i class='fa fa-money'></i> Maaş / Proje</button>";

            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='form-control one_select' pers_id='$prd->id'>";
            $row[] = $no;
            $row[] = $prd->name;
            $row[] = $prd->role_name;
            $row[] = $prd->proje_name;
            $row[] = "<input type='password' class='bakiye' style='cursor: default;border: none;' value='$bakiye'><i class='fa fa-eye-slash bakiye_show'></i>";
            $row[] = $edit.$view.$disable;
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
    public function create_save(){
        if (!$this->aauth->premission(59)->write) {
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
    public function update(){
        if (!$this->aauth->premission(59)->update) {
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
        if (!$this->aauth->premission(59)->delete) {
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

    public function disable_user(){
        if (!$this->aauth->premission(59)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Güncellemek İçin Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->disable_user();
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
        $users_details = $this->model->users_details($id);
        $salary_details = $this->model->salary_details($id);
        echo json_encode(array('status' => 200,
            'items' =>$details,
            'users_details' =>$users_details,
            'salary_details' =>$salary_details,
        ));
    }

    public function yetkili_kontrol(){
        $id = $this->input->post('id');
        if (!$this->aauth->premission($id)->read) {
            echo json_encode(array('status' => 410, 'message' =>'Görüntülemek İçin Yetkiniz Yoktur'));
        }
        else {
            echo json_encode(array('status' => 200, 'message' =>'Başarılı'));
        }
    }

}