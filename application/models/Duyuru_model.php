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
class Duyuru_model extends CI_Model
{
    public function details($id)
    {
//
        $this->db->select('*');
        $this->db->from('duyuru');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
}