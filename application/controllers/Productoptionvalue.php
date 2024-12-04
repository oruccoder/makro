<?php


class Productoptionvalue extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('ProductOptionValueModel', 'productOptionValue');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }




    public function index()
    {
        $this->load->helper('cookie');

        delete_cookie("pids");

        $head['title'] = "Urun Opsiyon Değer";

        $this->load->view('fixed/header', $head);

        $this->load->view('urun/product_option_value');

        $this->load->view('fixed/footer');
    }




    public function ajax_list()
    {

        $list = $this->productOptionValue->get_datatables_query_details_list();

        $data = [];
        $no = $this->input->post('start');

        // print_r($list);die;
        foreach ($list as $prd) {

            $edit = "<button class='btn btn-warning edit' product_option_value_id='$prd->id' title='Düzenle'><i class='fa fa-pencil'></i></button>&nbsp;";
            $cancel = "<button class='btn btn-danger delete' product_option_value_id='$prd->id' title='Sil'><i class='far fa-trash-alt'></i></button>&nbsp;";


            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $prd->name;
            $row[] = $prd->product_option_name;
            $row[] = $prd->description;
            $row[] = $edit . $cancel;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->productOptionValue->count_all(),
            "recordsFiltered" => $this->productOptionValue->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }




    public function create()
    {
        $this->db->trans_start();
        $result = $this->productOptionValue->create_save();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => "Başarılı"));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => "Hata Aldınız.Lütfen Yöneticiye Başvurun."));
        }
    }



    public function info()
    {
        $id = $this->input->post('id');

        $details_items = $this->productOptionValue->details_item($id);

        echo json_encode(array('status' => 'Success', 'details_items' => $details_items));
    }


    public function update()
    {
        $this->db->trans_start();
        $result = $this->productOptionValue->update();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => 'Başarılı'));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => 'Hata Aldınız.Lütfen Yöneticiye Başvurun.'));
        }
    }


    public function delete()
    {
        $result = $this->productOptionValue->delete();
        if ($result['status']) {
            echo json_encode(array('code' => 200, 'message' => 'Başarılı'));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('code' => 410, 'message' => 'Hata Aldınız.Lütfen Yöneticiye Başvurun.'));
        }
    }
}
