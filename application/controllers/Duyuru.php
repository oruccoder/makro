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

class Duyuru Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        $this->load->model('duyuru_model', 'model');
    }

    public function view($id)
    {
        $data['url']=$this->model->details($id)->dosya_url;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Duyuru Bilgilendirme';
        $this->load->view('fixed/header', $head);
        $this->load->view('duyuru/view',$data);
        $this->load->view('fixed/footer');
    }
}