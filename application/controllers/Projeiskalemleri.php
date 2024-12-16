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



class Projeiskalemleri Extends CI_Controller

{
    public function __construct()
    {
        parent::__construct();

        $this->load->library("Aauth");
        $selected_db = $this->session->userdata('selected_db');
        if (!empty($selected_db)) {
            $this->db = $this->load->database($selected_db, TRUE);
        }
        $this->load->model('projeiskalemleri_model', 'iskalemleri');
        $this->load->model('projeiskalemlerinew_model', 'model');
        $this->load->model('tools_model', 'tools');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

    }
    public function ajax_list()

    {

        $pid = $this->input->post('pid');

        $list = $this->iskalemleri->task_datatables($pid);

        $data = array();

        $no = $this->input->post('start');


        foreach ($list as $task) {

            $no++;

            $name = '<a class="check text-default" data-id="' . $task->id . '" data-stat="Due"> <i class="icon-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';

            if ($task->status == 'Done') {

                $name = '<a class="check text-success" data-id="' . $task->id . '" data-stat="Done"> <i class="icon-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';

            }

            if ($task->gorev_tipi == 1) {
                $tip = 'Hizmet';
            } else {
                $tip = 'Stok';
            }

            $style = '';

            if (isset($task->toplam_fiyat)) {
                if ($task->toplam_fiyat < invoice_task_total($task->id)) {
                    $style = "background-color: red;color: white;";

                }


            }

            $kalan=0;
            $id_to=$task->id;
            $totals = $this->db->query("Select SUM(qty) as total From project_is_girisi WHERE todolist_id = $id_to")->row()->total;

            $kalan=floatval($task->quantity)-floatval($totals);
            $asama_names=task_to_asama($task->parent_id).' | '.task_to_asama($task->asama_id);
            $kalan_str =  "<span class='badge badge-success detay_giris' task_id='$task->id'>".$kalan.' '.units_($task->unit)['name']."</span>";

            if($kalan < 0){
              $kalan_str="<span class='badge badge-danger detay_giris' task_id='$task->id'>".$kalan.' '.units_($task->unit)['name']."</span>";
            }
            $unit_name = units_($task->unit)['name'];
            $edit = "<button task_id='$task->id' class='btn btn-warning edit-task'><i class='fa fa-edit'></i></button>&nbsp;<button task_id='$task->id' class='btn btn-danger delete-task'><i class='fa fa-trash'></i></button>";
            $clone = "&nbsp;<button task_id='$task->id' class='btn btn-info clone-task'><i class='fa fa-clone'></i></button>";
            $row = array();
            $row[] = "<input type='checkbox' class='form-control on_checked_is_kalemleri' price='$task->fiyat' task_id='$task->id'  asama_name='$asama_names'  id='$task->id' qty='$task->quantity'  unit_id='$task->unit' unit_name='$unit_name' name_is='$task->name'>";
            $row[] = $no;
            $row[] = $tip;
            $row[] = $task->name;

            $row[] = $task->bolum_adi;
            $row[] = $asama_names;
            $row[] = amountFormat($task->fiyat);
            $row[] = $task->quantity.' '.units_($task->unit)['name'];
            $row[] = "<button type='button' class='btn btn-outline-secondary gorulmus_is_giris' task_id='$task->id'><i class='fa fa-check'></i></button>";
            $row[] = $kalan_str;
            $row[] = amountFormat($task->toplam_fiyat);
            /* $row[] = dateformat($task->start);

            $row[] = dateformat($task->duedate);*/

            $row[] = amountFormat(invoice_task_total($task->id));
            $row[] = personel_details($task->eid);
            $row[] = customer_details($task->cari_id)['company'];

            $row[] = is_kalemleri_status_id($task->is_kalemi_durumu)['name'];


            $row[] = $edit.$clone;


            $row[] = $style;

            $data[] = $row;

        }


        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->iskalemleri->task_count_all($pid),

            "recordsFiltered" => $this->iskalemleri->task_count_filtered($pid),

            "data" => $data,

        );

