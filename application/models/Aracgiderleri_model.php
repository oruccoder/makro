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





class Aracgiderleri_model extends CI_Model
{
    var $table_news = 'araclar ';

    var $column_order = array('araclar.code', 'araclar.plaka', 'araclar.name', 'arac_form.code');

    var $column_search = array('araclar.code', 'araclar.plaka', 'araclar.name', 'arac_form.code');

    var $order = array('id' => 'DESC');


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Personelgidertalep_model', 'model');

    }
}