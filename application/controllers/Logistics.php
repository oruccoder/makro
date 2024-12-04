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

defined('BASEPATH') or exit('No direct script access allowed');

class Logistics extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model');
        $this->load->model('invoices_model');
        $this->load->model('communication_model');
        $this->load->model('logistics_model', 'lojistik');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Lojistik Satınalma Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('logistics/index');
        $this->load->view('fixed/footer');
    }

    public function create()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Yeni Lojistik Satınalma Talebi';
        $this->load->view('fixed/header', $head);
        $this->load->view('logistics/create');
        $this->load->view('fixed/footer');
    }


    public function view($id)
    {

        $data['details'] = $this->lojistik->details($id);

        if (!$data['details']) {
            exit('<h3>Talep Bulunamadı</h3>');
        }

//        $data['items']= $this->lojistik->item_details_sf($id);
        $item_details_location = $this->lojistik->item_details_location($id);


        $unique = array();

        foreach ($item_details_location as $value) {
            $unique[$value['location_id']] = $value;
        }

        $data['items'] = array_values($unique);
        $head['title'] = 'Satınalma Görüntüle';
        $data['lojistik_talep'] = $this->lojistik->lojistik_talep($id);


        $data['item_notes'] = $this->lojistik->notes($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('logistics/view', $data);
        $this->load->view('fixed/footer');
    }

    public function _group_by($array, $key)
    {
        $return = array();
        foreach ($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }

    public function talep_onay_start()
    {
        $talep_id = $this->input->post('talep_id');
        $this->db->set('bildirim_durumu', 1);
        $this->db->where('id', $talep_id);
        if ($this->db->update('lojistik_satinalma_talep')) {
            $details = $this->lojistik->details($talep_id);
            $data = array(
                'file_id' => $talep_id,
                'type' => 12
            );
            if ($this->db->insert('geopos_onay', $data)) {
                $subject = 'Lojistik Satın Alma Formu Onayı';
                $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Satın Alma Formu Oluşturuldu. Onay İşleminiz Beklenmektedir.';
                $message .= "<br><br><br><br>";

                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $proje_sorumlusu_email = personel_detailsa($details->lojistik_muduru)['email'];
                $recipients = array($proje_sorumlusu_email);
                if ($this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili', $talep_id)) {
                    $this->aauth->applog("Lojistik Satınalma Formu Onaya Sunuldu : " . $talep_id, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde Onaya Sunuldu"));
                }
            } else {
                echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız"));
            }

        }
    }

    public function talep_onay()
    {
        $talep_id = $this->input->post('talep_id');
        $status = $this->input->post('status');
        $desc = $this->input->post('desc');
//        $item_id = $this->input->post('item_id');
        $total = $this->input->post('total');
        $user_id = $this->aauth->get_user()->id;

        $details = $this->lojistik->details($talep_id);

        if ($details->bildirim_durumu == 1) {
            if ($user_id == $details->lojistik_muduru || $user_id == $details->proje_muduru || $user_id == $details->genel_mudur) {
                $this->db->delete('lojistik_onay', array('talep_id' => $talep_id, 'user_id' => $user_id, 'type' => 2));
//            $this->db->delete('lojistik_satinalma_total', array('sf_id' => $talep_id,'user_id'=>$user_id));

                $data = array(
                    'talep_id' => $talep_id,
                    'user_id' => $user_id,
                    'status' => 2,
                    'type' => 2,
                    'desc' => $desc

                );
                $this->db->insert('lojistik_onay', $data);
//
//            $data_total = array(
//                'sf_id' => $talep_id,
//                'user_id' => $user_id,
//                'total' => $total,
//
//            );
//            $this->db->insert('lojistik_satinalma_total ', $data_total);

                if ($user_id == $details->lojistik_muduru) {

                    $this->db->set('proje_sorumlusu_status', $status);
                    $this->db->set('proje_sorumlusu_status_note', $desc);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 12);
                    $this->db->update('geopos_onay');

                    $subject = 'Lojistik Satınalma Formu Onayı';
                    $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Satınalma Formu Lojistik Müdürü Tarafından Onaylandı.Sizin Onayınız Beklemektedir.';
                    $message .= "<br><br><br><br>";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $proje_sorumlusu_email = personel_detailsa($details->proje_muduru)['email'];
                    $recipients = array($proje_sorumlusu_email);
                    $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili', $talep_id);
                }
                if ($user_id == $details->proje_muduru) {
                    $this->db->set('proje_muduru_status', $status);
                    $this->db->set('proje_muduru_status_note', $desc);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 12);
                    $this->db->update('geopos_onay');


                    $subject = 'Lojistik Satın Alma Formu Onayı';
                    $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Satın Alma Formu Proje Müdürü Tarafından Onaylandı.Sizin Onayınız Beklemektedir.';
                    $message .= "<br><br><br><br>";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $proje_sorumlusu_email = personel_detailsa($details->genel_mudur)['email'];
                    $recipients = array($proje_sorumlusu_email);
                    $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili', $talep_id);

                    // Genel Müdüre Mail
                }
                if ($user_id == $details->genel_mudur) {
                    // Kullanici ID gidecek
                    $this->db->set('genel_mudur_status', $status);
                    $this->db->set('genel_mudur_status_note', $desc);
                    $this->db->where('file_id', $talep_id);
                    $this->db->where('type', 12);
                    $this->db->update('geopos_onay');


                    $this->db->set('status', 2);
                    $this->db->where('id', $talep_id);
                    $this->db->update('lojistik_satinalma_talep');

                    $subject = 'Lojistik Satın Alma Formu Onayı';
                    $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Satın Alma Formu Genel Müdürü Tarafından Onaylandı.Fiyat Araştırması Yapabilirsiniz.';
                    $message .= "<br><br><br><br>";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $proje_sorumlusu_email = personel_detailsa($details->user_id)['email'];
                    $recipients = array($proje_sorumlusu_email);
                    $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili', $talep_id);
                }

                echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde Onaylandı"));


            } else {
                echo json_encode(array('status' => 'Error', 'message' => "Yetkiniz Yoktur"));
            }

        } else {
            echo json_encode(array('status' => 'Error', 'message' => "Onay Sistemi Başlatılmamıştır!"));
        }


    }

    public function talep_iptal()
    {
        $talep_id = $this->input->post('talep_id');
        $status = $this->input->post('status');
        $desc = $this->input->post('desc');
        $user_id = $this->aauth->get_user()->id;
        $details = $this->lojistik->details($talep_id);


        if ($user_id == $details->lojistik_muduru || $user_id == $details->proje_muduru || $user_id == $details->genel_mudur) {

            $data = array(
                'talep_id' => $talep_id,
                'user_id' => $user_id,
                'status' => 3,
                'desc' => $desc

            );
            $this->db->insert('lojistik_onay', $data);


            $this->db->set('status', 3);
            $this->db->where('id', $talep_id);
            $this->db->update('lojistik_talep');

            if ($user_id == $details->lojistik_muduru) {

                $this->db->set('proje_sorumlusu_status', $status);
                $this->db->set('proje_sorumlusu_status_note', $desc);
                $this->db->where('file_id', $talep_id);
                $this->db->where('type', 11);
                $this->db->update('geopos_onay');

                $subject = 'Lojistik Satın Alma Formu İptal';
                $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Satın Alma Formu Lojistik Müdürü Tarafından İptal Edildi.';
                $message .= "Açıklama : " . $desc . "<br><br><br><br>";

                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $proje_sorumlusu_email = personel_detailsa($details->user_id)['email'];
                $recipients = array($proje_sorumlusu_email);
                $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili', $talep_id);
            }
            if ($user_id == $details->proje_muduru) {
                $this->db->set('proje_muduru_status', $status);
                $this->db->set('proje_muduru_status_note', $desc);
                $this->db->where('file_id', $talep_id);
                $this->db->where('type', 11);
                $this->db->update('geopos_onay');


                $subject = 'Lojistik Satın Alma Formu İptal';
                $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Satın Alma Formu Proje Müdürü Tarafından İptal Edildi.';
                $message .= "Açıklama : " . $desc . "<br><br><br><br>";

                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $proje_sorumlusu_email = personel_detailsa($details->user_id)['email'];
                $recipients = array($proje_sorumlusu_email);
                $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili', $talep_id);

                // Genel Müdüre Mail
            }
            if ($user_id == $details->genel_mudur) {
                // Kullanici ID gidecek
                $this->db->set('genel_mudur_status', $status);
                $this->db->set('genel_mudur_status_note', $desc);
                $this->db->where('file_id', $talep_id);
                $this->db->where('type', 11);
                $this->db->update('geopos_onay');


                $subject = 'Lojistik Satın Alma Formu İptal';
                $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Satın Alma Formu Genel Müdür Tarafından İptal Edildi.';
                $message .= "Açıklama : " . $desc . "<br><br><br><br>";

                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $proje_sorumlusu_email = personel_detailsa($details->user_id)['email'];
                $recipients = array($proje_sorumlusu_email);
                $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili', $talep_id);

            }
            echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde İptal Edildi"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => "Yetkiniz Bulunmamaktadır."));
        }
    }

    public function onay_mailleri($subject, $message, $recipients, $tip)
    {

        $attachmenttrue = false;
        $attachment = '';


        $this->communication_model->onay_mail($recipients, $subject, $message, $attachmenttrue, $attachment, $tip);
        return 1;

    }

    public function ajax_list()
    {

        $list = $this->lojistik->get_datatables_details();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $button = '';
            $edit = "<a class='btn btn-warning' href='/logistics/edit/$prd->id'><i class='fa fa-pen'></i></a>&nbsp;";
            $view = "<a class='btn btn-info' href='/logistics/view/$prd->id'><i class='fa fa-eye'></i></a>&nbsp;";
            $cancel = "<button class='btn btn-danger talep_iptal' talep_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
            if ($prd->bildirim_durumu == 0) { // Bekliyor
                $button = $edit . $view . $cancel;
            } else if ($prd->status == 1) {
                $button = $view . $cancel;
            } else if ($prd->status == 2) {
                $button = $view . $cancel;
            } else if ($prd->status == 3) {
                $button = $view;
            }
            $no++;
            $row = array();
            $row[] = $prd->created_at;
            $row[] = $prd->talep_no;
            $row[] = $prd->status_name;
            $row[] = $prd->pers_name;
            $row[] = $button;
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

    public function edit($id)
    {
        $result = $this->lojistik->lojistik_talep($id);
        $item = [];
        foreach ($result as $items) {
            $item[] = $items->l_id;
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Lojistik Düzenleme';
        $data['details'] = $this->lojistik->details($id);
        $data['items'] = $this->lojistik->item_details($id);
        $data['lojistik_talep'] = $item;
        $this->load->view('fixed/header', $head);
        $this->load->view('logistics/edit', $data);
        $this->load->view('fixed/footer');
    }

    public function create_save()
    {
        $lojistik_muduru = $this->input->post('lojistik_muduru');
        $proje_muduru = $this->input->post('proje_muduru');
        $genel_mudur_id = $this->input->post('genel_mudur_id');
        $desc = $this->input->post('desc');
        $lojistik_talep_id = $this->input->post('lojistik_talep_id');

        $talep_no = numaric(16);
        $this->db->trans_start();
        $data = array(
            'lojistik_muduru' => $lojistik_muduru,
            'proje_muduru' => $proje_muduru,
            'genel_mudur' => $genel_mudur_id,
            'description' => $desc,
            'user_id' => $this->aauth->get_user()->id,
            'talep_no' => $talep_no,
            'loc' => $this->session->userdata('set_firma_id'),
        );
        if ($this->db->insert('lojistik_satinalma_talep', $data)) {
            $last_id = $this->db->insert_id();
            foreach ($lojistik_talep_id as $t_id) {
                $data_lojistik = array(
                    'l_id' => $t_id,
                    'sf_id' => $last_id,

                );
                $this->db->insert('lojistik_to_satinalma', $data_lojistik);
            }

            $operator = "deger+1";
            $this->db->set('deger', "$operator", FALSE);
            $this->db->where('tip', 16);
            $this->db->update('numaric');

            $product_details = $this->input->post('product_details');
            $productlist = [];
            $prodindex = 0;

            $item_count = count($product_details);
            if (count($product_details)) {
                foreach ($product_details as $items) {
                    $data_item = [
                        'lojistik_id' => $last_id,
                        'proje_id' => $items['proje_id'],
                        'desc' => $items['desc'],
                        'firma_id' => $items['firma_id'],
                        'arac_id' => $items['arac_id'],
                        'qty' => $items['qty'],
                        'unit_id' => $items['unit_id'],
                        'price' => $items['price'],
                        'kdv_durum' => $items['kdv_durum'],
                        'kdv_oran' => $items['kdv_oran'],
                        'account_type' => $items['account_type'],
                    ];
                    $productlist[$prodindex] = $data;
                    $prodindex++;
                    $this->db->insert('lojistik_satinalma_item', $data_item);

                    $item_id = $this->db->insert_id();

                    $data_pers = [
                        'lojistik_id' => $last_id,
                        'item_id' => $item_id,
                        'pers_id ' => $items['personel_id'],
                        'status ' => 0,
                    ];
                    $this->db->insert('lojistik_to_personel', $data_pers);

                    $data_protokol = [
                        'lojistik_id' => $last_id,
                        'sf_item_id' => $item_id,
                        'protokol_id ' => $items['protokol']
                    ];
                    $this->db->insert('satinalma_protokol', $data_protokol);


                    foreach ($items['location'] as $values) {
                        $data_location = [
                            'sf_item_id' => $item_id,
                            'location_id ' => $values,
                            'lojistik_id' => $last_id,
                        ];
                        $this->db->insert('satinalma_location', $data_location);
                    }
                    if (isset($items['sf_no'])) {
                        foreach ($items['sf_no'] as $values) {
                            $data_sf = [
                                'lojistik_id' => $last_id,
                                'item_id' => $item_id,
                                'sf_id ' => $values,
                                'type ' => 2,
                            ];
                            $this->db->insert('lojistik_sf', $data_sf);
                        }
                    }

                }

                if ($item_count == $prodindex) {

                    $this->aauth->applog("Lojistik Satın Alma Talep Formu Eklendi : " . $last_id . ' Talep No : ' . $talep_no, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde Talep Oluşturuldu", 'view' => '/logistics/view/' . $last_id));

                    $this->db->trans_complete();
                } else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
                }

            }
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }

    public function update_save()
    {
        $lojistik_id = $this->input->post('talep_id');
        $lojistik_muduru = $this->input->post('lojistik_muduru');
        $proje_muduru = $this->input->post('proje_muduru');
        $genel_mudur_id = $this->input->post('genel_mudur_id');
        $desc = $this->input->post('desc');
        $lojistik_talep_id = $this->input->post('lojistik_talep_id');

        $this->db->trans_start();
        $data = array(
            'lojistik_muduru' => $lojistik_muduru,
            'proje_muduru' => $proje_muduru,
            'genel_mudur' => $genel_mudur_id,
            'description' => $desc,
            'user_id' => $this->aauth->get_user()->id,
        );

        $this->db->set($data);
        $this->db->where('id', $lojistik_id);
        if ($this->db->update('lojistik_satinalma_talep', $data)) {
            $last_id = $lojistik_id;

            $this->db->delete('lojistik_to_satinalma', array('sf_id' => $lojistik_id));
            foreach ($lojistik_talep_id as $t_id) {
                $data_lojistik = array(
                    'l_id' => $t_id,
                    'sf_id' => $last_id,

                );
                $this->db->insert('lojistik_to_satinalma', $data_lojistik);
            }

            $this->db->delete('lojistik_satinalma_item', array('lojistik_id' => $lojistik_id));
            $this->db->delete('lojistik_to_personel', array('lojistik_id' => $lojistik_id));
            $this->db->delete('satinalma_protokol', array('lojistik_id' => $lojistik_id));
            $this->db->delete('satinalma_location', array('lojistik_id' => $lojistik_id));
            $this->db->delete('lojistik_sf', array('lojistik_id' => $lojistik_id));


            $product_details = $this->input->post('product_details');
            $productlist = [];
            $prodindex = 0;


            $item_count = count($product_details);
            if (count($product_details)) {
                foreach ($product_details as $items) {
                    $data_item = [
                        'lojistik_id' => $last_id,
                        'proje_id' => $items['proje_id'],
                        'desc' => $items['desc'],
                        'firma_id' => $items['firma_id'],
                        'arac_id' => $items['arac_id'],
                        'qty' => $items['qty'],
                        'unit_id' => $items['unit_id'],
                        'price' => $items['price'],
                        'kdv_durum' => $items['kdv_durum'],
                        'kdv_oran' => $items['kdv_oran'],
                        'account_type' => $items['account_type'],
                    ];
                    $productlist[$prodindex] = $data;
                    $prodindex++;
                    $this->db->insert('lojistik_satinalma_item', $data_item);

                    $item_id = $this->db->insert_id();

                    $data_pers = [
                        'lojistik_id' => $last_id,
                        'item_id' => $item_id,
                        'pers_id ' => $items['personel_id'],
                        'status ' => 0,
                    ];
                    $this->db->insert('lojistik_to_personel', $data_pers);

                    $data_protokol = [
                        'lojistik_id' => $last_id,
                        'sf_item_id' => $item_id,
                        'protokol_id ' => $items['protokol']
                    ];
                    $this->db->insert('satinalma_protokol', $data_protokol);


                    foreach ($items['location'] as $values) {
                        $data_location = [
                            'sf_item_id' => $item_id,
                            'location_id ' => $values,
                            'lojistik_id' => $last_id,
                        ];
                        $this->db->insert('satinalma_location', $data_location);
                    }
                    foreach ($items['sf_no'] as $values) {
                        $data_sf = [
                            'lojistik_id' => $last_id,
                            'item_id' => $item_id,
                            'sf_id ' => $values,
                            'type ' => 2,
                        ];
                        $this->db->insert('lojistik_sf', $data_sf);
                    }
                }

                if ($item_count == $prodindex) {

                    $this->aauth->applog("Lojistik Satın Alma Talep Formu Düzenlendi : " . $last_id, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde Talep Düzenlendi", 'view' => '/logistics/view/' . $last_id));

                    $this->db->trans_complete();
                } else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
                }
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' => "Lokasyon Oluşturmalısınız."));
            }
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }

    public function get_lojistik()
    {
        $details = [];
        $lojistik_id = $this->input->post('id');
        $type = $this->input->post('type');
        foreach ($lojistik_id as $id) {
            $array = $this->db->query("SELECT * FROM lojistik_talep_item Where lojistik_id = $id ");
            if ($array->num_rows()) {
                foreach ($array->result() as $item) {
                    $item->proje_name = proje_name($item->proje_id);
                    $item->unit_name = units_($item->unit_id)['name'];
                    $item->arac_name = arac_view($item->arac_id)->name;
                    $item->locations = lojistik_items_location_($id, $item->id, 1);
                    $item->sf_no = lojistik_items_sf_($id, $item->id, $type);
                    $details[] = $item;
                }

            }
        }

        echo json_encode(array('status' => 'Success', 'details' => $details));
    }

    public function user_sf_details()
    {
        $sf_id = $this->input->post('sf_id');
        $details = [];
        $user_id = $this->input->post('user_id');
        $array = $this->db->query("SELECT * FROM `lojistik_onay` WHERE `type` = 2 AND `talep_id` = $sf_id AND `user_id` = $user_id ORDER BY `talep_id` ASC ");
        if ($array->num_rows()) {

            foreach ($array->result() as $items) {
                $array_ = $this->db->query("SELECT * FROM `lojistik_satinalma_item` WHERE id = $items->item_id")->row();
                $details[] = [
                    'desc' => $items->desc,
                    'created_at' => $items->created_at,
                    'lokasyon' => $array_->location,
                    'price' => $array_->price,
                    'company' => customer_details($array_->firma_id)['company'],
                ];
            }
        }

        echo json_encode(array('status' => 'Success', 'details' => $details));
    }

    public function firma_to_protokol()
    {
        $firma_id = $this->input->post('firma_id');
        $items = $this->lojistik->firma_to_protokol($firma_id);
        echo json_encode(array('status' => 'Success', 'items' => $items));

    }

    public function sf_talep_iptal()
    {
        $talep_id = $this->input->post('talep_id');
        $status = $this->input->post('status');
        $desc = $this->input->post('desc');
        $user_id = $this->aauth->get_user()->id;
        $details = $this->lojistik->details($talep_id);


        if ($user_id == $details->lojistik_muduru || $user_id == $details->proje_muduru || $user_id == $details->genel_mudur) {

            $data = array(
                'talep_id' => $talep_id,
                'user_id' => $user_id,
                'status' => 3,
                'desc' => $desc,
                'type' => 2

            );
            $this->db->insert('lojistik_onay', $data);


            $this->db->set('status', 3);
            $this->db->where('id', $talep_id);
            $this->db->update('lojistik_satinalma_talep');

            if ($user_id == $details->lojistik_muduru) {

                $this->db->set('proje_sorumlusu_status', $status);
                $this->db->set('proje_sorumlusu_status_note', $desc);
                $this->db->where('file_id', $talep_id);
                $this->db->where('type', 12);
                $this->db->update('geopos_onay');

                $subject = 'Lojistik Satın Alma Formu İptal';
                $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Satın Alma Formu Lojistik Müdürü Tarafından İptal Edildi.';
                $message .= "Açıklama : " . $desc . "<br><br><br><br>";

                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $proje_sorumlusu_email = personel_detailsa($details->user_id)['email'];
                $recipients = array($proje_sorumlusu_email);
                $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili', $talep_id);
            }
            if ($user_id == $details->proje_muduru) {
                $this->db->set('proje_muduru_status', $status);
                $this->db->set('proje_muduru_status_note', $desc);
                $this->db->where('file_id', $talep_id);
                $this->db->where('type', 12);
                $this->db->update('geopos_onay');


                $subject = 'Lojistik Satın Alma Formu İptal';
                $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Satın Alma Formu Proje Müdürü Tarafından İptal Edildi.';
                $message .= "Açıklama : " . $desc . "<br><br><br><br>";

                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $proje_sorumlusu_email = personel_detailsa($details->user_id)['email'];
                $recipients = array($proje_sorumlusu_email);
                $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili', $talep_id);

                // Genel Müdüre Mail
            }
            if ($user_id == $details->genel_mudur) {
                // Kullanici ID gidecek
                $this->db->set('genel_mudur_status', $status);
                $this->db->set('genel_mudur_status_note', $desc);
                $this->db->where('file_id', $talep_id);
                $this->db->where('type', 12);
                $this->db->update('geopos_onay');


                $subject = 'Lojistik Satın Alma Formu İptal';
                $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Satın Alma Formu Genel Müdür Tarafından İptal Edildi.';
                $message .= "Açıklama : " . $desc . "<br><br><br><br>";

                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                $proje_sorumlusu_email = personel_detailsa($details->user_id)['email'];
                $recipients = array($proje_sorumlusu_email);
                $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili', $talep_id);

            }
            echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde İptal Edildi"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => "Yetkiniz Bulunmamaktadır."));
        }
    }


    public function print($tid)
    {

        $data['id'] = $tid;
        $data['details'] = $this->lojistik->details($tid);
        $item_details_location = $this->lojistik->item_details_location($tid);
        $unique = array();

        foreach ($item_details_location as $value) {
            $unique[$value['location_id']] = $value;
        }

        $data['items'] = array_values($unique);
        $data['lojistik_talep'] = $this->lojistik->lojistik_talep($tid);


        ini_set('memory_limit', '999M');
        $html = $this->load->view('logistics/view-print', $data, true);
        $header = $this->load->view('logistics/header-print', $data, true);
        $footer = $this->load->view('logistics/footer-print', $data, true);

//        $this->load->view('logistics/header-print', $data);
//        $this->load->view('logistics/view-print',$data);
//        $this->load->view('logistics/footer-print',$data);


        //PDF Rendering
        $this->load->library('pdf');

        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter($footer);
        $pdf->AddPage(
            'L', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            50, // margin top
            '72', // margin bottom
            5, 2, 0, 0, // margin header
            'auto'); // margin footer

        $pdf->WriteHTML($html);


        $file_name = "Talep__";


        $pdf->Output($file_name . '.pdf', 'I');

    }

    public function islem_bitir()
    {
        $sf_item_id = $this->input->post('sf_item_id');
        $lojistik_id = $this->input->post('lojistik_id');
        $this->db->trans_start();
        $item_details = $this->db->query("SELECT * FROM `lojistik_satinalma_item` WHERE `id` = $sf_item_id")->row();
        $details = $this->db->query("SELECT * FROM `lojistik_satinalma_talep` WHERE `id` = $lojistik_id")->row();

        $location_id = [];
        $location_sf = $this->db->query("SELECT * FROM `satinalma_location` WHERE `sf_item_id` =$sf_item_id")->result();
        foreach ($location_sf as $items) {
            $location_id[] = $items->location_id;
        }


        $arac_gider = $this->db->query("SELECT * FROM `lojistik_to_gider` WHERE arac_id =$item_details->arac_id and lojistik_id = $lojistik_id");

        $gun_totals = 0;
        $gun_details = $this->db->query("SELECT SUM(total_price) as total_price FROM lojistik_to_gun Where lojistik_id = $lojistik_id and arac_id=$item_details->arac_id and lsf_id =$sf_item_id");
        if ($gun_details->num_rows()) {
            $gun_totals = $gun_details->row()->total_price;
        }
        $gider_total = 0;
        if ($arac_gider->num_rows()) {
            foreach ($arac_gider->result() as $values) {
                if (in_array($values->satinalma_location_id, $location_id)) {
                    $gider_total += floatval($values->total_price);
                }

            }
        }


        $arac_name = arac_view($item_details->arac_id)->name;


        $location_details = location_name_($sf_item_id);
        $lokasyon = '';
        foreach ($location_details as $items) {
            $lokasyon .= $items->location . ' ';
        }

        $price = floatval($item_details->qty) * floatval($item_details->price);

        $data = array(
            'lojistik_satinalma_id' => $lojistik_id,
            'sf_item_id' => $sf_item_id,
            'status' => 1,
            'aauth_id' => $this->aauth->get_user()->id,
            'user_id' => 21,
            'teklif_tutari' => $price,
            'giderler_tutari' => floatval($gider_total) + floatval($gun_totals),
            'method' => $item_details->account_type,
        );
        if ($this->db->insert('lojistik_admin_confirm', $data)) {
            $subject = 'Lojistik Hizmet Tamamlama';
            $message = 'Sayın Yetkili ' . $details->talep_no . ' Numaralı Lojistik Satın Almasındaki ' . $lokasyon . ' Lokasyonundaki ' . $arac_name . ' Araç Hizmetini Tamamladı.Onayınız Bekliyor';
            $message .= "<br><br><br><br>";

            $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

            $proje_sorumlusu_email = personel_detailsa(21)['email'];
            $recipients = array($proje_sorumlusu_email);
            if ($this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili', $lojistik_id)) {
                $this->aauth->applog("Lojistik Satınalma Formunda Hizmet Tamamlama Onayı İstendi LJS-ID: " . $lojistik_id . ' LSFI-ID : ' . $sf_item_id, $this->aauth->get_user()->username);
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde Onaya Sunuldu"));
            }
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız"));
        }
    }

    public function lojistikhizmetcount()
    {

        $lojistikhizmetcount = $this->lojistik->lojistikhizmetcount();
        echo json_encode(array('status' => 'Success', 'count' => 0));
    }

    public function lojistikhizmetlist()
    {

        if (!$this->aauth->premission(33)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Lojistik Satınalma Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('logistics/lojistikhizmetlist');
        $this->load->view('fixed/footer');
    }

    public function ajax_lojistikhizmetlist()
    {
        $list = $this->lojistik->ajax_lojistikhizmetlist();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

//            $button='';
//            $edit = "<a class='btn btn-warning' href='/logistics/edit/$prd->id'><i class='fa fa-pen'></i></a>&nbsp;";
//            $view = "<a class='btn btn-info' href='/logistics/view/$prd->id'><i class='fa fa-eye'></i></a>&nbsp;";
//            $cancel = "<button class='btn btn-danger talep_iptal' talep_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
//            if($prd->bildirim_durumu == 0){ // Bekliyor
//                $button=$edit.$view.$cancel;
//            }
//            else if($prd->status == 1 ){
//                $button=$view.$cancel;
//            }
//            else if($prd->status == 2 ){
//                $button=$view.$cancel;
//            }
//            else if($prd->status == 3 ){
//                $button=$view;
//            }

            $location_id = [];
            $location_sf = $this->db->query("SELECT * FROM `satinalma_location` WHERE `sf_item_id` =$prd->lsf_id");
            if ($location_sf->num_rows()) {
                foreach ($location_sf->result() as $items) {
                    $location_id[] = $items->location_id;
                }
            }

            $arac_gider = $this->db->query("SELECT * FROM `lojistik_to_gider` WHERE arac_id =$prd->arac_id and lojistik_id = $prd->talep_id");

            $gider_total = 0;
            if ($arac_gider->num_rows()) {
                foreach ($arac_gider->result() as $values) {
                    if (count($location_id)) {
                        if (in_array($values->satinalma_location_id, $location_id)) {
                            $gider_total += floatval($values->total_price);
                        }
                    }


                }
            }

            $gun_totals = 0;
            $gun_details = $this->db->query("SELECT SUM(total_price) as total_price FROM lojistik_to_gun Where lojistik_id = $prd->talep_id and arac_id=$prd->arac_id and lsf_id =$prd->lsf_id");
            if ($gun_details->num_rows()) {
                $gun_totals = $gun_details->row()->total_price;
            }

            $location_details = location_name_($prd->lsf_id);

            $lokasyon = '';

        if($location_details){
            foreach ($location_details as $items) {
                $lokasyon .= $items->location . ' ';
            }
        }



            $lojistik_to_car_id = '';
            $arac_to_car = $this->db->query("SELECT * FROM lojistik_to_car Where lojistik_id = $prd->talep_id and sf_arac_id=$prd->arac_id");

            if ($arac_to_car->num_rows()) {
                $lojistik_to_car_id = $arac_to_car->row()->id;
            }

            $hrk = "<button class='btn btn-success arac_hareketleri' lojistik_car_id='$lojistik_to_car_id' lojistik_id='$prd->talep_id' arac_id='$prd->arac_id' type='button'>
            <i class='fa fa-truck'></i>&nbsp;$prd->name</button>";

            $status = '';

            if (lj_satinalma_onay_kontrol($prd->lsf_id)) {
                $status = lj_satinalma_onay_kontrol($prd->lsf_id);
            } else {
                if ($prd->status == 1) {
                    $status = 'Talep Bekliyor';
                } elseif ($prd->status == 2) {
                    $status = 'Talep Onaylandı';
                } elseif ($prd->status == 3) {
                    $status = 'Talep İptal Edildi';
                }
            }

            $gun_sayisi = 0;
            $gun_details = $this->db->query("SELECT SUM(gun_sayisi) as gun_sayisi FROM lojistik_to_gun Where lojistik_id = $prd->talep_id and arac_id=$prd->arac_id and lsf_id =$prd->lsf_id");
            if ($gun_details->num_rows()) {
                $gun_sayisi = $gun_details->row()->gun_sayisi;
            }


            $toplam_gider = $gider_total + $gun_totals;
            $check = "<input type='checkbox' teklif_tutari='$prd->teklif_tutari' toplam_gider='$toplam_gider' method_id='$prd->account_type_id' firma_id='$prd->customer_id' lsf_id='$prd->lsf_id' class='form-control one_select_talep'  style='width: 30px;' >";
            $button='';
            $array = $this->lojistik->lojistik_talep($prd->talep_id);
                foreach ($array as $taleps){
                $button.='<a target="_blank" href="/lojistik/view/'.$taleps->l_id.'" class="btn btn-info btn-sm  ml-1">Lojistik Talebi</a>';
                }


            $no++;
            $row = array();
            $row[] = $check;
            $row[] = $prd->created_at;
            $row[] = "<a href='/logistics/view/$prd->talep_id' class='btn btn-info btn-sm'>$prd->talep_no</a>";
            $row[]=$button;
            $row[] = $prd->company;
            $row[] = $lokasyon;
            $row[] = $gun_sayisi;
            $row[] = $hrk;
            $row[] = amountFormat($prd->teklif_tutari);
            $row[] = amountFormat($gider_total + $gun_totals);
            $row[] = $prd->method_name;
            $row[] = $status;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->lojistik->ajax_lojistikhizmetlist_count(),
            "recordsFiltered" => $this->lojistik->ajax_lojistikhizmetlist_filter(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function sms_confirm()
    {

        $details = $this->input->post('details');
        $kont_say = 0;
        foreach ($details as $item) {
            $kontrol = $this->db->query("SELECT * FROM lsf_table_file_item WHERE lsf_id=" . $item['lsf_id'] . " and status = 1")->num_rows();
            if ($kontrol) {
                $kont_say++;
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' => "Onayda Bekleyen Lojistik Seçtiniz"));
                exit();
            }
        }

        if ($kont_say == 0) {
            $code = rand(1, 99999);
            $data = [
                'codes' => $code,
            ];
            $this->db->insert('sms_confirm', $data);
            $last_id = $this->db->insert_id();
            $phone = "512018400";
            $meesage = 'Dogrulama Kodu  :  ' . $code;
            $tel = str_replace(" ", "", $phone);
            $domain = "https://sms.atatexnologiya.az/bulksms/api";
            $operation = 'submit';
            $login = 'makro2000';
            $password = "makro!sms";
            $title = 'MAKRO2000';
            $bulkmessage = $meesage;
            $scheduled = 'now';
            $isbulk = 'true';
            $msisdn = '994' . $tel;
            //$msisdn = '994502862033' ;
            $cont_id = rand(1, 999999999);
            $input_xml = "<?xml version='1.0' encoding='UTF-8'?>
               <request>
                <head>
                    <operation>$operation</operation>
                    <login>$login</login>
                    <password>$password</password>
                    <title>$title</title>
                    <bulkmessage>$bulkmessage</bulkmessage>
                    <scheduled>$scheduled</scheduled>
                    <isbulk>$isbulk</isbulk>
                    <controlid>$cont_id</controlid>
                </head>
                    <body>
                    <msisdn>$msisdn</msisdn>
                    </body>
                </request>";


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $domain);

            // For xml, change the content-type.
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));

            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

            $result = curl_exec($ch);
            curl_close($ch);
            echo json_encode(array('confirm_id' => $last_id, 'status' => 'Success', 'message' =>
                "Başarıyla Sms Gönderildi",'code'=>$code));
        }


    }

    public function lsf_table_file_create()
    {
        $details = $this->input->post('details');
        $talep_code = numaric(19);

        $this->db->trans_start();
        $firma_id = 0;
        $teklif_tutari = 0;
        $toplam_gider = 0;
        $method_id = 0;
        foreach ($details as $item) {
            $firma_id = $item['firma_id'];
            $method_id = $item['method_id'];
            $teklif_tutari += $item['teklif_tutari'];
            $toplam_gider += $item['toplam_gider'];


        }

        $one_staff = $this->db->query("SELECT * FROM lsf_table_file_staff Where sort=1")->row()->user_id;
        $data_file = [
            'code' => $talep_code,
            'firma_id' => $firma_id,
            'toplam_teklif' => $teklif_tutari,
            'toplam_gider' => $toplam_gider,
            'method' => $method_id,
            'status' => 1,
            'staff_status' => 1, // 1 = Bekliyor 2 = Onaylandı
            'staff_id' => $one_staff,
            'aauth_id' => $this->aauth->get_user()->id,
            'loc'=>    $this->session->userdata('set_firma_id')
        ];

        if ($this->db->insert('lsf_table_file', $data_file)) {
            $last_id = $this->db->insert_id();

            $staff = $this->db->query("SELECT * FROM lsf_table_file_staff  ORDER BY `lsf_table_file_staff`.`sort` ASC")->result();
            foreach ($staff as $items) {
                $data_onay = [
                    'lsf_table_file_id' => $last_id,
                    'status' => 0,
                    'sort' => $items->sort,
                    'user_id' => $items->user_id,
                ];
                $this->db->insert('lsf_table_file_onay', $data_onay);
            }


            $operator = "deger+1";
            $this->db->set('deger', "$operator", FALSE);
            $this->db->where('tip', 19);
            $this->db->update('numaric');
            $productlist = [];
            $prodindex = 0;

            foreach ($details as $item) {
                $data_file_item = [
                    'lsf_table_file_id' => $last_id,
                    'firma_id' => $firma_id,
                    'toplam_teklif' => $item['teklif_tutari'],
                    'toplam_gider' => $item['toplam_gider'],
                    'method' => $method_id,
                    'status' => 1,
                    'lsf_id' => $item['lsf_id']
                ];

                $productlist[$prodindex] = $data_file_item;
                $prodindex++;
            }
            if ($prodindex > 0) {
                $this->db->insert_batch('lsf_table_file_item', $productlist);

                $this->aauth->applog("Lojistik Hizmet Tamamlama Onayları İstendi Dosya ID: " . $last_id, $this->aauth->get_user()->username);
                $this->db->trans_complete();
                echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde Onaya Sunuldu"));
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız"));
            }

        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız"));
        }


    }

    public function ajax_list_onay_bekleyen(){

        $user_id = $this->aauth->get_user()->id;
        $list = $this->lojistik->ajax_list_onay_bekleyen();
        $data = array();
        $no = $this->input->post('start');

        //$new_list = $list;
        $new_list=[];
        foreach ($list as $prd) {

            $lojistik_muduru = $prd->lojistik_muduru;
            $proje_muduru = $prd->proje_muduru;
            $genel_mudur = $prd->genel_mudur;

            if($user_id == $lojistik_muduru){
                $kontol = $this->db->query("SELECT * FROM lojistik_onay Where talep_id = $prd->id and  type=2")->num_rows();
                if(!$kontol){
                    $new_list[]=$prd;
                }
            }
            elseif($user_id == $proje_muduru){
                $kontol = $this->db->query("SELECT * FROM lojistik_onay Where talep_id = $prd->id and type=2 and user_id=$lojistik_muduru")->num_rows();
                if($kontol){
                    $new_list[]=$prd;
                }
            }
            elseif($user_id == $genel_mudur){

                $kontol = $this->db->query("SELECT * FROM lojistik_onay Where talep_id = $prd->id and type=2 and user_id=$proje_muduru")->num_rows();
                if($kontol){
                    $new_list[]=$prd;
                }
            }


        }

        foreach ($new_list as $prd) {

            $view = "<a class='btn btn-info' href='/logistics/view/$prd->id'><i class='fa fa-eye'></i></a>&nbsp;";

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->created_at;
            $row[] = personel_details_full($prd->user_id)['name'];
            $row[] = $prd->talep_no;
            $row[] = 'Bekliyor';
            $row[] =$view;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => count($new_list),
            "recordsFiltered" => count($new_list),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

}

