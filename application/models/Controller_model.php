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





class Controller_model extends CI_Model

{

    var $table = 'geopos_controller';

    var $column_order = array('talep_no','kayit_tarihi','kullanici_id','islem_tipi','islem_id','aciklama','cont_status','cont_pers_id', 'cont_kabul_date');

    var $column_search = array('talep_no','islem_tipi', 'kayit_tarihi', 'aciklama', 'cont_kabul_date');

    var $column_order_envanter = array('proje','departman','personel','product','price');

    var $column_search_envanter = array('proje','departman','personel','product','price');

    var $order = array('id' => 'DESC');


    var $column_search_takip = array('geopos_projects.name','geopos_employees.name');

    var $column_order_takip = array('id','geopos_employees.proje_id','geopos_employees.name','personel_salary.salary','gun_say','gun_say');

    var $column_search_takip_bordro = array('geopos_projects.name','geopos_employees.name');

    var $column_order_takip_bordro = array('id','geopos_employees.proje_id','geopos_employees.name','salary_report.salary','is_gunu','calisilan_gun_sayisi_');




    var $column_search_salary_odenis = array('salary_report.id','geopos_employees.name','salary_report.hesaplama_ayi','salary_report.salary','salary_type.name','cemi','dsmf_isveren','issizlik_isveren','icbari_sigorta_isveren','dsmf_isci','issizlik_isci','icbari_sigorta_isci','gelir_vergisi','odenilecek_meblaq','banka_avans','nakit_avans','banka_hakedis','nakit_hakedis','odenisli_izin_count','oz_hesabina_count','salary_type.name');

    var $column_order_salary_odenis = array('salary_report.id','geopos_employees.name','salary_report.hesaplama_ayi','salary_report.salary','salary_type.name','cemi','dsmf_isveren','issizlik_isveren','icbari_sigorta_isveren','dsmf_isci','issizlik_isci','icbari_sigorta_isci','gelir_vergisi','odenilecek_meblaq','banka_avans','nakit_avans','banka_hakedis','nakit_hakedis','odenisli_izin_count','oz_hesabina_count','salary_type.name');




    var $column_search_salary = array('salary_report.salary','salary_report.banka_hesaplanan');

    var $column_order_salary = array('salary_report.salary','salary_report.banka_hesaplanan');

    var $column_search_job = array('employee_start_job.created_at','employee_start_job.staff_id');

    var $column_order_job = array('employee_start_job.created_at','employee_start_job.staff_id');


    var $opt = '';

    var $column_search_holidays = array('date','description');

    var $column_order_holidays = array('id','date','description');



    public function __construct()

    {

        parent::__construct();

    }





    function get_datatables_holidays($opt = '')

    {

        $this->_get_datatables_holidays($opt);


        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();

    }

    private function _get_datatables_holidays($opt = '')

