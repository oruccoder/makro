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



class Projeiskalemleri_model extends CI_Model

{
    var $column_order = array('geopos_todolist.name', 'geopos_milestones.name', 'geopos_project_bolum.name');
    var $column_search = array('geopos_todolist.name', 'geopos_milestones.name', 'geopos_project_bolum.name');
    var $order = array('id' => 'DESC');


    public function __construct()
    {
        parent::__construct();
        $this->load->model('projectsnew_model', 'projectsnew');
    }
    private function _task_datatables_query($cday = '')

    {


        $i=0;




        if($this->input->post('asama_id'))
        {
            if($this->input->post('alt_asama_id'))
            {
                $this->db->where('geopos_todolist.asama_id=', $this->input->post('alt_asama_id'));
            }
            else
            {
                if(parent_asama_sorgula($this->input->post('asama_id')))
                {
                    foreach (parent_asama_sorgula($this->input->post('asama_id')) as $key )
                    {
                        if($i === 0) {
                            $this->db->where('geopos_todolist.asama_id=', $key->id);
                        }
                        else
                        {
                            $this->db->or_where('geopos_todolist.asama_id=', $key->id);
                        }


                        $i++;

                    }
                }
                else
                {
                    $this->db->where('geopos_todolist.asama_id=', $this->input->post('asama_id'));
                }
            }

        }



        $this->db->select('geopos_todolist.*,geopos_milestones.name as asama_adi,geopos_milestones.parent_id as parent_id,geopos_project_bolum.name as bolum_adi,geopos_project_bolum.id as bolum_id,');

        $this->db->from('geopos_todolist');

        $this->db->join('geopos_milestones', 'geopos_todolist.asama_id = geopos_milestones.id', 'left');
        $this->db->join('geopos_project_bolum', 'geopos_milestones.bolum_id = geopos_project_bolum.id', 'left');

        $this->db->where('related', 1);


        if ($cday) {



            $this->db->where('rid=', $cday);

        }

        if($this->input->post('bolum_id'))
        {
            $this->db->where('geopos_project_bolum.id=', $this->input->post('bolum_id'));
        }








        if($this->input->post('durumu'))
        {
            $this->db->where('geopos_todolist.is_kalemi_durumu=', $this->input->post('durumu'));
        }

        if($this->input->post('is_durumu')==1)
        {
            $this->db->where('geopos_todolist.gorulmus_is_qty>geopos_todolist.quantity');
        }
        if($this->input->post('is_durumu')==2)
        {
            $this->db->where('geopos_todolist.gorulmus_is_qty<geopos_todolist.quantity');
        }

        if($this->input->post('is_durumu')==3)
        {
            $this->db->where('geopos_todolist.gorulmus_is_qty=geopos_todolist.quantity');
        }
        if($this->input->post('simeta_status'))
        {
            $this->db->where('geopos_todolist.simeta_status',$this->input->post('simeta_status'));
        }





        $i = 0;



        foreach ($this->column_search as $item) // loop column

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



                if (count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $search = $this->input->post('order');

        $this->db->order_by('geopos_todolist.id', 'desc');



    }
    function task_datatables($cday = '')

    {





        $this->_task_datatables_query($cday);



        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $this->db->where('related', 1);

        $this->db->where('rid=', $cday);

        $query = $this->db->get();

        return $query->result();

    }
    function task_count_filtered($cday = '')

    {

        $this->_task_datatables_query($cday);

        $this->db->where('related', 1);

        $this->db->where('rid=', $cday);

        $query = $this->db->get();

        return $query->num_rows();

    }
    public function task_count_all($cday = '')

    {

        $this->_task_datatables_query($cday);

        $this->db->where('related', 1);

        $this->db->where('rid=', $cday);

        $query = $this->db->get();

        return $query->num_rows();

    }


    public function clone(){
        $task_id = $this->input->post('task_id');

        if($this->db->query("INSERT INTO geopos_todolist (tdate, name, status, start, duedate, description, eid, aid, related, priority, rid, asama_id, uretim_id, purchase_id, sayim_id, miktar, price, olcu_birimi, cari_id, total, gorev_tipi, unit, quantity, fiyat, toplam_fiyat, proje_id, product_id, is_kalemi_durumu,
            gorulmus_is_qty, son_gorulmus_is, total_2, simeta_status, oran, sira) SELECT tdate, name, status, start, duedate, description, eid, aid, related, priority, rid, asama_id, uretim_id, purchase_id, sayim_id, miktar, price, olcu_birimi, cari_id, total, gorev_tipi, unit, quantity, fiyat, toplam_fiyat, proje_id, product_id, is_kalemi_durumu,
                                                                                                      gorulmus_is_qty, son_gorulmus_is, total_2, simeta_status, oran, sira FROM geopos_todolist Where id=$task_id")){
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde İş Kalemi Kopyalandı',
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız.Yöneticiye Başvurun',
            ];
        }

    }

