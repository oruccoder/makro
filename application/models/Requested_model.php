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



class Requested_model extends CI_Model

{

    var $table = 'geopos_talep';
    var $table_item = 'geopos_talep_items';

    var $order = array('geopos_talep.status' => 'desc');

    var $column_order = array('id','proje_name','olusturma_tarihi','onay_tarihi', 'total', 'status');
    var $column_search = array('id','proje_name','olusturma_tarihi','onay_tarihi', 'total', 'status');

    var $column_order_malzeme = array('olusturma_tarihi','onay_tarihi','id','proje_name', 'status', 'kullanici_id');
    var $column_search_malzeme = array('olusturma_tarihi','onay_tarihi','talep_no','proje_name', 'status', 'kullanici_id');


    var $column_order_satinalma = array('olusturma_tarihi','onay_tarihi','id','proje_name', 'status', 'kullanici_id');
    var $column_search_satinalma = array('olusturma_tarihi','onay_tarihi','talep_no','proje_name', 'status', 'kullanici_id');

    var $column_order_gider = array('olusturma_tarihi','onay_tarihi','id','proje_name', 'total','status', 'kullanici_id');
    var $column_search_gider = array('olusturma_tarihi','onay_tarihi','talep_no','proje_name','total', 'status', 'kullanici_id');

    var $column_order_avans = array('olusturma_tarihi','onay_tarihi','id','proje_name', 'total','status', 'kullanici_id');
    var $column_search_avans = array('olusturma_tarihi','onay_tarihi','talep_no','proje_name','total', 'status', 'kullanici_id');


    public function units()

    {

        $this->db->select('*');

        $this->db->from('geopos_units');

        $this->db->where('type', 0);

        $query = $this->db->get();

        return $query->result_array();



    }

    public function invoice_details($id)
    {

        $this->db->select('*');

        $this->db->from($this->table);

        $this->db->where('id', $id);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function invoice_products_($id)
    {
        $res=$this->db->query("SELECT * FROM geopos_talep_items WHERE geopos_talep_items.tip=$id GROUP BY product_name")->result_array();
        return $res;
    }
    public function invoice_products($id)

    {



        $this->db->select('*');

        $this->db->from($this->table_item);

        $this->db->where('tip', $id);

        $query = $this->db->get();

        return $query->result_array();



    }

    public function invoice_products_satinalma($id)

    {



        $this->db->select('*');

        $this->db->from($this->table_item);

        $this->db->where('tip', $id);
        $this->db->where('firma is NOT NULL',null );

        $this->db->order_by('price', 'ASC');
        $this->db->group_by('product_name', 'ASC');


        $query = $this->db->get();




        return $query->result_array();



    }

    public function invoice_products_satinalma_edit($id)

    {



        $this->db->select('*');

        $this->db->from($this->table_item);

        $this->db->where('tip', $id);
        $this->db->where('firma is NOT NULL',null );

        $query = $this->db->get();




        return $query->result_array();



    }

    public function invoice_products_satinalma_firmalar($id)

    {



        $this->db->select('geopos_talep_items.*, SUM(subtotal) as total');

        $this->db->from('geopos_talep_items');

        $this->db->where('tip', $id);
        $this->db->where('firma is NOT NULL',null );

        $this->db->group_by('firma', 'ASC');
        $this->db->order_by('total', 'ASC');


        $query = $this->db->get();




        return $query->result();



    }

    public function invoice_products_sf($id)

    {



        $this->db->select('geopos_item_alt.id,geopos_talep_items.unit,geopos_talep_items.product_name,geopos_talep_items.qty,geopos_item_alt.price,geopos_item_alt.subtotal,geopos_item_alt.firma ');

        $this->db->from("geopos_talep_items");
        $this->db->join('geopos_item_alt', 'geopos_item_alt.talep_id_item = geopos_talep_items.id');


        $this->db->where('geopos_talep_items.tip', $id);
        $this->db->where('geopos_item_alt.price!=0');

        $query = $this->db->get();

        return $query->result_array();



    }
    function get_datatables($opt = '')
    {
        $this->_get_datatables_query($opt);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();

    }

    public function count_all($opt = '',$tip=0)

    {

        $this->db->select('geopos_talep.id');

        $this->db->from($this->table);


        if ($tip!=0) {

            $this->db->where('geopos_talep.tip', $tip);
        }

        return $this->db->count_all_results();

    }

    function count_filtered($opt = '',$tip=0)

    {

        $this->_get_datatables_query($opt);



        $query = $this->db->get();

        return $query->num_rows();

    }

    private function _get_datatables_query($opt = '')
    {
        $tip = $this->input->post('tip');

        //proje müdür ise
        $user_id = $this->aauth->get_user()->id;
        $role_id = $this->aauth->get_user()->roleid;
        $this->db->select('*');
        $this->db->from($this->table);

        if($this->input->post('tip')) // if datatable send POST for search
        {
            $this->db->where('geopos_talep.tip=',$this->input->post('tip'));  //2019-11-24 14:28:57
        }
        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_talep.olusturma_tarihi) >=', datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where('DATE(geopos_talep.olusturma_tarihi) <=', datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
        }

