<?php
/**
 * İtalic Soft Yazılım  ERP - CRM - HRM
 * Copyright (c) İtalic Soft Yazılım. Tüm Hakları Saklıdır.
 * ***********************************************************************
 *
 *  Email: info@italicsoft.com
 *  Website: https://www.italicsoft.com
 *  Tel: 0850 317 41 44
 *  ******************************************tedtst***************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Malzemetalepform Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $selected_db = $this->session->userdata('selected_db');
        if (!empty($selected_db)) {
            $this->db = $this->load->database($selected_db, TRUE);
        }
        $this->load->model('Malzemetalepform_model', 'talep');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }
    public function index()
    {
        if (!$this->aauth->premission(31)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Malzame Talep Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('malzemetalepform/index');
        $this->load->view('fixed/footer');
    }

    public function create_save()
    {
        if (!$this->aauth->premission(97)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Malzeme Talebi Açmak İçin Yetkiniz Bulunmamaktadır.'));
            return;
        }

        $this->db->trans_start();
        $result = $this->talep->create_save();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => $result['message'], 'index' => '/malzemetalepform/view/' . $result['id']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => $result['message'] . ' Hata '));
        }
    }

    public function create_form_items()
    {
        if (!$this->aauth->premission(97)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Malzeme Talebi Açmak İçin Yetkiniz Bulunmamaktadır.'));
            return;
        }

        $this->db->trans_start();
        $result = $this->talep->create_form_items();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => $result['message'], 'data'=>$result));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => $result['message'] . ' Hata '));
        }
    }

    public function create_form_items_stock()
    {
        if (!$this->aauth->premission(97)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Malzeme Talebi Açmak İçin Yetkiniz Bulunmamaktadır.'));
            return;
        }

        $this->db->trans_start();
        $result = $this->talep->create_form_items_stock();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => $result['message'], 'data'=>$result));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => $result['message'] . ' Hata '));
        }
    }

    public function search_products()
    {
        $query = $this->input->post('query');

        // Sorgu uzunluğu kontrolü
        if (strlen($query) < 3) {
            echo json_encode(['success' => false, 'message' => 'En az 3 harf giriniz.']);
            return;
        }

        // Veritabanı sorgusu
        $keyword = $this->db->escape_like_str($query); // Güvenlik için input temizleme
        //CONCAT(geopos_products.product_name, ' ', geopos_products.product_name_tr, ' ', geopos_products.product_name_en) AS product_name,

        $query = $this->db->query(
            "SELECT 
    geopos_products.pid AS product_id,
    geopos_products.image AS images,
    geopos_products.product_name AS product_name,
    IF(product_stock_code.id, product_stock_code.code, 'varyasyon tanımlanmamış') AS varyasyon,
    IF(product_stock_code.id, product_stock_code.id, 0) AS product_stock_code_id,
    product_stock_code.code
FROM geopos_products
LEFT JOIN product_stock_code ON geopos_products.pid = product_stock_code.product_id
LEFT JOIN geopos_products_parent ON geopos_products_parent.product_stock_code_id = product_stock_code.id
WHERE geopos_products.deleted_at IS NULL
  AND (
      geopos_products_parent.tag LIKE '$keyword%' OR
      geopos_products.tag LIKE '$keyword%' OR
      product_stock_code.code LIKE '$keyword%' OR
      geopos_products.product_name LIKE '$keyword%' OR
      geopos_products.product_name_tr LIKE '$keyword%' OR
      geopos_products.product_name_en LIKE '$keyword%' OR
      geopos_products.product_code LIKE '$keyword%' OR
      geopos_products.barcode LIKE '$keyword%'
  )
GROUP BY product_stock_code.id
ORDER BY geopos_products.pid DESC
LIMIT 100;"
        );

        if ($query->num_rows() > 0) {
            echo json_encode(['success' => true, 'results' => $query->result()]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Sonuç bulunamadı.']);
        }
    }

    public function update_qty()
    {
        if (!$this->aauth->premission(97)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Malzeme Talebi Açmak İçin Yetkiniz Bulunmamaktadır.'));
            return;
        }

        $this->db->trans_start();
        $result = $this->talep->update_qty();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => $result['message']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => $result['message']));
        }
    }

    public function delete_item()
    {
        if (!$this->aauth->premission(97)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Ürün Silmek İçin Yetkiniz Bulunmamaktadır.'));
            return;
        }
        $this->db->trans_start();
        $result = $this->talep->delete_item();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => $result['message']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => $result['message']));
        }
    }

    public function delete_item_basvuru()
    {
        if (!$this->aauth->premission(97)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Ürün Silmek İçin Yetkiniz Bulunmamaktadır.'));
            return;
        }
        $this->db->trans_start();
        $result = $this->talep->delete_item_basvuru();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => $result['message']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => $result['message']));
        }
    }

    public function stok_kontrol_onayi()
    {
        if (!$this->aauth->premission(97)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Malzeme Talebi Açmak İçin Yetkiniz Bulunmamaktadır.'));
            return;
        }
        $this->db->trans_start();
        $result = $this->talep->stok_kontrol_onayi();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => $result['message']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => $result['message']));
        }
    }

    public function search_products_category()
    {
        $query = $this->input->post('query');
        $cat_id = $this->input->post('cat_id');

        // Sorgu uzunluğu kontrolü
        if (strlen($query) < 3) {
            echo json_encode(['success' => false, 'message' => 'En az 5 harf giriniz.']);
            return;
        }

        // Veritabanı sorgusu
        $keyword = $this->db->escape_like_str($query); // Güvenlik için input temizleme

        $query = $this->db->query(
            "SELECT
        geopos_products.pid AS product_id,
        geopos_products.image AS images,
        CONCAT(geopos_products.product_name, ' ', geopos_products.product_name_tr, ' ', geopos_products.product_name_en) AS product_name,
        IF(product_stock_code.id, product_stock_code.code, 'varyasyon tanımlanmamış') AS varyasyon,
        IF(product_stock_code.id, product_stock_code.id, 0) AS product_stock_code_id,
        product_stock_code.code
    FROM geopos_products
    LEFT JOIN product_stock_code ON geopos_products.pid = product_stock_code.product_id
    LEFT JOIN geopos_products_parent ON geopos_products_parent.product_stock_code_id = product_stock_code.id
    WHERE geopos_products.deleted_at IS NULL and (geopos_products_parent.pcat = $cat_id OR geopos_products.pcat = $cat_id)
      AND (
           geopos_products_parent.tag LIKE '$keyword%' OR
      geopos_products.tag LIKE '$keyword%' OR
      product_stock_code.code LIKE '$keyword%' OR
      geopos_products.product_name LIKE '$keyword%' OR
      geopos_products.product_name_tr LIKE '$keyword%' OR
      geopos_products.product_name_en LIKE '$keyword%' OR
      geopos_products.product_code LIKE '$keyword%' OR
      geopos_products.barcode LIKE '$keyword%'
      )
    GROUP BY product_stock_code.id
    ORDER BY geopos_products.pid DESC
    LIMIT 50"
        );
        if ($query->num_rows() > 0) {
            echo json_encode(['success' => true, 'results' => $query->result()]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Sonuç bulunamadı.']);
        }
    }


    public function view($id)
    {
        $head['title'] = 'Malzame Talep Görüntüleme';
        $history['talep_id']=$id;
        $data['details']= $this->talep->details($id);
        $this->load->view('fixed/header', $head); // Header sadece bir kez yüklenir
        $previous = $this->input->get('previous');
        // Talep durumu ve previous parametresi kontrolü
        $current_status = $data['details']->status;

        // Eğer previous mevcutsa ve current_status ile eşit değilse, previous değerini kullan
        $view_status = ($previous && $previous != $current_status) ? $previous : $current_status;

        switch ($view_status) {
            case 1: // Başvuru
                $data['talep_products']=$this->talep_products_return($this->talep->talep_products_basvuru($id));
                $this->load->view('malzemetalepform/view', $data);
                break;

            case 2: // Stok Kontrol
                $data['talep_products']=$this->talep_products_return($this->talep->talep_products($id));
                $this->load->view('malzemetalepform/stock_kontrol', $data);
                break;
            case 3: // Talep Onay
                $data['talep_products']=$this->talep_products_return($this->talep->talep_products($id));
                $this->load->view('malzemetalepform/talep_onay', $data);
                break;
            case 4: // Satın Alma Yönetimi
                $data['talep_products']=$this->talep_products_return($this->talep->talep_products($id));
                $this->load->view('malzemetalepform/satinalama_yonetim', $data);
                break;
            case 5: // cari süreci
                $data['talep_products']=$this->talep_products_return($this->talep->talep_products($id));
                $this->load->view('malzemetalepform/cari_yonetim', $data);
                break;
        }

        $this->load->view('malzemetalepform/talep_history',$history);
        $this->load->view('fixed/footer'); // Footer sadece bir kez yüklenir
    }

    public function cari_personel($id)
    {
        $head['title'] = 'Malzame Talep Görüntüleme';
        $history['talep_id']=$id;
        $data['details']= $this->talep->details($id);
        $this->load->view('fixed/header', $head); // Header sadece bir kez yüklenir

        $data['talep_products']=$this->talep_products_return($this->talep->talep_products_cari_personel($id));
        $this->load->view('malzemetalepform/cari_personel', $data);
        $this->load->view('malzemetalepform/talep_history',$history);
        $this->load->view('fixed/footer'); // Footer sadece bir kez yüklenir

    }

    private function talep_products_return($data)
    {
        $return = [];
        if (!empty($data)) {
            foreach ($data as $item) {
                // Ürün detaylarını al
                $product_details = product_details($item->product_id);
                $image = base_url() . ($product_details->image ?? 'default_image.png'); // Varsayılan resim kontrolü

                // Eğer ürün varyantı varsa farklı bir resim kullan
                if ($item->product_stock_code_id) {
                    $parent_details = product_full_details_parent($item->product_id);
                    $image = base_url() . ($parent_details['image'] ?? 'default_image.png');
                }

                // Durum ve aciliyet bilgilerini al
                $prg_status = progress_status_details($item->progress_status_id)->name ?? 'Bilinmiyor';
                $status = malzemetalepstatus($item->status);
                $status_badge = isset($status->badge_class) && isset($status->name)
                    ? "<span class='{$status->badge_class}'>{$status->name}</span>"
                    : 'Durum Bilinmiyor';

                // Ürün detaylarını oluştur
                $return[] = [
                    'id' => $item->id,
                    'product_name' => $product_details->product_name ?? 'Ürün Adı Yok',
                    'image' => $image,
                    'product_desc' => $item->product_desc ?? '',
                    'varyant' => talep_form_product_options_new($item->id),
                    'kullanim_yeri' => $item->product_kullanim_yeri ?? '',
                    'qty' => amountFormat_s($item->product_qty),
                    'birim' => units_($item->unit_id)['name'] ?? 'Birim Yok',
                    'temin_date' => $item->product_temin_date ?? '',
                    'aciliyet' => $prg_status,
                    'status' => $status_badge
                ];
            }
        }
        return $return;
    }




    public function ajax_list()
    {
        return [];
    }

    public function ajax_list_history()
    {
        $talep_id = $this->input->post('talep_id');

        if (!$talep_id) {
            echo json_encode([
                "status" => false,
                "message" => "Talep ID bulunamadı."
            ]);
            return;
        }

        $list = $this->talep->ajax_list_history($talep_id);

        $data = [];
        $no = $this->input->post('start') ?: 0; // Başlangıç numarası
        foreach ($list as $prd) {
            $pers_name = '';

            // Kullanıcı türüne göre isim belirleme
            if ($prd->type == 1) {
                $pers_name = personel_details($prd->user_id);
            } else {
                $customer_details = customer_details($prd->user_id);
                $pers_name = $customer_details['company'] ?? 'Müşteri bilgisi bulunamadı';
            }

            $no++;
            $data[] = [
                $pers_name,
                $prd->desc,
                $prd->created_at
            ];
        }

        $output = [
            "draw" => $_POST['draw'] ?? 0,
            "recordsTotal" => $this->talep->count_all_talep_history($talep_id),
            "recordsFiltered" => $this->talep->count_filtered_talep_history($talep_id),
            "data" => $data,
        ];

        // JSON çıktısı
        echo json_encode($output);
    }

    public function talep_form_onayi()
    {
        $this->db->trans_start();
        $result = $this->talep->talep_form_onayi();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => $result['message']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => $result['message']));
        }
    }

    public function satinalma_user_atama()
    {
        $this->db->trans_start();
        $result = $this->talep->satinalma_user_atama();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => $result['message']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => $result['message']));
        }
    }

    public function item_cari_atama()
    {
        $this->db->trans_start();
        $result = $this->talep->item_cari_atama();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => $result['message']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => $result['message']));
        }
    }
    public function teklif_asama_update()
    {
        $this->db->trans_start();
        $result = $this->talep->teklif_asama_update();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => $result['message']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => $result['message']));
        }
    }



}