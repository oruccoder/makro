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

class Faktorinq extends CI_Controller
{
    public function __construct()

    {

        parent::__construct();

        $this->load->model('faktorinq_model', 'invocies');
        $this->load->library("Aauth");
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
    public function index()
    {
        if (!$this->aauth->premission(18)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['title'] = "Faktorinq";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('faktorinq/index');
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


                $row[] = '<a href="' . base_url("faktorinq/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="Görüntüle"><i class="fa fa-eye"></i></a>';

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


                $row[] = amountFormat($invoices->subtotal,$invoices->para_birimi);
                $row[] = amountFormat($invoices->tax,$invoices->para_birimi);

                $row[] = amountFormat($invoices->total,$invoices->para_birimi);

                $row[] = '<span class="st-' . $invoices->status . '">' . invoice_status_ogren($invoices->status) . '</span>';
                $row[] = customer_details($invoices->alt_cari_id)['company'];

                $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>
                    &nbsp;<a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>
                    <a target="_blank"  href="' . base_url("/employee/view?id=$invoices->eid") .'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" data-html="true" title="'.personel_details($invoices->eid).'"><i class="fa fa-user"></i></a>';


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
    public function faktorinq_action()
    {

        if (!$this->aauth->premission(18)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $transok = true;
            $this->db->trans_start();
            $tutar = $this->input->post('tutar'); // total
            $verilme_tarihi = $this->input->post('verilme_tarihi');
            $bitme_tarihi = $this->input->post('bitme_tarihi');
            $tec_alici = $this->input->post('tec_alici');
            $muqavile_no = $this->input->post('muqavile_no');
            $faiz = $this->input->post('faiz');
            $invoice_type_id=37;

            $bill_date = datefordatabase($verilme_tarihi);

            $bill_due_date = datefordatabase($bitme_tarihi);

            $data = array(
                'invoicedate' => $bill_date,
                'invoice_name' => $muqavile_no,
                'invoiceduedate' => $bill_due_date,
                'eid' => $this->aauth->get_user()->id,
                'total' => $tutar,
                'csd' => $tec_alici,
                'invoice_type_id' => $invoice_type_id,
                'loc' =>  $this->session->userdata('set_firma_id'),
                'invoice_type_desc' => invoice_type_id($invoice_type_id),
                'notes' => $faiz

            );

            if ($this->db->insert('geopos_invoices', $data)) {

                $invoice_id = $this->db->insert_id();
                $str="Faktorinq-".$invoice_id;
                $this->db->set('invoice_no', "'$str'", FALSE);
                $this->db->where('id', $invoice_id);
                $this->db->update('geopos_invoices');

                $faturalar = $this->input->post('faturalar');

                $productlist = array();

                $prodindex = 0;

                $itc = 0;



                foreach ($faturalar as $key => $value)
                {
                    $data_item=array
                    (
                        'tid'=>$invoice_id,
                        'pid'=>$value,
                        'invoice_type_id'=>$invoice_type_id,
                        'invoice_type_desc' => invoice_type_id($invoice_type_id)
                    );
                    $productlist[$prodindex] = $data_item;
                    $prodindex++;
                }

                if ($prodindex > 0) {

                    $this->db->insert_batch('geopos_invoice_items', $productlist);

                } else {

                    echo json_encode(array('status' => 'Error', 'message' =>

                        "Lütfen Fatura Listesinden Fatura Seçin."));

                    $transok = false;

                }

                if ($transok) {

                    echo json_encode(array('status' => 'Success', 'message' =>'Faktorinq Başarıyla Oluşturulmuştur.'));

                }

            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "Invalid Entry!"));

                $transok = false;

            }





            if ($transok) {


                $this->db->trans_complete();

            } else {

                $this->db->trans_rollback();

            }
        }



    }
    public function faktorinq_edit_action()
    {
        if (!$this->aauth->premission(18)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $transok = true;
            $this->db->trans_start();


            $invoice_id = $this->input->post('fak_id'); // total
            $tutar = $this->input->post('tutar'); // total
            $verilme_tarihi = $this->input->post('verilme_tarihi');
            $bitme_tarihi = $this->input->post('bitme_tarihi');
            $tec_alici = $this->input->post('tec_alici');
            $muqavile_no = $this->input->post('muqavile_no');
            $faiz = $this->input->post('faiz');
            $invoice_type_id=37;

            $bill_date = datefordatabase($verilme_tarihi);

            $bill_due_date = datefordatabase($bitme_tarihi);

            $data = array(
                'invoicedate' => $bill_date,
                'invoice_name' => $muqavile_no,
                'invoiceduedate' => $bill_due_date,
                'eid' => $this->aauth->get_user()->id,
                'total' => $tutar,
                'csd' => $tec_alici,
                'invoice_type_id' => $invoice_type_id,
                'loc' =>  $this->session->userdata('set_firma_id'),
                'invoice_type_desc' => invoice_type_id($invoice_type_id),
                'notes' => $faiz

            );

            $this->db->set($data);

            $this->db->where('id', $invoice_id);
            if ($this->db->update('geopos_invoices', $data)) {

                $this->db->delete('geopos_invoice_items', array('tid' => $invoice_id));

                $faturalar = $this->input->post('faturalar');

                $productlist = array();

                $prodindex = 0;

                $itc = 0;

                foreach ($faturalar as $key => $value)
                {
                    $data_item=array
                    (
                        'tid'=>$invoice_id,
                        'pid'=>$value,
                        'invoice_type_id'=>$invoice_type_id,
                        'invoice_type_desc' => invoice_type_id($invoice_type_id)
                    );
                    $productlist[$prodindex] = $data_item;
                    $prodindex++;
                }

                if ($prodindex > 0) {

                    $this->db->insert_batch('geopos_invoice_items', $productlist);

                } else {

                    echo json_encode(array('status' => 'Error', 'message' =>

                        "Lütfen Fatura Listesinden Fatura Seçin."));

                    $transok = false;

                }

                if ($transok) {

                    echo json_encode(array('status' => 'Success', 'message' =>'Faktorinq Başarıyla Oluşturulmuştur.'));

                }

            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "Invalid Entry!"));

                $transok = false;

            }





            if ($transok) {


                $this->db->trans_complete();

            } else {

                $this->db->trans_rollback();

            }

        }



    }

    public function view()
    {
        if (!$this->aauth->premission(18)->read) {

            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        $tid = $this->input->get('id');

        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);

        $data['products'] = $this->invocies->invoice_products($tid);

        $head['title'] = "Faktorinq " . $data['invoice']['invoice_no'];

        $this->load->view('fixed/header', $head);
        $this->load->view('faktorinq/view', $data);
        $this->load->view('fixed/footer');
    }
}