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

class Lojistikconfirm Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('communication_model');
        $this->load->model('lojistikconfirm_model', 'lojistik');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $id = $this->aauth->get_user()->id;
        $option=0;
        $staff_durum_=0;
        $staff_durum = $this->db->query("SELECT * FROM lsf_table_file_staff Where user_id = $id");
        if($staff_durum->num_rows()){
            $staff_durum_=$staff_durum->row()->sort;
        }
        if($staff_durum_==1){
            $option="<option value='7'>Onayla</option><option value='6'>Düzeliş İste</option>";
        }
        $data['option']=$option;
        $head['title'] = 'Tamamlanan Lojistik Hizmetleri';
        $this->load->view('fixed/header', $head);
        $this->load->view('lojistikconfirm/index',$data);
        $this->load->view('fixed/footer');
    }


    public function ajax_list(){
        $list = $this->lojistik->get_datatables_details();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $toplam_tutar = file_item_toplam_tutar_sorgula($prd->id);
            $check ="<input type='checkbox' method_id='$prd->method' file_id='$prd->id' class='form-control one_select'  style='width: 30px;'>";;
            $no++;
            $row = array();
            $row[] = $check;
            $row[] = $prd->code;
            $row[] = $prd->company;
            $row[] = $prd->created_at;
            $row[] = amountFormat($toplam_tutar);
            $row[] = $prd->method_name;
            $row[] = 'Bekliyor';
            $row[] = "<button file_id='$prd->id' class='btn btn-info view'><i class='fa fa-eye'></i></button>";
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->lojistik->count_all(),
            "recordsFiltered" => $this->lojistik->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }



    public function ajax_list_item(){
        $file_id = $this->input->post('file_id');
        $list = $this->lojistik->get_datatables_details_item($file_id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {


            $location_details = location_name_($prd->lsf_id);
            $lokasyon = '';
            foreach ($location_details as $items){
                $lokasyon.=$items->location.' ';
            }
            $notes_='';
            $notes=$this->db->query("SELECT * FROM `lojistik_notes` WHERE `lojistik_id` = $prd->sf_lojistik_id");
            $ljsf_code=$this->db->query("SELECT * FROM `lojistik_satinalma_talep` WHERE `id` = $prd->sf_lojistik_id")->row()->talep_no;
            if($notes->num_rows()){
                foreach ($notes->result() as $details){
                    $notes_.="<p>$details->notes</p>";
                }
            }

            $check ="<input type='checkbox' sf_lojistik_id='$prd->sf_lojistik_id' file_item_id='$prd->id' class='form-control one_select_item'  style='width: 30px;'>";;
            $no++;
            $row = array();
            $row[] = $check;
            $row[] = $ljsf_code;
            $row[] = $lokasyon;
            $row[] = $prd->gun_sayisi;
            $row[] = amountFormat($prd->unit_price);
            $row[] = amountFormat($prd->total_price);
            $row[] = $prd->arac_name;
            $row[] = $prd->teklif_price;
            $row[] = $notes_;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->lojistik->count_all_item($file_id),
            "recordsFiltered" => $this->lojistik->count_filtered_item($file_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function one_item_update(){
        $this->db->trans_start();
        $edit_table_id =  $this->input->post('edit_table_id');
        $count = count($edit_table_id);
        $i=0;
        foreach ($edit_table_id as $id){
            $status =  $this->input->post('status');
            $desc =  $this->input->post('desc');
            $this->db->set('desc', $desc);
            $this->db->set('status', $status);
            $this->db->where('id', $id);
            if($this->db->update('lsf_table_file_item')){

                $i++;

                $this->aauth->applog("Lojistik Satın Alma Dosyasındaki Itemlere Durum Bildirildi ITEM ID: " . $id, $this->aauth->get_user()->username);
            }
        }
        if($i==$count){
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde Durum Bildirildi"));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }

    }

    function _group_by($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }
    function group_by($key, $data) {
        $result = array();

        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }

        return $result;
    }

    public function all_update(){
        $this->db->trans_start();
        $file_id = $this->input->post('edit_table_id');
        $details_='';
        $count = count($file_id);
        $i=0;
        $str='';
        foreach ($file_id as $id){
            $str='';



            $lsf_table_file_item = $this->db->query("SELECT lojistik_satinalma_talep.talep_no FROM lsf_table_file_item
                                                  Inner JOIN lojistik_satinalma_item on lsf_table_file_item.lsf_id=lojistik_satinalma_item.id
                                                  LEFT JOIN lojistik_satinalma_talep ON lojistik_satinalma_talep.id=lojistik_satinalma_item.lojistik_id
WHERE lsf_table_file_item.lsf_table_file_id=$id")->result();
            foreach ($lsf_table_file_item as $items){
                $str.=$items->talep_no.'<br>';
            }
            $staff_type =  $this->input->post('user_id'); //1 proje müdürü 2 genel müdür
            $status =  $this->input->post('status');
            $desc =  $this->input->post('desc');

            $aau_id=$this->aauth->get_user()->id;
            $sort_kontol = $this->db->query("SELECT * FROM `lsf_table_file_staff` where user_id = $aau_id");
            if($sort_kontol->num_rows()) {
                $sort = $sort_kontol->row()->sort;
                $kontrol_sort = floatval($sort) + floatval(1);
                $staff = $this->db->query("SELECT * FROM `lsf_table_file_staff` where sort = $kontrol_sort");
                if($staff->num_rows()){
                    // Proje mÜdürü
                    $staff_id = $staff->row()->user_id;
                    $this->db->set('staff_id', $staff_id);
                    $this->db->where('id', $id);
                    $this->db->update('lsf_table_file');
                    if($status==6){
                        $this->db->set('status', 0);
                        $this->db->where('lsf_table_file_id', $id);
                        $this->db->update('lsf_table_file_item');
                    }
                }
                else {


                    if($status==2) // Alacaklandır
                    {
                        $proje_id=[];
                        $details_items=[];
                        $item_details_ = $this->db->query("SELECT * FROM `lsf_table_file_item` Where lsf_table_file_id = $id and status = 1 ")->result();


                        foreach ($item_details_ as $key=> $items){
                            $lsf_id = $items->lsf_id;
                            $details =  $this->db->query("SELECT * FROM `lojistik_satinalma_item` WHERE `id`=$lsf_id")->row();
                            $proje_id[] =$details->proje_id;
                            $details_items[]=
                                [
                                    'proje_id'=>$details->proje_id,
                                    'lsf_id'=>$lsf_id,
                                ];
                        }



                        $group_ = $this->group_by('proje_id',$details_items);

                        foreach (array_unique($proje_id) as $ids){
                            $total=0;
                            $firma_id=0;
                            $payer=0;
                            $method=0;
                            $str_new='';

                            foreach ($group_[$ids] as $items){
                                $lsf_id_ = $items['lsf_id'];
                                $file_details = $this->db->query("SELECT * FROM `lsf_table_file_item` Where lsf_id=$lsf_id_")->row();
                                $toplam_tutar = floatval($file_details->toplam_teklif)+floatval($file_details->toplam_gider);
                                $total+=$toplam_tutar;
                                $firma_id=$file_details->firma_id;
                                $method=$file_details->method;
                                $talep_no = $this->db->query("SELECT lojistik_satinalma_talep.talep_no FROM lojistik_satinalma_item INNER JOIN lojistik_satinalma_talep ON lojistik_satinalma_item.lojistik_id=lojistik_satinalma_talep.id Where lojistik_satinalma_item.id=$lsf_id_")->row()->talep_no;
                                $str_new.=$talep_no.'<br>';
                                $payer=customer_details($file_details->firma_id)['company'];
                            }


                            // İnsert
                            $data_invoice = [
                                'total'=>$total,
                                'notes'=>'Lojistik Alacaklandırması SF : '.$str_new,
                                'csd'=>$firma_id,
                                'eid'=>$this->aauth->get_user()->id,
                                'invoice_type_id'=>39,
                                'invoice_type_desc'=>'Cari Alacaklandır',
                                'payer'=>$payer,
                                'method'=>$method,
                                'proje_id'=>$ids,
                            ];
                            $this->db->insert('geopos_invoices', $data_invoice);
                        }

                    }

                    // genel Müdür
                    $this->db->set('status', $status);
                    $this->db->set('staff_status', $status);
                    $this->db->where('id', $id);
                    if($this->db->update('lsf_table_file')){
                        $this->db->set('desc', $desc);
                        $this->db->set('status', $status);
                        $this->db->where('lsf_table_file_id', $id);
                        $this->db->where('status', 1);
                        $this->db->update('lsf_table_file_item');


                    }
                }

                $this->db->set('status', $status);
                $this->db->set('desc', $desc);
                $this->db->where('user_id', $this->aauth->get_user()->id);
                $this->db->where('lsf_table_file_id', $id);
                $this->db->update('lsf_table_file_onay');
            }



            $this->aauth->applog("Lojistik Satın Alma Dosyasındaki Itemlere Durum Bildirildi ITEM ID: " . $id, $this->aauth->get_user()->username);

            $i++;

            // Mail Bilgisi

            $code =$this->db->query("SELECT * FROM lsf_table_file Where id =$id")->row()->code;
            $subject = 'Tamamlanan Hizmet Bildirimi';
            $message = 'Sayın Yetkili ' . $code . ' Numaralı Hizmet Dosyanıza Durum Bildirilmiştir.';
            $message .= "<br><br><br><br>";

            $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

//            $proje_sorumlusu_email = personel_detailsa($details_->lojistik_muduru)['email'];
//            $recipients = array($proje_sorumlusu_email);
//            $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$id);

            // Mail Bigisi
        }

        if($count==$i){
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde Durum Bildirildi"));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }

    }

}
