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





class Malzemetalepform_model extends CI_Model
{
    private $column_search_history = [
        'malzemetalep_history.desc',            // Açıklama
        'malzemetalep_history.type',            // Tip
        'malzemetalep_history.created_at',      // Tarih
        'geopos_employees.name',       // Çalışan adı
    ];

    public function __construct()
    {
        parent::__construct();

    }

    public function create_save()
    {
        // POST verilerini alın
        $progress_status_id = $this->input->post('progress_status_id', true); // XSS koruması ekledik
        $talep_eden_user_id = $this->input->post('talep_eden_user_id', true);
        $proje_id = $this->input->post('proje_id', true);
        $bolum_id = $this->input->post('bolum_id', true);
        $asama_id = $this->input->post('asama_id', true);
        $desc = $this->input->post('desc', true);

        // Zorunlu alanların doğrulanması
        if (empty($progress_status_id) || empty($talep_eden_user_id) || empty($proje_id) || empty($bolum_id) || empty($asama_id)) {
            return [
                'status' => false,
                'message' => 'Tüm zorunlu alanları doldurunuz.',
            ];
        }

        // Talep numarası oluştur
        $talep_no = numaric(2);
        $warehouse = proje_to_warehouse($proje_id);

        if ($warehouse) {
            $warehouse_id = $warehouse->id;
        } else {
            return [
                'status' => false,
                'message' => 'Seçilen Projenin Deposu Tanımlanmamış.',
            ];
        }

        // Veri hazırlama
        $data = [
            'code' => $talep_no,
            'progress_status_id' => $progress_status_id,
            'talep_eden_user_id' => $talep_eden_user_id,
            'proje_id' => $proje_id,
            'desc' => $desc,
            'warehouse_id'=>$warehouse_id,
            'aauth' => $this->aauth->get_user()->id,
            'bolum_id' => $bolum_id,
            'asama_id' => $asama_id,
            'loc' => $this->session->userdata('set_firma_id'),
        ];

        // Veritabanı işlemine başla
        if ($this->db->insert('malzemetalepform', $data)) {
            $last_id = $this->db->insert_id();

            // Talep numarası sayacını güncelle
            numaric_update(2);

            // Talep geçmişine ekle
            $this->talep_history($last_id, $this->aauth->get_user()->id, 'Malzeme Talebi Oluşturuldu');

            // Veritabanı işlemini tamamla

            // İşlem başarılı
            return [
                'status' => true,
                'id' => $last_id,
                'message' => 'Başarılı Bir Şekilde Talebiniz Oluştu. Talebe Detayları Eklemek İçin Tıklayınız',
            ];
        } else {
            // İşlem başarısız, geri al
            return [
                'status' => false,
                'message' => 'Talep oluşturulurken bir hata oluştu.',
            ];
        }
    }

