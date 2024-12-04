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

class Arac Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('arac_model', 'arac');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function pass_kontrol()
    {
        $pass="post_pass";
        $userid='post_id';
        $salt = md5($userid);
       echo hash('sha256', $salt . $pass);
    }

    public function test_not()
    {
        $headers = [
            'Authorization: key=AAAA-X9x9Mc:APA91bE3E660tiKwm0BRrzqkP84Lln1AVQXIWJQQGr3TEBe7dpi1bMtDNjjzSKCWgBHhyJoQXYzXlQsS_607q1TtRCqBSKUkThPNvlFOlWf69UH_emuQIWtsgGUOqVaP_58lGHWjzGJI',
            'Content-Type: application/json'
        ];
        $notificarion = [
            'title'=>'Başlık',
            'body'=>'mesaj'
        ];

        $request=[
            'data'=>$notificarion,
            'registration_ids'=>array(21)
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googlepis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // ask for results to be returned
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));

        $res = curl_exec($ch);
        print_r($res);
        curl_close($ch);


    }

    public function index()
    {


        if (!$this->aauth->premission(26)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Araç Listesi';
            $this->load->view('fixed/header', $head);
            $this->load->view('arac/index');
            $this->load->view('fixed/footer');
        }
    }

    public function mk_araclist()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Araç Listesi';
        $this->load->view('fixed/header', $head);
        $data['items'] = $this->arac->mk_list();
        $this->load->view('arac/mk_araclist', $data);
        $this->load->view('fixed/footer');
    }

    public function ajax_list()
    {

        $list = $this->arac->get_datatables_details();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $pedding_driver = $this->arac->pedding_driver($prd->id);

            $str_driver = '<span style="left: 6px;" class="badge badge-pill badge-default badge-danger badge-default badge-up">' . $pedding_driver . '</span>';
            $button = '';
            $edit = "<button class='btn btn-warning edit' talep_id='$prd->id'><i class='fas fa-pencil-alt'></i></button>&nbsp;";
            $cancel = "<button class='btn btn-danger talep_sil' talep_id='$prd->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
            $ekipmanlar = "<button class='btn btn-info ekipmanlar' talep_id='$prd->id' type='button'><i class='fa fa-star'></i></button>&nbsp;";
            $date = "<button class='btn btn-info date_sozlesme' talep_id='$prd->id' type='button'><i class='fa fa-calendar'></i></button>&nbsp;";
            $icazeler = "<button class='btn btn-info icazeler' talep_id='$prd->id' type='button'><i class='fa fa-key'></i></button>&nbsp;";
            $oil = "<button class='btn btn-info oil' talep_id='$prd->id' type='button'><i class='fas fa-tint'></i></button>&nbsp;";
            $drivers = "<a href='/driver/index/$prd->id' class='btn btn-info drivers' type='button'><i class='fas fa-id-card'></i>$str_driver</a>&nbsp;";
            $traffic = "<button class='btn btn-info traffic' talep_id='$prd->id' type='button'><i class='fas fa-traffic-light'></i></button>&nbsp;";
            $view = "<button class='btn btn-success view' talep_id='$prd->id' type='button'><i class='fa fa-eye'></i></button>&nbsp;";


            $no++;
            $row = array();
            $row[] = '<span class="avatar-lg align-baseline"><img class="myImg" resim_yolu="' . base_url() . 'userfiles/product/' . $prd->image_text . '" src="' . base_url() . 'userfiles/product/thumbnail/' . $prd->image_text . '" ></span>';
            $row[] = $prd->code;
            $row[] = $prd->plaka;
            $row[] = $prd->name;
            $row[] = $prd->company;
            $row[] = $edit . $cancel . $ekipmanlar . $date . $icazeler . $oil . $drivers . $traffic . $view;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->arac->count_all(),
            "recordsFiltered" => $this->arac->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function create()
    {
        if (!$this->aauth->premission(26)->write) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Yeni Araç Tanımlama';
            $this->load->view('fixed/header', $head);
            $this->load->view('arac/create');
            $this->load->view('fixed/footer');
        }
    }

    public function while(){
        $keyword=0;
        while ($this->seo_kontrol($keyword)<1){

           $keyword++;
        }

        echo $keyword;
    }
    public function seo_kontrol($keyword){
        if($keyword==10){
            return 1;
        }
        else{
            return 0;
        }
    }

    public function create_save()
    {
        if (!$this->aauth->premission(26)->write) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {
            $firma_id = $this->input->post('firma_id');
            $name = $this->input->post('name');
            $plaka_no = $this->input->post('plaka');
            $marka = $this->input->post('marka');
            $yil = $this->input->post('yil');
            $model = $this->input->post('model');
            $renk = $this->input->post('renk');
            $bagaj_hacmi = $this->input->post('bagaj_hacmi');
            $yakit_tipi = $this->input->post('yakit_tipi');
            $ortalama_yakit = $this->input->post('ortalama_yakit');
            $agirlik = $this->input->post('agirlik');
            $active_surucu_id = $this->input->post('active_surucu_id');
            $sase_no = $this->input->post('sase_no');
            $image_text = $this->input->post('image_text');
            $kiralik_demirbas = $this->input->post('kiralik_demirbas');
            $yemek_cost_id = $this->input->post('yemek_cost_id');
            $benzin_cost_id = $this->input->post('benzin_cost_id');
            $demirbas_id = $this->input->post('demirbas_id');
            $talep_no = numaric(15);
            $this->db->trans_start();
            $data = array(
                'firma_id' => $firma_id,
                'demirbas_id' => $demirbas_id,
                'name' => $name,
                'plaka' => $plaka_no,
                'marka' => $marka,
                'yil' => $yil,
                'kiralik_demirbas' => $kiralik_demirbas,
                'active_surucu_id' => $active_surucu_id,
                'model' => $model,
                'renk' => $renk,
                'bagaj_hacmi' => $bagaj_hacmi,
                'yakit_tipi' => $yakit_tipi,
                'ortalama_yakit' => $ortalama_yakit,
                'agirlik' => $agirlik,
                'sase_no' => $sase_no,
                'image_text' => $image_text,
                'yemek_cost_id' => $yemek_cost_id,
                'benzin_cost_id' => $benzin_cost_id,
                'user_id' => $this->aauth->get_user()->id,
                'code' => $talep_no,
            );
            if ($this->db->insert('araclar', $data)) {

                $last_id = $this->db->insert_id();
                //sürücü listesine ekle
                $data_new =
                    [
                        'arac_id' => $last_id,
                        'status' => 2,
                        'user_id' => $active_surucu_id,
                        'aauth_id' => $this->aauth->get_user()->id,
                        'talep_id' => 0,
                    ];
                $this->db->insert('arac_suruculeri', $data_new);


                //sürücü listesine ekle

                $operator = "deger+1";
                $this->db->set('deger', "$operator", FALSE);
                $this->db->where('tip', 15);
                $this->db->update('numaric');
                $this->aauth->applog("Araç Eklendi  : Talep No : " . $talep_no, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 200 , 'message' => "Başarılı Bir Şekilde Talep Oluşturuldu", 'index' => '/arac/index'));

                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410 , 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
            }
        }
    }

    public function edit($id)
    {
        if (!$this->aauth->premission(26)->update) {
            echo json_encode(array('status' => 'Error' , 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Araç Düzenleme';
            $data['details'] = $this->arac->details($id);
            $this->load->view('fixed/header', $head);
            $this->load->view('arac/edit', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function update_save()
    {
        if (!$this->aauth->premission(26)->update) {
            echo json_encode(array('status' => 410 , 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {
            $arac_id = $this->input->post('arac_id');
            $firma_id = $this->input->post('firma_id');
            $kiralik_demirbas = $this->input->post('kiralik_demirbas');
            $name = $this->input->post('name');
            $plaka_no = $this->input->post('plaka');
            $marka = $this->input->post('marka');
            $active_surucu_id = $this->input->post('active_surucu_id');
            $yil = $this->input->post('yil');
            $model = $this->input->post('model');
            $renk = $this->input->post('renk');
            $bagaj_hacmi = $this->input->post('bagaj_hacmi');
            $yakit_tipi = $this->input->post('yakit_tipi');
            $ortalama_yakit = $this->input->post('ortalama_yakit');
            $agirlik = $this->input->post('agirlik');
            $sase_no = $this->input->post('sase_no');
            $image_text = $this->input->post('image_text');
            $yemek_cost_id = $this->input->post('yemek_cost_id');
            $benzin_cost_id = $this->input->post('benzin_cost_id');
            $demirbas_id = $this->input->post('demirbas_id');
            $this->db->trans_start();
            $data = array(
                'firma_id' => $firma_id,
                'demirbas_id' => $demirbas_id,
                'kiralik_demirbas' => $kiralik_demirbas,
                'name' => $name,
                'plaka' => $plaka_no,
                'active_surucu_id' => $active_surucu_id,
                'user_id' => $this->aauth->get_user()->id,
                'marka' => $marka,
                'yil' => $yil,
                'model' => $model,
                'renk' => $renk,
                'bagaj_hacmi' => $bagaj_hacmi,
                'yakit_tipi' => $yakit_tipi,
                'ortalama_yakit' => $ortalama_yakit,
                'agirlik' => $agirlik,
                'sase_no' => $sase_no,
                'image_text' => $image_text,
                'yemek_cost_id' => $yemek_cost_id,
                'benzin_cost_id' => $benzin_cost_id,
            );

            $this->db->set($data);
            $this->db->where('id', $arac_id);
            if ($this->db->update('araclar', $data)) {
                $last_id = $arac_id;

                if ($active_surucu_id) {
                    //sürücü listesine ekle
                    if ($this->db->delete('arac_suruculeri', array('talep_id' => 0, 'arac_id' => $last_id))) {
                        $data_new =
                            [
                                'arac_id' => $last_id,
                                'status' => 2,
                                'user_id' => $active_surucu_id,
                                'aauth_id' => $this->aauth->get_user()->id,
                                'talep_id' => 0,
                            ];
                        $this->db->insert('arac_suruculeri', $data_new);

                    }
                    //sürücü listesine ekle
                }


                $this->aauth->applog("Araç  Düzenlendi : " . $last_id, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 200  , 'message' => "Başarılı Bir Şekilde Düzenlendi", 'index' => '/arac/index'));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410 , 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
            }
        }
    }

    public function remove()
    {
        if (!$this->aauth->premission(26)->delete) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {
            $arac_id = $this->input->post('arac_id');
            $details = $this->arac->details($arac_id);
            $this->aauth->applog("Araç Silindi  : Araç Kodu : " . $details->code, $this->aauth->get_user()->username);
            if ($this->db->delete('araclar', array('id' => $arac_id))) {
                echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde Silindi"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
            }
        }
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

    public function get_info()
    {
        if (!$this->aauth->premission(26)->read) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        }
        else {
            $arac_id = $this->input->post('arac_id');
            $details = $this->arac->details($arac_id);
            $arac_ekipmanlari = $this->arac->arac_ekipmanlari($arac_id);
            $ekipmanlar = $this->arac->ekipmanlar();
            $bakimlar = $this->arac->bakimlar();
            $arac_bakimleri = $this->arac->arac_bakimlari($arac_id);
            $icazeler = $this->arac->icazeler();
            $arac_icazeleri = $this->arac->arac_icazeleri($arac_id);
            $arac_oil = $this->arac->arac_oil($arac_id);

            $arac_cezalari = $this->arac->arac_cezalari($arac_id);

            if ($details) {
                echo json_encode(array(
                    'status' => 'Success',
                    'items' => $details,
                    'arac_ekipmanlari' => $arac_ekipmanlari,
                    'ekipmanlar' => $ekipmanlar,
                    'bakimlar' => $bakimlar,
                    'arac_bakimleri' => $arac_bakimleri,
                    'icazeler' => $icazeler,
                    'arac_icazeleri' => $arac_icazeleri,
                    'arac_oil' => $arac_oil,
                    'arac_cezalari' => $arac_cezalari,
                ));
            }


        }
    }

    public function update_ekipman()
    {
        if (!$this->aauth->premission(26)->update) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {
            $arac_id = $this->input->post('arac_id');
            $check_id = $this->input->post('check_id');
            $this->db->trans_start();
            $count = 0;
            $this->db->delete('arac_ekipmanlari', array('arac_id' => $arac_id));
            foreach ($check_id as $id) {
                $data = array(
                    'arac_id' => $arac_id,
                    'ekipman_id' => $id,
                    'status' => 1,
                );
                if ($this->db->insert('arac_ekipmanlari', $data)) {
                    $count++;
                }
            }
            if ($count == count($check_id)) {
                $this->aauth->applog("Araç  Ekipmanlari : " . $arac_id, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde Düzenlendi"));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
            }
        }
    }

    public function update_bakim()
    {
        if (!$this->aauth->premission(26)->update) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {
            $arac_id = $this->input->post('arac_id');
            $bakim_id = $this->input->post('bakim_id');
            $user_id = $this->input->post('user_id');
            $firma_id = $this->input->post('firma_id');
            $tekrar_zamani = $this->input->post('tekrar_zamani');
            $ay_yil = $this->input->post('ay_yil');
            $son_yapilma_tarihi = $this->input->post('son_yapilma_tarihi');
            if ($ay_yil == 1) {
                $gelecek_donem_tarihi = date("Y-m-d", strtotime('+' . $tekrar_zamani . ' month', strtotime($son_yapilma_tarihi)));
            } else if ($ay_yil == 2) {
                $gelecek_donem_tarihi = date("Y-m-d", strtotime('+' . $tekrar_zamani . ' year', strtotime($son_yapilma_tarihi)));
            }


            $image_text_update = $this->input->post('image_text_update');
            $this->db->trans_start();

            $this->db->query("UPDATE `arac_bakimlari` SET status = 2 WHERE bakim_id=$bakim_id and arac_id=$arac_id");
            $data = array(
                'arac_id' => $arac_id,
                'bakim_id' => $bakim_id,
                'firma_id' => $firma_id,
                'user_id' => $user_id,
                'aauth_id' => $this->aauth->get_user()->id,
                'tekrar_zamani' => $tekrar_zamani,
                'ay_yil' => $ay_yil,
                'gelecek_donem_tarihi' => $gelecek_donem_tarihi,
                'file_name' => $image_text_update,
                'son_yapilma_tarihi' => $son_yapilma_tarihi,
                'status' => 1,
            );
            if ($this->db->insert('arac_bakimlari', $data)) {
                $this->aauth->applog("Araç  Bakımlari : " . $arac_id, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde Düzenlendi"));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
            }
        }
    }

    public function update_icaze()
    {
        if (!$this->aauth->premission(26)->update) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {
            $arac_id = $this->input->post('arac_id');
            $icaze_id = $this->input->post('icaze_id');
            $user_id = $this->input->post('user_id');
            $image_text_update = $this->input->post('image_text_update');
            $this->db->trans_start();
            $this->db->query("UPDATE `arac_icazeleri` SET status = 2 WHERE icaze_id=$icaze_id and arac_id=$arac_id");
            $data = array(
                'arac_id' => $arac_id,
                'icaze_id' => $icaze_id,
                'user_id' => $user_id,
                'aauth_id' => $this->aauth->get_user()->id,
                'file_name' => $image_text_update,
                'status' => 1,
            );
            if ($this->db->insert('arac_icazeleri', $data)) {
                $this->aauth->applog("Araç  İcazeleri : " . $arac_id, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde Eklendi"));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
            }
        }
    }

    public function update_oil()
    {
        if (!$this->aauth->premission(26)->update) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {
            $arac_id = $this->input->post('arac_id');
            $firma_id = $this->input->post('firma_id');
            $user_id = $this->input->post('user_id');
            $kart_no = $this->input->post('kart_no');
            $image_text_update = $this->input->post('image_text_update');
            $this->db->trans_start();
            $this->db->delete('arac_benzin_kart', array('arac_id' => $arac_id));
            $data = array(
                'arac_id' => $arac_id,
                'firma_id' => $firma_id,
                'user_id' => $user_id,
                'kart_no' => $kart_no,
                'aauth_id' => $this->aauth->get_user()->id,
                'file_name' => $image_text_update,
            );
            if ($this->db->insert('arac_benzin_kart ', $data)) {
                $this->aauth->applog("Araç  Benzin Kartı : " . $arac_id, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde Eklendi"));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
            }
        }
    }

    public function update_ceza()
    {
        if (!$this->aauth->premission(26)->update) {
            echo json_encode(array('status' => 410, 'message' => 'Yetkiniz Bulunmamaktadır'));
        } else {
            $arac_id = $this->input->post('arac_id');
            $ceza_id = $this->input->post('ceza_id');
            $tutar = $this->input->post('tutar');
            $user_id = $this->input->post('user_id');
            $date = $this->input->post('date');
            $ekstere_status = $this->input->post('ekstere_status');
            $image_text_update = $this->input->post('image_text_update');
            $this->db->trans_start();
            $data = array(
                'arac_id' => $arac_id,
                'ceza_id' => $ceza_id,
                'user_id' => $user_id,
                'tutar' => $tutar,
                'date' => $date,
                'ekstere_status' => $ekstere_status,
                'aauth_id' => $this->aauth->get_user()->id,
                'file_name' => $image_text_update,
            );
            if ($this->db->insert('arac_cezalari', $data)) {
                $this->aauth->applog("Araç  Cezası : " . $arac_id, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' => "Başarılı Bir Şekilde Eklendi"));
                $this->db->trans_complete();
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' => "Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
            }
        }
    }
}
