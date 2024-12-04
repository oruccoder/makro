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



class Invoices_model extends CI_Model

{

    var $table = 'geopos_invoices';
    var $column_order = array('geopos_invoices.invoicedate','geopos_invoices.invoice_no','geopos_invoices.invoice_type_desc','geopos_customers.invoice_no', 'geopos_customers.company', 'geopos_invoices.total', 'geopos_invoices.status',  'geopos_invoices.proje_id');
    var $column_searchf = array('geopos_invoices.invoicedate','geopos_invoices.payer','geopos_invoices.invoice_no','geopos_customers.company', 'geopos_invoices.total', 'geopos_invoices.status',  'geopos_invoices.proje_id');
    var $column_orderf = array('geopos_invoices.invoicedate','geopos_invoices.id','geopos_invoices.invoice_no','geopos_invoices.id', 'geopos_invoices.total', 'geopos_invoices.status',  'geopos_invoices.proje_id');

    var $column_search = array('geopos_customers.company', 'geopos_customers.name', 'geopos_invoices.invoicedate','geopos_invoices.invoice_no' ,'geopos_invoices.total','geopos_invoices.status','geopos_invoices.invoice_type_desc');



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




    public function convert_to_invoice($sipars_detaylari,$note)
    {
        $order_details=$sipars_detaylari['order_details'];
        $order=$sipars_detaylari['order'];


        $currency = 0; // Müşteri Para birimi


        $customer_id = $order['csd'];

        $invocieno =  $order['tid'];
        $depo =  $order['depo_id'];

        $invoicedate = $order['invoicedate'];

        $invocieduedate = $order['invoiceduedate'];
        $proje_id = $order['proje_id'];

        $notes =$note;

        $tax = '';

        $ship_taxtype ='incl';

        $subtotal = rev_amountExchange( $order['subtotal'],$currency);

        $shipping = rev_amountExchange($order['shipping'],$currency);

        $shipping_tax = rev_amountExchange($order['ship_tax'],$currency);

        if($ship_taxtype=='incl') $shipping=0;

        $refer =$order['refer'];

        $total = rev_amountExchange($order['total'],$currency);

        $project = 0;

        $total_tax = $order['tax'];

        $total_discount = $order['discount'];

        $discountFormat = $order['format_discount'];

        $pterms =$order['term'];

        $invoice_type = 1; // Müşterinden gelen sipariş olduğu için satış faturasına çevirelecek.

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

        $transok = true;

        $st_c = 0;

        $this->db->trans_start();

        //Invoice Data

        $bill_date = datefordatabase($invoicedate);

        $bill_due_date = datefordatabase($invocieduedate);

        $data = array(
            'tid' => $invocieno,
            'invoicedate' => $bill_date,
            'invoiceduedate' => $bill_due_date,
            'subtotal' => $subtotal,
            'proje_id' => $proje_id,
            'shipping' => $shipping,
            'ship_tax' => $shipping_tax,
            'invoice_type_id' => $invoice_type,
            'invoice_type_desc' => invoice_type_id($invoice_type),
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
            'multi' => $currency,
            'depo' => $depo,
            'loc' => $this->aauth->get_user()->loc);

        $invocieno2 = $invocieno;

        if ($this->db->insert('geopos_invoices', $data)) {

            $invocieno = $this->db->insert_id();


            $this->db->set(array('invoice_id' => $invocieno));

            $this->db->where('id', $order['id']);

            $this->db->update('geopos_purchase');



            $productlist = array();

            $prodindex = 0;

            $itc = 0;

            foreach ($order_details as $orders)
            {
                $toplam_rulo=0;
                $data = array(

                    'tid' => $invocieno,

                    'pid' => $orders['pid'],

                    'product' => $orders['product'],

                    'code' => $orders['code'],

                    'qty' => $orders['qty'],

                    'price' => rev_amountExchange($orders['price'],$currency),

                    'tax' => rev_amountExchange($orders['tax'],$currency),

                    'discount' => rev_amountExchange($orders['discount'],$currency),

                    'subtotal' => rev_amountExchange($orders['subtotal'],$currency),

                    'totaltax' => rev_amountExchange($orders['totaltax'],$currency),

                    'totaldiscount' => rev_amountExchange($orders['totaldiscount'],$currency),

                    'product_des' => $orders['product_des'],

                    'unit' => $orders['unit'],

                    'invoice_type_id' => $invoice_type,

                    'invoice_type_desc' => invoice_type_id($invoice_type)
                );

                $productlist[$prodindex] = $data;

                $i++;

                $prodindex++;

                $amt = $orders['qty'];
                if ($orders['pid'] > 0) {

                    if($order['sayim_durumu']==0)
                    {
                        $prdid=$orders['pid'];

                        $product_details = $this->db->query("select * from geopos_products WHERE  pid =$prdid ")->row_array();

                        if ($product_details['parent_id'] != 0) {

                            $parent_id = $product_details['parent_id'];
                            if ($product_details['en'] != 0 || $product_details['boy'] != 0) {

                                $m2 = $product_details['en'] * $product_details['boy'] / 10000;

                                $eklenecek_stok=$amt;
                                $toplam_rulo=$eklenecek_stok/$m2;
                            }
                            else
                            {
                                $toplam_rulo=0;
                                $eklenecek_stok = $amt;
                            }




                            $this->stock_update($eklenecek_stok,$parent_id, $invoice_type,$toplam_rulo,$depo); //ana ürüne eklenecek 730

                            $this->stock_update($amt,$orders['pid'], $invoice_type,$toplam_rulo,$depo); //731


                        } else {
                            $this->stock_update($amt,$orders['pid'], $invoice_type,$toplam_rulo,$depo); //731

                        }


                    }



                    $alert=stok_ogren_qty($orders['pid']);



                    //Stok Kontrolü

                    if($invoice_type=='1')
                    {
                        if (($alert - $amt) < 0 AND $st_c == 0) {

                            echo json_encode(array('status' => 'Error', 'message' => 'Ürün - <strong>' . $orders['product'] . "</strong> - az miktarda. Stok Miktarı  " . $alert));

                            $transok = false;

                            $st_c = 1;

                        }
                    }



                }

                $itc += $amt;
            }
            if ($prodindex > 0) {

                $this->db->insert_batch('geopos_invoice_items', $productlist);

                $this->db->set(array('discount' => rev_amountExchange($total_discount,$currency), 'tax' => rev_amountExchange($total_tax,$currency), 'items' => $itc));

                $this->db->where('id', $invocieno);

                $this->db->update('geopos_invoices');



            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "Lütfen ürün listesinden ürün seçiniz. Ürünleri eklemediyseniz, Ürün yöneticisi bölümüne gidin."));

                $transok = false;

            }

