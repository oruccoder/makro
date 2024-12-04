<?php

use Mpdf\Tag\Input;

defined('BASEPATH') or exit('No direct script access allowed');


class UrunModel extends CI_Model
{
    var $table_news = 'stock_io ';

    var $column_order = array('geopos_products.pid',null,'geopos_products.product_name','geopos_products.product_name_tr','geopos_products.product_name_en','geopos_product_cat.title','geopos_product_type.name','geopos_products.product_code','geopos_products.barcode','geopos_products.onay_durumu');

    var $column_search = array('geopos_products.product_code', 'geopos_products.tag', 'geopos_products.product_name', 'geopos_products.product_name_tr', 'geopos_products.product_name_en', 'geopos_product_cat.title', 'geopos_products.product_des', 'geopos_products.barcode');


    var $column_order_p = array('product_stock_code.id',null,'product_stock_code.code','geopos_products_parent.product_name','geopos_products_parent.product_name_tr','geopos_products_parent.product_name_en','geopos_product_cat.title','geopos_product_type.name','geopos_products.product_code',null,null);

    var $column_search_p = array('product_stock_code.code', 'geopos_products_parent.product_name', 'geopos_products_parent.product_name_tr', 'geopos_products_parent.product_name_en');





    var $column_report_op = array(null,'talep_form.id','talep_form.proje_id','geopos_products.pid','talep_form_products.product_stock_code_id','talep_form_products.product_qty',null);

    var $column_report_sp = array('talep_form.code','geopos_projects.code','geopos_products.product_name','product_stock_code.code','talep_form_products.product_qty');





    var $urun=array('geopos_products.pid','DESC');
    var $urun_p=array('geopos_products.pid','DESC');

    // var $column_search_transfer = [
    //     'stock_transfer.code',
    //     'stock_transfer.out_warehouse_id',
    //     'stock_transfer.in_warehouse_id',
    //     'geopos_geopos_products.product_name',
    //     'stock_transfer_items.qty',
    //     'geopos_units.name',
    //     'stock_transfer_item_notification.new_qty',
    //     'stock_transfer_items.desc',
    //     'geopos_employees.name'
    // ];

    // var $order = array('stock_transfer.id' => 'DESC');
    // var $mahsul = array('geopos_products.id' => 'DESC');


    public function __construct()
    {
        parent::__construct();
    }


    public function get_datatables_query_details_list()
    {
        $this->_get_datatables_query_details_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        //echo $this->db->last_query();die();

        return $query->result();
    }


