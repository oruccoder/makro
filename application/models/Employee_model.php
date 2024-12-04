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

class Employee_model extends CI_Model
{



    var $doccolumn_order = array(null, 'title', 'cdate', null);

    var $doccolumn_search = array('title', 'cdate');

    var $credit_search = array('vade_date', 'total');
    var $credit_order = array('vade_date', 'total','method','status');


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

        $this->db->from('geopos_documents_pers');

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


    function adddocument($title, $filename,$cid,$baslangic_date,$bitis_date,$file_type=0,$arac_id=0)

    {   $this->aauth->applog("[Personele Dosya Eklendi ]  Dosya ID $title Personel ID ".$cid,$this->aauth->get_user()->username);

        $data = array('baslangic_date' => $baslangic_date,'file_type' => $file_type,'arac_id' => $arac_id,'bitis_date' => $bitis_date,'title' => $title, 'filename' => $filename, 'cdate' => date('Y-m-d'),'cid'=>$this->aauth->get_user()->id,'fid'=>$cid,'rid'=>1);

        return $this->db->insert('geopos_documents_pers', $data);



    }

    function deletedocument($id,$cid)

    {

        $this->db->select('filename');

        $this->db->from('geopos_documents_pers');

        $this->db->where('id', $id);

        $query = $this->db->get();

        $result = $query->row_array();

        if ($this->db->delete('geopos_documents_pers', array('id' => $id))) {



            unlink(FCPATH .'userfiles/documents/' . $result['filename']);

            $this->aauth->applog("[Personel Dosyası Silindi]  Dosya ID $id PersonelID ".$cid,$this->aauth->get_user()->username);

            return true;

        } else {

            return false;

        }



    }

    public function document_count_all($cid)

    {

        $this->document_datatables_query($cid);

        $query = $this->db->get();

        return $query->num_rows();

    }

