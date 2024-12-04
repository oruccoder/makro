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

/*Baza olan iş kalemleri controlleri*/

class Projectiskalemleri Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('Projectiskalemleri_model', 'model');
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
            $head['title'] = 'İŞ Kalemleri Listesi';
            $this->load->view('fixed/header', $head);
            $this->load->view('projectiskalemleri/index');
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
            $new_title = parent_asama_kontrol_list($prd->asama_id).new_asama_name($prd->asama_id)->name;
            $recete_name='Reçete Oluşturulmamış';
            if($prd->recete_id){
                $recete_name='<a class="btn btn-secondary" href="/uretim/print_recete_is/'.$prd->recete_id.'" target="_blank">'.recete_name($prd->recete_id).'</a>';
            }

            $check="<input type='checkbox' class='form-control one_select' value='$prd->id'>";

            $row = array();
            $row[] = $no;
            $row[] = $check;
            $row[] = $prd->code;
            $row[] = $prd->simeta_code;
            $row[] = $new_title;
            $row[] = $prd->name;
            $row[] = amountFormat_s($prd->unit_qty).' '.units_($prd->unit_id)['name'];
            $row[] = $recete_name;
            $row[] = $prd->desc;
            $row[] = "<input type='number' value='0'  class='form-control qty".$prd->id."'>";
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
        $parent_durum=true;
        echo json_encode(array('status' => 200, 'items' => $this->model->info()));
    }

    public function search_is_kalemi()
    {
        $is_kalemi_asama_add_id=$this->input->post('is_kalemi_asama_add_id');
        $keyword=$this->input->post('keyword');
        $where = " (projeiskalmeleri.name LIKE '%$keyword%' or  projeiskalmeleri.code LIKE '%$keyword%' or `projeiskalmeleri`.`simeta_code` LIKE '%$keyword%' or `projeiskalmeleri`.`desc` LIKE '%$keyword%' ) and asama_id=$is_kalemi_asama_add_id";

        $query = $this->db->query("SELECT * FROM projeiskalmeleri Where  $where
ORDER BY projeiskalmeleri.name DESC LIMIT 30");
        if($query->num_rows()){
            foreach ($query->result() as $items){
                $data[]=[
                    'id'=>$items->id,
                    'unit_name'=>units_($items->unit_id)['name'],
                    'unit_qty'=>amountFormat_s($items->unit_qty),
                    'name'=>$items->name,
                    'code'=>$items->code,
                    'simeta_code'=>$items->simeta_code,
                    //'option_html'=>varyasyon_string_name($items->option_id,$items->option_value_id)
                ];
//                    }

            }
            echo json_encode(array('status' => 'Success','products'=>$data));
        }
        else {
            echo json_encode(array('status' => 'Error', 'message' =>"İş Kalemi Bulunamadı"));
        }
    }

}