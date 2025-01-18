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



class Customers_model extends CI_Model

{



    var $table = 'geopos_customers';

    var $column_order_p = array(null, 'geopos_customers.company', 'customers_project.proje_name',null);

    var $column_search_p = array('geopos_customers.company', 'customers_project.proje_name');

    var $column_order = array(null, 'geopos_customers.company', 'geopos_customers.address', 'geopos_customers.email','geopos_customers.phone', 'geopos_employees.name',null);

    var $column_search = array('geopos_customers.company','geopos_customers.email', 'geopos_customers.sektor', 'geopos_customers.phone','geopos_employees.name');

    var $trans_column_order = array('date', 'debit', 'credit', 'account', null);

    var $trans_column_search = array('geopos_customers.id', 'date');

    var $inv_column_order = array('invoice_no', 'name', 'invoicedate', 'total', 'status', null);

    var $inv_column_search = array('invoice_no', 'name', 'invoicedate', 'total','invoice_type_desc','status');

    var $order = array('geopos_customers.id' => 'desc');

    var $inv_order = array('geopos_invoices.tid' => 'desc');

    var $qto_order = array('geopos_talep_items.tip' => 'desc');

    var $notecolumn_order = array(null, 'title', 'cdate', null);

    var $notecolumn_search = array('id', 'title', 'cdate');

    var $pcolumn_order = array('geopos_projects.status', 'geopos_projects.name', 'geopos_projects.edate', 'geopos_projects.worth', null);

    var $pcolumn_search = array('geopos_projects.name', 'geopos_projects.edate', 'geopos_projects.status');

    var $ptcolumn_order = array('geopos_talep.talep_no','geopos_talep_items.product_name', 'geopos_talep_items.price', 'geopos_talep_items.qty','geopos_talep_items.subtotal');

    var $ptcolumn_search = array('geopos_talep.talep_no','geopos_talep_items.product_name', 'geopos_talep_items.price', 'geopos_talep_items.qty','geopos_talep_items.subtotal');

    var $porder = array('id' => 'desc');







    private function _get_datatables_query()
    {
        $active_status = $this->input->post('active_status');
        $this->db->select('geopos_customers.*,geopos_employees.`name` as emp_name');

        $this->db->from($this->table);

        if($this->input->post('musteri_grup_id'))
        {
//           $array=array($musteri_tipi,5,3,4,5,6,7,8);
            $this->db->where_in('geopos_customers.musteri_tipi', $this->input->post('musteri_grup_id'));
        }
        else
        {
//            $array=array(3,4);
//            $this->db->where_in('geopos_customers.musteri_tipi', $array);
        }
        $this->db->join('geopos_employees','geopos_customers.eid=geopos_employees.id');
        $this->db->where('geopos_customers.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        $this->db->where('geopos_customers.active',$active_status);


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

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }


    }



    function get_datatables()

    {

        $this->_get_datatables_query();



        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }



    function count_filtered($id = '')

    {

        $this->_get_datatables_query();

        $query = $this->db->get();

        return $query->num_rows($id = '');

    }



    public function count_all($id = '')

    {

        $this->_get_datatables_query();


        $query = $this->db->get();

        return $query->num_rows($id = '');

    }



    public function details($custid)

    {

        $this->db->select('geopos_customers.*,users.lang');

        $this->db->from($this->table);

        $this->db->join('users','users.cid=geopos_customers.id','left');

        $this->db->where('geopos_customers.id', $custid);

        $query = $this->db->get();

        return $query->row_array();

    }


    public function bank_details_id($id)
    {

        $this->db->select('*');
        $this->db->from('geopos_customer_bank');
        $this->db->where('geopos_customer_bank.id', $id);
        $query = $this->db->get();
        return $query->row_array();

    }


    public function bank_details($custid)
    {

        $this->db->select('*');
        $this->db->from('geopos_customer_bank');
        $this->db->where('geopos_customer_bank.customer_id', $custid);
        $query = $this->db->get();
        return $query->result();

    }
    public function invoice_adres_details($custid)
    {

        $this->db->select('*');
        $this->db->from('geopos_customer_iadress');
        $this->db->where('geopos_customer_iadress.customer_id', $custid);
        $query = $this->db->get();
        return $query->result();

    }
    public function invoice_teslimat_details($custid)
    {

        $this->db->select('*');
        $this->db->from('geopos_customer_tadress');
        $this->db->where('geopos_customer_tadress.customer_id', $custid);
        $query = $this->db->get();
        return $query->result();

    }
    public function customer_personel_details($custid)
    {

        $this->db->select('*');
        $this->db->from('geopos_customer_personel');
        $this->db->where('geopos_customer_personel.customer_id', $custid);
        $query = $this->db->get();
        return $query->result();

    }

    public function teminat_type_id($custid)
    {

        $this->db->select('*');

        $this->db->from($this->table);

        $this->db->where('id', $custid);

        $query = $this->db->get();

        return $query->row_array();

    }

    public function teminat_type_value($teminat_id)

    {

        $this->db->select('*');

        $this->db->from('geopos_teminat_type');

        $this->db->where('id', $teminat_id);

        $query = $this->db->get();

        return $query->row_array();

    }



    public function money_details($custid)

    {



        $this->db->select('SUM(debit) AS debit,SUM(credit) AS credit');

        $this->db->from('geopos_transactions');

        $this->db->where('payerid', $custid);

        $query = $this->db->get();

        return $query->row_array();

    }



    public function due_details($custid)

    {



        $this->db->select('SUM(total) AS total,SUM(pamnt) AS pamnt,SUM(discount) as discount');

        $this->db->from('geopos_invoices');

        $this->db->where('csd', $custid);


        $query = $this->db->get();

        return $query->row_array();

    }







    public function add(
        $name,
        $company,
        $phone,
        $email,
        $address,
        $city,
        $region,
        $country,
        $postbox,
        $customergroup,
        $taxid,
        $language='',
        $create_login=true,
        $password='',
        $discount=0,
        $customer_teminat_desc='',
        $teminat_type='',
        $customer_credit='',
        $company_about='',
        $musteri_tipi,
        $kdv_orani,
        $parent_id,
        $sirket_tipi,
        $yetkili_tel,
        $yetkili_mail,
        $yetkili_gorev,
        $sorumlu_personel,
        $sorumlu_muhasebe_personeli,
        $cari_tipi,
        $customer_credit_you,
        $sektor
    )



