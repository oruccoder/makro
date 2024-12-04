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

class Customeravanstalep Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('Customeravanstalep_model', 'model');
    }
    public function index()
    {
        if (!$this->aauth->premission(49)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $data['totals']=amountFormat($this->model->form_total_bekleyen());
        $data['bank']=amountFormat($this->model->form_total_bekleyen_method(3));
        $data['nakit']=amountFormat($this->model->form_total_bekleyen_method(1));
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Cari Avans Talep Formu';
        $this->load->view('fixed/header', $head);
        $this->load->view('customeravanstalep/index',$data);
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
            $view = "<a class='btn btn-success view' href='/customeravanstalep/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";

            $odeme_total = $this->model->odeme_total($prd->id);
            $form_total = $this->model->form_total($prd->id);
            $kalan=floatval($form_total)-floatval($odeme_total);

            $no++;
            $row = array();
            $row[] = $prd->code;
            $row[] = $prd->company;
            $row[] = $prd->progress_name;
            $row[] = $prd->created_at;
            $row[] = $prd->pers_name;
            $row[] = $prd->proje_name;
            $row[] = $prd->st_name;
            $row[] = amountFormat($toplam_tutar);
            $row[] = amountFormat($kalan);
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
        if (!$this->aauth->premission(49)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->create_save();
            if($result['status']){

                echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Talep Oluşturuldu",'index'=>'/customeravanstalep/view/'.$result['id']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
            }
        }


    }

    public function update_form(){
        if (!$this->aauth->premission(49)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Güncellemek İçin Yetkiniz Bulunmamaktadır'));

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
        if (!$this->aauth->premission(49)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }

        $data['details']= $this->model->details($id);

        $data['note_list']=new_list_note(3,$id);

        if (! $data['details']) {

            exit('<h3>Talep Bulunamadı</h3>');

        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Avans Talep Görüntüleme';
        $data['items']= $this->model->product_details($id);
        $data['file_details']= $this->model->file_details($id);

        $cari_id = $data['details']->cari_id;

        $toplam_tutar=0;
        foreach ($data['items'] as $details){
            $toplam_tutar+=$details->total;
        }


        $odeme_total = $this->model->odeme_total($id);
        $form_total = $this->model->form_total($id);
        $data['kalan']=floatval($form_total)-floatval($odeme_total);

        $data['odeme_details']=[
            'toplam_tutar'=>amountFormat($toplam_tutar),
            'toplam_tutar_float'=>$toplam_tutar,
            'cari'=>customer_details($data['details']->cari_id)['company'],
        ];





        $data['avans_details']='';
        $data['avans_details_old']='';
        // avans detayı


        if($data['details']->file_id){
            $data['avans_details_old']=cari_proje_bakiye_kontrol($id,$data['details']->file_id);

            $data['avans_details']=$this->db->query("SELECT * FROM talep_form_bakiye Where talep_id=$id ORDER BY id ASC")->result();
        }


        // avans detayı


        $this->load->view('fixed/header', $head);
        $this->load->view('customeravanstalep/view',$data);
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
        if($this->db->insert('talep_form_customer_files', $data_images)){
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
        if($this->db->delete('talep_form_customer_files', array('id' => $id))){
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

    public function status_upda(){
        if (!$this->aauth->premission(49)->write) {
            echo json_encode(array('status' => 410, 'message' =>'İptal Etmek İçin Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $file_id = $this->input->post('file_id');
            $desc = $this->input->post('desc');
            $details_ = $this->model->details($file_id);
            if($details_->status==10){
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Daha Önceden İptal Edilmiş Form Tekrar İptal Edilemez"));
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


    public function delete_item_form(){
        $this->db->trans_start();
        $id = $this->input->post('item_id');
        $details = $this->db->query("SELECT * FROM talep_form_customer_products Where id=$id")->row();
        $type = $this->input->post('type');
        $product_name = cost_details($details->cost_id)->name;

        $details_form = $this->model->details($details->form_id);
        $user_id  = $this->aauth->get_user()->id;
        $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $details_form->proje_id and (  proje_sorumlusu_id=$user_id or proje_muduru_id=$user_id or muhasebe_muduru_id=$user_id or genel_mudur_id=$user_id)")->num_rows();

        if($yetkili_kontrol) {
            if($type==1){
                $this->model->talep_history($details->form_id,$this->aauth->get_user()->id,$product_name.' Ürünü Kaldırıldı');
            }

            if($this->db->delete('talep_form_customer_products', array('id' => $id))){

                $this->aauth->applog("Cari Gider Talebinden Ürün Silindi  :  ID : ".$id, $this->aauth->get_user()->username);
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



        $details = $this->db->query("SELECT * FROM talep_form_customer_products Where id=$id")->row();

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

            if ($this->db->update('talep_form_customer_products', $data_update_product)) {

                $this->aauth->applog("Cari Gider Talebinden Ürün Güncellendi  :  ID : " . $id, $this->aauth->get_user()->username);
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success', 'message' => 'Başarıyla Güncellendi'));
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun." . ' Hata '));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' => "Yetkiniz Bulunmamaktadır.Proje Yetkileleri Düzenleme Yapabilir"));
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


            if ($this->db->update('talep_form_customer', $data_talep_updata)) {

                $mesaj=$details_form->code.' Numaralı Gider Talep Formuna Ödeme Emri Verilmiştir';
                //$this->model->send_mail($personel_id,'Gider Talep Onayı',$mesaj);

                $this->aauth->applog("Cari Gider Talebinden Güncellendi  :  ID : " . $id, $this->aauth->get_user()->username);
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
        if($type==2){


            $talep_kontrol  = $this->db->query("SELECT * FROM `talep_form_customer` where id=$id and aauth=$user_id")->num_rows();
            if($talep_kontrol){
                $details = $this->model->details($id);
                $talep_kontrol2  = $this->db->query("SELECT * FROM `talep_form_customer` where id=$id and file_id is null")->num_rows();
                if($talep_kontrol2){
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Avans Hangi Dosyaya İstinaden Yapılıyor İse o Dosyayı Seçmelisiniz."));
                    exit();
                }

                $data = array(
                    'bildirim_durumu' => 1,
                );
                $this->db->set($data);
                $this->db->where('id', $id);
                if ($this->db->update('talep_form_customer', $data)) {

                    $users_ = onay_sort(4,$details->proje_id);
                    if($users_){
                        foreach ($users_ as $items){
                            $staff=0;
                            if($items['sort']==1){
                                // bildirim maili at
                                $mesaj=$details->code.' Numaralı Avans Talep Formu Onayınızı Beklemektedir';
                                //$this->model->send_mail($items['user_id'],' Avans Talep Onayı',$mesaj);
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
                            $this->db->insert('talep_onay_customer_new', $data_onay);
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
            $item_details=$this->db->query("SELECT * FROM  talep_form_customer_products where id =$item_id ")->row();
            $product_name = cost_details($item_details->cost_id)->name;
            $data_item_update = [
                'product_qty'=>$items['item_qty'],
                'price'=>$items['item_price'],
                'total'=>floatval($items['item_price'])*floatval($items['item_qty']),
            ];
            $this->db->where('id',$items['item_id']);
            $this->db->set($data_item_update);
            $this->db->update('talep_form_customer_products', $data_item_update);

            $data_talep_updata=['progress_status_id'=>$progress_status_id];
            $this->db->where('id',$id);
            $this->db->set($data_talep_updata);
            $this->db->update('talep_form_customer', $data_talep_updata);

            $progress_status_details = progress_status_details($progress_status_id);
            $this->model->talep_history($id,$this->aauth->get_user()->id,$product_name.' Ürünü İçin Yeni Miktar : '.$items['item_qty'].' Yeni Durum : '.$progress_status_details->name);
        }


        $new_id=0;
        $new_user_id=0;
        $new_id_control = $this->db->query("SELECT * FROM `talep_onay_customer_new` Where type=$type and talep_id=$id and staff=0 and status is Null ORDER BY `talep_onay_customer_new`.`id` ASC LIMIT 1");
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
        if ($this->db->update('talep_onay_customer_new', $data)) {

            $this->model->talep_history($id,$this->aauth->get_user()->id,'Onay Verildi');
            if($new_id){

                $mesaj=$details->code.' Numaralı Gider Talep Formu Onayınızı Beklemektedir';
               // $this->model->send_mail($new_user_id,'Gider Talep Onayı',$mesaj);

                // Bir Sonraki Onay
                $data_new=array(
                    'staff'=>1,
                );
                $this->db->where('id',$new_id);
                $this->db->set($data_new);
                $this->db->update('talep_onay_customer_new', $data_new);
                // Bir Sonraki Onay
            }
            else {
//                $mesaj=$details->code.' Numaralı Gider Talep Formu Onaylanmıştır. İşleminiz Ödeme Emri Beklemektedir';
//                $this->model->send_mail($details->talep_eden_pers_id,'Gider Talep Formu',$mesaj);
                //Ödeme Bekliyor
                $data_Form=array(
                    'status'=>11,
                );
                //Ödeme Bekliyor
                $this->db->set($data_Form);
                $this->db->where('id', $id);
                $this->db->update('talep_form_customer', $data_Form);
                //Kontrol Bekliyor
            }

            $this->aauth->applog("Gider Talebine Onay Verildi :  ID : ".$id, $this->aauth->get_user()->username);
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
                'csd' => $details_form->cari_id,
                'payer' => customer_details($details_form->cari_id)['company'],
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
                if ($this->db->update('talep_form_customer', $data_talep_updata)) {
                    $this->model->talep_history($id, $this->aauth->get_user()->id, ' Cari Alacaklandırıldı : '.amountFormat($alacak_tutar));
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
        $tip = $this->input->post('tip');
        $account_id = $this->input->post('account_id');
        $cach_personel = $this->input->post('cach_personel');
        $alacak_tutar = $this->input->post('alacak_tutar');
        $details_form = $this->model->details($id);
        $not = $this->input->post('not').' '.$details_form->code.' İstinaden Ödeme';
        $invoice_type_id = 73; //Tedarkçiye Avans
        $role_id = $this->aauth->get_user()->roleid;
        $form_total = $this->model->form_total($id);
        $user_id  = $this->aauth->get_user()->id;
        if($tip=='muhasebe'){
            if($role_id==1 ||  $role_id==48 ||  $role_id==6){
                $data = array(
                    'csd' => $details_form->cari_id,
                    'payer' => customer_details($details_form->cari_id)['company'],
                    'acid' => $account_id, //hesapID ekleneck
                    'account' => account_details($account_id)->holder,
                    'total' => $alacak_tutar,
                    'invoice_type_id'=>$invoice_type_id,
                    'invoice_type_desc'=>invoice_type_desc($invoice_type_id),
                    'method' => $details_form->method,
                    'eid' => $this->aauth->get_user()->id, //user_id
                    'notes' => $not,
                    'loc' => $this->session->userdata('set_firma_id'),
                    'proje_id' => $details_form->proje_id,
                );
                if($this->db->insert('geopos_invoices', $data)){
                    $last_id_invoice_id = $this->db->insert_id();
                    $data_pay = array(
                        'form_id'=>$id,
                        'transaction_id'=>$last_id_invoice_id,
                        'total'=>$alacak_tutar,
                        'tip'=>2,
                        'cach_personel'=>$cach_personel,
                    );
                    $this->db->insert('talep_form_customer_new_payment', $data_pay);
                    $odeme_total = $this->model->odeme_total($id);


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
                echo json_encode(array('status' => 'Error', 'message' => "Yetkiniz Bulunmamaktadır"));
            }
        }
        else {
            if($user_id==$details_form->payment_personel_id) {
                $data = array(
                    'csd' => $details_form->cari_id,
                    'payer' => customer_details($details_form->cari_id)['company'],
                    'acid' => $account_id, //hesapID ekleneck
                    'account' => account_details($account_id)->holder,
                    'total' => $alacak_tutar,
                    'invoice_type_id'=>$invoice_type_id,
                    'invoice_type_desc'=>invoice_type_desc($invoice_type_id),
                    'method' => $details_form->method,
                    'eid' => $this->aauth->get_user()->id, //user_id
                    'notes' => $not,
                    'term' => $id,
                    'loc' => $this->session->userdata('set_firma_id'),
                    'proje_id' => $details_form->proje_id,
                );
                if($this->db->insert('geopos_invoices', $data)){
                    $last_id = $this->db->insert_id();
                    $data_pay = array(
                        'form_id'=>$id,
                        'transaction_id'=>$last_id,
                        'tip'=>2,
                        'total'=>$alacak_tutar,
                        'cach_personel'=>$cach_personel,
                    );
                    $this->db->insert('talep_form_customer_new_payment', $data_pay);
                    $odeme_total = $this->model->odeme_total($id);

                    if($form_total == $odeme_total) {
                        $data_talep_updata =
                            [
                                'odeme_durum' => 1,
                                'status' => 9,
                            ];
                        $this->db->where('id', $id);
                        $this->db->set($data_talep_updata);
                        $this->db->update('talep_form_customer', $data_talep_updata);
                    }

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
                echo json_encode(array('status' => 'Error', 'message' => "Yetkiniz Bulunmamaktadır"));
            }
        }

    }

    public function cari_proje_bakiye_kontrol(){
        $id = $this->input->post('talep_id');
        $file_id = $this->input->post('file_id');
        $details = $this->model->details($id);
        $avans_type=$details->avans_type;
        $cari_id=$details->cari_id;
        $avans_file_id=$details->file_id;
        $proje_id=$details->proje_id;
        $result = [];
        $forma2_durum='';
        $no=0;
        $bakiye=0;
        $borc_toplam=0;
        $alacak_toplam=0;

        $sql=$this->db->query("SELECT `geopos_invoices`.`end_date_islem`, `geopos_invoices`.`proje_id`, `geopos_invoices`.`stok_guncelle`,
       `geopos_invoice_type`.`description`, `geopos_invoice_type`.`type_value`, `geopos_invoices`.`status` as `fatura_durumu_s`,
       `geopos_invoices`.`invoicedate`, `geopos_invoices`.`invoice_no`, `geopos_invoice_type`.`id` as `type_id`,
       `geopos_invoice_type`.`type_value`, `geopos_invoices`.`status` as `fatura_durumu_s`, `geopos_invoices`.`invoicedate`, 
       `geopos_invoices`.`invoice_no`, `geopos_invoice_type`.`id` as `type_id`, `geopos_invoice_type`.`type_value`,
       IF(geopos_invoices.method!='', `geopos_invoices`.`method`, 'null') as odeme_tipi, IF(geopos_invoice_type.id=19, 
           `geopos_invoices`.`total`, 0) as kdv_borc, IF(geopos_invoice_type.id=20, `geopos_invoices`.`total`, 0) as kdv_alacak, 
       IF(geopos_invoice_type.transactions='income', `geopos_invoices`.`total`, NULL) as borc, IF(geopos_invoice_type.transactions='expense',
           `geopos_invoices`.`total`, NULL) as alacak, IF(geopos_invoice_type.transactions='income', `geopos_invoices`.`total`, NULL) as borc_sub,
       IF(geopos_invoice_type.transactions='expense', `geopos_invoices`.`total`, NULL) as alacak_sub, 
       `geopos_invoices`.`total`, `geopos_invoices`.`subtotal`, `geopos_invoices`.`kur_degeri`, `geopos_invoices`.`para_birimi`, 
       `geopos_invoices`.`notes`, `geopos_invoice_type`.`transactions`, `geopos_invoices`.`csd`, `geopos_invoices`.`id` as `inv_id` 
FROM `geopos_invoices` LEFT JOIN `geopos_invoice_type` ON `geopos_invoices`.`invoice_type_id`=`geopos_invoice_type`.`id` 
WHERE `geopos_invoice_type`.`id` IN(1, 2, 3, 4, 7, 8, 17, 18, 19, 20, 21, 22, 23, 24, 38, 43, 44, 45, 46, 47, 48, 39, 40, 54, 55, 29, 30, 62, 24, 41, 61, 65, 69) AND 
      `geopos_invoices`.`cari_pers_type` != 7 AND `geopos_invoices`.`proje_id` = $proje_id AND `geopos_invoices`.`csd` = $cari_id 
ORDER BY DATE(geopos_invoices.end_date_islem) ASC ");

        if($sql->num_rows()){
            $result_=$sql->result_array();
            $data_array_new=[];

            $kontrol =  $this->db->query("SELECT transaction_pay.* FROM transaction_pay Where cari_id = $cari_id and  proje_id =$proje_id");
            if($kontrol->num_rows()){
                $total=0;
                $array_details=[];
                foreach ($kontrol->result() as $items_new){


                    $code='';
                    $details  =  $this->db->query("SELECT * FROM geopos_invoices Where id = $items_new->invoice_id")->row();
                    if($items_new->avans_id){
                        $avans_detaisl = $this->db->query("SELECT * FROM talep_form_customer Where id=$items_new->avans_id");
                        if($avans_detaisl->row()){
                            $code=$avans_detaisl->row()->code;
                        }
                        else {
                            $code=$details->notes;
                        }
                    }
                    else {
                        $code=$details->notes;
                    }





                    $total+=$items_new->amount;
                    $data_array_new[]=
                        [
                            'invoicedate'=>$items_new->created_at,
                            'proje_id'=>$items_new->proje_id,
                            'odeme_tipi'=>$items_new->method,
                            'borc'=>$items_new->amount,
                            'total'=>$items_new->amount,
                            'stok_guncelle'=>0,
                            'invoice_no'=>$code.' Parçalı Ödeme',
                            'inv_id'=>$items_new->avans_id,
                            'alacak'=>0,
                            'csd'=>$items_new->cari_id,
                            'fatura_durumu_s'=>0,
                            'type_id'=>4,
                            'kur_degeri'=>0,
                            'para_birimi'=>1,
                            'type_value'=>'parcali',
                            'transactions'=>'expense',
                            'notes'=>'',
                            'description'=>'MƏXARİC',
                            'end_date_islem'=>$items_new->created_at,
                        ];

                    $array_details[]=$items_new->avans_id;

                }


                $uniq = array_unique($array_details);
                if(count($uniq)){
                    foreach ($uniq as $cvla)
                    {


                        $form_total=0;
                        $kalan=0;
                        if($cvla){
                            $form_total_details=$this->db->query("SELECT SUM(total) as total,talep_form_customer.status FROM talep_form_customer_products
                    INNER JOIN talep_form_customer ON talep_form_customer_products.form_id=talep_form_customer.id Where talep_form_customer_products.form_id=$cvla")->row();
                            if($form_total_details->status==10){
                                $form_total=$this->customeravans->form_total($cvla);
                            }
                            else {
                                $form_total = $this->db->query("SELECT SUM(amount) as total FROM transaction_pay Where avans_id = $cvla")->row()->total;
                            }


                            $total =  $this->db->query("SELECT SUM(amount) as total FROM transaction_pay Where avans_id = $cvla")->row()->total;
                            $kalan = floatval($form_total)-floatval($total);

                            $avans_detaisl = $this->db->query("SELECT * FROM talep_form_customer Where id=$cvla")->row();
                        }



                        if($kalan > 0)
                        {
                            $data_array_new[]=
                                [
                                    'invoicedate'=>$avans_detaisl->created_at,
                                    'proje_id'=>$avans_detaisl->proje_id,
                                    'odeme_tipi'=>$avans_detaisl->method,
                                    'borc'=>$kalan,
                                    'total'=>$kalan,
                                    'stok_guncelle'=>0,
                                    'invoice_no'=>$avans_detaisl->code.' Parçalı Ödeme (QALIQ)',
                                    'inv_id'=>$cvla,
                                    'alacak'=>0,
                                    'csd'=>$cari_id,
                                    'fatura_durumu_s'=>0,
                                    'type_id'=>4,
                                    'kur_degeri'=>0,
                                    'para_birimi'=>1,
                                    'type_value'=>'',
                                    'transactions'=>'expense',
                                    'notes'=>'',
                                    'description'=>'MƏXARİC',
                                    'end_date_islem'=>$avans_detaisl->created_at,
                                ];
                        }
                    }
                }




            }



            $bakiye=0;
            $ekstes_ = array_merge($result_,$data_array_new);
            foreach ($ekstes_ as $invoices) {

                $inv_id_=$invoices['inv_id'];

                if($invoices['fatura_durumu_s']!=3)
                {
                    if($invoices['type_id']!=55)
                    {
                        if($invoices['type_id']==29 || $invoices['type_id']==30){
                            if($invoices['fatura_durumu_s']==18 || $invoices['fatura_durumu_s']==17 || $invoices['fatura_durumu_s']==2) {
//                            if($invoices['odeme_tipi']==1){
                                if($this->input->post('para_birimi')!='tumu')
                                {
                                    $carpim=1;
                                }
                                else
                                {
                                    $carpim=$invoices['kur_degeri'];
                                }

                                $kur_degeri=para_birimi_id($invoices['para_birimi'])['rate'];
                                $carpim=$kur_degeri;


                                $no++;
                                $row = array();


                                if($invoices['type_id']==1 || $invoices['type_id']==2  )
                                {
                                    $borc=$invoices['borc_sub']*$carpim;
                                    $alacak=$invoices['alacak_sub']*$carpim;
                                    $total=$invoices['subtotal'];
                                }
                                else if ($invoices['type_id']==19 || $invoices['type_id']==20)
                                {
                                    $borc=$invoices['kdv_borc']*$carpim;
                                    $alacak=$invoices['kdv_alacak']*$carpim;
                                    $total=$invoices['subtotal'];
                                }
                                else
                                {
                                    $borc=$invoices['borc']*$carpim;
                                    $alacak=$invoices['alacak']*$carpim;
                                    $total=$invoices['total'];
                                }

                                $style='';
                                if($invoices['stok_guncelle'] == 0 )
                                {
                                    $style="background-color: red;color: white;";
                                }


                                if ($invoices['transactions'] == 'expense') {

                                    $alacak_toplam += $total*$carpim;
                                } elseif ($invoices['transactions'] == 'income') {
                                    $borc_toplam += $total*$carpim;
                                }
                                $bakiye += ($borc-$alacak);

//                            }
                            }
                            else {
                                continue;
                            }

                        }
                        elseif($invoices['type_id']==69)
                        {
                            $inv_id = $invoices['inv_id'];
                            $tehvil_kontrol = tehvil_durumu($inv_id);
                            if (!$tehvil_kontrol) {
                                {
                                    if ($this->input->post('para_birimi') != 'tumu') {
                                        $carpim = 1;
                                    } else {
                                        $carpim = $invoices['kur_degeri'];
                                    }

                                    $kur_degeri = para_birimi_id($invoices['para_birimi'])['rate'];
                                    $carpim = $kur_degeri;


                                    $no++;
                                    $row = array();


                                    if ($invoices['type_id'] == 1 || $invoices['type_id'] == 2) {
                                        $borc = $invoices['borc_sub'] * $carpim;
                                        $alacak = $invoices['alacak_sub'] * $carpim;
                                        $total = $invoices['subtotal'];
                                    } else if ($invoices['type_id'] == 19 || $invoices['type_id'] == 20) {
                                        $borc = $invoices['kdv_borc'] * $carpim;
                                        $alacak = $invoices['kdv_alacak'] * $carpim;
                                        $total = $invoices['subtotal'];
                                    } else {
                                        $borc = $invoices['borc'] * $carpim;
                                        $alacak = $invoices['alacak'] * $carpim;
                                        $total = $invoices['total'];
                                    }

                                    $style = '';
                                    if ($invoices['stok_guncelle'] == 0) {
                                        $style = "background-color: red;color: white;";
                                    }


                                    if ($invoices['transactions'] == 'expense') {

                                        $alacak_toplam += $total * $carpim;
                                    } elseif ($invoices['transactions'] == 'income') {
                                        $borc_toplam += $total * $carpim;
                                    }

                                    $bakiye += ($borc-$alacak);
                                }
                            }

                        }
                        else
                        {
                            $inv_id = $invoices['inv_id'];
                            $forma_2_kontorl =forma_2_kontrol($inv_id);
                            if($forma2_durum==1 || $forma2_durum==''){
                                if($forma_2_kontorl){
                                    if($this->input->post('para_birimi')!='tumu')
                                    {
                                        $carpim=1;
                                    }
                                    else
                                    {
                                        $carpim=$invoices['kur_degeri'];
                                    }

                                    $kur_degeri=para_birimi_id($invoices['para_birimi'])['rate'];
                                    $carpim=$kur_degeri;


                                    $no++;
                                    $row = array();


                                    if($invoices['type_id']==1 || $invoices['type_id']==2  )
                                    {
                                        $borc=$invoices['borc_sub']*$carpim;
                                        $alacak=$invoices['alacak_sub']*$carpim;
                                        $total=$invoices['subtotal'];
                                    }
                                    else if ($invoices['type_id']==19 || $invoices['type_id']==20)
                                    {
                                        $borc=$invoices['kdv_borc']*$carpim;
                                        $alacak=$invoices['kdv_alacak']*$carpim;
                                        $total=$invoices['subtotal'];
                                    }
                                    else
                                    {
                                        $borc=$invoices['borc']*$carpim;
                                        $alacak=$invoices['alacak']*$carpim;
                                        $total=$invoices['total'];
                                    }

                                    $style='';
                                    if($invoices['stok_guncelle'] == 0 )
                                    {
                                        $style="background-color: red;color: white;";
                                    }

                                    $kontrol =  $this->db->query("SELECT transaction_pay.* FROM transaction_pay Where invoice_id = $inv_id_");
                                    if(!$kontrol->num_rows()){
                                        if ($invoices['transactions'] == 'expense') {
                                            $alacak_toplam += $total*$carpim;
                                        } elseif ($invoices['transactions'] == 'income') {
                                            $borc_toplam += $total*$carpim;
                                        }

                                        $bakiye += ($borc-$alacak);
                                    }

                                }
                            }
                            elseif($forma2_durum==2) {
                                if($this->input->post('para_birimi')!='tumu')
                                {
                                    $carpim=1;
                                }
                                else
                                {
                                    $carpim=$invoices['kur_degeri'];
                                }

                                $kur_degeri=para_birimi_id($invoices['para_birimi'])['rate'];
                                $carpim=$kur_degeri;


                                $no++;
                                $row = array();


                                if($invoices['type_id']==1 || $invoices['type_id']==2  )
                                {
                                    $borc=$invoices['borc_sub']*$carpim;
                                    $alacak=$invoices['alacak_sub']*$carpim;
                                    $total=$invoices['subtotal'];
                                }
                                else if ($invoices['type_id']==19 || $invoices['type_id']==20)
                                {
                                    $borc=$invoices['kdv_borc']*$carpim;
                                    $alacak=$invoices['kdv_alacak']*$carpim;
                                    $total=$invoices['subtotal'];
                                }
                                else
                                {
                                    $borc=$invoices['borc']*$carpim;
                                    $alacak=$invoices['alacak']*$carpim;
                                    $total=$invoices['total'];
                                }

                                $style='';
                                if($invoices['stok_guncelle'] == 0 )
                                {
                                    $style="background-color: red;color: white;";
                                }


                                if ($invoices['transactions'] == 'expense') {

                                    $alacak_toplam += $total*$carpim;
                                } elseif ($invoices['transactions'] == 'income') {
                                    $borc_toplam += $total*$carpim;
                                }
                                $bakiye += ($borc-$alacak);
                            }


                        }
                    }


                }

            }

        }

        $tutar = amountFormat(abs($bakiye)).($bakiye>0?" (B)":" (A)");


        $table='';
        $avans_file_kontrol=0;
        $avans_kontrol_num=0;
        $avans_kontrol = $this->db->query("SELECT * FROM talep_form_customer Where cari_id=$cari_id and proje_id = $proje_id and avans_type=$avans_type and file_id=$file_id and type = 2 and status NOT IN (10,9) and id!=$id");
        if($avans_kontrol->num_rows()){
            $avans_kontrol_num++;
            $table.='<table class="table-bordered table">
<thead>
<tr>
<td>Talep Kodu</td>
<td>Tarih</td>
<td>Talep Eden Personel</td>
<td>Tutar</td>
<td>File</td>
<td>Talep Durumu</td>
</tr>
</thead>
<tbody>
';

            foreach ($avans_kontrol->result() as $items) {
                $avans_type_new=$items->avans_type;


                $details = avans_file_details($avans_type_new,$items->file_id);


                $text=' <div style="color: crimson;margin: 14px 0px 0 14px;text-decoration: underline;font-weight: bolder;">Aynı File Ait Açık Avans Mevcuttur.Tekrar Avans Açamassınız. Lütfen Var Olan Avansın Tutarını Güncelleyiniz</div>';
                $avans_file_kontrol=1;


                $status=talep_form_status_details($items->status)->name;
                $pers_name = personel_detailsa($items->talep_eden_user_id)['name'];
                $form_total = $this->model->form_total($items->id);
                $button="<a href='/customeravanstalep/view/$items->id' class='btn btn-info btn-sm' target='_blank'>$items->code</a>";
                $table.='<tr>
                <td>'.$button.'</td>
                <td>'.$items->created_at.'</td>
                <td>'.$pers_name.'</td>
                <td>'.amountFormat($form_total).'</td>
                <td>'.$details.$text.'</td>
                <td>'.$status.'</td>
                </tr>';
            }
            $table.="
</tbody>
</table>";
        }


        echo json_encode(array('status' => 200,'tutar'=>$tutar,'avans_kontrol_num'=>$avans_kontrol_num,'html'=>$table,'avans_file_kontrol'=>$avans_file_kontrol));

    }

    public function avans_file_update()
    {
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $file_id = $this->input->post('file_id');
        $data = array(
            'file_id' => $file_id,
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('talep_form_customer', $data)) {



            // Proje Bakiyeleri Insert
            $details_form= $this->model->details($id);
            $avans_details=cari_proje_bakiye_kontrol($id,$details_form->file_id);
            if($avans_details){
                // Kendi Projesi İçin Insert
                $data_insert = [
                    'talep_id'=>$id,
                    'proje_name'=>proje_code($details_form->proje_id).' | '.proje_name($details_form->proje_id),
                    'proje_id'=>$details_form->proje_id,
                    'hakedis_toplam'=>$avans_details['proje_bakiye_alacak'],
                    'borc_toplam'=>$avans_details['proje_bakiye_borc'],
                    'bakiye'=>$avans_details['proje_bakiye']
                ];
                $this->db->insert('talep_form_bakiye', $data_insert);
                // Kendi Projesi İçin Insert

                //diğer Projeler İçin Insert
                foreach ($avans_details['projeler_bakiyesi'] as $items_p){
                    $data_insert2 = [
                        'talep_id'=>$id,
                        'proje_name'=>$items_p['proje_code'].' | '.$items_p['proje_name'],
                        'proje_id'=>$items_p['proje_id'],
                        'hakedis_toplam'=>$items_p['alacak_toplam'],
                        'borc_toplam'=>$items_p['borc_toplam'],
                        'bakiye'=>$items_p['bakiye']
                    ];
                    $this->db->insert('talep_form_bakiye', $data_insert2);
                }
                //diğer Projeler İçin Insert

                //diğer Projeler İçin Insert

                $data_insert3 = [
                    'talep_id'=>$id,
                    'proje_id'=>0,
                    'hakedis_toplam'=>$avans_details['p_genel_bakiye_alacak'],
                    'borc_toplam'=>$avans_details['p_genel_bakiye_borc'],
                    'bakiye'=>$avans_details['genel_bakiye']
                ];
                $this->db->insert('talep_form_bakiye', $data_insert3);

                //diğer Projeler İçin Insert
            }
            // Proje Bakiyeleri Insert


            $this->aauth->applog("Cari Avans Talebinde File Tanımlaması Yapıldı Talep :  ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 200,'message'=>'Başarıyla Güncellendi'));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
        }
    }

    public function print($id){

        $data['details']= $this->model->details($id);
        $data['proje_code']=proje_code($data['details']->proje_id);
        $data['form_total']=$this->model->form_total($id);
        $data['items_']=$this->model->product_details($id);

        ini_set('memory_limit', '999M');
        $html = $this->load->view('fileprint/cari_gtalep_print_view', $data, true);
        $header = $this->load->view('fileprint/cari_atalep_print_header', $data, true);
        $footer = $this->load->view('fileprint/mt_teklif_print_footer', $data, true);

        $this->load->library('pdf');

        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter($footer);
        $pdf->AddPage(
            'L', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            59, // margin top
            '72', // margin bottom
            5, 2, 0, 0, // margin header
            'auto'); // margin footer

        $pdf->WriteHTML($html);
        $file_name ="Teklif__";
        $pdf->Output($file_name . '.pdf', 'I');
    }



}