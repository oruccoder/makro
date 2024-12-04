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



class Chart_model extends CI_Model

{



    public function productcat($type,$c1='',$c2='')

    {

        switch ($type) {

            case 'week':

                $day1 = date("Y-m-d", strtotime(' - 7 days'));

                $day2 = date('Y-m-d');

                break;

                        case 'month':

                $day1 = date("Y-m-d", strtotime(' - 30 days'));

                $day2 = date('Y-m-d');

                break;

                case 'year':

                $day1 = date("Y-m-d", strtotime(' - 1 years'));

                $day2 = date('Y-m-d');

                break;



                 case 'custom':

                $day1 = datefordatabase($c1);

                $day2 = datefordatabase($c2);

                break;



            default :

                $day1 = date("Y-m-d", strtotime(' - 30 days'));

                $day2 = date('Y-m-d');

                break;

        }

        $this->db->select_sum('geopos_invoice_items.qty');

        $this->db->select_sum('geopos_invoice_items.subtotal');

        $this->db->select('geopos_invoice_items.pid');

        $this->db->select('geopos_product_cat.title');

        $this->db->from('geopos_invoice_items');

        $this->db->group_by('geopos_product_cat.id');

        $this->db->join('geopos_invoices', 'geopos_invoices.id = geopos_invoice_items.tid', 'left');

        $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');

        $this->db->join('geopos_product_cat', 'geopos_product_cat.id = geopos_products.pcat', 'left');

        $month = date('Y-m');

        $today = date('Y-m-d');

        $this->db->where('DATE(geopos_invoices.invoicedate) >=', $day1);

        $this->db->where('DATE(geopos_invoices.invoicedate) <=', $day2);

        $query = $this->db->get();

        $result = $query->result_array();

        return $result;

    }



        public function trendingproducts($type,$c1='',$c2='')

    {

        switch ($type) {

            case 'week':

                $day1 = date("Y-m-d", strtotime(' - 7 days'));

                $day2 = date('Y-m-d');

                break;

                        case 'month':

                $day1 = date("Y-m-d", strtotime(' - 30 days'));

                $day2 = date('Y-m-d');

                break;

                case 'year':

                $day1 = date("Y-m-d", strtotime(' - 1 years'));

                $day2 = date('Y-m-d');

                break;



                 case 'custom':

                $day1 = datefordatabase($c1);

                $day2 = datefordatabase($c2);

                break;



            default :

                $day1 = date("Y-m-d", strtotime(' - 30 days'));

                $day2 = date('Y-m-d');

                break;

        }



        $this->db->select_sum('geopos_invoice_items.qty');

        $this->db->select('geopos_products.product_name');

        $this->db->from('geopos_invoice_items');

        $this->db->group_by('geopos_invoice_items.pid');

        $this->db->join('geopos_invoices', 'geopos_invoices.id = geopos_invoice_items.tid', 'left');

        $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');



        $this->db->where('DATE(geopos_invoices.invoicedate) >=', $day1);

        $this->db->where('DATE(geopos_invoices.invoicedate) <=', $day2);

        $this->db->order_by('geopos_invoice_items.qty', 'DESC');

        $this->db->limit(100);

        $query = $this->db->get();

        $result = $query->result_array();

        return $result;

    }



            public function profitchart($type,$c1='',$c2='')

    {

        switch ($type) {

            case 'week':

                $day1 = date("Y-m-d", strtotime(' - 7 days'));

                $day2 = date('Y-m-d');

                break;

                        case 'month':

                $day1 = date("Y-m-d", strtotime(' - 30 days'));

                $day2 = date('Y-m-d');

                break;

                case 'year':

                $day1 = date("Y-m-d", strtotime(' - 1 years'));

                $day2 = date('Y-m-d');

                break;



                 case 'custom':

                $day1 = datefordatabase($c1);

                $day2 = datefordatabase($c2);

                break;



            default :

                $day1 = date("Y-m-d", strtotime(' - 30 days'));

                $day2 = date('Y-m-d');

                break;

        }



        $this->db->select_sum('geopos_metadata.col1');

        $this->db->select('geopos_metadata.d_date');

        $this->db->from('geopos_metadata');

        $this->db->group_by('geopos_metadata.d_date');

        $month = date('Y-m');

        $today = date('Y-m-d');

        $this->db->where('DATE(geopos_metadata.d_date) >=', $day1);

        $this->db->where('DATE(geopos_metadata.d_date) <=', $day2);

        $query = $this->db->get();

        $result = $query->result_array();

        return $result;

    }



    public function customerchart($type,$c1='',$c2='')

