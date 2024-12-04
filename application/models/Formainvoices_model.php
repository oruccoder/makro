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



class Formainvoices_model extends CI_Model

{
    var $table = 'geopos_invoices';
    var $column_searchf = array(
        'geopos_invoices.invoicedate',
        'geopos_invoices.payer',
        'geopos_invoices.invoice_no',
        'geopos_customers.company',
        'geopos_invoices.total',
        'geopos_invoices.status',
        'geopos_projects.name'
    );
    var $column_orderf = array(
        'geopos_invoices.id',
        null,
        'geopos_invoices.muqavele_no',
        'geopos_invoices.invoice_no',
        'geopos_invoices.payer',
        'geopos_invoices.total',
        'geopos_invoices.status',
        'geopos_projects.name'
    );
    var $orderf = array('geopos_invoices.id' => 'desc');

    var $column_search_notes = array('desc', 'created_at', 'geopos_employees.name');
    var $column_search_history = array('desc', 'created_at', 'geopos_employees.name');


    //Forma 2
    function forma_total($id)

    {

        $this->db->select('SUM(subtotal) as total');
        $this->db->from('geopos_invoice_items');
        $this->db->where('tid',$id);
        $query = $this->db->get();
        return $query->row()->total;

    }
    function get_datatables_form2($opt = '')

    {

        $this->_get_datatables_query_form2($opt);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();


        return $query->result();

    }

    private function _get_datatables_query_form2($opt = '')

    {

        $where='geopos_invoices.i_class=0 and (geopos_invoices.invoice_type_id=29 or geopos_invoices.invoice_type_id=30)';

        $this->db->select('geopos_invoices.muqavele_no,geopos_invoices.forma2_notes,geopos_invoices.proje_id,geopos_invoices.refer,geopos_invoices.invoice_no,geopos_invoices.id,geopos_invoices.invoice_type_id,geopos_invoices.tid,geopos_invoices.invoicedate,geopos_invoices.invoiceduedate,geopos_invoices.total,geopos_invoices.status,geopos_customers.company as name,geopos_invoices.para_birimi');

        $this->db->join('geopos_projects','geopos_invoices.proje_id=geopos_projects.id','left');
        $this->db->from($this->table);


        $this->db->where($where);

        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_invoices.invoicedate) >=', datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where('DATE(geopos_invoices.invoicedate) <=', datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
        }
        if ($this->input->post('proje_id')) // if datatable send POST for search
        {
            $this->db->where('geopos_invoices.proje_id=', $this->input->post('proje_id')); //2019-11-23 14:28:57
        }

        if ($this->input->post('status')) // if datatable send POST for search
        {
            $this->db->where('geopos_invoices.status=', $this->input->post('status')); //2019-11-23 14:28:57
        }
        if ($this->input->post('tip')) // if datatable send POST for search
        {
            if($this->input->post('tip')=='proje_giderleri'){
                $this->db->where('geopos_invoices.status!=3'); //2019-11-23 14:28:57
            }

        }



        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');

        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_invoices.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }




        $i = 0;



        foreach ($this->column_searchf as $item) // loop column

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



                if (count($this->column_searchf) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_orderf[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->orderf)) {

            $order = $this->orderf;

            $this->db->order_by('id','desc');

        }


    }


    public function count_all_forma_2($opt = '')

    {

        $this->_get_datatables_query_form2();

        return $this->db->count_all_results();

    }

    function count_filtered_forma_2($opt = '')

    {

        $this->_get_datatables_query_form2();

        if ($opt) {

            $this->db->where('geopos_invoices.eid', $opt);

        }



        $query = $this->db->get();

        return $query->num_rows();

    }

    //Forma 2


    function list_bekleyen($opt = '')

    {

        $this->_list_bekleyen($opt);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();


        return $query->result();

    }

    private function _list_bekleyen($opt = '')

    {

        $auth_id = $this->aauth->get_user()->id;
        $this->db->select('geopos_invoices.*,geopos_employees.name as pers_name,invoice_status.name as st_name,geopos_projects.code as proje_name');
        $this->db->from('geopos_invoices');
        $this->db->join('geopos_employees','geopos_invoices.eid=geopos_employees.id','LEFT');
        $this->db->join('geopos_projects','geopos_invoices.proje_id=geopos_projects.id');
        $this->db->join('invoice_status','geopos_invoices.status=invoice_status.id');
        $this->db->join('invoices_onay_new','geopos_invoices.id=invoices_onay_new.invoices_id');
        $this->db->where("invoices_onay_new.type",2);
        $this->db->where("invoices_onay_new.staff",1);
//        $this->db->where("geopos_invoices.status",1);
        $this->db->where("invoices_onay_new.user_id",$auth_id);
        $this->db->where("geopos_invoices.status!=",3);
        $i = 0;
        foreach ($this->column_searchf as $item) // loop column

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

                    if (count($this->column_searchf) - 1 == $i) //last loop

                        $this->db->group_end(); //close bracke
                }

                $i++;
            }


        }
        $this->db->order_by('`geopos_invoices`.`id` DESC');


