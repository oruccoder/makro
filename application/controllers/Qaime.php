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



use Mike42\Escpos\PrintConnectors\FilePrintConnector;

use Mike42\Escpos\Printer;



class Qaime extends CI_Controller

{
    public function __construct()

    {
        parent::__construct();

        $this->load->model('qaime_model', 'invocies');
        $this->load->library("Aauth");
        $this->load->model('communication_model');
        $this->load->helper('cookie');
        $this->load->model('plugins_model', 'plugins');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(1)) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        if (!$this->aauth->premission(16)) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        if ($this->aauth->get_user()->roleid == 2) {
            $this->limited = $this->aauth->get_user()->id;
        } else {
            $this->limited = '';
        }

    }


    public function index()

    {
        $head['title'] = "Fatura Listesi";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('qaime/index');
        $this->load->view('fixed/footer');

    }
}


