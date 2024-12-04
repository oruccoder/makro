<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Podradci extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('Podradci_model', 'model');
        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');
        }

    }


    public function index()
    {

        $this->load->helper('cookie');

        $head['title'] = "Podradçi Listesi";

        $this->load->view('fixed/header', $head);

        $this->load->view('podradci/index');

        $this->load->view('fixed/footer');

    }

    public function view($id)
    {

        $this->load->helper('cookie');

        $data['details']=$this->model->details($id);
        $head['title'] = $data['details']->company;

        $podradci_name=' Herhangi Bir Podradçiya Bağlanmamış';
        $ana_podradci=' Herhangi Bir Cariye Bağlanmamış';

        $podradci_list = $this->db->query("SELECT * FROM podradci Where id=$id");
        if($podradci_list->num_rows()){
            if($podradci_list->row()->ana_cari){
                $ana_podradci=customer_details($podradci_list->row()->ana_cari)['company'];
            }
            $podradci_name=$podradci_list->row()->company;;
        }
        else {
            if($data['details']->ana_cari){
                $ana_podradci=customer_details($data['details']->ana_cari)['company'];
            }
        }

        $podradci_ana_cari='';
        $ust_parent = parent_podradci_kontrol_list_cari($id);
        if($ust_parent){
            $podradci_ana_cari= $this->db->query("SELECT * FROM podradci Where id=$ust_parent")->row()->ana_cari;
            $ana_podradci=customer_details($podradci_ana_cari)['company'];
        }


        $new_title = parent_podradci_kontrol_list($id).' KENDİSİ';
        $data['ana_cari']=$ana_podradci;
        $data['alt_podradci']=$new_title;

        $this->load->view('fixed/header', $head);

        $this->load->view('podradci/view',$data);

        $this->load->view('fixed/footer');

    }

    public function ajax_list(){
        $list = $this->model->ajax_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $id = $prd->id;
            $button="<button class='btn btn-outline-warning btn-sm edit' asama_id='$prd->id'><i class='fa fa-pen'></i></button> ";
            $button.="<button class='btn btn-outline-danger btn-sm delete' asama_id='$prd->id'><i class='fa fa-trash'></i></button>";
            $button.=" <a class='btn btn-outline-info btn-sm view' href='/podradci/view/$prd->id' ><i class='fa fa-eye'></i></a>";

            $podradci_name=' Herhangi Bir Podradçiya Bağlanmamış';
            $ana_podradci='Herhangi Bir Cariye Bağlanmamış';

            $podradci_list = $this->db->query("SELECT * FROM podradci Where id=$id");
            if($podradci_list->num_rows()){
                if($podradci_list->row()->ana_cari){
                    $ana_podradci=customer_details($podradci_list->row()->ana_cari)['company'];
                }
                else {
                    $ana_podradci=customer_details(parent_podradci_kontrol_list_cari($id))['company'];
                }
                $podradci_name=$podradci_list->row()->company;;
            }
            else {
                if($data['details']->ana_cari){
                    $ana_podradci=customer_details($data['details']->ana_cari)['company'];
                }
            }


            $podradci_ana_cari='';
            $ust_parent = parent_podradci_kontrol_list_cari($id);
            if($ust_parent){
                $podradci_ana_cari= $this->db->query("SELECT * FROM podradci Where id=$ust_parent")->row()->ana_cari;
                $ana_podradci=customer_details($podradci_ana_cari)['company'];
            }
            $new_title = parent_podradci_kontrol_list($id).' KENDİSİ';
            $no++;
            $row = array();
            $row[] = $no ;;
            $row[] = $prd->company;
            $row[] = $prd->yetkili_kisi;
            $row[] = $prd->telefon;
            $row[] = $prd->adres;
            $row[] = $ana_podradci;
            $row[] = $new_title;
            $row[] =$button;
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

    public function create(){

        if (!$this->aauth->premission(87)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->create();
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

        if (!$this->aauth->premission(87)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->update();
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

    public function delete(){

        if (!$this->aauth->premission(87)->delete) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

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

    public function info()
    {
        $id=$this->input->post('asama_id');
        $parent = $this->model->parent_info($id);
        $parent_durum=true;
        if(!$parent){
            $parent_durum=false;
        }
        echo json_encode(array('status' => 200, 'items' => $this->model->info(),'parent_durum'=>$parent_durum,'parent'=>$parent));
    }

    public function upload_profil_picture()
    {
        $config['upload_path'] = './userfiles/podradci/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 999999;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            echo json_encode(array(
                'status' => 410,
                'message'=>"Hata Aldınız",
                'code'=>$this->upload->display_errors()

            ));

        } else {
            $id=$this->input->post('id');
            $data['filename'] = $this->upload->data()['file_name'];
            $inputFileName = '/userfiles/podradci/' . $data['filename'];

            $data1 = array(
                'picture' => $data['filename'],
            );
            $this->db->set($data1);
            $this->db->where('id', $id);
            $this->db->update('podradci');

            echo json_encode(array(
                'status' => 200,
                'message'=>"Başarılı Bir Şekilde Yüklendi",
                'filename'=>$inputFileName

            ));
        }
    }

    public function document_load_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->model->document_datatables($cid);
        $data = array();
        $no = $this->input->post('start');


        foreach ($list as $document) {
            $proje_code='';
            if($document->proje_id){
                $proje_code = proje_code($document->proje_id);
            }
            $file_type='';

            if($document->file_type_id){
                $file_type = file_type_details($document->file_type_id)->name;
            }

            //$edit = "<button class='btn btn-outline-warning edit' talep_id='$document->id'><i class='fa fa-pen'></i></button>&nbsp;";
            $cancel = "<button class='btn btn-outline-danger talep_sil' talep_id='$document->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
            $view = "<a class='btn btn-outline-success view' href='".base_url('/userfiles/podradci/' . $document->filename)."' type='button'><i class='fa fa-eye'></i></a>&nbsp;";

            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $document->title;
            $row[] = dateformat_new($document->baslangic_date);
            $row[] = dateformat_new($document->bitis_date);
            $row[] = $proje_code;
            $row[] = $file_type;
            $row[] = $view.$cancel;


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

    public function add_document(){
        $this->db->trans_start();
        $bitis_date = $this->input->post('bitis_date');
        $baslangic_date = $this->input->post('baslangic_date');
        $file_type_id = $this->input->post('file_type_id');
        $name = $this->input->post('name');
        $cari_id = $this->input->post('cari_id');
        $image_text = $this->input->post('image_text');
        $proje_id = $this->input->post('proje_id');

        $data = array(
            'baslangic_date' => datefordatabase($baslangic_date),
            'bitis_date' => datefordatabase($bitis_date),
            'title' => $name,
            'filename' => $image_text,
            'cdate' => date('Y-m-d'),
            'cid'=>$this->aauth->get_user()->id,
            'fid'=>$cari_id,
            'rid'=>2,
            'file_type_id'=>$file_type_id,
            'proje_id'=>$proje_id
        );
        if($this->db->insert('geopos_documents', $data)){
            $this->aauth->applog("Podradciya Belge Eklendi : ".$cari_id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Dosya Eklendi'));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));

        }
    }

    public function file_handling(){

        $config['upload_path'] = './userfiles/podradci/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 999999;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            echo json_encode(array(
                'status' => 410,
                'message'=>"Hata Aldınız",
                'code'=>$this->upload->display_errors()

            ));

        } else {
            $id=$this->input->post('id');
            $data['filename'] = $this->upload->data()['file_name'];
            $inputFileName = $data['filename'];

            echo json_encode(array(
                'status' => 200,
                'message'=>"Başarılı Bir Şekilde Yüklendi",
                'filename'=>$inputFileName

            ));
        }
    }




}