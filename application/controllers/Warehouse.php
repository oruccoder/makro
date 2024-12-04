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



class Warehouse Extends CI_Controller

{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('warehouse_model', 'warehouse');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

    }

    public function index()

    {
        $head['title'] = "Depolar";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('warehouse/index');
        $this->load->view('fixed/footer');

    }

    public function ajax_list(){
        $list = $this->warehouse->get_datatables_details();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $view = "<a class='btn btn-success' href='/warehouse/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";
            $edit = "<button class='btn btn-warning edit' id='$prd->id'><i class='fa fa-pen'></i></button>&nbsp;";
            $no++;
            $row = array();
            $row[] = $prd->title;
            $row[] = personel_details($prd->pers_id);
            $row[] = $edit.$view;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->warehouse->count_all(),
            "recordsFiltered" => $this->warehouse->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_details(){
        $url = base_url();
        $id = $this->input->post('id');
        $list = $this->warehouse->get_datatables_details_details();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $pcat='';

            $name = $prd->product_name;
            $product_details = product_full_details($prd->product_id);
            if($prd->form_type==6){
                $name = who_demirbas($prd->product_id)->name;
                $pcat='-';
            }
            else {
                if($product_details['pcat']){
                    if(category_details($product_details['pcat'])){
                        $pcat=category_details($product_details['pcat'])->title;;
                    }
                }

            }

            $image = $product_details['image'];
            $view = "<button class='btn btn-success details btn-sm' product_id='$prd->product_id' warehouse='$id' type='button'><i class='fa fa-eye'></i> Giriş Çıkış</button>&nbsp;";
            $view_details = "&nbsp;<button class='btn btn-info  btn-sm details_varyant' product_id='$prd->product_id' warehouse='$id' type='button'><i class='fa fa-eye'></i> Stok</button>&nbsp;";
            $no++;
            $row = array();
            $row[] = "<img src='$url$image' alt='' style='max-width:100%' height='auto' class='img-fluid'>";
            $row[] = $pcat;
            $row[] = $name;
            $row[] = amountFormat_s(stock_qty_warehouse($prd->product_id,$id)['qty']).' '.stock_qty_warehouse($prd->product_id,$id)['unit_name'];
            $row[] = $view.$view_details;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->warehouse->count_all_details(),
            "recordsFiltered" => $this->warehouse->count_filtered_details(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function ajax_list_product_details(){


        $list = $this->warehouse->get_datatables_details_product_details();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $islem_turu='';
            $mt_id = $prd->mt_id;
            if($prd->form_type==1){

                $islem_kode='Talep Oluşturulmamış';
                $talep_eden='';
                $proje_adi='';
                $bolum_adi='';
                $asama_adi='';
                if($mt_id){
                    $islem_detaisl=$this->db->query("SELECT * FROM `talep_form` Where id =$mt_id");
                    if($islem_detaisl->num_rows()){
                        $islem_kode = $islem_detaisl->row()->code;
                        $talep_eden = personel_details_full($islem_detaisl->row()->talep_eden_user_id)['name'];
                        $proje_adi = proje_details($islem_detaisl->row()->proje_id)->name;
                        $bolum_adi = bolum_getir($islem_detaisl->row()->bolum_id);
                        $asama_adi = asama_get($islem_detaisl->row()->asama_id)->name;
                    }
                }

                $islem_turu = 'Malzeme Talep Satınalması - '.$islem_kode.'<br>'.$talep_eden.'<br>'.$proje_adi.'<br>'.$bolum_adi.'<br>'.$asama_adi;
            }
            elseif($prd->form_type==2){
                $islem_kode = $this->db->query("SELECT * FROM `geopos_invoices` Where id =$mt_id");
                if($islem_kode->num_rows()){
                    $islem_turu = 'Qaime - '.$islem_kode->row()->invoice_no;
                }
                else {
                    $islem_turu = 'Qaime - ';
                }

            }
            elseif($prd->form_type==3){
                $islem_kode = $this->db->query("SELECT * FROM `stock_io` Where id =$mt_id")->row()->code;
                $islem_turu = $islem_kode.'';
            }

            elseif($prd->form_type==4){
                $islem_kode = $this->db->query("SELECT * FROM `stock_transfer` Where id =$mt_id")->row()->code;
                $islem_turu = 'Stok Transfer Fişi - '.$islem_kode;
            }

            elseif($prd->form_type==5){
                if($this->db->query("SELECT * FROM `geopos_uretim` Where id =$mt_id")->num_rows()){
                    $islem_kode = $this->db->query("SELECT * FROM `geopos_uretim` Where id =$mt_id")->row()->code;
                    $islem_turu = 'Üretim Fişi - '.$islem_kode;
                }
                else {
                    $islem_turu = 'Kaldırılmış Üretim Fişi';
                }

            }
            elseif($prd->form_type==6){

                $islem_kode='Talep Oluşturulmamış';
                $talep_eden='';
                $proje_adi='';
                $bolum_adi='';
                $asama_adi='';
                if($mt_id){
                    $islem_detaisl=$this->db->query("SELECT * FROM `talep_form` Where id =$mt_id");
                    if($islem_detaisl->num_rows()){
                        $islem_kode = $islem_detaisl->row()->code;
                        $talep_eden = personel_details_full($islem_detaisl->row()->talep_eden_user_id)['name'];
                        $proje_adi = proje_details($islem_detaisl->row()->proje_id)->name;
                        $bolum_adi = bolum_getir($islem_detaisl->row()->bolum_id);
                        $asama_adi = asama_get($islem_detaisl->row()->asama_id)->name;
                    }
                }

                $islem_turu = 'Malzeme Talep Proje Gider Satınalması - '.$islem_kode.'<br>'.$talep_eden.'<br>'.$proje_adi.'<br>'.$bolum_adi.'<br>'.$asama_adi;
            }

            elseif($prd->form_type==8){
                if($this->db->query("SELECT * FROM `talep_form_nakliye_products` Where id =$mt_id")->num_rows()){
                    $islem_kode = $this->db->query("SELECT * FROM `talep_form_nakliye_products` Where id =$mt_id")->row();
                    $islem_kode_nakliye = $this->db->query("SELECT * FROM `talep_form_nakliye` Where id =$islem_kode->form_id")->row();
                    $islem_turu = $islem_kode_nakliye->code.' - '.$islem_kode->code.' | Nakliye Talebi';
                }
                else {
                    $islem_turu = 'Kaldırılmış Nakliye Talebi';
                }

            }


            $type='';
            if($prd->types==0){
                $type='<i class="fa fa-truck fa-2x text-danger"></i>'.' Stok Çıkışı';
            }
            else {
                $type='<i class="fa fa-truck fa-flip-horizontal fa-2x text-success"></i>'.' Stok Girişi';
            }
            $varyasyon='';
            if($prd->product_stock_code_id){
                $stock_code=$this->db->query("SELECT * FROM product_stock_code Where id=$prd->product_stock_code_id");
                if($stock_code->num_rows()){
                    $varyasyon = $stock_code->row()->code;
                }
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $varyasyon;
            $row[] = amountFormat_s($prd->qty).' '.units_($prd->unit)['name'];
            $row[] = $type;
            $row[] = $prd->pers_name;
            $row[] = $islem_turu;
            $row[] = $prd->created_at;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->warehouse->count_all_product_details(),
            "recordsFiltered" => $this->warehouse->count_filtered_product_details(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_product_varyant_details(){
        $product_id = $this->input->post('product_id');
        $list = $this->warehouse->get_ajax_list_product_varyant_details();

        $giren_details=[];
        $cikan_details=[];
        foreach ($list as $items){
            if($items->types==1) // Giren
            {
                $giren_details[]=[
                    'total'=>$items->total,
                    'option_id'=>$items->option_id,
                    'option_value_id'=>$items->option_value_id,
                    'product_stock_code_id'=>$items->product_stock_code_id,
                    'unit'=>$items->unit,
                    'warehouse_id'=>$items->warehouse_id,
                ];
            }
            else //Çıkan
            {
                $cikan_details[]=[
                    'total'=>$items->total,
                    'option_id'=>$items->option_id,
                    'option_value_id'=>$items->option_value_id,
                    'product_stock_code_id'=>$items->product_stock_code_id,
                    'unit'=>$items->unit,
                    'warehouse_id'=>$items->warehouse_id,
                ];
            }

        }

        $kalan_details=[];
        foreach ($giren_details as $giren){
            $kalan_qty=$giren['total'];
             foreach ($cikan_details as $cikan){
                 if($giren['product_stock_code_id'] == $cikan['product_stock_code_id']){
                     $kalan_qty-=$cikan['total'];
                 }
             }
            if($kalan_qty>0) {
                $kalan_details[] = [
                    'total' => $kalan_qty,
                    'option_id' => $giren['option_id'],
                    'option_value_id' => $giren['option_value_id'],
                    'unit' => $giren['unit'],
                    'warehouse_id' => $giren['warehouse_id'],
                    'product_stock_code_id' => $giren['product_stock_code_id'],
                ];
            }
        }




        $data = array();
        $no = $this->input->post('start');
        $start = $this->input->post('start');
        $index=0;
        foreach ($kalan_details as $prd) {
                $btn_stok_cikis=    '<button type="button" class="btn btn-success cikis_fis" tip="1" data-product_stock_code_id="'.$prd['product_stock_code_id'].'" data-option_id="'.$prd['option_id'].'"  data-option_value_id="'.$prd['option_value_id'].'" data-warehouse_id="'.$prd['warehouse_id'].'" data-unit="'.$prd['unit'].'" data-product_id="'.$product_id.'" >Stok Çıkış Listeme Ekle</button>';
                $btn_p_stok_cikis=  '<button type="button" class="btn btn-info cikis_fis" tip="2" data-product_stock_code_id="'.$prd['product_stock_code_id'].'"  data-option_id="'.$prd['option_id'].'"  data-option_value_id="'.$prd['option_value_id'].'" data-warehouse_id="'.$prd['warehouse_id'].'" data-unit="'.$prd['unit'].'"  data-product_id="'.$product_id.'" >Proje Stok Çıkış Listeme Ekle</button>';
                //$varyasyon=varyasyon_string_name($prd['option_id'],$prd['option_value_id']);
                $stock_code_id = $prd['product_stock_code_id'];
                $varyasyon='';
                if($stock_code_id){
                $stock_code=$this->db->query("SELECT * FROM product_stock_code Where id=$stock_code_id");
                if($stock_code->num_rows()){
                    $varyasyon = $stock_code->row()->code;
                }
            }


                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $varyasyon;
                $row[] = amountFormat_s($prd['total']).' '.units_($prd['unit'])['name'];
                $row[] = $btn_stok_cikis;
                $row[] = $btn_p_stok_cikis;
                $data[] = $row;
        }
        $bolum = count($kalan_details)/$_POST['length'];
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => count($kalan_details),
            "recordsFiltered" => 1,
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_product_varyant_details_all(){
        $product_id = $this->input->post('product_id');

        $loc = $this->session->userdata('set_firma_id');

        $warehouse_all = all_warehouse();
        $list_all = [];
        foreach ($warehouse_all as $items){
            $warehouse_id=$items->id;
            $array = $this->db->query("SELECT sum(stock.qty) as total, `stock`.*, `stock_to_options`.`option_id`,
               `stock_to_options`.`option_value_id` FROM `stock` LEFT JOIN `stock_to_options` ON `stock`.`id`=`stock_to_options`.`stock_id`
                WHERE `stock`.`warehouse_id` = $warehouse_id AND `stock`.`product_id` = $product_id AND `stock`.`loc` = $loc 
                  and types=1
                group by stock_to_options.option_value_id
                UNION ALL
                SELECT sum(stock.qty) as total, `stock`.*, `stock_to_options`.`option_id`,
                       `stock_to_options`.`option_value_id` FROM `stock` LEFT JOIN `stock_to_options` ON `stock`.`id`=`stock_to_options`.`stock_id`
                WHERE `stock`.`warehouse_id` = $warehouse_id AND `stock`.`product_id` = $product_id AND `stock`.`loc` = $loc
                  and types=0
                group by stock_to_options.option_value_id
                ");
            if($array->num_rows()){
                $list_all = array_merge($list_all,$array->result_array());
            }
        }



        $disctinc = $this->unique_multidim_array($list_all,'warehouse_id');

        $kalan_details=[];
        $data = array();
        foreach ($disctinc as $_walues){

            $warehouse_id=$_walues['warehouse_id'];
            $list_alls= $this->db->query("SELECT sum(stock.qty) as total, `stock`.*, `stock_to_options`.`option_id`,
               `stock_to_options`.`option_value_id` FROM `stock` LEFT JOIN `stock_to_options` ON `stock`.`id`=`stock_to_options`.`stock_id`
                WHERE `stock`.`warehouse_id` = $warehouse_id AND `stock`.`product_id` = $product_id AND `stock`.`loc` = $loc 
                  and types=1
                group by stock_to_options.option_value_id
                UNION ALL
                SELECT sum(stock.qty) as total, `stock`.*, `stock_to_options`.`option_id`,
                       `stock_to_options`.`option_value_id` FROM `stock` LEFT JOIN `stock_to_options` ON `stock`.`id`=`stock_to_options`.`stock_id`
                WHERE `stock`.`warehouse_id` = $warehouse_id AND `stock`.`product_id` = $product_id AND `stock`.`loc` = $loc
                  and types=0
                group by stock_to_options.option_value_id
                ")->result();

            $giren_details=[];
            $cikan_details=[];

            foreach ($list_alls as $items){
                if($items->types==1) // Giren
                {
                    $giren_details[]=[
                        'total'=>$items->total,
                        'option_id'=>$items->option_id,
                        'option_value_id'=>$items->option_value_id,
                        'unit'=>$items->unit,
                        'warehouse_id'=>$items->warehouse_id,
                    ];
                }
                else //Çıkan
                {
                    $cikan_details[]=[
                        'total'=>$items->total,
                        'option_id'=>$items->option_id,
                        'option_value_id'=>$items->option_value_id,
                        'unit'=>$items->unit,
                        'warehouse_id'=>$items->warehouse_id,
                    ];
                }

            }

            $kalan_details=[];
            foreach ($giren_details as $giren){
                $kalan_qty=$giren['total'];
                foreach ($cikan_details as $cikan){
                    if($giren['option_value_id'] == $cikan['option_value_id']){
                        $kalan_qty-=$cikan['total'];
                    }
                }
                if($kalan_qty>0){
                    $kalan_details[]=[
                        'total'=>$kalan_qty,
                        'option_id'=>$giren['option_id'],
                        'option_value_id'=>$giren['option_value_id'],
                        'unit'=>$giren['unit'],
                        'warehouse_id'=>$giren['warehouse_id'],
                    ];
                }

            }


            $no = $this->input->post('start');
            $start = $this->input->post('start');
            $index=0;
            foreach ($kalan_details as $prd) {
                if($this->input->post('warehouse_id')){

                    $varyasyon=varyasyon_string_name($prd['option_id'],$prd['option_value_id']);
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $varyasyon;
                    $row[] = amountFormat_s($prd['total']).' '.units_($prd['unit'])['name'];
                    $data[] = $row;

                }
                else{

                    $varyasyon=varyasyon_string_name($prd['option_id'],$prd['option_value_id']);
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = warehouse_details($prd['warehouse_id'])->title;
                    $row[] = $varyasyon;
                    $row[] = amountFormat_s($prd['total']).' '.units_($prd['unit'])['name'];
                    $data[] = $row;

                }
            }
            $bolum = count($kalan_details)/$_POST['length'];


        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => count($kalan_details),
            "recordsFiltered" => 1,
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }



    public function view($id){
        $data['details']=$this->warehouse->details($id);
        $head['title'] = "Depolar - ".$data['details']->title;
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['id']=$id;
        $this->load->view('fixed/header', $head);
        $this->load->view('warehouse/view',$data);
        $this->load->view('fixed/footer');
    }

    public function create_save(){
        $this->db->trans_start();
        $result = $this->warehouse->create_save();
        if($result['status']){

            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Depo Oluşturuldu"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }

    public function update_warehouse(){
        $this->db->trans_start();
        $result = $this->warehouse->update_warehouse();
        if($result['status']){

            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Depo Güncellendi"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }

    public function get_info(){
        $id = $this->input->post('id');
        echo json_encode(array('status' => 'Success', 'items'=>$this->warehouse->details($id)));
    }

    public function get_product_to_value_warehouse(){
        $product_id = $this->input->post('product_id');
        $warehouse_id = $this->input->post('warehouse_id');
        $html = product_to_option_html_warehouse($product_id,$warehouse_id);
        if($html['status']){
            echo json_encode(array('code' => 200, 'html' =>$html['html'],'varyasyonstatus'=>$html['varyasyonstatus'] ));
        }
        else {
            echo json_encode(array('code' => 410, 'html' =>'<h3>Herhangi Bir Varyasyon Bulunamadı</h3>','varyasyonstatus'=>$html['varyasyonstatus'] ));
        }
    }

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

    public function cloud_stock(){
        $details = $this->input->post('details');
        $warehouse_id = $details['warehouse_id'];
        $warehouse_details = warehouse_details($warehouse_id);
        if($this->aauth->get_user()->id == $warehouse_details->pers_id){
            $result = $this->warehouse->add_cloud_stock();
            echo json_encode(array('code' => $result['code'], 'message' =>$result['message']));
        }
        else {
            echo json_encode(array('code' => 410, 'message' =>'Depo Yetkilisi Değilsiniz'));

        }
    }
    public function clear_cloud(){
        $user_id =$this->aauth->get_user()->id;
        $result = $this->db->query("DELETE FROM  cloud_stock Where user_id=$user_id and durum=0");
        if($result){
            echo json_encode(array('code' => 200, 'message' =>'Başarıyla Silindi'));
        }
        else {
            echo json_encode(array('code' => 410, 'message' =>'Hata Aldınız'));
        }
    }
    public function get_cloud_list(){
        $tip = $this->input->post('tip');
        $user_id =$this->aauth->get_user()->id;
        $result =$this->db->query("SELECT * FROM cloud_stock Where tip=$tip and user_id=$user_id and durum=0");
        if($result->num_rows()){
            $details=[];
            foreach ($result->result() as $items){
                $details[]=[
                    'created_at'=>$items->created_at,
                    'durum'=>$items->durum,
                    'product_stock_code_id'=>$items->product_stock_code_id,
                    'fis'=>$items->fis,
                    'id'=>$items->id,
                    'loc'=>$items->loc,
                    'option_id'=>$items->option_id,
                    'option_value_id'=>$items->option_value_id,
                    'product_id'=>$items->product_id,
                    'qty'=>amountFormat_s($items->qty),
                    'qty_int'=>$items->qty,
                    'tip'=>$items->tip,
                    'unit_id'=>$items->unit_id,
                    'user_id'=>$items->user_id,
                    'warehouse_id'=>$items->warehouse_id,
                    'warehouse_name'=>warehouse_details($items->warehouse_id)->title,
                    'product_name'=>product_name($items->product_id),
                    'unit_name'=>units_($items->unit_id)['name'],
                    'varyasyon_html'=>varyasyon_string_name_new($items->product_stock_code_id)

                ];
            }
            echo json_encode(array('code' => 200, 'details'=>$details,'message' =>'Başarılı Bir Şekilde Veriler Getirildi'));
        }
        else {
            echo json_encode(array('code' => 410,'message' =>'Listenizde Ürün Bulunmamaktadır'));
        }
    }
}
