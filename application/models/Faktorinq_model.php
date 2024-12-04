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



class Faktorinq_model extends CI_Model

{
    var $table = 'geopos_invoices';
    var $column_order = array('geopos_invoices.invoicedate','geopos_invoices.invoice_no','geopos_invoices.invoice_type_desc','geopos_customers.invoice_no', 'geopos_customers.company', 'geopos_invoices.total', 'geopos_invoices.status',  'geopos_invoices.proje_id');
    var $column_searchf = array('geopos_invoices.invoicedate','geopos_invoices.payer','geopos_invoices.invoice_no','geopos_customers.company', 'geopos_invoices.total', 'geopos_invoices.status',  'geopos_invoices.proje_id');
    var $column_search = array('geopos_customers.company', 'geopos_customers.name', 'geopos_invoices.invoicedate','geopos_invoices.invoice_no' ,'geopos_invoices.total','geopos_invoices.status','geopos_invoices.invoice_type_desc');
    var $column_orderf = array('geopos_invoices.invoicedate','geopos_invoices.id','geopos_invoices.invoice_no','geopos_invoices.id', 'geopos_invoices.total', 'geopos_invoices.status',  'geopos_invoices.proje_id');



    var $orderf = array('geopos_invoices.id' => 'desc');
    var $order = array('geopos_invoices.tid' => 'desc');

    var $column_search_depo = array('geopos_talep.talep_no', 'geopos_talep.proje_name', 'geopos_talep_items.firma', 'geopos_talep_items.product_name');
    var $column_order_depo = array(Null,'geopos_talep_items.id', 'geopos_talep.proje_name',  'geopos_talep_items.firma', 'geopos_talep_items.product_name','geopos_talep_items.qty');

    var $column_search_dosya = array('tehvil_id');
    var $column_order_dosya = array('id');

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

        $this->db->select('geopos_invoices.csd,geopos_invoices.proje_id,geopos_invoices.notes,geopos_invoices.alt_cari_id,geopos_invoices.eid,geopos_invoices.notes,geopos_invoices.invoice_name,geopos_invoices.invoice_no,geopos_invoices.id,geopos_invoices.invoice_type_id,geopos_invoices.tid,geopos_invoices.invoicedate,geopos_invoices.invoiceduedate,geopos_invoices.total,geopos_invoices.tax,geopos_invoices.subtotal,geopos_invoices.status,geopos_customers.company as name,geopos_invoices.para_birimi');

        $this->db->from($this->table);




        if($this->input->post('tip'))
        {
            $type=array($this->input->post('tip'));
        }
        else
        {
            $type=array(1,2,7,8,24,41);
        }

        $this->db->where_in('geopos_invoices.invoice_type_id',$type);

        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_invoices.invoicedate) >=', datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where('DATE(geopos_invoices.invoicedate) <=', datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
        }

        if ($this->input->post('alt_firma')) // if datatable send POST for search
        {
            $this->db->where('alt_cari_id =', $this->input->post('alt_firma')); //2019-11-23 14:28:57

        }
        if ($this->input->post('status')) // if datatable send POST for search
        {
            $this->db->where('status =', $this->input->post('status')); //2019-11-23 14:28:57

        }
        if ($this->input->post('proje_id')) // if datatable send POST for search
        {
            $this->db->where('proje_id =', $this->input->post('proje_id')); //2019-11-23 14:28:57
        }

        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');

        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_invoices.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        $i = 0;



        foreach ($this->column_search as $item) // loop column

        {

            if ($_POST['search']['value']) // if datatable send POST for search

            {



                if ($i === 0) // first loop

                {

                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, $_POST['search']['value']);

                } else {

                    $this->db->or_like($item, $_POST['search']['value']);

                }



                if (count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else {

            $this->db->order_by('geopos_invoices.invoicedate','DESC');



        }



    }

    function count_filtered($opt = '')

    {

        $this->_get_datatables_query($opt);





        $query = $this->db->get();

        return $query->num_rows();

    }



    public function count_all($opt = '')

    {

        $this->db->select('geopos_invoices.id');

        $this->db->from($this->table);

        $this->db->where('geopos_invoices.i_class', 0);

        if ($opt) {

            $this->db->where('geopos_invoices.eid', $opt);



        }

        if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);

        }

        return $this->db->count_all_results();

    }
    public function invoice_details($id, $eid = '')

    {

        $this->db->select('geopos_invoices.*,SUM(geopos_invoices.shipping + geopos_invoices.ship_tax) AS shipping,geopos_customers.*,geopos_invoices.loc as loc,geopos_invoices.id AS iid,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');

        $this->db->from($this->table);

        $this->db->where('geopos_invoices.id', $id);



        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id', 'left');

        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_invoices.term', 'left');

        $query = $this->db->get();

        return $query->row_array();

    }
    public function invoice_products($id)

    {



        $this->db->select('*');

        $this->db->from('geopos_invoice_items');

        $this->db->where('tid', $id);

        $query = $this->db->get();

        return $query->result_array();



    }
}