    public function create_form_items()
    {
        $details = $this->details($this->input->post('talep_id'));
        if ($details->status != 1 && $details->status != 2) {
            return [
                'status' => false,
                'message' => 'Bu Aşamada Ürün eklenemez'
            ];
        }

        //Aynı Ürün Kontrolü

        $kontrol = $this->db->query(
            "SELECT id FROM malzemetalepform_products WHERE product_id = ? AND product_stock_code_id = ? AND form_id = ?",
            [$this->input->post('product_id'), $this->input->post('product_stock_code_id'), $this->input->post('talep_id')]
        );

        if($kontrol->num_rows()){
            return [
                'status' => false,
                'message' => 'Aynı Üründen Daha Önce Eklediniz Miktar Artırma Yapabilirsiniz'
            ];
        }

        // Giriş verilerini al
        $data = [
            'product_id' => $this->input->post('product_id'),
            'progress_status_id' => $this->input->post('progress_status_id'),
            'product_desc' => $this->input->post('product_desc'),
            'product_kullanim_yeri' => $this->input->post('product_kullanim_yeri'),
            'product_temin_date' => $this->input->post('product_temin_date'),
            'unit_id' => $this->input->post('unit_id'),
            'product_qty' => $this->input->post('product_qty'),
            'form_id' => $this->input->post('talep_id'),
            'product_stock_code_id' => $this->input->post('product_stock_code_id'),
            'aauth' => $this->aauth->get_user()->id
        ];
        // Veritabanına ekleme işlemi
        if ($this->db->insert('malzemetalepform_products', $data)) {
            $talep_form_products_id = $this->db->insert_id();

            // Varyasyon adı belirle
            $varyasyon_name = '';
            if (!empty($data['product_stock_code_id'])) {
                $stock_code = $this->db->get_where('product_stock_code', ['id' => $data['product_stock_code_id']])->row();
                $varyasyon_name = $stock_code ? $stock_code->code : '';
            }

            // Ürün ve birim bilgilerini al
            $product_details = product_details_($data['product_id']);
            $product_name = $product_details->product_name ?? 'Bilinmiyor';
            $unit_name = units_($data['unit_id'])['name'] ?? 'Birim Yok';

            // Talep geçmişi ve log kaydı
            $this->talep_history(
                $data['form_id'],
                $data['aauth'],
                'Ürün Eklendi : ' . $product_name . ' | ' . $data['product_qty'] . ' ' . $unit_name
            );
            $this->aauth->applog(
                "Malzeme Talebine Ürünler Eklendi  : Talep ID : " . $data['form_id'],
                $this->aauth->get_user()->username
            );

            $product_details = product_details_($this->input->post('product_id'));
            $image = base_url().$product_details->image;
            if($this->input->post('product_stock_code_id')){
                //parent bilgileri
                $product_details = product_full_details_parent($this->input->post('product_id'));
                $image = base_url().$product_details['image'];
            }
            $prg_status = progress_status_details($this->input->post('progress_status_id'));
            return [
                'status' => true,
                'image' => $image,
                'tanim' => $this->input->post('product_desc'),
                'product_kullanim_yeri' => $this->input->post('product_kullanim_yeri'),
                'talep_form_products_id' => $talep_form_products_id,
                'product_name' => $product_name,
                'prg_status' => $prg_status->name,
                'qyt_birim' => amountFormat_s($this->input->post('product_qty')),
                'birim'=>$unit_name,
                'product_temin_date'=>$this->input->post('product_temin_date'),
                'option_html' => $varyasyon_name,
                'product_status' => malzemetalepstatus(1)->name,
                'message' => 'Başarıyla ürün eklendi'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Ürün eklenirken bir hata oluştu'
            ];
        }
    }

