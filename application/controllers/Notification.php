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

class Notification Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('manager_model', 'manager');
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('plugins_model');
        $this->load->model('lojistikgider_model', 'lojistik');
        $this->load->model('aracform_model', 'aracform');
        $this->load->model('logistics_model', 'logistics');
        $this->load->model('communication_model');
        $this->load->model('Carigidertalepnew_model', 'cari_new_model');
        $this->load->model('malzemetalep_model', 'talep');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Bildirimler';
        $this->load->view('fixed/header', $head);
        $this->load->view('notification/index');
        $this->load->view('fixed/footer');
    }
    public function pendingtasks()
    {

        $user = $this->aauth->get_user()->id;



        $tasks = $this->manager->pending_talep_user($user);



        $tlist = '';

        $tc = 0;

        foreach ($tasks as $row) {
            $onay_kontrol=talep_onay_iptal_kontrol($row['id']);
            if($onay_kontrol==0) {


                $href = '';

                if ($row['tip'] == 1) // Malzeme Talep
                {
                    $href = "/requested/view?id=" . $row['id'];

                } else if ($row['tip'] == 2) // Satın Alma Talep
                {
                    $href = "/form/satinalma_view?id=" . $row['id'];
                } else if ($row['tip'] == 4) // Gider Talep
                {
                    $href = "/form/gider_view?id=" . $row['id'];
                } else if ($row['tip'] == 5) // Avans Alma Talep
                {
                    $href = "/form/avans_view?id=" . $row['id'];
                }

                $personel = onay_kimde_ogren($row['tip'], $row['id']);

                $tlist .= '<a href="' . $href . '" class="list-group-item">
    
                          <div class="media">
    
                            <div class="media-left valign-middle"><i class="icon-bullhorn2 icon-bg-circle bg-cyan"></i></div>
    
                            <div class="media-body">
    
                              <h6 class="media-heading">' . $row['talep_no'] . '</h6>
    
                              <p class="notification-text font-small-2 text-muted">Proje Adı ' . $row['proje_name'] . '.</p>
                              <p class="notification-text font-small-2 text-muted">' . $personel . ' Onay Bekliyor.</p>
    
                            </div>
    
                          </div></a>';

                $tc++;
            }

        }



      return $tc;





    }

    public function muhasebeview(){

        $result = $this->manager->muhasebeview();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }

    }


    public function all_count()
    {




        $count=
            count_kasa_func()+
            bordro_edit_count_func()+
            razi_count_func()+
            maascount_func()+
            bekleyenmaascount_func()+
            onay_qaime_list_func()+
            forma2_new_count_func()+
            stok_kontol_hizmet()+
            beklyen_malzeme_count_func()+
            personelsatinalmalistcount_func()+
            ihalelistcount_func()+
            odemeemrilistcount_func()+
            siparislistcount_func()+
            siparis_finist_list_count_func()+
            bekleyen_sened_list_count_func()+
            tehvil_list_count_func()+
            qaimelistcount_func()+
            warehousetransfercount_func()+
            talepwarehousetransfercount_func()+
            odemetalepcount_func()+
            avanslistcount_func()+
            odemelistcountnew_func()+
            ihalebeklyenlistcount_func()+
            transfertaleplist_func()+
            bekleyentask_func()+
            muhasebeview_func()+
            countgiderhizmet_func()+
            count_gider_mt_func()+
            nakliye_mt_talep_func()+
            caricezatalepcount_func()+
            nakliyeteklifbekleyen_func()+
            atama_gider_talep_func()+
            atama_nakliye_talep_func()+
            atama_cari_avans_talep_func()+
            atama_personel_avans_talep_func()+
            atama_personel_gider_talep_func()+
            ajax_podradci_borclandirma_func()+
            stok_kontol_hizmet_func()+
            bekleyen_hizmet_count_func()+
            personelsatinalmahizmetlistcount_func()+
            ihalelistcounthizmet_func()+
            siparislistcounthizmet_func()+
            siparis_finishizmet_list_count_func()+
            bekleyen_sened_list_hizmet_count_func()+
            tehvil_list_count_hizmet_func()+
            hizmetqaimelistcount_func();
            echo json_encode(array('status' => 'Success', 'count' =>$count));
    }


