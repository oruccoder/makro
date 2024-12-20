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



class Qaime_model extends CI_Model
{
    var $column_search = array('geopos_customers.company', 'geopos_customers.name', 'geopos_invoices.invoicedate','geopos_invoices.invoice_no' ,'geopos_invoices.total','geopos_invoices.status','geopos_invoices.invoice_type_desc');
    var $column_order = array(null,
        'geopos_invoices.invoicedate',
        'geopos_invoices.invoice_type_desc',
        'geopos_invoices.invoice_no',
        'geopos_invoices.proje_id',
        'geopos_invoices.csd',
        'geopos_invoices.notes',
        'geopos_invoices.subtotal',
        'geopos_invoices.tax',
        'geopos_invoices.total',
        'geopos_invoices.status',null,null
        );
    var $table = 'geopos_invoices';
    var $column_search_history = array('desc', 'created_at', 'geopos_employees.name');


    public function __construct()
    {
        parent::__construct();
        $this->load->model('communication_model');

    }

    private function _get_datatables_query()
    {
        // SELECT İfadeleri
        $this->db->select('geopos_invoices.discount,
                       geopos_invoices.csd,
                       geopos_invoices.proje_id,
                       geopos_invoices.notes,
                       geopos_invoices.alt_cari_id,
                       geopos_invoices.eid,
                       geopos_invoices.invoice_name,
                       geopos_invoices.invoice_no,
                       geopos_invoices.id,
                       geopos_invoices.invoice_type_id,
                       geopos_invoices.invoicedate,
                       geopos_invoices.total,
                       geopos_invoices.tax,
                       geopos_invoices.subtotal,
                       geopos_invoices.status,
                       geopos_customers.company as name,
                       geopos_invoices.para_birimi');
        $this->db->from($this->table);

        // Filtreleme: invoice_type_id
        $type = $this->input->post('tip') ? array($this->input->post('tip')) : array(1, 2, 7, 8, 24, 41);
        $this->db->where_in('geopos_invoices.invoice_type_id', $type);

        // Tarih Aralığı
        if ($this->input->post('start_date') && $this->input->post('end_date')) {
            $this->db->where('DATE(geopos_invoices.invoicedate) >=', datefordatabasefilter($this->input->post('start_date')));
            $this->db->where('DATE(geopos_invoices.invoicedate) <=', datefordatabasefilter($this->input->post('end_date')));
        }

        // Diğer Filtreler
        if ($this->input->post('alt_firma')) {
            $this->db->where('geopos_invoices.alt_cari_id', $this->input->post('alt_firma'));
        }
        if ($this->input->post('status')) {
            $this->db->where('geopos_invoices.status', $this->input->post('status'));
        }
        if ($this->input->post('proje_id')) {
            $this->db->where('geopos_invoices.proje_id', $this->input->post('proje_id'));
        }

        // Firma ID Filtreleme (Session)
        if ($this->session->userdata('set_firma_id')) {
            $this->db->where('geopos_invoices.loc', $this->session->userdata('set_firma_id'));
        }

        // Join
        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id', 'left');

        // Arama (LIKE Kullanımı)
        if ($_POST['search']['value']) {
            $this->db->group_start();
            foreach ($this->column_search as $i => $item) {
                if ($i === 0) {
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
            }
            $this->db->group_end();
        }

        // Sıralama (ORDER BY)
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('geopos_invoices.invoicedate', 'DESC');
        }
    }


    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();

    }