    {

        switch ($type) {

            case 'week':

                $day1 = date("Y-m-d", strtotime(' - 7 days'));

                $day2 = date('Y-m-d');

                break;

                        case 'month':

                $day1 = date("Y-m-d", strtotime(' - 30 days'));

                $day2 = date('Y-m-d');

                break;

                case 'year':

                $day1 = date("Y-m-d", strtotime(' - 1 years'));

                $day2 = date('Y-m-d');

                break;



                 case 'custom':

                $day1 = datefordatabase($c1);

                $day2 = datefordatabase($c2);

                break;



            default :

                $day1 = date("Y-m-d", strtotime(' - 30 days'));

                $day2 = date('Y-m-d');

                break;

        }

        $this->db->select_sum('geopos_invoices.total');

        $this->db->select('geopos_customers.name');

        $this->db->from('geopos_invoices');

        $this->db->group_by('geopos_invoices.csd');

        $this->db->join('geopos_customers', 'geopos_customers.id = geopos_invoices.csd', 'left');

        $month = date('Y-m');

        $today = date('Y-m-d');

        $this->db->where('DATE(geopos_invoices.invoicedate) >=', $day1);

        $this->db->where('DATE(geopos_invoices.invoicedate) <=', $day2);

        $this->db->order_by('geopos_invoices.total', 'DESC');

        $this->db->limit(100);

        $query = $this->db->get();

        $result = $query->result_array();

        return $result;

    }





            public function incomechart($type,$c1='',$c2='')

    {

        switch ($type) {

            case 'week':

                $day1 = date("Y-m-d", strtotime(' - 7 days'));

                $day2 = date('Y-m-d');

                break;

                        case 'month':

                $day1 = date("Y-m-d", strtotime(' - 30 days'));

                $day2 = date('Y-m-d');

                break;

                case 'year':

                $day1 = date("Y-m-d", strtotime(' - 1 years'));

                $day2 = date('Y-m-d');

                break;



                 case 'custom':

                $day1 = datefordatabase($c1);

                $day2 = datefordatabase($c2);

                break;



            default :

                $day1 = date("Y-m-d", strtotime(' - 30 days'));

                $day2 = date('Y-m-d');

                break;

        }

        $this->db->select_sum('credit');

        $this->db->select('date');

        $this->db->from('geopos_transactions');

        $this->db->group_by('date');

        $month = date('Y-m');

        $today = date('Y-m-d');

        $this->db->where('DATE(date) >=', $day1);

        $this->db->where('DATE(date) <=', $day2);

        $this->db->where('type', 'Income');

        $query = $this->db->get();

        $result = $query->result_array();

        return $result;

    }



       public function expenseschart($type,$c1='',$c2='')

    {

        switch ($type) {

            case 'week':

                $day1 = date("Y-m-d", strtotime(' - 7 days'));

                $day2 = date('Y-m-d');

                break;

                        case 'month':

                $day1 = date("Y-m-d", strtotime(' - 30 days'));

                $day2 = date('Y-m-d');

                break;

                case 'year':

                $day1 = date("Y-m-d", strtotime(' - 1 years'));

                $day2 = date('Y-m-d');

                break;



                 case 'custom':

                $day1 = datefordatabase($c1);

                $day2 = datefordatabase($c2);

                break;



            default :

                $day1 = date("Y-m-d", strtotime(' - 30 days'));

                $day2 = date('Y-m-d');

                break;

        }

        $this->db->select_sum('debit');

        $this->db->select('date');

        $this->db->from('geopos_transactions');

        $this->db->group_by('date');

        $month = date('Y-m');

        $today = date('Y-m-d');

        $this->db->where('DATE(date) >=', $day1);

        $this->db->where('DATE(date) <=', $day2);

        $this->db->where('type', 'Expense');

        $query = $this->db->get();

        $result = $query->result_array();

        return $result;

    }



     public function incexp($type,$c1='',$c2='')

    {

        switch ($type) {

            case 'week':

                $day1 = date("Y-m-d", strtotime(' - 7 days'));

                $day2 = date('Y-m-d');

                break;

                        case 'month':

                $day1 = date("Y-m-d", strtotime(' - 30 days'));

                $day2 = date('Y-m-d');

                break;

                case 'year':

                $day1 = date("Y-m-d", strtotime(' - 1 years'));

                $day2 = date('Y-m-d');

                break;



                 case 'custom':

                $day1 = datefordatabase($c1);

                $day2 = datefordatabase($c2);

                break;



            default :

                $day1 = date("Y-m-d", strtotime(' - 30 days'));

                $day2 = date('Y-m-d');

                break;

        }

          $this->db->select_sum('debit');

        $this->db->select_sum('credit');

        $this->db->select('type');

        $this->db->from('geopos_transactions');

        $this->db->group_by('type');

        $month = date('Y-m');

        $today = date('Y-m-d');

        $this->db->where('DATE(date) >=', $day1);

        $this->db->where('DATE(date) <=', $day2);



        $query = $this->db->get();

        $result = $query->result_array();

        return $result;

    }





}