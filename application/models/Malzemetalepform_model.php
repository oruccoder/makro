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





class MalzemeTalepForm_model extends CI_Model
{
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

        // Veri hazırlama
        $data = [
            'code' => $talep_no,
            'progress_status_id' => $progress_status_id,
            'talep_eden_user_id' => $talep_eden_user_id,
            'proje_id' => $proje_id,
            'desc' => $desc,
            'aauth' => $this->aauth->get_user()->id,
            'bolum_id' => $bolum_id,
            'asama_id' => $asama_id,
            'loc' => $this->session->userdata('set_firma_id'),
            'created_at' => date('Y-m-d H:i:s'), // Oluşturulma tarihi
        ];

        // Veritabanı işlemine başla
        if ($this->db->insert('talep_form', $data)) {
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


    public function talep_history($id,$user_id,$desc){
        $data_step = array(
            'talep_id' => $id,
            'user_id' => $user_id,
            'desc' => $desc,
        );
        $this->db->insert('malzemetalep_history', $data_step);
    }
}