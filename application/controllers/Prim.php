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

class Prim Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('prim_model', 'model');
        $this->load->model('communication_model');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        if (!$this->aauth->premission(74)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Prim / Ceza Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('prim/index');
        $this->load->view('fixed/footer');
    }

    public function ajax_list(){

        $list = $this->model->ajax_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $tip='Prim';
            if($prd->type==2){
                $tip='Ceza';
            }
            //$cancel = "<button class='btn btn-danger talep_sil' talep_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
            $view = "<button class='btn btn-success view' prim_id='$prd->id' type='button'><i class='fa fa-eye'></i></button>&nbsp;";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->personel_name;
            $row[] = $prd->aciklama;
            $row[] = dateformat_new($prd->created_at);
            $row[] = $prd->hesaplanan_ay;
            $row[] = $tip;
            $row[] = amountFormat($prd->tutar);
            $row[] = $view;
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
    public function get_info_prim_confirm(){
        $id = $this->input->post('prim_id');
        $result = $this->model->get_info_prim_confirm($id);
        if($result){
            echo json_encode(array('status' => 200, 'item' =>$result));
        }
        else {
            echo json_encode(array('status' => 410, 'messages' =>'Hata Aldınız'));
        }

    }
}