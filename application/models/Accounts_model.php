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





class Accounts_model extends CI_Model

{

    var $table = 'geopos_accounts';


    var $table_news = 'geopos_invoices';

    var $column_order = array('invoicedate', 'account', 'geopos_account_type.name', 'invoice_type_desc');

    var $column_search = array('invoicedate','account', 'geopos_account_type.name', 'invoice_type_desc','total');

    var $order = array('invoicedate' => 'DESC');

    var $opt = '';



    public function __construct()

    {

        parent::__construct();

    }



    public function accountslist()

    {

        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status', 1);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        $id = $this->aauth->get_user()->id;
        $roleid = $this->aauth->get_user()->roleid;


        if ($this->aauth->premission(27)->read) {

        }
        else {
            if ($this->aauth->premission(65)->read) {
                $this->db->where('eid', $id);
            }
            else {
                $this->db->where('eid', 0);
            }

        }


        $query = $this->db->get();
        return $query->result_array();
    }



    public function details($acid)

    {



        $this->db->select('*');

        $this->db->from('geopos_accounts');

        $this->db->where('id', $acid);

        if ($this->aauth->get_user()->loc) {

            $this->db->group_start();

            $this->db->where('loc', $this->aauth->get_user()->loc);

            $this->db->or_where('loc', 0);

            $this->db->group_end();

        }

        $query = $this->db->get();

        return $query->row_array();

    }



    public function addnew($accno, $holder, $acode, $lid,$kasa_tipi,$para_birimi,$eid)

