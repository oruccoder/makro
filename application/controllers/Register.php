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



class Register Extends CI_Controller

{

    public function __construct()

    {



        parent::__construct();

        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }

        if ($this->aauth->get_user()->roleid < 2) {



            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');



        }



        $this->load->library("Registerlog");

        $this->load->model('register_model', 'register');





    }



    public function index()

    {





        if ($this->aauth->get_user()->roleid > 4) {

            $head['title'] = "Register";

            $data = $this->registerlog->lists();

            $head['usernm'] = $this->aauth->get_user()->username;

            $this->load->view('fixed/header', $head);

            $this->load->view('register/index', $data);

            $this->load->view('fixed/footer');

        }

    }





    public function view()

    {

        if ($this->aauth->get_user()->roleid > 4) {

            $status = $this->registerlog->view($this->input->post('rid'));





            echo json_encode(array('cash' => $status['cash'], 'card' => $status['card'], 'bank' => $status['bank'], 'change' => $status['r_change'], 'date' => $status['o_date']));





        }

    }





    public function status()

    {



        $status = $this->registerlog->check($this->aauth->get_user()->id);





        if ($status) {

            echo json_encode(array('cash' => $status['cash'], 'card' => $status['card'], 'bank' => $status['bank'], 'change' => $status['r_change'], 'date' => $status['o_date']));

        }



    }





    public function close()

    {



        $this->registerlog->close($this->aauth->get_user()->id);

        redirect('dashboard');





    }





    public function create()

    {





        if ($this->registerlog->check($this->aauth->get_user()->id)) {

            redirect('pos_invoices/create');

        }

        if ($this->input->post()) {

            $cash = (float)$this->input->post('cash');

            $card =  (float)$this->input->post('card');

            $bank =  (float)$this->input->post('bank');

            $cheque =  (float)$this->input->post('cheque');



            if ($this->registerlog->create($this->aauth->get_user()->id, $cash, $card, $bank, $cheque)) {



                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . " <a href='" . base_url() . "pos_invoices/create' class='btn btn-info btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span> " . $this->lang->line('POS') . "  </a>"));





            } else {

                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

            }

        } else {





            $head['title'] = "Add Register";

            $head['usernm'] = $this->aauth->get_user()->username;

            $this->load->view('fixed/header', $head);

            $this->load->view('register/create');

            $this->load->view('fixed/footer');

        }

    }





    public function delete_i()

    {

        $id = $this->input->post('deleteid');

        if ($id) {



            $this->db->delete('geopos_register', array('id' => $id));





            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

        }

    }



    public function load_list()

    {

        $list = $this->register->get_datatables();

        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $promo) {

            $no++;

            switch ($promo->active) {

                case 1 :

                    $promo_status = '<span class="st-paid">' . $this->lang->line('Active') . '</a>';

                    break;

                case 0 :

                    $promo_status = '<span class="st-due">' . $this->lang->line('Close') . '</a>';

                    break;



            }

            $row = array();

            $row[] = $no;

            $row[] = $promo->username;

            $row[] = $promo->o_date;

            $row[] = $promo->c_date;

            $row[] = $promo_status;

            $row[] = '<a href="#" class="btn btn-primary btn-sm rounded set-reg" data-id="' . $promo->id . '" data-stat="0"  data-toggle="modal" data-target="#view_register" > ' . $this->lang->line('View') . ' </a> <a href="#" data-object-id="' . $promo->id . '" class="btn btn-danger btn-sm delete-object"><span class="icon-bin"></span></a>';





            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->register->count_all(),

            "recordsFiltered" => $this->register->count_filtered(),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);

    }



    public function promo_stats()

    {



        $this->promo->promo_stats();





    }



    public function set_status()

    {

        $id = $this->input->post('tid');

        $stat = $this->input->post('stat');

        $this->promo->set_status($id, $stat);

        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED'), 'pstatus' => 'Success'));





    }



    public function file_handling()

    {

        if ($this->input->get('op')) {

            $name = $this->input->get('name');

            if ($this->products->meta_delete($name)) {

                echo json_encode(array('status' => 'Success'));

            }

        } else {

            $id = $this->input->get('id');

            $this->load->library("Uploadhandler_generic", array(

                'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/company/', 'upload_url' => base_url() . 'userfile/company/'

            ));





        }





    }





}