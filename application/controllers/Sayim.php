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



class Sayim extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->model('sayim_model', 'sayim');
        $this->load->model('tools_model', 'tools');
        $this->load->model('communication_model');
        $this->load->library('parser');
        $this->load->model('templates_model', 'templates');

        $this->load->library("Aauth");

        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }



        if (!$this->aauth->premission(2)) {



            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');



        }



    }



    public function sayim_urunleri()
    {
        $data=array();

        $purchase_id = $this->input->post('purchase_id');
        $urunler2=array();

        $siparis_durumu=0;
        $sip_product=array();
        $urunler_prd=array();
        $key=0;

        if($purchase_id!=0)
        {
            $sayim_var_yok=$this->db->query("select DISTINCT(purchase_id)from geopos_sayim_to_purchase WHERE purchase_id=$purchase_id LIMIT 1");
            if($sayim_var_yok->num_rows()>0)
            {
                $urunler2=$this->db->query("SELECT geopos_sayim_items.pid,geopos_sayim_items.product, 
geopos_sayim_items.toplam_rulo as qty,
geopos_sayim_items.siparis_qty/ ((geopos_products.en*geopos_products.boy)/10000) as siparis_qty FROM `geopos_sayim_to_purchase`  
INNER JOIN geopos_sayim on geopos_sayim_to_purchase.sayim_id=geopos_sayim.id INNER JOIN geopos_sayim_items on
 geopos_sayim.id=geopos_sayim_items.tid INNER JOIN geopos_products on geopos_sayim_items.pid=geopos_products.pid 
 WHERE geopos_sayim_to_purchase.purchase_id=$purchase_id GROUP BY geopos_sayim_items.pid
")->result_array();

                $siparis_products=$this->db->query("SELECT geopos_purchase_items.pid,geopos_purchase_items.product,0 as qty,geopos_purchase_items.qty/((geopos_products.en*geopos_products.boy)/10000) as siparis_qty FROM geopos_purchase_items INNER JOIN geopos_products on geopos_purchase_items.pid=geopos_products.pid 
WHERE geopos_purchase_items.tid=$purchase_id
")->result_array();


                foreach ($siparis_products as $sip) // 4 adet ID
                {
                    $sip_product[]=$sip['pid'];

                }


                foreach ($urunler2 as $sip) // 4 adet ID
                {

                    $urunler_prd[]=$sip['pid'];
                }

                if(isset($urunler2))
                {



                    $data_product=array_diff($sip_product,$urunler_prd);

                    $data_urunler=array();

                    if(isset($data_product))
                    {


                        for ($i=0;$i<count($siparis_products);$i++)
                        {
                            if(isset($data_product[$i]))
                            {

                                $siparis_detay_ogren=siparis_detay_ogren($purchase_id,$data_product[$i]);

                                $data_urunler[]=array(
                                    'pid'=>$siparis_detay_ogren['product_id'],
                                    'product'=>$siparis_detay_ogren['product_name'],
                                    'qty'=>0,
                                    'siparis_qty'=>rulo_miktari_sorgula_purchase($siparis_detay_ogren['product_id'],$purchase_id)
                                );
                            }


                        }
                        $urunler = array_merge($urunler2,$data_urunler);
                    }
                    else
                    {
                        $urunler=$urunler2;
                    }
                }






                foreach ($urunler as $urun)
                {
                    $qty=floatval($urun['siparis_qty'])-floatval($urun['qty']);


                    if($qty==0 )
                    {
                        $siparis_durumu=1;
                    }
                    else
                    {
                        $siparis_durumu=0;
                    }

                    $data[]=array(
                        'product_id'=>$urun['pid'],
                        'product_name'=>product_name($urun['pid']),
                        'qty'=>$qty,
                        'stok_mik'=>stok_ogren($urun['pid']),
                        'siparis_durumu'=>$siparis_durumu
                    );
                }








            }
            else
            {
                $urunler=$this->sayim->purchase_products($purchase_id);
                foreach ($urunler as $urun)
                {
                    $data[]=array(
                        'durum'=>'siparis_sayimi',
                        'product_id'=>$urun['pid'],
                        'product_name'=>product_name($urun['pid']),
                        'qty'=>$urun['rulo_miktari'],
                        'stok_mik'=>stok_ogren($urun['pid']),
                        'siparis_durumu'=>$siparis_durumu
                    );
                }
            }
        }
        else
            {
                $data[]=array(
                    'durum'=>'depo_sayimi',
                    'product_id'=>0,
                    'product_name'=>0,
                    'qty'=>0,
                    'stok_mik'=>0,
                    'siparis_durumu'=>0
                );
            }







        echo json_encode($data);



    }

    public function sayim_urunleri_edit()
    {
        $data=array();
        $purchase_id = $this->input->post('purchase_id');
        $urunler=$this->sayim->purchase_products($purchase_id);

        foreach ($urunler as $urun)
        {
            $data[]=array(
                'product_id'=>$urun['pid'],
                'qty'=>$urun['qty'],
                'stok_mik'=>stok_ogren($urun['pid']+rezerv_stok_ogren($urun['pid']))
            );
        }

        echo json_encode($data);


    }


    public function new_sayim()
    {
        $data['purchases']=$this->sayim->purchases();

        $head['title'] = "Yeni Sayım";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('sayim/new_sayim', $data);

        $this->load->view('fixed/footer');
    }

    //create invoice

    public function create()

    {

        $purchase_id = intval($this->input->get('purchase_id'));
        $this->load->model('products_model', 'products');

        $user_id = $this->input->get('user_id');

        if($user_id)
        {
            $data['products']=$this->products->cart_details($user_id);
            $data['user_id_cart']=$user_id;

        }
        else
        {
            $data['products']=0;
            $data['user_id_cart']=0;
        }

        $data['purchase_id']=$purchase_id;

        $data['products']=$this->sayim->purchase_products($purchase_id);

        $data['emp'] = $this->sayim->employees();
        $data['projeler'] = $this->sayim->projeler();
        $this->load->library("Common");

        $data['taxlist'] = $this->common->taxlist($this->config->item('tax'));

        $this->load->model('plugins_model', 'plugins');

        $data['exchange'] = $this->plugins->universal_api(5);

        $data['currency'] = $this->sayim->currencies();

        $this->load->model('customers_model', 'customers');

        $data['customergrouplist'] = $this->customers->group_list();

        $data['lastinvoice'] = $this->sayim->lastsayim();

        $data['terms'] = $this->sayim->billingterms();

        $head['title'] = "Yeni Sayım";

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['warehouse'] = $this->sayim->warehouses();

        $data['taxdetails'] = $this->common->taxdetail();

        $this->load->view('fixed/header', $head);

        $this->load->view('sayim/newinvoice', $data);

        $this->load->view('fixed/footer');

    }



    //edit invoice

    public function edit()

    {



        $tid = $this->input->get('id');

        $purchase_details=purchase_in_sayim($tid);


        $data['id'] = $tid;

        $data['title'] = "Sayım Düzenle $tid";


        $data['purchase_id']=$purchase_details['id'];

        $this->load->model('customers_model', 'customers');

        $data['customergrouplist'] = $this->customers->group_list();

        $data['terms'] = $this->sayim->billingterms();

        $data['invoice'] = $this->sayim->sayim_details($tid);

        $data['products'] = $this->sayim->sayim_products($tid);;

        $head['title'] = "Sayım Düzenle #$tid";

        $head['usernm'] = $this->aauth->get_user()->username;

        $data['warehouse'] = $this->sayim->warehouses();

        $data['currency'] = $this->sayim->currencies();

        $this->load->model('plugins_model', 'plugins');

        $data['exchange'] = $this->plugins->universal_api(5);

        $this->load->library("Common");

        $data['taxlist'] = $this->common->taxlist_edit($data['invoice']['taxstatus']);

        $this->load->view('fixed/header', $head);

        $this->load->view('sayim/edit', $data);

        $this->load->view('fixed/footer');



    }



    //invoices list

    public function index()

    {

        $head['title'] = "Sayım Listesi";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('sayim/invoices');

        $this->load->view('fixed/footer');

    }



    //action

    public function action()

    {
        $this->db->trans_start();
        $urunler2='';
        $purchase_id = $this->input->post('purchase_id');
        $notes = $this->input->post('notes');
        $prodindex=0;
        $i=0;
        $order_name='';
        $productlist=array();
        $farli_prd=array();
        if($purchase_id)
        {

            $siparis_details=$this->db->query("Select * From geopos_purchase Where id=$purchase_id")->row_array();
            if($siparis_details)
            {
                $order_name=$siparis_details['tid'];
                $data = array(
                    'notes' => $notes,
                    'sayim_name' => $siparis_details['tid'].' Numaralı Sipariş Sayımı',
                    'csd' => $siparis_details['csd'], // siparişteki müşteri
                    'eid' => $this->aauth->get_user()->id, //sayımı yapan personel
                    'purchase_id' => $purchase_id //sayımı yapan personel
                );





                if ($this->db->insert('geopos_sayim', $data)) {

                    $invocieno = $this->db->insert_id();

                    // Sayım yapılan siparişin sayım ID Eklenir
                    $data = array(
                        'purchase_id' => $siparis_details['id'],
                        'sayim_id' =>$invocieno
                    );



                    $this->db->insert('geopos_sayim_to_purchase', $data);

                    $sayim_to_purchase_id = $this->db->insert_id();

                    // Sayım yapılan siparişin sayım ID Eklenir

                    //-----------------------------------------------------------------







                    $pid = $this->input->post('pid');
                    $product_name = $this->input->post('product_name');
                    $product_qty = $this->input->post('product_qty');

                    foreach ($pid as $key => $value)
                    {
                        $toplam_rulo=0;
                        if($pid[$key]!=0)
                        {
                            $product_details = $this->db->query("select * from geopos_products WHERE  pid = $pid[$key]")->row_array();
                            $m2=$product_details['en']*$product_details['boy'] /10000; // 3m2
                            $qty= $product_qty[$key]*$m2;

                            $item_detais=$this->db->query("Select * From geopos_purchase_items Where tid=$purchase_id and pid=$pid[$key]")->row_array();
                            $data2=array(
                                'tid'=>$invocieno,
                                'pid'=>$pid[$key],
                                'siparis_qty'=>$item_detais['qty'],
                                'product'=>$product_name[$key],
                                'toplam_rulo'=>$product_qty[$key],
                                'qty'=>$qty,
                                'unit'=>product_unit($pid[$key])
                            );

                            $productlist[$prodindex] = $data2;

                            $i++;

                            $prodindex++;



                            $product_id=$pid[$key];
                            $product_details = $this->db->query("select * from geopos_products WHERE  pid = $product_id")->row_array();

                            if ($product_details['parent_id'] != 0) {

                                $parent_id = $product_details['parent_id'];
                                if ($product_details['en'] != 0 || $product_details['boy'] != 0) {

                                    $m2 = $product_details['en'] * $product_details['boy'] / 10000;

                                    $eklenecek_stok = $m2 * $product_qty[$key];

                                    $toplam_rulo=$eklenecek_stok/$m2;
                                }
                                else
                                {
                                    $eklenecek_stok = $product_qty[$key];
                                    $toplam_rulo=0;
                                }




                                //$this->rezerv_stock_update($eklenecek_stok,$parent_id, 1,$toplam_rulo); //ana ürüne eklenecek 730

                                //$this->rezerv_stock_update($eklenecek_stok,$product_id, 1,$toplam_rulo); //731


                            } else {
                                //$this->rezerv_stock_update($product_qty[$key], $product_id,1,$toplam_rulo);

                            }







                            //$data_true_false[$prodindex] = $this->purchase_qty_kontrol($purchase_id,$pid[$key],$product_qty[$key]);

                        }



                    }






                    $siparis_products=$this->db->query("SELECT geopos_purchase_items.pid,geopos_purchase_items.product,0 as qty,geopos_purchase_items.qty as siparis_qty FROM geopos_purchase_items WHERE geopos_purchase_items.tid=$purchase_id
")->result_array();

                    $urunler2=array();


                    $urunler2=$this->sayim->urunler($purchase_id);




                    if($urunler2!=0)
                    {

                        foreach ($siparis_products as $sip)
                        {
                            $sip_product[]=$sip['pid'];
                        }

                        foreach ($urunler2 as $sip)
                        {
                            $urunler_prd[]=$sip['pid'];
                        }

                        $data_product=array_diff($sip_product,$urunler_prd);


                        if($data_product)
                        {
                            foreach ($data_product as $key => $value)
                            {
                                $farli_prd[]=array(
                                    'pid'=>$value,
                                    'siparis_qty'=>siparis_detay_ogren($purchase_id,$value)['qty'],
                                    'qty'=>0
                                );
                            }


                            $result = array_merge($farli_prd, $productlist);


                        }

                        else
                        {
                            $result = array_merge($urunler2, $productlist);
                        }


                    }
                    else
                    {
                        $result = $productlist;
                    }







                    $res2=$this->stok_topla($result);




                    $eksik_var=1;

                    //echo '<pre>';var_dump($res2);die();
                    foreach ($res2 as $prd)
                    {

                        if(floatval($prd['qty'])==floatval($prd['siparis_qty']))
                        {
                            $eksik_var=0;
                        }

                    }


                    if($eksik_var==0)
                    {
                        //sipariş durumu tamamlandı

                        $this->db->set('sayim_durumu', '1');

                        $this->db->where('id', $purchase_id);

                        $this->db->update('geopos_purchase');
                    }




                    if ($prodindex > 0) {

                        $this->db->insert_batch('geopos_sayim_items', $productlist);

                        $this->db->trans_complete();


                        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('sayim_order_success') .
                            "<a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'>

                            </span>" . $this->lang->line('View') . " </a>"));








                    } else {
                        $this->db->trans_rollback();

                        echo json_encode(array('status' => 'Error', 'message' =>

                            "Lütfen ürün listesinden ürün seçiniz. Ürünleri eklemediyseniz, Öğe yöneticisi bölümüne gidin."));

                    }
                }


            }


        }


    }

    public function stok_topla($data) {
        //echo '<pre>';var_dump($data);die();
        $groups = array();
        foreach ($data as $item) {


            $key = $item['pid'];


            if (!array_key_exists($key, $groups)) {
                $groups[$key] = array(
                    'pid' => $item['pid'],
                    'qty' => $item['qty'],
                    'siparis_qty' => $item['siparis_qty'],
                );
            } else {
                $groups[$key]['qty'] = $groups[$key]['qty'] + $item['qty'];
                $groups[$key]['siparis_qty'] =  $item['siparis_qty'];
            }
        }
        return $groups;
    }

    public function iptal_et()
    {
        $id = $this->input->post('id');
        $order_details=purchase_in_sayim($id);
        $order_name=$order_details['tid'];
        $invocieno=$order_details['id'];

        $order_products_details=sayim_products_details($id);

        foreach ($order_products_details as $prd)
        {
            $this->rezerv_stock_update($prd['qty'],$prd['pid'],2);
        }


        $this->db->set('new_status', 'iptal_edildi');

        $this->db->where('id', $id);

        $this->db->update('geopos_sayim');



        $this->db->set('sayim_id', 0);

        $this->db->set('sayim_durumu', 0);

        $this->db->where('id', $invocieno);

        $this->db->update('geopos_purchase');

        echo json_encode(array('status' => 'Success', 'message' =>

            "Sayım Başarıyla İptal Edildi
             <a href='/sayim/create?purchase_id=$invocieno' class='btn btn-info btn-lg'><span class='icon-plus-circle' aria-hidden='true'></span> Yeni Sayım </a>
            "));
    }


    public function onay_iste()
    {
        $id = $this->input->post('id');

        $order_details=purchase_in_sayim($id);


        $order_name=$order_details['tid'];
        $invocieno=$id;

        //Yetkiliye mail gönderme

        $mail_adresi=sayim_onay_mail();
        $mailtoc = $mail_adresi['email']; // Yetkili mail adresi
        $mailtotilte = 'Sayım İçin Onay Bilgisi';
        $subject = 'Sayım İçin Onay Bilgisi';

        $message = 'Sayın Yetkili '.$order_name. ' Numaralı Sipariş İçin Onayınız Gerekmektedir';
        $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
        $firma_kodu=$dbnames['firma_kodu'];
        $validtoken = hash_hmac('ripemd160', 'p' . $invocieno, $this->config->item('encryption_key'));


        $href="https://muhasebe.italicsoft.com/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$invocieno&type=onay&token=$validtoken";
        $message .="<br>İncelemek İçin<a href='$href'>Tıklayınız</a>";

        $message.='<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');


        $this->send_mail($mailtoc,$mailtotilte,$subject,$message);


        $this->db->set('mail_durumu', 1);

        $this->db->where('id', $id);

        $this->db->update('geopos_sayim');

        echo json_encode(array('status' => 'Success', 'message' =>

            "Admine Onay Talebi Başarıyla Gönderildi"));

        //Yetkiliye mail gönderme
    }




    public function send_mail($mailtoc,$mailtotilte,$subject,$message)
    {
        $attachmenttrue = false;
        $attachment = '';
        $this->communication_model->send_email($mailtoc, $mailtotilte, $subject, $message, $attachmenttrue, $attachment);

    }




    public function push()
    {
        $this->load->library('rest', array(
            'server' => 'http://twitter.com/',
            'http_user' => 'username',
            'http_pass' => 'password',
            'http_auth' => 'basic'
        ));

        $user = $this->rest->post('statuses/update.json', array('status' => 'Using the REST client to do stuff'));

    }





    public function ajax_list()

    {



        $list = $this->sayim->get_datatables();

        $data = array();



        $no = $this->input->post('start');



        foreach ($list as $invoices) {

            $no++;

            $row = array();

            $row[] = $no;

            $row[] = $invoices->sayim_name;

            $row[] = $invoices->name;

            $row[] = dateformat($invoices->invoicedate);

            $row[] = '<span> ' . $this->lang->line($invoices->new_status) . '</span>';

            $row[] = '<a href="' . base_url("sayim/view?id=$invoices->id") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("sayim/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-xs"  title="indir"><span class="icon-download"></span><i class="fa fa-download" aria-hidden="true"></i></a>';



            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->sayim->count_all(),

            "recordsFiltered" => $this->sayim->count_filtered(),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }





    public function view()

    {

        $this->load->model('accounts_model');

        $data['acclist'] = $this->accounts_model->accountslist((integer)$this->aauth->get_user()->loc);

        $tid = intval($this->input->get('id'));

        $data['id'] = $tid;

        $head['title'] = "Sayım $tid";

        $data['invoice'] = $this->sayim->sayim_details($tid);

        $data['products'] = $this->sayim->sayim_products($tid);

        $data['activity'] = $this->sayim->sayim_transactions($tid);

        $data['attach'] = $this->sayim->attach($tid);

        $data['employee'] = $this->sayim->employee($data['invoice']['eid']);

        $head['usernm'] = $this->aauth->get_user()->username;

        $user_id = $this->aauth->get_user()->id;

        $data['gorev_durumu']=$this->sayim->gorev_durumu($tid,$user_id);

        $this->load->view('fixed/header', $head);
        if($data['invoice']['purchase_id'])
        {
            if($data['invoice']) $this->load->view('sayim/view', $data);
        }

        else
            {
                if($data['invoice']) $this->load->view('sayim/depo_sayim_view', $data);
            }



        $this->load->view('fixed/footer');



    }





    public function printinvoice()

    {



        $tid = $this->input->get('id');



        $data['id'] = $tid;

        $data['title'] = "sayim $tid";

        $data['invoice'] = $this->sayim->sayim_details($tid);

        $data['products'] = $this->sayim->sayim_products($tid);

        $data['employee'] = $this->sayim->employee($data['invoice']['eid']);

        $data['invoice']['multi'] = 0;



        ini_set('memory_limit', '64M');





        //PDF Rendering





        if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {

            $html = $this->load->view('sayim/view-print-gstin', $data, true);

        } else {

            $html = $this->load->view('sayim/view-print-' . LTR, $data, true);

        }

        $header = $this->load->view('sayim/header-print-' . LTR, $data, true);

        //PDF Rendering

        $this->load->library('pdf');



        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');



        $pdf->WriteHTML($html);



        if ($this->input->get('d')) {



            $pdf->Output('sayim_#' . $data['invoice']['tid'] . '.pdf', 'D');

        } else {

            $pdf->Output('sayim_#' . $data['invoice']['tid'] . '.pdf', 'I');

        }





    }

    public function print_depo_fisi()

    {



        $tid = $this->input->get('id');



        $data['id'] = $tid;

        $data['title'] = "sayim $tid";

        $data['invoice'] = $this->sayim->sayim_details($tid);

        $data['products'] = $this->sayim->sayim_products($tid);

        $data['employee'] = $this->sayim->employee($data['invoice']['eid']);

        $data['invoice']['multi'] = 0;



        ini_set('memory_limit', '64M');





        //PDF Rendering





        if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {

            $html = $this->load->view('sayim/view-print-gstin', $data, true);

        } else {

            $html = $this->load->view('sayim/view-print-depo-' . LTR, $data, true);

        }

        $header = $this->load->view('sayim/header-print-' . LTR, $data, true);

        //PDF Rendering

        $this->load->library('pdf');



        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');



        $pdf->WriteHTML($html);



        if ($this->input->get('d')) {



            $pdf->Output('sayim_#' . $data['invoice']['tid'] . '.pdf', 'D');

        } else {

            $pdf->Output('sayim_#' . $data['invoice']['tid'] . '.pdf', 'I');

        }





    }



    public function delete_i()

    {

        $id = $this->input->post('deleteid');



        if ($this->sayim->sayim_delete($id)) {

            echo json_encode(array('status' => 'Success', 'message' =>

                "Sipariş :  #$id Başarıyla Silindi.!"));



        } else {



            echo json_encode(array('status' => 'Error', 'message' =>

                "Sipariş Silinirken Hata Oluştur."));

        }



    }



    public function editaction()

    {





        $invocieno = $this->input->post('iid');

        $purchase_id = $this->input->post('purchase_id');


        $notes = $this->input->post('notes',true);


        $this->db->trans_start();

        $flag = false;
        $i = 0;

        $transok = true;

        //Product Data

        $pid = $this->input->post('pid');

        $productlist = array();

        $prodindex = 0;

        $this->db->delete('geopos_sayim_items', array('tid' => $invocieno));





        foreach ($pid as $key => $value) {
            $toplam_rulo=0;



            $product_id = $this->input->post('pid');

            $product_name1 = $this->input->post('product_name',true);

            $product_qty = $this->input->post('product_qty');

            $old_product_qty = $this->input->post('old_product_qty');

            if ($old_product_qty == '') $old_product_qty = 0;



            if($pid[$key]!=0) {
                $item_detais = $this->db->query("Select * From geopos_purchase_items Where tid=$purchase_id and pid=$pid[$key]")->row_array();

                $product_details = $this->db->query("select * from geopos_products WHERE  pid = $pid[$key]")->row_array();
                $m2=$product_details['en']*$product_details['boy'] /10000; // 3m2
                $qty= $product_qty[$key]*$m2;

                $data = array(

                    'tid' => $invocieno,

                    'pid' => $product_id[$key],

                    'product' => $product_name1[$key],

                    'toplam_rulo'=>$product_qty[$key],

                    'qty'=>$qty,

                    'siparis_qty' => $item_detais['qty'],

                    'unit' => product_unit($pid[$key])

                );

                if(isset($old_product_qty[$key]))
                {
                    $old_product_qty[$key] = $old_product_qty[$key];
                }
                else
                {
                    $old_product_qty[$key]=0;
                }




                $amt = $product_qty[$key] - $old_product_qty[$key];

                if ($product_id[$key] > 0) {

                    $product_details = $this->db->query("select * from geopos_products WHERE  pid = $product_id[$key]")->row_array();

                    if ($product_details['parent_id'] != 0) {

                        $parent_id = $product_details['parent_id'];
                        if($product_details['en']!=0 || $product_details['boy']!=0 )
                        {

                            $m2=$product_details['en']*$product_details['boy'] /10000; // 3m2

                            $eklenecek_stok=$amt;

                            $toplam_rulos=$eklenecek_stok/$m2; //6

                            $old_rulo= old_rulo_quantity_sayim($product_id[$key],$invocieno); // 7

                            if(isset($old_rulo))
                            {

                                $toplam_rulo = (+$toplam_rulos) - (+$old_rulo[$key]);
                            }

                        }
                        else
                        {
                            $eklenecek_stok=$amt;
                            $toplam_rulo=0;
                        }




                        $this->rezerv_stock_update($eklenecek_stok, $parent_id, 1,$toplam_rulo); //ana ürüne eklenecek 730

                        $this->rezerv_stock_update($amt, $product_id[$key], 1,$toplam_rulo); //731


                    } else {
                        $this->rezerv_stock_update($amt, $product_id[$key], 1,$toplam_rulo);

                    }





                }


                $productlist[$prodindex] = $data;

                $i++;

                $prodindex++;
            }

            $flag = true;



        }






        $data = array
        (
            'notes' => $notes
        );

        $this->db->set($data);

        $this->db->where('id', $invocieno);



        if ($flag) {



            if ($this->db->update('geopos_sayim', $data)) {

                $this->db->insert_batch('geopos_sayim_items', $productlist);

                echo json_encode(array('status' => 'Success', 'message' =>

                    "Sipariş Başarıyla Güncellendi! 
                     <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> Görüntüle </a> "));

            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "There is a missing field!"));

                $transok = false;

            }


        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                "Please add atleast one product in order!"));

            $transok = false;

        }


        if ($this->input->post('restock')) {

            foreach ($this->input->post('restock') as $key => $value) {
                $myArray = explode('-', $value);

                $prid = $myArray[0];

                $dqty = $myArray[1];

                $sayim_product_details=sayim_product($prid);


                if ($prid > 0) {


                    $this->rezerv_stock_update($dqty,$prid,2,$sayim_product_details['toplam_rulo']);

                }

            }

        }





        if ($transok) {

            $this->db->trans_complete();

        } else {

            $this->db->trans_rollback();

        }

    }



    public function update_status()

    {

        $tid = $this->input->post('tid');

        $status = $this->input->post('status');





        $this->db->set('new_status', $status);

        $this->db->where('id', $tid);

        $this->db->update('geopos_sayim');



        echo json_encode(array('status' => 'Success', 'message' =>

            'Sipariş Durumu Başarıyla Değiştirildi', 'pstatus' => $status));

    }



    public function file_handling()

    {

        if ($this->input->get('op')) {

            $name = $this->input->get('name');

            $invoice = $this->input->get('invoice');

            if ($this->sayim->meta_delete($invoice, 4, $name)) {

                echo json_encode(array('status' => 'Success'));

            }

        } else {

            $id = $this->input->get('id');

            $this->load->library("Uploadhandler_generic", array(

                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'

            ));

            $files = (string)$this->uploadhandler_generic->filenaam();

            if ($files != '') {



                $this->sayim->meta_insert($id, 4, $files);

            }

        }

    }

    public function gorevi_tamamla()
    {
        // Sayım Yapan personelin görevi tamamlandı olarak değiştirili

        $purchase_id = $this->input->post('purchase_id');

        $this->db->set(array('status' => 'Done'));

        $this->db->where('purchase_id', $purchase_id);

        $this->db->update('geopos_todolist');
        echo json_encode(array('status' => 'Success', 'message' =>

            'Göreviniz Başarıyla Tamamlanmıştır!'));



        // Sayım Yapan personelin görevi tamamlandı olarak değiştirili
    }

    public function rezerv_stock_update($amt,$product_id,$invoice_type,$toplam_rulo)
    {

        $prd_deta = $this->db->query("select * from geopos_products WHERE  pid = $product_id")->row_array();

        $toplam_agirlik=0;

        if($prd_deta['en']!=0 || $prd_deta['boy']!=0 )
        {

            $en = $prd_deta['en']; //200
            $boy = $prd_deta['boy']; //20000
            $metrekare_agirligi = $prd_deta['metrekare_agirligi']/1000; //kg çevrildi
            $m2=$en*$boy/10000; //m2 çevrildi
            $toplam_m2=$amt;
            $toplam_agirlik=$metrekare_agirligi*$toplam_m2;
        }


        else
        {
            $metrekare_agirligi = $prd_deta['metrekare_agirligi']/1000; //kg çevrildi
            $toplam_agirlik=$metrekare_agirligi*$amt;
        }

        $operator1="qty-$amt";
        $operator2="toplam_agirlik-$toplam_agirlik";
        $operator3="rezerv_qty+$amt";
        $operator4="rezerv_toplam_agirlik+$toplam_agirlik";
        $operator5="rezerv_toplam_rulo+$toplam_rulo";
        $operator6="toplam_rulo+$toplam_rulo";


        if($invoice_type==1)
        {

            $operator1= "qty-$amt";
            $operator2= "toplam_agirlik-$toplam_agirlik";

            $operator3= "rezerv_qty+$amt";
            $operator4= "rezerv_toplam_agirlik+$toplam_agirlik";
            $operator5="rezerv_toplam_rulo+$toplam_rulo";
            $operator6="toplam_rulo+$toplam_rulo";
        }
        else if($invoice_type==2)
        {
            $operator1= "qty+$amt";
            $operator2= "toplam_agirlik+$toplam_agirlik";

            $operator3="rezerv_qty-$amt";
            $operator4= "rezerv_toplam_agirlik-$toplam_agirlik";
            $operator5="rezerv_toplam_rulo-$toplam_rulo";
            $operator6="toplam_rulo-$toplam_rulo";
        }

        else if($invoice_type==7)
        {
            $operator1= "qty+$amt";
            $operator2= "toplam_agirlik+$toplam_agirlik";
            $operator3="rezerv_qty-$amt";
            $operator4= "rezerv_toplam_agirlik-$toplam_agirlik";
            $operator5="rezerv_toplam_rulo-$toplam_rulo";
            $operator6="toplam_rulo-$toplam_rulo";
        }

        else if($invoice_type==8)
        {
            $operator1= "qty-$amt";
            $operator2= "toplam_agirlik-$toplam_agirlik";

            $operator3= "rezerv_qty+$amt";
            $operator4= "rezerv_toplam_agirlik+$toplam_agirlik";
            $operator5="rezerv_toplam_rulo+$toplam_rulo";
            $operator6="toplam_rulo-$toplam_rulo";
        }


        $this->db->set('qty', "$operator1", FALSE);
        $this->db->set('toplam_agirlik', "$operator2", FALSE);
        $this->db->set('rezerv_qty', "$operator3", FALSE);

        $this->db->set('rezerv_toplam_agirlik', "$operator4", FALSE);
        $this->db->set('rezerv_toplam_rulo', "$operator5", FALSE);
        $this->db->set('toplam_rulo', "$operator6", FALSE);


        $this->db->where('pid', $product_id);
        $this->db->update('geopos_products');




    }


    //action

    public function action_depo()

    {
        $this->db->trans_start();
        $date=date('m-d-Y');
        $notes = $this->input->post('notes');
        $prodindex=0;
        $i=0;
        $order_name='';
        $productlist=array();
        $farli_prd=array();

                $order_name='Depo Sayımı :'.$date;
                $data = array(
                    'notes' => $notes,
                    'sayim_name' => $date.' Tarihli Sayım',
                    'eid' => $this->aauth->get_user()->id, //sayımı yapan personel
                );





                if ($this->db->insert('geopos_sayim', $data)) {

                    $invocieno = $this->db->insert_id();

                    $pid = $this->input->post('pid');
                    $product_name = $this->input->post('product_name');
                    $product_qty = $this->input->post('product_qty');

                    foreach ($pid as $key => $value)
                    {
                        if($pid[$key]!=0)
                        {
                           $data2=array(
                                'tid'=>$invocieno,
                                'pid'=>$pid[$key],
                                'product'=>$product_name[$key],
                                'qty'=>$product_qty[$key],
                                'unit'=>product_unit($pid[$key])
                            );

                            $productlist[$prodindex] = $data2;

                            $i++;

                            $prodindex++;



                        }



                    }


                    if ($prodindex > 0) {

                        $this->db->insert_batch('geopos_sayim_items', $productlist);

                        $this->db->trans_complete();


                        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('sayim_order_success') .
                            "<a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'>

                            </span>" . $this->lang->line('View') . " </a>"));








                    } else {
                        $this->db->trans_rollback();

                        echo json_encode(array('status' => 'Error', 'message' =>

                            "Lütfen ürün listesinden ürün seçiniz. Ürünleri eklemediyseniz, Öğe yöneticisi bölümüne gidin."));

                    }
                }




    }

    //edit invoice

    public function edit_depo_sayim()

    {

        $tid = $this->input->get('id');
        $data['id'] = $tid;

        $data['title'] = "Sayım Düzenle $tid";

        $data['invoice'] = $this->sayim->sayim_details($tid);

        $data['products'] = $this->sayim->sayim_products($tid);;

        $head['title'] = "Sayım Düzenle #$tid";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('sayim/edit_depo_sayim', $data);

        $this->load->view('fixed/footer');



    }


    public function editdepoaction()

    {





        $invocieno = $this->input->post('iid');

        $notes = $this->input->post('notes',true);


        $this->db->trans_start();

        $flag = false;
        $i = 0;

        $transok = true;

        //Product Data

        $pid = $this->input->post('pid');

        $productlist = array();

        $prodindex = 0;

        $this->db->delete('geopos_sayim_items', array('tid' => $invocieno));





        foreach ($pid as $key => $value) {

            $product_id = $this->input->post('pid');

            $product_name1 = $this->input->post('product_name',true);

            $product_qty = $this->input->post('product_qty');

            $old_product_qty = $this->input->post('old_product_qty');



            if($pid[$key]!=0) {


                $data = array(

                    'tid' => $invocieno,

                    'pid' => $product_id[$key],

                    'product' => $product_name1[$key],

                    'qty'=>$product_qty[$key],

                    'unit' => product_unit($pid[$key])

                );


                $productlist[$prodindex] = $data;

                $i++;

                $prodindex++;
            }

            $flag = true;



        }






        $data = array
        (
            'notes' => $notes
        );

        $this->db->set($data);

        $this->db->where('id', $invocieno);



        if ($flag) {



            if ($this->db->update('geopos_sayim', $data)) {

                $this->db->insert_batch('geopos_sayim_items', $productlist);

                echo json_encode(array('status' => 'Success', 'message' =>

                    "Sipariş Başarıyla Güncellendi! 
                     <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> Görüntüle </a> "));

            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "There is a missing field!"));

                $transok = false;

            }


        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                "Please add atleast one product in order!"));

            $transok = false;

        }




        if ($transok) {

            $this->db->trans_complete();

        } else {

            $this->db->trans_rollback();

        }

    }
    public function print_depo_sayim()

    {



        $tid = $this->input->get('id');



        $data['id'] = $tid;

        $data['title'] = "Sayim $tid";

        $data['invoice'] = $this->sayim->sayim_details($tid);

        $data['products'] = $this->sayim->sayim_products($tid);

        $data['employee'] = $this->sayim->employee($data['invoice']['eid']);

        $data['invoice']['multi'] = 0;



        ini_set('memory_limit', '64M');





        //PDF Rendering





        if ($data['invoice']['taxstatus'] == 'cgst' || $data['invoice']['taxstatus'] == 'igst') {

            $html = $this->load->view('sayim/view-print-gstin', $data, true);

        } else {

            $html = $this->load->view('sayim/view-print-' . LTR, $data, true);

        }

        $header = $this->load->view('sayim/header-print-' . LTR, $data, true);

        //PDF Rendering

        $this->load->library('pdf');



        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['tid'] . '</div>');



        $pdf->WriteHTML($html);



        if ($this->input->get('d')) {



            $pdf->Output('sayim_#' . $data['invoice']['tid'] . '.pdf', 'D');

        } else {

            $pdf->Output('sayim_#' . $data['invoice']['tid'] . '.pdf', 'I');

        }





    }

}

