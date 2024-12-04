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



class Chat Extends CI_Controller

{
    public function __construct()

    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('Chat_model', 'model');
        $this->load->model('tools_model', 'tools');
        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }
    }

    public function index(){
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Chat Yönetimi';
        $data['user_ids']=$this->model->user_ids();
        $this->load->view('fixed/header', $head);
        $this->load->view('chat/index',$data);
        $this->load->view('fixed/footer');
    }

    public function add_message(){

        $this->db->trans_start();
        $result = $this->model->add_message();
        if($result['status']){

            echo json_encode(array('status' => 200));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }

    public function messages_kontrol(){
        $details = $this->input->post('details');



        $user_id_ = $this->aauth->get_user()->id;

        $count = $this->db->query("SELECT COUNT(id) as sayi,auth_id FROM mk_chat Where user_id=$user_id_ and visable=0 GROUP BY auth_id Order BY id ASC")->result();


        $result=$this->model->user_ids_visable();



        if($result){
            echo json_encode(array('status' => 200, 'all_messages' =>$result,'auth_id'=>$user_id_,'count'=>$count));
        }
        else {
            echo json_encode(array('status' => 410,'count'=>$count));
        }

    }

    public function new_message_kontrol(){
        $uyari = $this->input->post('durum');
        $user_id_ = $this->aauth->get_user()->id;


        $count_sya = $this->db->query("SELECT * FROM mk_chat Where user_id=$user_id_ and visable=0 Order BY id ASC")->num_rows();


        if($uyari==0){
            $count = $this->db->query("SELECT * FROM mk_chat Where user_id=$user_id_ and visable=0 and uyari=0")->num_rows();
            if($count){
                echo json_encode(array('status' => 200,'count'=>$count_sya));
            }
            else {
                echo json_encode(array('status' => 410,'count'=>$count_sya));
            }
        }
        else {
            $this->db->set('uyari', 1);
            $this->db->where('user_id', $user_id_);
            $this->db->where('visable', 0);
            if($this->db->update('mk_chat')){
                echo json_encode(array('status' => 410,'count'=>$count_sya));
            }
        }


    }

    public function count_control(){
        $user_id_ = $this->aauth->get_user()->id;
        $user_id = $this->input->post('user_id');

        $this->db->set('visable', 1);
        $this->db->where('user_id', $user_id_);
        $this->db->where('auth_id', $user_id);
        $this->db->where('visable', 0);
        if($this->db->update('mk_chat')){
            echo json_encode(array('status' => 200, 'count'=>0));
        }
        else {
            $count = $this->db->query("SELECT COUNT(id) as sayi,auth_id FROM mk_chat Where user_id=$user_id_ and visable=0 and auth_id=$user_id GROUP BY auth_id Order BY id ASC")->num_rows();
            echo json_encode(array('status' => 410, 'count'=>$count));
        }

    }
}
