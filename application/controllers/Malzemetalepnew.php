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

class Malzemetalepnew Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('malzemetalep_model', 'talep');
        $this->load->model('malzemetalepnew_model', 'newtalep');
        $this->load->model('projects_model', 'projects');

        $this->load->model('communication_model');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }
    public function index()
    {
        if (!$this->aauth->premission(31)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }



        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Malzame Talep Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('malzematalepnew/index');
        $this->load->view('fixed/footer');
    }
    public function ajax_list(){

        $list = $this->talep->get_datatables_query_details_talep_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $status_details =progress_status_details($prd->progress_status_id);
            $transfer_status = transfer_status($prd->transfer_status);

            if($prd->status==7){
                if($prd->transfer_status!=0){
                    if(!$prd->transfer_bildirim){
                        $transfer_status=' <button type="button" class="btn btn-secondary btn-labeled btn-labeled-left rounded-pill transfer_bildirim" talep_id='.$prd->id.'><b><i class="icon-reading"></i></b>Bildirim Başlat</button>';
                    }
                    else {
                        if($prd->transfer_status==1){
                            $transfer_status='Transfer Bildirimi Başlatıldı';
                        }
                        elseif($prd->transfer_status==2){
                            $transfer_status='Transfer Yapıldı';
                        }
                    }
                }
            }


            $color = $status_details->color;
            $text_color = $status_details->text_color;

            $style = "background-color:$color;color:$text_color";

            $cancel = "<button class='btn btn-danger talep_sil' talep_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
            $view = "<a class='btn btn-success view' href='/malzemetalepnew/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";

            $staff_personel=mt_onay_pers($prd->id,$prd->status)['personel_name'];
            $staf_tarih=mt_onay_pers($prd->id,$prd->status)['tarih'];;

            $no++;
            $row = array();
            $row[] = $prd->code;
            $row[] = $prd->progress_name;
            $row[] = $prd->created_at;
            $row[] = $prd->pers_name;
            $row[] = $prd->proje_name;
            $row[] = "<span class='badge text-status' style='background-color: $prd->color'>$prd->st_name</span>";
            $row[]=$transfer_status;
            $row[]=$staff_personel;
            $row[]=$staf_tarih;
            $row[] =$view;
            $row[] =$style;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->talep->count_all_talep(),
            "recordsFiltered" => $this->talep->count_filtered_talep(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function create_save(){
        $this->db->trans_start();
        $result = $this->newtalep->create_save();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Talep Oluşturuldu",'index'=>'/malzemetalepnew/view/'.$result['id']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }

    }
    public function create_form_items(){
        $this->db->trans_start();
        $result = $this->newtalep->create_form_items();
        if($result['status']){

            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Kayıt Edildi",'product_name'=>$result['product_name'],'qyt_birim'=>$result['qyt_birim'],'id'=>$result['id'],'option_html'=>$result['option_html'],'talep_form_products_id'=>$result['talep_form_products_id']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }
    }

    public function delete_item_form(){
        $this->db->trans_start();
        $id = $this->input->post('item_id');
        $details = $this->db->query("SELECT * FROM talep_form_products Where id=$id")->row();
        $type = $this->input->post('type');
        $talep_type  = $this->talep->details($details->form_id)->talep_type;

        if($talep_type==3){
            $product_name = who_demirbas($details->product_id)->name;
        }
        else {
            $product_name = product_details_($details->product_id)->product_name;
        }

        if($type==1){
            $this->newtalep->talep_history($details->form_id,$this->aauth->get_user()->id,$product_name.' Ürünü Kaldırıldı');
        }

        if($this->db->delete('talep_form_products', array('id' => $id))){

            $this->db->delete('talep_form_products_options', array('talep_form_product_id' => $id));
            $this->aauth->applog("Malzame Talebinden Ürün Silindi  :  ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Silindi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }

    }

    public function ban_item_form(){
        $this->db->trans_start();
        $id = $this->input->post('item_id');
        $details = $this->db->query("SELECT * FROM talep_form_products Where id=$id")->row();
        $type = $this->input->post('type');
        $talep_type  = $this->talep->details($details->form_id)->talep_type;

        if($talep_type==3){
            $product_name = who_demirbas($details->product_id)->name;
        }
        else {
            $product_name = product_details_($details->product_id)->product_name;
        }

        if($type==1){
            $this->newtalep->talep_history($details->form_id,$this->aauth->get_user()->id,$product_name.' Ürünü Kaldırıldı');
        }

        $data_update = array(
            'status' => 10,
            'iptal_eden_pers_id' => $this->aauth->get_user()->id,
        );
        $this->db->set($data_update);
        $this->db->where('id', $id);
        if ($this->db->update('talep_form_products', $data_update)) {

            $this->aauth->applog("Malzame Talebinden Ürün İptal Edildi  :  ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Ürün İptal Edildi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }

    }
    public function create_form_items_gider(){
        $this->db->trans_start();
        $result = $this->talep->create_form_items_gider();
        if($result['status']){

            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Kayıt Edildi",'product_name'=>$result['product_name'],'qyt_birim'=>$result['qyt_birim'],'id'=>$result['id'],'talep_form_products_id'=>$result['talep_form_products_id']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }
    }

    public function column_update(){
        $this->db->trans_start();
        $result = $this->newtalep->column_update();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }

    }

    public function view($id)
    {
        if (!$this->aauth->premission(31)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }

        $data['details']= $this->talep->details($id);

        $data['note_list']=new_list_note(7,$id);
        if (! $data['details']) {

            exit('<h3>Talep Bulunamadı</h3>');

        }
//        $data['cat'] = $this->categories_model->category_list();
//        $data['ana_kategoriler'] = $this->categories_model->category_list_();
//        $data['alt_kat'] = $this->categories_model->alt_kat();
        $users = $this->talep->talep_form_users($id);
        $user_=[];
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Malzame Talep Listesi';
        $data['bolumler']=$this->projects->bolumler_list($data['details']->proje_id);

        $data['items']= $this->newtalep->product_details($id);
        $data['data_products']= $this->newtalep->product_details($id);

        //Kategori detayları
        $products =  $data['data_products'];
        $cat_id_array = [];
        $cat_ids_array = [];
        if($products)
        {


            foreach ($products as $items){
                $product_details = product_details_($items->product_id);
                $cat_ids_array[] = $product_details->pcat;
                $cat_id_array[]=
                [
                    'id'=>$product_details->pcat,
                    'name'=>category_details($product_details->pcat)->title
                ];
            }
        }


        $uniq_cat = array_unique($cat_ids_array);
        $html="<div class='col-md-12 mb-3'>";
        foreach ($uniq_cat as $cat_id){
            $say = array_count_values(array_column($cat_id_array, 'id'))[$cat_id]; // outputs: 2
            $name = category_details($cat_id)->title;
            $html.="<span class='badge badge-secondary mr-2'>$say Ürün $name Kategorisinden</span>";

        }
        $html.="</div>";



        $data['kategori_html']= $html;
        $data['ihale_time']= $this->talep->ihale_time($id);
        $data['talep_user_satinalma']= $this->talep->talep_user_satinalma($id);
        $data['file_details']= $this->talep->file_details($id);
        if($users){
            foreach ($users as $items){
                $user_[]=$items->user_id;
            }
        }
        $data['users_details']= $user_;
        $this->load->view('fixed/header', $head);
        $this->load->view('malzematalepnew/view',$data);
        $this->load->view('fixed/footer');
    }

    public function stok_kontrol_view($id)
    {
        if (!$this->aauth->premission(31)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }

        $data['details']= $this->talep->details($id);

        $data['note_list']=new_list_note(7,$id);
        if (! $data['details']) {

            exit('<h3>Talep Bulunamadı</h3>');

        }
//        $data['cat'] = $this->categories_model->category_list();
//        $data['ana_kategoriler'] = $this->categories_model->category_list_();
//        $data['alt_kat'] = $this->categories_model->alt_kat();
        $users = $this->talep->talep_form_users($id);
        $user_=[];
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Malzame Talep Listesi';
        $data['bolumler']=$this->projects->bolumler_list($data['details']->proje_id);

        $data['items']= $this->newtalep->product_details($id);
        $data['data_products']= $this->newtalep->product_details($id);

        //Kategori detayları
        $products =  $data['data_products'];
        $cat_id_array = [];
        $cat_ids_array = [];
        if($products)
        {


            foreach ($products as $items){
                $product_details = product_details_($items->product_id);
                $cat_ids_array[] = $product_details->pcat;
                $cat_id_array[]=
                    [
                        'id'=>$product_details->pcat,
                        'name'=>category_details($product_details->pcat)->title
                    ];
            }
        }


        $uniq_cat = array_unique($cat_ids_array);
        $html="<div class='col-md-12 mb-3'>";
        foreach ($uniq_cat as $cat_id){
            $say = array_count_values(array_column($cat_id_array, 'id'))[$cat_id]; // outputs: 2
            $name = category_details($cat_id)->title;
            $html.="<span class='badge badge-secondary mr-2'>$say Ürün $name Kategorisinden</span>";

        }
        $html.="</div>";



        $data['kategori_html']= $html;


        $data['ihale_time']= $this->talep->ihale_time($id);
        $data['talep_user_satinalma']= $this->talep->talep_user_satinalma($id);
        $data['file_details']= $this->talep->file_details($id);
        if($users){
            foreach ($users as $items){
                $user_[]=$items->user_id;
            }
        }
        $data['users_details']= $user_;
        $this->load->view('fixed/header', $head);
        $this->load->view('malzematalepnew/stok_kontrol_view',$data);
        $this->load->view('fixed/footer');
    }

    public function talep_sureci($id)
    {
        if (!$this->aauth->premission(31)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }

        $data['details']= $this->talep->details($id);

        $data['note_list']=new_list_note(7,$id);
        if (! $data['details']) {

            exit('<h3>Talep Bulunamadı</h3>');

        }
//        $data['cat'] = $this->categories_model->category_list();
//        $data['ana_kategoriler'] = $this->categories_model->category_list_();
//        $data['alt_kat'] = $this->categories_model->alt_kat();
        $users = $this->talep->talep_form_users($id);
        $user_=[];
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Malzame Talep Listesi';
        $data['bolumler']=$this->projects->bolumler_list($data['details']->proje_id);

        $data['items']= $this->newtalep->product_details($id);
        $data['data_products']= $this->newtalep->product_details($id);

        //Kategori detayları
        $products =  $data['data_products'];
        $cat_id_array = [];
        $cat_ids_array = [];
        if($products)
        {


            foreach ($products as $items){
                $product_details = product_details_($items->product_id);
                $cat_ids_array[] = $product_details->pcat;
                $cat_id_array[]=
                    [
                        'id'=>$product_details->pcat,
                        'name'=>category_details($product_details->pcat)->title
                    ];
            }
        }


        $uniq_cat = array_unique($cat_ids_array);
        $html="<div class='col-md-12 mb-3'>";
        foreach ($uniq_cat as $cat_id){
            $say = array_count_values(array_column($cat_id_array, 'id'))[$cat_id]; // outputs: 2
            $name = category_details($cat_id)->title;
            $html.="<span class='badge badge-secondary mr-2'>$say Ürün $name Kategorisinden</span>";

        }
        $html.="</div>";



        $data['kategori_html']= $html;
        $data['ihale_time']= $this->talep->ihale_time($id);
        $data['talep_user_satinalma']= $this->talep->talep_user_satinalma($id);
        $data['file_details']= $this->talep->file_details($id);
        if($users){
            foreach ($users as $items){
                $user_[]=$items->user_id;
            }
        }
        $data['users_details']= $user_;
        $this->load->view('fixed/header', $head);
        $this->load->view('malzematalepnew/talep_sureci',$data);
        $this->load->view('fixed/footer');
    }


    public function search_products(){
        $where='';
        $data=[];
        $units=units();
        $cat_id = $this->input->post('cat_id');
        $proje_id = $this->input->post('proje_id');
        $bolum_id = $this->input->post('bolum_id');
        $asama_id = $this->input->post('asama_id');
        $keyword = $this->input->post('keyword');
        $talep_type = $this->input->post('talep_type');

        if($talep_type==1)
        {
            if($keyword && $cat_id){
                // $where = " (`product_name` LIKE '%$keyword%' or simeta_code LIKE '%$keyword%' or simeta_product_name LIKE '%$keyword%' or `product_code` LIKE '%$keyword%' or `barcode` LIKE '%$keyword%')  AND pcat=$cat_id";
                $where = " (geopos_products_parent.tag LIKE '%$keyword%' or  geopos_products.tag LIKE '%$keyword%' or `product_stock_code`.`code` LIKE '%$keyword%' or `geopos_products`.`product_name` LIKE '%$keyword%' or `geopos_products`.`product_code` LIKE '%$keyword%' or `geopos_products`.`barcode` LIKE '%$keyword%')  AND pcat=$cat_id";
            }
            else if($cat_id) {
                $where = "(geopos_products_parent.pcat=$cat_id or geopos_products.pcat=$cat_id)";
            }
            else if($keyword) {
                //$where = " `product_name` LIKE '%$keyword%' or simeta_code LIKE '%$keyword%' or simeta_product_name LIKE '%$keyword%' or `product_code` LIKE '%$keyword%' or `barcode` LIKE '%$keyword%' ";
                $where = " (geopos_products_parent.tag LIKE '%$keyword%' or geopos_products.tag LIKE '%$keyword%' or `product_stock_code`.`code` LIKE '%$keyword%' or `geopos_products`.`product_name` LIKE '%$keyword%' or `geopos_products`.`product_name_tr` LIKE '%$keyword%' or `geopos_products`.`product_name_en` LIKE '%$keyword%' or  `geopos_products`.`product_code` LIKE '%$keyword%' or `geopos_products`.`barcode` LIKE '%$keyword%' )";

            }

            $query = $this->db->query(" SELECT
    geopos_products.pid as product_id,
    geopos_products.image as images,
    CONCAT(geopos_products.product_name,
    ' ',geopos_products.product_name_tr,' ',geopos_products.product_name_en) 
        as product_name,
    IF(product_stock_code.id,product_stock_code.code,'varyasyon tanımlanmamış') as varyasyon,
    IF(product_stock_code.id,product_stock_code.id,0) as product_stock_code_id,
    product_stock_code.code
FROM geopos_products 
LEFT JOIN product_stock_code ON geopos_products.pid=product_stock_code.product_id
LEFT JOIN geopos_products_parent ON geopos_products_parent.product_stock_code_id=product_stock_code.id
WHERE  geopos_products.deleted_at is NULL and   $where GROUP BY product_stock_code.id
ORDER BY geopos_products.pid DESC LIMIT 30");
            if($query->num_rows()){
                foreach ($query->result() as $items){

                    $varyasyon_name = $items->varyasyon;
                    $product_id = $items->product_id;

                    $fa_button="<i class='fas fa-info-circle' style='font-size: 25px; animation-name: flash;  animation-duration: 1s;animation-timing-function: linear;animation-iteration-count: infinite;color: #0497ab'></i>";

                    if($items->product_stock_code_id){
                        $varyasyon_name="<span style='cursor:pointer' class='option_view_btn' stock_code_id='$items->product_stock_code_id'>$items->varyasyon</span>  ".$fa_button;

                    }

                    $images = $items->images;
                    $stoc_code_id = $items->product_stock_code_id;
                    $products_parent=$this->db->query("SELECT * FROM geopos_products_parent Where product_stock_code_id=$stoc_code_id");
                    if($products_parent->num_rows()){
                        $images = $products_parent->row()->image;
                    }
                    $data[]=[
                        'images'=>$images,
                        'product_id'=>$product_id,
                        'product_name'=>$items->product_name,
                        'proje_stoklari_id'=>0,
                        'unit_id'=>9,
                        'unit_name'=>units_(9)['name'],
                        'stock_qty'=>0,
                        'max_qty'=>99999999,
                        'option_id'=>null,
                        'option_value_id'=>null,
                        'p_unit_id'=>9,
                        'option_html'=>$varyasyon_name,
                        'product_stock_code_id'=>$items->product_stock_code_id,
                        'fa_button'=>$fa_button
                        //'option_html'=>varyasyon_string_name($items->option_id,$items->option_value_id)
                    ];
//                    }

                }
                echo json_encode(array('status' => 'Success','products'=>$data,'units'=>$units));
            }
            else {
                echo json_encode(array('status' => 'Error', 'message' =>"Ürün Bulunamadı"));
            }
        }
        elseif($talep_type==2)
        {

        }
        elseif($talep_type==3)
        {
            if($keyword && $cat_id){
                $where = " (`name` LIKE '%$keyword%' )  AND parent_id=$cat_id";
            }
            else if($cat_id) {
                $where = "parent_id=$cat_id";
            }
            else if($keyword) {
                $where = " `name` LIKE '%$keyword%'";

            }
            $query = $this->db->query("SElECT 
       geopos_cost.id  as pid ,
       geopos_cost.name as product_name,
       geopos_cost.unit as unit,
       geopos_cost.unit as p_unit_id

FROM `geopos_cost`
            WHERE $where   LIMIT 30");
            if($query->num_rows()){
                foreach ($query->result() as $items){


                    $data[]=[
                        'product_id'=>$items->pid,
                        'product_name'=>$items->product_name,
                        'unit_id'=>$items->unit,
                        'unit_name'=>units_($items->unit)['name'],
                        'stock_qty'=>0,
                        'max_qty'=>9999999999,
                        'option_id'=>0,
                        'option_value_id'=>0,
                        'p_unit_id'=>$items->p_unit_id,
                        'option_html'=>''
                    ];

                }
                echo json_encode(array('status' => 'Success','products'=>$data,'units'=>$units));
            }
            else {
                echo json_encode(array('status' => 'Error', 'message' =>"Ürün Bulunamadı"));
            }
        }




    }

    public function get_info_update(){
        $stok_id = $this->input->post('stok_id');
        $bolum_id = $this->input->post('bolum_id');
        $tip = $this->input->post('tip');
        $result = $this->newtalep->details_update($stok_id,$tip,$bolum_id);

        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['message'],'content'=>$result['content'],'title'=>$result['title']));
        }
        else {
            echo json_encode(array('status' => 410, 'message' =>$result['message'],'content'=>$result['content']));
        }

    }

    public function lineupdate(){
        $result = $this->newtalep->lineupdate();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['message']));
        }
        else {
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }

    }

    public function form_bildirim_olustur(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $type = $this->input->post('type');
        $user_id=$this->aauth->get_user()->id;
        if($type==1){


            $talep_kontrol  = $this->db->query("SELECT * FROM `talep_form` where id=$id and aauth=$user_id")->num_rows();
            if($talep_kontrol){
                $details = $this->talep->details($id);

                if(!isset($details->warehouse_id)){
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Depo Seçmeniz Gerekmektedir."));
                }
                else {

                    $products_items = $this->talep->details_items($id);
                    $sonuc=1;
//                    foreach ($products_items as $item_products){
//                       $val =  product_onay_kontrol($item_products->product_id);
//                       if(!$val){
//                           $sonuc++;
//                       }
//                    }
                    if($sonuc){
                        $data_update = array(
                            'status' => 17,
                        );
                        $this->db->set($data_update);
                        $this->db->where('id', $id);
                        if ($this->db->update('talep_form', $data_update)) {
                            $users_ = onay_sort(14,0,0,$id);

                            if($users_){
                                foreach ($users_ as $items){
                                    $staff=0;
                                    if($items['sort']==1){

                                        $staff=1;
                                    }

                                    $data_onay = array(
                                        'talep_id' => $id,
                                        'type' => 3,
                                        'staff' => $staff,
                                        'sort' => $items['sort'],
                                        'user_id' => $items['user_id'],
                                    );
                                    $this->db->insert('talep_onay_new', $data_onay);
                                }


                                $data = array(
                                    'status' => 17,
                                );
                                $this->db->set($data);
                                $this->db->where('form_id', $id);
                                $this->db->update('talep_form_products', $data);

                                // bildirim maili at
                                $mesaj=$details->code.' Numaralı Malzeme Talep Formu Stok Kontrol Onayınızı Beklemektedir';
                                $this->send_mail($items['user_id'],'Stok KOntrol Onayı',$mesaj);
                                // bildirim maili at
                                $user_phone = personel_details_full($items['user_id'])['phone'];
                                $this->mesaj_gonder($user_phone,$details->code.' Malzeme Talebi Onayınızı Beklemektedir.');

                                $this->newtalep->talep_history($id,$this->aauth->get_user()->id,'Onay İşlemi Başlatıldı');
                                //kont_kayit(21,$id);
                                $this->aauth->applog("Malzame Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);
                                $this->db->trans_complete();
                                echo json_encode(array('status' => 'Success','message'=>'Başarıyla Bildirim Başlatıldı'));

                            }
                            else {

                                echo json_encode(array('status' => 'Error', 'message' =>"Projenize Yetkili Kişiler Atanmamıştır veya Seçilen Depoya Yetkili Tanımlanmamıştır.Bu Sebeple İşlem Yapamazsınız."));
                                $this->db->trans_rollback();

                            }
                        }
                    }
                    else {
                        $data = array(
                            'bildirim_durumu' => 1,
                        );
                        $this->db->set($data);
                        $this->db->where('id', $id);
                        if ($this->db->update('talep_form', $data)) {

                            $data = array(
                                'status' => 1,
                            );
                            $this->db->set($data);
                            $this->db->where('form_id', $id);
                            $this->db->update('talep_form_products', $data);

                            $users_ = onay_sort(7,$details->proje_id,0,$id);

                            if($users_){
                                foreach ($users_ as $items){
                                    $staff=0;
                                    if($items['sort']==1){

                                        $staff=1;
                                    }

                                    $data_onay = array(
                                        'talep_id' => $id,
                                        'type' => $type,
                                        'staff' => $staff,
                                        'sort' => $items['sort'],
                                        'user_id' => $items['user_id'],
                                    );
                                    $this->db->insert('talep_onay_new', $data_onay);
                                }

                                // bildirim maili at
                                $mesaj=$details->code.' Numaralı Malzeme Talep Formu Onayınızı Beklemektedir';
                                $this->send_mail($items['user_id'],'Malzeme Talep Onayı',$mesaj);
                                // bildirim maili at
                                $user_phone = personel_details_full($items['user_id'])['phone'];
                                $this->mesaj_gonder($user_phone,$details->code.' Malzeme Talebi Onayınızı Beklemektedir.');

                                $this->newtalep->talep_history($id,$this->aauth->get_user()->id,'Onay İşlemi Başlatıldı');
                                //kont_kayit(21,$id);
                                $this->aauth->applog("Malzame Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);
                                $this->db->trans_complete();
                                echo json_encode(array('status' => 'Success','message'=>'Başarıyla Bildirim Başlatıldı'));

                            }
                            else {

                                echo json_encode(array('status' => 'Error', 'message' =>"Projenize Yetkili Kişiler Atanmamıştır veya Seçilen Depoya Yetkili Tanımlanmamıştır.Bu Sebeple İşlem Yapamazsınız."));
                                $this->db->trans_rollback();

                            }

                            //Satınalma İse

                            if($type==2){
                                $data_type= array(
                                    'status' => 4,
                                );
                                $this->db->set($data_type);
                                $this->db->where('id', $id);
                                $this->db->update('talep_form', $data_type);

                                //Satınalma İse
                                $this->newtalep->talep_history($id,$this->aauth->get_user()->id,'Onay İşlemi Başlatıldı');
                                $this->aauth->applog("Malzame Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);
                                $this->db->trans_complete();
                                echo json_encode(array('status' => 'Success','message'=>'Başarıyla Bildirim Başlatıldı'));
                            }


                        }
                        else {

                            $this->db->trans_rollback();
                            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
                        }
                    }

                }



            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Yetkiniz Bulunmamaktadır."));
            }
        }
        elseif($type==2){
            $talep_kontrol  = $this->db->query("SELECT * FROM `talep_user_satinalma` where talep_id=$id and user_id=$user_id")->num_rows();
            if($talep_kontrol){
                $details = $this->talep->details($id);
                $data = array(
                    'bildirim_durumu' => 1,
                );
                $this->db->set($data);
                $this->db->where('id', $id);
                if ($this->db->update('talep_form', $data)) {

                    $users_ = onay_sort(1,$details->proje_id,$id);
                    if(!$users_){
                        $this->db->trans_rollback();
                        echo json_encode(array('status' => 'Error', 'message' =>"Projenize Yetkili Kişiler Atanmamıştır.Bu Sebeple İşlem Yapamazsınız."));
                    }
                    else {
                        foreach ($users_ as $items){
                            $staff=0;
                            if($items['sort']==1){

                                $staff=1;
                            }
                            $data_onay = array(
                                'talep_id' => $id,
                                'type' => $type,
                                'staff' => $staff,
                                'sort' => $items['sort'],
                                'user_id' => $items['user_id'],
                            );
                            $this->db->insert('talep_onay_new', $data_onay);
                        }
                    }

                    //Satınalma İse

                    if($type==2){
                        $data_type= array(
                            'status' => 4,
                        );
                        $this->db->set($data_type);
                        $this->db->where('id', $id);
                        $this->db->update('talep_form', $data_type);
                    }

                    //Satınalma İse
                    $this->newtalep->talep_history($id,$this->aauth->get_user()->id,'Onay İşlemi Başlatıldı');
                    $this->aauth->applog("Malzame Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);
                    $this->db->trans_complete();
                    echo json_encode(array('status' => 'Success','message'=>'Başarıyla Bildirim Başlatıldı'));
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
                }
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Yetkiniz Yoktur."));
            }
        }



    }

    public function send_mail($user_id,$subject,$message){
        if(!$user_id){
            return 0;
        }
        else {
            $message .= "<br><br><br><br>";
            $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
            $proje_sorumlusu_email = personel_detailsa($user_id)['email'];
            $recipients = array($proje_sorumlusu_email);
            $this->communication_model->onay_mail($recipients, $subject, $message, false,'', 'gider_talep_onay_maili');
            return 1;
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

    public function warehouse_update()
    {
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $details = $this->talep->details($id);
        $warehouse_text = $this->input->post('warehouse_text');
        $warehouse_id = $this->input->post('warehouse_id');
        $tip = $this->input->post('tip');
        $data=[];
        if($tip==1){
            $data = array(
                'warehouse_id' => $warehouse_id,
                'warehouse_notes' => $warehouse_text,
            );
        }
        else {
            $data = array(
                'transfer_warehouse_id' => $warehouse_id,
                'transfer_warehouse_notes' => $warehouse_text,
            );
        }

        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('talep_form', $data)) {
            $this->aauth->applog("Malzame Talebinde Depo Tanımlaması Yapıldı Talep :  ID : ".$id, $this->aauth->get_user()->username);
            $this->newtalep->talep_history($id,$this->aauth->get_user()->id,'Depo Değiştildi. Eki Depo : '.warehouse_details($warehouse_id)->title.' Yeni Depo : '.warehouse_details($warehouse_id)->title );
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Güncellendi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
        }
    }
    public function onay_olustur_stok_kontrol(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $progress_status_id = $this->input->post('progress_status_id');
        $details = $this->talep->details($id);
        $type = $this->input->post('type');
        $product_details = $this->input->post('product_details');
        $onay_new_list = $this->input->post('onay_new_list');
        $data_useer=[];
        if($onay_new_list){
            $sort = $this->db->query("SELECT * FROM `talep_onay_new` Where type=3 and talep_id=$id  ORDER BY `sort` DESC LIMIT 1")->row()->sort;

            foreach ($onay_new_list as $items_users){
                $staff=0;
                $data_onay = array(
                    'talep_id' => $id,
                    'type' => 3,
                    'staff' => $staff,
                    'sort' => $sort,
                    'user_id' => $items_users,
                );
                $this->db->insert('talep_onay_new', $data_onay);
                $sort++;
            }
        }



        $new_id=0;
        $new_user_id=0;
        $new_id_control = $this->db->query("SELECT * FROM `talep_onay_new` Where type=$type and talep_id=$id and staff=0 and status is Null ORDER BY `talep_onay_new`.`id` ASC LIMIT 1");
        if($new_id_control->num_rows()){
            $new_id = $new_id_control->row()->id;
            $new_user_id = $new_id_control->row()->user_id;
        }


        $data_post = array(
            'status' => 1,
            'staff' => 0,
        );


        $this->db->where('user_id',$this->aauth->get_user()->id);
        $this->db->where('staff',1);
        $this->db->where('type',$this->input->post('type'));
        $this->db->set($data_post);
        $this->db->where('talep_id', $this->input->post('talep_id'));
        if ($this->db->update('talep_onay_new', $data_post)) {

            $this->newtalep->talep_history($id,$this->aauth->get_user()->id,'Onay Verildi');
            if($new_id){

                // bildirim maili at
                $mesaj=$details->code.' Numaralı Malzeme Talep Formu Onayınızı Beklemektedir';
                $this->send_mail($new_user_id,'Malzeme Talep Onayı',$mesaj);
                // bildirim maili at
                $user_phone = personel_details_full($new_user_id)['phone'];
                $this->mesaj_gonder($user_phone,$details->code.' Malzeme Talebi Onayınızı Beklemektedir.');
                // Bir Sonraki Onay
                $data_new=array(
                    'staff'=>1,
                );
                $this->db->where('id',$new_id);
                $this->db->set($data_new);
                $this->db->update('talep_onay_new', $data_new);
                // Bir Sonraki Onay
            }
            else {

                $data_form = array(
                    'bildirim_durumu' => 1,
                    'status' => 1,
                );
                $this->db->set($data_form);
                $this->db->where('id', $id);
                if ($this->db->update('talep_form', $data_form)) {

                    $users__talep = onay_sort(7,$details->proje_id,0,$id);

                    if($users__talep){
                        foreach ($users__talep as $items_talep){
                            $staff=0;
                            if($items_talep['sort']==1){

                                $staff=1;
                            }

                            $data_onay = array(
                                'talep_id' => $id,
                                'type' => 1,
                                'staff' => $staff,
                                'sort' => $items_talep['sort'],
                                'user_id' => $items_talep['user_id'],
                            );
                            $this->db->insert('talep_onay_new', $data_onay);
                        }

                        // bildirim maili at
                        $mesaj=$details->code.' Numaralı Malzeme Talep Formu Onayınızı Beklemektedir';
                        $this->send_mail($items_talep['user_id'],'Malzeme Talep Onayı',$mesaj);
                        // bildirim maili at
                        $user_phone = personel_details_full($items_talep['user_id'])['phone'];
                        $this->mesaj_gonder($user_phone,$details->code.' Malzeme Talebi Onayınızı Beklemektedir.');

                        $this->newtalep->talep_history($id,$this->aauth->get_user()->id,'Onay İşlemi Başlatıldı');
                        //kont_kayit(21,$id);
                        $this->aauth->applog("Malzame Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);

                        //proje stoklarına ekle
                        $product_details_items = $this->talep->details_items($id);
                        if($product_details_items){
                            foreach ($product_details_items as $product){
                                if($details->talep_type!=3){
                                    $proje_stoklari_kontrol = $this->db->query("SELECT * FROM proje_stoklari Where product_id=$product->product_id and product_stock_code_id=$product->product_stock_code_id");
                                    if($proje_stoklari_kontrol->num_rows())
                                    {
                                        $proje_stoklari_id = $proje_stoklari_kontrol->row()->id;
                                        $talep_form_item= array(
                                            'proje_stoklari_id' => $proje_stoklari_id,
                                        );
                                        $this->db->set($talep_form_item);
                                        $this->db->where('id', $product->id);
                                        $this->db->update('talep_form_products', $talep_form_item);


                                        $talep_form_qty= array(
                                            'qty' => ($proje_stoklari_kontrol->row()->qty+$product->product_qty),
                                        );
                                        $this->db->set($talep_form_qty);
                                        $this->db->where('id', $proje_stoklari_id);
                                        $this->db->update('proje_stoklari', $talep_form_qty);

                                    }
                                    else {
                                        //yeni ürün eklnmiş demektir proje stoklarına insert
                                        $product_stock_code_id=$product->product_stock_code_id;
                                        $data = array(
                                            'proje_id' => $details->proje_id,
                                            'product_id' => $product->product_id,
                                            'product_stock_code_id'=>$product_stock_code_id,
                                            'product_desc'=>$product->product_desc,
                                            'unit_id' => $product->unit_id,
                                            'qty' => $product->product_qty,
                                            'unit_price' => 0,
                                            'bolum_id' => $details->bolum_id,
                                            'asama_id' => $details->asama_id,
                                            'tip' => 1,
                                            'aauth_id' => $this->aauth->get_user()->id
                                        );

                                        $this->db->insert('proje_stoklari', $data);
                                        $last_id = $this->db->insert_id();

                                        $talep_form_item= array(
                                            'proje_stoklari_id' => $last_id,
                                        );
                                        $this->db->set($talep_form_item);
                                        $this->db->where('id', $product->id);
                                        $this->db->update('talep_form_products', $talep_form_item);

                                        //yeni ürün eklnmiş demektir proje stoklarına insert
                                    }
                                }

                            }
                        }
                        //proje stoklarına ekle


                        $data_products = [
                            'status'=>1
                        ];
                        $this->db->where('form_id',$id);
                        $this->db->set($data_products);
                        $this->db->update('talep_form_products', $data_products);

                        $this->db->trans_complete();
                        echo json_encode(array('status' => 'Success','message'=>'Başarıyla Bildirim Başlatıldı'));

                    }
                    else {

                        echo json_encode(array('status' => 'Error', 'message' =>"Projenize Yetkili Kişiler Atanmamıştır veya Seçilen Depoya Yetkili Tanımlanmamıştır.Bu Sebeple İşlem Yapamazsınız."));
                        $this->db->trans_rollback();

                    }

                    //Satınalma İse

                    if($type==2){
                        $data_type= array(
                            'status' => 4,
                        );
                        $this->db->set($data_type);
                        $this->db->where('id', $id);
                        $this->db->update('talep_form', $data_type);

                        //Satınalma İse
                        $this->talep_history($id,$this->aauth->get_user()->id,'Onay İşlemi Başlatıldı');
                        $this->aauth->applog("Malzame Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);
                        $this->db->trans_complete();
                        echo json_encode(array('status' => 'Success','message'=>'Başarıyla Bildirim Başlatıldı'));
                    }


                }
                else {

                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
                }
            }

//            $this->aauth->applog("Malzame Talebine Onay Verildi :  ID : ".$id, $this->aauth->get_user()->username);
//            $this->db->trans_complete();
//            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Onay Verildi'));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));

        }

    }

    public function onay_olustur(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $progress_status_id = $this->input->post('progress_status_id');
        $details = $this->talep->details($id);
        $type = $this->input->post('type');
        $product_details = $this->input->post('product_details');
        foreach ($product_details as $items){
            $item_id = $items['item_id'];
            $item_details=$this->db->query("SELECT * FROM  talep_form_products where id =$item_id ")->row();


            $product_name= '';
            //varyasyon var ise
            if($details->talep_type==1){
                $product_name= product_details_($item_details->product_id)->product_name;
            }
            elseif($details->talep_type==2) {
                $product_name= product_details_($item_details->product_id)->product_name;
            }
            elseif($details->talep_type==3) {
                $product_name= who_demirbas($item_details->product_id)->name;
            }


            $data_item_update = [
                'product_qty'=>$items['item_qty']
            ];
            $this->db->where('id',$items['item_id']);
            $this->db->set($data_item_update);
            $this->db->update('talep_form_products', $data_item_update);

            $data_talep_updata=['progress_status_id'=>$progress_status_id];
            $this->db->where('id',$id);
            $this->db->set($data_talep_updata);
            $this->db->update('talep_form', $data_talep_updata);

            $progress_status_details = progress_status_details($progress_status_id);
            $this->newtalep->talep_history($id,$this->aauth->get_user()->id,$product_name.' Ürünü İçin Yeni Miktar : '.$items['item_qty'].' Yeni Durum : '.$progress_status_details->name);
        }


        $satinalma_personeli = $this->input->post('satinalma_personeli');
        $new_id=0;
        $new_user_id=0;
        $new_id_control = $this->db->query("SELECT * FROM `talep_onay_new` Where type=$type and talep_id=$id and staff=0 and status is Null ORDER BY `talep_onay_new`.`id` ASC LIMIT 1");
        if($new_id_control->num_rows()){
            $new_id = $new_id_control->row()->id;
            $new_user_id = $new_id_control->row()->user_id;
        }

        $this->db->delete('talep_user_satinalma', array('talep_id' => $id));
        $data_satinalma=[
            'user_id'=>$satinalma_personeli,
            'talep_id'=>$id,
        ];

        $this->db->insert('talep_user_satinalma', $data_satinalma);

        $data = array(
            'status' => 1,
            'staff' => 0,
        );

        $this->db->where('user_id',$this->aauth->get_user()->id);
        $this->db->where('staff',1);
        $this->db->where('type',$type);
        $this->db->set($data);
        $this->db->where('talep_id', $id);
        if ($this->db->update('talep_onay_new', $data)) {

            $this->newtalep->talep_history($id,$this->aauth->get_user()->id,'Onay Verildi');
            if($new_id){

                // bildirim maili at
                $mesaj=$details->code.' Numaralı Malzeme Talep Formu Onayınızı Beklemektedir';
                $this->send_mail($new_user_id,'Malzeme Talep Onayı',$mesaj);
                // bildirim maili at
                $user_phone = personel_details_full($new_user_id)['phone'];
                $this->mesaj_gonder($user_phone,$details->code.' Malzeme Talebi Onayınızı Beklemektedir.');
                // Bir Sonraki Onay
                $data_new=array(
                    'staff'=>1,
                );
                $this->db->where('id',$new_id);
                $this->db->set($data_new);
                $this->db->update('talep_onay_new', $data_new);
                // Bir Sonraki Onay
            }
            else {

                $mesaj=$details->code.' Numaralı Malzeme Talep Formu Onaylanmıştır. İhale İşlemlerine Başlayabilirsiniz';

                if( $this->send_mail($satinalma_personeli,'İhale Emri',$mesaj)){
                    $user_phone = personel_details_full($satinalma_personeli)['phone'];
                    $this->mesaj_gonder($user_phone,$details->code.' Numaralı Malzeme Talep Formu Onaylanmıştır. İhale İşlemlerine Başlayabilirsiniz.');

                    // satinalmaya bildirimini goster
                    $data_sf=array(
                        'status'=>1,
                    );
                    //satınalmaya geç
                    $this->db->set($data_sf);
                    $this->db->where('talep_id', $id);
                    $this->db->update('talep_user_satinalma', $data_sf);
                    // satinalmaya bildirimini goster
                    $data_Form=array(
                        'status'=>2,
                    );
                    //satınalmaya geç
                    $this->db->set($data_Form);
                    $this->db->where('id', $id);
                    $this->db->update('talep_form', $data_Form);
                    //satınalmaya geç
                }


            }

            $this->aauth->applog("Malzame Talebine Onay Verildi :  ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Onay Verildi'));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));

        }

    }
}