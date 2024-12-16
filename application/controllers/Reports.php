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



class Reports extends CI_Controller

{

    public function __construct()

    {



        parent::__construct();
        $this->load->library("Aauth");
        $selected_db = $this->session->userdata('selected_db');
        if (!empty($selected_db)) {
            $this->db = $this->load->database($selected_db, TRUE);
        }
        $this->load->model('communication_model');
        $this->load->model('reports_model', 'reports');
        $this->load->model('invoices_model', 'invocies');
        $this->load->model('controller_model', 'cont');
        $this->load->model('salary_model', 'model');



        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }



        if (!$this->aauth->premission(8)) {

            $this->limited = $this->aauth->get_user()->id;

        } else {

            $this->limited = '';

        }




    }

    public function mt_depo_report_urun()
    {

        $this->load->helper('cookie');


        $head['title'] = "Urun";

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/mt_depo_report');

        $this->load->view('fixed/footer');
    }


    public function countkasa()
    {

        $result = $this->reports->countkasa();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }



    public function bekleyen_forma_2()

    {


        $head['title'] = "Forma 2 Muhasebe Kontrol Listesi";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/bekleyen_forma_2');

        $this->load->view('fixed/footer');

    }

    public function maascount()
    {
        $result = $this->reports->maascount();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }

    public function cikispers()
    {
        $result = $this->reports->cikispers();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }


    }

    public function forma2_new_count()
    {
        $result = $this->reports->forma2_new_count();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }


    }
    public function forma2count()
    {
        $invoices_where='';
        if($this->session->userdata('set_firma_id')){
            $invoices_where.='and geopos_invoices.loc='.$this->session->userdata('set_firma_id');
            //$this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $count=0;
        $salart_details = $this->db->query("SELECT * FROM `geopos_invoices` Where status = 19 $invoices_where");
        if($salart_details->num_rows()>0){
            $count =$salart_details->num_rows();

        }
        else {
            $count = 0;
        }

        echo json_encode(array('status' => 'Success', 'count' =>$count));

    }

    public function onay_qaime_list()
    {

        $result = $this->reports->onay_qaime_list();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }

    }



    public function bekleyenprimcount()
    {
        $result = $this->reports->bekleyenprimcount();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }

    }

    public function bekleyenmaascount()
    {
        $result = $this->reports->bekleyenmaascount();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }

    }

    public function prim_onaylari(){
        $head['title'] = "Bekleyen Prim / Ceza";
        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);
        $id = $this->aauth->get_user()->id;
        $data=[];
        $data['item']=$this->db->query("SELECT personel_prim.*,personel_prim_onay.description ,personel_prim_onay.onaylanan_tutar, personel_prim_onay.id as personel_prim_onay_id,personel_prim_onay.status FROM `personel_prim_onay` INNER JOIN personel_prim ON personel_prim_onay.personel_prim_id = personel_prim.id  Where personel_prim_onay.staff_id= $id  Order BY personel_prim_onay.id DESC")->result();
        $this->load->view('reports/prim_onaylari',$data);

        $this->load->view('fixed/footer');
    }
    public function maas_onayi(){
        $head['title'] = "Bekleyen Maaşlar";
        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/maas_onayi');

        $this->load->view('fixed/footer');
    }
