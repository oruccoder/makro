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





class Azpetrol_model extends CI_Model
{


    var $column_order = array('azpetrol_bakiye.created_at', 'azpetrol_bakiye.user_id', 'azpetrol_bakiye.tip', 'azpetrol_bakiye.amounth','azpetrol_bakiye.desc');

    var $column_search = array('azpetrol_bakiye.created_at', 'geopos_employees.name', 'azpetrol_bakiye.tip', 'azpetrol_bakiye.amounth','azpetrol_bakiye.desc');
    var $column_search_kart = array('azpetrol_bakiye.created_at', 'azpetrol_cart.cart_number','geopos_employees.name', 'azpetrol_bakiye.tip', 'azpetrol_bakiye.amounth','azpetrol_bakiye.desc');
    var $column_order_cart = array('azpetrol_bakiye.created_at', 'azpetrol_cart.cart_number','geopos_employees.name', 'azpetrol_bakiye.tip', 'azpetrol_bakiye.amounth','azpetrol_bakiye.desc');



    var $column_search_arac = array('azpetrol_bakiye.created_at', 'araclar.plaka','geopos_employees.name', 'azpetrol_bakiye.tip', 'azpetrol_bakiye.amounth','azpetrol_bakiye.desc');
    var $column_order_arac = array('azpetrol_bakiye.created_at', 'araclar.plaka','geopos_employees.name', 'azpetrol_bakiye.tip', 'azpetrol_bakiye.amounth','azpetrol_bakiye.desc');



    var $order = array('id' => 'DESC');


    public function __construct()
    {
        parent::__construct();

    }

    public function create_save(){
        $amounth = $this->input->post('amounth');
        $desc = $this->input->post('desc');
        $data = array(
            'invoice_id'=>0,
            'amounth'=>$amounth,
            'tip'=>1,
            'desc'=>$desc,
            'user_id' => $this->aauth->get_user()->id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        $index=0;
        if ($this->db->insert('azpetrol_bakiye', $data)) {
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Bakiye Eklendi',
            ];
        }
        else{
            return [
                'status'=>0,
                'message'=>'Bakiye Eklenirken Hata Aldınız',
            ];
        }
    }

    public function update_balanca_cart(){
        $amounth = $this->input->post('amounth');
        $desc = $this->input->post('desc');
        $cart_id = $this->input->post('cart_id');
        $tip = $this->input->post('tip');
        $data = array(
            'invoice_id'=>0,
            'amounth'=>$amounth,
            'kart_id'=>$cart_id,
            'tip'=>$tip,
            'desc'=>$desc,
            'user_id' => $this->aauth->get_user()->id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        $index=0;
        if ($this->db->insert('azpetrol_bakiye', $data)) {
            $new_tip = 0;
            if($tip==0){
                $new_tip=1;
            }
            if($tip==1){
                $data = array(
                    'invoice_id'=>0,
                    'amounth'=>$amounth,
                    'tip'=>$new_tip,
                    'desc'=>$desc,
                    'user_id' => $this->aauth->get_user()->id,
                    'loc' =>  $this->session->userdata('set_firma_id'),
                );
                $this->db->insert('azpetrol_bakiye', $data);
            }



            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Bakiye Güncellendi',
            ];
        }
        else{
            return [
                'status'=>0,
                'message'=>'Bakiye Eklenirken Hata Aldınız',
            ];
        }
    }

