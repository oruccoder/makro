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





class Razilastirma_model extends CI_Model
{
    var $table_news = 'cari_razilastirma ';

    var $column_order = array('date', 'cari_id', 'proje_id', 'odeme_tipi','muqavele_no','odeme_sekli','oran');

    var $column_search = array('date', 'cari_id', 'proje_id', 'odeme_tipi','muqavele_no','odeme_sekli','oran');


    var $column_search_all = array('geopos_customers.company', 'geopos_account_type.name', 'geopos_projects.name','geopos_projects.code', 'cari_razilastirma.code','cari_razilastirma.muqavele_no','cari_razilastirma.odeme_sekli','cari_razilastirma.net_tutar','cari_razilastirma.tax_tutar','cari_razilastirma.genel_tutar');

    var $column_order_all = array('cari_razilastirma.id','geopos_projects.code','geopos_customers.company', 'geopos_account_type.name','cari_razilastirma.tax_oran','cari_razilastirma.net_tutar','cari_razilastirma.tax_tutar','cari_razilastirma.genel_tutar', 'cari_razilastirma.bildirim_durumu', 'cari_razilastirma.razi_status');

    var $order = array('id' => 'DESC');



    public function __construct()

    {

        parent::__construct();
        $this->load->model('communication_model');

    }


    public function get_datatables_details($id)

