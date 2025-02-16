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

class Clientgroup extends CI_Controller
{
    public function __construct()
    {  
        parent::__construct();
        $this->load->model('clientgroup_model', 'clientgroup');
        $this->load->model('customers_model', 'customers');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(31)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
    }

    //groups
    public function index()
    {
        if (!$this->aauth->premission(31)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $data['group'] = $this->customers->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Cari Grubu';
        $this->load->view('fixed/header', $head);
        $this->load->view('groups/groups', $data);
        $this->load->view('fixed/footer');
    }

    //view
    public function groupview()
    {
        if (!$this->aauth->premission(31)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $id = $this->input->get('id');
        $data['group'] = $this->clientgroup->details($id);
        $head['title'] = 'Grupları Görüntüle';
        $this->load->view('fixed/header', $head);
        $this->load->view('groups/groupview', $data);
        $this->load->view('fixed/footer');
    }

    //datatable
    public function grouplist()

    {
        $base = base_url() . 'customers/';
        $id = $this->input->get('id');
        $list = $this->customers->get_datatables($id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $customers) {
            $no++;

            $row = array();
            $row[] = $no;
            $row[] = '<span class="avatar-sm align-baseline"><img class="rounded-circle"  src="' . base_url() . 'userfiles/customers/thumbnail/' . $customers->picture . '" ></span> &nbsp;<a href="customers/view?id=' . $customers->id . '">' . $customers->name . '</a>';
            $row[] = $customers->address . ',' . $customers->city . ',' . $customers->country;
            $row[] = $customers->email;
            $row[] = $customers->phone;
            $row[] = '<a href="' . $base . 'edit?id=' . $customers->id . '" class="btn btn-success btn-sm"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="icon-bin"></span></a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->count_all($id),
            "recordsFiltered" => $this->customers->count_filtered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function create()
    {
        if (!$this->aauth->premission(31)->write) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Yeni Grup';
        $this->load->view('fixed/header', $head);
        $this->load->view('groups/add');
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        $group_name = $this->input->post('group_name',true);
        $group_desc = $this->input->post('group_desc',true);

        if ($group_name) {
            $this->clientgroup->add($group_name, $group_desc);
        }
    }

    public function editgroup()
    {
        if (!$this->aauth->premission(31)->update) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $gid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('geopos_customer_type');
        $this->db->where('id', $gid);
        $query = $this->db->get();
        $data['group'] = $query->row_array();

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Düzenle';
        $this->load->view('fixed/header', $head);
        $this->load->view('groups/groupedit', $data);
        $this->load->view('fixed/footer');

    }

    public function editgroupupdate()
    {
        $gid = $this->input->post('gid',true);
        $group_name = $this->input->post('group_name',true);
        $group_desc = $this->input->post('group_desc',true);
        if ($gid) {
            $this->clientgroup->editgroupupdate($gid, $group_name, $group_desc);
        }
    }

    public function delete_i()
    {
        if (!$this->aauth->premission(1)->delete) {


            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));

        }

        else {
            $id = $this->input->post('deleteid');
            if ($id != 1) {
                $this->db->delete('geopos_customer_type', array('id' => $id));
                $this->db->set(array('musteri_tipi' => 1));
                $this->db->where('musteri_tipi', $id);
                $this->db->update('geopos_customers');
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
            } else if ($id == 1) {
                echo json_encode(array('status' => 'Error', 'message' => 'You can not delete the default group!'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        }

    }

    function sendGroup()
    {
        $id = $this->input->post('musteri_tipi');
        $subject = $this->input->post('subject',true);
        $message = $this->input->post('text');
        $attachmenttrue = false;
        $attachment = '';
        $recipients = $this->clientgroup->recipients($id);
        $this->load->model('communication_model');
        $this->communication_model->group_email($recipients, $subject, $message, $attachmenttrue, $attachment);
    }
}