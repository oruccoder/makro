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



class Purchase extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->model('purchase_model', 'purchase');
        $this->load->model('tools_model', 'tools');
        $this->load->model('communication_model');

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
        $this->load->model('products_model', 'products');

        $user_id = $this->input->get('user_id');

        if($user_id)
        {
            $data['products']=$this->products->cart_details($user_id);
            $data['user_id_cart']=$user_id;

        }
        else
            {
                $data['products']=0;
                $data['user_id_cart']=0;
            }

        $data['emp'] = $this->purchase->employees();
        $data['projeler'] = $this->purchase->projeler();
        $this->load->library("Common");

        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));

        $this->load->model('plugins_model', 'plugins');

        $data['exchange'] = $this->plugins->universal_api(5);

        $data['currency'] = $this->purchase->currencies();

        $this->load->model('customers_model', 'customers');

        $data['customergrouplist'] = $this->customers->group_list();

        $data['lastinvoice'] = $this->purchase->lastpurchase();

        $data['terms'] = $this->purchase->billingterms();

        $head['title'] = "Yeni Sipariş";

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['warehouse'] = $this->purchase->warehouses();

        $data['taxdetails'] = $this->common->taxdetail();

        $this->load->view('fixed/header', $head);

        $this->load->view('purchase/newinvoice', $data);

        $this->load->view('fixed/footer');

    }



    //edit invoice

    public function edit()

    {



        $tid = $this->input->get('id');

        $data['id'] = $tid;

        $data['title'] = "Sipariş Düzenle $tid";

        $this->load->model('customers_model', 'customers');

        $data['customergrouplist'] = $this->customers->group_list();

        $data['terms'] = $this->purchase->billingterms();

        $data['invoice'] = $this->purchase->purchase_details($tid);
        $data['emp'] = $this->purchase->employees();

        $data['products'] = $this->purchase->purchase_products($tid);;

        $head['title'] = "Sipariş Düzenleme #$tid";

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['warehouse'] = $this->purchase->warehouses();

          $data['currency'] = $this->purchase->currencies();

          $this->load->model('plugins_model', 'plugins');

        $data['exchange'] = $this->plugins->universal_api(5);

$this->load->library("Common");

         $data['taxlist'] = $this->common->taxlist_edit($data['invoice']['taxstatus']);

        $this->load->view('fixed/header', $head);

        $this->load->view('purchase/edit', $data);

        $this->load->view('fixed/footer');



    }



    //invoices list

    public function index()

    {

        $head['title'] = "Sipariş Listesi";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('purchase/invoices');

        $this->load->view('fixed/footer');

    }



    //action

    public function action()

    {


        $customer_id_cart = $this->input->post('customer_id_cart');



        $customer_id = $this->input->post('customer_id');
        $proje_id = $this->input->post('proje_id');
        $personel_id = $this->input->post('personel_id');


        $invocieno = $this->input->post('invocieno');

        $invoicedate = $this->input->post('invoicedate');

        $invocieduedate = $this->input->post('invocieduedate');

        $notes = $this->input->post('notes',true);

        $tax = $this->input->post('tax_handle');

        $subtotal = $this->input->post('subtotal');

        $ship_taxtype = $this->input->post('ship_taxtype');

        $shipping = $this->input->post('shipping');

        $shipping_tax = $this->input->post('ship_tax');



        $refer = $this->input->post('refer',true);

        $total = $this->input->post('total');

        $total_tax = 0;

        $total_discount = 0;

        $discountFormat = $this->input->post('discountFormat');

        $pterms = $this->input->post('pterms');
        $status = $this->input->post('status');
        $depo = $this->input->post('warehouses');

        $currency = $this->input->post('mcurrency');
        //proje bilgileri

        $project_name = $this->input->post('project_name');
        $project_adresi = $this->input->post('project_adresi');
        $project_sehir = $this->input->post('project_sehir');
        $project_yetkli_no = $this->input->post('project_yetkli_no');
        $proje_yetkili_adi = $this->input->post('proje_yetkili_adi');

        //proje bilgileri

        //şöför bilgileri
        $plaka_no = $this->input->post('plaka_no');
        $sofor_name = $this->input->post('sofor_name');
        $sofor_tel = $this->input->post('sofor_tel');
        //şöför bilgileri

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

        //products





        $transok = true;





        //Invoice Data

        $bill_date = datefordatabase($invoicedate);

        $bill_due_date = datefordatabase($invocieduedate);

        $order_no=$invocieno;


        $data = array(
            'tid' => $invocieno,
            'invoicedate' => $bill_date,
            'invoiceduedate' => $bill_due_date,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'ship_tax' => $shipping_tax,
            'ship_tax_type' => $ship_taxtype,
            'total' => $total,
            'notes' => $notes,
            'csd' => $customer_id,
            'eid' => $this->aauth->get_user()->id,
            'taxstatus' => $tax,
            'discstatus' => $discstatus,
            'format_discount' => $discountFormat,
            'refer' => $refer,
            'term' => $pterms,
            'proje_id' => $proje_id,
            'personel_id' => $personel_id,
            'proje_adi' => $project_name,
            'proje_adresi' => $project_adresi,
            'proje_sehir' => $project_sehir,
            'proje_tel' => $project_yetkli_no,
            'proje_yetkili_adi' => $proje_yetkili_adi,
            'plaka_no' => $plaka_no,
            'sofor_name' => $sofor_name,
            'sofor_tel' => $sofor_tel,
            'status' => $status,
            'depo_id' => $depo,
            'loc' => $this->aauth->get_user()->loc,
            'multi' => $currency);





        if ($this->db->insert('geopos_purchase', $data)) {

            $invocieno = $this->db->insert_id();

            if($personel_id!=0)
            {
                $name =  'Sipariş İçin Stok Çıkış Emri';

                $status = 1;

                $priority = 'High';

                $stdate ='';

                $tdate ='';

                $employee = $personel_id;

                $href="<a href='/sayim/create?purchase_id=$invocieno'>Sayıma Başla</a>";


                if($proje_id!=0)
                {
                    $proje_name=proje_name($proje_id);
                    $content = 'Sipariş için stok çıkış işlemi gerekli. '.$proje_name.' isimli Proje İçin, '.$order_no.' ID Sipariş Oluşturuldu.Sipariş Emri Size Atandı!'.$href;


                }
                else
                    {
                        $content = 'Sipariş için stok çıkış işlemi gerekli.'.$order_no.' ID Sipariş Oluşturuldu.Sipariş Emri Size Atandı!'.$href;

                    }



                $assign = $this->aauth->get_user()->id;


                $this->tools->addtask_purchase($name, $status, $priority, $employee, $assign, $content,$invocieno);
            }



            $pid = $this->input->post('pid');

            $productlist = array();
            $data_quantity_prd=array();
            $data_quantity=array();

            $prodindex = 0;

            $itc = 0;

            $flag = false;





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


                if($product_id[$key]!=0) {

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

                        'unit' => $product_unit[$key],
                        'rulo_miktari' =>rulo_hesapla($product_id[$key],$product_qty[$key]),

                    );

                    $flag = true;

                    $productlist[$prodindex] = $data;

                    $i++;

                    $prodindex++;

                    $amt = $product_qty[$key];



                }









                if ($product_id[$key] > 0) {

                   //Eğer Ürün Miktarı Yetersiz İse Satış Pazarlamadaki Personellere Mail gönderme

                    $stok_kontrol=siparis_eksik_stok($product_id[$key],$amt);

                    if(isset($stok_kontrol))

                    $data_quantity[]=array(
                        'product_name'=>product_name($stok_kontrol['product_id']),
                        'eksik_tutar'=>$stok_kontrol['eksik_miktar']
                    );

                   //Eğer Ürün Miktarı Yetersiz İse Satış Pazarlamadaki Personellere Mail gönderme

                    $itc += $amt;

                }

                $data_quantity_prd[$prodindex] = $data_quantity;



            }




            if($data_quantity)
            {

                $this->eksik_raporu_gonder($data_quantity,$invocieno);

            }





            if ($prodindex > 0) {

                $this->db->insert_batch('geopos_purchase_items', $productlist);

                $this->db->set(array('discount' => $total_discount, 'tax' => $total_tax, 'items' => $itc));

                $this->db->where('id', $invocieno);

                $this->db->update('geopos_purchase');



            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "Please choose product from product list. Go to Item manager section if you have not added the products."));

                $transok = false;

            }





            if($customer_id_cart!=0)
            {
                $this->purchase->cart_delete($customer_id_cart);
            }
            $product_details = $this->purchase->purchase_products($invocieno);


            $this->stock_update($status, $depo,$product_details,1,$invocieno);
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Purchase order success') . "<a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span>" . $this->lang->line('View') . " </a>"));

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



        $list = $this->purchase->get_datatables();

        $data = array();



        $no = $this->input->post('start');



        foreach ($list as $invoices) {

            $no++;

            $row = array();

            $row[] = $no;

            $row[] = $invoices->tid;

            $row[] = $invoices->name;

            $row[] = dateformat($invoices->invoicedate);

            $row[] = amountFormat($invoices->total);

            $row[] = purchase_status($invoices->status);

            $row[] = '<a href="' . base_url("purchase/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("purchase/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object"><span class="fa fa-trash"></span></a>';


            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->purchase->count_all(),

            "recordsFiltered" => $this->purchase->count_filtered(),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }

    public function convert_to_invoice()
    {
        $this->load->model('invoices_model','invoice');

        $tid = $this->input->post('tid');
        $data=array();

        $data['order']=$this->purchase->purchase_details($tid);
        $data['order_details']=$this->purchase->purchase_products($tid);

        $notes = $this->input->post('notes');

        $this->invoice->convert_to_invoice($data,$notes);

        $this->db->set(array('convert_to_invoice' => 1));

        $this->db->where('id', $tid);

        $this->db->update('geopos_purchase');




    }



    public function view()

    {

        $this->load->model('accounts_model');

        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);

        $tid = intval($this->input->get('id'));

        $data['id'] = $tid;

        $head['title'] = "Sipariş $tid";

        $data['invoice'] = $this->purchase->purchase_details($tid);
        $data['onaylayan_personel'] = personel_details( $data['invoice']['onaylayan_user_id']);
        $data['sayim_yapan_user'] = personel_details( $data['invoice']['personel_id']);
        $data['onay_durumu'] =$data['invoice']['onay_durumu'];
        $data['proje_name'] =proje_name($data['invoice']['proje_id']);

        $data['products'] = $this->purchase->purchase_products($tid);

        $data['rulo_miktari'] = rulo_miktari_sorgula($tid,'purchase');

        $data['activity'] = $this->purchase->purchase_transactions($tid);

        $data['attach'] = $this->purchase->attach($tid);

        $data['employee'] = $this->purchase->employee($data['invoice']['eid']);

        $head['usernm'] = $this->aauth->get_user()->username;

        $user_id = $this->aauth->get_user()->id;

        $data['gorev_durumu']=$this->purchase->gorev_durumu($tid,$user_id);

        $this->load->view('fixed/header', $head);

        if($data['invoice']) $this->load->view('purchase/view', $data);

        $this->load->view('fixed/footer');



    }





    public function printinvoice()

    {



        $tid = $this->input->get('id');



        $data['id'] = $tid;

        $data['title'] = "Purchase $tid";

        $data['invoice'] = $this->purchase->purchase_details($tid);

        $data['products'] = $this->purchase->purchase_products($tid);

        $data['employee'] = $this->purchase->employee($data['invoice']['eid']);

        $data['invoice']['multi'] = 0;



        ini_set('memory_limit', '64M');





        //PDF Rendering





        if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {

            $html = $this->load->view('purchase/view-print-gstin', $data, true);

        } else {

            $html = $this->load->view('purchase/view-print-' . LTR, $data, true);

        }

        $header = $this->load->view('purchase/header-print-' . LTR, $data, true);

        //PDF Rendering

        $this->load->library('pdf');



        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');



        $pdf->WriteHTML($html);



        if ($this->input->get('d')) {



            $pdf->Output('Purchase_#' . $data['invoice']['tid'] . '.pdf', 'D');

        } else {

            $pdf->Output('Purchase_#' . $data['invoice']['tid'] . '.pdf', 'I');

        }





    }
    public function print_depo_fisi()

    {



        $tid = $this->input->get('id');



        $data['id'] = $tid;

        $data['title'] = "Sipariş $tid";

        $data['invoice'] = $this->purchase->purchase_details($tid);

        $data['products'] = $this->purchase->purchase_products($tid);

        $data['employee'] = $this->purchase->employee($data['invoice']['eid']);

        $data['invoice']['multi'] = 0;



        ini_set('memory_limit', '64M');





        //PDF Rendering





        if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {

            $html = $this->load->view('purchase/view-print-gstin', $data, true);

        } else {

            $html = $this->load->view('purchase/view-print-depo-' . LTR, $data, true);

        }

        $header = $this->load->view('purchase/header-depo-print-' . LTR, $data, true);

        //PDF Rendering

        $this->load->library('pdf');



        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');



        $pdf->WriteHTML($html);



        if ($this->input->get('d')) {



            $pdf->Output('Purchase_#' . $data['invoice']['tid'] . '.pdf', 'D');

        } else {

            $pdf->Output('Purchase_#' . $data['invoice']['tid'] . '.pdf', 'I');

        }





    }



    public function delete_i()

    {

        $id = $this->input->post('deleteid');



        if ($this->purchase->purchase_delete($id)) {

            echo json_encode(array('status' => 'Success', 'message' =>

                "Sipariş :  #$id Başarıyla Silindi.!"));



        } else {



            echo json_encode(array('status' => 'Error', 'message' =>

                "Sipariş Silinirken Hata Oluştur."));

        }



    }



    public function editaction()

    {



        $customer_id = $this->input->post('customer_id');


        $invocieno = $this->input->post('iid');

        $depo = $this->db->query("Select * From geopos_purchase Where id=$invocieno")->row_array();
        $old_status = $depo['status'];

        $invoicedate = $this->input->post('invoicedate');

        $invocieduedate = $this->input->post('invocieduedate');

        $notes = $this->input->post('notes',true);

        $tax = $this->input->post('tax_handle');

        $subtotal = $this->input->post('subtotal');

        $shipping = $this->input->post('shipping');

        $refer = $this->input->post('refer',true);

        $total = $this->input->post('total');

        $currency = $this->input->post('mcurrency');

        $total_tax = 0;

        $total_discount = 0;

        $discountFormat = $this->input->post('discountFormat');

        $pterms = $this->input->post('pterms');
        $status = $this->input->post('status');
        $depo = $this->input->post('warehouses');



        $ship_taxtype = $this->input->post('ship_taxtype');

        $shipping = $this->input->post('shipping');

        $shipping_tax = $this->input->post('ship_tax');

        //proje bilgileri

        $project_name = $this->input->post('project_name');
        $project_adresi = $this->input->post('project_adresi');
        $project_sehir = $this->input->post('project_sehir');
        $project_yetkli_no = $this->input->post('project_yetkli_no');
        $proje_yetkili_adi = $this->input->post('proje_yetkili_adi');

        //proje bilgileri

        //şöför bilgileri
        $plaka_no = $this->input->post('plaka_no');
        $sofor_name = $this->input->post('sofor_name');
        $sofor_tel = $this->input->post('sofor_tel');
        //şöför bilgileri






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



        $this->db->delete('geopos_purchase_items', array('tid' => $invocieno));






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




            if($product_id[$key]!=0)
            {
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

                    'unit' => $product_unit[$key],
                    'rulo_miktari' =>rulo_hesapla($product_id[$key],$product_qty[$key]),

                );

                $productlist[$prodindex] = $data;

                $i++;

                $prodindex++;




                $flag = true;


            }










        }





        $bill_date = datefordatabase($invoicedate);

        $bill_due_date = datefordatabase($invocieduedate);




        $data = array(
            'invoicedate' => $bill_date,
            'invoiceduedate' => $bill_due_date,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'ship_tax' => $shipping_tax,
            'ship_tax_type' => $ship_taxtype,
            'discount' => $total_discount,
            'tax' => $total_tax,
            'total' => $total,
            'notes' => $notes,
            'csd' => $customer_id,
            'items' => $i,
            'taxstatus' => $tax,
            'discstatus' => $discstatus,
            'format_discount' => $discountFormat,
            'refer' => $refer,
            'term' => $pterms,
            'multi' => $currency,
            'proje_adi' => $project_name,
            'proje_adresi' => $project_adresi,
            'proje_sehir' => $project_sehir,
            'proje_tel' => $project_yetkli_no,
            'plaka_no' => $plaka_no,
            'sofor_name' => $sofor_name,
            'proje_yetkili_adi' => $proje_yetkili_adi,
            'sofor_tel' => $sofor_tel,
            'status' => $status,
            'depo_id' => $depo


        );

        $this->db->set($data);

        $this->db->where('id', $invocieno);



        if ($flag) {



            if ($this->db->update('geopos_purchase', $data)) {

                $this->db->insert_batch('geopos_purchase_items', $productlist);

                $this->db->set(array('discount' => rev_amountExchange($total_discount,$currency), 'tax' => rev_amountExchange($total_tax,$currency)));

                $this->db->where('id', $invocieno);

                $this->db->update('geopos_purchase');




                $product_details = $this->purchase->purchase_products($invocieno);


                $this->stock_update($status, $depo,$product_details,$old_status,$invocieno);


                echo json_encode(array('status' => 'Success', 'message' =>

                    "Sipariş Başarıyla Güncellendi! <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> Görüntüle </a> "));

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


        $this->purchase_stock_update($tid,$status);


    }


    public function purchase_stock_update($id,$status)
    {
        //Rezerve

        //Type 1==Rezerve Et, 2 ise iptal et ,3 ise rezerve sil

        $depo = $this->db->query("Select * From geopos_purchase Where id=$id")->row_array();
        $depo_id = $depo['depo_id'];
        $old_status = $depo['status'];
        $purchase_id=$id;

        $product_details = $this->purchase->purchase_products($id);

        if($old_status==1)
        {
            if($status==1)
            {
                echo json_encode(array('status' => 'Error', 'message' =>

                    "Siparişiniz ile seçtiğiniz durum aynıdır."));
            }
            else if($status==2)
            {
                    $this->stock_update($status,$depo_id,$product_details,$old_status,$purchase_id);
                    echo json_encode(array('status' => 'Success', 'message' =>

                        "Siparişiniz başarıyla rezerve edilmiştir."));


            }
            else if($status==3)
            {
                $this->stock_update($status,$depo_id,$product_details,$old_status,$purchase_id);
                $this->prim_hesapla($purchase_id,$status);
                    echo json_encode(array('status' => 'Success', 'message' =>

                        "Siparişiniz başarıyla onaylanmıştır."));

            }
            else if($status==4)
            {
                $this->stock_update($status,$depo_id,$product_details,$old_status,$purchase_id);
                $this->prim_hesapla($purchase_id,$status);
                    echo json_encode(array('status' => 'Success', 'message' =>

                        "Siparişiniz başarıyla iptal edilmiştir."));

            }
        }

        else if($old_status==2)
        {
            if($status==1)
            {
                $this->stock_update($status,$depo_id,$product_details,$old_status,$purchase_id);

                echo json_encode(array('status' => 'Success', 'message' =>

                    "Siparişiniz başarıyla değiştirilmiştir."));
            }


           else if($status==3)
            {
                $this->stock_update($status,$depo_id,$product_details,$old_status,$purchase_id);

                $this->prim_hesapla($purchase_id,$status);

                echo json_encode(array('status' => 'Success', 'message' =>

                    "Siparişiniz başarıyla onaylanmıştır."));
            }
            else if($status==4)
            {
                    $this->stock_update($status,$depo_id,$product_details,$old_status,$purchase_id);
                    echo json_encode(array('status' => 'Success', 'message' =>

                        "Siparişiniz başarıyla iptal edilmiştir."));

            }

            else
            {
                //Sipariş Durumunuz rezervede iptal edebilir veya onaylayabilirsiniz.

                echo json_encode(array('status' => 'Error', 'message' =>

                    "Siparişiniz rezerve durumundadır.İptal edebilir veya onaylayabilirsiniz."));
            }

        }

        else if($old_status==3)
        {


            if($status==4)
            {
                $this->stock_update($status,$depo_id,$product_details,$old_status,$purchase_id);
                $this->prim_hesapla($purchase_id,$status);
                    echo json_encode(array('status' => 'Success', 'message' =>

                        "Siparişiniz başarıyla iptal edilmiştir."));

            }

            else
            {
                //Onaylı Siparişinizi Sadece İptal Edebilirsiniz.

                echo json_encode(array('status' => 'Error', 'message' =>

                    "Onaylı siparişinizi sadece iptal edebilirsiniz."));
            }

        }

        else
            {
                echo json_encode(array('status' => 'Error', 'message' =>

                    "Siparişini tekrar açmanız gerekir!."));
                //Siparişini tekrar açmanız gerekir!
            }






    }




    public function prim_hesapla($purchase_id,$status)
    {
        $purchase_details = $this->purchase->purchase_details($purchase_id);
        if($status==3)//onaylandı prim ekle
        {

            if($purchase_details['eid']!=0)
            {
                $komisyon_orani=komisyon_orani($purchase_details['eid']);
                $prim=$purchase_details['total']*(100/$komisyon_orani);
                $prim_arr=array(
                    'purchase_id'=>$purchase_id,
                    'total'=>$prim,
                    'invoice_type_id'=>16,
                    'invoice_type_desc'=>'Sipariş Prim Alacağı',
                    'notes'=>'Sipariş Prim Alacağı',
                    'invoicedate'=>date('Y-m-d H:i:s'),
                    'invoiceduedate'=>date('Y-m-d H:i:s'),
                    'eid'=>$purchase_details['eid'],
                    'csd'=>$purchase_details['eid'],
                    'loc'=>5,
                    'payer'=>personel_details($purchase_details['eid'])
                );
                $this->db->insert('geopos_invoices', $prim_arr);
            }



        }
        else if($status==4)//prim sil
            {
                $this->db->delete('geopos_invoices', array('purchase_id' => $purchase_id));
            }
    }

    public function stock_update($status, $depo_id,$urunler,$old_status,$purchase_id)
    {



        $this->load->model('products_model', 'products');
        $toplam_agirlik=0;

        $operator1='';
        $operator2='';
        $operator3='';






        foreach ($urunler as $prd)
        {
            $product_id=$prd['pid'];
            $amt=$prd['qty'];


            $prd_deta = $this->products->poruduct_details($product_id);

            if($prd_deta['en']!=0 || $prd_deta['boy']!=0 )
            {
                $metrekare_agirligi = $prd_deta['metrekare_agirligi']/1000; //kg çevrildi
                $toplam_m2=$amt;
                $toplam_agirlik=$metrekare_agirligi*$toplam_m2;

            }
            else
            {
                $metrekare_agirligi = $prd_deta['metrekare_agirligi']/1000; //kg çevrildi
                $toplam_agirlik=$metrekare_agirligi*$amt;
            }

            if($old_status==1)
            {

                if($status==1) //Rezerve edilecek
                {
                    $operator1="qty-0";
                    $operator2= "rezerve_qty+0";
                    $operator3= "toplam_agirlik-0";
                }

                else if($status==2) //Rezerve edilecek
                {
                    $operator1="qty-$amt";
                    $operator2= "rezerve_qty+$amt";
                    $operator3= "toplam_agirlik+$toplam_agirlik";
                }
                else if($status==3) // Onaylandı Rezerve Sil
                {
                    $operator1="qty-$amt";
                    $operator2= "rezerve_qty-0";
                    $operator3= "toplam_agirlik+$toplam_agirlik";
                }
                else if($status==4)
                {
                    $operator1="qty-0";
                    $operator2= "rezerve_qty-0";
                    $operator3= "toplam_agirlik-0";
                }
            }

            if($old_status==2)
            {
                if($status==1) // rezerveden Bekliyor ise
                {
                    $operator1="qty+$amt";
                    $operator2= "rezerve_qty-$amt";
                    $operator3= "toplam_agirlik+0";
                }
                if($status==2) // Onaylandı Rezerve Sil
                {
                    $operator1="qty-0";
                    $operator2= "rezerve_qty-0";
                    $operator3= "toplam_agirlik+0";
                }


               else if($status==3) // Onaylandı Rezerve Sil
                {
                    $operator1="qty-0";
                    $operator2= "rezerve_qty-$amt";
                    $operator3= "toplam_agirlik+$toplam_agirlik";
                }
                else if($status==4)
                {
                    $operator1="qty+$amt";
                    $operator2= "rezerve_qty-$amt";
                    $operator3= "toplam_agirlik-0";
                }

            }

            if($old_status==3)
            {
                if($status==1)
                {
                    echo json_encode(array('status' => 'Error', 'message' =>

                        "Onaylanmış Siparişi Bekliyor Durumuna Alamazsınız"));
                    exit();
                }
                else if($status==2)
                {
                    $operator1="qty-0";
                    $operator2= "rezerve_qty-0";
                    $operator3= "toplam_agirlik+0";
                }

                else if($status==3)
                {
                    echo json_encode(array('status' => 'Error', 'message' =>

                        "Onaylanmış Siparişi Rezerve Durumuna Alamazsınız"));
                    exit();
                }

                else if($status==4)
                {
                    $operator1="qty+$amt";
                    $operator2= "rezerve_qty-0";
                    $operator3= "toplam_agirlik-0";
                }
            }


            //depo tablosunu güncelleme


            $depo_kontrol=$this->products->depo_kontrol($product_id,$depo_id);






            if(isset($depo_kontrol))
            {

                $this->db->set('qty', "$operator1", FALSE);
                $this->db->set('rezerve_qty', "$operator2", FALSE);
                $this->db->set('loc', "5", FALSE);

                $this->db->where('product_id', $product_id);

                $this->db->where('warehouse_id', $depo_id);

                $this->db->update('geopos_product_to_warehouse');
            }
            else
            {
                //depo tablosuna insert

                $depo_arr=array(
                    'product_id'=>$product_id,
                    'warehouse_id'=>$depo_id,
                    'qty'=>0,
                    'loc'=>5
                );
                $this->db->insert('geopos_product_to_warehouse', $depo_arr);

                $d_p_id = $this->db->insert_id();

                $this->db->set('qty', "$operator1", FALSE);

                $this->db->where('id', $d_p_id);

                $this->db->update('geopos_product_to_warehouse');

            }


            //depo tablosunu güncelleme
        }


        $this->db->set('status', "$status", FALSE);

        $this->db->where('id', $purchase_id);

        $this->db->update('geopos_purchase');


    }



    public function file_handling()

    {

        if ($this->input->get('op')) {

            $name = $this->input->get('name');

            $invoice = $this->input->get('invoice');

            if ($this->purchase->meta_delete($invoice, 4, $name)) {

                echo json_encode(array('status' => 'Success'));

            }

        } else {

            $id = $this->input->get('id');

            $this->load->library("Uploadhandler_generic", array(

                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'

            ));

            $files = (string)$this->uploadhandler_generic->filenaam();

            if ($files != '') {



                $this->purchase->meta_insert($id, 4, $files);

            }

        }

    }

    public function eksik_raporu_gonder($data,$order_name)
    {

        $html="<table width='100%' class='table'><thead><tr><th style='text-align: left'>Ürün Adı</th><th>Gerekli Miktar</th></tr></thead><tbody>";
        foreach ($data as $prd)
        {
            if(isset($prd['product_name']))
            {
                $html.="<tr><td style='text-align: left'>".$prd['product_name']."</td><td style='text-align: center'>".$prd['eksik_tutar']."</td></tr>";
            }

        }
        $html.="</tbody></table>";

        //$mail_adresi=sayim_onay_mail();


        $subject = 'Gerekli Stok Alım İşlemi';

        $message = 'Sayın Yetkili '.$order_name. ' Numaralı Sipariş İçin Gerekli Stok Alımı';


        $message .="<br><br><br><br>".$html;

        $message.='<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');


        $recipients=$this->satinalma_users();
        $this->send_mail($subject,$message,$recipients);

    }

    public function send_mail($subject,$message,$recipients)
    {
        $attachmenttrue = false;
        $attachment = '';
        $this->communication_model->send_email_eksik_siparis($recipients,$subject,$message,$attachmenttrue, $attachment);

    }


    public function satinalma_users()
    {

        $this->db->select('geopos_employees.name,geopos_users.email');
        $this->db->from('geopos_employees');
        $this->db->where('geopos_employees.dept', 7);
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id');
        $query = $this->db->get();
        return $query->result_array();
    }


}