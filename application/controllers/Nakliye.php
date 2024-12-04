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

class Nakliye Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('Nakliye_model', 'model');
        $this->load->model('malzemetalep_model', 'mt_talep');
    }




    public function qaime_create()
    {

    }
    public function qaime_ajax(){
        $form_id=$this->input->post('form_id');
        $cari_id=$this->input->post('cari_id');
        $data['cari_id']=$cari_id;

//        $data['form_details']=$this->talep->details($form_id);
//        $data['form_id']=$form_id;
//
//
//
//        $data['discount_type']=$data['teklif_details']->discount_type;
//        $data['kdv']=$data['teklif_details']->kdv;
//        $data['para_birimi']=$data['teklif_details']->para_birimi;
//        $data['teslimat_tutar']=$data['teklif_details_items']->teslimat_tutar;
//        $data['method_id']=$data['teklif_details_items']->method;
//
//        $data['teklif_kontrol']=teklif_update_kontrol($teklif_id);
//        $data['items_']=techizatcilar_item($form_id,$cari_id);
//        $data['para_birimi_details']=geopos_currencies_details($data['para_birimi']);
//        $data['details']= $this->talep->details($form_id);
//        $data['data_products']= $this->talep->product_details($form_id);
//        $head['usernm'] = $this->aauth->get_user()->username;

        $view = $this->load->view('nakliye/qaime_view',$data);
        echo json_encode(array('status' => 'Success', 'view' =>$view));

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



    public function upload_file(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $image_text = $this->input->post('image_text');
        $data_images = array(
            'user_id' => $this->aauth->get_user()->id,
            'image_text' => $image_text,
            'form_id' => $id,
        );
        if($this->db->insert('talep_form_nakliye_files', $data_images)){
            $this->aauth->applog("Nakliye Talebine File Yüklendi  : Talep ID : ".$id, $this->aauth->get_user()->username);
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
        if($this->db->delete('talep_form_nakliye_files', array('id' => $id))){
            $this->aauth->applog("Nakliye Talebinden File Silindi  : File ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Silindi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }

    }

    public function index()
    {
        if (!$this->aauth->premission(32)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Yeni Lojistik Talebi';
//        $data['totals'] = amountFormat($this->model->form_total_bekleyen());
//        $data['bank'] = amountFormat($this->model->form_total_bekleyen_method(3));
//        $data['nakit'] = amountFormat($this->model->form_total_bekleyen_method(1));
        $this->load->view('fixed/header', $head);
        $this->load->view('nakliye/index');
        $this->load->view('fixed/footer');
    }

    public function report()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Nakliye Raporları';
        $this->load->view('fixed/header', $head);
        $this->load->view('nakliye/report');
        $this->load->view('fixed/footer');
    }

    public function mt_info_arac(){
        $list = $this->model->mt_info_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $m_item_id=$prd->m_item_id;

            $product_stock_code_id = talep_form_product_options_teklif_values($m_item_id);


            $n_item_id=$this->input->post('n_item_id');
            $m_talep_id=$this->input->post('m_talep_id');

            $talep_form_nakliye_to_mt_details = $this->db->query("Select * From talep_form_nakliye_to_mt Where talep_item_id = $n_item_id and mt_id=$m_talep_id")->row();

            $yukleyen_pers_name = personel_details($talep_form_nakliye_to_mt_details->yukleyen_pers_id);
            $total_teslim_alinan = $this->db->query("SELECT SUM(qty) as total FROM stock Where types=1 and talep_form_nakliye_product_arac_id=$prd->id")->row()->total;


            $style='';
            if($total_teslim_alinan!=$prd->total){
                $style = "background-color:red;color:white";
            }


            $no++;
            $row = array();
            $row[] =$no ;
            $row[] = $prd->created_at;
            $row[] = talep_form_product_details_items($prd->m_item_id).' | '.talep_form_product_options_new($product_stock_code_id) ;
            $row[] = $yukleyen_pers_name;
            $row[] = amountFormat_s($prd->total);
            $row[] = amountFormat_s($total_teslim_alinan);
            $row[] =$style;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->mt_info_count_all(),
            "recordsFiltered" => $this->model->mt_info_count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function mt_atamasi(){
        $list = $this->model->atama_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->code;
            $row[] = $prd->created_at;
            $row[] = $prd->talep_eden_pers_name;
            $row[] = $prd->talep_text;
            $row[] = "<button class='btn btn-success status_change' atama_id='$prd->id'><i class='fa fa-check'></i></button>";
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->atama_count_all(),
            "recordsFiltered" => $this->model->atama_count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
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
            $view = "<a class='btn btn-success view' href='/nakliye/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";

            $odeme_total = $this->model->odeme_total($prd->id);
            $form_total = $this->model->form_total($prd->id);
            $kalan=floatval($form_total)-floatval($odeme_total);


            $gider_durumu = '<span class="badge badge-pill badge-light">Gidere İşlenmedi</span>';
            $invoice_durumu = '<span class="badge badge-pill badge-light">Faturalaşmadı</span>';
            if($prd->gider_durumu){
                $gider_durumu='<span class="badge badge-pill badge-secondary">Gidere İşlendi</span>';
            }
            if($prd->invoice_durumu){
                $invoice_durumu='<span class="badge badge-pill badge-secondary">Faturalaştı</span>';
            }
            $no++;
            $row = array();
            $row[] = $prd->code;
            $row[] = $prd->progress_name;
            $row[] = $prd->created_at;
            $row[] = $prd->pers_name;
            $row[] = $prd->proje_name;
            $row[] = amountFormat($toplam_tutar);
            $row[] = amountFormat($kalan);
            $row[] = $prd->st_name;
            $row[] =$prd->desc;
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
        if (!$this->aauth->premission(32)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->create_save();
            if($result['status']){

                echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Talep Oluşturuldu",'index'=>'/nakliye/view/'.$result['id']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
            }
        }


    }

    public function view($id)
    {
        if (!$this->aauth->premission(32)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $data['details']= $this->model->details($id);

        if (! $data['details']) {

            exit('<h3>Talep Bulunamadı</h3>');

        }

        $odeme_total = $this->model->odeme_total($id);
        $form_total = $this->model->form_total($id);
        $data['kalan']=floatval($form_total)-floatval($odeme_total);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Nakliye Talep Görüntüleme';
        $data['items']= $this->model->product_details($id);
        $data['file_details']= $this->model->file_details($id);

        $cari_id = $data['details']->cari_id;

        $toplam_tutar=0;
        foreach ($data['items'] as $details){
            $toplam_tutar+=$details->total;
        }

        $data['odeme_details']=[
            'toplam_tutar'=>amountFormat($toplam_tutar),
            'toplam_tutar_float'=>$toplam_tutar,
            'cari'=>customer_details($data['details']->cari_id)['company'],
        ];
        $this->load->view('fixed/header', $head);

        $this->load->view('nakliye/view',$data);
        $this->load->view('fixed/footer');
    }

    public function create_form_items(){
        $this->db->trans_start();
        $result = $this->model->create_form_items();
        if($result['status']){
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Kayıt Edildi",'id'=>$result['id'],'talep_form_products_id'=>$result['talep_form_products_id']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }
    }
    public function create_form_items_satinalma(){
        $this->db->trans_start();
        $result = $this->model->create_form_items_satinalma();
        if($result['status']){
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Kayıt Edildi",'id'=>$result['id'],'talep_form_products_id'=>$result['talep_form_products_id']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }
    }

    public function save_items(){
        $this->db->trans_start();
        $result = $this->model->save_items();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['messages']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['messages']));
        }
    }

    public function form_bildirim_olustur(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $type = $this->input->post('type');
        $user_id=$this->aauth->get_user()->id;
        $talep_kontrol  = $this->db->query("SELECT * FROM `talep_form_nakliye` where id=$id and aauth=$user_id")->num_rows();
//        if($talep_kontrol){
            $details = $this->model->details($id);


            if($type==2){ // satınalma
                $data = array(
                    'satinalma_bildirimi' => 1,
                );

                $this->db->set($data);
                $this->db->where('id', $id);
                if ($this->db->update('talep_form_nakliye', $data)) {

                    $users_ = onay_sort(16,$details->proje_id);
                    if($users_){
                        foreach ($users_ as $items){
                            $staff=0;
                            if($items['sort']==1){
                                // bildirim maili at
                                $mesaj=$details->code.' Numaralı Nakliye Talep Formu Onayınızı Beklemektedir';
                                //$this->model->send_mail($items['user_id'],' Gider Talep Onayı',$mesaj);
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
                            $this->db->insert('talep_onay_nakliye', $data_onay);
                        }

                        $this->model->talep_history($id,$this->aauth->get_user()->id,'Onay İşlemi Başlatıldı');
                        $this->aauth->applog("Nakliye Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);
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
                $data = array(
                    'bildirim_durumu' => 1,
                );
                $this->db->set($data);
                $this->db->where('id', $id);
                if ($this->db->update('talep_form_nakliye', $data)) {

                    $users_ = onay_sort(11,$details->proje_id);
                    if($users_){
                        foreach ($users_ as $items){
                            $staff=0;
                            if($items['sort']==1){
                                // bildirim maili at
                                $mesaj=$details->code.' Numaralı Nakliye Talep Formu Onayınızı Beklemektedir';
                                //$this->model->send_mail($items['user_id'],' Gider Talep Onayı',$mesaj);
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
                            $this->db->insert('talep_onay_nakliye', $data_onay);
                        }

                        $this->model->talep_history($id,$this->aauth->get_user()->id,'Onay İşlemi Başlatıldı');
                        $this->aauth->applog("Nakliye Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);
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


//        }
//        else {
//            $this->db->trans_rollback();
//            echo json_encode(array('status' => 'Error', 'message' =>"Yetkiniz Bulunmamaktadır."));
//        }


    }
    public function onay_olustur(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $progress_status_id = $this->input->post('progress_status_id');
        $details = $this->model->details($id);
        $type = $this->input->post('type');
        $data_talep_updata=['progress_status_id'=>$progress_status_id];
        $this->db->where('id',$id);
        $this->db->set($data_talep_updata);
        $this->db->update('talep_form_nakliye_products', $data_talep_updata);


        $new_id=0;
        $new_user_id=0;
        $new_id_control = $this->db->query("SELECT * FROM `talep_onay_nakliye` Where type=$type and talep_id=$id and staff=0 and status is Null ORDER BY `talep_onay_nakliye`.`id` ASC LIMIT 1");
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
        if ($this->db->update('talep_onay_nakliye', $data)) {

            $this->model->talep_history($id,$this->aauth->get_user()->id,'Onay Verildi');
            if($new_id){

                $mesaj=$details->code.' Numaralı Nakliye Talep Formu Onayınızı Beklemektedir';
                //$this->model->send_mail($new_user_id,'Gider Talep Onayı',$mesaj);

                // Bir Sonraki Onay
                $data_new=array(
                    'staff'=>1,
                );
                $this->db->where('id',$new_id);
                $this->db->set($data_new);
                $this->db->update('talep_onay_nakliye', $data_new);
                // Bir Sonraki Onay
            }
            else {

//                $mesaj=$details->code.' Numaralı Gider Talep Formu Onaylanmıştır. İşleminiz Ödeme Emri Beklemektedir';
//                $this->model->send_mail($details->talep_eden_pers_id,'Gider Talep Formu',$mesaj);
                //Teklif



                ///alacak durumları önceden tamamlanmışsa hiç bir işlem yapma
                if($details->status!=9){
                    $items_status=3;
                    $form_status=3;

                    if($type==2){
                        $items_status=13;
                        $form_status=5;
                    }


                    $data_Form = array(
                        'status' => $form_status,
                    );
                    //Ödeme Bekliyor
                    $this->db->set($data_Form);
                    $this->db->where('id', $id);
                    $this->db->update('talep_form_nakliye', $data_Form);


                    $data_Form_items=array(
                        'status'=>$items_status,
                    );
                    //Ödeme Bekliyor
                    $this->db->set($data_Form_items);
                    $this->db->where('form_id', $id);
                    $this->db->update('talep_form_nakliye_products', $data_Form_items);

                    $mesaj='Nakliye Onaylandı';
                    // $this->model->send_mail(lojistik_yetkili_id(),' Nakliye Talep Onayı',$mesaj);

                    //Hizmet İse status değiş
                    $items_details= $this->db->query("SELECT * FROM talep_form_nakliye_products Where form_id=$id and nakliye_item_tip=3");
                    if($items_details->num_rows()){
                        foreach ($items_details->result() as $item_values){
                            $data_Form_items=array(
                                'status'=>2,
                            );
                            //Ödeme Bekliyor
                            $this->db->set($data_Form_items);
                            $this->db->where('id', $item_values->id);
                            $this->db->update('talep_form_nakliye_products', $data_Form_items);
                        }
                    }
                    //Hizmet İse status değiş


                    //Kontrol Bekliyor
                }

                ///alacak durumları önceden tamamlanmışsa hiç bir işlem yapma



            }

            $this->aauth->applog("Nakliye Talebine Onay Verildi :  ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Onay Verildi'));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));

        }

    }

    public function update_item_pers(){
        $this->db->trans_start();
        $id = $this->input->post('item_id');
        $yukleyen_pers_id = $this->input->post('yukleyen_pers_id');
        $tehvil_pers_id = $this->input->post('tehvil_pers_id');
        $details = $this->db->query("SELECT * FROM talep_form_nakliye_products Where id=$id")->row();
        $data_update_product = array(
            'yukleyen_pers_id' => $yukleyen_pers_id,
            'tehvil_pers_id' => $tehvil_pers_id,
        );
        $this->db->set($data_update_product);
        $this->db->where('talep_item_id', $id);
        if ($this->db->update('talep_form_nakliye_to_mt', $data_update_product)) {
            $this->model->talep_history($details->form_id, $this->aauth->get_user()->id, $details->code.' Nakliye Talebine Personel Atandı');

            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success', 'message' => 'Başarıyla Güncellendi'));
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun." . ' Hata '));
        }

    }

    public function personel_info(){
        $id = $this->input->post('item_id');
        $yukleyen_pers_id=0;
        $tehvil_pers_id=0;
        $details = $this->db->query("SELECT * FROM talep_form_nakliye_to_mt Where talep_item_id=$id");
        if($details->num_rows()){
            $yukleyen_pers_id=$details->row()->yukleyen_pers_id;
            $tehvil_pers_id=$details->row()->tehvil_pers_id;
            echo json_encode(array('status' => 200, 'yukleyen_pers_id' => $yukleyen_pers_id,'tehvil_pers_id'=>$tehvil_pers_id));
        }
        else {
            echo json_encode(array('status' => 410));
        }

    }

    public function update_item_form()
    {
        $this->db->trans_start();
        $id = $this->input->post('item_id');
        $item_price = $this->input->post('item_price');
        $item_qty = $this->input->post('item_qty');
        $arac_id = $this->input->post('arac_id');
        $cari_id = $this->input->post('cari_id');
        $method = $this->input->post('method');
        $yukleme_yapacak_cari_id = $this->input->post('yukleme_yapacak_cari_id');


        $details = $this->db->query("SELECT * FROM talep_form_nakliye_products Where id=$id")->row();
        $details_form = $this->model->details($details->form_id);
        $type = $this->input->post('type');
        $product_name = isset(arac_details($arac_id)->name)?arac_details($arac_id)->name:'';
        $user_id  = $this->aauth->get_user()->id;
        $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $details_form->proje_id and (  proje_sorumlusu_id=$user_id or proje_muduru_id=$user_id or muhasebe_muduru_id=$user_id or genel_mudur_id=$user_id)")->num_rows();

        if($yetkili_kontrol || ($details_form->talep_eden_user_id == $user_id ||  $user_id == lojistik_yetkili_id() ||  $user_id == 289  ||  $user_id == 1006)) {
            if ($type == 1) {
                $this->model->talep_history($details->form_id, $this->aauth->get_user()->id, $product_name . ' Ürünü Güncellendi. Miktar : ' . $item_qty . ' Fiyat : ' . $item_price);
            }
            $data_update_product = array(
                'product_qty' => $item_qty,
                'arac_id' => $arac_id,
                'cari_id' => $cari_id,
                'price' => $item_price,
                'method' => $method,
                'yukleme_yapacak_cari_id' => $yukleme_yapacak_cari_id,
                'total' => floatval($item_price) * floatval($item_qty),
            );
            $this->db->set($data_update_product);
            $this->db->where('id', $id);
            if ($this->db->update('talep_form_nakliye_products', $data_update_product)) {
                $this->aauth->applog("Nakliye Talebinden Ürün Güncellendi  :  ID : " . $id, $this->aauth->get_user()->username);
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

    public function update_item_form_teslimat()
    {
        $this->db->trans_start();
        $id = $this->input->post('item_id');
        $item_price = $this->input->post('item_price');
        $item_qty = $this->input->post('item_qty');
        $details = $this->db->query("SELECT * FROM talep_form_nakliye_products Where id=$id")->row();



        $details_form = $this->model->details($details->form_id);
        $form_id=$details_form->id;
        $count =  $this->db->query("SELECT * FROM talep_form_nakliye_products Where form_id=$form_id")->num_rows();

        $type = $this->input->post('type');
        $product_name = arac_details($details->arac_id)->name;
        $user_id  = $this->aauth->get_user()->id;
        $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $details_form->proje_id and (  proje_sorumlusu_id=$user_id or proje_muduru_id=$user_id or muhasebe_muduru_id=$user_id or genel_mudur_id=$user_id)")->num_rows();

        if($yetkili_kontrol || ($details_form->talep_eden_user_id == $user_id)) {
            if ($type == 1) {
                $this->model->talep_history($details->form_id, $this->aauth->get_user()->id, $product_name . ' Aracı Yola Salındı.');
            }
            $data_update_product = array(
                'status' => 7,
            );
            $this->db->set($data_update_product);
            $this->db->where('id', $id);
            if ($this->db->update('talep_form_nakliye_products', $data_update_product)) {


                //tüm İtems Baklıyor
                $items_kontrol = $this->db->query("SELECT * FROM talep_form_nakliye_products Where form_id=$form_id and status=7")->num_rows();
                //teslimatta bekliyor
                if($count==$items_kontrol){

                    $data_Form=array(
                        'status'=>7,
                    );

                    $this->db->set($data_Form);
                    $this->db->where('id', $form_id);
                    $this->db->update('talep_form_nakliye', $data_Form);
                }
                //teslimatta bekliyor

                // Mt Kontrolü
                $mt_kontol = $this->db->query("SELECT * FROM talep_form_nakliye_to_mt Where talep_item_id = $id");
                if($mt_kontol->num_rows()){
                    foreach ($mt_kontol->result() as $mt_values){

                    }
                }

                // Mt Kontrolü

                $this->aauth->applog("Nakliye Talebinden Ürün Güncellendi  :  ID : " . $id, $this->aauth->get_user()->username);
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

    public function mt_view(){
        $mt_id = $this->input->post('mt_id');
         $sql = $this->db->query("SELECT talep_form_nakliye_products.lokasyon,talep_form_nakliye.id,talep_form_nakliye_to_mt.talep_item_id,talep_form_nakliye.code,araclar.name,talep_form_nakliye_products.status,talep_form_status.name as status_name FROM talep_form_nakliye_to_mt
                  INNER JOIN talep_form_nakliye_products ON talep_form_nakliye_to_mt.talep_item_id = talep_form_nakliye_products.id
                  INNER JOIN talep_form_nakliye ON talep_form_nakliye_products.form_id = talep_form_nakliye.id
                  INNER JOIN talep_form_status ON talep_form_nakliye_products.status = talep_form_status.id
                  INNER JOIN araclar ON talep_form_nakliye_products.arac_id = araclar.id where talep_form_nakliye_to_mt.mt_id=$mt_id
    ")->result();
         $html='<div class="delivery-main-message orange"><br></div>';
         foreach ($sql as $items){
             $html.='<div class="ty-content">
                        <a href="/nakliye/view/'.$items->id.'" target="_blank" style="cursor: pointer;font-size: 15px;" class="badge badge-info mt_view" mt_id="'.$items->id.'">'.$items->code.'</a>
                        &nbsp;<span class="badge badge-success">'.$items->name.'</span>
                        &nbsp;<span>Lokasyon : '.$items->lokasyon.'</span>
                         <div class="delivery-progress">
                            <div class="delivery-progress-flex">
                                
                                
            <div class="wrapper active">
                ';
             if($items->status==1){
                 $html.='<div class="circle" style="background: #0bc15c;border: 3px solid #0bc15c;">';
             }
             else{
                 $html.='<div class="circle">';
             }
             $html.=' <i class="icon-newspaper2 fa-3x" style="color:white"></i>';
             $html.='</div>   
                        <div class="content">Talep Aşamasında</div>
                    </div>
            
            
            
            <div class="wrapper active">';
             if($items->status==5){
                 $html.='<div class="circle" style="background: #0bc15c;border: 3px solid #0bc15c;">';
             }
             else{
                 $html.='<div class="circle">';
             }
             $html.=' <i class="fa fa-check fa-3x" style="color:white"></i>';
             $html.='   </div>   
                        <div class="content">Onaylandı</div>
                    </div>
            
            
            <div class="wrapper active">';

             if($items->status==13){
                 $html.='<div class="circle" style="background: #0bc15c;border: 3px solid #0bc15c;">';
             }
             else{
                 $html.='<div class="circle">';
             }
             $html.='
            
                    <i class="fa fa-cube fa-3x" style="color:white"></i>
                </div>
                <div class="content">Yükleme Emri Verildi</div>
            </div> 
            
            <div class="wrapper active">';

             if($items->status==14){
                 $html.='<div class="circle" style="background: #0bc15c;border: 3px solid #0bc15c;">';
             }
             else{
                 $html.='<div class="circle">';
             }
             $html.='
            
                    <i class="fa fa-truck fa-3x" style="color:white"></i>
                </div>
                <div class="content">Gönderi Yolda</div>
            </div>';
        
            $html.='<div class="wrapper active">';
             if($items->status==15){
                 $html.='<div class="circle" style="background: #0bc15c;border: 3px solid #0bc15c;">';
             }
             else{
                 $html.='<div class="circle">';
             }

             $html.='<i class="fa fa-warehouse fa-3x" style="color:white"></i>
                    </div>
                <div class="content">Teslim Edildi</div>
            </div>

                                                                           ';


             $html.=' </div>
                                                                        </div>
                                                                    </div>
                                                                <hr>';

         }



        echo json_encode(array('status' => 200, 'html' => $html));

    }

    public function arac_add_product(){
        $item_id = $this->input->post('talep_form_product_id');
        $mt_array=[];
        $product_details='';
        $html='';
        $mt_id = $this->db->query("SELECT * FROM talep_form_nakliye_to_mt Where talep_item_id=$item_id");

        if($mt_id->num_rows()){
            foreach ($mt_id->result() as $values){
                $mt_array[]=$values->mt_id;
            }
        }

        if($mt_array){
            $id_str = implode(',',$mt_array);
            $this->db->select('talep_form_products.*,geopos_products.product_name,geopos_units.name as unit_name');
            $this->db->from('talep_form_products');
            $this->db->join('geopos_products','talep_form_products.product_id=geopos_products.pid');
            $this->db->join('geopos_units','talep_form_products.unit_id=geopos_units.id');
            $this->db->where_in('form_id',$id_str);
            $query = $this->db->get();
            $product_details =  $query->result();
        }
        if($product_details){
            $html="<table class='table table-bordered'><thead><tr>
                    <th>#</th>
                    <th>Malzeme</th>
                    <th>Tanım</th>
                    <th>Varyasyon</th>
                    <th>MT Kodu</th>
                    <th>Miktar</th>
                    <th>Birim</th>
                    <th>İşlem</th>
                    </tr></thead><tbody>";
            $i=1;
            $eq=0;
            foreach ($product_details as $values) {
                $talep_form_product_options_teklif_values=talep_form_product_options_teklif_values($values->id);
                $p_price = piyasa_fiyati($values->product_id,$talep_form_product_options_teklif_values);
                $details = $this->db->query("SELECT * FROM talep_form WHERE id=$values->form_id")->row();

                $toplam_alinan_qty = $this->db->query("SElECT SUM(quantity) as total FROM talep_form_nakliye_product_arac Where m_item_id=$values->id")->row()->total;
                $kalan=floatval($values->product_qty)-floatval($toplam_alinan_qty);


                $html.=' <tr  id="remove'.$values->id.'">
                            <td>'.$i.'</td>
                            <td>'.$values->product_name.'</td>
                            <td>'.$values->product_desc.'</td>
                            <td>'.talep_form_product_options($values->id).'</td>
                           <td>'.$details->code.'</td>
                            <td><input item_id="'.$values->id.'" type="number" value="'.$kalan.'" max="'.$kalan.'" onkeyup="amount_max(this)" class="form-control item_qty_values" style="width:110px"></td>
                            <td>'.$values->unit_name.'</td>
                            <td><button type="button" eq="'.$eq.'" nakliye_item_id="'.$item_id.'"  class="btn btn-success add_arac_product_button" talep_form_product_id="'.$values->id.'" ><i class="fa fa-plus"></i>&nbsp; Araca Yükle</button></td>
        
        
                            <td></td>
                        </tr>';
                $i++;
                $eq++;
            }
        }

        echo json_encode(array('status' => 200, 'html' => $html));
    }

    public function add_arac_product(){

        $this->db->trans_start();
        $lojistik_details = $this->input->post('lojistik_details');
        $nakliye_item_id = $this->input->post('nakliye_item_id');
        $count = count($lojistik_details);
        $sayi=0;

        if($lojistik_details){
            foreach ($lojistik_details as $items){
                $talep_form_product_id= $items['talep_form_product_id'];
                $miktar= $items['miktar'];

                $nakliye_item_details = $this->db->query("SELECT * FROM talep_form_nakliye_products Where id=$nakliye_item_id")->row();
                $m_talep_details = $this->db->query("SELECT * FROM talep_form_products Where id=$talep_form_product_id")->row();
                $m_product_name = $m_talep_details->product_desc;
                $unit_name = units_($m_talep_details->unit_id)['name'];
                $arac_name=arac_details($nakliye_item_details->arac_id)->name;
                $m_talep_id = $m_talep_details->form_id;


                $n_talep_id = $this->db->query("SELECT * FROM talep_form_nakliye_products Where id=$nakliye_item_id")->row()->form_id;



                $data_step = array(
                    'n_talep_id' => $n_talep_id,
                    'n_item_id' => $nakliye_item_id,
                    'm_item_id' => $talep_form_product_id,
                    'm_talep_id' => $m_talep_id,
                    'quantity' => $miktar,
                );
                if($this->db->insert('talep_form_nakliye_product_arac', $data_step)){

                    $this->model->talep_history($n_talep_id,$this->aauth->get_user()->id,$arac_name.' İsimli Araca  '.$m_product_name.' Ürününden : '.$miktar .' '.$unit_name.' Yüklenmiştir');



                    $toplam_siparis = $this->db->query("SElECT product_qty FROM talep_form_products Where id=$talep_form_product_id")->row()->product_qty;
                    $toplam_alinan_qty = $this->db->query("SElECT SUM(quantity) as total FROM talep_form_nakliye_product_arac Where m_item_id=$talep_form_product_id")->row()->total;

                    $kalan=floatval($toplam_siparis)-floatval($toplam_alinan_qty);

                    $sayi++;

                    if($nakliye_item_details->status==13){
                        if($kalan==0){
                            $data_item_update = [
                                'status'=>14
                            ];
                            $this->db->where('id',$nakliye_item_id);
                            $this->db->set($data_item_update);
                            $this->db->update('talep_form_nakliye_products', $data_item_update);


                            $data_item_mt_to = [
                                'yukleme_durum'=>1
                            ];
                            $this->db->where('talep_item_id',$nakliye_item_id);
                            $this->db->set($data_item_mt_to);
                            $this->db->update('talep_form_nakliye_to_mt', $data_item_mt_to);
                        }

                    }




                }
            }
            if($sayi==$count){

                echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Araca Yüklendi",'kalan'=>$kalan));
                $this->db->trans_complete();
            }
            else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
                }


        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Seçilen Herhangi Bir Ürün Yok.".' Hata '));
        }



    }

    public function add_arac_product_stock(){

        $this->db->trans_start();
        $lojistik_details = $this->input->post('lojistik_details');
        $warehouse_id = $this->input->post('warehouse_select');
        $nakliye_item_id = $this->input->post('nakliye_item_id');
        $count = count($lojistik_details);
        $sayi=0;

        if($lojistik_details){
            foreach ($lojistik_details as $items){
                $talep_form_product_id= $items['talep_form_product_id'];
                $miktar= $items['miktar'];

                $nakliye_item_details = $this->db->query("SELECT * FROM talep_form_nakliye_products Where id=$nakliye_item_id")->row();

                $m_talep_details = $this->db->query("SELECT * FROM talep_form_products Where id=$talep_form_product_id")->row();
                $m_product_name = $m_talep_details->product_desc;
                $unit_name = units_($m_talep_details->unit_id)['name'];
                $arac_name=arac_details($nakliye_item_details->arac_id)->name;
                $depo_name=warehouse_details($warehouse_id)->title;
                $m_talep_id = $m_talep_details->form_id;


                $n_talep_id = $this->db->query("SELECT * FROM talep_form_nakliye_products Where id=$nakliye_item_id")->row()->form_id;


                $talep_form_Details = $this->db->query("SELECT * FROM talep_form_products Where id=$talep_form_product_id")->row();


                $talep_form_nakliye_product_arac=$this->db->query("SELECT * FROM talep_form_nakliye_product_arac Where n_item_id=$nakliye_item_id and m_item_id=$talep_form_product_id")->row();
                $product_stock_code_id = talep_form_product_options_teklif_values_new($talep_form_product_id);

                $tnf_arac_id = $talep_form_nakliye_product_arac->id;
                $stock_id = stock_update_new($talep_form_Details->product_id,$talep_form_Details->unit_id,$miktar,1,$warehouse_id,$this->aauth->get_user()->id,$m_talep_id,1,null,$tnf_arac_id);
                if($product_stock_code_id){
//                   $options_id='';
//                    $option_value_id='';
//                    $i=0;
//                    foreach ($options_details_res as $options_details){
//                        if ($i === array_key_last($options_details_res)) {// first loop
//                            $options_id.=$options_details['option_id'];
//                            $option_value_id.=$options_details['option_value_id'];
//                        }
//                        else {
//                            $options_id.=$options_details['option_id'].',';
//                            $option_value_id.=$options_details['option_value_id'].',';
//                        }
//                        $i++;
//                    }
                    stock_update_options_new($stock_id,$product_stock_code_id);
                }

                if($stock_id){

                    $product_name = product_details_($talep_form_Details->product_id)->product_name;
                    $unit_name = units_($talep_form_Details->unit_id)['name'];

                    $nakliye_id = $nakliye_item_details->form_id;
                    $nakliye_details = $this->db->query("SElECT * FROM talep_form_nakliye Where id=$nakliye_id")->row();


                    $this->mt_talep->talep_history($m_talep_id,$this->aauth->get_user()->id,'Depoya  '.$product_name.' Ürününden : '.$miktar .' '.$unit_name.' '.$depo_name.' Depoya Giriş Yapılmıştır');

                    $toplam_siparis = $this->db->query("SElECT product_qty FROM talep_form_products Where id=$talep_form_product_id")->row()->product_qty;
                    $toplam_alinan_qty = $this->db->query("SElECT SUM(quantity) as total FROM talep_form_nakliye_product_arac Where m_item_id=$talep_form_product_id")->row()->total;

                    $kalan=floatval($toplam_siparis)-floatval($toplam_alinan_qty);

                    $sayi++;


                    $this->model->talep_history($n_talep_id,$this->aauth->get_user()->id,$arac_name.' İsimli Araçtan  '.$m_product_name.' Ürününden : '.$miktar .' '.$unit_name.' '.$depo_name.' Depoya Giriş Yapılmıştır');


//
//                    if($nakliye_item_details->status==14){
//                        $data_item_update = [
//                            'status'=>15
//                        ];
//                        $this->db->where('id',$nakliye_item_id);
//                        $this->db->set($data_item_update);
//                        $this->db->update('talep_form_nakliye_products', $data_item_update);
//
//
//                        $data_item_mt_to = [
//                            'teslimat_durum'=>1
//                        ];
//                        $this->db->where('talep_item_id',$nakliye_item_id);
//                        $this->db->set($data_item_mt_to);
//                        $this->db->update('talep_form_nakliye_to_mt', $data_item_mt_to);
//                        $mesaj=$nakliye_details->code.' Numaralı Nakliye Talep Formunda Tamamlanan Araç Bulunmaktadır';
//                        $this->model->send_mail(lojistik_yetkili_id(),' Nakliy Talep Onayı',$mesaj);
//                    }




                }
            }
            if($sayi==$count){

                echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Araca Yüklendi",'kalan'=>$kalan));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
            }


        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Seçilen Herhangi Bir Ürün Yok.".' Hata '));
        }



    }

    public function nakliye_mt_talep(){
        $result = $this->model->nakliye_mt_talep();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }

    public function save_mt_talep(){
        $this->db->trans_start();
        $result = $this->model->save_mt_talep();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Talep Edildi"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }



    public function mt_atama_create(){
        $this->db->trans_start();
        $mt_id = $this->input->post('mt_id');
        $aciklama = $this->input->post('aciklama');
        $atama_id = $this->input->post('atama_id');
        $json_mt =  json_encode($mt_id);

        date_default_timezone_set('Asia/Baku');
        $date = new DateTime('now');
        $date_saat=$date->format('Y-m-d H:i:s');



        $data_Form_items=array(
            'mt_id'=>$json_mt,
            'mt_text'=>$aciklama,
            'updated_at'=>"$date_saat",
        );
        //Ödeme Bekliyor
        $this->db->set($data_Form_items);
        $this->db->where('id', $atama_id);
        if($this->db->update('nakliye_mt_talep', $data_Form_items)){

            $details = $this->db->query("SELECT * FROM nakliye_mt_talep Where id = $atama_id")->row();
            $talep_form_nakliye_details = $this->db->query("SELECT * FROM talep_form_nakliye  Where id =$details->talep_id")->row();
            $mesaj=$talep_form_nakliye_details->code.' Numaralı Nakliye Talep Formunda Mt Ataması Yapıldı';


            //$this->model->send_mail($talep_form_nakliye_details->aauth,' Nakliye Talep Onayı',$mesaj);

            echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Güncellendi"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }


    }
    public function odeme_talep(){
        $this->db->trans_start();
        $result = $this->model->odeme_talep();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['messages']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['messages']));
        }
    }


    public function dashboard_nakliye_item(){
        $lojistik_details = $this->input->post('lojistik_details');
        $nakliye_id = [];
        $result='';
        if($lojistik_details){
            foreach ($lojistik_details as $key=>$items){
                $nakliye_id[]=$items['nakliye_id'];
            }
            $nakliye_id = array_unique($nakliye_id);
            $str_nakliye = implode(',',$nakliye_id);
            $result = $this->db->query("SELECT talep_form_nakliye_products.*,araclar.plaka,araclar.name as arac_name FROM talep_form_nakliye_products
INNER JOIN araclar ON talep_form_nakliye_products.arac_id = araclar.id

Where
                    talep_form_nakliye_products.form_id IN ($str_nakliye) ")->result();
        }
        if($result){
            echo json_encode(array('status' => 200, 'items' => $result));
        }
        else {
            echo json_encode(array('status' => 410));
        }
    }

    public function customer_payment_update(){
        $this->db->trans_start();
        $talep_item_id = $this->input->post('item_id');
        $account_id = $this->input->post('account_id');
        $cach_personel = $this->input->post('cach_personel');
        $cach_cari_id = $this->input->post('cach_cari_id');
        $cach_method = $this->input->post('cach_method');
        $alacak_tutar = $this->input->post('alacak_tutar');
        $tip = $this->input->post('tip');

        $details_item_form = $this->db->query("SELECT * FROM talep_form_nakliye_products where id=$talep_item_id")->row();
        $talep_id=$details_item_form->form_id;
        $details_form = $this->db->query("SELECT * FROM talep_form_nakliye where id=$talep_id")->row();

        $not = $this->input->post('not').' '.$details_form->code.' İstinaden Ödeme';
        $invoice_type_id = 4; //Ödeme
        $role_id = $this->aauth->get_user()->roleid;
        $form_total = $this->model->form_total($talep_id);
        $user_id  = $this->aauth->get_user()->id;





        if($user_id==$details_item_form->payment_personel_id || $role_id==1 ||  $role_id==48 ||  $role_id==6) {
            $data = array(
                'csd' => $cach_cari_id,
                'payer' => customer_details($cach_cari_id)['company'],
                'acid' => $account_id, //hesapID ekleneck
                'account' => account_details($account_id)->holder,
                'total' => $alacak_tutar,
                'invoice_type_id'=>$invoice_type_id,
                'invoice_type_desc'=>invoice_type_desc($invoice_type_id),
                'method' => $cach_method,
                'eid' => $this->aauth->get_user()->id, //user_id
                'notes' => $not,
                'term' => $talep_item_id,
                'loc' => $this->session->userdata('set_firma_id'),
                'proje_id' => $details_form->proje_id,
            );
            if($this->db->insert('geopos_invoices', $data)){
                $last_id = $this->db->insert_id();
                $data_pay = array(
                    'form_item_id'=>$talep_item_id,
                    'form_id'=>$talep_id,
                    'transaction_id'=>$last_id,
                    'tip'=>1,
                    'total'=>$alacak_tutar,
                    'cach_personel'=>$cach_personel,
                );
                $this->db->insert('talep_form_nakliye_payment', $data_pay);
                $odeme_total = $this->model->odeme_total($talep_id);


                if($form_total == $odeme_total) {


                    //alacaklandırma kontrolü
                    $details_item_form_items = $this->db->query("SELECT * FROM talep_form_nakliye_products where form_id=$talep_id")->result();
                    $alacak_say = 0;
                    $alacak_item_id = [];
                    foreach ($details_item_form_items as $alacak_durums){
                        if(is_null($alacak_durums->alacak_durum)){
                            $alacak_say++;
                            $alacak_item_id[]=$alacak_durums->id;
                        }
                    }

                    if($alacak_say){
                        foreach ($alacak_item_id as $it_id){
                            $alacak_items = $this->db->query("SELECT * FROM talep_form_nakliye_products where id=$it_id")->row();
                            if($alacak_items->method==1)// Nakit
                            {
                                // Cari Alacaklandır
                                $not = $details_form->code.' | '.$alacak_items->code.' İstinaden Alacaklandırma';
                                $data = array(
                                    'csd' => $alacak_items->cari_id,
                                    'payer' => customer_details($alacak_items->cari_id)['company'],
                                    'acid' => 0, //hesapID ekleneck
                                    'account' => 'Kasasız İşlem',
                                    'total' => $alacak_items->total,
                                    'invoice_type_id'=>39,
                                    'invoice_type_desc'=>invoice_type_desc(39),
                                    'method' => $alacak_items->method,
                                    'eid' => $this->aauth->get_user()->id, //user_id
                                    'notes' => $not,
                                    'proje_id' => $details_form->proje_id,
                                );
                                if($this->db->insert('geopos_invoices', $data)) {
                                    $data_talep_updata =
                                        [
                                            'alacak_durum' => 1,
                                        ];
                                    $this->db->where('id', $it_id);
                                    $this->db->set($data_talep_updata);
                                    $this->db->update('talep_form_nakliye_products', $data_talep_updata);
                                }
                                // Cari Alacaklandır
                            }

                        }
                    }
                    //alacaklandırma kontrolü


                    $data_talep_updata =
                        [
                            'odeme_durum' => 1,
                            'status' => 9,
                        ];
                    $this->db->where('id', $talep_id);
                    $this->db->set($data_talep_updata);
                    $this->db->update('talep_form_nakliye', $data_talep_updata);
                }


                //items İçin
                $odeme_item_total = $this->model->odeme_total_item($talep_item_id);
                if($details_item_form->total == $odeme_item_total) {

                }

               // $details_item_form->alacak_durum
                $data_talep_updata =
                    [
                        'odeme_durum' => 1,
                        'status' => 9,
                    ];
                $this->db->where('id', $talep_item_id);
                $this->db->set($data_talep_updata);
                $this->db->update('talep_form_nakliye_products', $data_talep_updata);

                //items İçin

                $talep_details = $this->db->query("SELECT talep_form_nakliye.*,talep_form_nakliye_products.form_id,talep_form_nakliye_products.arac_id,talep_form_nakliye_products.lokasyon,talep_form_nakliye_products.cari_id FROM talep_form_nakliye_products INNER JOIN talep_form_nakliye ON talep_form_nakliye_products.form_id = talep_form_nakliye.id  Where talep_form_nakliye_products.id=$talep_item_id")->row();
                $lokasyon=$talep_details->lokasyon;
                $arac_name='Araç Tanımlanmamış';
                $cari_name='Cari Tanımlanmamış';
                if($talep_details->arac_id){
                    $arac_name=arac_details($talep_details->arac_id)->name;
                }
                if($cach_cari_id){
                    $cari_name=customer_details($cach_cari_id)['company'];
                }


                $messages = $cari_name.' Ait '.$arac_name.' ile gidilen '.$lokasyon.' Lokasyon İçin Ödeme Yapıldı';

                $this->model->talep_history($talep_id, $this->aauth->get_user()->id, $messages.' : '.amountFormat($alacak_tutar));
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


//        if($tip=='muhasebe'){
//            if($role_id==1){
//                $data = array(
//                    'csd' => $details_form->cari_id,
//                    'payer' => customer_details($details_form->cari_id)['company'],
//                    'acid' => $account_id, //hesapID ekleneck
//                    'account' => account_details($account_id)->holder,
//                    'total' => $alacak_tutar,
//                    'invoice_type_id'=>$invoice_type_id,
//                    'invoice_type_desc'=>invoice_type_desc($invoice_type_id),
//                    'method' => $details_form->method,
//                    'eid' => $this->aauth->get_user()->id, //user_id
//                    'notes' => $not,
//                    'loc' => $this->session->userdata('set_firma_id'),
//                    'proje_id' => $details_form->proje_id,
//                );
//                if($this->db->insert('geopos_invoices', $data)){
//                    $last_id_invoice_id = $this->db->insert_id();
//                    $data_pay = array(
//                        'form_id'=>$id,
//                        'transaction_id'=>$last_id_invoice_id,
//                        'total'=>$alacak_tutar,
//                        'tip'=>2,
//                        'cach_personel'=>$cach_personel,
//                    );
//                    $this->db->insert('talep_form_customer_new_payment', $data_pay);
//                    $odeme_total = $this->model->odeme_total($id);
//
//
//                    $this->model->talep_history($id, $this->aauth->get_user()->id, ' Ödeme Yapıldı : '.amountFormat($alacak_tutar));
//                    $this->db->trans_complete();
//                    echo json_encode(array('status' => 'Success', 'message' => 'Başarıyla Güncellendi'));
//
//
//                }
//                else {
//                    $this->db->trans_rollback();
//                    echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun." . ' Hata '));
//                }
//            }
//            else {
//                $this->db->trans_rollback();
//                echo json_encode(array('status' => 'Error', 'message' => "Yetkiniz Bulunmamaktadır"));
//            }
//        }
//        else {
//
//        }

    }

    public function delete_item_form(){
        $this->db->trans_start();
        $id = $this->input->post('item_id');
        $details = $this->db->query("SELECT * FROM talep_form_nakliye_products Where id=$id")->row();
        $type = $this->input->post('type');
        $product_name = '';

        $details_form = $this->model->details($details->form_id);
        $user_id  = $this->aauth->get_user()->id;
        $yetkili_kontrol  = $this->db->query("SELECT * FROM `geopos_projects` where id = $details_form->proje_id and (  proje_sorumlusu_id=$user_id or proje_muduru_id=$user_id or muhasebe_muduru_id=$user_id or genel_mudur_id=$user_id)")->num_rows();
        $aauth  = $this->db->query("SELECT * FROM `talep_form_nakliye` where id = $details->form_id and aauth=$user_id")->num_rows();

        if($yetkili_kontrol || $aauth ||  $user_id == lojistik_yetkili_id()) {
            if($type==1){
                $this->model->talep_history($details->form_id,$this->aauth->get_user()->id,$product_name.' Ürünü Kaldırıldı');
            }

            if($this->db->delete('talep_form_nakliye_products', array('id' => $id))){

                $this->aauth->applog("Nakliye Talebinden Ürün Silindi  :  ID : ".$id, $this->aauth->get_user()->username);
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

    public function dashboard_nakiye_item_status_change(){
        $this->db->trans_start();
        $lojistik_details = $this->input->post('lojistik_details');
        $type = $this->input->post('type');
        $status=0;
        if($type=="yukleme"){
            $status=14;
        }
        elseif($type=="tehvil"){
            $status=15;
        }
        $count = count($lojistik_details);
        $say=0;
        if($lojistik_details){
            foreach ($lojistik_details as $key=>$items){
                $nakliye_id=$items['nakliye_id'];
                $talep_form_product_id=$items['talep_form_product_id'];
                $nakliye_item_id_result = $this->db->query("SELECT * FROM talep_form_nakliye_product_arac Where m_item_id = $talep_form_product_id and n_talep_id=$nakliye_id");
                if($nakliye_item_id_result->num_rows()){
                   foreach ($nakliye_item_id_result->result() as $nakliye_item_id){

                       $data_item_update = [
                           'status'=>$status
                       ];
                       $this->db->where('id',$nakliye_item_id->n_item_id);
                       $this->db->set($data_item_update);
                       $this->db->update('talep_form_nakliye_products', $data_item_update);


                       if($type=='yukleme'){
                           $data_item_mt_to = [
                               'yukleme_durum'=>1
                           ];
                           $this->db->where('talep_item_id',$nakliye_item_id->n_item_id);
                           $this->db->set($data_item_mt_to);
                           $this->db->update('talep_form_nakliye_to_mt', $data_item_mt_to);
                           $say++;
                           $this->model->talep_history($nakliye_id,$this->aauth->get_user()->id,'Yükleme Yapıldı');
                       }
                       else if($type=='tehvil'){
                           $data_item_mt_to = [
                               'teslimat_durum'=>1
                           ];
                           $this->db->where('talep_item_id',$nakliye_item_id->n_item_id);
                           $this->db->set($data_item_mt_to);
                           $this->db->update('talep_form_nakliye_to_mt', $data_item_mt_to);
                           $say++;
                           $this->model->talep_history($nakliye_id,$this->aauth->get_user()->id,'Tehvil Yapışdı');

                       }

                   }
                }




            }
            if(intval($say)){


                $this->db->trans_complete();
                echo json_encode(array('status' => 200,'message'=>$say.' yükleme  İçin İşlem Tamamlandı'));
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410,'message'=>'İşlem Gerçekleşemedi'));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410,'message'=>'İşlem Gerçekleşemedi'));
        }

    }
    public function ajax_list_onay_bekleyen(){


        $list = $this->model->ajax_list_onay_bekleyen();
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
            $view = "<a class='btn btn-success view' href='/nakliye/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";

            $odeme_total = $this->model->odeme_total($prd->id);
            $form_total = $this->model->form_total($prd->id);
            $kalan=floatval($form_total)-floatval($odeme_total);

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->created_at;
            $row[] = $prd->pers_name;
            $row[] = $prd->code;
            $row[] = $prd->st_name;
            $row[] =$view;
            $row[] =$style;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_bekleyen(),
            "recordsFiltered" => $this->model->count_filtered_bekleyen(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function nakliyeteklifbekleyen(){
        $result = $this->talep->nakliyeteklifbekleyen();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }
    public function talep_nakliye_transfer_info(){
         $nakliye_item_id = $this->input->post('nakliye_item_id');
         $kontrol = $this->db->query("SELECT * FROM nakliye_talep_transfer Where n_item_id=$nakliye_item_id");
         if($kontrol->num_rows()){
             $ntt_id = $kontrol->row()->id;
             $result = $this->db->query("SELECT * FROM nakliye_talep_transfer_item Where ntt_id=$ntt_id ORDER BY sort ASC");
             if($result->num_rows()){
                 $details=[];
                 foreach ($result->result() as $items_value){

                     $type_text='Yükleme Yapacak Depo';
                     if($items_value->type==2){
                         $type_text='Teslim Alacak Depo';
                     }
                     $details[]=
                         [
                             'type_text'=>$type_text,
                             'sort' => $items_value->sort,
                             'text' => $items_value->text_desc,
                             'item_id' => $items_value->id,
                             'warehose_name'=>warehouse_details($items_value->warehouse_id)->title,
                         ];
                 }
                 echo json_encode(array('status' => 200, 'items' =>$details,'bildirim_durumu'=>$kontrol->row()->bildirim_durumu));
             }
             else {
                 echo json_encode(array('status' => 410));
             }




         }
         else {
             echo json_encode(array('status' => 410));
         }

    }

    public function transfer_item_add(){
        $this->db->trans_start();
        $result = $this->model->transfer_item_add();
        if($result['status']){

            echo json_encode(array(
                'status' => 200,
                'message' =>$result['messages'],
                'warehose_name'=>$result['warehose_name'],
                'type_text'=>$result['type_text'],
                'sort'=>$result['sort'],
                'text'=>$result['text'],
                'id'=>$result['id']
            ));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['messages']));
        }
    }

    public function delete_warehouse_item(){
        $this->db->trans_start();
        $id = $this->input->post('id');
        if($this->db->delete('nakliye_talep_transfer_item', array('id' => $id))){

            $this->aauth->applog("Nakliye Talebinden Belirli Depo Silindi  :  ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 200,'messages'=>'Başarıyla Silindi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410,'messages'=>'Hata Aldınız'));
        }
    }

    public function transfer_arac_add(){
        $this->db->trans_start();
        $index=0;
        $rusults = $this->input->post('collection');
        $tip = $this->input->post('tip');
        $nakliye_item_id = $this->input->post('nakliye_item_id');
        $onay_id = $this->input->post('onay_id');
        $nakliye_talep_transfer_item_id = $this->input->post('nakliye_talep_transfer_item_id');

        $fis_type=1;
        if($tip==1){
            $fis_type=0;
        }
        if($rusults){

            foreach($rusults as $result){
                // Depodan araca yükleme

                stock_update_new($result['product_id'],$result['unit_id'],$result['qty'],$fis_type,$this->input->post('warehouse_id'),$this->aauth->get_user()->id,$nakliye_item_id,8);
                $stock_id = $this->db->insert_id();
                $data_insert  = [
                    'nakliye_item_id'=>$nakliye_item_id,
                    'nakliye_talep_transfer_item_id'=>$nakliye_talep_transfer_item_id,
                    'stok_id'=>$stock_id,
                    'type'=>0,
                    'desc'=>$result['desc'],
                    'auth_id'=>$this->aauth->get_user()->id,
                ];
                $this->db->insert('nakliye_talep_transfer_arac', $data_insert);

                stock_update_options_new($stock_id,$result['product_stock_code_id']);
                $index++;
                //Depodan araca yükleme
            }
            if($index){
                $this->aauth->applog("Nakliye Talebindeki araca yükleme yapıldı :  nakliye_item_id : ".$nakliye_item_id, $this->aauth->get_user()->username);
                $this->db->trans_complete();
                echo json_encode(array('status' => 200,'message'=>'Başarıyla Yükleme Yapıldı.Deponuzdan Ürünler düştü!'));
            }
            else {
                echo json_encode(array('status' => 410, 'message' =>'Herhangi bir işlem yapılmamıştır.'));
                $this->db->trans_rollback();
            }
        }
        else {
            echo json_encode(array('status' => 410, 'message' =>"Herhangi bir ürün gönderilmemiştir."));
            $this->db->trans_rollback();
        }

    }

    public function transfer_bildirimi(){
        $this->db->trans_start();
        $nakliye_item_id = $this->input->post('nakliye_item_id');
        $id = $this->db->query("SELECT * FROM talep_form_nakliye_products Where id =$nakliye_item_id")->row()->form_id;
        $details = $this->model->details($id);
            $users_ = onay_sort(13,$details->proje_id,0,$nakliye_item_id);

            if($users_){

                $data = array(
                    'bildirim_durumu' => 1,
                );
                $this->db->set($data);
                $this->db->where('n_item_id', $nakliye_item_id);
                if($this->db->update('nakliye_talep_transfer', $data)) {

                foreach ($users_ as $items){
                    $staff=0;
                    if($items['sort']==1){
                        // bildirim maili at
                        $mesaj=$details->code.' Numaralı Nakliye Talep Formu Onayınızı Beklemektedir';
                        //$this->model->send_mail($items['user_id'],' Gider Talep Onayı',$mesaj);
                        // bildirim maili at
                        $staff=1;
                    }
                    $data_onay = array(
                        'talep_id' => $id,
                        'type' => 3,
                        'nakliye_talep_transfer_item_id'=>$items['nakliye_talep_transfer_item_id'],
                        'staff' => $staff,
                        'sort' => $items['sort'],
                        'user_id' => $items['user_id']
                    );

                    $this->db->insert('talep_onay_nakliye', $data_onay);
                }

                $this->model->talep_history($id,$this->aauth->get_user()->id,' Onay İşlemi Başlatıldı');
                $this->aauth->applog("Nakliye Talebinde Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);
                $this->db->trans_complete();
                echo json_encode(array('status' => 200,'message'=>'Başarıyla Bildirim Başlatıldı'));

            }
            else {

                echo json_encode(array('status' => 410, 'message' =>"Projenize Yetkili Kişiler Atanmamıştır veya Depolarda Yetkili Kişiler Atanmamıştır.Bu Sebeple İşlem Yapamazsınız."));
                $this->db->trans_rollback();

            }

        }
        else {
            echo json_encode(array('status' => 410, 'message' =>"Projenize Yetkili Kişiler Atanmamıştır veya Depolarda Yetkili Kişiler Atanmamıştır.Bu Sebeple İşlem Yapamazsınız."));
            $this->db->trans_rollback();
        }

    }

    public function delete_arac_item_stock(){
        $nakliye_talep_transfer_arac_id =  $this->input->post('id');
        $stock_id =  $this->input->post('stock_id');
        $this->db->trans_start();
        $user_id  = $this->aauth->get_user()->id;


        if($this->db->query('DELETE FROM `nakliye_talep_transfer_arac` WHERE auth_id='.$user_id.' and `nakliye_talep_transfer_arac`.`id` ='.$nakliye_talep_transfer_arac_id)){
            //$this->db->delete('stock', array('id' => $stock_id));
            $this->aauth->applog("Nakliye Talebinden Yüklenen Ürünler Geri Alındı  :  ID : ".$nakliye_talep_transfer_arac_id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 200,'messages'=>'Başarıyla Silindi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410,'messages'=>'Hata Aldınız'));
        }

    }


    public function transfer_info(){
        $item_id = $this->input->post('item_id');

        $sql = $this->db->query("SELECT * FROM nakliye_talep_transfer_item Where n_item_id=$item_id ORDER BY SORT ASC");

        $html='<div class="list"><div class="delivery-main-message orange"><br></div><div class="ty-content">
                         <div class="delivery-progress">
                            <div class="delivery-progress-flex">';
        if($sql){
            foreach ($sql->result() as $items){


                $onay=$this->db->query("SELECT talep_onay_nakliye.id as onay_id,talep_form_nakliye_products.id as item_id,talep_form_nakliye_products.code as item_code,CONCAT(araclar.name,araclar.plaka) as arac_name,talep_form_nakliye.code as nakliye_code,talep_onay_nakliye.nakliye_talep_transfer_item_id,
       nakliye_talep_transfer_item.text_desc

FROM talep_onay_nakliye
         INNER JOIN talep_form_nakliye_products ON talep_onay_nakliye.talep_id = talep_form_nakliye_products.form_id
         INNER JOIN talep_form_nakliye ON talep_form_nakliye_products.form_id = talep_form_nakliye.id
         INNER JOIN araclar ON talep_form_nakliye_products.arac_id=araclar.id
         INNER JOIN nakliye_talep_transfer_item ON nakliye_talep_transfer_item.id=talep_onay_nakliye.nakliye_talep_transfer_item_id
Where talep_onay_nakliye.type=3 and talep_form_nakliye_products.id=$item_id and talep_onay_nakliye.status
    is null and talep_onay_nakliye.staff=1;
")->row();


                $type_name="YÜKLEME YAPACAK DEPO";
                $pers_id = warehouse_details($items->warehouse_id)->pers_id;
                $warehouse_name=warehouse_details($items->warehouse_id)->title;
                $personel_name=personel_details($pers_id);
                if($items->type==2){
                    $type_name='TESLIM ALACAK DEPO';
                }
                $html.='<div class="wrapper active">';

                            if($items->id==$onay->nakliye_talep_transfer_item_id){
                                $html.='<div class="circle" style="background: #0bc15c;border: 3px solid #0bc15c;">';
                            }
                            else{
                                $html.='<div class="circle">';
                            }
                                $html.='<i class="fa fa-warehouse fa-3x" style="color:white"></i>
                            </div>
                                <div class="content">'.$type_name.'</div>
                                <span class="text-muted">Depo Adı : '.$warehouse_name.'</span>
                                <span class="text-muted">Sorumlu Personel : '.$personel_name.'</span>
                            </div>';
            }
        }




                        $html.='</div>
                    </div>
                </div>
            <hr></div>';

        echo json_encode(array('status' => 200,'html'=>$html));
    }

    public function arac_warehouse_view(){
        $nakliye_item_id = $this->input->post('nakliye_item_id');
        $sql = $this->db->query("select 
    nakliye_talep_transfer_arac.id as nakliye_talep_transfer_arac_id,
     geopos_warehouse.title as anbar,
       stock.created_at as yukleme_zamani,
       geopos_employees.name as yukleme_yapan_personel,
       geopos_products.product_name,
       psc.code as varyasyon,
       stock.id as stok_id,
stock.qty as qty_float,
geopos_units.name as unit_name,
       CONCAT(stock.qty,' ',geopos_units.name) as miqdar,
       nakliye_talep_transfer_arac.desc as aciklama,
        nakliye_talep_transfer_arac.id,
        nakliye_talep_transfer_arac.stok_id
       from nakliye_talep_transfer_arac
Inner JOIN stock on nakliye_talep_transfer_arac.stok_id=stock.id
Inner JOIN stock_to_options on stock.id = stock_to_options.stock_id
INNER JOIN product_stock_code psc on stock_to_options.product_stock_code_id = psc.id
Inner JOIN geopos_products ON stock.product_id=geopos_products.pid
Inner JOIN geopos_warehouse ON stock.warehouse_id=geopos_warehouse.id
Inner  JOIN geopos_employees ON stock.aauth_id=geopos_employees.id
Inner  JOIN geopos_units ON stock.unit=geopos_units.id
WHERE nakliye_talep_transfer_arac.nakliye_item_id=$nakliye_item_id and nakliye_talep_transfer_arac.type=0");
        if($sql->num_rows()){
            $items_details=[];
            foreach ($sql->result() as $items){
                $kontrol = $this->db->query("SELECT nakliye_talep_transfer_arac.old_stok_id,SUM(qty) as qty FROM
                           nakliye_talep_transfer_arac 
                           Inner JOIN stock on nakliye_talep_transfer_arac.stok_id=stock.id                  
                           Where nakliye_talep_transfer_arac.old_stok_id = $items->stok_id and nakliye_talep_transfer_arac.type=1 GROUP BY old_stok_id");
                if($kontrol->num_rows()){
                    if($kontrol->row()->qty < $items->qty_float){
                        $max_qty=floatval($items->qty_float)-floatval($kontrol->row()->qty);
                        $items->max_qty=$max_qty;
                        $items->new_miqdar=$max_qty.' '.$items->unit_name;
                        $items_details[]=$items;
                    }

                }
                else {
                    $max_qty=floatval($items->qty_float);
                    $items->max_qty=$max_qty;
                    $items->new_miqdar=$max_qty.' '.$items->unit_name;
                    $items_details[]=$items;
                }
            }
            if($items_details){
                echo json_encode(array('status' => 200, 'items' =>$items_details));
            }
            else {
                echo json_encode(array('status' => 410,'message'=>'Araçta mehsul bulunamadı'));
            }

        }
        else {
            echo json_encode(array('status' => 410,'message'=>'Araçta mehsul bulunamadı'));
        }
    }

    public function transfer_finish(){
        $this->db->trans_start();
        $tip = $this->input->post("tip");
        $nakliye_item_id = $this->input->post("nakliye_item_id");
        $nakliye_talep_transfer_item_id = $this->input->post("nakliye_talep_transfer_item_id");
        $onay_id = $this->input->post("onay_id");
        $form_id = $this->db->query("SELECT * FROM talep_form_nakliye_products Where id=$nakliye_item_id")->row()->form_id;

        $details = $this->db->query("SELECT * FROM talep_form_nakliye Where id = $form_id")->row();

        $history_message='Tehvil Alındı. İşlem Tamamlandı';
        if($tip==1){
            $history_message='Yükleme Yapıldı. İşlem Tamamlandı';
        }
        $id = $this->input->post("nakliye_item_id");
        $type = 3;

        $new_id=0;
        $new_user_id=0;
        $new_id_control = $this->db->query("SELECT * FROM `talep_onay_nakliye` Where type=$type and talep_id=$id and staff=0 and status is Null ORDER BY `talep_onay_nakliye`.`id` ASC LIMIT 1");
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
        if ($this->db->update('talep_onay_nakliye', $data)) {

            $this->model->talep_history($form_id,$this->aauth->get_user()->id,$history_message);
            if($new_id){

                $mesaj=$details->code.' Numaralı Nakliye Gider Talep Formu İşleminizi Beklemektedir';
                //$this->model->send_mail($new_user_id,'Nakliye Talep Formu',$mesaj);

                // Bir Sonraki Onay
                $data_new=array(
                    'staff'=>1,
                );
                $this->db->where('id',$new_id);
                $this->db->set($data_new);
                $this->db->update('talep_onay_nakliye', $data_new);
                // Bir Sonraki Onay
            }
            else {

                $data_Form=array(
                    'status'=>11,
                );

                $this->db->set($data_Form);
                $this->db->where('id', $id);
                $this->db->update('talep_form_nakliye_products', $data_Form);
            }
            $this->db->trans_complete();
            echo json_encode(array('status' => 200,'message'=>'Başarıyla Onay Verildi'));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));

        }


    }
    public function transfer_tehvil()
    {
        $this->db->trans_start();
        $nakliye_item_id = $this->input->post('nakliye_item_id');


        $talep_form_Details = $this->db->query("SELECT * FROM talep_form_nakliye_products Where id=$nakliye_item_id")->row();


        $nakliye_talep_transfer_item_id = $this->input->post('nakliye_talep_transfer_item_id');
        $nakliye_talep_transfer_item_details = $this->db->query("SELECT * FROM nakliye_talep_transfer_item Where id=$nakliye_talep_transfer_item_id")->row();
        $warehouse_id = $nakliye_talep_transfer_item_details->warehouse_id;
        $onay_id = $this->input->post('onay_id');
        $tehvil_details = $this->input->post('tehvil_details');
        if($tehvil_details){
            $index=0;
            foreach ($tehvil_details as $item_values){
                $tehvil_qty = $item_values['tehvil_qty'];
                $nakliye_talep_transfer_arac_id = $item_values['nakliye_talep_transfer_arac_id'];

                $transfer_arac_details = $this->db->query("SELECT 
    stock_to_options.product_stock_code_id,
    stock.*
    FROM nakliye_talep_transfer_arac 
                INNER JOIN stock On nakliye_talep_transfer_arac.stok_id = stock.id
                LEFT JOIN stock_to_options On stock.id = stock_to_options.stock_id
                    Where nakliye_talep_transfer_arac.id=$nakliye_talep_transfer_arac_id");
                if($transfer_arac_details->num_rows()){
                    foreach ($transfer_arac_details->result() as $items){
                        $old_stock_id = $items->id;
                        $stock_details = $this->db->query("SELECT * FROM stock Where id=$old_stock_id")->row();
                        $old_product_stock_code_id = $items->product_stock_code_id;
                        $old_product_id = $stock_details->product_id;
                        $old_unit_id = $stock_details->unit;
                        $tnf_arac_id = $nakliye_talep_transfer_arac_id;
                        $stock_id = stock_update_new($old_product_id,$old_unit_id,$tehvil_qty,1,$warehouse_id,$this->aauth->get_user()->id,$nakliye_item_id,8,null,$tnf_arac_id);

                        $data_insert  = [
                            'nakliye_item_id'=>$nakliye_item_id,
                            'nakliye_talep_transfer_item_id'=>$nakliye_talep_transfer_item_id,
                            'stok_id'=>$stock_id,
                            'type'=>1,
                            'old_stok_id'=>$old_stock_id,
                            'auth_id'=>$this->aauth->get_user()->id,
                        ];
                        $this->db->insert('nakliye_talep_transfer_arac', $data_insert);

                        if($old_product_stock_code_id){
                            stock_update_options_new($stock_id,$old_product_stock_code_id);
                        }
                    }
                }

                $index++;
            }

            if($index){
                $this->db->trans_complete();
                echo json_encode(array('status' => 200,'message'=>$index.' adet ürün başarılı bir şekilde depoya alındı'));
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>"Ürünler İçeri Alınamadı"));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Tehvil Detayları Alınamadı"));

        }
    }

    public function status_upda(){
        if (!$this->aauth->premission(47)->write) {
            echo json_encode(array('status' => 410, 'message' =>'İptal Etmek İçin Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $file_id = $this->input->post('file_id');
            $desc = $this->input->post('desc');
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

    public function update_form(){
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

    public function item_info()
    {
        $item_id = $this->input->post('item_id');
        $item_details = $this->model->product_details_who($item_id);
        echo json_encode(array('status' => 200, 'items' =>$item_details));

    }

    public function ajax_list_report(){

        $list = $this->model->list_report();


        $data = array();
        $total=0;
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
            $view = "<a class='btn btn-success view' href='/nakliye/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";

            $odeme_total = $this->model->odeme_total($prd->id);
            $form_total = $this->model->form_total($prd->id);
            $kalan=floatval($form_total)-floatval($odeme_total);


            $gider_durumu = '<span class="badge badge-pill badge-light">Gidere İşlenmedi</span>';
            $invoice_durumu = '<span class="badge badge-pill badge-light">Faturalaşmadı</span>';
            if($prd->gider_durumu){
                $gider_durumu='<span class="badge badge-pill badge-secondary">Gidere İşlendi</span>';
            }
            if($prd->invoice_durumu){
                $invoice_durumu='<span class="badge badge-pill badge-secondary">Faturalaştı</span>';
            }
            $total+=$prd->p_total;
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' value='$prd->p_total' class='form-control one_select'>";
            $row[] = $prd->code;
            $row[] = $prd->created_at;
            $row[] = $prd->pers_name;
            $row[] =$prd->desc;
            $row[] =$prd->p_code;
            $row[] = $prd->proje_name;
            $row[] = $prd->company;
            $row[] = amountFormat($prd->p_price);
            $row[] = amountFormat_s($prd->p_qty).' '.units_($prd->p_unit_id)['name'];
            $row[] = amountFormat($prd->p_total);
            $row[] = $prd->st_name;
            $row[] = $prd->p_lokasyon;
            $row[] =$view;
            $row[] =$style;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_report(),
            "recordsFiltered" => $this->model->count_filtered_report(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_notes(){

        $talep_id=$this->input->post('talep_id');

        $list = $this->model->get_datatables_query_details_talep_list_notes($talep_id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $cancel = "<button class='btn btn-danger notes_sil' talep_id='$talep_id'  notes_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
            $no++;
            $row = array();
            $row[] = $prd->created_at;
            $row[] = $prd->desc;
            $row[] = $prd->pers_name;
            $row[] =$cancel;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_talep_notes($talep_id),
            "recordsFiltered" => $this->model->count_filtered_talep_notes($talep_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function create_save_notes(){
        $this->db->trans_start();
        $result = $this->model->create_save_notes();
        if($result['status']){

            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Notunuz Oluşturuldu"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }

    public function notes_delete(){
        $this->db->trans_start();
        $id = $this->input->post('notes_id');
        $details = $this->db->query("SELECT * FROM talep_form_notes_nakliye WHERE id=$id ");
        if($details->num_rows()){
            if($details->row()->aaut_id == $this->aauth->get_user()->id){
                if($this->db->delete('talep_form_notes_nakliye', array('id' => $id))){
                    $this->aauth->applog("Nakliye Talebinden Note Silindi  : File ID : ".$id, $this->aauth->get_user()->username);
                    $this->db->trans_complete();
                    echo json_encode(array('status' => 'Success','message'=>'Başarıyla Silindi'));
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
                }
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Notu Oluşturan Personelden Başkası Silemez!."));
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Böyle Bir Not Bulunamadı."));
        }


    }



}