<?php


class Mahsul extends CI_Controller
{



    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('MahsulModel', 'product');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }




    public function index()
    {
        $this->load->helper('cookie');

        delete_cookie("pids");

        $head['title'] = "Mahsul";

        $this->load->view('fixed/header', $head);

        $this->load->view('mahsul/index');

        $this->load->view('fixed/footer');
    }




    public function ajax_list()
    {

        $list = $this->product->get_datatables_query_details_list();
        $data = [];
        $no = $this->input->post('start');

        foreach ($list as $prd) {

            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $prd->name;
            $row[] = $prd->cat_title;
            $row[] = $prd->code;
            $row[] = $prd->barcode;
            $row[] = $prd->type;
            $row[] = $prd->unit_id;
            $row[] = $prd->parent_id;
            $row[] = $prd->image;
            $row[] = 'wefwefwe' . 'wfeewfwefwe';
            $data[] = $row;
        }


        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->product->count_all(),
            "recordsFiltered" => $this->product->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }




    public function create()
    {
        $this->db->trans_start();
        $result = $this->product->create_save();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => "Başarılı"));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => "Hata Aldınız.Lütfen Yöneticiye Başvurun."));
        }
    }
}
