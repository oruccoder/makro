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


class Projectsnew Extends CI_Controller

{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('projectsnew_model', 'projects');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }
    public function index()
    {
        if (!$this->aauth->premission(4)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Proje Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('projectsnew/index');
        $this->load->view('fixed/footer');
    }
    public function list()

    {
        $list = $this->projects->list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $project) {

            $no++;
            $text=$project->name;
            $name = '<a class="btn btn-outline-info" href="' . base_url() . 'projectsnew/view/' . $project->id . '">' .$text  . '</a>';
            $row = array();
            $row[] = $no;
            $row[] = $project->code;
            $row[] = $name;
            $row[] = dateformat($project->sdate);
            $row[] = $project->customer;
            $row[] = project_status($project->status);
            $row[] = '<a href="' . base_url() . 'projectsnew/view/' . $project->id . '" class="btn btn-primary btn-sm rounded" data-id="' . $project->id . '" data-stat="0"><i class="fa fa-eye"></i></a>
        <a class="btn btn-info btn-sm edit_proje" type="button" proje_id="' . $project->id . '"> <i class="icon-pencil"></i> </a>
        <button class="btn btn-warning btn-sm maas_sort" type="button" proje_id="' . $project->id . '"> <i class="fa fa-filter"></i> </button>
        &nbsp;';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->projects->list_count_all(),
            "recordsFiltered" => $this->projects->list_filtered(),
            "data" => $data,

        );

        echo json_encode($output);

    }
    public function view($id)
    {
        $details = $this->projects->details($id);
        $data['details']=$details;
        if (!$this->aauth->premission(4)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $data['new_maliyet']=0;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $details->name;
        $this->load->view('fixed/header', $head);
        $this->load->view('projectsnew/view',$data);
        $this->load->view('fixed/footer');
    }

    public function bolumler($id)
    {
        $details = $this->projects->details($id);
        $data['details']=$details;
        if (!$this->aauth->premission(4)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $data['new_maliyet']=0;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $details->name;
        $this->load->view('fixed/header', $head);
        $this->load->view('projectsnew/bolumler',$data);
        $this->load->view('fixed/footer');
    }

    public function asamalar_list_select()
    {
        $bolum_id=$this->input->post('bolum_id');
        $proje_id=$this->input->post('proje_id');
        $invoice_list=$this->db->query("SELECT * FROM geopos_milestones WHERE pid=$proje_id and bolum_id=$bolum_id")->result();
        $data=array();


            foreach ($invoice_list as $item) :

                $asama_id = $item->default_proje_asama_id;
                $asama_details = $this->db->query("SELECT * FROM project_asama Where id = $asama_id")->row();

                $id = $asama_id;
                $title = $asama_details->name;
                $new_title = _ust_asama_kontrol($id).$title;
                $data[]=array(
                    'name'=>$new_title,
                    'id'=>$id
                );

            endforeach;


        echo json_encode($data);
    }

    public function bolumler_list_select()
    {

        $proje_id=$this->input->post('proje_id');
        $invoice_list=$this->db->query("SELECT * FROM geopos_project_bolum WHERE pid=$proje_id")->result();
        $data=array();
            foreach ($invoice_list as $item) :
                $data[]=array(
                    'name'=>$item->name,
                    'id'=>$item->id
                );

            endforeach;


        echo json_encode($data);
    }
}