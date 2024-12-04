<?php


class Newproductcategory extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('UrunModel', 'product');
        $this->load->model('ProductCategoryModel', 'productCategory');
        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');
        }

        if (!$this->aauth->premission(23)->read) {

            exit('<h3>Yetkiniz BUlunmamaktadır</h3>');
        }
    }


    public function index()
    {
        if (!$this->aauth->premission(23)->read) {

            exit('<h3>Yetkiniz BUlunmamaktadır</h3>');
        }

        $this->load->helper('cookie');

        delete_cookie("pids");

        $head['title'] = "Urun Kateqorileri";

        $this->load->view('fixed/header', $head);

        $this->load->view('product_category/index');

        $this->load->view('fixed/footer');
    }


    public function ajax_list()
    {

        $list = $this->productCategory->get_datatables_query_details_list();

        $data = [];
        $no = $this->input->post('start');

        foreach ($list as $item) {
            $edit = "<button class='btn btn-warning btn-sm edit' product_cat_id='$item->id' title='Düzenle'><i class='fa fa-pen'></i></button>&nbsp;";
            $delete = "<button class='btn btn-danger btn-sm delete' product_cat_id='$item->id' title='Sil'><i class='far fa-trash-alt'></i></button>&nbsp;";


            $bagli_olfugu_categori=

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $item->code;
            $row[] = _ust_kategori_kontrol($item->id);
            $row[] = $item->title;
            $row[] = numaric_get($item->id);
            $row[] =  $edit . $delete;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "data" => $data,
            "recordsTotal" => $this->productCategory->count_all(),
            "recordsFiltered" => $this->productCategory->count_filtered(),
        );

        //output to json format
        echo json_encode($output);
    }


    public function create()
    {
        if (!$this->aauth->premission(23)->write) {
            echo json_encode(array('status' => 410, 'message' => "Yetkiniz Bulunmamaktadır."));
        }
        else {
            $this->db->trans_start();
            $result = $this->productCategory->create_save();
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

        $product_cat_id = $this->input->post('product_cat_id');
        $details_items = $this->productCategory->details_item($product_cat_id);
        echo json_encode(array('status' => 'Success', 'details_items' => $details_items));
    }


    public function update()
    {
        if (!$this->aauth->premission(23)->update) {
            echo json_encode(array('status' => 410, 'message' => "Yetkiniz Bulunmamaktadır."));
        }
        else {
            $this->db->trans_start();
            $result = $this->productCategory->update();
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
        if (!$this->aauth->premission(23)->delete) {
            echo json_encode(array('status' => 410, 'message' => "Yetkiniz Bulunmamaktadır."));
        }
        else {
            $this->db->trans_start();
            $result = $this->productCategory->delete();
            if ($result['status']) {
                echo json_encode(array('code' => 200, 'message' => $result['messages']));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('code' => 410, 'message' => $result['messages']));
            }
        }

    }

    public function product_to_option_create()
    {
        $this->db->trans_start();
        $result = $this->productCategory->product_to_option_create();
        if ($result['status']) {
            echo json_encode(array('code' => 200, 'message' => $result['messages']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('code' => 410, 'message' => $result['messages']));
        }
    }

    public function numaric_insert()
    {
        $this->db->trans_start();
        $result = $this->productCategory->numaric_insert();
        if ($result['status']) {
            echo json_encode(array('code' => 200, 'message' => $result['messages']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('code' => 410, 'message' => $result['messages']));
        }
    }
}
