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



use Mike42\Escpos\PrintConnectors\FilePrintConnector;

use Mike42\Escpos\Printer;

class Formainvoices extends CI_Controller

{
    public function __construct()

    {

        parent::__construct();

        $this->load->model('formainvoices_model', 'invocies');
        $this->load->library("Aauth");
        $this->load->model('communication_model');
        $this->load->helper('cookie');
        $this->load->model('plugins_model', 'plugins');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
//        if (!$this->aauth->premission(15)->read) {
//            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
//        }

        $this->limited = '';
    }
    public function index(){

        if (!$this->aauth->premission(15)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }

        $head['title'] = "Forma 2";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('formainvoices/index');

        $this->load->view('fixed/footer');
    }
    public function ajax_list()

    {

        $list = $this->invocies->get_datatables_form2($this->limited);




        $data = array();



        $no = $this->input->post('start');

        $this->session->set_userdata('test', 1);

        foreach ($list as $invoices) {

            $durum='Fatura Kesilmedi';
            if($invoices->refer==1)
            {
                $durum='Fatura Kesildi';
            }

            $durum.=' - '.invoice_status($invoices->status);

            $edit_button='';
            if($invoices->status==1){
                $edit_button=' <a href="' . base_url("formainvoices/edit/$invoices->id").'" class="btn btn-info btn-sm"  title="Düzenle"><span class="fa fa-pen"></span></a>';
            }
            $odeme='';
            if($invoices->status == 10 || $invoices->status == 18){
                //$odeme='<a href="#pop_modal_transaction" data-id="'.$invoices->id.'" data-toggle="modal"  data-remote="false" class="odeme_button btn btn-success">Ödeme Yap</a>';

            }

            if( ($invoices->status != 2) && ($invoices->status != 3) ){
                $odeme='<button data-id="'.$invoices->id.'"  class="odeme_button btn btn-success" type="button">Ödeme Talep Et</a>';
            }

            $total=$this->invocies->forma_total($invoices->id);


            $no++;

            $row = array();

            //$row[] = $no;
            $row[] = dateformat($invoices->invoicedate);

            $row[] = invoice_type_id($invoices->invoice_type_id);

            $row[] = $invoices->muqavele_no;
            $row[] = $invoices->invoice_no;

            $row[] = $invoices->name;


            $row[] = amountFormat($total,$invoices->para_birimi);

            $row[] = $durum;
            $row[] = proje_name($invoices->proje_id);


            $row[] = '<a href="' . base_url("formainvoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="Görüntüle"><i class="fa fa-eye"></i></a>&nbsp;
            <a href="' . base_url("formainvoices/print?id=$invoices->id") . '" class="btn btn-success btn-sm" title="Yazdır"><i class="fa fa-print"></i></a>&nbsp;';
            //$row[] = $odeme;


            $data[] = $row;

        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->invocies->count_all_forma_2($this->limited),

            "recordsFiltered" => $this->invocies->count_filtered_forma_2($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }

    public function ajax_list_iptal()

    {

        $list = $this->invocies->list_iptal($this->limited);

        $data = array();
        $no = $this->input->post('start');
        $this->session->set_userdata('test', 1);


        $user_id = $this->aauth->get_user()->id;

        foreach ($list as $invoices) {


            $total=$this->invocies->forma_total($invoices->id);

            $durum='Fatura Kesilmedi';
            if($invoices->refer==1)
            {
                $durum='Fatura Kesildi';
            }

            $durum.=' - '.invoice_status($invoices->status);

            $no++;
            $row = array();
            //$row[] = $no;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = $invoices->invoice_no;
            $row[] = $invoices->payer;
            $row[] = amountFormat($total,$invoices->para_birimi);
            $row[] = $durum;
            $row[] = proje_name($invoices->proje_id);
            $row[] = personel_details($invoices->iptal_pers);
            $row[] = $invoices->iptal_desc;
            $row[] = '<a href="' . base_url("formainvoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="Görüntüle"><i class="fa fa-eye"></i></a>';
            //$row[] = $odeme;


            $data[] = $row;

        }





        $output = array(

            "draw" => $_POST['draw'],
            "recordsTotal" => $this->invocies->count_all_list_iptal(),
            "recordsFiltered" => $this->invocies->count_filtered_list_iptal(),
            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }
    public function ajax_list_onay_bekleyen()

    {

        $list = $this->invocies->list_bekleyen($this->limited);

        $data = array();
        $no = $this->input->post('start');
        $this->session->set_userdata('test', 1);


        $user_id = $this->aauth->get_user()->id;

        foreach ($list as $invoices) {


            $total=$this->invocies->forma_total($invoices->id);

            $durum='Fatura Kesilmedi';
            if($invoices->refer==1)
            {
                $durum='Fatura Kesildi';
            }

            $durum.=' - '.invoice_status($invoices->status);

            $no++;
            $row = array();
            //$row[] = $no;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = invoice_type_id($invoices->invoice_type_id);
            $row[] = $invoices->muqavele_no;
            $row[] = $invoices->invoice_no;
            $row[] = $invoices->payer;
            $row[] = amountFormat($total,$invoices->para_birimi);
            $row[] = $durum;
            $row[] = proje_name($invoices->proje_id);
            $row[] = '<a href="' . base_url("formainvoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="Görüntüle"><i class="fa fa-eye"></i></a>';
            //$row[] = $odeme;


            $data[] = $row;

        }





        $output = array(

            "draw" => $_POST['draw'],
            "recordsTotal" => $this->invocies->count_all_list_bekleyen(),
            "recordsFiltered" => $this->invocies->count_filtered_list_bekleyen(),
            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }
//    public function create()
//    {
//        if (!$this->aauth->premission(15)->write) {
//            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
//        }
//        $this->load->model('products_model', 'products');
//
//        $head['usernm'] = $this->aauth->get_user()->username;
//        $data=array();
//        $data['emp'] = $this->products->employees();
//        $data['warehouse'] = $this->products->warehouses();
//
//        if($this->input->get('id'))
//        {
//
//            $sayi=0;
//            $tid = $this->input->get('id');
//            $query=$this->db->query('Select * From geopos_onay where  file_id='.$tid)->result();
//
//
//            foreach ($query as $q)
//            {
//                if($q->proje_muduru_status!=1)
//                {
//                    $sayi=1;
//                }
//
//                if($q->genel_mudur_status!=1)
//                {
//                    $sayi=1;
//                }
//            }
//            if($sayi==1)
//            {
//                exit('<h3>Sayın kullanıcıcı Bu form işlem görmüştür.Bu sebep ile güncelleme yapamazsınız!</h3>');
//            }
//            $bildirim_durumu = $this->db->query("SELECT * FROM geopos_invoices WHERE id =$tid")->row();
//            if($bildirim_durumu->bildirim_durumu==1){
//                exit('<h3>Sayın kullanıcıcı Bu form Onaya sunulmuştur.Bu sebep ile güncelleme yapamazsınız!</h3>');
//            }
//            $pay_list_array = [];
//            $pay_list = $this->db->query("SELECT * FROM geopos_invoice_transactions WHERE invoice_id =$tid");
//            if($pay_list->num_rows()>0){
//                foreach ($pay_list->result() as $pay){
//                    $pay_list_array[]=$pay->transaction_id;
//
//                }
//            }
//            $pay_list_array_text = implode(",", $pay_list_array);
//            $id=$this->input->get('id');
//            $data['id']=$id;
//
//            $data['edit_data'] = $this->invocies->invoice_details($id, $this->limited);
//            $data['pay_array'] = $pay_list_array_text;
//            $data['price_ar'] = '';
//            $head['title'] = "Forma 2 Düzenle";
//            $data['products'] = $this->invocies->invoice_products_forma2($id);
//            //echo "<pre>";print_r( $data['products']);die();
//
//        }
//        else
//        {
//            $data['products'] = '';
//            $data['stok_cikis'] = '';
//            $head['title'] = "Yeni Forma 2";
//        }
//
//
//
//
//
//        $this->load->view('fixed/header', $head);
//
//        $this->load->view('formainvoices/new_forma_2',$data);
//
//        $this->load->view('fixed/footer');
//
//    }
    public function save()
    {
        if (!$this->aauth->premission(15)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $muqavele_id_ = $this->input->post('hizmet_protokol');
            $muqavele_details='';
            $muqavele_details = $this->db->query("SELECT * FROM cari_razilastirma where id = $muqavele_id_")->row();



            $invoice_type = $this->input->post('invoice_type');
            $refer = $this->input->post('invoice_durumu');
            $method = $muqavele_details->odeme_sekli;
            $proje_id = $muqavele_details->proje_id;

            $customer_id = $this->input->post('customer_id');
            $muqavele_no_new = $this->input->post('muqavele_no_new');

            $tax_oran = $muqavele_details->tax_oran;
            $tax_status =  $muqavele_details->tax_status;

            $kdv_durum = $this->input->post('kdv_durum');
            $kdv_oran = $this->input->post('kdv_oran');
            if($kdv_durum!='yok'){
                $tax_status = $kdv_durum;
            }
            if($kdv_oran){
                $tax_oran = $kdv_oran;
            }




            $invoice_no = numaric(8);
            $invoicedate = $this->input->post('fis_date');
            $notes = $this->input->post('fis_note',true);
            $sorumlu_pers_id = $this->input->post('sorumlu_pers_id',true);
            $para_birimi =$muqavele_details->cur_id;
            $proje_sorumlu_id =proje_details($muqavele_details->proje_id)->proje_sorumlusu_id;
            $proje_muduru_id =proje_details($muqavele_details->proje_id)->proje_muduru_id;
            $genel_mudur_id =proje_details($muqavele_details->proje_id)->genel_mudur_id;
            $pay_array =$this->input->post('pay_array');
            $transok = true;
            $this->db->trans_start();
            $bill_date = datefordatabase($invoicedate);
            $data = array(
                'invoicedate' => $bill_date,
                'proje_sorumlu_id' => $proje_sorumlu_id,
                'proje_muduru_id' => $proje_muduru_id,
                'genel_mudur_id' => $genel_mudur_id,
                'invoice_type_id' => $invoice_type,
                'invoice_type_desc' => invoice_type_id($invoice_type),
                'notes' => $notes,
                'muqavele_no' => $muqavele_no_new,
                'csd' => $customer_id,
                'eid' => $this->aauth->get_user()->id,
                'sorumlu_pers_id' => $sorumlu_pers_id,
                'refer' => $refer,
                'invoice_no' => $invoice_no,
                'taxstatus' => $tax_status,
                'tax_oran' => $tax_oran,

                'loc' => $this->session->userdata('set_firma_id'),
                'method' => $method,
                'proje_id' => $proje_id,
                'para_birimi' => $para_birimi,
                'payer' => customer_details($customer_id)['company'],

            );
            if ($this->db->insert('geopos_invoices', $data)) {
                $last_id = $this->db->insert_id();

                $muqavele_id_ = $this->input->post('hizmet_protokol');
                $data_form = array(
                    'muqavele_id' => $muqavele_id_,
                    'forma_2_id' => $last_id,

                );
                $this->db->insert('forma_2_to_muqavele', $data_form);

                if($pay_array){
                    $this->db->query("UPDATE `geopos_invoice_transactions` SET `invoice_id`=$last_id WHERE `transaction_id` IN ($pay_array)");
                }

                $this->aauth->applog("Forma2 Oluşturuldu $invoice_no ID ".$last_id,$this->aauth->get_user()->username);
                kont_kayit(31,$last_id);
                $pid = $this->input->post('pid');

                $productlist = array();

                $prodindex = 0;

                $sub_total=0;
                $itc = 0;
                $i = 0;
                foreach ($pid as $key => $value) {

                    $product_id = $this->input->post('pid');
                    $product_name1 = $this->input->post('product_name',true);
                    $item_desc = $this->input->post('item_desc',true);
                    $product_qty = $this->input->post('product_qty');
                    $product_price = $this->input->post('product_qiymet');

                    $product_subtotal = $this->input->post('product_cemi');
                    $product_unit = $this->input->post('unit_id');

                    $bolum_id = $this->input->post('bolum_id');
                    $asama_id = $this->input->post('asama_id');

                    $data = array(

                        'tid' => $last_id,
                        'pid' => $product_id[$key],
                        'product' => $product_name1[$key],
                        'item_desc' => $item_desc[$key],
                        'qty' => $product_qty[$key],
                        'price' => $product_price[$key],
                        'subtotal' => floatval($product_price[$key])*floatval($product_qty[$key]),
                        'unit' => $product_unit[$key],
                        'bolum_id' => $bolum_id[$key],
                        'asama_id' => $asama_id[$key],
                        'invoice_type_id' => $invoice_type,
                        'proje_id' => $proje_id,
                        'invoice_type_desc' => invoice_type_id($invoice_type)
                    );
                    $productlist[$prodindex] = $data;

                    $i++;

                    $prodindex++;
                    $sub_total+=$product_subtotal[$key];
                }

                if ($prodindex > 0) {

                    $this->db->insert_batch('geopos_invoice_items', $productlist);
                    $this->db->insert_batch('geopos_project_items_gider', $productlist);

                    $total = $sub_total;
                    if($tax_status=='yes') // KDV DAHİL
                    {
                        $tax_total = floatval($sub_total) * (floatval($tax_oran)/100);
                        //$sub_total=floatval($tax_status)-floatval($tax_total);
                        $sub_total=floatval($sub_total)-floatval($tax_total);
                    }
                    else {
                        $tax_total = floatval($sub_total) * (floatval($tax_oran)/100);
                        $total= floatval($sub_total)+floatval($tax_total);
                    }
                    $this->db->set(
                        array
                        (
                            'subtotal' => $sub_total,
                            'tax' => $tax_total,
                            'total' => $total,
                            'items' => $itc
                        )
                    );

                    $this->db->where('id', $last_id);
                    $this->db->update('geopos_invoices');



                } else {


                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'status' => 410,
                        'message' =>'Hata Aldınız'
                    ));
                    $transok = false;

                }

                if ($transok) {

                    $operator= "deger+1";
                    $this->db->set('deger', "$operator", FALSE);
                    $this->db->where('tip', 8);
                    $this->db->update('numaric');

                    $this->db->trans_complete();

                    $validtoken = hash_hmac('ripemd160', $last_id, $this->config->item('encryption_key'));

                    $link = base_url('billing/view?id=' . $last_id . '&token=' . $validtoken);


                    echo json_encode(array(
                        'status' => 200,
                        'message' =>'Başarıyla Oluşturuldu',
                        'url' =>'/formainvoices/view/?id='.$last_id,
                    ));


                }

            } else {

                echo json_encode(array(
                    'status' => 410,
                    'message' =>'Hata Aldınız'
                ));

                $transok = false;

            }
        }



    }
    public function update()
    {
        if (!$this->aauth->premission(15)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $muqavele_id_ = $this->input->post('hizmet_protokol');
            $muqavele_details='';

            $muqavele_details = $this->db->query("SELECT * FROM cari_razilastirma where id = $muqavele_id_")->row();


            $forma_2_id = $this->input->post('forma_2_id');
            $muqavele_details = $this->db->query("SELECT * FROM cari_razilastirma where id = $muqavele_id_")->row();
            $invoice_type = $this->input->post('invoice_type');
            $refer = $this->input->post('invoice_durumu');
            $method = $muqavele_details->odeme_sekli;
            $proje_id = $muqavele_details->proje_id;
            $customer_id = $this->input->post('customer_id');
            $tax_oran = $muqavele_details->tax_oran;
            $tax_status =  $muqavele_details->tax_status;

            $tax_status = $this->input->post('kdv_durum');
            $kdv_oran = $this->input->post('kdv_oran');

            if(isset($kdv_oran)){
                $tax_oran = $kdv_oran;
            }


            $invoicedate = $this->input->post('fis_date');
            $notes = $this->input->post('fis_note',true);
            $sorumlu_pers_id = $this->input->post('sorumlu_pers_id',true);
            $para_birimi =$muqavele_details->cur_id;
            $proje_sorumlu_id =proje_details($muqavele_details->proje_id)->proje_sorumlusu_id;
            $proje_muduru_id =proje_details($muqavele_details->proje_id)->proje_muduru_id;
            $genel_mudur_id =proje_details($muqavele_details->proje_id)->genel_mudur_id;
            $muqavele_no_new =$this->input->post('muqavele_no_new');
            $pay_array =$this->input->post('pay_array');
            $pay_id =$this->input->post('pay_id');
            $price =$this->input->post('price');
            $transok = true;
            $this->db->trans_start();
            $bill_date = datefordatabase($invoicedate);
            $data = array(
                'invoicedate' => $bill_date,
                'proje_sorumlu_id' => $proje_sorumlu_id,
                'proje_muduru_id' => $proje_muduru_id,
                'genel_mudur_id' => $genel_mudur_id,
                'invoice_type_id' => $invoice_type,
                'invoice_type_desc' => invoice_type_id($invoice_type),
                'notes' => $notes,
                'csd' => $customer_id,
                'muqavele_no' => $muqavele_no_new,
                'eid' => $this->aauth->get_user()->id,
                'sorumlu_pers_id' => $sorumlu_pers_id,
                'refer' => $refer,
                'tax_oran' => $tax_oran,
                'taxstatus' => $tax_status,
                'method' => $method,
                'proje_id' => $proje_id,
                'para_birimi' => $para_birimi,
                'payer' => customer_details($customer_id)['company'],

            );
            $this->db->set($data);
            $this->db->where('id',$forma_2_id);
            if ($this->db->update('geopos_invoices', $data)) {
                $last_id = $forma_2_id;

                $this->db->delete('geopos_invoice_items', array('tid' => $forma_2_id));
                $this->db->delete('forma_2_to_muqavele', array('forma_2_id' => $forma_2_id));


                $data_form = array(
                    'muqavele_id' => $muqavele_id_,
                    'forma_2_id' => $last_id,

                );
                $this->db->insert('forma_2_to_muqavele', $data_form);

                if($pay_id){
                    $this->db->set('invoice_id',NULL);
                    $this->db->where('invoice_id', $last_id);
                    $this->db->update('geopos_invoice_transactions');

                    $pay_explode = explode(',',$pay_id);
                    $price_explpde = explode(',',$price);
                    foreach ($pay_explode as $key=>$p_id){
                        $price_v = $price_explpde[$key];

                        $this->db->query("UPDATE `geopos_invoice_transactions` SET `invoice_id`=$last_id, total=$price_v WHERE `transaction_id` = $p_id");
                    }

                }
                $this->aauth->applog("Forma2 Düzenlendi ID ".$last_id,$this->aauth->get_user()->username);
                kont_kayit(31,$last_id);
                $pid = $this->input->post('pid');
                $productlist = array();

                $prodindex = 0;

                $sub_total=0;
                $itc = 0;
                $i = 0;


                $this->db->delete('geopos_invoice_items', array('tid' => $last_id));
                $this->db->delete('geopos_project_items_gider', array('tid' => $last_id));
                foreach ($pid as $key => $value) {

                    $product_id = $this->input->post('pid');
                    $product_name1 = $this->input->post('product_name',true);
                    $item_desc = $this->input->post('item_desc',true);
                    $product_qty = $this->input->post('product_qty');
                    $product_price = $this->input->post('product_qiymet');
                    $product_subtotal = $this->input->post('product_cemi');
                    $product_unit = $this->input->post('unit_id');
                    $bolum_id = $this->input->post('bolum_id');
                    $asama_id = $this->input->post('asama_id');

                    $data = array(

                        'tid' => $last_id,

                        'pid' => $product_id[$key],

                        'product' => $product_name1[$key],
                        'item_desc' => $item_desc[$key],
                        'qty' => $product_qty[$key],

                        'price' => $product_price[$key],

                        'subtotal' => floatval($product_price[$key])*floatval($product_qty[$key]),

                        'unit' => $product_unit[$key],

                        'bolum_id' => $bolum_id[$key],

                        'asama_id' => $asama_id[$key],

                        'invoice_type_id' => $invoice_type,

                        'proje_id' => $proje_id,

                        'invoice_type_desc' => invoice_type_id($invoice_type)
                    );
                    $productlist[$prodindex] = $data;

                    $i++;

                    $prodindex++;
                    $sub_total+=$product_subtotal[$key];
                }

                if ($prodindex > 0) {

                    $this->db->insert_batch('geopos_invoice_items', $productlist);
                    $this->db->insert_batch('geopos_project_items_gider', $productlist);


                    $total = $sub_total;
                    if($tax_status=='yes') // KDV DAHİL
                    {
                        $tax_total = floatval($sub_total) * (floatval($tax_oran)/100);
                        $sub_total=floatval($sub_total)-floatval($tax_total);


                    }
                    else {
                        $tax_total = floatval($sub_total) * (floatval($tax_oran)/100);
                        $total= floatval($sub_total)+floatval($tax_total);

                    }
                    $this->db->set(
                        array
                        (
                            'subtotal' => $sub_total,
                            'tax' => $tax_total,
                            'total' => $total,
                            'items' => $itc
                        )
                    );

                    $this->db->where('id', $last_id);
                    $this->db->update('geopos_invoices');



                } else {

                    echo json_encode(array('status' => 'Error', 'message' =>

                        "Lütfen ürün listesinden ürün seçin. Ürünleri eklemediyseniz, Ürün yöneticisi bölümüne gidin."));

                    $transok = false;

                }

                if ($transok) {
                    $this->db->trans_complete();

                    $validtoken = hash_hmac('ripemd160', $last_id, $this->config->item('encryption_key'));
                    $link = base_url('billing/view?id=' . $last_id . '&token=' . $validtoken);



                    echo json_encode(array(
                        'status' => 200,
                        'message' =>'Başarıyla Güncellendi',
                        'url' =>'/formainvoices/view/?id='.$last_id,
                    ));


                }

            } else {

                $this->db->trans_rollback();
                echo json_encode(array(
                    'status' => 410,
                    'message' =>'Hata Aldınız'
                ));


                $transok = false;

            }
        }
    }

    public function create_new(){
        if (!$this->aauth->premission(15)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->invocies->create_new();
            if($result['status']){

                $id = $result['id'];
                $this->aauth->applog("Forma2 Oluşturuldu ".$id,$this->aauth->get_user()->username);

                echo json_encode(array('status' => 200, 'message' =>$result['message'],'id'=>$id));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }
    }

    public function create_new_hizmet(){

        $this->db->trans_start();
        $result = $this->invocies->create_new_hizmet();
        if($result['status']){

            $id = $result['id'];
            $this->aauth->applog("Forma2 Oluşturuldu ".$id,$this->aauth->get_user()->username);

            echo json_encode(array('status' => 200, 'message' =>$result['message'],'id'=>$id));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function update_new(){
        $forma_2_id = $this->input->post('forma_2_id');
        $details = $this->invocies->invoice_details($forma_2_id);
        if (!$this->aauth->premission(15)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else if($details['bildirim_durumu']){
            echo json_encode(array('status' => 410, 'message' =>'Forma 2 İşlem Görmüştür Düzenleme Yapılamaz'));
        }
        else {
            $this->db->trans_start();
            $result = $this->invocies->update_new();
            if($result['status']){

                $id = $result['id'];
                $this->aauth->applog("Forma2 Düzenlendi ".$id,$this->aauth->get_user()->username);

                echo json_encode(array('status' => 200, 'message' =>$result['message'],'id'=>$id));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }
    }


    public function get_razilastirma(){
        $razilastirma_id = $this->input->post('razilastirma_id');
        $sql = $this->db->query("Select geopos_invoices.id, geopos_invoices.invoice_no,geopos_invoices.payer,geopos_invoices.subtotal,geopos_invoices.tax,geopos_invoices.total From cari_razilastirma INNER JOIN forma_2_to_muqavele ON cari_razilastirma.id = forma_2_to_muqavele.muqavele_id
                               INNER JOIN geopos_invoices ON forma_2_to_muqavele.forma_2_id = geopos_invoices.id

    WHERE cari_razilastirma.id=$razilastirma_id");
        echo json_encode(array('items' =>$sql->result()));

    }


    public function view()
    {
        if (!$this->aauth->premission(15)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $tid = $this->input->get('id');
        $data=array();
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        $data['file_details']= $this->invocies->file_details($tid);

        $data['note_list']=new_list_note(1,$tid);

        // echo "<pre>";print_r($data['invoice']);die();
//        $data['products'] = $this->db->query("SELECT geopos_project_bolum.id,geopos_invoice_items.product,geopos_invoice_items.item_desc,
//       geopos_project_bolum.name,geopos_invoice_items.unit,geopos_invoice_items.qty,geopos_invoice_items.price,
//       geopos_invoice_items.subtotal FROM `geopos_todolist` INNER JOIN geopos_milestones ON geopos_milestones.id=geopos_todolist.asama_id
//    INNER JOIN geopos_project_bolum ON geopos_project_bolum.id=geopos_milestones.bolum_id
//    INNER JOIN geopos_invoice_items ON  geopos_invoice_items.pid=geopos_todolist.id
//WHERE geopos_invoice_items.tid=$tid ORDER BY `geopos_invoice_items`.`pid` ASC")->result_array();



        $data['fehle_status']=0;

         $data['invoice']['id'];
        $data['products']=[];
        $data['bolumler']=[];
         $hizmet_kontrol = $this->db->query("SELECT * FROM forma_2_to_ht Where forma_2_id=$tid");

         $fehle_kontrol = $this->db->query("SELECT * FROM worker_run Where forma2_id = $tid");


         if($hizmet_kontrol->num_rows()){
             $data['products'] = $this->db->query("
        SELECT geopos_project_bolum.id,geopos_invoice_items.product,geopos_invoice_items.item_desc,
       geopos_project_bolum.name,geopos_invoice_items.unit,geopos_invoice_items.qty,geopos_invoice_items.price,geopos_milestones.name as asama_name,
       geopos_invoice_items.subtotal,geopos_invoice_items.i_class FROM `demirbas_group`

            INNER JOIN geopos_invoice_items ON  geopos_invoice_items.pid=demirbas_group.id
           LEFT JOIN geopos_milestones ON geopos_milestones.id=geopos_invoice_items.asama_id 
           LEFT JOIN geopos_project_bolum ON geopos_project_bolum.id=geopos_milestones.bolum_id
        WHERE geopos_invoice_items.tid=$tid ORDER BY `geopos_invoice_items`.`pid` ASC")->result_array();



             $talep_id = $hizmet_kontrol->row()->muqavele_id;
             $talep_details = $this->db->query("SELECT * FROM talep_form Where id = $talep_id")->row();

             $data['bolumler'][] = (object) [
                 'id' => $talep_details->bolum_id,
                 'name' => bolum_getir($talep_details->bolum_id)
             ];


         }
         elseif($fehle_kontrol->num_rows()){
             $data['fehle_status']=1;
             $data['products'] = $this->db->query("

        SELECT geopos_project_bolum.id,geopos_invoice_items.product,geopos_invoice_items.item_desc,
       geopos_project_bolum.name,geopos_invoice_items.unit,geopos_invoice_items.qty,geopos_invoice_items.price,geopos_milestones.name as asama_name,
       geopos_invoice_items.subtotal,geopos_invoice_items.i_class FROM `geopos_invoice_items`

        
           INNER JOIN geopos_milestones ON geopos_milestones.id=geopos_invoice_items.asama_id 
           INNER JOIN geopos_project_bolum ON geopos_project_bolum.id=geopos_milestones.bolum_id


        WHERE geopos_invoice_items.tid=$tid ORDER BY `geopos_invoice_items`.`pid` ASC")->result_array();

             $data['bolumler']=$this->db->query("SELECT geopos_project_bolum.id,geopos_project_bolum.name
                                            FROM `geopos_invoice_items` 
                                                INNER JOIN geopos_milestones ON geopos_milestones.id=geopos_invoice_items.asama_id 
                                                INNER JOIN geopos_project_bolum ON geopos_project_bolum.id=geopos_milestones.bolum_id 
                                            WHERE geopos_invoice_items.tid=$tid 
                                            GROUP BY geopos_project_bolum.id 
                                            ORDER BY geopos_project_bolum.id DESC")->result();

         }
         else {
             $data['products'] = $this->db->query("SELECT geopos_project_bolum.id,geopos_invoice_items.product,geopos_invoice_items.item_desc,
       geopos_project_bolum.name,geopos_invoice_items.unit,geopos_invoice_items.qty,geopos_invoice_items.price,geopos_milestones.name as asama_name,
       geopos_invoice_items.subtotal,geopos_invoice_items.i_class FROM `geopos_todolist`

            INNER JOIN geopos_invoice_items ON  geopos_invoice_items.pid=geopos_todolist.id
           LEFT JOIN geopos_milestones ON geopos_milestones.id=geopos_invoice_items.asama_id 
           LEFT JOIN geopos_project_bolum ON geopos_project_bolum.id=geopos_milestones.bolum_id


        WHERE geopos_invoice_items.tid=$tid ORDER BY `geopos_invoice_items`.`pid` ASC")->result_array();
         $data['bolumler']=$this->db->query("SELECT geopos_project_bolum.id,geopos_project_bolum.name
                                            FROM `geopos_todolist` 
                                                INNER JOIN geopos_milestones ON geopos_milestones.id=geopos_todolist.asama_id 
                                                INNER JOIN geopos_project_bolum ON geopos_project_bolum.id=geopos_milestones.bolum_id 
                                                INNER JOIN geopos_invoice_items ON geopos_invoice_items.pid=geopos_todolist.id 
                                            WHERE geopos_invoice_items.tid=$tid 
                                            GROUP BY geopos_project_bolum.id 
                                            ORDER BY geopos_project_bolum.id DESC")->result();
         }








        $head['title'] = "Forma 2";
        $data['trans_pay']=$this->db->query("SELECT transaction_pay.*,geopos_employees.name FROM `transaction_pay` INNER JOIN geopos_employees ON transaction_pay.aauth_id=geopos_employees.id WHERE transaction_pay.forma2_id=$tid ORDER BY transaction_pay.id DESC")->result();

        $this->load->view('fixed/header', $head);
        $this->load->view('formainvoices/view_form2', $data);
        $this->load->view('fixed/footer');

    }
    public function edit($tid)
    {
        if (!$this->aauth->premission(15)->update) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }

        $this->load->model('products_model', 'products');

        $head['usernm'] = $this->aauth->get_user()->username;
        $data=array();
        $data['emp'] = $this->products->employees();
        $data['warehouse'] = $this->products->warehouses();

        $sayi=0;
        $query=$this->db->query('Select * From geopos_onay where  file_id='.$tid)->result();

        foreach ($query as $q)
        {
            if($q->proje_muduru_status!=1)
            {
                $sayi=1;
            }

            if($q->genel_mudur_status!=1)
            {
                $sayi=1;
            }
        }
        if($sayi==1)
        {
            exit('<h3>Sayın kullanıcıcı Bu form işlem görmüştür.Bu sebep ile güncelleme yapamazsınız!</h3>');
        }
        $pay_list_array = [];
        $pay_list = $this->db->query("SELECT * FROM geopos_invoice_transactions WHERE invoice_id =$tid");
        if($pay_list->num_rows()>0){
            foreach ($pay_list->result() as $pay){
                $pay_list_array[]=$pay->transaction_id;

            }
        }
        $pay_list_array_text = implode(",", $pay_list_array);

        $data['id']=$tid;
        $data['forma_2_id']=$tid;
        $data['edit_data'] = $this->invocies->invoice_details($tid, $this->limited);
        $data['pay_array'] = $pay_list_array_text;
        $q = $this->db->query("SELECT * FROM forma_2_to_muqavele where forma_2_id = $tid");
        $data['muqavele_id']=0;
        if($q->num_rows()){
            $data['muqavele_id'] = array($q->row()->muqavele_id);
        }


        $data['price_ar'] = '';
        $head['title'] = "Forma 2 Düzenle";
        $data['products'] = $this->invocies->invoice_products_forma2($tid);
        //echo "<pre>";print_r( $data['products']);die();




        $this->load->view('fixed/header', $head);

        $this->load->view('formainvoices/edit_forma_2',$data);

        $this->load->view('fixed/footer');

    }
    public function print()
    {
        if (!$this->aauth->premission(15)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $tid = $this->input->get('id');
        ini_set('memory_limit', '999999M');


        $data=array();
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);

        // echo "<pre>";print_r($data['invoice']);die();
//        $data['products'] = $this->db->query("SELECT geopos_project_bolum.id,geopos_invoice_items.product,geopos_invoice_items.item_desc,
//       geopos_project_bolum.name,geopos_invoice_items.unit,geopos_invoice_items.qty,geopos_invoice_items.price,
//       geopos_invoice_items.subtotal FROM `geopos_todolist` INNER JOIN geopos_milestones ON geopos_milestones.id=geopos_todolist.asama_id
//    INNER JOIN geopos_project_bolum ON geopos_project_bolum.id=geopos_milestones.bolum_id
//    INNER JOIN geopos_invoice_items ON  geopos_invoice_items.pid=geopos_todolist.id
//WHERE geopos_invoice_items.tid=$tid")->result_array();

        $data['products'] = $this->db->query("SELECT geopos_project_bolum.id,geopos_invoice_items.product,geopos_invoice_items.item_desc,
       geopos_project_bolum.name,geopos_invoice_items.unit,geopos_invoice_items.qty,geopos_invoice_items.price,geopos_milestones.name as asama_name,
       geopos_invoice_items.subtotal FROM `geopos_todolist`

    INNER JOIN geopos_invoice_items ON  geopos_invoice_items.pid=geopos_todolist.id
           INNER JOIN geopos_milestones ON geopos_milestones.id=geopos_invoice_items.asama_id INNER JOIN geopos_project_bolum ON geopos_project_bolum.id=geopos_milestones.bolum_id


WHERE geopos_invoice_items.tid=$tid ORDER BY `geopos_invoice_items`.`pid` ASC")->result_array();

        $data['bolumler']=$this->db->query("SELECT geopos_project_bolum.id,geopos_project_bolum.name FROM `geopos_todolist` INNER JOIN geopos_milestones ON geopos_milestones.id=geopos_todolist.asama_id INNER JOIN geopos_project_bolum ON geopos_project_bolum.id=geopos_milestones.bolum_id INNER JOIN geopos_invoice_items ON geopos_invoice_items.pid=geopos_todolist.id WHERE geopos_invoice_items.tid=$tid GROUP BY geopos_project_bolum.id")->result();

        $head['title'] = "Forma 2";

        $html = $this->load->view('formainvoices/print_form', $data, true);

        $this->load->library('pdf');



        $pdf = $this->pdf->load_split();


        $pdf->SetHTMLFooter('');

        $pdf->AddPage(
            '', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            5, // margin top
            '', // margin bottom
            0,50,0,0, // margin header
            ''); // margin footer

        $pdf->WriteHTML($html);

        $file_name = preg_replace( '/[^A-Za-z0-9]+/', '-', 'FORMA 2'. $data['invoice']['tid']);

        $pdf->Output($file_name . '.pdf', 'I');



    }
    public function cancel(){

        if (!$this->aauth->premission(15)->update) {
            echo json_encode(array('status' => 'Erorr', 'message' =>'Yetkiniz Bulunmamaktadır'));
            exit;
        }


        $foma2_id = $this->input->post('foma2_id');
        $desc = $this->input->post('desc');

        $this->db->set('status', 3);
        $this->db->set('pers_notes',"$desc");
        $this->db->set('updated_user_id',$this->aauth->get_user()->id);
        $this->db->where('id', $foma2_id);

        if($this->db->update('geopos_invoices')){
            $this->aauth->applog("Forma2 İptal Edildi ID ".$foma2_id,$this->aauth->get_user()->username);

            $this->talep_history($foma2_id,$this->aauth->get_user()->id,'iptal Edildi'.$desc,1);

            $this->db->set('invoice_id',NULL);
            $this->db->where('invoice_id', $foma2_id);
            $this->db->update('geopos_invoice_transactions');

            $this->db->delete('firma_gider', array('talep_id' => $foma2_id,'type'=>5));
            $this->db->delete('geopos_project_items_gider', array('tid' => $foma2_id));


            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
            exit;
        }
        else{
            echo json_encode(array('status' => 'Erorr', 'message' =>
                $this->lang->line('UPDATED'), 'pstatus' => 'Hata Oluştu Yöneticiye Başvurun'));
            exit;
        }

    }
    public function form2_status_change(){
        if (!$this->aauth->premission(15)->update) {
            echo json_encode(array('status' => 'Erorr', 'message' =>'Yetkiniz Bulunmamaktadır'));
            exit;
        }
        $foma2_id = $this->input->post('foma2_id');
        $form_2_status_id = $this->input->post('form_2_status_id');
        $old_status = $this->input->post('old_status');

        $this->db->set('status', $form_2_status_id);
        $this->db->where('id', $foma2_id);

        if($this->db->update('geopos_invoices')){
            $this->aauth->applog("Forma2 Durum Değiştirildi New Status : $form_2_status_id Old Status : $old_status Forma2 ID : ".$foma2_id,$this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
            exit;
        }
        else{
            echo json_encode(array('status' => 'Erorr', 'message' =>
                $this->lang->line('UPDATED'), 'pstatus' => 'Hata Oluştu Yöneticiye Başvurun'));
            exit;
        }

    }
    public function bildirim_olustur(){
        $talep_id=$this->input->post('invoice_id');
        $details=$this->db->query("SELECT * FROM geopos_invoices WHERE id=$talep_id")->row();
        $proje_name=proje_name($details->proje_id);

        // Proje Kişileri Update

        $users_ = proje_yetkilileri($details->proje_id,2);
        $proje_sorumlu_id = $users_[0]['user_id'];
        $proje_muduru_id = $users_[1]['user_id'];
        $genel_mudur_id = $users_[2]['user_id'];

        $data_update = array(
            'proje_sorumlu_id' => $proje_sorumlu_id,
            'proje_muduru_id' => $proje_muduru_id,
            'genel_mudur_id' => $genel_mudur_id,
        );
        $this->db->set($data_update);
        $this->db->where('id',$talep_id);
        $this->db->update('geopos_invoices', $data_update);
        // Proje Kişileri Update

        $talep_no=$details->invoice_no;



        $proje_sorumlusu_id=$details->proje_sorumlu_id;

        $subject = 'Forma2 Onayı';
        $message = 'Sayın Yetkili ' . $proje_name.' - '.$talep_no . ' Numaralı Forma2 Oluşturuldu. Onay İşleminiz Beklenmektedir.';
        $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
        $firma_kodu=$dbnames['firma_kodu'];
        $validtoken = hash_hmac('ripemd160', 'p' . $talep_id, $this->config->item('encryption_key'));
        $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$talep_id&pers_id=$proje_sorumlusu_id&type=forma2onay&token=$validtoken";
        $message .="<br>İncelemek İçin Sisteme Giriş Yapınız. Bekleyen Talep Listesinde Görüntüleyebilirsiniz";
        $message .= "<br><br><br><br>";
        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
        $proje_sorumlusu_email = personel_detailsa($proje_sorumlusu_id)['email'];


        $recipients = array($proje_sorumlusu_email);

        $this->db->delete('geopos_onay', array('file_id' => $talep_id,'type'=>10));

        $this->db->set('bildirim_durumu', 1);
        $this->db->where('id', $talep_id);
        $this->db->update('geopos_invoices');


        $data_o= array(
            'product_id' => 0,
            'malzeme_items_id' => 0,
            'file_id' => $talep_id,
            'type' => 10);

        $this->db->insert('geopos_onay', $data_o);

        $this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili');
        echo json_encode(array('status' => 'Success', 'message' =>'Başrıyla Onaya Sunulmuştur...', 'pstatus' => 'Başarılı'));
    }
    public function onay_mailleri($subject, $message, $recipients, $tip)
    {

        $attachmenttrue = false;
        $attachment = '';


        $this->communication_model->onay_mail($recipients, $subject, $message, $attachmenttrue, $attachment, $tip);

    }
    public function forma2_user_kontrol(){
        $invoice_id = $this->input->post('invoice_id');
        $kullanici = $this->aauth->get_user()->id;
        $query = $this->db->query("SELECT * FROM geopos_invoices where id=$invoice_id and (proje_muduru_id=$kullanici or proje_sorumlu_id=$kullanici or  genel_mudur_id=$kullanici) ");
        if ($query->num_rows() > 0) {
            if ($query->row()->proje_sorumlu_id == $kullanici && $query->row()->proje_muduru_id == $kullanici && $query->row()->genel_mudur_id == $kullanici)    //proje müdürü onayladı
            {
                echo json_encode(array('status' => 'Success', 'genel_mudur' =>true,'proje_muduru'=>false));
            }
            else if ($query->row()->proje_muduru_id == $kullanici)    //proje müdürü onayladı
            {
                echo json_encode(array('status' => 'Success', 'genel_mudur' =>false,'proje_muduru'=>true));
            }
            else if ($query->row()->proje_sorumlu_id == $kullanici)    //proje müdürü onayladı
            {
                echo json_encode(array('status' => 'Success', 'genel_mudur' =>false,'proje_muduru'=>true));
            }
            else {
                echo json_encode(array('status' => 'Success', 'genel_mudur' =>true,'proje_muduru'=>false));
            }
        }
        else {
            echo json_encode(array('status' => 'Error', 'message'=>'Yetkiniz Bulunmamaktadır'));
        }
    }
    public function forma2_onay(){
        $talep_id = $this->input->post('invoice_id');
        $onay_tipi = $this->input->post('onay_tipi');
        date_default_timezone_set('Asia/Baku');
        $date = new DateTime('now');
        $date_saat=$date->format('Y-m-d H:i:s');
        $kullanici = $this->aauth->get_user()->id;


        $subject = 'Forma2 Hk.';
        $query = $this->db->query("SELECT * FROM geopos_invoices where id=$talep_id and (proje_muduru_id=$kullanici or proje_sorumlu_id=$kullanici or  genel_mudur_id=$kullanici) ");
        if ($query->num_rows() > 0)
        {
            if ($query->row()->proje_sorumlu_id == $kullanici)    //proje müdürü onayladı
            {

                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=10 and file_id=$talep_id");
                if($onay_kontrol->num_rows()>0){
                    $this->db->set('proje_sorumlusu_status', 3);
                    $this->db->set('proje_sorumlusu_onay_saati', $date_saat);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 10);
                    if( $this->db->update('geopos_onay')){

                        $yeni_pers_id = $query->row()->proje_muduru_id;
                        $yeni_pers_id_email = personel_detailsa($yeni_pers_id)['email'];
                        $recipients = array($yeni_pers_id_email);
                        $mobile = personel_detailsa($yeni_pers_id)['phone'];
                        $text_message=$query->row()->invoice_no . '  numaralı Forma2 Proje Sorumlusu Tarafından Onaylandı.';
                        $message = 'Sayın Yetkili ' . $query->row()->invoice_no . ' numaralı Forma2 Proje Müdürü Tarafından Onaylandı.Sizin Onayınız Beklemektedir.';

                        if($this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili'))
                        {

                        }


                    }
                }
            }
            if ($query->row()->proje_muduru_id == $kullanici)    //proje müdürü onayladı
            {

                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=10 and file_id=$talep_id");
                if($onay_kontrol->num_rows()>0){
                    $this->db->set('proje_muduru_status', 3);
                    $this->db->set('proje_muduru_onay_saati', $date_saat);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 10);
                    if( $this->db->update('geopos_onay')){

                        $yeni_pers_id = $query->row()->genel_mudur_id;
                        $yeni_pers_id_email = personel_detailsa($yeni_pers_id)['email'];
                        $recipients = array($yeni_pers_id_email);
                        $mobile = personel_detailsa($yeni_pers_id)['phone'];
                        $text_message=$query->row()->invoice_no . '  numaralı Forma2 Proje Müdürü Tarafından Onaylandı.';
                        $message = 'Sayın Yetkili ' . $query->row()->invoice_no . ' numaralı Forma2 Proje Müdürü Tarafından Onaylandı.Sizin Onayınız Beklemektedir.';

                        if($this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili'))
                        {

                        }


                    }
                }
            }

            if ($query->row()->genel_mudur_id == $kullanici)    //Genel müdürü onayladı
            {
                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=10 and file_id=$talep_id");
                if($onay_kontrol->num_rows()>0){
                    $this->db->set('genel_mudur_status', 3);
                    $this->db->set('genel_mudur_onay_saati	', $date_saat);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 10);

                    if( $this->db->update('geopos_onay')){


                        $status_=0;
                        if($onay_tipi==2){
                            $status_ = 19;
                            $pers_notes='Cariye İşle Ve Bekleyen Ödeme Listesine Ekle';
                        }
                        elseif($onay_tipi==1){
                            $status_=19;
                            $pers_notes='Ödeme Listesine Almadan Cariye İşle';
                        }

                        $this->db->set('status', $status_);
                        $this->db->set('forma2_notes', $pers_notes);
                        $this->db->where('id', $talep_id);
                        $this->db->update('geopos_invoices');



                        $yeni_pers_id = $query->row()->eid;
                        $yeni_pers_id_email = personel_detailsa($yeni_pers_id)['email'];
                        $recipients = array($yeni_pers_id_email);
                        $mobile = personel_detailsa($yeni_pers_id)['phone'];
                        $text_message=$query->row()->invoice_no . '  numaralı Forma2 Genel Müdür Tarafından Onaylandı.';
                        $message = 'Sayın Yetkili ' . $query->row()->invoice_no . ' numaralı Forma2 Genel Müdür Tarafından Onaylandı.';

                        if($this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili'))
                        {

                        }



                    }
                }
            }

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
            exit;
        }
        else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('UPDATED'), 'pstatus' => 'Yetkiniz Yoktur'));
            exit;
        }
    }

    public function onay_baslat(){
        $this->db->trans_start();
        $talep_id = $this->input->post('talep_id');
        $type = $this->input->post('type');
        $details = $this->invocies->invoice_details($talep_id);
        $users_ = onay_sort(8,$details['proje_id']);

        if($users_){
            foreach ($users_ as $items){
                $staff=0;
                if($items['sort']==1){
                    $staff=1;
                }
                $data_onay = array(
                    'invoices_id' => $talep_id,
                    'type' => $type,
                    'staff' => $staff,
                    'sort' => $items['sort'],
                    'user_id' => $items['user_id'],
                );
                $this->db->insert('invoices_onay_new', $data_onay);
            }

//            // bildirim maili at
//            $mesaj=$details['invoice_no'].' Numaralı Forma2 Onayınızı Beklemektedir';
//            $this->send_mail($items['user_id'],'Forma 2 Onayı',$mesaj);
//            // bildirim maili at
//            $user_phone = personel_details_full($items['user_id'])['phone'];
//            $this->mesaj_gonder($user_phone,$details['invoice_no'].' Forma 2 Onayınızı Beklemektedir.');


            $this->db->set('bildirim_durumu', 1);
            $this->db->where('id', $talep_id);
            $this->db->update('geopos_invoices');
            $this->talep_history($talep_id,$this->aauth->get_user()->id,'Bildirim Başlatıldı',2);
            $this->aauth->applog("Forma 2 Bildirim Başlatıldı :  ID : ".$talep_id, $this->aauth->get_user()->username);
            $this->db->trans_complete();

            //kont_kayit(21,$id);
            echo json_encode(array('status' => 200,'message'=>'Başarıyla Bildirim Başlatıldı'));

        }
        else {
            echo json_encode(array('status' => 410, 'message' =>"Projenize Yetkili Kişiler Atanmamıştır veya Seçilen Depoya Yetkili Tanımlanmamıştır.Bu Sebeple İşlem Yapamazsınız."));
            $this->db->trans_rollback();
        }
    }

    public function send_mail($user_id,$subject,$message){
        if(!$user_id){
            return 0;
        }
        else {
            $message .= "<br><br><br><br>";
            $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
            $proje_sorumlusu_email = personel_detailsa($user_id)['email'];
            $recipients = array($proje_sorumlusu_email);
            $this->communication_model->onay_mail($recipients, $subject, $message, false,'', 'gider_talep_onay_maili');
            return 1;
        }

    }
    public function mesaj_gonder($proje_sorumlusu_no,$mesaj)
    {
        $result='';




        $tel=str_replace(" ","",$proje_sorumlusu_no);

        $domain="https://sms.atatexnologiya.az/bulksms/api";
        $operation='submit';
        $login='makro2000';
        $password="makro!sms";
        $title='MAKRO2000';
        $bulkmessage=$mesaj;
        $scheduled='now';
        $isbulk='true';
        $msisdn='994'.$tel;

        $cont_id=rand(1,999999999);



        $input_xml = "<?xml version='1.0' encoding='UTF-8'?>
               <request>
                <head>
                    <operation>$operation</operation>
                    <login>$login</login>
                    <password>$password</password>
                    <title>$title</title>
                    <bulkmessage>$bulkmessage</bulkmessage>
                    <scheduled>$scheduled</scheduled>
                    <isbulk>$isbulk</isbulk>
                    <controlid>$cont_id</controlid>
                </head>
                    <body>
                    <msisdn>$msisdn</msisdn>
                    </body>
                </request>";



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $domain);

        // For xml, change the content-type.
        curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

        // Send to remote and return data to caller.
        $result = curl_exec($ch);

        curl_close($ch);


        return 1;




    }


    public function forma2_iptal(){
        $talep_id = $this->input->post('invoice_id');
        $desc = $this->input->post('desc');
        date_default_timezone_set('Asia/Baku');
        $date = new DateTime('now');
        $date_saat=$date->format('Y-m-d H:i:s');
        $kullanici = $this->aauth->get_user()->id;


        $subject = 'Forma2 Hk.';
        $query = $this->db->query("SELECT * FROM geopos_invoices where id=$talep_id and (proje_muduru_id=$kullanici or proje_sorumlu_id=$kullanici or  genel_mudur_id=$kullanici) ");
        if ($query->num_rows() > 0)
        {
            if ($query->row()->proje_sorumlu_id == $kullanici)    //proje müdürü onayladı
            {

                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=10 and file_id=$talep_id");
                if($onay_kontrol->num_rows()>0){
                    $this->db->set('proje_sorumlusu_status', 4);
                    $this->db->set('proje_sorumlusu_status_note', $desc);
                    $this->db->set('proje_sorumlusu_onay_saati', $date_saat);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 10);
                    if( $this->db->update('geopos_onay')){

                        $this->db->set('invoice_id',NULL);
                        $this->db->where('invoice_id', $talep_id);
                        $this->db->update('geopos_invoice_transactions');

                        $yeni_pers_id = $query->row()->eid;
                        $yeni_pers_id_email = personel_detailsa($yeni_pers_id)['email'];
                        $recipients = array($yeni_pers_id_email);
                        $mobile = personel_detailsa($yeni_pers_id)['phone'];
                        $text_message=$query->row()->invoice_no . '  numaralı Forma2 Genel Müdür Tarafından İptal Edildi.';
                        $message = 'Sayın Yetkili ' . $query->row()->invoice_no . ' numaralı Proje Müdürü Tarafından İptal Edildi.';

                        if($this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili'))
                        {

                        }
                        echo json_encode(array('status' => 'Success', 'message' =>
                            $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
                        exit();

                    }
                }
            }
            if ($query->row()->proje_muduru_id == $kullanici)    //proje müdürü onayladı
            {

                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=10 and file_id=$talep_id");
                if($onay_kontrol->num_rows()>0){
                    $this->db->set('proje_muduru_status', 4);
                    $this->db->set('proje_muduru_status_note', $desc);
                    $this->db->set('proje_muduru_onay_saati', $date_saat);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 10);
                    if( $this->db->update('geopos_onay')){

                        $this->db->set('invoice_id',NULL);
                        $this->db->where('invoice_id', $talep_id);
                        $this->db->update('geopos_invoice_transactions');

                        $yeni_pers_id = $query->row()->eid;
                        $yeni_pers_id_email = personel_detailsa($yeni_pers_id)['email'];
                        $recipients = array($yeni_pers_id_email);
                        $mobile = personel_detailsa($yeni_pers_id)['phone'];
                        $text_message=$query->row()->invoice_no . '  numaralı Forma2 Genel Müdür Tarafından İptal Edildi.';
                        $message = 'Sayın Yetkili ' . $query->row()->invoice_no . ' numaralı Proje Müdürü Tarafından İptal Edildi.';

                        if($this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili'))
                        {

                        }
                        echo json_encode(array('status' => 'Success', 'message' =>
                            $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
                        exit();

                    }
                }
            }

            if ($query->row()->genel_mudur_id == $kullanici)    //Genel müdürü onayladı
            {
                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=10 and file_id=$talep_id");
                if($onay_kontrol->num_rows()>0){
                    $this->db->set('genel_mudur_status', 4);
                    $this->db->set('genel_mudur_status_note', $desc);
                    $this->db->set('genel_mudur_onay_saati	', $date_saat);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 10);
                    if( $this->db->update('geopos_onay')){

                        $this->db->set('invoice_id',NULL);
                        $this->db->where('invoice_id', $talep_id);
                        $this->db->update('geopos_invoice_transactions');

                        $yeni_pers_id = $query->row()->eid;
                        $yeni_pers_id_email = personel_detailsa($yeni_pers_id)['email'];
                        $recipients = array($yeni_pers_id_email);
                        $mobile = personel_detailsa($yeni_pers_id)['phone'];
                        $text_message=$query->row()->invoice_no . '  numaralı Forma2 Genel Müdür Tarafından İptal Edildi.';
                        $message = 'Sayın Yetkili ' . $query->row()->invoice_no . ' numaralı Forma2 Genel Müdür Tarafından İptal Edildi.';

                        if($this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili'))
                        {

                        }

                        echo json_encode(array('status' => 'Success', 'message' =>
                            $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
                        exit();

                    }
                }
            }
        }
    }

    public function talep_history($id,$user_id,$desc,$type=1){
        $data_step = array(
            'talep_id' => $id,
            'user_id' => $user_id,
            'desc' => $desc,
            'type' => $type,
        );
        $this->db->insert('invoice_history', $data_step);

    }

    public function ajax_list_history(){

        $talep_id=$this->input->post('talep_id');

        $list = $this->invocies->ajax_list_history($talep_id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $no++;
            $row = array();
            $row[] = $prd->pers_name;
            $row[] = $prd->desc;
            $row[] = $prd->created_at;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->invocies->count_all_talep_history($talep_id),
            "recordsFiltered" => $this->invocies->count_filtered_talep_history($talep_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function onay_olustur(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $status = $this->input->post('status');
        $desc = $this->input->post('desc');
        $aauth_sort = $this->input->post('aauth_sort');
        $details = $this->invocies->invoice_details($id);
        $type = $this->input->post('type');

        $auth_id = $this->aauth->get_user()->id;
        $sort_kontrol = $this->db->query("SELECT * FROM invoices_onay_new Where invoices_id=$id and  user_id=$auth_id and  status is null and staff=1 and sort=$aauth_sort")->num_rows();

        if($sort_kontrol) {
            if ($this->aauth->get_user()->id == 61) {
                $razilastirma_details = $this->db->query("SELECT * FROM geopos_invoices where id = $id")->row();
                $subject = 'Forma2 Onayı';
                $message = $razilastirma_details->invoice_no . ' Numaralı Forma2ye Genel Müdür Durum Bildirildi.';
                $recipients = array(832, 831);
                $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili', $id);
            }

            if ($status > 0) {
                $new_id = 0;
                $new_user_id = 0;
                $sort = 0;
                $new_id_control = $this->db->query("SELECT * FROM `invoices_onay_new` Where type=$type and invoices_id=$id and staff=0 and status is Null ORDER BY `invoices_onay_new`.`id` ASC LIMIT 1");
                if ($new_id_control->num_rows()) {
                    $new_id = $new_id_control->row()->id;
                    $new_user_id = $new_id_control->row()->user_id;
                    $sort = $new_id_control->row()->sort;
                }
                $data = array(
                    'status' => 1,
                    'staff' => 0,
                );

                $this->db->where('user_id', $this->aauth->get_user()->id);
                $this->db->where('staff', 1);
                $this->db->where('type', $type);
                $this->db->set($data);
                $this->db->where('invoices_id', $id);
                if ($this->db->update('invoices_onay_new', $data)) {

                    $this->talep_history($id, $this->aauth->get_user()->id, 'Onay Verildi' . $desc);


                    if ($new_id) {

                        $data_new = array(
                            'staff' => 1,
                        );
                        $this->db->where('id', $new_id);
                        $this->db->set($data_new);
                        $this->db->update('invoices_onay_new', $data_new);
                        // Bir Sonraki Onay
//                        if ($sort == 4) // Genel Müdürse
//                        {
//                            $pers_notes = 'Ödeme Listesine Almadan Cariye İşle';
//                            $this->db->set('forma2_notes', $pers_notes);
//                            $this->db->where('id', $id);
//                            $this->db->update('geopos_invoices');
//
//                        }
                    }
                    else {
                        $this->db->set('status', 18);
                        $this->db->where('id', $id);
                        $this->db->update('geopos_invoices');
                    }


//                    if ($sort == 7) { //cariye İşle
//                        $this->db->set('status', 18);
//                        $this->db->where('id', $id);
//                        $this->db->update('geopos_invoices');
//                    }

                    if ($sort == 9) {
                        $subject = 'Forma2  Onayı';
                        $message = $razilastirma_details->invoice_no . ' Numaralı Forma2 ye Onay Verildi.';
                        $proje_sorumlusu_email = personel_detailsa(832)['email'];
                        $proje_sorumlusu_email2 = personel_detailsa(831)['email'];

                        $recipients = array($proje_sorumlusu_email, $proje_sorumlusu_email2);
                        $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili', $id);
                    }

                    $this->db->trans_complete();
                    echo json_encode(array('status' => 'Success', 'message' => 'Başarıyla Onay Verildi'));

                } else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun." . ' Hata '));

                }
            } elseif ($status == -1) {
                $staff_details = $this->input->post('staff_details');
                $staff_id = $staff_details['staff_id'];
                $sort_id = $staff_details['sort_id'];
                $onay_id = $staff_details['onay_id'];
                $kontrol = $this->db->query("SELECT * FROM invoices_onay_new Where invoices_onay_new.invoices_id=$id and type=2 and sort BETWEEN $sort_id AND $aauth_sort");
                if ($kontrol->num_rows()) {
                    $update_id = 0;
                    foreach ($kontrol->result() as $items) {
                        $this->db->set('status', NULL, true);
                        $this->db->set('staff', 0);
                        $this->db->where('id', $items->id);
                        $this->db->update('invoices_onay_new');
                        if ($items->sort == $sort_id) {
                            $update_id = $items->id;
                        }

                    }
                    $this->db->set('staff', 1);
                    $this->db->where('id', $update_id);
                    $this->db->update('invoices_onay_new');

                    $personel_name = personel_details($staff_id);
                    $this->talep_history($id, $this->aauth->get_user()->id, 'Talep Geri Alındı.Atanan Personel : ' . $personel_name . ' Açıklama : ' . $desc);
                    $this->db->trans_complete();
                    echo json_encode(array('status' => 'Success', 'message' => 'Başarıyla Geri Alındı'));
                }

            } elseif ($status == 0) {

                $data_new = array(
                    'status' => 3,
                );
                $this->db->where('id', $id);
                $this->db->where('staff', 1);
                $this->db->where('user_id', $this->aauth->get_user()->id);
                $this->db->set($data_new);
                $this->db->update('invoices_onay_new', $data_new);


                $this->db->set('status', 3);
                $this->db->where('id', $id);
                $this->db->update('geopos_invoices');
                $this->talep_history($id, $this->aauth->get_user()->id, 'İptal Edildi. Açıklama : ' . $desc);


                $this->db->set('invoice_id', NULL);
                $this->db->where('invoice_id', $id);
                $this->db->update('geopos_invoice_transactions');

                $this->db->delete('firma_gider', array('talep_id' => $id, 'type' => 5));
                $this->db->delete('geopos_project_items_gider', array('tid' => $id));


                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success', 'message' => 'Başarıyla İptal Edildi'));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Doğru Tercih Yapmadınız Sayfa Yenilemesi Yapınız.".' Hata '));
        }


    }

    public function check_pers_all(){
        $id = $this->input->post('talep_id');
        $all=$this->db->query("SELECT invoices_onay_new.*,geopos_employees.name FROM invoices_onay_new
Inner JOIN geopos_employees on invoices_onay_new.user_id = geopos_employees.id Where invoices_onay_new.invoices_id=$id and invoices_onay_new.type=2 and invoices_onay_new.status IN(1,0) GROUP BY invoices_onay_new.user_id");
        if($all->num_rows()){
            echo json_encode(array('status' => 200,'details'=>$all->result()));
        }
        else {
            echo json_encode(array('status' => 410,'messages'=>'Onaylayan Personel Bulunanamıştır'));
        }
    }
    public function islem_details(){
        $id = $this->input->post('pay_id');
        $details = $this->db->query("SELECT * FROM geopos_invoices Where id = $id")->row();

        $forma_2_list=cari_forma2_list($details->csd);
        $proje_list=all_projects();
        $islem_details = $this->db->query("SELECT transaction_pay.*,geopos_invoices.invoice_no FROM transaction_pay LEFT JOIN geopos_invoices ON transaction_pay.forma2_id =geopos_invoices.id  Where invoice_id = $id");
        $history='';
        $islem_durum = 0;
        $max=$details->total;
        $parca=0;
        if($islem_details->num_rows()){

            foreach ($islem_details->result() as $items){
                $parca+=$items->amount;
            }
            $max=floatval($details->total)-floatval($parca);
            $history=$islem_details->result();
            $islem_durum = 1;
        }
        echo json_encode(array('status' => 200,'details'=>$details,'islem_details'=>$history,'islme_durum'=>$islem_durum,'max'=>$max,'forma_2_list'=>$forma_2_list,'proje_list'=>$proje_list));

    }

    public function islem_details_avans(){
        $id = $this->input->post('pay_id');
        $transaction_id = $this->db->query("SELECT * FROM talep_form_customer_new_payment Where form_id = $id and tip=2")->row()->transaction_id;

        $details = $this->db->query("SELECT * FROM geopos_invoices Where id = $transaction_id")->row();

        $islem_details = $this->db->query("SELECT transaction_pay.*,geopos_invoices.invoice_no FROM transaction_pay LEFT JOIN geopos_invoices ON transaction_pay.forma2_id =geopos_invoices.id  Where invoice_id = $transaction_id");
        $history='';
        $islem_durum = 0;
        $max=$details->total;
        $parca=0;
        if($islem_details->num_rows()){

            foreach ($islem_details->result() as $items){
                $parca+=$items->amount;
            }
            $max=floatval($details->total)-floatval($parca);
            $history=$islem_details->result();
            $islem_durum = 1;
        }
        echo json_encode(array('status' => 200,'details'=>$details,'islem_details'=>$history,'islme_durum'=>$islem_durum,'max'=>$max));

    }
    public function islem_create(){
        $forma2_id = $this->input->post('forma2_id');
        $proje_id = $this->input->post('proje_id');
        $transaction_id = $this->input->post('transaction_id');
        $amount = $this->input->post('amount');
        $desc = $this->input->post('desc');


        $islem_Details = $this->db->query("SELECT * FROM geopos_invoices Where id=$transaction_id")->row();
        $cari_id=$islem_Details->csd;

        if($forma2_id){
            $details=$this->db->query("SELECT * FROM geopos_invoices WHERE id=$forma2_id");

            if($details->num_rows()){
                $proje_id =$details->row()->proje_id;
            }
        }
        $method = $this->input->post('method');
        $this->db->trans_start();


        //parçalanan tutarı geopos_invoice tablosuna avans parçalı olarak ekleme

        $data_parcalis = array(
            'code'=>numaric(51),
            'total'=>$amount,
            'notes'=>$desc,
            'eid' => $this->aauth->get_user()->id,
            'csd' => $cari_id,
            'loc' => $this->session->userdata('set_firma_id'),
            'invoice_type_id'=>76,
            'invoice_type_desc'=>invoice_type_id(76),
            'payer'=>customer_details($cari_id)['company'],
            'acid'=>$islem_Details->acid,
            'account'=>$islem_Details->account,
            'method'=>$islem_Details->method,
            'para_birimi'=>$islem_Details->para_birimi,
            'proje_id'=>$proje_id,
        );
        if ($this->db->insert('geopos_invoices', $data_parcalis)) {
            $invoice_transaction_id =  $this->db->insert_id();
            numaric_update(51);
            //parçalanan tutarı geopos_invoice tablosuna avans parçalı olarak ekleme


            $data = array(
                'invoice_id' => $transaction_id,
                'proje_id' => $proje_id,
                'amount' => $amount,
                'cari_id' => $cari_id,
                'invoice_transaction_id' => $invoice_transaction_id,
                'aauth_id' => $this->aauth->get_user()->id,
            );
            if ($this->db->insert('transaction_pay', $data)) {

                if($forma2_id){
                    //forma2'ye bağlanan yer
                    $data_form2_insert =array(
                        'invoice_id'=>$forma2_id,
                        'transaction_id'=>$invoice_transaction_id,
                        'total'=>$amount,
                        'tip'=>1,
                        'method'=>$islem_Details->method,
                    );
                    if ($this->db->insert('geopos_invoice_transactions', $data_form2_insert)) {
                        $this->db->trans_complete();
                        echo json_encode(array('status' => 200,'messages'=>'Başarıyla Kayıt Oluşturuldu'));
                    }
                    //forma2'ye bağlanan yer
                }
                else {
                    $this->db->trans_complete();
                    echo json_encode(array('status' => 200,'messages'=>'Başarıyla Kayıt Oluşturuldu'));
                }



            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410,'messages'=>'Hata Aldınız'));
            }


        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410,'messages'=>'Hata Aldınız'));
        }











    }
    public function delete_pay(){
        $id = $this->input->post('id');
        $forma2_id = $this->input->post('forma2_id');
        if($this->db->delete('transaction_pay', array('id' => $id))){
            $this->aauth->applog("Forma2den Parçalı Ödeme Silindi forma2 ID ".$forma2_id,$this->aauth->get_user()->username);

            echo json_encode(array('status' => 200,'message'=>'Başarıyla Silindi'));
        }
        else {
            echo json_encode(array('status' => 410,'messages'=>'Hata Aldınız'));
        }
    }

    public function update_item_avans(){
        $tip = $this->input->post('tip');
        $id = $this->input->post('id');
        if($tip==0) //delete
        {

            // detayları alacağım
            $det = $this->db->query("SELECT * FROM transaction_pay Where id = $id")->row();
            $invoice_transaction_id = $det->invoice_transaction_id; // parçalı ödemenin finansta gözükmeyen işlemin ID bunuda silememiz lazım

            // detayları alacağım

            if($this->db->delete('transaction_pay', array('id' => $id))){
                $this->db->delete('geopos_invoices', array('id' => $invoice_transaction_id)); // paralanan invoice kaydını sil
                $this->db->delete('geopos_invoice_transactions', array('transaction_id' => $invoice_transaction_id)); // forma2 bağlılığını sil
                $this->aauth->applog("Parçalı Ödeme Silindi",$this->aauth->get_user()->username);

                echo json_encode(array('status' => 200,'message'=>'Başarıyla Silindi'));
            }
            else {
                echo json_encode(array('status' => 410,'messages'=>'Hata Aldınız'));
            }
        }
        elseif($tip==1) //update
        {
            $forma2_id = $this->input->post('forma2_id');
            $proje_id = $this->input->post('proje_id');

            $this->db->set(
                array
                (
                    'proje_id' => $proje_id,
                    'forma2_id' => $forma2_id,
                )
            );

            $this->db->where('id', $id);
            if( $this->db->update('transaction_pay'))
            {
            echo json_encode(array('status' => 200,'message'=>'Başarıyla Güncellendi'));
            }
            else {
                echo json_encode(array('status' => 410,'messages'=>'Hata Aldınız'));
            }

        }
    }

    public function get_info(){
        $forma2_id = $this->input->post('id');
        $details = $this->invocies->invoice_details($forma2_id);
        if($forma2_id){
            echo json_encode(array('status' => 200,'details'=>$details));
        }
        else {
            echo json_encode(array('status' => 410,'messages'=>'Hata Aldınız'));
        }
    }

    public function get_forma_2_details(){
        $forma_2_id = $this->input->post('forma_2_id');
        $details = $this->invocies->invoice_details($forma_2_id);
        $details_items = $this->invocies->invoice_products_forma2($forma_2_id);

        $bill_date = time_to_date_format($details['invoicedate']);

        echo json_encode(array('status' => 200,'details'=>$details,'details_items'=>$details_items,'bill_date'=>$bill_date));


    }


    public function file_handling()
    {
        $this->load->library("Uploadhandler_generic", array(
            'accept_file_types' => '/\.(pdf|gif|jpe?g|png|xlsx)$/i', 'upload_dir' => FCPATH . 'userfiles/formainvoices/', 'upload_url' => base_url() . 'userfile/formainvoices/'

        ));
    }

    public function upload_file(){
        $this->db->trans_start();
        $id = $this->input->post('forma_2_id');
        $image_text = $this->input->post('image_text');
        $data_images = array(
            'file_name' => $image_text,
            'invoices_id' => $id,
            'user_id' =>$this->aauth->get_user()->id ,
        );
        if($this->db->insert('invoices_file', $data_images)){
            $this->aauth->applog("Forma 2  File Yüklendi  : Forma 2 ID : ".$id, $this->aauth->get_user()->username);
            $this->talep_history($id,$this->aauth->get_user()->id,'File Yüklendi',1);
            $this->db->trans_complete();
            echo json_encode(array('status' => 200,'message'=>'Başarıyla Yüklendi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }

    }

    public function delete_file(){
        $this->db->trans_start();

        $id = $this->input->post('file_id');
        $details = $this->db->query("SELECT * FROM invoices_file where id=$id")->row();
        if($this->db->delete('invoices_file', array('id' => $id))){
            $this->aauth->applog("Forma 2  File Silindi  : Forma 2 ID : ".$id, $this->aauth->get_user()->username);

            unlink(FCPATH . 'userfiles/formainvoices/'.$details->file_name);
            unlink(FCPATH . 'userfiles/formainvoices/thumbnail/'.$details->file_name);
            $this->talep_history($id,$this->aauth->get_user()->id,'File Silindi',1);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Silindi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }

    }


    public function price_update(){

        $subtotal = $this->input->post('subtotal');
        $tax = $this->input->post('tax');
        $total = $this->input->post('total');
        $invoice_id = $this->input->post('forma2_id');


        $old_tutar = $this->db->query("SELECT * FROM geopos_invoices where  id =$invoice_id")->row()->total;
        $old_tax = $this->db->query("SELECT * FROM geopos_invoices where  id =$invoice_id")->row()->tax;
        $old_subtotal = $this->db->query("SELECT * FROM geopos_invoices where  id =$invoice_id")->row()->subtotal;

        if($this->db->query("UPDATE geopos_invoices set total = $total,subtotal = $subtotal, tax= $tax WHERE  id = $invoice_id")){

            $this->aauth->applog("Tutar Değiştirildi 
                Yeni Total  $total Old Tutar $old_tutar
                Yeni kdv tutar  $tax kdv tutar $old_tax
                Yeni net tutar  $subtotal Old net tutar $old_subtotal
                 
                 ISLEM ID $invoice_id",$this->aauth->get_user()->username);
            echo json_encode(array('status' => 200, 'message' =>'Başarıyla Güncellenmiştir.'));
        }
        else {

            echo json_encode(array('status' => 410, 'message' =>'Hata Aldınız Lütfen Yöneticiye Başvurun.'));
        }


    }

    public function cancel_talep()
    {
        $this->db->trans_start();
        $result = $this->invocies->cancel_talep();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function cancel_talep_return()
    {
        $this->db->trans_start();
        $result = $this->invocies->cancel_talep_return();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }


}