            if ($transok) {

                $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));

                $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);

                echo json_encode(array('status' => 'Success', 'message' =>

                    $this->lang->line('Invoice Success') . " <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$invocieno' class='btn btn-indigo btn-lg' target='_blank'><span class='icon-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; <a href='$link' class='btn btn-orange btn-lg'><span class='icon-earth' aria-hidden='true'></span> " . $this->lang->line('Public View') . " </a>"));

            }

        }
        else {

            echo json_encode(array('status' => 'Error', 'message' =>

                "Zorunlu Alanlar"));

            $transok = false;

        }

        if ($transok) {

            if (($this->aauth->get_user()->roleid > 3) AND $project > 0) {



                $data = array('pid' => $project, 'meta_key' => 11, 'meta_data' => $invocieno, 'value' => '0');



                $this->db->insert('geopos_project_meta', $data);



            }

            $this->db->trans_complete();

        } else {

            $this->db->trans_rollback();

        }
        if ($transok) {

            $this->db->from('univarsal_api');

            $this->db->where('univarsal_api.id', 56);

            $query = $this->db->get();

            $auto = $query->row_array();

            if ($auto['key1'] == 1) {

                $this->db->select('name,email');

                $this->db->from('geopos_customers');

                $this->db->where('id', $customer_id);

                $query = $this->db->get();

                $customer = $query->row_array();



                $this->load->model('communication_model');

                $invoice_mail = $this->send_invoice_auto($invocieno, $invocieno2, $bill_date, $total, $currency);

                $attachmenttrue = false;

                $attachment = '';

                $this->communication_model->send_corn_email($customer['email'], $customer['name'], $invoice_mail['subject'], $invoice_mail['message'], $attachmenttrue, $attachment);



            }



            if ($auto['key2'] == 1) {

                $this->db->select('name,phone');

                $this->db->from('geopos_customers');

                $this->db->where('id', $customer_id);

                $query = $this->db->get();

                $customer = $query->row_array();



                $this->load->model('plugins_model', 'plugins');

                $invoice_sms = $this->send_sms_auto($invocieno, $invocieno2, $bill_date, $total, $currency);



                $mobile = $customer['phone'];

                $text_message = $invoice_sms['message'];



                require APPPATH . 'third_party/twilio-php-master/Twilio/autoload.php';



                $sms_service = $this->plugins->universal_api(2);





// Your Account SID and Auth Token from twilio.com/console

                $sid = $sms_service['key1'];

                $token = $sms_service['key2'];

                $client = new Client($sid, $token);





                $message = $client->messages->create(

                // the number you'd like to send the message to

                    $mobile,

                    array(

                        // A Twilio phone number you purchased at twilio.com/console

                        'from' => $sms_service['url'],

                        // the body of the text message you'd like to send

                        'body' => $text_message

                    )

                );





            }



            //kar hesaplama

            $t_profit = 0;

            $this->db->select('geopos_talep_items.unit,geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.product_price');

            $this->db->from('geopos_invoice_items');

            $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');

            $this->db->where('geopos_invoice_items.tid', $invocieno);

            $query = $this->db->get();



            //alis fiyatı ortalama hesaplaması step1:product_id bulma

            $this->db->select('geopos_invoice_items.pid ');

            $this->db->from('geopos_invoice_items');

            $this->db->where('geopos_invoice_items.tid', $invocieno);

            $sql = $this->db->get();



            $alislar = $sql->result_array();

            $product_id=array();

            foreach ($alislar as $products)
            {
                $product_id[] = $products['pid'];
            }





            //alis fiyatı ortalama hesaplaması step1:product_id bulma


            //alis fiyatı ortalama hesaplaması step2:ortalama bulma

            $ort_alis_maliyeti=array();

            foreach($product_id as $p_id)
            {
                $this->db->select('*');

                $this->db->from('geopos_invoice_items');

                $this->db->where('geopos_invoice_items.pid', $p_id);

                $this->db->where('geopos_invoice_items.invoice_type_id', 2);

                $sql_2 = $this->db->get();

                $alislar_2 = $sql_2->result_array();

                $alis_toplam=0;
                $alis_qty_toplam=0;

                if($alislar_2)
                {
                    foreach ($alislar_2 as $value)
                    {
                        $alis_toplam += $value['qty']*$value['price'];
                        $alis_qty_toplam += $value['qty'];

                    }


                    $ort_alis_maliyeti[]=array
                    (
                        'product_id'=>$p_id,
                        'maliyet' =>$alis_toplam/$alis_qty_toplam
                    );
                }





            }

            //alis fiyatı ortalama hesaplaması step2:ortalama bulma





            $pids = $query->result_array();

            $adet_price=array();

            foreach ($pids as $profit) {


                $adet_price[]=array
                (
                    'qty'=>$profit['qty'],
                    'price' =>$profit['price'],
                    'product_id' =>$profit['pid']

                );
            }
            $i=0;

            foreach($ort_alis_maliyeti as $mali)
            {

                if($mali['product_id']==$adet_price[$i]['product_id'])
                {
                    $t_cost = $mali['maliyet'] * $adet_price[$i]['qty']; //toplam alış maliyeti

                    $s_cost = $adet_price[$i]['price'] * $adet_price[$i]['qty'];

                    $t_profit += $s_cost - $t_cost;
                    $i++;
                }

            }

            $data = array('type' => 9, 'rid' => $invocieno, 'col1' => rev_amountExchange($t_profit,$currency), 'd_date' => date('Y-m-d'));


            //kar hesaplamaları
            //eğer satış faturası ise bu tablayo ekleme yapılacak

            if($invoice_type==1)
            {
                $this->db->insert('geopos_metadata', $data);
            }




        }




    }





    public function lastinvoice()

    {

        $this->db->select('tid');

        $this->db->from($this->table);

        $this->db->order_by('id', 'DESC');

        $this->db->limit(1);

        $this->db->where('i_class', 0);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->row()->tid;

        } else {

            return 1000;

        }

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


        $gider = 0;
        $query2 = $this->db->query("SELECT * FROM `talep_to_invoice` Where invoice_id=$id and  tip=1 GROUP BY talep_id");
        if($query2->num_rows()){
            foreach ($query2->result() as $items_talep){
                $talep_id = $items_talep->talep_id;
                $kontrol = $this->db->query("SELECT * FROM talep_form Where id = $talep_id and talep_type=3");
                if($kontrol->num_rows()){
                    $gider++;
                }
            }
        }

        if($gider){
            $details =$this->db->query("SELECT * FROM geopos_invoices Where id = $id AND `invoicedate` <= '2024-05-01 00:00:00'");
//            if($details->num_rows()){
//
//            }
//            else {
//                $this->db->select('*');
//                $this->db->from('geopos_invoice_items');
//                $this->db->where('tid', $id);
//                $query = $this->db->get();
//                return $query->result_array();
//            }

            $this->db->select('geopos_invoice_items.id,geopos_invoice_items.tid,geopos_invoice_items.pid,geopos_cost.name as product,geopos_invoice_items.item_desc,geopos_invoice_items.code,geopos_invoice_items.qty,geopos_invoice_items.price,geopos_invoice_items.tax,geopos_invoice_items.discount,geopos_invoice_items.subtotal,geopos_invoice_items.totaltax,geopos_invoice_items.totaldiscount,geopos_invoice_items.product_des,geopos_invoice_items.i_class,geopos_invoice_items.unit,geopos_invoice_items.fire,geopos_invoice_items.fire_quantity,geopos_invoice_items.invoice_type_desc,geopos_invoice_items.last_balance,geopos_invoice_items.kdv_last_balance,geopos_invoice_items.proje_id,geopos_invoice_items.bolum_id,geopos_invoice_items.asama_id,geopos_invoice_items.depo_id,geopos_invoice_items.tax_type,geopos_invoice_items.fire_qty_total,geopos_invoice_items.invoice_type_id,geopos_invoice_items.status,geopos_invoice_items.gider_durumu,geopos_invoice_items.gider_id,');
            $this->db->from('geopos_invoice_items');
            $this->db->join('geopos_cost','geopos_invoice_items.pid=geopos_cost.id','LEFT');
            $this->db->where('geopos_invoice_items.tid', $id);
            $query = $this->db->get();
            return $query->result_array();
        }
        else {
            $this->db->select('*');
            $this->db->from('geopos_invoice_items');
            $this->db->where('tid', $id);
            $query = $this->db->get();
            return $query->result_array();
        }






    }

    public function invoice_products_forma2($id)

    {



        $this->db->select('*');

        $this->db->from('geopos_invoice_items');

        $this->db->where('tid', $id);

        $this->db->order_by('geopos_invoice_items.pid','ASC');

        $query = $this->db->get();

        return $query->result();



    }

    public function invoice_gecmisi($id,$tip)

    {

        if($tip==1)
        {
            //fatura ödemeleri
            $this->db->where('geopos_invoices.invoice_type_id', 17);
        }
        else  if($tip==2)
        {
            // KDV Ödemeleri
            $this->db->where('geopos_invoices.invoice_type_id', 19);
        }
        if($tip==4)
        {
            //fatura Tahsilatları
            $this->db->where('geopos_invoices.invoice_type_id', 18);
        }
        else  if($tip==5)
        {
            // KDV tahsilatları
            $this->db->where('geopos_invoices.invoice_type_id', 20);
        }

        $this->db->select('
        geopos_invoice_transactions.id,
        geopos_invoice_transactions.invoice_id,
        geopos_invoice_transactions.transaction_id,
        geopos_invoice_transactions.total,
        geopos_invoice_transactions.kur_degeri,
        geopos_invoice_transactions.para_birimi as int_pb,
        geopos_invoice_transactions.tip,
        geopos_invoices.invoicedate as date,

        geopos_invoices.method,geopos_invoices.credit,
        geopos_invoices.total as debit,geopos_invoices.account,
        geopos_invoices.invoice_type_desc,
        geopos_invoices.last_balance,
        geopos_invoices.kdv_last_balance');

        $this->db->from('geopos_invoice_transactions');
        $this->db->join('geopos_invoices','geopos_invoice_transactions.transaction_id=geopos_invoices.id');

        $this->db->where('geopos_invoice_transactions.invoice_id', $id);


        $query = $this->db->get();

        return $query->result_array();

    }
    public function rulo_miktari_sorgula($id)

    {



        $this->db->select('geopos_invoice_items.*,geopos_products.toplam_rulo');

        $this->db->from('geopos_invoice_items');

        $this->db->where('geopos_invoice_items.tid', $id);

        $this->db->join('geopos_products', 'geopos_invoice_items.pid=geopos_products.pid', 'left');

        $query = $this->db->get();

        $querys = $query->result_array();

        $data=0;

        foreach ($querys as $queryss)
        {
            if($queryss['toplam_rulo']!=0)
            {
                $data = 1;
            }

        }

        return $data;





    }



    public function currencies()

    {



        $this->db->select('*');

        $this->db->from('geopos_currencies');

        $query = $this->db->get();

        return $query->result_array();

    }



    public function currency_d($id)

    {

        $this->db->select('*');

        $this->db->from('geopos_currencies');

        $this->db->where('id', $id);

        $query = $this->db->get();

        return $query->row_array();

    }



    public function warehouses()

    {

        $this->db->select('*');

        $this->db->from('geopos_warehouse');

        if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

            $this->db->or_where('loc', 0);

        }



        $query = $this->db->get();



        return $query->result_array();



    }



    public function invoice_transactions($id)

    {



        $this->db->select('*');

        $this->db->from('geopos_transactions');

        $this->db->where('tid', $id);

        $this->db->where('ext', 0);


        $query = $this->db->get();

        return $query->result_array();



    }



    public function invoice_delete($id, $eid = '')

    {

        $this->db->trans_start();

        $this->db->select('*');

        $this->db->from('geopos_invoices');

        $this->db->where('id', $id);

        $query = $this->db->get();

        $result = $query->row_array();

        $invoice_type=$result['invoice_type_id'];

        if($result['status'] == '3')
        {

            $res = $this->db->delete('geopos_invoices', array('id' => $id));



            $affect=$this->db->affected_rows();



            if ($res) {

                if ($result['status'] == 3) {

                    $this->db->select('pid,qty');

                    $this->db->from('geopos_invoice_items');

                    $this->db->where('tid', $id);

                    $query = $this->db->get();

                    $prevresult = $query->result_array();

                    if($affect)  $this->db->delete('geopos_invoice_items', array('tid' => $id));



                    $data = array('type' => 9, 'rid' => $id);

                    $this->db->delete('geopos_metadata', $data);



                    if ($this->db->trans_complete()) {

                        return true;

                    } else {

                        return false;

                    }

                }

                else
                {
                    return false;
                }


            }
        }

        else
        {
            return false;
        }



    }





        private function _get_datatables_query($opt = '')

    {

        // $where='geopos_invoices.i_class=0 and (geopos_invoices.invoice_type_id=21 or geopos_invoices.invoice_type_id=2 or geopos_invoices.invoice_type_id=1 or geopos_invoices.invoice_type_id=7 or geopos_invoices.invoice_type_id=8)';

        $this->db->select('geopos_invoices.discount,geopos_invoices.csd,geopos_invoices.proje_id,geopos_invoices.notes,geopos_invoices.alt_cari_id,geopos_invoices.eid,geopos_invoices.notes,geopos_invoices.invoice_name,geopos_invoices.invoice_no,geopos_invoices.id,geopos_invoices.invoice_type_id,geopos_invoices.tid,geopos_invoices.invoicedate,geopos_invoices.invoiceduedate,geopos_invoices.total,geopos_invoices.tax,geopos_invoices.subtotal,geopos_invoices.status,geopos_customers.company as name,geopos_invoices.para_birimi');

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


    //Forma 2
    function get_datatables_form2($opt = '')

    {

        $this->_get_datatables_query_form2($opt);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();


       // echo $this->db->last_query();die();

        return $query->result();

    }

    private function _get_datatables_query_form2($opt = '')

    {

        $auth_id = $this->aauth->get_user()->id;
        $this->db->select('geopos_invoices.*,geopos_employees.name as pers_name,invoice_status.name as st_name,geopos_projects.code as proje_name');
        $this->db->from('geopos_invoices');
        $this->db->join('geopos_employees','geopos_invoices.eid=geopos_employees.id','LEFT');
        $this->db->join('geopos_projects','geopos_invoices.proje_id=geopos_projects.id');
        $this->db->join('invoice_status','geopos_invoices.status=invoice_status.id');
        $this->db->join('invoices_onay_new','geopos_invoices.id=invoices_onay_new.invoices_id');
        $this->db->where("invoices_onay_new.type",2);
        $this->db->where("invoices_onay_new.staff",1);
        $this->db->where("geopos_invoices.status!=",3);

//        $this->db->where("geopos_invoices.status",1);
        $this->db->where("invoices_onay_new.user_id",$auth_id);
        $i = 0;
        foreach ($this->column_searchf as $item) // loop column

            {
                if($_POST){
                    if ($_POST['search']['value']) // if datatable send POST for search

                    {
                        if ($i === 0) // first loop

                        {
                            $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                            $this->db->like($item, $_POST['search']['value']);

                        } else {

                            $this->db->or_like($item, $_POST['search']['value']);

                        }

                        if (count($this->column_searchf) - 1 == $i) //last loop

                            $this->db->group_end(); //close bracke
                    }

                    $i++;
                }


            }
        $this->db->order_by('`geopos_invoices`.`id` DESC');


//        $where='geopos_invoices.i_class=0 and (geopos_invoices.invoice_type_id=29 or geopos_invoices.invoice_type_id=30)';
//
//        $this->db->select('geopos_invoices.muqavele_no,geopos_invoices.forma2_notes,geopos_invoices.proje_id,geopos_invoices.refer,geopos_invoices.invoice_no,geopos_invoices.id,geopos_invoices.invoice_type_id,geopos_invoices.tid,geopos_invoices.invoicedate,geopos_invoices.invoiceduedate,geopos_invoices.total,geopos_invoices.status,geopos_customers.company as name,geopos_invoices.para_birimi');
//
//        $this->db->from($this->table);
//
//
//        $this->db->where($where);
//
//        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
//        {
//            $this->db->where('DATE(geopos_invoices.invoicedate) >=', datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
//            $this->db->where('DATE(geopos_invoices.invoicedate) <=', datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
//        }
//        if ($this->input->post('proje_id')) // if datatable send POST for search
//        {
//            $this->db->where('geopos_invoices.proje_id=', $this->input->post('proje_id')); //2019-11-23 14:28:57
//        }
//
//        if ($this->input->post('status')) // if datatable send POST for search
//        {
//            $this->db->where('geopos_invoices.status=', $this->input->post('status')); //2019-11-23 14:28:57
//        }
//
//
//
//        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');
//
//
//
//        $i = 0;
//
//
//
//        foreach ($this->column_searchf as $item) // loop column
//
//        {
//
//            if ($_POST['search']['value']) // if datatable send POST for search
//
//            {
//
//
//
//                if ($i === 0) // first loop
//
//                {
//
//                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
//
//                    $this->db->like($item, $_POST['search']['value']);
//
//                } else {
//
//                    $this->db->or_like($item, $_POST['search']['value']);
//
//                }
//
//
//
//                if (count($this->column_searchf) - 1 == $i) //last loop
//
//                    $this->db->group_end(); //close bracket
//
//            }
//
//            $i++;
//
//        }
//
//
//
//        if (isset($_POST['order'])) // here order processing
//
//        {
//
//            $this->db->order_by($this->column_orderf[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
//
//        } else if (isset($this->orderf)) {
//
//            $order = $this->orderf;
//
//            $this->db->order_by('id','desc');
//
//        }


    }


    public function count_all_forma_2($opt = '')

    {

        $this->_get_datatables_query_form2();

        return $this->db->count_all_results();

    }

    function count_filtered_forma_2($opt = '')

    {

        $this->_get_datatables_query_form2();

        if ($opt) {

            $this->db->where('geopos_invoices.eid', $opt);

        }



        $query = $this->db->get();

        return $query->num_rows();

    }

    //Forma 2



    function get_datatables($opt = '')

    {

        $this->_get_datatables_query($opt);


        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();




        return $query->result();

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





    public function billingterms()

    {

        $this->db->select('id,title');

        $this->db->from('geopos_terms');

        $this->db->where('type', 1);

        $this->db->or_where('type', 0);

        $query = $this->db->get();

        return $query->result_array();

    }



    public function employee($id)

    {

        $this->db->select('geopos_employees.name,geopos_employees.sign,geopos_users.roleid');

        $this->db->from('geopos_employees');

        $this->db->where('geopos_employees.id', $id);

        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');

        $query = $this->db->get();

        return $query->row_array();

    }



    public function meta_insert($id, $type, $meta_data)

    {

        $data = array('type' => $type, 'rid' => $id, 'col1' => $meta_data);

        if ($id) {

            return $this->db->insert('geopos_metadata', $data);

        } else {

            return 0;

        }

    }



    public function attach($id)

    {

        $this->db->select('geopos_metadata.*');

        $this->db->from('geopos_metadata');

        $this->db->where('geopos_metadata.type', 1);

        $this->db->where('geopos_metadata.rid', $id);

        $query = $this->db->get();

        return $query->result_array();

    }



    public function meta_delete($id, $type, $name)

    {

        if (@unlink(FCPATH . 'userfiles/attach/' . $name)) {

            return $this->db->delete('geopos_metadata', array('rid' => $id, 'type' => $type, 'col1' => $name));

        }

    }



    public function gateway_list($enable = '')

    {

        $this->db->from('geopos_gateways');

        if ($enable == 'Yes') {

            $this->db->where('enable', 'Yes');

        }

        $query = $this->db->get();

        return $query->result_array();

    }


    public function stock_update($amt,$product_id,$invoice_type,$toplam_rulo,$depo)
    {

        $prd_deta = $this->db->query("select * from geopos_products WHERE  pid = $product_id")->row_array();

        $toplam_agirlik=0;

        if($prd_deta['en']!=0 || $prd_deta['boy']!=0 )
        {

            $en = $prd_deta['en']; //200
            $boy = $prd_deta['boy']; //20000
            $metrekare_agirligi = $prd_deta['metrekare_agirligi']/1000; //kg çevrildi
            $toplam_m2=$amt;
            $toplam_agirlik=$metrekare_agirligi*$toplam_m2;
        }


        else
        {
            $metrekare_agirligi = $prd_deta['metrekare_agirligi']/1000; //kg çevrildi
            $toplam_agirlik=$metrekare_agirligi*$amt;
        }

        $operator1="qty-$amt";
        $operator2="toplam_agirlik-$toplam_agirlik";
        $operator3= "toplam_rulo-$toplam_rulo";


        if($invoice_type==1)
        {

            $operator1= "qty-$amt";
            $operator2= "toplam_agirlik-$toplam_agirlik";
            $operator3= "toplam_rulo-$toplam_rulo";

        }
        else if($invoice_type==2)
        {
            $operator1= "qty+$amt";
            $operator2= "toplam_agirlik+$toplam_agirlik";
            $operator3= "toplam_rulo+$toplam_rulo";
        }

        else if($invoice_type==7)
        {
            $operator1= "qty+$amt";
            $operator2= "toplam_agirlik+$toplam_agirlik";
            $operator3= "toplam_rulo+$toplam_rulo";
        }

        else if($invoice_type==8)
        {
            $operator1= "qty-$amt";
            $operator2= "toplam_agirlik-$toplam_agirlik";
            $operator3= "toplam_rulo-$toplam_rulo";
        }


        $this->db->set('qty', "$operator1", FALSE);
        $this->db->set('toplam_agirlik', "$operator2", FALSE);
        $this->db->set('toplam_rulo', "$operator3", FALSE);

        $this->db->where('pid', $product_id);
        $this->db->update('geopos_products');


        $this->db->set('qty', "$operator1", FALSE);

        $this->db->set('loc', "5", FALSE);

        $this->db->where('product_id', $product_id);

        $this->db->where('warehouse_id', $depo);

        $this->db->update('geopos_product_to_warehouse');
    }

    public function hizmetler()
    {
        $this->db->select('*');

        $this->db->from('geopos_todolist');
        $this->db->where('rid!=0');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function stock_product_price($invoice_id,$date,$product_id,$amt,$depo,$p_price,$p_tax,$p_discount,$p_subtotal,$p_total_tax,$p_total_discount,$kur_degeri,$para_birimi)
    {
        $this->db->delete('geopos_product_price', array('invoice_id' => $invoice_id,'product_id'=>$product_id));

        //insert
        $data = array(
            'invoice_id' => $invoice_id,
            'date' => $date,
            'product_id' => $product_id,
            'quantity' => $amt,
            'depo_id' => $depo,
            'price' => $p_price,
            'tax' => $p_tax,
            'discount' => $p_discount,
            'subtotal' => $p_subtotal,
            'totaltax' => $p_total_tax,
            'totaldiscount' => $p_total_discount,
            'kur_degeri' => $kur_degeri,
            'para_birimi' => $para_birimi,
            'loc'=>$this->aauth->get_user()->loc
        );


        $this->db->insert('geopos_product_price', $data);


        $this->db->set(array('guncel_maliyet_price' => $p_price));

        $this->db->where('pid', $product_id);

        $this->db->update('geopos_products');



    }

    function get_datatables_onay($opt = '')

    {

        $user_id=$this->aauth->get_user()->id;

        $start=$_POST['start'];
        $len=$_POST['length'];

        $query=$this->db->query("SELECT 1 as tip,geopos_invoices.id,geopos_invoices.para_birimi,geopos_invoices.invoicedate,geopos_invoices.invoice_no,
geopos_invoices.notes,geopos_invoices.proje_id,geopos_invoices.total FROM geopos_invoices WHERE geopos_invoices.status=1  and geopos_invoices.invoice_type_id IN(2)
UNION ALL SELECT 2 as tip,geopos_talep_items.id,1 as para_birimi,geopos_talep.olusturma_tarihi as
invoicedate,geopos_talep.talep_no as invoice_no,geopos_talep_items.product_name as
notes,geopos_talep.proje_id,geopos_talep_items.subtotal FROM geopos_talep_items LEFT JOIN
 geopos_onay ON geopos_talep_items.product_id=geopos_onay.product_id INNER JOIN geopos_talep
  ON geopos_talep_items.tip=geopos_talep.id WHERE


( (geopos_onay.satinalma_status=1  and  geopos_talep.satinalma_mudur_id=$user_id) or (geopos_onay.proje_sorumlusu_status=1
and geopos_talep.proje_sorumlusu_id=$user_id) or (geopos_onay.proje_muduru_status=1  and geopos_talep.proje_muduru_id=$user_id)
or ( geopos_onay.finans_status=1 and geopos_talep.finans_departman_pers_id=$user_id) or (geopos_onay.genel_mudur_status=1 and
geopos_talep.genel_mudur_id=$user_id) or (geopos_onay.satinalma_personeli_status=1 and geopos_talep.satinalma_mudur_id=$user_id))
 GROUP BY id
 LIMIT $start,$len");







        return $query->result();

    }



    function count_filtered_onay($opt = '')

    {

        $user_id=$this->aauth->get_user()->id;

        $query=$this->db->query("SELECT 1 as tip,geopos_invoices.id,geopos_invoices.para_birimi,geopos_invoices.invoicedate,geopos_invoices.invoice_no,
geopos_invoices.notes,geopos_invoices.proje_id,geopos_invoices.total FROM geopos_invoices WHERE geopos_invoices.status=1
UNION ALL SELECT 2 as tip,geopos_talep_items.id,1 as para_birimi,geopos_talep.olusturma_tarihi as
invoicedate,geopos_talep.talep_no as invoice_no,geopos_talep_items.product_name as
notes,geopos_talep.proje_id,geopos_talep_items.subtotal FROM geopos_talep_items LEFT JOIN
 geopos_onay ON geopos_talep_items.product_id=geopos_onay.product_id INNER JOIN geopos_talep
  ON geopos_talep_items.tip=geopos_talep.id WHERE


( (geopos_onay.satinalma_status=1  and  geopos_talep.satinalma_mudur_id=$user_id) or (geopos_onay.proje_sorumlusu_status=1
and geopos_talep.proje_sorumlusu_id=$user_id) or (geopos_onay.proje_muduru_status=1  and geopos_talep.proje_muduru_id=$user_id)
or ( geopos_onay.finans_status=1 and geopos_talep.finans_departman_pers_id=$user_id) or (geopos_onay.genel_mudur_status=1 and
geopos_talep.genel_mudur_id=$user_id) or (geopos_onay.satinalma_personeli_status=1 and geopos_talep.satinalma_mudur_id=$user_id))");


        return $query->num_rows();

    }



    public function count_all_onay($opt = '')

    {

        $user_id=$this->aauth->get_user()->id;

        $query=$this->db->query("SELECT 1 as tip,geopos_invoices.id,geopos_invoices.para_birimi,geopos_invoices.invoicedate,geopos_invoices.invoice_no,
geopos_invoices.notes,geopos_invoices.proje_id,geopos_invoices.total FROM geopos_invoices WHERE geopos_invoices.status=1
UNION ALL SELECT 2 as tip,geopos_talep_items.id,1 as para_birimi,geopos_talep.olusturma_tarihi as
invoicedate,geopos_talep.talep_no as invoice_no,geopos_talep_items.product_name as
notes,geopos_talep.proje_id,geopos_talep_items.subtotal FROM geopos_talep_items LEFT JOIN
 geopos_onay ON geopos_talep_items.product_id=geopos_onay.product_id INNER JOIN geopos_talep
  ON geopos_talep_items.tip=geopos_talep.id WHERE


( (geopos_onay.satinalma_status=1  and  geopos_talep.satinalma_mudur_id=$user_id) or (geopos_onay.proje_sorumlusu_status=1
and geopos_talep.proje_sorumlusu_id=$user_id) or (geopos_onay.proje_muduru_status=1  and geopos_talep.proje_muduru_id=$user_id)
or ( geopos_onay.finans_status=1 and geopos_talep.finans_departman_pers_id=$user_id) or (geopos_onay.genel_mudur_status=1 and
geopos_talep.genel_mudur_id=$user_id) or (geopos_onay.satinalma_personeli_status=1 and geopos_talep.satinalma_mudur_id=$user_id))");

        $query=$query->result();

        return count($query);

    }





    function get_datatables_onay_talep($opt = '')

    {

        /*
        $user_id=$this->aauth->get_user()->id;

        $start=$_POST['start'];
        $len=$_POST['length'];


        $role_id = $this->aauth->get_user()->roleid;


        $querys=$this->db->query("
SELECT * FROM `geopos_onay` WHERE `proje_sorumlusu_status` = 1 or `proje_muduru_status` = 1 or `genel_mudur_status` = 1 or `bolum_muduru_status` = 1  or finans_status=1
 GROUP BY geopos_onay.file_id ORDER BY  geopos_onay.file_id DESC
");


        //$array = array_unique (array_merge ($query, $querys));


        //return (object)$array;
        return $querys->result();


        */

        $data = $this->_get_datatables_onay_talep();



        if ($this->input->post('length') != -1)

            //$this->db->limit($this->input->post('length'), $this->input->post('start'));
            $array = array_slice($data,$this->input->post('start'),$this->input->post('length'));

        return $array;

        //$query = $this->db->get();

        //return $query->result();

    }
    private function _get_datatables_onay_talep(){

//        $this->db->select('*');
//        $this->db->from('geopos_onay');
//        $this->db->or_where('proje_sorumlusu_status', 1);
//        $this->db->or_where('proje_muduru_status', 1);
//        $this->db->or_where('genel_mudur_status', 1);
//        $this->db->or_where('bolum_muduru_status', 1);
//        $this->db->or_where('finans_status', 1);
//        $this->db->group_by('file_id');
//        $this->db->order_by('file_id','DESC');
//        $query = $this->db->get();

//        $query=$this->db->query("
//SELECT * FROM `geopos_onay` WHERE  (`proje_sorumlusu_status` = 1 or `proje_muduru_status` = 1 or `genel_mudur_status` = 1 or `bolum_muduru_status` = 1  or finans_status=1) and `open`= 0
// GROUP BY geopos_onay.file_id ORDER BY  geopos_onay.file_id DESC
//");

        $query_avans=$this->db->query("
SELECT geopos_onay.*, 0 as invoice_type_id FROM `geopos_onay`
    Inner JOIN geopos_talep on geopos_talep.id = geopos_onay.file_id

WHERE geopos_talep.tip=5 and  geopos_talep.visable_status=1 and geopos_talep.bildirim_durumu=1 and   
      (geopos_onay.proje_sorumlusu_status = 1 or geopos_onay.proje_muduru_status = 1
   or geopos_onay.genel_mudur_status = 1 or geopos_onay.bolum_muduru_status = 1  or geopos_onay.finans_status=1) 
  and geopos_onay.open= 0 and geopos_talep.status NOT IN (6,4)
 GROUP BY geopos_onay.file_id ORDER BY  geopos_onay.file_id DESC
")->result();

        $query_gider=$this->db->query("
SELECT geopos_onay.*, 0 as invoice_type_id FROM `geopos_onay`
    Inner JOIN geopos_talep on geopos_talep.id = geopos_onay.file_id

WHERE geopos_talep.tip=4 and geopos_talep.visable_status=1 and geopos_talep.bildirim_durumu=1 and   (geopos_onay.proje_sorumlusu_status = 1 or geopos_onay.proje_muduru_status = 1 or geopos_onay.genel_mudur_status = 1 or geopos_onay.bolum_muduru_status = 1  or geopos_onay.finans_status=1) and geopos_onay.open= 0 and geopos_talep.status NOT IN (6,4)
 GROUP BY geopos_onay.file_id ORDER BY  geopos_onay.file_id DESC
")->result();

//        $query_satinalma=$this->db->query("
//SELECT geopos_onay.*, 0 as invoice_type_id FROM `geopos_onay`
//    Inner JOIN geopos_talep on geopos_talep.id = geopos_onay.file_id
//
//WHERE geopos_talep.tip=2 and geopos_talep.visable_status=1 and geopos_talep.bildirim_durumu=1 and
//      ( geopos_onay.proje_muduru_status = 1 or geopos_onay.genel_mudur_status = 1
//             or geopos_onay.finans_status=1)
//  and geopos_onay.open= 0 and geopos_talep.status NOT IN (6,4)
// GROUP BY geopos_onay.file_id ORDER BY  geopos_onay.file_id DESC
//")->result();
//
//        $query_malzemetalep=$this->db->query("
//SELECT geopos_onay.*, 0 as invoice_type_id FROM `geopos_onay`
//    Inner JOIN geopos_talep on geopos_talep.id = geopos_onay.file_id
//
//WHERE geopos_talep.tip=1 and geopos_talep.visable_status=1 and geopos_talep.bildirim_durumu=1 and   (geopos_onay.proje_sorumlusu_status = 1 or geopos_onay.proje_muduru_status = 1 or geopos_onay.genel_mudur_status = 1 or geopos_onay.bolum_muduru_status = 1  or geopos_onay.finans_status=1) and geopos_onay.open= 0 and geopos_talep.status NOT IN (6,4)
// GROUP BY geopos_onay.file_id ORDER BY  geopos_onay.file_id DESC
//")->result();

        $query2=$this->db->query("SELECT geopos_onay.*,geopos_invoices.invoice_type_id FROM `geopos_onay` LEFT JOIN geopos_invoices on geopos_invoices.id = geopos_onay.file_id WHERE geopos_invoices.invoice_type_id IN(29,30) and geopos_invoices.bildirim_durumu=1 ORDER BY `geopos_onay`.`id`;
")->result();

        $query3=$this->db->query("SELECT geopos_onay.*,2 as invoice_type_id FROM `geopos_onay` LEFT JOIN lojistik_talep on lojistik_talep.id = geopos_onay.file_id WHERE lojistik_talep.status NOT IN(3) and lojistik_talep.bildirim_durumu=1 and geopos_onay.type=11 ORDER BY `geopos_onay`.`id`;
")->result();
        $query4=$this->db->query("SELECT geopos_onay.*,3 as invoice_type_id FROM `geopos_onay` INNER JOIN lojistik_satinalma_talep on lojistik_satinalma_talep.id = geopos_onay.file_id WHERE lojistik_satinalma_talep.status NOT IN(3) and lojistik_satinalma_talep.bildirim_durumu=1 and geopos_onay.type=12 ORDER BY `geopos_onay`.`id`;
")->result();



        //$array = array_merge($query_malzemetalep,$query_satinalma,$query_gider,$query_avans,$query2,$query3,$query4);
        $array = array_merge($query_gider,$query_avans,$query2,$query3,$query4);


        $role_id = $this->aauth->get_user()->roleid;
        $user_id =$this->aauth->get_user()->id;

        $data = [];

        foreach ($array as $invoices ){

            $talep_id=$invoices->file_id;
            $durum=0;
            if($invoices->invoice_type_id==29 || $invoices->invoice_type_id==30){
                $durum =1;
            }
            else if($invoices->invoice_type_id==2){
                $durum =2;
            }
            else if($invoices->invoice_type_id==3){
                $durum =3;
            }


            $kontrol=satinalma_onay($talep_id,$role_id,$user_id,$durum);


            if($kontrol==0)
            {
                $data[] = $invoices;
            }
        }

        return $data;


    }



    function count_filtered_onay_talep($opt = '')

    {
        /*

        $user_id=$this->aauth->get_user()->id;

        $query=$this->db->query("SELECT * FROM `geopos_onay` WHERE `proje_sorumlusu_status` = 3 AND `proje_muduru_status` = 3 AND `genel_mudur_status` = 1 AND `bolum_muduru_status` = 3 ORDER BY `genel_mudur_status` ASC

 ");
         return $query->num_rows();

        */


        $data = $this->_get_datatables_onay_talep();


        return count($data);


    }



    public function count_all_onay_talep($opt = '')

    {


        $data = $this->_get_datatables_onay_talep();


        return count($data);

    }





    function get_datatables_gorusmeler($opt = '')

    {

        $this->_get_datatables_query_gorusmeler($opt);


        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();




        return $query->result();

    }



    function count_filtered_gorusmeler($opt = '')

    {

        $this->_get_datatables_query_gorusmeler($opt);





        $query = $this->db->get();

        return $query->num_rows();

    }



    public function count_all_gorusmeler($opt = '')

    {

        $user_id=$this->aauth->get_user()->id;
        $this->db->select('geopos_invoices.id');

        $this->db->from('geopos_notes');

        $this->db->where('geopos_notes.pers_id', $user_id);
        $this->db->where('geopos_notes.status', 0);


        return $this->db->count_all_results();

    }

    private function _get_datatables_query_gorusmeler($opt = '')

    {

        $user_id=$this->aauth->get_user()->id;
        $this->db->select('*');

        $this->db->from('geopos_notes');

        $this->db->where('geopos_notes.status', '0');
        $this->db->where('geopos_notes.pers_id', $user_id);



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

            $this->db->order_by('geopos_notes.cdate','DESC');



        }



    }



    function get_datatables_randevu($opt = '')

    {

        $this->_get_datatables_query_randevu($opt);


        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();




        return $query->result();

    }



    function count_filtered_randevu($opt = '')

    {

        $this->_get_datatables_query_randevu($opt);





        $query = $this->db->get();

        return $query->num_rows();

    }



    public function count_all_randevu($opt = '')

    {

        $user_id=$this->aauth->get_user()->id;
        $this->db->select('geopos_events.id');

        $this->db->from('geopos_events');

        $this->db->like('geopos_events.pers_id', $user_id);
        $this->db->where('geopos_events.status', 0);


        return $this->db->count_all_results();

    }

    private function _get_datatables_query_randevu($opt = '')

    {

        $user_id=$this->aauth->get_user()->id;
        $this->db->select('*');

        $this->db->from('geopos_events');

        $this->db->where('geopos_events.pers_id', $user_id);
        $this->db->where('geopos_events.status', 0);


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

            $this->db->order_by('geopos_events.etkinlik_saati','DESC');



        }



    }


    function get_datatables_depo_urunler($opt = '')

    {

        $this->_get_datatables_depo_urunler($opt);


        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();




        return $query->result();

    }


    private function _get_datatables_depo_urunler($opt = '')

    {
        $user_id =$this->aauth->get_user()->id;
        $this->db->select('geopos_talep_items.id,
        geopos_talep.talep_no,
        geopos_talep.proje_name,
        geopos_talep_items.firma,
        geopos_talep_items.product_name,
        geopos_talep_items.qty,
        geopos_talep_items.unit,
        geopos_talep_items.teslim_tarihi_item,
        geopos_talep.tip,
        geopos_talep.bolum_mudur_id,
        geopos_talep_items.depo_alim_durumu,
        geopos_talep_items.product_id
        ');

        $this->db->from('geopos_onay');



        $this->db->where('geopos_onay.genel_mudur_status',3);
        $this->db->where('geopos_talep.bolum_mudur_id', $user_id);

        if($this->input->post('status_id')) //
        {
            $type=array($this->input->post('status_id'));
        }
        else
        {
            if($this->input->post('tip')==1) // depo için ekrana
            {
                $type=array(1,3);
            }
            else if($this->input->post('tip')==2) // tehvil alınanlar
            {
                $type=array(2);
            }
            else
            {
                $type=array(1,2,3,4,5,6);
            }
        }


        $this->db->where_in('geopos_talep_items.depo_alim_durumu',$type);





        if($this->input->post('talep_no')) //
        {
            $this->db->where('geopos_talep.id',$this->input->post('talep_no'));
        }
        if($this->input->post('proje_id')) //
        {
            $this->db->where('geopos_talep.proje_id',$this->input->post('proje_id'));
        }
        if($this->input->post('firma_id')) //
        {
            $this->db->where('geopos_talep_items.firma',$this->input->post('firma_id'));
        }



        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_talep_items.teslim_tarihi_item) >=', datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where('DATE(geopos_talep_items.teslim_tarihi_item) <=', datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
        }


        $this->db->where('geopos_talep.tip',2);

        $this->db->join('geopos_talep_items', 'geopos_onay.malzeme_items_id=geopos_talep_items.id ');
        $this->db->join('geopos_talep', 'geopos_talep.id=geopos_talep_items.tip');


        $i = 0;



        foreach ($this->column_search_depo as $item) // loop column

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



                if (count($this->column_search_depo) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order_depo[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else {

            $this->db->order_by('geopos_talep.id','DESC');



        }



    }

    function count_filtered_depo_urunler($opt = '')

    {

        $user_id =$this->aauth->get_user()->id;
        $this->db->select('geopos_talep_items.id,
        geopos_talep.talep_no,
        geopos_talep.proje_name,
        geopos_talep_items.firma,
        geopos_talep_items.product_name,
        geopos_talep_items.qty,
        geopos_talep_items.unit,
        geopos_talep.tip,
        geopos_talep_items.depo_alim_durumu
        ');

        $this->db->from('geopos_onay');



        $this->db->where('geopos_onay.genel_mudur_status',3);

        if($this->input->post('status_id')) //
        {
            $type=array($this->input->post('status_id'));
        }
        else
        {
            if($this->input->post('tip')==1) // depo için ekrana
            {
                $type=array(1,3);
            }
            else if($this->input->post('tip')==2) // tehvil alınanlar
            {
                $type=array(2);
            }
            else
            {
                $type=array(1,2,3,4,5,6);
            }
        }


        $this->db->where_in('geopos_talep_items.depo_alim_durumu',$type);


        $this->db->where('geopos_talep.bolum_mudur_id', $user_id);


        if($this->input->post('talep_no')) //
        {
            $this->db->where('geopos_talep.id',$this->input->post('talep_no'));
        }
        if($this->input->post('proje_id')) //
        {
            $this->db->where('geopos_talep.proje_id',$this->input->post('proje_id'));
        }
        if($this->input->post('firma_id')) //
        {
            $this->db->where('geopos_talep_items.firma',$this->input->post('firma_id'));
        }



        $this->db->where('geopos_talep.tip',2);

        $this->db->join('geopos_talep_items', 'geopos_onay.malzeme_items_id=geopos_talep_items.id ');
        $this->db->join('geopos_talep', 'geopos_talep.id=geopos_talep_items.tip');

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function count_all_depo_urunler($opt = '')

    {

        $this->_get_datatables_depo_urunler($opt);

        return $this->db->count_all_results();


    }




    function get_datatables_depo_dosyalar($opt = '')
    {

        $this->_get_datatables_depo_dosyalar($opt);


        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();




        return $query->result();

    }


    private function _get_datatables_depo_dosyalar($opt = '')

    {
        $user_id =$this->aauth->get_user()->id;
        $this->db->select('*');

        $this->db->from('geopos_depo_onay');

        if ($this->aauth->get_user()->roleid == 5)
        {
            $this->db->where('geopos_depo_onay.user_id', $user_id);
        }


        $i = 0;



        foreach ($this->column_search_dosya as $item) // loop column

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



                if (count($this->column_search_dosya) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order_dosya[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else {

            $this->db->order_by('geopos_depo_onay.id','DESC');



        }

        $this->db->group_by('geopos_depo_onay.tehvil_id');



    }

    function count_filtered_depo_dosyalar($opt = '')

    {

        $user_id =$this->aauth->get_user()->id;
        $this->db->select('*');

        $this->db->from('geopos_depo_onay');

        if ($this->aauth->get_user()->roleid == 5)
        {
            $this->db->where('geopos_depo_onay.user_id', $user_id);
        }
        $this->db->group_by('geopos_depo_onay.tehvil_id');


        $query = $this->db->get();

        return $query->num_rows();

    }



    public function count_all_depo_dosyalar($opt = '')

    {

        $this->_get_datatables_depo_dosyalar($opt);

        return $this->db->count_all_results();


    }
}






