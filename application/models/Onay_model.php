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





class Onay_model extends CI_Model
{
    var $table_news = 'araclar ';

    var $column_order = array('talep_form.code', 'talep_form.desc', 'geopos_employees.name', 'progress_status.name', 'geopos_projects.code', 'talep_form_status.name');

    var $column_search = array('talep_form.code', 'talep_form.desc', 'geopos_employees.name', 'progress_status.name', 'geopos_projects.code', 'talep_form_status.name');


    var $customer_column_order = array('geopos_customers.company','talep_form_customer_new.code', 'talep_form_customer_new.desc', 'geopos_employees.name', 'progress_status.name', 'geopos_projects.code', 'talep_form_status.name');

    var $customer_column_search = array('geopos_customers.company','talep_form_customer_new.code', 'talep_form_customer_new.desc', 'geopos_employees.name', 'progress_status.name', 'geopos_projects.code', 'talep_form_status.name');


    var $personel_column_order = array('geopos_employees.name','talep_form_personel.code', 'talep_form_personel.desc', 'progress_status.name', 'geopos_projects.code', 'talep_form_status.name');

    var $personel_column_search = array('geopos_employees.name','talep_form_personel.code', 'talep_form_personel.desc', 'progress_status.name', 'geopos_projects.code', 'talep_form_status.name');



    var $order = array('id' => 'DESC');

    var $column_report = array('code');




    public function __construct()
    {
        parent::__construct();

    }



    public function get_datatables_query_details_talep_list()

    {
        $this->_get_datatables_query_details_talep_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        //$query=$query->result();
        //echo $this->db->last_query();die();

        return $query->result();

    }

