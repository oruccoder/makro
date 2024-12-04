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



class Stockreturn_model extends CI_Model

{

    var $table = 'geopos_stock_r';

    var $column_order = array(null, 'tid', 'name', 'invoicedate', 'total', 'status', null);

    var $column_search = array('tid', 'name', 'invoicedate', 'total');

    var $order = array('tid' => 'desc');



    public function __construct()

    {

        parent::__construct();

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

            $this->db->where('loc', $this->aauth->get_user()->loc);

              $this->db->or_where('loc', 0);

        }



        $query = $this->db->get();

        return $query->result_array();



    }



    public function purchase_details($id)

    {



         $this->db->select('geopos_stock_r.i_class');

        $this->db->from($this->table);

        $this->db->where('geopos_stock_r.id', $id);

        $query = $this->db->get();

       $out= $query->row_array();



       if($out['i_class']){

                  $this->db->select('geopos_stock_r.*,geopos_stock_r.id AS iid,SUM(geopos_stock_r.shipping + geopos_stock_r.ship_tax) AS shipping,geopos_customers.*,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');

           $this->db->from($this->table);

           $this->db->where('geopos_stock_r.id', $id);

           $this->db->join('geopos_customers', 'geopos_stock_r.csd = geopos_customers.id', 'left');

           $this->db->join('geopos_terms', 'geopos_terms.id = geopos_stock_r.term', 'left');

           if ($this->aauth->get_user()->loc) {

               $this->db->where('geopos_stock_r.loc', $this->aauth->get_user()->loc);

           }

           $query = $this->db->get();

           return $query->row_array();

       }

       else {



           $this->db->select('geopos_stock_r.*,geopos_stock_r.id AS iid,SUM(geopos_stock_r.shipping + geopos_stock_r.ship_tax) AS shipping,geopos_supplier.*,geopos_supplier.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');

           $this->db->from($this->table);

           $this->db->where('geopos_stock_r.id', $id);

           $this->db->join('geopos_supplier', 'geopos_stock_r.csd = geopos_supplier.id', 'left');

           $this->db->join('geopos_terms', 'geopos_terms.id = geopos_stock_r.term', 'left');

           if ($this->aauth->get_user()->loc) {

               $this->db->where('geopos_stock_r.loc', $this->aauth->get_user()->loc);

           }

           $query = $this->db->get();

           return $query->row_array();

       }



    }



    public function purchase_products($id)

    {



        $this->db->select('*');

        $this->db->from('geopos_stock_r_items');

        $this->db->where('tid', $id);

        $query = $this->db->get();

        return $query->result_array();



    }



    public function purchase_transactions($id)

    {



        $this->db->select('*');

        $this->db->from('geopos_transactions');

        $this->db->where('tid', $id);

        $this->db->where('ext', 6);

        $query = $this->db->get();

        return $query->result_array();



    }



    public function purchase_delete($id)

    {



        $this->db->trans_start();



        $this->db->select('pid,qty');

        $this->db->from('geopos_stock_r_items');

        $this->db->where('tid', $id);

        $query = $this->db->get();

        $prevresult = $query->result_array();



        foreach ($prevresult as $prd) {

            $amt = $prd['qty'];

            $this->db->set('qty', "qty+$amt", FALSE);

            $this->db->where('pid', $prd['pid']);

            $this->db->update('geopos_products');

        }



              $whr=array('id' => $id);

 if ($this->aauth->get_user()->loc) {

         $whr=array('id' => $id,'loc'=>$this->aauth->get_user()->loc);

        }

        $this->db->delete('geopos_stock_r', $whr);



        if($this->db->affected_rows()) $this->db->delete('geopos_stock_r_items', array('tid' => $id));







        if ($this->db->trans_complete()) {

            return true;

        } else {

            return false;

        }

    }





    private function _get_datatables_query($type=0)

    {

        if($type){



                   $this->db->select('geopos_stock_r.id,geopos_stock_r.tid,geopos_stock_r.invoicedate,geopos_stock_r.invoiceduedate,geopos_stock_r.total,geopos_stock_r.status,geopos_customers.name');

            $this->db->from($this->table);

            $this->db->where('geopos_stock_r.i_class', $type);

            $this->db->join('geopos_customers', 'geopos_stock_r.csd=geopos_customers.id', 'left');

            if ($this->aauth->get_user()->loc) {

                $this->db->where('geopos_stock_r.loc', $this->aauth->get_user()->loc);

            }

        }

        else {

            $this->db->select('geopos_stock_r.id,geopos_stock_r.tid,geopos_stock_r.invoicedate,geopos_stock_r.invoiceduedate,geopos_stock_r.total,geopos_stock_r.status,geopos_supplier.name');

            $this->db->from($this->table);

            $this->db->where('geopos_stock_r.i_class', $type);

            $this->db->join('geopos_supplier', 'geopos_stock_r.csd=geopos_supplier.id', 'left');

            if ($this->aauth->get_user()->loc) {

                $this->db->where('geopos_stock_r.loc', $this->aauth->get_user()->loc);

            }

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



    function get_datatables($type=0)

    {

        $this->_get_datatables_query($type);

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

            $this->db->where('geopos_stock_r.loc', $this->aauth->get_user()->loc);

        }

        return $this->db->count_all_results();

    }





    public function billingterms()

    {

        $this->db->select('id,title');

        $this->db->from('geopos_terms');

        $query = $this->db->get();

        return $query->result_array();

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



    public function meta_delete($id,$type,$name)

    {

        if (@unlink(FCPATH . 'userfiles/attach/' . $name)) {

            return $this->db->delete('geopos_metadata', array('rid' => $id, 'type' => $type, 'col1' => $name));

        }

    }









}