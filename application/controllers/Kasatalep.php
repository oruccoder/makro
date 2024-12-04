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

class Kasatalep Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('Kasatalep_model', 'model');
    }
    public function index()
    {
        if (!$this->aauth->premission(70)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Kasa Avans Talep Formu';
        $this->load->view('fixed/header', $head);
        $this->load->view('kasatalep/index');
        $this->load->view('fixed/footer');
    }


    public function all_list()
    {
        if (!$this->aauth->premission(68)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Avans Talepleri';
        $this->load->view('fixed/header', $head);
        $this->load->view('kasatalep/all_list');
        $this->load->view('fixed/footer');
    }

    public function ajax_list(){

        $list = $this->model->list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $status_details = progress_status_details($prd->progress_status_id);

            $toplam_tutar=0;
            foreach ($this->model->product_details($prd->id) as $details){
                $toplam_tutar+=$details->total;
            }

            $color = $status_details->color;
            $text_color = $status_details->text_color;

            $style = "background-color:$color;color:$text_color";

            $cancel = "<button class='btn btn-danger talep_sil' talep_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
            $view = "<a class='btn btn-success view' href='/kasatalep/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";


            $no++;
            $row = array();
            $row[] = $prd->code;
            $row[] = $prd->pers_name;
            $row[] = $prd->progress_name;
            $row[] = $prd->created_at;
            $row[] = $prd->proje_name;
            $row[] = $prd->st_name;
            $row[] =amountFormat($toplam_tutar);
            $row[] =$cancel.$view;
            $row[] =$style;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all(),
            "recordsFiltered" => $this->model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function create_save(){
        if (!$this->aauth->premission(70)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->create_save();
            if($result['status']){

                echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Talep Oluşturuldu",'index'=>'/kasatalep/view/'.$result['id']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
            }
        }


    }

    public function status_upda(){
        if (!$this->aauth->premission(70)->write) {
            echo json_encode(array('status' => 410, 'message' =>'İptal Etmek İçin Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $file_id = $this->input->post('file_id');
            $desc = $this->input->post('desc');
            $details_ = $this->model->details($file_id);
            if($details_->status==10){
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>"Daha Önceden İptal Edilmiş Form Tekrar İptal Edilemez"));
            }
            else {
                $result = $this->model->status_upda();
                if($result['status']){

                    echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Güncellendi"));
                    $this->db->trans_complete();
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
                }
            }
        }



    }

    public function update_form(){
        if (!$this->aauth->premission(70)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->update_form();
            if($result['status']){

                echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Güncellendi"));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
            }
        }

    }

    public function file_handling(){
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

    public function view($id)
    {
        if (!$this->aauth->premission(70)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Talep Görüntüleme';
        $data['items']= $this->model->product_details($id);
        $data['file_details']= $this->model->file_details($id);
        $data['details']= $this->model->details($id);
        $personel_id = $data['details']->personel_id;

        $toplam_tutar=0;
        foreach ($data['items'] as $details){
            $toplam_tutar+=$details->total;
        }



        $data['odeme_details']=[
            'toplam_tutar'=>amountFormat($toplam_tutar),
            'toplam_tutar_float'=>$toplam_tutar,
            'cari'=>personel_details_full($data['details']->personel_id)['name'],
        ];
        $this->load->view('fixed/header', $head);

        $this->load->view('kasatalep/view',$data);
        $this->load->view('fixed/footer');
    }

    public function upload_file(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $image_text = $this->input->post('image_text');
        $data_images = array(
            'user_id' => $this->aauth->get_user()->id,
            'image_text' => $image_text,
            'form_id' => $id,
        );
        if($this->db->insert('talep_form_personel_files', $data_images)){
            $this->aauth->applog("Gider Talebine File Yüklendi  : Talep ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Yüklendi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }

    }
    public function delete_file(){
        $this->db->trans_start();
        $id = $this->input->post('file_id');
        if($this->db->delete('talep_form_personel_files', array('id' => $id))){
            $this->aauth->applog("Gider Talebinden File Silindi  : File ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Silindi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }

    }
    public function search_products(){
        $where='';
        $data=[];
        $units=units();
        $cat_id = $this->input->post('cat_id');
        $keyword = $this->input->post('keyword');


        if($keyword && $cat_id){
            $where = " (`name` LIKE '%$keyword%')  AND parent_id=$cat_id";
        }
        else if($cat_id) {
            $where = "parent_id=$cat_id";
        }
        else if($keyword) {
            $where = "(`name` LIKE '%$keyword%')  AND parent_id!=0";

        }
        $query = $this->db->query("SELECT * FROM `geopos_cost` WHERE $where   LIMIT 30");
        if($query->num_rows()){
            foreach ($query->result() as $items){

                $data[]=[
                    'product_id'=>$items->id,
                    'product_name'=>$items->name,
                    'unit_id'=>$items->unit,
                    'p_unit_id'=>$items->unit,
                    'unit_name'=>units_($items->unit)['name'],
                ];

            }
            echo json_encode(array('status' => 'Success','products'=>$data,'units'=>$units));
        }
        else {
            echo json_encode(array('status' => 'Error', 'message' =>"Ürün Bulunamadı"));
        }


    }

    public function create_form_items(){
        $this->db->trans_start();
        $result = $this->model->create_form_items();
        if($result['status']){
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Kayıt Edildi",'product_name'=>$result['product_name'],'qyt_birim'=>$result['qyt_birim'],'id'=>$result['id'],'talep_form_products_id'=>$result['talep_form_products_id']));
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
        $details = $this->db->query("SELECT * FROM talep_form_personel_products Where id=$id")->row();
        $type = $this->input->post('type');
        $product_name = cost_details($details->cost_id)->name;

        $details_form = $this->model->details($details->form_id);
        $user_id  = $this->aauth->get_user()->id;
        $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $details_form->proje_id and (  proje_sorumlusu_id=$user_id or proje_muduru_id=$user_id or muhasebe_muduru_id=$user_id or genel_mudur_id=$user_id)")->num_rows();

        if($yetkili_kontrol) {
            if($type==1){
                $this->model->talep_history($details->form_id,$this->aauth->get_user()->id,$product_name.' Ürünü Kaldırıldı');
            }

            if($this->db->delete('talep_form_personel_products', array('id' => $id))){

                $this->aauth->applog("Personel Avans Talebinden Ürün Silindi  :  ID : ".$id, $this->aauth->get_user()->username);
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success','message'=>'Başarıyla Silindi'));
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' => "Yetkiniz Bulunmamaktadır"));
        }

    }

    public function update_item_form(){
        $this->db->trans_start();
        $id = $this->input->post('item_id');
        $item_price = $this->input->post('item_price');
        $item_qty = $this->input->post('item_qty');



        $details = $this->db->query("SELECT * FROM talep_form_personel_products Where id=$id")->row();

        $details_form = $this->model->details($details->form_id);
        $type = $this->input->post('type');
        $product_name = cost_details($details->cost_id)->name;
        $user_id  = $this->aauth->get_user()->id;
        $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $details_form->proje_id and (  proje_sorumlusu_id=$user_id or proje_muduru_id=$user_id or muhasebe_muduru_id=$user_id or genel_mudur_id=$user_id)")->num_rows();
        if($yetkili_kontrol) {
            if ($type == 1) {
                $this->model->talep_history($details->form_id, $this->aauth->get_user()->id, $product_name . ' Ürünü Güncellendi. Miktar : ' . $item_qty . ' Fiyat : ' . $item_price);
            }

            $data_update_product = array(
                'product_qty' => $item_qty,
                'price' => $item_price,
                'total' => floatval($item_price) * floatval($item_qty),
            );
            $this->db->set($data_update_product);
            $this->db->where('id', $id);

            if ($this->db->update('talep_form_personel_products', $data_update_product)) {

                $this->aauth->applog("Personel Avans Talebinden Ürün Güncellendi  :  ID : " . $id, $this->aauth->get_user()->username);
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success', 'message' => 'Başarıyla Güncellendi'));
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun." . ' Hata '));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' => "Yetkiniz Bulunmamaktadır"));
        }

    }


    public function update_form_payment(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $personel_id = $this->input->post('personel_id');

        $details_form = $this->model->details($id);
        $user_id  = $this->aauth->get_user()->id;
        $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $details_form->proje_id and (  muhasebe_muduru_id=$user_id or genel_mudur_id=$user_id)")->num_rows();
        if($yetkili_kontrol) {

            $personel_name = personel_details_full($personel_id)['name'];
            $this->model->talep_history($id, $this->aauth->get_user()->id, ' Talep Güncellendi. Ödeme Emri Verildi : ' . $personel_name);
            $data_talep_updata=
                [
                    'payment_personel_id'=>$personel_id,
                    'status'=>12,
                ];
            $this->db->where('id',$id);
            $this->db->set($data_talep_updata);


            if ($this->db->update('talep_form_personel', $data_talep_updata)) {

                $mesaj=$details_form->code.' Numaralı Avans Talep Formuna Ödeme Emri Verilmiştir';
                $this->model->send_mail($personel_id,'Avans Talep Onayı',$mesaj);

                $this->aauth->applog("Personel Avans Talebinden Güncellendi  :  ID : " . $id, $this->aauth->get_user()->username);
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success', 'message' => 'Başarıyla Güncellendi'));
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun." . ' Hata '));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' => "Yetkiniz Bulunmamaktadır"));
        }

    }

    public function form_bildirim_olustur(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $type = $this->input->post('type');
        $user_id=$this->aauth->get_user()->id;
        if($type==1){


            $talep_kontrol  = $this->db->query("SELECT * FROM `talep_form_personel` where id=$id and aauth=$user_id")->num_rows();
            if($talep_kontrol){
                $details = $this->model->details($id);
                $data = array(
                    'bildirim_durumu' => 1,
                );
                $this->db->set($data);
                $this->db->where('id', $id);
                if ($this->db->update('talep_form_personel', $data)) {

                    $users_ = onay_sort(5,$details->proje_id,$details->personel_id);
                    if($users_){
                        foreach ($users_ as $items){
                            $staff=0;
                            if($items['sort']==1){
                                // bildirim maili at
                                $mesaj=$details->code.' Numaralı Avans Talep Formu Onayınızı Beklemektedir';
                                $this->model->send_mail($items['user_id'],' Avans Talep Onayı',$mesaj);
                                // bildirim maili at
                                $staff=1;
                            }
                            $data_onay = array(
                                'talep_id' => $id,
                                'type' => $type,
                                'staff' => $staff,
                                'sort' => $items['sort'],
                                'user_id' => $items['user_id'],
                            );
                            $this->db->insert('talep_onay_personel_new', $data_onay);
                        }

                        $this->model->talep_history($id,$this->aauth->get_user()->id,'Onay İşlemi Başlatıldı');
                        $this->aauth->applog("Avans Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);
                        $this->db->trans_complete();
                        echo json_encode(array('status' => 'Success','message'=>'Başarıyla Bildirim Başlatıldı'));

                    }
                    else {

                        echo json_encode(array('status' => 'Error', 'message' =>"Projenize Yetkili Kişiler Atanmamıştır.Bu Sebeple İşlem Yapamazsınız."));
                        $this->db->trans_rollback();

                    }



                }
                else {

                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
                }

            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Yetkiniz Bulunmamaktadır."));
            }
        }


    }


    public function onay_olustur(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $progress_status_id = $this->input->post('progress_status_id');
        $details = $this->model->details($id);
        $type = $this->input->post('type');
        $product_details = $this->input->post('product_details');
        foreach ($product_details as $items){
            $item_id = $items['item_id'];
            $item_details=$this->db->query("SELECT * FROM  talep_form_personel_products where id =$item_id ")->row();
            $product_name = cost_details($item_details->cost_id)->name;
            $data_item_update = [
                'product_qty'=>$items['item_qty'],
                'price'=>$items['item_price'],
                'total'=>floatval($items['item_price'])*floatval($items['item_qty']),
            ];
            $this->db->where('id',$items['item_id']);
            $this->db->set($data_item_update);
            $this->db->update('talep_form_personel_products', $data_item_update);

            $data_talep_updata=['progress_status_id'=>$progress_status_id];
            $this->db->where('id',$id);
            $this->db->set($data_talep_updata);
            $this->db->update('talep_form_personel', $data_talep_updata);

            $progress_status_details = progress_status_details($progress_status_id);
            $this->model->talep_history($id,$this->aauth->get_user()->id,$product_name.' Ürünü İçin Yeni Miktar : '.$items['item_qty'].' Yeni Durum : '.$progress_status_details->name);
        }


        $new_id=0;
        $new_user_id=0;
        $new_id_control = $this->db->query("SELECT * FROM `talep_onay_personel_new` Where type=$type and talep_id=$id and staff=0 and status is Null ORDER BY `talep_onay_personel_new`.`id` ASC LIMIT 1");
        if($new_id_control->num_rows()){
            $new_id = $new_id_control->row()->id;
            $new_user_id = $new_id_control->row()->user_id;
        }
        $data = array(
            'status' => 1,
            'staff' => 0,
        );

        $this->db->where('user_id',$this->aauth->get_user()->id);
        $this->db->where('staff',1);
        $this->db->where('type',$type);
        $this->db->set($data);
        $this->db->where('talep_id', $id);
        if ($this->db->update('talep_onay_personel_new', $data)) {

            $this->model->talep_history($id,$this->aauth->get_user()->id,'Onay Verildi');
            if($new_id){

                $mesaj=$details->code.' Numaralı Avans Talep Formu Onayınızı Beklemektedir';
                $this->model->send_mail($new_user_id,'Avans Talep Onayı',$mesaj);

                // Bir Sonraki Onay
                $data_new=array(
                    'staff'=>1,
                );
                $this->db->where('id',$new_id);
                $this->db->set($data_new);
                $this->db->update('talep_onay_personel_new', $data_new);
                // Bir Sonraki Onay
            }
            else {
//                $mesaj=$details->code.' Numaralı Avans Talep Formu Onaylanmıştır. İşleminiz Ödeme Emri Beklemektedir';
//                $this->model->send_mail($details->talep_eden_pers_id,'Avans Talep Formu',$mesaj);
                //Ödeme Bekliyor
                $data_Form=array(
                    'status'=>11,
                );
                //Ödeme Bekliyor
                $this->db->set($data_Form);
                $this->db->where('id', $id);
                $this->db->update('talep_form_personel', $data_Form);
                //Kontrol Bekliyor
            }

            $this->aauth->applog("Avans Talebine Onay Verildi :  ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Onay Verildi'));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));

        }

    }

    public function customer_alacak_update(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $alacak_tutar = $this->input->post('alacak_tutar');
        $details_form = $this->model->details($id);
        $not = $this->input->post('not').' '.$details_form->code.' İstinaden Alacaklandırma';
        $invoice_type_id = 39;

        $user_id  = $this->aauth->get_user()->id;
        if($user_id==$details_form->payment_personel_id) {
            $data = array(
                'csd' => $details_form->personel_id,
                'payer' => personel_details_full($details_form->personel_id)['name'],
                'acid' => 0, //hesapID ekleneck
                'account' => 'Kasasız İşlem',
                'total' => $alacak_tutar,
                'invoice_type_id'=>$invoice_type_id,
                'invoice_type_desc'=>invoice_type_desc($invoice_type_id),
                'method' => $details_form->method,
                'eid' => $this->aauth->get_user()->id, //user_id
                'notes' => $not,
                'proje_id' => $details_form->proje_id,
            );
            if($this->db->insert('geopos_invoices', $data)){
                $data_talep_updata=
                    [
                        'alacak_durum'=>1,
                    ];
                $this->db->where('id',$id);
                $this->db->set($data_talep_updata);
                if ($this->db->update('talep_form_personel', $data_talep_updata)) {
                    $this->model->talep_history($id, $this->aauth->get_user()->id, ' Personel Alacaklandırıldı : '.amountFormat($alacak_tutar));
                    $this->db->trans_complete();
                    echo json_encode(array('status' => 'Success', 'message' => 'Başarıyla Güncellendi'));
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun." . ' Hata '));
                }
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun." . ' Hata '));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' => "Yetkiniz Bulunmamaktadır"));
        }
    }
    public function customer_payment_update(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $account_id = $this->input->post('account_id');
        $alacak_tutar = $this->input->post('alacak_tutar');
        $details_form = $this->model->details($id);
        $not = $this->input->post('not').' '.$details_form->code.' İstinaden Ödeme';
        $invoice_type_id = 14; //Personel Maaş Avansı

        $user_id  = $this->aauth->get_user()->id;
        if($user_id==$details_form->payment_personel_id) {
            $data = array(
                'csd' => $details_form->personel_id,
                'payer' => personel_details_full($details_form->personel_id)['name'],
                'acid' => $account_id, //hesapID ekleneck
                'account' => account_details($account_id)->holder,
                'total' => $alacak_tutar,
                'invoice_type_id'=>$invoice_type_id,
                'invoice_type_desc'=>invoice_type_desc($invoice_type_id),
                'method' => $details_form->method,
                'eid' => $this->aauth->get_user()->id, //user_id
                'notes' => $not,
                'proje_id' => $details_form->proje_id,
            );
            if($this->db->insert('geopos_invoices', $data)){
                $data_talep_updata=
                    [
                        'odeme_durum'=>1,
                        'status'=>9,
                    ];
                $this->db->where('id',$id);
                $this->db->set($data_talep_updata);
                if ($this->db->update('talep_form_personel', $data_talep_updata)) {
                    $this->model->talep_history($id, $this->aauth->get_user()->id, ' Ödeme Yapıldı : '.amountFormat($alacak_tutar));
                    $this->db->trans_complete();
                    echo json_encode(array('status' => 'Success', 'message' => 'Başarıyla Güncellendi'));
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun." . ' Hata '));
                }
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun." . ' Hata '));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' => "Yetkiniz Bulunmamaktadır"));
        }
    }


}