    public function create_form_items_stock()
    {
        //Aynı Ürün Kontrolü

        $kontrol = $this->db->query(
            "SELECT id FROM malzemetalepform_products WHERE product_id = ? AND product_stock_code_id = ? AND form_id = ?",
            [$this->input->post('product_id'), $this->input->post('product_stock_code_id'), $this->input->post('talep_id')]
        );

        if($kontrol->num_rows()){
            return [
                'status' => false,
                'message' => 'Aynı Üründen Daha Önce Eklediniz Miktar Artırma Yapabilirsiniz'
            ];
        }

        // Giriş verilerini al
        $data = [
            'product_id' => $this->input->post('product_id'),
            'progress_status_id' => $this->input->post('progress_status_id'),
            'product_desc' => $this->input->post('product_desc'),
            'product_kullanim_yeri' => $this->input->post('product_kullanim_yeri'),
            'product_temin_date' => $this->input->post('product_temin_date'),
            'unit_id' => $this->input->post('unit_id'),
            'product_qty' => $this->input->post('product_qty'),
            'form_id' => $this->input->post('talep_id'),
            'product_stock_code_id' => $this->input->post('product_stock_code_id'),
            'aauth' => $this->aauth->get_user()->id,
            'basvuru_status' => 1,
            'status' => 2,
            'stock_status' => 0,
        ];
        // Veritabanına ekleme işlemi
        if ($this->db->insert('malzemetalepform_products', $data)) {
            $talep_form_products_id = $this->db->insert_id();

            // Varyasyon adı belirle
            $varyasyon_name = '';
            if (!empty($data['product_stock_code_id'])) {
                $stock_code = $this->db->get_where('product_stock_code', ['id' => $data['product_stock_code_id']])->row();
                $varyasyon_name = $stock_code ? $stock_code->code : '';
            }

            // Ürün ve birim bilgilerini al
            $product_details = product_details_($data['product_id']);
            $product_name = $product_details->product_name ?? 'Bilinmiyor';
            $unit_name = units_($data['unit_id'])['name'] ?? 'Birim Yok';

            // Talep geçmişi ve log kaydı
            $this->talep_history(
                $data['form_id'],
                $data['aauth'],
                'Ürün Eklendi : ' . $product_name . ' | ' . $data['product_qty'] . ' ' . $unit_name
            );
            $this->aauth->applog(
                "Malzeme Talebine Ürünler Eklendi  : Talep ID : " . $data['form_id'],
                $this->aauth->get_user()->username
            );

            $product_details = product_details_($this->input->post('product_id'));
            $image = base_url().$product_details->image;
            if($this->input->post('product_stock_code_id')){
                //parent bilgileri
                $product_details = product_full_details_parent($this->input->post('product_id'));
                $image = base_url().$product_details['image'];
            }
            $prg_status = progress_status_details($this->input->post('progress_status_id'));
            return [
                'status' => true,
                'image' => $image,
                'tanim' => $this->input->post('product_desc'),
                'product_kullanim_yeri' => $this->input->post('product_kullanim_yeri'),
                'talep_form_products_id' => $talep_form_products_id,
                'product_name' => $product_name,
                'prg_status' => $prg_status->name,
                'product_status' => malzemetalepstatus(2)->name,
                'qyt_birim' => amountFormat_s($this->input->post('product_qty')),
                'birim'=>$unit_name,
                'product_temin_date'=>$this->input->post('product_temin_date'),
                'option_html' => $varyasyon_name,
                'message' => 'Başarıyla ürün eklendi'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Ürün eklenirken bir hata oluştu'
            ];
        }
    }

