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

class Locations Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(14)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->load->library("Common");
         $this->load->model('locations_model', 'locations');
    }

    public function index()
    {

        $head['title'] = "Firmalar";
        $data['locations'] = $this->locations->locations_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('locations/index', $data);
        $this->load->view('fixed/footer');
    }


    public function view()
    {
        $data['cat'] = $this->products_cat->category_stock();
        $head['title'] = "View Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category_view', $data);
        $this->load->view('fixed/footer');
    }


    public function create()
    {
        if ($this->input->post()) {
            $name = $this->input->post('name',true);
            $address = $this->input->post('address',true);
            $city = $this->input->post('city',true);
            $region = $this->input->post('region',true);
            $country = $this->input->post('country',true);
            $postbox = $this->input->post('postbox',true);
            $phone = $this->input->post('phone',true);
            $email = $this->input->post('email',true);
            $taxid = $this->input->post('taxid',true);
            $image = $this->input->post('image',true);
            $cur_id = $this->input->post('cur_id',true);
            $ac_id = $this->input->post('account',true);
              $wid = $this->input->post('wid');
            $this->locations->create($name, $address, $city, $region, $country, $postbox, $phone, $email, $taxid, $image, $cur_id,$ac_id,$wid);
        } else {


            $head['title'] = "Yeni Şirket";
            $data['currency'] = $this->locations->currencies();
            $data['warehouse'] = $this->locations->warehouses();
            $data['accounts'] = $this->locations->accountslist();
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('locations/create', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function edit()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $name = $this->input->post('name',true);
            $address = $this->input->post('address',true);
            $city = $this->input->post('city',true);
            $region = $this->input->post('region',true);
            $country = $this->input->post('country',true);
            $postbox = $this->input->post('postbox',true);
            $phone = $this->input->post('phone',true);
            $email = $this->input->post('email',true);
            $taxid = $this->input->post('taxid',true);
            $image = $this->input->post('image',true);
            $cur_id = $this->input->post('cur_id',true);
            $ac_id = $this->input->post('account',true);
              $wid = $this->input->post('wid');
            $this->locations->edit($id, $name, $address, $city, $region, $country, $postbox, $phone, $email, $taxid, $image, $cur_id,$ac_id,$wid);
        } else {


            $head['title'] = "Şirketi Düzenle";
            $head['usernm'] = $this->aauth->get_user()->username;
            $data = $this->locations->view($this->input->get('id'));
            $data['currency'] = $this->locations->currencies();
            $data['accounts'] = $this->locations->accountslist();
             $data['warehouse'] = $this->locations->warehouses();
            $data['online_pay'] = $this->locations->online_pay_settings($this->input->get('id'));
            $this->load->view('fixed/header', $head);
            $this->load->view('locations/edit', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function delete_i()
    {
        $id = $this->input->post('deleteid');

        if ($id) {

            $this->db->delete('geopos_locations', array('id' => $id));


            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function load_list()
    {
        $list = $this->promo->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $promo) {
            $no++;
            switch ($promo->active) {
                case 0 :
                    $promo_status = '<span class="st-paid">' . $this->lang->line('Active') . '</a>';
                    break;
                case 1 :
                    $promo_status = '<span class="st-partial">' . $this->lang->line('Used') . '</a>';
                    break;
                case 2 :
                    $promo_status = '<span class="st-due">' . $this->lang->line('Expired') . '</a>';
                    break;
            }
            $row = array();
            $row[] = $no;
            $row[] = $promo->code;
            $row[] = $promo->amount;
            $row[] = $promo->valid;
            $row[] = $promo_status;
            $row[] = $promo->available . ' (' . $promo->qty . ')';
            $row[] = '<a href="#" class="btn btn-primary btn-sm rounded set-task" data-id="' . $promo->id . '" data-stat="0"> SET </a> <a href="#" data-object-id="' . $promo->id . '" class="btn btn-danger btn-sm delete-object"><span class="icon-bin"></span></a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->promo->count_all(),
            "recordsFiltered" => $this->promo->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function promo_stats()
    {

        $this->promo->promo_stats();


    }

    public function set_status()
    {
        $id = $this->input->post('tid');
        $stat = $this->input->post('stat');
        $this->promo->set_status($id, $stat);
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED'), 'pstatus' => 'Success'));


    }

    public function file_handling()
    {
        if ($this->input->get('op')) {
            $name = $this->input->get('name');
            if ($this->products->meta_delete($name)) {
                echo json_encode(array('status' => 'Success'));
            }
        } else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/company/', 'upload_url' => base_url() . 'userfile/company/'
            ));


        }


    }

    public function set_firma(){
        $firma_id = $this->input->post('firma_id');
        $this->session->set_userdata('set_firma_id', $firma_id);
        if(true){
            echo json_encode(array('status' => 200, 'message' =>'Başarılı'));

        }
        else {
            echo json_encode(array('status' => 410, 'message' =>'Hata Aldınız'));
        }
    }
    public function set_firma_onay(){

        $user_id = $this->input->post('user_id');
        $tip = $this->input->post('tip');
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $rowss =  $this->db->query('SELECT * FROM geopos_users WHERE id='.$user_id)->row();

        $data = array(
            'id' => $user_id,
            'username' => $rows->username,
            'email' => $rowss->email,
            's_role' => 'r_'.$rowss->roleid,
            'loggedin' => TRUE
        );

        $href='/dashboard';
        if($tip=='maas'){
            $href='/reports/maas_onayi';
        }
        $firma_id = $this->input->post('firma_id');

        $this->session->set_userdata('set_firma_id', $firma_id);



        $this->session->set_userdata($data);
        if(true){
            echo json_encode(array('status' => 200, 'message' =>'Başarılı','href'=>$href));

        }
        else {
            echo json_encode(array('status' => 410, 'message' =>'Hata Aldınız'));
        }
    }

    public function test(){
        $personel_id = $this->session->userdata('set_firma_id'); //257
        echo $personel_id;
    }
    public function othercompany(){
        $data=[];
        $parent_locations_kontrol = parent_locations_kontrol();
        if($parent_locations_kontrol){
            $totals=0;
            foreach ($parent_locations_kontrol as $items){

                $this->db->select('new_bordro.*');
                $this->db->from('salary_onay_new');
                $this->db->join('new_bordro_item','salary_onay_new.bordro_item_id = new_bordro_item.id');
                $this->db->join('new_bordro','new_bordro_item.bordro_id = new_bordro.id');
                $this->db->where('new_bordro_item.loc =', $items['firma_id']); //2019-11-23 14:28:57
                $this->db->where('salary_onay_new.staff', 1);
                $this->db->where('salary_onay_new.user_id', $items['user_id']);
                $this->db->where_not_in('new_bordro_item.status',[4,3]);
                $query = $this->db->get();
                $count = $kasa_count =  $query->num_rows();


                $totals+=$count;

                $data[]=[
                  'id_name'=>'maas_onayi_'.$items['firma_id'],
                  'count'=>$count,
                ];
            }
            echo json_encode(array('status' => 200, 'items' =>$data,'totals'=>$totals));

        }
        else {
            echo json_encode(array('status' => 410, 'message' =>'Hata Aldınız'));
        }
    }


}