        echo json_encode($output);

    }
    public function create()
    {
        $this->db->trans_start();
        $result = $this->iskalemleri->create();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }

    }

    public function createnew()
    {
        $this->db->trans_start();
        $result = $this->iskalemleri->createnew();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }

    }
    public function clone()
    {
        $this->db->trans_start();
        $result = $this->iskalemleri->clone();
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
        $result = $this->iskalemleri->update();
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
        $result = $this->iskalemleri->delete();
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
        $task_id = $this->input->post('task_id');
        $result = $this->iskalemleri->details($task_id);
        $customer_details = [
            'customer_id'=>$result->cari_id,
            'company'=>customer_details($result->cari_id)['company'],
        ];
        echo json_encode(array('status' => 200, 'item' =>$result,'customer_details'=>$customer_details));
    }



    public function new_ajax_list()
    {
        $list = $this->model->ajax_list();
        $no = $this->input->post('start');
        $data = array();
        //$bolum_to_asama = bolum_to_asama($task->bolum_id);
        foreach ($list as $item) {
            $bolum_id = $this->db->query("SELECT * FROM geopos_milestones Where default_proje_asama_id=$item->asama_id")->row();
            $recete_name='Reçete Oluşturulmamış';
            if($item->recete_id){
                $recete_name='<a class="btn btn-secondary" href="/uretim/print_recete_is/'.$item->recete_id.'" target="_blank">'.recete_name($item->recete_id).'</a>';
            }
            $row = array();
            $no++;
            $row[] = $no;
            $row[] =  bolum_getir($item->bolum_id);
            $row[] = parent_asama_kontrol_list($item->asama_id).$item->asama_name;
            $row[] = $item->simeta_code;
            $row[] = $item->is_name;
            $row[] = amountFormat_s($item->unit_qty).' '.units_($item->unit_id)['name'];
            $row[] = amountFormat_proje($item->qty).' '.units_($item->unit_id)['name'];
            $row[] = $recete_name;
            $row[] = '';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->task_count_all(),
            "recordsFiltered" => $this->model->task_count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function input_create()
    {
        $this->db->trans_start();
        $result = $this->iskalemleri->input_create();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function ajax_list_is_kalemleri_ac(){

        $talep_id=$this->input->post('talep_id');

        $list = $this->iskalemleri->ajax_list_is_kalemleri_ac_list($talep_id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $cancel = "<button class='btn btn-danger is_girisi_sil' is_id='$talep_id'  is_giris_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->created_at;
            $row[] = $prd->date_input;
            $row[] = $prd->sorumlu_pers;
            $row[] = personel_detailsa($prd->auth_id)['name'];
            $row[] = $prd->desc;
            $row[] =amountFormat_s($prd->qty).' '.units_($prd->olcu_birimi)['name'];
            $row[] =$cancel;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->iskalemleri->ac_list_count($talep_id),
            "recordsFiltered" => $this->iskalemleri->ac_list_filtered($talep_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function is_giris_delete(){
        $this->db->trans_start();
        $id = $this->input->post('is_giris_id');
        $proje_id = $this->input->post('proje_id');
        $details = $this->db->query("SELECT * FROM project_is_girisi WHERE id=$id ");
        if($details->num_rows()){
            if($details->row()->auth_id == $this->aauth->get_user()->id){
                if($this->db->delete('project_is_girisi', array('id' => $id))){
                    $this->iskalemleri->talep_history($proje_id,$this->aauth->get_user()->id,"iş Girişi Silindi ".$id);
                    $this->db->trans_complete();
                    echo json_encode(array('status' => 200,'message'=>'Başarıyla Silindi'));
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
                }
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>"İş Girişini Oluşturan Personelden Başkası Silemez!."));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Böyle Bir İş Girişi Bulunamadı."));
        }


    }

}