//        $user_id = $this->aauth->get_user()->id;
//        $where='(geopos_invoices.invoice_type_id=29 or geopos_invoices.invoice_type_id=30)';
//        //$where='geopos_invoices.i_class=0 and (geopos_invoices.invoice_type_id=29 or geopos_invoices.invoice_type_id=30)';
//
//        $this->db->select('geopos_invoices.muqavele_no,geopos_invoices.forma2_notes,
//            geopos_invoices.proje_id,geopos_invoices.refer,geopos_invoices.invoice_no,geopos_invoices.id,
//            geopos_invoices.invoice_type_id,geopos_invoices.tid,geopos_invoices.invoicedate,geopos_invoices.invoiceduedate,
//            geopos_invoices.total,geopos_invoices.status,geopos_customers.company as name,geopos_invoices.para_birimi,
//            geopos_invoices.proje_sorumlu_id,geopos_invoices.proje_muduru_id,geopos_invoices.genel_mudur_id
//            ');
//
//        $this->db->join('geopos_projects','geopos_invoices.proje_id=geopos_projects.id','left');
//        $this->db->from($this->table);
//        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');
//        $this->db->where('geopos_invoices.bildirim_durumu=1');
//        $this->db->where('geopos_invoices.status=1');
//        $this->db->where("(geopos_invoices.proje_sorumlu_id=$user_id or geopos_invoices.proje_muduru_id=$user_id or  geopos_invoices.genel_mudur_id=$user_id)");
//        $this->db->where($where);
//
//
//
//
//
//        $i = 0;
//
//
//
//        foreach ($this->column_searchf as $item) // loop column
//
//        {
//
//            if ($_POST['search']['value']) // if datatable send POST for search
//
//            {
//
//
//
//                if ($i === 0) // first loop
//
//                {
//
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
//
//
//                if (count($this->column_searchf) - 1 == $i) //last loop
//
//                    $this->db->group_end(); //close bracket
//
//            }
//
//            $i++;
//
//        }
//
//
//
//        if (isset($_POST['order'])) // here order processing
//
//        {
//
//            $this->db->order_by($this->column_orderf[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
//
//        } else if (isset($this->orderf)) {
//
//            $order = $this->orderf;
//
//            $this->db->order_by('id','desc');
//
//        }


    }

    public function count_all_list_bekleyen($opt = '')

    {

        $this->_list_bekleyen();

        return $this->db->count_all_results();

    }

    public function count_filtered_list_bekleyen($opt = '')

    {

        $this->_list_bekleyen();

        if ($opt) {

            $this->db->where('geopos_invoices.eid', $opt);

        }



        $query = $this->db->get();

        return $query->num_rows();

    }




    function list_iptal($opt = '')

    {

        $this->_list_iptal($opt);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();


        return $query->result();

    }

    private function _list_iptal($opt = '')

    {

        $auth_id = $this->aauth->get_user()->id;
        $this->db->select('geopos_invoices.*,geopos_employees.name as pers_name,invoice_status.name as st_name,geopos_projects.code as proje_name,iptal_talep.user_id as iptal_pers,iptal_talep.desc as iptal_desc');
        $this->db->from('geopos_invoices');
        $this->db->join('geopos_employees','geopos_invoices.eid=geopos_employees.id','LEFT');
        $this->db->join('geopos_projects','geopos_invoices.proje_id=geopos_projects.id');
        $this->db->join('invoice_status','geopos_invoices.status=invoice_status.id');
        $this->db->join('iptal_talep','geopos_invoices.id=iptal_talep.islem_id');
        $this->db->where("iptal_talep.type",1);
        $this->db->where("iptal_talep.yetkili_status",0);

//        $this->db->where("geopos_invoices.status",1);

        $this->db->where("geopos_invoices.status!=",3);
        $i = 0;
        foreach ($this->column_searchf as $item) // loop column

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

                    if (count($this->column_searchf) - 1 == $i) //last loop

                        $this->db->group_end(); //close bracke
                }

                $i++;
            }


        }
        $this->db->order_by('`geopos_invoices`.`id` DESC');


