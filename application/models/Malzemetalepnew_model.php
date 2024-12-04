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





class Malzemetalepnew_model extends CI_Model
{
    var $table_news = 'araclar ';

    var $column_order = array('talep_form.code', 'talep_form.desc', 'geopos_employees.name', 'progress_status.name', 'geopos_projects.code', 'talep_form_status.name');

    var $column_search = array('talep_form.code', 'talep_form.desc', 'geopos_employees.name', 'progress_status.name', 'geopos_projects.code', 'talep_form_status.name');

    var $column_search_notes = array('desc', 'created_at', 'geopos_employees.name');
    var $column_search_history = array('desc', 'created_at', 'geopos_employees.name');

    var $order = array('id' => 'DESC');


    public function __construct()
    {
        parent::__construct();

    }

    public function create_save(){
        //$all_users = $this->input->post('all_users');
        $progress_status_id = $this->input->post('progress_status_id');
        $talep_eden_user_id = $this->input->post('talep_eden_user_id');
        $proje_id = $this->input->post('proje_id');
        $satinalma_birimi = $this->input->post('satinalma_birimi');
        $transfer_status = $this->input->post('transfer_status');
        $desc = $this->input->post('desc');
        $image_text = $this->input->post('image_text');
        $talep_type = $this->input->post('talep_type');
        $gider_durumu = $this->input->post('gider_durumu');
        $demirbas_id=0;
        $firma_demirbas_id=0;
        if($talep_type==3){
            $gider_durumu=1;
            $demirbas_id = $this->input->post('demirbas_id');
            $firma_demirbas_id = $this->input->post('firma_demirbas_id');
        }



        $talep_no = numaric(2);
        $data = array(
            'code' => $talep_no,
            'progress_status_id' => $progress_status_id,
            'talep_type' => $talep_type,
            'talep_eden_user_id' => $talep_eden_user_id,
            'satinalma_birimi' => $satinalma_birimi,
            'proje_id' => $proje_id,
            'desc' => $desc,
            'status' => 21,
            'transfer_status' => $transfer_status,
            'firma_demirbas_id' => $firma_demirbas_id,
            'demirbas_id' => $demirbas_id,
            'gider_durumu' => intval($gider_durumu),
            'aauth' => $this->aauth->get_user()->id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        if ($this->db->insert('talep_form', $data)) {
            $last_id = $this->db->insert_id();


            $this->db->set('deger', "deger+1",FALSE);
            $this->db->where('tip', 2);
            $this->db->update('numaric');
            if(time_day_get(1)){
                $data_time=
                    [
                        'mt_id'=>$last_id,
                        'status'=>1,
                        'start_time'=>n_gun_sonra(time_day_get(1))['start_date'],
                        'end_time'=>n_gun_sonra(time_day_get(1))['end_date'],

                    ];
                $this->db->insert('talep_time', $data_time);
            }
            //all_users
//            foreach ($all_users as $user_id){
//                $data_step = array(
//                    'user_id' => $user_id,
//                    'form_id' => $last_id,
//                );
//                $this->db->insert('talep_form_users', $data_step);
//            }
            //all_user
            //images
            $data_images = array(
                'image_text' => $image_text,
                'form_id' => $last_id,
            );
            $this->db->insert('talep_form_files', $data_images);
            //all_user

            $this->aauth->applog("Malzame Talebi Oluşturuldu  : Talep No : ".$talep_no, $this->aauth->get_user()->username);

            return [
                'status'=>1,
                'id'=>$last_id
            ];
        }
        else {
            return [
                'status'=>0,
                'id'=>0
            ];
        }
    }

    public function column_update()
    {

        $form_id = $this->input->post('form_id');
        $column = $this->input->post('column');
        $new_deger = $this->input->post('new_deger');
        $data_item_update = [
            $column=>$new_deger
        ];
        $this->db->where('id',$form_id);
        $this->db->set($data_item_update);
        if($this->db->update('talep_form', $data_item_update)){
            $this->talep_history($form_id,$this->aauth->get_user()->id,$column.' Değişiklik Yapıldı.');
            return [
                'status'=>1,
                'message'=>'Başarıyla Güncellendi'
            ];
            //stok transfer fişi oluşturma


        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }
    }

    public function talep_history($id,$user_id,$desc){
        date_default_timezone_set('Asia/Baku');
        $data_step = array(
            'talep_id' => $id,
            'user_id' => $user_id,
            'desc' => $desc,
        );
        $this->db->insert('talep_history', $data_step);
    }

    public function details_items($id){
        $this->db->select('*');
        $this->db->from('talep_form_products');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function details($id){
        $this->db->select('*');
        $this->db->from('talep_form');
        $this->db->where('talep_form.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    public function product_details($id){
        $talep_type = $this->details($id)->talep_type;
        if($talep_type==1){
            $status = $this->input->get('status');
            $this->db->select('talep_form_products.*,geopos_products.product_name,geopos_units.name as unit_name');
            $this->db->from('talep_form_products');
            $this->db->join('geopos_products','talep_form_products.product_id=geopos_products.pid');
            $this->db->join('geopos_units','talep_form_products.unit_id=geopos_units.id');
            $this->db->where('form_id',$id);
            $this->db->where('talep_form_products.status',$status);
            $query = $this->db->get();
            return $query->result();
        }
        elseif($talep_type==2){
            $this->db->select('talep_form_products.*,geopos_products.product_name,geopos_units.name as unit_name');
            $this->db->from('talep_form_products');
            $this->db->join('geopos_products','talep_form_products.product_id=geopos_products.pid');
            $this->db->join('geopos_units','talep_form_products.unit_id=geopos_units.id');
            $this->db->where('form_id',$id);
            $query = $this->db->get();
            return $query->result();
        }
        elseif($talep_type==3){

            if($id < 3193){
                $this->db->select('talep_form_products.*,geopos_cost.name as product_name,geopos_units.name as unit_name');
                $this->db->from('talep_form_products');
                $this->db->join('geopos_cost','talep_form_products.product_id=geopos_cost.id');
                $this->db->join('geopos_units','talep_form_products.unit_id=geopos_units.id');
                $this->db->where('form_id',$id);
                $query = $this->db->get();
                return $query->result();
            }else {
                $this->db->select('talep_form_products.*,demirbas_group.name as product_name,geopos_units.name as unit_name');
                $this->db->from('talep_form_products');
                $this->db->join('demirbas_group','talep_form_products.product_id=demirbas_group.id');
                $this->db->join('geopos_units','talep_form_products.unit_id=geopos_units.id');
                $this->db->where('form_id',$id);
                $query = $this->db->get();
                return $query->result();
            }


        }
        $this->db->select('talep_form_products.*,geopos_products.product_name,geopos_units.name as unit_name');
        $this->db->from('talep_form_products');
        $this->db->join('geopos_products','talep_form_products.product_id=geopos_products.pid');
        $this->db->join('geopos_units','talep_form_products.unit_id=geopos_units.id');
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function create_form_items(){
        $option_html='';
        $product_id = $this->input->post('product_id');
        $product_stock_code_id = $this->input->post('product_stock_code_id');
        $proje_stoklari_id = $this->input->post('proje_stoklari_id');
        $option_details = $this->input->post('option_details');
        $product_desc = $this->input->post('product_desc');
        $product_kullanim_yeri = $this->input->post('product_kullanim_yeri');
        $product_temin_date = $this->input->post('product_temin_date');
        $progress_status_id = $this->input->post('progress_status_id');
        $unit_id = $this->input->post('unit_id');
        $product_qty = $this->input->post('product_qty');
        $bolum_id = $this->input->post('bolum_id');
        $asama_id = $this->input->post('asama_id');
        $form_id = $this->input->post('form_id');
        $talep_details=$this->details($form_id);

        if($product_temin_date==''){
            $product_temin_date=date('Y-m-d');
        }



        $data = array(
            'product_id' => $product_id,
            'progress_status_id' => $progress_status_id,
            'product_desc' => $product_desc,
            'asama_id' => $asama_id,
            'bolum_id' => $bolum_id,
            'product_kullanim_yeri' => $product_kullanim_yeri,
            'product_temin_date' => $product_temin_date,
            'unit_id' => $unit_id,
            'product_qty' => $product_qty,
            'form_id' => $form_id,
            'proje_stoklari_id' => $proje_stoklari_id,
            'status' => $talep_details->status,
            'product_stock_code_id' => $product_stock_code_id,
            'aauth' => $this->aauth->get_user()->id
        );
        if ($this->db->insert('talep_form_products', $data)) {
            $talep_form_products_id = $this->db->insert_id();
            //varyasyon var ise
            if($option_details){

                $data_options = array(
                    'talep_form_product_id' => $talep_form_products_id,
                    'option_id' => option_sort($option_details[0]['option_id']),
                    'option_value_id' => option_sort($option_details[0]['option_value_id'])
                );
                $this->db->insert('talep_form_products_options', $data_options);
                //$option_html.=varyasyon_string_name($option_details[0]['option_id'],$option_details[0]['option_value_id']);


            }

            $varyasyon_name='';
            if(intval($product_stock_code_id)){
                $stock_code=$this->db->query("SELECT * FROM product_stock_code Where id=$product_stock_code_id");
                if($stock_code->num_rows()){
                    $varyasyon_name = $stock_code->row()->code;
                }
            }
            $option_html.=$varyasyon_name;

            $product_name= '';
            //varyasyon var ise
            if($talep_details->talep_type==1){
                $product_name= product_details_($product_id)->product_name;
            }
            elseif($talep_details->talep_type==2) {
                $product_name= product_details_($product_id)->product_name;
            }
            elseif($talep_details->talep_type==3) {
                $product_name= cost_details($product_id)->name;
            }


            $unit_name = units_($unit_id)['name'];
            $this->talep_history($form_id,$this->aauth->get_user()->id,'Ürün Eklendi : '.$product_name.' | '.$product_qty.' '.$unit_name);
            $last_id = $this->db->insert_id();
            $this->aauth->applog("Malzeme Talebine Ürünler Eklendi  : Talep ID : ".$form_id, $this->aauth->get_user()->username);

            return [
                'status'=>1,
                'id'=>$last_id,
                'talep_form_products_id'=>$talep_form_products_id,
                'product_name'=>$product_name,
                'qyt_birim'=>$product_qty.' '.units_($unit_id)['name'],
                'option_html'=>$option_html
            ];
        }
        else {
            return [
                'status'=>0,
                'id'=>0
            ];
        }
    }

    public function details_update($stok_id,$tip){

        $html = '';
        $title = '';
        $details_items = $this->details_items($stok_id);
        $form_id = $details_items->form_id;
        $details = $this->db->query("SELECT * FROM talep_form Where id=$form_id")->row();
        if($tip=='table_bolum_update'){
            $title='Bölüm Düzenle';
            $html='<form id="update_form">
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="name">Bölümler</label>
                                      <select name="line_bolum_id" class="form-control select-box"  id="line_bolum_id">
                                      <option value="0">Seçiniz</option>';
            foreach (all_bolum_proje($details->proje_id) as $blm)
            {
                $id=$blm->id;
                $name=$blm->name;
                if($details->bolum_id==$id){
                    $html.='<option selected value='.$id.'>'.$name.'</option>';
                }
                else {
                    $html.='<option value='.$id.'>'.$name.'</option>';
                }

            }

            $html.='</select>
                                    </div>
                                </div>
                            ';
        }
        elseif($tip=='table_asama_update'){
            $title='Aşama Düzenle';
            $html='<form id="update_form">
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="name">Proje Aşamaları</label>
                                      <select name="line_asama_id" class="form-control select-box" id="line_asama_id">
                                      <option value="0">Seçiniz</option>';
            foreach (asama_list_rows($details->proje_id,$details_items->bolum_id) as $blm)
            {
                $id=$blm['id'];
                $name=$blm['name'];
                if($details->asama_id==$id){
                    $html.='<option selected value='.$id.'>'.$name.'</option>';
                }
                else {
                    $html.='<option value='.$id.'>'.$name.'</option>';
                }

            }
            $html.='</select>
                                    </div>
                                </div>
                           ';
        }
        elseif($tip=='table_qty_update'){
            $title='Miktar ve Birim Düzenle';
            $proje_id = $details->proje_id;
            $html='<form id="update_form">
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="name">Stok Birimi</label>
                                      <select name="line_unit_id" class="form-control select-box" id="line_unit_id">
                                      <option value="0">Seçiniz</option>';
            foreach (units() as $blm)
            {
                $id=$blm['id'];
                $name=$blm['name'];
                if($details_items->unit_id==$id){
                    $html.='<option selected value='.$id.'>'.$name.'</option>';
                }
                else {
                    $html.='<option value='.$id.'>'.$name.'</option>';
                }

            }
            $html.='</select>
                                    </div>
                                    <div class="form-group col-md-12">
                                    <label for="name">Miktar</label>
                                    <input type="number" value="'.$details_items->product_qty.'" class="form-control" name="line_qty">
                                    </div>
                                       <div class="form-group col-md-12">
                                    <label for="name">Açıklama</label>
                                    <input type="text" value="" class="form-control" name="line_description">
                                    </div>
                                    ';

            $html.='</div>
                           ';
        }

        elseif($tip=='table_product_update'){
            $title='Ürün Düzenle';
            $product_name = product_name($details->product_id);
            $html='<form id="update_form">
                              <div class="form-row">
                                    <div class="form-group col-md-12">
                                    <label for="name">Stok Kartı</label>
                                             <select name="line_product_id" class="form-control" id="line_product_id">
                                                    <option value="'.$details->product_id.'">'.$product_name.'</option>
                                                </select>
                                    </div>
                                    <input type="hidden" name="line_option_id" id="line_option_id" value="">
                                    <input type="hidden" name="line_option_value_id" id="line_option_value_id" value="">
                                </div>
                           ';
        }
        elseif($tip=='table_price_update'){
            $title='Fiyat Düzenle';
            $html='<form id="update_form">
                              <div class="form-row">
                                    <div class="form-group col-md-12">
                                    <label for="name">Birim Fiyatı</label>
                                    <input type="number" value="'.$details->unit_price.'" class="form-control" name="line_price">
                                    </div>
                                </div>
                           ';
        }
        elseif($tip=='table_product_stock_code_update'){

            $title='Varyant Düzenle';
            $html.='<form id="update_form">';
            $html.=product_to_option_html_news_radio($details->product_id)['html'];
            $html.="</form>";
        }

        $html.='<input type="hidden" name="stok_id" value="'.$stok_id.'">';
        $html.='<input type="hidden" name="tip" value="'.$tip.'"> </form>';
        return [
            'status'=>1,
            'message'=>'Başarılı Bir Şekilde Veri Bulundu',
            'content'=>$html,
            'title'=>$title,
            'id'=>$stok_id
        ];
    }

    public function lineupdate(){

        $tip = $this->input->post('tip');
        $stok_id = $this->input->post('stok_id');
        $stock_code_id = $this->input->post('stock_code_id');
        $details = $this->details_items($stok_id);
        $form_id = $details->form_id;
        $details_form = $this->db->query("SELECT * FROM talep_form Where id=$form_id")->row();
        $proje_id = $details_form->proje_id;
        $user_id = $this->aauth->get_user()->id;
        $stok_kontrol = $this->db->query("SELECT * FROM geopos_projects Where id = $proje_id and stok_giris_durumu=0");
        if($stok_kontrol->num_rows()){
            if($tip=='table_bolum_update'){
                $new_bolum_id = $this->input->post('line_bolum_id');
                $data = [
                    'bolum_id'=>$new_bolum_id
                ];
                $this->db->where('id',$stok_id);
                $this->db->set($data);
                if ($this->db->update('talep_form_products', $data)) {
                    $asama_kontrol = $this->db->query("SELECT * FROM geopos_milestones Where bolum_id = $new_bolum_id and id = $details->asama_id");
                    if(!$asama_kontrol->num_rows()){
                        // eski aşama yeni bölüme ait değilse asama boşa düşürülmelidir.
                        $data_asama = [
                            'asama_id'=>0
                        ];
                        $this->db->where('id',$stok_id);
                        $this->db->set($data_asama);
                        $this->db->update('talep_form_products', $data_asama);
                        // eski aşama yeni bölüme ait değilse asama boşa düşürülmelidir.
                    }

                    return [
                        'status'=>1,
                        'message'=>'Başarılı Bir Şekilde Stok Güncellendi'
                    ];

                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                    ];
                }
            }
            elseif($tip=='table_asama_update'){
                $new_asama_id = $this->input->post('line_asama_id');
                $data = [
                    'asama_id'=>$new_asama_id
                ];
                $this->db->where('id',$stok_id);
                $this->db->set($data);
                if ($this->db->update('talep_form_products', $data)) {

                    return [
                        'status'=>1,
                        'message'=>'Başarılı Bir Şekilde Stok Güncellendi'
                    ];

                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                    ];
                }
            }
            elseif($tip=='table_qty_update'){

                $new_qty = $this->input->post('line_qty');
                $line_description = $this->input->post('line_description');


                $new_unit_id = $this->input->post('line_unit_id');
                $data = [
                    'product_qty'=>$new_qty,
                    'unit_id'=>$new_unit_id,
                ];
                $this->db->where('id',$stok_id);
                $this->db->set($data);
                if ($this->db->update('talep_form_products', $data)) {

                    return [
                        'status'=>1,
                        'message'=>'Başarılı Bir Şekilde Stok Güncellendi'
                    ];

                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                    ];
                }
            }
            elseif($tip=='table_price_update'){
                $new_price = $this->input->post('line_price');
                $data = [
                    'unit_price'=>$new_price
                ];
                $this->db->where('id',$stok_id);
                $this->db->set($data);
                if ($this->db->update('proje_stoklari', $data)) {
                    $title = 'Stoğun Birim Fiyatı Güncellendi Stok_ID  ' . $stok_id;
                    $this->add_activity($title, $details->proje_id);
                    $this->aauth->applog("Stoğun Birim Fiyatı Güncellendi Stok_ID: ".$stok_id, $this->aauth->get_user()->username);

                    return [
                        'status'=>1,
                        'message'=>'Başarılı Bir Şekilde Stok Güncellendi'
                    ];

                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                    ];
                }
            }
            elseif($tip=='table_product_update'){
                $new_product_id = $this->input->post('line_product_id');
                $new_option_id = $this->input->post('line_option_id');
                $new_option_value_id = $this->input->post('line_option_value_id');
                $data = [
                    'product_id'=>$new_product_id,
                    'option_id'=>$new_option_id,
                    'option_value_id'=>$new_option_value_id,
                ];
                $this->db->where('id',$stok_id);
                $this->db->set($data);
                if ($this->db->update('proje_stoklari', $data)) {
                    $title = 'Stok Güncellendi Stok_ID  ' . $stok_id;
                    $this->add_activity($title, $details->proje_id);
                    $this->aauth->applog("Stok Güncellendi Stok_ID: ".$stok_id, $this->aauth->get_user()->username);

                    return [
                        'status'=>1,
                        'message'=>'Başarılı Bir Şekilde Stok Güncellendi'
                    ];

                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                    ];
                }
            }
            elseif($tip=='table_product_stock_code_update'){
                $data = [
                    'product_stock_code_id'=>$stock_code_id,
                ];
                $this->db->where('id',$stok_id);
                $this->db->set($data);
                if ($this->db->update('proje_stoklari', $data)) {

                    // Onaylanmamış Taleplerde Ürün Değiştirme
                    $talepKontrol = $this->db->query("SELECT talep_form_products.id as id FROM talep_form_products INNER JOIN talep_form ON talep_form.id =talep_form_products.form_id  Where talep_form_products.proje_stoklari_id=$stok_id and talep_form.status IN (17,1) and bildirim_durumu=0");
                    if($talepKontrol->num_rows()){
                        foreach ($talepKontrol->result() as $itemValues){
                            $talep_form_products_id = $itemValues->id;
                            $dataPost = [
                                'product_stock_code_id'=>$stock_code_id,
                            ];
                            $this->db->where('id',$talep_form_products_id);
                            $this->db->set($dataPost);
                            $this->db->update('talep_form_products', $dataPost);
                        }
                    }
                    // Onaylanmamış Taleplerde Ürün Değiştirme
                    $title = 'Stok Varyant Güncellendi Stok_ID  ' . $stok_id;
                    $this->add_activity($title, $details->proje_id);
                    $this->aauth->applog("Stok Varyant Güncellendi Stok_ID: ".$stok_id, $this->aauth->get_user()->username);

                    return [
                        'status'=>1,
                        'message'=>'Başarılı Bir Şekilde Stok Güncellendi'
                    ];

                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                    ];
                }
            }
        }
        else {
            if($tip=='table_qty_update'){
                $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $proje_id and (  proje_sorumlusu_id=$user_id or proje_muduru_id=$user_id or muhasebe_muduru_id=$user_id or genel_mudur_id=$user_id)")->num_rows();

                if($yetkili_kontrol){
                    $line_artiq_stok = $this->input->post('line_artiq_stok');
                    $new_qty = $this->input->post('line_qty');
                    $line_description = $this->input->post('line_description');


                    if($line_artiq_stok=='on'){
                        $eski_stoq = $details->qty;
                        if($eski_stoq < $new_qty){
                            $artiq_stoq_qty = floatval($new_qty)-$eski_stoq;
                            $data_artiq = [
                                'stok_id'=>$stok_id,
                                'qty'=>$artiq_stoq_qty,
                                'old_qty'=>$eski_stoq,
                                'new_qty'=>$new_qty,
                                'description'=>$line_description,
                            ];
                            $this->db->insert('proje_stoklari_artiq_stok', $data_artiq);
                        }
                    }



                    $new_unit_id = $this->input->post('line_unit_id');
                    $data = [
                        'qty'=>$new_qty,
                        'unit_id'=>$new_unit_id,
                        'description'=>$line_description,
                    ];
                    $this->db->where('id',$stok_id);
                    $this->db->set($data);
                    if ($this->db->update('proje_stoklari', $data)) {
                        $title = 'Stoğun Miktar ve Birim Güncellendi Stok_ID  ' . $stok_id;
                        $this->add_activity($title, $details->proje_id);
                        $this->aauth->applog("Stoğun Miktar ve Birim Güncellendi Stok_ID: ".$stok_id, $this->aauth->get_user()->username);

                        return [
                            'status'=>1,
                            'message'=>'Başarılı Bir Şekilde Stok Güncellendi'
                        ];

                    }
                    else {
                        return [
                            'status'=>0,
                            'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                        ];
                    }
                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Projenin Stok Girişi ve Düzenleme Durumu Kapatılmıştır.Artık Stok Girişini Ancak Yetkililer Yapabilir',
                        'id'=>0
                    ];
                }
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Projenin Stok Girişi ve Düzenleme Durumu Kapatılmıştır.İlave Stok Girişi Yapınız',
                    'id'=>0
                ];
            }

        }
    }

}