//    public function all_count(){
//        $id =  $this->aauth->get_user()->id;
//        $aauth_id =  $this->aauth->get_user()->id;
//        $user_id =  $this->aauth->get_user()->id;
//        $kasa_count =  count_kasa_func();
//        $bordro_edit_count = bordro_edit_count_func();
//        $razi_count = razi_count_func();
//        $count_invoice_onay =  onay_qaime_list_func();
//        $maas_count  =  maascount_func();
//        $bekleyen_maas_count  = bekleyenmaascount_func();
//        $hm_bekleyen = $this->cari_new_model->_count_gider_hizmet();
//        $bekleyen_prim_count = bekleyenprimcount_func();
//        $count_malzeme = beklyen_malzeme_count_func();
//        $count_pers_satinalma = personelsatinalmalistcount_func();
//        $lojistikhizmetcount= 0;//$this->logistics->lojistikhizmetcount();
//        $count_ihale =ihalelistcount_func();
//        $sened_list_count = bekleyen_sened_list_count_func();
//        $tehvil_lsit_count = tehvil_list_count_func();
//        $count_qaime=0;
//        if($aauth_id==39){
//            $count_qaime = qaimelistcount_func();
//        }
//        $count_odeme = odemetalepcount_func();
//
//
//
//        $count_task_personel = bekleyentask_func();
//
//        $count_transfer_warehouse = warehousetransfercount_func();
//        $count_talep_transfer_warehouse =talepwarehousetransfercount_func();
//
//
//        $count_avans_t=avanslistcount_func();
//        $count_odme_t=odemelistcountnew_func();
//        $count_odme_emri=odemeemrilistcount_func();
//
//        $where_talep_form='';
//        $where_talep_form.='and talep_form.loc='.$this->session->userdata('set_firma_id');
//        $where_invoices='and geopos_invoices.loc='.$this->session->userdata('set_firma_id');
//
//
//
//
//        $mt_olusturma_bekleyen  = $this->db->query("SELECT * FROM nakliye_mt_talep Where mt_talep_personel_id = $user_id and mt_id is null")->num_rows();
//        $mt_gider_create_count=0;
//        if($aauth_id==39){
//            $mt_gider_create_count = $this->db->query("SELECT siparis_list_form_new.*,geopos_products.product_name,talep_form_products.product_id FROM siparis_list_form_new
//                 INNER JOIN talep_form_products On siparis_list_form_new.talep_form_product_id = talep_form_products.id
//                 INNER JOIN geopos_products ON talep_form_products.product_id =geopos_products.pid
//                 INNER JOIN talep_form ON talep_form.id =talep_form_products.form_id
//WHERE talep_form_products.gider_durumu=0 and talep_form.gider_durumu=1 group by talep_form.id")->num_rows();
//        }
//
//
//
//
//
//
//
//        $muhasebe_maas_kontrol=0;
//
//        if($user_id==39){
//            $this->db->select('new_bordro.*');
//            $this->db->from('new_bordro_item');
//            $this->db->join('new_bordro','new_bordro_item.bordro_id = new_bordro.id');
//            //$this->db->where('new_bordro.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
//            $this->db->where('new_bordro_item.status', 7);
//            $query = $this->db->get();
//            $muhasebe_maas_kontrol  =  $query->num_rows();
//        }
//
//
//        $forma_2_count=0;
//
//        $forma_2_count = $this->db->query("SELECT * FROM `invoices_onay_new`
//INNER JOIN geopos_invoices On invoices_onay_new.invoices_id=geopos_invoices.id
//WHERE invoices_onay_new.type = 2 AND  geopos_invoices.status=1 and invoices_onay_new.user_id = $aauth_id AND `staff` = 1 $where_invoices")->num_rows();
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
////        $talep_count_bell = $this->pendingtasks();
//        $count_ihale_surec = $this->db->query("SELECT * FROM `talep_form`  INNER JOIN talep_user_satinalma ON talep_form.id = talep_user_satinalma.talep_id WHERE talep_form.status = 3 AND talep_user_satinalma.user_id = $aauth_id  $where_talep_form")->num_rows();
//        $count_transfer_talep_list = $this->db->query("SELECT * FROM `talep_form` INNER JOIN geopos_warehouse On talep_form.transfer_warehouse_id = geopos_warehouse.id   WHERE talep_form.status = 8 and talep_form.transfer_status=1  and talep_form.transfer_bildirim=1 and geopos_warehouse.pers_id = $aauth_id $where_talep_form")->num_rows();
//
//        $where_talep_form='';
//        if($this->session->userdata('set_firma_id')){
//            $where_talep_form.='and talep_form.loc='.$this->session->userdata('set_firma_id');
//            //$this->db->where('virman.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
//        }
//
//        $count_syok_kontrol = stok_kontol_hizmet();
//
//
//        // Ana sayfa atamaları;
//        $talep_form_customer_new = 'and talep_form_customer_new.loc ='.$this->session->userdata('set_firma_id');
//
//        $count_talep_form_customer_new=0;
//        if($this->aauth->get_user()->id==61){
//
//            $count_talep_form_customer_new = $this->db->query("SELECT COUNT(id) as sayi FROM talep_form_customer_new Where status=11 and talep_form_customer_new.type=1  $talep_form_customer_new")->row()->sayi;
//        }
//
//
//        $count_talep_form_nakliye_products=0;
//        $talep_form_nakliye = 'and talep_form_nakliye_products.loc ='.$this->session->userdata('set_firma_id');
//
//        if($this->aauth->get_user()->id==61){
//            $count_talep_form_nakliye_products = $this->db->query("SELECT COUNT(id) as sayi FROM talep_form_nakliye_products Where status=11 $talep_form_nakliye")->row()->sayi;
//        }
//
//        $talep_form_customer = 'and talep_form_customer.loc ='.$this->session->userdata('set_firma_id');
//
//        $count_talep_form_customer=0;
//        if($this->aauth->get_user()->id==61){
//            $count_talep_form_customer = $this->db->query("SELECT COUNT(id) as sayi FROM talep_form_customer Where status=11 and talep_form_customer.type=2  $talep_form_customer")->row()->sayi;
//        }
//
//        $where_loc_personel = 'and talep_form_personel.loc ='.$this->session->userdata('set_firma_id');
//
//        $count_talep_form_personel=0;
//        if($this->aauth->get_user()->id==61){
//            $count_talep_form_personel = $this->db->query("SELECT COUNT(id) as sayi FROM talep_form_personel Where status=11 and talep_form_personel.tip=2  $where_loc_personel")->row()->sayi;
//        }
//
//        $count_talep_form_personel_=0;
//        if($this->aauth->get_user()->id==61){
//            $count_talep_form_personel_ = $this->db->query("SELECT COUNT(id) as sayi FROM talep_form_personel Where status=11 and talep_form_personel.tip=1  $where_loc_personel")->row()->sayi;
//        }
//
//
//        // Ana sayfa atamaları;
//
//
//        //odeme Onayı Bekleyen
//
//
//        $odeme_onayi_bekleyen = 0;
//        $result = $this->db->query("SELECT * FROM talep_form Where talep_form.status = 20 $where_talep_form");
//        if($result->num_rows()){
//            foreach ($result->result() as $items){
//                $avans_sorgu = $this->db->query("SELECT * FROM talep_form_avans Where talep_id = $items->id and type = 2 and status_id=3");
//                if($avans_sorgu->num_rows()){
//                    foreach ($avans_sorgu->result() as $values){
//                        $avans_talep_id = $values->id;
//                        if($aauth_id==talep_form_sort_why($avans_talep_id)->staff_id){
//                            $odeme_onayi_bekleyen++;
//                        }
//                    }
//                }
//            }
//        }
//
//        //odeme Onayı Bekleyen
//
//
//        //satınalma nakliye say
//        $user_id=$this->aauth->get_user()->id;
//        $count_nakliye_tejlif_bekleyen = 0;
//        //if($user_id==lojistik_yetkili_id()){
//        if($user_id==lojistik_yetkili_id()){
//            $count_nakliye_tejlif_bekleyen = $this->db->query("SELECT * FROM talep_form_nakliye Where status=3")->num_rows();
//        }
//
//        //satınalma nakliye say
//        $count_podradci_onayi = $this->db->query("SELECT COUNT(id) as sayi FROM talep_borclandirma Where durum=0 and staff_id=$user_id")->row()->sayi;
//
//        $count=
//            $kasa_count+
//            $maas_count+
//            $bekleyen_maas_count+
//            $forma_2_count+
//            $bekleyen_prim_count+
//            $razi_count+
//            $bordro_edit_count+
//            $lojistikhizmetcount+
//            $count_malzeme+
//            $count_pers_satinalma+
//            $count_ihale+
//            $sened_list_count+
//            $tehvil_lsit_count+ //$siparislist+$siparis_finish+
//            $count_qaime+
//            $count_transfer_warehouse+
//            $count_talep_transfer_warehouse+
//            $count_odeme+
//            $count_transfer_talep_list+
//            $muhasebe_maas_kontrol+
//            $count_task_personel+
//            $count_odme_t+
//            $count_avans_t+
//            $count_ihale_surec+
//            $count_odme_emri+
//            $hm_bekleyen+
//            $mt_gider_create_count+
//            $mt_olusturma_bekleyen+
//            $count_invoice_onay+
//            $count_syok_kontrol+
//            $count_talep_form_customer_new+
//            $count_talep_form_nakliye_products+
//            $count_talep_form_customer+
//            $count_talep_form_personel+
//            $count_talep_form_personel_+
//            $odeme_onayi_bekleyen+
//            $count_nakliye_tejlif_bekleyen+
//            $count_podradci_onayi;
//
//
//
//
//
//        echo json_encode(array('status' => 'Success', 'count' =>$count));
//
//
//
//    }

    public function select_count(){
        //$talep_count_bell = $this->pendingtasks();
        $kasa_count=0;
        $id =  $this->aauth->get_user()->id;
        $aauth_id =  $this->aauth->get_user()->id;


        $this->db->select('v.*');
        $this->db->from('virman_onay');
        $this->db->join('virman v','virman_onay.virman_id = v.id');
        $this->db->where('virman_onay.user_id',$id);
        $this->db->where('virman_onay.staff',1);
        $this->db->where('virman_onay.status is null');
        $query = $this->db->get();
        $kasa_count =  $query->num_rows();

        $bekleyen_maas_count=0;

        $this->db->select('new_bordro.*');
        $this->db->from('salary_onay_new');
        $this->db->join('new_bordro_item','salary_onay_new.bordro_item_id = new_bordro_item.id');
        $this->db->join('new_bordro','new_bordro_item.bordro_id = new_bordro.id');
        $this->db->where('new_bordro_item.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        $this->db->where('salary_onay_new.staff', 1);
        $this->db->where('salary_onay_new.user_id', $this->aauth->get_user()->id);
        $this->db->where_not_in('new_bordro_item.status',[4,3]);
        $query = $this->db->get();
        $bekleyen_maas_count  =  $query->num_rows();



//        $kontrol_details = $this->db->query("SELECT * FROM salary_odeme_kontrol Where user_id = $id and status = 0 GROUP BY proje_id");
//
//        if($kontrol_details->num_rows()){
//            foreach ($kontrol_details->result() as $kontrol_items){
//                $hesaplama_ayi = $kontrol_items->hesaplama_ayi;
//                $hesaplama_yili = $kontrol_items->hesaplama_yili;
//                $proje_id =$kontrol_items->proje_id;
//                $sort_kontrol = $this->db->query("SELECT * FROM `maas_onay_sort` Where proje_id = $proje_id ORDER BY `maas_onay_sort`.`sort` DESC LIMIT 1");
//                if($sort_kontrol->num_rows()){
//                    $yetkili_id = $sort_kontrol->row()->user_id; //61
//                    $salart_details = $this->db->query("SELECT salary_onay.* FROM `salary_onay`
//                                  INNER JOIN salary_report ON salary_onay.salary_report_id = salary_report.id Where
//                                  salary_onay.user_id =$yetkili_id and  (salary_onay.nakit_status= 1 or salary_onay.banka_status = 1) and
//                                    (salary_report.cache_pay_odenis=0 or salary_report.bank_pay_odenis=0) and salary_report.proje_id=$proje_id");
//                    if($salart_details->num_rows()>0){
//                        $bekleyen_maas_count+=$salart_details->num_rows();
//                    }
//
//                }
//            }
//        }
        $forma_2_count=0;

//        if($this->aauth->get_user()->id == 39 || $this->aauth->get_user()->id == 174) {
//            $salart_details = $this->db->query("SELECT * FROM `geopos_invoices` Where status = 19");
//            if ($salart_details->num_rows() > 0) {
//                $forma_2_count = $salart_details->num_rows();
//
//            } else {
//                $forma_2_count = 0;
//            }
//        }

        $where_invoices=' and geopos_invoices.loc='.$this->session->userdata('set_firma_id');
        $forma_2_count = $this->db->query("SELECT * FROM `invoices_onay_new` 
INNER JOIN geopos_invoices On invoices_onay_new.invoices_id=geopos_invoices.id
WHERE invoices_onay_new.type = 2 AND  geopos_invoices.status=1 and invoices_onay_new.user_id = $aauth_id AND `staff` = 1 $where_invoices")->num_rows();



        $bekleyen_prim_count = 0;

        $salart_details = $this->db->query("SELECT * FROM `personel_prim_onay` Where staff_id= $id and  is_staff= 1 and status=0");
        if($salart_details->num_rows()>0){
            $bekleyen_prim_count =$salart_details->num_rows();

        }
        else {
            $bekleyen_prim_count = 0;
        }

        $where_talep_form='and talep_form.loc='.$this->session->userdata('set_firma_id');
        $talep_count_bell = $this->db->query("SELECT * FROM `talep_onay_new` 
INNER JOIN talep_form On talep_onay_new.talep_id=talep_form.id
WHERE talep_onay_new.type = 1 AND  talep_form.status=1 and talep_onay_new.user_id = $id AND `staff` = 1 $where_talep_form")->num_rows();


        echo json_encode(array('status' =>
            'Success',
            'kasa_count' =>$kasa_count,
            'bekleyen_prim_count' =>$bekleyen_prim_count,
            'forma_2_count' =>$forma_2_count,
            'bekleyen_maas_count' =>$bekleyen_maas_count,
            'talep_count_bell' =>$talep_count_bell,
        ));
    }

    public function get_duyuru(){
        $id =  $this->aauth->get_user()->id;
        $duyuru_details = $this->db->query("SELECT duyuru.* FROM `duyuru` Where status=1");
        $array=[];
        if($duyuru_details->num_rows()){
            foreach ($duyuru_details->result() as $items){
                $onay_details =  $this->db->query("SELECT * FROM `duyuru_onay` Where duyuru_id=$items->id and user_id= $id LIMIT 1");
                if(!$onay_details->num_rows())
                {
                    $array[]=[
                        'id'=>$items->id,
                        'text'=>$items->text
                    ];
                }
            }
            echo json_encode(array('status' =>
                200,
                'details' =>$array
            ));

        }
        else{
            echo json_encode(array('status' =>
                410
            ));
        }

    }

    public function duyuru_onay(){
        $id =  $this->aauth->get_user()->id;
        $duyuru_id = $this->input->post('id');

        $data['duyuru_id'] = $duyuru_id;
        $data['user_id'] = $id;


        if($this->db->insert('duyuru_onay', $data)){
            echo json_encode(array('status' =>
                200,
                'message'=>'Başarılı Bir Şekilde Güncellendi'
            ));
        }
        else{
            echo json_encode(array('status' =>
                410,
                'message'=>'Hata Aldınız'
            ));
        }
    }
}
