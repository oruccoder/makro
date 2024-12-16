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

class Personel Extends CI_Controller
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
        $this->load->model('Personel_model', 'model');
    }

    public function index()
    {
        if (!$this->aauth->premission(7)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('personel/index');
        $this->load->view('fixed/footer');
    }
    public function ajax_list(){
        $list = $this->model->list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {



            $bakiye=personel_bakiye_report($prd->id);
            $btn='';
            $edit = "<button class='btn btn-outline-warning edit' pers_id='$prd->id'><i class='fa fa-pen'></i></button>&nbsp;";
            $view = "<a class='btn btn-outline-success'  href='/personel/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";
            $disable= "<button pers_id='$prd->id' class='btn btn-outline-success disabled_button' ><i class='fa fa-chain-broken'></i>Pasifleştir</button>&nbsp;";

            $cart= "<button pers_id='$prd->id' class='btn btn-outline-info cart_button' ><i class='fa fa-credit-card'></i> Maaş Kartı</button>&nbsp;";

            $cart_kontrol = $this->db->query("SELECT * FROM personel_cart WHERE pers_id=$prd->id and status=1");
            if($cart_kontrol->num_rows()){
                $date = new DateTime('now');
                $yil =  $date->format('Y');
                $m =  $date->format('m');
                $cart_yil=$cart_kontrol->row()->skt_yil;
                $cart_ay=$cart_kontrol->row()->skt_ay;

                if($cart_yil <= $yil){
                    $kalan=intval($cart_ay)-intval($m);

                    if($kalan <= 1){
                        $cart= "<button pers_id='$prd->id' class='btn btn-outline-danger cart_button' ><i class='fa fa-credit-card'></i> Maaş Kartı</button>&nbsp;";
                    }
                }
            }



            //$maas_proje= "<button  data-object-id='" . $prd->id . "' class='btn btn-outline-info  maas_pers' title='Maas Düzenleme'><i class='fa fa-money'></i> Maaş / Proje</button>";
            $mezuniyet=mezuniyet_report($prd->id)['mezuniyet_total'];
            $mezuniyet_kalan=mezuniyet_report($prd->id)['mezuniyet_kalan'];
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='form-control one_select' pers_id='$prd->id'>";
            $row[] = $no;
            $row[] = '<img class="img-fluid rounded-circle" id="profile_images" src="/userfiles/employee/'.$prd->picture.'" width="60" height="60" alt="">';
            $row[] = $prd->name;
            $row[] = $prd->role_name;
            $row[] = $prd->proje_code;
            $row[] = $prd->phone;
            $row[] = "<input type='password' class='bakiye' style='cursor: default;border: none;' value='$bakiye'><i class='fa fa-eye-slash bakiye_show'></i>";
            $row[] = "<input type='number' pers_id='$prd->id' class='mezuniyet form-control' style='cursor: default;border: none;' value='$mezuniyet'>";
            $row[] = $mezuniyet_kalan;
            $row[] = saatlik_izin_rapor($prd->id);

            $row[] = $edit.$view.$disable.$cart;
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
        if (!$this->aauth->premission(7)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->create_save();
            if($result['status']){
                echo json_encode(array('status' => 200, 'message' =>$result['message']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }
    }


    public function update(){
        if (!$this->aauth->premission(7)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->update();
            if($result['status']){
                echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Talep Güncellendi"));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
            }
        }
    }
    public function delete(){
        if (!$this->aauth->premission(7)->delete) {
            echo json_encode(array('status' => 410, 'message' =>'Silmek İçin Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->delete();
            if($result['status']){
                echo json_encode(array('status' => 200, 'message' =>$result['message']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }
    }

    public function disable_user(){
        if (!$this->aauth->premission(7)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Güncellemek İçin Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->disable_user();
            if($result['status']){
                echo json_encode(array('status' => 200, 'message' =>$result['message']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }
    }
    public function info(){
        $id=$this->input->post('id');
        $details = $this->model->details($id);
        $users_details = $this->model->users_details($id);
        $salary_details = $this->model->salary_details($id);
        $paralel_details = $this->model->paralel_details($id);
        echo json_encode(array('status' => 200,
            'items' =>$details,
            'users_details' =>$users_details,
            'salary_details' =>$salary_details,
            'paralel_details' =>$paralel_details,
        ));
    }


    public function yetkili_kontrol(){
        $id = $this->input->post('id');
        if (!$this->aauth->premission($id)->read) {
            echo json_encode(array('status' => 410, 'message' =>'Görüntülemek İçin Yetkiniz Yoktur'));
        }
        else {
            echo json_encode(array('status' => 200, 'message' =>'Başarılı'));
        }
    }

    public function view($id)
    {
        // Tüm personelleri görme yetkisi var mı?
        if (!$this->aauth->premission(7)->read) {
            exit('<h3>Üzgünüm! Giriş Yetkiniz Bulunmamaktadır</h3>');
        }

        $user = $this->aauth->get_user()->id; // Giriş yapan kullanıcı ID'si
        $role_id = $this->aauth->get_user()->roleid; // Kullanıcı rolü
        $santiye_id = personel_salary_details_get($user)->proje_id; // Kullanıcının şantiyesi
        $status = true;

        // Kullanıcı tüm personelleri görme yetkisine sahip değilse
        if (!$this->aauth->premission(95)->read) {
            if (in_array($role_id, [10, 40, 48,6,19,30])) {
                // Proje Müdürü veya Şantiye Muhasebecisi ise, şantiye kontrolü yap
                $santiye_id_personel = personel_salary_details_get($id)->proje_id; // Görüntülenmek istenen personelin şantiyesi
                if ($santiye_id != $santiye_id_personel) {
                    $status = false; // Eğer personel başka bir şantiyede ise yetkisiz
                }
            } else {
                // Diğer rollerde kullanıcı yetkisiz
                $status = false;
            }
        }

        if ($status) {
            // Kullanıcı yetkili ise personel detaylarını getir
            $data['point_value'] = $this->model->point_value($id);
            $data['details'] = $this->model->details($id);
            $data['users_details'] = $this->model->users_details($id);
            $data['salary_details'] = $this->model->salary_details($id);

            // Başlık ve kullanıcı adı
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Personel Detayları';

            // Görünüm yükle
            $this->load->view('fixed/header', $head);
            $this->load->view('personel/view', $data);
            $this->load->view('fixed/footer');
        } else {
            // Yetkisiz kullanıcı için mesaj
            exit('<h3>Üzgünüm! Bu Personeli Görme Yetkiniz Yoktur</h3>');
        }
    }



    public function apiview($id)
    {

        $data['details'] = $this->model->details($id);
    }

    public function delete_document()
    {

        if (!$this->aauth->premission(7)->delete) {
            echo json_encode(array('status' => 410, 'message' =>'Silmek İçin Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $id = $this->input->post('deleteid'); //3
            $personel_id = $this->session->userdata('cid'); //257

            $result = $this->model->deletedocument($id,$personel_id);
            if($result['status']){
                echo json_encode(array('status' => 200, 'message' =>$result['message']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }


    }

    public function create_file(){
        if (!$this->aauth->premission(7)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->create_file();
            if($result['status']){
                echo json_encode(array('status' => 200, 'message' =>$result['message']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }
    }
    public function adddocument(){

        //$img = (string)$this->uploadhandler->filenaam();

        $this->load->library("Uploadhandler_generic", array(

            'accept_file_types' => '/\.(pdf|gif|jpe?g|png|xlsx)$/i', 'upload_dir' => FCPATH . 'userfiles/documents/', 'upload_url' => base_url() . 'userfiles/documents/'

        ));


    }

    public function personel_ajax_alacak_borc(){

        if (!$this->aauth->premission(60)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->personel_ajax_alacak_borc();
            if($result['status']){
                echo json_encode(array('status' => 200, 'message' =>$result['message']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }

    }

    public function personel_prim_talep(){

        if (!$this->aauth->premission(61)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->personel_prim_talep();
            if($result['status']){
                echo json_encode(array('status' => 200, 'message' =>$result['message']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }

    }

    public function personel_is_cikis_update(){

        if (!$this->aauth->premission(62)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->personel_is_cikis_update();
            if($result['status']){
                echo json_encode(array('status' => 200, 'message' =>$result['message']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }

    }

    public function add_cart(){

        if (!$this->aauth->premission(7)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->add_cart();
            if($result['status']){
                echo json_encode(array('status' => 200, 'message' =>$result['message']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }

    }
	
    public function new_password()
    {

        if($this->aauth->get_user()->id==21){
            $id = $this->input->post('id');
            $password = $this->input->post('password');
            $result = $this->model->new_password($id, $password);
            if ($result['status']) {
                $this->session->set_flashdata('message', 'Başarılı');
                redirect(base_url().'personel/index');
            } else {
                $this->session->set_flashdata('message', 'Hata Aldınız.Lütfen Yöneticiye Başvurun.');
                redirect(base_url().'personel/view');

            }
        }
        else {
            $this->session->set_flashdata('message', 'Yetkiniz Yoktur');
            redirect(base_url().'personel/view');
        }


    }

    public function bio_create(){
        $request_url = "10.10.0.236:8090/personnel/api/employees/";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$request_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "emp_code=102&department=3&area=[2,15]&photo='https://muhasebe.makro2000.com.tr/userfiles/company/904811makro-2000-600x315w.png'");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close($ch);
        print_r($ch);


    }

    public function listpersonelfirma(){
        $firma_id=$this->input->post('firma_id');
        if($firma_id){
            $result = $this->db->query("SELECT * FROM geopos_employees Where loc=$firma_id");
            if($result->num_rows()){
                echo json_encode(array('status' => 200, 'list' =>$result->result()));
            }
            else {
                echo json_encode(array('status' => 410,'messages'=>'Firmaya ait personel bulunamadı'));
            }
        }
        else {
            echo json_encode(array('status' => 410,'messages'=>'Geçersiz Firma'));
        }
    }

    public function cart_list(){
        $pers_id=$this->input->post('pers_id');
        if($pers_id){
            $result = $this->db->query("SELECT * FROM personel_cart Where pers_id=$pers_id");
            if($result->num_rows()){
                echo json_encode(array('status' => 200, 'list' =>$result->result()));
            }
            else {
                echo json_encode(array('status' => 410,'messages'=>'Personele ait kart bulunamadı'));
            }
        }
        else {
            echo json_encode(array('status' => 410,'messages'=>'Geçersiz Personel'));
        }
    }

    public function mezuniyet_update(){

        if (!$this->aauth->premission(89)->read) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $personel_id=$this->input->post('pers_id');
            $deger=$this->input->post('deger');
            $date = new DateTime('now');
            $yil =  $date->format('Y');
            $result = izin_gun_kontrol($personel_id);
            $old_deger=0;
            $knt= $this->db->query("SELECT * FROM personel_mezuniyet Where personel_id = $personel_id and yil=$yil");
            if($knt->num_rows()){

                $old_deger = $knt->row()->mezuniyet;
                //update


                $data1 = array(
                    'mezuniyet' => $deger,
                );
                $this->db->set($data1);
                $this->db->where('id', $knt->row()->id);
                $this->db->update('personel_mezuniyet');
                $this->aauth->applog("Personel Mezuniyeti Değiştirildi : Eski Mezuniyet ".$old_deger.' Yeni Mezuniyet '.$deger, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 200, 'message' =>'Başarılı Bir Şekilde Güncellendi'));
            }
            else {
                $data_paralel = [
                    'mezuniyet' => $deger,
                    'personel_id'=>$personel_id,
                    'yil'=>$yil,
                ];
                if($this->db->insert('personel_mezuniyet', $data_paralel)){
                    echo json_encode(array('status' => 200, 'message' =>'Başarılı Bir Şekilde Eklendi'));
                }
            }
        }

    }

    public function dev_kontrol()
    {

         $deger=$this->input->post('pers_id');
         $kontrol = $this->db->query("SELECT * FROM onay_devri Where user_id = $deger and status=1");
         if($kontrol->num_rows()){
             echo json_encode(array('status' => 200, 'devr_user_id' =>$kontrol->row()->devr_user_id,'status_user'=>$kontrol->row()->status));
         }
         else {
             echo json_encode(array('status' => 200, 'devr_user_id' =>0));
         }
    }

    public function update_atama_pers()
    {
        $this->db->trans_start();
        $user_id=$this->input->post('pers_id');
        $devr_pers_id=$this->input->post('devr_pers_id');
        $status=$this->input->post('status');
        $kontrol = $this->db->query("SELECT * FROM onay_devri Where user_id=$user_id and  devr_user_id = $devr_pers_id and status=1");
        if(!$kontrol->num_rows()){
            $data_paralel = [
                'user_id' => $user_id,
                'auth_id' => $user_id,
                'devr_user_id'=>$devr_pers_id,
                'status'=>$status,
            ];
            if($this->db->insert('onay_devri', $data_paralel)){
                $this->db->trans_complete();
                echo json_encode(array('status' => 200, 'message' =>'Başarılı Bir Şekilde Eklendi'));
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>'Hata Aldınız'));
            }
        }
        else {

            $data1 = array(
                'status' => 0,
            );
            $this->db->set($data1);
            $this->db->where('user_id', $user_id);
            $this->db->update('onay_devri');
            $data_paralel = [
                'user_id' => $user_id,
                'auth_id' => $user_id,
                'devr_user_id'=>$devr_pers_id,
                'status'=>$status,
            ];
            if($this->db->insert('onay_devri', $data_paralel)){

                if($status==1){
                    $izinle_pers_name = personel_detailsa($user_id)['name'];
                    $mesaj='Tüm Taleplerin Onayları '.$izinle_pers_name.' Tarafından Size Atanmıştır.Lütfen İnsan Resusları Tarafından Kağız Alınız';
                    $this->send_mail($devr_pers_id,'Onay Ataması',$mesaj);
                }
                $this->db->trans_complete();
                echo json_encode(array('status' => 200, 'message' =>'Başarılı Bir Şekilde Eklendi'));
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>'Hata Aldınız'));
            }
        }


    }

    public function send_mail($user_id,$subject,$message){
        $this->load->model('communication_model');
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



}