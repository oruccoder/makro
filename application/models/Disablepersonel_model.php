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





class Disablepersonel_model extends CI_Model
{
    var $table_news = 'geopos_employees ';

    var $column_search = array('geopos_employees.name', 'geopos_role.name', 'geopos_projects.name');

    var $column_order = array(null,'geopos_employees.id','geopos_employees.name', 'geopos_role.name', 'geopos_projects.name');

    var $order = array('geopos_employees.id' => 'DESC');


    public function __construct()
    {
        parent::__construct();
        $this->load->model('communication_model');

    }

    public function list()

    {
        $this->_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _list()

    {

        $this->db->select('geopos_employees.*,geopos_users.banned,geopos_users.roleid ,geopos_users.loc,geopos_projects.name as proje_name,geopos_role.name as role_name');
        $this->db->from('geopos_employees');
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id');
        $this->db->join('personel_salary', 'personel_salary.personel_id = geopos_users.id','left');
        $this->db->join('geopos_projects', 'personel_salary.proje_id = geopos_projects.id','left');
        $this->db->join('geopos_role', 'geopos_users.roleid = geopos_role.role_id','left');
        $this->db->where('geopos_users.banned', 1);
        $this->db->where('personel_salary.status', 1);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_users.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
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
        } else {
            $this->db->order_by('`geopos_employees`.`id` DESC');
        }


    }


    public function count_filtered()
    {
        $this->_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_list();
        return $this->db->count_all_results();
    }

    public function create_save(){
        $name = $this->input->post('name');
        $username = str_replace(" ","",$name);
        $email = $this->input->post('email');
        $roleid = $this->input->post('roleid');
        $proje_id = $this->input->post('proje_id');
        $password = $this->input->post('password');
        $salary_type = $this->input->post('salary_type');
        $salary = $this->input->post('salary');
        $bank_salary = $this->input->post('bank_salary');
        $net_salary = $this->input->post('net_salary');
        $salary_day = $this->input->post('salary_day');

        $a = $this->aauth->create_user($email, $password, $username);
        if ((string)$this->aauth->get_user($a)->id != $this->aauth->get_user()->id) {
            $user_id = (string)$this->aauth->get_user($a)->id;
            $data_salary=
                [
                    'salary'=>$salary,
                    'bank_salary'=>$bank_salary,
                    'salary_day'=>$salary_day,
                    'salary_type'=>$salary_type,
                    'net_salary'=>$net_salary,
                    'proje_id'=>$proje_id,
                    'staff_id'=>$this->aauth->get_user()->id,
                    'personel_id'=>$user_id,
                ];
            $this->db->insert('personel_salary', $data_salary);
            $data = array(
                'id' => $user_id,
                'username' => $username,
                'name' => $name,
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'region' => $this->input->post('region'),
                'country' => $this->input->post('country'),
                'ise_baslangic_tarihi' => $this->input->post('ise_baslangic_tarihi'),
                'phone' => $this->input->post('phone'),
                'calisma_sekli' => $this->input->post('calisma_sekli'),
                'vatandaslik' => $this->input->post('vatandaslik'),
                'cinsiyet' => $this->input->post('cinsiyet'),
                'medeni_durumu' => $this->input->post('medeni_durumu'),
                'fin_no' => $this->input->post('fin_no'),
                'sorumlu_pers_id' => $this->input->post('sorumlu_pers_id'),
            );

            if ($this->db->insert('geopos_employees', $data)) {
                $data1 = array(
                    'roleid' => $roleid,
                    'loc' => 5,
                );
                $this->db->set($data1);
                $this->db->where('id', $user_id);
                $this->db->update('geopos_users');
                $this->aauth->applog("Personel Kartı Oluşturuldu : ".$user_id, $this->aauth->get_user()->username);

                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde Personel Kartı Oluşturuldu'
                ];

            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız'
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Personel Zaten Oluşturulmuş'
            ];
        }


    }

    public function update(){

        $personel_id = $this->input->post('personel_id');
        $user_id = $this->input->post('personel_id');
        $name = $this->input->post('name');
        $username = str_replace(" ","",$name);
        $roleid = $this->input->post('roleid');
        $proje_id = $this->input->post('proje_id');
        $salary_type = $this->input->post('salary_type');
        $salary = $this->input->post('salary');
        $bank_salary = $this->input->post('bank_salary');
        $net_salary = $this->input->post('net_salary');
        $salary_day = $this->input->post('salary_day');
        $data_salary=
            [
                'salary'=>$salary,
                'bank_salary'=>$bank_salary,
                'salary_day'=>$salary_day,
                'salary_type'=>$salary_type,
                'net_salary'=>$net_salary,
                'proje_id'=>$proje_id,
                'staff_id'=>$this->aauth->get_user()->id,
                'personel_id'=>$user_id,
            ];
        $this->db->set($data_salary);
        $this->db->where('personel_id', $user_id);
        $this->db->update('personel_salary', $data_salary);

        $data = array(
            'id' => $user_id,
            'username' => $username,
            'name' => $name,
            'address' => $this->input->post('address'),
            'city' => $this->input->post('city'),
            'region' => $this->input->post('region'),
            'country' => $this->input->post('country'),
            'ise_baslama_tarihi' => $this->input->post('ise_baslangic_tarihi'),
            'phone' => $this->input->post('phone'),
            'calisma_sekli' => $this->input->post('calisma_sekli'),
            'vatandaslik' => $this->input->post('vatandaslik'),
            'cinsiyet' => $this->input->post('cinsiyet'),
            'medeni_durumu' => $this->input->post('medeni_durumu'),
            'fin_no' => $this->input->post('fin_no'),
            'sorumlu_pers_id' => $this->input->post('sorumlu_pers_id'),
        );

        $this->db->set($data);
        $this->db->where('id', $personel_id);
        if ($this->db->update('geopos_employees', $data)) {
            $data1 = array(
                'roleid' => $roleid,
                'loc' => 5,
            );
            $this->db->set($data1);
            $this->db->where('id', $user_id);
            $this->db->update('geopos_users');
            $this->aauth->applog("Personel Kartı Güncellendi : ".$user_id, $this->aauth->get_user()->username);

            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Personel Kartı Oluşturuldu'
            ];

        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }

    }

    public function disable_user() {
        $uid = $this->input->post('personel_id');

        $this->db->select('banned');
        $this->db->from('geopos_users');
        $this->db->where('id', $uid);
        $query = $this->db->get();
        $result = $query->row_array();
        if ($result['banned'] == 0) {
            if($this->aauth->ban_user($uid)){
                return [
                    'status'=>1,
                    'message'=>'Personel Pasifleştirilmiştir'
                ];
            }

        } else {
            $data1 = array(
                'banned' => 0,
            );
            $this->db->set($data1);
            $this->db->where('id', $uid);
            if( $this->db->update('geopos_users')){
                return [
                    'status'=>1,
                    'message'=>'Personel Aktifleştirilmiştir'
                ];
            }
        }

    }

    public function details($id){
        $this->db->select('*');
        $this->db->from('geopos_employees');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function users_details($id){
        $this->db->select('*');
        $this->db->from('geopos_users');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function salary_details($id){
        $this->db->select('*');
        $this->db->from('personel_salary');
        $this->db->where('personel_id',$id);
        $this->db->where('status',1);
        $query = $this->db->get();
        return $query->row();
    }

}