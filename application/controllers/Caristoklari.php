<?php

/**
 * İtalic Soft Yazılım  ERP - CRM - HRM
 * Copyright (c) İtalic Soft Yazılım. Tüm Hakları Saklıdır.
 * ***********************************************************************
 *
 *  Email: info@italicsoft.com
 *  Website: https://www.italicsoft.com
 *  Tel: 0850 317 41 44
 *  ************************************************************************
 */



defined('BASEPATH') OR exit('No direct script access allowed');



class Caristoklari Extends CI_Controller

{
    public function __construct()

    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('Caristoklari_model', 'stok');
        $this->load->model('tools_model', 'tools');
        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }
    }

    public function index(){
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Cari Giriş / Çıkış Fiş Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('caristoklari/index');
        $this->load->view('fixed/footer');
    }

    public function ajax_stok_fis_list()
    {
        $list = $this->stok->datatables_stok_fis_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $item) {

            $edit = "<button data-id='$item->stock_io_id_new' class='btn btn-danger cancel-stockio'><i class='fa fa-ban'></i></button>&nbsp<button data-id='$item->stock_io_id_new' class='btn btn-warning edit-stockio'><i class='fa fa-edit'></i></button>&nbsp<a type='button' href='/stockio/print/?print=$item->stock_io_id_new&whareouse=$item->warehouse_id' TARGET='_blank' class='btn btn-info'><i class='fa fa-print'></i></a>  ";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $item->fis_code;
            $row[] = $item->fis_type_name;
            $row[] = $item->warehouse;
            $row[] =$edit;
            $data[] = $row;

        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->stok->count_all_fis_list(),
            "recordsFiltered" => $this->stok->count_filtered_fis_list(),
            "data" => $data,

        );

        echo json_encode($output);
    }

    public function create_fis(){


        $this->db->trans_start();
        $result = $this->stok->create_fis();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function update_fis(){


        $this->db->trans_start();
        $result = $this->stok->update_fis();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function delete_fis(){


        $this->db->trans_start();
        $result = $this->stok->delete_fis();
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