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



class Supplier extends CI_Controller

{



    public function __construct()

    {

        parent::__construct();

        $this->load->model('supplier_model', 'supplier');

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



        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'Supplier';

        $this->load->view('fixed/header', $head);

        $this->load->view('supplier/clist');

        $this->load->view('fixed/footer');

    }



    public function create()

    {

        $data['customergrouplist'] = $this->supplier->group_list();

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'Create Supplier';

        $this->load->view('fixed/header', $head);

        $this->load->view('supplier/create', $data);

        $this->load->view('fixed/footer');

    }



    public function view()

    {

        $custid = $this->input->get('id');

        $data['details'] = $this->supplier->details($custid);

        $data['customergroup'] = $this->supplier->group_info($data['details']['gid']);

        $data['money'] = $this->supplier->money_details($custid);

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'View Supplier';

        $this->load->view('fixed/header', $head);

        $this->load->view('supplier/view', $data);

        $this->load->view('fixed/footer');

    }



    public function load_list()

    {

        $list = $this->supplier->get_datatables();

        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $customers) {

            $no++;



            $row = array();

            $row[] = $no;

            $row[] = '<a href="supplier/view?id=' . $customers->id . '">' . $customers->name . '</a>';

            $row[] = $customers->address . ',' . $customers->city . ',' . $customers->country;

            $row[] = $customers->email;

            $row[] = $customers->phone;

            $row[] = '<a href="supplier/view?id=' . $customers->id . '" class="btn btn-info btn-sm"><span class="icon-eye"></span> ' . $this->lang->line('View') . '</a> <a href="supplier/edit?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="icon-bin"></span></a>';





            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->supplier->count_all(),

            "recordsFiltered" => $this->supplier->count_filtered(),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);

    }



    //edit section

    public function edit()

    {

        $pid = $this->input->get('id');



        $data['customer'] = $this->supplier->details($pid);

        $data['customergroup'] = $this->supplier->group_info($pid);

        $data['customergrouplist'] = $this->supplier->group_list();

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'Edit Supplier';

        $this->load->view('fixed/header', $head);

        $this->load->view('supplier/edit', $data);

        $this->load->view('fixed/footer');



    }



    public function addsupplier()

    {

        $name = $this->input->post('name',true);

        $company = $this->input->post('company',true);

        $phone = $this->input->post('phone',true);

        $email = $this->input->post('email',true);

        $address = $this->input->post('address',true);

        $city = $this->input->post('city',true);

        $region = $this->input->post('region',true);

        $country = $this->input->post('country',true);

        $postbox = $this->input->post('postbox',true);

        $taxid = $this->input->post('taxid',true);



        $this->supplier->add($name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $taxid);



    }



    public function editsupplier()

    {

        $id = $this->input->post('id',true);

        $name = $this->input->post('name',true);

        $company = $this->input->post('company',true);

        $phone = $this->input->post('phone',true);

        $email = $this->input->post('email',true);

        $address = $this->input->post('address',true);

        $city = $this->input->post('city',true);

        $region = $this->input->post('region',true);

        $country = $this->input->post('country',true);

        $postbox = $this->input->post('postbox',true);

        $taxid = $this->input->post('taxid',true);



        if ($id) {

            $this->supplier->edit($id, $name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $taxid);

        }

    }





    public function delete_i()

    {

        $id = $this->input->post('deleteid');



        if ($this->supplier->delete($id)) {

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

        }

    }



    public function displaypic()

    {

        $id = $this->input->get('id');

        $this->load->library("uploadhandler", array(

            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/customers/'

        ));

        $img = (string)$this->uploadhandler->filenaam();

        if ($img != '') {

            $this->supplier->editpicture($id, $img);

        }





    }





    public function translist()

    {

        $cid = $this->input->post('cid');

        $list = $this->supplier->trans_table($cid);

        $data = array();

        // $no = $_POST['start'];

        $no = $this->input->post('start');

        foreach ($list as $prd) {

            $no++;

            $row = array();

            $pid = $prd->id;

            $row[] = $prd->date;

            $row[] = amountFormat($prd->debit);

            $row[] = amountFormat($prd->credit);

            $row[] = $prd->account;

            $row[] = $prd->payer;

            $row[] = $this->lang->line($prd->method);



            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-eye"></span> ' . $this->lang->line('View') . '</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-bin"></span> ' . $this->lang->line('Delete') . '</a>';

            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->supplier->trans_count_all($cid),

            "recordsFiltered" => $this->supplier->trans_count_filtered($cid),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);

    }



    public function inv_list()

    {

        $cid = $this->input->post('cid');

        $list = $this->supplier->inv_datatables($cid);

        $data = array();



        $no = $this->input->post('start');



        foreach ($list as $invoices) {

            $no++;

            $row = array();

            $row[] = $no;

            $row[] = $invoices->tid;



            $row[] = $invoices->invoicedate;

            $row[] = amountFormat($invoices->total);

            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';

            $row[] = '<a href="' . base_url("purchase/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("purchase/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="icon-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object"><span class="icon-trash"></span></a>';

            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->supplier->inv_count_all($cid),

            "recordsFiltered" => $this->supplier->inv_count_filtered($cid),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }





    public function transactions()

    {

        $custid = $this->input->get('id');

        $data['details'] = $this->supplier->details($custid);

        $data['money'] = $this->supplier->money_details($custid);

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'View Supplier';

        $this->load->view('fixed/header', $head);

        $this->load->view('supplier/transactions', $data);

        $this->load->view('fixed/footer');

    }



    public function invoices()

    {

        $custid = $this->input->get('id');

        $data['details'] = $this->supplier->details($custid);



        $data['money'] = $this->supplier->money_details($custid);

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'View Supplier Invoices';

        $this->load->view('fixed/header', $head);

        $this->load->view('supplier/invoices', $data);

        $this->load->view('fixed/footer');

    }





}