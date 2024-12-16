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





class Salary_model extends CI_Model
{
    var $table_news = 'new_bordro ';

    var $column_order = array('id','code', 'ay', 'yil', 'aauth','desc');

    var $column_search = array('code', 'ay', 'yil', 'created_at','desc','geopos_employees.name');
    var $column_search_bordro = array('new_bordro.code', 'new_bordro.ay', 'new_bordro.yil', 'new_bordro.created_at','new_bordro.desc','geopos_employees.name','geopos_projects.name');
    var $column_search_history = array('desc', 'created_at', 'geopos_employees.name');

    var $order = array('id' => 'DESC');


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Demirbas_model', 'dmodel');
        $this->load->model('communication_model');

    }

    public function get_datatables_details(){
        $this->_get_ajax_list_details();
        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    public function _get_ajax_list_details(){
        $user =$this->aauth->get_user()->id;
        $role_id = $this->aauth->get_user()->roleid;
        $santiye_id = personel_salary_details_get($user)->proje_id;

        $this->db->select('new_bordro.*,geopos_employees.name,geopos_projects.name');
        $this->db->from('new_bordro');
        $this->db->join('geopos_employees','new_bordro.aauth_id=geopos_employees.id');
        $this->db->join('geopos_projects','new_bordro.proje_id=geopos_projects.id');
        $this->db->where('new_bordro.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57

        if (!$this->aauth->premission(95)->read) {
            // Eğer kullanıcı tüm personelleri görme yetkisine sahip değilse
            if (in_array($role_id, personel_yetkileri())) {
                // Kullanıcının şantiyesine göre filtrele
                $this->db->where('new_bordro.proje_id', $santiye_id);
            } else {
                // Yetkisi olmayan kullanıcılar için boş sonuç
                $this->db->where('1', 0);
            }
        }

        $i = 0;
        foreach ($this->column_search_bordro as $item) // loop column
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

                if (count($this->column_search_bordro) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`new_bordro`.`id` DESC');
    }
    public function count_filtered()
    {
        $this->_get_ajax_list_details();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all()
    {
        $this->_get_ajax_list_details();
        return $this->db->count_all_results();
    }



    public function get_datatables_details_onay(){
        $this->_get_ajax_list_details_onay();
        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    public function _get_ajax_list_details_onay(){
        $this->db->select('new_bordro.*');
        $this->db->from('salary_onay_new');
        $this->db->join('new_bordro_item','salary_onay_new.bordro_item_id = new_bordro_item.id');
        $this->db->join('new_bordro','new_bordro_item.bordro_id = new_bordro.id');
        $this->db->where('new_bordro_item.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        $this->db->where('salary_onay_new.staff', 1);
        $this->db->where('salary_onay_new.user_id', $this->aauth->get_user()->id);
        $this->db->where('new_bordro.status!=', 3);
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
        $this->db->order_by('`new_bordro`.`id` DESC');
        $this->db->group_by('new_bordro_item.bordro_id');
    }
    public function count_filtered_onay()
    {
        $this->_get_ajax_list_details_onay();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_onay()
    {
        $this->_get_ajax_list_details_onay();
        return $this->db->count_all_results();
    }



    public function get_datatables_details_muhasebe(){
        $this->_get_ajax_list_details_muhasebe();
        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    public function _get_ajax_list_details_muhasebe(){
        $this->db->select('new_bordro.*');
        $this->db->from('new_bordro_item');
        $this->db->join('new_bordro','new_bordro_item.bordro_id = new_bordro.id');
        //$this->db->where('new_bordro.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        $this->db->where('new_bordro_item.status', 7);
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
        $this->db->order_by('`new_bordro`.`id` DESC');
        $this->db->group_by('new_bordro_item.bordro_id');
    }
    public function count_filtered_muhasebe()
    {
        $this->_get_ajax_list_details_muhasebe();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_muhasebe()
    {
        $this->_get_ajax_list_details_muhasebe();
        return $this->db->count_all_results();
    }






    public function create_save()
    {
        $code = numaric(35);
        $bordro_yili = $this->input->post('bordro_yili');
        $bordro_ayi = $this->input->post('bordro_ayi');
        $proje_id = $this->input->post('proje_id');
        $pers_id = $this->input->post('pers_id');
        $desc = $this->input->post('desc');

        // Bordro kontrol
        $bordro_exists = $this->db->query(
            "SELECT * FROM new_bordro WHERE ay = ? AND yil = ? AND proje_id = ? AND status != 3",
            [$bordro_ayi, $bordro_yili, $proje_id]
        );

        if ($bordro_exists->num_rows() > 0) {
            return [
                'status' => 0,
                'messages' => 'Bordro oluşturulamadı. Aynı bilgilere ait bordro mevcut. Mevcut bordroyu iptal edip tekrar deneyiniz.',
            ];
        }

        // Bordro oluştur
        $data = [
            'code' => $code,
            'ay' => $bordro_ayi,
            'yil' => $bordro_yili,
            'aauth_id' => $this->aauth->get_user()->id,
            'desc' => $desc,
            'proje_id' => $proje_id,
            'loc' => $this->session->userdata('set_firma_id'),
        ];

        if (!$this->db->insert('new_bordro', $data)) {
            return [
                'status' => 0,
                'messages' => 'Bordro oluşturulamadı.',
            ];
        }

        $last_id = $this->db->insert_id();
        numaric_update(35);

        // Personel belirleme
        $data_pers = [];
        if ($pers_id[0] == 0) {
            $all_personel = $this->db->query(
                "SELECT geopos_employees.id FROM geopos_employees
            INNER JOIN personel_salary ON geopos_employees.id = personel_salary.personel_id
            INNER JOIN geopos_users ON geopos_employees.id = geopos_users.id
            WHERE geopos_users.banned = 0 AND personel_salary.status = 1 AND personel_salary.proje_id = ?",
                [$proje_id]
            );

            if ($all_personel->num_rows() > 0) {
                foreach ($all_personel->result() as $items) {
                    $data_pers[] = $items->id;
                }
            }
        } else {
            $data_pers = $pers_id;
        }

        // Personel bordro kayıt
        if (empty($data_pers)) {
            return [
                'status' => 0,
                'messages' => 'Personel bulunamadı.',
            ];
        }

        $sayi = 0;
        foreach ($data_pers as $id) {
            $date_items = [
                'bordro_id' => $last_id,
                'bordro_ayi' => $bordro_ayi,
                'bordro_yili' => $bordro_yili,
                'pers_id' => $id,
                'proje_id' => $proje_id,
                'loc' => $this->session->userdata('set_firma_id'),
            ];

            if ($this->db->insert('new_bordro_item', $date_items)) {
                $sayi++;
            }
        }

        if ($sayi > 0) {
            return [
                'status' => 1,
                'id' => $last_id,
                'messages' => 'Başarıyla kayıt edildi. ' . $sayi . ' adet personel bordrosu hazırlandı.',
            ];
        }

        return [
            'status' => 0,
            'messages' => 'Personel kayıt edilemedi.',
        ];
    }


    public function details($id){
        $this->db->select('*');
        $this->db->from('new_bordro');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    public function details_items($id){
        $this->db->select('*');
        $this->db->from('new_bordro_item');
        $this->db->where('bordro_id',$id);
        $this->db->where('status!=',3);
        $query = $this->db->get();
        return $query->result();
    }
    public function details_items_row($id){
        $this->db->select('*');
        $this->db->from('new_bordro_item');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    public function all_details_items_ay_yil($ay,$yil){
        $this->db->select('*');
        $this->db->from('new_bordro_item');
        $this->db->where('bordro_yili',$yil);
        $this->db->where('bordro_ayi',$ay);
        $this->db->where('status!=',3);
        $query = $this->db->get();
        return $query->result();
    }

    public function status_change() {
        $id =  $this->input->post('bordro_id');
        $status_id =  $this->input->post('status');
        $desc =  $this->input->post('desc');
        if($this->aauth->get_user()->id==21){
            $this->db->set('status', $status_id);
            $this->db->set('iptal_desc', $desc);
            $this->db->where('id', $id);
            if( $this->db->update('new_bordro')){

                $this->db->set('status', $status_id);
                $this->db->where('bordro_id', $id);
                $this->db->update('new_bordro_item');

                $this->talep_history($id,$this->aauth->get_user()->id, ' İptal Edildi',1);


                return [
                    'status'=>1,
                    'messages'=>'Başarıyla İptal Edildi',
                ];
            }
            else {
                return [
                    'status'=>0,
                    'messages'=>'Hata Aldınız',
                ];
            }
        }
        else {
            $this->talep_history($id,$this->aauth->get_user()->id, ' İptal Etmeye Çalıştı',1);

            return [
                'status'=>0,
                'messages'=>'YEtkiniz Yok',
            ];
        }


    }


    public function get_datatables_details_items(){
        $this->_get_ajax_list_details_items();
        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    public function _get_ajax_list_details_items(){

        $user =$this->aauth->get_user()->id;
        $role_id = $this->aauth->get_user()->roleid;
        $santiye_id = personel_salary_details_get($user)->proje_id;

        $list_tipi = $this->input->post('tip');
        $this->db->select('new_bordro_item.*,geopos_employees.name as pers_name');
        $this->db->from('new_bordro_item');
        $this->db->join('geopos_employees','new_bordro_item.pers_id=geopos_employees.id');
        if($list_tipi=='onay'){
            $this->db->join('salary_onay_new','new_bordro_item.id=salary_onay_new.bordro_item_id');
        }
        if($this->input->post('bordro_id')){
            $this->db->where('new_bordro_item.bordro_id =', $this->input->post('bordro_id')); //2019-11-23 14:28:57
        }
        if($this->input->post('m')){
            $this->db->where('new_bordro_item.bordro_ayi =', $this->input->post('m')); //2019-11-23 14:28:57
        }
        if($this->input->post('y')){
            $this->db->where('new_bordro_item.bordro_yili =', $this->input->post('y')); //2019-11-23 14:28:57
        }
        if($this->input->post('proje_id')){
            $this->db->where('new_bordro_item.proje_id =', $this->input->post('proje_id')); //2019-11-23 14:28:57
        }

        if (!$this->aauth->premission(95)->read) {
            // Eğer kullanıcı tüm personelleri görme yetkisine sahip değilse
            if (in_array($role_id, personel_yetkileri())) {
                // Kullanıcının şantiyesine göre filtrele
                $this->db->where('new_bordro_item.proje_id', $santiye_id);
            } else {
                // Yetkisi olmayan kullanıcılar için boş sonuç
                $this->db->where('1', 0);
            }
        }


        if($list_tipi=='onay'){
            $this->db->where('salary_onay_new.user_id =', $this->aauth->get_user()->id);
            $this->db->where('salary_onay_new.staff =', 1);
        }
        if($list_tipi=='muhasebe'){
            $this->db->where('new_bordro_item.status =',7);
        }

        if($this->session->userdata('set_firma_id')){
            $this->db->where('new_bordro_item.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        $this->db->where('new_bordro_item.status !=',3);
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
        $this->db->order_by('`new_bordro_item`.`id` DESC');
    }
    public function count_filtered_items()
    {
        $this->_get_ajax_list_details_items();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_items()
    {
        $this->_get_ajax_list_details_items();
        return $this->db->count_all_results();
    }
    public function create_onay(){
        $result = $this->input->post('bordro_details');
        $bordro_id = $this->input->post('bordro_id');

        $say = 0;
        if($result){
            foreach ($result as $key=>$items){
                $data_update=
                    [
                        'nakit_borc_bakiye'=>$items['nakit_borc_bakiye'],
                        'nakit_alacak_bakiye'=>$items['nakit_alacak_bakiye'],
                        'banka_borc_bakiye'=>$items['banka_borc_bakiye'],
                        'banka_alacak_bakiye'=>$items['banka_alacak_bakiye'],
                        'prim'=>$items['prim'],
                        'ceza'=>$items['ceza'],
                        'aylik_banka_hakedis'=>$items['aylik_banka_hakedis'],
                        'aylik_nakit_hakedis'=>$items['aylik_nakit_hakedis'],
                        'banka_avans'=>$items['banka_avans'],
                        'nakit_avans'=>$items['nakit_avans'],
                        'bankadan_odenilecek'=>$items['bankadan_odenilecek'],
                        'maas_tipi'=>$items['maas_tipi'],
                        'hesaplanan'=>$items['hesaplanan'],
                        'mezuniyet_tutar'=>$items['mezuniyet_tutar'],
                        'cemi'=>$items['cemi'],
                        'dsmf_isveren'=>$items['dsmf_isveren'],
                        'issizlik_isveren'=>$items['issizlik_isveren'],
                        'icbari_sigorta_isveren'=>$items['icbari_sigorta_isveren'],
                        'dsmf_isci'=>$items['dsmf_isci'],
                        'issizlik_isci'=>$items['issizlik_isci'],
                        'icbari_sigorta_isci'=>$items['icbari_sigorta_isci'],
                        'gelir_vergisi'=>$items['gelir_vergisi'],
                        'odenilecek_meblaq'=>$items['odenilecek_meblaq'],
                        'dusulen_gune_gore_meblaq'=>$items['dusulen_gune_gore_meblaq'],
                        'salary'=>$items['toplam_maas'],
                        'brut_maas'=>$items['brut_maas'],
                        'net_maas'=>$items['net_maas'],
                        'status'=>2, // Onaya Sunuldu
                    ];
                $this->db->set($data_update);
                $this->db->where('id', $items['bordro_item_id']);
                if( $this->db->update('new_bordro_item')){
                    //Onay İnsert

                    $bordro_id_item_id=$items['bordro_item_id'];
                    $proje_id = $this->details($bordro_id)->proje_id;
                    $users_ = onay_sort(9,$proje_id);
                    if($users_){
                        foreach ($users_ as $items_){
                            $staff=0;
                            if($items_['sort']==1){
                                $staff=1;
                            }
                            $data_onay = array(
                                'bordro_item_id' => $bordro_id_item_id,
                                'type' => 1,
                                'staff' => $staff,
                                'sort' => $items_['sort'],
                                'user_id' => $items_['user_id'],
                            );
                            $this->db->insert('salary_onay_new', $data_onay);
                        }

                        $say++;

                    }

                    //Onay İnsert
                }



            }

            if($say){
                $this->talep_history($bordro_id,$this->aauth->get_user()->id,$say. ' Personelin Onay Bildirim Başlatıldı',2);
                $this->db->trans_complete();
                return [
                    'status'=>1,
                    'messages'=>$say. ' Personelin Onay Bildirim Başlatıldı',
                ];
            }
            else {
                $this->db->trans_rollback();
                return [
                    'status'=>0,
                    'messages'=>'Kayıt Oluşmadı'
                ];
            }
        }

    }

    public function bordro_item_delete(){
        $result = $this->input->post('bordro_details');
        $bordro_id = $this->input->post('bordro_id');

        $say = 0;
        if($result){
            foreach ($result as $key=>$items){
                if( $this->db->delete('new_bordro_item', array('id' => $items['bordro_item_id']))){
                    $say++;
                }
            }
            if($say){
                $this->talep_history($bordro_id,$this->aauth->get_user()->id,$say. ' Personel Bordrodan Kaldırıldı',2);
                $this->db->trans_complete();
                return [
                    'status'=>1,
                    'messages'=>$say. ' Personel Bordrodan Kaldırıldı',
                ];
            }
            else {
                $this->db->trans_rollback();
                return [
                    'status'=>0,
                    'messages'=>'Hata Aldınız'
                ];
            }
        }

    }


    public function bordro_item_create(){
        $pers_id = $this->input->post('pers_id');
        $bordro_id = $this->input->post('bordro_id');

        $say = 0;
        if($pers_id){
           $kontrol = $this->db->query("SELECT * FROM new_bordro_item WHERE pers_id = $pers_id and bordro_id=$bordro_id and status!=3");
            if(!$kontrol->num_rows()){
                //İnsert
                $details = $this->details($bordro_id);
                $date_items =
                    [
                        'bordro_id'=>$bordro_id,
                        'bordro_ayi'=>$details->ay,
                        'bordro_yili'=>$details->yil,
                        'pers_id'=>$pers_id,
                        'proje_id'=>$details->proje_id,
                        'loc'=>$this->session->userdata('set_firma_id'),

                    ];
                if($this->db->insert('new_bordro_item', $date_items)){
                    $this->talep_history($bordro_id,$this->aauth->get_user()->id,'Personel Eklendi',2);
                    $this->db->trans_complete();
                    return [
                        'status'=>1,
                        'messages'=>'Personel Eklendi',
                    ];
                }
                else {
                    $this->db->trans_rollback();
                    return [
                        'status'=>0,
                        'messages'=>'Hata Aldınız'
                    ];
                }
                //İnsert

            }
            else {
                $this->db->trans_rollback();
                return [
                    'status'=>0,
                    'messages'=>'Personel Daha Önce Eklenmiştir'
                ];
            }
        }

    }

    public function talep_history($id,$user_id,$desc,$type=1){
        $data_step = array(
            'bordro_item_id' => $id,
            'user_id' => $user_id,
            'desc' => $desc,
            'type' => $type,
        );
        $this->db->insert('salary_history', $data_step);

    }

    public function create_onay_new(){
        $result = $this->input->post('bordro_details');
        $bordro_id = $this->input->post('bordro_id');
        $status_onay = $this->input->post('status_onay');
        $tip = $this->input->post('tip');
        $desc = $this->input->post('desc');
        $messages='';
        $say = 0;
        if($result){
            foreach ($result as $key=>$items){
                $bordro_item_id = $items['bordro_item_id'];
                $item_details_bordro = $this->db->query("SELECT * FROM new_bordro_item Where id=$bordro_item_id")->row();
                if($tip=='muhasebe'){
                    $item_details = $this->db->query("SELECT * FROM new_bordro_item Where id=$bordro_item_id")->row();
                    if($item_details->banka_hakedis_durumu == 0 || $item_details->nakit_hakedis_durumu==0){
                        $this->db->trans_rollback();
                        return [
                            'status'=>0,
                            'messages'=>'Hakedis Yapınız'
                        ];
                    }
                }

                $data_update=
                    [
                        'prim'=>$items['prim'],
                        'ceza'=>$items['ceza'],
                        'aylik_banka_hakedis'=>$items['aylik_banka_hakedis'],
                        'aylik_nakit_hakedis'=>$items['aylik_nakit_hakedis'],
                        'banka_avans'=>$items['banka_avans'],
                        'nakit_avans'=>$items['nakit_avans'],
                        'bankadan_odenilecek'=>$items['bankadan_odenilecek'],
                        'maas_tipi'=>$items['maas_tipi'],
                        'hesaplanan'=>$items['hesaplanan'],
                        'mezuniyet_tutar'=>$items['mezuniyet_tutar'],
                        'cemi'=>$items['cemi'],
                        'dsmf_isveren'=>$items['dsmf_isveren'],
                        'issizlik_isveren'=>$items['issizlik_isveren'],
                        'icbari_sigorta_isveren'=>$items['icbari_sigorta_isveren'],
                        'dsmf_isci'=>$items['dsmf_isci'],
                        'issizlik_isci'=>$items['issizlik_isci'],
                        'icbari_sigorta_isci'=>$items['icbari_sigorta_isci'],
                        'gelir_vergisi'=>$items['gelir_vergisi'],
                        'odenilecek_meblaq'=>$items['odenilecek_meblaq'],
                        'salary'=>$items['toplam_maas'],
                        'brut_maas'=>$items['brut_maas'],
                        'net_maas'=>$items['net_maas'],
                        'nakit_odenilecek'=>$items['nakit_odenilecek'],
                        'status'=>2, // Onaya Sunuldu
                    ];
                $this->db->set($data_update);
                $this->db->where('id', $items['bordro_item_id']);
                if( $this->db->update('new_bordro_item')){
                    $say++;

                    $item_id = $items['bordro_item_id'];
                    //ilerleme
                    $new_id=0;
                    $new_user_id=0;
                    $sort=0;
                    $new_id_control = $this->db->query("SELECT * FROM `salary_onay_new` Where type=1 and bordro_item_id=$item_id and staff=0 and status is Null ORDER BY `salary_onay_new`.`id` ASC LIMIT 1");
                        if($new_id_control->num_rows()){
                            $new_id = $new_id_control->row()->id;
                            $new_user_id = $new_id_control->row()->user_id;
                            $sort = $new_id_control->row()->sort;
                        }

                        if($status_onay==6){
                            $messages='Personellere Onay Verildi';
                            $data = array(
                                'status' => 1,
                                'staff' => 0,
                            );

                            $this->db->where('user_id',$this->aauth->get_user()->id);
                            $this->db->where('staff',1);
                            $this->db->where('type',1);
                            $this->db->set($data);
                            $this->db->where('bordro_item_id', $item_id);
                            if ($this->db->update('salary_onay_new', $data)) {
                                $this->talep_history($bordro_id, $this->aauth->get_user()->id, 'Onay Verildi. ' . $desc);
                                if($new_id){

                                    // bildirim maili at
//                                    $mesaj=$details->code.' Numaralı Malzeme Talep Formu Onayınızı Beklemektedir';
//                                    $this->send_mail($new_user_id,'Malzeme Talep Onayı',$mesaj);
//                                    // bildirim maili at
//                                    $user_phone = personel_details_full($new_user_id)['phone'];
//                                    $this->mesaj_gonder($user_phone,$details->code.' Malzeme Talebi Onayınızı Beklemektedir.');
                                    // Bir Sonraki Onay
                                    $data_new=array(
                                        'staff'=>1,
                                    );
                                    $this->db->where('id',$new_id);
                                    $this->db->set($data_new);
                                    $this->db->update('salary_onay_new', $data_new);
                                    // Bir Sonraki Onay
                                }
                                else
                                { //onaylar bitti
                                    $data_Form=array(
                                        'status'=>7,
                                    );
                                    //Ödeme Bekliyor
                                    $this->db->set($data_Form);
                                    $this->db->where('id', $item_id);
                                    $this->db->update('new_bordro_item', $data_Form);
                                    //Kontrol Bekliyor
                                }
                            }
                        }
                        elseif($status_onay==5) {

                            $messages=' Tekrar Bordro İstendi';
                            //onayları sil

                             $this->db->delete('salary_onay_new', array('bordro_item_id' => $item_id));
                            $data_new=array(
                                'status'=>5,
                            );
                            $this->db->where('id',$item_id);
                            $this->db->set($data_new);
                            $this->db->update('new_bordro_item', $data_new);


                            $personel_name = personel_details($item_details_bordro->pers_id);
                            $user_name = personel_details($this->aauth->get_user()->id);
                            $proje_text=$personel_name.' Personeli İçin '.$user_name.' Adlı Yetkili Bordroyu Yenilemenizi Talep Etmiştir.'.'Açıklama : '.$desc;
                            $subject = 'Bordro Yenileme!';
                            $message = 'Sayın Yetkili ' . $proje_text;


                            $pers_id=1007;
                            $email = personel_detailsa($pers_id)['email'];
                            $recipients = array($email);
                            $this->onay_mailleri($messages, $message, $recipients, 'avans_talep_onay_maili');
                            //onayları sil
                        }
                        elseif($status_onay==4) {
                            $messages=' Bordro Pasifleştirildi';

                            $data_new=array(
                                'status'=>4,
                            );
                            $this->db->where('id',$item_id);
                            $this->db->set($data_new);
                            $this->db->update('new_bordro_item', $data_new);
                            //onayları sil
                        }



                    //ilerleme
                }
            }

            if($say){
                $this->db->trans_complete();
                return [
                    'status'=>1,
                    'messages'=>$say. ' '.$messages,
                ];
            }
            else {
                $this->db->trans_rollback();
                return [
                    'status'=>0,
                    'messages'=>'Hata Aldınız'
                ];
            }
        }

    }


    public function create_all_islem(){
        $result = $this->input->post('bordro_details');
        $bordro_id = $this->input->post('bordro_id');

        $say = 0;
        if($result){
            foreach ($result as $key=>$items){
                $data_update=
                    [
                        'prim'=>$items['prim'],
                        'ceza'=>$items['ceza'],
                        'aylik_banka_hakedis'=>$items['aylik_banka_hakedis'],
                        'aylik_nakit_hakedis'=>$items['aylik_nakit_hakedis'],
                        'banka_avans'=>$items['banka_avans'],
                        'nakit_avans'=>$items['nakit_avans'],
                        'bankadan_odenilecek'=>$items['bankadan_odenilecek'],
                        'maas_tipi'=>$items['maas_tipi'],
                        'hesaplanan'=>$items['hesaplanan'],
                        'mezuniyet_tutar'=>$items['mezuniyet_tutar'],
                        'cemi'=>$items['cemi'],
                        'dsmf_isveren'=>$items['dsmf_isveren'],
                        'issizlik_isveren'=>$items['issizlik_isveren'],
                        'icbari_sigorta_isveren'=>$items['icbari_sigorta_isveren'],
                        'dsmf_isci'=>$items['dsmf_isci'],
                        'issizlik_isci'=>$items['issizlik_isci'],
                        'icbari_sigorta_isci'=>$items['icbari_sigorta_isci'],
                        'gelir_vergisi'=>$items['gelir_vergisi'],
                        'odenilecek_meblaq'=>$items['odenilecek_meblaq'],
                        'nakit_odenilecek'=>$items['nakit_odenilecek'],
                        'salary'=>$items['toplam_maas'],
                        'brut_maas'=>$items['brut_maas'],
                        'net_maas'=>$items['net_maas'],
                    ];
                $this->db->set($data_update);
                $this->db->where('id', $items['bordro_item_id']);
                if( $this->db->update('new_bordro_item')){
                    $say++;
                }
            }

            if($say){
                $this->db->trans_complete();
                $this->talep_history($bordro_id, $this->aauth->get_user()->id, $say.' Adet Veriler Güncellendi ');
                return [
                    'status'=>1,
                    'messages'=>$say. ' İşlemler Güncellendi',
                ];
            }
            else {
                $this->db->trans_rollback();
                return [
                    'status'=>0,
                    'messages'=>'Hata Aldınız'
                ];
            }
        }

    }
    public function create_hakedis(){
        $result = $this->input->post('bordro_details');
        $bordro_id = $this->input->post('bordro_id');
        $method = $this->input->post('status_onay'); //1 nakit 3 Banka
        $sny = 0;
        $say_=0;
        if($result) {
            foreach ($result as $key => $items) {
                $item_id = $items['bordro_item_id'];
                $prd = $this->db->query("SELECT * FROM new_bordro_item Where id = $item_id")->row();

                $m = $prd->bordro_ayi;
                $y = $prd->bordro_yili;
                $total_ay_sayisi_ = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
                $sny++;
                $d = date('Y-'.$m.'-'.$total_ay_sayisi_.' H:i:s',strtotime('+'.$sny.' minutes'));

                if($method==1){
                    if (!$prd->nakit_hakedis_durumu) {
                        $data_nakit = array(
                            'invoicedate' => $d,
                            'invoiceduedate' => $d,
                            'total' =>$items['aylik_nakit_hakedis'],
                            'payer' =>personel_details($prd->pers_id),
                            'notes' => 'Nakit Hakediş',
                            'csd'=>$prd->pers_id,
                            'eid'=>$this->aauth->get_user()->id,
                            'invoice_type_id'=>13,
                            'cari_pers_type'=>2,
                            'method'=>1,
                            'invoice_type_desc'=>'Maaş Alacağı'
                        );
                        $this->db->insert('geopos_invoices', $data_nakit);
                        $this->db->query("UPDATE new_bordro_item set nakit_hakedis_durumu = 1  WHERE id =$item_id");


                        if($prd->bankadan_odenilecek == 0){
                            $this->db->query("UPDATE new_bordro_item set banka_hakedis_durumu=1  WHERE id =$item_id");
                        }

                        $this->talep_history($bordro_id, $this->aauth->get_user()->id, personel_details($prd->pers_id).' Personel İçin Nakit Hakediş Verildi. ');


                        $say_++;
                    }
                }
                else {
                    if (!$prd->banka_hakedis_durumu) {

                        $banka_hak=$items['aylik_banka_hakedis'];
                        if($prd->dusulen_gun){

                            $data_nakit = array(
                                'invoicedate' => $d,
                                'invoiceduedate' => $d,
                                'total' =>$prd->dusulen_gune_gore_meblaq,
                                'payer' =>personel_details($prd->pers_id),
                                'notes' => 'Nakit Hakediş - Borca İstinaden',
                                'csd'=>$prd->pers_id,
                                'eid'=>$this->aauth->get_user()->id,
                                'invoice_type_id'=>13,
                                'cari_pers_type'=>2,
                                'method'=>1,
                                'invoice_type_desc'=>'Maaş Alacağı'
                            );
                            $this->db->insert('geopos_invoices', $data_nakit);
                            $banka_hak=$banka_hak-$prd->dusulen_gune_gore_meblaq;
                        }


                        $data_banka = array(
                            'invoicedate' => $d,
                            'invoiceduedate' => $d,
                            'total' =>$banka_hak,
                            'payer' =>personel_details($prd->pers_id),
                            'notes' => 'Banka Hakediş',
                            'csd'=>$prd->pers_id,
                            'eid'=>$this->aauth->get_user()->id,
                            'invoice_type_id'=>31,
                            'cari_pers_type'=>2,
                            'method'=>3,
                            'invoice_type_desc'=>'Maaş Alacağı Banka'
                        );
                        $this->db->insert('geopos_invoices', $data_banka);

                        // Gidere İşleme
                        $result = $this->dmodel->gider_create_form($item_id,8);

                        // Gidere İşleme

                        $this->db->query("UPDATE new_bordro_item set banka_hakedis_durumu = 1  WHERE id =$item_id");
                        if(intval($prd->aylik_nakit_hakedis) == 0){
                            $this->db->query("UPDATE new_bordro_item set nakit_hakedis_durumu=1  WHERE id =$item_id");
                        }



                        $this->talep_history($bordro_id, $this->aauth->get_user()->id, personel_details($prd->pers_id).' Personel İçin Banka Hakediş Verildi. ');
                        $say_++;
                    }
                }

            }

            if($say_){
                return [
                    'status'=>1,
                    'messages'=>$say_. ' Adet Personele Hakediş Verildi',
                ];
            }
            else {
                return [
                    'status'=>0,
                    'messages'=>'Hata Aldınız'
                ];
            }
        }

    }

    public function create_pay_set(){
        $result = $this->input->post('bordro_details');
        $bordro_id = $this->input->post('bordro_id');
        $pay_set_id = $this->input->post('pay_set_id');
        $method = $this->input->post('method');
        $nakit_durum_insert=0;
        $banka_durum_insert=0;
        $say=0;
        if($result) {
            foreach ($result as $key => $items) {
                    $item_id = $items['bordro_item_id'];
                    $prd = $this->db->query("SELECT * FROM new_bordro_item Where id = $item_id")->row();
                    if($method==1){
                        if($prd->nakit_odenilecek > 0){
                            $nakit_durum_insert = 1;
                        }
                        else {
                            $nakit_durum_insert=0;
                        }

                        $this->db->query("UPDATE new_bordro_item set nakit_odeme_emri=1  WHERE id =$item_id");
                        if($prd->bankadan_odenilecek == 0){
                            $this->db->query("UPDATE new_bordro_item set banka_odeme_emri=1  WHERE id =$item_id");
                        }

                    }
                    elseif($method==3){
                        if($prd->bankadan_odenilecek > 0){
                            $banka_durum_insert=1;
                        }
                        else {
                            $banka_durum_insert=0;
                        }

                        $this->db->query("UPDATE new_bordro_item set banka_odeme_emri=1  WHERE id =$item_id");

                        if($prd->nakit_odenilecek == 0){
                            $this->db->query("UPDATE new_bordro_item set nakit_odeme_emri=1  WHERE id =$item_id");
                        }
                    }


                    $data_nakit = array(
                        'bordro_id' => $bordro_id,
                        'bordro_item_id' => $item_id,
                        'pay_set_id' =>$pay_set_id,
                        'nakit_durum' =>$nakit_durum_insert,
                        'banka_durum' => $banka_durum_insert,
                        'aauth_id'=>$this->aauth->get_user()->id,
                    );
                    if($this->db->insert('new_bordro_pay_set', $data_nakit))
                    {
                        // Ödeme Emri Verildi

                        $this->talep_history($bordro_id, $this->aauth->get_user()->id, personel_details($prd->pers_id).' Personel İçin Ödeme Emri '. personel_details($pay_set_id).' Adlı Personele Verildi. ');

                        $prd_new = $this->db->query("SELECT * FROM new_bordro_item Where id = $item_id")->row();
                        if($prd_new->banka_odeme_emri==1 && $prd_new->nakit_odeme_emri==1){
                            $this->db->query("UPDATE new_bordro_item set status=8  WHERE id =$item_id");
                        }
                        $say++;
                    }



            }
            if($say){
                return [
                    'status'=>1,
                    'messages'=>$say. ' Adet Personel İçin Ödeme Emri Verildi',
                ];
            }
            else {
                return [
                    'status'=>0,
                    'messages'=>'İşlemler Yapılmadı'
                ];
            }
        }
    }

    public function create_pay(){
        $result = $this->input->post('bordro_details');
        $method = $this->input->post('method');
        $acid = $this->input->post('acid');
        $sny=0;
        $int=0;
        $nakit_durum_say=0;
        $banka_durum_say=0;
        if($result) {
            foreach ($result as $key => $items) {
                $bordro_item_id = $items['bordro_item_id'];
                $bordro_pay_set_id = $items['bordro_pay_set_id'];
                $nakit_durum = $items['nakit_durum'];
                $banka_durum = $items['banka_durum'];
                $item_details = $this->db->query("SELECT * FROM new_bordro_item Where id=$bordro_item_id")->row();

                $m = $item_details->bordro_ayi;
                $y = $item_details->bordro_yili;
                $total_ay_sayisi_ = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
                $sny++;
                $d = date('Y-m-d H:i:s',strtotime('+'.$sny.' minutes'));
                if($method==1) // Nakit
                {
                    if($nakit_durum){
                        $data = [
                            'total' => $item_details->nakit_odenilecek,
                            'invoicedate' => $d,
                            'debit' => $item_details->nakit_odenilecek,
                            'csd' => $item_details->pers_id,
                            'eid' => $this->aauth->get_user()->id,
                            'invoice_type_id' => 12,
                            'invoice_type_desc' => 'Maaş Ödemesi',
                            'cari_pers_type' => 2,
                            'payer' => personel_details($item_details->pers_id),
                            'acid' => $acid,
                            'method' => 1,
                            'account' => account_details($acid)->holder,
                            'maas_ay' => $item_details->bordro_ayi,
                            'maas_yil' => $item_details->bordro_yili,
                        ];
                        if($this->db->insert('geopos_invoices', $data)){
                            $last_id = $this->db->insert_id();
                            $data_Form=array(
                                'transaction_id'=>$last_id,
                            );
                            $this->db->set($data_Form);
                            $this->db->where('id', $bordro_pay_set_id);
                            $this->db->update('new_bordro_pay_set', $data_Form);
                            $int++;
                            $bordro_id = $item_details->bordro_id;


                            $data_Form_item=array(
                                'nakit_odeme_durumu'=>1,
                            );
                            $this->db->set($data_Form_item);
                            $this->db->where('id', $bordro_item_id);
                            $this->db->update('new_bordro_item', $data_Form_item);

                            $this->talep_history($bordro_id, $this->aauth->get_user()->id, personel_details($item_details->pers_id).' Personel Nakit Banka Ödeme Yapıldı ');

                        }
                        if($item_details->bankadan_odenilecek == 0){
                            $this->db->query("UPDATE new_bordro_item set banka_odeme_durumu=1  WHERE id =$bordro_item_id");
                        }
                    }
                    else {
                        $nakit_durum_say++;
                    }


                }
                elseif($method==3) // Banka
                {
                    if($banka_durum){
                        $data = [
                            'total' => $item_details->bankadan_odenilecek,
                            'invoicedate' => $d,
                            'debit' => $item_details->bankadan_odenilecek,
                            'csd' => $item_details->pers_id,
                            'eid' => $this->aauth->get_user()->id,
                            'invoice_type_id' => 49,
                            'method' => 3,
                            'cari_pers_type' => 2,
                            'invoice_type_desc' => 'Banka Maaş Ödemesi',
                            'payer' => personel_details($item_details->pers_id),
                            'acid' => $acid,
                            'account' => account_details($acid)->holder,
                            'maas_ay' => $item_details->bordro_ayi,
                            'maas_yil' => $item_details->bordro_yili,
                        ];
                        if($this->db->insert('geopos_invoices', $data)){
                            $last_id = $this->db->insert_id();
                            $data_Form=array(
                                'transaction_id'=>$last_id,
                            );
                            $this->db->set($data_Form);
                            $this->db->where('id', $bordro_pay_set_id);
                            $this->db->update('new_bordro_pay_set', $data_Form);
                            $int++;

                            $bordro_id = $item_details->bordro_id;

                            if($item_details->nakit_odenilecek == 0){
                                $this->db->query("UPDATE new_bordro_item set nakit_odeme_durumu=1  WHERE id =$bordro_item_id");
                            }

                            $data_Form_item=array(
                                'banka_odeme_durumu'=>1,
                            );
                            $this->db->set($data_Form_item);
                            $this->db->where('id', $bordro_item_id);
                            $this->db->update('new_bordro_item', $data_Form_item);

                            $this->talep_history($bordro_id, $this->aauth->get_user()->id, personel_details($item_details->pers_id).' Personel İçin Banka Ödeme Yapıldı ');


                        }
                    }
                    else {
                        $banka_durum_say++;
                    }

                }

                $prd_new = $this->db->query("SELECT * FROM new_bordro_item Where id = $bordro_item_id")->row();
                if($prd_new->banka_odeme_durumu==1 && $prd_new->nakit_odeme_durumu==1){
                    $this->db->query("UPDATE new_bordro_item set status=4  WHERE id =$bordro_item_id");
                }
            }

            if($int){
           


                return [
                    'status'=>1,
                    'messages'=>$int. ' Adet Personel İçin Ödeme Yapıldı',
                ];
            }
            else {
                if($nakit_durum_say){
                    return [
                        'status'=>0,
                        'messages'=>$nakit_durum_say.' Adet Personelin Nakit Ödemesi Yoktur.'
                    ];
                }
                if($banka_durum_say){
                    return [
                        'status'=>0,
                        'messages'=>$banka_durum_say.' Adet Personelin Banka Ödemesi Yoktur.'
                    ];
                }
                return [
                    'status'=>0,
                    'messages'=>'İşlemler Yapılmadı'
                ];
            }
        }
    }


    public function ajax_list_odenis(){
        $this->_ajax_list_odenis();
        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    public function _ajax_list_odenis(){

        $this->db->select('
        IF(new_bordro_pay_set.banka_durum=1,new_bordro_item.bankadan_odenilecek,0) as bankadan_odenilecek,
        IF(new_bordro_pay_set.nakit_durum=1,new_bordro_item.nakit_odenilecek,0) as nakit_odenilecek,
        new_bordro_pay_set.banka_durum,
        new_bordro_pay_set.nakit_durum,
        new_bordro_pay_set.id,
        new_bordro_item.id as item_id,
        ,geopos_employees.name as pers_name,new_bordro_item.bordro_yili,new_bordro_item.bordro_ayi');
        $this->db->from('new_bordro_pay_set');
        $this->db->join('new_bordro_item','new_bordro_pay_set.bordro_item_id=new_bordro_item.id');
        $this->db->join('geopos_employees','new_bordro_item.pers_id=geopos_employees.id');
        $this->db->where('new_bordro_pay_set.pay_set_id =', $this->aauth->get_user()->id);
        $this->db->where('new_bordro_pay_set.transaction_id=',0);
        $this->db->where_not_in('new_bordro_item.status',[4,3]);
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
        $this->db->order_by('`new_bordro_item`.`id` DESC');
    }
    public function count_filtered_odenis()
    {
        $this->_ajax_list_odenis();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_odenis()
    {
        $this->_ajax_list_odenis();
        return $this->db->count_all_results();
    }


    public function ajax_list_history($id)

    {
        $this->_ajax_list_history($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _ajax_list_history($id)

    {



        $this->db->select('salary_history.*,geopos_employees.name as pers_name');
        $this->db->from('salary_history');
        $this->db->join('geopos_employees','salary_history.user_id=geopos_employees.id');
        $this->db->where('salary_history.bordro_item_id',$id);
        $i = 0;
        foreach ($this->column_search_history as $item) // loop column
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

                if (count($this->column_search_notes) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`salary_history`.`id` DESC');

    }


    public function count_filtered_talep_history($id)
    {
        $this->_ajax_list_history($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_talep_history($id)
    {
        $this->_ajax_list_history($id);
        return $this->db->count_all_results();
    }

    public function onay_mailleri($subject, $message, $recipients, $tip)
    {

        $attachmenttrue = false;
        $attachment = '';


        $this->communication_model->onay_mail($recipients, $subject, $message, $attachmenttrue, $attachment, $tip);
        return 1;

    }

}