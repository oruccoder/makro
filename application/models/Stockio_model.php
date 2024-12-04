<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Stockio_model extends CI_Model
{
    var $table_news = 'stock_io ';

    var $column_order = array('stock_io.id','type','stock_io.code','geopos_projects.code','geopos_warehouse.title');

    var $column_search = array('stock_io.code','IF(type="0","ÇIXIŞ","GİRİŞ")','geopos_projects.code','geopos_warehouse.title');

    var $order = array('stock_io.id' => 'DESC');

    public function __construct()
    {

    }

    public function get_all()

    {
        $this->all();
        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    public function all(){
        $this->db->select('stock_io.*,stock_io.id as stock_io_id_new,IF(type="0","ÇIXIŞ","GİRİŞ") as fis_type_name,geopos_warehouse.id as warehouse_id ,geopos_warehouse.title as warehouse ,geopos_projects.code, geopos_projects.name as project_name ,stock_io.code as fis_code');
        $this->db->from('stock_io');
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = stock_io.warehouse_id','left');
        $this->db->join('geopos_projects', 'geopos_projects.code = stock_io.proje_id','left');
        $this->db->where('stock_io.fis_tur',1);

        if($this->session->userdata('set_firma_id')){
            $this->db->where('stock_io.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
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

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }

    public function get_product($id = null){
        $this->db->select('stock_io.*,stock_io_products.*,geopos_products.pid,geopos_products.product_name,geopos_units.id,geopos_units.name as unit_name,geopos_warehouse.id ,geopos_warehouse.title as warehouse ,geopos_projects.code, geopos_projects.name as project_name ,stock_io.code as fis_code,stock_io_products.description as item_desc');
        $this->db->from('stock_io');
        if($id){
            $this->db->where('stock_io.id',$id);
        }
        $this->db->join('stock_io_products', 'stock_io.id = stock_io_products.stock_io_id','left');
        $this->db->join('geopos_products', 'stock_io_products.product_id = geopos_products.pid','left');
        $this->db->join('geopos_units', 'stock_io_products.unit_id = geopos_units.id','left');
        $this->db->join('geopos_warehouse', 'geopos_warehouse.id = stock_io.warehouse_id','left');
        $this->db->join('geopos_projects', 'geopos_projects.code = stock_io.proje_id','left');
        return $this->db->get()->result();
    }
    function all_filtered($opt = '')
    {
        $this->all();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function all_count($opt = '')
    {
        $this->all();
        return $this->db->count_all_results();
    }

    public function details($id){
        $this->db->select('*');
        $this->db->from('stock_io');
        $this->db->where('stock_io.id',$id);
        $query = $this->db->get();
        return $query->row();
    }

}

