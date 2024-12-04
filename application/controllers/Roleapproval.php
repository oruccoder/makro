<?php


//t
defined('BASEPATH') OR exit('No direct script access allowed');



class Roleapproval Extends CI_Controller

{
    public function __construct()

    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('Roleapproval_model', 'Rolemodel');
        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');
        }

      
    }

    public function index(){
        if (!$this->aauth->premission(38)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Rol Təsdiqi Səhifəsi !';
        $this->load->view('fixed/header', $head);
        $this->load->view('roleapproval/index');
        $this->load->view('fixed/footer');
    }

    public function ajax_role_approval_list()
    {
        $list = $this->Rolemodel->approval_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $item) {

            $edit = "<button data-id='$item->id' class='btn btn-danger cancel-stockio'><i class='fa fa-ban'></i></button>&nbsp<button data-id='$item->id' class='btn btn-warning edit-stockio'><i class='fa fa-edit'></i></button>&nbsp  ";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $item->code;
            $row[] = $item->name;
            $row[] =$edit;
            $data[] = $row;

        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Rolemodel->count_all_fis_list(),
            "recordsFiltered" => $this->Rolemodel->count_filtered_fis_list(),
            "data" => $data,

        );

        echo json_encode($output);
    }

    public function create(){
        $this->db->trans_start();
        $result = $this->Rolemodel->create_approval();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function update(){
        $this->db->trans_start();
        $result = $this->Rolemodel->update_approval();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function delete(){


        $this->db->trans_start();
        $result = $this->Rolemodel->delete();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function info(){
        $id = $this->input->post('roleapp_id');
        $details = $this->Rolemodel->details($id);
        $role_details = $this->Rolemodel->role_details($details->approval_id);
        $item_details = $this->Rolemodel->item_details($id);
        echo json_encode(array('status' => 200,'item' =>$details,'item_details'=>$item_details,'role_details'=>$role_details));
    }
}