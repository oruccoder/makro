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



class Restservice_model extends CI_Model

{



    public function customers($id = '')

    {



        $this->db->select('*');

        $this->db->from('geopos_employees');

        if ($id != '') {



            $this->db->where('id', $id);

        }

        $query = $this->db->get();

        return $query->result_array();

    }



    public function delete_customer($id)

    {

        return $this->db->delete('geopos_customers', array('id' => $id));

    }



      public function products($id = '')

    {



        $this->db->select('*');

        $this->db->from('geopos_products');

        if ($id != '') {



            $this->db->where('id', $id);

        }

        $query = $this->db->get();

        return $query->result_array();

    }



        public function invoice($id)

    {

        $this->db->select('geopos_invoices.*,geopos_customers.*,geopos_invoices.id AS iid,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');

        $this->db->from('geopos_invoices');

        $this->db->where('geopos_invoices.id', $id);

        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id', 'left');

        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_invoices.term', 'left');

        $query = $this->db->get();

        $invoice=$query->row_array();

        $loc=location($invoice['loc']);

          $this->db->select('geopos_invoice_items.*');

        $this->db->from('geopos_invoice_items');

        $this->db->where('geopos_invoice_items.tid', $id);

         $query = $this->db->get();

        $items=$query->result_array();

        return array(array('invoice'=>$invoice,'company'=>$loc,'items'=>$items,'currency'=> currency($invoice['loc'])));

    }





}