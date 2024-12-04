
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



class Requested extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->library("Aauth");
        $this->load->model('communication_model');
        $this->load->helper('cookie');
        $this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model');
        $this->load->model('invoices_model');
        $this->load->library("Common");
        $this->load->model("requested_model", 'requested');


        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }




        if ($this->aauth->get_user()->roleid == 2) {

            $this->limited = $this->aauth->get_user()->id;

        } else {

            $this->limited = '';
        }
    }


    public function create()
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
        $this->load->view('requested/requested_add', $data);
        $this->load->view('fixed/footer');
    }


    public function action()
    {
        $currency = 1;
        $st=0; //Muhasebe ürünleri
        $talep_no = numaric(2);
        $stok_durumu = $this->input->post('stok_durumu', true);
        if($stok_durumu=='on')
        {
            $st=1;
        }

        $proje_id = $this->input->post('proje_id', true);
        $proje_name = proje_name($proje_id);
        $olusturma_tarihi = $this->input->post('olusturma_tarihi', true);
        $onay_tarihi = $this->input->post('onay_tarihi', true);
        $description = $this->input->post('description', true);
        $talep_eden_pers_id = $this->input->post('talep_eden_pers_id', true);
        $genel_mudur_id = $this->input->post('genel_mudur_id', true);
        $discount_format = $this->input->post('discount_format', true);
        $bolum_mudur_id = $this->input->post('bolum_mudur_id');
        $discount_rate = $this->input->post('discount_rate', true);
        $email = $this->input->post('email', true);
        $tel = $this->input->post('tel', true);
        $subtotal = $this->input->post('subtotal', true); // Ara Toplam
        $tax = 0; //toplam kdv
        $discount = 0; //toplam indirim
        $nettotalinp = $this->input->post('nettotalinp', true); // Net toplam
        $total = $this->input->post('total'); //Genel Toplam
        $olus_t = datefordatabase($olusturma_tarihi);
        $onay_t = datefordatabase($onay_tarihi);

        $proje_sorumlusu_id = $this->input->post('proje_sorumlusu_id');
        $proje_muduru_id = $this->input->post('proje_muduru_id');
        $gonderme_sekli = $this->input->post('gonderme_sekli');
        $proje_bolum_id = $this->input->post('proje_bolum_id');
        $kullanici_id =$this->aauth->get_user()->id;



        $transok = true;

        $st_c = 0;

        $this->db->trans_start();

        $data = array(
            'talep_no' => $talep_no,
            'proje_name' => $proje_name,
            'olusturma_tarihi' => $olus_t,
            'onay_tarihi' => $onay_t,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'nettotal' => $nettotalinp,
            'total' => $total,
            'tel' => $tel,
            'email' => $email,
            'description' => $description,
            'talep_eden_pers_id' => $talep_eden_pers_id,
            'bolum_mudur_id' => $bolum_mudur_id,
            'talep_olusturan_pers_id' => $this->aauth->get_user()->id,
            'proje_sorumlusu_id' => $proje_sorumlusu_id,
            'proje_muduru_id' => $proje_muduru_id,
            'gonderme_sekli' => $gonderme_sekli,
            'genel_mudur_id' => $genel_mudur_id,
            'discount_format' => $discount_format,
            'proje_id' => $proje_id,
            'discount_rate' => $discount_rate,
            'stok_durumu' => $st,
            'bildirim_durumu' => 0,
            'kullanici_id' => $kullanici_id,
            'proje_bolum_id' => $proje_bolum_id,
            'proje_bolum_name' => $this->db->query("SELECT * FROM geopos_project_bolum Where id =$proje_bolum_id")->row()->name,
            'loc' => $this->aauth->get_user()->loc);

        if ($this->db->insert('geopos_talep', $data)) {

            $talep_id = $this->db->insert_id();

            $this->aauth->applog("Malzeme Talep Formu Oluşturuldu $talep_no ID ".$talep_id,$this->aauth->get_user()->username);
            kont_kayit(21,$talep_id);

            $operator= "deger+1";


            $this->db->set('deger', "$operator", FALSE);
            $this->db->where('tip', 2);
            $this->db->update('numaric');


            $product_name = $this->input->post('product_name');
            $productlist = array();
            $data_items = array();
            $prodindex = 0;
            $itc = 0;
            $total_tax = 0;
            $total_discount = 0;

            foreach ($product_name as $key => $value) {
                $product_name = $this->input->post('product_name');
                $unit = $this->input->post('unit');
                $product_detail = $this->input->post('product_detail');
                $product_qty = $this->input->post('product_qty');
                $product_id = $this->input->post('pid');


                $bolum_id=0;
                $bagli_oldugu_asama_id_val=0;
                $asama_id=0;
                if($st==1)
                {
                    $bolum_id = $this->input->post('bolum_id');
                    $bagli_oldugu_asama_id_val = $this->input->post('bagli_oldugu_asama_id_val');
                    $asama_id = $this->input->post('asama_id');
                }



                /*$product_price = $this->input->post('product_price');
                $product_tax = $this->input->post('product_tax');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('product_subtotal');
                $ptotal_tax = $this->input->post('taxa');
                $ptotal_disc = $this->input->post('disca'); */

                $product_price=0;
                $product_tax=0;
                $product_discount=0;
                $ptotal_disc=0;
                $product_subtotal=0;
                $ptotal_tax=0;

                if(isset($product_id[$key]))
                {
                    if($product_id[$key]!=0)
                    {
                        $data_items = array(

                            'tip' => $talep_id,

                            'product_name' => $product_name[$key],

                            'product_detail' => $product_detail[$key],

                            'bolum_id' => $bolum_id[$key],

                            'bagli_oldugu_asama_id' => $bagli_oldugu_asama_id_val[$key],

                            'asama_id' => $asama_id[$key],

                            'product_id' => $product_id[$key],

                            'qty' => $product_qty[$key],

                            'price' => 0,

                            'tax' => 0,

                            'discount' => 0,

                            'subtotal' => 0,

                            'totaltax' => 0,

                            'totaldiscount' => 0,

                            'unit' => $unit[$key]
                        );
                    }
                }


                $productlist[$prodindex] = $data_items;

                $this->db->insert('geopos_talep_items', $data_items);

                $malzeme_items_id = $this->db->insert_id();

                $data_o= array(
                    'product_id' => $product_id[$key],
                    'malzeme_items_id' => $malzeme_items_id,
                    'file_id' => $talep_id,
                    'type' => 1);

                $this->db->insert('geopos_onay', $data_o);

                $prodindex++;

            }



            if ($transok) {

                // Mail Gönderme


                // Mail Gönderme
                echo json_encode(array('status' => 'Success', 'message' =>

                    $this->lang->line('talep_success') . " <a href='/requested/view?id=$talep_id' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$talep_id' class='btn btn-indigo btn-lg' target='_blank'><span class='icon-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; "));
                $this->db->trans_complete();
            }

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                "Invalid Entry!"));

            $transok = false;
            $this->db->trans_rollback();


        }


    }

    public function bildirim_olustur_satin_alma()
    {

        $talep_id=$this->input->post('talep_id');
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


        //$href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$talep_id&pers_id=$satinalma_mudur_id&type=satinalma_formu_onay&token=$validtoken";
        //$message .="<br>İncelemek İçin<a href='$href'>Tıklayınız</a>";




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

        //$this->mesaj_gonder($mobile_,$mesaj);
        //$this->mesaj_gonder($mobile2,$mesaj);
        //$this->mesaj_gonder($mobile3,$mesaj);

        $this->onay_mailleri($subject, $message, $recipients, 'satin_alma_formu',$talep_id);


        $this->db->set('bildirim_durumu', 1);
        $this->db->set('dev_bildirim', 1);
        $this->db->where('id', $talep_id);
        $this->db->update('geopos_talep');
        echo json_encode(array('status' => 'Success', 'message' =>'Başrıyla Onaya Sunulmuştur...', 'pstatus' => 'Başarılı'));


    }

    public function yazilim_bildirimi()
    {

        $talep_id=$this->input->post('talep_id');
        $details=$this->db->query("SELECT * FROM geopos_talep WHERE id=$talep_id")->row();
        $proje_name=proje_name($details->proje_id);
        $talep_no=$details->talep_no;
        $message = 'Sayın Yazılım Yetkilisi ' . $proje_name.' - '.$talep_no . ' Numaralı Talep Formu Oluşturuldu. İncelemeniz Beklenmektedir.';
        $subject = 'Malzeme Talep Formu Onayı';
        $recipients = array('busra@makro2000.com.tr','elvinlatifzade@makro2000.com.tr','elmarmemmedli@makro2000.com.tr');

        $data = array(
            'talep_id' => $talep_id,
            'status' => 0,
        );

        $this->db->insert('geopos_developer_table', $data);

//        $this->db->set('bildirim_durumu', 1);
//        $this->db->where('id', $talep_id);
//        $this->db->update('geopos_talep');

        $this->db->set('status', 9);
        $this->db->set('dev_bildirim', 1);
        $this->db->where('id', $talep_id);
        $this->db->update('geopos_talep');


        $this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili',$talep_id);

        file_get_contents('https://api.telegram.org/bot2134835899:AAHIvoq1YmOEgnqO8bAGaI9XihK7DxPr2sw/sendMessage?chat_id=-741350779&text='.$message);

        echo json_encode(array('status' => 'Success', 'message' =>'Başrıyla Onaya Sunulmuştur...', 'pstatus' => 'Başarılı'));

    }

    public function bildirim_olustur(){
        $talep_id=$this->input->post('talep_id');
        $details=$this->db->query("SELECT * FROM geopos_talep WHERE id=$talep_id")->row();
        $proje_name=proje_name($details->proje_id);
        $talep_no=$details->talep_no;
        $proje_sorumlusu_id=$details->proje_sorumlusu_id;
        $subject = 'Malzeme Talep Formu Onayı';
        $message = 'Sayın Yetkili ' . $proje_name.' - '.$talep_no . ' Numaralı Talep Formu Oluşturuldu. Onay İşleminiz Beklenmektedir.';
        $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
        $firma_kodu=$dbnames['firma_kodu'];
        $validtoken = hash_hmac('ripemd160', 'p' . $talep_id, $this->config->item('encryption_key'));
        $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$talep_id&pers_id=$proje_sorumlusu_id&type=malzeme_talep_formu_onay&token=$validtoken";
        $message .="<br>İncelemek İçin<a href='$href'>Tıklayınız</a>";
        $message .= "<br><br><br><br>";
        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
        $proje_sorumlusu_email = personel_detailsa($proje_sorumlusu_id)['email'];
        $proje_sorumlusu_no = personel_detailsa($proje_sorumlusu_id)['phone'];

        $recipients = array($proje_sorumlusu_email);

        $short_url = $this->getSmallLink($href);
        $mesaj=$proje_name.' - '.$talep_no." Numaralı Malzeme Talep Formunu Incelemek icin tiklayiniz.$short_url";

        //$message_ = $this->mesaj_gonder($proje_sorumlusu_no,$mesaj);

        $this->db->set('bildirim_durumu',1);
        $this->db->set('status', 1);
        $this->db->where('id', $talep_id);
        $this->db->update('geopos_talep');


        $this->db->set('status',1);
        $this->db->where('talep_id', $talep_id);
        $this->db->update('geopos_developer_table');

        $this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili',$talep_id);
        echo json_encode(array('status' => 'Success', 'message' =>'Başrıyla Onaya Sunulmuştur...', 'pstatus' => 'Başarılı'));
    }

    public function onay_mailleri($subject, $message, $recipients, $tip,$talep_id)
    {

        $attachmenttrue = false;
        $attachment = '';


        $this->communication_model->onay_mail($recipients, $subject, $message, $attachmenttrue, $attachment, $tip);

    }

    public function update_status()

    {


        $talep_id = $this->input->post('talep_id');

        $status = $this->input->post('status');


        $kullanici = $this->aauth->get_user()->id;


        $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and (proje_sorumlusu_id=$kullanici or proje_muduru_id=$kullanici  or bolum_mudur_id=$kullanici or genel_mudur_id=$kullanici) ");

        if ($query->num_rows() > 0) {

            if ($query->row()->proje_sorumlusu_id == $kullanici)    //proje sorumlusu onayladı
            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=1 and file_id=$talep_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('proje_sorumlusu_status	', $status);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 1);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array('proje_sorumlusu_status' => $status,
                        'file_id' => $talep_id,
                        'type' => 1);

                    $this->db->insert('geopos_onay', $data);
                }

                // Mail Gönderme

                $durum = purchase_status($status);
                if ($status == 3) {
                    $subject = 'Talep Formu Onayı';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Proje Sorumlusu Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Sizlerin Onayı Beklenmektedir.";

                    $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
                    $firma_kodu=$dbnames['firma_kodu'];
                    $validtoken = hash_hmac('ripemd160', 'p' . $talep_id, $this->config->item('encryption_key'));


                    $proje_mudur_id=$query->row()->proje_muduru_id;
                    $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$talep_id&pers_id=$proje_mudur_id&type=malzeme_talep_formu_onay&token=$validtoken";
                    $message .="<br>İncelemek İçin<a href='$href'>Tıklayınız</a>";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $proje_muduru_email = personel_detailsa($query->row()->proje_muduru_id)['email'];
                    // $genel_mudur_email=personel_detailsa($query->row()->genel_mudur_id)['email'];


                    $recipients = array($proje_muduru_email);


                    $this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili',$talep_id);

                    // Mail Gönderme
                } else {
                    //talep oluşturana mail at

                    $subject = 'Talep Formu Hk.';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Proje Sorumlusu Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Kontrolleri Sağlayıp Tekrar Talep Formu Oluşturmanızı Rica Ederiz.";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $talep_eden_pers = personel_detailsa($query->row()->talep_eden_pers_id)['email'];
                    // $genel_mudur_email=personel_detailsa($query->row()->genel_mudur_id)['email'];


                    $recipients = array($talep_eden_pers);


                    $this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili',$talep_id);

                }


            }

            if ($query->row()->proje_muduru_id == $kullanici)  //proje Müdürü onayladı

            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=1 and file_id=$talep_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('proje_muduru_status	', $status);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 1);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array('proje_muduru_status' => $status,
                        'file_id' => $talep_id,
                        'type' => 1);

                    $this->db->insert('geopos_onay', $data);
                }

                // Mail Gönderme

                $durum = purchase_status($status);

                if ($status == 3) {
                    $subject = 'Talep Formu Onayı';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Proje Müdürü Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Sizlerin Onayı Beklenmektedir.";

                    $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
                    $firma_kodu=$dbnames['firma_kodu'];
                    $validtoken = hash_hmac('ripemd160', 'p' . $talep_id, $this->config->item('encryption_key'));

                    $bolum_mudur_id=$query->row()->bolum_mudur_id;

                    $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$talep_id&pers_id=$bolum_mudur_id&type=malzeme_talep_formu_onay&token=$validtoken";
                    $message .="<br>İncelemek İçin<a href='$href'>Tıklayınız</a>";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $bolum_mudur_mail = personel_detailsa($query->row()->bolum_mudur_id)['email'];


                    $recipients = array($bolum_mudur_mail);


                    $this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili',$talep_id);

                    // Mail Gönderme
                } else {
                    //talep oluşturana mail at

                    $subject = 'Talep Formu Hk.';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Proje Sorumlusu Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Kontrolleri Sağlayıp Tekrar Talep Formu Oluşturmanızı Rica Ederiz.";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $proje_sorumlusu = personel_detailsa($query->row()->proje_sorumlusu_id)['email'];


                    $recipients = array($proje_sorumlusu);


                    $this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili',$talep_id);

                }

            }
            if ($query->row()->bolum_mudur_id == $kullanici)  //Bölüm Müdür onayladı

            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=1 and file_id=$talep_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('bolum_muduru_status', $status);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 1);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array('bolum_muduru_status' => $status,
                        'file_id' => $talep_id,
                        'type' => 1);

                    $this->db->insert('geopos_onay', $data);
                }

                // Mail Gönderme

                $durum = purchase_status($status);

                if ($status == 3) {
                    $subject = 'Talep Formu Onayı';
                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Bölüm Müdürü Tarafından Değiştirildi. Durum :' . $durum;
                    $message .= "<br><br><br><br>";
                    $message .= "Sizlerin Onayı Beklenmektedir.";

                    $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
                    $firma_kodu=$dbnames['firma_kodu'];
                    $validtoken = hash_hmac('ripemd160', 'p' . $talep_id, $this->config->item('encryption_key'));

                    $genel_mudur_id=$query->row()->genel_mudur_id;

                    $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$talep_id&pers_id=$genel_mudur_id&type=malzeme_talep_formu_onay&token=$validtoken";
                    $message .="<br>İncelemek İçin<a href='$href'>Tıklayınız</a>";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $genel_mudur_email = personel_detailsa($query->row()->genel_mudur_id)['email'];


                    $recipients = array($genel_mudur_email);


                    $this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili',$talep_id);

                    // Mail Gönderme
                }
                else {
                    //talep oluşturana mail at

                    $subject = 'Talep Formu Hk.';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Proje Müdürü Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Kontrolleri Sağlayıp Tekrar Talep Formu Oluşturmanızı Rica Ederiz.";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $satinalma_pers = personel_detailsa($query->row()->satinalma_pers_id)['email'];


                    $recipients = array($satinalma_pers);


                    $this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili',$talep_id);

                }

            }

            if ($query->row()->genel_mudur_id == $kullanici) {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=1 and file_id=$talep_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('genel_mudur_status', $status);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 1);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array('genel_mudur_status' => $status,
                        'file_id' => $talep_id,
                        'type' => 1);

                    $this->db->insert('geopos_onay', $data);
                }

                // Mail Gönderme

                $durum = purchase_status($status);
                if ($status == 3) {
                    $subject = 'Talep Formu Onayı';
                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Genel Müdür Tarafından Değiştirildi. Durum :' . $durum;
                    $message .= "<br><br><br><br>";
                    $message .= "Satın Alma Formu Oluşturabilirsiniz.";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');


                    $recipients = $this->satinalma_users();


                    $this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili',$talep_id);

                    // Mail Gönderme
                } else {
                    //talep oluşturana mail at

                    $subject = 'Talep Formu Hk.';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Genel Müdür Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Kontrolleri Sağlayıp Tekrar Talep Formu Oluşturmanızı Rica Ederiz.";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $proje_muduru_email = personel_detailsa($query->row()->proje_muduru_id)['email'];


                    $recipients = array($proje_muduru_email);


                    $this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili',$talep_id);

                }

                //update
                $this->db->set('status', $status);
                $this->db->where('id', $talep_id);
                $this->db->update('geopos_talep');


            }  //genel müdür onayladı satınalma departmanına gideccek


            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED'), 'pstatus' => $status));

        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Onaylamak İçin Yetkiniz Yoktur.', 'pstatus' => ''));
        }


    }

    public function malzeme_talep_formu_users($talep_id)
    {

        $this->db->select('geopos_employees.name,geopos_users.email');
        $this->db->from('geopos_employees');
        $this->db->where('geopos_employees.dept', 7);
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id');
        $query = $this->db->get();
        return $query->result_array();
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

    public function view()

    {
        $data=array();
        $tid = $this->input->get('id');
        $depo_mudur_id = talep_user_id_ogren('bolum_mudur_id',$tid);

        $data['depo_mudur_id']=$depo_mudur_id;
        $data['kullanici_id']=$this->aauth->get_user()->id;

        $data['depo_durum']=0;
        if($depo_mudur_id==$this->aauth->get_user()->id)
        {
            $data['depo_durum']=1;
        }


        $data['invoice'] = $this->requested->invoice_details($tid, $this->limited);
        $head['title'] = "Talep No " . $data['invoice']['id'];
        $data['invoice']['para_birimi'] = 1;
        $data['products'] = $this->requested->invoice_products($tid);
        $this->load->view('fixed/header', $head);
        $this->load->view('requested/requested-view', $data);
        $this->load->view('fixed/footer');
    }

    public function index()

    {

        $head['title'] = "Talep Listesi";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('requested/list');

        $this->load->view('fixed/footer');
    }


    public function test()
    {
        $tid = $this->input->get('id');

        $data['id'] = $tid;
        $data['invoice'] = $this->requested->invoice_details($tid, $this->limited);
        $this->load->view('requested/header-print-ltr', $data);
    }

    public function printinvoice()

    {


        $tid = $this->input->get('id');

        $data['id'] = $tid;


        $data['invoice'] = $this->requested->invoice_details($tid, $this->limited);

        if ($data['invoice']) $data['products'] = $this->requested->invoice_products($tid);


        ini_set('memory_limit', '64M');


        $html = $this->load->view('requested/view-print-' . LTR, $data, true);
        $header = $this->load->view('requested/header-print-' . LTR, $data, true);
        $footer = $this->load->view('requested/footer-print-' . LTR, $data, true);

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
            90, // margin top
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

    public function ajax_list()

    {


        $list = $this->requested->get_datatables($this->limited);


        $data = array();


        $no = $this->input->post('start');

        $this->session->set_userdata('test', 1);

        foreach ($list as $invoices) {

            $no++;

            $row = array();

            //$row[] = $no;
            $row[] = dateformat($invoices->olusturma_tarihi);

            $row[] = dateformat($invoices->onay_tarihi);

            $row[] = $invoices->talep_no;

            $row[] = $invoices->proje_name;


            $row[] = amountFormat($invoices->total, 1);

            $row[] = purchase_status($invoices->status);


            $row[] = '<a href="' . base_url("requested/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("requested/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="İndir"><span class="fa fa-download"></span></a> <a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-sm delete-object"><span class="fa fa-trash"></span></a>';


            $data[] = $row;

        }


        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->requested->count_all($this->limited),

            "recordsFiltered" => $this->requested->count_filtered($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);


    }


    public function edit()

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

        $role_id = $this->aauth->get_user()->roleid;
        if ($role_id==8) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

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

        if ($data['invoice']) $this->load->view('requested/edit', $data);

        $this->load->view('fixed/footer');


    }
    public function satinalma_edit()

    {


        $tid = intval($this->input->get('id'));

        $sayi=0;
        $query=$this->db->query('Select * From geopos_onay where `type`=2 and file_id='.$tid)->result();
        $status=$this->db->query('Select * From geopos_talep where id='.$tid)->row()->status;

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


        $head['title'] = "Satın Alma Formu Düzenle #" . $invoice_no;

        if ($data['invoice']) $data['products'] = $this->requested->invoice_products_satinalma_edit($tid);


        $head['title'] = "Satın Alma Formu Düzenle #" . $invoice_no;

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        if ($data['invoice']) $this->load->view('requested/satinalma_edit', $data);

        $this->load->view('fixed/footer');


    }

    public function editaction()
    {
        $st=0; //Muhasebe ürünleri
        $stok_durumu = $this->input->post('stok_durumu', true);

        if($stok_durumu=='on')
        {
            $st=1;
        }

        $currency = 1;
        $tip = $this->input->post('tip_id');


        $proje_name = $this->input->post('proje_name');
        $proje_id = $this->input->post('proje_id');
        $olusturma_tarihi = $this->input->post('olusturma_tarihi');
        $onay_tarihi = $this->input->post('onay_tarihi');
        $talep_eden_pers_id = $this->input->post('talep_eden_pers_id');
        $bolum_mudur_id = $this->input->post('bolum_mudur_id');

        $genel_mudur_id = $this->input->post('genel_mudur_id');
        $email = $this->input->post('email');
        $tel = $this->input->post('tel');
        $description = $this->input->post('description');
        $discount_format = $this->input->post('discount_format');
        $discount_rate = $this->input->post('discount_rate');

        $proje_sorumlusu_id = $this->input->post('proje_sorumlusu_id');
        $proje_muduru_id = $this->input->post('proje_muduru_id');
        $gonderme_sekli = $this->input->post('gonderme_sekli');


        $subtotal = $this->input->post('subtotal', true); // Ara Toplam
        $tax = 0; //toplam kdv
        $discount = 0; //toplam indirim
        $nettotalinp = $this->input->post('nettotalinp', true); // Net toplam
        $total = $this->input->post('total'); //Genel Toplam
        $proje_bolum_id = $this->input->post('proje_bolum_id');


        $olusturma_tarihi_d = datefordatabase($olusturma_tarihi);

        $onay_tarihi_d = datefordatabase($onay_tarihi);

        $transok = true;

        $st_c = 0;

        $this->db->trans_start();

        $data = array(
            'proje_name' => $proje_name,
            'proje_id' => $proje_id,
            'olusturma_tarihi' => $olusturma_tarihi_d,
            'onay_tarihi' => $onay_tarihi_d,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'nettotal' => $nettotalinp,
            'total' => $total,
            'tel' => $tel,
            'email' => $email,
            'description' => $description,
            'talep_olusturan_pers_id' => $this->aauth->get_user()->id,
            'bolum_mudur_id' => $bolum_mudur_id,
            'talep_eden_pers_id' => $talep_eden_pers_id,
            'proje_muduru_id' => $proje_muduru_id,
            'proje_sorumlusu_id' => $proje_sorumlusu_id,
            'gonderme_sekli' => $gonderme_sekli,
            'genel_mudur_id' => $genel_mudur_id,
            'discount_format' => $discount_format,
            'discount_rate' => $discount_rate,
            'proje_bolum_id' => $proje_bolum_id,
            'proje_bolum_name' => $this->db->query("SELECT * FROM geopos_project_bolum Where id =$proje_bolum_id")->row()->name,
            'loc' => $this->aauth->get_user()->loc


        );


        $this->db->set($data);

        $this->db->where('id', $tip);


        if ($this->db->update('geopos_talep', $data)) {

            $this->aauth->applog("Malzeme Talep Formu Düzenlendi $tip ID ".$tip,$this->aauth->get_user()->username);
            kont_kayit(22,$tip);

            $this->db->delete('geopos_talep_items', array('tip' => $tip));
            $this->db->delete('geopos_onay', array('file_id' => $tip));
            $product_name = $this->input->post('product_name');
            $productlist = array();
            $data_items = array();
            $prodindex = 0;
            $itc = 0;
            $total_tax = 0;
            $total_discount = 0;


            foreach ($product_name as $key => $value) {
                $product_name = $this->input->post('product_name');
                $unit = $this->input->post('unit');
                $product_detail = $this->input->post('product_detail');
                $product_qty = $this->input->post('product_qty');
                $product_id = $this->input->post('pid');


                $bolum_id=0;
                $bagli_oldugu_asama_id_val=0;
                $asama_id=0;

                if($st==1)
                {
                    $bolum_id = $this->input->post('bolum_id');
                    $bagli_oldugu_asama_id_val = $this->input->post('bagli_oldugu_asama_id_val');
                    $asama_id = $this->input->post('asama_id');
                    $data_items = array(

                        'tip' => $tip,

                        'product_name' => $product_name[$key],
                        'product_detail' => $product_detail[$key],

                        'bolum_id' => $bolum_id[$key],

                        'bagli_oldugu_asama_id' => $bagli_oldugu_asama_id_val[$key],

                        'asama_id' => $asama_id[$key],

                        'product_id' => $product_id[$key],

                        'qty' => $product_qty[$key],

                        'price' => 0,

                        'tax' => 0,

                        'discount' => 0,

                        'subtotal' => 0,

                        'totaltax' => 0,

                        'totaldiscount' => 0,

                        'unit' => $unit[$key]
                    );
                }
                else
                {
                    $data_items = array(

                        'tip' => $tip,

                        'product_name' => $product_name[$key],
                        'product_detail' => $product_detail[$key],

                        'bolum_id' => $bolum_id,

                        'bagli_oldugu_asama_id' => $bagli_oldugu_asama_id_val,

                        'asama_id' => $asama_id,

                        'product_id' => $product_id[$key],

                        'qty' => $product_qty[$key],

                        'price' => 0,

                        'tax' => 0,

                        'discount' => 0,

                        'subtotal' => 0,

                        'totaltax' => 0,

                        'totaldiscount' => 0,

                        'unit' => $unit[$key]
                    );

                }

                if(isset($product_id[$key]))
                {
                    if($product_id[$key]!=0)
                    {
                        $productlist[$prodindex] = $data_items;

                        $this->db->insert('geopos_talep_items', $data_items);

                        $malzeme_items_id = $this->db->insert_id();

                        $data_o= array(
                            'product_id' => $product_id[$key],
                            'malzeme_items_id' => $malzeme_items_id,
                            'file_id' => $tip,
                            'type' => 1);

                        $this->db->insert('geopos_onay', $data_o);

                        $prodindex++;
                    }
                }



            }

            if ($prodindex > 0) {

                //$this->db->insert_batch('geopos_talep_items', $productlist);

                $this->db->set(array(
                    'discount' => rev_amountExchange($total_discount, $currency),
                    'tax' => rev_amountExchange($total_tax, $currency)
                ));

                $this->db->where('id', $tip);

                $this->db->update('geopos_talep');


            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "Lütfen ürün listesinden ürün seçin. Ürünleri eklemediyseniz, Ürün yöneticisi bölümüne gidin."));

                $transok = false;

            }

            if ($transok) {


                echo json_encode(array('status' => 'Success', 'message' =>

                    $this->lang->line('talep_success') . " <a href='view?id=$tip' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$tip' class='btn btn-indigo btn-lg' target='_blank'><span class='icon-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; "));
                $this->db->trans_complete();
            }

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                "Invalid Entry!"));

            $transok = false;
            $this->db->trans_rollback();


        }


    }

    public function action_satinalma()
    {
        $talep_no = numaric(3);
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
        $ihale_formu_id = $this->input->post('ihale_formu_id');
        $aciklama = $this->input->post('aciklama');
        $para_birimi_ = $this->input->post('para_birimi_');

        $kullanici_id =$this->aauth->get_user()->id;

        $transok = true;

        $st_c = 0;


        $this->db->trans_start();
        $olus_t = datefordatabase($olusturma_tarihi);
        $data = array(
            'talep_no' => $talep_no,
            'proje_name' => $proje_name,
            'proje_id' => $proje_id,
            'olusturma_tarihi' => $olus_t,
            'talep_olusturan_pers_id' => $this->aauth->get_user()->id,
            'hazirlayan_pers_id' => $hazirlayan_per_is,
            'satinalma_mudur_id' => $satinalma_mudur_id,
            'genel_mudur_id' => $genel_mudur_id,
            'proje_muduru_id' => $proje_muduru_id,
            'finans_departman_pers_id' => $finans_departman_pers_id,
            'satinalma_personeli' => $satinalma_pers_id,
            'bolum_mudur_id' => $bolum_mudur_id,
            'bolum_adi' => $bolum_adi,
            'malzeme_talep_form_id' => $malzeme_talep_form_id,
            'ihale_formu_id' => $ihale_formu_id,
            'tip' => 2,
            'kullanici_id' => $kullanici_id,
            'aciklama' => $aciklama,
            'para_birimi' => $para_birimi_,
            'loc' => $this->aauth->get_user()->loc);

        if ($this->db->insert('geopos_talep', $data)) {

            $talep_id = $this->db->insert_id();

            $this->aauth->applog("Satınalma Formu Oluşturuldu $talep_no ID ".$talep_id,$this->aauth->get_user()->username);
            kont_kayit(23,$talep_id);

            $operator= "deger+1";
            $this->db->set('deger', "$operator", FALSE);
            $this->db->where('tip', 3);
            $this->db->update('numaric');



            $product_name = $this->input->post('product_name');
            $product_id = $this->input->post('product_id');
            $product_detail = $this->input->post('product_detail');
            $product_qty = $this->input->post('product_qty');
            $unit = $this->input->post('unit');

            $product_price = $this->input->post('product_price');
            $product_tutar = $this->input->post('product_tutar');
            $firma = $this->input->post('firma');
            $firma_tel = $this->input->post('firma_tel');
            $teklif_tarih_no = $this->input->post('teklif_tarih_no');
            $odeme_sekli = $this->input->post('odeme_sekli');
            $method = $this->input->post('method');
            $odeme_tarihi = $this->input->post('odeme_tarihi');
            $marka = $this->input->post('marka');
            $ulke = $this->input->post('ulke');
            $ref_urun = $this->input->post('ref_urun');
            $firma_id = $this->input->post('firma_id');
            $kdv_durumu = $this->input->post('kdv_durumu');

            $prodindex = 0;
            foreach ($product_name as $key => $nms) {
                $product_name_ = $product_name[$key];
                $product_id_ = $product_id[$key];
                $product_detail_ = $product_detail[$key];
                $product_qty_ = $product_qty[$key];
                $unit_ = $unit[$key];

                $firma_name='';
                $firma_ids=0;
                if(is_numeric($firma[$key])){
                    $firma_name = customer_details($firma[$key])['company'];
                    $firma_ids = $firma[$key];
                }
                else {
                    $firma_details=$this->db->query("SELECT* FROM geopos_customers Where company='$firma[$key]'");
                    if($firma_details->num_rows()){
                        $firma_ids = $firma_details->row()->id;
                        $firma_name = $firma[$key];
                    }
                }

                $currency = 1;
                if ($product_name_ != '') {
                    $data_items = array(

                        'tip' => $talep_id,
                        'product_id' => $product_id_,
                        'product_name' => $product_name_,
                        'product_detail' => $product_detail_,
                        'firma_tel' => $firma_tel[$key],
                        'firma' => $firma_name,
                        'teklif_tarih_no' => $teklif_tarih_no[$key],
                        'odeme_sekli' => $odeme_sekli[$key],
                        'price' => $product_price[$key],
                        'subtotal' =>$product_tutar[$key],
                        'qty' => $product_qty_,
                        'unit' => $unit_,
                        'odeme_tarihi' => $odeme_tarihi[$key],
                        'method' => $method[$key],
                        'marka' => $marka[$key],
                        'ulke' => $ulke[$key],
                        'ref_urun' => $ref_urun[$key],
                        'kdv_dahil_haric'=>$kdv_durumu[$key],
                        'firma_id' => $firma_ids
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

            // Mail Gönderme






            // Mail Gönderme
            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('talep_success') . " <a href='/form/satinalma_view?id=$talep_id' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp;<a href='printinvoice?id=$talep_id' class='btn btn-indigo btn-lg' target='_blank'><span class='icon-print' aria-hidden='true'></span> " . $this->lang->line('Print') . "  </a> &nbsp; &nbsp; "));
            $this->db->trans_complete();
        }
    }

    public function edit_action_satinalma()
    {


        $sayi=0;
        $talep_id = $this->input->post('tip_id');
        $query=$this->db->query("Select * From geopos_onay where `type`=2 and file_id=$talep_id")->result();

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
            echo json_encode(array('status' => 'Error', 'message' =>'Sayın kullanıcıcı Bu form işlem görmüştür.Bu sebep ile güncelleme yapamazsınız!'));
        }
        else
        {

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
            $ihale_formu_id = $this->input->post('ihale_formu_id');
            $aciklama = $this->input->post('aciklama');
            $para_birimi_ = $this->input->post('para_birimi_');

            $transok = true;

            $st_c = 0;

            /*
            'hazirlayan_pers_id' => $hazirlayan_per_is,
            'talep_olusturan_pers_id' => $this->aauth->get_user()->id,
            'satinalma_personeli' => $satinalma_pers_id,
            'satinalma_mudur_id' => $satinalma_mudur_id,
            */
            $this->db->trans_start();
            $olus_t = datefordatabase($olusturma_tarihi);
            $data = array(
                'proje_name' => $proje_name,
                'proje_id' => $proje_id,
                'olusturma_tarihi' => $olus_t,
                'genel_mudur_id' => $genel_mudur_id,
                'proje_muduru_id' => $proje_muduru_id,
                'finans_departman_pers_id' => $finans_departman_pers_id,
                'bolum_mudur_id' => $bolum_mudur_id,
                'bolum_adi' => $bolum_adi,
                'malzeme_talep_form_id' => $malzeme_talep_form_id,
                'ihale_formu_id' => $ihale_formu_id,
                'aciklama' => $aciklama,
                'para_birimi' => $para_birimi_,
                'tip' => 2,
                'loc' => $this->aauth->get_user()->loc);
            $this->db->where('id', $talep_id);

            if ($this->db->update('geopos_talep', $data)) {

                $this->aauth->applog("Satınalma Formu Düzenlendi $talep_id ID ".$talep_id,$this->aauth->get_user()->username);
                kont_kayit(24,$talep_id);

                $this->db->delete('geopos_onay', array('file_id' => $talep_id));
                $this->db->delete('geopos_talep_items', array('tip' => $talep_id,));


                $product_name = $this->input->post('product_name');
                $product_id = $this->input->post('product_id');
                $product_detail = $this->input->post('product_detail');
                $product_qty = $this->input->post('product_qty');
                $unit = $this->input->post('unit');

                $product_price = $this->input->post('product_price');
                $product_tutar = $this->input->post('product_tutar');
                $firma = $this->input->post('firma');
                $firma_tel = $this->input->post('firma_tel');
                $method = $this->input->post('method');
                $teklif_tarih_no = $this->input->post('teklif_tarih_no');
                $odeme_sekli = $this->input->post('odeme_sekli');
                $odeme_tarihi = $this->input->post('odeme_tarihi');

                $marka = $this->input->post('marka');
                $ulke = $this->input->post('ulke');
                $ref_urun = $this->input->post('ref_urun');
                $firma_id = $this->input->post('firma_id');
                $kdv_durumu = $this->input->post('kdv_durumu');

                $prodindex = 0;
                foreach ($product_name as $key => $nms) {
                    $product_name_ = $product_name[$key];
                    $product_id_ = $product_id[$key];
                    $product_detail_ = $product_detail[$key];
                    $product_qty_ = $product_qty[$key];
                    $unit_ = $unit[$key];

                    $currency = 1;
                    if ($product_name_ != '') {

                        $firma_name = customer_details($firma[$key])['company'];
                        $data_items = array(

                            'tip' => $talep_id,
                            'product_name' => $product_name_,
                            'method' => $method[$key],
                            'product_id' => $product_id_,
                            'product_detail' => $product_detail_,
                            'firma_tel' => $firma_tel[$key],
                            'firma' => $firma_name,
                            'teklif_tarih_no' => $teklif_tarih_no[$key],
                            'odeme_sekli' => $odeme_sekli[$key],
                            'price' => $product_price[$key],
                            'subtotal' =>$product_tutar[$key],
                            'qty' => $product_qty_,
                            'unit' => $unit_,
                            'odeme_tarihi' => $odeme_tarihi[$key],
                            'marka' => $marka[$key],
                            'ulke' => $ulke[$key],
                            'ref_urun' => $ref_urun[$key],
                            'kdv_dahil_haric' => $kdv_durumu[$key],
                            'firma_id' => $firma[$key]
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
                echo json_encode(array('status' => 'Success', 'message' =>

                    $this->lang->line('talep_success') . " <a href='/form/satinalma_view?id=$talep_id' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a>"    ));
                $this->db->trans_complete();
            }
        }


    }



    public function test2()
    {
        $this->load->view('requested/view-print-satinalma-' . LTR, true);
    }

    public  function getSmallLink($longurl){
        $sayi=rand(1,99999999);
        $name='makro2000'.$sayi;
        $url = urlencode("$longurl");
        $json = file_get_contents("https://cutt.ly/api/api.php?key=e67f08835022a9c59b736d5c9e109ba5a8c4a&short=$url&name=$name");
        $data = json_decode ($json, true);

        return $data['url']['shortLink'];

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

    public function update_status_satinalma()

    {

        $talep_id = $this->input->post('talep_id');

        $status = $this->input->post('status');

        $kullanici = $this->aauth->get_user()->id;


        $query = $this->db->query("SELECT * FROM geopos_talep where id=$talep_id and  (
        satinalma_personeli=$kullanici or satinalma_mudur_id=$kullanici or
          proje_muduru_id=$kullanici  or bolum_mudur_id=$kullanici or
          genel_mudur_id=$kullanici or finans_departman_pers_id=$kullanici) ");


        if ($query->num_rows() > 0) {

            if ($query->row()->satinalma_personeli == $kullanici)    //satınalma personeli onayladı
            {
                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=2 and file_id=$talep_id");

                if ($onay_kontrol->num_rows() > 0)
                {
                    //update
                    $this->db->set('satinalma_personeli_status	', $status);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 2);
                    $this->db->update('geopos_onay');


                }
                else
                {
                    //insert
                    $data = array('satinalma_personeli_status' => $status,
                        'file_id' => $talep_id,
                        'type' => 2);

                    $this->db->insert('geopos_onay', $data);
                }

                // Mail Gönderme

                $durum = purchase_status($status);
                if ($status == 3)
                {
                    $subject = 'Satın Alma Formu Onayladı';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Satın Alma Formun Durumu Satın Alma Personeli Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Sizlerin Onayı Beklenmektedir.";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $satin_alma_muduru = personel_detailsa($query->row()->satinalma_mudur_id)['email'];


                    $recipients = array($satin_alma_muduru);


                    $this->onay_mailleri($subject, $message, $recipients, 'satin_alma_formu',$talep_id);

                    // Mail Gönderme
                }
                else
                {
                    //talep oluşturana mail at

                    $subject = 'Satın Alma Formu Hk.';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Satın Alma Formunun Durumu Satın Alma Müdürü Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Kontrolleri Sağlayıp Tekrar Talep Formu Oluşturmanızı Rica Ederiz.";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $talep_eden_pers = personel_detailsa($query->row()->talep_eden_pers_id)['email'];


                    $recipients = array($talep_eden_pers);


                    $this->onay_mailleri($subject, $message, $recipients, 'satin_alma_formu',$talep_id);

                }


            }


            if ($query->row()->satinalma_mudur_id == $kullanici)    //satınalma Müdürü onayladı
            {
                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=2 and file_id=$talep_id");

                if ($onay_kontrol->num_rows() > 0)
                {
                    //update
                    $this->db->set('satinalma_status	', $status);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 2);
                    $this->db->update('geopos_onay');


                }
                else
                {
                    //insert
                    $data = array('satinalma_status' => $status,
                        'file_id' => $talep_id,
                        'type' => 2);

                    $this->db->insert('geopos_onay', $data);
                }

                // Mail Gönderme

                $durum = purchase_status($status);
                if ($status == 3)
                {
                    $subject = 'Satın Alma Formu Onayladı';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Satın Alma Formun Durumu Satın Alma Müdürü Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Sizlerin Onayı Beklenmektedir.";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $proje_muduru_email = personel_detailsa($query->row()->proje_muduru_id)['email'];


                    $recipients = array($proje_muduru_email);


                    $this->onay_mailleri($subject, $message, $recipients, 'satin_alma_formu',$talep_id);

                    // Mail Gönderme
                }
                else
                {
                    //talep oluşturana mail at

                    $subject = 'Satın Alma Formu Hk.';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Satın Alma Formunun Durumu Satın Alma Müdürü Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Kontrolleri Sağlayıp Tekrar Talep Formu Oluşturmanızı Rica Ederiz.";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $talep_eden_pers = personel_detailsa($query->row()->talep_eden_pers_id)['email'];


                    $recipients = array($talep_eden_pers);


                    $this->onay_mailleri($subject, $message, $recipients, 'satin_alma_formu',$talep_id);

                }


            }


            if ($query->row()->proje_muduru_id == $kullanici)  //proje Müdürü onayladı

            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=2 and file_id=$talep_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('proje_muduru_status	', $status);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 2);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array('proje_muduru_status' => $status,
                        'file_id' => $talep_id,
                        'type' => 2);

                    $this->db->insert('geopos_onay', $data);
                }

                // Mail Gönderme

                $durum = purchase_status($status);

                if ($status == 3) {
                    $subject = 'Satın Alma Formu Onayı';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Satın Alma Formunun Durumu Proje Müdürü Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Sizlerin Onayı Beklenmektedir.";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $bolum_mudur_email = personel_detailsa($query->row()->bolum_mudur_id)['email'];


                    $recipients = array($bolum_mudur_email);


                    $this->onay_mailleri($subject, $message, $recipients, 'satin_alma_formu',$talep_id);

                    // Mail Gönderme
                }

                else {
                    //talep oluşturana mail at

                    $subject = 'Satın Alma Formu Hk.';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Satın Alma Formunun Durumu Proje Müdürü Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Kontrolleri Sağlayıp Tekrar Talep Formu Oluşturmanızı Rica Ederiz.";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $satinalma_pers = personel_detailsa($query->row()->satinalma_pers_id)['email'];


                    $recipients = array($satinalma_pers);


                    $this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili',$talep_id);

                }

            }

            if ($query->row()->bolum_mudur_id == $kullanici)  //Bölüm Müdür onayladı

            {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=2 and file_id=$talep_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('bolum_muduru_status', $status);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 2);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array('bolum_muduru_status' => $status,
                        'file_id' => $talep_id,
                        'type' => 2);

                    $this->db->insert('geopos_onay', $data);
                }

                // Mail Gönderme

                $durum = purchase_status($status);

                if ($status == 3) {
                    $subject = 'Satın Alma Formu Onayı';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Satın Alma Formunun Durumu Bölüm Müdürü Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Sizlerin Onayı Beklenmektedir.";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $genel_mudur_email = personel_detailsa($query->row()->genel_mudur_id)['email'];


                    $recipients = array($genel_mudur_email);


                    $this->onay_mailleri($subject, $message, $recipients, 'satin_alma_formu',$talep_id);

                    // Mail Gönderme
                }
                else {
                    //talep oluşturana mail at

                    $subject = 'Satın Alma Formu Hk.';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Satın Alma Formunun Durumu Proje Müdürü Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Kontrolleri Sağlayıp Tekrar Talep Formu Oluşturmanızı Rica Ederiz.";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $satinalma_pers = personel_detailsa($query->row()->satinalma_pers_id)['email'];


                    $recipients = array($satinalma_pers);


                    $this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili',$talep_id);

                }

            }

            if ($query->row()->genel_mudur_id == $kullanici) {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=2 and file_id=$talep_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('genel_mudur_status', $status);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 2);
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array('genel_mudur_status' => $status,
                        'file_id' => $talep_id,
                        'type' => 2);

                    $this->db->insert('geopos_onay', $data);
                }

                // Mail Gönderme

                $durum = purchase_status($status);
                if ($status == 3) {
                    $subject = 'Satın Alma Formu Onayı';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Satın Alma Formunun Durumu Genel Müdür Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Sizlerin Onayı Beklenmektedir.";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');


                    $finans_departman_per_email=personel_detailsa($query->row()->finans_departman_pers_id)['email'];
                    $recipients = array($finans_departman_per_email);


                    $this->onay_mailleri($subject, $message, $recipients, 'satin_alma_formu',$talep_id);

                    // Mail Gönderme
                }

                else {
                    //talep oluşturana mail at

                    $subject = 'Talep Formu Hk.';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Genel Müdür Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Kontrolleri Sağlayıp Tekrar Talep Formu Oluşturmanızı Rica Ederiz.";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $proje_muduru_email = personel_detailsa($query->row()->proje_muduru_id)['email'];


                    $recipients = array($proje_muduru_email);


                    $this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili',$talep_id);

                }

                //update
                $this->db->set('status', $status);
                $this->db->where('id', $talep_id);
                $this->db->update('geopos_talep');


            }

            if ($query->row()->finans_departman_pers_id == $kullanici) {


                $onay_kontrol = $this->db->query("SELECT * FROM `geopos_onay` where `type`=2 and file_id=$talep_id");
                if ($onay_kontrol->num_rows() > 0) {
                    //update
                    $this->db->set('finans_status', $status);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 2) ;
                    $this->db->update('geopos_onay');


                } else {
                    //insert
                    $data = array('finans_status' => $status,
                        'file_id' => $talep_id,
                        'type' => 2);

                    $this->db->insert('geopos_onay', $data);
                }

                // Mail Gönderme

                $durum = purchase_status($status);
                if ($status == 3) {
                    $subject = 'Satın Alma Formu Onayı';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Satın Alma Formunun Durumu Finans Departmanı Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Satın Alma Emri Oluşturabilirsiniz.";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');



                    $recipients = $this->satinalma_users();


                    $this->onay_mailleri($subject, $message, $recipients, 'satin_alma_formu',$talep_id);

                    // Mail Gönderme
                }
                else {
                    //talep oluşturana mail at

                    $subject = 'Talep Formu Hk.';

                    $message = 'Sayın Yetkili ' . $query->row()->talep_no . ' Numaralı Talep Formunun Durumu Genel Müdür Tarafından Değiştirildi. Durum :' . $durum;


                    $message .= "<br><br><br><br>";
                    $message .= "Kontrolleri Sağlayıp Tekrar Talep Formu Oluşturmanızı Rica Ederiz.";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
    <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
                 ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $proje_muduru_email = personel_detailsa($query->row()->proje_muduru_id)['email'];


                    $recipients = array($proje_muduru_email);


                    $this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili',$talep_id);

                }



            }  //finans depertmanı onayladı satınalma departmanına gideccek


            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED'), 'pstatus' => $status));

        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Onaylamak İçin Yetkiniz Yoktur.', 'pstatus' => ''));
        }


    }

    public function arastirma_talep_olustur()
    {
        $personel_l=$this->input->post('personel_l');


        foreach ($personel_l as $key=>$value)
        {

            $malzeme_talep_id=$this->input->post('malzeme_talep_id');
            $mesaj=$this->input->post('mesaj');
            $personel=$personel_l[$key];

            $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
            $firma_kodu=$dbnames['firma_kodu'];
            $validtoken = hash_hmac('ripemd160', 'p' . $malzeme_talep_id, $this->config->item('encryption_key'));
            $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$malzeme_talep_id&pers_id=$personel&type=malzeme_talep_arge&token=$validtoken";


            $short_url = $this->getSmallLink($href);



            $no=personel_detailsa($personel)['phone'];

            $this->mesaj_gonder($no,$mesaj.' İncelemek İcin Tiklayiniz '.$short_url);


            $data=array(
                'pers_id'=>$personel,
                'mesaj'=>$mesaj,
                'talep_id'=>$malzeme_talep_id
            );
            $this->db->insert('geopos_satinalma_arge', $data);


        }

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => 2));




    }

    public function mesaj_gonder2($proje_sorumlusu_no,$mesaj)
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

        return 1;




    }

    public function proje_guncelle()
    {
        $proje_id=$this->input->post('proje_id');
        $talep_id=$this->input->post('talep_id');
        $proje_bolum_id=$this->input->post('proje_bolum_id');

        $proje_name=proje_name($proje_id);
        $proje_bolum_id_name=$this->db->query("SELECT * FROM geopos_project_bolum Where id =$proje_bolum_id")->row()->name;

        $this->db->set('proje_id', "$proje_id", FALSE);
        $this->db->set('proje_name', "'$proje_name'", FALSE);
        $this->db->set('proje_bolum_id', "'$proje_bolum_id'", FALSE);
        $this->db->set('proje_bolum_name', "'$proje_bolum_id_name'", FALSE);
        $this->db->where('id', $talep_id);

        if($this->db->update('geopos_talep'))
        {
            echo json_encode(array('status' => 'Success', 'message' =>"Başarıyla Güncellendi"));

        }



    }






}
