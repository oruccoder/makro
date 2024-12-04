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

class Worker Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('worker_model', 'model');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }
    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Fehle Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('worker/index');
        $this->load->view('fixed/footer');
    }
    public function create_save()
    {
        $this->db->trans_start();
        $result = $this->model->create_save();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>$result['message'],'index'=>'/worker/view/'.$result['id']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message'].' Hata '));
        }
    }
    public function ajax_list()
    {
        $list = $this->model->list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $btn='';
            $edit = "<button class='btn btn-outline-warning edit' pers_id='$prd->id'><i class='fa fa-pen'></i></button>&nbsp;";
            $view = "<a class='btn btn-outline-success'  href='/worker/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";
            $disable= "<button pers_id='$prd->id' class='btn btn-outline-success disabled_button' ><i class='fa fa-chain-broken'></i>Pasifleştir</button>&nbsp;";
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='form-control one_select' pers_id='$prd->id'>";
            $row[] = $no;
            $row[] = '<img class="img-fluid rounded-circle" id="profile_images" src="/userfiles/employee/'.$prd->picture.'" width="60" height="60" alt="">';
            $row[] = $prd->name;
            $row[] = $prd->phone;
            $row[] = $prd->fin_no;
            $row[] = $prd->seri_no;
            $row[] = $prd->region;
            $row[] = $prd->job;
            $row[] = $prd->sorumlu_personel;
            $row[] = $edit.$view;
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

    public function view($id)
    {

        $data['details'] = $this->model->details($id);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Fehle Detayları';
        $this->load->view('fixed/header', $head);
        $this->load->view('worker/view',$data);
        $this->load->view('fixed/footer');
    }

    public function document_load_list()
    {
        $cid = $this->input->post('cid');
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

        $this->load->library("Uploadhandler_generic", array(

            'accept_file_types' => '/\.(pdf|gif|jpe?g|png|xlsx)$/i', 'upload_dir' => FCPATH . 'userfiles/documents/', 'upload_url' => base_url() . 'userfiles/documents/'

        ));
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

    public function update_time_out()
    {
        $this->db->trans_start();
        $result = $this->model->update_time_out();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function info()
    {
        $personel_id=$this->input->post('id');
        $parent = $this->model->details($personel_id);
        echo json_encode(array('status' => 200,'items'=>$parent));
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

    public function personel_get_all()
    {
        $personel_id=$this->input->post('id');
        $parent = $this->model->details_get_all($personel_id);
        echo json_encode(array('status' => 200,'items'=>$parent));
    }

    public function create_worker()
    {
        $this->db->trans_start();
        $result = $this->model->create_worker();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message'].' Hata '));
        }

    }
    public function run_list()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Fehle Detayları';
        $this->load->view('fixed/header', $head);
        $this->load->view('worker/run_list');
        $this->load->view('fixed/footer');
    }

    public function ajax_list_aauth()
    {
        $list = $this->model->list_aauth();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $btn='';
            $edit = "<button class='btn btn-outline-warning edit' pers_id='$prd->id'><i class='fa fa-pen'></i></button>&nbsp;";
            $view = "<a class='btn btn-outline-success'  href='/worker/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";
            $disable= "<button pers_id='$prd->id' class='btn btn-outline-success disabled_button' ><i class='fa fa-chain-broken'></i>Pasifleştir</button>&nbsp;";
            $no++;

            $calisma_tipi = "Saatlik";
            if($prd->tip==1) {   $calisma_tipi = "Günlük";}
            $calisma_miktari=amountFormat_s($prd->miktar).' '.units_($prd->birim)['name'];
            $birim_fiyati=amountFormat($prd->birim_fiyati);
            $total = floatval($prd->birim_fiyati) * floatval($prd->miktar);
            $cikis_saati = isset($prd->cikis_saati)?$prd->cikis_saati:'<button type="button" class="btn btn-outline-secondary check_out_clock" run_id="'.$prd->id.'"><i class="fa fa-clock"></i></button>';
            $html=' <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <td>Çalışma Tipi</td>
                                                                <td>Çalışma Miktarı</td>
                                                                <td>Birim Fiyatı</td>
                                                                <td>Toplam Fiyat</td>
                                                                <td>Çalıştığı Gün</td>
                                                                <td>Şantiye Giriş Saati</td>
                                                                <td>Şantiye Çıkış Saati</td>
                                                                <td>Durum</td>
                                                            </tr>
                                                            </thead> <tbody>
                                                            <tr>
                                                                 <th>'.$calisma_tipi.'</th>
                                                                <th>'.$calisma_miktari.'</th>
                                                                <th>'.$birim_fiyati.'</th>
                                                                <th>'.amountFormat($total).'</th>
                                                                <th>'.$prd->calisma_gunu.'</th>
                                                                <th>'.$prd->giris_saati.'</th>
                                                                <th>'.$cikis_saati.'</th>
                                                                <th>'.work_item_status($prd->id,$prd->status).'</th>
                                                                ';
            $html.=' </tr>
                                                            </tbody>
                                                        </table>';


            $check='Forma 2 Oluşturuldu';
            if(!$prd->forma2_id){
                $check= "<input type='checkbox' class='form-control one_select' pers_id='$prd->pers_id' run_id='$prd->id' proje_id='$prd->proje_id'>";
            }
            $row = array();
            $row[] =$check;
            $row[] = $prd->code;
            $row[] = $prd->name;
            $row[] = proje_code($prd->proje_id);
            $row[] = $html;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_aauth(),
            "recordsFiltered" => $this->model->count_filtered_aauth(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function proje_details()
    {
        $proje_id_arr=$this->input->post('proje_id');
        $proje_id = $proje_id_arr[0];
        $bolumler = proje_to_bolum($proje_id);
        echo json_encode(array('status' => 200, 'bolumler' =>$bolumler));

    }

    public function asama_list()
    {
        $proje_id_arr=$this->input->post('bolum_id');
        $query2 = $this->db->query("SELECT * FROM geopos_milestones WHERE bolum_id=$proje_id_arr");

        echo json_encode(array('status' => 200, 'asamalar' =>$query2->result()));

    }
    public function create_forma2()
    {
        $this->db->trans_start();
        $result = $this->model->create_forma2();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message'].' Hata '));
        }
    }

}