    public function create(){
        $name = $this->input->post('name_is');
        $customer = $this->input->post('customer_statement_is');
        $content = $this->input->post('content_is');
        $prid = $this->input->post('project');
        $employee = $this->input->post('pers_id_is');
        $olcu_birimi = $this->input->post('olcu_birimi_is');
        $quantity = $this->input->post('quantity_is');
        $fiyat = $this->input->post('fiyat_is');
        $toplam_fiyat = $this->input->post('toplam_fiyat_is');
        $oran = $this->input->post('oran_is');
        $status = $this->input->post('status');

        //$group_id = $this->input->post('asama_id');


        $group_id_arr = $this->input->post('group_id');
        $group_id=0;
        if($group_id_arr){
            $group_id = $group_id_arr[array_key_last($group_id_arr)];
            $ar_count=count($group_id_arr);
            if($group_id==0){
                $eq = intval($ar_count)-1;
                if($eq<=0){
                    $group_id=0;
                }
                else {
                    $eq=$eq-1;
                    $group_id=$group_id_arr[$eq];
                }
            }
        }


        $data = [
            'tdate' => date('Y-m-d H:i:s'),
            'name' => $name,
            'oran' => $oran,
            'status' => $status,
            'description' => $content,
            'eid' => $employee,
            'aid' => $this->aauth->get_user()->id,
            'related' => 1,
            'priority' => 'Medium',
            'rid' => $prid,
            'proje_id' => $prid,
            'asama_id' => $group_id,
            'quantity' => $quantity,
            'price' => $fiyat,
            'fiyat' => $fiyat,
            'total' => $toplam_fiyat,
            'toplam_fiyat' => $toplam_fiyat,
            'unit' => $olcu_birimi,
            'cari_id' => $customer,
            'gorev_tipi' => 1,
            'simeta_status' => 1,

        ];

        if ($this->db->insert('geopos_todolist', $data)) {
            $last_id = $this->db->insert_id();
            kont_kayit(35, $last_id);
            $title = '[İş Kalemi Adı] ' . $name;
            $this->add_activity($title, $prid);
            $this->aauth->applog("Projeye İş Kalemi Eklendi ID: ".$prid, $this->aauth->get_user()->username);

            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde İş Kalemi Eklendi',
                'id'=>$last_id
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                'id'=>0
            ];
        }
    }

    public function createnew(){

        $bolum_id = $this->input->post('bolum_id');
        $asama_id = $this->input->post('asama_id');
        $is_kalemi_id = $this->input->post('is_kalemi_id');
        $qty_new = $this->input->post('qty_new');
        $proje_id = $this->input->post('proje_id');
        $kontrol = $this->db->query("SELECT * FROM project_new_islist Where proje_id = $proje_id and asama_id = $asama_id and bolum_id = $bolum_id and iskalemleri_id=$is_kalemi_id");
        if(!$kontrol->num_rows()){
            $data = [
                'proje_id' => $proje_id,
                'iskalemleri_id' => $is_kalemi_id,
                'qty' => $qty_new,
                'bolum_id' => $bolum_id,
                'asama_id' => $asama_id,
                'loc' => $this->session->userdata('set_firma_id'),
                'auth_id' => $this->aauth->get_user()->id

            ];
            if ($this->db->insert('project_new_islist', $data)) {
                $this->projectsnew->talep_history($proje_id,$this->aauth->get_user()->id,'Projeye İş Kalemi Eklendi: ID :'.$is_kalemi_id);
                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde İş Kalemi Eklendi',
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                    'id'=>0
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Aynı İş Kalemi Proje Eklenmiştir.Miktar Artırımı Talep Ediniz',
                'id'=>0
            ];
        }

    }

    public function update()
    {

        $task_id = $this->input->post('task_id');
        $name = $this->input->post('name');
        $customer = $this->input->post('customer');
        $content = $this->input->post('content');
        $prid = $this->input->post('project');
        $employee = $this->input->post('pers_id');
        $olcu_birimi = $this->input->post('olcu_birimi');
        $quantity = $this->input->post('quantity');
        $fiyat = $this->input->post('fiyat');
        $toplam_fiyat = $this->input->post('toplam_fiyat');
        $oran = $this->input->post('oran');
        $status = $this->input->post('status');


        // Forma2 kontrolü
        if ($this->has_active_forma2($task_id)) {
            return [
                'status' => 0,
                'message' => 'Bu iş kalemine ait kesilmiş forma2 mevcuttur. Bu sebeple iş kaleminde değişiklik yapamazsınız!',
                'id' => 0
            ];
        }

        // Güncelleme verileri
        $data = [
            'name' => $name,
            'oran' => $oran,
            'status' => $status,
            'description' => $content,
            'eid' => $employee,
            'related' => 1,
            'priority' => 'Medium',
            'rid' => $prid,
            'proje_id' => $prid,
            'quantity' => $quantity,
            'fiyat' => $fiyat,
            'toplam_fiyat' => $toplam_fiyat,
            'unit' => $olcu_birimi,
            'cari_id' => $customer,
            'gorev_tipi' => 1,
            'simeta_status' => 1,
        ];

        // Veritabanında güncelleme işlemi
        $this->db->where('id', $task_id);
        if ($this->db->update('geopos_todolist', $data)) {
            $title = 'Güncelleme Yapıldı [İş Kalemi Adı] ' . $name;
            $this->add_activity($title, $prid);
            $this->aauth->applog("İş Kalemi Güncellendi ID: " . $prid, $this->aauth->get_user()->username);

            return [
                'status' => 1,
                'message' => 'Başarılı Bir Şekilde İş Kalemi Güncellendi',
                'id' => $task_id
            ];
        } else {
            return [
                'status' => 0,
                'message' => 'Hata Aldınız. Yöneticiye Başvurun.',
                'id' => 0
            ];
        }
    }

