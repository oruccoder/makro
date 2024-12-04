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



class Products_model extends CI_Model

{



    var $table = 'geopos_products';

    var $column_order = array(null, 'geopos_products.product_name', 'geopos_products.qty','geopos_products.rezerv_qty', 'geopos_products.product_code','geopos_products.kalite','geopos_products.uretim_yeri', 'geopos_product_cat.title', 'geopos_products.product_price', null); //set column field database for datatable orderable
    var $column_order_stok = array(null, 'geopos_stok_cikis.fis_no', 'geopos_stok_cikis.fis_date', 'geopos_stok_cikis.fis_name',NULL); //set column field database for datatable orderable

    var $column_search = array('geopos_products.product_name', 'geopos_products.product_code','geopos_products.qty'); //set column field database for datatable searchable

    var $order = array('geopos_products.pid' => 'desc'); // default order
    var $order_stok = array('geopos_stok_cikis.id' => 'desc'); // default order

    var $column_stock = array('fis_no', 'fis_name', 'fis_date', 'type');

    var $column_search_stock = array('id', 'fis_no', 'fis_date','fis_name');



    public function __construct()

    {

        parent::__construct();

        $this->load->database();

    }



    private function _get_datatables_query($id = '', $w = '')

    {
        $table='geopos_product_to_warehouse';

        /*if ($this->aauth->get_user()->roleid==14) {

           $table='geopos_product_to_warehouse_r';

        }*/
        $this->db->select('*');
        $this->db->from($this->table);

        $types = array(6,7);

        $this->db->where_not_in('geopos_products.product_type',$types);
        //$this->db->where('geopos_products.project_status', 0);
        if($id!='')
        {
            $this->db->where($table.'.warehouse_id',$id);
        }






        $this->db->join('geopos_product_cat', 'geopos_product_cat.id = geopos_products.pcat');
        //$this->db->join('geopos_product_to_warehouse','geopos_product_to_warehouse.product_id = geopos_products.pid','LEFT');






        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_products.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $i = 0;



        foreach ($this->column_search as $item) // loop column

        {

            $search = $this->input->post('search');

            $value = $search['value'];

            if ($value) // if datatable send POST for search

            {



                if ($i === 0) // first loop

                {

                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, $value);

                } else {

                    $this->db->or_like($item, $value);

                }



                if (count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) // here order processing

        {

            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

        $this->db->group_by('geopos_products.pid');




    }



    function get_datatables($id = '', $w = '')

    {
        $this->_get_datatables_query($id, $w);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }


    function get_datatables_stock($opt = '')
    {

        $this->_get_datatables_query_stock($opt);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_stok_cikis.loc', $this->aauth->get_user()->loc);

        }

        return $query->result();
    }

    private function _get_datatables_query_stock($opt = '')

    {


        $this->db->select('geopos_stok_cikis.*');

        $this->db->from('geopos_stok_cikis');







        $i = 0;



        foreach ($this->column_search_stock as $item) // loop column

        {

            if ($_POST['search']['value']) // if datatable send POST for search

            {



                if ($i === 0) // first loop

                {

                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, $_POST['search']['value']);

                } else {

                    $this->db->or_like($item, $_POST['search']['value']);

                }



                if (count($this->column_search_stock) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order_stok[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->order_stok)) {

            $order = $this->order_stok;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }




    function count_filtered($id, $w = '')

    {

        if ($id > 0) {

            $this->_get_datatables_query($id, $w);

        } else {

            $this->_get_datatables_query();

        }



        $query = $this->db->get();

        return $query->num_rows();

    }



    public function count_all()

    {

        $this->db->from($this->table);

        if ($this->aauth->get_user()->loc) {

            $this->db->join('geopos_warehouse', 'geopos_warehouse.id = geopos_products.warehouse');

            $this->db->where('geopos_warehouse.loc', $this->aauth->get_user()->loc);

            $this->db->or_where('geopos_warehouse.loc', 0);

        }

        return $this->db->count_all_results();

    }


    function count_filtered_stok($id, $w = '')

    {

        if ($id > 0) {

            $this->_get_datatables_query_stock($id, $w);

        } else {

            $this->_get_datatables_query_stock();

        }



        $query = $this->db->get();

        return $query->num_rows();

    }



    public function count_all_stok()

    {

        $this->db->from('geopos_stok_cikis');

        if ($this->aauth->get_user()->loc) {



            $this->db->where('geopos_stok_cikis.loc', $this->aauth->get_user()->loc);

            $this->db->or_where('geopos_stok_cikis.loc', 0);

        }

        return $this->db->count_all_results();

    }


    public function addnew($catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate,
                           $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode,$wdate,
                           $product_type,$en,$boy,$g_urun_adi,$g_urun_code,$v_alert,$g_stock,$metrekare_agirligi,$kalite,$uretim_yeri,$iscilik_price,$paketleme_tipi,$paketleme_miktari,$raf_no)

    {


        $toplam_agirlik_stoklu=0;






        $datetime1 = new DateTime(date('Y-m-d'));



        $datetime2 = new DateTime($wdate);



        $difference = $datetime1->diff($datetime2);

        if(!$difference->d>0) { $wdate=null; }





        $depo_id=firmaya_gore_depo_ogren($this->aauth->get_user()->loc);

        if (!is_numeric($barcode)) {
            $barcode = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);

        }
        $data = array(

            'pcat' => $catid,

            'warehouse' => $warehouse,

            'product_name' => $product_name,

            'product_code' => $product_code,

            'product_price' => $product_price,

            'fproduct_price' => $factoryprice,

            'taxrate' => $taxrate,

            'disrate' => $disrate,

            'qty' => $product_qty,

            'product_des' => $product_desc,

            'alert' => $product_qty_alert,

            'unit' => $unit,

            'image' => $image,

            'barcode' => $barcode,

            'expiry' => $wdate,
            'product_type' => $product_type,

            'metrekare_agirligi' => $metrekare_agirligi,
            'toplam_agirlik' => $toplam_agirlik_stoklu,
            'uretim_yeri' => $uretim_yeri,
            'kalite' => $kalite,
            'iscilik_price' => $iscilik_price,
            'paketleme_tipi'=>$paketleme_tipi,
            'raf_no' =>$raf_no


        );

        $this->db->trans_start();

        if ($this->db->insert('geopos_products', $data)) {

            $pid = $this->db->insert_id();

            kont_kayit(1,$pid);







            if($product_type==6)
            {
                if (isset($en)) {

                    foreach ($en as $key => $value)
                    {
                        if ($en[$key] && $en[$key]>0)
                        {
                            $barcode = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);

                            $data['metrekare_agirligi']=$metrekare_agirligi;

                            $data['toplam_agirlik']=0;

                            $data['parent_id']=$pid;

                            $data['metrekare_agirligi']= $metrekare_agirligi;

                            $data['product_name'] = $g_urun_adi[$key];

                            $data['product_code'] = $g_urun_code[$key];
                            $data['paketleme_miktari'] = $paketleme_miktari[$key];

                            $data['en'] = $en[$key];

                            $data['boy'] = $boy[$key];

                            $data['qty'] = $g_stock[$key];

                            $data['alert'] = $v_alert[$key];

                            $data['merge'] = 0;

                            $data['pcat'] = $catid;

                            $data['product_price']=$product_price;

                            $data['fproduct_price'] = $factoryprice;

                            $data['taxrate'] = $taxrate;

                            $data['disrate'] = $disrate;

                            $data['product_des'] = $product_desc;

                            $data['unit'] = $unit; //Rulo için geçerli

                            $data['image'] = $image;

                            $data['barcode'] = $barcode;
                            $data['uretim_yeri'] = $uretim_yeri;
                            $data['kalite'] = $kalite;
                            $data['iscilik_price'] = $iscilik_price;
                            $data['paketleme_tipi'] = $paketleme_tipi;
                            $data['raf_no'] =$raf_no;


                            $data['product_type'] = 1; //stoklu Ürün

                            $this->db->insert('geopos_products', $data);

                            $product_id = $this->db->insert_id();

                            //depo tablosuna insert

                            $depo_arr=array(
                                'product_id'=>$product_id,
                                'warehouse_id'=>$depo_id,
                                'qty'=>0,
                                'loc'=>$this->aauth->get_user()->loc
                            );
                            $this->db->insert('geopos_product_to_warehouse', $depo_arr);

                            //depo tablosuna insert
                        }
                    }
                }
            }


            $operator= "deger+1";
            $this->db->set('deger', "$operator", FALSE);
            $this->db->where('tip', 21);
            $this->db->update('numaric');

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('ADDED') . "  <a href='add' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a>"));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }

