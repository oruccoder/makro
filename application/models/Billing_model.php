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



class Billing_model extends CI_Model

{



    public function paynow($tid, $amount, $note, $pmethod,$loc=false)

    {

         $account['id']=false;

        if($loc){

         $this->db->select('geopos_accounts.id,geopos_accounts.holder,');

        $this->db->from('geopos_locations');

        $this->db->where('geopos_locations.id', $loc);

        $this->db->join('geopos_accounts', 'geopos_locations.ext = geopos_accounts.id', 'left');

        $query = $this->db->get();

        $account = $query->row_array();

        }

        if(!$account['id']){

              $this->db->select('geopos_accounts.id,geopos_accounts.holder,');

        $this->db->from('univarsal_api');

        $this->db->where('univarsal_api.id', 54);



        $this->db->join('geopos_accounts', 'univarsal_api.key1 = geopos_accounts.id', 'left');



        $query = $this->db->get();

        $account = $query->row_array();

        }







        $this->db->select('geopos_invoices.*,geopos_customers.name,geopos_customers.id AS cid');

        $this->db->from('geopos_invoices');

        $this->db->where('geopos_invoices.id', $tid);

        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id', 'left');



        $query = $this->db->get();

        $invoice = $query->row_array();



        // print_r($invoice);





        $data = array(

            'acid' => $account['id'],

            'account' => $account['holder'],

            'type' => 'Income',

            'cat' => 'Sales',

            'credit' => $amount,

            'payer' => $invoice['name'],

            'payerid' => $invoice['csd'],

            'method' => $pmethod,

            'date' => date('Y-m-d'),

            'eid' => $invoice['eid'],

            'tid' => $tid,

            'note' => $note,

            'loc' => $invoice['loc']

        );

        $this->db->trans_start();

        $this->db->insert('geopos_transactions', $data);

        $trans=$this->db->insert_id();





        $totalrm = $invoice['total'] - $invoice['pamnt'];



        if ($totalrm > $amount) {

            $this->db->set('pmethod', $pmethod);

            $this->db->set('pamnt', "pamnt+$amount", FALSE);



            $this->db->set('status', 'partial');

            $this->db->where('id', $tid);

            $this->db->update('geopos_invoices');





            //account update

            $this->db->set('lastbal', "lastbal+$amount", FALSE);

            $this->db->where('id', $account['id']);

            $this->db->update('geopos_accounts');



        } else {

            $this->db->set('pmethod', $pmethod);

            $this->db->set('pamnt', "pamnt+$amount", FALSE);

            $this->db->set('status', 'paid');

            $this->db->where('id', $tid);

            $this->db->update('geopos_invoices');

            //acount update

            $this->db->set('lastbal', "lastbal+$amount", FALSE);

            $this->db->where('id', $account['id']);

            $this->db->update('geopos_accounts');



        }

           $this->aauth->applog("[Payment Invoice $tid]  Transaction-$trans - $amount ",$this->aauth->get_user()->username);

        if ($this->db->trans_complete()) {

            return true;

        } else {

            return false;

        }

    }



    public function gateway($id)