//        $user_id = $this->aauth->get_user()->id;
//        $where='(geopos_invoices.invoice_type_id=29 or geopos_invoices.invoice_type_id=30)';
//        //$where='geopos_invoices.i_class=0 and (geopos_invoices.invoice_type_id=29 or geopos_invoices.invoice_type_id=30)';
//
//        $this->db->select('geopos_invoices.muqavele_no,geopos_invoices.forma2_notes,
//            geopos_invoices.proje_id,geopos_invoices.refer,geopos_invoices.invoice_no,geopos_invoices.id,
//            geopos_invoices.invoice_type_id,geopos_invoices.tid,geopos_invoices.invoicedate,geopos_invoices.invoiceduedate,
//            geopos_invoices.total,geopos_invoices.status,geopos_customers.company as name,geopos_invoices.para_birimi,
//            geopos_invoices.proje_sorumlu_id,geopos_invoices.proje_muduru_id,geopos_invoices.genel_mudur_id
//            ');
//
//        $this->db->join('geopos_projects','geopos_invoices.proje_id=geopos_projects.id','left');
//        $this->db->from($this->table);
//        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');
//        $this->db->where('geopos_invoices.bildirim_durumu=1');
//        $this->db->where('geopos_invoices.status=1');
//        $this->db->where("(geopos_invoices.proje_sorumlu_id=$user_id or geopos_invoices.proje_muduru_id=$user_id or  geopos_invoices.genel_mudur_id=$user_id)");
//        $this->db->where($where);
//
//
//
//
//
//        $i = 0;
//
//
//
//        foreach ($this->column_searchf as $item) // loop column
//
//        {
//
//            if ($_POST['search']['value']) // if datatable send POST for search
//
//            {
//
//
//
//                if ($i === 0) // first loop
//
//                {
//
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
//
//
//                if (count($this->column_searchf) - 1 == $i) //last loop
//
//                    $this->db->group_end(); //close bracket
//
//            }
//
//            $i++;
//
//        }
//
//
//
//        if (isset($_POST['order'])) // here order processing
//
//        {
//
//            $this->db->order_by($this->column_orderf[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
//
//        } else if (isset($this->orderf)) {
//
//            $order = $this->orderf;
//
//            $this->db->order_by('id','desc');
//
//        }


    }

    public function count_all_list_iptal($opt = '')

    {

        $this->_list_iptal();

        return $this->db->count_all_results();

    }

    public function count_filtered_list_iptal($opt = '')

    {

        $this->_list_iptal();

        if ($opt) {

            $this->db->where('geopos_invoices.eid', $opt);

        }



        $query = $this->db->get();

        return $query->num_rows();

    }



    public function invoice_details($id, $eid = '')

    {

        $this->db->select('geopos_invoices.*,SUM(geopos_invoices.shipping + geopos_invoices.ship_tax) AS shipping,geopos_customers.*,geopos_invoices.loc as loc,geopos_invoices.id AS iid,geopos_customers.id AS cid,geopos_terms.id AS termid,geopos_terms.title AS termtit,geopos_terms.terms AS terms');

        $this->db->from($this->table);

        $this->db->where('geopos_invoices.id', $id);



        $this->db->join('geopos_customers', 'geopos_invoices.csd = geopos_customers.id', 'left');

        $this->db->join('geopos_terms', 'geopos_terms.id = geopos_invoices.term', 'left');

        $query = $this->db->get();

        return $query->row_array();

    }


    public function invoice_products_forma2($id)

    {



        $this->db->select('geopos_invoice_items.*,geopos_units.name as unit_name');

        $this->db->from('geopos_invoice_items');
        $this->db->join('geopos_units', 'geopos_units.id=geopos_invoice_items.unit','LEFT');
        $this->db->where('geopos_invoice_items.tid', $id);

        $this->db->order_by('geopos_invoice_items.pid','ASC');

        $query = $this->db->get();

        return $query->result();


    }



    public function bildirim_olustur_forma2(){
        $talep_id=$this->input->post('invoice_id');
        $details=$this->db->query("SELECT * FROM geopos_invoices WHERE id=$talep_id")->row();
        $proje_name=proje_name($details->proje_id);
        $talep_no=$details->invoice_no;
        $proje_sorumlusu_id=$details->proje_sorumlu_id;

        $subject = 'Forma2 Onayı';
        $message = 'Sayın Yetkili ' . $proje_name.' - '.$talep_no . ' Numaralı Forma2 Oluşturuldu. Onay İşleminiz Beklenmektedir.';
        $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
        $firma_kodu=$dbnames['firma_kodu'];
        $validtoken = hash_hmac('ripemd160', 'p' . $talep_id, $this->config->item('encryption_key'));
        $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$talep_id&pers_id=$proje_sorumlusu_id&type=forma2onay&token=$validtoken";
        $message .="<br>İncelemek İçin Sisteme Giriş Yapınız. Bekleyen Talep Listesinde Görüntüleyebilirsiniz";
        $message .= "<br><br><br><br>";
        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
        $proje_sorumlusu_email = personel_detailsa($proje_sorumlusu_id)['email'];


        $recipients = array($proje_sorumlusu_email);

        $this->db->delete('geopos_onay', array('file_id' => $talep_id,'type'=>10));

        $this->db->set('bildirim_durumu', 1);
        $this->db->where('id', $talep_id);
        $this->db->update('geopos_invoices');


        $data_o= array(
            'product_id' => 0,
            'malzeme_items_id' => 0,
            'file_id' => $talep_id,
            'type' => 10);

        $this->db->insert('geopos_onay', $data_o);

        $this->onay_mailleri($subject, $message, $recipients, 'malzeme_talep_onay_maili');
        echo json_encode(array('status' => 'Success', 'message' =>'Başrıyla Onaya Sunulmuştur...', 'pstatus' => 'Başarılı'));
    }

    public function ajax_list_history($id)

    {
        $this->_ajax_list_history($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _ajax_list_history($id)

    {



        $this->db->select('invoice_history.*,geopos_employees.name as pers_name');
        $this->db->from('invoice_history');
        $this->db->join('geopos_employees','invoice_history.user_id=geopos_employees.id');
        $this->db->where('invoice_history.talep_id',$id);
        $i = 0;
        foreach ($this->column_search_history as $item) // loop column
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

                if (count($this->column_search_notes) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`invoice_history`.`id` DESC');

    }


    public function count_filtered_talep_history($id)
    {
        $this->_ajax_list_history($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_talep_history($id)
    {
        $this->_ajax_list_history($id);
        return $this->db->count_all_results();
    }

    public function create_new(){

        $muqavele_id_ = $this->input->post('razilastirma_id');
        $muqavele_details = $this->db->query("SELECT * FROM cari_razilastirma where id = $muqavele_id_")->row();


        $invoice_type = $this->input->post('invoice_type');
        $refer = $this->input->post('invoice_durumu');
        $method = $muqavele_details->odeme_sekli;
        $proje_id = $muqavele_details->proje_id;
        $customer_id = $muqavele_details->cari_id;
        $muqavele_no_new = $muqavele_details->muqavele_no;
        $tax_oran = $muqavele_details->tax_oran;
        $tax_status =  $muqavele_details->tax_status;


        $invoice_no = numaric(8);
        $invoicedate = $this->input->post('fis_date');
        $notes = $this->input->post('fis_note',true);
        $sorumlu_pers_id = $this->aauth->get_user()->id;
        $para_birimi = 1;
        $proje_sorumlu_id =proje_details($muqavele_details->proje_id)->proje_sorumlusu_id;
        $proje_muduru_id =proje_details($muqavele_details->proje_id)->proje_muduru_id;
        $genel_mudur_id =proje_details($muqavele_details->proje_id)->genel_mudur_id;

        $bill_date = datefordatabase($invoicedate);
        $data = array(
            'invoicedate' => $bill_date,
            'proje_sorumlu_id' => $proje_sorumlu_id,
            'proje_muduru_id' => $proje_muduru_id,
            'genel_mudur_id' => $genel_mudur_id,
            'invoice_type_id' => $invoice_type,
            'invoice_type_desc' => invoice_type_id($invoice_type),
            'notes' => $notes,
            'muqavele_no' => $muqavele_no_new,
            'csd' => $customer_id,
            'eid' => $this->aauth->get_user()->id,
            'sorumlu_pers_id' => $sorumlu_pers_id,
            'refer' => $refer,
            'invoice_no' => $invoice_no,
            'taxstatus' => $tax_status,
            'tax_oran' => $tax_oran,
            'loc' => $this->session->userdata('set_firma_id'),
            'method' => $method,
            'proje_id' => $proje_id,
            'para_birimi' => $para_birimi,
            'payer' => customer_details($customer_id)['company'],

        );
        if ($this->db->insert('geopos_invoices', $data)) {
            $last_id = $this->db->insert_id();
            $data_form = array(
                'muqavele_id' => $muqavele_id_,
                'forma_2_id' => $last_id,

            );
            $this->db->insert('forma_2_to_muqavele', $data_form);

            $productlist = [];
            $prodindex = 0;

            $price = $this->input->post('price');
            $item_task_id = $this->input->post('item_task_id');
            $qty = $this->input->post('qty');
            $item_desc = $this->input->post('item_desc');


            foreach ($item_task_id as $key=> $items){
                if($item_task_id[$key]!=0) {
                    $is_kalemi_details = is_kalemi_details($item_task_id[$key]);
                    $total = floatval($qty[$key])*floatval($price[$key]);
                    $bolum_id = asama_get($is_kalemi_details->asama_id)->bolum_id;



                    $data=[
                        'tid' => $last_id,
                        'pid'=>$item_task_id[$key],
                        'product'=>$is_kalemi_details->name,
                        'item_desc'=>$item_desc[$key],
                        'qty'=>$qty[$key],
                        'price'=>$price[$key],
                        'subtotal'=>$total,
                        'unit'=>$is_kalemi_details->unit,
                        'bolum_id' => $bolum_id,
                        'asama_id' => $is_kalemi_details->asama_id,
                        'invoice_type_id' => $invoice_type,
                        'proje_id' => $proje_id,
                        'invoice_type_desc' => invoice_type_id($invoice_type)
                    ];
                    $productlist[$prodindex] = $data;
                    $prodindex++;
                }

            }
            if ($prodindex > 0) {

                $this->db->insert_batch('geopos_invoice_items', $productlist);
                $this->db->insert_batch('geopos_project_items_gider', $productlist);


                $this->db->set(
                    array
                    (
                        'subtotal' => $this->input->post('net_tutar_db'),
                        'tax' => $this->input->post('kdv_tutar_db'),
                        'total' =>  $this->input->post('genel_tutar_db'),
                        'items' => 0
                    )
                );

                $this->db->where('id', $last_id);
                $this->db->update('geopos_invoices');


                $this->db->set(
                    array
                    (
                        'razi_status' =>3
                    )
                );

                $this->db->where('id', $muqavele_id_);
                $this->db->update('cari_razilastirma');

                numaric_update(8);

                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde Forma 2 Oluşturuldu',
                    'id'=>$last_id
                ];

            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Herhangi Bir İş Kalemi Bulunmamaktadır',
                ];
            }

        }
        else {
            return [
                'status'=>0,
                'message'=>'Forma 2 Oluştulurken Hata Aldınız',
            ];
        }


    }

    public function create_new_hizmet(){


        $talep_id = $this->input->post('talep_id'); //24
        $cari_id = $this->input->post('cari_id'); //26
        $muqavele_no_new = $this->input->post('nuqavele_no');
        //$tax_oran = $this->input->post('tax_oran');

        $talep_details = $this->db->query("SELECT * FROM talep_form where id = $talep_id")->row();
        $kdv_bilgileri = $this->db->query("SELECT * FROM talep_form_teklifler Where cari_id = $cari_id and form_id = $talep_id")->row();
        $tf_teklif_id = $this->db->query("SELECT * FROM talep_form_teklifler where form_id=$talep_id and cari_id=$cari_id")->row()->id;//12
        $odenis_bilgileri = $this->db->query("SELECT * FROM talep_form_teklifler_details where tf_teklif_id=$tf_teklif_id")->row();


        $invoice_type = 29;
        $refer = 2;
        $proje_id = $talep_details->proje_id;
        $method = $odenis_bilgileri->method; //3
        $tax_status =  $odenis_bilgileri->edv_durum;
        $tax_oran =  $odenis_bilgileri->kdv_oran;


        $customer_id = $cari_id;



        $invoice_no = numaric(8);
        $invoicedate = $this->input->post('fis_date');
        $notes = $this->input->post('fis_note',true);
        $sorumlu_pers_id = $this->aauth->get_user()->id;
        $para_birimi = 1;
        $proje_sorumlu_id =proje_details($proje_id)->proje_sorumlusu_id;
        $proje_muduru_id =proje_details($proje_id)->proje_muduru_id;
        $genel_mudur_id =proje_details($proje_id)->genel_mudur_id;

        $bill_date = datefordatabase($invoicedate);
        $data = array(
            'invoicedate' => $bill_date,
            'proje_sorumlu_id' => $proje_sorumlu_id,
            'proje_muduru_id' => $proje_muduru_id,
            'genel_mudur_id' => $genel_mudur_id,
            'invoice_type_id' => $invoice_type,
            'invoice_type_desc' => invoice_type_id($invoice_type),
            'notes' => $notes,
            'muqavele_no' => $muqavele_no_new,
            'csd' => $customer_id,
            'eid' => $this->aauth->get_user()->id,
            'sorumlu_pers_id' => $sorumlu_pers_id,
            'refer' => $refer,
            'invoice_no' => $invoice_no,
            'taxstatus' => $tax_status,
            'tax_oran' => $tax_oran,
            'loc' => $this->session->userdata('set_firma_id'),
            'method' => $method,
            'proje_id' => $proje_id,
            'para_birimi' => $para_birimi,
            'payer' => customer_details($customer_id)['company'],

        );
        if ($this->db->insert('geopos_invoices', $data)) {
            $last_id = $this->db->insert_id();
            $data_form = array(
                'muqavele_id' => $talep_id,
                'forma_2_id' => $last_id,

            );
            $this->db->insert('forma_2_to_ht', $data_form);
            $forma_2_ht_last_id = $this->db->insert_id();


            $productlist = [];
            $prodindex = 0;
            $inv_sub_total=0;
            $product_details = $this->input->post('product_details');
            $product_id = $this->input->post('product_id');
            $talep_form_product_id = $this->input->post('talep_form_product_id');
            $qty = $this->input->post('qty');

            $talep_form_product_id=[];
            foreach ($product_details as $key=> $items){
                if($items['qty']!=0) {
                    $tf_p_id=$items['talep_form_product_id'];

                    $details_items = $this->db->query("SELECT * FROM talep_form_products Where id=$tf_p_id")->row();
                    $siparis_son = $this->db->query("SELECT * FROM siparis_list_form_new where talep_form_product_id=$tf_p_id")->row();

                    $product_name= who_demirbas($items['product_id'])->name;

                    $total = floatval($items['qty'])*floatval($siparis_son->new_item_price);
                    $bolum_id = asama_get($talep_details->asama_id)->bolum_id;
                    $data=[
                        'tid' => $last_id,
                        'i_class'=>1,
                        'pid'=>$items['product_id'],
                        'product'=>$product_name,
                        'item_desc'=>$product_name,
                        'qty'=>$items['qty'],
                        'price'=>$siparis_son->new_item_price,
                        'subtotal'=>$total,
                        'unit'=>$details_items->unit_id,
                        'bolum_id' => $bolum_id,
                        'asama_id' => $talep_details->asama_id,
                        'invoice_type_id' => $invoice_type,
                        'proje_id' => $proje_id,
                        'invoice_type_desc' => invoice_type_id($invoice_type)
                    ];
                    $productlist[$prodindex] = $data;
                    $prodindex++;
                    $inv_sub_total+=$total;
                    $talep_form_product_id[]=$tf_p_id;


                }

            }
            if ($prodindex > 0) {

                $this->db->insert_batch('geopos_invoice_items', $productlist);
                $this->db->insert_batch('geopos_project_items_gider', $productlist);


                if(count($talep_form_product_id)){
                    foreach ($talep_form_product_id as $values){

                        $data = array(
                            'item_id'=>$values,
                            'ht_id' =>  $forma_2_ht_last_id
                        );
                        $this->db->insert('forma2_ht_items', $data);
                    }
                }



                $tax = floatval($inv_sub_total) * (floatval($tax_oran)/100);
                $this->db->set(
                    array
                    (
                        'subtotal' => $inv_sub_total,
                        'tax_oran' => $tax_oran,
                        'tax' => $tax,
                        'total' =>  floatval($tax)+floatval($inv_sub_total),
                        'items' => 0
                    )
                );

                $this->db->where('id', $last_id);
                $this->db->update('geopos_invoices');

                numaric_update(8);

                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde Forma 2 Oluşturuldu',
                    'id'=>$last_id
                ];

            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Miktar 0 dan büyük olmalıdır',
                ];
            }

        }
        else {
            return [
                'status'=>0,
                'message'=>'Forma 2 Oluştulurken Hata Aldınız',
            ];
        }


    }

    public function update_new(){
        $forma_2_id = $this->input->post('forma_2_id');
        $details = $this->invoice_details($forma_2_id);

        $muqavele_id_ =  $this->db->query("SELECT * FROM forma_2_to_muqavele Where forma_2_id = $forma_2_id")->row()->muqavele_id;
        $muqavele_details = $this->db->query("SELECT * FROM cari_razilastirma where id = $muqavele_id_")->row();


        $invoice_type = $this->input->post('invoice_type');
        $refer = $this->input->post('invoice_durumu');

        $method = $muqavele_details->odeme_sekli;
        $proje_id = $muqavele_details->proje_id;
        $customer_id = $muqavele_details->cari_id;
        $muqavele_no_new = $muqavele_details->muqavele_no;
        $tax_oran = $muqavele_details->tax_oran;
        $tax_status =  $muqavele_details->tax_status;


        $invoicedate = $this->input->post('fis_date');
        $notes = $this->input->post('fis_note',true);
        $sorumlu_pers_id = $this->aauth->get_user()->id;
        $para_birimi = 1;
        $proje_sorumlu_id =proje_details($muqavele_details->proje_id)->proje_sorumlusu_id;
        $proje_muduru_id =proje_details($muqavele_details->proje_id)->proje_muduru_id;
        $genel_mudur_id =proje_details($muqavele_details->proje_id)->genel_mudur_id;

        $bill_date = datefordatabase($invoicedate);
        $data_update = array(
            'invoicedate' => $bill_date,
            'proje_sorumlu_id' => $proje_sorumlu_id,
            'proje_muduru_id' => $proje_muduru_id,
            'genel_mudur_id' => $genel_mudur_id,
            'invoice_type_id' => $invoice_type,
            'invoice_type_desc' => invoice_type_id($invoice_type),
            'notes' => $notes,
            'muqavele_no' => $muqavele_no_new,
            'csd' => $customer_id,
            'eid' => $this->aauth->get_user()->id,
            'sorumlu_pers_id' => $sorumlu_pers_id,
            'refer' => $refer,
            'taxstatus' => $tax_status,
            'tax_oran' => $tax_oran,
            'loc' => $this->session->userdata('set_firma_id'),
            'method' => $method,
            'proje_id' => $proje_id,
            'para_birimi' => $para_birimi,
            'payer' => customer_details($customer_id)['company'],

        );

        $this->db->set($data_update);
        $this->db->where('id', $forma_2_id);
        if ($this->db->update('geopos_invoices', $data_update)) {


            $this->db->delete('geopos_invoice_items', array('tid' => $forma_2_id));
            $this->db->delete('geopos_project_items_gider', array('tid' => $forma_2_id));

            $productlist = [];
            $prodindex = 0;

            $price = $this->input->post('price');
            $item_task_id = $this->input->post('item_task_id');
            $qty = $this->input->post('qty');

            $item_desc = $this->input->post('item_desc');
            foreach ($item_task_id as $key=> $items){
                if($item_task_id[$key]!=0) {
                    $is_kalemi_details = is_kalemi_details($item_task_id[$key]);
                    $total = floatval($qty[$key])*floatval($price[$key]);
                    $bolum_id = asama_get($is_kalemi_details->asama_id)->bolum_id;
                    $data=[
                        'tid' => $forma_2_id,
                        'pid'=>$item_task_id[$key],
                        'item_desc'=>$item_desc[$key],
                        'product'=>$is_kalemi_details->name,
                        'qty'=>$qty[$key],
                        'price'=>$price[$key],
                        'subtotal'=>$total,
                        'unit'=>$is_kalemi_details->unit,
                        'bolum_id' => $bolum_id,
                        'asama_id' => $is_kalemi_details->asama_id,
                        'invoice_type_id' => $invoice_type,
                        'proje_id' => $proje_id,
                        'invoice_type_desc' => invoice_type_id($invoice_type)
                    ];
                    $productlist[$prodindex] = $data;
                    $prodindex++;
                }

            }
            if ($prodindex > 0) {

                $this->db->insert_batch('geopos_invoice_items', $productlist);
                $this->db->insert_batch('geopos_project_items_gider', $productlist);


                $this->db->set(
                    array
                    (
                        'subtotal' => $this->input->post('net_tutar_db'),
                        'tax' => $this->input->post('kdv_tutar_db'),
                        'total' =>  $this->input->post('genel_tutar_db'),
                        'items' => 0
                    )
                );

                $this->db->where('id', $forma_2_id);
                $this->db->update('geopos_invoices');


                $this->db->set(
                    array
                    (
                        'razi_status' =>3
                    )
                );

                $this->db->where('id', $muqavele_id_);
                $this->db->update('cari_razilastirma');

                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde Forma 2 Güncellendi',
                    'id'=>$forma_2_id
                ];

            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Herhangi Bir İş Kalemi Bulunmamaktadır',
                ];
            }

        }
        else {
            return [
                'status'=>0,
                'message'=>'Forma 2 Oluştulurken Hata Aldınız',
            ];
        }


    }


    public function file_details($id){
        $this->db->select('*');
        $this->db->from('invoices_file');
        $this->db->where('invoices_id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function cancel_talep()
    {
        $desc = $this->input->post('desc');
        $id = $this->input->post('foma2_id');
        $user =personel_details($this->aauth->get_user()->id);


        $details = $this->invoice_details($id);
        $kontrol= $this->db->query("SELECT * FROM iptal_talep WHERE islem_id=$id and yetkili_status=0")->num_rows();

        if(!$kontrol){
            $message=$details['invoice_no'].' Kodlu Forma 2 ye '.$user.' Tarafından İptal Talebi Oluşturuldu.Açıklama : '.$desc;
            $data = array(
                'islem_id'=>$id,
                'type'=>1, //forma 2 iptal talebi
                'desc'=>$desc,
                'user_id' => $this->aauth->get_user()->id,
                'loc' =>  $this->session->userdata('set_firma_id'),
            );
            if ($this->db->insert('iptal_talep', $data)) {
                $last_id = $this->db->insert_id();

                $this->talep_history($id,$this->aauth->get_user()->id,'iptal Talebi Oluşturuldu.Açıklama : '.$desc,1);


                $this->send_mail(39,'Forma 2 İptal Talebi', $message);
                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir İptal Talebiniz Oluşturuldu',
                ];
            }
            else{
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız',
                ];
            }
        }
        else{
            return [
                'status'=>0,
                'message'=>'İncelemede Olan İptal Talebi Bulunmaktadır.',
            ];
        }

    }

    public function cancel_post($foma2_id,$desc){


        $foma2_id = $this->input->post('foma2_id');
        $eid = $this->invoice_details($foma2_id)['eid'];
        $desc = $this->input->post('desc');
        $this->db->set('status', 3);
        $this->db->set('pers_notes',"$desc");
        $this->db->set('updated_user_id',$this->aauth->get_user()->id);
        $this->db->where('id', $foma2_id);

        if($this->db->update('geopos_invoices')){
            $this->aauth->applog("Forma2 İptal Edildi ID ".$foma2_id,$this->aauth->get_user()->username);
            $this->talep_history($foma2_id,$this->aauth->get_user()->id,'iptal Edildi'.$desc,1);
            $this->db->set('invoice_id',NULL);
            $this->db->where('invoice_id', $foma2_id);
            $this->db->update('geopos_invoice_transactions');

            $this->db->delete('firma_gider', array('talep_id' => $foma2_id,'type'=>5));
            $this->db->delete('geopos_project_items_gider', array('tid' => $foma2_id));

            $this->send_mail($eid,'Forma 2 İptal', $desc);


            return 1;
        }
        else{

            return  0;
        }

    }




    public function cancel_talep_return()
    {
        $yetkili_text = $this->input->post('yetkili_text');
        $yetkili_status = $this->input->post('yetkili_status');
        $id = $this->input->post('foma2_id');
        $user =personel_details($this->aauth->get_user()->id);
        $details = $this->invoice_details($id);
        $kontrol= $this->db->query("SELECT * FROM iptal_talep WHERE islem_id=$id and yetkili_status=0");

        if($kontrol->num_rows()){
            $iptal_taleo_id = $kontrol->row()->id;
            $talep_acan_id = $kontrol->row()->user_id;

            $message=$details['invoice_no'].' Kodlu Forma 2 ye '.$user.' Tarafından Cevap Verildi.Açıklama : '.$yetkili_text;

            $this->db->set('yetkili_status', $yetkili_status);
            $this->db->set('yetkili_text', $yetkili_text);
            $this->db->where('id', $iptal_taleo_id);
            if ($this->db->update('iptal_talep')) {

                if($yetkili_status==1){
                   $ret =  $this->cancel_post($id,$yetkili_text);
                }

                $this->talep_history($id,$this->aauth->get_user()->id,'iptal Talebine Bildirim Oluşturdu.Açıklama : '.$yetkili_text,1);


                $this->send_mail($talep_acan_id,'Forma 2 İptal Talebine Cevap', $message);
                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir İptal Talebiniz Oluşturuldu',
                ];
            }
            else{
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız',
                ];
            }
        }
        else{
            return [
                'status'=>0,
                'message'=>'İncelemede Olan İptal Talebi Bulunmaktadır.',
            ];
        }

    }

    public function send_mail($user_id,$subject,$message){
        $this->load->model('communication_model');
        $message .= "<br><br><br><br>";
        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
        $proje_sorumlusu_email = personel_detailsa($user_id)['email'];
        $recipients = array($proje_sorumlusu_email);
        $this->communication_model->onay_mail($recipients, $subject, $message, false,'', 'gider_talep_onay_maili');
        return 1;
    }

    public function talep_history($id,$user_id,$desc,$type=1){
        $data_step = array(
            'talep_id' => $id,
            'user_id' => $user_id,
            'desc' => $desc,
            'type' => $type,
        );
        $this->db->insert('invoice_history', $data_step);

    }


}

