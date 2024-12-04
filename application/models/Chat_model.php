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



class Chat_model extends CI_Model

{

    public function __construct()
    {
        parent::__construct();

    }


    public function user_ids(){

        $aut_id=$this->aauth->get_user()->id;
//        $this->db->select('user_id,auth_id,geopos_employees.name,geopos_users.picture');
//        $this->db->from('mk_chat');
//        $this->db->join('geopos_employees','mk_chat.user_id=geopos_employees.id');
//        $this->db->join('geopos_users','geopos_employees.id=geopos_users.id');
//        $this->db->where('mk_chat.auth_id',$this->aauth->get_user()->id);
//        $this->db->group_by('mk_chat.user_id');
//        $query = $this->db->get();
//        return $query->result();

        $query = $this->db->query("SELECT auth_id as user_id,geopos_employees.name,geopos_users.picture 

FROM mk_chat  
    INNER JOIN geopos_employees ON mk_chat.auth_id=geopos_employees.id
    INNER JOIN geopos_users ON geopos_employees.id=geopos_users.id  Where mk_chat.user_id=$aut_id GROUP BY mk_chat.auth_id

UNION 
SELECT user_id,geopos_employees.name,geopos_users.picture 
FROM mk_chat
INNER JOIN geopos_employees ON mk_chat.user_id=geopos_employees.id
INNER JOIN geopos_users ON geopos_employees.id=geopos_users.id
Where mk_chat.auth_id=$aut_id GROUP BY mk_chat.user_id
")->result();
        return $query;


    }

    public function user_ids_visable(){

        $this->db->select('user_id,geopos_employees.name,geopos_users.picture,mk_chat.*');
        $this->db->from('mk_chat');
        $this->db->join('geopos_employees','mk_chat.auth_id=geopos_employees.id');
        $this->db->join('geopos_users','geopos_employees.id=geopos_users.id');
        $this->db->where('mk_chat.user_id',$this->aauth->get_user()->id);

        $this->db->where('mk_chat.visable',0);
        $query = $this->db->get();
        return $query->result();
    }

    public function add_message(){
        date_default_timezone_set('Asia/Baku');
        $user_id = $this->input->post('to_id');
        $message = $this->input->post('text');
        $auth_id = $this->aauth->get_user()->id;
        $time  = $this->db->query("SELECT CURTIME() as times")->row()->times;

        $data = array(
            'user_id' => $user_id,
            'message' => $message,
            'auth_id' => $auth_id,
            'times' => $time
        );
        if ($this->db->insert('mk_chat', $data)) {

            return [
                'status'=>1
            ];
        }
        else {
            return [
                'status'=>0
            ];
        }

    }
}