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
////// yorum

defined('BASEPATH') OR exit('No direct script access allowed');

class Barcode Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 4) {

            exit('<h3>Bu bölüme giriş izniniz yoktur!</h3>');

        }
         $this->load->model('barcode_model');
        $this->load->model('categories_model');


    }


    public function barcode()
    {
        $pid = $this->input->get('pid');
        if ($pid) {
            $this->db->select('product_code,barcode');
            $this->db->from('geopos_products');
            //  $this->db->where('warehouse', $warehouse);
            $this->db->where('pid', $pid);
            $query = $this->db->get();
            $resultz = $query->row_array();
            $data['name'] = $resultz['product_code'];
            $data['code'] = "SA-PVC-KNLZ-75-2.2-3.2-3000";
            $html = $this->load->view('barcode/view', $data, true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output("Code128" . '_barcode.pdf', 'I');

        }
    }


}