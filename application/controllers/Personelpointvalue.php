<?php

/**
 * İtalic Soft Yazılım  ERP - CRM - HRM
 * Copyright (c) İtalic Soft Yazılım. Tüm Hakları Saklıdır.
 * ***********************************************************************
 *
 *  Email: info@italicsoft.com
 *  Website: https://www.italicsoft.com
 *  Tel: 0850 317 41 44
 *  ************************************************************************


defined('BASEPATH') OR exit('No direct script access allowed');

class Personelpointvalue Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('Personelpointvalue_model', 'model');
        $this->load->model('communication_model');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        if (!$this->aauth->premission(74)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel değeri';
        $this->load->view('fixed/header', $head);
        $this->load->view('personelpointvalue/index');
        $this->load->view('fixed/footer');
    }

    public function ajax_list(){

        $list = $this->model->list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {



            //$bakiye=personel_bakiye_report($prd->id);
            $btn='';
            $edit = "<button class='btn btn-warning edit' pers_id='$prd->id'><i class='fa fa-pen'></i></button>&nbsp;";
            $view = "<a class='btn btn-success'  href='/personel/view/$prd->id' type='button'><i class='fa fa-eye'></i></a>&nbsp;";
            $disable= "<button pers_id='$prd->id' class='btn btn-success disabled_button' ><i class='fa fa-chain-broken'></i>Pasifleştir</button>&nbsp;";
            //$maas_proje= "<button  data-object-id='" . $prd->id . "' class='btn btn-info  maas_pers' title='Maas Düzenleme'><i class='fa fa-money'></i> Maaş / Proje</button>";

            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='form-control one_select' pers_id='$prd->id'>";
            $row[] = $no;
            $row[] = $prd->name;
            $row[] = $prd->who_entered;
            //$row[] = $prd->role_name;
            //$row[] = $prd->proje_code;
            //$row[] = "<input type='password' class='bakiye' style='cursor: default;border: none;' value='$bakiye'><i class='fa fa-eye-slash bakiye_show'></i>";
            $row[] = $edit.$view.$disable;

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

}
 */

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

defined('BASEPATH') or exit('No direct script access allowed');

class Personelpointvalue extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('Personelpointvalue_model', 'model');
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Yetkinlikleri';
        $this->load->view('fixed/header', $head);
        $this->load->view('personelpointvalue/index');
        $this->load->view('fixed/footer');
    }

    public function list()
    {
        $list = $this->model->list();
        $data = [];
        $no = 0;

        foreach ($list as $customers) {

            $edit = "<button class='btn btn-warning edit' pers_id='$customers->id'><i class='fa fa-pen'></i></button>&nbsp;&nbsp;&nbsp;&nbsp;";
            $cancel = "<button class='btn btn-danger delete' pers_id='$customers->id' title='Sil'><i class='far fa-trash-alt'></i></button>&nbsp;";

            $no++;
            $row = [];

            $row[] = $no;
            $row[] = $customers->name;
            $row[] = $customers->personel_name;
            $row[] = $customers->created_at;
            $row[] = $edit.$cancel;

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
        if (!$this->aauth->premission(77)->write) {
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

    public function update()
    {
        if (!$this->aauth->premission(77)->update) {
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

    public function delete()
    {
        if (!$this->aauth->premission(77)->delete) {
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

    public function info()
    {
        $id=$this->input->post('id');

        $details = $this->model->details($id);


        echo json_encode(array('status' => 200,
            'items' =>$details,


        ));
    }
}
