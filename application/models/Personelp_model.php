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





class Personelp_model extends CI_Model
{
    var $doccolumn_order = array(null, 'title', 'cdate', null);

    var $doccolumn_search = array('title', 'cdate');

    var $table_news = 'geopos_employees_p ';

    var $column_search = array('geopos_employees_p.name', 'geopos_role.name', 'geopos_projects.name','geopos_projects.code');

    var $column_order = array(null,'geopos_employees_p.id',null,'geopos_employees_p.name', 'geopos_role.name', 'geopos_projects.name');

    var $order = array('geopos_employees_p.id' => 'DESC');


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

        $this->db->select('geopos_employees_p.*,
        geopos_users_p.banned,
        geopos_users_p.picture,
        geopos_users_p.roleid ,
        geopos_users_p.loc,
        geopos_projects.name as proje_name,
        geopos_projects.code as proje_code,
        geopos_role.name as role_name');
        $this->db->from('geopos_employees_p');
        $this->db->join('geopos_users_p', 'geopos_employees_p.id = geopos_users_p.id');
        $this->db->join('personel_salary_p', 'personel_salary_p.personel_id = geopos_users_p.id','left');
        $this->db->join('geopos_projects', 'personel_salary_p.proje_id = geopos_projects.id','left');
        $this->db->join('geopos_role', 'geopos_users_p.roleid = geopos_role.role_id','left');
        $this->db->where('geopos_users_p.banned', 0);
        $this->db->where('personel_salary_p.status', 1);

        if($this->input->post('cari_id')){
            $this->db->where('geopos_employees_p.ana_cari',$this->input->post('cari_id'));
        }
        if($this->input->post('parent_id')){
            $this->db->where('geopos_employees_p.podradci_id',$this->input->post('parent_id'));
        }
        if($this->input->post('proje_id')){
            $this->db->where('personel_salary_p.proje_id',$this->input->post('proje_id'));
        }

        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_employees_p.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $i = 0;
        foreach ($this->column_search as $item) // loop column

        {
            if ($_POST['search']['value']) // if datatable send POST for search

            {
                if ($i === 0) // first loop

                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, $_POST['search']['value']);

                } else {

                    $this->db->or_like($item, $_POST['search']['value']);

                }

                if (count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else {
            $this->db->order_by('`geopos_employees_p`.`id` DESC');
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

        if ($this->db->where(['id' => $id])->update('geopos_users_p', ['pass' => $password])) {
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



            $data_users = array(
                'email' => $email,
                'pass' => 123456,
                'username' => (!$username) ? '' : $username,
                'date_created' => date("Y-m-d H:i:s"),
                'picture'=>'example.png'
            );
            $this->db->insert('geopos_users_p', $data_users);
            $user_id = $this->db->insert_id();

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
            $this->db->insert('personel_salary_p', $data_salary);
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
                'seri_no' => $this->input->post('seri_no'),
                'sorumlu_pers_id' => $this->input->post('sorumlu_pers_id'),
                'loc' => $this->input->post('loc_id'),
            );

            if ($this->db->insert('geopos_employees_p', $data)) {
                $last_id = $this->db->insert_id();
                $response = $this->update_personel($last_id,$this->input->post('podradci_id'),$this->input->post('ana_cari'));
                $data1 = array(
                    'roleid' => $roleid,
                    'loc' => $this->input->post('loc_id'),
                );
                $this->db->set($data1);
                $this->db->where('id', $user_id);
                $this->db->update('geopos_users_p');
                $this->aauth->applog("Podradçı Personel Kartı Oluşturuldu : ".$user_id, $this->aauth->get_user()->username);

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

    public function info_personel()
    {
        $id=$this->input->post('personel_id');
        $this->db->select('*');
        $this->db->from('geopos_employees_p');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function update_personel()
    {

        $personel_id = $this->input->post('personel_id');
        $podradci_id = $this->input->post('podradci_id');
        $ana_cari_id = $this->input->post('ana_cari');
        // Başlangıç değerini tanımla
        $ana_cari = $ana_cari_id;
        // Podradci ID varsa ana_cari değerini al
        if ($podradci_id) {
            $query = $this->db->query("SELECT ana_cari FROM podradci WHERE id = ?", [$podradci_id])->row();
            if ($query) {
                $ana_cari = $query->ana_cari;
            }
        }

        // Güncellenecek veriler
        $data = [
            'podradci_id' => $podradci_id,
            'ana_cari' => $ana_cari,
        ];

        // Veritabanında güncelleme işlemi
        $this->db->where('id', $personel_id);
        if ($this->db->update('geopos_employees_p', $data)) {
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde güncellendi'
            ];
        } else {
            return [
                'status'=>0,
                'message'=>'Güncelleme Gerçekleşmedi.Eksik veya Hatalı Bilgi Girişi Yapıldı'
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

        $this->db->set('status',0);
        $this->db->where('personel_id', $personel_id);
        $this->db->update('personel_salary_p');


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
//        $this->db->update('personel_salary_p', $data_salary);
        $this->db->insert('personel_salary_p', $data_salary);

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
            'seri_no' => $this->input->post('seri_no'),
            'sorumlu_pers_id' => $this->input->post('sorumlu_pers_id'),
            'loc' => $this->input->post('loc_id'),
        );

        $this->db->set($data);
        $this->db->where('id', $personel_id);
        if ($this->db->update('geopos_employees_p', $data)) {
            $data1 = array(
                'roleid' => $roleid,
                'loc' => $this->input->post('loc_id')
            );
            $this->db->set($data1);
            $this->db->where('id', $user_id);
            $this->db->update('geopos_users_p');
            $this->aauth->applog("Podradçı Personel Kartı Güncellendi : ".$user_id, $this->aauth->get_user()->username);



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
        $this->db->from('geopos_users_p');
        $this->db->where('id', $uid);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_users_p.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
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
            if( $this->db->update('geopos_users_p')){
                return [
                    'status'=>1,
                    'message'=>'Personel Aktifleştirilmiştir'
                ];
            }
        }

    }

    public function details($id){
        $this->db->select('*');
        $this->db->from('geopos_employees_p');
        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_employees_p.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function users_details($id){
        $this->db->select('*');
        $this->db->from('geopos_users_p');
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
        $this->db->from('personel_salary_p');
        $this->db->where('personel_id',$id);
        $this->db->where('status',1);
        $query = $this->db->get();
        return $query->row();
    }

    public function deletedocument()
    {
        $id = $this->input->post('id');
        $this->db->select('filename');
        $this->db->from('geopos_documents_pers_p');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        if ($this->db->delete('geopos_documents_pers_p', array('id' => $id))) {
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
        if( $this->db->insert('geopos_documents_pers_p', $data)){
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
            $salary_details = $this->db->query("SELECT * FROM personel_salary_p Where personel_id = $pers_id and status = 1")->row();
            $this->db->set('status',0);
            $this->db->where('personel_id', $pers_id);
            $this->db->update('personel_salary_p');

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

            $this->db->insert('personel_salary_p', $data);
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

    public function editpicture($id, $pic)
    {

        $this->db->select('picture');
        $this->db->from('geopos_employees_p');
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();

        @unlink(FCPATH . 'userfiles/employee/'. $result['picture']);
        @unlink(FCPATH . 'userfiles/employee/thumbnail/'.$result['picture']);



        $data = array(
            'picture' => $pic
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_employees_p')) {

            $this->db->set($data);
            $this->db->where('id', $id);
            $this->db->update('geopos_users_p');
            return 1;

        }
        else
        {
            return 0;
        }


    }



    public function document_datatables($cid)

    {

        $this->document_datatables_query($cid);

        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }



    private function document_datatables_query($cid)

    {


        $this->db->select('*');

        $this->db->from('geopos_documents_pers_p');

        $this->db->where('fid',$cid);

        $this->db->where('rid',1);

        $i = 0;



        foreach ($this->doccolumn_search as $item) // loop column

        {

            $search = $this->input->post('search');

            $value = $search['value'];

            if ($value) {



                if ($i === 0) {

                    $this->db->group_start();

                    $this->db->like($item, $value);

                } else {

                    $this->db->or_like($item, $value);

                }



                if (count($this->doccolumn_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



    }



    function document_count_filtered($cid)

    {

        $this->document_datatables_query($cid);

        $query = $this->db->get();

        return $query->num_rows();

    }




    public function document_count_all($cid)

    {

        $this->document_datatables_query($cid);

        $query = $this->db->get();

        return $query->num_rows();

    }

    function adddocument($title, $filename,$cid,$baslangic_date,$bitis_date,$file_type=0,$arac_id=0)

    {   $this->aauth->applog("[Personele Dosya Eklendi ]  Dosya ID $title Personel ID ".$cid,$this->aauth->get_user()->username);

        $data = array('baslangic_date' => $baslangic_date,'file_type' => $file_type,'arac_id' => $arac_id,'bitis_date' => $bitis_date,'title' => $title, 'filename' => $filename, 'cdate' => date('Y-m-d'),'cid'=>$this->aauth->get_user()->id,'fid'=>$cid,'rid'=>1);

        return $this->db->insert('geopos_documents_pers_p', $data);



    }


}