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





class Personelaction_model extends CI_Model
{
    var $table_news = 'user_permit';
    var $column_order = array('code', 'start_date', 'end_date','creatad_at');
    var $column_search = array('code', 'start_date', 'end_date','creatad_at');

    var $column_order_task = array('id','code', 'personel_id',null,null);
    var $column_search_task = array('geopos_employees.name', 'created_at');

    var $column_order_task_v = array('id','code', 'text','geopos_employees.name','created_at','status','progress_status_id');
    var $column_search_task_v = array('code', 'text','geopos_employees.name','created_at','geopos_task_status.name','progress_status.name');

    var $order = array('id' => 'DESC');


    public function datatables_izinler()

    {
        $this->_datatables_izinler_query();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _datatables_izinler_query()
    {

        $user_id = $this->input->post('cid');
        $this->db->select('*');
        $this->db->from('user_permit');
        $this->db->where('user_id',$user_id);

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
        $this->db->order_by('`user_permit`.`id` DESC');
    }
    public function count_filtered_izinler()
    {
        $this->_datatables_izinler_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_izinler()
    {
        $this->_datatables_izinler_query();
        return $this->db->count_all_results();
    }


    public function datatables_task()

    {
        $this->_datatables_task_query();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _datatables_task_query()
    {
        $this->db->select('personel_task.*,geopos_employees.name');
        $this->db->from('personel_task');
        $this->db->join('geopos_employees','personel_task.personel_id=geopos_employees.id','LEFT');

        if($this->input->post('tip')){
            if($this->input->post('tip')==1){ //atadığım
                $this->db->where('personel_task.staff_id',$this->aauth->get_user()->id);
            }
            else if($this->input->post('tip')==2){
                $this->db->where('personel_task.personel_id',$this->aauth->get_user()->id);
            }
        }
        else {
            //$this->db->where('personel_task.status!=3');
        }

        if($this->session->userdata('set_firma_id')){
            $this->db->where('personel_task.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

        $i = 0;
        foreach ($this->column_search_task as $item) // loop column
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
                if (count($this->column_search_task) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) {
            $this->db->order_by($this->column_order_task[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $this->db->order_by('`personel_task`.`id` DESC');
        }

        $this->db->group_by('`personel_task`.`personel_id`');
    }
    public function count_filtered_task()
    {
        $this->_datatables_task_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_task()
    {
        $this->_datatables_task_query();
        return $this->db->count_all_results();
    }




    public function datatables_task_details()

    {
        $this->_datatables_task_query_details();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _datatables_task_query_details()
    {
        $personel_id = $this->input->post('personel_id');
        $this->db->select('personel_task.*,geopos_employees.name,');
        $this->db->from('personel_task');
        $this->db->join('geopos_employees','personel_task.staff_id=geopos_employees.id');
        $this->db->join('geopos_task_status','personel_task.status=geopos_task_status.id');
        $this->db->join('progress_status','personel_task.progress_status_id=progress_status.id');
        $this->db->where('personel_task.personel_id',$personel_id);

        if($this->input->post('tip')){
            if($this->input->post('tip')==1){
                $this->db->where('personel_task.bildirim_durumu',1);
                $this->db->where('personel_task.status IN (1,2)');
            }
        }
        if($this->input->post('view')){
            if($this->input->post('view')==2){
                $this->db->where('personel_task.staff_id',$this->aauth->get_user()->id);
            }
            elseif($this->input->post('view')==3){
                $this->db->where('personel_task.personel_id',$this->aauth->get_user()->id);
            }
        }

        $i = 0;
        foreach ($this->column_search_task_v as $item) // loop column
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
                if (count($this->column_search_task_v) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) {
            $this->db->order_by($this->column_order_task_v[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $this->db->order_by('`personel_task`.`id` DESC');
        }
    }
    public function count_filtered_task_details()
    {
        $this->_datatables_task_query_details();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_task_details()
    {
        $this->_datatables_task_query_details();
        return $this->db->count_all_results();
    }


    public function datatables_task_actions()

    {
        $this->_datatables_task_actions_query_details();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _datatables_task_actions_query_details()
    {
        $id = $this->input->post('id');
        $this->db->select('personel_task_action.*,geopos_employees.name,geopos_task_status.name as st_name');
        $this->db->from('personel_task_action');
        $this->db->join('geopos_employees','personel_task_action.aauth_id=geopos_employees.id');
        $this->db->join('geopos_task_status','personel_task_action.status=geopos_task_status.id');
        $this->db->where('personel_task_action.task_id',$id);
        $i = 0;
        foreach ($this->column_search_task_v as $item) // loop column
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
                if (count($this->column_search_task_v) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) {
            $this->db->order_by($this->column_order_task_v[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $this->db->order_by('`personel_task_action`.`id` DESC');
        }
    }
    public function count_filtered_task_actions()
    {
        $this->_datatables_task_actions_query_details();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_task_actions()
    {
        $this->_datatables_task_actions_query_details();
        return $this->db->count_all_results();
    }


    public function daysBetween($dt1, $dt2) {
        return date_diff(
            date_create($dt2),
            date_create($dt1)
        )->format('%a');
    }

    public function create_permit(){

        $kalan_mezuniyet = mezuniyet_report($this->aauth->get_user()->id)['mezuniyet_kalan_number'];
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        $gun_farki = intval($this->daysBetween($start_date,$end_date));
        $gun_farki_n=intval($gun_farki)+1;

        $permit_type = $this->input->post('permit_type');

        if($permit_type==1){
            if(intval($gun_farki_n) <= intval($kalan_mezuniyet)){
                $description = $this->input->post('description');
                $user_id = $this->input->post('user_id');

                $new_start_date =  str_replace('T',' ',$start_date);
                $new_end_date =  str_replace('T',' ',$end_date);

                $code = numaric(27);
                $data = [
                    'user_id'=>$user_id,
                    'code'=>$code,
                    'description'=>$description,
                    'start_date'=>$new_start_date,
                    'end_date'=>$new_end_date,
                    'permit_type'=>$permit_type,
                    'loc'=>$this->session->userdata('set_firma_id'),
                ];



                if($this->db->insert('user_permit', $data)){
                    $last_id=$this->db->insert_id();
                    numaric_update(27);
                    $this->aauth->applog("İzin Talebi Oluşturuldu : ".$permit_type.' '.$code, $this->aauth->get_user()->username);
                    return [
                        'status'=>1,
                        'message'=>'Başarıyla Oluşturulmuştur',

                    ];
                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız',
                        'id'=>0
                    ];
                }
            }
            else {
                $mess='Sizin Mezuniyet Hakkınız Kalmamış.Öz Hesabına veya Ücretli Talep edebilirsiniz';
                if($kalan_mezuniyet){
                    $mess='Sizin max Mezuniyet kullanma gün sayınız : '.$kalan_mezuniyet;
                }
                return [
                    'status'=>0,
                    'message'=>$mess,
                    'id'=>0
                ];
            }
        }
        else {
            $description = $this->input->post('description');
            $user_id = $this->input->post('user_id');
            $new_start_date =  str_replace('T',' ',$start_date);
            $new_end_date =  str_replace('T',' ',$end_date);
            $code = numaric(27);
            $data = [
                'user_id'=>$user_id,
                'code'=>$code,
                'description'=>$description,
                'start_date'=>$new_start_date,
                'end_date'=>$new_end_date,
                'permit_type'=>$permit_type,
                'loc'=>$this->session->userdata('set_firma_id'),
            ];

            if($this->db->insert('user_permit', $data)){
                $last_id=$this->db->insert_id();
                numaric_update(27);
                $this->aauth->applog("İzin Talebi Oluşturuldu : ".$permit_type.' '.$code, $this->aauth->get_user()->username);
                return [
                    'status'=>1,
                    'message'=>'Başarıyla Oluşturulmuştur',

                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız',
                    'id'=>0
                ];
            }
        }






    }
    public function update_permit(){
        $permit_id = $this->input->post('permit_id');
        $details = $this->details_permit($permit_id);
        $code = $details->code;
        $this->db->delete('user_permit_confirm', array('user_permit_id' => $permit_id));
        $this->db->delete('user_permit', array('id' => $permit_id));
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $description = $this->input->post('description');
        $user_id = $this->input->post('user_id');
        $permit_type = $this->input->post('permit_type');
        $new_start_date =  str_replace('T',' ',$start_date);
        $new_end_date =  str_replace('T',' ',$end_date);
        $data = [
            'user_id'=>$user_id,
            'code'=>$code,
            'description'=>$description,
            'start_date'=>$new_start_date,
            'end_date'=>$new_end_date,
            'permit_type'=>$permit_type,
            'loc'=>$this->session->userdata('set_firma_id'),
        ];
        if($this->db->insert('user_permit', $data)){
            $this->aauth->applog("İzin Talebi Güncellendi : ".$permit_type.' '.$code, $this->aauth->get_user()->username);
            return [
                'status'=>1,
                'message'=>'Başarıyla Güncellendi',

            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız',
                'id'=>0
            ];
        }
    }
    public function delete_permit(){
        $id = $this->input->post('id');
        $details = $this->details_permit($id);
        $code = $details->code;
        $user_id = $this->aauth->get_user()->id;
        if($user_id==$details->user_id){
            $this->db->delete('user_permit_confirm', array('user_permit_id' => $id));
            if( $this->db->delete('user_permit', array('id' => $id))){
                $this->aauth->applog("İzin Talebi Silinmiştir : ".$code, $this->aauth->get_user()->username);
                return [
                    'status'=>1,
                    'message'=>'Başarıyla Silindi',
                    'id'=>0
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız',
                    'id'=>0
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Silmek için Yetkiniz Bulunmamaktadır.Yönetici İle İletişime Geçiniz',
                'id'=>0
            ];
        }
    }


    public function task_delete(){
        $id = $this->input->post('id');
        $details = $this->task_details($id);
        $code = $details->code;
        $user_id = $this->aauth->get_user()->id;
        if($user_id==$details->staff_id){
            if( $this->db->delete('personel_task', array('id' => $id))){
                $this->aauth->applog("Görev Silinmiştir : ".$code, $this->aauth->get_user()->username);
                return [
                    'status'=>1,
                    'message'=>'Başarıyla Silindi',
                    'id'=>0
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız',
                    'id'=>0
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Görevi Tanımlayan Personel Dışında Silme İşlemi Yapamazsınız',
                'id'=>0
            ];
        }
    }

    public function create_task(){
        date_default_timezone_set('Asia/Baku');
        $text = $this->input->post('text');
        $progress_status_id = $this->input->post('progress_status_id');
        $status = $this->input->post('status');
        $personel_id = $this->input->post('personel_id');
        $image_text = $this->input->post('image_text');

        $code = numaric(30);
        $data = [
            'text'=>$text,
            'progress_status_id'=>$progress_status_id,
            'status'=>$status,
            'image_text'=>$image_text,
            'personel_id'=>$personel_id,
            'code'=>$code,
            'loc'=>$this->session->userdata('set_firma_id'),
            'staff_id'=>$this->aauth->get_user()->id,
        ];

        if($this->db->insert('personel_task', $data)){
            $last_id=$this->db->insert_id();
            numaric_update(30);
            $this->aauth->applog("Görevlendirme Oluşturulmuştur: ".$code, $this->aauth->get_user()->username);
            return [
                'status'=>1,
                'code'=>$code,
                'message'=>'Başarıyla Oluşturulmuştur',

            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız',
                'id'=>0
            ];
        }
    }

    public function update_task(){

        $id = $this->input->post('id');
        $details = $this->task_details($id);
        $code = $details->code;
        $staff_id = $details->staff_id;
        if($staff_id==$this->aauth->get_user()->id){
            date_default_timezone_set('Asia/Baku');
            $text = $this->input->post('text');
            $progress_status_id = $this->input->post('progress_status_id');
            $status = 1;
            $personel_id = $this->input->post('personel_id');

            $this->db->delete('personel_task', array('id' => $id));
            $data = [
                'text'=>$text,
                'progress_status_id'=>$progress_status_id,
                'status'=>$status,
                'personel_id'=>$personel_id,
                'code'=>$code,
                'staff_id'=>$this->aauth->get_user()->id,
            ];

            if($this->db->insert('personel_task', $data)){
                $this->aauth->applog("Görevlendirme Güncellendi: ".$code, $this->aauth->get_user()->username);
                return [
                    'status'=>1,
                    'message'=>'Başarıyla Güncellendi',

                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız',
                    'id'=>0
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Güncelleme İşlemini Atayan Personel Yapabilir',
                'id'=>0
            ];
        }


    }

    public function update_task_change(){

        date_default_timezone_set('Asia/Baku');
        $id = $this->input->post('id');
        $details = $this->task_details($id);
        $code = $details->code;
        $staff_id = $details->personel_id;
        if($staff_id==$this->aauth->get_user()->id){

            $text = $this->input->post('text');
            $status = $this->input->post('status');
            $new_pers_id = $this->input->post('new_pers_id');

            if($new_pers_id){
                $this->db->delete('personel_task', array('id' => $id));
                $data = [
                    'text'=>$details->text.' '.$text,
                    'progress_status_id'=>$details->progress_status_id,
                    'image_text'=>$details->image_text,
                    'status'=>$status,
                    'personel_id'=>$new_pers_id,
                    'code'=>$code,
                    'bildirim_durumu'=>1,
                    'staff_id'=>$this->aauth->get_user()->id,
                ];

                if($this->db->insert('personel_task', $data)){
                    $last_id=$this->db->insert_id();

                    $this->db->set('task_id',$last_id, FALSE);
                    $this->db->where('id', $id);
                    $this->db->update('personel_task_action');

                    $this->task_sms($code,$new_pers_id,$this->aauth->get_user()->id);
                    $this->aauth->applog("Görevlendirme Güncellendi: ".$code, $this->aauth->get_user()->username);
                    return [
                        'status'=>1,
                        'code'=>$code,
                        'status_name'=>task_status($status),
                        'new_pers_id'=>$new_pers_id,
                        'personel_id'=>$staff_id,
                        'message'=>'Başarıyla Güncellendi',

                    ];
                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız',
                        'id'=>0
                    ];
                }
            }
            else {
                $this->db->set('status',$status, FALSE);
                $this->db->where('id', $id);
                if( $this->db->update('personel_task')){

                    $data = [
                        'desc'=>$text,
                        'task_id'=>$id,
                        'status'=>$status,
                        'aauth_id'=>$this->aauth->get_user()->id,
                    ];

                    if($this->db->insert('personel_task_action', $data)){
                        return [
                            'status'=>1,
                            'status_name'=>task_status($status),
                            'code'=>$code,
                            'new_pers_id'=>0,
                            'personel_id'=>$details->staff_id,
                            'message'=>'Başarıyla Güncellendi',

                        ];
                    }
                    else {
                        return [
                            'status'=>0,
                            'message'=>'Hata Aldınız',

                        ];
                    }

                }
            }




        }
        else {
            return [
                'status'=>0,
                'message'=>'Güncelleme İşlemini Atayan Personel Yapabilir',
                'id'=>0
            ];
        }


    }

    public function notifation_permit(){
        $id = $this->input->post('id');
        $details = $this->details_permit($id);
        $code = $details->code;
        $user_id = $this->aauth->get_user()->id;
        if($user_id==$details->user_id){
            $this->db->set('bildirim_durumu',1, FALSE);
            $this->db->where('id', $id);
            if( $this->db->update('user_permit')){
                $pers_id = $details->user_id;
                $sorumlu_pers_id = personel_details_full($pers_id)['sorumlu_pers_id']; //bölüm Müdürü
                $role_id = personel_details_full($pers_id)['roleid'];
                $details = confirm_details_permit($role_id);

                $users_ = onay_sort(10,0,$user_id);
                if($users_){
                    foreach ($users_ as $items){
                        $staff=0;
                        if($items['sort']==1){
                            $staff=1;
                        }
                        $status  = confirm_insert_permit($id,$items['user_id'],$items['sort']);
                    }


                if($details){

                    if($status){
                        $this->aauth->applog("İzin Talebi Bildirimi Başlatılmıştır : ".$code, $this->aauth->get_user()->username);
                        return [
                            'status'=>1,
                            'message'=>'Başarıyla Bildirim Oluşturuldu',
                            'id'=>0
                        ];
                    }
                    else {
                        return [
                            'status'=>0,
                            'message'=>'Hata Aldınız',
                            'id'=>0
                        ];
                    }


                }
                else{
                    return [
                        'status'=>0,
                        'message'=>'Rolünüzle İlgili Atamalar Yapılmamışrır',
                        'id'=>0
                    ];
                }
            }
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız',
                    'id'=>0
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Silmek için Yetkiniz Bulunmamaktadır.Yönetici İle İletişime Geçiniz',
                'id'=>0
            ];
        }
    }

    public function task_notifation(){
        $id = $this->input->post('id');
        $details = $this->task_details($id);
        $code = $details->code;
        $user_id = $this->aauth->get_user()->id;
        if($user_id==$details->staff_id){
            $this->db->set('bildirim_durumu',1, FALSE);
            $this->db->where('id', $id);
            if( $this->db->update('personel_task')){
                $pers_id = $details->personel_id;
                $sorumlu_pers_id = personel_details_full($pers_id)['sorumlu_pers_id']; //bölüm Müdürü
                    if($sorumlu_pers_id){

                        $this->task_sms($code,$details->personel_id,$details->staff_id);
                        $this->aauth->applog("Görev Talebi Bildirimi Başlatılmıştır : ".$code, $this->aauth->get_user()->username);
                        return [
                            'status'=>1,
                            'message'=>'Başarıyla Bildirim Oluşturuldu',
                            'id'=>0,
                            'code'=>$code,
                            'personel_id'=>$pers_id,
                        ];
                    }
                    else {
                        return [
                            'status'=>0,
                            'message'=>'Hata Aldınız',
                            'id'=>0
                        ];
                    }
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız',
                    'id'=>0
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Silmek için Yetkiniz Bulunmamaktadır.Yönetici İle İletişime Geçiniz',
                'id'=>0
            ];
        }
    }
    public function details_permit($id){
        $this->db->select('*');
        $this->db->from('user_permit');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function task_details($id){
        $this->db->from('personel_task');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function details_permit_confirm($id){
        $this->db->select('user_permit_confirm.*,geopos_employees.name,permit_type.name as permit_name');
        $this->db->from('user_permit_confirm');
        $this->db->join('geopos_employees','user_permit_confirm.staff_id=geopos_employees.id');
        $this->db->join('permit_type','user_permit_confirm.staff_permit_type=permit_type.id','LEFT');
        $this->db->where('user_permit_confirm.user_permit_id', $id);
        $this->db->order_by('user_permit_confirm.sort','ASC');
        $query = $this->db->get();
        return $query->result();
    }
    public function details_item_sort($id){
        $this->db->select('*');
        $this->db->from('user_permit_confirm');
        $this->db->where('staff_status', null);
        $this->db->where('user_permit_id', $id);
        $this->db->limit('1');
        $this->db->order_by('sort','asc');
        $query = $this->db->get();
        return $query->row();
    }

    public function permit_sms($permit_id){

//        $details = $this->details_permit($permit_id);
//        $details_item_sort = $this->details_item_sort($permit_id);
//
//        $staff_id = $details_item_sort->staff_id;
//        $personel_details = personel_details_full($details->user_id);
//        $personel_name = $personel_details['name'];
//        $href="https://personel.makro2000.com.tr";
//        $short_url = "https://personel.makro2000.com.tr";//getSmallLink($href,18);
//        $messages='Sayin yetkili '.$personel_name.' , personeliniz izin talep etmektedir.İncelemek ucun buraya vurun. '.$short_url;
//        $yetkili_details = personel_details_full($staff_id);
//
//
//        //$message_ = $this->mesaj_gonder(502862033,$messages);
//        $message_ = $this->mesaj_gonder($yetkili_details['phone'],$messages);
//        return $message_;
        return true;

    }

    public function task_sms($code,$personel_id,$staff_id){

        $personel_details = personel_details_full($staff_id);
        $personel_name = $personel_details['name'];

        $messages='Sayin yetkili '.$personel_name.' , adlı personel '.$code.' kodlu görevi size atadı. Görevlerim Bildirimlerinden Bakabilirsiniz.';
        $yetkili_details = personel_details_full($personel_id);


        //$message_ = $this->mesaj_gonder(502862033,$messages);
        $message_ = $this->mesaj_gonder($yetkili_details['phone'],$messages);
      //  return $message_;
        return true;
    }

   public function mesaj_gonder($no,$mesaj)
    {
        $result='';




        $tel=str_replace(" ","",$no);

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

    public function user_permit_update(){
        $id_confirm = $this->input->post('confirm_id');
        $status = $this->input->post('status');
        $desc = $this->input->post('desc');
        $permit_type = $this->input->post('permit_type');
        $data_update=[
            'staff_status'=>$status,
            'staff_desc'=>$desc,
            'staff_permit_type'=>$permit_type,
            'updated_at'=>'NOW()',
        ];
        $this->db->set($data_update);
        $this->db->where('id',$id_confirm);
        $this->db->update('user_permit_confirm',$data_update);


        if($status==1){
            $user_permit_id = $this->db->query("SELECT * FROM user_permit_confirm where id=$id_confirm ")->row()->user_permit_id;
            //Permit Update
            $this->db->set('permit_type', $permit_type);
            $this->db->where('id', $user_permit_id);
            $this->db->update('user_permit');
            //Permit Update


            $kontrol  = $this->db->query("SELECT * FROM user_permit_confirm where user_permit_id=$user_permit_id and staff_status is null ORDER BY sort LIMIT 1 ");
            if($kontrol->num_rows()){

                //onaylayacak Biri Var
                $staff_id  = $kontrol->row()->staff_id;
                $details = $this->details_permit($user_permit_id);
                $personel_details = personel_details_full($details->user_id);
                $personel_name = $personel_details['name'];
                $href="https://personel.makro2000.com.tr";
                $short_url = "https://personel.makro2000.com.tr";//getSmallLink($href,18);
                $messages='Sayin yetkili '.$personel_name.' , personeliniz izin talep etmektedir.İncelemek ucun buraya vurun. '.$short_url;
                $yetkili_details = personel_details_full($staff_id);
                if($this->mesaj_gonder($yetkili_details['phone'],$messages)){
                    return [
                        'status'=>1,
                        'message'=>'Başarıyla Onayınız İletilmiştir',
                        'id'=>0
                    ];
                }



            }
            else {

                $user_permit_id = $this->db->query("SELECT * FROM user_permit_confirm where id=$id_confirm ")->row()->user_permit_id;

                //Permit Update
                $this->db->set('permit_type', $permit_type);
                $this->db->where('id', $user_permit_id);
                $this->db->update('user_permit');
                //Permit Update
                $details = $this->details_permit($user_permit_id);
                $messages='Sayin yetkili İzin Talebiniz Onaylanmıştır';
                $yetkili_details = personel_details_full($details->user_id);
                $message_ =$this->mesaj_gonder($yetkili_details['phone'],$messages);
                $this->db->set('status', $status, FALSE);
                $this->db->where('id', $user_permit_id);
                if(	$this->db->update('user_permit')){
                    return [
                        'status'=>1,
                        'message'=>'Onay Talebiniz Personele İletilmiştir',
                        'id'=>0
                    ];
                }

            }
        }
        else {
            $user_permit_id = $this->db->query("SELECT * FROM user_permit_confirm where id=$id_confirm ")->row()->user_permit_id;
            $details = $this->details_permit($user_permit_id);
            $messages='Sayin yetkili İzin Talebiniz İptal Edilmiştir.Açıklama : '.$desc;
            $yetkili_details = personel_details_full($details->user_id);
            $message_ =$this->mesaj_gonder($yetkili_details['phone'],$messages);

            $data=[
                'status'=>2
            ];
            $this->db->set($data);
            $this->db->where('id',$user_permit_id);
            if($this->db->update('user_permit', $data)){
                return [
                    'status'=>1,
                    'message'=>'İptal Talebiniz Personele İletilmiştir',
                ];
            }

        }


    }

    public function bekleyentask(){
        $aauth_id = $this->aauth->get_user()->id;
        $count = $this->db->query("SELECT * FROM `personel_task` WHERE `status` IN (1,2) AND `personel_id` = $aauth_id AND `bildirim_durumu` = 1")->num_rows();

        return [
            'status'=>1,
            'count'=>$count
        ];
    }


}
