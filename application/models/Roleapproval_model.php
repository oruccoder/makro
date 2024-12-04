<?php


//R
defined('BASEPATH') OR exit('No direct script access allowed');


class Roleapproval_model extends CI_Model
{
    var $column_order_approval = array(null,'role_approvals.code','geopos_role.name');

    var $column_search_approval = array('role_approvals.code','geopos_role.name');

    var $order = array('id' => 'DESC');

    public function __construct()
    {
        parent::__construct();

    }

    function approval_list()

    {
        $this->_approval_list();
        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }

    private function _approval_list()

    {

        $this->db->select('role_approvals.*,geopos_role.name');
        $this->db->from('role_approvals');
        $this->db->join('geopos_role','role_approvals.approval_id=geopos_role.role_id');
        if($this->session->userdata('set_firma_id')){
            $this->db->where('role_approvals.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $i = 0;

        foreach ($this->column_search_approval as $item) // loop column

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

                if (count($this->column_search_approval) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }

        $order = $this->input->post('order');

        if ($order) {

            $this->db->order_by($this->column_order_approval[$order['0']['column']], $order['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }

    function count_filtered_fis_list()

    {

        $this->_approval_list();
        $query = $this->db->get();
        return $query->num_rows();

    }
    public function count_all_fis_list()

    {

        $this->_approval_list();


        $query = $this->db->get();

        return $query->num_rows();

    }

    public function create_approval(){

        $post_data = $this->input->post("collection");

        $loc=$this->session->userdata('set_firma_id');

        if(isset($post_data)){

            $v_id = $post_data[0]['v_id'];

            $kontrol = $this->db->query("SELECT * FROM role_approvals Where approval_id=$v_id and loc=$loc");
            if($kontrol->num_rows()){
                return [
                    'status'=>0,
                    'message'=>'Bu Vazifeye Kullanıcılar Atanmıştır.Güncelleme Yapınız',
                    'id'=>0
                ];
            }
            else {
                $code = numaric(26);
                $data_items = array(
                    'aauth_id'      => $this->aauth->get_user()->id,
                    'code'         => $code ,
                    'approval_id'         => $v_id ,
                    'loc'         => $loc,
                );

                if($this->db->insert('role_approvals', $data_items)){
                    $role_approvals_id = $this->db->insert_id();
                    $index=0;
                    $product_list=[];
                    foreach ($post_data as $items){
                        $data = array(
                            'role_id' => $role_approvals_id,
                            'short' => $items['sort'],
                            'staff_id' => $items['user_id'],
                        );
                        $product_list[$index]=$data;
                        $index++;
                    }
                    if($index){
                        if ($this->db->insert_batch('role_approvals_items', $product_list)) {
                            $operator= "deger+1";
                            $this->db->set('deger', "$operator", FALSE);
                            $this->db->where('tip', 26);
                            $this->db->update('numaric');
                            $this->aauth->applog("KUllanıcı Rollerinin Ayarlamaları Yapıldı : ".$role_approvals_id, $this->aauth->get_user()->username);
                            return [
                                'status'=>1,
                                'message'=>'Başarıyla Oluşturulmuştur',
                                'id'=>0
                            ];
                        }
                    }
                    else {
                        return [
                            'status'=>0,
                            'message'=>'Hata Aldınız',
                            'id'=>0
                        ];
                    }
                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız',
                        'id'=>0
                    ];
                }
            }


        }
        else {
            return [
                'status'=>0,
                'message'=>'Herhangi Bir Veri Gönderilmemiştir',
                'id'=>0
            ];
        }
    }

    public function update_approval(){

        $post_data = $this->input->post("collection");
        if(isset($post_data)){
            $role_approvals_id = $this->input->post("roleapp_id");
            $this->db->delete('role_approvals_items', array('role_id' => $role_approvals_id));
            $index=0;
            $product_list=[];
            foreach ($post_data as $items){
                $data = array(
                    'role_id' => $role_approvals_id,
                    'short' => $items['sort'],
                    'staff_id' => $items['user_id'],
                );
                $product_list[$index]=$data;
                $index++;
            }

            if($index){
                if ($this->db->insert_batch('role_approvals_items', $product_list)) {
                    $this->aauth->applog("KUllanıcı Rollerinin Güncelleme Yapıldı : ".$role_approvals_id, $this->aauth->get_user()->username);
                    return [
                        'status'=>1,
                        'message'=>'Başarıyla Oluşturulmuştur',
                        'id'=>0
                    ];
                }
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız',
                    'id'=>0
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Herhangi Bir Veri Gönderilmemiştir',
                'id'=>0
            ];
        }
    }

    public function delete(){
        $id = $this->input->post('roleapp_id');
        $details = $this->details($id);
        $code = $details->code;
        $user_id = $this->aauth->get_user()->id;
        if($user_id==$details->aauth_id){
            $this->db->delete('role_approvals_items', array('role_id' => $id));
            if( $this->db->delete('role_approvals', array('id' => $id))){
                $this->aauth->applog("KUllanıcı Tanımlamaları Silindi : ".$code, $this->aauth->get_user()->username);
                return [
                    'status'=>1,
                    'message'=>'Başarıyla Silindi',
                    'id'=>0
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız',
                    'id'=>0
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Silmek için Yetkiniz Bulunmamaktadır.Yönetici İle İletişime Geçiniz',
                'id'=>0
            ];
        }
    }

    public function details($id){
        $this->db->select('*');
        $this->db->from('role_approvals');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function role_details($id){
        $this->db->select('*');
        $this->db->from('geopos_role');
        $this->db->where('role_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function item_details($id){
        $this->db->select('role_approvals_items.*,geopos_employees.name');
        $this->db->from('role_approvals_items');
        $this->db->join('geopos_employees','role_approvals_items.staff_id=geopos_employees.id');
        $this->db->where('role_id', $id);
        $this->db->order_by('role_approvals_items.short','ASC');
        $query = $this->db->get();
        return $query->result();
    }

}