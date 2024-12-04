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
 */




defined('BASEPATH') OR exit('No direct script access allowed');



class Messages extends CI_Controller

{





    public function __construct()

    {

        parent::__construct();

        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

            exit;

        }



        if ($this->aauth->get_user()->roleid < 2) {



            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');



        }



        $this->load->model('dashboard_model');

        $this->load->model('tools_model');





    }





    public function index()

    {



        $this->load->view('fixed/header');

        $this->load->view('messages/index');

        $this->load->view('fixed/footer');

    }


    public function mesaj_kontrol()
    {
        $id = $this->aauth->get_user()->id;

        $query=$this->db->query("SELECT * FROM geopos_pms WHERE receiver_id=$id and date_read is NULL")->num_rows();

        if($query>0)
        {
            echo json_encode(array('status' => 'Success', 'message' =>$query.' Adet Okunmamış Mesajınız Var.  '.'<a href="/messages" class="">Tüm Mesajları Görüntüle</a> '));
        }
    }

    public function sendpm()

    {





        $subject = $this->input->post('subject',true);

        $message = $this->input->post('text',true);

        $receiver = $this->input->post('userid');




        $this->aauth->send_pm($this->aauth->get_user()->id, $receiver, $subject, $message);



        echo json_encode(array('status' => 'Success', 'message' =>

            "Message Sent!"));





    }



    public function view()

    {


        $data['sender_id'] = $this->input->get('id');
        $data['pid'] = $this->input->get('pid');
        //$this->aauth->set_as_read_pm_id($data['id']);


        $this->db->set(
            array
            (
                'date_read' => date('Y-m-d H:i:s')
            )
        );

        $this->db->where('receiver_id',  $this->aauth->get_user()->id);
        $this->db->where('sender_id', $this->input->get('id'));
        $this->db->update('geopos_pms');
        $this->load->model('message_model', 'message');

        $data['employee'] = $this->message->employee_details($data['sender_id']);



        $this->load->view('fixed/header');

        $this->load->view('messages/view', $data);

        $this->load->view('fixed/footer');





    }



    public function deletepm()

    {





        $pmid = $this->input->post('pmid');





        if ($this->aauth->delete_pm($pmid)) {

            echo json_encode(array('status' => 'Success', 'message' =>

                "Message Deleted!"));

        } else {





            echo json_encode(array('status' => 'Error', 'message' =>

                "Error !"));

        }





    }





}