    public function list_employee()
    {
        $this->db->select('geopos_employees.*,geopos_users.banned,geopos_users.roleid ,geopos_users.loc,geopos_projects.name as proje_name');
        $this->db->from('geopos_employees');
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id');
        $this->db->join('personel_salary', 'personel_salary.personel_id = geopos_users.id','left');
        $this->db->join('geopos_projects', 'personel_salary.proje_id = geopos_projects.id','left');
        $this->db->where('geopos_users.banned', 0);
        $this->db->where('personel_salary.status', 1);
        $this->db->order_by('geopos_users.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function list_employee_active()
    {
        $loc= $this->session->userdata('set_firma_id');
        $this->db->select('geopos_employees.*,geopos_users.banned,geopos_users.roleid ,geopos_users.loc');
        $this->db->from('geopos_employees');
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');
        $this->db->where('geopos_employees.calisma_sekli', 1);
        $this->db->where('geopos_employees.loc', $loc);
        $this->db->where('geopos_users.banned', 0);
        $this->db->order_by('geopos_users.id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
        public function list_employee_active_result()
    {
        $this->db->select('geopos_employees.*,geopos_users.banned,geopos_users.roleid ,geopos_users.loc');
        $this->db->from('geopos_employees');
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id', 'left');
        $this->db->where('geopos_employees.calisma_sekli', 1);
        $this->db->where('geopos_users.banned', 0);
        $this->db->order_by('geopos_users.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function list_project_employee($id)
    {
        $this->db->select('geopos_employees.*');
        $this->db->from('geopos_project_meta');
        $this->db->where('geopos_project_meta.pid', $id);
        $this->db->where('geopos_project_meta.meta_key', 19);
        $this->db->join('geopos_employees', 'geopos_employees.id = geopos_project_meta.meta_data', 'left');
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id');
        $this->db->where('geopos_users.banned', 0);
        $this->db->order_by('geopos_users.roleid', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function employee_details($id)
    {
        $this->db->select('geopos_employees.*,geopos_users.email,geopos_users.loc,geopos_users.roleid,geopos_users.date_created');
        $this->db->from('geopos_employees');
        $this->db->join('geopos_users', 'geopos_employees.id = geopos_users.id');
        $this->db->where('geopos_employees.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function salary_history($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_hrm');
        $this->db->where('typ',1);
        $this->db->where('rid',$id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_employee($id, $name,$roleid, $phone, $phonealt, $address, $city, $region, $country,
                                    $postbox,$location,$salary=0,$department=-1,$commission,$date_created,$calisma_sekli,
                                    $sozlesme_turu,$sozlesme_date,$resmi_maas,$gayri_resmi_maas,
                                    $vatandaslik,$cinsiyet,$birthdays,$medeni_durumu,$cocuk_durumu,
                                    $kan_grubu,$fin_no,$sorumlu_pers_id,$ayrilma_tarihis,$ayrilma_sebebi,$sorumlu_kisi,$firma_durumu,$birim,$salary_type,$salary_gunluk,$proje_id)
    {
        $this->db->select('salary');
        $this->db->from('geopos_employees');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $sal= $query->row_array();



        $data = array(
            'name' => $name,
            'phone' => $phone,
            'phonealt' => $phonealt,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox,
            'salary' => $salary,
            'dept' => $department,
            'c_rate' => $commission,
            'calisma_sekli' => $calisma_sekli,
            'sozlesme_turu' => $sozlesme_turu,
            'sozlesme_date' => $sozlesme_date,
            'resmi_maas' => $resmi_maas,
            'gayri_resmi_maas' => $gayri_resmi_maas,
            'vatandaslik' => $vatandaslik,
            'cinsiyet' => $cinsiyet,
            'salary_type' => $salary_type,
            'birthday' => $birthdays,
            'medeni_durumu' => $medeni_durumu,
            'cocuk_durumu' => $cocuk_durumu,
            'kan_grubu' => $kan_grubu,
            'fin_no' => $fin_no,
            'sorumlu_pers_id' => $sorumlu_pers_id,
            'ayrilma_tarihi' => $ayrilma_tarihis,
            'ayrilma_sebebi' => $ayrilma_sebebi,
            'sorumlu_kisi' => $sorumlu_kisi,
            'firma_durumu' => $firma_durumu,
            'birim' => $birim,
            'salary_gunluk' => $salary_gunluk,
            'proje_id' => $proje_id,
        );




        $this->db->set($data);
        $this->db->where('id', $id);



        if ($this->db->update('geopos_employees')) {




            $this->db->set( 'loc',$location);
            $this->db->set( 'date_created',$date_created);

            $this->db->where('id', $id);
            $this->db->update('geopos_users');

            if(($salary!=$sal['salary']) AND ($salary>0.00)) {
                $data1 = array(
                    'typ'=>1,
                    'rid' => $id,
                    'val1' => $salary,
                    'val2' => $sal['salary'],
                    'val3' => date('Y-m-d H:i:s')
                );

                $this->db->insert('geopos_hrm', $data1);
            }

            $this->aauth->applog("Personel Düzenlendi $name ID ".$id,$this->aauth->get_user()->username);
            kont_kayit(20,$id);

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

        $data1 = array(
            'roleid' => $roleid,
            'loc' => $location
        );

        $this->db->set($data1);
        $this->db->where('id', $id);

        $this->db->update('geopos_users');



    }

    public function update_password($id, $cpassword, $newpassword, $renewpassword)
    {


    }

    public function editpicture($id, $pic)
    {
        $this->db->select('picture');
        $this->db->from('geopos_employees');
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();


        $data = array(
            'picture' => $pic
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_employees')) {
            $this->db->set($data);
            $this->db->where('id', $id);
            $this->db->update('geopos_users');

            @unlink(FCPATH . 'userfiles/employee/'. $result['picture']);
            @unlink(FCPATH . 'userfiles/employee/thumbnail/'.$result['picture']);

        }


    }


    public function editsign($id, $pic)
    {
        $this->db->select('sign');
        $this->db->from('geopos_employees');
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();


        $data = array(
            'sign' => $pic
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_employees')) {

            unlink(FCPATH . 'userfiles/employee_sign/' . $result['sign']);
            unlink(FCPATH . 'userfiles/employee_sign/thumbnail/' . $result['sign']);
        }


    }


    var $table = 'geopos_invoices';
    var $column_order = array(null, 'geopos_invoices.tid', 'geopos_invoices.invoicedate', 'geopos_invoices.total', 'geopos_invoices.status');
    var $column_search = array('geopos_invoices.tid', 'geopos_invoices.invoicedate', 'geopos_invoices.total', 'geopos_invoices.status');
    var $order = array('geopos_invoices.tid' => 'asc');


    private function _invoice_datatables_query($id)
    {
        $this->db->select('geopos_invoices.*,geopos_customers.name');
        $this->db->from('geopos_invoices');
        $this->db->where('geopos_invoices.eid', $id);
        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function invoice_datatables($id)
    {
        $this->_invoice_datatables_query($id);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function invoicecount_filtered($id)
    {
        $this->_invoice_datatables_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('geopos_invoices.eid', $id);
        }
        return $query->num_rows($id);
    }

    public function invoicecount_all($id)
    {
        $this->_invoice_datatables_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('geopos_invoices.eid', $id);
        }
        return $query->num_rows($id = '');
    }

    //transaction


    var $tcolumn_order = array(null, 'account', 'invoice_type_desc', 'total', 'status');
    var $tcolumn_search = array('id', 'account');
    var $torder = array('id' => 'asc');
    var $eid = '';

    private function _get_datatables_query()
    {

        $this->db->from('geopos_invoices');

        $this->db->where('eid', $this->eid);
        $this->db->where('invoice_type_id', 12);


        $i = 0;

        foreach ($this->tcolumn_search as $item) // loop column
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

                if (count($this->tcolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->tcolumn_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->torder)) {
            $order = $this->torder;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($eid)
    {
        $this->eid = $eid;
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->db->from('geopos_transactions');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from('geopos_transactions');
        $this->db->where('eid', $this->eid);
        return $this->db->count_all_results();
    }


    public function add_employee($id, $username, $name, $roleid,
                                 $phone, $address, $city, $region,
                                 $country, $postbox,$location,$salary = 0,
                                 $commission = 0,$department=0,
                                 $calisma_sekli,$sozlesme_turu,$sozlesme_date,$resmi_maas,$gayri_resmi_maas,$date_created,
                                 $vatandaslik,$cinsiyet,$birthdays,$medeni_durumu,$cocuk_durumu,$kan_grubu,
                                 $fin_no,$phonealt,$sorumlu_pers_id,$sorumlu_kisi,$firma_durumu,$birim)
    {
        $data = array(
            'id' => $id,
            'username' => $username,
            'name' => $name,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox,
            'phone' => $phone,
            'dept' => $department,
            'salary' => $salary,
            'c_rate' => $commission,
            'calisma_sekli' => $calisma_sekli,
            'sozlesme_turu' => $sozlesme_turu,
            'sozlesme_date' => $sozlesme_date,
            'resmi_maas' => $resmi_maas,
            'gayri_resmi_maas' => $gayri_resmi_maas,
            'vatandaslik' => $vatandaslik,
            'cinsiyet' => $cinsiyet,
            'birthday' => $birthdays,
            'medeni_durumu' => $medeni_durumu,
            'cocuk_durumu' => $cocuk_durumu,
            'kan_grubu' => $kan_grubu,
            'fin_no' => $fin_no,
            'phonealt' => $phonealt,
            'sorumlu_pers_id' => $sorumlu_pers_id,
            'sorumlu_kisi' => $sorumlu_kisi,
            'firma_durumu' => $firma_durumu,
            'birim' => $birim,
        );


        if ($this->db->insert('geopos_employees', $data)) {
            $data1 = array(
                'roleid' => $roleid,
                'loc' => $location,
                'date_created' => $date_created,
            );

            $this->db->set($data1);
            $this->db->where('id', $id);

            $this->db->update('geopos_users');

            $this->aauth->applog("Yeni Personel Oluşturuldu $name ID ".$id,$this->aauth->get_user()->username);
            kont_kayit(19,$id);




            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED') . "  <a href='add' class='btn btn-indigo btn-lg'><span class='fa fa-plus-circle' aria-hidden='true'></span>  </a>"));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function employee_validate($email)
    {
        $this->db->select('*');
        $this->db->from('geopos_users');
        $this->db->where('email', $email);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function money_details($eid)
    {
        // Bu ay için maaş ödemesi / avans / prim alınmışmı




        $this->db->select('total,invoice_type_desc,account');
        $this->db->from('geopos_invoices');
        $this->db->where('eid', $eid);
        $this->db->where('invoice_type_id', 13);
        $this->db->where('DATE(geopos_invoices.invoicedate)  >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)');

        $query = $this->db->get();

        $query=$query->row_array();
        if(!$query)
        {
            //maaşı hesaplanacak eklenecek

        }


        // Bu ay için maaş ödemesi veya avans alınmışmı





        $this->db->select('SUM(debit) AS debit,SUM(credit) AS credit');
        $this->db->from('geopos_invoices');
        $this->db->where('eid', $eid);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function sales_details_all()
    {

        $eid=$this->aauth->get_user()->id;

        $guns_=date("t");
        $date = new DateTime('now');
        $date->modify('last day of this month');

        $date_y=$date->format('Y');
        $hesaplanacak_ay=$date->format('m');
        $date_g=$guns_;


        $date_saat=$date->format(' H:i:s');


        //$date_S= $date->format('Y-m-d H:i:s');




        //$date_f=$date->format('Y-m-d');
        $date_f=$date_y.'-'.$hesaplanacak_ay.'-'.$date_g;
        $date_bas=$date_f.' 00:00:00';
        $date_bit=$date_f.' 23:59:59';

        $date_S= $date_y.'-'.$hesaplanacak_ay.'-'.$date_g.' '.$date_saat;



        $personeller=$this->db->query("SELECT * FROM geopos_employees")->result();
        $prodindex=0;
        $productlist=array();
        $data=array();
        foreach ($personeller as $prs)
        {

            $personel_name=$prs->name;
            $csd=$prs->id;
            $maas=personel_detailsa($csd)['salary']; //2000
            $gun=0;

            $date_ti=$date_y.'-'.$hesaplanacak_ay.'-'.$guns_;
            $sorgu_t=$this->db->query("SELECT  DATEDIFF('$date_ti',geopos_users.date_created) AS gun_sayisi FROM geopos_employees INNER JOIN geopos_users On geopos_users.id=geopos_employees.id Where  geopos_employees.id=$csd")->row();
            if($sorgu_t->gun_sayisi<$guns_)
            {
                $gun=$sorgu_t->gun_sayisi;
            }
            else
            {
                $gun=$guns_;
            }

            $gunluk=$maas/30;
            $hakedis=floatval($gunluk)*floatval($gun);


            $sorgu=$this->db->query("SELECT * FROM geopos_invoices where csd=$csd and invoice_type_id=13 and   (DATE(invoicedate)>='$date_bas' and DATE(invoicedate)<='$date_bit') ");
            $result = $sorgu->result_array();
            $kalan=0;
            if ($sorgu->num_rows() != 0)
            {
                $total=0;

                foreach ($result as $row)
                {
                    $total+=round($row['total'],3);
                }







                if(round($total,2)==round($hakedis,2))
                {
                    $kalan=0;
                }
                else
                {
                    $kalan=$hakedis-$total;

                }







                if($kalan>0)
                {

                    $data = array(
                        'invoicedate' => $date_S,
                        'invoiceduedate' => $date_S,
                        'total' =>$kalan,
                        'credit' =>$kalan,
                        'payer' =>$personel_name,
                        'notes' => 'Hakediş',
                        'csd'=>$csd,
                        'eid'=>$eid,
                        'invoice_type_id'=>13,
                        'invoice_type_desc'=>'Maaş Alacağı'
                    );

                    $productlist[$prodindex] = $data;
                    $prodindex++;




                }

            }
            else
            {


                $date_ti=$date_y.'-'.$hesaplanacak_ay.'-'.$guns_;
                $sorgu_t=$this->db->query("SELECT  DATEDIFF('$date_ti',geopos_users.date_created) AS gun_sayisi FROM geopos_employees INNER JOIN geopos_users On geopos_users.id=geopos_employees.id Where  geopos_employees.id=$csd")->row();
                if($sorgu_t->gun_sayisi<$guns_)
                {
                    $gun=$sorgu_t->gun_sayisi;
                }
                else
                {
                    $gun=$guns_;
                }



                $gunluk=$maas/30;
                $totals=$gunluk*$gun;

                $data = array('invoicedate' => $date_S,'invoiceduedate' => $date_S, 'total' =>$totals, 'credit' =>$totals,
                    'payer' =>$personel_name, 'notes' => 'Hakediş','csd'=>$csd,'eid'=>$eid,'invoice_type_id'=>13,'invoice_type_desc'=>'Maaş Alacağı');
                $productlist[$prodindex] = $data;
                $prodindex++;

            }



        }

        if ($prodindex > 0) {


            $this->db->insert_batch('geopos_invoices', $productlist);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success', 'message' =>'Hakedişler Yapılmıştır.'));
        }
        else
        {
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Error', 'message' =>'Hesaplamalar Daha Önceden Yapılmıştır.'));

        }




    }

    public function sales_details($csd,$totals,$eid,$personel_name,$hesaplanacak_ay,$banka=0,$nakit=0)
    {

        $date = new DateTime('now');
        $date->modify('last day of this month');

        $date_y=$date->format('Y');
        $date_g='30';


        $date_saat=$date->format('H:i:s');


        //$date_S= $date->format('Y-m-d H:i:s');




        //$date_f=$date->format('Y-m-d');
        $date_f=$date_y.'-'.$hesaplanacak_ay.'-'.$date_g;
        $date_bas=$date_f.' 00:00:00';
        $date_bit=$date_f.' 23:59:59';

        $date_S= $date_y.'-'.$hesaplanacak_ay.'-'.$date_g.' '.$date_saat;

        $invoice_type_id=0;
        $trans=0;

        $maas=personel_detailsa($csd)['salary'];
        $nakit_maas=personel_detailsa($csd)['gayri_resmi_maas'];
        $banka_maas=personel_detailsa($csd)['resmi_maas'];

        $gunluk = $banka_maas/30;
        $b_kalan=$gunluk*$date_g;

//        $sorgu=$this->db->query("SELECT * FROM geopos_invoices where csd=$csd and (invoice_type_id=13 or invoice_type_id=31) and   (DATE(invoicedate)>='$date_bas' and DATE(invoicedate)<='$date_bit') ");
//        $result = $sorgu->result_array();
//        $total=0;
//        if ($sorgu->num_rows() > 0)
//        {
//            foreach ($result as $row)
//            {
//                $total+=$row['total'];
//            }
//
//            $kalan=$maas-$total;
//            if($kalan==0)
//            {
//                echo json_encode(array('status' => 'Error', 'message' =>'Personelin bu ay için maaş alacağı yoktur!'));
//            }
//            else if($kalan>0)
//            {
//                if($nakit==1)
//                {
//                    //Nakit Kalan
//                    $nakit_odenen=0;
//                    $sorgu=$this->db->query("SELECT * FROM geopos_invoices where csd=$csd and invoice_type_id=13 and (DATE(invoicedate)>='$date_bas' and DATE(invoicedate)<='$date_bit') ");
//                    $result = $sorgu->result_array();
//                    foreach ($result as $row)
//                    {
//                        $nakit_odenen+=$row['total'];
//                    }
//
//                    $nakit_kalan=$nakit_maas-$nakit_odenen;
//                    if($nakit_kalan>0)
//                    {
//                        $data = array(
//                            'invoicedate' => $date_S,
//                            'invoiceduedate' => $date_S,
//                            'total' =>$totals,
//                            'credit' =>$nakit_kalan,
//                            'payer' =>$personel_name,
//                            'notes' => 'Nakit Hakediş',
//                            'csd'=>$csd,
//                            'eid'=>$eid,
//                            'invoice_type_id'=>13,
//                            'invoice_type_desc'=>'Maaş Alacağı'
//                        );
//                        $this->db->insert('geopos_invoices', $data);
//                        $trans++;
//                    }
//                    //Nakit Kalan
//                }
//
//                if($banka==1)
//                {
//                    //Banka Kalan
//                    $banka_odenen=0;
//                    $sorgu=$this->db->query("SELECT * FROM geopos_invoices where csd=$csd and invoice_type_id=31 and (DATE(invoicedate)>='$date_bas' and DATE(invoicedate)<='$date_bit') ");
//                    $result = $sorgu->result_array();
//                    foreach ($result as $row)
//                    {
//                        $banka_odenen+=$row['total'];
//                    }
//
//                    $banka_kalan=$banka_maas-$banka_odenen;
//                    if($banka_kalan>0)
//                    {
//                        $data = array(
//                            'invoicedate' => $date_S,
//                            'invoiceduedate' => $date_S,
//                            'total' =>$totals,
//                            'credit' =>$banka_kalan,
//                            'payer' =>$personel_name,
//                            'notes' => 'Banka Hakediş',
//                            'csd'=>$csd,
//                            'eid'=>$eid,
//                            'invoice_type_id'=>31,
//                            'invoice_type_desc'=>'Maaş Alacağı Banka'
//                        );
//                        $this->db->insert('geopos_invoices', $data);
//                        $trans++;
//
//                    }
//                }
//                //Banka Kalan
//                if($trans>0)
//                {
//                    echo json_encode(array('status' => 'Success', 'message' =>'Personelin bu ay için maaş alacağı :'.$kalan.'  Bu tutarda hesaplama yapılmıştır.'));
//                }
//                else
//                {
//                    echo json_encode(array('status' => 'Error', 'message' =>
//                        $this->lang->line('ERROR')));
//                }
//
//
//            }
//            else
//            {
//                echo json_encode(array('status' => 'Error', 'message' =>'Personeliniz Maaş Günü Gelmeden Avans Hakkı Kullanmıştır.'));
//            }
//
//        }






        if($banka==1)
        {
            //Banka Kalan



            $data = array(
                'invoicedate' => $date_S,
                'invoiceduedate' => $date_S,
                'total' =>$totals,
                'credit' =>$b_kalan,
                'payer' =>$personel_name,
                'notes' => 'Banka Hakediş',
                'csd'=>$csd,
                'eid'=>$eid,
                'invoice_type_id'=>31,
                'invoice_type_desc'=>'Maaş Alacağı Banka'
            );
            $this->db->insert('geopos_invoices', $data);
            $trans++;


        }

        if($nakit==1)
        {
            $n_kalan=$maas-$b_kalan;
            $data = array(
                'invoicedate' => $date_S,
                'invoiceduedate' => $date_S,
                'total' =>$totals,
                'credit' =>$n_kalan,
                'payer' =>$personel_name,
                'notes' => 'Nakit Hakediş',
                'csd'=>$csd,
                'eid'=>$eid,
                'invoice_type_id'=>13,
                'invoice_type_desc'=>'Maaş Alacağı'
            );
            $this->db->insert('geopos_invoices', $data);
            $trans++;
            //Nakit Kalan
        }


            if($trans>0)
            {
                echo json_encode(array('status' => 'Success', 'message' =>'Personelin Hesaplanan alacağı :'.$totals.'  Bu tutarda hesaplama yapılmıştır.'));
            }
            else
            {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
            }





    }


    public function personel_izinleri_datatables()
    {
        $this->db->select('*');
        $this->db->from('geopos_izinler');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function employee_permissions()
    {
        $this->db->select('*');
        $this->db->from('geopos_premissions');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    //documents list



    function addholidays($loc,$hday,$hdayto,$note)
    {
        $data = array('typ' => 2, 'rid' =>$loc, 'val1' => $hday,'val2'=>$hdayto,'val3'=>$note);
        return $this->db->insert('geopos_hrm', $data);

    }

    function deleteholidays($id)
    {

        if ($this->db->delete('geopos_hrm', array('id' => $id,'typ' => 2))) {


            return true;
        } else {
            return false;
        }

    }


    function holidays_datatables()
    {
        $this->holidays_datatables_query();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function holidays_datatables_query()
    {

        $this->db->from('geopos_hrm');
        $this->db->where('typ',2);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('rid', $this->aauth->get_user()->loc);
        }
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
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->doccolumn_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->doccolumn_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function holidays_count_filtered()
    {
        $this->holidays_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function holidays_count_all()
    {
        $this->holidays_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function hday_view($id,$loc)
    {
        $this->db->select('*');
        $this->db->from('geopos_hrm');
        $this->db->where('id',$id);
        $this->db->where('typ',2);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('rid',$loc);
        }

        $query = $this->db->get();
        return $query->row_array();
    }

    public function edithday($id,$loc,$from, $todate, $note)
    {

        $data = array('typ' => 2, 'val1' => $from,'val2'=>$todate,'val3'=>$note);


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('rid',$loc);
        }


        $this->db->update('geopos_hrm');
        return true;

    }



    public function department_list($id=0)
    {
        $this->db->select('*');
        $this->db->from('geopos_hrm');
        $this->db->where('typ',3);


        $query = $this->db->get();
        return $query->result_array();
    }

    public function department_elist($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_employees');

        $this->db->where('dept',$id);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function department_view($id,$loc)
    {
        $this->db->select('*');
        $this->db->from('geopos_hrm');
        $this->db->where('id',$id);
        $this->db->where('typ',3);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('rid',$loc);
        }


        $query = $this->db->get();
        return $query->row_array();
    }

    function adddepartment($loc,$name)
    {
        $data = array('typ' => 3, 'rid' =>$loc, 'val1' => $name);
        return $this->db->insert('geopos_hrm', $data);

    }

    function deletedepartment($id)
    {

        if ($this->db->delete('geopos_hrm', array('id' => $id,'typ' => 3))) {


            return true;
        } else {
            return false;
        }

    }

    public function editdepartment($id, $loc,$name)
    {

        $data = array(
            'val1' => $name
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->aauth->get_user()->loc) {
            $this->db->where('rid',$loc);
        }


        $this->db->update('geopos_hrm');
        return true;

    }

    //payroll

    private function _pay_get_datatables_query($eid)
    {

        $this->db->from('geopos_invoices');
        if ($this->aauth->get_user()->loc) {
            $this->db->where('loc', $this->aauth->get_user()->loc);
        }
        //$this->db->where('ext', 4);
        if($eid){
            $this->db->where('payerid', $eid);
        }


        $i = 0;

        foreach ($this->tcolumn_search as $item) // loop column
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

                if (count($this->tcolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->tcolumn_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->torder)) {
            $order = $this->torder;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function pay_get_datatables($eid)
    {

        $this->_pay_get_datatables_query($eid);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function pay_count_filtered($eid)
    {
        $this->db->from('geopos_transactions');
        $this->db->where('ext', 4);
        if($eid){
            $this->db->where('payerid', $eid);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function pay_count_all($eid)
    {
        $this->db->from('geopos_transactions');
        $this->db->where('ext', 4);
        if($eid){
            $this->db->where('payerid', $eid);
        }
        return $this->db->count_all_results();
    }


    function addattendance($emp,$adate,$tfrom,$tto,$note)
    {

        foreach ($emp as $row){

            $this->db->where('emp',$row);
            $this->db->where('DATE(adate)',$adate);
            $num = $this->db->count_all_results('geopos_attendance');

            if(!$num){
                $data = array('emp' => $row, 'created' =>date('Y-m-d H:i:s'), 'adate' => $adate,'tfrom'=>$tfrom,'tto'=>$tto,'note'=>$note);
                $this->db->insert('geopos_attendance', $data);
            }

        }

        return true;

    }

    function deleteattendance($id)
    {

        if ($this->db->delete('geopos_attendance', array('id' => $id))) {
            return true;
        } else {
            return false;
        }

    }

    var $acolumn_order = array(null, 'geopos_attendance.emp', 'geopos_attendance.adate', null,null);
    var $acolumn_search = array('geopos_employees.name', 'geopos_attendance.adate');
    function attendance_datatables($cid)
    {
        $this->attendance_datatables_query($cid);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function attendance_datatables_query($cid=0)
    {
        $this->db->select('geopos_attendance.*,geopos_employees.name');
        $this->db->from('geopos_attendance');
        $this->db->join('geopos_employees','geopos_employees.id=geopos_attendance.emp','left');
        if ($this->aauth->get_user()->loc) {
            $this->db->join('geopos_users','geopos_users.id=geopos_attendance.emp','left');
            $this->db->where('geopos_users.loc', $this->aauth->get_user()->loc);

        }
        if($cid)   $this->db->where('geopos_attendance.emp', $cid);
        $i = 0;

        foreach ($this->acolumn_search as $item) // loop column
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

                if (count($this->acolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->acolumn_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->acolumn_order)) {
            $order = $this->acolumn_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function attendance_count_filtered($cid)
    {
        $this->attendance_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function attendance_count_all($cid)
    {
        $this->attendance_datatables_query($cid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getAttendance($emp,$start, $end)
    {

        $sql = "SELECT  CONCAT(tfrom, ' - ', tto) AS title,DATE(adate) as start ,DATE(adate) as end FROM geopos_attendance WHERE (emp='$emp') AND (DATE(adate) BETWEEN ? AND ? ) ORDER BY DATE(adate) ASC";
        return $this->db->query($sql, array($start, $end))->result();

    }

    public function getHolidays($loc,$start, $end)
    {

        $sql = "SELECT  CONCAT(DATE(val1), ' - ', DATE(val2),' - ',val3) AS title,DATE(val1) as start ,DATE(val2) as end FROM geopos_hrm WHERE  (typ='2') AND  (rid='$loc') AND (DATE(val1) BETWEEN ? AND ? ) ORDER BY DATE(val1) ASC";
        return $this->db->query($sql, array($start, $end))->result();

    }


    public function salary_view($eid){
        $this->db->from('geopos_transactions');
        $this->db->where('ext', 4);
        $this->db->where('payerid', $eid);
        $query = $this->db->get();

        return $query->result_array();
    }


    function izinler_datatables($id,$tyd=0)

    {

        $query=$this->_izinler_datatables($id);
        return $query;

    }

    private function _izinler_datatables($id)

    {


        return $this->db->query("SELECT * From geopos_izinler Where emp_id=$id ORDER BY created_date DESC")->result_array();

    }

    function ekstre_datatables_mezuniyet($id)

    {

        $this->_ekstre_datatables_mezuniyet($id);

        $query = $this->db->get();
        return $query->result();

    }

    private function _ekstre_datatables_mezuniyet($id)

    {


        $this->db->select('*');
        $this->db->from('salary_grad');
        $this->db->where('personel_id', $id);

    }


    function mezuniyet_count_filtered($id)

    {

        $this->_ekstre_datatables_mezuniyet($id);

        $query = $this->db->get();

        return $query->num_rows();

    }

    public function mezuniyet_count_all($id)

    {

        $this->db->select('*');
        $this->db->from('salary_grad');
        $this->db->where('personel_id', $id);

        return $this->db->count_all_results();

    }


    function ekstre_datatables_gider($id,$tyd=0,$para_birimi)

    {

        $query=$this->_ekstre_datatables_gider($id);
        return $query;

    }

    private function _ekstre_datatables_gider($id)

    {


        return $this->db->query("SELECT geopos_invoices.id as invoice_id, geopos_invoices.invoicedate,geopos_cost.name as cost_name,geopos_account_type.name,geopos_invoices.total,geopos_invoices.kur_degeri,
       geopos_invoices.para_birimi FROM `geopos_invoices` INNER JOIN geopos_cost ON geopos_invoices.masraf_id=geopos_cost.id
    INNER JOIN geopos_account_type ON geopos_invoices.method=geopos_account_type.id WHERE geopos_invoices.csd = $id and geopos_invoices.invoice_type_id!=21
    and geopos_invoices.masraf_id!=0; ")->result_array();

    }

    function ekstre_datatables_is($id,$tyd=0,$para_birimi)

    {

        $query=$this->_ekstre_datatables_is($id);
        return $query;

    }


    private function _ekstre_datatables_is($id)

    {


        return $this->db->query("SELECT geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoices.id as invoice_id,
                  IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
                IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc,
                IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak,
                geopos_invoices.total,geopos_invoices.kur_degeri,
                geopos_invoice_type.transactions,geopos_invoices.notes  FROM geopos_invoices
                LEFT JOIN geopos_invoice_type on geopos_invoices.invoice_type_id=geopos_invoice_type.id
                Where geopos_invoices.csd=$id  and geopos_invoice_type.id IN (59,60)
                ORDER BY invoicedate ASC")->result_array();

    }


    function ekstre_datatables($id,$tyd=0,$para_birimi)

    {

        $query=$this->_ekstre_datatables($id);
        return $query;

    }


    private function _ekstre_datatables($id)

    {


        return $this->db->query("SELECT geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoices.id as invoice_id,
                  IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
                IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc,
                IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak,
                geopos_invoices.total,geopos_invoices.kur_degeri,
                geopos_invoice_type.transactions,geopos_invoices.notes  FROM geopos_invoices
                LEFT JOIN geopos_invoice_type on geopos_invoices.invoice_type_id=geopos_invoice_type.id
                Where geopos_invoices.csd=$id  and geopos_invoice_type.id IN (12,13,14,31,49,53,26,15,70) and geopos_invoices.`invoicedate` > '2020-12-31 23:59:59'
                ORDER BY invoicedate ASC")->result_array();

    }


    function ekstre_datatables_razi($id,$tyd=0,$para_birimi)

    {

        $query=$this->_ekstre_datatables_razi($id);
        return $query;

    }


    private function _ekstre_datatables_razi($id)

    {


        return $this->db->query("SELECT geopos_invoice_type.description,geopos_invoices.invoicedate,
                  IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
                IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc,
                IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak,
                geopos_invoices.total,geopos_invoices.kur_degeri,
                geopos_invoice_type.transactions,geopos_invoices.notes  FROM geopos_invoices
                LEFT JOIN geopos_invoice_type on geopos_invoices.invoice_type_id=geopos_invoice_type.id
                Where geopos_invoices.csd=$id  and geopos_invoice_type.id IN (50,66) and geopos_invoices.`invoicedate` > '2021-01-30 23:59:59'
                ORDER BY invoicedate ASC")->result_array();

    }

    function ekstre_datatables_borclandirma($id,$tyd=0,$para_birimi)

    {

        $query=$this->_ekstre_datatables_borclandirma($id);
        return $query;

    }


    private function _ekstre_datatables_borclandirma($id)

    {

        return $this->db->query("SELECT geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoice_type.id as type_id,geopos_invoices.id as invoice_id,
                  IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
                IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc,
                IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak,
                geopos_invoices.total,geopos_invoices.kur_degeri,
                geopos_invoice_type.transactions,geopos_invoices.notes  FROM geopos_invoices
                LEFT JOIN geopos_invoice_type on geopos_invoices.invoice_type_id=geopos_invoice_type.id
                Where geopos_invoices.csd=$id  and geopos_invoice_type.id IN (52,51,34,63) and geopos_invoices.`invoicedate` > '2021-01-30 23:59:59'
                ORDER BY invoicedate ASC")->result_array();

    }

    function inv_count_filtered($id)

    {

        $this->_ekstre_datatables($id);

        $query = $this->db->get();

        return $query->num_rows();

    }

    public function inv_count_all($id)

    {

        $this->db->from('geopos_invoices');

        $this->db->where('eid', $id);
        $this->db->where('invoice_type_id', 12);
        $this->db->or_where('invoice_type_id', 15);

        return $this->db->count_all_results();

    }


    public function izinler_count_all($id)

    {

        $this->db->from('geopos_izinler');

        $this->db->where('emp_id', $id);

        return $this->db->count_all_results();

    }

    function izinler_count_filtered($id)

    {

        $query=$this->db->query("SELECT * From geopos_izinler Where emp_id=$id ORDER BY created_date DESC")->num_rows();

        return $query;

    }

    function add_permissions($description,$bas_t,$baslangic_saati,$bit_t,$bitis_saati,$emp_id)
    {
        $emp_fullname=personel_details($emp_id);

        $details = $this->db->query("SELECT * FROM geopos_employees WHERE id =$emp_id")->row_array();

        $data = array(
            'emp_id'=>$emp_id,
            'emp_fullname' => $emp_fullname,
            'bas_date' => $bas_t,
            'bitis_date' => $bit_t,
            'bolum_sorumlusu' =>izin_yetkili_pers_id(), // Ofis Menejeri
            'genel_mudur' =>izin_yetkili_genel_mudur_id(), // Genel Müdür
            'bolum_pers_id' =>$details['sorumlu_pers_id'], // Şube Müdürü
            'finans_pers_id' =>finans_yetkili_id(), // Finans Müdürü
            'izin_sebebi' => $description,
            'status' => 0,
            'genel_mudur_status' => 0,
            'bolum_pers_status' => 0,
            'finas_pers_status' => 0,
            'bas_saati' => $baslangic_saati ,
            'bit_saati' => $bitis_saati,
        );
        return $this->db->insert('geopos_izinler', $data);





    }
    function permission_details()

    {

        return $this->db->select('*')
            ->from('geopos_izinler')

            ->get()
            ->result();



    }
    function pers_views($id)

    {
        $query = $this->db->where('id',$id)->get('geopos_izinler')->row();
        return $query;
    }




    public function pers_views2($id)

    {
        $querys= $this->db->where('id',$id)->get('geopos_izinler')->row();

        $query=$this->db->query("SELECT * From geopos_users Inner JOIN geopos_employees ON geopos_users.id=geopos_employees.id Where geopos_users.id=$querys->emp_id")->row();

        return $query;
    }

    function edit_permissions($id,$description,$bas_t,$baslangic_saati,$bit_t,$bitis_saati,$emp_id,$izin_tipi='',$status=0)
    {
        $emp_fullname=personel_details($emp_id);

        $data = array(
            'emp_id'=>$emp_id,
            'emp_fullname' => $emp_fullname,
            'bas_date' => $bas_t,
            'bitis_date' => $bit_t,
            'bolum_sorumlusu' =>izin_yetkili_pers_id(),
            'izin_sebebi' => $description,
            'status' => 0,
            'bas_saati' => $baslangic_saati,
            'bit_saati' => $bitis_saati,
            'izin_tipi' => $izin_tipi,
            'status' => $status,
        );
        return $this->db->where('id',$id)->update('geopos_izinler', $data);





    }


    function get_datatables_personel_credit($id)

    {
        $this->_get_datatables_personel_credit($id);


        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();

    }


    private function _get_datatables_personel_credit($id)

    {


        $this->db->select('*');

        $this->db->from('salary_credit');

        $this->db->where('transaction_id',$id);

        $i = 0;



        foreach ($this->credit_search as $item) // loop column

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



                if (count($this->credit_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }


        if (isset($_POST['order'])) // here order processing

        {
            $this->db->order_by($this->credit_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else {

            $this->db->order_by('id','ASC');

        }

    }

    function count_personel_credit_filter($id)

    {


        $this->_get_datatables_personel_credit($id);


        $query = $this->db->get();

        return $query->num_rows();

    }

    public function count_personel_credit_all($id)

    {

        $this->_get_datatables_personel_credit($id);


        return $this->db->count_all_results();

    }


}