// Forma2 kontrolü
    private function has_active_forma2($task_id)
    {
        $forma2_kontrol = $this->db->query("SELECT * FROM geopos_invoice_items WHERE pid = $task_id AND invoice_type_id IN (29,30)");

        if ($forma2_kontrol->num_rows()) {
            foreach ($forma2_kontrol->result() as $f_items) {
                $form2_id = $f_items->tid;
                $form2_status_kontrol = $this->db->query("SELECT * FROM geopos_invoices WHERE id = $form2_id AND status != 3");
                if ($form2_status_kontrol->num_rows()) {
                    return true;
                }
            }
        }

        return false;
    }


    public function delete(){

        // Kullanıcı kimliğini kontrol et
        if ($this->aauth->get_user()->id != 21) {
            return [
                'status' => 0,
                'message' => 'Yetkiniz Bulunmamaktadır. Bu işlemi yapamazsınız.',
                'id' => 0
            ];
        }

        $task_id = $this->input->post('task_id');
        // İş kalemi detaylarını al
        $details = $this->details($task_id);

        if ($details) {
            // İş kalemini veritabanından sil
            if ($this->db->delete('geopos_todolist', array('id' => $task_id))) {
                // Silme işlemi başarılıysa logları ve aktiviteleri güncelle
                $title = 'Silindi [İş Kalemi Adı] ' . $details->name . ' | Personel: ' . $this->aauth->get_user()->username;
                $this->add_activity($title, $details->rid);
                $this->aauth->applog("İş Kalemi Silindi ID: " . $details->rid, $this->aauth->get_user()->username);

                return [
                    'status' => 1,
                    'message' => 'Başarılı Bir Şekilde İş Kalemi Silindi',
                    'id' => $task_id
                ];
            } else {
                return [
                    'status' => 0,
                    'message' => 'Hata Aldınız. Yöneticiye Başvurun.',
                    'id' => 0
                ];
            }
        } else {
            return [
                'status' => 0,
                'message' => 'Silmek istediğiniz iş kalemi bulunamadı.',
                'id' => 0
            ];
        }
    }


    public function details($id){
        $this->db->select('*');
        $this->db->from('geopos_todolist');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function add_activity($name, $prid,$key3='',$tutar=0)
    {
        $data = array('key3'=>$key3,'pid' => $prid, 'meta_key' => 12, 'value' => $name . ' @' . date('Y-m-d H:i:s'),'total'=>$tutar);

        if ($prid) {

            return $this->db->insert('geopos_project_meta', $data);

        } else {

            return 0;
        }

    }

    public function input_create(){


        $proje_id = $this->input->post('proje_id');
        $todolist_id = $this->input->post('todolist_id');
        $qty = $this->input->post('qty');
        $desc = $this->input->post('desc');
        $confirm_user = $this->input->post('confirm_user');
        $date_input = $this->input->post('date_input');
            $data = [
                'todolist_id' => $todolist_id,
                'qty' => $qty,
                'desc' => $desc,
                'confirm_user' => $confirm_user,
                'date_input' => $date_input,
                'loc' => $this->session->userdata('set_firma_id'),
                'auth_id' => $this->aauth->get_user()->id

            ];
            if ($this->db->insert('project_is_girisi', $data)) {
                $this->talep_history($proje_id,$this->aauth->get_user()->id,'İş Girişi Yapıldı: ID :'.$todolist_id);
                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde Girişi Yapıldı',
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız.Yöneticiye Başvurun',
                    'id'=>0
                ];
            }


    }

    public function talep_history($proje_id,$user_id,$mesaj){
        $data = [
            'proje_id' => $proje_id,
            'user_id' => $user_id,
            'desc' => $mesaj
        ];
        if ($this->db->insert('proje_history', $data)) {
            return true;
        }
        else {
            return  false;
        }
    }

    public function ajax_list_is_kalemleri_ac_list($id)

    {
        $this->_ajax_list_is_kalemleri_ac_list($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }

    private function _ajax_list_is_kalemleri_ac_list($id)

    {


        $this->db->select('project_is_girisi.id,
        project_is_girisi.auth_id,
        project_is_girisi.created_at,
        project_is_girisi.desc,
        project_is_girisi.date_input,
        project_is_girisi.qty,
        geopos_todolist.unit as olcu_birimi,
        geopos_employees.name as sorumlu_pers
        ');
        $this->db->from('project_is_girisi');
        $this->db->join('geopos_employees','project_is_girisi.confirm_user=geopos_employees.id');
        $this->db->join('geopos_todolist','project_is_girisi.todolist_id=geopos_todolist.id');
        $this->db->where('project_is_girisi.todolist_id',$id);
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
        $this->db->order_by('`project_is_girisi`.`id` DESC');

    }


    public function ac_list_filtered($id)
    {
        $this->_ajax_list_is_kalemleri_ac_list($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function ac_list_count($id)
    {
        $this->_ajax_list_is_kalemleri_ac_list($id);
        return $this->db->count_all_results();
    }
}

