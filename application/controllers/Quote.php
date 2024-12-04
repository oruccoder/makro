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



class Quote extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->model('quote_model', 'quote');

        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }

             if (!$this->aauth->premission(9)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }



    }



    //create invoice

    public function create()

    {

        $this->load->library("Common");

         $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));

        $this->load->model('customers_model', 'customers');

        $this->load->model('plugins_model', 'plugins');

        $data['exchange'] = $this->plugins->universal_api(5);

        $data['currency'] = $this->quote->currencies();

        $data['projeler'] = $this->quote->projeler();

        $data['customergrouplist'] = $this->customers->group_list();

        $data['lastinvoice'] = $this->quote->lastquote();

        $data['terms'] = $this->quote->billingterms();

        $head['title'] = "Yeni Teklif";

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['warehouse'] = $this->quote->warehouses();

        $data['taxdetails'] = $this->common->taxdetail();

        $this->load->view('fixed/header', $head);

        $this->load->view('quotes/newquote', $data);

        $this->load->view('fixed/footer');

    }



    //edit invoice

    public function edit()

    {

        $this->load->model('customers_model', 'customers');

        $data['projeler'] = $this->quote->projeler();

        $data['customergrouplist'] = $this->customers->group_list();

        $tid = intval($this->input->get('id'));

        $data['id'] = $tid;

        $data['terms'] = $this->quote->billingterms();

        $data['invoice'] = $this->quote->quote_details($tid);

        $data['products'] = $this->quote->quote_products($tid);

        $data['currency'] = $this->quote->currencies();

        $head['title'] = "Teklif Düzenle #" . $data['invoice']['tid'];

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['warehouse'] = $this->quote->warehouses();

        $this->load->model('plugins_model', 'plugins');

        $data['exchange'] = $this->plugins->universal_api(5);

        $this->load->library("Common");

         $data['taxlist'] = $this->common->taxlist_edit($data['invoice']['taxstatus']);

        $this->load->view('fixed/header', $head);

        $this->load->view('quotes/edit', $data);

        $this->load->view('fixed/footer');

    }



    //invoices list

    public function index()

    {

        $head['title'] = "Teklif Listesi";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('quotes/quotes');

        $this->load->view('fixed/footer');

    }





    //action

    public function action()

    {



        $customer_id = $this->input->post('customer_id');

        $invocieno = $this->input->post('invocieno');

        $invoicedate = $this->input->post('invoicedate');

        $invocieduedate = $this->input->post('invocieduedate');

        $notes = $this->input->post('notes',true);

        $tax = $this->input->post('tax_handle');

        $subtotal = $this->input->post('subtotal');

          $ship_taxtype = $this->input->post('ship_taxtype');

        $shipping = $this->input->post('shipping');

        $shipping_tax = $this->input->post('ship_tax');



        $refer = $this->input->post('refer');

        $total = $this->input->post('total');

        $proposal = $this->input->post('propos');

        $total_tax = 0;

        $total_discount = 0;

        $discountFormat = $this->input->post('discount_format');

        $pterms = $this->input->post('pterms');

        $currency = $this->input->post('mcurrency');
        $proje_id = $this->input->post('proje_id');
        $warehouses = $this->input->post('warehouses');
        $discount_rate = $this->input->post('discount_rate');
        $teslimat = $this->input->post('teslimat');

        $i = 0;

        if ($discountFormat == '0') {

            $discstatus = 0;

        } else {

            $discstatus = 1;

        }



        if ($customer_id == 0) {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('Please add a new client')));

            exit;

        }

        $this->db->trans_start();

        //products

        $transok = true;

        //Invoice Data

        $bill_date = datefordatabase($invoicedate);

        $bill_due_date = datefordatabase($invocieduedate);

        $data = array('tid' => $invocieno,
            'invoicedate' => $bill_date,
            'invoiceduedate' => $bill_due_date,
            'subtotal' => $subtotal,
            'proje_id' => $proje_id,
            'shipping' => $shipping,
            'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype,
            'discount' => $total_discount, 'tax' => $total_tax, 'total' => $total,
            'notes' => $notes, 'csd' => $customer_id, 'eid' => $this->aauth->get_user()->id,
            'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat,
            'refer' => $refer, 'term' => $pterms, 'proposal' => $proposal, 'multi' => $currency,
            'loc' => $this->aauth->get_user()->loc,
            'warehouses'=>$warehouses,
            'discount_rate'=>$discount_rate,
            'teslimat'=>$teslimat
            );

        if ($this->db->insert('geopos_quotes', $data)) {

            $pid = $this->input->post('pid');

            $invocieno = $this->db->insert_id();

            $productlist = array();

            $prodindex = 0;

            $itc = 0;

            $flag = false;

            foreach ($pid as $key => $value) {



                $product_id = $this->input->post('pid');
                $unit = product_unit($product_id[$key]);

                $product_name1 = $this->input->post('product_name',true);

                $product_qty = $this->input->post('product_qty');

                $product_price = $this->input->post('product_price');

                $product_tax = $this->input->post('product_tax');

                $product_discount = $this->input->post('product_discount');

                $product_subtotal = $this->input->post('product_subtotal');

                $ptotal_tax = $this->input->post('taxa');

                $ptotal_disc = $this->input->post('disca');

                $product_des = $this->input->post('product_description',true);

                $product_hsn = $this->input->post('hsn');

                $total_discount += $ptotal_disc[$key];

                $total_tax += $ptotal_tax[$key];



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

                    'unit' => $unit

                );



                $flag = true;

                $productlist[$prodindex] = $data;

                $i++;

                $prodindex++;





                $amt = intval($product_qty[$key]);



                $itc += $amt;



            }



            if ($prodindex > 0) {

                $this->db->insert_batch('geopos_quotes_items', $productlist);



                $this->db->set(array('discount' => $total_discount, 'tax' => $total_tax, 'items' => $itc));

                $this->db->where('id', $invocieno);

                $this->db->update('geopos_quotes');

            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "Please choose product from product list. Go to Item manager section if you have not added the products."));

                $transok = false;

            }



            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('Quote has  been created') .
                " <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='fa fa-eye' aria-hidden='true'>

