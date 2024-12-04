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



class Uretim_model extends CI_Model

{


    var $table = 'geopos_invoices';

    var $column_uretim = array('invoicedate', 'acid', 'debit', 'credit', 'payer', 'method');

    var $column_order = array(null, 'tid', 'invoicedate', 'invoice_name', 'status', null);

    var $column_search = array('tid', 'name', 'invoicedate','invoice_type_desc','invoice_name');

    var $column_search_uretim = array('id', 'product_id', 'product_name','quantity','uretim_desc','uretim_date');
    var $colum_order_uretim = array('id', 'product_id', 'product_name','quantity','uretim_desc','uretim_date');
    var $column_search_history = array('desc', 'created_at', 'geopos_employees.name');
    var $order = array('id' => 'desc');

    var $opt = '';





    function get_datatables($opt = '')

    {

        $this->_get_datatables_query($opt);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();

    }
    private function _get_datatables_query($opt = '')

    {

        $this->db->select('*');
        $this->db->from('geopos_invoices');
        $this->db->where_in('geopos_invoices.invoice_type_id',[11,71]);
        $this->db->where('geopos_invoices.loc', $this->session->userdata('set_firma_id'));
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

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }
    public function count_all($opt = '')

    {

        $this->_get_datatables_query();

        return $this->db->count_all_results();

    }
    function count_filtered($opt = '')

    {
        $this->_get_datatables_query();
        $query = $this->db->get();

        return $query->num_rows();

    }


