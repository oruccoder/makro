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





class Personel_model extends CI_Model
{
    var $table_news = 'geopos_employees ';

    var $column_search = array('geopos_employees.name', 'geopos_role.name', 'geopos_projects.name','geopos_projects.code');

    var $column_order = array(null,'geopos_employees.id','geopos_employees.name', 'geopos_role.name', 'geopos_projects.name');

    var $order = array('geopos_employees.id' => 'DESC');


    public function __construct()
    {
        parent::__construct();
        $this->load->model('communication_model');

    }

    public function list()

    {
        $this->_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }


    private function _list()
    {
        $user =$this->aauth->get_user()->id;
        $role_id = $this->aauth->get_user()->roleid;
        $santiye_id = personel_salary_details_get($user)->proje_id;
        $this->db->select('geopos_employees.*, geopos_users.banned, geopos_users.picture, geopos_users.roleid, geopos_users.loc, geopos_projects.name as proje_name, geopos_projects.code as proje_code, geopos_role.name as role_name');
        $this->db->from('geopos_employees');
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id');
        $this->db->join('personel_salary', 'personel_salary.personel_id = geopos_users.id', 'left');
        $this->db->join('geopos_projects', 'personel_salary.proje_id = geopos_projects.id', 'left');
        $this->db->join('geopos_role', 'geopos_users.roleid = geopos_role.role_id', 'left');
        $this->db->where('geopos_users.banned', 0);
        $this->db->where('personel_salary.status', 1);

        if (!$this->aauth->premission(95)->read) {
            // Eğer kullanıcı tüm personelleri görme yetkisine sahip değilse
            if (in_array($role_id, personel_yetkileri())) {
                // Kullanıcının şantiyesine göre filtrele
                $this->db->where('geopos_projects.id', $santiye_id);
            } else {
                // Yetkisi olmayan kullanıcılar için boş sonuç
                $this->db->where('1', 0);
            }
        }

        if ($this->session->userdata('set_firma_id')) {
            $this->db->where('geopos_employees.loc =', $this->session->userdata('set_firma_id'));
        }

        $i = 0;
        foreach ($this->column_search as $item) // loop column
        {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else {
            $this->db->order_by('geopos_employees.id', 'DESC');
        }
    }



    public function count_filtered()
    {
        $this->_list();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_list();
        return $this->db->count_all_results();
    }

	    function hash_password($pass, $userid)
    {
        if ($this->config_vars['use_password_hash']) {
            return password_hash($pass, $this->config_vars['password_hash_algo'], $this->config_vars['password_hash_options']);
        } else {
            $salt = md5($userid);
            return hash($this->config_vars['hash'], $salt . $pass);
        }
    }
	
	
	    public function new_password($id, $password)
    {
        $password = $this->aauth->hash_password($password, $id);

        if ($this->db->where(['id' => $id])->update('geopos_users', ['pass' => $password])) {
            return [
                'status' => 1,
            ];
        } else {
            return [
                'status' => 0,
            ];
        }

    }

    public function add_cart(){
        $personel_id = $this->input->post('personel_id');
        $skt_yil = $this->input->post('skt_yil');
        $skt_ay = $this->input->post('skt_ay');
        $cart_no = $this->input->post('cart_no');
        $personel_cart_details=$this->db->query("SELECT * FROM personel_cart Where pers_id=$personel_id");
        if($personel_cart_details->num_rows()){
            $data1 = array(
                'status' => 0,
            );
            $this->db->set($data1);
            $this->db->where('pers_id', $personel_id);
            $this->db->update('personel_cart');
        }

        $data_salary=
            [
                'pers_id'=>$personel_id,
                'skt_yil'=>$skt_yil,
                'skt_ay'=>$skt_ay,
                'number'=>$cart_no,
            ];
        if($this->db->insert('personel_cart', $data_salary))
        {
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Personel Kartı Oluşturuldu'
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }
    }
	
    public function create_save(){
        $name = $this->input->post('name');
        $username = str_replace(" ","",$name);
        $email = $this->input->post('email');
        $roleid = $this->input->post('roleid');
        $proje_id = $this->input->post('proje_id');
        $password = $this->input->post('password');
        $salary_type = $this->input->post('salary_type');
        $salary = $this->input->post('salary');
        $bank_salary = $this->input->post('bank_salary');
        $net_salary = $this->input->post('net_salary');
        $salary_day = $this->input->post('salary_day');
        $loc_id = $this->input->post('loc_id');
        $aylik_maas = $this->input->post('aylik_maas');

        $a = $this->aauth->create_user($email, $password, $username,$loc_id);

        if ((string)$this->aauth->get_user($a)->id != $this->aauth->get_user()->id) {
            $user_id = (string)$this->aauth->get_user($a)->id;
            $data_salary=
                [
                    'salary'=>$salary,
                    'bank_salary'=>$bank_salary,
                    'salary_day'=>$salary_day,
                    'salary_type'=>$salary_type,
                    'net_salary'=>$net_salary,
                    'proje_id'=>$proje_id,
                    'staff_id'=>$this->aauth->get_user()->id,
                    'personel_id'=>$user_id,
                    'aylik_maas'=>$aylik_maas,
                ];
            $this->db->insert('personel_salary', $data_salary);
            $data = array(
                'id' => $user_id,
                'username' => $username,
                'name' => $name,
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'region' => $this->input->post('region'),
                'country' => $this->input->post('country'),
                'ise_baslama_tarihi' => $this->input->post('ise_baslangic_tarihi'),
                'phone' => $this->input->post('phone'),
                'calisma_sekli' => $this->input->post('calisma_sekli'),
                'vatandaslik' => $this->input->post('vatandaslik'),
                'cinsiyet' => $this->input->post('cinsiyet'),
                'medeni_durumu' => $this->input->post('medeni_durumu'),
                'fin_no' => $this->input->post('fin_no'),
                'sorumlu_pers_id' => $this->input->post('sorumlu_pers_id'),
                'loc' => $this->input->post('loc_id'),
            );

            if ($this->db->insert('geopos_employees', $data)) {
                $data1 = array(
                    'roleid' => $roleid,
                    'loc' => $this->input->post('loc_id'),
                );
                $this->db->set($data1);
                $this->db->where('id', $user_id);
                $this->db->update('geopos_users');
                $this->aauth->applog("Personel Kartı Oluşturuldu : ".$user_id, $this->aauth->get_user()->username);

                //paralel var ise kayıt
                $paralel_firma_id = $this->input->post('paralel_firma_id');
                if($paralel_firma_id){
                    $paralel_pers_id = $this->input->post('paralel_pers_id');

                    $data_paralel = [
                        'aauth_id'=>$user_id,
                        'aauth_firma_id'=>$this->session->userdata('set_firma_id'),
                        'paralel_pers_id'=>$paralel_pers_id,
                        'paralel_firma_id'=>$paralel_firma_id
                    ];
                    $this->db->insert('locations_paralel_pers', $data_paralel);
                }
                //paralel var ise kayıt

                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde Personel Kartı Oluşturuldu'
                ];

            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız'
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Personel Zaten Oluşturulmuş'
            ];
        }


    }

