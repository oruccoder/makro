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

class Azpetrol Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('azpetrol_model', 'model');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        if (!$this->aauth->premission(85)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Azpetrol Kontrol Paneli';
            $this->load->view('fixed/header', $head);
            $this->load->view('azpetrol/index');
            $this->load->view('fixed/footer');
        }
    }

    public function create_save(){
        if (!$this->aauth->premission(85)->write) {
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

    public function create_save_cart(){
        if (!$this->aauth->premission(85)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->create_save_cart();
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

    public function update_car_cart(){
        if (!$this->aauth->premission(85)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->update_car_cart();
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

    public function update_balanca_cart(){
        if (!$this->aauth->premission(85)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->update_balanca_cart();
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

    public function ajax_list_bakiye(){
        $list = $this->model->ajax_list_bakiye();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $tip='Çıkış';
            if($prd->tip==1){
                $tip='Giriş';
            }
            $no++;
            $row = array();
            $row[] = $prd->created_at;
            $row[] = $prd->pers_name;
            $row[] = $tip;
            $row[] = amountFormat($prd->amounth);
            $row[] = $prd->desc;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_bakiye(),
            "recordsFiltered" => $this->model->count_filtered_bakiye(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_kart_bakiye(){
        $list = $this->model->ajax_list_kart_bakiye();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $tip='Çıkış';
            if($prd->tip==1){
                $tip='Giriş';
            }
            $no++;
            $row = array();
            $row[] = $prd->created_at;
            $row[] = $prd->cart_number;
            $row[] = $prd->pers_name;
            $row[] = $tip;
            $row[] = amountFormat($prd->amounth);
            $row[] = $prd->desc;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_bakiye_kart(),
            "recordsFiltered" => $this->model->count_filtered_bakiye_kart(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_kart_arac(){
        $list = $this->model->ajax_list_kart_arac();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $tip='Çıkış';
            if($prd->tip==1){
                $tip='Giriş';
            }
            $no++;
            $row = array();
            $row[] = $prd->created_at;
            $row[] = $prd->plaka;
            $row[] = $prd->pers_name;
            $row[] = $tip;
            $row[] = amountFormat($prd->amounth);
            $row[] = $prd->desc;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_arac(),
            "recordsFiltered" => $this->model->count_filtered_arac(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
}