    {

        $data = array(

            'acn' => $accno,

            'holder' => $holder,

            'adate' => date('Y-m-d H:i:s'),

            'code' => $acode,

            'loc' => $lid,
            'account_type' => $kasa_tipi,
            'para_birimi' => $para_birimi,
            'eid' => $eid,

        );



        if ($this->db->insert('geopos_accounts', $data)) {

            $last_id=$this->db->insert_id();
            $this->aauth->applog("Kasa Açıldı $accno  ID ".$last_id,$this->aauth->get_user()->username);

            kont_kayit(14,$last_id);

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('ADDED')."  <a href='add' class='btn btn-indigo btn-lg'><span class='fa fa-plus' aria-hidden='true'></span>  </a>"));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }



    public function edit($acid, $accno, $holder, $acode, $lid,$kasa_tipi,$para_birimi,$eid)

    {

        $data = array(

            'acn' => $accno,

            'holder' => $holder,

            'code' => $acode,

            'loc' => $lid,
            'account_type' => $kasa_tipi,
            'para_birimi' => $para_birimi,
            'eid' => $eid,

        );





        $this->db->set($data);

        $this->db->where('id', $acid);



        if ($this->db->update('geopos_accounts')) {

            $this->aauth->applog("[Kasa Düzenlendi] $accno - ID ".$acid,$this->aauth->get_user()->username);

            kont_kayit(15,$acid);
            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }



    public function account_stats()

    {

        $whr=' ';

        if ($this->aauth->get_user()->loc) {

            $whr=" WHERE
             geopos_invoice_type.type_value = 'transaction'
             and geopos_invoices.acid is not null and   geopos_invoices.loc=".$this->aauth->get_user()->loc;

        }



        //$query = $this->db->query("SELECT SUM(lastbal) AS balance,COUNT(id) AS count_a FROM geopos_accounts $whr");



        $bakiye=0;
        $query = $this->db->query("SELECT geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoices.acid,geopos_invoices.para_birimi,
IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi, IF(geopos_invoice_type.transactions='income',
geopos_invoices.total,0) as borc, IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,0) as alacak,
 geopos_invoices.total, geopos_invoice_type.transactions FROM geopos_invoices INNER JOIN geopos_invoice_type on
 geopos_invoices.invoice_type_id=geopos_invoice_type.id  $whr");

        $row = $query->result_array();
        foreach ($row as $rows)
        {
            if($rows['para_birimi']!=1)
            {
                $gelen_para_birimi = hesap_getir($rows['acid'])->para_birimi;
                $gelen_kur=para_birimi_id($gelen_para_birimi)['rate'];

                $bakiye+=($rows['alacak']*$gelen_kur)-($rows['borc']*$gelen_kur);
            }
            else
            {
                $bakiye+=$rows['alacak']-$rows['borc'];
            }

        }


        $data=array( array
        (
            'balance'=>amountFormat($bakiye),
            'count_a'=>account_count($this->aauth->get_user()->loc)
        )

        );




        echo json_encode($data);
        // echo json_encode($query->result_array());



    }

    public function devir_bakiye($id)
    {

        if (($this->input->post('start_date') && $this->input->post('end_date') ) || $_POST['start']>0) // if datatable send POST for search
        {
            $bakiye=0;
            $bakiyes=0;
            $where='';
            $limit='';


            $d=datefordatabasefilter($this->input->post('start_date'));
            $query1 = $this->db->query("SELECT geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoices.kur_degeri,
IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi, IF(geopos_invoice_type.transactions='income',
geopos_invoices.total,0) as borc, IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,0) as alacak,
 geopos_invoices.total, geopos_invoice_type.transactions FROM geopos_invoices LEFT JOIN geopos_invoice_type on
 geopos_invoices.invoice_type_id=geopos_invoice_type.id WHERE geopos_invoices.acid=$id and
 geopos_invoices.invoice_type_id NOT IN(21,1,2,7,8,9,10,11,13,15,16,22,23,24,26,29,30,31,32,34,53) AND  DATE(geopos_invoices.invoicedate) <'$d'  ORDER BY
 `geopos_invoices`.`invoicedate` ASC");



            $rowss = $query1->result_array();
            foreach ($rowss as $rows)
            {
                $bakiyes+=($rows['alacak']*$rows['kur_degeri'])-($rows['borc']*$rows['kur_degeri']);
            }


            if($this->input->post('start_date') && $_POST['start']==0)
            {

                $d=datefordatabasefilter($this->input->post('start_date'));
                $d1=datefordatabasefilter($this->input->post('end_date'));
                //$where.="AND DATE(geopos_invoices.invoicedate) >'$d'";  //2019-11-24 14:28:57
                $where.="AND DATE(geopos_invoices.invoicedate) <'$d'";  //2019-11-24 14:28:57
            }


            else if($this->input->post('start_date') && $_POST['start'] > 0)
            {



                $bakiye+=$bakiyes;

                $d=datefordatabasefilter($this->input->post('start_date'));
                $d1=datefordatabasefilter($this->input->post('end_date'));
                $where.="AND DATE(geopos_invoices.invoicedate) >='$d'";  //2019-11-24 14:28:57>=
                $where.="AND DATE(geopos_invoices.invoicedate) <='$d1'";  //2019-11-24 14:28:57 >=

                $str=$_POST['start'];
                $limit="LIMIT $str";

                // $this->db->limit($_POST['length'], $_POST['start']);
            }

            else  if($_POST['start']>0)
            {

                $str=$_POST['start'];
                $limit="LIMIT $str";

                // $this->db->limit($_POST['length'], $_POST['start']);
            }







            $query = $this->db->query("SELECT geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoices.kur_degeri,
IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi, IF(geopos_invoice_type.transactions='income',
geopos_invoices.total,0) as borc, IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,0) as alacak,
 geopos_invoices.total, geopos_invoice_type.transactions FROM geopos_invoices LEFT JOIN geopos_invoice_type on
 geopos_invoices.invoice_type_id=geopos_invoice_type.id WHERE geopos_invoices.acid=$id and
 geopos_invoices.invoice_type_id NOT IN(21,1,2,7,8,9,10,11,13,15,16,22,23,24,26,29,30,31,32,34,53) $where ORDER BY
 `geopos_invoices`.`invoicedate` ASC $limit");



            $row = $query->result_array();
            foreach ($row as $rows)
            {
                $bakiye+=($rows['alacak']*$rows['kur_degeri'])-($rows['borc']*$rows['kur_degeri']);
            }

            return $bakiye;
            // echo $bakiye;

        }





    }

    public function get_datatables_details_razi($id)

    {



        $this->_get_datatables_query_details_razi($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _get_datatables_query_details_razi($id)

    {

        $this->db->select('geopos_invoices.*,geopos_invoices.id as trns_id,geopos_employees.name as pers_name');

        $this->db->from('geopos_invoices');
        // $where = "invoice_type_id IN (3,4,12,14,17,18,19,20,25,27,28,33)";
        //$type=array(21,1,2,7,8,9,10,11,13,15,16,22,23,24,26,29,30,31,32,34);
        $type=array(49);
        //$this->db->where($where);

        $this->db->where_in('geopos_invoices.invoice_type_id',$type);
        $this->db->where('geopos_invoices.acid',$id);
        $this->db->where('geopos_employees.firma_durumu','Razı');

        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where("DATE(geopos_invoices.invoicedate) >=",datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where("DATE(geopos_invoices.invoicedate) <=",datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
        }



        $this->db->join('geopos_account_type','geopos_invoices.method=geopos_account_type.id','LEFT');
        $this->db->join('geopos_employees','geopos_invoices.csd=geopos_employees.id','INNER');



        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_invoices.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
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

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        $this->db->order_by('`geopos_invoices`.`invoicedate` DESC');





    }



    private function _get_datatables_query_details($id)

    {

        $this->db->select('geopos_invoices.*,geopos_invoices.id as trns_id');

        $this->db->from('geopos_invoices');
        // $where = "invoice_type_id IN (3,4,12,14,17,18,19,20,25,27,28,33)";
        $type=array(21,1,2,7,8,9,10,11,13,15,16,22,23,24,26,29,30,31,32,34,54,55,57,42,62,63,53);
        //$this->db->where($where);

        $this->db->where_not_in('geopos_invoices.invoice_type_id',$type);
        $this->db->where('geopos_invoices.acid',$id);

        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where("DATE(geopos_invoices.invoicedate) >=",datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where("DATE(geopos_invoices.invoicedate) <=",datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
        }

        if ($this->aauth->premission(17)->read) {

        }
        else {
            if ($this->aauth->premission(64)->read) {
                $this->db->where('geopos_invoices.eid', $this->aauth->get_user()->id);
            }
            else {
                $this->db->where('geopos_invoices.eid', 0);
            }

        }

        $this->db->join('geopos_account_type','geopos_invoices.method=geopos_account_type.id','LEFT');


        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_invoices.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
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

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        $this->db->order_by('`geopos_invoices`.`invoicedate` DESC');





    }



    public function get_datatables_details($id)

    {



        $this->_get_datatables_query_details($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }



    public function count_filtered($id)

    {

        $this->_get_datatables_query_details($id);

        $query = $this->db->get();



        return $query->num_rows();

    }


    public function count_filtered_razi($id)

    {

        $this->_get_datatables_query_details_razi($id);

        $query = $this->db->get();



        return $query->num_rows();

    }

    public function count_all_razi($id)

    {

        $this->_get_datatables_query_details_razi($id);



        return $this->db->count_all_results();

    }




    public function count_all($id)

    {

        $this->_get_datatables_query_details($id);



        return $this->db->count_all_results();

    }



}
