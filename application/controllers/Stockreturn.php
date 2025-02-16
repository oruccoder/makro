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



class Stockreturn extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->model('Stockreturn_model', 'stockreturn');

        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }



        if (!$this->aauth->premission(2)) {



            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');



        }



    }



    //create invoice

    public function create()

    {

        $this->load->library("Common");

         $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));

        $this->load->model('customers_model', 'customers');

        $data['customergrouplist'] = $this->customers->group_list();

        $data['lastinvoice'] = $this->stockreturn->lastpurchase();

        $data['terms'] = $this->stockreturn->billingterms();

        $head['title'] = "New Stock return";

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['warehouse'] = $this->stockreturn->warehouses();

        $data['taxdetails'] = $this->common->taxdetail();

        $this->load->view('fixed/header', $head);

        $this->load->view('stockreturn/newinvoice', $data);

        $this->load->view('fixed/footer');

    }



        public function create_client()

    {

        $this->load->library("Common");

         $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));

        $this->load->model('customers_model', 'customers');

        $data['customergrouplist'] = $this->customers->group_list();

        $data['lastinvoice'] = $this->stockreturn->lastpurchase();

        $data['terms'] = $this->stockreturn->billingterms();

        $head['title'] = "New Stock return";

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['warehouse'] = $this->stockreturn->warehouses();

        $data['taxdetails'] = $this->common->taxdetail();

        $this->load->view('fixed/header', $head);

        $this->load->view('stockreturn/c_newinvoice', $data);

        $this->load->view('fixed/footer');

    }



        public function create_note()

    {

        $this->load->library("Common");

         $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));

        $this->load->model('customers_model', 'customers');

        $data['customergrouplist'] = $this->customers->group_list();

        $data['lastinvoice'] = $this->stockreturn->lastpurchase();

        $data['terms'] = $this->stockreturn->billingterms();

        $head['title'] = "New Credit Note";

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['warehouse'] = $this->stockreturn->warehouses();

        $data['taxdetails'] = $this->common->taxdetail();

        $this->load->view('fixed/header', $head);

        $this->load->view('stockreturn/note_newinvoice', $data);

        $this->load->view('fixed/footer');

    }



    //edit invoice

    public function edit()

    {



        $tid = intval($this->input->get('id'));

        $data['id'] = $tid;

        $data['title'] = "Stock return Order $tid";

        $this->load->model('customers_model', 'customers');

        $data['customergrouplist'] = $this->customers->group_list();

        $data['terms'] = $this->stockreturn->billingterms();

        $data['invoice'] = $this->stockreturn->purchase_details($tid);

        $data['products'] = $this->stockreturn->purchase_products($tid);;

        $head['title'] = "Edit Invoice #$tid";

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['warehouse'] = $this->stockreturn->warehouses();

$this->load->library("Common");

         $data['taxlist'] = $this->common->taxlist_edit($data['invoice']['taxstatus']);

        $this->load->view('fixed/header', $head);

        $this->load->view('stockreturn/edit', $data);

        $this->load->view('fixed/footer');



    }



        public function edit_c()

    {



        $tid = intval($this->input->get('id'));

        $data['id'] = $tid;

        $data['title'] = "Stock return Order $tid";

        $this->load->model('customers_model', 'customers');

        $data['customergrouplist'] = $this->customers->group_list();

        $data['terms'] = $this->stockreturn->billingterms();

        $data['invoice'] = $this->stockreturn->purchase_details($tid);

        $data['products'] = $this->stockreturn->purchase_products($tid);;

        $head['title'] = "Edit Invoice #$tid";

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['warehouse'] = $this->stockreturn->warehouses();

$this->load->library("Common");

         $data['taxlist'] = $this->common->taxlist_edit($data['invoice']['taxstatus']);

        $this->load->view('fixed/header', $head);

        $this->load->view('stockreturn/c_edit', $data);

        $this->load->view('fixed/footer');



    }



            public function edit_note()

    {



        $tid = intval($this->input->get('id'));

        $data['id'] = $tid;

        $data['title'] = "Stock return Order $tid";

        $this->load->model('customers_model', 'customers');

        $data['customergrouplist'] = $this->customers->group_list();

        $data['terms'] = $this->stockreturn->billingterms();

        $data['invoice'] = $this->stockreturn->purchase_details($tid);

        $data['products'] = $this->stockreturn->purchase_products($tid);;

        $head['title'] = "Edit Invoice #$tid";

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['warehouse'] = $this->stockreturn->warehouses();

$this->load->library("Common");

         $data['taxlist'] = $this->common->taxlist_edit($data['invoice']['taxstatus']);

        $this->load->view('fixed/header', $head);

        $this->load->view('stockreturn/note_edit', $data);

        $this->load->view('fixed/footer');



    }



    //invoices list

    public function index()

    {

        $head['title'] = "Manage Stockreturn Orders";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('stockreturn/invoices');

        $this->load->view('fixed/footer');

    }



     public function customer()

    {

        $head['title'] = "Manage Stockreturn Orders";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('stockreturn/invoices_client');

        $this->load->view('fixed/footer');

    }



       public function creditnotes()

    {

        $head['title'] = "Manage Credit Notes";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('stockreturn/creditnotes_client');

        $this->load->view('fixed/footer');

    }







    //action

    public function action()

    {



        $customer_id = $this->input->post('customer_id');

        $person_type = $this->input->post('person_type');

        $new_u='create';

        if($person_type) $new_u='create_client';

        $invocieno = $this->input->post('invocieno');

        $invoicedate = $this->input->post('invoicedate');

        $invocieduedate = $this->input->post('invocieduedate');

        $notes = $this->input->post('notes',true);

        $tax = $this->input->post('tax_handle');

        $subtotal = $this->input->post('subtotal');

        $ship_taxtype = $this->input->post('ship_taxtype');

        $shipping = $this->input->post('shipping');

        $shipping_tax = $this->input->post('ship_tax');

         if($ship_taxtype=='incl') $shipping=$shipping-$shipping_tax;

        $refer = $this->input->post('refer',true);

        $total = $this->input->post('total');

        $total_tax = 0;

        $total_discount = 0;

        $discountFormat = $this->input->post('discountFormat');

        $pterms = $this->input->post('pterms');

        $i = 0;

        if ($discountFormat == '0') {

            $discstatus = 0;

        } else {

            $discstatus = 1;

        }



        if ($customer_id == 0) {

            echo json_encode(array('status' => 'Error', 'message' =>

                "Please add a new person or search from a previous added!"));

            exit;

        }

        $this->db->trans_start();

        //products





        $transok = true;





        //Invoice Data

        $bill_date = datefordatabase($invoicedate);

        $bill_due_date = datefordatabase($invocieduedate);

        $data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype,'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'eid' => $this->aauth->get_user()->id, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'loc' => $this->aauth->get_user()->loc,'i_class'=>$person_type);

        if ($this->db->insert('geopos_stock_r', $data)) {

            $invocieno = $this->db->insert_id();

            $pid = $this->input->post('pid');

            $productlist = array();

            $prodindex = 0;

            $itc = 0;

            foreach ($pid as $key => $value) {

                $product_id = $this->input->post('pid');

                $product_name1 = $this->input->post('product_name',true);

                $product_qty = $this->input->post('product_qty');

                $product_price = $this->input->post('product_price');

                $product_tax = $this->input->post('product_tax');

                $product_discount = $this->input->post('product_discount');

                $product_subtotal = $this->input->post('product_subtotal');

                $ptotal_tax = $this->input->post('taxa');

                $ptotal_disc = $this->input->post('disca');

                $total_discount += $ptotal_disc[$key];

                $total_tax += $ptotal_tax[$key];

                $product_des = $this->input->post('product_description',true);

                $product_unit = $this->input->post('unit');

                $product_hsn = $this->input->post('hsn');

                $data = array(

                    'tid' => $invocieno,

                    'pid' => $product_id[$key],

                    'product' => $product_name1[$key],

                    'code' => $product_hsn[$key],

                    'qty' => $product_qty[$key],

                    'price' => $product_price[$key],

                    'tax' => $product_tax[$key],

                    'discount' => $product_discount[$key],

                    'subtotal' => $product_subtotal[$key],

                    'totaltax' => $ptotal_tax[$key],

                    'totaldiscount' => $ptotal_disc[$key],

                    'product_des' => $product_des[$key],

                    'unit' => $product_unit[$key]

                );

                $productlist[$prodindex] = $data;

                $i++;

                $prodindex++;

                $amt = intval($product_qty[$key]);

                if ($product_id[$key] > 0) {

                    if ($this->input->post('update_stock') == 'yes') {



                        $this->db->set('qty', "qty-$amt", FALSE);

                        $this->db->where('pid', $product_id[$key]);

                        $this->db->update('geopos_products');

                    }

                    $itc += $amt;

                }

            }



            if ($prodindex > 0) {

                $this->db->insert_batch('geopos_stock_r_items', $productlist);

                $this->db->set(array('discount' => $total_discount, 'tax' => $total_tax, 'items' => $itc));

                $this->db->where('id', $invocieno);

                $this->db->update('geopos_stock_r');

            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "Please choose product from product list. Go to Item manager section if you have not added the products."));

                $transok = false;

            }



            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('Stock order success') . "<a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . " </a>   <a href='".$new_u."' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a>"));

        } else {

            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

            $transok = false;

        }





        if ($transok) {

            $this->db->trans_complete();

        } else {

            $this->db->trans_rollback();

        }





    }





    public function ajax_list()

    {

 $no = $this->input->post('start');

        $type = $this->input->get('t');

        $list = $this->stockreturn->get_datatables($type);

        $data = array();





        foreach ($list as $invoices) {

            $no++;

            $row = array();

            $row[] = $no;

            $row[] = $invoices->tid;

            $row[] = $invoices->name;

            $row[] = dateformat($invoices->invoicedate);

            $row[] = amountFormat($invoices->total);

            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';

            $row[] = '<a href="' . base_url("stockreturn/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("stockreturn/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="icon-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object"><span class="icon-trash"></span></a>';



            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->stockreturn->count_all(),

            "recordsFiltered" => $this->stockreturn->count_filtered(),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }



    public function view()

    {

        $this->load->model('accounts_model');

        $data['acclist'] = $this->accounts_model->accountslist();

        $tid = intval($this->input->get('id'));

        $data['id'] = $tid;

        $head['title'] = "Stock return $tid";

        $data['invoice'] = $this->stockreturn->purchase_details($tid);

        $data['products'] = $this->stockreturn->purchase_products($tid);

        $data['activity'] = $this->stockreturn->purchase_transactions($tid);

        $data['attach'] = $this->stockreturn->attach($tid);

        $data['employee'] = $this->stockreturn->employee($data['invoice']['eid']);

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        if($data['invoice']) $this->load->view('stockreturn/view', $data);

        $this->load->view('fixed/footer');



    }





    public function printinvoice()

    {



        $tid = $this->input->get('id');

        $ty = $this->input->get('ty');



        $data['id'] = $tid;

        $data['title'] = "Stock Return $tid";

        $data['invoice'] = $this->stockreturn->purchase_details($tid);

        $data['products'] = $this->stockreturn->purchase_products($tid);

        $data['employee'] = $this->stockreturn->employee($data['invoice']['eid']);

          $this->load->library('pdf');





        ini_set('memory_limit', '64M');

        if($ty<2){

            $html = $this->load->view('stockreturn/view-print', $data, true);

             $pdf = $this->pdf->load();

        }

        else{

             $header = $this->load->view('stockreturn/header-print-' . LTR, $data, true);

             $html = $this->load->view('stockreturn/view-print-' . LTR, $data, true);

            $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        }





        //PDF Rendering





        $pdf->SetHTMLFooter('<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #959595; font-weight: bold; font-style: italic;"><tr><td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td><td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td><td width="33%" style="text-align: right; ">#' . $tid . '</td></tr></table>');



        $pdf->WriteHTML($html);



          $file_name = preg_replace( '/[^A-Za-z0-9]+/', '-', 'Credit_note__'.$data['invoice']['name'].'_'. $data['invoice']['tid']);

        if ($this->input->get('d')) {



            $pdf->Output($file_name. '.pdf', 'D');

        } else {

            $pdf->Output($file_name . '.pdf', 'I');

        }





    }



    public function delete_i()

    {

        echo json_encode(array('status' => 'Success', 'message' =>

            $this->lang->line('DELETED') . ' This action is disabled in demo.'));





    }



    public function editaction()

    {

        $customer_id = $this->input->post('customer_id');

        $person_type = $this->input->post('person_type');

        $invocieno = $this->input->post('iid');

        $invoicedate = $this->input->post('invoicedate');

        $invocieduedate = $this->input->post('invocieduedate');

        $notes = $this->input->post('notes',true);

        $tax = $this->input->post('tax_handle');

        $subtotal = $this->input->post('subtotal');



        $refer = $this->input->post('refer');

        $total = $this->input->post('total');

        $ship_taxtype = $this->input->post('ship_taxtype');

        $shipping = $this->input->post('shipping');

        $shipping_tax = $this->input->post('ship_tax');

         if($ship_taxtype=='incl') $shipping=$shipping-$shipping_tax;

        $total_tax = 0;

        $total_discount = 0;

        $discountFormat = $this->input->post('discountFormat');

        $pterms = $this->input->post('pterms');

        $i = 0;

        if ($discountFormat == '0') {

            $discstatus = 0;

        } else {

            $discstatus = 1;

        }

        if ($customer_id == 0) {

            echo json_encode(array('status' => 'Error', 'message' =>

                "Please add a new supplier or search from a previous added!"));

            exit;

        }

        $this->db->trans_start();

        $flag = false;

        $transok = true;





        //Product Data

        $pid = $this->input->post('pid');

        $productlist = array();



        $prodindex = 0;



        $this->db->delete('geopos_stock_r_items', array('tid' => $invocieno));





        foreach ($pid as $key => $value) {



            $product_id = $this->input->post('pid');

            $product_name1 = $this->input->post('product_name',true);

            $product_qty = $this->input->post('product_qty');

            $old_product_qty = $this->input->post('old_product_qty');

            if ($old_product_qty == '') $old_product_qty = 0;

            $product_price = $this->input->post('product_price');

            $product_tax = $this->input->post('product_tax');

            $product_discount = $this->input->post('product_discount');

            $product_subtotal = $this->input->post('product_subtotal');

            $ptotal_tax = $this->input->post('taxa');

            $ptotal_disc = $this->input->post('disca');

            $total_discount += $ptotal_disc[$key];

            $total_tax += $ptotal_tax[$key];

            $product_des = $this->input->post('product_description',true);

            $product_unit = $this->input->post('unit');

            $product_hsn = $this->input->post('hsn');



            $data = array(

                'tid' => $invocieno,

                'pid' => $product_id[$key],

                'product' => $product_name1[$key],

                'code' => $product_hsn[$key],

                'qty' => $product_qty[$key],

                'price' => $product_price[$key],

                'tax' => $product_tax[$key],

                'discount' => $product_discount[$key],

                'subtotal' => $product_subtotal[$key],

                'totaltax' => $ptotal_tax[$key],

                'totaldiscount' => $ptotal_disc[$key],

                'product_des' => $product_des[$key],

                'unit' => $product_unit[$key]

            );





            $productlist[$prodindex] = $data;

            $i++;

            $prodindex++;



            if ($this->input->post('update_stock') == 'yes') {

                $amt = intval($product_qty[$key]) - @intval($old_product_qty[$key]);

                $this->db->set('qty', "qty-$amt", FALSE);

                $this->db->where('pid', $product_id[$key]);

                $this->db->update('geopos_products');

            }

            $flag = true;



        }





        $bill_date = datefordatabase($invoicedate);

        $bill_due_date = datefordatabase($invocieduedate);



        $data = array('invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping,'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'discount' => $total_discount, 'tax' => $total_tax, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'items' => $i, 'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms,'i_class'=>$person_type);

        $this->db->set($data);

        $this->db->where('id', $invocieno);



        if ($flag) {



            if ($this->db->update('geopos_stock_r', $data)) {

                $this->db->insert_batch('geopos_stock_r_items', $productlist);

                echo json_encode(array('status' => 'Success', 'message' =>

                    "Stock return order has  been updated successfully! <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> View </a> "));

            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "There is a missing field!"));

                $transok = false;

            }





        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                "Please add atleast one product in order!"));

            $transok = false;

        }



        if ($this->input->post('update_stock') == 'yes') {

            if ($this->input->post('restock')) {

                foreach ($this->input->post('restock') as $key => $value) {





                    $myArray = explode('-', $value);

                    $prid = $myArray[0];

                    $dqty = $myArray[1];

                    if ($prid > 0) {



                        $this->db->set('qty', "qty-$dqty", FALSE);

                        $this->db->where('pid', $prid);

                        $this->db->update('geopos_products');

                    }

                }





            }

        }





        if ($transok) {

            $this->db->trans_complete();

        } else {

            $this->db->trans_rollback();

        }

    }



    public function update_status()

    {

        $tid = $this->input->post('tid');

        $status = $this->input->post('status');





        $this->db->set('status', $status);

        $this->db->where('id', $tid);

        $this->db->update('geopos_stock_r');



        echo json_encode(array('status' => 'Success', 'message' =>

            'Stock return Order Status updated successfully!', 'pstatus' => $status));

    }



    public function file_handling()

    {

        if ($this->input->get('op')) {

            $name = $this->input->get('name');

            $invoice = $this->input->get('invoice');

            if ($this->stockreturn->meta_delete($invoice, 5, $name)) {

                echo json_encode(array('status' => 'Success'));

            }

        } else {

            $id = $this->input->get('id');

            $this->load->library("Uploadhandler_generic", array(

                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'

            ));

            $files = (string)$this->uploadhandler_generic->filenaam();

            if ($files != '') {



                $this->stockreturn->meta_insert($id, 5, $files);

            }

        }





    }





    public function cancelorder()

    {



        if ($this->aauth->get_user()->roleid < 3) {



            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');



        }



        $tid = intval($this->input->post('tid'));





        $this->db->set('pamnt', "0.00", FALSE);

        $this->db->set('status', 'canceled');

        $this->db->where('id', $tid);

        $this->db->update('geopos_stock_r');

        //reverse

        $this->db->select('credit,acid');

        $this->db->from('geopos_transactions');

        $this->db->where('tid', $tid);

        $this->db->where('ext', 6);

        $query = $this->db->get();

        $revresult = $query->result_array();

        foreach ($revresult as $trans) {

            $amt = $trans['credit'];

            $this->db->set('lastbal', "lastbal-$amt", FALSE);

            $this->db->where('id', $trans['acid']);

            $this->db->update('geopos_accounts');

        }

        $this->db->select('pid,qty');

        $this->db->from('geopos_stock_r_items');

        $this->db->where('tid', $tid);

        $query = $this->db->get();

        $prevresult = $query->result_array();

        foreach ($prevresult as $prd) {

            $amt = $prd['qty'];

            $this->db->set('qty', "qty+$amt", FALSE);

            $this->db->where('pid', $prd['pid']);

            $this->db->update('geopos_products');

        }

        $this->db->delete('geopos_transactions', array('tid' => $tid, 'ext' => 6));

        echo json_encode(array('status' => 'Success', 'message' =>

            $this->lang->line('Return canceled')));

    }





    public function pay()

    {



        if ($this->aauth->get_user()->roleid < 3) {



            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');



        }



        $tid = intval($this->input->post('tid'));

        $amount = $this->input->post('amount');

        $paydate = $this->input->post('paydate');

        $note = $this->input->post('shortnote',true);

        $pmethod = $this->input->post('pmethod');

        $acid = $this->input->post('account');

        $cid = $this->input->post('cid');

        $cname = $this->input->post('cname',true);

        $paydate = datefordatabase($paydate);



        $this->db->select('holder');

        $this->db->from('geopos_accounts');

        $this->db->where('id', $acid);

        $query = $this->db->get();

        $account = $query->row_array();



        $data = array(

            'acid' => $acid,

            'account' => $account['holder'],

            'type' => 'Income',

            'cat' => 'Purchase',

            'credit' => $amount,

            'payer' => $cname,

            'payerid' => $cid,

            'method' => $pmethod,

            'date' => $paydate,

            'eid' => $this->aauth->get_user()->id,

            'tid' => $tid,

            'note' => $note,

            'ext' => 6

        );



        $this->db->insert('geopos_transactions', $data);

        $this->db->insert_id();



        $this->db->select('total,csd,pamnt');

        $this->db->from('geopos_stock_r');

        $this->db->where('id', $tid);

        $query = $this->db->get();

        $invresult = $query->row();



        $totalrm = $invresult->total - $invresult->pamnt;



        if ($totalrm > $amount) {

            $this->db->set('pmethod', $pmethod);

            $this->db->set('pamnt', "pamnt+$amount", FALSE);



            $this->db->set('status', 'partial');

            $this->db->where('id', $tid);

            $this->db->update('geopos_stock_r');





            //account update

            $this->db->set('lastbal', "lastbal-$amount", FALSE);

            $this->db->where('id', $acid);

            $this->db->update('geopos_accounts');

            $paid_amount = $invresult->pamnt + $amount;

            $status = 'Partial';

            $totalrm = $totalrm - $amount;

        } else {

            $this->db->set('pmethod', $pmethod);

            $this->db->set('pamnt', "pamnt+$amount", FALSE);

            $this->db->set('status', 'accepted');

            $this->db->where('id', $tid);

            $this->db->update('geopos_stock_r');

            //acount update

            $this->db->set('lastbal', "lastbal-$amount", FALSE);

            $this->db->where('id', $acid);

            $this->db->update('geopos_accounts');



            $totalrm = 0;

            $status = 'Accepted';

            $paid_amount = $amount;





        }





        $activitym = "<tr><td>" . substr($paydate, 0, 10) . "</td><td>$pmethod</td><td>$amount</td><td>$note</td></tr>";





        echo json_encode(array('status' => 'Success', 'message' =>

            $this->lang->line('Transaction has been added'), 'pstatus' => $this->lang->line($status), 'activity' => $activitym, 'amt' => $totalrm, 'ttlpaid' => $paid_amount));

    }





}