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



class Projestoklari Extends CI_Controller

{
    public function __construct()

    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('projestoklari_model', 'stok');
        $this->load->model('tools_model', 'tools');
        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }

    }

    public function ajax_list()
    {

        $pid = $this->input->post('pid');
        $list = $this->stok->datatables($pid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $items) {

            $asama_adi='Aşama Seçiniz';
            if(isset($items->asama_adi)){
                $asama_adi = $items->asama_adi;
            }
            $birim_qty = $items->qty.' '.units_($items->unit_id)['name'];
            //$varyasyon_name = varyasyon_string_name($items->option_id,$items->option_value_id,$items->product_id);
            $varyasyon_name='';
            if($items->product_stock_code_id){
                $stock_code=$this->db->query("SELECT * FROM product_stock_code Where id=$items->product_stock_code_id");
                if($stock_code->num_rows()){
                    $varyasyon_name = $stock_code->row()->code;
                }
            }

            $price_text = amountFormat($items->unit_price);
            $no++;
            $edit = "<button stok_id='$items->id' class='btn btn-danger delete-stok' durum='1'><i class='fa fa-trash'></i></button>&nbsp;";


            $plus = "<button stok_id='$items->id' class='btn btn-success talep-plus' durum='1'><i class='fa fa-plus'></i>&nbsp;</button>";

            $talep_list_kontrol = talep_list_kontrol($items->id,$this->aauth->get_user()->id);
            if($talep_list_kontrol){
                $plus = "<button stok_id='$items->id' class='btn btn-danger talep-plus' durum='1'><i class='fa fa-ban'></i>&nbsp;</button>";

            }


            $tamamlayici='';
            if(product_full_details($items->product_id)['product_type']==9){
                $tamamlayici="<button class='btn btn-info parent_product' proje_stoklari_id='$items->id'>İncele</button>";
            }



            $style='';
            $product_onay_kontrol=product_onay_kontrol($items->product_id);
            if(!$product_onay_kontrol){
                $style = "background-color: #ff7900;color: white;";
            }


            $group_button_view = "<button class='btn btn-edit table_line_update' tip='table_product_stock_code_update' stok_id='$items->id' title='Gruplu Ürün'>$varyasyon_name</button>&nbsp;";

            $asama_new_name = task_to_asama_parent($items->asama_id);
            $row = array();
            $row[] = "<input type='checkbox' class='form-control one_select_mt_list'stok_id='$items->id' >";
            $row[] = $no;
            $row[] = "<button class='btn btn-edit table_line_update' tip='table_bolum_update' stok_id='$items->id' bolum_id='$items->bolum_id'>$items->bolum_adi</button>";
            $row[] = "<button class='btn btn-edit table_line_update' tip='table_asama_update'  stok_id='$items->id' asama_id='$items->asama_id'> $asama_new_name</button>";
            $row[] = "<button class='btn btn-edit table_line_update' tip='table_product_update'  stok_id='$items->id' product_id='$items->product_id'>$items->product_name</button>";
            $row[] = '';
            $row[] = $group_button_view;
            $row[] = $tamamlayici;
            $row[] = "<button class='btn btn-edit table_line_update' tip='table_qty_update'  stok_id='$items->id' qty='$items->qty' unit_id='$items->unit_id'>$birim_qty</button>";
            $row[] = "<button class='btn btn-edit table_line_update' tip='table_price_update'  stok_id='$items->id' price='$items->unit_price' >$price_text</button>";
            $row[] = $items->tip_name;
            $row[] = $edit.$plus;
            $row[] = $style;
            $data[] = $row;

        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->stok->count_all($pid),
            "recordsFiltered" => $this->stok->count_filtered($pid),
            "data" => $data,

        );

        echo json_encode($output);
    }

    public function create()
    {
        $this->db->trans_start();
        $result = $this->stok->create();
        if($result['status']){
            echo json_encode(array(
                'status' => 200,
                'message' =>$result['message'],
                'array_items' =>$result['array_items'],

            ));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }

    }


    public function talep_list_create()
    {
        $this->db->trans_start();
        $result = $this->stok->talep_list_create();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }

    }

    public function talep_list_create_toplu()
    {
        $this->db->trans_start();
        $result = $this->stok->talep_list_create_toplu();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }

    }

    public function update(){
        $this->db->trans_start();
        $result = $this->stok->update();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        elseif($result['status']==0) {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function delete(){
        $this->db->trans_start();
        $result = $this->stok->delete();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function get_info(){
        $bolum_id = $this->input->post('bolum_id');
        $result = $this->stok->details($bolum_id);
        echo json_encode(array('status' => 200, 'item' =>$result));
    }

    public function get_info_update(){
        $stok_id = $this->input->post('stok_id');
        $tip = $this->input->post('tip');
        $result = $this->stok->details_update($stok_id,$tip);

        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['message'],'content'=>$result['content'],'title'=>$result['title']));
        }
        else {
            echo json_encode(array('status' => 410, 'message' =>$result['message'],'content'=>$result['content']));
        }

    }

    public function fislist(){
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Proje Giriş / Çıkış Fiş Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('projestoklari/fislist');
        $this->load->view('fixed/footer');
    }

    public function test(){
        $string='6,2,9';
        $stringParts = explode(',',$string);
        sort($stringParts);
        $stringParts= implode(',',$stringParts);
        echo $stringParts;
    }

    public function ajax_stok_fis_list()
    {
        $list = $this->stok->datatables_stok_fis_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $item) {

//            <button data-id='$item->stock_io_id_new' class='btn btn-warning edit-stockio'><i class='fa fa-edit'></i></button>&nbsp
            $edit = "<button data-id='$item->stock_io_id_new' class='btn btn-danger cancel-stockio'><i class='fa fa-ban'></i></button>&nbsp
          
            <button data-id='$item->stock_io_id_new' class='btn btn-indigo file-stockio'><i class='fa fa-file'></i></button>&nbsp
            <a type='button' href='/stockio/print/?print=$item->stock_io_id_new&whareouse=$item->warehouse_id' TARGET='_blank' class='btn btn-info'><i class='fa fa-print'></i></a>  ";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $item->fis_code;
            $row[] = $item->fis_type_name;
            $row[] = $item->warehouse;
            $row[] =$edit;
            $data[] = $row;

        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->stok->count_all_fis_list(),
            "recordsFiltered" => $this->stok->count_filtered_fis_list(),
            "data" => $data,

        );

        echo json_encode($output);
    }


    public function ajax_stok_fis_list_file()
    {
        $list = $this->stok->datatables_stok_fis_list_file();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $item) {

            $edit = "<button data-id='$item->id' data-stock_io_id='$item->stock_io_id' class='btn btn-danger cancel-stockio-file'><i class='fa fa-ban'></i></button>&nbsp";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $item->file_name;
            $row[] = $item->user_name;
            $row[] = $item->created_at;
            $row[] = "<a type='button' href='/userfiles/product/$item->file' TARGET='_blank' class='btn btn-info'><i class='fa fa-eye'></i></a> ";
            $row[] =$edit;
            $data[] = $row;

        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->stok->count_all_fis_list(),
            "recordsFiltered" => $this->stok->count_filtered_fis_list(),
            "data" => $data,

        );

        echo json_encode($output);
    }
    public function ajax_list_stok_takibi()
    {
        $proje_id =  $this->input->post('pid');
        $depo_id = $proje_details = project_to_depo($proje_id)->id;
        $list = $this->stok->datatables_stok_takibi_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $item) {
            $details=stock_qty_warehouse_str_option_new($item->product_id,$depo_id,$item->product_stock_code_id);
            $giris_qty=0;
            $kullanilan_miktar=0;
            if($item->type==0){
                $kullanilan_miktar = $item->qty.' '.$item->birim_name;
                $giris_qty = '0 '.$item->birim_name;
            }
            else {
                $kullanilan_miktar = '0 '.$item->birim_name;
                $giris_qty = $item->qty.' '.$item->birim_name;
            }

            $sorumlu_personel = personel_details_full($item->pers_id)['name'];
//            if($item->fis_tur==3){
//                $sorumlu_personel = customer_details($item->pers_id)['company'];
//            }

            if($item->cari_pers_type==1){
                $sorumlu_personel = customer_details($item->pers_id)['company'];
            }
            $new_qty='';
            if(isset($details['qty'])){
                $new_qty=$details['qty'].' '.$details['unit_name'];
            }


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $item->product_name."<p>".varyasyon_string_name_new($item->product_stock_code_id)."</p>";
            $row[] = $new_qty;
            $row[] = $kullanilan_miktar;
//            $row[] = $giris_qty;
            $row[] = $item->bolum_name;
            $row[] = $item->asama_name;
            $row[] = $sorumlu_personel;
            $row[] = personel_details_full($item->aauth_id)['name'];
            $row[] = $item->code;
            $row[] = $item->created_at;
            $row[] = $item->description;
            $data[] = $row;

        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->stok->count_all_stok_takibi_list(),
            "recordsFiltered" => $this->stok->count_filtered_stok_takibi_list(),
            "data" => $data,

        );

        echo json_encode($output);
    }

    public function ajax_list_depo_takibi()
    {
        $proje_id =  $this->input->post('pid');
        $depo_id = $proje_details = project_to_depo($proje_id)->id;
        $list = $this->stok->datatables_depo_takibi_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $item) {


            $tamamlayici_urun='';
            if($item->proje_stoklari_id){
                $tamamlayici_urun_details=$this->db->query("SELECT * FROM proje_stoklari WHERE id=$item->proje_stoklari_id");
                if($tamamlayici_urun_details->num_rows()){
                    $tamamlayici_urun=product_name($tamamlayici_urun_details->row()->product_id);
                }
            }
            $sorumlu_personel = personel_details_full($item->aauth_id)['name'];
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $item->product_name."<p>".varyasyon_string_name($item->option_id,$item->option_value_id)."</p>";
            $row[]=$tamamlayici_urun;
            $row[] = $item->kalan.' '.$item->birim;
            $row[] = personel_details_full($item->aauth_id)['name'];
            $row[] = $item->created_at.'&nbsp<a href="/malzemetalep/view/'.$item->mt_id.'" class="btn btn-info">MT</a>';
            $data[] = $row;

        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->stok->count_all_depo_takibi_list(),
            "recordsFiltered" => $this->stok->count_filtered_depo_takibi_list(),
            "data" => $data,

        );

        echo json_encode($output);
    }

    public function get_proje_bolum_asama(){
        $proje_id = $this->input->post('proje_id');
        $html = proje_to_bolum_html($proje_id);
        if($html['status']){
            echo json_encode(array('code' => 200, 'html' =>$html['html'] ));
        }
        else {
            echo json_encode(array('code' => 410, 'html' =>'<h3>Herhangi Bir Bölüm Bulunamadı</h3>' ));
        }
    }

    public function get_proje_bolum_to_asama(){
        $bolum_id = $this->input->post('bolum_id');
        $html = bolum_to_asama_html($bolum_id);
        if($html['status']){
            echo json_encode(array('code' => 200, 'html' =>$html['html'] ));
        }
        else {
            echo json_encode(array('code' => 410, 'html' =>'<h3 class="asama_div">Herhangi Bir Aşama Bulunamadı</h3>' ));
        }
    }

    public function getall_products(){
        echo json_encode(all_products_like_warehouse($this->input->post('tip'),$this->input->post('search'),$this->input->post('warehouse_id')));
    }


    public function info_stock_details(){
        $stok_id = $this->input->post('stok_id');
        $new_tip = $this->input->post('new_tip');
        $new_warehouse = $this->input->post('new_warehouse');
        $new_personel_id = $this->input->post('new_personel_id');
        $tip_name='Cixis';
        if(intval($new_tip)==1){
            $tip_name='Giriş';
        }
        $result = $this->stok->stokdetails($stok_id);
        $result_items = $this->stok->stokitemdetails($stok_id);
        $item_details = [];
        foreach ($result_items as $items){

            $untis=$this->db->query("SELECT t.*
            FROM stock t
            WHERE product_id=$items->product_id
            GROUP BY unit");


            $unit_get=[];
            if($untis->num_rows()){
                foreach ($untis->result() as $items_value){
                    $unit_get[]=[
                        'id'=>$items_value->unit,
                        'name'=>units_($items_value->unit)['name']
                    ];
                }
            }
            else {
                foreach (units() as $items_value){
                    $unit_get[]=[
                        'id'=>$items_value['id'],
                        'name'=>$items_value['name']
                    ];
                }
            }


            $item_details[] = [
                'tip_name'=>$tip_name,
                'sorumlu_personel'=>personel_details_full($new_personel_id)['name'],
                'anbar'=>warehouse_details($new_warehouse)->title,
                'product_name'=>product_full_details($items->product_id)['product_name'],
                'product_id'=>$items->product_id,
                'option_value_id'=>$items->option_value_id,
                'bolum_id'=>$items->bolum_id,
                'asama_id'=>$items->asama_id,
                'bolum_name'=>bolum_to_asama($items->bolum_id),
                'asama_name'=>task_to_asama($items->asama_id),
                'value_text'=>varyasyon_value_string($items->option_value_id),
                'proje'=>proje_code($items->proje_id),
                'warehouse_qty_details'=>stock_qty_warehouse_str_option($items->product_id,$new_warehouse,$items->option_id,$items->option_value_id),
                'miktar'=>$items->qty,
                'proje_name'=>proje_code($items->proje_id),
                'proje_id'=>$items->proje_id,
                'unit_get'=>$unit_get,
                'unit_id'=>$items->unit_id,
                'desc'=>$items->description,
            ];
        }


        echo json_encode(array(
            'tip_name'=>$tip_name,
            'warehouse_name'=>warehouse_details($new_warehouse)->title,
            'personel_name'=>personel_details_full($new_personel_id)['name'],
            'item_details'=>$item_details
        ));
    }

    public function add_product_details(){
        $bolum_id = $this->input->post('bolum_id');
        $asama_id = $this->input->post('asama_id');
        $product_id = $this->input->post('product_id');
        $tip = $this->input->post('tip');
        $warehouse_id = $this->input->post('warehouse_id');
        $proje_id = $this->input->post('proje_id');
        $personel_id = $this->input->post('personel_id');
        $cari_pers_type = $this->input->post('cari_pers_type');
        $untis=$this->db->query("SELECT t.*
FROM stock t
WHERE product_id=$product_id
GROUP BY unit");


        $unit_get=[];
        if($untis->num_rows()){
            foreach ($untis->result() as $items){
                $unit_get[]=[
                    'id'=>$items->unit,
                    'name'=>units_($items->unit)['name']
                ];
            }
        }
        else {
            foreach (units() as $items){
                $unit_get[]=[
                    'id'=>$items['id'],
                    'name'=>$items['name']
                ];
            }
        }

        $tip_name='Cixis';
        if(intval($tip)==1){
            $tip_name='Giriş';
        }
        $pers_name = personel_details_full($personel_id)['name'];
        if($cari_pers_type==1){
            $pers_name = customer_details($personel_id)['company'];
        }
        echo json_encode(array(
            'bolum_name'=>bolum_to_asama($bolum_id),
            'asama_name'=>task_to_asama($asama_id),
            'product_name'=>product_full_details($product_id)['product_name'],
            'tip_name'=>$tip_name,
            'warehouse_name'=>warehouse_details($warehouse_id)->title,
            'proje_name'=>proje_code($proje_id),
            'personel_name'=>$pers_name,
            'unit'=>$unit_get

        ));

    }

    public function create_fis(){


        $this->db->trans_start();
        $result = $this->stok->create_fis();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function create_fis_cloud(){


        $this->db->trans_start();
        $result = $this->stok->create_fis_cloud();
        if($result['status']){
            echo json_encode(array('code' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('code' => 410, 'message' =>$result['message']));
        }
    }

    public function update_fis(){


        $this->db->trans_start();
        $result = $this->stok->update_fis();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function delete_fis(){


        $this->db->trans_start();
        $result = $this->stok->delete_fis();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function delete_fis_file(){


        $this->db->trans_start();
        $result = $this->stok->delete_fis_file();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function insert_file_fis(){

        $this->db->trans_start();
        $result = $this->stok->insert_file_fis();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }
    public function talep_list_clear(){


        $this->db->trans_start();
        $result = $this->stok->talep_list_clear();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function stokdetails(){
        $stok_id = $this->input->post('stok_id');
        $result = $this->stok->stokdetails($stok_id);
        echo json_encode(array('status' => 200, 'item' =>$result));
    }

    public function get_parent_products(){
        $proje_stoklari_id = $this->input->post('proje_stoklari_id');
        $result = $this->stok->stock_parent($proje_stoklari_id);
        $item_details=[];
        foreach ($result as $items){
            $item_details[] = [
                'product_name'=>$items->product_name,
                'product_id'=>$items->product_id,
                'option_id'=>$items->option_id,
                'option_value_id'=>$items->option_value_id,
                'value_text'=>varyasyon_value_string($items->option_value_id),
                'qty'=>$items->qty,
                'unit_name'=>$items->unit_name,
                'proje_stoklari_id'=>$items->proje_stoklari_id,
                'unit_id'=>$items->unit_id,
                'unit_price'=>$items->unit_price,
            ];
        }



        if($result){
            echo json_encode(array('status' => 200, 'item' =>$item_details));
        }
        else {
            echo json_encode(array('status' => 410, 'item' =>''));
        }

    }

    public function create_parent(){
        $this->db->trans_start();
        $result = $this->stok->create_parent();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function personel_customer_type(){

        $tip = $this->input->post('tip');
        $result = customer_personel($tip);
        echo json_encode(array('status' => 200, 'item' =>$result));
    }

    public function file_handling()
    {
        if ($this->input->get('op')) {

            $name = $this->input->get('name');

            if ($this->transactions->meta_delete($name)) {

                echo json_encode(array('status' => 'Success'));

            }

        } else {

            $id = $this->input->get('id');

            $this->load->library("Uploadhandler_generic", array(

                'accept_file_types' => '/\.(pdf|gif|jpe?g|png|xlsx)$/i', 'upload_dir' => FCPATH . 'userfiles/product/', 'upload_url' => base_url() . 'userfile/product/'

            ));


        }
    }

}