    {
        $this->_get_datatables_query_details($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _get_datatables_query_details($id)

    {

        $this->db->select('cari_razilastirma.*,geopos_projects.name as proje_name,geopos_account_type.name as odeme_sekli_name,odeme_tipi_razilastirma.name as odeme_tipi_name');
        $this->db->from($this->table_news);
        $this->db->where('cari_id',$id);
        $this->db->where('cari_razilastirma.deleted_at is Null');

        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where("DATE(geopos_invoices.invoicedate) >=",datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where("DATE(geopos_invoices.invoicedate) <=",datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
        }

        $this->db->join('geopos_projects','cari_razilastirma.proje_id=geopos_projects.id','LEFT');
        $this->db->join('geopos_account_type','cari_razilastirma.odeme_sekli=geopos_account_type.id','LEFT');
        $this->db->join('odeme_tipi_razilastirma','cari_razilastirma.odeme_tipi=odeme_tipi_razilastirma.id','LEFT');

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
        $this->db->order_by('`cari_razilastirma`.`id` DESC');

    }


    public function count_filtered($id)
    {
        $this->_get_datatables_query_details($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($id)
    {
        $this->_get_datatables_query_details($id);
        return $this->db->count_all_results();
    }




    public function get_datatables_details_proje($id)

    {
        $this->_get_datatables_query_details_proje($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _get_datatables_query_details_proje($id)

    {

        $this->db->select('geopos_customers.company,cari_razilastirma.*,geopos_projects.name as proje_name,geopos_account_type.name as odeme_sekli_name,odeme_tipi_razilastirma.name as odeme_tipi_name');
        $this->db->from($this->table_news);
        $this->db->where('proje_id',$id);
        $this->db->where('cari_razilastirma.deleted_at is Null');

        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where("DATE(geopos_invoices.invoicedate) >=",datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where("DATE(geopos_invoices.invoicedate) <=",datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
        }

        $this->db->join('geopos_projects','cari_razilastirma.proje_id=geopos_projects.id','LEFT');
        $this->db->join('geopos_account_type','cari_razilastirma.odeme_sekli=geopos_account_type.id','LEFT');
        $this->db->join('odeme_tipi_razilastirma','cari_razilastirma.odeme_tipi=odeme_tipi_razilastirma.id','LEFT');
        $this->db->join('geopos_customers','cari_razilastirma.cari_id=geopos_customers.id');

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
        $this->db->order_by('`cari_razilastirma`.`id` DESC');

    }


    public function count_filtered_proje($id)
    {
        $this->_get_datatables_query_details_proje($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_proje($id)
    {
        $this->_get_datatables_query_details_proje($id);
        return $this->db->count_all_results();
    }




    public function ajax_list_all()

    {
        $this->_ajax_list_all();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _ajax_list_all()

    {

        $this->db->select('geopos_customers.company,cari_razilastirma.*,geopos_projects.code as proje_name,geopos_account_type.name as odeme_sekli_name,odeme_tipi_razilastirma.name as odeme_tipi_name');
        $this->db->from($this->table_news);
        $this->db->where('cari_razilastirma.deleted_at is Null');

        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where("DATE(geopos_invoices.invoicedate) >=",datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where("DATE(geopos_invoices.invoicedate) <=",datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
        }

        $this->db->join('geopos_projects','cari_razilastirma.proje_id=geopos_projects.id','LEFT');
        $this->db->join('geopos_account_type','cari_razilastirma.odeme_sekli=geopos_account_type.id','LEFT');
        $this->db->join('odeme_tipi_razilastirma','cari_razilastirma.odeme_tipi=odeme_tipi_razilastirma.id','LEFT');
        $this->db->join('geopos_customers','cari_razilastirma.cari_id=geopos_customers.id');

        $i = 0;

        foreach ($this->column_search_all as $item) // loop column

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

                if (count($this->column_search_all) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order_all[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->column_order_all)) {

            $order = $this->column_order_all;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }


    public function count_filtered_list()
    {
        $this->_ajax_list_all();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_list()
    {
        $this->_ajax_list_all();
        return $this->db->count_all_results();
    }




    public function send_mail($user_id,$subject,$message){
        $message .= "<br><br><br><br>";
        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
        $proje_sorumlusu_email = personel_detailsa($user_id)['email'];
        $recipients = array($proje_sorumlusu_email);
        $this->communication_model->onay_mail($recipients, $subject, $message, false,'', 'gider_talep_onay_maili');
        return 1;
    }



    public function get_datatables_details_bekleyen($id)

    {
        $this->_get_datatables_query_details_bekleyen($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _get_datatables_query_details_bekleyen($id)

    {


        $tip = $this->input->post('tip');

        $auth_id = $this->aauth->get_user()->id;

        $this->db->select('cari_razilastirma.*,geopos_projects.name as proje_name,geopos_account_type.name as odeme_sekli_name,odeme_tipi_razilastirma.name as odeme_tipi_name,razilastirma_onay.status');
        $this->db->from('cari_razilastirma');
        $this->db->join('razilastirma_onay','cari_razilastirma.id=razilastirma_onay.razilastirma_id');
        $this->db->join('odeme_tipi_razilastirma','cari_razilastirma.odeme_tipi=odeme_tipi_razilastirma.id','LEFT');
        $this->db->join('geopos_customers','cari_razilastirma.cari_id=geopos_customers.id');
        $this->db->join('geopos_account_type','cari_razilastirma.odeme_sekli=geopos_account_type.id','LEFT');
        $this->db->join('geopos_projects','cari_razilastirma.proje_id=geopos_projects.id');
        $this->db->where('razilastirma_onay.staff',1);
        $this->db->where('razilastirma_onay.user_id', $auth_id);
        $this->db->where('razilastirma_onay.status is null');
        $this->db->where_not_in('cari_razilastirma.razi_status',[2,4]);

        if($this->session->userdata('set_firma_id')){
            $this->db->where('cari_razilastirma.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }


//        $this->db->select('cari_razilastirma.*,geopos_projects.name as proje_name,geopos_account_type.name as odeme_sekli_name,odeme_tipi_razilastirma.name as odeme_tipi_name,razilastirma_onay.status');
//        $this->db->from($this->table_news);
//
//
//        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
//        {
//            $this->db->where("DATE(geopos_invoices.invoicedate) >=",datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
//            $this->db->where("DATE(geopos_invoices.invoicedate) <=",datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
//        }
//
//        $this->db->join('geopos_projects','cari_razilastirma.proje_id=geopos_projects.id','LEFT');
//        $this->db->join('geopos_account_type','cari_razilastirma.odeme_sekli=geopos_account_type.id','LEFT');
//        $this->db->join('odeme_tipi_razilastirma','cari_razilastirma.odeme_tipi=odeme_tipi_razilastirma.id','LEFT');
//        $this->db->join('razilastirma_onay','razilastirma_onay.razilastirma_id=cari_razilastirma.id','LEFT');
//        $this->db->where('razilastirma_onay.staff_id',$id);
//        $this->db->where('razilastirma_onay.status',0);
//        $this->db->where('razilastirma_onay.next_status',1);
//        $this->db->where('razilastirma_onay.deleted_at is Null');
//        $this->db->where('cari_razilastirma.deleted_at is Null');
//        $this->db->where('cari_razilastirma.bildirim_durumu',1);
//
//        $i = 0;
//
//        foreach ($this->column_search as $item) // loop column
//
//        {
//            if ($_POST['search']['value']) // if datatable send POST for search
//
//            {
//                if ($i === 0) // first loop
//
//                {
//                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
//
//                    $this->db->like($item, $_POST['search']['value']);
//
//                } else {
//
//                    $this->db->or_like($item, $_POST['search']['value']);
//
//                }
//
//                if (count($this->column_search) - 1 == $i) //last loop
//
//                    $this->db->group_end(); //close bracke
//            }
//
//            $i++;
//
//        }
//        $this->db->group_by('cari_razilastirma.id');
//        $this->db->order_by('`cari_razilastirma`.`id` DESC');

    }


    public function count_filtered_bekleyen($id)
    {
        $this->_get_datatables_query_details_bekleyen($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_bekleyen($id)
    {
        $this->_get_datatables_query_details_bekleyen($id);
        return $this->db->count_all_results();
    }


    public function odeme_metodlari(){
        $this->db->select('*');
        $this->db->from('geopos_account_type');
        $query = $this->db->get();
        return $query->result();

    }

    public function projeler(){
        $this->db->select('*');
        $this->db->from('geopos_projects');
        $query = $this->db->get();
        return $query->result();
    }

    public function staff_id($id,$tip){
        $this->db->select('staff');
        $this->db->from('razilastirma_onay');
        $this->db->where('razilastirma_id',$id);
        $this->db->where('tip',$tip);
        $query = $this->db->get();
        return $query->row()->staff;
    }

    public function staff_details($id,$tip){
        $this->db->select('*');
        $this->db->from('razilastirma_onay');
        $this->db->where('razilastirma_id',$id);
        $this->db->where('tip',$tip);
        $query = $this->db->get();
        return $query->row();
    }
    public function personeller(){
        $this->db->select('geopos_employees.*,geopos_users.banned,geopos_users.roleid ,geopos_users.loc,geopos_projects.name as proje_name');
        $this->db->from('geopos_employees');
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id');
        $this->db->join('personel_salary', 'personel_salary.personel_id = geopos_users.id','left');
        $this->db->join('geopos_projects', 'personel_salary.proje_id = geopos_projects.id','left');
        $this->db->where('geopos_users.banned', 0);
        $this->db->where('personel_salary.status', 1);
        $this->db->order_by('geopos_users.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
    public function odeme_tipleri(){
        $this->db->select('*');
        $this->db->from('odeme_tipi_razilastirma');
        $query = $this->db->get();
        return $query->result();

    }


    public function details($id){
        $this->db->select('cari_razilastirma.*,geopos_projects.name as proje_name,geopos_account_type.name as odeme_sekli_name,odeme_tipi_razilastirma.name as odeme_tipi_name');
        $this->db->from('cari_razilastirma');
        $this->db->join('geopos_projects', 'cari_razilastirma.proje_id=geopos_projects.id','LEFT');
        $this->db->join('geopos_account_type', 'cari_razilastirma.odeme_sekli=geopos_account_type.id ','LEFT');
        $this->db->join('odeme_tipi_razilastirma', 'cari_razilastirma.odeme_tipi=odeme_tipi_razilastirma.id ','LEFT');
        $this->db->where('cari_razilastirma.id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    public function item_details($id){
        $this->db->select('cari_razilastirma_item.*,geopos_todolist.name');
        $this->db->from('cari_razilastirma_item');
        $this->db->join('geopos_todolist','cari_razilastirma_item.task_id=geopos_todolist.id');
        $this->db->where('cari_razilastirma_item.razilastirma_id',$id);
        $this->db->order_by('cari_razilastirma_item.id','DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function form_total($id){
        $this->db->select('SUM(toplam_tutar) as total');
        $this->db->from('cari_razilastirma_item');
        $this->db->where('razilastirma_id',$id);
        $query = $this->db->get();
        return $query->row()->total;
    }
    public function razi_count()
    {
        $count=0;
        $id =  $this->aauth->get_user()->id;
        $count = $this->db->query("SELECT * FROM `razilastirma_onay` 
INNER JOIN cari_razilastirma On razilastirma_onay.razilastirma_id=cari_razilastirma.id
WHERE   cari_razilastirma.razi_status=0 and razilastirma_onay.user_id = $id AND `staff` = 1 ")->num_rows();

        return [
            'status'=>1,
            'count'=>$count
        ];

    }

}