        if($this->input->post('first')) // if datatable send POST for search
        {
            $this->db->where('geopos_talep.kullanici_id=',$user_id);  //2019-11-24 14:28:57
        }



        if ($this->input->post('status')) // if datatable send POST for search
        {
            $this->db->where('geopos_talep.status=', $this->input->post('status'));  //2019-11-24 14:28:57
        }




        $i = 0;

        $search=$this->column_search;
        $order=$this->column_order;

        if ($this->input->post('tip')==1) // if datatable send POST for search
        {
            $search=$this->column_search_malzeme;
            $order=$this->column_order_malzeme;
        }
        else if ($this->input->post('tip')==2) // if datatable send POST for search
        {
            $search=$this->column_search_satinalma;
            $order=$this->column_order_satinalma;
        }
        else if ($this->input->post('tip')==4) // if datatable send POST for search
        {
            $search=$this->column_search_gider;
            $order=$this->column_order_gider;
        }

        else if ($this->input->post('tip')==5) // if datatable send POST for search
        {
            $search=$this->column_search_avans;
            $order=$this->column_order_avans;
        }


        foreach ($search as $item) // loop column

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





        $this->db->order_by('geopos_talep.id','desc');

    }








    public function requested_edit($tid){
        return $this->db->where('id',$tid)->get('geopos_talep')->row();
    }

    public function invoice_delete($id, $eid = '')

    {

        $this->db->trans_start();

        $this->db->delete('geopos_talep', array('id' => $id));
        $this->db->delete('geopos_talep_items', array('tip' => $id));
        $this->db->delete('geopos_onay', array('file_id' => $id));


        if ($this->db->trans_complete()) {

            return true;

        } else {

            return false;

        }




    }

    function get_datatables_prd($opt = '')

    {

        $this->_get_datatables_query_prd($opt);



        $query = $this->db->get();




        return $query->result();

    }

    private function _get_datatables_query_prd($opt = '')

    {


        $this->db->select('*');

        $this->db->from("geopos_talep_items");

        $this->db->where('geopos_talep_items.tip=', $this->input->post('tip'));

        $i = 0;


        $this->db->order_by('id','ASC');

    }

    public function count_all_prd($opt = '')

    {

        $this->db->select('geopos_talep_items.id');

        $this->db->from('geopos_talep_items');

        $this->db->where('geopos_talep_items.tip=', $this->input->post('tip'));


        return $this->db->count_all_results();

    }

    function count_filtered_prd($opt = '')

    {

        $this->_get_datatables_query_prd($opt);


        $query = $this->db->get();

        return $query->num_rows();

    }

    public function avans_attach($id)

    {

        $this->db->select('geopos_metadata.*');

        $this->db->from('geopos_metadata');

        $this->db->where('geopos_metadata.type', 100); // Avans

        $this->db->where('geopos_metadata.rid', $id);

        $query = $this->db->get();

        return $query->result_array();

    }


    public function meta_delete($id, $type, $name)

    {

        if (@unlink(FCPATH . 'userfiles/attach/' . $name)) {

            return $this->db->delete('geopos_metadata', array('rid' => $id, 'type' => $type, 'col1' => $name));

        }

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


}
