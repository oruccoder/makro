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



class Sayim_model extends CI_Model

{

    var $table = 'geopos_sayim';

    var $column_order = array(null, 'tid', 'name', 'invoicedate', 'total', 'status', null);

    var $column_search = array('sayim_name','tid', 'name', 'invoicedate', 'total');

    var $order = array('tid' => 'desc');



    public function __construct()

    {

        parent::__construct();



    }

    public function cart_delete($user_id)
    {
        $this->db->delete('geopos_cart', array('user_id' => $user_id));
    }



    public function lastsayim()

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



        $this->db->select('geopos_purchase.*,geopos_purchase.id AS iid,SUM(geopos_purchase.shipping + geopos_purchase.ship_tax) AS shipping,geopos_customers.*,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');

        $this->db->from('geopos_purchase');

        $this->db->where('geopos_purchase.id', $id);



        $this->db->join('geopos_customers', 'geopos_purchase.csd = geopos_customers.id', 'left');

        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_purchase.term', 'left');

        $query = $this->db->get();

        return $query->row_array();



    }



    public function sayim_details($id)

    {



        $this->db->select('geopos_sayim.*,geopos_sayim.eid as pers_id,geopos_sayim.id AS iid,SUM(geopos_sayim.shipping + geopos_sayim.ship_tax) AS shipping,geopos_customers.*,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');

        $this->db->from('geopos_sayim');

        $this->db->where('geopos_sayim.id', $id);



        $this->db->join('geopos_customers', 'geopos_sayim.csd = geopos_customers.id', 'left');

        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_sayim.term', 'left');

        $query = $this->db->get();

        return $query->row_array();



    }





    public function sayim_products($id)

    {


        $this->db->select('*');

        $this->db->from('geopos_sayim_items');

        $this->db->where('tid', $id);

        $query = $this->db->get();



        return $query->result_array();



    }

    public function purchase_products($id)

    {



        $this->db->select('*');

        $this->db->from('geopos_purchase_items');

        $this->db->where('tid', $id);

        $query = $this->db->get();

        return $query->result_array();



    }



    public function sayim_transactions($id)

    {



        $this->db->select('*');

        $this->db->from('geopos_transactions');

        $this->db->where('tid', $id);

        $this->db->where('ext', 1);

        $query = $this->db->get();

        return $query->result_array();



    }



    public function sayim_delete($id)

    {



        $this->db->trans_start();
        $whr=array('id' => $id);

        $this->db->delete('geopos_sayim', $whr);
        $this->db->delete('geopos_sayim_items', array('tid' => $id));

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

        $this->db->select('geopos_sayim.id,geopos_sayim.sayim_name,geopos_sayim.new_status,
            geopos_sayim.tid,
            geopos_sayim.invoicedate,
            geopos_sayim.invoiceduedate,
            geopos_sayim.total,geopos_sayim.status,geopos_customers.company as name');

        $this->db->from($this->table);

        $this->db->join('geopos_customers', 'geopos_sayim.csd=geopos_customers.id', 'left');

        if ($this->aauth->get_user()->loc) {

            //$this->db->where('geopos_sayim.loc', $this->aauth->get_user()->loc); -->firmaya ait tüm siparişlerin listelenmesi için

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

            $this->db->where('geopos_sayim.loc', $this->aauth->get_user()->loc);

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

        $this->db->select('geopos_employees.name,geopos_employees.sign,geopos_users.roleid');

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

    public function purchases()
    {

        $this->db->select('geopos_purchase.*');

        $this->db->from('geopos_purchase');

        $query = $this->db->get();

        return $query->result_array();
    }



    public function meta_delete($id,$type,$name)

    {

        if (@unlink(FCPATH . 'userfiles/attach/' . $name)) {

            return $this->db->delete('geopos_metadata', array('rid' => $id, 'type' => $type, 'col1' => $name));

        }

    }

    public function urunler($purchase_id)
    {
            $urunler=$this->db->query("SELECT geopos_sayim_items.pid,geopos_sayim_items.product,
          SUM(geopos_sayim_items.qty) as qty,geopos_sayim_items.siparis_qty FROM `geopos_sayim_to_purchase` INNER JOIN 
          geopos_sayim on geopos_sayim_to_purchase.sayim_id=geopos_sayim.id INNER JOIN geopos_sayim_items on
           geopos_sayim.id=geopos_sayim_items.tid WHERE geopos_sayim_to_purchase.purchase_id=$purchase_id GROUP BY geopos_sayim_items.pid");


        $query= $urunler->result_array();
        if($query)
        {
            return $query;
        }
        else
            {
                return 0;
            }
    }



}