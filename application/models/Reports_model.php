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



class Reports_model extends CI_Model

{


    var $column_order = array('geopos_products.product_name','geopos_products.product_code','geopos_products.unit');
    var $column_search = array('geopos_products.product_name','geopos_products.product_code','geopos_products.unit');
    var $column_search_izin = array('user_permit.code','geopos_employees.name');
    var $column_search_gider = array('talep_form_customer_products.product_desc','talep_form_customer.code','talep_form_customer_products.total','talep_form_customer_products.price','talep_form_customer.desc');
    var $column_search_malzeme = array('talep_form_products.product_desc','talep_form.code','talep_form.desc','product_stock_code.code');

    var $order = array('geopos_products.pid' => 'desc');

    var $column_order_prd = array('geopos_products.product_name','geopos_products.product_code','geopos_products.unit','geopos_product_cat.title');
    var $column_search_prd = array('geopos_products.product_name','geopos_products.product_code','geopos_products.unit','geopos_product_cat.title');



    var $table_in = 'geopos_invoices';
    var $column_order_in = array('geopos_invoices.invoicedate','geopos_invoices.total','geopos_invoices.payer');
    var $column_search_in = array('geopos_invoices.invoicedate','geopos_invoices.total','geopos_invoices.payer');


    var $column_search_stock = array('geopos_products.product_name','geopos_products.product_code','geopos_products.short_name', 'geopos_product_type.name', 'geopos_warehouse.title');


    var $order_in = array('geopos_invoices.id' => 'desc');

    var $column_search_prim = array('personel_prim.tutar','personel_prim.aciklama','personel_prim_onay.description', 'personel_prim_onay.onaylanan_tutar');

    public function index()

    {

        $query = $this->db->query("SELECT pid,product_name,product_price FROM geopos_products WHERE UPPER(product_name) LIKE '" . strtoupper($name) . "%'");



        $result = $query->result_array();



        return $result;

    }



    public function viewstatement($pay_acc, $trans_type, $sdate, $edate, $ttype)

    {



        if ($trans_type == 'All') {

            $where = "acid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') ";

        } else {

            $where = "acid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') AND type='$trans_type'";

        }

        $this->db->select('*');

        $this->db->from('geopos_transactions');

        $this->db->where($where);

        $this->db->order_by('id', 'DESC');

        $query = $this->db->get();

        $result = $query->result_array();



        return $result;

    }



    public function get_statements($pay_acc, $trans_type, $sdate, $edate)

    {



        if ($trans_type == 'All') {

            $where = "acid='$pay_acc' AND (DATE(invoicedate) BETWEEN '$sdate' AND '$edate') ";

        } else if ($trans_type == 'Expense') {

            $where = "acid='$pay_acc' AND (DATE(invoicedate) BETWEEN '$sdate' AND '$edate') AND (invoice_type_id=3 or invoice_type_id=5 ) ";

        }
        else if ($trans_type == 'Income') {

            $where = "acid='$pay_acc' AND (DATE(invoicedate) BETWEEN '$sdate' AND '$edate') AND (invoice_type_id=4 or invoice_type_id=6 ) ";

        }

        $this->db->select('*');

        $this->db->from('geopos_invoices');
        $this->db->where('invoice_type_id!=',21);

        $this->db->where($where);

                  if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

            $this->db->or_where('loc', 0);

        }



        //  $this->db->order_by('id', 'DESC');

        $query = $this->db->get();

        $result = $query->result_array();

        //echo $this->db->last_query();die();



