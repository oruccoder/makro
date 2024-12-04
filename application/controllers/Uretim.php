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



class Uretim extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->library("Aauth");

        $this->load->model('uretim_model', 'uretim');
        $this->load->model('customers_model', 'customers');
        $this->load->model('categories_model');
        $this->load->model('plugins_model', 'plugins');
        $this->load->model('tools_model', 'tools');

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }

        if (!$this->aauth->premission(1)) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        if ($this->aauth->get_user()->roleid == 2) {

            $this->limited = $this->aauth->get_user()->id;

        } else {

            $this->limited = '';

        }



    }

    public function index()

    {

        if (!$this->aauth->premission(6)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }

        $head['title'] = "Üretim";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('uretim/index');

        $this->load->view('fixed/footer');



    }
    public function ajax_list()

    {
        $list = $this->uretim->get_datatables($this->limited);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {

            $no++;

            $row = array();

            $option_html='';
            $details = uretim_new_products($invoices->id);

            if($details){
                foreach ($details as $items){
                    $option_html.=varyasyon_string_name($items->option_id,$items->option_value_id);
                }
            }


            //<a href="' . base_url("uretim/yeni_uretim?id=$invoices->id") . '"
            //            class="btn btn-info btn-xs"><i class="fa fa-building"></i>&nbsp;' . $this->lang->line('uretim_gonder') . '</a>&nbsp; &nbsp;

            $product_name='';
            if(product_details($invoices->new_prd_id)){
                $product_name=product_details($invoices->new_prd_id)->product_name.'<br>'.$option_html;
            }
            $row[] = $invoices->invoice_no;
            $row[] = $invoices->invoice_name;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = $product_name;
            $row[] = '<a href="' . base_url("uretim/view/$invoices->id") . '" class="btn btn-success btn-xs">
            <i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> &nbsp; &nbsp;<a href="' . base_url("uretim/uretim_list/$invoices->id") . '" 
            class="btn btn-warning btn-xs"><i class="fa fa-list"></i>&nbsp; Üretim Fişleri</a>';
            $data[] = $row;
        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->uretim->count_all($this->limited),

            "recordsFiltered" => $this->uretim->count_filtered($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }
    public function create_save(){
        if (!$this->aauth->premission(6)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->uretim->create_save();
            if($result['status']){

                echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Reçete oluşturuldu",'index'=>'/uretim/view/'.$result['id']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
            }
        }


    }
    public function update_save(){
        if (!$this->aauth->premission(6)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->uretim->update_save();
            if($result['status']){

                echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Reçete oluşturuldu",'index'=>'/uretim/view/'.$result['id']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
            }
        }
    }
    public function view($id)
    {
        if (!$this->aauth->premission(6)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }

        $data['cat'] = $this->categories_model->category_list();
        $data['ana_kategoriler'] = $this->categories_model->category_list_();
        $data['alt_kat'] = $this->categories_model->alt_kat();
        $user_=[];
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Üretim Reçetesi';

        $data['details']= $this->uretim->details($id);
        $data['items']= $this->uretim->product_details($id);
        $data['data_products']= $this->uretim->product_details($id);
        $data['file_details']= $this->uretim->file_details($id);
        $this->load->view('fixed/header', $head);
        if($data['details']->invoice_type_id==11){
            $this->load->view('uretim/view_recete',$data);
        }
        else {
            $this->load->view('uretim/view_recete_is_kalemi',$data);
        }

        $this->load->view('fixed/footer');
    }
    public function get_product_to_value(){
        $product_id=$this->input->post('product_id');
        $html = product_to_option_html($product_id);
        if($html['status']){
            echo json_encode(array('code' => 200, 'html' =>$html['html'] ));
        }
        else {
            echo json_encode(array('code' => 410, 'html' =>'<h3>Herhangi Bir Varyasyon Bulunamadı</h3>' ));
        }


    }
    public function create_item(){


        if (!$this->aauth->premission(6)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->uretim->create_item();
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
    public function warehouse_update()
    {
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $details = $this->uretim->details($id);
        $warehouse_id = $this->input->post('warehouse_id');
        $data=[];

        $data = array(
            'depo' => $warehouse_id,
        );

        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_invoices', $data)) {
            $this->aauth->applog("Reçetede Depo Tanımlaması Yapıldı Talep :  ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Güncellendi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun." ));
        }
    }
    public function delete_file(){
        $this->db->trans_start();
        $id = $this->input->post('file_id');
        $details  = $this->db->query("SELECT * FROM invoices_files Where id = $id")->row();
        if($this->db->delete('invoices_files', array('id' => $id))){
            $this->uretim->talep_history(0,$details->invoices_id,$this->aauth->get_user()->id,'File Silindi');
            $this->aauth->applog("Reçeteden Talebinden File Silindi  : File ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Silindi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }

    }
    public function upload_file(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        $image_text = $this->input->post('image_text');
        $data_images = array(
            'user_id' => $this->aauth->get_user()->id,
            'image_text' => $image_text,
            'invoices_id' => $id,
        );
        if($this->db->insert('invoices_files', $data_images)){
            $this->uretim->talep_history(0,$id,$this->aauth->get_user()->id,'File Yüklendi');
            $this->aauth->applog("Üretim Reçetesine File Yüklendi  : Talep ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Yüklendi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }

    }
    public function delete_item_form(){
        $this->db->trans_start();
        $id = $this->input->post('item_id');
        $details = $this->db->query("SELECT * FROM geopos_invoice_items Where id=$id")->row();


        if($this->db->delete('geopos_invoice_items', array('id' => $id))){


            $this->db->delete('invoices_item_to_option', array('invoices_item_id' => $id));
            $this->aauth->applog("Reçeteden Ürün Silindi  :  ID : ".$id, $this->aauth->get_user()->username);
            $this->uretim->talep_history(0,$details->tid,$this->aauth->get_user()->id,$details->product.' Ürünü Silindi');
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Silindi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }

    }
    public function recete_getir()
    {
        $durum  = false;
        $html='';
        $product_id = $this->input->post('product_id', true);
        $warehouse_id = $this->input->post('warehouse_id', true);
        $recete_id = $this->input->post('recete_id', true);
        $details = $this->uretim->details($recete_id);
        $miktar = $this->input->post('miktar', true);
        $list=$this->uretim->recete_getir($recete_id);
        $product_name=product_name($product_id);
        $product_unit=units_($details->term)['name'];
        $uretim_fis_list=[];
        $uretim_fis_details = $this->db->query("SELECT geopos_uretim_item.*,geopos_uretim.status as uretim_status  FROM geopos_uretim  INNER JOIN geopos_uretim_item ON geopos_uretim.id=geopos_uretim_item.uretim_id Where geopos_uretim.recete_id = $recete_id and geopos_uretim.status IN (1,2)");
        if($uretim_fis_details->num_rows()){
            $uretim_fis_list = $uretim_fis_details->result();
        }



        $html='<div class="row recete_table">
                        <div class="col-12">
                            <span class="font-18 font-weight-light"><strong>'.$miktar. ' '.$product_unit.' '.$product_name.' </strong>İçin Tüketilen Malzemeler</span>
                            <div class="table-responsive mt-2">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Malzeme Adı</th>
                                        <th>Birim Başı Tüketilen</th>
                                        <th></th>
                                        <th>Mamul Fire Miktarı</th>
                                        <th></th>
                                        <th>Üretilen Mamul Miktarı</th>
                                        <th></th>
                                        <th>Toplam Tüketilen</th>
                                        <th>Bekleyen / Uretim Stoğu</th>
                                        <th>Depodaki Stok</th>
                                        <th>Gerekli Stok</th>
                                    </tr>
                                    </thead>
                                    <tbody>';
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
                $grk_stk_aciklama=abs($grk_stk).' '.units_($invoices['unit'])['name'];
                $style1='style="background-color: #ff0000c2;color: white;"';
                $disabled='';
                $durum=true;
            }
            else
            {
                $grk_stk_aciklama='Gerekli Miktarda Mevcut';
                $disabled='disabled';
            }
            if($depodaki_stok<$toplam_tuketilen)
            {
                $style='style="background-color: #ff0f0f9c;color: white;"';
            }
            else
            {

                $style='style="background-color: #048e089c;color: white;"';
            }


            if($product_type==2){
                $depodaki_stok_html='<td '.$style.'>'.$depodaki_stok.'</td>';
            }
            else {
                $depodaki_stok_html='<td '.$style.'>'.$depodaki_stok.' '.units_($invoices['unit'])['name'].'</td>';
            }
            $html.='<tr>';
            $html.='<td><a target="_blank" rel="noopener" class="mr-2" title="Ürüne git" data-tid="open-parasut-product-icon" href="">'.$invoices['product'].'</a></td>';
            $html.='<td>'.floatval($invoices['qty']).' '.units_($invoices['unit'])['name'].'</td>';
            $html.='<td>+</td>';
            $html.='<td>'.floatval($invoices['fire_quantity']).' '.units_($invoices['unit'])['name'].'</td>';
            $html.='<td>X</td>';
            $html.='<td>'.$miktar.'</td>';
            $html.='<td>=</td>';
            $html.='<td>'.$toplam_tuketilen.' '.units_($invoices['unit'])['name'].'</td>';
            $html.='<td>'.$bekleyen_stok.' '.units_($invoices['unit'])['name'].'</td>';
            $html.=$depodaki_stok_html;
            $html.='<td '.$style1.'>'.$grk_stk_aciklama.'</td>';
           // $html.='<td><input type="button" '.$disabled.' onclick="siparis_emri('.$invoices['pid'].','.abs($gerekli_stok).')"  class="btn btn-success" value="Sipariş Emri Oluştur"></td></tr>';
        }

        $html.='</tbody>

                                </table>
                            </div>
                        </div>
                    </div>';


        //output to json format

        //echo $html;
        echo json_encode(array(
            'status' => $durum,
            'message' => $html
        ));
    }

    public function alis_fiyati_guncelle()
    {

        $pid = $this->input->post('product_id');
        $recete_id = $this->input->post('recete_id');



        $items = $this->uretim->product_details($recete_id);
        foreach ($items as $invoices){
            $option_details=[];
            $item_id = $invoices->id;
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
            $p_price = piyasa_fiyati($invoices->pid,$option_details);
            $data[]= array(
                'alis_fiyati'=>$p_price,
                'product_id'=>$invoices->pid
            );
        }


        echo json_encode(array(
                'status' => 'Başarılı',
                'message' => "Başarılı Bir Şekilde Veriler Güncellendi",
                'data' => $data
            )
        );


    }
    public function muhasebe()
    {

        if (!$this->aauth->premission(6)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->uretim->muhasebe();
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

    public function uretim_list($recete_id)
    {

        $details = $this->uretim->details($recete_id);
        $head['title'] = $details->invoice_no." Reçetesine Ait Üretim Fişleri";
        $data['title']=$details->invoice_no." Reçetesine Ait Üretim Fişleri";
        $data['recete_id']=$recete_id;

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('uretim/list_uretim',$data);

        $this->load->view('fixed/footer');
    }
    public function ajax_list_uretim()
    {
        $list = $this->uretim->get_datatables_uretim($this->limited);
        $data = array();
        $no=1;
        foreach ($list as $invoices) {
            $status_name = uretim_status($invoices->status)->name;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->code;
            $row[] = $invoices->uretim_desc;
            $row[] = $invoices->product_name;
            $row[] = dateformat($invoices->uretim_date);
            $row[] =amountFormat_s($invoices->quantity).' '.units_($invoices->unit_id)['name'];
            $row[] =personel_details($invoices->user_id);
            $row[] ="<button class='btn btn-warning status_chage' type='button' data-uretim_id='$invoices->id'><i class='fa fa-retweet'></i> $status_name</button>";
            $row[] = '<a href="' . base_url("uretim/view_uretim_fisi?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a>';
            $data[] = $row;

            $no++;
        }
        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->uretim->count_all_uretim($this->limited),

            "recordsFiltered" => $this->uretim->count_filtered_uretim($this->limited),

            "data" => $data,

        );
        echo json_encode($output);
    }
    public function view_uretim_fisi()
    {
        $this->load->model('accounts_model');


        $tid = $this->input->get('id');

        $data['invoice'] = $this->uretim->uretim_details($tid, $this->limited);

        $data['customer_details']=customer_details( $data['invoice']['customer_id']);

        $data['personel']=personel_details($data['invoice']['personel_id']);




        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = "Üretim Fişi " . $data['invoice']['id'];

        $this->load->view('fixed/header', $head);



        $data['products'] = $this->uretim->uretim_products($tid);





        $data['employee'] = $this->uretim->employee($data['invoice']['user_id']);





        if ($data['invoice']) { $data['invoice']['id'] = $tid; $this->load->view('uretim/view_uretim_fisi', $data);}



        $this->load->view('fixed/footer');

    }

    public function delete_gider(){
        $this->db->trans_start();
        $id = $this->input->post('id');
        $details = $this->db->query("SELECT * FROM geopos_uretim_item Where id=$id")->row();
        $gider_tutar = $details->toplam_price;
        $uretim_id = $details->uretim_id;
        $uretim_details = $this->db->query("SELECT * FROM geopos_uretim Where id=$uretim_id")->row();
        $total_maliyet = $uretim_details->maliyet;
        $new_maliyet = floatval($total_maliyet)-floatval($gider_tutar);


        if($this->db->delete('geopos_uretim_item', array('id' => $id))){
            $this->db->query("UPDATE `geopos_uretim` SET `maliyet`='$new_maliyet' WHERE id=$uretim_id");
            $this->aauth->applog("Üretim Fişinden Gider Silindi  :  ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 200,'message'=>'Başarıyla Silindi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }

    }
    public function save_maliyet()
    {
        $json=array();
        $uretim_id = $this->input->post('uretim_id');
        $recete_id=recete_id_maliyet($uretim_id);
        $recete_maliyeti=$this->input->post('recete_maliyeti');
        $uretim_maliyeti=0;
        $this->db->query("UPDATE `geopos_invoices` SET `total`='$recete_maliyeti' WHERE id=$recete_id");


        $pid=$this->input->post('product_id');
        foreach ($pid as $key=>$value)
        {
            $product_id = $this->input->post('product_id');
            $alis_fiyati = $this->input->post('alis_fiyati');

            $prd_id=$product_id[$key];
            $alis_fiyatii=$alis_fiyati[$key];

            $this->db->query("UPDATE `geopos_invoice_items` SET `price`='$alis_fiyatii' WHERE pid='$prd_id' and tid=$recete_id");
            $this->db->query("UPDATE `geopos_uretim_item` SET `alis_fiyati`='$alis_fiyatii' WHERE pid='$prd_id' and uretim_id=$uretim_id");
            //if ($this->db->insert('geopos_uretim', $data))
        }

        $gider_tipi = $this->input->post('gider_tipi');
        $tutar = $this->input->post('tutar');




        if (isset($gider_tipi)) {

            foreach ($gider_tipi as $key=>$value) {

                if($gider_tipi[$key])
                {

                    $gider_tipii = $gider_tipi[$key];
                    $tutarr = $tutar[$key];
                    $uretim_maliyeti += floatval($tutarr);



                    $this->db->query("INSERT INTO `geopos_uretim_item`(`uretim_id`, `name`, `alis_fiyati`, `toplam_price`,`type` ) VALUES 
                    (
                    '$uretim_id','$gider_tipii','$tutarr','$tutarr','maliyet'
                    )");
                }



            }
        }



        $gider_maliyeti = $this->db->query("SELECT SUM(toplam_price) as total From geopos_uretim_item Where uretim_id=$uretim_id and type='maliyet'")->row()->total;
        $uretim_maliyeti=$gider_maliyeti+$recete_maliyeti;
        $this->db->query("UPDATE `geopos_uretim` SET `maliyet`='$uretim_maliyeti' WHERE id=$uretim_id");

        echo json_encode(array(
                'status' => 'Başarılı',
                'uretim_id' => $uretim_id,
                'message' => "Başarılı Bir Şekilde Veriler Güncellendi"
            )
        );

    }
    public function save_uretim()
    {


        $customer_id=0;
        $prodindex=0;
        $talep_no = numaric(32);
        $recete_id=$this->input->post('recete_id_get');
        $new_prd_id=$this->input->post('new_prd_id');
        $new_prd_name=$this->input->post('new_prd_name');
        $warehouse_id=$this->input->post('warehouse_id');
        $miktar=$this->input->post('miktar');
        $uretim_aciklamasi=$this->input->post('uretim_aciklamasi');

        $productlist=array();
        $data['products'] =  $this->uretim->invoice_products( $recete_id);
        $recete_details =  $this->uretim->details($recete_id);
        $date_uretim=$this->input->post('uretim_tarihi');

        $data = array(

            'product_name' => $new_prd_name,
            'code' => $talep_no,
            'personel_id' => 0,
            'product_id' => $new_prd_id,
            'quantity' =>$miktar,
            'unit_id' =>$recete_details->term,
            'uretim_desc' => $uretim_aciklamasi,
            'user_id' => $this->aauth->get_user()->id,
            'recete_id' => $recete_id,
            'customer_id' => 0,
            'depo_id' => $warehouse_id,
            'loc_id' => $this->session->userdata('set_firma_id')
        );


        if ($this->db->insert('geopos_uretim', $data)) {

            $uretim_id = $this->db->insert_id();

            $this->db->set('deger', "deger+1",FALSE);
            $this->db->where('tip', 32);
            $this->db->update('numaric');


            $status = 1;

            $data['products'] =  $this->uretim->invoice_products( $recete_id);

            foreach ( $data['products'] as $prd)
            {
                $toplam=floatval($prd['qty'])+floatval($prd['fire_quantity']);

                $toplam_tuketilen= $toplam * floatval($this->input->post('miktar'));


                $data2 = array(
                    'pid' => $prd['pid'],
                    'name' => $prd['product'],
                    'uretim_id' => $uretim_id,
                    'quantity' => $this->input->post('miktar'),
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


    }

    public function get_info(){

        $recete_id = $this->input->post('recete_id');
        $details = $this->uretim->details($recete_id);
        if ($details) {
            echo json_encode(array(
                'status' => '200',
                'items' => $details,
            ));
        }
    }


    public function get_info_fis(){

        $uretim_id = $this->input->post('uretim_id');
        $details = $this->uretim->uretim_details_res($uretim_id);
        if ($details) {
            echo json_encode(array(
                'status' => '200',
                'items' => $details,
            ));
        }
    }

    public function stok_kontrol(){
        $uretim_id = $this->input->post('uretim_id');
        $uretim_details= $this->uretim->uretim_details_res($uretim_id);
        $miktar = $this->input->post('qty');
        $recete_id = $uretim_details->recete_id;
        $list=$this->uretim->recete_getir($recete_id);

        $uretim_fis_list=[];
        $uretim_fis_details = $this->db->query("SELECT geopos_uretim_item.*,geopos_uretim.status as uretim_status  FROM geopos_uretim  INNER JOIN geopos_uretim_item ON geopos_uretim.id=geopos_uretim_item.uretim_id Where geopos_uretim.recete_id = $recete_id and geopos_uretim.status IN (1,2) and geopos_uretim.id!=$uretim_id");
        if($uretim_fis_details->num_rows()){
            $uretim_fis_list = $uretim_fis_details->result();
        }

        $warehouse_id=$uretim_details->depo_id;
        $text='';
        $durum=1;
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
            $depodaki_stok=$stock_details['qty'];


            $toplam_tuketilen=(floatval($invoices['qty'])+floatval($invoices['fire_quantity'])) *floatval($miktar);
            $gerekli_stok=floatval($depodaki_stok)-floatval($toplam_tuketilen)-floatval($bekleyen_stok);

            $grk_stk_aciklama='';
            $grk_stk=$gerekli_stok;

            if($grk_stk<0)
            {
                $grk_stk_aciklama=abs($grk_stk).' '.units_($invoices['unit'])['name'];
                $style1='style="background-color: #ff0000c2;color: white;"';
                $disabled='';
                $durum=0;
                $product_name = product_name($invoices['pid']);
                $text.=$product_name.' Gerekli Miktarda Stokta Mevcut Değil<br>';
            }
         }
        echo json_encode(array('status' => $durum, 'message' =>$text));

    }

    public function update_save_uretim(){
        if (!$this->aauth->premission(6)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $customer_id=0;
            $prodindex=0;
            $talep_no = numaric(32);
            $uretim_id=$this->input->post('uretim_id');
            $uretim_fis_details = $this->uretim->uretim_details_res($uretim_id);
            if($uretim_fis_details->status==1 || $uretim_fis_details->status==2){

                $recete_id=$uretim_fis_details->recete_id;
                $miktar=$this->input->post('miktar');
                $uretim_aciklamasi=$this->input->post('desc');

                $productlist=array();
                $data['products'] =  $this->uretim->invoice_products( $recete_id);
                $recete_details =  $this->uretim->details($recete_id);
                $data = array(
                    'quantity' =>$miktar,
                    'uretim_desc' => $uretim_aciklamasi
                );
                $this->db->set($data);
                $this->db->where('id', $uretim_id);
                if ($this->db->update('geopos_uretim', $data)) {
                    $this->db->delete('geopos_uretim_item', array('uretim_id' => $uretim_id));
                    $data['products'] =  $this->uretim->invoice_products( $recete_id);

                    foreach ( $data['products'] as $prd)
                    {
                        $toplam=floatval($prd['qty'])+floatval($prd['fire_quantity']);

                        $toplam_tuketilen= $toplam * floatval($miktar);


                        $data2 = array(
                            'pid' => $prd['pid'],
                            'name' => $prd['product'],
                            'uretim_id' => $uretim_id,
                            'quantity' => $this->input->post('miktar'),
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
                    $messages = $talep_no.' Numarasında '.$recete_details->invoice_no.' Kodlu Reçete İçin Üretim Fişi Düzenlendi. Üretim Miktarı : '.$miktar.' '.units_($recete_details->term)['name'];
                    $this->uretim->talep_history($uretim_id,0,$this->aauth->get_user()->id,$messages);
                    $this->db->trans_complete();
                    echo json_encode(array(
                        'status' => 200,
                        'message' => 'Başarılı Bir Şekilde Oluşturuldu',
                    ));

                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array(
                        'status' => 410,
                        'message' => 'Hata Aldınız Yöneticiye Başvurun',
                    ));
                }
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array(
                    'status' => 410,
                    'message' => uretim_status($uretim_fis_details->status)->name.' Durumunda Olan Bir Fiş Güncellenemez',
                ));
            }
        }



    }

    public function print_recete($file_id)
    {
        $data['items']= $this->uretim->product_details($file_id);
        $data['details']= $this->uretim->details($file_id);
        ini_set('memory_limit', '999M');
        $html = $this->load->view('fileprint/recete_list_print_view', $data, true);
        $header = $this->load->view('fileprint/recete_list_print_header', $data, true);
        $footer = $this->load->view('fileprint/recete_siparis_print_footer', $data, true);

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

    public function print_recete_is($file_id)
    {
        $data['items']= $this->uretim->product_details($file_id);
        $data['details']= $this->uretim->details($file_id);
        ini_set('memory_limit', '999M');
        $html = $this->load->view('fileprint/print_recete_is', $data, true);
        $header = $this->load->view('fileprint/recete_list_print_header', $data, true);
        $footer = $this->load->view('fileprint/recete_siparis_print_footer', $data, true);

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

    public function print_uretim($file_id)
    {
        $data['items']= $this->uretim->uretim_products_res($file_id);
        $data['details']= $this->uretim->uretim_details_res($file_id);
        ini_set('memory_limit', '999M');
        $html = $this->load->view('fileprint/uretim_list_print_view', $data, true);
        $header = $this->load->view('fileprint/uretim_list_print_header', $data, true);
        $footer = $this->load->view('fileprint/recete_siparis_print_footer', $data, true);

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


    public function tehvilprint($file_id)
    {
        $data['details']= $this->uretim->tehvil_details($file_id);

        $data['siparis_details']=$this->uretim->details($data['details']->purchase_id);
        $data['uretim_details']=$this->uretim->uretim_details_res($data['details']->task_id);
        $uretim_fis_id=$data['details']->task_id;
        //and id!=$file_id
        $t=$this->db->query("SELECT SUM(items) as total FROM geopos_invoices Where task_id=$uretim_fis_id  and invoice_type_id=69")->row()->total;

        $data['teslim_edilen_miktar']=isset($t)?$t:0;
        //$data['kalan']=$data['uretim_details']->quantity - ($data['teslim_edilen_miktar']+$data['details']->items);
        $data['kalan']=$data['uretim_details']->quantity - $t;
        ini_set('memory_limit', '999M');
        $html = $this->load->view('fileprint/siparis_tehvil_print_view', $data, true);
        $header = $this->load->view('fileprint/siparis_tehvil_print_header', $data, true);
        $footer = $this->load->view('fileprint/siparis_tehvil_print_footer', $data, true);

        $this->load->library('pdf');

        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter($footer);
        $pdf->AddPage(
            'P', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            60, // margin top
            '72', // margin bottom
            5, 2, 0, 0, // margin header
            'auto'); // margin footer


        $pdf->WriteHTML($html);


        $file_name ="Teklif__";


        $pdf->Output($file_name . '.pdf', 'I');

    }

    public function status_change(){
        if (!$this->aauth->premission(6)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->uretim->status_change();
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

    public function ajax_list_history(){
        $talep_id=$this->input->post('talep_id');

        $list = $this->uretim->ajax_list_history($talep_id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $row[] = $prd->pers_name;
            $row[] = $prd->desc;
            $row[] = $prd->created_at;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->uretim->count_all_talep_history($talep_id),
            "recordsFiltered" => $this->uretim->count_filtered_talep_history($talep_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }






    public function add_recete()
    {
        if (!$this->aauth->premission(5)) {



            exit('<h3>Üzgünüm! Buraya giriş yetkiniz bulunmamaktadır.</h3>');



        }





        $data['exchange'] = $this->plugins->universal_api(5);

        $data['customergrouplist'] = $this->customers->group_list();

        //$data['warehouse'] = $this->uretim->warehouses();

        //$data['terms'] = $this->uretim->billingterms();

        $data['currency'] = $this->uretim->currencies();

        $this->load->library("Common");

        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));

        $head['title'] = "Yeni Reçete";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('uretim/add_recete');

        $this->load->view('fixed/footer');
    }

    public function action()


    {

        $i = 0;

        $customer_id = $this->input->post('customer_id');

        $invocieno = $this->input->post('receteno');

        $invoicedate = $this->input->post('recetedate');
        $product_id = $this->input->post('new_prd_id');

        $recete_adi = $this->input->post('recete_adi');

        $bill_date = datefordatabase($invoicedate);

        $refer = $this->input->post('refer',true);
        $notes = $this->input->post('notes',true);
        $invoice_type_id = 11;
        $invoice_type_description= 'Üretim Reçetesi';

        $data = array(
            'tid' => $invocieno,
            'new_prd_id' => $product_id,
            'invoicedate' => $bill_date,
            'invoice_type_id' => $invoice_type_id,
            'invoice_name' => $recete_adi,
            'invoice_type_desc' => $invoice_type_description,
            'notes' => $notes,
            'csd' => $customer_id,
            'eid' => $this->aauth->get_user()->id,
            'refer' => $refer,
            'loc' => $this->aauth->get_user()->loc);

        $invocieno2 = $invocieno;

        if ($this->db->insert('geopos_invoices', $data))
        {
            $invocieno = $this->db->insert_id();

            //products



            $pid = $this->input->post('pid');

            $productlist = array();

            $prodindex = 0;

            $itc = 0;



            foreach ($pid as $key => $value)
            {
                $product_id = $this->input->post('pid');

                $product_name1 = $this->input->post('product_name',true);

                $product_qty = $this->input->post('product_qty');

                $product_unit = $this->input->post('product_unit');

                $product_hsn = $this->input->post('hsn',true);

                $fire = $this->input->post('product_fire',true);

                $fire_quantity = $this->input->post('product_fire_quantity',true);

                $data2 = array(

                    'tid' => $invocieno,

                    'pid' => $product_id[$key],

                    'product' => $product_name1[$key],

                    'code' => $product_hsn[$key],

                    'qty' => $product_qty[$key],

                    'unit' => $product_unit[$key],

                    'price' => product_alis_fiyati($product_id[$key]),

                    'fire' => $fire[$key],

                    'fire_quantity' => $fire_quantity[$key],

                    'invoice_type_id' => 11,

                    'invoice_type_desc' => 'Üretim Reçetesi'
                );

                $productlist[$prodindex] = $data2;

                $i++;

                $prodindex++;


            }



            if ($prodindex > 0) {

                $this->db->insert_batch('geopos_invoice_items', $productlist);
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Recete has  been updated') . " <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . " </a> "));




            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "Lütfen ürün listesinden ürün seçiniz. Ürünleri eklemediyseniz, Ürün Yöneticisine gidin."));


            }
        }

    }

    public function editaction()


    {

        $i = 0;

        $iid = $this->input->post('iid');

        $customer_id = $this->input->post('customer_id');

        $invocieno = $this->input->post('receteno');

        $invoicedate = $this->input->post('recetedate');
        $product_id = $this->input->post('new_prd_id');

        $recete_adi = $this->input->post('recete_adi');

        $bill_date = datefordatabase($invoicedate);

        $refer = $this->input->post('refer',true);
        $notes = $this->input->post('notes',true);
        $invoice_type_id = 11;
        $invoice_type_description= 'Üretim Reçetesi';

        $data = array(
            'tid' => $invocieno,
            'new_prd_id' => $product_id,
            'invoicedate' => $bill_date,
            'invoice_type_id' => $invoice_type_id,
            'invoice_name' => $recete_adi,
            'invoice_type_desc' => $invoice_type_description,
            'notes' => $notes,
            'csd' => $customer_id,
            'eid' => $this->aauth->get_user()->id,
            'refer' => $refer,
            'loc' => $this->aauth->get_user()->loc);


        $this->db->set($data);

        $this->db->where('id', $iid);


        if ($this->db->update('geopos_invoices', $data)) {
        {
            $invocieno = $this->db->insert_id();

            //products

            $pid = $this->input->post('pid');

            $productlist = array();

            $prodindex = 0;

            $itc = 0;

            $this->db->delete('geopos_invoice_items', array('tid' => $iid));



            foreach ($pid as $key => $value)
            {
                $product_id = $this->input->post('pid');

                $product_name1 = $this->input->post('product_name',true);

                $product_qty = $this->input->post('product_qty');

                $product_unit = $this->input->post('product_unit');

                $product_hsn = $this->input->post('hsn',true);

                $fire = $this->input->post('product_fire',true);

                $fire_quantity = $this->input->post('product_fire_quantity',true);

                $data2 = array(

                    'tid' => $iid,

                    'pid' => $product_id[$key],

                    'product' => $product_name1[$key],

                    'code' => $product_hsn[$key],

                    'qty' => $product_qty[$key],

                    'unit' => $product_unit[$key],

                    'price' => product_alis_fiyati($product_id[$key]),

                    'fire' => $fire[$key],

                    'fire_quantity' => $fire_quantity[$key],

                    'invoice_type_id' => 11,

                    'invoice_type_desc' => 'Üretim Reçetesi'
                );

                $productlist[$prodindex] = $data2;

                $i++;

                $prodindex++;


            }



            if ($prodindex > 0) {

                $this->db->insert_batch('geopos_invoice_items', $productlist);
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Recete has  been updated') . " <a href='view?id=$iid' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . " </a> "));




            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "Lütfen ürün listesinden ürün seçiniz. Ürünleri eklemediyseniz, Ürün Yöneticisine gidin."));


            }
        }

    }
    }








    public function yeni_uretim()
    {
        $this->load->model('employee_model', 'employee');

        $head['title'] = "Yeni Üretim";


        $data['emp'] = $this->employee->list_employee();

        $head['usernm'] = $this->aauth->get_user()->username;



        $data['recete_id']=$this->input->get('id');
        $data['uretim_fis_id']=$this->input->get('uretim_fis_id');


        $this->load->view('fixed/header', $head);

        $this->load->view('uretim/yeni_uretim',$data);

        $this->load->view('fixed/footer');
    }








    public function siparis_emri()
    {
        $product_name=product_name($this->input->post('product_id'));
        $product_unit=product_unit($this->input->post('product_id'));
        $miktar=$this->input->post('miktar');
        $name =  'Üretim İçin Gerekli Stok Alım İşlemi.';

        $status = 1;

        $priority = 'High';

        $stdate ='NOW()';

        $tdate ='NOW()';

        $employee = role_id_pers_id();

        $content = 'Üretim İçin '.$product_name.' Ürününden '.$miktar.' '.$product_unit.' gerekli.Sipariş Emri Size Atandı.';

        $assign = $this->aauth->get_user()->id;


        $this->tools->addtask($name, $status, $priority, $stdate, $tdate, $employee, $assign, $content);
    }



    public function printuretim()

    {



        $tid = $this->input->get('id');

        $data['id'] = $tid;
        $data['invoice'] = $this->uretim->uretim_details($tid, $this->limited);
        $data['products'] =  $this->uretim->invoice_products( $data['invoice']['recete_id']);
        $data['employee'] = $this->uretim->employee($data['invoice']['user_id']);
        $data['customer']=customer_details( $data['invoice']['customer_id']);

        $data['personel']=personel_details($data['invoice']['personel_id']);



        ini_set('memory_limit', '64M');

        $html = $this->load->view('uretim/view-uretim-print-' . LTR, $data, true);

        $header = $this->load->view('uretim/header-uretim-print-' . LTR, $data, true);

        //PDF Rendering

        $this->load->library('pdf');



        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['id'] . '</div>');


        $pdf->AddPage(
            '', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            90, // margin top
            '', // margin bottom
            0,50,0,0, // margin header
            ''); // margin footer

        $pdf->WriteHTML($html);



        $file_name = preg_replace( '/[^A-Za-z0-9]+/', '-', 'UretimFisi__'.$data['invoice']['name'].'_'. $data['invoice']['id']);

        if ($this->input->get('d')) {

            $pdf->Output($file_name. '.pdf', 'D');

        } else {

            $pdf->Output($file_name . '.pdf', 'I');

        }





    }


    public function print_uretim_maliyet()

    {



        $tid = $this->input->get('id');

        $data['id'] = $tid;
        $data['invoice'] = $this->uretim->uretim_details($tid, $this->limited);
        $data['products'] =  $this->uretim->uretim_products( $tid);
        $data['uretim_maliyet'] =  $this->uretim->uretim_maliyet( $tid);
        $data['employee'] = $this->uretim->employee($data['invoice']['user_id']);
        $data['customer']=customer_details( $data['invoice']['customer_id']);

        $data['personel']=personel_details($data['invoice']['personel_id']);



        ini_set('memory_limit', '64M');

        $html = $this->load->view('uretim/view-uretim-maliyet-print-' . LTR, $data, true);

        $header = $this->load->view('uretim/header-uretim-print-' . LTR, $data, true);

        //PDF Rendering

        $this->load->library('pdf');



        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['id'] . '</div>');


        $pdf->AddPage(
            '', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            80, // margin top
            '', // margin bottom
            0,0,0,0, // margin header
            ''); // margin footer

        $pdf->WriteHTML($html);



        $file_name = preg_replace( '/[^A-Za-z0-9]+/', '-', 'UretimFisi__'.$data['invoice']['name'].'_'. $data['invoice']['id']);

        if ($this->input->get('d')) {

            $pdf->Output($file_name. '.pdf', 'D');

        } else {

            $pdf->Output($file_name . '.pdf', 'I');

        }





    }




    public function uretim_maliyet()
    {
        $id = $this->input->get('id');
        $data['uretim_id'] = $id;


        $recete_id=recete_id_maliyet($id);
        $data['recete_id'] = $recete_id;

        $data['products'] = $this->uretim->invoice_products($recete_id);
        $data['maliyet'] = $this->db->query("SELECT * From geopos_uretim Where id=$id")->row()->maliyet;

        $head['title'] = "Maliyet Hesaplaması";

        $head['usernm'] = $this->aauth->get_user()->username;
        $data['all_giders']=[];
        $all_gider=$this->db->query("SELECT * From geopos_uretim_item Where uretim_id=$id and type='maliyet'");
        if($all_gider->num_rows()){
            $data['all_giders']=$all_gider->result();
        }

        $this->load->view('fixed/header', $head);

        $this->load->view('uretim/uretim_maliyet',$data);

        $this->load->view('fixed/footer');
    }




    public function edit_uretim()
    {

        $data['uretim_fis_id']=$this->input->get('id');
        $this->load->model('employee_model', 'employee');

        $head['title'] = "Üretim Fişi Düzenleme";


        $data['emp'] = $this->employee->list_employee();

        $uretim=$this->uretim->uretim_details($data['uretim_fis_id']);

        $data['recete_id'] = $uretim['recete_id'];

        $data['miktar']=$uretim['quantity'];

        $data['personel_id']=$uretim['personel_id'];

        $data['uretim_id']=$this->input->get('id');


        $data['tahmini_bitirme_tarihi']=tahmini_bitirme_tarhi($data['uretim_fis_id']);;

        $data['uretim_tarihi']=$uretim['uretim_date'];

        $data['uretim_desc']=$uretim['uretim_desc'];


        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('uretim/edit_uretim',$data);

        $this->load->view('fixed/footer');
    }


    public function edit_recete()
    {

        $tid = intval($this->input->get('id'));

        $data['id'] = $tid;

        $data['title'] = "Reçete Düzenle $tid";

        $this->load->model('customers_model', 'customers');

        $data['customergrouplist'] = $this->customers->group_list();

        $data['currency'] = $this->uretim->currencies();

        $data['invoice'] = $this->uretim->invoice_details($tid, $this->limited);

        if ($data['invoice']) $data['products'] = $this->uretim->invoice_products($tid);

        $head['title'] = "Reçete Düzenle #$tid";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->model('plugins_model', 'plugins');

        $data['exchange'] = $this->plugins->universal_api(5);

        $this->load->library("Common");

        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));





        $this->load->view('fixed/header', $head);

        if ($data['invoice']) $this->load->view('uretim/edit_recete', $data);

        $this->load->view('fixed/footer');
    }
    public function update_uretim()
    {


        $customer_id=0;
        $prodindex=0;
        $recete_id=recete_id($this->input->post('mamul_product_id'));
        $depo_id=purchase_in_depo($recete_id);
        $customer_id=customer_id_recete($recete_id);
        $productlist=array();

        $uretim_id = $this->input->post('uretim_id');

        $data['products'] =  $this->uretim->invoice_products( $recete_id);

        $data = array(

            'product_name' => $this->input->post('uretim_product_name'),
            'personel_id' => $this->input->post('personel'),
            'product_id' => $this->input->post('mamul_product_id'),
            'quantity' =>$this->input->post('miktar'),
            'uretim_date' =>datefordatabase($this->input->post('uretim_tarihi')),
            'uretim_desc' => $this->input->post('uretim_aciklamasi'),
            'user_id' => $this->aauth->get_user()->id,
            'recete_id' => $recete_id,
            'customer_id' => $customer_id,
            'depo_id' => $depo_id,
            'loc_id' => $this->aauth->get_user()->loc);


         $this->db->set($data);

        $this->db->where('id', $uretim_id);


        if ($this->db->update('geopos_uretim', $data)) {

            $old_user_id=$this->input->post('old_user_id');

            $this->db->delete('geopos_todolist', array('uretim_id' => $uretim_id));




            $name = 'ID: '.$uretim_id.'; üretim kontrolü size atanmıştır.';

            $status = 1;

            $priority = 'High';

            $stdate = $this->input->post('uretim_tarihi');

            $tdate = $this->input->post('uretim_bitis');

            $employee =  $this->input->post('personel');

            $content = $uretim_id.' ID ye sahip üretim kontrolü size atanmıştır.';

            $assign = $this->aauth->get_user()->id;

            $stdate = datefordatabase($stdate);

            $tdate = datefordatabase($tdate);

            $this->tools->addtask($name, $status, $priority, $stdate, $tdate, $employee, $assign, $content,$uretim_id);



            $data['products'] =  $this->uretim->invoice_products( $recete_id);

            $this->db->delete('geopos_uretim_item', array('uretim_id' => $uretim_id,'type'=>'uretim'));

            foreach ( $data['products'] as $prd)
            {

                $toplam=floatval($prd['qty'])+floatval($prd['fire_quantity']);

                $toplam_tuketilen= $toplam * floatval($this->input->post('miktar'));


                $data2 = array(
                    'pid' => $prd['pid'],
                    'name' => $prd['product'],
                    'uretim_id' => $uretim_id,
                    'quantity' => $this->input->post('miktar'),
                    'quantity_2' =>$prd['qty'],
                    'type' =>'uretim',
                    'fire' => $prd['fire'],
                    'fire_quantity' =>$prd['fire_quantity'],
                    'toplam_tuketilen' => $toplam_tuketilen);
                $prodindex++;

                $productlist[$prodindex] = $data2;
            }



            $this->db->insert_batch('geopos_uretim_item', $productlist);


            echo json_encode(array(
                'status' => 'Başarılı',
                'message' => $this->lang->line('uretim_save') . " <a href='view_uretim_fisi?id=$uretim_id' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . " </a> "));

        }


    }


    public  function  uretim_hesaplama()
    {
        $head['title'] = "Üretim Hesaplama";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('uretim/uretim_hesaplama');

        $this->load->view('fixed/footer');
    }

    public function uretim_qty_hesapla()
    {

        $id = $_POST['product_id'];
        $sorgu = $this->db->query("SELECT * FROM geopos_invoices WHERE  new_prd_id=$id")->row_array();
        $uretim_id = $sorgu['id'];


        $bolen = array();
        $sorgu = $this->db->query("SELECT * FROM geopos_invoice_items WHERE  tid=$uretim_id")->result();
        foreach ($sorgu as $sorgus) {
            $product_id = $sorgus->pid;
            $quantity = $sorgus->qty + $sorgus->fire_quantity;
            $urun_quantity = stok_ogren($product_id);
            $bln = $urun_quantity / $quantity;
            array_push($bolen, $bln);

        }
        $enkucuk = min($bolen);

        if ($enkucuk < 0) {
            echo "0 Adet Üretebilirsiniz...";
        } else {
            echo floor($enkucuk) . " Adet Üretebilirsiniz...";
        }
    }
}

?>