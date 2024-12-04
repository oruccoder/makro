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





class Siparis_model extends CI_Model
{
    var $column_order = array('id', 'invoice_no', 'invoicedate','geopos_customers.company','notes');

    var $column_search = array('id', 'invoice_no', 'invoicedate','geopos_customers.company','notes');

    var $order = array('id' => 'DESC');

    public function __construct()
    {
        parent::__construct();

    }

    public function ajax_list()

    {
        $this->_ajax_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _ajax_list()

    {

        $this->db->select('geopos_invoices.*,geopos_customers.company as company');
        $this->db->from('geopos_invoices');

        $this->db->join('geopos_customers','geopos_invoices.csd=geopos_customers.id');

        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_invoices.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        $this->db->where('geopos_invoices.invoice_type_id',9);



        $i = 0;

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
        $this->db->order_by('`geopos_invoices`.`id` DESC');

    }


    public function count_filtered()
    {
        $this->_ajax_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_ajax_list();
        return $this->db->count_all_results();
    }

    public function details($id){
        $this->db->select('*');
        $this->db->from('geopos_invoices');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function create_save(){
        $talep_no = numaric(33);
        $cari_id = $this->input->post('cari_id');
        $cari_proje_id = $this->input->post('cari_proje_id');
        $cari_teslimat_id = $this->input->post('cari_teslimat_id');
        $warehouse_id = $this->input->post('warehouse_id');
        $sorumlu_personel = $this->input->post('sorumlu_personel');
        $desc = $this->input->post('desc');
        $image_text = $this->input->post('image_text');
        $table_product_id_ar = $this->input->post('table_product_id_ar');
        $collection = $this->input->post('collection');
        $data = array(
            'invoice_no'=>$talep_no,
            'proje_id'=>$cari_proje_id,
            'depo'=>$warehouse_id,
            'notes'=>$desc,
            'invoice_type_id'=>9,
            'invoice_type_desc'=>invoice_type_desc(9),
            'csd'=>$cari_id,
            'sorumlu_pers_id'=>$sorumlu_personel,
            'ext'=>$image_text,
            'shipping_id'=>$cari_teslimat_id,
            'eid' => $this->aauth->get_user()->id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        $index=0;
        if ($this->db->insert('geopos_invoices', $data)) {
            $last_id = $this->db->insert_id();
            $this->db->set('deger', "deger+1",FALSE);
            $this->db->where('tip', 33);
            $this->db->update('numaric');
            foreach ($collection as $items){
                $product_id = $items['product_id'];
                $value_id =  $items['value_id'];
                $unit_id = $items['unit_id'];
                $price = $items['price'];
                $total_price = $items['total_price'];
                $qty = $items['qty'];
                $options_id='';
                $i=0;
                $data_product = array(
                    'invoice_type_id'=>9,
                    'invoice_type_desc'=>invoice_type_desc(9),
                    'unit'  => $unit_id,
                    'pid'  => $product_id,
                    'product'  => product_name($product_id),
                    'qty'  => $qty,
                    'price'  => $price,
                    'subtotal'  => $total_price,
                    'tid'  => $last_id,
                );
                if($this->db->insert('geopos_invoice_items', $data_product)){
                    $invoice_items_id = $this->db->insert_id();
                    $index++;
                    if($items['option_id']){
                        $option_details = $items['option_id'];
                        $values_details = $items['value_id'];
                        $option_details_str = explode(',',$option_details);
                        $values_details_Str = explode(',',$values_details);
                        foreach ($option_details_str as $key => $val){
                            $val_option_id = $val;
                            $val_option_value_id = $values_details_Str[$key];
                            //varyasyon kayıt
                            $varyasyon=[
                                'invoices_item_id'=>$invoice_items_id,
                                'option_id'=>$val_option_id,
                                'option_value_id'=>$val_option_value_id,
                            ];
                            $this->db->insert('invoices_item_to_option',$varyasyon);
                            //varyasyon kayıt
                        }
                    }
                }



            }
            if($index){
                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde Sipariş Oluşturuldu',
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız',
                ];
            }


        }

    }

    public function update_save_siparis(){

        $siparis_id = $this->input->post('siparis_id');
        $cari_id = $this->input->post('cari_id');
        $cari_proje_id = $this->input->post('cari_proje_id');
        $cari_teslimat_id = $this->input->post('cari_teslimat_id');
        $warehouse_id = $this->input->post('warehouse_id');
        $sorumlu_personel = $this->input->post('sorumlu_personel');
        $desc = $this->input->post('desc');
        $image_text = $this->input->post('image_text');
        $data = array(
            'proje_id'=>$cari_proje_id,
            'depo'=>$warehouse_id,
            'notes'=>$desc,
            'invoice_type_id'=>9,
            'invoice_type_desc'=>invoice_type_desc(9),
            'csd'=>$cari_id,
            'sorumlu_pers_id'=>$sorumlu_personel,
            'ext'=>$image_text,
            'shipping_id'=>$cari_teslimat_id,
        );
        $this->db->where('id', $siparis_id);
        if($this->db->update('geopos_invoices',$data))
        {
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Güncellendi',
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız',
            ];
        }
    }

    public function update_item(){


        $invoice_item_id = $this->input->post('invoice_item_id');
        $product_id = $this->input->post('product_id');
        $product_name = $this->input->post('product_name');
        $option_id_data = $this->input->post('option_id_data');
        $option_value_id_data = $this->input->post('option_value_id_data');
        $qty = $this->input->post('qty');
        $unit_id = $this->input->post('unit_id');
        $price = $this->input->post('price');
        $total_price = $this->input->post('total_price');

        $data_product = array(
            'invoice_type_id'=>9,
            'invoice_type_desc'=>invoice_type_desc(9),
            'unit'  => $unit_id,
            'pid'  => $product_id,
            'product'  => product_name($product_id),
            'qty'  => $qty,
            'price'  => $price,
            'subtotal'  => $total_price,
        );
        $this->db->where('id', $invoice_item_id);
        if($this->db->update('geopos_invoice_items',$data_product))
        {
            if($option_id_data){
                $this->db->delete('invoices_item_to_option', array('invoices_item_id' => $invoice_item_id));
                $option_details = $option_id_data;
                $values_details = $option_value_id_data;
                $option_details_str = explode(',',$option_details);
                $values_details_Str = explode(',',$values_details);
                foreach ($option_details_str as $key => $val){
                    $val_option_id = $val;
                    $val_option_value_id = $values_details_Str[$key];
                    //varyasyon kayıt
                    $varyasyon=[
                        'invoices_item_id'=>$invoice_item_id,
                        'option_id'=>$val_option_id,
                        'option_value_id'=>$val_option_value_id,
                    ];
                    $this->db->insert('invoices_item_to_option',$varyasyon);
                    //varyasyon kayıt
                }
            }

            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Güncellendi',
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız',
            ];
        }
    }

