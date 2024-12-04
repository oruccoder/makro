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

class Caripointvalue Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('caripointvalue_model', 'model');
    }
    public function index(){
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Cari Puanlama Değerleri';
        $this->load->view('fixed/header', $head);
        $this->load->view('caripointvalue/index');
        $this->load->view('fixed/footer');
    }
    public function list(){
        $list = $this->model->list();
        $data = [];
        $no=0;
        foreach ($list as $customers) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $customers->name;
            $row[] = $customers->personel_name;
            $row[] = $customers->created_at;
            $row[] = '';
            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->model->count_all(),
            "recordsFiltered" => $this->model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }
    public function create(){

    }
    public function update(){

    }
    public function delete(){

    }
    public function info(){

    }
}