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



use Mike42\Escpos\PrintConnectors\FilePrintConnector;

use Mike42\Escpos\Printer;



class Qaime extends CI_Controller

{
    public function __construct()

    {
        parent::__construct();


        $this->load->library("Aauth");
        $selected_db = $this->session->userdata('selected_db');
        if (!empty($selected_db)) {
            $this->db = $this->load->database($selected_db, TRUE);
        }
        $this->load->model('qaime_model', 'invocies');
        $this->load->model('communication_model');
        $this->load->helper('cookie');
        $this->load->model('plugins_model', 'plugins');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(1)) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        if (!$this->aauth->premission(16)) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }
        if ($this->aauth->get_user()->roleid == 2) {
            $this->limited = $this->aauth->get_user()->id;
        } else {
            $this->limited = '';
        }

    }


    public function index()
    {
        $head['title'] = "Fatura Listesi";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('qaime/index');
        $this->load->view('fixed/footer');
    }
    public function ajax_list()
    {
        $list = $this->invocies->get_datatables($this->limited);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {

            $button_view="<a class='btn btn-outline-secondary'  target='_blank' href='/qaime/view/$invoices->id'><i class='fa fa-eye'></i></a>";
            $button_pers="<a class='btn btn-outline-secondary' target='_blank' href='/employee/view?id=$invoices->eid'><i class='fa fa-user'></i></a>";

            $proje_name = proje_name($invoices->proje_id);
            $notes = 'Proje Adı : ' . $proje_name . ' &#013;Not : ' . $invoices->notes;
            $tool = "data-toggle='tooltip' data-placement='top' data-html='true' title='$notes'";
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='form-control invoice_ids' name='invoice_ids[]' value='$invoices->id'>";
            $row[] = date_izin($invoices->invoicedate);
            $row[] = invoice_type_id($invoices->invoice_type_id);
            $row[] = "<a class='btn btn-outline-secondary'  target='_blank' href='/qaime/view/$invoices->id' >" . "<span data-toggle='tooltip' data-placement='top' data-html='true' title='" . $notes . "'>" . $invoices->invoice_no . "</span></a>";
            $row[] = "<a class='btn btn-outline-secondary'  target='_blank' href='/projects/explore?id=$invoices->proje_id' >" . proje_code($invoices->proje_id) . "</a>";
            $row[] = "<a class='btn btn-outline-secondary'  target='_blank' href='/customers/view?id=$invoices->csd' >" . $invoices->name . "</a>";
            $row[] = $invoices->notes;
            $row[] = amountFormat(($invoices->subtotal - $invoices->discount), $invoices->para_birimi);
            $row[] = amountFormat($invoices->tax, $invoices->para_birimi);
            $row[] = amountFormat($invoices->total, $invoices->para_birimi);
            $row[] = '<span class="st-' . $invoices->status . '">' . invoice_status_ogren($invoices->status) . '</span>';
            $row[] = customer_details($invoices->alt_cari_id)['company'];
            $row[] = $button_view.' &nbsp;'.$button_pers;
            $data[] = $row;
        }

        // JSON çıktısı oluşturma
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->invocies->count_all($this->limited),
            "recordsFiltered" => $this->invocies->count_filtered($this->limited),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function view($id)
    {


        $details=$this->invocies->details($id);
        $head['title'] = "Fatura Görüntüle - ".$details->invoice_no;
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['invoice']=$details;
        $data['note_list']=new_list_note(2,$id);
        $data['customer_details']=customer_details_res($details->csd);
        $data['products'] = $this->invocies->productsdetails($id,$details->invoice_type_id);
        $content = '<table class="table notestable" style="text-align: center;">
    <thead class="notesthead" id="notesthead">
        <tr>
            <th>Personel</th>
            <th>Not</th>
            <th>Oluşturma Tarihi</th>
            <th>İşlem</th>
        </tr>
    </thead>
    <tbody class="notestbody">';
        if (new_list_note(2,$id)) {
            foreach (new_list_note(2,$id) as $list) {
                $content .= '<tr class="notestr">
            <td>' . $list->name . '</td>
            <td>' . $list->notes . '</td>
            <td>' . $list->created_at . '</td>
            <td><button class="delete_not_new btn btn-danger" note_id="' . $list->id . '" type="button">SİL</button></td>
        </tr>';
            }
        }
        $content .= '</tbody></table>';
        $data['content']=$content;
        $this->load->view('fixed/header', $head);
        $this->load->view('qaime/view',$data);
        $this->load->view('fixed/footer');
    }

    public function createall()
    {
        $head['title'] = "Fatura Oluştur";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('qaime/createall');
        $this->load->view('fixed/footer');
    }
    public function create($id){
        $head['title'] = "Yeni Qaime";
        $data['invoice_type_id']=$id;
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('qaime/create',$data);
        $this->load->view('fixed/footer');
    }

    public function edit($id)
    {
        $details=$this->invocies->details($id);
        $head['title'] = "Fatura Görüntüle - ".$details->invoice_no;
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['invoice_type_id']=$details->invoice_type_id;
        $data['search_input_nakliye']=$this->invocies->get_search_input_nakliye($id);
        $data['search_input_forma2']=$this->invocies->get_search_input_forma_2($id);

        $data['invoice']=$details;
        $data['customer_details']=customer_details_res($details->csd);
        $data['products'] = $this->invocies->productsdetails($id,$details->invoice_type_id);
        $this->load->view('fixed/header', $head);
        $this->load->view('qaime/edit',$data);
        $this->load->view('fixed/footer');
    }

    public function create_save(){
        if (!$this->aauth->premission(1)->write) {
            echo json_encode(array('status' => 410, 'message' => "Yetkiniz Mevcut değil"));
        }
        $this->db->trans_start();
        $result = $this->invocies->create_save();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => $result['message'], 'index' => '/qaime/view/' . $result['id']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => $result['message']));
        }
    }

    public function update_save(){
        if (!$this->aauth->premission(1)->write) {
            echo json_encode(array('status' => 410, 'message' => "Yetkiniz Mevcut değil"));
        }
        $this->db->trans_start();
        $result = $this->invocies->update_save();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => $result['message'], 'index' => '/qaime/view/' . $result['id']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => $result['message']));
        }
    }

    public function search_cari_to_nakliye()
    {
        // GET ile gelen parametreleri al
        $search = $this->input->get('search', TRUE);
        $cari_id = $this->input->get('cari_id', TRUE);

        // Parametre kontrolü: cari_id boşsa hata döner
        if (empty($cari_id)) {
            echo json_encode(array('status' => 400, 'message' => 'CSD ID gerekli.'));
            return;
        }

        $talep_details = [];

        // Ana sorgu: JOIN kullanarak iki tabloyu birleştiriyoruz
        $this->db->select('t1.form_id, t2.code');
        $this->db->from('talep_form_nakliye_products t1');
        $this->db->join('talep_form_nakliye t2', 't1.form_id = t2.id', 'left');
        $this->db->where('t1.cari_id', $cari_id);

        // Arama işlemi: t2.code alanında LIKE kullanılır
        if (!empty($search)) {
            $this->db->like('t2.code', $search );
        }

        // Grup ve sıralama işlemleri
        $this->db->group_by('t1.form_id'); // form_id'ye göre gruplama
        $this->db->order_by('t1.form_id', 'DESC');

        // Sorguyu çalıştır
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            // Sonuçları döngüyle işleyerek array'e ekle
            foreach ($query->result() as $row) {
                $talep_details[] = [
                    'id' => $row->form_id,
                    'code' => $row->code
                ];
            }

            // JSON yanıtı: başarılı
            echo json_encode(array('status' => 200, 'data' => $talep_details));
        } else {
            // JSON yanıtı: sonuç bulunamadı
            echo json_encode(array('status' => 404, 'message' => 'Nakliye Bulunamadı'));
        }
    }

    public function search_cari_to_forma_2()
    {
        // GET ile gelen parametreleri al
        $search = $this->input->get('search', TRUE);
        $cari_id = $this->input->get('cari_id', TRUE);

        // Parametre kontrolü: cari_id boşsa hata döner
        if (empty($cari_id)) {
            echo json_encode(array('status' => 400, 'message' => 'CSD ID gerekli.'));
            return;
        }

        $talep_details = [];

        // Ana sorgu: JOIN kullanarak iki tabloyu birleştiriyoruz
        $this->db->select('id,invoice_no');
        $this->db->from('geopos_invoices');
        $this->db->where('csd', $cari_id);
        $this->db->where_in('invoice_type_id', [29,30]);
        $this->db->where('status !=', 3);

        // Arama işlemi: t2.code alanında LIKE kullanılır
        if (!empty($search)) {
            $this->db->like('invoice_no', $search );
        }

        $this->db->order_by('id', 'DESC');
        // Sorguyu çalıştır
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Sonuçları döngüyle işleyerek array'e ekle
            foreach ($query->result() as $row) {
                $talep_details[] = [
                    'id' => $row->id,
                    'code' => $row->invoice_no
                ];
            }

            // JSON yanıtı: başarılı
            echo json_encode(array('status' => 200, 'data' => $talep_details));
        } else {
            // JSON yanıtı: sonuç bulunamadı
            echo json_encode(array('status' => 404, 'message' => 'Forma 2 Bulunamadı'));
        }
    }

    public function get_selected_nakliye()
    {
        $invoice_id = $this->input->post('invoice_id');
        $this->db->select('talep_form_nakliye.id, talep_form_nakliye.code');
        $this->db->from('nakliye_to_invoice');
        $this->db->join('talep_form_nakliye', 'nakliye_to_invoice.nakliye_id = talep_form_nakliye.id', 'left');
        $this->db->where('nakliye_to_invoice.invoice_id', $invoice_id); // Kullanıcı bazlı filtre
        $query = $this->db->get();


        $results = [];
        foreach ($query->result() as $row) {
            $results[] = ['id' => $row->id, 'text' => $row->code];
        }

        // JSON formatında döndür
        echo json_encode($results);
    }

    public function get_payinvoice_form_data(){

        $invoice_details = $this->invocies->details($this->input->get('invoice_id'));
        $rming = $invoice_details->total - $invoice_details->pamnt;
        $data = [
            'rming' => $rming, // Ödenmesi gereken tutar
            'para_birimi' => para_birimi(), // Para birimi listesi
            'invoice_type_desc' => invoice_type_desc($invoice_details->invoice_type_id), // Fatura açıklaması
            'invoice_no' => $invoice_details->invoice_no,
            'invoice_id' => $invoice_details->id,
            'csd' => $invoice_details->csd,
            'account_types' => account_type_islem(), // Hesap türleri
        ];
        echo json_encode($data);
    }

    public function get_invoice_status(){
        $statuses = invoice_status(); // Durumları getir
        echo json_encode($statuses);
    }

    public function qaime_onay()
    {
        $this->db->trans_start();
        $result = $this->invocies->qaime_onay();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => $result['message']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => $result['message']));
        }
    }

    public function ajax_list_history(){

        $talep_id=$this->input->post('talep_id');

        $list = $this->invocies->ajax_list_history($talep_id);
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
            "recordsTotal" => $this->invocies->count_all_talep_history($talep_id),
            "recordsFiltered" => $this->invocies->count_filtered_talep_history($talep_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function search_products()
    {
        $query = $this->input->post('query');
        $invoice_type_id = $this->input->post('invoice_type_id');
        $keyword = $this->db->escape_like_str($query);

        if (strlen($query) < 3) {
            echo json_encode(['success' => false, 'message' => 'En az 3 harf giriniz.']);
            return;
        }

        if($invoice_type_id==24 || $invoice_type_id==41){
            $query = $this->db->query("
                SELECT  
    dg1.id AS product_id,
    '' AS images,
    CONCAT(dg2.name,' -> ',dg1.name) as product_name,
    '' AS varyasyon,
    0 AS product_stock_code_id,
    0 AS code,
    dg1.demirbas_id as demirbas_id
FROM demirbas_group AS dg1
LEFT JOIN demirbas_group AS dg2 
    ON dg1.demirbas_id = dg2.id
WHERE dg1.demirbas_id != 0 
  AND dg1.name LIKE '$keyword%'
ORDER BY dg1.id DESC
LIMIT 100;

            ");
        }
        else {
            $query = $this->db->query(
                "SELECT 
    geopos_products.pid AS product_id,
    geopos_products.image AS images,
    geopos_products.product_name AS product_name,
    IF(product_stock_code.id, product_stock_code.code, 'varyasyon tanımlanmamış') AS varyasyon,
    IF(product_stock_code.id, product_stock_code.id, 0) AS product_stock_code_id,
    product_stock_code.code,
    0 as demirbas_id
FROM geopos_products
LEFT JOIN product_stock_code ON geopos_products.pid = product_stock_code.product_id
LEFT JOIN geopos_products_parent ON geopos_products_parent.product_stock_code_id = product_stock_code.id
WHERE geopos_products.deleted_at IS NULL
  AND (
      geopos_products_parent.tag LIKE '$keyword%' OR
      geopos_products.tag LIKE '$keyword%' OR
      product_stock_code.code LIKE '$keyword%' OR
      geopos_products.product_name LIKE '$keyword%' OR
      geopos_products.product_name_tr LIKE '$keyword%' OR
      geopos_products.product_name_en LIKE '$keyword%' OR
      geopos_products.product_code LIKE '$keyword%' OR
      geopos_products.barcode LIKE '$keyword%'
  )
GROUP BY product_stock_code.id
ORDER BY geopos_products.pid DESC
LIMIT 100;"
            );
        }


        //CONCAT(geopos_products.product_name, ' ', geopos_products.product_name_tr, ' ', geopos_products.product_name_en) AS product_name,
        if ($query->num_rows() > 0) {
            echo json_encode(['success' => true, 'results' => $query->result()]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Sonuç bulunamadı.']);
        }
    }

    public function reverseonay(){
        $this->db->trans_start();
        $result = $this->invocies->reverseonay();
        if ($result['status']) {
            echo json_encode(array('status' => 200, 'message' => $result['message']));
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' => $result['message']));
        }
    }

}


