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





class Raporlar_model extends CI_Model

{
    var $column_order = array('geopos_employees.name','salary_report.hesaplama_ayi','salary_report.odenilecek_meblaq');

    var $column_search = array('geopos_employees.name','salary_report.hesaplama_ayi','salary_report.odenilecek_meblaq');
    var $order = array('salary_report.id' => 'DESC');
    public function __construct()

    {

        parent::__construct();

    }


    function ajax_razi_report($m=0,$y=0)

    {

        $this->ajax_razi_report_(floatval($m),floatval($y));


        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

//        echo $this->db->last_query();
//        die();

        return $query->result();

    }

    private function ajax_razi_report_($m,$y)

    {


        $date = new DateTime('now');

        if($m==0){
            $m= $date->format('m');
            $y= $date->format('Y');
        }



        $this->db->select('salary_report.*,geopos_employees.name');
        $this->db->from("salary_report");
        $this->db->join("geopos_employees","geopos_employees.id=salary_report.personel_id");
        $this->db->where('salary_report.hesaplama_ayi',intval($m));
        $this->db->where('salary_report.hesaplama_yili',intval($y));
        $this->db->where('salary_report.salary_type',3);


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



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else {

            $this->db->order_by('salary_report.id','DESC');

        }





    }

    public function ajax_razi_report_filter($m=0,$y=0)

    {

        $this->ajax_razi_report_($m,$y);


        $query = $this->db->get();

        return $query->num_rows();

    }

    public function ajax_razi_report_count($m=0,$y=0)

    {

        $this->ajax_razi_report_($m,$y);


        return $this->db->count_all_results();

    }


    function ajax_avans_report($m=0,$y=0)

    {

        $this->ajax_avans_report_(floatval($m),floatval($y));


        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

//        echo $this->db->last_query();
//        die();

        return $query->result();

    }

    private function ajax_avans_report_($m,$y)

    {


        $date = new DateTime('now');

        if($m==0){
            $m= $date->format('m');
            $y= $date->format('Y');
        }



        $this->db->select('salary_report.*,geopos_employees.name');
        $this->db->from("salary_report");
        $this->db->join("geopos_employees","geopos_employees.id=salary_report.personel_id");
        $this->db->where('salary_report.hesaplama_ayi',intval($m));
        $this->db->where('salary_report.hesaplama_yili',intval($y));
        $this->db->where('salary_report.toplam_avans>0');


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



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else {

            $this->db->order_by('salary_report.id','DESC');

        }





    }

    public function ajax_avans_report_filter($m=0,$y=0)

    {

        $this->ajax_avans_report_($m,$y);


        $query = $this->db->get();

        return $query->num_rows();

    }

    public function ajax_avans_report_count($m=0,$y=0)

    {

        $this->ajax_avans_report_($m,$y);


        return $this->db->count_all_results();

    }


    function ajax_edit_report()

    {

        $this->ajax_edit_report_();


        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

//        echo $this->db->last_query();
//        die();

        return $query->result();

    }

    private function ajax_edit_report_()

    {
        $this->db->select('salary_edit_table.*,geopos_employees.name,salary_report.hesaplama_ayi,salary_report.hesaplama_yili');
        $this->db->from("salary_edit_table");
        $this->db->join("salary_report","salary_report.id=salary_edit_table.rep_id");
        $this->db->join("geopos_employees","geopos_employees.id=salary_report.personel_id");
        $this->db->where('salary_edit_table.status=1');


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



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else {

            $this->db->order_by('salary_report.id','DESC');

        }





    }

    public function ajax_edit_report_filter()

    {

        $this->ajax_edit_report_();


        $query = $this->db->get();

        return $query->num_rows();

    }

    public function ajax_edit_report_count()

    {

        $this->ajax_edit_report_();


        return $this->db->count_all_results();

    }

    public function ajax_kdv_bekleyen_faturalar(){
        $this->_ajax_kdv_bekleyen_faturalar();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();

    //        echo $this->db->last_query();
    //        die();
        return $query->result();

    }

    public function _ajax_kdv_bekleyen_faturalar(){
        $this->db->select('*');
        $this->db->from("geopos_invoices");
        $this->db->where('geopos_invoices.status=2');
        $this->db->where('geopos_invoices.invoice_type_id=2');


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



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else {
            $this->db->order_by('salary_report.id','DESC');
        }

    }


    public function kdv_bekleyen_filter()

    {

        $this->_ajax_kdv_bekleyen_faturalar();


        $query = $this->db->get();

        return $query->num_rows();

    }

    public function kdv_bekleyen_count()

    {

        $this->_ajax_kdv_bekleyen_faturalar();


        return $this->db->count_all_results();

    }

    public function bordro_edit_count(){
        $count=0;
        $id=$this->aauth->get_user()->id;
        $salart_details = $this->db->query("SELECT * FROM `salary_edit_table`  Where status = 1 and aauth_id=$id");

        if($salart_details->num_rows()>0){
            $count =$salart_details->num_rows();

        }
        else {
            $count = 0;
        }

        return [
            'status'=>1,
            'count'=>$count
        ];
    }
}
