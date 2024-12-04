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

class Projectasama Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('projectasama_model', 'model');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }


    public function index()
    {

        if (!$this->aauth->premission(87)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Proje Aşamaları Listesi';
            $this->load->view('fixed/header', $head);
            $this->load->view('projectasama/index');
            $this->load->view('fixed/footer');
        }

    }

    public function ajax_list(){
        $list = $this->model->ajax_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $button="<button class='btn btn-outline-warning btn-sm edit' asama_id='$prd->id'><i class='fa fa-pen'></i></button> ";
            $button.="<button class='btn btn-outline-danger btn-sm delete' asama_id='$prd->id'><i class='fa fa-trash'></i></button>";
            $no++;
            $check="<input type='checkbox' style='margin-right: 20px;' class='form-control one_select' value='$prd->id'>";

            $new_title = parent_asama_kontrol_list($prd->id);
            $row = array();
            $row[] = $no;
            $row[] = $check;
            $row[] = $prd->id;
            $row[] = $prd->code;
            $row[] = $prd->simeta_code;
            $row[] = $new_title;
            $row[] = $prd->name;
            $row[] = $prd->desc;
            $row[] =$button;
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

    public function create(){

        if (!$this->aauth->premission(87)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->create();
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

    public function create_proje_add(){

        if (!$this->aauth->premission(87)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->create_proje_add();
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

        if (!$this->aauth->premission(87)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->update();
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
    public function delete(){

        if (!$this->aauth->premission(87)->delete) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

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

    public function info()
    {
        $id=$this->input->post('asama_id');
        $parent = $this->model->parent_info($id);
        $parent_durum=true;
        if(!$parent){
            $parent_durum=false;
        }
        echo json_encode(array('status' => 200, 'items' => $this->model->info(),'parent_durum'=>$parent_durum,'parent'=>$parent));
    }

}