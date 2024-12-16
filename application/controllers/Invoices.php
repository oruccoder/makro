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

class Invoices extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();


        $this->load->library("Aauth");
        $selected_db = $this->session->userdata('selected_db');
        if (!empty($selected_db)) {
            $this->db = $this->load->database($selected_db, TRUE);
        }
        $this->load->model('invoices_model', 'invocies');

        $this->load->model('communication_model');
        $this->load->model('transactions_model', 'transactions');
        $this->load->helper('cookie');

        $this->load->model('plugins_model', 'plugins');

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }




        if ($this->aauth->get_user()->roleid == 2) {

            $this->limited = $this->aauth->get_user()->id;

        } else {

            $this->limited = '';

        }



    }

    public function forma2_list(){
        $customer_id = $this->input->post('cid');
        $new_list=[];
        $kontol = $this->db->query("SELECT * FROM geopos_invoices Where invoice_type_id in (29,30) and csd=$customer_id");
        if($kontol->num_rows()){
            $new_list=$kontol->result();
        }
        echo json_encode(array('status' => 200, 'details' =>$new_list));
    }

    public function tehvil_list(){
        $customer_id = $this->input->post('cid');
        $new_list=[];
        $kontol = $this->db->query("SELECT * FROM geopos_invoices Where invoice_type_id in (69) and csd=$customer_id");
        if($kontol->num_rows()){
            $new_list=$kontol->result();
        }
        echo json_encode(array('status' => 200, 'details' =>$new_list));
    }

    public function invoice_details(){
        $id = $this->input->post('id');
        $kontol = $this->db->query("SELECT * FROM geopos_invoices Where id=$id")->row();
        echo json_encode(array('status' => 200, 'details' =>$kontol));
    }

    public function index()

    {
        if (!$this->aauth->premission(1)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }

        setcookie('invoice_id', 1, time() + (86400 * 30), "/"); // 86400 = 1 day
        $head['title'] = "Faturalar";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('invoices/invoices');

        $this->load->view('fixed/footer');

    }

    public function formaduzenleme()

    {

        $head['title'] = "Forma2 ";
        $data['invoices']=$this->db->query("SELECT * FROM geopos_invoices Where invoice_type_id IN (29,30) and loc=5 and tax_oran=18 and status!=3 and visable=1")->result();


        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('invoices/invoices_new',$data);

        $this->load->view('fixed/footer');

    }
    public function ajax_list()
    {



        $list = $this->invocies->get_datatables($this->limited);

        $data = array();



        $no = $this->input->post('start');

        $this->session->set_userdata('test', 1);

        foreach ($list as $invoices) {

            $proje_name=proje_name($invoices->proje_id);

            $notes='Proje Adı : '.$proje_name.' &#013;Not : '.$invoices->notes;
            $tool="data-toggle='tooltip' data-placement='top' data-html='true' title='$notes'";
            $no++;

            $row = array();

            if($invoices->invoice_type_id==37)
            {

                $tarih1=dateformat($invoices->invoicedate);
                $tarih2=date('Y-m-d');
                $fark = strtotime($tarih2) - strtotime($tarih1);
                $gun_sayisi=floor($fark / (60 * 60 * 24)) ;

                $yillik=($invoices->total*(intval($invoices->notes)==0) ? 0 : (100/intval($invoices->notes)));
                $hesap=($yillik/360);

                $tastig_t=($hesap*$gun_sayisi)+$invoices->total;

                $row[] = $invoices->invoice_name;
                $row[] =  "<span data-toggle='tooltip' data-placement='top' data-html='true' title='".$notes."'>".$invoices->invoice_no."</span>";

                $row[] = dateformat($invoices->invoicedate);
                $row[] = dateformat($invoices->invoiceduedate);
                $row[] = $invoices->notes.' %'; //faiz
                $row[] = amountFormat($invoices->total,$invoices->para_birimi);
                $row[] = amountFormat($hesap*$gun_sayisi);
                $row[] = amountFormat($tastig_t);
                $row[] = $invoices->name;
                $row[] = '<span class="st-' . $invoices->status . '">' . invoice_status($invoices->status) . '</span>';


                $row[] = '<a href="' . base_url("invoices/faktoring_view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="Görüntüle"><i class="fa fa-eye"></i></a>';

                $data[] = $row;
            }
            else
            {
                $row[] = "<input type='checkbox' class='form-control invoice_ids' name='invoice_ids[]' value='$invoices->id'>";
                $row[] = dateformat($invoices->invoicedate);

                $row[] = invoice_type_id($invoices->invoice_type_id);

                $row[] =  "<a href='/invoices/view?id=$invoices->id' >"."<span data-toggle='tooltip' data-placement='top' data-html='true' title='".$notes."'>".$invoices->invoice_no."</span></a>";


                $row[] = "<a href='/projects/explore?id=$invoices->proje_id' >".proje_code($invoices->proje_id)."</a>";
                $row[] = "<a href='/customers/view?id=$invoices->csd' >".$invoices->name."</a>";
                $row[] = $invoices->notes;


                $row[] = amountFormat(($invoices->subtotal-$invoices->discount),$invoices->para_birimi);
                $row[] = amountFormat($invoices->tax,$invoices->para_birimi);

                $row[] = amountFormat($invoices->total,$invoices->para_birimi);

                $row[] = '<span class="st-' . $invoices->status . '">' . invoice_status_ogren($invoices->status) . '</span>';
                $row[] = customer_details($invoices->alt_cari_id)['company'];

                $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>
                    &nbsp;<a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>
                    <a target="_blank"  href="' . base_url("/employee/view?id=$invoices->eid") .'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" data-html="true" title="'.personel_details($invoices->eid).'"><i class="fa fa-user"></i></a>
                    <button class="btn btn-danger btn-sm cancel" invoice_id="'.$invoices->id.'" title="Iptal Et"><i class="fa fa-ban"></i></button>
                    
                    ';


                $data[] = $row;
            }



        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->invocies->count_all($this->limited),

            "recordsFiltered" => $this->invocies->count_filtered($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }
    public function create()

    {

        if (!$this->aauth->premission(1)->write) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }

        $this->load->model('customers_model', 'customers');

        $this->load->model('invoices_model');

        $data['exchange'] = $this->plugins->universal_api(5);

        $data['customergrouplist'] = $this->customers->group_list();

        $data['lastinvoice'] = $this->invocies->lastinvoice();
        $data['hizmetler'] = $this->invocies->hizmetler();

        $data['warehouse'] =all_warehouse();

        $data['terms'] = $this->invocies->billingterms();

        $data['currency'] = $this->invocies->currencies();

        $this->session->mark_as_temp('para_birimi', 3);

        $this->load->library("Common");

        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));

        $head['title'] = "Yeni Fatura";

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['taxdetails'] = $this->common->taxdetail();

        $this->load->view('fixed/header', $head);

        $this->load->view('invoices/newinvoice', $data);

        $this->load->view('fixed/footer');

    }
    public function edit()

    {

        if (!$this->aauth->premission(1)->update) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }



        $tid = intval($this->input->get('id'));

        $data['id'] = $tid;
        $this->load->model('customers_model', 'customers');
        $data['customergrouplist'] = $this->customers->group_list();
        $data['terms'] = $this->invocies->billingterms();
        $data['currency'] = $this->invocies->currencies();
        $data['hizmetler'] = $this->invocies->hizmetler();
        $data['forma2_'] = $this->db->query("SELECT geopos_invoices.* FROM invoice_to_forma_2 INNER JOIN geopos_invoices ON invoice_to_forma_2.forma_2_id = geopos_invoices.id Where invoice_to_forma_2.invoice_id = $tid")->result();
        $data['tehvil_list'] = $this->db->query("SELECT geopos_invoices.* FROM invoice_to_tehvil INNER JOIN geopos_invoices ON invoice_to_tehvil.tehvil_id = geopos_invoices.id Where invoice_to_tehvil.invoice_id = $tid")->result();

        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);

        $invoice_no=$data['invoice']['invoice_no'];

        $head['title'] = "Fatura Düzenle #".$invoice_no;

        if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);


        $head['title'] = "Fatura Düzenle #".$invoice_no;

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['warehouse'] = all_warehouse();

        $this->load->model('plugins_model', 'plugins');

        $data['exchange'] = $this->plugins->universal_api(5);

        $this->load->library("Common");

        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));

        $this->session->set_userdata('para_birimi',$data['invoice']['para_birimi']);

        $this->load->view('fixed/header', $head);

        if ($data['invoice']) $this->load->view('invoices/edit', $data);

        $this->load->view('fixed/footer');



    }
    public function new_cancelinvoice(){
        if (!$this->aauth->premission(1)->update) {


            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->invoice_iptal();
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

    public function invoice_iptal(){
        $invoice_id= $this->input->post('invoice_id');
        $status_id= $this->input->post('status_id');
        $desc= $this->input->post('desc');
        $this->db->set('status', $status_id);
        $this->db->where('id', $invoice_id);
        if($this->db->update('geopos_invoices')){
            if($status_id==3){
                $this->db->delete('geopos_transactions', array('tid' => $invoice_id));
                $this->db->delete('geopos_project_items_gider', array('tid' => $invoice_id));
                $this->db->delete('firma_gider', array('talep_id' => $invoice_id,'type'=>6));
            }


            $this->talep_history($invoice_id,$this->aauth->get_user()->id,'Qaime Durumu Değiştirildi : '.$desc,1);


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
    public function view()

    {


        $this->load->model('accounts_model');

        $data['warehouse'] =$this->invocies->warehouses();
        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);

        $tid = $this->input->get('id');



        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);

        //echo "<pre>";print_r($data['invoice']);die();

        $data['attach'] = $this->invocies->attach($tid);

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = "Fatura No " . $data['invoice']['invoice_no'];

        $this->load->view('fixed/header', $head);



        $data['note_list']=new_list_note(2,$tid);
        $data['products'] = $this->invocies->invoice_products($tid);
        $data['rulo_miktari'] = rulo_miktari_sorgula($tid,'invoice');


        if ($data['invoice']) $data['activity'] = $this->invocies->invoice_transactions($tid);

        $data['employee'] = $this->invocies->employee($data['invoice']['eid']);



        if ($data['invoice']) { $data['invoice']['id'] = $tid; $this->load->view('invoices/view', $data);}



        $this->load->view('fixed/footer');

    }
    public function printinvoice()
    {

        if (!$this->aauth->premission(1)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }

        $tid = $this->input->get('id');



        $data['id'] = $tid;



        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);

        if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);

        if ($data['invoice']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);



        ini_set('memory_limit', '64M');

        if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {

            $html = $this->load->view('invoices/view-print-gstin', $data, true);

        } else {

            $html = $this->load->view('invoices/view-print-' . LTR, $data, true);

        }

        $header = $this->load->view('invoices/header-print-' . LTR, $data, true);

        //PDF Rendering

        $this->load->library('pdf');



        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['invoice_no'] . '</div>');

        $pdf->WriteHTML($html);



        $file_name = preg_replace( '/[^A-Za-z0-9]+/', '-', 'Invoice__'.$data['invoice']['name'].'_'. $data['invoice']['tid']);

        if ($this->input->get('d')) {



            $pdf->Output($file_name. '.pdf', 'D');

        } else {

            $pdf->Output($file_name . '.pdf', 'I');

        }





    }
    public function odeme_gecmisi()
    {
        if (!$this->aauth->premission(1)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $tid = $this->input->get('id');
        $tip = $this->input->get('tip');

        $data['id'] = $tid;

        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);

        if ($data['invoice']) $data['products'] = $this->invocies->invoice_gecmisi($tid,$tip);

        if ($data['invoice']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);



        ini_set('memory_limit', '64M');

        if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {

            $html = $this->load->view('invoices/view-print-gstin', $data, true);

        } else {


            $html = $this->load->view('invoices/view-gecmis-'.LTR, $data, true);

        }

        $header = $this->load->view('invoices/header-print-' . LTR, $data, true);

        //PDF Rendering

        $this->load->library('pdf');



        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['invoice_no'] . '</div>');



        $pdf->WriteHTML($html);



        $file_name = preg_replace( '/[^A-Za-z0-9]+/', '-', 'Invoice__'.$data['invoice']['name'].'_'. $data['invoice']['tid']);

        if ($this->input->get('d')) {



            $pdf->Output($file_name. '.pdf', 'D');

        } else {

            $pdf->Output($file_name . '.pdf', 'I');

        }
    }

    public function form2_ajax_list_muhasebe()

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
                $edit_button=' <a href="' . base_url("invoices/edit_forma_2/$invoices->id").'" class="btn btn-info btn-sm"  title="Düzenle"><span class="fa fa-pencil"></span></a>';
            }
            $odeme='';
            if($invoices->status == 10){
                $odeme='<a href="#pop_modal_transaction" data-id="'.$invoices->id.'" data-toggle="modal"  data-remote="false" class="odeme_button btn btn-success">Ödeme Yap</a>';
            }

            $no++;

            $row = array();

            //$row[] = $no;
            $row[] = dateformat($invoices->invoicedate);

            $row[] = invoice_type_id($invoices->invoice_type_id);

            $row[] = $invoices->invoice_no;

            $row[] = isset($invoices->payer)?$invoices->payer:'';


            $row[] = amountFormat($invoices->total,$invoices->para_birimi);

            $row[] = $durum;
            $row[] = proje_name($invoices->proje_id);
            $row[] = $invoices->forma2_notes;


            $row[] = '<a href="' . base_url("formainvoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="Görüntüle"><i class="fa fa-eye"></i>';


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


    public function update_status_toplu_dashboard()

    {

        $inv_array = $this->input->post('array');

        $this->db->trans_start();
        $index=0;
        $status = $this->input->post('status');
        foreach ($inv_array as $lists)
        {
            $this->db->set('status', $status);

            $this->db->where('id', $lists);

            $this->db->update('geopos_invoices');
            $this->aauth->applog("Status : ".$status." Durum Değiştirildi : ID " . $lists, $this->aauth->get_user()->username);
            $index++;

        }

        if($index){
            echo json_encode(array('status' => 200,'message' =>$index.' Adet Fatura Güncellendi. Bekleyeniz'));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>'Hata Aldınız'));
        }


    }

    public function update_status_toplu()

    {

        $inv_array = $this->input->post('invoice_id');

        $this->db->trans_start();
        $index=0;
        $status = $this->input->post('status');
        foreach ($inv_array as $lists)
        {
            $this->db->set('status', $status);
            $this->db->where('id', $lists);
            $this->db->update('geopos_invoices');
            $this->aauth->applog("Status : ".$status." Durum Değiştirildi : ID " . $lists, $this->aauth->get_user()->username);
            $index++;

        }

        if($index){
            echo json_encode(array('status' => 200,'message' =>$index.' Adet Fatura Güncellendi. Bekleyeniz'));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>'Hata Aldınız'));
        }

    }

    public function action()


    {


        $currency = $this->input->post('mcurrency');
        $customer_id = $this->input->post('customer_id');
        $invocieno = $this->input->post('invoice_no');
        $invoice_no = $this->input->post('invoice_no');
        $alt_cari_id = $this->input->post('alt_cari_id');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes',true);
        $tax = $this->input->post('tax_handle');
        $ship_taxtype = $this->input->post('ship_taxtype');
        $subtotal = rev_amountExchange($this->input->post('subtotal'),$currency);
        $shipping = rev_amountExchange($this->input->post('shipping'),$currency);
        $shipping_tax = rev_amountExchange($this->input->post('ship_tax'),$currency);
        if($ship_taxtype=='incl') $shipping=0;
        $refer = $this->input->post('refer',true);
        $total = rev_amountExchange($this->input->post('total'),$currency);

        $total_tax = 0;

        $total_discount = 0;

        $discountFormat = $this->input->post('discountFormat');

        $pterms = $this->input->post('pterms',true);

        $invoice_type = $this->input->post('invoice_type');


        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));
        $kur_degeri = $this->input->post('kur_degeri');


        $discount_rate = $this->input->post('discount_rate');
        $dosya_id = $this->input->post('dosya_id');
        $ithalat_ihracat_tip = $this->input->post('ithalat_ihracat_tip');
        $bolum_id = $this->input->post('bolum_id');

        $asama_id = $this->input->post('asama_id');
        $depo = $this->input->post('warehouses');
        $alt_asama_id = $this->input->post('alt_asama_id');
        $task_id = $this->input->post('task_id');
        $malzeme_talep_id = $this->input->post('malzeme_talep_id');
        $avans_talep_id = $this->input->post('avans_talep_formu');
        $satinalma_talep_id = $this->input->post('satinalma_talep_id');
        $forma2_id = $this->input->post('forma2_id');
        $tehvil_id = $this->input->post('tehvil_id');

        $paymethod = $this->input->post('paymethod');
        $project = $this->input->post('proje_id');
        $stok_durumu = $this->input->post('stok_durumu');







        $stok_guncellemes=isset($stok_durumu)?1:0;






        $i = 0;

        if ($discountFormat == '0') {

            $discstatus = 0;

        } else {

            $discstatus = 1;

        }

        if($invoice_type==24)
        {

            if ($customer_id == 0)
            {
                $customer_id=0;
            }
            else
            {
                $customer_id = $this->input->post('customer_id');
            }
        }
        else
        {
            if ($customer_id == 0) {

                echo json_encode(array('status' => 410, 'message' =>

                    $this->lang->line('Please add a new client')));

                exit;

            }
        }



        $transok = true;

        $st_c = 0;

        $this->db->trans_start();

        //Invoice Data

        $bill_date = datefordatabase($invoicedate);

        $bill_due_date = datefordatabase($invocieduedate);


        $loc =   $this->aauth->get_user()->loc;
        if($this->session->userdata('set_firma_id')){
            $loc = $this->session->userdata('set_firma_id');
        }

        $data = array(
            'tid' => $invocieno,
            'invoicedate' => $bill_date,
            'invoiceduedate' => $bill_due_date,
            'subtotal' => $subtotal,
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
            'discount_rate' => $discount_rate,
            'refer' => $refer,
            'term' => $pterms,
            'multi' => $currency,
            'para_birimi' => $para_birimi,
            'kur_degeri' => $kur_degeri,
            'invoice_no' => $invoice_no,
            'loc' => $this->aauth->get_user()->loc,
            //'depo' => $depo, Item tablosuna kayıt olduğu için kapatıldı
            'dosya_id' => $dosya_id,
            'ithalat_ihracat_tip' => $ithalat_ihracat_tip,
            'asama_id' => $asama_id,
            'alt_asama_id' => $alt_asama_id,
            'task_id' => $task_id,
            'bolum_id' => $bolum_id,
            'proje_id' => $project,
            'method' => $paymethod,
            'alt_cari_id' => $alt_cari_id,
            'stok_guncelle' => $stok_guncellemes,
            'loc'=>$loc

        );



        $invocieno2 = $invocieno;

        if ($this->db->insert('geopos_invoices', $data)) {

            $insert_id = $this->db->insert_id();
            $invocieno = $this->db->insert_id();

            if($avans_talep_id){
                foreach ($avans_talep_id as $aid){
                    $data_avans =  array('tip'=>5,'talep_id'=>$aid,'invoice_id'=>$insert_id,'user_id'=>$this->aauth->get_user()->id);
                    $this->db->insert('invoice_to_talep', $data_avans);
                }
            }

            if($malzeme_talep_id){
                foreach ($malzeme_talep_id as $aid){
                    $data_avans =  array('tip'=>1,'talep_id'=>$aid,'invoice_id'=>$insert_id,'user_id'=>$this->aauth->get_user()->id);
                    $this->db->insert('invoice_to_talep', $data_avans);
                }
            }
            if($satinalma_talep_id){
                foreach ($satinalma_talep_id as $aid){
                    $data_avans =  array('tip'=>2,'talep_id'=>$aid,'invoice_id'=>$insert_id,'user_id'=>$this->aauth->get_user()->id);
                    $this->db->insert('invoice_to_talep', $data_avans);
                }
            }

            if($forma2_id){
                foreach ($forma2_id as $aid){
                    $data_forma2_ =  array('forma_2_id'=>$aid,'invoice_id'=>$insert_id);
                    $this->db->insert('invoice_to_forma_2', $data_forma2_);
                }
            }

            if($tehvil_id){
                foreach ($tehvil_id as $aid){
                    $data_tehvil_ =  array('tehvil_id'=>$aid,'invoice_id'=>$insert_id);
                    $this->db->insert('invoice_to_tehvil', $data_tehvil_);
                }
            }



            $this->aauth->applog("Fatura Oluşturuldu $invocieno2 ID ".$invocieno,$this->aauth->get_user()->username);
            kont_kayit(29,$invocieno);

            //products



            $pid = $this->input->post('pid');

            $productlist = array();

            $prodindex = 0;

            $itc = 0;



            foreach ($pid as $key => $value) {
                $toplam_rulo=0;

                $product_id = $this->input->post('pid');

                $product_name1 = $this->input->post('product_name',true);
                $depo_id_item = $this->input->post('depo_id_item',true);

                $product_qty = $this->input->post('product_qty');

                $product_price = $this->input->post('product_price');

                $product_tax = $this->input->post('product_tax');

                $product_discount = $this->input->post('product_discount');

                $product_subtotal = $this->input->post('product_subtotal');

                $ptotal_tax = $this->input->post('taxa');

                $ptotal_disc = $this->input->post('disca');

                $product_des =$this->input->post('item_desc');

                $product_unit = $this->input->post('unit');

                $product_hsn = $this->input->post('hsn',true);

                $product_alert = $this->input->post('alert');

                $item_descs = $this->input->post('item_desc');


                $total_discount += $ptotal_disc[$key];

                $total_tax += $ptotal_tax[$key];

                if($product_id[$key]!=0) {

                    if($invoice_type==24)
                    {
                        $p_name=masraf_name($product_id[$key]);

                    }
                    else if($invoice_type==41)
                    {
                        $p_name=masraf_name($product_id[$key]);

                    }
                    else
                    {
                        $p_name=product_name($product_id[$key]);
                    }


                    $p_price=rev_amountExchange($product_price[$key], $currency);
                    $p_tax=rev_amountExchange($product_tax[$key], $currency);
                    $p_discount=rev_amountExchange($product_discount[$key], $currency);
                    $p_subtotal=rev_amountExchange($product_subtotal[$key], $currency);
                    $p_total_tax=rev_amountExchange($ptotal_tax[$key], $currency);
                    $p_total_discount=rev_amountExchange($ptotal_disc[$key], $currency);


                    //$proje_deposu=project_to_depo($project)->id;

                    /*
                    $proje_item_id=0;
                    if($proje_deposu==$depo_id_item[$key])
                    {
                        $proje_item_id=$project;
                    }
                    else
                        {
                            $proje_item_id=0;
                        }

                    */

                    $item_desc='';
                    if(isset($item_descs[$key]))
                    {
                        $item_desc=$item_descs[$key];
                    }
                    else {
                        $item_desc='';
                    }
                    $proje_item_id=$project;

                    $data = array(

                        'tid' => $invocieno,

                        'pid' => $product_id[$key],

                        'product' => $product_name1[$key],

                        'code' => $product_hsn[$key],

                        'qty' => $product_qty[$key],

                        'price' => $p_price,

                        'tax' => $p_tax,

                        'discount' => $p_discount,

                        'subtotal' => $p_subtotal,

                        'totaltax' => $p_total_tax,

                        'totaldiscount' => $p_total_discount,

                        'product_des' => $product_des[$key],

                        'unit' => $product_unit[$key],

                        'invoice_type_id' => $invoice_type,

                        'proje_id' => $proje_item_id,

                        'depo_id' => $depo_id_item[$key],
                        'item_desc' => $item_desc,

                        'invoice_type_desc' => invoice_type_id($invoice_type)
                    );
                    $productlist[$prodindex] = $data;

                    $i++;

                    $prodindex++;
                }






                $amt = $product_qty[$key];

                if($invoice_type==1) //Satış
                {
                    if(!$stok_guncellemes)
                    {  stock_update_new($product_id[$key],$product_unit[$key],$amt,0,$depo_id_item[$key],$this->aauth->get_user()->id,$invocieno,2);
                        $stock_id = $this->db->insert_id();
                    }

                }
                elseif($invoice_type==2) // Alış
                {
                    if(!$stok_guncellemes){
                    stock_update_new($product_id[$key],$product_unit[$key],$amt,1,$depo_id_item[$key],$this->aauth->get_user()->id,$invocieno,2);
                    $stock_id = $this->db->insert_id();
                    }
                }

                //alış fiyatlarını görebilmemiz için tabloya ekleme yapıyoruz

                //$this->invocies->stock_product_price($invocieno,$bill_date,$product_id[$key],$amt,$depo_id_item[$key],$p_price,$p_tax,$p_discount,$p_subtotal,$p_total_tax,$p_total_discount,$kur_degeri,$para_birimi);

                //alış fiyatlarını görebilmemiz için tabloya ekleme yapıyoruz




                $itc += $amt;

            }

            if ($prodindex > 0) {


                $this->db->insert_batch('geopos_invoice_items', $productlist);
                $this->db->insert_batch('geopos_project_items_gider', $productlist);



                $this->db->set(array('discount' => rev_amountExchange($total_discount,$currency), 'tax' => rev_amountExchange($total_tax,$currency), 'items' => $itc));

                $this->db->where('id', $invocieno);

                $this->db->update('geopos_invoices');



            } else {

                echo json_encode(array('status' => 410, 'message' =>

                    "Lütfen ürün listesinden ürün seçin. Ürünleri eklemediyseniz, Ürün yöneticisi bölümüne gidin."));

                $transok = false;

            }

            if ($transok) {

                $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));

                $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);

                echo json_encode(array('status' => 200, 'message' =>'Fatura Başarıyla Oluşturuldu','id'=>$insert_id));

            }

        } else {

            echo json_encode(array('status' => 410, 'message' =>'Hata Aldınız'));

            $transok = false;

        }





        if ($transok) {

            if (($this->aauth->premission(4)) AND $project > 0) {



                $data = array('pid' => $project, 'meta_key' => 11, 'meta_data' => $invocieno, 'value' => '0');


                $this->db->insert('geopos_project_meta', $data);



                /*$this->db->set('task_id', "$task_id", FALSE);

                $this->db->where('id', $invocieno);

                $this->db->update('geopos_invoices');*/



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

            $this->db->select('geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.product_price');

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

    public function editaction()

    {


        $forma2_id = $this->input->post('forma2_id');
        $tehvil_id = $this->input->post('tehvil_id');

        $invoice_item_id = $this->input->post('invoice_item_id');
        $customer_id = $this->input->post('customer_id');
        $invocieno = $this->input->post('invocieno');
        $invoice_no = $this->input->post('invoice_no');

        $iid = $this->input->post('iid');

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

        $total_tax_ = $this->input->post('taxr2');
        $total_tax = 0;

        $total_discount = 0;

        $discountFormat = $this->input->post('discountFormat');
        $discount_rate = $this->input->post('discount_rate');

        $pterms = $this->input->post('pterms');
        $alt_cari_id = $this->input->post('alt_cari_id');

        $currency = $this->input->post('mcurrency');

        $invoice_type = $this->input->post('invoice_type');
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));
        $kur_degeri = $this->input->post('kur_degeri');
        $depo = $this->input->post('warehouses');

        $old_depo=$this->db->query("Select depo From geopos_invoices where id= $iid")->row_array();

        $old_depo_id=$old_depo['depo'];

        $stok_durumu = $this->input->post('stok_durumu');

        $malzeme_talep_id = $this->input->post('malzeme_talep_id');
        $avans_talep_id = $this->input->post('avans_talep_formu');
        $satinalma_talep_id = $this->input->post('satinalma_talep_id');


        $stok_guncellemes=isset($stok_durumu)?1:0;



        $asama_id = $this->input->post('asama_id');
        $alt_asama_id = $this->input->post('alt_asama_id');
        $bolum_id = $this->input->post('bolum_id');
        $task_id= $this->input->post('task_id');
        $paymethod = $this->input->post('paymethod');
        $proje_id = $this->input->post('proje_id');
        $proje_details=$this->db->query('Select*FROM geopos_project_meta where meta_key=11 and meta_data='.$iid)->row_array();

        if(!$proje_details)
        {
            $data=array(
                'pid'=>$proje_id,
                'meta_key'=>11,
                'meta_data'=>$iid

            );
            $this->db->insert('geopos_project_meta',$data);
        }
        else
        {


            $this->db->set('pid', $proje_id);

            $this->db->where('meta_data', $iid);
            $this->db->where('meta_key', 11);

            $this->db->update('geopos_project_meta');
        }


        $i = 0;





        if ($discountFormat == '0') {

            $discstatus = 0;

        } else {

            $discstatus = 1;

        }

        if($invoice_type==24)
        {

            if ($customer_id == 0)
            {
                $customer_id=0;
            }
            else
            {
                $customer_id = $this->input->post('customer_id');
            }

        }
        else
        {
            if ($customer_id == 0) {

                echo json_encode(array('status' => 'Error', 'message' =>

                    $this->lang->line('Please add a new client')));

                exit;

            }
        }


        $this->db->trans_start();



        $transok = true;





        $bill_date = datefordatabase($invoicedate);

        $bill_due_date = datefordatabase($invocieduedate);


        $eski_stok_durumu=$this->db->query("SELECT * FROM geopos_invoices Where id=$iid")->row()->stok_guncelle;





        $data = array('invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'invoice_type_id' => $invoice_type,
            'invoice_type_desc' => invoice_type_id($invoice_type),
            'subtotal' => $subtotal, 'shipping' => $shipping,'ship_tax' =>
                $shipping_tax, 'ship_tax_type' => $ship_taxtype, 'discount' =>
                $total_discount, 'tax' => $total_tax, 'total' => $total, 'notes' => $notes,
            'csd' => $customer_id, 'items' => 0, 'taxstatus' => $tax, 'discstatus' => $discstatus,
            'format_discount' => $discountFormat,
            'discount_rate' => $discount_rate,
            'refer' => $refer, 'term' => $pterms,
            'multi' => $currency,
            'para_birimi' => $para_birimi,
            'kur_degeri' => $kur_degeri,
            'invoice_no' => $invoice_no,
            'depo' => $depo,
            'proje_id' => $proje_id,
            'method' => $paymethod,
            'alt_cari_id' => $alt_cari_id,
            'task_id' => $task_id,
            'asama_id' => $asama_id,
            'alt_asama_id' => $alt_asama_id,
            'bolum_id' => $bolum_id,
            'stok_guncelle' => $stok_guncellemes

        );

        $this->db->set($data);

        $this->db->where('id', $iid);

        if ($this->db->update('geopos_invoices', $data)) {


            $this->db->delete('invoice_to_talep', array('invoice_id' => $iid));
            $this->db->delete('invoice_to_forma_2', array('invoice_id' => $iid));
            $this->db->delete('invoice_to_tehvil', array('invoice_id' => $iid));
            if($avans_talep_id){
                foreach ($avans_talep_id as $aid){
                    $data_avans =  array('tip'=>5,'talep_id'=>$aid,'invoice_id'=>$iid,'user_id'=>$this->aauth->get_user()->id);
                    $this->db->insert('invoice_to_talep', $data_avans);
                }
            }

            if($malzeme_talep_id){
                foreach ($malzeme_talep_id as $aid){
                    $data_avans =  array('tip'=>1,'talep_id'=>$aid,'invoice_id'=>$iid,'user_id'=>$this->aauth->get_user()->id);
                    $this->db->insert('invoice_to_talep', $data_avans);
                }
            }
            if($satinalma_talep_id){
                foreach ($satinalma_talep_id as $aid){
                    $data_avans =  array('tip'=>2,'talep_id'=>$aid,'invoice_id'=>$iid,'user_id'=>$this->aauth->get_user()->id);
                    $this->db->insert('invoice_to_talep', $data_avans);
                }
            }

            if($forma2_id){
                foreach ($forma2_id as $aid){
                    $data_forma2_ =  array('forma_2_id'=>$aid,'invoice_id'=>$iid);
                    $this->db->insert('invoice_to_forma_2', $data_forma2_);
                }
            }

            if($tehvil_id){
                foreach ($tehvil_id as $id_list){
                    $data_tehvil =  array('tehvil_id'=>$id_list,'invoice_id'=>$iid);
                    $this->db->insert('invoice_to_tehvil', $data_tehvil);
                }
            }
            //Product Data

            $pid = $this->input->post('pid');


            $this->aauth->applog("Fatura Düzenlendi $invocieno ID ".$iid,$this->aauth->get_user()->username);
            kont_kayit(30,$iid);

            $productlist = array();

            $prodindex = 0;

            $itc = 0;

            $this->db->delete('geopos_invoice_items', array('tid' => $iid));
            $this->db->delete('geopos_project_items_gider', array('tid' => $iid));





            foreach ($pid as $key => $value) {
                $toplam_rulo=0;



                $product_id = $this->input->post('pid');

                $product_name1 = $this->input->post('product_name',true);

                $product_qty = $this->input->post('product_qty');
                $old=$this->input->post('old_product_qty');
                if(isset($old))
                {
                    $old_product_qty = $old;
                }else
                {
                    $old_product_qty=0;
                }



                $old_depo_id_item = $this->input->post('old_depo_id_item'); //100

                $product_price = $this->input->post('product_price');

                $product_tax = $this->input->post('product_tax');

                $product_discount = $this->input->post('product_discount');

                $product_subtotal = $this->input->post('product_subtotal');

                $ptotal_tax = $this->input->post('taxa');

                $ptotal_disc = $this->input->post('disca');

                $product_des = $this->input->post('product_description',true);

                $product_unit = $this->input->post('unit');

                $product_hsn = $this->input->post('hsn');
                $depo_id_item = $this->input->post('depo_id_item');

                $total_discount += $ptotal_disc[$key];

                $total_tax += $ptotal_tax[$key];

                //echo "<br>";echo $key.'-'.$product_id[$key];

                if($product_id[$key]!=0) {


                    $p_price=$product_price[$key];
                    $p_tax=$product_tax[$key];
                    $p_discount=$product_discount[$key];
                    $p_subtotal=$product_subtotal[$key];
                    $p_total_tax=$ptotal_tax[$key];
                    $p_total_discount=$ptotal_disc[$key];

                    $data = array(

                        'tid' => $iid,

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

                        'invoice_type_id' => $invoice_type,
                        'proje_id' => $proje_id,
                        'depo_id' => $depo_id_item[$key],

                        'invoice_type_desc' => invoice_type_id($invoice_type)

                    );
                    $productlist[$prodindex] = $data;
                    $i++;

                    $prodindex++;

                }


                //alış fiyatlarını görebilmemiz için tabloya ekleme yapıyoruz

                //$this->stock_product_price($iid,$bill_date,$product_id[$key],$product_qty[$key],$depo_id_item[$key],$p_price,$p_tax,$p_discount,$p_subtotal,$p_total_tax,$p_total_discount,$kur_degeri,$para_birimi);

                //alış fiyatlarını görebilmemiz için tabloya ekleme yapıyoruz


                if(isset($old_product_qty[$key]))
                {
                    $old_product_qty[$key]=$old_product_qty[$key];
                }
                else
                {
                    $old_product_qty[$key]=0;
                }



                $amt = (+$product_qty[$key]) - (+$old_product_qty[$key]);





                $this->db->delete('stock', array('mt_id' => $iid,'form_type'=>2));
                if($invoice_type==1) //Satış
                {
                    if(!$stok_guncellemes){
                        stock_update_new($product_id[$key],$product_unit[$key],$product_qty[$key],0,$depo_id_item[$key],$this->aauth->get_user()->id,$iid,2);
                        $stock_id = $this->db->insert_id();
                    }

                }
                elseif($invoice_type==2) // Alış
                {
                    if(!$stok_guncellemes) {
                        stock_update_new($product_id[$key], $product_unit[$key], $product_qty[$key], 1, $depo_id_item[$key], $this->aauth->get_user()->id, $iid, 2);
                        $stock_id = $this->db->insert_id();
                    }
                }





                $itc += $amt;


            }



            if ($prodindex > 0) {
                $load=array_chunk($productlist, 50, true);

                $this->db->insert_batch('geopos_invoice_items', $productlist);
                $this->db->insert_batch('geopos_project_items_gider', $productlist);



                $this->db->set(array('discount' => $total_discount, 'tax' => $total_tax_, 'items' => $itc));

                $this->db->where('id', $iid);

                $this->db->update('geopos_invoices');

                echo json_encode(array('status' => 200, 'message' => 'Başarıyla Güncellendi','id'=>$iid));

            } else {

                echo json_encode(array('status' => 410, 'message' =>

                    $this->lang->line('ERROR')));

                $transok = false;

            }


            $type=$invoice_type;


            //silinen satırdaki ürünün stoğunu güncelleme


        } else {

            echo json_encode(array('status' => 410, 'message' =>

                "Please add at least one product in invoice"));

            $transok = false;

        }





        if ($transok) {

            $this->db->trans_complete();

        } else {

            $this->db->trans_rollback();

        }



        //profit calculation
        $t_profit = 0;
        $this->db->select('geopos_invoice_items.pid, geopos_invoice_items.price, geopos_invoice_items.qty, geopos_products.fproduct_price');
        $this->db->from('geopos_invoice_items');
        $this->db->join('geopos_products', 'geopos_products.pid = geopos_invoice_items.pid', 'left');
        $this->db->where('geopos_invoice_items.tid', $iid);
        $query = $this->db->get();
        $pids = $query->result_array();
        foreach ($pids as $profit) {
            $t_cost = $profit['fproduct_price'] * $profit['qty'];
            $s_cost = $profit['price'] * $profit['qty'];

            $t_profit += $s_cost - $t_cost;
        }
        $this->db->set('col1', $t_profit);
        $this->db->where('type', 9);
        $this->db->where('rid', $invocieno);
        $this->db->update('geopos_metadata');




    }

    public function update_unit(){
        $this->db->trans_start();
        $unit_id = $this->input->post('unit_id');
        $invoice_id = $this->input->post('invoice_id');
        $invoice_item_id = $this->input->post('invoice_item_id');
        $this->db->set('unit',$unit_id);
        $this->db->where('id', $invoice_item_id);
         if( $this->db->update('geopos_invoice_items')){

             $this->db->set('unit',$unit_id);
             $this->db->where('form_type', 2);
             $this->db->where('mt_id', $invoice_id);
             $this->db->update('stock');


             echo json_encode(array('status' => 200,'message' =>'Başarıyla Güncellendi'));
             $this->db->trans_complete();
         }
         else {
             $this->db->trans_rollback();
             echo json_encode(array('status' => 410, 'message' =>'Hata Aldınız'));

         }
    }

    public function short_edit(){

        $this->db->trans_start();

        $visable = $this->input->post('visable');
        $invoice_id = $this->input->post('invoice_id');
        $total = $this->input->post('total');
        $tax = $this->input->post('tax');
        $tax_oran = $this->input->post('tax_oran');
        $taxstatus = $this->input->post('taxstatus');
        $subtotal = $this->input->post('subtotal');
        $details = $this->db->query("SELECT * FROM geopos_invoices Where id=$invoice_id")->row();
        $old_tax_staus = $details->taxstatus;
        $new_tax_status = $taxstatus;
        if($taxstatus==0){
            $new_tax_status = $old_tax_staus;
        }

        $data = array(
            'visable' => $visable,
            'total' => $total,
            'tax' => $tax,
            'tax_oran' => $tax_oran,
            'taxstatus' => $new_tax_status,
            'subtotal' => $subtotal,

        );

        $this->db->set($data);

        $this->db->where('id', $invoice_id);

        if ($this->db->update('geopos_invoices', $data)) {
            echo json_encode(array('status' => 200,'message' =>'Başarıyla Güncellendi'));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>'Hata Aldınız'));

        }


    }

    public function onay_baslat(){
        $this->db->trans_start();
        $talep_id = $this->input->post('talep_id');
        $type = $this->input->post('type');
        $details = $this->invocies->invoice_details($talep_id,$this->limited);
        $users_ = onay_sort(12,$details['proje_id']);

        $kontrol = $this->db->query("SELECT * FROM invoices_onay_new Where invoices_id = $talep_id and type=1");
        if(!$kontrol->num_rows()){
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
                $this->db->set('bildirim_durumu', 1);
                $this->db->where('id', $talep_id);
                $this->db->update('geopos_invoices');

                $this->talep_history($talep_id,$this->aauth->get_user()->id,'Bildirim Başlatıldı',1);

                $this->aauth->applog("Qaime Bildirim Başlatıldı :  ID : ".$talep_id, $this->aauth->get_user()->username);
                $this->db->trans_complete();

                //kont_kayit(21,$id);
                echo json_encode(array('status' => 200,'message'=>'Başarıyla Bildirim Başlatıldı'));

            }
            else {
                echo json_encode(array('status' => 410, 'message' =>"Projenize Yetkili Kişiler Atanmamıştır veya Seçilen Depoya Yetkili Tanımlanmamıştır.Bu Sebeple İşlem Yapamazsınız."));
                $this->db->trans_rollback();
            }
        }

        else {
            echo json_encode(array('status' => 410, 'message' =>"Onay Sisteminde Kayıt Bulunmaktadır!"));
            $this->db->trans_rollback();
        }

    }


    public function check_pers_all(){
        $id = $this->input->post('talep_id');
        $all=$this->db->query("SELECT invoices_onay_new.*,geopos_employees.name FROM invoices_onay_new
Inner JOIN geopos_employees on invoices_onay_new.user_id = geopos_employees.id Where invoices_onay_new.invoices_id=$id and invoices_onay_new.type=1 and invoices_onay_new.status IN(1,0) GROUP BY invoices_onay_new.user_id");
        if($all->num_rows()){
            echo json_encode(array('status' => 200,'details'=>$all->result()));
        }
        else {
            echo json_encode(array('status' => 410,'messages'=>'Onaylayan Personel Bulunanamıştır'));
        }
    }

    public function onay_olustur(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $status = $this->input->post('status');
        $desc = $this->input->post('desc');
        $aauth_sort = $this->input->post('aauth_sort');
        $details = $this->invocies->invoice_details($id);
        $type = $this->input->post('type');
        $auth_id=$this->aauth->get_user()->id;



        if($status>0){

            $sort_kontrol = $this->db->query("SELECT * FROM invoices_onay_new Where invoices_id=$id and  user_id=$auth_id and  status is null and staff=1 and sort=$aauth_sort and type=$type")->num_rows();
            if($sort_kontrol){
                $new_id=0;
                $new_user_id=0;
                $sort=0;
                $sorts=$aauth_sort+1;
                $new_id_control = $this->db->query("SELECT * FROM `invoices_onay_new` Where type=$type and sort=$sorts and invoices_id=$id and  status is Null ORDER BY `invoices_onay_new`.`id` ASC LIMIT 1");
                if($new_id_control->num_rows()){
                    $new_id = $new_id_control->row()->id;
                    $new_user_id = $new_id_control->row()->user_id;
                    $sort = $new_id_control->row()->sort;
                }
                $data = array(
                    'status' => 1,
                    'staff' => 0,
                );

                $this->db->where('user_id',$this->aauth->get_user()->id);
                $this->db->where('staff',1);
                $this->db->where('type',$type);
                $this->db->set($data);
                $this->db->where('invoices_id', $id);
                if ($this->db->update('invoices_onay_new', $data)) {

                    $this->talep_history($id,$this->aauth->get_user()->id,'Onay Verildi '.$desc);



                    if($new_id){

                        $data_new=array(
                            'staff'=>1,
                        );
                        $this->db->where('id',$new_id);
                        $this->db->set($data_new);
                        $this->db->update('invoices_onay_new', $data_new);

                    }

                    else {
                        //banka onayı bekliyor
                        $this->db->set('status', 22);
                        $this->db->where('id', $id);
                        $this->db->update('geopos_invoices');
                    }
                    $this->db->trans_complete();
                    echo json_encode(array('status' => 'Success','message'=>'Başarıyla Onay Verildi'));

                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));

                }
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Doğru Tercih Yapmadınız Sayfa Yenilemesi Yapınız.".' Hata '));

            }

        }
        elseif($status==-1){
            $staff_details = $this->input->post('staff_details');
            $staff_id = $staff_details['staff_id'];
            $sort_id = $staff_details['sort_id'];
            $onay_id = $staff_details['onay_id'];
            $kontrol = $this->db->query("SELECT * FROM invoices_onay_new Where invoices_onay_new.invoices_id=$id and type=1 and sort BETWEEN $sort_id AND $aauth_sort");
            if($kontrol->num_rows()){
                $update_id = 0;
                foreach ($kontrol->result() as $items){
                    $this->db->set('status', NULL,true);
                    $this->db->set('staff', 0);
                    $this->db->where('id', $items->id);
                    $this->db->update('invoices_onay_new');
                    if($items->sort==$sort_id){
                        $update_id=$items->id;
                    }

                }
                $this->db->set('staff', 1);
                $this->db->where('id', $update_id);
                $this->db->update('invoices_onay_new');

                $personel_name = personel_details($staff_id);
                $this->talep_history($id,$this->aauth->get_user()->id,'Talep Geri Alındı.Atanan Personel : '.$personel_name.' Açıklama : '.$desc);
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success','message'=>'Başarıyla Geri Alındı'));
            }

        }
        elseif($status==0) {

            $data_new=array(
                'status'=>3,
            );
            $this->db->where('id',$id);
            $this->db->where('staff',1);
            $this->db->where('user_id',$this->aauth->get_user()->id);
            $this->db->set($data_new);
            $this->db->update('invoices_onay_new', $data_new);


            $this->db->set('status', 3);
            $this->db->where('id', $id);
            $this->db->update('geopos_invoices');
            $this->talep_history($id,$this->aauth->get_user()->id,'İptal Edildi. Açıklama : '.$desc);


            $this->db->set('invoice_id',NULL);
            $this->db->where('invoice_id', $id);
            $this->db->update('geopos_invoice_transactions');

            //$this->db->delete('firma_gider', array('talep_id' => $id,'type'=>5));
            $this->db->delete('geopos_project_items_gider', array('tid' => $id));


            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla İptal Edildi'));
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



}
