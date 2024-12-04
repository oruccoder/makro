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

class Permissions Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('Permissions_model', 'model');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

    }
    public function index(){
        if (!$this->aauth->premission(38)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Kullanıcı İzinleri';
        $this->load->view('fixed/header', $head);
        $this->load->view('permissions/index');
        $this->load->view('fixed/footer');
    }
    public function ajax_list(){
        $list = $this->model->get_datatables_details();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $edit = "<button class='btn btn-warning edit' id='$prd->id' role_id='$prd->role_id'><i class='fa fa-pen'></i></button>&nbsp;";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->name;
            $row[] = $edit;
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

    public function info(){
        $role_id = $this->input->post('role_id');
        $details = $this->model->details($role_id);
        echo json_encode(array('status' => 200,'items' =>$details));
    }

    public function update(){
        $this->db->trans_start();
        $result = $this->model->update();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }
}