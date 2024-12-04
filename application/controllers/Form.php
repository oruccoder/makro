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

class Form Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
		$this->load->database('default');
        $this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model');
        $this->load->model('invoices_model');
        $this->load->model("requested_model", 'requested');
        $this->load->model('communication_model');
        $this->load->model('ihale_model', 'ihale');
        $this->load->model('onay_model', 'onay');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }




        if ($this->aauth->get_user()->roleid == 2) {

            $this->limited = $this->aauth->get_user()->id;

        } else {

            $this->limited = '';

        }

        $this->load->model("requested_model",'requested');
        $this->load->model('form_model', 'form');
    }

    public function forma2kontrol(){


        $result=$this->db->query("SELECT id,subtotal,tax,total FROM `geopos_invoices` WHERE status!=3 and `invoice_type_id` IN (29,30) and taxstatus='no'  ORDER BY `id` DESC
")->result();
        foreach ($result as $item){
            $sub_total = $this->db->query("SELECT SUM(subtotal) as sub_total FROM geopos_invoice_items Where tid=$item->id")->row()->sub_total;
            if(round($sub_total,2) !=round($item->subtotal,2)){
                echo $item->id.'<br>';
            }
        }

    }

    public function ofis_depo_form()
    {

        $data='';
        ini_set('memory_limit', '64M');
        $html = $this->load->view('form/ofis_depo_form', $data, true);
        $header = '';
        $this->load->library('pdf');
        $pdf = $this->pdf->load_split();
        $pdf->SetHTMLHeader($header);
        $pdf->SetHTMLFooter('');
        $pdf->AddPage(
            '', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            10, // margin top
            '', // margin bottom
            0,50,0,0, // margin header
            ''); // margin footer
        $pdf->WriteHTML($html);
        $file_name = 'ofis_depo_form';
        $pdf->Output($file_name . '.pdf', 'I');
    }

    public function santiye_form()
    {

        $data='';
        ini_set('memory_limit', '64M');
        $html = $this->load->view('form/santiye_form', $data, true);
        $header = '';
        $this->load->library('pdf');
        $pdf = $this->pdf->load_split();
        $pdf->SetHTMLHeader($header);
        $pdf->SetHTMLFooter('');
        $pdf->AddPage(
            '', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            10, // margin top
            '', // margin bottom
            0,50,0,0, // margin header
            ''); // margin footer
        $pdf->WriteHTML($html);
        $file_name = 'santiye_form';
        $pdf->Output($file_name . '.pdf', 'I');
    }

    public function ise_gec_gelme_ihtar_form()
    {
        $data='';
        ini_set('memory_limit', '64M');
        $html = $this->load->view('form/ise_gec_gelme_ihtar_form', $data, true);
        $header = '';
        $this->load->library('pdf');
        $pdf = $this->pdf->load_split();
        $pdf->SetHTMLHeader($header);
        $pdf->SetHTMLFooter('');

        $pdf->AddPage(
            '', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            10, // margin top
            '', // margin bottom
            0,50,0,0, // margin header
            ''); // margin footer

        $pdf->WriteHTML($html);
        $file_name = 'ise_gec_gelme_ihtar_form';
        $pdf->Output($file_name . '.pdf', 'I');
    }

    public function ise_gec_gelme_tutanak_form()
    {

        $data='';
        ini_set('memory_limit', '64M');
        $html = $this->load->view('form/ise_gec_gelme_tutanak_form', $data, true);
        $header = '';
        $this->load->library('pdf');
        $pdf = $this->pdf->load_split();
        $pdf->SetHTMLHeader($header);
        $pdf->SetHTMLFooter('');
        $pdf->AddPage(
            '', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            10, // margin top
            '', // margin bottom
            0,50,0,0, // margin header
            ''); // margin footer
        $pdf->WriteHTML($html);
        $file_name = 'ise_gec_gelme_tutanak_form';
        $pdf->Output($file_name . '.pdf', 'I');
    }

    public function malzeme_talep_list()
    {
        $head['title'] = "Malzeme Talep Listesi";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('form/malzeme_talep_list');

        $this->load->view('fixed/footer');
    }
    public function gider_talebi_list($status='')
    {
        $head['title'] = "Gider Talep Listesi";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('form/gider_talebi_list');

        $this->load->view('fixed/footer');
    }
    public function avans_talebi_list($status='')
    {
        $head['title'] = "Avans Talep Listesi";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('form/avans_talebi_list');

        $this->load->view('fixed/footer');
    }

    public function avans_edit()
    {
        $tid = intval($this->input->get('id'));


        $sayi=0;
        $query=$this->db->query('Select * From geopos_onay where  file_id='.$tid)->result();

        foreach ($query as $q)
        {
            if($q->proje_sorumlusu_status!=1)
            {
                $sayi=1;
            }
            if($q->proje_muduru_status!=1)
            {
                $sayi=1;
            }

            if($q->genel_mudur_status!=1)
            {
                $sayi=1;
            }
        }
        $status=$this->db->query('Select * From geopos_talep where id='.$tid)->row()->status;
        if($status==4){
            exit('<h3>Sayın kullanıcıcı Bu form işlem iptal Edildimiştir.Bu sebep ile güncelleme yapamazsınız!</h3>');
        }
        if($sayi==1)
        {
            exit('<h3>Sayın kullanıcıcı Bu form işlem görmüştür.Bu sebep ile güncelleme yapamazsınız!</h3>');
        }

        $data['id'] = $tid;

        $data['invoice'] = $this->requested->invoice_details($tid, $this->limited);

        $invoice_no = $data['invoice']['talep_no'];


        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
        $data['taxdetails'] = $this->common->taxdetail();


        $head['title'] = "Talep Düzenle #" . $invoice_no;

        if ($data['invoice']) $data['products'] = $this->requested->invoice_products($tid);


        $head['title'] = "Talep Düzenle #" . $invoice_no;

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        if ($data['invoice']) $this->load->view('form/avans_edit', $data);

        $this->load->view('fixed/footer');
    }

    public function gider_edit()

    {


        $tid = intval($this->input->get('id'));

        $sayi=0;
        $query=$this->db->query('Select * From geopos_onay where  file_id='.$tid)->result();

        foreach ($query as $q)
        {
            if($q->proje_sorumlusu_status!=1)
            {
                $sayi=1;
            }
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

        $data['id'] = $tid;

        $data['invoice'] = $this->requested->invoice_details($tid, $this->limited);

        $invoice_no = $data['invoice']['talep_no'];


        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));
        $data['taxdetails'] = $this->common->taxdetail();


        $head['title'] = "Talep Düzenle #" . $invoice_no;

        if ($data['invoice']) $data['products'] = $this->requested->invoice_products($tid);


        $head['title'] = "Talep Düzenle #" . $invoice_no;

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        if ($data['invoice']) $this->load->view('form/gider_edit', $data);

        $this->load->view('fixed/footer');


    }



    public function malzeme_ajax_list()

    {


        $button='';

        $list = $this->requested->get_datatables($this->limited);


        $data = array();



        $no = $this->input->post('start');
        $tip = $this->input->post('tip');

        $this->session->set_userdata('test', 1);


        foreach ($list as $invoices) {

            $no++;
            $total=0;

            $notes='Not : '.$invoices->description;
            $tool="data-toggle='tooltip' data-placement='top' data-html='true' title='$notes'";

            $p_href=base_url("projects/explore?id=$invoices->proje_id");
            if($tip==1)

            {
                $button='<a href="' . base_url("requested/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("requested/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="İndir"><span class="fa fa-download"></span></a>';


                $href=base_url("form/malzeme_hareket_listesi?id=$invoices->id");
            }
            else if($tip==2)
            {
                $button='<a href="' . base_url("form/satinalma_view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("requested/satin_alma_printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="İndir"><span class="fa fa-download"></span></a>';

                $href='';
            }

            else if($tip==3)
            {
                $button='<a href="' . base_url("form/satinalma_emri_view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("requested/satin_alma_printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="İndir"><span class="fa fa-download"></span></a> ';

                $href='';
            }
            else if($tip==4)
            {
                $odeme_button='';
                if($invoices->status == 7) {
                    $odeme_button ='&nbsp<a href="#pop_modal_transaction" data-id="'.$invoices->id.'" data-toggle="modal"  data-remote="false" class="odeme_button btn btn-info btn-sm"><span class="fa fa-money"></span></a>';
                }
                $button='<a href="' . base_url("form/gider_view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a> '.$odeme_button;



                $href=base_url("form/gider_view?id=$invoices->id");
                $total=$invoices->total;

            }
            else if($tip==5)
            {
                $odeme_button='';
                if($invoices->status == 7) {
                    $odeme_button ='&nbsp<a href="#pop_modal_transaction" data-id="'.$invoices->id.'" data-toggle="modal"  data-remote="false" class="odeme_button btn btn-info btn-sm"><span class="fa fa-money"></span></a>';
                }
                $button='<a href="' . base_url("form/avans_view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>'.$odeme_button;

                $href=base_url("form/avans_view?id=$invoices->id");
                $total=$invoices->total;

            }
            $row = array();

            //$row[] = $no;
            $row[] = "<a href='".$href."'>".dateformat($invoices->olusturma_tarihi).'</a>';

            $row[] = "<a href='".$href."'>".dateformat($invoices->onay_tarihi).'</a>';;

            $row[] = "<a href='".$href."'>"."<span data-toggle='tooltip' data-placement='top' data-html='true' title='".$notes."'>".$invoices->talep_no."</span>".'</a>';

            $row[] = "<a href='".$p_href."'>".$invoices->proje_name.'</a>';;



            if($tip==4)
            {
                $row[] = amountFormat($invoices->total,1);
            }
            if($tip==5)
            {
                $row[] = amountFormat($invoices->total,1);
            }


            $row[] = purchase_status($invoices->status);

            $row[] = personel_details_full($invoices->talep_olusturan_pers_id)['name'];;

            if($tip==1)
            {
                $satin_alma_formu=satin_alma_formu_list($invoices->id);
                $row[] = $satin_alma_formu;
            }

            if($tip==2)
            {
                $fir='';
                $firmas = $this->db->query("Select geopos_talep_items.firma From geopos_onay INNER JOIN geopos_talep_items ON geopos_onay.malzeme_items_id=geopos_talep_items.id where geopos_onay.file_id=$invoices->id and geopos_onay.genel_mudur_status=3 GROUP BY geopos_talep_items.firma
")->result();
                foreach ($firmas as $f)
                {
                    $fir.=$f->firma.'-';
                }
                $row[] = $fir;
            }


            $row[] = $button;






            $data[] = $row;

        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->requested->count_all($this->limited,$this->input->post('tip')),

            "recordsFiltered" => $this->requested->count_filtered($this->limited,$this->input->post('tip')),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }

    public function giderprintinvoice()

    {

        $tid = $this->input->get('id');

        $data['id'] = $tid;


        $data['invoice'] = $this->requested->invoice_details($tid, $this->limited);

        if ($data['invoice']) $data['products'] = $this->requested->invoice_products($tid);


        ini_set('memory_limit', '64M');


        $html = $this->load->view('form/view-print-gider-' . LTR, $data, true);
        $header = $this->load->view('form/header-print-gider-' . LTR, $data, true);
        $footer = $this->load->view('form/footer-print-gider-' . LTR, $data, true);

        //PDF Rendering

        $this->load->library('pdf');


        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter($footer);
        $pdf->AddPage(
            'P', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            69, // margin top
            '72', // margin bottom
            5, 2, 0, 0, // margin header
            'auto'); // margin footer

        $pdf->WriteHTML($html);


        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'Talep__' . $data['invoice']['name'] . '_' . $data['invoice']['id']);

        if ($this->input->get('d')) {


            $pdf->Output($file_name . '.pdf', 'D');

        } else {

            $pdf->Output($file_name . '.pdf', 'I');

        }


    }

    public function gider_view()

    {
        $data=array();
        $tid = $this->input->get('id');
        $data['invoice'] = $this->requested->invoice_details($tid, $this->limited);
        $head['title'] = "Talep No " . $tid;
        $data['invoice']['para_birimi'] = 1;
        $data['products'] = $this->requested->invoice_products($tid);
        $this->load->view('fixed/header',$head);
        $this->load->view('form/gider-view', $data);
        $this->load->view('fixed/footer');
    }

    public function avans_view()

    {
        $data=array();
        $tid = $this->input->get('id');
        $data['invoice'] = $this->requested->invoice_details($tid, $this->limited);
        $head['title'] = "Talep No " . $tid;
        $data['invoice']['para_birimi'] = 1;
        $data['products'] = $this->requested->invoice_products($tid);

        $data['attach'] = $this->requested->avans_attach($tid);
        $this->load->view('fixed/header',$head);
        $this->load->view('form/avans_view', $data);
        $this->load->view('fixed/footer');
    }

    public function satinalma_view()

    {
        $tid = $this->input->get('id');
        $data['invoice'] = $this->requested->invoice_details($tid, $this->limited);
        $head['title'] = "Talep No " . $tid;
        $data['products'] = $this->requested->invoice_products_satinalma($tid);
        $data['firmalar'] = $this->requested->invoice_products_satinalma_firmalar($tid);
        $data['discount']=false;
        foreach ($data['firmalar'] as $firmalar){
            $firma_id = $firmalar->firma_id;
            $details = $this->db->query("SELECT * FROM talep_to_discount Where firma_id =$firma_id and talep_id = $tid");
            if($details->num_rows()){
                $data['discount'][]=['firma_id'=>$firma_id,'dis'=>$details->row()->discount];
            }


        }

        $this->load->view('fixed/header', $head);
        $this->load->view('form/satinalma_view', $data);
        $this->load->view('fixed/footer');
    }


	public function discount_create(){
		$talep_id = $this->input->post('sf_id');
		$firma    = $this->input->post('firma');
		$discount = $this->input->post('discount');
		if($this->db->query('SELECT count(`id`) as count FROM `talep_to_discount` WHERE `talep_id` = '.$talep_id.' AND `firma_id` = '.$firma.';')->row()->count > 0){
			exit(json_encode([
				'code' => 410,
				'error' => 'Bu tələbə endrim tədbiq edilib'
			]));
		}

		$insert = $this->db->query('INSERT INTO `talep_to_discount` SET
			`manager_id` = '.$this->aauth->get_user()->id.',
			`talep_id` = '.$talep_id.',
			`firma_id` = '.$firma.',
			`discount` = '.$discount.',
			`description` = \'Bu endirim '.$this->aauth->get_user()->username.' tərəfindən sistemə daxil edilmişdir\'
		;');

		if($insert){
			exit(json_encode([
				'code' => 200
			]));
		} else {
			exit(json_encode([
				'code' => 410,
				'error' => 'Məlumat bazasına qoşulma zamanı xəta baş vermişdir İT şöbəsinə bildirməyiniz xahiş olunur',
			]));
		}
	}


    public function satinalma_emri_view()

    {
        $tid = $this->input->get('id');
        $data['invoice'] = $this->requested->invoice_details($tid, $this->limited);
        $head['title'] = "Talep No " . $data['invoice']['id'];
        $data['invoice']['para_birimi'] = 1;
        $data['products'] = $this->requested->invoice_products($tid);
        $this->load->view('fixed/header', $head);
        $this->load->view('form/satinalma_emri_view', $data);
        $this->load->view('fixed/footer');
    }

    public function malzeme_talep_create()
    {
        $role_id = $this->aauth->get_user()->roleid;
        if ($role_id==8) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $data['exchange'] = $this->plugins_model->universal_api(5);
        $data['currency'] = $this->invoices_model->currencies();
        $data['terms'] = $this->invoices_model->billingterms();

        $this->session->mark_as_temp('para_birimi', 3);

        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['taxdetails'] = $this->common->taxdetail();


        $data['units'] = $this->requested->units();

        $this->load->view('fixed/header',$head);
        $this->load->view('form/malzeme_talep_create',$data);
        $this->load->view('fixed/footer');
    }

    public function gider_talebi()
    {
        $data['exchange'] = $this->plugins_model->universal_api(5);
        $data['currency'] = $this->invoices_model->currencies();
        $data['terms'] = $this->invoices_model->billingterms();

        $this->session->mark_as_temp('para_birimi', 3);

        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = "Gider Talebi";
        $data['taxdetails'] = $this->common->taxdetail();


        $data['units'] = $this->requested->units();

        $this->load->view('fixed/header',$head);
        $this->load->view('form/gider_talebi_create',$data);
        $this->load->view('fixed/footer');
    }
    public function avans_talebi()
    {
        $data['exchange'] = $this->plugins_model->universal_api(5);
        $data['currency'] = $this->invoices_model->currencies();
        $data['terms'] = $this->invoices_model->billingterms();

        $this->session->mark_as_temp('para_birimi', 3);

        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = "Avans Talebi";

        $data['taxdetails'] = $this->common->taxdetail();


        $data['units'] = $this->requested->units();

        $this->load->view('fixed/header',$head);
        $this->load->view('form/avans_talebi_create',$data);
        $this->load->view('fixed/footer');
    }

    public function satinalma_formu_list()
    {
        $head['title'] = "Satın Alma Formları Listesi";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('form/satinalma_formu_list');

        $this->load->view('fixed/footer');
    }

    public function satinalma_emri_list()
    {
        $head['title'] = "Satın Emri Listesi";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('form/satinalma_emri_list');

        $this->load->view('fixed/footer');
    }
    public function satinalma_formu_create()
    {
        $data['exchange'] = $this->plugins_model->universal_api(5);
        $data['currency'] = $this->invoices_model->currencies();
        $data['terms'] = $this->invoices_model->billingterms();

        $this->session->mark_as_temp('para_birimi', 3);

        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['taxdetails'] = $this->common->taxdetail();


        $data['units'] = $this->requested->units();

        $this->load->view('fixed/header');
        $this->load->view('form/satinalma_formu_create',$data);
        $this->load->view('fixed/footer');
    }

    public function satinalma_emri_create()
    {
        $data['exchange'] = $this->plugins_model->universal_api(5);
        $data['currency'] = $this->invoices_model->currencies();
        $data['terms'] = $this->invoices_model->billingterms();

        $this->session->mark_as_temp('para_birimi', 3);

        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['taxdetails'] = $this->common->taxdetail();


        $data['units'] = $this->requested->units();

        $this->load->view('fixed/header');
        $this->load->view('form/satinalma_emri_create',$data);
        $this->load->view('fixed/footer');
    }

    public function edit_action_gider()
    {


        $talep_id=$this->input->post('talep_id', true);
        $currency = 1;
        $st=0; //Muhasebe ürünleri
        $proje_id = $this->input->post('proje_id', true);
        $proje_name = proje_name($proje_id);
        $olusturma_tarihi = $this->input->post('olusturma_tarihi', true);
        $talep_eden_pers_id = $this->input->post('talep_eden_pers_id', true);
        $proje_sorumlusu_id = $this->input->post('proje_sorumlusu_id');
        $proje_muduru_id = $this->input->post('proje_muduru_id');
        $bolum_mudur_id = $this->input->post('bolum_mudur_id');
        $finans_mudur_id = $this->input->post('finans_mudur_id');
        $genel_mudur_id = $this->input->post('genel_mudur_id', true);
        $tel = $this->input->post('tel', true);
        $description = $this->input->post('description', true);
        $bolum_adi = $this->input->post('bolum_adi', true);
        $subtotal = $this->input->post('subtotal', true); // Ara Toplam
        $proje_bolum_id = $this->input->post('proje_bolum_id', true); // Ara Toplam
        $tax = 0; //toplam kdv
        $discount = 0; //toplam indirim
        $nettotalinp = $this->input->post('nettotalinp', true); // Net toplam
        $total = $this->input->post('total'); //Genel Toplam
        $method = $this->input->post('method'); //Genel Toplam
        $olus_t = datefordatabase($olusturma_tarihi);

        $transok = true;

        $st_c = 0;

        $this->db->trans_start();

        $data = array(
            'proje_name' => $proje_name,
            'olusturma_tarihi' => $olus_t,
            'method' => $method,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'nettotal' => $nettotalinp,
            'total' => $total,
            'tel' => $tel,
            'description' => $description,
            'talep_eden_pers_id' => $talep_eden_pers_id,
            'bolum_mudur_id' => $bolum_mudur_id,
            'talep_olusturan_pers_id' => $this->aauth->get_user()->id,
            'proje_sorumlusu_id' => $proje_sorumlusu_id,
            'proje_muduru_id' => $proje_muduru_id,
            'genel_mudur_id' => $genel_mudur_id,
            'finans_departman_pers_id' => $finans_mudur_id,
            'bolum_adi' => $bolum_adi,
            'proje_id' => $proje_id,
            'stok_durumu' => $st,
            'tip' => 4,
            'proje_bolum_id' => $proje_bolum_id,
            'proje_bolum_name' => $this->db->query("SELECT * FROM geopos_project_bolum Where id =$proje_bolum_id")->row()->name,
            'loc' => $this->aauth->get_user()->loc);

        $this->db->set($data);

        $this->db->where('id', $talep_id);

        if ($this->db->update('geopos_talep', $data)) {

            $this->aauth->applog("Gider Talep Formu Düzenlendi $talep_id ID ".$talep_id,$this->aauth->get_user()->username,$talep_id);
            kont_kayit(26,$talep_id);

            $this->db->delete('geopos_talep_items', array('tip' => $talep_id));

            $this->db->delete('geopos_onay', array('file_id' => $talep_id,'type'=>4));

            $productlist = array();
            $data_items = array();
            $prodindex = 0;
            $itc = 0;
            $total_tax = 0;
            $total_discount = 0;

            $product_name = $this->input->post('product_name');


            foreach ($product_name as $key => $value) {
                $product_name = $this->input->post('product_name');
                $unit = $this->input->post('unit');

                $product_qty = $this->input->post('product_qty');
                $product_id = $this->input->post('pid');

                $product_price = $this->input->post('product_price');
                $product_subtotal = $this->input->post('product_subtotal');
                $product_detail = $this->input->post('product_detail');

                $data_items = array(

                    'tip' => $talep_id,

                    'product_name' => $product_name[$key],

                    'product_detail' => $product_detail[$key],

                    'product_id' => $product_id[$key],

                    'qty' => $product_qty[$key],

                    'price' => $product_price[$key],

                    'tax' => 0,

                    'discount' => 0,

                    'subtotal' => $product_subtotal[$key],

                    'totaltax' => 0,

                    'totaldiscount' => 0,

                    'unit' => $unit[$key]
                );
                $productlist[$prodindex] = $data_items;

                $this->db->insert('geopos_talep_items', $data_items);

                $malzeme_items_id = $this->db->insert_id();

                $data_o= array(
                    'product_id' => $product_id[$key],
                    'file_id' => $talep_id,
                    'malzeme_items_id' => $malzeme_items_id,
                    'type' => 4);

                $this->db->insert('geopos_onay', $data_o);

                $prodindex++;

            }

            if ($prodindex > 0) {








            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "Lütfen ürün listesinden ürün seçin. Ürünleri eklemediyseniz, Ürün yöneticisi bölümüne gidin."));

                $transok = false;

            }

            if ($transok) {

                // Mail Gönderme



                /* $subject = 'Gider Talep Formu Onayı';

                 $message = 'Sayın Yetkili ' . $talep_no . ' Numaralı Gider Talep Formu Oluşturuldu. Onay İşleminiz Beklenmektedir.';
                 $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
                 $firma_kodu=$dbnames['firma_kodu'];
                 $validtoken = hash_hmac('ripemd160', 'p' . $talep_id, $this->config->item('encryption_key'));


                 $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$talep_id&pers_id=$proje_sorumlusu_id&type=gider_talep_formu_onay&token=$validtoken";
                 $message .="<br>İncelemek İçin<a href='$href'>Tıklayınız</a>";


                 $message .= "<br><br><br><br>";

                 $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                 $proje_sorumlusu_email = personel_detailsa($proje_sorumlusu_id)['email'];



                 $recipients = array($proje_sorumlusu_email);


                 $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$talep_id);
 */


                $this->db->trans_complete();
                // Mail Gönderme
                echo json_encode(array('status' => 'Success', 'message' =>

                    $this->lang->line('talep_success') . " <a href='/form/gider_view?id=$talep_id' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='giderprintinvoice?id=$talep_id' class='btn btn-indigo btn-lg' target='_blank'><span class='icon-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; "));

            }

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                "Invalid Entry!"));

            $transok = false;
            $this->db->trans_rollback();


        }


    }




    public  function getSmallLink($longurl){

        if($longurl){
            $sayi=rand(1,99999999);
            $name='makro2000'.$sayi;
            $url = urlencode("$longurl");
            $json = file_get_contents("https://cutt.ly/api/api.php?key=e67f08835022a9c59b736d5c9e109ba5a8c4a&short=$url&name=$name");
            $data = json_decode ($json, true);
            return $data['url']['shortLink'];
        }
        else {
            return "";
        }




    }

    public function cari_pers_list()
    {
        $tip=$this->input->post('cari_pers');
        $invoice_list=array();
        if($tip==1) //personel
        {
            $invoice_list=$this->db->query("SELECT id,name FROM geopos_employees ")->result();
        }
        else if($tip==2) //personel
        {
            $invoice_list=$this->db->query("SELECT geopos_customers.id,geopos_customers.company as name FROM `geopos_customers`")->result();
        }

        $data=array();
        foreach ($invoice_list as $l)
        {
            $data[]=array(
                'name'=>$l->name,
                'id'=>$l->id
            );
        }

        echo json_encode($data);
    }

    public function cari_pers_list_invoice()
    {
        $tip=$this->input->post('cari_id');
        $talep_or_invoice=$this->input->post('talep_or_invoice');
        $data=array();
        if($talep_or_invoice==1){
            $invoice_list=$this->db->query("SELECT geopos_customers.id,geopos_customers.name,geopos_invoices.id as
inv_id,geopos_invoices.invoice_no,geopos_invoices.total FROM
 `geopos_customers` LEFT JOIN geopos_invoices ON geopos_customers.id=geopos_invoices.csd WHERE geopos_customers.id=$tip")->result();


            foreach ($invoice_list as $l)
            {
                $data[]=array(
                    'name'=>$l->invoice_no.' '.amountFormat($l->total),
                    'id'=>$l->inv_id,
                    'total'=>$l->total,
                    'status'=>0,
                    'beklyen_total'=>0
                );
            }
        }
        elseif($talep_or_invoice==3){
            $invoice_list=$this->db->query("SELECT * FROM lojistik_satinalma_talep WHERE status=2")->result();



            foreach ($invoice_list as $l)
            {
                $invoice_items=$this->db->query("SELECT * FROM `lojistik_satinalma_item` WHERE `lojistik_id` = $l->id")->result();
                $totals = 0;
                foreach ($invoice_items as $items){
                    $totals+=$items->price;
                }

                $kontrol = $this->db->query("SELECT * FROM `geopos_talep` WHERE `invoice_id` = $l->id and tip=5 and status IN (1,3,7,9)");
                $status=0;
                $beklyen_total=0;
                if($kontrol->num_rows()){
                    foreach ($kontrol->result() as $items){
                        $beklyen_total += $items->total;
                    }
                }

                $data[]=array(
                    'name'=>$l->talep_no,
                    'id'=>$l->id,
                    'total'=>$totals,
                    'status'=>0,
                    'beklyen_total'=>$beklyen_total,
                );
            }
        }
        else {
            $invoice_list=$this->db->query("SELECT * FROM `geopos_talep` WHERE `status` = 3 and tip=2 ORDER BY `id` DESC")->result();



            foreach ($invoice_list as $l)
            {

                $invoice_items=$this->db->query(" SELECT * FROM `geopos_talep_items` WHERE `tip` =  $l->id")->result();
                $totals = 0;
                foreach ($invoice_items as $items){
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` WHERE `malzeme_items_id` = $items->id and genel_mudur_status=3")->num_rows();
                    if($onay_kontrol)
                        $totals+=$items->price;
                    }




                $data[]=array(
                    'name'=>$l->talep_no,
                    'id'=>$l->id,
                    'total'=>$totals,
                    'status'=>0,
                    'beklyen_total'=>0,

                );
            }
        }



        echo json_encode($data);
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

    public function edit_avans()
    {
        $talep_id=$this->input->post('talep_id', true);
        $method=$this->input->post('method', true);
        $proje_id = $this->input->post('proje_id', true);
        $proje_name = proje_name($proje_id);
        $olusturma_tarihi = $this->input->post('olusturma_tarihi', true);
        $talep_eden_pers_id = $this->input->post('talep_eden_pers_id', true);
        $proje_sorumlusu_id = $this->input->post('proje_sorumlusu_id');
        $proje_muduru_id = $this->input->post('proje_muduru_id');
        $bolum_mudur_id = $this->input->post('bolum_mudur_id');
        $finans_mudur_id = $this->input->post('finans_mudur_id');
        $genel_mudur_id = $this->input->post('genel_mudur_id', true);
        $tel = $this->input->post('tel', true);
        $description = $this->input->post('description', true);
        $bolum_adi = $this->input->post('bolum_adi', true);
        $subtotal = $this->input->post('subtotal', true); // Ara Toplam
        $tax = 0; //toplam kdv
        $discount = 0; //toplam indirim
        $nettotalinp = $this->input->post('nettotalinp', true); // Net toplam
        $cari_pers = $this->input->post('cari_pers', true); // Net toplam
        $total = $this->input->post('total'); //Genel Toplam
        $olus_t = datefordatabase($olusturma_tarihi);
        $kullanici_id =$this->aauth->get_user()->id;
        $inv_id =$this->input->post('invoice', true); // İnvoice ID
        $proje_bolum_id =$this->input->post('proje_bolum_id', true); // İnvoice ID

        $transok = true;

        $st_c = 0;

        $this->db->trans_start();

        $pers_name='';

        if($cari_pers==1) // Personel
        {
            $pers_name = personel_details($talep_eden_pers_id);
        }
        else { // Cari 2
            $pers_name = customer_details($talep_eden_pers_id)['company'];;
        }

        $data = array(
            'proje_name' => $proje_name,
            'olusturma_tarihi' => $olus_t,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'method' => $method,
            'discount' => $discount,
            'nettotal' => $nettotalinp,
            'total' => $total,
            'tel' => $tel,
            'description' => $description,
            'talep_eden_pers_id' => $talep_eden_pers_id,
            'bolum_mudur_id' => $bolum_mudur_id,
            'talep_olusturan_pers_id' => $this->aauth->get_user()->id,
            'proje_sorumlusu_id' => $proje_sorumlusu_id,
            'proje_muduru_id' => $proje_muduru_id,
            'genel_mudur_id' => $genel_mudur_id,
            'finans_departman_pers_id' => $finans_mudur_id,
            'bolum_adi' => $bolum_adi,
            'proje_id' => $proje_id,
            'tip' => 5,
            'bildirim_durumu' => 1,
            'dev_bildirim' => 1,
            'kullanici_id' => $kullanici_id,
            'cari_pers' => $cari_pers,
            'invoice_id' => $inv_id,
            'payer' => $pers_name,
            'proje_bolum_id' => $proje_bolum_id,
            'proje_bolum_name' => $this->db->query("SELECT * FROM geopos_project_bolum Where id =$proje_bolum_id")->row()->name,
            'loc' => $this->aauth->get_user()->loc);

        $this->db->set($data);

        $this->db->where('id', $talep_id);

        if ($this->db->update('geopos_talep', $data)) {

            $this->aauth->applog("Ödeme / Avans Talebi Düzenlendi $talep_id ID ".$talep_id,$this->aauth->get_user()->username,$talep_id);
            kont_kayit(28,$talep_id);

            $this->db->delete('geopos_talep_items', array('tip' => $talep_id));

            $this->db->delete('geopos_onay', array('file_id' => $talep_id,'type'=>4));

            $productlist = array();
            $data_items = array();
            $prodindex = 0;
            $itc = 0;
            $total_tax = 0;
            $total_discount = 0;

            $product_name = $this->input->post('product_name');


            $this->db->delete('geopos_onay', array('file_id' => $talep_id));
            foreach ($product_name as $key => $value) {
                $product_name = $this->input->post('product_name');
                $unit = $this->input->post('unit');

                $product_qty = $this->input->post('product_qty');
                $product_id = $this->input->post('pid');

                $product_price = $this->input->post('product_price');
                $product_subtotal = $this->input->post('product_subtotal');
                $product_detail = $this->input->post('product_detail');

                if ($product_id[$key] != 0) {
                    $data_items = array(

                        'tip' => $talep_id,

                        'product_name' => $product_name[$key],

                        'product_detail' => $product_detail[$key],

                        'product_id' => $product_id[$key],

                        'qty' => $product_qty[$key],

                        'price' => $product_price[$key],

                        'tax' => 0,

                        'discount' => 0,

                        'subtotal' => $product_subtotal[$key],

                        'totaltax' => 0,

                        'totaldiscount' => 0,

                        'unit' => $unit[$key]
                    );
                    $productlist[$prodindex] = $data_items;

                    $this->db->insert('geopos_talep_items', $data_items);

                    $malzeme_items_id = $this->db->insert_id();

                    $data_o= array(
                        'product_id' => $product_id[$key],
                        'file_id' => $talep_id,
                        'malzeme_items_id' => $malzeme_items_id,
                        'type' => 5);

                    $this->db->insert('geopos_onay', $data_o);

                    $prodindex++;
                }
            }

            if ($prodindex > 0) {








            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "Lütfen gider listesinden ürün seçin. Gider eklemediyseniz, Gider yöneticisi bölümüne gidin."));

                $transok = false;

            }
            if ($transok) {


                $this->db->trans_complete();
                // Mail Gönderme
                echo json_encode(array('status' => 'Success', 'message' =>

                    $this->lang->line('talep_success') . " <a href='/form/avans_view?id=$talep_id' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='/form/avansprintinvoice?id=$talep_id' class='btn btn-indigo btn-lg' target='_blank'><span class='icon-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; "));

            }

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                "Invalid Entry!"));

            $transok = false;
            $this->db->trans_rollback();


        }

    }

    public function odeme_talep_view(){

        $odeme_id = $this->input->get('id');
        $data['trans'] = $this->db->query("SELECT * FROM geopos_talep  Where id = $odeme_id")->row_array();
        if($data['trans']['tip']==6){
            $data['sf_no'] = $this->db->query("SELECT * FROM geopos_talep  Where id =".$data['trans']['malzeme_talep_form_id'])->row()->talep_no;
            $data['tip']=1;
        }
        else
        {
            $data['sf_no'] = $this->db->query("SELECT * FROM geopos_invoices  Where id =".$data['trans']['malzeme_talep_form_id'])->row()->invoice_no;
            $data['tip']=2;
        }



        $head['title'] = "Talep Görüntüle";
        $head['usernm'] = $this->aauth->get_user()->username;
        $id = $this->input->get('id');
        $this->load->view('fixed/header', $head);
        $this->load->view('form/odeme_talep_view', $data);

        $this->load->view('fixed/footer');
    }


    public function odeme_talep_create(){

        if($this->input->post('tip')=='sf'){

            $sf_id = $this->input->post('sf_id', true);
            $firma = $this->input->post('firma', true);
            $net_tutar = $this->input->post('net_tutar', true);
            $total_kdv = $this->input->post('total_kdv', true);
            $talep_total = $this->input->post('talep_total', true);
            $total = $this->input->post('total', true);
            $method = $this->input->post('method', true);

            $talep_details = $this->db->query("SELECT * FROM geopos_talep Where id = $sf_id")->row();
            $talep_no = numaric(12);
            $proje_id = $talep_details->proje_id;
            $proje_name = $talep_details->proje_name;
            $proje_bolum_id = $talep_details->proje_bolum_id;
            $proje_bolum_name = $talep_details->proje_bolum_name;
            $subtotal = $net_tutar;
            $nettotal = $net_tutar;
            $description = $this->input->post('desc', true);
            $tax = $total_kdv;
            $talep_eden_pers_id = $this->db->query("select * from geopos_customers where company='$firma' ")->row()->id;
            $malzeme_talep_form_id = $sf_id;

            $data = array(
                'talep_no' => $talep_no,
                'proje_name' => $proje_name,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'nettotal' => $nettotal,
                'talep_total' => $talep_total,
                'total' => $total,
                'description' => $description,
                'talep_eden_pers_id' => $talep_eden_pers_id,
                'talep_olusturan_pers_id' => $this->aauth->get_user()->id,
                'proje_id' => $proje_id,
                'status' => 3,
                'tip' => 6,
                'bildirim_durumu' => 1,
                'dev_bildirim' => 1,
                'kullanici_id' => $this->aauth->get_user()->id,
                'cari_pers' => 2,
                'payer' => $firma,
                'proje_bolum_id' => $proje_bolum_id,
                'method' => $method,
                'proje_bolum_name' => $proje_bolum_name,
                'loc' => $this->aauth->get_user()->loc,
                'malzeme_talep_form_id'=>$malzeme_talep_form_id
            );


            if ($this->db->insert('geopos_talep', $data)) {

                $talep_id = $this->db->insert_id();

                $this->aauth->applog("Ödeme Talebi Oluşturuldu $talep_no ID " . $talep_id, $this->aauth->get_user()->username, $talep_no);

                $operator = "deger+1";
                $this->db->set('deger', "$operator", FALSE);
                $this->db->where('tip', 12);
                $this->db->update('numaric');

                echo json_encode(array('status' => 'Success', 'message' =>

                    "Başarıyla Talebiniz Oluşturuldu."));
            }
            else {
                echo json_encode(array('status' => 'Error', 'message' =>

                    "Lütfen Yöneticiye Başvurun."));
            }
        }
        else {
            $forma_2_id = $this->input->post('forma_2_id', true);
            $net_tutar = $this->input->post('net_tutar', true);
            $total_kdv = $this->input->post('total_kdv', true);
            $talep_total = $this->input->post('talep_total', true);
            $total = $this->input->post('total', true);
            $method = $this->input->post('method', true);
            $description = $this->input->post('desc', true);

            $talep_details = $this->db->query("SELECT * FROM geopos_invoices Where id = $forma_2_id")->row();

            $talep_no = numaric(12);
            $proje_id = $talep_details->proje_id;
            $proje_name = proje_name($talep_details->proje_id);
            $proje_bolum_id = 0;
            $proje_bolum_name = '';
            $subtotal = $net_tutar;
            $nettotal = $net_tutar;
            $malzeme_talep_form_id = $forma_2_id;

            $sayi=0;

            $talep_kontrol = $this->db->query("SELECT * FROM `geopos_talep` WHERE `malzeme_talep_form_id` = $forma_2_id ORDER BY `tip` DESC");
            if($talep_kontrol->num_rows()){
              foreach ($talep_kontrol->result() as $values)
              {
                  if($values->status==3){
                      $sayi++;
                  }
              }

            }
            if($talep_total==0){
                echo json_encode(array('status' => 'Error', 'message' =>

                    "Ödemeniz Kalmamıştır."));
                exit();
            }
            if($sayi==0){
                $data = array(
                    'talep_no' => $talep_no,
                    'proje_name' => $proje_name,
                    'subtotal' => $subtotal,
                    'tax' => $total_kdv,
                    'nettotal' => $nettotal,
                    'talep_total' => $talep_total,
                    'total' => $total,
                    'description' => $description,
                    'talep_eden_pers_id' => $talep_details->csd,
                    'talep_olusturan_pers_id' => $this->aauth->get_user()->id,
                    'proje_id' => $proje_id,
                    'status' => 3,
                    'tip' => 7,
                    'bildirim_durumu' => 1,
                    'dev_bildirim' => 1,
                    'kullanici_id' => $this->aauth->get_user()->id,
                    'cari_pers' => 2,
                    'payer' => $talep_details->payer,
                    'proje_bolum_id' => 0,
                    'method' => $method,
                    'proje_bolum_name' => '',
                    'loc' => $this->aauth->get_user()->loc,
                    'malzeme_talep_form_id'=>$malzeme_talep_form_id
                );


                if ($this->db->insert('geopos_talep', $data)) {

                    $talep_id = $this->db->insert_id();

                    $this->aauth->applog("Forma 2 Ödeme Talebi Oluşturuldu $talep_no ID " . $talep_id, $this->aauth->get_user()->username, $talep_no);

                    $operator = "deger+1";
                    $this->db->set('deger', "$operator", FALSE);
                    $this->db->where('tip', 12);
                    $this->db->update('numaric');

                    echo json_encode(array('status' => 'Success', 'message' =>

                        "Başarıyla Talebiniz Oluşturuldu."));
                }
                else {
                    echo json_encode(array('status' => 'Error', 'message' =>

                        "Lütfen Yöneticiye Başvurun."));
                }
            }
            else {
                echo json_encode(array('status' => 'Error', 'message' =>

                    "İncelemede Olan Ödeme Talebiniz Var."));
            }



        }




        }
    public function sf_info_firma(){

        $sf_id = $this->input->post('sf_id', true);
        $firma = $this->input->post('firma', true);
        $query2 = $this->db->query("SELECT * FROM geopos_talep_items INNER JOIN geopos_onay ON geopos_talep_items.id = geopos_onay.malzeme_items_id Where geopos_talep_items.tip = $sf_id and geopos_talep_items.firma='$firma' and geopos_onay.genel_mudur_status=3")->result();
        $odenen_total = 0;
        $odeme_talepleri = $this->db->query("SELECT * FROM `geopos_talep` WHERE `malzeme_talep_form_id` = $sf_id ");
        if($odeme_talepleri->num_rows()>0){
            foreach ($odeme_talepleri->result() as $value){
                $odenen_total += $this->db->query("SELECT IF(SUM(total), SUM(total),0) as total FROM geopos_invoice_transactions Where invoice_id=$value->id and tip=7")->row()->total;
            }
        }



        $method =  $this->db->query("SELECT method FROM `geopos_talep_items` WHERE `tip`=$sf_id and firma='$firma' and ref_urun=0   GROUP by method")->row()->method;


        $subtotal=0;
        $total=0;
        $tax=0;
        $net_tutar=0;
        $kdv_status = 0;
        foreach ($query2 as $value){
            $subtotal += $value->subtotal;
            if($value->kdv_dahil_haric == 1){
                $kdv_status=1;
            }
        }
        if($kdv_status == 1){
            $net_tutar = $subtotal - (floatval($subtotal) * 0.18);
            $tax = (floatval($subtotal) * 0.18);
            $total = $tax+$net_tutar;
        }
        else {
            $tax = 0;
            $total = $subtotal;
            $net_tutar = $subtotal;
        }

        if($odenen_total == $total){
            echo json_encode(array('status' => 'Error', 'message'=>'Tüm Bakiye Ödenmiş'));
        }
        else {


            echo json_encode(array('status' => 'Success', 'method'=>$method,'net_tutar'=>$net_tutar,'tax'=>$tax,'total'=>$total,'kalan'=>floatval($total)-floatval($odenen_total)));
        }


    }
    public function action_avans()
    {


        $currency = 1;
        $st=0; //Muhasebe ürünleri
        $talep_no = numaric(5);
        $proje_id = $this->input->post('proje_id', true);
        $method = $this->input->post('method', true);
        $proje_name = proje_name($proje_id);
        $olusturma_tarihi = $this->input->post('olusturma_tarihi', true);
        $talep_eden_pers_id = $this->input->post('talep_eden_pers_id', true);
        $proje_sorumlusu_id = $this->input->post('proje_sorumlusu_id');
        $proje_muduru_id = $this->input->post('proje_muduru_id');
        $bolum_mudur_id = $this->input->post('bolum_mudur_id');
        $finans_mudur_id = $this->input->post('finans_mudur_id');
        $genel_mudur_id = $this->input->post('genel_mudur_id', true);
        $tel = $this->input->post('tel', true);
        $description = $this->input->post('description', true);
        $bolum_adi = $this->input->post('bolum_adi', true);
        $subtotal = $this->input->post('subtotal', true); // Ara Toplam
        $tax = 0; //toplam kdv
        $discount = 0; //toplam indirim
        $nettotalinp = $this->input->post('nettotalinp', true); // Net toplam
        $cari_pers = $this->input->post('cari_pers', true); // Net toplam
        $total = $this->input->post('total'); //Genel Toplam
        $olus_t = datefordatabase($olusturma_tarihi);
        $kullanici_id =$this->aauth->get_user()->id;
        $inv_id =$this->input->post('invoice', true); // İnvoice ID
        $proje_bolum_id = $this->input->post('proje_bolum_id');
        $talep_or_invoice = $this->input->post('talep_or_invoice');


        $transok = true;

        if(!$talep_eden_pers_id){
            echo json_encode(array('status' => 'Error', 'message' =>

                "Talep Eden Zorunludur"));

            $transok = false;
            $this->db->trans_rollback();
        }

        $st_c = 0;

        $this->db->trans_start();

        $pers_name='';

        if($cari_pers==1) // Personel
        {
            $pers_name = personel_details($talep_eden_pers_id);
        }
        else { // Cari 2
            $pers_name = customer_details($talep_eden_pers_id)['company'];;
        }

        $data = array(
            'talep_no' => $talep_no,
            'proje_name' => $proje_name,
            'olusturma_tarihi' => $olus_t,
            'subtotal' => $subtotal,
            'method' => $method,
            'tax' => $tax,
            'discount' => $discount,
            'nettotal' => $nettotalinp,
            'total' => $total,
            'tel' => $tel,
            'talep_or_invoice' => $talep_or_invoice,
            'description' => $description,
            'talep_eden_pers_id' => $talep_eden_pers_id,
            'bolum_mudur_id' => $bolum_mudur_id,
            'talep_olusturan_pers_id' => $this->aauth->get_user()->id,
            'proje_sorumlusu_id' => $proje_sorumlusu_id,
            'proje_muduru_id' => $proje_muduru_id,
            'genel_mudur_id' => $genel_mudur_id,
            'finans_departman_pers_id' => $finans_mudur_id,
            'bolum_adi' => $bolum_adi,
            'proje_id' => $proje_id,
            'stok_durumu' => $st,
            'tip' => 5,
            'bildirim_durumu' => 1,
            'dev_bildirim' => 1,
            'kullanici_id' => $kullanici_id,
            'cari_pers' => $cari_pers,
            'invoice_id' => $inv_id,
            'payer' => $pers_name,
            'proje_bolum_id' => $proje_bolum_id,
            'proje_bolum_name' => $this->db->query("SELECT * FROM geopos_project_bolum Where id =$proje_bolum_id")->row()->name,
            'loc' => $this->aauth->get_user()->loc);


        if ($this->db->insert('geopos_talep', $data)) {

            $talep_id = $this->db->insert_id();

            $this->aauth->applog("Ödeme / Avans Talebi Oluşturuldu $talep_no ID ".$talep_id,$this->aauth->get_user()->username,$talep_no);
            kont_kayit(27,$talep_id);

            $operator= "deger+1";


            $this->db->set('deger', "$operator", FALSE);
            $this->db->where('tip', 5);
            $this->db->update('numaric');



            $productlist = array();
            $data_items = array();
            $prodindex = 0;
            $itc = 0;
            $total_tax = 0;
            $total_discount = 0;

            $product_name = $this->input->post('product_name');





            foreach ($product_name as $key => $value) {
                $product_name = $this->input->post('product_name');
                $unit = $this->input->post('unit');

                $product_qty = $this->input->post('product_qty');
                $product_id = $this->input->post('pid');

                $product_price = $this->input->post('product_price');
                $product_subtotal = $this->input->post('product_subtotal');
                $product_detail = $this->input->post('product_detail');

                if ($product_id[$key] != 0) {
                    $data_items = array(

                        'tip' => $talep_id,

                        'product_name' => $product_name[$key],

                        'product_detail' => $product_detail[$key],

                        'product_id' => $product_id[$key],

                        'qty' => $product_qty[$key],

                        'price' => $product_price[$key],

                        'tax' => 0,

                        'discount' => 0,

                        'subtotal' => $product_subtotal[$key],

                        'totaltax' => 0,

                        'totaldiscount' => 0,

                        'unit' => $unit[$key]
                    );
                    $productlist[$prodindex] = $data_items;

                    $this->db->insert('geopos_talep_items', $data_items);

                    $malzeme_items_id = $this->db->insert_id();

                    $data_o= array(
                        'product_id' => $product_id[$key],
                        'file_id' => $talep_id,
                        'malzeme_items_id' => $malzeme_items_id,
                        'type' => 5);

                    $this->db->insert('geopos_onay', $data_o);

                    $prodindex++;
                }
            }

            if ($prodindex > 0) {








            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "Lütfen ürün listesinden ürün seçin. Ürünleri eklemediyseniz, Ürün yöneticisi bölümüne gidin."));

                $transok = false;

            }

            if ($transok) {

                // Mail Gönderme



                $subject = 'Avans Talep Formu Onayı';

                $message = 'Sayın Yetkili ' . $talep_no . ' Numaralı Avans Talep Formu Oluşturuldu. Onay İşleminiz Beklenmektedir.';
                $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
                $firma_kodu=$dbnames['firma_kodu'];
                $validtoken = hash_hmac('ripemd160', 'p' . $talep_id, $this->config->item('encryption_key'));


                $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$talep_id&pers_id=$proje_sorumlusu_id&type=avans_talep_formu_onay&token=$validtoken";
                $message .="<br>Avans Talep Formunu İncelemek İçin<a href='$href'>Tıklayınız</a>";


                $message .= "<br><br><br><br>";

                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $proje_sorumlusu_email = personel_detailsa($proje_sorumlusu_id)['email'];
                $proje_sorumlusu_no = personel_detailsa($proje_sorumlusu_id)['phone'];



                $short_url = $this->getSmallLink($href);
                $mesaj=$talep_no." Numaralı Avans Talep Formunu Incelemek icin tiklayiniz.$short_url";


                $recipients = array($proje_sorumlusu_email);

                $message_ = $this->mesaj_gonder($proje_sorumlusu_no,$mesaj);
                if($message_==1)
                {
                    $this->onay_mailleri($subject, $message, $recipients, 'avans_talep_onay_maili');
                }





                // Mail Gönderme
                echo json_encode(array('status' => 'Success', 'message' =>

                    $this->lang->line('talep_success') . " <a href='/form/avans_view?id=$talep_id' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='giderprintinvoice?id=$talep_id' class='btn btn-indigo btn-lg' target='_blank'><span class='icon-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; "));
                $this->db->trans_complete();
            }

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                "Invalid Entry!"));

            $transok = false;
            $this->db->trans_rollback();


        }


    }

    public function action_gider()
    {


        $currency = 1;
        $st=0; //Muhasebe ürünleri
        $talep_no = numaric(1);
        $proje_id = $this->input->post('proje_id', true);
        $proje_name = proje_name($proje_id);
        $olusturma_tarihi = $this->input->post('olusturma_tarihi', true);
        $talep_eden_pers_id = $this->input->post('talep_eden_pers_id', true);
        $proje_sorumlusu_id = $this->input->post('proje_sorumlusu_id');
        $proje_muduru_id = $this->input->post('proje_muduru_id');
        $bolum_mudur_id = $this->input->post('bolum_mudur_id');
        $finans_mudur_id = $this->input->post('finans_mudur_id');
        $genel_mudur_id = $this->input->post('genel_mudur_id', true);
        $tel = $this->input->post('tel', true);
        $cari_pers = $this->input->post('cari_pers', true); // Net toplam
        $description = $this->input->post('description', true);
        $bolum_adi = $this->input->post('bolum_adi', true);
        $subtotal = $this->input->post('subtotal', true); // Ara Toplam
        $tax = 0; //toplam kdv
        $discount = 0; //toplam indirim
        $nettotalinp = $this->input->post('nettotalinp', true); // Net toplam
        $total = $this->input->post('total'); //Genel Toplam
        $olus_t = datefordatabase($olusturma_tarihi);
        $kullanici_id =$this->aauth->get_user()->id;
        $proje_bolum_id = $this->input->post('proje_bolum_id');
        $inv_id =$this->input->post('invoice', true); // İnvoice ID


        if(!$talep_eden_pers_id){
            echo json_encode(array('status' => 'Error', 'message' =>

                "Talep Eden Zorunludur"));

            $transok = false;
            $this->db->trans_rollback();
        }

        $pers_name='';

        if($cari_pers==1) // Personel
        {
            $pers_name = personel_details($talep_eden_pers_id);
        }
        else { // Cari 2
            $pers_name = customer_details($talep_eden_pers_id)['company'];;
        }


        $transok = true;

        $st_c = 0;

        $this->db->trans_start();

        $data = array(
            'talep_no' => $talep_no,
            'proje_name' => $proje_name,
            'olusturma_tarihi' => $olus_t,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'nettotal' => $nettotalinp,
            'total' => $total,
            'tel' => $tel,
            'description' => $description,
            'talep_eden_pers_id' => $talep_eden_pers_id,
            'bolum_mudur_id' => $bolum_mudur_id,
            'talep_olusturan_pers_id' => $this->aauth->get_user()->id,
            'proje_sorumlusu_id' => $proje_sorumlusu_id,
            'proje_muduru_id' => $proje_muduru_id,
            'genel_mudur_id' => $genel_mudur_id,
            'finans_departman_pers_id' => $finans_mudur_id,
            'bolum_adi' => $bolum_adi,
            'proje_id' => $proje_id,
            'stok_durumu' => $st,
            'payer' => $pers_name,
            'tip' => 4,
            'cari_pers' => $cari_pers,
            'invoice_id' => $inv_id,
            'bildirim_durumu' => 1,
            'dev_bildirim' => 1,
            'kullanici_id' => $kullanici_id,
            'proje_bolum_id' => $proje_bolum_id,
            'proje_bolum_name' => $this->db->query("SELECT * FROM geopos_project_bolum Where id =$proje_bolum_id")->row()->name,
            'loc' => $this->aauth->get_user()->loc);

        if ($this->db->insert('geopos_talep', $data)) {

            $talep_id = $this->db->insert_id();

            $this->aauth->applog("Gider Talep Formu Oluşturuldu $talep_no ID ".$talep_id,$this->aauth->get_user()->username,$talep_no);
            kont_kayit(25,$talep_id);


            $operator= "deger+1";


            $this->db->set('deger', "$operator", FALSE);
            $this->db->where('tip', 1);
            $this->db->update('numaric');



            $productlist = array();
            $data_items = array();
            $prodindex = 0;
            $itc = 0;
            $total_tax = 0;
            $total_discount = 0;

            $product_name = $this->input->post('product_name');





            foreach ($product_name as $key => $value) {
                $product_name = $this->input->post('product_name');
                $unit = $this->input->post('unit');

                $product_qty = $this->input->post('product_qty');
                $product_id = $this->input->post('pid');

                $product_price = $this->input->post('product_price');
                $product_subtotal = $this->input->post('product_subtotal');
                $product_detail = $this->input->post('product_detail');

                if ($product_id[$key] != 0) {
                    $data_items = array(

                        'tip' => $talep_id,

                        'product_name' => $product_name[$key],

                        'product_detail' => $product_detail[$key],

                        'product_id' => $product_id[$key],

                        'qty' => $product_qty[$key],

                        'price' => $product_price[$key],

                        'tax' => 0,

                        'discount' => 0,

                        'subtotal' => $product_subtotal[$key],

                        'totaltax' => 0,

                        'totaldiscount' => 0,

                        'unit' => $unit[$key]
                    );
                    $productlist[$prodindex] = $data_items;

                    $this->db->insert('geopos_talep_items', $data_items);

                    $malzeme_items_id = $this->db->insert_id();

                    $data_o= array(
                        'product_id' => $product_id[$key],
                        'file_id' => $talep_id,
                        'malzeme_items_id' => $malzeme_items_id,
                        'type' => 4);

                    $this->db->insert('geopos_onay', $data_o);

                    $prodindex++;
                }
            }

            if ($prodindex > 0) {








            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "Lütfen ürün listesinden ürün seçin. Ürünleri eklemediyseniz, Ürün yöneticisi bölümüne gidin."));

                $transok = false;

            }

            if ($transok) {

                // Mail Gönderme



                $subject = 'Gider Talep Formu Onayı';

                $message = 'Sayın Yetkili ' . $talep_no . ' Numaralı Gider Talep Formu Oluşturuldu. Onay İşleminiz Beklenmektedir.';
                $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
                $firma_kodu=$dbnames['firma_kodu'];
                $validtoken = hash_hmac('ripemd160', 'p' . $talep_id, $this->config->item('encryption_key'));


                $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$talep_id&pers_id=$proje_sorumlusu_id&type=gider_talep_formu_onay&token=$validtoken";
                $message .="<br>Gider Talep Formunu İncelemek İçin<a href='$href'>Tıklayınız</a>";


                $message .= "<br><br><br><br>";

                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $proje_sorumlusu_email = personel_detailsa($proje_sorumlusu_id)['email'];
                $proje_sorumlusu_no = personel_detailsa($proje_sorumlusu_id)['phone'];



                $short_url = $this->getSmallLink($href);
                $mesaj=$talep_no." Numaralı Gider Talep Formunu Incelemek icin tiklayiniz.$short_url";


                $recipients = array($proje_sorumlusu_email);

                $message_ = $this->mesaj_gonder($proje_sorumlusu_no,$mesaj);
                if($message_==1)
                {
                    $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili');
                }





                // Mail Gönderme
                echo json_encode(array('status' => 'Success', 'message' =>

                    $this->lang->line('talep_success') . " <a href='/form/gider_view?id=$talep_id' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='giderprintinvoice?id=$talep_id' class='btn btn-indigo btn-lg' target='_blank'><span class='icon-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; "));
                $this->db->trans_complete();
            }

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                "Invalid Entry!"));

            $transok = false;
            $this->db->trans_rollback();


        }


    }

    public function action_satinalma_emri()
    {
        $currency = 1;
        $talep_no = $this->input->post('talep_no', true);
        $proje_name = $this->input->post('proje_name', true);
        $olusturma_tarihi = $this->input->post('olusturma_tarihi', true);
        $talep_eden_pers_id = $this->input->post('talep_eden_pers_id', true);
        $satinalma_personeli = $this->input->post('satinalma_personeli', true);
        $proje_muduru_id = $this->input->post('proje_muduru_id', true);
        $genel_mudur_id = $this->input->post('genel_mudur_id', true);
        $finans_departman_pers_id = $this->input->post('finans_departman_pers_id', true);
        $bolum_mudur_id = $this->input->post('bolum_mudur_id');


        $olus_t = datefordatabase($olusturma_tarihi);

        $transok = true;

        $st_c = 0;

        $this->db->trans_start();

        $data = array(
            'talep_no' => $talep_no,
            'proje_name' => $proje_name,
            'olusturma_tarihi' => $olus_t,
            'talep_eden_pers_id' => $talep_eden_pers_id,
            'satinalma_personeli' => $satinalma_personeli,
            'proje_muduru_id' => $proje_muduru_id,
            'bolum_mudur_id' => $bolum_mudur_id,
            'finans_departman_pers_id' => $finans_departman_pers_id,
            'talep_olusturan_pers_id' => $this->aauth->get_user()->id,
            'genel_mudur_id' => $genel_mudur_id,
            'tip' => 3,
            'loc' => $this->aauth->get_user()->loc);

        if ($this->db->insert('geopos_talep', $data)) {

            $talep_id = $this->db->insert_id();


            $product_name = $this->input->post('product_name');
            $productlist = array();
            $prodindex = 0;
            $itc = 0;
            $total_tax = 0;
            $total_discount = 0;

            foreach ($product_name as $key => $value) {
                $product_name = $this->input->post('product_name');
                $unit = $this->input->post('unit');
                $firma = $this->input->post('firma');
                $product_detail = $this->input->post('product_detail');
                $satin_alma_pers_item_id = $this->input->post('satin_alma_pers_item_id');
                $product_qty = $this->input->post('product_qty');
                $product_price = $this->input->post('product_price');
                $product_tax = $this->input->post('product_tax');
                $product_subtotal = $this->input->post('product_tutar');
                $ptotal_tax = $this->input->post('tax');
                $ptotal_disc = $this->input->post('disca');

                $total_discount += $ptotal_disc[$key];
                $total_tax += $ptotal_tax[$key];
                if ($product_name[$key] != '') {
                    $data_items = array(

                        'tip' => $talep_id,

                        'product_name' => $product_name[$key],

                        'product_detail' => $product_detail[$key],

                        'qty' => $product_qty[$key],

                        'firma' => $firma[$key],

                        'price' => rev_amountExchange($product_price[$key], $currency),

                        'tax' => rev_amountExchange($product_tax[$key], $currency),
                        'satin_alma_pers_item_id' => $satin_alma_pers_item_id[$key],
                        'subtotal' => rev_amountExchange($product_subtotal[$key], $currency),

                        'totaltax' => rev_amountExchange($ptotal_tax[$key], $currency),

                        'totaldiscount' => rev_amountExchange($ptotal_disc[$key], $currency),

                        'unit' => $unit[$key]
                    );
                    $productlist[$prodindex] = $data_items;

                    $prodindex++;
                }
            }

            if ($prodindex > 0) {

                $this->db->insert_batch('geopos_talep_items', $productlist);

                $this->db->set(array(
                    'discount' => rev_amountExchange($total_discount, $currency),
                    'tax' => rev_amountExchange($total_tax, $currency)
                ));

                $this->db->where('id', $talep_id);

                $this->db->update('geopos_talep');


            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "Lütfen ürün listesinden ürün seçin. Ürünleri eklemediyseniz, Ürün yöneticisi bölümüne gidin."));

                $transok = false;

            }

            if ($transok) {

                // Mail Gönderme

                $subject = 'Satın Alma Emri Hk.';

                $message = 'Sayın Yetkili ' . $talep_no . ' Numaralı Satın Alma Emri Oluşturuldu. Onay İşleminiz Beklenmektedir.';


                $message .= "<br><br><br><br>";

                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $proje_muduru_email = personel_detailsa($proje_muduru_id)['email'];
                $finans_departman_pers_email = personel_detailsa($finans_departman_pers_id)['email'];
                $genel_mudur_email = personel_detailsa($genel_mudur_id)['email'];


                $recipients = array($proje_muduru_email,$finans_departman_pers_email,$genel_mudur_email);


                $mobile_ = personel_detailsa($proje_muduru_id)['phone'];
                $mobile2= personel_detailsa($finans_departman_pers_id)['phone'];
                $mobile3= personel_detailsa($genel_mudur_id)['phone'];
                $mesaj="Sayın Yetkili ".$talep_no." Numaralı Satın Alma Formu Olusturulmustur. Programa giris yaparak satın alma formundan islemlerinize baslayabilirsiniz.";

                $this->mesaj_gonder($mobile_,$mesaj);
                $this->mesaj_gonder($mobile2,$mesaj);
                $this->mesaj_gonder($mobile3,$mesaj);


                $this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili');

                // Mail Gönderme
                echo json_encode(array('status' => 'Success', 'message' =>

                    $this->lang->line('talep_success') . " <a href='/form/satinalma_emri_view?id=$talep_id' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$talep_id' class='btn btn-indigo btn-lg' target='_blank'><span class='icon-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; "));
                $this->db->trans_complete();
            }

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                "Invalid Entry!"));

            $transok = false;
            $this->db->trans_rollback();


        }


    }
    public function onay_mailleri($subject, $message, $recipients, $tip)
    {

        $attachmenttrue = false;
        $attachment = '';


        $this->communication_model->onay_mail($recipients, $subject, $message, $attachmenttrue, $attachment, $tip);
        return 1;

    }

    public function satinalmaemri_print()

    {

        $tid = $this->input->get('id');

        $data['id'] = $tid;


        $data['invoice'] = $this->requested->invoice_details($tid, $this->limited);

        if ($data['invoice']) $data['products'] = $this->requested->invoice_products($tid);


        ini_set('memory_limit', '64M');


        $html = $this->load->view('form/satinalma_emri_view-print-' . LTR, $data, true);
        $header = $this->load->view('form/satinalma_emri_header-print-' . LTR, $data, true);
        $footer = $this->load->view('form/satinalma_emri_footer-print-' . LTR, $data, true);

        //PDF Rendering

        $this->load->library('pdf');


        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter($footer);
        $pdf->AddPage(
            'L', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            78, // margin top
            '72', // margin bottom
            5, 2, 0, 0, // margin header
            'auto'); // margin footer

        $pdf->WriteHTML($html);


        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'Talep__' . $data['invoice']['name'] . '_' . $data['invoice']['id']);

        if ($this->input->get('d')) {


            $pdf->Output($file_name . '.pdf', 'D');

        } else {

            $pdf->Output($file_name . '.pdf', 'I');

        }


    }

    // AVANS TALEP FORMU
    public function avans_talep_islem_bitir()
    {
        $talep_id = $this->input->post('talep_id');
        $kullanici = $this->input->post('pers_id');
        $yeni_pers_id = '';
        $proje_muduru_email = '';
        $recipients = array();
        $text_message='';
        $mobile='';
        $message='';


        $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and (proje_sorumlusu_id=$kullanici or proje_muduru_id=$kullanici  or bolum_mudur_id=$kullanici or genel_mudur_id=$kullanici  or finans_departman_pers_id=$kullanici) ");

        $subject = 'Avans Talep Formu Hk.';

        $talep_no=$query->row()->proje_name.'-'.$query->row()->talep_no;
        $dbnames = $this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
        $firma_kodu = $dbnames['firma_kodu'];
        $validtoken = hash_hmac('ripemd160', 'p' . $talep_id, $this->config->item('encryption_key'));

        if ($query->row()->proje_sorumlusu_id == $kullanici)    //proje sorumlusu onayladı
        {
            $yeni_pers_id = $query->row()->proje_muduru_id;
            $yeni_pers_id_email = personel_detailsa($yeni_pers_id)['email'];

            $recipients = array($yeni_pers_id_email);
            $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Proje Sorumlusu Tarafından Değiştirildi.';
            $mobile = personel_detailsa($yeni_pers_id)['phone'];
            $text_message=$query->row()->talep_no . '  Talep Formunu Proje Sorumlusu Tarafından Değiştirildi.';
        }
        if ($query->row()->proje_muduru_id == $kullanici)    //proje müdürü onayladı
        {
            $yeni_pers_id = $query->row()->bolum_mudur_id;
            $yeni_pers_id_email = personel_detailsa($yeni_pers_id)['email'];
            $recipients = array($yeni_pers_id_email);
            $mobile = personel_detailsa($yeni_pers_id)['phone'];
            $text_message=$query->row()->talep_no . '  Talep Formunu Proje Sorumlusu Tarafından Değiştirildi.';
            $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Proje Müdürü Tarafından Değiştirildi.';
        }
        if ($query->row()->bolum_mudur_id == $kullanici)    //proje bolum_mduru onayladı
        {
            $yeni_pers_id = $query->row()->genel_mudur_id;
            $yeni_pers_id_email = personel_detailsa($yeni_pers_id)['email'];
            $recipients = array($yeni_pers_id_email);
            $mobile = personel_detailsa($yeni_pers_id)['phone'];
            $text_message=$query->row()->talep_no . '  Talep Formunu Proje Sorumlusu Tarafından Değiştirildi.';
            $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Bölüm Müdürü Tarafından Değiştirildi.';
        }
        if ($query->row()->genel_mudur_id == $kullanici)    //genel müdür onayladı
        {
            $yeni_pers_id = $query->row()->finans_departman_pers_id;
            $yeni_pers_id_email = personel_detailsa($yeni_pers_id)['email'];
            $recipients = array($yeni_pers_id_email);
            $mobile = personel_detailsa($yeni_pers_id)['phone'];
            $text_message=$query->row()->talep_no . '  Talep Formunu Genel Müdür  Tarafından Değiştirildi.';
            $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Genel Müdürü Tarafından Değiştirildi.';
        }


        $text_message.="İncelemek İçin Aşağıdaki Linke Tıklayınız. https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$talep_id&pers_id=$yeni_pers_id&type=avans_talep_formu_onay&token=$validtoken";
        $href = "https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$talep_id&pers_id=$yeni_pers_id&type=avans_talep_formu_onay&token=$validtoken";
        $message .= "<br>Avans Talep Formunu İncelemek icin<a href='$href'>Tiklayiniz</a>";


        $message .= "<br><br><br><br>";
        $message .= "Sizlerin İncelemesi Beklenmektedir.";
        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');


        // eğer personeller onayladıysa kimseye mail atma

        $qrs = $this->db->query("SELECT * FROM `geopos_onay`  where geopos_onay.file_id=$talep_id and geopos_onay.type=5 and (proje_sorumlusu_status=1 or proje_muduru_status=1 or genel_mudur_status=1 or finans_status=1 or bolum_muduru_status=1)");



        if($qrs->num_rows()>0)
        {
            if($href!='')
            {


                if ($query->row()->finans_departman_pers_id == $kullanici)
                {
                    $genel_mudur_onay_kontrol=$this->db->query("SELECT * FROM `geopos_onay` Where  file_id=$talep_id")->result();
                    $onay_sayi=count($genel_mudur_onay_kontrol);
                    $onay=0;
                    $iptal=0;
                    foreach ($genel_mudur_onay_kontrol as $knt)
                    {
                        if($knt->genel_mudur_status==3)
                        {
                            $onay++;
                        }
                        else if($knt->genel_mudur_status==4)
                        {
                            $iptal++;
                        }
                    }



                    if($onay==$onay_sayi)
                    {
                        $this->db->set('status', 3);
                        $this->db->where('id', $talep_id);
                        $this->db->update('geopos_talep');
                    }
                    else if ($iptal==$onay_sayi)
                    {
                        $this->db->set('status', 4);
                        $this->db->where('id', $talep_id);
                        $this->db->update('geopos_talep');
                    }
                    else
                    {
                        $this->db->set('status', 5);
                        $this->db->where('id', $talep_id);
                        $this->db->update('geopos_talep');
                    }

                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
                }
                else
                {
                    if($this->onay_mailleri($subject, $message, $recipients, 'avans_talep_onay_maili', $talep_id))
                    {
                        if($href!='')
                        {
                            $short_url = $this->getSmallLink($href);
                            $mesaj=$talep_no." Numaralı Avans Talep Formunu Incelemek icin tiklayiniz. ".$short_url;
                            $message = $this->mesaj_gonder($mobile,$mesaj);
                        }

                        echo json_encode(array('status' => 'Success', 'message' =>
                            $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
                    }
                }

            }
            else
            {
                echo json_encode(array('status' => 'Error', 'message' => 'Mail Gönderilirken Hata Oluştu.Lütren Daha Sonra İşlemi Bitirmeyi Tekrar Deneyiniz.', 'pstatus' => ''));
            }

        }

        else
        {
            if ($query->row()->finans_departman_pers_id == $kullanici)
            {
                $qrs = $this->db->query("SELECT * FROM `geopos_onay`  where geopos_onay.file_id=$talep_id and geopos_onay.type=5");
                $this->db->set('status', $qrs->row()->finans_status);
                $this->db->where('id', $talep_id);
                $this->db->update('geopos_talep');

            }

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
        }



        // Mail Gönderme
    }
    public function avans_talep_product_status()
    {

        $talep_id = $this->input->post('talep_id');
        $product_id = $this->input->post('product_id');
        $kullanici = $this->input->post('pers_id');
        $status = $this->input->post('status');
        $note = $this->input->post('note');
        $price = $this->input->post('price');
        $tip = $this->input->post('tip');
        $subject='';
        $message='';
        $recipients=array();


        $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and (proje_sorumlusu_id=$kullanici or proje_muduru_id=$kullanici  or bolum_mudur_id=$kullanici or genel_mudur_id=$kullanici  or finans_departman_pers_id=$kullanici) ");

        if ($query->num_rows() > 0) {

            $this->db->set('price', $price);
            $this->db->where('id', $product_id);
            $this->db->update('geopos_talep_items');

            if ($query->row()->proje_sorumlusu_id == $kullanici)    //proje sorumlusu onayladı
            {



                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('proje_sorumlusu_status	', $status);
                    $this->db->set('proje_sorumlusu_status_note', $note);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->where('malzeme_items_id', $product_id);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'proje_sorumlusu_status' => $status,
                        'malzeme_items_id' => $product_id,
                        'proje_sorumlusu_status_note' => $note,
                        'file_id' => $talep_id,
                        'type' => $tip);

                    $this->db->insert('geopos_onay', $data);
                }


                $subject = 'Avans Talep Formu Hk.';
                $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunda Bazı Ürünler Proje Sorumlusu Tarafından Onay Almamıştır.Detaylı Bilgi İçin Gider Talep Formunu İnceleyiniz.';
                $message .= "<br><br><br><br>";
                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
                $talep_olusturan_pers_id = $query->row()->talep_olusturan_pers_id;
                $talep_eden_pers_id = $query->row()->talep_eden_pers_id;
                $talep_olusturan_pers_id_email = personel_detailsa($talep_olusturan_pers_id)['email'];
                $talep_eden_pers_id_email = personel_detailsa($talep_eden_pers_id)['email'];

                $recipients = array($talep_olusturan_pers_id_email,$talep_eden_pers_id_email);



            }

            if ($query->row()->proje_muduru_id == $kullanici)    //proje Müdürü onayladı
            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('proje_muduru_status	', $status);
                    $this->db->set('proje_muduru_status_note', $note);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->where('malzeme_items_id', $product_id);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'proje_muduru_status' => $status,
                        'proje_muduru_status_note' => $note,
                        'malzeme_items_id' => $product_id,
                        'file_id' => $talep_id,
                        'type' => $tip);

                    $this->db->insert('geopos_onay', $data);
                }





                $subject = 'Avans Talep Formu Hk.';
                $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunda Bazı Ürünler Proje Müdürü Tarafından Onay Almamıştır.Detaylı Bilgi İçin Gider Talep Formunu İnceleyiniz.';
                $message .= "<br><br><br><br>";
                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $talep_olusturan_pers_id = $query->row()->talep_olusturan_pers_id;
                $talep_eden_pers_id = $query->row()->talep_eden_pers_id;
                $talep_olusturan_pers_id_email = personel_detailsa($talep_olusturan_pers_id)['email'];
                $talep_eden_pers_id_email = personel_detailsa($talep_eden_pers_id)['email'];

                $recipients = array($talep_olusturan_pers_id_email,$talep_eden_pers_id_email);



            }


            if ($query->row()->bolum_mudur_id == $kullanici)  //Bölüm Müdürü onayladı

            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id  and malzeme_items_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('bolum_muduru_status', $status);
                    $this->db->set('bolum_muduru_status_note', $note);
                    $this->db->set('malzeme_items_id', $product_id);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'proje_muduru_status' => $status,
                        'bolum_muduru_status_note' => $note,
                        'malzeme_items_id' => $product_id,
                        'file_id' => $talep_id,
                        'type' => $tip);

                    $this->db->insert('geopos_onay', $data);
                }

                // Mail Gönderme



                $subject = 'Avans Talep Formu Hk.';
                $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunda Bazı Ürünler Bölüm Müdürü Tarafından Onay Almamıştır.Detaylı Bilgi İçin Gider Talep Formunu İnceleyiniz.';
                $message .= "<br><br><br><br>";
                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $talep_olusturan_pers_id = $query->row()->talep_olusturan_pers_id;
                $talep_eden_pers_id = $query->row()->talep_eden_pers_id;
                $talep_olusturan_pers_id_email = personel_detailsa($talep_olusturan_pers_id)['email'];
                $talep_eden_pers_id_email = personel_detailsa($talep_eden_pers_id)['email'];
                $recipients = array($talep_olusturan_pers_id_email,$talep_eden_pers_id_email);


            }

            if ($query->row()->genel_mudur_id == $kullanici)  //Genel Müdürü onayladı

            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id  and malzeme_items_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('genel_mudur_status', $status);
                    $this->db->set('genel_mudur_status_note', $note);
                    $this->db->set('malzeme_items_id', $product_id);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'genel_mudur_status' => $status,
                        'genel_mudur_status_note' => $note,
                        'malzeme_items_id' => $product_id,
                        'file_id' => $talep_id,
                        'type' => $tip);

                    $this->db->insert('geopos_onay', $data);
                }

                // Mail Gönderme

                $subject = 'Avans Talep Formu Hk.';
                $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunda Bazı Ürünler Genel Müdürü Tarafından Onay Almamıştır.Detaylı Bilgi İçin Gider Talep Formunu İnceleyiniz.';
                $message .= "<br><br><br><br>";
                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $talep_olusturan_pers_id = $query->row()->talep_olusturan_pers_id;
                $talep_eden_pers_id = $query->row()->talep_eden_pers_id;
                $talep_olusturan_pers_id_email = personel_detailsa($talep_olusturan_pers_id)['email'];
                $talep_eden_pers_id_email = personel_detailsa($talep_eden_pers_id)['email'];
                $recipients = array($talep_olusturan_pers_id_email,$talep_eden_pers_id_email);


            }

            if ($query->row()->finans_departman_pers_id == $kullanici)  //Finans Departnanı onayladı
            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id  and malzeme_items_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('finans_status', $status);
                    $this->db->set('finans_status_note', $note);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('malzeme_items_id', $product_id);
                    $this->db->where('type', $tip);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'finans_status' => $status,
                        'finans_status_note' => $note,
                        'malzeme_items_id' => $malzeme_items_id,
                        'file_id' => $talep_id,
                        'type' => $tip);

                    $this->db->insert('geopos_onay', $data);
                }

                // Mail Gönderme

                $subject = 'Avans Talep Formu Hk.';
                $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunda Bazı Ürünler Genel Müdürü Tarafından Onay Almamıştır.Detaylı Bilgi İçin Gider Talep Formunu İnceleyiniz.';
                $message .= "<br><br><br><br>";
                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $talep_olusturan_pers_id = $query->row()->talep_olusturan_pers_id;
                $talep_eden_pers_id = $query->row()->talep_eden_pers_id;
                $talep_olusturan_pers_id_email = personel_detailsa($talep_olusturan_pers_id)['email'];
                $talep_eden_pers_id_email = personel_detailsa($talep_eden_pers_id)['email'];
                $recipients = array($talep_olusturan_pers_id_email,$talep_eden_pers_id_email);


            }


            if($status==3)
            {
                if ($this->onay_mailleri($subject, $message, $recipients, 'avans_talep_onay_maili', $talep_id)) {
                    echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Onaylandı', 'pstatus' => $status));
                }

            }
            else if($status==4) {

                echo json_encode(array('status' => 'Warning', 'message' => 'Başarıyla İptal İşleminiz Gerçekleşti', 'pstatus' => $status));
            }

        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Onaylamak İçin Yetkiniz Yoktur.', 'pstatus' => ''));
        }




    }
    public function avans_talep_product_status_toplu()
    {
        $talep_id = $this->input->post('talep_id')[0];
        $product_id = $this->input->post('product_id');
        $kullanici = $this->input->post('pers_id')[0];
        $note = $this->input->post('note');
        $price = $this->input->post('price');
        $status = 3;
        $tip =5;
        $ind=0;

        $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and (proje_sorumlusu_id=$kullanici or proje_muduru_id=$kullanici  or bolum_mudur_id=$kullanici or genel_mudur_id=$kullanici  or finans_departman_pers_id=$kullanici ) ");
        if ($query->num_rows() > 0)
        {
            if ($query->row()->proje_sorumlusu_id == $kullanici)    //proje sorumlusu onayladı
            {
                $ind=0;
                foreach ($product_id as $key=>$value)
                {
                    $this->db->set('price', $price[$key]);
                    $this->db->where('id', $value);
                    $this->db->update('geopos_talep_items');


                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('proje_sorumlusu_status	', $status);
                        $this->db->set('proje_sorumlusu_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('malzeme_items_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'proje_sorumlusu_status' => $status,
                            'malzeme_items_id' => $value,
                            'proje_sorumlusu_status_note' => $note[$key],
                            'file_id' => $talep_id,
                            'type' => $tip);

                        $this->db->insert('geopos_onay', $data);
                    }
                    $ind++;
                }



            }
            if ($query->row()->proje_muduru_id == $kullanici)    //proje müdürü onayladı
            {
                $ind=0;
                foreach ($product_id as $key=>$value)
                {
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('proje_muduru_status	', $status);
                        $this->db->set('proje_muduru_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('malzeme_items_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'proje_muduru_status' => $status,
                            'malzeme_items_id' => $value,
                            'proje_muduru_status_note' => $note[$key],
                            'file_id' => $talep_id,
                            'type' => $tip);

                        $this->db->insert('geopos_onay', $data);
                    }
                    $ind++;
                }



            }
            if ($query->row()->bolum_mudur_id == $kullanici)    //bolum müdürü onayladı
            {
                $ind=0;
                foreach ($product_id as $key=>$value)
                {
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('bolum_muduru_status	', $status);
                        $this->db->set('bolum_muduru_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('malzeme_items_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'bolum_muduru_status' => $status,
                            'malzeme_items_id' => $value,
                            'bolum_muduru_status_note' => $note[$key],
                            'file_id' => $talep_id,
                            'type' => $tip);

                        $this->db->insert('geopos_onay', $data);
                    }
                    $ind++;
                }



            }
            if ($query->row()->genel_mudur_id == $kullanici)    //genel müdürü onayladı
            {
                $ind=0;
                foreach ($product_id as $key=>$value)
                {
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('genel_mudur_status', $status);
                        $this->db->set('open', 1);
                        $this->db->set('genel_mudur_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('malzeme_items_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'genel_mudur_status' => $status,
                            'malzeme_items_id' => $value,
                            'genel_mudur_status_note' => $note[$key],
                            'file_id' => $talep_id,
                            'type' => $tip);

                        $this->db->insert('geopos_onay', $data);
                    }
                    $ind++;
                }



            }
            if ($query->row()->finans_departman_pers_id == $kullanici)    //finans müdürü onayladı
            {
                $ind=0;
                foreach ($product_id as $key=>$value)
                {
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('finans_status', $status);
                        $this->db->set('finans_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('malzeme_items_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'finans_status' => $status,
                            'malzeme_items_id' => $value,
                            'finans_status_note' => $note[$key],
                            'file_id' => $talep_id,
                            'type' => $tip);

                        $this->db->insert('geopos_onay', $data);
                    }
                    $ind++;
                }



            }

            if($ind>0)
            {
                echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Onaylandı.Bekleyiniz...', 'pstatus' => $status));
            }
        }
    }

    // AVANS TALEP FORMU


    // MALZEME TALEP FORMU
    public function malzeme_talep_product_status_toplu()
    {
        $talep_id = $this->input->post('talep_id')[0];
        $product_id = $this->input->post('product_id');
        $depo_mik = $this->input->post('depo_var_olan_mik');
        $satin_alma_='';
        if($this->input->post('satin_alma_'))
        {
            $satin_alma_ = $this->input->post('satin_alma_');
        }

        $kullanici = $this->input->post('pers_id')[0];
        $note = $this->input->post('note');
        $status = 3;
        $tip =1;
        $ind=0;

        if (in_array("0", $satin_alma_)) {
            echo json_encode(array('status' => 'Error', 'message' =>'Satın Alma Personeli Seçiniz', 'pstatus' => $status));
        }
        else
        {
            date_default_timezone_set('Asia/Baku');

            $date = new DateTime('now');
            $date_saat=$date->format('Y-m-d H:i:s');

            $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and (proje_sorumlusu_id=$kullanici or proje_muduru_id=$kullanici  or bolum_mudur_id=$kullanici or genel_mudur_id=$kullanici) ");
            if ($query->num_rows() > 0)
            {
                if ($query->row()->proje_sorumlusu_id == $kullanici)    //proje sorumlusu onayladı
                {
                    $ind=0;
                    foreach ($product_id as $key=>$value)
                    {

                        $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                        if ($onay_kontrol->num_rows() > 0) {
                            //update
                            $this->db->set('satinalma_yonlendirme', $satin_alma_[$key]);
                            $this->db->set('proje_sorumlusu_status	', $status);
                            $this->db->set('proje_sorumlusu_onay_saati	', $date_saat);
                            $this->db->set('proje_sorumlusu_status_note', $note[$key]);
                            $this->db->where('file_id', $talep_id);
                            $this->db->where('type', 1);
                            $this->db->where('malzeme_items_id', $value);
                            $this->db->update('geopos_onay');


                        } else {
                            //insert
                            $data = array(
                                'satinalma_yonlendirme' => $satin_alma_[$key],
                                'proje_sorumlusu_status' => $status,
                                'proje_sorumlusu_onay_saati' => $date_saat,
                                'malzeme_items_id' => $value,
                                'proje_sorumlusu_status_note' => $note[$key],
                                'file_id' => $talep_id,
                                'type' => 1);

                            $this->db->insert('geopos_onay', $data);
                        }
                        $ind++;
                    }



                }
                if ($query->row()->proje_muduru_id == $kullanici)    //proje müdürü onayladı
                {
                    $ind=0;
                    foreach ($product_id as $key=>$value)
                    {
                        $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                        if ($onay_kontrol->num_rows() > 0) {
                            //update
                            $this->db->set('satinalma_yonlendirme', $satin_alma_[$key]);
                            $this->db->set('proje_muduru_status	', $status);
                            $this->db->set('proje_muduru_onay_saati	', $date_saat);
                            $this->db->set('proje_muduru_status_note', $note[$key]);
                            $this->db->where('file_id', $talep_id);
                            $this->db->where('type', 1);
                            $this->db->where('malzeme_items_id', $value);
                            $this->db->update('geopos_onay');


                        } else {
                            //insert
                            $data = array(
                                'satinalma_yonlendirme' => $satin_alma_[$key],
                                'proje_muduru_status' => $status,
                                'proje_muduru_onay_saati' => $date_saat,
                                'malzeme_items_id' => $value,
                                'proje_muduru_status_note' => $note[$key],
                                'file_id' => $talep_id,
                                'type' => 1);

                            $this->db->insert('geopos_onay', $data);
                        }
                        $ind++;
                    }



                }
                if ($query->row()->bolum_mudur_id == $kullanici)    //depo müdürü onayladı
                {
                    $ind=0;
                    foreach ($product_id as $key=>$value)
                    {
                        $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                        if ($onay_kontrol->num_rows() > 0) {
                            //update
                            $this->db->set('satinalma_yonlendirme', $satin_alma_[$key]);
                            $this->db->set('bolum_muduru_status	', $status);
                            $this->db->set('depoda_bulunan_mik	', $depo_mik[$key]);
                            $this->db->set('bolum_muduru_saati	', $date_saat);
                            $this->db->set('bolum_muduru_status_note', $note[$key]);
                            $this->db->where('file_id', $talep_id);
                            $this->db->where('type', 1);
                            $this->db->where('malzeme_items_id', $value);
                            $this->db->update('geopos_onay');


                        } else {
                            //insert
                            $data = array(
                                'satinalma_yonlendirme' => $satin_alma_[$key],
                                'depoda_bulunan_mik' => $depo_mik[$key],
                                'bolum_muduru_status' => $status,
                                'malzeme_items_id' => $value,
                                'bolum_muduru_saati' => $date_saat,
                                'bolum_muduru_status_note' => $note[$key],
                                'file_id' => $talep_id,
                                'type' => 1);

                            $this->db->insert('geopos_onay', $data);
                        }
                        $ind++;
                    }



                }
                if ($query->row()->genel_mudur_id == $kullanici)    //genel müdürü onayladı
                {
                    $ind=0;
                    foreach ($product_id as $key=>$value)
                    {
                        $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                        if ($onay_kontrol->num_rows() > 0) {

                            //update
                            $this->db->set('satinalma_yonlendirme', $satin_alma_[$key]);
                            $this->db->set('genel_mudur_status	', $status);
                            $this->db->set('open',1);
                            $this->db->set('genel_mudur_onay_saati', $date_saat);
                            $this->db->set('genel_mudur_status_note', $note[$key]);
                            $this->db->where('file_id', $talep_id);
                            $this->db->where('type', 1);
                            $this->db->where('malzeme_items_id', $value);
                            $this->db->update('geopos_onay');


                        } else {
                            //insert
                            $data = array(
                                'satinalma_yonlendirme' => $satin_alma_[$key],
                                'genel_mudur_status' => $status,
                                'genel_mudur_onay_saati' => $date_saat,
                                'malzeme_items_id' => $value,
                                'genel_mudur_status_note' => $note[$key],
                                'file_id' => $talep_id,
                                'type' => 1);

                            $this->db->insert('geopos_onay', $data);
                        }
                        $ind++;
                    }



                }

                if($ind>0)
                {
                    echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Onaylandı.Bekleyiniz...', 'pstatus' => $status));
                }
            }
            else
            {
                echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Yoktur...', 'pstatus' => $status));
            }
        }




    }
    public function malzeme_talep_product_status_toplu_iptal()
    {
        $talep_id = $this->input->post('talep_id')[0];
        $product_id = $this->input->post('product_id');
        $depo_mik = $this->input->post('depo_var_olan_mik');
        $satin_alma_='';
        if($this->input->post('satin_alma_'))
        {
            $satin_alma_ = $this->input->post('satin_alma_');
        }

        $kullanici = $this->input->post('pers_id')[0];
        $note = $this->input->post('note');
        $status = 4;
        $tip =1;
        $ind=0;

        date_default_timezone_set('Asia/Baku');

        $date = new DateTime('now');
        $date_saat=$date->format('Y-m-d H:i:s');

        $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and (proje_sorumlusu_id=$kullanici or proje_muduru_id=$kullanici  or bolum_mudur_id=$kullanici or genel_mudur_id=$kullanici) ");
        if ($query->num_rows() > 0)
        {
            if ($query->row()->proje_sorumlusu_id == $kullanici)    //proje sorumlusu onayladı
            {
                $ind=0;
                foreach ($product_id as $key=>$value)
                {
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('satinalma_yonlendirme', $satin_alma_[$key]);
                        $this->db->set('proje_sorumlusu_status	', $status);
                        $this->db->set('proje_sorumlusu_onay_saati	', $date_saat);
                        $this->db->set('proje_sorumlusu_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', 1);
                        $this->db->where('malzeme_items_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'satinalma_yonlendirme' => $satin_alma_[$key],
                            'proje_sorumlusu_status' => $status,
                            'proje_sorumlusu_onay_saati' => $date_saat,
                            'malzeme_items_id' => $value,
                            'proje_sorumlusu_status_note' => $note[$key],
                            'file_id' => $talep_id,
                            'type' => 1);

                        $this->db->insert('geopos_onay', $data);
                    }
                    $ind++;
                }



            }
            if ($query->row()->proje_muduru_id == $kullanici)    //proje müdürü onayladı
            {
                $ind=0;
                foreach ($product_id as $key=>$value)
                {
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('satinalma_yonlendirme', $satin_alma_[$key]);
                        $this->db->set('proje_muduru_status	', $status);
                        $this->db->set('proje_muduru_onay_saati	', $date_saat);
                        $this->db->set('proje_muduru_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', 1);
                        $this->db->where('malzeme_items_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'satinalma_yonlendirme' => $satin_alma_[$key],
                            'proje_muduru_status' => $status,
                            'proje_muduru_onay_saati' => $date_saat,
                            'malzeme_items_id' => $value,
                            'proje_muduru_status_note' => $note[$key],
                            'file_id' => $talep_id,
                            'type' => 1);

                        $this->db->insert('geopos_onay', $data);
                    }
                    $ind++;
                }



            }
            if ($query->row()->bolum_mudur_id == $kullanici)    //depo müdürü onayladı
            {

                $ind=0;
                foreach ($product_id as $key=>$value)
                {
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('satinalma_yonlendirme', $satin_alma_[$key]);
                        $this->db->set('depoda_bulunan_mik', $depo_mik[$key]);
                        $this->db->set('bolum_muduru_status	', $status);
                        $this->db->set('bolum_muduru_saati	', $date_saat);
                        $this->db->set('bolum_muduru_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', 1);
                        $this->db->where('malzeme_items_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'satinalma_yonlendirme' => $satin_alma_[$key],
                            'depoda_bulunan_mik' => $depo_mik[$key],
                            'bolum_muduru_status' => $status,
                            'malzeme_items_id' => $value,
                            'bolum_muduru_saati' => $date_saat,
                            'bolum_muduru_status_note' => $note[$key],
                            'file_id' => $talep_id,
                            'type' => 1);

                        $this->db->insert('geopos_onay', $data);
                    }
                    $ind++;
                }



            }
            if ($query->row()->genel_mudur_id == $kullanici)    //genel müdürü onayladı
            {
                $ind=0;
                foreach ($product_id as $key=>$value)
                {
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {

                        //update
                        $this->db->set('satinalma_yonlendirme', $satin_alma_[$key]);
                        $this->db->set('genel_mudur_status	', $status);
                        $this->db->set('open', 1);
                        $this->db->set('genel_mudur_onay_saati', $date_saat);
                        $this->db->set('genel_mudur_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', 1);
                        $this->db->where('malzeme_items_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'satinalma_yonlendirme' => $satin_alma_[$key],
                            'genel_mudur_status' => $status,
                            'genel_mudur_onay_saati' => $date_saat,
                            'malzeme_items_id' => $value,
                            'genel_mudur_status_note' => $note[$key],
                            'file_id' => $talep_id,
                            'type' => 1);

                        $this->db->insert('geopos_onay', $data);
                    }
                    $ind++;
                }



            }

            if($ind>0)
            {
                echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla İptal Edildi.Bekleyiniz...', 'pstatus' => $status));
            }
        }
        else
        {
            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Yoktur...', 'pstatus' => $status));
        }
    }
    public function malzeme_talep_product_status()
    {

        $satin_alma_='';
        if($this->input->post('satin_alma_'))
        {
            $satin_alma_ = $this->input->post('satin_alma_');
        }
        $talep_id = $this->input->post('talep_id');

        $depo_mik = $this->input->post('depo_mik');


        $product_id = $this->input->post('product_id');
        $kullanici = $this->input->post('pers_id');
        $status = $this->input->post('status');
        $note = $this->input->post('note');
        $tip = $this->input->post('tip');
        $subject='';
        $message='';
        $recipients=array();
        date_default_timezone_set('Asia/Baku');

        $date = new DateTime('now');
        $date_saat=$date->format('Y-m-d H:i:s');


        $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and (proje_sorumlusu_id=$kullanici or proje_muduru_id=$kullanici  or bolum_mudur_id=$kullanici or genel_mudur_id=$kullanici) ");

        if ($query->num_rows() > 0) {

            if ($query->row()->proje_sorumlusu_id == $kullanici)    //proje sorumlusu onayladı
            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('satinalma_yonlendirme', $satin_alma_);
                    $this->db->set('proje_sorumlusu_status	', $status);
                    $this->db->set('proje_sorumlusu_status_note', $note);
                    $this->db->set('proje_sorumlusu_onay_saati', $date_saat);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 1);
                    $this->db->where('malzeme_items_id', $product_id);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'satinalma_yonlendirme' => $satin_alma_,
                        'proje_sorumlusu_status' => $status,
                        'proje_sorumlusu_onay_saati' => $date_saat,
                        'malzeme_items_id' => $product_id,
                        'proje_sorumlusu_status_note' => $note,
                        'file_id' => $talep_id,
                        'type' => 1);

                    $this->db->insert('geopos_onay', $data);
                }





            }

            if ($query->row()->proje_muduru_id == $kullanici)    //proje Müdürü onayladı
            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('satinalma_yonlendirme', $satin_alma_);
                    $this->db->set('proje_muduru_status	', $status);
                    $this->db->set('proje_muduru_status_note', $note);
                    $this->db->set('proje_muduru_onay_saati', $date_saat);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 1);
                    $this->db->where('malzeme_items_id', $product_id);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'satinalma_yonlendirme' => $satin_alma_,
                        'proje_muduru_status' => $status,
                        'proje_muduru_onay_saati' => $date_saat,
                        'proje_muduru_status_note' => $note,
                        'malzeme_items_id' => $product_id,
                        'file_id' => $talep_id,
                        'type' => 1);

                    $this->db->insert('geopos_onay', $data);
                }






            }


            if ($query->row()->bolum_mudur_id == $kullanici)  //Depo Müdürü onayladı
            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=1 and file_id=$talep_id  and malzeme_items_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('satinalma_yonlendirme', $satin_alma_);
                    $this->db->set('depoda_bulunan_mik', $depo_mik);
                    $this->db->set('bolum_muduru_status', $status);
                    $this->db->set('bolum_muduru_saati', $date_saat);
                    $this->db->set('bolum_muduru_status_note', $note);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('malzeme_items_id', $product_id);
                    $this->db->where('type', 1);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'satinalma_yonlendirme' => $satin_alma_,
                        'depoda_bulunan_mik' => $depo_mik,
                        'proje_muduru_status' => $status,
                        'bolum_muduru_status_note' => $note,
                        'bolum_muduru_saati' => $date_saat,
                        'malzeme_items_id' => $product_id,
                        'file_id' => $talep_id,
                        'type' => 1);

                    $this->db->insert('geopos_onay', $data);
                }




            }

            if ($query->row()->genel_mudur_id == $kullanici)  //Genel Müdürü onayladı

            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=1 and file_id=$talep_id  and malzeme_items_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('satinalma_yonlendirme', $satin_alma_);
                    $this->db->set('genel_mudur_status', $status);
                    $this->db->set('genel_mudur_status_note', $note);
                    $this->db->set('genel_mudur_onay_saati', $date_saat);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('malzeme_items_id', $product_id);
                    $this->db->where('type', 1);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'satinalma_yonlendirme' => $satin_alma_,
                        'genel_mudur_status' => $status,
                        'genel_mudur_status_note' => $note,
                        'genel_mudur_onay_saati' => $date_saat,
                        'malzeme_items_id' => $product_id,
                        'file_id' => $talep_id,
                        'type' => 1);

                    $this->db->insert('geopos_onay', $data);
                }
            }


            if($status==3)
            {
                echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Onaylandı.İşlem Bitire Basmayı Unutmayınız', 'pstatus' => $status));
            }
            else if($status==4) {
                echo json_encode(array('status' => 'Warning', 'message' => 'Başarıyla İptal İşleminiz Gerçekleşti.İşlem Bitire Basmayı Unutmayınız', 'pstatus' => $status));
            }

        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Onaylamak İçin Yetkiniz Yoktur.', 'pstatus' => ''));
        }




    }
    public function malzeme_talep_islem_bitir()
    {
        $talep_id = $this->input->post('talep_id');
        $kullanici = $this->input->post('pers_id');
        $yeni_pers_id = '';
        $proje_muduru_email = '';
        $recipients = array();
        $text_message='';
        $mobile='';
        $href='';



        $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and (proje_sorumlusu_id=$kullanici or proje_muduru_id=$kullanici  or bolum_mudur_id=$kullanici or genel_mudur_id=$kullanici) ");

        $subject = 'Talep Formu Hk.';


        $talep_no=$query->row()->proje_name.'-'.$query->row()->talep_no;
        $dbnames = $this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
        $firma_kodu = $dbnames['firma_kodu'];
        $validtoken = hash_hmac('ripemd160', 'p' . $talep_id, $this->config->item('encryption_key'));

        if ($query->row()->proje_sorumlusu_id == $kullanici)    //proje sorumlusu onayladı
        {
            $yeni_pers_id = $query->row()->proje_muduru_id;
            $yeni_pers_id_email = personel_detailsa($yeni_pers_id)['email'];

            $recipients = array($yeni_pers_id_email);
            $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Proje Sorumlusu Tarafından Değiştirildi.';
            $mobile = personel_detailsa($yeni_pers_id)['phone'];
            $text_message=$query->row()->talep_no . '  Talep Formunu Proje Sorumlusu Tarafından Değiştirildi.';
        }
        if ($query->row()->proje_muduru_id == $kullanici)    //proje müdürü onayladı
        {
            $yeni_pers_id = $query->row()->bolum_mudur_id;
            $yeni_pers_id_email = personel_detailsa($yeni_pers_id)['email'];
            $recipients = array($yeni_pers_id_email);
            $mobile = personel_detailsa($yeni_pers_id)['phone'];
            $text_message=$query->row()->talep_no . '  Talep Formunu Proje Sorumlusu Tarafından Değiştirildi.';
            $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Proje Müdürü Tarafından Değiştirildi.';
        }

        if ($query->row()->bolum_mudur_id == $kullanici)    //proje bolum_mduru onayladı
        {
            $yeni_pers_id = $query->row()->genel_mudur_id;
            $yeni_pers_id_email = personel_detailsa($yeni_pers_id)['email'];
            $recipients = array($yeni_pers_id_email);
            $mobile = personel_detailsa($yeni_pers_id)['phone'];
            $text_message=$query->row()->talep_no . '  Talep Formunu Proje Sorumlusu Tarafından Değiştirildi.';
            $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Bölüm Müdürü Tarafından Değiştirildi.';
        }
        if ($query->row()->genel_mudur_id == $kullanici)    //proje sorumlusu onayladı
        {


            $genel_mudur_onay_kontrol=$this->db->query("SELECT * FROM `geopos_onay` Where  file_id=$talep_id")->result();
            $onay_sayi=count($genel_mudur_onay_kontrol);
            $onay=0;
            $iptal=0;
            foreach ($genel_mudur_onay_kontrol as $knt)
            {
                if($knt->genel_mudur_status==3)
                {
                    $onay++;
                }
                else if($knt->genel_mudur_status==4)
                {
                    $iptal++;
                }
            }



            if($onay==$onay_sayi)
            {
                $this->db->set('status', 3);
                $this->db->where('id', $talep_id);
                $this->db->update('geopos_talep');
            }
            else if ($iptal==$onay_sayi)
            {
                $this->db->set('status', 4);
                $this->db->where('id', $talep_id);
                $this->db->update('geopos_talep');
            }
            else
            {
                $this->db->set('status', 5);
                $this->db->where('id', $talep_id);
                $this->db->update('geopos_talep');
            }




            $message_="";
            $recipients=array();
            $querys = $this->db->query("SELECT * FROM geopos_onay where file_id=$talep_id and  genel_mudur_status=3 GROUP BY satinalma_yonlendirme")->result();
            foreach ($querys as $querys_)
            {

                $recipients[]=$querys_->satinalma_yonlendirme;
                $talep=$query->row()->proje_name.'-'.$query->row()->talep_no;
                $mobile_ = personel_detailsa($querys_->satinalma_yonlendirme)['phone'];
                $email[] = personel_detailsa($querys_->satinalma_yonlendirme)['email'];
                $name = personel_detailsa($querys_->satinalma_yonlendirme)['name'];
                $mesaj="Sayın ".$name." ".$talep." Numaralı Malzeme Talep Formundan bazı ürünlerin satın alma islemi size atanmıştır.";
                //$message_=$this->mesaj_gonder($mobile_,$mesaj);

            }
            $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Malzeme Talep Formundan bazı ürünlerin satın alma islemi size atanmıştır.';

            if($this->onay_mailleri($subject, $message, $email, 'malzeme_talep_onay_maili'))
            {
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
                exit;
            }

            if($message_==1)
            {
            }

        }

        $message .= "<br><br><br><br>";
        $message .= "Sizlerin İncelemesi Beklenmektedir.";

        if ($query->row()->genel_mudur_id != $kullanici)
        {
            $text_message.="İncelemek İçin Aşağıdaki Linke Tıklayınız. https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$talep_id&pers_id=$yeni_pers_id&type=malzeme_talep_formu_onay&token=$validtoken";
            $href = "https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$talep_id&pers_id=$yeni_pers_id&type=malzeme_talep_formu_onay&token=$validtoken";
            $message .= "<br>İncelemek İçin<a href='$href'>Tıklayınız</a>";

        }
        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');



        if($this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili'))
        {

            if($mobile!='')
            {
                $short_url = $this->getSmallLink($href);
                $mesaj=$talep_no." Numaralı Malzeme Talep Formunu Incelemek icin tiklayiniz. ".$short_url;
                //$message = $this->mesaj_gonder($mobile,$mesaj);
            }


            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
        }
        else
        {
            echo json_encode(array('status' => 'Error', 'message' => 'Mail Gönderilirken Hata Oluştu.Lütren Daha Sonra İşlemi Bitirmeyi Tekrar Deneyiniz.', 'pstatus' => ''));
        }

        // Mail Gönderme
    }
    // MALZEME TALEP FORMU


    // GİDER TALEP FORMU
    public function gider_talep_islem_bitir()
    {
        $talep_id = $this->input->post('talep_id');
        $kullanici = $this->input->post('pers_id');
        $yeni_pers_id = '';
        $proje_muduru_email = '';
        $recipients = array();
        $text_message='';
        $mobile='';
        $message='';


        $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and (proje_sorumlusu_id=$kullanici or proje_muduru_id=$kullanici  or bolum_mudur_id=$kullanici or genel_mudur_id=$kullanici  or finans_departman_pers_id=$kullanici) ");

        $subject = 'Gider Talep Formu Hk.';

        $talep_no=$query->row()->proje_name.'-'.$query->row()->talep_no;
        $dbnames = $this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
        $firma_kodu = $dbnames['firma_kodu'];
        $validtoken = hash_hmac('ripemd160', 'p' . $talep_id, $this->config->item('encryption_key'));

        if ($query->row()->proje_sorumlusu_id == $kullanici)    //proje sorumlusu onayladı
        {
            $yeni_pers_id = $query->row()->proje_muduru_id;
            $yeni_pers_id_email = personel_detailsa($yeni_pers_id)['email'];

            $recipients = array($yeni_pers_id_email);
            $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Proje Sorumlusu Tarafından Değiştirildi.';
            $mobile = personel_detailsa($yeni_pers_id)['phone'];
            $text_message=$query->row()->talep_no . '  Talep Formunu Proje Sorumlusu Tarafından Değiştirildi.';
        }
        if ($query->row()->proje_muduru_id == $kullanici)    //proje müdürü onayladı
        {
            $yeni_pers_id = $query->row()->bolum_mudur_id;
            $yeni_pers_id_email = personel_detailsa($yeni_pers_id)['email'];
            $recipients = array($yeni_pers_id_email);
            $mobile = personel_detailsa($yeni_pers_id)['phone'];
            $text_message=$query->row()->talep_no . '  Talep Formunu Proje Sorumlusu Tarafından Değiştirildi.';
            $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Proje Müdürü Tarafından Değiştirildi.';
        }
        if ($query->row()->bolum_mudur_id == $kullanici)    //proje bolum_mduru onayladı
        {
            $yeni_pers_id = $query->row()->genel_mudur_id;
            $yeni_pers_id_email = personel_detailsa($yeni_pers_id)['email'];
            $recipients = array($yeni_pers_id_email);
            $mobile = personel_detailsa($yeni_pers_id)['phone'];
            $text_message=$query->row()->talep_no . '  Talep Formunu Proje Sorumlusu Tarafından Değiştirildi.';
            $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Bölüm Müdürü Tarafından Değiştirildi.';
        }
        if ($query->row()->genel_mudur_id == $kullanici)    //genel müdür onayladı
        {
            $yeni_pers_id = $query->row()->finans_departman_pers_id;
            $yeni_pers_id_email = personel_detailsa($yeni_pers_id)['email'];
            $recipients = array($yeni_pers_id_email);
            $mobile = personel_detailsa($yeni_pers_id)['phone'];
            $text_message=$query->row()->talep_no . '  Talep Formunu Genel Müdür  Tarafından Değiştirildi.';
            $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Genel Müdürü Tarafından Değiştirildi.';
        }


        $text_message.="İncelemek İçin Aşağıdaki Linke Tıklayınız. https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$talep_id&pers_id=$yeni_pers_id&type=gider_talep_formu_onay&token=$validtoken";
        $href = "https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$talep_id&pers_id=$yeni_pers_id&type=gider_talep_formu_onay&token=$validtoken";
        $message .= "<br>Gider Talep Formunu İncelemek icin<a href='$href'>Tiklayiniz</a>";


        $message .= "<br><br><br><br>";
        $message .= "Sizlerin İncelemesi Beklenmektedir.";
        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');


        // eğer personeller onayladıysa kimseye mail atma

        $qrs = $this->db->query("SELECT * FROM `geopos_onay`  where geopos_onay.file_id=$talep_id and geopos_onay.type=4 and (proje_sorumlusu_status=1 or proje_muduru_status=1 or genel_mudur_status=1 or finans_status=1 or bolum_muduru_status=1)");



        if($qrs->num_rows()>0)
        {
            if($href!='')
            {


                if ($query->row()->finans_departman_pers_id == $kullanici)
                {

                    $genel_mudur_onay_kontrol=$this->db->query("SELECT * FROM `geopos_onay` Where  file_id=$talep_id")->result();
                    $onay_sayi=count($genel_mudur_onay_kontrol);
                    $onay=0;
                    $iptal=0;
                    foreach ($genel_mudur_onay_kontrol as $knt)
                    {
                        if($knt->genel_mudur_status==3)
                        {
                            $onay++;
                        }
                        else if($knt->genel_mudur_status==4)
                        {
                            $iptal++;
                        }
                    }



                    if($onay==$onay_sayi)
                    {
                        $this->db->set('status', 3);
                        $this->db->where('id', $talep_id);
                        $this->db->update('geopos_talep');
                    }
                    else if ($iptal==$onay_sayi)
                    {
                        $this->db->set('status', 4);
                        $this->db->where('id', $talep_id);
                        $this->db->update('geopos_talep');
                    }
                    else
                    {
                        $this->db->set('status', 5);
                        $this->db->where('id', $talep_id);
                        $this->db->update('geopos_talep');
                    }
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
                }
                else
                {
                    if($this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili', $talep_id))
                    {
                        if($href!='')
                        {
                            $short_url = $this->getSmallLink($href);
                            $mesaj=$talep_no." Numaralı Gider Talep Formunu Incelemek icin tiklayiniz. ".$short_url;
                            $message = $this->mesaj_gonder($mobile,$mesaj);
                        }

                        echo json_encode(array('status' => 'Success', 'message' =>
                            $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
                    }
                }

            }
            else
            {
                echo json_encode(array('status' => 'Error', 'message' => 'Mail Gönderilirken Hata Oluştu.Lütren Daha Sonra İşlemi Bitirmeyi Tekrar Deneyiniz.', 'pstatus' => ''));
            }

        }

        else
        {
            if ($query->row()->finans_departman_pers_id == $kullanici)
            {
                $genel_mudur_onay_kontrol=$this->db->query("SELECT * FROM `geopos_onay` Where  file_id=$talep_id")->result();
                $onay_sayi=count($genel_mudur_onay_kontrol);
                $onay=0;
                $iptal=0;
                foreach ($genel_mudur_onay_kontrol as $knt)
                {
                    if($knt->genel_mudur_status==3)
                    {
                        $onay++;
                    }
                    else if($knt->genel_mudur_status==4)
                    {
                        $iptal++;
                    }
                }



                if($onay==$onay_sayi)
                {
                    $this->db->set('status', 3);
                    $this->db->where('id', $talep_id);
                    $this->db->update('geopos_talep');
                }
                else if ($iptal==$onay_sayi)
                {
                    $this->db->set('status', 4);
                    $this->db->where('id', $talep_id);
                    $this->db->update('geopos_talep');
                }
                else
                {
                    $this->db->set('status', 5);
                    $this->db->where('id', $talep_id);
                    $this->db->update('geopos_talep');
                }

            }

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
        }



        // Mail Gönderme
    }
    public function gider_talep_product_status()
    {

        $talep_id = $this->input->post('talep_id');
        $product_id = $this->input->post('product_id');
        $kullanici = $this->input->post('pers_id');
        $status = $this->input->post('status');
        $note = $this->input->post('note');
        $tip = $this->input->post('tip');
        $price = $this->input->post('price');
        $subject='';
        $message='';
        $recipients=array();


        $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and (proje_sorumlusu_id=$kullanici or proje_muduru_id=$kullanici  or bolum_mudur_id=$kullanici or genel_mudur_id=$kullanici  or finans_departman_pers_id=$kullanici) ");

        if ($query->num_rows() > 0) {



            if ($query->row()->proje_sorumlusu_id == $kullanici)    //proje sorumlusu onayladı
            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('proje_sorumlusu_status	', $status);
                    $this->db->set('proje_sorumlusu_status_note', $note);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->where('malzeme_items_id', $product_id);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'proje_sorumlusu_status' => $status,
                        'malzeme_items_id' => $product_id,
                        'proje_sorumlusu_status_note' => $note,
                        'file_id' => $talep_id,
                        'type' => $tip);

                    $this->db->insert('geopos_onay', $data);
                }


                $subject = 'Gider Talep Formu Hk.';
                $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunda Bazı Ürünler Proje Sorumlusu Tarafından Onay Almamıştır.Detaylı Bilgi İçin Gider Talep Formunu İnceleyiniz.';
                $message .= "<br><br><br><br>";
                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
                $talep_olusturan_pers_id = $query->row()->talep_olusturan_pers_id;
                $talep_eden_pers_id = $query->row()->talep_eden_pers_id;
                $talep_olusturan_pers_id_email = personel_detailsa($talep_olusturan_pers_id)['email'];
                $talep_eden_pers_id_email = personel_detailsa($talep_eden_pers_id)['email'];

                $recipients = array($talep_olusturan_pers_id_email,$talep_eden_pers_id_email);



            }

            if ($query->row()->proje_muduru_id == $kullanici)    //proje Müdürü onayladı
            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('proje_muduru_status	', $status);
                    $this->db->set('proje_muduru_status_note', $note);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->where('malzeme_items_id', $product_id);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'proje_muduru_status' => $status,
                        'proje_muduru_status_note' => $note,
                        'malzeme_items_id' => $product_id,
                        'file_id' => $talep_id,
                        'type' => $tip);

                    $this->db->insert('geopos_onay', $data);
                }





                $subject = 'Gider Talep Formu Hk.';
                $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunda Bazı Ürünler Proje Müdürü Tarafından Onay Almamıştır.Detaylı Bilgi İçin Gider Talep Formunu İnceleyiniz.';
                $message .= "<br><br><br><br>";
                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $talep_olusturan_pers_id = $query->row()->talep_olusturan_pers_id;
                $talep_eden_pers_id = $query->row()->talep_eden_pers_id;
                $talep_olusturan_pers_id_email = personel_detailsa($talep_olusturan_pers_id)['email'];
                $talep_eden_pers_id_email = personel_detailsa($talep_eden_pers_id)['email'];

                $recipients = array($talep_olusturan_pers_id_email,$talep_eden_pers_id_email);



            }


            if ($query->row()->bolum_mudur_id == $kullanici)  //Bölüm Müdürü onayladı

            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id  and malzeme_items_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('bolum_muduru_status', $status);
                    $this->db->set('bolum_muduru_status_note', $note);
                    $this->db->set('malzeme_items_id', $product_id);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'proje_muduru_status' => $status,
                        'bolum_muduru_status_note' => $note,
                        'malzeme_items_id' => $product_id,
                        'file_id' => $talep_id,
                        'type' => $tip);

                    $this->db->insert('geopos_onay', $data);
                }

                // Mail Gönderme



                $subject = 'Gider Talep Formu Hk.';
                $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunda Bazı Ürünler Bölüm Müdürü Tarafından Onay Almamıştır.Detaylı Bilgi İçin Gider Talep Formunu İnceleyiniz.';
                $message .= "<br><br><br><br>";
                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $talep_olusturan_pers_id = $query->row()->talep_olusturan_pers_id;
                $talep_eden_pers_id = $query->row()->talep_eden_pers_id;
                $talep_olusturan_pers_id_email = personel_detailsa($talep_olusturan_pers_id)['email'];
                $talep_eden_pers_id_email = personel_detailsa($talep_eden_pers_id)['email'];
                $recipients = array($talep_olusturan_pers_id_email,$talep_eden_pers_id_email);


            }

            if ($query->row()->genel_mudur_id == $kullanici)  //Genel Müdürü onayladı

            {

                $this->db->set('price', $price);
                $this->db->where('id', $product_id);
                $this->db->update('geopos_talep_items');

                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id  and malzeme_items_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('genel_mudur_status', $status);
                    $this->db->set('genel_mudur_status_note', $note);
                    $this->db->set('malzeme_items_id', $product_id);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'genel_mudur_status' => $status,
                        'genel_mudur_status_note' => $note,
                        'malzeme_items_id' => $product_id,
                        'file_id' => $talep_id,
                        'type' => $tip);

                    $this->db->insert('geopos_onay', $data);
                }

                // Mail Gönderme

                $subject = 'Gider Talep Formu Hk.';
                $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunda Bazı Ürünler Genel Müdürü Tarafından Onay Almamıştır.Detaylı Bilgi İçin Gider Talep Formunu İnceleyiniz.';
                $message .= "<br><br><br><br>";
                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $talep_olusturan_pers_id = $query->row()->talep_olusturan_pers_id;
                $talep_eden_pers_id = $query->row()->talep_eden_pers_id;
                $talep_olusturan_pers_id_email = personel_detailsa($talep_olusturan_pers_id)['email'];
                $talep_eden_pers_id_email = personel_detailsa($talep_eden_pers_id)['email'];
                $recipients = array($talep_olusturan_pers_id_email,$talep_eden_pers_id_email);


            }

            if ($query->row()->finans_departman_pers_id == $kullanici)  //Finans Departnanı onayladı

            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id  and malzeme_items_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('finans_status', $status);
                    $this->db->set('finans_status_note', $note);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('malzeme_items_id', $product_id);
                    $this->db->where('type', $tip);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'finans_status' => $status,
                        'finans_status_note' => $note,
                        'malzeme_items_id' => $product_id,
                        'file_id' => $talep_id,
                        'type' => $tip);

                    $this->db->insert('geopos_onay', $data);
                }

                // Mail Gönderme

                $subject = 'Gider Talep Formu Hk.';
                $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunda Bazı Ürünler Genel Müdürü Tarafından Onay Almamıştır.Detaylı Bilgi İçin Gider Talep Formunu İnceleyiniz.';
                $message .= "<br><br><br><br>";
                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $talep_olusturan_pers_id = $query->row()->talep_olusturan_pers_id;
                $talep_eden_pers_id = $query->row()->talep_eden_pers_id;
                $talep_olusturan_pers_id_email = personel_detailsa($talep_olusturan_pers_id)['email'];
                $talep_eden_pers_id_email = personel_detailsa($talep_eden_pers_id)['email'];
                $recipients = array($talep_olusturan_pers_id_email,$talep_eden_pers_id_email);


            }


            if($status==3)
            {
                echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Onaylandı', 'pstatus' => $status));
            }
            else if($status==4) {
                if ($this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili', $talep_id)) {
                    echo json_encode(array('status' => 'Warning', 'message' => 'Başarıyla İptal İşleminiz Gerçekleşti', 'pstatus' => $status));
                }
            }

        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Onaylamak İçin Yetkiniz Yoktur.', 'pstatus' => ''));
        }




    }
    public function gider_talep_product_status_toplu()
    {
        $talep_id = $this->input->post('talep_id')[0];
        $product_id = $this->input->post('product_id');
        $kullanici = $this->input->post('pers_id')[0];
        $note = $this->input->post('note');
        $price = $this->input->post('price');
        $status = 3;
        $tip =4;
        $ind=0;

        $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and (proje_sorumlusu_id=$kullanici or proje_muduru_id=$kullanici  or bolum_mudur_id=$kullanici or genel_mudur_id=$kullanici  or finans_departman_pers_id=$kullanici ) ");
        if ($query->num_rows() > 0)
        {


            if ($query->row()->proje_sorumlusu_id == $kullanici)    //proje sorumlusu onayladı
            {
                $ind=0;
                foreach ($product_id as $key=>$value)
                {
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('proje_sorumlusu_status	', $status);
                        $this->db->set('proje_sorumlusu_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('malzeme_items_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'proje_sorumlusu_status' => $status,
                            'malzeme_items_id' => $value,
                            'proje_sorumlusu_status_note' => $note[$key],
                            'file_id' => $talep_id,
                            'type' => $tip);

                        $this->db->insert('geopos_onay', $data);
                    }
                    $ind++;
                }



            }
            if ($query->row()->proje_muduru_id == $kullanici)    //proje müdürü onayladı
            {
                $ind=0;
                foreach ($product_id as $key=>$value)
                {
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('proje_muduru_status	', $status);
                        $this->db->set('proje_muduru_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('malzeme_items_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'proje_muduru_status' => $status,
                            'malzeme_items_id' => $value,
                            'proje_muduru_status_note' => $note[$key],
                            'file_id' => $talep_id,
                            'type' => $tip);

                        $this->db->insert('geopos_onay', $data);
                    }
                    $ind++;
                }



            }
            if ($query->row()->bolum_mudur_id == $kullanici)    //bolum müdürü onayladı
            {
                $ind=0;
                foreach ($product_id as $key=>$value)
                {
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('bolum_muduru_status	', $status);
                        $this->db->set('bolum_muduru_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('malzeme_items_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'bolum_muduru_status' => $status,
                            'malzeme_items_id' => $value,
                            'bolum_muduru_status_note' => $note[$key],
                            'file_id' => $talep_id,
                            'type' => $tip);

                        $this->db->insert('geopos_onay', $data);
                    }
                    $ind++;
                }



            }
            if ($query->row()->genel_mudur_id == $kullanici)    //genel müdürü onayladı
            {


                $ind=0;
                foreach ($product_id as $key=>$value)
                {


                    $this->db->set('price', $price[$key]);
                    $this->db->where('id', $value);
                    $this->db->update('geopos_talep_items');

                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('genel_mudur_status	', $status);
                        $this->db->set('genel_mudur_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('malzeme_items_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'genel_mudur_status' => $status,
                            'product_id' => $value,
                            'genel_mudur_status_note' => $note[$key],
                            'malzeme_items_id' => $talep_id,
                            'type' => $tip);

                        $this->db->insert('geopos_onay', $data);
                    }
                    $ind++;
                }



            }
            if ($query->row()->finans_departman_pers_id == $kullanici)    //finans müdürü onayladı
            {
                $ind=0;
                foreach ($product_id as $key=>$value)
                {
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('finans_status	', $status);
                        $this->db->set('finans_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('malzeme_items_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'finans_status' => $status,
                            'malzeme_items_id' => $value,
                            'finans_status_note' => $note[$key],
                            'file_id' => $talep_id,
                            'type' => $tip);

                        $this->db->insert('geopos_onay', $data);
                    }
                    $ind++;
                }



            }

            if($ind>0)
            {
                echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Onaylandı.Bekleyiniz...', 'pstatus' => $status));
            }
        }
    }


    public function satinalma_item_onay_detay()
    {
        $talep_id = $this->input->post('talep_id');
        $product_name = $this->input->post('product_name');
        $kullanici = $this->input->post('pers_id');
        $status=2;
        $note = $this->input->post('secenek_note').' '.$this->input->post('secenek');


        $query=$this->db->query("SELECT * FROM geopos_talep_items WHERE tip=$talep_id and product_name='$product_name' LIMIT 1")->row();
        $data_items = array(

            'tip' => $talep_id,

            'product_name' => $product_name,

            'product_detail' => $query->product_detail,


            'qty' =>  $query->qty,

            'price' => 0,

            'tax' => 0,

            'discount' => 0,

            'subtotal' => 0,

            'totaltax' => 0,

            'totaldiscount' => 0,

            'unit' =>  $query->unit
        );

        $this->db->insert('geopos_talep_items', $data_items);

        $lists = $this->db->insert_id();

        $data_o= array(
            'file_id' => $talep_id,
            'malzeme_items_id' => $lists,
            'type' => 2);

        $this->db->insert('geopos_onay', $data_o);





        $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and (proje_muduru_id=$kullanici  or genel_mudur_id=$kullanici  or finans_departman_pers_id=$kullanici) ");
        if ($query->num_rows() > 0) {


            if ($query->row()->proje_muduru_id == $kullanici)    //proje Müdürü onayladı
            {
                //update
                $this->db->set('proje_muduru_status	', $status);
                $this->db->set('proje_muduru_status_note', $note);
                $this->db->where('malzeme_items_id', $lists);
                $this->db->update('geopos_onay');
            }
            if ($query->row()->genel_mudur_id == $kullanici)  //Genel Müdürü onayladı
            {

                $this->db->set('genel_mudur_status', $status);
                $this->db->set('genel_mudur_status_note', $note);
                $this->db->where('malzeme_items_id', $lists);
                $this->db->update('geopos_onay');

                $genel_mudur_onay_kontrol=$this->db->query("SELECT * FROM `geopos_onay` Where  file_id=$talep_id")->result();
                $onay_sayi=count($genel_mudur_onay_kontrol);
                $onay=0;
                $iptal=0;
                foreach ($genel_mudur_onay_kontrol as $knt)
                {
                    if($knt->genel_mudur_status==3)
                    {
                        $onay++;
                    }
                    else if($knt->genel_mudur_status==4)
                    {
                        $iptal++;
                    }
                }



                if($onay==$onay_sayi)
                {
                    $this->db->set('status', 3);
                    $this->db->where('id', $talep_id);
                    $this->db->update('geopos_talep');
                }
                else if ($iptal==$onay_sayi)
                {
                    $this->db->set('status', 4);
                    $this->db->where('id', $talep_id);
                    $this->db->update('geopos_talep');
                }
                else
                {
                    $this->db->set('status', 5);
                    $this->db->where('id', $talep_id);
                    $this->db->update('geopos_talep');
                }



            }
            if ($query->row()->finans_departman_pers_id == $kullanici)  //Finans Departnanı onayladı
            {

                $this->db->set('finans_status', $status);
                $this->db->set('finans_status_note', $note);
                $this->db->where('malzeme_items_id', $lists);
                $this->db->update('geopos_onay');


            }


            echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla İşlem Eklendi', 'pstatus' => $status));
        }

    }

    public function satinalma_item_onay()
    {

        $talep_id = $this->input->post('talep_id');
        $list = $this->input->post('item_ids');
        $kullanici = $this->input->post('pers_id');
        $note ='';
        $tip = $this->input->post('tip');
        $status_ = $this->input->post('status');
        $status=1;
        if($status_==1) // Seçili Olanları Tastikle
        {
            $status=3;
        }
        if($status_==2) // Seçili Olanları iptal et
        {
            $status=4;
        }
        if($status_==3) // Seçili Olanları Tastikle
        {
            $status=3;
        }
        $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and (proje_muduru_id=$kullanici  or genel_mudur_id=$kullanici  or finans_departman_pers_id=$kullanici) ");
        if ($query->num_rows() > 0) {
            foreach ($list as $lists)
            {

                if ($query->row()->proje_muduru_id == $kullanici)    //proje Müdürü onayladı
                {
                    //update
                    $this->db->set('proje_muduru_status	', $status);
                    $this->db->set('proje_muduru_status_note', $note);
                    $this->db->where('malzeme_items_id', $lists);
                    $this->db->update('geopos_onay');
                }
                if ($query->row()->genel_mudur_id == $kullanici)  //Genel Müdürü onayladı

                {

                    $this->db->set('genel_mudur_status', $status);
                    $this->db->set('genel_mudur_status_note', $note);
                    $this->db->where('malzeme_items_id', $lists);
                    $this->db->update('geopos_onay');

                    $this->db->set('status', $status);
                    $this->db->where('id', $talep_id);
                    $this->db->update('geopos_talep');

                }
                if ($query->row()->finans_departman_pers_id == $kullanici)  //Finans Departnanı onayladı
                {

                    $this->db->set('finans_status', $status);
                    $this->db->set('finans_status_note', $note);
                    $this->db->where('malzeme_items_id', $lists);
                    $this->db->update('geopos_onay');


                }

            }


            if($status==3)
            {
                echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Onaylandı.Bekleyiniz', 'pstatus' => $status));
            }
            else if($status==4)
            {
                echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla İptal Edildi.Bekleyiniz', 'pstatus' => $status));
            }


        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Onaylamak İçin Yetkiniz Yoktur.', 'pstatus' => ''));
        }




    }


    public function satinalma_item_onay_firma_bazli()
    {

        $talep_id = $this->input->post('talep_id');
        $firma_adi = $this->input->post('firma_adi');
        $kullanici = $this->input->post('pers_id');
        $tip = $this->input->post('tip');
        $note ='';
        $status=$this->input->post('status');;

        date_default_timezone_set('Asia/Baku');

        $date = new DateTime('now');
        $date_saat=$date->format('Y-m-d H:i:s');

        $i=0;
        $j=0;
        $k=0;
        $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and (proje_muduru_id=$kullanici  or genel_mudur_id=$kullanici  or finans_departman_pers_id=$kullanici) ");
        if ($query->num_rows() > 0) {

            $list= $this->db->query("SELECT * FROM `geopos_talep_items` WHERE `tip` = $talep_id AND `firma` LIKE '%$firma_adi%' and ref_urun=0 ORDER BY `tip` DESC")->result();
            foreach ($list as $lists)
            {

                if ($query->row()->proje_muduru_id == $kullanici)    //proje Müdürü onayladı
                {
                    if($i==0)
                    {
                        $this->db->set('proje_muduru_onay_saati', $date_saat);
                        $this->db->set('proje_muduru_status	', 1);
                        $this->db->where('file_id', $talep_id);
                        $this->db->update('geopos_onay');
                    }

                    //update
                    $this->db->set('proje_muduru_onay_saati', $date_saat);
                    $this->db->set('proje_muduru_status	', $status);
                    $this->db->set('proje_muduru_status_note', $note);
                    $this->db->where('malzeme_items_id', $lists->id);
                    $this->db->update('geopos_onay');
                    $i++;
                }
                if ($query->row()->genel_mudur_id == $kullanici)  //Genel Müdürü onayladı

                {

                    if($j==0) {
                        $this->db->set('genel_mudur_onay_saati', $date_saat);
                        $this->db->set('genel_mudur_status', 1);
                        $this->db->where('file_id', $talep_id);
                        $this->db->update('geopos_onay');
                    }

                    $this->db->set('genel_mudur_onay_saati', $date_saat);
                    $this->db->set('genel_mudur_status', $status);
                    $this->db->set('genel_mudur_status_note', $note);
                    $this->db->where('malzeme_items_id', $lists->id);
                    $this->db->update('geopos_onay');

                    $this->db->set('status', $status);
                    $this->db->where('id', $talep_id);
                    $this->db->update('geopos_talep');
                    $j++;

                }
                if ($query->row()->finans_departman_pers_id == $kullanici)  //Finans Departnanı onayladı
                {

                    if($k==0) {

                        $this->db->set('finans_onay_saati', $date_saat);
                        $this->db->set('finans_status', 1);
                        $this->db->where('file_id', $talep_id);
                        $this->db->update('geopos_onay');
                    }

                    $this->db->set('finans_onay_saati', $date_saat);
                    $this->db->set('finans_status', $status);
                    $this->db->set('finans_status_note', $note);
                    $this->db->where('malzeme_items_id', $lists->id);
                    $this->db->update('geopos_onay');
                    $k++;

                }

            }


            if($status==3)
            {
                echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Onaylandı.Bekleyiniz', 'pstatus' => $status));
            }
            else if($status==4)
            {
                echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla İptal Edildi.Bekleyiniz', 'pstatus' => $status));
            }


        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Onaylamak İçin Yetkiniz Yoktur.', 'pstatus' => ''));
        }




    }

    public function satinalma_item_onay_products()
    {

        $talep_id = $this->input->post('talep_id');
        $lists = $this->input->post('item_ids');
        $kullanici = $this->input->post('pers_id');
        $note = $this->input->post('notes');
        $tip = $this->input->post('tip');
        $status = $this->input->post('status');

        /*
        $status_ = $this->input->post('status');
        $status=1;
        if($status_==1) // Seçili Olanları Tastikle
        {
            $status=3;
        }
        if($status_==2) // Seçili Olanları iptal et
        {
            $status=4;
        }
        if($status_==3) // Seçili Olanları Tastikle
        {
            $status=3;
        }
        */

        date_default_timezone_set('Asia/Baku');

        $date = new DateTime('now');
        $date_saat=$date->format('Y-m-d H:i:s');

        $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and (proje_muduru_id=$kullanici  or genel_mudur_id=$kullanici  or finans_departman_pers_id=$kullanici) ");
        if ($query->num_rows() > 0) {


            if ($query->row()->proje_muduru_id == $kullanici)    //proje Müdürü onayladı
            {
                //update
                $this->db->set('proje_muduru_onay_saati', $date_saat);
                $this->db->set('proje_muduru_status', $status);
                $this->db->set('proje_muduru_status_note', $note);
                $this->db->where('malzeme_items_id', $lists);
                $this->db->update('geopos_onay');
            }
            if ($query->row()->genel_mudur_id == $kullanici)  //Genel Müdürü onayladı

            {

                $this->db->set('genel_mudur_onay_saati', $date_saat);
                $this->db->set('genel_mudur_status', $status);
                $this->db->set('genel_mudur_status_note', $note);
                $this->db->where('malzeme_items_id', $lists);
                $this->db->update('geopos_onay');

                $genel_mudur_onay_kontrol=$this->db->query("SELECT * FROM `geopos_onay` Where  file_id=$talep_id")->result();
                $onay_sayi=count($genel_mudur_onay_kontrol);
                $onay=0;
                $iptal=0;
                foreach ($genel_mudur_onay_kontrol as $knt)
                {
                    if($knt->genel_mudur_status==3)
                    {
                        $onay++;
                    }
                    else if($knt->genel_mudur_status==4)
                    {
                        $iptal++;
                    }
                }



                if($onay==$onay_sayi)
                {
                    $this->db->set('status', 3);
                    $this->db->where('id', $talep_id);
                    $this->db->update('geopos_talep');
                }
                else if ($iptal==$onay_sayi)
                {
                    $this->db->set('status', 4);
                    $this->db->where('id', $talep_id);
                    $this->db->update('geopos_talep');
                }
                else
                {
                    $this->db->set('status', 5);
                    $this->db->where('id', $talep_id);
                    $this->db->update('geopos_talep');
                }


            }
            if ($query->row()->finans_departman_pers_id == $kullanici)  //Finans Departnanı onayladı
            {

                $this->db->set('finans_onay_saati', $date_saat);
                $this->db->set('finans_status', $status);
                $this->db->set('finans_status_note', $note);
                $this->db->where('malzeme_items_id', $lists);
                $this->db->update('geopos_onay');


            }


            if($status==3)
            {
                echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Onaylandı', 'pstatus' => $status));
            }
            else if($status==4)
            {
                echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla İptal Edildi', 'pstatus' => $status));
            }
            else if($status==1)
            {
                echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Onay Başarıyla Geri Alındı', 'pstatus' => $status));
            }


        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Onaylamak İçin Yetkiniz Yoktur.', 'pstatus' => ''));
        }




    }



    public function urun_bilgileri(){
        $id = $this->input->post('id');
        $string='proje_muduru_status';
        $firma_id = $this->input->post('product_name');
        $data['data']=$this->db->query("SELECT * FROM `geopos_talep_items` WHERE tip=$id and firma_id=$firma_id and ref_urun=0 ORDER BY `geopos_talep_items`.`price` ASC")->result_array();
        $user_id = $this->aauth->get_user()->id;
        $dettais=$this->db->query("SELECT * FROM `geopos_talep` where id=$id ")->row();
        $data['invoice_details']=$dettais;
        if($dettais->proje_muduru_id==$user_id)
        {
            $string='proje_muduru_status';
        }
        else if($dettais->genel_mudur_id==$user_id)
        {
            $string='genel_mudur_status';
        }
        else if($dettais->finans_departman_pers_id==$user_id)
        {
            $string='finans_status';
        }
        $data['product_name']=customer_details($firma_id)['company'];
        $data['string']=$string;
        $data['satin_alma_id']=$id;
        $data['malzeme_talep_id']=customer_details($firma_id)['company'];
        $this->load->view('form/view_bilgi_onay', $data);

    }
    public function eksik_urun_bilgileri(){
        $id = $this->input->post('id');
        $string='';
        $firma_adi = $this->input->post('firma_adi');
        $query2=$this->db->query("SELECT * FROM geopos_talep_items WHERE `tip` = $id and ref_urun=0 and
        product_name NOT IN ( SELECT product_name FROM geopos_talep_items WHERE tip=$id and firma='$firma_adi' and ref_urun=0 ) GROUP BY product_name
")->result_array();


        $data['data']=$query2;
        $data['product_name']=$firma_adi;
        $data['string']=$string;
        $data['satin_alma_id']=$id;
        $data['malzeme_talep_id']=$firma_adi;
        $this->load->view('form/view_bilgi_eksik_urun', $data);

    }


    // GİDER TALEP FORMU

    public function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    public function talep_iptal()
    {
        $id = $this->input->post('talep_id');
        $status = $this->input->post('status');
        $desc = $this->input->post('desc');

        $talep_no = $this->db->query("SELECT * FROM geopos_talep WHERE  id =$id")->row_array();

        if($status==0)//iptal
        {
            $this->aauth->applog("Talep İptal : No " . $talep_no['talep_no'], $this->aauth->get_user()->username,$id);
            kont_kayit(45,$id);

            $data=array(
                'status'=>4,
                'iptal_desc'=>$desc,
                'iptal_pers_id'=>$this->aauth->get_user()->id,
            );

            $this->db->set($data);

            $this->db->where('id', $id);

            $this->db->update('geopos_talep', $data);



            echo json_encode(array('status' => 'Success', 'message' =>

                'Başarıyla İptal Edildi'));
        }
        else
        {
            $this->aauth->applog("Talep Kapatıldı : NO " . $talep_no['talep_no'], $this->aauth->get_user()->username,$id);

            kont_kayit(46,$id);

            $data=array('status'=>6,'malzeme_talep_durumu'=>1);

            $this->db->set($data);

            $this->db->where('id', $id);

            $this->db->update('geopos_talep', $data);

            echo json_encode(array('status' => 'Success', 'message' =>

                'Başarıyla Kapatıldı'));
        }


    }

    public function delete_talep()

    {


        if (!$this->aauth->premission(91)) {

            echo json_encode(array('status' => 'Error', 'message' =>
                'Silme Yetkiniz Yoktur'));
            die();

        }
        else
        {
            $id = $this->input->post('deleteid');
            $talep_no = $this->db->query("SELECT * FROM geopos_talep WHERE  id =$id")->row_array();



            if ($this->requested->invoice_delete($id, $this->limited)) {


                $this->aauth->applog("Talep Silindi : ID " . $talep_no['talep_no'], $this->aauth->get_user()->username,$id);
                kont_kayit(47,$id);

                echo json_encode(array('status' => 'Success', 'message' =>

                    $this->lang->line('DELETED')));



            } else {

                kont_kayit(48,$id);

                $this->aauth->applog("İptal Edilmek İstendi : ID " . $id, $this->aauth->get_user()->username,$id);
                echo json_encode(array('status' => 'Error', 'message' =>
                    'Faturayı Önce İptal Etmeniz Gerekir'));

            }
        }






    }

    public function personel_list()
    {
        $dep = $this->input->post('dep', true);

        $invoice_list=$this->db->query("SELECT * FROM geopos_employees WHERE dept=$dep ORDER BY `geopos_employees`.`name` ASC")->result();
        $data=array();
        foreach ($invoice_list as $l)
        {
            $data[]=array(
                'name'=>$l->name,
                'id'=>$l->id
            );
        }

        echo json_encode($data);

    }

    public function ajax_list_talep()

    {


        $talep_id = $this->input->post('tip');

        $depo_mudur_id = talep_user_id_ogren('bolum_mudur_id',$talep_id);

        $kullanici_id = $this->aauth->get_user()->id;

        $list = $this->requested->get_datatables_prd($this->limited);


        $data = array();

        $no = $this->input->post('start');
        $id = $this->input->post('tip');

        $this->session->set_userdata('test', 1);

        $sub_t=0;
        foreach ($list as $invoices) {

            $product_id=$invoices->product_id;
            $opt="";
            $satinalma_= $this->db->query("SELECT * FROM `geopos_onay` Where `type`=1 and file_id=$id and product_id=$product_id")->row_array();

            $sub_t += $invoices->price * $invoices->qty;

            foreach (personel_list() as $emp){
                $emp_id=$emp['id'];
                $name=$emp['name'];

                $product_id=$invoices->id;
                $selected='';

                $satin_alma_yon=$satinalma_['satinalma_yonlendirme'];
                if($satin_alma_yon==$emp_id)
                {
                    $selected="selected";
                }
                $opt.='<option '.$selected.' value="'.$emp_id.'">'.$name.'</option>';
            }




            $no++;

            $row = array();
            $row[] = '<button type="button" class="btn btn-success btn-sm onayla" status="3" >✓</button>&nbsp
            <button  type="button"  class="btn btn-danger btn-sm iptal" status="4">X</button>';
            if($kullanici_id==$depo_mudur_id)
            {
                $row[] = '<input placeholder="Depoda Bulunan Miktar"  name="depo_var_olan_mik[]" value="0" class="form-control depo_var_olan_mik">';

            }





            $row[] = $invoices->product_name;
            $row[] = $invoices->product_detail;
            $row[] = round($invoices->qty,2).' '.$invoices->unit;
            $row[] = purchase_status(onay_durumlari_ogren_product_str(1,$id,$product_id,"proje_sorumlusu_status")['durum']).' </br>'.(onay_durumlari_ogren_product_onay_saati(1,$id,$product_id,"proje_sorumlusu_onay_saati")['onay_saati']);
            $row[] = purchase_status(onay_durumlari_ogren_product_str(1,$id,$product_id,"proje_muduru_status")['durum']).' </br>'.(onay_durumlari_ogren_product_onay_saati(1,$id,$product_id,"proje_muduru_onay_saati")['onay_saati']);
            $row[] = purchase_status(onay_durumlari_ogren_product_str(1,$id,$product_id,"bolum_muduru_status")['durum']).' </br>'.(onay_durumlari_ogren_product_onay_saati(1,$id,$product_id,"bolum_muduru_saati")['onay_saati']).' </br><span style="font-weight: 900;">'.malzeme_talep_depo_miktari($id,$product_id).' '.$invoices->unit.' Depo Müdürü Var Olarak İşaretledi</span>';
            $row[] = purchase_status(onay_durumlari_ogren_product_str(1,$id,$product_id,"genel_mudur_status")['durum']).' </br>'.(onay_durumlari_ogren_product_onay_saati(1,$id,$product_id,"genel_mudur_onay_saati")['onay_saati']);

            $row[] = '<select class="form-control satin_alma_ select-box" name="satin_alma_[]">
                <option value="0">Seçiniz</option>
                '.$opt.'

                </select><input type="hidden" class="product_id" name="product_id[]" value="'.$product_id.'">
                                                        <input type="hidden" class="talep_id" name="talep_id[]" value="'.$id.'">
                                                        <input type="hidden" class="pers_id" name="pers_id[]" value="'.$this->aauth->get_user()->id.'">';

            $data[] = $row;




        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->requested->count_all_prd($this->limited),

            "recordsFiltered" => $this->requested->count_filtered_prd($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }

    public function exportxls_satinalma() {
        $id=$_GET['id'];
        $name=$this->db->query("SELECT * FROM geopos_talep Where id=$id")->row()->talep_no;

        $result = $this->db->query("Select geopos_talep_items.product_name as 'Ürün Adı', geopos_talep_items.product_detail as 'Ürün Açıklaması',
geopos_talep_items.qty as 'Miktar',geopos_talep_items.price as 'Birim Fiyatı',geopos_talep_items.subtotal as 'Toplam',
geopos_onay.genel_mudur_status_note as 'Genel Müdür Notu',geopos_talep_items.firma as 'Firma Adı',geopos_talep_items.firma_tel as 'Firma Tel'
From geopos_onay INNER JOIN geopos_talep_items ON geopos_onay.malzeme_items_id=geopos_talep_items.id where geopos_onay.file_id=$id and geopos_onay.genel_mudur_status=3
");
        to_excel($result, 'Satınalma Formu #'.$name);
    }



    public function satinalma_emri_olustur() {

        $id=$this->input->post('id');
        $data=array('satinalma_status'=>3);

        $this->db->set($data);

        $this->db->where('file_id', $id);

        $this->db->update('geopos_onay', $data);

        $tabler='';

        $result = $this->db->query("Select geopos_talep_items.product_name, geopos_talep_items.product_detail,
geopos_talep_items.qty,geopos_talep_items.price,geopos_talep_items.subtotal,
geopos_onay.genel_mudur_status_note as 'Genel Müdür Notu',geopos_talep_items.firma ,geopos_talep_items.firma_tel
From geopos_onay INNER JOIN geopos_talep_items ON geopos_onay.malzeme_items_id=geopos_talep_items.id where geopos_onay.file_id=$id and geopos_onay.genel_mudur_status=3
");
        $tabler="<table class='table'>
                <tr>
                <td>Ürün Adı</td>
                <td>Ürün Açıklaması</td>
                <td>Miktar</td>
                <td>Birim Fiyatı</td>
                <td>Toplam</td>
                <td>Firma</td>
                <td>Firma Tel</td>
                </tr>";

        foreach ($result->result() as $prd)
        {
            $tabler.="
                    <tr>
                        <td>$prd->product_name</td>
                        <td>$prd->product_detail</td>
                        <td>$prd->qty</td>
                        <td>$prd->price</td>
                        <td>$prd->subtotal</td>
                        <td>$prd->firma</td>
                        <td>$prd->firma_tel</td>
                    </tr>
";
        }

        $tabler.='</table>';

        $details=$this->db->query("SELECT * FROM geopos_talep WHERE id=$id")->row();

        $subject = 'Satın Alma Emri';


        $message = 'Sayın Yetkili '.$details->proje_name.' Projesine Bağlı ' . $details->talep_no . ' Numaralı Satın Alma Formundaki Onaylanan Ürünler İçin Satın Alma Başlamıştır.Ürün Listesi Aşağıda Bulunmaktadır.';



        $message .= '<br><br>'.$tabler;

        $message .= "<br><br><br><br>";
        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

        $proje_sorumlusu_email = personel_detailsa($details->proje_muduru_id)['email'];
        $genel_mudur_email = personel_detailsa($details->genel_mudur_id)['email'];






        $recipients = array($proje_sorumlusu_email,$genel_mudur_email);


        if($this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili'))
        {
            echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla İşlem Eklendi', 'pstatus' => 'basarili'));
        }





    }



    public function print_teklif_firma()

    {



        $tid = $this->input->get('id');
        $firma_id = $this->input->get('firma_id');

        $data['id'] = $tid;


        $kelimer = explode(' ',$firma_name);
        $kel=$kelimer[0];

        $i = 0;




        $data['firma'] = $this->db->query("SELECT * FROM geopos_customers WHERE id=$firma_id")->row_array();
        $data['invoice'] = $this->db->query("SELECT * FROM `geopos_talep` WHERE `id`=$tid ")->row_array();


        $data['dis']=0;
        $firma_id = $data['firma']['id'];
        $details = $this->db->query("SELECT * FROM talep_to_discount Where firma_id =$firma_id and talep_id = $tid");
        if($details->num_rows()){
         $data['dis'] = $details->row()->discount;
        }

        $method =  $this->db->query("SELECT method FROM `geopos_talep_items` WHERE `tip`=$tid and firma_id=$firma_id and ref_urun=0   GROUP by method")->row()->method;
        $data['odeme']=account_type_sorgu($method);
        $data['products']= $this->db->query("SELECT * FROM `geopos_talep_items` WHERE tip=$tid and firma_id=$firma_id and ref_urun=0 ORDER BY `geopos_talep_items`.`price` ASC")->result_array();



        ini_set('memory_limit', '64M');


        $html = $this->load->view('form/view-print-firma-teklif-ltr', $data, true);

        $header = $this->load->view('form/header-print-firma-teklif-ltr', $data, true);

        //PDF Rendering

        $this->load->library('pdf');



        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['talep_no'] . '</div>');

        $pdf->AddPage(
            '', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            40, // margin top
            '', // margin bottom
            0,50,0,0, // margin header
            ''); // margin footer

        $pdf->WriteHTML($html);



        $file_name = preg_replace( '/[^A-Za-z0-9]+/', '-', 'Satinalma__'.$data['invoice']['talep_no'].'_'. $data['invoice']['id']);

        if ($this->input->get('d')) {



            $pdf->Output($file_name. '.pdf', 'D');

        } else {

            $pdf->Output($file_name . '.pdf', 'I');

        }





    }

    public function print_teklif_firma_ekstra()

    {



        $tid = $this->input->get('id');
        $firma_id = $this->input->get('firma_id');

        $data['id'] = $tid;



        $i = 0;



        $data['firma'] = $this->db->query("SELECT * FROM geopos_customers WHERE id=$firma_id")->row_array();
        $data['invoice'] = $this->db->query("SELECT * FROM `geopos_talep` WHERE `id`=$tid ")->row_array();

        $method =  $this->db->query("SELECT method FROM `geopos_talep_items` WHERE `tip`=$tid and firma_id=$firma_id and ref_urun=1   GROUP by method")->row()->method;
        $data['odeme']=account_type_sorgu($method);
        $data['products']= $this->db->query("SELECT * FROM `geopos_talep_items` WHERE tip=$tid and firma_id=$firma_id and ref_urun=1 ORDER BY `geopos_talep_items`.`price` ASC")->result_array();



        ini_set('memory_limit', '64M');


        $html = $this->load->view('form/view-print-firma-teklif-ltr', $data, true);

        $header = $this->load->view('form/header-print-firma-teklif-ltr', $data, true);

        //PDF Rendering

        $this->load->library('pdf');



        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['talep_no'] . '</div>');

        $pdf->AddPage(
            '', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            40, // margin top
            '', // margin bottom
            0,50,0,0, // margin header
            ''); // margin footer

        $pdf->WriteHTML($html);



        $file_name = preg_replace( '/[^A-Za-z0-9]+/', '-', 'Satinalma__'.$data['invoice']['talep_no'].'_'. $data['invoice']['id']);

        if ($this->input->get('d')) {



            $pdf->Output($file_name. '.pdf', 'D');

        } else {

            $pdf->Output($file_name . '.pdf', 'I');

        }





    }

    public function onaylanan_print_teklif_firma()
    {



        $tid = $this->input->get('id');
        $firma_id = $this->input->get('firma_id');

        $data['id'] = $tid;


        $kelimer = explode(' ',$firma_name);
        $kel=$kelimer[0];

        $i = 0;




        $data['firma'] = $this->db->query("SELECT * FROM geopos_customers WHERE id=$firma_id")->row_array();
        $data['invoice'] = $this->db->query("SELECT * FROM `geopos_talep` WHERE `id`=$tid ")->row_array();


        $data['dis']=0;
        $firma_id = $data['firma']['id'];
        $details = $this->db->query("SELECT * FROM talep_to_discount Where firma_id =$firma_id and talep_id = $tid");
        if($details->num_rows()){
            $data['dis'] = $details->row()->discount;
        }


        $data['products']= $this->db->query("SELECT * FROM `geopos_talep_items` INNER JOIN geopos_onay ON geopos_talep_items.id =geopos_onay.malzeme_items_id WHERE geopos_onay.genel_mudur_status=3 and geopos_talep_items.tip=$tid and geopos_talep_items.firma_id=$firma_id and geopos_talep_items.ref_urun=0 ORDER BY `geopos_talep_items`.`price` ASC")->result_array();



        ini_set('memory_limit', '64M');


        $html = $this->load->view('form/view-print-firma-teklif-ltr', $data, true);

        $header = $this->load->view('form/header-print-firma-teklif-ltr', $data, true);

        //PDF Rendering

        $this->load->library('pdf');



        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['talep_no'] . '</div>');

        $pdf->AddPage(
            '', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            50, // margin top
            '', // margin bottom
            0,70,0,0, // margin header
            ''); // margin footer

        $pdf->WriteHTML($html);



        $file_name = preg_replace( '/[^A-Za-z0-9]+/', '-', 'Satinalma__'.$data['invoice']['talep_no'].'_'. $data['invoice']['id']);

        if ($this->input->get('d')) {



            $pdf->Output($file_name. '.pdf', 'D');

        } else {

            $pdf->Output($file_name . '.pdf', 'I');

        }





    }

    public function avansprintinvoice()

    {

        $tid = $this->input->get('id');

        $data['id'] = $tid;


        $data['invoice'] = $this->requested->invoice_details($tid, $this->limited);

        if ($data['invoice']) $data['products'] = $this->requested->invoice_products($tid);


        ini_set('memory_limit', '64M');


        $html = $this->load->view('form/view-print-avans-' . LTR, $data, true);
        $header = $this->load->view('form/header-print-avans-' . LTR, $data, true);
        $footer = $this->load->view('form/footer-print-avans-' . LTR, $data, true);

        //PDF Rendering

        $this->load->library('pdf');


        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter($footer);
        $pdf->AddPage(
            'P', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            77, // margin top
            '72', // margin bottom
            5, 2, 0, 0, // margin header
            'auto'); // margin footer

        $pdf->WriteHTML($html);


        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'Talep__' . $data['invoice']['name'] . '_' . $data['invoice']['id']);

        if ($this->input->get('d')) {


            $pdf->Output($file_name . '.pdf', 'D');

        } else {

            $pdf->Output($file_name . '.pdf', 'I');

        }


    }


    public function eksik_urun_bilgileri_onay(){
        $id = $this->input->post('id');
        $string='proje_muduru_status';
        $data['urunler']=$this->db->query("SELECT * FROM `geopos_talep_items` WHERE tip=$id and ref_urun=0 GROUP BY product_name")->result_array();
        $data['data']=$this->db->query("SELECT * FROM `geopos_talep_items` WHERE tip=$id and ref_urun=0 ORDER BY `geopos_talep_items`.`product_name`,geopos_talep_items.price ASC")->result_array();
        $user_id = $this->aauth->get_user()->id;
        $dettais=$this->db->query("SELECT * FROM `geopos_talep` where id=$id ")->row();
        $data['invoice_details']=$dettais;
        if($dettais->proje_muduru_id==$user_id)
        {
            $string='proje_muduru_status';
        }
        else if($dettais->genel_mudur_id==$user_id)
        {
            $string='genel_mudur_status';
        }
        else if($dettais->finans_departman_pers_id==$user_id)
        {
            $string='finans_status';
        }
        $data['string']=$string;
        $data['satin_alma_id']=$id;
        $this->load->view('form/view_bilgi_onay_all', $data);

    }

    public function odeme_emri()
    {
        $talep_id = $this->input->post('talep_id');
        $odeme_tarihi_ = $this->input->post('odeme_tarihi');
        $odeme_tarihi = datefordatabase($odeme_tarihi_);
        $aciklama = $this->input->post('aciklama');
        $kasa = $this->input->post('kasa');

        $kontrol = $this->db->query("SELECT * FROM geopos_invoices Where tid =$talep_id");
        if($kontrol->num_rows()>0)
        {
            echo json_encode(array('status' => 'Error', 'message' =>"Ödeme Emri Daha Önce Oluşturuldu"));
        }
        else
        {
            $data=array(
                'tid'=>$talep_id,
                'acid'=>$kasa,
                'invoice_type_id'=>42,
                'eid'=>$this->aauth->get_user()->id,
                'invoice_type_desc'=>'Ödeme Emri',
                'invoicedate'=>$odeme_tarihi,
                'notes'=>$aciklama
            );

            if ($this->db->insert('geopos_invoices', $data))
            {

                $this->db->set('status', "7", FALSE);

                $this->db->where('id', $talep_id);

                $this->db->update('geopos_talep');

                echo json_encode(array('status' => 'Success', 'message' =>"Ödeme Emri Başarıyla Oluşturuldu"));
            }
        }


    }

    public function proje_muduru_urunleri_onayla()
    {
        $talep_id = $this->input->post('talep_id');
        $odeme_tarihi_ = $this->input->post('pers_id');
        $status = $this->input->post('status');
        date_default_timezone_set('Asia/Baku');

        $date = new DateTime('now');
        $date_saat=$date->format('Y-m-d H:i:s');


        $kontrol = $this->db->query("SELECT * FROM `geopos_onay` WHERE `file_id` = $talep_id and proje_muduru_status=3");
        if($kontrol->num_rows()>0)
        {

            $user_id = $this->aauth->get_user()->id;

            $pers_kont = $this->db->query("SELECT * FROM `geopos_talep` WHERE `id` = $talep_id and genel_mudur_id=$user_id");
            $pers_kont2 = $this->db->query("SELECT * FROM `geopos_talep` WHERE `id` = $talep_id and finans_departman_pers_id=$user_id");


            if($pers_kont->num_rows()>0)
            {
                $this->db->set('genel_mudur_onay_saati', $date_saat);
                $this->db->set('genel_mudur_status', "1", FALSE);
                $this->db->where('file_id', $talep_id);
                $this->db->update('geopos_onay');
                foreach ($kontrol->result() as $knt)
                {


                    $this->db->set('genel_mudur_onay_saati', $date_saat);
                    $this->db->set('genel_mudur_status', "3", FALSE);
                    $this->db->set('open', 1);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('malzeme_items_id', $knt->malzeme_items_id);
                    $this->db->update('geopos_onay');
                }
            }
            else if($pers_kont2->num_rows()>0)
            {
                $this->db->set('finans_onay_saati', $date_saat);
                $this->db->set('finans_status', "1", FALSE);
                $this->db->where('file_id', $talep_id);
                $this->db->update('geopos_onay');
                foreach ($kontrol->result() as $knt)
                {
                    $this->db->set('finans_onay_saati', $date_saat);
                    $this->db->set('finans_status', "3", FALSE);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('malzeme_items_id', $knt->malzeme_items_id);
                    $this->db->update('geopos_onay');
                }
                $this->db->set('status', 3, FALSE);
                $this->db->where('id', $talep_id);
                $this->db->update('geopos_talep');

            }




            echo json_encode(array('status' => 'Success', 'message' =>"Başarıyla Güncellendi.Bekleyiniz"));
        }
        else
        {
            echo json_encode(array('status' => 'Error', 'message' =>"Proje Müdürü Onay Vermemiş"));
        }




    }

    public function update_toplu_depo_urun()
    {
        $talep_ids_array_urun = $this->input->post('talep_ids_array_urun');
        $talep_qty_array_urun = $this->input->post('talep_qty_array_urun');
        $talep_note_array_urun = $this->input->post('talep_note_array_urun');



        $list_id=explode(',',$talep_ids_array_urun);
        $list_qty=explode(',',$talep_qty_array_urun);
        $list_note=explode(',',$talep_note_array_urun);
        $status = $this->input->post('status');

        $talep_ids_array_urun_ses=array();
        $talep_qty_array_urun_ses=array();
        $talep_note_array_urun_ses=array();
        $tehvil_id=numaric(7);
        foreach ($list_id as $key=>$value)
        {
            $teslim_alinanlar_q=0;
            $siparis_qty=$this->db->query("SELECT * FROM geopos_talep_items WHERE id=$value")->row()->qty;
            $teslim_alinanlar=$this->db->query("SELECT SUM(teslim_alinan_miktar) as qty FROM geopos_depo_onay WHERE talep_item_id=$value");
            if($teslim_alinanlar->num_rows()>0)
            {
                $teslim_alinanlar_q=$teslim_alinanlar->row()->qty;
            }

            $tesl=$teslim_alinanlar_q+$list_qty[$key];

            $kalan=$siparis_qty-$tesl;
            if($kalan>0)
            {
                $status=3;// 3  Yarım Kalan Ürünler
            }


            $data_item=array
            (
                'talep_id'=>talep_id_getir($value),
                'talep_item_id'=>$value,
                'teslim_alinan_miktar'=>$list_qty[$key],
                'notes' => $list_note[$key],
                'status' => $status,
                'tehvil_id' => $tehvil_id,
                'user_id' =>$this->aauth->get_user()->id
            );
            $this->db->insert('geopos_depo_onay', $data_item);




            $onay_id = $this->db->insert_id();

            $teslim_date = $this->db->query("SELECT teslim_tarihi FROM geopos_depo_onay WHERE id=$onay_id")->row();
            $this->db->query("UPDATE `geopos_talep_items` SET `teslim_tarihi_item` ='$teslim_date->teslim_tarihi' WHERE id=$value");

            $talep_ids_array_urun_ses[]=$onay_id;
            $talep_qty_array_urun_ses[]=$list_qty[$key];
            $talep_note_array_urun_ses[]=$list_note[$key];

            $this->db->set('depo_alim_durumu', "$status", FALSE);
            $this->db->where('id', $value);
            $this->db->update('geopos_talep_items');

        }

        $this->session->set_userdata('talep_ids_array_urun', $talep_ids_array_urun_ses);
        $this->session->set_userdata('talep_qty_array_urun', $talep_qty_array_urun_ses);
        $this->session->set_userdata('talep_note_array_urun', $talep_note_array_urun_ses);
        $this->session->set_userdata('tehvil_id', $tehvil_id);

        $operator= "deger+1";
        $this->db->set('deger', "$operator", FALSE);
        $this->db->where('tip', 7);
        $this->db->update('numaric');

        echo json_encode(array(
            'status' => 'Success',
            'message' =>"Başarıyla Güncellendi Lütfen Bekleyiniz.",
            'url'=>"/form/print_tevhil_alinanlar"
        ));
    }

    public function depo_onay_bilgileri(){
        $talep_item_id = $this->input->post('id');
        $data['data']=$this->db->query("SELECT * FROM `geopos_depo_onay` WHERE talep_item_id=$talep_item_id")->result_array();
        $this->load->view('reports/view_bilgi_depo_onay', $data);

    }


    public function tehvil_alinan_urunler()
    {
        $head['title'] = "Tehvil Alınan Ürünler";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('form/tehvil_alinan_urunler');

        $this->load->view('fixed/footer');
    }

    public function print_tevhil_alinanlar()
    {
        $talep_ids_array_urun = $this->session->userdata('talep_ids_array_urun');
        $talep_qty_array_urun = $this->session->userdata('talep_qty_array_urun');
        $talep_note_array_urun = $this->session->userdata('talep_note_array_urun');
        $tehvil_id = $this->session->userdata('tehvil_id');

        $data['list_id']=$talep_ids_array_urun;
        $data['list_qty']=$talep_qty_array_urun;
        $data['list_note']=$talep_note_array_urun;
        $data['tehvil_id']=$tehvil_id;

        $html = $this->load->view('form/view-print-tevhil-' . LTR, $data, true);
        $header = $this->load->view('form/header-print-tevhil-' . LTR, $data, true);
        $footer = $this->load->view('form/footer-print-tevhil-' . LTR, $data, true);

        //PDF Rendering

        $this->load->library('pdf');


        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter($footer);
        $pdf->AddPage(
            'P', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            58, // margin top
            '72', // margin bottom
            5, 2, 0, 0, // margin header
            'auto'); // margin footer

        $pdf->WriteHTML($html);


        $file_name ='Tehvil Formu_'.$tehvil_id;

        $pdf->Output($file_name . '.pdf', 'D');


    }

    public function tehvil_dosyalari()
    {
        $head['title'] = "Tehvil Dosyaları";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('form/tehvil_dosyalari');

        $this->load->view('fixed/footer');
    }

    public function depo_dosya_view()

    {


        $tehvil_id = $this->input->get('id');






        $head['title'] = "Tehvil No ".$tehvil_id;
        $data['tehvil_no'] = $tehvil_id;

        $this->load->view('fixed/header', $head);



        $data['products'] = $this->db->query("SELECT geopos_talep_items.product_name,geopos_talep_items.firma,geopos_talep_items.unit,geopos_talep.proje_name,geopos_talep.talep_no,geopos_talep_items.qty,geopos_depo_onay.* FROM `geopos_depo_onay` INNER JOIN geopos_talep_items On geopos_depo_onay.talep_item_id=geopos_talep_items.id INNER JOIN geopos_talep On geopos_talep_items.tip=geopos_talep.id WHERE geopos_depo_onay.tehvil_id='$tehvil_id'
")->result();


        $data['attach'] = $this->db->query("SELECT * FROM geopos_depo_pdf WHERE dosya_id='$tehvil_id'")->result_array();



        $this->load->view('form/depo_dosya_view', $data);



        $this->load->view('fixed/footer');

    }


    public function meta_delete($tehvil_id, $name)

    {

        if (@unlink(FCPATH . 'userfiles/attach/' . $name)) {

            return $this->db->delete('geopos_depo_pdf', array('dosya_id' => "$tehvil_id", 'dosya_name' => $name));

        }

    }

    public function depo_file_handling()

    {

        if ($this->input->get('op')) {

            $name = $this->input->get('name');

            $invoice = $this->input->get('invoice');

            if ($this->meta_delete($invoice, $name)) {

                echo json_encode(array('status' => 'Success'));

            }

        } else {

            $id = $this->input->get('id');

            $this->load->library("Uploadhandler_generic", array(

                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'

            ));

            $files = (string)$this->uploadhandler_generic->filenaam();

            if ($files != '') {



                $this->meta_insert($id,$files);

            }

        }





    }

    public function meta_insert($id, $meta_data)

    {

        $data = array('dosya_id' => "$id", 'dosya_name' => $meta_data);

        if ($id) {

            return $this->db->insert('geopos_depo_pdf', $data);

        } else {

            return 0;

        }

    }


    public function bekleyen_talep_onay_pers_id(){


        $loc= $this->session->userdata('set_firma_id');


        $list = $this->db->query("Select * From talep_form Where status not in (13,10,9) and talep_form.bildirim_durumu=1 and 
talep_form.loc=$loc")->result();


        $mt_pers_id = [];
        $gt_pers_id = [];
        $at_pers_id = [];
        foreach ($list as $prd) {
            $staff_id=mt_onay_pers($prd->id,$prd->status)['pers_id'];
            $mt_pers_id[]=$staff_id;
        }

        $this->session->set_userdata('mt_talep_pers',array_unique($mt_pers_id));





        $select = $this->db->query("Select * From talep_form_customer_new Where status not in (13,10,9) and talep_form_customer_new.bildirim_durumu=1 and 
talep_form_customer_new.type=1  and talep_form_customer_new.loc=$loc")->result();

        foreach ($select as $prd) {
            $staff_id_2=gt_onay_pers($prd->id,$prd->status,1)['pers_id'];
            $gt_pers_id[]=$staff_id_2;
        }



        $list3 = $this->db->query("Select * From talep_form_customer_new Where status not in (13,10,9) and talep_form_customer_new.bildirim_durumu=1 and 
talep_form_customer_new.type=2  and talep_form_customer_new.loc=$loc")->result();
        foreach ($list3 as $prd) {
            $staff_id_3=gt_onay_pers($prd->id,$prd->status,2)['pers_id'];
            $at_pers_id[]=$staff_id_3;
        }

        $array_uniq = array_merge($at_pers_id,$gt_pers_id);
        $this->session->set_userdata('cari_talep_pers',array_unique($array_uniq));


    }
    public function test()
    {
        $this->load->view('fixed/header');

        $this->load->view('form/test');

        $this->load->view('fixed/footer');
    }


    public function bekleyen_talepler()
    {


        $head['title'] = "Onay Bekleyen Talepler";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['taleps'] = array();
        $data['pers_id'] = 0;
        if($_GET)
        {
            $tip = $this->input->get('tip');
            $proje_id = $this->input->get('proje_id');
            $pers_id = $this->input->get('pers_id');

            $tip_where='and tip IN(1,5,4)';
            $proje_where='';
            if($tip!=0)
            {
                $tip_where=" and tip IN($tip)";
            }
            if($proje_id!=0)
            {
                $proje_where=" and proje_id =$proje_id";
            }
            if($pers_id!=0)
            {
                $data['pers_id']=$pers_id;
            }

            $data['taleps'] = $this->db->query("SELECT * FROM geopos_talep WHERE status=1 and bildirim_durumu=1 $tip_where  $proje_where ORDER BY id desc")->result();
        }
        else
        {
            $data['taleps'] = $this->db->query("SELECT * FROM geopos_talep WHERE status=1 and bildirim_durumu=1 and tip IN(1,5,4) ORder BY id desc")->result();
        }

        $this->bekleyen_talep_onay_pers_id();
        $this->load->view('fixed/header', $head);

        $this->load->view('form/onay_bekleyen_talepler',$data);

        $this->load->view('fixed/footer');
    }


    public function avans_file_handling()

    {

        if ($this->input->get('op')) {

            $name = $this->input->get('name');

            $invoice = $this->input->get('talep_id');

            if ($this->requested->meta_delete($invoice, 100, $name)) {

                echo json_encode(array('status' => 'Success'));

            }

        } else {

            $id = $this->input->get('id');

            $this->load->library("Uploadhandler_generic", array(

                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'

            ));

            $files = (string)$this->uploadhandler_generic->filenaam();

            if ($files != '') {



                $this->requested->meta_insert($id, 100, $files);

            }

        }





    }

    public function malzeme_hareket_listesi()
    {

        $data=array();
        $tid = $this->input->get('id');
        $head['title'] = "Talep No " . $tid;

        $data['malzeme_talep_bilgileri'] = $this->requested->invoice_details($tid, $this->limited);
        $data['malzeme_talep_bilgileri_details'] = $this->requested->invoice_products($tid);

        $ihale_id=0;
        $satin_alma_id=0;
        $data['satin_alma_id']=0;
        $data['ihale']='';

        $ihale=$this->db->query("SELECT * FROM `ihale_to_malzeme_talep` WHERE malzeme_talep_id=$tid");
        if($ihale->num_rows()>0)
        {
            $ihale_id=$ihale->row()->ihale_id;
            $data['ihale_id']=$ihale_id;
        }
        if($ihale_id==0)
        {
            $satin_alma=$this->db->query("SELECT * FROM `geopos_talep` WHERE malzeme_talep_form_id=$tid");
            if($satin_alma->num_rows()>0)
            {
                $satin_alma_id=$satin_alma->row()->id;
            }


        }
        else
        {
            $data['ihale']=$this->ihale->dosya_details($ihale_id);

            $satin_alma=$this->db->query("SELECT * FROM `geopos_talep` WHERE ihale_formu_id=$ihale_id");
            if($satin_alma->num_rows()>0)
            {
                $satin_alma_id=$satin_alma->row()->id;
            }

        }



        if($satin_alma_id!=0)
        {
            $string='proje_muduru_status';
            $data['urunler']=$this->db->query("SELECT * FROM `geopos_talep_items` WHERE tip=$satin_alma_id and ref_urun=0 GROUP BY product_name")->result_array();
            $data['data']=$this->db->query("SELECT * FROM `geopos_talep_items` WHERE tip=$satin_alma_id and ref_urun=0 ORDER BY `geopos_talep_items`.`product_name`,geopos_talep_items.price ASC")->result_array();
            $user_id = $this->aauth->get_user()->id;
            $dettais=$this->db->query("SELECT * FROM `geopos_talep` where id=$satin_alma_id ")->row();
            if($dettais->proje_muduru_id==$user_id)
            {
                $string='proje_muduru_status';
            }
            else if($dettais->genel_mudur_id==$user_id)
            {
                $string='genel_mudur_status';
            }
            else if($dettais->finans_departman_pers_id==$user_id)
            {
                $string='finans_status';
            }
            $data['string']=$string;
            $data['satin_alma_id']=$satin_alma_id;
        }

        $data['satinalma'] = $this->requested->invoice_details($satin_alma_id, $this->limited);


        if($satin_alma_id!=0)
        {
            $invoice=$this->db->query("SELECT * FROM `geopos_invoices` WHERE malzeme_talep_id=$tid or satinalma_talep_id=$satin_alma_id");
        }
        else
        {
            $invoice=$this->db->query("SELECT * FROM `geopos_invoices` WHERE malzeme_talep_id=$tid");
        }

        if($invoice->num_rows()>0)
        {
            $invoice_details=$invoice->row();
            $data['fatura']=$invoice_details;
            $data['products'] = $this->invoices_model->invoice_products($invoice_details->id);
            $data['rulo_miktari'] = rulo_miktari_sorgula($invoice_details->id,'invoice');
        }




        $this->load->view('fixed/header', $head);

        $this->load->view('form/malzeme_hareket_listesi',$data);

        $this->load->view('fixed/footer');
    }

    public function ajax_list_talep_view()

    {


        $talep_id = $this->input->post('tip');

        $depo_mudur_id = talep_user_id_ogren('bolum_mudur_id',$talep_id);

        $kullanici_id = $this->aauth->get_user()->id;

        $list = $this->requested->get_datatables_prd($this->limited);


        $data = array();

        $no = $this->input->post('start');
        $id = $this->input->post('tip');

        $this->session->set_userdata('test', 1);

        $sub_t=0;
        foreach ($list as $invoices) {

            $product_id=$invoices->product_id;
            $opt="";
            $satinalma_= $this->db->query("SELECT * FROM `geopos_onay` Where `type`=1 and file_id=$id and product_id=$product_id")->row_array();

            $sub_t += $invoices->price * $invoices->qty;



            $image='';
            $prd=$this->db->query("SELECT * FROM geopos_products WHERE pid=$product_id");
            if($prd->num_rows()>0)
            {
                $image= $prd->row()->image;
            }

            $no++;

            $row = array();
            $row[] = $no;
            $row[] = '<span class="avatar-lg align-baseline"><img class="myImg" resim_yolu="' . base_url() . 'userfiles/product/' . $image . '" src="' . base_url() . 'userfiles/product/thumbnail/' . $image . '" ></span> &nbsp;';

            $row[] = $invoices->product_name;
            $row[] = $invoices->product_detail;
            $row[] = round($invoices->qty,2).' '.$invoices->unit;
            $row[] = purchase_status(onay_durumlari_ogren_product_str(1,$id,$invoices->id,"proje_sorumlusu_status")['durum']).' </br>'.(onay_durumlari_ogren_product_onay_saati(1,$id,$invoices->id,"proje_sorumlusu_onay_saati")['onay_saati']);
            $row[] = purchase_status(onay_durumlari_ogren_product_str(1,$id,$invoices->id,"proje_muduru_status")['durum']).' </br>'.(onay_durumlari_ogren_product_onay_saati(1,$id,$invoices->id,"proje_muduru_onay_saati")['onay_saati']);
            $row[] = purchase_status(onay_durumlari_ogren_product_str(1,$id,$invoices->id,"bolum_muduru_status")['durum']).' </br>'.(onay_durumlari_ogren_product_onay_saati(1,$id,$invoices->id,"bolum_muduru_saati")['onay_saati']).' </br><span style="font-weight: 900;">'.malzeme_talep_depo_miktari($id,$invoices->id).' '.$invoices->unit.' Depo Müdürü Var Olarak İşaretledi</span>';
            $row[] = purchase_status(onay_durumlari_ogren_product_str(1,$id,$invoices->id,"genel_mudur_status")['durum']).' </br>'.(onay_durumlari_ogren_product_onay_saati(1,$id,$invoices->id,"genel_mudur_onay_saati")['onay_saati']);
            $data[] = $row;




        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->requested->count_all_prd($this->limited),

            "recordsFiltered" => $this->requested->count_filtered_prd($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }

    public function invoice_depo_urunler_view()

    {



        $list = $this->invoices_model->get_datatables_depo_urunler($this->limited);






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



            $image='';
            $prd=$this->db->query("SELECT * FROM geopos_products WHERE pid=$invoices->product_id");
            if($prd->num_rows()>0)
            {
                $image= $prd->row()->image;
            }

            $image='<span class="avatar-lg align-baseline"><img class="myImg" resim_yolu="' . base_url() . 'userfiles/product/' . $image . '" src="' . base_url() . 'userfiles/product/thumbnail/' . $image . '" ></span> &nbsp;';

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
            else
            {

                $tm= "<a href='#pop_model_depo_bilgi' malzeme_talep_id='$malzeme_talep_id' data-toggle='modal' data-remote='false' class='pop_model_depo_bilgi btn btn-info'>".round($teslim_alinan_mik,2).' '.$unit."</a>";
                $notes=depo_notes_ogren($malzeme_talep_id);
                $kalan_=round($kalan,2).' '.$unit;
            }

            $date='-';
            if($status!=1)
            {
                $date = dateformat($invoices->teslim_tarihi_item);
            }

            $row[] =$no ;
            $row[] = $talep_no;
            $row[] = $proje_name;
            $row[] =  $firma;
            $row[] =$image ;
            $row[] = $product_name;
            $row[] = round($miktar,2).' '.$unit;
            $row[] = $tm;
            $row[] = $kalan_;
            $row[] = $notes;
            $row[] = $status_;
            $row[] = $sorumlu_pers;
            $row[] =$date ;
            if($this->input->post('tip')==2) // tehvil alınanlar
            {
                $row[] = $tehvil_id;
            }
            else
            {
                $row[] ='';
            }


            $data[] = $row;

        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->invoices_model->count_all_depo_urunler($this->limited),

            "recordsFiltered" => $this->invoices_model->count_filtered_depo_urunler($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }

    public function status_change() {
        $id =  $this->input->post('talep_id');
        $status_id =  $this->input->post('status_id');

        $this->db->set('status', $status_id, FALSE);
        $this->db->where('id', $id);
           if( $this->db->update('geopos_talep')){
               echo json_encode(array('status' => 'Success', 'message' =>

                   "Başarıyla Talebiniz Güncellendi."));
           }
           else {
               echo json_encode(array('status' => 'Error', 'message' =>

                   "Hata Oluştu."));
           }



    }

    public function creat_new_notes(){
        $islem_tipi = $this->input->post('islem_tipi');
        $islem_id = $this->input->post('islem_id');
        $desc = $this->input->post('desc');

        $this->db->trans_start();
          $data = array(
              'islem_id' => $islem_id,
              'islem_tipi' => $islem_tipi,
              'notes' => $desc,
              'user_id' => $this->aauth->get_user()->id,

          );
        if ($this->db->insert('form_all_notes', $data)) {
            $this->db->trans_complete();
            echo json_encode(array('status' => 200,'messages'=>'Başarıyla Kayıt Oluşturuldu'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410,'messages'=>'Hata Aldınız'));
        }

    }

    public function delete_new_notes(){
        $id = $this->input->post('id');
        $user_id = $this->aauth->get_user()->id;
        $this->db->trans_start();
        $kontolr = $this->db->query("SELECT * FROM form_all_notes Where id = $id and user_id=$user_id")->num_rows();
        if($kontolr){
            if($this->db->delete('form_all_notes', array('id' => $id))){
                $this->db->trans_complete();
                echo json_encode(array('status' => 200,'messages'=>'Kayıt Silindi'));
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410,'messages'=>'Hata Aldınız'));
            }

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410,'messages'=>'Notu Sadece Oluşturan Personel Silebilir'));
        }

    }



}
