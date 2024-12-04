<?php
/**
 * İtalic Soft Yazılım  ERP - CRM - HRM
 * Copyright (c) İtalic Soft Yazılım. Tüm Hakları Saklıdır.
 * ***********************************************************************
 *
 *  Email: info@italicsoft.com
 *  Website: https://www.italicsoft.com
 *  Tel: 0850 317 41 44
 *  ******************************************tedtst***************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Demirbas Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('demirbas_model', 'model');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function info()
    {
        $demirbas_id = $this->input->post('demirbas_id');
        $details_items = $this->model->details($demirbas_id);
        echo json_encode(array('status' => 'Success', 'details_items' => $details_items));
    }

    public function index()
    {
        if (!$this->aauth->premission(87)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        } else {
            $list = $this->db->query("SHOW TABLES");
            $table_list=[];
            foreach ($list->result() as $items){
                $db_details  = db_details(1); // Link DB Bilgileri
                $table_name='Tables_in_'.$db_details->db_name;
                $table_list[]=$items->$table_name;
            }
            $data['table_list']=$table_list;
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Gider Yönetimi Kontrol Paneli';
            $this->load->view('fixed/header', $head);
            $this->load->view('demirbas/index',$data);
            $this->load->view('fixed/footer');
        }
    }
    public function view($id)
    {
        if (!$this->aauth->premission(87)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        } else {


            $data['details']=$this->model->details($id);
            $data['demisbas_id']=$id;
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Gider Yönetimi - '.$data['details']->name;
            $this->load->view('fixed/header', $head);
            $this->load->view('demirbas/view',$data);
            $this->load->view('fixed/footer');
        }
    }
    public function mt_create($id)
    {
        if (!$this->aauth->premission(87)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        } else {


            $data['details']=$this->db->query("SELECT * FROM talep_form WHERE id = $id")->row();

            if($id <= 3193){
                $data['items']=$this->db->query("SELECT siparis_list_form_new.*,demirbas_group.name as product_name,talep_form_products.product_id FROM siparis_list_form_new
                 INNER JOIN talep_form_products On siparis_list_form_new.talep_form_product_id = talep_form_products.id
             INNER JOIN demirbas_group ON demirbas_group.id =talep_form_products.product_id
WHERE talep_form_products.form_id = $id and talep_form_products.gider_durumu=0")->result();

            }
            else {
                $data['items']=$this->db->query("SELECT siparis_list_form_new.*,geopos_products.product_name,talep_form_products.product_id FROM siparis_list_form_new
                 INNER JOIN talep_form_products On siparis_list_form_new.talep_form_product_id = talep_form_products.id
                 INNER JOIN geopos_products ON talep_form_products.product_id =geopos_products.pid
WHERE talep_form_products.form_id = $id and talep_form_products.gider_durumu=0")->result();
            }



            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Gider Yönetimi - '.$data['details']->code;
            $this->load->view('fixed/header', $head);
            $this->load->view('demirbas/mt_create',$data);
            $this->load->view('fixed/footer');
        }
    }

    public function forma2create($id)
    {
        if (!$this->aauth->premission(87)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        } else {


            $data['details']=$this->db->query("SELECT * FROM geopos_invoices WHERE id = $id")->row();
            $data['items']=$this->db->query("SELECT geopos_invoice_items.* FROM geopos_invoice_items
                 INNER JOIN geopos_invoices ON geopos_invoices.id =geopos_invoice_items.tid
WHERE geopos_invoices.id = $id and geopos_invoice_items.gider_durumu=0")->result();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Gider Yönetimi - '.$data['details']->invoice_no;
            $this->load->view('fixed/header', $head);
            $this->load->view('demirbas/forma2_create',$data);
            $this->load->view('fixed/footer');
        }
    }

    public function invoicecreate($id)
    {
        if (!$this->aauth->premission(87)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        } else {


            $data['details']=$this->db->query("SELECT * FROM geopos_invoices WHERE id = $id")->row();
            $data['items']=$this->db->query("SELECT geopos_invoice_items.* FROM geopos_invoice_items
                 INNER JOIN geopos_invoices ON geopos_invoices.id =geopos_invoice_items.tid
WHERE geopos_invoices.id = $id and geopos_invoice_items.gider_durumu=0")->result();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Gider Yönetimi - '.$data['details']->invoice_no;
            $this->load->view('fixed/header', $head);
            $this->load->view('demirbas/invoicecreate',$data);
            $this->load->view('fixed/footer');
        }
    }

    public function count_gider_mt(){
       $count =  $this->db->query("SELECT siparis_list_form_new.*,geopos_products.product_name,talep_form_products.product_id FROM siparis_list_form_new
                 INNER JOIN talep_form_products On siparis_list_form_new.talep_form_product_id = talep_form_products.id
                 INNER JOIN geopos_products ON talep_form_products.product_id =geopos_products.pid
                 INNER JOIN talep_form ON talep_form_products.form_id =talep_form.id
WHERE  talep_form_products.gider_durumu=0 and  talep_form.gider_durumu=1")->num_rows();

        echo json_encode(array('status' => 'Success', 'count' =>$count));
    }

    public function gider_view($id)
    {
        if (!$this->aauth->premission(87)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        } else {


            $data['details']=$this->model->details($id);
            $data['demisbas_id']=$id;
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Gider Yönetimi - '.$data['details']->name;
            $this->load->view('fixed/header', $head);
            $this->load->view('demirbas/gider_view',$data);
            $this->load->view('fixed/footer');
        }
    }

    public function alt_view($id)
    {
        if (!$this->aauth->premission(87)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        } else {


            $data['details']=$this->model->details($id);
            $data['demisbas_id']=$id;
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Gider Yönetimi - '.$data['details']->name;
            $this->load->view('fixed/header', $head);
            $this->load->view('demirbas/alt_view',$data);
            $this->load->view('fixed/footer');
        }
    }

    public function ajax_list(){
        $list = $this->model->ajax_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $total = demirbas_gider_total($prd->id);
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->code;
            $row[] = $prd->name;
            $row[] = amountFormat($total);
            $row[] = "<a href='/demirbas/view/$prd->id' class='btn btn-outline-info'><i class='fa fa-eye'></i></a> <button demirbas_id='$prd->id' class='btn btn-outline-warning edit_button'><i class='fa fa-pen'></i></button>";
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all(),
            "recordsFiltered" => $this->model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function ajax_list_view(){
        $list = $this->model->ajax_list_view();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $total=demirbas_alt_gider_total($prd->id);
            $btn="<a href='/demirbas/gider_view/$prd->id' class='btn btn-outline-info'><i class='fa fa-eye'></i></a>";
            if(parent_demirbas_kontrol($prd->id)){
                $btn="<a href='/demirbas/alt_view/$prd->id' class='btn btn-outline-info'><i class='fa fa-eye'></i></a>";
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->code;
            $row[] = $prd->name;
            $row[] = amountFormat($total);
            $row[] = $btn." <button demirbas_id='$prd->id' class='btn btn-outline-warning edit_button'><i class='fa fa-pen'></i></button>";
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_view(),
            "recordsFiltered" => $this->model->count_filtered_view(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_gider(){
        $list = $this->model->ajax_list_gider();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $t_code='';
            $href='';
            if($prd->type==1) //customer talep formu
            {
                $talep_details = $this->db->query("SELECT * FROM talep_form_customer_new Where id = $prd->talep_id")->row();
                $t_code = $talep_details->code;
                $href='/carigidertalepnew/view/'.$prd->talep_id;

            }
            elseif($prd->type==2) //personel talep formu
            {
                $talep_details = $this->db->query("SELECT * FROM talep_form_personel Where id = $prd->talep_id")->row();
                $t_code = $talep_details->code;
                $href='/personelgidertalep/view/'.$prd->talep_id;

            }
            elseif($prd->type==3) //Malzeme Talep Formu
            {
                $talep_details = $this->db->query("SELECT * FROM talep_form Where id = $prd->talep_id")->row();
                $t_code = $talep_details->code;
                $href='/malzemetalep/view/'.$prd->talep_id;

            }
            elseif($prd->type==5) //Forma 2
            {
                $talep_details = $this->db->query("SELECT * FROM geopos_invoices Where id = $prd->talep_id")->row();
                $t_code = $talep_details->invoice_no;
                $href='/formainvoices/view?id='.$prd->talep_id;

            }
            elseif($prd->type==6) //fatura
            {
                $talep_details = $this->db->query("SELECT * FROM geopos_invoices Where id = $prd->talep_id")->row();
                $t_code = $talep_details->invoice_no;
                $href='/invoices/view?id='.$prd->talep_id;

            }

            elseif($prd->type==7) //Yeni İşlem
            {
                $talep_details = $this->db->query("SELECT * FROM geopos_invoices Where id = $prd->talep_id")->row();
                $t_code = 'Finans İşlemi';
                $href='/transactions/view?id='.$prd->talep_id;

            }
            elseif($prd->type==9) //Yeni İşlem
            {
                $talep_details = $this->db->query("SELECT * FROM geopos_invoices Where id = $prd->talep_id")->row();
                $t_code = 'Finans İşlemi';
                $href='/transactions/view?id='.$prd->talep_id;

            }
            elseif($prd->type==10) //Hizmet Talep Formu
            {
                $talep_details = $this->db->query("SELECT * FROM talep_form Where id = $prd->talep_id")->row();
                $t_code = $talep_details->code;
                $href='/hizmet/view/'.$prd->talep_id;

            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->created_at;
            $row[] = $prd->item_name.' '.$prd->item_desc;//demirbas_table_to_name($prd->table_name,$prd->firma_demirbas_id);
            $row[] = amountFormat_s($prd->product_qty).' '.units_($prd->unit_id)['name'];
            $row[] = amountFormat($prd->price);
            $row[] = amountFormat(floatval($prd->price)*floatval($prd->product_qty));
            $row[] = "<a href='$href' class='btn btn-info btn-sm' target='_blank'><i class='fa fa-eye'></i> $t_code</a>";
            $row[] = $prd->code;
            $row[] = $prd->status_name;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_gider(),
            "recordsFiltered" => $this->model->count_filtered_gider(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_gider_firma(){
        $list = $this->model->ajax_list_gider_firma();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->created_at;
            $row[] = $prd->dg_name;
            $row[] = amountFormat_s($prd->product_qty).' '.units_($prd->unit_id)['name'];
            $row[] = amountFormat($prd->price);
            $row[] = amountFormat(floatval($prd->price)*floatval($prd->product_qty));
            $row[] = $prd->code;
            $row[] = $prd->status_name;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_gider_firma(),
            "recordsFiltered" => $this->model->count_filtered_gider_firma(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_view_alt(){
        $list = $this->model->ajax_list_view_alt();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $total=demirbas_alt_gider_total($prd->id);

            $btn="<a href='/demirbas/gider_view/$prd->id' class='btn btn-outline-info'><i class='fa fa-eye'></i></a>";
            if(parent_demirbas_kontrol($prd->id)){
                $btn="<a href='/demirbas/alt_view/$prd->id' class='btn btn-outline-info'><i class='fa fa-eye'></i></a>";
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->code;
            $row[] = $prd->name;
            $row[] = amountFormat($total);
            $row[] = $btn." <button demirbas_id='$prd->id' class='btn btn-outline-warning edit_button'><i class='fa fa-pen'></i></button>";
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_view_alt(),
            "recordsFiltered" => $this->model->count_filtered_view_alt(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function update()
    {

        if (!$this->aauth->premission(87)->update) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {
            $this->db->trans_start();
            $result = $this->model->update();
            if ($result['status']) {
                echo json_encode(array('status' => 200, 'message' => 'Başarılı'));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' => 'Hata Aldınız.Lütfen Yöneticiye Başvurun.'));
            }
        }
    }


    public function create_save(){

        if (!$this->aauth->premission(87)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->create_save();
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

    public function gider_create_save(){

        if (!$this->aauth->premission(87)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->gider_create_save();
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

    public function gider_create_form(){

        if (!$this->aauth->premission(87)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $file_id = $this->input->post('file_id');
            $type = $this->input->post('type'); // 1 ise cari gider talep
            $result = $this->model->gider_create_form($file_id,$type);
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
    public function get_parent_kontrol(){
        if (!$this->aauth->premission(87)->read) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->get_parent_kontrol();
            if($result['status']){
                echo json_encode(array('status' => 200, 'items' =>$result['items']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['message']));
            }
        }
    }

    public function get_firma_demirbas(){
        $result = $this->model->get_firma_demirbas();
        if($result['status']){
            echo json_encode(array('status' => 200, 'items' =>$result['items'],'tip'=>$result['tip']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function get_parent_list(){
        $result = $this->model->get_parent_list();
        if($result['status']){

            echo json_encode(array(
                'status' => 200,
                'items' =>$result['items'],
                'firma_item_list'=>$result['firma_item_list'],
                'firma_item_list_durum'=>$result['firma_item_list_durum']
            ));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function get_db_list(){

        $list = $this->db->query("SHOW TABLES");
        $table_list=[];
        foreach ($list->result() as $items){
            $db_details  = db_details(1); // Link DB Bilgileri
            $table_name='Tables_in_'.$db_details->db_name;
            $table_list[]=$items->$table_name;
        }
        if($table_list){
            echo json_encode(array('status' => 200, 'items' =>$table_list));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>'Bulunamadı'));
        }
    }

    public function item_views($id,$str)
    {
        if (!$this->aauth->premission(87)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        } else {




            $data['demisbas_id']=$id;
            $data['table_name']=$str;
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Detaylar';
            $this->load->view('fixed/header', $head);
            $this->load->view('demirbas/item_views',$data);
            $this->load->view('fixed/footer');
        }
    }

}