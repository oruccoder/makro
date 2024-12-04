<?php

class Lojistikconfirm_model extends CI_Model

{
    var $column_search = array('code', 'geopos_customers.company','toplam_teklif','toplam_gider','geopos_account_type.name');
    var $order = array('lsf_table_file.id' => 'DESC');

    public function get_datatables_details()

    {

        $this->_get_datatables_query_details();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _get_datatables_query_details()

    {

        $id= $this->aauth->get_user()->id;
        $this->db->select('lsf_table_file.*,geopos_customers.company,geopos_account_type.name as method_name');
        $this->db->from('lsf_table_file');
        $this->db->join('geopos_customers','lsf_table_file.firma_id=geopos_customers.id');
        $this->db->join('geopos_account_type','lsf_table_file.method=geopos_account_type.id');
        $this->db->where('lsf_table_file.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57

        if($id==289){
            $this->db->where('lsf_table_file.staff_id',66);
        }
        else {
            $this->db->where('lsf_table_file.staff_id',$id);
        }

        $this->db->where('lsf_table_file.staff_status',1);
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

        $this->db->order_by('`lsf_table_file`.`id`','DESC');
    }
    public function count_filtered()

    {

        $this->_get_datatables_query_details();

        $query = $this->db->get();



        return $query->num_rows();

    }
    public function count_all()

    {

        $this->_get_datatables_query_details();



        return $this->db->count_all_results();

    }


    public function get_datatables_details_item($file_id)

    {

        $this->_get_datatables_query_details_item($file_id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _get_datatables_query_details_item($file_id)

    {

        $this->db->select('lojistik_satinalma_item.lojistik_id as sf_lojistik_id,lsf_table_file_item.*,lojistik_to_gun.gun_sayisi,lojistik_to_gun.unit_price,lojistik_to_gun.total_price,araclar.name as arac_name,(lojistik_satinalma_item.qty*lojistik_satinalma_item.price) as teklif_price');
        $this->db->from('lsf_table_file_item');
        $this->db->join('lojistik_satinalma_item','lsf_table_file_item.lsf_id=lojistik_satinalma_item.id');
        $this->db->join('lojistik_to_gun','lsf_table_file_item.lsf_id=lojistik_to_gun.lsf_id','LEFT');
        $this->db->join('araclar','lojistik_satinalma_item.arac_id=araclar.id');
        $this->db->where('lsf_table_file_item.lsf_table_file_id',$file_id);
        $this->db->where('lsf_table_file_item.status',1);
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

        $this->db->order_by('`lsf_table_file_item`.`id`','DESC');
    }
    public function count_filtered_item($file_id)

    {

        $this->_get_datatables_query_details_item($file_id);

        $query = $this->db->get();



        return $query->num_rows();

    }
    public function count_all_item($file_id)

    {

        $this->_get_datatables_query_details_item($file_id);



        return $this->db->count_all_results();

    }
}