    public function create_save(){
        //$all_users = $this->input->post('all_users');
        $recete_adi = $this->input->post('recete_adi');
        $recete_tipi = $this->input->post('recete_tipi');
        $proje_id = $this->input->post('proje_id');
        $warehouse_id = $this->input->post('warehouse_id');
        $desc = $this->input->post('desc');
        $product_id = $this->input->post('product_id');
        $image_text = $this->input->post('image_text');
        $product_details = $this->input->post('product_details');
        $uretim_unit_id = $this->input->post('uretim_unit_id');




        $talep_no = numaric(31);
        $data = array(
            'invoice_no'=>$talep_no,
            'invoice_name'=>$recete_adi,
            'proje_id'=>$proje_id,
//            'depo'=>$warehouse_id,
            'notes'=>$desc,
            'invoice_type_id'=>$recete_tipi,
            'invoice_type_desc'=>invoice_type_desc($recete_tipi),
            'new_prd_id'=>$product_id,
            'term'=>$uretim_unit_id,
            'eid' => $this->aauth->get_user()->id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        if ($this->db->insert('geopos_invoices', $data)) {
            $last_id = $this->db->insert_id();

            if(isset($product_details[0]['product_options'])){
                foreach ($product_details[0]['product_options'] as $items){
                    $option_id =  $items['option_id'];
                    $option_value_id =  $items['option_value_id'];
                    $option_name =  $items['option_name'];
                    $option_value_name =  $items['option_value_name'];

                    $data_new = array(
                        'option_id'=>$option_id,
                        'option_value_id'=>$option_value_id,
                        'option_name'=>$option_name,
                        'value_name'=>$option_value_name,
                        'product_id'=>$product_id,
                        'invoice_id'=>$last_id,
                    );
                    $this->db->insert('uretim_new_product', $data_new);
                }

            }


            $this->db->set('deger', "deger+1",FALSE);
            $this->db->where('tip', 31);
            $this->db->update('numaric');

            if($image_text){
                $data_images = array(
                    'image_text' => $image_text,
                    'invoices_id' => $last_id,
                );
                $this->db->insert('invoices_files', $data_images);
            }


            $this->aauth->applog("Üretim Reçetesi Oluşturuldu: Talep No : ".$talep_no, $this->aauth->get_user()->username);
            $this->talep_history(0,$last_id,$this->aauth->get_user()->id,$talep_no.' Numaralı Reçete Oluşturuldu');

            return [
                'status'=>1,
                'id'=>$last_id
            ];
        }
        else {
            return [
                'status'=>0,
                'id'=>0
            ];
        }
    }
    public function update_save(){
        //$all_users = $this->input->post('all_users');
        $recete_id = $this->input->post('recete_id');
        $details = $this->details($recete_id);

        $recete_adi = $this->input->post('recete_adi');
        $proje_id = $this->input->post('proje_id');
        $desc = $this->input->post('desc');

        $uretim_unit_id = $this->input->post('uretim_unit_id');

        $product_id = $this->input->post('product_id');
        if(intval($product_id)){
            $product_id = $this->input->post('product_id');
        }
        else {
            $product_id = $details->new_prd_id;
        }




        $data = array(
            'invoice_name'=>$recete_adi,
            'proje_id'=>$proje_id,
//            'depo'=>$warehouse_id,
            'notes'=>$desc,
            'new_prd_id'=>$product_id,
            'term'=>$uretim_unit_id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        $this->db->where('id',$recete_id);
        $this->db->set($data);
        if ($this->db->update('geopos_invoices', $data)) {
            $last_id = $recete_id;

            if(intval($this->input->post('product_id'))) {
                $product_details = $this->input->post('product_details');
                if (isset($product_details[0]['product_options'])) {
                    $this->db->delete('uretim_new_product', array('invoice_id'=>$last_id));
                    foreach ($product_details[0]['product_options'] as $items) {
                        $option_id = $items['option_id'];
                        $option_value_id = $items['option_value_id'];
                        $option_name = $items['option_name'];
                        $option_value_name = $items['option_value_name'];

                        $data_new = array(
                            'option_id' => $option_id,
                            'option_value_id' => $option_value_id,
                            'option_name' => $option_name,
                            'value_name' => $option_value_name,
                            'product_id' => $product_id,
                            'invoice_id' => $last_id,
                        );
                        $this->db->insert('uretim_new_product', $data_new);
                    }

                }
            }



            $this->aauth->applog("Üretim Reçetesi Güncellendi: Talep No : ".$details->invoice_no, $this->aauth->get_user()->username);
            $this->talep_history(0,$last_id,$this->aauth->get_user()->id,$details->invoice_no.' Numaralı Reçete Güncellendi');

            return [
                'status'=>1,
                'id'=>$last_id
            ];
        }
        else {
            return [
                'status'=>0,
                'id'=>0
            ];
        }
    }

    public function create_item(){

        $rusults =  $this->input->post('collection');
        $invoice_id =  $this->input->post('invoice_id');
        $details=$this->details($invoice_id);

        $i=0;
        if($rusults) {
            foreach ($rusults as $result) {
                $data_product = array(
                    'invoice_type_id'=>11,
                    'invoice_type_desc'=>invoice_type_desc(11),
                    'unit'  => $result['unit_id'],
                    'pid'  => $result['product_id'],
                    'product'  => product_name($result['product_id']),
                    'qty'  => $result['qty'],
                    'fire'  => $result['fire_oran'],
                    'fire_quantity'  => $result['fire_miktar'],
                    'fire_qty_total'  => $result['toplam_miktar'],
                    'tid'  => $invoice_id,
                );
                if($this->db->insert('geopos_invoice_items', $data_product)){
                    $invoice_items_id = $this->db->insert_id();
                    if($result['product_stock_code_id']){

                        //varyasyon kayıt
                        $varyasyon=[
                            'invoices_item_id'=>$invoice_items_id,
                            'product_stock_code_id'=>$result['product_stock_code_id']
                        ];
                        $this->db->insert('invoices_item_to_option',$varyasyon);
                        //varyasyon kayıt
                    }
                    $i++;
                    $this->talep_history(0,$invoice_id,$this->aauth->get_user()->id,product_name($result['product_id']).' '.$result['qty'].' '.units_($result['unit_id'])['name'].' Ürün Eklendi'.' Toplam Tüketilen :'.$result['toplam_miktar']);
                }
                else {
                    return [
                        'status'=>0,
                        'messages'=>'Ürün Bilgilerinde Hata Oluştur'
                    ];
                }
            }
        }
        else {
            return [
                'status'=>0,
                'messages'=>'Herhangi Bir Ürün Seçilmemiş'
            ];
        }
        if($i){
            return [
                'status'=>1,
                'messages'=>$i.' Adet Ürün Eklendi'
            ];
        }
        else {
            return [
                'status'=>0,
                'messages'=>'Hata Aldınız Yönetime Başvutun'
            ];
        }
    }

    public function details($id){
        $this->db->select('*');
        $this->db->from('geopos_invoices');
        $this->db->where('geopos_invoices.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
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

    public function file_details($id){
        $this->db->select('*');
        $this->db->from('invoices_files');
        $this->db->where('invoices_id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function muhasebe(){
        $uretim_id = $this->input->post('uretim_id');
        $desc = $this->input->post('desc');
        $new_uretim_qty = $this->input->post('uretim_qty');
        $plaka_no = $this->input->post('plaka_no');
        $cari_proje_id = $this->input->post('cari_proje_id');
        $cari_teslimat_id = $this->input->post('cari_teslimat_id');

        $siparis_id=fis_to_siparis($uretim_id)['details']->id;
        $cari_id=fis_to_siparis($uretim_id)['details']->csd;

        $uretin_details = $this->db->query("SELECT * FROM geopos_uretim Where id=$uretim_id")->row();
        $uretim_miktari = $uretin_details->quantity;
        if($new_uretim_qty >$uretim_miktari){
            return [
                'status'=>0,
                'messages'=>'Girmiş Olduğunuz Miktar Üretim Miktarından Büyük Olamaz'
            ];
        }
        else {
            $old_uretim_qty=0;
            $old_details = $this->db->query("SELECT * FROM geopos_invoices Where task_id=$uretim_id");
            if($old_details->num_rows()){
                foreach ($old_details->result() as  $old_items){
                    $old_uretim_qty+=$old_items->items;
                }
            }

            $total_uretim = $old_uretim_qty+$new_uretim_qty;
            if($total_uretim > $uretim_miktari) {
                return [
                    'status'=>0,
                    'messages'=>'Daha Önce Üretilen Miktar ve Girmiş Olduğunuz Miktar Üretim Miktarından Büyük Olamaz'
                ];
            }
            else {

                $talep_code=numaric(34);
//                $data_uretim_teslimat_fisleri=[
//                    'code'=>$talep_code,
//                    'uretim_fis_id'=>$uretim_id,
//                    'siparis_fis_id'=>$siparis_id,
//                    'cari_id'=>$cari_id,
//                    'cari_proje_id'=>$cari_proje_id,
//                    'cari_teslimat_id'=>$cari_teslimat_id,
//                    'plaka_no'=>$plaka_no,
//                    'miktar'=>$new_uretim_qty,
//                    'desc'=>$desc,
//                    'aauth_id'=>$this->aauth->get_user()->id,
//                ];


                $invoice_item_id = $uretin_details->invoice_item_id;
                $price=$this->db->query("SELECT * FROM geopos_invoice_items where id=$invoice_item_id")->row()->price;

                $total_qiymet = $price*$new_uretim_qty;
                $data_uretim_teslimat_fisleri=[
                    'invoice_no'=>$talep_code,
                    'task_id'=>$uretim_id,
                    'purchase_id'=>$siparis_id,
                    'csd'=>$cari_id,
                    'proje_id'=>$cari_proje_id,
                    'shipping_id'=>$cari_teslimat_id,
                    'pers_notes'=>$plaka_no,
                    'total'=>$total_qiymet,
                    'subtotal'=>$total_qiymet,
                    'items'=>$new_uretim_qty,
                    'notes'=>$desc,
                    'invoice_type_id'=>69,
                    'invoice_type_desc'=>invoice_type_desc(69),
                    'eid'=>$this->aauth->get_user()->id
                ];
                if($this->db->insert('geopos_invoices', $data_uretim_teslimat_fisleri)){

                    $operator = "deger+1";
                    $this->db->set('deger', "$operator", FALSE);
                    $this->db->where('tip', 34);
                    $this->db->update('numaric');


                    $depo_id = $uretin_details->depo_id;
                    $uretim_product_id = $uretin_details->product_id;
                    $uretim_unit_id = $uretin_details->unit_id;
                    $recete_id = $uretin_details->recete_id;
                    $warehouse_id = $uretin_details->depo_id;
                    $recete_details =$this->uretim_to_products($uretim_id);
                    foreach ($recete_details as $items){
                        $item_product_id = $items->pid;
                        $fire_orani = $items->fire;
                        //$item_qty = $items->toplam_tuketilen;
                        $item_unit = $items->unit_id;

                        $_miktar = $new_uretim_qty*$items->quantity_2;
                        $new_fire_miktari = ($_miktar*$fire_orani)/100;
                        $item_qty = $_miktar+$new_fire_miktari;

                        $product_type = $this->db->query("SELECT * FROM geopos_products Where pid =$item_product_id")->row()->product_type;

                        if($product_type!=2){
                            $stock_id = stock_update_new($item_product_id,$item_unit,$item_qty,0,$warehouse_id,$this->aauth->get_user()->id,$uretim_id,5);

                            $item_id=$this->db->query("SELECT * FROM geopos_invoice_items Where tid=$recete_id and pid=$item_product_id")->row()->id;
                            $details = $this->db->query("SELECT * FROM invoices_item_to_option Where invoices_item_id=$item_id");

                            if($details->num_rows()){
                                $i=0;
                                $options_id='';
                                $option_value_id='';
                                foreach ($details->result() as $options_details){
                                    if($options_details->option_id){

                                        if ($i === array_key_last($details->result())) {// first loop
                                            $options_id.=$options_details->option_id;
                                            $option_value_id.=$options_details->option_value_id;
                                        }
                                        else {
                                            $options_id.=$options_details->option_id.',';
                                            $option_value_id.=$options_details->option_value_id.',';
                                        }
                                        $i++;
                                    }

                                }
                                stock_update_options_new($stock_id,$options_id,$option_value_id);
                            }
                        }

                    }

                    // Stok Artış
                    //$stock_id_giren = stock_update_new($uretim_product_id,$uretim_unit_id,$uretim_miktari,1,$warehouse_id,$this->aauth->get_user()->id,$uretim_id,5);
                    $stock_id_giren = stock_update_new($uretim_product_id,$uretim_unit_id,$new_uretim_qty,1,$warehouse_id,$this->aauth->get_user()->id,$uretim_id,5);
                    $stock_id_giren = stock_update_new($uretim_product_id,$uretim_unit_id,$new_uretim_qty,0,$warehouse_id,$this->aauth->get_user()->id,$uretim_id,5);

                    $details_ = $this->db->query("SELECT * FROM uretim_new_product Where invoice_id=$recete_id");
                    if($details_->num_rows()){
                        $i=0;
                        $options_id='';
                        $option_value_id='';
                        foreach ($details_->result() as $options_details){
                            if($options_details->option_id){

                                if ($i === array_key_last($details_->result())) {// first loop
                                    $options_id.=$options_details->option_id;
                                    $option_value_id.=$options_details->option_value_id;
                                }
                                else {
                                    $options_id.=$options_details->option_id.',';
                                    $option_value_id.=$options_details->option_value_id.',';
                                }
                                $i++;
                            }

                        }
                        stock_update_options_new($stock_id_giren,$options_id,$option_value_id);
                    }
                    // Stok Artış

                    if($stock_id_giren){

                        $newdesc='Belirtilen Üretim Oluşmuştur.Stok Hareketleri Gerçekleşmiştir. Üretilen Miktar : '.amountFormat_s($new_uretim_qty);
                        $this->talep_history($uretim_id,0,$this->aauth->get_user()->id,$newdesc,1);

                        $n_old_uretim_qty=0;
                        $old_details = $this->db->query("SELECT * FROM geopos_invoices Where task_id=$uretim_id");
                        if($old_details->num_rows()){
                            foreach ($old_details->result() as  $old_items){
                                $n_old_uretim_qty+=$old_items->items;
                            }
                        }

                        if($n_old_uretim_qty==$uretim_miktari){
                        $this->db->set('status', 3);
                        $this->db->where('id', $uretim_id); // Tamamlandı
                        $this->db->update('geopos_uretim');
                        }

                        return [
                            'status'=>1,
                            'messages'=>'Başarıyla Stok İşlemleri Yapıldı'
                        ];
                    }
                    else {
                        return [
                            'status'=>0,
                            'messages'=>'Stok Girişinde Hata aldınız'
                        ];
                    }
                }

            }


        }







    }

    public function status_change(){

        $uretim_id = $this->input->post('talep_id');
        $status = $this->input->post('status');
        $desc = $this->input->post('desc');
        $details = $this->uretim_details($uretim_id);
        if($details['status']==4){
            return [
                'status'=>0,
                'messages'=>'İptal Olunmuş Fişin Durumu Değiştirilemez'
            ];

        }
        else {

            if($details['status']==1 || $details['status']==2){
                $old_status = uretim_status($details['status'])->name;
                $new_status = uretim_status($status)->name;
                $data_items = array(
                    'status'      => $status,
                );
                $this->db->where('id', $uretim_id);
                if($this->db->update('geopos_uretim',$data_items    )){
                    $newdesc='Üretim Fişi '.$old_status.' Durumundan '.$new_status.' Durumuna Alındı.Açıklama : '.$desc;

                    $this->talep_history($uretim_id,0,$this->aauth->get_user()->id,$newdesc,$status);
                    return  [
                        'status'=>1,
                        'messages'=>'Başarılı Bir Şekilde Güncellendi'
                    ];
                }
            }
            else {
                return [
                    'status'=>0,
                    'messages'=>'Tamamlanmış Bir Üretimin Durumunu Değiştiremezsiniz.Yönetici İle İletişime Geçiniz'
                ];
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

        return $query->result();

    }

    public function talep_history($id=0,$recete_id =0,$user_id,$desc,$status=0){
        date_default_timezone_set('Asia/Baku');
        $data_step = array(
            'uretim_id' => $id,
            'recete_id' => $recete_id,
            'aauth_id' => $user_id,
            'desc' => $desc,
            'status' => $status,
        );
        $this->db->insert('uretim_recete_history', $data_step);

    }


    public function ajax_list_history($id)

    {
        $this->_ajax_list_history($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _ajax_list_history($id)

    {


        $tip=$this->input->post('tip');
        $this->db->select('uretim_recete_history.*,geopos_employees.name as pers_name');
        $this->db->from('uretim_recete_history');
        $this->db->join('geopos_employees','uretim_recete_history.aauth_id=geopos_employees.id');
        if($tip==1){
            $this->db->where('uretim_recete_history.recete_id',$id);
        }
        elseif($tip==2) {
            $this->db->where('uretim_recete_history.uretim_id',$id);
        }

        $i = 0;
        foreach ($this->column_search_history as $item) // loop column
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

                if (count($this->column_search_notes) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`uretim_recete_history`.`id` DESC');

    }


    public function count_filtered_talep_history($id)
    {
        $this->_ajax_list_history($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_talep_history($id)
    {
        $this->_ajax_list_history($id);
        return $this->db->count_all_results();
    }

    //////////////////


    public function currencies()

    {



        $this->db->select('*');

        $this->db->from('geopos_currencies');

        $query = $this->db->get();

        return $query->result_array();

    }







    function get_datatables_uretim($opt = '')

    {

        $this->_get_datatables_query_uretim($opt);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();

        return $query->result();

    }

    private function _get_datatables_query_uretim($opt = '')

    {


        $recete_id= $this->input->post('recete_id');
        $this->db->select('geopos_uretim.id,geopos_uretim.code,geopos_uretim.unit_id,geopos_uretim.user_id,geopos_uretim.product_name,geopos_uretim.quantity,
        geopos_uretim.uretim_date,geopos_uretim.uretim_desc,geopos_uretim.status');
        $this->db->from('geopos_uretim');
        $i = 0;
        $this->db->where('geopos_uretim.recete_id',$recete_id);
        foreach ($this->column_search_uretim as $item) // loop column
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



                if (count($this->column_search_uretim) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->colum_order_uretim[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->colum_order_uretim)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }




    public function count_all_uretim($opt = '')

    {

        $this->db->select('geopos_uretim.id');

        $this->db->from('geopos_uretim');


        if ($opt) {

            $this->db->where('geopos_uretim.user_id', $opt);



        }

        if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_uretim.loc_id', $this->aauth->get_user()->loc);

        }

        return $this->db->count_all_results();

    }

    function count_filtered_uretim($opt = '')

    {

        $this->_get_datatables_query_uretim($opt);

        if ($opt) {

            $this->db->where('user_id', $opt);

        }

        if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_uretim.loc_id', $this->aauth->get_user()->loc);

        }

        $query = $this->db->get();

        return $query->num_rows();

    }




    public function invoice_details($id, $eid = '')

    {

        $this->db->select('geopos_invoices.*,SUM(geopos_invoices.shipping + geopos_invoices.ship_tax) AS shipping,geopos_customers.*,geopos_invoices.loc as loc,geopos_invoices.id AS iid,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');

        $this->db->from($this->table);

        $this->db->where('geopos_invoices.id', $id);

        if ($eid) {

            $this->db->where('geopos_invoices.eid', $eid);

        }

        if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);

        }

        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id', 'left');

        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_invoices.term', 'left');

        $query = $this->db->get();

        return $query->row_array();

    }

    public function attach($id)

    {

        $this->db->select('geopos_metadata.*');

        $this->db->from('geopos_metadata');

        $this->db->where('geopos_metadata.type', 1);

        $this->db->where('geopos_metadata.rid', $id);

        $query = $this->db->get();

        return $query->result_array();

    }
    public function invoice_products($id)

    {



        $this->db->select('*');

        $this->db->from('geopos_invoice_items');

        $this->db->where('tid', $id);

        $query = $this->db->get();

        return $query->result_array();



    }

    public function employee($id)

    {

        $this->db->select('geopos_employees.name,geopos_employees.sign,geopos_users.roleid');

        $this->db->from('geopos_employees');

        $this->db->where('geopos_employees.id', $id);

        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');

        $query = $this->db->get();

        return $query->row_array();

    }

    public function recete_getir($pid)
    {
        $this->db->select('geopos_invoice_items.*');

        $this->db->from('geopos_invoice_items');

        $this->db->where('geopos_invoice_items.tid', $pid);

        $query = $this->db->get();

        return $query->result_array();

    }

    public function uretim_products($id)
    {
        $this->db->select('geopos_uretim_item.*');

        $this->db->from('geopos_uretim_item');

        $this->db->where('geopos_uretim_item.uretim_id', $id);
        
        $this->db->where('geopos_uretim_item.type', 'uretim');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function uretim_products_res($id)
    {
        $this->db->select('geopos_uretim_item.*');

        $this->db->from('geopos_uretim_item');

        $this->db->where('geopos_uretim_item.uretim_id', $id);

        $this->db->where('geopos_uretim_item.type', 'uretim');

        $query = $this->db->get();

        return $query->result();
    }
    public function uretim_maliyet($id)
    {
        $this->db->select('geopos_uretim_item.*');

        $this->db->from('geopos_uretim_item');

        $this->db->where('geopos_uretim_item.uretim_id', $id);

        $this->db->where('geopos_uretim_item.type', 'maliyet');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function uretim_details($id, $eid = '')
    {
        $this->db->select('geopos_uretim.*');

        $this->db->from('geopos_uretim');

        $this->db->where('geopos_uretim.id', $id);

        $this->db->join('geopos_customers', 'geopos_uretim.customer_id = geopos_customers.id', 'left');

        $query = $this->db->get();

        return $query->row_array();
    }
    public function uretim_details_res($id, $eid = '')
    {
        $this->db->select('geopos_uretim.*');

        $this->db->from('geopos_uretim');

        $this->db->where('geopos_uretim.id', $id);

        $query = $this->db->get();

        return $query->row();
    }

    public function tehvil_details($id)
    {
        $this->db->select('geopos_invoices.*');

        $this->db->from('geopos_invoices');

        $this->db->where('geopos_invoices.id', $id);

        $query = $this->db->get();

        return $query->row();
    }

}