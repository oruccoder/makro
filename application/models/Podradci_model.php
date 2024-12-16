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
class Podradci_model extends CI_Model
{
    var $column_order = array('podradci.id','podradci.company', 'podradci.yetkili_kisi', 'podradci.telefon','podradci.adres',null);

    var $column_search = array('podradci.company','podradci.yetkili_kisi','podradci.telefon','podradci.adres');

    var $doccolumn_order = array(null, 'title', 'cdate', null);

    var $doccolumn_search = array('title', 'cdate');
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
        $this->db->from('podradci');
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
            $this->db->order_by('`podradci`.`id` DESC');
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


        $company = $this->input->post('company');
        $yetkili_kisi = $this->input->post('yetkili_kisi');
        $yetkili_telefon = $this->input->post('yetkili_telefon');
        $sektor = $this->input->post('sektor');
        $adres = $this->input->post('adres');
        $telefon = $this->input->post('telefon');
        $ana_cari = $this->input->post('ana_cari');
        $desc = $this->input->post('desc');
        $parent_id = $this->input->post('parent_id');

        $data = array(
            'company'=>$company,
            'yetkili_kisi'=>$yetkili_kisi,
            'yetkili_telefon'=>$yetkili_telefon,
            'adres'=>$adres,
            'sektor'=>$sektor,
            'ana_cari'=>$ana_cari,
            'telefon'=>$telefon,
            'desc'=>$desc,
            'auth_id' => $this->aauth->get_user()->id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        $index=0;
        if ($this->db->insert('podradci', $data)) {
            $last_id = $this->db->insert_id();
            if($parent_id){
                $data_parent = array(
                    'podradci_id'=>$last_id,
                    'parent_id'=>$parent_id,
                );
                $this->db->insert('podradci_parent', $data_parent);
            }
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Podradci Eklendi',
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
        $id=$this->input->post('asama_id');
        $this->db->select('*');
        $this->db->from('podradci');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function details($id)
    {

        $this->db->select('*');
        $this->db->from('podradci');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }


    public function parent_info($id)
    {
        $this->db->select('*');
        $this->db->from('podradci_parent');
        $this->db->where('podradci_id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function update()
    {
        $id = $this->input->post('id');

        $company = $this->input->post('company');
        $yetkili_kisi = $this->input->post('yetkili_kisi');
        $yetkili_telefon = $this->input->post('yetkili_telefon');
        $sektor = $this->input->post('sektor');
        $adres = $this->input->post('adres');
        $telefon = $this->input->post('telefon');
        $ana_cari = $this->input->post('ana_cari');
        $desc = $this->input->post('desc');
        $parent_id = $this->input->post('parent_id');


        $data = array(
            'company'=>$company,
            'yetkili_kisi'=>$yetkili_kisi,
            'yetkili_telefon'=>$yetkili_telefon,
            'adres'=>$adres,
            'sektor'=>$sektor,
            'ana_cari'=>$ana_cari,
            'telefon'=>$telefon,
            'desc'=>$desc,
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('podradci')) {
            $this->db->delete('podradci_parent', array('podradci_id' => $id));
            if($parent_id){
                $data_parent = array(
                    'podradci_id'=>$id,
                    'parent_id'=>$parent_id,
                );
                $this->db->insert('podradci_parent', $data_parent);
            }

            $this->aauth->applog("Podradci Düzenlendi ".$id,$this->aauth->get_user()->username);
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
        $info=$this->db->query("SELECT * FROM podradci Where id=$id")->row();
        $name=$info->company;
        $kontrol2 = $this->db->query("SELECT * FROM podradci_parent Where parent_id=$id")->num_rows();
        if(!$kontrol2){
            $kontrol = $this->db->query("SELECT * FROM geopos_employees_p Where podradci_id=$id")->num_rows();

            if(!$kontrol){
                if ($this->db->delete('podradci', array('id' => $id))) {
                    $this->aauth->applog("Podradçi Silindi ".$name,$this->aauth->get_user()->username);
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
                    'message'=>'Bu Podradciya Ait Personel Bulunmaktadır.',
                ];

            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Bu Podradciya Ait Alt Podradçi Mevcuttur.',
            ];

        }



    }

    function document_datatables($cid)

    {

        $this->document_datatables_query($cid);

        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }



    private function document_datatables_query($cid)

    {



        $this->db->from('geopos_documents');

        $this->db->where('fid',$cid);

        $this->db->where('rid',2);

        $i = 0;



        foreach ($this->doccolumn_search as $item) // loop column

        {

            $search = $this->input->post('search');

            $value = $search['value'];

            if ($value) {



                if ($i === 0) {

                    $this->db->group_start();

                    $this->db->like($item, $value);

                } else {

                    $this->db->or_like($item, $value);

                }



                if (count($this->doccolumn_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->doccolumn_order[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }



    function document_count_filtered($cid)

    {

        $this->document_datatables_query($cid);

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function document_count_all($cid)

    {

        $this->document_datatables_query($cid);

        $query = $this->db->get();

        return $query->num_rows();

    }
}