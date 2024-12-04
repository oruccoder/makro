<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Personelpoint extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('file');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('Personelpoint_model', 'model');
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Puanlama';
        $this->load->view('fixed/header', $head);
        $this->load->view('personelpoint/index');
        $this->load->view('fixed/footer');
    }

    public function list()
    {
        $list = $this->model->list();
        $data = [];
        $no = 0;

        foreach ($list as $customers) {

            //$edit = "<button class='btn btn-warning edit' pers_id='$customers->id'><i class='fa fa-pen'></i></button>&nbsp;&nbsp;&nbsp;&nbsp;";
            $cancel="<button class='btn btn-danger delete' pers_id='$customers->id' title='Sil'><i class='far fa-trash-alt'></i></button>&nbsp;&nbsp;";
            $view = "<button class='btn btn-success view' employee_id='$customers->id' type='button'><i class='fa fa-eye'></i></button>&nbsp;&nbsp;";

            $no++;
            $row = [];

            $row[] = $no;
            $row[] = $customers->personel_name;
            $row[] = $customers->role_name;
            $row[] = $customers->created_at;
            $row[] = $cancel.$view;

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->model->count_all(),
            "recordsFiltered" => $this->model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function create()
    {


        if (!$this->aauth->premission(76)->write) {
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

    public function info_list(){

        $list = $this->model->details();
        $data = array();

        $no=0;
        foreach ($list as $items){

            $cancel="<button class='btn btn-danger delete_line' pers_id='$items->personel_id' deger_id='$items->id' title='Sil'><i class='far fa-trash-alt'></i></button>&nbsp;&nbsp;";
            $no++;
            $row = array();


            $row[] = $items->name;
            $row[] = $items->puan;
            $row[] = $items->personel_name;
            $row[] = $items->created_at;
            $row[] = $cancel;

            $data[] = $row;
        }

        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->model->count_all(),
            "recordsFiltered" => $this->model->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function delete()
    {

        if (!$this->aauth->premission(76)->delete) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->delete();
            if ($result['status']) {
                echo json_encode(array('code' => 200, 'message' => $result['messages']));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('code' => 410, 'message' => $result['messages']));
            }
        }
    }
    public function delete_line()
    {

        if (!$this->aauth->premission(76)->delete) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->delete_line();
            if ($result['status']) {
                echo json_encode(array('code' => 200, 'message' => $result['messages']));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('code' => 410, 'message' => $result['messages']));
            }
        }
    }
    /*public function info(){
            $id=$this->input->post('id');
            $details = $this->model->details($id);

            $details_items=[];

            foreach ($details as $items){

                $details_items[]=[


                    'id'=>$items->id,
                    'loc'=>$items->loc,
                    'name'=>$items->name,
                    'auth_id'=>$items->auth_id,
                    'personel_id'=>$items->personel_id,
                    'point_value_id'=>$items->point_value_id,
                    'puan'=>$items->puan,
                    'aauth_id'=>$this->aauth->get_user()->id,
                    'created_at'=>$items->created_at,
                    'personel_name'=>$items->personel_name,



                ];
            }

            echo json_encode(array('status' => 200, 'items' =>$details,'items_onay'=>$details_items));
        }*/

    /*public function _info(){
        $id=$this->input->post('id');
        $details = $this->model->details($id);



        $details_items=[];

        foreach ($details as $items){

            $details_items[]=[


                'id'=>$items->id,
                'loc'=>$items->loc,
                'name'=>$items->name,
                'auth_id'=>$items->auth_id,
                'personel_id'=>$items->personel_id,
                'point_value_id'=>$items->point_value_id,
                'puan'=>$items->puan,
                'aauth_id'=>$this->aauth->get_user()->id,
                'created_at'=>$items->created_at,
                'personel_name'=>$items->personel_name,



            ];
        }

        echo json_encode(array('status' => 200, 'items' =>$details,'items_onay'=>$details_items));
    }*/
}