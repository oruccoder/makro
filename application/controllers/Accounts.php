<?php
/**
 * İtalic Soft Yazılım  ERP - CRM - HRM
 * Copyright (c) İtalic Soft Yazılım. Tüm Hakları Saklıdır.
 * ***********************************************************************
 *
 *  Email: info@italicsoft.com
 *  Website: https://www.italicsoft.com
 *  Tel: 0850 317 41 44
 *  ******************************************tedtst***************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $selected_db = $this->session->userdata('selected_db');
        if (!empty($selected_db)) {
            $this->db = $this->load->database($selected_db, TRUE);
        }
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

         $this->load->model('accounts_model', 'accounts');
    }



    public function test(){
        print_r($this->aauth->get_user()->loc);
        $date = '2021-11-03 11:08:07';
        $datetime1 = new DateTime();
        $onay_saati_ = new DateTime($date);
        $interval = $datetime1->diff($onay_saati_);
        $elapsed = $interval->format('%a gün %h saat %i dakika Gecikti');
        print_r($datetime1);
    }


    public function index()
    {


        $data['accounts'] = $this->accounts->accountslist();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Hesaplar';
        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/list', $data);
        $this->load->view('fixed/footer');
    }



    public function view()
    {
       
        $acid = $this->input->get('id');
        $data['account'] = $this->accounts->details($acid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Hesap Detayları';
        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/view', $data);
        $this->load->view('fixed/footer');
    }

    public function pers_razi()
    {
        if (!$this->aauth->premission(27)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $acid = $this->input->get('id');
        $data['account'] = $this->accounts->details($acid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Hesap Detayları';
        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/view_razi', $data);
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        if (!$this->aauth->premission(27)->write) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->model('locations_model');
        $data['locations'] = $this->locations_model->locations_list2();
        $head['title'] = 'Yeni Hesap';
        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/add',$data);
        $this->load->view('fixed/footer');
    }

    public function addacc()
    {

        if (!$this->aauth->premission(27)->write) {

            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));
        }

        else {
            $accno = $this->input->post('accno');
            $holder = $this->input->post('holder');
            $acode = $this->input->post('acode');
            $lid = $this->session->userdata('set_firma_id');
            $kasa_tipi = $this->input->post('kasa_tipi');
            $para_birimi = $this->input->post('para_birimi');
            $account_eid = $this->input->post('account_eid');

            if ($accno) {
                $this->accounts->addnew($accno, $holder, $acode,$lid,$kasa_tipi,$para_birimi,$account_eid);

            }
        }

    }

    public function account_details()
    {

        $id=$this->input->get('id');
		if($id==85 || $id==86 ||$id==84 ||$id==91)
		{
			$id_kont=[62,61,21];
			if(in_array($this->aauth->get_user()->id,$id_kont))
			   {
			    	$this->ac_new_list($id);
			   }
			   else{
			     exit('<h3>Giriş Yetkiniz Bulunmamaktadır</h3>');
			   }
		  
		}
			   else{
			   $this->ac_new_list($id);
			   }
        

    }

	public function ac_new_list($id)
			   {
			   $list = $this->accounts->get_datatables_details($id);
        $data = array();
        // $no = $_POST['start'];$id==85 ||
        $bakiye=0;
        $alacak_toplam=0;
        $brc=0;
        $alc=0;
        $borc_toplam=0;
        $total=0;

        $no = $this->input->post('start');
        $d_bakiye=0;
        $d_borc=0;
        $d_alacak=0;
        $devir_bakiye=$this->accounts->devir_bakiye($id);
        //echo amountFormat($devir_bakiye);
        $start = $_POST['start'];
        $i=0;
        foreach ($list as $prd) {
//            if($i==0)
//            {
//                $bakiye+=$devir_bakiye;
//            }



            $image='';
            if(empty($prd->ext))
            {
                if($prd->ext!='default.png')
                {
                    $image='<a target="_blank" href="' . base_url() . 'userfiles/product/' . $prd->ext . '"   class="btn btn-purple btn-sm"><span class="fa fa-file"></span>Dosya</a>
                                <div class="dropdown-divider"></div>&nbsp;';
                }

            }
            $total=$prd->total*$prd->kur_degeri;
            $debit=amountFormat($total,$prd->para_birimi);


            $_borc = 0;
            $_alacak = 0;


            $sql = $this->db->query('SELECT invoice_type_id, SUM(IF(invoice_type_id IN (3,18,20,25,27,51,50,60,44,60,70,72),total,0)) as borc,SUM(IF(invoice_type_id IN (4,12,14,17,19,28,33,35,36,37,38,39,40,41,42,45,46,47,48,49,52,43,59,61,68,73),total,0)) as alacak From geopos_invoices Where geopos_invoices.acid = '.$id.' and   geopos_invoices.invoicedate <= "'.$prd->invoicedate.'"')->row();

            $type =[3,18,20,25,27,51,50,60,44,70,72];

            if( in_array($sql->invoice_type_id,$type)) // BORÇ
            {
                $_borc = $sql->alacak-floatval($sql->borc);
                $_alacak=0;
            }
            else {
                $_alacak = $sql->borc-floatval($sql->alacak);
                $_borc=0;
            }

            $bakiye = $_alacak-$_borc;


            if( in_array($prd->invoice_type_id,$type)) // BORÇ
            {

                $borc=$debit;
                $borc_toplam += $total;
                $brc = $total;
                $alc = 0;
                $alacak=amountFormat(0,$prd->para_birimi);

            }
            else
            {
                $alacak=$debit;
                $alacak_toplam += $total;
                $alc = $total;
                $brc = 0;
                $borc=amountFormat(0,$prd->para_birimi);

            }

            //$bakiye += ($brc-$alc);




            $desc ='';
            if($prd->invoice_type_id==17){
                $trans_details = $this->db->query("SELECT * FROM geopos_invoice_transactions Where transaction_id = $prd->id");
                if($trans_details->num_rows()){
                    $inv_id_ = $trans_details->row()->invoice_id;
                    if($inv_id_){
                        if($this->db->query("SELECT * FROM geopos_invoices Where id =$inv_id_")->num_rows()>0){
                            $desc.= $this->db->query("SELECT * FROM geopos_invoices Where id = $inv_id_")->row()->notes;
                        }
                    }

                }


            }
            if($prd->invoice_type_id==14){
                $desc.= $prd->payer;
            }

            $price=$debit;

            $payer = ($prd->payer)?$prd->payer:masraf_name($prd->masraf_id);
            $pid = $prd->trns_id;
            $html ='<div class="btn-group">
                        <button type="button" class="btn btn btn-primary dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i>  </button>
                        <div class="dropdown-menu">&nbsp;'.$image.'
                             
                                 <button type="button" data-object-id="' . $pid . '" price="'.$price.'" class="btn btn-success btn-sm price_update"><span class="fa fa-retweet"></span>Tutar Güncelle</button>
                                <div class="dropdown-divider"></div>&nbsp;
                                <a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-success btn-sm  view-object"> <span class="icon-eye"></span>Görüntüle</a>
                                <div class="dropdown-divider"></div>&nbsp;
                                 <a href="' . base_url() . 'transactions/print_t?id=' . $pid . '" class="btn btn-success btn-sm"> <span class="fa fa-print"></span>Yazdır</a>


                        </div>
                </div>';

            $no++;

            $row = array();


            $talep =  invoice_to_talep($prd->id,0);

            if($prd->invoice_type_desc=="Avans Banka Personel"){
                $desc.=$this->db->query("SELECT * FROM geopos_employees Where name LIKE '%".$payer."%'")->row()->firma_durumu;
            }
            $href=$payer;
            if($prd->invoice_type_desc == 'Personel Razı'){
                $href = '<a target="_blank" class="btn btn-success" href="/employee/view?id='.$prd->csd.'">'.$payer.'</a>';
            }
            $row[] = dateformat($prd->invoicedate);

            $row[] = $prd->account;
            $row[] = $href;
            $row[] = $borc;
            $row[] = $alacak;
            $row[] = amountFormat(abs($bakiye),$prd->para_birimi).($bakiye>0?" (B)":" (A)");
            $row[] = account_type_sorgu($prd->method);
            $row[] = $prd->invoice_type_desc;
            $row[] = personel_details($prd->eid);
            $row[] = $prd->notes.' '.$desc;
            $row[] = ($talep)?$talep:'';
            $row[]= $html;

            $data[] = $row;

            $i++;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->accounts->count_all($id),

            "recordsFiltered" => $this->accounts->count_filtered($id),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);
			   }

    public function account_details_razi()
    {
        $id=$this->input->get('id');
        $list = $this->accounts->get_datatables_details_razi($id);


        $data = array();

        $i=0;
        foreach ($list as $prd) {
            if($prd->invoice_type_desc=="Avans Banka Personel"){
                $row = array();
                $row[] = dateformat($prd->invoicedate);
                $row[] = $prd->account;
                $row[] = $prd->payer;
                $row[] = $prd->total;
                $row[] = account_type_sorgu($prd->method);
                $row[] = $prd->invoice_type_desc;
                $row[] = personel_details($prd->eid);
                $row[] = $prd->notes;
                $data[] = $row;

                $i++;
            }



        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->accounts->count_all_razi($id),

            "recordsFiltered" => $this->accounts->count_filtered_razi($id),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);

    }

    public function delete_i()
    {
        if (!$this->aauth->premission(27)->delete) {

            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $id = $this->input->post('deleteid');
            if ($id) {
                $whr=  array('id' => $id);
                if ($this->aauth->get_user()->loc) {
                    $whr= array('id' => $id,'loc'=>$this->aauth->get_user()->loc);
                }
                $this->db->delete('geopos_accounts',$whr);
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ACC_DELETED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        }

    }

//view for edit
    public function edit()
    {
        if (!$this->aauth->premission(27)->update) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $catid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('geopos_accounts');
        $this->db->where('id', $catid);
        $query = $this->db->get();
        $data['account'] = $query->row_array();
$this->load->model('locations_model');
        $data['locations'] = $this->locations_model->locations_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Edit Account';

        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/edit', $data);
        $this->load->view('fixed/footer');

    }

    public function editacc()
    {
        if ($this->aauth->get_user()->id != 21) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
            return;
        }

            $acid = $this->input->post('acid');
            $accno = $this->input->post('accno');
            $holder = $this->input->post('holder');
            $para_birimi = $this->input->post('para_birimi');
            $acode = $this->input->post('acode');
            $lid = $this->session->userdata('set_firma_id');
            $kasa_tipi = $this->input->post('kasa_tipi');
            $account_eid = $this->input->post('account_eid');

            if ($acid) {
                $this->accounts->edit($acid, $accno, $holder, $acode,$lid,$kasa_tipi,$para_birimi,$account_eid);
            }

    }

    public function balancesheet()
    {


        $head['title'] = "Balance Summary";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['accounts'] = $this->accounts->accountslist();

        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/balance', $data);
        $this->load->view('fixed/footer');

    }

    public function account_stats()
    {

        $this->accounts->account_stats();


    }

    public function gunun_ozeti()
    {
        if (!$this->aauth->premission(29)->read) {
            exit('<h3>Giriş Yetkiniz Bulunmamaktadır</h3>');
        }

        $head['title'] = "Günün Özeti";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['accounts'] = $this->accounts->accountslist();

        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/gunun_ozeti', $data);
        $this->load->view('fixed/footer');

    }

    public function kasalar()
    {

        $method = $this->input->post('method');
        $list = pay_type_next_process(1,0,0,$method);
        echo json_encode(array('status' => 'Success', 'item' => $list));
    }

    public function gunun_ozeti_data()
    {
        $no = $this->input->post('start');

        $tip=['Alış Faturaları','Satış Faturaları','Siparişler','Teklifler','Kasalar','KDV'];
        foreach ($tip as $key=>$value)
        {
            $devir = ozet_devir($key,'devir')['total'];
            $bakiye = ozet_devir($key,'bakiye')['total'];
            $row = array();
            $row[] = $value;


            if($key==0) //alış
            {
                $row[] = amountFormat($devir);
                $row[] =amountFormat($bakiye); //çıkan
                $row[] =amountFormat(0); //giren
                $row[] =amountFormat($bakiye+$devir).' (A)';
            }
            else if($key==1) //satış
            {

                $row[] = amountFormat($devir);
                $row[] =amountFormat(0);
                $row[] =amountFormat($bakiye);
                $row[] =amountFormat($bakiye+$devir).' (B)';
            }

            else if($key==2) //sipariş
            {

                $row[] = amountFormat($devir);
                $row[] =amountFormat(0);
                $row[] =amountFormat($bakiye);
                $row[] =amountFormat($bakiye+$devir).' (B)';
            }
            else if($key==3) //teklif
            {
                $row[] = amountFormat($devir);

                $row[] =amountFormat(0);
                $row[] =amountFormat($bakiye);
                $row[] =amountFormat($bakiye+$devir).' (B)';
            }

            else if($key==4) //kasa
            {


                $giren=ozet_devir($key,'bakiye')['alacak'];
                $cikan=ozet_devir($key,'bakiye')['borc'];
                $bakiyes=($devir+$giren)-$cikan;

                if($bakiyes<0)
                {
                    $bakiyess=amountFormat(abs($bakiyes)).' (A)';
                }
                else
                {
                    $bakiyess=amountFormat(abs($bakiyes)).' (B)';
                }

                $row[] = amountFormat($devir);
                $row[] = amountFormat(ozet_devir($key,'bakiye')['alacak']);
                $row[] =amountFormat(ozet_devir($key,'bakiye')['borc']);
                $row[] =$bakiyess;
            }
            else if($key==5) //kdv
            {
                if($devir<0)
                {
                    $devirs=amountFormat(abs($devir)).' (A)';
                }
                else
                    {
                        $devirs=amountFormat(abs($devir)).' (B)';
                    }

                    $bakiye_kdv=$devir+ozet_devir($key,'bakiye')['satis_kdv_total'] + ozet_devir($key,'bakiye')['alis_kdv_total']- ozet_devir($key,'bakiye')['satis_kdv_total'];

                if($bakiye_kdv<0)
                {
                    $bakiye_kdvs=amountFormat(abs($bakiye_kdv)).' (A)';
                }
                else
                {
                    $bakiye_kdvs=amountFormat(abs($bakiye_kdv)).' (B)';
                }


                $row[] = $devirs;
                $row[] = amountFormat(ozet_devir($key,'bakiye')['alis_kdv_total']);
                $row[] = amountFormat(ozet_devir($key,'bakiye')['satis_kdv_total']);;
                $row[] =$bakiye_kdvs;;
            }





            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => count(account_type()),
            "recordsFiltered" => 0,
            "data" => $data,
        );
        echo json_encode($output);



    }

    public function price_update(){

        if (!$this->aauth->premission(27)->update) {

            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $price = $this->input->post('price');
            $invoice_id = $this->input->post('invoice_id');
            $old_tutar = $this->db->query("SELECT * FROM geopos_invoices where  id =$invoice_id")->row()->total;

            if($this->db->query("UPDATE geopos_invoices set total = $price  WHERE  id = $invoice_id")){


                $this->db->query("UPDATE geopos_invoice_transactions set total = $price  WHERE  transaction_id = $invoice_id");

                echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Güncellenmiştir.'));
                $this->aauth->applog("Tutar Değiştirildi Yeni Tutar  $price Old Tutar $old_tutar ISLEM ID $invoice_id",$this->aauth->get_user()->username);
                exit();
            }
            else {

                echo json_encode(array('status' => 'Error', 'message' =>'Hata Aldınız Lütfen Yöneticiye Başvurun.'));
            }

        }


    }

    public function proje_update_transaction(){

        if (!$this->aauth->premission(27)->update) {

            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $proje_id = $this->input->post('proje_id');
            $invoice_id = $this->input->post('invoice_id');
            $old_proje_id = $this->db->query("SELECT * FROM geopos_invoices where  id =$invoice_id")->row()->proje_id;

            if($this->db->query("UPDATE geopos_invoices set proje_id = $proje_id  WHERE  id = $invoice_id")){
                echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Güncellenmiştir.'));
                $this->aauth->applog("Tutar Değiştirildi Yeni Proje ID  $proje_id Old Proje ID $old_proje_id ISLEM ID $invoice_id",$this->aauth->get_user()->username);
                exit();
            }
            else {

                echo json_encode(array('status' => 'Error', 'message' =>'Hata Aldınız Lütfen Yöneticiye Başvurun.'));
            }

        }


    }


}
