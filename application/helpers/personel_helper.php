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


if (!defined('BASEPATH')) exit('No direct script access allowed');


function personel_salary_details_get($personel_id)
{
    $ci = &get_instance();
    $ci->load->database();
    $ci->db->select("*");
    $ci->db->from("personel_salary");
    $ci->db->where("personel_id", $personel_id);
    $ci->db->where("status", 1);
    $query = $ci->db->get();
    return $query->row();

}
if (!function_exists('check_bordro_payment_status')) {
    /**
     * Check if a personnel has unpaid bordro items for the current month and year.
     *
     * @param int $pers_id Personnel ID.
     * @return bool True if unpaid bordro items exist, otherwise false.
     */
    function check_bordro_payment_status($pers_id,$method,$result)
    {
        $ci = &get_instance();
        $ci->load->database();

// Geçerli yıl ve ay bilgilerini al
        $ay = intval(date('m')) - 1; // Bir önceki ay
        $yil = date('Y');

// Eğer ay 0 ise (Ocak ayı için bir önceki ay Aralık olur, yıl düşer)
        if ($ay === 0) {
            $ay = 12;
            $yil--;
        }

// Hakediş türüne göre filtre ekle
        if ($method == 3) {
            $ci->db->where('new_bordro_item.aylik_banka_hakedis >', 0);
        } elseif ($method == 1) {
            $ci->db->where('new_bordro_item.aylik_nakit_hakedis >', 0);
        }

// Sorguyu oluştur
        $ci->db->select('new_bordro.*, new_bordro_item.*');
        $ci->db->from('new_bordro');
        $ci->db->join('new_bordro_item', 'new_bordro.id = new_bordro_item.bordro_id');
        $ci->db->where('new_bordro_item.pers_id', $pers_id);
        $ci->db->where('new_bordro.ay', $ay);
        $ci->db->where('new_bordro.yil', $yil);
        $ci->db->where('new_bordro_item.banka_odeme_durumu', 0);

// Sorguyu çalıştır
        $query = $ci->db->get();

// Sonuçları döndür
        if($result==1){
            return $query->num_rows() > 0;
        }
        else{
            return $query->row();
        }

    }
}

