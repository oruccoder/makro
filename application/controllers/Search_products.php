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
class Search_products extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('search_model');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->get_user()->roleid == 2) {
            exit('<h3>Bu Sayfaya Giriş İzniniz Yoktur!</h3>');

        }

    }

//Ürün Kontrol
    public function product_control()

    {

        $result = array();

        $out = array();

        $row_num = $this->input->post('row_num', true);

        $name = $this->input->post('name_startsWith', true);

        $wid = $this->input->post('wid', true);

        $qw = '';



        $join = '';

        if ($this->aauth->get_user()->loc) {

            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';

            $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND ';

        }

        if ($name) {

            $query = $this->db->query("SELECT geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.product_code,geopos_products.taxrate,0 as disrate,geopos_products.product_des,geopos_products.qty,geopos_products.unit  FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%') OR (UPPER(geopos_products.product_code) LIKE '" . strtoupper($name) . "%')");



            $result = $query->result_array();

            if($result)
            {
                echo 'Aynı Ürün Daha Önce Tanımlanmış';
            }
            else
            {
                echo 0;
            }

        }



    }


//Ürün Kontrol

    public function search_newproducts()

    {

        $result = array();

        $out = array();

        $row_num = $this->input->post('row_num', true);

        $name = $this->input->post('name_startsWith', true);

        $wid = $this->input->post('wid', true);

        $qw = '';

        if ($wid > 0) {

            $qw = "(geopos_products.warehouse='$wid') AND ";

        }

        $join = '';

        if ($this->aauth->get_user()->loc) {

            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';

            $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND ';

        }



        if ($name) {

            $query = $this->db->query("SELECT geopos_products.pid,geopos_products.product_name,geopos_products.product_price,
geopos_products.product_code,geopos_products.taxrate,0 as disrate,geopos_products.product_des,geopos_products.qty,
geopos_products.unit  FROM geopos_products $join WHERE geopos_products.product_type NOT IN(6,7) AND( " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%')
             OR (UPPER(geopos_products.product_code) LIKE '" . strtoupper($name) . "%')
               OR
(UPPER(geopos_products.barcode) LIKE '" . strtoupper($name) . "%')) LIMIT 6");



            $result = $query->result_array();

            if($result)

            {
                foreach ($result as $row) {

                    $name = array($row['product_name'], $row['product_price'], $row['pid'], $row['taxrate'], $row['disrate'], $row['product_des'], $row['unit'], $row['product_code'], $row['qty'], $row_num);

                    array_push($out, $name);

                }
            }

            else
            {
                $names=array($name,0,0);
                array_push($out, $names);
            }


            echo json_encode($out);

        }




    }

    public function talep_urunleri_ihale()
    {
        $out=array();
        $talep_id = $this->input->post('talep_id', true);
        $teklif_details= $this->db->query("SELECT * FROM `geopos_ihale` where id =$talep_id")->row_array();
        $items= $this->db->query("SELECT * FROM `geopos_ihale_items` WHERE `ihale_id` = $talep_id ORDER BY `product_name` ASC")->result();
        $firmalar= $this->db->query("SELECT * FROM `geopos_ihale_items_firma` WHERE `ihale_id` = $talep_id GROUP BY firma_id")->result();


        foreach ($items as $item)
        {
            foreach ($firmalar as $firma)
            {

                $detailss = $this->db->query("SELECT geopos_ihale_items_firma.kdv,geopos_ihale_items_firma.ulke,geopos_ihale_items_firma.marka,geopos_ihale_items_firma.teklif_tarihi,geopos_ihale_items_firma.odeme,geopos_ihale_items_firma.nakliye_durumu,geopos_ihale_items_firma.odeme_tarihi,geopos_ihale_items_firma.firma_id
,geopos_ihale_items_firma.item_id,geopos_ihale_items_firma.product_id,
geopos_ihale_items.product_name,geopos_ihale_items_firma.fiyat,geopos_ihale_items.unit,geopos_ihale_items.product_qty as qty,geopos_ihale_items.product_detail
 FROM `geopos_ihale_items_firma` INNER JOIn geopos_ihale_items ON geopos_ihale_items_firma.item_id=geopos_ihale_items.id WHERE `item_id` = $item->id
 and firma_id=$firma->firma_id and fiyat>0 ORDER BY `geopos_ihale_items_firma`.`fiyat` ASC LIMIT 1")->row_array();

                if(isset($detailss['product_name']))
                {

                    $out[]=array(
                        'teklif_tarih'=>$detailss['teklif_tarihi'].' | '.$teklif_details['dosya_no'],
                        'firma_name'=>customer_details($firma->firma_id)['company'],
                        'firma_tel'=>customer_details($firma->firma_id)['phone'],
                        'product_id'=>$detailss['product_id'],
                        'firma_id'=>$firma->firma_id,
                        'item_id'=>$detailss['item_id'],
                        'product_name'=>$detailss['product_name'],
                        'price'=>$detailss['fiyat'],
                        'unit'=>$detailss['unit'],
                        'qty'=>$detailss['qty'],
                        'details'=>$detailss['product_detail'],
                        'odeme'=>$detailss['odeme'],
                        'nakliye_durumu'=>$detailss['nakliye_durumu'],
                        'odeme_tarihi'=>$detailss['odeme_tarihi'],
                        'marka'=>$detailss['marka'],
                        'kdv'=>$detailss['kdv'],
                        'ulke'=>$detailss['ulke']
                    );



                }

            }
        }






        echo json_encode($out);
    }

    public function talep_urunleri()
    {
        $out=array();
        $talep_id = $this->input->post('talep_id', true);
        $details= $this->db->query("SELECT * FROM geopos_talep_items WHERE tip=$talep_id")->result();
        foreach ($details as $detailss)
        {

            $query=$this->db->query("Select * From geopos_onay where malzeme_items_id=$detailss->id")->row();
            /*if($query->satinalma_yonlendirme==$this->aauth->get_user()->id)
            {


            }
            */

            if($query->malzeme_items_id==$detailss->id)
            {
                $out[]=array(
                    'product_id'=>$detailss->product_id,
                    'product_name'=>$detailss->product_name,
                    'unit'=>$detailss->unit,
                    'qty'=>$detailss->qty,
                    'details'=>$detailss->product_detail
                );
            }


        }

        echo json_encode($out);
    }

    public function personel_ajax()
    {
        $out=array();
        $paymethod = $this->input->post('paymethod', true);

        $details= $this->db->query("SELECT * FROM geopos_employees WHERE resmi_maas>0")->result();
        foreach ($details as $detailss)
        {
            $maas=$detailss->salary;
            $resmi_maas=$detailss->resmi_maas;
            $gayri_resmi_maas=$detailss->gayri_resmi_maas;
            $date = new DateTime('now');
            $date->modify('last day of this month');
            $hesaplanacak_ay=$date->format('m');
            $date_y=$date->format('Y');
            $customer_id = $detailss->id;

            $maas=0;
            if($paymethod==1) // Nakit //gayri resmi
            {

                $query = $this->db->query("SELECT SUM(total) as totals FROM geopos_invoices where csd=$customer_id and (invoice_type_id=16 or invoice_type_id=14 or invoice_type_id=12 or invoice_type_id=4 or invoice_type_id=34)  and method!=3");
                $result = $query->row();

                $total=0;
                $guns_=date("t");
                $gun=0;

                $date_ti=$date_y.'-'.$hesaplanacak_ay.'-'.$guns_;
                $sorgu_t=$this->db->query("SELECT  DATEDIFF('$date_ti',geopos_users.date_created) AS gun_sayisi FROM geopos_employees INNER JOIN geopos_users On geopos_users.id=geopos_employees.id Where  geopos_employees.id=$customer_id")->row();

                if($sorgu_t->gun_sayisi < $guns_)
                {
                    $gun=$sorgu_t->gun_sayisi;
                }
                else
                {
                    $gun=$guns_;
                }






                $gunluk=$resmi_maas/30;
                $resmi_mmas_t=$gunluk*$guns_;
                $nakit_kalan=$maas-$resmi_mmas_t;

                $hakedis=$this->db->query("SELECT SUM(total) as total_hak FROM geopos_invoices where csd=$customer_id and (invoice_type_id=13 or invoice_type_id=15 or invoice_type_id=16 or invoice_type_id=26) and method=1 ")->row_array();


                $nakit_hak=0;
                if(isset($hakedis))
                {
                    $nakit_hak=$hakedis['total_hak'];
                }

                $total=$result->totals;

                $kalan = $nakit_hak-$total;
                $maas = $kalan;
                //$maas=$detailss->gayri_resmi_maas;
            }
            else //resmi maas
            {
                $query = $this->db->query("SELECT * FROM geopos_invoices where csd=$customer_id and (invoice_type_id=16 or invoice_type_id=14 or invoice_type_id=12 or invoice_type_id=4 or invoice_type_id=34) and method=3");
                $result = $query->result_array();
                $total=0;

                $gun=0;
                $guns_=date("t");

                $date_ti=$date_y.'-'.$hesaplanacak_ay.'-'.$guns_;
                $sorgu_t=$this->db->query("SELECT  DATEDIFF('$date_ti',geopos_users.date_created) AS gun_sayisi FROM geopos_employees INNER JOIN geopos_users On geopos_users.id=geopos_employees.id Where  geopos_employees.id=$customer_id")->row();

                // $sorgu_t=$this->db->query("SELECT DATEDIFF('$date_ti',`joindate`) AS gun_sayisi FROM geopos_employees Where id=$customer_id")->row();
                if($sorgu_t->gun_sayisi<$guns_)
                {
                    $gun=$sorgu_t->gun_sayisi;
                }
                else
                {
                    $gun=$guns_;
                }





                $gunluk=$resmi_maas/30;
                $hakedis=$this->db->query("SELECT SUM(total) as total_hak FROM geopos_invoices where csd=$customer_id and (invoice_type_id=31 or invoice_type_id=26) and method=3 ")->row_array();
                $hakedis=$hakedis['total_hak'];



                if ($query->num_rows() > 0)
                {
                    foreach ($result as $row)
                    {
                        $total+=$row['total'];
                    }
                    $kalan = $hakedis-$total;

                }
                else
                {
                    $kalan=$hakedis;
                }

                $maas=$kalan;
                //  $maas=$detailss->resmi_maas;
            }

            $out[]=array(
                'maas'=>$maas,
                'pers_name'=>$detailss->name,
                'pers_id'=>$detailss->id
            );

        }




        echo json_encode($out);
    }

    public function personel_ajax_search()
    {
        $out=array();
        $paymethod = $this->input->post('paymethod', true);
        $name_startsWith = $this->input->post('name_startsWith', true);

        $details= $this->db->query("SELECT * FROM geopos_employees WHERE resmi_maas>0 and `name` LIKE '%$name_startsWith%'")->result();
        foreach ($details as $detailss)
        {

            $maas=$detailss->salary;
            $resmi_maas=$detailss->resmi_maas;
            $gayri_resmi_maas=$detailss->gayri_resmi_maas;
            $date = new DateTime('now');
            $date->modify('last day of this month');
            $hesaplanacak_ay=$date->format('m');
            $date_y=$date->format('Y');
            $customer_id = $detailss->id;

            $maas=0;
            if($paymethod==1) // Nakit //gayri resmi
            {

                $query = $this->db->query("SELECT SUM(total) as totals FROM geopos_invoices where csd=$customer_id and (invoice_type_id=16 or invoice_type_id=14 or invoice_type_id=12 or invoice_type_id=4 or invoice_type_id=34)  and method!=3");
                $result = $query->row();

                $total=0;
                $guns_=date("t");
                $gun=0;

                $date_ti=$date_y.'-'.$hesaplanacak_ay.'-'.$guns_;
                $sorgu_t=$this->db->query("SELECT  DATEDIFF('$date_ti',geopos_users.date_created) AS gun_sayisi FROM geopos_employees INNER JOIN geopos_users On geopos_users.id=geopos_employees.id Where  geopos_employees.id=$customer_id")->row();

                if($sorgu_t->gun_sayisi < $guns_)
                {
                    $gun=$sorgu_t->gun_sayisi;
                }
                else
                {
                    $gun=$guns_;
                }






                $gunluk=$resmi_maas/30;
                $resmi_mmas_t=$gunluk*$guns_;
                $nakit_kalan=$maas-$resmi_mmas_t;

                $hakedis=$this->db->query("SELECT SUM(total) as total_hak FROM geopos_invoices where csd=$customer_id and (invoice_type_id=13 or invoice_type_id=15 or invoice_type_id=16 or invoice_type_id=26) and method=1 ")->row_array();


                $nakit_hak=0;
                if(isset($hakedis))
                {
                    $nakit_hak=$hakedis['total_hak'];
                }

                $total=$result->totals;

                $kalan = $nakit_hak-$total;
                $maas = $kalan;
                //$maas=$detailss->gayri_resmi_maas;
            }
            else //resmi maas
            {
                $query = $this->db->query("SELECT * FROM geopos_invoices where csd=$customer_id and (invoice_type_id=16 or invoice_type_id=14 or invoice_type_id=12 or invoice_type_id=4 or invoice_type_id=34) and method=3");
                $result = $query->result_array();
                $total=0;

                $gun=0;
                $guns_=date("t");

                $date_ti=$date_y.'-'.$hesaplanacak_ay.'-'.$guns_;
                $sorgu_t=$this->db->query("SELECT  DATEDIFF('$date_ti',geopos_users.date_created) AS gun_sayisi FROM geopos_employees INNER JOIN geopos_users On geopos_users.id=geopos_employees.id Where  geopos_employees.id=$customer_id")->row();

                // $sorgu_t=$this->db->query("SELECT DATEDIFF('$date_ti',`joindate`) AS gun_sayisi FROM geopos_employees Where id=$customer_id")->row();
                if($sorgu_t->gun_sayisi<$guns_)
                {
                    $gun=$sorgu_t->gun_sayisi;
                }
                else
                {
                    $gun=$guns_;
                }





                $gunluk=$resmi_maas/30;
                $hakedis=$this->db->query("SELECT SUM(total) as total_hak FROM geopos_invoices where csd=$customer_id and (invoice_type_id=31 or invoice_type_id=26) and method=3 ")->row_array();
                $hakedis=$hakedis['total_hak'];



                if ($query->num_rows() > 0)
                {
                    foreach ($result as $row)
                    {
                        $total+=$row['total'];
                    }
                    $kalan = $hakedis-$total;

                }
                else
                {
                    $kalan=$hakedis;
                }

                $maas=$kalan;
                //  $maas=$detailss->resmi_maas;
            }


            $name = array(
                $maas,
                $detailss->name,
                $detailss->id
            );

            array_push($out, $name);

        }




        echo json_encode($out);
    }

    public function proje_deposu()
    {
        $proje_id = $this->input->post('proje_id', true);
        $details= $this->db->query("SELECT * FROM geopos_warehouse WHERE proje_id=$proje_id")->row();
        $out=array('id'=>$details->id,'name'=>$details->title);
        echo json_encode($out);
    }

    public function proje_bilgileri()
    {
        $proje_id = $this->input->post('proje_id', true);
        $details= $this->db->query("SELECT * FROM geopos_projects WHERE id=$proje_id")->row();
        $out=array(
            'proje_sorumlusu_id'=>$details->proje_sorumlusu_id,
            'genel_mudur_id'=>$details->genel_mudur_id,
            'proje_muduru'=>$details->proje_muduru,
            'depo_muduru_id'=>$details->depo_muduru_id
        );
        echo json_encode($out);
    }

    public function new_product()
    {

        $this->load->model('products_model', 'products');

        $product_name = $this->input->post('name_startsWith', true);

        $product_code = $product_name.'- 01';

        $unit = 'Ad';

        $product_type = 4;



        $product_id=$this->products->new_product($product_name, $product_code, $product_type,$unit);

        echo $product_id;
        die();




    }

    public function proje_bolumleri()
    {
        $out=array();
        $proje_id = $this->input->post('proje_id', true);
        $name = $this->input->post('name_startsWith', true);
        $bolumler = $this->db->query("SELECT * FROM `geopos_project_bolum` WHERE  pid=$proje_id and `name` LIKE '%" . strtoupper($name) . "%' ")->result();
        foreach ($bolumler as $bolum)
        {
            $name = array(
                $bolum->name,
                $bolum->id
            );

            array_push($out, $name);
        }

        echo json_encode($out);
    }

    public function bagli_proje_asamalari()
    {
        $out=array();
        $proje_id = $this->input->post('proje_id', true);
        $bolum_id = $this->input->post('bolum_id', true);
        $name = $this->input->post('name_startsWith', true);
        $asamalar = $this->db->query("SELECT * FROM `geopos_milestones` WHERE  pid=$proje_id and bolum_id=$bolum_id and parent_id=0 and `name` LIKE '%" . strtoupper($name) . "%' ")->result();
        foreach ($asamalar as $asama)
        {
            $parent_ = $asama->name;
            $name= $parent_;

            $name = array(
                $name,
                $asama->id
            );

            array_push($out, $name);
        }

        echo json_encode($out);
    }

    public function proje_asamalari()
    {
        $out=array();
        $proje_id = $this->input->post('proje_id', true);
        $bolum_id = $this->input->post('bolum_id', true);
        $bagli_oldugu_asama = $this->input->post('bagli_oldugu_asama', true);
        $name = $this->input->post('name_startsWith', true);
        $q='';
        if($bagli_oldugu_asama!=0)
        {
            $q="AND parent_id=".$bagli_oldugu_asama;
        }

        $asamalar = $this->db->query("SELECT * FROM `geopos_milestones` WHERE  pid=$proje_id and bolum_id=$bolum_id  $q and `name` LIKE '%" . strtoupper($name) . "%' ")->result();
        foreach ($asamalar as $asama)
        {
            $name = $asama->name;

            $name = array(
                $name,
                $asama->id
            );


            array_push($out, $name);
        }

        echo json_encode($out);
    }


    public function search_form_2()

    {

        $result = array();

        $out = array();

        $row_num = $this->input->post('row_num', true);

        $invoice_type = $this->input->post('invoice_type', true);

        $proje_id = $this->input->post('proje_id', true);
        $asama_id = $this->input->post('asama_id', true);



        $name = $this->input->post('name_startsWith', true);



        $is_kalemleri = $this->db->query("SELECT * FROM `geopos_todolist` WHERE  proje_id=$proje_id and asama_id=$asama_id and `name` LIKE '%" . strtoupper($name) . "%' ")->result();
        foreach ($is_kalemleri as $products)
        {
            $name = array(
                $products->name,
                $products->fiyat,
                $products->id,
                0,
                0,
                $products->name,
                units_($products->unit)['name'],
                $products->name,
                $products->quantity,
                $products->unit,
                $row_num
            );

            array_push($out, $name);
        }

        echo json_encode($out);



    }
//search product in invoice

    public function search()

    {

        $result = array();

        $out = array();

        $row_num = $this->input->post('row_num', true);

        $invoice_type = $this->input->post('invoice_type', true);



        $name = $this->input->post('name_startsWith', true);
        $wid = $this->input->post('wid', true);



        $where_products=' geopos_products.loc ='.$this->session->userdata('set_firma_id').' and'; //2019-11-23 14:28:57
        $where_cost=' and demirbas_group.loc ='.$this->session->userdata('set_firma_id'); //2019-11-23 14:28:57


        if($invoice_type==24) // eğer Gider faturası ise
        {
            //$query = $this->db->query("SELECT * FROM geopos_cost WHERE parent_id!=0 $where_cost and  (UPPER(name) LIKE '%" . strtoupper($name) . "%')  LIMIT 20");
            $query = $this->db->query("SELECT demirbas_group.*, 9 as 'unit' FROM demirbas_group WHERE demirbas_id!=0 $where_cost and  (UPPER(name) LIKE '%" . strtoupper($name) . "%')  LIMIT 20");

            $result = $query->result_array();

            foreach ($result as $row) {
                $price_in=0;
                $demirbas_id = $row['demirbas_id'];
                $x_name = who_demirbas($demirbas_id)->name;
                $name = array($x_name.' -> '.$row['name'], $price_in, $row['id'],0, 0, 0,$row['unit'], '',9999999999,$row_num);
                array_push($out, $name);
            }
            echo json_encode($out);

        }
        else if($invoice_type==-1) // eğer Gider Talebi ise
        {
            $query = $this->db->query("
SELECT geopos_products.product_name as name , geopos_products.pid as id,geopos_products.unit FROM geopos_products WHERE geopos_products.product_type NOT IN(6,7) AND $where_products  (UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%')  UNION ALL

SELECT geopos_cost.name,geopos_cost.id, geopos_cost.unit FROM geopos_cost WHERE parent_id!=0 $where_cost AND  (UPPER(name) LIKE '%" . strtoupper($name) . "%')  LIMIT 20");

            $result = $query->result_array();

            foreach ($result as $row) {
                $price_in=0;
                $name = array(
                    $row['name'],
                    $price_in,
                    $row['id'],0, 0, 0,$row['unit'], '',9999999999, units_($row['unit'])['name']);
                array_push($out, $name);
            }
            echo json_encode($out);

        }
        else if($invoice_type==41) // eğer Gider  ise
        {
            $query = $this->db->query("SELECT * FROM geopos_cost WHERE parent_id!=0 $where_cost AND  (UPPER(name) LIKE '%" . strtoupper($name) . "%')  LIMIT 20");

            $result = $query->result_array();

            foreach ($result as $row) {
                $price_in=0;
                $name = array($row['name'], $price_in, $row['id'],0, 0, 0,$row['unit'], '',9999999999,$row_num);
                array_push($out, $name);
            }
            echo json_encode($out);

        }

        else if($invoice_type==36 ||  $invoice_type==35) // eğer sözleşme faturası ise
        {
            $query = $this->db->query("SELECT * FROM geopos_cost WHERE parent_id!=0 $where_cost AND  (UPPER(name) LIKE '%" . strtoupper($name) . "%')  LIMIT 20");

            $result = $query->result_array();

            foreach ($result as $row) {
                $price_in=0;
                $name = array($row['name'], $price_in, $row['id'],0, 0, 0,$row['unit'], '',9999999999,$row_num);
                array_push($out, $name);
            }
            echo json_encode($out);

        }
        else {

            $qw = '';
            $join = '';
            $slc='0 as product_price,geopos_products.product_type,geopos_products.pid,geopos_products.product_name,
geopos_products.product_code,geopos_products.taxrate,0 as disrate,
geopos_products.product_des,100 as qty,geopos_products.unit  ';



            if($invoice_type==1)
            {

                //$join = "LEFT JOIN geopos_product_to_warehouse ON geopos_product_to_warehouse.product_id = geopos_products.pid";

            }


            else
            {

                $slc='0 as fproduct_price,geopos_products.product_type,geopos_products.pid,geopos_products.product_name,
0 as product_price,geopos_products.product_code,geopos_products.taxrate,0 as disrate,
geopos_products.product_des,0 as qty,geopos_products.unit  ';

            }







            if ($name) {


//FROM geopos_products $join WHERE $where_products geopos_products.product_type NOT IN(7) AND (
                $query = $this->db->query("SELECT  $slc

                             FROM geopos_products $join WHERE $where_products  (
" . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%') OR
(UPPER(geopos_products.product_code) LIKE '" . strtoupper($name) . "%')  OR
(UPPER(geopos_products.barcode) LIKE '" . strtoupper($name) . "%') )  LIMIT 100");



                $bar='';
                if (is_numeric($name)) {
                    $qw='';

                    //       $barcode = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);

                    $b = array('-', '-', '-');

                    $c = array(3, 4, 11);

                    $barcode = $name;

                    for ($i = count($c) - 1; $i >= 0; $i--) {

                        $barcode = substr_replace($barcode, $b[$i], $c[$i], 0);

                    }



                    //    echo(substr($barcode, 0, -1));

                    $slc='geopos_products.product_price,geopos_products.product_type,geopos_products.pid,geopos_products.product_name,
geopos_products.product_price,geopos_products.product_code,geopos_products.taxrate,0 as disrate,
geopos_products.product_des,geopos_product_to_warehouse.qty,geopos_products.unit  ';

                    if ($wid > 0) {

                        if($invoice_type==1)
                        {
                            $qw = "geopos_product_to_warehouse.warehouse_id='$wid' AND ";
                            $join = "INNER JOIN geopos_product_to_warehouse ON geopos_product_to_warehouse.product_id = geopos_products.pid";

                        }


                        else
                        {
                            $qw = "";
                            $slc='geopos_products.fproduct_price,geopos_products.product_type,geopos_products.pid,geopos_products.product_name,
geopos_products.product_price,geopos_products.product_code,geopos_products.taxrate,0 as disrate,
geopos_products.product_des,0 as qty,geopos_products.unit  ';

                        }



                    }

                    $bar = " (geopos_products.barcode LIKE '%" . (substr($barcode, 0, -1)) ."%') OR (UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%') ";

                    $query=$this->db->query("SELECT $slc FROM geopos_products $join WHERE $where_products  " . $qw . " $bar  AND  geopos_products.product_type NOT IN(6,7)  LIMIT 20");



                }








                $result = $query->result_array();

                foreach ($result as $row) {
                    $price_in=0;
                    $qty =  stock_qty_warehouse($row['pid'],$wid)['qty'];

                    if($row['product_type']){
                        if($row['product_type']==2){
                            $qty=99999;
                        }
                    }

                    //$qty=$this->db->query("SELECT SUM(qty) as qty FROM geopos_product_to_warehouse where product_id =".$row['pid'].' and warehouse_id=7')->row()->qty;
                    $pname=$row['product_name'];



                    if($invoice_type==1) // Satış
                    {
                        $price_in=$row['product_price'];


                    }
                    else if($invoice_type==2) // Alış
                    {
                        $price_in=$row['fproduct_price'];
                        $pname=$row['product_name'];
                    }
                    else if($invoice_type==7) // Satış İade
                    {
                        $price_in=$row['fproduct_price'];
                    }
                    else if($invoice_type==8) // Alış İade
                    {
                        $price_in=$row['product_price'];
                    }
                    $unit=units_($row['unit'])['name'];

                    $name = array($pname, $price_in, $row['pid'],
                        $row['taxrate'], $row['disrate'], $row['product_des'],
                        $row['unit'], $row['product_code'], $qty,$unit, $row_num);

                    array_push($out, $name);

                }


                echo json_encode($out);

            }


        }
    }


    public function malzeme_talep_search_stok()
    {
        $out = array();

        $row_num = $this->input->post('row_num', true);
        $prj_st = $this->input->post('prj_st', true);
        $name = $this->input->post('name_startsWith', true);

        $name=str_replace("'","\'",$name);

        $query='';
        $result='';

        if($prj_st){
            $query = $this->db->query("SELECT  name as product_name,unit,id as pid
    FROM geopos_todolist  WHERE  (UPPER(geopos_todolist.name) LIKE '%" . strtoupper($name) . "%')  LIMIT 20");
        }
        else {
            $query = $this->db->query("SELECT  *
    FROM geopos_products  WHERE  (UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%')  LIMIT 20");
        }


        if($query->num_rows()>0)
        {
            $result = $query->result_array();
        }

        foreach ($result as $row) {
            $price_in=0;
            $pname=$row['product_name'];

            $unit=units_($row['unit'])['name'];

            $name = array($pname, $price_in, $row['pid'],
                0, 0, $row['product_name'],
                $row['unit'], '', 1,$unit, $row_num);

            array_push($out, $name);

        }


        echo json_encode($out);
    }

    public function malzeme_talep_search()

    {

        $result = array();

        $out = array();

        $row_num = $this->input->post('row_num', true);

        $invoice_type = $this->input->post('invoice_type', true);



        $name = $this->input->post('name_startsWith', true);

        $bagli_oldugu_asama = $this->input->post('bagli_oldugu_asama', true);
        $asama_id = $this->input->post('asama_id', true);










        if ($name) {

            $result='';

            $query = $this->db->query("SELECT  *
    FROM geopos_todolist  WHERE  (UPPER(geopos_todolist.name) LIKE '%" . strtoupper($name) . "%') and geopos_todolist.asama_id=$asama_id  LIMIT 6");

            $query2 = $this->db->query("SELECT  *
    FROM geopos_todolist  WHERE  (UPPER(geopos_todolist.name) LIKE '%" . strtoupper($name) . "%') and geopos_todolist.asama_id=$bagli_oldugu_asama  LIMIT 6");

            if($query->num_rows()>0)
            {
                $result = $query->result_array();
            }
            else
            {
                $result = $query2->result_array();
            }




            foreach ($result as $row) {
                $price_in=0;
                $pname=$row['name'];

                $unit=units_($row['unit'])['name'];

                $name = array($pname, $price_in, $row['product_id'],
                    0, 0, $row['name'],
                    $row['unit'], '', round($row['quantity'],2),$unit, $row_num);

                array_push($out, $name);

            }


            echo json_encode($out);

        }



    }



    public function puchase_search()

    {

        $result = array();

        $out = array();

        $row_num = $this->input->post('row_num', true);

        $name = $this->input->post('name_startsWith', true);

        $wid = $this->input->post('wid', true);

        $qw = '';






        if ($name) {





            $query = $this->db->query("SELECT pid,product_name,product_code,product_price,taxrate,disrate,
product_des,unit FROM geopos_products WHERE geopos_products.product_type NOT IN(6,7) AND( " . $qw . "UPPER(product_name)
 LIKE '%" . strtoupper($name) . "%' or UPPER(barcode) LIKE '%" . strtoupper($name) . "%'
 OR UPPER(product_code) LIKE '" . strtoupper($name) . "%') LIMIT 6");

            $join='';
            $bar='';

            if (is_numeric($name)) {

                //       $barcode = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);

                $b = array('-', '-', '-');

                $c = array(3, 4, 11);

                $barcode = $name;

                for ($i = count($c) - 1; $i >= 0; $i--) {

                    $barcode = substr_replace($barcode, $b[$i], $c[$i], 0);

                }



                //    echo(substr($barcode, 0, -1));

                $bar = " (geopos_products.barcode LIKE '" . (substr($barcode, 0, -1)) ."%')";


                $query=$this->db->query("SELECT geopos_products.* FROM geopos_products $join WHERE " . $qw . " $bar LIMIT 16");



            }



            $result = $query->result_array();

            foreach ($result as $row) {

                $name = array(
                    'value'=>$row['product_name'],
                    $row['product_name'],
                    $row['product_price'],
                    $row['pid'],
                    $row['taxrate'],
                    $row['disrate'],
                    $row['product_des'],
                    $row['unit'],
                    $row['product_code'],
                    99999999999999999999 // Stok Kontrolü Yaplımayacak
                );

                array_push($out, $name);

            }



            echo json_encode($out);

        }



    }


    public function c_credit()
    {

        $cid = $this->input->post('cid', true);
        $k=1000000000;
        if($cid!='undefined' || $cid!='')
        {
            $sum = $this->input->post('sum', true);
            $sql=$this->db->query("SELECT * FROM geopos_customers WHERE id =$cid");
            $customer = $sql->row_array();

            $query = $this->db->query("SELECT geopos_invoices.*,'all_fatura' as Fatura_Durumu FROM `geopos_invoices` WHERE `csd`=$cid and invoice_type_id=1 and invoiceduedate < DATE_SUB(NOW(), INTERVAL 1 MONTH) UNION ALL
SELECT geopos_invoices.*,'one_fatura' as Fatura_Durumu  FROM `geopos_invoices` WHERE `csd`=$cid and invoice_type_id=1 and invoiceduedate > DATE_SUB(NOW(), INTERVAL 1 MONTH)

");

            $results = $query->result_array();
            $total=0;
            if($results)
            {
                foreach ($results as $rows)
                {
                    $total+=$rows['total'];
                }


            }

            $kalan_credit=$customer['credit']-$total;
            $kalan_credit-=$sum;
            $k=amountFormat($kalan_credit);
        }


        echo $k;
    }

    public function kasalar()
    {

        $id = $this->aauth->get_user()->id;
        $roleid = $this->aauth->get_user()->roleid;

        $metod= $this->input->post('metod', true);;

        $metods=$this->db->query("SELECT * FROM geopos_account_type WHERE geopos_account_type.id=$metod")->row();

        $where="geopos_account_type.id=$metod";

        if($metod==4)
        {
            $where="(geopos_account_type.id=$metod or geopos_account_type.id=3) and geopos_accounts.para_birimi=1";
        }


        if($roleid==1 || $roleid==7 || $roleid==4)
        {

        }
        else
        {
            $where.=" and geopos_accounts.eid = $id ";
            $this->db->where('eid', $id);
        }


        $kasalar=$this->db->query("SELECT geopos_accounts.*, geopos_account_type.name as tip_name FROM geopos_accounts INNER JOIN geopos_account_type ON geopos_accounts.account_type=geopos_account_type.id
WHERE geopos_accounts.status=1 and $where ORDER BY geopos_accounts.id DESC")->result();

        $data=array(
            'tip'=> $metods->name,
            'kasalar'=>$kasalar
        );

        echo json_encode($data);
    }



    public function purchase_search()

    {

        $result = array();

        $out = array();

        $name = $this->input->get('keyword', true);

        $whr = '';

        if ($this->aauth->get_user()->loc) {

            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';

        }

        if ($name) {

            $query = $this->db->query("SELECT * From geopos_purchase WHERE $whr (UPPER(tid)  LIKE '%" . strtoupper($name) . "%' OR UPPER(tid)  LIKE '" . strtoupper($name) . "%') LIMIT 6");

            $result = $query->result_array();

            echo '<ol>';

            $i = 1;

            foreach ($result as $row) {
                $id=$row['id'];
                $order_name=$row['tid'];
                $date=$row['invoicedate'];
                $customer_details=customer_details($row['csd']);





                echo "<li onClick=\"select_sayim('" . $id . "')\"><p>" . $order_name. " - &nbsp; &nbsp  " . $date . " - &nbsp; &nbsp  " . $customer_details['company'] . "</p></li>";




                $i++;

            }

            echo '</ol>';

        }



    }

    public function csearchSatin()

    {

        $result = array();

        $out = array();

        $name = $this->input->get('keyword', true);
        $invoice_type = $this->input->get('invoice_type', true);
        $eq = $this->input->get('eq', true);

        $whr = '';

        if ($this->aauth->get_user()->loc) {

            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';

        }

        if ($name) {

            $query = $this->db->query("SELECT id,name,address,city,phone,email,discount_c,credit,company FROM geopos_customers WHERE $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(company)  LIKE '%" . strtoupper($name) . "%'    OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");


            $result = $query->result_array();

            echo '<ol>';

            $i = 1;

            foreach ($result as $row) {
                $c_id=$row['id'];

                $query = $this->db->query("SELECT geopos_invoices.*,'all_fatura' as Fatura_Durumu FROM `geopos_invoices` WHERE `csd`=$c_id and invoice_type_id=1 and invoiceduedate < DATE_SUB(NOW(), INTERVAL 1 MONTH) UNION ALL
SELECT geopos_invoices.*,'one_fatura' as Fatura_Durumu  FROM `geopos_invoices` WHERE `csd`=$c_id and invoice_type_id=1 and invoiceduedate > DATE_SUB(NOW(), INTERVAL 1 MONTH)

");

                $results = $query->result_array();
                $total=0;
                if($results)
                {
                    foreach ($results as $rows)
                    {
                        $total+=$rows['total'];
                    }


                }

                $kalan_credit=$row['credit']-$total;




                echo "<li onClick=\"selectCustomerSatin('". $eq . "'
                ,'" . $row['phone'] . "'
                ,'" . $row['company']  . "')\"><span>$i</span><p>" . $row['company'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";




                $i++;

            }

            echo '</ol>';

        }



    }
    public function csearch()

    {

        $result = array();

        $out = array();

        $name = $this->input->get('keyword', true);
        $invoice_type = $this->input->get('invoice_type', true);

        $whr = '';


        $where_customer=' geopos_customers.loc ='.$this->session->userdata('set_firma_id').' and'; //2019-11-23 14:28:57
        $where_invoice=' and geopos_invoices.loc ='.$this->session->userdata('set_firma_id'); //2019-11-23 14:28:57



        if ($name) {

            $query = $this->db->query("SELECT id,name,address,city,phone,email,discount_c,credit,company FROM geopos_customers WHERE $where_customer $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(company)  LIKE '%" . strtoupper($name) . "%'    OR UPPER(phone)  LIKE '" . strtoupper($name) . "%')  LIMIT 6");


            $result = $query->result_array();

            echo '<ol>';

            $i = 1;

            foreach ($result as $row) {
                $c_id=$row['id'];

                $query = $this->db->query("SELECT geopos_invoices.*,'all_fatura' as Fatura_Durumu FROM `geopos_invoices` WHERE `csd`=$c_id and invoice_type_id=1 and invoiceduedate < DATE_SUB(NOW(), INTERVAL 1 MONTH)
UNION ALL
SELECT geopos_invoices.*,'one_fatura' as Fatura_Durumu  FROM `geopos_invoices` WHERE `csd`=$c_id $where_invoice and invoice_type_id=1 and invoiceduedate > DATE_SUB(NOW(), INTERVAL 1 MONTH)

");

                $results = $query->result_array();
                $total=0;
                if($results)
                {
                    foreach ($results as $rows)
                    {
                        $total+=$rows['total'];
                    }


                }

                $kalan_credit=$row['credit']-$total;




                echo "<li onClick=\"selectCustomer('" . $row['id'] . "','" . $row['name'] . " ','" . $row['address'] . "',
                '" . $row['city'] . "','" . $row['phone'] . "','" . $row['email'] . "','" . $row['discount_c'] . "',
                '" . amountFormat($kalan_credit) . "','" . amountFormat($row['credit']) . "','" . $invoice_type . "','" . $row['company']  . "')\"><span>$i</span><p>" . $row['company'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";




                $i++;

            }

            echo '</ol>';

        }



    }

    public function gider_hesapla()
    {
        $paymethod = $this->input->post('paymethod', true);
        $customer_id = $this->input->post('customer_id', true);
        $tur_id = $this->input->post('tur_id', true);
        $pay_type = $this->input->post('pay_type', true);
        $where='';

        if($customer_id!=0 )
        {
            $where="and csd=$customer_id";
        }
        $gider_toplami_odenen=0;
        $gider_toplami=0;
        $query = $this->db->query("SELECT IF(SUM(total),SUM(total),0) as gider_toplami FROM geopos_invoices where  geopos_invoices.invoice_type_id=32 $where")->row();
        $querys = $this->db->query("SELECT IF(SUM(total),SUM(total),0) as gider_toplami_odenen FROM geopos_invoices where  geopos_invoices.invoice_type_id=33 $where")->row();
        if($query->gider_toplami!=0)
        {
            $gider_toplami=$query->gider_toplami;
        }
        if($querys->gider_toplami_odenen!=0)
        {
            $gider_toplami_odenen=$querys->gider_toplami_odenen;
        }
        echo $gider_toplami-$gider_toplami_odenen;
    }


    public function maas_hesapla()
    {
        $paymethod = $this->input->post('paymethod', true);
        $customer_id = $this->input->post('customer_id', true);
        $tur_id = $this->input->post('tur_id', true);
        $pay_type = $this->input->post('pay_type', true);
        $kalan=0;


        $date = new DateTime('now');
        $date->modify('last day of this month');
        $hesaplanacak_ay=$date->format('m');
        $date_y=$date->format('Y');


        $query_emp = $this->db->query("SELECT salary,resmi_maas,gayri_resmi_maas FROM geopos_employees where id=$customer_id");
        $row = $query_emp->row_array();
        $maas=$row['salary'];
        $resmi_maas=$row['resmi_maas'];
        $gayri_resmi_maas=$row['gayri_resmi_maas'];
        if($paymethod==3) // Banka
        {
            $hakedis=0;




            if($pay_type==17) //prim ödemesi
            {
                //prim alacağı
                $query = $this->db->query("SELECT * FROM geopos_invoices where csd=$customer_id and geopos_invoices.invoice_type_id=16");
                $result = $query->result_array();
                $total=0;
                $totals=0;
                if ($query->num_rows() > 0)
                {
                    foreach ($result as $row)
                    {
                        $total+=$row['total'];
                    }

                }

                //prim ödemesi
                $querys = $this->db->query("SELECT * FROM geopos_invoices where csd=$customer_id and geopos_invoices.invoice_type_id=17");
                $results = $querys->result_array();
                if ($querys->num_rows() > 0)
                {
                    foreach ($results as $row)
                    {
                        $totals+=$row['total'];
                    }

                }

                echo $total-$totals;

            }
            else if($pay_type==12 || $pay_type==4) // Avans
            {

                $query = $this->db->query("SELECT * FROM geopos_invoices where csd=$customer_id and (invoice_type_id=16 or invoice_type_id=14 or invoice_type_id=12 or invoice_type_id=4 or invoice_type_id=34)  and method=3");
                $result = $query->result_array();
                $total=0;

                $gun=0;
                $guns_=date("t");

                $date_ti=$date_y.'-'.$hesaplanacak_ay.'-'.$guns_;
                $sorgu_t=$this->db->query("SELECT  DATEDIFF('$date_ti',geopos_users.date_created) AS gun_sayisi FROM geopos_employees INNER JOIN geopos_users On geopos_users.id=geopos_employees.id Where  geopos_employees.id=$customer_id")->row();

                // $sorgu_t=$this->db->query("SELECT DATEDIFF('$date_ti',`joindate`) AS gun_sayisi FROM geopos_employees Where id=$customer_id")->row();
                if($sorgu_t->gun_sayisi<$guns_)
                {
                    $gun=$sorgu_t->gun_sayisi;
                }
                else
                {
                    $gun=$guns_;
                }





                $gunluk=$resmi_maas/30;
                $hakedis=$this->db->query("SELECT SUM(total) as total_hak FROM geopos_invoices where csd=$customer_id and (invoice_type_id=31 or invoice_type_id=26) and method=3 ")->row_array();
                $hakedis=$hakedis['total_hak'];



                if ($query->num_rows() > 0)
                {
                    foreach ($result as $row)
                    {
                        $total+=$row['total'];
                    }
                    $kalan = $hakedis-$total;

                }
                else
                {
                    $kalan=$hakedis;
                }



                echo $kalan;
            }
            else
            {
                echo $kalan;
            }

        }
        else
        {
            $hakedis=0;
            if($pay_type==17) //prim ödemesi
            {
                //prim alacağı
                $query = $this->db->query("SELECT * FROM geopos_invoices where csd=$customer_id and geopos_invoices.invoice_type_id=16");
                $result = $query->result_array();
                $total=0;
                $totals=0;
                if ($query->num_rows() > 0)
                {
                    foreach ($result as $row)
                    {
                        $total+=$row['total'];
                    }

                }

                //prim ödemesi
                $querys = $this->db->query("SELECT * FROM geopos_invoices where csd=$customer_id and geopos_invoices.invoice_type_id=17");
                $results = $querys->result_array();
                if ($querys->num_rows() > 0)
                {
                    foreach ($results as $row)
                    {
                        $totals+=$row['total'];
                    }

                }

                echo $total-$totals;

            }
            else if($pay_type==15 || $pay_type==12 || $pay_type==4) // Avans
            {

                $query = $this->db->query("SELECT SUM(total) as totals FROM geopos_invoices where csd=$customer_id and (invoice_type_id=16 or invoice_type_id=14 or invoice_type_id=12 or invoice_type_id=4 or invoice_type_id=34)  and method!=3");
                $result = $query->row();

                $total=0;
                $guns_=date("t");
                $gun=0;

                $date_ti=$date_y.'-'.$hesaplanacak_ay.'-'.$guns_;
                $sorgu_t=$this->db->query("SELECT  DATEDIFF('$date_ti',geopos_users.date_created) AS gun_sayisi FROM geopos_employees INNER JOIN geopos_users On geopos_users.id=geopos_employees.id Where  geopos_employees.id=$customer_id")->row();

                if($sorgu_t->gun_sayisi < $guns_)
                {
                    $gun=$sorgu_t->gun_sayisi;
                }
                else
                {
                    $gun=$guns_;
                }






                $gunluk=$resmi_maas/30;
                $resmi_mmas_t=$gunluk*$guns_;
                $nakit_kalan=$maas-$resmi_mmas_t;

                $hakedis=$this->db->query("SELECT SUM(total) as total_hak FROM geopos_invoices where csd=$customer_id and (invoice_type_id=13 or invoice_type_id=15 or invoice_type_id=16 or invoice_type_id=26) and method=1 ")->row_array();


                $nakit_hak=0;
                if(isset($hakedis))
                {
                    $nakit_hak=$hakedis['total_hak'];
                }

                $total=$result->totals;

                $kalan = $nakit_hak-$total;



                echo $kalan;
            }
        }







    }



    public function party_search()

    {

        $result = array();

        $out = array();

        $tbl = 'geopos_customers';

        $name = $this->input->get('keyword', true);
        $cari_pers_type = $this->input->get('cari_pers_type', true);



        $ty = $this->input->get('ty', true);

        if ($ty) $tbl = 'geopos_supplier';



        if($cari_pers_type==1) // Cari
        {
            $whr = '';

            if ($this->aauth->get_user()->loc) {

                $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';

            }

            if ($name) {

                $query = $this->db->query("SELECT company,id,name,address,city,phone,email FROM $tbl  WHERE $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' or UPPER(company)  LIKE '%" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");

                $result = $query->result_array();

                echo '<ol>';

                $i = 1;

                foreach ($result as $row) {



                    echo "<li onClick=\"selectCustomer('" . $row['id'] . "','" . $row['name'] . " ','" . $row['address'] . "',
                '" . $row['city'] . "',
                '" . $row['phone'] . "',
                '" . $row['email'] . "',0,0,0,0,

                '" . $row['company'] .

                        "',0)\"><span>$i</span><p>" . $row['company'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";

                    $i++;

                }

                echo '</ol>';

            }
        }
        else if($cari_pers_type==2 || $cari_pers_type==5 ) //personel
        {

            $whr = '';

            if ($this->aauth->get_user()->loc) {

                $whr = ' (geopos_users.loc=' . $this->aauth->get_user()->loc . ' OR geopos_users.loc=0) AND ';

            }

            if ($name) {

                $query = $this->db->query("SELECT geopos_employees.*,geopos_users.email From geopos_employees Inner JOIN geopos_users ON geopos_employees.id = geopos_users.id WHERE $whr
                    (UPPER(geopos_employees.name)  LIKE '%" . strtoupper($name) . "%'
            or UPPER(geopos_employees.username)  LIKE '%" . strtoupper($name) . "%' OR UPPER(geopos_employees.phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");

                $result = $query->result_array();

                echo '<ol>';

                $i = 1;

                foreach ($result as $row) {



                    echo "<li onClick=\"selectCustomer('"
                        . $row['id'] . "','"
                        . $row['name'] . " ','"
                        . $row['address'] . "',
                '" . $row['city'] . "',
                '" . $row['phone'] . "',
                '" . $row['email'] . "',0,0,0,0,

                '" . $row['name'] .

                        "',0)\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['email'] . "</p></li>";

                    $i++;

                }

                echo '</ol>';

            }
        }

        else if($cari_pers_type==3) //Masraf
        {

            $whr = '';

            if ($this->aauth->get_user()->loc) {

                $whr = ' (geopos_invoices.loc=' . $this->aauth->get_user()->loc . ' OR geopos_invoices.loc=0) AND ';

            }

            if ($name) {

                $query = $this->db->query("SELECT  geopos_invoices.csd,geopos_invoices.id as invoice_id,geopos_invoice_items.last_balance,geopos_invoice_items.kdv_last_balance,geopos_invoices.invoice_no,
                geopos_invoice_items.`pid`,
                geopos_invoice_items.`subtotal`*geopos_invoices.kur_degeri as subtotal,
                geopos_invoice_items.`totaltax`*geopos_invoices.kur_degeri as total_tax,
                (geopos_invoice_items.subtotal+geopos_invoice_items.`totaltax`)*geopos_invoices.kur_degeri as total,
                geopos_invoice_items.qty as total_qty,
                geopos_invoice_items.unit,
                (SELECT geopos_cost.name FROM geopos_cost Where geopos_cost.id=geopos_invoice_items.pid ) as cost_parent_name,
                (SELECT geopos_cost.parent_id FROM geopos_cost Where geopos_cost.id=geopos_invoice_items.pid ) as inv_parent_id,
                (SELECT geopos_cost.id FROM geopos_cost Where geopos_cost.id=inv_parent_id ) as masraf_id,
                (SELECT geopos_cost.name FROM geopos_cost Where geopos_cost.id=inv_parent_id ) as cost_name

                FROM geopos_invoices
                JOIN geopos_invoice_items ON geopos_invoices.id=geopos_invoice_items.tid
                WHERE (geopos_invoices.invoice_type_id=21 or  geopos_invoices.invoice_type_id=24) AND  (
                (SELECT geopos_cost.name FROM geopos_cost Where geopos_cost.id=(SELECT geopos_cost.parent_id FROM geopos_cost Where geopos_cost.id=geopos_invoice_items.pid )) LIKE '%" . strtoupper($name) . "%'
                OR
                (SELECT geopos_cost.name FROM geopos_cost Where geopos_cost.id=geopos_invoice_items.pid ) LIKE '%" . strtoupper($name) . "%' )
                LIMIT 6 ");
                $result = $query->result_array();

                echo '<ol>';

                $i = 1;

                foreach ($result as $row) {
                    $csd=0;

                    if(isset($row['csd']))
                    {
                        $csd=$row['csd'];
                    }
                    else
                    {
                        $csd=$row['invoice_id'];
                    }

                    $kalan_total=$row['subtotal']-$row['last_balance'];
                    $kalan_kdv_total=$row['total_tax']-$row['kdv_last_balance'];

                    echo "<li onClick=\"selectCustomer('"
                        . $csd . "','"
                        . $row['invoice_no'] . " ','"
                        . $row['pid'] . "',
                '"
                        . $row['invoice_id'] . "',
                '',
                '',0,0,0,0,

                '"
                        . $row['cost_parent_name'] .'-'. $row['invoice_no'].' Kalan Tutar('. amountFormat($kalan_total).')'.' Kalan KDV Tutar('. amountFormat($kalan_kdv_total).')'."','"
                        . $row['pid'] . "')\"><span>$i</span><p>" . $row['invoice_no'] . " &nbsp; &nbsp  " . $row['cost_name']. " &nbsp; &nbsp  " .$row['cost_parent_name'] . " &nbsp; &nbsp  " .'Kalan Tutar: '.' ('. amountFormat($kalan_total).')'.' Kalan KDV Tutar: '.' ('. amountFormat($kalan_kdv_total).')'. "</p></li>";

                    $i++;

                }

                echo '</ol>';

            }
        }

        else if($cari_pers_type==6) //Faktorinq
        {

            $whr = '';

            if ($this->aauth->get_user()->loc) {

                $whr = ' (geopos_invoices.loc=' . $this->aauth->get_user()->loc . ' OR geopos_invoices.loc=0) AND ';

            }

            if ($name) {

                //$query = $this->db->query("SELECT * FROM geopos_invoices WHERE invoice_type_id=37 and status=1 and UPPER(invoice_name)  LIKE '%" . strtoupper($name) . "%'");
                $query = $this->db->query("SELECT * FROM geopos_invoices WHERE invoice_type_id=37 and  UPPER(invoice_name)  LIKE '%" . strtoupper($name) . "%'");
                $result = $query->result_array();

                echo '<ol>';

                $i = 1;

                foreach ($result as $row) {
                    $csd=$row['id'];

                    $kalan_total=$row['total']-$row['last_balance'];
                    $kalan_kdv_total=0;

                    echo "<li onClick=\"selectFactor('"
                        . $csd . "','"
                        . $row['invoice_no'] . " ','"
                        . 0 . "','"
                        . $row['id'] . "',
                        '',
                        '',0,0,0,0,

                '"
                        . $row['invoice_name'] .'-'. $row['invoice_no'].' Kalan Tutar('. amountFormat($kalan_total).',)'.' Kalan KDV Tutar('. amountFormat($kalan_kdv_total).')'."','0','$kalan_total')\"><span>$i</span><p>" . $row['invoice_name']  .' Kalan Tutar: '.' ('. amountFormat($kalan_total).')'. "</p></li>";

                    $i++;

                }

                echo '</ol>';

            }
        }







    }



    public function pos_c_search()

    {

        $result = array();

        $out = array();

        $name = $this->input->get('keyword', true);

        $whr = '';

        if ($this->aauth->get_user()->loc) {

            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';

        }



        if ($name) {

            $query = $this->db->query("SELECT id,name,phone,discount_c FROM geopos_customers WHERE $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");

            $result = $query->result_array();

            echo '<ol>';

            $i = 1;

            foreach ($result as $row) {

                echo "<li onClick=\"PselectCustomer('" . $row['id'] . "','" . $row['name'] . " ','" . $row['discount_c'] . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";

                $i++;

            }

            echo '</ol>';

        }



    }





    public function supplier()

    {

        $result = array();

        $out = array();

        $name = $this->input->get('keyword', true);



        $whr = '';

        if ($this->aauth->get_user()->loc) {

            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';

        }

        if ($name) {

            $query = $this->db->query("SELECT id,name,address,city,phone,email FROM geopos_supplier WHERE $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");

            $result = $query->result_array();

            echo '<ol>';

            $i = 1;

            foreach ($result as $row) {

                echo "<li onClick=\"selectSupplier('" . $row['id'] . "','" . $row['name'] . " ','" . $row['address'] . "','" . $row['city'] . "','" . $row['phone'] . "','" . $row['email'] . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";

                $i++;

            }

            echo '</ol>';

        }



    }

    public function credit_sorgu()
    {
        $out=array();
        $messages='';
        $total=0;

        $invoice_type = $this->input->post('invoice_type', true);
        //$credit = $this->input->post('credit', true);
        $cid = $this->input->post('cid', true);

        $sql=$this->db->query("SELECT * FROM geopos_customers WHERE id =$cid");
        $customer = $sql->row_array();

//        if($invoice_type==1)
//        {
//            $query = $this->db->query("SELECT geopos_invoices.*,'all_fatura' as Fatura_Durumu FROM `geopos_invoices` WHERE `csd`=$cid and invoice_type_id=1 and invoiceduedate < DATE_SUB(NOW(), INTERVAL 1 MONTH) UNION ALL
//SELECT geopos_invoices.*,'one_fatura' as Fatura_Durumu  FROM `geopos_invoices` WHERE `csd`=$cid and invoice_type_id=1 and invoiceduedate > DATE_SUB(NOW(), INTERVAL 1 MONTH)
//
//");
//
//            $result = $query->result_array();
//            if($result)
//            {
//                foreach ($result as $row)
//                {
//                    if($row['Fatura_Durumu']=='all_fatura')
//                    {
//                        $total+=$row['total'];
//                        $messages= $this->lang->line('all_fatura_messages');
//                        $out=array(
//                            'status'=>0,
//                            'messages'=>$messages,
//                            'total'=>$total
//                        );
//                    }
//                    else if($row['Fatura_Durumu']=='one_fatura')
//                    {
//                        $total+=$row['total'];
//                        $messages=sprintf($this->lang->line('one_fatura_messages'),amountFormat($customer['credit']),amountFormat($total));
//                        $out=array(
//                            'status'=>1,
//                            'messages'=>$messages,
//                            'total'=>$total
//                        );
//                    }
//                }
//
//
//            }
//            else
//            {
//                $out=array(
//                    'status'=>1,
//                    'messages'=>'',
//                    'total'=>0
//                );
//            }
//        }
//        else
//        {
//            $out=array(
//                'status'=>1,
//                'messages'=>'',
//                'total'=>0
//            );
//        }

        $out=array(
            'status'=>1,
            'messages'=>'',
            'total'=>0
        );
        echo json_encode($out);

    }

    public function pos_search()

    {



        $out = '';

        $name = $this->input->post('name', true);

        $cid = $this->input->post('cid', true);

        $invoice_type = $this->input->post('invoice_type', true);

        $wid = $this->input->post('wid', true);

        $qw = '';

        $join = '';

        $slc='geopos_products.product_price,geopos_products.pid,geopos_products.product_name,
geopos_products.product_price,geopos_products.product_code,geopos_products.taxrate,0 as disrate,
geopos_products.product_des,geopos_product_to_warehouse.qty,geopos_products.unit  ';

        if ($wid > 0) {

            if($invoice_type==1)
            {
                $qw = "geopos_product_to_warehouse.warehouse_id='$wid' AND (";
                $join = "INNER JOIN geopos_product_to_warehouse ON geopos_product_to_warehouse.product_id = geopos_products.pid";

            }


            else
            {
                $qw = " (";
                $slc='geopos_products.fproduct_price,geopos_products.pid,geopos_products.product_name,
geopos_products.product_price,geopos_products.product_code,geopos_products.taxrate,0 as disrate,
geopos_products.product_des,0 as qty,geopos_products.unit  ';

            }

        }



        $bar = '';

        $query = "SELECT $slc FROM geopos_products $join WHERE geopos_products.product_type NOT IN(6,7)AND( " . $qw . "(UPPER(geopos_products.product_name) LIKE
         '%" . strtoupper($name) . "%' $bar OR geopos_products.product_code LIKE '" . strtoupper($name) . "%') AND
          (geopos_products.qty>0) ) LIMIT 16";

        if (is_numeric($name)) {

            //       $barcode = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);





            $b = array('-', '-', '-');

            $c = array(3, 4, 11);

            $barcode = $name;

            for ($i = count($c) - 1; $i >= 0; $i--) {

                $barcode = substr_replace($barcode, $b[$i], $c[$i], 0);

            }



            //    echo(substr($barcode, 0, -1));

            $bar = " (geopos_products.barcode LIKE '" . (substr($barcode, 0, -1)) ."%')";

            $query = "SELECT $slc FROM geopos_products $join WHERE " . $qw . " $bar AND (geopos_products.qty>0) LIMIT 16";



        }





        $query = $this->db->query($query);



        $result = $query->result_array();

        $i = 0;

        if(isset($result))
        {
            echo '<div class="row">';

            foreach ($result as $row) {

                // $name = array($row['product_name'],$row['fproduct_price'],$row['pid'],$row['taxrate'],$row['disrate'],$row['product_des'] , $row_num);

                $out .= '    <div class="col-xs-3 "><div class="card round" style="width: 100%;">

                                 <a   id="posp'.$i.'"  style="height: 110pt;width: 100%;overflow: hidden;" class="select_pos_item btn btn-outline-light-blue round"
                                        data-name="' . $row['product_name'] . '"
                                        data-price=" ' . $row['product_price'] . '"
                                        data-tax="' . $row['taxrate'] . '"
                                        data-discount="' . $row['disrate'] . '"
                                        data-pcode="' . $row['product_code'] . '"
                                        data-pid="' . $row['pid'] . '"
                                        data-stock="' . $row['qty'] . '"
                                        data-unit="' . $row['unit'] . '" >

                                        <img class="round"

                                             src="' . base_url('userfiles/product/' . $row['image']) . '"  style="max-height: 70%;max-width: 90%">

                                        <div class="text-xs-center text">



                                            <small style="white-space: pre-wrap;">' . $row['product_name'] . '</small>





                                        </div></a>



                                </div></div>';



                $i++;

                if ($i % 4 == 0) $out .= '</div><div class="row">';

            }
        }





        echo $out;



    }



    public function v2_pos_search()

    {



        $out = '';

        $name = $this->input->post('name', true);

        $cid = $this->input->post('cid', true);

        $wid = $this->input->post('wid', true);

        $qw = '';

        if ($wid > 0) {

            $qw .= "(geopos_products.warehouse='$wid') AND ";

        }

        if ($cid > 0) {

            $qw .= "(geopos_products.pcat='$cid') AND ";

        }

        $join = '';

        if ($this->aauth->get_user()->loc) {

            $join = 'LEFT JOIN geopos_warehouse ON geopos_warehouse.id=geopos_products.warehouse';

            $qw .= '(geopos_warehouse.loc=' . $this->aauth->get_user()->loc . ' OR geopos_warehouse.loc=0) AND ';

        }

        $bar = '';

        $query = "SELECT geopos_products.* FROM geopos_products $join WHERE " . $qw . "(UPPER(geopos_products.product_name) LIKE '%" . strtoupper($name) . "%' $bar OR geopos_products.product_code LIKE '" . strtoupper($name) . "%')  LIMIT 16";

        if (is_numeric($name)) {

            //       $barcode = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);





            $b = array('-', '-', '-');

            $c = array(3, 4, 11);

            $barcode = $name;

            for ($i = count($c) - 1; $i >= 0; $i--) {

                $barcode = substr_replace($barcode, $b[$i], $c[$i], 0);

            }



            //    echo(substr($barcode, 0, -1));

            $bar = " (geopos_products.barcode LIKE '" . (substr($barcode, 0, -1)) ."%')";

            $query = "SELECT geopos_products.* FROM geopos_products $join WHERE " . $qw . " $bar  LIMIT 16";



        }





        $query = $this->db->query($query);



        $result = $query->result_array();

        $i = 0;

        echo '<div class="row">';

        foreach ($result as $row) {

            // $name = array($row['product_name'],$row['fproduct_price'],$row['pid'],$row['taxrate'],$row['disrate'],$row['product_des'] , $row_num);

            $out .= '    <div class="col-xs-2" style="padding-right: 1.05rem;padding-left: 1.05rem;"><div class="card round" style="width: 100%;">

                                 <a  id="posp'.$i.'" style="height: 110pt;width: 100%;overflow: hidden;" class="v2_select_pos_item btn btn-outline-light-blue round"   data-name="' . $row['product_name'] . '"  data-price=" ' . $row['product_price'] . '"  data-tax="' . $row['taxrate'] . '"  data-discount="' . $row['disrate'] . '"   data-pcode="' . $row['product_code'] . '"   data-pid="' . $row['pid'] . '"  data-stock="' . $row['qty'] . '" data-unit="' . $row['unit'] . '" >

                                        <img class="round"

                                             src="' . base_url('userfiles/product/' . $row['image']) . '"  style="max-height: 70%;max-width: 90%">

                                        <div class="text-xs-center text">



                                            <small style="white-space: pre-wrap;">' . $row['product_code'] . '</small>





                                        </div></a>



                                </div></div>';



            $i++;

            if ($i % 6 == 0) $out .= '</div><div class="row">';

        }



        echo $out;



    }

    public function search_mamul()

    {

        $result = array();

        $out = array();

        $row_num = $this->input->post('row_num', true);

        $name = $this->input->post('name_startsWith', true);


        $join = '';
        $loc =  $this->session->userdata('set_firma_id');

        if ($name) {

            $query = $this->db->query("SELECT geopos_products.pid,geopos_products.product_name,geopos_products.product_price,geopos_products.product_code,
geopos_products.taxrate,0 as disrate,geopos_products.product_des,geopos_products.qty,geopos_products.unit
 FROM geopos_products $join WHERE geopos_products.loc=$loc and (geopos_products.product_name LIKE '%" . $name . "%' OR geopos_products.product_code LIKE '" . $name . "%')  LIMIT 50");



            $result = $query->result_array();

            if($result)

            {
                foreach ($result as $row) {

                    $name = array($row['product_name'], $row['product_price'], $row['pid'], $row['taxrate'], $row['disrate'], $row['product_des'], $row['unit'], $row['product_code'], $row['qty'], $row_num);

                    array_push($out, $name);

                }
            }

            else
            {
                $names=array('Mamül Bulunamadı',0,0);
                array_push($out, $names);
            }


            echo json_encode($out);

        }




    }

    public function kur_al()
    {

        $para_birimi = $this->input->post('para_birimi', true);
        $invoice_date = $this->input->post('invoice_date', true);





        $para_birimi_post=para_birimi_ogren($para_birimi);
        $date= str_replace("-",".",$invoice_date);



        $this->session->set_userdata('para_birimi',$para_birimi_post);




        $data=doviz($para_birimi,$date);
        echo $data;

    }
    public function iscilik_fiyati_al()
    {
        $product_id = $this->input->post('product_id', true);
        $res=$this->db->query('SELECT iscilik_price From geopos_products WHERE pid='.$product_id)->row_array();

        echo $res['iscilik_price'];

    }

    public function curr_degis()
    {

        $para_birimi_post = $this->input->post('para_birimi', true);
        $para_birimi=para_birimi_ogren($para_birimi_post);

        $this->session->set_userdata('para_birimi',$para_birimi);


        //echo $para_birimi;
        $loc = $this->input->post('loc', true);
        $data=currency($loc,$para_birimi);
        echo $data;

    }

    public function csearchfis()

    {

        $result = array();

        $out = array();

        $name = $this->input->get('keyword', true);
        $cari_type = $this->input->get('cari_type', true);

        $whr = '';

        if ($this->aauth->get_user()->loc) {

            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';

        }





        if ($name) {

            if($cari_type==1)
            {
                $query = $this->db->query("SELECT id,name,address,city,phone,email,discount_c,credit,company FROM geopos_customers WHERE $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(company)  LIKE '%" . strtoupper($name) . "%'    OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");


                $result = $query->result_array();

                echo '<ol>';

                $i = 1;

                foreach ($result as $row) {


                    echo "<li onClick=\"selectCustomerFis('" . $row['id'] . "','" . $row['company']  . "')\"><span>$i</span><p>" . $row['company'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";




                    $i++;

                }
            }
            else
            {
                $query = $this->db->query("SELECT id,name, null as address, null as city, null as phone, null as email, null as discount_c, null as credit, null as company FROM geopos_projects WHERE (UPPER(name)  LIKE '%" . strtoupper($name) . "%') LIMIT 6");


                $result = $query->result_array();

                echo '<ol>';

                $i = 1;

                foreach ($result as $row) {


                    echo "<li onClick=\"selectCustomerFis('" . $row['id'] . "','" . $row['name']  . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";




                    $i++;

                }
            }



            echo '</ol>';

        }



    }

    public function csearchform()

    {

        $result = array();

        $out = array();

        $name = $this->input->get('keyword', true);
        $cari_type = $this->input->get('cari_type', true);

        $whr = '';

        if ($this->aauth->get_user()->loc) {

            $whr = ' (loc=' . $this->aauth->get_user()->loc . ' OR loc=0) AND ';

        }





        if ($name) {

            if($cari_type==1)
            {
                $query = $this->db->query("SELECT id,name,address,city,phone,email,discount_c,credit,company FROM geopos_customers WHERE $whr (UPPER(name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(company)  LIKE '%" . strtoupper($name) . "%'    OR UPPER(phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");


                $result = $query->result_array();

                echo '<ul>';

                $i = 1;

                foreach ($result as $row) {


                    echo "<li onClick=\"selectCustomerFis('" . $row['id'] . "','" . $row['company']  . "')\"><p>" . $row['company'] . "</p></li>";




                    $i++;

                }
                echo '</ul>';
            }
            else
            {
                $query = $this->db->query("SELECT id,name, null as address, null as city, null as phone, null as email, null as discount_c, null as credit, null as company FROM geopos_projects WHERE geopos_projects.status!=4 and (UPPER(name)  LIKE '%" . strtoupper($name) . "%') LIMIT 6");


                $result = $query->result_array();

                echo '<ol>';

                $i = 1;

                foreach ($result as $row) {


                    echo "<li onClick=\"selectProjectFis('" . $row['id'] . "','" . $row['name']  . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";




                    $i++;

                }
                echo '</ol>';
            }





        }



    }


    public function paketleme_hesapla()
    {
        $adet = $this->input->post('qty', true);
        $product_id = $this->input->post('product_id', true);
        $paketleme_miktari=paketleme_miktari($product_id);

        $kalan=$adet%$paketleme_miktari;
        if($kalan==0)
        {
            echo 0;
        }
        else
        {
            echo 1;
        }

    }

    public function list_employee()

    {


        $this->db->select('geopos_employees.*,geopos_users.banned,geopos_users.roleid,geopos_users.loc');
        $this->db->from('geopos_employees');
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');
        $this->db->order_by('geopos_users.id', 'DESC');
        $query = $this->db->get();


        $result = $query->result_array();

        echo json_encode($result);

    }

    public function hesap_getir()
    {
        $ana_cari_id  = $this->input->post('ana_cari_id', true);
        $invoice_list=$this->db->query("SELECT * FROM `geopos_cari_hesap`WHERE geopos_cari_hesap.ana_cari_id=$ana_cari_id ")->result();
        $data=array();
        foreach ($invoice_list as $l)
        {
            $data[]=array(
                'id'=>$l->id,
                'invoice_id'=>$l->invoice_id,
                'notes'=>'',
                'tutar'=>amountFormat($l->tutar),
                'tutar_o'=>$l->tutar
            );
        }

        echo json_encode($data);
    }


    public function islem_listesi_getir()
    {
        $islem_tipi = $this->input->post('islem_tipi', true);
        $alt_customer_id = $this->input->post('alt_customer_id', true);
        $alacakak_borc = $this->input->post('alacakak_borc', true);

        $invoice_list=array();

        if($islem_tipi==2) // Finans İşlemleri (Alt carinin faturalarına istinaden  işlemleri)
        {

            if($alacakak_borc==39) // tahsilatlar
            {
                $invoice_list=$this->db->query("SELECT geopos_invoices.*,geopos_invoice_transactions.invoice_id FROM `geopos_invoices` LEFT JOIN geopos_invoice_transactions ON geopos_invoices.id=geopos_invoice_transactions.transaction_id WHERE geopos_invoices.csd=$alt_customer_id and geopos_invoices.invoice_type_id=18 ORDER BY geopos_invoices.invoicedate DESC")->result();


            }
            else //ödemeler
            {
                $invoice_list=$this->db->query("SELECT geopos_invoices.*,geopos_invoice_transactions.invoice_id FROM `geopos_invoices` LEFT JOIN geopos_invoice_transactions ON geopos_invoices.id=geopos_invoice_transactions.transaction_id WHERE geopos_invoices.csd=$alt_customer_id and geopos_invoices.invoice_type_id=17 ORDER BY geopos_invoices.invoicedate DESC")->result();


            }
        }

        else if($islem_tipi==3) // KDV İşlemleri (alt carinin kdv tahsilat)
        {
            if($alacakak_borc==40) // ödemeler
            {
                $invoice_list=  $this->db->query("SELECT geopos_invoices.*,geopos_invoice_transactions.invoice_id FROM `geopos_invoices` LEFT JOIN geopos_invoice_transactions ON geopos_invoices.id=geopos_invoice_transactions.transaction_id WHERE geopos_invoices.csd=$alt_customer_id and geopos_invoices.invoice_type_id=19 ORDER BY geopos_invoices.invoicedate DESC")->result();
            }
            else //tahsilat
            {
                $invoice_list=  $this->db->query("SELECT geopos_invoices.*,geopos_invoice_transactions.invoice_id FROM `geopos_invoices` LEFT JOIN geopos_invoice_transactions ON geopos_invoices.id=geopos_invoice_transactions.transaction_id WHERE geopos_invoices.csd=$alt_customer_id and geopos_invoices.invoice_type_id=20 ORDER BY geopos_invoices.invoicedate DESC ORDER BY invoicedate DESC")->result();
            }
        }

        $data=array();
        foreach ($invoice_list as $l)
        {
            $data[]=array(
                'id'=>$l->id,
                'invoice_id'=>$l->invoice_id,
                'note'=>$l->notes,
                'tutar'=>amountFormat($l->total),
                'tutar_o'=>$l->total
            );
        }

        echo json_encode($data);


    }

    public function invoice_id_getir()
    {
        $islem_listesi_id = $this->input->post('islem_listesi_id', true);
        $invoice_list=  $this->db->query("SELECT * FROM geopos_invoice_transactions Where transaction_id=$islem_listesi_id")->row();
        echo $invoice_list->invoice_id;
    }




}
