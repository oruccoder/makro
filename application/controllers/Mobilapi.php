<?php
use Firebase\JWT\JWT;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Mobilapi Extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");

        //test Database İşlemi için
        $this->db = $this->load->database('mobile_db', TRUE);
        //test Database İşlemi için

        $this->load->model('malzemetalep_model', 'talep');
        $this->load->model('Carigidertalepnew_model', 'model_cari_gider');
        $this->load->model('Customeravanstalep_model', 'model_cari_avans');
        $this->load->model('Personelgidertalep_model', 'model_personel_gider');
        $this->load->model('Nakliye_model', 'model_nakliye');
        $this->load->model('onay_model', 'onay');
        $this->load->model('mobilapi_model', 'mobilapi');

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST");
        header("Access-Control-Allow-Headers: Content-Type");

    }

    public function jwt_olustur($user_id,$email)
    {
        $key = 'XZSgcL2f2zUKAmLhVwbZGuwrgKKS3K'; // Güvenli bir anahtar belirleyin
        $payload = [
            'iss' => 'muhasebe.makro2000.com.tr', // Tokeni oluşturan
            'aud' => 'mobil.app.makroerp', // Tokeni kullanan
            'iat' => time(),           // Oluşturulma zamanı
            'data' => [
                'user_id' => $user_id,
                'email' => $email
            ]
        ];

        $jwt = generateJWT($payload, $key);
        return $jwt;

    }

    public function jwt_coz($jwt)
    {

        $key = 'XZSgcL2f2zUKAmLhVwbZGuwrgKKS3K';
        try {
            $decoded = decodeJWT($jwt, $key);
            return $decoded;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function allcount_get()
    {
        $user_id  = $_GET['user_id'];

        $result = $this->mobilapi->allcount($user_id);
        echo json_encode(array(
            'result' => $result,
        ));
    }
     public function duyurular_get()
    {
        $result = $this->db->query("SELECT * FROM duyuru Where mobil_in=1 ORDER BY id DESC LIMIT 4")->result();
        echo json_encode(array(
            'result' => $result,
        ));
    }

    public function create_mobil_ticket_get()
    {

        $user_id  = $_GET['user_id'];
        $ticketTitle  = $_GET['ticketTitle'];
        $ticketDescription  = $_GET['ticketDescription'];
        $result = $this->mobilapi->create_mobil_ticket($user_id,$ticketTitle,$ticketDescription);
        echo json_encode($result);
    }
    public function cari_gider_list_get()
    {

        $user_id  = $_GET['user_id'];
        $result = $this->mobilapi->cari_gider_onay_list($user_id);
        echo json_encode(array(
            'result' => $result,
        ));
    }
    public function nakliye_onay_list_get()
    {

        $user_id  = $_GET['user_id'];
        $type  = $_GET['type'];
        $status  = $_GET['status'];
        $result = $this->mobilapi->nakliye_onay_list($user_id,$type,$status);
        echo json_encode(array(
            'result' => $result,
        ));
    }
    public function cari_form_list_get()
    {

        $user_id  = $_GET['user_id'];
        $result = $this->mobilapi->cari_form_list($user_id);
        echo json_encode(array(
            'result' => $result,
        ));
    }

    public function cari_protokol_list_get()
    {

        $user_id  = $_GET['user_id'];
        $result = $this->mobilapi->cari_protokol_onay_list($user_id);
        echo json_encode(array(
            'result' => $result,
        ));
    }
    public function cari_avans_list_get()
    {

        $user_id  = $_GET['user_id'];
        $result = $this->mobilapi->cari_avans_onay_list($user_id);
        echo json_encode(array(
            'result' => $result,
        ));
    }



    public function personel_permit_view_get()
    {
        $user_id  = $_GET['user_id'];
        $confirm_id  = $_GET['confirm_id'];
        $result = $this->mobilapi->personel_permit_view($user_id,$confirm_id);
        echo json_encode($result);
    }

    public function nakliye_talep_view_get()
    {
        $user_id  = $_GET['user_id'];
        $talep_id  = $_GET['talep_id'];
        $tip  = $_GET['tip'];
        $result = $this->mobilapi->nakliye_talep_view($user_id,$tip,$talep_id);
        echo json_encode($result);
    }
    public function personel_task_list_get()
    {

        $user_id  = $_GET['user_id'];
        $result = $this->mobilapi->personel_task_list($user_id);
        echo json_encode(array(
            'result' => $result,
        ));
    }
    public function personel_permit_list_get()
    {

        $user_id  = $_GET['user_id'];
        $result = $this->mobilapi->personel_permit_list($user_id);
        echo json_encode(array(
            'result' => $result,
        ));
    }

    public function personel_gider_list_get()
    {

        $user_id  = $_GET['user_id'];
        $result = $this->mobilapi->personel_gider_list($user_id);
        echo json_encode(array(
            'result' => $result,
        ));
    }

    public function account_virman_list_get()
    {
        $user_id  = $_GET['user_id'];
        $result = $this->mobilapi->account_virman_list($user_id);
        echo json_encode(array(
            'result' => $result,
        ));
    }
    public function malzeme_talep_list_get()
    {
        $user_id  = $_GET['user_id'];
        $tip  = $_GET['tip'];
        $result = $this->mobilapi->malzeme_talep_list($user_id,$tip);
        echo json_encode(array(
            'result' => $result,
        ));
    }
    public function hizmet_talep_list_get()
    {
        $user_id  = $_GET['user_id'];
        $tip  = $_GET['tip'];
        $result = $this->mobilapi->hizmet_talep_list($user_id,$tip);
        echo json_encode(array(
            'result' => $result,
        ));
    }

    public function virman_view_get()
    {
        $user_id  = $_GET['user_id'];
        $talep_id  = $_GET['talep_id'];
        $result = $this->mobilapi->virman_view($user_id,$talep_id);
        echo json_encode($result);
    }

    public function malzeme_talep_view_get()
    {
        $user_id  = $_GET['user_id'];
        $talep_id  = $_GET['talep_id'];
        $tip  = $_GET['tip'];
        $result = $this->mobilapi->malzeme_talep_view($user_id,$talep_id,$tip);
        echo json_encode($result);
    }
    public function hizmet_talep_view_get()
    {
        $user_id  = $_GET['user_id'];
        $talep_id  = $_GET['talep_id'];
        $tip  = $_GET['tip'];
        $result = $this->mobilapi->hizmet_talep_view($user_id,$talep_id,$tip);
        echo json_encode($result);
    }
    public function cari_gider_view_get()
    {
        $user_id  = $_GET['user_id'];
        $talep_id  = $_GET['talep_id'];
        $result = $this->mobilapi->cari_gider_view($user_id,$talep_id);
        echo json_encode($result);
    }
    public function personel_task_view_get()
    {
        $user_id  = $_GET['user_id'];
        $talep_id  = $_GET['talep_id'];
        $result = $this->mobilapi->personel_task_view($user_id,$talep_id);
        echo json_encode($result);
    }
    public function cari_avans_view_get()
    {
        $user_id  = $_GET['user_id'];
        $talep_id  = $_GET['talep_id'];
        $result = $this->mobilapi->cari_avans_view($user_id,$talep_id);
        echo json_encode($result);
    }

    public function cari_protokol_view_get()
    {
        $user_id  = $_GET['user_id'];
        $talep_id  = $_GET['talep_id'];
        $result = $this->mobilapi->cari_protokol_view($user_id,$talep_id);
        echo json_encode($result);
    }

    public function cari_forma_view_get()
    {
        $user_id  = $_GET['user_id'];
        $talep_id  = $_GET['talep_id'];
        $result = $this->mobilapi->cari_forma_view($user_id,$talep_id);
        echo json_encode($result);
    }

    public function create_permit_get()
    {
        $user_id  = $_GET['user_id'];
        $permit_type  = $_GET['permit_type'];
        $startDateTime  = $_GET['startDateTime'];
        $endDateTime  = $_GET['endDateTime'];
        $description  = $_GET['description'];
        $result = $this->mobilapi->create_permit($user_id,$permit_type,$startDateTime,$endDateTime,$description);
        echo json_encode($result);
    }

    public function task_status_update_get()
    {
        $user_id  = $_GET['user_id'];
        $DurumID  = $_GET['DurumID'];
        $description  = $_GET['description'];
        $talep_id  = $_GET['talep_id'];
        $result = $this->mobilapi->task_status_update($user_id,$DurumID,$talep_id,$description);
        echo json_encode($result);
    }

    public function create_nakliye_get()
    {
        $user_id  = $_GET['user_id'];
        $talep_eden_personel  = $_GET['talep_eden_personel'];
        $proje_id  = $_GET['proje_id'];
        $description  = $_GET['description'];
        $location  = $_GET['location'];
        $CariID  = $_GET['CariID'];
        $itemdesc  = $_GET['itemdesc'];
        $result = $this->mobilapi->create_nakliye($user_id,$talep_eden_personel,$proje_id,$location,$description,$CariID,$itemdesc);
        echo json_encode($result);

    }

    public function create_avans_get()
    {
        $user_id  = $_GET['user_id'];
        $amount  = $_GET['amount'];
        $paymentMethod  = $_GET['paymentMethod'];
        $description  = $_GET['description'];
        $result = $this->mobilapi->create_avans($user_id,$amount,$paymentMethod,$description);
        echo json_encode($result);

    }

    public function onay_islemleri_get()
    {
        $user_id  = $_GET['user_id'];
        $islem_tipi  = $_GET['islem_tipi'];
        $aciklama  = $_GET['aciklama'];
        $status  = $_GET['status'];
        $deviceModel  = $_GET['deviceModel'];
        $talep_id  = $_GET['talep_id'];

        if($islem_tipi=='protokol_onayi'){
            $result = $this->mobilapi->cari_protokol_islem_olustur($user_id,$talep_id,$status,$deviceModel,$aciklama);
            echo json_encode($result);
        }
        elseif($islem_tipi=='cari_gider_talep_onayi'){
            $type  = $_GET['type'];
            $sort  = $_GET['sort'];
            $result = $this->mobilapi->cari_gider_islem_olustur($user_id,$talep_id,$status,$type,$sort,$deviceModel,$aciklama);
            echo json_encode($result);
        }
        elseif($islem_tipi=='cari_avans_talep_onayi'){
            $type  = $_GET['type'];
            $sort  = $_GET['sort'];
            $result = $this->mobilapi->cari_avans_islem_olustur($user_id,$talep_id,$status,$type,$sort,$deviceModel,$aciklama);
            echo json_encode($result);
        }
        elseif($islem_tipi=='forma2_onayi'){
            $type  = $_GET['type'];
            $sort  = $_GET['sort'];
            $result = $this->mobilapi->cari_forma_islem_olustur($user_id,$talep_id,$status,$type,$sort,$deviceModel,$aciklama);
            echo json_encode($result);
        }
        elseif($islem_tipi=='permit_confirm'){
            $selectedPermitType  = $_GET['selectedPermitType'];
            $result = $this->mobilapi->permit_confirm($user_id,$talep_id,$status,$deviceModel,$aciklama,$selectedPermitType);
            echo json_encode($result);
        }
        elseif($islem_tipi=='personel_gider_talep_onayi'){
            $type  = $_GET['type'];
            $sort  = $_GET['sort'];
            $result = $this->mobilapi->personel_gider_talep_onayi($user_id,$talep_id,$status,$type,$sort,$deviceModel,$aciklama);
            echo json_encode($result);
        }

        elseif($islem_tipi=='virman_onay'){
            $virman_onay_id  = $_GET['virman_onay_id'];
            $onaylanan_tutar  = $_GET['onaylanan_tutar'];
            $result = $this->mobilapi->virman_onay($user_id,$talep_id,$status,$virman_onay_id,$onaylanan_tutar,$deviceModel,$aciklama);
            echo json_encode($result);
        }
        elseif($islem_tipi=='malzeme_talep_onayi'){
            $satinalma_pers_id  = $_GET['personelID'];
            $type  = $_GET['type'];
            $sort  = $_GET['sort'];
            $result = $this->mobilapi->malzeme_talep_onayi($user_id,$talep_id,$status,$satinalma_pers_id,$deviceModel,$aciklama,$type,$sort);
            echo json_encode($result);
        }

        elseif($islem_tipi=='hizmet_talep_onayi'){
            $satinalma_pers_id  = $_GET['personelID'];
            $type  = $_GET['type'];
            $sort  = $_GET['sort'];
            $result = $this->mobilapi->hizmet_talep_onayi($user_id,$talep_id,$status,$satinalma_pers_id,$deviceModel,$aciklama,$type,$sort);
            echo json_encode($result);
        }

        elseif($islem_tipi=='nakliye_talep_onayi'){
            $type  = $_GET['type'];
            $sort  = $_GET['sort'];
            $result = $this->mobilapi->nakliye_talep_onayi($user_id,$talep_id,$status,$deviceModel,$aciklama,$type,$sort);
            echo json_encode($result);
        }

    }

    public function personel_gider_view_get()
    {
        $user_id  = $_GET['user_id'];
        $talep_id  = $_GET['talep_id'];
        $result = $this->mobilapi->personel_gider_view($user_id,$talep_id);
        echo json_encode($result);
    }




    public function updateApprovalCount_get() {

        $userId  = $_GET['user_id'];

        $result = $this->mobilapi->allcount($userId);
        // Talebin durumunu güncelle
        $approvalCount = $result['count'];

        // Firebase URL ve veritabanı yapılandırması
        $firebaseUrl = 'https://mobil-erpv1-default-rtdb.firebaseio.com/approvals/' . $userId . '/pending_count.json';

        // Firebase'e veri gönderme
        $ch = curl_init($firebaseUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($approvalCount));
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }



    public function login_get()
    {
        $email=$_GET['email'];
        $password=$_GET['password'];
        $result = $this->mobilapi->user_details($email,$password);
        echo json_encode(array(
            'result' => $result
        ));
    }


    public function cari_avans_get_api()
    {

    }


    public function bekleyen_malzeme_ajax_list_get_api(){

        $start = $_GET['start'];
        $length = $_GET['length'];
        $tip = $_GET['tip'];
        $user_id = $_GET['user_id'];

        $list = $this->mobilapi->get_datatables_query_details_talep_list($start,$length,$tip,$user_id);


        $data = array();
        $no = $start;
        $href = "malzemetalep";
        $talep_type_hizmet = [105,106,107,108,109,110,111,112,113];

        if(in_array($tip,$talep_type_hizmet)){
            $href="hizmet";
        }

        foreach ($list as $prd) {
            $view = "<a class='btn btn-md btn-primary view' href='/$href/view/$prd->id' type='button'>Görüntüle</a>&nbsp;";
            if($tip==105){
                $view = "<a class='btn btn-md btn-primary view' href='/$href/view/$prd->id' type='button'>Görüntüle</a>&nbsp;";
            }
            $no++;
            $row = array();
            $row['code'] = $prd->code;
            $row['date'] = $prd->created_at;
            $row['proje'] = $prd->proje_name;
            $row['buttons'] =$view;
            $data[] = $row;
        }

        //output to json format
        echo json_encode(array(
            'data' => $data,
            'recordsFiltered' => $this->mobilapi->count_filtered_talep($start,$length,$tip,$user_id),
            'recordsTotal' => $this->mobilapi->count_all_talep($start,$length,$tip,$user_id),
        ));
    }
    public function bekleyen_malzeme_count($aauth_id){

        $loc = 5;
        if($aauth_id){
            $where_talep_form='';

            $where_talep_form.='and talep_form.loc='.$loc;
            $count = $this->db->query("SELECT * FROM `talep_onay_new` 
INNER JOIN talep_form On talep_onay_new.talep_id=talep_form.id
WHERE talep_onay_new.type = 1 AND  talep_form.status=1 and talep_form.talep_type=1 and talep_onay_new.user_id = $aauth_id AND `staff` = 1 $where_talep_form
")->num_rows();
            echo json_encode(array('status' => 1, 'count' =>$count));

        }
        else {

            echo json_encode(array('status' => 0, 'count' =>0));
        }


    }
}