    public function productsdetails($id,$invoice_type_id)
    {

        if($invoice_type_id==35 || $invoice_type_id==36){
            $this->db->select( '
                geopos_invoice_items.id,
                geopos_invoice_items.pid,
                geopos_invoice_items.qty,
                geopos_invoice_items.price,
                geopos_invoice_items.unit,
                geopos_invoice_items.tax,
                geopos_invoice_items.totaltax,
                geopos_invoice_items.totaldiscount,
                geopos_invoice_items.discount,
                geopos_invoice_items.subtotal,
                geopos_invoice_items.demirbas_id,
                 IFNULL(geopos_cost.name, geopos_invoice_items.product) AS product_name,
                                "-" as product_code,
                                0 as product_stock_code_id

                ');
            $this->db->from('geopos_invoice_items');
            $this->db->join('geopos_cost', 'geopos_invoice_items.pid = geopos_cost.id', 'left');
            $this->db->where('geopos_invoice_items.tid',$id);
            $query = $this->db->get();
            return $query->result();
        }
        elseif($invoice_type_id==24 || $invoice_type_id==41){ // Gider faurası
            $this->db->select( '
                geopos_invoice_items.id,
                geopos_invoice_items.pid,
                geopos_invoice_items.qty,
                geopos_invoice_items.price,
                geopos_invoice_items.unit,
                geopos_invoice_items.tax,
                geopos_invoice_items.totaltax,
                geopos_invoice_items.totaldiscount,
                geopos_invoice_items.discount,
                geopos_invoice_items.subtotal,
                geopos_invoice_items.demirbas_id,

                IFNULL(demirbas_group.name, geopos_invoice_items.product) AS product_name,

                                "-" as product_code,
                                0 as product_stock_code_id

                ');
            $this->db->from('geopos_invoice_items');
            $this->db->join('demirbas_group', 'geopos_invoice_items.pid = demirbas_group.id', 'left');
            $this->db->where('geopos_invoice_items.tid',$id);
            $query = $this->db->get();
            return $query->result();
        }
        else{
            $this->db->select( '
                geopos_invoice_items.id,
                geopos_invoice_items.pid,
                geopos_invoice_items.qty,
                geopos_invoice_items.price,
                geopos_invoice_items.unit,
                geopos_invoice_items.tax,
                geopos_invoice_items.totaltax,
                geopos_invoice_items.totaldiscount,
                geopos_invoice_items.discount,
                geopos_invoice_items.subtotal,
                geopos_invoice_items.demirbas_id,
                IFNULL(geopos_products.product_name, geopos_invoice_items.product) AS product_name,
                IFNULL(product_stock_code.code, "-") AS product_code,
                IFNULL(product_stock_code.id, 0) AS product_stock_code_id,

                ');
            $this->db->from('geopos_invoice_items');
            $this->db->join('invoices_item_to_option', 'geopos_invoice_items.id = invoices_item_to_option.invoices_item_id', 'left');
            $this->db->join('product_stock_code', 'product_stock_code.id = invoices_item_to_option.product_stock_code_id', 'left');
            $this->db->join('geopos_products', 'geopos_invoice_items.pid = geopos_products.pid', 'left');
            $this->db->where('geopos_invoice_items.tid',$id);
            $query = $this->db->get();
            return $query->result();

        }
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all()
    {
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }

    public function details($id){
        $this->db->select('*');
        $this->db->from('geopos_invoices');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function create_save()
    {


        $data = json_decode($_POST['data'], true);
        $form_data = $data['form_data'];
        $product_data = $data['product_data'];
        $toplamlar = $data['local_storage_data'];

        $tax_status = !empty($form_data['taxformat']) ? 'yes' : 'no';

        //invoice bilgiler
        $data_invoice = [
            'invoice_no' => $form_data['invoice_no'],
            'invoicedate' => $form_data['invoice_date'],
            'invoiceduedate' => $form_data['invocieduedate'],
            'refer' => $form_data['refer'],
            'alt_cari_id' => $form_data['alt_cari_id'],
            'para_birimi' => $form_data['para_birimi'],
            'invoice_type_id' => $form_data['invoice_type_id'],
            'invoice_type_desc' => invoice_type_id($form_data['invoice_type_id']),
            'notes' => $form_data['notes'],
            'csd' => $form_data['customer_id'],
            'proje_id' => $form_data['proje_id'],
            'bolum_id' => $form_data['bolum_id'],
            'asama_id' => $form_data['asama_id'],
            'subtotal'=> $toplamlar['araToplam'],
            'discount'=> $toplamlar['toplamIndirim'],
            'netToplam'=> $toplamlar['netToplam'],
            'tax'=> $toplamlar['toplamKDV'],
            'total'=> $toplamlar['genelToplam'],
            'format_discount' => $form_data['discount_format'],
            'discount_rate' => $form_data['discount_rate'] ?? 0,
            'taxstatus' => $tax_status,
            'tax_oran' => $form_data['kdv_oran'],
            'kur_degeri' => $form_data['kur_degeri'],
            'loc' =>$this->session->userdata('set_firma_id'),
            'eid' => $this->aauth->get_user()->id,
        ];
        if ($this->db->insert('geopos_invoices', $data_invoice)) {
            $insert_id = $this->db->insert_id();
            // Nakliye verileri ekleniyor
            if (!empty($form_data['search_input_nakliye'])) {
                foreach ($form_data['search_input_nakliye'] as $aid) {
                    $data_nakliye = ['nakliye_id' => $aid, 'invoice_id' => $insert_id];
                    $this->db->insert('nakliye_to_invoice', $data_nakliye);
                }
            }

            // forma2 verileri
            if (!empty($form_data['forma_2_id'])) {
                foreach ($form_data['forma_2_id'] as $aid) {
                    $data_forma2 = ['forma_2_id' => $aid, 'invoice_id' => $insert_id];
                    $this->db->insert('invoice_to_forma_2', $data_forma2);
                }
            }
            $kayit=0;
            $productlist = [];
            foreach ($product_data as $key => $value) {
                $product_name = $this->product_name_invoice_type($form_data['invoice_type_id'],$value['product_id']);
                $total_tax = $this->item_total_hesap($value['product_price'],$value['product_qty'],$value['edv_oran'],$value['indirim_oran'],$form_data['discount_format'])['total_tax'];
                $total_discount = $this->item_total_hesap($value['product_price'],$value['product_qty'],$value['edv_oran'],$value['indirim_oran'],$form_data['discount_format'])['total_discount'];
                $data_products = [
                    'tid' => $insert_id,
                    'pid' => $value['product_id'],
                    'product' => $product_name,
                    'unit' => $value['product_unit_id'],
                    'price' => $value['product_price'],
                    'qty' => $value['product_qty'],
                    'tax' => $value['edv_oran'],
                    'totaltax' => $total_tax,
                    'discount' => $value['indirim_oran'],
                    'totaldiscount' => $total_discount,
                    'subtotal' => $value['cemi_edvsiz'],
                    'product_des' => $product_name,
                    'proje_id' => $form_data['proje_id'],
                    'depo_id' =>0,
                    'invoice_type_id' => $form_data['invoice_type_id'],
                    'demirbas_id' => $value['product_demirbas_id'],
                    'invoice_type_desc' => invoice_type_id($form_data['invoice_type_id'])
                ];

                if ($this->db->insert('geopos_invoice_items', $data_products)) {
                    $productlist[$kayit] = $data_products;
                    $insert_id_item_id = $this->db->insert_id();
                    if($value['product_stock_code_id_input']){
                        $varyasyon=[
                            'invoices_item_id'=>$insert_id_item_id,
                            'product_stock_code_id'=>$value['product_stock_code_id_input'],
                        ];
                        $this->db->insert('invoices_item_to_option',$varyasyon);
                    }
                    $kayit++;
                }
            }

            if(!empty($kayit)){
                if($this->db->insert_batch('geopos_project_items_gider', $productlist)){
                    $this->talep_history($insert_id,  $this->aauth->get_user()->id,' Qaime Oluşturuldu');

                    return [
                        'status' => true,
                        'message' => 'Qaime Başarılı Bir Şekilde Oluşturuldu',
                        'id'=>$insert_id
                    ];

                }
                else {
                    return [
                        'status' => false,
                        'message' => 'Ürünler Qaimeye İşlenirken Hata Aldınız!'
                    ];
                }

            }


        }
        else {
            return [
                'status' => false,
                'message' => 'Qaime Oluşturulurken Hata Aldınız!'
            ];
        }
    }

    public function update_save()
    {
        $data = json_decode($_POST['data'], true);
        $form_data = $data['form_data'];
        $product_data = $data['product_data'];
        $toplamlar = $data['local_storage_data'];
        $invoice_id = $data['invoice_id'];
        $tax_status = !empty($form_data['taxformat']) ? 'yes' : 'no';

        $data_invoice_update = [
            'invoice_no' => $form_data['invoice_no'],
            'invoicedate' => $form_data['invoice_date'],
            'invoiceduedate' => $form_data['invocieduedate'],
            'refer' => $form_data['refer'],
            'alt_cari_id' => $form_data['alt_cari_id'],
            'para_birimi' => $form_data['para_birimi'],
            'invoice_type_id' => $form_data['invoice_type_id'],
            'invoice_type_desc' => invoice_type_id($form_data['invoice_type_id']),
            'notes' => $form_data['notes'],
            'csd' => $form_data['customer_id'],
            'proje_id' => $form_data['proje_id'],
            'bolum_id' => $form_data['bolum_id'],
            'asama_id' => $form_data['asama_id'],
            'subtotal'=> $toplamlar['araToplam'],
            'discount'=> $toplamlar['toplamIndirim'],
            'netToplam'=> $toplamlar['netToplam'],
            'tax'=> $toplamlar['toplamKDV'],
            'total'=> $toplamlar['genelToplam'],
            'format_discount' => $form_data['discount_format'],
            'discount_rate' => $form_data['discount_rate'] ?? 0,
            'taxstatus' => $tax_status,
            'tax_oran' => $form_data['kdv_oran'],
            'kur_degeri' => $form_data['kur_degeri'],
            'loc' =>$this->session->userdata('set_firma_id'),
            'eid' => $this->aauth->get_user()->id,
        ];

        $this->db->where('id', $invoice_id);
        if ($this->db->update('geopos_invoices', $data_invoice_update)) {

            $this->db->delete('nakliye_to_invoice', array('invoice_id' => $invoice_id));
            $this->db->delete('invoice_to_forma_2', array('invoice_id' => $invoice_id));
            $this->db->delete('geopos_invoice_items', array('tid' => $invoice_id));
            $this->db->delete('geopos_project_items_gider', array('tid' => $invoice_id));
            // Nakliye verileri ekleniyor
            if (!empty($form_data['search_input_nakliye'])) {
                foreach ($form_data['search_input_nakliye'] as $aid) {
                    $data_nakliye = ['nakliye_id' => $aid, 'invoice_id' => $invoice_id];
                    $this->db->insert('nakliye_to_invoice', $data_nakliye);
                }
            }
            // forma2 verileri
            if (!empty($form_data['forma_2_id'])) {
                foreach ($form_data['forma_2_id'] as $aid) {
                    $data_forma2 = ['forma_2_id' => $aid, 'invoice_id' => $invoice_id];
                    $this->db->insert('invoice_to_forma_2', $data_forma2);
                }
            }

            $kayit=0;
            $productlist = [];
            foreach ($product_data as $key => $value) {
                $product_name = $this->product_name_invoice_type($form_data['invoice_type_id'],$value['product_id']);
                $total_tax = $this->item_total_hesap($value['product_price'],$value['product_qty'],$value['edv_oran'],$value['indirim_oran'],$form_data['discount_format'])['total_tax'];
                $total_discount = $this->item_total_hesap($value['product_price'],$value['product_qty'],$value['edv_oran'],$value['indirim_oran'],$form_data['discount_format'])['total_discount'];
                $data_products = [
                    'tid' => $invoice_id,
                    'pid' => $value['product_id'],
                    'product' => $product_name,
                    'unit' => $value['product_unit_id'],
                    'price' => $value['product_price'],
                    'qty' => $value['product_qty'],
                    'tax' => $value['edv_oran'],
                    'totaltax' => $total_tax,
                    'discount' => $value['indirim_oran'],
                    'totaldiscount' => $total_discount,
                    'subtotal' => $value['cemi_edvsiz'],
                    'product_des' => $product_name,
                    'proje_id' => $form_data['proje_id'],
                    'depo_id' =>0,
                    'invoice_type_id' => $form_data['invoice_type_id'],
                    'demirbas_id' => $value['product_demirbas_id'],
                    'invoice_type_desc' => invoice_type_id($form_data['invoice_type_id'])
                ];

                if ($this->db->insert('geopos_invoice_items', $data_products)) {
                    $productlist[$kayit] = $data_products;
                    $insert_id_item_id = $this->db->insert_id();
                    if($value['product_stock_code_id_input']){
                        $varyasyon=[
                            'invoices_item_id'=>$insert_id_item_id,
                            'product_stock_code_id'=>$value['product_stock_code_id_input'],
                        ];
                        $this->db->insert('invoices_item_to_option',$varyasyon);
                    }
                    $kayit++;
                }
            }

            if(!empty($kayit)){
                if($this->db->insert_batch('geopos_project_items_gider', $productlist)){
                    $this->talep_history($invoice_id,  $this->aauth->get_user()->id,' Qaime Güncellendi');

                    return [
                        'status' => true,
                        'message' => 'Qaime Başarılı Bir Şekilde Güncellendi',
                        'id'=>$invoice_id
                    ];

                }
                else {
                    return [
                        'status' => false,
                        'message' => 'Ürünler Qaimeye İşlenirken Hata Aldınız!'
                    ];
                }

            }
            // Güncelleme başarılı
        } else {
            // Güncelleme başarısız
            return [
                'status' => false,
                'message' => 'Qaime Oluşturulurken Hata Aldınız!'
            ];
        }

    }
    public function get_search_input_nakliye($invoice_id)
    {
       $this->db->select('nakliye_id,talep_form_nakliye.code');
        $this->db->from('nakliye_to_invoice');
        $this->db->join('talep_form_nakliye','nakliye_to_invoice.nakliye_id = talep_form_nakliye.id');
        $this->db->where('nakliye_to_invoice.invoice_id',$invoice_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_search_input_forma_2($invoice_id)
    {
       $this->db->select('geopos_invoices.id,geopos_invoices.invoice_no');
        $this->db->from('invoice_to_forma_2');
        $this->db->join('geopos_invoices','invoice_to_forma_2.forma_2_id = geopos_invoices.id');
        $this->db->where('invoice_to_forma_2.invoice_id',$invoice_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function product_name_invoice_type($invoice_type_id,$product_id){
        if ($invoice_type_id == 2) {
            $this->db->select('product_name');
            $this->db->from('geopos_products');
            $this->db->where('pid', $product_id);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->row()->product_name; // Ürün adı döndürülür
            } else {
                return null; // Ürün bulunamadığında null döndür
            }
        }
    }
    public function item_total_hesap($price, $qty, $edv_oran, $discount_oran, $discount_format)
    {
        // KDV'siz toplam tutar
        $total = $price * $qty;

        // İndirim hesaplama
        $discount = 0;
        if ($discount_oran > 0) {
            if ($discount_format === '%') {
                $discount = ($total * $discount_oran) / 100; // Yüzde indirimi
            } elseif ($discount_format === 'flat') {
                $discount = $discount_oran; // Sabit indirim
            }
        }

        // İndirimli toplam tutar
        $total_after_discount = $total - $discount;

        // KDV hesaplama
        $total_tax = 0;
        if ($edv_oran > 0) {
            $total_tax = ($total_after_discount * $edv_oran) / 100; // KDV oranı
        }

        // Sonuçları döndür
        return [
            'total_tax' => $total_tax,
            'total_discount' => $discount
        ];
    }

    public function qaime_onay()
    {
        $onay_id = $this->input->post('onay_id', true);
        $invoice_id = $this->input->post('invoice_id', true);
        $user_id = $this->aauth->get_user()->id;
        $invoice_details  = $this->details($invoice_id);
        $talep_status = $invoice_details->status;

        if ($talep_status == 3) {
            return [
                'status' => false,
                'message' => 'Qaime İptal Edilmiştir. Durum Bildirilemez'
            ];
        }
        // 1. Onayı veren kullanıcıyı güncelle
        $onay_guncelle = $this->db->where('id', $onay_id)
            ->where('user_id', $user_id)
            ->update('invoices_onay_new', [
                'status' => 1,
                'staff' => 0,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        if (!$onay_guncelle || $this->db->affected_rows() === 0) {
            return [
                'status' => false,
                'message' => 'Yetkiniz bulunmamaktadır veya bu onay zaten tamamlanmış.'
            ];
        }

        // 2. Sıradaki onay kullanıcısını bul
        $sonraki_kullanici = $this->db->select('*')
            ->from('invoices_onay_new')
            ->where('invoices_id', $invoice_id)
            ->where('type', 1)
            ->where('status', null)
            ->order_by('sort', 'ASC')
            ->get()
            ->row();

        if ($sonraki_kullanici) {
            // Sıradaki kullanıcıyı aktif yap
            $this->db->where('id', $sonraki_kullanici->id)
                ->update('invoices_onay_new', [
                    'staff' => 1
                ]);

            // Talep geçmişine kayıt ekle
            $this->talep_history($invoice_id, $user_id,' Onay Verildi');
            return [
                'status' => true,
                'message' => 'Onay başarılı, sıradaki kullanıcıya geçildi.'
            ];
        }


        // 3. Eğer sıradaki kullanıcı yoksa talep tamamlandı olarak işaretle
        $talep_guncelle = $this->db->where('id', $invoice_id)
            ->update('geopos_invoices', ['status' => 22]); // 3: Talep Onaylandı

        if ($talep_guncelle) {
            $this->talep_history($invoice_id, $user_id,' Onaylar Başarıyla Tamamlandı');
            return [
                'status' => true,
                'message' => 'Talep başarıyla tamamlandı.'
            ];
        }

        // 4. Genel hata durumu
        return [
            'status' => false,
            'message' => 'Talep durumu güncellenirken bir hata oluştu.'
        ];
    }

    public function reverseonay()
    {
        // POST verilerini alın
        $onay_id = $this->input->post('onay_id', true);
        $invoice_id = $this->input->post('invoice_id', true);
        $personel_id = $this->input->post('personel_id', true);
        $text = $this->input->post('text', true);
        $user_id = $this->aauth->get_user()->id;

        // Fatura detaylarını al (gerekiyorsa)
        $invoice_details = $this->details($invoice_id);

        // Veritabanı işlemlerine başla
        $this->db->trans_start();

        // 1. Onayı geri çeken kişinin durumunu sıfırla
        $this->db->set('status', NULL)
            ->set('staff', 0)
            ->where('id', $onay_id)
           ->where('user_id', $user_id)
            ->update('invoices_onay_new');
        if ($this->db->affected_rows() > 0) {
            $sort  = $this->db->query("SELECT sort FROM invoices_onay_new WHERE id = $onay_id")->row()->sort;


            // 2. Geri gönderilen kişiden önceleri durumunu NULL yap
            $this->db->set('status', NULL)
                ->set('staff', 0)
                ->where('invoices_id', $invoice_id)
                ->where('type', 1)
                ->where('sort < '.$sort)
                ->update('invoices_onay_new');
            if ($this->db->affected_rows() > 0) {
                $min_id = $this->db->select_min('id')
                    ->from('invoices_onay_new')
                    ->where('invoices_id', $invoice_id)
                    ->where('type', 1)
                    ->where('user_id', $personel_id)
                    ->get()
                    ->row()
                    ->id;
                // Eğer bir sonuç bulunursa güncelleme yap
                if ($min_id) {
                    $this->db->set('status', NULL)
                        ->set('staff', 1)
                        ->where('id', $min_id) // Sadece en küçük ID'yi günceller
                        ->update('invoices_onay_new');
                }
            }
            else {
                // Tüm Onayları Sil OBildirim Durumunu 0 Yap Talebi Açana Mail at
                if ($this->db->delete('invoices_onay_new', array('invoices_id' => $invoice_id, 'type' => 1))) {
                    $this->db->set('bildirim_durumu', 0)
                        ->where('id', $invoice_id)
                        ->update('geopos_invoices');
                    $this->send_mail($personel_id,'#'.$invoice_details->invoice_no.' Nolu Qaime Onayları Geri Alındı',$text);
                }
            }
            $this->talep_history($invoice_id,  $this->aauth->get_user()->id,' Qaime '.personel_details($personel_id).' Adlı Personelenin Onayına Tekrar Sunuldu.Açıklama : '.$text);
            $this->db->trans_complete();
            // İşlemin başarılı olup olmadığını kontrol et
            if ($this->db->trans_status() === FALSE) {
                return [
                    'status' => false,
                    'message' => 'Güncelleme sırasında bir hata oluştu.'
                ];
            }
            return [
                'status' => true,
                'message'=>'Başarıyla Güncellendi.'
            ];
        }
        else {
            return [
                'status' => false,
                'message' => 'Yetkiniz Yoktur.'
            ];
        }



    }

    public function talep_history($id,$user_id,$desc,$type=1){
        $data_step = array(
            'talep_id' => $id,
            'user_id' => $user_id,
            'desc' => $desc,
            'type' => $type,
        );
        $this->db->insert('invoice_history', $data_step);
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
        $this->db->select('invoice_history.*,geopos_employees.name as pers_name');
        $this->db->from('invoice_history');
        $this->db->join('geopos_employees','invoice_history.user_id=geopos_employees.id');
        $this->db->where('invoice_history.talep_id',$id);
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
        $this->db->order_by('`invoice_history`.`id` DESC');

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

    public function send_mail($user_id,$subject,$message){
        if(!$user_id){
            return 0;
        }
        else {
            $message .= "<br><br><br><br>";
            $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
            $proje_sorumlusu_email = personel_detailsa($user_id)['email'];
            $recipients = array($proje_sorumlusu_email);
            $this->communication_model->onay_mail($recipients, $subject, $message, false,'', 'gider_talep_onay_maili');
            return 1;
        }
    }


}