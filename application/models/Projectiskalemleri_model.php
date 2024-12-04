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

/*Baza olan iş kalemleri modeli*/

class Projectiskalemleri_model extends CI_Model
{
    var $column_order = array('projeiskalmeleri.id','projeiskalmeleri.id','projeiskalmeleri.code',null, 'projeiskalmeleri.simeta_code', 'projeiskalmeleri.name', 'projeiskalmeleri.desc',null);

    var $column_search = array('projeiskalmeleri.code','projeiskalmeleri.simeta_code','projeiskalmeleri.name','projeiskalmeleri.desc');

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
        $this->db->from('projeiskalmeleri');
        $i = 0;



        if($this->input->post('category_id'))
        {
            $cat_id = $this->input->post('category_id');
            $parent_kontrol = $this->db->query("SELECT * FROM project_asama_parent Where parent_id = $cat_id");
            if($parent_kontrol->num_rows()){
                $id_parent=[];
                foreach ($parent_kontrol->result() as $p_items){
                    $id_parent[]=$p_items->asama_id;
                }
                $this->db->where_in('projeiskalmeleri.asama_id', $id_parent,false);
            }
            else {
                $this->db->where('projeiskalmeleri.asama_id', $cat_id);
            }

        }


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
            $this->db->order_by('`projeiskalmeleri`.`id` DESC');
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
        $asama_id = $this->input->post('asama_id');
        $unit_id = $this->input->post('unit_id');
        $unit_qty = $this->input->post('unit_qty');
        $recete_id = $this->input->post('recete_id');
        $simeta_code = $this->input->post('simeta_code');
        $code = isEmptyFunction( $this->input->post('code'),numaric(48));
        $simeta_code = isEmptyFunction( $this->input->post('simeta_code'),$code);
        $data = array(
            'code'=>$code,
            'name'=>$name,
            'recete_id'=>$recete_id,
            'asama_id'=>$asama_id,
            'desc'=>$desc,
            'unit_qty'=>$unit_qty,
            'unit_id'=>$unit_id,
            'simeta_code'=>$simeta_code,
            'auth_id' => $this->aauth->get_user()->id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        $index=0;
        if ($this->db->insert('projeiskalmeleri', $data)) {
            $last_id = $this->db->insert_id();
            numaric_update(48);
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
    public function update()
    {
        $id = $this->input->post('id');
        $data = array(
            'desc' => $this->input->post('desc'),
            'recete_id' => $this->input->post('recete_id'),
            'name' => $this->input->post('name'),
            'asama_id' => $this->input->post('asama_id'),
            'unit_id' => $this->input->post('unit_id'),
            'unit_qty' => $this->input->post('unit_qty'),
            'code' => isEmptyFunction( $this->input->post('code'),numaric(48)),
            'simeta_code' => isEmptyFunction( $this->input->post('simeta_code'),numaric(48))
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('projeiskalmeleri')) {
            numaric_update(48);
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
    public function info()
    {
        $id=$this->input->post('asama_id');
        $this->db->select('*');
        $this->db->from('projeiskalmeleri');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function parent_info($id)
    {
        $this->db->select('*');
        $this->db->from('projeiskalmeleri_parent');
        $this->db->where('asama_id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function delete()
    {
        $id = $this->input->post('id');
        $info=$this->db->query("SELECT * FROM projeiskalmeleri Where id=$id")->row();
        // $kontrol = $this->db->query("SELECT * FROM geopos_milestones Where default_proje_asama_id=$id")->num_rows();
        $kontrol=false;
        if(!$kontrol){
            if ($this->db->delete('projeiskalmeleri', array('id' => $id))) {
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
        $is_kalemi_details = $this->input->post('is_kalemi_details');
        if($is_kalemi_details){
            $i=0;
            $j=0;
            foreach ($is_kalemi_details as $iskalemi_items){
                $parent_id = $iskalemi_items['is_kalemi_id'];
                $qty = $iskalemi_items['qty'];

                $iskalemi_details_who = $this->db->query("SELECT * FROM projeiskalmeleri Where id = $parent_id")->row();
                $asama_id = $iskalemi_details_who->asama_id;
                $kontrol=$this->db->query("SELECT * FROM project_new_islist Where asama_id = $asama_id and iskalemleri_id=$parent_id and bolum_id=$bolum and proje_id=$proje_id")->num_rows();
                if(!$kontrol){
                    $data = [
                        'proje_id' => $proje_id,
                        'iskalemleri_id' => $parent_id,
                        'qty' => $qty,
                        'bolum_id' => $bolum,
                        'asama_id' => $asama_id,
                        'loc' => $this->session->userdata('set_firma_id'),
                        'auth_id' => $this->aauth->get_user()->id

                    ];
                    if ($this->db->insert('project_new_islist', $data)) {
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
                    'message'=>'Başarılı Bir Şekilde '.$i.' Adet iş Kalemi Eklendi',
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
                'message'=>'İş Kalemi Bulunamadı',
                'id'=>0
            ];
        }
    }
}