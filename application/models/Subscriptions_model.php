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



class Subscriptions_model extends CI_Model

{

    var $table = 'geopos_invoices';

    var $column_order = array(null, 'tid', 'name', 'invoicedate', 'total', 'status', null,null);

    var $column_search = array('tid', 'name', 'invoicedate', 'total');

    var $order = array('tid' => 'desc');



    public function __construct()

    {

        parent::__construct();

    }



    public function lastinvoice()

    {

        $this->db->select('tid');

        $this->db->from($this->table);

        $this->db->order_by('id', 'DESC');

        $this->db->limit(1);

         $this->db->where('i_class', 0);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            return $query->row()->tid;

        } else {

            return 1000;

        }

    }







    public function invoice_details($id, $eid = '')

    {



        $this->db->select('geopos_invoices.*,geopos_customers.*,geopos_invoices.id AS iid,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');

        $this->db->from($this->table);

        $this->db->where('geopos_invoices.id', $id);

        if ($eid) {

            $this->db->where('geopos_invoices.eid', $eid);



        }

         if ($this->aauth->get_user()->loc) {

        $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);

        }

        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id', 'left');

        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_invoices.term', 'left');

        $query = $this->db->get();

        return $query->row_array();



    }



    public function invoice_products($id)

    {



        $this->db->select('*');

        $this->db->from('geopos_invoice_items');

        $this->db->where('tid', $id);

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



    public function invoice_transactions($id)

    {



        $this->db->select('*');

        $this->db->from('geopos_transactions');

        $this->db->where('tid', $id);

        $this->db->where('ext', 0);

        $query = $this->db->get();

        return $query->result_array();



    }



    public function invoice_delete($id, $eid = '')

    {



        $this->db->trans_start();



		$this->db->select('status');

        $this->db->from('geopos_invoices');

        $this->db->where('id', $id);

		$query = $this->db->get();

        $result = $query->row_array();



                if ($this->aauth->get_user()->loc) {

            if ($eid) {



                $res = $this->db->delete('geopos_invoices', array('id' => $id, 'eid' => $eid, 'loc' => $this->aauth->get_user()->loc));





            } else {

                $res = $this->db->delete('geopos_invoices', array('id' => $id, 'loc' => $this->aauth->get_user()->loc));

            }

        } else {

            if ($eid) {



                $res = $this->db->delete('geopos_invoices', array('id' => $id, 'eid' => $eid));





            } else {

                $res = $this->db->delete('geopos_invoices', array('id' => $id));

            }

        }

        $affect=$this->db->affected_rows();





        if ($res) {

			if($result['status']!='canceled'){

            $this->db->select('pid,qty');

            $this->db->from('geopos_invoice_items');

            $this->db->where('tid', $id);

            $query = $this->db->get();

            $prevresult = $query->result_array();



            foreach ($prevresult as $prd) {

                $amt = $prd['qty'];

                $this->db->set('qty', "qty+$amt", FALSE);

                $this->db->where('pid', $prd['pid']);

                $this->db->update('geopos_products');

            }

			}

            if($affect)  $this->db->delete('geopos_invoice_items', array('tid' => $id));

            if ($this->db->trans_complete()) {

                return true;

            } else {

                return false;

            }

        }

    }





    private function _get_datatables_query($opt = '')

    {

       $this->db->select('geopos_invoices.id,geopos_invoices.tid,geopos_invoices.invoicedate,geopos_invoices.invoiceduedate,geopos_invoices.total,geopos_invoices.status,geopos_invoices.i_class,geopos_customers.name');

        $this->db->from($this->table);

        $this->db->where('geopos_invoices.i_class>', 1);

        if ($opt) {

            $this->db->where('geopos_invoices.eid', $opt);

        }

        if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);

        }

        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');



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



    function get_datatables($opt = '')

    {

        $this->_get_datatables_query($opt);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

               if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);

        }

           $this->db->where('geopos_invoices.i_class>', 1);

        $query = $this->db->get();





        return $query->result();

    }



    function count_filtered($opt = '')

    {

        $this->_get_datatables_query($opt);

        if ($opt) {

            $this->db->where('eid', $opt);

        }

               if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);

        }

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function count_all($opt = '')

    {

        $this->db->select('geopos_invoices.id');

        $this->db->from($this->table);

          $this->db->where('geopos_invoices.i_class>', 1);

        if ($opt) {

            $this->db->where('geopos_invoices.eid', $opt);

        }

               if ($this->aauth->get_user()->loc) {

            $this->db->where('geopos_invoices.loc', $this->aauth->get_user()->loc);

        }



        return $this->db->count_all_results();

    }





    public function billingterms()

    {

        $this->db->select('id,title');

        $this->db->from('geopos_terms');

        $this->db->where('type', 1);

        $this->db->or_where('type', 0);

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

        $this->db->where('geopos_metadata.type', 1);

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

    public function gateway_list($enable = '')

    {



        $this->db->from('geopos_gateways');

        if ($enable == 'Yes') {

            $this->db->where('enable', 'Yes');

        }

        $query = $this->db->get();

        return $query->result_array();

    }

}