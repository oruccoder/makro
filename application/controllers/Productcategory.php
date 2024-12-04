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


defined('BASEPATH') or exit('No direct script access allowed');


class Productcategory extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->model('categories_model', 'products_cat');
        $this->load->model('products_model', 'products');

        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');
        }

        if (!$this->aauth->premission(2)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
    }


    public function warehouseproduct_list()

    {

        $catid = $this->input->get('id');


        $list = $this->products->get_datatables_depo($catid, true);

        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $prd) {

            $no++;

            $kalan = $prd->qty - stok_cikisi($prd->pid, $catid);

            $row = array();

            $row[] = $no;

            $pid = $prd->pid;

            $row[] = $prd->product_name;

            $row[] = $prd->qty . ' ' . units_($prd->unit)['name'];
            $row[] = stok_cikisi($prd->pid, $catid) . ' ' . units_($prd->unit)['name'];;

            $row[] = $kalan . ' ' . units_($prd->unit)['name'];

            //$row[] = '<a href="#" data-object-id="' . $pid . '" class="btn btn-success btn-xs  view-object"><span class="icon-eye"></span> ' . $this->lang->line('View') . '</a> <a href="' . base_url() . 'products/edit?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs  delete-object"><span class="icon-bin"></span> ' . $this->lang->line('Delete') . '</a>';

            $data[] = $row;
        }


        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->products->count_all_depo($catid, true),

            "recordsFiltered" => $this->products->count_filtered_depo($catid, true),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);
    }


    public function index()

    {

        $data['cat'] = $this->products_cat->category_stock();

        $head['title'] = "Ürün Kategorileri";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('products/category', $data);

        $this->load->view('fixed/footer');
    }


    public function warehouse()

    {

        $data['cat'] = $this->products_cat->warehouse();

        $head['title'] = "Depolar";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('products/warehouse', $data);

        $this->load->view('fixed/footer');
    }


    public function view()

    {

        $data['cat'] = $this->products_cat->category_stock();

        $head['title'] = "View Product Category";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('products/category_view', $data);

        $this->load->view('fixed/footer');
    }


    public function warehouse_report()
    {
        $pid = intval($this->input->post('id'));

        $r_type = intval($this->input->post('r_type'));
        $s_date = datefordatabase($this->input->post('s_date'));
        $e_date = datefordatabase($this->input->post('e_date'));

        if ($pid && $r_type) {
            $qj = '';
            $wr = '';
            if ($this->aauth->get_user()->loc) {
                $qj = "LEFT JOIN geopos_warehouse ON geopos_products.warehouse=geopos_warehouse.id";

                $wr = " AND geopos_warehouse.loc='" . $this->aauth->get_user()->loc . "'";
            }

            switch ($r_type) {
                case 1:
                    $query = $this->db->query("SELECT geopos_invoices.tid,geopos_invoice_items.qty,geopos_invoice_items.price,geopos_invoices.invoicedate FROM geopos_invoice_items LEFT JOIN geopos_invoices ON geopos_invoices.id=geopos_invoice_items.tid LEFT JOIN geopos_products ON geopos_products.pid=geopos_invoice_items.pid $qj WHERE geopos_invoices.status!='canceled'  AND (DATE(geopos_invoices.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date')) AND geopos_products.warehouse='$pid' $wr");
                    $result = $query->result_array();
                    break;

                case 2:
                    $query = $this->db->query("SELECT geopos_purchase.tid,geopos_purchase_items.qty,geopos_purchase_items.price,geopos_purchase.invoicedate FROM geopos_purchase_items LEFT JOIN geopos_purchase ON geopos_purchase.id=geopos_purchase_items.tid LEFT JOIN geopos_products ON geopos_products.pid=geopos_purchase_items.pid  LEFT JOIN geopos_product_cat ON geopos_product_cat.id=geopos_products.pcat  WHERE geopos_purchase.status!='canceled' AND (DATE(geopos_purchase.invoicedate) BETWEEN DATE('$s_date') AND DATE('$e_date')) AND geopos_products.pcat='$pid' ");
                    $result = $query->result_array();
                    break;

                case 3:
                    $query = $this->db->query("SELECT geopos_movers.rid2 AS qty, DATE(geopos_movers.d_time) AS  invoicedate,geopos_movers.note,geopos_products.product_price AS price,geopos_products.product_name  FROM geopos_movers LEFT JOIN geopos_products ON geopos_products.pid=geopos_movers.rid1  WHERE geopos_movers.d_type='1' AND geopos_products.warehouse='$pid'  AND (DATE(geopos_movers.d_time) BETWEEN DATE('$s_date') AND DATE('$e_date'))");
                    $result = $query->result_array();
                    break;
            }


            $this->db->select('*');
            $this->db->from('geopos_warehouse');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $html = $this->load->view('products/ware_statementpdf-ltr', array('report' => $result, 'product' => $product, 'r_type' => $r_type), true);
            ini_set('memory_limit', '64M');


            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pid . 'report.pdf', 'I');
        } else {
            $pid = intval($this->input->get('id'));
            $this->db->select('*');
            $this->db->from('geopos_warehouse');
            $this->db->where('id', $pid);
            $query = $this->db->get();
            $product = $query->row_array();

            $head['title'] = "Ürün Satış Raporu";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/ware_statement', array('id' => $pid, 'product' => $product));
            $this->load->view('fixed/footer');
        }
    }


    public function viewwarehouse()

    {

        $data['cat'] = $this->products_cat->warehouse();

        $head['title'] = "Depoda Bulunan Ürünler";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('products/warehouse_view', $data);

        $this->load->view('fixed/footer');
    }


    public function add()

    {

        $data['cat'] = $this->products_cat->category_list();

        $this->load->model('locations_model');

        $data['locations'] = $this->locations_model->locations_list2();

        $head['title'] = "Add Product Category";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('products/category_add', $data);

        $this->load->view('fixed/footer');
    }


    public function addwarehouse()

    {

        if ($this->input->post()) {


            $cat_name = $this->input->post('product_catname');

            $proje_id = $this->input->post('proje_id');

            $cat_desc = $this->input->post('product_catdesc');

            $lid = $this->input->post('lid');

            if ($this->aauth->get_user()->roleid == 4 || $this->aauth->get_user()->roleid == 7 || $this->aauth->get_user()->roleid == 9) {

                $lid = $this->input->post('lid');
            } else {

                exit();
            }


            if ($cat_name) {


                $this->products_cat->addwarehouse($cat_name, $cat_desc, $lid, $proje_id);
            }
        } else {

            $this->load->model('locations_model');

            $data['locations'] = $this->locations_model->locations_list2();

            $data['cat'] = $this->products_cat->category_list();

            $head['title'] = "Depo Ekle";

            $head['usernm'] = $this->aauth->get_user()->username;

            $this->load->view('fixed/header', $head);

            $this->load->view('products/warehouse_add', $data);

            $this->load->view('fixed/footer');
        }
    }


    public function addcat()

    {

        $cat_name = $this->input->post('product_catname', true);
        $cat_rel = $this->input->post('cat_rel', true);

        $cat_desc = $this->input->post('product_catdesc', true);

        $cat_type = 0;

        if ($cat_rel != 0) {
            $cat_type = 1;
        }


        if ($cat_name) {

            $this->products_cat->addnew($cat_name, $cat_desc, $cat_type, $cat_rel);
        }
    }


    public function delete_i()

    {

        $id = $this->input->post('deleteid');

        if ($id) {

            $this->db->delete('geopos_products', array('pcat' => $id));

            $this->db->delete('geopos_product_cat', array('id' => $id));

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Product Category with products')));
        } else {

            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    public function delete_warehouse()

    {

        $id = $this->input->post('deleteid');

        if ($id) {

            $this->db->delete('geopos_products', array('pcat' => $id));

            $this->db->delete('geopos_warehouse', array('id' => $id));

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Product Warehouse with products')));
        } else {

            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    //view for edit

    public function edit()

    {


        $catid = $this->input->get('id');


        $data['cat'] = $this->products_cat->category_list($catid);

        $this->db->select('*');

        $this->db->from('geopos_product_cat');

        $this->db->where('id', $catid);

        $query = $this->db->get();

        $data['productcat'] = $query->row_array();


        $head['title'] = "Kategori Düzenle";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('products/product-cat-edit', $data);

        $this->load->view('fixed/footer');
    }


    public function editwarehouse()

    {

        if ($this->input->post()) {

            $cid = $this->input->post('catid');

            $cat_name = $this->input->post('product_cat_name', true);

            $cat_desc = $this->input->post('product_cat_desc', true);
            $proje_id = $this->input->post('proje_id', true);

            $lid = $this->input->post('lid');


            if ($this->aauth->get_user()->loc) {

                if ($lid == 0 or $this->aauth->get_user()->loc == $lid) {
                } else {

                    exit();
                }
            }


            if ($cat_name) {


                $this->products_cat->editwarehouse($cid, $cat_name, $cat_desc, $lid, $proje_id);
            }
        } else {

            $catid = $this->input->get('id');

            $this->db->select('*');

            $this->db->from('geopos_warehouse');

            $this->db->where('id', $catid);

            $query = $this->db->get();

            $data['warehouse'] = $query->row_array();

            $this->load->model('locations_model');

            $data['locations'] = $this->locations_model->locations_list2();

            $head['title'] = "Depo Düzenle";

            $head['usernm'] = $this->aauth->get_user()->username;

            $this->load->view('fixed/header', $head);

            $this->load->view('products/product-warehouse-edit', $data);

            $this->load->view('fixed/footer');
        }
    }


    public function editcat()

    {

        $cid = $this->input->post('catid');

        $cat_rel = $this->input->post('cat_rel', true);

        $cat_type = 0;

        if ($cat_rel != 0) {
            $cat_type = 1;
        }

        $product_cat_name = $this->input->post('product_cat_name');

        $product_cat_desc = $this->input->post('product_cat_desc');

        if ($cid) {

            $this->products_cat->edit($cid, $product_cat_name, $product_cat_desc, $cat_type, $cat_rel);
        }
    }
}
