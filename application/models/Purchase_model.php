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



class Purchase_model extends CI_Model

{

    var $table = 'geopos_purchase';

    var $column_order = array(null, 'tid', 'name', 'invoicedate', 'total', 'status', null);

    var $column_search = array('tid', 'name', 'invoicedate', 'total','status');

    var $order = array('tid' => 'desc');



    public function __construct()

    {

        parent::__construct();



    }

    public function cart_delete($user_id)
    {
        $this->db->delete('geopos_cart', array('user_id' => $user_id));
    }



    public function lastpurchase()

    {

        $this->db->select('tid');

        $this->db->from($this->table);

        $this->db->order_by('tid', 'DESC');

        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->row()->tid;

        } else {

            return 1000;

        }

    }



    public function warehouses()

    {

        $this->db->select('*');

        $this->db->from('geopos_warehouse');



              if ($this->aauth->get_user()->loc) {

                  $this->db->where('loc', 0);

            $this->db->or_where('loc', $this->aauth->get_user()->loc);

        }



        $query = $this->db->get();

        return $query->result_array();



    }



    public function purchase_details($id)

    {



        $this->db->select('geopos_purchase.*,geopos_purchase.id AS iid,SUM(geopos_purchase.shipping + geopos_purchase.ship_tax) AS shipping,geopos_customers.name as cname,geopos_customers.*,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');

        $this->db->from($this->table);

        $this->db->where('geopos_purchase.id', $id);

         if ($this->aauth->get_user()->loc) {

                    //$this->db->where('geopos_purchase.loc', $this->aauth->get_user()->loc);

                }

        $this->db->join('geopos_customers', 'geopos_purchase.csd = geopos_customers.id', 'left');

        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_purchase.term', 'left');

        $query = $this->db->get();

        return $query->row_array();



    }



    public function purchase_products($id)

    {



        $this->db->select('*');

        $this->db->from('geopos_purchase_items');

        $this->db->where('tid', $id);

        $query = $this->db->get();

        return $query->result_array();



    }



    public function purchase_transactions($id)

    {



        $this->db->select('*');

        $this->db->from('geopos_transactions');

        $this->db->where('tid', $id);

        $this->db->where('ext', 1);

        $query = $this->db->get();

        return $query->result_array();



    }



    public function purchase_delete($id)

    {



        $this->db->trans_start();
         $whr=array('id' => $id);

        $this->db->delete('geopos_purchase', $whr);
        $this->db->delete('geopos_purchase_items', array('tid' => $id));

        if ($this->db->trans_complete()) {

            return true;

        } else {

            return false;

        }

    }


    public function gorev_durumu($id,$user_id)
    {
        $this->db->select('*');

        $this->db->from('geopos_todolist');

        $this->db->where('purchase_id', $id);

        $this->db->where('eid', $user_id);

        $query = $this->db->get();

        return $query->row_array();
    }


    private function _get_datatables_query()

    {

 $this->db->select('geopos_purchase.id,geopos_purchase.status,
            geopos_purchase.tid,
            geopos_purchase.invoicedate,
            geopos_purchase.invoiceduedate,
            geopos_purchase.total,geopos_purchase.status,geopos_customers.name');

        $this->db->from($this->table);

        $this->db->join('geopos_customers', 'geopos_purchase.csd=geopos_customers.id', 'left');


 if ($this->aauth->get_user()->loc) {

     if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
     {
         $this->db->where('DATE(geopos_purchase.invoicedate) >=', datefordatabase($this->input->post('start_date')));
         $this->db->where('DATE(geopos_purchase.invoicedate) <=', datefordatabase($this->input->post('end_date')));
     }

            //$this->db->where('geopos_purchase.loc', $this->aauth->get_user()->loc); -->firmaya ait tüm siparişlerin listelenmesi için

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

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }



    function get_datatables()

    {

        $this->_get_datatables_query();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }



    function count_filtered()

    {

        $this->_get_datatables_query();

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function count_all()

    {

        $this->db->from($this->table);

         if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_purchase.loc', $this->aauth->get_user()->loc);

        }

        return $this->db->count_all_results();

    }





    public function billingterms()

    {

        $this->db->select('id,title');

        $this->db->from('geopos_terms');

        $this->db->where('type', 4);

        $this->db->or_where('type', 0);

        $query = $this->db->get();

        return $query->result_array();

    }

        public function currencies()

    {



        $this->db->select('*');

        $this->db->from('geopos_currencies');

        $query = $this->db->get();

        return $query->result_array();

    }



    public function currency_d($id)

    {

        $this->db->select('*');

        $this->db->from('geopos_currencies');

        $this->db->where('id', $id);

        $query = $this->db->get();

        return $query->row_array();

    }



    public function employee($id)

    {

        $this->db->select('geopos_employees.name,geopos_employees.sign,geopos_users.roleid,geopos_employees.phone');

        $this->db->from('geopos_employees');

        $this->db->where('geopos_employees.id', $id);

        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');

        $query = $this->db->get();

        return $query->row_array();

    }



    public function meta_insert($id, $type, $meta_data)

    {



        $data = array('type' => $type, 'rid' => $id, 'col1' => $meta_data);

        if ($id) {

            return $this->db->insert('geopos_metadata', $data);

        } else {

            return 0;

        }

    }



    public function attach($id)

    {

        $this->db->select('geopos_metadata.*');

        $this->db->from('geopos_metadata');

        $this->db->where('geopos_metadata.type', 4);

        $this->db->where('geopos_metadata.rid', $id);

        $query = $this->db->get();

        return $query->result_array();

    }

    public function projeler()

    {

        $this->db->select('geopos_projects.*');

        $this->db->from('geopos_projects');

        $query = $this->db->get();

        return $query->result_array();

    }

    public function employees()

    {

        $this->db->select('geopos_employees.*');

        $this->db->from('geopos_employees');

        $query = $this->db->get();

        return $query->result_array();

    }



    public function meta_delete($id,$type,$name)

    {

        if (@unlink(FCPATH . 'userfiles/attach/' . $name)) {

            return $this->db->delete('geopos_metadata', array('rid' => $id, 'type' => $type, 'col1' => $name));

        }

    }



}