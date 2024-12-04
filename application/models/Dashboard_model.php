<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function todayInvoice($today)
    {
        $where = "DATE(create_date) ='$today'";
        $this->db->where($where);
        $this->db->from('geopos_invoices');

        $type=array(1,2);
        $this->db->where_in('invoice_type_id', $type);
        return $this->db->count_all_results();

    }

    public function today_gider($today)
    {
        $where = "DATE(create_date) ='$today'";
        $this->db->select("SUM(total) as total");
        $this->db->where($where);
        $this->db->from('geopos_invoices');

        $type=array(3,18);
        $this->db->where_in('invoice_type_id', $type);
        $query = $this->db->get();
        return $query->row()->total;

    }


    public function today_gelir($today)
    {
        $where = "DATE(create_date) ='$today'";
        $this->db->select("SUM(total) as total");
        $this->db->where($where);
        $this->db->from('geopos_invoices');

        $type=array(4,17);
        $this->db->where_in('invoice_type_id', $type);
        $query = $this->db->get();
        return $query->row()->total;


    }
    public function today_kdv_odemesi($today)
    {
        $where = "DATE(create_date) ='$today'";
        $this->db->where($where);
        $this->db->select("SUM(total) as total");
        $this->db->from('geopos_invoices');

        $type=array(19);
        $this->db->where_in('invoice_type_id', $type);
        $query = $this->db->get();
        return $query->row()->total;

    }
    public function today_kdv_tahsilati($today)
    {
        $where = "DATE(create_date) ='$today'";
        $this->db->select("SUM(total) as total");
        $this->db->where($where);
        $this->db->from('geopos_invoices');

        $type=array(20);
        $this->db->where_in('invoice_type_id', $type);
        $query = $this->db->get();
        return $query->row()->total;

    }

    public function todaySales($today)
    {

        $where = "DATE(create_date) ='$today'";
        $this->db->select('(total*kur_degeri) as totals');
        $this->db->from('geopos_invoices');
        $this->db->where($where);
        $type=array(2);
        $this->db->where_in('invoice_type_id', $type);
        $query = $this->db->get();
        $q=$query->result_array();
        $totals=0;
     foreach ($q as $ss )
     {
         $totals+=$ss['totals'];
     }
     return $totals;
    }

    public function todayInexp($today)
    {
        $this->db->select('SUM(debit) as debit,SUM(credit) as credit', FALSE);
        $this->db->where("DATE(date) ='$today'");
        $this->db->where("type!='Transfer'");
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $this->db->from('geopos_transactions');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function recent_payments()
    {
        $this->db->limit(13);
        $this->db->order_by('id', 'DESC');
        $this->db->from('geopos_invoices');
        $type=array(3,4,12,14,17,18,19,20,25,27,28,33);
        $this->db->where_in('invoice_type_id', $type);
        $this->db->order_by('`geopos_invoices`.`id` DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    public function stock()
    {

        $query = $this->db->query("SELECT geopos_products.pid,geopos_products.unit,geopos_products.product_name,geopos_product_to_warehouse.qty,geopos_warehouse.title FROM geopos_products INNER JOIN geopos_product_to_warehouse On geopos_product_to_warehouse.product_id=geopos_products.pid INNER JOIN geopos_warehouse ON geopos_warehouse.id=geopos_product_to_warehouse.warehouse_id WHERE geopos_products.product_type=1 and geopos_product_to_warehouse.qty<=geopos_products.alert GROUP BY geopos_product_to_warehouse.warehouse_id LIMIT 7");
        return $query->result_array();
    }

    public function todayItems($today)
    {
        $where = "DATE(invoicedate) ='$today'";
        $this->db->select_sum('items');
        $this->db->from('geopos_invoices');
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('loc', 0);
        }
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row()->items;
    }

    public function todayProfit($today)
    {
        $where = "DATE(geopos_metadata.d_date) ='$today'";
        $this->db->select_sum('geopos_metadata.col1');
        $this->db->from('geopos_metadata');
        $this->db->join('geopos_invoices', 'geopos_metadata.rid=geopos_invoices.id', 'left');
        $this->db->where($where);
        $this->db->where('geopos_metadata.type', 9);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);
        } elseif (!BDATA) {
            $this->db->where('geopos_invoices.loc', 0);
        }
        $query = $this->db->get();
        return $query->row()->col1;
    }

    public function incomeChart($today, $month, $year)
    {

        $date = new DateTime('now');
        $start =  $date->format('Y-m-01 00:00:00');
        $end =  $date->format('Y-m-t 00:00:00');

        $this->db->select('IF( SUM(total*kur_degeri), SUM(total*kur_degeri) ,0) as totals');
        $this->db->from('geopos_invoices');
        $this->db->where('DATE(invoicedate) >=', $start); //2019-11-23 14:28:57
        $this->db->where('DATE(invoicedate) <=', $end);  //2019-11-24 14:28:57
        $type=array(4,48,44,18);
        $this->db->where_in('invoice_type_id', $type);
        $query = $this->db->get();
        return $query->row()->totals;
    }

    public function expenseChart($today, $month, $year)
    {


        $date = new DateTime('now');
        $start =  $date->format('Y-m-01 00:00:00');
        $end =  $date->format('Y-m-t 00:00:00');

        $this->db->select('IF( SUM(total*kur_degeri), SUM(total*kur_degeri) ,0) as totals');
        $this->db->from('geopos_invoices');
//        $this->db->where($where);
        $this->db->where('DATE(invoicedate) >=', $start); //2019-11-23 14:28:57
        $this->db->where('DATE(invoicedate) <=', $end);  //2019-11-24 14:28:57
        $type=array(3,46,59,57,49,45,43,33,12,14,17);
        $this->db->where_in('invoice_type_id', $type);
        $query = $this->db->get();
        return $query->row()->totals;


    }

    public function countmonthlyChart()
    {
        $today = date('Y-m-d');
        $whr = '';
        $whr = "and  invoice_type_id IN(17,4)";
        $query = $this->db->query("SELECT COUNT(id) AS ttlid,SUM(total) AS total,DATE(invoicedate) as date FROM geopos_invoices WHERE (DATE(invoicedate) BETWEEN '$today' - INTERVAL 30 DAY AND '$today')  $whr GROUP BY DATE(invoicedate) ORDER BY date DESC");
        return $query->result_array();
    }


    public function monthlyInvoice($month, $year)
    {

        $where = "DATE(create_date) BETWEEN '$year-$month-01' AND '$year-$month-31'";
        $this->db->where($where);
        $this->db->from('geopos_invoices');
        $type=array(1,2);
        $this->db->where_in('invoice_type_id', $type);
        return $this->db->count_all_results();

    }

    public function monthlySales($month, $year)
    {




        $where = "DATE(create_date) BETWEEN '$year-$month-01' AND '$year-$month-31'";
        $this->db->select('(total*kur_degeri) as totals');
        $this->db->from('geopos_invoices');
        $this->db->where($where);
        $type=array(2);
        $this->db->where_in('invoice_type_id', $type);
        $query = $this->db->get();
        $q=$query->result_array();
        $totals=0;
        foreach ($q as $ss )
        {
            $totals+=$ss['totals'];
        }
        return $totals;
    }

    public function aylik_kdv_odemesi($month, $year)
    {



        $date = new DateTime('now');
        $start =  $date->format('Y-m-01 00:00:00');
        $end =  $date->format('Y-m-t 00:00:00');
        $this->db->select('IF( SUM(total), SUM(total) ,0) as totals');
        $this->db->from('geopos_invoices');
        $this->db->where('DATE(invoicedate) >=', $start); //2019-11-23 14:28:57
        $this->db->where('DATE(invoicedate) <=', $end);  //2019-11-24 14:28:57
        $type=array(19,47);
        $this->db->where_in('invoice_type_id', $type);
        $query = $this->db->get();
        $q=$query->row()->totals;
        return $q;
    }


    public function aylik_kdv_tahsilati($month, $year)
    {




        $date = new DateTime('now');

        $start =  $date->format('Y-m-01 00:00:00');
        $end =  $date->format('Y-m-t 00:00:00');

        $this->db->select('IF( SUM(total*kur_degeri), SUM(total*kur_degeri) ,0) as totals');
        $this->db->from('geopos_invoices');
//        $this->db->where($where);
        $this->db->where('DATE(invoicedate) >=', $start); //2019-11-23 14:28:57
        $this->db->where('DATE(invoicedate) <=', $end);  //2019-11-24 14:28:57
        $type=array(20,48);
        $this->db->where_in('invoice_type_id', $type);
        $query = $this->db->get();
        $q=$query->row()->totals;
        return $q;
    }


    public function recentInvoices()
    {

        $query = $this->db->query("SELECT i.invoice_no,i.id,i.tid,i.invoicedate,i.total,i.kur_degeri,i.status,i.i_class,c.name,c.picture,i.csd
FROM geopos_invoices AS i LEFT JOIN geopos_customers AS c ON i.csd=c.id WHERE i.invoice_type_id = 2 ORDER BY i.id DESC LIMIT 10");
        return $query->result_array();

    }

    public function recentBuyers()
    {
        $this->db->trans_start();
        $whr = '';

        $whr.=' WHERE i.invoice_type_id IN (17)';
        $query = $this->db->query("SELECT i.id AS iid,i.kur_degeri,i.csd,SUM(i.total) AS total, c.cid,MAX(c.picture) as picture ,MAX(c.name) as name,MAX(i.status) as status FROM geopos_invoices AS i LEFT JOIN (SELECT geopos_customers.id AS cid, geopos_customers.picture AS picture, geopos_customers.name AS name FROM geopos_customers) AS c ON c.cid=i.csd $whr GROUP BY i.csd ORDER BY iid DESC LIMIT 5;");
        $result= $query->result_array();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            return 'sql';
        }
        else
        {
            return $result;
        }

    }

    public function tasks($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_todolist');
        $this->db->where('eid', $id);
        $this->db->limit(10);
        $this->db->order_by('DATE(duedate)', 'ASC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function teklif_emp($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_quotes');
        $this->db->join('geopos_customers','geopos_quotes.csd=geopos_customers.id','left');
        $this->db->where('geopos_quotes.eid', $id);
        $this->db->limit(10);
        $this->db->order_by('DATE(geopos_quotes.invoicedate)', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    public function purchase_emp($id)
    {
        $this->db->select('geopos_purchase.*,geopos_customers.company as name');
        $this->db->from('geopos_purchase');
        $this->db->join('geopos_customers','geopos_purchase.csd=geopos_customers.id','left');
        $this->db->where('geopos_purchase.eid', $id);
        $this->db->limit(10);
        $this->db->order_by('DATE(geopos_purchase.invoicedate)', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function clockin($id)
    {
        $this->db->select('clock');
        $this->db->where('id', $id);
        $this->db->from('geopos_employees');
        $query = $this->db->get();
        $emp = $query->row_array();
        if (!$emp['clock']) {
            $data = array(
                'clock' => 1,
                'clockin' => time(),
                'clockout' => 0
            );
            $this->db->set($data);
            $this->db->where('id', $id);
            $this->db->update('geopos_employees');
            $this->aauth->applog("[Employee ClockIn]  ID $id", $this->aauth->get_user()->username);
        }
        return true;
    }

    public function clockout($id)
    {

        $this->db->select('clock,clockin');
        $this->db->where('id', $id);
        $this->db->from('geopos_employees');
        $query = $this->db->get();
        $emp = $query->row_array();

        if ($emp['clock']) {

            $data = array(
                'clock' => 0,
                'clockin' => 0,
                'clockout' => time()
            );

            $total_time = time() - $emp['clockin'];


            $this->db->set($data);
            $this->db->where('id', $id);

            $this->db->update('geopos_employees');
            $this->aauth->applog("[Employee ClockOut]  ID $id", $this->aauth->get_user()->username);

            $today = date('Y-m-d');

            $this->db->select('id,adate');
            $this->db->where('emp', $id);
            $this->db->where('DATE(adate)', date('Y-m-d'));
            $this->db->from('geopos_attendance');
            $query = $this->db->get();
            $edate = $query->row_array();
            if ($edate['adate']) {


                $this->db->set('actual_hours', "actual_hours+$total_time", FALSE);
                $this->db->set('tto', date('H:i:s'));
                $this->db->where('id', $edate['id']);
                $this->db->update('geopos_attendance');


            } else {
                $data = array(
                    'emp' => $id,
                    'adate' => date('Y-m-d'),
                    'tfrom' => gmdate("H:i:s", $emp['clockin']),
                    'tto' => date('H:i:s'),
                    'note' => 'Self Attendance',
                    'actual_hours' => $total_time
                );


                $this->db->insert('geopos_attendance', $data);
            }

        }
        return true;
    }


}
