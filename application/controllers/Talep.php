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

class Talep Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('Talep_model', 'model');
    }
    public function index()
    {
        if (!$this->aauth->premission(47)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Talep';
        $data['totals']=amountFormat($this->model->form_total_bekleyen());
        $data['bank']=amountFormat($this->model->form_total_bekleyen_method(3));
        $data['nakit']=amountFormat($this->model->form_total_bekleyen_method(1));
        $this->load->view('fixed/header', $head);
        $this->load->view('carigidertalep/index',$data);
        $this->load->view('fixed/footer');
    }
}