</span> Görüntüle </a> &nbsp; &nbsp;<a href='create' class='btn btn-amber btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span> " . $this->lang->line('Create') . "  </a>"));
        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

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



        $list = $this->quote->get_datatables();

        $data = array();



        $no = $this->input->post('start');





        foreach ($list as $invoices) {

            $no++;

            $row = array();

            $row[] = $no;
            $row[] = dateformat($invoices->invoicedate);


            $row[] = '<a href="' . base_url("quote/view?id=$invoices->id") . '" class="btn btn-blue btn-sm">'.$invoices->tid.'</a>';

            $row[] = '<a href="' . base_url("customers/view?id=$invoices->customer_id") . '" class="btn btn-blue btn-sm">'.$invoices->company.'</a>';



            $row[] = amountFormat($invoices->total);

            $row[] = '<span class="badge st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = $invoices->name;

            $row[] = '<a href="' . base_url("quote/view?id=$invoices->id") . '" class="btn btn-blue btn-sm"><i class="fa fa-eye"></i></a> &nbsp; <a href="' . base_url("quote/printquote?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>&nbsp;<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';



            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->quote->count_all(),

            "recordsFiltered" => $this->quote->count_filtered(),

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



        $data['invoice'] = $this->quote->quote_details($tid);

        $data['products'] = $this->quote->quote_products($tid);

        $data['attach'] = $this->quote->attach($tid);





        $data['employee'] = $this->quote->employee($data['invoice']['eid']);

        $head['title'] = "Teklif #" . $data['invoice']['tid'];

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        if( $data['invoice'])$this->load->view('quotes/view', $data);

        $this->load->view('fixed/footer');



    }





    public function printquote()

    {



        $tid = intval($this->input->get('id'));



        $data['id'] = $tid;

        $data['title'] = "Quote $tid";

        $data['invoice'] = $this->quote->quote_details($tid);

        $data['products'] = $this->quote->quote_products($tid);

        $data['employee'] = $this->quote->employee($data['invoice']['eid']);



        ini_set('memory_limit', '64M');

        if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {

            $html = $this->load->view('quotes/view-print-gstin', $data, true);

        } else {

            $html = $this->load->view('quotes/view-print-' . LTR, $data, true);

        }

        $header = $this->load->view('quotes/header-print-' . LTR, $data, true);

        //PDF Rendering





        $this->load->library('pdf');



        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');


        $pdf->AddPage(
            '', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            95, // margin top
            5, // margin bottom
            0,5,0,0, // margin header
            0,70,0,0); // margin footer


        $pdf->WriteHTML($html);



        $file_name = preg_replace( '/[^A-Za-z0-9]+/', '-', 'Teklif__'.$data['invoice']['name'].'_'. $data['invoice']['tid']);

        if ($this->input->get('d')) {



            $pdf->Output($file_name. '.pdf', 'D');

        } else {

            $pdf->Output($file_name . '.pdf', 'I');

        }





    }



    public function delete_i()

    {

        $id = $this->input->post('deleteid');

        if ($this->quote->quote_delete($id)) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('DELETED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }

    }



    public function editaction()

    {



        $customer_id = $this->input->post('customer_id');



        $invocieno_n = $this->input->post('invocieno');

        $invocieno = $this->input->post('iid');

        $invoicedate = $this->input->post('invoicedate');

        $invocieduedate = $this->input->post('invocieduedate');

        $notes = $this->input->post('notes',true);

        $tax = $this->input->post('tax_handle');

        $subtotal = $this->input->post('subtotal');

        $shipping = $this->input->post('shipping');

        $refer = $this->input->post('refer',true);

        $total = $this->input->post('total');

        $total_tax = 0;

        $total_discount = 0;

        $discountFormat = $this->input->post('discount_format');

        $pterms = $this->input->post('pterms');

        $propos = $this->input->post('propos');

        $currency = $this->input->post('mcurrency');



        $ship_taxtype = $this->input->post('ship_taxtype');

        $shipping = $this->input->post('shipping');

        $shipping_tax = $this->input->post('ship_tax');
        $warehouses = $this->input->post('warehouses');
        $discount_rate = $this->input->post('discount_rate');
        $quo_teslimat = $this->input->post('teslimat');

         if($ship_taxtype=='incl') $shipping=$shipping-$shipping_tax;



        $i = 0;

        if ($discountFormat == '0') {

            $discstatus = 0;

        } else {

            $discstatus = 1;

        }



        if ($customer_id == 0) {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('Please add a new client')));

            exit;





        }





        $this->db->trans_start();

        $flag = false;

        $transok = true;





        //Product Data

        $pid = $this->input->post('pid');

        $productlist = array();



        $prodindex = 0;



        $this->db->delete('geopos_quotes_items', array('tid' => $invocieno));



        foreach ($pid as $key => $value) {

            $product_id = $this->input->post('pid');

            $unit = product_unit($product_id[$key]);

            $product_name1 = $this->input->post('product_name',true);

            $product_qty = $this->input->post('product_qty');

            $product_price = $this->input->post('product_price');

            $product_tax = $this->input->post('product_tax');

            $product_discount = $this->input->post('product_discount');

            $product_subtotal = $this->input->post('product_subtotal');

            $ptotal_tax = $this->input->post('taxa');

            $ptotal_disc = $this->input->post('disca');

            $product_des = $this->input->post('product_description',true);

            $product_hsn = $this->input->post('hsn');

            $total_discount += $ptotal_disc[$key];

            $total_tax += $ptotal_tax[$key];



            $data = array(

                'tid' => $invocieno,

                'pid' => $product_id[$key],

                'product' => $product_name1[$key],

                'code' => $product_hsn[$key],

                'qty' => $product_qty[$key],

                'price' => $product_price[$key],

                'tax' => $product_tax[$key],

                'discount' => isset($product_discount[$key])?$product_discount[$key]:0,

                'subtotal' => $product_subtotal[$key],

                'totaltax' => $ptotal_tax[$key],

                'totaldiscount' => $ptotal_disc[$key],

                'product_des' => $product_des[$key],
                'unit' =>$unit

            );



            $flag = true;

            $productlist[$prodindex] = $data;

            $i++;

            $prodindex++;

        }





        $bill_date = datefordatabase($invoicedate);

        $bill_due_date = datefordatabase($invocieduedate);



        $data = array('invoicedate' => $bill_date,
            'invoiceduedate' => $bill_due_date,
            'subtotal' => $subtotal,'shipping' => $shipping,
            'ship_tax' => $shipping_tax, 'ship_tax_type' => $ship_taxtype,
            'discount' => $total_discount, 'tax' => $total_tax, 'total' => $total,
            'notes' => $notes, 'csd' => $customer_id, 'items' => $i,
            'taxstatus' => $tax, 'discstatus' => $discstatus, 'format_discount' => $discountFormat,
            'refer' => $refer, 'term' => $pterms, 'proposal' => $propos, 'multi' => $currency,
            'warehouses'=>$warehouses,
            'discount_rate'=>$discount_rate,
            'teslimat'=>$quo_teslimat
        );

        $this->db->set($data);

        $this->db->where('id', $invocieno);



        if ($flag) {



            if ($this->db->update('geopos_quotes', $data)) {

                $this->db->insert_batch('geopos_quotes_items', $productlist);

                echo json_encode(array('status' => 'Success', 'message' =>

                    $this->lang->line('Quote has  been updated') . " <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> Görüntüle </a> "));

            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    $this->lang->line('ERROR')));

                $transok = false;

            }





        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                "Please add atleast one product in invoice $invocieno"));

            $transok = false;

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

        $this->db->update('geopos_quotes');



        echo json_encode(array('status' => 'Success', 'message' =>

            $this->lang->line('Quote Status updated') . '', 'pstatus' => $status));

    }



    public function convert()

    {

        $tid = $this->input->post('tid');





        if ($this->quote->convert($tid)) {



            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('Quote to invoice conversion')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }

    }



    public function file_handling()

    {

        if ($this->input->get('op')) {

            $name = $this->input->get('name');

            $invoice = $this->input->get('invoice');

            if ($this->quote->meta_delete($invoice, 2, $name)) {

                echo json_encode(array('status' => 'Success'));

            }

        } else {

            $id = $this->input->get('id');

            $this->load->library("Uploadhandler_generic", array(

                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'

            ));

            $files = (string)$this->uploadhandler_generic->filenaam();

            if ($files != '') {

                $fid = rand(100, 9999);

                $this->quote->meta_insert($id, 2, $files);

            }

        }





    }





}