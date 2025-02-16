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



class Supplier_model extends CI_Model

{



    var $table = 'geopos_supplier';

    var $column_order = array(null, 'name', 'address', 'email', 'phone', null);

    var $column_search = array('name', 'phone', 'address', 'city', 'email');

    var $trans_column_order = array('date', 'debit', 'credit', 'account', null);

    var $trans_column_search = array('id', 'date');

    var $inv_column_order = array(null, 'tid', 'name', 'invoicedate', 'total', 'status', null);

    var $inv_column_search = array('tid', 'name', 'invoicedate', 'total');

    var $order = array('id' => 'desc');

    var $inv_order = array('geopos_purchase.tid' => 'desc');





    private function _get_datatables_query($id = '')

    {



        $this->db->from($this->table);

                 if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

        }

        if ($id != '') {

            $this->db->where('gid', $id);

        }

        $i = 0;



        foreach ($this->column_search as $item) // loop column

        {

            $search = $this->input->post('search');

            $value = $search['value'];

            if ($value) // if datatable send POST for search

            {



                if ($i === 0) // first loop

                {

                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, $value);

                } else {

                    $this->db->or_like($item, $value);

                }



                if (count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) // here order processing

        {

            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }



    function get_datatables($id = '')

    {

        $this->_get_datatables_query($id);

        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

                 if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

        }

        $query = $this->db->get();

        return $query->result();

    }



    function count_filtered($id = '')

    {

        $this->_get_datatables_query();

                 if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

        }    if ($id != '') {

            $this->db->where('gid', $id);

        }

        $query = $this->db->get();



        return $query->num_rows($id = '');

    }



    public function count_all($id = '')

    {

        $this->_get_datatables_query();

        if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

        }

        $query = $this->db->get();

        if ($id != '') {

            $this->db->where('gid', $id);

        }

        return $query->num_rows($id = '');

    }



    public function details($custid)

    {



        $this->db->select('*');

        $this->db->from($this->table);

        $this->db->where('id', $custid);

        $query = $this->db->get();

        return $query->row_array();

    }



    public function money_details($custid)

    {



        $this->db->select('SUM(debit) AS debit,SUM(credit) AS credit');

        $this->db->from('geopos_transactions');

        $this->db->where('payerid', $custid);

        $this->db->where('ext', 1);

        $query = $this->db->get();

        return $query->row_array();

    }





    public function add($name, $company, $phone, $email, $address, $city, $region, $country, $postbox,$taxid)

    {

        $data = array(

            'name' => $name,

            'company' => $company,

            'phone' => $phone,

            'email' => $email,

            'address' => $address,

            'city' => $city,

            'region' => $region,

            'country' => $country,

            'postbox' => $postbox,

            'taxid' => $taxid

        );



           if ($this->aauth->get_user()->loc) {

            $data['loc']=$this->aauth->get_user()->loc;

        }





        if ($this->db->insert('geopos_supplier', $data)) {

            $cid = $this->db->insert_id();

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED') . ' <a href="' . base_url('supplier/view?id=' . $cid) . '" class="btn btn-info btn-sm"><span class="icon-eye"></span> ' . $this->lang->line('View') . '</a>', 'cid' => $cid));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }





    public function edit($id, $name, $company, $phone, $email, $address, $city, $region, $country, $postbox,$taxid)

    {

        $data = array(

            'name' => $name,

            'company' => $company,

            'phone' => $phone,

            'email' => $email,

            'address' => $address,

            'city' => $city,

            'region' => $region,

            'country' => $country,

            'postbox' => $postbox,

            'taxid' => $taxid



        );





        $this->db->set($data);

        $this->db->where('id', $id);



        if ($this->db->update('geopos_supplier')) {

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }



    public function editpicture($id, $pic)

    {

        $this->db->select('picture');

        $this->db->from($this->table);

        $this->db->where('id', $id);



        $query = $this->db->get();

        $result = $query->row_array();





        $data = array(

            'picture' => $pic

        );





        $this->db->set($data);

        $this->db->where('id', $id);

        if ($this->db->update('geopos_supplier')) {



            unlink(FCPATH . 'userfiles/supplier/' . $result['picture']);

            unlink(FCPATH . 'userfiles/supplier/thumbnail/' . $result['picture']);

        }





    }



    public function group_list()

    {

        $query = $this->db->query("SELECT c.*,p.pc FROM geopos_cust_group AS c LEFT JOIN ( SELECT gid,COUNT(gid) AS pc FROM geopos_supplier GROUP BY gid) AS p ON p.gid=c.id");

        return $query->result_array();

    }



    public function delete($id)

    {



        return $this->db->delete('geopos_supplier', array('id' => $id));

    }





    //transtables



    function trans_table($id)

    {

        $this->_get_trans_table_query($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }





    private function _get_trans_table_query($id)

    {



        $this->db->from('geopos_transactions');





        $this->db->where('payerid', $id);

        $this->db->where('ext', 1);



        $i = 0;



        foreach ($this->trans_column_search as $item) // loop column

        {

            $search = $this->input->post('search');

            $value = $search['value'];

            if ($value) // if datatable send POST for search

            {



                if ($i === 0) // first loop

                {

                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, $value);

                } else {

                    $this->db->or_like($item, $value);

                }



                if (count($this->trans_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) // here order processing

        {

            $this->db->order_by($this->trans_column_order[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }



    function trans_count_filtered($id = '')

    {

        $this->_get_trans_table_query($id);

        $query = $this->db->get();

        if ($id != '') {

            $this->db->where('payerid', $id);

        }

        return $query->num_rows($id = '');

    }



    public function trans_count_all($id = '')

    {

        $this->_get_trans_table_query($id);

        $query = $this->db->get();

        if ($id != '') {

            $this->db->where('payerid', $id);

        }





    }



    private function _inv_datatables_query($id)

    {

       $this->db->select('geopos_purchase.*');

        $this->db->from('geopos_purchase');

        $this->db->where('geopos_purchase.csd', $id);

        $this->db->join('geopos_supplier', 'geopos_purchase.csd=geopos_supplier.id', 'left');



        $i = 0;



        foreach ($this->inv_column_search as $item) // loop column

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



                if (count($this->inv_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->inv_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->inv_order)) {

            $order = $this->inv_order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }



    function inv_datatables($id)

    {

        $this->_inv_datatables_query($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }



    function inv_count_filtered($id)

    {

        $this->_inv_datatables_query($id);

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function inv_count_all($id)

    {

        $this->db->from('geopos_purchase');

        $this->db->where('csd', $id);

        return $this->db->count_all_results();

    }



    public function group_info($id)

    {



        $this->db->from('geopos_cust_group');

        $this->db->where('id', $id);

        $query = $this->db->get();

        return $query->row_array();

    }





}