    {

        $this->db->select('email');
        $this->db->from('geopos_customers');
        $this->db->where('email', $email);
        $query = $this->db->get();
        $valid = $query->row_array();
        if (!empty($valid['email'])) {

            $data = array(

                'sirket_tipi' => $sirket_tipi,
                'yetkili_tel' => $yetkili_tel,
                'yetkili_mail' => $yetkili_mail,
                'yetkili_gorev' => $yetkili_gorev,
                'sorumlu_personel' => $sorumlu_personel,
                'sorumlu_muhasebe_personeli' => $sorumlu_muhasebe_personeli,
                'cari_tipi'=>$cari_tipi,
                'name' => $name,

                'company' => $company,

                'phone' => $phone,

                'email' => $email,

                'address' => $address,

                'city' => $city,

                'region' => $region,

                'country' => $country,

                'postbox' => $postbox,

                'gid' => $customergroup,

                'taxid' => $taxid,


                'discount_c' => $discount,

                'customer_teminat_desc' => $customer_teminat_desc,

                'teminat_type' => $teminat_type,

                'credit' => $customer_credit,

                'company_about' => $company_about,
                'eid' => $this->aauth->get_user()->id,
                'musteri_tipi' => $musteri_tipi,
                'kdv_orani' => $kdv_orani,
                'customer_credit_you'=>$customer_credit_you,
                'sektor'=>$sektor

            );




            $data['loc'] = $this->session->userdata('set_firma_id');



            if ($this->db->insert('geopos_customers', $data)) {

                $cid = $this->db->insert_id();

                $this->db->delete('customer_to_parent', array('customer_id' => $cid));
                if(!empty($parent_id)){
                    $parent_list = [];
                    $data_par = array('customer_id' => $cid,'parent_id'=>$parent_id);
                    $this->db->insert('customer_to_parent', $data_par);

                }

              //  kont_kayit(41,$cid);

                // Banka Bilgileri //
                $data_bank=array();
                $productlist=array();
                $ses_data=$this->session->userdata('cari_bank_data');

                if($ses_data!=0)
                {
                    $prodindex=0;
                    foreach ($ses_data as $sd)
                    {
                        $data_bank = array(
                            'customer_id'=>$cid,
                            'firma_adi'=>$company,
                            'director'=>$name,
                            'hesap_numarasi'  => $sd['hesap_numarasi'],
                            'iden_numarasi' =>$sd['iden_numarasi'],
                            'banka'     => $sd['banka'],
                            'banka_unvan' =>$sd['banka_unvan'],
                            'banka_tel' =>$sd['banka_tel'],
                            'kod' =>$sd['kod'],
                            'bank_voen' =>$sd['banka_voen'],
                            'swift_kodu' =>$sd['swift'],
                            'muhbir_hesab' =>$sd['muh_hesab'],
                            'para_birimi' =>$sd['para_birimi']
                        );

                        $productlist[$prodindex] = $data_bank;

                        $prodindex++;
                    }

                    $this->db->insert_batch('geopos_customer_bank', $productlist);
                }
                // Banka Bilgileri //

                // Fatura Bilgileri //
                $data_invoice=array();
                $productlist_inv=array();
                $ses_data_inv=$this->session->userdata('cari_invoice_data');
                if($ses_data_inv!=0)
                {
                    $prodindex_inv=0;
                    foreach ($ses_data_inv as $sd)
                    {
                        if(isset($sd['unvan_invoice']))
                        {
                            $data_invoice= array(
                                'customer_id'=>$cid,
                                'unvan_invoice'  => $sd['unvan_invoice'],
                                'country_invoice'     =>  $sd['country_invoice'],
                                'sehir_invoice' => $sd['sehir_invoice'],
                                'city_invoice' => $sd['city_invoice'],
                                'post_invoice' => $sd['post_invoice'],
                                'adres_invoice' => $sd['adres_invoice'],
                                'phone_invoice' => $sd['phone_invoice'],
                                'email_invoice' => $sd['email_invoice']
                            );
                            $productlist_inv[$prodindex_inv] = $data_invoice;

                            $prodindex_inv++;
                        }

                    }

                    $this->db->insert_batch('geopos_customer_iadress', $productlist_inv);
                }
                // Fatura Bilgileri //

                // Teslimat Bilgileri //
                $data_tes=array();
                $productlist_tes=array();
                $ses_data_tes=$this->session->userdata('cari_teslimat_data');
                if($ses_data_tes!=0)
                {
                    $prodindex_tes=0;
                    foreach ($ses_data_tes as $sd)
                    {
                        if(isset($sd['unvan_teslimat']))
                        {
                            $data_tes= array(
                                'customer_id'=>$cid,
                                'unvan_teslimat'  => $sd['unvan_teslimat'],
                                'country_teslimat'     =>  $sd['country_teslimat'],
                                'sehir_teslimat' => $sd['sehir_teslimat'],
                                'city_teslimat' => $sd['city_teslimat'],
                                'post_teslimat' => $sd['post_teslimat'],
                                'adres_teslimat' => $sd['adres_teslimat'],
                                'phone_teslimat' => $sd['phone_teslimat'],
                                'email_teslimat' => $sd['email_teslimat']
                            );

                            $productlist_tes[$prodindex_tes] = $data_tes;

                            $prodindex_tes++;

                        }

                    }

                    $this->db->insert_batch('geopos_customer_tadress', $productlist_tes);
                }
                // Teslimat Bilgileri //


                // Diğer Personel Bilgileri //
                $data_personel=array();
                $productlist_pers=array();
                $ekstra_pers_tipi=$this->input->post('ekstra_pers_tipi',true);
                if(isset($ekstra_pers_tipi) && count($ekstra_pers_tipi)>0)
                {
                    $ekstra_fullname=$this->input->post('ekstra_fullname',true);
                    $ekstra_tel=$this->input->post('ekstra_tel',true);
                    $ekstra_mail=$this->input->post('ekstra_mail',true);

                    $prodindex_pers=0;
                    foreach ($ekstra_pers_tipi as $key=>$value)
                    {
                        if($value!=0)
                        {

                            $data_personel= array(
                                'customer_id'=>$cid,
                                'tip'  => $value,
                                'fullname'     =>  $ekstra_fullname[$key],
                                'tel' => $ekstra_tel[$key],
                                'mail' => $ekstra_mail[$key]
                            );

                            $productlist_pers[$prodindex_pers] = $data_personel;

                            $prodindex_pers++;

                        }

                    }

                    //$this->db->insert_batch('geopos_customer_personel', $productlist_pers);
                }
                // Diğer Personel Bilgileri //




                $p_string='';

                $temp_password='';

                if($create_login) {



                    if($password) { $temp_password=$password; } else { $temp_password = rand(200000, 999999); }



                    $pass = password_hash($temp_password, PASSWORD_DEFAULT);

                    $data = array(

                        'user_id' => 1,

                        'status' => 'active',

                        'is_deleted' => 0,

                        'name' => $name,

                        'password' => $pass,

                        'email' => $email,

                        'user_type' => 'Member',

                        'cid' => $cid,

                        'lang' => $language

                    );



                    $this->db->insert('users', $data);

                    $p_string=' Geçici Şifre ' . $temp_password.' ';

                }



                $this->session->unset_userdata('cari_invoice_data');
                $this->session->unset_userdata('cari_teslimat_data');
                $this->session->unset_userdata('cari_bank_data');

                $this->aauth->applog("CARİ EKLENDİ $name ID " . $cid, $this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . $p_string . '&nbsp;<a href="' . base_url('customers/view?id=' . $cid) . '" class="btn btn-info btn-sm"><span class="icon-eye"></span>' . $this->lang->line('View') . '</a>', 'cid' => $cid, 'pass' => $temp_password, 'discount' => amountFormat_general($discount)));

                $this->custom->save_fields_data($cid, 1);



                $this->db->select('other');
                $this->db->from('univarsal_api');
                $this->db->where('id', 64);
                $query = $this->db->get();
                $othe = $query->row_array();

                if (!empty($othe['other'])) {
                    $auto_mail = $this->send_mail_auto($email, $name, $temp_password);
                    $this->load->model('communication_model');
                    $attachmenttrue = false;
                    $attachment = '';
                    $this->communication_model->send_corn_email($email, $name, $auto_mail['subject'], $auto_mail['message'], $attachmenttrue, $attachment);
                }





            } else {

                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));

            }

        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                'Mail Adresi Mevcuttur.'));
        }



    }




    public function send_mail_auto($email, $name, $password)
    {
        $this->load->library('parser');
        $this->load->model('templates_model', 'templates');
        $template = $this->templates->template_info(16);

        $data = array(
            'Company' => $this->config->item('ctitle'),
            'NAME' => $name
        );
        $subject = $this->parser->parse_string($template['key1'], $data, TRUE);

        $data = array(
            'Company' => $this->config->item('ctitle'),
            'NAME' => $name,
            'EMAIL' => $email,
            'URL' => base_url() . 'crm',
            'PASSWORD' => $password,
            'CompanyDetails' => '<h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email'),


        );
        $message = $this->parser->parse_string($template['other'], $data, TRUE);


        return array('subject' => $subject, 'message' => $message);
    }


    public function edit($id,$name, $company, $phone, $email, $address, $city, $region, $country,
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
    )

    {

        $data = array(

            'sirket_tipi' => $sirket_tipi,
            'yetkili_tel' => $yetkili_tel,
            'yetkili_mail' => $yetkili_mail,
            'yetkili_gorev' => $yetkili_gorev,
            'sorumlu_personel' => $sorumlu_personel,
            'sorumlu_muhasebe_personeli' => $sorumlu_muhasebe_personeli,
            'cari_tipi'=>$cari_tipi,
            'name' => $name,

            'company' => $company,

            'phone' => $phone,
            'ekstre_tipi' => $ekstre_tipi,

            'email' => $email,

            'address' => $address,

            'city' => $city,

            'region' => $region,

            'country' => $country,

            'postbox' => $postbox,

            'gid' => $customergroup,

            'taxid' => $taxid,


            'discount_c' => $discount,

            'customer_teminat_desc' => $customer_teminat_desc,

            'teminat_type' => $teminat_type,

            'credit' => $customer_credit,

            'company_about' => $company_about,
            'eid' => $this->aauth->get_user()->id,
            'musteri_tipi' => $musteri_tipi,
            'kdv_orani' => $kdv_orani,
            'customer_credit_you'=>$customer_credit_you,
            'sektor'=>$sektor,
			'folder_path'=>$folder_path


        );





        $this->db->set($data);

        $this->db->where('id', $id);



        if ($this->db->update('geopos_customers')) {

            kont_kayit(42,$id);

            $cid=$id;


            // Parent Bilgiileri

            $this->db->delete('customer_to_parent', array('customer_id' => $id));
            if(isset($parent_id)){
                $parent_list = [];
                $data_par = [];
                $i=0;
                foreach ($parent_id as $value){
                    $data_par = array('customer_id' => $id,'parent_id'=>$value);
                    $parent_list[$i] = $data_par;
                    $i++;
                }
                $this->db->insert_batch('customer_to_parent', $parent_list);

            }
            // Parent Bilgiileri

            // Banka Bilgileri //
            $data_bank=array();
            $productlist=array();
            $ses_data=$this->session->userdata('cari_bank_data');
            if(isset($ses_data))
            {
                $prodindex=0;
                foreach ($ses_data as $sd)
                {
                    $data_bank = array(
                        'customer_id'=>$cid,
                        'firma_adi'=>$company,
                        'director'=>$name,
                        'hesap_numarasi'  => $sd['hesap_numarasi'],
                        'iden_numarasi' =>$sd['iden_numarasi'],
                        'banka'     => $sd['banka'],
                        'banka_unvan' =>$sd['banka_unvan'],
                        'banka_tel' =>$sd['banka_tel'],
                        'kod' =>$sd['kod'],
                        'bank_voen' =>$sd['banka_voen'],
                        'swift_kodu' =>$sd['swift_kodu'],
                        'muhbir_hesab' =>$sd['muh_hesab'],
                        'para_birimi' =>$sd['para_birimi']
                    );

                    $productlist[$prodindex] = $data_bank;

                    $prodindex++;
                }

                $this->db->insert_batch('geopos_customer_bank', $productlist);
            }
            // Banka Bilgileri //

            // Fatura Bilgileri //
            $data_invoice=array();
            $productlist_inv=array();
            $ses_data_inv=$this->session->userdata('cari_invoice_data');
            if(isset($ses_data_inv))
            {
                $prodindex_inv=0;
                foreach ($ses_data_inv as $sd)
                {
                    if(isset($sd['unvan_invoice']))
                    {
                        $data_invoice= array(
                            'customer_id'=>$cid,
                            'unvan_invoice'  => $sd['unvan_invoice'],
                            'country_invoice'     =>  $sd['country_invoice'],
                            'sehir_invoice' => $sd['sehir_invoice'],
                            'city_invoice' => $sd['city_invoice'],
                            'post_invoice' => $sd['post_invoice'],
                            'adres_invoice' => $sd['adres_invoice'],
                            'phone_invoice' => $sd['phone_invoice'],
                            'email_invoice' => $sd['email_invoice']
                        );
                        $productlist_inv[$prodindex_inv] = $data_invoice;

                        $prodindex_inv++;
                    }

                }

                $this->db->insert_batch('geopos_customer_iadress', $productlist_inv);
            }
            // Fatura Bilgileri //

            // Teslimat Bilgileri //
            $data_tes=array();
            $productlist_tes=array();
            $ses_data_tes=$this->session->userdata('cari_teslimat_data');
            if(isset($ses_data_tes))
            {
                $prodindex_tes=0;
                foreach ($ses_data_tes as $sd)
                {
                    if(isset($sd['unvan_teslimat']))
                    {
                        $data_tes= array(
                            'customer_id'=>$cid,
                            'unvan_teslimat'  => $sd['unvan_teslimat'],
                            'country_teslimat'     =>  $sd['country_teslimat'],
                            'sehir_teslimat' => $sd['sehir_teslimat'],
                            'city_teslimat' => $sd['city_teslimat'],
                            'post_teslimat' => $sd['post_teslimat'],
                            'adres_teslimat' => $sd['adres_teslimat'],
                            'phone_teslimat' => $sd['phone_teslimat'],
                            'email_teslimat' => $sd['email_teslimat']
                        );

                        $productlist_tes[$prodindex_tes] = $data_tes;

                        $prodindex_tes++;

                    }

                }

                $this->db->insert_batch('geopos_customer_tadress', $productlist_tes);
            }
            // Teslimat Bilgileri //


            // Diğer Personel Bilgileri // Önce Sil
            $this->db->delete('geopos_customer_personel', array('customer_id' => $cid));

            $data_personel=array();
            $productlist_pers=array();
            $ekstra_pers_tipi=$this->input->post('ekstra_pers_tipi',true);
            if(isset($ekstra_pers_tipi))
            {
                $ekstra_fullname=$this->input->post('ekstra_fullname',true);
                $ekstra_tel=$this->input->post('ekstra_tel',true);
                $ekstra_mail=$this->input->post('ekstra_mail',true);

                $prodindex_pers=0;
                foreach ($ekstra_pers_tipi as $key=>$value)
                {
                    if($value!=0)
                    {

                        $data_personel= array(
                            'customer_id'=>$cid,
                            'tip'  => $value,
                            'fullname'     =>  $ekstra_fullname[$key],
                            'tel' => $ekstra_tel[$key],
                            'mail' => $ekstra_mail[$key]
                        );

                        $productlist_pers[$prodindex_pers] = $data_personel;

                        $prodindex_pers++;

                    }

                }

                $this->db->insert_batch('geopos_customer_personel', $productlist_pers);
            }
            // Diğer Personel Bilgileri //

            $data = array(

                'name' => $name,

                'email' => $email,

                'lang' => $language

            );

            $this->db->set($data);

            $this->db->where('cid', $id);

            $this->db->update('users');

            $this->aauth->applog("[Client Updated] $name ID ".$id,$this->aauth->get_user()->username);

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                $this->lang->line('ERROR')));

        }



    }



    public function changepassword($cari_id,$number, $password)

    {

        $pas_num=$password;

        $pass= $this->aauth->hash_password($password,$cari_id);

        $kontrol  = $this->db->query("Select * From customer_info Where customer_id = $cari_id");
        if($kontrol->num_rows()){
            $data = array(
                'pass' => $pass,
                'pass_num' => $pas_num,
                'phone' => $number
            );
            $this->db->set($data);
            $this->db->where('customer_id', $cari_id);
            if($this->db->update('customer_info', $data)){
                return true;
            }
            else {
                return false;
            }
        }
        else {
            $data = array(
                'pass' => $pass,
                'phone' => $number,
                'pass_num' => $pas_num,
                'customer_id' => $cari_id
            );
            if($this->db->insert('customer_info', $data)){
                return true;
            }
            else {
                return false;
            }
        }

    }



    public function editpicture($id, $pic)

    {

        $this->db->select('picture');

        $this->db->from($this->table);

        $this->db->where('id', $id);



        $query = $this->db->get();

        $result = $query->row_array();





        $data = array(

            'picture' => $pic

        );





        $this->db->set($data);

        $this->db->where('id', $id);

        if ($this->db->update('geopos_customers') AND $result['picture']!='example.png') {



            unlink(FCPATH . 'userfiles/customers/' . $result['picture']);

            unlink(FCPATH . 'userfiles/customers/thumbnail/' . $result['picture']);

        }





    }
    public function yoklama_delete()
    {
        $id = $this->input->post('id');
        $pers_id =  $this->aauth->get_user()->id;
        $kontrol = $this->db->query("SELECT * FROM cari_yoklama where id = $id and pers_id = $pers_id")->num_rows();
        if($kontrol){
            if($this->db->delete('cari_yoklama', array('id' => $id))){
                $this->aauth->applog("Yoklama Silindi  ID ".$id,$this->aauth->get_user()->username);
                return [
                    'status'=>1,
                    'message'=>'Başarıyla Silindi',
                ];
            }
            else {
                return [
                    'status'=>0,
                    'message'=>'Hata Aldınız',
                ];
            }
        }
        else {
            return [
                'status'=>0,
                'message'=>'Yoklamayı oluşturan personel dışında başka personel silme yapamaz',
            ];
        }

        $data = array(
            'active' => $status
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_customers')){
            $this->aauth->applog("Cari Pasif Yapıldı  ID ".$id,$this->aauth->get_user()->username);
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Güncellendi',
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız',
            ];
        }
    }

    public function passive_update()
    {
        $id = $this->input->post('cari_id');
        $status = $this->input->post('status');
        $data = array(
            'active' => $status
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('geopos_customers')){
            $this->aauth->applog("Cari Pasif Yapıldı  ID ".$id,$this->aauth->get_user()->username);
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Güncellendi',
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız',
            ];
        }
    }

    public function editpicture_comp($id, $pic)

    {

        $this->db->select('company_picture');

        $this->db->from($this->table);

        $this->db->where('id', $id);



        $query = $this->db->get();

        $result = $query->row_array();





        $data = array(

            'company_picture' => $pic

        );





        $this->db->set($data);

        $this->db->where('id', $id);

        if ($this->db->update('geopos_customers') AND $result['company_picture']!='example.png') {



            unlink(FCPATH . 'userfiles/customers/' . $result['company_picture']);

            unlink(FCPATH . 'userfiles/customers/thumbnail/' . $result['company_picture']);

        }





    }



    public function group_list()

    {


        $where2=' Where c.loc='.$this->session->userdata('set_firma_id');
        $query = $this->db->query("SELECT c.*,p.pc FROM geopos_customer_type AS c LEFT JOIN 
        ( SELECT musteri_tipi,COUNT(musteri_tipi) AS pc FROM geopos_customers   GROUP BY musteri_tipi)
            AS p ON p.musteri_tipi=c.id   $where2");

        return $query->result_array();

    }



    public function delete($id)

    {

        $this->aauth->applog("[Client Deleted]  ID ".$id,$this->aauth->get_user()->username);

        $this->db->delete('users', array('cid' => $id));

        return $this->db->delete('geopos_customers', array('id' => $id));

    }





    //transtables



    function trans_table($id)

    {

        $this->_get_trans_table_query($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }





    private function _get_trans_table_query($id)

    {

        $this->db->select('geopos_invoices.*,geopos_invoices.invoicedate as date');

        $this->db->from('geopos_invoices');

        $this->db->where('geopos_invoices.csd',$id);



        // if($tyd) $this->db->where('geopos_invoices.i_class', 2);

        $this->db->where('geopos_invoice_type.type_value', 'transaction');
        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');
        $this->db->join('geopos_invoice_type', 'geopos_invoices.invoice_type_id=geopos_invoice_type.id', 'left');



        $i = 0;



        foreach ($this->inv_column_search as $item) // loop column

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



                if (count($this->inv_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->inv_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->inv_order)) {

            $order = $this->inv_order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }



    function trans_count_filtered($id = '')

    {

        $this->_get_trans_table_query($id);

        $query = $this->db->get();



        return $query->num_rows($id = '');

    }



    public function trans_count_all($id = '')

    {

        $this->_get_trans_table_query($id);

        $query = $this->db->get();







    }



    private function _inv_datatables_query($id,$tyd=0)

    {

        $this->db->select('geopos_invoices.*');

        $this->db->from('geopos_invoices');

        $this->db->where('geopos_invoices.csd',$id);



        if($tyd) $this->db->where('geopos_invoices.i_class', 2);

        $this->db->where('geopos_invoice_type.type_value', 'fatura');
        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');
        $this->db->join('geopos_invoice_type', 'geopos_invoices.invoice_type_id=geopos_invoice_type.id', 'left');



        $i = 0;



        foreach ($this->inv_column_search as $item) // loop column

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



                if (count($this->inv_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->inv_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->inv_order)) {

            $order = $this->inv_order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }



    function inv_datatables($id,$tyd=0)

    {

        $this->_inv_datatables_query($id,$tyd);



        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }



    function inv_count_filtered($id)

    {

        $this->_inv_datatables_query($id);

        $query = $this->db->get();

        return $query->num_rows();

    }

    public function inv_count_all($id)

    {

        $this->db->from('geopos_invoices');

        $this->db->where('csd', $id);

        return $this->db->count_all_results();

    }




    private function _inv_datatables_query_alt($id,$tyd=0)

    {

        $this->db->select('geopos_invoices.*');

        $this->db->from('geopos_invoices');

        $this->db->where('geopos_invoices.alt_cari_id',$id);



        if($tyd) $this->db->where('geopos_invoices.i_class', 2);

        $this->db->where('geopos_invoice_type.type_value', 'fatura');
        $this->db->join('geopos_customers', 'geopos_invoices.csd=geopos_customers.id', 'left');
        $this->db->join('geopos_invoice_type', 'geopos_invoices.invoice_type_id=geopos_invoice_type.id', 'left');



        $i = 0;



        foreach ($this->inv_column_search as $item) // loop column

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



                if (count($this->inv_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->inv_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->inv_order)) {

            $order = $this->inv_order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }



    function inv_datatables_alt($id,$tyd=0)

    {

        $this->_inv_datatables_query_alt($id,$tyd);



        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }



    function inv_count_filtered_alt($id)

    {

        $this->_inv_datatables_query_alt($id);

        $query = $this->db->get();

        return $query->num_rows();

    }

    public function inv_count_all_alt($id)

    {

        $this->db->from('geopos_invoices');

        $this->db->where('alt_cari_id', $id);

        return $this->db->count_all_results();

    }





    private function _qto_datatables_query($id,$tyd=0)

    {


        $this->db->select('geopos_talep_items.*,geopos_talep.talep_no,geopos_talep.olusturma_tarihi');

        $this->db->from('geopos_talep_items');

        $this->db->join('geopos_talep', 'geopos_talep_items.tip=geopos_talep.id', 'left');
        $this->db->where('geopos_talep_items.firma_id', $id);
        $this->db->where('geopos_talep.tip', 2);


        $i = 0;



        foreach ($this->ptcolumn_search as $item) // loop column

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



                if (count($this->ptcolumn_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->ptcolumn_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->ptcolumn_order)) {

            $order = $this->ptcolumn_order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }



    function qto_datatables($id,$tyd=0)

    {

        $this->_qto_datatables_query($id);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }



    function qto_count_filtered($id)

    {

        $this->_qto_datatables_query($id);

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function qto_count_all($id)

    {

        $this->db->from('geopos_quotes');

        $this->db->where('csd', $id);

        return $this->db->count_all_results();

    }



    public function group_info($id)

    {



        $this->db->from('geopos_cust_group');

        $this->db->where('id', $id);

        $query = $this->db->get();

        return $query->row_array();

    }



    public function activity($id)

    {

        $this->db->select('*');

        $this->db->from('geopos_metadata');

        $this->db->where('type', 21);

        $this->db->where('rid', $id);

        $query = $this->db->get();

        return $query->result_array();

    }



    public function recharge($id, $amount)

    {



        $this->db->set('balance', "balance+$amount", FALSE);

        $this->db->where('id', $id);



        $this->db->update('geopos_customers');



        $data = array(

            'type' => 21,

            'rid' => $id,

            'col1' => $amount,

            'col2' => date('Y-m-d H:i:s').' Account Recharge by '.$this->aauth->get_user()->username

        );





        if ($this->db->insert('geopos_metadata', $data)) {

            $this->aauth->applog("[Client Wallet Recharge] Amt-$amount ID ".$id,$this->aauth->get_user()->username);

            return true;

        } else {

            return false;

        }



    }



    private function _project_datatables_query($cday = '')

    {

        $this->db->select("geopos_projects.*,geopos_customers.name AS customer");

        $this->db->from('geopos_projects');

        $this->db->join('geopos_customers', 'geopos_projects.cid = geopos_customers.id', 'left');





        $this->db->where('geopos_projects.cid=', $cday);







        $i = 0;



        foreach ($this->pcolumn_search as $item) // loop column

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



                if (count($this->pcolumn_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->porder)) {

            $order = $this->porder;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }



    function project_datatables($cday = '')

    {





        $this->_project_datatables_query($cday);



        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }



    function project_count_filtered($cday = '')

    {

        $this->_project_datatables_query($cday);

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function project_count_all($cday = '')

    {

        $this->_project_datatables_query($cday);

        $query = $this->db->get();

        return $query->num_rows();

    }



    //notes



    private function _notes_datatables_query($id)

    {



        $this->db->from('geopos_notes');

        $this->db->where('fid',$id);

        $this->db->where('ntype',1);

        $i = 0;



        foreach ($this->notecolumn_search as $item) // loop column

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



                if (count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->notecolumn_order[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->porder)) {

            $order = $this->porder;

            $this->db->order_by(key($order), $order[key($order)]);

        }

    }



    function notes_datatables($id)

    {

        $this->_notes_datatables_query($id);

        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }



    function notes_count_filtered($id)

    {

        $this->_notes_datatables_query($id);

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function notes_count_all($id)

    {

        $this->_notes_datatables_query($id);

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function editnote($id, $title, $content,$cid)

    {



        $data = array('title' => $title, 'content' => $content, 'last_edit' => date('Y-m-d H:i:s'));





        $this->db->set($data);

        $this->db->where('id', $id);

        $this->db->where('fid', $cid);





        if ($this->db->update('geopos_notes')) {

            $this->aauth->applog("[Client Note Edited]  NoteId $id CID ".$cid,$this->aauth->get_user()->username);

            return true;

        } else {

            return false;

        }



    }



    public function note_v($id,$cid)

    {

        $this->db->select('*');

        $this->db->from('geopos_notes');

        $this->db->where('id', $id);

        $this->db->where('fid', $cid);

        $query = $this->db->get();

        return $query->row_array();

    }



    function addnote($title, $content,$cid)

    {

        $this->aauth->applog("[Client Note Added]  NoteId $title CID ".$cid,$this->aauth->get_user()->username);

        $data = array('title' => $title, 'content' => $content, 'cdate' => date('Y-m-d'),'last_edit' => date('Y-m-d H:i:s'),'cid' => $this->aauth->get_user()->id,'fid' => $cid,'rid'=>1,'ntype'=>1);

        return $this->db->insert('geopos_notes', $data);



    }

    function deletenote($id,$cid)

    {   $this->aauth->applog("[Client Note Deleted]  NoteId $id CID ".$cid,$this->aauth->get_user()->username);

        return $this->db->delete('geopos_notes', array('id' => $id,'fid' => $cid,'rid'=>1));



    }



    //documents list



    var $doccolumn_order = array(null, 'title', 'cdate', null);

    var $doccolumn_search = array('title', 'cdate');



    public function documentlist($cid)

    {

        $this->db->select('*');

        $this->db->from('geopos_documents');

        $this->db->where('fid',$cid);

        $this->db->where('rid',1);

        $query = $this->db->get();

        return $query->result_array();

    }



    function adddocument($title, $filename,$cid,$baslangic_date,$bitis_date)

    {   $this->aauth->applog("[Client Doc Added]  DocId $title CID ".$cid,$this->aauth->get_user()->username);

        $data = array('baslangic_date' => $baslangic_date,'bitis_date' => $bitis_date,'title' => $title, 'filename' => $filename, 'cdate' => date('Y-m-d'),'cid'=>$this->aauth->get_user()->id,'fid'=>$cid,'rid'=>1);

        return $this->db->insert('geopos_documents', $data);



    }



    function deletedocument($id,$cid)

    {

        $this->db->select('filename');

        $this->db->from('geopos_documents');

        $this->db->where('id', $id);

        $query = $this->db->get();

        $result = $query->row_array();

        if ($this->db->delete('geopos_documents', array('id' => $id,'rid'=>1))) {



            unlink(FCPATH . 'userfiles/documents/' . $result['filename']);

            $this->aauth->applog("[Client Doc Deleted]  DocId $id CID ".$cid,$this->aauth->get_user()->username);

            return true;

        } else {

            return false;

        }



    }





    function document_datatables($cid)

    {

        $this->document_datatables_query($cid);

        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }



    private function document_datatables_query($cid)

    {



        $this->db->from('geopos_documents');

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

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->doccolumn_order[$search['0']['column']], $search['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

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

    function customer_ekstre_datatables_forma2_liste($id,$tyd=0,$para_birimi,$kdv_durum,$proje_id=0,$tahvil=0)

    {

        $this->_customer_extre_forma2_liste($id,$tyd,$para_birimi,$kdv_durum,$proje_id,$tahvil);



        if ($_POST['length'] != -1)
        {

            $this->db->limit(10000, 0);
        }
        else
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }



        $query = $this->db->get();


        return $query->result();

    }

    function customer_ekstre_datatables($id,$tyd=0,$para_birimi,$kdv_durum,$proje_id=0,$tahvil=0,$parent_id=0,$forma2_durum=0)

    {



        $this->_customer_extre($id,$tyd,$para_birimi,$kdv_durum,$proje_id,$tahvil,$parent_id,$forma2_durum);





        if ($_POST['length'] != -1)
        {

            $this->db->limit(10000, 0);
        }
        else
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }



        $query = $this->db->get();

        //$query=$query->result();
        //echo $this->db->last_query();die();







        return $query->result_array();

    }

    function customer_ekstre_datatables_sozlesme($id,$tyd=0,$para_birimi,$kdv_durum,$proje_id=0,$tahvil=0)

    {

        $this->_customer_extre_sozlesme($id,$tyd,$para_birimi,$kdv_durum,$proje_id,$tahvil);



        if ($_POST['length'] != -1)
        {

            $this->db->limit(10000, 0);
        }
        else
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }



        $query = $this->db->get();


        return $query->result();

    }


    function customer_ekstre_datatables_forma2($id,$tyd=0,$para_birimi,$kdv_durum,$proje_id=0,$tahvil=0)

    {

        $this->_customer_extre_forma2($id,$tyd,$para_birimi,$kdv_durum,$proje_id,$tahvil);



        if ($_POST['length'] != -1)
        {

            $this->db->limit(10000, 0);
        }
        else
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }



        $query = $this->db->get();


        return $query->result_array();

    }



    function customer_ekstre_datatables_avans($id,$tyd=0,$para_birimi,$kdv_durum,$proje_id=0,$tahvil=0)

    {

        $this->_customer_extre_avans($id,$tyd,$para_birimi,$kdv_durum,$proje_id,$tahvil);



        if ($_POST['length'] != -1)
        {

            $this->db->limit(10000, 0);
        }
        else
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }



        $query = $this->db->get();


        return $query->result();

    }



    private function _customer_extre_forma2_liste($id,$tyd=0,$para_birimi,$kdv_durum,$proje_id=0,$tahvil=0)

    {


        $whr='';
        $w='';

        if($kdv_durum==0)
        {
            $this->db->select("geopos_invoices.csd,
            geopos_invoices.proje_id,
            geopos_invoices.stok_guncelle,geopos_invoice_type.description,geopos_invoices.status as fatura_durumu_s,
            geopos_invoices.invoicedate,geopos_invoices.invoice_no,geopos_invoice_type.id as type_id,geopos_invoice_type.type_value,
          IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
           IF(geopos_invoice_type.id=19,geopos_invoices.total,0) as kdv_borc,
            IF(geopos_invoice_type.id=20,geopos_invoices.total,0) as kdv_alacak,
        IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc,
        IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak,
       IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc_sub,
        IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak_sub,
        geopos_invoices.total,
        geopos_invoices.subtotal,
        geopos_invoices.kur_degeri,
        geopos_invoices.para_birimi,
        geopos_invoice_type.transactions
        ");
            $this->db->from('geopos_invoices');

            $this->db->join('geopos_invoice_type', 'geopos_invoices.invoice_type_id=geopos_invoice_type.id', 'left');


        }
        else if($kdv_durum==1)
        {
            $this->db->select("geopos_invoices.csd,geopos_invoices.stok_guncelle,geopos_invoice_type.description,geopos_invoices.status as fatura_durumu_s,geopos_invoices.invoicedate,geopos_invoices.invoice_no,geopos_invoice_type.id as type_id,geopos_invoice_type.type_value,
            IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
            IF(geopos_invoice_type.id=19,geopos_invoices.total,0) as kdv_borc,
            IF(geopos_invoice_type.id=20,geopos_invoices.total,0) as kdv_alacak,
            IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc,
            IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak,
            IF(geopos_invoice_type.transactions='income',geopos_invoices.subtotal,NULL) as borc_sub,
            IF(geopos_invoice_type.transactions='expense',geopos_invoices.subtotal,NULL) as alacak_sub,
            geopos_invoices.total,
            geopos_invoices.subtotal,
            geopos_invoices.kur_degeri,
             geopos_invoices.para_birimi,
            geopos_invoice_type.transactions
            ");
            $this->db->from('geopos_invoices');

            $this->db->join('geopos_invoice_type', 'geopos_invoices.invoice_type_id=geopos_invoice_type.id', 'left');


        }

        else if($kdv_durum==2)
        {
            $this->db->select("geopos_invoices.csd,geopos_invoices.stok_guncelle,geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoices.status as fatura_durumu_s,geopos_invoices.invoice_no,geopos_invoice_type.id as type_id,geopos_invoice_type.type_value,



            IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,

            IF(geopos_invoice_type.id=19,geopos_invoices.total,0) as kdv_borc,
            IF(geopos_invoice_type.id=20,geopos_invoices.total,0) as kdv_alacak,

            IF(geopos_invoice_type.id=1,geopos_invoices.tax,0) as borc,
            IF(geopos_invoice_type.id=2,geopos_invoices.tax,0) as alacak,

            IF(geopos_invoice_type.id=1,geopos_invoices.tax,0) as borc_sub,
            IF(geopos_invoice_type.id=2,geopos_invoices.tax,0) as alacak_sub,
            geopos_invoices.tax as total,
            geopos_invoices.tax as subtotal,
            geopos_invoices.kur_degeri,
             geopos_invoices.para_birimi,
            geopos_invoice_type.transactions
            ");
            $this->db->from('geopos_invoices');

            $this->db->join('geopos_invoice_type', 'geopos_invoices.invoice_type_id=geopos_invoice_type.id', 'left');





        }

        $type=array(29,30,45,46,54,55);
        $this->db->where_in('geopos_invoice_type.id',$type);








        if(is_numeric($para_birimi))
        {
            $this->db->where('geopos_invoices.para_birimi',$para_birimi);


        }

        if($tahvil==1)
        {
            $this->db->where('geopos_invoices.stok_guncelle',1);
        }

        $this->db->where('geopos_invoices.csd',$id);

        if(!empty($proje_id))
        {
            $this->db->where_in('geopos_invoices.proje_id',$proje_id);

        }


        $this->db->order_by('DATE(geopos_invoices.invoicedate)', 'ASC');







        $i = 0;



        foreach ($this->inv_column_search as $item) // loop column

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



                if (count($this->inv_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }





    }

    private function _customer_extre($id,$tyd=0,$para_birimi,$kdv_durum,$proje_id=0,$tahvil=0,$parent_id=0,$forma2_durum=0)

    {


        $whr='';
        $w='';
        if($kdv_durum==0)
        {
            $select="geopos_invoices.end_date_islem,geopos_invoices.proje_id,
            geopos_invoices.stok_guncelle,geopos_invoice_type.description,geopos_invoice_type.type_value,
            geopos_invoices.status as fatura_durumu_s,geopos_invoices.invoicedate,geopos_invoices.invoice_no,geopos_invoice_type.id as type_id,geopos_invoice_type.type_value,
            geopos_invoices.status as fatura_durumu_s,geopos_invoices.invoicedate,geopos_invoices.invoice_no,geopos_invoice_type.id as type_id,geopos_invoice_type.type_value,
          IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
           IF(geopos_invoice_type.id=19,geopos_invoices.total,0) as kdv_borc,
            IF(geopos_invoice_type.id=20,geopos_invoices.total,0) as kdv_alacak,
        IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc,
        IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak,
           IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc_sub,
            IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak_sub,
        geopos_invoices.total,
        geopos_invoices.subtotal,
        geopos_invoices.kur_degeri,
        geopos_invoices.para_birimi,
        geopos_invoices.notes,
        geopos_invoice_type.transactions,
        geopos_invoices.csd,geopos_invoices.id as inv_id
        ";



            $this->db->select($select);
            $this->db->from('geopos_invoices');

            $this->db->join('geopos_invoice_type', 'geopos_invoices.invoice_type_id=geopos_invoice_type.id', 'left');


        }
        else if($kdv_durum==1)
        {
            $this->db->select("geopos_invoices.end_date_islem,geopos_invoices.proje_id,geopos_invoices.stok_guncelle,
            geopos_invoice_type.description,geopos_invoice_type.type_value,geopos_invoices.status as fatura_durumu_s,geopos_invoices.invoicedate,geopos_invoices.invoice_no,geopos_invoice_type.id as type_id,geopos_invoice_type.type_value,
              IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
               IF(geopos_invoice_type.id=19,geopos_invoices.total,0) as kdv_borc,
            IF(geopos_invoice_type.id=20,geopos_invoices.total,0) as kdv_alacak,
            IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc,
            IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak,
            IF(geopos_invoice_type.transactions='income',geopos_invoices.subtotal,NULL) as borc_sub,
            IF(geopos_invoice_type.transactions='expense',geopos_invoices.subtotal,NULL) as alacak_sub,
            geopos_invoices.total,
            geopos_invoices.subtotal,
            geopos_invoices.kur_degeri,
              geopos_invoices.notes,
             geopos_invoices.para_birimi,
            geopos_invoice_type.transactions,
        geopos_invoices.csd,geopos_invoices.id as inv_id
            ");
            $this->db->from('geopos_invoices');
            $this->db->join('geopos_invoice_type', 'geopos_invoices.invoice_type_id=geopos_invoice_type.id', 'left');


        }
        else if($kdv_durum==2)
        {
            $this->db->select("geopos_invoices.end_date_islem,geopos_invoices.proje_id,geopos_invoices.stok_guncelle,
            geopos_invoice_type.description,geopos_invoice_type.type_value,geopos_invoices.invoicedate,geopos_invoices.status as fatura_durumu_s,geopos_invoices.invoice_no,
            geopos_invoice_type.id as type_id,geopos_invoice_type.type_value,
            IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
            IF(geopos_invoice_type.id=19,geopos_invoices.total,0) as kdv_borc,
            IF(geopos_invoice_type.id=20,geopos_invoices.total,0) as kdv_alacak,
            IF(geopos_invoice_type.id=1,geopos_invoices.tax,0) as borc,
            IF(geopos_invoice_type.id=2,geopos_invoices.tax,0) as alacak,
            IF(geopos_invoice_type.id=1,geopos_invoices.tax,0) as borc_sub,
            IF(geopos_invoice_type.id=2,geopos_invoices.tax,0) as alacak_sub,
            geopos_invoices.tax as total,
            geopos_invoices.tax as subtotal,
            geopos_invoices.kur_degeri,
             geopos_invoices.para_birimi,
            geopos_invoice_type.transactions,
              geopos_invoices.notes,
        geopos_invoices.csd,geopos_invoices.id as inv_id
            ");
            $this->db->from('geopos_invoices');
            $this->db->join('geopos_invoice_type', 'geopos_invoices.invoice_type_id=geopos_invoice_type.id', 'left');

        }

        if($kdv_durum==1)
        {
            $type=array(1,2,3,4,7,8,17,18,21,22,23,24,38,43,44,45,46,54,55,29,30,62,24,41,39,40,61,65,69,73,72,76);
        }
        else if($kdv_durum==2)
        {
            $type=array(19,20,47,48);
        }
        else if($forma2_durum==2){
            $type=array(1,2,3,4,7,8,17,18,19,20,21,22,23,24,38,43,44,45,46,47,48,39,40,54,55,62,24,41,61,65,69,73,72,76);
        }
        else if($forma2_durum==1){
            $type=array(3,4,17,18,19,20,21,22,23,38,43,44,45,46,47,48,39,40,54,55,29,30,62,73,72,76);
        }
        else
        {
            $type=array(1,2,3,4,7,8,17,18,19,20,21,22,23,24,38,43,44,45,46,47,48,39,40,54,55,29,30,62,24,41,61,65,69,72,73,76);
        }

        //$this->db->join('geopos_customers', 'geopos_invoices.payer=geopos_customers.id', 'left');

        $this->db->where_in('geopos_invoice_type.id',$type);


//        $this->db->where('geopos_invoices.masraf_id=0');
        $this->db->where('geopos_invoices.cari_pers_type!=7');

        if(is_numeric($para_birimi))
        {
            $this->db->where('geopos_invoices.para_birimi',$para_birimi);

        }

        if($tahvil==1)
        {
            $this->db->where('geopos_invoices.stok_guncelle',1);

        }


        $j=0;

        if(!empty($proje_id))
        {
            $this->db->where_in('geopos_invoices.proje_id',$proje_id);

        }

        if(!empty($parent_id))
        {
            $this->db->where_in('geopos_invoices.csd',$parent_id);

        }
        else
        {
            if (!empty($_POST['columns'][0]['search']['value'])) //FİRMA
            {
                $id_search_all_firma = explode('|',$_POST['columns'][0]['search']['value']);



                if(count($id_search_all_firma)>1)
                {
                    $array_ids_firma=array();
                    foreach ($id_search_all_firma as $id_search_firma)
                    {


                        $id_firma=customer_id_ogren($id_search_firma);
                        $array_ids_firma[]=$id_firma;

                    }



                    $this->db->where_in('geopos_invoices.csd', $array_ids_firma);
                }
                else
                {
                    $id_firma=customer_id_ogren($id_search_all_firma[0]);
                    $this->db->where('geopos_invoices.csd', $id_firma);
                }

            }

            if (!empty($_POST['columns'][2]['search']['value'])) // İşlem TİPİ
            {

                $id_search_all_islem = explode('|',$_POST['columns'][2]['search']['value']);


                if(count($id_search_all_islem)>1)
                {
                    $array_ids_islem=array();
                    foreach ($id_search_all_islem as $id_search_islem)
                    {

                        $id_islem=invoice_type_id_ogren($id_search_islem);
                        $array_ids_islem[]=$id_islem;

                    }



                    $this->db->where_in('geopos_invoices.invoice_type_id', $array_ids_islem);
                }
                else
                {
                    $id_islem=invoice_type_id_ogren($id_search_all_islem[0]);
                    $this->db->where('geopos_invoices.invoice_type_id', $id_islem);
                }


            }

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



                    $this->db->where_in('geopos_invoices.proje_id', $array_ids_proje);
                }
                else
                {
                    $id_proje=proje_id_ogren($id_search_all_proje[0]);
                    $this->db->where('geopos_invoices.proje_id', $id_proje);
                }

            }

            if (!empty($_POST['columns'][5]['search']['value'])) //Ödeme Tİpi
            {
                $id_search_all_odeme = explode('|',$_POST['columns'][5]['search']['value']);
                if(count($id_search_all_odeme)>1)
                {
                    $array_ids_odeme=array();
                    foreach ($id_search_all_odeme as $id_search_odeme)
                    {

                        $id_odeme=odeme_tipi_id_ogren($id_search_odeme);
                        $array_ids_odeme[]=$id_odeme;

                    }



                    $this->db->where_in('geopos_invoices.method', $array_ids_odeme);
                }
                else
                {
                    $id_odeme=odeme_tipi_id_ogren($id_search_all_odeme[0]);
                    $this->db->where('geopos_invoices.method', $id_odeme);
                }



            }

            $this->db->where('geopos_invoices.csd',$id);


        }

        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where("DATE(geopos_invoices.invoicedate) >=",datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where("DATE(geopos_invoices.invoicedate) <=",datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
        }



        $this->db->order_by('DATE(geopos_invoices.invoicedate)', 'ASC');







        $i = 0;



        foreach ($this->inv_column_search as $item) // loop column

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



                if (count($this->inv_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }





    }



    private function _customer_extre_sozlesme($id,$tyd=0,$para_birimi,$kdv_durum,$proje_id=0,$tahvil=0)

    {


        $whr='';
        $w='';

        $this->db->select("geopos_invoices.csd,geopos_invoices.proje_id,
            geopos_invoices.stok_guncelle,geopos_invoice_type.description,
            geopos_invoices.status as fatura_durumu_s,geopos_invoices.invoicedate,geopos_invoices.invoice_no,geopos_invoice_type.id as type_id,geopos_invoice_type.type_value,
          IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
           IF(geopos_invoice_type.id=19,geopos_invoices.total,0) as kdv_borc,
            IF(geopos_invoice_type.id=20,geopos_invoices.total,0) as kdv_alacak,
        IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc,
        IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak,
           IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc_sub,
            IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak_sub,
        geopos_invoices.total,
        geopos_invoices.subtotal,
        geopos_invoices.kur_degeri,
         geopos_invoices.para_birimi,
        geopos_invoice_type.transactions
        ");
        $this->db->from('geopos_invoices');

        $this->db->join('geopos_invoice_type', 'geopos_invoices.invoice_type_id=geopos_invoice_type.id', 'left');


        if (!empty($_POST['columns'][0]['search']['value'])) //FİRMA
        {
            $id_search_all = explode('|',$_POST['columns'][0]['search']['value']);



            if(count($id_search_all)>1)
            {
                $array_ids=array();
                foreach ($id_search_all as $id_search)
                {


                    $id_=customer_id_ogren($id_search);
                    $array_ids[]=$id_;

                }



                $this->db->where_in('geopos_invoices.csd', $array_ids);
            }
            else
            {
                $id_=customer_id_ogren($id_search_all[0]);
                $this->db->where('geopos_invoices.csd', $id_);
            }

        }

        if (!empty($_POST['columns'][2]['search']['value'])) // İşlem TİPİ
        {

            $id_search_all = explode('|',$_POST['columns'][2]['search']['value']);


            if(count($id_search_all)>1)
            {
                $array_ids=array();
                foreach ($id_search_all as $id_search)
                {

                    $id_=invoice_type_id_ogren($id_search);
                    $array_ids[]=$id_;

                }



                $this->db->where_in('geopos_invoices.invoice_type_id', $array_ids);
            }
            else
            {
                $id_=invoice_type_id_ogren($id_search_all[0]);
                $this->db->where('geopos_invoices.invoice_type_id', $id_);
            }


        }

        if (!empty($_POST['columns'][3]['search']['value'])) //Proje
        {

            $id_search_all = explode('|',$_POST['columns'][3]['search']['value']);


            if(count($id_search_all)>1)
            {
                $array_ids=array();
                foreach ($id_search_all as $id_search)
                {

                    $id_=proje_id_ogren($id_search);
                    $array_ids[]=$id_;

                }



                $this->db->where_in('geopos_invoices.proje_id', $array_ids);
            }
            else
            {
                $id_=invoice_type_id_ogren($id_search_all[0]);
                $this->db->where('geopos_invoices.proje_id', $id_);
            }

        }

        if (!empty($_POST['columns'][5]['search']['value'])) //Ödeme Tİpi
        {
            $id_search_all = explode('|',$_POST['columns'][5]['search']['value']);
            if(count($id_search_all)>1)
            {
                $array_ids=array();
                foreach ($id_search_all as $id_search)
                {

                    $id_=odeme_tipi_id_ogren($id_search);
                    $array_ids[]=$id_;

                }



                $this->db->where_in('geopos_invoices.method', $array_ids);
            }
            else
            {
                $id_=odeme_tipi_id_ogren($id_search_all[0]);
                $this->db->where('geopos_invoices.method', $id_);
            }



        }

        $this->db->where('geopos_invoices.csd',$id);

        $type=array(36,35,3,4,17,18,43,44,45,46,54,55);
        $this->db->where_in('geopos_invoice_type.id',$type);








        if(is_numeric($para_birimi))
        {
            $this->db->where('geopos_invoices.para_birimi',$para_birimi);


        }

        if($tahvil==1)
        {
            $this->db->where('geopos_invoices.stok_guncelle',1);

        }

        $this->db->where('geopos_invoices.csd',$id);

        if(!empty($proje_id))
        {
            $this->db->where_in('geopos_invoices.proje_id',$proje_id);

        }


        $this->db->order_by('DATE(geopos_invoices.invoicedate)', 'ASC');







        $i = 0;



        foreach ($this->inv_column_search as $item) // loop column

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



                if (count($this->inv_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }





    }



    private function _customer_extre_forma2($id,$tyd=0,$para_birimi,$kdv_durum,$proje_id=0,$tahvil=0)

    {


        $whr='';
        $w='';

        $this->db->select("geopos_invoices.csd,geopos_invoices.oran,geopos_invoices.proje_id,geopos_invoices.stok_guncelle,geopos_invoice_type.description,geopos_invoices.status as fatura_durumu_s,geopos_invoices.invoicedate,geopos_invoices.invoice_no,geopos_invoice_type.id as type_id,geopos_invoice_type.type_value,
          IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
           IF(geopos_invoice_type.id=19,geopos_invoices.total,0) as kdv_borc,
            IF(geopos_invoice_type.id=20,geopos_invoices.total,0) as kdv_alacak,
        IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc,
        IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak,
       IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc_sub,
        IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak_sub,
        geopos_invoices.total,
        geopos_invoices.subtotal,
        geopos_invoices.kur_degeri,
        geopos_invoices.para_birimi,
        geopos_invoice_type.transactions
        ");
        $this->db->from('geopos_invoices');

        $this->db->join('geopos_invoice_type', 'geopos_invoices.invoice_type_id=geopos_invoice_type.id', 'left');

        $type=array(29,30,45,46,54,55,3,4);
        $this->db->where_in('geopos_invoice_type.id',$type);








        if(is_numeric($para_birimi))
        {
            $this->db->where('geopos_invoices.para_birimi',$para_birimi);


        }

        if($tahvil==1)
        {
            $this->db->where('geopos_invoices.stok_guncelle',1);
        }

        $this->db->where('geopos_invoices.csd',$id);

        if(!empty($proje_id))
        {
            $this->db->where_in('geopos_invoices.proje_id',$proje_id);

        }


        if (!empty($_POST['columns'][0]['search']['value'])) //FİRMA
        {
            $id_search_all = explode('|',$_POST['columns'][0]['search']['value']);



            if(count($id_search_all)>1)
            {
                $array_ids=array();
                foreach ($id_search_all as $id_search)
                {


                    $id_=customer_id_ogren($id_search);
                    $array_ids[]=$id_;

                }



                $this->db->where_in('geopos_invoices.csd', $array_ids);
            }
            else
            {
                $id_=customer_id_ogren($id_search_all[0]);
                $this->db->where('geopos_invoices.csd', $id_);
            }

        }

        if (!empty($_POST['columns'][2]['search']['value'])) // İşlem TİPİ
        {

            $id_search_all = explode('|',$_POST['columns'][2]['search']['value']);


            if(count($id_search_all)>1)
            {
                $array_ids=array();
                foreach ($id_search_all as $id_search)
                {

                    $id_=invoice_type_id_ogren($id_search);
                    $array_ids[]=$id_;

                }



                $this->db->where_in('geopos_invoices.invoice_type_id', $array_ids);
            }
            else
            {
                $id_=invoice_type_id_ogren($id_search_all[0]);
                $this->db->where('geopos_invoices.invoice_type_id', $id_);
            }


        }

        if (!empty($_POST['columns'][3]['search']['value'])) //Proje
        {

            $id_search_all = explode('|',$_POST['columns'][3]['search']['value']);


            if(count($id_search_all)>1)
            {
                $array_ids=array();
                foreach ($id_search_all as $id_search)
                {

                    $id_=proje_id_ogren($id_search);
                    $array_ids[]=$id_;

                }



                $this->db->where_in('geopos_invoices.proje_id', $array_ids);
            }
            else
            {
                $id_=invoice_type_id_ogren($id_search_all[0]);
                $this->db->where('geopos_invoices.proje_id', $id_);
            }

        }

        if (!empty($_POST['columns'][5]['search']['value'])) //Ödeme Tİpi
        {
            $id_search_all = explode('|',$_POST['columns'][5]['search']['value']);
            if(count($id_search_all)>1)
            {
                $array_ids=array();
                foreach ($id_search_all as $id_search)
                {

                    $id_=odeme_tipi_id_ogren($id_search);
                    $array_ids[]=$id_;

                }



                $this->db->where_in('geopos_invoices.method', $array_ids);
            }
            else
            {
                $id_=odeme_tipi_id_ogren($id_search_all[0]);
                $this->db->where('geopos_invoices.method', $id_);
            }



        }

        $this->db->where('geopos_invoices.csd',$id);


        $this->db->order_by('DATE(geopos_invoices.invoicedate)', 'ASC');







        $i = 0;



        foreach ($this->inv_column_search as $item) // loop column

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



                if (count($this->inv_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }





    }

    private function _customer_extre_avans($id,$tyd=0,$para_birimi,$kdv_durum,$proje_id=0,$tahvil=0)

    {


        $whr='';
        $w='';

        $this->db->select("geopos_invoices.csd,geopos_invoices.oran,geopos_invoices.proje_id,geopos_invoices.stok_guncelle,geopos_invoice_type.description,geopos_invoices.status as fatura_durumu_s,geopos_invoices.invoicedate,geopos_invoices.invoice_no,geopos_invoice_type.id as type_id,geopos_invoice_type.type_value,
          IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
           IF(geopos_invoice_type.id=19,geopos_invoices.total,0) as kdv_borc,
            IF(geopos_invoice_type.id=20,geopos_invoices.total,0) as kdv_alacak,
        IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc,
        IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak,
       IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc_sub,
        IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak_sub,
        geopos_invoices.total,
        geopos_invoices.subtotal,
        geopos_invoices.kur_degeri,
        geopos_invoice_type.transactions
        ");
        $this->db->from('geopos_invoices');

        $this->db->join('geopos_invoice_type', 'geopos_invoices.invoice_type_id=geopos_invoice_type.id', 'left');










        if(is_numeric($para_birimi))
        {
            $this->db->where('geopos_invoices.para_birimi',$para_birimi);


        }

        if($tahvil==1)
        {
            $this->db->where('geopos_invoices.stok_guncelle',1);
        }



        if(!empty($proje_id))
        {
            $this->db->where_in('geopos_invoices.proje_id',$proje_id);

        }

        if (!empty($_POST['columns'][0]['search']['value'])) //FİRMA
        {
            $id_search_all = explode('|',$_POST['columns'][0]['search']['value']);



            if(count($id_search_all)>1)
            {
                $array_ids=array();
                foreach ($id_search_all as $id_search)
                {


                    $id_=customer_id_ogren($id_search);
                    $array_ids[]=$id_;

                }



                $this->db->where_in('geopos_invoices.csd', $array_ids);
            }
            else
            {
                $id_=customer_id_ogren($id_search_all[0]);
                $this->db->where('geopos_invoices.csd', $id_);
            }

        }

        if (!empty($_POST['columns'][2]['search']['value'])) // İşlem TİPİ
        {

            $id_search_all = explode('|',$_POST['columns'][2]['search']['value']);


            if(count($id_search_all)>1)
            {
                $array_ids=array();
                foreach ($id_search_all as $id_search)
                {

                    $id_=invoice_type_id_ogren($id_search);
                    $array_ids[]=$id_;

                }



                $this->db->where_in('geopos_invoices.invoice_type_id', $array_ids);
            }
            else
            {
                $id_=invoice_type_id_ogren($id_search_all[0]);
                $this->db->where('geopos_invoices.invoice_type_id', $id_);
            }


        }
        else
        {
            $type=array(35,36,43,44,29,30,47,48);
            $this->db->where_in('geopos_invoice_type.id',$type);
        }

        if (!empty($_POST['columns'][3]['search']['value'])) //Proje
        {

            $id_search_all = explode('|',$_POST['columns'][3]['search']['value']);


            if(count($id_search_all)>1)
            {
                $array_ids=array();
                foreach ($id_search_all as $id_search)
                {

                    $id_=proje_id_ogren($id_search);
                    $array_ids[]=$id_;

                }



                $this->db->where_in('geopos_invoices.proje_id', $array_ids);
            }
            else
            {
                $id_=invoice_type_id_ogren($id_search_all[0]);
                $this->db->where('geopos_invoices.proje_id', $id_);
            }

        }

        if (!empty($_POST['columns'][5]['search']['value'])) //Ödeme Tİpi
        {
            $id_search_all = explode('|',$_POST['columns'][5]['search']['value']);
            if(count($id_search_all)>1)
            {
                $array_ids=array();
                foreach ($id_search_all as $id_search)
                {

                    $id_=odeme_tipi_id_ogren($id_search);
                    $array_ids[]=$id_;

                }



                $this->db->where_in('geopos_invoices.method', $array_ids);
            }
            else
            {
                $id_=odeme_tipi_id_ogren($id_search_all[0]);
                $this->db->where('geopos_invoices.method', $id_);
            }



        }



        $this->db->where('geopos_invoices.csd',$id);

        $this->db->order_by('DATE(geopos_invoices.invoicedate)', 'ASC');







        $i = 0;



        foreach ($this->inv_column_search as $item) // loop column

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



                if (count($this->inv_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }





    }
    // Sipariş



    function customer_siparis_datatables($id,$tyd=0,$para_birimi)

    {

        $query=$this->_customer_siparis($id,$tyd,$para_birimi);





        return $query;

    }


    private function _customer_siparis($id,$tyd=0,$para_birimi)

    {


        return $this->db->query("select *
from (
      SELECT 'Sipariş Fişi' as description,geopos_purchase.invoicedate,
          'null' as odeme_tipi,
            geopos_purchase.total as borc,
            0 as alacak,
        geopos_purchase.total,1 as kur_degeri,
        'income'as transactions From geopos_purchase

        where geopos_purchase.csd=$id and geopos_purchase.status=3


        UNION ALL
        SELECT geopos_invoice_type.description,geopos_invoices.invoicedate,
          IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,
        IF(geopos_invoice_type.transactions='income',geopos_invoices.total,NULL) as borc,
        IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,NULL) as alacak,
        geopos_invoices.total,geopos_invoices.kur_degeri,
        geopos_invoice_type.transactions  FROM geopos_invoices
        LEFT JOIN geopos_invoice_type on geopos_invoices.invoice_type_id=geopos_invoice_type.id
        Where geopos_invoices.csd=$id and (geopos_invoices.invoice_type_id=3 or geopos_invoices.invoice_type_id=4)


       ) a
        ORDER BY invoicedate DESC")->result_array();











    }

    function customer_ekstre_datatables_bekleyen_odeme($id,$tyd=0,$para_birimi,$kdv_durum,$proje_id=0,$tahvil=0)

    {

        $this->_customer_extre_bekleyen_odeme($id,$tyd,$para_birimi,$kdv_durum,$proje_id,$tahvil);



        if ($_POST['length'] != -1)
        {

            $this->db->limit(10000, 0);
        }
        else
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }



        $query = $this->db->get();


        return $query->result();

    }

    private function _customer_extre_bekleyen_odeme($id,$tyd=0,$para_birimi,$kdv_durum,$proje_id=0,$tahvil=0)

    {



        $this->db->select("*");
        $this->db->from('geopos_talep');
        $this->db->where_in('status',[3,5]);



        if(!empty($proje_id))
        {
            $this->db->where_in('geopos_talep.proje_id',$proje_id);

        }


        $this->db->where('geopos_talep.talep_eden_pers_id',$id);
        $this->db->where('geopos_talep.cari_pers',2);
        $this->db->order_by('DATE(geopos_talep.olusturma_tarihi)', 'ASC');


        $i = 0;

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



                $this->db->where_in('geopos_talep.proje_id', $array_ids_proje);
            }
            else
            {
                $id_proje=proje_id_ogren($id_search_all_proje[0]);
                $this->db->where('geopos_talep.proje_id', $id_proje);
            }

        }

        foreach ($this->inv_column_search as $item) // loop column

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



                if (count($this->inv_column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }





    }


    public function devir_bakiye($id)
    {

        if (($this->input->post('start_date') && $this->input->post('end_date') ) || $_POST['start']>0) // if datatable send POST for search
        {
            $bakiye=0;
            $bakiyes=0;
            $where='';
            $limit='';


            $d=datefordatabasefilter($this->input->post('start_date'));
            $query1 = $this->db->query("SELECT geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoices.kur_degeri,
IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi, IF(geopos_invoice_type.transactions='income',
geopos_invoices.total,0) as borc, IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,0) as alacak,
 geopos_invoices.total, geopos_invoice_type.transactions FROM geopos_invoices LEFT JOIN geopos_invoice_type on
 geopos_invoices.invoice_type_id=geopos_invoice_type.id WHERE geopos_invoices.csd=$id and
 geopos_invoices.invoice_type_id  IN(1,2,3,4,7,8,17,18,19,20,21,22,23,24,38,43,44,45,46,54,55,47,48)  AND  DATE(geopos_invoices.invoicedate) <'$d'  ORDER BY
 `geopos_invoices`.`invoicedate` ASC");



            $rowss = $query1->result_array();
            foreach ($rowss as $rows)
            {
                $bakiyes+=($rows['alacak']*$rows['kur_degeri'])-($rows['borc']*$rows['kur_degeri']);
            }


            if($this->input->post('start_date') && $_POST['start']==0)
            {

                $d=datefordatabasefilter($this->input->post('start_date'));
                $d1=datefordatabasefilter($this->input->post('end_date'));
                //$where.="AND DATE(geopos_invoices.invoicedate) >'$d'";  //2019-11-24 14:28:57
                $where.="AND DATE(geopos_invoices.invoicedate) <'$d'";  //2019-11-24 14:28:57
            }


            else if($this->input->post('start_date') && $_POST['start'] > 0)
            {



                $bakiye+=$bakiyes;

                $d=datefordatabasefilter($this->input->post('start_date'));
                $d1=datefordatabasefilter($this->input->post('end_date'));
                $where.="AND DATE(geopos_invoices.invoicedate) >='$d'";  //2019-11-24 14:28:57>=
                $where.="AND DATE(geopos_invoices.invoicedate) <='$d1'";  //2019-11-24 14:28:57 >=

                $str=$_POST['start'];
                $limit="LIMIT $str";

                // $this->db->limit($_POST['length'], $_POST['start']);
            }

            else  if($_POST['start']>0)
            {

                $str=$_POST['start'];
                $limit="LIMIT $str";

                // $this->db->limit($_POST['length'], $_POST['start']);
            }







            $query = $this->db->query("SELECT geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoices.kur_degeri,
IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi, IF(geopos_invoice_type.transactions='income',
geopos_invoices.total,0) as borc, IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,0) as alacak,
 geopos_invoices.total, geopos_invoice_type.transactions FROM geopos_invoices LEFT JOIN geopos_invoice_type on
 geopos_invoices.invoice_type_id=geopos_invoice_type.id WHERE geopos_invoices.csd=$id and
 geopos_invoices.invoice_type_id  IN(1,2,3,4,7,8,17,18,19,20,21,22,23,24,38,43,44,45,46,54,55,47,48) $where ORDER BY
 `geopos_invoices`.`invoicedate` ASC $limit");



            $row = $query->result_array();
            foreach ($row as $rows)
            {
                $bakiye+=($rows['alacak']*$rows['kur_degeri'])-($rows['borc']*$rows['kur_degeri']);
            }

            return $bakiye;
            // echo $bakiye;

        }





    }

    public function ajax_list_proje()
    {

        $this->_ajax_list_proje();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();
    }



    private function _ajax_list_proje()
    {
        $this->db->select('customers_project.id as cp_id,customers_project.proje_name,geopos_customers.*');
        $this->db->from('customers_project');
        $this->db->join('geopos_customers','customers_project.customer_id=geopos_customers.id');
        $i = 0;
        foreach ($this->column_search_p as $item) // loop column
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

                if (count($this->column_search_p) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`customers_project`.`id` DESC');
    }


    public function count_filtered_proje()
    {
        $this->_ajax_list_proje();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_proje()
    {
        $this->_ajax_list_proje();
        return $this->db->count_all_results();
    }

    public function create_project(){
        $name = $this->input->post('name');
        $firma_id = $this->input->post('firma_id');
        $data = array(
            'proje_name'=>$name,
            'customer_id'=>$firma_id,
            'aauth_id' => $this->aauth->get_user()->id,
        );
        if ($this->db->insert('customers_project', $data)) {
            $this->aauth->applog("Cariye Proje Oluşturuldu Cari_id: ".$firma_id, $this->aauth->get_user()->username);
            return [
                'status'=>1,
            ];
        }
        else {
            return [
                'status'=>0
            ];
        }
    }

    public function update_project(){
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $firma_id = $this->input->post('firma_id');
        $data = array(
            'proje_name'=>$name,
            'customer_id'=>$firma_id,
        );
        $this->db->where('id',$id);
        $this->db->set($data);
        if ($this->db->update('customers_project', $data)) {
            $this->aauth->applog("Cari Projesi Güncellendi. Cari_id: ".$firma_id, $this->aauth->get_user()->username);
            return [
                'status'=>1,
            ];
        }
        else {
            return [
                'status'=>0
            ];
        }
    }
















}
