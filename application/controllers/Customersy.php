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

class Customersy extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customers_model', 'customers');
        $this->load->model('customeravanstalep_model', 'customeravans');
        $this->load->library("Aauth");
        $this->load->library("Custom");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(3)->read) {

            exit('<h3>Bu bölüme giriş izniniz yoktur!</h3>');

        }
    }

    public function cari_projeleri()
    {
        if (!$this->aauth->premission(3)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }


        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Cari Projeleri';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/cari_projeleri');
        $this->load->view('fixed/footer');
    }

    public function cari_proje_ajax_list(){
        $list = $this->customers->ajax_list_proje();
        $data = [];
        $no = $this->input->post('start');
        foreach ($list as $item) {
            $edit = "<button class='btn btn-warning btn-sm edit' id='$item->cp_id' title='Düzenle'><i class='fas fa-pencil-alt'></i></button>&nbsp;";
            $delete = "<button class='btn btn-danger btn-sm delete' id='$item->cp_id' title='Sil'><i class='far fa-trash-alt'></i></button>&nbsp;";
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $item->proje_name;
            $row[] = $item->company;
            $row[] = $edit . $delete;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->count_all_proje(),
            "recordsFiltered" => $this->customers->count_filtered_proje(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    public function index()
    {
        if (!$this->aauth->premission(3)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }


        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Müşteriler';
        $data['active_status']=1;

        $this->load->view('fixed/header', $head);
        $this->load->view('customers/clist',$data);
        $this->load->view('fixed/footer');
    }

    public function passive_list()
    {
        if (!$this->aauth->premission(3)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Müşteriler';
        $this->load->view('fixed/header', $head);
        $data['active_status']=0;
        $this->load->view('customers/clist',$data);
        $this->load->view('fixed/footer');
    }

    public function get_yoklama_details()
    {
        $cari_id = $this->input->post('cari_id');
        $kontrol = $this->db->query("SELECT * FROM cari_yoklama Where cari_id= $cari_id")->result();
        $html = '<table class="table table-bordered">';
        $html.= '<tr>
            <td>No</td>
            <td>İşlemi Yapan Personel</td>
            <td>Akt Durumu</td>
            <td>Yoklama Durumu</td>
            <td>Açıklama</td>
            <td>Tarih</td>
            <td>Sil</td>
            </tr><tbody>';
        $i=1;
        foreach ($kontrol as $items){

            $personel_name = personel_detailsa($items->pers_id)['name'];
            $akt_durumu ='-';
            $yoklama_durumu ='-';
            if($items->akt_status){
                $akt_durumu='Akt Yapıldı';
            }

            if($items->yoklama_status){
                $yoklama_durumu='Yoklama Yapıldı';
            }

            $desc = $items->desc;
            $date = $items->created_at;

            $button="<button type='button' yk_id='".$items->id."' class='delete_yoklama btn btn-danger btn-sm'><i class='fa fa-ban'></i></button>";

            $html.="<tr>
                <td>".$i."</td>
                <td>".$personel_name."</td>
                <td>".$akt_durumu."</td>
                <td>".$yoklama_durumu."</td>
                <td>".$desc."</td>
                <td>".$date."</td>
                <td>".$button."</td>
                </tr>";
            $i++;

        }
        $html.="</tbody></table>";
        echo json_encode(array('status' => 200, 'html' =>$html));

    }
    public function load_list()
    {
        $no = $this->input->post('start');

        $list = $this->customers->get_datatables();





        $data = array();
        if ($this->input->post('due')) {
            foreach ($list as $customers) {
                $cari_yoklama_details = cari_yoklama_detalis($customers->id);
                $style='';
                if($cari_yoklama_details['inceleme_status']){
                    $style='background: #dd4646;color: white;';
                }

                $views='<a href="/customers/view?id=' . $customers->id . '" class="dropdown-item">' . $this->lang->line('View') . '</a>';
                $edit='<a href="/customers/edit?id=' . $customers->id . '" class="dropdown-item">' . $this->lang->line('Edit') . '</a>';
                $buttons_='<div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                İşlemler
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                '.$views.'
                '.$edit.'
              </div>
            </div>';


                $no++;
                $row = array();
                //$row[] = $no . ' <input type="checkbox" name="cust[]" class="checkbox" value="' . $customers->id . '"> ';
                $row[] = $no;
                $row[]='<span class="avatar-sm align-baseline"><img class="" src="' . base_url() . 'userfiles/customers/thumbnail/' . $customers->picture . '" ></span>';
                $row[] = '<a class="btn btn-outline-secondary btn-sm" href="/customers/view?id=' . $customers->id . '">' . $customers->company . '</a>';
                $row[] = amountExchange($customers->total - $customers->pamnt, 0, $this->aauth->get_user()->loc);
                $row[] = $customers->address . ',' . $customers->city . ',' . $customers->country;
                $row[] = $customers->email;
                $row[] = $customers->phone;
                $row[] = $customers->emp_name;
                $row[] =$buttons_ ;
                $row[] =$style ;
                $data[] = $row;
            }
        } else {
            foreach ($list as $customers) {
                $cari_yoklama_details = cari_yoklama_detalis($customers->id);
                $style='';
                $durums='İnceleme Yapılmadı';
                if($cari_yoklama_details['inceleme_status']){
                    $style='background: #4b865d;color: white;';
                    $durums="<div style='display: flex;'><img class='cari_tables' onmouseover='cari_tables($customers->id)' src='/userfiles/cari-yoklandi.jpg' style='    width: 70px;'>";
                }
                else {
                    $style='';
                }

                if($cari_yoklama_details['akt_status']){
                    if(!$cari_yoklama_details['inceleme_status']){
                        $durums="<div style='display: flex;'><img  class='cari_tables' onmouseover='cari_tables($customers->id)' src='/userfiles/akt.jpg' style='    width: 70px;'></div>";
                    }
                    else {
                        $durums.="<img  src='/userfiles/akt.jpg' onmouseover='cari_tables($customers->id)' style='width: 70px;'></div>";
                    }

                }

                $passive='<button class="passive dropdown-item" status="1" cari_id="' . $customers->id . '">AKTİF YAP</button>';

                if($customers->active){
                    $passive='<button class="passive dropdown-item" status="0" cari_id="' . $customers->id . '">PASİF YAP</button>';
                }

                $views='<a href="/customers/view?id=' . $customers->id . '" class="dropdown-item">' . $this->lang->line('View') . '</a>';
                $edit='<a href="/customers/edit?id=' . $customers->id . '" class="dropdown-item">' . $this->lang->line('Edit') . '</a>';
                $akt='<button class="akt_yoklama dropdown-item" cari_id="' . $customers->id . '">AKT / YOKLAMA BİLDİR</button>';
                $buttons_='<div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                İşlemler
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                '.$views.'
                '.$edit.'
                '.$akt.'
                '.$passive.'
              </div>
            </div>';

                $notes=$customers->address . ',' . $customers->city . ',' . $customers->country;
//                $tool='data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="'.$notes.'"';


                $name=$customers->company;

                $no++;
                $row = array();
                //$row[] = $no . ' <input type="checkbox" name="cust[]" class="checkbox" value="' . $customers->id . '"> ';

                $row[] = $no ;
                $row[] = $durums;
                $row[]='<span class="avatar-sm align-baseline"><img class="" src="' . base_url() . 'userfiles/customers/thumbnail/' . $customers->picture . '" ></span>';
                $row[] = '<a class="btn btn-outline-secondary btn-sm" href="/customers/view?id=' . $customers->id . '">' . $name . '</a>';
                $row[] = $customers->country;
                $row[] = $customers->email;
                $row[] = $customers->phone;
                $row[] = $customers->emp_name;
                $row[] = $buttons_;
                $row[] =$style ;
                $data[] = $row;
            }
        }


        $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->customers->count_all(),
            "recordsFiltered" => $this->customers->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function create()
    {
        if (!$this->aauth->premission(3)->write) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $this->session->unset_userdata('cari_invoice_data');
        $this->session->unset_userdata('cari_teslimat_data');
        $this->session->unset_userdata('cari_bank_data');

        $this->load->library("Common");
        $data['langs'] = $this->common->languages();
        $data['teminat'] = $this->common->teminat_type();
        $data['customergrouplist'] = $this->customers->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Yeni Müşteri';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/create', $data);
        $this->load->view('fixed/footer');
    }
    public function edit()
    {
        if (!$this->aauth->premission(3)->update) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        $this->load->library("Common");
        $pid = $this->input->get('id');

        $this->session->unset_userdata('cari_invoice_data');
        $this->session->unset_userdata('cari_teslimat_data');
        $this->session->unset_userdata('cari_bank_data');

        $teminat_type_id= $this->customers->teminat_type_id($pid);
        $data['customer'] = $this->customers->details($pid);
        $data['customer_b'] = $this->customers->bank_details($pid);
        $data['customer_inv'] = $this->customers->invoice_adres_details($pid);
        $data['customer_tes'] = $this->customers->invoice_teslimat_details($pid);
        $data['customer_pers'] = $this->customers->customer_personel_details($pid);


        $data['teminat'] = $this->common->teminat_type( $teminat_type_id['teminat_type']);
        $data['customergroup'] = $this->customers->group_info($data['customer']['gid']);
        $data['customergrouplist'] = $this->customers->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Müşteri Düzenle';
        $data['langs'] = $this->common->languages();
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/edit', $data);
        $this->load->view('fixed/footer');
    }



    public function view()
    {
        if (!$this->aauth->premission(3)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $custid = $this->input->get('id');
        $data['id'] = $this->input->get('id');
        $data['customer_id'] = $this->input->get('id');
        $data['para_birimi'] = 'tumu';
        $this->load->model('transactions_model');
        $data['details'] = $this->customers->details($data['id']);
        $head['title'] = "Müşteri Detayları";


        $head['usernm'] = $this->aauth->get_user()->username;


        $data['customer'] = $this->customers->details($data['id']);

        $data['customer_b'] = $this->customers->bank_details($data['id']);
        $data['customer_inv'] = $this->customers->invoice_adres_details($data['id']);
        $data['customer_tes'] = $this->customers->invoice_teslimat_details($data['id']);
        $data['customer_pers'] = $this->customers->customer_personel_details($data['id']);

        $id = $this->input->get('id');
        $customer_group_id=$this->db->query("SELECT * FROM geopos_customers WHERE id=$id")->row()->musteri_tipi;
        $this->load->view('fixed/header', $head);
        if($customer_group_id==10)
        {
            $this->load->view('customers/statement_musteri', $data);
        }
        else
        {
            $this->load->view('customers/statement', $data);
        }


        $this->load->view('fixed/footer');
    }


    public function controller_notes()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Notlar';
        $data['data'] = $this->db->query("SELECT geopos_cari_controller.*,geopos_customers.company,geopos_employees.name as pers_name FROM geopos_cari_controller Inner JOIN geopos_customers ON geopos_cari_controller.cari_id = geopos_customers.id Inner JOIN geopos_employees ON geopos_cari_controller.user_id = geopos_employees.id")->result();
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/controller_notes',$data);
        $this->load->view('fixed/footer');
    }


    public function potansiyel_musteriler()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Potansiyel Müşteriler';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/potansiyel_musteriler');
        $this->load->view('fixed/footer');
    }

    public function controller_save(){
        $cari_id  = $this->input->post('controller_cari_id');
        $date  = $this->input->post('controller_date');
        $controller_notes  = $this->input->post('controller_notes');
        if(cari_kont_kayit($cari_id,$date,$controller_notes)){
            echo json_encode(array('status' => 'Success', 'message' => 'Başarıyla Oluşturuldu'));
        }
    }

    public function create_project(){
        $this->db->trans_start();
        $result = $this->customers->create_project();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Proje OLuşuturuldu"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }

    }

    public function update_project(){
        $this->db->trans_start();
        $result = $this->customers->update_project();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>"Başarılı Bir Şekilde Proje Güncellendi"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }

    }

    public function passive_update(){
        $this->db->trans_start();
        $result = $this->customers->passive_update();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }

    }
    public function yoklama_delete(){
        $this->db->trans_start();
        $result = $this->customers->yoklama_delete();
        if($result['status']){

            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }

    }

    public function project_info(){
        $id  = $this->input->post('id');
        $project_details = $this->db->query("SELECT * FROM customers_project Where id=$id")->row();
        echo json_encode(array('status' => 200, 'item' =>$project_details));
    }

    public function podratci()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Podratci ve Siparişçi Müşteriler';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/podratci');
        $this->load->view('fixed/footer');
    }


    public function bulk_email()
    {
        $data['customer'] ='';
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/bulk_email', $data);
        $this->load->view('fixed/footer');
    }

    public function addcustomer()
    {
        $cari_tipi = $this->input->post('cari_tipi',true); // Özel Devlet  1 özel 2 devlet
        $company = $this->input->post('company',true); //firma adı
        $country = $this->input->post('country',true); // Firma Ülke
        $region = $this->input->post('region',true); //Şehir
        $city = $this->input->post('city',true); // Rayon
        $postbox = $this->input->post('postbox',true); // posta kodu
        $address = $this->input->post('address',true); // adresi
        $phone = $this->input->post('phone',true); // Firma Telefon
        $email = $this->input->post('email',true); // Firma E-Mail
        $name = $this->input->post('name',true); // Yetkili Adı
        $yetkili_tel = $this->input->post('yetkili_tel',true); // Yetkili Tel
        $yetkili_mail = $this->input->post('yetkili_mail',true); // Yetkili Mail
        $yetkili_gorev = $this->input->post('yetkili_gorev',true); // Yetkili Görev
        $sorumlu_personel = $this->input->post('sorumlu_personel',true); // Sorumlu Personel
        $sorumlu_muhasebe_personeli = $this->input->post('sorumlu_muhasebe_personeli',true); // Sorumlu Muhasebe Personeli
        $company_about = $this->input->post('company_about',true);  // Firma Hakkında Bilgi
        $taxid = $this->input->post('taxid',true); // VÖEN
        $kdv_orani = $this->input->post('kdv_orani',true); // KDV Oranı
        $sirket_tipi = $this->input->post('sirket_tipi',true); // Şirket Tipi Grup / Tekil  1 Tekil 2 Grup
        $parent_id = $this->input->post('parent_id',true); // Bağlı Olduğu Firma
        $musteri_tipi = $this->input->post('musteri_tipi',true); // cari Grubu
        $sektor = $this->input->post('sektor',true); // cari Grubu
        $customergroup =1;

        //$name_s = $this->input->post('name_s',true);
        //$phone_s = $this->input->post('phone_s',true);
        //$email_s = $this->input->post('email_s',true);
        //$address_s = $this->input->post('address_s',true);
        //$city_s = $this->input->post('city_s',true);
        //$region_s = $this->input->post('region_s',true);
        //$country_s = $this->input->post('country_s',true);
        //$postbox_s = $this->input->post('postbox_s',true);

        //$sektor = '';
        //$docid ='';
        //$custom ='';


        $discount = $this->input->post('discount',true);
        $teminat_type = $this->input->post('teminat_type',true);
        $customer_teminat_desc = $this->input->post('customer_teminat_desc',true);
        $customer_credit = $this->input->post('customer_credit',true);
        $customer_credit_you = $this->input->post('customer_credit_you',true);
        $create_login = $this->input->post('c_login',true);
        $password = $this->input->post('password_c',true);
        $language = $this->input->post('language',true);



        $this->customers->add($name, $company, $phone, $email, $address, $city, $region, $country,
            $postbox, $customergroup, $taxid, $language, $create_login,
            $password,$discount,
            $customer_teminat_desc,
            $teminat_type,
            $customer_credit,
            $company_about,
            $musteri_tipi,
            $kdv_orani,$parent_id,
            $sirket_tipi,
            $yetkili_tel,
            $yetkili_mail,
            $yetkili_gorev,
            $sorumlu_personel,
            $sorumlu_muhasebe_personeli,
            $cari_tipi,
            $customer_credit_you,
            $sektor

        );
    }

    public function cari_parent_kontrol(){
        $id = $this->input->post('id');
        $details = car_to_parent_cari($id);
        $messages = "Bu Carinin Bağlı Olduğu Cari Yoktur.Eğer Var ise Cost Kontrol Ekibine Bildiriniz!";
        if($details){
            $messages = "Bu Carinin Bağlı Olduğu Cari : ".$details->company.' dir.Yanlış Olduğunu Düşünüyorsanız Cost Kontrol Ekibine Bildiriniz!';
        }

        $data_details = [];
        $tedarikci_avans_kontrol = $this->db->query("Select * from geopos_invoices Where invoice_type_id = 73 and csd = $id");
        if($tedarikci_avans_kontrol->num_rows()){
            foreach ($tedarikci_avans_kontrol->result() as $items){
                $kalan_kontrol = $this->db->query("SELECT * FROM transaction_pay Where cari_id = $id and invoice_id = $items->id");
                if($kalan_kontrol->num_rows()){
                    $parcali_total=0;
                    foreach ($kalan_kontrol->result() as $item_kalan){

                        $parcali_total+=$item_kalan->amount;
                    }
                    $kalan = $items->total-$parcali_total;
                    $data_details[]=[
                        'invoice_id'=>$items->code,
                        'total'=>$kalan,
                    ];

                }
                else {
                    $data_details[]=[
                        'invoice_id'=>$items->code,
                        'total'=>$items->total,
                    ];
                }
            }
        }
        $txt='';

        if($data_details){
            $txt.="<hr><span>Açıkta Olan Tedarikçi Avansları</span><table class='table table-bordered'><tbody><tr><th>İşlem Kodu</th><th>Kalan Tutar</th></tr><tbody>";

            foreach ($data_details as $items_data){
                $txt.="<tr>";
                $txt.="<td>".$items_data['invoice_id']."</td>";
                $txt.="<td>".amountFormat($items_data['total'])."</td>";
                $txt.="<tr>";
            }
            $txt.="</tbody></table>";
        }


        echo json_encode(array(
            'status' => 'Success',
            'messages'=>$messages,
            'text'=>$txt
        ));
    }

    public function editcustomer()
    {
        if (!$this->aauth->premission(3)->update) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        $id = $this->input->post('id');
        $cari_tipi = $this->input->post('cari_tipi',true); // Özel Devlet  1 özel 2 devlet
        $company = $this->input->post('company',true); //firma adı
        $country = $this->input->post('country',true); // Firma Ülke
        $region = $this->input->post('region',true); //Şehir
        $city = $this->input->post('city',true); // Rayon
        $postbox = $this->input->post('postbox',true); // posta kodu
        $address = $this->input->post('address',true); // adresi
        $phone = $this->input->post('phone',true); // Firma Telefon
        $email = $this->input->post('email',true); // Firma E-Mail
        $name = $this->input->post('name',true); // Yetkili Adı
        $yetkili_tel = $this->input->post('yetkili_tel',true); // Yetkili Tel
        $yetkili_mail = $this->input->post('yetkili_mail',true); // Yetkili Mail
        $yetkili_gorev = $this->input->post('yetkili_gorev',true); // Yetkili Görev
        $sorumlu_personel = $this->input->post('sorumlu_personel',true); // Sorumlu Personel
        $sorumlu_muhasebe_personeli = $this->input->post('sorumlu_muhasebe_personeli',true); // Sorumlu Muhasebe Personeli
        $company_about = $this->input->post('company_about',true);  // Firma Hakkında Bilgi
        $taxid = $this->input->post('taxid',true); // VÖEN
        $kdv_orani = $this->input->post('kdv_orani',true); // KDV Oranı
        $sirket_tipi = $this->input->post('sirket_tipi',true); // Şirket Tipi Grup / Tekil  1 Tekil 2 Grup
        $parent_id = $this->input->post('parent_id',true); // Bağlı Olduğu Firma
        $musteri_tipi = $this->input->post('musteri_tipi',true); // cari Grubu
        $sektor = $this->input->post('sektor',true); // cari Grubu
        $customergroup =1;

        //$name_s = $this->input->post('name_s',true);
        //$phone_s = $this->input->post('phone_s',true);
        //$email_s = $this->input->post('email_s',true);
        //$address_s = $this->input->post('address_s',true);
        //$city_s = $this->input->post('city_s',true);
        //$region_s = $this->input->post('region_s',true);
        //$country_s = $this->input->post('country_s',true);
        //$postbox_s = $this->input->post('postbox_s',true);

        //$sektor = '';
        //$docid ='';
        //$custom ='';


        $discount = $this->input->post('discount',true);
        $teminat_type = $this->input->post('teminat_type',true);
        $customer_teminat_desc = $this->input->post('customer_teminat_desc',true);
        $customer_credit = $this->input->post('customer_credit',true);
        $customer_credit_you = $this->input->post('customer_credit_you',true);
        $create_login = $this->input->post('c_login',true);
        $password = $this->input->post('password_c',true);
        $language = $this->input->post('language',true);
        $folder_path = $this->input->post('folder_path',true);
        $ekstre_tipi = $this->input->post('ekstre_tipi',true);

        if ($id) {
            $this->customers->edit($id,$name, $company, $phone, $email, $address, $city, $region, $country,
                $postbox, $customergroup, $taxid, $language, $create_login,
                $password,$discount,
                $customer_teminat_desc,
                $teminat_type,
                $customer_credit,
                $company_about,
                $musteri_tipi,
                $kdv_orani,$parent_id,
                $sirket_tipi,
                $yetkili_tel,
                $yetkili_mail,
                $yetkili_gorev,
                $sorumlu_personel,
                $sorumlu_muhasebe_personeli,
                $cari_tipi,
                $customer_credit_you,
                $sektor,
                $folder_path,
                $ekstre_tipi
            );
        }
    }

    public function customer_details_()
    {
        $id = $this->input->post('id');
        $tip = $this->input->post('tip');
        $data=array();
        if($tip==1) // banka
        {
            $data['details'] = $this->db->query("SELECT * FROM geopos_customer_bank WHERE id=$id")->row_array();
            $this->load->view('customers/view_bilgi_bank', $data);
        }
        else if($tip==2) // Fatura Adresi
        {
            $data['details'] = $this->db->query("SELECT * FROM geopos_customer_iadress WHERE id=$id")->row_array();
            $this->load->view('customers/view_bilgi_invoice_adresi', $data);
        }

        else if($tip==3) // Teslimat Adresi
        {
            $data['details'] = $this->db->query("SELECT * FROM geopos_customer_tadress WHERE id=$id")->row_array();
            $this->load->view('customers/view_bilgi_teslimat_adresi', $data);
        }




    }

    public function view_customer_details_()
    {
        $id = $this->input->post('id');
        $tip = $this->input->post('tip');
        $data=array();
        if($tip==1) // banka
        {
            $data['details'] = $this->db->query("SELECT * FROM geopos_customer_bank WHERE id=$id")->row_array();
            $this->load->view('customers/view_bilgi_bank_', $data);
        }
        else if($tip==2) // Fatura Adresi
        {
            $data['details'] = $this->db->query("SELECT * FROM geopos_customer_iadress WHERE id=$id")->row_array();
            $this->load->view('customers/view_bilgi_invoice_adresi_', $data);
        }

        else if($tip==3) // Teslimat Adresi
        {
            $data['details'] = $this->db->query("SELECT * FROM geopos_customer_tadress WHERE id=$id")->row_array();
            $this->load->view('customers/view_bilgi_teslimat_adresi_', $data);
        }




    }

    public function  remove_data_cust()
    {
        $id = $this->input->post('id');
        $tip = $this->input->post('tip');
        if($tip==1) // banka
        {
            $this->db->delete('geopos_customer_bank', array('id' => $id));
        }
        else if($tip==2) // Fatura Adresi
        {
            $this->db->delete('geopos_customer_iadress', array('id' => $id));
        }

        else if($tip==3) // Teslimat Adresi
        {
            $this->db->delete('geopos_customer_tadress', array('id' => $id));
        }
        else if($tip==4) // Teslimat Adresi
        {
            $this->db->delete('geopos_customer_personel', array('id' => $id));
        }
        echo json_encode(array(
            'status' => 'Success'));
    }

    public function remove_sessioan()
    {

        $id = $this->input->post('id');
        $tip = $this->input->post('tip');

        if($tip==1) // banka
        {
            $data = $this->session->userdata('cari_bank_data');
            $this->session->unset_userdata('cari_bank_data');
            $data_=array();
            foreach ($data as $key => $value)
            {
                if($value['id']!=$id)
                {
                    $data_[] = array(
                        'hesap_numarasi'  => $value['hesap_numarasi'],
                        'banka'     => $value['banka'],
                        'iden_numarasi' =>$value['iden_numarasi'],
                        'banka_unvan' =>$value['banka_unvan'],
                        'banka_tel' =>$value['banka_tel'],
                        'banka_fax' =>$value['banka_fax'],
                        'kod' =>$value['kod'],
                        'swift' =>$value['swift'],
                        'banka_voen' =>$value['banka_voen'],
                        'muh_hesab' =>$value['muh_hesab'],
                        'para_birimi' =>$value['para_birimi'],
                        'user_id' =>$value['user_id'],
                        'id' =>$value['id']
                    );


                }
            }
            $this->session->set_userdata('cari_bank_data',$data_);
        }
        else if($tip==2) // invoice
        {
            $data = $this->session->userdata('cari_invoice_data');
            $this->session->unset_userdata('cari_invoice_data');
            $data_=array();
            foreach ($data as $key => $value)
            {
                if($value['id']!=$id)
                {
                    $data_[] = array(
                        'unvan_invoice'  => $value['unvan_invoice'],
                        'country_invoice'     => $value['country_invoice'],
                        'sehir_invoice' =>$value['sehir_invoice'],
                        'city_invoice' =>$value['city_invoice'],
                        'post_invoice' =>$value['post_invoice'],
                        'adres_invoice' =>$value['adres_invoice'],
                        'phone_invoice' =>$value['phone_invoice'],
                        'email_invoice' =>$value['email_invoice'],
                        'user_id' =>$value['user_id'],
                        'id' =>$value['id']
                    );


                }
            }
            $this->session->set_userdata('cari_invoice_data',$data_);
        }
        else if($tip==3) // teslimat
        {
            $data = $this->session->userdata('cari_teslimat_data');
            $this->session->unset_userdata('cari_teslimat_data');
            $data_=array();
            foreach ($data as $key => $value)
            {
                if($value['id']!=$id)
                {
                    $data_[] = array(
                        'unvan_teslimat'  => $value['unvan_teslimat'],
                        'country_teslimat'     => $value['country_teslimat'],
                        'sehir_teslimat' =>$value['sehir_teslimat'],
                        'city_teslimat' =>$value['city_teslimat'],
                        'post_teslimat' =>$value['post_teslimat'],
                        'adres_teslimat' =>$value['adres_teslimat'],
                        'phone_teslimat' =>$value['phone_teslimat'],
                        'email_teslimat' =>$value['email_teslimat'],
                        'user_id' =>$value['user_id'],
                        'id' =>$value['id']
                    );


                }
            }
            $this->session->set_userdata('cari_teslimat_data',$data_);
        }

        echo json_encode(array(
            'status' => 'Success'));


        /*
                $this->session->unset_userdata('cari_invoice_data');
                $this->session->unset_userdata('cari_teslimat_data');
                $this->session->unset_userdata('cari_bank_data');
        */

    }

    public function session_teslimat()
    {

        $unvan_teslimat = $this->input->post('unvan_teslimat');
        $country_teslimat = $this->input->post('country_teslimat');
        $sehir_teslimat = $this->input->post('sehir_teslimat');
        $city_teslimat = $this->input->post('city_teslimat');
        $post_teslimat = $this->input->post('post_teslimat');
        $adres_teslimat = $this->input->post('adres_teslimat');
        $phone_teslimat = $this->input->post('phone_teslimat');
        $email_teslimat = $this->input->post('email_teslimat');
        $session_id=rand(10,9999999);
        $data=array();
        $ses_data=$this->session->userdata('cari_teslimat_data');
        $deger=1;
        if(isset($ses_data))
        {
            foreach ($ses_data as $sd)
            {
                $data[] = array(
                    'unvan_teslimat'  => $sd['unvan_teslimat'],
                    'country_teslimat'     => $sd['country_teslimat'],
                    'sehir_teslimat' =>$sd['sehir_teslimat'],
                    'city_teslimat' =>$sd['city_teslimat'],
                    'post_teslimat' =>$sd['post_teslimat'],
                    'adres_teslimat' =>$sd['adres_teslimat'],
                    'phone_teslimat' =>$sd['phone_teslimat'],
                    'email_teslimat' =>$sd['email_teslimat'],
                    'user_id' =>$sd['user_id'],
                    'id' =>$sd['id']
                );

                $deger=$deger+1;
            }
        }

        $data[] = array(
            'unvan_teslimat'  => $unvan_teslimat,
            'country_teslimat'     => $country_teslimat,
            'sehir_teslimat' =>$sehir_teslimat,
            'city_teslimat' =>$city_teslimat,
            'post_teslimat' =>$post_teslimat,
            'adres_teslimat' =>$adres_teslimat,
            'phone_teslimat' =>$phone_teslimat,
            'email_teslimat' =>$email_teslimat,
            'user_id' =>$this->aauth->get_user()->id,
            'id' =>$session_id
        );

        $this->session->set_userdata('cari_teslimat_data',$data);

        echo json_encode(array(
            'status' => 'Success',
            'no'=>$deger,
            'unvan'=>$unvan_teslimat,
            'eylem'=>'<a href="#" class="btn btn-danger delete_teslimat" tip="3"  id="'.$session_id.'" ">Sil</a> '));
    }

    public function session_invoice()
    {

        $unvan_invoice = $this->input->post('unvan_invoice');
        $country_invoice = $this->input->post('country_invoice');
        $sehir_invoice = $this->input->post('sehir_invoice');
        $city_invoice = $this->input->post('city_invoice');
        $post_invoice = $this->input->post('post_invoice');
        $adres_invoice = $this->input->post('adres_invoice');
        $phone_invoice = $this->input->post('phone_invoice');
        $email_invoice = $this->input->post('email_invoice');
        $session_id=rand(10,9999999);
        $data=array();
        $ses_data=$this->session->userdata('cari_invoice_data');

        $deger=1;
        if(isset($ses_data))
        {
            foreach ($ses_data as $sd)
            {
                $data[] = array(
                    'unvan_invoice'  => $sd['unvan_invoice'],
                    'country_invoice'     => $sd['country_invoice'],
                    'sehir_invoice' =>$sd['sehir_invoice'],
                    'city_invoice' =>$sd['city_invoice'],
                    'post_invoice' =>$sd['post_invoice'],
                    'adres_invoice' =>$sd['adres_invoice'],
                    'phone_invoice' =>$sd['phone_invoice'],
                    'email_invoice' =>$sd['email_invoice'],
                    'user_id' =>$sd['user_id'],
                    'id' =>$sd['id']
                );
                $deger=$deger+1;
            }
        }

        $data[]= array(
            'unvan_invoice'  => $unvan_invoice,
            'country_invoice'     => $country_invoice,
            'sehir_invoice' =>$sehir_invoice,
            'city_invoice' =>$city_invoice,
            'post_invoice' =>$post_invoice,
            'adres_invoice' =>$adres_invoice,
            'phone_invoice' =>$phone_invoice,
            'email_invoice' =>$email_invoice,
            'user_id' =>$this->aauth->get_user()->username,
            'id' =>$session_id
        );

        $this->session->set_userdata('cari_invoice_data',$data);

        echo json_encode(array(
            'status' => 'Success',
            'no'=>$deger,
            'unvan'=>$unvan_invoice,
            'eylem'=>'<a href="#" class="btn btn-danger delete_invoice"  tip="2"  id="'.$session_id.'" ">Sil</a> '));
    }

    public function session_bank()
    {

        $hesap_numarasi = $this->input->post('hesap_numarasi');
        $banka = $this->input->post('banka');
        $iden_numarasi = $this->input->post('iden_numarasi');
        $banka_unvan = $this->input->post('banka_unvan');
        $banka_tel = $this->input->post('banka_tel');
        $banka_fax = $this->input->post('banka_fax');
        $kod = $this->input->post('kod');
        $swift = ($this->input->post('swift'))?$this->input->post('swift'):'';
        $banka_voen = $this->input->post('banka_voen');
        $muh_hesab = $this->input->post('muh_hesab');
        $para_birimi = $this->input->post('para_birimi');
        $session_id=rand(10,9999999);
        $data=array();
        $ses_data=$this->session->userdata('cari_bank_data');

        $deger=1;
        if(isset($ses_data))
        {
            foreach ($ses_data as $sd)
            {
                $data[] = array(
                    'hesap_numarasi'  => $sd['hesap_numarasi'],
                    'banka'     => $sd['banka'],
                    'iden_numarasi' =>$sd['iden_numarasi'],
                    'banka_unvan' =>$sd['banka_unvan'],
                    'banka_tel' =>$sd['banka_tel'],
                    'banka_fax' =>$sd['banka_fax'],
                    'kod' =>$sd['kod'],
                    'swift' =>$sd['swift'],
                    'banka_voen' =>$sd['banka_voen'],
                    'muh_hesab' =>$sd['muh_hesab'],
                    'para_birimi' =>$sd['para_birimi'],
                    'user_id' =>$sd['user_id'],
                    'id' =>$sd['id']
                );

                $deger=$deger+1;
            }
        }

        $data[] = array(
            'hesap_numarasi'  => $hesap_numarasi,
            'banka'     => $banka,
            'iden_numarasi' =>$iden_numarasi,
            'banka_unvan' =>$banka_unvan,
            'banka_tel' =>$banka_tel,
            'banka_fax' =>$banka_fax,
            'kod' =>$kod,
            'swift_kodu' =>$swift,
            'banka_voen' =>$banka_voen,
            'muh_hesab' =>$muh_hesab,
            'para_birimi' =>$para_birimi,
            'user_id' =>$this->aauth->get_user()->id,
            'id' =>$session_id
        );


        $this->session->set_userdata('cari_bank_data',$data);

        echo json_encode(array(
            'status' => 'Success',
            'no'=>$deger,
            'bank_adi'=>$banka,
            'eylem'=>'<a href="#" class="btn btn-danger delete_bank"  tip="1"  id="'.$session_id.'" ">Sil</a> '));
    }


    public function bank_details_print()

    {

        $tid = $this->input->get('id');

        $data['id'] = $tid;

        $data['invoice'] = $this->customers->bank_details_id($tid);



        ini_set('memory_limit', '64M');


        $html = $this->load->view('customers/view-print-bank-' . LTR, $data, true);
        $header = $this->load->view('customers/header-print-bank-' . LTR, $data, true);
        $footer = $this->load->view('customers/footer-print-bank-' . LTR, $data, true);

        //PDF Rendering

        $this->load->library('pdf');


        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter($footer);
        $pdf->AddPage(
            'P', // L - landscape, P - portrait
            '', '', '', '',
            '', // margin_left
            '', // margin right
            30, // margin top
            '72', // margin bottom
            5, 2, 0, 0, // margin header
            'auto'); // margin footer

        $pdf->WriteHTML($html);


        $file_name = preg_replace('/[^A-Za-z0-9]+/', '-', 'BankDetails___');

        if ($this->input->get('d')) {


            $pdf->Output($file_name . '.pdf', 'D');

        } else {

            $pdf->Output($file_name . '.pdf', 'I');

        }


    }

    public function file_handling(){
        if ($this->input->get('op')) {

            $name = $this->input->get('name');

            if ($this->transactions->meta_delete($name)) {

                echo json_encode(array('status' => 'Success'));

            }

        } else {

            $id = $this->input->get('id');

            $this->load->library("Uploadhandler_generic", array(

                'accept_file_types' => '/\.(pdf|gif|jpe?g|png|xlsx)$/i', 'upload_dir' => FCPATH . 'userfiles/documents/', 'upload_url' => base_url() . 'userfiles/documents/'

            ));
        }
    }


    public function update_pass(){
        $this->db->trans_start();
        $cari_id=$this->input->post('cari_id');
        $pass=$this->input->post('pass');
        $number=$this->input->post('number');


        $kontrol  = $this->db->query("Select * From customer_info Where  phone = $number");
        if($kontrol->num_rows()) {
            if($cari_id!=$kontrol->row()->customer_id){
                $customer_id = $kontrol->row()->customer_id;
                $name  = customer_details($customer_id)['company'];
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Bu Telefon Numarası Başka Bir Caride Kayıtlı. Cari Adı: ".$name));

            }
            else{
                if($this->customers->changepassword($cari_id, $number,$pass)){
                    $this->aauth->applog("Cari Şifresi Değiştirildi : Cari ID : ".$cari_id, $this->aauth->get_user()->username);
                    echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Onay Verildi"));
                    $this->db->trans_complete();
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
                }
            }
        }
        else {
            if($this->customers->changepassword($cari_id, $number,$pass)){
                $this->aauth->applog("Cari Şifresi Değiştirildi : Cari ID : ".$cari_id, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Onay Verildi"));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
            }
        }

    }

    public function changepassword()
    {
        if (!$this->aauth->premission(3)->update) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        if ($id = $this->input->post()) {
            $id = $this->input->post('id');
            $password = $this->input->post('password',true);
            if ($id) {
                $this->customers->changepassword($id, $password);
            }
        } else {
            $pid = $this->input->get('id');
            $data['customer'] = $this->customers->details($pid);
            $data['customergroup'] = $this->customers->group_info($pid);
            $data['customergrouplist'] = $this->customers->group_list();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Müşteri Düzenle';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/edit_password', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function delete_i()
    {
        if (!$this->aauth->premission(30)) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        //if ($this->aauth->get_user()->roleid < 3) {
        //  echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        // }
        $id = $this->input->post('deleteid');
        if ($id > 1) {
            if ($this->customers->delete($id)) {
                echo json_encode(array('status' => 'Success', 'message' => 'Cari Başarıyla Silinmiştir.'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
            }
        }
    }

    public function displaypic()
    {

        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/customers/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->customers->editpicture($id, $img);
        }
    }

    public function displaypiccomp()
    {

        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/customers/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->customers->editpicture_comp($id, $img);
        }
    }


    public function translist()
    {
        if (!$this->aauth->premission(3)->read) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        $cid = $this->input->post('cid');
        $list = $this->customers->trans_table($cid);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->date;
            $row[] = amountFormat($prd->debit);
            $row[] = amountFormat($prd->credit);
            $row[] = $prd->account;

            $row[] = $this->lang->line($prd->method);
            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-eye"></span>  ' . $this->lang->line('View') . '</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-bin"></span></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->trans_count_all($cid),
            "recordsFiltered" => $this->customers->trans_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function inv_list()
    {
        if (!$this->aauth->premission(3)->read) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');

        $list = $this->customers->inv_datatables($cid, $tid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
            $row = array();

            $row[] = $invoices->invoice_no;

            $row[] = $invoices->invoicedate;
            $row[] = amountFormat($invoices->total);
            $row[] = '<span class="st-' . $invoices->status . '">' .invoice_status($invoices->status). '</span>';
            $row[] = invoice_type_id($invoices->invoice_type_id);
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-xs" title="Fatura Görüntüle"><i class="fa fa-eye"></i> </a> <a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-print"></span></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->inv_count_all($cid),
            "recordsFiltered" => $this->customers->inv_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function inv_list_alt()
    {
        if (!$this->aauth->premission(3)->read) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');

        $list = $this->customers->inv_datatables_alt($cid, $tid);


        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
            $row = array();

            $row[] = customer_details($invoices->csd)['company'];
            $row[] = $invoices->invoice_no;
            $row[] = $invoices->invoicedate;
            $row[] = amountFormat($invoices->total);
            $row[] = '<span class="st-' . $invoices->status . '">' .invoice_status($invoices->status). '</span>';
            $row[] = invoice_type_id($invoices->invoice_type_id);
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-xs" title="Fatura Görüntüle"><i class="fa fa-eye"></i> </a> <a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="fa fa-print"></span></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->inv_count_all_alt($cid),
            "recordsFiltered" => $this->customers->inv_count_filtered_alt($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function transactions()
    {
        if (!$this->aauth->premission(3)->read) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'İşlemler';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/transactions', $data);
        $this->load->view('fixed/footer');
    }

    public function invoices()
    {
        if (!$this->aauth->premission(3)->read) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Faturalar';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/invoices', $data);
        $this->load->view('fixed/footer');
    }
    public function alt_invoices()
    {
        if (!$this->aauth->premission(3)->read) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['totals'] =  $this->db->query("SELECT IF(SUM(total*kur_degeri) ,SUM(total*kur_degeri) ,0)as totals FROM geopos_invoices Where alt_cari_id=$custid")->row()->totals;
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Faturalar';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/alt_invoices', $data);
        $this->load->view('fixed/footer');
    }

    public function quotes()
    {
        if (!$this->aauth->premission(3)->read) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Teklifler';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/quotes', $data);
        $this->load->view('fixed/footer');
    }

    public function avanstalep()
    {
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['talepler']=$this->db->query("SELECT * FROM `geopos_talep` WHERE `talep_eden_pers_id` = $custid and cari_pers=2 and tip=5")->result();
        $head['title'] = 'Teklifler';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/avanstalep', $data);
        $this->load->view('fixed/footer');
    }
    public function qto_list()
    {
        if (!$this->aauth->premission(3)->read) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');
        $data_array=[];
        $list=[];
        $list_ = $this->customers->qto_datatables($cid, $tid);


        $sf_total = $this->db->query("SELECT SUM(geopos_talep_items.subtotal) as_total FROM geopos_talep_items LEFT JOIN geopos_talep ON geopos_talep_items.tip=geopos_talep.id WHERE geopos_talep_items.firma_id=$cid and geopos_talep.tip=2;")->row()->as_total;

        $parent_customer = customer_parent($cid);
        $sf_total_parent=0;

        if($parent_customer){
            foreach ($parent_customer as $parent_id){

                $sf_total_parent += $this->db->query("SELECT SUM(geopos_talep_items.subtotal) as_total FROM geopos_talep_items LEFT JOIN geopos_talep ON geopos_talep_items.tip=geopos_talep.id WHERE geopos_talep_items.firma_id=$parent_id and geopos_talep.tip=2;")->row()->as_total;

                $data_array[] = $this->customers->qto_datatables($parent_id, $tid);
            }
        }

        $genel_sf_total = floatval($sf_total)+floatval($sf_total_parent);

//        $list_all = array_merge($data_array,$list_);
//
//        foreach ($list_all as $value){
//            foreach ($value as $key){
//                $list[] = $key;
//            }
//        }



        if(count($data_array)>0){
            if(count($data_array[0])>0)
            {
                $data_q=[];
                foreach ($data_array as $value){
                    foreach ($value as $item){
                        $data_q[]=$item;
                    }
                }
                $list = array_merge($list_,$data_q);
            }
            else
            {
                $list = $list_;
            }
        }
        else {
            $list = $list_;
        }


        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $invoices->firma;
            $row[] = $invoices->talep_no.' - '.sf_firma_total($invoices->tip,$invoices->firma);
            $row[] = $invoices->olusturma_tarihi;
            $row[] = $invoices->product_name;
            $row[] = amountFormat($invoices->price);
            $row[] = $invoices->qty;
            $row[] = amountFormat($invoices->subtotal);
            $row[] = amountFormat($genel_sf_total);
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->qto_count_all($cid),
            "recordsFiltered" => $this->customers->qto_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function balance()
    {
        if (!$this->aauth->premission(3)->read) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $amount = $this->input->post('amount',true);
            if ($this->customers->recharge($id, $amount)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Balance Added')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
            }
        } else {
            $custid = $this->input->get('id');
            $data['details'] = $this->customers->details($custid);
            $data['customergroup'] = $this->customers->group_info($data['details']['gid']);
            $data['money'] = $this->customers->money_details($custid);
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['activity'] = $this->customers->activity($custid);
            $head['title'] = 'Müşteriler';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/recharge', $data);
            $this->load->view('fixed/footer');
        }
    }

    public function projects()
    {
        if (!$this->aauth->premission(3)->read) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Faturalar';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/projects', $data);
        $this->load->view('fixed/footer');
    }

    public function prj_list()
    {
        if (!$this->aauth->premission(3)->read) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        $cid = $this->input->post('cid');


        $list = $this->customers->project_datatables($cid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $project) {
            $no++;
            $name = '<a href="' . base_url() . 'projects/explore?id=' . $project->id . '">' . $project->name . '</a>';

            $row = array();
            $row[] = $no;
            $row[] = $name;
            $row[] = dateformat($project->sdate);
            $row[] = $project->customer;
            $row[] = '<span class="project_' . $project->status . '">' . $this->lang->line($project->status) . '</span>';

            $row[] = '<a href="' . base_url() . 'projects/explore?id=' . $project->id . '" class="btn btn-primary btn-sm rounded" data-id="' . $project->id . '" data-stat="0"> ' . $this->lang->line('View') . ' </a>
                    <a class="btn btn-info btn-sm" href="' . base_url() . 'projects/edit?id=' . $project->id . '" data-object-id="' . $project->id . '"> <i class="icon-pencil"></i> </a>&nbsp;
                    <a class="btn btn-info btn-sm" href="' . base_url() . 'customers/projects_detay?csd='.$cid.'&id=' . $project->id . '"> <i class="fa fa-info"></i> </a>';


            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->project_count_all($cid),
            "recordsFiltered" => $this->customers->project_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function notes()
    {
        if (!$this->aauth->premission(3)->write) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        $custid = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['details'] = $this->customers->details($custid);
        $this->session->set_userdata("cid",$custid);
        $head['title'] = 'Notes';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/notes', $data);
        $this->load->view('fixed/footer');
    }


    public function randevu_list()
    {
        if (!$this->aauth->premission(3)->read) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        $custid = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['details'] = $this->customers->details($custid);
        $this->session->set_userdata("cid",$custid);
        $head['title'] = 'Notes';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/randevu_list', $data);
        $this->load->view('fixed/footer');
    }

    public function notes_load_list()
    {
        if (!$this->aauth->premission(3)->read) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        $cid = $this->input->post('cid');
        $list = $this->customers->notes_datatables($cid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $note) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $note->title;
            $row[] = dateformat($note->cdate);

            $row[] = '<a href="editnote?id=' . $note->id . '&cid=' . $note->fid . '" class="btn btn-info btn-sm"><span class="fa fa-eye"></span> ' . $this->lang->line('View') . '</a> <a class="btn btn-danger btn-sm delete-object" href="#" data-object-id="' . $note->id . '"> <i class="fa fa-trash-o "></i> </a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->notes_count_all($cid),
            "recordsFiltered" => $this->customers->notes_count_filtered($cid),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function editnote()
    {
        if (!$this->aauth->premission(3)->update) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $title = $this->input->post('title',true);
            $content = $this->input->post('content');
            $cid = $this->input->post('cid');
            if ($this->customers->editnote($id, $title, $content,$cid)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED') . " <a href='notes?id=$cid' class='btn btn-indigo btn-lg'><span class='icon-user' aria-hidden='true'></span>  </a> <a href='editnote?id=$id&cid=$cid' class='btn btn-indigo btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $id = $this->input->get('id');
            $cid = $this->input->get('cid');
            $data['note'] = $this->customers->note_v($id, $cid);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Düzenle';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/editnote', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function addnote()
    {
        if (!$this->aauth->premission(3)->write) {
            echo json_encode(array('status' => 'Error', 'message' => 'Üzgünüm Yetkiniz Bulunmamakta'));
        }
        if ($this->input->post('title')) {

            $title = $this->input->post('title',true);
            $cid = $this->input->post('id');
            $content = $this->input->post('content');

            if ($this->customers->addnote($title, $content, $cid)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='addnote?id=" . $cid . "' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='notes?id=" . $cid . "' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Yeni Not';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/addnote', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function delete_note()
    {
        $id = $this->input->post('deleteid');
        $cid = $this->session->userdata('cid');
        if ($this->customers->deletenote($id,$cid)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    function projects_detay()
    {
        $data['csd'] = $this->input->get('csd');
        $data['id'] = $this->input->get('id');
        $this->load->model('transactions_model');
        $data['details'] = $this->customers->details($data['csd']);
        $head['title'] = "Müşteri Detayları";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['para_birimi'] = 'tumu';
        $data['proje_id'] = $this->input->get('id');
        $data['customer_id'] = $this->input->get('csd');
        $head['title'] = "Müşteri Proje Ekstresi";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/projects_detay', $data);
        $this->load->view('fixed/footer');

    }

    public function statement_sozlesme()
    {
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));
        $data['id'] = $this->input->get('id');
        $data['para_birimi'] = $para_birimi;
        $this->load->model('transactions_model');
        $data['details'] = $this->customers->details($data['id']);
        $head['title'] = "Müşteri Detayları";
        $head['usernm'] = $this->aauth->get_user()->username;
        $id = $this->input->get('id');
        $customer_group_id=$this->db->query("SELECT * FROM geopos_customers WHERE id=$id")->row()->musteri_tipi;
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/statement_sozlesme', $data);


        $this->load->view('fixed/footer');
    }

    function statement()
    {
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));
        if($this->input->post()){



            $this->load->model('reports_model');


            $proje_id=0;
            $customer = $this->input->post('customer');
            $trans_type = $this->input->post('trans_type');
            $proje_id = $this->input->post('proje_ids');

            //$sdate = datefordatabase($this->input->post('sdate'));
            //$edate = datefordatabase($this->input->post('edate'));
            $data['customer'] = $this->customers->details($customer);

            $data['customer_b'] = $this->customers->bank_details($customer);
            $data['customer_inv'] = $this->customers->invoice_adres_details($customer);
            $data['customer_tes'] = $this->customers->invoice_teslimat_details($customer);
            $data['customer_pers'] = $this->customers->customer_personel_details($customer);

            $data['para_biri_s']=$this->input->post('para_birimi');
            $data['proje_id']=$proje_id;


            $data['list'] = $this->reports_model->get_customer_statements($customer, $trans_type,$this->input->post('para_birimi'),$proje_id);




            $html = $this->load->view('customers/statementpdf', $data, true);


            ini_set('memory_limit', '64M');


            $this->load->library('pdf');

            $pdf = $this->pdf->load();


            $pdf->WriteHTML($html);


            $pdf->Output('Statement' . $customer . '.pdf', 'I');
        }

        else {

            $data['id'] = $this->input->get('id');
            $data['para_birimi'] = $para_birimi;
            $this->load->model('transactions_model');
            $data['details'] = $this->customers->details($data['id']);
            $head['title'] = "Müşteri Detayları";
            $head['usernm'] = $this->aauth->get_user()->username;
            $id = $this->input->get('id');
            $customer_group_id=$this->db->query("SELECT * FROM geopos_customers WHERE id=$id")->row()->musteri_tipi;
            $this->load->view('fixed/header', $head);
            if($customer_group_id==10)
            {
                $this->load->view('customers/statement_musteri', $data);
            }
            else
            {
                $this->load->view('customers/statement', $data);
            }


            $this->load->view('fixed/footer');
        }

    }


    public function siparis_ekstre()
    {
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));
        if($this->input->post()){



            $this->load->model('reports_model');


            $customer = $this->input->post('customer');
            $trans_type = $this->input->post('trans_type');

            //$sdate = datefordatabase($this->input->post('sdate'));
            //$edate = datefordatabase($this->input->post('edate'));
            $data['customer'] = $this->customers->details($customer);
            $data['para_biri_s']=$this->input->post('para_birimi');


            $data['list'] = $this->reports_model->get_customer_siparis_ekstre($customer, $trans_type,$this->input->post('para_birimi'));




            $html = $this->load->view('customers/statementpdf', $data, true);


            ini_set('memory_limit', '64M');


            $this->load->library('pdf');

            $pdf = $this->pdf->load();


            $pdf->WriteHTML($html);


            $pdf->Output('Statement' . $customer . '.pdf', 'I');
        }

        else {
            $data['id'] = $this->input->get('id');
            $data['para_birimi'] = $para_birimi;
            $this->load->model('transactions_model');
            $data['details'] = $this->customers->details($data['id']);
            $head['title'] = "Müşteri Detayları";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/siparis_ekstre', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function documents()
    {
        $data['id'] = $this->input->get('id');
        $data['details'] = $this->customers->details($data['id']);
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->session->set_userdata("cid",$data['id']);
        $head['title'] = 'Dosyalar';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/documents',$data);
        $this->load->view('fixed/footer');


    }

    public function document_load_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->customers->document_datatables($cid);
        $data = array();
        $no = $this->input->post('start');


        foreach ($list as $document) {
            $proje_code='';
            if($document->proje_id){
                $proje_code = proje_code($document->proje_id);
            }
            $file_type='';

            if($document->file_type_id){
                $file_type = file_type_details($document->file_type_id)->name;
            }

            $edit = "<button class='btn btn-warning edit' talep_id='$document->id'><i class='fa fa-pencil'></i></button>&nbsp;";
            $cancel = "<button class='btn btn-danger talep_sil' talep_id='$document->id' type='button'><i class='fa fa-ban'></i></button>&nbsp;";
            $view = "<a class='btn btn-success view' href='".base_url('userfiles/documents/' . $document->filename)."' type='button'><i class='fa fa-eye'></i></a>&nbsp;";

            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $document->title;
            $row[] = dateformat($document->baslangic_date);
            $row[] = dateformat($document->bitis_date);
            $row[] = $proje_code;
            $row[] = $file_type;
            $row[] = $view.$edit.$cancel;


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->document_count_all($cid),
            "recordsFiltered" => $this->customers->document_count_filtered($cid),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function document_get_info(){
        $id = $this->input->post('edit_id');
        $row = $this->db->query("SELECT * FROM geopos_documents Where id=$id")->row();
        echo json_encode(array('status' => 'Success','items'=>$row));

    }


    public function remove_document(){
        $this->db->trans_start();
        $id = $this->input->post('edit_id');
        if($this->db->delete('geopos_documents', array('id' => $id))){
            $this->aauth->applog("cariden  File Silindi  : File ID : ".$id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Silindi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }

    }

    public function add_document(){
        $this->db->trans_start();
        $bitis_date = $this->input->post('bitis_date');
        $baslangic_date = $this->input->post('baslangic_date');
        $file_type_id = $this->input->post('file_type_id');
        $name = $this->input->post('name');
        $cari_id = $this->input->post('cari_id');
        $image_text = $this->input->post('image_text');
        $proje_id = $this->input->post('proje_id');

        $data = array(
            'baslangic_date' => $baslangic_date,
            'bitis_date' => $bitis_date,
            'title' => $name,
            'filename' => $image_text,
            'cdate' => date('Y-m-d'),
            'cid'=>$this->aauth->get_user()->id,
            'fid'=>$cari_id,
            'rid'=>1,
            'file_type_id'=>$file_type_id,
            'proje_id'=>$proje_id
        );
        if($this->db->insert('geopos_documents', $data)){
            $this->aauth->applog("Cariye Belge Eklendi : ".$cari_id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Dosya Eklendi'));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));

        }
    }

    public function update_document(){
        $this->db->trans_start();
        $id = $this->input->post('edit_id');
        $bitis_date = $this->input->post('bitis_date');
        $baslangic_date = $this->input->post('baslangic_date');
        $file_type_id = $this->input->post('file_type_id');
        $name = $this->input->post('name');
        $cari_id = $this->input->post('cari_id');
        $image_text = $this->input->post('image_text');
        $proje_id = $this->input->post('proje_id');

        $data = array(
            'baslangic_date' => $baslangic_date,
            'bitis_date' => $bitis_date,
            'title' => $name,
            'filename' => $image_text,
            'fid'=>$cari_id,
            'rid'=>1,
            'file_type_id'=>$file_type_id,
            'proje_id'=>$proje_id
        );
        $this->db->where('id',$id);
        $this->db->set($data);
        if($this->db->update('geopos_documents', $data)){
            $this->aauth->applog("Cariye Belge Güncellendi : ".$cari_id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success','message'=>'Başarıyla Dosya Güncellendi'));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));

        }
    }

    public function adddocument()
    {
        $data['id'] = $this->input->get('id');
        $data['customer_id'] = $this->input->get('id');
        $this->load->helper(array('form'));
        $data['response'] = 3;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Dosya Ekle';

        $this->load->view('fixed/header', $head);

        if ($this->input->post('title')) {
            $title = $this->input->post('title',true);
            $cid = $this->input->post('id');
            $baslangic_date_ = datefordatabase($this->input->post('baslangic_date'));
            $bitis_date_ = datefordatabase($this->input->post('bitis_date'));



            $config['upload_path'] = './userfiles/documents';
            $config['allowed_types'] = 'docx|docs|txt|pdf|xls';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = 300000000;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('userfile')) {
                $data['response'] = 0;
                $data['responsetext'] = 'File Upload Error';

            } else {
                $data['response'] = 1;
                $data['responsetext'] = 'Başarıyla YÜklendi. <a href="documents?id='.$cid.'"
                                       class="btn btn-indigo btn-md"><i
                                                class="icon-folder"></i>
                                    </a>';
                $filename = $this->upload->data()['file_name'];
                $this->customers->adddocument($title, $filename,$cid,$baslangic_date_,$bitis_date_);
            }

            $this->load->view('customers/adddocument', $data);
        } else {


            $this->load->view('customers/adddocument', $data);


        }
        $this->load->view('fixed/footer');


    }


    public function delete_document()
    {
        $id = $this->input->post('deleteid');
        $cid = $this->session->userdata('cid');

        if ($this->customers->deletedocument($id,$cid)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function ekstre_musteri()
    {
        if (!$this->aauth->premission(3)->read) {
            exit('<h3>Üzgünüm. Yetkiniz bulunmamaktadır!</h3>');
        }
        $cid = $this->input->post('cid');
        $proje_id = $this->input->post('proje_id');
        $kdv_durum = $this->input->post('kdv_durum');
        $tid = $this->input->post('tyd');
        $tahvil = $this->input->post('tahvil_durum');
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));

        $list=$this->db->query('SELECT *
From `geopos_cari_hesap`
WHERE ana_cari_id='.$cid.'  ORDER BY dates ASC')->result();

        //echo "<pre>";print_r($list);die();


        $data = array();
        $no = $this->input->post('start');
        $bakiye=0;
        $alacak_toplam=0;
        $borc_toplam=0;
        $total=0;
        $borc_a=0;
        $kdv=0;
        $alacak=0;
        $kdv_str=0;

        foreach ($list as $invoices) {

            $carpim=1;
            $ana_para=0;
            $no++;
            $row = array();

            if($invoices->tip==40) // borç
            {
                if($invoices->islem_tipi==2 ) // ANA PARA BORÇ
                {
                    $borc_a=$invoices->tutar;
                    $kdv_str=0;
                    $kdv=0;
                }

                if($invoices->islem_tipi==3) // KDV PARA BORÇ
                {
                    $borc_a=0;
                    $kdv=$invoices->hesaplanan_tutar;
                    $kdv_str=$invoices->tutar;

                }

                $orans=$invoices->oran;
                $alacak=0;
                $ana_para=$kdv+$borc_a;
            }
            else if($invoices->tip==39) //alacak
            {
                $alacak=$invoices->tutar;
                $borc_a=0;
                $kdv=0;
                $orans='';
                $kdv_str=0;

            }


            $firma=customer_details($invoices->cari_id)['company'];
            $date=$invoices->dates;







            $bakiye+=($ana_para)-$alacak;


            $row[] = $date;
            $row[] = $firma;
            $row[] = amountFormat($borc_a);
            $row[] = amountFormat($kdv_str);
            $row[] = $orans;
            $row[] = amountFormat($kdv);
            $row[] = amountFormat($alacak);;

            $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");
            $data[] = $row;









        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->inv_count_all($cid),
            "recordsFiltered" => $this->customers->inv_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function liste_forma2()
    {

        if (!$this->aauth->premission(3)->read) {
            exit('<h3>Üzgünüm. Yetkiniz bulunmamaktadır!</h3>');
        }
        $cid = $this->input->post('cid');
        $proje_id = $this->input->post('proje_id');
        $kdv_durum = $this->input->post('kdv_durum');
        $tid = $this->input->post('tyd');
        $tahvil = $this->input->post('tahvil_durum');
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));

        if(!$this->input->post('para_birimi')!='tumu')
        {
            $list = $this->customers->customer_ekstre_datatables_forma2_liste($cid, $tid,$para_birimi,$kdv_durum,$proje_id,$tahvil);
        }
        else {
            $list = $this->customers->customer_ekstre_datatables_forma2_liste($cid, $tid,$this->input->post('para_birimi'),$kdv_durum,$proje_id,$tahvil);
        }

        //echo "<pre>";print_r($list);die();


        $data = array();
        $no = $this->input->post('start');
        $bakiye=0;
        $alacak_toplam=0;
        $borc_toplam=0;
        $total=0;

        foreach ($list as $invoices) {
            if($invoices->fatura_durumu_s!=3)
            {
                if($this->input->post('para_birimi')!='tumu')
                {
                    $carpim=1;
                }
                else
                {
                    $carpim=$invoices->kur_degeri;
                }
                $no++;
                $row = array();


                if($invoices->type_id==1 || $invoices->type_id==2  )
                {
                    $borc=$invoices->borc_sub*$carpim;
                    $alacak=$invoices->alacak_sub*$carpim;
                    $total=$invoices->subtotal;
                }
                else if ($invoices->type_id==19 || $invoices->type_id==20)
                {
                    $borc=$invoices->kdv_borc*$carpim;
                    $alacak=$invoices->kdv_alacak*$carpim;
                    $total=$invoices->subtotal;
                }
                else
                {
                    $borc=$invoices->borc*$carpim;
                    $alacak=$invoices->alacak*$carpim;
                    $total=$invoices->total;
                }

                $style='';
                if($invoices->stok_guncelle == 0 )
                {
                    $style="background-color: red;color: white;";
                }


                if ($invoices->transactions == 'expense') {

                    $alacak_toplam += $total*$carpim;
                } elseif ($invoices->transactions == 'income') {
                    $borc_toplam += $total*$carpim;
                }
                $bakiye += ($borc-$alacak);

                $proje_name=proje_name($invoices->proje_id);

                $row[] = dateformat($invoices->invoicedate);
                $row[] = $invoices->description;
                $row[] = $proje_name;
                $row[] = $invoices->invoice_no;
                $row[] = account_type_sorgu($invoices->odeme_tipi);
                $row[] = amountFormat($borc,$para_birimi);
                $row[] = amountFormat($alacak,$para_birimi);

                $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");
                $row[]=$style;
                $data[] = $row;
            }

        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->inv_count_all($cid),
            "recordsFiltered" => $this->customers->inv_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ekstre_forma2()
    {

        if (!$this->aauth->premission(3)->read) {
            exit('<h3>Üzgünüm. Yetkiniz bulunmamaktadır!</h3>');
        }
        $cid = $this->input->post('cid');
        $proje_id = $this->input->post('proje_id');
        $kdv_durum = $this->input->post('kdv_durum');
        $tid = $this->input->post('tyd');
        $tahvil = $this->input->post('tahvil_durum');
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));

        if(!$this->input->post('para_birimi')!='tumu')
        {
            $list = $this->customers->customer_ekstre_datatables_forma2($cid, $tid,$para_birimi,$kdv_durum,$proje_id,$tahvil);
        }
        else {
            $list = $this->customers->customer_ekstre_datatables_forma2($cid, $tid,$this->input->post('para_birimi'),$kdv_durum,$proje_id,$tahvil);
        }


        // echo "<pre>";print_r($list);die();


        $data = array();
        $no = $this->input->post('start');
        $bakiye=0;
        $alacak_toplam=0;
        $borc_toplam=0;
        $total=0;


        foreach ($list as $invoices) {
            if($invoices['fatura_durumu_s']!=3)
            {


                $kur_degeri=para_birimi_id($invoices['para_birimi'])['rate'];
                $carpim=floatval($kur_degeri);





                $no++;
                $row = array();


                if($invoices['type_id']==1 || $invoices['type_id']==2  )
                {
                    $borc=$invoices['borc_sub']*$carpim;
                    $alacak=$invoices['borc_sub']*$carpim;
                    $total=$invoices['total']*$carpim;
                }
                else if ($invoices['type_id']==19 || $invoices['type_id']==20)
                {
                    $borc=$invoices['kdv_borc']*$carpim;
                    $alacak=$invoices['kdv_alacak']*$carpim;
                    $total=$invoices['total']*$carpim;
                }
                else
                {
                    $borc=$invoices['borc']*$carpim;
                    $alacak=$invoices['alacak']*$carpim;
                    $total=$invoices['total']*$carpim;
                }

                $style='';
                if($invoices['stok_guncelle'] == 0 )
                {
                    $style="background-color: red;color: white;";
                }


                if ($invoices['transactions'] == 'expense')
                {
                    $alacak_toplam += $total*$carpim;
                } elseif ($invoices['transactions'] == 'income') {
                    $borc_toplam += $total*$carpim;
                }

                $oran_=$invoices['oran'];


                $string='';
//
//                if($invoices->type_id==29 || $invoices->type_id==30)
//                {
//
//                    //  $string = $invoices->invoice_no.' Nolu Avans Sonrası Hakediş Bedeli';
//                    //                        $borc=$borc-($borc*($oran_/100));
//                    //                        $alacak=$alacak-($alacak*($oran_/100));
//                    //
//                    //                        $bakiye += ($borc-$alacak);
//
//
//                    if($oran_==0)
//                    {
//                        $oran_=100;
//                    }
//                    $string = $invoices->invoice_no.' Nolu Avans Sonrası Hakediş Bedeli';
//                    $borc=$borc*($oran_/100);
//                    $alacak=$alacak*($oran_/100);
//
//
//                }

                $bakiye += ($borc-$alacak);


                $proje_name=proje_name($invoices['proje_id']);

                $firma=$invoices['csd'];

                $row[] = customer_details($firma)['company'];
                $row[] = dateformat($invoices['invoicedate']);
                $row[] = $invoices['description'];
                $row[] = $proje_name;
                $row[] = $invoices['invoice_no'].'-'.$string;
                $row[] = account_type_sorgu($invoices['odeme_tipi']);
                $row[] = amountFormat($borc,$para_birimi);
                $row[] = amountFormat($alacak,$para_birimi);

                $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");
                $row[]=$style;
                $data[] = $row;
            }

        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->inv_count_all($cid),
            "recordsFiltered" => $this->customers->inv_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function ekstre_avans()
    {

        if (!$this->aauth->premission(3)->read) {
            exit('<h3>Üzgünüm. Yetkiniz bulunmamaktadır!</h3>');
        }
        $cid = $this->input->post('cid');
        $proje_id = $this->input->post('proje_id');
        $kdv_durum = $this->input->post('kdv_durum');
        $tid = $this->input->post('tyd');
        $tahvil = $this->input->post('tahvil_durum');
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));

        if(!$this->input->post('para_birimi')!='tumu')
        {
            $list = $this->customers->customer_ekstre_datatables_avans($cid, $tid,$para_birimi,$kdv_durum,$proje_id,$tahvil);
        }
        else {
            $list = $this->customers->customer_ekstre_datatables_avans($cid, $tid,$this->input->post('para_birimi'),$kdv_durum,$proje_id,$tahvil);
        }

        //echo "<pre>";print_r($list);die();


        $data = array();
        $no = $this->input->post('start');
        $bakiye=0;
        $alacak_toplam=0;
        $borc_toplam=0;
        $total=0;

        foreach ($list as $invoices) {
            if($invoices->fatura_durumu_s!=3)
            {
                if($invoices->type_id!=29 && $invoices->type_id!=30)
                {


                    if($this->input->post('para_birimi')!='tumu')
                    {
                        $carpim=1;
                    }
                    else
                    {
                        $carpim=$invoices->kur_degeri;
                    }
                    $no++;
                    $row = array();

                    $oran_=$invoices->oran;

                    if($invoices->type_id==1 || $invoices->type_id==2  )
                    {
                        $borc=$invoices->borc_sub*$carpim;
                        $alacak=$invoices->alacak_sub*$carpim;
                        $total=$invoices->subtotal;
                    }
                    else if ($invoices->type_id==19 || $invoices->type_id==20)
                    {
                        $borc=$invoices->kdv_borc*$carpim;
                        $alacak=$invoices->kdv_alacak*$carpim;
                        $total=$invoices->subtotal;
                    }
                    else
                    {
                        $borc=$invoices->borc*$carpim;
                        $alacak=$invoices->alacak*$carpim;
                        $total=$invoices->total;
                    }

                    $style='';
                    if($invoices->stok_guncelle == 0 )
                    {
                        $style="background-color: red;color: white;";
                    }


                    if ($invoices->transactions == 'expense') {

                        $alacak_toplam += $total*$carpim;
                    } elseif ($invoices->transactions == 'income') {
                        $borc_toplam += $total*$carpim;
                    }


                    $bakiye += (($borc*($oran_/100))-($alacak*($oran_/100)));
                    $string='';
                    if($invoices->type_id==35 || $invoices->type_id==36)
                    {
                        $string = ' %'.round($oran_,2).' Avans Hakedişi';
                    }

                    if($invoices->type_id==29 || $invoices->type_id==30)
                    {
                        $string = ' %'.round($oran_,2).' Hakedişi Avans Kesintisi';
                    }

                    $proje_name=proje_name($invoices->proje_id);
                    $firma=$invoices->csd;

                    $row[] = customer_details($firma)['company'];
                    $row[] = dateformat($invoices->invoicedate);
                    $row[] = $invoices->description;

                    $row[] = $proje_name;
                    $row[] = $invoices->invoice_no.'-'.$string;
                    $row[] = account_type_sorgu($invoices->odeme_tipi);
                    $row[] = amountFormat($borc*($oran_/100),$para_birimi);
                    $row[] = amountFormat($alacak*($oran_/100),$para_birimi);

                    $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");
                    $row[]=$style;
                    $data[] = $row;
                }

            }
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->inv_count_all($cid),
            "recordsFiltered" => $this->customers->inv_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function ekstre_bekleyen_odeme()
    {

        if (!$this->aauth->premission(3)->read) {
            exit('<h3>Üzgünüm. Yetkiniz bulunmamaktadır!</h3>');
        }
        $cid = $this->input->post('cid');
        $proje_id = $this->input->post('proje_id');
        $kdv_durum = $this->input->post('kdv_durum');
        $tid = $this->input->post('tyd');
        $tahvil = $this->input->post('tahvil_durum');
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));

        if(!$this->input->post('para_birimi')!='tumu')
        {
            $list = $this->customers->customer_ekstre_datatables_bekleyen_odeme($cid, $tid,$para_birimi,$kdv_durum,$proje_id,$tahvil);
        }
        else {
            $list = $this->customers->customer_ekstre_datatables_bekleyen_odeme($cid, $tid,$this->input->post('para_birimi'),$kdv_durum,$proje_id,$tahvil);
        }

        //echo "<pre>";print_r($list);die();


        $data = array();
        $no = $this->input->post('start');
        $bakiye=0;
        $alacak_toplam=0;
        $borc_toplam=0;
        $total=0;

        foreach ($list as $invoices) {

            $tip='';
            if($invoices->tip==5){
                $tip ="Avas Talebi";
            }
            elseif($invoices->tip==4){
                $tip='Gider Talbi';

            }




            $no++;
            $row = array();
            $style='';
            $proje_name=proje_name($invoices->proje_id);
            $firma=$cid;
            $row[] = customer_details($firma)['company'];
            $row[] = dateformat($invoices->olusturma_tarihi);
            $row[] =$tip;
            $row[] = $proje_name;
            $row[] = $invoices->talep_no;
            $row[] = amountFormat($invoices->total);
            $row[]=$style;
            $data[] = $row;


        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->inv_count_all($cid),
            "recordsFiltered" => $this->customers->inv_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ekstre_sozlesme()
    {

        if (!$this->aauth->premission(3)->read) {
            exit('<h3>Üzgünüm. Yetkiniz bulunmamaktadır!</h3>');
        }
        $cid = $this->input->post('cid');
        $proje_id = $this->input->post('proje_id');
        $kdv_durum = $this->input->post('kdv_durum');
        $tid = $this->input->post('tyd');
        $tahvil = $this->input->post('tahvil_durum');
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));

        if(!$this->input->post('para_birimi')!='tumu')
        {
            $list = $this->customers->customer_ekstre_datatables_sozlesme($cid, $tid,$para_birimi,$kdv_durum,$proje_id,$tahvil);
        }
        else {
            $list = $this->customers->customer_ekstre_datatables_sozlesme($cid, $tid,$this->input->post('para_birimi'),$kdv_durum,$proje_id,$tahvil);
        }

        //echo "<pre>";print_r($list);die();


        $data = array();
        $no = $this->input->post('start');
        $bakiye=0;
        $alacak_toplam=0;
        $borc_toplam=0;
        $total=0;

        foreach ($list as $invoices) {
            if($invoices->fatura_durumu_s!=3)
            {
                $kur_degeri=para_birimi_id($invoices->para_birimi)['rate'];
                $carpim=floatval($kur_degeri);

                $no++;
                $row = array();


                if($invoices->type_id==1 || $invoices->type_id==2  )
                {
                    $borc=$invoices->borc_sub*$carpim;
                    $alacak=$invoices->alacak_sub*$carpim;
                    $total=$invoices->subtotal*$carpim;
                }
                else if ($invoices->type_id==19 || $invoices->type_id==20)
                {
                    $borc=$invoices->kdv_borc*$carpim;
                    $alacak=$invoices->kdv_alacak*$carpim;
                    $total=$invoices->subtotal*$carpim;
                }
                else
                {
                    $borc=$invoices->borc*$carpim;
                    $alacak=$invoices->alacak*$carpim;
                    $total=$invoices->total*$carpim;
                }

                $style='';
                if($invoices->stok_guncelle == 0 )
                {
                    $style="background-color: red;color: white;";
                }


                if ($invoices->transactions == 'expense') {

                    $alacak_toplam += $total*$carpim;
                } elseif ($invoices->transactions == 'income') {
                    $borc_toplam += $total*$carpim;
                }
                $bakiye += ($borc-$alacak);


                $proje_name=proje_name($invoices->proje_id);
                $firma=$invoices->csd;

                $row[] = customer_details($firma)['company'];
                $row[] = dateformat($invoices->invoicedate);
                $row[] = $invoices->description;
                $row[] = $proje_name;
                $row[] = $invoices->invoice_no;
                $row[] = account_type_sorgu($invoices->odeme_tipi);
                $row[] = amountFormat($borc,$para_birimi);
                $row[] = amountFormat($alacak,$para_birimi);

                $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");
                $row[]=$style;
                $data[] = $row;
            }

        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->inv_count_all($cid),
            "recordsFiltered" => $this->customers->inv_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ekstre()
    {

        if (!$this->aauth->premission(3)->read) {
            exit('<h3>Üzgünüm. Yetkiniz bulunmamaktadır!</h3>');
        }
        $cid = $this->input->post('cid');
        $parent_id = $this->input->post('parent_id');
        $proje_id = $this->input->post('proje_id');
        $kdv_durum = $this->input->post('kdv_durum');
        $forma2_durum = $this->input->post('forma2_durum');
        $tid = $this->input->post('tyd');
        $tahvil = $this->input->post('tahvil_durum');
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));
        $ekstre_tipi = customer_details($cid)['ekstre_tipi'];



        $ekstes=[];

        if(!$this->input->post('para_birimi')!='tumu')
        {
            $lists = $this->customers->customer_ekstre_datatables($cid, $tid,$para_birimi,$kdv_durum,$proje_id,$tahvil,$parent_id,$forma2_durum);

        }
        else {

            $lists = $this->customers->customer_ekstre_datatables($cid, $tid, $this->input->post('para_birimi'), $kdv_durum, $proje_id, $tahvil, $parent_id,$forma2_durum);


        }



        $quers__=[];

        $parent_id_array = customer_parent($cid);
        if($parent_id_array)
        {
            foreach ($parent_id_array as $parent_id){
                if(!$this->input->post('para_birimi')!='tumu')
                {
                    $quers__[] = $this->customers->customer_ekstre_datatables($parent_id, $tid,$para_birimi,$kdv_durum,$proje_id,$tahvil,$forma2_durum);
                }
                else {
                    $quers__[] = $this->customers->customer_ekstre_datatables($parent_id, $tid,$this->input->post('para_birimi'),$kdv_durum,$proje_id,$tahvil,$forma2_durum);
                }
            }
        }

        if(count($quers__)>0){
            if(count($quers__[0])>0)
            {
                $parent_date=[];
                foreach ($quers__ as $value){
                    foreach ($value as $item){
                        $parent_date[]=$item;
                    }
                }
                $ekstes = array_merge($lists,$parent_date);
            }
            else
            {
                $ekstes = $lists;
            }
        }
        else {
            $ekstes = $lists;
        }



        $data = array();
        $no = $this->input->post('start');

        $alacak_toplam=0;
        $borc_toplam=0;
        $total=0;

        $i=0;
        $devir_bakiye=$this->customers->devir_bakiye($cid);
        $bakiye=$devir_bakiye;


        $button_data_toggle='';
        $data_array_new=[];
        $where='';

        if (!empty($_POST['columns'][3]['search']['value'])) //Proje
        {

            $id_search_all_proje = explode('|',$_POST['columns'][3]['search']['value']);


            if(count($id_search_all_proje)>1)
            {
                $array_ids_proje=array();
                foreach ($id_search_all_proje as $id_search)
                {

                    $id_proje=proje_id_ogren($id_search);
                    $array_ids_proje[]=$id_proje;

                }



                $where="and  proje_id IN $array_ids_proje";
            }
            else
            {
                $id_proje=proje_id_ogren($id_search_all_proje[0]);
                $where="and  proje_id = $id_proje";
            }

        }


        $kontrol =  $this->db->query("SELECT transaction_pay.* FROM transaction_pay Where cari_id = $cid $where");
        if($kontrol->num_rows()){
            $total=0;
            $array_details=[];
            foreach ($kontrol->result() as $items_new){



                $avans_detaisl = $this->db->query("SELECT * FROM talep_form_customer Where id=$items_new->avans_id");
                if($avans_detaisl->num_rows()){
                    $details  =  $this->db->query("SELECT * FROM geopos_invoices Where id = $items_new->invoice_id")->row();

                    $total+=$items_new->amount;
                    $data_array_new[]=
                        [
                            'invoicedate'=>$items_new->created_at,
                            'proje_id'=>$items_new->proje_id,
                            'odeme_tipi'=>$items_new->method,
                            'borc'=>$items_new->amount,
                            'total'=>$items_new->amount,
                            'stok_guncelle'=>0,
                            'invoice_no'=>$avans_detaisl->row()->code.' Parçalı Ödeme'.$items_new->id,
                            'inv_id'=>$items_new->avans_id,
                            'alacak'=>0,
                            'csd'=>$cid,
                            'fatura_durumu_s'=>0,
                            'type_id'=>4,
                            'kur_degeri'=>0,
                            'para_birimi'=>1,
                            'type_value'=>'parcali',
                            'transactions'=>'expense',
                            'notes'=>'',
                            'description'=>'MƏXARİC',
                            'end_date_islem'=>$items_new->created_at,
                        ];

                    $array_details[]=$items_new->avans_id;
                }
                else {
                    $islem_details = $this->db->query("SELECT * FROM geopos_invoices Where id=$items_new->invoice_id")->row();
                    $total+=$items_new->amount;
                    $data_array_new[]=
                        [
                            'invoicedate'=>$items_new->created_at,
                            'proje_id'=>$items_new->proje_id,
                            'odeme_tipi'=>$items_new->method,
                            'borc'=>$items_new->amount,
                            'total'=>$items_new->amount,
                            'stok_guncelle'=>0,
                            'invoice_no'=>' Parçalı Ödeme',
                            'inv_id'=>$items_new->avans_id,
                            'alacak'=>0,
                            'csd'=>$cid,
                            'fatura_durumu_s'=>0,
                            'type_id'=>4,
                            'kur_degeri'=>0,
                            'para_birimi'=>1,
                            'type_value'=>'av_notparcali',
                            'transactions'=>'expense',
                            'notes'=>'',
                            'description'=>'MƏXARİC',
                            'end_date_islem'=>$items_new->created_at,
                        ];

                    $array_details[]=$items_new->avans_id;
                }




            }


            $uniq = array_unique($array_details);
            if(count($uniq)){
                foreach ($uniq as $cvla)
                {


                    $form_total=0;
                    $form_total_details=$this->db->query("SELECT SUM(total) as total,talep_form_customer.status FROM talep_form_customer_products
                    INNER JOIN talep_form_customer ON talep_form_customer_products.form_id=talep_form_customer.id Where talep_form_customer_products.form_id=$cvla")->row();
                    if($form_total_details->status==10){
                        $form_total=$this->customeravans->form_total($cvla);
                    }
                    else {
                        $form_total = $this->db->query("SELECT SUM(amount) as total FROM transaction_pay Where avans_id = $cvla")->row()->total;
                    }


                    $total =  $this->db->query("SELECT SUM(amount) as total FROM transaction_pay Where avans_id = $cvla")->row()->total;
                    $kalan = floatval($form_total)-floatval($total);

                    $avans_detaisl = $this->db->query("SELECT * FROM talep_form_customer Where id=$cvla")->row();


                    if($kalan > 0)
                    {
                        $data_array_new[]=
                            [
                                'invoicedate'=>$avans_detaisl->created_at,
                                'proje_id'=>$avans_detaisl->proje_id,
                                'odeme_tipi'=>$avans_detaisl->method,
                                'borc'=>$kalan,
                                'total'=>$kalan,
                                'stok_guncelle'=>0,
                                'invoice_no'=>$avans_detaisl->code.' Parçalı Ödeme (QALIQ)',
                                'inv_id'=>$cvla,
                                'alacak'=>0,
                                'csd'=>$cid,
                                'fatura_durumu_s'=>0,
                                'type_id'=>4,
                                'kur_degeri'=>0,
                                'para_birimi'=>1,
                                'type_value'=>'',
                                'transactions'=>'expense',
                                'notes'=>'',
                                'description'=>'MƏXARİC',
                                'end_date_islem'=>$avans_detaisl->created_at,
                            ];
                    }
                }
            }




        }



        $ekstes_ = array_merge($ekstes,$data_array_new);




        foreach ($ekstes_ as $invoices) {
            $inv_id_=$invoices['inv_id'];

            if($invoices['fatura_durumu_s']!=3)
            {
                if($invoices['type_id']!=55)
                {
                    if($invoices['type_id']==29 || $invoices['type_id']==30){
                        if($invoices['fatura_durumu_s']==18 || $invoices['fatura_durumu_s']==17 || $invoices['fatura_durumu_s']==2) {
//                            if($invoices['odeme_tipi']==1){
                            if($this->input->post('para_birimi')!='tumu')
                            {
                                $carpim=1;
                            }
                            else
                            {
                                $carpim=$invoices['kur_degeri'];
                            }

                            $kur_degeri=para_birimi_id($invoices['para_birimi'])['rate'];
                            $carpim=$kur_degeri;


                            $no++;
                            $row = array();


                            if($invoices['type_id']==1 || $invoices['type_id']==2  )
                            {
                                $borc=$invoices['borc_sub']*$carpim;
                                $alacak=$invoices['alacak_sub']*$carpim;
                                $total=$invoices['subtotal'];
                            }
                            else if ($invoices['type_id']==19 || $invoices['type_id']==20)
                            {
                                $borc=$invoices['kdv_borc']*$carpim;
                                $alacak=$invoices['kdv_alacak']*$carpim;
                                $total=$invoices['subtotal'];
                            }
                            else
                            {
                                $borc=$invoices['borc']*$carpim;
                                $alacak=$invoices['alacak']*$carpim;
                                $total=$invoices['total'];
                            }

                            $style='';
                            if($invoices['stok_guncelle'] == 0 )
                            {
                                $style="background-color: red;color: white;";
                            }


                            if ($invoices['transactions'] == 'expense') {

                                $alacak_toplam += $total*$carpim;
                            } elseif ($invoices['transactions'] == 'income') {
                                $borc_toplam += $total*$carpim;
                            }
                            $bakiye += ($borc-$alacak);

                            $proje_name=proje_name($invoices['proje_id']);


                            $proje_name=proje_name($invoices['proje_id']);
                            if($invoices['type_id']==69){
                                $proje_name = customer_new_projects_details($invoices['proje_id'])->proje_name;
                            }


                            $button=$invoices['invoice_no'];
                            $dsc=$invoices['description'];
                            if($invoices['type_value']=='hizmet'){
                                $button='<a href="/transactions/view?id='.$invoices['inv_id'].'" target="_blank">'.$invoices['invoice_no'].'</a>';
                            }
                            elseif($invoices['type_value']=='fatura'){
                                $button='<a href="/invoices/view?id='.$invoices['inv_id'].'" target="_blank">'.$invoices['invoice_no'].'</a>';
                            }
                            elseif($invoices['type_value']=='tehvil'){
                                $button='<a href="/uretim/tehvilprint/'.$invoices['inv_id'].'" target="_blank">'.$invoices['invoice_no'].'</a>';
                            }
                            elseif($invoices['type_value']=='parcali'){
                                $button='<button style="font-size: 10px;padding: 0px;" avans_id="'.$invoices['inv_id'].'" class="btn btn-info parcali btn-sm">'.$invoices['invoice_no'].'</button>';
                            }
                            elseif($invoices['type_value']=='transaction'){
                                if(isset($invoices['invoice_no'])){
                                    $button='<a href="/transactions/view?id='.$invoices['inv_id'].'" target="_blank">'.$invoices['invoice_no'].'</a>';

                                }
                                else {
                                    $button='<a href="/transactions/view?id='.$invoices['inv_id'].'" target="_blank">Görüntüle</a>';

                                }
                            }
                            elseif($invoices['type_value']=='forma2'){
                                $button='<a href="/formainvoices/view?id='.$invoices['inv_id'].'" target="_blank">'.$invoices['invoice_no'].'</a>';
                            }

                            $firma=$invoices['csd'];

                            $row[] = customer_details($firma)['company'];
                            $row[] = dateformat($invoices['invoicedate']);
                            $row[] = $dsc;
                            $row[] = $proje_name;
                            $row[] = $button;
                            $row[] = account_type_sorgu($invoices['odeme_tipi']);
                            $row[] = amountFormat($borc,$para_birimi);
                            $row[] = amountFormat($alacak,$para_birimi);

                            $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");
                            $row[]=$invoices['notes'];
                            $row[] = $invoices['end_date_islem'];
                            $row[]=$style;
                            $data[] = $row;
//                            }
                        }
                        else {
                            continue;
                        }

                    }
                    elseif($invoices['type_id']==69)
                    {
                        $inv_id = $invoices['inv_id'];
                        $tehvil_kontrol = tehvil_durumu($inv_id);
                        if (!$tehvil_kontrol) {
                            {
                                if ($this->input->post('para_birimi') != 'tumu') {
                                    $carpim = 1;
                                } else {
                                    $carpim = $invoices['kur_degeri'];
                                }

                                $kur_degeri = para_birimi_id($invoices['para_birimi'])['rate'];
                                $carpim = $kur_degeri;


                                $no++;
                                $row = array();


                                if ($invoices['type_id'] == 1 || $invoices['type_id'] == 2) {
                                    $borc = $invoices['borc_sub'] * $carpim;
                                    $alacak = $invoices['alacak_sub'] * $carpim;
                                    $total = $invoices['subtotal'];
                                } else if ($invoices['type_id'] == 19 || $invoices['type_id'] == 20) {
                                    $borc = $invoices['kdv_borc'] * $carpim;
                                    $alacak = $invoices['kdv_alacak'] * $carpim;
                                    $total = $invoices['subtotal'];
                                } else {
                                    $borc = $invoices['borc'] * $carpim;
                                    $alacak = $invoices['alacak'] * $carpim;
                                    $total = $invoices['total'];
                                }

                                $style = '';
                                if ($invoices['stok_guncelle'] == 0) {
                                    $style = "background-color: red;color: white;";
                                }


                                if ($invoices['transactions'] == 'expense') {

                                    $alacak_toplam += $total * $carpim;
                                } elseif ($invoices['transactions'] == 'income') {
                                    $borc_toplam += $total * $carpim;
                                }
                                $bakiye += ($borc - $alacak);

                                $proje_name = proje_name($invoices['proje_id']);
                                if ($invoices['type_id'] == 69) {
                                    $proje_name = customer_new_projects_details($invoices['proje_id'])->proje_name;
                                }


                                $button = $invoices['invoice_no'];
                                $dsc = $invoices['description'];
                                if ($invoices['type_value'] == 'hizmet') {
                                    $button = '<a href="/transactions/view?id=' . $invoices['inv_id'] . '" target="_blank">' . $invoices['invoice_no'] . '</a>';
                                } elseif ($invoices['type_value'] == 'fatura') {
                                    $button = '<a href="/invoices/view?id=' . $invoices['inv_id'] . '" target="_blank">' . $invoices['invoice_no'] . '</a>';
                                } elseif ($invoices['type_value'] == 'tehvil') {
                                    $button = '<a href="/uretim/tehvilprint/' . $invoices['inv_id'] . '" target="_blank">' . $invoices['invoice_no'] . '</a>';
                                } elseif ($invoices['type_value'] == 'transaction') {
                                    if (isset($invoices['invoice_no'])) {
                                        $button = '<a href="/transactions/view?id=' . $invoices['inv_id'] . '" target="_blank">' . $invoices['invoice_no'] . '</a>';

                                    } else {
                                        $button = '<a href="/transactions/view?id=' . $invoices['inv_id'] . '" target="_blank">Görüntüle</a>';

                                    }
                                } elseif ($invoices['type_value'] == 'forma2') {
                                    $button = '<a href="/formainvoices/view?id=' . $invoices['inv_id'] . '" target="_blank">' . $invoices['invoice_no'] . '</a>';
                                }


                                $firma = $invoices['csd'];

                                $row[] = customer_details($firma)['company'];
                                $row[] = dateformat($invoices['invoicedate']);
                                $row[] = $dsc;
                                $row[] = $proje_name;
                                $row[] = $button;
                                $row[] = account_type_sorgu($invoices['odeme_tipi']);
                                $row[] = amountFormat($borc, $para_birimi);
                                $row[] = amountFormat($alacak, $para_birimi);

                                $row[] = amountFormat(abs($bakiye), $para_birimi) . ($bakiye > 0 ? " (B)" : " (A)");
                                $row[] = $invoices['notes'];
                                $row[] = $invoices['end_date_islem'];
                                $row[] = $style;
                                $data[] = $row;
                            }
                        }

                    }
                    else
                    {
                        $inv_id = $invoices['inv_id'];
                        $forma_2_kontorl =forma_2_kontrol($inv_id);
                        if($forma2_durum==1 || $forma2_durum==''){
                            if($forma_2_kontorl){
                                if($this->input->post('para_birimi')!='tumu')
                                {
                                    $carpim=1;
                                }
                                else
                                {
                                    $carpim=$invoices['kur_degeri'];
                                }

                                $kur_degeri=para_birimi_id($invoices['para_birimi'])['rate'];
                                $carpim=$kur_degeri;


                                $no++;
                                $row = array();


                                if($invoices['type_id']==1 || $invoices['type_id']==2  )
                                {
                                    $borc=$invoices['borc_sub']*$carpim;
                                    $alacak=$invoices['alacak_sub']*$carpim;
                                    $total=$invoices['subtotal'];
                                }
                                else if ($invoices['type_id']==19 || $invoices['type_id']==20)
                                {
                                    $borc=$invoices['kdv_borc']*$carpim;
                                    $alacak=$invoices['kdv_alacak']*$carpim;
                                    $total=$invoices['subtotal'];
                                }
                                else
                                {
                                    $borc=$invoices['borc']*$carpim;
                                    $alacak=$invoices['alacak']*$carpim;
                                    $total=$invoices['total'];
                                }

                                $style='';
                                if($invoices['stok_guncelle'] == 0 )
                                {
                                    $style="background-color: red;color: white;";
                                }


                                $kontrol =  $this->db->query("SELECT transaction_pay.* FROM transaction_pay Where invoice_id = $inv_id_ and (avans_id!=0 or forma2_id!=0)");
                                if(!$kontrol->num_rows()){
                                    if ($invoices['transactions'] == 'expense') {
                                        $alacak_toplam += $total*$carpim;
                                    } elseif ($invoices['transactions'] == 'income') {
                                        $borc_toplam += $total*$carpim;
                                    }
                                    $bakiye += ($borc-$alacak);
                                }







                                $proje_name=proje_name($invoices['proje_id']);
                                if($invoices['type_id']==69){
                                    $proje_name = customer_new_projects_details($invoices['proje_id'])->proje_name;
                                }


                                $button=$invoices['invoice_no'];
                                $dsc=$invoices['description'];
                                if($invoices['type_value']=='hizmet'){
                                    $button='<a href="/transactions/view?id='.$invoices['inv_id'].'" target="_blank">'.$invoices['invoice_no'].'</a>';
                                }
                                elseif($invoices['type_value']=='fatura'){
                                    $button='<a href="/invoices/view?id='.$invoices['inv_id'].'" target="_blank">'.$invoices['invoice_no'].'</a>';
                                }
                                elseif($invoices['type_value']=='tehvil'){
                                    $button='<a href="/uretim/tehvilprint/'.$invoices['inv_id'].'" target="_blank">'.$invoices['invoice_no'].'</a>';
                                }
                                elseif($invoices['type_value']=='parcali'){
                                    $button='<button style="font-size: 10px;padding: 0px;"  avans_id="'.$invoices['inv_id'].'" class="btn btn-info parcali btn-sm">'.$invoices['invoice_no'].'</button>';
                                }
                                elseif($invoices['type_value']=='transaction'){
                                    if(isset($invoices['invoice_no'])){
                                        $button='<a href="/transactions/view?id='.$invoices['inv_id'].'" target="_blank">'.$invoices['invoice_no'].'</a>';

                                    }
                                    else {
                                        $button='<a href="/transactions/view?id='.$invoices['inv_id'].'" target="_blank">Görüntüle</a>';

                                    }
                                }
                                elseif($invoices['type_value']=='forma2'){
                                    $button='<a href="/formainvoices/view?id='.$invoices['inv_id'].'" target="_blank">'.$invoices['invoice_no'].'</a>';
                                }



                                $firma=$invoices['csd'];

                                $button_data_toggle='';
                                $kontrol =  $this->db->query("SELECT transaction_pay.* FROM transaction_pay Where invoice_id = $inv_id_ and (avans_id!=0 or forma2_id!=0)");
                                if($kontrol->num_rows()){



                                }
                                else {
                                    $row[] = customer_details($firma)['company'];
                                    $row[] = dateformat($invoices['invoicedate']);
                                    $row[] = $dsc;
                                    $row[] = $proje_name;
                                    $row[] = $button;
                                    $row[] = account_type_sorgu($invoices['odeme_tipi']);
                                    $row[] = amountFormat($borc,$para_birimi);
                                    $row[] = amountFormat($alacak,$para_birimi);

                                    $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");
                                    $row[]=$invoices['notes'];
                                    $row[] = $invoices['end_date_islem'];
                                    $row[]=$style;
                                    $data[] = $row;

                                }


                            }
                        }
                        elseif($forma2_durum==2) {
                            if($this->input->post('para_birimi')!='tumu')
                            {
                                $carpim=1;
                            }
                            else
                            {
                                $carpim=$invoices['kur_degeri'];
                            }

                            $kur_degeri=para_birimi_id($invoices['para_birimi'])['rate'];
                            $carpim=$kur_degeri;


                            $no++;
                            $row = array();


                            if($invoices['type_id']==1 || $invoices['type_id']==2  )
                            {
                                $borc=$invoices['borc_sub']*$carpim;
                                $alacak=$invoices['alacak_sub']*$carpim;
                                $total=$invoices['subtotal'];
                            }
                            else if ($invoices['type_id']==19 || $invoices['type_id']==20)
                            {
                                $borc=$invoices['kdv_borc']*$carpim;
                                $alacak=$invoices['kdv_alacak']*$carpim;
                                $total=$invoices['subtotal'];
                            }
                            else
                            {
                                $borc=$invoices['borc']*$carpim;
                                $alacak=$invoices['alacak']*$carpim;
                                $total=$invoices['total'];
                            }

                            $style='';
                            if($invoices['stok_guncelle'] == 0 )
                            {
                                $style="background-color: red;color: white;";
                            }


                            if ($invoices['transactions'] == 'expense') {

                                $alacak_toplam += $total*$carpim;
                            } elseif ($invoices['transactions'] == 'income') {
                                $borc_toplam += $total*$carpim;
                            }
                            $bakiye += ($borc-$alacak);

                            $proje_name=proje_name($invoices['proje_id']);
                            if($invoices['type_id']==69){
                                $proje_name = customer_new_projects_details($invoices['proje_id'])->proje_name;
                            }


                            $button=$invoices['invoice_no'];
                            $dsc=$invoices['description'];
                            if($invoices['type_value']=='hizmet'){
                                $button='<a href="/transactions/view?id='.$invoices['inv_id'].'" target="_blank">'.$invoices['invoice_no'].'</a>';
                            }
                            elseif($invoices['type_value']=='fatura'){
                                $button='<a href="/invoices/view?id='.$invoices['inv_id'].'" target="_blank">'.$invoices['invoice_no'].'</a>';
                            }
                            elseif($invoices['type_value']=='tehvil'){
                                $button='<a href="/uretim/tehvilprint/'.$invoices['inv_id'].'" target="_blank">'.$invoices['invoice_no'].'</a>';
                            }
                            elseif($invoices['type_value']=='parcali'){
                                $button='<button style="font-size: 10px;padding: 0px;"  avans_id="'.$invoices['inv_id'].'" class="btn btn-info parcali btn-sm">'.$invoices['invoice_no'].'</button>';
                            }
                            elseif($invoices['type_value']=='transaction'){
                                if(isset($invoices['invoice_no'])){
                                    $button='<a href="/transactions/view?id='.$invoices['inv_id'].'" target="_blank">'.$invoices['invoice_no'].'</a>';

                                }
                                else {
                                    $button='<a href="/transactions/view?id='.$invoices['inv_id'].'" target="_blank">Görüntüle</a>';

                                }
                            }
                            elseif($invoices['type_value']=='forma2'){
                                $button='<a href="/formainvoices/view?id='.$invoices['inv_id'].'" target="_blank">'.$invoices['invoice_no'].'</a>';
                            }

                            $firma=$invoices['csd'];

                            $row[] = customer_details($firma)['company'];
                            $row[] = dateformat($invoices['invoicedate']);
                            $row[] = $dsc;
                            $row[] = $proje_name;
                            $row[] = $button;
                            $row[] = account_type_sorgu($invoices['odeme_tipi']);
                            $row[] = amountFormat($borc,$para_birimi);
                            $row[] = amountFormat($alacak,$para_birimi);
                            $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");
                            $row[]=$invoices['notes'];
                            $row[] = $invoices['end_date_islem'];
                            $row[]=$style;
                            $data[] = $row;
                        }


                    }
                }


            }

        }
        $output = array(
            "bakiye" => amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)"),
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->inv_count_all($cid),
            "recordsFiltered" => $this->customers->inv_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function siparis_ekstre_data()
    {

        if (!$this->aauth->premission(3)->read) {
            exit('<h3>Üzgünüm. Yetkiniz bulunmamaktadır!</h3>');
        }
        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));

        if(!$this->input->post('para_birimi')!='tumu')
        {
            $list = $this->customers->customer_siparis_datatables($cid, $tid,$para_birimi);
        }
        else {
            $list = $this->customers->customer_siparis_datatables($cid, $tid,$this->input->post('para_birimi'));
        }


        $data = array();
        $no = $this->input->post('start');
        $bakiye=0;
        $alacak_toplam=0;
        $borc_toplam=0;

        foreach ($list as $invoices) {
            if($this->input->post('para_birimi')!='tumu')
            {
                $carpim=1;
            }
            else
            {
                $carpim=$invoices['kur_degeri'];
            }
            $no++;
            $row = array();
            $borc=$invoices['borc']*$carpim;
            $alacak=$invoices['alacak']*$carpim;


            if ($invoices['transactions'] == 'expense') {
                $alacak_toplam += $invoices['total']*$carpim;
            } elseif ($invoices['transactions'] == 'income') {
                $borc_toplam += $invoices['total']*$carpim;
            }
            $bakiye += ($borc-$alacak);

            $row[] = dateformat($invoices['invoicedate']);
            $row[] = $invoices['description'];
            $row[] = account_type_sorgu($invoices['odeme_tipi']);
            $row[] = amountFormat($borc,$para_birimi);
            $row[] = amountFormat($alacak,$para_birimi);

            $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->inv_count_all($cid),
            "recordsFiltered" => $this->customers->inv_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function fatura_kdv_raporu()
    {
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));

        $data['id'] = $this->input->get('id');
        $data['para_birimi'] = $para_birimi;
        $this->load->model('transactions_model');
        $data['details'] = $this->customers->details($data['id']);
        $head['title'] = "Fatura KDV Raporu";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/customer_kdv', $data);
        $this->load->view('fixed/footer');

    }

    public function customer_bank_edit()
    {
        $hesap_numarasi = $this->input->post('hesap_numarasi');
        $banka = $this->input->post('banka');
        $iden_numarasi = $this->input->post('iden_numarasi');
        $banka_unvan = $this->input->post('banka_unvan');
        $banka_tel = $this->input->post('banka_tel');
        $banka_fax = $this->input->post('banka_fax');
        $kod = $this->input->post('kod');
        $swift = $this->input->post('swift');
        $banka_voen = $this->input->post('banka_voen');
        $muh_hesab = $this->input->post('muh_hesab');
        $para_birimi = $this->input->post('para_birimi');
        $id = $this->input->post('id_bank_edit');

        $data = array(
            'hesap_numarasi'  => $hesap_numarasi,
            'banka'     => $banka,
            'iden_numarasi' =>$iden_numarasi,
            'banka_unvan' =>$banka_unvan,
            'banka_tel' =>$banka_tel,
            'banka_fax' =>$banka_fax,
            'kod' =>$kod,
            'swift_kodu' =>$swift,
            'bank_voen' =>$banka_voen,
            'muhbir_hesab' =>$muh_hesab,
            'para_birimi' =>$para_birimi
        );

        $this->db->set($data);

        $this->db->where('id', $id);

        $this->db->update('geopos_customer_bank');


    }

    public function customer_invoice_edit()
    {
        $unvan_invoice = $this->input->post('unvan_invoice');
        $country_invoice = $this->input->post('country_invoice');
        $sehir_invoice = $this->input->post('sehir_invoice');
        $city_invoice = $this->input->post('city_invoice');
        $post_invoice = $this->input->post('post_invoice');
        $adres_invoice = $this->input->post('adres_invoice');
        $phone_invoice = $this->input->post('phone_invoice');
        $email_invoice = $this->input->post('email_invoice');
        $id = $this->input->post('id_invoice_edit');

        $data= array(
            'unvan_invoice'  => $unvan_invoice,
            'country_invoice'     => $country_invoice,
            'sehir_invoice' =>$sehir_invoice,
            'city_invoice' =>$city_invoice,
            'post_invoice' =>$post_invoice,
            'adres_invoice' =>$adres_invoice,
            'phone_invoice' =>$phone_invoice,
            'email_invoice' =>$email_invoice
        );

        $this->db->set($data);

        $this->db->where('id', $id);

        $this->db->update('geopos_customer_iadress');


    }

    public function customer_teslimat_edit()
    {
        $unvan_teslimat = $this->input->post('unvan_teslimat');
        $country_teslimat = $this->input->post('country_teslimat');
        $sehir_teslimat = $this->input->post('sehir_teslimat');
        $city_teslimat = $this->input->post('city_teslimat');
        $post_teslimat = $this->input->post('post_teslimat');
        $adres_teslimat = $this->input->post('adres_teslimat');
        $phone_teslimat = $this->input->post('phone_teslimat');
        $email_teslimat = $this->input->post('email_teslimat');
        $id = $this->input->post('id_teslimat');

        $data = array(
            'unvan_teslimat'  => $unvan_teslimat,
            'country_teslimat'     => $country_teslimat,
            'sehir_teslimat' =>$sehir_teslimat,
            'city_teslimat' =>$city_teslimat,
            'post_teslimat' =>$post_teslimat,
            'adres_teslimat' =>$adres_teslimat,
            'phone_teslimat' =>$phone_teslimat,
            'email_teslimat' =>$email_teslimat
        );

        $this->db->set($data);

        $this->db->where('id', $id);

        $this->db->update('geopos_customer_tadress');


    }
    public function cari_alacaklandir_borclandir()
    {
        $cari_id=$this->input->post("cari_id");
        $metod=$this->input->post("alacak_metod");
        $not=$this->input->post("alacak_not");
        $tarix=$this->input->post("tarix");

        $alacak_tutar=$this->input->post("alacak_tutar");
        $alacakak_borc=$this->input->post("alacakak_borc");
        $proje_id_alacak=$this->input->post("proje_id_alacak");

        $data = array(

            'csd' => $cari_id,

            'payer' => customer_details($cari_id)['company'],

            'acid' => 0, //hesapID ekleneck

            'account' => '', //hesap adı ekelenecek

            'invoicedate' => $tarix,

            'invoiceduedate' => $tarix,

            'debit' => 0, // eklenecek

            'credit' => 0, //eklenecek

            'total' => $alacak_tutar,

            //'type' => $pay_type, // income expense
            'invoice_type_id'=>$alacakak_borc,

            'invoice_type_desc'=>invoice_type_desc($alacakak_borc),

            //'cat' => $pay_cat,

            'method' => $metod, //ödeme metodu ekelenecek

            'eid' => $this->aauth->get_user()->id, //user_id

            'notes' => $not,
            'proje_id' => $proje_id_alacak,

            // 'ext'=>$ty, //müşterimi tedarikçimi gerek yok

            'loc' => $this->aauth->get_user()->loc

        );

        $this->db->insert('geopos_invoices', $data);

        echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla İşlendi'));

    }

    public function forma2_report($cari_id){

        $head['usernm'] = $this->aauth->get_user()->username;
        $data['forma2'] =$this->db->query("SELECT * FROM `geopos_invoices` WHERE `csd` = $cari_id AND `invoice_type_id` IN (29,30) and proje_id=82")->result();
        $data['bank'] =$this->db->query("SELECT * FROM `geopos_invoices` WHERE `csd` = $cari_id AND `invoice_type_id` IN (4,14,17,43,45) and proje_id=82 and method=3")->result();
        $data['nakit'] =$this->db->query("SELECT * FROM `geopos_invoices` WHERE `csd` = $cari_id AND `invoice_type_id` IN (4,14,17,43,45) and proje_id=82 and method=1")->result();
        $data['proje'] =proje_name(82);
        $head['title'] = 'Forma2 Rapor';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/forma2_report',$data);
        $this->load->view('fixed/footer');
    }

    public function customer_details(){
        $cari_id = $this->input->post('cari_id');

        $cari_details = $this->db->query("SELECT * FROM geopos_customers Where id =$cari_id")->row();
        $cari_info = $this->db->query("SELECT * FROM customer_info Where customer_id =$cari_id")->row();

        echo json_encode(array('status' => 'Success', 'cari_details' =>$cari_details,'cari_info'=>$cari_info));

    }

    public function customer_pay_list(){
        if (!$this->aauth->premission(3)->read) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));
            exit();

        }
        else {
            $data=[];
            $customer_id = $this->input->post('customer_id');
            $pay_details = $this->db->query("SELECT * FROM `geopos_invoices` WHERE csd = $customer_id and invoice_type_id IN (4,14,17,43,45,54,55,57,61) and method IN(1,3)");
            if($pay_details->num_rows()>0){
                foreach ($pay_details->result() as $value){
                    $transaction_details = $this->db->query("SELECT * FROM `geopos_invoice_transactions` WHERE `transaction_id` = $value->id ORDER BY `id` DESC");
                    if($transaction_details->num_rows()){
                        if(!$transaction_details->row()->invoice_id){
                            $data[]=['id'=>$value->id,'tip'=>$value->invoice_type_desc,'amount'=>amountFormat($value->total),'total'=>$value->total,'notes'=>$value->notes,'date'=>$value->invoicedate];
                        }
                    }

                }
            }
            $protokols=[];
            $protokol=$this->db->query("SELECT * FROM  cari_razilastirma WHERE razi_status=1 and deleted_at is Null and cari_id = $customer_id");
            if($protokol->num_rows()){
                $protokols=$protokol->result_array();
            }
            echo json_encode(array(
                'status' => 200,
                'data' =>$data,
                'count'=>count($data),
                'cari_protokol'=>$protokols
            ));
        }

    }



    public function teslimat_details(){
        $customer_id = $this->input->post('cari_id');
        $teslimat_details = customer_teslimat_adresleri($customer_id);
        $proje_details = customers_project_details($customer_id);

        if($teslimat_details || $proje_details){
            echo json_encode(array(
                'status' => 200,
                'teslimat_details' =>$teslimat_details,
                'proje_details' =>$proje_details
            ));
        }
        else {
            echo json_encode(array(
                'status' => 410,
                'messages' =>'Teslimat Adresleri ve Projeler Tanımlanmamış',
            ));
        }

    }

    public function delete_project(){
        $this->db->trans_start();
        $id = $this->input->post('id');
        $details  = $this->db->query("SELECT * FROM customers_project Where id = $id")->row();
        if($this->db->delete('customers_project', array('id' => $id))){
            $this->aauth->applog("Cariden Proje Silindi  : Proje Name : ".$details->proje_name, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('code' => 200,'message'=>'Başarıyla Silindi'));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('code' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun.".' Hata '));
        }
    }

    public function akt_yok_update()
    {
        $this->db->trans_start();
        $cari_id = $this->input->post('cari_id');
        $desc = $this->input->post('desc');
        $types = $this->input->post('types');
        $yoklama_status=0;
        $akt_status=0;

        if($types==1){
            $yoklama_status = 1;
            $akt_status = 0;
        }
        else {
            $yoklama_status = 0;
            $akt_status = 1;
        }

        $data = array(
            'cari_id' => $cari_id,
            'pers_id'=>$this->aauth->get_user()->id,
            'yoklama_status'=>$yoklama_status,
            'akt_status'=>$akt_status,
            'desc'=>$desc,
            'type'=>$types,

        );
        if($this->db->insert('cari_yoklama', $data)){
            $this->aauth->applog("Cariye Durum Bildirildi : ".$cari_id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 200,'message'=>'Başarıyla Dosya Eklendi'));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));

        }
    }

    public function translist_update()
    {
        $data=[];
        $data_olmaya=[];
        $lisst = $this->db->query('select id,invoice_id,forma2_id,aauth_id,amount,method,cari_id,proje_id FROM transaction_pay');
        if($lisst->num_rows()){
            foreach ($lisst->result() as $items){
                if(floatval($items->amount)>0){
                    if(intval($items->forma2_id)){
                        $invoices_kontrol = $this->db->query("SELECT * FROM geopos_invoices Where id =$items->invoice_id");
                        if($invoices_kontrol->num_rows()){
                            $data[]=[
                                'invoice_id'=>$items->invoice_id,
                                'forma2_id'=>$items->forma2_id,
                                'aauth_id'=>$items->aauth_id,
                                'amount'=>$items->amount,
                                'proje_id'=>$items->proje_id,
                                'method'=>$invoices_kontrol->row()->method,
                                'cari_id'=>$items->cari_id,
                                'transaction_pay_id'=>$items->id,
                                'acid'=>$invoices_kontrol->row()->acid,
                                'para_birimi'=>$invoices_kontrol->row()->para_birimi,
                                'account'=>$invoices_kontrol->row()->account
                            ];
                        }
                        else {
                            $data_olmaya[]=[
                                'invoice_id'=>$items->invoice_id,
                                'forma2_id'=>$items->forma2_id,
                                'aauth_id'=>$items->aauth_id,
                                'amount'=>$items->amount,
                                'method'=>$items->method,
                                'cari_id'=>$items->cari_id,
                                'transaction_pay_id'=>$items->id,
                            ];
                        }

                    }
                }
            }
        }

        $update=0;

        if($data)
        {
            foreach ($data as $value){
                $data_parcalis = array(
                    'code'=>numaric(51),
                    'total'=>$value['amount'],
                    'notes'=>'Avans Parçalı',
                    'eid' => $value['aauth_id'],
                    'csd' => $value['cari_id'],
                    'loc' => 5,
                    'invoice_type_id'=>76,
                    'invoice_type_desc'=>invoice_type_id(76),
                    'payer'=>customer_details($value['cari_id'])['company'],
                    'acid'=>$value['acid'],
                    'account'=>$value['account'],
                    'method'=>$value['method'],
                    'para_birimi'=>$value['para_birimi'],
                    'proje_id'=>$value['proje_id']
                );
                if($this->db->insert('geopos_invoices', $data_parcalis)){
                    $last_id = $this->db->insert_id();
                    $data_update_product = array(
                        'invoice_transaction_id' => $last_id,
                    );
                    $this->db->set($data_update_product);
                    $this->db->where('id', $last_id);
                    if ($this->db->update('transaction_pay', $data_update_product)) {
                        $update++;

                    }

                }
            }
            echo $update.' Veri Güncellendi';
        }

    }


}