        return $result;

    }


    public function approve_request($request_id, $user_id) {
        $this->db->where('id', $request_id);
        $query = $this->db->get('requests');
        $request = $query->row();
    
        if ($request) {
            if ($request->approval_status == 0) {
                $this->db->where('id', $request_id);
                $this->db->update('requests', ['approval_status' => 1, 'approved_by' => $user_id]);
    
                $this->db->insert('notifications', [
                    'user_id' => $this->get_second_approver(), 
                    'message' => "Sizin təsdiqiniz gözlənilir! Sorğu ID: " . $request_id,
                    'status' => 0
                ]);
    
                return "Birinci təsdiq edildi, ikinci istifadəçiyə bildiriş göndərildi.";
            } elseif ($request->approval_status == 1) {
                $this->db->where('id', $request_id);
                $this->db->update('requests', ['approval_status' => 2, 'approved_by' => $user_id]);
    
                return "İkinci təsdiq edildi, sorğu tam təsdiq olundu.";
            }
        }
        return "Xəta baş verdi.";
    }
    
    public function get_second_approver() {
        // Burada ikinci təsdiqləyici user-i seç (məsələn, rolu 'manager' olan user)
        $this->db->where('role', 'manager');
        $query = $this->db->get('users');
        $user = $query->row();
        return $user ? $user->id : null;
    }
    





    //income statement





    public function incomestatement()

    {





        $this->db->select_sum('lastbal');

        $this->db->from('geopos_accounts');

            if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

            $this->db->or_where('loc', 0);

        }

        $query = $this->db->get();

        $result = $query->row_array();



        $lastbal = $result['lastbal'];



        $this->db->select_sum('credit');

        $this->db->from('geopos_transactions');

    if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

            $this->db->or_where('loc', 0);

        }

        $this->db->where('type', 'Income');

        $month = date('Y-m');

        $today = date('Y-m-d');

        $this->db->where('DATE(date) >=', "$month-01");

        $this->db->where('DATE(date) <=', $today);



        $query = $this->db->get();

        $result = $query->row_array();



        $motnhbal = $result['credit'];

        return array('lastbal' => $lastbal, 'monthinc' => $motnhbal);



    }



    public function customincomestatement($acid, $sdate, $edate)

    {





        $this->db->select_sum('credit');

        $this->db->from('geopos_transactions');

        if ($acid > 0) {

            $this->db->where('acid', $acid);

        }

            if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

            $this->db->or_where('loc', 0);

        }

        $this->db->where('type', 'Income');

        $this->db->where('DATE(date) >=', $sdate);

        $this->db->where('DATE(date) <=', $edate);

        // $this->db->where("DATE(date) BETWEEN '$sdate' AND '$edate'");

        $query = $this->db->get();

        $result = $query->row_array();



        return $result;

    }



    //expense statement





    public function expensestatement()

    {





        $this->db->select_sum('debit');

        $this->db->from('geopos_transactions');

    if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

            $this->db->or_where('loc', 0);

        }

        $this->db->where('type', 'Expense');

        $month = date('Y-m');

        $today = date('Y-m-d');

        $this->db->where('DATE(date) >=', "$month-01");

        $this->db->where('DATE(date) <=', $today);

    if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

            $this->db->or_where('loc', 0);

        }

        $query = $this->db->get();

        $result = $query->row_array();



        $motnhbal = $result['debit'];

        return array('monthinc' => $motnhbal);



    }



    public function customexpensestatement($acid, $sdate, $edate)

    {





        $this->db->select_sum('debit');

        $this->db->from('geopos_transactions');

        if ($acid > 0) {

            $this->db->where('acid', $acid);

        }

            if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

            $this->db->or_where('loc', 0);

        }

        $this->db->where('type', 'Expense');

        $this->db->where('DATE(date) >=', $sdate);

        $this->db->where('DATE(date) <=', $edate);

        // $this->db->where("DATE(date) BETWEEN '$sdate' AND '$edate'");

        $query = $this->db->get();

        $result = $query->row_array();



        return $result;

    }



    public function statistics($limit = false)

    {

        $this->db->from('geopos_reports');

        // if($limit) $this->db->limit(12);

        $this->db->order_by('id', 'DESC');

        $query = $this->db->get();

        $result = $query->result_array();

        return $result;

    }



    public function get_customer_statements($pay_acc, $trans_type,$para_birimi,$proje_id)

    {





        $para_birimi_post=para_birimi_ogren($para_birimi);



        $this->db->select("geopos_invoice_type.description,geopos_invoices.invoicedate,
          IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
        IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc,
        IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak,
        geopos_invoices.total,
        geopos_invoice_type.transactions,geopos_invoices.para_birimi,geopos_invoices.kur_degeri
        ");

        $this->db->from('geopos_invoices');

        $this->db->join('geopos_invoice_type', 'geopos_invoices.invoice_type_id=geopos_invoice_type.id', 'left');

        $this->db->where('geopos_invoices.csd',$pay_acc);
        if($para_birimi!='tumu')
        {
            $this->db->where('geopos_invoices.para_birimi',$para_birimi_post);
        }

        if($proje_id!=0)
        {
            $this->db->where('geopos_invoices.proje_id',$proje_id);
        }





        //  $this->db->order_by('id', 'DESC');

        $query = $this->db->get();

        $result = $query->result_array();





        return $result;

    }



    public function get_supplier_statements($pay_acc, $trans_type, $sdate, $edate)

    {



        if ($trans_type == 'All') {

            $where = "payerid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') AND ext=1";

        } else {

            $where = "payerid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') AND type='$trans_type' AND ext=1";

        }

        $this->db->select('*');

        $this->db->from('geopos_transactions');

        $this->db->where($where);

            if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

            $this->db->or_where('loc', 0);

        }

        //  $this->db->order_by('id', 'DESC');

        $query = $this->db->get();

        $result = $query->result_array();



        return $result;

    }



    //

     //income statement





    public function profitstatement()

    {









    }



    public function customprofitstatement($lid, $sdate, $edate)

    {





        $this->db->select_sum('geopos_metadata.col1');

        $this->db->from('geopos_metadata');

        $this->db->where('geopos_metadata.type',9);

        $this->db->where('DATE(geopos_metadata.d_date) >=', $sdate);

        $this->db->where('DATE(geopos_metadata.d_date) <=', $edate);

        if($lid>0){

                $this->db->join('geopos_invoices', 'geopos_invoices.id = geopos_metadata.rid', 'left');

                 $this->db->where('geopos_invoices.loc',$lid);

        }



        $query = $this->db->get();

        $result = $query->row_array();



        return $result;

    }



      //sales statement





    public function salesstatement()

    {



    }



    public function customsalesstatement($lid, $sdate, $edate)

    {

        $this->db->select_sum('total');

        $this->db->from('geopos_invoices');

        $this->db->where('DATE(invoicedate) >=', $sdate);

        $this->db->where('DATE(invoicedate) <=', $edate);

        if($lid>0){

                 $this->db->where('loc',$lid);

        }

        $query = $this->db->get();

        $result = $query->row_array();

        return $result;

    }



     //products statement





    public function productsstatement()

    {

        $this->db->select_sum('qty');

         $this->db->select_sum('subtotal');

        $this->db->from('geopos_invoice_items');

        $query = $this->db->get();

        $result = $query->row_array();

        $qty = $result['qty'];

        $subtotal = $result['subtotal'];



       $this->db->select_sum('geopos_invoice_items.qty');

         $this->db->select_sum('geopos_invoice_items.subtotal');

        $this->db->from('geopos_invoice_items');

         $this->db->join('geopos_invoices', 'geopos_invoices.id = geopos_invoice_items.tid', 'left');

        $month = date('Y-m');

        $today = date('Y-m-d');

        $this->db->where('DATE(geopos_invoices.invoicedate) >=', "$month-01");

        $this->db->where('DATE(geopos_invoices.invoicedate) <=', $today);

        $query = $this->db->get();

        $result = $query->row_array();

        $qty_m = $result['qty'];

        $subtotal_m = $result['subtotal'];

        return array('qty' => $qty,'qty_m' => $qty_m, 'subtotal' => $subtotal,'subtotal_m' => $subtotal_m);

    }



    public function customproductsstatement($lid, $sdate, $edate)

    {



             $this->db->select_sum('geopos_invoice_items.qty');

         $this->db->select_sum('geopos_invoice_items.subtotal');

        $this->db->from('geopos_invoice_items');

         $this->db->join('geopos_invoices', 'geopos_invoices.id = geopos_invoice_items.tid', 'left');

         $this->db->where('DATE(geopos_invoices.invoicedate) >=',  $sdate);

        $this->db->where('DATE(geopos_invoices.invoicedate) <=', $edate);

          if($lid>0){

                 $this->db->where('geopos_invoices.loc',$lid);

        }

        $query = $this->db->get();

        $result = $query->row_array();



        return $result;

    }



        public function customproductsstatement_cat($lid, $sdate, $edate)

    {



             $this->db->select_sum('geopos_invoice_items.qty');

         $this->db->select_sum('geopos_invoice_items.subtotal');

        $this->db->from('geopos_invoice_items');

         $this->db->join('geopos_invoices', 'geopos_invoices.id = geopos_invoice_items.tid', 'left');

             $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');

         $this->db->where('DATE(geopos_invoices.invoicedate) >=',  $sdate);

        $this->db->where('DATE(geopos_invoices.invoicedate) <=', $edate);

          if($lid>0){

                 $this->db->where('geopos_products.pid',$lid);

        }

        $query = $this->db->get();

        $result = $query->row_array();

        return $result;

    }



    //fetch data



        public function fetchdata($page)

    {



        switch ($page)

        {

            case 'products' :



                $this->db->select_sum('geopos_invoice_items.qty');

         $this->db->select_sum('geopos_invoice_items.subtotal');

        $this->db->from('geopos_invoice_items');

        $this->db->join('geopos_invoices', 'geopos_invoices.id = geopos_invoice_items.tid', 'left');

             if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);

            $this->db->or_where('geopos_invoices.loc', 0);

        }

        $query = $this->db->get();

        $result = $query->row_array();

        $qty = $result['qty'];

        $subtotal = $result['subtotal'];

       $this->db->select_sum('geopos_invoice_items.qty');

         $this->db->select_sum('geopos_invoice_items.subtotal');

        $this->db->from('geopos_invoice_items');

         $this->db->join('geopos_invoices', 'geopos_invoices.id = geopos_invoice_items.tid', 'left');

              if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);

            $this->db->or_where('geopos_invoices.loc', 0);

        }

        $month = date('Y-m');

        $today = date('Y-m-d');

        $this->db->where('DATE(geopos_invoices.invoicedate) >=', "$month-01");

        $this->db->where('DATE(geopos_invoices.invoicedate) <=', $today);

        $query = $this->db->get();

        $result = $query->row_array();

        $qty_m = $result['qty'];

        $subtotal_m = $result['subtotal'];

        return array('p1' => $qty,'p2' => $qty_m, 'p3' => amountFormat($subtotal),'p4' =>  amountFormat($subtotal_m));

        break;



            case 'sales' :

                     $this->db->select_sum('total');

        $this->db->from('geopos_invoices');

             if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

            $this->db->or_where('loc', 0);

        }

        $query = $this->db->get();

        $result = $query->row_array();

        $lastbal = $result['total'];

        $this->db->select_sum('total');

        $this->db->from('geopos_invoices');

      if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

            $this->db->or_where('loc', 0);

        }

        $month = date('Y-m');

        $today = date('Y-m-d');

        $this->db->where('DATE(invoicedate) >=', "$month-01");

        $this->db->where('DATE(invoicedate) <=', $today);

        $query = $this->db->get();

        $result = $query->row_array();

        $motnhbal = $result['total'];

        return array('p1' => amountFormat($lastbal), 'p2' => amountFormat($motnhbal),'p3' =>0,'p4' =>  0);



        break;



            case 'profit':



      $this->db->select_sum('geopos_metadata.col1');

        $this->db->from('geopos_metadata');

         $this->db->join('geopos_invoices', 'geopos_invoices.id = geopos_metadata.rid', 'left');

        $this->db->where('geopos_metadata.type', 9);

              if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);

            $this->db->or_where('geopos_invoices.loc', 0);

        }

        $query = $this->db->get();

        $result = $query->row_array();



        $lastbal = $result['col1'];



        $this->db->select_sum('geopos_metadata.col1');

        $this->db->from('geopos_metadata');

        $this->db->where('geopos_metadata.type', 9);

        $this->db->join('geopos_invoices', 'geopos_invoices.id = geopos_metadata.rid', 'left');

                  if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);

            $this->db->or_where('geopos_invoices.loc', 0);

        }

        $month = date('Y-m');

        $today = date('Y-m-d');

        $this->db->where('DATE(geopos_metadata.d_date) >=', "$month-01");

        $this->db->where('DATE(geopos_metadata.d_date) <=', $today);

        $query = $this->db->get();

        $result = $query->row_array();

        $motnhbal = $result['col1'];

        return array('p1' => amountFormat($lastbal), 'p2' => amountFormat($motnhbal),'p3' =>0,'p4' =>  0);

        }



    }

    function get_datatables($opt = '')

    {

        $this->_get_datatables_query($opt);

        if ($_POST['length'] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }



        $query = $this->db->get();


        return $query->result();

    }

    private function _get_datatables_query($opt = '')

    {



        $where='geopos_products.product_type=1';

        $this->db->select('geopos_products.pid,geopos_products.product_name,geopos_products.product_code,geopos_products.unit,
        SUM(geopos_product_to_warehouse.qty) as qty');

        $this->db->from('geopos_products');
        $this->db->join('geopos_product_to_warehouse','geopos_products.pid=geopos_product_to_warehouse.product_id','LEFT');

        $this->db->where($where);





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

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

        $this->db->group_by("geopos_product_to_warehouse.product_id");


    }

    function get_datatables_products($opt = '')

    {

        $this->_get_datatables_products($opt);

        if ($_POST['length'] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }



        $query = $this->db->get();


        if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_product_to_warehouse.loc', $this->aauth->get_user()->loc);

        }

        return $query->result();

    }

    private function _get_datatables_products($opt = '')

    {



        $where='geopos_products.product_type!=7';

        $this->db->select('geopos_products.pid,geopos_products.product_name,geopos_products.product_code,geopos_products.unit,
        0 as qty,geopos_product_cat.title');

        $this->db->from('geopos_products');
        //$this->db->join('geopos_product_to_warehouse','geopos_products.pid=geopos_product_to_warehouse.product_id','LEFT');
        $this->db->join('geopos_product_cat', 'geopos_product_cat.id = geopos_products.pcat');

        if ($this->input->post('kat_id')) // if datatable send POST for search
        {
            foreach ($this->input->post('kat_id') as $kt)
            {
                $this->db->or_where('geopos_products.pcat =', $kt); //2019-11-23 14:28:57

            }

        }

        $this->db->where($where);





        $i = 0;



        foreach ($this->column_search_prd as $item) // loop column

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



                if (count($this->column_search_prd) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order_prd[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

        //$this->db->group_by("geopos_product_to_warehouse.product_id");
        $this->db->group_by('geopos_products.pid');


    }


    public function count_all($opt = '')

    {



        $this->db->select('geopos_products.pid,geopos_products.product_name,geopos_products.product_code,geopos_products.unit,
        SUM(geopos_product_to_warehouse.qty) as qty');

        $this->db->from('geopos_products');
        $this->db->join('geopos_product_to_warehouse','geopos_products.pid=geopos_product_to_warehouse.product_id','LEFT');

        $this->db->where('geopos_products.product_type=1');




        if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_product_to_warehouse.loc', $this->aauth->get_user()->loc);

        }

        $this->db->group_by("geopos_product_to_warehouse.product_id");

        return $this->db->count_all_results();

    }

    function count_filtered($opt = '')

    {

        $this->_get_datatables_query($opt);

        if ($opt) {

            $this->db->where('eid', $opt);

        }

        if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_product_to_warehouse.loc', $this->aauth->get_user()->loc);

        }

        $query = $this->db->get();

        return $query->num_rows();

    }


    public function count_all_products($opt = '')

    {



        $this->db->select('geopos_products.pid,geopos_products.product_name,geopos_products.product_code,geopos_products.unit,
        SUM(geopos_product_to_warehouse.qty) as qty,geopos_product_cat.title');

        $this->db->from('geopos_products');
        $this->db->join('geopos_product_to_warehouse','geopos_products.pid=geopos_product_to_warehouse.product_id','LEFT');
        $this->db->join('geopos_product_cat','geopos_products.pcat=geopos_product_cat.id','LEFT');
        $this->db->where('geopos_products.product_type=1');





        $this->db->group_by("geopos_product_to_warehouse.product_id");

        return $this->db->count_all_results();

    }

    function count_filtered_products($opt = '')

    {

        $this->_get_datatables_products($opt);

        if ($opt) {

            $this->db->where('eid', $opt);

        }


        $query = $this->db->get();

        return $query->num_rows();

    }


    function personel_kesintileri($opt = '')

    {

        $this->personel_kesintileri_($opt);

        if ($_POST['length'] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }



        $query = $this->db->get();


        return $query->result_array();

    }

    private function personel_kesintileri_($opt = '')

    {



        $where='geopos_invoices.invoice_type_id=32';

        $this->db->select('*');

        $this->db->from($this->table_in);

        $this->db->where($where);
        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_invoices.invoicedate) >=', datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where('DATE(geopos_invoices.invoicedate) <=', datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
        }



        $i = 0;



        foreach ($this->column_search_in as $item) // loop column

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



                if (count($this->column_search_in) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order_in[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->order_in)) {

            $order = $this->order_in;

            $this->db->order_by(key($order), $order[key($order)]);

        }



    }

    function personel_kesintileri_count_filt($opt = '')

    {

        $this->personel_kesintileri_($opt);


        $query = $this->db->get();

        return $query->num_rows();

    }

   public function prim_onaylari_list($id)

    {
        $this->_prim_onaylari_list($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _prim_onaylari_list($id)

    {


        $this->db->select('personel_prim.*,personel_prim_onay.description ,personel_prim_onay.onaylanan_tutar, personel_prim_onay.personel_prim_id ,personel_prim_onay.id as personel_prim_onay_id,personel_prim_onay.status');
        $this->db->from('personel_prim_onay');
        $this->db->join('personel_prim','personel_prim_onay.personel_prim_id = personel_prim.id');

        $this->db->where('personel_prim_onay.staff_id',$id);

        $i = 0;

        foreach ($this->column_search_prim as $item) // loop column

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

                if (count($this->column_search_prim) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`personel_prim_onay`.`id` DESC');

    }


    public function count_filtered_prim($id)
    {
        $this->_prim_onaylari_list($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_prim($id)
    {
        $this->_prim_onaylari_list($id);
        return $this->db->count_all_results();
    }

    public function personel_izin_raporu()

    {
        $this->_personel_izin_raporu();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

//        echo $this->db->last_query();
//        die();
        return $query->result();

    }

    private function _personel_izin_raporu()
    {

        $date = new DateTime('now');
        $m= $date->format('m');
        $y= $date->format('Y');
        $total_ay_sayisi_ = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);

        if(!$this->input->post('user_name'))
        {
            if(intval($this->input->post('hesap_ay')) >0){
                $m = $this->input->post('hesap_ay');
                $total_ay_sayisi_ = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
            }
            elseif(intval($this->input->post('hesap_ay')) ==-1){
                $m= $date->format('m');
                $total_ay_sayisi_ = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
            }
            if($this->input->post('hesap_yil')){
                $y = $this->input->post('hesap_yil');
            }

            if($this->input->post('hesap_ay') < 0){
                $where1 = "user_permit.end_date BETWEEN '".$y."-01-01 09:00:00' AND '".$y."-12-31 18:00:00'";
                $where2 = "user_permit.start_date BETWEEN '".$y."-01-01 09:00:00' AND '".$y."-12-31 18:00:00'";
            }
            else {
                $where1 = "user_permit.end_date BETWEEN '".$y."-".$m."-01 09:00:00' AND '".$y."-".$m."-".$total_ay_sayisi_." 18:00:00'";
                $where2 = "user_permit.start_date BETWEEN '".$y."-".$m."-01 09:00:00' AND '".$y."-".$m."-".$total_ay_sayisi_." 18:00:00'";


            }

        }

        if(intval($this->input->post('month')) >0){
            $m = $this->input->post('month');
            $total_ay_sayisi_ = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
        }
        if($this->input->post('year')){
            $y = $this->input->post('year');
        }


        if($this->input->post('user_name')){
            $name = $this->input->post('user_name');
            $where1 = "user_permit.end_date BETWEEN '".$y."-".$m."-01 09:00:00' AND '".$y."-".$m."-".$total_ay_sayisi_." 18:00:00'";
            $where2 = "user_permit.start_date BETWEEN '".$y."-".$m."-01 09:00:00' AND '".$y."-".$m."-".$total_ay_sayisi_." 18:00:00'";
        }














        $this->db->select("DATE_FORMAT(user_permit.end_date, '%m') as month,user_permit.code,geopos_employees.name,user_permit.end_date,user_permit.start_date,TIMESTAMPDIFF(HOUR,user_permit.start_date,user_permit.end_date) as toplam_saat,TIMESTAMPDIFF(MINUTE,user_permit.start_date,user_permit.end_date) as toplam_dk");
        $this->db->from('user_permit');
        $this->db->join('geopos_employees','user_permit.user_id=geopos_employees.id');
        $this->db->where($where1);
        $this->db->where($where2);
        $this->db->where('user_permit.status',1);

        $i=0;
        foreach ($this->column_search_izin as $item) // loop column

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

                if (count($this->column_search_izin) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }

        $j=0;
        foreach ($this->column_search_izin as $item) // loop column

        {
            if ($this->input->post('user_name')) // if datatable send POST for search

            {
                if ($j === 0) // first loop

                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, $name);

                } else {

                    $this->db->or_like($item, $name);

                }

                if (count($this->column_search_izin) - 1 == $j) //last loop

                    $this->db->group_end(); //close bracke
            }

            $j++;

        }
        //$this->db->group_by('user_permit.user_id');


    }


    public function count_filtered_personel_izin_raporu()
    {
        $this->_personel_izin_raporu();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_personel_izin_raporu()
    {
        $this->_personel_izin_raporu();
        return $this->db->count_all_results();
    }

    public function gider_raporu(){
        $this->_gider_raporu();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

//        echo $this->db->last_query();
//        die();
        return $query->result();
    }

    private function _gider_raporu(){

        $this->db->select("talep_form_customer_products.*,talep_form_customer.code,talep_form_customer.proje_id,talep_form_customer.status,talep_form_customer.desc");
        $this->db->from('talep_form_customer_products');
        $this->db->join('talep_form_customer','talep_form_customer_products.form_id=talep_form_customer.id');
        $this->db->where('talep_form_customer.type',1);
        $this->db->where('talep_form_customer.status!=10');
        if($this->input->post('proje')){
            $this->db->where('talep_form_customer.proje_id',$this->input->post('proje'));
        }

        $i=0;
        foreach ($this->column_search_gider as $item) // loop column

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

                if (count($this->column_search_gider) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }

    }

    public function count_gider()
    {
        $this->_gider_raporu();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function filtered_gider()
    {
        $this->_gider_raporu();
        return $this->db->count_all_results();
    }



    public function malzeme_raporu(){
        $this->_malzeme_raporu();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

//        echo $this->db->last_query();
//        die();
        return $query->result();
    }

    private function _malzeme_raporu(){

        $this->db->select("talep_form_products.*,talep_form.code,talep_form.proje_id,talep_form.status,talep_form.desc,talep_form.talep_type");
        $this->db->from('talep_form_products');
        $this->db->join('talep_form','talep_form_products.form_id=talep_form.id');
        $this->db->join('product_stock_code','talep_form_products.product_stock_code_id=product_stock_code.id','LEFT');
        //$this->db->where('talep_form.status!=10');
        if($this->input->post('cari_id')){
            $this->db->join('siparis_list_form_new','talep_form_products.id=siparis_list_form_new.talep_form_product_id','LEFT');
            $this->db->join('siparis_list_form','siparis_list_form.id=siparis_list_form_new.siparis_liste_form_id','LEFT');
            $this->db->where('siparis_list_form.cari_id',$this->input->post('cari_id'));



        }

        if($this->input->post('proje')){
            $this->db->where('talep_form.proje_id',$this->input->post('proje'));
        }
        if($this->input->post('status_id')){
            $this->db->where('talep_form.status',$this->input->post('status_id'));
        }

        $i=0;
        foreach ($this->column_search_malzeme as $item) // loop column

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

                if (count($this->column_search_malzeme) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }

    }

    public function count_malzeme()
    {
        $this->_malzeme_raporu();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function filtered_malzeme()
    {
        $this->_malzeme_raporu();
        return $this->db->count_all_results();
    }



    public function ajax_list_stok_raporu(){
        $this->_ajax_list_stok_raporu();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

//        echo $this->db->last_query();
//        die();
        return $query->result();
    }

    private function _ajax_list_stok_raporu(){

        $this->db->select("geopos_products.pid,geopos_product_cat.title as category_name, geopos_products.product_name, geopos_products.product_code, geopos_products.short_name, geopos_products.product_type, geopos_product_type.name as type_name");
        $this->db->from('geopos_products');
        $this->db->join('geopos_product_type','geopos_products.product_type=geopos_product_type.id ');
        $this->db->join('stock','geopos_products.pid = stock.product_id ');
        $this->db->join('geopos_product_cat', 'geopos_products.pcat=geopos_product_cat.id','LEFT');
//        $this->db->join('geopos_warehouse','stock.warehouse_id=geopos_warehouse.id ');
        $this->db->where('geopos_products.status',1);
        //$this->db->where('talep_form.status!=10');
        if($this->input->post('category_id')){
            $this->db->where('geopos_products.pcat',$this->input->post('category_id'));
        }
        if($this->input->post('warehouse_id')){
            $this->db->where('stock.warehouse_id',$this->input->post('warehouse_id'));
        }

        $i=0;
        foreach ($this->column_search_stock as $item) // loop column

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

                if (count($this->column_search_stock) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }

        $this->db->group_by("stock.product_id");

    }

    public function count_stok()
    {
        $this->_ajax_list_stok_raporu();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function filtered_stok()
    {
        $this->_ajax_list_stok_raporu();
        return $this->db->count_all_results();
    }
    public function countkasa()
    {
        $user_id =  $this->aauth->get_user()->id;
        $this->db->select('v.*');
        $this->db->from('virman_onay');
        $this->db->join('virman v','virman_onay.virman_id = v.id');
        $this->db->where('virman_onay.user_id',$user_id);
        $this->db->where('virman_onay.staff',1);
        $this->db->where('virman_onay.status is null');
        if($this->session->userdata('set_firma_id')){
            $this->db->where('v.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $query = $this->db->get();
        $count =  $query->num_rows();


        return [
            'status'=>1,
            'count'=>$count
        ];
    }

    public function maascount()
    {
        $this->db->select('new_bordro.*');
        $this->db->from('salary_onay_new');
        $this->db->join('new_bordro_item','salary_onay_new.bordro_item_id = new_bordro_item.id');
        $this->db->join('new_bordro','new_bordro_item.bordro_id = new_bordro.id');
        $this->db->where('new_bordro_item.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        $this->db->where('salary_onay_new.staff', 1);
        $this->db->where('salary_onay_new.user_id', $this->aauth->get_user()->id);
        $this->db->where_not_in('new_bordro_item.status',[4,3]);
        $query = $this->db->get();
        $count =  $query->num_rows();

        return [
            'status'=>1,
            'count'=>$count
        ];

    }

    public function bekleyenmaascount()
    {
        $count=0;

        $this->db->select('
        IF(new_bordro_pay_set.banka_durum=1,new_bordro_item.bankadan_odenilecek,0) as bankadan_odenilecek,
        IF(new_bordro_pay_set.nakit_durum=1,new_bordro_item.nakit_odenilecek,0) as nakit_odenilecek,
        new_bordro_pay_set.banka_durum,
        new_bordro_pay_set.nakit_durum,
        new_bordro_pay_set.id,
        new_bordro_item.id as item_id,
        ,geopos_employees.name as pers_name,new_bordro_item.bordro_yili,new_bordro_item.bordro_ayi');
        $this->db->from('new_bordro_pay_set');
        $this->db->join('new_bordro_item','new_bordro_pay_set.bordro_item_id=new_bordro_item.id');
        $this->db->join('geopos_employees','new_bordro_item.pers_id=geopos_employees.id');
        $this->db->where('new_bordro_pay_set.pay_set_id =', $this->aauth->get_user()->id);
        $this->db->where('new_bordro_pay_set.transaction_id=',0);
        $this->db->where_not_in('new_bordro_item.status',[4,3]);
        $query = $this->db->get();
        $count  =  $query->num_rows();

        return [
            'status'=>1,
            'count'=>$count
        ];

    }

    public function onay_qaime_list()
    {

        $this->db->select('*');
        $this->db->from('invoices_onay_new');
        $this->db->join('geopos_invoices','geopos_invoices.id=invoices_onay_new.invoices_id');
        $this->db->where('invoices_onay_new.staff', 1);
        $this->db->where('invoices_onay_new.user_id', $this->aauth->get_user()->id);
        $this->db->where('invoices_onay_new.status is null');
        $this->db->where('invoices_onay_new.type',1);
        $this->db->where_not_in('geopos_invoices.status',[3]);

        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_invoices.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $query = $this->db->get();
        $count  =  $query->num_rows();

        return [
            'status'=>1,
            'count'=>$count
        ];


    }

    public function bekleyenprimcount()
    {
        $count=0;
        $id = $this->aauth->get_user()->id;
        $salart_details = $this->db->query("SELECT * FROM `personel_prim_onay` Where staff_id= $id and  is_staff= 1 and status=0");
        if($salart_details->num_rows()>0){
            $count =$salart_details->num_rows();

        }
        else {
            $count = 0;
        }

        return [
            'status'=>1,
            'count'=>$count
        ];

    }

    public function cikispers()
    {
        $employess_where='';
        if($this->session->userdata('set_firma_id')){
            $employess_where.='and geopos_employees.loc='.$this->session->userdata('set_firma_id');
            //$this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $count=0;
        $salart_details = $this->db->query("SELECT * FROM `personel_salary` INNER JOIN geopos_users ON personel_salary.personel_id = geopos_users.id INNER JOIN geopos_employees ON personel_salary.personel_id=geopos_employees.id WHERE geopos_users.banned=0 and personel_salary.is_cikis_date and personel_salary.status=1 $employess_where;");
        if($salart_details->num_rows()>0){
            $count =$salart_details->num_rows();

        }
        else {
            $count = 0;
        }

        return [
            'status'=>1,
            'count'=>$count
        ];


    }

    public function forma2_new_count()
    {

        $aauth_id =  $this->aauth->get_user()->id;
        $where_invoices=' and geopos_invoices.loc='.$this->session->userdata('set_firma_id');
        $forma_2_count = $this->db->query("SELECT * FROM `invoices_onay_new` 
INNER JOIN geopos_invoices On invoices_onay_new.invoices_id=geopos_invoices.id
WHERE invoices_onay_new.type = 2 AND  geopos_invoices.status=1 and invoices_onay_new.user_id = $aauth_id AND `staff` = 1 $where_invoices")->num_rows();

        return [
            'status'=>1,
            'count'=>$forma_2_count
        ];


    }




}



