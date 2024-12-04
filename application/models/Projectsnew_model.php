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



class Projectsnew_model extends CI_Model

{
    var $column_order = array('geopos_projects.id', 'geopos_projects.name', 'geopos_projects.edate', 'geopos_projects.worth', null,null);

    var $column_search = array('geopos_projects.name','geopos_projects.code', 'geopos_projects.edate', 'geopos_projects.status');

    function list()
    {
        $this->_list();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();

    }
    private function _list()
    {
        $this->db->select("geopos_projects.*,geopos_customers.name AS customer");
        $this->db->from('geopos_projects');
        $this->db->join('geopos_customers', 'geopos_projects.cid = geopos_customers.id', 'left');
        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_projects.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $i = 0;
        foreach ($this->column_search as $item) // loop column
        {
            if($_POST){
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
        }
        $search = $this->input->post('order');
        if (isset($search)) {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function list_filtered()
    {
        $this->_list();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function list_count_all()
    {
        $this->_list();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function details($id)
    {
        $this->db->select('geopos_projects.*,geopos_projects.id AS prj, geopos_customers.company AS customer,geopos_project_meta.*');
        $this->db->from('geopos_projects');
        $this->db->join('geopos_customers', 'geopos_projects.cid = geopos_customers.id', 'left');
        $this->db->join('geopos_project_meta', 'geopos_project_meta.pid = geopos_projects.id', 'left');
        $this->db->where('geopos_projects.id', $id);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_projects.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $query = $this->db->get();
        return $query->row();
    }

    public function talep_history($id,$user_id,$desc){
        date_default_timezone_set('Asia/Baku');
        $data_step = array(
            'proje_id' => $id,
            'user_id' => $user_id,
            'desc' => $desc,
        );
        $this->db->insert('proje_history', $data_step);

    }
}