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



use Twilio\Rest\Client;



class Sms Extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->model('plugins_model', 'plugins');



        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }

        $this->load->library('parser');



    }



    //todo section



    public function template()

    {



        $id = $this->input->post('invoiceid');

        $ttype = $this->input->post('ttype');

        if ($ttype == 'quote') {



            $invoice['tid'] = $id;

            $this->load->model('quote_model', 'quote');

            $invoice = $this->quote->quote_details($id);

            $validtoken = hash_hmac('ripemd160', 'q' . $id, $this->config->item('encryption_key'));



            $link = base_url('billing/quoteview?id=' . $id . '&token=' . $validtoken);

        } elseif ($ttype == 'purchase') {

            $invoice['tid'] = $id;

            $this->load->model('purchase_model', 'purchase');

            $invoice = $this->purchase->purchase_details($id);

            $validtoken = hash_hmac('ripemd160', $id, $this->config->item('encryption_key'));



            $link = base_url('billing/purchase?id=' . $id . '&token=' . $validtoken);

        }


        elseif ($ttype == 'sayim_sms') {

            $invoice['tid'] = $id;

            $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
            $firma_kodu=$dbnames['firma_kodu'];

            $this->load->model('sayim_model', 'sayim');

            $invoice = $this->sayim->sayim_details($id);



            $validtoken = hash_hmac('ripemd160', $id, $this->config->item('encryption_key'));
            $link = "http://muhasebe.italicsoft.com/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$id&type=sayim_sms&token=$validtoken";
            //$link = base_url('billing/purchase?id=' . $id . '&token=' . $validtoken);

        }
        else {

            $invoice['tid'] = $id;



            $this->load->model('invoices_model', 'invoices');

            $invoice = $this->invoices->invoice_details($id);



            $validtoken = hash_hmac('ripemd160', $id, $this->config->item('encryption_key'));


            $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
            $firma_kodu=$dbnames['firma_kodu'];

            $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$id&type=invoice_update&token=$validtoken";


            $link= $this->getSmallLink($href);


        }



        $sms_service = $this->plugins->universal_api(1);



        if ($sms_service['active']) {



            $this->load->library("Shortenurl");

            $this->shortenurl->setkey($sms_service['key1']);

            $link = $this->shortenurl->shorten($link);



        }



        $this->load->model('templates_model', 'templates');

        switch ($ttype) {

            case 'notification':

                $template = $this->templates->template_info(30);

                break;

            case 'sayim_sms':

                $template = $this->templates->template_info(37);

                break;



            case 'reminder':

                $template = $this->templates->template_info(31);

                break;



            case 'refund':

                $template = $this->templates->template_info(32);

                break;





            case 'received':

                $template = $this->templates->template_info(33);

                break;



            case 'overdue':

                $template = $this->templates->template_info(34);

                break;





            case 'quote':

                $template = $this->templates->template_info(35);

                break;





            case 'purchase':

                $template = $this->templates->template_info(36);

                break;





        }



        $data = array(

            'BillNumber' => $invoice['tid'],

            'URL' => $link,

            'DueDate' => dateformat($invoice['invoiceduedate']),

            'Amount' => amountExchange($invoice['total'], $invoice['multi'])

        );

        $message = $this->parser->parse_string($template['other'], $data, TRUE);





        echo json_encode(array('message' => $message));

    }


    public  function getSmallLink($longurl){
        $sayi=rand(1,99999999);
        $name='makro2000'.$sayi;
        $url = urlencode("$longurl");
        $json = file_get_contents("https://cutt.ly/api/api.php?key=e67f08835022a9c59b736d5c9e109ba5a8c4a&short=$url&name=$name");
        $data = json_decode ($json, true);

        return $data['url']['shortLink'];

    }





    public function send_sms_yedek()

    {



        $mobile = $this->input->post('mobile');

        $text_message = $this->input->post('text_message');



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



        if ($message->sid) {

            echo json_encode(array('status' => 'Success', 'message' => 'Mesajınız Başarıyla Gönderildi. Mesaj Durumurumu : ' . $message->status));

        } else {

            echo json_encode(array('status' => 'Error', 'message' => 'SMS Service Error'));

        }





    }

    public function send_sms()

    {



        $pers_id = $this->input->post('pers_id');
        $invoice_id = $this->input->post('tid');

        $proje_sorumlusu_no = personel_detailsa($pers_id)['phone'];

        $text_message = $this->input->post('text_message');
        $kontrol = $this->db->query("SELECT * FROM sms_log Where invoice_id = $invoice_id");

        if($kontrol->num_rows()){
            $this->db->delete('sms_log', array('invoice_id' => $invoice_id));
        }
        $data=['pers_id'=>$pers_id,'invoice_id'=>$invoice_id,'emp_id'=>$this->aauth->get_user()->id,'sms'=>$text_message];
        $this->db->insert('sms_log', $data);
        
        if ($this->mesaj_gonder($proje_sorumlusu_no,$text_message)) {

            echo json_encode(array('status' => 'Success', 'message' => 'Mesajınız Başarıyla Gönderildi. Mesaj Durumurumu : Başarılı' ));

        } else {

            echo json_encode(array('status' => 'Error', 'message' => 'SMS Service Error'));

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
        curl_close($ch);

        return 1;




    }





}





