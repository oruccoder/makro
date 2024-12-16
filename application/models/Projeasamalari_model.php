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





class Projeasamalari_model extends CI_Model
{
    var $table_news = 'geopos_milestones ';

    var $column_search = array('geopos_milestones.name', 'geopos_milestones.edate', 'geopos_milestones.sdate', 'geopos_employees.name');
    var $column_order = array('geopos_milestones.name', 'geopos_milestones.edate', 'geopos_milestones.sdate', 'geopos_employees.name');
    var $order = array('id' => 'DESC');


    public function __construct()
    {
        parent::__construct();

    }

    private function _asama_datatables_query($cday = '')

    {

    $this->db->select("geopos_milestones.*,geopos_employees.name AS pers_name");

    $this->db->from('geopos_milestones');

    $this->db->join('geopos_employees', 'geopos_milestones.pers_id = geopos_employees.id', 'left');



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
    function asamalar_datatables($cday = '')

    {


    $this->_asama_datatables_query($cday);



    if ($this->input->post('length') != -1)

    $this->db->limit($this->input->post('length'), $this->input->post('start'));

    $this->db->where('pid=', $cday);

    $query = $this->db->get();

    return $query->result();

    }
    function asama_count_filtered($cday = '')

    {

    $this->_asama_datatables_query($cday);
    $this->db->where('pid=', $cday);

    $query = $this->db->get();

    return $query->num_rows();

    }
    public function asama_count_all($cday = '')

    {

    $this->_asama_datatables_query($cday);

    $this->db->where('pid=', $cday);

    $query = $this->db->get();

    return $query->num_rows();

    }

    public function create(){
        $name = $this->input->post('name');
        $customer = $this->input->post('customer');
        $content = $this->input->post('content');
        $bolum = $this->input->post('bolum');
        $parent_id = $this->input->post('parent_id');
        $butce = $this->input->post('butce');
        $prid = $this->input->post('project');
        $pers_id = $this->input->post('pers_id');
        $olcu_birimi = $this->input->post('olcu_birimi');
        $quantity = $this->input->post('quantity');
        $fiyat = $this->input->post('fiyat');
        $toplam_fiyat = $this->input->post('toplam_fiyat');
        $data = [
            'pid' => $prid,
            'name' => $name,
            'exp' => $content,
            'bolum_id'=>$bolum,
            'pers_id'=>$pers_id,
            'total'=>$butce,
            'customer_id'=>$customer,
            'olcu_birimi'=>$olcu_birimi,
            'quantity'=>$quantity,
            'fiyat'=>$fiyat,
            'toplam'=>$toplam_fiyat,
            'parent_id'=>$parent_id
        ];

        if ($this->db->insert('geopos_milestones', $data)) {
            $last_id = $this->db->insert_id();
            $title = '[Aşama Adı] ' . $name;
            $this->add_activity($title, $prid);
            $this->aauth->applog("Projeye Aşama Eklendi ID: ".$prid, $this->aauth->get_user()->username);

            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Aşama Eklendi',
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

        $asama_id = $this->input->post('asama_id');
        $name = $this->input->post('name');
        $customer = $this->input->post('customer');
        $content = $this->input->post('content');
        $bolum = $this->input->post('bolum');
        $parent_id = $this->input->post('parent_id');
        $butce = $this->input->post('butce');
        $prid = $this->input->post('project');
        $pers_id = $this->input->post('pers_id');
        $olcu_birimi = $this->input->post('olcu_birimi');
        $quantity = $this->input->post('quantity');
        $fiyat = $this->input->post('fiyat');
        $toplam_fiyat = $this->input->post('toplam_fiyat');
        $data = [
            'pid' => $prid,
            'name' => $name,
            'exp' => $content,
            'bolum_id'=>$bolum,
            'pers_id'=>$pers_id,
            'total'=>$butce,
            'customer_id'=>$customer,
            'olcu_birimi'=>$olcu_birimi,
            'quantity'=>$quantity,
            'fiyat'=>$fiyat,
            'toplam'=>$toplam_fiyat,
            'parent_id'=>$parent_id
        ];
        $this->db->where('id',$asama_id);
        $this->db->set($data);
        if ($this->db->update('geopos_milestones', $data)) {
            $title = 'Güncelleme Yapıldı [Aşama Adı] ' . $name;
            $this->add_activity($title, $prid);
            $this->aauth->applog("Aşama Güncellendi ID: ".$prid, $this->aauth->get_user()->username);

            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Aşama Güncellendi',
                'id'=>$asama_id
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

    public function delete()
    {
        // Kullanıcı kimliğini kontrol et
        if ($this->aauth->get_user()->id != 21) {
            return [
                'status' => 0,
                'message' => 'Yetkiniz Bulunmamaktadır. Bu işlemi yapamazsınız.',
                'id' => 0
            ];
        }

        // Aşama ID'sini al
        $asama_id = $this->input->post('asama_id');
        $details = $this->details($asama_id);

        // Silme işlemi
        if ($this->db->delete('geopos_milestones', ['id' => $asama_id])) {
            $title = 'Silindi [Aşama Adı] ' . $details->name . ' | Personel: ' . $this->aauth->get_user()->username;
            $this->add_activity($title, $details->pid);
            $this->aauth->applog("Aşama Silindi ID: " . $details->pid, $this->aauth->get_user()->username);

            return [
                'status' => 1,
                'message' => 'Başarılı Bir Şekilde Aşama Silindi',
                'id' => $asama_id
            ];
        } else {
            return [
                'status' => 0,
                'message' => 'Hata Aldınız. Yöneticiye Başvurun.',
                'id' => 0
            ];
        }
    }



    public function details($asama_id){
        $this->db->select('*');
        $this->db->from('geopos_milestones');
        $this->db->where('id', $asama_id);
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