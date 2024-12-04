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



class Transactions_model extends CI_Model

{

    var $table = 'geopos_transactions';

    var $table_news = 'geopos_invoices';

    var $column_order = array('invoicedate', 'account', 'geopos_account_type.name', 'invoice_type_desc');

    var $column_search = array('invoicedate','account', 'geopos_account_type.name', 'invoice_type_desc','payer','total','notes');

    var $order = array('invoicedate' => 'DESC');

    var $opt = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Demirbas_model', 'dmodel');

    }


    public function meta_delete($name)

    {

        if (@unlink(FCPATH . 'userfiles/product/' . $name)) {

            return true;

        }

    }

    private function _get_datatables_query()

    {


        $type=hesap_types_array();
        $kasa_id=array(46,45,44,36,37);

        $this->db->select("geopos_invoices.*,geopos_invoices.id as trns_id");

        $this->db->from('geopos_invoices');
        // $where = "invoice_type_id IN (3,4,12,14,17,18,19,20,25,27,28,33)";
        $this->db->where_in('geopos_invoices.invoice_type_id',$type);
        $id = $this->aauth->get_user()->id;
        $roleid = $this->aauth->get_user()->roleid;

        if ($this->aauth->premission(17)->read) {

        }
        else {
            if ($this->aauth->premission(64)->read) {
                $this->db->where('geopos_invoices.eid', $id);
            }
            else {
                $this->db->where('geopos_invoices.eid', 0);
            }

        }





        $this->db->join('geopos_account_type','geopos_invoices.method=geopos_account_type.id','LEFT');


        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_invoices.invoicedate) >=', datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where('DATE(geopos_invoices.invoicedate) <=', datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
        }

        if ($this->input->post('hesap_id')) // if datatable send POST for search
        {
            $this->db->where('geopos_invoices.acid', $this->input->post('hesap_id'));
        }

        if ($this->input->post('proje_id')) // if datatable send POST for search
        {
            $this->db->where('geopos_invoices.proje_id', $this->input->post('proje_id'));
        }





        if ($this->input->post('tip_id')) // if datatable send POST for search
        {
            $this->db->where('geopos_invoices.invoice_type_id', $this->input->post('tip_id'));
        }
        if ($this->input->post('odeme_turu')) // if datatable send POST for search
        {
            $this->db->where('geopos_invoices.method', $this->input->post('odeme_turu'));
        }



        /*
                if ($this->aauth->get_user()->loc) {

                    $this->db->where('loc', $this->aauth->get_user()->loc);

                }


        */
        $i = 0;

        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_invoices.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

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





        $this->db->order_by('`geopos_invoices`.`id` DESC');


    }



    function get_datatables($opt = 'all')

    {

        $this->opt = $opt;

        $this->_get_datatables_query();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }



    function count_filtered()

    {

        $this->_get_datatables_query();

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function count_all()

    {

        $this->_get_datatables_query();



        return $this->db->count_all_results();

    }



    public function categories()

    {

        $this->db->select('*');

        $this->db->from('geopos_trans_cat');

        $query = $this->db->get();

        return $query->result_array();

    }



    public function acc_list($para_birimi=0)

    {

        $this->db->select('id,acn,holder,account_type,para_birimi');

        $this->db->from('geopos_accounts');
        if($para_birimi!=0)
        {
            $this->db->where('para_birimi', $para_birimi);
        }

        $id = $this->aauth->get_user()->id;
        $roleid = $this->aauth->get_user()->roleid;
        if($roleid==1 || $roleid==7 || $roleid==4)
        {
            if ($this->aauth->get_user()->loc) {

                $this->db->where('loc', $this->aauth->get_user()->loc);

                $this->db->or_where('loc', 0);

            }
        }
        else
        {
            $this->db->where('eid', $id);
        }



        $query = $this->db->get();

        return $query->result_array();

    }



    public function addcat($name)

    {

        $data = array(

            'name' => $name

        );



        return $this->db->insert('geopos_trans_cat', $data);

    }



    public function addtrans($payer_id, $payer_name, $pay_acc, $date, $debit, $credit, $pay_type, $pay_cat, $paymethod, $note, $eid, $loc = 0, $ty=0)

    {



        if ($pay_acc > 0) {



            $this->db->select('holder');

            $this->db->from('geopos_accounts');

            $this->db->where('id', $pay_acc);

            if ($this->aauth->get_user()->loc) {

                $this->db->group_start();

                $this->db->where('loc', $this->aauth->get_user()->loc);

                $this->db->or_where('loc', 0);

                $this->db->group_end();

            }

            $query = $this->db->get();

            $account = $query->row_array();



            if ($account) {

                $data = array(

                    'payerid' => $payer_id,

                    'payer' => $payer_name,

                    'acid' => $pay_acc,

                    'account' => $account['holder'],

                    'date' => $date,

                    'debit' => $debit,

                    'credit' => $credit,

                    'type' => $pay_type,

                    'cat' => $pay_cat,

                    'method' => $paymethod,

                    'eid' => $eid,

                    'note' => $note,

                    'ext'=>$ty,

                    'loc' => $loc

                );

                $amount = $credit - $debit;

                $this->db->set('lastbal', "lastbal+$amount", FALSE);

                $this->db->where('id', $pay_acc);

                $this->db->update('geopos_accounts');



                return $this->db->insert('geopos_transactions', $data);

            }

        }

    }



    public function addtransfer($pay_acc, $pay_acc2, $amount, $eid, $loc = 0,$para_birimi,$kur_degeri)

    {




        if ($pay_acc > 0) {



            $this->db->select('holder');

            $this->db->from('geopos_accounts');

            $this->db->where('id', $pay_acc);

            if ($this->aauth->get_user()->loc) {

                $this->db->group_start();

                $this->db->where('loc', $this->aauth->get_user()->loc);

                $this->db->or_where('loc', 0);

                $this->db->group_end();

            }

            $query = $this->db->get();

            $account = $query->row_array();

            $this->db->select('holder');

            $this->db->from('geopos_accounts');

            $this->db->where('id', $pay_acc2);

            if ($this->aauth->get_user()->loc) {

                $this->db->group_start();

                $this->db->where('loc', $this->aauth->get_user()->loc);

                $this->db->or_where('loc', 0);

                $this->db->group_end();

            }

            $query = $this->db->get();

            $account2 = $query->row_array();

//paranın çıktığı hesabın para birimi ne ise kurunu alıyoruz. o kurdan giriş yapacak para



            if ($account2) {


                //Paranın eklendiği hesap//

                $gelen_para_birimi = hesap_getir($pay_acc2)->para_birimi;



                $data = array(

                    'acid' => $pay_acc2, //hesapID ekleneck

                    'account' => $account2['holder'], //hesap adı ekelenecek

                    'debit' => 0, // eklenecek

                    'credit' => $amount,

                    'total' => $amount,
                    'para_birimi' => $para_birimi,

                    'kur_degeri' => $kur_degeri,
                    //'type' => $pay_type, // income expense

                    'invoice_type_id'=>27,

                    'invoice_type_desc'=>invoice_type_desc(27),

                    //'cat' => $pay_cat,

                    'method' => 1, //ödeme metodu ekelenecek

                    'eid' => $eid, //user_id

                    'notes' => invoice_type_desc(27),

                    // 'ext'=>$ty, //müşterimi tedarikçimi gerek yok

                    'loc' => $loc,

                );




                $this->db->insert('geopos_invoices', $data);
                //Paranın girdiği hesap//


            }

            if ($account) {


                $cikan_hesap_para_birimi = hesap_getir($pay_acc)->para_birimi;
                $cikan_kur_degeri = 1;
                //Paranın Çıktığı hesap//

                $data = array(

                    'acid' => $pay_acc, //hesapID ekleneck

                    'account' => $account['holder'], //hesap adı ekelenecek

                    'debit' => $amount, // eklenecek

                    'credit' => 0,

                    'total' => $amount,

                    //'type' => $pay_type, // income expense
                    'invoice_type_id'=>28,

                    'invoice_type_desc'=>invoice_type_desc(28),

                    //'cat' => $pay_cat,

                    'method' => 1, //ödeme metodu ekelenecek

                    'eid' => $eid, //user_id
                    'para_birimi' => $cikan_hesap_para_birimi,
                    'kur_degeri' => $cikan_kur_degeri,

                    'notes' => invoice_type_desc(28),

                    // 'ext'=>$ty, //müşterimi tedarikçimi gerek yok

                    'loc' => $loc,

                );




                $this->db->insert('geopos_invoices', $data);
                return 1;

//Paranın Çıktığı hesap//

            }

        }

    }


    public function addtransferDoviz($cikan_hesap, $gelen_hesap, $eid, $loc = 0,$kur_degeri,$tutar_cikan,$tutar_gelen,$date,$note)

    {
        $id_talep_eden=0;
        $id_talep_edilen=0;
        if ($cikan_hesap > 0) {

            //talep eden
            $hesap_adi=account_details($cikan_hesap)->holder;
            $hesap_adi_giden=account_details($gelen_hesap)->holder;
            $_giden_pb=account_details($cikan_hesap)->para_birimi;
            $data = array(

                'acid' => $cikan_hesap, //hesapID ekleneck
                'acid_' => $gelen_hesap, //hesapID ekleneck
                'payer' => $hesap_adi_giden, //hesapID ekleneck

                'account' => $hesap_adi, //hesap adı ekelenecek

                'debit' => 0, // eklenecek

                'credit' => $tutar_cikan,
                'invoicedate' => $date,
                'invoiceduedate' => $date,
                'total' => $tutar_cikan,
                'para_birimi' => $_giden_pb,

                'kur_degeri' => $kur_degeri,
                //'type' => $pay_type, // income expense

                'invoice_type_id'=>28,

                'onay_status'=>0,

                'invoice_type_desc'=>invoice_type_desc(28),

                //'cat' => $pay_cat,

                'method' => 1, //ödeme metodu ekelenecek

                'eid' => $eid, //user_id

                'notes' => 'Talep - Kur Değeri : '.$kur_degeri.' | '.$note.' | '.$hesap_adi_giden.' Kasasına Talep Etti',

                // 'ext'=>$ty, //müşterimi tedarikçimi gerek yok

                'loc' => $loc,

            );




            $this->db->insert('doviz_transfer', $data);

            $id_talep_eden = $this->db->insert_id();

            $this->aauth->applog("Virman (Giren) " . $id_talep_eden.' '.invoice_type_desc(28), $this->aauth->get_user()->username);
            //Paranın girdiği hesap//





            if ($gelen_hesap) {

                $hesap_adi_gelen=account_details($cikan_hesap)->holder;

                $hesap_adi=account_details($gelen_hesap)->holder;
                $_gelen_pb=account_details($gelen_hesap)->para_birimi;
                $data = array(

                    'acid' => $gelen_hesap, //hesapID ekleneck
                    'acid_' => $cikan_hesap, //hesapID ekleneck
                    'payer' => $hesap_adi_gelen, //hesapID ekleneck

                    'account' => $hesap_adi, //hesap adı ekelenecek
                    'invoicedate' => $date,
                    'invoiceduedate' => $date,

                    'debit' => 0, // eklenecek

                    'credit' => $tutar_gelen,
                    'total' => $tutar_gelen,
                    'para_birimi' => $_gelen_pb,

                    'kur_degeri' => $kur_degeri,
                    //'type' => $pay_type, // income expense

                    'invoice_type_id'=>27,

                    'onay_status'=>0,

                    'invoice_type_desc'=>invoice_type_desc(27),

                    //'cat' => $pay_cat,

                    'method' => 1, //ödeme metodu ekelenecek

                    'eid' => $eid, //user_id

                    'notes' => 'Kur Değeri : '.$kur_degeri.' | '.$note.' | '.$hesap_adi_gelen.' Kasasından Talep Gönderildi',

                    // 'ext'=>$ty, //müşterimi tedarikçimi gerek yok

                    'loc' => $loc,

                );




                $this->db->insert('doviz_transfer', $data);
                $id_talep_edilen = $this->db->insert_id();


                $this->aauth->applog("Talep - Virman (Çıkan) " . $id_talep_edilen.' '.invoice_type_desc(27), $this->aauth->get_user()->username);



                $data_item=[
                    'talep_eden_id'=>$id_talep_eden,
                    'talep_edilen_id'=>$id_talep_edilen,
                    'user_id'=>$this->aauth->get_user()->id,
                ];

                $this->db->insert('doviz_transfer_item', $data_item);

                return 1;

//Paranın Çıktığı hesap//

            }



        }
    }






    public function delt($id)

    {


        $this->db->trans_start();
        $this->db->select('*');

        $this->db->from('geopos_invoice_transactions');


        $this->db->where('transaction_id', $id);

        $query = $this->db->get();

        $trans = $query->row_array();



        $amt = $trans['total'];

        $invoice_details=$this->db->query("SELECT * FROM geopos_invoices Where id=$id")->row();

        $inv_id=0;

        if(isset($invoice_details))
        {
            $inv_id=$trans['invoice_id'];
        }




        if($inv_id!=0)
        {
            $kontrol=$this->db->query("SELECT * FROM geopos_invoices Where id=$inv_id");



            // fatura
            if($kontrol->num_rows()>0)
            {
                $this->db->set('last_balance', "last_balance-$amt", FALSE);

                $this->db->where('id', $inv_id);

                $this->db->update('geopos_invoices');

            }

            // proje


            if($kontrol->num_rows()>0)
            {
                $invo=$kontrol->row();
                $proje_id = $invo->proje_id;


                if($proje_id!=0)
                {
                    $item_details = $this->db->query("SELECT * FROM geopos_project_items_gider Where tid = $inv_id")->result();

                    $urun_sayisi=count($item_details);
                    $ortalama = $amt/$urun_sayisi;






                    foreach ($item_details as $itm)
                    {
                        //echo 'Deger:'.$update.'<br>';

                        $this->db->set('last_balance', "last_balance-$ortalama", FALSE);
                        $this->db->where('tid', $inv_id);
                        $this->db->where('id', $itm->id);
                        $this->db->update('geopos_project_items_gider');

                    }
                }

            }
        }







        $this->db->delete('geopos_invoice_transactions', array('transaction_id' => $id));

        $this->db->delete('geopos_invoices', array('id' => $id));

        $this->db->trans_complete();

        $this->aauth->applog("İşlem Silindi : ID " . $id, $this->aauth->get_user()->username);

        return array('status' => 'Success', 'message' => $this->lang->line('DELETED'));





    }



    public function view($id)

    {

        $this->db->select('*');

        $this->db->from('geopos_invoices');

        $this->db->where('id', $id);

        $query = $this->db->get();

        return $query->row_array();

    }



    public function cview($id,$ext=0)

    {



        if($ext==1) {

            $this->db->select('*');

            $this->db->from('geopos_customers');

            $this->db->where('id', $id);

            if ($this->aauth->get_user()->loc) {

                $this->db->group_start();

                $this->db->where('loc', $this->aauth->get_user()->loc);

                $this->db->or_where('loc', 0);

                $this->db->group_end();

            }

            $query = $this->db->get();

            return $query->row_array();

        } elseif ($ext==4) {

            $this->db->select('geopos_employees.*,geopos_users.email');

            $this->db->from('geopos_employees');

            $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');

            $this->db->where('geopos_employees.id', $id);

            if ($this->aauth->get_user()->loc) {

                $this->db->group_start();

                $this->db->where('geopos_users.loc', $this->aauth->get_user()->loc);

                $this->db->or_where('geopos_users.loc', 0);

                $this->db->group_end();

            }

            $query = $this->db->get();

            return $query->row_array();

        }

        else{

            $this->db->select('*');

            $this->db->from('geopos_customers');

            $this->db->where('id', $id);

            if ($this->aauth->get_user()->loc) {

                $this->db->group_start();

                $this->db->where('loc', $this->aauth->get_user()->loc);

                $this->db->or_where('loc', 0);

                $this->db->group_end();

            }

            $query = $this->db->get();

            return $query->row_array();

        }



    }



    public function cat_details($id)

    {



        $this->db->select('*');

        $this->db->from('geopos_trans_cat');

        $this->db->where('id', $id);

        $query = $this->db->get();

        return $query->row_array();

    }



    public function cat_update($id, $cat_name)

    {



        $data = array(

            'name' => $cat_name



        );





        $this->db->set($data);

        $this->db->where('id', $id);



        if ($this->db->update('geopos_trans_cat')) {

            return true;

        } else {

            return false;

        }

    }



    public function check_balance($id)

    {

        $this->db->select('balance');

        $this->db->from('geopos_customers');

        $this->db->where('id', $id);

        if ($this->aauth->get_user()->loc) {

            $this->db->group_start();

            $this->db->where('loc', $this->aauth->get_user()->loc);

            $this->db->or_where('loc', 0);

            $this->db->group_end();

        }

        $query = $this->db->get();

        return $query->row_array();

    }

    public function addtransinv($payer_id, $payer_name, $pay_acc, $debit, $credit, $pay_type, $pay_cat,
                                $paymethod, $note, $eid, $loc = 0, $ty=0,$amount,$para_birimi,$kur_degeri,
                                $masraf_id=0,$dosya_id,$ithalat_ihracat_tip,$proje_id,$cari_pers_type,$invoice_id_masraf,$image,$maas_ay=0,$proje_bolum_id=0,$talep_id=0)

    {



        $date_ = new DateTime('now');
        $maas_yil=$date_->format('Y');
        if ($pay_acc > 0) {



            $this->db->select('holder');

            $this->db->from('geopos_accounts');

            $this->db->where('id', $pay_acc);

            $query = $this->db->get();

            $account = $query->row_array();



            //proje gideri ekleme
            if($proje_id)
            {
                if($pay_type==17)
                {
                    if($cari_pers_type==1) // bu bir faturadır
                    {

                        if($invoice_id_masraf){
                            $item_details = $this->db->query("SELECT * FROM geopos_project_items_gider Where tid = $invoice_id_masraf")->result();
                            $urun_sayisi=count($item_details); //2
                            $ortalama = floatval($amount);

                            foreach ($item_details as $itm)
                            {


                                $kalan = floatval($itm->subtotal)-floatval($itm->last_balance);

                                $update=0;
                                if(floatval($kalan) < floatval($ortalama) || floatval($kalan)==floatval($ortalama))
                                {
                                    $update=$kalan;

                                }
                                else
                                {
                                    $update = $ortalama;
                                }


                                $this->db->set('last_balance', "last_balance+$update", false);
                                $this->db->where('tid', $invoice_id_masraf);
                                $this->db->where('id', $itm->id);
                                $this->db->update('geopos_project_items_gider');

                                $ortalama=floatval($ortalama)-floatval($update);



                            }
                        }







                    }
                    else if($cari_pers_type==3) // bu bir masraftır
                    {

                        $this->db->set('last_balance', "last_balance+$amount", FALSE);

                        $this->db->where('tid', $payer_id);

                        $this->db->update('geopos_project_items_gider');
                    }

                    else if($cari_pers_type==2) // bu bir personeldir
                    {

                    }
                }
                else if($pay_type==19)
                {
                    if($cari_pers_type==1) // bu bir faturadır
                    {

                        if($invoice_id_masraf){
                            $item_details = $this->db->query("SELECT * FROM geopos_project_items_gider Where tid = $invoice_id_masraf")->result();

                            $ortalama = floatval($amount);

                            foreach ($item_details as $itm)
                            {

                                $update=0;
                                $kalan = floatval($itm->totaltax)-floatval($itm->kdv_last_balance);

                                if(floatval($kalan) < floatval($ortalama) || floatval($kalan)==floatval($ortalama))
                                {
                                    $update=$kalan;

                                }
                                else
                                {
                                    $update = $ortalama;
                                }

                                //echo $update;



                                $this->db->set('kdv_last_balance', "kdv_last_balance+$update", FALSE);

                                $this->db->where('id', $itm->id);

                                $this->db->update('geopos_project_items_gider');


                                $ortalama=floatval($ortalama)-floatval($update);



                            }
                        }







                    }
                    else if($cari_pers_type==3) // bu bir masraftır
                    {
                        $this->db->set('kdv_last_balance', "kdv_last_balance+$amount", FALSE);

                        $this->db->where('tid', $payer_id);

                        $this->db->update('geopos_project_items_gider');
                    }

                    else if($cari_pers_type==2) // bu bir personeldir
                    {

                    }
                }


            }

            if($pay_type==17) {

                $this->db->set('last_balance', "last_balance+$amount", FALSE);

                $this->db->where('id', $invoice_id_masraf);

                $this->db->update('geopos_invoices');

            }
            else if($pay_type==19)
            {
                $this->db->set('kdv_last_balance', "kdv_last_balance+$amount", FALSE);

                $this->db->where('id', $invoice_id_masraf);

                $this->db->update('geopos_invoices');
            }



            //proje ödeme - tahsilatı ekletme



            if($masraf_id!=0){
                $payer_id=0;
            }

            if(is_null($masraf_id)){
                $masraf_id=0;
            }

            if ($account) {

                $data = array(

                    'csd' => $payer_id,

                    'payer' => $payer_name,

                    'acid' => $pay_acc, //hesapID ekleneck

                    'account' => $account['holder'], //hesap adı ekelenecek

                    'debit' => $debit, // eklenecek

                    'credit' => $credit, //eklenecek

                    'total' => $amount,

                    //'type' => $pay_type, // income expense
                    'invoice_type_id'=>$pay_type,

                    'invoice_type_desc'=>invoice_type_desc($pay_type),

                    //'cat' => $pay_cat,

                    'method' => $paymethod, //ödeme metodu ekelenecek

                    'eid' => $eid, //user_id

                    'notes' => $note,

                    // 'ext'=>$ty, //müşterimi tedarikçimi gerek yok

                    'loc' => $loc,
                    'para_birimi' => $para_birimi,
                    'kur_degeri' => $kur_degeri,
                    'masraf_id' => $masraf_id,
                    'dosya_id'=>$dosya_id,
                    'ithalat_ihracat_tip'=>$ithalat_ihracat_tip,
                    'proje_id'=>$proje_id,
                    'cari_pers_type'=>$cari_pers_type,
                    'maas_ay'=>$maas_ay,
                    'maas_yil'=>$maas_yil,
                    'bolum_id'=>$proje_bolum_id,
                    'ext'=>$image

                );



                $this->db->set('lastbal', "lastbal+$amount", FALSE);

                $this->db->where('id', $pay_acc);

                $this->db->update('geopos_accounts');



                if($cari_pers_type==6)
                {
                    $invoice_details=$this->db->query("SELECT * FROM geopos_invoices WHERE id=$payer_id")->row()->invoice_type_id;
                    if($invoice_details==37)
                    {

                        $this->db->set('last_balance', "last_balance+$amount", FALSE);

                        $this->db->where('id', $payer_id);

                        $this->db->update('geopos_invoices');

                        $invoice_details=$this->db->query("SELECT * FROM geopos_invoices WHERE id=$payer_id")->row();

                        if($invoice_details->total==$invoice_details->last_balance)
                        {

                            $this->db->set('status', "2", FALSE);

                            $this->db->where('id', $payer_id);

                            $this->db->update('geopos_invoices');
                        }



                    }
                }





                $last =  $this->db->insert('geopos_invoices', $data);

                $last_id = $this->db->insert_id();

                if($talep_id){
                    foreach ($talep_id as $aid){
                        if($this->input->post('tip_odeme')){
                            if($this->input->post('tip_odeme')==2) // forma2
                            {

                            }
                            else {
                                $s_tip = $this->db->query("SELECT * FROM geopos_talep where id = $aid")->row()->tip;
                                $data_avans =  array('tip'=>$s_tip,'talep_id'=>$aid,'invoice_id'=>$last_id,'user_id'=>$this->aauth->get_user()->id);
                                $this->db->insert('invoice_to_talep', $data_avans);
                            }
                        }
                        else {
                            $s_tip = $this->db->query("SELECT * FROM geopos_talep where id = $aid")->row()->tip;
                            $data_avans =  array('tip'=>$s_tip,'talep_id'=>$aid,'invoice_id'=>$last_id,'user_id'=>$this->aauth->get_user()->id);
                            $this->db->insert('invoice_to_talep', $data_avans);
                        }

                    }
                }



                if($talep_id!=0){
                    foreach ($talep_id as $talep){
                        $data = array(

                            'invoice_id' => $talep,
                            'transaction_id' => $last_id,
                            'total' => $amount,
                            'kur_degeri' => $kur_degeri,
                            'para_birimi' => $para_birimi,
                            'method' => $paymethod,
                            'tip' => 7, // Talep
                            'ext' => $image

                        );
                        $this->db->insert('geopos_invoice_transactions', $data);

                        $data = array(
                            'transaction_id' => $last_id,
                            'total' => $amount,
                            'kur_degeri' => $kur_degeri,
                            'para_birimi' => $para_birimi,
                            'method' => $paymethod,
                            'tip' => 8, // Avans
                            'ext' => $image

                        );
                        $this->db->insert('geopos_invoice_transactions', $data);



                    }

                    foreach ($talep_id as $talep){
                        if($this->input->post('tip_odeme')){
                            if($this->input->post('tip_odeme')==2) // forma2
                            {
                                $odenen_toplam = $this->db->query("SELECT SUM(total) as total FROM `geopos_invoice_transactions`  Where invoice_id = $talep ")->row();
                                $total_talep = $this->db->query("SELECT * FROM geopos_invoices Where id = $talep")->row()->total;
                                if(floatval($odenen_toplam->total) == floatval($total_talep) ){
                                    $this->db->set('status', "2");
                                    $this->db->where('id', $talep);
                                    $this->db->update('geopos_invoices');
                                }
                            }
                            else {
                                $odenen_toplam = $this->db->query("SELECT SUM(total) as total FROM `geopos_invoice_transactions`  Where invoice_id = $talep and tip = 7")->row();
                                $total_talep = $this->db->query("SELECT * FROM geopos_talep Where id = $talep")->row();
                                $talep_total=$total_talep->total;
                                if($total_talep->tip==6){
                                    $talep_total = $total_talep->talep_total;
                                }
                                if(floatval($odenen_toplam->total) == floatval($talep_total) ){
                                    $this->db->set('status', "6");
                                    $this->db->set('transaction_id	', $last_id, FALSE);
                                    $this->db->where('id', $talep);
                                    $this->db->update('geopos_talep');
                                }
                            }

                        }
                        else {
                            $odenen_toplam = $this->db->query("SELECT SUM(total) as total FROM `geopos_invoice_transactions`  Where invoice_id = $talep and tip = 7")->row();
                            $total_talep = $this->db->query("SELECT * FROM geopos_talep Where id = $talep")->row()->total;
                            if(floatval($odenen_toplam->total) == floatval($total_talep) ){
                                $this->db->set('status', "6");
                                $this->db->set('transaction_id	', $last_id, FALSE);
                                $this->db->where('id', $talep);
                                $this->db->update('geopos_talep');
                            }
                        }

                    }

                }



                return $last_id;

            }

        }

    }

    public function edit_trans($trans_id,$payer_id, $payer_name, $pay_acc, $debit, $credit, $pay_type,
                               $pay_cat, $paymethod, $note, $eid, $loc = 0, $ty=0,$amount,$para_birimi,$kur_degeri,$masraf_id,$dosya_id,
                               $ithalat_ihracat_tip,$proje_id,$cari_pers_type,$image,$proje_bolum_id)

    {



        $this->db->select('holder');

        $this->db->from('geopos_accounts');

        $this->db->where('id', $pay_acc);
        $query = $this->db->get();
        $account = $query->row_array();


        //proje gideri ekleme
        if($proje_id!=0)
        {

            if($pay_type==4) // Tipi Ödeme ise
            {




                $kontrol = $this->db->query("SELECT * FROM geopos_project_items_gider WHERE tid=$trans_id");


                if($kontrol->num_rows()>0)
                {

                    $old_total=$this->input->post("old_total");

                    $kalan = $old_total-$amount;

                    $this->db->set('last_balance', "last_balance+$kalan", FALSE);

                    $this->db->where('tid', $trans_id);

                    $this->db->update('geopos_project_items_gider');


                }

                else
                {
                    $masraf_id_=$this->db->query("SELECT * FROM `geopos_invoices` WHERE `id` = $trans_id")->row();
                    if(isset($masraf_id_->tid))
                    {
                        $detais=$this->db->query("SELECT * FROM `geopos_invoice_items` WHERE `tid` = $masraf_id_->tid")->row();

                        $data_items = array(

                            'tid' => $trans_id,

                            'pid' => $detais->pid,

                            'product' => masraf_name($detais->pid),

                            'code' => masraf_name($detais->pid),

                            'qty' => 1,

                            'price' => $amount,


                            'discount' => 0,

                            'subtotal' => $amount,


                            'totaldiscount' => 0,

                            'last_balance' => $amount,

                            'product_des' => '',

                            'unit' => 9,

                            'invoice_type_id' => 21,

                            'proje_id' => $proje_id,

                            'invoice_type_desc' => 'Masraf',
                        );
                        $this->db->insert('geopos_project_items_gider', $data_items);
                    }

                }



            }
            else if($pay_type==17 ) // Tipi Ödeme ise ve Fatura Ödeme İse
            {


                $invoice_id = $this->input->post('cari_in_invoice', true);


                $item_details = $this->db->query("SELECT * FROM geopos_project_items_gider Where tid = $invoice_id")->result();

                $urun_sayisi=count($item_details);


                $old_total=$this->input->post("old_total");

                $kalan_yeni = $amount-$old_total;

                $ortalama = $kalan_yeni/$urun_sayisi;



                foreach ($item_details as $itm)
                {




                    $kalan = $itm->subtotal-$itm->last_balance;


                    $update=0;
                    if($kalan > $ortalama)
                    {
                        $update=$ortalama;
                    }
                    else
                    {
                        $update = $kalan-$ortalama;
                    }


                    //echo 'Deger:'.$update.'<br>';

                    $this->db->set('last_balance', "last_balance+$update", FALSE);
                    $this->db->where('tid', $invoice_id);
                    $this->db->where('id', $itm->id);
                    $this->db->update('geopos_project_items_gider');

                }
            }

            else if($pay_type==45 || $pay_type==46){}

            else
            {
                $masraf_id_=$this->db->query("SELECT * FROM `geopos_invoices` WHERE `id` = $trans_id")->row();
                if(isset($masraf_id_->tid))
                {
                    $detais=$this->db->query("SELECT * FROM `geopos_invoice_items` WHERE `tid` = $masraf_id_->tid")->row();

                    $data_items = array(

                        'tid' => $trans_id,

                        'pid' => $detais->pid,

                        'product' => masraf_name($detais->pid),

                        'code' => masraf_name($detais->pid),

                        'qty' => 1,

                        'price' => $amount,


                        'discount' => 0,

                        'subtotal' => $amount,


                        'totaldiscount' => 0,

                        'last_balance' => $amount,

                        'product_des' => '',

                        'unit' => 9,

                        'invoice_type_id' => 21,

                        'proje_id' => $proje_id,

                        'invoice_type_desc' => 'Masraf',
                    );
                    $this->db->insert('geopos_project_items_gider', $data_items);
                }

            }



        }


        if($pay_type==17 ) // Tipi Ödeme ise ve Fatura Ödeme İse
        {
            $invoice_id = $this->input->post('cari_in_invoice', true);
            $old_total=$this->input->post("old_total");
            $kalan_yeni = $amount-$old_total;
            $this->db->set('last_balance', "last_balance+$kalan_yeni", FALSE);
            $this->db->where('id', $invoice_id);
            $this->db->update('geopos_invoices');

        }



        $data = array(

            'csd' => $payer_id,

            'payer' => $payer_name,

            'acid' => $pay_acc, //hesapID ekleneck

            'account' => $account['holder'], //hesap adı ekelenecek


            'debit' => $debit, // eklenecek

            'credit' => $credit, //eklenecek

            'total' => $amount,

            //'type' => $pay_type, // income expense
            'invoice_type_id'=>$pay_type,

            'invoice_type_desc'=>invoice_type_id($pay_type),

            //'cat' => $pay_cat,

            'method' => $paymethod, //ödeme metodu ekelenecek

            'eid' => $eid, //user_id

            'notes' => $note,

            // 'ext'=>$ty, //müşterimi tedarikçimi gerek yok

            'loc' => $loc,
            'para_birimi' => $para_birimi,
            'kur_degeri' => $kur_degeri,
            'masraf_id' => $masraf_id,
            'dosya_id'=>$dosya_id,
            'ithalat_ihracat_tip'=>$ithalat_ihracat_tip,
            'proje_id'=>$proje_id,
            'bolum_id'=>$proje_bolum_id,
            'cari_pers_type'=>$cari_pers_type,
            'ext'=>$image

        );

        $this->db->set($data);
        $this->db->where('id', $trans_id);
        return $this->db->update('geopos_invoices', $data);





    }

    public function cari_in_invoice($customer_id,$pay_type,$id=0)
    {
        //18 Fatura Ödeme
        //19 Fatura tahsilat



        $union='';
        if($pay_type==17 || $pay_type==18)
        {
            $union='';
            $join=" WHERE `geopos_invoices`.`csd` = '$customer_id'
        AND `geopos_invoice_type`.`type_value` = 'fatura' and `geopos_invoices`.`last_balance` NOT IN(geopos_invoices.subtotal) ";

            if($id!=0)
            {
                $union="UNION ALL SELECT `geopos_invoices`.*,geopos_invoices.subtotal-geopos_invoices.last_balance as kalan
            FROM  `geopos_invoices` JOIN `geopos_invoice_type` ON
      `geopos_invoices`.`invoice_type_id`=`geopos_invoice_type`.`id` WHERE `geopos_invoices`.`csd` = '$customer_id'
        AND `geopos_invoice_type`.`type_value` = 'fatura' and `geopos_invoices`.`last_balance` NOT IN(geopos_invoices.subtotal)";
                $join="INNER JOIN geopos_invoice_transactions ON
                geopos_invoices.id=geopos_invoice_transactions.invoice_id WHERE
                geopos_invoice_transactions.transaction_id=$id AND `geopos_invoices`.`csd` = '$customer_id'
        AND `geopos_invoice_type`.`type_value` = 'fatura' and `geopos_invoices`.`last_balance` ";
            }
            $query=$this->db->query("SELECT `geopos_invoices`.*,geopos_invoices.subtotal-geopos_invoices.last_balance as kalan
            FROM  `geopos_invoices` JOIN `geopos_invoice_type` ON
      `geopos_invoices`.`invoice_type_id`=`geopos_invoice_type`.`id` $join  $union");
        }
        else if($pay_type==43 || $pay_type==44)
        {
            $union='';
            $join=" WHERE `geopos_invoices`.`csd` = '$customer_id'
        AND `geopos_invoice_type`.`id` IN  (1,2,7,8,24,35,36,38,42,29,30) and `geopos_invoices`.`last_balance` NOT IN(geopos_invoices.subtotal) ";

            if($id!=0)
            {
                $union="UNION ALL SELECT `geopos_invoices`.*,geopos_invoices.subtotal-geopos_invoices.last_balance as kalan
            FROM  `geopos_invoices` JOIN `geopos_invoice_type` ON
      `geopos_invoices`.`invoice_type_id`=`geopos_invoice_type`.`id` WHERE `geopos_invoices`.`csd` = '$customer_id'
         AND `geopos_invoice_type`.`id` IN (43,44)  and `geopos_invoices`.`last_balance` NOT IN(geopos_invoices.subtotal)";

                $join="INNER JOIN geopos_invoice_transactions ON
                geopos_invoices.id=geopos_invoice_transactions.invoice_id WHERE
                geopos_invoice_transactions.transaction_id=$id AND `geopos_invoices`.`csd` = '$customer_id'
        AND `geopos_invoice_type`.`id` IN (43,44) and `geopos_invoices`.`last_balance` ";
            }
            $query=$this->db->query("SELECT `geopos_invoices`.*,geopos_invoices.subtotal-geopos_invoices.last_balance as kalan
            FROM  `geopos_invoices` JOIN `geopos_invoice_type` ON
      `geopos_invoices`.`invoice_type_id`=`geopos_invoice_type`.`id` $join  $union");
        }
        else if($pay_type==45 || $pay_type==46 || $pay_type==54 || $pay_type==55 || $pay_type==57 || $pay_type==61 || $pay_type==65)
        {

            $join=" WHERE `geopos_invoices`.`csd` = '$customer_id'
         AND `geopos_invoice_type`.`id` IN (29,30)";

            if($id!=0)
            {
                $union="UNION ALL SELECT `geopos_invoices`.*,geopos_invoices.subtotal-geopos_invoices.last_balance as kalan
            FROM  `geopos_invoices` JOIN `geopos_invoice_type` ON
      `geopos_invoices`.`invoice_type_id`=`geopos_invoice_type`.`id` WHERE `geopos_invoices`.`csd` = '$customer_id'
        AND `geopos_invoice_type`.`id` IN (29,30)  and `geopos_invoices`.`last_balance`";
                $join="INNER JOIN geopos_invoice_transactions ON
                geopos_invoices.id=geopos_invoice_transactions.invoice_id WHERE
                geopos_invoice_transactions.transaction_id=$id AND `geopos_invoices`.`csd` = '$customer_id'
        AND `geopos_invoice_type`.`id` IN (45,46) ";
            }
            $query=$this->db->query("SELECT `geopos_invoices`.*,geopos_invoices.subtotal-geopos_invoices.last_balance as kalan
            FROM  `geopos_invoices` JOIN `geopos_invoice_type` ON
      `geopos_invoices`.`invoice_type_id`=`geopos_invoice_type`.`id` $join  $union");
        }
        else  if($pay_type==19 || $pay_type==20)
        {
            $join=" WHERE `geopos_invoices`.`csd` = '$customer_id'
        AND `geopos_invoice_type`.`type_value` = 'fatura' and `geopos_invoices`.`kdv_last_balance` NOT IN(geopos_invoices.tax) ";
            if($id!=0)
            {
                $union="UNION ALL SELECT `geopos_invoices`.*,geopos_invoices.tax-geopos_invoices.kdv_last_balance as kalan FROM `geopos_invoices` JOIN `geopos_invoice_type` ON
      `geopos_invoices`.`invoice_type_id`=`geopos_invoice_type`.`id` WHERE `geopos_invoices`.`csd` = '$customer_id'
        AND `geopos_invoice_type`.`type_value` = 'fatura' and `geopos_invoices`.`kdv_last_balance` NOT IN(geopos_invoices.tax) ";
                $join="INNER JOIN geopos_invoice_transactions ON
                geopos_invoices.id=geopos_invoice_transactions.invoice_id WHERE
                geopos_invoice_transactions.transaction_id=$id AND `geopos_invoices`.`csd` = '$customer_id'
        AND `geopos_invoice_type`.`type_value` = 'fatura' and `geopos_invoices`.`kdv_last_balance` ";
            }

            $query=$this->db->query("SELECT `geopos_invoices`.*,geopos_invoices.tax-geopos_invoices.kdv_last_balance as kalan FROM `geopos_invoices` JOIN `geopos_invoice_type` ON
      `geopos_invoices`.`invoice_type_id`=`geopos_invoice_type`.`id` $join $union");


        }


        //20 KDV Ödeme
        //21 KDV Tahsilat



        return $query->result();
    }

    public function add_invoice_transaction($string,$invoice_id,$lid,$amount,$para_birimi,$kur_degeri,$paymethod,$tip,$image)
    {







        $this->db->select('*');

        $this->db->from('geopos_invoices');

        $this->db->where('id', $invoice_id);

        $query = $this->db->get();

        $invoices = $query->row_array();

        $odenen_tutar=$invoices['last_balance']+$invoices['kdv_last_balance'];

        if($odenen_tutar==$invoices['total'])
        {
            $this->db->set('odeme_durumu', "3", FALSE);
            $this->db->where('id', $invoice_id);
            $this->db->update('geopos_invoices');
        }




        if($string=='add')
        {
            if($invoice_id==0){
                $invoice_id=$this->input->post('talep_id')[0];
            }
            $data = array(

                'invoice_id' => $invoice_id,
                'transaction_id' => $lid,
                'total' => $amount,
                'kur_degeri' => $kur_degeri,
                'para_birimi' => $para_birimi,
                'method' => $paymethod,
                'tip' => $tip,
                'ext' => $image

            );


            return $this->db->insert('geopos_invoice_transactions', $data);
        }
        else
        {
            $this->db->delete('geopos_invoice_transactions', array('transaction_id' => $lid));

            $data = array(

                'invoice_id' => $invoice_id,
                'transaction_id' => $lid,
                'total' => $amount,
                'kur_degeri' => $kur_degeri,
                'para_birimi' => $para_birimi,
                'method' => $paymethod,
                'tip' => $tip,
                'ext' => $image

            );


            return $this->db->insert('geopos_invoice_transactions', $data);
        }



    }


    public function cari_alacak_borc()
    {
        $alacakak_borc=$this->input->post("alacakak_borc");
        $ana_cari_id=$this->input->post("ana_cari_id");
        $alt_customer_id=$this->input->post("alt_customer_id");
        $islem_tipi=$this->input->post("islem_tipi");
        $islem_listesi=$this->input->post("islem_listesi");
        $islem_listesi=isset($islem_listesi)?$islem_listesi:0;
        $alacak_tutar=$this->input->post("alacak_tutar");
        $oran=$this->input->post("oran");
        $hesaplanan_tutar=$this->input->post("hesaplanan_tutar");
        $dates=$this->input->post("dates");
        $invoice_id=$this->input->post("invoice_id");
        $acid=$this->input->post("acid");


        $date = datefordatabase($dates);

        $data = array(

            'tip' => $alacakak_borc,
            'cari_id' => $alt_customer_id,
            'islem_tipi' => $islem_tipi,
            'islem_id' => $islem_listesi,
            'tutar' => $alacak_tutar,
            'oran' => $oran,
            'hesaplanan_tutar' => $hesaplanan_tutar,
            'ana_cari_id' => $ana_cari_id,
            'invoice_id' => $invoice_id,
            'dates' => $date

        );

        $this->db->insert('geopos_cari_hesap', $data);
        $last_id_hesap= $this->db->insert_id();


        if($alacakak_borc==39)
        {
            $data2 = array(

                'acid' => $acid, //hesapID ekleneck

                'account' => $hesap_adi=account_details($acid)->holder, //hesap adı ekelenecek

                'debit' => 0, // eklenecek

                'credit' => $alacak_tutar,

                'total' => $alacak_tutar,
                'para_birimi' => 1,

                'kur_degeri' => 1,
                //'type' => $pay_type, // income expense

                'invoice_type_id'=>3,

                'invoice_type_desc'=>invoice_type_desc(3),

                //'cat' => $pay_cat,

                'method' => 1, //ödeme metodu ekelenecek

                'eid' =>   $this->aauth->get_user()->id, //user_id

                'notes' => invoice_type_desc(4),

                // 'ext'=>$ty, //müşterimi tedarikçimi gerek yok

                'loc' => $this->session->userdata('set_firma_id'),

            );
            $this->db->insert('geopos_invoices', $data2);
            $last_id = $this->db->insert_id();
            $datas = array(

                'invoice_id' => $invoice_id,
                'transaction_id' => $last_id,
                'total' => $alacak_tutar,
                'kur_degeri' => 1,
                'para_birimi' => 1,
                'method' => 1

            );

            $this->db->insert('geopos_invoice_transactions', $datas);
        }
        else
        {


            $invoice_id_islem=$this->input->post("invoice_id_islem");

            $sayi='mt-'.rand(10000,999999999);

            if($islem_tipi==3)
            {
                $this->db->set('invoice_id', "'$sayi'", FALSE);
                $this->db->set('oran', "$oran", FALSE);

                $this->db->where('id', $invoice_id_islem);

                $this->db->update('geopos_cari_hesap');
            }




            $this->db->set('invoice_id', "'$sayi'", FALSE);

            $this->db->where('id', $last_id_hesap);

            $this->db->update('geopos_cari_hesap');
        }




        echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla İşlendi'));




    }

    public function new_payinvoice(){
        $invoice_id = $this->input->post('invoice_id');
        $details = $this->db->query("SELECT * FROM geopos_invoices Where id = $invoice_id")->row();
        $proje_id = $details->proje_id;
        $proje_bolum_id = $details->bolum_id;
        $payer_id = $details->csd;
        $para_birimi = $this->input->post('para_birimi');
        $kur_degeri = $this->input->post('kur_degeri');
        $amount = $this->input->post('amount');
        $notes = $this->input->post('notes');
        $cari_pers_type = 1;
        $paymethod = $this->input->post('paymethod');
        $pay_acc = $this->input->post('pay_acc');
        $pay_type = $this->input->post('pay_type');
        $cari_in_invoice=$invoice_id;
        $date_ = new DateTime('now');
        $maas_yil=$date_->format('Y');
        $maas_ay=0;
        $status_is_avans =$this->input->post('status_is_avans', true);
        $pay_array =$this->input->post('pay_array', true);
        $payer_name=customer_details($payer_id)['company'];
        $is_avans_kasa=0;
        $toplam_odenen = 0;
        $toplam_avans = 0;
        $pers_id = 0;
        if($status_is_avans==0){
            if($pay_acc){
                $account_name=account_details($pay_acc)->holder;
            }
            else {
                $account_name='Kasasız İşlem';
                $pay_acc=0;
            }
            $data = array(
                'csd' => $payer_id,
                'payer' => $payer_name,
                'acid' => $pay_acc, //hesapID ekleneck
                'account' => $account_name, //hesap adı ekelenecek
                'total' => $amount,
                'invoice_type_id'=>$pay_type,
                'invoice_type_desc'=>invoice_type_desc($pay_type),
                'method' => $paymethod, //ödeme metodu ekelenecek
                'eid' => $this->aauth->get_user()->id, //user_id
                'notes' => $notes,
                'loc' => $this->session->userdata('set_firma_id'),
                'para_birimi' => $para_birimi,
                'kur_degeri' => $kur_degeri,
                'proje_id'=>$proje_id,
                'bolum_id'=>$proje_bolum_id,
                'cari_pers_type'=>$cari_pers_type,
                'maas_ay'=>$maas_ay,
                'maas_yil'=>$maas_yil

            );
            if($this->db->insert('geopos_invoices', $data)){
                $last_id = $this->db->insert_id();
                if($cari_in_invoice){
                    $data = array(
                        'invoice_id' => $cari_in_invoice,
                        'transaction_id' => $last_id,
                        'total' => $amount,
                        'kur_degeri' => $kur_degeri,
                        'para_birimi' => $para_birimi,
                        'method' => $paymethod,
                        'tip' => $cari_pers_type

                    );
                    $this->db->insert('geopos_invoice_transactions', $data);
                }
                $this->aauth->applog("Yeni İşlem Yapıldı : ".$last_id, $this->aauth->get_user()->username);
                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde İşleminiz Gerçekleştirildi'
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız.Yöneticiye Başvurunuz'
                ];
            }


        }
        else {
            $list = json_decode($pay_array);
            foreach ($list as $value_){


                $this->db->query("UPDATE `geopos_invoice_transactions` SET `invoice_id`=$invoice_id WHERE `transaction_id` = $value_->id ");

                $value= $this->db->query("SELECT * FROM geopos_invoices where id =$value_->id")->row();
                $value_s= $this->db->query("SELECT * FROM geopos_invoices where id =$invoice_id")->row();


                $is_avans_kasa =$value->acid;

                $payer_name = customer_details($value_s->csd)['company']; // müşteri adı
                $pers_id=$value->csd;
                $pers_name=$value->payer;
                $data=[
                    'total'=>$value_->price,
                    'tid'=>$value_->id,
                    'csd'=>$value_s->csd, //müştari
                    'payer'=>$payer_name, //müştari
                    'invoice_type_id'=>62, //müştari
                    'eid'=>$value_s->eid, //müştari
                    'invoice_type_desc'=>'Personel Cari Ödemesi', //müştari
                    'acid'=>$value->acid,
                    'account'=>$value->account,
                    'method'=>$value->method,
                    'para_birimi'=>$value->para_birimi,
                    'kur_degeri'=>$value->kur_degeri,
                    'cari_pers_type'=>1
                ];
                $this->db->insert('geopos_invoices', $data);
                $toplam_odenen+=$value_->price;
                $toplam_avans+=$value->total;
            }
            if($is_avans_kasa){
                if(floatval($toplam_odenen) > floatval($value_s->total) ){
                    //kasadan kalan parayı çık
                    $kalan = floatval($value_s->total)-floatval($toplam_avans);
                    $data=[
                        'total'=>$kalan,
                        'csd'=>$pers_id, //personel
                        'payer'=>$pers_name, //personel
                        'invoice_type_id'=>59, //
                        'eid'=> $this->aauth->get_user()->id,
                        'invoice_type_desc'=>'Personel İş Masrafı', //müştari
                        'acid'=>$is_avans_kasa,
                        'account'=>account_details($is_avans_kasa)->holder,
                        'method'=>1,
                        'para_birimi'=>1,
                        'kur_degeri'=>1,
                        'cari_pers_type'=>2
                    ];
                    $this->db->insert('geopos_invoices', $data);

                }
                else {
                    //kasaya parayı geri al
                    $kalan = floatval($toplam_avans)-floatval($value_s->total);
                    $data=[
                        'total'=>$kalan,
                        'csd'=>$pers_id, //personel
                        'payer'=>$pers_name, //personel
                        'invoice_type_id'=>60, //
                        'eid'=> $this->aauth->get_user()->id,
                        'invoice_type_desc'=>'Personel İş Masrafı Qalıq ', //müştari
                        'acid'=>$is_avans_kasa,
                        'account'=>account_details($is_avans_kasa)->holder,
                        'method'=>1,
                        'para_birimi'=>1,
                        'kur_degeri'=>1,
                        'cari_pers_type'=>2
                    ];
                    $this->db->insert('geopos_invoices', $data);
                }


            }

            $this->aauth->applog("Yeni İşlem Yapıldı : ".$invoice_id, $this->aauth->get_user()->username);
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde İşleminiz Gerçekleştirildi'
            ];
        }




    }

    public function new_create(){
        $end_date_islem = $this->input->post('end_date_islem');

        $date_ = new DateTime('now');
        if(!$end_date_islem){
            $end_date_islem=$date_->format('Y-m-d H:i:s');
        }

        $proje_id = $this->input->post('proje_id');
        $islem_turu_benzin_cen = $this->input->post('islem_turu_benzin_cen');
        $benzin_ltr = $this->input->post('benzin_ltr');
        $proje_bolum_id = $this->input->post('proje_bolum_id');
        $payer_id = $this->input->post('payer_id');
        $image = $this->input->post('image_text');
        $para_birimi = $this->input->post('para_birimi');
        $kur_degeri = $this->input->post('kur_degeri');
        $amount = $this->input->post('amount');
        $notes = $this->input->post('notes');
        $cari_pers_type = $this->input->post('cari_pers_type');
        $paymethod = $this->input->post('paymethod');
        $pay_acc = $this->input->post('pay_acc');
        $pay_type = $this->input->post('pay_type');
        $cari_in_invoice=0;
        $payer_name='';
        $group_id_val=0;
        $demirbas_firma_id=0;

        $maas_yil=$date_->format('Y');
        $maas_ay=0;
        if($cari_pers_type==1) // Cari
        {
            $payer_name=customer_details($payer_id)['company'];

            if($pay_type==3 || $pay_type==4 || $pay_type==22 || $pay_type==23){ //ödeme tahsilat devir borç devir alacak

            }
            else { // ya fatura yada forma2
                $cari_in_invoice = $this->input->post('cari_in_invoice');
            }

        }
        elseif($cari_pers_type==8) // Fehle
        {
            $payer_name=customer_details($payer_id)['company'];

            if($pay_type==3 || $pay_type==4 || $pay_type==22 || $pay_type==23){ //ödeme tahsilat devir borç devir alacak

            }
            else { // ya fatura yada forma2
                $cari_in_invoice = $this->input->post('cari_in_invoice');
            }

        }
        elseif($cari_pers_type==2) // Personel
        {
            $payer_name=personel_details_full($payer_id)['name'];
        }
        elseif($cari_pers_type==6) // Faktoring
        {
            $details = $this->db->query("SELECT * FROM geopos_invoices Where id = $payer_id")->row();
            $payer_name= $details->invoice_no.' | '.$details->invoice_name;
        }
        elseif($cari_pers_type==7) // Gider
        {
            $group_id_val = $this->input->post('group_id_val');
            $demirbas_firma_id = $this->input->post('firma_demirbas_id');

            $details = $this->db->query("SELECT * FROM demirbas_group Where id = $group_id_val")->row();
            $details2 = $this->db->query("SELECT * FROM demirbas_group Where id = $payer_id")->row();
            $payer_name= $details2->name.' | '.$details->name;
        }

        if($pay_acc){
            $account_name=account_details($pay_acc)->holder;
        }
        else {
            $account_name='Kasasız İşlem';
            $pay_acc=0;
        }


        $data = array(
            'islem_turu_benzin_cen' => $islem_turu_benzin_cen,
            'benzin_ltr' => $benzin_ltr,
            'csd' => $payer_id,
            'payer' => $payer_name,
            'acid' => $pay_acc, //hesapID ekleneck
            'account' => $account_name, //hesap adı ekelenecek
            'total' => $amount,
            'multi' => $group_id_val,
            'term' => $demirbas_firma_id,
            'invoice_type_id'=>$pay_type,
            'invoice_type_desc'=>invoice_type_desc($pay_type),
            'method' => $paymethod, //ödeme metodu ekelenecek
            'eid' => $this->aauth->get_user()->id, //user_id
            'notes' => $notes,
            'loc' => $this->session->userdata('set_firma_id'),
            'para_birimi' => $para_birimi,
            'kur_degeri' => $kur_degeri,
            'proje_id'=>$proje_id,
            'bolum_id'=>$proje_bolum_id,
            'cari_pers_type'=>$cari_pers_type,
            'maas_ay'=>$maas_ay,
            'masraf_id'=>0,
            'maas_yil'=>$maas_yil,
            'ext'=>$image,
            'end_date_islem'=>$end_date_islem,
            'invoicedate'=>$end_date_islem,

        );
        if($this->db->insert('geopos_invoices', $data)){
            $last_id = $this->db->insert_id();

            //Benzin Çen Kontrolü
            if($islem_turu_benzin_cen==1) // Benzin Çen
            {
                $desc = $notes;
                $benzin_type_id = $this->input->post('benzin_type_id');
                $data_benzin = array(
                    'invoice_id'=>$last_id,
                    'quantity'=>$benzin_ltr,
                    'benzin_type_id'=>0,
                    'tip'=>1,
                    'desc'=>$desc,
                    'unit_id'=>12,
                    'user_id' => $this->aauth->get_user()->id,
                    'loc' =>  $this->session->userdata('set_firma_id'),
                );
                $index=0;

                $this->db->insert('benzin_bakiye', $data_benzin);
            }
            elseif($islem_turu_benzin_cen==2) // Azpetrol Havuz
            {
                $amounth = $amount;
                $desc = $notes;
                $data_benzin = array(
                    'invoice_id'=>$last_id,
                    'amounth'=>$benzin_ltr,
                    'tip'=>1,
                    'desc'=>$desc,
                    'user_id' => $this->aauth->get_user()->id,
                    'loc' =>  $this->session->userdata('set_firma_id'),
                );

                $this->db->insert('azpetrol_bakiye', $data_benzin);
            }
            //Benzin Çen Kontrolü

            //gider create
            if($cari_pers_type==7){
                $result = $this->dmodel->gider_create_form($last_id,7);
            }
            //gider create

            if($cari_in_invoice==0){
                $cari_in_invoice=null;
            }
            $data = array(
                'invoice_id' => $cari_in_invoice,
                'transaction_id' => $last_id,
                'total' => $amount,
                'kur_degeri' => $kur_degeri,
                'para_birimi' => $para_birimi,
                'method' => $paymethod,
                'tip' => $cari_pers_type,
                'ext' => $image

            );
            $this->db->insert('geopos_invoice_transactions', $data);
            $this->aauth->applog("Yeni İşlem Yapıldu : ".$last_id, $this->aauth->get_user()->username);
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde İşleminiz Gerçekleştirildi'
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız.Yöneticiye Başvurunuz'
            ];
        }



    }
    public function update_image(){
        $transaction_id = $this->input->post('transaction_id');
        $image_text = $this->input->post('image_text');
        $this->db->set('ext', $image_text);
        $this->db->where('id', $transaction_id);
        if($this->db->update('geopos_invoices')){
            $this->aauth->applog("İşlemde Dosya Değiştirildi : ".$transaction_id, $this->aauth->get_user()->username);
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Dosya Güncellendi',
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız.Yöneticiye Başvurunuz'
            ];
        }
    }

    public function update_trans_new(){


        $date_ = new DateTime('now');
        $end_date_islem = $this->input->post('end_date_islem');
        if(!$end_date_islem){
            $end_date_islem=$date_->format('Y-m-d H:i:s');
        }
        $transaction_id_hidden = $this->input->post('transaction_id_hidden');
        $details = $this->details($transaction_id_hidden);
        $invoicedate=$details->invoicedate;

        $this->db->delete('geopos_invoices', array('id' => $transaction_id_hidden));
        $this->db->delete('geopos_invoice_transactions', array('transaction_id' => $transaction_id_hidden));

        $proje_id = $this->input->post('proje_id');
        $islem_turu_benzin_cen = $this->input->post('islem_turu_benzin_cen');
        $benzin_ltr = $this->input->post('benzin_ltr');
        $proje_bolum_id = $this->input->post('proje_bolum_id');
        $payer_id = $this->input->post('payer_id');
        $image = $this->input->post('image_text');
        $para_birimi = $this->input->post('para_birimi');
        $kur_degeri = $this->input->post('kur_degeri');
        $amount = $this->input->post('amount');
        $notes = $this->input->post('notes');
        $cari_pers_type = $this->input->post('cari_pers_type');
        $paymethod = $this->input->post('paymethod');
        $pay_acc = $this->input->post('pay_acc');
        $pay_type = $this->input->post('pay_type');
        $cari_in_invoice=0;
        $payer_name='';
        $demirbas_firma_id = 0;
        $group_id_val=0;

        $maas_yil=$date_->format('Y');
        $maas_ay=0;
        if($cari_pers_type==1) // Cari
        {
            $payer_name=customer_details($payer_id)['company'];

            if($pay_type==3 || $pay_type==4 || $pay_type==22 || $pay_type==23){ //ödeme tahsilat devir borç devir alacak

            }
            else { // ya fatura yada forma2
                $cari_in_invoice = $this->input->post('cari_in_invoice');
            }

        }
        elseif($cari_pers_type==8) // Fehle
        {
            $payer_name=customer_details($payer_id)['company'];

            if($pay_type==3 || $pay_type==4 || $pay_type==22 || $pay_type==23){ //ödeme tahsilat devir borç devir alacak

            }
            else { // ya fatura yada forma2
                $cari_in_invoice = $this->input->post('cari_in_invoice');
            }

        }
        elseif($cari_pers_type==2) // Personel
        {
            $payer_name=personel_details_full($payer_id)['name'];
        }
        elseif($cari_pers_type==6) // Faktoring
        {
            $details = $this->db->query("SELECT * FROM geopos_invoices Where id = $payer_id")->row();
            $payer_name= $details->invoice_no.' | '.$details->invoice_name;
        }
        elseif($cari_pers_type==7) // Gider
        {
            $group_id_val = $this->input->post('group_id_val');
            $demirbas_firma_id = $this->input->post('firma_demirbas_id');
            $details = $this->db->query("SELECT * FROM demirbas_group Where id = $group_id_val")->row();
            $details2 = $this->db->query("SELECT * FROM demirbas_group Where id = $payer_id")->row();
            $payer_name= $details2->name.' | '.$details->name;
        }

        if($pay_acc){
            $account_name=account_details($pay_acc)->holder;
        }
        else {
            $account_name='Kasasız İşlem';
            $pay_acc=0;
        }


        $data = array(
            'csd' => $payer_id,
            'islem_turu_benzin_cen' => $islem_turu_benzin_cen,
            'benzin_ltr' => $benzin_ltr,
            'payer' => $payer_name,
            'invoicedate' => $invoicedate,
            'acid' => $pay_acc, //hesapID ekleneck
            'account' => $account_name, //hesap adı ekelenecek
            'total' => $amount,
            'invoice_type_id'=>$pay_type,
            'invoice_type_desc'=>invoice_type_desc($pay_type),
            'method' => $paymethod, //ödeme metodu ekelenecek
            'eid' => $this->aauth->get_user()->id, //user_id
            'notes' => $notes,
            'loc' => $this->session->userdata('set_firma_id'),
            'para_birimi' => $para_birimi,
            'kur_degeri' => $kur_degeri,
            'proje_id'=>$proje_id,
            'bolum_id'=>$proje_bolum_id,
            'cari_pers_type'=>$cari_pers_type,
            'maas_ay'=>$maas_ay,
            'maas_yil'=>$maas_yil,
            'ext'=>$image,
            'end_date_islem'=>$end_date_islem,
            'multi' => $group_id_val,
            'term' => $demirbas_firma_id

        );
        if($this->db->insert('geopos_invoices', $data)){
            $last_id = $this->db->insert_id();


            //gider create
            if($cari_pers_type==7){
                $details_gider = $this->db->query("SELECT * FROM firma_gider Where talep_id = $transaction_id_hidden and type =7")->row();
                $delete_id = $details_gider->id;
                $this->db->delete('firma_gider', array('id' => $delete_id));
                $this->db->delete('firma_gider_products', array('form_id' => $delete_id));
                $result = $this->dmodel->gider_create_form($last_id,7);
            }
            //gider create

            //Benzin Çen Kontrolü




            $this->db->delete('azpetrol_bakiye', array('invoice_id' => $transaction_id_hidden));
            $this->db->delete('benzin_bakiye', array('invoice_id' => $transaction_id_hidden));
            if($islem_turu_benzin_cen==1) // Benzin Çen
            {

                $amounth = $amount;
                $desc = $notes;
                $benzin_type_id = $this->input->post('benzin_type_id');
                $data_benzin = array(
                    'invoice_id'=>$last_id,
                    'quantity'=>$benzin_ltr,
                    'benzin_type_id'=>0,
                    'tip'=>1,
                    'desc'=>$desc,
                    'unit_id'=>12,
                    'user_id' => $this->aauth->get_user()->id,
                    'loc' =>  $this->session->userdata('set_firma_id'),
                );
                $index=0;

                $this->db->insert('benzin_bakiye', $data_benzin);
            }
            elseif($islem_turu_benzin_cen==2) // Azpetrol Havuz
            {

                $amounth = $amount;
                $desc = $notes;
                $data_benzin = array(
                    'invoice_id'=>$last_id,
                    'amounth'=>$benzin_ltr,
                    'tip'=>1,
                    'desc'=>$desc,
                    'user_id' => $this->aauth->get_user()->id,
                    'loc' =>  $this->session->userdata('set_firma_id'),
                );

                $this->db->insert('azpetrol_bakiye', $data_benzin);
            }
            //Benzin Çen Kontrolü

            if($cari_in_invoice==0){
                $cari_in_invoice=null;
            }
            $data = array(
                'invoice_id' => $cari_in_invoice,
                'transaction_id' => $last_id,
                'total' => $amount,
                'kur_degeri' => $kur_degeri,
                'para_birimi' => $para_birimi,
                'method' => $paymethod,
                'tip' => $cari_pers_type,
                'ext' => $image

            );
            $this->db->insert('geopos_invoice_transactions', $data);
            $this->aauth->applog("İşlem Güncellendi : ".$last_id, $this->aauth->get_user()->username);
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde İşleminiz Gerçekleştirildi'
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız.Yöneticiye Başvurunuz'
            ];
        }



    }

    public function new_cancelinvoice(){
        $invoice_id= $this->input->post('invoice_id');
        $status_id= $this->input->post('status_id');
        $invoice_details=$this->details($invoice_id);
        $this->db->set('status', $status_id);
        $this->db->where('id', $invoice_id);
        if($this->db->update('geopos_invoices')){
            if($status_id==3){
                $this->db->delete('geopos_transactions', array('tid' => $invoice_id));
                $this->db->delete('geopos_project_items_gider', array('tid' => $invoice_id));
                $this->db->delete('firma_gider', array('talep_id' => $invoice_id,'type'=>6));
            }
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde İşleminiz Gerçekleştirildi'
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız.Yöneticiye Başvurunuz'
            ];
        }

    }



    public function details($transaction_id){
        $this->db->select('*');
        $this->db->from('geopos_invoices');
        $this->db->where('id',$transaction_id);
        $query = $this->db->get();
        return $query->row();
    }
    public function item_details($transaction_id){
        $this->db->select('*');
        $this->db->from('geopos_invoice_items');
        $this->db->where('id',$transaction_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function details_transaction($transaction_id){
        $this->db->select('*');
        $this->db->from('geopos_invoice_transactions');
        $this->db->where('transaction_id',$transaction_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function podradci_status_change()
    {
        $borclandirma_id= $this->input->post('borclandirma_id');
        $desc= $this->input->post('desc');
        $durum= $this->input->post('durum');
        $details = $this->db->query("SElECT * FROM talep_borclandirma WHERE id=$borclandirma_id")->row();


        $this->db->set('durum', $durum);
        $this->db->where('id', $borclandirma_id);
        if($this->db->update('talep_borclandirma')){



            if($durum==1){
                $b_id=$borclandirma_id;
                $cari_pers_type=$details->cari_pers_id;
                $invoice_type_id=53;
                $cari_name=personel_detailsa($details->payer_id)['name'];
                if($cari_pers_type==1){
                    $invoice_type_id=40;
                    $cari_name= customer_details($details->payer_id)['company'];
                }
                $messages='';
                $proje_id=0;
                $islem_tipi=$details->islem_tipi;
                $islem_id=$details->islem_id;
                $user_id_list=[];

                switch ($islem_tipi) {
                    case 1: // Malzeme Talebi İse
                        $code_details = $this->db->query("SELECT * FROM talep_form Where id=$islem_id")->row();
                        $proje_id=$code_details->proje_id;
                        $messages.=$code_details->code." Malzeme Talebine İstinaden Borçlandırma";
                        $user_id_list=onay_sort(1,$proje_id);
                        break;
                    case 2:  // Gider Talebi İse
                        $code_details = $this->db->query("SELECT * FROM talep_form_customer_new Where id=$islem_id")->row();
                        $proje_id=$code_details->proje_id;
                        $messages.=$code_details->code." Gider Talebine İstinaden Borçlandırma";
                        $user_id_list=onay_sort(2,$proje_id);
                        break;
                    case 3:  // Cari Avans Talebi İse
                        $code_details = $this->db->query("SELECT * FROM talep_form_customer Where id=$islem_id")->row();
                        $proje_id=$code_details->proje_id;
                        $messages.=$code_details->code.=" Cari Avans Talebine İstinaden Borçlandırma";
                        $user_id_list=onay_sort(4,$proje_id);
                        break;
                    case 4:  // Forma2 Talebi İse
                        $code_details = $this->db->query("SELECT * FROM geopos_invoices Where id=$islem_id")->row();
                        $proje_id=$code_details->proje_id;
                        $messages.=$code_details->invoice_no.=" Forma2 Talebine İstinaden Borçlandırma";
                        $user_id_list=onay_sort(8,$proje_id);
                        break;
                    case 5:  // Finans işlemi İse
                        $code_details = $this->db->query("SELECT * FROM geopos_invoices Where id=$islem_id")->row();
                        $proje_id=$code_details->proje_id;
                        $messages.=$code_details->id.=" IDli Finans İşlemine İstinaden Borçlandırma";
                        $user_id_list=[66,61];
                        break;
                    case 6:  // Qaime  İse
                        $code_details = $this->db->query("SELECT * FROM geopos_invoices Where id=$islem_id")->row();
                        $proje_id=$code_details->proje_id;
                        $messages.=$code_details->invoice_no.=" Qaimeye İstinaden Borçlandırma";
                        $user_id_list=onay_sort(12,$proje_id);
                        break;
                    case 7:  // Nakliye  İse
                        $code_details = $this->db->query("SELECT * FROM talep_form_nakliye Where id=$islem_id")->row();
                        $proje_id=$code_details->proje_id;
                        $messages.=$code_details->code.=" Nakliye Talebine İstinaden Borçlandırma";
                        $user_id_list=onay_sort(11,$proje_id);
                        break;
                }

                $data_invoices = array(
                    'csd' => $details->payer_id,
                    'payer' => $cari_name,
                    'acid' => 0,
                    'account' => '',
                    'total' => $details->tutar,
                    'invoice_type_id'=>$invoice_type_id,
                    'invoice_type_desc'=>invoice_type_desc($invoice_type_id),
                    'method' => 1, //ödeme metodu ekelenecek
                    'eid' => $this->aauth->get_user()->id, //user_id
                    'notes' =>  $messages,
                    'proje_id' => $proje_id,
                    'loc' => $this->aauth->get_user()->loc

                );

                if($this->db->insert('geopos_invoices', $data_invoices)){
                    $last_id = $this->db->insert_id();
                    $this->db->set('transaction_id', $last_id);
                    $this->db->where('id', $b_id);
                    $this->db->update('talep_borclandirma');
                    foreach ($user_id_list as $item_users){
                        $user_lis_array[]=personel_detailsa($item_users['user_id'])['email'];
                    }
                    $this->send_mail($user_lis_array,'Talep Borçalandırma Talebi',$messages.' Oluşturuldu.Borçlandırılan Şahıs : '.$cari_name.' Tutar : '.amountFormat($details->tutar).' Bilginize...');

                    //talep eden
                    $email = personel_detailsa($details->auth_id)['email'];
                    $user_lis_array_t=[$email];
                    $this->send_mail($user_lis_array_t,'Talep Borçalandırma Talebi HK.',' Durum Bildirildi : '.$desc);
                    //talep eden

                    return [
                        'status'=>1,
                        'message'=>'Başarılı Bir Şekilde İşleminiz Gerçekleştirildi'
                    ];
                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'İşlem Yapılamadı'
                    ];
                }
            }
            else {

                //talep eden
                $email = personel_detailsa($details->auth_id)['email'];
                $user_lis_array_t=[$email];
                $this->send_mail($user_lis_array_t,'Talep Borçalandırma Talebi HK.',' Durum Bildirildi : '.$desc);
                //talep eden

                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde İşleminiz Gerçekleştirildi'
                ];
            }

        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }


    }
    public function create_podradci_borc()
    {
        $user_id = $this->aauth->get_user()->id;
        $role_id = $this->aauth->get_user()->roleid;

        $payer_id= $this->input->post('payer_id'); // Cari Yada Personel ID
        $desc= $this->input->post('desc');
        $tutar= $this->input->post('tutar');
        $cari_pers_type= $this->input->post('cari_pers_type'); // 1=Cari 2= Personel cari = 40 personel = 34
        $islem_tipi= $this->input->post('islem_tipi'); //1=MT 2=GT 3=AT 4=forma2 5=finans işlemi 6=qaime
        $islem_id= $this->input->post('islem_id'); // Talep ID
        $tip= $this->input->post('tip');  //create talep

        if($tip=="create"){
            if($role_id==1 || $role_id==2 || $role_id==7 || $role_id==6 || $role_id==48){ // Baş Mühasib Mühasib Kömekçisi Yazılım Müdürü Direktor Müavini Şantiye Mühasib

                $data = [];
                $messages='';
                $proje_id=0;
                $user_lis_array=[];
                $user_id_list=[];
                switch ($islem_tipi) {
                    case 1: // Malzeme Talebi İse
                        $code_details = $this->db->query("SELECT * FROM talep_form Where id=$islem_id")->row();
                        $proje_id=$code_details->proje_id;
                        $messages.=$code_details->code." Malzeme Talebine İstinaden Borçlandırma";
                        $user_id_list=onay_sort(1,$proje_id);
                        break;
                    case 2:  // Gider Talebi İse
                        $code_details = $this->db->query("SELECT * FROM talep_form_customer_new Where id=$islem_id")->row();
                        $proje_id=$code_details->proje_id;
                        $messages.=$code_details->code." Gider Talebine İstinaden Borçlandırma";
                        $user_id_list=onay_sort(2,$proje_id);
                        break;
                    case 3:  // Cari Avans Talebi İse
                        $code_details = $this->db->query("SELECT * FROM talep_form_customer Where id=$islem_id")->row();
                        $proje_id=$code_details->proje_id;
                        $messages.=$code_details->code.=" Cari Avans Talebine İstinaden Borçlandırma";
                        $user_id_list=onay_sort(4,$proje_id);
                        break;
                    case 4:  // Forma2 Talebi İse
                        $code_details = $this->db->query("SELECT * FROM geopos_invoices Where id=$islem_id")->row();
                        $proje_id=$code_details->proje_id;
                        $messages.=$code_details->invoice_no.=" Forma2 Talebine İstinaden Borçlandırma";
                        $user_id_list=onay_sort(8,$proje_id);
                        break;
                    case 5:  // Finans işlemi İse
                        $code_details = $this->db->query("SELECT * FROM geopos_invoices Where id=$islem_id")->row();
                        $proje_id=$code_details->proje_id;
                        $messages.=$code_details->id.=" IDli Finans İşlemine İstinaden Borçlandırma";
                        $user_id_list=[66,61];
                        break;
                    case 6:  // Qaime  İse
                        $code_details = $this->db->query("SELECT * FROM geopos_invoices Where id=$islem_id")->row();
                        $proje_id=$code_details->proje_id;
                        $messages.=$code_details->invoice_no.=" Qaimeye İstinaden Borçlandırma";
                        $user_id_list=onay_sort(12,$proje_id);
                        break;
                    case 7:  // Nakliye  İse
                        $code_details = $this->db->query("SELECT * FROM talep_form_nakliye Where id=$islem_id")->row();
                        $proje_id=$code_details->proje_id;
                        $messages.=$code_details->code.=" Nakliye Talebine İstinaden Borçlandırma";
                        $user_id_list=onay_sort(11,$proje_id);
                        break;
                }

                $data=[
                    'islem_id'=>$islem_id,
                    'islem_tipi'=>$islem_tipi,
                    'tip'=>$tip,
                    'cari_pers_id'=>$cari_pers_type,
                    'tutar'=>$tutar,
                    'desc'=>$desc,
                    'payer_id'=>$payer_id,
                    'auth_id'=>$user_id,
                    'staff_id'=>0, // Onaylayacak muhasebe personeli
                    'durum'=>1, //tamamlanmış 0 ise onay bekliyor
                ];

                if($this->db->insert('talep_borclandirma', $data)){
                    $b_id = $this->db->insert_id();
                    //Borçlandırma

                    $invoice_type_id=53;
                    $cari_name=personel_detailsa($payer_id)['name'];
                    if($cari_pers_type==1){
                        $invoice_type_id=40;
                        $cari_name= customer_details($payer_id)['company'];
                    }
                    $data_invoices = array(
                        'csd' => $payer_id,
                        'payer' => $cari_name,
                        'acid' => 0,
                        'account' => '',
                        'total' => $tutar,
                        'invoice_type_id'=>$invoice_type_id,
                        'invoice_type_desc'=>invoice_type_desc($invoice_type_id),
                        'method' => 1, //ödeme metodu ekelenecek
                        'eid' => $this->aauth->get_user()->id, //user_id
                        'notes' =>  $messages,
                        'proje_id' => $proje_id,
                        'loc' => $this->aauth->get_user()->loc

                    );

                    if($this->db->insert('geopos_invoices', $data_invoices)){
                        $last_id = $this->db->insert_id();
                        $this->db->set('transaction_id', $last_id);
                        $this->db->where('id', $b_id);
                        $this->db->update('talep_borclandirma');
                        if($islem_tipi==5){
                            $user_lis_array=[21];
                        }
                        else {
                            foreach ($user_id_list as $item_users){
                                $user_lis_array[]=personel_detailsa($item_users['user_id'])['email'];
                            }
                        }


                        $this->send_mail($user_lis_array,'Talep Borçalandırma Talebi',$messages.' Oluşturuldu.Borçlandırılan Şahıs : '.$cari_name.' Tutar : '.amountFormat($tutar).' Bilginize...');
                        return [
                            'status'=>1,
                            'message'=>'Başarılı Bir Şekilde İşleminiz Gerçekleştirildi'
                        ];
                    }
                    else {
                        return [
                            'status'=>0,
                            'message'=>'İşlem Yapılamadı'
                        ];
                    }

                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Borçlandırma Yapılamadı'
                    ];
                }

            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Yetkiniz Bulunmamaktadır'
                ];
            }
        }
        else {
            $data = [];
            $messages='';
            $proje_id=0;
            $user_lis_array=[];
            $user_id_list=[];
            switch ($islem_tipi) {
                case 1: // Malzeme Talebi İse
                    $code_details = $this->db->query("SELECT * FROM talep_form Where id=$islem_id")->row();
                    $proje_id=$code_details->proje_id;
                    $messages.=$code_details->code." Malzeme Talebine İstinaden Borçlandırma";
                    break;
                case 2:  // Gider Talebi İse
                    $code_details = $this->db->query("SELECT * FROM talep_form_customer_new Where id=$islem_id")->row();
                    $proje_id=$code_details->proje_id;
                    $messages.=$code_details->code." Gider Talebine İstinaden Borçlandırma";
                    break;
                case 3:  // Cari Avans Talebi İse
                    $code_details = $this->db->query("SELECT * FROM talep_form_customer Where id=$islem_id")->row();
                    $proje_id=$code_details->proje_id;
                    $messages.=$code_details->code.=" Cari Avans Talebine İstinaden Borçlandırma";
                    break;
                case 4:  // Forma2 Talebi İse
                    $code_details = $this->db->query("SELECT * FROM geopos_invoices Where id=$islem_id")->row();
                    $proje_id=$code_details->proje_id;
                    $messages.=$code_details->invoice_no.=" Forma2 Talebine İstinaden Borçlandırma";
                    break;
                case 5:  // Finans işlemi İse
                    $code_details = $this->db->query("SELECT * FROM geopos_invoices Where id=$islem_id")->row();
                    $proje_id=$code_details->proje_id;
                    $messages.=$code_details->id.=" IDli Finans İşlemine İstinaden Borçlandırma";
                    break;
                case 6:  // Qaime  İse
                    $code_details = $this->db->query("SELECT * FROM geopos_invoices Where id=$islem_id")->row();
                    $proje_id=$code_details->proje_id;
                    $messages.=$code_details->invoice_no.=" Qaimeye İstinaden Borçlandırma";
                    break;
            }

            $proje_details = $this->db->query("SELECT * FROM geopos_projects Where id=$proje_id")->row();
            $muhasebe_muduru_id  = $proje_details->muhasebe_muduru_id;





            $data=[
                'islem_id'=>$islem_id,
                'islem_tipi'=>$islem_tipi,
                'tip'=>$tip,
                'cari_pers_id'=>$cari_pers_type,
                'tutar'=>$tutar,
                'desc'=>$desc,
                'payer_id'=>$payer_id,
                'auth_id'=>$user_id,
                'staff_id'=>$muhasebe_muduru_id, // Onaylayacak muhasebe personeli
                'durum'=>0, //tamamlanmış 0 ise onay bekliyor
            ];

            if($this->db->insert('talep_borclandirma', $data)){
                $user_lis_array[]=personel_detailsa($muhasebe_muduru_id)['email'];
                $this->send_mail($user_lis_array,'Talep Borçalandırma Talebi',$messages.' Talebi Oluşturuldu Onayınız bekliyor.');

                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde İşleminiz Gerçekleştirildi'
                ];


            }
            else {
                return [
                    'status'=>0,
                    'message'=>'İşlem Yapılamadı'
                ];
            }
        }

    }

    public function borclandirma_sil()
    {
        $user_id = $this->aauth->get_user()->id;
        $id= $this->input->post('id');
        $details = $this->db->query("SELECT * FROM talep_borclandirma Where id=$id")->row();
        if($details->auth_id == $user_id){

            $transaction_id = $details->transaction_id;
            $this->db->delete('geopos_invoices', array('id' => $transaction_id));
            if($this->db->delete('talep_borclandirma', array('id' => $id))){
                return [
                    'status'=>1,
                    'message'=>'İşlemler Başarıyla Silinmiştir!'
                ];
            }

        }
        else {
            return [
                'status'=>0,
                'message'=>'İşlemi Silmek İçin Yetkiniz Bulunmamaktadır!'
            ];
        }
    }

    public function send_mail($recipients,$subject,$message){
        $this->load->model('communication_model');

        $message .= "<br><br><br><br>";
        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
        $this->communication_model->onay_mail($recipients, $subject, $message, false,'', 'gider_talep_onay_maili');
        return 1;
    }


    public function podradci_borclandirma_list()

    {
        $this->_podradci_borclandirma_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _podradci_borclandirma_list()

    {

        $this->db->select('*');
        $this->db->from('talep_borclandirma');
        $this->db->where('staff_id',$this->aauth->get_user()->id);
        $this->db->where('durum',0);

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

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`talep_borclandirma`.`id` DESC');

    }


    public function podradci_borclandirma_count_filtered()
    {
        $this->_podradci_borclandirma_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function podradci_borclandirma_count_all()
    {
        $this->_podradci_borclandirma_list();
        return $this->db->count_all_results();
    }
}
