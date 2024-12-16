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





class Projebolumleri_model extends CI_Model
{
    private $table_news = 'geopos_project_bolum';
    private $column_order = ['id', 'name', 'exp', 'butce'];
    private $column_search = ['id', 'name', 'exp', 'butce'];
    private $order = ['id' => 'DESC'];


    public function __construct()
    {
        parent::__construct();

        $this->load->model('projectsnew_model', 'proje_model_new');
    }

    private function _bolum_datatables_query($cday = '')
    {
        $this->db->from($this->table_news); // Dinamik tablo adı kullanımı

        $i = 0;

        foreach ($this->column_search as $item) { // Aranabilir sütunlar üzerinde döngü
            $search = $this->input->post('search');
            $value = $search['value'] ?? null;

            if ($value) {
                if ($i === 0) {
                    $this->db->group_start(); // İlk aramada grup başlat
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end(); // Son sütunda grup kapat
                }
            }
            $i++;
        }

        // Sıralama işlemi
        $order = $this->input->post('order');
        if ($order) {
            $this->db->order_by(
                $this->column_order[$order[0]['column']] ?? 'id',
                $order[0]['dir'] ?? 'ASC'
            );
        } else if (isset($this->order)) {
            $this->db->order_by(key($this->order), $this->order[key($this->order)]);
        }
    }

// Datatables sorgu sonucu
    public function bolumler_datatables($cday = '')
    {
        $this->_bolum_datatables_query($cday);

        // Limit ve başlangıç noktası
        $length = $this->input->post('length', true) ?? -1;
        $start = $this->input->post('start', true) ?? 0;

        if ($length != -1) {
            $this->db->limit($length, $start);
        }

        // Projeye göre filtreleme
        $this->db->where('pid', $cday);
        $query = $this->db->get();

        return $query->result();
    }

// Filtrelenmiş toplam sayısı
    public function bolum_count_filtered($cday = '')
    {
        $this->_bolum_datatables_query($cday);
        $this->db->where('pid', $cday);

        return $this->db->count_all_results(); // Daha hızlı işlem için count_all_results() kullanıldı
    }

// Toplam kayıt sayısı
    public function bolum_count_all($cday = '')
    {
        $this->db->from($this->table_news);
        $this->db->where('pid', $cday);

        return $this->db->count_all_results();
    }

    public function create()
    {
        // Kullanıcıdan gelen verileri al ve doğrula
        $name = $this->input->post('name', true);
        $content = $this->input->post('content', true);
        $butce = $this->input->post('butce', true);
        $code = $this->input->post('code', true);
        $simeta_code = $this->input->post('simeta_code', true);
        $prid = $this->input->post('project', true);

        // Gerekli alanların kontrolü
        if (empty($name) || empty($content) || empty($prid)) {
            return [
                'status' => 0,
                'message' => 'Tüm alanları doldurmanız gerekmektedir.',
                'id' => 0
            ];
        }

        // Kodları varsayılan değerlerle doldur
        $code = isEmptyFunction($code, numaric(46));
        $simeta_code = isEmptyFunction($simeta_code, $code);

        // Veritabanına kaydedilecek veriler
        $data = [
            'pid' => $prid,
            'name' => $name,
            'code' => $code,
            'butce' => !empty($butce) ? $butce : 0, // Bütçe boşsa 0 olarak ayarlanır
            'simeta_code' => $simeta_code,
            'exp' => $content
        ];

        // Veritabanına ekleme işlemi
        if ($this->db->insert('geopos_project_bolum', $data)) {
            $last_id = $this->db->insert_id();
            numaric_update(46);

            // Tarihçe kaydı ekle
            $this->proje_model_new->talep_history(
                $last_id,
                $this->aauth->get_user()->id,
                'Proje Bölümü Eklendi. Bölüm Adı: ' . $name
            );

            return [
                'status' => 1,
                'message' => 'Başarılı bir şekilde bölüm eklendi.',
                'id' => $last_id
            ];
        } else {
            return [
                'status' => 0,
                'message' => 'Hata aldınız. Yöneticiye başvurun.',
                'id' => 0
            ];
        }
    }


