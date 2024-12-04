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




defined('BASEPATH') OR exit('No direct script access allowed');





class Personelpointvalue_model extends CI_Model
{
    var $table_news = 'personel_point_value ';

    var $column_search = array('personel_point_value.name', 'personel_point_value.who_entered');

    var $column_order = array('personel_point_value.name', 'personel_point_value.who_entered');

    var $order = array('personel_point_value.id' => 'DESC');


    public function __construct()
    {
        parent::__construct();
        $this->load->model('communication_model');

    }

    public function list()

    {
        $this->_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _list()

    {


        $this->db->select('*');
        $this->db->from('personel_point_value');





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
        } else {
            $this->db->order_by('`personel_point_value`.`id` DESC');
        }


    }


    public function count_filtered()
    {
        $this->_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_list();
        return $this->db->count_all_results();
    }

}
 *
 */


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


defined('BASEPATH') or exit('No direct script access allowed');


class Personelpointvalue_model extends CI_Model

{

    var $table = 'personel_point_value';

    var $column_order = array('personel_point_value.id', 'personel_point_value.name', 'geopos_employees.name', 'personel_point_value.created_at');

    var $column_search = array('personel_point_value.name', 'geopos_employees.name', 'personel_point_value.created_at');

    var $order = array('personel_point_value.id' => 'desc');

    public function list()
    {
        $this->_list();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();

        return $query->result();
    }

    private function _list()
    {

        $this->db->select('personel_point_value.*,geopos_employees.`name` as personel_name');
        $this->db->from('personel_point_value');
        $this->db->join('geopos_employees', 'personel_point_value.auth_id=geopos_employees.id');
        $this->db->where('personel_point_value.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        $i = 0;

        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) // first loop
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);

                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }


        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }

    function count_filtered($id = '')
    {
        $this->_list();
        $query = $this->db->get();
        return $query->num_rows($id = '');
    }

    public function count_all($id = '')
    {
        $this->_list();
        $query = $this->db->get();
        return $query->num_rows($id = '');

    }

    public function create_save(){
        $name = $this->input->post('name');

            $data = array(

                'name' => $name,
                'auth_id' => $this->aauth->get_user()->id,
                'loc' => $this->session->userdata('set_firma_id')
            );

            if ($this->db->insert('personel_point_value', $data)) {


                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde Oluşturuldu'
                ];

            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız'
                ];
            }



    }

    public function update(){
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $auth_id = $this->aauth->get_user()->id;
        $loc = $this->session->userdata('set_firma_id');

        $data = array(
            'id'=>$id,
            'name' => $name,
            'auth_id' => $auth_id,
            'loc' => $loc
        );

        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->where('auth_id', $auth_id);
        $this->db->where('loc', $loc);
        if ($this->db->update('personel_point_value'))
        {
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Personel degeri Güncellendi'
            ];
        }
        else
        {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }

    }

    public function delete()
    {
        $deger_id = $this->input->post('pers_id');

        $query = $this->db->query("SELECT * FROM `personel_point` WHERE `point_value_id`=$deger_id");
        if ($query->num_rows()>0)
        {
            $this->db->where(['point_value_id' => $deger_id])->delete('personel_point');
            return [
                'status' => 0,
                'messages' => 'Bu degere personel puanlamasi yapilmisdir bundan dolayi silinemez'
            ];
        }
        else{
            if ($this->db->where(['id' => $deger_id])->delete('personel_point_value'))
            {


                return [
                    'status' => 1,
                    'messages' => 'Başarıyla Silindi'
                ];
            }
            else
            {
                return [
                    'status' => 0,
                    'messages' => 'Hata Aldınız. Yöneticiye Başvurun'
                ];
            }
        }

    }

    public function details($id){
        $this->db->select('*');
        $this->db->from('personel_point_value');
        if($this->session->userdata('set_firma_id')){
            $this->db->where('personel_point_value.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }
}