    public function product_details($id){
        $this->db->select('geopos_invoice_items.*,geopos_products.product_name,geopos_units.name as unit_name');
        $this->db->from('geopos_invoice_items');
        $this->db->join('geopos_products','geopos_invoice_items.pid=geopos_products.pid');
        $this->db->join('geopos_units','geopos_invoice_items.unit=geopos_units.id');
        $this->db->where('geopos_invoice_items.tid',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function status_change(){

        $id = $this->input->post('talep_id');
        $status = $this->input->post('status');
        $desc = $this->input->post('desc');
        $details = $this->details($id);
        if($details->status==3){
            return [
                'status'=>0,
                'messages'=>'İptal Olunmuş Fişin Durumu Değiştirilemez'
            ];

        }
        else {

            if($details->status==20 || $details->status==1){
                $old_status = invoice_status($details->status);
                $new_status = invoice_status($status);
                $data_items = array(
                    'status'      => $status,
                );
                $this->db->where('id', $id);
                if($this->db->update('geopos_invoices',$data_items    )){
                    $newdesc='Sipariş Fişi '.$old_status.' Durumundan '.$new_status.' Durumuna Alındı.Açıklama : '.$desc;

                    $this->aauth->applog($newdesc, $this->aauth->get_user()->username);
                    return  [
                        'status'=>1,
                        'messages'=>'Başarılı Bir Şekilde Güncellendi'
                    ];
                }
            }
            else {
                return [
                    'status'=>0,
                    'messages'=>'Tamamlanmış Bir Siparişin Durumunu Değiştiremezsiniz.Yönetici İle İletişime Geçiniz'
                ];
            }

        }
    }

    public function delete_item(){
        $invoice_item_id = $this->input->post('invoice_item_id');
        if ($this->db->delete('geopos_invoice_items', array('id' => $invoice_item_id))) {
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Silindi',
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız',
            ];
        }
    }

}