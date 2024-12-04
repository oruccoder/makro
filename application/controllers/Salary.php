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

class Salary Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('salary_model', 'model');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }
    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Bordro İşlemleri';
        $this->load->view('fixed/header', $head);
        $this->load->view('salary/index');
        $this->load->view('fixed/footer');
    }
    public function bordro_history($id)
    {
        if (!$this->aauth->premission(84)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        } else {
            $data['details']=$this->model->details($id);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Bordro Hareketleri';
            $this->load->view('fixed/header', $head);
            $this->load->view('salary/bordro_history',$data);
            $this->load->view('fixed/footer');
        }
    }
    public function allbordro()
    {
        if (!$this->aauth->premission(84)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        } else {

             $date = new DateTime('now');
             $m=date('m');
             $y = date('Y');
             $data['m']=$m;
             $data['y']=$y;
             $data['bordro_projeleri'] = $this->db->query("SELECT geopos_projects.* FROM new_bordro INNER JOIN geopos_projects ON geopos_projects.id =new_bordro.proje_id where new_bordro.ay=$m and new_bordro.yil=$y and new_bordro.status!=3")->result();
             $data['total_pers'] = $this->db->query("SELECT * FROM new_bordro_item where new_bordro_item.bordro_ayi=$m and new_bordro_item.bordro_yili=$y and new_bordro_item.status!=3")->num_rows();
             $data['all_details_items_ay_yil']=$this->model->all_details_items_ay_yil($m,$y);
             $n=$this->db->query("SELECT  IF(SUM(nakit_odenilecek),SUM(nakit_odenilecek),0) as nakit_odenilecek FROM new_bordro_item where new_bordro_item.bordro_ayi=$m and new_bordro_item.bordro_yili=$y and new_bordro_item.status!=3")->row()->nakit_odenilecek;
             $b=$this->db->query("SELECT IF(SUM(bankadan_odenilecek),SUM(bankadan_odenilecek),0) as bankadan_odenilecek FROM new_bordro_item where new_bordro_item.bordro_ayi=$m and new_bordro_item.bordro_yili=$y and new_bordro_item.status!=3")->row()->bankadan_odenilecek;
             $data['nakit_odenilcek']= $n;
             $data['bankadan_odenilecek']=$b;
            $data['azn_nakit_odenilcek']= amountFormat($n);
            $data['azn_bankadan_odenilecek']=amountFormat($b);


             $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Tüm Bordrolar';
            $this->load->view('fixed/header', $head);
            $this->load->view('salary/allbordro',$data);
            $this->load->view('fixed/footer');
        }
    }

    public function muhasebe()
    {
        if (!$this->aauth->premission(84)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Bordro İşlemleri';
            $this->load->view('fixed/header', $head);
            $this->load->view('salary/muhasebe');
            $this->load->view('fixed/footer');
        }
    }
    public function ajax_list()
    {

        $list = $this->model->get_datatables_details();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $view = "<a target='_blank' class='btn btn-success' href='/salary/view/$prd->id'><i class='fa fa-eye'></i></a>&nbsp;";
            $ban = "<button  class='btn btn-danger iptal' data-id='$prd->id'><i class='fa fa-ban'></i></button>&nbsp;";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->code;
            $row[] = az_month($prd->ay)->month.' | '.$prd->yil;
            $row[] = proje_name($prd->proje_id);
            $row[] = personel_details($prd->aauth_id);
            $row[] = $prd->desc;
            $row[] = bordro_status($prd->status)->name.' '.$prd->iptal_desc;
            $row[] = $view.' '.$ban;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all(),
            "recordsFiltered" => $this->model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_muhasebe_kontrol()
    {

        $list = $this->model->get_datatables_details_muhasebe();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $view = "<a target='_blank' class='btn btn-success' href='/salary/muhasebe_view
/$prd->id'><i class='fa fa-eye'></i></a>&nbsp;";
            $ban = "<button  class='btn btn-danger iptal' data-id='$prd->id'><i class='fa fa-ban'></i></button>&nbsp;";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->code;
            $row[] = az_month($prd->ay)->month.' | '.$prd->yil;
            $row[] = proje_name($prd->proje_id);
            $row[] = personel_details($prd->aauth_id);
            $row[] = $prd->desc;
            $row[] = bordro_status($prd->status)->name.' '.$prd->iptal_desc;
            $row[] = $view.' '.$ban;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_muhasebe(),
            "recordsFiltered" => $this->model->count_filtered_muhasebe(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_onay()
    {

        $list = $this->model->get_datatables_details_onay();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $view = "<a target='_blank' class='btn btn-success' href='/salary/onay_view/$prd->id'><i class='fa fa-eye'></i></a>&nbsp;";
            $ban = "<button  class='btn btn-danger iptal' data-id='$prd->id'><i class='fa fa-ban'></i></button>&nbsp;";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->code;
            $row[] = az_month($prd->ay)->month.' | '.$prd->yil;
            $row[] = proje_name($prd->proje_id);
            $row[] = personel_details($prd->aauth_id);
            $row[] = $prd->desc;
            $row[] = bordro_status($prd->status)->name.' '.$prd->iptal_desc;
            $row[] = $view.' '.$ban;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_onay(),
            "recordsFiltered" => $this->model->count_filtered_onay(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_muhasebe()
    {

        $list = $this->model->get_datatables_details_muhasebe();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $view = "<a target='_blank' class='btn btn-success' href='/salary/muhasebe_view/$prd->id'><i class='fa fa-eye'></i></a>&nbsp;";
            $ban = "<button  class='btn btn-danger iptal' data-id='$prd->id'><i class='fa fa-ban'></i></button>&nbsp;";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->code;
            $row[] = az_month($prd->ay)->month.' | '.$prd->yil;
            $row[] = proje_name($prd->proje_id);
            $row[] = personel_details($prd->aauth_id);
            $row[] = $prd->desc;
            $row[] = bordro_status($prd->status)->name.' '.$prd->iptal_desc;
            $row[] = $view.' '.$ban;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_muhasebe(),
            "recordsFiltered" => $this->model->count_filtered_muhasebe(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function create_save(){
        $this->db->trans_start();
        $result = $this->model->create_save();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['messages'],'link'=>'/salary/view/'.$result['id']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['messages']));
        }

    }
    public function view($id){
        $details = $this->model->details($id);
        $details_items = $this->model->details_items($id);

        if($this->aauth->get_user()->id == 664){
            if($details->proje_id==75){
                $head['usernm'] = $this->aauth->get_user()->username;
                $data['details']=$details;
                $data['details_items']=$details_items;
                $data['all_details_items_ay_yil']=$this->model->all_details_items_ay_yil($details->ay,$details->yil);
                $head['title'] = $details->code.' - Bordro İşlemleri';
                $this->load->view('fixed/header', $head);
                $this->load->view('salary/view',$data);
                $this->load->view('fixed/footer');
            }
            else {
                exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
            }
        }
        else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['details']=$details;
            $data['details_items']=$details_items;
            $data['all_details_items_ay_yil']=$this->model->all_details_items_ay_yil($details->ay,$details->yil);
            $head['title'] = $details->code.' - Bordro İşlemleri';
            $this->load->view('fixed/header', $head);
            $this->load->view('salary/view',$data);
            $this->load->view('fixed/footer');
        }


    }

    public function onay_view($id){
        $details = $this->model->details($id);
        $details_items = $this->model->details_items($id);
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['details']=$details;
        $data['details_items']=$details_items;
        $data['all_details_items_ay_yil']=$this->model->all_details_items_ay_yil($details->ay,$details->yil);
        $head['title'] = $details->code.' - Bordro İşlemleri';
        $this->load->view('fixed/header', $head);
        $this->load->view('salary/onay_view',$data);
        $this->load->view('fixed/footer');
    }

    public function muhasebe_view($id){
        if (!$this->aauth->premission(84)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        } else {

            $details = $this->model->details($id);
            $details_items = $this->model->details_items($id);
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['details']=$details;
            $data['details_items']=$details_items;
            $data['all_details_items_ay_yil']=$this->model->all_details_items_ay_yil($details->ay,$details->yil);
            $head['title'] = $details->code.' - Bordro İşlemleri';
            $this->load->view('fixed/header', $head);
            $this->load->view('salary/muhasebe_view',$data);
            $this->load->view('fixed/footer');
        }
    }
    public function status_change(){
        $this->db->trans_start();
        $result = $this->model->status_change();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['messages']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['messages']));
        }
    }

    public function ajax_list_items()
    {

        $salary_config = $this->config->item('salary');
        $list = $this->model->get_datatables_details_items();
        $data = array();
        $no = $this->input->post('start');
        $list_tipi = $this->input->post('tip');

        foreach ($list as $prd) {

            $m = $prd->bordro_ayi;
            $y = $prd->bordro_yili;
            $total_pazar = total_sundays($m,$y);
            $total_ay_sayisi_ = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
            $total_ay_sayisi = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
            $tatil_hesaplama = tatil_gunleri($m,$y);
            if($tatil_hesaplama){
                $total_ay_sayisi=floatval($total_ay_sayisi_)-$tatil_hesaplama;
            }
            $is_gunu = floatval($total_ay_sayisi)-floatval($total_pazar);
            $salary_details = $this->db->query("SELECT * FROM personel_salary Where personel_id = $prd->pers_id and status = 1")->row();




            $view = "<a target='_blank' class='btn btn-success' href='/salary/view/$prd->id'><i class='fa fa-eye'></i></a>&nbsp;";
            $ban = "<button  class='btn btn-danger iptal' data-id='$prd->id'><i class='fa fa-ban'></i></button>&nbsp;";
            $no++;

            $toplam_maas=$salary_details->salary;
            $brut_maas=$salary_details->bank_salary;
            $net_maas = net_maas_hesaplama($prd->pers_id,$is_gunu);
            $nakit_hakedis = 0;
            $banka_hakedis = 0;



            $borc_total = $this->personel_borc_ogren($prd->pers_id);
            $pers_bakiye=$this->personel_bakiye($prd->pers_id);


            $total_nakit_avans=0;
            $total_banka_avans=0;
            $total_banka_borc=0;
            $total_nakit_borc=0;
            $total_nakit_alacak=0;
            $total_banka_alacak=0;

            if($pers_bakiye['nakit_bakiye_status']==1){
                $total_nakit_avans=$pers_bakiye['nakit_bakiye'];
            }
            if($pers_bakiye['banka_bakiye_status']==1){
                $total_banka_avans=$pers_bakiye['banka_bakiye'];
            }


            if($pers_bakiye['nakit_bakiye_status']==0){
                $total_nakit_alacak=$pers_bakiye['nakit_bakiye'];
            }
            if($pers_bakiye['banka_bakiye_status']==0){
                $total_banka_alacak=$pers_bakiye['banka_bakiye'];
            }

            if($borc_total['nakit_bakiye_status']==1){
                $total_nakit_borc=$borc_total['nakit_bakiye'];
            }
            if($borc_total['banka_bakiye_status']==1){
                $total_banka_borc=$borc_total['banka_bakiye'];
            }

            if($prd->banka_alacak_bakiye > 0)  {  $alacak_banka_bakiye = $prd->banka_alacak_bakiye; } else  {  $alacak_banka_bakiye = $total_banka_alacak; }
            if($prd->nakit_alacak_bakiye > 0)  {  $alacak_nakit_bakiye = $prd->nakit_alacak_bakiye; } else  {  $alacak_nakit_bakiye = $total_nakit_alacak; }
            if($prd->banka_borc_bakiye > 0)  {  $borc_banka_bakiye = $prd->banka_borc_bakiye; } else  {  $borc_banka_bakiye = $total_banka_avans; }
            if($prd->nakit_borc_bakiye > 0)  {  $borc_nakit_bakiye = $prd->nakit_borc_bakiye; } else  {  $borc_nakit_bakiye = $total_nakit_avans; }





//            $toplam_borc = $total_banka_borc+$total_nakit_borc+$total_banka_avans+$total_nakit_avans;



            $banka_hesaplanan=0;
            $mezuniyet_hesap=0;
            $cemi=0;
            $personel_mezuniyet=$prd->mezuniyet;
            $hastalik_amouth=$prd->hastalik;

            //Eski
            $dsmf_isveren=0;
            $dsmf_isci=0;
            $icbari_sigorta_isveren=0;
            $icbari_sigorta_isci=0;
            $gelir_vergisi=0;
            $banka_salary=$brut_maas;
            $salary=$toplam_maas;
            $mezuniyet_hesap = 0;
            $calisilan_gun_sayisi = $prd->r_gercek_is_gunu;
            $calisilan_gun_sayisi_ = $prd->r_gercek_is_gunu;
            $hesap =0;
            $cemi =0;
            $issizlik_isveren =0;
            $issizlik_isci =0;
            $odenilecek_meblaq =0;
            $kesinti =0;
            $hesaplanan =0;
            $fark =0;
            $banka_hesaplanan =0;
            //Eski
            $prim=0;
            $ceza=0;
            $dusulen_gune_gore_meblaq=0;


            $date = new DateTime('now');

            $filter_Date = $date->format('Y-'.$m.'-'.$total_ay_sayisi_.' 23:59:59');
            $filter_Date_s = $date->format('Y-'.$m.'-01  00:00:00');
            //echo "SELECT SUM(total) as total FROM geopos_invoices Where invoicedate  BETWEEN '$filter_Date_s' AND '$filter_Date' AND invoice_type_id = 15 and  csd=$invoices->id";die();
            $prim = $this->db->query("SELECT IF(SUM(total),SUM(total),0) as total FROM geopos_invoices Where invoicedate  BETWEEN '$filter_Date_s' AND '$filter_Date' AND invoice_type_id = 15 and  csd=$prd->pers_id")->row()->total;
            $ceza = $this->db->query("SELECT IF(SUM(total),SUM(total),0) as total FROM geopos_invoices Where invoicedate  BETWEEN '$filter_Date_s' AND '$filter_Date' AND  invoice_type_id = 53 and  csd=$prd->pers_id")->row()->total;


            $total_n_son_bakiye = $total_nakit_avans+$total_nakit_borc;
            $total_b_son_bakiye = $total_banka_avans+$total_banka_borc;


            $banka_odenilecek=$banka_hakedis-$total_b_son_bakiye;
            $nakit_odenilecek=$nakit_hakedis-$total_n_son_bakiye+$prim-$ceza;





            if($salary_details->salary_type==1){
                $nakit_net_salary = $salary_details->salary;
                $total_ay_sayisi = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
                $gunluk = $nakit_net_salary/$total_ay_sayisi;
                $nakit_hakedis = $gunluk*$prd->gercek_is_gunu;
                $nakit_odenilecek=$nakit_hakedis-$prd->nakit_kesilecek;
            }
            elseif($salary_details->salary_type==2){

                $banka_hesaplanan= floatval($banka_salary)/$is_gunu*$prd->r_gercek_is_gunu;
                if($personel_mezuniyet >0){
                    $hesap = ( floatval($banka_salary)/floatval($salary_config['mezuniyet_oran']))  * floatval($personel_mezuniyet);
                    $mezuniyet_hesap = round( $hesap,2);
                }
                $cemi = floatval($mezuniyet_hesap)+floatval($banka_hesaplanan)+floatval($hastalik_amouth);
                $cemi=round($cemi,2);
                $cemi=$cemi+$prd->maas_tamamlama_tutari;

                if((floatval($cemi)-floatval($hastalik_amouth)) > $salary_config['salary_200']){
                    $dsmf_isveren = $salary_config['200_buyuk_toplam'] + ($cemi-$hastalik_amouth-$salary_config['salary_200'])*$salary_config['200_buyuk_oran'];
                }
                else {
                    $dsmf_isveren = ($cemi-$hastalik_amouth)*$salary_config['200_kucuk_oran'];
                }
                $dsmf_isveren=round($dsmf_isveren,2);
                $issizlik_isveren = round(($cemi-$hastalik_amouth) * ($salary_config['issizlik_oran']/100),3);
                $issizlik_isveren=round($issizlik_isveren,2);
                $issizlik_isci =  floatval(($cemi-$hastalik_amouth))*($salary_config['issizlik_oran']/100);
                $issizlik_isci=round($issizlik_isci,2);
                if($cemi<=floatval($salary_config['icbari_tavan'])){
                    $icbari_sigorta_isveren = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
                    $icbari_sigorta_isci = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
                }
                elseif($cemi>$salary_config['icbari_tavan']) {
                    $icbari_sigorta_isveren = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*$salary_config['icbari_tavan_orani']/100;
                    $icbari_sigorta_isci = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*$salary_config['icbari_tavan_orani']/100;
                }
                $icbari_sigorta_isci=round($icbari_sigorta_isci,2);
                $icbari_sigorta_isveren=round($icbari_sigorta_isveren,2);
                if(($cemi-$hastalik_amouth) > floatval($salary_config['salary_200'])){
                    $dsmf_isci = $salary_config['dsmf_isci_float'] + ($cemi-$hastalik_amouth-$salary_config['salary_200'])*$salary_config['dsmf_isci_oran_max']/100;
                }
                else {
                    $dsmf_isci = ($cemi-$hastalik_amouth)*floatval($salary_config['dsmf_isci_oran_min'])/100;

                }
                $dsmf_isci=round($dsmf_isci,2);
                if($cemi > $salary_config['icbari_tavan']){
                    $gelir_vergisi = ($cemi-$salary_config['icbari_tavan'])*floatval($salary_config['gelir_vergi_oran'])/100;
                }
                else {
                    $gelir_vergisi=0;
                }
                $gelir_vergisi=round($gelir_vergisi,2);
                $kesinti=floatval($dsmf_isci)+floatval($gelir_vergisi)+floatval($icbari_sigorta_isci)+floatval($issizlik_isci);
                $odenilecek_meblaq = floatval($cemi)-floatval($kesinti);
                if($calisilan_gun_sayisi==0 && $mezuniyet_hesap==0){
                    $odenilecek_meblaq = 0;
                }

                if($prd->r_gercek_is_gunu==0){
                    $odenilecek_meblaq=$odenilecek_meblaq+$hastalik_amouth;
                }
                $banka_hakedis = $odenilecek_meblaq;
                $odenilecek_meblaq=$odenilecek_meblaq-$prd->banka_kesilecek;
                $nakit_odenilecek=0;
                $banka_odenilecek=$odenilecek_meblaq;

                $date = date("$prd->bordro_yili-$prd->bordro_ayi-28");
                $newdate = date("Y-m-28", strtotime ( '-1 month' , strtotime ( $date ) )) ;


                $prc = explode('-',$newdate);
                $old_y = $prc[0];
                $old_m = $prc[1];
                $bordro_kontrol = $this->db->query("SELECT * FROM new_bordro_item Where 
                            bordro_yili=$old_y and bordro_ayi=$old_m and        
                            pers_id=$prd->pers_id and status  IN (1,2,5,6,7,8)");


                if($bordro_kontrol->num_rows()){
                    if($bordro_kontrol->row()->banka_odeme_durumu==0){
                        $old_banka_borc_bakiye=$bordro_kontrol->row()->banka_avans;
                        $old_kesilecek_banka=$bordro_kontrol->row()->banka_kesilecek;
                        $old_bakiye=$old_banka_borc_bakiye-$old_kesilecek_banka;
                        $total_b_son_bakiye=$old_bakiye;
                    }

                }

            }
            elseif($salary_details->salary_type==3){
                $banka_hesaplanan= floatval($banka_salary)/$is_gunu*$prd->r_gercek_is_gunu;
                if($personel_mezuniyet >0){
                    $hesap = ( floatval($banka_salary)/floatval($salary_config['mezuniyet_oran']))  * floatval($personel_mezuniyet);
                    $mezuniyet_hesap = round( $hesap,2);
                }
                $cemi = floatval($mezuniyet_hesap)+floatval($banka_hesaplanan)+floatval($hastalik_amouth);
                $cemi=round($cemi,2);
                if((floatval($cemi)-floatval($hastalik_amouth)) > $salary_config['salary_200']){
                    $dsmf_isveren = $salary_config['200_buyuk_toplam'] + ($cemi-$hastalik_amouth-$salary_config['salary_200'])*$salary_config['200_buyuk_oran'];
                }
                else {
                    $dsmf_isveren = ($cemi-$hastalik_amouth)*$salary_config['200_kucuk_oran'];
                }
                $dsmf_isveren=round($dsmf_isveren,2);
                $issizlik_isveren = round(($cemi-$hastalik_amouth) * ($salary_config['issizlik_oran']/100),3);
                $issizlik_isveren=round($issizlik_isveren,2);
                $issizlik_isci =  floatval(($cemi-$hastalik_amouth))*($salary_config['issizlik_oran']/100);
                $issizlik_isci=round($issizlik_isci,2);
                if($cemi<=floatval($salary_config['icbari_tavan'])){
                    $icbari_sigorta_isveren = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
                    $icbari_sigorta_isci = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
                }
                elseif($cemi>$salary_config['icbari_tavan']) {
                    $icbari_sigorta_isveren = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*$salary_config['icbari_tavan_orani']/100;
                    $icbari_sigorta_isci = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*$salary_config['icbari_tavan_orani']/100;
                }
                $icbari_sigorta_isci=round($icbari_sigorta_isci,2);
                $icbari_sigorta_isveren=round($icbari_sigorta_isveren,2);
                if(($cemi-$hastalik_amouth) > floatval($salary_config['salary_200'])){
                    $dsmf_isci = $salary_config['dsmf_isci_float'] + ($cemi-$hastalik_amouth-$salary_config['salary_200'])*$salary_config['dsmf_isci_oran_max']/100;
                }
                else {
                    $dsmf_isci = ($cemi-$hastalik_amouth)*floatval($salary_config['dsmf_isci_oran_min'])/100;

                }
                $dsmf_isci=round($dsmf_isci,2);
                if($cemi > $salary_config['icbari_tavan']){
                    $gelir_vergisi = ($cemi-$salary_config['icbari_tavan'])*floatval($salary_config['gelir_vergi_oran'])/100;
                }
                else {
                    $gelir_vergisi=0;
                }
                $gelir_vergisi=round($gelir_vergisi,2);
                $kesinti=floatval($dsmf_isci)+floatval($gelir_vergisi)+floatval($icbari_sigorta_isci)+floatval($issizlik_isci);
                $odenilecek_meblaq = floatval($cemi)-floatval($kesinti);
                if($calisilan_gun_sayisi==0 && $mezuniyet_hesap==0){
                    $odenilecek_meblaq = 0;
                }

                $banka_hakedis = $odenilecek_meblaq;
                $odenilecek_meblaq=$odenilecek_meblaq-$prd->banka_kesilecek;
                $nakit_odenilecek=0;
                $banka_odenilecek=$odenilecek_meblaq;
            }
            elseif($salary_details->salary_type==4){
                $total_ay_sayisi = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
                $toplam_maas = $total_ay_sayisi*$salary_details->salary_day;
                $net_maas = $toplam_maas;
                $brut_maas = $toplam_maas;
                $nakit_hakedis = $prd->gercek_is_gunu * $salary_details->salary_day;
                $nakit_odenilecek = $nakit_hakedis-$prd->nakit_kesilecek+$prd->prim;

            }
            elseif($salary_details->salary_type==6){ // Aylık nakit / Banka


//                $nakit_net_salary = $salary_details->net_salary;
//                $total_ay_sayisi = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
//                $gunluk = $nakit_net_salary/$total_ay_sayisi;
//                $nakit_hakedis = $gunluk*$prd->gercek_is_gunu;



                $banka_hesaplanan= floatval($banka_salary)/$is_gunu*$prd->r_gercek_is_gunu;
                if($personel_mezuniyet >0){
                    $hesap = ( floatval($banka_salary)/floatval($salary_config['mezuniyet_oran']))  * floatval($personel_mezuniyet);
                    $mezuniyet_hesap = round( $hesap,2);
                }
                $cemi = floatval($mezuniyet_hesap)+floatval($banka_hesaplanan)+floatval($hastalik_amouth);
                $cemi=round($cemi,2);
                $cemi=$cemi+$prd->maas_tamamlama_tutari;




                $cemi=round($cemi,2);
                if((floatval($cemi)-floatval($hastalik_amouth)) > $salary_config['salary_200']){
                    $dsmf_isveren = $salary_config['200_buyuk_toplam'] + ($cemi-$hastalik_amouth-$salary_config['salary_200'])*$salary_config['200_buyuk_oran'];
                }
                else {
                    $dsmf_isveren = ($cemi-$hastalik_amouth)*$salary_config['200_kucuk_oran'];
                }
                $dsmf_isveren=round($dsmf_isveren,2);
                $issizlik_isveren = round(($cemi-$hastalik_amouth) * ($salary_config['issizlik_oran']/100),3);
                $issizlik_isveren=round($issizlik_isveren,2);
                $issizlik_isci =  floatval(($cemi-$hastalik_amouth))*($salary_config['issizlik_oran']/100);
                $issizlik_isci=round($issizlik_isci,2);
                if($cemi<=floatval($salary_config['icbari_tavan'])){
                    $icbari_sigorta_isveren = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
                    $icbari_sigorta_isci = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
                }
                elseif($cemi>$salary_config['icbari_tavan']) {
                    $icbari_sigorta_isveren = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*$salary_config['icbari_tavan_orani']/100;
                    $icbari_sigorta_isci = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*$salary_config['icbari_tavan_orani']/100;
                }
                $icbari_sigorta_isci=round($icbari_sigorta_isci,2);
                $icbari_sigorta_isveren=round($icbari_sigorta_isveren,2);
                if(($cemi-$hastalik_amouth) > floatval($salary_config['salary_200'])){
                    $dsmf_isci = $salary_config['dsmf_isci_float'] + ($cemi-$hastalik_amouth-$salary_config['salary_200'])*$salary_config['dsmf_isci_oran_max']/100;
                }
                else {
                    $dsmf_isci = ($cemi-$hastalik_amouth)*floatval($salary_config['dsmf_isci_oran_min'])/100;

                }
                $dsmf_isci=round($dsmf_isci,2);
                if($cemi > $salary_config['icbari_tavan']){
                    $gelir_vergisi = ($cemi-$salary_config['icbari_tavan'])*floatval($salary_config['gelir_vergi_oran'])/100;
                }
                else {
                    $gelir_vergisi=0;
                }
                $gelir_vergisi=round($gelir_vergisi,2);
                $kesinti=floatval($dsmf_isci)+floatval($gelir_vergisi)+floatval($icbari_sigorta_isci)+floatval($issizlik_isci);
                $odenilecek_meblaq = floatval($cemi)-floatval($kesinti);
                if($calisilan_gun_sayisi==0 && $mezuniyet_hesap==0){
                    $odenilecek_meblaq = 0;
                }

                $banka_hakedis = $odenilecek_meblaq;
                $odenilecek_meblaq=$banka_hakedis-$prd->banka_kesilecek;
                $banka_odenilecek=$banka_hakedis-$prd->banka_kesilecek;



                $nakit_hakedis = $salary_details->net_salary;


                $nakit_net_salary = $salary_details->net_salary;
                $total_ay_sayisi = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
                $gunluk = $nakit_net_salary/$is_gunu;
                $nakit_hakedis = $gunluk*$prd->gercek_is_gunu;




                $nakit_odenilecek=$nakit_hakedis-$prd->nakit_kesilecek;


                $date = date("$prd->bordro_yili-$prd->bordro_ayi-28");
                $newdate = date("Y-m-28", strtotime ( '-1 month' , strtotime ( $date ) )) ;


                $prc = explode('-',$newdate);
                $old_y = $prc[0];
                $old_m = $prc[1];
                $bordro_kontrol = $this->db->query("SELECT * FROM new_bordro_item Where 
                            bordro_yili=$old_y and bordro_ayi=$old_m and        
                            pers_id=$prd->pers_id and status  IN (1,2,5,6,7,8)");


                if($bordro_kontrol->num_rows()){
                    if($bordro_kontrol->row()->banka_odeme_durumu==0){
                        $old_banka_borc_bakiye=$bordro_kontrol->row()->banka_avans;
                        $old_kesilecek_banka=$bordro_kontrol->row()->banka_kesilecek;
                        $old_bakiye=$old_banka_borc_bakiye-$old_kesilecek_banka;
                        $total_b_son_bakiye=$old_bakiye;
                    }

                    if($bordro_kontrol->row()->nakit_odeme_durumu==0){
                        $old_nakit_borc_bakiye=$bordro_kontrol->row()->nakit_avans;
                        $old_kesilecek_nakit=$bordro_kontrol->row()->nakit_kesilecek;
                        $old_bakiye_n=$old_nakit_borc_bakiye-$old_kesilecek_nakit;
                        $total_n_son_bakiye=$old_bakiye_n;
                    }

                }









            }
            elseif($salary_details->salary_type==12){
                $banka_hesaplanan= floatval($banka_salary)/$is_gunu*$prd->r_gercek_is_gunu;
                if($personel_mezuniyet >0){
                    $hesap = ( floatval($banka_salary)/floatval($salary_config['mezuniyet_oran']))  * floatval($personel_mezuniyet);
                    $mezuniyet_hesap = round( $hesap,2);
                }
                $cemi = floatval($mezuniyet_hesap)+floatval($banka_hesaplanan)+floatval($hastalik_amouth);
                $cemi=round($cemi,2);
                if((floatval($cemi)-floatval($hastalik_amouth)) > $salary_config['salary_200']){
                    $dsmf_isveren = $salary_config['200_buyuk_toplam'] + ($cemi-$hastalik_amouth-$salary_config['salary_200'])*$salary_config['200_buyuk_oran'];
                }
                else {
                    $dsmf_isveren = ($cemi-$hastalik_amouth)*$salary_config['200_kucuk_oran'];
                }
                $dsmf_isveren=round($dsmf_isveren,2);
                $issizlik_isveren = round(($cemi-$hastalik_amouth) * ($salary_config['issizlik_oran']/100),3);
                $issizlik_isveren=round($issizlik_isveren,2);
                $issizlik_isci =  floatval(($cemi-$hastalik_amouth))*($salary_config['issizlik_oran']/100);
                $issizlik_isci=round($issizlik_isci,2);
                if($cemi<=floatval($salary_config['icbari_tavan'])){
                    $icbari_sigorta_isveren = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
                    $icbari_sigorta_isci = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
                }
                elseif($cemi>$salary_config['icbari_tavan']) {
                    $icbari_sigorta_isveren = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*$salary_config['icbari_tavan_orani']/100;
                    $icbari_sigorta_isci = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*$salary_config['icbari_tavan_orani']/100;
                }
                $icbari_sigorta_isci=round($icbari_sigorta_isci,2);
                $icbari_sigorta_isveren=round($icbari_sigorta_isveren,2);
                if(($cemi-$hastalik_amouth) > floatval($salary_config['salary_200'])){
                    $dsmf_isci = $salary_config['dsmf_isci_float'] + ($cemi-$hastalik_amouth-$salary_config['salary_200'])*$salary_config['dsmf_isci_oran_max']/100;
                }
                else {
                    $dsmf_isci = ($cemi-$hastalik_amouth)*floatval($salary_config['dsmf_isci_oran_min'])/100;

                }
                $dsmf_isci=round($dsmf_isci,2);
                if($cemi > $salary_config['icbari_tavan']){
                    $gelir_vergisi = ($cemi-$salary_config['icbari_tavan'])*floatval($salary_config['gelir_vergi_oran'])/100;
                }
                else {
                    $gelir_vergisi=0;
                }
                $gelir_vergisi=round($gelir_vergisi,2);
                $kesinti=floatval($dsmf_isci)+floatval($gelir_vergisi)+floatval($icbari_sigorta_isci)+floatval($issizlik_isci);
                $odenilecek_meblaq = floatval($cemi)-floatval($kesinti);
                if($calisilan_gun_sayisi==0 && $mezuniyet_hesap==0){
                    $odenilecek_meblaq = 0;
                }

                if($prd->r_gercek_is_gunu==0){
                    $odenilecek_meblaq=$odenilecek_meblaq+$hastalik_amouth;
                }
                $banka_hakedis = $odenilecek_meblaq+$prd->maas_tamamlama_tutari;
                $odenilecek_meblaq=$odenilecek_meblaq-$prd->banka_kesilecek;
                $nakit_odenilecek=0;
                $banka_odenilecek=$odenilecek_meblaq;
            }
            elseif($salary_details->salary_type==13){
                $banka_hesaplanan= floatval($banka_salary)/$is_gunu*$prd->r_gercek_is_gunu;
                if($personel_mezuniyet >0){
                    $hesap = ( floatval($banka_salary)/floatval($salary_config['mezuniyet_oran']))  * floatval($personel_mezuniyet);
                    $mezuniyet_hesap = round( $hesap,2);
                }
                $cemi = floatval($mezuniyet_hesap)+floatval($banka_hesaplanan)+floatval($hastalik_amouth);
                $cemi=round($cemi,2);

                if((floatval($cemi)-floatval($hastalik_amouth)) > $salary_config['salary_200']){
                    $dsmf_isveren = $salary_config['200_buyuk_toplam'] + ($cemi-$hastalik_amouth-$salary_config['salary_200'])*$salary_config['200_buyuk_oran'];
                }
                else {
                    $dsmf_isveren = ($cemi-$hastalik_amouth)*$salary_config['200_kucuk_oran'];
                }
                $dsmf_isveren=round($dsmf_isveren,2);
                $issizlik_isveren = round(($cemi-$hastalik_amouth) * ($salary_config['issizlik_oran']/100),3);
                $issizlik_isveren=round($issizlik_isveren,2);
                $issizlik_isci =  floatval(($cemi-$hastalik_amouth))*($salary_config['issizlik_oran']/100);
                $issizlik_isci=round($issizlik_isci,2);
                if($cemi<=floatval($salary_config['icbari_tavan'])){
                    $icbari_sigorta_isveren = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
                    $icbari_sigorta_isci = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
                }
                elseif($cemi>$salary_config['icbari_tavan']) {
                    $icbari_sigorta_isveren = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*$salary_config['icbari_tavan_orani']/100;
                    $icbari_sigorta_isci = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*$salary_config['icbari_tavan_orani']/100;
                }
                $icbari_sigorta_isci=round($icbari_sigorta_isci,2);
                $icbari_sigorta_isveren=round($icbari_sigorta_isveren,2);
                if(($cemi-$hastalik_amouth) > floatval($salary_config['salary_200'])){
                    $dsmf_isci = $salary_config['dsmf_isci_float'] + ($cemi-$hastalik_amouth-$salary_config['salary_200'])*$salary_config['dsmf_isci_oran_max']/100;
                }
                else {
                    $dsmf_isci = ($cemi-$hastalik_amouth)*floatval($salary_config['dsmf_isci_oran_min'])/100;

                }
                $dsmf_isci=round($dsmf_isci,2);
                if($cemi > $salary_config['icbari_tavan']){
                    $gelir_vergisi = ($cemi-$salary_config['icbari_tavan'])*floatval($salary_config['gelir_vergi_oran'])/100;
                }
                else {
                    $gelir_vergisi=0;
                }
                $gelir_vergisi=round($gelir_vergisi,2);
                $kesinti=floatval($dsmf_isci)+floatval($gelir_vergisi)+floatval($icbari_sigorta_isci)+floatval($issizlik_isci);
                $odenilecek_meblaq = floatval($cemi)-floatval($kesinti);
                if($calisilan_gun_sayisi==0 && $mezuniyet_hesap==0){
                    $odenilecek_meblaq = 0;
                }

                if($prd->r_gercek_is_gunu==0){
                    $odenilecek_meblaq=$odenilecek_meblaq+$hastalik_amouth;
                }
                $banka_hakedis = $odenilecek_meblaq+$prd->maas_tamamlama_tutari;
                $odenilecek_meblaq=$odenilecek_meblaq-$prd->banka_kesilecek;
                $nakit_odenilecek=0;
                $banka_odenilecek=$odenilecek_meblaq;
            }



            $check=bordro_onay_kimde($prd->id).' - '.bordro_status($prd->status)->name;
            $disabled='disabled';
            $disabled_='disabled';
            if($list_tipi=='onay' || $list_tipi=='muhasebe'){
                $disabled_='';
            }

//            $odenilecek_meblaq=$odenilecek_meblaq+$prd->maas_tamamlama_tutari;
//            $banka_odenilecek=$banka_odenilecek+$prd->maas_tamamlama_tutari;

            if($prd->dusulen_gun){

                $gun = $prd->r_gercek_is_gunu-$prd->dusulen_gun;
                $banka_gunluk = $this->banka_gunluk_hesaplama($banka_salary,$is_gunu,$gun,$hastalik_amouth,$personel_mezuniyet,$calisilan_gun_sayisi);
                $odenilecek_meblaq = $banka_gunluk+$prd->maas_tamamlama_tutari;
                $dusulen_gune_gore_meblaq=$banka_hakedis-$banka_odenilecek;

            }




            $alacak_nakit_durum='';
            $alacak_banka_durum='';
            $nakit_odeme_emri='';
            $banka_odeme_emri='';
            if($list_tipi=='muhasebe' || $list_tipi=='list'){
                if($prd->banka_hakedis_durumu){
                    $alacak_banka_durum='Banka Hakedişi Verildi';
                }
                if($prd->nakit_hakedis_durumu){
                    $alacak_nakit_durum='Nakit Hakedişi Verildi';
                }

                if($prd->nakit_odeme_emri){
                    $pay_details = $this->db->query("SELECT* FROM new_bordro_pay_set Where bordro_item_id = $prd->id and nakit_durum=1");
                    if($pay_details->num_rows()){
                        $nakit_odeme_emri.= personel_details($pay_details->row()->pay_set_id).' Nakit Ödeme E. Verildi';
                    }
                }
                if($prd->banka_odeme_emri){
                    $pay_details = $this->db->query("SELECT* FROM new_bordro_pay_set Where bordro_item_id = $prd->id and banka_durum=1");
                    if($pay_details->num_rows()){
                        $banka_odeme_emri.= personel_details($pay_details->row()->pay_set_id).' Banka Ödeme E. Verildi';
                    }
                }
            }


            if($prd->status==0 || $prd->status==1 || $prd->status==5 || $list_tipi=='onay' || $list_tipi=='muhasebe'){

                //data-aylik_banka_hakedis='$banka_hakedis'
                if($prd->aylik_banka_hakedis > 0){
                    $banka_hakedis=$prd->aylik_banka_hakedis;
                }
                if($prd->aylik_nakit_hakedis > 0){
                    $nakit_hakedis=$prd->aylik_nakit_hakedis;
                }


                $dusulen_gune_gore_meblaq=0;
                $check = "<input type='checkbox' class='form-control one_checked_salary'
                        data-toplam_maas='$toplam_maas'
                        data-banka_alacak_bakiye='$alacak_banka_bakiye'
                        data-brut_maas='$brut_maas'
                        data-net_maas='$net_maas'
                        data-banka_alacak_bakiye='$alacak_banka_bakiye'
                        data-nakit_alacak_bakiye='$alacak_nakit_bakiye'
                        data-banka_borc_bakiye='$borc_banka_bakiye'
                        data-nakit_borc_bakiye='$borc_nakit_bakiye'
                        data-prim='$prim'
                        data-ceza='$ceza' 
                        data-aylik_banka_hakedis='$banka_hakedis'
                        data-aylik_nakit_hakedis='$nakit_hakedis'
                        data-banka_avans='$total_b_son_bakiye' 
                        data-nakit_avans='$total_n_son_bakiye' 
                        data-bankadan_odenilecek='$banka_odenilecek' 
                        data-nakit_odenilecek='$nakit_odenilecek' 
                        data-maas_tipi='$salary_details->salary_type'
                        data-hesaplanan='$banka_hesaplanan' 
                        data-mezuniyet_tutar='$mezuniyet_hesap' 
                        data-cemi='$cemi' 
                        data-dsmf_isveren='$dsmf_isveren' 
                        data-issizlik_isveren='$issizlik_isveren' 
                        data-icbari_sigorta_isveren='$icbari_sigorta_isveren' 
                        data-dsmf_isci='$dsmf_isci' 
                        data-issizlik_isci='$issizlik_isci' 
                        data-icbari_sigorta_isci='$icbari_sigorta_isci'
                        data-gelir_vergisi='$gelir_vergisi' 
                        data-odenilecek_meblaq='$odenilecek_meblaq' 
                        data-dusulen_gune_gore_meblaq='$dusulen_gune_gore_meblaq' 
                                    value='$prd->id'>";
                $disabled='';
            }


            if($list_tipi=='onay'){
                $disabled='disabled';
            }
            if($list_tipi=='all_bordro'){
                $disabled='disabled';
                $disabled_='disabled';
            }


            $nakit_kesilecek = $prd->nakit_kesilecek;
            $banka_kesilecek = $prd->banka_kesilecek;
            $desc_dusulen='';
            if($dusulen_gune_gore_meblaq){
                $banka_kesilecek = $dusulen_gune_gore_meblaq;
                $disabled_='disabled';
                $desc_dusulen='<span class="badge badge-warning">Nakit Borcuna Karşılık Kesildi</span>';
            }


            //bordro_status($prd->status)->name.' '.$prd->iptal_desc;
            $row = array();

            $bakiye=personel_bakiye_report($prd->pers_id);
            $row[] = $no;
            $row[] = $prd->pers_name;
            $row[] = amountFormat($toplam_maas);
            $row[] = amountFormat($brut_maas);
            $row[] = amountFormat($net_maas);
            $row[] = $is_gunu;
            $row[] = "<input $disabled type='number' style='border: none; background: none;' value='$prd->gercek_is_gunu' class='form-control all_text' data-column='gercek_is_gunu' data-bordro_id ='$prd->id'>";
            $row[] = "<input $disabled type='number' style='border: none; background: none;' value='$prd->r_gercek_is_gunu' class='form-control all_text' data-column='r_gercek_is_gunu' data-bordro_id ='$prd->id'>";
            $row[] = "<input $disabled type='number' style='border: none; background: none;' value='$prd->dusulen_gun' class='form-control all_text' data-column='dusulen_gun' data-bordro_id ='$prd->id'>";
            $row[] = "<input $disabled type='number' style='border: none; background: none;' value='$prd->mezuniyet' class='form-control all_text' data-column='mezuniyet' data-bordro_id ='$prd->id'>";
            $row[] = "<input $disabled type='number' style='border: none; background: none;' value='$prd->maas_tamamlama_tutari' class='form-control all_text' data-column='maas_tamamlama_tutari' data-bordro_id ='$prd->id'>";
            $row[] = amountFormat($prim);
            $row[] = amountFormat($ceza);
            $row[] = amountFormat($banka_hakedis);
            $row[] = amountFormat($nakit_hakedis);

            $row[] = amountFormat($total_b_son_bakiye);
            $row[] = amountFormat($total_n_son_bakiye);
            $row[] = "<input $disabled_ type='number' style='border: none; background: none;' value='$nakit_kesilecek' class='form-control all_text' data-column='nakit_kesilecek' data-bordro_id ='$prd->id'>";
            $row[] = "<input $disabled_ type='number' style='border: none; background: none;' value='$banka_kesilecek' class='form-control all_text' data-column='banka_kesilecek' data-bordro_id ='$prd->id'>$desc_dusulen";

            $row[] = amountFormat($banka_odenilecek);
            $row[] = amountFormat($nakit_odenilecek);
            $row[] = salary_type($salary_details->salary_type)->name;
            $row[]= amountFormat($banka_hesaplanan);
            $row[]= amountFormat($mezuniyet_hesap);
            $row[] = "<input $disabled type='number' style='border: none; background: none;' value='$prd->hastalik' class='form-control all_text' data-column='hastalik' data-bordro_id ='$prd->id'>";
            $row[] =  amountFormat($cemi);
            $row[] =  amountFormat($dsmf_isveren);
            $row[] =  amountFormat($issizlik_isveren);
            $row[] =  amountFormat($icbari_sigorta_isveren);
            $row[] =  amountFormat($dsmf_isci);
            $row[] =  amountFormat($issizlik_isci);
            $row[] =  amountFormat($icbari_sigorta_isci);
            $row[] =  amountFormat($gelir_vergisi);
            $row[] =  amountFormat($odenilecek_meblaq);
//            $row[] =  amountFormat($alacak_nakit_bakiye);
//            $row[] =  amountFormat($borc_nakit_bakiye);
//            $row[] =  amountFormat($alacak_banka_bakiye);
//            $row[] =  amountFormat($borc_banka_bakiye);
            $row[] =  $bakiye;


            $row[] = $check.'<br>'.$alacak_nakit_durum.'<br>'.$alacak_banka_durum.'<br>'.$nakit_odeme_emri.'<br>'.$banka_odeme_emri;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_items(),
            "recordsFiltered" => $this->model->count_filtered_items(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function item_update(){
        $this->db->trans_start();
        $id = $this->input->post('bordro_item_id');
        $details_items = $this->model->details_items_row($id);



        $deger = $this->input->post('deger');
        $column = $this->input->post('column');

        $eski_column_deger = $details_items->$column;

        $data_items=[
            $column=>$deger,
        ];
        $this->db->set($data_items);
        $this->db->where('id', $id);
        if($this->db->update('new_bordro_item', $data_items)){

            $personel_name = personel_details($details_items->pers_id);
            $desc=$personel_name.' Adlı Personelin '.$column. ' Eski Değeri : '.$eski_column_deger.' Güncellenerek '.$deger.' Olumuştur.';
            $this->model->talep_history($details_items->bordro_id,$this->aauth->get_user()->id,$desc,2);

            echo json_encode(array('status' => 200, 'message' =>'güncellendi'));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>'basarısız'));
        }


    }

    public function salary_text_update(){
        $this->db->trans_start();
        $id = $this->input->post('bordro_id');
        $deger = $this->input->post('deger');
        $column = $this->input->post('column');

        $data_items=[
            $column=>$deger,
        ];
        $this->db->set($data_items);
        $this->db->where('bordro_id', $id);
        if($this->db->update('new_bordro_item', $data_items)){
            echo json_encode(array('status' => 200, 'message' =>'güncellendi'));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>'basarısız'));
        }
    }

    public function personel_bakiye($id){

        $nakit_borc=0;
        $nakit_bakiye=0;
        $nakit_alacak=0;
        $banka_alacak=0;
        $banka_borc=0;
        $banka_bakiye=0;
        $result = $this->db->query("SELECT geopos_invoices.id,geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoices.id as invoice_id,
                  IF(geopos_invoices.method!='',geopos_invoices.method, 0) as odeme_tipi,
                IF(geopos_invoice_type.transactions='income',geopos_invoices.total,0) as borc,
                IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,0) as alacak,
                geopos_invoices.total,geopos_invoices.kur_degeri,
                geopos_invoice_type.transactions,geopos_invoices.notes  FROM geopos_invoices
                LEFT JOIN geopos_invoice_type on geopos_invoices.invoice_type_id=geopos_invoice_type.id
                Where geopos_invoices.csd=$id  and geopos_invoice_type.id IN (12,13,14,31,49,53,26,15,70) and geopos_invoices.`invoicedate` > '2020-12-31 23:59:59'
                ORDER BY invoicedate ASC");
        if($result->num_rows()){
            foreach ($result->result() as $ites){
                if($ites->odeme_tipi){
                    if($ites->odeme_tipi==1) // Nakit
                    {
                        $nakit_borc+=$ites->borc;
                        $nakit_alacak+=$ites->alacak;
                    }
                    elseif($ites->odeme_tipi==3){ //banka
                        $banka_borc+=$ites->borc;
                        $banka_alacak+=$ites->alacak;
                    }
                }
                else {

                    if($ites->notes=='Banka Hakediş'){ //banka
                        $banka_borc+=$ites->borc;
                        $banka_alacak+=$ites->alacak;
                    }
                    else {

                        $nakit_borc+=$ites->borc;
                        $nakit_alacak+=$ites->alacak;
                    }
                }
            }


        }

        $nb = floatval($nakit_borc)-floatval($nakit_alacak);
        $bb = floatval($banka_borc)-floatval($banka_alacak);
        // 1 = Borçlu 0 == Alacaklı

        $status_n = $nb > 0 ? 1 : 0;
        $status_b = $bb > 0 ? 1 : 0;

        $n_tutar =round(floatval($nakit_borc)-floatval($nakit_alacak),2);
        $b_tutar =round(floatval($banka_borc)-floatval($banka_alacak),2);
        $data=[
            'nakit_bakiye'=>abs($n_tutar),
            'nakit_bakiye_status'=>$status_n,
            'banka_bakiye'=>abs($b_tutar),
            'banka_bakiye_status'=>$status_b,
        ];

        return $data;
    }

    public function personel_borc_ogren($cid){


        $nakit_borc=0;
        $nakit_bakiye=0;
        $nakit_alacak=0;
        $banka_alacak=0;
        $banka_borc=0;
        $banka_bakiye=0;

        $result = $this->db->query("SELECT geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoice_type.id as type_id,geopos_invoices.id as invoice_id,
                  IF(geopos_invoices.method!='',geopos_invoices.method, 0) as odeme_tipi,
                IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,0) as borc,
                IF(geopos_invoice_type.transactions='income',geopos_invoices.total,0) as alacak,
                geopos_invoices.total,geopos_invoices.kur_degeri,
                geopos_invoice_type.transactions,geopos_invoices.notes  FROM geopos_invoices
                LEFT JOIN geopos_invoice_type on geopos_invoices.invoice_type_id=geopos_invoice_type.id
                Where geopos_invoices.csd=$cid  and geopos_invoice_type.id IN (52,51,34,63) and geopos_invoices.`invoicedate` > '2021-01-30 23:59:59'
                ORDER BY invoicedate ASC");
        if($result->num_rows()) {
            foreach ($result->result() as $ites) {

                if($ites->odeme_tipi){
                    if($ites->odeme_tipi==1) // Nakit
                    {
                        $nakit_borc+=$ites->borc;
                        $nakit_alacak+=$ites->alacak;
                    }
                    elseif($ites->odeme_tipi==3){ //banka
                        $banka_borc+=$ites->borc;
                        $banka_alacak+=$ites->alacak;
                    }
                }
                else {

                    $banka_borc=0;
                    $banka_alacak=0;
                    $nakit_borc=0;
                    $nakit_alacak=0;
                }


            }
        }

        $nb = floatval($nakit_alacak)-floatval($nakit_borc);
        $bb = floatval($banka_alacak)-floatval($nakit_borc);
        // 1 = Borçlu 0 == Alacaklı

        $status_n = $nb > 0 ? 1 : 0;
        $status_b = $bb > 0 ? 1 : 0;

        $n_tutar =round(floatval($nakit_borc)-floatval($nakit_alacak),2);
        $b_tutar =round(floatval($banka_borc)-floatval($banka_alacak),2);
        $data=[
            'nakit_bakiye'=>abs($n_tutar),
            'nakit_bakiye_status'=>$status_n,
            'banka_bakiye'=>abs($b_tutar),
            'banka_bakiye_status'=>$status_b,
        ];

        return $data;
    }

    public function bordro_item_delete(){
        $this->db->trans_start();
        $result = $this->model->bordro_item_delete();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['messages']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['messages']));
        }
    }
    public function bordro_item_create(){
        $this->db->trans_start();
        $result = $this->model->bordro_item_create();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['messages']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['messages']));
        }
    }
    public function create_onay(){
        $this->db->trans_start();
        $result = $this->model->create_onay();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['messages']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['messages']));
        }
    }

    public function create_onay_new(){
        $this->db->trans_start();
        $result = $this->model->create_onay_new();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['messages']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['messages']));
        }
    }

    public function create_hakedis(){
        $this->db->trans_start();
        $result = $this->model->create_hakedis();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['messages']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['messages']));
        }
    }
    public function create_pay_set(){
        $this->db->trans_start();
        $result = $this->model->create_pay_set();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['messages']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['messages']));
        }
    }
    public function create_all_islem(){
        $this->db->trans_start();
        $result = $this->model->create_all_islem();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['messages']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['messages']));
        }
    }
    public function create_pay(){
        $this->db->trans_start();
        $result = $this->model->create_pay();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['messages']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['messages']));
        }
    }

    public function ajax_list_odenis(){
        $list = $this->model->ajax_list_odenis();
        $data = array();
        $no = $this->input->post('start');


        foreach ($list as $prd) {

            $method=0;
            if($prd->nakit_durum==1){
                $method=1;
            }
            elseif($prd->banka_durum==1){
                $method=3;
            }


            $check="<input type='checkbox' class='form-control one_checkbox' 
data-nakit_durum='$prd->nakit_durum'
data-banka_durum='$prd->banka_durum' 
data-bordro_pay_set_id='$prd->id' 
data-bordro_item_id='$prd->item_id' 
data-method='$method' 
>";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->pers_name;
            $row[] = az_month($prd->bordro_ayi)->month.' | '.$prd->bordro_yili;
            $row[] = amountFormat($prd->bankadan_odenilecek);
            $row[] = amountFormat($prd->nakit_odenilecek);
            $row[] = $check;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_odenis(),
            "recordsFiltered" => $this->model->count_filtered_odenis(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function all_bordro_details(){
        $proje_id = $this->input->post('proje_id');
        $m = $this->input->post('ay');
        $y = $this->input->post('yil');
        $bordro_details='';
        $bordro_status='-';
        $total_pers=0;
        if($proje_id){
            $bordro_details_ = $this->db->query("SELECT * FROM new_bordro Where ay=$m and yil=$y and status!=3 and proje_id = $proje_id");
            if($bordro_details_->num_rows()){
                $bordro_details=$bordro_details_->row();
                $bordro_item_details = $this->db->query("SELECT * FROM new_bordro_item Where bordro_id=$bordro_details->id");
                $total_pers=$bordro_item_details->num_rows();
                $bordro_status=bordro_status($bordro_details->status)->name;
                $proje_name=proje_name($bordro_details->proje_id);

                $n=$this->db->query("SELECT  IF(SUM(nakit_odenilecek),SUM(nakit_odenilecek),0) as nakit_odenilecek FROM new_bordro_item where new_bordro_item.bordro_ayi=$m and new_bordro_item.bordro_yili=$y and new_bordro_item.status!=3 and proje_id = $proje_id")->row()->nakit_odenilecek;
                $b=$this->db->query("SELECT IF(SUM(bankadan_odenilecek),SUM(bankadan_odenilecek),0) as bankadan_odenilecek FROM new_bordro_item where new_bordro_item.bordro_ayi=$m and new_bordro_item.bordro_yili=$y and new_bordro_item.status!=3 and proje_id = $proje_id")->row()->bankadan_odenilecek;
                $nakit_odenilcek= $n;
                $bankadan_odenilecek=$b;
                $azn_nakit_odenilcek= amountFormat($n);
                $azn_bankadan_odenilecek=amountFormat($b);


                echo json_encode(array(
                    'status' => 200,
                    'date' => az_month($m)->month.' | '.$y,
                    'bordro_details'=>$bordro_details,
                    'total_pers'=>$total_pers,
                    'bordro_status'=>$bordro_status,
                    'proje_name'=>$proje_name,
                    'proje_personel_count'=> count(proje_to_employe($proje_id)),
                    'bordro_item_count'=> $total_pers,
                    'nakit_odenilcek'=> $nakit_odenilcek,
                    'bankadan_odenilecek'=> $bankadan_odenilecek,
                    'azn_nakit_odenilcek'=> $azn_nakit_odenilcek,
                    'azn_bankadan_odenilecek'=> $azn_bankadan_odenilecek,
                    'fark'=> count(proje_to_employe($proje_id))-$total_pers
                ));
            }
            else {
                echo json_encode(array(
                    'status' => 410,
                    'message' => 'Bordro Bulunamadı',
                ));
            }


        }
        else {
            $bordro_item_details = $this->db->query("SELECT * FROM new_bordro_item Where bordro_yili=$y and bordro_ayi = $m and status!=3");


            $n=$this->db->query("SELECT  IF(SUM(nakit_odenilecek),SUM(nakit_odenilecek),0) as nakit_odenilecek FROM new_bordro_item where new_bordro_item.bordro_ayi=$m and new_bordro_item.bordro_yili=$y and new_bordro_item.status!=3 ")->row()->nakit_odenilecek;
            $b=$this->db->query("SELECT IF(SUM(bankadan_odenilecek),SUM(bankadan_odenilecek),0) as bankadan_odenilecek FROM new_bordro_item where new_bordro_item.bordro_ayi=$m and new_bordro_item.bordro_yili=$y and new_bordro_item.status!=3")->row()->bankadan_odenilecek;
            $nakit_odenilcek= $n;
            $bankadan_odenilecek=$b;
            $azn_nakit_odenilcek= amountFormat($n);
            $azn_bankadan_odenilecek=amountFormat($b);

            echo json_encode(array(
                'status' => 500,
                'nakit_odenilcek'=> $nakit_odenilcek,
                'bankadan_odenilecek'=> $bankadan_odenilecek,
                'azn_nakit_odenilcek'=> $azn_nakit_odenilcek,
                'azn_bankadan_odenilecek'=> $azn_bankadan_odenilecek,
                'count' => $bordro_item_details->num_rows(),
            ));
        }


    }


    public function ajax_list_history(){

        $talep_id=$this->input->post('bordro_id');

        $list = $this->model->ajax_list_history($talep_id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $no++;
            $row = array();
            $row[] = $prd->pers_name;
            $row[] = $prd->desc;
            $row[] = $prd->created_at;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all_talep_history($talep_id),
            "recordsFiltered" => $this->model->count_filtered_talep_history($talep_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function banka_gunluk_hesaplama($banka_salary,$is_gunu,$r_gercek_is_gunu,$hastalik_amouth,$personel_mezuniyet,$calisilan_gun_sayisi){
        $salary_config = $this->config->item('salary');
        $dsmf_isveren=0;
        $mezuniyet_hesap=0;
        $banka_hesaplanan= floatval($banka_salary)/$is_gunu*$r_gercek_is_gunu;
        if($personel_mezuniyet >0){
            $hesap = ( floatval($banka_salary)/floatval($salary_config['mezuniyet_oran']))  * floatval($personel_mezuniyet);
            $mezuniyet_hesap = round( $hesap,2);
        }
        $cemi = floatval($mezuniyet_hesap)+floatval($banka_hesaplanan)+floatval($hastalik_amouth);
        $cemi=round($cemi,2);
        if((floatval($cemi)-floatval($hastalik_amouth)) > $salary_config['salary_200']){
            $dsmf_isveren = $salary_config['200_buyuk_toplam'] + ($cemi-$hastalik_amouth-$salary_config['salary_200'])*$salary_config['200_buyuk_oran'];
        }
        else {
            $dsmf_isveren = ($cemi-$hastalik_amouth)*$salary_config['200_kucuk_oran'];
        }
        $dsmf_isveren=round($dsmf_isveren,2);
        $issizlik_isveren = round(($cemi-$hastalik_amouth) * ($salary_config['issizlik_oran']/100),3);
        $issizlik_isveren=round($issizlik_isveren,2);
        $issizlik_isci =  floatval(($cemi-$hastalik_amouth))*($salary_config['issizlik_oran']/100);
        $issizlik_isci=round($issizlik_isci,2);
        if($cemi<=floatval($salary_config['icbari_tavan'])){
            $icbari_sigorta_isveren = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
            $icbari_sigorta_isci = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
        }
        elseif($cemi>$salary_config['icbari_tavan']) {
            $icbari_sigorta_isveren = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*$salary_config['icbari_tavan_orani']/100;
            $icbari_sigorta_isci = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*$salary_config['icbari_tavan_orani']/100;
        }
        $icbari_sigorta_isci=round($icbari_sigorta_isci,2);
        $icbari_sigorta_isveren=round($icbari_sigorta_isveren,2);
        if(($cemi-$hastalik_amouth) > floatval($salary_config['salary_200'])){
            $dsmf_isci = $salary_config['dsmf_isci_float'] + ($cemi-$hastalik_amouth-$salary_config['salary_200'])*$salary_config['dsmf_isci_oran_max']/100;
        }
        else {
            $dsmf_isci = ($cemi-$hastalik_amouth)*floatval($salary_config['dsmf_isci_oran_min'])/100;

        }
        $dsmf_isci=round($dsmf_isci,2);
        if($cemi > $salary_config['icbari_tavan']){
            $gelir_vergisi = ($cemi-$salary_config['icbari_tavan'])*floatval($salary_config['gelir_vergi_oran'])/100;
        }
        else {
            $gelir_vergisi=0;
        }
        $gelir_vergisi=round($gelir_vergisi,2);
        $kesinti=floatval($dsmf_isci)+floatval($gelir_vergisi)+floatval($icbari_sigorta_isci)+floatval($issizlik_isci);
        $odenilecek_meblaq = floatval($cemi)-floatval($kesinti);
        if($calisilan_gun_sayisi==0 && $mezuniyet_hesap==0){
            $odenilecek_meblaq = 0;
        }

        if($r_gercek_is_gunu==0){
            $odenilecek_meblaq=$odenilecek_meblaq+$hastalik_amouth;
        }
        $banka_hakedis = $odenilecek_meblaq;
//        $odenilecek_meblaq=$odenilecek_meblaq-$prd->banka_kesilecek;
//        $nakit_odenilecek=0;
//        $banka_odenilecek=$odenilecek_meblaq;

        return $banka_hakedis;
    }

    public function ajax_account_bordro_razi(){
        $bordro_id_hid = $this->input->post('bordro_id_hid');



        $emp_id =$this->aauth->get_user()->id;
        $list = $this->db->query('SELECT geopos_accounts.* FROM `geopos_accounts` INNER JOIN geopos_employees ON geopos_accounts.eid = geopos_employees.id WHERE geopos_accounts.eid='.$emp_id.' and  geopos_accounts.status = 1 and geopos_accounts.eid is NOT Null');
        $account=[];
        if($list->num_rows()){
            $account=$list->result();
        }
        else {
            if($this->aauth->get_user()->id = 174){
                $account = $this->db->query('SELECT geopos_accounts.* FROM `geopos_accounts` INNER JOIN geopos_employees ON geopos_accounts.eid = geopos_employees.id WHERE   geopos_accounts.status = 1 and geopos_accounts.eid is NOT Null')->result();

            }
        }

        $toplam_tutar=0;
        $nakit=[];

        $bordro_details = $this->db->query("SELECT * FROM new_bordro_item WHERE bordro_id = $bordro_id_hid and maas_tipi=3 and razi_durum=0");
        if($bordro_details->num_rows()){
            foreach ($bordro_details->result() as $items){
                $nakit[]=['name'=>personel_details($items->pers_id),'tutar'=>amountFormat($items->bankadan_odenilecek),'bordro_item_id'=>$items->id];
                $toplam_tutar+=$items->bankadan_odenilecek;
            }
            echo json_encode(array('status' => 200, 'item' => $account,'nakit'=>$nakit,'toplam_tutar'=>amountFormat($toplam_tutar)));

        }
        else {
            echo json_encode(array('status'=>410,'message'=>'Razı Personel Bulunamadı'));
        }


      }

    public function create_razi_kasa()
    {
        $this->db->trans_start();
        $details = $this->input->post('details');
        $account_id = $this->input->post('account_id');
        $account_name = account_details($account_id)->holder;
        $data=[];
        $productlist=[];
        $productlist_=[];
        $prodindex=0;
        $prodindex_=0;
        $toplam_tutar=0;
        foreach ($details as $items)
        {
            $bordro_item_id =$items['bordro_item_id'];
            $value =$items['value'];
            $salary_details = $this->db->query("SELECT * FROM new_bordro_item WHERE id = $bordro_item_id")->row();

            $data=[
                'total'=>$value,
                'notes'=>'Razı Geri Ödeme',
                'csd'=>$salary_details->pers_id,
                'eid'=>$this->aauth->get_user()->id,
                'invoice_type_id'=>50,
                'invoice_type_desc'=>'Personel Razı',
                'payer'=>personel_details($salary_details->pers_id),
                'acid'=>$account_id,
                'account'=>account_details($account_id)->holder,
                'method'=>1,
                'proje_id'=>35,
                'bolum_id'=>59,
                'cari_pers_type'=>2,
                'maas_ay'=>$salary_details->bordro_ayi,
                'maas_yil'=>$salary_details->bordro_yili,
            ];

            $productlist[$prodindex] = $data;
            $prodindex++;
            $toplam_tutar+=floatval($value);
            $this->db->query("UPDATE new_bordro_item set razi_geri_alinan_tutar = $value,razi_durum=1,razi_geri_alinan_acid=$account_id  WHERE  id = $bordro_item_id");

            // PErsonel Ekstresi İçin
            $dataekstre=[
                'total'=>$salary_details->bankadan_odenilecek,
                'notes'=>'Razı Geri Ödeme',
                'csd'=>$salary_details->pers_id,
                'eid'=>$this->aauth->get_user()->id,
                'invoice_type_id'=>66,
                'invoice_type_desc'=>'Personel Razı Ödemesi',
                'payer'=>personel_details($salary_details->pers_id),
                'acid'=>$account_id,
                'account'=>account_details($account_id)->holder,
                'method'=>1,
                'proje_id'=>35,
                'bolum_id'=>59,
                'cari_pers_type'=>2,
                'maas_ay'=>$salary_details->bordro_ayi,
                'maas_yil'=>$salary_details->bordro_yili,
            ];

            $productlist_[$prodindex_] = $dataekstre;
            $prodindex_++;

        }

        if ($prodindex > 0) {
            $this->db->insert_batch('geopos_invoices', $productlist);
            $this->db->insert_batch('geopos_invoices', $productlist_);
            $this->aauth->applog(floatval($prodindex)." Adet  Nakit Geri Ödenecekler ".$account_name." Kasasına ".amountFormat($toplam_tutar)." Aktarıldı ",$this->aauth->get_user()->username);
            $this->db->trans_complete();

            echo json_encode(array('status' => 200, 'message' =>
                "Başarıyla Giriş Yapıldı"));
        }
        else{
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>
                "İşlem Durduruldu. "));

        }
    }

}