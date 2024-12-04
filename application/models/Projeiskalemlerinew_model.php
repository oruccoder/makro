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



class Projeiskalemlerinew_model extends CI_Model
{
    var $column_order = array('project_new_islist.bolum_id', 'project_new_islist.asama_id', 'project_new_islist.iskalemleri_id','projeiskalmeleri.name','projeiskalmeleri.unit_qty','project_new_islist.qty',null,null);
    var $column_search = array('project_asama.name', 'projeiskalmeleri.name','projeiskalmeleri.unit_qty','project_new_islist.qty');

    public function __construct()
    {
        parent::__construct();
       // $this->load->model('projectsnew_model', 'proje_model_new');

    }
    private function _ajax_list($cday = '')
    {

        $this->db->select('project_new_islist.*, projeiskalmeleri.name as is_name,projeiskalmeleri.simeta_code as simeta_code,projeiskalmeleri.unit_qty, projeiskalmeleri.unit_id, project_asama.name as asama_name, projeiskalmeleri.recete_id,project_asama.id as asama_id');
        $this->db->from('project_new_islist');
        $this->db->join('projeiskalmeleri','projeiskalmeleri.id=project_new_islist.iskalemleri_id');
        $this->db->join('project_asama','projeiskalmeleri.asama_id=project_asama.id');
        $this->db->where('project_new_islist.proje_id', $this->input->post('proje_id'));

        if($this->session->userdata('set_firma_id')){
            $this->db->where('project_new_islist.loc', $this->session->userdata('set_firma_id'));
        }
        $i = 0;

        foreach ($this->column_search as $item) // loop column
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

                if (count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $search = $this->input->post('order');


        if ($search) {

            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);

        }
        else {
            $this->db->order_by('`project_new_islist`.`id` DESC');
        }



    }
    function ajax_list($cday = '')
    {
        $this->_ajax_list($cday);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();
        return $query->result();
    }
    function task_count_filtered($cday = '')

    {

        $this->_ajax_list($cday);


        $query = $this->db->get();

        return $query->num_rows();

    }
    public function task_count_all($cday = '')

    {

        $this->_ajax_list($cday);


        $query = $this->db->get();

        return $query->num_rows();

    }
}