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



class Projebolumleri Extends CI_Controller

{
    public function __construct()

    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('projebolumleri_model', 'bolum');
        $this->load->model('tools_model', 'tools');
        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }

    }

    public function ajax_list()
    {

        $pid = $this->input->post('pid');

        $list = $this->bolum->bolumler_datatables($pid);

        $data = array();

        $no = $this->input->post('start');


        foreach ($list as $task) {

            $no++;

            $style = '';
            $bolum_to_asama = '';
            $total = 0;

            $edit = "<button bolum_id='$task->id' class='btn btn-warning edit-bolum'><i class='fa fa-edit'></i></button>&nbsp;<button bolum_id='$task->id' class='btn btn-danger delete-bolum'><i class='fa fa-trash'></i></button>";


            if (isset($task->butce)) {
                if ($task->butce < bolum_invoice($task->id, $pid)) {
                    $style = "background-color: red;color: white;";

                }


            }

            $row = array();

            $row[] = $no;

            $row[] = $task->code;
            $row[] = $task->name;
            $row[] = amountFormat($task->butce);
            $row[] = amountFormat(bolum_invoice($task->id, $pid));

            $row[] = $edit;
            $row[] = $style;
            $data[] = $row;

        }


        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->bolum->bolum_count_all($pid),

            "recordsFiltered" => $this->bolum->bolum_count_filtered($pid),

            "data" => $data,

        );

        echo json_encode($output);
    }

    public function create()
    {
        $this->db->trans_start();
        $result = $this->bolum->create();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }

    }

    public function update(){
        $this->db->trans_start();
        $result = $this->bolum->update();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function delete(){
        $this->db->trans_start();
        $result = $this->bolum->delete();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function get_info(){
        $bolum_id = $this->input->post('bolum_id');
        $result = $this->bolum->details($bolum_id);
        echo json_encode(array('status' => 200, 'item' =>$result));
    }
}