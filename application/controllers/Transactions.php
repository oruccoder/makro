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



class Transactions extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->library("Aauth");

        $this->load->model('invoices_model');

        $this->load->model('transactions_model', 'transactions');
        $this->load->model('Demirbas_model', 'dmodel');

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }


    }



    public function index()

    {
        $head['title'] = "Finans İşlemleri";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/index');
        $this->load->view('fixed/footer');

    }



    public function add__()

    {

        if (!$this->aauth->premission(5)) {



            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');



        }

        $data['cat'] = $this->transactions->categories();

        $data['accounts'] = $this->transactions->acc_list();

        $head['title'] = "Yeni İşlem";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('transactions/create', $data);

        $this->load->view('fixed/footer');



    }

    public function edit()

    {

        $id = $this->input->get('id');

        if (!$this->aauth->premission(5)) {



            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');



        }

        $data['cat'] = $this->transactions->categories();
        $data['trans_id'] =$id;

        $data['accounts'] = $this->transactions->acc_list();
        $data['editdata'] = $this->transactions->view($id);

        $head['title'] = "Düzenle";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('transactions/edit', $data);

        $this->load->view('fixed/footer');



    }



    public function transfer()

    {

        if (!$this->aauth->premission(5)) {



            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');



        }

        $para_birimi=1;


        $data['cat'] = $this->transactions->categories();

        $data['accounts'] = $this->transactions->acc_list($para_birimi);

        $head['title'] = "Yeni Transfer";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('transactions/transfer', $data);

        $this->load->view('fixed/footer');



    }

    public function doviz_transfer()

    {

        if (!$this->aauth->premission(28)->write) {

            exit('<h3>Yetkiniz Bulunmamaktadır</h3>');
        }


        $data['cat'] = $this->transactions->categories();

        $data['accounts'] = $this->transactions->acc_list();

        $head['title'] = "Yeni Döviz Transfer";

        $head['usernm'] = $this->aauth->get_user()->username;
        $data['kasa']=personel_account($this->aauth->get_user()->id);

        $this->load->view('fixed/header', $head);

        $this->load->view('transactions/doviz_transfer', $data);

        $this->load->view('fixed/footer');



    }


    public function new_payinvoice(){
    

            $this->db->trans_start();
            $result = $this->transactions->new_payinvoice();
            if($result['status']){
                echo json_encode(array('status' => 200,'message' =>$result['message']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }

    }

    public function payinvoice()

    {




        $credit = 0;

        $debit = 0;

        $payer_id = $this->input->post('cid', true); // müşteri ID

        $payer_ty = 0; // müşterimi tedarikçi mi

        $payer_name = customer_details($payer_id)['company']; // müşteri adı

        $pay_acc = $this->input->post('account', true); //hesap ıd kasalar

//        $date = $this->input->post('paydate', true); // tarih

        $amount = (float)$this->input->post('amount', true); // tutar



        $status_is_avans =$this->input->post('status_is_avans', true);
        $pay_array =$this->input->post('pay_array', true);









        $para_birimi_post = $this->input->post('para_birimi', true); // para birimi
        $kur_degeri = $this->input->post('kur_degeri', true); // para birimi
        $paymethod = $this->input->post('pmethod', true); // Method
        $pay_type = $this->input->post('pay_type', true); // Method

        // income ise credit
        // expense ise debit

        if ($pay_type == '6' || $pay_type == '4' || $pay_type == '12' || $pay_type == '15' || $pay_type == '17' ||  $pay_type == '18'  || $pay_type == '20') { //ödeme

            $debit = $amount;

        } elseif ($pay_type == '3' || $pay_type == '5'  || $pay_type == '13'  || $pay_type == '16'  || $pay_type == '19'  || $pay_type == '5' || $pay_type == '21'  || $pay_type == '21') { //tahsilat

            $credit = $amount;

        }

        $pay_cat = 'Income'; // işlem kategorisi



        $note = $this->input->post('shortnote'); // not

//        $date = datefordatabase($date);
        $invoice_id = $this->input->post('tid', true); // tarih



        $cari_pers_type=1;


        if($amount>0) {
            $proje_id=0;
            $details = $this->db->query("SELECT * FROM geopos_invoices WHERE id=$invoice_id");
            if($details->num_rows()>0)
            {
                if($details->row()->proje_id!=0)
                {
                    $proje_id=$details->row()->proje_id;
                }
            }





            if($status_is_avans==0){
                if ($this->transactions->addtransinv(
                    $payer_id,
                    $payer_name,
                    $pay_acc,
                    $debit,
                    $credit,
                    $pay_type,
                    $pay_cat,
                    $paymethod,
                    $note,
                    $this->aauth->get_user()->id,
                    $this->aauth->get_user()->loc,
                    $payer_ty,
                    $amount,
                    $para_birimi_post,
                    $kur_degeri
                    ,0,0,0,$proje_id,$cari_pers_type,
                    $invoice_id,'')) {

                    $lid = $this->db->insert_id();

                    if($this->transactions->add_invoice_transaction('add',$invoice_id,$lid,$amount,$para_birimi_post,$kur_degeri,$paymethod,'','')){
                        echo json_encode(array('status' => 'Success', 'message' =>

                            $this->lang->line('Transaction has been') . "  <a href='" . base_url() . "transactions/add' class='btn btn-indigo btn-sm'><span class='icon-plus-circle' aria-hidden='true'></span> " . $this->lang->line('New') . "  </a> <a href='" . base_url() . 'transactions/view?id=' . $lid . "' class='btn btn-primary btn-xs'><span class='icon-eye'></span>  " . $this->lang->line('View') . "</a> <a href='" . base_url() . "transactions' class='btn btn-indigo btn-sm'><span class='icon-list-ul' aria-hidden='true'></span></a>"));

                    }


                }
            }
            else {





                $is_avans_kasa =$this->input->post('is_avans_kasa', true);
                $toplam_odenen = 0;
                $toplam_avans = 0;
                $pers_id = 0;
                $list = json_decode($pay_array);
                foreach ($list as $value_){
                    $this->db->query("UPDATE `geopos_invoice_transactions` SET `invoice_id`=$invoice_id WHERE `transaction_id` = $value_->id ");
                    $value= $this->db->query("SELECT * FROM geopos_invoices where id =$value_->id")->row();
                    $value_s= $this->db->query("SELECT * FROM geopos_invoices where id =$invoice_id")->row();
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
                echo json_encode(array('status' => 'Success', 'message' =>"Başarıyla Kayıt Edildi"));


            }


        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                'Error!'));

        }



    }





    public function paypurchase()

    {



        if (!$this->aauth->premission(2)) {



            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');



        }



        $tid = $this->input->post('tid', true);

        $amount = $this->input->post('amount', true);

        $paydate = $this->input->post('paydate', true);

        $note = $this->input->post('shortnote', true);

        $pmethod = $this->input->post('pmethod', true);

        $acid = $this->input->post('account', true);

        $cid = $this->input->post('cid', true);

        $cname = $this->input->post('cname', true);

        $paydate = datefordatabase($paydate);



        $this->db->select('holder');

        $this->db->from('geopos_accounts');

        $this->db->where('id', $acid);

        $query = $this->db->get();

        $account = $query->row_array();



        $data = array(

            'acid' => $acid,

            'account' => $account['holder'],

            'type' => 'Expense',

            'cat' => 'Purchase',

            'debit' => $amount,

            'payer' => $cname,

            'payerid' => $cid,

            'method' => $pmethod,

            'date' => $paydate,

            'eid' => $this->aauth->get_user()->id,

            'tid' => $tid,

            'note' => $note,

            'ext' => 1,

            'loc' => $this->aauth->get_user()->loc

        );



        $this->db->insert('geopos_transactions', $data);

        $this->db->insert_id();



        $this->db->select('total,csd,pamnt');

        $this->db->from('geopos_purchase');

        $this->db->where('id', $tid);

        $query = $this->db->get();

        $invresult = $query->row();



        $totalrm = $invresult->total - $invresult->pamnt;



        if ($totalrm > $amount) {

            $this->db->set('pmethod', $pmethod);

            $this->db->set('pamnt', "pamnt+$amount", FALSE);



            $this->db->set('status', 'partial');

            $this->db->where('id', $tid);

            $this->db->update('geopos_purchase');





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

            $this->db->set('status', 'paid');

            $this->db->where('id', $tid);

            $this->db->update('geopos_purchase');

            //acount update

            $this->db->set('lastbal', "lastbal-$amount", FALSE);

            $this->db->where('id', $acid);

            $this->db->update('geopos_accounts');



            $totalrm = 0;

            $status = 'Paid';

            $paid_amount = $amount;





        }





        $activitym = "<tr><td>" . substr($paydate, 0, 10) . "</td><td>$pmethod</td><td>$amount</td><td>$note</td></tr>";





        echo json_encode(array('status' => 'Success', 'message' =>

            $this->lang->line('Transaction has been added'), 'pstatus' => $this->lang->line($status), 'activity' => $activitym, 'amt' => $totalrm, 'ttlpaid' => $paid_amount));

    }






    public function cancelinvoice()

    {

        if (!$this->aauth->premission(1)->update) {

            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else
        {
            $tid = intval($this->input->post('tid'));

            $this->db->set('pamnt', "0.00", FALSE);

            $this->db->set('total', "0.00", FALSE);

            $this->db->set('items', 0);

            $this->db->set('status', '3');

            $this->db->where('id', $tid);

            $this->db->update('geopos_invoices');

            //reverse

            $this->db->select('credit,acid');

            $this->db->from('geopos_transactions');

            $this->db->where('tid', $tid);

            $query = $this->db->get();

            $revresult = $query->result_array();

            foreach ($revresult as $trans) {

                $amt = $trans['credit'];

                $this->db->set('lastbal', "lastbal-$amt", FALSE);

                $this->db->where('id', $trans['acid']);

                $this->db->update('geopos_accounts');

            }

            $this->db->select('pid,qty,depo_id');

            $this->db->from('geopos_invoice_items');

            $this->db->where('tid', $tid);

            $query = $this->db->get();

            $prevresult = $query->result_array();

            //type
            $this->db->select('*');

            $this->db->from('geopos_invoices');

            $this->db->where('id', $tid);

            $query = $this->db->get();

            $result = $query->row_array();

            $invoice_type=$result['invoice_type_id'];

            $depo=$result['depo'];
            $toplam_rulo=0;
            $invoice_type_new=0;


            //type

            if($invoice_type==2)
            {
                $invoice_type_new=1;
            }

            else if($invoice_type==1)
            {
                $invoice_type_new=2;
            }
            else if($invoice_type==7)
            {
                $invoice_type_new=1;
            }
            else if($invoice_type==8)
            {
                $invoice_type_new=2;
            }

            foreach ($prevresult as $prd) {




                $prdid=$prd['pid'];
                $amt = $prd['qty'];
                $depo_id = $prd['depo_id'];

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




                    $this->stock_update($eklenecek_stok,$parent_id, $invoice_type_new,$toplam_rulo,$depo_id); //ana ürüne eklenecek 730

                    $this->stock_update($amt,$prdid, $invoice_type_new,$toplam_rulo,$depo_id); //731


                } else {
                    $this->stock_update($amt,$prdid, $invoice_type_new,$toplam_rulo,$depo_id); //731

                }

            }

            $this->db->delete('geopos_transactions', array('tid' => $tid));
            $this->db->delete('geopos_project_items_gider', array('tid' => $tid));

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('Invoice canceled')));
        }







    }





    public function cancelpurchase()

    {



        if (!$this->aauth->premission(2)) {



            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');



        }



        $tid = intval($this->input->post('tid'));





        $this->db->set('pamnt', "0.00", FALSE);

        $this->db->set('status', 4);

        $this->db->where('id', $tid);

        $this->db->update('geopos_purchase');



        //reverse

        $this->db->select('debit,credit,acid');

        $this->db->from('geopos_transactions');

        $this->db->where('tid', $tid);

        $this->db->where('ext', 1);

        $query = $this->db->get();

        $revresult = $query->result_array();



        foreach ($revresult as $trans) {

            $amt = $trans['debit'];

            $this->db->set('lastbal', "lastbal+$amt", FALSE);

            $this->db->where('id', $trans['acid']);

            $this->db->update('geopos_accounts');

        }

        $this->db->select('pid,qty');

        $this->db->from('geopos_purchase_items');

        $this->db->where('tid', $tid);

        $query = $this->db->get();

        $prevresult = $query->result_array();



        $this->db->select('*');

        $this->db->from('geopos_purchase');

        $this->db->where('id', $tid);

        $query2 = $this->db->get();

        $prevresult_S = $query2->row_array();

        $invoice_type=$prevresult_S['status'];
        $depo_id=$prevresult_S['depo_id'];

        $invoice_type_new=0;



        //type

        if($invoice_type==1)
        {
            //hiç bir şey yapma
            $invoice_type_new=0;
        }

        else if($invoice_type==2) //bekliyor
        {
            //rezerve sil
            $invoice_type_new=10;
        }
        else if($invoice_type==3)
        {
            //onay qty yerine ekle
            $invoice_type_new=2;
        }

        $toplam_rulo=0;


        foreach ($prevresult as $prd) {




            $prdid=$prd['pid'];
            $amt = $prd['qty'];

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




                $this->stock_update($eklenecek_stok,$parent_id, $invoice_type_new,$toplam_rulo,$depo_id); //ana ürüne eklenecek 730

                $this->stock_update($amt,$prdid, $invoice_type_new,$toplam_rulo,$depo_id); //731


            } else {
                $this->stock_update($amt,$prdid, $invoice_type_new,$toplam_rulo,$depo_id); //731

            }

        }

        $this->db->delete('geopos_transactions', array('tid' => $tid, 'ext' => 1));

        echo json_encode(array('status' => 'Success', 'message' =>

            $this->lang->line('Purchase canceled!')));

    }





    public function translist()

    {

        if (!$this->aauth->premission(51)) {

            exit('<h3>Giriş Yetkiniz Bulunmamaktadır</h3>');

        }



        $ttype = $this->input->get('type');

        $list = $this->transactions->get_datatables($ttype);

        $data = array();

        // $no = $_POST['start'];

        $no = $this->input->post('start');
        // echo '<pre>';print_r($list);die();

        foreach ($list as $prd) {

            $edit_button='';

            $image='';
            if(isset($prd->ext))
            {
                if($prd->ext!='default.png' && $prd->ext!='')
                {
                    $image='<a target="_blank" href="' . base_url() . 'userfiles/product/' . $prd->ext . '" class="dropdown-item btn btn-primary btn-xs">
            Dosya</a> ';
                }

            }


            $total=$prd->total*$prd->kur_degeri;
            $debit=amountFormat($total,$prd->para_birimi);

            $no++;

            $row = array();

            $pid = $prd->trns_id;

//            if($prd->invoice_type_id==27 || $prd->invoice_type_id==28 )
//            {
//                $edit_button='';
//            }
//            else
//            {
//                $edit_button='<a href="' . base_url() . 'transactions/edit?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a> ';
//
//            }
            $vouns='';
            $voun=$this->db->query("SELECT * FROM geopos_customers Where company='$prd->payer'");
            if($voun->num_rows()){
                $vouns=$voun->row()->taxid;
            }




            $mt_button_list='';
            $mt=$this->db->query("SELECT * FROM talep_form_transaction Where islem_id=$pid and talep_form_avans_id=0 and tip=1");
            if($mt->num_rows()){
                foreach ($mt->result() as $mt_items){
                    $mt_code = $this->db->query("SELECT * FROM talep_form WHERE id=$mt_items->form_id")->row()->code;
                    $mt_button_list.='<a href="' . base_url() . '/malzemetalep/view/1995' . $mt_items->form_id . '" class="btn btn-info btn-sm">'.$mt_code.' GÖRÜNTÜLE</a>';
                }

            }

            $views='<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="dropdown-item">GÖRÜNTÜLE</a>';
            $edit_button='<button type="button" id="'.$pid.'" class="dropdown-item edit_transaction_button">DÜZENLE</button> ';
            $parcala='<button type="button" id="'.$pid.'" csd="'.$prd->csd.'" class="dropdown-item parcala">PARÇALA</button> ';
            $mt_button='<button pay_id="'.$pid.'" class="dropdown-item mt_button">MALZEME TALEBİNE BAĞLA</button> ';
            $trans_edit='<button transaction_id="'.$pid.'" type="button" class="dropdown-item transaction_edit">HIZLI DÜZENLEME</button>';
            $image_button='<button data-invoice_id="'.$pid.'" class="dropdown-item invoice_image ">DOSYA YÜKLE</button>';
            $gider_button='                                                                    
    <button  type="button" class="dropdown-item button_podradci_borclandirma" islem_id="'.$pid.'" islem_tipi="5" tip="create" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Podradçi / Personel Borçlandır">PODRADÇI / PERSONEL BORÇLANDIR</button>
';
            $podradci_button='<button data-invoice_id="'.$pid.'" class="dropdown-item gider_ekle ">KOMİSYON OLARAK İŞLE</button>';
            $qaimeye_isle='<button data-invoice_id="'.$pid.'" class="dropdown-item qaime_isle ">QAİME İŞLE</button>';


            $buttons_='<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    İşlemler
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    '.$image.'
    '.$views.'
    '.$edit_button.'
    '.$parcala.'
    '.$mt_button.'
    '.$trans_edit.'
    '.$image_button.'
    '.$gider_button.'
    '.$podradci_button.'
    '.$qaimeye_isle.'
  </div>
</div>';

            $row[] = $no;
            $row[] = dateformat($prd->invoicedate);

            $row[] = $prd->account;
            $row[] = $prd->payer;

            $row[] = $debit;


            $row[] = account_type_sorgu($prd->method);

            $row[] = $prd->invoice_type_desc;

            $row[] = $buttons_;

            /* $row[] = $image.'<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs">
           <span class="icon-eye"></span>  ' . $this->lang->line('View') . '</a> '.$edit_button.'
            <a href="' . base_url() . 'transactions/print_t?id=' . $pid . '" class="btn btn-info btn-xs"  title="Print">
            <i class="fa fa-print" aria-hidden="true"></i></a>';*/

            $row[] = personel_details($prd->eid);
            $row[] = $prd->notes.'<br>'.$mt_button_list;
            $row[] = $vouns;
            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->transactions->count_all(),

            "recordsFiltered" => $this->transactions->count_filtered(),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);

    }




    public function save_trans()

    {

        if (!$this->aauth->premission(5)) {



            exit('<h3>Üzgünüm! Bu Bölüme Giriş İzniniz Bulunmamaktadır</h3>');

        }

        $this->db->trans_start();
        $credit = 0;

        $debit = 0;

        $payer_id = $this->input->post('payer_id', true); // müşteri ID var ise müşteri ID yok ise 0


        $payer_ty = $this->input->post('ty_p', true); // müşterimi tedarikçi mi  //0

        $payer_name = $this->input->post('payer_name', true); // müşteri adı  //Masraf Adı

        $pay_acc = $this->input->post('pay_acc', true); //hesap ıd kasalar

//        $date = $this->input->post('date', true); // tarih

        $amount = (float)$this->input->post('amount', true); // tutar

        $pay_type = $this->input->post('pay_type', true); // Income Expense işlem türü // 4
        $cari_pers_type = $this->input->post('cari_pers_type', true); // cari Personel Masraf
        $masraf_id = $this->input->post('masraf_id', true); // cari Personel Masraf
        $proje_id = $this->input->post('proje_id', true); // cari Personel Masraf
        $maas_ay = $this->input->post('maas_ay', true) ;
        $proje_bolum_id = $this->input->post('proje_bolum_id', true) ;



        $para_birimi = $this->input->post('para_birimi', true); // para birimi
        $kur_degeri = $this->input->post('kur_degeri', true); // para birimi
        $image = $this->input->post('image');

        $dosya_id = $this->input->post('dosya_id');
        $ithalat_ihracat_tip = $this->input->post('ithalat_ihracat_tip');

        // income ise credit
        // expense ise debit

        if ($pay_type == '6' || $pay_type == '4' || $pay_type == '12' || $pay_type == '14' || $pay_type == '16' ||  $pay_type == '17'  || $pay_type == '19' || $pay_type == '21' || $pay_type == '43' || $pay_type == '45') { //ödeme

            $debit = $amount;

        } elseif ($pay_type == '3' || $pay_type == '5'  || $pay_type == '13'  || $pay_type == '15'  || $pay_type == '18'  || $pay_type == '5' || $pay_type == '20'  || $pay_type == '44' || $pay_type == '46' ) { //tahsilat

            $credit = $amount;

        }







        $pay_cat = $this->input->post('pay_cat'); // işlem kategorisi

        $paymethod = $this->input->post('paymethod'); // ödeme türü

        $note = $this->input->post('note'); // not
        $talep_id = $this->input->post('talep_id'); // not

//        $date = datefordatabase($date);







        if($amount>0) {

            $invoice_id_masraf=0;

            if($cari_pers_type==3)
            {

                $invoice_id_masraf = $this->input->post('invoice_id_masraf', true); // müşteri ID var ise müşteri ID yok ise 0

            }
            else
            {

                $invoice_id_masraf = $this->input->post('cari_in_invoice', true); // tarih

            }



            $lid=$this->transactions->addtransinv($payer_id, $payer_name, $pay_acc, $debit, $credit, $pay_type, $pay_cat, $paymethod, $note, $this->aauth->get_user()->id,
                $this->aauth->get_user()->loc, $payer_ty,$amount,$para_birimi,$kur_degeri,$masraf_id,$dosya_id,$ithalat_ihracat_tip,$proje_id,$cari_pers_type,$invoice_id_masraf,$image,$maas_ay,$proje_bolum_id,$talep_id);
            // if ($this->transactions->addtrans($payer_id, $payer_name, $pay_acc, $date, $debit, $credit, $pay_type, $pay_cat, $paymethod, $note, $this->aauth->get_user()->id, $this->aauth->get_user()->loc, $payer_ty)) {
            if ($lid) {


                $this->aauth->applog("Yeni Finans İşlemi Oluşturuldu $lid ID ",$this->aauth->get_user()->username);
                kont_kayit(12,$lid);

                $this->transactions->add_invoice_transaction('add',$invoice_id_masraf,$lid,$amount,$para_birimi,$kur_degeri,$paymethod,$cari_pers_type,$image);


                // EĞer KDV ÖDEMESİ SEÇİLİ İSE
                $kdv_durum=$this->input->post('kdv_durumu', true);

                if(isset($kdv_durum))
                {

                    $paymethod_kdv = $this->input->post('paymethod_kdv'); // ödeme türü
                    $pay_acc_kdv = $this->input->post('pay_acc_kdv', true);
                    $amount_kdv = (float)$this->input->post('amount_kdv', true); // tutar
                    $note_kdv = $this->input->post('note_kdv'); // not
                    $pay_type_kdv = $this->input->post('pay_type_kdv'); // not

                    $this->transactions->addtransinv($payer_id, $payer_name, $pay_acc_kdv, $debit, $credit, $pay_type_kdv, $pay_cat, $paymethod_kdv, $note_kdv, $this->aauth->get_user()->id,
                        $this->aauth->get_user()->loc, $payer_ty,$amount_kdv,$para_birimi,$kur_degeri,$masraf_id,$dosya_id,$ithalat_ihracat_tip,$proje_id,$cari_pers_type,$invoice_id_masraf,$image);
                    $kdv_last_id = $this->db->insert_id();

                    $lid2 = $this->db->insert_id();
                    $this->aauth->applog("Yeni Finans KDV İşlemi Oluşturuldu $lid2 ID ",$this->aauth->get_user()->username);
                    kont_kayit(12,$kdv_last_id);

                    $this->transactions->add_invoice_transaction('add',$invoice_id_masraf,$kdv_last_id,$amount_kdv,$para_birimi,$kur_degeri,$paymethod_kdv,$cari_pers_type,$image);


                }
                // EĞer KDV ÖDEMESİ SEÇİLİ İSE

                if($this->input->post('status')){
                    $status = $this->input->post('status');
                    $this->db->query("UPDATE `geopos_invoices` SET `status`=$status WHERE id = $invoice_id_masraf");
                }


                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success', 'message' =>

                    $this->lang->line('Transaction has been') . "  <a href='" . base_url() . "transactions/add' class='btn btn-indigo btn-sm'><span class='icon-plus-circle' aria-hidden='true'></span> " . $this->lang->line('New') . "  </a> <a href='" . base_url() . 'transactions/view?id=' . $lid . "' class='btn btn-primary btn-xs'><span class='icon-eye'></span>  " . $this->lang->line('View') . "</a> <a href='" . base_url() . "transactions' class='btn btn-indigo btn-sm'><span class='icon-list-ul' aria-hidden='true'></span></a>"));

            }

        } else {

            $this->db->trans_rollback();

            echo json_encode(array('status' => 'Error', 'message' =>

                'Error!'));

        }





    }

    public function edit_trans()

    {



        if (!$this->aauth->premission(5)) {



            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');



        }




        $this->db->trans_start();
        $credit = 0;

        $debit = 0;

        $trans_id = $this->input->post('trans_id', true); // müşteri ID
        $payer_id = $this->input->post('payer_id', true); // müşteri ID

        $payer_ty = $this->input->post('ty_p', true); // müşterimi tedarikçi mi

        $payer_name = $this->input->post('payer_name', true); // müşteri adı

        $pay_acc = $this->input->post('pay_acc', true); //hesap ıd kasalar

//        $date = $this->input->post('date', true); // tarih

        $amount = (float)$this->input->post('amount', true); // tutar

        $pay_type = $this->input->post('pay_type', true); // Income Expense işlem türü // 4
        $cari_pers_type = $this->input->post('cari_pers_type', true); // cari Personel Masraf
        $masraf_id=0;
        if($this->input->post('masraf_id', true)!=''){
            $masraf_id = $this->input->post('masraf_id', true); // cari Personel Masraf
        }

        $proje_id = $this->input->post('proje_id', true); // cari Personel Masraf
        $proje_bolum_id = $this->input->post('proje_bolum_id', true); // cari Personel Masraf



        $para_birimi = $this->input->post('para_birimi', true); // para birimi
        $kur_degeri = $this->input->post('kur_degeri', true); // para birimi

        $dosya_id = $this->input->post('dosya_id');
        $ithalat_ihracat_tip = $this->input->post('ithalat_ihracat_tip');
        $image = $this->input->post('image');

        // income ise credit
        // expense ise debit

        if ($pay_type == '6' || $pay_type == '4' || $pay_type == '12' || $pay_type == '14' || $pay_type == '16' ||  $pay_type == '17'  || $pay_type == '19' || $pay_type == '21') { //ödeme

            $debit = $amount;

        } elseif ($pay_type == '3' || $pay_type == '5'  || $pay_type == '13'  || $pay_type == '15'  || $pay_type == '18'  || $pay_type == '5' || $pay_type == '20'  ) { //tahsilat

            $credit = $amount;

        }

        $pay_cat = $this->input->post('pay_cat'); // işlem kategorisi

        $paymethod = $this->input->post('paymethod'); // ödeme türü

        $note = $this->input->post('note'); // not

//        $date = datefordatabase($date);



        if($amount>0) {



            if ($this->transactions->edit_trans($trans_id,$payer_id, $payer_name, $pay_acc, $debit, $credit, $pay_type,
                $pay_cat, $paymethod, $note, $this->aauth->get_user()->id, $this->aauth->get_user()->loc, $payer_ty,$amount,$para_birimi
                ,$kur_degeri,$masraf_id,$dosya_id,$ithalat_ihracat_tip,$proje_id,$cari_pers_type,$image,$proje_bolum_id)) {

                $lid = $trans_id;



                if($pay_type==17 || $pay_type==18 || $pay_type==19 || $pay_type==20|| $pay_type==45|| $pay_type==46 || $pay_type==3 || $pay_type==54 || $pay_type==65 || $pay_type==55 || $pay_type==61)
                {

                    if($cari_pers_type==3)
                    {

                        $invoice_id_masraf = $this->input->post('invoice_id_masraf'); // müşteri ID var ise müşteri ID yok ise 0

                    }
                    else
                    {

                        $invoice_id_masraf = $this->input->post('cari_in_invoice'); // tarih

                    }



                    $this->transactions->add_invoice_transaction('edit',$invoice_id_masraf,$lid,$amount,$para_birimi,$kur_degeri,$paymethod,$cari_pers_type,'');





                }

				$this->aauth->applog("Finans İşlemi Düzenlendi $lid ID ",$this->aauth->get_user()->username);

                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success', 'message' =>

                    $this->lang->line('Transaction has been') . "  <a href='" . base_url() . "transactions/add' class='btn btn-indigo btn-sm'><span class='icon-plus-circle' aria-hidden='true'></span> " . $this->lang->line('New') . "  </a> <a href='" . base_url() . 'transactions/view?id=' . $lid . "' class='btn btn-primary btn-xs'><span class='icon-eye'></span>  " . $this->lang->line('View') . "</a> <a href='" . base_url() . "transactions' class='btn btn-indigo btn-sm'><span class='icon-list-ul' aria-hidden='true'></span></a>"));

            }

        } else {

            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>

                'Error!'));

        }





    }



    public function save_transfer()

    {

        if (!$this->aauth->premission(5)) {



            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');



        }



        $pay_acc = $this->input->post('pay_acc'); // Çıkan Hesap

        $pay_acc2 = $this->input->post('pay_acc2'); // Giren Hesap

        $amount = (float)$this->input->post('amount', true);
        $para_birimi = (float)$this->input->post('para_birimi', true);
        $kur_degeri = (float)$this->input->post('kur_degeri', true);




        if ($amount > 0) {

            if ($this->transactions->addtransfer($pay_acc, $pay_acc2, $amount, $this->aauth->get_user()->id, $this->aauth->get_user()->loc,$para_birimi,$kur_degeri)) {

                echo json_encode(array('status' => 'Success', 'message' =>

                    "Transfer Başarıyla Gerçekleşti! <a href='" . base_url() . "transactions/transfer' class='btn btn-indigo btn-sm'><span class='icon-plus-circle' aria-hidden='true'></span> " . $this->lang->line('New') . "  </a> <a href='" . base_url() . "accounts' class='btn btn-indigo btn-sm'><span class='icon-list-ul' aria-hidden='true'></span></a>"));

            }

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                'Error!'));

        }





    }

    public function save_transfer_doviz()

    {

        if (!$this->aauth->premission(5)) {



            exit('<h3>Yetkiniz Yoktur</h3>');



        }



        $cikan_hesap = $this->input->post('cikan_hesap'); // Çıkan Hesap
        $invoicedate = $this->input->post('invoicedate'); // Çıkan Hesap
        $bill_date = datefordatabase($invoicedate);

        $gelen_hesap = $this->input->post('gelen_hesap'); // Giren Hesap

        $kur_degeri = (float)$this->input->post('kur_degeri', true);
        $tutar_cikan = (float)$this->input->post('tutar_cikan', true); // çıkan tutar
        $tutar_gelen = (float)$this->input->post('tutar_gelen', true); // çıkan tutar
        $notes = $this->input->post('notes', true); // çıkan tutar




        if ($tutar_cikan > 0) {

            if ($this->transactions->addtransferDoviz($cikan_hesap, $gelen_hesap, $this->aauth->get_user()->id, $this->aauth->get_user()->loc,$kur_degeri,$tutar_cikan,$tutar_gelen,$bill_date,$notes)) {

                echo json_encode(array('status' => 'Success', 'message' =>

                    "Transfer Başarıyla Gerçekleşti! <a href='" . base_url() . "transactions/doviz_transfer' class='btn btn-indigo btn-sm'><span class='fa fa-plus' aria-hidden='true'></span> " . $this->lang->line('New') . "  </a> <a href='" . base_url() . "accounts' class='btn btn-indigo btn-sm'><span class='fa fa-eye' aria-hidden='true'></span></a>"));

            }

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                'Error!'));

        }





    }





    public function delete_i()

    {

        if (!$this->aauth->premission(54)) {



            exit('<h3>Silme Yetkiniz Bulunmamaktadır.</h3>');



        }



        $id = $this->input->post('deleteid');

        if ($id) {


            echo json_encode($this->transactions->delt($id));

        } else {

            echo json_encode(array('status' => 'Error', 'message' => 'Error!'));

        }

    }



    public function income()

    {

        if (!$this->aauth->premission(5)) {



            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');



        }

        $head['title'] = "Income Transaction";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('transactions/income');

        $this->load->view('fixed/footer');



    }



    public function expense()

    {

        if (!$this->aauth->premission(5)) {



            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');



        }

        $head['title'] = "Expense Transaction";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('transactions/expense');

        $this->load->view('fixed/footer');



    }


    public function view()

    {

        if (!$this->aauth->premission(17)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }

        $head['title'] = "İşlem Görüntüle";

        $head['usernm'] = $this->aauth->get_user()->username;

        $id = $this->input->get('id');

        $data['trans'] = $this->transactions->view($id);




        if ($data['trans']['csd'] > 0) {

            $data['cdata'] = $this->transactions->cview($data['trans']['csd'], 1);

        } else {

            $data['cdata'] = array('address' => 'Not Registered', 'city' => '', 'phone' => '', 'email' => '');

        }

        $this->load->view('fixed/header', $head);

        $this->load->view('transactions/new-view', $data);

        $this->load->view('fixed/footer');



    }




