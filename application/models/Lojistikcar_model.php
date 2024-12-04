<?php

class Lojistikcar_model extends CI_Model

{

    var $table = 'lojistik_to_car';
    var $column_order = array('lojistik_satinalma_item.lojistik_id','araclar.name');
    var $column_search = array('lojistik_satinalma_item.lojistik_id','araclar.name');
    var $order = array('lojistik_satinalma_item.id' => 'DESC');



    var $column_order_history = array('lojistik_to_car_history.id','locations.location','geopos_employees.name as pers_name','lojistik_to_car_history.created_at','lojistik_to_car_history.desc','arac_history_status.name');
    var $column_search_history = array('lojistik_to_car_history.id','locations.location','geopos_employees.name  as pers_name','lojistik_to_car_history.created_at','lojistik_to_car_history.desc','arac_history_status.name');
    var $order_history = array('lojistik_to_car_history.id' => 'DESC');

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

        $this->db->select('lojistik_satinalma_item.arac_id as arac_id,lojistik_satinalma_item.lojistik_id,araclar.name');
        $this->db->from('lojistik_satinalma_item');
        $this->db->join('araclar','lojistik_satinalma_item.arac_id=araclar.id');
        $this->db->where('lojistik_satinalma_item.lojistik_id',$id);
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

        $this->db->group_by('`lojistik_satinalma_item`.`arac_id`');


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


    public function get_datatables_history($id)

    {



        $this->_get_datatables_query_details_history($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _get_datatables_query_details_history($id)

    {

        $this->db->select('lojistik_to_car_history.id,locations.location,geopos_employees.name  as pers_name,lojistik_to_car_history.created_at,lojistik_to_car_history.desc,arac_history_status.name');
        $this->db->from('lojistik_to_car_history');
        $this->db->join('locations','lojistik_to_car_history.sf_lokasyon_id=locations.id');
        $this->db->join('geopos_employees','lojistik_to_car_history.user_id=geopos_employees.id');
        $this->db->join('arac_history_status','lojistik_to_car_history.status=arac_history_status.id');

        $this->db->where('lojistik_to_car_history.lojistik_to_car_id',$id);
        $i = 0;

        foreach ($this->column_search_history as $item) // loop column

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



                if (count($this->column_search_history) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $this->db->order_by('`lojistik_to_car_history`.`id`','DESC');


    }
    public function count_filtered_history($id)

    {

        $this->_get_datatables_query_details_history($id);

        $query = $this->db->get();



        return $query->num_rows();

    }
    public function count_all_history($id)

    {

        $this->_get_datatables_query_details_history($id);



        return $this->db->count_all_results();

    }

    public function car_info($id){
        $this->db->select('*');
        $this->db->from('lojistik_to_car');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();

    }
    public function satinalma_location($id){
        $this->db->select('locations.*');
        $this->db->from('satinalma_location');
        $this->db->join('locations','satinalma_location.location_id = locations.id','LEFT');
        $this->db->where('satinalma_location.lojistik_id',$id);
        $this->db->group_by('`satinalma_location`.`location_id`');
        $query = $this->db->get();
        return $query->result();

    }
    public function arac_history_status(){
        $this->db->select('*');
        $this->db->from('arac_history_status');
        $query = $this->db->get();
        return $query->result();

    }

}