    private function _get_datatables_query_details_list()
    {

        $this->db->select('geopos_products.* ,geopos_product_cat.title as category_name, geopos_product_type.name as product_type_name');
        $this->db->from('geopos_products');

        $this->db->join('geopos_product_cat', 'geopos_products.pcat=geopos_product_cat.id','LEFT');
        //$this->db->join('geopos_products_parent', 'geopos_products.pid=geopos_products_parent.product_id','LEFT');

        $this->db->join('geopos_product_type', 'geopos_products.product_type=geopos_product_type.id');
        $this->db->where('geopos_products.deleted_at', NULL, FALSE);
        $i = 0;




        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_products.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        if($this->input->post('category_id'))
        {
            $cat_id = $this->input->post('category_id');

            //echo "<pre>";print_r(_ust_kategori_kontrol_return_array($cat_id));

            $parent_kontrol = $this->db->query("SELECT * FROM geopos_product_cat Where id = $cat_id");
            $this->db->where_in('geopos_products.pcat', _ust_kategori_kontrol_return_array($cat_id));




        }
        foreach ($this->column_search as $item) // loop column
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

                if (count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke

            }

            $i++;
        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->urun)) {

            $this->db->order_by('geopos_products.pid','DESC');
        }

        $this->db->group_by('geopos_products.pid');

    }


    public function count_filtered()
    {
        $this->_get_datatables_query_details_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_get_datatables_query_details_list();
        return $this->db->count_all_results();
    }

    public function create_save()
    {
        $this->load->model('projestoklari_model', 'stok');
        $product_code = $this->input->post('product_code');

        $user_id = $this->aauth->get_user()->id;



        $barcode = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);;
        $sort_name = isEmptyFunction($this->input->post('short_name'),$product_code);
        $product_code = isEmptyFunction($this->input->post('product_code'),numaric(21));
        $data = array(
            'product_name' =>  $this->input->post('product_name'),
            'tag' =>  $this->input->post('tag'),
            'auth_id' =>  $user_id,
            'pcat' => $this->input->post('category_id'),
            'image' => 'userfiles/product/' . $this->input->post('image'),
            'product_des' => $this->input->post('product_description'),
            'barcode' => $barcode, //$this->input->post('barcode'),
            'product_type' => $this->input->post('pro_type'),
           // 'product_code'=>$this->input->post('product_code'),
            'product_code'=>$product_code,
            'product_name_tr'=>$this->input->post('product_name_tr'),
            'product_name_en'=>$this->input->post('product_name_en'),
            'short_name'=>$sort_name,
            'marka'=>$this->input->post('marka'),
            'kalinlik'=>$this->input->post('kalinlik'),
            'en'=>$this->input->post('en'),
            'boy'=>$this->input->post('boy'),
            'yukseklik'=>$this->input->post('yukseklik'),
            'yogunluk'=>$this->input->post('yogunluk'),
            'ic_cap'=>$this->input->post('ic_cap'),
            'dis_cap'=>$this->input->post('dis_cap'),
            't'=>$this->input->post('t'),
            'alert'=>$this->input->post('emniyet_stok'),
            'min_sip_mik'=>$this->input->post('min_sip_mik'),
            'siparis_katlari'=>$this->input->post('siparis_katlari'),
            'iskarta_orani'=>$this->input->post('iskarta_orani'),
            'uretim_katsayisi'=>$this->input->post('uretim_katsayisi'),
            'palet'=>$this->input->post('palet'),
            'denye'=>$this->input->post('denye'),
            'brut_agirlik'=>$this->input->post('brut_agirlik'),
            'net_agirlik'=>$this->input->post('net_agirlik'),
            'gercek'=>$this->input->post('gercek'),
            'status'=>$this->input->post('status'),
            'standart_code'=>$this->input->post('standart_code'),
            'ozel_kod_1'=>$this->input->post('ozel_kod_1'),
            'ozel_kod_2'=>$this->input->post('ozel_kod_2'),
            'ozel_kod_3'=>$this->input->post('ozel_kod_3'),
            'baz_miktari'=>$this->input->post('baz_miktari'),
            'fire_stok_kodu'=>$this->input->post('fire_stok_kodu'),
            'pcat'=>$this->input->post('mg_1'),
            'mg_1'=>$this->input->post('mg_1'),
            'mg_2'=>$this->input->post('mg_2'),
            'mg_3'=>$this->input->post('mg_3'),
            'mg_4'=>$this->input->post('mg_4'),
            'mg_5'=>$this->input->post('mg_5'),
            'unit'=>$this->input->post('unit'),
            'unit_2'=>$this->input->post('unit_2'),
            'satinalama_siparis_birimi'=>$this->input->post('satinalama_siparis_birimi'),
            'satinalama_kabul_birimi'=>$this->input->post('satinalama_kabul_birimi'),
            'satis_birimi'=>$this->input->post('satis_birimi'),
            'temin_turu'=>$this->input->post('temin_turu'),
            'satinalma_turu'=>$this->input->post('satinalma_turu'),
            'imalat_siparis_birimi'=>$this->input->post('imalat_siparis_birimi'),
            'rapor_birimi'=>$this->input->post('rapor_birimi'),
            'satinalma_suresi'=>$this->input->post('satinalma_suresi'),
            'imalat_tedarik_suresi'=>$this->input->post('imalat_tedarik_suresi'),
            'taxrate'=>$this->input->post('kdv'),
            'ean'=>$this->input->post('ean'),
            'kullanim_yeri'=>$this->input->post('kullanim_yeri'),
            'color'=>$this->input->post('color'),
            'loc' => $this->session->userdata('set_firma_id'),
            'created_at' => date('Y-m-d H:i:s'),
        );

        if ($this->db->insert('geopos_products', $data)) {
            $operator= "deger+1";
            $this->db->set('deger', "$operator", FALSE);
            $this->db->where('tip', 21);
            $this->db->update('numaric');
            return [
                'status' => 1,
            ];
        } else {
            return [
                'status' => 0,
            ];
        }
    }



    public function update_tag()
    {
        $product_id =  $this->input->post('product_id');
        $types =  $this->input->post('types');
        $tag =  $this->input->post('tag');
        $geopos_products = array(
            'tag' =>  $tag
        );

        $id_val='pid';
        if($types=='geopos_products_parent'){
            $id_val="product_stock_code_id";
        }

        if ($this->db->where([$id_val => $product_id])->update($types, $geopos_products)) {
            return [
                'status' => 1,
            ];
        } else {
            return [
                'status' => 0,
            ];
        }

    }
    public function update()
    {
        // echo $this->input->post('id') . '<br>';
        // echo $this->input->post('category_id') . '<br>';
        // echo $this->input->post('product_name') . '<br>';
        // echo $this->input->post('product_description') . '<br>';
        // echo $this->input->post('pro_type') . '<br>';
        // echo $this->input->post('image');die;
        // die;
        $product_id =  $this->input->post('product_id');
        $geopos_products = array(
            'product_name' =>  $this->input->post('product_name'),
            'pcat' => $this->input->post('category_id'),
            'tag' =>  $this->input->post('tag'),
            'image' => $this->input->post('image'),
            'product_des' => $this->input->post('product_description'),
            'product_type' => $this->input->post('pro_type'),
            'product_code'=>$this->input->post('product_code'),
            'product_name_tr'=>$this->input->post('product_name_tr'),
            'product_name_en'=>$this->input->post('product_name_en'),
            'short_name'=>$this->input->post('short_name'),
            'marka'=>$this->input->post('marka'),
            'kalinlik'=>$this->input->post('kalinlik'),
            'en'=>$this->input->post('en'),
            'boy'=>$this->input->post('boy'),
            'yukseklik'=>$this->input->post('yukseklik'),
            'yogunluk'=>$this->input->post('yogunluk'),
            'ic_cap'=>$this->input->post('ic_cap'),
            'dis_cap'=>$this->input->post('dis_cap'),
            't'=>$this->input->post('t'),
            'alert'=>$this->input->post('emniyet_stok'),
            'min_sip_mik'=>$this->input->post('min_sip_mik'),
            'siparis_katlari'=>$this->input->post('siparis_katlari'),
            'iskarta_orani'=>$this->input->post('iskarta_orani'),
            'uretim_katsayisi'=>$this->input->post('uretim_katsayisi'),
            'palet'=>$this->input->post('palet'),
            'denye'=>$this->input->post('denye'),
            'brut_agirlik'=>$this->input->post('brut_agirlik'),
            'net_agirlik'=>$this->input->post('net_agirlik'),
            'gercek'=>$this->input->post('gercek'),
            'status'=>$this->input->post('status'),
            'standart_code'=>$this->input->post('standart_code'),
            'ozel_kod_1'=>$this->input->post('ozel_kod_1'),
            'ozel_kod_2'=>$this->input->post('ozel_kod_2'),
            'ozel_kod_3'=>$this->input->post('ozel_kod_3'),
            'baz_miktari'=>$this->input->post('baz_miktari'),
            'fire_stok_kodu'=>$this->input->post('fire_stok_kodu'),
            'pcat'=>$this->input->post('mg_1'),
            'mg_1'=>$this->input->post('mg_1'),
            'mg_2'=>$this->input->post('mg_2'),
            'mg_3'=>$this->input->post('mg_3'),
            'mg_4'=>$this->input->post('mg_4'),
            'mg_5'=>$this->input->post('mg_5'),
            'unit'=>$this->input->post('unit'),
            'unit_2'=>$this->input->post('unit_2'),
            'satinalama_siparis_birimi'=>$this->input->post('satinalama_siparis_birimi'),
            'satinalama_kabul_birimi'=>$this->input->post('satinalama_kabul_birimi'),
            'satis_birimi'=>$this->input->post('satis_birimi'),
            'temin_turu'=>$this->input->post('temin_turu'),
            'satinalma_turu'=>$this->input->post('satinalma_turu'),
            'imalat_siparis_birimi'=>$this->input->post('imalat_siparis_birimi'),
            'rapor_birimi'=>$this->input->post('rapor_birimi'),
            'satinalma_suresi'=>$this->input->post('satinalma_suresi'),
            'imalat_tedarik_suresi'=>$this->input->post('imalat_tedarik_suresi'),
            'taxrate'=>$this->input->post('kdv'),
            'ean'=>$this->input->post('ean'),
            'kullanim_yeri'=>$this->input->post('kullanim_yeri'),
            'color'=>$this->input->post('color'),
            'image' => $this->input->post('image'),
//            'product_name' =>  $this->input->post('product_name'),
//            'pcat' => $this->input->post('category_id'),
//            'image' => $this->input->post('image'),
//            'product_des' => $this->input->post('product_description'),
//            'product_type' => $this->input->post('pro_type'),
//            'simeta_product_name' => $this->input->post('simeta_product_name'),
//            'simeta_code' => $this->input->post('simeta_code'),
//            'demirbas_id' => $this->input->post('demirbas_id'),
            'updated_at' => date('Y-m-d H:i:s'),
        );
        // print_r($geopos_products);
        if ($this->db->where(['pid' => $product_id])->update('geopos_products', $geopos_products)) {
            return [
                'status' => 1,
            ];
        } else {
            return [
                'status' => 0,
            ];
        }
    }

    public function update_parent()
    {

        // echo $this->input->post('id') . '<br>';
        // echo $this->input->post('category_id') . '<br>';
        // echo $this->input->post('product_name') . '<br>';
        // echo $this->input->post('product_description') . '<br>';
        // echo $this->input->post('pro_type') . '<br>';
        // echo $this->input->post('image');die;
        // die;
        $product_id =  $this->input->post('product_id');
        $product_stock_code_id =  $this->input->post('product_stock_code_id');
        $code = $this->db->query("SELECT * FROM product_stock_code Where id=$product_stock_code_id")->row()->code;

        $id =  $this->input->post('id');

        if($id==0){
            $details = $this->details($product_id);
            $barcode = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);;
            $data = array(
                'product_name' =>  $details->product_name,
                'tag' =>  $details->tag,
                'product_id' =>  $product_id,
                'pcat' => $details->pcat,
                'product_stock_code_id'=>$product_stock_code_id,
                'image' =>  $details->image,
                'product_des' => $details->product_des,
                'barcode' => $barcode, //$this->input->post('barcode'),
                'product_type' => 1,
                // 'product_code'=>$this->input->post('product_code'),
                'product_code'=>$code,
                'product_name_tr'=>$details->product_name_tr,
                'product_name_en'=>$details->product_name_en,
                'short_name'=>$details->short_name,
                'marka'=>$details->marka,
                'kalinlik'=>$details->kalinlik,
                'en'=>$details->en,
                'boy'=>$details->boy,
                'yukseklik'=>$details->yukseklik,
                'yogunluk'=>$details->yogunluk,
                'ic_cap'=>$details->ic_cap,
                'dis_cap'=>$details->dis_cap,
                't'=>$details->t,
                'alert'=>$details->alert,
                'min_sip_mik'=>$details->min_sip_mik,
                'siparis_katlari'=>$details->siparis_katlari,
                'iskarta_orani'=>$details->iskarta_orani,
                'uretim_katsayisi'=>$details->uretim_katsayisi,
                'palet'=>$details->palet,
                'denye'=>$details->denye,
                'brut_agirlik'=>$details->brut_agirlik,
                'net_agirlik'=>$details->net_agirlik,
                'gercek'=>$details->gercek,
                'status'=>$details->status,
                'standart_code'=>$details->standart_code,
                'ozel_kod_1'=>$details->ozel_kod_1,
                'ozel_kod_2'=>$details->ozel_kod_2,
                'ozel_kod_3'=>$details->ozel_kod_3,
                'baz_miktari'=>$details->baz_miktari,
                'fire_stok_kodu'=>$details->fire_stok_kodu,
                'pcat'=>$details->pcat,
                'mg_1'=>$details->mg_1,
                'mg_2'=>$details->mg_2,
                'mg_3'=>$details->mg_3,
                'mg_4'=>$details->mg_4,
                'mg_5'=>$details->mg_5,
                'unit'=>$details->unit,
                'unit_2'=>$details->unit_2,
                'satinalama_siparis_birimi'=>$details->satinalama_siparis_birimi,
                'satinalama_kabul_birimi'=>$details->satinalama_kabul_birimi,
                'satis_birimi'=>$details->satis_birimi,
                'temin_turu'=>$details->temin_turu,
                'satinalma_turu'=>$details->satinalma_turu,
                'imalat_siparis_birimi'=>$details->imalat_siparis_birimi,
                'rapor_birimi'=>$details->rapor_birimi,
                'satinalma_suresi'=>$details->satinalma_suresi,
                'imalat_tedarik_suresi'=>$details->imalat_tedarik_suresi,
                'taxrate'=>$details->taxrate,
                'ean'=>$details->ean,
                'loc' => $details->loc,
                'created_at' => date('Y-m-d H:i:s'),
            );
            if( $this->db->insert('geopos_products_parent', $data)){
                return [
                    'status' => 1,
                    'messages'=>'Başarıyla Yeni Stok Kartı Oluştu. Sayfayı Yenileyip Tekrar Giriş Yapınız'
                ];
            }
            else {
                return [
                    'status' => 0,
                ];
            }

        }
        else {
            $geopos_products = array(
                'product_name' =>  $this->input->post('product_name'),
                'product_id' =>  $product_id,
                'pcat' => $this->input->post('category_id'),
                'pcat' => $this->input->post('category_id'),
                'tag' => $this->input->post('tag'),
                'image' => $this->input->post('image'),
                'product_des' => $this->input->post('product_description'),
                'product_type' => $this->input->post('pro_type'),
                'product_code'=>$code,
                'product_name_tr'=>$this->input->post('product_name_tr'),
                'product_name_en'=>$this->input->post('product_name_en'),
                'short_name'=>$this->input->post('short_name'),
                'marka'=>$this->input->post('marka'),
                'kalinlik'=>$this->input->post('kalinlik'),
                'en'=>$this->input->post('en'),
                'boy'=>$this->input->post('boy'),
                'yukseklik'=>$this->input->post('yukseklik'),
                'yogunluk'=>$this->input->post('yogunluk'),
                'ic_cap'=>$this->input->post('ic_cap'),
                'dis_cap'=>$this->input->post('dis_cap'),
                't'=>$this->input->post('t'),
                'alert'=>$this->input->post('emniyet_stok'),
                'min_sip_mik'=>$this->input->post('min_sip_mik'),
                'siparis_katlari'=>$this->input->post('siparis_katlari'),
                'iskarta_orani'=>$this->input->post('iskarta_orani'),
                'uretim_katsayisi'=>$this->input->post('uretim_katsayisi'),
                'palet'=>$this->input->post('palet'),
                'denye'=>$this->input->post('denye'),
                'brut_agirlik'=>$this->input->post('brut_agirlik'),
                'net_agirlik'=>$this->input->post('net_agirlik'),
                'gercek'=>$this->input->post('gercek'),
                'status'=>$this->input->post('status'),
                'standart_code'=>$this->input->post('standart_code'),
                'ozel_kod_1'=>$this->input->post('ozel_kod_1'),
                'ozel_kod_2'=>$this->input->post('ozel_kod_2'),
                'ozel_kod_3'=>$this->input->post('ozel_kod_3'),
                'baz_miktari'=>$this->input->post('baz_miktari'),
                'fire_stok_kodu'=>$this->input->post('fire_stok_kodu'),
                'pcat'=>$this->input->post('mg_1'),
                'mg_1'=>$this->input->post('mg_1'),
                'mg_2'=>$this->input->post('mg_2'),
                'mg_3'=>$this->input->post('mg_3'),
                'mg_4'=>$this->input->post('mg_4'),
                'mg_5'=>$this->input->post('mg_5'),
                'unit'=>$this->input->post('unit'),
                'unit_2'=>$this->input->post('unit_2'),
                'satinalama_siparis_birimi'=>$this->input->post('satinalama_siparis_birimi'),
                'satinalama_kabul_birimi'=>$this->input->post('satinalama_kabul_birimi'),
                'satis_birimi'=>$this->input->post('satis_birimi'),
                'temin_turu'=>$this->input->post('temin_turu'),
                'satinalma_turu'=>$this->input->post('satinalma_turu'),
                'imalat_siparis_birimi'=>$this->input->post('imalat_siparis_birimi'),
                'rapor_birimi'=>$this->input->post('rapor_birimi'),
                'satinalma_suresi'=>$this->input->post('satinalma_suresi'),
                'imalat_tedarik_suresi'=>$this->input->post('imalat_tedarik_suresi'),
                'taxrate'=>$this->input->post('kdv'),
                'ean'=>$this->input->post('ean'),
                'image' => $this->input->post('image'),
//            'product_name' =>  $this->input->post('product_name'),
//            'pcat' => $this->input->post('category_id'),
//            'image' => $this->input->post('image'),
//            'product_des' => $this->input->post('product_description'),
//            'product_type' => $this->input->post('pro_type'),
//            'simeta_product_name' => $this->input->post('simeta_product_name'),
//            'simeta_code' => $this->input->post('simeta_code'),
//            'demirbas_id' => $this->input->post('demirbas_id'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            // print_r($geopos_products);
            if ($this->db->where(['id' => $id])->update('geopos_products_parent', $geopos_products)) {
                return [
                    'status' => 1,
                ];
            } else {
                return [
                    'status' => 0,
                ];
            }
        }

    }

    public function parent_image_update()
    {


        $product_stock_code_id = $this->input->post('product_stock_code_id');
        $geopos_products = array(

            'image' => $this->input->post('image_text_update_new'),
        );
        // print_r($geopos_products);
        if ($this->db->where(['product_stock_code_id' => $product_stock_code_id])->update('geopos_products_parent', $geopos_products)) {
            return [
                'status' => 1,
            ];
        } else {
            return [
                'status' => 0,
            ];
        }

    }


    public function delete()
    {
        $product_id =  $this->input->post('product_id');
        $stock_kontrol = stock_qty($product_id);



        if(count($stock_kontrol)==0){
            if ($this->db->where(['pid' => $product_id])->update('geopos_products', ['deleted_at' => date('Y-m-d H:i:s')])) {
                $this->db->delete('product_to_options', array('product_id' => $product_id));
                return [
                    'status' => 1,
                    'messages'=>'Başarıyla Silindi'
                ];
            } else {
                return [
                    'status' => 0,
                    'messages'=>'Hata Aldınız. Yöneticiye Başvurun'
                ];
            }
        }
        else {
            return [
                'status' => 0,
                'messages'=>'Bu Üründen Depolarda Mevcut Olduğundan Stok Kartı Silinemez'
            ];
        }


    }

    public function onay()
    {
        $product_id =  $this->input->post('product_id');
            if ($this->db->where(['pid' => $product_id])->update('geopos_products', ['onay_durumu' => 1])) {
                $this->aauth->applog("urun Onaylandı. Urun ID : " . $product_id, $this->aauth->get_user()->username);

                return [
                    'status' => 1,
                    'messages'=>'Başarıyla Silindi'
                ];
            } else {
                return [
                    'status' => 0,
                    'messages'=>'Hata Aldınız. Yöneticiye Başvurun'
                ];
            }

    }


    public function details_item($product_id)
    {
        $this->db->select('*');
        $this->db->from('geopos_products');
        $this->db->where('pid', $product_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function details_item_parent($product_id)
    {
        $this->db->select('*');
        $this->db->from('geopos_products_parent');
        $this->db->where('product_stock_code_id', $product_id);
        $query = $this->db->get();
        return $query->result();
    }


    public function details($product_id)
    {
        $this->db->select('*');
        $this->db->from('geopos_products');
        $this->db->where('pid', $product_id);
        $query = $this->db->get();
        return $query->row();
    }




































    public function transfer_update()
    {
        $product_details =  $this->input->post('product_details');
        $tip =  $this->input->post('tip'); //1 onay 2 iptal

        $product_list = [];
        $index = 0;


        foreach ($product_details as $items) {

            $stock_id = $items['stock_id'];
            $this->aauth->applog("Stok Transfer Talebi Güncellendi NT_ID" . $items['notifation_id'], $this->aauth->get_user()->username);
            $data_new_update = [
                'new_qty' => $items['new_qty'],
                'staff_status' => null,
                'status' => $tip,
                'id' => $items['notifation_id']
            ];
            $product_list[$index] = $data_new_update;
            $index++;
            $this->db->update_batch('stock_transfer_item_notification', $product_list, 'id');

            if ($items['type_id'] == 2) // Giriş İse Stok Güncellemesi
            {

                if ($tip == 1) // Kabul edildiyse
                {
                    $notifation_details = $this->notifation_details($items['notifation_id']);
                    $item_details = $this->item_details($notifation_details->stock_item_id);
                    $details = $this->details($item_details->stock_transfer_id);
                    $giris_depo_id = $details->in_warehouse_id;
                    $cikis_depo_id = $details->out_warehouse_id;
                    stock_update_new($item_details->product_id, $item_details->unit_id, $items['new_qty'], 1, $giris_depo_id, $this->aauth->get_user()->id, $item_details->stock_transfer_id, 4);
                    stock_update_new($item_details->product_id, $item_details->unit_id, $items['new_qty'], 0, $cikis_depo_id, $this->aauth->get_user()->id, $item_details->stock_transfer_id, 4);
                }
            } elseif ($items['type_id'] == 1) { // Çıkış Güncellemesi ise giriş deposuna mail bildir
                $data_update = array(
                    'staff_status' => 1
                );
                $this->db->where('stock_id=', $stock_id);
                $this->db->where('status', 0);
                $this->db->update('stock_transfer_item_notification', $data_update);

                // İptal varsa
                $iptal_kontrol = $this->db->query("SELECT * FROM stock_transfer_item_notification Where status=2");
                if ($iptal_kontrol->num_rows()) {
                    foreach ($iptal_kontrol as $result) {
                        $data_new_update = [
                            'staff_status' => null,
                        ];
                        $this->db->where("id", $result->id);
                        $this->db->update('stock_transfer_item_notification', $data_new_update);
                    }
                }
                // İptal varsa
            }
        }


        //$this->stocktransfer->send_mail($staff_id_cikis,'Mahsul Giriş Talebi','Yeni Bir Giriş Talebi Oluşturuldu İncelemek İçin Bildirimler Bölümüne Bakınız');



        if ($index) {
            return [
                'status' => 1,
                'message' => 'Başarılı Bir Şekilde Stok Transfer Talebi Güncellendi',
            ];
        } else {
            return [
                'status' => 0,
                'message' => 'Hata Aldınız.Lütfen Yöneyiciye Başvurun.',
                'id' => 0
            ];
        }
    }

    public function bildirim_olustur()
    {
        $talep_id = $this->input->post('talep_id');
        $this->db->set('bildirim_durumu', 1);
        $this->db->where('id', $talep_id);
        if ($this->db->update('stock_transfer')) {
            $this->aauth->applog("Stok Transfer Talep Bildirimi Oluşturuldu  : Talep ID : " . $talep_id, $this->aauth->get_user()->username);
            return 1;
        } else {
            return 0;
        }
    }


    public function notifation_details($id)
    {
        $this->db->select('*');
        $this->db->from('stock_transfer_item_notification');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function item_details($id)
    {
        $this->db->select('*');
        $this->db->from('stock_transfer_items');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function send_mail($user_id, $subject, $message)
    {
        $message .= "<br><br><br><br>";
        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
        $proje_sorumlusu_email = personel_detailsa($user_id)['email'];
        //$recipients = array($proje_sorumlusu_email);
        //$this->communication_model->onay_mail($recipients, $subject, $message, false,'', 'gider_talep_onay_maili');
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.yandex.com',
            'smtp_port' => 465,
            'smtp_user' => 'Makro2000 ERP',
            'smtp_pass' => 'bulut220618',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => true,
        ];
        $this->load->library('Email', $config);

        $this->email->from('info@makropro.az');
        $this->email->to($proje_sorumlusu_email);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }

    public function product_to_option_create_new(){
        if($this->aauth->get_user()->id==741 || $this->aauth->get_user()->id==21 ||  $this->aauth->get_user()->id==832 ||  $this->aauth->get_user()->id==1147 || $this->aauth->get_user()->id==831 || $this->aauth->get_user()->id==1094){
            $product_id = $this->input->post('product_id');
            $sistem_code = $this->input->post('sistem_code');
            $options_details_res = $this->input->post('option_details');
            $product_details = $this->details($product_id);

            //
            $pcat = $product_details->pcat;
            $cat_details = $this->db->query("SELECT * FROM geopos_product_cat Where id=$pcat");
            if($cat_details->num_rows()){
                if($cat_details->row()->product_varyant){
                    //$stock_code =$product_details->short_name;
                    $stock_code =$cat_details->row()->product_varyant;
                    $i_=0;
                    $index=0;
                    $new_code='';

                    if($options_details_res) {
                        foreach ($options_details_res as $options_details) {
                            if ($i_ === array_key_last($options_details_res)) {// first loop
                                $new_code .= $options_details['option_value_name'];
                            } else {
                                $new_code .= $options_details['option_value_name'] . '-';
                            }
                            $i_++;
                        }
                        $news_code = $stock_code . '-' . $new_code;

                        $data_option = [
                            'product_id' => $product_id,
                            'code' => $news_code,
                            'sistem_code' => $sistem_code,
                        ];
                        $this->db->insert('product_stock_code', $data_option);
                        $product_stock_code = $this->db->insert_id();


                        foreach ($options_details_res as $options_details) {
                            $option_value_id = $options_details['option_value_id'];
                            $option_id = $options_details['option_id'];
                            $product_to_option_id = $this->db->query("SELECT * FROM product_to_options Where product_id=$product_id and option_id=$option_id")->row()->id;

                            // Update Stock_code

                            $this->db->set('stock_code_id', $product_stock_code);
                            $this->db->where('id', $product_to_option_id);
                            $this->db->update('product_to_options');

                            // Update Stock_code
                            $data_option_value = [
                                'product_to_option_id' => $product_to_option_id,
                                'option_value_id' => $option_value_id,
                                'product_stock_code' => $product_stock_code,
                            ];
                            $this->db->insert('product_to_options_value', $data_option_value);
                            $index++;

                        }


                        if($index){

                            //Parent Stok Kartı
                            $details = $this->details($product_id);

                            $product_code = $sistem_code;
                            $barcode = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);;
                            $data = array(
                                'product_name' =>  $details->product_name,
                                'product_id' =>  $product_id,
                                'tag' =>  $details->tag,
                                'pcat' => $details->pcat,
                                'product_stock_code_id'=>$product_stock_code,
                                'image' =>  $details->image,
                                'product_des' => $details->product_des,
                                'barcode' => $barcode, //$this->input->post('barcode'),
                                'product_type' => 1,
                                // 'product_code'=>$this->input->post('product_code'),
                                'product_code'=>$product_code,
                                'product_name_tr'=>$details->product_name_tr,
                                'product_name_en'=>$details->product_name_en,
                                'short_name'=>$details->short_name,
                                'marka'=>$details->marka,
                                'kalinlik'=>$details->kalinlik,
                                'en'=>$details->en,
                                'boy'=>$details->boy,
                                'yukseklik'=>$details->yukseklik,
                                'yogunluk'=>$details->yogunluk,
                                'ic_cap'=>$details->ic_cap,
                                'dis_cap'=>$details->dis_cap,
                                't'=>$details->t,
                                'alert'=>$details->alert,
                                'min_sip_mik'=>$details->min_sip_mik,
                                'siparis_katlari'=>$details->siparis_katlari,
                                'iskarta_orani'=>$details->iskarta_orani,
                                'uretim_katsayisi'=>$details->uretim_katsayisi,
                                'palet'=>$details->palet,
                                'denye'=>$details->denye,
                                'brut_agirlik'=>$details->brut_agirlik,
                                'net_agirlik'=>$details->net_agirlik,
                                'gercek'=>$details->gercek,
                                'status'=>$details->status,
                                'standart_code'=>$details->standart_code,
                                'ozel_kod_1'=>$details->ozel_kod_1,
                                'ozel_kod_2'=>$details->ozel_kod_2,
                                'ozel_kod_3'=>$details->ozel_kod_3,
                                'baz_miktari'=>$details->baz_miktari,
                                'fire_stok_kodu'=>$details->fire_stok_kodu,
                                'pcat'=>$details->pcat,
                                'mg_1'=>$details->mg_1,
                                'mg_2'=>$details->mg_2,
                                'mg_3'=>$details->mg_3,
                                'mg_4'=>$details->mg_4,
                                'mg_5'=>$details->mg_5,
                                'unit'=>$details->unit,
                                'unit_2'=>$details->unit_2,
                                'satinalama_siparis_birimi'=>$details->satinalama_siparis_birimi,
                                'satinalama_kabul_birimi'=>$details->satinalama_kabul_birimi,
                                'satis_birimi'=>$details->satis_birimi,
                                'temin_turu'=>$details->temin_turu,
                                'satinalma_turu'=>$details->satinalma_turu,
                                'imalat_siparis_birimi'=>$details->imalat_siparis_birimi,
                                'rapor_birimi'=>$details->rapor_birimi,
                                'satinalma_suresi'=>$details->satinalma_suresi,
                                'imalat_tedarik_suresi'=>$details->imalat_tedarik_suresi,
                                'taxrate'=>$details->taxrate,
                                'ean'=>$details->ean,
                                'loc' => $details->loc,
                                'created_at' => date('Y-m-d H:i:s'),
                            );
                            $this->db->insert('geopos_products_parent', $data);

                            return [
                                'status' => 1,
                                'messages' => 'Başarılı Bir Şekilde Eklendi',
                            ];
                        }
                        else {
                            return [
                                'status' => 0,
                                'messages' => 'Hata Aldınız.Lütfen Yöneyiciye Başvurun.',
                            ];
                        }

                    }
                    else {

                        $this->db->delete('product_stock_code', array('product_id' => $product_id));
                        $this->db->delete('product_to_options', array('product_id' => $product_id));
                        return [
                            'status' => 1,
                            'messages' => 'Başarılı Bir Şekilde Eklendi',
                        ];
                    }
                }
                else {
                    return [
                        'status' => 0,
                        'messages' => 'Ana Üründe Kategoriye Kısa Kod Verilmemiştir.',
                    ];
                }

            }
            else {
                return [
                    'status' => 0,
                    'messages' => 'Ana Üründe Kategori Seçilmemiştir.',
                ];
            }


        }
        else {
            return [
                'status' => 0,
                'messages' => 'Yetkiniz Yoktur',
            ];
        }


    }

    public function product_to_option_create(){
        $product_id = $this->input->post('product_id');
        $option_details = $this->input->post('option_details');
        $index=0;
        if($option_details){
            foreach ($option_details as  $items){
                $option_kontol_id = $items['option_id'];
                $kontrol = $this->db->query("SELECT * FROM product_to_options WHERE  product_id=$product_id and option_id=$option_kontol_id");
                if(!$kontrol->num_rows()){
                    $data_option=[
                        'product_id'=>$product_id,
                        'option_id'=>$items['option_id'],
                        'sort'=>$items['sort'],
                    ];
                    $this->db->insert('product_to_options', $data_option);
                    $last_id = $this->db->insert_id();
                    $value_details = get_product_option_value($items['option_id']);
                    foreach ($value_details as $value_items){
                        $data_option=[
                            'product_to_option_id'=>$last_id,
                            'option_value_id'=>$value_items->id,
                        ];
                        $this->db->insert('product_to_options_value', $data_option);
                    }
                    $index++;

                    // option create
                }
            }
            if($index){
                return [
                    'status' => 1,
                    'messages' => 'Başarılı Bir Şekilde Eklendi',
                ];
            }
            else {
                return [
                    'status' => 0,
                    'messages' => 'Hata Aldınız.Lütfen Yöneyiciye Başvurun.',
                ];
            }
        }
        else {
            return [
                'status' => 0,
                'messages' => 'Değer Gönderilmemiştir.',
            ];
        }
//        if($kontrol->num_rows()){
//            $delete_id = [];
//            foreach ($kontrol->result() as $items){
//                $delete_id[]=[
//                    'option_id'=>$items->option_id,
//                    'sort'=>$items->sort
//                ];
//
//            }
//
//            $option_details = array_diff_key($option_details,$delete_id );
//
//           // $delete_id_in =  implode(',',$delete_id);
//
//
//            //$this->db->delete('product_to_options', array('product_id' => $product_id));
//            //$this->db->query('DELETE FROM `product_to_options_value` WHERE  product_to_option_id IN ('.$delete_id_in.')');
//        }





    }
    public function product_to_option_create_post($product_id,$option_details){
        $index=0;
        $kontrol = $this->db->query("SELECT * FROM product_to_options WHERE  product_id=$product_id");
        if($kontrol->num_rows()){
            $delete_id = [];
            foreach ($kontrol->result() as $items){
                $delete_id[]=$items->id;
            }

            $delete_id_in =  implode(',',$delete_id);
          //  $this->db->delete('product_to_options', array('product_id' => $product_id));
            $this->db->query('DELETE FROM `product_to_options_value` WHERE  product_to_option_id IN ('.$delete_id_in.')');
        }

        // option create
        foreach ($option_details as $items){
            $option_id=$items['option_id'];
            $kontrol = $this->db->query("SELECT * FROM product_to_options WHERE  product_id=$product_id and option_id=$option_id");
            if($kontrol->num_rows()){
                $this->db->delete('product_to_options', array('product_id' => $product_id,'option_id'=>$option_id));
            }

            $data_option=[
                'product_id'=>$product_id,
                'option_id'=>$option_id,
                'sort'=>$items['sort'],
            ];
            $this->db->insert('product_to_options', $data_option);
            $last_id = $this->db->insert_id();
            $value_details = get_product_option_value($items['option_id']);
            foreach ($value_details as $value_items){
                $data_option=[
                    'product_to_option_id'=>$last_id,
                    'option_value_id'=>$value_items->id,
                ];
                $this->db->insert('product_to_options_value', $data_option);
            }
            $index++;
        }
        if($index){
            return [
                'status' => 1,
                'messages' => 'Başarılı Bir Şekilde Eklendi',
            ];
        }
        else {
            return [
                'status' => 0,
                'messages' => 'Hata Aldınız.Lütfen Yöneyiciye Başvurun.',
            ];
        }
        // option create

    }

    public function delete_product_to_option()
    {
        $product_to_options_id = $this->input->post('product_to_options_id');
        $kontrol = $this->db->query("SELECT * FROM product_to_options_value Where product_to_option_id=$product_to_options_id and product_stock_code is not null")->num_rows();
        if(!$kontrol){

            $this->db->query("DELETE FROM `product_to_options_value` WHERE  product_to_option_id  = $product_to_options_id");
            $this->db->query("DELETE FROM `product_to_options` WHERE  id  = $product_to_options_id");
            return [
                'status' => 1,
                'messages' => 'Başarılı Bir Şekilde Eklendi',
            ];
        }
        else {
            return [
                'status' => 0,
                'messages' => 'Bu Varyasyon İle Yeni Ürün Oluşturulmuştur Silinemez',
            ];
        }
    }

    public function varyant_delete(){
        $product_id = $this->input->post('product_id');
        $product_details = $this->details($product_id);

        $option_details = $this->input->post('option_details');
        $say = count($option_details);
        $i = 0;
        foreach ($option_details as $items){
            $stock_code_id=$items['stock_code_id'];
            $stock_code_details = $this->db->query("SELECT * FROM product_stock_code Where id=$stock_code_id")->row()->code;
            $this->aauth->applog($product_details->product_name." Ürününden " .$stock_code_details.' Kodlu Varyant Silindi', $this->aauth->get_user()->username);


            $this->db->delete('product_stock_code', array('id' => $stock_code_id));
            $this->db->delete('geopos_products_parent', array('product_stock_code_id' => $stock_code_id));
            $this->db->delete('product_to_options_value', array('product_stock_code' => $stock_code_id));
            $i++;
        }

        if($i){
            return [
                'status' => 1,
                'messages' => 'Başarılı Bir Şekilde '.$i. ' Adet Varyant Silindi',
            ];
        }
        else {
            return [
                'status' => 0,
                'messages' => 'Hata Aldınız.Lütfen Yöneyiciye Başvurun.',
            ];
        }



    }


    public function alt_urun()
    {
        $this->_alt_urun();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        //echo $this->db->last_query();die();

        return $query->result();
    }


    private function _alt_urun()
    {

        $this->db->select('geopos_products_parent.*,product_stock_code.code as p_code, ,geopos_product_cat.title as category_name, geopos_product_type.name as product_type_name');
        $this->db->from('geopos_products_parent');

        $this->db->join('geopos_product_cat', 'geopos_products_parent.pcat=geopos_product_cat.id','LEFT');
        $this->db->join('product_stock_code', 'geopos_products_parent.product_stock_code_id=product_stock_code.id');

        $this->db->join('geopos_product_type', 'geopos_products_parent.product_type=geopos_product_type.id');
        $this->db->where('geopos_products_parent.deleted_at', NULL, FALSE);
        $i = 0;




        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_products_parent.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        if($this->input->post('category_id'))
        {
            $cat_id = $this->input->post('category_id');

            //echo "<pre>";print_r(_ust_kategori_kontrol_return_array($cat_id));

            $parent_kontrol = $this->db->query("SELECT * FROM geopos_product_cat Where id = $cat_id");
            $this->db->where_in('geopos_products_parent.pcat', _ust_kategori_kontrol_return_array($cat_id));




        }
        if($this->input->post('parent_id'))
        {
            $parent_id = $this->input->post('parent_id');
            $this->db->where_in('geopos_products_parent.product_id', $parent_id);

        }
        foreach ($this->column_search_p as $item) // loop column
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

                if (count($this->column_search_p) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke

            }

            $i++;
        }

        $search = $this->input->post('order');
        $this->db->order_by('geopos_products_parent.id','DESC');


    }


    public function count_filtered_alt_urun()
    {
        $this->_alt_urun();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_alt_urun()
    {
        $this->_alt_urun();
        return $this->db->count_all_results();
    }

    public function new_code_create()
    {
        $product_id = $this->input->post('product_id');
        $details = $this->details($product_id);
        $cat_id = $details->pcat;

        $category_details = $this->db->query("SELECT * FROM geopos_product_cat Where id=$cat_id")->row();
        if($category_details->code_string || $category_details->code_numaric){
            $numaric_kontrol  = $this->db->query("SELECT * FROM category_numaric Where cat_id=$cat_id");
            if($numaric_kontrol->row()){
                $code=$category_details->code.'-'.$numaric_kontrol->row()->numaric;

                if(numaric_update_category($cat_id)){
                    return [
                        'status' => 1,
                        'messages' => 'Başarılı Bir Şekilde Yeni Kod Oluşturuldu',
                        'new_code' => $code
                    ];
                }
                else{
                    return [
                        'status' => 0,
                        'messages' => 'Kod Oluşturulurken Hata Aldınız',
                    ];
                }
            }
            else {
                return [
                    'status' => 0,
                    'messages' => 'Seçilen Kategorinin Başlangıç Numarası Girilmemiştir.',
                ];
            }

        }
        else{
            return [
                'status' => 0,
                'messages' => 'Seçilen Kategorinin Kodlaması Yapılmamıştır.',
            ];
        }






        //_ust_kategori_kontrol_return_array_tek
    }

    public function proje_mt_report()
    {
        $this->_proje_mt_report();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        //echo $this->db->last_query();die();

        return $query->result();
    }


    private function _proje_mt_report()
    {




        $this->db->select('geopos_projects.code as pcde,geopos_products.pid,geopos_products.product_name,talep_form.code,talep_form.id,talep_form_products.id as talep_form_products_id,talep_form_products.product_stock_code_id,talep_form_products.product_qty,talep_form_products.unit_id,talep_form_products.product_stock_code_id');
        $this->db->from('geopos_products');
        $this->db->join('talep_form_products', 'geopos_products.pid=talep_form_products.product_id');
        $this->db->join('talep_form', 'talep_form.id=talep_form_products.form_id');
        $this->db->join('geopos_projects', 'geopos_projects.id=talep_form.proje_id');
        $this->db->join('product_stock_code', 'talep_form_products.product_stock_code_id=product_stock_code.id');
        $this->db->where('geopos_products.deleted_at', NULL, FALSE);
        $this->db->where('talep_form.talep_type', 1);
        $this->db->where('talep_form.status!=10');
        if($this->input->post('proje_id')){
            $proje_id = $this->input->post('proje_id');
            $this->db->where('talep_form.proje_id',$proje_id);
        }


        $i = 0;


        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_products.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        foreach ($this->column_report_sp as $item) // loop column
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

                if (count($this->column_report_sp) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke

            }

            $i++;
        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_report_op[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->urun)) {

            $this->db->order_by('talep_form.id','DESC');
        }
    }


    public function count_filtered_mt_report()
    {
        $this->_proje_mt_report();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_mt_report()
    {
        $this->_proje_mt_report();
        return $this->db->count_all_results();
    }
}
