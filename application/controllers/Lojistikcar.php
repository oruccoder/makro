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

class Lojistikcar Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('communication_model');
        $this->load->model('lojistikcar_model', 'lojistik');
        $this->load->model('employee_model', 'employee');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }
    public function ajax_list(){

        $lojistik_id = $this->input->post('id');
        $list = $this->lojistik->get_datatables_details($lojistik_id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $button='';
//            $hrk = "<a class='btn btn-warning' href='/lojistik/edit/$prd->id'><i class='fa fa-pen'></i></a>&nbsp;";
//            $view = "<a class='btn btn-info' href='/lojistik/view/$prd->id'><i class='fa fa-eye'></i></a>&nbsp;";
            $hrk='Araç Bilgilerini Giriniz';

            $plaka='';
            $sofor='';
            $tel='';
            $lojistik_to_car_id='';
            $arac_to_car = $this->db->query("SELECT * FROM lojistik_to_car Where lojistik_id = $prd->lojistik_id and sf_arac_id=$prd->arac_id");

            if($arac_to_car->num_rows()){
                $plaka= $arac_to_car->row()->plaka;
                $sofor= $arac_to_car->row()->sofor;
                $tel= $arac_to_car->row()->tel;
                $lojistik_to_car_id= $arac_to_car->row()->id;
            }
            if($lojistik_to_car_id){
                $hrk = "<button class='btn btn-success arac_hareketleri' lojistik_car_id='$lojistik_to_car_id' lojistik_id='$prd->lojistik_id' arac_id='$prd->arac_id' type='button'><i class='fa fa-truck'></i></button>&nbsp;<button class='btn btn-success new_history' lojistik_car_id='$lojistik_to_car_id' lojistik_id='$prd->lojistik_id' arac_id='$prd->arac_id' type='button'><i class='fa fa-plus'></i></button>";

            }

            $islem = "<button class='btn btn-warning arac_bilgileri' lojistik_car_id='$lojistik_to_car_id'  lojistik_id='$prd->lojistik_id' arac_id='$prd->arac_id' type='button'><i class='fa fa-pen'></i></button>&nbsp;";



            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->name;
            $row[] = $plaka;
            $row[] = $sofor;
            $row[] = $tel;
            $row[] =$hrk;
            $row[] =$islem;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->lojistik->count_all($lojistik_id),
            "recordsFiltered" => $this->lojistik->count_filtered($lojistik_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function create_car(){
        $result =0;
        $lojistik_id = $this->input->post('lojistik_id');
        $arac_id = $this->input->post('arac_id');
        $plaka = $this->input->post('plaka');
        $sofor = $this->input->post('sofor');
        $lojistik_car_id = $this->input->post('lojistik_car_id');
        $tel = $this->input->post('tel');
        $this->db->trans_start();
        $data = array(
            'lojistik_id' => $lojistik_id,
            'sf_arac_id' => $arac_id,
            'plaka' => $plaka,
            'sofor' => $sofor,
            'tel' => $tel,
            'user_id' => $this->aauth->get_user()->id,
        );
        if($lojistik_car_id==0){
            $result = $this->db->insert('lojistik_to_car', $data);
        }
        else {
            $this->db->set($data);
            $this->db->where('id', $lojistik_car_id);
            $result = $this->db->update('lojistik_to_car');
        }
        if($result){
            $this->aauth->applog("Lojistik Araç Bilgileri Girildi : " . $arac_id.' Lojistik ID : '.$lojistik_id, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Bilgiler Eklendi"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }
    public function cart_info(){
        $car_details=[];
        $lojistik_car_id = $this->input->post('lojistik_car_id');
        if(isset($lojistik_car_id)){
            $car_details = $this->lojistik->car_info($lojistik_car_id);
        }
        echo json_encode((array('status'=>'Status','item'=>$car_details)));
    }

    public function history_get_info(){
        $lojistik_id = $this->input->post('lojistik_id');
        $location_details = $this->lojistik->satinalma_location($lojistik_id);
        $arac_history_status = $this->lojistik->arac_history_status();
        $employe_list =  $this->employee->list_employee_active();
        echo json_encode((array('status'=>'Status','items'=>$location_details,'history'=>$arac_history_status,'employe_list'=>$employe_list)));
    }
    public function arac_history_status(){
        $arac_history_status = $this->lojistik->arac_history_status();
        echo json_encode((array('status'=>'Status','items'=>$arac_history_status)));
    }

    public function create_history(){
        $lojistik_id = $this->input->post('lojistik_id');
        $arac_id = $this->input->post('arac_id');
        $lojistik_car_id = $this->input->post('lojistik_car_id');
        $status = $this->input->post('status');
        $sf_lokasyon_id = $this->input->post('sf_lokasyon_id');
        $desc = $this->input->post('desc');
        $sms_bildir = $this->input->post('sms_bildir');
        $personel_id = $this->input->post('personel_id');

        $this->db->trans_start();
        $data = array(
            'lojistik_id' => $lojistik_id,
            'lojistik_to_car_id' => $lojistik_car_id,
            'arac_id' => $arac_id,
            'sf_lokasyon_id' => $sf_lokasyon_id,
            'status' => $status,
            'desc' => $desc,
            'user_id' => $this->aauth->get_user()->id,
        );
        if($this->db->insert('lojistik_to_car_history', $data)){
            $last_id = $this->db->insert_id();

            if($sms_bildir){
                $this->personel_bildirimi($last_id,$personel_id,$status);
            }

            $data_items=['status'=>$status];
            $this->db->set($data_items);
            $this->db->where('id', $lojistik_car_id);
            $this->db->update('lojistik_to_car');

            $this->aauth->applog("Lojistik Araç Hareketi Eklendi : " . $last_id.' Lojistik ID : '.$lojistik_id, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Bilgiler Eklendi"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }


    public  function getSmallLink($longurl){

        if($longurl){
            $sayi=rand(1,99999999);
            $name='makro2000'.$sayi;
            $url = urlencode("$longurl");
            $json = file_get_contents("https://cutt.ly/api/api.php?key=e67f08835022a9c59b736d5c9e109ba5a8c4a&short=$url&name=$name");
            $data = json_decode ($json, true);
            return $data['url']['shortLink'];
        }
        else {
            return "";
        }
    }

    public function personel_bildirimi($lojistik_to_car_history_id,$personel_id,$status){
        $lojistik_to_car_id = $this->db->query("SELECT * FROM `lojistik_to_car_history` Where id = $lojistik_to_car_history_id")->row()->lojistik_to_car_id;
        $lojistik_id = $this->db->query("SELECT * FROM `lojistik_to_car_history` Where id = $lojistik_to_car_history_id")->row()->lojistik_id;
        $arac_id = $this->db->query("SELECT * FROM `lojistik_to_car_history` Where id = $lojistik_to_car_history_id")->row()->arac_id;
        $araclar = $this->db->query("SELECT * FROM `araclar` Where id = $arac_id")->row();
        $car_details = $this->db->query("SELECT * FROM `lojistik_to_car` where id = $lojistik_to_car_id ")->row();
        $data=[
            'aaut_id'=>$this->aauth->get_user()->id,
            'user_id'=>$personel_id,
            'lojistik_to_car_history_id'=>$lojistik_to_car_id,
            'status'=>$status,
            'sort '=>1,
        ];
        $this->db->insert('lojistik_arac_personel_history', $data);

        $last_id = $this->db->insert_id();


        $data=[
            'lojistik_arac_personel_history_id' =>$last_id,
            'status' =>$status,
            'user_id' =>$this->aauth->get_user()->id,
            'desc' =>'',
        ];
        $this->db->insert('lojistik_arac_personel_history_item', $data);


        $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
        $firma_kodu=$dbnames['firma_kodu'];
        $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&personelen_history_id=$last_id&lojistik_to_car_history_id=$lojistik_to_car_history_id&pers_id=$personel_id&type=arac_history_create";
        $short_url = $this->getSmallLink($href);

        $meesage = 'Sayın Yetkili '.$car_details->plaka.' Nömreli '.$araclar->name.' Lojistik Yetkilisi Tarafından Size Yönlendirilmistir.Arac Durumu Belirtmek İcin Tiklayiniz.'.$short_url;

        $details = personel_detailsa($personel_id);
        $name = $details['name'];
        $phone = $details['phone'];
        $tel=str_replace(" ","",$phone);

        $domain="https://sms.atatexnologiya.az/bulksms/api";
        $operation='submit';
        $login='makro2000';
        $password="makro!sms";
        $title='MAKRO2000';
        $bulkmessage=$meesage;
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

    public function ajax_list_history(){

        $lojistik_car_id = $this->input->post('lojistik_car_id');
        $list = $this->lojistik->get_datatables_history($lojistik_car_id);
        $data = array();
        $this->db->trans_start();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<input type='checkbox' class='form-control one_select' id='$prd->id' style='width: 30px;'>";
            $row[] = $prd->created_at;
            $row[] = $prd->desc;
            $row[] = $prd->location;
            $row[] = $prd->pers_name;
            $row[] = $prd->name;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->lojistik->count_all_history($lojistik_car_id),
            "recordsFiltered" => $this->lojistik->count_filtered_history($lojistik_car_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_history_info(){

        $lojistik_car_id = $this->input->post('lojistik_car_id');
        $list = $this->lojistik->get_datatables_history($lojistik_car_id);
        $data = array();
        $this->db->trans_start();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->created_at;
            $row[] = $prd->desc;
            $row[] = $prd->location;
            $row[] = $prd->pers_name;
            $row[] = $prd->name;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->lojistik->count_all_history($lojistik_car_id),
            "recordsFiltered" => $this->lojistik->count_filtered_history($lojistik_car_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function all_delete_hisyory(){
        $id_array = $this->input->post('id_array');
        $i=0;
        foreach($id_array as $id){
            $this->db->delete('lojistik_to_car_history', array('id' => $id));
            $i++;
        }

        if($i>0){
            $this->aauth->applog("Lojistik Hareketi Silindi : " . $id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde ".$i." Adet Veri Girişi İptal Edildi"));


        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }

    }

    public function create_note(){
        $lojistik_id = $this->input->post('lojistik_id');
        $desc = $this->input->post('desc');
        $users_id = [];
        $type=1;
        $lojistik_details = $this->db->query("SELECT * FROM lojistik_satinalma_talep Where id = $lojistik_id")->row();
        $satinalma_details = $this->db->query("SELECT geopos_talep.* FROM lojistik_sf  INNER JOIN geopos_talep ON lojistik_sf.sf_id = geopos_talep.id Where lojistik_sf.lojistik_id = $lojistik_id")->result();
        $users_id['lojistik_muduru'][]=$lojistik_details->lojistik_muduru;
        $users_id['proje_muduru'][]=$lojistik_details->proje_muduru;
        $users_id['genel_mudur'][]=$lojistik_details->genel_mudur;
        $users_id['satinalma_sorumlusu']=[];
        $users_id['finans']=[];
        foreach ($satinalma_details as $items){
            $users_id['satinalma_sorumlusu'][]=$items->kullanici_id;
            $users_id['finans'][]=$items->finans_departman_pers_id;
        }



        $lm_=false;
        $this->db->trans_start();

        foreach ($users_id['lojistik_muduru'] as $lm)
        {
            if($lm==$this->aauth->get_user()->id)
            {
                $type = 1;
                $lm_=true;
            }
        }
        foreach ($users_id['proje_muduru'] as $lm)
        {
            if($lm==$this->aauth->get_user()->id)
            {
                $type = 1;
            }
        }
        foreach ($users_id['genel_mudur'] as $lm)
        {
            if($lm==$this->aauth->get_user()->id)
            {
                $type = 1;
            }
        }

        if( $users_id['satinalma_sorumlusu']){
            foreach ($users_id['satinalma_sorumlusu'] as $lm)
            {
                if($lm==$this->aauth->get_user()->id)
                {
                    $type = 1;
                }
            }
        }
        if( $users_id['finans']){
            foreach ($users_id['finans'] as $lm)
            {
                if($lm==$this->aauth->get_user()->id)
                {
                    $type = 1;
                }
            }
        }

        $data = array(
            'lojistik_id' => $lojistik_id,
            'notes' => $desc,
            'user_id' => $this->aauth->get_user()->id,
            'type' => $type,
        );
        if($type!=0){
            if($this->db->insert('lojistik_notes', $data)){
                $last_id = $this->db->insert_id();

                if($lm_){

                    $subject = 'Lojitik Satın Alma Talebi Notu Eklendi!';

                    $pm = $lojistik_details->proje_muduru;
                    $gm = $lojistik_details->genel_mudur;

                    $message = 'Sayın Yetkili ' . $lojistik_details->talep_no . ' Numaralı Lojistik Satınalma Talep Formuna Lojistik Müdürü Not Ekledi.';
                    $message.= '</br> Note : '.$desc;
                    $message .= "<br><br><br><br>";

                    $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                    $proje_sorumlusu_email = personel_detailsa($pm)['email'];
                    $genel_mudur_email = personel_detailsa($gm)['email'];



                    $recipients = array($proje_sorumlusu_email,$genel_mudur_email);


                    $this->onay_mailleri($subject, $message, $recipients, 'gider_talep_onay_maili',$lojistik_details->id);
                }

                // eğer notu oluşturan lojistik müdürü ise diğerlerime mail at


                $pers_name  = personel_details($this->aauth->get_user()->id);
                $date = $this->db->query("select * from lojistik_notes where id = $last_id")->row()->created_at;
                $this->aauth->applog("Lojistik Notu : " . $last_id.' Lojistik ID : '.$lojistik_id, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Bilgiler Eklendi",'type'=>$type,'desc'=>$desc,'date'=>$date,'user_name'=>$pers_name));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
            }
        }
        else{
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Bu Lojistiğe Yorum Yapabilmeniz İçin Lojistik Müdürü,Satınalma Sorumlusu, Genel Müdürü, Finans Müdürü veya Proje Müdürü Olmanız Gerekmektedi."));
        }




    }

    public function onay_mailleri($subject, $message, $recipients, $tip)
    {

        $attachmenttrue = false;
        $attachment = '';


        $this->communication_model->onay_mail($recipients, $subject, $message, $attachmenttrue, $attachment, $tip);
        return 1;

    }
}
