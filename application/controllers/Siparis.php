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



class Siparis extends CI_Controller
{

    public function __construct()

    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('siparis_model', 'model');
        $this->load->model('uretim_model', 'uretim');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }
    public function index(){
        if (!$this->aauth->premission(10)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['title'] = "Sipariş";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('siparis/index');
        $this->load->view('fixed/footer');
    }
    public function ajax_list()
    {

        $list = $this->model->ajax_list();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $edit = "<button class='btn btn-warning edit' talep_id='$prd->id'><i class='fas fa-pencil-alt'></i></button>&nbsp;";
            $cancel = "<button class='btn btn-danger talep_sil' talep_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
            $view = "<a class='btn btn-success ' href='/siparis/view/$prd->id' ><i class='fa fa-eye'></i></a>&nbsp;";


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->invoice_no;
            $row[] = $prd->invoicedate;
            $row[] = $prd->company;
            $row[] = $prd->notes;
            $row[] = invoice_status($prd->status);
            $row[] = $view;
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
    public function create_save(){
        if (!$this->aauth->premission(10)->write) {
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
    public function update_save_siparis(){
        if (!$this->aauth->premission(10)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->update_save_siparis();
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
    public function view($id){
        if (!$this->aauth->premission(10)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['title'] = "Sipariş Görüntüleme";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['invoice']=$this->model->details($id);
        $data['products']=$this->model->product_details($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('siparis/view',$data);
        $this->load->view('fixed/footer');
    }
    public function status_change(){
        if (!$this->aauth->premission(10)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->status_change();
            if($result['status']){
                echo json_encode(array('status' => 200, 'message' =>$result['messages']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['messages']));
            }
        }

    }
    public function print_siparis($file_id)
    {
        $tip=$this->input->get('tip');
        $data['items']= $this->model->product_details($file_id);
        $data['details']= $this->model->details($file_id);
        ini_set('memory_limit', '999M');
        if($tip==0){
            $html = $this->load->view('fileprint/siparis_print_view', $data, true);
        }

        else {
            $html = $this->load->view('fileprint/siparis_print_view_', $data, true);
        }

        $header = $this->load->view('fileprint/siparis_print_header', $data, true);

        $footer = $this->load->view('fileprint/siparis_print_footer', $data, true);

        $this->load->library('pdf');

        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter($footer);
        $pdf->AddPage(
            'L', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            75, // margin top
            '72', // margin bottom
            5, 2, 0, 0, // margin header
            'auto'); // margin footer


        $pdf->WriteHTML($html);


        $file_name ="Teklif__";


        $pdf->Output($file_name . '.pdf', 'I');

    }
    public function get_product_to_recete(){
        $invoice_item_id=$this->input->post('invoice_item_id');
        $invoice_item_details = $this->db->query("SELECT * FROM geopos_invoice_items WHERE id=$invoice_item_id")->row();
        $product_id = $invoice_item_details->pid;
        $unit_id = $invoice_item_details->unit;

        $array_options=[];
        $recete_array_options=[];
        $invoice_item_options_details = $this->db->query("SELECT * FROM invoices_item_to_option Where invoices_item_id=$invoice_item_id");
        if($invoice_item_options_details->num_rows()){
            foreach ($invoice_item_options_details->result() as $values){
                $array_options[]=[
                    'option_id'=>$values->option_id,
                    'option_value_id'=>$values->option_value_id
                ];
            }
        }

        //
        $options_id='';
        $option_value_id='';
        $i=0;
        foreach ($array_options as $options_details){

            if ($i === array_key_last($array_options)) {// first loop
                $options_id.=$options_details['option_id'];
                $option_value_id.=$options_details['option_value_id'];
            }
            else {
                $options_id.=$options_details['option_id'].',';
                $option_value_id.=$options_details['option_value_id'].',';
            }
            $i++;
        }

        //

        $recete_array_id=[];

        $data_recete_options=[];
        $recete_details = $this->db->query("SELECT * FROM geopos_invoices WHERE new_prd_id=$product_id and invoice_type_id=11 and term=$unit_id");
        if($recete_details->num_rows()){
            foreach ($recete_details->result() as $items){
                $recete_options_details = $this->db->query("SELECT * FROM uretim_new_product Where invoice_id=$items->id");
                if($recete_options_details->num_rows())
                {
                    $j=0;
                    $recete_array_options=[];
                    foreach ($recete_options_details->result() as $values_items){


                        $recete_array_options[]=[
                            'option_id'=>$values_items->option_id,
                            'option_value_id'=>$values_items->option_value_id,
                            'recete_id'=>$items->id,
                        ];

                            $recete_options_id='';
                            $recete_option_value_id='';
                            $i=0;
                            foreach ($recete_array_options as $options_details){
                                if ($i === array_key_last($recete_array_options)) {// first loop
                                    $recete_options_id.=$options_details['option_id'];
                                    $recete_option_value_id.=$options_details['option_value_id'];
                                }
                                else {
                                    $recete_options_id.=$options_details['option_id'].',';
                                    $recete_option_value_id.=$options_details['option_value_id'].',';
                                }
                                $i++;
                            }



                                $data_recete_options[]=[
                                    'option_id'=>$recete_options_id,
                                    'option_value_id'=>$recete_option_value_id,
                                    'recete_id'=>$items->id,
                                ];



                            $j++;

                    }
                }
                else {
                    $data_recete_options[]=[
                        'option_id'=>'',
                        'option_value_id'=>'',
                        'recete_id'=>$items->id,
                    ];
                }
            }


            $data_options=[
                'option_id'=>$options_id,
                'option_value_id'=>$option_value_id,
            ];

            foreach ($data_recete_options as $item_items_values){

                if($item_items_values['option_id']==$data_options['option_id'] && $item_items_values['option_value_id']==$data_options['option_value_id']){
                    $recete_array_id[]=$item_items_values['recete_id'];
                }
            }

            $recete_id_str=implode(",",$recete_array_id);

            $recete_list = $this->db->query("SELECT * FROM geopos_invoices WHERE id IN($recete_id_str)");


            echo json_encode(array(
                'status' => 200,
                'recete_details' =>$recete_list->result()
            ));
        }
        else {
            echo json_encode(array(
                'status' => 410,
                'message' =>'Bu Ürün Bilgilerine Bağlı Reçete Bulunamadı'
            ));
        }

    }
    public function uretim_kontrol(){
        $recete_id=$this->input->post('recete_id');
        $invoice_item_id=$this->input->post('invoice_item_id');
        $warehouse_id=$this->input->post('warehouse_id');

        $invoice_item_details = $this->db->query("SELECT * FROM geopos_invoice_items WHERE id=$invoice_item_id")->row();
        $miktar = $invoice_item_details->qty;



        //Üretim Kontrol

        $durum=true;
        $text='';
        $uretim_fis_list=[];
        $uretim_fis_details = $this->db->query("SELECT geopos_uretim_item.*,geopos_uretim.status as uretim_status  FROM geopos_uretim  INNER JOIN geopos_uretim_item ON geopos_uretim.id=geopos_uretim_item.uretim_id Where geopos_uretim.recete_id = $recete_id and geopos_uretim.status IN (1,2)");
        if($uretim_fis_details->num_rows()){
            $uretim_fis_list = $uretim_fis_details->result();
        }
        $list=$this->uretim->recete_getir($recete_id);

        foreach ($list as $invoices) {

            $style='';
            $gerekli_stok=0;
            $style1='';
            $disabled='';

            $option_details=[];

            $item_id = $invoices['id'];
            $details = $this->db->query("SELECT * FROM invoices_item_to_option Where invoices_item_id=$item_id");
            if($details->num_rows()){
                foreach ($details->result() as $options_items){
                    if($options_items->option_id){
                        $option_details[]=[
                            'option_id'=>$options_items->option_id,
                            'option_value_id'=>$options_items->option_value_id,
                        ];
                    }

                }
            }

            $bekleyen_stok = 0;
            foreach ($uretim_fis_list as $items){
                if($items->pid == $invoices['pid']){
                    $bekleyen_stok+=$items->toplam_tuketilen;
                }
            }
            $stock_details = stock_qty_warehouse($invoices['pid'],$warehouse_id,$option_details);
            $product_type = $this->db->query("SELECT * FROM geopos_products Where pid =".$invoices['pid'])->row()->product_type;
            if($product_type==2){
                $grk_stk=999;
                $depodaki_stok='Stoksuz Ürün';
            }
            else {
                $depodaki_stok=$stock_details['qty'];
            }
            $toplam_tuketilen=(floatval($invoices['qty'])+floatval($invoices['fire_quantity'])) *floatval($miktar);
            $gerekli_stok=floatval($depodaki_stok)-floatval($toplam_tuketilen)-floatval($bekleyen_stok);

            $grk_stk_aciklama='';
            $grk_stk=$gerekli_stok;



            if($product_type==2){
                $grk_stk=999;
            }
            if($grk_stk<0)
            {
                $product_name = product_name($invoices['pid']);
                $text.=$product_name.' Gerekli Miktarda Stokta Mevcut Değil<br>';
                $durum=false;
                continue;
            }
            else
            {
                $grk_stk_aciklama='Gerekli Miktarda Mevcut';
                $disabled='disabled';
            }
         }
        if($durum){
            echo json_encode(array(
                'status' => 200,
                'messages' =>'Üretim Fişi Oluşturulacak'
            ));
        }
        else {
            echo json_encode(array(
                'status' => 410,
                'messages' =>$text
            ));
        }
        //Üretim Kontrol


    }
    public function uretim_fis_create(){
        $invoice_item_id=$this->input->post('invoice_item_id');
        $siparis_id=$this->input->post('siparis_id');
        $recete_id=$this->input->post('recete_id');
        $warehouse_id=$this->input->post('warehouse_id');
        $details = $this->model->details($siparis_id);


        $invoice_item_details = $this->db->query("SELECT * FROM geopos_invoice_items WHERE id=$invoice_item_id")->row();
        $new_prd_id = $invoice_item_details->pid;
        $unit_id = $invoice_item_details->unit;
        //Uretim Fişi Create

        $customer_id=0;
        $prodindex=0;
        $talep_no = numaric(32);

        $new_prd_name=product_name($new_prd_id);

        $miktar=$invoice_item_details->qty;
        $uretim_aciklamasi=$this->input->post('desc');

        $productlist=array();
        $data['products'] =  $this->uretim->invoice_products( $recete_id);
        $recete_details =  $this->uretim->details($recete_id);
        $data = array(

            'product_name' => $new_prd_name,
            'code' => $talep_no,
            'personel_id' => 0,
            'product_id' => $new_prd_id,
            'quantity' =>$miktar,
            'unit_id' =>$recete_details->term,
            'uretim_desc' => $details->invoice_no.' Nolu Siparişin Üretim Fişi. '.$uretim_aciklamasi,
            'user_id' => $this->aauth->get_user()->id,
            'recete_id' => $recete_id,
            'customer_id' => 0,
            'depo_id' => $warehouse_id,
            'invoice_item_id' => $invoice_item_id,
            'loc_id' => $this->session->userdata('set_firma_id')
        );


        if ($this->db->insert('geopos_uretim', $data)) {
            $uretim_id = $this->db->insert_id();
            $data_update = array(
                'status' =>20,
            );
            $this->db->set($data_update);
            $this->db->where('id', $invoice_item_id);
            if ($this->db->update('geopos_invoice_items', $data_update)) {
                $data_uretim_siparis = array(
                    'uretim_fis_id' => $uretim_id,
                    'siparis_id' => $siparis_id,
                    'recete_id' => $recete_id,
                    'invoice_item_id' => $invoice_item_id,
                    'aauth_id' => $this->aauth->get_user()->id
                );
                $this->db->insert('siparis_to_uretim_fis', $data_uretim_siparis);
            }

            $this->db->set('deger', "deger+1",FALSE);
            $this->db->where('tip', 32);
            $this->db->update('numaric');


            $status = 1;

            $data['products'] =  $this->uretim->invoice_products( $recete_id);

            foreach ( $data['products'] as $prd)
            {
                $toplam=floatval($prd['qty'])+floatval($prd['fire_quantity']);

                $toplam_tuketilen= $toplam * floatval($miktar);


                $data2 = array(
                    'pid' => $prd['pid'],
                    'name' => $prd['product'],
                    'uretim_id' => $uretim_id,
                    'quantity' => $miktar,
                    'quantity_2' =>$prd['qty'],
                    'type' =>'uretim',
                    'unit_id' =>$prd['unit'],
                    'fire' => $prd['fire'],
                    'fire_quantity' =>$prd['fire_quantity'],
                    'toplam_tuketilen' => $toplam_tuketilen);
                $prodindex++;

                $productlist[$prodindex] = $data2;
            }

            $this->db->insert_batch('geopos_uretim_item', $productlist);

            $messages = $talep_no.' Numarasında '.$recete_details->invoice_no.' Kodlu Reçete İçin Üretim Fişi Oluşturuldu. Üretim Miktarı : '.$miktar.' '.units_($recete_details->term)['name'];
            $this->uretim->talep_history($uretim_id,0,$this->aauth->get_user()->id,$messages);

            echo json_encode(array(
                'status' => 200,
                'message' => 'Başarılı Bir Şekilde Oluşturuldu',
                'link'=>'/uretim/view_uretim_fisi?id='.$uretim_id
            ));

        }
        else {
            echo json_encode(array(
                'status' => 410,
                'message' => 'Hata Aldınız Yöneticiye Başvurun',
            ));
        }
        //Uretim Fişi Create
    }
    public function get_info_siparis(){
        $id = $this->input->post('siparis_id');
        $details = $this->model->details($id);
        echo json_encode(array('status' => 200, 'items' =>$details));
    }
    public function update_item(){
        if (!$this->aauth->premission(10)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->model->update_item();
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
    public function delete_item(){
        if (!$this->aauth->premission(10)->delete) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $this->db->trans_start();
            $result = $this->model->delete_item();
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

}