<?php


class ProductToOption extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('ProductToOptionModel', 'productToOption');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }




    public function index()
    {
        $this->load->helper('cookie');

        delete_cookie("pids");

        $head['title'] = "Urun Opsiyon Birleştir";

        $this->load->view('fixed/header', $head);

        $this->load->view('urun/product_to_option');

        $this->load->view('fixed/footer');
    }




    public function ajax_list()
    {

        $list = $this->productToOption->get_datatables_query_details_list();

        $data = [];
        $no = $this->input->post('start');

        // print_r($list);die;
        foreach ($list as $prd) {

            $edit = "<button class='btn btn-warning edit' product_to_option_id='$prd->id' title='Düzenle'><i class='fas fa-pencil-alt'></i></button>&nbsp;";
            $cancel = "<button class='btn btn-danger delete' product_to_option_id='$prd->id' title='Sil'><i class='far fa-trash-alt'></i></button>&nbsp;";

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $prd->product_name;
            $row[] = $prd->product_option_value_name;
            $row[] = $prd->description;
            $row[] = $edit . $cancel;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->productToOption->count_all(),
            "recordsFiltered" => $this->productToOption->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }




    public function create()
    {
        $this->db->trans_start();
        $result = $this->productToOption->create_save();
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

        $details_items = $this->productToOption->details_item($id);

        echo json_encode(array('status' => 'Success', 'details_items' => $details_items));
    }


    public function update()
    {
        $this->db->trans_start();
        $result = $this->productToOption->update();
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
        $this->db->trans_start();
        $result = $this->productToOption->delete();
        if ($result['status']) {
            echo json_encode(array('code' => 200, 'message' => $result['messages']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('code' => 410, 'message' => $result['messages']));
        }
    }


    public function getValue()
    {
        $id = $this->input->post('id');

        $product_to_options = $this->productToOption->getValue($id);

        echo json_encode(['product_to_options' => $product_to_options]);
    }
}
