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



class Lojistik_model extends CI_Model

{

    var $table = 'step_to_lojistik';

    var $column_order = array('geopos_talep.talep_no','geopos_customers.company', 'step_to_lojistik.lojistik_start_locations', 'step_to_lojistik.lojistik_stop_locations','step_to_lojistik.lojistik_notes');

    var $column_search = array('geopos_talep.talep_no','geopos_customers.company', 'step_to_lojistik.lojistik_start_locations', 'step_to_lojistik.lojistik_stop_locations','step_to_lojistik.lojistik_notes');

    var $order = array('step_to_lojistik.id' => 'DESC');

    public function __construct()
    {
        parent::__construct();

    }


    public function get_datatables_details($id)

    {



        $this->_get_datatables_query_details($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _get_datatables_query_details($id)

    {

        $this->db->select('step_to_lojistik.*,geopos_customers.company,geopos_talep.talep_no');
        $this->db->from('step_to_lojistik');
        $this->db->where('step_to_lojistik.status',1);
        $this->db->join('geopos_customers','step_to_lojistik.firma_id=geopos_customers.id');
        $this->db->join('geopos_talep','step_to_lojistik.talep_id=geopos_talep.id');


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

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        $this->db->order_by('`step_to_lojistik`.`id` DESC');





    }
    public function count_filtered($id)

    {

        $this->_get_datatables_query_details($id);

        $query = $this->db->get();



        return $query->num_rows();

    }
    public function count_all($id)

    {

        $this->_get_datatables_query_details($id);



        return $this->db->count_all_results();

    }





}
