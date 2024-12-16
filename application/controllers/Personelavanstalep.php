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

class Personelavanstalep Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $selected_db = $this->session->userdata('selected_db');
        if (!empty($selected_db)) {
            $this->db = $this->load->database($selected_db, TRUE);
        }

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('Personelavanstalep_model', 'model');
    }
    public function index()
    {
        if (!$this->aauth->premission(50)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Avans Talep Formu';
        $this->load->view('fixed/header', $head);
        $this->load->view('personelavanstalep/index');
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
        $this->load->view('personelavanstalep/all_list');
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
            $view = "<a class='btn btn-success view' href='/personelavanstalep/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";


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

    public function test()
    {





    }

    public function create_save(){
        if (!$this->aauth->premission(94)->write) {
            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır.Bölüm Müdürünüzden veya IT şubesinden destek alınız'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->create_save();
            if($result['status']){

                echo json_encode(array('status' => 'Success', 'message' =>$result['mesaj'],'index'=>'/personelavanstalep/view/'.$result['id']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>$result['mesaj']));
            }
        }
    }

    public function create_save_yetki(){
        if (!$this->aauth->premission(94)->write) {
            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır.Bölüm Müdürünüzden veya IT şubesinden destek alınız'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->create_save_yetki();
            if($result['status']){

                echo json_encode(array('status' => 'Success', 'message' =>$result['mesaj'],'index'=>'/personelavanstalep/view/'.$result['id']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>$result['mesaj']));
            }
        }

    }

    public function status_upda(){
        if (!$this->aauth->premission(50)->write) {
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
        if (!$this->aauth->premission(50)->update) {
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
        if (!$this->aauth->premission(7)->read) {
            exit('<h3>Üzgünüm! Giriş Yetkiniz Bulunmamaktadır</h3>');
        }

        $user = $this->aauth->get_user()->id; // Giriş yapan kullanıcı ID'si
        $role_id = $this->aauth->get_user()->roleid; // Kullanıcı rolü
        $santiye_id = personel_salary_details_get($user)->proje_id; // Kullanıcının şantiyesi
        $status = true;

        $data['details']= $this->model->details($id);
        $personel_id = $data['details']->personel_id;


        // Kullanıcı tüm personelleri görme yetkisine sahip değilse
        if (!$this->aauth->premission(95)->read) {
            if (in_array($role_id, [10, 40, 48,6,19,30])) {
                // Proje Müdürü veya Şantiye Muhasebecisi ise, şantiye kontrolü yap
                $santiye_id_personel = personel_salary_details_get($personel_id)->proje_id; // Görüntülenmek istenen personelin şantiyesi
                if ($santiye_id != $santiye_id_personel) {
                    $status = false; // Eğer personel başka bir şantiyede ise yetkisiz
                }
            } else {
                // Diğer rollerde kullanıcı yetkisiz
                $status = false;
            }
        }

        if ($status) {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Personel Talep Görüntüleme';
            $data['items'] = $this->model->product_details($id);
            $sorumlu_pers_id = personel_details_full($personel_id)['sorumlu_pers_id'];
            $data['file_details'] = $this->model->file_details($id);
            $toplam_tutar = 0;
            foreach ($data['items'] as $details) {
                $toplam_tutar += $details->total;
            }
            $data['note_list'] = new_list_note(5, $id);
            $data['odeme_details'] = [
                'toplam_tutar' => amountFormat($toplam_tutar),
                'toplam_tutar_float' => $toplam_tutar,
                'cari' => personel_details_full($data['details']->personel_id)['name'],
            ];
            $odeme_total = $this->model->odeme_total($id);
            $form_total = $this->model->form_total($id);
            $data['kalan'] = floatval($form_total) - floatval($odeme_total);
            $this->load->view('fixed/header', $head);
            $this->load->view('personelavanstalep/view', $data);
            $this->load->view('fixed/footer');
        }
        else {
            exit('<h3>Üzgünüm! Bu Talebi Görme Yetkiniz Yoktur</h3>');
        }
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
        $item_qty = 1;



        $details = $this->db->query("SELECT * FROM talep_form_personel_products Where id=$id")->row();
        $details_form = $this->model->details($details->form_id);

        $old_price= $details->price;


        $proje_id=$details_form->proje_id;
        $proje_details = $this->db->query("SELECT * FROM geopos_projects Where id=$proje_id")->row();
        $proje_muduru_id  = $proje_details->proje_muduru_id;

      //  $sorumlu_pers_id =  personel_details_full($details_form->personel_id)['sorumlu_pers_id'];
        $sorumlu_pers_id =  $proje_muduru_id;
        if($proje_id==35){
            $sorumlu_pers_id=62;
        }




        $aylik_tutar_kontrol=aylik_kalan_tutar($details_form->personel_id);
        $tutar_ = $aylik_tutar_kontrol['tutar']+1;




        if($item_price <= $tutar_){
            $type = $this->input->post('type');
            $product_name = cost_details($details->cost_id)->name;
            $user_id  = $this->aauth->get_user()->id;
//            $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $details_form->proje_id and (  proje_sorumlusu_id=$user_id or proje_muduru_id=$user_id or muhasebe_muduru_id=$user_id or genel_mudur_id=$user_id)")->num_rows();
//            if($yetkili_kontrol) {
            $data_update_product = array(
                'product_qty' => $item_qty,
                'price' => $item_price,
                'total' => floatval($item_price) * floatval($item_qty),
            );
            $this->db->set($data_update_product);
            $this->db->where('id', $id);

            if ($this->db->update('talep_form_personel_products', $data_update_product)) {

                $this->model->talep_history($details->form_id, $this->aauth->get_user()->id, $product_name . ' Ürünü Güncellendi. Miktar : ' . $item_qty . ' Fiyat : ' . $item_price);

                $this->aauth->applog("Personel Avans Talebinden Ürün Güncellendi  :  ID : " . $id, $this->aauth->get_user()->username);
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success', 'message' => 'Başarıyla Güncellendi'));
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun." . ' Hata '));
            }
        }
        else {

            if($sorumlu_pers_id==$this->aauth->get_user()->id){
                $type = $this->input->post('type');
                $product_name = cost_details($details->cost_id)->name;
                $user_id  = $this->aauth->get_user()->id;
//            $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $details_form->proje_id and (  proje_sorumlusu_id=$user_id or proje_muduru_id=$user_id or muhasebe_muduru_id=$user_id or genel_mudur_id=$user_id)")->num_rows();
//            if($yetkili_kontrol) {
                $data_update_product = array(
                    'product_qty' => $item_qty,
                    'price' => $item_price,
                    'total' => floatval($item_price) * floatval($item_qty),
                );
                $this->db->set($data_update_product);
                $this->db->where('id', $id);

                if ($this->db->update('talep_form_personel_products', $data_update_product)) {

                    $this->model->talep_history($details->form_id, $this->aauth->get_user()->id, $product_name . ' Ürünü Güncellendi. Miktar : ' . $item_qty . ' Fiyat : ' . amountFormat($item_price).' Eski Tutar : '.amountFormat($old_price));

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
                echo json_encode(array('status' => 'Error', 'message' => $aylik_tutar_kontrol['mesaj'].' '.amountFormat($aylik_tutar_kontrol['tutar'])));
            }


        }




    }


    public function update_form_payment()
    {
        $this->db->trans_start();

        $id = $this->input->post('talep_id');
        $personel_id = $this->input->post('personel_id');
        $user_id = $this->aauth->get_user()->id;

        // Talep detaylarını al
        $details_form = $this->model->details($id);

        // Yetkili kontrolü
        $yetkili_kontrol = $this->db->where('id', $details_form->proje_id)
            ->group_start()
            ->where('muhasebe_muduru_id', $user_id)
            ->or_where('genel_mudur_id', $user_id)
            ->group_end()
            ->count_all_results('geopos_projects');

        if ($yetkili_kontrol) {
            // Personel adı alınır
            $personel_details = personel_details_full($personel_id);
            $personel_name = $personel_details['name'];

            // Talep güncelleme işlemi
            $data_talep_update = [
                'payment_personel_id' => $personel_id,
                'status' => 12,
            ];

            $this->db->where('id', $id);
            if ($this->db->update('talep_form_personel', $data_talep_update)) {
                // Talep geçmişi güncellemesi
                $this->model->talep_history(
                    $id,
                    $user_id,
                    'Talep Güncellendi. Ödeme Emri Verildi : ' . $personel_name
                );

                // Bildirim gönderimi
                $mesaj = $details_form->code . ' Numaralı Avans Talep Formuna Ödeme Emri Verilmiştir';
                // $this->model->send_mail($personel_id, 'Avans Talep Onayı', $mesaj);

                // Log kaydı
                $this->aauth->applog(
                    "Personel Avans Talebinden Güncellendi : ID : " . $id,
                    $this->aauth->get_user()->username
                );

                // İşlem başarıyla tamamlandı
                $this->db->trans_complete();
                echo json_encode([
                    'status' => 'Success',
                    'message' => 'Başarıyla Güncellendi',
                ]);
            } else {
                // Hata durumunda işlem geri alınıyor
                $this->db->trans_rollback();
                echo json_encode([
                    'status' => 'Error',
                    'message' => "Hata Aldınız. Lütfen Yöneyiciye Başvurun.",
                ]);
            }
        } else {
            // Yetki kontrolü başarısız
            $this->db->trans_rollback();
            echo json_encode([
                'status' => 'Error',
                'message' => "Yetkiniz Bulunmamaktadır",
            ]);
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
    public function customer_payment_update()
    {
        $this->db->trans_start();

        $id = $this->input->post('talep_id');
        $account_id = $this->input->post('account_id');
        $alacak_tutar = $this->input->post('alacak_tutar');
        $tip = $this->input->post('tip');
        $not = $this->input->post('not');
        $user_id = $this->aauth->get_user()->id;
        $role_id = $this->aauth->get_user()->roleid;

        // Talep detaylarını al
        $details_form = $this->model->details($id);
        $not .= ' ' . $details_form->code . ' İstinaden Ödeme';
        $invoice_type_id = 14; // Personel Maaş Avansı

        // Ödeme işlemleri için genel veri seti
        $data = [
            'csd' => $details_form->personel_id,
            'payer' => personel_details_full($details_form->personel_id)['name'],
            'acid' => $account_id,
            'account' => account_details($account_id)->holder,
            'total' => $alacak_tutar,
            'invoice_type_id' => $invoice_type_id,
            'invoice_type_desc' => invoice_type_desc($invoice_type_id),
            'method' => $details_form->method,
            'eid' => $user_id,
            'notes' => $not,
            'proje_id' => $details_form->proje_id,
        ];

        // Muhasebe işlemi için kontrol
        if ($tip === 'muhasebe') {
            if ($role_id == 1 || $role_id == 48) {
                $this->process_payment($id, $data, $alacak_tutar, $details_form, $tip, $details_form->personel_id);
            } else {
                $this->db->trans_rollback();
                echo json_encode(['status' => 'Error', 'message' => "Yetkiniz Bulunmamaktadır"]);
            }
        } else {
            // Yetkili kullanıcı kontrolü
            if ($user_id == $details_form->payment_personel_id) {
                $this->process_payment($id, $data, $alacak_tutar, $details_form, $tip, $details_form->personel_id);
            } else {
                $this->db->trans_rollback();
                echo json_encode(['status' => 'Error', 'message' => "Yetkiniz Bulunmamaktadır"]);
            }
        }
    }

    private function process_payment($id, $data, $alacak_tutar, $details_form, $tip, $pers_id)
    {
        // Ödemeyi `geopos_invoices` tablosuna ekleme işlemi
        if ($this->db->insert('geopos_invoices', $data)) {

            // Talep durumu güncelleme
            if ($tip === 'odeme') {
                $data_talep_update = [
                    'odeme_durum' => 1,
                    'status' => 9,
                ];
                $this->db->where('id', $id);
                if (!$this->db->update('talep_form_personel', $data_talep_update)) {
                    $this->rollback_with_error("Talep formu güncellenirken bir hata oluştu. Lütfen yöneticinizle iletişime geçin.");
                    return;
                }
            }

            // Bordro güncelleme
            $bordro_details = check_bordro_payment_status($pers_id, $details_form->method, 2);

            // Hakediş türüne göre bordro güncelleme
            $data_bordro_update = [];
            if ($details_form->method == 1) { // Nakit ödemeler
                $data_bordro_update = [
                    'nakit_odenilecek' => $bordro_details->nakit_odenilecek - $alacak_tutar,
                ];
            } elseif ($details_form->method == 3) { // Banka ödemeleri
                $data_bordro_update = [
                    'bankadan_odenilecek' => $bordro_details->bankadan_odenilecek - $alacak_tutar,
                    'odenilecek_meblaq' => $bordro_details->odenilecek_meblaq - $alacak_tutar,
                ];
            }

            // Bordro güncelleme işlemi
            $this->db->where('id', $bordro_details->id);
            if (!$this->db->update('new_bordro_item', $data_bordro_update)) {
                $this->rollback_with_error("Bordro güncellenirken bir hata oluştu. Lütfen yöneticinizle iletişime geçin.");
                return;
            }

            // İşlem başarılı olduğunda tarihçe kaydı ekle
            $this->model->talep_history($id, $this->aauth->get_user()->id, 'Ödeme Yapıldı: ' . amountFormat($alacak_tutar));

            // İşlemi başarıyla tamamla
            $this->db->trans_complete();
            echo json_encode(['status' => 'Success', 'message' => 'Başarıyla Güncellendi']);
        } else {
            // Ödeme eklenemezse hata mesajı döndür
            $this->rollback_with_error("Talep eklenirken bir hata oluştu. Lütfen yöneticinizle iletişime geçin.");
        }
    }




    private function rollback_with_error($message)
    {
        $this->db->trans_rollback();
        echo json_encode(['status' => 'Error', 'message' => $message]);
    }



    public function knt_aylik_kalan_tutar($personel_id)
    {
        $result = $this->model->knt_aylik_kalan_tutar($personel_id);
        echo "<pre>";print_r($result);
    }
    public function onay_olustur(){
        $this->db->trans_start();
        $result = $this->model->onay_olustur();
        if($result['status']){
            echo json_encode(array('status' => 'Success', 'message' =>$result['mesaj']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>$result['mesaj']));
        }
    }


}