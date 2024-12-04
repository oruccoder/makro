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

/*Baza olan Proje Aşamaları modeli*/

defined('BASEPATH') OR exit('No direct script access allowed');
class Projectasama_model extends CI_Model
{
    var $column_order = array(null,null,'project_asama.id','project_asama.code', 'project_asama.simeta_code','project_asama.name', 'project_asama.desc',null);

    var $column_search = array('project_asama.code','project_asama.simeta_code','project_asama.name','project_asama.desc');

    public function __construct()
    {
        parent::__construct();
        $this->load->model('projectsnew_model', 'proje_model_new');

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
        $this->db->from('project_asama');


        if($this->input->post('category_id'))
        {
            $cat_id = $this->input->post('category_id');

            //echo "<pre>";print_r(_ust_kategori_kontrol_return_array($cat_id));

            $parent_kontrol = $this->db->query("SELECT * FROM project_asama_parent Where parent_id = $cat_id");
            if($parent_kontrol->num_rows()){
                $id_parent=[];
                foreach ($parent_kontrol->result() as $p_items){
                    $id_parent[]=$p_items->asama_id;
                }
                $this->db->where_in('project_asama.id', $id_parent,false);
            }
            else {
                $this->db->where('project_asama.id', 0);
            }





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

        }
        else {
            $this->db->order_by('`project_asama`.`id` DESC');
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
        $parent_id = $this->input->post('parent_id');
        $simeta_code = $this->input->post('simeta_code');
        $code = isEmptyFunction( $this->input->post('code'),numaric(47));
        $simeta_code = isEmptyFunction( $this->input->post('simeta_code'),$code);
        $data = array(
            'code'=>$code,
            'name'=>$name,
            'desc'=>$desc,
            'simeta_code'=>$simeta_code,
            'auth_id' => $this->aauth->get_user()->id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        $index=0;
        if ($this->db->insert('project_asama', $data)) {
            $last_id = $this->db->insert_id();
            if($parent_id){
                $data_parent = array(
                    'asama_id'=>$last_id,
                    'parent_id'=>$parent_id,
                );
                $this->db->insert('project_asama_parent', $data_parent);
            }
            numaric_update(47);
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
        $id=$this->input->post('asama_id');
        $this->db->select('*');
        $this->db->from('project_asama');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function parent_info($id)
    {
        $this->db->select('*');
        $this->db->from('project_asama_parent');
        $this->db->where('asama_id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function update()
    {
        $id = $this->input->post('id');
        $parent_id = $this->input->post('parent_id');

        $data = array(
            'desc' => $this->input->post('desc'),
            'name' => $this->input->post('name'),
            'code' => isEmptyFunction( $this->input->post('code'),numaric(47)),
            'simeta_code' => isEmptyFunction( $this->input->post('simeta_code'),numaric(47))
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('project_asama')) {
            numaric_update(47);
            $this->db->delete('project_asama_parent', array('asama_id' => $id));
            if($parent_id){
                $data_parent = array(
                    'asama_id'=>$id,
                    'parent_id'=>$parent_id,
                );
                $this->db->insert('project_asama_parent', $data_parent);
            }

            $this->aauth->applog("Proje Aşaması Düzenlendi ".$id,$this->aauth->get_user()->username);
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
        $info=$this->db->query("SELECT * FROM project_asama Where id=$id")->row();
        $kontrol = $this->db->query("SELECT * FROM geopos_milestones Where default_proje_asama_id=$id")->num_rows();
        if(!$kontrol){
            if ($this->db->delete('project_asama', array('id' => $id))) {
                $this->aauth->applog("Proje Aşaması Silindi ".$info->name,$this->aauth->get_user()->username);
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
                'message'=>'Bu Aşama Bazı Bölümlerde Kullanılmaktadır.',
            ];

        }


    }

    public function create_proje_add()
    {
        $proje_id = $this->input->post('proje_id');
        $bolum = $this->input->post('bolum_id');
        $asama_details = $this->input->post('asama_details');
        if($asama_details){
            $i=0;
            $j=0;
            foreach ($asama_details as $asama_items){
                $parent_id = $asama_items['asama_id'];
                $kontrol=$this->db->query("SELECT * FROM geopos_milestones Where default_proje_asama_id=$parent_id and bolum_id=$bolum and pid=$proje_id")->num_rows();
                if(!$kontrol){
                    $asama_details_who = $this->db->query("SELECT * FROM project_asama Where id=$parent_id")->row();
                    $data = [
                        'code' => $asama_details_who->code,
                        'simeta_code' => $asama_details_who->simeta_code,
                        'pid' => $proje_id,
                        'bolum_id'=>$bolum,
                        'default_proje_asama_id'=>$parent_id
                    ];

                    if ($this->db->insert('geopos_milestones', $data)) {
                        $last_id = $this->db->insert_id();
                        $this->proje_model_new->talep_history($proje_id, $this->aauth->get_user()->id,' Proje Aşama Eklendi.Aşama Adı : '.$asama_details_who->name);

                        $i++;
                    }
                }
                else {
                    $j++;
                }
            }
            if($i){
                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde '.$i.' Adet Aşama Eklendi',
                ];
            }
            else {
                if($j){
                    return [
                        'status'=>0,
                        'message'=>'Daha önceden Eklenmiştir.Aynı Projeye ve Bölüme Eklenmiştir.',
                        'id'=>0
                    ];
                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                        'id'=>0
                    ];
                }

            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Aşama Bulunamadı',
                'id'=>0
            ];
        }

    }
}