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

class Personelp Extends CI_Controller
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
        $this->load->model('Personelp_model', 'model');
    }

    public function index()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Podradçı Personel Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('personelp/index');
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
            $view = "<a class='btn btn-outline-success'  href='/personelp/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";
            $disable= "<button pers_id='$prd->id' class='btn btn-outline-success disabled_button' ><i class='fa fa-chain-broken'></i>Pasifleştir</button>&nbsp;";

            $podradci= "<button personel_id='$prd->id' class='btn btn-outline-success podradci_button' ><i class='fa fa-building'></i> Bağlı Olduğu Podradçı</button>&nbsp;";
            $ana_podradci=' Herhangi Bir Podradçiya Bağlanmamış';
            $podradci_list = $this->db->query("SELECT * FROM podradci Where id=$prd->podradci_id");
            if($podradci_list->num_rows()){
                if($podradci_list->row()->ana_cari){
                    $ana_podradci=customer_details($podradci_list->row()->ana_cari)['company'];
                }
            }
            else {
                if($prd->ana_cari){
                    $ana_podradci=customer_details($prd->ana_cari)['company'];
                }
            }
            $new_title = parent_podradci_kontrol_list($prd->podradci_id);

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
            $row[] = $ana_podradci;
            $row[] = $new_title;
            $row[] = $edit.$view.$podradci;
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


    public function update(){
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

        $data['point_value']=$this->model->point_value($id);
        $data['details'] = $this->model->details($id);
        $data['users_details'] = $this->model->users_details($id);
        $data['salary_details'] = $this->model->salary_details($id);


        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('personelp/view',$data);
        $this->load->view('fixed/footer');
    }

    public function delete_document()
    {
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

    public function create_file(){
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
        $id = $this->input->post('id');
        $password = $this->input->post('password');


        $result = $this->model->new_password($id, $password);

        if ($result['status']) {
            $this->session->set_flashdata('message', 'Başarılı');
            redirect(base_url().'personelp/index');
        } else {
            $this->session->set_flashdata('message', 'Hata Aldınız.Lütfen Yöneticiye Başvurun.');
            redirect(base_url().'personelp/view');

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

    public function displaypic()
    {

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $id = $this->input->get('id');
            $res = $this->load->library("uploadhandler", array(
                'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/employee/'
            ));

            $img = $this->uploadhandler->filenaam();




    }
    public function update_image()
    {
        $id=$this->input->post('id');
        $img=$this->input->post('image');

        if($this->model->editpicture($id, $img)){
            echo json_encode(array('status' => 200, 'messages' =>'Başarıyla Güncellendi'));
        }
        else {
            echo json_encode(array('status' => 410,'messages'=>'Hata Aldınız'));
        }
    }
    public function document_load_list()
    {   $cid = $this->input->post('cid');
        $list = $this->model->document_datatables($cid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $document) {

            $arac_name = (arac_view($document->arac_id))?arac_view($document->arac_id)->name:'';
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $document->title;
            $row[] = personel_file_type_id($document->file_type);
            $row[] = $arac_name;
            $row[] = dateformat($document->baslangic_date);
            $row[] = dateformat($document->bitis_date);

            $row[] = '<a href="' . base_url('userfiles/documents/' . $document->filename) . '" class="btn btn-outline-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> <a class="btn btn-outline-danger btn-xs delete-object" href="#" data-object-id="' . $document->id . '"> <i class="icon-trash "></i> </a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->document_count_all($cid),
            "recordsFiltered" => $this->model->document_count_filtered($cid),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function update_personel(){

        $this->db->trans_start();
        $result = $this->model->update_personel();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function info_personel()
    {
        $personel_id=$this->input->post('personel_id');
        $parent = $this->model->info_personel($personel_id);

        $parent_durum=true;
        if(!$parent->podradci_id){
            $parent_durum=false;
        }
        echo json_encode(array('status' => 200,'info_durum'=>$parent_durum,'info'=>$parent,'ana_cari'=>$parent->ana_cari));
    }




}