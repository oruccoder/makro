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

class Dashboard extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
            exit;
        }

        $this->load->model('dashboard_model');
        $this->load->model('tools_model');



    }


    public function test(){

        $date = new DateTime('now');
        $start =  $date->format('Y-m-01 00:00:00');
        $end =  $date->format('Y-m-t 00:00:00');

        $this->db->select('IF( SUM(total*kur_degeri), SUM(total*kur_degeri) ,0) as totals');
        $this->db->from('geopos_invoices');
//        $this->db->where($where);
        $this->db->where('DATE(invoicedate) >=', $start); //2019-11-23 14:28:57
        $this->db->where('DATE(invoicedate) <=', $end);  //2019-11-24 14:28:57
        $type=array(18,3,46);
        $this->db->where_in('invoice_type_id', $type);
        $query = $this->db->get();
        $q=$query->row()->totals;

        echo $q;
    }

    function daysBetween($dt1, $dt2) {
        return date_diff(
            date_create($dt2),
            date_create($dt1)
        )->format('%a');
    }


    public function index(){

        $head['title'] = 'Kontrol Paneli';
        $this->load->view('fixed/header', $head);
        $this->load->view('dashboard');
        $this->load->view('fixed/footer');

        $user_id = $this->aauth->get_user()->id;
        $list = $this->db->query("SELECT * FROM talep_form Where status IN (1,2,3,4,5,6,7,8,12,10,13,14,15,16,17,18,19,20,21) and 
                         
                        (talep_form.talep_eden_user_id =$user_id or talep_form.aauth=$user_id)");
        if($list->num_rows()){
            foreach ($list->result() as $prd){
                if($prd->status==10)
                {
                    $iptal_kontrol = $this->db->query("SELECT * FROM iptal_visable Where user_id = $user_id and talep_id=$prd->id")->num_rows();
                    if(!$iptal_kontrol){
                        $data_inst = array(
                            'user_id' =>$user_id,
                            'talep_id' =>$prd->id
                        );
                        $this->db->insert('iptal_visable', $data_inst);
                    }
                    else {
                        $iptal_kontrols = $this->db->query("SELECT * FROM iptal_visable Where user_id = $user_id and talep_id=$prd->id and visable_date is null")->row();

                        if($iptal_kontrols){
                            $old_date = $iptal_kontrols->created_at;
                            $now = date('Y-m-d');
                            $sonuc =  $this->daysBetween($old_date,$now);
                            if($sonuc > 1){
                                $data_update=array(
                                    'visable_date' => $now
                                );
                                $this->db->set($data_update);
                                $this->db->where('user_id', $user_id);
                                $this->db->where('talep_id', $prd->id);
                                $this->db->update('iptal_visable', $data_update);
                            }

                        }



                    }
                }
            }
        }



//        $user_id = $this->aauth->get_user()->id;
//        $iptal_kontrol = $this->db->query("SELECT * FROM iptal_visable Where user_id = $user_id")->num_rows();
//        if(!$iptal_kontrol){
//            $data_inst = array(
//                'user_id' =>$user_id
//            );
//            $this->db->insert('iptal_visable', $data_inst);
//        }
//        else {
//            $iptal_kontrols = $this->db->query("SELECT * FROM iptal_visable Where user_id = $user_id and visable_date is null")->row();
//
//            if($iptal_kontrols){
//                $old_date = $iptal_kontrols->created_at;
//                $now = date('Y-m-d');
//                $sonuc =  $this->daysBetween($old_date,$now);
//                if($sonuc > 3){
//                    $data_update=array(
//                        'visable_date' => $now
//                    );
//                    $this->db->set($data_update);
//                    $this->db->where('user_id', $user_id);
//                    $this->db->update('iptal_visable', $data_update);
//                }
//
//            }
//
//
//
//        }



    }

//
//    public function index()
//    {
//        $today = date("Y-m-d");
//        $month = date("m");
//        $year = date("Y");
//
//        $data['users']=array(61,32,39,21,62,66,85,33,64,63,547,546,560,500,522);
//
//        $head['usernm'] = $this->aauth->get_user()->username;
//        $data['todayin'] = $this->dashboard_model->todayInvoice($today);
//        $data['today_gelir'] = $this->dashboard_model->today_gelir($today);
//        $data['today_gider'] = $this->dashboard_model->today_gider($today);
//        $data['today_kdv_odemesi'] = $this->dashboard_model->today_kdv_odemesi($today);
//        $data['today_kdv_tahsilati'] = $this->dashboard_model->today_kdv_tahsilati($today);
//        $data['todayprofit'] = $this->dashboard_model->todayProfit($today);
//        $data['incomechart'] = $this->dashboard_model->incomeChart($today, $month, $year);
//        $data['expensechart'] = $this->dashboard_model->expenseChart($today, $month, $year);
//        $data['countmonthlychart'] = $this->dashboard_model->countmonthlyChart();
//        $data['monthin'] = $this->dashboard_model->monthlyInvoice($month, $year);
//        $data['todaysales'] = $this->dashboard_model->todaySales($today);
//        $data['monthsales'] = $this->dashboard_model->monthlySales($month, $year);
//        $data['aylik_kdv_odemesi'] = $this->dashboard_model->aylik_kdv_odemesi($month, $year);
//        $data['aylik_kdv_tahsilati'] = $this->dashboard_model->aylik_kdv_tahsilati($month, $year);
//        $data['todayinexp'] = $this->dashboard_model->todayInexp($today);
//        $data['recent_payments'] = $this->dashboard_model->recent_payments();
//        $data['recent'] = $this->dashboard_model->recentInvoices();
//        $data['recent_buy'] = $this->dashboard_model->recentBuyers();
//        $data['goals'] = $this->tools_model->goals(1);
//
//
//        if ($this->aauth->premission(9)) {
//            $data['teklif'] = $this->dashboard_model->teklif_emp($this->aauth->get_user()->id);
//
//
//        }
//        if ($this->aauth->premission(10)) {
//            $data['purchase'] = $this->dashboard_model->purchase_emp($this->aauth->get_user()->id);
//
//
//        }
//
//        if ($this->aauth->premission(4)) {
//            $this->load->model('projects_model', 'projects');
//            $head['title'] = 'Projeler';
//            $data['totalt'] = $this->projects->project_count_all();
//
//
//        } if ($this->aauth->premission(2)) {
//         $data['stock'] = $this->dashboard_model->stock();
//            $head['title'] = "Ürünler";
//        }
//
//
//        $data['tasks'] = $this->dashboard_model->tasks($this->aauth->get_user()->id);
//        $head['title'] = 'Kontrol Paneli';
//        $this->load->view('fixed/header', $head);
//        $this->load->view('dashboard', $data);
//        $this->load->view('fixed/footer');
//
//
//    }
}
