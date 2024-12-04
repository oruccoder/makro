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





class Activecar_model extends CI_Model
{
    var $table_news = 'araclar ';

    var $column_order = array('code', 'plaka', 'name', 'firma_id');

    var $column_search = array('code', 'plaka', 'name', 'firma_id');

    var $order = array('id' => 'DESC');


    public function __construct()
    {
        parent::__construct();

    }


    public function araclar(){
        $this->db->select('araclar.id as arac_id,lojistik_to_car.id as lojistik_car_id,araclar.name,lojistik_to_car.plaka,lojistik_to_car.sofor,lojistik_to_car.tel,lojistik_to_car.lojistik_id,arac_history_status.name as status_name');
        $this->db->from('lojistik_satinalma_talep');
        $this->db->join('lojistik_to_car','lojistik_satinalma_talep.id=lojistik_to_car.lojistik_id');
        $this->db->join('arac_history_status','lojistik_to_car.status=arac_history_status.id','LEFT');
        $this->db->join('araclar','lojistik_to_car.sf_arac_id=araclar.id');
        $this->db->where('lojistik_satinalma_talep.status',2);
        $this->db->where('lojistik_to_car.status!=',7);
        $query = $this->db->get();
        return $query->result();
    }
}
