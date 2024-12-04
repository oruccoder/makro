<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Meeting extends CI_Controller

{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('MeetingModel', 'meeting');
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
        if (!$this->aauth->premission(35)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $this->load->helper('cookie');

        $head['title'] = "Meeting";

        $this->load->view('fixed/header', $head);

        $this->load->view('meeting/index');

        $this->load->view('fixed/footer');
    }


    public function ajax_list()
    {

        $list = $this->meeting->get_datatables_query_details_list();

        $data = [];
        $no = $this->input->post('start');


        foreach ($list as $item) {

            if($item->confirm_user == $this->aauth->get_user()->employes->id and $item->status == "Bekliyor")
            {
                $check = "<button class='btn btn-success btn-sm confirm' meeting_id='$item->id' title='Onayla'><i class='fas fa-check'></i></button>&nbsp;";
            }else{
                $check = '';
            }


            if($item->confirm_user == $this->aauth->get_user()->employes->id and $item->status == "Bekliyor")
            {
                $cancel = "<button class='btn btn-danger btn-sm cancel' meeting_id='$item->id' title='Iptal Et'><i class='fa fa-ban'></i></button>&nbsp;";
            }else{
                $cancel = '';
            }

            if($item->status == "Onaylandı")
            {
                $open = "<button class='btn btn-primary btn-sm open' meeting_id='$item->id' title='Toplantıya Katılan Kişilere Bak'><i class='fas fa-eye'></i></button>&nbsp;";
            }else{
                $open = '';
            }



            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $item->uniqid;
            $row[] = $item->by_user;
            $row[] = $item->who_created;
            $row[] = $item->confirm_user_name;
            $row[] = $item->time;
            $row[] = $item->type;
            $row[] = $item->location;
            $row[] = $item->status;
            $row[] = $item->created_at;
            $row[] = $item->confirm_date;
            // $row[] = $item->cancel_date;
            $row[] = $cancel . $check . $open;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "data" => $data,
            "recordsTotal" => $this->meeting->count_all(),
            "recordsFiltered" => $this->meeting->count_filtered(),
        );

        //output to json format
        echo json_encode($output);
    }


    public function create()
    {
        if (!$this->aauth->premission(35)->write) {


            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->meeting->create_save();
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


        $meeting_id = $this->input->post('meeting_id');
        $details_items = $this->meeting->details_item($meeting_id);
        echo json_encode(array('status' => 'Success', 'details_items' => $details_items));
    }


    public function update()
    {
        if (!$this->aauth->premission(35)->update) {


            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->meeting->update();
            if ($result['status']) {
                echo json_encode(array('status' => 200, 'message' => 'Başarılı'));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' => 'Hata Aldınız.Lütfen Yöneticiye Başvurun.'));
            }
        }

    }


    public function cancel()
    {
        if (!$this->aauth->premission(35)->delete) {


            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->meeting->cancel();
            if ($result['status']) {
                echo json_encode(array('code' => 200, 'message' => $result['messages']));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('code' => 410, 'message' => $result['messages']));
            }
        }

    }

    public function members()
    {
        $meeting_id = $this->input->post('meeting_id');

        $details_member = $this->meeting->details_member($meeting_id);

        echo json_encode(array('details_member' => $details_member));

    }
}
