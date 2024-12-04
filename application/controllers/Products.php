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


use Mike42\Escpos\PrintConnectors\FilePrintConnector;

use Mike42\Escpos\Printer;




class Products extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();



        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');
        }


        if ($this->aauth->get_user()->roleid == 2) {

            $this->limited = $this->aauth->get_user()->id;
        } else {

            $this->limited = '';
        }

        $this->load->model('products_model', 'products');

        $this->load->model('categories_model');
    }




    public function product_name(){
        $product_id = $this->input->post('product_id');
        $product_name = product_name($product_id);
        echo json_encode(array(
            'product_name' => $product_name
        ));

    }
    public function add_cart()
    {
        $product_id = $this->input->post('product_id');
        $miktar = $this->input->post('miktar');
        $user_id = $this->aauth->get_user()->id;
        $cart = $this->products->cart_add($product_id, $user_id, $miktar);

        $product_name = product_name($product_id);
        echo json_encode(array(
            'product_id' => $product_id,
            'count' => $cart['count'],
            'status' => 'Başarılı',
            'message' => $product_name . ' ürünü başarılı bir şekilde sepete eklendi'
        ));
    }

    public function index()

    {

        $this->load->helper('cookie');
        delete_cookie("pids");

        $head['title'] = "Ürünler";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('products/products');

        $this->load->view('fixed/footer');
    }



    public function cat()

    {

        $head['title'] = "Kategoriler";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('products/cat_productlist');

        $this->load->view('fixed/footer');
    }





    public function add()

    {
        $_arr = [21, 735, 732, 748, 640, 796, 797, 801];
        if (!in_array($this->aauth->get_user()->id, $_arr)) {

            exit('<h3>Yetkiniz Yoktur!</h3>');
        }

        /*$data['cat'] = $this->categories_model->category_list_();*/
        $data['cat'] = $this->categories_model->category_list();


        $data['ana_kategoriler'] = $this->categories_model->category_list_();
        $data['alt_kat'] = $this->categories_model->alt_kat();

        $data['units'] = $this->products->units();

        $data['paketleme_tipi'] = $this->products->paketleme_tipi();

        $data['warehouse'] = $this->categories_model->warehouse_list();

        $this->load->model('units_model', 'units');

        $data['variables'] = $this->units->variables_list();

        $head['title'] = "Yeni Ürün";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('products/product-add', $data);

        $this->load->view('fixed/footer');
    }





    public function product_list()

    {



        $catid = $this->input->get('id');



        $list = $this->products->get_datatables();

        $data = array();

        $no = $this->input->post('start');


        foreach ($list as $prd) {

            $no++;

            $row = array();


            $pid = $prd->pid;


            $row[] = $no;


            $row[] = '<span class="avatar-lg align-baseline"><img class="myImg" resim_yolu="' . base_url() . 'userfiles/product/' . $prd->image . '" src="' . base_url() . 'userfiles/product/thumbnail/' . $prd->image . '" ></span> &nbsp;' . $prd->product_name;

            $row[] = toplam_rulo_adet($prd->pid)['toplam_adet'] . ' ' . units_($prd->unit)['name'];
            $row[] = toplam_rulo_adet($prd->pid)['rezerve_qty'] . ' ' . units_($prd->unit)['name'];

            $row[] = $prd->product_code;
            $row[] = $prd->kalite;
            $row[] = $prd->uretim_yeri;

            $row[] = $prd->title;

            $loc = $this->aauth->get_user()->loc;
            $para_birimi = loc_para_birimi($loc);
            $row[] = amountFormat($prd->product_price, $para_birimi);

            $row[] = '

            <div class="btn-group">
                        <button type="button" class="btn btn btn-primary dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i>  </button>
                        <div class="dropdown-menu">&nbsp;
                            <a href="' . base_url() . 'products/edit?id=' . $pid . '"  class="btn btn-purple btn-sm"><span class="fa fa-edit"></span>' . $this->lang->line('Edit') . '</a>
                            <div class="dropdown-divider"></div>&nbsp;
                            <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span>' . $this->lang->line('Delete') . '</a>
                              <div class="dropdown-divider"></div>&nbsp;
                               <a href="#" data-object-id="' . $pid . '" class="btn btn-info btn-sm  clone-object"><span class="fa fa-clone"></span>Kopyala</a>
                                <div class="dropdown-divider"></div>&nbsp;
                                <a href="#" data-object-id="' . $pid . '" class="btn btn-success btn-sm  view-object"> <span class="icon-eye"></span>Göster</a>
                                  <div class="dropdown-divider"></div>&nbsp;
                                    <a href="#" data-object-id="' . $pid . '" class="btn btn-warning btn-sm view-bilgi"><span class="fa fa-eye">Bilgiler</span> </a>
                                    <div class="dropdown-divider"></div>&nbsp;
                                    <a class="btn btn-pink  btn-sm" href="' . base_url() . 'products/sales_product?id=' . $pid . '" target="_blank"> <span class="fa fa-pie-chart"></span> Satış Raporu</a>
                                     <div class="dropdown-divider"></div>&nbsp;

                        </div>
                </div>';
            $row[] = '

            <a href="' . base_url() . 'products/barcode?id=' . $pid . '" class="btn btn-info btn-xs"><span class="fa fa-barcode"></span></a>

            <a href="' . base_url() . 'products/poslabel?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="fa fa-barcode"></span> </a>
            ';


            $row[] = '<input type="checkbox" name="sec[]" class="sec" value="' . $pid . '" />';
            $data[] = $row;
        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->products->count_all($catid),

            "recordsFiltered" => $this->products->count_filtered($catid),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);
    }



    public function addproduct()

    {



        $product_code =  numaric(21);
        $product_name = $this->input->post('product_name', true);

        $catid = $this->input->post('product_cat');

        $warehouse = $this->input->post('product_warehouse');



        $product_price = $this->input->post('product_price');

        $factoryprice = $this->input->post('fproduct_price');

        $taxrate = $this->input->post('product_tax', true);

        $disrate = $this->input->post('product_disc', true);

        $product_qty = $this->input->post('product_qty', true);

        $product_qty_alert = $this->input->post('product_qty_alert');

        $product_desc = $this->input->post('product_desc', true);

        $image = $this->input->post('image');

        $unit = $this->input->post('unit', true);

        $metrekare_agirligi = $this->input->post('metrekare_agirligi', true);

        $barcode = $this->input->post('barcode');

        //Gruplu Ürün

        $en = $this->input->post('en');

        $boy = $this->input->post('boy');

        $g_urun_adi = $this->input->post('g_urun_adi');

        $g_stock = $this->input->post('g_stock');

        $g_urun_code = $this->input->post('g_urun_code');
        $g_urun_paketleme_miktari = $this->input->post('g_urun_paketleme_miktari');

        $v_alert = $this->input->post('v_alert');

        $product_type = $this->input->post('product_type');

        $wdate = datefordatabase($this->input->post('wdate'));

        $kalite = $this->input->post('kalite');

        $uretim_yeri = $this->input->post('uretim_yeri');

        $iscilik_price = $this->input->post('iscilik_price');
        $paketleme_tipi = $this->input->post('paketleme_tipi');
        $raf_no = $this->input->post('raf_no');





        $this->products->addnew(
            $catid,
            $warehouse,
            $product_name,
            $product_code,
            $product_price,
            $factoryprice,
            $taxrate,
            $disrate,
            $product_qty,
            $product_qty_alert,
            $product_desc,
            $image,
            $unit,
            $barcode,
            $wdate,
            $product_type,
            $en,
            $boy,
            $g_urun_adi,
            $g_urun_code,
            $v_alert,
            $g_stock,
            $metrekare_agirligi,
            $kalite,
            $uretim_yeri,
            $iscilik_price,
            $paketleme_tipi,
            $g_urun_paketleme_miktari,
            $raf_no
        );
    }






    public function delete_i()

    {

        if (!$this->aauth->premission(38)) {

            exit('<h3>Yetkiniz Yoktur!</h3>');
        }
        $id = $this->input->post('deleteid');

        if ($id) {

            $grp = $this->db->query("Select * From geopos_products Where pid=$id");
            if ($grp->num_rows() > 0) {
                $stok_mik = stok_ogren($id);
                $depo_id = product_depo($id); //7

                foreach ($depo_id as $dp_id) {

                    $this->stock_update($stok_mik, $id, 1, 0, $dp_id['warehouse_id']);
                }

                $this->db->delete('geopos_products', array('pid' => $id));
                $this->db->delete('geopos_products', array('parent_id' => $id));
            }




            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {

            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    public function delete_i_stock()
    {
        $id = $this->input->post('deleteid');



        if ($this->products->stok_delete($id, $this->limited)) {

            echo json_encode(array('status' => 'Success', 'message' =>

            $this->lang->line('DELETED')));
        } else {



            echo json_encode(array('status' => 'Error', 'message' =>

            $this->lang->line('ERROR')));
        }
    }



    public function edit()

    {

        if (!$this->aauth->premission(37)) {

            exit('<h3>Yetkiniz Yoktur!</h3>');
        }
        $pid = $this->input->get('id');

        $this->db->select('*');

        $this->db->from('geopos_products');

        $this->db->where('pid', $pid);

        $query = $this->db->get();

        $data['product'] = $query->row_array();

        $this->db->select('*');

        $this->db->from('geopos_products');

        $this->db->where('parent_id', $pid);

        $query_g = $this->db->get();


        $data['gruplu_urun'] = $query_g->result_array();






        $data['units'] = $this->products->units();
        $data['paketleme_tipi'] = $this->products->paketleme_tipi();

        $data['prd_ware'] = $this->products->prd_ware($pid);

        $data['cat_ware'] = $this->categories_model->cat_ware($pid);

        $data['warehouse'] = $this->categories_model->warehouse_list();

        $data['cat'] = $this->categories_model->category_list();

        $head['title'] = "Ürün Düzenle";

        $head['usernm'] = $this->aauth->get_user()->username;



        $this->load->view('fixed/header', $head);

        $this->load->view('products/product-edit', $data);

        $this->load->view('fixed/footer');
    }



    public function editproduct()

    {

        $pid = $this->input->post('pid');

        $product_name = $this->input->post('product_name', true);

        $catid = $this->input->post('product_cat');

        $warehouse = $this->input->post('product_warehouse');


        $product_price = $this->input->post('product_price');

        $factoryprice = $this->input->post('fproduct_price');

        $taxrate = $this->input->post('product_tax');

        $disrate = $this->input->post('product_disc');

        $product_qty = $this->input->post('product_qty');

        $product_qty_alert = $this->input->post('product_qty_alert');

        $product_desc = $this->input->post('product_desc', true);

        $image = $this->input->post('image');

        $unit = $this->input->post('unit');

        $metrekare_agirligi = $this->input->post('metrekare_agirligi', true);

        $barcode = $this->input->post('barcode');

        //Gruplu Ürün

        $en = $this->input->post('en');


        $boy = $this->input->post('boy');

        $g_urun_adi = $this->input->post('g_urun_adi');
        $g_stock = $this->input->post('g_stock');

        $g_urun_code = $this->input->post('g_urun_code');
        $g_urun_paketleme_miktari = $this->input->post('g_urun_paketleme_miktari');

        $v_alert = $this->input->post('v_alert');
        $g_pid = $this->input->post('g_pid');



        $product_type = $this->input->post('product_type');
        $kalite = $this->input->post('kalite');
        $uretim_yeri = $this->input->post('uretim_yeri');
        $iscilik_price = $this->input->post('iscilik_price');
        $paketleme_tipi = $this->input->post('paketleme_tipi');
        $raf_no = $this->input->post('raf_no');

        if ($pid) {

            $this->products->edit(
                $pid,
                $catid,
                $warehouse,
                $product_name,
                $product_price,
                $factoryprice,
                $taxrate,
                $disrate,
                $product_qty,
                $product_qty_alert,
                $product_desc,
                $image,
                $unit,
                $barcode,
                $product_type,
                $en,
                $boy,
                $g_urun_adi,
                $g_stock,
                $g_urun_code,
                $v_alert,
                $g_pid,
                $metrekare_agirligi,
                $kalite,
                $uretim_yeri,
                $iscilik_price,
                $paketleme_tipi,
                $g_urun_paketleme_miktari,
                $raf_no
            );
        }
    }

    public function print_list_2()
    {

        $pids_array = $this->input->cookie('pids', TRUE);

        $data['products'] = $this->products->print_list($pids_array);



        ini_set('memory_limit', '128M');

        $html = $this->load->view('products/view-products-print-' . LTR, $data, true);

        $header = $this->load->view('products/header-products-print-' . LTR, $data, true);
        $this->load->library('pdf');


        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #</div>');



        $pdf->WriteHTML($html);



        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'Urun_listesi');

        if ($this->input->get('d')) {



            $pdf->Output($file_name . '.pdf', 'D');
        } else {

            $pdf->Output($file_name . '.pdf', 'I');
        }
    }


    public function print_list()
    {
        $data = array();
        $ids = array();

        $ids = $this->input->post('ids_array_name');




        $data['ids'] = $ids;


        $this->load->helper('cookie');
        setcookie('pids', $ids, time() + (86400 * 30), "/"); // 86400 = 1 day
        echo json_encode($data);









        /*$data['products'] = $this->products->print_list($num);



        ini_set('memory_limit', '128M');

        $html = $this->load->view('products/view-products-print-' . LTR, $data, true);

        $header = $this->load->view('products/header-products-print-' . LTR, $data, true);
        $this->load->library('pdf');


        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #</div>');



        $pdf->WriteHTML($html);



        $file_name = preg_replace( '/[^A-Za-z0-9]+/', '-', 'Urun_listesi');

        if ($this->input->get('d')) {



            $pdf->Output($file_name. '.pdf', 'D');

        } else {

            $pdf->Output($file_name . '.pdf', 'I');

        }*/
    }









    public function prd_stats()

    {



        $this->products->prd_stats();
    }



    public function stock_transfer_products()

    {

        $wid = $this->input->get('wid');

        $customer = $this->input->post('product');

        $terms = @$customer['term'];

        $result = $this->products->products_list($wid, $terms);

        echo json_encode($result);
    }



    public function stock_transfer()

    {

        if ($this->input->post()) {



            $products_l = $this->input->post('products_l'); //ürünler

            $from_warehouse = $this->input->post('from_warehouse'); // transfer edecek yer

            $to_warehouse = $this->input->post('to_warehouse'); // transfer edilecek yer

            $qty = $this->input->post('products_qty');





            $this->products->transfer($from_warehouse, $products_l, $to_warehouse, $qty);
        } else {



            $data['cat'] = $this->categories_model->category_list();

            $data['warehouse'] = $this->categories_model->warehouse_list();

            $head['title'] = "Stok Transferi";

            $head['usernm'] = $this->aauth->get_user()->username;

            $this->load->view('fixed/header', $head);

            $this->load->view('products/stock_transfer', $data);

            $this->load->view('fixed/footer');
        }
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

                'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/product/', 'upload_url' => base_url() . 'userfile/product/'

            ));
        }
    }

    public function test()
    {
        $en = $this->products->poruduct_details(731);

        echo $en['en'];
    }

    public function poslabel()
    {
        $pid = $this->input->get('id');
        if ($pid) {
            $this->db->select('*');
            $this->db->from('geopos_products');
            //  $this->db->where('warehouse', $warehouse);
            $this->db->where('pid', $pid);
            $query = $this->db->get();
            $resultz = $query->row_array();
            $loc = $this->aauth->get_user()->loc;
            $loc2 = location($loc);

            $html = $this->load->view('barcode/poslabel', array('lab' => $resultz, 'loca' => $loc2), true);
            ini_set('memory_limit', '64M');
            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load_thermal();
            $pdf->WriteHTML($html);
            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');
        }
    }




    public function barcode()

    {

        $pid = $this->input->get('id');

        if ($pid) {

            $this->db->select('product_name,barcode');

            $this->db->from('geopos_products');

            //  $this->db->where('warehouse', $warehouse);

            $this->db->where('pid', $pid);

            $query = $this->db->get();

            $resultz = $query->row_array();

            $data['name'] = $resultz['product_name'];

            $data['code'] = $resultz['barcode'];

            $html = $this->load->view('barcode/view', $data, true);

            ini_set('memory_limit', '64M');



            //PDF Rendering

            $this->load->library('pdf');

            $pdf = $this->pdf->load();

            $pdf->WriteHTML($html);

            $pdf->Output($data['name'] . '_barcode.pdf', 'I');
        }
    }


    public function clone()
    {
        if (!$this->aauth->premission(36)) {

            exit('<h3>Yetkiniz Yoktur!</h3>');
        }
        $this->db->trans_start();
        $pid = $this->input->post('id');
        $query = $this->db->query("SELECT * FROM `geopos_products` WHERE pid=$pid")->row_array();
        $prodindex = 0;
        $productlist = array();

        $barcode = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);
        $data = array(
            'pcat' => $query['pcat'],
            'product_type' => $query['product_type'],
            'warehouse' => $query['warehouse'],
            'product_name' => $query['product_name'],
            'product_code' => $query['product_code'],
            'product_price' => $query['product_price'],
            'fproduct_price' => $query['fproduct_price'],
            'taxrate' => $query['taxrate'],
            'disrate' => $query['disrate'],
            'qty' => $query['qty'],
            'product_des' => $query['product_des'],
            'alert' => $query['alert'],
            'unit' => $query['unit'],
            'image' => $query['image'],
            'barcode' => $barcode,
            'merge' => $query['merge'],
            'en' => $query['en'],
            'boy' => $query['boy'],
            'metrekare_agirligi' => $query['metrekare_agirligi'],
            'toplam_agirlik' => $query['toplam_agirlik'],
            'uretim_yeri' => $query['uretim_yeri'],
            'kalite' => $query['kalite'],
            'raf_no' => $query['raf_no']
        );

        if ($this->db->insert('geopos_products', $data)) {

            $last_id = $this->db->insert_id();

            $product_id = $this->db->insert_id();
            $depo = array(
                'product_id' => $product_id,
                'warehouse_id' => $query['warehouse'],
                'qty' => 0
            );
            $this->db->insert('geopos_product_to_warehouse', $depo);

            $parent_kontrol = $this->db->query("SELECT * FROM `geopos_products` WHERE parent_id=$pid")->result_array();
            if (count($parent_kontrol) > 0) {
                foreach ($parent_kontrol as $query) {
                    $barcode2 = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);
                    $data2 = array(
                        'parent_id' => $last_id,
                        'pcat' => $query['pcat'],
                        'product_type' => $query['product_type'],
                        'warehouse' => $query['warehouse'],
                        'product_name' => $query['product_name'],
                        'product_code' => $query['product_code'],
                        'product_price' => $query['product_price'],
                        'fproduct_price' => $query['fproduct_price'],
                        'taxrate' => $query['taxrate'],
                        'disrate' => $query['disrate'],
                        'qty' => 0,
                        'product_des' => $query['product_des'],
                        'alert' => $query['alert'],
                        'unit' => $query['unit'],
                        'image' => $query['image'],
                        'barcode' => $barcode2,
                        'merge' => $query['merge'],
                        'en' => $query['en'],
                        'boy' => $query['boy'],
                        'metrekare_agirligi' => $query['metrekare_agirligi'],
                        'toplam_agirlik' => $query['toplam_agirlik'],
                        'uretim_yeri' => $query['uretim_yeri'],
                        'kalite' => $query['kalite'],
                        'raf_no' => $query['raf_no']
                    );

                    $productlist[$prodindex] = $data2;
                    $prodindex++;
                }


                if ($prodindex > 0) {

                    $this->db->insert_batch('geopos_products', $productlist);
                } else {

                    echo json_encode(array('status' => 'Error', 'message' =>

                    "Lütfen Hataları Kontrol Edin.Eğer sorun yoksa ürün yöneticisine gidin."));
                    $this->db->trans_rollback();
                }
            }
        }





        if ($last_id) {
            $this->db->trans_complete();
        }
    }



    public function view_over()

    {

        $pid = $this->input->post('id');

        $this->db->select('geopos_products.*,geopos_warehouse.title');

        $this->db->from('geopos_products');

        $this->db->where('geopos_products.pid', $pid);

        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');

        if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);

            //$this->db->or_where('geopos_warehouse.loc', 0);

        }



        $query = $this->db->get();

        //echo  $this->db->last_query();
        //die();

        $data['product'] = $query->row_array();






        $this->db->select('geopos_products.*,geopos_warehouse.title');

        $this->db->from('geopos_products');

        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');

        if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
        }
        $this->db->where('geopos_products.parent_id', $pid);


        $query = $this->db->get();




        $data['product_variations'] = $query->result_array();




        $parent_ids = $this->db->query("Select * From geopos_products WHERE parent_id=$pid")->result_array();
        $ware = array();

        if ($parent_ids) {
            foreach ($parent_ids as $par) {

                $product_id = $par['pid'];
                $this->db->select('geopos_products.*,geopos_warehouse.title,geopos_product_to_warehouse.warehouse_id as depo_id');

                $this->db->from('geopos_products');


                $this->db->join('geopos_product_to_warehouse', 'geopos_product_to_warehouse.product_id = geopos_products.pid');
                $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_product_to_warehouse.warehouse_id');


                $this->db->where('geopos_products.pid', $product_id);

                $query = $this->db->get();

                $ware[] = $query->result_array();
                $data['product_warehouse'] = $ware;
            }
        } else {
            $this->db->select('geopos_products.*,geopos_warehouse.title,geopos_product_to_warehouse.warehouse_id as depo_id');
            $this->db->from('geopos_products');
            $this->db->join('geopos_product_to_warehouse', 'geopos_product_to_warehouse.product_id = geopos_products.pid');
            $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');
            if ($this->aauth->get_user()->loc) {
                $this->db->group_start();
                $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);
                if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                $this->db->group_end();
            } elseif (!BDATA) {
                $this->db->where('geopos_warehouse.loc', 0);
            }
            $this->db->where('geopos_products.sub', $pid);
            $this->db->or_where('geopos_products.pid', $pid);

            $query = $this->db->get();


            $ware[] = $query->result_array();
            $data['product_warehouse'] = $ware;
        }







        //var_dump($data['product_warehouse']);die();
        // $data['product_warehouse'];






        $this->load->view('products/view-over', $data);
    }

    public function stok_cikis()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $data = array();
        $data['emp'] = $this->products->employees();
        $data['warehouse'] = $this->products->warehouses();

        if ($this->input->get('id')) {

            $id = $this->input->get('id');
            $data['id'] = $id;
            $data['stok_cikis'] = $this->products->stock_cikis_details($id);
            if ($data['stok_cikis']['type'] == 1) {
                $head['title'] = "Stok Giriş Fişi Düzenle";
            } else {
                $head['title'] = "Stok Çıkış Fişi Düzenle";
            }

            $data['products'] = $this->products->stock_cikis_products($id);
        } else {
            $data['products'] = '';
            $data['stok_cikis'] = '';
            $head['title'] = "Stok Fişi";
        }




        $this->load->view('fixed/header', $head);

        $this->load->view('products/stok_cikis_fisi', $data);

        $this->load->view('fixed/footer');
    }






    public function stok_cikis_save()
    {


        $st_c = 0;
        $transok = true;
        $this->db->trans_start();


        $fis_no = $this->input->post('fis_no');
        $fis_name = $this->input->post('fis_name');
        $fis_note = $this->input->post('fis_note');
        $fis_date = $this->input->post('fis_date');
        $customer_id = $this->input->post('customer_id');
        $sorumlu_pers_id = $this->input->post('sorumlu_pers_id');
        $plaka_no = $this->input->post('plaka_no');
        $sofor_name = $this->input->post('sofor_name');
        $sofor_tel = $this->input->post('sofor_tel');
        $warehouses = $this->input->post('warehouses');
        $customer_type = $this->input->post('cari_type');
        $stok_guncelleme = $this->input->post('stok_durumu');

        $stok_guncellemes = isset($stok_guncelleme) ? 1 : 0;



        $type = $this->input->post('type');


        $product_id = $this->input->post('pid');
        $productlist = array();
        $productlist_proje = array();
        $prodindex = 0;

        $data = array(
            'fis_no' => $fis_no,
            'customer_id' => $customer_id,
            'fis_name' => $fis_name,
            'fis_note' => $fis_note,
            'sorumlu_pers_id' => $sorumlu_pers_id,
            'plaka_no' => $plaka_no,
            'sofor_name' => $sofor_name,
            'customer_type' => $customer_type,
            'sofor_tel' => $sofor_tel,
            'fis_date' => datefordatabase($fis_date),
            'user_id' => $this->aauth->get_user()->id,
            'type' => $type,
            'warehouse_id' => $warehouses,
            'stok_guncelleme' => $stok_guncellemes,
            'loc' => $this->aauth->get_user()->loc
        );


        if ($this->input->get('id')) {
            $id = $this->input->get('id');

            $old_depo = $this->db->query("Select * From geopos_stok_cikis where id= $id")->row_array();
            $old_depo_id = $old_depo['warehouse_id'];

            $this->db->set($data);

            $this->db->where('id', $id);

            if ($this->db->update('geopos_stok_cikis', $data)) {
                $this->db->delete('geopos_stok_cikis_items', array('tid' => $id));
                $this->db->delete('geopos_project_items_gider', array('tid' => $id, 'invoice_type_id' => 58));


                foreach ($product_id as $key => $value) {
                    $toplam_rulo = 0;
                    $product_id = $this->input->post('pid');
                    $product_unit = $this->input->post('product_unit');
                    $product_qty = $this->input->post('product_qty');
                    $product_name = $this->input->post('product_name');
                    $product_alert = $this->input->post('alert');
                    $old_product_qty = $this->input->post('old_product_qty');

                    $bolum_id = 0;
                    $bagli_oldugu_asama_id_val = 0;
                    $asama_id = 0;

                    if ($customer_type == 2) {
                        $details = $this->db->query("SELECT * FROM `geopos_invoice_items` WHERE `pid` = $product_id[$key] ORDER BY `geopos_invoice_items`.`price` DESC LIMIT 1")->row();
                        $price = $details->price;
                        $invoice_id = $details->tid;
                        $bolum_id = $this->input->post('bolum_id');
                        $asama_id = $this->input->post('asama_id');
                        $data2 = array(
                            'tid' => $id,
                            'pid' => $product_id[$key],
                            'unit' => $product_unit[$key],
                            'product' => $product_name[$key],
                            'qty' => $product_qty[$key],
                            'asama_id' => $asama_id[$key],
                            //'bagli_oldugu_asama_id_val' => $bagli_oldugu_asama_id_val[$key],
                            'bolum_id' => $bolum_id[$key],
                            'depo_id' => $warehouses,
                            'invoice_type_desc' => 'Stok Transfer',
                            'invoice_type_id' => 58,
                        );



                        $subtotal = floatval($price * $product_qty[$key]);
                        $data_prject = array(

                            'tid' => $invoice_id,
                            'pid' => $product_id[$key],
                            'unit' => $product_unit[$key],
                            'product' => $product_name[$key],
                            'qty' => $product_qty[$key],
                            'price' => $price,
                            'subtotal' => $subtotal,
                            'proje_id' => $customer_id,
                            'invoice_type_desc' => 'Stok Transfer',
                            'invoice_type_id' => 58,
                            'asama_id' => $asama_id[$key],
                            'bolum_id' => $bolum_id[$key],
                            'depo_id' => $warehouses,
                        );


                        $productlist_proje[$prodindex] = $data_prject;
                    } else {
                        $data2 = array(
                            'tid' => $id,
                            'pid' => $product_id[$key],
                            'unit' => $product_unit[$key],
                            'product' => $product_name[$key],
                            'qty' => $product_qty[$key],
                            'depo_id' => $warehouses,
                            'invoice_type_desc' => 'Stok Transfer',
                            'invoice_type_id' => 58,
                        );
                    }

                    $productlist[$prodindex] = $data2;
                    $prodindex++;

                    if (isset($old_product_qty[$key])) {
                        $old_product_qty[$key] = $old_product_qty[$key];
                    } else {
                        $old_product_qty[$key] = 0;
                    }



                    $amt = (+$product_qty[$key]) - (+$old_product_qty[$key]);


                    if ($product_id[$key] > 0) {

                        if ($stok_guncellemes == 1) // Eğer Fişte Stok Güncelleme Seçili İse Stok Güncellenecek

                        {



                            $product_details = $this->db->query("select * from geopos_products WHERE  pid = $product_id[$key]")->row_array();


                            if ($product_details['parent_id'] != 0) {

                                $parent_id = $product_details['parent_id'];


                                if ($product_details['en'] != 0 || $product_details['boy'] != 0) {

                                    $m2 = $product_details['en'] * $product_details['boy'] / 10000; // 3m2

                                    $eklenecek_stok = $amt;

                                    $toplam_rulos = $eklenecek_stok / $m2; //6

                                    $old_rulo =  $old_product_qty[$key] / $m2; // 7

                                    if (isset($old_rulo)) {

                                        $toplam_rulo = (+$toplam_rulos) - (+$old_rulo[$key]);
                                    }
                                } else {
                                    $eklenecek_stok = $amt;
                                    $toplam_rulo = 0;
                                }



                                if ($warehouses != $old_depo_id) {
                                    $this->depo_silme($old_depo_id, $product_id[$key], $old_product_qty[$key]);

                                    $this->stock_update($old_product_qty[$key], $parent_id, $type, $toplam_rulo, $warehouses, $product_unit[$key]); //ana ürüne eklenecek 730

                                    $this->stock_update($old_product_qty[$key], $product_id[$key], $type, $toplam_rulo, $warehouses, $product_unit[$key]); //731
                                } else {

                                    $this->stock_update($eklenecek_stok, $parent_id, $type, $toplam_rulo, $warehouses, $product_unit[$key]); //ana ürüne eklenecek 730

                                    $this->stock_update($amt, $product_id[$key], $type, $toplam_rulo, $warehouses, $product_unit[$key]); //731
                                }
                            } else {
                                if ($warehouses != $old_depo_id) {
                                    $this->depo_silme($old_depo_id, $product_id[$key], $old_product_qty[$key]);
                                    $this->stock_update($old_product_qty[$key], $product_id[$key], $type, $toplam_rulo, $warehouses, $product_unit[$key]);
                                } else {
                                    $this->stock_update($amt, $product_id[$key], $type, $toplam_rulo, $warehouses, $product_unit[$key]);
                                }
                            }


                            //Stok Kontrolü

                            if ($type == '1') {
                                if (($product_alert[$key] - $amt) < 0 and $st_c == 0) {

                                    echo json_encode(array(
                                        'status' => 'Error',
                                        'message' => 'Ürün Adı - ' . $product_name[$key] . '- Düşük Miktar. Mevcut Stok  ' . $product_alert[$key] . ' Çıkış Yapamazsınız'
                                    ));

                                    $st_c = 1;
                                    $transok = false;
                                }
                            }
                        }
                    }
                }

                if ($stok_guncellemes == 1) // Eğer Fişte Stok Güncelleme Seçili İse Stok Güncellenecek

                {
                    //silinen satırdaki ürünün stoğunu güncelleme

                    if ($this->input->post('restock')) {


                        $type = $this->input->post('type');


                        foreach ($this->input->post('restock') as $key => $value) {
                            $toplam_rulo = 0;

                            $myArray = explode('-', $value);

                            $prid = $myArray[0]; //153

                            $amt = $myArray[1]; //300

                            if ($prid > 0) {


                                $product_details = $this->db->query("select * from geopos_products WHERE  pid = $prid")->row_array();

                                if ($product_details['parent_id'] != 0) {

                                    $parent_id = $product_details['parent_id']; // 152
                                    if ($product_details['en'] != 0 || $product_details['boy'] != 0) {

                                        $m2 = $product_details['en'] * $product_details['boy'] / 10000; // 3m2

                                        $eklenecek_stok = $amt; //300

                                        $toplam_rulos = $eklenecek_stok / $m2; //100

                                        $old_rulo = $old_product_qty[$key] / $m2; // 7

                                        if (isset($old_rulo)) {

                                            $toplam_rulo = (+$toplam_rulos) - (+$old_rulo[$key]);
                                        }
                                    } else {
                                        $eklenecek_stok = $amt;
                                        $toplam_rulo = 0;
                                    }


                                    if ($warehouses != $old_depo_id) {
                                        $this->depo_silme($old_depo_id, $prid, $amt);


                                        $this->stock_update($amt, $parent_id, $type, $toplam_rulo, $warehouses); //ana ürüne eklenecek 730

                                        $this->stock_update($amt, $prid, $type, $toplam_rulo, $warehouses); //731
                                    } else {
                                        $this->stock_update($amt, $parent_id, $type, $toplam_rulo, $warehouses); //ana ürüne eklenecek 730

                                        $this->stock_update($amt, $prid, $type, $toplam_rulo, $warehouses); //731
                                    }
                                } else {

                                    if ($warehouses != $old_depo_id) {
                                        $this->depo_silme($old_depo_id, $prid, $amt);

                                        $this->stock_update($amt, $prid, $type, $toplam_rulo, $warehouses);
                                    } else {
                                        $this->stock_update($amt, $prid, $type, $toplam_rulo, $warehouses);
                                    }
                                }
                            }
                        }
                    }
                }

                if ($prodindex > 0) {

                    $this->db->insert_batch('geopos_stok_cikis_items', $productlist);
                    if (isset($productlist_proje)) {
                        $this->db->insert_batch('geopos_project_items_gider', $productlist_proje);
                    }
                } else {

                    echo json_encode(array('status' => 'Error', 'message' =>

                    "Lütfen Hataları Kontrol Edin.Eğer sorun yoksa ürün yöneticisine gidin."));
                }

                if ($transok) {

                    $this->db->trans_complete();
                    echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('stok_cikis_add_message') . " <a href='view_stok_fisi?id=$id' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . " </a> "));
                } else {
                    $this->db->trans_rollback();
                }
            }
        } else {
            if ($this->db->insert('geopos_stok_cikis', $data)) {

                $stok_id = $this->db->insert_id();

                foreach ($product_id as $key => $value) {
                    $toplam_rulo = 0;
                    $product_id = $this->input->post('pid');
                    $product_unit = $this->input->post('product_unit');
                    $product_qty = $this->input->post('product_qty');
                    $product_name = $this->input->post('product_name');
                    $product_alert = $this->input->post('alert');
                    $bolum_id = $this->input->post('bolum_id');
                    $bagli_oldugu_asama_id_val = $this->input->post('bagli_oldugu_asama_id_val');
                    $asama_id = $this->input->post('asama_id');

                    $price = 0;
                    $invoice_id = 0;
                    $details = $this->db->query("SELECT * FROM `geopos_invoice_items` WHERE `pid` = $product_id[$key] ORDER BY `geopos_invoice_items`.`price` DESC LIMIT 1");
                    if ($details->num_rows()) {
                        $details = $details->row();
                        $price = $details->price;
                        $invoice_id = $details->tid;
                    }


                    if ($customer_type == 2) // Proje
                    {
                        $data2 = array(
                            'tid' => $stok_id,
                            'pid' => $product_id[$key],
                            'unit' => $product_unit[$key],
                            'product' => $product_name[$key],
                            'qty' => $product_qty[$key],
                            'asama_id' => $asama_id[$key],
                            //'bagli_oldugu_asama_id_val' => $bagli_oldugu_asama_id_val[$key],
                            'bolum_id' => $bolum_id[$key],
                            'depo_id' => $warehouses,
                            'invoice_type_desc' => 'Stok Transfer',
                            'invoice_type_id' => 58,
                        );



                        $subtotal = floatval($price * $product_qty[$key]);
                        $data_prject = array(

                            'tid' => $invoice_id,
                            'pid' => $product_id[$key],
                            'unit' => $product_unit[$key],
                            'product' => $product_name[$key],
                            'qty' => $product_qty[$key],
                            'price' => $price,
                            'subtotal' => $subtotal,
                            'proje_id' => $customer_id,
                            'invoice_type_desc' => 'Stok Transfer',
                            'invoice_type_id' => 58,
                            'asama_id' => $asama_id[$key],
                            'bolum_id' => $bolum_id[$key],
                            'depo_id' => $warehouses,
                        );

                        $productlist_proje[$prodindex] = $data_prject;
                    } else {
                        $data2 = array(
                            'tid' => $stok_id,
                            'pid' => $product_id[$key],
                            'unit' => $product_unit[$key],
                            'product' => $product_name[$key],
                            'qty' => $product_qty[$key],
                            'depo_id' => $warehouses,
                            'invoice_type_desc' => 'Stok Transfer',
                            'invoice_type_id' => 58,
                        );
                    }


                    $productlist[$prodindex] = $data2;

                    $prodindex++;

                    $amt = $product_qty[$key];


                    if ($product_id[$key] > 0) {

                        if ($stok_guncellemes == 1) // Eğer Fişte Stok Güncelleme Seçili İse Stok Güncellenecek
                        {


                            $product_details = $this->db->query("select * from geopos_products WHERE  pid = $product_id[$key]")->row_array();



                            if ($product_details['parent_id'] != 0) {

                                $parent_id = $product_details['parent_id'];
                                if ($product_details['en'] != 0 || $product_details['boy'] != 0) {

                                    $m2 = ($product_details['en'] * $product_details['boy']) / 10000;

                                    $eklenecek_stok = $product_qty[$key];
                                    $toplam_rulo = $eklenecek_stok / $m2;
                                } else {
                                    $eklenecek_stok = $product_qty[$key];
                                    $toplam_rulo = 0;
                                }



                                $this->stock_update($eklenecek_stok, $parent_id, $type, $toplam_rulo, $warehouses, $product_unit[$key]); //ana ürüne eklenecek 730

                                $this->stock_update($amt, $product_id[$key], $type, $toplam_rulo, $warehouses, $product_unit[$key]); //731





                            } else {
                                $this->stock_update($amt, $product_id[$key], $type, $toplam_rulo, $warehouses, $product_unit[$key]);
                            }
                        }
                    }
                }

                if ($prodindex > 0) {

                    $this->db->insert_batch('geopos_stok_cikis_items', $productlist);

                    if (count($productlist_proje) > 0) {
                        $this->db->insert_batch('geopos_project_items_gider', $productlist_proje);
                    }

                    $transok = true;
                } else {

                    echo json_encode(array('status' => 'Error', 'message' =>

                    "Lütfen Hataları Kontrol Edin.Eğer sorun yoksa ürün yöneticisine gidin."));
                }

                if ($transok) {

                    $this->db->trans_complete();
                    echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('stok_cikis_add_message') . " <a href='view_stok_fisi?id=$stok_id' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . " </a> "));
                } else {
                    $this->db->trans_rollback();
                }
            }
        }
    }

    public function view_stok_fisi()
    {



        $id = $this->input->get('id');
        $title = '';

        $data['stok_cikis'] = $this->products->stock_cikis_details($id);

        if ($data['stok_cikis']['type'] == 'Stok Girişi') {
            $title = 'Stok Giriş Fişi ' . $id;
        } else {
            $title = "Stok Çıkış Fişi " . $id;
        }

        $data['type'] = $data['stok_cikis']['type'];




        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = $title;

        $this->load->view('fixed/header', $head);

        $data['products'] = $this->products->stock_cikis_products($id);





        if ($data['stok_cikis']) {
            $data['stok_cikis']['id'] = $id;
            $this->load->view('products/view_stok_cikis_fisi', $data);
        }



        $this->load->view('fixed/footer');
    }


    public function stok_fis_list()
    {

        $head['title'] = "Fişler";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('products/stok_fis_list');

        $this->load->view('fixed/footer');
    }

    public function ajax_stok_fis_list()
    {

        $list = $this->products->get_datatables_stock($this->limited);




        $data = array();



        $no = $this->input->post('start');



        foreach ($list as $invoices) {

            $no++;

            $stok_durumu = "";
            if ($invoices->stok_guncelleme == 0) {
                $stok_durumu = "Stok İşlemi Yapılmamış";
            } else {
                $stok_durumu = "Stoklu Olarak İşlem Sağlanmış";
            }

            $proje_name = '';

            if ($invoices->customer_type == 2) {
                $proje_name = proje_name($invoices->customer_id);
            } else {
                $proje_name = customer_details($invoices->customer_id)['company'];
            }


            $row = array();

            $row[] = $no;
            $row[] = $invoices->fis_no;



            $row[] = dateformat($invoices->fis_date);

            $row[] = $invoices->fis_name;
            $row[] = $proje_name;


            $row[] = fis_tip($invoices->type);
            $row[] = $stok_durumu;



            $row[] = '<a href="' . base_url("products/view_stok_fisi?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><i class="fa fa-download" aria-hidden="true"></i></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-xs delete-object"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';



            $data[] = $row;
        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->products->count_all_stok($this->limited),

            "recordsFiltered" => $this->products->count_filtered_stok($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);
    }

    public function stock_update($amt, $product_id, $invoice_type, $toplam_rulo, $depo, $unit)
    {



        $this->load->model('products_model', 'products');

        $prd_deta = $this->products->poruduct_details($product_id);

        $toplam_agirlik = 0;

        if ($prd_deta['en'] != 0 || $prd_deta['boy'] != 0) {


            if ($prd_deta['metrekare_agirligi'] != 0) {
                $metrekare_agirligi = $prd_deta['metrekare_agirligi'] / 1000; //kg çevrildi
                $toplam_m2 = $amt;
                $toplam_agirlik = $metrekare_agirligi * $toplam_m2;
            } else {
                $toplam_m2 = $amt;
                $toplam_agirlik = 0;
            }
        } else {
            $metrekare_agirligi = $prd_deta['metrekare_agirligi'] / 1000; //kg çevrildi
            $toplam_agirlik = $metrekare_agirligi * $amt;
        }

        $operator = "qty-$amt";

        if ($invoice_type == 1) {
            $operator = "qty-$amt";
            $operator2 = "toplam_agirlik-$toplam_agirlik";

            $depo_arr = array(
                'types' => 0,
                'unit' => $unit,
                'warehouse_id' => $depo,
                'qty' => $amt,
                'product_id' => $product_id,
                'aauth_id' => $this->aauth->get_user()->id,
            );
            $this->db->insert('stock', $depo_arr);
        } else if ($invoice_type == 2) {
            $operator = "qty+$amt";
            $operator2 = "toplam_agirlik+$toplam_agirlik";

            $depo_arr = array(
                'types' => 1,
                'unit' => $unit,
                'warehouse_id' => $depo,
                'qty' => $amt,
                'product_id' => $product_id,
                'aauth_id' => $this->aauth->get_user()->id,
            );
            $this->db->insert('stock', $depo_arr);
        } else if ($invoice_type == 7) {

            $operator = "qty-$amt";
            $operator2 = "toplam_agirlik-$toplam_agirlik";

            $depo_arr = array(
                'types' => 0,
                'unit' => $unit,
                'warehouse_id' => $depo,
                'qty' => $amt,
                'product_id' => $product_id,
                'aauth_id' => $this->aauth->get_user()->id,
            );
            $this->db->insert('stock', $depo_arr);
        } else if ($invoice_type == 8) {
            $operator = "qty+$amt";
            $operator2 = "toplam_agirlik+$toplam_agirlik";

            $depo_arr = array(
                'types' => 1,
                'unit' => $unit,
                'warehouse_id' => $depo,
                'qty' => $amt,
                'product_id' => $product_id,
                'aauth_id' => $this->aauth->get_user()->id,
            );
            $this->db->insert('stock', $depo_arr);
        }






        $this->db->set('toplam_agirlik', "$operator2", FALSE);
        $this->db->where('pid', $product_id);
        $this->db->update('geopos_products');

        $loc = $this->aauth->get_user()->loc;

        //depo tablosunu güncelleme


        $depo_kontrol = $this->products->depo_kontrol_var_yok($product_id, $depo);





        if ($depo_kontrol > 0) {

            $this->db->set('qty', "$operator", FALSE);

            $this->db->where('product_id', $product_id);

            $this->db->where('warehouse_id', $depo);

            $this->db->update('geopos_product_to_warehouse');
        } else {
            //depo tablosuna insert

            $depo_arr = array(
                'product_id' => $product_id,
                'warehouse_id' => $depo,
                'qty' => $amt,
                'loc' => $loc
            );
            $this->db->insert('geopos_product_to_warehouse', $depo_arr);
        }


        //depo tablosunu güncelleme


    }


    public function muhasebe()
    {
        $uretim_id = $this->input->post('uretim_id');
        $products = $this->products->uretim_to_products($uretim_id);






        $s_type = 'Stok Çıkışı';
        $stok_id = 0;
        $this->db->trans_start();
        $type = 1;
        $st_c = 0;
        $transok = true;
        $prodindex = 0;
        $productlist = array();

        $uretim_produt_id = product_id_uretim($uretim_id);
        $uretim_produt_qty = product_id_uretim_qty($uretim_id);
        $maliyet = product_id_uretim_maliyet($uretim_id);

        $birim_maliyet = floatval($maliyet) / $uretim_produt_qty;

        $operator = "qty+$uretim_produt_qty";

        $this->db->set('qty', "$operator", FALSE);

        $this->db->set('fproduct_price', $birim_maliyet, FALSE);

        $this->db->where('pid', $uretim_produt_id);

        $this->db->update('geopos_products');




        $data = array(
            'fis_no' => $uretim_id . ' Nolu Üretim',
            'fis_name' => 'Depodan Üretime Stok Transferi',
            'fis_note' => 'Depodan Üretime Stok Transferi',
            'user_id' => $this->aauth->get_user()->id,
            'type' => $s_type,
            'uretim_id' => $uretim_id,
            'loc' => $this->aauth->get_user()->loc
        );


        if ($this->db->insert('geopos_stok_cikis', $data)) {
            $stok_id = $this->db->insert_id();

            $this->db->query("UPDATE `geopos_uretim` SET `muhasebe_durumu`=1 WHERE `id`=$uretim_id");


            foreach ($products as $prd) {
                $data2 = array(
                    'stok_fis_id' => $stok_id,
                    'product_id' => $prd['pid'],
                    'product_unit' => product_unit($prd['pid']),
                    'product_name' => $prd['name'],
                    'product_qty' => $prd['toplam_tuketilen']
                );

                $productlist[$prodindex] = $data2;
                $prodindex++;

                $amt = $prd['toplam_tuketilen'];


                if ($prd['pid'] > 0) {




                    $alert = stok_ogren($prd['pid']);


                    //Stok Kontrolü

                    if ($type == '1') {
                        if (($alert - $amt) < 0 and $st_c == 0) {

                            echo json_encode(array(
                                'status' => 'Error',
                                'message' => 'Ürün Adı - ' . $prd['name'] . '- Düşük Miktar. Mevcut Stok  ' . $alert . ' Çıkış Yapamazsınız'
                            ));

                            $st_c = 1;
                            $transok = false;
                        }
                    }


                    $depo_id = $this->db->query("SELECT * FROM geopos_uretim WHERE id=$uretim_id")->row()->depo_id;

                    $this->stock_update($amt, $prd['pid'], $type, 0, $depo_id);
                }
            }
        }

        if ($prodindex > 0) {

            $this->db->insert_batch('geopos_stok_cikis_items', $productlist);
        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

            "Lütfen Hataları Kontrol Edin.Eğer sorun yoksa ürün yöneticisine gidin."));
        }

        if ($transok) {


            $this->db->trans_complete();
            echo json_encode(array(
                'status' => 'Başarılı',
                'stok_id' => $stok_id,
                'message' => $this->lang->line('stok_cikis_add_message')
            ));
        } else {
            $this->db->trans_rollback();
        }
    }


    public function sc_print_fis()
    {
        $id = $this->input->get('id');
        $data['id'] = $id;
        $data['invoice'] = $this->products->stock_cikis_details($id);
        $data['customer'] = $this->products->stock_customer($data['invoice']['customer_id']);
        $data['pers'] = personel_details_full($data['invoice']['sorumlu_pers_id']);
        $data['products'] = $this->products->stock_cikis_products($id);
        ini_set('memory_limit', '64M');

        $html = $this->load->view('products/view-print-' . LTR, $data, true);
        $header = $this->load->view('products/header-print-' . LTR, $data, true);
        $footer = $this->load->view('products/footer-print-stok-' . LTR, $data, true);

        //PDF Rendering

        $this->load->library('pdf');



        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);
        $pdf->SetHTMLFooter($footer);

        $pdf->AddPage(
            'P', // L - landscape, P - portrait
            '',
            '',
            '',
            '',
            '', // margin_left
            '', // margin right
            98, // margin top
            '72', // margin bottom
            5,
            2,
            0,
            0, // margin header
            'auto'
        ); // margin footer


        $pdf->WriteHTML($html);
        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'Stok_Fisi' . 'Makbuz' . '_' . $data['invoice']['id']);

        if ($this->input->get('d')) {



            $pdf->Output($file_name . '.pdf', 'D');
        } else {

            $pdf->Output($file_name . '.pdf', 'I');
        }
    }

    public function view_bilgi()
    {
        $pid = $this->input->post('id');
        $this->load->model("Products_model");
        $data = $this->Products_model->view_bilgi();
        $this->load->view('products/view-bilgi', $data);
    }
    public function print_list_bilgi()
    {

        $this->load->model("Products_model");
        $data = $this->Products_model->print_bilgi();

        $data['id'] = $data;


        ini_set('memory_limit', '64M');

        if ($data['product']['product_name'] == 'cgst') {

            $html = $this->load->view('products/view-print-gstin', $data, true);
        } else {

            $html = $this->load->view('products/view-bilgi-print-' . LTR, $data, true);
        }

        $header = $this->load->view('products/header-bilgi-print-' . LTR, $data, true);

        //PDF Rendering

        $this->load->library('pdf');





        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['product']['product_name'] . '</div>');



        $pdf->WriteHTML($html);



        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'Product__' . $data['product']['children'] . '_' . $data['product']['pid']);

        if ($this->input->get('d')) {



            $pdf->Output($file_name . '.pdf', 'D');
        } else {

            $pdf->Output($file_name . '.pdf', 'I');
        }
    }

    public function depo_silme($depo_id, $product_id, $qty)
    {
        $operator = "qty-$qty";

        $this->db->set('qty', "$operator", FALSE);

        $this->db->where('product_id', $product_id);

        $this->db->where('warehouse_id', $depo_id);

        $this->db->update('geopos_product_to_warehouse');
    }


    public function sales_product()
    {
        $product_id = $this->input->get('id');

        $product_name = product_name($product_id);

        $head['title'] = $product_name . " Satış Raporu";
        $data['title'] = $product_name . " Satış Raporu";
        $data['product_id'] = $product_id;

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('products/sales_product', $data);

        $this->load->view('fixed/footer');
    }

    public function custom_label()
    {
        if ($this->input->post()) {
            $width = $this->input->post('width');
            $height = $this->input->post('height');
            $padding = $this->input->post('padding');
            $store_name = $this->input->post('store_name');
            $warehouse_name = $this->input->post('warehouse_name');
            $product_price = $this->input->post('product_price');
            $product_code = $this->input->post('product_code');
            $bar_height = $this->input->post('bar_height');
            $total_rows = $this->input->post('total_rows');
            $items_per_rows = $this->input->post('items_per_row');
            $products = array();


            foreach ($this->input->post('products_l') as $row) {
                $this->db->select('geopos_products.product_name,geopos_products.product_price,geopos_products.product_code,geopos_products.barcode,geopos_products.expiry,geopos_warehouse.title,geopos_warehouse.loc');
                $this->db->from('geopos_products');
                $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse', 'left');

                if ($this->aauth->get_user()->loc) {
                    $this->db->group_start();
                    $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);

                    if (BDATA) $this->db->or_where('geopos_warehouse.loc', 0);
                    $this->db->group_end();
                } elseif (!BDATA) {
                    $this->db->where('geopos_warehouse.loc', 0);
                }

                //  $this->db->where('warehouse', $warehouse);
                $this->db->where('geopos_products.pid', $row);
                $query = $this->db->get();
                $resultz = $query->row_array();

                $products[] = $resultz;
            }


            $loc = location($resultz['loc']);

            $design = array('store' => $loc['cname'], 'warehouse' => $resultz['title'], 'width' => $width, 'height' => $height, 'padding' => $padding, 'store_name' => $store_name, 'warehouse_name' => $warehouse_name, 'product_price' => $product_price, 'product_code' => $product_code, 'bar_height' => $bar_height, 'total_rows' => $total_rows, 'items_per_row' => $items_per_rows);

            $html = $this->load->view('barcode/custom_label', array('products' => $products, 'style' => $design), true);
            ini_set('memory_limit', '64M');

            //PDF Rendering
            $this->load->library('pdf');
            $pdf = $this->pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($resultz['product_name'] . '_label.pdf', 'I');
        } else {
            $data['cat'] = $this->categories_model->category_list();
            $data['warehouse'] = $this->categories_model->warehouse_list();
            $head['title'] = "Barkod Tasarımı";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/custom_label', $data);
            $this->load->view('fixed/footer');
        }
    }
}