        $this->db->trans_complete();







    }



    public function edit($pid, $catid, $warehouse, $product_name, $product_price,
                         $factoryprice, $taxrate, $disrate, $product_qty, $product_qty_alert, $product_desc, $image, $unit, $barcode,$product_type
        ,$en,$boy,$g_urun_adi,$g_stock,$g_urun_code,$v_alert,$g_pid,$metrekare_agirligi,$kalite,$uretim_yeri,$iscilik_price,$paketleme_tipi,$paketleme_miktari,$raf_no)

    {

        $toplam_agirlik=0;
        $product_qty=0;
        $toplam_agirlik_stoklu=0;

        $data = array(

            'pcat' => $catid,

            'warehouse' => $warehouse,

            'product_name' => $product_name,


            'product_price' => $product_price,

            'fproduct_price' => $factoryprice,

            'taxrate' => $taxrate,

            'disrate' => $disrate,

            'product_des' => $product_desc,

            'alert' => $product_qty_alert,

            'unit' => $unit,

            'image' => $image,

            'barcode' => $barcode,

            'product_type' => $product_type,

            'metrekare_agirligi' => $metrekare_agirligi,
            'toplam_agirlik' => $toplam_agirlik_stoklu,
            'kalite' => $kalite,
            'uretim_yeri' => $uretim_yeri,
            'iscilik_price' => $iscilik_price,
            'paketleme_tipi' => $paketleme_tipi,
            'raf_no' => $raf_no


        );





        $this->db->set($data);

        $this->db->where('pid', $pid);





        if ($this->db->update('geopos_products')) {

            kont_kayit(2,$pid);



            if ($g_pid) {



                foreach ($g_pid as $key => $value) {

                    if ($g_pid[$key] && $g_pid[$key]>0) {

                        $product_details = $this->db->query("select * from geopos_products WHERE  pid = $g_pid[$key]")->row_array();


                        if ($product_details) {




                            $barcode2 = $product_details['barcode'];
                            $data2 = array(
                                'product_name' => $g_urun_adi[$key],
                                'product_code' => $g_urun_code[$key],
                                'paketleme_miktari' => $paketleme_miktari[$key],
                                'en' => $en[$key],
                                'boy' => $boy[$key],
                                'alert' => $v_alert[$key],
                                'merge' => 0,
                                'pcat' => $catid,
                                'product_price' => $product_price,
                                'fproduct_price' => $factoryprice,
                                'taxrate' => $taxrate,
                                'disrate' => $disrate,
                                'product_des' => $product_desc,
                                'unit' => $unit, //Rulo için geçerli,
                                'image' => $image,
                                'barcode' => $barcode2,
                                'metrekare_agirligi' => $metrekare_agirligi,
                                'toplam_agirlik' => $toplam_agirlik,
                                'iscilik_price' => $iscilik_price,
                                'paketleme_tipi' => $paketleme_tipi,
                                'product_type'=>1,
                                'raf_no'=>$raf_no
                            );


                            $this->db->set($data2);

                            $this->db->where('pid', $g_pid[$key]);
                            $this->db->update('geopos_products');

                        }

                    }
                    else
                    {
                        $barcode = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);

                        $data['parent_id']=$pid;

                        $data['product_name'] = $g_urun_adi[$key];

                        $data['product_code'] = $g_urun_code[$key];
                        $data['paketleme_miktari'] = $paketleme_miktari[$key];

                        $data['en'] = $en[$key];

                        $data['boy'] = $boy[$key];


                        $data['alert'] = $v_alert[$key];

                        $data['merge'] = 0;

                        $data['pcat'] = $catid;

                        $data['product_price']=$product_price;

                        $data['fproduct_price'] = $factoryprice;

                        $data['taxrate'] = $taxrate;

                        $data['disrate'] = $disrate;

                        $data['product_des'] = $product_desc;

                        $data['unit'] = $unit;

                        $data['image'] = $image;

                        $data['barcode'] = $barcode;
                        $data['metrekare_agirligi'] = $metrekare_agirligi;
                        $data['toplam_agirlik'] = $toplam_agirlik;
                        $data['kalite'] = $kalite;
                        $data['uretim_yeri'] = $uretim_yeri;
                        $data['iscilik_price'] = $iscilik_price;
                        $data['paketleme_tipi'] = $paketleme_tipi;

                        $data['product_type'] = 1;
                        $data['raf_no'] = $raf_no;


                        $this->db->insert('geopos_products', $data);
                    }



                }



            }

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED'). " <a href='index' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('Manage Products') . " </a> "));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }







    }



    public function prd_stats()

    {



        $whr = '';

        if ($this->aauth->get_user()->loc) {

            $whr = ' LEFT JOIN  geopos_warehouse on geopos_warehouse.id = geopos_products.warehouse WHERE geopos_warehouse.loc=0 OR geopos_warehouse.loc=' . $this->aauth->get_user()->loc;

        }

        $query = $this->db->query("SELECT

COUNT(IF( geopos_products.qty > 0, geopos_products.qty, NULL)) AS instock,

COUNT(IF( geopos_products.qty <= 0, geopos_products.qty, NULL)) AS outofstock,

COUNT(geopos_products.qty) AS total

FROM geopos_products $whr");

        //   return $query->result_array();



        echo json_encode($query->result_array());



    }



    public function products_list($id,$term='')

    {

        $this->db->select('geopos_products.product_price,geopos_products.pid,geopos_products.product_name,
geopos_products.product_price,geopos_products.product_code,geopos_products.taxrate,geopos_products.disrate,
geopos_products.product_des,geopos_product_to_warehouse.qty,geopos_products.unit ');

        $this->db->from('geopos_products');

        $this->db->where('geopos_product_to_warehouse.warehouse_id', $id);
        $this->db->where_not_in('geopos_products.product_type', 6);

        $this->db->join('geopos_product_to_warehouse', 'geopos_product_to_warehouse.product_id = geopos_products.pid');

        if($term) {

            $this->db->where("geopos_products.product_name LIKE '%$term%'");

            $this->db->or_where("geopos_products.product_code LIKE '$term%'");

        }

        $query = $this->db->get();

        return $query->result_array();



    }





    public function units()

    {

        $this->db->select('*');

        $this->db->from('geopos_units');

        $this->db->where('type', 0);

        $query = $this->db->get();

        return $query->result_array();



    }
    public function paketleme_tipi()

    {

        $this->db->select('*');

        $this->db->from('geopos_paketleme_tipi');

        $query = $this->db->get();

        return $query->result_array();



    }

    public function prd_ware($id)

    {

        $query = $this->db->query("SELECT punits.id,punits.name,punits.code FROM geopos_products AS p LEFT JOIN geopos_units AS punits ON p.unit=punits.code WHERE p.pid='$id' ");

        return $query->row_array();

    }



    public function transfer($from_warehouse, $products_l, $to_warehouse, $qty)

    {


        $qtyArray = explode(',', $qty);
        $i = 0;
        $k = 0;
        $j = 0;

        foreach ($products_l as $product_id) {
            $depo_kontrol = $this->depo_kontrol($product_id,$to_warehouse);  //Giren Depo
            $depo_kontrol_qty = $this->depo_kontrol($product_id,$from_warehouse);  //Çıkan depo

            $loc=$this->aauth->get_user()->loc;

            if($qtyArray[$i] < $depo_kontrol_qty['qty'])
            {
                $j++;
                $operator= "qty-$qtyArray[$i]";
                $operator2= "qty+$qtyArray[$i]";

                //seçilen depodan ürünü çıkaracak
                $this->db->set('qty', "$operator", FALSE);

                $this->db->set('loc', "$loc", FALSE);

                $this->db->where('product_id', $product_id);

                $this->db->where('warehouse_id', $from_warehouse);

                $this->db->update('geopos_product_to_warehouse');

                //Projenin giderinden çıkıyor
                $this->db->set('qty', "$operator", FALSE);

                $this->db->where('pid', $product_id);

                $this->db->where('depo_id', $from_warehouse);

                $this->db->update('geopos_project_items_gider');


                if(isset($depo_kontrol))
                {

                    //seçilen depoya  ürünü transfer edecek
                    $this->db->set('qty', "$operator2", FALSE);

                    $this->db->set('loc', "$loc", FALSE);

                    $this->db->where('product_id', $product_id);

                    $this->db->where('warehouse_id', $to_warehouse);

                    $this->db->update('geopos_product_to_warehouse');

                    //Projenin giderine ekleniyor

                    $this->db->set('qty', "$operator2", FALSE);

                    $this->db->where('pid', $product_id);

                    $this->db->where('depo_id', $to_warehouse);

                    $this->db->update('geopos_project_items_gider');



                }
                else
                {
                    //depo tablosuna insert

                    $depo_arr=array(
                        'product_id'=>$product_id,
                        'warehouse_id'=>$to_warehouse,
                        'qty'=>$qtyArray[$i],
                        'loc'=>$loc
                    );
                    $this->db->insert('geopos_product_to_warehouse', $depo_arr);
                }

                $i++;


            }
            else
            {
                $k++;
            }




        }

        if($j>0)
        {
            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));
        }
        else if($k>0)
        {
            echo json_encode(array('status' => 'ERROR', 'message' =>

                'Yeterli Miktarda Stok Yok'));
        }









    }


    public function stock_update($amt,$product_id,$invoice_type,$toplam_rulo,$depo)
    {

        $prd_deta = $this->db->query("select * from geopos_products WHERE  pid = $product_id")->row_array();

        $toplam_agirlik=0;

        if($prd_deta['en']!=0 || $prd_deta['boy']!=0 )
        {

            $en = $prd_deta['en']; //200
            $boy = $prd_deta['boy']; //20000
            $metrekare_agirligi = $prd_deta['metrekare_agirligi']/1000; //kg çevrildi
            $toplam_m2=$amt;
            $toplam_agirlik=$metrekare_agirligi*$toplam_m2;
        }


        else
        {
            $metrekare_agirligi = $prd_deta['metrekare_agirligi']/1000; //kg çevrildi
            $toplam_agirlik=$metrekare_agirligi*$amt;
        }

        $operator1="qty-$amt";
        $operator2="toplam_agirlik-$toplam_agirlik";
        $operator3= "toplam_rulo-$toplam_rulo";


        if($invoice_type==1)
        {

            $operator1= "qty-$amt";
            $operator2= "toplam_agirlik-$toplam_agirlik";
            $operator3= "toplam_rulo-$toplam_rulo";

        }
        else if($invoice_type==2)
        {
            $operator1= "qty+$amt";
            $operator2= "toplam_agirlik+$toplam_agirlik";
            $operator3= "toplam_rulo+$toplam_rulo";
        }




        $this->db->set('qty', "$operator1", FALSE);
        $this->db->set('toplam_agirlik', "$operator2", FALSE);
        $this->db->set('toplam_rulo', "$operator3", FALSE);

        $this->db->where('pid', $product_id);
        $this->db->update('geopos_products');



        $this->db->set('qty', "$operator1", FALSE);

        $this->db->set('loc', "5", FALSE);

        $this->db->where('product_id', $product_id);

        $this->db->where('warehouse_id', $depo);

        $this->db->update('geopos_product_to_warehouse');
    }




    public function meta_delete($name)

    {

        if (@unlink(FCPATH . 'userfiles/product/' . $name)) {

            return true;

        }

    }



    public function valid_warehouse($warehouse)

    {

        $this->db->select('id,loc');

        $this->db->from('geopos_warehouse');

        $this->db->where('id', $warehouse);

        $query = $this->db->get();

        $row = $query->row_array();

        return $row;

    }

    public function new_product($product_name, $product_code, $product_type,$unit)
    {
        $barcode = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);

        $loc=$this->aauth->get_user()->loc;



        $query=$this->db->query('Select * From geopos_warehouse where loc='.$loc)->row_array();

        $data = array(


            'product_name' => $product_name,

            'product_code' => $product_code,

            'warehouse' => $query['id'],

            'barcode' => $barcode,

            'unit' => $unit,

            'merge' =>0,

            'product_type' => $product_type

        );



        //$this->db->trans_start();

        if ($this->db->insert('geopos_products', $data)) {

            $pid = $this->db->insert_id();

            return $pid;
        }

    }



    public function warehouses()

    {

        $this->db->select('*');

        $this->db->from('geopos_warehouse');

        if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

            $this->db->or_where('loc', 0);

        }



        $query = $this->db->get();



        return $query->result_array();



    }

    public function stock_cikis_details($id)
    {
        $this->db->select('*');

        $this->db->from('geopos_stok_cikis');

        $this->db->where('id', $id);

        $query = $this->db->get();

        $row = $query->row_array();

        return $row;
    }

    public function employees()

    {

        $this->db->select('geopos_employees.*');

        $this->db->from('geopos_employees');

        $query = $this->db->get();

        return $query->result_array();

    }

    public function stock_customer($id)
    {
        $this->db->select('*');

        $this->db->from('geopos_customers');

        $this->db->where('id', $id);

        $query = $this->db->get();

        $row = $query->row_array();

        return $row;
    }

    public function stock_cikis_products($id)
    {
        $this->db->select('*');

        $this->db->from('geopos_stok_cikis_items');

        $this->db->where('tid', $id);

        $query = $this->db->get();

        return  $query->result();
    }

    public function stok_delete($id, $eid = '')

    {

        $this->db->trans_start();

        $this->db->select('*');

        $this->db->from('geopos_stok_cikis');

        $this->db->where('id', $id);

        $query = $this->db->get();

        $result = $query->row_array();

        $stok_fis_type=$result['type'];

        $depo=$result['warehouse_id'];

        if(isset($result['uretim_id']))
        {
            $this->db->set('muhasebe_durumu', "0", FALSE);

            $this->db->where('id', $result['uretim_id']);

            $this->db->update('geopos_uretim');
        }

        if ($this->aauth->get_user()->loc) {

            if ($eid) {



                $res = $this->db->delete('geopos_stok_cikis', array('id' => $id, 'user_id' => $eid, 'loc' => $this->aauth->get_user()->loc));





            } else {

                $res = $this->db->delete('geopos_stok_cikis', array('id' => $id, 'loc' => $this->aauth->get_user()->loc));

            }

        } else {

            if ($eid) {



                $res = $this->db->delete('geopos_stok_cikis', array('id' => $id, 'user_id' => $eid));





            } else {

                $res = $this->db->delete('geopos_stok_cikis', array('id' => $id));

            }

        }



        $affect=$this->db->affected_rows();



        if ($res) {


            $this->db->select('product_id,product_qty');

            $this->db->from('geopos_stok_cikis_items');

            $this->db->where('stok_fis_id', $id);

            $query = $this->db->get();

            $prevresult = $query->result_array();
            $toplam_rulo=0;

            if($stok_fis_type==1)
            {
                $invoice_type_new=2;
            }
            else
            {
                $invoice_type_new=1;
            }

            foreach ($prevresult as $prd) {




                $prdid=$prd['product_id'];
                $amt = $prd['product_qty'];

                $product_details = $this->db->query("select * from geopos_products WHERE  pid =$prdid ")->row_array();

                if ($product_details['parent_id'] != 0) {

                    $parent_id = $product_details['parent_id'];
                    if ($product_details['en'] != 0 || $product_details['boy'] != 0) {

                        $m2 = $product_details['en'] * $product_details['boy'] / 10000;

                        $eklenecek_stok=$amt;
                        $toplam_rulo=$eklenecek_stok/$m2;
                    }
                    else
                    {
                        $toplam_rulo=0;
                        $eklenecek_stok = $amt;
                    }




                    $this->stock_update($eklenecek_stok,$parent_id, $invoice_type_new,$toplam_rulo,$depo); //ana ürüne eklenecek 730

                    $this->stock_update($amt,$prdid, $invoice_type_new,$toplam_rulo,$depo); //731


                } else {
                    $this->stock_update($amt,$prdid, $invoice_type_new,$toplam_rulo,$depo); //731

                }

            }













            if($affect)  $this->db->delete('geopos_stok_cikis_items', array('stok_fis_id' => $id));


            if ($this->db->trans_complete()) {

                return true;

            } else {

                return false;

            }

        }

    }

    public  function uretim_to_products($uretim_id)
    {
        $this->db->select('*');

        $this->db->from('geopos_uretim_item');

        $this->db->where('type', 'uretim');
        $this->db->where('uretim_id', $uretim_id);

        $query = $this->db->get();

        return $query->result_array();

    }

    public function poruduct_details($id)
    {
        $this->db->select('*');

        $this->db->from('geopos_products');

        $this->db->where('pid', $id);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function depo_kontrol($id,$depo_id)
    {
        $this->db->select('*');

        $this->db->from('geopos_product_to_warehouse');

        $this->db->where('product_id', $id);
        $this->db->where('warehouse_id', $depo_id);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function depo_kontrol_var_yok($id,$depo_id)
    {
        $this->db->select('*');

        $this->db->from('geopos_product_to_warehouse');

        $this->db->where('product_id', $id);
        $this->db->where('warehouse_id', $depo_id);

        $query = $this->db->get();

        return $query->num_rows();
    }



    public function cart_details($user_id)
    {
        $this->db->select('*');

        $this->db->from('geopos_cart');

        $this->db->where('user_id', $user_id);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function cart_add($product_id,$user_id,$miktar)
    {
        $this->db->select('*');

        $this->db->from('geopos_cart');

        $this->db->where('product_id', $product_id);
        $this->db->where('user_id', $user_id);

        $query = $this->db->get();

        $prd_kont=$query->row_array();



        if(!$prd_kont)
        {
            $product_details = $this->poruduct_details($product_id);

            $kdv=isset($product_details['tax_rate'])?$product_details['tax_rate']:18;

            $total_discount=floatval($product_details['product_price'])*(1+($product_details['disrate']/100))-floatval($product_details['product_price']);

            $indirimli_tutar=floatval($product_details['product_price'])-$total_discount;

            $total_tax=floatval($indirimli_tutar)*(1+($kdv/100))-floatval($indirimli_tutar);

            $m2=$product_details['en']*$product_details['boy']/10000;


            $data = array(


                'user_id' => $user_id,

                'product_id' => $product_id,

                'discount' => $product_details['disrate'],

                'product_name' => $product_details['product_name'],

                'product_model' => $product_details['product_code'],

                'miktar' => $miktar*$m2,

                'totaldiscount' => $total_discount,

                'totaltax' => $total_tax,

                'unit' =>$product_details['unit'],

                'kdv' =>$kdv,

                'price' => $product_details['product_price']

            );

            $this->db->insert('geopos_cart', $data);
        }

        else {


            $item_total_price=$miktar*$prd_kont['price'];
            $product_details = $this->poruduct_details($product_id);

            $m2=$product_details['en']*$product_details['boy']/10000;

            $total_discount=$item_total_price*(1+($prd_kont['discount']/100))-$item_total_price;
            $indirimli_tutar=$item_total_price-$total_discount;
            $total_tax=$indirimli_tutar*(1+($prd_kont['kdv']/100))-$indirimli_tutar;


            $this->db->set(array(
                'miktar'=>$miktar*$m2,
                'totaldiscount'=>$total_discount,
                'totaltax'=>$total_tax
            ));
            $this->db->where(array('product_id' => $product_id, 'user_id' => $user_id));
            $this->db->update('geopos_cart');


        }


        $query = $this->db->query("SELECT COUNT(id) as count FROM `geopos_cart` WHERE user_id=$user_id");
        return $query->row_array();

    }

    public function print_list($pids)
    {

        $dd=array();

        $dd=explode(',',$pids);
        $result=array();
        $result_parrent=array();

        foreach ($dd as $value)
        {
            $pid = $value;


            $query=$this->db->query("Select * from geopos_products where pid=$pid")->row(); //ana ürün



            if($query->product_type==6) // Gruplu Ürün İse
            {


                $query_parent=$this->db->query("Select * from geopos_products where parent_id=$pid")->result();



                foreach ($query_parent as $qur_par)
                {
                    $id=$qur_par->pid;


                    if(isset($id))
                    {
                        $parent_urunler = $this->db->query("Select * from geopos_products where pid=$id")->row();

                        $result_parrent[]=$parent_urunler;
                    }




                }
            }
            else
            {
                $result[]=$query;
            }




        }



        return array_merge($result,$result_parrent);



    }



    public function print_bilgi() {


        $pid = $this->input->get('id');
        $this->db->select('geopos_products.* , geopos_product_type.name AS type, geopos_product_cat.title AS category, geopos_warehouse.title AS warehouse,geopos_paketleme_tipi.name AS paketleme,
           geopos_units.name AS units');

        $this->db->from('geopos_products');
        $this->db->join('geopos_product_type', 'geopos_products.product_type = geopos_product_type.id');
        $this->db->join('geopos_product_cat', 'geopos_products.pcat = geopos_product_cat.id');
        $this->db->join('geopos_warehouse', 'geopos_products.warehouse   = geopos_warehouse.id');
        $this->db->join('geopos_paketleme_tipi', 'geopos_products.paketleme_tipi   = geopos_paketleme_tipi.id');
        $this->db->join('geopos_units','geopos_products.unit   = geopos_units.code');

        $this->db->where('geopos_products.pid', $pid);



        $query = $this->db->get();
        //$data = [];

        $this->db->select('*');
        $this->db->from('geopos_products');
        $this->db->where('parent_id', $pid);

        $query2 = $this->db->get();

        $data['product']  = $query->row_array();
        $data['children'] = $query2->result() ?? [];

        return $data;

    }



    public function view_bilgi(){
        $pid = $this->input->post('id');
        $this->db->select('geopos_products.* , geopos_product_type.name AS type, geopos_product_cat.title AS category, geopos_warehouse.title AS warehouse,geopos_paketleme_tipi.name AS paketleme,
           geopos_units.name AS units');

        $this->db->from('geopos_products');
        $this->db->join('geopos_product_type', 'geopos_products.product_type = geopos_product_type.id');
        $this->db->join('geopos_product_cat', 'geopos_products.pcat = geopos_product_cat.id');
        $this->db->join('geopos_warehouse', 'geopos_products.warehouse   = geopos_warehouse.id');
        $this->db->join('geopos_paketleme_tipi', 'geopos_products.paketleme_tipi   = geopos_paketleme_tipi.id');
        $this->db->join('geopos_units','geopos_products.unit   = geopos_units.code');

        $this->db->where('geopos_products.pid', $pid);



        $query = $this->db->get();
        //$data = [];

        $this->db->select('*');
        $this->db->from('geopos_products');
        $this->db->where('parent_id', $pid);

        $query2 = $this->db->get();

        $data['product']  = $query->row_array();
        $data['children'] = $query2->result() ?? [];

        return $data;
    }


    public function print_lists(){

        $pids = $this->input->post('pids');

        foreach ($pids as $key => $value) {
            $data=$value;
        }

    }

    function get_datatables_depo($id = '', $w = '')

    {
        $this->_get_datatables_query_depo($id, $w);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _get_datatables_query_depo($id = '', $w = '')

    {
        $table='geopos_product_to_warehouse';

        /*if ($this->aauth->get_user()->roleid==14) {

           $table='geopos_product_to_warehouse_r';

        }*/
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('geopos_product_to_warehouse.warehouse_id', $id);
        $types = array(6,7);

        $this->db->where_not_in('geopos_products.product_type',$types);
        $this->db->join('geopos_product_to_warehouse','geopos_product_to_warehouse.product_id = geopos_products.pid');



        $i = 0;



        foreach ($this->column_search as $item) // loop column

        {

            $search = $this->input->post('search');

            $value = $search['value'];

            if ($value) // if datatable send POST for search

            {



                if ($i === 0) // first loop

                {

                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, $value);

                } else {

                    $this->db->or_like($item, $value);

                }



                if (count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) // here order processing

        {

            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

        $this->db->group_by('geopos_product_to_warehouse.product_id');




    }

    function count_filtered_depo($id, $w = '')

    {

        $this->_get_datatables_query_depo($id, $w);



        $query = $this->db->get();

        return $query->num_rows();

    }



    public function count_all_depo($id)

    {

        $table='geopos_product_to_warehouse';

        /*if ($this->aauth->get_user()->roleid==14) {

           $table='geopos_product_to_warehouse_r';

        }*/
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('geopos_product_to_warehouse.warehouse_id', $id);
        $types = array(6,7);

        $this->db->where_not_in('geopos_products.product_type',$types);
        $this->db->join('geopos_product_to_warehouse','geopos_product_to_warehouse.product_id = geopos_products.pid');

        return $this->db->count_all_results();

    }








}