    public function details($id)
    {
        $this->db->select('*');
        $this->db->from('malzemetalepform');
        $this->db->where('malzemetalepform.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function talep_products($id)
    {
        $this->db->select('*');
        $this->db->from('malzemetalepform_products');
        $this->db->where('form_id',$id);
        $this->db->where('stock_status',0);
        $query = $this->db->get();
        return $query->result();
    }

    public function talep_products_cari_personel($id)
    {
        $user_id = $this->aauth->get_user()->id;

        $this->db->select('malzemetalepform_products.*');
        $this->db->from('malzemetalepform_products');
        $this->db->join(
            'malzemetalep_products_satinalma_atamalari',
            'malzemetalepform_products.id = malzemetalep_products_satinalma_atamalari.item_id',
            'inner'
        );
        $this->db->where('malzemetalep_products_satinalma_atamalari.satinalma_user_id', $user_id);
        $this->db->where('malzemetalepform_products.form_id', $id);
        $this->db->where('malzemetalepform_products.stock_status', 0);
        $this->db->where('malzemetalepform_products.status', 5);

        $query = $this->db->get();

        return $query->result();
    }
    public function talep_products_basvuru($id)
    {

        $status = $this->details($id)->status;


        $this->db->select('*');
        $this->db->from('malzemetalepform_products');
        $this->db->where('form_id',$id);
        $this->db->where('basvuru_status',0);
        $query = $this->db->get();
        return $query->result();
    }
    public function talep_products_details($id)
    {
        $this->db->select('*');
        $this->db->from('malzemetalepform_products');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function talep_history($id,$user_id,$desc){
        $data_step = array(
            'talep_id' => $id,
            'user_id' => $user_id,
            'desc' => $desc,
        );
        $this->db->insert('malzemetalep_history', $data_step);
    }

    public function update_qty()
    {
        $item_id = $this->input->post('item_id');
        $varyant = talep_form_product_options_new($item_id);

        $qyt = $this->input->post('qty');

        // Ürün detaylarını getir
        $product_details = $this->talep_products_details($item_id);

        if (!$product_details) {
            return [
                'status' => false,
                'message' => 'Ürün bulunamadı.'
            ];
        }

        $form_id = $product_details->form_id;
        $form_Details = $this->details($form_id);
        if($form_Details->status == 1 || $form_Details->status == 2 ){
            $old_qty = amountFormat_s($product_details->product_qty) . ' ' . units_($product_details->unit_id)['name'];
            $product_name = $product_details->product_desc.' | '.$varyant;
            $new_qty = amountFormat_s($qyt) . ' ' . units_($product_details->unit_id)['name'];

            $text = "Miktar Güncellendi. Ürün Adı: $product_name | Eski Miktar: $old_qty | Yeni Miktar: $new_qty";

            // Veriyi güncelle
            $data = [
                'product_qty' => floatval($qyt),
            ];

            if ($this->db->where('id', $item_id)->update('malzemetalepform_products', $data)) {
                // Güncelleme başarılı, tarihçeye kaydet
                $this->talep_history($form_id, $this->aauth->get_user()->id, $text);

                return [
                    'status' => true,
                    'message' => 'Başarılı bir şekilde güncellendi.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Güncelleme yapılırken hata aldınız.'
                ];
            }
        }
        else {
            return [
                'status' => false,
                'message' => 'Bu Aşamada Güncelleme Yapamazsınız!'
            ];
        }

    }


    public function delete_item()
    {
        $item_id = $this->input->post('item_id');

        // Ürün detaylarını al
        $product_details = $this->talep_products_details($item_id);

        if (!$product_details) {
            return [
                'status' => false,
                'message' => 'Ürün bulunamadı.'
            ];
        }

        $varyant = talep_form_product_options_new($item_id);
        $form_id = $product_details->form_id;
        $product_desc = $product_details->product_desc.' | '.$varyant;

        // Ürünü sil
        if ($this->db->where('id', $item_id)->delete('malzemetalepform_products')) {
            // Silme işlemi başarılıysa tarihçeye kaydet
            $this->talep_history($form_id, $this->aauth->get_user()->id, "Ürün Silindi: $product_desc");

            return [
                'status' => true,
                'message' => 'Başarılı bir şekilde kaldırıldı.'
            ];
        } else {
            // Silme işlemi başarısızsa hata döndür
            return [
                'status' => false,
                'message' => 'Silme işlemi sırasında bir hata oluştu.'
            ];
        }
    }

    public function delete_item_basvuru()
    {
        $item_id = $this->input->post('item_id');

        // Ürün detaylarını al
        $product_details = $this->talep_products_details($item_id);

        if (!$product_details) {
            return [
                'status' => false,
                'message' => 'Ürün bulunamadı.'
            ];
        }

        $varyant = talep_form_product_options_new($item_id);
        $form_id = $product_details->form_id;
        $product_desc = $product_details->product_desc.' | '.$varyant;

        // Ürünü sil
        $data = [
            'stock_status' => 1
        ];
        if(  $this->db->where('id', $item_id)->update('malzemetalepform_products', $data)){
            // Silme işlemi başarılıysa tarihçeye kaydet
            $this->talep_history($form_id, $this->aauth->get_user()->id, "Stok Kontrolünden Ürün Silindi: $product_desc");

            return [
                'status' => true,
                'message' => 'Başarılı bir şekilde kaldırıldı.'
            ];
        } else {
            // Silme işlemi başarısızsa hata döndür
            return [
                'status' => false,
                'message' => 'Silme işlemi sırasında bir hata oluştu.'
            ];
        }
    }


    public function stok_kontrol_onayi()
    {
        $talep_id = $this->input->post('talep_id', true);
        $details = $this->details($talep_id);
        if($details->status==2){
            return [
                'status' => false,
                'message' => 'Daha Önceden Onaya Sunulmuştur.'
            ];
        }
        // İşlem Veritabanı Güvenliği (Transaction) Başlat
        $this->db->trans_begin();
        // Talep ana tablosunu güncelle
        $data = [
            'bildirim_durumu' => 1,
            'status' => 2,
        ];
        $this->db->where('id', $talep_id)->update('malzemetalepform', $data);
        // Talep ürün tablosunu güncelle
        $data_item = [
            'status' => 2,
        ];
        $this->db->where('form_id', $talep_id)->update('malzemetalepform_products', $data_item);

        // Talep geçmişine ekle
        $this->talep_history($talep_id, $this->aauth->get_user()->id, 'Stok Kontrol Onayına Sunuldu');

        // İşlem kontrolü
        if ($this->db->trans_status() === FALSE) {
            // Hata durumunda geri al
            $this->db->trans_rollback();
            return [
                'status' => false,
                'message' => 'Güncelleme yapılırken bir hata oluştu.'
            ];
        } else {


            $onay_result = onay_sort_new(2,0,$talep_id,2);
            if($onay_result['status']){
                // Başarılı durumunda işlemi tamamla
                $this->db->trans_commit();
                return [
                    'status' => true,
                    'message' => 'Başarılı bir şekilde stok kontrol onayına sunuldu.'
                ];
            }
            else {
                return [
                    'status' => false,
                    'message' => $onay_result['message']
                ];
            }

        }
    }

    public function ajax_list_history($id)
    {
        // Listeleme sorgusunu çağır
        $this->_ajax_list_history($id);

        // Limit ve offset kontrolü
        if (isset($_POST['length']) && $_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start'] ?? 0);
        }

        $query = $this->db->get();

        return $query->result();
    }

    private function _ajax_list_history($id)
    {
        // Tablo seçim kontrolü
        $table = 'malzemetalep_history';

        // Tabloyu ve filtreleri ayarla
        $this->db->select('malzemetalep_history.*,geopos_employees.name')
            ->from($table)
            ->join('geopos_employees', 'malzemetalep_history.user_id = geopos_employees.id', 'left')
            ->where('talep_id', $id);

        // Arama işlemi
        if (!empty($_POST['search']['value'])) {
            $this->db->group_start(); // Parantez aç
            foreach ($this->column_search_history as $index => $item) {
                if ($index === 0) {
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
            }
            $this->db->group_end(); // Parantez kapat
        }

        // Sıralama
        $this->db->order_by('id', 'DESC');
    }

    public function count_filtered_talep_history($id)
    {
        $this->_ajax_list_history($id);
        return $this->db->count_all_results(); // Daha hızlı sorgu
    }

    public function count_all_talep_history($id)
    {
        // Toplam kayıt sayısı
        $table = 'malzemetalep_history';
        $this->db->from($table)
            ->where('talep_id', $id);

        return $this->db->count_all_results();
    }


    public function talep_form_onayi()
    {
        $onay_id = $this->input->post('onay_id', true);
        $talep_id = $this->input->post('talep_id', true);
        $user_id = $this->aauth->get_user()->id;
        $talep_details  = $this->details($talep_id);
        $talep_status = $talep_details->status;

        if ($talep_status == 4) {
            // Satın alma atamalarını kontrol et
            $atama_status = $this->checkSatinalmaAtamalari($talep_id);

            if (!$atama_status) {
                return [
                    'status' => false,
                    'message' => 'Ürünlerin satın alma atamaları tamamlanmamıştır.'
                ];
            }
        }
        // 1. Onayı veren kullanıcıyı güncelle
        $onay_guncelle = $this->db->where('id', $onay_id)
            ->where('kullanici_id', $user_id)
            ->where('onay_tipi', $talep_status)
            ->update('malzemetalepform_onaylari', [
                'onay_durumu' => 'Onaylandı',
                'is_staff' => 0,
                'onay_tarihi' => date('Y-m-d H:i:s')
            ]);

        if (!$onay_guncelle || $this->db->affected_rows() === 0) {
            return [
                'status' => false,
                'message' => 'Yetkiniz bulunmamaktadır veya bu onay zaten tamamlanmış.'
            ];
        }

        // 2. Sıradaki onay kullanıcısını bul
        $sonraki_kullanici = $this->db->select('*')
            ->from('malzemetalepform_onaylari')
            ->where('talep_id', $talep_id)
            ->where('onay_tipi', $talep_status)
            ->where('onay_durumu', 'Bekliyor')
            ->order_by('onay_sirasi', 'ASC')
            ->get()
            ->row();

        if ($sonraki_kullanici) {
            // Sıradaki kullanıcıyı aktif yap
            $this->db->where('id', $sonraki_kullanici->id)
                ->update('malzemetalepform_onaylari', [
                    'is_staff' => 1
                ]);

            $status_name = malzemetalepstatus($talep_status)->name;
            // Talep geçmişine kayıt ekle
            $this->talep_history($talep_id, $user_id, 'Aşama : '.$status_name.' | Onay Verildi');
            return [
                'status' => true,
                'message' => 'Onay başarılı, sıradaki kullanıcıya geçildi.'
            ];
        }

        $guncel_status = intval($talep_status)+1;
        // 3. Eğer sıradaki kullanıcı yoksa talep tamamlandı olarak işaretle
        $talep_guncelle = $this->db->where('id', $talep_id)
            ->update('malzemetalepform', ['status' => $guncel_status]); // 3: Talep Onaylandı

        if ($talep_guncelle) {

            $this->db->where('form_id', $talep_id)
                ->update('malzemetalepform_products', ['status' => $guncel_status]); // 3: Ürün Durumlarını Güncelle

            if($guncel_status!=5){
                $onay_result = onay_sort_new($guncel_status,0,$talep_id,$guncel_status);
                if($onay_result['status']){
                    // Başarılı durumunda işlemi tamamla
                    $this->talep_history($talep_id, $user_id, $guncel_status.' Onayları başarıyla tamamlandı.');
                    return [
                        'status' => true,
                        'message' => 'Talep başarıyla tamamlandı.'
                    ];
                }
                else {
                    return [
                        'status' => false,
                        'message' => 'Talep Tamamlanırken Hata Oluştu'
                    ];
                }
            }
            else {
                // cari bölümü için bir onay yoktur satınalma süreci başlar satınalmacılar teklifleri hazırlar
                $this->talep_history($talep_id, $user_id, $guncel_status.' Onayları başarıyla tamamlandı.');
                return [
                    'status' => true,
                    'message' => 'Talep başarıyla tamamlandı.'
                ];
            }



        }

        // 4. Genel hata durumu
        return [
            'status' => false,
            'message' => 'Talep durumu güncellenirken bir hata oluştu.'
        ];
    }

    private function checkSatinalmaAtamalari($talep_id)
    {
        $all_products = $this->talep_products($talep_id);

        foreach ($all_products as $item) {
            $status_sonuc = malzemetalep_item_satinalma($item->id)['status'];
            if (!$status_sonuc) {
                return false; // Herhangi bir ürünün ataması tamamlanmamış
            }
        }

        return true; // Tüm ürünlerin atamaları tamamlanmış
    }

    public function satinalma_user_atama()
    {
        $talep_id = $this->input->post('talep_id', true);
        $satinalma_user_id = $this->input->post('satinalma_user_id', true);
        $urunDetails = $this->input->post('urunDetails', true);
        $user_id = $this->aauth->get_user()->id;

        // Talep detaylarını kontrol et
        $talep_details = $this->details($talep_id);

        if (!$talep_details) {
            return [
                'status' => false,
                'message' => 'Talep bulunamadı.'
            ];
        }

        // Kullanıcının onay yetkisini kontrol et
        $result = $this->db->select('id')
            ->from('malzemetalepform_onaylari')
            ->where('onay_tipi', $talep_details->status)
            ->where('talep_id', $talep_id)
            ->where('kullanici_id', $user_id)
            ->where('is_staff', 1)
            ->order_by('onay_sirasi', 'ASC')
            ->get()
            ->row();

        if (!$result) {
            return [
                'status' => false,
                'message' => 'Yetkiniz mevcut değildir.'
            ];
        }

        // Satın alma atamaları
        if (empty($urunDetails)) {
            return [
                'status' => false,
                'message' => 'Ürün detayları boş olamaz.'
            ];
        }

        $insert_count = 0;

        foreach ($urunDetails as $value) {
            $item_id = $value['item_id'];

            $data = [
                'item_id' => $item_id,
                'form_id' => $talep_id,
                'satinalma_user_id' => $satinalma_user_id,
                'atama_yapan_user_id' => $user_id,
            ];

            // Kayıt mevcut mu kontrol et
            $exists = $this->db->where('item_id', $item_id)
                ->where('form_id', $talep_id)
                ->get('malzemetalep_products_satinalma_atamalari')
                ->row();

            if ($exists) {
                // Kayıt varsa güncelle
                $this->db->where('id', $exists->id)
                    ->update('malzemetalep_products_satinalma_atamalari', $data);
                $insert_count++;
            } else {
                // Kayıt yoksa ekle
                if ($this->db->insert('malzemetalep_products_satinalma_atamalari', $data)) {
                    $insert_count++;
                }
            }

            // Talep geçmişine kayıt ekle
            $product_details = $this->talep_products_details($item_id);
            $varyant = talep_form_product_options_new($item_id);
            $satinalma_personel = personel_detailsa($satinalma_user_id)['name'];
            $assigner_personel = personel_detailsa($user_id)['name'];

            $text = "{$product_details->product_desc} - {$varyant} ürünü {$satinalma_personel} personeline satın alma yapması için {$assigner_personel} tarafından atandı.";
            $this->talep_history($talep_id, $user_id, $text);
        }

        if ($insert_count > 0) {
            return [
                'status' => true,
                'message' => 'Başarılı bir şekilde atama yapıldı.'
            ];
        }

        return [
            'status' => false,
            'message' => 'Atama yapılırken hata oluştu.'
        ];
    }

    public function item_cari_atama()
    {
        $talep_id = $this->input->post('talep_id', true);
        $teklif_cari_id = $this->input->post('teklif_cari_id', true);
        $urunDetails = $this->input->post('urunDetails', true);
        $user_id = $this->aauth->get_user()->id;

        // Talep detaylarını kontrol et
        $talep_details = $this->details($talep_id);

        if (!$talep_details) {
            return [
                'status' => false,
                'message' => 'Talep bulunamadı.'
            ];
        }

        // Kullanıcının onay yetkisini kontrol et
        $yetki_kontrol = false;

// Tüm item_id'leri bir sorguda kontrol edelim
        $item_ids = array_column($urunDetails, 'item_id'); // Tüm item_id değerlerini al

        if (!empty($item_ids)) {
            $this->db->select('id')
                ->from('malzemetalep_products_satinalma_atamalari')
                ->where('satinalma_user_id', $user_id)
                ->where('form_id', $talep_id)
                ->where_in('item_id', $item_ids);

            $kontrol = $this->db->get();

            if ($kontrol->num_rows() > 0) {
                $yetki_kontrol = true;
            }
        }

        if (!$yetki_kontrol) {
            return [
                'status' => false,
                'message' => 'Yetkiniz mevcut değildir.'
            ];
        }


        // Satın alma atamaları
        if (empty($urunDetails)) {
            return [
                'status' => false,
                'message' => 'Ürün detayları boş olamaz.'
            ];
        }

        $insert_count = 0;

        foreach ($urunDetails as $value) {
            $item_id = $value['item_id'];

            foreach ($teklif_cari_id as $cari_id) { // Her bir cari_id için işlem yap
                $data = [
                    'item_id' => $item_id,
                    'form_id' => $talep_id,
                    'cari_id' => $cari_id,
                    'atama_yapan_user_id' => $user_id,
                ];

                // Kayıt mevcut mu kontrol et
                $exists = $this->db->where('item_id', $item_id)
                    ->where('form_id', $talep_id)
                    ->where('cari_id', $cari_id)
                    ->get('malzemetalep_products_cari_atamalari')
                    ->row();

                if ($exists) {
                    // Kayıt varsa güncelle
                    $this->db->where('id', $exists->id)
                        ->update('malzemetalep_products_cari_atamalari', $data);
                    $insert_count++;
                } else {
                    // Kayıt yoksa ekle
                    if ($this->db->insert('malzemetalep_products_cari_atamalari', $data)) {
                        $insert_count++;
                    }
                }

                // Talep geçmişine kayıt ekle
                $product_details = $this->talep_products_details($item_id);
                $varyant = talep_form_product_options_new($item_id);
                $teklif_cari_name = customer_details($cari_id)['company'];
                $assigner_personel = personel_detailsa($user_id)['name'];

                $text = "{$product_details->product_desc} - {$varyant} ürününe {$teklif_cari_name} Cari teklif vermesi için {$assigner_personel} tarafından atandı.";
                $this->talep_history($talep_id, $user_id, $text);
            }
        }


        if ($insert_count > 0) {
            return [
                'status' => true,
                'message' => 'Başarılı bir şekilde atama yapıldı.'
            ];
        }

        return [
            'status' => false,
            'message' => 'Atama yapılırken hata oluştu.'
        ];
    }

    public function teklif_asama_update()
    {
        $talep_id = $this->input->post('talep_id', true);
        $urunDetails = $this->input->post('urunDetails', true);
        $user_id = $this->aauth->get_user()->id;

        $talep_details = $this->details($talep_id);

        if (!$talep_details) {
            return [
                'status' => false,
                'message' => 'Talep bulunamadı.'
            ];
        }

        // Kullanıcının onay yetkisini kontrol et
        $yetki_kontrol = false;

// Tüm item_id'leri bir sorguda kontrol edelim
        $item_ids = array_column($urunDetails, 'item_id'); // Tüm item_id değerlerini al

        if (!empty($item_ids)) {
            $this->db->select('id')
                ->from('malzemetalep_products_satinalma_atamalari')
                ->where('satinalma_user_id', $user_id)
                ->where('form_id', $talep_id)
                ->where_in('item_id', $item_ids);

            $kontrol = $this->db->get();

            if ($kontrol->num_rows() > 0) {
                $yetki_kontrol = true;
            }
        }

        if (!$yetki_kontrol) {
            return [
                'status' => false,
                'message' => 'Yetkiniz mevcut değildir.'
            ];
        }


        // Satın alma atamaları
        if (empty($urunDetails)) {
            return [
                'status' => false,
                'message' => 'Ürün detayları boş olamaz.'
            ];
        }

        $insert_count = 0;

        foreach ($urunDetails as $value) {
            $item_id = $value['item_id'];

            $data = [
                'status' => 6,
            ];

            $this->db->where('id', $item_id)
                ->update('malzemetalepform_products', $data);
            $insert_count++;

            // Talep geçmişine kayıt ekle
            $product_details = $this->talep_products_details($item_id);
            $varyant = talep_form_product_options_new($item_id);
            $assigner_personel = personel_detailsa($user_id)['name'];

            $text = "{$product_details->product_desc} - {$varyant} ürünü {$assigner_personel} personeli tarafından teklif aşamasına alındı.";
            $this->talep_history($talep_id, $user_id, $text);
        }

        if ($insert_count > 0) {
            return [
                'status' => true,
                'message' => 'Başarılı bir şekilde Aşama Değiştirildi yapıldı.'
            ];
        }

        return [
            'status' => false,
            'message' => 'Atama yapılırken hata oluştu.'
        ];
    }

}