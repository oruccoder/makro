
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





class Mobilapi_model extends CI_Model
{
    var $table_news = 'araclar ';

    var $column_order = array('talep_form.code', 'talep_form.desc', 'geopos_employees.name', 'progress_status.name', 'geopos_projects.code', 'talep_form_status.name');

    var $column_search = array('talep_form.code', 'talep_form.desc', 'geopos_employees.name', 'progress_status.name', 'geopos_projects.code', 'talep_form_status.name');


    var $customer_column_order = array('geopos_customers.company', 'talep_form_customer_new.code', 'talep_form_customer_new.desc', 'geopos_employees.name', 'progress_status.name', 'geopos_projects.code', 'talep_form_status.name');

    var $customer_column_search = array('geopos_customers.company', 'talep_form_customer_new.code', 'talep_form_customer_new.desc', 'geopos_employees.name', 'progress_status.name', 'geopos_projects.code', 'talep_form_status.name');


    var $personel_column_order = array('geopos_employees.name', 'talep_form_personel.code', 'talep_form_personel.desc', 'progress_status.name', 'geopos_projects.code', 'talep_form_status.name');

    var $personel_column_search = array('geopos_employees.name', 'talep_form_personel.code', 'talep_form_personel.desc', 'progress_status.name', 'geopos_projects.code', 'talep_form_status.name');


    var $order = array('id' => 'DESC');

    var $column_report = array('code');


    public function __construct()
    {
        parent::__construct();

    }


    public function get_datatables_query_details_talep_list($start,$length,$tip,$user_id)

    {
        $this->_get_datatables_query_details_talep_list($tip,$user_id);
        if ($length != -1)

            $this->db->limit($length, $start);

        $query = $this->db->get();
        //$query=$query->result();
        //echo $this->db->last_query();die();

        return $query->result();

    }

    private function _get_datatables_query_details_talep_list($tip,$user_id)
    {

        $auth_id = $user_id;
        $this->db->select('talep_form.*,geopos_employees.name as pers_name,progress_status.name as progress_name,talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.sort_name as st_name');
        $this->db->from('talep_form');
        $this->db->join('geopos_employees','talep_form.talep_eden_user_id=geopos_employees.id');
        $this->db->join('progress_status','talep_form.progress_status_id=progress_status.id');
        $this->db->join('geopos_projects','talep_form.proje_id=geopos_projects.id','LEFT');
        $this->db->join('talep_form_status','talep_form.status=talep_form_status.id');
        if($tip==1){
            $this->db->join('talep_onay_new','talep_form.id=talep_onay_new.talep_id');
        }
        elseif($tip==2  || $tip==107){
            $this->db->join('talep_user_satinalma','talep_form.id=talep_user_satinalma.talep_id');
        }
        elseif($tip==3 || $tip==108){
            $this->db->join('talep_onay_new','talep_form.id=talep_onay_new.talep_id');
        }

        elseif($tip==5 || $tip==109){
            $this->db->join('talep_user_satinalma','talep_form.id=talep_user_satinalma.talep_id');
        }

        elseif($tip==6 || $tip==110){
            $this->db->join('siparis_list_form','talep_form.id=siparis_list_form.talep_id');
        }
        elseif($tip==7 || $tip==111){
            $this->db->join('talep_user_satinalma','talep_form.id=talep_user_satinalma.talep_id');
        }
        elseif($tip==8){
            $this->db->join('geopos_warehouse','talep_form.warehouse_id=geopos_warehouse.id');
        }
        elseif($tip==11){
            $this->db->join('talep_user_satinalma','talep_form.id=talep_user_satinalma.talep_id');
        }
        elseif($tip==99){
            $this->db->join('talep_form_avans','talep_form.id=talep_form_avans.talep_id');
            $this->db->join('talep_form_avans_sort','talep_form_avans.id=talep_form_avans_sort.talep_form_avans_id');
        }

        elseif($tip==100){
            $this->db->join('talep_form_avans','talep_form.id=talep_form_avans.talep_id');
            $this->db->join('talep_form_avans_sort','talep_form_avans.id=talep_form_avans_sort.talep_form_avans_id');
        }
        elseif($tip==101){
            $this->db->join('talep_form_avans','talep_form.id=talep_form_avans.talep_id');
            $this->db->join('talep_form_avans_sort','talep_form_avans.id=talep_form_avans_sort.talep_form_avans_id');
        }
        elseif($tip==102){
            $this->db->join('talep_user_satinalma','talep_form.id=talep_user_satinalma.talep_id');
        }
        elseif($tip==103){
            $this->db->join('geopos_warehouse','talep_form.transfer_warehouse_id=geopos_warehouse.id');
        }
        elseif($tip==104){
            $this->db->join('talep_onay_new','talep_form.id=talep_onay_new.talep_id');
        }
        elseif($tip==105 || $tip==106){
            $this->db->join('talep_onay_new','talep_form.id=talep_onay_new.talep_id');
        }

        $this->db->where('talep_form.loc', 5);
        if($tip==1){
            $this->db->where("talep_onay_new.type",1);
            $this->db->where("talep_onay_new.staff",1);
            $this->db->where("talep_form.status",1);
            $this->db->where("talep_onay_new.user_id",$auth_id);
        }
        elseif($tip==2 || $tip==107){

            $this->db->where("talep_form.status IN (2,3)");
            $this->db->where("talep_user_satinalma.status IN(1,2)");
            $this->db->where("talep_user_satinalma.user_id",$auth_id);
        }

        elseif($tip==5  || $tip==109){
            $this->db->where("talep_form.status",5);
            $this->db->where("talep_user_satinalma.user_id",$auth_id);
        }

        elseif($tip==7 || $tip==111){
            $this->db->where("talep_form.status",6);
            $this->db->where("talep_user_satinalma.user_id",$auth_id);
        }
        elseif($tip==3 || $tip==108){
            $this->db->where("talep_onay_new.type",2);
            $this->db->where("talep_form.status",4);
            $this->db->where("talep_onay_new.staff",1);
            $this->db->where("talep_onay_new.user_id",$auth_id);
        }
        elseif($tip==6 || $tip==110){
            $this->db->where("siparis_list_form.staf_status",1);
            $this->db->where("siparis_list_form.deleted_at is NULL");
            $this->db->where("siparis_list_form.staff_id",$auth_id);
            $this->db->where("talep_form.status",5);
        }
        elseif($tip==8){
            $this->db->where("talep_form.status",7);
            $this->db->where("geopos_warehouse.pers_id",$auth_id);
        }

        elseif($tip==112){
            $this->db->where("talep_form.status",7);
            $this->db->where("talep_form.warehouse_id",$auth_id);
        }

        elseif($tip==99){
            $this->db->where("talep_form_avans.status_id",1);
            $this->db->where("talep_form_avans_sort.staff_status",0);
            $this->db->where("talep_form_avans_sort.staff",1);
            $this->db->where("talep_form_avans_sort.staff_id",$auth_id);
            $this->db->where("talep_form.status",18);
        }

        elseif($tip==100){
            $this->db->where("talep_form.status",20);
            $this->db->where("talep_form_avans.type",2);
            $this->db->where("talep_form_avans_sort.staff_status",0);
            $this->db->where("talep_form_avans_sort.staff_id",$auth_id);
        }
        elseif($tip==101){
            $this->db->where("talep_form_avans_sort.staff_status",4);
            $this->db->where("talep_form_avans_sort.type",2);
            $this->db->where("talep_form_avans_sort.muhasebe_id",$auth_id);
            $this->db->where("talep_form.status",12);
        }
        elseif($tip==9 || $tip==113){


            if($auth_id==39){
                $this->db->where("talep_form.status",8);
//                    $this->db->where("geopos_projects.muhasebe_muduru_id",$auth_id);
            }
            else {
                $this->db->where("talep_form.status",0);
            }

        }

        elseif($tip==11){
            $this->db->where_in("talep_form.status",[11,19]);
            $this->db->where("talep_user_satinalma.user_id",$auth_id);
        }
        elseif($tip==102){
            $this->db->where("talep_form.status",3);
            $this->db->where("talep_user_satinalma.user_id",$auth_id);
        }
        elseif($tip==103){
            $this->db->where("talep_form.status",8);
            $this->db->where("talep_form.transfer_bildirim",1);
            $this->db->where("talep_form.transfer_status",1);
            $this->db->where("geopos_warehouse.pers_id",$auth_id);
        }
        elseif($tip==104){
            $this->db->where("talep_onay_new.type",3);
            $this->db->where("talep_onay_new.staff",1);
            $this->db->where("talep_form.status",17);
            $this->db->where("talep_onay_new.user_id",$auth_id);
        }

        //hizet
        elseif($tip==105){
            $this->db->where("talep_onay_new.type",3);
            $this->db->where("talep_onay_new.staff",1);
            $this->db->where("talep_form.status",17);
            $this->db->where("talep_onay_new.user_id",$auth_id);
            $this->db->where("talep_form.talep_type",2);
        }
        elseif($tip==106){

            $this->db->where("talep_onay_new.type",1);
            $this->db->where("talep_onay_new.staff",1);
            $this->db->where("talep_onay_new.user_id",$auth_id);
            $this->db->where("talep_form.status",1);
            $this->db->where("talep_form.talep_type",2);
        }


        $talep_type_not = [105,106,107,108,109,110,111,112,113];

        if(!in_array($tip,$talep_type_not)){
            $this->db->where("talep_form.talep_type",1);
        }
        else {
            $this->db->where("talep_form.talep_type",2);
        }



        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if($_POST){
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


        }
        $this->db->order_by('`talep_form`.`id` DESC');
        if($tip==6 || $tip==110){
            $this->db->group_by('`siparis_list_form`.`talep_id`');
        }
        else if($tip==99 ||$tip==100 || $tip==101){
            $this->db->group_by('`talep_form_avans`.`talep_id`');
        }

    }

    public function pass_kontrol($pass,$userid)
    {

        $salt = md5($userid);
        return hash('sha256', $salt . $pass);
    }

