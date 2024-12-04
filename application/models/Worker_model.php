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
class Worker_model extends CI_Model
{

    var $doccolumn_search = array('title', 'cdate');
    var $column_search = array('worker_list.name', 'worker_list.salary_day', 'worker_list.country','worker_list.address','worker_list.phone','worker_list.fin_no','worker_list.seri_no','worker_list.region','worker_list.job','geopos_employees.name');
    var $column_order = array(null, 'worker_list.name', 'worker_list.phone','worker_list.fin_no','worker_list.seri_no','worker_list.region','worker_list.job','worker_list.sorumlu_pers_id');

    var $column_search_run =array('worker_run.aciklama','worker_run.birim_fiyati','worker_run.miktar','worker_run.calisma_gunu','geopos_projects.code','worker_list.name');
    var $column_order_run =array(null,'worker_run.id','worker_list.name','geopos_projects.code',null);

    var $order = array('geopos_employees_p.id' => 'DESC');
    public function create_save(){
        $name = $this->input->post('name');
        $salary_day = $this->input->post('salary_day');
        $job = $this->input->post('job');
        $loc_id = $this->input->post('loc_id');
        $sorumlu_pers_id = $this->input->post('sorumlu_pers_id');
        $vatandaslik = $this->input->post('vatandaslik');
        $country = $this->input->post('country');
        $region = $this->input->post('region');
        $city = $this->input->post('city');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $fin_no = $this->input->post('fin_no');
        $seri_no = $this->input->post('seri_no');
        $data_users = array(
            'name' => $name,
            'salary_day' => $salary_day,
            'loc_id' => $loc_id,
            'job' => $job,
            'sorumlu_pers_id' => $sorumlu_pers_id,
            'vatandaslik' => $vatandaslik,
            'country' => $country,
            'region' => $region,
            'city' => $city,
            'address' => $address,
            'phone' => $phone,
            'fin_no' => $fin_no,
            'seri_no' => $seri_no,
            'aauth_id' => $this->aauth->get_user()->id,
            'picture'=>'example.png'
        );
        if ($this->db->insert('worker_list', $data_users)) {
            $last_id = $this->db->insert_id();

            // cari tablosuna gizli cari ekleeme

                $data_cari = array(
                   'name'=>$name,
                   'company'=>$name,
                   'loc'=>$loc_id,
                   'active'=>0,
                );
                $this->db->insert('geopos_customers', $data_cari);
                $cari_id = $this->db->insert_id();

                $data_update=
                    [
                        'cari_id' => $cari_id,
                    ];
                $this->db->set($data_update);
                $this->db->where('id', $last_id);
                $this->db->update('worker_list', $data_update);

            // cari tablosuna gizli cari ekleeme
            $this->aauth->applog("Fehle Kartı : ".$name, $this->aauth->get_user()->username);
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Fehle Kartı Oluşturuldu',
                'id'=>$last_id
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Kayıt Oluşurken Hata Aldınız'
            ];
        }
    }

    public function update_time_out()
    {
        $run_id = $this->input->post('run_id');
        $cikis_saati = $this->input->post('cikis_saati');
        $data=
            [
                'cikis_saati' => $cikis_saati,
            ];
        $this->db->set($data);
        $this->db->where('id', $run_id);
        if ($this->db->update('worker_run', $data)) {
            $this->aauth->applog("Çıkış Saati Güncellendi : ".$run_id, $this->aauth->get_user()->username);
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Güncellendi'
            ];

        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }
    }

    public function update(){

        $user_id = $this->input->post('personel_id');
        $name = $this->input->post('name');
        $salary_day = $this->input->post('salary_day');
        $job = $this->input->post('job');
        $loc_id = $this->input->post('loc_id');
        $sorumlu_pers_id = $this->input->post('sorumlu_pers_id');
        $vatandaslik = $this->input->post('vatandaslik');
        $country = $this->input->post('country');
        $region = $this->input->post('region');
        $city = $this->input->post('city');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $fin_no = $this->input->post('fin_no');
        $seri_no = $this->input->post('seri_no');

        $data=
            [
                'name' => $name,
                'salary_day' => $salary_day,
                'loc_id' => $loc_id,
                'job' => $job,
                'sorumlu_pers_id' => $sorumlu_pers_id,
                'vatandaslik' => $vatandaslik,
                'country' => $country,
                'region' => $region,
                'city' => $city,
                'address' => $address,
                'phone' => $phone,
                'fin_no' => $fin_no,
                'seri_no' => $seri_no
            ];
        $this->db->set($data);
        $this->db->where('id', $user_id);
        if ($this->db->update('worker_list', $data)) {
            $this->aauth->applog("Fehle Güncellendi : ".$name, $this->aauth->get_user()->username);
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Personel Kartı Oluşturuldu'
            ];

        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }

    }

    public function list()
    {
        $this->_list();
        if ($_POST['length'] != -1) $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function _list()
    {
        $this->db->select('worker_list.*, geopos_employees.name as sorumlu_personel');
        $this->db->from('worker_list');
        $this->db->join('geopos_employees', 'worker_list.sorumlu_pers_id = geopos_employees.id');
        if($this->session->userdata('set_firma_id')){
            $this->db->where('worker_list.loc_id =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
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
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else {
            $this->db->order_by('`worker_list`.`id` DESC');
        }
    }
    public function count_all()
    {
        $this->_list();
        return $this->db->count_all_results();
    }
    public function count_filtered()
    {
        $this->_list();
        $query = $this->db->get();
        return $query->num_rows();
    }



    public function list_aauth()
    {
        $this->_list_aauth();
        if ($_POST['length'] != -1) $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function _list_aauth()
    {
        $this->db->select('worker_run.*, worker_list.name');
        $this->db->from('worker_run');
        $this->db->join('worker_list', 'worker_run.pers_id = worker_list.id');
        $this->db->join('geopos_projects', 'worker_run.proje_id = geopos_projects.id');
        if($this->session->userdata('set_firma_id')){
            $this->db->where('worker_list.loc_id =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $i = 0;
        foreach ($this->column_search_run as $item) // loop column

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

                if (count($this->column_search_run) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->column_order_run[$search['0']['column']], $search['0']['dir']);
        } else {
            $this->db->order_by('`worker_list`.`id` DESC');
        }
    }
    public function count_all_aauth()
    {
        $this->_list();
        return $this->db->count_all_results();
    }
    public function count_filtered_aauth()
    {
        $this->_list_aauth();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function details($id){
        $this->db->select('*');
        $this->db->from('worker_list');
        if($this->session->userdata('set_firma_id')){
            $this->db->where('worker_list.loc_id =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function details_get_all($id){

        $str = implode(",",$id);
        $this->db->select('*');
        $this->db->from('worker_list');
        if($this->session->userdata('set_firma_id')){
            $this->db->where('worker_list.loc_id =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $this->db->where_in('id',$id);
        $query = $this->db->get();
        return $query->result();
    }
    public function editpicture($id, $pic)
    {

        $this->db->select('picture');
        $this->db->from('worker_list');
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();

        @unlink(FCPATH . 'userfiles/employee/'. $result['picture']);
        @unlink(FCPATH . 'userfiles/employee/thumbnail/'.$result['picture']);



        $data = array(
            'picture' => $pic
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('worker_list')) {
            return 1;

        }
        else
        {
            return 0;
        }


    }

    public function document_datatables($cid)

    {

        $this->document_datatables_query($cid);

        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }



    private function document_datatables_query($cid)

    {


        $this->db->select('*');

        $this->db->from('worker_document');

        $this->db->where('fid',$cid);

        $this->db->where('rid',1);

        $i = 0;



        foreach ($this->doccolumn_search as $item) // loop column

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



                if (count($this->doccolumn_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



    }



    function document_count_filtered($cid)

    {

        $this->document_datatables_query($cid);

        $query = $this->db->get();

        return $query->num_rows();

    }




    public function document_count_all($cid)

    {

        $this->document_datatables_query($cid);

        $query = $this->db->get();

        return $query->num_rows();

    }


    public function create_file(){
        $personel_id = $this->input->post('personel_id');
        $baslangic_date = $this->input->post('baslangic_date');
        $bitis_date = $this->input->post('bitis_date');
        $title = $this->input->post('title');
        $file_type = $this->input->post('file_type');
        $arac_id = $this->input->post('arac_id');
        $image_text = $this->input->post('image_text');
        $data = array(
            'baslangic_date' => $baslangic_date,
            'file_type' => $file_type,
            'arac_id' => $arac_id,
            'bitis_date' => $bitis_date,
            'title' => $title,
            'filename' => $image_text,
            'cdate' => date('Y-m-d'),
            'cid'=>$this->aauth->get_user()->id,
            'fid'=>$personel_id,'rid'=>1
        );
        if( $this->db->insert('worker_document', $data)){
            return [
                'status'=>1,
                'message'=>'Başarıyla Dosya Eklenmiştir'
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }
    }

    public function deletedocument()
    {
        $id = $this->input->post('id');
        $this->db->select('filename');
        $this->db->from('worker_document');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        if ($this->db->delete('worker_document', array('id' => $id))) {
            @unlink(FCPATH .'userfiles/documents/' . $result['filename']);
            $this->aauth->applog("[Personel Dosyası Silindi]  Dosya ID $id PersonelID ",$this->aauth->get_user()->username);
            return [
                'status'=>1,
                'message'=>'Başarıyla Silinmiştir'
            ];
        } else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }
    }

    public function create_worker()
    {
        $productlist=array();
        $prodindex=0;
        $product_details=$this->input->post('product_details');
        foreach ($product_details as $items){
            $data = array(
                'code' => numaric(52),
                'pers_id' => $items['pers_id'],
                'birim_fiyati' => $items['birim_fiyati'],
                'miktar' => $items['miktar'],
                'birim' => $items['birim'],
                'tip' => $items['tip'],
                'odeme_tipi' => $items['odeme_tipi'],
                'proje_id' => $items['proje_id'],
                'calisma_gunu' => $items['calisma_gunu'],
                'giris_saati' => $items['giris_saati'].':00',
                'aciklama' => $items['aciklama'],
                'aauth_id' => $this->aauth->get_user()->id,
                'status' => 1,//Aktif
                'forma2_id' => 0 // Forma2 bağlandığında buraya kayıt gelmeli
            );
            $productlist[$prodindex] = $data;
            $prodindex++;
            numaric_update(52);
        }
        if ($prodindex > 0) {
            $this->db->insert_batch('worker_run', $productlist);
            return [
                'status'=>1,
                'message'=>'Başarıyla İşlenmiştir.Detayları Cari Kart Bölümünden Aktif Fehle Bölümünden Görebilirsiniz'
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }



    }

    public function create_forma2()
    {
        $run_details=$this->input->post('run_details'); //run_id
        $bolum_id=$this->input->post('bolum_id');
        $proje_id=$this->input->post('proje_id');
        $pers_id=$this->input->post('pers_id');
        $asama_id=$this->input->post('asama_id');
        $aciklama=$this->input->post('aciklama');
        $forma_2_tarihi=$this->input->post('forma_2_tarihi');

        $cikis_saat_count =0;
        foreach ($run_details as $items){
            $kontrol = $this->db->query("SELECT * FROM worker_run Where id = $items")->row();
            if(!$kontrol->cikis_saati){
                $cikis_saat_count++;
            }
        }
        if($cikis_saat_count){
            return [
                'status'=>0,
                'message'=>'Seçilen Bazı Fehlelerin Çıkış Saatleri Girilmemiştir.'
            ];
        }

        //forma2 oluşturma

        $kontrol = $this->db->query("SELECT * FROM worker_run Where id = $items")->row();

        $fehle_details = $this->details($pers_id);
        $proje_details = proje_details($kontrol->proje_id);

        $bill_date = datefordatabase($forma_2_tarihi);
        $invoice_no=numaric(8);
        $data = array(
            'invoicedate' => $bill_date,
            'proje_sorumlu_id' => $proje_details->proje_sorumlusu_id,
            'proje_muduru_id' => $proje_details->proje_muduru_id,
            'genel_mudur_id' => $proje_details->genel_mudur_id,
            'invoice_type_id' => 29,
            'invoice_type_desc' => invoice_type_id(29),
            'notes' => $aciklama,
            'muqavele_no' => '',
            'csd' => $fehle_details->cari_id,
            'eid' => $this->aauth->get_user()->id,
            'sorumlu_pers_id' => $this->aauth->get_user()->id,
            'refer' => '99',
            'invoice_no' => $invoice_no,
            'taxstatus' => 'no',
            'tax_oran' => 0,
            'loc' => $this->session->userdata('set_firma_id'),
            'method' => 1,
            'proje_id' => $proje_id,
            'para_birimi' => 1,
            'payer' => customer_details($fehle_details->cari_id)['name'],

        );
        if ($this->db->insert('geopos_invoices', $data)) {
            $forma_2_id = $this->db->insert_id();
            numaric_update(8);
            $productlist = [];
            $prodindex = 0;
            $sub_total=0;
            foreach ($run_details as $items_value){

                $run_id = $items_value;
                $run_details_row =  $this->db->query("Select * from worker_run WHERE id=$run_id")->row();

                $calisma_tipi = "Saatlik";
                if($run_details_row->tip==1) {   $calisma_tipi = "Günlük";}
                $calisma_miktari=amountFormat_s($run_details_row->miktar).' '.units_($run_details_row->birim)['name'];


                $total=$run_details_row->birim_fiyati*$run_details_row->miktar;
                $data=[
                    'tid' => $forma_2_id,
                    'pid'=>0,
                    'product'=>'Fehle Hizmeti - '.$run_details_row->aciklama,
                    'item_desc'=>$calisma_tipi.' | '.$run_details_row->calisma_gunu.' | '.$run_details_row->giris_saati.' | '.$run_details_row->cikis_saati,
                    'qty'=>$run_details_row->miktar,
                    'price'=>$run_details_row->birim_fiyati,
                    'subtotal'=>$total,
                    'unit'=>$run_details_row->birim,
                    'bolum_id' => $bolum_id,
                    'asama_id' => $asama_id,
                    'invoice_type_id' => 29,
                    'proje_id' => $proje_id,
                    'invoice_type_desc' => invoice_type_id(29)
                ];
                $productlist[$prodindex] = $data;
                $prodindex++;
                $sub_total+=$total;

                //worker_run_status güncelleme

                $this->db->set(
                    array
                    (
                        'status' => 2,
                    )
                );

                $this->db->where('id', $run_id);
                $this->db->update('worker_run');

                //worker_run_status güncelleme
            }
            if ($prodindex > 0) {
                $this->db->insert_batch('geopos_invoice_items', $productlist);
                $this->db->set(
                    array
                    (
                        'subtotal' => $sub_total,
                        'tax' => 0,
                        'total' =>  $sub_total,
                        'items' => 0
                    )
                );

                $this->db->where('id', $forma_2_id);
                $this->db->update('geopos_invoices');

                //forma2 bağlama
                foreach ($run_details as $items_value){
                    $this->db->set(
                        array
                        (
                            'forma2_id' => $forma_2_id,
                        )
                    );

                    $this->db->where('id', $items_value);
                    $this->db->update('worker_run');
                }
                //forma2 bağlama
                return [
                    'status'=>1,
                    'message'=>'Başarılı Bir Şekilde forma 2 Oluşturuldu : '.$invoice_no,
                    'id'=>$forma_2_id
                ];

            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Herhangi bir fehle bulunamadı'
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız'
            ];
        }
        //forma2 oluşturma




    }



}