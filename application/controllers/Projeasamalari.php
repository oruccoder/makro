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



class Projeasamalari Extends CI_Controller

{
    public function __construct()

    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('projeasamalari_model', 'asama');
        $this->load->model('tools_model', 'tools');
        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }

    }

    public function ajax_list()
    {

        $pid = $this->input->post('pid');
        $list = $this->asama->asamalar_datatables($pid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $task) {
            $style = '';
            $bolum_to_asama = '';
            $total = 0;

            if (isset($task->total)) {
                if ($task->total < asama_invoice($task->id, $pid)) {
                    $style = "background-color: red;color: white;";

                }


            }

            $total = $task->total;

            if (isset($task->bolum_id)) {
                $bolum_to_asama = bolum_to_asama($task->bolum_id);

            } else {
                $bolum_to_asama = '';
            }


            $no++;



            $parent_ = '';
            $task_name = '';
            if ($task->parent_id != 0) {
                $parent_ = $task->name;
                $task_name = task_to_asama($task->parent_id);
            } else {
                $parent_ = $task->name;
                $task_name = '';
            }

            $p=$this->db->query("SELECT * FROM geopos_milestones WHERE parent_id=$task->id");
            if ($p->num_rows() < 1)
            {
                $button = "<button asama_id='$task->id' class='btn btn-warning edit-asama'><i class='fa fa-edit'></i></button>&nbsp;<button asama_id='$task->id' class='btn btn-danger delete-asama'><i class='fa fa-trash'></i></button>";
                $row = array();
                $row[] = $no;
                $row[] = $bolum_to_asama;
                $row[] = $task_name;
                $row[] = $parent_;
                $row[] = $task->pers_name;
                $row[] = customer_details($task->customer_id)['company'];
                $row[] = amountFormat($total);
                $row[] = amountFormat(asama_invoice($task->id, $pid));
                $row[] = $button;
                $row[] = $style;
                $data[] = $row;
            }


        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->asama->asama_count_all($pid),

            "recordsFiltered" => $this->asama->asama_count_filtered($pid),

            "data" => $data,

        );

        echo json_encode($output);
    }

    public function create()
    {
        $this->db->trans_start();
        $result = $this->asama->create();
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
        $result = $this->asama->update();
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
        $result = $this->asama->delete();
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
        $asama_id = $this->input->post('asama_id');
        $result = $this->asama->details($asama_id);
        $customer_details = [
            'customer_id'=>$result->customer_id,
            'company'=>customer_details($result->customer_id)['company'],
        ];
        echo json_encode(array('status' => 200, 'item' =>$result,'customer_details'=>$customer_details));
    }
}