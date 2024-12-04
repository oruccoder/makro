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


class Registerlog
{
    public $RI;

    public function __construct()
    {
        // get main CI object
        $this->RI = &get_instance();
    }

    public function check($id)
    {
        $this->RI->db->from('geopos_register');
        $this->RI->db->where('uid', $id);
        $this->RI->db->where('active', 1);
        $query = $this->RI->db->get();
        $result = $query->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }

    }

    public function view($id)
    {
        $this->RI->db->from('geopos_register');
        $this->RI->db->where('id', $id);
        $query = $this->RI->db->get();
        $result = $query->row_array();
        if ($result) {
            return $result;
        } else {
            return false;
        }

    }


    public function create($id, $cash, $card, $bank, $cheque)
    {
        $data = array(
            'uid' => $id,
            'o_date' => date('Y-m-d H:i:s'),
            'cash' => $cash,
            'card' => $card,
            'bank' => $bank,
            'cheque' => $cheque,
            'active'=>1
        );
        return $this->RI->db->insert('geopos_register', $data);
    }

    public function update($id, $cash = 0,  $card = 0, $bank = 0, $cheque = 0,$change = 0)
    {

        $this->RI->db->set('cash', "cash+$cash", FALSE);
        $this->RI->db->set('card', "card+$card", FALSE);
        $this->RI->db->set('bank', "bank+$bank", FALSE);
        $this->RI->db->set('cheque', "cheque+$cheque", FALSE);
        $this->RI->db->set('r_change', "r_change+$change", FALSE);
        $this->RI->db->where('uid', $id);
        $this->RI->db->where('active', 1);
        $this->RI->db->update('geopos_register');
    }


    public function close($id)
    {
        $this->RI->db->set('active', 0);
          $this->RI->db->set('c_date',  date('Y-m-d H:i:s'));
        $this->RI->db->where('uid', $id);
        $this->RI->db->where('active', 1);
        $this->RI->db->update('geopos_register');
    }

    public function lists()
    {
       $this->RI->db->select('geopos_register.*,geopos_users.username');
        $this->RI->db->from('geopos_register');
       $this->RI->db->join('geopos_users','geopos_register.uid=geopos_users.id','left');
        $query = $this->RI->db->get();
        $result = $query->result_array();

            return $result;

    }

}