//    public function view()
//
//    {
//
//        if (!$this->aauth->premission(5)) {
//
//
//
//            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
//
//
//
//        }
//
//        $head['title'] = "İşlem Görüntüle";
//
//        $head['usernm'] = $this->aauth->get_user()->username;
//
//        $id = $this->input->get('id');
//
//        $data['trans'] = $this->transactions->view($id);
//
//
//
//
//        if ($data['trans']['csd'] > 0) {
//
//            $data['cdata'] = $this->transactions->cview($data['trans']['csd'], 1);
//
//        } else {
//
//            $data['cdata'] = array('address' => 'Not Registered', 'city' => '', 'phone' => '', 'email' => '');
//
//        }
//
//        $this->load->view('fixed/header', $head);
//
//        $this->load->view('transactions/view', $data);
//
//        $this->load->view('fixed/footer');
//
//
//
//    }





    public function print_t()

    {

        if (!$this->aauth->premission(5)) {



            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');



        }

        $head['title'] = "İşlem Görüntüle";

        $head['usernm'] = $this->aauth->get_user()->username;

        $id = $this->input->get('id');

        $data['trans'] = $this->transactions->view($id);

        if ($data['trans']['csd'] > 0) {

            $data['cdata'] = $this->transactions->cview($data['trans']['csd'], 2);

        } else {

            $data['cdata'] = array('address' => 'Not Registered', 'city' => '', 'phone' => '', 'email' => '');

        }






        ini_set('memory_limit', '64M');



        $html = $this->load->view('transactions/view-print', $data, true);

        //PDF Rendering

        $this->load->library('pdf');



        $pdf = $this->pdf->load_en();



        $pdf->SetHTMLFooter('<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;"><tr><td width="33%"></td><td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td><td width="33%" style="text-align: right; ">#' . $id . '</td></tr></table>');



        $pdf->WriteHTML($html);



        if ($this->input->get('d')) {



            $pdf->Output('Trans_#' . $id . '.pdf', 'D');

        } else {

            $pdf->Output('Trans_#' . $id . '.pdf', 'I');

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

        else //diğer
        {
            $operator="qty+$amt";
            $operator2= "toplam_agirlik+$toplam_agirlik";
        }


        $this->db->set('toplam_agirlik', "$operator2", FALSE);
        $this->db->where('pid', $product_id);
        $this->db->update('geopos_products');


        //depo tablosunu güncelleme


        $depo_kontrol=$this->products->depo_kontrol($product_id,$depo);


        $loc=$this->aauth->get_user()->loc;
        if(isset($depo_kontrol))
        {


            $this->db->set('qty', "$operator", FALSE);

            $this->db->set('loc', "$loc", FALSE);

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
                'loc'=>$loc
            );
            $this->db->insert('geopos_product_to_warehouse', $depo_arr);
        }




        //depo tablosunu güncelleme




    }


    public function cari_in_invoice_kdv_total()
    {
        $invoice_id = $this->input->post('invoice_id', true);
        $invoice_list= $query=$this->db->query("SELECT `geopos_invoices`.*,geopos_invoices.tax-geopos_invoices.kdv_last_balance as kalan FROM `geopos_invoices` JOIN `geopos_invoice_type` ON
      `geopos_invoices`.`invoice_type_id`=`geopos_invoice_type`.`id` WHERE `geopos_invoices`.`id` = '$invoice_id'
        AND `geopos_invoice_type`.`type_value` = 'fatura' and `geopos_invoices`.`kdv_last_balance` NOT IN(geopos_invoices.tax) ")->row();

        $data=array(
            'invoice_no'=>$invoice_list->invoice_no,
            'id'=>$invoice_list->id,
            'type'=>$invoice_list->invoice_type_desc,
            'kalan'=>$invoice_list->kalan*$invoice_list->kur_degeri
        );

        echo json_encode($data);

    }


    public function cari_in_invoice()
    {
        $customer_id = $this->input->post('customer_id', true);
        $pay_type = $this->input->post('pay_type', true);
        $id = $this->input->post('id', true);

        $invoice_list=$this->transactions->cari_in_invoice($customer_id,$pay_type,$id);
        $data=array();



        foreach ($invoice_list as $l)
        {
            $odemeler=0;
            if($pay_type==43 || $pay_type==44)
            {
                $odemeler=$this->db->query("SELECT SUM(total) as total FROM geopos_invoice_transactions WHERE invoice_id=$l->id")->row()->total;
                $k=$l->kalan*$l->kur_degeri;
                $kalan=$k*($l->oran/100);
                $kalan=$kalan-$odemeler;
            }
            else if($pay_type==45 || $pay_type==46 || $pay_type==54 || $pay_type==55 || $pay_type==57 || $pay_type==61|| $pay_type==65)
            {
                $oran_=$l->oran;
                $odemeler=$l->total-($l->total*($oran_/100));
                $k=$l->kalan*$l->kur_degeri;
                $kalan=$l->total-$odemeler;
            }
            else
            {
                $k=$l->kalan*$l->kur_degeri;
                $kalan=$k*($l->oran/100);
                $kalan=$kalan-$odemeler;
            }

            $data[]=array(
                'invoice_no'=>$l->invoice_no,
                'id'=>$l->id,
                'type'=>$l->invoice_type_desc,
                'kalan'=>round($kalan,2)
            );
        }

        echo json_encode($data);

    }

    public function file_handling()

    {

        if ($this->input->get('op')) {

            $name = $this->input->get('name');

            if ($this->transactions->meta_delete($name)) {

                echo json_encode(array('status' => 'Success'));

            }

        } else {

            $id = $this->input->get('id');

            $this->load->library("Uploadhandler_generic", array(

                'accept_file_types' => '/\.(pdf|gif|jpe?g|png|xlsx)$/i', 'upload_dir' => FCPATH . 'userfiles/product/', 'upload_url' => base_url() . 'userfile/product/'

            ));





        }




    }


    public function cari_alacak_borc()
    {

        $this->transactions->cari_alacak_borc();
    }

    public function info(){
        $transaction_id = $this->input->post('transaction_id');
        $tip = $this->input->post('tip');
        $details = $this->db->query("SELECT * FROM geopos_invoices WHERE  id= $transaction_id")->row();
        $details_items = [];
        if($tip==1) //cari
        {
            $details_items=all_customer();
        }
        else {
            $details_items=all_cost();
        }
        echo json_encode(array('details' => $details, 'details_item' =>$details_items));

    }
    public function cari_gider_update(){
        $this->db->trans_start();
        $transaction_id = $this->input->post('transaction_id');
        $tip = $this->input->post('tip');
        $details_id = $this->input->post('details_id');
        $invoice_type_id = $this->input->post('invoice_type_id');
        $type_details = invoice_type_where($invoice_type_id);
        $data=[];
        if($details_id){

            if($tip==1) //cari
            {
                $data = [
                    'csd'=> $details_id,
                    'invoice_type_id'=> $invoice_type_id,
                    'invoice_type_desc'=> $type_details->description,
                    'payer'=> customer_details($details_id)['company'],
                    'cari_pers_type'=> 1,
                ];
            }
            else {
                $data = [
                    'csd'=> $details_id,
                    'invoice_type_id'=> $invoice_type_id,
                    'invoice_type_desc'=> $type_details->description,
                    'masraf_id'=> $details_id,
                    'payer'=> cost_details($details_id)->name,
                    'cari_pers_type'=> 0,
                ];
            }
            $this->db->set($data);
            $this->db->where('id',$transaction_id);
              if($this->db->update('geopos_invoices', $data)){
                  echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Güncellendi"));
                  $this->db->trans_complete();
              }
              else {
                  $this->db->trans_rollback();
                  echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
              }

        }
    }



    public function pay_type_get(){
        $cari_pers_type = $this->input->post('cari_pers_type');
        echo json_encode(array('status' => 200, 'items' =>pay_type($cari_pers_type)));
    }
    public function pay_type_next_process(){
        $cari_pers_type = $this->input->post('cari_pers_type');
        $pay_type = $this->input->post('pay_type');
        $payer_id = $this->input->post('payer_id');
        $paymethod = $this->input->post('paymethod');
        $pay_type_next_process= pay_type_next_process($cari_pers_type,$pay_type,$payer_id,$paymethod);
        echo json_encode(array(
            'status' => 200,
            'invoice_list' =>$pay_type_next_process['invoice_list'],
            'title' =>$pay_type_next_process['title'],
            'account_list' =>$pay_type_next_process['account_list'],
            'list_durum' =>$pay_type_next_process['list_durum'],
            'account_durum' =>$pay_type_next_process['account_durum'],
        ));
    }

    public function save_trans_new(){

        if ($this->aauth->premission(17)->read) {

            $this->db->trans_start();
            $result = $this->transactions->new_create();
            if($result['status']){
                echo json_encode(array('status' => 200,'message' =>$result['message']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }
        else {
            if (!$this->aauth->premission(64)->read) {
                echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
            }
            else {
                $this->db->trans_start();
                $result = $this->transactions->new_create();
                if($result['status']){
                    echo json_encode(array('status' => 200,'message' =>$result['message']));
                    $this->db->trans_complete();
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 410, 'message' =>$result['message']));
                }
            }

        }


    }

    public function create_podradci_borc()
    {
        $this->db->trans_start();
        $result = $this->transactions->create_podradci_borc();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function borclandirma_sil()
    {
        $this->db->trans_start();
        $result = $this->transactions->borclandirma_sil();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function update_image(){
        $this->db->trans_start();
        $result = $this->transactions->update_image();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function update_trans_new(){

        if ($this->aauth->premission(17)->update) {
            $this->db->trans_start();
            $result = $this->transactions->update_trans_new();
            if($result['status']){
                echo json_encode(array('status' => 200,'message' =>$result['message']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }
       else{
           if (!$this->aauth->premission(64)->read) {
               echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
           }
           else {
               $this->db->trans_start();
               $result = $this->transactions->update_trans_new();
               if($result['status']){
                   echo json_encode(array('status' => 200,'message' =>$result['message']));
                   $this->db->trans_complete();
               }
               else {
                   $this->db->trans_rollback();
                   echo json_encode(array('status' => 410, 'message' =>$result['message']));
               }
           }
        }

    }

    public function get_info(){

        $transaction_id = $this->input->post('transaction_id');
        $details = $this->transactions->details($transaction_id);
        $details_transaction = $this->transactions->details_transaction($transaction_id);


        $pay_type_next_process= pay_type_next_process($details->cari_pers_type,$details->invoice_type_id,$details->csd,$details->method);

        echo json_encode(array('status' => 200,
            'details'=>$details,
            'details_tranaction'=>$details_transaction,
            'invoice_list' =>$pay_type_next_process['invoice_list'],

            'title' =>$pay_type_next_process['title'],
            'account_list' =>$pay_type_next_process['account_list'],
            'list_durum' =>$pay_type_next_process['list_durum'],
            'account_durum' =>$pay_type_next_process['account_durum'],
        ));


    }

    public function create_komisyon_islem(){
        $this->db->trans_start();
        $transaction_id = $this->input->post('transaction_id');
        $result = $this->dmodel->gider_create_form($transaction_id,9);
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function podradci_status_change(){
        $this->db->trans_start();
        $result = $this->transactions->podradci_status_change();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }
    public function podradci_html()
    {
        $islem_id = $this->input->post('islem_id');
        $islem_tipi = $this->input->post('islem_tipi');



        $html='';
        if(talep_borclandirma($islem_id,$islem_tipi)){
            $html='<div class="col-md-12">
                                    <h2 class="text-bold-700" style="text-align: center;text-decoration: underline;font-family: monospace;">Talep İle İlgili Borçlandırmalar</h2>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td>Oluşturan Personel</td>
                                                <td>Tutar</td>
                                                <td>Açıklama</td>
                                                <td>Tip</td>
                                                <td>İşlem Yapılan Şahıs</td>
                                                <td>Tarih</td>
                                                <td>Durum</td>
                                                <td>İşlem</td>
                                            </tr>
                                        </thead>
                                        <tbody>';
        foreach (talep_borclandirma($islem_id,$islem_tipi) as $b_items){
                $html.='<tr>
                    <td>'.$b_items['personel'].'</td>
                    <td>'.$b_items['tutar'].'</td>
                    <td>'.$b_items['desc'].'</td>
                    <td>'.$b_items['tip'].'</td>
                    <td>'.$b_items['cari_pers'].'</td>
                    <td>'.$b_items['created_at'].'</td>
                    <td>'.$b_items['durum'].'</td>
                    <td><button class="btn btn-outline-danger borclandirma_sil" b_id="'.$b_items['id'].'"><i class="fa fa-ban"></i></button></td>
                </tr>';

                    }
            $html.='</tbody>
            </table>
        </div>';
        }
        echo json_encode(array('status' => 200, 'html' =>$html));


    }

    public function ajax_list_bekleyen_podradci_borclandirma(){

        $list = $this->transactions->podradci_borclandirma_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $messages='';
            $talep_tipi='';
            $code='';
            $islem_id=$prd->islem_id;
            $wiew='';
            switch ($prd->islem_tipi) {
                case 1: // Malzeme Talebi İse
                    $code_details = $this->db->query("SELECT * FROM talep_form Where id=$islem_id")->row();
                    $proje_id=$code_details->proje_id;
                    $code=$code_details->code;
                    $messages.=$code_details->code." Malzeme Talebine İstinaden Borçlandırma";
                    $talep_tipi='Malzeme Talebi';
                    $view = "<a class='btn btn-success view' target='_blank' href='/malzemetalep/view/$islem_id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";


                    break;
                case 2:  // Gider Talebi İse
                    $code_details = $this->db->query("SELECT * FROM talep_form_customer_new Where id=$islem_id")->row();
                    $proje_id=$code_details->proje_id;
                    $code=$code_details->code;
                    $messages.=$code_details->code." Gider Talebine İstinaden Borçlandırma";
                    $talep_tipi='Gider Talebi';
                    $view = "<a class='btn btn-success view' target='_blank' href='/carigidertalepnew/view/$islem_id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";


                    break;
                case 3:  // Cari Avans Talebi İse
                    $code_details = $this->db->query("SELECT * FROM talep_form_customer Where id=$islem_id")->row();
                    $proje_id=$code_details->proje_id;
                    $code=$code_details->code;
                    $messages.=$code_details->code.=" Cari Avans Talebine İstinaden Borçlandırma";
                    $talep_tipi='Cari Avans Talebi';
                    $view = "<a class='btn btn-success view' target='_blank' href='/customeravanstalep/view/$islem_id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";


                    break;
                case 4:  // Forma2 Talebi İse
                    $code_details = $this->db->query("SELECT * FROM geopos_invoices Where id=$islem_id")->row();
                    $proje_id=$code_details->proje_id;
                    $code=$code_details->invoice_no;
                    $messages.=$code_details->invoice_no.=" Forma2 Talebine İstinaden Borçlandırma";
                    $talep_tipi='Forma2 Talebi';
                    $view = "<a class='btn btn-success view' target='_blank' href='/formainvoices/view?id=$islem_id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";


                    break;
                case 5:  // Finans işlemi İse
                    $code_details = $this->db->query("SELECT * FROM geopos_invoices Where id=$islem_id")->row();
                    $proje_id=$code_details->proje_id;
                    $code=$code_details->id;
                    $messages.=$code_details->id.=" IDli Finans İşlemine İstinaden Borçlandırma";
                    $talep_tipi='Finans İşlemi';
                    $view = "<a class='btn btn-success view' target='_blank' href='/transactions/view?id=$islem_id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";


                    break;
                case 6:  // Qaime  İse
                    $code_details = $this->db->query("SELECT * FROM geopos_invoices Where id=$islem_id")->row();
                    $proje_id=$code_details->proje_id;
                    $code=$code_details->invoice_no;
                    $messages.=$code_details->invoice_no.=" Qaimeye İstinaden Borçlandırma";
                    $talep_tipi='Qaime';
                    $view = "<a class='btn btn-success view' target='_blank' href='/invoices/view?id=$islem_id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";


                    break;
            }

            $cari_pers_type_name="Personel";
            $cari_name=personel_detailsa($prd->payer_id)['name'];
            if($prd->cari_pers_id==1){
                $cari_pers_type_name='Cari';
                $cari_name= customer_details($prd->payer_id)['company'];
            }

            $cancel = "<button class='btn btn-warning onay_iptal' talep_id='$prd->id' type='button'><i class='fa fa-check'></i></button>&nbsp;";
           $no++;
            $row = array();
            $row[] = $no;
            $row[] = $talep_tipi;
            $row[] = $code;
            $row[] = $cari_pers_type_name;
            $row[] = $cari_name;
            $row[] = amountFormat($prd->tutar);
            $row[] =$view;
            $row[] =$cancel;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->transactions->podradci_borclandirma_count_all(),
            "recordsFiltered" => $this->transactions->podradci_borclandirma_count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


}
