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



class Personelaction Extends CI_Controller

{
    public function __construct()

    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('Personelaction_model', 'personel');
        $this->load->model('communication_model');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function ajax_list_izinler()
    {
        $tip = $this->input->post('tip');
        $list = $this->personel->datatables_izinler();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $item) {
            $bildirim_text='Bildirim Oluşturulmamış';
            $disabled_bildirim='';

            if($item->bildirim_durumu){
                $bildirim_text='Bildirim Başlatılmış';
                $disabled_bildirim='disabled';
            }
            if($tip=="p"){
                $edit = "
            <button data-id='$item->id' class='btn btn-info eye-permit'><i class='fa fa-eye'></i></button>&nbsp
            <button $disabled_bildirim data-id='$item->id' class='btn btn-danger cancel-permit'><i class='fa fa-ban'></i></button>&nbsp
            <button $disabled_bildirim data-id='$item->id' class='btn btn-warning edit-permit'><i class='fa fa-edit'></i></button>&nbsp
            <button $disabled_bildirim data-id='$item->id' class='btn btn-success notifation-permit'><i class='fa fa-bell'></i></button>&nbsp
            <a type='button' href='/personelaction/print_permit/$item->id' TARGET='_blank' class='btn btn-info'><i class='fa fa-print'></i></a>  
            <a type='button' href='/personelaction/print_permit_g/$item->id' TARGET='_blank' class='btn btn-info'><i class='fa fa-print'></i> R</a>  
            
            ";
            }
            else {
                $edit = "
            <button data-id='$item->id' class='btn btn-info eye-permit'><i class='fa fa-eye'></i></button>&nbsp
            <a type='button' href='/personelaction/print_permit/$item->id' TARGET='_blank' class='btn btn-info'><i class='fa fa-print'></i></a> 
               <a type='button' href='/personelaction/print_permit_g/$item->id' TARGET='_blank' class='btn btn-info'><i class='fa fa-print'></i> R</a>  
            
            
             ";
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $item->code;
            $row[] = $item->creatad_at;
            $row[] = $item->start_date;
            $row[] = $item->end_date;
            $row[] = $bildirim_text;
            $row[] = permit_status($item->status);
            $row[] = user_permit_type($item->permit_type)->name;
            $row[] =$edit;
            $data[] = $row;

        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->personel->count_all_izinler(),
            "recordsFiltered" => $this->personel->count_filtered_izinler(),
            "data" => $data,

        );

        echo json_encode($output);
    }