    public function update(){

        $personel_id = $this->input->post('personel_id');
        $user_id = $this->input->post('personel_id');
        $name = $this->input->post('name');
        $username = str_replace(" ","",$name);
        $roleid = $this->input->post('roleid');
        $proje_id = $this->input->post('proje_id');
        $salary_type = $this->input->post('salary_type');
        $salary = $this->input->post('salary');
        $bank_salary = $this->input->post('bank_salary');
        $net_salary = $this->input->post('net_salary');
        $salary_day = $this->input->post('salary_day');
        $aylik_maas = $this->input->post('aylik_maas');
        $update = $this->input->post('update');
        $old_sorumlu = personel_detailsa($personel_id)['sorumlu_pers_id'];

        $this->db->set('status',0);
        $this->db->where('personel_id', $personel_id);
        $this->db->update('personel_salary');


        $data_salary=
            [
                'salary'=>$salary,
                'bank_salary'=>$bank_salary,
                'salary_day'=>$salary_day,
                'salary_type'=>$salary_type,
                'net_salary'=>$net_salary,
                'proje_id'=>$proje_id,
                'staff_id'=>$this->aauth->get_user()->id,
                'personel_id'=>$user_id,
                'aylik_maas'=>$aylik_maas,
            ];
//        $this->db->set($data_salary);
//        $this->db->where('personel_id', $user_id);
//        $this->db->update('personel_salary', $data_salary);
        $this->db->insert('personel_salary', $data_salary);

            $data = array(
                'id' => $user_id,
                'username' => $username,
                'name' => $name,
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'region' => $this->input->post('region'),
                'country' => $this->input->post('country'),
                'ise_baslama_tarihi' => $this->input->post('ise_baslangic_tarihi'),
                'phone' => $this->input->post('phone'),
                'calisma_sekli' => $this->input->post('calisma_sekli'),
                'vatandaslik' => $this->input->post('vatandaslik'),
                'cinsiyet' => $this->input->post('cinsiyet'),
                'medeni_durumu' => $this->input->post('medeni_durumu'),
                'fin_no' => $this->input->post('fin_no'),
                'sorumlu_pers_id' => $this->input->post('sorumlu_pers_id'),
                'loc' => $this->input->post('loc_id'),
            );

            $this->db->set($data);
            $this->db->where('id', $personel_id);
            if ($this->db->update('geopos_employees', $data)) {
                $data1 = array(
                    'roleid' => $roleid,
                    'loc' => $this->input->post('loc_id')
                );
                $this->db->set($data1);
                $this->db->where('id', $user_id);
                $this->db->update('geopos_users');
                $this->aauth->applog("Personel Kartı Güncellendi : ".$user_id.' Eski Sorumlu Pers ID '.$old_sorumlu, $this->aauth->get_user()->username);


                //paralel var ise kayıt

                $this->db->delete('locations_paralel_pers', array('aauth_id' => $user_id));
                $paralel_firma_id = $this->input->post('paralel_firma_id');
                if($paralel_firma_id){
                    $paralel_pers_id = $this->input->post('paralel_pers_id');

                    $data_paralel = [
                        'aauth_id'=>$user_id,
                        'aauth_firma_id'=>$this->session->userdata('set_firma_id'),
                        'paralel_pers_id'=>$paralel_pers_id,
                        'paralel_firma_id'=>$paralel_firma_id
                    ];
                    $this->db->insert('locations_paralel_pers', $data_paralel);
                }
                //paralel var ise kayıt


                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde Personel Kartı Oluşturuldu'
                ];

            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız'
                ];
            }

    }

    public function disable_user() {
        $uid = $this->input->post('personel_id');

        $this->db->select('banned');
        $this->db->from('geopos_users');
        $this->db->where('id', $uid);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_users.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $query = $this->db->get();
        $result = $query->row_array();
        if ($result['banned'] == 0) {
            if($this->aauth->ban_user($uid)){
                return [
                    'status'=>1,
                    'message'=>'Personel Pasifleştirilmiştir'
                ];
            }

        }  else {
            $data1 = array(
                'banned' => 0,
            );
            $this->db->set($data1);
            $this->db->where('id', $uid);
            if( $this->db->update('geopos_users')){
                return [
                    'status'=>1,
                    'message'=>'Personel Aktifleştirilmiştir'
                ];
            }
        }

    }

    public function details($id){
        $this->db->select('*');
        $this->db->from('geopos_employees');
        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_employees.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function users_details($id){
        $this->db->select('*');
        $this->db->from('geopos_users');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function paralel_details($id){
        $this->db->select('*');
        $this->db->from('locations_paralel_pers');
        $this->db->where('aauth_id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function salary_details($id){
        $this->db->select('*');
        $this->db->from('personel_salary');
        $this->db->where('personel_id',$id);
        $this->db->where('status',1);
        $query = $this->db->get();
        return $query->row();
    }

    public function deletedocument()
    {
        $id = $this->input->post('id');
        $this->db->select('filename');
        $this->db->from('geopos_documents_pers');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        if ($this->db->delete('geopos_documents_pers', array('id' => $id))) {
            @unlink(FCPATH .'userfiles/documents/' . $result['filename']);
            $this->aauth->applog("[Personel Dosyası Silindi]  Dosya ID $id PersonelID ",$this->aauth->get_user()->username);
            return [
                'status'=>1,
                'message'=>'Başarıyla Silinmiştir'
            ];
        } else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }



    }

    public function create_file(){
        $personel_id = $this->input->post('personel_id');
        $baslangic_date = $this->input->post('baslangic_date');
        $bitis_date = $this->input->post('bitis_date');
        $title = $this->input->post('title');
        $file_type = $this->input->post('file_type');
        $arac_id = $this->input->post('arac_id');
        $image_text = $this->input->post('image_text');
        $data = array(
            'baslangic_date' => $baslangic_date,
            'file_type' => $file_type,
            'arac_id' => $arac_id,
            'bitis_date' => $bitis_date,
            'title' => $title,
            'filename' => $image_text,
            'cdate' => date('Y-m-d'),
            'cid'=>$this->aauth->get_user()->id,
            'fid'=>$personel_id,'rid'=>1
        );
        if( $this->db->insert('geopos_documents_pers', $data)){
            return [
                'status'=>1,
                'message'=>'Başarıyla Dosya Eklenmiştir'
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }
    }

    public function personel_ajax_alacak_borc(){

        $tutar_expense = $this->input->post('tutar_expense');
        $aciklama_expense = $this->input->post('aciklama_expense');
        $alacakak_borc = $this->input->post('alacakak_borc');
        $method = $this->input->post('method');
        $acid = $this->input->post('acid');
        $vade = $this->input->post('vade');
        $image = $this->input->post('image');


        $list = $this->input->post('personel_details');
        $holder='';
        $acid_id =isset($acid)?$acid:0;
        $send_sms = $this->input->post('send_sms');
        if($acid){
            $holder = hesap_getir($acid)->holder;
            $acid_id = $acid;
        }
        $j=0;
        foreach ($list as $pers_id){
            $data = array(

                'csd' => $pers_id,
                'payer' => personel_details_full($pers_id)['name'],
                'acid' => $acid_id, //hesapID ekleneck
                'account' => $holder, //hesap adı ekelenecek
                'invoicedate' => date('Y-m-d'),
                'invoiceduedate' => date('Y-m-d'),
                'total' => $tutar_expense,
                'invoice_type_id'=>$alacakak_borc,
                'invoice_type_desc'=>invoice_type_desc($alacakak_borc),
                'method' => $method, //ödeme metodu ekelenecek
                'eid' => $this->aauth->get_user()->id, //user_id
                'cari_pers_type' => 2,
                'notes' => $aciklama_expense,
                'ext' => $image

            );
            if($this->db->insert('geopos_invoices', $data))
            {
                $j++;
                $last_id = $this->db->insert_id();
                $total =floatval($tutar_expense)/floatval($vade);
                for($i=1; $i<= $vade; $i++){
                    $date = new DateTime('now');
                    $date->modify('+'.$i.' month');
                    $borc_date =  $date->format('Y-m-d');
                    $data_credit = array (
                        'personel_id'=>$pers_id,
                        'transaction_id'=>$last_id,
                        'vade_date'=>$borc_date,
                        'total'=>$total,
                        'method'=>$method,
                        'type'=>2,
                        'acid'=>$acid
                    );
                    $this->db->insert('salary_credit', $data_credit);
                }
                if($send_sms){
                    $ret = $this->mesaj_gonder(personel_detailsa($pers_id)['phone'],$aciklama_expense.' Cəmi : '.amountFormat($tutar_expense));
                }
            }
        }

        if($j){
            return [
                'status'=>1,
                'message'=>'Başarıyla Oluşturulmuştur'
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }


    }


    public function personel_prim_talep(){
        $filed_upload = $this->input->post('filed_upload');
        $type = $this->input->post('type');
        $tutar = $this->input->post('tutar');
        $hesaplanan_ay = $this->input->post('hesaplanan_ay_');
        $aciklama = $this->input->post('aciklama');
        $proje_id_modal = $this->input->post('proje_id_modal');

        $proje_muduru =  proje_details($proje_id_modal)->proje_muduru_id;

        $index=0;
        $list = $this->input->post('personel_details');
        foreach ($list as $pers_id){
            $data=
                [
                    'personel_id'=>$pers_id,
                    'proje_id'=>$proje_id_modal,
                    'tutar'=>$tutar,
                    'aciklama'=>$aciklama,
                    'hesaplanan_ay'=>$hesaplanan_ay,
                    'type'=>$type,
                    'file'=>$filed_upload,
                    'user_id'=>$this->aauth->get_user()->id,
                ];

            $this->db->insert('personel_prim', $data);
            $personel_prim_id = $this->db->insert_id();

            $data_onay=
                [
                    'personel_prim_id'=>$personel_prim_id,
                    'staff_id'=>$proje_muduru,
                    'status'=>0,
                    'tip'=>1,
                    'is_staff'=>1,
                ];
            $this->db->insert('personel_prim_onay', $data_onay);

            $data_onay_g=
                [
                    'personel_prim_id'=>$personel_prim_id,
                    'staff_id'=>61,
                    'status'=>0,
                    'tip'=>2,
                    'is_staff'=>0,
                ];
            $this->db->insert('personel_prim_onay', $data_onay_g);

            $index++;
        }


        if($index){
            return [
                'status'=>1,
                'message'=>'Başarıyla Oluşturulmuştur'
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }


    }

    public function personel_is_cikis_update(){

        $is_cikis_desc = $this->input->post('is_cikis_desc');
        $is_cikis_date = $this->input->post('is_cikis_date');
        $hesap_kesim_date = $this->input->post('hesap_kesim_date');
        $index=0;
        $list = $this->input->post('personel_details');

        foreach ($list as $pers_id){
            $salary_details = $this->db->query("SELECT * FROM personel_salary Where personel_id = $pers_id and status = 1")->row();
            $this->db->set('status',0);
            $this->db->where('personel_id', $pers_id);
            $this->db->update('personel_salary');

            $data=
                [
                    'salary'=>$salary_details->salary,
                    'proje_id'=>$salary_details->proje_id,
                    'bank_salary'=>$salary_details->bank_salary,
                    'staff_id'=>$this->aauth->get_user()->id,
                    'salary_type'=>$salary_details->salary_type,
                    'salary_day'=>$salary_details->salary_day,
                    'personel_id'=>$pers_id,
                    'is_cikis_desc'=>$is_cikis_desc,
                    'is_cikis_date'=>datefordatabase($is_cikis_date),
                    'hesap_kesim_date'=>datefordatabase($hesap_kesim_date),
                ];

            $this->db->insert('personel_salary', $data);
            $index++;
        }

        if($index){
            return [
                'status'=>1,
                'message'=>'Başarıyla Oluşturulmuştur'
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }




    }

    public function mesaj_gonder($proje_sorumlusu_no,$mesaj)
    {
        $result='';
        $tel=str_replace(" ","",$proje_sorumlusu_no);

        $domain="https://sms.atatexnologiya.az/bulksms/api";
        $operation='submit';
        $login='makro2000';
        $password="makro!sms";
        $title='MAKRO2000';
        $bulkmessage=$mesaj;
        $scheduled='now';
        $isbulk='true';
        $msisdn='994'.$tel;

        $cont_id=rand(1,999999999);



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
        curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

        // Send to remote and return data to caller.
        $result = curl_exec($ch);

        curl_close($ch);


        return 1;




    }



    public function point_value($id)
    {
        $this->db->select_sum('puan');
        $this->db->where('personel_id',$id);

        if($this->session->userdata('set_firma_id')) {

            $this->db->where('personel_point.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $query1 = $this->db->get('personel_point');

        $data = array();

        if ($query1->row()->puan!=null){

            $query1 =  $query1->row();
            $data['all_puan_sum'] = $query1->puan;

            $this->db->where('personel_id',$id);
            if($this->session->userdata('set_firma_id'))
            {
                $this->db->where('personel_point.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
            }
            $data['all_count'] = $this->db->count_all_results('personel_point');
            $data['result'] = number_format(($query1->puan / $data['all_count'])*10,1);

            $this->db->select_max('created_at');
            $this->db->where('personel_id',$id);
            $query1 = $this->db->get('personel_point');
            $query1 = $query1->row();
            $data['created_at']  =$query1->created_at;
            $data['personel_id'] = $id;

            $this->db->select('auth_id');
            $this->db->where('personel_id',$id);
            $query1 = $this->db->get('personel_point');
            $query1 = $query1->row();
            $data['auth_id'] = $query1->auth_id;


            return $data;
        }
        else
        {
            $data['not_found'] = 'bu kisiye ait henuz puan  yok';
            $data['result'] = null;
            return $data;
        }
    }

}