    public function create_save_cart(){
        $card_number = $this->input->post('card_number');
        $car_id = $this->input->post('car_id');
        $desc = $this->input->post('desc');

        $data = array(
            'cart_number'=>$card_number,
            'car_id'=>$car_id,
            'desc'=>$desc,
            'user_id' => $this->aauth->get_user()->id,
            'loc' =>  $this->session->userdata('set_firma_id'),
        );
        $index=0;
        if ($this->db->insert('azpetrol_cart', $data)) {

            $last_id = $this->db->insert_id();
            if($car_id > 0){
                $car_update = array(
                    'az_cart_id' => $last_id,
                );
                $this->db->set($car_update);
                $this->db->where('id', $car_id);
                $this->db->update('araclar');

                }
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Kart Eklendi',
            ];
        }
        else{
            return [
                'status'=>0,
                'message'=>'Kart Eklenirken Hata Aldınız',
            ];
        }
    }

    public function update_car_cart(){
        $cart_id = $this->input->post('cart_id');
        $car_id = $this->input->post('car_id');
        $car_update = array(
            'az_cart_id' => $cart_id,
        );
        $this->db->set($car_update);
        $this->db->where('id', $car_id);
        if ($this->db->update('araclar')) {

            $cart_update = array(
                'car_id' => $car_id,
            );
            $this->db->set($cart_update);
            $this->db->where('id', $cart_id);
            $this->db->update('azpetrol_cart');
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Kart Eklendi',
            ];
        }
        else{
            return [
                'status'=>0,
                'message'=>'Kart Eklenirken Hata Aldınız',
            ];
        }
    }

    public function ajax_list_bakiye(){
        $this->_ajax_list_bakiye();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _ajax_list_bakiye()
    {

        $tip  = $this->input->post('tip');


        $this->db->select('azpetrol_bakiye.*,geopos_employees.name as pers_name,');
        $this->db->from('azpetrol_bakiye');
        $this->db->join('geopos_employees','azpetrol_bakiye.user_id=geopos_employees.id');
        $i = 0;
        $this->db->where('azpetrol_bakiye.kart_id',0);
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
            $this->db->order_by('`azpetrol_bakiye`.`id` DESC');
        }

    }
    public function count_filtered_bakiye()
    {
        $this->_ajax_list_bakiye();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_bakiye()
    {
        $this->_ajax_list_bakiye();
        return $this->db->count_all_results();
    }


    public function ajax_list_kart_bakiye(){
        $this->_ajax_list_kart_bakiye();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _ajax_list_kart_bakiye()
    {

        $tip  = $this->input->post('tip');


        $this->db->select('azpetrol_bakiye.*,geopos_employees.name as pers_name,azpetrol_cart.cart_number');
        $this->db->from('azpetrol_bakiye');
        $this->db->join('geopos_employees','azpetrol_bakiye.user_id=geopos_employees.id');
        $this->db->join('azpetrol_cart','azpetrol_bakiye.kart_id=azpetrol_cart.id');
        $i = 0;
        $this->db->where('azpetrol_bakiye.kart_id!=',0);
        foreach ($this->column_search_kart as $item) // loop column
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

                if (count($this->column_search_kart) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }


        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order_cart[$search['0']['column']], $search['0']['dir']);

        }
        else {
            $this->db->order_by('`azpetrol_bakiye`.`id` DESC');
        }


    }
    public function count_filtered_bakiye_kart()
    {
        $this->_ajax_list_kart_bakiye();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_bakiye_kart()
    {
        $this->_ajax_list_kart_bakiye();
        return $this->db->count_all_results();
    }

    public function ajax_list_kart_arac(){
        $this->_ajax_list_kart_arac();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _ajax_list_kart_arac()
    {

        $this->db->select('araclar.*,geopos_employees.name as pers_name,azpetrol_cart.cart_number,azpetrol_bakiye.tip,azpetrol_bakiye.amounth,azpetrol_bakiye.desc');
        $this->db->from('araclar');
        $this->db->join('azpetrol_cart','araclar.az_cart_id=azpetrol_cart.id');
        $this->db->join('azpetrol_bakiye','azpetrol_bakiye.kart_id=azpetrol_cart.id');
        $this->db->join('geopos_employees','azpetrol_bakiye.user_id=geopos_employees.id');
        $i = 0;
        foreach ($this->column_search_arac as $item) // loop column
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

                if (count($this->column_search_arac) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }


        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order_arac[$search['0']['column']], $search['0']['dir']);

        }
        else {
            $this->db->order_by('`azpetrol_bakiye`.`id` DESC');
        }


    }
    public function count_filtered_arac()
    {
        $this->_ajax_list_kart_arac();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_arac()
    {
        $this->_ajax_list_kart_arac();
        return $this->db->count_all_results();
    }

}