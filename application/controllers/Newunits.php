<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Newunits extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('NewUnitsModel', 'units');
        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');
        }

        if (!$this->aauth->premission(2)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
    }


    public function index()
    {


        if (!$this->aauth->premission(24)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        } else {
            $this->load->helper('cookie');

            $head['title'] = "Measurement Units";

            $this->load->view('fixed/header', $head);

            $this->load->view('product_units/index');

            $this->load->view('fixed/footer');
        }
    }


    public function ajax_list()
    {

        $list = $this->units->get_datatables_query_details_list();

        $data = [];
        $no = $this->input->post('start');


        foreach ($list as $item) {

            $edit = "<button class='btn btn-warning btn-sm edit' unit_id='$item->id' title='Düzenle'><i class='fas fa-pencil-alt'></i></button>&nbsp;";
            $delete = "<button class='btn btn-danger btn-sm delete' unit_id='$item->id' title='Sil'><i class='far fa-trash-alt'></i></button>&nbsp;";

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $item->id;
            $row[] = $item->name;
            $row[] = $item->code;
            $row[] = $edit . $delete;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->units->count_all(),
            "recordsFiltered" => $this->units->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }


    public function create()
    {

        if (!$this->aauth->premission(24)->write) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {
            $this->db->trans_start();
            $result = $this->units->create_save();
            if ($result['status']) {
                echo json_encode(array('status' => 200, 'message' => "Başarılı"));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' => "Hata Aldınız.Lütfen Yöneticiye Başvurun."));
            }
        }
    }


    public function info()
    {
        if (!$this->aauth->premission(24)->read) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {

            $unit_id = $this->input->post('unit_id');
            $details_items = $this->units->details_item($unit_id);
            echo json_encode(array('status' => 'Success', 'details_items' => $details_items));
        }
    }


    public function update()
    {

        if (!$this->aauth->premission(24)->update) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {
            $this->db->trans_start();
            $result = $this->units->update();
            if ($result['status']) {
                echo json_encode(array('status' => 200, 'message' => 'Başarılı'));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' => 'Hata Aldınız.Lütfen Yöneticiye Başvurun.'));
            }
        }
    }


    public function delete()
    {
        if (!$this->aauth->premission(24)->delete) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {
            $this->db->trans_start();
            $result = $this->units->delete();
            if ($result['status']) {
                echo json_encode(array('code' => 200, 'message' => $result['messages']));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('code' => 410, 'message' => $result['messages']));
            }
        }

    }
}