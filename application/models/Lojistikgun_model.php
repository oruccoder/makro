<?php

class Lojistikgun_model extends CI_Model

{

    var $table = 'lojistik_to_gun';
    var $column_order = array('araclar.name as arac_name', 'lojistik_to_gun.gun_sayisi','lojistik_to_gun.unit_price ','lojistik_to_gun.total_price');
    var $column_search = array('araclar.name as arac_name', 'lojistik_to_gun.gun_sayisi','lojistik_to_gun.unit_price ','lojistik_to_gun.total_price');
    var $order = array('lojistik_to_gun.id' => 'DESC');

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

        $this->db->select('lojistik_to_gun.*,araclar.name as arac_name');
        $this->db->from('lojistik_to_gun');
        $this->db->join('araclar','lojistik_to_gun.arac_id=araclar.id');
        $this->db->where('lojistik_to_gun.lojistik_id',$id);
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

        $this->db->order_by('`lojistik_to_gun`.`id`','DESC');
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


    public function get_datatables_details_personel($id)

    {

        $this->_get_datatables_query_details_personel($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
//
        return $query->result();

    }
    private function _get_datatables_query_details_personel($id)

    {

        $this->db->select('lojistik_arac_personel_history.aaut_id,lojistik_arac_personel_history_item.user_id,lojistik_to_car_history.arac_id,lojistik_arac_personel_history_item.status,lojistik_arac_personel_history_item.desc,lojistik_arac_personel_history_item.created_at');
        $this->db->from('lojistik_to_car_history');
        $this->db->join('lojistik_arac_personel_history','lojistik_to_car_history.lojistik_to_car_id=lojistik_arac_personel_history.lojistik_to_car_history_id');
        $this->db->join('lojistik_arac_personel_history_item','lojistik_arac_personel_history.id=lojistik_arac_personel_history_item.lojistik_arac_personel_history_id');
        $this->db->where('lojistik_to_car_history.lojistik_id',$id);
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

        $this->db->group_by('`lojistik_arac_personel_history_item`.`id`');
        $this->db->order_by('`lojistik_to_car_history`.`id`','DESC');
    }
    public function count_filtered_personel($id)

    {

        $this->_get_datatables_query_details_personel($id);

        $query = $this->db->get();



        return $query->num_rows();

    }
    public function count_all_personel($id)

    {

        $this->_get_datatables_query_details_personel($id);



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

    public function cost_details($id){
        $this->db->select('*');
        $this->db->from('lojistik_to_gun');
        $this->db->Where('lojistik_to_gun.id',$id);
        $query = $this->db->get();
        return $query->row();

    }
}
