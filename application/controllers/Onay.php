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

class Onay Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('malzemetalep_model', 'talep');
        $this->load->model('Carigidertalepnew_model', 'model_cari_gider');
        $this->load->model('Customeravanstalep_model', 'model_cari_avans');
        $this->load->model('Personelgidertalep_model', 'model_personel_gider');
        $this->load->model('Nakliye_model', 'model_nakliye');
        $this->load->model('onay_model', 'onay');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

    }
    public function projemalzemelist(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen Proje Smeta (Malzeme) Listesi';
        $data['title'] = 'Onay Bekleyen Proje Smeta (Malzeme) Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=1;
        $this->load->view('onay/projemalzemelist',$data);
        $this->load->view('fixed/footer');

    }

    public function onay_qaime_list(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen Qaime Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=1;
        $this->load->view('onay/onay_qaime_list',$data);
        $this->load->view('fixed/footer');

    }
    public function nakliye_mt_talep(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Lojistik İçin Mt Talebi';
        $this->load->view('fixed/header', $head);
        $this->load->view('onay/nakliye_mt_talep');
        $this->load->view('fixed/footer');

    }
    public function podradci_borclandirma(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Podradci / Personel Borçlandırma Talepleri';
        $this->load->view('fixed/header', $head);
        $this->load->view('onay/podradci_borclandirma');
        $this->load->view('fixed/footer');

    }

    public function ajax_podradci_borclandirma(){
        $result = $this->onay->ajax_podradci_borclandirma();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }

    }

    public function malzemetaleplist(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen Malzeme Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=1;
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }

    public function hizmet_talep_form(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen Hizmet Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=106;
        $this->load->view('onay/hizmet_talep_form',$data);
        $this->load->view('fixed/footer');

    }

    public function stok_kontrol_list(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Kontrol Bekleyen Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=104;
        $this->load->view('onay/stok_kontrol_list',$data);
        $this->load->view('fixed/footer');

    }
    public function stok_kontrol_list_hizmet(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Kontrol Bekleyen Hizmet Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=105;
        $this->load->view('onay/stok_kontrol_list_hizmet',$data);
        $this->load->view('fixed/footer');

    }


    public function nakliyeteklifbekleyen(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Teklif Bekleyen Nakliyeler';
        $this->load->view('fixed/header', $head);
        $data['type']=1;
        $this->load->view('onay/nakliyeteklifbekleyen',$data);
        $this->load->view('fixed/footer');

    }

    public function caricezatalep(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Cari Ceza Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=3;
        $this->load->view('onay/caricezatalep',$data);
        $this->load->view('fixed/footer');

    }
    public function warehouse_transfer(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen Mahsul Transfer Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=1;
        $this->load->view('onay/warehouse_transfer',$data);
        $this->load->view('fixed/footer');

    }
    public function transferlist(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Transfer Talepleri';
        $this->load->view('fixed/header', $head);
        $data['type']=103;
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }

    public function bekleyentask(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Bekleyen Görevler';
        $this->load->view('fixed/header', $head);
        $data['tip']=1; // Bekleyen
        $data['personel_id']= $this->aauth->get_user()->id;
        $this->load->view('onay/personeltask',$data);
        $this->load->view('fixed/footer');

    }
    public function talep_warehouse_transfer(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen Mahsul Transfer Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=1;
        $this->load->view('onay/talep_warehouse_transfer',$data);
        $this->load->view('fixed/footer');

    }

    public function bekleyen_sened_list(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Senedleri Tamamlanmamış Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=7;
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }
  public function bekleyen_sened_list_hizmet(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Senedleri Tamamlanmamış Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=111;
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }

    public function ihalelist(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen İhale Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=3;
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }

    public function ihalelist_hizmet(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen İhale Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=108;
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }

    public function tekliflist(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Teklif Sürecinde Olan Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=102;
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }
    public function tehvillist(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen İhale Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=8;
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }
    public function tehvillist_hizmet(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen İhale Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=112;
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }

    public function odeme_bekleyen_talepler(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Ödeme Bekleyen Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=11;
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }
    public function avanslist(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Ödeme Bekleyen Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=99; // avans kontrolü
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }
    public function odemelist(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Ödeme Bekleyen Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=100; // ödeme kontrolü
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }

    public function odemeemrilist(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Ödeme Emri Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=101; // ödeme kontrolü
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }

    public function qaimelist(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Bekleyen Qaime Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=9;
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }

    public function hizmetqaimelist(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Bekleyen Qaime Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=113;
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }

    public function siparslist(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen İhale Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=5;
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }

    public function siparslist_hizmet(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen İhale Talep Listesi';
        $this->load->view('fixed/header', $head);
        $data['type']=109;
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }

    public function siparisfinishlist(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen Son Sipariş Talepleri';
        $this->load->view('fixed/header', $head);
        $data['type']=6;
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }

    public function siparisfinishlist_hizmet(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen Son Sipariş Talepleri';
        $this->load->view('fixed/header', $head);
        $data['type']=110;
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }

    public function caribekleyen(){

        if (!$this->aauth->premission(53)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen Cari Talepleri ';
        $this->load->view('fixed/header', $head);
        $data['type']=$this->input->get('tip');
        $data['status']=$this->input->get('status');
        $this->load->view('onay/caribekleyen',$data);
        $this->load->view('fixed/footer');

    }

    public function carilojistik(){

        if (!$this->aauth->premission(53)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen Cari Talepleri ';
        $this->load->view('fixed/header', $head);
        $data['type']=$this->input->get('tip');
        $data['status']=$this->input->get('status');
        $this->load->view('onay/carilojistik',$data);
        $this->load->view('fixed/footer');

    }
    public function personelbekleyen(){

        if (!$this->aauth->premission(52)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen Personel Talepleri ';
        $this->load->view('fixed/header', $head);
        $data['type']=$this->input->get('tip');
        $data['status']=$this->input->get('status');
        $this->load->view('onay/personelbekleyen',$data);
        $this->load->view('fixed/footer');

    }

    public function personel_satinalma_list(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen Atanmış M. Talep Listesi';
        $data['type']=2;
        $this->load->view('fixed/header', $head);
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }
    public function personel_satinalma_list_hizmet(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Onay Bekleyen Atanmış M. Talep Listesi';
        $data['type']=107;
        $this->load->view('fixed/header', $head);
        $this->load->view('onay/malzemetaleplist',$data);
        $this->load->view('fixed/footer');

    }

    public function giderhizmetbekleyen(){

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Cari Gider Talebi Tamamlanmamış Hizmetler';
        $this->load->view('fixed/header', $head);
        $data['type']=2;
        $this->load->view('onay/giderhizmetbekleyen',$data);
        $this->load->view('fixed/footer');

    }
    public function mtgidercreate(){

        $data['items']=$this->db->query("SELECT talep_form.id,talep_form.code  FROM siparis_list_form_new
                 INNER JOIN talep_form_products On siparis_list_form_new.talep_form_product_id = talep_form_products.id
                 INNER JOIN geopos_products ON talep_form_products.product_id =geopos_products.pid
                 INNER JOIN talep_form ON talep_form_products.form_id =talep_form.id
WHERE  talep_form_products.gider_durumu=0 and  talep_form.gider_durumu=1 group by talep_form.id")->result();

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Gidere İşlenmesi Bekleyen Ürünler';
        $this->load->view('fixed/header', $head);
        $data['type']=2;
        $this->load->view('onay/mtgidercreate',$data);
        $this->load->view('fixed/footer');

    }

    public function bekleyen_qaime_list(){
        $list = $this->onay->bekleyen_qaime_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $view = "<a class='btn btn-success view' href='/invoices/view?id=$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = invoice_type_desc($prd->invoice_type_id);
            $row[] = $prd->proje_name;
            $row[] = $prd->company;
            $row[] = amountFormat($prd->subtotal);
            $row[] = amountFormat($prd->tax);
            $row[] = amountFormat($prd->total);
            $row[] =$view;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->onay->count_all_qaime(),
            "recordsFiltered" => $this->onay->count_filtered_qaime(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function malzemetalep_ajax_list(){
        $list = $this->onay->get_datatables_query_details_talep_list();
        $data = array();
        $no = $this->input->post('start');
        $tip = $this->input->get('tip');


        $href = "malzemetalep";
        $talep_type_hizmet = [105,106,107,108,109,110,111,112,113];

        if(in_array($tip,$talep_type_hizmet)){
            $href="hizmet";
        }

        foreach ($list as $prd) {
            $view = "<a class='btn btn-success view' href='/$href/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";
            if($tip==105){
                $view = "<a class='btn btn-success view' href='/$href/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";
            }
            $no++;
            $row = array();
            $row[] = $prd->code;
            $row[] = $prd->progress_name;
            $row[] = $prd->created_at;
            $row[] = $prd->pers_name;
            $row[] = $prd->proje_name;
            $row[] = "<span class='badge text-status' style='background-color: $prd->color'>$prd->st_name</span>";
            $row[] =$view;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->onay->count_all_talep(),
            "recordsFiltered" => $this->onay->count_filtered_talep(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function proje_stoklari_bekleyen_ajax_list(){

        $list = $this->onay->proje_stoklari_bekleyen_ajax_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $proje_name =  '<span class="txt-color-darken no-padding proje_name_string" data-popup="popover" title="" data-trigger="hover" data-content="'.$prd->name.'" data-original-title="Proje Adı"><b>'.$prd->code.'</b>
</span>
';
            $product_name =$prd->product_name.'<br>'.varyasyon_string_name($prd->option_id,$prd->option_value_id);
            $islem='';
            $no++;
            $check ="<input type='checkbox' method_id='$prd->method' file_id='$prd->id' class='form-control one_select'  style='width: 30px;'>";;
            $row = array();
            $row[] = $check;
            $row[] = $no;
            $row[] = $proje_name;
            $row[] = $prd->bolum_name;
            $row[] = $prd->asama_name;
            $row[] = $product_name;
            $row[] =$islem;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->onay->count_all_proje_stoklari_bekleyen(),
            "recordsFiltered" => $this->onay->count_filtered_proje_stoklari_bekleyen(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function cari_gider_ajax_list(){
        $list = $this->onay->get_datatables_query_details_cari_gider_list();
        $list2= $this->onay->get_datatables_query_details_cari_gider_list2();

        $lists = array_merge($list,$list2);
        $data = array();
        $no = $this->input->post('start');
        foreach ($lists as $prd) {

            $toplam_tutar=0;
            if($prd->href=='carigidertalep'){
                foreach ($this->model_cari_gider->product_details2($prd->id) as $details){
                    $toplam_tutar+=$details->total;
                }
            }
            else {
                foreach ($this->model_cari_gider->product_details($prd->id) as $details){
                    $toplam_tutar+=$details->total;
                }
            }


            $view = "<a class='btn btn-success view' href='/$prd->href/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";


            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='form-control one_select'  price='$toplam_tutar' id='$prd->id' style='width: 30px;'>";
            $row[] = $no;
            $row[] = $prd->company;
            $row[] = $prd->code;
            $row[] = $prd->proje_name;
            $row[] = account_type_sorgu($prd->method);
            $row[] = amountFormat($toplam_tutar);
            $row[] =$view;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->onay->count_all_carigider(),
            "recordsFiltered" => $this->onay->count_filtered_carigider(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function cari_gider_ajax_list_yeni(){
        $list = $this->onay->get_datatables_query_details_cari_gider_list_yeni();


        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $toplam_tutar=0;
            if($prd->href=='carigidertalep'){
                foreach ($this->model_cari_gider->product_details2($prd->id) as $details){
                    $toplam_tutar+=$details->total;
                }
            }
            else {
                foreach ($this->model_cari_gider->product_details($prd->id) as $details){
                    $toplam_tutar+=$details->total;
                }
            }


            $view = "<a class='btn btn-success view' href='/$prd->href/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";


            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='form-control one_select'  price='$toplam_tutar' id='$prd->id' style='width: 30px;'>";
            $row[] = $no;
            $row[] = $prd->company;
            $row[] = $prd->code;
            $row[] = $prd->proje_name;
            $row[] = account_type_sorgu($prd->method);
            $row[] = amountFormat($toplam_tutar);
            $row[] =$view;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->onay->count_all_carigider_yeni(),
            "recordsFiltered" => $this->onay->count_filtered_carigider_yeni(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function cari_avans_ajax_list(){
        $list = $this->onay->get_datatables_query_details_cari_avans_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $toplam_tutar=0;
            foreach ($this->model_cari_avans->product_details($prd->id) as $details){
                $toplam_tutar+=$details->total;
            }

            $view = "<a class='btn btn-success view' href='/customeravanstalep/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";


            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='form-control one_select'  price='$toplam_tutar' id='$prd->id' style='width: 30px;'>";
            $row[] = $no;
            $row[] = $prd->company;
            $row[] = $prd->code;
            $row[] = $prd->proje_name;
            $row[] = account_type_sorgu($prd->method);
            $row[] = amountFormat($toplam_tutar);
            $row[] =$view;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->onay->count_all_cariavans(),
            "recordsFiltered" => $this->onay->count_filtered_cariavans(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function cari_lojistik_ajax_list(){
        $list = $this->onay->lojistik_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {



            //$view = "<a class='btn btn-success view' href='/customeravanstalep/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";

            $style=nakliye_item_tip_who($prd->nakliye_item_tip,$prd->id)['style'];
            $messages=nakliye_item_tip_who($prd->nakliye_item_tip,$prd->id)['messages'];
            $names=nakliye_item_tip_who($prd->nakliye_item_tip,$prd->id)['name'];
            $tips='
            <span style="'.$style.'" class="txt-color-darken no-padding"
             data-html="true" data-popup="popover"  data-trigger="hover" 
             data-content="'.$messages.'" data-original-title="Talep Tipi"><b>'.$names.'</b></span>';

            $url = site_url().'nakliye/view/'.$prd->id;
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='form-control one_select'  price='$prd->total' id='$prd->id' style='width: 30px;'>";
            $row[] = $no;
            $row[] = $prd->company;
            $row[] = $prd->arac_name;
            $row[] = $prd->lokasyon;
            $row[] = $tips;
            $row[] =  nakliye_tip_details($prd->nakliye_item_tip,$prd->id);
            //$row[] ="<button url='$url'  class='btn btn-outline-info talep_view'>$prd->code</button>";
            $row[] ="<a href='/nakliye/view/$prd->talep_id' target='popup' class='btn btn-outline-info'>$prd->code</a>";
            $row[] = $prd->proje_name;
            $row[] = account_type_sorgu($prd->method);
            $row[] = amountFormat($prd->total);
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->onay->count_all_lojistik_list(),
            "recordsFiltered" => $this->onay->count_filtered_lojistik_list(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function cari_avans_ajax_list_dash(){
        $list = $this->onay->get_datatables_query_details_cari_avans_list_dash();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $toplam_tutar=0;
            foreach ($this->model_cari_avans->product_details($prd->id) as $details){
                $toplam_tutar+=$details->total;
            }

            $view = "<a class='btn btn-success view' href='/customeravanstalep/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";


            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='form-control one_select'  price='$toplam_tutar' id='$prd->id' style='width: 30px;'>";
            $row[] = $no;
            $row[] = $prd->company;
            $row[] = $prd->code;
            $row[] = $prd->proje_name;
            $row[] = account_type_sorgu($prd->method);
            $row[] = amountFormat($toplam_tutar);
            $row[] =$view;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->onay->count_all_cariavans_dash(),
            "recordsFiltered" => $this->onay->count_filtered_cariavans_dash(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function personel_gider_ajax_list(){
        $list = $this->onay->get_datatables_query_details_personel_gider_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $toplam_tutar=0;
            foreach ($this->model_personel_gider->product_details($prd->id) as $details){
                $toplam_tutar+=$details->total;
            }


            $view = "<a class='btn btn-success view' href='/personelgidertalep/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";


            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='form-control one_select'  price='$toplam_tutar' id='$prd->id' style='width: 30px;'>";
            $row[] = $no;
            $row[] = $prd->pers_name;
            $row[] = $prd->code;
            $row[] = $prd->proje_name;
            $row[] = account_type_sorgu($prd->method);
            $row[] =amountFormat($toplam_tutar);
            $row[] =$view;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->onay->count_all_personelgider(),
            "recordsFiltered" => $this->onay->count_filtered_personelgider(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function personel_avans_ajax_list(){
        $list = $this->onay->get_datatables_query_details_personel_avans_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $toplam_tutar=0;
            foreach ($this->model_personel_gider->product_details($prd->id) as $details){
                $toplam_tutar+=$details->total;
            }


            $view = "<a class='btn btn-success view' href='/personelavanstalep/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";


            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='form-control one_select'  price='$toplam_tutar' id='$prd->id' style='width: 30px;'>";
            $row[] = $no;
            $row[] = $prd->pers_name;
            $row[] = $prd->code;
            $row[] = $prd->proje_name;
            $row[] = account_type_sorgu($prd->method);
            $row[] =amountFormat($toplam_tutar);
            $row[] =$view;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->onay->count_all_personelavans(),
            "recordsFiltered" => $this->onay->count_filtered_personelavans(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function all_payment_cari(){
        $this->db->trans_start();
        $index=0;
        $details = $this->input->post('product_details');
        $tip = $this->input->post('tip');
        foreach ($details as $items){
            $talep_id = $items['talep_id'];
            $pay_personel_id = $items['pay_personel_id'];

            $personel_name = personel_details_full($pay_personel_id)['name'];
            if($tip==3){  // avans talebi
            $data = array(
                'payment_personel_id' => $pay_personel_id,
                'status' => 12,
            );

            $this->db->where('id',$talep_id);
            $this->db->set($data);
                $this->db->update('talep_form_customer', $data);
                $index++;

                $this->model_cari_avans->talep_history($talep_id, $this->aauth->get_user()->id, ' Talep Güncellendi. Ödeme Emri Verildi : ' . $personel_name);

            }
            elseif($tip==2) //
            {
                $data = array(
                    'payment_personel_id' => $pay_personel_id,
                    'status' => 12,
                );

                $this->db->where('id',$talep_id);
                $this->db->set($data);
                $this->db->update('talep_form_customer_new', $data);
                $index++;

                $this->model_cari_gider->talep_history($talep_id, $this->aauth->get_user()->id, ' Talep Güncellendi. Ödeme Emri Verildi : ' . $personel_name);

            }
//            else {
//                $this->model_personel_gider->talep_history($talep_id, $this->aauth->get_user()->id, ' Talep Güncellendi. Ödeme Emri Verildi : ' . $personel_name);
//
//                $data = array(
//                    'payment_personel_id' => $pay_personel_id,
//                    'status' => 12,
//                );
//
//                $this->db->where('id',$talep_id);
//                $this->db->set($data);
//                $this->db->update('talep_form_personel', $data);
//                $index++;
//            }

        }
        if($index)
        {
            $this->db->trans_complete();
            echo json_encode(array('status' => 200, 'message' => $index.' Adet Talep Başarıyla Atandı'));
        }
        else
        {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => "Hata Aldınız. Yöneticiye Başvurun"));
        }

    }

    public function all_payment_cari_lojistik(){
        $this->db->trans_start();
        $index=0;
        $details = $this->input->post('product_details');
        $tip = $this->input->post('tip');
        foreach ($details as $items){
            $talep_item_id = $items['talep_item_id'];
            $pay_personel_id = $items['pay_personel_id'];

            $personel_name = personel_details_full($pay_personel_id)['name'];

            $data = array(
                'payment_personel_id' => $pay_personel_id,
                'status' => 12,
            );

            $this->db->where('id',$talep_item_id);
            $this->db->set($data);
            $this->db->update('talep_form_nakliye_products', $data);
            $index++;

            $talep_details = $this->db->query("SELECT talep_form_nakliye.*,talep_form_nakliye_products.form_id,talep_form_nakliye_products.arac_id,talep_form_nakliye_products.lokasyon,talep_form_nakliye_products.cari_id FROM talep_form_nakliye_products INNER JOIN talep_form_nakliye ON talep_form_nakliye_products.form_id = talep_form_nakliye.id  Where talep_form_nakliye_products.id=$talep_item_id")->row();
            $lokasyon=$talep_details->lokasyon;
            $arac_name=arac_details($talep_details->arac_id)->name;
            $cari_name=customer_details($talep_details->cari_id)['company'];
            $messages = $cari_name.' Ait '.$arac_name.' ile gidilen '.$lokasyon.' Lokasyon İçin Ödeme Emri Verildi';
            $this->model_nakliye->talep_history($talep_details->form_id, $this->aauth->get_user()->id, $messages.' : ' . $personel_name);

        }
        if($index)
        {
            $this->db->trans_complete();
            echo json_encode(array('status' => 200, 'message' => $index.' Adet Talep Başarıyla Atandı'));
        }
        else
        {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => "Hata Aldınız. Yöneticiye Başvurun"));
        }

    }

    public function invoices_talep_onay_report(){
        $list = $this->onay->invoices_talep_onay_report();
        $data = array();
        $no = $this->input->post('start');
        $page = $this->input->post('page');
        $pers_get_id = $this->input->post('pers_id');
        $say =0;


        foreach ($list as $prd) {



            $view='';
            $talep_tipi='';
            $durum='';
            $staff_personel='';
            $staff_id=0;

            $view = "<a class='btn btn-success view' href='/malzemetalep/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";
            $talep_tipi='MT';
            $durum=talep_form_status_details($prd->status)->name;
            $staff_personel=mt_onay_pers($prd->id,$prd->status)['personel_name'];
            $staff_id=mt_onay_pers($prd->id,$prd->status)['pers_id'];
            $bildirim='<button type="button" class="btn btn-danger talep_bildirimi_gonder"  code="'.$prd->code.'"   pers_id="'.$staff_id.'" talep_type="mt_talep"><i class="fa fa-envelope"></i></button>';

            $html='-';
            $detaylar = onaylanan_firma_list($prd->id);

            if($detaylar){
                $html = "<table>
                <thead>
                <tr>
                <th>Cari</th>
                <th>Toplam</th>
                </tr>
                </thead>
                <tbody>
                ";

                foreach ($detaylar as $detaylar_items){
                    $totals=0;
                    $sql = $this->db->query("select * from talep_form_teklifler Where form_id=$prd->id and cari_id =$detaylar_items->cari_id")->row();
                    if($sql){
                        $totals = $sql->total;
                    }
                    $cari_name = customer_details($detaylar_items->cari_id)['company'];
                    $total = $totals;
                    $cemi = amountFormat($total);
                    $html.="<tr>";
                    $html.="<th>".$cari_name."</th>";
                    $html.="<th>".$cemi."</th>";
                    $html.="<tr>";
                }


                $html.="</tbody>";
                $html.="</table>";
            }


            if($page=='personel'){
                if($staff_id==$pers_get_id){
                    $no++;
                    $row = array();
                    $row[] = $no;

                    $row[] = proje_name($prd->proje_id);
                    $row[] = $prd->code;
                    $row[] = $staff_personel;
                    $row[] =$durum;
                    $row[] =$html;
                    $row[] =$view.' '.$bildirim;
                    $data[] = $row;
                    $say++;
                }
            }
            else {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = proje_name($prd->proje_id);
                $row[] = $prd->code;
                $row[] = $staff_personel;
                $row[] =$durum;
                $row[] =$html;
                $row[] =$view.' '.$bildirim;
                $data[] = $row;
            }



        }


        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->onay->count_all_talep_report(),
            "recordsFiltered" => $this->onay->count_filtered_talep_report(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function invoices_cari_onay_report(){
        $list = $this->onay->invoices_cari_onay_report();
        $data = array();
        $no = $this->input->post('start');
        $tip = $this->input->post('tip');
        $page = $this->input->post('page');
        $pers_get_id = $this->input->post('pers_id');


        foreach ($list as $prd) {



            $bildirim='';
            if($tip==1){
                $view = "<a class='btn btn-success view' href='/carigidertalepnew/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";
                $talep_tipi='GT';
                $durum=talep_form_status_details($prd->status)->name;
                $staff_personel=gt_onay_pers($prd->id,$prd->status,$tip)['personel_name'];
                $staff_id=gt_onay_pers($prd->id,$prd->status,$tip)['pers_id'];
                $bildirim='<button type="button" class="btn btn-danger talep_bildirimi_gonder" code="'.$prd->code.'" pers_id="'.$staff_id.'" talep_type="cari_gider"><i class="fa fa-envelope"></i></button>';



            }
            else {
                $view = "<a class='btn btn-success view' href='/customeravanstalep/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";
                $talep_tipi='AT';
                $durum=talep_form_status_details($prd->status)->name;
                $staff_personel=gt_onay_pers($prd->id,$prd->status,$tip)['personel_name'];
                $staff_id=gt_onay_pers($prd->id,$prd->status,$tip)['pers_id'];
                $bildirim='<button type="button" class="btn btn-danger talep_bildirimi_gonder"  code="'.$prd->code.'"  pers_id="'.$staff_id.'" talep_type="cari_avans"><i class="fa fa-envelope"></i></button>';

            }





            if($page=='personel'){
                if($staff_id==$pers_get_id){
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = proje_name($prd->proje_id);
                    $row[] = $prd->code;
                    $row[] = $staff_personel;
                    $row[] =$durum;
                    $row[] =$view.' '.$bildirim;
                    $data[] = $row;
                }
            }
            else{
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = proje_name($prd->proje_id);
                $row[] = $prd->code;
                $row[] = $staff_personel;
                $row[] =$durum;
                $row[] =$view.' '.$bildirim;
                $data[] = $row;
            }



        }

        //$this->session->userdata('cari_talep_pers');
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->onay->count_all_cari_gider_talep_report(),
            "recordsFiltered" => $this->onay->count_filtered_cari_gider_talep_report(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function atama_gider_talep()
    {

        $result = $this->onay->atama_gider_talep();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }

    }

    public function atama_cari_avans_talep()
    {
        $result = $this->onay->atama_cari_avans_talep();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }

    }
    public function atama_nakliye_talep()
    {
        $result = $this->onay->atama_nakliye_talep();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }

    }


    public function atama_personel_avans_talep()
    {
        $result = $this->onay->atama_personel_avans_talep();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }

    }

    public function atama_personel_gider_talep()
    {
        $result = $this->onay->atama_personel_gider_talep();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }

    }






}
