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
require_once FCPATH . 'application/third_party/vendor/autoload.php';

use Twilio\Rest\Client;

class Billing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('invoices_model', 'invocies');
        $this->load->model('billing_model', 'billing');
        $this->load->model('plugins_model', 'plugins');
        $this->load->model('employee_model', 'employee');

        $this->load->library("Common");

        $this->load->model('invoices_model');
        $this->load->model("requested_model", 'requested');
        $this->load->model("ihale_model", 'ihale');

        $this->load->library("Aauth");
        $this->load->model('communication_model');
        $this->load->model('tools_model', 'tools');

    }

    public function print_form()
    {
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));

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

        $html = $this->load->view('invoices/print_form', $data, true);

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

    public function print_satinalma()

    {

        $tid = $this->input->get('id');

        $data['id'] = $tid;


        $data['invoice'] = $this->requested->invoice_details($tid, $this->limited);

        //$data['products'] = $this->requested->invoice_products($tid);
        $data['products'] = $this->requested->invoice_products_($tid);
        //echo "<pre>";print_r($data['products']);die();


        ini_set('memory_limit', '9999M');


        $html = $this->load->view('requested/view-print-satinalma-' . LTR, $data, true);
        $header = $this->load->view('requested/header-print-satinalma-' . LTR, $data, true);
        $footer = $this->load->view('requested/footer-print-satinalma-' . LTR, $data, true);

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
            69, // margin top
            55, // margin bottom
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
    public function printinvoice_()

    {


        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));

        $tid = $this->input->get('id');

        $data['id'] = $tid;



        $data['invoice'] = $this->invocies->invoice_details($tid);

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


    public function invoice_update()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = $this->input->get('id');

        $token = $this->input->get('token');
        $head['title'] = 'Fatura Detayları!';
        $data['token'] = $token;
        $this->load->model('accounts_model');

        $data['id'] = $tid;
        $data['token'] = $token;

        $data['invoice'] = $this->invocies->invoice_details($tid);
        $data['online_pay'] = $this->billing->online_pay_settings();
        $data['products'] = $this->invocies->invoice_products($tid);
        $data['activity'] = $this->invocies->invoice_transactions($tid);
        $data['attach'] = $this->invocies->attach($tid);


        $data['employee'] = $this->invocies->employee($data['invoice']['eid']);

        $head['usernm'] = '';
        $head['title'] = "Invoice " . $data['invoice']['tid'];

        $this->load->view('billing/header', $head);
        $this->load->view('billing/view',$data);
        $this->load->view('billing/footer');




    }

    public function izin_onay()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = $this->input->get('id');
        $pers_id = $this->input->get('pers_id');

        $token = $this->input->get('token');
        $head['title'] = 'İzin Detayları';
        $data['token'] = $token;
        $this->load->model('accounts_model');

        $data['id'] = $tid;
        $data['pers_id'] = $pers_id;
        $data['token'] = $token;
        $data['detail']=$this->db->query("SELECT * FROM geopos_izinler WHERE id=$tid")->row_array();


        $head['usernm'] = '';
        $head['title'] = "İzin Detayları ";

        $this->load->view('billing/header', $head);
        $this->load->view('billing/izin_detay',$data);
        $this->load->view('billing/footer');



    }

    public function update_status_invoice()

    {

        $tid = $this->input->post('tid');

        $status = $this->input->post('status');
        $proje_id = $this->input->post('proje_id');
        $desc  = $this->input->post('desc');





        $this->db->set('status', $status);
        $this->db->set('proje_id', $proje_id);
        $this->db->set('pers_notes', $desc);
        $this->db->where('id', $tid);
        $this->db->update('geopos_invoices');

        $_pers_id = $this->db->query("SELECT * FROM sms_log Where invoice_id = $tid")->row_array()['pers_id'];

        $this->aauth->applog("Fatura Durumu Güncellendi Status = $status  Fatura ID $tid ID ",$_pers_id);

        $productlist = $this->invocies->invoice_products($tid);

        if($proje_id!=0)
        {
            $kont = $this->db->query("SELECT * FROM `geopos_project_items_gider`  WHERE tid=$tid and proje_id=$proje_id")->num_rows();

            if($kont==0)
            {
                foreach ($productlist as $prd)
                {

                    $data = array(

                        'tid' => $tid,

                        'pid' => $prd['pid'],

                        'product' => $prd['product'],

                        'code' => $prd['code'],

                        'qty' => $prd['qty'],

                        'price' => $prd['price'],

                        'tax' => $prd['tax'],

                        'discount' => $prd['discount'],

                        'subtotal' => $prd['subtotal'],

                        'totaltax' => $prd['totaltax'],

                        'totaldiscount' => $prd['totaldiscount'],

                        'product_des' => $prd['product_des'],

                        'unit' => $prd['unit'],

                        'invoice_type_id' => $prd['invoice_type_id'],

                        'proje_id' => $proje_id,

                        'depo_id' => $prd['depo_id'],

                        'item_desc' => $prd['item_desc'],

                        'invoice_type_desc' => invoice_type_id($prd['invoice_type_id'])
                    );
                    $this->db->insert('geopos_project_items_gider', $data);
                }
            }

        }







        echo json_encode(array('status' => 'Success', 'message' =>

            $this->lang->line('UPDATED'), 'pstatus' => 'Başarılı'));

    }

    public function gorusme_onay()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = $this->input->get('id');
        $token = $this->input->get('token');
        $pers_id = $this->input->get('pers_id');

        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));


        /*
        $this->db->set('status', 3);

        $this->db->where('id', $tid);

        if($this->db->update('geopos_notes'))
        {

            $head['title'] = 'Başarılı!';
            $data["deger"]=1;
            $this->load->view('billing/header', $head);
            $this->load->view('billing/basarili',$data);

        }
        */


        $head['title'] = 'Görüşme Detayları!';
        $data['detail']=$this->db->query("SELECT * FROM geopos_notes WHERE id=$tid")->row_array();

        $this->load->view('billing/header', $head);
        $this->load->view('billing/gorusme_detay',$data);
        $this->load->view('billing/footer');




    }

    public function izin_talebi_onay()
    {
        $id = $this->input->post('izin_id');
        $pers_id = $this->input->post('pers_id');
        $status = $this->input->get('tip');
        $mesaj='';
        $dbnames = $this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
        $firma_kodu = $dbnames['firma_kodu'];
        $validtoken = hash_hmac('ripemd160', 'p' . $id, $this->config->item('encryption_key'));

        $href='';
        $query=$this->db->query("SELECT * FROM geopos_izinler Where id=$id and (bolum_sorumlusu=$pers_id or genel_mudur=$pers_id or bolum_pers_id=$pers_id or finans_pers_id=$pers_id)");

        if($query->num_rows()>0)
        {

            if($status!=3)
            {

                if($query->row()->bolum_pers_id==$pers_id) // Sorumlu Personel
                {
                    $yeni_pers_id = $query->row()->bolum_sorumlusu;
                    $this->db->set('bolum_pers_status', "$status");
                    if($status==1)
                    {
                        $this->db->set('izin_tipi', "Ödenişli");
                    }
                    else if($status==2)
                    {
                        $this->db->set('izin_tipi', "Öz Hesabına");
                    }

                    $this->db->where('id', $id);
                    $this->db->update('geopos_izinler');

                    $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$id&pers_id=$yeni_pers_id&type=izin_onay&token=$validtoken";

                    $short_url = $this->getSmallLink($href);

                    $mesaj='Sayın Yetkili, '.$query->row()->emp_fullname.' ait izin talebini Şube Müdürü Onaylamıştır.Sizin Onayınız Bekleniyor. '.$short_url;
                }

                if($query->row()->bolum_sorumlusu==$pers_id) //ofis Menejeri
                {
                    if($query->row()->finas_pers_status==0)
                    {
                        $yeni_pers_id = $query->row()->finans_pers_id;
                        $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$id&pers_id=$yeni_pers_id&type=izin_onay&token=$validtoken";

                        $short_url = $this->getSmallLink($href);

                        $mesaj='Sayın Finans Muduru, '.$query->row()->emp_fullname.' ait izin talebini Ofis Menejeri Onaylamıştır.Sizin Onayınız Bekleniyor. '.$short_url;
                    }
                    else  if($query->row()->genel_mudur_status==0)
                    {
                        $yeni_pers_id = $query->row()->genel_mudur;
                        $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$id&pers_id=$yeni_pers_id&type=izin_onay&token=$validtoken";

                        $short_url = $this->getSmallLink($href);

                        $mesaj='Sayın Genel Mudur, '.$query->row()->emp_fullname.' ait izin talebini Ofis Menejeri Onaylamıştır.Sizin Onayınız Bekleniyor. '.$short_url;
                    }
                    else
                    {
                        $yeni_pers_id =$query->row()->emp_id;
                        $mesaj='Sayın Yetkili, izin talebiniz Onaylamıştır';
                    }



                    $this->db->set('status', "$status");
                    if($status==1)
                    {
                        $this->db->set('izin_tipi', "Ödenişli");
                    }
                    else if($status==2)
                    {
                        $this->db->set('izin_tipi', "Öz Hesabına");
                    }

                    $this->db->where('id', $id);
                    $this->db->update('geopos_izinler');




                }


                if($query->row()->finans_pers_id==$pers_id) // Finans Müdür
                {
                    $yeni_pers_id = $query->row()->genel_mudur;
                    $this->db->set('finas_pers_status', "$status");
                    if($status==1)
                    {
                        $this->db->set('izin_tipi', "Ödenişli");
                    }
                    else if($status==2)
                    {
                        $this->db->set('izin_tipi', "Öz Hesabına");
                    }

                    $this->db->where('id', $id);
                    $this->db->update('geopos_izinler');

                    if($query->row()->status==0)
                    {
                        $yeni_pers_id = $query->row()->bolum_sorumlusu;

                        $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$id&pers_id=$yeni_pers_id&type=izin_onay&token=$validtoken";

                        $short_url = $this->getSmallLink($href);

                        $mesaj='Sayın Ofis Menejeri, '.$query->row()->emp_fullname.' ait izin talebini HR Müdürü Onaylamıştır.Sizin Onayınız Bekleniyor. '.$short_url;
                    }
                    else
                    {
                        $yeni_pers_id = $query->row()->genel_mudur;
                        $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$id&pers_id=$yeni_pers_id&type=izin_onay&token=$validtoken";

                        $short_url = $this->getSmallLink($href);

                        $mesaj='Sayın Genel Mudur, '.$query->row()->emp_fullname.' ait izin talebini HR Müdürü Onaylamıştır.Sizin Onayınız Bekleniyor. '.$short_url;
                    }


                }


                if($query->row()->genel_mudur==$pers_id) // Genel Müdür
                {
                    $yeni_pers_id =$query->row()->emp_id;

                    $this->db->set('genel_mudur_status', "$status");
                    if($status==1)
                    {
                        $this->db->set('izin_tipi', "Ödenişli");
                    }
                    else if($status==2)
                    {
                        $this->db->set('izin_tipi', "Öz Hesabına");
                    }

                    $this->db->where('id', $id);
                    $this->db->update('geopos_izinler');

                    $mesaj='Sayın Yetkili izin talebiniz onaylanmistir.';


                }
            }
            else
            {

                if($query->row()->bolum_sorumlusu==$pers_id)
                {
                    $this->db->set('status', "$status");
                }
                if($query->row()->bolum_pers_id==$pers_id)
                {
                    $this->db->set('bolum_pers_status', "$status");
                }
                if($query->row()->finans_pers_id==$pers_id)
                {
                    $this->db->set('finas_pers_status', "$status");
                }
                if($query->row()->genel_mudur==$pers_id)
                {
                    $this->db->set('genel_mudur_status', "$status");
                }


                $this->db->where('id', $id);
                $this->db->update('geopos_izinler');
                $yeni_pers_id =$query->row()->emp_id;
                $mesaj='Sayın Yetkili, izin talebininiz İptal Edilmiştir.';
            }



            $mobile_ = personel_detailsa($yeni_pers_id)['phone'];
            $message_=$this->mesaj_gonder($mobile_,$mesaj);
            if($message_==1)
            {
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
            }
            else
            {
                echo json_encode(array('status' => 'Error', 'message' =>
                    'Hata Olustu', 'pstatus' => 'Hata Olustu'));
            }




        }
        else
        {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED'), 'pstatus' => 'Yetkiniz Yoktur'));
        }





    }
    public function gorusme_onay_ajax()
    {
        $id = $this->input->post('id');
        $status = $this->input->get('tip');

        if($status==12)
        {
            $status=$this->input->post('diger');
        }

        $this->db->set('status', "$status");

        $this->db->where('id', $id);

        if($this->db->update('geopos_notes'))
        {

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
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
        //echo "<pre>";print_r($result);
        //die();
        curl_close($ch);

        return 1;




    }




    public  function getSmallLink($longurl){
        $sayi=rand(1,99999999);
        $name='makro2000'.$sayi;
        $url = urlencode("$longurl");
        $json = file_get_contents("https://cutt.ly/api/api.php?key=e67f08835022a9c59b736d5c9e109ba5a8c4a&short=$url&name=$name");
        $data = json_decode ($json, true);

        return $data['url']['shortLink'];

    }



    // Malzeme talep formu toplu onaylama
    public function malzeme_talep_product_status_toplu()
    {
        $talep_id = $this->input->post('talep_id')[0];
        $product_id = $this->input->post('product_id');
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
                                'malzeme_items_id' => $value,
                                'proje_sorumlusu_onay_saati' => $date_saat,
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
                if ($query->row()->bolum_mudur_id == $kullanici)    //bolum müdürü onayladı
                {
                    $ind=0;
                    foreach ($product_id as $key=>$value)
                    {
                        $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and malzeme_items_id=$value");
                        if ($onay_kontrol->num_rows() > 0) {
                            //update
                            $this->db->set('satinalma_yonlendirme', $satin_alma_[$key]);
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
                            $this->db->set('genel_mudur_onay_saati	', $date_saat);
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
        }

    }
    // Malzeme talep formu toplu onaylama


    public function malzeme_talep_product_status()
    {

        $satin_alma_='';
        if($this->input->post('satin_alma_'))
        {
            $satin_alma_ = $this->input->post('satin_alma_');
        }
        $talep_id = $this->input->post('talep_id');
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
                    $this->db->set('proje_sorumlusu_onay_saati	', $date_saat);
                    $this->db->set('proje_sorumlusu_status_note', $note);
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


            if ($query->row()->bolum_mudur_id == $kullanici)  //Bölüm Müdürü onayladı

            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=1 and file_id=$talep_id  and malzeme_items_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('satinalma_yonlendirme', $satin_alma_);
                    $this->db->set('bolum_muduru_status', $status);
                    $this->db->set('bolum_muduru_status_note', $note);
                    $this->db->set('bolum_muduru_saati', $date_saat);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 1);
                    $this->db->where('malzeme_items_id', $product_id);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'satinalma_yonlendirme' => $satin_alma_,
                        'proje_muduru_status' => $status,
                        'bolum_muduru_status_note' => $date_saat,
                        'bolum_muduru_saati' => $note,
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
                echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Onaylandı', 'pstatus' => $status));
            }
            else if($status==4) {
                echo json_encode(array('status' => 'Warning', 'message' => 'Başarıyla İptal İşleminiz Gerçekleşti', 'pstatus' => $status));
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
                $talep=$talep_no=$query->row()->proje_name.'-'.$query->row()->talep_no;
                $mobile_ = personel_detailsa($querys_->satinalma_yonlendirme)['phone'];
                $mesaj="Sayın Yetkili ".$talep." Numaralı Malzeme Talep Formundan bazı ürünlerin satın alma islemi size atanmıştır. Programa giris yaparak satın alma formundan islemlerinize baslayabilirsiniz.";
                //$message_=$this->mesaj_gonder($mobile_,$mesaj);


            }
            $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Genel Müdür Tarafından Değiştirildi.Satın Alma Formu Oluşturabilirsiniz.';

            if($this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili',$talep_id))
            {
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('UPDATED'), 'pstatus' => 'Başarıyla İşleminiz Tamamlandı'));
                exit;
            }

            /* if($message_==1)
             {

             } */

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



        if($this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili', $talep_id))
        {

            if($mobile!='')
            {
                $short_url = $this->getSmallLink($href);
                $mesaj=$talep_no." Numaralı Malzeme Talep Formunu Incelemek icin tiklayiniz. ".$short_url;
                // $message = $this->mesaj_gonder($mobile,$mesaj);
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

    // Gider talep formu toplu onaylama
    public function gider_talep_product_status_toplu()
    {
        $talep_id = $this->input->post('talep_id')[0];
        $product_id = $this->input->post('product_id');
        $kullanici = $this->input->post('pers_id')[0];
        $note = $this->input->post('note');
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
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and product_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('proje_sorumlusu_status	', $status);
                        $this->db->set('proje_sorumlusu_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('product_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'proje_sorumlusu_status' => $status,
                            'product_id' => $value,
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
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and product_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('proje_muduru_status	', $status);
                        $this->db->set('proje_muduru_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('product_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'proje_muduru_status' => $status,
                            'product_id' => $value,
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
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and product_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('bolum_muduru_status	', $status);
                        $this->db->set('bolum_muduru_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('product_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'bolum_muduru_status' => $status,
                            'product_id' => $value,
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
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and product_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('genel_mudur_status	', $status);
                        $this->db->set('genel_mudur_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('product_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'genel_mudur_status' => $status,
                            'product_id' => $value,
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
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and product_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('finans_status	', $status);
                        $this->db->set('finans_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('product_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'finans_status' => $status,
                            'product_id' => $value,
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

    // Gider talep formu toplu onaylama


    public function gider_talep_product_status()
    {

        $talep_id = $this->input->post('talep_id');
        $product_id = $this->input->post('product_id');
        $kullanici = $this->input->post('pers_id');
        $status = $this->input->post('status');
        $note = $this->input->post('note');
        $tip = $this->input->post('tip');
        $subject='';
        $message='';
        $recipients=array();


        $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and (proje_sorumlusu_id=$kullanici or proje_muduru_id=$kullanici  or bolum_mudur_id=$kullanici or genel_mudur_id=$kullanici  or finans_departman_pers_id=$kullanici) ");

        if ($query->num_rows() > 0) {

            if ($query->row()->proje_sorumlusu_id == $kullanici)    //proje sorumlusu onayladı
            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and product_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('proje_sorumlusu_status	', $status);
                    $this->db->set('proje_sorumlusu_status_note', $note);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->where('product_id', $product_id);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'proje_sorumlusu_status' => $status,
                        'product_id' => $product_id,
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


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and product_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('proje_muduru_status	', $status);
                    $this->db->set('proje_muduru_status_note', $note);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->where('product_id', $product_id);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'proje_muduru_status' => $status,
                        'proje_muduru_status_note' => $note,
                        'product_id' => $product_id,
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


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id  and product_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('bolum_muduru_status', $status);
                    $this->db->set('bolum_muduru_status_note', $note);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'proje_muduru_status' => $status,
                        'bolum_muduru_status_note' => $note,
                        'product_id' => $product_id,
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


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id  and product_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('genel_mudur_status', $status);
                    $this->db->set('genel_mudur_status_note', $note);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'genel_mudur_status' => $status,
                        'genel_mudur_status_note' => $note,
                        'product_id' => $product_id,
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


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id  and product_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('finans_status', $status);
                    $this->db->set('finans_status_note', $note);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'finans_status' => $status,
                        'finans_status_note' => $note,
                        'product_id' => $product_id,
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


    public function satinalma_users()
    {

        $this->db->select('geopos_users.email');
        $this->db->from('geopos_employees');
        $this->db->where('geopos_employees.dept', 1);
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id');
        $query = $this->db->get();
        $data = array();
        foreach ($query->result_array() as $q) {
            $data[] = $q['email'];
        }
        return $data;
    }

    public function onay()
    {
        if (!$this->input->get()) {
            exit();
        }

        $tid = $this->input->get('sayim_id');
        $token = $this->input->get('token');
        $sayim_details=$this->billing->sayim_details($tid);
        $personel_id=$sayim_details['eid'];
        $sayim_durumu=$sayim_details['onay_durumu'];

        $onaylayan=sayim_onay_mail();



        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));


        if (hash_equals($token, $validtoken))
        {
            if($sayim_durumu==0)
            {
                if($this->billing->sayim_update($tid))
                {
                    $this->db->set('onaylayan_user_id', $onaylayan['user_id']);

                    $this->db->where('sayim_id', $tid);

                    $this->db->update('geopos_purchase');
                    $data['deger']=1;;

                    //Stoklar Düşmüştür.
                    //personele onaylandığına dair görev atanmıştır.
                    if($personel_id!=0)
                    {
                        $name =  'Sayım İçin Yükleme Emri';

                        $status = '1';

                        $priority = 'High';

                        $employee = $personel_id;
                        $sayim_name=$sayim_details['sayim_name'];
                        $content = $sayim_name.' İsimli sayım yönetici tarafından onaylanmıştır.Gerekli çıkış işlemlerini yapabilirsiniz';



                        $assign = -1;


                        $this->tools->addtask_sayim($name, $status, $priority, $employee, $assign, $content,$tid);




                    }
                    //personele onaylandığına dair görev atanmıştır.


                }
                else
                {
                    $data['deger']=0;
                }
            }
            else if($sayim_durumu==2)
            {
                $data['deger']=4;
            }
            else
            {
                $data['deger']=2;
            }

            $head['title'] = 'Başarılı!';
            $this->load->view('billing/header', $head);
            $this->load->view('billing/basarili',$data);
            $this->load->view('billing/footer');
        }
    }
    public function onay_red()
    {
        if (!$this->input->get()) {
            exit();
        }

        $tid = $this->input->get('sayim_id');
        $token = $this->input->get('token');
        $sayim_details=$this->billing->sayim_details($tid);
        $personel_id=$sayim_details['eid'];
        $sayim_durumu=$sayim_details['onay_durumu'];


        $onaylayan=sayim_onay_mail();



        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));


        if (hash_equals($token, $validtoken))
        {
            if($sayim_durumu==0 )
            {

                $this->db->set('onay_durumu', 2);
                $this->db->set('new_status', 'siparis_red');

                $this->db->where('id', $tid);

                $this->db->update('geopos_sayim');



                $data['deger']=3;

            }
            else if($sayim_durumu==2)
            {
                $data['deger']=4;
            }
            else
            {
                $data['deger']=2;
            }

            $head['title'] = 'Başarılı!';
            $this->load->view('billing/header', $head);
            $this->load->view('billing/basarili',$data);
            $this->load->view('billing/footer');
        }
    }

    public function view()
    {

        if (!$this->input->get()) {
            exit();
        }



        $tid = $this->input->get('id');
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {

            $this->load->model('accounts_model');
            $data['acclist'] = $this->accounts_model->accountslist();

            $data['id'] = $tid;
            $data['token'] = $token;

            $data['invoice'] = $this->invocies->invoice_details($tid);
            $data['online_pay'] = $this->billing->online_pay_settings();
            $data['products'] = $this->invocies->invoice_products($tid);
            $data['activity'] = $this->invocies->invoice_transactions($tid);
            $data['attach'] = $this->invocies->attach($tid);


            $data['employee'] = $this->invocies->employee($data['invoice']['eid']);

            $head['usernm'] = '';
            $head['title'] = "Invoice " . $data['invoice']['tid'];
            $this->load->view('billing/header', $head);
            $this->load->view('billing/view', $data);
            $this->load->view('billing/footer');
        }

    }


    public function sayim_listesi()
    {

        if (!$this->input->get()) {

            exit();
        }



        $tid = $this->input->get('id');
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));



        if (hash_equals($token, $validtoken)) {

            $head['title'] = "Sayım Raporu $tid";

            $this->load->model('sayim_model', 'sayim');
            $data['invoice'] = $this->sayim->sayim_details($tid);

            $data['tid'] = $tid;
            $data['products'] = $this->sayim->sayim_products($tid);

            $this->load->view('billing/header', $head);
            $this->load->view('billing/sayim_rapor_view', $data);
            $this->load->view('billing/footer');
        }

    }


    public function updata_car_status(){
        $pers_id = $this->input->post('pers_id');
        $aaut_id = $this->input->post('aaut_id');
        $desc = $this->input->post('desc');
        $personel_histort_id = $this->input->post('personel_histort_id');
        $status = $this->input->post('status');

        if($pers_id){

            $data_insert=[
                'lojistik_arac_personel_history_id' =>$personel_histort_id,
                'status' =>$status,
                'user_id' =>$aaut_id,
                'desc' =>$desc,
            ];

            if ($this->db->insert('lojistik_arac_personel_history_item', $data_insert)) {
                $this->aauth->applog("Personel Araca Durum Bildirdi : " . $personel_histort_id, $aaut_id);
            }


            $details = $this->db->query("SELECT * FROM lojistik_arac_personel_history WHERE id=$personel_histort_id")->row();
            $details_cars = $this->db->query("SELECT * FROM lojistik_to_car_history WHERE id=$details->lojistik_to_car_history_id")->row();

            $arac_adi = arac_view($details_cars->arac_id)->name;

            $arac_details = $this->db->query("SELECT * FROM `lojistik_to_car`  WHERE lojistik_id = $details_cars->lojistik_id and sf_arac_id=$details_cars->arac_id")->row();
            $plaka = $arac_details->plaka;

            $data=[
                'aaut_id'=>$aaut_id,
                'user_id'=>$pers_id,
                'lojistik_to_car_history_id'=>$details->lojistik_to_car_history_id,
                'status'=>$status,
                'sort '=>floatval($details->sort)+floatval(1),
            ];
            $this->db->insert('lojistik_arac_personel_history', $data);
            $last_id = $this->db->insert_id();
            $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
            $firma_kodu=$dbnames['firma_kodu'];
            $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&personelen_history_id=$last_id&lojistik_to_car_history_id=$details->lojistik_to_car_history_id&pers_id=$pers_id&type=arac_history_create";
            $short_url = $this->getSmallLink($href);

            $meesage = 'Sayın Yetkili '.$plaka.' Nömreli '.$arac_adi.' Lojistik Yetkilisi Tarafından Size Yönlendirilmistir.Arac Durumu Belirtmek İcin Tiklayiniz.'.$short_url;

            $details = personel_detailsa($pers_id);
            $name = $details['name'];
            $phone = $details['phone'];
            $tel=str_replace(" ","",$phone);

            $domain="https://sms.atatexnologiya.az/bulksms/api";
            $operation='submit';
            $login='makro2000';
            $password="makro!sms";
            $title='MAKRO2000';
            $bulkmessage=$meesage;
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

            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Bildirildi"));
        }
        else {
            $data=[
                'lojistik_arac_personel_history_id' =>$personel_histort_id,
                'status' =>$status,
                'user_id' =>$aaut_id,
                'desc' =>$desc,
            ];

            if ($this->db->insert('lojistik_arac_personel_history_item', $data)) {
                $this->aauth->applog("Personel Araca Durum Bildirdi : " . $personel_histort_id, $aaut_id);
                echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Bildirildi"));
            }
        }
    }
    public function arac_history_create(){
        if (!$this->input->get()) {

            exit();
        }

        $pers_id = $this->input->get('pers_id');
        $personelen_history_id = $this->input->get('personelen_history_id');
        $lojistik_to_car_history_id = $this->input->get('id');
        $details = $this->db->query("SELECT * FROM lojistik_to_car_history WHERE id=$lojistik_to_car_history_id")->row();



        $lojistik_to_car_id = $details->lojistik_to_car_id;
        $details_personel_hist = $this->db->query("SELECT * FROM `lojistik_arac_personel_history` where id=$personelen_history_id")->row();

        $mvcut_status = arac_history_status($details_personel_hist->status)->name;

        $kontrol = $this->db->query("SELECT * FROM `lojistik_arac_personel_history_item` where lojistik_arac_personel_history_id=$personelen_history_id  ORDER BY `lojistik_arac_personel_history_item`.`id` ASC");
        if($kontrol->num_rows()){
            foreach ($kontrol->result() as $items){
                if($items->user_id == $pers_id){
                    $mvcut_status = arac_history_status($items->status)->name;
                }
            }
        }




        $statusler=arac_history_status();
        $employe_list =  $this->employee->list_employee_active_result();
        $arac_adi = arac_view($details->arac_id)->name;

        $arac_details = $this->db->query("SELECT * FROM `lojistik_to_car`  WHERE lojistik_id = $details->lojistik_id and sf_arac_id=$details->arac_id")->row();
        $plaka = $arac_details->plaka;
        $sofor_adi = $arac_details->sofor;
        $tel = $arac_details->tel;
        $head['title']='Araç Durum Bildirme';
        $data=[];
        $data['yonlendirme_personeli']=personel_details($details_personel_hist->aaut_id);
        $data['arac_adi']=$arac_adi;
        $data['aaut_id']=$pers_id;
        $data['employe_list']=$employe_list;
        $data['personelen_history_id']=$personelen_history_id;
        $data['mvcut_status']=$mvcut_status;
        $data['statusler']=$statusler;
        $data['plaka']=$plaka;
        $data['sofor_adi']=$sofor_adi;
        $data['tel']=$tel;

        $this->load->view('billing/header', $head);
        $this->load->view('logistics/arac_history_create',$data);
        $this->load->view('billing/footer');





    }

    public function teklif_olustur(){
        $this->db->trans_start();
        $cari_id = $this->input->post('cari_id');
        $talep_id = $this->input->post('talep_id');
        $tftcd_id = $this->input->post('tftcd_id');
        $nakliye = $this->input->post('nakliye');
        $kdv = $this->input->post('kdv');

        $details = $this->db->query("SELECT * FROM `talep_form_teklif_cari_details` where id=$tftcd_id")->row();


        $product_details = $this->input->post('product_details');
        $total_price=0;
        foreach ($product_details as $items){
            $data_insert = [
                'item_id'=>$items['item_id'],
                'marka'=>$items['marka'],
                'price'=>$items['price'],
                'notes'=>$items['notes'],
                'teklif_id'=>$details->teklif_id
            ];

            $details_products = $this->db->query("SELECT * FROM `talep_form_products` where id=".$items['item_id'])->row();
            $totals= floatval($items['price']) * floatval($details_products->product_qty);
            $total_price+=$totals;

            $this->db->insert('talep_form_teklifler_item', $data_insert);
        }

        $this->talep_history($talep_id,$cari_id,'Firma Teklif Verdi',2);

        $this->db->set('status', 3, FALSE);
        $this->db->where('id', $tftcd_id);
        if($this->db->update('talep_form_teklif_cari_details')){

            //total update
            $this->db->set('total', $total_price);
            $this->db->set('kdv', $kdv);
            $this->db->set('teslimat', $nakliye);
            $this->db->where('form_id', $talep_id);
            $this->db->where('cari_id', $cari_id);
            $this->db->update('talep_form_teklifler');
            //total update
            //$this->db->query("UPDATE `talep_form` SET `status` = '4' WHERE `talep_form`.`id` = $talep_id");
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Oluşturuldu'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
        }
    }

    public function talep_history($id,$user_id,$desc,$type=1){
        $data_step = array(
            'talep_id' => $id,
            'user_id' => $user_id,
            'desc' => $desc,
            'type' => $type,
        );
        $this->db->insert('talep_history', $data_step);

    }

    public function firma_new_ihale()
    {

        if (!$this->input->get()) {

            exit();
        }

        $tid = $this->input->get('id'); //ihale ID
        $pers_id = $this->input->get('pers_id'); // Firma ID
        $tftcd_id = $this->input->get('tftcd_id'); // Firma ID
        $teklif_id = $this->input->get('teklif_id'); // Firma ID
        $data['status'] = 1;

        $kontrol = $this->db->query("SELECT * FROM `talep_form_teklif_cari_details` where teklif_id = $teklif_id and status = 3 and cari_id=$pers_id")->num_rows();
        if($kontrol){
            $data['status'] = 0;
        }
        else {

            $this->db->set('status', "2", FALSE);
            $this->db->where('id', $tftcd_id);
            $this->db->update('talep_form_teklif_cari_details');
        }




        $data['cari_id'] = $pers_id;
        $data['tftcd_id'] = $tftcd_id;
        $data['form_id'] = $tid;
        $data['items_']=techizatcilar_item($tid,$pers_id);
        $data['code']=$this->db->query("SELECT * FROM talep_form Where id=$tid")->row()->code;
        $head['title'] = 'Malzame Talep Listesi';
        $this->load->view('billing/header', $head);
        $this->load->view('malzematalep/ihale_onay',$data);
        $this->load->view('billing/footer');



    }
    public function firma_teklif_onay()
    {

        if (!$this->input->get()) {

            exit();
        }



        $tid = $this->input->get('id'); //ihale ID

        $token = $this->input->get('token');
        $pers_id = $this->input->get('pers_id'); // Firma ID
        $oturum = $this->input->get('oturum'); // Firma ID

        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));



        if (hash_equals($token, $validtoken)) {
            if(isset($oturum))
            {
                $kont=$this->db->query("SELECT * FROM geopos_ihale_items_firma Where firma_id=$pers_id and ihale_id=$tid and fiyat!=0 and oturum=$oturum")->num_rows();
            }
            else {
                $kont=$this->db->query("SELECT * FROM geopos_ihale_items_firma Where firma_id=$pers_id and ihale_id=$tid and fiyat!=0")->num_rows();
            }





            if($kont>0)
            {
                $details= $this->db->query("SELECT * FROM geopos_ihale WHERE id=$tid")->row_array();
                $head['title'] = "Teklif Formu.".$details['dosya_no'];

                $data['invoice'] = $details;

                $data['tid'] = $tid;
                $data['token'] = $token;
                $data['oturum'] = $oturum;
                $data['firma_id'] = $pers_id;
                $data['products'] =  $this->ihale->product_detail($tid,$pers_id,$oturum);

                $this->load->view('billing/header', $head);
                $this->load->view('ihale/ihale_form_onay2', $data);
                $this->load->view('billing/footer');
            }
            else
            {
                $details= $this->db->query("SELECT * FROM geopos_ihale WHERE id=$tid")->row_array();
                $head['title'] = "Teklif Formu.".$details['dosya_no'];

                $data['invoice'] = $details;


                $data['tid'] = $tid;
                $data['token'] = $token;
                $data['oturum'] = $oturum;
                $data['firma_id'] = $pers_id;
                $data['products'] =  $this->ihale->product_detail($tid,$pers_id,$oturum);

                $this->load->view('billing/header', $head);
                $this->load->view('ihale/ihale_form_onay', $data);
                $this->load->view('billing/footer');
            }



        }
    }

    public function firma_teklif_onay_pdf()
    {

        if (!$this->input->get()) {

            exit();
        }



        $tid = $this->input->get('id'); //ihale ID
        $token = $this->input->get('token');
        $pers_id = $this->input->get('pers_id'); // Firma ID
        $oturum = $this->input->get('oturum'); // Firma ID

        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));



        if (hash_equals($token, $validtoken)) {
            if(isset($oturum))
            {
                $kont=$this->db->query("SELECT * FROM geopos_ihale_items_firma Where firma_id=$pers_id and ihale_id=$tid and fiyat!=0 and oturum=$oturum")->num_rows();
            }
            else {
                $kont=$this->db->query("SELECT * FROM geopos_ihale_items_firma Where firma_id=$pers_id and ihale_id=$tid and fiyat!=0")->num_rows();
            }





            $details= $this->db->query("SELECT * FROM geopos_ihale WHERE id=$tid")->row_array();
            $head['title'] = "Teklif Formu.".$details['dosya_no'];

            $data['invoice'] = $details;

            $data['tid'] = $tid;
            $data['token'] = $token;
            $data['oturum'] = $oturum;
            $data['firma_id'] = $pers_id;
            $data['products'] =  $this->ihale->product_detail($tid,$pers_id,$oturum);

            ini_set('memory_limit', '64M');


            $html = $this->load->view('ihale/teklif_pdf-' . LTR, $data, true);
            //PDF Rendering
            $this->load->library('pdf');

            $pdf = $this->pdf->load_split();
            $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $tid . '</div>');

            $pdf->WriteHTML($html);

            if ($this->input->get('d')) {

                $pdf->Output('Teklif#' . $tid . '.pdf', 'D');
            } else {
                $pdf->Output('Teklif#' . $tid . '.pdf', 'I');
            }



        }
    }


    public function avans_talep_formu_onay()
    {

        if (!$this->input->get()) {

            exit();
        }



        $tid = $this->input->get('id');
        $token = $this->input->get('token');
        $pers_id = $this->input->get('pers_id');

        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));



        if (hash_equals($token, $validtoken)) {

            $head['title'] = "Avans Talep Formu Onayı $tid";

            $this->load->model('requested_model', 'requested');
            $data['invoice'] = $this->requested->invoice_details($tid);

            $data['tid'] = $tid;
            $data['token'] = $token;
            $data['pers_id'] = $pers_id;
            $data['products'] =  $this->requested->invoice_products($tid);

            $this->load->view('billing/header', $head);
            $this->load->view('form/avans_talep_onay_form', $data);
            $this->load->view('billing/footer');
        }

    }

    public function gider_talep_formu_onay()
    {

        if (!$this->input->get()) {

            exit();
        }



        $tid = $this->input->get('id');
        $token = $this->input->get('token');
        $pers_id = $this->input->get('pers_id');

        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));



        if (hash_equals($token, $validtoken)) {

            $head['title'] = "Gider Talep Formu Onayı $tid";

            $this->load->model('requested_model', 'requested');
            $data['invoice'] = $this->requested->invoice_details($tid);

            $data['tid'] = $tid;
            $data['pers_id'] = $pers_id;
            $data['products'] =  $this->requested->invoice_products($tid);

            $this->load->view('billing/header', $head);
            $this->load->view('form/gider_talep_onay_form', $data);
            $this->load->view('billing/footer');
        }

    }

    public function satinalma_formu_onay()
    {

        if (!$this->input->get()) {

            exit();
        }



        $tid = $this->input->get('id');
        $token = $this->input->get('token');
        $pers_id = $this->input->get('pers_id');

        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));



        if (hash_equals($token, $validtoken)) {

            $head['title'] = "Satın Alma Talep Formu Onayı $tid";

            $this->load->model('requested_model', 'requested');
            $data['invoice'] = $this->requested->invoice_details($tid);

            $data['tid'] = $tid;
            $data['pers_id'] = $pers_id;
            $data['products'] =  $this->requested->invoice_products_sf($tid);

            $this->load->view('billing/header', $head);
            $this->load->view('form/satinalma_formu_onay_form', $data);
            $this->load->view('billing/footer');
        }

    }


    public function action_satinalma()
    {
        $talep_no = $this->input->post('talep_no');
        $proje_id = $this->input->post('proje_id', true);
        $proje_name = proje_name($proje_id);
        $olusturma_tarihi = $this->input->post('olusturma_tarihi');
        $hazirlayan_per_is = $this->input->post('hazirlayan_per_is');
        $satinalma_mudur_id = $this->input->post('satin_alma_muduru');
        $proje_muduru_id = $this->input->post('proje_muduru_id');
        $genel_mudur_id = $this->input->post('genel_mudur_id');
        $finans_departman_pers_id = $this->input->post('finans_departman_pers_id');
        $satinalma_pers_id = $this->input->post('satinalma_personeli');
        $bolum_mudur_id = $this->input->post('bolum_mudur_id');
        $bolum_adi = $this->input->post('bolum_adi');
        $malzeme_talep_form_id = $this->input->post('malzeme_talep_form_id');
        $kullanici_id =$hazirlayan_per_is;

        $transok = true;

        $st_c = 0;
        $talep_id = 0;

        $this->db->trans_start();
        $olus_t = datefordatabase($olusturma_tarihi);
        $data = array(
            'talep_no' => $talep_no,
            'proje_name' => $proje_name,
            'proje_id' => $proje_id,
            'olusturma_tarihi' => $olus_t,
            'talep_olusturan_pers_id' => $hazirlayan_per_is,
            'hazirlayan_pers_id' => $hazirlayan_per_is,
            'satinalma_mudur_id' => $satinalma_mudur_id,
            'genel_mudur_id' => $genel_mudur_id,
            'proje_muduru_id' => $proje_muduru_id,
            'finans_departman_pers_id' => $finans_departman_pers_id,
            'satinalma_personeli' => $satinalma_pers_id,
            'bolum_mudur_id' => $bolum_mudur_id,
            'bolum_adi' => $bolum_adi,
            'malzeme_talep_form_id' => $malzeme_talep_form_id,
            'tip' => 2,
            'kullanici_id' => $kullanici_id,
            'loc' => 0 );

        if ($this->db->insert('geopos_talep', $data)) {

            $talep_id = $this->db->insert_id();

            $operator= "deger+1";
            $this->db->set('deger', "$operator", FALSE);
            $this->db->where('tip', 3);
            $this->db->update('numaric');



            $product_name = $this->input->post('product_name');
            $product_detail = $this->input->post('product_detail');
            $product_qty = $this->input->post('product_qty');
            $unit = $this->input->post('unit');

            $product_price = $this->input->post('product_price');
            $product_tutar = $this->input->post('product_tutar');
            $firma = $this->input->post('firma');
            $firma_tel = $this->input->post('firma_tel');
            $teklif_tarih_no = $this->input->post('teklif_tarih_no');
            $odeme_sekli = $this->input->post('odeme_sekli');
            $odeme_tarihi = $this->input->post('odeme_tarihi');

            $prodindex = 0;
            foreach ($product_name as $key => $nms) {
                $product_name_ = $product_name[$key];
                $product_detail_ = $product_detail[$key];
                $product_qty_ = $product_qty[$key];
                $unit_ = $unit[$key];

                $currency = 1;
                if ($product_name_ != '') {
                    $data_items = array(

                        'tip' => $talep_id,
                        'product_name' => $product_name_,
                        'product_detail' => $product_detail_,
                        'firma_tel' => $firma_tel[$key],
                        'firma' => $firma[$key],
                        'teklif_tarih_no' => $teklif_tarih_no[$key],
                        'odeme_sekli' => $odeme_sekli[$key],
                        'price' => $product_price[$key],
                        'subtotal' =>$product_tutar[$key],
                        'qty' => $product_qty_,
                        'unit' => $unit_,
                        'odeme_tarihi' => $odeme_tarihi[$key],
                    );

                    if ($this->db->insert('geopos_talep_items', $data_items)) {
                        $talep_id_item = $this->db->insert_id();
                        $data_o= array(
                            'product_id' => $talep_id_item,
                            'malzeme_items_id' => $talep_id_item,
                            'file_id' => $talep_id,
                            'type' => 2);// satın alma formu

                        $this->db->insert('geopos_onay', $data_o);

                    }
                    $prodindex++;

                }
            }


        }

        if ($prodindex > 0) {

            $details=$this->db->query("SELECT * FROM geopos_talep WHERE id=$talep_id")->row();
            $proje_name=proje_name($details->proje_id);
            $talep_no=$details->talep_no;
            $proje_muduru_id=$details->proje_muduru_id;
            $finans_departman_pers_id=$details->finans_departman_pers_id;
            $satinalma_mudur_id=$details->satinalma_mudur_id;
            $genel_mudur_id=$details->genel_mudur_id;
            $subject = 'Satın Alma Formu Onayı';

            $message = 'Sayın Yetkili ' .$proje_name.' - '.$talep_no . ' Numaralı Satın Alma Formu Oluşturuldu. Onay İşleminiz Beklenmektedir.';

            $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
            $firma_kodu=$dbnames['firma_kodu'];
            $validtoken = hash_hmac('ripemd160', 'p' . $talep_id, $this->config->item('encryption_key'));


            $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$talep_id&pers_id=$satinalma_mudur_id&type=satinalma_formu_onay&token=$validtoken";
            $message .="<br>İncelemek İçin<a href='$href'>Tıklayınız</a>";




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
            $mesaj="Sayın Yetkili ".$proje_name.'-'.$talep_no." Numaralı Satın Alma Formu Olusturulmustur. Programa giris yaparak satın alma formundan islemlerinize baslayabilirsiniz.";

            $this->mesaj_gonder($mobile_,$mesaj);
            $this->mesaj_gonder($mobile2,$mesaj);
            $this->mesaj_gonder($mobile3,$mesaj);
            $this->onay_mailleri($subject, $message, $recipients, 'satin_alma_formu',$talep_id);


            $this->db->set('bildirim_durumu	', 1);
            $this->db->where('id', $talep_id);
            $this->db->update('geopos_talep');




            // Mail Gönderme
            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('talep_success'). $this->lang->line('View')));
            $this->db->trans_complete();
        }
    }

    public function talep_urunleri()
    {
        $out=array();
        $talep_id = $this->input->post('talep_id', true);
        $details= $this->db->query("SELECT * FROM geopos_talep_items WHERE tip=$talep_id")->result();
        foreach ($details as $detailss)
        {

            $query=$this->db->query("Select * From geopos_onay where malzeme_items_id=$detailss->id")->row();
            /*if($query->satinalma_yonlendirme==$this->aauth->get_user()->id)
            {


            }
            */

            if($query->malzeme_items_id==$detailss->id)
            {
                $out[]=array(
                    'product_id'=>$detailss->product_id,
                    'product_name'=>$detailss->product_name,
                    'unit'=>$detailss->unit,
                    'qty'=>$detailss->qty,
                    'details'=>$detailss->product_detail
                );
            }


        }

        echo json_encode($out);
    }


    public function satinalma_talep_olustur()
    {
        if (!$this->input->get()) {

            exit();
        }

        $tid = $this->input->get('id');
        $token = $this->input->get('token');
        $pers_id = $this->input->get('pers_id');

        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {

            $head['title'] = "Teklif Formu $tid";

            $this->load->model('requested_model', 'requested');
            $data['invoice'] = $this->requested->invoice_details($tid);
            $data['finans_departman_pers_id'] = $data['invoice']['finans_departman_pers_id'];
            $data['genel_mudur_id'] = $data['invoice']['genel_mudur_id'];
            $data['proje_id'] = $data['invoice']['proje_id'];

            $data['tid'] = $tid;
            $data['pers_id'] = $pers_id;
            $data['products'] =  $this->requested->invoice_products($tid);

            $data['exchange'] = $this->plugins->universal_api(5);
            $data['currency'] = $this->invoices_model->currencies();
            $data['terms'] = $this->invoices_model->billingterms();

            $this->session->mark_as_temp('para_birimi', 3);

            $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));


            $data['taxdetails'] = $this->common->taxdetail();


            $data['units'] = $this->requested->units();

            $this->load->view('billing/header', $head);
            $this->load->view('requested/teklif_form', $data);
            $this->load->view('billing/footer');
        }

    }


    public function malzeme_talep_arge()
    {

        if (!$this->input->get()) {

            exit();
        }



        $tid = $this->input->get('id');
        $token = $this->input->get('token');
        $pers_id = $this->input->get('pers_id');

        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));

        $data['genel_mudur']=false;

        $kontrol=$this->db->query("SELECT * FROM geopos_talep WHERE id=$tid");
        if($kontrol->num_rows()>0)
        {
            $data['genel_mudur']=true;
        }

        if (hash_equals($token, $validtoken)) {

            $head['title'] = "Malzeme Talep Formu $tid";

            $this->load->model('requested_model', 'requested');
            $data['invoice'] = $this->requested->invoice_details($tid);

            $data['tid'] = $tid;
            $data['pers_id'] = $pers_id;
            $data['products'] =  $this->requested->invoice_products($tid);

            $this->load->view('billing/header', $head);
            $this->load->view('requested/malzeme_talep_arge', $data);
            $this->load->view('billing/footer');
        }

    }
    public function malzeme_talep_formu_onay()
    {

        if (!$this->input->get()) {

            exit();
        }



        $tid = $this->input->get('id');
        $token = $this->input->get('token');
        $pers_id = $this->input->get('pers_id');

        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));

        $data['genel_mudur']=false;

        $kontrol=$this->db->query("SELECT * FROM geopos_talep WHERE id=$tid and genel_mudur_id=$pers_id");
        if($kontrol->num_rows()>0)
        {
            $data['genel_mudur']=true;
        }

        if (hash_equals($token, $validtoken)) {

            $head['title'] = "Malzeme Talep Formu Onayı $tid";

            $this->load->model('requested_model', 'requested');
            $data['invoice'] = $this->requested->invoice_details($tid);

            $data['tid'] = $tid;
            $data['pers_id'] = $pers_id;
            $data['products'] =  $this->requested->invoice_products($tid);

            $this->load->view('billing/header', $head);
            $this->load->view('requested/malzeme_talep_onay_form', $data);
            $this->load->view('billing/footer');
        }

    }


    public function sayim_noti()
    {

        if (!$this->input->get()) {

            exit();
        }



        $tid = $this->input->get('id');
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', 's' . $tid, $this->config->item('encryption_key'));



        if (hash_equals($token, $validtoken)) {


            $head['title'] = "Sipariş Bilgisi $tid";
            $this->load->model('sayim_model', 'sayim');
            $data['invoice'] = $this->sayim->sayim_details($tid);
            $data['tid'] = $tid;
            $data['products'] = $this->sayim->sayim_products($tid);
            $this->load->view('billing/header', $head);
            $this->load->view('billing/sayim_rapor_mail', $data);
            $this->load->view('billing/footer');
        }

    }

    public function sayim_noti_sms()
    {

        if (!$this->input->get()) {

            exit();
        }



        $tid = $this->input->get('id');
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160',  $tid, $this->config->item('encryption_key'));



        if (hash_equals($token, $validtoken)) {


            $head['title'] = "Sipariş Bilgisi $tid";
            $this->load->model('sayim_model', 'sayim');
            $data['invoice'] = $this->sayim->sayim_details($tid);
            $data['tid'] = $tid;
            $data['products'] = $this->sayim->sayim_products($tid);
            $this->load->view('billing/header', $head);
            $this->load->view('billing/sayim_rapor_mail', $data);
            $this->load->view('billing/footer');
        }

    }



    public function quoteview()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', 'q' . $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {

            $this->load->model('quote_model', 'quote');

            $this->load->model('accounts_model');
            $data['acclist'] = $this->accounts_model->accountslist();
            $tid = intval($this->input->get('id'));
            $data['id'] = $tid;
            $data['token'] = $token;
            $head['title'] = "Quote $tid";
            $data['invoice'] = $this->quote->quote_details($tid);
            $data['attach'] = $this->quote->attach($tid);

            $data['products'] = $this->quote->quote_products($tid);


            $data['employee'] = $this->quote->employee($data['invoice']['eid']);

            $head['usernm'] = '';
            $this->load->view('billing/header', $head);
            $this->load->view('billing/quoteview', $data);
            $this->load->view('billing/footer');
        }

    }

    public function purchase()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {
            $this->load->model('purchase_model', 'purchase');

            $this->load->model('accounts_model');
            $data['acclist'] = $this->accounts_model->accountslist();
            $data['attach'] = $this->purchase->attach($tid);
            $tid = intval($this->input->get('id'));
            $data['id'] = $tid;
            $data['token'] = $token;
            $head['title'] = "Purchase $tid";
            $data['invoice'] = $this->purchase->purchase_details($tid);
            // $data['online_pay'] = $this->purchase->online_pay_settings();
            $data['products'] = $this->purchase->purchase_products($tid);
            $data['activity'] = $this->purchase->purchase_transactions($tid);;


            $data['employee'] = $this->purchase->employee($data['invoice']['eid']);

            $head['usernm'] = '';
            $this->load->view('billing/header', $head);
            $this->load->view('billing/purchase', $data);
            $this->load->view('billing/footer');
        }

    }


    public function stockreturn()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', 's' . $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {
            $this->load->model('stockreturn_model', 'stockreturn');

            $this->load->model('accounts_model');
            $data['acclist'] = $this->accounts_model->accountslist();
            $data['attach'] = $this->stockreturn->attach($tid);
            $tid = intval($this->input->get('id'));
            $data['id'] = $tid;
            $data['token'] = $token;
            $head['title'] = "Stock return $tid";
            $data['invoice'] = $this->stockreturn->purchase_details($tid);
            // $data['online_pay'] = $this->purchase->online_pay_settings();
            $data['products'] = $this->stockreturn->purchase_products($tid);
            $data['activity'] = $this->stockreturn->purchase_transactions($tid);;


            $data['employee'] = $this->stockreturn->employee($data['invoice']['eid']);

            $head['usernm'] = '';
            $this->load->view('billing/header', $head);
            $this->load->view('billing/stockreturn', $data);
            $this->load->view('billing/footer');
        }

    }


    public function gateway()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->post('tid'));
        $token = $this->input->post('token');
        $amount = $this->input->post('p_amount');
        $pay_gateway = $this->input->post('pay_gateway');

        $validtoken = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {


            switch ($pay_gateway) {

                case 1 :
                    $this->card();
                    break;
            }
        }


    }


    public function printinvoice()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {

            $data['id'] = $tid;
            $data['invoice'] = $this->invocies->invoice_details($tid);
            $data['title'] = "Invoice " . $data['invoice']['tid'];
            $data['products'] = $this->invocies->invoice_products($tid);
            $data['employee'] = $this->invocies->employee($data['invoice']['eid']);

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
            $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');

            $pdf->WriteHTML($html);

            if ($this->input->get('d')) {

                $pdf->Output('Invoice_#' . $data['invoice']['tid'] . '.pdf', 'D');
            } else {
                $pdf->Output('Invoice_#' . $data['invoice']['tid'] . '.pdf', 'I');
            }


        }

    }


    public function printquote()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', 'q' . $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {

            $this->load->model('quote_model', 'quote');

            $data['id'] = $tid;
            $data['title'] = "Quote $tid";
            $data['invoice'] = $this->quote->quote_details($tid);
            $data['products'] = $this->quote->quote_products($tid);
            $data['employee'] = $this->quote->employee($data['invoice']['eid']);

            ini_set('memory_limit', '64M');
            if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {
                $html = $this->load->view('quotes/view-print-gstin', $data, true);
            } else {
                $html = $this->load->view('quotes/view-print-' . LTR, $data, true);
            }
            $header = $this->load->view('quotes/header-print-' . LTR, $data, true);
            //PDF Rendering


            $this->load->library('pdf');

            $pdf = $this->pdf->load_split();
            $pdf->SetHTMLHeader($header);
            $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $tid . '</div>');

            $pdf->WriteHTML($html);

            if ($this->input->get('d')) {

                $pdf->Output('Quote_#' . $tid . '.pdf', 'D');
            } else {
                $pdf->Output('Quote_#' . $tid . '.pdf', 'I');
            }


        }


    }


    public function printorder()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {
            $this->load->model('purchase_model', 'purchase');

            $data['id'] = $tid;
            $data['title'] = "Invoice $tid";
            $data['invoice'] = $this->purchase->purchase_details($tid);
            $data['invoice']['multi'] = 0;
            $data['products'] = $this->purchase->purchase_products($tid);
            $data['employee'] = $this->purchase->employee($data['invoice']['eid']);

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
            $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $tid . '</div>');

            $pdf->WriteHTML($html);

            if ($this->input->get('d')) {

                $pdf->Output('Purchase_#' . $tid . '.pdf', 'D');
            } else {
                $pdf->Output('Purchase_#' . $tid . '.pdf', 'I');
            }


        }

    }

    public function printstockreturn()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', 's' . $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {
            $this->load->model('stockreturn_model', 'stockreturn');

            $data['id'] = $tid;
            $data['title'] = "Invoice $tid";
            $data['invoice'] = $this->stockreturn->purchase_details($tid);
            $data['products'] = $this->stockreturn->purchase_products($tid);
            $data['employee'] = $this->stockreturn->employee($data['invoice']['eid']);

            ini_set('memory_limit', '64M');

            $html = $this->load->view('stockreturn/view-print', $data, true);

            //PDF Rendering
            $this->load->library('pdf');

            $pdf = $this->pdf->load();

            $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $tid . '</div>');

            $pdf->WriteHTML($html);

            if ($this->input->get('d')) {

                $pdf->Output('Stockreturn_order#' . $tid . '.pdf', 'D');
            } else {
                $pdf->Output('Stockreturn_order#' . $tid . '.pdf', 'I');
            }


        }

    }


    public function card()
    {
        if (!$this->input->get()) {
            exit();
        }
        $online_pay = $this->billing->online_pay_settings();
        if ($online_pay['enable'] == 0) {
            exit();
        }
        $data['tid'] = $this->input->get('id');
        $data['token'] = $this->input->get('token');
        $data['itype'] = $this->input->get('itype');
        if ($data['itype'] == 'inv') {
            $validtoken = hash_hmac('ripemd160', $data['tid'], $this->config->item('encryption_key'));
            if (hash_equals($data['token'], $validtoken)) {
                $data['invoice'] = $this->invocies->invoice_details($data['tid']);
            } else {
                exit();
            }
        }
        $online_pay = $this->billing->online_pay_settings();
        $data['gateway'] = $this->billing->gateway_list('Yes');
        if ($online_pay['enable'] == 1) {
            $this->load->view('billing/header');
            $this->load->view('payment/card', $data);
            $this->load->view('billing/footer');
        } else {
            echo '<h3>' . $this->lang->line('Online Payment Service') . '</h3>';
        }


    }

    public function process_card()
    {
        if (!$this->input->post()) {
            exit();
        }
        $tid = $this->input->post('id', true);
        $itype = $this->input->post('itype', true);
        $amount = number_format($this->input->post('amount', true), 2, '.', '');

        if ($itype == 'inv') {
            $customer = $this->invocies->invoice_details($tid);
            if (!$customer['tid']) {
                exit();
            }
        }


        $hash = $this->input->post('token', true);
        $gateway = $this->input->post('gateway', true);
        $cardNumber = $this->input->post('cardNumber', true);
        $cardExpiry = $this->input->post('cardExpiry', true);
        $cardCVC = $this->input->post('cardCVC', true);

        $nmonth = substr($cardExpiry, 0, 2);
        $nyear = '20' . substr($cardExpiry, 5, 2);

        $note = 'Card Payment for #' . $customer['tid'];
        $pmethod = 'Card';

        $amount_o = $amount;

        if ($customer['multi'] > 0) {
            $multi_currency = $this->invocies->currency_d($customer['multi']);
            $amount = $multi_currency['rate'] * $amount;
            $gateway_data['currency'] = $multi_currency['code'];
            $note .= ' (Currency Conversion Applied)';
        }

        $validtoken = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));

        $gateway_data = $this->billing->gateway($gateway);
        $surcharge = ($amount * $gateway_data['surcharge']) / 100;
        $amount_t = $amount + $surcharge;

        $amount = number_format($amount_t, 2, '.', '');

        if (hash_equals($hash, $validtoken)) {


            switch ($gateway) {

                case 1:
                    // $response = $this->stripe($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $gateway_data);
                    $response = $this->moka($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $gateway_data);
                    break;
                case 2:
                    $response = $this->authorizenet($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data);
                    break;
                case 3:
                    $response = $this->pinpay($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data, $customer);
                    break;
                case 4:
                    $response = $this->paypal($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data, $customer);
                    break;
                case 5:
                    $response = $this->securepay($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data);
                    break;

            }

            // Process response //moka için
            if ($response) {

                if ($this->billing->paynow($tid, $amount_o, $note, $pmethod,$customer['loc'])) {
                    header('Content-Type: application/json');
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('Thank you for the payment') . " <a href='" . base_url('billing/view?id=' . $tid . '&token=' . $hash) . "' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "</a>"));
                }

            }
            else if ($response->isSuccessful()) {

                if ($this->billing->paynow($tid, $amount_o, $note, $pmethod,$customer['loc'])) {
                    header('Content-Type: application/json');
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('Thank you for the payment') . " <a href='" . base_url('billing/view?id=' . $tid . '&token=' . $hash) . "' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "</a>"));
                }

            } elseif ($response->isRedirect()) {

                // Redirect to offsite payment gateway
                $response->redirect();

            } else {

                // Payment failed
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('Payment failed')));
            }


        }


    }


    private function stripe($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $gateway_data)
    {

        $gateway = Omnipay::create('Stripe');
        $gateway->setApiKey($gateway_data['key1']);

// Example form data
        $formData = [
            'number' => $cardNumber,
            'expiryMonth' => $nmonth,
            'expiryYear' => $nyear,
            'cvv' => $cardCVC
        ];

// Send purchase request
        return $gateway->purchase(
            [
                'amount' => $amount,
                'currency' => $gateway_data['currency'],
                'card' => $formData
            ]
        )->send();


    }


    private function authorizenet($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data)
    {
        $gateway = Omnipay::create('AuthorizeNet_AIM');
        $gateway->setApiLoginId($gateway_data['key2']);
        $gateway->setTransactionKey($gateway_data['key1']);
        $gateway->setDeveloperMode(true);

        try {
            return $gateway->purchase(
                array(
                    'card' => array(
                        'number' => $cardNumber,
                        'expiryMonth' => $nmonth,
                        'expiryYear' => $nyear,
                        'cvv' => $cardCVC
                    ),
                    'amount' => $amount,
                    'currency' => $gateway_data['currency'],
                    'description' => 'Paid on' . $this->config->item('ctitle'),
                    'transactionId' => 'INV#' . $tid
                )
            )->send();

        } catch (Exception $e) {
            return 0;
        }
    }
    private function moka($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $gateway_data)
    {


        return true;
    }


    private function pinpay($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data, $customer)
    {
        $gateway = \Omnipay\Omnipay::create('Pin');

        // Initialise the gateway
        $gateway->initialize(array(
            'secretKey' => $gateway_data['key1'],
            'testMode' => $gateway_data['dev_mode'], // Or false when you are ready for live transactions
        ));

        // Create a credit card object
        // This card can be used for testing.
        // See https://pin.net.au/docs/api/test-cards for a list of card
        // numbers that can be used for testing.
        $card = new \Omnipay\Common\CreditCard(array(
            'firstName' => $customer['name'],
            'lastName' => 'Customer',
            'number' => $cardNumber,
            'expiryMonth' => $nmonth,
            'expiryYear' => $nyear,
            'cvv' => $cardCVC,
            'email' => $customer['email'],
            'billingAddress1' => $customer['address'],
            'billingCountry' => $customer['country'],
            'billingCity' => $customer['city'],
            'billingPostcode' => $customer['postbox'],
            'billingState' => $customer['region'],
        ));

        // Do a purchase transaction on the gateway
        $transaction = $gateway->purchase(array(
            'description' => 'Payment for INV#' . $tid,
            'amount' => $amount,
            'currency' => $gateway_data['currency'],
            'clientIp' => $_SERVER['REMOTE_ADDR'],
            'card' => $card,
        ));
        return $transaction->send();

    }


    private function securepay($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data)
    {


        $gateway = \Omnipay\Omnipay::create('SecurePay_SecureXML');
        $gateway->setMerchantId($gateway_data['key1']);
        $gateway->setTransactionPassword($gateway_data['key2']);
        $gateway->setTestMode($gateway_data['dev_mode']);

        // Create a credit card object
        $card = new \Omnipay\Common\CreditCard(
            [
                'number' => $cardNumber,
                'expiryMonth' => $nmonth,
                'expiryYear' => $nyear,
                'cvv' => $cardCVC,
            ]
        );

        // Perform a purchase test
        $transaction = $gateway->purchase(
            [
                'amount' => $amount,
                'currency' => $gateway_data['currency'],
                'transactionId' => 'invoice_' . $tid,
                'card' => $card,
            ]
        );

        return $transaction->send();
    }


    private function paypal($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data, $customer)
    {

        $gateway = Omnipay::create('PayPal_Rest');
        // Initialise the gateway
        $gateway->initialize(array(
            'clientId' => $gateway_data['key1'],
            'secret' => $gateway_data['key2'],
            'testMode' => $gateway_data['dev_mode'], // Or false when you are ready for live transactions
        ));

        $card = new \Omnipay\Common\CreditCard(array(
            'firstName' => $customer['name'],
            'lastName' => 'Customer',
            'number' => $cardNumber,
            'expiryMonth' => $nmonth,
            'expiryYear' => $nyear,
            'cvv' => $cardCVC,
            'billingAddress1' => $customer['address'],
            'billingCountry' => $customer['country'],
            'billingCity' => $customer['city'],
            'billingPostcode' => $customer['postbox'],
            'billingState' => $customer['state'],
        ));

        try {
            $transaction = $gateway->purchase(array(
                'amount' => $amount,
                'currency' => $gateway_data['currency'],
                'description' => 'Payment for #inv ' . $tid,
                'card' => $card,
            ));
            return $transaction->send();
        } catch (\Exception $e) {
            return false;
        }


    }

    public function bank()
    {
        $online_pay = $this->billing->online_pay_settings();
        if ($online_pay['bank'] == 1) {
            $data['accounts'] = $this->billing->bank_accounts('Yes');
            $this->load->view('billing/header');
            $this->load->view('payment/public_bank_view', $data);
            $this->load->view('billing/footer');
        }

    }


    public function recharge()
    {

        if (!$this->input->get()) {
            exit();
        }
        $online_pay = $this->billing->online_pay_settings();
        if ($online_pay['enable'] == 0) {
            exit();
        }
        $data['id'] = base64_decode($this->input->get('id',true));

        $data['amount'] = $this->input->get('amount',true);

        $online_pay = $this->billing->online_pay_settings();
        $data['gateway'] = $this->billing->gateway_list('Yes');
        if ($online_pay['enable'] == 1) {
            $this->load->view('billing/header');
            $this->load->view('payment/recharge', $data);
            $this->load->view('billing/footer');
        } else {
            echo '<h3>' . $this->lang->line('Online Payment Service') . '</h3>';
        }


    }

    public function process_recharge()
    {
        if (!$this->input->post()) {
            exit();
        }
        $tid = $this->input->post('id', true);
        $amount = number_format($this->input->post('amount', true), 2, '.', '');
        $gateway = $this->input->post('gateway', true);
        $cardNumber = $this->input->post('cardNumber', true);
        $cardExpiry = $this->input->post('cardExpiry', true);
        $cardCVC = $this->input->post('cardCVC', true);

        $nmonth = substr($cardExpiry, 0, 2);
        $nyear = '20' . substr($cardExpiry, 5, 2);

        $note = 'Card Payment for #' . $tid;
        $pmethod = 'Card';

        $amount_o = $amount;

        $gateway_data = $this->billing->gateway($gateway);
        $surcharge = ($amount * $gateway_data['surcharge']) / 100;
        $amount_t = $amount + $surcharge;
        $this->load->model('customers_model', 'customers');
        $customer = $this->customers->details($tid);


        $amount = number_format($amount_t, 2, '.', '');


        switch ($gateway) {

            case 1:
                $response = $this->stripe($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $gateway_data);
                break;
            case 2:
                $response = $this->authorizenet($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data);
                break;
            case 3:
                $response = $this->pinpay($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data, $customer);
                break;
            case 4:
                $response = $this->paypal($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data, $customer);
                break;
            case 5:
                $response = $this->securepay($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data);
                break;

        }

        // Process response
        if ($response->isSuccessful()) {

            if ($this->billing->recharge_done($tid, $amount_o)) {
                header('Content-Type: application/json');
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('Thank you for the payment') . " <a href='" . base_url('crm/payments/recharge') . "' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "</a>"));
            }

        } elseif ($response->isRedirect()) {

            // Redirect to offsite payment gateway
            $response->redirect();

        } else {

            // Payment failed
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('Payment failed')));
        }


    }

    public function onay_mailleri($subject, $message, $recipients, $tip,$talep_id)
    {

        $attachmenttrue = false;
        $attachment = '';


        $this->communication_model->onay_mail($recipients, $subject, $message, $attachmenttrue, $attachment, $tip);
        return 1;





    }

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
                    $this->db->set('status', $query->row()->finans_status);
                    $this->db->where('id', $talep_id);
                    $this->db->update('geopos_talep');
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

    // Gider talep formu toplu onaylama
    public function avans_talep_product_status_toplu()
    {
        $talep_id = $this->input->post('talep_id')[0];
        $product_id = $this->input->post('product_id');
        $kullanici = $this->input->post('pers_id')[0];
        $note = $this->input->post('note');
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
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and product_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('proje_sorumlusu_status	', $status);
                        $this->db->set('proje_sorumlusu_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('product_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'proje_sorumlusu_status' => $status,
                            'product_id' => $value,
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
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and product_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('proje_muduru_status	', $status);
                        $this->db->set('proje_muduru_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('product_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'proje_muduru_status' => $status,
                            'product_id' => $value,
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
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and product_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('bolum_muduru_status	', $status);
                        $this->db->set('bolum_muduru_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('product_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'bolum_muduru_status' => $status,
                            'product_id' => $value,
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
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and product_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('genel_mudur_status	', $status);
                        $this->db->set('genel_mudur_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('product_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'genel_mudur_status' => $status,
                            'product_id' => $value,
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
                    $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and product_id=$value");
                    if ($onay_kontrol->num_rows() > 0) {
                        //update
                        $this->db->set('finans_status	', $status);
                        $this->db->set('finans_status_note', $note[$key]);
                        $this->db->where('file_id', $talep_id);
                        $this->db->where('type', $tip);
                        $this->db->where('product_id', $value);
                        $this->db->update('geopos_onay');


                    } else {
                        //insert
                        $data = array(
                            'finans_status' => $status,
                            'product_id' => $value,
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

    // Gider talep formu toplu onaylama


    public function avans_talep_product_status()
    {

        $talep_id = $this->input->post('talep_id');
        $product_id = $this->input->post('product_id');
        $kullanici = $this->input->post('pers_id');
        $status = $this->input->post('status');
        $note = $this->input->post('note');
        $tip = $this->input->post('tip');
        $subject='';
        $message='';
        $recipients=array();


        $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and (proje_sorumlusu_id=$kullanici or proje_muduru_id=$kullanici  or bolum_mudur_id=$kullanici or genel_mudur_id=$kullanici  or finans_departman_pers_id=$kullanici) ");

        if ($query->num_rows() > 0) {

            if ($query->row()->proje_sorumlusu_id == $kullanici)    //proje sorumlusu onayladı
            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and product_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('proje_sorumlusu_status	', $status);
                    $this->db->set('proje_sorumlusu_status_note', $note);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->where('product_id', $product_id);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'proje_sorumlusu_status' => $status,
                        'product_id' => $product_id,
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


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id and product_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('proje_muduru_status	', $status);
                    $this->db->set('proje_muduru_status_note', $note);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->where('product_id', $product_id);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'proje_muduru_status' => $status,
                        'proje_muduru_status_note' => $note,
                        'product_id' => $product_id,
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


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id  and product_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('bolum_muduru_status', $status);
                    $this->db->set('bolum_muduru_status_note', $note);
                    $this->db->set('product_id', $product_id);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'proje_muduru_status' => $status,
                        'bolum_muduru_status_note' => $note,
                        'product_id' => $product_id,
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


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id  and product_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('genel_mudur_status', $status);
                    $this->db->set('genel_mudur_status_note', $note);
                    $this->db->set('product_id', $product_id);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'genel_mudur_status' => $status,
                        'genel_mudur_status_note' => $note,
                        'product_id' => $product_id,
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


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=$tip and file_id=$talep_id  and product_id=$product_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('finans_status', $status);
                    $this->db->set('finans_status_note', $note);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', $tip);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array(
                        'finans_status' => $status,
                        'finans_status_note' => $note,
                        'product_id' => $product_id,
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

    public function firma_teklif_onay_()
    {


        $firma_id = $this->input->post('pers_id');
        $ihale_id = $this->input->post('talep_id');
        $odeme = $this->input->post('odeme');
        $nakliye_durumu = $this->input->post('nakliye_durumu');
        $kdv_durumu = $this->input->post('kdv_durumu');
        $odeme_tarihi = $this->input->post('odeme_tarihi');
        $fiyat = $this->input->post('fiyat');
        $item_id = $this->input->post('item_id');
        $oturum = $this->input->post('oturum');
        $ulke = $this->input->post('ulke');
        $not = $this->input->post('not');
        $marka = $this->input->post('marka');

        $product_name = $this->input->post('product_name');
        $product_fiyat = $this->input->post('product_fiyat');
        $product_fiyat = $this->input->post('product_fiyat');
        $product_qty = $this->input->post('product_qty');
        $product_nakliye_durumu = $this->input->post('product_nakliye_durumu');
        $product_kdv = $this->input->post('product_kdv_durumu');
        $product_odeme = $this->input->post('product_odeme');
        $product_ulke = $this->input->post('product_ulke');
        $product_odeme_tarihi = $this->input->post('product_odeme_tarihi');
        $product_not = $this->input->post('product_not');
        $product_unit = $this->input->post('product_unit');
        $product_marka = $this->input->post('product_marka');
        $product_oturum = $this->input->post('product_oturum');
        $product_details = $this->input->post('product_details');


        date_default_timezone_set('Asia/Baku');

        $date = new DateTime('now');
        $date_saat=$date->format('Y-m-d H:i:s');
        $ip=$_SERVER['REMOTE_ADDR'];

        if(!empty($product_name))
        {
            foreach ($product_name as $key=>$value)
            {
                $product_name_ = $product_name[$key];
                $product_fiyat_ = $product_fiyat[$key];
                $product_qty_ = $product_qty[$key];
                $product_odeme_ = $product_odeme[$key];
                $product_nakliye_durumu_ = $product_nakliye_durumu[$key];
                $product_kdv_ = $product_kdv[$key];
                $product_ulke_ = $product_ulke[$key];
                $product_odeme_tarihi_ = $product_odeme_tarihi[$key];
                $product_not_ = $product_not[$key];
                $product_unit_ = $product_unit[$key];
                $product_marka_ = $product_marka[$key];
                $product_oturum_ = $product_oturum[$key];
                $product_details_ = $product_details[$key];

                $data_item=array
                (
                    'ihale_id'=>$ihale_id[0],
                    'product_name'=>$product_name_,
                    'marka'=>$product_marka_,
                    'product_qty'=>$product_qty_,
                    'unit' => $product_unit_,
                    'ref_urun' => 1
                );

                $this->db->insert('geopos_ihale_items', $data_item);
                $last_id=$lid = $this->db->insert_id();

                $data_items=array
                (
                    'ihale_id'=>$ihale_id[0],
                    'odeme'=>$product_odeme_,
                    'nakliye_durumu'=>$product_nakliye_durumu_,
                    'kdv'=>$product_kdv_,
                    'odeme_tarihi'=>$product_odeme_tarihi_,
                    'fiyat'=>$product_fiyat_,
                    'ulke'=>$product_ulke_,
                    'item_id'=>$last_id,
                    'marka'=>$product_marka_,
                    'firma_id'=>$firma_id[0],
                    'aciklama'=>$product_not_,
                    'oturum'=>$product_oturum_,
                    'teklif_tarihi'=>$date_saat,
                    'ip_address'=>$ip,
                    'ref_urun' => 1
                );
                $this->db->insert('geopos_ihale_items_firma', $data_items);
            }
        }

        $ind=0;



        $query = $this->db->query("SELECT * FROM geopos_ihale_items_firma where ihale_id=$ihale_id[0] and firma_id=$firma_id[0]");
        if ($query->num_rows() > 0)
        {
            foreach ($fiyat as $key=>$value)
            {
                $this->db->set('odeme', $odeme[$key]);
                $this->db->set('nakliye_durumu', $nakliye_durumu[$key]);
                $this->db->set('kdv', $kdv_durumu[$key]);
                $this->db->set('odeme_tarihi', $odeme_tarihi[$key]);
                $this->db->set('fiyat', $fiyat[$key]);
                $this->db->set('ulke', $ulke[$key]);
                $this->db->set('aciklama', $not[$key]);
                $this->db->set('marka', $marka[$key]);
                $this->db->set('teklif_tarihi', "$date_saat");
                $this->db->set('ip_address', "$ip");
                $this->db->where('item_id', $item_id[$key]);
                $this->db->where('firma_id', $firma_id[$key]);
                $this->db->where('ihale_id', $ihale_id[$key]);
                if(isset($oturum))
                {
                    $this->db->where('oturum', $oturum[$key]);
                }
                $this->db->update('geopos_ihale_items_firma');
            }

            $details = $this->db->query("SELECT * FROM geopos_ihale where id=$ihale_id[0]")->row();
            $firma_ids=$firma_id[0];
            $company=customer_details($firma_ids)['company'];
            $mobile_ = personel_detailsa($details->emp_id)['phone'];


            $ds=explode("-",$details->dosya_no);



            $mesaj="Sayın Yetkili ".$ds[1].'-'.$ds[2]." Numarali teklifinize ".$company.' fiyat vermistir.Dosyanızı takip ediniz.';


            $message_=$this->mesaj_gonder($mobile_,$mesaj);


            echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Onaylandı...', 'pstatus' => 'Başarılı'));
        }
    }


}
