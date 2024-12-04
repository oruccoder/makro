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



class Search extends CI_Controller

{

    public function __construct()

    {



        parent::__construct();

        $this->load->model('search_model', 'search');

        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }



    }



    public function search_invoice()

    {

        $invoicenumber = $this->input->post('');



        $data['search'] = $this->search->invoice($invoicenumber);



        $this->load->model('transactions_model');

        $data['accounts'] = $this->transactions_model->acc_list();

        $head['title'] = "Product Categories";

        $head['usernm'] = $this->aauth->get_user()->username;



        $this->load->view('fixed/header', $head);

        $this->load->view('search/invoice', $data);

        $this->load->view('fixed/footer');



    }





    public function invoice()

    {

        $result = array();

        $out = array();

        $tid = $this->input->get('keyword', true);

             $whr='';

       if ($this->aauth->get_user()->loc) {

            $whr=' (loc='.$this->aauth->get_user()->loc.' OR loc=0) AND ';

        }



        if ($tid) {

            $query = $this->db->query("SELECT tid FROM geopos_invoices WHERE $whr (UPPER(tid)  LIKE '" . $tid . "%')  LIMIT 4");



            $result = $query->result_array();



            echo '<ul>';

            $i = 1;

            foreach ($result as $row) {





                echo "<li ><a href='" . base_url('invoices/view?id=' . $row['tid']) . "'>" . $row['tid'] . "</a></li>";

                $i++;

            }

            echo '</ul>';





        }



    }



    public function customer()

    {



        $name = $this->input->get('keyword', true);

      $whr='';

       if ($this->aauth->get_user()->loc) {

            $whr=' (loc='.$this->aauth->get_user()->loc.' OR loc=0) AND ';

        }



        if ($name) {

            $query = $this->db->query("SELECT id,name,address,city,phone,email,company FROM geopos_customers WHERE $whr (UPPER(name)   LIKE '%" . strtoupper($name) . "%' OR UPPER(company) LIKE '" . strtoupper($name) . "%' OR UPPER(phone) LIKE '" . strtoupper($name) ."%') LIMIT 6");



            $result = $query->result_array();





            $i = 1;

            foreach ($result as $row) {





                echo '

                    <a href="' . base_url('customers/view?id=' . $row['id']) . '" class="list-group-item">  <div class="media">

                        <div class="media-left valign-middle"><i class="icon-user1 icon-bg-circle bg-cyan"></i></div>

                        <div class="media-body">

                          <h6 class="media-heading">' . $row['company'] . '</h6>

                          <p class="notification-text font-small-3 text-muted">' . $row['address'] . ',' . $row['city'].','.$row['name']. '</p><small><i class="icon-phone"></i> ' . $row['phone'] . '</small>

                        </div>

                      </div></a>



               ';

                $i++;

            }





        }



    }



    public function user()

    {



        $name = $this->input->get('username', true);





        if ($name != '') {

            //$query = $this->db->query("SELECT id,name as username FROM geopos_employees WHERE name  LIKE '%" . $name . "%' LIMIT 12");

            $this->db->select('geopos_employees.id,geopos_employees.name as username');
            $this->db->from('geopos_employees');
            $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id');
            $this->db->join('personel_salary', 'personel_salary.personel_id = geopos_users.id','left');
            $this->db->join('geopos_projects', 'personel_salary.proje_id = geopos_projects.id','left');
            $this->db->where('geopos_users.banned', 0);
            $this->db->where('personel_salary.status', 1);
            $this->db->like('geopos_employees.name', $name);
            $this->db->order_by('geopos_users.id', 'DESC');
            $query = $this->db->get();
            $result = $query->result_array();









            $i = 1;

            echo '<ol>';

            foreach ($result as $row) {





                echo '<li class="selectuser" data-username="' . $row['username'] . '" data-userid="' . $row['id'] . '">' . $row['username'] . '</li> ';



            }

            echo '</ol>';







        }



    }



    public function customer_select()

    {



        $name = $this->input->post('customer', true);



        $loc = $this->session->userdata('set_firma_id');

        if ($name) {

            $query = $this->db->query("SELECT company,id,name,address,city,phone,email FROM geopos_customers 
WHERE geopos_customers.loc=$loc and (UPPER(name)  LIKE '%" . strtoupper($name['term']) . "%' or UPPER(company)  LIKE '%" . strtoupper($name['term']) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name['term']) . "%') LIMIT 6");


            //$query = $this->db->query("SELECT id,name,address,city,phone,email FROM geopos_customers WHERE  (UPPER(name)  LIKE '" . strtoupper($name['term']) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name['term']) . "%') LIMIT 6");



            $result = $query->result_array();





            echo json_encode($result);





        }



    }

    public function product_select()

    {
        $name = $this->input->post('product', true);
        if ($name) {
            $query = $this->db->query("SELECT product_name,pid FROM geopos_products  WHERE (UPPER(product_name)  LIKE '%" . strtoupper($name['term']) . "%' or UPPER(product_code)  LIKE '%" . strtoupper($name['term']) . "%' OR UPPER(barcode)  LIKE '" . strtoupper($name['term']) . "%') LIMIT 30");
            $result = $query->result_array();
            echo json_encode($result);

        }
    }



    public function supplier_select()

    {



        $name = $this->input->post('supplier', true);

      $whr='';

       if ($this->aauth->get_user()->loc) {

            $whr=' (loc='.$this->aauth->get_user()->loc.' OR loc=0) AND ';

        }



        if ($name) {

            $query = $this->db->query("SELECT id,name,address,city,phone,email FROM geopos_supplier WHERE $whr (UPPER(name)  LIKE '" . strtoupper($name['term']) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name['term']) . "%') LIMIT 6");



            $result = $query->result_array();





            echo json_encode($result);





        }



    }





}