    {


        $this->db->select('*');
        $this->db->from("holidays");
        $this->db->where('deleted_at IS  NULL', null, false);

        if($this->input->post('start_date')){
            $this->db->where('month',$this->input->post('start_date'));
        }
        if($this->input->post('hesap_yil')){
            $this->db->where('year',$this->input->post('hesap_yil'));
        }

        if($this->session->userdata('set_firma_id')){
            $this->db->where('holidays.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        $i = 0;

        foreach ($this->column_search_holidays as $item) // loop column
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



                if (count($this->column_search_holidays) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order_holidays[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else {

            $this->db->order_by('holidays.id','DESC');

        }





    }

    public function count_holidays_filtered($opt = '')

    {

        $this->_get_datatables_holidays($opt);


        $query = $this->db->get();

        return $query->num_rows();

    }

    public function count_holidays_all($opt = '')

    {

        $this->_get_datatables_holidays($opt);


        return $this->db->count_all_results();

    }

    function get_datatables_personel_job($opt = '')

    {

        $this->_get_datatables_personel_job($opt);


        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

//       echo $this->db->last_query();
//        die();

        return $query->result();

    }



    private function _get_datatables_personel_job($opt = '')

    {


        $hesaplama_ayi=$this->input->post('hesaplama_ayi');

        $date = new DateTime('now');
        $y= $date->format('Y');
        if($this->input->post('hesaplama_yili')){
            $y=$this->input->post('hesaplama_yili');
        }

        $total_ay_sayisi = cal_days_in_month( CAL_GREGORIAN,intval($hesaplama_ayi), $y);
        $date_E = $y.'-'.$hesaplama_ayi.'-'.$total_ay_sayisi.' 00:00:00';
        $date_S = $y.'-'.$hesaplama_ayi.'-01 00:00:00';

        $this->db->select('*');
        $this->db->from("employee_start_job");


        if ($this->input->post('hesaplama_ayi')) // if datatable send POST for search
        {
            $this->db->where('DATE(employee_start_job.created_at) >=', $date_S); //2019-11-23 14:28:57
            $this->db->where('DATE(employee_start_job.created_at) <=', $date_E);  //2019-11-24 14:28:57


        }
        $this->db->where('user_id=',$this->input->post('personel_id'));
        $this->db->where('deleted_at IS  NULL', null, false);

        $i = 0;

        foreach ($this->column_search_job as $item) // loop column

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



                if (count($this->column_search_job) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order_job[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else {

            $this->db->order_by('employee_start_job.id','DESC');

        }





    }



    public function count_personel_job_filter_($opt = '')

    {

        $this->_get_datatables_personel_job($opt);


        $query = $this->db->get();

        return $query->num_rows();

    }

    public function count_personel_job_all_($opt = '')

    {

        $this->_get_datatables_personel_job($opt);


        return $this->db->count_all_results();

    }

    public function count_personel_bordro_all_odenis_filter($opt = '')

    {

        $this->_get_datatables_personel_bordro_odenis($opt);


        $query = $this->db->get();

        return $query->num_rows();

    }

    public function count_personel_bordro_all_odenis($opt = '')

    {

        $this->_get_datatables_personel_bordro_odenis($opt);


        return $this->db->count_all_results();

    }



    function get_datatables_personel_salary($opt = '')

    {

        $this->_get_datatables_personel_salary($opt);


        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();

    }

    private function _get_datatables_personel_salary($opt = '')

    {



        $this->db->select('salary_report.*,geopos_projects.name as proje_name');
        $this->db->from("salary_report");


        $this->db->join('geopos_projects', 'salary_report.proje_id=geopos_projects.id');
        $this->db->join('salary_onay', 'salary_report.id=salary_onay.salary_report_id');
        if ($this->input->post('proje_id')) // if datatable send POST for search
        {
            $this->db->where_in('salary_report.proje_id', $this->input->post('proje_id')); //2019-11-23 14:28:57

        }

        if ($this->input->post('hesaplama_ayi')) // if datatable send POST for search
        {
            $this->db->where('salary_report.hesaplama_ayi', $this->input->post('hesaplama_ayi')); //2019-11-23 14:28:57

        }
        //$this->db->where('(salary_report.bank_payment_status = 0 or salary_report.cache_payment_status= 0)');
        $this->db->where('(salary_onay.banka_status = 0 or salary_onay.nakit_status=0)');
        $i = 0;


        foreach ($this->column_search_salary as $item) // loop column

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



                if (count($this->column_search_salary) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order_salary[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else {

            $this->db->order_by('salary_report.id','DESC');

        }

        $this->db->group_by('salary_report.personel_id');



    }


    public function count_personel_salary_filter_($opt = '')

    {

        $this->_get_datatables_personel_salary($opt);


        $query = $this->db->get();

        return $query->num_rows();

    }

    public function count_personel_salary_all_($opt = '')

    {

        $this->_get_datatables_personel_salary($opt);


        return $this->db->count_all_results();

    }




    //bordro


    function get_datatables_personel_bordro($opt = '')

    {

        $this->_get_datatables_personel_bordro($opt);


        if ($_POST['length'] != -1)

        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();


        return $query->result();

    }

    public function _get_datatables_personel_bordro_odenis_count()
    {
        $id = $this->aauth->get_user()->id;
        $yetkili_id=[];
        $hesaplama_ayi=0;
        $hesaplama_yili=0;
        $kontrol_details = $this->db->query("SELECT * FROM salary_odeme_kontrol Where user_id = $id and status = 0 GROUP BY proje_id");
        if($kontrol_details->num_rows()){
            foreach ($kontrol_details->result() as $kontrol_items){
                $proje_id =$kontrol_items->proje_id;
                $sort_kontrol = $this->db->query("SELECT * FROM `maas_onay_sort` Where proje_id = $proje_id ORDER BY `maas_onay_sort`.`sort` DESC LIMIT 1");
                if ($sort_kontrol->num_rows()) {
                    $yetkili_id = $sort_kontrol->row()->user_id;
                    $hesaplama_ayi = $kontrol_items->hesaplama_ayi;
                    $hesaplama_yili = $kontrol_items->hesaplama_yili;
                }
            }
        }
        $this->db->select('salary_report.*,salary_type.name as salary_type_name,personel_salary.bank_salary,
         salary_onay.banka_status as bank_payment_status, salary_onay.nakit_status as cache_payment_status,geopos_projects.name as proje_name');
        $this->db->from("salary_report");


        $this->db->join('geopos_projects', 'salary_report.proje_id=geopos_projects.id');
        $this->db->join('geopos_employees', 'salary_report.personel_id=geopos_employees.id');
        $this->db->join('salary_onay', 'salary_report.id=salary_onay.salary_report_id');
        $this->db->join('salary_type', 'salary_report.salary_type=salary_type.id','LEFT');
        $this->db->join('personel_salary', 'salary_report.personel_id=personel_salary.personel_id','LEFT');
        /*$this->db->where_in('salary_onay.user_id',39);
        $this->db->where('personel_salary.status',1);
        $this->db->where('salary_report.hesaplama_ayi',4);
        $this->db->where('salary_report.hesaplama_yili',2022);*/

        if($yetkili_id){
            $this->db->where_in('salary_onay.user_id',$yetkili_id);
        }

        $this->db->where('personel_salary.status',1);
        $this->db->where('salary_report.hesaplama_ayi',$hesaplama_ayi);
        $this->db->where('salary_report.hesaplama_yili',$hesaplama_yili);



        if ($this->input->post('status')) // if datatable send POST for search
        {
            $this->db->where('(salary_report.cache_pay_odenis = 0 or salary_report.bank_pay_odenis = 0)');
            $this->db->where('(salary_onay.nakit_status = 1 or salary_onay.banka_status = 1)');
            // $this->db->where('pay_set_id',$this->aauth->get_user()->id);

        }
        else {
            $this->db->where('(salary_onay.nakit_status = 0 or salary_onay.banka_status = 0)');
        }





        if ($this->input->post('proje_id')) // if datatable send POST for search
        {
            $this->db->where_in('salary_report.proje_id', $this->input->post('proje_id')); //2019-11-23 14:28:57

        }
        $this->db->order_by('salary_report.id','DESC');
        $query = $this->db->get();
        return $query->num_rows();





    }

    private function _get_datatables_personel_bordro_odenis($opt = '')

    {

        $id = $this->aauth->get_user()->id;
        $yetkili_id=[];
        $hesaplama_ayi=[];
        $hesaplama_yili=0;

        $kontrol_details = $this->db->query("SELECT * FROM salary_odeme_kontrol Where user_id = $id and status = 0 GROUP BY proje_id");
        if($kontrol_details->num_rows()){
            foreach ($kontrol_details->result() as $kontrol_items){
                $proje_id =$kontrol_items->proje_id;
                $sort_kontrol = $this->db->query("SELECT * FROM `maas_onay_sort` Where proje_id = $proje_id ORDER BY `maas_onay_sort`.`sort` DESC LIMIT 1");
                if ($sort_kontrol->num_rows()) {
                    $yetkili_id = $sort_kontrol->row()->user_id;
                    $hesaplama_ayi[] = $kontrol_items->hesaplama_ayi;
                    $hesaplama_yili = $kontrol_items->hesaplama_yili;
                }
            }
        }
        $this->db->select('salary_report.*,salary_type.name as salary_type_name,personel_salary.bank_salary,
         salary_onay.banka_status as bank_payment_status, salary_onay.nakit_status as cache_payment_status,geopos_projects.name as proje_name');
        $this->db->from("salary_report");
        $this->db->join('geopos_projects', 'salary_report.proje_id=geopos_projects.id');
        $this->db->join('geopos_employees', 'salary_report.personel_id=geopos_employees.id');
        $this->db->join('salary_onay', 'salary_report.id=salary_onay.salary_report_id');
        $this->db->join('salary_type', 'salary_report.salary_type=salary_type.id');
        $this->db->join('personel_salary', 'salary_report.personel_id=personel_salary.personel_id');

        $this->db->where_in('salary_onay.user_id',39);
        $this->db->where('personel_salary.status',1);
//        $this->db->where('salary_report.hesaplama_ayi',4);
        $this->db->where('salary_report.hesaplama_yili',2023);

//        if($yetkili_id){
//            $this->db->where_in('salary_onay.user_id',$yetkili_id);
//        }
        $this->db->where('salary_report.pay_set_id',$this->aauth->get_user()->id);
        $this->db->where('personel_salary.status',1);
        if ($this->input->post('bordro_ayi')) // if datatable send POST for search
        {
            $this->db->where_in('salary_report.hesaplama_ayi',$this->input->post('bordro_ayi'));

        }
//        $this->db->where_in('salary_report.hesaplama_ayi',$hesaplama_ayi);
//        $this->db->where('salary_report.hesaplama_yili',$hesaplama_yili);



        if ($this->input->post('status')) // if datatable send POST for search
        {
            $this->db->where('(salary_report.cache_pay_odenis = 0 or salary_report.bank_pay_odenis = 0)');
            $this->db->where('(salary_onay.nakit_status = 1 or salary_onay.banka_status = 1)');
           // $this->db->where('pay_set_id',$this->aauth->get_user()->id);

        }
        else {
            $this->db->where('(salary_report.cache_pay_odenis = 0 or salary_report.bank_pay_odenis = 0)');
            $this->db->where('(salary_onay.nakit_status = 1 or salary_onay.banka_status = 1)');
        }





        if ($this->input->post('proje_id')) // if datatable send POST for search
        {
            $this->db->where_in('salary_report.proje_id', $this->input->post('proje_id')); //2019-11-23 14:28:57

        }
        $i = 0;




        foreach ($this->column_search_salary_odenis as $item) // loop column

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



                if (count($this->column_search_salary_odenis) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order_salary_odenis[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else {

            $this->db->order_by('salary_report.id','DESC');

        }






    }

    function get_datatables_personel_bordro_odenis($opt = '')

    {

        $this->_get_datatables_personel_bordro_odenis($opt);

        $this->db->group_by('salary_report.id');


        if ($_POST['length'] != -1)

        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();



//        echo $this->db->last_query();
        return $query->result();

    }

    private function _get_datatables_personel_bordro($opt = '')

    {



        $this->db->select('`salary_report.id`, `hesaplama_ayi`, `hesaplama_yili`, `proje_id`, SUM(salary) as salary, `is_gunu`,
         `calisilan_gun_sayisi_`,SUM(banka_hesaplanan) as banka_hesaplanan, `mezuniyet`, `mezuniyet_hesap`,
         `hastalik_amouth`, SUM(`cemi`) as cemi, SUM(`dsmf_isveren`) as dsmf_isveren, SUM(`issizlik_isveren`) as issizlik_isveren,
          SUM(`icbari_sigorta_isveren`) as icbari_sigorta_isveren, SUM(`dsmf_isci`) as dsmf_isci, SUM(`issizlik_isci`) as issizlik_isci,
          SUM(`icbari_sigorta_isci`) as icbari_sigorta_isci, SUM(`gelir_vergisi`) as gelir_vergisi, SUM(`odenilecek_meblaq`) as odenilecek_meblaq,
        SUM(`banka_avans`) as banka_avans, SUM(`nakit_avans`) as nakit_avans, SUM(`banka_hakedis`) as banka_hakedis, SUM(`nakit_hakedis`) as nakit_hakedis,
        SUM(`odenisli_izin_count`) as odenisli_izin_count, SUM(`oz_hesabina_count`) as oz_hesabina_count, SUM(`kesinti`) as kesinti, `emp_id`,
         salary_onay.banka_status as bank_payment_status, salary_onay.nakit_status as cache_payment_status,geopos_projects.name as proje_name');
        $this->db->from("salary_report");


        $this->db->join('geopos_projects', 'salary_report.proje_id=geopos_projects.id');
        $this->db->join('salary_onay', 'salary_report.id=salary_onay.salary_report_id');


        if ($this->input->post('status')) // if datatable send POST for search
        {
            $this->db->where('(salary_report.cache_pay_odenis = 0 or salary_report.bank_pay_odenis = 0)');
            $this->db->where('(salary_onay.nakit_status = 1 or salary_onay.banka_status = 1)');
            $this->db->where('pay_set_id',$this->aauth->get_user()->id);

        }
        else {
            $this->db->where('(salary_onay.nakit_status = 0 or salary_onay.banka_status = 0)');
        }


        if ($this->input->post('proje_id')) // if datatable send POST for search
        {
            $this->db->where_in('salary_report.proje_id', $this->input->post('proje_id')); //2019-11-23 14:28:57

        }
        $i = 0;

        $this->db->where('salary_onay.user_id',$this->aauth->get_user()->id);


        foreach ($this->column_search_salary as $item) // loop column

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



                if (count($this->column_search_salary) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order_salary[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else {

            $this->db->order_by('salary_report.id','DESC');

        }

        $this->db->group_by('salary_report.hesaplama_yili');
        $this->db->group_by('salary_report.hesaplama_ayi');
        $this->db->group_by('salary_report.proje_id');



    }


    public function count_personel_bordro_filtered($opt = '')

    {

        $this->_get_datatables_personel_bordro($opt);


        $query = $this->db->get();


        return $query->num_rows();

    }

    public function count_personel_bordro_all($opt = '')

    {

        $this->_get_datatables_personel_bordro($opt);


        return $this->db->count_all_results();

    }


    // Takip
    function get_datatables_personel_takip()

    {

        $this->_get_datatables_personel_takip_query();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _get_datatables_personel_takip_query()

    {


        $date = new DateTime('now');
        $guns_=date("t");
        $date_y=$date->format('Y');
        $hesaplanacak_ay=$date->format('m');

        $start =  $date->format('Y-m-01 00:00:00');
        $end =  $date->format('Y-m-t 00:00:00');

        if($this->input->post('hesap_yil')){

            $date_y = $this->input->post('hesap_yil');
        }



        if($this->input->post('start_date')){


            $m = $this->input->post('start_date');
            $total_ay_sayisi_ = cal_days_in_month( CAL_GREGORIAN,intval($m), $date_y);
            $start =  $date->format($date_y.'-'.$m.'-01 00:00:00');
            $end =  $date->format($date_y.'-'.$m.'-'.$total_ay_sayisi_.' 00:00:00');

        }

        $this->db->select('geopos_employees.*,
        geopos_projects.name as proje_name,
        personel_salary.salary_day,
        personel_salary.net_salary,
        personel_salary.proje_id as salary_proje_id,
        employee_start_job.staff_id,
        personel_salary.bank_salary,
        personel_salary.mezuniyet,
        personel_salary.salary as total_maas,
        personel_salary.hastalik_amouth,
        personel_salary.salary_type as s_type,
        personel_salary.is_cikis_date,
        personel_salary.is_cikis_desc,
        personel_salary.hesap_kesim_date,
        personel_salary.mezuniyet_start_date,
        personel_salary.personel_id,
        IF(
        (SELECT COUNT(id) as gun_say FROM employee_start_job WHERE employee_start_job.er=1 and employee_start_job.deleted_at is null and employee_start_job.status=1 and employee_start_job.user_id=geopos_employees.id and
        (employee_start_job.created_at >= "'.$start.'" and employee_start_job.created_at  <= "'.$end.'"))
        ,(SELECT COUNT(id) as gun_say FROM employee_start_job WHERE employee_start_job.er=1 and employee_start_job.deleted_at is null and employee_start_job.status=1 and employee_start_job.user_id=geopos_employees.id and
         (employee_start_job.created_at >= "'.$start.'" and employee_start_job.created_at <= "'.$end.'")),0) as gun_say,
          IF(
        (SELECT COUNT(id) as gun_say_gelmedi FROM employee_start_job WHERE employee_start_job.deleted_at is null and employee_start_job.status=0 and employee_start_job.user_id=geopos_employees.id and
        (employee_start_job.created_at >= "'.$start.'" and employee_start_job.created_at  <= "'.$end.'"))
        ,(SELECT COUNT(id) as gun_say_gelmedi FROM employee_start_job WHERE employee_start_job.deleted_at is null and employee_start_job.status=0 and employee_start_job.user_id=geopos_employees.id and
         (employee_start_job.created_at >= "'.$start.'" and employee_start_job.created_at <= "'.$end.'")),0) as gun_say_gelmedi');
        $this->db->from("geopos_employees");


        $this->db->join('personel_salary', 'geopos_employees.id=personel_salary.personel_id');
        $this->db->join('geopos_projects', 'personel_salary.proje_id=geopos_projects.id','LEFT');
        $this->db->join('employee_start_job', 'geopos_employees.id=employee_start_job.user_id','LEFT');
        $this->db->join('geopos_users', 'geopos_employees.id=geopos_users.id');




        if ($this->input->post('pers_id')) // if datatable send POST for search
        {
            $this->db->where('employee_start_job.user_id =', $this->input->post('pers_id')); //2019-11-23 14:28:57

        }
        if ($this->input->post('proje_id')) // if datatable send POST for search
        {
            $this->db->where_in('personel_salary.proje_id', $this->input->post('proje_id')); //2019-11-23 14:28:57
        }
        if ($this->input->post('maas_type_id')) // if datatable send POST for search
        {
            $this->db->where_in('personel_salary.salary_type', $this->input->post('maas_type_id')); //2019-11-23 14:28:57
        }

        $this->db->where('geopos_employees.loc', $this->session->userdata('set_firma_id'));
        $this->db->where('personel_salary.status =', 1); //2019-11-23 14:28:57
        $this->db->where('geopos_users.banned =', 0); //2019-11-23 14:28:57
        $this->db->where('personel_salary.salary_type!=',11);


        $i = 0;



        foreach ($this->column_search_takip as $item) // loop column

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



                if (count($this->column_search_takip) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order_takip[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else {

            $this->db->order_by('gun_say','DESC');

        }

        $this->db->group_by('geopos_employees.id');



    }


    public function count_personel_takip_filtered()

    {

        $this->_get_datatables_personel_takip_query();


        $query = $this->db->get();

        return $query->num_rows();

    }

    public function count_personel_takip_all()
    {

        $this->_get_datatables_personel_takip_query();


        return $this->db->count_all_results();

    }

    //takip

    //bordro


    function get_datatables_personel_takip_bordro_list($opt = '')

    {

        $this->_get_datatables_personel_takip_bordro_list($opt);


        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

//       echo $this->db->last_query();
//       die();
        return $query->result();

    }

    private function _get_datatables_personel_takip_bordro_list($opt = '')

    {

        $date = new DateTime('now');
        $guns_=date("t");
        $date_y=$date->format('Y');
        $hesaplanacak_ay=$date->format('m');

        $start =  $date->format('Y-m-01 00:00:00');
        $end =  $date->format('Y-m-t 00:00:00');


        if($this->input->post('hesap_yil')){

            $date_y = $this->input->post('hesap_yil');
        }
        if($this->input->post('start_date')){

            $m = $this->input->post('start_date');
            $start =  $date->format($date_y.'-'.$m.'-01 00:00:00');
            $end =  $date->format($date_y.'-'.$m.'-t 00:00:00');

        }





        $this->db->select('geopos_employees.name,
        geopos_projects.name as proje_name,
        salary_report.*,
        ');
        $this->db->from("salary_report");


        $this->db->join('personel_salary', 'salary_report.personel_id=personel_salary.personel_id');
        $this->db->join('geopos_projects', 'salary_report.proje_id=geopos_projects.id','LEFT');
        $this->db->join('geopos_employees', 'salary_report.personel_id=geopos_employees.id','LEFT');


        if ($this->input->post('proje_id')) // if datatable send POST for search
        {
            $this->db->where_in('salary_report.proje_id', $this->input->post('proje_id')); //2019-11-23 14:28:57
        }
        if ($this->input->post('start_date')) // if datatable send POST for search
        {
            $this->db->where_in('salary_report.hesaplama_ayi', $this->input->post('start_date')); //2019-11-23 14:28:57
        }

        if ($this->input->post('hesap_yil')) // if datatable send POST for search
        {
            $this->db->where_in('salary_report.hesaplama_yili', $this->input->post('hesap_yil')); //2019-11-23 14:28:57
        }
        else
        {
            $this->db->where_in('salary_report.hesaplama_yili', $date_y); //2019-11-23 14:28:57
        }

        $i = 0;

        if($this->session->userdata('set_firma_id')){
            $this->db->where('salary_report.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }



        foreach ($this->column_search_takip_bordro as $item) // loop column

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



                if (count($this->column_search_takip_bordro) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order_takip_bordro[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else {

            $this->db->order_by('gun_say','DESC');

        }

        $this->db->group_by('geopos_employees.id');



    }

    public function count_personel_takip_bordro_list_filtered($opt = '')

    {

        $this->_get_datatables_personel_takip_bordro_list($opt);


        $query = $this->db->get();

        return $query->num_rows();

    }

    public function count_personel_takip_bordro_list_all($opt = '')

    {

        $this->_get_datatables_personel_takip_bordro_list($opt);


        return $this->db->count_all_results();

    }
    //bordro


    function get_datatables($opt = '')

    {

        $this->_get_datatables_query($opt);


        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();




        return $query->result();

    }


    private function _get_datatables_query($opt = '')

    {


        $auth_id = $this->aauth->get_user()->id;
        $system_cont_id = $this->db->query("select * from geopos_system WHERE id=1")->row()->cost_pers_id;
        $this->db->select('geopos_controller.*,geopos_employees.name as kullanici_adi');
        $this->db->from("geopos_controller");


        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_controller.kayit_tarihi) >=', datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where('DATE(geopos_controller.kayit_tarihi) <=', datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
        }
        if($system_cont_id != $auth_id ){
            $this->db->where('cont_pers_id =',$auth_id); //2019-11-23 14:28:57
        }

        if ($this->input->post('pers_id')) // if datatable send POST for search
        {
            $this->db->where('kullanici_id =', $this->input->post('kullanici_id')); //2019-11-23 14:28:57

        }
        if ($this->input->post('status')) // if datatable send POST for search
        {
            $this->db->where('cont_status =', $this->input->post('status')); //2019-11-23 14:28:57

        }


        $this->db->join('geopos_employees', 'geopos_controller.kullanici_id=geopos_employees.id');


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

            $this->db->order_by('geopos_controller.id','DESC');

        }



    }


    function count_filtered($opt = '')

    {

        $this->_get_datatables_query($opt);


        $query = $this->db->get();

        return $query->num_rows();

    }



    public function count_all($opt = '')

    {

        $this->db->select('geopos_controller.id');

        $this->db->from("geopos_controller");


        return $this->db->count_all_results();

    }



    function get_datatables_envanter($opt = '')

    {

        $this->_get_datatables_query_envanter($opt);


        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();




        return $query->result();

    }

    private function _get_datatables_query_envanter($opt = '')

    {


        $this->db->select('*');
        $this->db->from("geopos_envanter");

        $i = 0;



        foreach ($this->column_search_envanter as $item) // loop column

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



                if (count($this->column_search_envanter) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order_envanter[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else {

            $this->db->order_by('geopos_envanter.id','DESC');

        }



    }


    function count_envanter_filtered($opt = '')

    {

        $this->_get_datatables_query_envanter($opt);


        $query = $this->db->get();

        return $query->num_rows();

    }



    public function count_envanter_all($opt = '')

    {

        $this->db->select('geopos_envanter.id');

        $this->db->from("geopos_envanter");


        return $this->db->count_all_results();

    }

    public function desc_update()
    {
        $id = $this->input->post('id');
        $desc =$this->input->post('desc');

        $data = array(
            'aciklama' => $desc
        );

        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_controller'))
        {
            $pers_name=$this->aauth->get_user()->username;
            $this->aauth->applog("Kontroller Ekibinden  $pers_name $id ID'li Görevin açıklamasını güncelledi. ");

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
    public function pers_update()
    {
        $auth_id = $this->aauth->get_user()->id;
        $system_cont_id = $this->db->query("select * from geopos_system WHERE id=1")->row()->cost_pers_id;
        if($system_cont_id==$auth_id){
            $id = $this->input->post('id');
            $yeni_pers_id =$this->input->post('yeni_pers_id');
            $data = array(
                'cont_pers_id' => $yeni_pers_id
            );
            $this->db->set($data);
            $this->db->where('id', $id);
            if ($this->db->update('geopos_controller')){
                $details = $this->details($id);
                $yeni_pers_name=personel_details($yeni_pers_id);
                $pers_name=personel_details($this->aauth->get_user()->id);
                $mesages = "Kontroller Ekibinden  $pers_name  Görevi $yeni_pers_name adlı personele atadı ";
                kont_history($id,$mesages,$details['cont_status']);
                return
                    [
                        'status'=>1,
                        'messages'=>'Başarılı Bir Şekilede Atama Yapıldı'
                    ];

            }
            else {
                return
                    ['status'=>0,
                     'messages'=>'Hata Aldınız Yöneticiye Başvurun'
                    ];
            }
        }
        else {
            return
                ['status'=>0,'messages'=>'Yetkiniz Bulunmamaktadır'];
        }
    }
    public function cont_status_update()
    {
        $id = $this->input->post('id');
        $yeni_deger_status =$this->input->post('yeni_deger_status');

        $data = array(
            'id' => $id,
            'cont_status' => $yeni_deger_status
        );

        $const_status=controller_status($yeni_deger_status);
        $pers_name=$this->aauth->get_user()->employes->name;
        $this->aauth->applog("Kontroller Ekibinden  $pers_name $id ID'li Görevin durumunu güncelledi. Yeni durum : $const_status ");


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_controller'))
        {

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }


    public function details($id)

    {

        $this->db->select('*');

        $this->db->from('geopos_controller');

        $this->db->where('id', $id);
        $query = $this->db->get();
        $query = $query->row_array();
        return $query;

    }

    public function get_datatables_history(){

        $this->_get_datatables_history();
        if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    private function _get_datatables_history(){

        $this->db->select('geopos_controller_history.*,geopos_employees.name as pers_name,geopos_controller_status.name as st_name');
        $this->db->from("geopos_controller_history");
        $this->db->join('geopos_employees', 'geopos_controller_history.cont_user_id=geopos_employees.id');
        $this->db->join('geopos_controller_status', 'geopos_controller_history.status_id=geopos_controller_status.id');
        $this->db->where('geopos_controller_history.cont_id',$this->input->post('talep_id'));

        $i = 0;

        foreach ($this->column_search_holidays as $item) // loop column
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



                if (count($this->column_search_holidays) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $this->db->order_by('geopos_controller_history.id','DESC');
    }
    public function count_all_history(){

        $this->_get_datatables_history();
        return $this->db->count_all_results();

    }
    public function count_filtered_history(){

        $this->_get_datatables_history();
        $query = $this->db->get();
        return $query->num_rows();

    }



}
