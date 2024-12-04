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

class Employee extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('employee_model', 'employee');
        $this->load->model('tools_model','tools');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        $this->li_a = 'emp';
    }

    public function adddocument()
    {
        $data['id'] = $this->input->get('id');
        $this->load->helper(array('form'));
        $data['response'] = 3;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Dosya Ekle';

        $this->load->view('fixed/header', $head);

        if ($this->input->post('title')) {
            $title = $this->input->post('title',true);
            $cid = $this->input->post('id');
            $file_type = $this->input->post('file_type');
            $arac_id = $this->input->post('arac_id');
            $baslangic_date_ = datefordatabase($this->input->post('baslangic_date'));
            $bitis_date_ = datefordatabase($this->input->post('bitis_date'));



            $config['upload_path'] = './userfiles/documents';
            $config['allowed_types'] = 'docx|docs|txt|pdf|xls|png|jpg|jpeg';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = 3000;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('userfile')) {
                $data['response'] = 0;
                $data['responsetext'] = 'File Upload Error';

            } else {
                $data['response'] = 1;
                $data['responsetext'] = 'Başarıyla YÜklendi. <a href="/employee/view?id='.$cid.'"
                                       class="btn btn-indigo btn-md"><i
                                                class="icon-folder"></i>
                                    </a>';
                $filename = $this->upload->data()['file_name'];
                $this->employee->adddocument($title, $filename,$cid,$baslangic_date_,$bitis_date_,$file_type,$arac_id);
            }

            $this->load->view('employee/adddocument', $data);
        } else {


            $this->load->view('employee/adddocument', $data);


        }
        $this->load->view('fixed/footer');


    }

    public function delete_document()
    {
        $id = $this->input->post('deleteid'); //3
        $cid = $this->session->userdata('cid'); //257

        if ($this->employee->deletedocument($id,$cid)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function document_load_list()
    {   $cid = $this->input->post('cid');
        $list = $this->employee->document_datatables($cid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $document) {

            $arac_name = (arac_view($document->arac_id))?arac_view($document->arac_id)->name:'';
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $document->title;
            $row[] = personel_file_type_id($document->file_type);
            $row[] = $arac_name;
            $row[] = dateformat($document->baslangic_date);
            $row[] = dateformat($document->bitis_date);

            $row[] = '<a href="' . base_url('userfiles/documents/' . $document->filename) . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> <a class="btn btn-danger btn-xs delete-object" href="#" data-object-id="' . $document->id . '"> <i class="icon-trash "></i> </a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->document_count_all($cid),
            "recordsFiltered" => $this->employee->document_count_filtered($cid),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function personel_report(){
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Maaş Listesi';
        $data['employee'] = $this->employee->list_employee_active();

        $this->load->view('fixed/header', $head);
        $this->load->view('employee/personel_report', $data);
        $this->load->view('fixed/footer');
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Listesi';
        $data['employee'] = $this->employee->list_employee();


        $this->load->view('fixed/header', $head);
        $this->load->view('employee/list', $data);
        $this->load->view('fixed/footer');
    }

    public function toplu_maas_odeme()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Toplu Maaş Ödemesi';
        $data['employee'] = $this->employee->list_employee();


        $this->load->view('fixed/header', $head);
        $this->load->view('employee/toplu_maas_odeme', $data);
        $this->load->view('fixed/footer');
    }

    public function salaries()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Listesi';
        $data['employee'] = $this->employee->list_employee();
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/salaries', $data);
        $this->load->view('fixed/footer');
    }




    public function view()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Detaylar';
        $data['employee'] = $this->employee->employee_details($id);
        $data['permissions'] = $this->employee->permission_details();


        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/view', $data);
        $this->load->view('fixed/footer');

    }

    public function history()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Detaylar';
        $data['employee'] = $this->employee->employee_details($id);
        $data['history'] = $this->employee->salary_history($data['employee']['id']);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/history', $data);
        $this->load->view('fixed/footer');

    }


    public function add()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Ekle';
        $head['roles'] =role_name();

        $data['dept'] = $this->employee->department_list();
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/add',$data);
        $this->load->view('fixed/footer');


    }

    public function submit_user()
    {
        if (!$this->aauth->premission(7)){
            redirect('/dashboard/', 'refresh');
        }

        $username = $this->input->post('username',true);
        $vatandaslik = $this->input->post('vatandaslik', true);
        $cinsiyet = $this->input->post('cinsiyet', true);
        $birthday = $this->input->post('birthday', true);

        $email = $this->input->post('email',true);
        $password = $this->input->post('password',true);
        $roleid = $this->input->post('roleid');

        $medeni_durumu = $this->input->post('medeni_durumu', true);
        $cocuk_durumu = $this->input->post('cocuk_durumu', true);
        $location = $this->input->post('location',true);
        $name = $this->input->post('name',true);
        $kan_grubu = $this->input->post('kan_grubu', true);
        $fin_no = $this->input->post('fin_no', true);
        $address = $this->input->post('address',true);
        $city = $this->input->post('city',true);
        $region = $this->input->post('region',true);
        $country = $this->input->post('country',true);
        $postbox = $this->input->post('postbox',true);
        $phone = $this->input->post('phone',true);
        $email = $this->input->post('email',true);
        $department = $this->input->post('department', true);
        $sorumlu_pers_id = $this->input->post('sorumlu_pers_id', true);
        $calisma_sekli = $this->input->post('calisma_sekli', true);



        //Yeni Alanlar
        $phonealt = $this->input->post('phonealt', true);
        $salary = $this->input->post('salary', true);
        $resmi_maas = $this->input->post('resmi_maas', true);
        $gayri_resmi_maas = $this->input->post('gayri_resmi_maas', true);
        $commission = $this->input->post('commission', true);



        $sozlesme_turu = $this->input->post('sozlesme_turu', true);
        $sozlesme_date = $this->input->post('sozlesme_date', true);
        $date_created = $this->input->post('date_created', true);
        $sozlesme_dates=datefordatabase($sozlesme_date);
        $date_createds=datefordatabase($date_created);
        $sorumlu_kisi = $this->input->post('sorumlu_kisi', true);
        $firma_durumu = $this->input->post('firma_durumu', true);
        $birim = $this->input->post('birim', true);



        //ekstra







        $birthdays=datefordatabase($birthday);

        $a = $this->aauth->create_user($email, $password, $username);

        if ((string)$this->aauth->get_user($a)->id != $this->aauth->get_user()->id) {
            $nuid = (string)$this->aauth->get_user($a)->id;

            if ($nuid > 0) {

                $data=
                    [
                        'salary'=>$salary,
                        'bank_salary'=>$resmi_maas,
                        'staff_id'=>$this->aauth->get_user()->id,
                        'personel_id'=>$nuid,
                    ];
                $this->db->insert('personel_salary', $data);

                $this->employee->add_employee(
                    $nuid, (string)$this->aauth->get_user($a)->username,
                    $name, $roleid, $phone, $address, $city, $region, $country, $postbox,
                    $location, $salary, $commission, $department,$calisma_sekli,$sozlesme_turu,$sozlesme_dates
                    ,$resmi_maas,$gayri_resmi_maas,$date_createds,$vatandaslik,$cinsiyet,$birthdays,$medeni_durumu,$cocuk_durumu,$kan_grubu,
                    $fin_no,$phonealt,$sorumlu_pers_id,$sorumlu_kisi,$firma_durumu,$birim);

            }

        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                'There has been an error, please try again.'));
        }
    }

    public function invoices()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Faturaları';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/invoices', $data);
        $this->load->view('fixed/footer');
    }

    public function invoices_list()
    {

        $eid = $this->input->post('eid');
        $list = $this->employee->invoice_datatables($eid);
        $data = array();

        $no = $this->input->post('start');


        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = $invoices->invoicedate;
            $row[] = amountFormat($invoices->total);
            switch ($invoices->status) {
                case "paid" :
                    $out = '<span class="label label-success">Paid</span> ';
                    break;
                case "due" :
                    $out = '<span class="label label-danger">Due</span> ';
                    break;
                case "canceled" :
                    $out = '<span class="label label-warning">Canceled</span> ';
                    break;
                case "partial" :
                    $out = '<span class="label label-primary">Partial</span> ';
                    break;
                default :
                    $out = '<span class="label label-info">Pending</span> ';
                    break;
            }
            $row[] = $out;
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> View</a> &nbsp; <a href="' . base_url("invoices/printinvoice?id=$invoices->tid") . '&d=1" class="btn btn-info btn-xs"  title="Download"><i class="fa fa-download" aria-hidden="true"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->invoicecount_all($eid),
            "recordsFiltered" => $this->employee->invoicecount_filtered($eid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function transactions()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Ödemeler';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/transactions', $data);
        $this->load->view('fixed/footer');
    }

    public function pers_alacaklandir()
    {
        $pers_id=$this->input->post("alacak_pers_id");
        $metod=$this->input->post("alacak_metod");
        $not=$this->input->post("alacak_not");
        $alacak_tutar=$this->input->post("alacak_tutar");
        $alacakak_borc=$this->input->post("alacakak_borc");
        $image = $this->input->post('image');
        $send_sms = false;
        if(strlen($this->input->post('send-sms')) > 1 && $this->input->post('send-sms') == 'on'){
            $send_sms = true;
        }

        $data = array(

            'csd' => $pers_id,

            'payer' => personel_details_full($pers_id)['name'],

            'acid' => 0, //hesapID ekleneck

            'account' => '', //hesap adı ekelenecek

            'invoicedate' => date('Y-m-d'),

            'invoiceduedate' => date('Y-m-d'),

            'debit' => 0, // eklenecek

            'credit' => 0, //eklenecek

            'total' => $alacak_tutar,

            //'type' => $pay_type, // income expense
            'invoice_type_id'=>$alacakak_borc,

            'invoice_type_desc'=>invoice_type_desc($alacakak_borc),

            //'cat' => $pay_cat,

            'method' => $metod, //ödeme metodu ekelenecek

            'eid' => $this->aauth->get_user()->id, //user_id
            'cari_pers_type' => 2,

            'notes' => $not,
            'ext' => $image,


            // 'ext'=>$ty, //müşterimi tedarikçimi gerek yok

            'loc' => $this->aauth->get_user()->loc

        );

        if($this->db->insert('geopos_invoices', $data))
        {
//            if($send_sms){
//
//             $this->mesaj_gonder( personel_detailsa($pers_id)['phone'],$not.' Cəmi : '.amountFormat($alacak_tutar));
//            }
            echo json_encode(array('status' => 'Success', 'message' =>
                'Personel Başarıyla Alacaklandırılmıştır'));
        }
    }

    public function translist()
    {
        $eid = $this->input->post('eid');
        $list = $this->employee->get_datatables($eid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->invoicedate;
            $row[] = $prd->account;
            $row[] = amountFormat($prd->debit);
            $row[] = amountFormat($prd->credit);

            $row[] = $prd->payer;
            $row[] = $prd->method;
            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-eye"></span> View</a> <a data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-bin"></span>Delete</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->count_all(),
            "recordsFiltered" => $this->employee->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    function disable_user()
    {
        if (!$this->aauth->get_user()->roleid == 5) {
            redirect('/dashboard/', 'refresh');
        }
        $uid = intval($this->input->post('deleteid'));

        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'You can not disable yourself!'));
        } else {

            $this->db->select('banned');
            $this->db->from('geopos_users');
            $this->db->where('id', $uid);
            $query = $this->db->get();
            $result = $query->row_array();
            if ($result['banned'] == 0) {
                $this->aauth->ban_user($uid);
            } else {
                $this->aauth->ban_user($uid);
            }

            echo json_encode(array('status' => 'Success', 'message' =>
                'User Profile updated successfully!'));


        }
    }

    function enable_user()
    {
        if (!$this->aauth->get_user()->roleid == 5) {
            redirect('/dashboard/', 'refresh');
        }
        $uid = intval($this->input->post('deleteid'));

        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'You can not disable yourself!'));
        } else {


            $a = $this->aauth->unban_user($uid);

            echo json_encode(array('status' => 'Success', 'message' =>
                'User Profile disabled successfully!'));


        }
    }

    function delete_user()
    {
        if (!$this->aauth->get_user()->roleid == 5) {
            redirect('/dashboard/', 'refresh');
        }
        $uid = intval($this->input->post('empid'));

        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'You can not delete yourself!'));
        } else {

            $this->db->delete('geopos_employees', array('id' => $uid));

            $this->db->delete('geopos_users', array('id' => $uid));

            echo json_encode(array('status' => 'Success', 'message' =>
                'User Profile deleted successfully! Please refresh the page!'));


        }
    }


    public function calc_income()
    {
        $eid = $this->input->post('eid');

        if ($this->employee->money_details($eid)) {
            $details = $this->employee->money_details($eid);

            echo json_encode(array('status' => 'Success', 'message' =>
                '<br> Toplam Alacak: ' . $details['credit'] . '<br> Topla Borç: ' . $details['debit']));

        }


    }

    public function all_hakedis()
    {

        $this->employee->sales_details_all();
    }

    public function hesap()
    {
        echo date('F ');

    }



    public function maas_gunu_hesaplamasi()
    {

        $hesaplanacak_ay=$_POST['ay'];
        $guns_=date("t");
        $per_is=$_POST['id'];

        $date = new DateTime('now');
        $date->modify('last day of this month');

        $date_y=$date->format('Y');



        $gun=0;

        $date_f=$date_y.'-'.$hesaplanacak_ay.'-'.$guns_;

        $date_ti=$date_y.'-'.$hesaplanacak_ay.'-'.$guns_;

        $date_bas=$date_f.' 00:00:00';

        $sorgu=$this->db->query("SELECT geopos_employees.* FROM geopos_employees  INNER JOIN geopos_users On geopos_users.id=geopos_employees.id  Where  DATE(geopos_users.date_created)<='$date_bas' and geopos_employees.id=$per_is");
        $sorgu_t=$this->db->query("SELECT  DATEDIFF('$date_ti',geopos_users.date_created) AS gun_sayisi FROM geopos_employees INNER JOIN geopos_users On geopos_users.id=geopos_employees.id Where  geopos_employees.id=$per_is")->row();

        if($sorgu_t->gun_sayisi<$guns_)
        {
            $gun=$sorgu_t->gun_sayisi+1;
        }
        else
        {
            $gun=$guns_;
        }

        if($sorgu->num_rows()==0)
        {
            $gun=0;

            echo json_encode(array('gun'=>$gun,'status' => 'Success', 'message' => 'Bu Personel Seçilen Tarihten Sonra İşe Başlamıştır.Gün Hesaplaması Yapınız.'));
        }
        else
        {
            echo json_encode(array('gun'=>$gun,'status' => 'Error'));
        }


    }

    public function calc_sales()
    {
        $csd = $this->input->post('eid');
        $resmi = $this->input->post('resmi');
        $nakit = $this->input->post('nakit');

        $resmi=isset($resmi)?1:0;
        $nakit=isset($nakit)?1:0;


        $total = $this->input->post('new_maas');
        $hesaplanacak_ay = $this->input->post('hesaplanacak_ay');
        $eid=$this->aauth->get_user()->id;

        $personel_name=personel_details($csd);

        $this->employee->sales_details($csd,$total,$eid,$personel_name,$hesaplanacak_ay,$resmi,$nakit);


    }

    public function update()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $username = $this->input->post('username',true);
        $email = $this->input->post('email',true);
        $password = $this->input->post('password',true);
        $roleid = $this->input->post('roleid');

        /* if ($roleid > 3) {
            if ($this->aauth->get_user()->roleid < 5) {
                die('Yetkiniz Yok!');
            }
        }
        */


        $id = $this->input->get('id');
        $this->load->model('employee_model', 'employee');
        if ($this->input->post()) {
            $eid = $this->input->post('eid',true);
            $salary_type = $this->input->post('salary_type',true);
            $name = $this->input->post('name',true);
            $phone = $this->input->post('phone',true);
            $phonealt = $this->input->post('phonealt',true);
            $address = $this->input->post('address',true);
            $city = $this->input->post('city',true);
            $region = $this->input->post('region',true);
            $country = $this->input->post('country',true);
            $postbox = $this->input->post('postbox',true);
            $location = $this->input->post('location',true);
            $salary = $this->input->post('salary',true);
            $department = $this->input->post('department',true);
            $commission = $this->input->post('commission',true);
            $date_created = $this->input->post('date_created',true);
            $calisma_sekli = $this->input->post('calisma_sekli', true);
            $sozlesme_turu = $this->input->post('sozlesme_turu', true);
            $sozlesme_date = $this->input->post('sozlesme_date', true);
            $resmi_maas = $this->input->post('resmi_maas', true);
            $gayri_resmi_maas = $this->input->post('gayri_resmi_maas', true);


            //ekstra
            $vatandaslik = $this->input->post('vatandaslik', true);
            $cinsiyet = $this->input->post('cinsiyet', true);
            $birthday = $this->input->post('birthday', true);
            $ayrilma_tarihi = $this->input->post('ayrilma_tarihi', true);
            $ayrilma_sebebi = $this->input->post('ayrilma_sebebi', true);
            $medeni_durumu = $this->input->post('medeni_durumu', true);
            $cocuk_durumu = $this->input->post('cocuk_durumu', true);
            $kan_grubu = $this->input->post('kan_grubu', true);
            $fin_no = $this->input->post('fin_no', true);
            $sorumlu_pers_id = $this->input->post('sorumlu_pers_id', true);
            $sorumlu_kisi = $this->input->post('sorumlu_kisi', true);
            $birthdays=datefordatabase($birthday);
            $ayrilma_tarihis=datefordatabase($ayrilma_tarihi);
            $firma_durumu = $this->input->post('firma_durumu', true);
            $birim = $this->input->post('birim', true);
            $salary_gunluk = $this->input->post('salary_gunluk', true);
            $proje_id = $this->input->post('proje_id', true);



            $date_createds = datefordatabase($date_created);
            $this->employee->update_employee($eid, $name, $roleid,
                $phone, $phonealt, $address, $city, $region, $country, $postbox, $location,$salary,
                $department,$commission,$date_createds,$calisma_sekli,$sozlesme_turu,$sozlesme_date,
                $resmi_maas,$gayri_resmi_maas,$vatandaslik,$cinsiyet,$birthdays,$medeni_durumu,$cocuk_durumu,
                $kan_grubu,$fin_no,$sorumlu_pers_id,$ayrilma_tarihis,$ayrilma_sebebi,$sorumlu_kisi,$firma_durumu,$birim,$salary_type,$salary_gunluk,$proje_id);


        } else {

            $head['usernm'] = $this->aauth->get_user($id)->username;
            $head['title'] = $head['usernm'] . ' Profili Düzenle';


            $data['user'] = $this->employee->employee_details($id);


            $data['dept'] = $this->employee->department_list($id);


            $data['eid'] = intval($id);
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/edit', $data);
            $this->load->view('fixed/footer');
        }


    }


    public function displaypic()
    {

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $id = $this->input->post('id');
        $user_id = $this->aauth->get_user()->id;
        if($user_id==$id){
            $this->load->model('employee_model', 'employee');

            $this->load->library("uploadhandler", array(
                'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/employee/'
            ));

            $img = (string)$this->uploadhandler->filenaam();
            if ($img != '') {
                $this->employee->editpicture($id, $img);
            }
        }
        else {
            echo json_encode(array('status' => 400, 'message' => 'Yetkiniz Yoktur'));
        }
    }


    public function user_sign()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $this->load->model('employee_model', 'employee');
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/employee_sign/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->employee->editsign($id, $img);
        }


    }


    public function updatepassword()
    {

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->library("form_validation");

        $id = $this->input->get('id');
        $this->load->model('employee_model', 'employee');


        if ($this->input->post()) {
            $eid = $this->input->post('eid');
            $this->form_validation->set_rules('newpassword', 'Password', 'required');
            $this->form_validation->set_rules('renewpassword', 'Confirm Password', 'required|matches[newpassword]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => 'Error', 'message' => '<br>Rules<br> Password length should  be at least 6 [a-z-0-9] allowed!<br>New Password & Re New Password should be same!'));
            } else {

                $newpassword = $this->input->post('newpassword');


                echo json_encode(array('status' => 'Success', 'message' => 'Password Updated Successfully!'));

                $this->aauth->update_user($eid, false, $newpassword, false);


            }


        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $head['usernm'] . ' Profile';


            $data['user'] = $this->employee->employee_details($id);
            $data['eid'] = intval($id);
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/password', $data);
            $this->load->view('fixed/footer');
        }


    }

    public function permissions()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Kullanıcı İzinleri';
        $data['permission'] = $this->employee->employee_permissions();
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/permissions',$data);
        $this->load->view('fixed/footer');


    }

    public function permissions_update()
    {

        if (!$this->aauth->premission(62)) {
            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));
        }

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Kullanıcı İzinleri';
        $permission = $this->employee->employee_permissions();

        foreach ($permission as $row) {
            $i = $row['id'];
            $name1 = 'r_' . $i . '_1';
            $name2 = 'r_' . $i . '_2';
            $name3 = 'r_' . $i . '_3';
            $name4 = 'r_' . $i . '_4';
            $name5 = 'r_' . $i . '_5';
            $name6 = 'r_' . $i . '_6';
            $name7 = 'r_' . $i . '_7';
            $name8 = 'r_' . $i . '_8';
            $name9 = 'r_' . $i . '_9';
            $name10 = 'r_' . $i . '_10';
            $name11 = 'r_' . $i . '_11';
            $name12 = 'r_' . $i . '_12';
            $name13 = 'r_' . $i . '_13';



            $val1 = 0;
            $val2 = 0;
            $val3 = 0;
            $val4 = 0;
            $val5 = 0;
            $val6 = 0;
            $val7 = 0;
            $val8 = 0;
            $val9 = 0;
            $val10 = 0;
            $val11 = 0;
            $val12 = 0;
            $val13 = 0;


            if ($this->input->post($name1)) $val1 = 1;
            if ($this->input->post($name2)) $val2 = 1;
            if ($this->input->post($name3)) $val3 = 1;
            if ($this->input->post($name4)) $val4 = 1;
            if ($this->input->post($name5)) $val5 = 1;
            if ($this->input->post($name6)) $val6 = 1;
            if ($this->input->post($name7)) $val7 = 1;
            if ($this->input->post($name8)) $val8 = 1;
            if ($this->input->post($name9)) $val9 = 1;
            if ($this->input->post($name10)) $val10 = 1;
            if ($this->input->post($name11)) $val11 = 1;
            if ($this->input->post($name12)) $val12 = 1;
            if ($this->input->post($name13)) $val13 = 1;

            if($this->aauth->get_user()->roleid==5 && $i==9)  $val5=1;
            $data = array('r_1' => $val1, 'r_2' => $val2, 'r_3' => $val3, 'r_4' => $val4, 'r_5' => $val5, 'r_6' => $val6,
                'r_7' => $val7, 'r_8' => $val8, 'r_9' => $val9, 'r_10' => $val10, 'r_11' => $val11, 'r_12' => $val12, 'r_13' => $val13);
            $this->db->set($data);
            $this->db->where('id', $i);
            $this->db->update('geopos_premissions');


        }

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED')));
    }


    public function holidays()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Holidays';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/holidays');
        $this->load->view('fixed/footer');

    }


    public function hday_list()
    {
        $list = $this->employee->holidays_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $obj) {
            $datetime1 = date_create($obj->val1);
            $datetime2 = date_create($obj->val2);
            $interval = date_diff($datetime1, $datetime2);
            $day=$interval->format('%a days');
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->val1;
            $row[] = $obj->val2;
            $row[] = $day;
            $row[] = $obj->val3;
            $row[] = "<a href='" . base_url("employee/editholiday?id=$obj->id") . "' class='btn btn-indigo btn-xs'><i class='icon-pen'></i> " . $this->lang->line('Edit') ."</a> ".'<a href="#" data-object-id="' . $obj->id . '" class="btn btn-danger btn-sm delete-object"><i class="fas fa-trash-alt"></i></a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->holidays_count_all(),
            "recordsFiltered" => $this->employee->holidays_count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function editizin()
    {

        if(!izin_yetkilisi_pers($this->aauth->get_user()->id)) {

            exit('<h3>Bu bölüme giriş izniniz yoktur!</h3>');

        }

        $id = intval($this->input->get('id'));
        $data['id']=$id;
        $data['details']=$this->employee->pers_views($id);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'İzin Düzenle';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/edit_izin', $data);
        $this->load->view('fixed/footer');

    }



    public function personel_izinleri()
    {
        $list = $this->employee->personel_izinleri_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $obj) {

            $id=$obj['id'];
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj['emp_fullname'];
            $row[] = $obj['bas_date'].' '.$obj['bas_saati'];
            $row[] = $obj['bitis_date'].' '.$obj['bit_saati'];
            $row[] = izin_status($obj['status']);
            $row[] = "
            <a href='" . base_url("employee/editizin?id=$id") . "' class='btn btn-success btn-xs'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') ."</a>";


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => 1,
            "recordsFiltered" =>2,
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete_hday()
    {
        $id = $this->input->post('deleteid');


        if ($this->employee->deleteholidays($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function addhday()
    {

        if ($this->input->post()) {

            $from = datefordatabase($this->input->post('from'));
            $todate = datefordatabase($this->input->post('todate'));
            $note = $this->input->post('note',true);

            $date1=new DateTime($from);
            $date2=new DateTime($todate);
            if($date1<=$date2){


                if ($this->employee->addholidays($this->aauth->get_user()->loc,$from, $todate, $note)) {
                    echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "   <a href='addhday' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='holidays' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
                }
            }
            else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR').'- Invalid'));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add Holiday';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/addholyday', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function editholiday()
    {

        if ($this->input->post()) {


            $id = $this->input->post('did');
            $from = datefordatabase($this->input->post('from'));
            $todate = datefordatabase($this->input->post('todate'));
            $note = $this->input->post('note',true);

            if ($this->employee->edithday($id,$this->aauth->get_user()->loc,$from, $todate, $note)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='addhday' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='holidays' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['hday'] = $this->employee->hday_view($data['id'],$this->aauth->get_user()->loc);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Holiday';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/edithday', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function departments()
    {
        $this->li_a = 'dep';
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['department_list'] = $this->employee->department_list(0,$this->aauth->get_user()->loc);
        $head['title'] = 'Bölümler';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/departments',$data);
        $this->load->view('fixed/footer');

    }

    public function department()
    {
        $this->li_a = 'dep';
        $data['id'] = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['department'] = $this->employee->department_view($data['id'],$this->aauth->get_user()->loc);
        $data['department_list'] = $this->employee->department_elist($data['id'] );
        $head['title'] = 'Bölümler';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/department',$data);
        $this->load->view('fixed/footer');

    }

    public function delete_dep()
    {
        $this->li_a = 'dep';
        $id = $this->input->post('deleteid');


        if ($this->employee->deletedepartment($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function adddep()
    {
        $this->li_a = 'dep';
        if ($this->input->post()) {

            $name = $this->input->post('name',true);


            if ($this->employee->adddepartment($this->aauth->get_user()->loc,$name)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='adddep' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='departments' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Bölüm Ekle';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/adddep');
            $this->load->view('fixed/footer');
        }

    }

    public function editdep()
    {
        $this->li_a = 'dep';
        if ($this->input->post()) {

            $name = $this->input->post('name',true);
            $id = $this->input->post('did');

            if ($this->employee->editdepartment($id,$this->aauth->get_user()->loc,$name)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='adddep' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='departments' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $data['id'] = $this->input->get('id');
            $data['department'] = $this->employee->department_view($data['id'],$this->aauth->get_user()->loc);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Bölüm Düzenle';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/editdep', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function payroll_create()
    {
        $this->load->library("Custom");
        $this->li_a = 'pay';
        $this->load->model('transactions_model', 'transactions');

        $data['dual'] = $this->custom->api_config(65);
        $data['cat'] = $this->transactions->categories();
        $data['accounts'] = $this->transactions->acc_list();
        $head['title'] = "Add Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll_create', $data);
        $this->load->view('fixed/footer');

    }

    public function emp_search()
    {

        $name = $this->input->get('keyword', true);


        $whr='';
        if ($this->aauth->get_user()->loc) {
            $whr=' (geopos_users.loc='.$this->aauth->get_user()->loc.') AND ';
        }
        if ($name) {
            $query = $this->db->query("SELECT geopos_employees.* ,geopos_users.email FROM geopos_employees  LEFT JOIN geopos_users ON geopos_users.id=geopos_employees.id  WHERE $whr (UPPER(geopos_employees.name)  LIKE '%" . strtoupper($name) . "%' OR UPPER(geopos_employees.phone)  LIKE '" . strtoupper($name) . "%') LIMIT 6");
            $result = $query->result_array();
            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {

                echo "<li onClick=\"selectPay('" . $row['id'] . "','" . $row['name'] . " ','" . $row['salary'] . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';
        }

    }

    public function payroll()
    { $this->li_a = 'pay';

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Payroll Transactions';


        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll');
        $this->load->view('fixed/footer');
    }



    public function payroll_list()
    {

        if($this->aauth->get_user()->id == 61 || $this->aauth->get_user()->id == 21 || $this->aauth->get_user()->id == 39 || $this->aauth->get_user()->id == 1007 || $this->aauth->get_user()->id == 62){
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Personel Bordro';
            $data['employee'] = $this->employee->list_employee();

            $this->load->view('fixed/header', $head);
            $this->load->view('employee/payroll_list',$data);
            $this->load->view('fixed/footer');
        }
        else {
            exit('<h3>Bu bölüme giriş izniniz yoktur!</h3>');
        }


    }

    public function bordro_hesaplandir()
    {
        $guns_=date("t");
        $date = new DateTime('now');
        $date->modify('last day of this month');

        $date_y=$date->format('Y');
        $hesaplanacak_ay=$date->format('m');
        $date_g=$guns_;
        $date_saat=$date->format(' H:i:s');
        $date_S= $date_y.'-'.$hesaplanacak_ay.'-'.$date_g.' '.$date_saat;

        $pers_ids=$this->input->post('per_id');

        foreach ($pers_ids as $key => $value)
        {

            $pers_id=$value;
            $gun_saiyisi=$this->input->post('gun_saiyisi')[$key];
            $personel_name= personel_details($pers_id);
            $calistigi_gun_sayisi=$this->input->post('norma_is_sayisi')[$key];
            $alacak_tutar_banka=$this->input->post('cemi_odenen_inp')[$key];

            $dsmf_inp=$this->input->post('dsmf_inp')[$key];
            $issizlik_inp=$this->input->post('issizlik_inp')[$key];
            $toplam_gider=floatval($dsmf_inp)+floatval($issizlik_inp);

            if(personel_detailsa($pers_id)['banned']==0)
            {
                // banka alacağını kayıt et
                $data = array(
                    'invoicedate' => $date_S,
                    'invoiceduedate' => $date_S,
                    'total' =>$alacak_tutar_banka+$toplam_gider,
                    'credit' =>$alacak_tutar_banka+$toplam_gider,
                    'payer' =>$personel_name,
                    'notes' => 'Hakediş',
                    'csd'=>$pers_id,
                    'eid'=>$this->aauth->get_user()->id,
                    'invoice_type_id'=>31,
                    'method'=>3,
                    'cari_pers_type'=>2,
                    'invoice_type_desc'=>'Banka Maaş Alacağı'
                );

                $this->db->insert('geopos_invoices', $data);
                // banka alacağını kayıt et




                //nakit alacağını kayıt et

                $nakit_maas=personel_detailsa($pers_id)['gayri_resmi_maas'];
                $gunluk=$nakit_maas/$gun_saiyisi;
                $nakit_alacak=$gunluk*$calistigi_gun_sayisi;

                $data = array(
                    'invoicedate' => $date_S,
                    'invoiceduedate' => $date_S,
                    'total' =>$nakit_alacak,
                    'credit' =>$nakit_alacak,
                    'payer' =>$personel_name,
                    'notes' => 'Hakediş',
                    'csd'=>$pers_id,
                    'eid'=>$this->aauth->get_user()->id,
                    'invoice_type_id'=>13,
                    'method'=>1,
                    'cari_pers_type'=>2,
                    'invoice_type_desc'=>'Nakit Maaş Alacağı'
                );
                $this->db->insert('geopos_invoices', $data);

                /* $data2 = array(
                     'invoicedate' => $date_S,
                     'invoiceduedate' => $date_S,
                     'total' =>$toplam_gider,
                     'credit' =>$toplam_gider,
                     'payer' =>$personel_name,
                     'notes' => 'Kesinti Hakedişi',
                     'csd'=>$pers_id,
                     'eid'=>$this->aauth->get_user()->id,
                     'invoice_type_id'=>13,
                     'method'=>1,
                     'invoice_type_desc'=>'Nakit Maaş Alacağı'
                 );

                 $this->db->insert('geopos_invoices', $data2); */


                //nakit alacağını kayıt et


                //giderleri işle

                $data_gider=array(
                    'invoicedate' => $date_S,
                    'invoiceduedate' => $date_S,
                    'total' =>$toplam_gider,
                    'credit' =>$toplam_gider,
                    'payer' =>$personel_name,
                    'notes' => 'Personel Giderleri',
                    'csd'=>$pers_id,
                    'eid'=>$this->aauth->get_user()->id,
                    'invoice_type_id'=>32,
                    'method'=>3,
                    'cari_pers_type'=>2,
                    'invoice_type_desc'=>'Personel Giderleri'
                );
                $this->db->insert('geopos_invoices', $data_gider);
                //giderleri işle
            }


        }
        echo json_encode(array('status' => 'Success', 'message' =>
            'Başarıyla İşlem Yapılmıştır!'));

    }

    public function list_emp()
    {
        $list = $this->employee->list_employee();
        $i=0;
        $data=array();
        foreach ($list as $invoices) {

            $is_gunu=27;
            $hesaplanan=($invoices['resmi_maas']/$is_gunu)*$is_gunu;
            $dsm_fond=0;
            $dsm=0;
            $issizlik_fond=0;
            $gelir_vergisi=0;
            if($hesaplanan>200)
            {
                $dsm_fond=44+($hesaplanan-200)*0.15;
            }
            else
            {
                $dsm_fond=($hesaplanan)*0.22;
            }

            $issizlik_fond=$hesaplanan*0.005;

            if($hesaplanan>200)
            {
                $dsm=6+($hesaplanan-200)*0.10;
            }
            else
            {
                $dsm=($hesaplanan)*0.3;
            }

            if($hesaplanan>8000)
            {
                $gelir_vergisi=($hesaplanan-8000)*0.14;
            }
            if($gelir_vergisi<0)
            {
                $gelir_vergisi=0;
            }

            $cemi_tutar=$dsm+$gelir_vergisi+$issizlik_fond;
            $cemi_odenen=$hesaplanan-$cemi_tutar;
            $mez_hesap=0;

            $row=array();
            $i++;
            $row[] = $i;
            $row[] = $invoices['name'];
            $row[] = $invoices['birim'];
            $row[] = "<span>".amountFormat($invoices['resmi_maas'])."</span>"."<input type='hidden' name='per_id[]' value='".$invoices['id']."'><input type='hidden' class='resmi_maas' value='".$invoices['resmi_maas']."'>"; //emek hakkı
            $row[] = "<input type='number' name='gun_saiyisi[]' value='28'  class='form-control gun_sayisi'>"; // norma iş ayı
            $row[] = "<input type='number' name='norma_is_sayisi[]' value='28'  class='form-control norma_is_sayisi'>"; //aya nisbede
            $row[] =  "<input type='hidden' name='hesaplanan_inp[]' class='hesaplanan_inp' value='".$hesaplanan."'>"."<span class='hesaplanan'>".amountFormat($hesaplanan)."<span>"; //Hesablanıb
            $row[] = "<input type='number' name='mez_hesap_gun[]' value='0'  class='form-control mez_hesap_gun'>";; //Məzuniyyət və ya Son Haqq-Hesab
            $row[] = "<input type='hidden' class='mesa_hesap_inp' value='0'>"."<span class='mez_hesap'>".amountFormat($mez_hesap)."<span>"; //Məzuniyyət və ya Son Haqq-Hesab
            $row[] = "<input type='number' name='hastalik[]' value='0'  class='form-control hastalik'>";; //Xəstəlik
            $row[] = "<input type='hidden' class='cemi_inp' value='".$hesaplanan."'>"."<span class='cemi'>".amountFormat($hesaplanan)."<span>"; // //Cəmi
            $row[] = "<input type='hidden' class='dsmf_fond_inp' value='".$dsm_fond."'>"."<span class='dsmf_fond'>".amountFormat($dsm_fond)."<span>"; //DSMF fond
            $row[] = "<input type='hidden' class='issizlik_fond_inp' value='".$issizlik_fond."'>"."<span class='issizlik_fond'>".amountFormat($issizlik_fond)."</span>"; //işsizlik fond
            $row[] = "<input type='hidden' name ='dsmf_inp[]' class='dsmf_inp' value='".$dsm."'>"."<span class='dsmf'>".amountFormat($dsm)."</span>"; //DSMF
            $row[] = "<input type='hidden' name='issizlik_inp[]' class='issizlik_inp' value='".$issizlik_fond."'>"."<span class='issizlik'>".amountFormat($issizlik_fond)."</span>";//İşsizlik
            $row[] = "<input type='hidden' class='gelir_vergisi_inp' value='".$gelir_vergisi."'>"."<span class='gelir_vergisi'>".amountFormat($gelir_vergisi)."</span>"; //Gəlir vergisi
            $row[] = "<input type='number' name='odenilmis_e_h[]' value='0'  class='form-control odenilmis_e_h'>"; //Ödənilmiş (ə/h, məzuniyyət s.h.h.)
            $row[] = "<input type='hidden' class='cemi_tutar_inp' value='".$cemi_tutar."'>"."<span class='cemi_tutar'>".amountFormat($cemi_tutar)."</span>"; //Cəmi Tutulur
            $row[] ="<input type='hidden' name='cemi_odenen_inp[]' class='cemi_odenen_inp' value='".$cemi_odenen."'>"."<span class='cemi_odenen'>".amountFormat($cemi_odenen)."</span>"; //Cəmi Ödənilir
            $data[] = $row;

        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => 500,
            "recordsFiltered" =>0,
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }



    public function bordro_hesaplama()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Bordro Listesi';
        $data['employee'] = $this->employee->list_employee();

        $this->load->view('fixed/header', $head);
        $this->load->view('cont/personel_takip',$data);
        $this->load->view('fixed/footer');
    }

    public function payroll_emp()
    {     $this->li_a = 'pay';
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Payroll Transactions';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/payroll_employee', $data);
        $this->load->view('fixed/footer');
    }



    public function payrolllist()
    {  $this->li_a = 'pay';
        $eid = $this->input->post('eid');
        $list = $this->employee->pay_get_datatables($eid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->invoicedate;

            $row[] = amountFormat($prd->debit);
            $row[] = amountFormat($prd->credit);
            $row[] = $prd->account;
            $row[] = $prd->payer;
            $row[] = $prd->method;
            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-eye"></span> View</a> <a  href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-bin"></span></a> ';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->pay_count_all($eid),
            "recordsFiltered" => $this->employee->pay_count_filtered($eid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function attendances()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Attendance';
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/attendance_list');
        $this->load->view('fixed/footer');

    }

    public function attendance()
    {
        if ($this->input->post()) {
            $emp = $this->input->post('employee');
            $adate = datefordatabase($this->input->post('adate'));
            $from = timefordatabase($this->input->post('from'));
            $todate = timefordatabase($this->input->post('to'));
            $note = $this->input->post('note');

            if ($this->employee->addattendance($emp,$adate,$from,$todate,$note)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . "  <a href='attendance' class='btn btn-indigo btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span>  </a> <a href='attendances' class='btn btn-grey btn-lg'><span class='icon-eye' aria-hidden='true'></span>  </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        }else {


            $data['emp'] = $this->employee->list_employee();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'New Attendance';
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/attendance', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function att_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->employee->attendance_datatables($cid);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $obj) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $obj->name;
            $row[] = dateformat($obj->adate).' '.$obj->tfrom.' - '.$obj->tto;
            $row[] = $obj->note;

            $row[] = '<a href="#" data-object-id="' . $obj->id . '" class="btn btn-danger btn-sm delete-object"><span class="icon-bin"></span></a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->attendance_count_all($cid),
            "recordsFiltered" => $this->employee->attendance_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function delete_attendance()
    {
        $id = $this->input->post('deleteid');


        if ($this->employee->deleteattendance($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function ekstre_data_borclandirma()
    {


        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));

        $list = $this->employee->ekstre_datatables_borclandirma($cid, $tid,$para_birimi);

        $data = array();
        $no = $this->input->post('start');
        $bakiye=0;
        $alacak_toplam=0;
        $borc_toplam=0;

        foreach ($list as $invoices) {
            $notes=$invoices['notes'];
            if( $invoices['total']!=0)
            {
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

                $btn=$invoices['description'];
                if($invoices['type_id']==52 || $invoices['type_id']==34){
                    $btn='<button class="btn btn-info btn-sm credit" credit_id="'.$invoices['invoice_id'].'">'.$invoices['description'].'</button>';
                }
                $row[] = dateformat($invoices['invoicedate']);
                $row[] = $btn;
                $row[] = account_type_sorgu($invoices['odeme_tipi']);
                $row[] = amountFormat($borc,$para_birimi);
                $row[] = amountFormat($alacak,$para_birimi);

                $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");
                $data[] = $row;
            }
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->inv_count_all($cid),
            "recordsFiltered" =>0,
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ekstre_data_razi()
    {


        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));
        $firma_durumu =$this->db->query("SELECT * From geopos_employees Where id = $cid")->row()->firma_durumu;
        $list = "";
//        if($firma_durumu=="Razı" || $firma_durumu=='RAZI')
//        {
//
//        }

        $list = $this->employee->ekstre_datatables_razi($cid, $tid,$para_birimi);


        $data = array();
        $no = $this->input->post('start');
        $bakiye=0;
        $alacak_toplam=0;
        $borc_toplam=0;

        if($list){
            foreach ($list as $invoices) {
                $notes=$invoices['notes'];
                if( $invoices['total']!=0)
                {
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
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->inv_count_all($cid),
            "recordsFiltered" =>0,
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ekstre_data()
    {


        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));

        $list = $this->employee->ekstre_datatables($cid, $tid,$para_birimi);

        $data = array();
        $no = $this->input->post('start');
        $bakiye=0;
        $alacak_toplam=0;
        $borc_toplam=0;

        foreach ($list as $invoices) {
            $notes=$invoices['notes'];
            if( $invoices['total']!=0)
            {
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
                $row[] = "<a href='/transactions/view?id=".$invoices['invoice_id']."' class='btn btn-success'>".$invoices['description']."</a>";
                $row[] = account_type_sorgu($invoices['odeme_tipi']);
                $row[] = amountFormat($borc,$para_birimi);
                $row[] = amountFormat($alacak,$para_birimi);

                $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");
                $row[] = $invoices['notes'];
                $data[] = $row;
            }
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->inv_count_all($cid),
            "recordsFiltered" =>0,
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function ekstre_is()
    {


        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));

        $list_ = $this->employee->ekstre_datatables_is($cid, $tid,$para_birimi);

        $items_ar = [];
        foreach ($list_ as $list_ar){
            $id = $list_ar['invoice_id'];
            $odemeler = $this->db->query("SELECT * FROM geopos_invoice_transactions where transaction_id = $id GROUP BY geopos_invoice_transactions.invoice_id");
            if($odemeler->num_rows()>0){
                foreach ($odemeler->result() as $items){
                    $items_ar[]=$this->db->query("SELECT geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoices.id as invoice_id,
                  IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
                IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as alacak,
                IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as borc,
                geopos_invoices.total,geopos_invoices.kur_degeri,
                geopos_invoice_type.transactions,geopos_invoices.notes  FROM geopos_invoices
                LEFT JOIN geopos_invoice_type on geopos_invoices.invoice_type_id=geopos_invoice_type.id
                Where geopos_invoices.tid=$id
                ORDER BY invoicedate ASC ")->row_array();
                }
            }

        }

        $list = array_merge($list_,$items_ar);



        $data = array();
        $no = $this->input->post('start');
        $bakiye=0;
        $alacak_toplam=0;
        $borc_toplam=0;

        foreach ($list as $invoices) {
            $notes=$invoices['notes'];
            if( $invoices['total']!=0)
            {
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
                $row[] = "<a href='/transactions/view?id=".$invoices['invoice_id']."' class='btn btn-success'>".$invoices['description']."</a>";
                $row[] = account_type_sorgu($invoices['odeme_tipi']);
                $row[] = amountFormat($borc,$para_birimi);
                $row[] = amountFormat($alacak,$para_birimi);

                $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");
                $row[] = $invoices['notes'];
                $data[] = $row;
            }
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->inv_count_all($cid),
            "recordsFiltered" =>0,
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ekstre_gider()
    {


        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));

        $list_ = $this->employee->ekstre_datatables_gider($cid, $tid,$para_birimi);



        $data = array();
        $no = $this->input->post('start');
        $bakiye=0;
        $alacak_toplam=0;
        $borc_toplam=0;


        $result_deger=[];
        $odemeler = $this->db->query("SELECT geopos_invoices.*,geopos_account_type.name FROM geopos_invoices  INNER JOIN geopos_account_type ON geopos_invoices.method=geopos_account_type.id  Where geopos_invoices.csd = $cid and geopos_invoices.invoice_type_id = 33");
        if($odemeler->num_rows()){
            $result = $odemeler->result();
            foreach ($result as $res){
                $talep_item = $this->db->query("SELECT * FROM invoice_to_talep where invoice_id = $res->id");
                if($talep_item->num_rows()){
                  $talep_id = $talep_item->row()->talep_id;
                  $talep_details = $this->db->query("SELECT * FROM `geopos_talep_items` Where tip =$talep_id")->result();
                    foreach ($talep_details as $taleps){
                        $result_deger[]=array(
                            'total'=>  $taleps->price,
                            'kur_degeri'=>  $res->kur_degeri,
                            'invoicedate'=>  $res->invoicedate,
                            'invoice_id'=>  $res->id,
                            'name'=>  $res->name,
                            'cost_name'=>  $taleps->product_name,
                        );
                    }

                }
            }
        }


        $list = array_merge($list_,$result_deger);

        foreach ($list as $invoices) {

            if( $invoices['total']!=0)
            {
                $carpim=$invoices['kur_degeri'];
                $no++;
                $row = array();
                $bakiye = $invoices['total'];

                $row[] = dateformat($invoices['invoicedate']);
                $row[] = "<a href='/transactions/view?id=".$invoices['invoice_id']."' class='btn btn-success'>".$invoices['cost_name']."</a>";
                $row[] = $invoices['name'];
                $row[] = amountFormat(abs($bakiye));
                $data[] = $row;
            }
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->inv_count_all($cid),
            "recordsFiltered" =>0,
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function mezuniyet()
    {


        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');
        $para_birimi = para_birimi_ogren($this->input->post('para_birimi'));

        $list = $this->employee->ekstre_datatables_mezuniyet($cid);



        $data = array();
        foreach ($list as $invoices) {
            $row=[];
            if($invoices->mezuniyer_st==1){
                $tip='Mezuniyet';
            }
            else {
                $tip='Hastalık';
            }

            $delete="<button class='btn btn-danger delete_mezuniyet' mezuniyet_id='$invoices->id'><i class='fa fa-ban'></i></button>";

            $row[] = dateformat($invoices->created_at);
            $row[] = $tip;
            $row[] = $delete;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->mezuniyet_count_all($cid),
            "recordsFiltered" => $this->employee->mezuniyet_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function izinler()
    {

        $cid = $this->input->post('cid');
        $tid = $this->input->post('tyd');

        $list = $this->employee->izinler_datatables($cid, $tid);

        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $invoices) {

            $id=$invoices['id'];
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = dateformat($invoices['created_date']);
            $row[] = izin_durumu($invoices['bolum_pers_status']);
            $row[] = izin_durumu($invoices['status']);
            $row[] = izin_durumu($invoices['finas_pers_status']);
            $row[] = izin_durumu($invoices['genel_mudur_status']);
            if ($invoices['status']==0) {

                $row[] =  '<a href="' . base_url() . 'employee/permissions_edit?id=' . $id . '"  class="btn btn-secondary" ><span class="icon-plus-circle"></span> Düzenle</a>'


                ;
                $data[] = $row;
            }else if($invoices['status']==1){

                $row[] =  '

               <a href="' . base_url("employee/print_izin?id=$id") . '" class="btn btn-primary"><span class="fa fa-print" ></span>Yazdır</a>';

                $data[] = $row;
            }
            else
            {
                $row[] = '<spanan>Talebiniz Red Edilmiştir.</spanan>';
                $data[] = $row;
            }
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->izinler_count_all($cid),
            "recordsFiltered" =>$this->employee->izinler_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function permissions_add(){


        $this->load->view('fixed/header');
        $this->load->view('employee/permissions-add');
        $this->load->view('fixed/footer');

    }
    public function permissions_action(){

        $description = $this->input->post('description',true);
        $baslangic_tarihi = $this->input->post('baslangic_tarihi',true);
        $baslangic_saati = $this->input->post('baslangic_saati',true);
        $bitis_tarihi = $this->input->post('bitis_tarihi',true);
        $bitis_saati = $this->input->post('bitis_saati',true);

        $bas_t=datefordatabase($baslangic_tarihi);
        $bit_t=datefordatabase($bitis_tarihi);
        $emp_id= $this->aauth->get_user()->id;

        if($this->employee->add_permissions($description,$bas_t,$baslangic_saati,$bit_t,$bitis_saati,$emp_id))
        {
            $insert_id = $this->db->insert_id();
            $this->load->model('communication_model');
            $this->load->model('tools_model');

            $yetkili_id=$this->db->query("SELECT * FROM geopos_employees WHERE id=$emp_id")->row()->sorumlu_pers_id;
            $emp_fullname=personel_details($emp_id);
            $yetkili_izin_pers_email=personel_email($yetkili_id)['email'];
            $yetkili_no=personel_detailsa($yetkili_id)['phone'];




            $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
            $firma_kodu=$dbnames['firma_kodu'];
            $validtoken = hash_hmac('ripemd160', 'p' . $insert_id, $this->config->item('encryption_key'));

            $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$insert_id&pers_id=$yetkili_id&type=izin_onay&token=$validtoken";

            $short_url = $this->getSmallLink($href);


            $message=$emp_fullname.' Adlı Personeliniz İzin Talep Etmektedir.';


            $message .="<br>Detaylar İçin<a href='$short_url'>Tıklayınız</a>";

            $mesaj=$emp_fullname.' Adlı Personeliniz İzin Talep Etmektedir.Detaylar İçin '.$short_url;

            $message_ = $this->mesaj_gonder($yetkili_no,$mesaj);
            /*  if($message_==1)
              {
                  $this->communication_model->send_email($yetkili_izin_pers_email, $emp_fullname, 'İzin Talebi', $message, false, '');
              }

            */









            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('izin_talebi_basarili')));

        }else
        {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }



    }



    public  function getSmallLink($longurl){
        $talep_no = numaric(18);

        $url =$longurl;
        $sort_url='https://makrolink.site/'.$talep_no;

        $data_items=array
        (
            'sort_link'=>$sort_url,
            'long_link'=>$url,
        );
        $this->db->insert('sort_link', $data_items);

        $operator= "deger+1";
        $this->db->set('deger', "$operator", FALSE);
        $this->db->where('tip', 18);
        $this->db->update('numaric');

        $firma = new mysqli('localhost', 'link', 'Gm7s6z^8', 'link');
        if ($firma->connect_error) {
            die("Connection failed: " . $firma->connect_error);
        }
        $sql="INSERT INTO `sort_link`(`sort_link`, `long_link`) VALUES ('$sort_url','$url')";
        if ($firma->query($sql) === TRUE) {
            return $sort_url;
        }
        else {
            echo "Error: " . $sql . "<br>" . $firma->error;
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

    public function pers_view($id){
        $this->load->model("employee_model");
        $pers_views = $this->employee_model->pers_views($id);
        echo json_encode($pers_views);
        exit();
    }


    public function permissions_edit(){
        $id = $this->input->get('id');
        $row = $this->db
            ->where("id",$id)
            ->get("geopos_izinler")->row();
        $viewdata = new stdClass();
        $viewdata->row = $row;

        $this->load->view('fixed/header');
        $this->load->view("employee/pers_edit",$viewdata);
        $this->load->view('fixed/footer');

    }

    public function izin_duzenle_action()
    {
        $id = $this->input->post('izin_id');
        $description = $this->input->post('description',true);
        $baslangic_tarihi = $this->input->post('baslangic_tarihi',true);
        $baslangic_saati = $this->input->post('baslangic_saati',true);
        $bitis_tarihi = $this->input->post('bitis_tarihi',true);
        $bitis_saati = $this->input->post('bitis_saati',true);
        $status = $this->input->post('status',true);
        $izin_tipi = $this->input->post('izin_tipi',true);

        $bas_t=datefordatabase($baslangic_tarihi);
        $bit_t=datefordatabase($bitis_tarihi);
        $emp_id= $this->input->post('emp_id',true);

        if($this->employee->edit_permissions($id,$description,$bas_t,$baslangic_saati,$bit_t,$bitis_saati,$emp_id,$izin_tipi,$status))
        {
            $this->load->model('communication_model');


            $emp_fullname=personel_details($emp_id);
            $yetkili_izin_pers_email=personel_email($emp_id)['email'];
            $durum=izin_status($status);
            $message='Sayın '.$emp_fullname.' İzin Durumunuz '.$durum.' olarak güncellenmiştir.İzinlerim sekmesinden bakabilirsiniz..';

            $this->communication_model->send_email($yetkili_izin_pers_email, $emp_fullname, 'İzin Durumu Hk',
                $message, '');


            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('izin_Düzenleme_basarili')));

        }else
        {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
    public function permiss_update(){

        $id = $this->input->post('id');
        $description = $this->input->post('description',true);
        $baslangic_tarihi = $this->input->post('baslangic_tarihi',true);
        $baslangic_saati = $this->input->post('baslangic_saati',true);
        $bitis_tarihi = $this->input->post('bitis_tarihi',true);
        $bitis_saati = $this->input->post('bitis_saati',true);

        $bas_t=datefordatabase($baslangic_tarihi);
        $bit_t=datefordatabase($bitis_tarihi);
        $emp_id= $this->aauth->get_user()->id;

        if($this->employee->edit_permissions($id,$description,$bas_t,$baslangic_saati,$bit_t,$bitis_saati,$emp_id))
        {
            $this->load->model('communication_model');
            $yetkili_id=izin_yetkili_pers_id();
            $emp_fullname=personel_details($emp_id);
            $yetkili_izin_pers_email=personel_email($yetkili_id)['email'];
            $message=$emp_fullname.' Adlı Personeliniz İzin Talep Etmektedir.';

            $this->communication_model->send_email($yetkili_izin_pers_email, $emp_fullname, 'İzin Talebi',
                $message, '');


            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('izin_Düzenleme_basarili')));

        }else
        {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }



    }

    public function ise_alim_print()
    {
        $id = $this->input->get('id');
        $data['id'] = $id;
        $data['details']=personel_detailsa($id);
        $head['title'] = "İşe Alım Formu";
        $head['usernm'] = $this->aauth->get_user()->username;

        ini_set('memory_limit', '64M');
        $html = $this->load->view('employee/ise-alim-print-' . LTR, $data, true);
        $this->load->library('pdf');



        $pdf = $this->pdf->load_en();



        $pdf->SetHTMLFooter('<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;"><tr><td width="33%"></td><td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td><td width="33%" style="text-align: right; ">' . $id . '</td></tr></table>');



        $pdf->WriteHTML($html);



        if ($this->input->get('d')) {



            $pdf->Output('ise_alim#' . $id . '.pdf', 'D');

        } else {

            $pdf->Output('ise_alim#' . $id . '.pdf', 'I');

        }

    }

    public function is_cikis_print()
    {
        $id = $this->input->get('id');
        $data['id'] = $id;
        $data['details']=personel_detailsa($id);
        $head['title'] = "İşeten Çıkış Formu";
        $head['usernm'] = $this->aauth->get_user()->username;

        ini_set('memory_limit', '64M');
        $html = $this->load->view('employee/isten-cikis-print-' . LTR, $data, true);
        $this->load->library('pdf');



        $pdf = $this->pdf->load_en();



        $pdf->SetHTMLFooter('<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;"><tr><td width="33%"></td><td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td><td width="33%" style="text-align: right; ">' . $id . '</td></tr></table>');



        $pdf->WriteHTML($html);



        if ($this->input->get('d')) {



            $pdf->Output('isten_cikis#' . $id . '.pdf', 'D');

        } else {

            $pdf->Output('isten_cikis#' . $id . '.pdf', 'I');

        }

    }

    public function print_izin()
    {

        $id = $this->input->get('id');
        $data['id'] = $id;
        $data['details']=$this->employee->pers_views($id);
        $data['detailsa']=$this->employee->pers_views2($id);
        $head['title'] = "İzin Kağıdı Yazdır";
        $head['usernm'] = $this->aauth->get_user()->username;

        ini_set('memory_limit', '64M');
        $html = $this->load->view('employee/view-print-' . LTR, $data, true);

        $this->load->library('pdf');

        $footer = $this->load->view('employee/footer-print-' . LTR, $data, true);

        $pdf = $this->pdf->load_en();

        $pdf->SetHTMLFooter($footer);


        $orientation = 'P';
        $condition = '';
        $resetpagenum = '';
        $pagenumstyle = '';
        $suppress = '';
        $mgl = '3';
        $mgr = '3';
        $mgt = 1;
        $mgb = '0';
        $mgh = '';
        $mgf = '160';
        $ohname = '';
        $ehname = '';
        $ofname = '';
        $efname = '';
        $ohvalue = 0;
        $ehvalue = 0;
        $ofvalue = 0;
        $efvalue = 0;
        $pagesel = '';
        $newformat = 'A4';

        $pdf->AddPage(
            $orientation, // L - landscape, P - portrait
            $condition,
            $resetpagenum ,
            $pagenumstyle ,
            $suppress ,
            $mgl ,
            $mgr ,
            $mgt ,
            $mgb ,
            $mgh ,
            $mgf ,
            $ohname ,
            $ehname ,
            $ofname ,
            $efname ,
            $ohvalue ,
            $ehvalue,
            $ofvalue,
            $efvalue,
            $pagesel ,
            $newformat
        ); // margin footer


        $pdf->WriteHTML($html);



        if ($this->input->get('d')) {

            $pdf->Output('İzin_Kagıdı#' . $id . '.pdf', 'D');

        } else {

            $pdf->Output('İzin_Kagıdı#' . $id . '.pdf', 'I');

        }



    }


    public function permissions_view()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'İzin Detayları';
        $data['details'] = $this->db->query("SELECT * FROM geopos_izinler WHERE id=$id")->row();


        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/permissions_view', $data);
        $this->load->view('fixed/footer');

    }

    public function izin_update()
    {
        $tip = $this->input->post('status');
        $id = $this->input->post('id');

        $user_id =  $this->aauth->get_user()->id;


        $query2 = $this->db->query("SELECT * FROM `geopos_izinler` WHERE id=$id and  (`bolum_sorumlusu`=$user_id or `genel_mudur`=$user_id or `bolum_pers_id`=$user_id or `finans_pers_id`=$user_id)");


        if($query2->num_rows()>0)
        {
            if ($query2->row()->bolum_pers_id == $user_id) //sorumlu Personel Müdür
            {
                $data = array('bolum_pers_status'=>$tip);
                $this->db->set($data);
                $this->db->where('id', $id);
                $this->db->update('geopos_izinler');
            }
            if ($query2->row()->bolum_sorumlusu == $user_id) //ofis mene
            {
                $data = array('status'=>$tip);
                $this->db->set($data);
                $this->db->where('id', $id);
                $this->db->update('geopos_izinler');
            }

            if ($query2->row()->genel_mudur == $user_id) //genel müdür
            {
                $data = array('genel_mudur_status'=>$tip);
                $this->db->set($data);
                $this->db->where('id', $id);
                $this->db->update('geopos_izinler');
            }

            if ($query2->row()->finans_pers_id == $user_id) //genel müdür
            {
                $data = array('finas_pers_status'=>$tip);
                $this->db->set($data);
                $this->db->where('id', $id);
                $this->db->update('geopos_izinler');
            }

            echo json_encode(array('status' => 'Success', 'message' => 'Başarıyla Güncellendi. Bekleyiniz...'));
        }
        else
        {
            echo json_encode(array('status' => 'Erorr', 'message' => 'Yetkiniz Yoktur'));
        }

    }


    public function ajax_emp_list(){
        $loc= $this->session->userdata('set_firma_id');
        $list = $this->db->query('SELECT geopos_employees.* FROM `geopos_accounts` 
        INNER JOIN geopos_employees ON geopos_accounts.eid = geopos_employees.id    
        INNER JOIN geopos_users ON geopos_employees.id = geopos_users.id
        WHERE geopos_employees.loc = '.$loc.' and geopos_users.banned=0 and geopos_accounts.status = 1 and geopos_accounts.eid is NOT Null

GROUP BY geopos_accounts.eid ')->result();

        $yetkili=0;
        $user_id = $this->aauth->get_user()->id;
        if($user_id==61){
            $yetkili=1;
        }
        echo json_encode(array('status' => 'Success', 'item' => $list,'yetkili'=>$yetkili));
    }

    public function ajax_emp_list_all(){
        $list = $this->employee->list_employee_active();

        echo json_encode(array('status' => 'Success', 'item' => $list));
    }


    public function projeler(){
        $loc= $this->session->userdata('set_firma_id');
        $list = $this->db->query('SELECT * FROM `geopos_projects` Where loc='.$loc)->result();
        $list_units = $this->db->query('SELECT * FROM `geopos_units` Where loc='.$loc)->result();

        echo json_encode(array('status' => 'Success', 'item' => $list,'units'=>$list_units));
    }
    public function kasalar(){
        $loc= $this->session->userdata('set_firma_id');
        $list = $this->db->query('SELECT * FROM `geopos_accounts` where status=1 and loc='.$loc)->result();

        echo json_encode(array('status' => 'Success', 'item' => $list));
    }

    public function proje_to_pers(){
        $proje_id = $this->input->post('proje_id');
        $list = $this->db->query('SELECT geopos_employees.* FROM `geopos_employees`
        Inner JOIN personel_salary ON geopos_employees.id =personel_salary.personel_id
        Inner JOIN geopos_users ON geopos_employees.id =geopos_users.id
    Where geopos_users.banned=0 and  personel_salary.status = 1 and personel_salary.proje_id ='.$proje_id)->result();

        echo json_encode(array('status' => 'Success', 'item' => $list));
    }
    public function personel_salary(){
        $user_id = $this->aauth->get_user()->id;
        if($user_id==21 || $user_id==61 || $user_id==1007 || $user_id==39 || $user_id==62){
            $id = $this->input->post('personel_id');
            $salary_details = $this->db->query("SELECT * FROM personel_salary Where personel_id = $id and status = 1")->row();
            $salary_type = $this->db->query("SELECT * FROM salary_type")->result();
            $all_proje = all_projects();
            echo json_encode(array('status' => 'Success', 'item' =>$salary_details,'salary_type'=>$salary_type,'all_proje'=>$all_proje));
        }
        else {
            echo json_encode(array('status' => 'Error', 'message'=>'Yetkiniz Yoktur'));
        }

    }

    public function salary_update(){
        $id = $this->input->post('pers_id');
        $salary = $this->input->post('salary');
        $bank_salary = $this->input->post('bank_salary');
        $net_salary = $this->input->post('net_salary');
        $salary_type = $this->input->post('salary_type');
        $salary_day = $this->input->post('salary_day');
        $salary_details = $this->db->query("SELECT * FROM personel_salary Where personel_id = $id and status = 1")->row();
        $proje_id = $this->input->post('proje_id');
        $this->db->set('status',0);
        $this->db->where('personel_id', $id);
        $this->db->update('personel_salary');

        $data=
            [
                'salary'=>$salary,
                'proje_id'=>$proje_id,
                'bank_salary'=>$bank_salary,
                'staff_id'=>$this->aauth->get_user()->id,
                'salary_type'=>$salary_type,
                'salary_day'=>$salary_day,
                'net_salary'=>$net_salary,
                'personel_id'=>$id,
            ];
        if( $this->db->insert('personel_salary', $data)){
            echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Güncellendi'));
        }
        else {
            echo json_encode(array('status' => 'Error', 'message' =>'Yöneticiye Başvurun'));
        }



    }

    public function personel_is_cikis_update(){
        $id = $this->input->post('pers_id');
        $is_cikis_desc = $this->input->post('is_cikis_desc');
        $is_cikis_date = $this->input->post('is_cikis_date');
        $hesap_kesim_date = $this->input->post('hesap_kesim_date');
        $index=0;
        $list = explode(',',$id);

        foreach ($list as $pers_id){
            $salary_details = $this->db->query("SELECT * FROM personel_salary Where personel_id = $pers_id and status = 1")->row();
            $this->db->set('status',0);
            $this->db->where('personel_id', $pers_id);
            $this->db->update('personel_salary');

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

            $this->db->insert('personel_salary', $data);
            $index++;
        }


        if($index){
            echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Güncellendi'));
        }
        else {
            echo json_encode(array('status' => 'Error', 'message' =>'Yöneticiye Başvurun'));
        }



    }

    public function personel_mezuniyet(){
        $id = $this->input->post('pers_id');
        $mezuniyet_gun = $this->input->post('mezuniyet_gun');
        $mezuniyet_start_date = $this->input->post('mezuniyet_start_date');
        $index=0;
        $list = explode(',',$id);

        foreach ($list as $pers_id){
            $salary_details = $this->db->query("SELECT * FROM personel_salary Where personel_id = $pers_id and status = 1")->row();
            $this->db->set('status',0);
            $this->db->where('personel_id', $pers_id);
            $this->db->update('personel_salary');

            $data=
                [
                    'salary'=>$salary_details->salary,
                    'proje_id'=>$salary_details->proje_id,
                    'bank_salary'=>$salary_details->bank_salary,
                    'staff_id'=>$this->aauth->get_user()->id,
                    'salary_type'=>$salary_details->salary_type,
                    'salary_day'=>$salary_details->salary_day,
                    'personel_id'=>$pers_id,
                    'mezuniyet'=>$mezuniyet_gun,
                    'mezuniyet_start_date'=>datefordatabase($mezuniyet_start_date)
                ];

            $this->db->insert('personel_salary', $data);
            $index++;
        }


        if($index){
            echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Güncellendi'));
        }
        else {
            echo json_encode(array('status' => 'Error', 'message' =>'Yöneticiye Başvurun'));
        }



    }

    public function personel_proje_update(){
        $id = $this->input->post('pers_id');
        $proje_id = $this->input->post('proje_id');
        $salary_details = $this->db->query("SELECT * FROM personel_salary Where personel_id = $id and status = 1")->row();
        $this->db->set('status',0);
        $this->db->where('personel_id', $id);
        $this->db->update('personel_salary');

        $data=
            [
                'salary'=>$salary_details->salary,
                'proje_id'=>$proje_id,
                'bank_salary'=>$salary_details->bank_salary,
                'staff_id'=>$this->aauth->get_user()->id,
                'salary_type'=>$salary_details->salary_type,
                'salary_day'=>$salary_details->salary_day,
                'personel_id'=>$id,
            ];
        if( $this->db->insert('personel_salary', $data)){
            echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Güncellendi'));
        }
        else {
            echo json_encode(array('status' => 'Error', 'message' =>'Yöneticiye Başvurun'));
        }


    }

    public function personel_prim_talep(){
        $id = $this->input->post('pers_id');
        $filed_upload = $this->input->post('filed_upload');
        $type = $this->input->post('type');
        $tutar = $this->input->post('tutar');
        $hesaplanan_ay = $this->input->post('hesaplanan_ay_');
        $aciklama = $this->input->post('aciklama');
        $proje_muduru = $this->input->post('proje_muduru');
        $proje_id_modal = $this->input->post('proje_id_modal');
        $index=0;
        $list = explode(',',$id);

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
            echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Oluşturuldu'));
        }
        else {
            echo json_encode(array('status' => 'Error', 'message' =>'Yöneticiye Başvurun'));
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
          $pers_id = $this->input->post('pers_id');


          $list = explode(',',$pers_id);
            $holder='';
            $acid_id =0;
            $send_sms = $this->input->post('send_sms');
            if(isset($acid)){
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

                    'debit' => 0, // eklenecek

                    'credit' => 0, //eklenecek

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
                    if($method==3){
//                        $data = array(
//
//                            'csd' => $pers_id,
//
//                            'payer' => personel_details_full($pers_id)['name'],
//
//                            'acid' => $acid_id, //hesapID ekleneck
//
//                            'account' => $holder, //hesap adı ekelenecek
//
//                            'invoicedate' => date('Y-m-d'),
//                            'maas_ay' => date('m'),
//                            'maas_yil' => date('Y'),
//
//                            'invoiceduedate' => date('Y-m-d'),
//
//                            'debit' => 0, // eklenecek
//
//                            'credit' => 0, //eklenecek
//
//                            'total' => $tutar_expense,
//
//                            //'type' => $pay_type, // income expense
//                            'invoice_type_id'=>14,
//
//                            'invoice_type_desc'=>invoice_type_desc(14),
//
//                            //'cat' => $pay_cat,
//
//                            'method' => $method, //ödeme metodu ekelenecek
//
//                            'eid' => $this->aauth->get_user()->id, //user_id
//                            'cari_pers_type' => 2,
//
//                            'notes' => $aciklama_expense,
//                            'ext' => $image
//
//                        );
//
//                        $this->db->insert('geopos_invoices', $data);
                    }
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
                        $this->mesaj_gonder( personel_detailsa($pers_id)['phone'],$aciklama_expense.' Cəmi : '.amountFormat($tutar_expense));
                    }
                }
            }

            if($j){
                echo json_encode(array('status' => 'Success', 'message' =>'Başarıyla Oluşturuldu'));
            }
            else {
                echo json_encode(array('status' => 'Error', 'message' =>'Yöneticiye Başvurun'));
            }

    }


    public function personel_credit_report(){
        $credit_id = $this->input->post('credit_id');
        $list = $this->employee->get_datatables_personel_credit($credit_id);

        $data = array();



        $no = $this->input->post('start');

        $this->session->set_userdata('test', 1);


        $i = 1;
        foreach ($list as $invoices) {
            $status='Bekliyor';
            if($invoices->status==2){
               $status='Ödendi';
            }
            $row = array();
            $row[] = $invoices->vade_date;
            $row[] =  amountFormat($invoices->total);
            $row[] =  account_type_sorgu($invoices->method);
            $row[] = $status;
            $data[] = $row;

            $i++;

        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->employee->count_personel_credit_all($credit_id),

            "recordsFiltered" => $this->employee->count_personel_credit_filter($credit_id),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);

    }

    public function mezuniyet_sil(){
        $this->db->trans_start();
        $id = $this->input->post('talep_id');
        if($this->db->delete('salary_grad', array('id' => $id))){
            $this->aauth->applog("Mezuninet Silindi : " . $id, $this->aauth->get_user()->username);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Silindi",'index'=>'/arac/index'));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }
    }



}
