<?php

defined('BASEPATH') or exit('No direct script access allowed');


class Items extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('Items_model', 'model');
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


        if (!$this->aauth->premission(88)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        } else {
            $this->load->helper('cookie');

            $head['title'] = "Diğer Tanımlamalar";

            $this->load->view('fixed/header', $head);

            $this->load->view('items/index');

            $this->load->view('fixed/footer');
        }
    }


    public function ajax_list()
    {

        $list = $this->model->get_datatables_query_details_list();

        $data = [];
        $no = $this->input->post('start');


        foreach ($list as $item) {

            $edit = "<button class='btn btn-outline-warning btn-sm edit' unit_id='$item->id' title='Düzenle'><i class='fas fa-pencil-alt'></i></button>&nbsp;";
            $delete = "<button class='btn btn-outline-danger btn-sm delete' unit_id='$item->id' title='Sil'><i class='far fa-trash-alt'></i></button>&nbsp;";
            $view = "<a class='btn btn-outline-info btn-sm ' href='/demirbas/item_views/$item->id/items' ><i class='far fa-eye'></i></a>&nbsp;";

            $no++;
            $row = [];
            $row[] = "<label class='checkbox'><input  type='checkbox' name='materialCheck' value='$item->id' class='one_select'><i style='top: 12px;'></i></label>";
            $row[] = $no;
            $row[] = $item->name;
            $row[] = $item->code;
            $row[] = $item->departman_name;
            $row[] = $item->personel_name;
            $row[] = $edit . $delete.$view;
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


    public function create()
    {

        if (!$this->aauth->premission(88)->write) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {
            $this->db->trans_start();
            $result = $this->model->create_save();
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
        if (!$this->aauth->premission(88)->read) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {

            $unit_id = $this->input->post('unit_id');
            $details_items = $this->model->details_item($unit_id);
            echo json_encode(array('status' => 'Success', 'details_items' => $details_items));
        }
    }


    public function update()
    {

        if (!$this->aauth->premission(88)->update) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {
            $this->db->trans_start();
            $result = $this->model->update();
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
        if (!$this->aauth->premission(88)->delete) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {
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
    public function barcode_creates(){
       $items_id =  $this->input->post('items_id');
       $str = implode(",",$items_id);
       if($str)
       {
           $this->session->set_userdata('items_id',$str);
           echo json_encode(array('code' => 200, 'message'=>'Başarıyla Barkod Oluşturuldu Sayfaya Girmek İçin Tamam Butonuna Tıklayın','url' => '/items/barcode_print'));

       }
       else {
           echo json_encode(array('code' => 410, 'message' => 'hata Aldınız'));
       }
    }

    public function barcode_print(){
        $str  = $this->session->userdata('items_id');
        $data['details'] =$this->db->query("Select * From items Where id IN($str)")->result();
        $html = $this->load->view('barcode/barcode_demirbas', $data, true);
        ini_set('memory_limit', '64M');//PDF Rendering
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->AddPage(
            'P', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            10, // margin top
            10, // margin bottom
            5, 2, 0, 0, // margin header
            'auto'); // margin footer
        $pdf->WriteHTML($html);

        $pdf->Output($data['name'] . '_barcode.pdf', 'I');
    }
}