//    public function maas_onayi(){
//        $head['title'] = "Bekleyen Maaşlar";
//        $head['usernm'] = $this->aauth->get_user()->username;
//
//        $this->load->view('fixed/header', $head);
//
//        $this->load->view('reports/maas_onayi');
//
//        $this->load->view('fixed/footer');
//    }
    public function maas_odemesi(){
        $head['title'] = "Onaylanan Maaşlar";
        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/maas_odemesi');

        $this->load->view('fixed/footer');
    }

    public function kasa_talepleri(){
        $data=[];
        $data_=[];
        $data['item']='';
        $array = [];
        $id =  $this->aauth->get_user()->id;
        $kasa_details = $this->db->query("SELECT * FROM `geopos_accounts` Where eid = $id");
        if($kasa_details->num_rows()>0){
            foreach ($kasa_details->result() as $key => $items){
                $kasa_id = $items->id;
                $doviz_transfer = $this->db->query("SELECT * FROM doviz_transfer Where acid = $kasa_id ORDER BY id DESC ");
                if($doviz_transfer->num_rows() > 0) {
                    $array = $doviz_transfer->result();
                    $data_ =  array_merge($array,$data_);
                }

            }

        }





        $data['item']=$data_;
        $head['title'] = "Bekleyen Virman İşlemleri";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/bekleyen_virman_islemleri',$data);

        $this->load->view('fixed/footer');
    }

    public function doviz_transfer_update(){
        $id =  $this->input->post('id');
        $durum =  $this->input->post('durum');
        $desc =  $this->input->post('desc');
        $tutar =  $this->input->post('tutar');
        $item_id =  $this->input->post('item_id');
        $doviz_details = $this->db->query("SELECT * FROM doviz_transfer_item Where id=$id")->row();
        //$this->db->query("UPDATE `doviz_transfer` SET status=$durum where id IN($doviz_details->talep_edilen_id,$doviz_details->talep_eden_id)");
        $this->db->query("UPDATE `doviz_transfer` SET status=$durum,onay_status=1 where id IN($item_id)");

        $this->db->query("UPDATE `doviz_transfer_item` SET status='$desc' , onaylanan_tutar=$tutar where id = $id ");

        $this->db->query("UPDATE `doviz_transfer` SET onaylanan_tutar=$tutar where id = $item_id ");






        $sorgu = $this->db->query("SELECT * FROM doviz_transfer where onay_status=1 and id IN($doviz_details->talep_edilen_id,$doviz_details->talep_eden_id)");
        if($sorgu->num_rows()==2){

            $this->db->query("INSERT INTO `geopos_invoices`(`id`, `tid`, `invoice_no`, `invoice_name`, `invoicedate`, `invoiceduedate`, `subtotal`, `shipping`, `ship_tax`, `ship_tax_type`, `discount`, `tax`, `tax_oran`, `total`, `pmethod`, `notes`, `csd`, `eid`, `pamnt`, `items`, `taxstatus`, `discstatus`, `format_discount`, `discount_rate`, `refer`, `term`, `multi`, `i_class`, `loc`, `r_time`, `invoice_type_id`, `invoice_type_desc`, `payer`, `acid`, `acid_`, `account`, `debit`, `credit`, `method`, `task_id`, `asama_id`, `alt_asama_id`, `bolum_id`, `new_prd_id`, `proje_id`, `para_birimi`, `kur_degeri`, `depo`, `purchase_id`, `last_balance`, `kdv_last_balance`, `masraf_id`, `odeme_durumu`, `ithalat_ihracat_tip`, `dosya_id`, `cari_pers_type`, `ext`, `alt_cari_id`, `stok_guncelle`, `pers_notes`, `oran`, `status`, `create_date`, `malzeme_talep_id`, `satinalma_talep_id`, `maas_ay`, `talep_id_finance`, `bildirim_durumu`, `proje_muduru_id`, `genel_mudur_id`, `odeme_emri_id`, `updated_user_id`)
SELECT NULL, `tid`, `invoice_no`, `invoice_name`, `invoicedate`, `invoiceduedate`, `subtotal`, `shipping`, `ship_tax`, `ship_tax_type`, `discount`, `tax`, `tax_oran`, `onaylanan_tutar`, `pmethod`, `notes`, `csd`, `eid`, `pamnt`, `items`, `taxstatus`, `discstatus`, `format_discount`, `discount_rate`, `refer`, `term`, `multi`, `i_class`, `loc`, `r_time`, `invoice_type_id`, `invoice_type_desc`, `payer`, `acid`, `acid_`, `account`, `debit`, `credit`, `method`, `task_id`, `asama_id`, `alt_asama_id`, `bolum_id`, `new_prd_id`, `proje_id`, `para_birimi`, 1, `depo`, `purchase_id`, `last_balance`, `kdv_last_balance`, `masraf_id`, `odeme_durumu`, `ithalat_ihracat_tip`, `dosya_id`, `cari_pers_type`, `ext`, `alt_cari_id`, `stok_guncelle`, `pers_notes`, `oran`, 1, `create_date`, `malzeme_talep_id`, `satinalma_talep_id`, `maas_ay`, `talep_id_finance`, `bildirim_durumu`, `proje_muduru_id`, `genel_mudur_id`, `odeme_emri_id`, `updated_user_id` FROM `doviz_transfer` WHERE id=$doviz_details->talep_edilen_id");
            $this->db->query("INSERT INTO `geopos_invoices`(`id`, `tid`, `invoice_no`, `invoice_name`, `invoicedate`, `invoiceduedate`, `subtotal`, `shipping`, `ship_tax`, `ship_tax_type`, `discount`, `tax`, `tax_oran`, `total`, `pmethod`, `notes`, `csd`, `eid`, `pamnt`, `items`, `taxstatus`, `discstatus`, `format_discount`, `discount_rate`, `refer`, `term`, `multi`, `i_class`, `loc`, `r_time`, `invoice_type_id`, `invoice_type_desc`, `payer`, `acid`, `acid_`, `account`, `debit`, `credit`, `method`, `task_id`, `asama_id`, `alt_asama_id`, `bolum_id`, `new_prd_id`, `proje_id`, `para_birimi`, `kur_degeri`, `depo`, `purchase_id`, `last_balance`, `kdv_last_balance`, `masraf_id`, `odeme_durumu`, `ithalat_ihracat_tip`, `dosya_id`, `cari_pers_type`, `ext`, `alt_cari_id`, `stok_guncelle`, `pers_notes`, `oran`, `status`, `create_date`, `malzeme_talep_id`, `satinalma_talep_id`, `maas_ay`, `talep_id_finance`, `bildirim_durumu`, `proje_muduru_id`, `genel_mudur_id`, `odeme_emri_id`, `updated_user_id`)
SELECT NULL, `tid`, `invoice_no`, `invoice_name`, `invoicedate`, `invoiceduedate`, `subtotal`, `shipping`, `ship_tax`, `ship_tax_type`, `discount`, `tax`, `tax_oran`, `onaylanan_tutar`, `pmethod`, `notes`, `csd`, `eid`, `pamnt`, `items`, `taxstatus`, `discstatus`, `format_discount`, `discount_rate`, `refer`, `term`, `multi`, `i_class`, `loc`, `r_time`, `invoice_type_id`, `invoice_type_desc`, `payer`, `acid`, `acid_`, `account`, `debit`, `credit`, `method`, `task_id`, `asama_id`, `alt_asama_id`, `bolum_id`, `new_prd_id`, `proje_id`, `para_birimi`, 1, `depo`, `purchase_id`, `last_balance`, `kdv_last_balance`, `masraf_id`, `odeme_durumu`, `ithalat_ihracat_tip`, `dosya_id`, `cari_pers_type`, `ext`, `alt_cari_id`, `stok_guncelle`, `pers_notes`, `oran`, 1, `create_date`, `malzeme_talep_id`, `satinalma_talep_id`, `maas_ay`, `talep_id_finance`, `bildirim_durumu`, `proje_muduru_id`, `genel_mudur_id`, `odeme_emri_id`, `updated_user_id` FROM `doviz_transfer` WHERE id=$doviz_details->talep_eden_id");

        }


        echo json_encode(array('status' => 'Success', 'message' =>"Başarıyla Güncellendi"));


    }


    public function prim_update(){
        $method =  $this->input->post('method');
        $durum =  $this->input->post('durum');
        $tutar =  $this->input->post('tutar');
        $desc =  $this->input->post('desc');
        $personel_prim_onay_id =  $this->input->post('personel_prim_onay_id');
        $id =  $this->aauth->get_user()->id;

        $personel_prim_id = $this->db->query("SELECT * FROM personel_prim_onay Where id=$personel_prim_onay_id")->row()->personel_prim_id;
        if($durum==1) // Onay
        {
            $this->db->query("UPDATE `personel_prim_onay` SET status=$durum, is_staff =0,onaylanan_tutar=$tutar,description='$desc',method=$method where id = $personel_prim_onay_id and staff_id=$id");

            $this->db->query("UPDATE `personel_prim_onay` SET is_staff =1,onaylanan_tutar=$tutar,description='$desc',method=$method where personel_prim_id = $personel_prim_id and status=0");
        }
        else {
            $this->db->query("UPDATE `personel_prim_onay` SET status=$durum, is_staff =0,onaylanan_tutar=$tutar,description='$desc',method=$method where id = $personel_prim_onay_id");
        }

            $details = $this->db->query("SELECT * FROM personel_prim_onay Where personel_prim_id=$personel_prim_id and is_staff=1");
            if($details->num_rows() == 0){
                // Genel Müdür Onayladı Personeli Alacak veya Borö

                if($durum==1) // Onay
                {
                    $prim_details = $this->db->query("SELECT personel_prim.*,personel_prim_onay.onaylanan_tutar,`personel_prim_onay`.`method` FROM personel_prim INNER JOIN personel_prim_onay ON personel_prim.id = personel_prim_onay.personel_prim_id  WHERE personel_prim_onay.staff_id=$id and personel_prim.id=$personel_prim_id")->row();
                    $notes='';
                    $invoice_type_id='';
                    $invoice_type_desc='';
                    if($prim_details->type ==1){
                        $notes = 'Prim Hakediş';
                        $invoice_type_id = 15;
                        $invoice_type_desc = "Prim Alacağı";
                    }
                    else {
                        $notes = 'Cezai İşlem';
                        $invoice_type_id = 53;
                        $invoice_type_desc = "Personel Cərimə";
                    }

                    $date = new DateTime('now');




                    $method=0;
                    $m= $prim_details->hesaplanan_ay;

                    if(strlen($m)==1){
                        $m='0'.$m;
                    }
                    $y= $date->format('Y');
                    $total_ay_sayisi_ = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
                    $d = date('Y-'.$m.'-'.$total_ay_sayisi_.' H:i:s');
                    if($prim_details->method==1){
                        $method=1;
                    }
                    else{
                        $method=3;
                    }
                    $data_banka = array(
                        'invoicedate'=>$d,
                        'total' =>$prim_details->onaylanan_tutar,
                        'tid' =>$personel_prim_id,
                        'credit' =>$prim_details->onaylanan_tutar,
                        'payer' =>personel_details($prim_details->personel_id),
                        'notes' => $notes,
                        'method' => $method,
                        'csd'=>$prim_details->personel_id,
                        'maas_ay'=>$prim_details->hesaplanan_ay,
                        'maas_yil'=>$y,
                        'eid'=>$this->aauth->get_user()->id,
                        'invoice_type_id'=>$invoice_type_id,
                        'invoice_type_desc'=>$invoice_type_desc
                    );
                    $this->db->insert('geopos_invoices', $data_banka);
                }



                // Genel Müdür Onayladı
            }



        echo json_encode(array('status' => 'Success', 'message' =>"Başarıyla Güncellendi"));


    }

    public function test(){
        $date = new DateTime('now');




        $method=0;
        $m=5;
        if(strlen($m)==1){
            $m='0'.$m;
        }
        $y= $date->format('Y');
        $total_ay_sayisi_ = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
        $d = date('Y-'.$m.'-'.$total_ay_sayisi_.' H:i:s');

        echo $d;
    }

    public function onaylananlar(){
        $head['title'] = "Onaylanan Ödemeler";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/onaylanan_odemeler');

        $this->load->view('fixed/footer');
    }

    public function onay_bekleyen_odemeler(){
        $head['title'] = "Onay Bekleyen Ödemeler";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/onay_bekleyen_odemeler');

        $this->load->view('fixed/footer');
    }

    public function ajax_bekleyen_odemeler(){

        $data = [];
        $total=0;
        $payer = $this->input->post('payer');
        $proje = $this->input->post('proje');
        $status = $this->input->post('status');
        $no = 0;

        $total_bekleyen=0;
        $nakit_bekleyen=0;
        $bank_bekleyen=0;
        $odenen_toplam_=0;
        $odenen_nakit_total=0;
        $odenen_banks=0;



        foreach(odeme_bekleyen_talepler_($_POST['length'],$_POST['start'],$_POST['search']['value'],$_POST['order'][0]['column'],$_POST['order'][0]['dir'],$payer,$proje,$status) as $odeme) {
            $no++;
            $odeme_total = 0;
            $total_cikan = 0;
            $kalan = 0;
            $toplam_= $odeme->total;
            if($odeme->invoice_type_id == 0 ){ // Talepler
                $tip = '';
                $href = '';
                $pers_id = $odeme->talep_eden_pers_id;

                if ($odeme->cari_pers == 2) {
                    $pers_name = customer_details($odeme->talep_eden_pers_id)['company'];
                } else {
                    $pers_name = personel_details($odeme->talep_eden_pers_id);

                }

                $desc = $odeme->description;


                if ($odeme->tip == 4) {
                    $tip = 'Gider Talebi';
                    $href = '/form/gider_view?id=' . $odeme->id;
                    $total += $odeme->total;

                    $total_cikan= talep_pay_history($odeme->id);

                    $kalan = floatval($odeme->total) - floatval($total_cikan);
                }
                if($odeme->tip==6) {
                    $toplam_=$odeme->talep_total;
                    $tip = 'Ödeme Talebi';
                    $href = '/form/odeme_talep_view?id=' . $odeme->id;

                    $total += $odeme->talep_total;

                    $total_cikan= talep_pay_history($odeme->id);

                    $kalan = floatval($odeme->talep_total) - floatval($total_cikan);
                }
                if($odeme->tip == 7) {
                    $toplam_=$odeme->talep_total;
                    $tip = 'Forma 2 Ödeme Talebi';
                    $href = '/form/odeme_talep_view?id=' . $odeme->id;

                    $total += $odeme->talep_total;

                    $total_cikan= talep_pay_history($odeme->id);

                    $kalan = floatval($odeme->talep_total) - floatval($total_cikan);
                }

                if($odeme->tip == 5) {
                    $tip = 'Avans Talebi';
                    $href = '/form/avans_view?id=' . $odeme->id;

                    $total += $odeme->total;

                    $total_cikan= talep_pay_history($odeme->id);

                    $kalan = floatval($odeme->total) - floatval($total_cikan);
                }




                if ($pers_name == 'Firma') {
                    $pers_name = 'Cari Oluşturulmamış';
                    $desc = gider_kalemi($odeme->id);
                }

                if($odeme->method==1){
                    $odenen_nakit_total+=$total_cikan;
                }
                else {
                    $odenen_banks+=$total_cikan;
                }

            }
            else {
                $tip = 'Forma 2';
                $pers_id = $odeme->csd;
                $pers_name = customer_details($pers_id)['company'];
                $href = '/invoices/view_form2?id=' . $odeme->id;
                $desc = $odeme->notes;


                $teminat = 0;
                $ceza_total = 0;
                $prim = 0;
                $kur_degeri=para_birimi_id($odeme->para_birimi)['rate'];
                $carpim=$kur_degeri;

                foreach (forma_2_pay_history($odeme->id) as  $value){
                    if($value->invoice_type_id == 55) // Teminat
                    {
                        $teminat+=$value->total;
                    }
                    else if($value->invoice_type_id == 54) // Ceza
                    {
                        $ceza_total+=$value->total;
                    }
                    else if($value->invoice_type_id == 57) // Prim
                    {
                        $prim+=$value->total;
                    }
                    else { // Ödeme
                        $odeme_total += $value->total;
                    }
                }

                $total_cikan = $odeme_total  +$teminat + $ceza_total;
                $kalan = ($odeme->total*$carpim)-($total_cikan);

                if($odeme->method==1){
                    $odenen_nakit_total+=$total_cikan;
                }
                else {
                    $odenen_banks+=$total_cikan;
                }

            }


            $odenen_toplam_+=$total_cikan;


            if($kalan!=0){
                $total_bekleyen+=$kalan;
                if($odeme->method==1){
                    $nakit_bekleyen+=$kalan;
                }
                else {
                    $bank_bekleyen+=$kalan;
                }

                $row = array();
                //$row[] = "<input type='checkbox' class='form-control talep_ids' name='talep_ids[]' value='$talep_details->id'>";
                $row[] =$no;
                $row[] = '<a target="_blank" class="btn btn-dark btn-sm" href="'.$href.'">'.$tip.'</a>';
                $row[] = proje_name($odeme->proje_id);
                $row[] = $odeme->payer;
                $row[] = $desc;
                $row[] = account_type_sorgu($odeme->method);
                $row[] = amountFormat($toplam_) ;
                $row[] = amountFormat($total_cikan) ;
                $row[] = amountFormat($kalan) ;
                $row[] = '<button type="button" tip = "'.$odeme->tip.'" data-id="'.$odeme->id.'" data-toggle="modal"  data-remote="false" class="odeme_emri_button btn btn-info">Ödeme Emri Ver</button>' ;
                //$row[] = '<a href="#pop_modal_transaction" data-id="'.$odeme->id.'" data-toggle="modal"  data-remote="false" class="odeme_button btn btn-success">Ödeme Yap</a>' ;

                $data[] = $row;
            }


        }




//
//        $list = odeme_bekleyen_talepler_();
//        foreach ($list as $list_values){
//            $total_bekleyen += $list_values->total;
//            if($list_values->method==1){
//                $nakit_bekleyen += $list_values->total;
//            }
//            else if($list_values->method==3){
//                $bank_bekleyen += $list_values->total;
//            }
//        }



        $totals['odenen_toplam']=amountFormat($odenen_toplam_);
        $totals['odenen_bank']=amountFormat($odenen_banks);
        $totals['odenen_nakit']=amountFormat($odenen_nakit_total);

        $totals['total_bekleyen']=amountFormat($total_bekleyen);
        $totals['nakit_bekleyen']=amountFormat($nakit_bekleyen);
        $totals['bank_bekleyen']=amountFormat($bank_bekleyen);


        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => count(odeme_bekleyen_talepler_($_POST['length'],$_POST['start'],$_POST['search']['value'])),

            "recordsFiltered" => count(odeme_bekleyen_talepler_()),

            "data" => $data,
            "totals" => $totals,

        );

        //output to json format

        echo json_encode($output);


    }

    public function proje_mudur_prim_method(){
        $personel_prim_id=$this->input->post("personel_prim_id");
        $proje_mudur_durum_kontrol=$this->db->query("SELECT * FROM `personel_prim_onay` where is_staff=0 and personel_prim_id=$personel_prim_id and tip=1")->row();

        echo json_encode(array('method'=>$proje_mudur_durum_kontrol->method));

    }

    public function prim_onaylari_list(){
        $id = $this->aauth->get_user()->id;
        $data=[];
        $i=1;
       $list=$this->reports->prim_onaylari_list($id);
       foreach ($list as $items){

           $prim_desc='';
           $proje_adi = proje_name($items->proje_id);

           $image='<a target="_blank" href="' . base_url() . 'userfiles/product/' . $items->file . '"   class="btn btn-info btn-sm"><span class="fa fa-file"></span> Dosya</a>';
            if($items->type == 1){
                $prim_desc='Prim';
            }else {
                $prim_desc='Ceza';

            }
            $islem='';
           if($items->status==0){
            $islem = "<button personel_prim_id='$items->personel_prim_id' tutar='$items->tutar' type ='$prim_desc' class='btn btn-success onayla' type='button' personel_prim_onay='$items->personel_prim_onay_id'>İşlem Yap</button>";
            }
            elseif($items->status==1){
                $islem="Onaylandı";
            }
            elseif($items->status==2){
                $islem="İptal Edildi";


            }

           $prj_s='Bekliyor';
           $prj_method='';
           $proje_mudur_durum_kontrol=$this->db->query("SELECT * FROM `personel_prim_onay` where  personel_prim_id=$items->personel_prim_id and tip=1")->row();
           if($proje_mudur_durum_kontrol->status==2){
               $prj_s='İptal Edildi';
           }
           else if($proje_mudur_durum_kontrol->status==1){
               $prj_s='Onaylandı';
           }
             else if($proje_mudur_durum_kontrol->status==0){
               $prj_s='Bekliyor';
           }


           if($proje_mudur_durum_kontrol->staff_id==$id){

               $row = array();
               $row[] =$i;
               $row[] = $items->created_at;
               $row[] =personel_details($items->personel_id);
               $row[] = $prim_desc;
               $row[] = personel_details($items->user_id);
               $row[] = $proje_adi;
               $row[] = $items->aciklama;
               $row[] = amountFormat($items->tutar);
               $row[] = amountFormat($items->onaylanan_tutar);
//               $row[] = $items->description;
//               $row[] = $prj_s;
               $row[] = $image;
               $row[] = $islem;
               $data[] = $row;
               $i++;
           }
           else {
               if($proje_mudur_durum_kontrol->status==1){
                   $row = array();
                   $row[] =$i;
                   $row[] = $items->created_at;
                   $row[] =personel_details($items->personel_id);
                   $row[] = $prim_desc;
                   $row[] = personel_details($items->user_id);
                   $row[] = $proje_adi;
                   $row[] = $items->aciklama;
                   $row[] = amountFormat($items->tutar);
                   $row[] = amountFormat($items->onaylanan_tutar);
//                   $row[] = $items->description;
//                   $row[] = $prj_s;
                   $row[] = $image;
                   $row[] = $islem;
                   $data[] = $row;
                   $i++;
               }
           }




       }


        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->reports->count_filtered_prim($id),

            "recordsFiltered" => $this->reports->count_all_prim($id),

            "data" => $data,

        );
        echo json_encode($output);
    }

    public function ajax_bekleyen_odemeler_count(){

        $data = [];
        $total=0;
        $payer = $this->input->post('payer');
        $proje = $this->input->post('proje');
        $status = $this->input->post('status');
        $no = 0;

        $total_bekleyen=0;
        $nakit_bekleyen=0;
        $bank_bekleyen=0;
        $odenen_toplam_=0;
        $odenen_nakit_total=0;
        $odenen_banks=0;


        foreach(odeme_bekleyen_talepler() as $odeme) {

                $talep_total = amountFormat($odeme->total);
                $talep_total_ = $odeme->total;

                if($odeme->tip==4)
                {
                    $talep_total_ = $odeme->total;

                }
                if($odeme->tip==6)
                {

                    $talep_total_ = $odeme->talep_total;
                }
                if($odeme->tip==7)
                {
                    $talep_total_ = $odeme->talep_total;

                }

                $total_bekleyen+=$talep_total_;
                if($odeme->method==1){
                    $nakit_bekleyen+=$talep_total_;
                }
                else {
                    $bank_bekleyen+=$talep_total_;
                }

            }














        $totals['total_bekleyen']=amountFormat(floatval($total_bekleyen));
        $totals['nakit_bekleyen']=amountFormat(floatval($nakit_bekleyen));
        $totals['bank_bekleyen']=amountFormat(floatval($bank_bekleyen));




        //output to json format

        echo json_encode(array('totals'=>$totals));


    }

    public function ajax_onaylanan_odemeler(){

        $data = [];
        $total=0;
        $payer = $this->input->post('payer');
        $proje = $this->input->post('proje');
        $status = $this->input->post('status');
        $no = 0;
        $user_id =$this->aauth->get_user()->id;

        $odeme_total = 0;
        $total_cikan = 0;
        $kalan = 0;
        $tip_=0;

        foreach(odeme_onaylanan_talepler_($_POST['length'],$_POST['start'],$_POST['search']['value'],$_POST['order'][0]['column'],$_POST['order'][0]['dir'],$payer,$proje,$status,$user_id) as $odeme) {
            $no++;
            $total_ = $odeme->total;
            if($odeme->invoice_type_id == 0 ){
                $tip = '';
                $href = '';
                $total_cikan=0;
                $pers_id = $odeme->talep_eden_pers_id;
                if ($odeme->cari_pers == 2) {
                    $pers_name = customer_details($odeme->talep_eden_pers_id)['company'];
                } else {
                    $pers_name = personel_details($odeme->talep_eden_pers_id);

                }

                $desc = $odeme->description;


                if ($pers_name == 'Firma') {
                    $pers_name = 'Cari Oluşturulmamış';
                    $desc = gider_kalemi($odeme->id);
                }

                if ($odeme->tip == 4) {

                    $tip = 'Gider Talebi';
                    $href = '/form/gider_view?id=' . $odeme->id;
                    $total += $odeme->total;
                    $total_cikan= talep_pay_history($odeme->id);
                    $kalan = floatval($odeme->total) - floatval($total_cikan);
                }

                else if ($odeme->tip == 6) {
                    $total_=$odeme->talep_total;
                    $tip = 'Ödeme Talebi';
                    $href = '/form/odeme_talep_view?id=' . $odeme->id;

                    $total += $odeme->talep_total;
                    $total_cikan= talep_pay_history($odeme->id);
                    $kalan = floatval($odeme->talep_total) - floatval($total_cikan);
                }
                else if ($odeme->tip == 7) {
                    $total_=$odeme->talep_total;
                    $tip = 'Forma2 Ödeme Talebi';
                    $href = '/form/odeme_talep_view?id=' . $odeme->id;

                    $total += $odeme->talep_total;
                    $total_cikan= talep_pay_history($odeme->id);
                    $kalan = floatval($odeme->talep_total) - floatval($total_cikan);
                }

                else {
                    $total += $odeme->total;
                    $total_cikan= talep_pay_history($odeme->id);
                    $kalan = floatval($odeme->total) - floatval($total_cikan);
                    $tip = 'Avans Talebi';

                    $href = '/form/avans_view?id=' . $odeme->id;
                }

                $tip_=1;
            }
            else {
                $tip_=2;
                $total_cikan=0;
                $tip = 'Forma 2';
                $pers_id = $odeme->csd;
                $pers_name = customer_details($pers_id)['company'];
                $href = '/invoices/view_form2?id=' . $odeme->id;

                $desc = $odeme->notes;

                $teminat = 0;
                $ceza_total = 0;
                $prim = 0;
                $odeme_total = 0;
                $kur_degeri=para_birimi_id($odeme->para_birimi)['rate'];
                $carpim=$kur_degeri;


                foreach (forma_2_pay_history($odeme->id) as  $value){
                    if($value->invoice_type_id == 55) // Teminat
                    {
                        $teminat+=$value->total;
                    }
                    else if($value->invoice_type_id == 54) // Ceza
                    {
                        $ceza_total+=$value->total;
                    }
                    else if($value->invoice_type_id == 57) // Prim
                    {
                        $prim+=$value->total;
                    }
                    else { // Ödeme
                        $odeme_total += $value->total;
                    }
                }


                $total_cikan = $odeme_total  + $teminat + $ceza_total;
                $kalan = ($odeme->total*$carpim)-($total_cikan);
            }

            $odeme_emri='';
            $odeme_tarihi='';
            $odeme_personeli='';
            $sql = $this->db->query("SELECT * FROM `geopos_invoices` LEFT JOIN geopos_accounts ON geopos_invoices.acid= geopos_accounts.id WHERE geopos_invoices.tid=$odeme->id and geopos_invoices.invoice_type_id=42");

            if($sql->num_rows()>0){
                $odeme_emri=$sql->row()->notes;
                $odeme_tarihi=dateformat($sql->row()->invoicedate);
                $odeme_personeli=personel_details($sql->row()->odeme_emri_id);
            }

            $row = array();
            if($kalan!=0){
                //$row[] = "<input type='checkbox' class='form-control talep_ids' name='talep_ids[]' value='$talep_details->id'>";
                $row[] =$no;
                $row[] = '<a target="_blank" class="btn btn-dark btn-sm" href="'.$href.'">'.$tip.'</a>';
                $row[] = proje_name($odeme->proje_id);
                $row[] = $odeme->payer;

                $row[] = $desc;
                $row[] = $odeme_personeli;
                $row[] = $odeme_tarihi;
                $row[] = $odeme_emri;
                $row[] = "<input class='form-control muh_note' invoice_type_tip='$odeme->invoice_type_id' file_id='$odeme->id' style='border: none;' value='$odeme->muhasebe_notes'>";
                $row[] = amountFormat($total_) ;
                $row[] = amountFormat($total_cikan) ;
                $row[] = amountFormat($kalan) ;
                $row[] = '<a href="#pop_modal_transaction" data-id="'.$odeme->id.'"  tip ="'.$tip_.'" data-toggle="modal"  data-remote="false" class="odeme_button btn btn-success">Ödeme Yap</a>' ;
                $data[] = $row;
            }


        }








        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => count(odeme_bekleyen_talepler_($_POST['length'],$_POST['start'],$_POST['search']['value'])),

            "recordsFiltered" => count(odeme_bekleyen_talepler_()),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);


    }

    public function onay_bekleyen_islemler()

    {

        if (!$this->aauth->premission(8)) {

            exit('<h3>Üzgünüm! Giriş Yetkiniz Bulunmamaktadır</h3>');

        }

        setcookie('invoice_id', 1, time() + (86400 * 30), "/"); // 86400 = 1 day
        $head['title'] = "Onay Bekleyen İşlemler";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/onay_bekleyen_islemler');

        $this->load->view('fixed/footer');

    }

    public function odeme_emri(){
        $tip = $this->input->post('tip');
        $file_id = $this->input->post('talep_id');
        $desc = $this->input->post('desc');
        $tutar = $this->input->post('tutar');

        $odeme_tarihi_ = $this->input->post('odeme_date');
        $odeme_tarihi = datefordatabase($odeme_tarihi_);

        $user_id = $this->input->post('user_id');

        $talep_details = $this->db->query("SELECT * FROM geopos_talep WHERE id =$file_id ")->row();
        if($talep_details->tip !=6){
            $kontrol = $this->db->query("SELECT * FROM geopos_invoices Where tid =$file_id and invoice_type_id = 42");
            if($kontrol->num_rows()>0)
            {
                $personel = personel_details($user_id);
                $this->db->query("UPDATE `geopos_invoices` SET status = 10,odeme_emri_id = $user_id where id=$file_id");
                $this->db->query("UPDATE `geopos_invoices` SET payer ='$personel', odeme_emri_id = $user_id where tid=$file_id");
                $this->db->query("UPDATE `geopos_talep` SET status =7 where id=$file_id");

                $this->aauth->applog("ödeme emri daha önceden verildi talep $file_id ID ",$this->aauth->get_user()->username,$file_id);
                //echo json_encode(array('status' => 'Error', 'message' =>"Ödeme Emri Daha Önce Oluşturuldu.Güncelleme Yapıldı"));
                echo json_encode(array('status' => 'Error', 'message' =>"Güncelleme Yapıldı"));

                exit();
            }
            else
            {
                $data=array(
                    'tid'=>$file_id,
                    'odeme_emri_id'=>$user_id,
                    'payer'=>personel_details($user_id),
                    'invoice_type_id'=>42,
                    'invoice_type_desc'=>'Ödeme Emri',
                    'invoicedate'=>$odeme_tarihi,
                    'total'=>$tutar,
                    'notes'=>$desc
                );
                $this->db->insert('geopos_invoices', $data);

                $this->db->query("UPDATE `geopos_invoices` SET odeme_emri_id = $user_id where id=$file_id");
                $this->aauth->applog("ödeme emri  verildi talep $file_id ID ",$this->aauth->get_user()->username,$file_id);


            }
        }
        else {
            $data=array(
                'tid'=>$file_id,
                'odeme_emri_id'=>$user_id,
                'payer'=>personel_details($user_id),
                'invoice_type_id'=>42,
                'invoice_type_desc'=>'Ödeme Emri',
                'invoicedate'=>$odeme_tarihi,
                'total'=>$tutar,
                'notes'=>$desc
            );
            $this->db->insert('geopos_invoices', $data);

            $this->db->query("UPDATE `geopos_invoices` SET odeme_emri_id = $user_id where id=$file_id");
        }




        if($tip=='10'){

            $this->db->query("UPDATE `geopos_invoices` SET status = 10 where id=$file_id");

            $subject = 'Ödeme Emri!';

            $talep_details = $this->db->query("SELECT * FROM geopos_invoices WHERE id =$file_id ")->row();

            $message = 'Sayın Yetkili ' . $talep_details->invoice_no . ' Numaralı Forma2 ye Ödeme Emri Verildi';
            $message .= "<br><br><br><br>";

            $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

            $email = personel_detailsa($user_id)['email'];
            $recipients = array($email);
            $this->onay_mailleri($subject, $message, $recipients, 'avans_talep_onay_maili');

        }
        else
        {
            $this->db->set('status', 7);
            $this->db->where('id', $file_id);
            $this->db->update('geopos_talep');

            $data=array(
                'tid'=>$file_id,
                'odeme_emri_id'=>$user_id,
                'payer'=>personel_details($user_id),
                'invoice_type_id'=>42,
                'total'=>$tutar,
                'invoice_type_desc'=>'Ödeme Emri',
                'invoicedate'=>$odeme_tarihi,
                'notes'=>$desc
            );
            $this->db->insert('geopos_invoices', $data);

            $this->db->query("UPDATE `geopos_talep` SET odeme_emri_id = $user_id where id=$file_id");

            $subject = 'Ödeme Emri!';

            $talep_details = $this->db->query("SELECT * FROM geopos_talep WHERE id =$file_id")->row();

            $message = 'Sayın Yetkili ' . $talep_details->talep_no . ' Numaralı İşleme Ödeme Emri Verildi';
            $message .= "<br><br><br><br>";

            $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

            $email = personel_detailsa($user_id)['email'];
            $recipients = array($email);
            $this->onay_mailleri($subject, $message, $recipients, 'avans_talep_onay_maili');
            $this->aauth->applog("ödeme emri  verildi forma2 $file_id ID ",$this->aauth->get_user()->username,$file_id);
        }

        echo json_encode(array('status' => 'Success', 'message' => 'Ödeme Emri Verildi Lütfen Bekleyiniz'));
    }

    public function onay_mailleri($subject, $message, $recipients, $tip)
    {

        $attachmenttrue = false;
        $attachment = '';


        $this->communication_model->onay_mail($recipients, $subject, $message, $attachmenttrue, $attachment, $tip);
        return 1;

    }


    public function ajax_list()

    {



        $list = $this->invocies->get_datatables_onay($this->limited);








        $data = array();



        $no = $this->input->post('start');

        $this->session->set_userdata('test', 1);

        foreach ($list as $invoices) {

            $proje_name=proje_name($invoices->proje_id);

            $notes='Proje Adı : '.$proje_name.' &#013;Not : '.$invoices->notes;
            $tool="data-toggle='tooltip' data-placement='top' data-html='true' title='$notes'";
            $no++;

            $row = array();

            $row[] = "<input type='checkbox' class='form-control invoice_ids' name='invoice_ids[]' value='$invoices->id'>";
            $row[] = dateformat($invoices->invoicedate);
            $row[] =  "<span data-toggle='tooltip' data-placement='top' data-html='true' title='".$notes."'>".$invoices->invoice_no."</span>";
            $row[] = $invoices->notes;
            $row[] = $proje_name;
            $row[] = amountFormat($invoices->total,$invoices->para_birimi);
            $row[] = 'Onay Bekliyor';
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>
                    &nbsp;<a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>
                    <a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';

            $data[] = $row;




        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->invocies->count_all_onay($this->limited),

            "recordsFiltered" => $this->invocies->count_filtered_onay($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }

    public function ajax_list_gorusmeler()

    {



        $list = $this->invocies->get_datatables_gorusmeler($this->limited);








        $data = array();



        $no = $this->input->post('start');

        $this->session->set_userdata('test', 1);

        foreach ($list as $invoices) {

            $name=$invoices->content;
            $title=$invoices->title;

            $row = array();

            $row[] = "<input type='checkbox' class='form-control gorusme_ids' name='gorusme_ids[]' value='$invoices->id'>";
            $row[] = dateformat($invoices->cdate);
            $row[] = $title;
            $row[] = $name;
            $row[] = 'Onay Bekliyor';

            $data[] = $row;




        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->invocies->count_all_onay_talep($this->limited),

            "recordsFiltered" => $this->invocies->count_filtered_onay_talep($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }


    public function ajax_list_randevu()

    {



        $list = $this->invocies->get_datatables_randevu($this->limited);






        $data = array();



        $no = $this->input->post('start');

        $this->session->set_userdata('test', 1);

        foreach ($list as $invoices) {

            $name=$invoices->description;
            $title=$invoices->title;
            $status=$invoices->status;
            $_status='';
            if($status==0)
            {
                $_status="Bekliyor";
            }
            else
            {
                $_status="Onaylandı";
            }

            $row = array();

            $row[] = "<input type='checkbox' class='form-control randevu_ids' name='randevu_ids[]' value='$invoices->id'>";
            $row[] = dateformat($invoices->start).' '.$invoices->etkinlik_saati_rel .' </br> '.dateformat($invoices->end).' '.$invoices->etkinlik_saati_bitis_rel;
            $row[] = $title;
            $row[] = $name;
            $row[] = $_status;
            $row[] = '<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-info btn-sm view-bilgi"><span class="fa fa-eye">Görüntüle</span> </a> ';
            $data[] = $row;




        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->invocies->count_all_randevu($this->limited),

            "recordsFiltered" => $this->invocies->count_filtered_randevu($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }



    public function ajax_list_talep()

    {



        $list = $this->invocies->get_datatables_onay_talep($this->limited);





        $data = array();

        $role_id = $this->aauth->get_user()->roleid;
        $user_id =$this->aauth->get_user()->id;

        $no = $this->input->post('start');

        $this->session->set_userdata('test', 1);


        foreach ($list as $invoices) {

            $talep_id=$invoices->file_id;
            $item_id=$invoices->malzeme_items_id;
            $product_id=$invoices->product_id;
            $type=$invoices->type;
            $cari_personel='-';




            if($type==10){
                $talep_detailss=$this->db->query("SELECT * FROM geopos_invoices WHERE id=$talep_id");
                if($talep_detailss->num_rows()>0)
                {
                    $talep_details = $talep_detailss->row();
                    $proje_name=proje_name($talep_details->proje_id);
                    $notes='Proje Adı : '.$proje_name.' &#013;Not : '.$talep_details->notes;
                    $tool="data-toggle='tooltip' data-placement='top' data-html='true' title='$notes'";
                    $no++;
                    $name=$talep_details->notes;


                    $date=dateformat($talep_details->invoicedate);
                    $status='';
                    $tip='';
                    $tutar_miktar='';
                    $href='';
                    if($type==10)
                    {
                        $tip='Forma 2';

                        $href_b='<a href="' . base_url("formainvoices/view_form2?id=$talep_details->id") . '" class="btn btn-success btn-sm" title="Detaylar"><i class="fa fa-eye"></i></a>';;

                        $href="<a href='/formainvoices/view_form2?id=$talep_details->id'><span data-toggle='tooltip' data-placement='top' data-html='true' title='".$notes."'>".$talep_details->invoice_no."</span></a>";

                        $status='Onay Bekliyor';
                        $pers_id=$talep_details->csd;
                        $pers_name=customer_details($talep_details->csd)['company'];
                        $cari_personel="<a target='_blank' href='/customers/view?id=$pers_id' class='btn btn-info btn-sm'>Cari - $pers_name</a>";
                    }
                }
            }
            elseif($type==11){
                $talep_detailss=$this->db->query("SELECT * FROM lojistik_talep WHERE id=$talep_id");
                if($talep_detailss->num_rows()>0)
                {
                    $talep_details = $talep_detailss->row();
                    $proje_name='';
                    $notes=$talep_details->description;
                    $no++;
                    $name=$talep_details->description;


                    $date=dateformat($talep_details->created_at);
                    $status='';
                    $tip='';
                    $tutar_miktar='';
                    $href='';
                    if($type==11)
                    {
                        $tip='Lojistik Talebi';

                        $href_b='<a href="' . base_url("lojistik/view/$talep_details->id") . '" class="btn btn-success btn-sm" title="Detaylar"><i class="fa fa-eye"></i></a>';;

                        $href="<a href='/lojistik/view/$talep_details->id'><span data-toggle='tooltip' data-placement='top' data-html='true' title='".$notes."'>".$talep_details->talep_no."</span></a>";

                        $status='Onay Bekliyor';
                        $pers_id=$talep_details->user_id;
                        $pers_name=personel_details($talep_details->user_id);
                        $cari_personel="<a target='_blank' href='/employee/view?id=$pers_id' class='btn btn-info btn-sm'>Personel - $pers_name</a>";
                    }
                }
            }
            elseif($type==12){
                $talep_detailss=$this->db->query("SELECT * FROM lojistik_satinalma_talep WHERE id=$talep_id");
                if($talep_detailss->num_rows()>0)
                {
                    $talep_details = $talep_detailss->row();
                    $proje_name='';
                    $notes=$talep_details->description;
                    $no++;
                    $name=$talep_details->description;


                    $date=dateformat($talep_details->created_at);
                    $status='';
                    $tip='';
                    $tutar_miktar='';
                    $href='';
                    if($type==12)
                    {
                        $tip='Lojistik Satınalma';

                        $href_b='<a href="' . base_url("logistics/view/$talep_details->id") . '" class="btn btn-success btn-sm" title="Detaylar"><i class="fa fa-eye"></i></a>';;

                        $href="<a href='/logistics/view/$talep_details->id'><span data-toggle='tooltip' data-placement='top' data-html='true' title='".$notes."'>".$talep_details->talep_no."</span></a>";

                        $status='Onay Bekliyor';
                        $pers_id=$talep_details->user_id;
                        $pers_name=personel_details($talep_details->user_id);
                        $cari_personel="<a target='_blank' href='/employee/view?id=$pers_id' class='btn btn-info btn-sm'>Personel - $pers_name</a>";
                    }
                }
            }
            else {
                $talep_detailss=$this->db->query("SELECT * FROM geopos_talep WHERE id=$talep_id");
                if($talep_detailss->num_rows()>0)
                {
                    $talep_details = $talep_detailss->row();
                    $proje_name=proje_name($talep_details->proje_id);



                    $notes='Proje Adı : '.$proje_name.' &#013;Not : '.$talep_details->description;
                    $tool="data-toggle='tooltip' data-placement='top' data-html='true' title='$notes'";
                    $no++;
                    $name=$talep_details->description;


                    $status='';
                    $tip='';
                    $tutar_miktar='';
                    $href='';
                    if($type==1)
                    {
                        $tip='Malzeme Talep Formu';
                        if($talep_details->stok_durumu==1){
                            $tip='Hizmet Talep Formu';
                        }

                        $href_b='<a href="' . base_url("requested/view?id=$talep_details->id") . '" class="btn btn-success btn-sm" title="Detaylar"><i class="fa fa-eye"></i></a>';;

                        $href="<a href='/requested/view?id=$talep_details->id'><span data-toggle='tooltip' data-placement='top' data-html='true' title='".$notes."'>".$talep_details->talep_no."</span></a>";

                        $status='Onay Bekliyor';
                        $pers_id=$talep_details->talep_eden_pers_id;
                        $pers_name=personel_details($talep_details->talep_eden_pers_id);
                        $cari_personel="<a target='_blank' href='/employee/view?id=$pers_id' class='btn btn-info btn-sm'>Personel - $pers_name</a>";
                    }
                    else if($type==4)
                    {
                        $tip='Gider Talep Formu';
                        $href_b='<a href="' . base_url("form/gider_view?id=$talep_details->id") . '" class="btn btn-success btn-sm" title="Detaylar"><i class="fa fa-eye"></i></a>';;
                        $href="<a href='/form/gider_view?id=$talep_details->id'><span data-toggle='tooltip' data-placement='top' data-html='true' title='".$notes."'>".$talep_details->talep_no."</span></a>";

                        $status='Onay Bekliyor';

                        $pers_id=$talep_details->talep_eden_pers_id;
                        $pers_name=personel_details($talep_details->talep_eden_pers_id);
                        $cari_personel="<a target='_blank' href='/employee/view?id=$pers_id' class='btn btn-info btn-sm'>Personel - $pers_name</a>";

                    }
                    else if($type==5)
                    {
                        $tip='Avans Talep Formu';
                        $href_b='<a href="' . base_url("form/avans_view?id=$talep_details->id") . '" class="btn btn-success btn-sm" title="Detaylar"><i class="fa fa-eye"></i></a>';;
                        $href="<a href='/form/avans_view?id=$talep_details->id'><span data-toggle='tooltip' data-placement='top' data-html='true' title='".$notes."'>".$talep_details->talep_no."</span></a>";
                        $status='Onay Bekliyor';

                        if($talep_details->cari_pers==1) //personel
                        {
                            $pers_id=$talep_details->talep_eden_pers_id;
                            $pers_name=personel_details($talep_details->talep_eden_pers_id);
                            $cari_personel="<a target='_blank' href='/employee/view?id=$pers_id' class='btn btn-info btn-sm'>Personel - $pers_name</a>";
                        }
                        else if($talep_details->cari_pers==2) //Cari
                        {
                            $pers_id=$talep_details->talep_eden_pers_id;
                            $pers_name=customer_details($talep_details->talep_eden_pers_id)['company'];
                            $cari_personel="<a target='_blank' href='/customers/view?id=$pers_id' class='btn btn-info btn-sm'>Cari - $pers_name</a>";
                        }

                    }
                    else if($type==2)
                    {
                        $pers_id=$talep_details->kullanici_id;
                        $pers_name=personel_details($talep_details->kullanici_id);
                        $cari_personel="<a target='_blank' href='/employee/view?id=$pers_id' class='btn btn-info btn-sm'>Personel - $pers_name</a>";
                        $tip='Satın Alma Talep Formu';
                        $href_b='<a href="' . base_url("form/satinalma_view?id=$talep_details->id") . '" class="btn btn-success btn-sm" title="Detaylar"><i class="fa fa-eye"></i></a>';;

                        $href="<a href='/form/satinalma_view?id=$talep_details->id'><span data-toggle='tooltip' data-placement='top' data-html='true' title='".$notes."'>".$talep_details->talep_no."</span></a>";

                        if($talep_details->status==3)
                        {
                            $status='Onaylandı';
                        }
                        else
                        {
                            $status='Onay Bekliyor';
                        }

                    }
                    $date= dateformat($talep_details->olusturma_tarihi);



                }

            }

            $row = array();

            //$row[] = "<input type='checkbox' class='form-control talep_ids' name='talep_ids[]' value='$talep_details->id'>";
            $row[] = $no;
            $row[] = $date;
            $row[] =  $tip;
            $row[] = $cari_personel;
            $row[] =  $href;
            $row[] = $name;
            $row[] = $proje_name;
            $row[] = $status;;
            $row[] = $href_b;

            $data[] = $row;





            /*$talep_details=$this->db->query("SELECT geopos_talep_items.product_name,geopos_talep_items.qty,geopos_talep_items.unit,geopos_talep_items.subtotal as
total,geopos_talep.talep_no,geopos_talep.olusturma_tarihi,geopos_talep.proje_id,geopos_talep.description,geopos_talep.id as
talep_id,geopos_talep_items.id as items_id FROM geopos_talep_items INNER JOIN geopos_talep ON geopos_talep_items.tip=geopos_talep.id
 Where geopos_talep_items.tip=$talep_id and geopos_talep_items.id=$item_id")->row(); */





        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->invocies->count_filtered_onay_talep($this->limited),

            "recordsFiltered" => $this->invocies->count_filtered_onay_talep($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }



    //Statistics



    public function statistics()



    {



        $data['stat'] = $this->reports->statistics();

        $head['title'] = "Statistics";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/stat', $data);

        $this->load->view('fixed/footer');



    }



    //accounts section



    public function accountstatement()



    {

        $this->load->model('transactions_model');

        $data['accounts'] = $this->transactions_model->acc_list();

        $head['title'] = "Account Statement";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/statement', $data);

        $this->load->view('fixed/footer');



    }



    public function customerstatement()



    {

        $this->load->model('transactions_model');

        $data['accounts'] = $this->transactions_model->acc_list();

        $head['title'] = "Account Statement";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/customer_statement', $data);

        $this->load->view('fixed/footer');



    }



    public function supplierstatement()



    {

        $this->load->model('transactions_model');

        $data['accounts'] = $this->transactions_model->acc_list();

        $head['title'] = "Account Statement";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/supplier_statement', $data);

        $this->load->view('fixed/footer');



    }



    public function viewstatement()



    {

        $this->load->model('accounts_model', 'accounts');

        $pay_acc = $this->input->post('pay_acc');

        $trans_type = $this->input->post('trans_type');

        $sdate = datefordatabase($this->input->post('sdate'));

        $edate = datefordatabase($this->input->post('edate'));

        $ttype = $this->input->post('ttype');

        $account = $this->accounts->details($pay_acc);

        $data['filter'] = array($pay_acc, $trans_type, $sdate, $edate, $ttype, $account['holder']);

        $head['title'] = "Hesap İşlemleri";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/statement_list', $data);

        $this->load->view('fixed/footer');

    }





    public function customerviewstatement()



    {

        $this->load->model('customers_model', 'customer');

        $cid = $this->input->post('customer');

        $trans_type = $this->input->post('trans_type');

        $sdate = datefordatabase($this->input->post('sdate'));

        $edate = datefordatabase($this->input->post('edate'));

        $ttype = $this->input->post('ttype');

        $customer = $this->customer->details($cid);

        $data['filter'] = array($cid, $trans_type, $sdate, $edate, $ttype, $customer['name']);



        //  print_r( $data['statement']);

        $head['title'] = "Customer Account Statement";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/customerstatement_list', $data);

        $this->load->view('fixed/footer');





    }



    public function supplierviewstatement()



    {

        $this->load->model('supplier_model', 'supplier');

        $cid = $this->input->post('supplier');

        $trans_type = $this->input->post('trans_type');

        $sdate = datefordatabase($this->input->post('sdate'));

        $edate = datefordatabase($this->input->post('edate'));

        $ttype = $this->input->post('ttype');

        $customer = $this->supplier->details($cid);

        $data['filter'] = array($cid, $trans_type, $sdate, $edate, $ttype, $customer['name']);



        //  print_r( $data['statement']);

        $head['title'] = "Supplier Account Statement";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/supplierstatement_list', $data);

        $this->load->view('fixed/footer');





    }





    //



    public function statements()

    {



        $pay_acc = $this->input->post('ac');

        $trans_type = $this->input->post('ty');

        $sdate = date_ajanda($this->input->post('sd'));

        $edate = date_ajanda($this->input->post('ed'));

        $list = $this->reports->get_statements($pay_acc, $trans_type, $sdate, $edate);

        $balance = 0;

        $bakiye=0;
        $alacak_toplam=0;
        $borc_toplam=0;
        $carpim=1;
        $total_b=hesap_balance($pay_acc);


        foreach ($list as $row) {

            $carpim=$row['kur_degeri'];

            $invoice_type_id=$row['invoice_type_id'];
            if($invoice_type_id==3 || $invoice_type_id==5 ) //Tahsilat - Expense
            {
                $alacak_toplam += $row['total']*$carpim;
                $borc_toplam=0;
            }
            else if($invoice_type_id==4 || $invoice_type_id==6 ) //Ödeme - Income
            {
                $borc_toplam += $row['total']*$carpim;
                $alacak_toplam=0;
            }






            echo '
            <tr>
            <td>' . $row['invoicedate'] . '</td>
            <td>' . $row['notes'] . '</td>
            <td>' . amountFormat($alacak_toplam) . '</td>
            <td>' . amountFormat($borc_toplam) . '</td>
            <td>' . amountFormat(abs($total_b),1).($total_b>0?" (B)":" (A)"). '</td></tr>';

        }



    }



    public function customerstatements()

    {





        $pay_acc = $this->input->post('ac');

        $trans_type = $this->input->post('ty');

        $sdate = datefordatabase($this->input->post('sd'));

        $edate = datefordatabase($this->input->post('ed'));





        $list = $this->reports->get_customer_statements($pay_acc, $trans_type, $sdate, $edate);

        $balance = 0;



        foreach ($list as $row) {

            $balance += $row['credit'] - $row['debit'];

            echo '<tr><td>' . $row['date'] . '</td><td>' . $row['note'] . '</td><td>' . amountFormat($row['debit']) . '</td><td>' . amountFormat($row['credit']) . '</td><td>' . amountFormat($balance) . '</td></tr>';

        }



    }



    public function supplierstatements()

    {





        $pay_acc = $this->input->post('ac');

        $trans_type = $this->input->post('ty');

        $sdate = datefordatabase($this->input->post('sd'));

        $edate = datefordatabase($this->input->post('ed'));





        $list = $this->reports->get_supplier_statements($pay_acc, $trans_type, $sdate, $edate);

        $balance = 0;



        foreach ($list as $row) {

            $balance += $row['debit'] - $row['credit'];

            echo '<tr><td>' . $row['date'] . '</td><td>' . $row['note'] . '</td><td>' . amountFormat($row['debit']) . '</td><td>' . amountFormat($row['credit']) . '</td><td>' . amountFormat($balance) . '</td></tr>';

        }



    }





    // income section





    public function incomestatement()



    {

        $head['title'] = "Income Statement";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);



        $this->load->model('transactions_model');

        $data['accounts'] = $this->transactions_model->acc_list();

        $data['income'] = $this->reports->incomestatement();





        $this->load->view('reports/incomestatement', $data);





        $this->load->view('fixed/footer');



    }





    public function customincome()

    {



        if ($this->input->post('check')) {

            $acid = $this->input->post('pay_acc');

            $sdate = datefordatabase($this->input->post('sdate'));

            $edate = datefordatabase($this->input->post('edate'));



            $date1 = new DateTime($sdate);

            $date2 = new DateTime($edate);



            $diff = $date2->diff($date1)->format("%a");

            if ($diff < 365) {

                $income = $this->reports->customincomestatement($acid, $sdate, $edate);



                echo json_encode(array('status' => 'Success', 'message' => 'Calculated', 'param1' => '<hr><b>Income between the dates is ' . amountFormat(floatval($income['credit'])) . '</b>'));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => 'Date range should be within 365 days', 'param1' => ''));

            }



        }

    }



    // expense section





    public function expensestatement()



    {

        $head['title'] = "Expense Statement";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);



        $this->load->model('transactions_model');

        $data['accounts'] = $this->transactions_model->acc_list();

        $data['income'] = $this->reports->expensestatement();





        $this->load->view('reports/expensestatement', $data);





        $this->load->view('fixed/footer');



    }





    public function customexpense()

    {



        if ($this->input->post('check')) {

            $acid = $this->input->post('pay_acc');

            $sdate = datefordatabase($this->input->post('sdate'));

            $edate = datefordatabase($this->input->post('edate'));



            $date1 = new DateTime($sdate);

            $date2 = new DateTime($edate);



            $diff = $date2->diff($date1)->format("%a");

            if ($diff < 365) {

                $income = $this->reports->customexpensestatement($acid, $sdate, $edate);



                echo json_encode(array('status' => 'Success', 'message' => 'Calculated', 'param1' => '<hr><b>Expense between the dates is ' . amountFormat(floatval($income['debit'])) . '</b>'));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => 'Date range should be within 365 days', 'param1' => ''));

            }



        }



    }





    public function refresh_data()



    {





        $head['title'] = "Refreshing Reports";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/refresh_data');

        $this->load->view('fixed/footer');



    }



    public function refresh_process()



    {



        $this->load->model('cronjob_model');

        if ($this->cronjob_model->reports()) {



            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Calculated')));

        }



    }



    public function taxstatement()



    {

        $this->load->model('transactions_model');

        $data['accounts'] = $this->transactions_model->acc_list();

        $head['title'] = "TAX Statement";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->model('locations_model');

        $data['locations'] = $this->locations_model->locations_list();

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/tax_statement', $data);

        $this->load->view('fixed/footer');



    }



    public function taxviewstatement()



    {





        $trans_type = $this->input->post('ty');

        $sdate = datefordatabase($this->input->post('sdate'));

        $edate = datefordatabase($this->input->post('edate'));

        $lid = $this->input->post('lid');

        $data['filter'] = array($sdate, $edate, $trans_type,$lid );





        //  print_r( $data['statement']);

        $head['title'] = "TAX Statement";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/tax_out', $data);

        $this->load->view('fixed/footer');





    }



    public function taxviewstatements_load()

    {





        $trans_type = $this->input->post('ty');

        $sdate = datefordatabase($this->input->post('sd'));

        $edate = datefordatabase($this->input->post('ed'));

        $lid = $this->input->post('loc');



        if ($trans_type == 'Sales') {

            $where = " WHERE (DATE(geopos_invoices.invoicedate) BETWEEN '$sdate' AND '$edate' )";

            if($lid>0) $where .=" AND (geopos_invoices.loc=$lid)";

            $query = $this->db->query("SELECT geopos_customers.taxid AS VAT_Number,geopos_invoices.tid AS invoice_number,geopos_invoices.total AS amount,geopos_invoices.tax AS tax,geopos_customers.name AS customer_name,geopos_customers.company AS Company_Name,geopos_invoices.invoicedate AS date FROM geopos_invoices LEFT JOIN geopos_customers ON geopos_invoices.csd=geopos_customers.id" . $where);

        } else {



            $where = " WHERE (DATE(geopos_purchase.invoicedate) BETWEEN '$sdate' AND '$edate') ";

            if($lid>0) $where .=" AND (geopos_invoices.loc=$lid)";

            $query = $this->db->query("SELECT geopos_supplier.taxid AS VAT_Number,geopos_purchase.tid AS invoice_number,geopos_purchase.total AS amount,geopos_purchase.tax AS tax,geopos_supplier.name AS customer_name,geopos_supplier.company AS Company_Name,geopos_purchase.invoicedate AS date FROM purchase LEFT JOIN supplier ON geopos_purchase.csd=geopos_supplier.id" . $where);

        }





//echo $where;





        $balance = 0;



        foreach ($query->result_array() as $row) {

            $balance += $row['tax'];

            echo '<tr><td>' . $row['invoice_number'] . '</td><td>' . $row['customer_name'] . '</td><td>' . $row['VAT_Number'] . '</td><td>' . amountFormat($row['amount']) . '</td><td>' . amountFormat($row['tax']) . '</td><td>' . amountFormat($balance) . '</td></tr>';

        }





    }



    // profit section





    public function profitstatement()



    {

        $head['title'] = "Profit Statement";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);



        $this->load->model('locations_model');

        $data['locations'] = $this->locations_model->locations_list2();

        $data['income'] = $this->reports->profitstatement();





        $this->load->view('reports/profitstatement', $data);





        $this->load->view('fixed/footer');



    }





    public function customprofit()

    {



        if ($this->input->post('check')) {

            $lid = $this->input->post('pay_acc');

            $sdate = datefordatabase($this->input->post('sdate'));

            $edate = datefordatabase($this->input->post('edate'));



            $date1 = new DateTime($sdate);

            $date2 = new DateTime($edate);



            if ($this->aauth->get_user()->loc) {

                $lid=$this->aauth->get_user()->loc;

            }



            $diff = $date2->diff($date1)->format("%a");

            if ($diff < 365) {

                $income = $this->reports->customprofitstatement($lid, $sdate, $edate);



                echo json_encode(array('status' => 'Success', 'message' => 'Calculated', 'param1' => '<hr> Profit between the dates is ' . amountFormat(floatval($income['col1'])) . ' '));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => 'Date range should be within 365 days', 'param1' => ''));

            }



        }

    }



    // profit section





    public function sales()



    {

        $head['title'] = "Sales Statement";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);



        $this->load->model('locations_model');

        $data['locations'] = $this->locations_model->locations_list();

        $data['income'] = $this->reports->salesstatement();





        $this->load->view('reports/sales', $data);





        $this->load->view('fixed/footer');



    }





    public function customsales()

    {



        if ($this->input->post('check')) {

            $lid = $this->input->post('pay_acc');

            $sdate = datefordatabase($this->input->post('sdate'));

            $edate = datefordatabase($this->input->post('edate'));



            $date1 = new DateTime($sdate);

            $date2 = new DateTime($edate);



            if ($this->aauth->get_user()->loc) {

                $lid=$this->aauth->get_user()->loc;

            }



            $diff = $date2->diff($date1)->format("%a");

            if ($diff < 365) {

                $income = $this->reports->customsalesstatement($lid, $sdate, $edate);



                echo json_encode(array('status' => 'Success', 'message' => 'Calculated', 'param1' => '<hr> Sales between the dates is ' . amountFormat(floatval($income['total'])) . ''));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => 'Date range should be within 365 days', 'param1' => ''));

            }

        }

    }



    // products section

    public function products()



    {



        $this->load->model('locations_model');

        $this->load->model('categories_model');

        $data['locations'] = $this->locations_model->locations_list();

        $data['cat'] = $this->categories_model->category_list();

        $data['income'] = $this->reports->productsstatement();

        $head['title'] = "Products Statement";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/products', $data);

        $this->load->view('fixed/footer');

    }





    public function customproducts()

    {

        if ($this->input->post('check')) {

            $lid = $this->input->post('pay_acc');

            $sdate = datefordatabase($this->input->post('sdate'));

            $edate = datefordatabase($this->input->post('edate'));

            $date1 = new DateTime($sdate);

            $date2 = new DateTime($edate);

            $diff = $date2->diff($date1)->format("%a");

            if ($this->aauth->get_user()->loc) {

                $lid=$this->aauth->get_user()->loc;

            }

            if ($diff < 365) {

                $income = $this->reports->customproductsstatement($lid, $sdate, $edate);

                echo json_encode(array('status' => 'Success', 'message' => 'Calculated', 'param1' => '<hr>Product Sales between the dates is ' . amountFormat(floatval($income['subtotal'])) . ' <br> Qty between the dates is ' . $income['qty']. '.'));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => 'Date range should be within 365 days', 'param1' => ''));

            }



        }

    }



    public function customproducts_cat()

    {

        if ($this->input->post('check')) {

            $lid = $this->input->post('pay_acc');

            $sdate = datefordatabase($this->input->post('sdate'));

            $edate = datefordatabase($this->input->post('edate'));

            $date1 = new DateTime($sdate);

            $date2 = new DateTime($edate);

            $diff = $date2->diff($date1)->format("%a");

            if ($this->aauth->get_user()->loc) {

                $lid=$this->aauth->get_user()->loc;

            }

            if ($diff < 365) {

                $income = $this->reports->customproductsstatement_cat($lid, $sdate, $edate);

                echo json_encode(array('status' => 'Success', 'message' => 'Calculated', 'param1' => '<hr>Product Sales between the dates is ' . amountFormat(floatval($income['subtotal'])) . ' Qty between the dates is ' . $income['qty']. '.'));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => 'Date range should be within 365 days', 'param1' => ''));

            }



        }

    }



    public function fetch_data()

    {

        if ($this->input->get('p')) {



            $data = $this->reports->fetchdata($this->input->get('p'));

            echo json_encode(array('status' => 'Success', 'message' => 'Calculated', 'p1' => $data['p1'], 'p2' => $data['p2'], 'p3' => $data['p3'], 'p4' => $data['p4']));

        }

    }
    public function personel_kesintisi()
    {
        $head['title'] = "Personel Kesintisi";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/personel_kesinti');

        $this->load->view('fixed/footer');
    }

    public function ajax_personel_kesinti()
    {

        if (!$this->aauth->premission(8)) {
            exit('<h3>Üzgünüm. Yetkiniz bulunmamaktadır!</h3>');
        }


        $list=$this->reports->personel_kesintileri();

        $data = array();
        $no = $this->input->post('start');


        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices['payer'];
            $row[] = dateformat($invoices['invoicedate']);
            $row[] = amountFormat($invoices['total']);
            $data[] = $row;



        }


        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->reports->personel_kesintileri_count_filt(),
            "recordsFiltered" => $this->reports->personel_kesintileri_count_filt(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_cari_bakiye()
    {

        if (!$this->aauth->premission(8)) {
            exit('<h3>Üzgünüm. Yetkiniz bulunmamaktadır!</h3>');
        }


        $list=cariler_bakiye_alacak_borc('ekstre',$_POST['search']['value'],$_POST['cust_group']);

        $para_birimi = 1;
        $bakiye_filt=$_POST['bakiye'];
        $data = array();
        $no = $this->input->post('start');


        foreach ($list as $invoices) {


            $bakiye=0;

            $carpim=$invoices['kur_degeri'];
            $no++;
            $row = array();
            $borc=$invoices['borc']*$carpim;
            $alacak=$invoices['alacak']*$carpim;


            $customer_id=$invoices['customer_id'];
            $v_href="customers/statement?para_birimi=tumu&id=$customer_id";

            $bakiye += ($borc-$alacak);


            if($bakiye_filt!='')
            {
                if($bakiye_filt==1)
                {
                    // Alacaklılar
                    if($bakiye<0 || $bakiye==0)
                    {
                        $row[] = $no;
                        $row[] = $invoices['company'];
                        $row[] = amountFormat($alacak,$para_birimi);
                        $row[] = amountFormat($borc,$para_birimi);
                        $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");
                        $row[] = '<a href="' . base_url($v_href) . '" class="btn btn-success btn-xs" title="Cari Görüntüle"><i class="fa fa-eye"></i> </a>';
                        $data[] = $row;
                    }



                }
                else if($bakiye_filt==2)
                {
                    // borçlular
                    if($bakiye>0 || $bakiye==0)
                    {
                        $row[] = $no;
                        $row[] = $invoices['company'];
                        $row[] = amountFormat($alacak,$para_birimi);
                        $row[] = amountFormat($borc,$para_birimi);
                        $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");
                        $row[] = '<a href="' . base_url($v_href) . '" class="btn btn-success btn-xs" title="Cari Görüntüle"><i class="fa fa-eye"></i> </a>';
                        $data[] = $row;
                    }
                }

            }
            else
            {
                $row[] = $no;
                $row[] = $invoices['company'];
                $row[] = amountFormat($alacak,$para_birimi);
                $row[] = amountFormat($borc,$para_birimi);
                $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");
                $row[] = '<a href="' . base_url($v_href) . '" class="btn btn-success btn-xs" title="Cari Görüntüle"><i class="fa fa-eye"></i> </a>';
                $data[] = $row;
            }




        }


        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => cariler_bakiye_alacak_borc('count'),
            "recordsFiltered" => cariler_bakiye_alacak_borc('count'),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function cari_bakiye()
    {
        $head['title'] = "Cari Bakiye Raporu";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/cari_bakiye_reports');

        $this->load->view('fixed/footer');
    }




    public function kdv_raporu()
    {
        $head['title'] = "KDV Raporu";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/kdv_reports');

        $this->load->view('fixed/footer');
    }

    public function ajax_kdv_total()
    {

        if (!$this->aauth->premission(8)) {
            exit('<h3>Üzgünüm. Yetkiniz bulunmamaktadır!</h3>');
        }


        $list=cariler_kdv_total('ekstre',$_POST['search']['value']);

        $para_birimi = 1;
        $data = array();
        $no = $this->input->post('start');


        foreach ($list as $invoices) {
            $bakiye=0;

            $carpim=$invoices['kur_degeri'];
            $no++;
            $row = array();
            $satis_kdv_total=$invoices['satis_faturasi_kdv_total']*$carpim;
            $alis_kdv_total=$invoices['alis_faturasi_kdv_total']*$carpim;


            $customer_id=$invoices['customer_id'];
            $v_href="customers/statement?para_birimi=tumu&id=$customer_id";

            $odenecek_kdv=$satis_kdv_total-$alis_kdv_total;
            if($satis_kdv_total>$alis_kdv_total)
            {
                $kdv_odeme_durumu='(+)';
            }
            else
            {
                $kdv_odeme_durumu='(-)';
            }



            $row[] = $no;
            $row[] = $invoices['company'];
            $row[] = $invoices['description'];
            $row[] = amountFormat($alis_kdv_total,$para_birimi);
            $row[] = amountFormat($satis_kdv_total,$para_birimi);
            $row[] = amountFormat(abs($odenecek_kdv),$para_birimi).' '.$kdv_odeme_durumu;
            $row[] = '<a href="' . base_url($v_href) . '" class="btn btn-success btn-xs" title="Cari Görüntüle"><i class="fa fa-eye"></i> </a>';
            $data[] = $row;


        }


        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => cariler_kdv_total('count'),
            "recordsFiltered" => cariler_kdv_total('count'),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function envanter_raporu()
    {
        $head['title'] = "Envanter Raporu";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/envanter_raporu');

        $this->load->view('fixed/footer');
    }

    public function product_report()
    {
        $head['title'] = "Stok Raporu";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/product_report');

        $this->load->view('fixed/footer');
    }
    public function ajax_envanter_raporu()
    {

        if (!$this->aauth->premission(8)) {
            exit('<h3>Üzgünüm. Yetkiniz bulunmamaktadır!</h3>');
        }


        $list=$this->reports->get_datatables($this->limited);

        $data = array();



        foreach ($list as $invoices) {

            $row = array();

            if ($invoices->product_name!='')
            {
                $row[] = $invoices->product_name;
                $row[] = $invoices->product_code;
                $row[] = units_($invoices->unit)['name'];
                $row[] = $invoices->qty;
                $row[] = amountFormat(son_alis_fiyati($invoices->pid));
                $row[] = amountFormat(ortalama_alis_fiyati($invoices->pid));
                $row[] =amountFormat(son_maliyet_fiyati(son_alis_fiyati($invoices->pid),$invoices->pid));
                $row[] =amountFormat(ortalama_maliyet_fiyati($invoices->pid));
                $row[] =amountFormat(son_satis_fiyati($invoices->pid));
                $data[] = $row;
            }

        }






        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->reports->count_all($this->limited),

            "recordsFiltered" => $this->reports->count_filtered($this->limited),

            "data" => $data,

        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_product_reports()
    {

        if (!$this->aauth->premission(8)) {
            exit('<h3>Üzgünüm. Yetkiniz bulunmamaktadır!</h3>');
        }


        $list=$this->reports->get_datatables_products($this->limited);

        $data = array();



        foreach ($list as $invoices) {

            if($invoices->product_name!=''){
                $row = array();

                $row[] = "<a href='#satinalma_detay' product_id='$invoices->pid' product_name='$invoices->product_name' data-toggle='modal' class='btn btn-info btn-sm satinalma_detay' data-remote='false'>".$invoices->product_name."<a/>";
                $row[] = $invoices->product_code;
                $row[] = units_($invoices->unit)['name'];
                $row[] = stok_ogren($invoices->pid);
                $row[] = $invoices->title;
                $row[] = son_alis_olan_firma($invoices->pid);
                $data[] = $row;
            }
        }






        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->reports->count_all_products($this->limited),

            "recordsFiltered" => $this->reports->count_filtered_products($this->limited),

            "data" => $data,

        );
        //output to json format
        echo json_encode($output);
    }

    public function invoice_depo_urunler()

    {



        $list = $this->invocies->get_datatables_depo_urunler($this->limited);






        $data = array();

        $role_id = $this->aauth->get_user()->roleid;
        $user_id =$this->aauth->get_user()->id;

        $no = $this->input->post('start');

        $this->session->set_userdata('test', 1);


        foreach ($list as $invoices) {

            $malzeme_talep_id=$invoices->id;
            $talep_no=$invoices->talep_no;
            $product_name=$invoices->product_name;
            $firma=$invoices->firma;
            $miktar=$invoices->qty;
            $unit=$invoices->unit;
            $proje_name=$invoices->proje_name;
            $status=$invoices->depo_alim_durumu;

            $status_=depo_urun_status_ogren($status);

            $teslim_alinan_mik=depo_toplam_teslim_qty($malzeme_talep_id);
            $tehvil_id=depo_tehvil_id($malzeme_talep_id);
            $sorumlu_pers=personel_details($invoices->bolum_mudur_id);

            $kalan=$miktar-$teslim_alinan_mik;



            $no++;

            $row = array();
            $m=round($miktar,2);


            $tm='';
            $notes='';
            $kalan_='';
            if($this->input->post('tip')==1) // depo için ekrana
            {
                $tm="<input type='number' class='form-control' id='teslim_alinan_miktar-$malzeme_talep_id' value='0'>";
                $notes="<input type='text' class='form-control' id='note-$malzeme_talep_id' value=''>";
                $kalan_="<a href='#pop_model_depo_bilgi' malzeme_talep_id='$malzeme_talep_id' data-toggle='modal' data-remote='false' class='pop_model_depo_bilgi btn btn-info'>".round($kalan,2).' '.$unit."</a>";
            }
            else if($this->input->post('tip')==2) // tehvil alınanlar
            {
                $tm= "<a href='#pop_model_depo_bilgi' malzeme_talep_id='$malzeme_talep_id' data-toggle='modal' data-remote='false' class='pop_model_depo_bilgi btn btn-info'>".round($teslim_alinan_mik,2).' '.$unit."</a>";
                $notes=depo_notes_ogren($malzeme_talep_id);
                $kalan_=round($kalan,2).' '.$unit;

            }

            $row[] = "<input type='checkbox' class='form-control talep_ids_urun' name='talep_ids_urun[]' value='$malzeme_talep_id'>";
            $row[] = $talep_no;
            $row[] = $proje_name;
            $row[] =  $firma;
            $row[] = $product_name;
            $row[] = round($miktar,2).' '.$unit;
            $row[] = $tm;
            $row[] = $kalan_;
            $row[] = $notes;
            $row[] = $status_;
            $row[] = $sorumlu_pers;
            $row[] = dateformat($invoices->teslim_tarihi_item);
            if($this->input->post('tip')==2) // tehvil alınanlar
            {
                $row[] = $tehvil_id;
            }


            $data[] = $row;

        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->invocies->count_all_depo_urunler($this->limited),

            "recordsFiltered" => $this->invocies->count_filtered_depo_urunler($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }

    public function invoice_depo_dosyalari()

    {



        $list = $this->invocies->get_datatables_depo_dosyalar($this->limited);






        $data = array();

        $role_id = $this->aauth->get_user()->roleid;
        $user_id =$this->aauth->get_user()->id;

        $no = $this->input->post('start');

        $this->session->set_userdata('test', 1);


        foreach ($list as $invoices) {

            $no++;
            $row = array();

            $row[] = $no;
            $row[] = $invoices->tehvil_id;
            $row[] = "<a href='/form/depo_dosya_view?id=".$invoices->tehvil_id."' class='btn btn-info'>Göster</a>";

            $data[] = $row;

        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->invocies->count_all_depo_dosyalar($this->limited),

            "recordsFiltered" => $this->invocies->count_filtered_depo_dosyalar($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }

    public function satinalma_detay(){
        $id = $this->input->post('id');
        $string=$this->input->post('product_name');

        $product=str_replace("'","\'",$string);

        $data_urunler=array();
        $query=$this->db->query("SELECT * FROM `geopos_ihale_items_firma` WHERE product_id=$id");
        if($query->num_rows()>0)
        {
            foreach ($query->result() as $prd)
            {
                if($prd->fiyat>0)
                {
                    $data_urunler[]=array
                    (
                        'firma_adi'=>customer_details($prd->firma_id)['company'],
                        'teklif_tarihi'=>$prd->teklif_tarihi,
                        'tutar'=>amountFormat($prd->fiyat),
                        'price'=>$prd->fiyat,
                        'ihale_id'=>satin_alma_formu_list_ihale($prd->ihale_id)
                    );
                }

            }
        }


        $data['string']=$string;
        $data['urunler']=$data_urunler;
        $data['satin_alma_id']=$id;
        $this->load->view('reports/satinalma_details', $data);

    }

    function talep_details(){
        $talep_id = $this->input->post('talep_id');
        $talep_details = $this->db->query("SELECT * FROM geopos_talep WHERE id =$talep_id")->row();
        $total_cikan= talep_pay_history($talep_id);
        $kalan = floatval($talep_details->total) - floatval($total_cikan);
        if($talep_details->tip == 6){
            $kalan = floatval($talep_details->talep_total) - floatval($total_cikan);
        }



        echo json_encode(array('status' => 'Success', 'item' =>$talep_details,'kalan'=>$kalan));
    }
    function invoices_details(){
        $talep_id = $this->input->post('talep_id');
        $talep_details = $this->db->query("SELECT geopos_invoices.*,geopos_projects.name as proje_name FROM geopos_invoices LEFT JOIN geopos_projects ON geopos_projects.id = geopos_invoices.proje_id WHERE geopos_invoices.id =$talep_id")->row();


        $emir_total=0;
        $odeme_emri_details=$this->db->query("SELECT * FROM `geopos_invoices` WHERE `tid` =$talep_id and invoice_type_id = 42");
        if($odeme_emri_details->num_rows()){
            $emir_total=$odeme_emri_details->row()->total;
        }

        $teminat = 0;
        $ceza_total = 0;
        $prim = 0;
        $odeme_total = 0;
        $kur_degeri=para_birimi_id($talep_details->para_birimi)['rate'];
        $carpim=$kur_degeri;

        foreach (forma_2_pay_history($talep_id) as  $value){
            if($value->invoice_type_id == 55) // Teminat
            {
                $teminat+=$value->total;
            }
            else if($value->invoice_type_id == 54) // Ceza
            {
                $ceza_total+=$value->total;
            }
            else if($value->invoice_type_id == 57) // Prim
            {
                $prim+=$value->total;
            }
            else { // Ödeme
                $odeme_total += $value->total;
            }
        }

        $total_cikan = $odeme_total  +$teminat + $ceza_total;
        $kalan = ($talep_details->total*$carpim)-($total_cikan);
        $talep_details->cari_pers = 2;

        if($emir_total==0){
            $emir_total = $kalan;
        }

        echo json_encode(array('status' => 'Success', 'item' =>$talep_details,'kalan'=>round(floatval($emir_total),2)));
    }

    public function muhasebe_notu_update(){
        $id = $this->input->post('id');
        $invoice_type_tip = $this->input->post('invoice_type_tip');
        $val = $this->input->post('val');


        if($invoice_type_tip==0){

            $update =  $this->db->query("UPDATE `geopos_talep` SET muhasebe_notes='$val' where id = $id");
        }
        else {

            $update =  $this->db->query("UPDATE `geopos_invoices` SET muhasebe_notes='$val' where id = $id");
        }
        if($update){
            echo json_encode([
                'status'  => 'Success',
                'message' => $this->lang->line('UPDATED')
            ]);
        } else {
            echo json_encode([
                'status'  => 'Error',
                'message' => $this->lang->line('ERROR')
            ]);
        }
    }

    public function personel_izin_raporu()
    {
        if (!$this->aauth->premission(70)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/personel_izin_raporu');
        $this->load->view('fixed/footer');
    }
    public function ajax_list_personel_izin_raporu(){
        $list = $this->reports->personel_izin_raporu();
        $data = array();

        $date = new DateTime('now');
        $m= $date->format('m');
        $y= $date->format('Y');
        if($this->input->post('hesap_ay')){
            $m = $this->input->post('hesap_ay');

        }
        if($this->input->post('hesap_yil')){
            $y = $this->input->post('hesap_yil');
        }






        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $month_name  = month_name(intval($prd->month));
            $toplam_gun = 0;
            $toplam_saat = 0;
            $kalan_saat = 0;
            $kalan_dk = 0;
            if($prd->toplam_saat > 8){

                if($prd->toplam_saat==9){
                    $toplam_gun=1;
                }
                else{
                    if($prd->toplam_saat%24){
                        $kalan_saat = $prd->toplam_saat%9;
                        if($kalan_saat > 3){

                            $toplam_gun++;
                            $kalan_saat=0;
                        }
                        else {
                            $saat = $prd->toplam_saat%24;
                            if($saat > 3){

                                $toplam_gun++;
                                $kalan_saat=0;
                            }
                        }
                    }

                    $toplam_gun+= intval($prd->toplam_saat/24);
                }


//                $kalan  =  $prd->toplam_dakika%540;
//                $kalan_dk  =  $kalan%60;
//                $toplam_gun  =  intval($prd->toplam_dakika/540);
//                $toplam_saat  =  intval($kalan/60);
            }
            else {
                $kalan_saat = $prd->toplam_saat;

            }

            if($prd->toplam_dk < 540){
                $kalan_saat  =  intval($prd->toplam_dk/60);
                $kalan_dk  =  $prd->toplam_dk%60;
                if($kalan_saat > 3){
                    $toplam_gun++;
                    $kalan_saat=0;
                }
            }

            $no++;
            $row = array();
            $row[] = $no.' - '.$prd->code;
            $row[] = $prd->name;
            $row[] = $month_name.' - '.$y;
            $row[] = $toplam_gun.' Gün';
            $row[] = $kalan_saat.' Saat '.$kalan_dk.' Dakika';
            $row[] = '';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->reports->count_all_personel_izin_raporu(),
            "recordsFiltered" => $this->reports->count_filtered_personel_izin_raporu(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function gider_talep_report()

    {
        $head['title'] = "Gider Talep Raporu";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/gider_talep_raporu');
        $this->load->view('fixed/footer');

    }

    public function ajax_gider_raporu(){
        $list = $this->reports->gider_raporu();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<a href='/carigidertalep/view/$prd->form_id' class='btn btn-success btn-sm' target='_blank'>$prd->code</a>";
            $row[] = $prd->desc;
            $row[] = (proje_details($prd->proje_id))?proje_details($prd->proje_id)->name:'';
            $row[] = $prd->product_desc;
            $row[] = $prd->product_qty;
            $row[] = units_($prd->unit_id)['name'];
            $row[] = amountFormat($prd->price);
            $row[] = amountFormat($prd->total);
            $row[] = talep_form_status_details($prd->status)->name;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->reports->count_gider(),
            "recordsFiltered" => $this->reports->filtered_gider(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function malzeme_talep_report()

    {
        $head['title'] = "Malzeme Talep Raporu";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/malzeme_talep_raporu');
        $this->load->view('fixed/footer');

    }

    public function ajax_malzeme_raporu(){
        $list = $this->reports->malzeme_raporu();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {


            $price=0;
            $cari_id=0;
            $cari_name='Teklif Onaylanmamış veya Oluşturulmamış';
            $siparis_n_lis_form_details = $this->db->query("SELECT * FROM siparis_list_form_new Where talep_form_product_id=$prd->id");
            if($siparis_n_lis_form_details->num_rows()){
                $price = $siparis_n_lis_form_details->row()->new_item_price;
                $sip_id = $siparis_n_lis_form_details->row()->siparis_liste_form_id;

                if($this->db->query("SELECT * FROM siparis_list_form Where id=$sip_id")->num_rows()){
                    $cari_id = $this->db->query("SELECT * FROM siparis_list_form Where id=$sip_id")->row()->cari_id;

                }

            }

            if($cari_id){
                $cari_name = customer_details($cari_id)['company'];
            }
            $product_name='';

            if($prd->talep_type==1)//malzeme talep
            {
                $product_name = product_details_($prd->product_id)->product_name.'<br>'.talep_form_product_options_teklif_html($prd->id);

            }
            else if($prd->talep_type==2)//malzeme talep
            {
                $product_name = product_details_($prd->product_id)->product_name.'<br>'.talep_form_product_options_teklif_html($prd->id);
            }
            else {
                if($prd->form_id < 3193){
                    $product_name  = cost_details($prd->product_id)->name;
                }
                else {
                    $product_name = who_demirbas($prd->product_id)->name;
                }
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<a href='/malzemetalep/view/$prd->form_id' class='btn btn-success btn-sm' target='_blank'>$prd->code</a>";
            $row[] = $prd->desc;
            $row[] = (proje_details($prd->proje_id))?proje_details($prd->proje_id)->name:'';
            $row[] = $product_name;
            $row[] = $prd->product_qty;
            $row[] = units_($prd->unit_id)['name'];
            $row[] = amountFormat($price);
            $row[] = $cari_name;
            $row[] = talep_form_status_details($prd->status)->name;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->reports->count_malzeme(),
            "recordsFiltered" => $this->reports->filtered_malzeme(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function stok_raporu()
    {
        $head['title'] = "Stok Raporu";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('reports/stok_raporu');

        $this->load->view('fixed/footer');
    }

    public function ajax_list_stok_raporu(){
        $list = $this->reports->ajax_list_stok_raporu();
        $data = array();
        $no = $this->input->post('start');
        $warehouse_id = $this->input->post('warehouse_id');
        $warehose_name='TÜM DEPOLAR';
        if($warehouse_id){
            $warehose_name = warehouse_details($warehouse_id)->title;
        }
        foreach ($list as $prd) {


//            $price=0;
//            $cari_id=0;
//            $cari_name='Teklif Onaylanmamış veya Oluşturulmamış';
//            $siparis_n_lis_form_details = $this->db->query("SELECT * FROM siparis_list_form_new Where talep_form_product_id=$prd->id");
//            if($siparis_n_lis_form_details->num_rows()){
//                $price = $siparis_n_lis_form_details->row()->new_item_price;
//                $sip_id = $siparis_n_lis_form_details->row()->siparis_liste_form_id;
//
//                $cari_id = $this->db->query("SELECT * FROM siparis_list_form Where id=$sip_id")->row()->cari_id;
//
//            }
//
//            if($cari_id){
//                $cari_name = customer_details($cari_id)['company'];
//            }


            $no++;
            $row = array();
            $row[] = $no;
            $row[] =$prd->category_name;
            $row[] =$prd->short_name;
            $row[] =$prd->product_code;
            $row[] =$prd->product_name;
            $row[] =$prd->type_name;
            $row[] =$warehose_name;
            $row[] =stock_qty_new($prd->pid,0,$warehouse_id)['qty'].' '.stock_qty_new($prd->pid,0,$warehouse_id)['unit_name'];
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->reports->count_stok(),
            "recordsFiltered" => $this->reports->filtered_stok(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
}