    public function ajax_list_task_actions()
    {

        $list = $this->personel->datatables_task_actions();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $item) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $item->created_at;
            $row[] = $item->desc;
            $row[] = $item->name;
            $row[] = $item->st_name;
            $data[] = $row;

        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->personel->count_all_task_actions(),
            "recordsFiltered" => $this->personel->count_filtered_task_actions(),
            "data" => $data,

        );

        echo json_encode($output);
    }

    public function personel_pay_list(){


        if (!$this->aauth->premission(16)->read) {

            echo json_encode(array('status' => 'Error', 'messages'=>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $data=[];
            $pay_details = $this->db->query("SELECT * FROM `geopos_invoices` WHERE invoice_type_id IN (59) ");
            if($pay_details->num_rows()>0){
                foreach ($pay_details->result() as $value){
                    $transaction_details = $this->db->query("SELECT * FROM `geopos_invoice_transactions` WHERE `transaction_id` = $value->id and invoice_id is null ORDER BY `id` DESC");
                    if($transaction_details->num_rows()>0){
                        $data[]=['id'=>$value->id,'personel'=>$value->payer,'tip'=>$value->invoice_type_desc,'amount'=>amountFormat($value->total),'amount_float'=>$value->total,'notes'=>$value->notes,'date'=>$value->invoicedate,'kasa'=>$value->account];
                    }

                }
            }
            echo json_encode(array('status' => 'Success', 'data' =>$data,'count'=>count($data)));
        }

    }


    public function create_permit()
    {
        $this->db->trans_start();
        $result = $this->personel->create_permit();
        if($result['status']){
            echo json_encode(array('status' => 200,'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }

    }

    public function create_task()
    {
        if (!$this->aauth->premission(63)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Görev Atamak İçin Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->personel->create_task();
            if($result['status']){

                echo json_encode(array('status' => 200,'message' =>$result['message']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }


    }

    public function send_mail($user_id,$subject,$message){
        if(!$user_id){
            return 0;
        }
        else {
            $message .= "<br><br><br><br>";
            $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
            $proje_sorumlusu_email = personel_detailsa($user_id)['email'];
            $recipients = array($proje_sorumlusu_email);
            $this->communication_model->onay_mail($recipients, $subject, $message, false,'', 'gider_talep_onay_maili');
            return 1;
        }

    }
    public function update_task()
    {
        if (!$this->aauth->premission(63)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Görev Güncellemek İçin Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->personel->update_task();
            if($result['status']){
                echo json_encode(array('status' => 200,'message' =>$result['message']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }


    }
    public function update_task_change()
    {
        if (!$this->aauth->premission(63)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Görev Güncellemek İçin Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->personel->update_task_change();
            if($result['status']){
                if($result['new_pers_id']){
                     // Yönlendirme olumuştur
                    $mesaj=$result['code'].' Numaralı Görevlendirme Size Yönlendirilmiştir';
                    $this->send_mail($result['new_pers_id'],'Görevlendirme',$mesaj);

                    $personel_details = personel_details($result['new_pers_id']);
                    $mesaj_news=$result['code'].' Numaralı Görevlendirme '.$personel_details.' adlı personele yönlendirilmiştir.';
                    $this->send_mail($result['personel_id'],'Görevlendirme',$mesaj_news);

                }
                else {
                    //Görev Güncellenmiş

                    $mesaj_news=$result['code'].' Numaralı Görevlendirme Güncellenmiştir. Durum : '.$result['status_name'];
                    $this->send_mail($result['personel_id'],'Görevlendirme',$mesaj_news);
                }
                echo json_encode(array('status' => 200,'message' =>$result['message']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }


    }


    public function update_permit(){
        $this->db->trans_start();
        $result = $this->personel->update_permit();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        elseif($result['status']==0) {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function delete_permit(){
        $this->db->trans_start();
        $result = $this->personel->delete_permit();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function task_delete(){
        if (!$this->aauth->premission(63)->delete) {
            echo json_encode(array('status' => 410, 'message' =>'Görev Silmek İçin Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->personel->task_delete();
            if($result['status']){

                echo json_encode(array('status' => 200, 'message' =>$result['message']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }

    }
    public function notifation_permit(){
        $this->db->trans_start();
        $result = $this->personel->notifation_permit();
        if($result['status']){
            $this->db->trans_complete();
            $id = $this->input->post('id');
            $this->personel->permit_sms($id);

            echo json_encode(array('status' => 200, 'message' =>$result['message']));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function task_notifation(){
        $this->db->trans_start();
        $result = $this->personel->task_notifation();
        if($result['status']){
            $this->db->trans_complete();
            $mesaj=$result['code'].' Numaralı Görevlendirme Size Atanmıştır';
            $this->send_mail($result['personel_id'],'Görevlendirme',$mesaj);

            echo json_encode(array('status' => 200, 'message' =>$result['message']));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function get_info_permit(){
        $id = $this->input->post('permit_id');
        $result = $this->personel->details_permit($id);
        echo json_encode(array('status' => 200, 'item' =>$result));
    }

    public function get_info_permit_confirm(){
        $id = $this->input->post('permit_id');
        $result = $this->personel->details_permit_confirm($id);

        if($result){
            $details_permit = $this->personel->details_permit($id);
            echo json_encode(array('status' => 200, 'item' =>$result,'details_permit'=>$details_permit));
        }
        else {
            echo json_encode(array('status' => 410, 'messages' =>'Bildirim Başlatılmamış'));
        }

    }

    public function test($permit_id){

        $this->personel->permit_sms($permit_id);
    }

    public function permit_info(){
        $id_confirm = $this->input->post('id');
        $details_permit = $this->db->query("SELECT * FROM user_permit_confirm WHERE id = $id_confirm")->row();
        $id = $details_permit->user_permit_id;
        $details = $this->personel->details_permit($id);
        $user_details = personel_details_full($details->user_id);
        $role_id  = $user_details['roleid'];
        $user_role = $this->db->query("SELECT * FROM geopos_role Where role_id = $role_id")->row()->name;
        $salary_details = $this->db->query("SELECT * FROM personel_salary Where personel_id=$details->user_id and status=1")->row();
        $proje = proje_name($salary_details->proje_id);


        $result = $this->personel->details_permit_confirm($id);


        echo json_encode(array('status' => 200,'item' =>$details,'user_name'=>$user_details['name'],'user_role'=>$user_role,'proje'=>$proje,'details_permit'=>$result));
    }

    public function user_permit_update(){
        $this->db->trans_start();
        $result = $this->personel->user_permit_update();
        if($result['status']){
            $this->db->trans_complete();
            echo json_encode(array('status' => 200,'message' =>$result['message']));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }

    }

    public function personel_task(){
        if (!$this->aauth->premission(63)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Görevleri';
        $this->load->view('fixed/header', $head);
        $this->load->view('personelaction/personel_task');
        $this->load->view('fixed/footer');
    }

    public function task_view($personel_id){

        if (!$this->aauth->premission(63)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $view=0;
        if(!empty($this->input->get('view'))){
            $view=$this->input->get('view');
        }
        $personel_name =  personel_details_full($personel_id)['name'];
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['personel_id']=$personel_id;
        $head['view']=$view;
        $head['title'] = $personel_name. ' Görevleri';
        $this->load->view('fixed/header', $head);
        $this->load->view('personelaction/personel_task_view',$head);
        $this->load->view('fixed/footer');
    }

    public function tasktopersonel(){
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Atadığım Görevler';
        $head['tip_str'] = 'task_to_personel';
        $this->load->view('fixed/header', $head);
        $this->load->view('personelaction/tasktopersonel',$head);
        $this->load->view('fixed/footer');
    }

    public function personeltotask(){
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Atanan Görevler';
        $head['tip_str'] = 'personel_to_task';
        $this->load->view('fixed/header', $head);
        $this->load->view('personelaction/personeltotask',$head);
        $this->load->view('fixed/footer');
    }

    public function ajax_list_task()
    {

        $list = $this->personel->datatables_task();
        $data = array();
        $bekleyen=0;
        $tamamlanan=0;
        $no = $this->input->post('start');
        foreach ($list as $item) {
            $view=0;
            if(!empty($this->input->post('view'))){
                if($this->input->post('view')=='task_to_personel'){
                    $view=2;
                }
                else {
                    $view=3;
                }
            }


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $item->code;
            $row[] = $item->name;
            $row[] = task_count($item->personel_id,1);
            $row[] = task_count($item->personel_id,2);
            $row[] = task_count($item->personel_id,3);
            $row[] ="<a class='btn btn-success' href='/personelaction/task_view/$item->personel_id?view=$view'><i class='fa fa-eye'></i></a>";
            $data[] = $row;

        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->personel->count_all_task(),
            "recordsFiltered" => $this->personel->count_filtered_task(),
            "data" => $data,

        );

        echo json_encode($output);
    }

    public function ajax_list_task_details()
    {

        $list = $this->personel->datatables_task_details();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $item) {

            $status_details =progress_status_details($item->progress_status_id);

            $color = $status_details->color;
            $text_color = $status_details->text_color;

            $style = "background-color:$color;color:$text_color";

            $disable='';
            if($item->bildirim_durumu){
                $disable='disabled';
            }

            $edit="<button $disable class='btn btn-warning edit' id='$item->id'><i class='fa fa-pen'></i></button>&nbsp;";
            $bildirim="<button $disable class='btn btn-info bildirim' id='$item->id'><i class='fa fa-bell'></i></button>&nbsp;";
            $cancel="<button $disable class='btn btn-danger cancel' id='$item->id'><i class='fa fa-ban'></i></button>&nbsp;";
            $check="<button class='btn btn-success status_change' id='$item->id'><i class='fa fa-check'></i></button>&nbsp;";
            $view="<button class='btn btn-secondary action_view' id='$item->id'><i class='fa fa-eye'></i></button>&nbsp;";

            $file = '';
            if(isEmptyFunction($item->image_text,'Dosya Yüklenmemiş')){
                $return = isEmptyFunction($item->image_text,'Dosya Yüklenmemiş');
                if($return=='Dosya Yüklenmemiş'){
                    $file="Dosya Yüklenmemiş";
                }
                else {
                    $file="<a href='/userfiles/excel_malzeme/$item->image_text' class='btn btn-info'><i class='fa fa-file'></i> Dosyayı İndir</a>";
                }

            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $item->code;
            $row[] = "<p style='text-transform: lowercase;'>$item->text</p>";
            $row[] = $item->name;
            $row[] = $item->created_at;
            $row[] = task_status($item->status);
            $row[] = $status_details->name;
            $row[] = $file;
            $row[] =$edit.$bildirim.$cancel.$check.$view;
            $row[]=$style;
            $data[] = $row;

        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->personel->count_all_task_details(),
            "recordsFiltered" => $this->personel->count_filtered_task_details(),
            "data" => $data,

        );

        echo json_encode($output);
    }

    public function task_info(){
        $id = $this->input->post('id');
        $details = $this->personel->task_details($id);
        echo json_encode(array('status' => 200,'item' =>$details));
    }

    public function bekleyentask(){
        $result = $this->personel->transfertaleplist();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }
    }
    public function print_permit($id){
        $data['details']= $this->personel->details_permit($id);
        ini_set('memory_limit', '999M');
        $html = $this->load->view('fileprint/personel_izin_view', $data, true);
        $header = $this->load->view('fileprint/personel_izin_header', $data, true);
        $footer = $this->load->view('fileprint/personel_izin_footer', $data, true);

        $this->load->library('pdf');

        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter($footer);
        $pdf->AddPage(
            'P', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            59, // margin top
            '72', // margin bottom
            5, 2, 0, 0, // margin header
            'auto'); // margin footer

        $pdf->WriteHTML($html);
        $file_name ="PersonelIzın";
        $pdf->Output($file_name . '.pdf', 'I');
    }
    public function print_permit_g($id){
        $this->db->select("");
        $this->db->from('user_permit');

        $data['details']= $this->db->query("SELECT user_permit.creatad_at,DATE_FORMAT(user_permit.end_date, '%m') as month,
        user_permit.code,user_permit.end_date,user_permit.start_date,user_permit.user_id,
        TIMESTAMPDIFF(HOUR,user_permit.start_date,user_permit.end_date) as toplam_saat,
        TIMESTAMPDIFF(MINUTE,user_permit.start_date,user_permit.end_date) as toplam_dk From user_permit where id=$id")->row();
        $data['personel_name']=personel_details($data['details']->user_id);



        $role_id = personel_details_full($data['details']->user_id)['roleid'];
        $sorumlu_pers_id = personel_details_full($data['details']->user_id)['sorumlu_pers_id'];

        $role_id_sorumlu = personel_details_full($sorumlu_pers_id)['roleid'];

        $data['sorumlu_pers_name']=personel_details($sorumlu_pers_id);
        $data['sorumlu_role_name']=role_name($role_id_sorumlu)['name'];

        $data['role_name']=role_name($role_id)['name'];
        $data['fin']=personel_details_full($data['details']->user_id)['fin_no'];
        $data['seri_no']=personel_details_full($data['details']->user_id)['seri_no'];


        $prd=$data['details'];
        $date = new DateTime('now');
        $m= $date->format('m');
        $y= $date->format('Y');
        $month_name  = month_name(intval($prd->month));
        $toplam_gun = 0;
        $toplam_saat = 0;
        $kalan_saat = 0;
        $kalan_dk = 0;
        if($prd->toplam_saat > 8){

            if($prd->toplam_saat==9){
                $toplam_gun=1;
            }
            else{
                if($prd->toplam_saat%24){
                    $kalan_saat = $prd->toplam_saat%9;
                    if($kalan_saat > 3){

                        $toplam_gun++;
                        $kalan_saat=0;
                    }
                    else {
                        $saat = $prd->toplam_saat%24;
                        if($saat > 3){

                            $toplam_gun++;
                            $kalan_saat=0;
                        }
                    }
                }

                $toplam_gun+= intval($prd->toplam_saat/24);
            }


//                $kalan  =  $prd->toplam_dakika%540;
//                $kalan_dk  =  $kalan%60;
//                $toplam_gun  =  intval($prd->toplam_dakika/540);
//                $toplam_saat  =  intval($kalan/60);
        }
        else {
            $kalan_saat = $prd->toplam_saat;

        }

        if($prd->toplam_dk < 540){
            $kalan_saat  =  intval($prd->toplam_dk/60);
            $kalan_dk  =  $prd->toplam_dk%60;
            if($kalan_saat > 3){
                $toplam_gun++;
                $kalan_saat=0;
            }
        }
        $data['toplam_gun']=$toplam_gun;



        ini_set('memory_limit', '999M');
        $html = $this->load->view('fileprint/personel_izin_g_view', $data, true);
        $header = $this->load->view('fileprint/personel_izin_g_header', $data, true);
        $footer = $this->load->view('fileprint/personel_izin_g_footer', $data, true);


        $this->load->library('pdf');

        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter($footer);
        $pdf->AddPage(
            'P', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            79, // margin top
            '72', // margin bottom
            5, 2, 0, 0, // margin header
            'auto'); // margin footer

        $pdf->WriteHTML($html);
        $file_name ="PersonelIzın";
        $pdf->Output($file_name . '.pdf', 'I');
    }

    public function file_handling()
    {
        if ($this->input->get('op')) {

            $name = $this->input->get('name');

            if ($this->transactions->meta_delete($name)) {

                echo json_encode(array('status' => 'Success'));

            }

        } else {

            $id = $this->input->get('id');

            $this->load->library("Uploadhandler_generic", array(

                'accept_file_types' => '/\.(pdf|gif|jpe?g|png|xlsx)$/i', 'upload_dir' => FCPATH . 'userfiles/excel_malzeme/', 'upload_url' => base_url() . 'userfile/product/'

            ));


        }
    }
}