    private function _get_datatables_query_details_talep_list()
    {

            $tip = $this->input->get('tip');

            $auth_id = $this->aauth->get_user()->id;
            $this->db->select('talep_form.*,geopos_employees.name as pers_name,progress_status.name as progress_name,talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.sort_name as st_name');
            $this->db->from('talep_form');
            $this->db->join('geopos_employees','talep_form.talep_eden_user_id=geopos_employees.id');
            $this->db->join('progress_status','talep_form.progress_status_id=progress_status.id');
            $this->db->join('geopos_projects','talep_form.proje_id=geopos_projects.id','LEFT');
            $this->db->join('talep_form_status','talep_form.status=talep_form_status.id');
            if($tip==1){
                $this->db->join('talep_onay_new','talep_form.id=talep_onay_new.talep_id');
            }
            elseif($tip==2  || $tip==107){
                $this->db->join('talep_user_satinalma','talep_form.id=talep_user_satinalma.talep_id');
            }
            elseif($tip==3 || $tip==108){
                $this->db->join('talep_onay_new','talep_form.id=talep_onay_new.talep_id');
            }

            elseif($tip==5 || $tip==109){
                $this->db->join('talep_user_satinalma','talep_form.id=talep_user_satinalma.talep_id');
            }

            elseif($tip==6 || $tip==110){
                $this->db->join('siparis_list_form','talep_form.id=siparis_list_form.talep_id');
            }
            elseif($tip==7 || $tip==111){
                $this->db->join('talep_user_satinalma','talep_form.id=talep_user_satinalma.talep_id');
            }
            elseif($tip==8){
                $this->db->join('geopos_warehouse','talep_form.warehouse_id=geopos_warehouse.id');
            }
            elseif($tip==11){
                $this->db->join('talep_user_satinalma','talep_form.id=talep_user_satinalma.talep_id');
            }
            elseif($tip==99){
                $this->db->join('talep_form_avans','talep_form.id=talep_form_avans.talep_id');
                $this->db->join('talep_form_avans_sort','talep_form_avans.id=talep_form_avans_sort.talep_form_avans_id');
            }

            elseif($tip==100){
                $this->db->join('talep_form_avans','talep_form.id=talep_form_avans.talep_id');
                $this->db->join('talep_form_avans_sort','talep_form_avans.id=talep_form_avans_sort.talep_form_avans_id');
            }
            elseif($tip==101){
                $this->db->join('talep_form_avans','talep_form.id=talep_form_avans.talep_id');
                $this->db->join('talep_form_avans_sort','talep_form_avans.id=talep_form_avans_sort.talep_form_avans_id');
            }
            elseif($tip==102){
                $this->db->join('talep_user_satinalma','talep_form.id=talep_user_satinalma.talep_id');
            }
            elseif($tip==103){
                $this->db->join('geopos_warehouse','talep_form.transfer_warehouse_id=geopos_warehouse.id');
            }
            elseif($tip==104){
                $this->db->join('talep_onay_new','talep_form.id=talep_onay_new.talep_id');
            }
            elseif($tip==105 || $tip==106){
                $this->db->join('talep_onay_new','talep_form.id=talep_onay_new.talep_id');
            }

            $this->db->where('talep_form.loc', $this->session->userdata('set_firma_id'));
            if($tip==1){
                $this->db->where("talep_onay_new.type",1);
                $this->db->where("talep_onay_new.staff",1);
                $this->db->where("talep_form.status",1);
                $this->db->where("talep_onay_new.user_id",$auth_id);
            }
            elseif($tip==2 || $tip==107){

                $this->db->where("talep_form.status IN (2,3)");
                $this->db->where("talep_user_satinalma.status IN(1,2)");
                $this->db->where("talep_user_satinalma.user_id",$auth_id);
            }

            elseif($tip==5  || $tip==109){
                $this->db->where("talep_form.status",5);
                $this->db->where("talep_user_satinalma.user_id",$auth_id);
            }

            elseif($tip==7 || $tip==111){
                $this->db->where("talep_form.status",6);
                $this->db->where("talep_user_satinalma.user_id",$auth_id);
            }
            elseif($tip==3 || $tip==108){
                $this->db->where("talep_onay_new.type",2);
                $this->db->where("talep_form.status",4);
                $this->db->where("talep_onay_new.staff",1);
                $this->db->where("talep_onay_new.user_id",$auth_id);
            }
             elseif($tip==6 || $tip==110){
                $this->db->where("siparis_list_form.staf_status",1);
                $this->db->where("siparis_list_form.deleted_at is NULL");
                $this->db->where("siparis_list_form.staff_id",$auth_id);
                 $this->db->where("talep_form.status",5);
            }
            elseif($tip==8){
                $this->db->where("talep_form.status",7);
                $this->db->where("geopos_warehouse.pers_id",$auth_id);
            }

            elseif($tip==112){
                $this->db->where("talep_form.status",7);
                $this->db->where("talep_form.warehouse_id",$auth_id);
            }

            elseif($tip==99){
                $this->db->where("talep_form_avans.status_id",1);
                $this->db->where("talep_form_avans_sort.staff_status",0);
                $this->db->where("talep_form_avans_sort.staff",1);
                $this->db->where("talep_form_avans_sort.staff_id",$auth_id);
                $this->db->where("talep_form.status",18);
            }

            elseif($tip==100){
                $this->db->where("talep_form.status",20);
                $this->db->where("talep_form_avans.type",2);
                $this->db->where("talep_form_avans_sort.staff_status",0);
                $this->db->where("talep_form_avans_sort.staff_id",$auth_id);
            }
            elseif($tip==101){
                $this->db->where("talep_form_avans_sort.staff_status",4);
                $this->db->where("talep_form_avans_sort.type",2);
                $this->db->where("talep_form_avans_sort.muhasebe_id",$auth_id);
                $this->db->where("talep_form.status",12);
            }
            elseif($tip==9 || $tip==113){


                if($auth_id==39){
                    $this->db->where("talep_form.status",8);
//                    $this->db->where("geopos_projects.muhasebe_muduru_id",$auth_id);
                }
                else {
                    $this->db->where("talep_form.status",0);
                }

            }

            elseif($tip==11){
                $this->db->where_in("talep_form.status",[11,19]);
                $this->db->where("talep_user_satinalma.user_id",$auth_id);
            }
            elseif($tip==102){
                $this->db->where("talep_form.status",3);
                $this->db->where("talep_user_satinalma.user_id",$auth_id);
            }
            elseif($tip==103){
                $this->db->where("talep_form.status",8);
                $this->db->where("talep_form.transfer_bildirim",1);
                $this->db->where("talep_form.transfer_status",1);
                $this->db->where("geopos_warehouse.pers_id",$auth_id);
            }
            elseif($tip==104){
                $this->db->where("talep_onay_new.type",3);
                $this->db->where("talep_onay_new.staff",1);
                $this->db->where("talep_form.status",17);
                $this->db->where("talep_onay_new.user_id",$auth_id);
            }

            //hizet
            elseif($tip==105){
                $this->db->where("talep_onay_new.type",3);
                $this->db->where("talep_onay_new.staff",1);
                $this->db->where("talep_form.status",17);
                $this->db->where("talep_onay_new.user_id",$auth_id);
                $this->db->where("talep_form.talep_type",2);
            }
            elseif($tip==106){

                $this->db->where("talep_onay_new.type",1);
                $this->db->where("talep_onay_new.staff",1);
                $this->db->where("talep_onay_new.user_id",$auth_id);
                $this->db->where("talep_form.status",1);
                $this->db->where("talep_form.talep_type",2);
            }


            $talep_type_not = [105,106,107,108,109,110,111,112,113];

            if(!in_array($tip,$talep_type_not)){
                $this->db->where("talep_form.talep_type",1);
            }
            else {
                $this->db->where("talep_form.talep_type",2);
            }



            $i = 0;

            foreach ($this->column_search as $item) // loop column
            {
                if($_POST){
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


            }
            $this->db->order_by('`talep_form`.`id` DESC');
            if($tip==6 || $tip==110){
                $this->db->group_by('`siparis_list_form`.`talep_id`');
            }
            else if($tip==99 ||$tip==100 || $tip==101){
                $this->db->group_by('`talep_form_avans`.`talep_id`');
            }




    }


    public function count_filtered_talep()
    {
        $this->_get_datatables_query_details_talep_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_talep()
    {
        $this->_get_datatables_query_details_talep_list();
        return $this->db->count_all_results();
    }


    public function lojistik_list()

    {
        $this->_lojistik_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        //$query=$query->result();
        //echo $this->db->last_query();die();

        return $query->result();

    }

    private function _lojistik_list()

    {

        $tip = $this->input->post('tip');
        $status = $this->input->post('status');

        $auth_id = $this->aauth->get_user()->id;

        $this->db->select('talep_form_nakliye_products.*
        ,geopos_employees.name as pers_name,
        talep_form_status.color as color,
        geopos_projects.code as proje_name,
        talep_form_status.name as st_name,
        geopos_customers.company,
        araclar.name as arac_name,
        talep_form_nakliye.code,
        talep_form_nakliye.id as talep_id
        
        ');
        $this->db->from('talep_form_nakliye_products');
        $this->db->join('talep_form_nakliye','talep_form_nakliye.id=talep_form_nakliye_products.form_id');
        $this->db->join('araclar','talep_form_nakliye_products.arac_id=araclar.id','LEFT');
        $this->db->join('geopos_employees','talep_form_nakliye.talep_eden_user_id=geopos_employees.id');
        $this->db->join('geopos_customers','talep_form_nakliye_products.cari_id=geopos_customers.id');
        $this->db->join('geopos_projects','talep_form_nakliye.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_nakliye_products.status=talep_form_status.id');
        $this->db->where('talep_form_nakliye_products.status',$status);
        $this->db->where('talep_form_nakliye.status!=9',);


        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_nakliye_products.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }


        $i = 0;

        foreach ($this->customer_column_search as $item) // loop column
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

                if (count($this->customer_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }


    }

    public function count_filtered_lojistik_list()
    {
        $this->_lojistik_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_lojistik_list()
    {
        $this->_lojistik_list();
        return $this->db->count_all_results();
    }






    public function get_datatables_query_details_cari_gider_list2()

    {
        $this->_get_datatables_query_details_cari_gider_list2();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

//        $query=$query->result();
//        echo $this->db->last_query();
        return $query->result();

    }

    private function _get_datatables_query_details_cari_gider_list2()
    {

        $tip = $this->input->post('tip');
        $status = $this->input->post('status');

        $auth_id = $this->aauth->get_user()->id;

        $this->db->select('talep_form_customer.*,geopos_employees.name as pers_name,progress_status.name as progress_name,"carigidertalep" as href,
        talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name,geopos_customers.company');
        $this->db->from('talep_form_customer');
        $this->db->join('geopos_employees','talep_form_customer.talep_eden_user_id=geopos_employees.id');
        $this->db->join('geopos_customers','talep_form_customer.cari_id=geopos_customers.id');
        $this->db->join('progress_status','talep_form_customer.progress_status_id=progress_status.id');
        $this->db->join('geopos_projects','talep_form_customer.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_customer.status=talep_form_status.id');

        if($tip==1){
            $this->db->join('talep_onay_customer_new','talep_form_customer.id=talep_onay_customer_new.talep_id');
        }
        if($tip==1){
            $this->db->where("talep_onay_customer_new.type",1);
            $this->db->where("talep_onay_customer_new.staff",1);
            $this->db->where("talep_onay_customer_new.user_id",$auth_id);
        }


        if($tip==2) // //cari Gider
        {
            $this->db->where('talep_form_customer.status',$status);
            $this->db->where('talep_form_customer.type',1);

        }
        if($tip==3) // //cari Avans
        {
            $this->db->where('talep_form_customer.status',$status);
            $this->db->where('talep_form_customer.type',2);

        }
        if($status==12){
            $this->db->where("talep_form_customer.payment_personel_id",$auth_id);
        }


        //$this->db->where('talep_form_customer.type',1);
        $this->db->where('talep_form_customer.status!=',10);




        $i = 0;


        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_customer.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }


        foreach ($this->customer_column_search as $item) // loop column

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

                if (count($this->customer_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`talep_form_customer`.`id` ASC');

    }


    public function get_datatables_query_details_cari_gider_list()

    {
        $this->_get_datatables_query_details_cari_gider_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

//        $query=$query->result();
//        echo $this->db->last_query();
        return $query->result();

    }

    private function _get_datatables_query_details_cari_gider_list()

    {

        $tip = $this->input->post('tip');
        $status = $this->input->post('status');

        $auth_id = $this->aauth->get_user()->id;

        $this->db->select('talep_form_customer_new.*,geopos_employees.name as pers_name,progress_status.name as progress_name,"carigidertalepnew" as href,
        talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name,geopos_customers.company');
        $this->db->from('talep_form_customer_new');
        $this->db->join('geopos_employees','talep_form_customer_new.talep_eden_user_id=geopos_employees.id');
        $this->db->join('geopos_customers','talep_form_customer_new.cari_id=geopos_customers.id');
        $this->db->join('progress_status','talep_form_customer_new.progress_status_id=progress_status.id');
        $this->db->join('geopos_projects','talep_form_customer_new.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_customer_new.status=talep_form_status.id');
        if($tip==1){
            $this->db->join('talep_onay_customer_new','talep_form_customer_new.id=talep_onay_customer_new.talep_id');
            $this->db->where("talep_onay_customer_new.type",1);
            $this->db->where("talep_onay_customer_new.staff",1);
            $this->db->where("talep_onay_customer_new.user_id",$auth_id);
        }


        if($tip==2) // //cari Gider
        {
            $this->db->where('talep_form_customer_new.status',$status);

        }
        if($tip==3) // //cari Gider
        {
            $this->db->where('talep_form_customer_new.status',$status);

        }
        if($status==12){
            if($auth_id!=61){
                $this->db->where("talep_form_customer_new.payment_personel_id",$auth_id);
            }

        }

        //$this->db->where('talep_form_customer_new.type',1);
        $this->db->where('talep_form_customer_new.status!=',10);




        $i = 0;


        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_customer_new.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }


        foreach ($this->customer_column_search as $item) // loop column

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

                if (count($this->customer_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`talep_form_customer_new`.`id` ASC');

    }


    public function count_filtered_carigider()
    {
        $this->_get_datatables_query_details_cari_gider_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_carigider()
    {
        $this->_get_datatables_query_details_cari_gider_list();
        return $this->db->count_all_results();
    }


    public function get_datatables_query_details_cari_avans_list()

    {
        $this->_get_datatables_query_details_cari_avans_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

//        $query=$query->result();
//        echo $this->db->last_query();
        return $query->result();

    }

    private function _get_datatables_query_details_cari_avans_list()

    {

        $tip = $this->input->post('tip');
        $status = $this->input->post('status');

        $auth_id = $this->aauth->get_user()->id;

        $this->db->select('talep_form_customer.*,geopos_employees.name as pers_name,progress_status.name as progress_name,
        talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name,geopos_customers.company');
        $this->db->from('talep_form_customer');
        $this->db->join('geopos_employees','talep_form_customer.talep_eden_user_id=geopos_employees.id');
        $this->db->join('geopos_customers','talep_form_customer.cari_id=geopos_customers.id');
        $this->db->join('progress_status','talep_form_customer.progress_status_id=progress_status.id');
        $this->db->join('geopos_projects','talep_form_customer.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_customer.status=talep_form_status.id');
        if($tip==1){
            $this->db->join('talep_onay_customer_new','talep_form_customer.id=talep_onay_customer_new.talep_id');
            $this->db->where("talep_form_customer.type",2);
            $this->db->where("talep_onay_customer_new.staff",1);
            $this->db->where("talep_onay_customer_new.user_id",$auth_id);
        }

        if($tip==3){
            $this->db->where('talep_form_customer.status',$status);
            $this->db->where('talep_form_customer.type',2);
        }
        if($tip==2){
            $this->db->where('talep_form_customer.status',$status);
            $this->db->where('talep_form_customer.type',1);
        }
        if(!$tip){
            $this->db->where('talep_form_customer.type',2);
        }

        if($status==12){
            if($auth_id!=61){
                $this->db->where("talep_form_customer.payment_personel_id",$auth_id);
            }

        }


        if(!$status){
            $this->db->where('talep_form_customer.status!=',10);
        }

        $this->db->where('talep_form_customer.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57


        $i = 0;

        foreach ($this->customer_column_search as $item) // loop column

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

                if (count($this->customer_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }


    }


    public function count_filtered_cariavans()
    {
        $this->_get_datatables_query_details_cari_avans_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_cariavans()
    {
        $this->_get_datatables_query_details_cari_avans_list();
        return $this->db->count_all_results();
    }



    public function get_datatables_query_details_cari_avans_list_dash()

    {
        $this->_get_datatables_query_details_cari_avans_list_dash();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

//        $query=$query->result();
//        echo $this->db->last_query();
        return $query->result();

    }

    private function _get_datatables_query_details_cari_avans_list_dash()

    {

        $tip = $this->input->post('tip');
        $status = $this->input->post('status');
        $auth_id = $this->aauth->get_user()->id;

        $this->db->select('talep_form_customer.*,geopos_employees.name as pers_name,progress_status.name as progress_name,
        talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name,geopos_customers.company');
        $this->db->from('talep_form_customer');
        $this->db->join('geopos_employees','talep_form_customer.talep_eden_user_id=geopos_employees.id');
        $this->db->join('geopos_customers','talep_form_customer.cari_id=geopos_customers.id');
        $this->db->join('progress_status','talep_form_customer.progress_status_id=progress_status.id');
        $this->db->join('geopos_projects','talep_form_customer.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_customer.status=talep_form_status.id');
        if($tip==1){
            $this->db->join('talep_onay_customer_new','talep_form_customer.id=talep_onay_customer_new.talep_id');
        }
        if($tip==1){
            $this->db->where("talep_form_customer.type",2);
            $this->db->where("talep_onay_customer_new.staff",1);
            $this->db->where("talep_onay_customer_new.user_id",$auth_id);
            $this->db->where("talep_onay_customer_new.type",2);

        }


        $this->db->where('talep_form_customer.status',1);

        if($status==12){
            $this->db->where("talep_form_customer.payment_personel_id",$auth_id);
        }

        $this->db->where('talep_form_customer.type',2);

        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_customer.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }


        $i = 0;

        foreach ($this->customer_column_search as $item) // loop column

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

                if (count($this->customer_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }


    }


    public function count_filtered_cariavans_dash()
    {
        $this->_get_datatables_query_details_cari_avans_list_dash();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_cariavans_dash()
    {
        $this->_get_datatables_query_details_cari_avans_list_dash();
        return $this->db->count_all_results();
    }


    public function get_datatables_query_details_personel_gider_list()

    {
        $this->_get_datatables_query_details_personel_gider_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

//        $query=$query->result();
//        echo $this->db->last_query();
        return $query->result();

    }

    private function _get_datatables_query_details_personel_gider_list()

    {

        $tip = $this->input->post('tip');
        $status = $this->input->post('status');

        $auth_id = $this->aauth->get_user()->id;

        $this->db->select('talep_form_personel.*,geopos_employees.name as pers_name,progress_status.name as progress_name,
        talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name');
        $this->db->from('talep_form_personel');
        $this->db->join('geopos_employees','talep_form_personel.talep_eden_user_id=geopos_employees.id');
        $this->db->join('progress_status','talep_form_personel.progress_status_id=progress_status.id');
        $this->db->join('geopos_projects','talep_form_personel.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_personel.status=talep_form_status.id');
        if($tip==1){
            $this->db->join('talep_onay_personel_new','talep_form_personel.id=talep_onay_personel_new.talep_id');
        }
        if($tip==1){
            $this->db->where("talep_onay_personel_new.type",1);
            $this->db->where("talep_onay_personel_new.staff",1);
            $this->db->where("talep_onay_personel_new.user_id",$auth_id);
        }

        if($tip==2){
            $this->db->where('talep_form_personel.status',$status);
        }
        if($tip==3){
            $this->db->where('talep_form_personel.status',$status);
        }
        if($status==12){
            if($auth_id!=61){
                $this->db->where("talep_form_personel.payment_personel_id",$auth_id);
            }

        }

        $this->db->where('talep_form_personel.tip',1);
        $this->db->where('talep_form_personel.status!=',10);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_personel.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        $i = 0;

        foreach ($this->personel_column_search as $item) // loop column

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

                if (count($this->personel_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`talep_form_personel`.`id` ASC');

    }


    public function count_filtered_personelgider()
    {
        $this->_get_datatables_query_details_personel_gider_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_personelgider()
    {
        $this->_get_datatables_query_details_personel_gider_list();
        return $this->db->count_all_results();
    }


    public function get_datatables_query_details_personel_avans_list()

    {
        $this->_get_datatables_query_details_personel_avans_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

//        $query=$query->result();
//        echo $this->db->last_query();
        return $query->result();

    }

    private function _get_datatables_query_details_personel_avans_list()

    {

        $tip = $this->input->post('tip');
        $status = $this->input->post('status');

        $auth_id = $this->aauth->get_user()->id;

        $this->db->select('talep_form_personel.*,geopos_employees.name as pers_name,progress_status.name as progress_name,
        talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name');
        $this->db->from('talep_form_personel');
        $this->db->join('geopos_employees','talep_form_personel.talep_eden_user_id=geopos_employees.id');
        $this->db->join('progress_status','talep_form_personel.progress_status_id=progress_status.id');
        $this->db->join('geopos_projects','talep_form_personel.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_personel.status=talep_form_status.id');
        if($tip==1){
            $this->db->join('talep_onay_personel_new','talep_form_personel.id=talep_onay_personel_new.talep_id');
        }
        if($tip==1){
            $this->db->where("talep_onay_personel_new.type",1);
            $this->db->where("talep_onay_personel_new.staff",1);
            $this->db->where("talep_onay_personel_new.user_id",$auth_id);
        }

        if($tip==2) // //cari Gider
        {
            $this->db->where('talep_form_personel.status',$status);

        }
        if($tip==3) // //cari Gider
        {
            $this->db->where('talep_form_personel.status',$status);

        }

        if($status==12){
            if($auth_id==61){

            }
            else {
                $this->db->where("talep_form_personel.payment_personel_id",$auth_id);
            }

        }
        $this->db->where('talep_form_personel.loc', $this->session->userdata('set_firma_id'));
        $this->db->where('talep_form_personel.tip',2);
        $this->db->where('talep_form_personel.status!=',10);

        $i = 0;

        foreach ($this->personel_column_search as $item) // loop column

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

                if (count($this->personel_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`talep_form_personel`.`id` ASC');

    }


    public function count_filtered_personelavans()
    {
        $this->_get_datatables_query_details_personel_avans_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_personelavans()
    {
        $this->_get_datatables_query_details_personel_avans_list();
        return $this->db->count_all_results();
    }




    public function proje_stoklari_bekleyen_ajax_list()

    {
        $this->_proje_stoklari_bekleyen_ajax_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

//        $query=$query->result();
//        echo $this->db->last_query();
        return $query->result();

    }

    private function _proje_stoklari_bekleyen_ajax_list()

    {

        $auth_id = $this->aauth->get_user()->id;
        $this->db->select('proje_stoklari_onay_list.id,geopos_projects.name,geopos_projects.code,geopos_project_bolum.name as  bolum_name,geopos_milestones.name as asama_name,geopos_products.product_name,proje_stoklari.option_id,proje_stoklari.option_value_id');
        $this->db->from('proje_stoklari_onay_list');
        $this->db->join('proje_stoklari','proje_stoklari_onay_list.proje_stok_id = proje_stoklari.id');
        $this->db->join('geopos_projects','proje_stoklari.proje_id = geopos_projects.id');
        $this->db->join('geopos_products','proje_stoklari.product_id = geopos_products.pid');
        $this->db->join('geopos_project_bolum','proje_stoklari.bolum_id = geopos_project_bolum.id','left');
        $this->db->join('geopos_milestones','proje_stoklari.asama_id = geopos_milestones.id','left');
        $this->db->where('proje_stoklari_onay_list.staff_id',$auth_id);
        $this->db->where('proje_stoklari_onay_list.staff_status=0');

        $i = 0;

        foreach ($this->customer_column_search as $item) // loop column

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

                if (count($this->customer_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`proje_stoklari_onay_list`.`id` ASC');

    }


    public function count_filtered_proje_stoklari_bekleyen()
    {
        $this->_proje_stoklari_bekleyen_ajax_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_proje_stoklari_bekleyen()
    {
        $this->_proje_stoklari_bekleyen_ajax_list();
        return $this->db->count_all_results();
    }


    public function invoices_talep_onay_report()

    {
        $this->_invoices_talep_onay_report();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        //$query=$query->result();
        //echo $this->db->last_query();die();

        return $query->result();

    }

    private function _invoices_talep_onay_report()

    {

        $proje_id = $this->input->post('proje_id');
        $tip = $this->input->get('tip');
        $this->db->select('talep_form.*, 1 as tip');
        $this->db->from('talep_form');
        $this->db->where_not_in('talep_form.status',[13,10,9]);
        $this->db->where('talep_form.bildirim_durumu',1);
        $this->db->where('talep_form.loc', $this->session->userdata('set_firma_id'));
        if($proje_id>0){
            $this->db->where('talep_form.proje_id',$proje_id);
        }


        $i = 0;

        foreach ($this->column_report as $item) // loop column

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



                if (count($this->column_report) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $this->db->order_by('`talep_form`.`id` DESC');


    }


    public function count_filtered_talep_report()
    {
        $this->_invoices_talep_onay_report();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_talep_report()
    {
        $this->_invoices_talep_onay_report();
        return $this->db->count_all_results();
    }



    public function invoices_cari_onay_report()

    {
        $this->_invoices_cari_onay_report();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        //$query=$query->result();
        //echo $this->db->last_query();die();

        return $query->result();

    }

    private function _invoices_cari_onay_report()

    {

        $tip = $this->input->post('tip');
        $proje_id = $this->input->post('proje_id');
        if($tip==1){
            $this->db->select('*');
            $this->db->from('talep_form_customer_new');
            $this->db->where_not_in('talep_form_customer_new.status',[13,10,9]);
            $this->db->where('talep_form_customer_new.bildirim_durumu',1);
            $this->db->where('talep_form_customer_new.type',$tip);
            $this->db->where('talep_form_customer_new.loc', $this->session->userdata('set_firma_id'));

            if($proje_id){
                $this->db->where('talep_form_customer_new.proje_id',$proje_id);
            }

            $i = 0;
            foreach ($this->column_report as $item) // loop column

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



                    if (count($this->column_report) - 1 == $i) //last loop

                        $this->db->group_end(); //close bracket

                }

                $i++;

            }

            $this->db->order_by('`talep_form_customer_new`.`id` DESC');
        }
        else {
            $this->db->select('*');
            $this->db->from('talep_form_customer');
            $this->db->where_not_in('talep_form_customer.status',[13,10,9]);
            $this->db->where('talep_form_customer.bildirim_durumu',1);
            $this->db->where('talep_form_customer.type',$tip);
            $this->db->where('talep_form_customer.loc', $this->session->userdata('set_firma_id'));
            if($proje_id > 0){
                $this->db->where('talep_form_customer.proje_id',$proje_id);
            }
            $i = 0;
            foreach ($this->column_report as $item) // loop column
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



                    if (count($this->column_report) - 1 == $i) //last loop

                        $this->db->group_end(); //close bracket

                }

                $i++;

            }


            $this->db->order_by('`talep_form_customer`.`id` DESC');
        }



    }


    public function count_filtered_cari_gider_talep_report()
    {
        $this->_invoices_cari_onay_report();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_cari_gider_talep_report()
    {
        $this->_invoices_cari_onay_report();
        return $this->db->count_all_results();
    }



    public function bekleyen_qaime_list()

    {
        $this->_bekleyen_qaime_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        //$query=$query->result();
        //echo $this->db->last_query();die();

        return $query->result();

    }

    private function _bekleyen_qaime_list()

    {

        $tip = $this->input->post('tip');

        $auth_id = $this->aauth->get_user()->id;

        $this->db->select('geopos_invoices.*,geopos_customers.company,geopos_projects.name as proje_name');
        $this->db->from('geopos_invoices');
        $this->db->join('invoices_onay_new','geopos_invoices.id=invoices_onay_new.invoices_id');
        $this->db->join('geopos_customers','geopos_invoices.csd=geopos_customers.id','LEFT');
        $this->db->join('geopos_projects','geopos_invoices.proje_id=geopos_projects.id');

        $this->db->where('invoices_onay_new.staff',1);
        $this->db->where('invoices_onay_new.user_id', $auth_id);
        $this->db->where('invoices_onay_new.status is null');
        $this->db->where('invoices_onay_new.type',$tip);
        $this->db->where_not_in('geopos_invoices.status',[3]);

        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_invoices.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }


        $i = 0;

        foreach ($this->customer_column_search as $item) // loop column

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

                if (count($this->customer_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }


    }

    public function count_filtered_qaime()
    {
        $this->_bekleyen_qaime_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_qaime()
    {
        $this->_bekleyen_qaime_list();
        return $this->db->count_all_results();
    }


    public function get_datatables_query_details_cari_gider_list_yeni()

    {
        $this->_get_datatables_query_details_cari_gider_list_yeni();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

//        $query=$query->result();
//        echo $this->db->last_query();
        return $query->result();

    }

    private function _get_datatables_query_details_cari_gider_list_yeni()

    {

        $tip = $this->input->post('tip');
        $status = $this->input->post('status');

        $auth_id = $this->aauth->get_user()->id;

        $this->db->select('talep_form_customer_new.*,geopos_employees.name as pers_name,progress_status.name as progress_name,"carigidertalepnew" as href,
        talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name,geopos_customers.company');
        $this->db->from('talep_form_customer_new');
        $this->db->join('geopos_employees','talep_form_customer_new.talep_eden_user_id=geopos_employees.id');
        $this->db->join('geopos_customers','talep_form_customer_new.cari_id=geopos_customers.id');
        $this->db->join('progress_status','talep_form_customer_new.progress_status_id=progress_status.id');
        $this->db->join('geopos_projects','talep_form_customer_new.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_customer_new.status=talep_form_status.id');
        $this->db->join('talep_onay_customer_new','talep_form_customer_new.id=talep_onay_customer_new.talep_id');
        $this->db->where("talep_onay_customer_new.type",1);
        $this->db->where("talep_onay_customer_new.staff",1);
        $this->db->where("talep_onay_customer_new.user_id",$auth_id);
        //$this->db->where('talep_form_customer_new.type',1);
        $this->db->where('talep_form_customer_new.status',1);




        $i = 0;


        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_customer_new.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }


        foreach ($this->customer_column_search as $item) // loop column

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

                if (count($this->customer_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`talep_form_customer_new`.`id` ASC');

    }


    public function count_filtered_carigider_yeni()
    {
        $this->_get_datatables_query_details_cari_gider_list_yeni();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_carigider_yeni()
    {
        $this->_get_datatables_query_details_cari_gider_list_yeni();
        return $this->db->count_all_results();
    }

    public function atama_gider_talep()
    {
        $count=0;
        $talep_form_customer_new = 'and talep_form_customer_new.loc ='.$this->session->userdata('set_firma_id');

        $say=0;
        if($this->aauth->get_user()->id==61){

            $count = $this->db->query("SELECT COUNT(id) as sayi FROM talep_form_customer_new Where status=11 and talep_form_customer_new.type=1  $talep_form_customer_new")->row();
            $say=$count->sayi;
        }

        return [
            'status'=>1,
            'count'=>$say
        ];

    }

    public function atama_nakliye_talep()
    {
        $say=0;
        $talep_form_nakliye = 'and talep_form_nakliye_products.loc ='.$this->session->userdata('set_firma_id');

        if($this->aauth->get_user()->id==61){
            //$count = $this->db->query("SELECT COUNT(id) as sayi FROM talep_form_nakliye_products Where status=11 $talep_form_nakliye")->row();
            $count = $this->db->query("SELECT COUNT(talep_form_nakliye_products.id) as sayi 
                    FROM talep_form_nakliye_products
                   Inner JOIN talep_form_nakliye ON talep_form_nakliye_products.form_id=talep_form_nakliye.id
                         Where 
                             talep_form_nakliye_products.status=11 and
                             talep_form_nakliye.status!=9 $talep_form_nakliye ")->row();
            $say=$count->sayi;
        }

        $this->db->from('talep_form_nakliye_products');
        $this->db->join('talep_form_nakliye','talep_form_nakliye.id=talep_form_nakliye_products.form_id');
        $this->db->join('araclar','talep_form_nakliye_products.arac_id=araclar.id','LEFT');
        $this->db->join('geopos_employees','talep_form_nakliye.talep_eden_user_id=geopos_employees.id');
        $this->db->join('geopos_customers','talep_form_nakliye_products.cari_id=geopos_customers.id');
        $this->db->join('geopos_projects','talep_form_nakliye.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_nakliye_products.status=talep_form_status.id');
        $this->db->where('talep_form_nakliye_products.status',$status);
        $this->db->where('talep_form_nakliye.status!=9',);

        return [
            'status'=>1,
            'count'=>$say
        ];

    }

    public function atama_cari_avans_talep()
    {
        $sayi=0;
        $talep_form_nakliye = 'and talep_form_customer.loc ='.$this->session->userdata('set_firma_id');

        if($this->aauth->get_user()->id==61){
            $count = $this->db->query("SELECT COUNT(id) as sayi FROM talep_form_customer Where status=11 and talep_form_customer.type=2  $talep_form_nakliye")->row();
            $sayi=$count->sayi;
        }

        return [
            'status'=>1,
            'count'=>$sayi
        ];


    }
    public function atama_personel_avans_talep()
    {
        $say=0;

        $where_loc_personel = 'and talep_form_personel.loc ='.$this->session->userdata('set_firma_id');

        if($this->aauth->get_user()->id==61){
            $count = $this->db->query("SELECT COUNT(id) as sayi FROM talep_form_personel Where status=11 and talep_form_personel.tip=2  $where_loc_personel")->row();
            $say=$count->sayi;
        }
        return [
            'status'=>1,
            'count'=>$say
        ];

    }

    public function atama_personel_gider_talep()
    {
        $say=0;

        $where_loc_personel = 'and talep_form_personel.loc ='.$this->session->userdata('set_firma_id');

        if($this->aauth->get_user()->id==61){
            $count = $this->db->query("SELECT COUNT(id) as sayi FROM talep_form_personel Where status=11 and talep_form_personel.tip=1  $where_loc_personel")->row();
            $say=$count->sayi;
        }
        return [
            'status'=>1,
            'count'=>$say
        ];

    }

    public function ajax_podradci_borclandirma(){

        $count=0;
        $user_id = $this->aauth->get_user()->id;
        $count = $this->db->query("SELECT COUNT(id) as sayi FROM talep_borclandirma Where durum=0 and staff_id=$user_id")->row();
        return [
            'status'=>1,
            'count'=>$count->sayi
        ];

    }

    public function cari_avans_onay_count()
    {
        $auth_id = $this->aauth->get_user()->id;

        $this->db->select('talep_form_customer.*,geopos_employees.name as pers_name,progress_status.name as progress_name,
        talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name,geopos_customers.company');
        $this->db->from('talep_form_customer');
        $this->db->join('geopos_employees','talep_form_customer.talep_eden_user_id=geopos_employees.id');
        $this->db->join('geopos_customers','talep_form_customer.cari_id=geopos_customers.id');
        $this->db->join('progress_status','talep_form_customer.progress_status_id=progress_status.id');
        $this->db->join('geopos_projects','talep_form_customer.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_customer.status=talep_form_status.id');
        $this->db->join('talep_onay_customer_new','talep_form_customer.id=talep_onay_customer_new.talep_id');
        $this->db->where("talep_form_customer.type",2);
        $this->db->where("talep_onay_customer_new.staff",1);
        $this->db->where("talep_onay_customer_new.user_id",$auth_id);
        $this->db->where("talep_onay_customer_new.type",2);
        $this->db->where('talep_form_customer.status',1);
        $this->db->where('talep_form_customer.type',2);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_customer.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $this->db->order_by('`talep_form_customer`.`id` ASC');
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function cari_gider_onay_count()
    {
        $auth_id = $this->aauth->get_user()->id;

        $this->db->select('talep_form_customer_new.*,geopos_employees.name as pers_name,progress_status.name as progress_name,"carigidertalepnew" as href,
        talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name,geopos_customers.company');
        $this->db->from('talep_form_customer_new');
        $this->db->join('geopos_employees','talep_form_customer_new.talep_eden_user_id=geopos_employees.id');
        $this->db->join('geopos_customers','talep_form_customer_new.cari_id=geopos_customers.id');
        $this->db->join('progress_status','talep_form_customer_new.progress_status_id=progress_status.id');
        $this->db->join('geopos_projects','talep_form_customer_new.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_customer_new.status=talep_form_status.id');
        $this->db->join('talep_onay_customer_new','talep_form_customer_new.id=talep_onay_customer_new.talep_id');
        $this->db->where("talep_onay_customer_new.type",1);
        $this->db->where("talep_onay_customer_new.staff",1);
        $this->db->where("talep_onay_customer_new.user_id",$auth_id);
        $this->db->where('talep_form_customer_new.status',1);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('talep_form_customer_new.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $this->db->order_by('`talep_form_customer_new`.`id` ASC');

        $query = $this->db->get();

//        $query=$query->result();
//        echo $this->db->last_query();
        return $query->num_rows();

    }


}
