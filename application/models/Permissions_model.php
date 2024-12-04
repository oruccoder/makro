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





class Permissions_model extends CI_Model
{
    var $table_news = 'geopos_role';
    var $column_order = array('geopos_role.id', 'geopos_role.role_id', 'geopos_role.name');
    var $column_search =  array('geopos_role.id', 'geopos_role.role_id', 'geopos_role.name');
    var $order = array('id' => 'DESC');


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

        $this->db->select('*');
        $this->db->from('geopos_role');

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
        $this->db->order_by('`geopos_role`.`id` DESC');

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

    public function details($role_id){
        $this->db->select('user_permissions.*,geopos_premissions.module as module_name');
        $this->db->from('user_permissions');
        $this->db->join('geopos_premissions','user_permissions.module_id=geopos_premissions.id');
        $this->db->where('role_id', $role_id);
        $query = $this->db->get();
        return $query->result();
    }
    public function update()
    {

        $post_data = $this->input->post("collection");
        $role_id = $this->input->post("role_id");
        if (isset($post_data)) {
            if($this->aauth->get_user()->roleid==4 || $this->aauth->get_user()->id==21){ // sade IT GÜncelleme Yapabilir
                $this->db->delete('user_permissions', array('role_id' => $role_id));
                $index=0;
                $product_list=[];
                foreach ($post_data as $items){
                    $data = array(
                        'role_id' => $role_id,
                        'write' => $items['write'],
                        'delete' => $items['delete'],
                        'update' => $items['update'],
                        'read' => $items['read'],
                        'module_id' => $items['module_id'],
                    );
                    $product_list[$index]=$data;
                    $index++;
                }
                if($index){
                    if ($this->db->insert_batch('user_permissions', $product_list)) {
                        $this->aauth->applog("KUllanıcı Yetkilendirme Ayarları Yapıldı : ".$role_id, $this->aauth->get_user()->username);
                        return [
                            'status'=>1,
                            'message'=>'Başarıyla Güncellendi',
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
                    'message'=>'Sadece IT Bölümü Güncelleme Yapabilir!',
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
}