    {



        $this->db->from('geopos_gateways');

        $this->db->where('id', $id);

        $query = $this->db->get();

        return $query->row_array();

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



    public function bank_accounts($enable = '')

    {



        $this->db->from('geopos_bank_ac');

        if ($enable == 'Yes') {

            $this->db->where('enable', 'Yes');

        }

        $query = $this->db->get();

        return $query->result_array();

    }



    public function bank_account_info($id)

    {



        $this->db->from('geopos_bank_ac');

        $this->db->where('id', $id);

        $query = $this->db->get();

        return $query->row_array();

    }





    public function gateway_update($gid, $currency, $key1, $key2, $enable, $devmode, $p_fee)

    {

        $data = array(

            'key1' => $key1,

            'key2' => $key2,

            'enable' => $enable,

            'dev_mode' => $devmode,

            'currency' => $currency,

            'surcharge' => $p_fee

        );





        $this->db->set($data);

        $this->db->where('id', $gid);



        if ($this->db->update('geopos_gateways')) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }



    public function online_pay_settings()

    {



        $this->db->select('univarsal_api.key1 AS default_acid,univarsal_api.key2 AS currency_code,univarsal_api.url AS enable,univarsal_api.method AS bank, geopos_accounts.*');

         $this->db->from('univarsal_api');

        $this->db->where('univarsal_api.id', 54);



        $this->db->join('geopos_accounts', 'univarsal_api.key1 = geopos_accounts.id', 'left');



        $query = $this->db->get();

        return $query->row_array();

    }





    public function payment_settings($id, $enable, $bank)

    {

        $data = array(

            'key1' => $id,

            'url' => $enable,

            'method' => $bank

        );





        $this->db->set($data);

        $this->db->where('id', 54);



        if ($this->db->update('univarsal_api')) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }





    public function bank_ac_add($name, $acn, $code, $enable, $bank, $branch, $address)

    {

        $data = array(

            'name' => $name,

            'acn' => $acn,

            'code' => $code,

            'enable' => $enable,

            'note' => $bank,

            'branch' => $branch,

            'address' => $address,

        );





        if ($this->db->insert('geopos_bank_ac', $data)) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('ADDED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }





    public function bank_ac_update($gid, $name, $acn, $code, $enable, $bank, $branch, $address)

    {

        $data = array(

            'name' => $name,

            'acn' => $acn,

            'code' => $code,

            'enable' => $enable,

            'note' => $bank,

            'branch' => $branch,

            'address' => $address,

        );





        $this->db->set($data);

        $this->db->where('id', $gid);



        if ($this->db->update('geopos_bank_ac')) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }



    public function add_currency($code, $symbol, $spos, $rate, $decimal, $thous_sep, $deci_sep)

    {

        $data = array(

            'code' => $code,

            'symbol' => $symbol,

            'rate' => $rate,

            'thous' => $thous_sep,

            'dpoint' => $deci_sep,

            'decim' => $decimal,

            'cpos' => $spos

        );





        if ($this->db->insert('geopos_currencies', $data)) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('ADDED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }



    public function edit_currency($gid, $code, $symbol, $spos, $rate, $decimal, $thous_sep, $deci_sep)

    {

        $data = array(

            'code' => $code,

            'symbol' => $symbol,

            'rate' => $rate,

            'thous' => $thous_sep,

            'dpoint' => $deci_sep,

            'decim' => $decimal,

            'cpos' => $spos

        );

        $this->db->set($data);

        $this->db->where('id', $gid);

        if ($this->db->update('geopos_currencies')) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }





    public function exchange($currency, $key1, $key2, $enable,$reverse=0)

    {

        $data = array(

            'key1' => $key1,

            'key2' => $key2,

            'url' => $currency,

            'other'=>$reverse,

            'active' => $enable

        );



        $this->db->set($data);

        $this->db->where('id', 5);



        if ($this->db->update('univarsal_api')) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }





    public function recharge_done($id, $amount)

    {



        $this->db->set('balance', "balance+$amount", FALSE);

        $this->db->where('id', $id);



        $this->db->update('geopos_customers');



        $data = array(

            'type' => 21,

            'rid' => $id,

            'col1' => $amount,

            'col2' => date('Y-m-d H:i:s').' Account Recharge'

        );





        if ($this->db->insert('geopos_metadata', $data)) {

              $this->aauth->applog("[Wallet Payment $id]  Amt - $amount ",$this->aauth->get_user()->username);

           return true;

        } else {

           return false;

        }



    }



        public function pos_paynow($tid, $amount, $note, $pmethod)

    {



        $this->db->select('geopos_accounts.id,geopos_accounts.holder,');

        $this->db->from('univarsal_api');

        $this->db->where('univarsal_api.id', 54);

        $this->db->join('geopos_accounts', 'univarsal_api.key1 = geopos_accounts.id', 'left');



        $query = $this->db->get();

        $account = $query->row_array();



        $this->db->select('geopos_invoices.*,geopos_customers.name,geopos_customers.id AS cid');

        $this->db->from('geopos_invoices');

        $this->db->where('geopos_invoices.id', $tid);

        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id', 'left');



        $query = $this->db->get();

        $invoice = $query->row_array();



        // print_r($invoice);





        $data = array(

            'acid' => $account['id'],

            'account' => $account['holder'],

            'type' => 'Income',

            'cat' => 'Sales',

            'credit' => $amount,

            'payer' => $invoice['name'],

            'payerid' => $invoice['csd'],

            'method' => $pmethod,

            'date' => date('Y-m-d'),

            'eid' => $invoice['eid'],

            'tid' => $tid,

            'note' => $note,

            'loc' => $invoice['loc']

        );

        $this->db->trans_start();

        $this->db->insert('geopos_transactions', $data);

        $trans=$this->db->insert_id();





        $totalrm = $invoice['total'] - $invoice['pamnt'];



        if ($totalrm > $amount) {

            $this->db->set('pmethod', $pmethod);

            $this->db->set('pamnt', "pamnt+$amount", FALSE);



            $this->db->set('status', 'partial');

            $this->db->where('id', $tid);

            $this->db->update('geopos_invoices');





            //account update

            $this->db->set('lastbal', "lastbal+$amount", FALSE);

            $this->db->where('id', $account['id']);

            $this->db->update('geopos_accounts');



        } else {

            $this->db->set('pmethod', $pmethod);

            $this->db->set('pamnt', "pamnt+$amount", FALSE);

            $this->db->set('status', 'paid');

            $this->db->where('id', $tid);

            $this->db->update('geopos_invoices');

            //acount update

            $this->db->set('lastbal', "lastbal+$amount", FALSE);

            $this->db->where('id', $account['id']);

            $this->db->update('geopos_accounts');



        }

          $this->aauth->applog("[Payment Invoice $tid]  Transaction-$trans - $amount ",$this->aauth->get_user()->username);

        if ($this->db->trans_complete()) {

            return true;

        } else {

            return false;

        }

    }

    public function sayim_update($id)
    {

        $this->db->set('onay_durumu', "1", FALSE);
        $this->db->set('new_status', "'onaylandi'", FALSE);

        $this->db->where('id', $id);

        $this->db->update('geopos_sayim');


        $geopos_sayim_to_purchase=$this->db->query("Select * From geopos_sayim_to_purchase Where sayim_id=$id LIMIT 1")->row_array();
        $purchase_id=$geopos_sayim_to_purchase['purchase_id'];

        $depo_id=purchase_in_depo($purchase_id);


        $this->db->set('onay_durumu', "1", FALSE);

        $this->db->where('sayim_id', $purchase_id);

        $this->db->update('geopos_purchase');


        // eğer sayılacak artık ürün kalmadıysa tüm ürünler eksiksiz sayıldı ise sayım tamamlandı update

        //siparişteki ürünler
        $this->db->select('*');

        $this->db->from('geopos_purchase_items');

        $this->db->where('tid', $purchase_id);

        $query = $this->db->get();

        $sip_products = $query->result_array();

        $durum1=false;
        $durum2=true;
        foreach ($sip_products as $prd)
        {
            $p_id = $prd['pid'];  // siparişteki ürün id
            $p_qty = $prd['qty']; // sipariş adeti



            $query=$this->db->query("select geopos_sayim_items.pid, sum(geopos_sayim_items.qty) as sayilan from geopos_sayim INNER JOIN geopos_sayim_items on geopos_sayim.id=geopos_sayim_items.tid
where geopos_sayim.purchase_id=$purchase_id and geopos_sayim_items.pid=$p_id");
            if(isset($query))
            {
                $sayi=$query->num_rows();
                if($sayi>0)
                {
                    $query=$query->row_array();
                    if($p_id==$query['pid'])
                    {
                        if($p_qty==$query['sayilan'])
                        {
                            $durum1=true;
                        }else
                            {
                                $durum2=false;
                            }
                    }

                }
            }

            if($durum1==$durum2)
            {
                $this->db->set('status', "3", FALSE);

                $this->db->where('id', $purchase_id);

                $this->db->update('geopos_purchase');

            }

        }






        // eğer sayılacak artık ürün kalmadıysa tüm ürünler eksiksiz sayıldı ise


        $this->db->select('*');

        $this->db->from('geopos_sayim_items');

        $this->db->where('geopos_sayim_items.tid', $id);

        $query = $this->db->get();

        $products = $query->result_array();

        if($products)
        {

            foreach ($products as $prd)
            {
                $toplam_rulo=0;
                $product_id=$prd['pid'];
                $product_details = $this->db->query("select * from geopos_products WHERE  pid = $product_id")->row_array();


                if ($product_details['parent_id'] != 0) {

                    $parent_id = $product_details['parent_id'];
                    if ($product_details['en'] != 0 || $product_details['boy'] != 0) {



                        $eklenecek_stok = $prd['qty'];
                        $toplam_rulo=$prd['toplam_rulo'];
                    }
                    else
                    {
                        $eklenecek_stok = $prd['qty'];
                        $toplam_rulo=0;
                    }




                    $this->stock_update($eklenecek_stok, $parent_id, 5,$toplam_rulo,$depo_id); //ana ürüne eklenecek 730


                    $this->stock_update($eklenecek_stok, $product_id, 1,$toplam_rulo,$depo_id); //731


                } else {
                    $this->stock_update($prd['qty'], $product_id, 1,$toplam_rulo,$depo_id);

                }
            }
            return true;
        }
        else
            {
                return false;
            }





    }

    public function stock_update($amt,$product_id,$invoice_type,$toplam_rulo,$depo)
    {

        $this->load->model('products_model', 'products');

        $prd_deta = $this->products->poruduct_details($product_id);

        $toplam_agirlik=0;

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

        $operator="qty-$amt";
        if($invoice_type==1)
        {
            $operator= "qty-$amt";
            $operator2= "toplam_agirlik-$toplam_agirlik";
        }
        else if($invoice_type==2)
        {
            $operator="qty+$amt";
            $operator2= "toplam_agirlik+$toplam_agirlik";
        }

        else if($invoice_type==7) // Satış İade Fatuası
        {
            $operator="qty-$amt";
            $operator2= "toplam_agirlik-$toplam_agirlik";

        }

        else if($invoice_type==8) // Alış İade Faturası
        {
            $operator="qty+$amt";
            $operator2= "toplam_agirlik+$toplam_agirlik";
        }

        else if($invoice_type==5) // Satış İade Fatuası
        {
            $operator="qty-$amt";
            $operator2= "toplam_agirlik-$toplam_agirlik";

        }


        $this->db->set('toplam_agirlik', "$operator2", FALSE);
        $this->db->where('pid', $product_id);
        $this->db->update('geopos_products');


        //depo tablosunu güncelleme


        $depo_kontrol=$this->depo_kontrol($product_id,$depo);



        if(isset($depo_kontrol))
        {

            $this->db->set('qty', "$operator", FALSE);

            $this->db->set('loc', "5", FALSE);

            $this->db->where('product_id', $product_id);

            $this->db->where('warehouse_id', $depo);

            $this->db->update('geopos_product_to_warehouse');
        }
        else
        {
            //depo tablosuna insert

            $depo_arr=array(
                'product_id'=>$product_id,
                'warehouse_id'=>$depo,
                'qty'=>$amt,
                'loc'=>5
            );
            $this->db->insert('geopos_product_to_warehouse', $depo_arr);
        }


        //depo tablosunu güncelleme


    }

    public function depo_kontrol($id,$depo_id)
    {
        $this->db->select('*');

        $this->db->from('geopos_product_to_warehouse');

        $this->db->where('product_id', $id);
        $this->db->where('warehouse_id', $depo_id);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function sayim_details($id)

    {



        $this->db->select('geopos_sayim.*,geopos_sayim.id AS iid,SUM(geopos_sayim.shipping + geopos_sayim.ship_tax) AS shipping,geopos_customers.*,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');

        $this->db->from('geopos_sayim');

        $this->db->where('geopos_sayim.id', $id);



        $this->db->join('geopos_customers', 'geopos_sayim.csd = geopos_customers.id', 'left');

        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_sayim.term', 'left');

        $query = $this->db->get();

        return $query->row_array();



    }







}