    public function salary_details($id){
        $this->db->select('*');
        $this->db->from('personel_salary');
        $this->db->where('personel_id',$id);
        $this->db->where('status',1);
        $query = $this->db->get();
        return $query->row();
    }
    public function user_details($email,$password)
    {

        $user_kontrol = $this->db->query("Select * from geopos_users Where email ='$email'");
        if($user_kontrol->num_rows()){

            $user_id = $user_kontrol->row()->id;

            $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
            $data = array(
                'id' => $user_id,
                'loggedin' => TRUE,
                'user_new_id' => '½'.$rows->id.'½',
            );

            $this->session->set_userdata($data);
            $this->session->set_userdata('set_firma_id',$rows->loc);

            $new_pas = $this->pass_kontrol($password,$user_id);
            $salary_details = $this->salary_details($user_id);
            $all_users = all_personel();
            $all_customer = all_customer();
            $all_proje = all_projects();
            if($new_pas ==$user_kontrol->row()->pass){
                return [
                    'status'=>1,
                    'message'=>'Giriş Başarılı',
                    'user_id'=>$user_id,
                    'posizyon'=>role_name($user_kontrol->row()->roleid)['name'],
                    'details'=>personel_detailsa($user_kontrol->row()->id),
                    'user_name'=>personel_detailsa($user_kontrol->row()->id)['name'],
                    'proje_code'=> proje_code($salary_details->proje_id),
                    'all_users'=>$all_users,
                    'all_customer'=>$all_customer,
                    'all_proje'=>$all_proje
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Şifre Hatalı',
                    'user_id'=>0
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Kayıtlı E-Mail Adresi Bulunamadı',
                'user_id'=>0
            ];
        }
    }

    public function create_mobil_ticket($user_id,$ticketTitle,$ticketDescription)
    {
        $this->db->trans_start();
        $data = array(
            'user_id' => $user_id,
            'ticketTitle' => $ticketTitle,
            'ticketDescription' => $ticketDescription,
            'status' => 1,
        );
        if ($this->db->insert('mobil_ticket', $data)) {
            $this->db->trans_complete();
            return [
                'status'=>1,
                'message'=>'Destek Talebiniz Başarılı İle Oluşturuldu Yakın Zamanda Sizinle İletişime Geçilecektir.',
            ];
        }
        else {
            $this->db->trans_rollback();
            return [
                'status'=>0,
                'message'=>'Talep Oluşturulurken Hata Aldınız',

            ];
        }


    }
    public function malzeme_talep_list($user_id,$tip)
    {
        $tip_select='"MtMalzemeTalepDetailsScreen" as route,';
        if($tip==99){
            $tip_select='"MTAvansTalepDetailScreen" as route,';
        }

        $auth_id = $user_id;
        $this->db->select('talep_form.*,geopos_employees.name as pers_name,
        progress_status.name as progress_name,
        talep_form_status.color as color,geopos_projects.code as proje_name,
        '.$tip_select.'
        talep_form_status.sort_name as st_name');
        $this->db->from('talep_form');
        $this->db->join('geopos_employees','talep_form.talep_eden_user_id=geopos_employees.id');
        $this->db->join('progress_status','talep_form.progress_status_id=progress_status.id');
        $this->db->join('geopos_projects','talep_form.proje_id=geopos_projects.id','LEFT');
        $this->db->join('talep_form_status','talep_form.status=talep_form_status.id');
        if($tip==1){
            $this->db->join('talep_onay_new','talep_form.id=talep_onay_new.talep_id');
        }
        elseif($tip==99){
            $this->db->join('talep_form_avans','talep_form.id=talep_form_avans.talep_id');
            $this->db->join('talep_form_avans_sort','talep_form_avans.id=talep_form_avans_sort.talep_form_avans_id');
        }

        $this->db->where('talep_form.loc', 5);
        if($tip==1){
            $this->db->where("talep_onay_new.type",1);
            $this->db->where("talep_onay_new.staff",1);
            $this->db->where("talep_form.status",1);
            $this->db->where("talep_onay_new.user_id",$auth_id);
        }
        elseif($tip==99){
            $this->db->where("talep_form_avans.status_id",1);
            $this->db->where("talep_form_avans_sort.staff_status",0);
            $this->db->where("talep_form_avans_sort.staff",1);
            $this->db->where("talep_form_avans_sort.staff_id",$auth_id);
            $this->db->where("talep_form.status",18);
        }

        $talep_type_not = [105,106,107,108,109,110,111,112,113];
        if(!in_array($tip,$talep_type_not)){
            $this->db->where("talep_form.talep_type",1);
        }
        else {
            $this->db->where("talep_form.talep_type",2);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function hizmet_talep_list($user_id,$tip)
    {
        $tip_select='"HizmetTalepDetailsScreen" as route,';
        if($tip==99){
            $tip_select='"MTAvansTalepDetailScreen" as route,';
        }

        $auth_id = $user_id;
        $this->db->select('talep_form.*,geopos_employees.name as pers_name,
        progress_status.name as progress_name,
        talep_form_status.color as color,geopos_projects.code as proje_name,
        '.$tip_select.'
        talep_form_status.sort_name as st_name');
        $this->db->from('talep_form');
        $this->db->join('geopos_employees','talep_form.talep_eden_user_id=geopos_employees.id');
        $this->db->join('progress_status','talep_form.progress_status_id=progress_status.id');
        $this->db->join('geopos_projects','talep_form.proje_id=geopos_projects.id','LEFT');
        $this->db->join('talep_form_status','talep_form.status=talep_form_status.id');
        if($tip==1){
            $this->db->join('talep_onay_new','talep_form.id=talep_onay_new.talep_id');
        }
        $this->db->where('talep_form.loc', 5);
        if($tip==1){
            $this->db->where("talep_onay_new.type",1);
            $this->db->where("talep_onay_new.staff",1);
            $this->db->where("talep_form.status",1);
            $this->db->where("talep_onay_new.user_id",$auth_id);
        }
        $this->db->where("talep_form.talep_type",2);
        $query = $this->db->get();
        return $query->result();
    }

    public function malzeme_talep_view($user_id,$id,$tip)
    {
        $this->load->model('malzemetalep_model', 'talep');
        $data['details']= $this->talep->details($id);
        $data['proje_code']= proje_code($data['details']->proje_id);
        $data['proje_bolum']= bolum_getir($data['details']->bolum_id);
        $data['proje_asama']= task_to_asama($data['details']->asama_id);
        $data['teslimat_yeri']= warehouse_details($data['details']->warehouse_id)->title;
        $data['talep_tarihi']= dateformat_new($data['details']->created_at);
        $data['talep_eden_personel']= personel_details($data['details']->aauth);
        $data['talep_durumu']  =  talep_form_status_details($data['details']->status)->name;
        $data['code']  =  $data['details']->code;
        $data['dec']  =  $data['details']->desc;
        $data['avans_details']=[];


        if($tip==1){
            $onay_details = $this->db->query("SELECT * FROM talep_onay_new Where talep_id=$id and type=1 and user_id=$user_id and staff=1 and status is null ")->row();
            $data['sort_val']=$onay_details->sort;
            $data['type_val']=1;
            $data['satinalma_pers_name_id']= $this->talep->talep_user_satinalma($id)->user_id;
        }
        if($tip==99){

            $teklif_avans_kontrol = teklif_avans_kontrol($id);
            if($teklif_avans_kontrol){
                foreach($teklif_avans_kontrol as $avas_items){
                    $details_avans = teklif_avans_details($avas_items);
                    $cari_name = customer_details($details_avans['cari_id'])['company'];
                    $toplam_tutar = $details_avans['toplam_tutar'];
                    $talep_form_avans_id = avans_odeme_kontrol_details($id,1,$details_avans['cari_id'])->id;
                    $data['avans_details'][]=[
                        'cariname'=>$cari_name,
                        'toplam_tutar'=>amountFormat($toplam_tutar),
                        'talep_form_avans_id'=>$talep_form_avans_id,

                    ];

                }
            }
        }
        $data['satinalma_pers_name']= personel_details($this->talep->talep_user_satinalma($id)->user_id);


        $items= $this->talep->product_details($id);
        foreach ($items as $item){

            $image='https://muhasebe.makro2000.com.tr/'.product_full_details_parent($item->product_stock_code_id,$item->product_id)['image'];

            $data['items'][]=
                [
                    'id'=>$item->id,
                    'material'=>$item->product_name,
                    'image'=>$image,
                    'quantity'=>$item->product_qty.' '.$item->unit_name,
                    'variant'=>talep_form_product_options_new_mobil($item->product_stock_code_id)
                ];
        }
        return $data;
    }


    public function hizmet_talep_view($user_id,$id,$tip)
    {
        $this->load->model('malzemetalep_model', 'talep');
        $data['details']= $this->talep->details($id);
        $data['proje_code']= proje_code($data['details']->proje_id);
        $data['proje_bolum']= bolum_getir($data['details']->bolum_id);
        $data['proje_asama']= task_to_asama($data['details']->asama_id);
        $data['teslimat_yeri']= personel_details($data['details']->warehouse_id);
        $data['talep_tarihi']= dateformat_new($data['details']->created_at);
        $data['talep_eden_personel']= personel_details($data['details']->aauth);
        $data['talep_durumu']  =  talep_form_status_details($data['details']->status)->name;
        $onay_details = $this->db->query("SELECT * FROM talep_onay_new Where talep_id=$id and type=1 and user_id=$user_id and staff=1 and status is null ")->row();
        $data['sort_val']=$onay_details->sort;
        $data['type_val']=1;
        if($this->talep->talep_user_satinalma($id)){
            $data['satinalma_pers_name_id']= $this->talep->talep_user_satinalma($id)->user_id;
        }
        else {
            $data['satinalma_pers_name_id']=0;
        }


        $this->db->select('talep_form_products.*,demirbas_group.name as product_name,geopos_units.name as unit_name');
        $this->db->from('talep_form_products');
        $this->db->join('demirbas_group','talep_form_products.product_id=demirbas_group.id');
        $this->db->join('geopos_units','talep_form_products.unit_id=geopos_units.id','LEFT');
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        $items =  $query->result();

        foreach ($items as $item){
            $data['items'][]=
                [
                    'id'=>$item->id,
                    'material'=>$item->product_name,
                    'quantity'=>$item->product_qty.' '.$item->unit_name,
                ];
        }
        return $data;
    }


    public function allcount($user_id)
    {

        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $data = array(
            'id' => $user_id,
            'loggedin' => TRUE,
            'user_new_id' => '½'.$rows->id.'½',
        );

        $this->session->set_userdata($data);
        $this->session->set_userdata('set_firma_id',$rows->loc);


        $count=
            $this->nakliye_onay_list_count(1,$user_id,1)+ //bekleyen nakliye onayları
            $this->nakliye_onay_list_count(2,$user_id,3)+ //bekleyen nakliye onayları
            count_kasa_func()+
            beklyen_malzeme_count_func()+
            razi_count_func()+
            forma2_new_count_func()+
            cari_gider_onay_count()+
            cari_avans_onay_count()+
            bekleyentask_func()+
            bekleyen_hizmet_count_func()+
            $this->personel_izin_count($user_id)+
            $this->personel_gider_list_count($user_id);

        return [
            'status'=>1,
            'count'=>$count,
            'cari_bildirimleri'=>razi_count_func()+forma2_new_count_func()+cari_gider_onay_count()+cari_avans_onay_count(),
            'personel_bildirimleri'=>bekleyentask_func()+$this->personel_gider_list_count($user_id)+$this->personel_izin_count($user_id),
            'razi_count'=>razi_count_func(),
            'personel_task_count'=>bekleyentask_func(),
            'finans_bildirimleri'=>count_kasa_func(),
            'kasa_count'=>count_kasa_func(),
            'forma2_count'=>forma2_new_count_func(),
            'cari_gider_onay_count'=>cari_gider_onay_count(),
            'cari_avans_onay_count'=>cari_avans_onay_count(),

            'malzeme_talep_bildirimi_all'=>beklyen_malzeme_count_func(),
            'mt_avans_talep_bildirimi'=>avanslistcount_func(),
            'mt_odeme_talep_bildirimi'=>odemelistcountnew_func(),
            'mt_talep_bildirimi'=>beklyen_malzeme_count_func(),

            'ht_onay_beklyen'=>bekleyen_hizmet_count_func(),

            'nakliye_onaylari'=> $this->nakliye_onay_list_count(1,$user_id,1)+$this->nakliye_onay_list_count(2,$user_id,3), //bekleyen nakliye onayları
            'nakliye_talep_onayi'=> $this->nakliye_onay_list_count(1,$user_id,1), //bekleyen nakliye onayları
            'nakliye_satinalma_talep_onayi'=> $this->nakliye_onay_list_count(2,$user_id,3), //bekleyen nakliye onayları


            'personel_permit_count'=> $this->personel_izin_count($user_id),
            'personel_gider_list_count'=> $this->personel_gider_list_count($user_id),

        ];
    }

    public function personel_izin_count($user_id)
    {
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $this->db->select('upc.*,user_permit.user_id,geopos_employees.name as pers_name,user_permit.code');
        $this->db->from('user_permit_confirm upc');
        $this->db->join('user_permit','upc.user_permit_id=user_permit.id');
        $this->db->join('geopos_employees','geopos_employees.id=user_permit.user_id');
        $this->db->where('upc.staff_id',$user_id);
        $this->db->where('upc.staff_status',null);
        $this->db->where('upc.sort=(SELECT MIN(sort) From user_permit_confirm Where `user_permit_confirm`.`staff_status` IS NULL and upc.user_permit_id =user_permit_confirm.user_permit_id )');
        $this->db->where('user_permit.status',0);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('user_permit.loc =', $rows->loc); //2019-11-23 14:28:57
        }
        $this->db->group_by('upc.user_permit_id');
        $query = $this->db->get();
        if($query->num_rows()){
            return $query->num_rows();
        }
        else {
            return 0;
        }
    }

    public function count_filtered_talep($start,$length,$tip,$user_id)
    {
        $this->_get_datatables_query_details_talep_list($tip,$user_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function cari_gider_onay_list($user_id)
    {

        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $data = array(
            'id' => $user_id,
            'loggedin' => TRUE,
            'user_new_id' => '½'.$rows->id.'½',
        );

        $this->session->set_userdata($data);
        $this->session->set_userdata('set_firma_id',$rows->loc);


        $auth_id = $user_id;
        $loc = $rows->loc;

        $this->db->select('talep_form_customer_new.*,
        geopos_employees.name as pers_name,
        "CariGiderDetailsScreen" as route,
        progress_status.name as progress_name,
        "carigidertalepnew" as href,
        talep_form_status.color as color,
        geopos_projects.code as proje_name,talep_form_status.name as st_name,geopos_customers.company');
        $this->db->from('talep_form_customer_new');
        $this->db->join('geopos_employees','talep_form_customer_new.talep_eden_user_id=geopos_employees.id');
        $this->db->join('geopos_customers','talep_form_customer_new.cari_id=geopos_customers.id');
        $this->db->join('progress_status','talep_form_customer_new.progress_status_id=progress_status.id');
        $this->db->join('geopos_projects','talep_form_customer_new.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_customer_new.status=talep_form_status.id');
        $this->db->join('talep_onay_customer_new','talep_form_customer_new.id=talep_onay_customer_new.talep_id');
        $this->db->where("talep_onay_customer_new.type",1);
        $this->db->where("talep_onay_customer_new.staff",1);
        $this->db->where("talep_onay_customer_new.user_id",$auth_id);
        $this->db->where('talep_form_customer_new.status',1);
        $this->db->where('talep_form_customer_new.loc =', $loc); //2019-11-23 14:28:57
        $this->db->order_by('`talep_form_customer_new`.`id` ASC');

        $query = $this->db->get();
        return $query->result();

    }

    public function create_permit($user_id,$permit_type,$start_date,$end_date,$description)
    {
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $data = array(
            'id' => $user_id,
            'loggedin' => TRUE,
            'user_new_id' => '½'.$rows->id.'½',
        );

        $this->session->set_userdata($data);
        $this->session->set_userdata('set_firma_id',$rows->loc);


        $kalan_mezuniyet = mezuniyet_report($user_id)['mezuniyet_kalan_number'];

        $new_start_date = $this->date_db($start_date);
        $new_end_date = $this->date_db($end_date);


        $gun_farki = intval($this->daysBetween($new_start_date,$new_end_date));
        $gun_farki_n=intval($gun_farki)+1;

        if($permit_type==1){
            if(intval($gun_farki_n) <= intval($kalan_mezuniyet)){
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
                    $user_name = $this->db->query("Select * from geopos_employees Where id = $user_id")->row()->name;

                    $id = $last_id;
                    $details = $this->details_permit($id);
                    $code = $details->code;
                    if($user_id==$details->user_id){
                        $this->db->set('bildirim_durumu',1, FALSE);
                        $this->db->where('id', $id);
                        if( $this->db->update('user_permit')){
                            $pers_id = $details->user_id;
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
                                        numaric_update(27);
                                        $this->aauth->applog("İzin Talebi Bildirimi Başlatılmıştır : ".$code, $user_name);
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
            $new_start_date = $this->date_db($start_date);
            $new_end_date = $this->date_db($end_date);
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
                $user_name = $this->db->query("Select * from geopos_employees Where id = $user_id")->row()->name;

                $id = $last_id;
                $details = $this->details_permit($id);
                $code = $details->code;
                if($user_id==$details->user_id){
                    $this->db->set('bildirim_durumu',1, FALSE);
                    $this->db->where('id', $id);
                    if( $this->db->update('user_permit')){
                        $pers_id = $details->user_id;
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
                                    numaric_update(27);
                                    $this->aauth->applog("İzin Talebi Bildirimi Başlatılmıştır : ".$code, $user_name);
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
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız',
                    'id'=>0
                ];
            }
        }

    }
    public function create_avans($talep_eden_user_id,$fiyat,$paymentMethod,$desc)
    {

        $this->db->trans_start();
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$talep_eden_user_id)->row();
        $data = array(
            'id' => $talep_eden_user_id,
            'loggedin' => TRUE,
            'user_new_id' => '½'.$rows->id.'½',
        );

        $this->session->set_userdata($data);
        $this->session->set_userdata('set_firma_id',$rows->loc);

        $loc_id = $rows->loc;


        $progress_status_id = 1;
        $proje_id  = $this->db->query("SELECT * FROM personel_salary Where personel_id=$talep_eden_user_id and status=1")->row()->proje_id;
        $method = $paymentMethod;
        $personel_id = $talep_eden_user_id;

        if($talep_eden_user_id==522){ // Hacıali
            $talep_no = numaric(5);
            $data = array(
                'code' => $talep_no,
                'progress_status_id' => $progress_status_id,
                'talep_eden_user_id' => $talep_eden_user_id,
                'personel_id' => $personel_id,
                'method' => $method,
                'proje_id' => $proje_id,
                'desc' => $desc,
                'tip' => 2,
                'loc' =>  $loc_id,
                'aauth' => $personel_id
            );
            if ($this->db->insert('talep_form_personel', $data)) {
                $last_id = $this->db->insert_id();
                numaric_update(5);

                $data = array(
                    'cost_id' => 170,
                    'progress_status_id' => 3,
                    'product_desc' => "Avans Talebi",
                    'product_kullanim_yeri' => "Maaş",
                    'product_temin_date'=> date('Y-m-d'),
                    'unit_id' => 9,
                    'product_qty' => 1,
                    'price' => $fiyat,
                    'total' => floatval($fiyat)*floatval((1)),
                    'form_id' => $last_id,
                    'aauth' => $personel_id
                );
                if ($this->db->insert('talep_form_personel_products', $data)) {
                    $product_name= cost_details(170)->name;
                    $unit_name = units_(9)['name'];
                    $this->talep_history($last_id,$personel_id,'Avans Eklendi : '.$product_name.' | 1 '.$unit_name,null,'personel_talep_history');
                }
                $this->aauth->applog("Personel Avans Talebi Oluşturuldu  : Talep No : ".$talep_no, $rows->username);

                if($this->avans_talep_bildirim_baslat($last_id,$personel_id)['status']){
                    $this->db->trans_complete();
                    return [
                        'status'=>1,
                        'id'=>$last_id,
                        'message'=>"Başarılı Bir Şekilde Talep Oluşturuldu",
                    ];
                }
                else {
                    $this->db->trans_rollback();
                       return [
                           'status'=>0,
                           'id'=>$last_id,
                           'message'=>$this->avans_talep_bildirim_baslat($last_id,$personel_id)['mesaj']
                       ];
                }


            }
            else {
                $this->db->trans_rollback();
                return [
                    'status'=>0,
                    'id'=>0,
                    'message'=>'Hata Aldınız.'
                ];
            }
        }
        else {
            $talep_kontrol = talep_avans_kontrol($personel_id);
            if($talep_kontrol['status']){
                $aylik_tutar_kontrol=aylik_kalan_tutar($personel_id);
                $tutar = $aylik_tutar_kontrol['tutar'];
                if($aylik_tutar_kontrol['status']){
                    if($fiyat<=$tutar){
                        $talep_no = numaric(5);
                        $data = array(
                            'code' => $talep_no,
                            'progress_status_id' => $progress_status_id,
                            'talep_eden_user_id' => $talep_eden_user_id,
                            'personel_id' => $personel_id,
                            'method' => $method,
                            'proje_id' => $proje_id,
                            'desc' => $desc,
                            'tip' => 2,
                            'loc' =>  $loc_id,
                            'aauth' => $personel_id
                        );
                        if ($this->db->insert('talep_form_personel', $data)) {
                            $last_id = $this->db->insert_id();
                            numaric_update(5);

                            //items ekleme

                            $data = array(
                                'cost_id' => 170,
                                'progress_status_id' => 3,
                                'product_desc' => "Avans Talebi",
                                'product_kullanim_yeri' => "Maaş",
                                'product_temin_date'=> date('Y-m-d'),
                                'unit_id' => 9,
                                'product_qty' => 1,
                                'price' => $fiyat,
                                'total' => floatval($fiyat)*floatval((1)),
                                'form_id' => $last_id,
                                'aauth' => $personel_id
                            );
                            if ($this->db->insert('talep_form_personel_products', $data)) {
                                $product_name= cost_details(170)->name;
                                $unit_name = units_(9)['name'];
                                $this->talep_history($last_id,$personel_id,'Avans Eklendi : '.$product_name.' | 1 '.$unit_name,null,'personel_talep_history');
                            }
                            //items ekleme

                            $this->aauth->applog("Avans Talebi Oluşturuldu  : Talep No : ".$talep_no, $rows->username);

                            if($this->avans_talep_bildirim_baslat($last_id,$personel_id)['status']){
                                $this->db->trans_complete();
                                return [
                                    'status'=>1,
                                    'id'=>$last_id,
                                    'message'=>"Başarılı Bir Şekilde Talep Oluşturuldu",
                                ];
                            }
                            else {
                                $this->db->trans_rollback();
                                return [
                                    'status'=>0,
                                    'id'=>$last_id,
                                    'message'=>$this->avans_talep_bildirim_baslat($last_id,$personel_id)['mesaj']
                                ];
                            }



                        }
                        else {
                            $this->db->trans_rollback();
                            return [
                                'status'=>0,
                                'id'=>0,
                                'message'=>'Hata Aldınız'
                            ];

                        }
                    }
                    else {

                        $this->db->trans_rollback();
                        return [
                            'status'=>0,
                            'id'=>0,
                            'message'=>$aylik_tutar_kontrol['mesaj'].' : '.$aylik_tutar_kontrol['tutar']
                        ];
                    }
                }
                else {


                    $this->db->trans_rollback();
                    return [
                        'status'=>0,
                        'id'=>0,
                        'message'=>'Artık Siz Talep Oluşturamazsınız! Sorumlu Personelizden İzin Talep Ediniz.Sonra IT Destek Alınız'
                    ];

                }

            }
            else {
                $this->db->trans_rollback();
                return [
                    'status'=>0,
                    'id'=>0,
                    'message'=>$talep_kontrol['message']
                ];
            }
        }



    }

    public function create_nakliye($user_id,$talep_eden_user_id,$proje_id,$lokasyon,$desc,$yukleme_yapacak_cari_id,$product_desc)
    {
        $this->db->trans_start();
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$talep_eden_user_id)->row();
        $data = array(
            'id' => $talep_eden_user_id,
            'loggedin' => TRUE,
            'user_new_id' => '½'.$rows->id.'½',
        );

        $this->session->set_userdata($data);
        $this->session->set_userdata('set_firma_id',$rows->loc);

        $loc_id = $rows->loc;
        $progress_status_id = 1;

        $method = 0;
        $cari_id = 0;
        $talep_no = numaric(14);
        $data = array(
            'code' => $talep_no,
            'progress_status_id' => $progress_status_id,
            'talep_eden_user_id' => $talep_eden_user_id,
            'cari_id' => $cari_id,
            'method' => $method,
            'proje_id' => $proje_id,
            'desc' => $desc,
            'loc' =>  $loc_id,
            'aauth' => $user_id
        );
        if ($this->db->insert('talep_form_nakliye', $data)) {
            $form_id = $this->db->insert_id();
            numaric_update(14);
            $this->aauth->applog("Nakliye Talebi Oluşturuldu  : Talep No : ".$talep_no, $rows->name);

            $nakliye_item_tip=3;
            $data = array(
                'product_desc' => $product_desc,
                'code' => numaric(43),
                'lokasyon' => $lokasyon,
                'unit_id' => 9,
                'nakliye_item_tip' => $nakliye_item_tip,
                'yukleme_yapacak_cari_id' => $yukleme_yapacak_cari_id,
                'form_id' => $form_id,
                'aauth' => $user_id
            );
            if ($this->db->insert('talep_form_nakliye_products', $data)) {
                numaric_update(43);
                $this->talep_history($form_id,$user_id,'İtem Eklendi. ',null,'talep_form_nakliye_history');
                $this->aauth->applog("Nakliye Talebine Ürünler Eklendi  : Talep ID : ".$form_id, $rows->name);



                $type = 1;
                $details =$this->db->query("SELECT * FROM talep_form_nakliye Where id = $form_id")->row();
                $data = array(
                    'bildirim_durumu' => 1,
                );
                $this->db->set($data);
                $this->db->where('id', $form_id);
                if ($this->db->update('talep_form_nakliye', $data)) {

                    $users_ = onay_sort(11,$details->proje_id);
                    if($users_){
                        foreach ($users_ as $items){
                            $staff=0;
                            if($items['sort']==1){
                                $staff=1;
                            }
                            $data_onay = array(
                                'talep_id' => $form_id,
                                'type' => $type,
                                'staff' => $staff,
                                'sort' => $items['sort'],
                                'user_id' => $items['user_id'],
                            );
                            $this->db->insert('talep_onay_nakliye', $data_onay);
                        }

                        $this->talep_history($form_id,$user_id,'Onay İşlemi Başlatıldı. ',null,'talep_form_nakliye_history');
                        $this->aauth->applog("Nakliye Talebinde Bildirim Başlatıldı :  ID : ".$form_id, $rows->username);
                        $this->db->trans_complete();
                        return [
                            'status'=>1,
                            'message'=>'Başarılı Bir Şekilde Talep Oluşturuldu.Ana sayfaya Yönlendiriliceksiniz'
                        ];

                    }
                    else {

                        $this->db->trans_rollback();
                        return [
                            'status'=>0,
                            'message'=>'Projenize Yetkili Kişiler Atanmamıştır.Bu Sebeple İşlem Yapamazsınız.'
                        ];
                    }
                }
                else {
                    $this->db->trans_rollback();
                    return [
                        'status'=>0,
                        'message'=>'bildirim Başlatılırken Hata Aldınız.'
                    ];
                }
            }
            else {
                $this->db->trans_rollback();
                return [
                    'status'=>0,
                    'message'=>'Teknika eklenirken hata aldınız.'
                ];
            }

        }
        else {
            $this->db->trans_rollback();
            return [
                'status'=>0,
                'message'=>'Talep Oluşturulurken Hata Aldınız'
            ];
        }
    }

    public function avans_talep_bildirim_baslat($id,$user_id)
    {
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();

        $this->db->trans_start();
        $talep_kontrol  = $this->db->query("SELECT * FROM `talep_form_personel` where id=$id and aauth=$user_id")->num_rows();
        if($talep_kontrol){
            $details =$this->db->query("SELECT * FROM `talep_form_personel` where id=$id")->row();
            $data = array(
                'bildirim_durumu' => 1,
            );
            $this->db->set($data);
            $this->db->where('id', $id);
            if ($this->db->update('talep_form_personel', $data)) {

                $users_ = onay_sort(5,$details->proje_id,$details->personel_id);
                if($users_){
                    foreach ($users_ as $items){
                        $staff=0;
                        if($items['sort']==1){
                            $staff=1;
                        }
                        $data_onay = array(
                            'talep_id' => $id,
                            'type' => 1,
                            'staff' => $staff,
                            'sort' => $items['sort'],
                            'user_id' => $items['user_id'],
                        );
                        $this->db->insert('talep_onay_personel_new', $data_onay);
                    }


                    $this->talep_history($id,$user_id,'Onay işemi Başlatıldı',null,'personel_talep_history');
                    $this->aauth->applog("Avans Talebinde Bildirim Başlatıldı :  ID : ".$id, $rows->name);
                    $this->db->trans_complete();

                    return [
                        'status'=>1,
                        'mesaj'=>"Başarıyla Bildirim Başlatıldı",
                    ];

                }
                else {
                    $this->db->trans_rollback();
                    return [
                        'status'=>1,
                        'mesaj'=>"Projenize Yetkili Kişiler Atanmamıştır.Bu Sebeple İşlem Yapamazsınız",
                    ];



                }



            }
            else {

                $this->db->trans_rollback();
                return [
                    'status'=>1,
                    'mesaj'=>"Hata Aldınız.Lütfen Yöneyiciye Başvurun",
                ];

            }

        }
        else {

            $this->db->trans_rollback();
            return [
                'status'=>1,
                'mesaj'=>"Yetkiniz Bulunmamaktadır.",
            ];
        }
    }

    public function task_status_update($user_id,$status,$id,$text)
    {
        $this->db->trans_start();
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $details = $this->personel_task_details($id);
        $code = $details->code;
        $this->db->set('status',$status, FALSE);
        $this->db->where('id', $id);
        if( $this->db->update('personel_task')){
            $data = [
                'desc'=>$text,
                'task_id'=>$id,
                'status'=>$status,
                'aauth_id'=>$user_id,
            ];
            if($this->db->insert('personel_task_action', $data)){

                $this->aauth->applog("Personel Görev Düzenlemesi Yaptı :  ID : ".$id, $rows->name);
                $this->db->trans_complete();

                return [
                    'status'=>1,
                    'message'=>"Başarıyla Bildirim Başlatıldı",
                ];
            }
            else {
                $this->db->trans_rollback();
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız',

                ];
            }

        }
    }

    public function personel_task_details($id){
        $this->db->from('personel_task');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function personel_gider_list($user_id)
    {
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $data = array(
            'id' => $user_id,
            'loggedin' => TRUE,
            'user_new_id' => '½'.$rows->id.'½',
        );

        $this->session->set_userdata($data);
        $this->session->set_userdata('set_firma_id',$rows->loc);
        $auth_id = $user_id;
        $loc = $rows->loc;
        $this->db->select('talep_form_personel.*,geopos_employees.name as pers_name,progress_status.name as progress_name,
         "GiderDetailsScreen" as route,
        talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name');
        $this->db->from('talep_form_personel');
        $this->db->join('geopos_employees','talep_form_personel.talep_eden_user_id=geopos_employees.id');
        $this->db->join('progress_status','talep_form_personel.progress_status_id=progress_status.id');
        $this->db->join('geopos_projects','talep_form_personel.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_personel.status=talep_form_status.id');
        $this->db->join('talep_onay_personel_new','talep_form_personel.id=talep_onay_personel_new.talep_id');
        $this->db->where("talep_onay_personel_new.type",1);
        $this->db->where("talep_onay_personel_new.staff",1);
        $this->db->where("talep_onay_personel_new.user_id",$auth_id);
        $this->db->where('talep_form_personel.tip',1);
        $this->db->where('talep_form_personel.status!=',10);
        $this->db->where('talep_form_personel.loc =', $loc); //2019-11-23 14:28:57
        $query = $this->db->get();
        return $query->result();

    }

    public function personel_gider_list_count($user_id)
    {
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $data = array(
            'id' => $user_id,
            'loggedin' => TRUE,
            'user_new_id' => '½'.$rows->id.'½',
        );

        $this->session->set_userdata($data);
        $this->session->set_userdata('set_firma_id',$rows->loc);
        $auth_id = $user_id;
        $loc = $rows->loc;
        $this->db->select('talep_form_personel.*,geopos_employees.name as pers_name,progress_status.name as progress_name,
        talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name');
        $this->db->from('talep_form_personel');
        $this->db->join('geopos_employees','talep_form_personel.talep_eden_user_id=geopos_employees.id');
        $this->db->join('progress_status','talep_form_personel.progress_status_id=progress_status.id');
        $this->db->join('geopos_projects','talep_form_personel.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_personel.status=talep_form_status.id');
        $this->db->join('talep_onay_personel_new','talep_form_personel.id=talep_onay_personel_new.talep_id');
        $this->db->where("talep_onay_personel_new.type",1);
        $this->db->where("talep_onay_personel_new.staff",1);
        $this->db->where("talep_onay_personel_new.user_id",$auth_id);
        $this->db->where('talep_form_personel.tip',1);
        $this->db->where('talep_form_personel.status!=',10);
        $this->db->where('talep_form_personel.loc =', $loc); //2019-11-23 14:28:57
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function account_virman_list($user_id)
    {
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $this->db->select('v.*,  "AccountVirmanDetailsScreen" as route,virman_onay.id as virman_onay_id');
        $this->db->from('virman_onay');
        $this->db->join('virman v','virman_onay.virman_id = v.id');
        $this->db->where('virman_onay.user_id',$user_id);
        $this->db->where('virman_onay.staff',1);
        $this->db->where('virman_onay.status is null');
        $this->db->where('v.loc',$rows->loc);
        $query = $this->db->get();
        return $query->result();

    }

    public function virman_details($id)
    {
        $this->db->select('*');
        $this->db->from('virman');
        $this->db->where('id',$id);
        $query = $this->db->get();
        $virman_details =  $query->row();
        return $virman_details;
    }

    public function virman_view($user_id,$talep_id)
    {
        $this->db->select('*');
        $this->db->from('virman');
        $this->db->where('id',$talep_id);
        $query = $this->db->get();
        $virman_details =  $query->row();

        $data['code']=$virman_details->code;
        $data['istek_yapan_kasa']=account_details($virman_details->in_account_id)->holder;
        $data['hedef_kasa']=account_details($virman_details->out_account_id)->holder;
        $data['istek_zamani']=$virman_details->created_at;
        $data['aciklama']=$virman_details->desc;
        $data['transfer_miktari_num']=$virman_details->in_price;
        $data['transfer_miktari']=amountFormat($virman_details->in_price);

        return $data;



    }

    public function details_permit($id){
        $this->db->select('*');
        $this->db->from('user_permit');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function date_db($originalDate)
    {
        $date = DateTime::createFromFormat('m/d/Y, H:i:s', $originalDate);

// Yeni formatta tarih
        $formattedDate = $date->format('Y-m-d H:i:s');

        return $formattedDate;
    }
    public function daysBetween($dt1, $dt2) {
        return date_diff(
            date_create($dt2),
            date_create($dt1)
        )->format('%a');
    }
    public function cari_avans_onay_list($user_id)
    {

        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $data = array(
            'id' => $user_id,
            'loggedin' => TRUE,
            'user_new_id' => '½'.$rows->id.'½',
        );

        $this->session->set_userdata($data);
        $this->session->set_userdata('set_firma_id',$rows->loc);
        $auth_id = $user_id;
        $loc=$rows->loc;
        $this->db->select('talep_form_customer.*,
         "CariAvansDetailsScreen" as route,
        geopos_employees.name as pers_name,progress_status.name as progress_name,
        talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name,geopos_customers.company');
        $this->db->from('talep_form_customer');
        $this->db->join('geopos_employees','talep_form_customer.talep_eden_user_id=geopos_employees.id');
        $this->db->join('geopos_customers','talep_form_customer.cari_id=geopos_customers.id');
        $this->db->join('progress_status','talep_form_customer.progress_status_id=progress_status.id');
        $this->db->join('geopos_projects','talep_form_customer.proje_id=geopos_projects.id');
        $this->db->join('talep_form_status','talep_form_customer.status=talep_form_status.id');
        $this->db->join('talep_onay_customer_new','talep_form_customer.id=talep_onay_customer_new.talep_id');
        $this->db->where("talep_form_customer.type",2);
        $this->db->where("talep_onay_customer_new.staff",1);
        $this->db->where("talep_onay_customer_new.user_id",$auth_id);
        $this->db->where("talep_onay_customer_new.type",2);
        $this->db->where('talep_form_customer.status',1);
        $this->db->where('talep_form_customer.loc =', $loc); //2019-11-23 14:28:57
        $query = $this->db->get();
        return $query->result();

    }


    public function cari_protokol_onay_list($user_id)
    {

        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $data = array(
            'id' => $user_id,
            'loggedin' => TRUE,
            'user_new_id' => '½'.$rows->id.'½',
        );

        $this->session->set_userdata($data);
        $this->session->set_userdata('set_firma_id',$rows->loc);


        $auth_id = $user_id;
        $this->db->select('cari_razilastirma.*,
           "ProtokolDetailsScreen" as route,
        geopos_projects.name as proje_name,geopos_account_type.name as odeme_sekli_name,odeme_tipi_razilastirma.name as odeme_tipi_name,razilastirma_onay.status');
        $this->db->from('cari_razilastirma');
        $this->db->join('razilastirma_onay','cari_razilastirma.id=razilastirma_onay.razilastirma_id');
        $this->db->join('odeme_tipi_razilastirma','cari_razilastirma.odeme_tipi=odeme_tipi_razilastirma.id','LEFT');
        $this->db->join('geopos_customers','cari_razilastirma.cari_id=geopos_customers.id');
        $this->db->join('geopos_account_type','cari_razilastirma.odeme_sekli=geopos_account_type.id','LEFT');
        $this->db->join('geopos_projects','cari_razilastirma.proje_id=geopos_projects.id');
        $this->db->where('razilastirma_onay.staff',1);
        $this->db->where('razilastirma_onay.user_id', $auth_id);
        $this->db->where('razilastirma_onay.status is null');
        $this->db->where_not_in('cari_razilastirma.razi_status',[2,4]);

        if($this->session->userdata('set_firma_id')){
            $this->db->where('cari_razilastirma.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $this->db->order_by('`cari_razilastirma`.`id` ASC');


        $query = $this->db->get();
        return $query->result();

    }

    public function cari_form_list($user_id)
    {
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $data = array(
            'id' => $user_id,
            'loggedin' => TRUE,
            'user_new_id' => '½'.$rows->id.'½',
        );

        $this->session->set_userdata($data);
        $this->session->set_userdata('set_firma_id',$rows->loc);


        $auth_id = $user_id;
        $this->db->select('geopos_invoices.*,
          "FormaDetailsScreen" as route,
        geopos_employees.name as pers_name,invoice_status.name as st_name,geopos_projects.code as proje_name');
        $this->db->from('geopos_invoices');
        $this->db->join('geopos_employees','geopos_invoices.eid=geopos_employees.id','LEFT');
        $this->db->join('geopos_projects','geopos_invoices.proje_id=geopos_projects.id');
        $this->db->join('invoice_status','geopos_invoices.status=invoice_status.id');
        $this->db->join('invoices_onay_new','geopos_invoices.id=invoices_onay_new.invoices_id');
        $this->db->where("invoices_onay_new.type",2);
        $this->db->where("invoices_onay_new.staff",1);
        $this->db->where("geopos_invoices.status!=",3);
        $this->db->where("invoices_onay_new.user_id",$auth_id);
        $this->db->order_by('`geopos_invoices`.`id` DESC');
        $query = $this->db->get();
        return $query->result();
    }


    public function personel_task_list($user_id)
    {
        $this->db->select('personel_task.*,
          "TaskDetailsScreen" as route,
        geopos_employees.name,');
        $this->db->from('personel_task');
        $this->db->join('geopos_employees','personel_task.staff_id=geopos_employees.id');
        $this->db->join('geopos_task_status','personel_task.status=geopos_task_status.id');
        $this->db->join('progress_status','personel_task.progress_status_id=progress_status.id');
        $this->db->where('personel_task.personel_id',$user_id);
        $this->db->where('personel_task.bildirim_durumu',1);
        $this->db->where('personel_task.status IN (1,2)');
        $query = $this->db->get();
        return $query->result();


    }

    public function personel_permit_list($user_id)
    {

        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();

        $this->db->select('upc.*,user_permit.user_id,geopos_employees.name as pers_name,user_permit.code,user_permit.id as talep_id,
          "PermitDetailsScreen" as route,
        ');
        $this->db->from('user_permit_confirm upc');
        $this->db->join('user_permit','upc.user_permit_id=user_permit.id');
        $this->db->join('geopos_employees','geopos_employees.id=user_permit.user_id');
        $this->db->where('upc.staff_id',$user_id);
        $this->db->where('upc.staff_status',null);
        $this->db->where('upc.sort=(SELECT MIN(sort) From user_permit_confirm Where `user_permit_confirm`.`staff_status` IS NULL and upc.user_permit_id =user_permit_confirm.user_permit_id )');
        $this->db->where('user_permit.status',0);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('user_permit.loc =', $rows->loc); //2019-11-23 14:28:57
        }
        $this->db->group_by('upc.user_permit_id');
        $query = $this->db->get();
        if($query->num_rows()){
            return $query->result();
        }
        else {
            return false;
        }
    }

    public function cari_gider_view($user_id,$id)
    {
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $data_new = array(
            'id' => $user_id,
            'loggedin' => TRUE,
            'user_new_id' => '½'.$rows->id.'½',
        );

        $this->session->set_userdata($data_new);
        $this->session->set_userdata('set_firma_id',$rows->loc);


        $this->load->model('Carigidertalepnew_model', 'cari_gider_model');


        $data['details']= $this->cari_gider_model->details($id);
        $data['note_list']=new_list_note(4,$id);
        $odeme_total = $this->cari_gider_model->odeme_total($id);
        $form_total = $this->cari_gider_model->form_total($id);
        $data['kalan']=floatval($form_total)-floatval($odeme_total);
        $items =  $this->cari_gider_model->product_details($id);
        $data['items']=[];
        if($items){
            foreach ($items as $items_value){
                $data['items'][]=[
                    'name'=>$items_value->name,
                    'product_desc'=>$items_value->product_desc,
                    'total_num'=>$items_value->total,
                    'total'=>amountFormat($items_value->total)
                ];
            }

        }



        $data['file_details']= $this->cari_gider_model->file_details($id);
        $data['proje_code']= proje_code($data['details']->proje_id);
        $cari_id = $data['details']->cari_id;
        $methos = $data['details']->method;


        $data['cari_name']= customer_details($cari_id)['company'];
        $data['odeme_metodu']= account_type_sorgu($methos);
        $data['persname']= personel_detailsa($data['details']->talep_eden_user_id)['name'];
        $data['aciklama']= $data['details']->desc;
        $data['code']= $data['details']->code;
        $data['type_val']= $data['details']->type;
        $type=$data['type_val'];

        $sort = $this->db->query("SELECT * FROM talep_onay_customer_new Where talep_id=$id and type=$type and user_id=$user_id and staff=1 and status is null")->row()->sort;
        $data['sort_val']= $sort;
        $toplam_tutar=0;
        foreach ($data['items'] as $details){
            $toplam_tutar+=$details['total_num'];
        }
        $data['odeme_details']=
            [
            'toplam_tutar'=>amountFormat($toplam_tutar),
            'toplam_tutar_float'=>$toplam_tutar,
            'cari'=>customer_details($data['details']->cari_id)['company'],
        ];
        return $data;
    }

    public function cari_avans_view($user_id,$id)
    {
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $data_new = array(
            'id' => $user_id,
            'loggedin' => TRUE,
            'user_new_id' => '½'.$rows->id.'½',
        );

        $this->session->set_userdata($data_new);
        $this->session->set_userdata('set_firma_id',$rows->loc);

        $this->load->model('Customeravanstalep_model', 'cari_gider_model');



        $data['details']= $this->cari_gider_model->details($id);
        $data['note_list']=new_list_note(4,$id);
        $odeme_total = $this->cari_gider_model->odeme_total($id);
        $form_total = $this->cari_gider_model->form_total($id);
        $data['kalan']=floatval($form_total)-floatval($odeme_total);
        $items =  $this->cari_gider_model->product_details($id);
        $data['items']=[];
        if($items){
            foreach ($items as $items_value){
                $data['items'][]=[
                    'name'=>$items_value->name,
                    'product_desc'=>$items_value->product_desc,
                    'total_num'=>$items_value->total,
                    'total'=>amountFormat($items_value->total)
                ];
            }

        }



        $data['file_details']= $this->cari_gider_model->file_details($id);
        $data['proje_code']= proje_code($data['details']->proje_id);


        $cari_id = $data['details']->cari_id;
        $methos = $data['details']->method;


        $data['cari_name']= customer_details($cari_id)['company'];
        $data['odeme_metodu']= account_type_sorgu($methos);
        $data['persname']= personel_detailsa($data['details']->talep_eden_user_id)['name'];
        $data['aciklama']= $data['details']->desc;
        $data['code']= $data['details']->code;
        $data['type_val']= $data['details']->type;
        $type=$data['type_val'];

        $sort = $this->db->query("SELECT * FROM talep_onay_customer_new Where talep_id=$id and type=$type and user_id=$user_id and staff=1 and status is null")->row()->sort;
        $data['sort_val']= $sort;
        $toplam_tutar=0;
        foreach ($data['items'] as $details){
            $toplam_tutar+=$details['total_num'];
        }
        $data['odeme_details']=
            [
                'toplam_tutar'=>amountFormat($toplam_tutar),
                'toplam_tutar_float'=>$toplam_tutar,
                'cari'=>customer_details($data['details']->cari_id)['company'],
            ];
        return $data;
    }

    public function cari_protokol_view($user_id,$id)
    {
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $data_new = array(
            'id' => $user_id,
            'loggedin' => TRUE,
            'user_new_id' => '½'.$rows->id.'½',
        );

        $this->session->set_userdata($data_new);
        $this->session->set_userdata('set_firma_id',$rows->loc);


        $this->load->model('Razilastirma_model', 'razilastirma_model');


        $data['details']= $this->razilastirma_model->details($id);

        $items = $this->db->query("SELECT geopos_todolist.*,cari_razilastirma_item.price,cari_razilastirma_item.qty,cari_razilastirma_item.unit_name FROM cari_razilastirma_item INNER JOIN geopos_todolist ON cari_razilastirma_item.task_id = geopos_todolist.id WHERE razilastirma_id=$id")->result();
        $data['items']=[];
        if($items){
            foreach ($items as $items_value){
                $total = floatval($items_value->price)*floatval($items_value->qty);
                $data['items'][]=[
                    'name'=>$items_value->name,
                    'price_num'=>$items_value->price,
                    'price'=>amountFormat($items_value->price),
                    'qty'=>amountFormat_s($items_value->qty).' '.$items_value->unit_name,
                    'total_num'=>$total,
                    'total'=>amountFormat($total)
                ];
            }

        }

        $data['proje_code']= proje_code($data['details']->proje_id);


        $cari_id = $data['details']->cari_id;
        $methos = $data['details']->odeme_sekli;

        $data['cari_name']= customer_details($cari_id)['company'];
        $data['odeme_metodu']= account_type_sorgu($methos);
        $data['persname']= personel_detailsa($data['details']->user_id)['name'];
        $data['aciklama']= $data['details']->description;
        $data['code']= $data['details']->code;
        $data['file_url']= 'https://muhasebe.makro2000.com.tr/userfiles/product/'.$data['details']->file;

        $toplam_tutar=0;
        foreach ($data['items'] as $details){
            $toplam_tutar+=$details['total_num'];
        }
        $data['toplam_tutar'] =amountFormat($toplam_tutar);
        $data['odeme_details']=
            [
                'toplam_tutar_float'=>$toplam_tutar,
                'cari'=>customer_details($data['details']->cari_id)['company'],
            ];
        return $data;
    }

    public function cari_forma_view($user_id,$id)
    {

        $this->load->model('Invoices_model', 'invoice_model');
        $details =$this->db->query("SELECT * FROM geopos_invoices Where id = $id")->row();
        $data['details']=$details;
        $data['proje_code']=proje_code($details->proje_id);
        $data['cari_name']=customer_details($details->csd)['company'];
        $data['toplam_tutar']=amountFormat($details->total);
        $data['persname']=personel_detailsa($details->eid)['name'];
        $data['notes']=$details->notes;
        $data['invoice_no']=$details->invoice_no;

        $data['items']=[];

        $f_totals=0;
        $items = $this->db->query("SELECT * FROM geopos_invoice_items Where tid = $id")->result();
        foreach ($items as $values){
            $name = $this->db->query("SELECT * FROM geopos_todolist Where id = $values->pid")->row()->name;
            $total = floatval($values->price)*floatval($values->qty);
            $bolum = $this->db->query("SELECT * FROM geopos_project_bolum Where id = $values->bolum_id")->row()->name;
            $asama = $this->db->query("SELECT * FROM geopos_milestones Where id = $values->asama_id")->row()->name;
            $data['items'][]=[
                'name'=>$name,
                'price'=>amountFormat($values->price),
                'qty'=>amountFormat_s($values->qty).' '.units_($values->unit)['name'],
                'total'=>amountFormat($total),
                'asama'=>$asama,
                'bolum'=>$bolum,
            ];

            $f_totals+=$values->subtotal;
        }



        $odeme_total = 0;
        $teminat = 0;
        $ceza_total = 0;
        $prim = 0;
        $temiat_odeme = 0;
        $teminat=0;

        foreach (forma_2_pay_history($id) as  $value) {

            $total_trans = isset($value->total_transaction) ? amountFormat($value->total_transaction) : '';
            $desc = isset($value->invoice_type_desc) ? $value->invoice_type_desc : '';
            $odeme_metodu = isset($value->method) ? account_type_sorgu($value->method) : '';
            $personel = isset($value->eid) ? personel_details($value->eid) : '';
            $notes = isset($value->notes) ? $value->notes : '';
            $date = isset($value->invoicedate) ? $value->invoicedate : '';
            if ($value->invoice_type_id == 55) // Teminat
            {
                $teminat += $value->total_transaction;
            } else if ($value->invoice_type_id == 54 || $value->invoice_type_id == 65) // Ceza
            {
                $ceza_total += $value->total_transaction;
            } else if ($value->invoice_type_id == 57) // Prim
            {
                $prim += $value->total_transaction;
            } else if ($value->invoice_type_id == 61) // Teminat Ödemesi
            {
                $temiat_odeme += $value->total_transaction;
            } else if ($value->invoice_type_id == -1) // Avans parça ödemesi
            {
                $odeme_total += $value->amount;
                $total_trans = amountFormat($value->amount);
                $desc = $value->desc . ' <a target="_blank" href="/transactions/view?id=' . $value->invoice_transaction_id . '" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> Ödeniş Tapşırığı</a>';
                $odeme_metodu = account_type_sorgu($value->method);
                $personel = personel_details($value->aauth_id);
                $notes = '';
                $date = $value->created_at;
            } else { // Ödeme
                $odeme_total += $value->total_transaction;
            }
        }

            $carpim=1;
            $net_total=$f_totals;
            $kdv_new_totoal=$details->tax;
            if($details->taxstatus=='yes'){
                $net_total=(($f_totals)/(1+($details->tax_oran/100)));
                $kdv_new_totoal=$f_totals-$net_total;
                $f_totals=$net_total;
            }


            $total_cikan = $odeme_total  + $teminat + $ceza_total;
            $toplam_hakedis = ($f_totals*$carpim) +($prim*$carpim) +  $kdv_new_totoal;
            $teminat=$teminat-$temiat_odeme;
            $forma2_new_toplam = $net_total-$ceza_total;
            $new_tax_tutar=$forma2_new_toplam*($details->tax_oran/100);
            $kalan = (($forma2_new_toplam)+$prim)-($odeme_total)-$teminat;



        $sort = $this->db->query("SELECT * FROM invoices_onay_new Where invoices_id=$id and type=2 and user_id=$user_id and staff=1 and status is null")->row()->sort;

        $data['form_toplam']=amountFormat($net_total*$carpim);
        $data['kesinti']=amountFormat($ceza_total);
        $data['forma_net_toplam']=amountFormat($forma2_new_toplam);
        $data['kdv_toplam']=amountFormat($new_tax_tutar);
        $data['toplam_hakedis']=amountFormat($forma2_new_toplam+$new_tax_tutar );
        $data['prim_toplami']=amountFormat($prim*$carpim );
        $data['odeme_total']=amountFormat($odeme_total);
        $data['kalan']=amountFormat($kalan);
        $data['sort_val']=$sort;


        return $data;

    }

    public function personel_task_view($user_id,$id)
    {
        $this->db->select('personel_task.*,geopos_employees.name,');
        $this->db->from('personel_task');
        $this->db->join('geopos_employees','personel_task.staff_id=geopos_employees.id');
        $this->db->join('geopos_task_status','personel_task.status=geopos_task_status.id');
        $this->db->join('progress_status','personel_task.progress_status_id=progress_status.id');
        $this->db->where('personel_task.personel_id',$user_id);
        $this->db->where('personel_task.id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function personel_permit_view($user_id,$id_confirm)
    {
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $data_new = array(
            'id' => $user_id,
            'loggedin' => TRUE,
            'user_new_id' => '½'.$rows->id.'½',
        );

        $this->session->set_userdata($data_new);
        $this->session->set_userdata('set_firma_id',$rows->loc);


        $details_permit = $this->db->query("SELECT * FROM user_permit_confirm WHERE id = $id_confirm")->row();

        $id = $details_permit->user_permit_id;
        $details = $this->details_permit($id);
        $user_details = personel_details_full($details->user_id);
        $role_id  = $user_details['roleid'];
        $user_role = $this->db->query("SELECT * FROM geopos_role Where role_id = $role_id")->row()->name;
        $salary_details = $this->db->query("SELECT * FROM personel_salary Where personel_id=$details->user_id and status=1")->row();
        $proje = proje_name($salary_details->proje_id);
//        $result = $this->personel->details_permit_confirm($id);

        $data['start_date']=$details->start_date;
        $data['desc']=$details->description;
        $data['end_date']=$details->end_date;
        $data['creatad_at']=$details->creatad_at;
        $data['personel_name']=$user_details['name'];
        $data['kalan'] = mezuniyet_report($details->user_id)['mezuniyet_kalan_number'];
        $data['permit_type'] = $this->permit_type_get($details->permit_type)->name;
        $data['permit_type_id'] = $details->permit_type;
        $data['all_permit_type'] =$this->permit_type_all_get();

        $this->load->model('personelaction_model','personel_model');

        $result = $this->personel_model->details_permit_confirm($id);
        $data['onay']=[];
        $i=1;
        foreach($result as $items){

             $durum = 'Bekliyor';
             if($items->staff_status==1){
                 $durum = 'Onaylandı';
             }
            $data['onay'][]=
                [
                    'sort'=>$i,
                    'personel_name'=>$items->name,
                    'staff_desc'=>$items->staff_desc,
                    'durum'=>$durum
                ];
            $i++;
        }

        return $data;


    }

    public function personel_gider_view($user_id,$talep_id)
    {
        $data['details']=$this->talep_form_personel_details($talep_id);
        $items = $this->talep_form_personel_details_items($talep_id);
        $data['proje_code'] = proje_code($data['details']->proje_id);
        $methos = $data['details']->method;

        $data['odeme_metodu']= account_type_sorgu($methos);
        $data['persname']= personel_detailsa($data['details']->talep_eden_user_id)['name'];
        $data['aciklama']= $data['details']->desc;
        $data['code']= $data['details']->code;
        $data['type_val']= $data['details']->tip;
        $type=$data['type_val'];


        if($items){
            foreach ($items as $items_value){
                $data['items'][]=[
                    'name'=>$items_value->name,
                    'product_desc'=>$items_value->product_desc,
                    'total_num'=>$items_value->total,
                    'total'=>amountFormat($items_value->total)
                ];
            }

        }

        $sort = $this->db->query("SELECT * FROM talep_onay_personel_new Where talep_id=$talep_id and type=$type and user_id=$user_id and staff=1 and status is null")->row()->sort;
        $data['sort_val']= $sort;
        $toplam_tutar=0;
        foreach ($data['items'] as $details){
            $toplam_tutar+=$details['total_num'];
        }
        $data['odeme_details']=
            [
                'toplam_tutar'=>amountFormat($toplam_tutar),
                'toplam_tutar_float'=>$toplam_tutar,
            ];

        return $data;
    }

    public function talep_form_personel_details($id)
    {
        $this->db->select('*');
        $this->db->from('talep_form_personel');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();

    }
    public function talep_form_personel_details_items($id)
    {
        $this->db->select('talep_form_personel_products.*,demirbas_group.name,geopos_units.name as unit_name');
        $this->db->from('talep_form_personel_products');
        $this->db->join('demirbas_group','talep_form_personel_products.cost_id=demirbas_group.id','LEFT');
        $this->db->join('geopos_units','talep_form_personel_products.unit_id=geopos_units.id');
        $this->db->where('form_id',$id);
        $query = $this->db->get();
        return $query->result();

    }

    public function permit_confirm($user_id,$id_confirm,$status,$deviceModel,$desc,$permit_type)
    {
        $this->db->trans_start();
        $data_update=[
            'staff_status'=>$status,
            'staff_desc'=>$desc,
            'staff_permit_type'=>$permit_type,
            'updated_at'=>'NOW()',
        ];
        $this->db->set($data_update);
        $this->db->where('id',$id_confirm);
        if($this->db->update('user_permit_confirm',$data_update)){
            if($status==1){
                $user_permit_id = $this->db->query("SELECT * FROM user_permit_confirm where id=$id_confirm ")->row()->user_permit_id;
                //Permit Update
                $this->db->set('permit_type', $permit_type);
                $this->db->where('id', $user_permit_id);
                if($this->db->update('user_permit')){
                    $kontrol  = $this->db->query("SELECT * FROM user_permit_confirm where user_permit_id=$user_permit_id and staff_status is null ORDER BY sort LIMIT 1 ");
                    if($kontrol->num_rows()){
                        $this->db->trans_complete();
                        return [
                            'status'=>1,
                            'message'=>'Başarıyla Onayınız İletilmiştir',
                            'id'=>0
                        ];
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
                        $this->send_mail($details->user_id,'İzin Talebi', $messages);
                        $this->db->set('status', $status, FALSE);
                        $this->db->where('id', $user_permit_id);
                        if(	$this->db->update('user_permit')){
                            $this->db->trans_complete();
                            return [
                                'status'=>1,
                                'message'=>'Onay Talebiniz Personele İletilmiştir',
                            ];
                        }

                    }
                }
                else {
                    $this->db->trans_rollback();
                    return [
                        'status'=>0,
                        'message'=>'Onaylanırken Hata aldınız',
                    ];
                }
                //Permit Update
            }
            else {
                $user_permit_id = $this->db->query("SELECT * FROM user_permit_confirm where id=$id_confirm ")->row()->user_permit_id;
                $details = $this->details_permit($user_permit_id);
                $messages='Sayin yetkili İzin Talebiniz İptal Edilmiştir.Açıklama : '.$desc;
                $this->send_mail($details->user_id,'İzin Talebi', $messages);
                $data=[
                    'status'=>2
                ];
                $this->db->set($data);
                $this->db->where('id',$user_permit_id);
                if($this->db->update('user_permit', $data)){
                    $this->db->trans_complete();
                    return [
                        'status'=>1,
                        'message'=>'İptal Talebiniz Personele İletilmiştir',
                    ];
                }
                else {
                    $this->db->trans_rollback();
                    return [
                        'status'=>0,
                        'message'=>'İptal Edilirken Hata Aldınız',
                    ];
                }

            }
        }
        else {
            $this->db->trans_rollback();
            return [
                'status'=>0,
                'message'=>'Durum Oluştururken Hata Aldınız',
            ];
        }

    }

    public function personel_gider_talep_onayi($user_id,$id,$status,$type,$sort,$deviceModel,$aciklama)
    {
        $this->db->trans_start();
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $progress_status_id = 1;
        $details = $this->talep_form_personel_details($id);
        $product_details = $this->talep_form_personel_details_items($id);

        $sort_kontrol = $this->db->query("SELECT * FROM talep_onay_personel_new Where talep_id=$id and type=$type and user_id=$user_id and  status is null and staff=1 and sort=$sort and type=$type")->num_rows();
        if($sort_kontrol){
            if($status==1){
                foreach ($product_details as $items){
                    $item_id = $items->id;
                    $item_details=$this->db->query("SELECT * FROM  talep_form_personel_products where id =$item_id ")->row();
                    $product_name = who_demirbas($item_details->cost_id)->name;
                    $progress_status_details = progress_status_details($progress_status_id);
                    $this->talep_history($id,$user_id,$deviceModel.' Cihazından,  '.$product_name.' Ürünü İçin Yeni Miktar : '.$items->product_qty.' Yeni Durum : '.$progress_status_details->name,null,'personel_talep_history');
                }
                $new_id=0;
                $new_user_id=0;
                $new_id_control = $this->db->query("SELECT * FROM `talep_onay_personel_new` Where type=$type and talep_id=$id and staff=0 and status is Null ORDER BY `talep_onay_personel_new`.`id` ASC LIMIT 1");
                if($new_id_control->num_rows()){
                    $new_id = $new_id_control->row()->id;
                    $new_user_id = $new_id_control->row()->user_id;
                }
                $data = array(
                    'status' => 1,
                    'staff' => 0,
                );

                $this->db->where('user_id',$rows->id);
                $this->db->where('staff',1);
                $this->db->where('type',$type);
                $this->db->set($data);
                $this->db->where('talep_id', $id);
                if ($this->db->update('talep_onay_personel_new', $data)) {
                    $this->talep_history($id,$user_id,$deviceModel.' Cihazından Onay Verildi',null,'personel_talep_history');
                    if($new_id){
                        $data_new=array(
                            'staff'=>1,
                        );
                        $this->db->where('id',$new_id);
                        $this->db->set($data_new);
                        $this->db->update('talep_onay_personel_new', $data_new);

                    }
                    else {
                        $data_Form=array(
                            'status'=>11,
                        );
                        //Ödeme Bekliyor
                        $this->db->set($data_Form);
                        $this->db->where('id', $id);
                        $this->db->update('talep_form_personel', $data_Form);
                        //Kontrol Bekliyor
                    }
                    $this->aauth->applog($deviceModel."Cihazından Gider Talebine Onay Verildi :  ID : ".$id, $rows->username);
                    $this->db->trans_complete();
                    return [
                        'status'=>1,
                        'message'=>'Başarıyla Onay Verildi',
                    ];

                }
                else {
                    $this->db->trans_rollback();
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız.Lütfen Yöneyiciye Başvurun.',
                    ];

                }
            }
            else {
                //iptal
                $now_status = $details->status;
                $data = array(
                    'status' => 10,
                );
                $this->db->set($data);
                $this->db->where('id', $id);
                if ($this->db->update('talep_form_personel', $data)) {

                    $data_iptal = array(
                        'iptal_status' => $now_status,
                    );
                    $this->db->set($data_iptal);
                    $this->db->where('id', $id);
                    $this->db->update('talep_form_personel', $data_iptal);
                    $this->talep_history($id,$user_id,$deviceModel.' Cihazından Talep İptal Edildi.Açıklama : '.$aciklama,null,'personel_talep_history');
                    $this->db->delete('firma_gider', array('talep_id' => $id,'type'=>2));
                    $this->aauth->applog("Personel Gider Talebi İptal Edildi  : Talep No : ".$id, $rows->username);
                    $this->db->trans_complete();
                    return [
                        'status'=>1,
                        'message'=>'Başarıyla İptal Verildi',
                    ];

                }
                else {
                    $this->db->trans_rollback();
                    return [
                        'status'=>0,
                        'message'=>'İptal Edilirken Hata Aldınız',
                    ];
                }
            }

        }
        else {
            $this->db->trans_rollback();
            return [
                'status'=>0,
                'message'=>'Doğru Tercih Yapmadınız Sayfa Yenilemesi Yapınız.',
            ];
        }


    }
    public function malzeme_talep_onayi($user_id,$id,$status,$satinalma_personeli,$deviceModel,$aciklama,$type,$sort)
    {
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $this->db->trans_start();
        $this->load->model('malzemetalep_model', 'talep');
        $details = $this->talep->details($id);
        $auth_id = $rows->id;
        if($status==1){ //Onay
            $sort_kontrol = $this->db->query("SELECT * FROM talep_onay_new Where talep_id=$id and  user_id=$auth_id and  status is null and staff=1 and sort=$sort and type=$type")->num_rows();
            if($sort_kontrol){
                $sorts=$sort+1;
                $new_id=0;
                $new_user_id=0;
                $new_id_control = $this->db->query("SELECT * FROM `talep_onay_new` Where type=$type and talep_id=$id and sort=$sorts and status is Null ORDER BY `talep_onay_new`.`id` ASC LIMIT 1");
                if($new_id_control->num_rows()){
                    $new_id = $new_id_control->row()->id;
                    $new_user_id = $new_id_control->row()->user_id;
                }
                if($this->db->delete('talep_user_satinalma', array('talep_id' => $id)))
                {
                    $data_satinalma=[
                        'user_id'=>$satinalma_personeli,
                        'talep_id'=>$id,
                    ];
                    if($this->db->insert('talep_user_satinalma', $data_satinalma))
                    {
                        $data = array(
                            'status' => 1,
                            'staff' => 0,
                        );
                        $this->db->where('user_id',$rows->id);
                        $this->db->where('staff',1);
                        $this->db->where('status',null,false);
                        $this->db->where('sort',$sort);
                        $this->db->where('type',$type);
                        $this->db->where('talep_id', $id);
                        $this->db->set($data);
                        if ($this->db->update('talep_onay_new', $data)) {

                            $this->talep_history($id,$rows->id,$deviceModel.' Cihazındann Onay Verildi',1,'talep_history');
                            if($new_id){
                                $data_new=array(
                                    'staff'=>1,
                                );
                                $this->db->where('id',$new_id);
                                $this->db->set($data_new);
                                if(!$this->db->update('talep_onay_new', $data_new)){
                                    $this->db->trans_rollback();
                                    return [
                                        'status'=>0,
                                        'message'=>'Atama Oluşturulurken Hata Aldınız',
                                    ];
                                }
                                else{
                                    $this->aauth->applog("Malzame Talebine Onay Verildi :  ID : ".$id, $rows->username);
                                    $this->db->trans_complete();
                                    return [
                                        'status'=>1,
                                        'message'=>'Başarıyla Onay Verildi',
                                    ];
                                }
                                // Bir Sonraki Onay
                            }
                            else {

                                $mesaj=$details->code.' Numaralı Malzeme Talep Formu Onaylanmıştır. İhale İşlemlerine Başlayabilirsiniz';
                                if( $this->send_mail($satinalma_personeli,'İhale Emri',$mesaj)){
                                    $data_sf=array(
                                        'status'=>1,
                                    );
                                    //satınalmaya geç
                                    $this->db->set($data_sf);
                                    $this->db->where('talep_id', $id);
                                    if($this->db->update('talep_user_satinalma', $data_sf)){
                                        // satinalmaya bildirimini goster
                                        $data_Form=array(
                                            'status'=>2,
                                        );
                                        //satınalmaya geç
                                        $this->db->set($data_Form);
                                        $this->db->where('id', $id);
                                        if( $this->db->update('talep_form', $data_Form)){
                                            $this->aauth->applog("Malzame Talebine Onay Verildi :  ID : ".$id, $rows->username);
                                            $this->db->trans_complete();
                                            return [
                                                'status'=>1,
                                                'message'=>'Başarıyla Onay Verildi',
                                            ];
                                        }
                                        else {
                                            $this->db->trans_rollback();
                                            return [
                                                'status'=>0,
                                                'message'=>'Talep Durumu Güncellenirken Hata Aldınız',
                                            ];
                                        }
                                    }
                                    else {
                                        $this->db->trans_rollback();
                                        return [
                                            'status'=>0,
                                            'message'=>'İhale Emri Verilirken Hata Aldınız',
                                        ];
                                    }
                                }
                                else {
                                    $this->db->trans_rollback();
                                    return [
                                        'status'=>0,
                                        'message'=>'Mail Gönderilirken Hata Aldınız',
                                    ];
                                }
                            }
                        }
                        else {
                            $this->db->trans_rollback();
                            return [
                                'status'=>0,
                                'message'=>'Onay Sıralaması Oluşturulurken Hata Aldınız',
                            ];
                        }
                    }
                    else {
                        $this->db->trans_rollback();
                        return [
                            'status'=>0,
                            'message'=>'Satın Alma Personeli Eklenirken Hata Aldınız',
                        ];
                    }

                }
                else {
                    $this->db->trans_rollback();
                    return [
                        'status'=>0,
                        'message'=>'Satın Alma Tablosunda İşlem Yapılırken Hata Aldınız',
                    ];
                }
            }
            else {
                $this->db->trans_rollback();
                return [
                    'status'=>0,
                    'message'=>'Doğru Tercih Yapmadınız Sayfa Yenilemesi Yapınız.',
                ];
            }
        }
        else {
            //iptal et sttatus 10

            $data_Form=array(
                'status'=>10,
            );
            //satınalmaya geç
            $this->db->set($data_Form);
            $this->db->where('id', $id);
            if( $this->db->update('talep_form', $data_Form)){
                $this->aauth->applog("Malzame Talebine İptal Verildi :  ID : ".$id, $rows->username);
                $this->talep_history($id,$rows->id,$deviceModel.' Cihazındann İptal Verildi',1,'talep_history');

                $this->db->trans_complete();
                return [
                    'status'=>1,
                    'message'=>'Başarıyla İptal Edildi',
                ];
            }
            else {
                $this->db->trans_rollback();
                return [
                    'status'=>0,
                    'message'=>'Talep Durumu Güncellenirken Hata Aldınız',
                ];
            }


        }


    }

    public function hizmet_talep_onayi($user_id,$id,$status,$satinalma_personeli,$deviceModel,$aciklama,$type,$sort)
    {
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $this->db->trans_start();
        $this->load->model('malzemetalep_model', 'talep');
        $details = $this->talep->details($id);
        $auth_id = $rows->id;
        if($status==1){ //Onay
            $sort_kontrol = $this->db->query("SELECT * FROM talep_onay_new Where talep_id=$id and  user_id=$auth_id and  status is null and staff=1 and sort=$sort and type=$type")->num_rows();
            if($sort_kontrol){
                $sorts=$sort+1;
                $new_id=0;
                $new_user_id=0;
                $new_id_control = $this->db->query("SELECT * FROM `talep_onay_new` Where type=$type and talep_id=$id and sort=$sorts and status is Null ORDER BY `talep_onay_new`.`id` ASC LIMIT 1");
                if($new_id_control->num_rows()){
                    $new_id = $new_id_control->row()->id;
                    $new_user_id = $new_id_control->row()->user_id;
                }
                if($this->db->delete('talep_user_satinalma', array('talep_id' => $id)))
                {
                    $data_satinalma=[
                        'user_id'=>$satinalma_personeli,
                        'talep_id'=>$id,
                    ];
                    if($this->db->insert('talep_user_satinalma', $data_satinalma))
                    {
                        $data = array(
                            'status' => 1,
                            'staff' => 0,
                        );
                        $this->db->where('user_id',$rows->id);
                        $this->db->where('staff',1);
                        $this->db->where('status',null,false);
                        $this->db->where('sort',$sort);
                        $this->db->where('type',$type);
                        $this->db->where('talep_id', $id);
                        $this->db->set($data);
                        if ($this->db->update('talep_onay_new', $data)) {

                            $this->talep_history($id,$rows->id,$deviceModel.' Cihazındann Onay Verildi',1,'talep_history');
                            if($new_id){
                                $data_new=array(
                                    'staff'=>1,
                                );
                                $this->db->where('id',$new_id);
                                $this->db->set($data_new);
                                if(!$this->db->update('talep_onay_new', $data_new)){
                                    $this->db->trans_rollback();
                                    return [
                                        'status'=>0,
                                        'message'=>'Atama Oluşturulurken Hata Aldınız',
                                    ];
                                }
                                else{
                                    $this->aauth->applog("Hizmet Talebine Onay Verildi :  ID : ".$id, $rows->username);
                                    $this->db->trans_complete();
                                    return [
                                        'status'=>1,
                                        'message'=>'Başarıyla Onay Verildi',
                                    ];
                                }
                                // Bir Sonraki Onay
                            }
                            else {

                                $mesaj=$details->code.' Numaralı Hizmet Talep Formu Onaylanmıştır. İhale İşlemlerine Başlayabilirsiniz';
                                if( $this->send_mail($satinalma_personeli,'İhale Emri',$mesaj)){
                                    $data_sf=array(
                                        'status'=>1,
                                    );
                                    //satınalmaya geç
                                    $this->db->set($data_sf);
                                    $this->db->where('talep_id', $id);
                                    if($this->db->update('talep_user_satinalma', $data_sf)){
                                        // satinalmaya bildirimini goster
                                        $data_Form=array(
                                            'status'=>2,
                                        );
                                        //satınalmaya geç
                                        $this->db->set($data_Form);
                                        $this->db->where('id', $id);
                                        if( $this->db->update('talep_form', $data_Form)){
                                            $this->aauth->applog("Hizmet Talebine Onay Verildi :  ID : ".$id, $rows->username);
                                            $this->db->trans_complete();
                                            return [
                                                'status'=>1,
                                                'message'=>'Başarıyla Onay Verildi',
                                            ];
                                        }
                                        else {
                                            $this->db->trans_rollback();
                                            return [
                                                'status'=>0,
                                                'message'=>'Talep Durumu Güncellenirken Hata Aldınız',
                                            ];
                                        }
                                    }
                                    else {
                                        $this->db->trans_rollback();
                                        return [
                                            'status'=>0,
                                            'message'=>'İhale Emri Verilirken Hata Aldınız',
                                        ];
                                    }
                                }
                                else {
                                    $this->db->trans_rollback();
                                    return [
                                        'status'=>0,
                                        'message'=>'Mail Gönderilirken Hata Aldınız',
                                    ];
                                }
                            }
                        }
                        else {
                            $this->db->trans_rollback();
                            return [
                                'status'=>0,
                                'message'=>'Onay Sıralaması Oluşturulurken Hata Aldınız',
                            ];
                        }
                    }
                    else {
                        $this->db->trans_rollback();
                        return [
                            'status'=>0,
                            'message'=>'Satın Alma Personeli Eklenirken Hata Aldınız',
                        ];
                    }

                }
                else {
                    $this->db->trans_rollback();
                    return [
                        'status'=>0,
                        'message'=>'Satın Alma Tablosunda İşlem Yapılırken Hata Aldınız',
                    ];
                }
            }
            else {
                $this->db->trans_rollback();
                return [
                    'status'=>0,
                    'message'=>'Doğru Tercih Yapmadınız Sayfa Yenilemesi Yapınız.',
                ];
            }
        }
        else {
            //iptal et sttatus 10

            $data_Form=array(
                'status'=>10,
            );
            //satınalmaya geç
            $this->db->set($data_Form);
            $this->db->where('id', $id);
            if( $this->db->update('talep_form', $data_Form)){
                $this->aauth->applog("Hizmet Talebine İptal Verildi :  ID : ".$id, $rows->username);
                $this->talep_history($id,$rows->id,$deviceModel.' Cihazındann İptal Verildi',1,'talep_history');

                $this->db->trans_complete();
                return [
                    'status'=>1,
                    'message'=>'Başarıyla İptal Edildi',
                ];
            }
            else {
                $this->db->trans_rollback();
                return [
                    'status'=>0,
                    'message'=>'Talep Durumu Güncellenirken Hata Aldınız',
                ];
            }


        }


    }


    public function nakliye_talep_onayi($user_id,$id,$status,$deviceModel,$aciklama,$type,$sort)
    {
        $this->db->trans_start();
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $this->load->model('Nakliye_model', 'model');
        $details = $this->model->details($id);
        $new_id=0;
        $new_user_id=0;
        $new_id_control = $this->db->query("SELECT * FROM `talep_onay_nakliye` Where type=$type and talep_id=$id and staff=0 and status is Null ORDER BY `talep_onay_nakliye`.`id` ASC LIMIT 1");
        if($new_id_control->num_rows()){
            $new_id = $new_id_control->row()->id;
            $new_user_id = $new_id_control->row()->user_id;
        }

        $data = array(
            'status' => 1,
            'staff' => 0,
        );

        $this->db->where('user_id',$user_id);
        $this->db->where('staff',1);
        $this->db->where('type',$type);
        $this->db->set($data);
        $this->db->where('talep_id', $id);
        if ($this->db->update('talep_onay_nakliye', $data)) {

            $this->talep_history($id,$rows->id,$deviceModel.' Cihazındann Onay Verildi',null,'talep_form_nakliye_history');
            if($new_id){
                $data_new=array(
                    'staff'=>1,
                );
                $this->db->where('id',$new_id);
                $this->db->set($data_new);
                $this->db->update('talep_onay_nakliye', $data_new);
                // Bir Sonraki Onay
            }
            else {
                if($details->status!=9){
                    $items_status=3;
                    $form_status=3;

                    if($type==2){
                        $items_status=13;
                        $form_status=5;
                    }


                    $data_Form = array(
                        'status' => $form_status,
                    );
                    //Ödeme Bekliyor
                    $this->db->set($data_Form);
                    $this->db->where('id', $id);
                    $this->db->update('talep_form_nakliye', $data_Form);


                    $data_Form_items=array(
                        'status'=>$items_status,
                    );
                    //Ödeme Bekliyor
                    $this->db->set($data_Form_items);
                    $this->db->where('form_id', $id);
                    $this->db->update('talep_form_nakliye_products', $data_Form_items);

                    $mesaj='Nakliye Onaylandı';
                    $items_details= $this->db->query("SELECT * FROM talep_form_nakliye_products Where form_id=$id and nakliye_item_tip=3");
                    if($items_details->num_rows()){
                        foreach ($items_details->result() as $item_values){
                            $data_Form_items=array(
                                'status'=>2,
                            );
                            //Ödeme Bekliyor
                            $this->db->set($data_Form_items);
                            $this->db->where('id', $item_values->id);
                            $this->db->update('talep_form_nakliye_products', $data_Form_items);
                        }
                    }
                    //Hizmet İse status değiş


                    //Kontrol Bekliyor
                }
                ///alacak durumları önceden tamamlanmışsa hiç bir işlem yapma
            }

            $this->aauth->applog("Nakliye Talebine Onay Verildi :  ID : ".$id, $rows->username);
            $this->db->trans_complete();

            return [
                'status'=>1,
                'message'=>'Talebe Başarıyla Onay Verdiniz.',
            ];

        }
        else {
            $this->db->trans_rollback();
            return [
                'status'=>0,
                'message'=>'Talep Güncellenirken Hata Aldınız.',
            ];

        }
    }


    public function permit_type_get($id)
    {
        $this->db->select('*');
        $this->db->from('permit_type');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }


    public function permit_type_all_get()
    {
        $this->db->select('*');
        $this->db->from('permit_type');
        $query = $this->db->get();
        return $query->result();
    }

    public function count_all_talep($start,$length,$tip,$user_id)
    {
        $this->_get_datatables_query_details_talep_list($tip,$user_id);
        return $this->db->count_all_results();
    }

    public function get_user_by_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('geopos_users'); // Kullanıcı tablosu
        return $query->row_array();
    }

    public function cari_gider_islem_olustur($user_id,$talep_id,$status,$type,$sort,$deviceModel,$aciklama)
    {
        $this->db->trans_start();
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $data_nre = array(
            'id' => $user_id,
            'loggedin' => TRUE,
            'user_new_id' => '½'.$rows->id.'½',
        );

        $this->session->set_userdata($data_nre);
        $this->session->set_userdata('set_firma_id',$rows->loc);
        $id=$talep_id;
        $progress_status_id=1;
        if($status==1){
            $details = $this->db->query("SELECT * FROM talep_form_customer_new WHERE  id=$id")->row();
            $product_details = $this->db->query("SELECT * FROM talep_form_customer_products_new WHERE  form_id=$id")->result();
            $auth_id=$user_id;
            foreach ($product_details as $items){
                $item_id = $items->id;
                $item_details=$this->db->query("SELECT * FROM  talep_form_customer_products_new where id =$item_id ")->row();
                $product_name = who_demirbas($item_details->cost_id)->name;

                $progress_status_details = progress_status_details($progress_status_id);
                $this->talep_history($id,$rows->id,$product_name.' Ürünü İçin Yeni Miktar : '.$items->product_qty.' Yeni Durum : '.$progress_status_details->name,2,'customer_talep_history');
            }

            $sort_kontrol = $this->db->query("SELECT * FROM talep_onay_customer_new Where talep_id=$id and type=$type and user_id=$auth_id and  status is null and staff=1 and sort=$sort and type=$type")->num_rows();
            if($sort_kontrol){

                $new_id=0;
                $new_user_id=0;
                $new_id_control = $this->db->query("SELECT * FROM `talep_onay_customer_new` Where type=$type and talep_id=$id and staff=0 and status is Null ORDER BY `talep_onay_customer_new`.`id` ASC LIMIT 1");
                if($new_id_control->num_rows()){
                    $new_id = $new_id_control->row()->id;
                    $new_user_id = $new_id_control->row()->user_id;
                }

                $data = array(
                    'status' => 1,
                    'staff' => 0,
                );

                $this->db->where('user_id',$rows->id);
                $this->db->where('staff',1);
                $this->db->where('type',$type);
                $this->db->set($data);
                $this->db->where('talep_id', $id);
                if ($this->db->update('talep_onay_customer_new', $data)) {

                    $this->talep_history($id,$rows->id,'Mobil Cihazdan Onay Verildi :'.$deviceModel,2,'customer_talep_history');
                    if($new_id){

                        $mesaj=$details->code.' Numaralı Gider Talep Formu Onayınızı Beklemektedir';
                        //$this->model->send_mail($new_user_id,'Gider Talep Onayı',$mesaj);

                        // Bir Sonraki Onay
                        $data_new=array(
                            'staff'=>1,
                        );
                        $this->db->where('id',$new_id);
                        $this->db->set($data_new);
                        $this->db->update('talep_onay_customer_new', $data_new);
                        // Bir Sonraki Onay
                    }
                    else {
//                $mesaj=$details->code.' Numaralı Gider Talep Formu Onaylanmıştır. İşleminiz Ödeme Emri Beklemektedir';
//                $this->model->send_mail($details->talep_eden_pers_id,'Gider Talep Formu',$mesaj);
                        //Ödeme Bekliyor
                        $data_Form=array(
                            'status'=>11,
                        );
                        //Ödeme Bekliyor
                        $this->db->set($data_Form);
                        $this->db->where('id', $id);
                        $this->db->update('talep_form_customer_new', $data_Form);
                        //Kontrol Bekliyor
                    }

                    $this->aauth->applog("Gider Talebine Onay Verildi :  ID : ".$id, $rows->username);
                    $this->db->trans_complete();
                    return [
                        'status'=>1,
                        'message'=>'Başarıyla Onay Verildi',
                    ];

                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız.Lütfen Yöneyiciye Başvurun.',
                    ];

                }
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Doğru Tercih Yapmadınız Sayfa Yenilemesi Yapınız.',
                ];
            }

        }
        else {

            $details_ = $this->db->query("SELECT * FROM talep_form_customer_new WHERE  id=$talep_id")->row();

            $now_status=$details_->status;
            $file_id=$talep_id;
            $data = array(
                'status' => 10,
            );
            $this->db->set($data);
            $this->db->where('id', $talep_id);
            if ($this->db->update('talep_form_customer_new', $data)) {
                $data_iptal = array(
                    'iptal_status' => $now_status,
                );
                $this->db->set($data_iptal);
                $this->db->where('id', $talep_id);
                $this->db->update('talep_form_customer_new', $data_iptal);


                $desc = $aciklama;
                $this->talep_history($file_id,$rows->id,'Mobil Cihazdan Talep İptal Edildi. '.$deviceModel. '.Açıklama : '.$desc,2,'customer_talep_history');
                $talep_form_customer_new_payment = $this->db->query("SELECT * FROM talep_form_customer_new_payment Where form_id=$file_id and tip=1");
                if($talep_form_customer_new_payment->num_rows()){
                    foreach ($talep_form_customer_new_payment->result() as $values){
                        // Odemeleri Sil
                        $this->db->delete('geopos_invoices', array('id' => $values->transaction_id));
                    }

                    $this->db->delete('talep_form_customer_new_payment', array('form_id' => $file_id,'tip'=>1));
                }
                if($details_->gider_durumu){
                    //giderlerden sil
                    $this->db->delete('firma_gider', array('type' => 1,'talep_id'=>$file_id));


                }
                if($details_->invoice_durumu){
                    //faturayı iptal et
                    $invoice_id = $details_->invoice_id;
                    $data_iptal_invoice = array(
                        'status' => 3,
                    );
                    $this->db->set($data_iptal_invoice);
                    $this->db->where('id', $invoice_id);
                    $this->db->update('geopos_invoices', $data_iptal_invoice);
                }

                $mesaj=$details_->code.' Numaralı Gider Talep Formu İptal Edilmiştir.';

                $this->send_mail($details_->aauth,'Gider Talep İptali',$mesaj);
                $this->db->trans_complete();

                return [
                    'status'=>1,
                    'message'=>'Başarıyla İptal Edilmiştir.',
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız.Lütfen Yöneyiciye Başvurun.',
                ];
            }
        }
    }

    public function cari_protokol_islem_olustur($user_id,$talep_id,$status,$deviceModel,$desc)
    {
        $this->db->trans_start();
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $data_nre = array(
            'id' => $user_id,
            'loggedin' => TRUE,
            'user_new_id' => '½'.$rows->id.'½',
        );

        $this->session->set_userdata($data_nre);
        $this->session->set_userdata('set_firma_id',$rows->loc);
        $id=$talep_id;
        $details = $this->db->query("SELECT * FROM cari_razilastirma where id = $id")->row();
        $new_id=0;
        $new_user_id=0;

        if($status==1){
            $new_id_control = $this->db->query("SELECT * FROM `razilastirma_onay` Where razilastirma_id=$id and staff=0 and status is Null ORDER BY `razilastirma_onay`.`id` ASC LIMIT 1");
            if($new_id_control->num_rows()){
                $new_id = $new_id_control->row()->id;
                $new_user_id = $new_id_control->row()->user_id;
            }


            $data = array(
                'status' => 1,
                'staff' => 0,
            );

            $this->db->where('user_id',$rows->id);
            $this->db->where('staff',1);
            $this->db->set($data);
            $this->db->where('razilastirma_id', $id);
            if ($this->db->update('razilastirma_onay', $data)) {
                if($new_id){
                    $data_new=array(
                        'staff'=>1,
                    );
                    $this->db->where('id',$new_id);
                    $this->db->set($data_new);
                    $this->db->update('razilastirma_onay', $data_new);
                    // Bir Sonraki Onay
                }
                else {
                    //Onaylandı
                    $data_Form=array(
                        'razi_status'=>1,
                    );
                    //Onaylandı
                    $this->db->set($data_Form);
                    $this->db->where('id', $id);
                    $this->db->update('cari_razilastirma', $data_Form);
                    //Kontrol Bekliyor

                    $subject = 'Razılaştırma  Onayı';
                    $message = $details->code.' Numaralı Razılaştırmaya Onay Verildi.';
                    $proje_sorumlusu_email = personel_detailsa(832)['email'];
                    $proje_sorumlusu_email2 = personel_detailsa(831)['email'];
                    $talep_acan_id = $details->user_id;

                    $recipients = array($proje_sorumlusu_email,$proje_sorumlusu_email2,$talep_acan_id);
                    $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$id);

                }

                $this->aauth->applog("Razılaştırma Talebine Mobil Cihazdan Onay Verildi.Mobil Cihaz : ".$deviceModel." :  ID : ".$id, $rows->username);
                $this->db->trans_complete();
                return [
                    'status'=>1,
                    'message'=>'Başarıyla Onay Verildi',
                ];

            }
            else {
                $this->db->trans_rollback();
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız.Lütfen Yöneyiciye Başvurun',
                ];

            }
        }
        else {
            $data_Form=array(
                'razi_status'=>2,
            );
            //Onaylandı
            $this->db->set($data_Form);
            $this->db->where('id', $id);
            $this->db->update('cari_razilastirma', $data_Form);


            $subject = 'Razılaştırma  İptali';
            $message = $details->code.' Numaralı Razılaştırmaya İptal Verildi.Açıklama : '.$desc;
            $proje_sorumlusu_email = personel_detailsa(832)['email'];
            $proje_sorumlusu_email2 = personel_detailsa(831)['email'];
            $talep_acan_id = $details->user_id;

            $recipients = array($proje_sorumlusu_email,$proje_sorumlusu_email2,$talep_acan_id);
            $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$id);

            $this->aauth->applog("Razılaştırma Talebine İptal Verildi.Desc : ".$desc.' | Açıklama : '.$id, $rows->username);
            $this->db->trans_complete();
            return [
                'status'=>1,
                'message'=>'Başarıyla İptal Verildi',
            ];

        }
    }

    public function cari_forma_islem_olustur($auth_id,$id,$status,$type,$aauth_sort,$deviceModel,$desc)
    {
        $this->db->trans_start();
        $sort_kontrol = $this->db->query("SELECT * FROM invoices_onay_new Where invoices_id=$id and  user_id=$auth_id and  status is null and staff=1 and sort=$aauth_sort")->num_rows();

        if($sort_kontrol) {
            if ($status == 1) {
                $new_id = 0;
                $sort = 0;
                $new_id_control = $this->db->query("SELECT * FROM `invoices_onay_new` Where type=$type and invoices_id=$id and staff=0 and status is Null ORDER BY `invoices_onay_new`.`id` ASC LIMIT 1");
                if ($new_id_control->num_rows()) {
                    $new_id = $new_id_control->row()->id;
                    $sort = $new_id_control->row()->sort;
                }
                $data = array(
                    'status' => 1,
                    'staff' => 0,
                );

                $this->db->where('user_id', $auth_id);
                $this->db->where('staff', 1);
                $this->db->where('type', $type);
                $this->db->set($data);
                $this->db->where('invoices_id', $id);
                if ($this->db->update('invoices_onay_new', $data)) {
                    $this->talep_history($id, $auth_id, 'Mobil Cihazdan Onay Verildi.'.$deviceModel.' Açıklama '. $desc,$type,'invoice_history');
                    if ($new_id) {
                        $data_new = array(
                            'staff' => 1,
                        );
                        $this->db->where('id', $new_id);
                        $this->db->set($data_new);
                        $this->db->update('invoices_onay_new', $data_new);

                    }
                    else {

                        $this->db->set('status', 18);
                        $this->db->where('id', $id);
                        $this->db->update('geopos_invoices');

                        //artık yeni ID yok Talep durumunu Ödeme Bekliyor yap ve Mail gönder
                        $razilastirma_details = $this->db->query("SELECT * FROM geopos_invoices where id = $id")->row();
                        $subject = 'Forma2 Onayı';
                        $message = $razilastirma_details->invoice_no . ' Numaralı Forma2ye Genel Müdür Durum Bildirildi.';
                        $recipients = array(832, 831);
                        $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili');
                    }
                    $this->db->trans_complete();
                    return [
                        'status'=>1,
                        'message'=>'Başarıyla Onay Verildi',
                    ];

                } else {
                    $this->db->trans_rollback();

                    return [
                        'status'=>0,
                        'message'=>'Onay verilirken hata aldınız',
                    ];
                }
            }
            else {

                $data_new = array(
                    'status' => 3,
                );
                $this->db->where('id', $id);
                $this->db->where('staff', 1);
                $this->db->where('user_id', $rows->id);
                $this->db->set($data_new);
                $this->db->update('invoices_onay_new', $data_new);


                $this->db->set('status', 3);
                $this->db->where('id', $id);
                $this->db->update('geopos_invoices');
                $this->talep_history($id, $rows->id, 'Mobil Cihazdan İptal Edildi.'.$deviceModel.' Açıklama : ' . $desc,2,'invoice_history');


                $this->db->set('invoice_id', NULL);
                $this->db->where('invoice_id', $id);
                $this->db->update('geopos_invoice_transactions');

                $this->db->delete('firma_gider', array('talep_id' => $id, 'type' => 5));
                $this->db->delete('geopos_project_items_gider', array('tid' => $id));


                $this->db->trans_complete();
                return [
                    'status'=>1,
                    'message'=>'Başarıyla İptal Edildi',
                ];
            }
        }
        else {
            $this->db->trans_rollback();
            return [
                'status'=>0,
                'message'=>'Doğru Tercih Yapmadınız Sayfa Yenilemesi Yapınız.',
            ];
        }

    }


    public function cari_avans_islem_olustur($user_id,$talep_id,$status,$type,$sort,$deviceModel,$aciklama)
    {
        $this->db->trans_start();
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$user_id)->row();
        $data_nre = array(
            'id' => $user_id,
            'loggedin' => TRUE,
            'user_new_id' => '½'.$rows->id.'½',
        );

        $this->session->set_userdata($data_nre);
        $this->session->set_userdata('set_firma_id',$rows->loc);
        $id=$talep_id;
        $progress_status_id=1;
        if($status==1){
            $details = $this->db->query("SELECT * FROM talep_form_customer WHERE  id=$id")->row();
            $product_details = $this->db->query("SELECT * FROM talep_form_customer_products WHERE  form_id=$id")->result();
            $auth_id=$user_id;
            foreach ($product_details as $items){
                $item_id = $items->id;
                $item_details=$this->db->query("SELECT * FROM  talep_form_customer_products where id =$item_id ")->row();


                $product_name=$item_details->product_desc;
                $progress_status_details = progress_status_details($progress_status_id);
                $this->talep_history($id,$rows->id,$product_name.' Ürünü İçin Yeni Miktar : '.$items->product_qty.' Yeni Durum : '.$progress_status_details->name,1,'customer_talep_history');
            }

            $sort_kontrol = $this->db->query("SELECT * FROM talep_onay_customer_new Where talep_id=$id and type=$type and user_id=$auth_id and  status is null and staff=1 and sort=$sort and type=$type")->num_rows();
            if($sort_kontrol){

                $new_id=0;
                $new_user_id=0;
                $new_id_control = $this->db->query("SELECT * FROM `talep_onay_customer_new` Where type=$type and talep_id=$id and staff=0 and status is Null ORDER BY `talep_onay_customer_new`.`id` ASC LIMIT 1");
                if($new_id_control->num_rows()){
                    $new_id = $new_id_control->row()->id;
                    $new_user_id = $new_id_control->row()->user_id;
                }

                $data = array(
                    'status' => 1,
                    'staff' => 0,
                );

                $this->db->where('user_id',$rows->id);
                $this->db->where('staff',1);
                $this->db->where('type',$type);
                $this->db->set($data);
                $this->db->where('talep_id', $id);
                if ($this->db->update('talep_onay_customer_new', $data)) {

                    $this->talep_history($id,$rows->id,'Mobil Cihazdan Onay Verildi :'.$deviceModel,1,'customer_talep_history');
                    if($new_id){

                        $data_new=array(
                            'staff'=>1,
                        );
                        $this->db->where('id',$new_id);
                        $this->db->set($data_new);
                        $this->db->update('talep_onay_customer_new', $data_new);
                        // Bir Sonraki Onay
                    }
                    else {
                        //Ödeme Bekliyor
                        $data_Form=array(
                            'status'=>11,
                        );
                        //Ödeme Bekliyor
                        $this->db->set($data_Form);
                        $this->db->where('id', $id);
                        $this->db->update('talep_form_customer', $data_Form);
                        //Kontrol Bekliyor
                    }

                    $this->aauth->applog("Avans Talebine Onay Verildi :  ID : ".$id, $rows->username);
                    $this->db->trans_complete();
                    return [
                        'status'=>1,
                        'message'=>'Başarıyla Onay Verildi',
                    ];

                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'Hata Aldınız.Lütfen Yöneyiciye Başvurun.',
                    ];

                }
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Doğru Tercih Yapmadınız Sayfa Yenilemesi Yapınız.',
                ];
            }

        }
        else {

            $details_ = $this->db->query("SELECT * FROM talep_form_customer WHERE  id=$talep_id")->row();

            $now_status=$details_->status;
            $file_id=$talep_id;
            $data = array(
                'status' => 10,
            );
            $this->db->set($data);
            $this->db->where('id', $talep_id);
            if ($this->db->update('talep_form_customer', $data)) {
                $data_iptal = array(
                    'iptal_status' => $now_status,
                );
                $this->db->set($data_iptal);
                $this->db->where('id', $talep_id);
                $this->db->update('talep_form_customer', $data_iptal);


                $desc = $aciklama;
                $this->talep_history($file_id,$rows->id,'Mobil Cihazdan Talep İptal Edildi. '.$deviceModel. '.Açıklama : '.$desc,1,'customer_talep_history');
                $talep_form_customer_new_payment = $this->db->query("SELECT * FROM talep_form_customer_new_payment Where form_id=$file_id and tip=2");
                if($talep_form_customer_new_payment->num_rows()){
                    foreach ($talep_form_customer_new_payment->result() as $values){
                        // Odemeleri Sil
                        $this->db->delete('geopos_invoices', array('id' => $values->transaction_id));
                    }

                    $this->db->delete('talep_form_customer_new_payment', array('form_id' => $file_id,'tip'=>2));
                }
                $mesaj=$details_->code.' Numaralı Avans Talep Formu İptal Edilmiştir.';
                $this->send_mail($details_->aauth,'Avans Talep İptali',$mesaj);
                $this->db->trans_complete();
                return [
                    'status'=>1,
                    'message'=>'Başarıyla İptal Edilmiştir.',
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız.Lütfen Yöneyiciye Başvurun.',
                ];
            }
        }
    }

    public function virman_onay($user_id,$talep_id,$tip,$virman_onay_id,$onaylanan_tutar,$deviceModel,$desc)
    {
        $this->db->trans_start();
        $onay_details_count = $this->db->query("SELECT * FROM virman_onay Where id = $virman_onay_id");
        if($onay_details_count->num_rows()){
            $onay_details = $onay_details_count->row();
            $sort = $onay_details->sort;
            $virman_id = $onay_details->virman_id;
            if($tip==1) // Onay
            {
                $data = array(
                    'desc' => $desc,
                    'onaylanan_price' => $onaylanan_tutar,
                    'status' => $tip,
                    'staff' => 0,
                );
                $this->db->set('update_at', 'NOW()', FALSE);
                $this->db->set($data);
                $this->db->where('id',$virman_onay_id);
                $this->db->where('sort',$sort);
                if ($this->db->update('virman_onay', $data)) {
                    $new_sort=$sort+intval(1);
                    $new_onay_details_count = $this->db->query("SELECT * FROM virman_onay Where sort = $new_sort and virman_id=$virman_id");
                    if($new_onay_details_count->num_rows()){
                        $new_onay_details = $new_onay_details_count->row();
                        $data = array(
                            'staff' => 1,
                        );
                        $this->db->set($data);
                        $this->db->where('id',$new_onay_details->id);
                        if( $this->db->update('virman_onay', $data)){
                            $this->db->trans_complete();
                            return [
                                'status'=>1,
                                'message'=>'Başarılı Bir Şekilde Onayınız Verildi Ve Bir Sonraki Kasada İşlem Beklemektedir'
                            ];
                        }
                        else {
                            $this->db->trans_rollback();
                            return [
                                'status'=>1,
                                'message'=>'Onay Verilirken Hata Aldınız'
                            ];
                        }
                    }
                    else {
                        // Para Aktarımı Olacak

                        // Çıkış İşlemleri
                        $virma_details = $this->virman_details($virman_id);
                        $details = $this->db->query("SELECT * FROM  virman_onay Where virman_id=$virman_id and out_account_id is not null");
                        if($details->num_rows()){
                            $data_cikis=[
                                'invoice_no'=>$virma_details->code,
                                'total'=>$details->row()->onaylanan_price,
                                'notes'=>$virma_details->desc.' | '.$details->row()->desc,
                                'eid'=>$details->row()->user_id,
                                'invoice_type_id'=>28,
                                'invoice_type_desc'=>invoice_type_desc(28),
                                'payer'=>account_details($virma_details->out_account_id)->holder,
                                'para_birimi'=>account_details($virma_details->out_account_id)->para_birimi,
                                'acid'=>$virma_details->out_account_id,
                                'acid_'=>$virma_details->in_account_id,
                                'account'=>account_details($virma_details->in_account_id)->holder,
                                'method'=>1,
                                'loc'=>$this->session->userdata('set_firma_id'),
                            ];
                            if(!$this->db->insert('geopos_invoices', $data_cikis)){
                                $this->db->trans_rollback();
                                return [
                                    'status'=>1,
                                    'message'=>'Kayıt Alınırken Hata Oluştu'
                                ];
                            }
                        }
                        else {
                            $this->db->trans_rollback();
                            return [
                                'status'=>1,
                                'message'=>'Veri Alınırken Hata oluştu'
                            ];
                        }

                        // Çıkış İşlemleri

                        // Giriş İşlemleri
                        $details_giris = $this->db->query("SELECT * FROM  virman_onay Where virman_id=$virman_id and in_account_id is not null");
                        if($details_giris->num_rows()){
                            $data_cikis=[
                                'invoice_no'=>$virma_details->code,
                                'total'=>$details_giris->row()->onaylanan_price,
                                'notes'=>$virma_details->desc.' | '.$details_giris->row()->desc,
                                'eid'=>$details_giris->row()->user_id,
                                'invoice_type_id'=>27,
                                'invoice_type_desc'=>invoice_type_desc(27),
                                'payer'=>account_details($virma_details->in_account_id)->holder,
                                'para_birimi'=>account_details($virma_details->in_account_id)->para_birimi,
                                'acid'=>$virma_details->in_account_id,
                                'acid_'=>$virma_details->out_account_id,
                                'account'=>account_details($virma_details->out_account_id)->holder,
                                'method'=>1,
                                'loc'=>$this->session->userdata('set_firma_id'),
                            ];
                            if(!$this->db->insert('geopos_invoices', $data_cikis)){
                                $this->db->trans_rollback();
                                return [
                                    'status'=>1,
                                    'message'=>'Kayıt Alınırken Hata Oluştu'
                                ];
                            }
                        }
                        // Giriş İşlemleri
                        $this->db->trans_complete();
                        return [
                            'status'=>1,
                            'message'=>'Para Aktarımı Yapıldı'
                        ];
                    }
                }
                else {
                    $this->db->trans_rollback();
                    return [
                        'status'=>0,
                        'message'=>'Onay Verilirken Hata Aldınız.'
                    ];
                }
            }
            else // İptal
            {
                $data = array(
                    'desc' => $desc,
                    'onaylanan_price' => $onaylanan_tutar,
                    'status' => $tip,
                    'staff' => 0,
                    'update_at' => 'NOW()',
                );
                $this->db->set($data);
                $this->db->where('id',$virman_onay_id);
                $this->db->where('sort',$sort);
                if ($this->db->update('virman_onay', $data)) {
                    return [
                        'status'=>1,
                        'message'=>'Başarılı Bir Şekilde İptal Edildi'
                    ];
                }
                else {
                    return [
                        'status'=>0,
                        'message'=>'İptal Edilirken Hata Aldınız'
                    ];
                }
            }

        }
    }

    public function nakliye_onay_list($auth_id,$type,$status)
    {
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$auth_id)->row();

        $tip_select='"NakliyeSatinalmaDetails" as route,';
        if($type==1){
            $tip_select='"NakliyeTalepDetails" as route,';
        }


        $this->db->select('talep_form_nakliye.*,geopos_employees.name as pers_name,
         '.$tip_select.'
        progress_status.name as progress_name,talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name,geopos_customers.company');
        $this->db->from('talep_form_nakliye');
        $this->db->join('geopos_employees','talep_form_nakliye.talep_eden_user_id=geopos_employees.id','LEFT');
        $this->db->join('progress_status','talep_form_nakliye.progress_status_id=progress_status.id','LEFT');
        $this->db->join('geopos_projects','talep_form_nakliye.proje_id=geopos_projects.id','LEFT');
        $this->db->join('talep_form_status','talep_form_nakliye.status=talep_form_status.id','LEFT');
        $this->db->join('geopos_customers','talep_form_nakliye.cari_id=geopos_customers.id','LEft');
        $this->db->join('talep_onay_nakliye','talep_form_nakliye.id=talep_onay_nakliye.talep_id','LEFT');
        if($status!=0){
            $this->db->where('talep_form_nakliye.status',$status);
        }
        $this->db->where('talep_form_nakliye.type',1);
        $this->db->where('talep_form_nakliye.loc =', $rows->loc); //2019-11-23 14:28:57
        $this->db->where("talep_onay_nakliye.type",$type);
        $this->db->where("talep_onay_nakliye.staff",1);
        $this->db->where("talep_onay_nakliye.user_id",$auth_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function nakliye_onay_list_count($type,$auth_id,$status)
    {
        $rows =  $this->db->query('SELECT * FROM geopos_employees WHERE id='.$auth_id)->row();

        $tip_select='"MtMalzemeTalepDetailsScreen" as route,';
        if($type==1){
            $tip_select='"NakliyeTalepDetails" as route,';
        }


        $this->db->select('talep_form_nakliye.*,geopos_employees.name as pers_name,
         '.$tip_select.'
        progress_status.name as progress_name,talep_form_status.color as color,geopos_projects.code as proje_name,talep_form_status.name as st_name,geopos_customers.company');
        $this->db->from('talep_form_nakliye');
        $this->db->join('geopos_employees','talep_form_nakliye.talep_eden_user_id=geopos_employees.id','LEFT');
        $this->db->join('progress_status','talep_form_nakliye.progress_status_id=progress_status.id','LEFT');
        $this->db->join('geopos_projects','talep_form_nakliye.proje_id=geopos_projects.id','LEFT');
        $this->db->join('talep_form_status','talep_form_nakliye.status=talep_form_status.id','LEFT');
        $this->db->join('geopos_customers','talep_form_nakliye.cari_id=geopos_customers.id','LEft');
        $this->db->join('talep_onay_nakliye','talep_form_nakliye.id=talep_onay_nakliye.talep_id','LEFT');
        if($status!=0){
            $this->db->where('talep_form_nakliye.status',$status);
        }
        $this->db->where('talep_form_nakliye.type',1);
        $this->db->where('talep_form_nakliye.loc =', $rows->loc); //2019-11-23 14:28:57
        $this->db->where("talep_onay_nakliye.type",$type);
        $this->db->where("talep_onay_nakliye.staff",1);
        $this->db->where("talep_onay_nakliye.user_id",$auth_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function nakliye_talep_view($user_id,$tip,$id)
    {
        $this->load->model('Nakliye_model', 'model');
        $data['details']= $this->model->details($id);
        $odeme_total = $this->model->odeme_total($id);
        $form_total = $this->model->form_total($id);
        $data['kalan']=floatval($form_total)-floatval($odeme_total);
        $items= $this->model->product_details($id);
        $data['file_details']= $this->model->file_details($id);
        $data['proje_code']= proje_code($data['details']->proje_id);
        $data['talep_eden_personel']= personel_details($data['details']->talep_eden_user_id);
        $sort = $this->db->query("SELECT * FROM talep_onay_nakliye Where talep_id=$id and type=$tip and user_id=$user_id and staff=1 and status is null ")->row()->sort;


        $data['sort_val']=$sort;
        $data['type_val']=$tip;
        if($tip==1){
            foreach ($items as $item){

                $item_name = $this->db->query("SELECT * FROM `nakliye_item_tip` Where id=$item->nakliye_item_tip")->row()->name;

                $data['items'][]=
                    [
                        'id'=>$item->id,
                        'code'=>$item->code,
                        'lokasyon'=>$item->lokasyon,
                        'cari_name'=>customer_details($item->yukleme_yapacak_cari_id)['company'],
                        'type'=>$item_name,
                        'product_desc'=>$item->product_desc,
                        'total'=>$item->total
                    ];
            }
        }
        else {
            foreach ($items as $item){

                $item_name = $this->db->query("SELECT * FROM `nakliye_item_tip` Where id=$item->nakliye_item_tip")->row()->name;

                $data['items'][]=
                    [
                        'id'=>$item->id,
                        'code'=>$item->code,
                        'lokasyon'=>$item->lokasyon,
                        'cari_name'=>customer_details($item->yukleme_yapacak_cari_id)['company'],
                        'type'=>$item_name,
                        'qty'=>amountFormat_s($item->product_qty).' '.units_($item->unit_id)['name'],
                        'price'=>amountFormat($item->price),
                        'product_desc'=>$item->product_desc,
                        'cari'=>customer_details($item->cari_id)['company'],
                        'arac'=>arac_details($item->arac_id)->name,
                        'total'=>$item->total,
                        'totals'=>amountFormat($item->total)
                    ];
            }
        }


        $toplam_tutar=0;
        foreach ($items as $details){
            $toplam_tutar+=$details->total;
        }
        $data['odeme_details']=[
            'toplam_tutar'=>amountFormat($toplam_tutar),
            'toplam_tutar_float'=>$toplam_tutar,
            'cari'=>customer_details($data['details']->cari_id)['company'],
        ];
        return $data;
    }

    public function onay_mailleri($subject, $message, $recipients, $tip)
    {
        $this->load->model('communication_model');
        $attachmenttrue = false;
        $attachment = '';
        $this->communication_model->onay_mail($recipients, $subject, $message, $attachmenttrue, $attachment, $tip);
        return 1;

    }


    public function send_mail($user_id,$subject,$message){
        $this->load->model('communication_model');
        $message .= "<br><br><br><br>";
        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
        $proje_sorumlusu_email = personel_detailsa($user_id)['email'];
        $recipients = array($proje_sorumlusu_email);
        $this->communication_model->onay_mail($recipients, $subject, $message, false,'', 'gider_talep_onay_maili');
        return 1;
    }

    private function talep_history($id,$user_id,$desc,$tip=2,$table){

        date_default_timezone_set('Asia/Baku');
        if($table=='customer_talep_history'){
            $data_step = [
                'talep_id' => $id,
                'user_id' => $user_id,
                'desc' => $desc,
                'tip' => $tip,
            ];
            $this->db->insert('customer_talep_history', $data_step);
        }
        elseif($table=='invoice_history'){
            $data_step = [
                'talep_id' => $id,
                'user_id' => $user_id,
                'desc' => $desc,
                'type' => $tip,
            ];
            $this->db->insert('invoice_history', $data_step);
        }

        elseif($table=='personel_talep_history'){
            $data_step = [
                'talep_id' => $id,
                'user_id' => $user_id,
                'desc' => $desc,
            ];
            $this->db->insert('personel_talep_history', $data_step);
        }
        elseif($table=='talep_form_nakliye_history'){
            $data_step = [
                'talep_id' => $id,
                'user_id' => $user_id,
                'desc' => $desc,
            ];
            $this->db->insert('talep_form_nakliye_history', $data_step);
        }
        elseif($table=='talep_history'){
            $data_step = [
                'talep_id' => $id,
                'user_id' => $user_id,
                'desc' => $desc,
                'type' => $tip,
            ];
            $this->db->insert('talep_history', $data_step);
        }
        elseif($table=='talep_form_nakliye_history'){
            $data_step = [
                'talep_id' => $id,
                'user_id' => $user_id,
                'desc' => $desc,
            ];
        $this->db->insert('talep_form_nakliye_history', $data_step);
        }


    }

}