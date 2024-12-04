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





class Projebolumleri_model extends CI_Model
{
    var $table_news = 'geopos_project_bolum ';

    var $column_order = array('id', 'name', 'exp', 'butce');

    var $column_search = array('id', 'name', 'exp', 'butce');

    var $order = array('id' => 'DESC');


    public function __construct()
    {
        parent::__construct();

        $this->load->model('projectsnew_model', 'proje_model_new');
    }

    private function _bolum_datatables_query($cday = '')

    {

        $this->db->from('geopos_project_bolum');

        $i = 0;

        foreach ($this->column_search as $item) // loop column

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



                if (count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_search[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }
    function bolumler_datatables($cday = '')

    {


        $this->_bolum_datatables_query($cday);



        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $this->db->where('pid=', $cday);

        $query = $this->db->get();

        return $query->result();

    }
    function bolum_count_filtered($cday = '')

    {

        $this->_bolum_datatables_query($cday);
        $this->db->where('pid=', $cday);

        $query = $this->db->get();

        return $query->num_rows();

    }
    public function bolum_count_all($cday = '')

    {

        $this->_bolum_datatables_query($cday);

        $this->db->where('pid=', $cday);

        $query = $this->db->get();

        return $query->num_rows();

    }

    public function create(){

        $name = $this->input->post('name');
        $content = $this->input->post('content');
        $butce = $this->input->post('butce');
        $code = $this->input->post('code');
        $simeta_code = $this->input->post('simeta_code');
        $code = isEmptyFunction($this->input->post('product_code'),numaric(46));
        $simeta_code = isEmptyFunction($this->input->post('simeta_code'),$code);
        $prid = $this->input->post('project');
        $data = array(
            'pid' => $prid,
            'name' => $name,
            'code' => $code,
            'butce' => 0,
            'simeta_code' => $simeta_code,
            'exp' => $content);

        if ($this->db->insert('geopos_project_bolum', $data)) {
            $last_id = $this->db->insert_id();
            numaric_update(46);
            $this->proje_model_new->talep_history($last_id, $this->aauth->get_user()->id,' Proje Bölümü Eklendi.Bölüm Adı : '.$name);

            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Bölüm Eklendi',
                'id'=>$last_id
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

    public function update(){

        $bolum_id = $this->input->post('bolum_id');
        $code = $this->input->post('code');
        $simeta_code = $this->input->post('simeta_code');
        $code = isEmptyFunction($this->input->post('product_code'),numaric(46));
        $simeta_code = isEmptyFunction($this->input->post('simeta_code'),$code);

        $name = $this->input->post('name');
        $content = $this->input->post('content');
        $butce = $this->input->post('butce');
        $prid = $this->input->post('project');
        $data = array(
            'pid' => $prid,
            'name' => $name,
            'code' => $code,
            'simeta_code' => $simeta_code,
            'butce' => $butce,
            'exp' => $content);

        $this->db->where('id',$bolum_id);
        $this->db->set($data);
        if ($this->db->update('geopos_project_bolum', $data)) {
            numaric_update(46);

            $this->proje_model_new->talep_history($prid, $this->aauth->get_user()->id,' Proje Bölümü Düzenlendi.Bölüm Adı : '.$name);


            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Bölüm Güncellendi',
                'id'=>$bolum_id
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

    public function delete(){

        $bolum_id = $this->input->post('bolum_id');
        $details = $this->details($bolum_id);
        $kontrol = $this->db->query("SELECT * FROM geopos_milestones Where bolum_id=$bolum_id")->num_rows();
        if(!$kontrol){
            if($this->db->delete('geopos_project_bolum', array('id' => $bolum_id))){
                $this->proje_model_new->talep_history($details->pid, $this->aauth->get_user()->id,' Proje Bölümü Silindi.Bölüm Adı : '.$details->name);
                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde Bölüm Silindi',
                    'id'=>$bolum_id
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
        else {
            return [
                'status'=>0,
                'message'=>'Bölüme Bağlı Aşama Bulunmaktadır. Bu sebeple Silinemez',
                'id'=>0
            ];
        }

    }


    public function details($bolum_id){
        $this->db->select('*');
        $this->db->from('geopos_project_bolum');
        $this->db->where('id', $bolum_id);
        $query = $this->db->get();
        return $query->row();
    }


    public function add_activity($name, $prid,$key3='',$tutar=0)

    {
        $data = array('key3'=>$key3,'pid' => $prid, 'meta_key' => 12, 'value' => $name . ' @' . date('Y-m-d H:i:s'),'total'=>$tutar);

        if ($prid) {

            return $this->db->insert('geopos_project_meta', $data);

        } else {

            return 0;
        }

    }
}