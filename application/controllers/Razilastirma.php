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

class Razilastirma extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('razilastirma_model', 'model');
        $this->load->model('customers_model', 'customers');
        $this->load->model('projects_model', 'projects');
        $this->load->model('projeiskalemleri_model', 'projeiskalemleri');
        $this->load->model('tools_model', 'tools');
        $this->load->model('communication_model');
        $this->load->library("Aauth");
        $this->load->library("Custom");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
     
    }

    public function list($id)
    {
        if (!$this->aauth->premission(27)) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $data['details'] = $this->customers->details($id);
        $data['money'] = $this->customers->money_details($id);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['id'] = $id;
        $head['title'] = 'Razılaştırma';
        $this->load->view('fixed/header', $head);
        $this->load->view('razilastirma/list',$data);
        $this->load->view('fixed/footer');
    }



    public function ajax_list_projects(){
        if (!$this->aauth->premission(3)) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }

        $cid = $this->input->post('cid');
        $list = $this->model->get_datatables_details_proje($cid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $status ='';
            $pt_status ='Bekliyor';

            $disabled='';
            if($prd->bildirim_durumu==0){
                $status = "<button class='btn btn-warning btn-sm razilastirma_onay' data-object-id='" . $prd->id . "' >Onaya Sun</button>";
            }
            else {
                $status="<button class='btn btn-warning btn-sm razilastirma_onay_detay' data-object-id='" . $prd->id . "' >Onaya Sunuldu</button>";
                $disabled='disabled="'.$disabled.'" ';

            }



            $pt_status = razilastirma_status($prd->razi_status)->name;

            if($prd->razi_status==3){
                $pt_status="<button type='button' class='btn btn-success forma2_list_view' razilastirma_id='$prd->id'>Forma 2 Bağlandı</button>";
            }

            $disabled_frm = razilastirma_status($prd->razi_status)->forma_2_status;



            $pdf = "<a href ='/userfiles/product/".$prd->file."' target='_blank' class='btn btn-info btn-sm '>PDF</a>";
            $islemler = '
                           
                            
                            <button '.$disabled.'  type="button" razilastirma_id="' . $prd->id . '" class="btn btn-purple btn-sm edit_razilastirma"><span class="fa fa-edit"></span></button>
                           
                            <button  '.$disabled.'  type="button" razilastirma_id="' . $prd->id . '"  class="btn btn-danger btn-sm  delete_rezilastirma"><span class="fa fa-trash"></span></button>
                            <button  '.$disabled_frm.'  type="button" razilastirma_id="' . $prd->id . '"  class="btn btn-success btn-sm  razilastirma_forma_2"><span class="fa fa-plus"></span></button>

             ';
            $no++;
            $row = array();
            $row[] = $prd->code;
            $row[] = $prd->company;
            $row[] = $prd->odeme_sekli_name;
            $row[] = amountFormat_s($prd->tax_oran);
            $row[] = amountFormat($prd->net_tutar);
            $row[] = amountFormat($prd->tax_tutar);
            $row[] = amountFormat($prd->genel_tutar);
            $row[] = $status;
            $row[] = $pt_status;
            $row[] = $islemler;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_proje($cid),
            "recordsFiltered" => $this->model->count_filtered_proje($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list(){
        if (!$this->aauth->premission(3)) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }

        $cid = $this->input->post('cid');
        $list = $this->model->get_datatables_details($cid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $status ='';
            $pt_status ='Bekliyor';

            $disabled='';
            if($prd->bildirim_durumu==0){
                $status = "<button class='btn btn-warning btn-sm razilastirma_onay' data-object-id='" . $prd->id . "' >Onaya Sun</button>";
            }
            else {
                $status="<button class='btn btn-warning btn-sm razilastirma_onay_detay' data-object-id='" . $prd->id . "' >Onaya Sunuldu</button>";
                $disabled='disabled="'.$disabled.'" ';
            }
            if($prd->razi_status==1){
                $pt_status='Onaylandı';
            }

            else if($prd->razi_status==2){
                $pt_status='İptal Edildi';
            }

            $pdf = "<a href ='/userfiles/product/".$prd->file."' target='_blank' class='btn btn-info btn-sm '>PDF</a>";
            $islemler = '
                           
                            
                             <button type="button" data-object-id="' . $prd->id . '" class="btn btn-success btn-sm view"> <span class="icon-eye"></span></button>
                          
                            <button '.$disabled.'  type="button" data-object-id="' . $prd->id . '" class="btn btn-purple btn-sm edit"><span class="fa fa-edit"></span></button>
                           
                            <button   type="button" data-object-id="' . $prd->id . '" class="btn btn-danger btn-sm  delete"><span class="fa fa-trash"></span></button>

             ';
            $no++;
            $row = array();
            $row[] = $prd->proje_name;
            $row[] = $prd->code;
            $row[] = $prd->muqavele_no;
            $row[] = $prd->date;
            $row[] = $prd->odeme_tipi_name;
            $row[] = $prd->odeme_sekli_name;
            $row[] = $prd->oran;
            $row[] = $pdf;
            $row[] = $status;
            $row[] = $pt_status;
            $row[] = $islemler;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all($cid),
            "recordsFiltered" => $this->model->count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_bekleyen(){
        if (!$this->aauth->premission(3)) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }

        $user_id = $this->aauth->get_user()->id;
        $list = $this->model->get_datatables_details_bekleyen($user_id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $status ='';

            $disabled='';
            if($prd->status==0){
                $status = "<button class='btn btn-warning btn-sm razilastirma_onay' data-object-id='" . $prd->id . "' >Protokole Onay Ver</button>";
            }

            $pdf = "<a href ='/userfiles/product/".$prd->file."' target='_blank' class='btn btn-info btn-sm '>PDF</a>";
            $islemler = '<div class="btn-group">
                            <button type="button" class="btn btn btn-primary dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i>  </button>
                            <div class="dropdown-menu">&nbsp;
                             <button type="button" data-object-id="' . $prd->id . '" class="btn btn-success btn-sm view"> <span class="icon-eye"></span>Göster</button>


                </div>';
            $cari_name = customer_details($prd->cari_id)['company'];
            $no++;
            $row = array();
            $row[] = $cari_name;
            $row[] = $prd->proje_name;
            $row[] = $prd->code;
            $row[] = $prd->muqavele_no;
            $row[] = $prd->date;
//            $row[] = $prd->odeme_tipi_name;
            $row[] = $prd->odeme_sekli_name;
//            $row[] = $prd->oran;
            $row[] = $pdf;
            $row[] = $status;
            $row[] = $islemler;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_bekleyen($user_id),
            "recordsFiltered" => $this->model->count_filtered_bekleyen($user_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function ajax_list_all(){
        if (!$this->aauth->premission(3)) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }

        $list = $this->model->ajax_list_all();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $status ='';
            $pt_status ='Bekliyor';

            $disabled='';
            if($prd->bildirim_durumu==0){
                $status = "<button class='btn btn-warning btn-sm razilastirma_onay' data-object-id='" . $prd->id . "' >Onaya Sun</button>";
            }
            else {
                $status="<button class='btn btn-warning btn-sm razilastirma_onay_detay' data-object-id='" . $prd->id . "' >Onaya Sunuldu</button>";
                $disabled='disabled="'.$disabled.'" ';

            }



            $pt_status = razilastirma_status($prd->razi_status)->name;

            $forma_2_kontrol = $this->db->query("SELECT * FROM forma_2_to_muqavele Where muqavele_id = $prd->id")->num_rows();


            if($forma_2_kontrol){
                $pt_status="<button type='button' class='btn btn-success forma2_list_view' razilastirma_id='$prd->id'>Forma 2 Bağlandı</button>";
            }

            $disabled_frm = razilastirma_status($prd->razi_status)->forma_2_status;



            $pdf = "<a href ='/userfiles/product/".$prd->file."' target='_blank' class='btn btn-info btn-sm '>PDF</a>";
            $islemler = '
                             <button type="button" data-object-id="' . $prd->id . '" class="btn btn-success btn-sm view"> <span class="icon-eye"></span></button>
                            <button  '.$disabled_frm.'  type="button" razilastirma_id="' . $prd->id . '"  class="btn btn-success btn-sm  razilastirma_forma_2"><span class="fa fa-plus"></span></button>

             ';


            $net_tutar=$prd->net_tutar;
            $tax_tutar=$prd->tax_tutar;
            $genel_tutar=$prd->genel_tutar;

            if($prd->net_tutar==0){
                $form_total = $this->model->form_total($prd->id);
                $net_tutar=$form_total;
                if($prd->tax_oran > 0){
                    $tax_tutar = $net_tutar* (1+($prd->tax_oran/100));

                }
                $genel_tutar = $tax_tutar+$net_tutar;


            }

            $no++;
            $row = array();
            $row[] = $prd->code;
            $row[] = $prd->proje_name;
            $row[] = $prd->company;
            $row[] = $prd->odeme_sekli_name;
            $row[] = amountFormat_s($prd->tax_oran);
            $row[] = amountFormat($net_tutar);
            $row[] = amountFormat($tax_tutar);
            $row[] = amountFormat($genel_tutar);
            $row[] = $status;
            $row[] = $pt_status;
            $row[] = $islemler;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_list(),
            "recordsFiltered" => $this->model->count_filtered_list(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function razilastirma_list_all()
    {
        if (!$this->aauth->premission(27)) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Razılaştırma';
        $this->load->view('fixed/header', $head);
        $this->load->view('razilastirma/razilastirma_list_all');
        $this->load->view('fixed/footer');
    }

    public function get_tables(){
        $odeme_metodlari = $this->model->odeme_metodlari();
        $odeme_tipi = $this->model->odeme_tipleri();
        $projeler = all_projects();
        $personeller = all_personel();
        $para_birimleri = para_birimi();

        echo json_encode(array(
            'status' => 'Success',
            'odeme_metodlari' => $odeme_metodlari,
            'odeme_tipi' => $odeme_tipi,
            'projeler' => $projeler,
            'personeller' => $personeller,
            'para_birimleri' => $para_birimleri,
        ));
    }

    public function todo_load_list_forma2()

    {

        $pid = $this->input->post('pid');

        $list = $this->projeiskalemleri->task_datatables($pid);

        $data = array();

        $no = $this->input->post('start');




        foreach ($list as $task) {

            $no++;

            $name = '<a class="check text-default" data-id="' . $task->id . '" data-stat="Due"> <i class="icon-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';

            if ($task->status == 'Done') {

                $name = '<a class="check text-success" data-id="' . $task->id . '" data-stat="Done"> <i class="icon-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';

            }



            $style='';

            if(isset($task->toplam_fiyat))
            {
                if($task->toplam_fiyat < is_kalemleri_invoice($task->id,$pid))
                {
                    $style="background-color: red;color: white;";

                }


            }

            $ana_asama_adi=task_to_asama($task->asama_id);
            $ana_asama_id=$task->asama_id;
            $unit_n=units_($task->unit)['name'];

            $row = array();

            $row[] = "<input type='checkbox' class='form-control task_id'
            proje_bolum_id ='$task->bolum_id'
            proje_bolum_name ='$task->bolum_adi'
            ana_asama_id='$ana_asama_id'
            ana_asama_name='$ana_asama_adi'
            hizmet_name='$task->name'
            birim_fiyati='$task->fiyat'
            quantity_='$task->quantity'
            total_fiyat='$task->toplam_fiyat'
            unit_id='$task->unit'
            unit_name='$unit_n'

             value='$task->id'>";
            $row[] =   $task->name;
            $row[] = task_to_asama($task->asama_id);
            $row[] = $task->bolum_adi;
            $row[] = $task->quantity;
            $row[] = units_($task->unit)['name'];
            /* $row[] = dateformat($task->start);
            $row[] = dateformat($task->duedate);*/


            $row[]=$style;

            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->projeiskalemleri->task_count_all($pid),

            "recordsFiltered" => $this->projeiskalemleri->task_count_filtered($pid),

            "data" => $data,

        );

        echo json_encode($output);

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

                'accept_file_types' => '/\.(pdf|gif|jpe?g|png|xlsx)$/i', 'upload_dir' => FCPATH . 'userfiles/product/', 'upload_url' => base_url() . 'userfile/product/'

            ));

        }




    }
//    public function save_razilastirma(){
//        die();
//
//        $talep_no = numaric(13);
//        $proje_id = $this->input->post('proje_id');
//        $odeme_tipi = $this->input->post('odeme_tipi');
//        $odeme_sekli = $this->input->post('odeme_sekli');
//        $description = $this->input->post('description');
//        $oran = $this->input->post('oran');
//        $cari_id = $this->input->post('cari_id');
//        $image_text = $this->input->post('image_text');
//        $muqavele_no = $this->input->post('muqavele_no');
//        $date = $this->input->post('date');
//        $proje_mudur_id = $this->input->post('proje_mudur_id');
//        $genel_mudur_id = $this->input->post('genel_mudur_id');
//
//        $cur_id = $this->input->post('cur_id');
//        $tax_status = $this->input->post('tax_status');
//        $tax_oran = $this->input->post('tax_oran');
//
//
//        $this->db->trans_start();
//
//        $data = array(
//            'proje_id' => $proje_id,
//            'odeme_tipi' => $odeme_tipi,
//            'odeme_sekli' => $odeme_sekli,
//            'description' => $description,
//            'user_id' => $this->aauth->get_user()->id,
//            'file' => $image_text,
//            'tip' => 1,
//            'oran' => $oran,
//            'muqavele_no' => $muqavele_no,
//            'cari_id' => $cari_id,
//            'date' => $date,
//            'code' => $talep_no,
//            'cur_id' => $cur_id,
//            'tax_status' => $tax_status,
//            'tax_oran' => $tax_oran,
//            'loc' =>  $this->session->userdata('set_firma_id')
//
//        );
//        if ($this->db->insert('cari_razilastirma', $data)) {
//            $last_id = $this->db->insert_id();
//
//            // Onay Sistemi
//
//            $data_onay_1 = array(
//                'razilastirma_id' => $last_id,
//                'staff_id' => $proje_mudur_id,
//                'tip' => 1,
//                'status' => 0,// Sıra bunda
//
//            );
//            $this->db->insert('razilastirma_onay', $data_onay_1);
//
//            $data_onay_2 = array(
//                'razilastirma_id' => $last_id,
//                'staff_id' => $genel_mudur_id,
//                'tip' => 2,
//                'status' => 0,// Beklemede
//
//            );
//            $this->db->insert('razilastirma_onay', $data_onay_2);
//
//            // Onay Sistemi
//
//            $operator= "deger+1";
//            $this->db->set('deger', "$operator", FALSE);
//            $this->db->where('tip', 13);
//            $this->db->update('numaric');
//
//            $productlist = [];
//            $prodindex = 0;
//            $product_details = $this->input->post('product_details');
//            foreach ($product_details as $items){
//                if($items['pid']!=0) {
//                    $data=[
//                        'razilastirma_id'=>$last_id,
//                        'task_id'=>$items['pid'],
//                        'qty'=>$items['qty'],
//                        'price'=>$items['price'],
//                        'toplam_tutar'=>$items['toplam_tutar'],
//                        'unit_id'=>$items['unit_id'],
//                        'unit_name'=>units_($items['unit_id'])['name'],
//                    ];
//
//                    $productlist[$prodindex] = $data;
//                    $prodindex++;
//                }
//
//            }
//            if ($prodindex > 0) {
//                if( $this->db->insert_batch('cari_razilastirma_item', $productlist)){
//
//                    $this->aauth->applog("Cariye Razılatırma Eklendi Cari_ID : " . $cari_id.' Razılaştırma ID : '.$last_id, $this->aauth->get_user()->username);
//                    echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Razılaştırma Oluşturuldu"));
//
//                    $this->db->trans_complete();
//                }
//                else {
//                    $this->db->trans_rollback();
//                    echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
//                }
//            }
//
//            $this->db->trans_complete();
//        }
//        else {
//            $this->db->trans_rollback();
//            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
//        }
//
//    }

    public function save_razilastirma(){


        $talep_no = numaric(13);
        $proje_id = $this->input->post('proje_id');
        $odeme_tipi = $this->input->post('method_id');
        $description = $this->input->post('description');
        $cari_id = $this->input->post('cari_id');
        $tax_oranpost = $this->input->post('tax_oran');
        $tax_oran = isset($tax_oranpost)?$tax_oranpost:0;
        $muqavele_no = $this->input->post('nuqavele_no');
        $date = $this->input->post('g_date');
        $image_text = $this->input->post('image_text');
        $tax_status = 'no';
        $cur_id = 1;

        $proje_details = proje_details($proje_id);


        $proje_mudur_id = $proje_details->proje_muduru_id;
        $genel_mudur_id = $proje_details->genel_mudur_id;





        $this->db->trans_start();

        $data = array(
            'proje_id' => $proje_id,
            'odeme_tipi' => 0,
            'odeme_sekli' => $odeme_tipi,
            'description' => $description,
            'user_id' => $this->aauth->get_user()->id,
            'file' => $image_text,
            'tip' => 1,
            'oran' => 0,
            'muqavele_no' => $muqavele_no,
            'cari_id' => $cari_id,
            'date' => $date,
            'code' => $talep_no,
            'cur_id' => $cur_id,
            'tax_status' => $tax_status,
            'tax_oran' => $tax_oran,
            'net_tutar' =>  $this->input->post('net_tutar_db'),
            'tax_tutar' =>  $this->input->post('kdv_tutar_db'),
            'genel_tutar' =>  $this->input->post('genel_tutar_db'),
            'loc' =>  $this->session->userdata('set_firma_id')

        );
        if ($this->db->insert('cari_razilastirma', $data)) {
            $last_id = $this->db->insert_id();


            $operator= "deger+1";
            $this->db->set('deger', "$operator", FALSE);
            $this->db->where('tip', 13);
            $this->db->update('numaric');

            $productlist = [];
            $prodindex = 0;

            $price = $this->input->post('price');
            $item_task_id = $this->input->post('item_task_id');
            $qty = $this->input->post('qty');

            foreach ($item_task_id as $key=> $items){
                if($item_task_id[$key]!=0) {

                    $is_kalemi_details = is_kalemi_details($item_task_id[$key]);
                    $total = floatval($qty[$key])*floatval($price[$key]);
                    $data=[
                        'razilastirma_id'=>$last_id,
                        'task_id'=>$item_task_id[$key],
                        'qty'=>$qty[$key],
                        'price'=>$price[$key],
                        'toplam_tutar'=>$total,
                        'unit_id'=>$is_kalemi_details->unit,
                        'unit_name'=>units_($is_kalemi_details->unit)['name'],
                    ];

                    $productlist[$prodindex] = $data;
                    $prodindex++;
                }

            }
            if ($prodindex > 0) {
                if( $this->db->insert_batch('cari_razilastirma_item', $productlist)){

                    $this->aauth->applog("Cariye Razılatırma Eklendi Cari_ID : " . $cari_id.' Razılaştırma ID : '.$last_id, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Razılaştırma Oluşturuldu"));

                    $this->db->trans_complete();
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
                }
            }

            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }

    }


    public function update_razilastirma(){





        $odeme_tipi = $this->input->post('method_id');
        $description = $this->input->post('description');
        $cari_id = $this->input->post('cari_id');
        $tax_oranpost = $this->input->post('tax_oran');
        $tax_oran = isset($tax_oranpost)?$tax_oranpost:0;
        $muqavele_no = $this->input->post('nuqavele_no');
        $date = $this->input->post('g_date');
        $image_text = $this->input->post('image_text');
        $this->db->trans_start();
        $data = array(
            'odeme_sekli' => $odeme_tipi,
            'description' => $description,
            'file' => $image_text,
            'muqavele_no' => $muqavele_no,
            'cari_id' => $cari_id,
            'date' => $date,
            'tax_oran' => $tax_oran,
            'net_tutar' =>  $this->input->post('net_tutar_db'),
            'tax_tutar' =>  $this->input->post('kdv_tutar_db'),
            'genel_tutar' =>  $this->input->post('genel_tutar_db'),
        );
            $this->db->where('id', $this->input->post('razilastirma_id'));
            if($this->db->update('cari_razilastirma', $data)) {
            $last_id = $this->input->post('razilastirma_id');
            $this->db->set('deleted_at', "NOW()", FALSE);
            $this->db->where('razilastirma_id', $this->input->post('razilastirma_id'));
            $this->db->update('cari_razilastirma_item');
            $this->db->delete('cari_razilastirma_item', array('razilastirma_id' => $this->input->post('razilastirma_id')));


            $productlist = [];
            $prodindex = 0;
            $price = $this->input->post('price');
            $item_task_id = $this->input->post('item_task_id');
            $qty = $this->input->post('qty');
            foreach ($item_task_id as $key=> $items){
                    if($item_task_id[$key]!=0) {

                        $is_kalemi_details = is_kalemi_details($item_task_id[$key]);
                        $total = floatval($qty[$key])*floatval($price[$key]);
                        $data=[
                            'razilastirma_id'=>$last_id,
                            'task_id'=>$item_task_id[$key],
                            'qty'=>$qty[$key],
                            'price'=>$price[$key],
                            'toplam_tutar'=>$total,
                            'unit_id'=>$is_kalemi_details->unit,
                            'unit_name'=>units_($is_kalemi_details->unit)['name'],
                        ];

                        $productlist[$prodindex] = $data;
                        $prodindex++;
                    }

                }
            if ($prodindex > 0) {
                if( $this->db->insert_batch('cari_razilastirma_item', $productlist)){

                    $this->aauth->applog("Cariye Razılatırma Düzenlendi  Razılaştırma Eski ID : ".$this->input->post('razilastirma_id').' Yeni ID '.$last_id, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Razılaştırma Güncellendi"));

                    $this->db->trans_complete();
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
                }
            }

            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }

//    public function update_razilastirma(){
//
//
//
//        $proje_id = $this->input->post('proje_id');
//        $odeme_tipi = $this->input->post('odeme_tipi');
//        $odeme_sekli = $this->input->post('odeme_sekli');
//        $description = $this->input->post('description');
//        $oran = $this->input->post('oran');
//        $image_text = $this->input->post('image_text');
//        $muqavele_no = $this->input->post('muqavele_no');
//        $genel_mudur_id = $this->input->post('genel_mudur_id');
//        $proje_mudur_id = $this->input->post('proje_mudur_id');
//        $date = $this->input->post('date');
//        $cur_id = $this->input->post('cur_id');
//        $tax_status = $this->input->post('tax_status');
//        $tax_oran = $this->input->post('tax_oran');
//
//        $this->db->trans_start();
//
//        $select =  $this->db->query("SELECT * FROM cari_razilastirma where id =".$this->input->post('razilastirma_id'))->row();
//
//        $talep_no = $select->code;
//        $cari_id = $select->cari_id;
//        $this->db->set('deleted_at', "NOW()", FALSE);
//        $this->db->where('id', $this->input->post('razilastirma_id'));
//        $this->db->update('cari_razilastirma');
//
//
//        $data = array(
//            'proje_id' => $proje_id,
//            'odeme_tipi' => $odeme_tipi,
//            'odeme_sekli' => $odeme_sekli,
//            'description' => $description,
//            'user_id' => $this->aauth->get_user()->id,
//            'file' => $image_text,
//            'oran' => $oran,
//            'muqavele_no' => $muqavele_no,
//            'date' => $date,
//            'code' => $talep_no,
//            'tip' => 1,
//            'cari_id' => $cari_id,
//            'cur_id' => $cur_id,
//            'tax_status' => $tax_status,
//            'tax_oran' => $tax_oran,
//
//        );
////        $this->db->set($data);
////        $this->db->where('id', $this->input->post('razilastirma_id'));
////        if($this->db->update('cari_razilastirma', $data)) {
//        if ($this->db->insert('cari_razilastirma', $data)) {
//            $last_id = $this->db->insert_id();
//            $this->db->set('deleted_at', "NOW()", FALSE);
//            $this->db->where('razilastirma_id', $this->input->post('razilastirma_id'));
//            $this->db->update('cari_razilastirma_item');
//            //$this->db->delete('cari_razilastirma_item', array('razilastirma_id' => $this->input->post('razilastirma_id')));
//            $this->db->delete('razilastirma_onay', array('razilastirma_id' => $this->input->post('razilastirma_id')));
//
//            // Onay Sistemi
//
//            $data_onay_1 = array(
//                'razilastirma_id' => $last_id,
//                'staff_id' => $proje_mudur_id,
//                'tip' => 1,
//                'status' => 0,// Sıra bunda
//
//            );
//            $this->db->insert('razilastirma_onay', $data_onay_1);
//
//            $data_onay_2 = array(
//                'razilastirma_id' => $last_id,
//                'staff_id' => $genel_mudur_id,
//                'tip' => 2,
//                'status' => 0,// Beklemede
//
//            );
//            $this->db->insert('razilastirma_onay', $data_onay_2);
//
//            // Onay Sistemi
//
//            $productlist = [];
//            $prodindex = 0;
//            $product_details = $this->input->post('product_details');
//            foreach ($product_details as $items){
//                if($items['pid']!=0) {
//                    $data=[
//                        'razilastirma_id'=>$last_id,
//                        'task_id'=>$items['pid'],
//                        'qty'=>$items['qty'],
//                        'toplam_tutar'=>$items['toplam_tutar'],
//                        'price'=>$items['price'],
//                        'unit_id'=>$items['unit_id'],
//                        'unit_name'=>units_($items['unit_id'])['name'],
//                    ];
//
//                    $productlist[$prodindex] = $data;
//                    $prodindex++;
//                }
//
//            }
//            if ($prodindex > 0) {
//                if( $this->db->insert_batch('cari_razilastirma_item', $productlist)){
//
//                    $this->aauth->applog("Cariye Razılatırma Düzenlendi  Razılaştırma Eski ID : ".$this->input->post('razilastirma_id').' Yeni ID '.$last_id, $this->aauth->get_user()->username);
//                    echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Razılaştırma Güncellendi"));
//
//                    $this->db->trans_complete();
//                }
//                else {
//                    $this->db->trans_rollback();
//                    echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
//                }
//            }
//
//            $this->db->trans_complete();
//        }
//        else {
//            $this->db->trans_rollback();
//            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
//        }
//    }
    public function get_razi_info(){
        $id = $this->input->post('id');
        $razilastirma_details = $this->model->details($id);

        $cur_name = para_birimi_id($razilastirma_details->cur_id)['code'];
        $tax_durum = 'Hariç';
        if($razilastirma_details->tax_status=='yes'){
            $tax_durum = 'Dahil';
        }

        $proje_muduru = '';
        $genel_muduru = '';
        $item_details = $this->model->item_details($id);
        $odeme_metodlari = $this->model->odeme_metodlari();
        $odeme_tipi = $this->model->odeme_tipleri();
        $projeler = $this->model->projeler();

        $birimler = units();
        echo json_encode(array('status' => 'Success',
            'details'=>$razilastirma_details,
            'item_details'=>$item_details,
            'odeme_metodlari'=>$odeme_metodlari,
            'odeme_tipi'=>$odeme_tipi,
            'proje_muduru'=>$proje_muduru,
            'genel_muduru'=>$genel_muduru,
            'birimler'=>$birimler,
            'tax_durum'=>$tax_durum,
            'cur_name'=>$cur_name,
        ));

    }
    public function birimler(){

        $birimler = units();
        echo json_encode(array('status' => 'Success',
            'birimler'=>$birimler,
        ));

    }

    public function delete_razilastirma(){
        $id = $this->input->post('id');
        $this->db->set('deleted_at', "NOW()", FALSE);
        $this->db->where('id', $id);
        if($this->db->update('cari_razilastirma')){

            //ITEM
            $this->db->set('deleted_at', "NOW()", FALSE);
            $this->db->where('razilastirma_id', $this->input->post('razilastirma_id'));
            $this->db->update('cari_razilastirma_item');
            //ITEM

            $this->aauth->applog("Razılatırma Silindi Razılaştırma ID : '".$id, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Silindi'));

        }
        else {
            echo json_encode(array('status' => 'Error','message'=>'Hata Oluştu'));
        }

    }
    public function change_status(){
        $id = $this->input->post('id');
        $staff_id =  $this->aauth->get_user()->id;
        $status = $this->input->post('status');
        $desc = $this->input->post('desc');

        $this->db->set('`status`', $status, FALSE);
        $this->db->set('`desc`', "'$desc'", FALSE);
        $this->db->set('next_status', 0, FALSE);
        $this->db->where('razilastirma_id', $id);
        $this->db->where('staff_id', $staff_id);
        if($this->db->update('razilastirma_onay'))
        {
            $g_kontrol = $this->db->query("SELECT * FROM razilastirma_onay where razilastirma_id = $id and staff_id=$staff_id and tip=1");
            if($g_kontrol->num_rows()){
                if($status==1){
                    $this->db->set('next_status', 1, FALSE);
                    $this->db->where('razilastirma_id', $id);
                    $this->db->where('staff_id!=', $staff_id);
                    $this->db->update('razilastirma_onay');
                }
            }

            $g_kontrol_ = $this->db->query("SELECT * FROM razilastirma_onay where razilastirma_id = $id and staff_id=$staff_id and tip=2");
            if($g_kontrol_->num_rows()){
                $this->db->set('razi_status', $status, FALSE);
                $this->db->where('id', $id);
                $this->db->update('cari_razilastirma');
            }


            if($staff_id==61){
                $razilastirma_details = $this->db->query("SELECT * FROM cari_razilastirma where id = $id")->row();
                $subject = 'Razılaştırma Onayı';
                $message = $razilastirma_details->code.' Numaralı Razılaştırmaya Onay Verildi.';
                $proje_sorumlusu_email = personel_detailsa(832)['email'];
                $proje_sorumlusu_email2 = personel_detailsa(831)['email'];

                $recipients = array($proje_sorumlusu_email,$proje_sorumlusu_email2);

                $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$id);
            }

            $this->aauth->applog("Razılatırmaya Durum Bildirildi Durum ID : ".$status."  R ID : '".$id, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Durum Bildirildi'));

        }
        else {
            echo json_encode(array('status' => 'Error','message'=>'Hata Oluştu'));
        }

    }

    public function onay_olustur()
    {
        $this->db->trans_start();
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $desc = $this->input->post('desc');
        $details = $this->db->query("SELECT * FROM cari_razilastirma where id = $id")->row();
        $new_id=0;
        $new_user_id=0;

        if($status==1){
            $new_id_control = $this->db->query("SELECT * FROM `razilastirma_onay` Where razilastirma_id=$id and staff=0 and status is Null ORDER BY `razilastirma_onay`.`id` ASC LIMIT 1");
            if($new_id_control->num_rows()){
                $new_id = $new_id_control->row()->id;
                $new_user_id = $new_id_control->row()->user_id;
            }


            $data = array(
                'status' => 1,
                'staff' => 0,
            );

            $this->db->where('user_id',$this->aauth->get_user()->id);
            $this->db->where('staff',1);
            $this->db->set($data);
            $this->db->where('razilastirma_id', $id);
            if ($this->db->update('razilastirma_onay', $data)) {
                if($new_id){

                    $mesaj=$details->code.' Numaralı Razilastirma Talep Formu Onayınızı Beklemektedir';
                    //$this->model->send_mail($new_user_id,'Razilastirma Talep Onayı',$mesaj);

                    // Bir Sonraki Onay
                    $data_new=array(
                        'staff'=>1,
                    );
                    $this->db->where('id',$new_id);
                    $this->db->set($data_new);
                    $this->db->update('razilastirma_onay', $data_new);
                    // Bir Sonraki Onay
                }
                else {
//                $mesaj=$details->code.' Numaralı Gider Talep Formu Onaylanmıştır. İşleminiz Ödeme Emri Beklemektedir';
//                $this->model->send_mail($details->talep_eden_pers_id,'Gider Talep Formu',$mesaj);
                    //Onaylandı
                    $data_Form=array(
                        'razi_status'=>1,
                    );
                    //Onaylandı
                    $this->db->set($data_Form);
                    $this->db->where('id', $id);
                    $this->db->update('cari_razilastirma', $data_Form);
                    //Kontrol Bekliyor

                    $subject = 'Razılaştırma  Onayı';
                    $message = $details->code.' Numaralı Razılaştırmaya Onay Verildi.';
                    $proje_sorumlusu_email = personel_detailsa(832)['email'];
                    $proje_sorumlusu_email2 = personel_detailsa(831)['email'];
                    $talep_acan_id = $details->user_id;

                    $recipients = array($proje_sorumlusu_email,$proje_sorumlusu_email2,$talep_acan_id);
                    $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$id);

                }

                $this->aauth->applog("Razılaştırma Talebine Onay Verildi :  ID : ".$id, $this->aauth->get_user()->username);
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success','message'=>'Başarıyla Onay Verildi'));

            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));

            }
        }
        else {
            $data_Form=array(
                'razi_status'=>2,
            );
            //Onaylandı
            $this->db->set($data_Form);
            $this->db->where('id', $id);
            $this->db->update('cari_razilastirma', $data_Form);


            $subject = 'Razılaştırma  İptali';
            $message = $details->code.' Numaralı Razılaştırmaya İptal Verildi.Açıklama :        '.$desc;
            $proje_sorumlusu_email = personel_detailsa(832)['email'];
            $proje_sorumlusu_email2 = personel_detailsa(831)['email'];
            $talep_acan_id = $details->user_id;

            $recipients = array($proje_sorumlusu_email,$proje_sorumlusu_email2,$talep_acan_id);
            $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$id);

            $this->aauth->applog("Razılaştırma Talebine İptal Verildi.Desc : ".$desc.' | Açıklama : '.$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla İptal Verildi'));


        }

    }

//    public function onay_start(){
//        $id = $this->input->post('id');
//        $sayi=0;
//        $onay_details = $this->db->query("SELECT * FROM razilastirma_onay Where razilastirma_id=$id and tip=1");
//        if($onay_details->num_rows()){
//            $staff_id = $onay_details->row()->staff_id;
//            $razilastirma_details = $this->db->query("SELECT * FROM cari_razilastirma where id = $id")->row();
//            $cari_name = customer_details($razilastirma_details->cari_id)['company'];
//            // Mail Gönderme
//
//
//
//            $subject = 'Razılaştırma Onayı';
//
//            $message = 'Sayın Proje Müdürü ' .$cari_name.' Firmasına Ait '. $razilastirma_details->code . ' Numaralı Razılaştırma Oluşturuldu. İnceleyip Onay İşleminiz Beklenmektedir.';
//
//            $message .= "<br><br><br><br>";
//
//            $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
//<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
//          ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
//
//            $proje_sorumlusu_email = personel_detailsa($staff_id)['email'];
//
//            $recipients = array($proje_sorumlusu_email);
//            $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$id);
//            $sayi = 1;
//
//
//
//
//        }
//        if($sayi){
//            $this->db->set('next_status', 1, FALSE);
//            $this->db->where('razilastirma_id', $id);
//            $this->db->where('tip', 1);
//            $this->db->update('razilastirma_onay');
//
//            $this->db->set('bildirim_durumu', 1, FALSE);
//            $this->db->where('id', $id);
//            $this->db->update('cari_razilastirma');
//
//            $this->aauth->applog("Razılatırma Onaya Sunuludu Razılaştırma ID : '".$id, $this->aauth->get_user()->username);
//            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Onaya Sunuldu'));
//        }
//        else {
//            echo json_encode(array('status' => 'Error','message'=>'Hata Oluştu'));
//        }
//
//    }

    public function onay_start()
    {
        $id = $this->input->post('id');
        $talep_kontrol  = $this->db->query("SELECT * FROM cari_razilastirma where id = $id")->num_rows();

        if($talep_kontrol){
            $details = $this->model->details($id);
            $cari_name = customer_details($details->cari_id)['company'];
            $data = array(
                'bildirim_durumu' => 1,
            );
            $this->db->set($data);
            $this->db->where('id', $id);
            if ($this->db->update('cari_razilastirma', $data)) {

                $users_ = onay_sort(15,$details->proje_id);
                if($users_){
                    foreach ($users_ as $items){
                        $staff=0;
                        if($items['sort']==1){
                            // bildirim maili at


                            $subject = 'Razılaştırma Onayı';
                            $message = 'Sayın Yetkili ' .$cari_name.' Firmasına Ait '. $details->code . ' Numaralı Razılaştırma Oluşturuldu. İnceleyip Onay İşleminiz Beklenmektedir.';
                            $message .= "<br><br><br><br>";

                            $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
          ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                            $proje_sorumlusu_email = personel_detailsa($items['user_id'])['email'];

                            $recipients = array($proje_sorumlusu_email);
                            $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$id);

                            // bildirim maili at
                            $staff=1;
                        }
                        $data_onay = array(
                            'razilastirma_id' => $id,
                            'staff' => $staff,
                            'sort' => $items['sort'],
                            'user_id' => $items['user_id'],
                        );
                        $this->db->insert('razilastirma_onay', $data_onay);
                    }

                    $this->aauth->applog("Razılaştırma Bildirim Başlatıldı :  ID : ".$id, $this->aauth->get_user()->username);
                    $this->db->trans_complete();
                    echo json_encode(array('status' => 'Success','message'=>'Başarıyla Bildirim Başlatıldı'));

                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Projenize Yetkili Kişiler Atanmamıştır.Bu Sebeple İşlem Yapamazsınız."));


                }



            }
            else {

                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
            }

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Razılaştırma Bulunamadı."));
        }
    }

    public function onay_mailleri($subject, $message, $recipients, $tip)
    {

        $attachmenttrue = false;
        $attachment = '';


        $this->communication_model->onay_mail($recipients, $subject, $message, $attachmenttrue, $attachment, $tip);
        return 1;

    }

    public function onay_details_get(){
        $id = $this->input->post('id');

//        $proje_muduru = $this->model->staff_id($id,1);
//        $genel_muduru = $this->model->staff_id($id,2);
//
//        $p_status = $this->model->staff_details($id,1);
//        $g_status = $this->model->staff_details($id,2);
//        $p_desc = $this->model->staff_details($id,1)->desc;
//        $g_desc = $this->model->staff_details($id,2)->desc;
//
//        $p_status_text='';
//        $g_status_text='';
//
//
//        if($p_status->status==0){
//            $p_status_text='Bekliyor';
//        }
//        else if($p_status->status==1){
//            $p_status_text='Onaylandı';
//        }
//        else if($p_status->status==2){
//            $p_status_text='İptal Edildi';
//        }
//
//        if($g_status->status==0){
//            $g_status_text='Bekliyor';
//        }
//        else if($g_status->status==1){
//            $g_status_text='Onaylandı';
//        }
//        else if($g_status->status==2){
//            $g_status_text='İptal Edildi';
//        }

        $html='';


        foreach (talep_onay_razilastirma($id) as $items) {
            $durum='Sıra Gelmedi';
            $button='<button class="btn btn-warning"><i class="fa fa-question"></i>&nbsp;Sıra Gelmedi</button>';
            if($items->status==1){
                $durum='Onaylandı';
            }
            if($items->staff==1 && $items->status==0){
                $durum='Gözləmedə';
            }

            $personel=personel_details($items->user_id);
            $html.="<span>$personel</span> <b>$durum</b><br>";
            }


        echo json_encode(array('status' => 'Success',
            'html'=>$html,
        ));
    }

    public function razi_count()
    {
        $result = $this->model->razi_count();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }

    }

    public function bekleyen_list(){
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Bekleyen Razılaştırma Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('razilastirma/bekleyen_list');
        $this->load->view('fixed/footer');
    }

    public function get_item()
    {
        $protokols=[];
        $id_ = $this->input->post('id');
        $details = $this->db->query("SELECT geopos_todolist.*,geopos_milestones.name as asama_adi,geopos_milestones.parent_id as parent_id,geopos_project_bolum.name
    as bolum_adi,geopos_project_bolum.id as bolum_id
     ,cari_razilastirma_item.qty as r_qty,
       cari_razilastirma_item.price as r_price,cari_razilastirma_item.unit_id as r_unit_id,cari_razilastirma_item.unit_name as r_unit_name FROM
        `cari_razilastirma_item`
            INNER JOIN geopos_todolist On cari_razilastirma_item.task_id = geopos_todolist.id
            LEFT JOIN geopos_milestones On geopos_todolist.asama_id = geopos_milestones.id
            LEFT JOIN geopos_project_bolum On geopos_milestones.bolum_id = geopos_project_bolum.id
Where cari_razilastirma_item.razilastirma_id = $id_ ");



        $protokols[]= $details->result_array();

        $details_new = $this->db->query("SELECT * FROM cari_razilastirma WHERE id=$id_")->row();




        echo json_encode(array('status' => 'Success', 'details' =>$protokols,'details_new'=>$details_new));
    }

    public function get_item_details()
    {
        $protokols=[];
        $asama_id = $this->input->post('asama_id');
        $unit = $this->input->post('unit');

        $ana_asama_adi=task_to_asama($asama_id);
        $unit_n=units_($unit)['name'];


        echo json_encode(array('status' => 'Success', 'ana_asama_adi' =>$ana_asama_adi,'unit_n'=>$unit_n));
    }
}