    public function update()
    {
        // Girdi verilerini alın
        $bolum_id = $this->input->post('bolum_id', true);
        $code = $this->input->post('code', true);
        $name = $this->input->post('name', true);
        $content = $this->input->post('content', true);
        $butce = $this->input->post('butce', true);
        $prid = $this->input->post('project', true);

        // Varsayılan değerler
        $code = isEmptyFunction($code, numaric(46));
        $simeta_code = isEmptyFunction($this->input->post('simeta_code', true), $code);

        // Zorunlu alan kontrolü
        if (empty($bolum_id) || empty($name) || empty($butce) || empty($prid)) {
            return [
                'status' => 0,
                'message' => 'Gerekli alanlar doldurulmadı. Lütfen tüm alanları doldurun.',
                'id' => 0,
            ];
        }

        // Güncellenecek veriler
        $data = [
            'pid' => $prid,
            'name' => $name,
            'code' => $code,
            'simeta_code' => $simeta_code,
            'butce' => $butce,
            'exp' => $content,
        ];

        // Veritabanında güncelleme
        $this->db->where('id', $bolum_id);
        if ($this->db->update('geopos_project_bolum', $data)) {
            // Güncelleme başarılıysa tarihçeye kaydet
            $this->proje_model_new->talep_history($prid, $this->aauth->get_user()->id, 'Proje Bölümü Düzenlendi. Bölüm Adı: ' . $name);

            return [
                'status' => 1,
                'message' => 'Başarılı bir şekilde bölüm güncellendi.',
                'id' => $bolum_id,
            ];
        } else {
            // Güncelleme başarısızsa hata mesajı döndür
            return [
                'status' => 0,
                'message' => 'Hata aldınız. Lütfen yöneticinizle iletişime geçin.',
                'id' => 0,
            ];
        }
    }


    public function delete()
    {
        // Kullanıcı kimlik doğrulama kontrolü
        if ($this->aauth->get_user()->id != 21) {
            return [
                'status' => 0,
                'message' => 'Yetkiniz Bulunmamaktadır',
                'id' => 0
            ];
        }
        // Bölüm ID'sini al
        $bolum_id = $this->input->post('bolum_id', true);
        // Bölüm detaylarını al
        $details = $this->details($bolum_id);
        // Bölüme bağlı aşama kontrolü
        $kontrol = $this->db->query("SELECT * FROM geopos_milestones WHERE bolum_id = ?", [$bolum_id])->num_rows();
        if (!$kontrol) {
            // Bölüm silme işlemi
            if ($this->db->delete('geopos_project_bolum', ['id' => $bolum_id])) {
                // Silme işlemi başarılıysa tarihçeye kaydet
                $this->proje_model_new->talep_history(
                    $details->pid,
                    $this->aauth->get_user()->id,
                    'Proje Bölümü Silindi. Bölüm Adı: ' . $details->name
                );
                return [
                    'status' => 1,
                    'message' => 'Başarılı Bir Şekilde Bölüm Silindi',
                    'id' => $bolum_id
                ];
            } else {
                // Silme işlemi başarısızsa hata döndür
                return [
                    'status' => 0,
                    'message' => 'Hata Aldınız. Yöneticiye Başvurun',
                    'id' => 0
                ];
            }
        } else {
            // Bölüme bağlı aşama varsa silme işlemi engellenir
            return [
                'status' => 0,
                'message' => 'Bölüme Bağlı Aşama Bulunmaktadır. Bu sebeple Silinemez',
                'id' => 0
            ];
        }
    }



    public function details($bolum_id){
        $this->db->select('*');
        $this->db->from('geopos_project_bolum');
        $this->db->where('id', $bolum_id);
        $query = $this->db->get();
        return $query->row();
    }


    public function add_activity($name, $prid,$key3='',$tutar=0)

    {
        $data = array('key3'=>$key3,'pid' => $prid, 'meta_key' => 12, 'value' => $name . ' @' . date('Y-m-d H:i:s'),'total'=>$tutar);

        if ($prid) {

            return $this->db->insert('geopos_project_meta', $data);

        } else {

            return 0;
        }

    }
}