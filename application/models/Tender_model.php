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



class Tender_model extends CI_Model

{
    public function __construct()

    {

        parent::__construct();

    }

    function get_datatables($opt = '')

    {

        $this->_get_datatables_query($opt);


        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();




        return $query->result();

    }
    private function _get_datatables_query($opt = '')

    {

        // $where='geopos_invoices.i_class=0 and (geopos_invoices.invoice_type_id=21 or geopos_invoices.invoice_type_id=2 or geopos_invoices.invoice_type_id=1 or geopos_invoices.invoice_type_id=7 or geopos_invoices.invoice_type_id=8)';
        $search = $this->input->post('search');
        $this->db->select('*');

        $this->db->from('tender_list');






        $i = 0;

        $this->db->order_by('tender_list.id','DESC');



    }
    function count_filtered($opt = '')

    {

        $this->_get_datatables_query($opt);





        $query = $this->db->get();

        return $query->num_rows();

    }
    public function count_all($opt = '')

    {

        $this->_get_datatables_query();

        return $this->db->count_all_results();

    }

}