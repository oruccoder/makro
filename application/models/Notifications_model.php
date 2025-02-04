<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications_model extends CI_Model{
    public function add_notification($user_id, $message){
        $data = array(
          "user_id" => $user_id,
          "message" => $message,  
          "status" => 'pending'
        );
        $this->db->insert('notifications', $data);
    }

    public function get_notifications() {
        $user_id = $this->aauth->get_user()->id;
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 0); 
        $query = $this->db->get('notifications');
        echo json_encode($query->result());
    }
    

    public function mark_as_read($id){
        $this->db->where('id', $id);
        $this->db->update('notifications', array('status' => "read"));
    }

    public function get_pending_notifications_count() {
        $this->db->where('status', 'pending');
        return $this->db->count_all_results('notifications'); 
    }
}