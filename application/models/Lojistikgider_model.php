<?php

class Lojistikgider_model extends CI_Model

{

    var $table = 'lojistik_to_gider';
    var $column_order = array('araclar.name as arac_name', 'geopos_cost.name as cost_name','lojistik_to_gider.qty','lojistik_to_gider.unit_id','lojistik_to_gider.price','lojistik_to_gider.total_price','lojistik_to_gider.desc','satinalma_location_id.location_id');
    var $column_search = array('araclar.name as arac_name', 'geopos_cost.name as cost_name','lojistik_to_gider.qty','lojistik_to_gider.unit_id','lojistik_to_gider.price','lojistik_to_gider.total_price','lojistik_to_gider.desc','satinalma_location_id.location_id');
    var $order = array('lojistik_to_gider.id' => 'DESC');

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

        $this->db->select('lojistik_to_gider.*,geopos_cost.name as cost_name,araclar.name as arac_name');
        $this->db->from('lojistik_to_gider');
        $this->db->join('geopos_cost','lojistik_to_gider.gider_id=geopos_cost.id');
        $this->db->join('araclar','lojistik_to_gider.arac_id=araclar.id');
        $this->db->where('lojistik_to_gider.lojistik_id',$id);
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

        $this->db->order_by('`lojistik_to_gider`.`id`','DESC');
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


    public function get_datatables_details_bekleyen($id)

    {

        $this->_get_datatables_query_details_bekleyen($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _get_datatables_query_details_bekleyen($id)

    {

        $this->db->select('lojistik_to_gider.*,geopos_cost.name as cost_name,araclar.name as arac_name,lojistik_gider_onay.id as onay_id');
        $this->db->from('lojistik_to_gider');
        $this->db->join('geopos_cost','lojistik_to_gider.gider_id=geopos_cost.id');
        $this->db->join('araclar','lojistik_to_gider.arac_id=araclar.id');
        $this->db->join('lojistik_gider_onay','lojistik_gider_onay.lojistik_gider_id = lojistik_to_gider.id');
        $this->db->join('lojistik_satinalma_talep','lojistik_to_gider.lojistik_id = lojistik_satinalma_talep.id');
        $this->db->Where('lojistik_gider_onay.user_id',$id);
        $this->db->Where('lojistik_gider_onay.status',0);
        $this->db->Where('lojistik_satinalma_talep.status',2);


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

        $this->db->order_by('`lojistik_to_gider`.`id`','DESC');
    }
    public function count_filtered_bekleyen($id)

    {

        $this->_get_datatables_query_details_bekleyen($id);

        $query = $this->db->get();



        return $query->num_rows();

    }
    public function count_all_bekleyen($id)

    {

        $this->_get_datatables_query_details_bekleyen($id);



        return $this->db->count_all_results();

    }

    public function satinalma_araclar($id){
        $this->db->select('araclar.*');
        $this->db->from('lojistik_satinalma_item');
        $this->db->join('araclar','lojistik_satinalma_item.arac_id = araclar.id','LEFT');
        $this->db->where('lojistik_satinalma_item.lojistik_id',$id);
        $this->db->group_by('`lojistik_satinalma_item`.`arac_id`');
        $query = $this->db->get();
        return $query->result();

    }
    public function cost(){
        $this->db->select('*');
        $this->db->from('geopos_cost');
        $query = $this->db->get();
        return $query->result();

    }
    public function unit(){
        $this->db->select('*');
        $this->db->from('geopos_units');
        $query = $this->db->get();
        return $query->result();

    }
    public function rey_details($id){
        $this->db->select('lojistik_gider_onay.*,geopos_employees.name as pers_name');
        $this->db->from('lojistik_gider_onay');
        $this->db->join('geopos_employees','lojistik_gider_onay.user_id = geopos_employees.id','LEFT');
        $this->db->Where('lojistik_gider_onay.id',$id);
        $query = $this->db->get();
        return $query->row();

    }
    public function lojistik_gider_onay($id){
        $this->db->select('*');
        $this->db->from('lojistik_gider_onay');
        $this->db->Where('lojistik_gider_id',$id);
        $query = $this->db->get();
        return $query->row();

    }
    public function cost_details($id){
        $this->db->select('*');
        $this->db->from('lojistik_to_gider');
        $this->db->Where('lojistik_to_gider.id',$id);
        $query = $this->db->get();
        return $query->row();

    }
    public function bekleyenlojistikgideri($id){
        $this->db->select('lojistik_satinalma_talep.*');
        $this->db->from('lojistik_gider_onay');
        $this->db->join('lojistik_to_gider','lojistik_gider_onay.lojistik_gider_id = lojistik_to_gider.id');
        $this->db->join('lojistik_satinalma_talep','lojistik_to_gider.lojistik_id = lojistik_satinalma_talep.id');
        $this->db->Where('lojistik_gider_onay.user_id',$id);
        $this->db->Where('lojistik_gider_onay.status',0);
        $this->db->Where('lojistik_satinalma_talep.status',2);
        $query = $this->db->get();
        return $query->num_rows();

    }
}
