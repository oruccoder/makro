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

use Omnipay\Omnipay;

class Billing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('invoices_model', 'invocies');
        $this->load->model('billing_model', 'billing');
        $this->load->library("Aauth");
        $this->load->model('tools_model', 'tools');

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

    public function gorusme()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = $this->input->get('id');
        $token = $this->input->get('token');
        $pers_id = $this->input->get('pers_id');

        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));


        if (hash_equals($token, $validtoken))
        {
            $this->db->set('status', 3);

            $this->db->where('id', $tid);

            if($this->db->update('geopos_notes'))
            {


            }
        }
        $data['meesage']='Onaylandı';
        $this->load->view('billing/gorusme_onay',$data);
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


}