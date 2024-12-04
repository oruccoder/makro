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
class Projectbolum_model extends CI_Model
{
    var $column_order = array('project_bolum.id','project_bolum.code', 'project_bolum.name', 'project_bolum.desc',null);

    var $column_search = array('project_bolum.code','project_bolum.name','project_bolum.desc');

    public function __construct()
    {
        parent::__construct();

    }

    public function ajax_list(){
        $this->_ajax_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _ajax_list()
    {

        $this->db->select('*');
        $this->db->from('project_bolum');
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

        }
        else {
            $this->db->order_by('`project_bolum`.`id` DESC');
        }

    }
    public function count_filtered()
    {
        $this->_ajax_list();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all()
    {
        $this->_ajax_list();
        return $this->db->count_all_results();
    }
    public function create(){

        $desc = $this->input->post('desc');
        $name = $this->input->post('name');
        $code = isEmptyFunction( $this->input->post('code'),numaric(46));
        $data = array(
            'code'=>$code,
            'name'=>$name,
            'desc'=>$desc,
            'auth_id' => $this->aauth->get_user()->id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        $index=0;
        if ($this->db->insert('project_bolum', $data)) {
            $last_id = $this->db->insert_id();
            numaric_update(46);
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Bölüm Eklendi',
            ];
        }
        else{
            return [
                'status'=>0,
                'message'=>'Eklenirken Hata Aldınız',
            ];
        }
    }
    public function info()
    {
        $id=$this->input->post('bolum_id');
        $this->db->select('*');
        $this->db->from('project_bolum');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function update()
    {
        $id = $this->input->post('id');
        $data = array(
            'desc' => $this->input->post('desc'),
            'name' => $this->input->post('name'),
            'code' => isEmptyFunction( $this->input->post('code'),numaric(46))
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('project_bolum')) {
            numaric_update(46);
            $this->aauth->applog("Proje Bolumu Düzenlendi ".$id,$this->aauth->get_user()->username);
            return [
                'status'=>1,
                'message'=>'Başarıyla Güncellendi'
            ];

        } else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız',
            ];

        }

    }
    public function delete()
    {
        $id = $this->input->post('id');
        $info=$this->db->query("SELECT * FROM project_bolum Where id=$id")->row();
        $kontrol = $this->db->query("SELECT * FROM geopos_project_bolum Where default_proje_bolum_id=$id")->num_rows();
        if(!$kontrol){
            if ($this->db->delete('project_bolum', array('id' => $id))) {
                $this->aauth->applog("Proje Bolumu Silindi ".$info->name,$this->aauth->get_user()->username);
                return [
                    'status'=>1,
                    'message'=>'Başarıyla Silindi'
                ];

            } else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız',
                ];

            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Bu Bölüm Bazı Projelerde Kullanılmaktadır.',
            ];

        }


    }
}