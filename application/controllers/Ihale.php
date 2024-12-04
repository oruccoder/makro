<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 11.02.2020
 * Time: 15:45
 */
?>
<?php
class Ihale extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ihale_model', 'ihale');
        $this->load->model('invoices_model', 'invocies');
        $this->load->library("Aauth");
        $this->load->library("Custom");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(5)) {

            exit('<h3>Bu bölüme giriş izniniz yoktur!</h3>');

        }

        if ($this->aauth->get_user()->roleid == 2) {

            $this->limited = $this->aauth->get_user()->id;

        } else {

            $this->limited = '';

        }
    }

    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'İhale Dosyaları';
        $this->load->view('fixed/header', $head);
        $this->load->view('ihale/index');
        $this->load->view('fixed/footer');
    }
    public function gider_kalemleri()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Gider Kalemleri';
        $data['ana_gider_kalemleri']=$this->cost->ana_gider_kalemleri();
        $data['alt_gider_kalemleri']=$this->cost->alt_gider_kalemleri();
        $this->load->view('fixed/header', $head);
        $this->load->view('cost/gider_kalemleri',$data);
        $this->load->view('fixed/footer');
    }

    public function gider_kalemi_i()
    {
        $id = $this->input->post('id');
        $alt_id = $this->input->post('alt_id');
        $type = $this->input->post('type');
        $gider_kalemi = $this->input->post('gider_kalemi');
        if($type==0) //Yeni gider Ekle
        {
            if ($this->cost->new_gider($id,$gider_kalemi))
            {
                echo json_encode(array('status' => 'Success', 'message' =>

                    'Başarıyla Kayıt Edildi'));
            }
            else
            {
                echo json_encode(array('status' => 'Error', 'message' =>
                    'Hata Oluştu.Tekrar Deneyiniz'));
            }
        }
        else
        {
            //düzenle
            if ($this->cost->edit_gider($gider_kalemi,$alt_id))
            {
                echo json_encode(array('status' => 'Success', 'message' =>

                    'Başarıyla Güncellendi'));
            }
            else
            {
                echo json_encode(array('status' => 'Error', 'message' =>
                    'Hata Oluştu.Tekrar Deneyiniz'));
            }
        }

    }

    public function delete_i()
    {
        {

            $id = $this->input->post('id');
            if ($this->cost->cost_delete($id))
            {
                echo json_encode(array('status' => 'Success', 'message' =>

                    $this->lang->line('DELETED')));
            }
            else
            {
                echo json_encode(array('status' => 'Error', 'message' =>
                    'Hata Oluştu.Tekrar Deneyiniz'));
            }



        }
    }

    public function delete_stok()
    {
        {

            $id = $this->input->post('deleteid');
            if ($this->ihale->stok_delete($id))
            {
                echo json_encode(array('status' => 'Success', 'message' =>

                    $this->lang->line('DELETED')));
            }
            else
            {
                echo json_encode(array('status' => 'Error', 'message' =>
                    'Hata Oluştu.Tekrar Deneyiniz'));
            }



        }
    }

    public function delete_cari()
    {
        {

            $id = $this->input->post('deleteid');
            if ($this->ihale->cari_delete($id))
            {
                echo json_encode(array('status' => 'Success', 'message' =>

                    $this->lang->line('DELETED')));
            }
            else
            {
                echo json_encode(array('status' => 'Error', 'message' =>
                    'Hata Oluştu.Tekrar Deneyiniz'));
            }



        }
    }

    public function anaUpdate()
    {
        $id = $this->input->post('id');
        $gider_kalemi = $this->input->post('gider_kalemi');

        if($id!=0)
        {

            if ($this->cost->edit_gider($gider_kalemi,$id))
            {
                echo json_encode(array('status' => 'Success', 'message' =>

                    'Başarıyla Güncellendi'));
            }
            else
            {
                echo json_encode(array('status' => 'Error', 'message' =>
                    'Hata Oluştu.Tekrar Deneyiniz'));
            }
        }
        else
        {
            if ($this->cost->new_gider($id,$gider_kalemi))
            {
                echo json_encode(array('status' => 'Success', 'message' =>

                    'Başarıyla Eklendi'));
            }
            else
            {
                echo json_encode(array('status' => 'Error', 'message' =>
                    'Hata Oluştu.Tekrar Deneyiniz'));
            }
        }

    }
    public function yeni_dosya()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Yeni İhale Dosyası';
        $data['accounts']=$this->ihale->acc_list();
        $data['customer']=$this->ihale->cari_list();
        $this->load->view('fixed/header', $head);
        $this->load->view('ihale/yeni_dosya',$data);
        $this->load->view('fixed/footer');
    }

    public function edit_dosya()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'İhracat Dosyası Düzenle';
        $data['accounts']=$this->ihracat->acc_list();
        $data['customer']=$this->ihracat->cari_list();
        $data['invoices']=$this->ihracat->dosya_details($id);

        $this->load->view('fixed/header', $head);
        $this->load->view('ihracat/edit_dosya',$data);
        $this->load->view('fixed/footer');
    }

    public function cari_list()
    {
        $invoice_list=$this->cost->cari_list();
        $data=array();
        foreach ($invoice_list as $l)
        {
            $data[]=array(
                'name'=>$l->company,
                'id'=>$l->id
            );
        }

        echo json_encode($data);
    }
    public function personel_list()
    {
        $invoice_list=$this->cost->personel_list();
        $data=array();
        foreach ($invoice_list as $l)
        {
            $data[]=array(
                'name'=>$l->name,
                'id'=>$l->id
            );
        }
        echo json_encode($data);
    }
    public function invoice_list()
    {
        $invoice_list=$this->cost->invoice_list();
        $data=array();
        foreach ($invoice_list as $l)
        {
            $data[]=array(
                'invoice_no'=>$l->invoice_no,
                'id'=>$l->id,
                'type'=>$l->invoice_type_desc,
                'kalan'=>amountFormat($l->kalan*$l->kur_degeri)
            );
        }
        echo json_encode($data);
    }

    public function edit_action()
    {
        $ihracat_id=$this->input->post('ihracat_id');
        $dosya_no=$this->input->post('dosya_no');
        $baslama_tarihi=$this->input->post('baslama_tarihi');
        $baslama_tarihi = datefordatabase($baslama_tarihi);
        $bitis_tarihi=$this->input->post('bitis_tarihi');
        $bitis_tarihi = datefordatabase($bitis_tarihi);
        $cari_id=$this->input->post('cari_id');
        $description=$this->input->post('description');
        $gumrukcu_firma_id=$this->input->post('gumrukcu_firma_id');
        $status=$this->input->post('status');
        $cari_unvan=masraf_cari_personel_fatura(1,$cari_id);
        $gumrukcu_firma_unvan=masraf_cari_personel_fatura(1,$gumrukcu_firma_id);

        if ($this->ihracat->edit_invoice(
            $ihracat_id,
            $dosya_no,$baslama_tarihi,
            $bitis_tarihi,
            $cari_id,
            $description,
            $gumrukcu_firma_id,
            $cari_unvan,
            $gumrukcu_firma_unvan,
            $status,
            $this->aauth->get_user()->id,
            $this->aauth->get_user()->loc))
        {



            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('dosya_edit') . "
                <a href='" . base_url() . "ihracat/yeni_dosya' class='btn btn-indigo btn-sm'>
                    <span class='icon-plus-circle' aria-hidden='true'></span>
                     " . $this->lang->line('New') . "  </a>
                <a href='" . base_url() . 'ihracat/view?id=' . $ihracat_id . "' class='btn btn-primary btn-xs'>
                    <span class='icon-eye'></span>
                    " . $this->lang->line('View') . "</a>
                <a href='" . base_url() . "ihracat' class='btn btn-indigo btn-sm'>
                    <span class='icon-list-ul' aria-hidden='true'></span>
                </a>"));

        }


    }

    public function action()
    {
        $dosya_no=$this->input->post('dosya_no');
        $baslama_tarihi=$this->input->post('baslama_tarihi');
        $baslama_tarihi = datefordatabase($baslama_tarihi);
        $bitis_tarihi=$this->input->post('bitis_tarihi');
        $bitis_tarihi = datefordatabase($bitis_tarihi);
        $description=$this->input->post('description');
        $status=$this->input->post('status');
        $ihale_sekli=$this->input->post('ihale_sekli');
        $proje_id=$this->input->post('proje_id');



        if ($this->ihale->addinvoice(
            $dosya_no,
            $baslama_tarihi,
            $bitis_tarihi,
            $description,
            $status,
            $ihale_sekli,
            $this->aauth->get_user()->id,
            $proje_id
        ))
        {

            $lid = $this->db->insert_id();
            $this->aauth->applog("İhale Oluşturuldu $dosya_no ID ".$lid,$this->aauth->get_user()->username);
            kont_kayit(18,$lid);

            $operator= "deger+1";
            $this->db->set('deger', "$operator", FALSE);
            $this->db->where('tip', 6);
            $this->db->update('numaric');




            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('dosya_ekleme') . "
                <a href='" . base_url() . "ihale/yeni_dosya' class='btn btn-indigo btn-sm'>
                    <span class='icon-plus-circle' aria-hidden='true'></span>
                     " . $this->lang->line('New') . "  </a>
                <a href='" . base_url() . 'ihale/view?id=' . $lid . "' class='btn btn-primary btn-xs'>
                    <span class='icon-eye'></span>
                    " . $this->lang->line('View') . "</a>
                <a href='" . base_url() . "ihale' class='btn btn-indigo btn-sm'>
                    <span class='icon-list-ul' aria-hidden='true'></span>
                </a>"));

        }


    }



    public function getSmallLink($longurl){


        $talep_no = numaric(17);

        $url = $longurl;
        $sort_url='https://makrolink.site/'.$talep_no;

        $data_items=array
        (
            'sort_link'=>$sort_url,
            'long_link'=>$url,
        );
        $this->db->insert('sort_link', $data_items);

        $operator= "deger+1";
        $this->db->set('deger', "$operator", FALSE);
        $this->db->where('tip', 17);
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



    public  function getSmallLink_(){





//        print_r($data);die();
       /// return $data['url']['shortLink'];
//        $url = 'https://api-ssl.bitly.com/v4/bitlinks';
//        $ch = curl_init($url);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['long_url' => 'https://muhasebe.makro2000.com.tr/controller/personel_takip']));
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, [
//            "Authorization: Bearer c98adccd90988b2defe0d182d63042e287a64dd1",
//            "Content-Type: application/json"
//        ]);
//
//        $arr_result = json_decode(curl_exec($ch));
//        print_r($arr_result);die();
//        return $arr_result->link;


    }

    public function tekrar_teklif_iste()
    {
        $prodindex=0;
        $mesaj=$this->input->post('mesaj');
        $firma_id=$this->input->post('firma_id');
        $ihale_id=$this->input->post('ihale_id');
        $id_array=$this->input->post('id_array');
        $ids=explode(",",$id_array);
        $firma_tel=0;
        foreach ($ids as $ids)
        {
            $ihale_items_firma_id=$ids;
            $detaylar = $this->db->query("SELECT * FROM `geopos_ihale_items_firma` WHERE firma_id=$firma_id and ihale_id=$ihale_id and item_id=$ids ORDER BY `geopos_ihale_items_firma`.`oturum` DESC LIMIT 1")->row();
            $oturum = intval($detaylar->oturum)+1;

            $data_items=array
            (
                'ihale_id'=>$ihale_id,
                'item_id'=>$ids,
                'ref_urun'=>$detaylar->ref_urun,
                'firma_id'=>$firma_id,
                'oturum'=>$oturum,
                'product_id'=>$detaylar->product_id
            );
            $this->db->insert('geopos_ihale_items_firma', $data_items);



            $prodindex++;
        }

        $firma_tel=customer_details($firma_id)['phone'];
        $firma_name=customer_details($firma_id)['company'];
        $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
        $firma_kodu=$dbnames['firma_kodu'];
        $validtoken = hash_hmac('ripemd160', 'p' . $ihale_id, $this->config->item('encryption_key'));
        $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$ihale_id&oturum=$oturum&pers_id=$firma_id&type=firma_teklif_onay&token=$validtoken";

        $short_url = $this->getSmallLink($href);

        $dosya_no=$this->db->query("SELECT * FROM geopos_ihale where id=$ihale_id")->row()->dosya_no;
        $mesaj="Sayın ".$firma_name. ' Firmasi Makro2000 Grup Sirketleri sizlerden '.$dosya_no.' Numaralı teklifine '.$oturum.'. fiyat beklemektedir.Teklif vermek icin tiklayiniz. '.$short_url;



        if ($prodindex > 0) {

            $message_ = $this->mesaj_gonder($firma_tel,$mesaj);

            echo json_encode(array('status' => 'Success', 'message' =>

                "Başarıyla Kayıt Edildi."));


        } else {

            echo json_encode(array('status' => 'Error', 'message' =>

                "Hata Oluştu."));

        }
    }

    public function stok_kayit()
    {

        $send_sms_new = $this->input->post('send_smsm');
        if($send_sms_new=='false'){
            $send_sms_new=false;
        }
        else {
            $send_sms_new=true;
        }
        $malzeme_talep_forum=$this->input->post('malzeme_talep_foru');
        $id=$this->input->post('talep_id');
        $product_name=$this->input->post('product_name');
        $product_id=$this->input->post('product_id');
        $product_detail=$this->input->post('product_detail');
        $marka=$this->input->post('marka');
        $product_qty=$this->input->post('product_qty');
        $firma=$this->input->post('firma');
        $unit=$this->input->post('unit');
        $product_index=$this->input->post('product_index');


        $this->db->trans_start();

        $productlist = array();
        $prodindex = 0;

        $ar_firma=array();

        $data_items=[];
        $index=0;
        if($malzeme_talep_forum){
            foreach ($malzeme_talep_forum as $key=>$value)
            {
                $data_item=array
                (
                    'ihale_id'=>$id,
                    'malzeme_talep_id'=>$malzeme_talep_forum[$key]
                );

                $data_items[$index]=$data_item;
                $index++;
            }

            $this->db->insert_batch('ihale_to_malzeme_talep', $data_items);
        }
        else {
            echo json_encode(array('status' => 'Error', 'message' => "Malzame Talep Formu Seçiniz"));
            exit();
        }



        if($firma){
            foreach ($firma as $val)
            {
                foreach ($val as $value)
                {
                    $ar_firma[]=$value;
                }
            }

            $ar_firma = array_unique($ar_firma);
        }
        else {
            echo json_encode(array('status' => 'Error', 'message' =>"Firma Seçiniz"));
            exit();
        }


        $productlist=array();
        $i=0;

        if($product_name){
            foreach ($product_name as $key => $value)
            {
                if(isset($product_name[$key]))
                {
                    $pid=$product_id[$key];
                    $knt = $this->db->query("SELECT id FROM geopos_ihale_items WHERE ihale_id=$id and product_id=$pid");

                    if($knt->num_rows()>0)
                    {
                        $last_id=$knt->row()->id;

                    }
                    else
                    {
                        $data_item=array
                        (
                            'ihale_id'=>$id,
                            'product_id'=>$product_id[$key],
                            'product_name'=>$product_name[$key],
                            'product_detail'=>$product_detail[$key],
                            'marka'=>$marka[$key],
                            'product_qty'=>$product_qty[$key],
                            'unit' => $unit[$key]
                        );

                        $this->db->insert('geopos_ihale_items', $data_item);
                        $last_id= $this->db->insert_id();

                    }




                    $ind=$product_index[$key];



                    $productlist=[];
                    foreach ($firma[$ind] as $j => $val)
                    {

                        if(isset($firma[$ind][$j]))
                        {
                            $data_items=array
                            (
                                'ihale_id'=>$id,
                                'item_id'=>$last_id,
                                'marka'=>$marka[$key],
                                'product_id'=>$product_id[$key],
                                'firma_id'=>$firma[$ind][$j],
                                'oturum'=>1
                            );

                            $productlist[$prodindex] = $data_items;
                            $prodindex++;
                        }

                    }
                    if($prodindex>0){
                        $this->db->insert_batch('geopos_ihale_items_firma', $productlist);
                    }
                }


                $i++;

            }
        }
        else{
            echo json_encode(array('status' => 'Error', 'message' =>"Stokları Getiriniz"));
            exit();
        }





        // firmalara  sms


        foreach ($ar_firma as $va)
        {
            $firma_id=$va;
            $firma_tel=customer_details($firma_id)['phone'];
            $firma_name=customer_details($firma_id)['company'];
            $dbnames=$this->db->query('SELECT * FROM geopos_db WHERE id=1')->row_array();
            $firma_kodu=$dbnames['firma_kodu'];
            $validtoken = hash_hmac('ripemd160', 'p' . $id, $this->config->item('encryption_key'));
            $href="https://muhasebe.makro2000.com.tr/firma_login/token_giris.php?firma_kodu=$firma_kodu&id=$id&oturum=1&pers_id=$firma_id&type=firma_teklif_onay&token=$validtoken";

            $short_url = $this->getSmallLink($href);

            $dosya_details=$this->db->query("SELECT * FROM geopos_ihale where id=$id")->row();

            $elega = personel_detailsa($dosya_details->emp_id)['phone'];
            $yetkili_pers = personel_detailsa($dosya_details->emp_id)['name'];

            $mesaj=$firma_name. ' - Makro2000 Qrup Sirketleri sizdən bir qiymət gozleyirler.'.$yetkili_pers.' Elaqe nomrəmiz : '.$elega.'  Teklif göndermək ucun buraya vurun. '.$short_url;

            $this->aauth->applog("Firmalardan Teklif İstendi $dosya_details->dosya_no ",$this->aauth->get_user()->username);
            if($send_sms_new){
                log_mesaj('geopos_ihale_items_firma',$id,$elega,$short_url,$mesaj,$firma_id);
            }



            $kontrol=$this->db->query("SELECT * FROM geopos_ihale_items_firma where ihale_id=$id and firma_id=$firma_id")->num_rows();
            if($kontrol>0)
            {
                if($send_sms_new){
                    $message_ = $this->mesaj_gonder($firma_tel,$mesaj);
                }
            }

        }
        // firmalara  sms

        if ($prodindex > 0) {


            $this->db->trans_complete();

            $dosya_details=$this->db->query("SELECT * FROM geopos_ihale where id=$id")->row();
            kont_kayit(44,$dosya_details->dosya_no);


            echo json_encode(array('status' => 'Success', 'message' =>

                "Başarıyla Kayıt Edildi."));
            exit();


        } else {

            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>

                "Hata Oluştu."));
            exit();

        }

    }

    public function ajax_talep_formlari()
    {
        $id=$this->input->post('malzeme_talep_id');

        $query= $this->db->query("SELECT * FROM geopos_talep_items Where  geopos_talep_items.tip In ($id)");

        $q= $query->result();


//        $out=array();
//        foreach ($q as $detailss)
//        {
//            $out[]=array(
//                'product_id'=>$detailss->product_id,
//                'product_name'=>$detailss->product_name,
//                'unit'=>$detailss->unit,
//                'qty'=>round($detailss->qty,2),
//                'details'=>$detailss->product_detail
//            );
//        }

        echo json_encode(array('status' => 'Success', 'item'=>$q));

//        echo json_encode($out);


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

    public function ajax_list()
    {
        $list = $this->ihale->get_datatables($this->limited);

        $data = array();



        $no = $this->input->post('start');

        foreach ($list as $invoices) {

            $status_string='Kapalı';
            if($invoices->status==1)
            {
                $status_string='Açık';
            }

            $no++;

            $row = array();

            $row[] = $no;
            $row[] = '<a href="' . base_url("ihale/view?id=$invoices->id") . '" class="btn btn-success btn-sm" ">'.$invoices->dosya_no.'</a>';
            $row[] = dateformat($invoices->baslangic_tarihi);
            $row[] = dateformat($invoices->bitis_tarihi);
            $row[] = $status_string;
            $row[] = $invoices->description;



            $row[] = '<a href="' . base_url("ihale/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View">
            <i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("ihale/edit_dosya?id=$invoices->id") . '"
            class="btn btn-info btn-sm"  title="Download"><span class="fa fa-edit"></span></a>
            <a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-sm delete-object">
            <span class="fa fa-trash"></span></a>';


            $data[] = $row;

        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->ihale->count_all($this->limited),

            "recordsFiltered" => $this->ihale->count_filtered($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);
    }

    public function ajax_list_talepler()
    {
        $list = $this->ihale->get_datatables_stoklar($this->limited);

        $data = array();



        $no = $this->input->post('start');

        foreach ($list as $invoices) {

            $no++;

            $row = array();

            $row[] = '';
            $row[] = $invoices->product_name."<input type='hidden' value='$invoices->id' class='item_id'>";
            $row[] = $invoices->product_qty;
            $row[] = $invoices->unit;

            $row[] = '';


            $data[] = $row;

        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->ihale->count_all_stoklar($this->limited),

            "recordsFiltered" => $this->ihale->count_filtered_stoklar($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);
    }

    public function ajax_list_firmalar()
    {
        $list = $this->ihale->get_datatables_firmalar($this->limited);

        $data = array();



        $no = $this->input->post('start');


        foreach ($list as $invoices) {

            $no++;


            $row = array();

            $row[] = '';
            $row[] = $invoices->company."<input type='hidden' value='$invoices->firma_id' class='item_id'><input type='hidden' value='$invoices->ihale_id' class='dosya_id'>";
            $row[] = $invoices->address;
            $row[] = $invoices->phone;
            $row[] = amountFormat(firma_total_teklif($invoices->firma_id,$invoices->ihale_id)->total);
            $data[] = $row;

        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->ihale->count_all_stoklar($this->limited),

            "recordsFiltered" => $this->ihale->count_filtered_stoklar($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);
    }

    public function ihale_item_stok()
    {

        $item_id=$this->input->post('item_id');
        $dosya_id=$this->input->post('ihale_id');

        $oturum =$this->db->query("SELECT max(oturum) as oturum FROM `geopos_ihale_items_firma` WHERE `ihale_id` = $dosya_id and firma_id=$item_id and fiyat IS NOT null;;")->row()->oturum;

        $result =$this->db->query("SELECT geopos_ihale_items_firma.*,geopos_ihale_items.product_name,geopos_ihale_items.product_detail,geopos_ihale_items.product_qty,geopos_ihale_items.unit
FROM geopos_ihale_items_firma INNER JOIN
geopos_ihale_items ON geopos_ihale_items_firma.item_id=geopos_ihale_items.id
where geopos_ihale_items_firma.oturum=$oturum and  geopos_ihale_items_firma.firma_id=$item_id
and geopos_ihale_items_firma.ihale_id=$dosya_id
ORDER BY geopos_ihale_items_firma.oturum DESC
")->result_array();
        echo json_encode($result);

    }

    public function teklif_ogren()
    {
        $item_id=$this->input->post('item_id');
        $dosya_id=$this->input->post('ihale_id');
        $firma_id=$this->input->post('firma_id');

        $price_1 = 0;
        $price_2 = 0;
        $price_3 = 0;
        $price_4 = 0;

        $price_id_1 = 0;
        $price_id_2 = 0;
        $price_id_3 = 0;
        $price_id_4 = 0;

        $price_1_ = $this->db->query("SELECT * FROM `geopos_ihale_items_firma` WHERE `firma_id` = $firma_id and `ihale_id` = $dosya_id and `item_id` = $item_id and `oturum` = 1");
        $price_2_ = $this->db->query("SELECT * FROM `geopos_ihale_items_firma` WHERE `firma_id` = $firma_id and `ihale_id` = $dosya_id and `item_id` = $item_id and `oturum` = 2");
        $price_3_ = $this->db->query("SELECT * FROM `geopos_ihale_items_firma` WHERE `firma_id` = $firma_id and `ihale_id` = $dosya_id and `item_id` = $item_id and `oturum` = 3");
        $price_4_ = $this->db->query("SELECT * FROM `geopos_ihale_items_firma` WHERE `firma_id` = $firma_id and `ihale_id` = $dosya_id and `item_id` = $item_id and `oturum` = 4");

        if($price_1_->num_rows()>0)
        {
            $price_1 = $price_1_->row()->fiyat;
            $price_id_1 = $price_1_->row()->id;
        }
        if($price_2_->num_rows()>0)
        {
            $price_2 = $price_2_->row()->fiyat;
            $price_id_2 = $price_2_->row()->id;
        }
        if($price_3_->num_rows()>0)
        {
            $price_3 = $price_3_->row()->fiyat;
            $price_id_3 = $price_3_->row()->id;
        }
        if($price_4_->num_rows()>0)
        {
            $price_4 = $price_4_->row()->fiyat;
            $price_id_4 = $price_4_->row()->id;
        }

        echo json_encode(array(
            'price_1'   => amountFormat($price_1),
            'price_2'   => amountFormat($price_2),
            'price_3'   => amountFormat($price_3),
            'price_4'   => amountFormat($price_4),

            'price_1_s' => $price_1,
            'price_2_s' => $price_2,
            'price_3_s' => $price_3,
            'price_4_s' => $price_4,

            'id_1'      => intval($price_id_1),
            'id_2'      => intval($price_id_2),
            'id_3'      => intval($price_id_3),
            'id_4'      => intval($price_id_4)
        ));

    }

    public function priceupdate(){
        $id = $this->input->post('id');
        $price = $this->input->post('price');
        $firstPrice = $this->input->post('firstPrice');
        $this->aauth->applog($this->aauth->get_user()->employes->name. '  kullanıcısı ihale-item-ID '.$id.' olan ürünün fiyatını '.$firstPrice.' ~ '. $price . ' olarak güncelledi.');
        $this->ihale->priceUpdate();
    }

    public function view()
    {
        $data=array();
        $head=array();
        $data['accounts']=$this->ihale->acc_list();
        $id = $this->input->get('id');
        $data['invoices']=$this->ihale->dosya_details($id);
        $data['ihale_stoklari']=$this->ihale->ihale_stoklari($id);
        $data['ihracat_id']=$id;
        $data['customer']=$this->ihale->cari_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $href='';
        $talep_ids = $this->db->query("SELECT * FROM `ihale_to_malzeme_talep` Where ihale_id=$id");
            if($talep_ids->num_rows()){
                foreach ($talep_ids->result() as $items){
                    $talep_no=$this->db->query("SELECT * FROM `geopos_talep` WHERE id=$items->malzeme_talep_id")->row()->talep_no;
                    $href.="<a href='/requested/view?id=$items->malzeme_talep_id'  target='_blank' class='btn btn-info'>$talep_no</a>&nbsp;&nbsp;";
                }
            }


            $data['href']=$href;
        $list=$this->db->query("SELECT * FROM geopos_ihale_items_firma WHERE ihale_id=$id GROUP  BY firma_id")->result();
        $sub_total=0;
        foreach ($list as $invoices)
        {
            $sub_total+=firma_total_teklif($invoices->firma_id,$invoices->ihale_id)->total;
        }
        $sayi=count($list);

        $ortalama=@amountFormat($sub_total/$sayi);

        $data['ortalama']=$ortalama;

        $head['title'] = 'Dosya Detayları';
        $this->load->view('fixed/header', $head);
        $this->load->view('ihale/dosya_view',$data);
        $this->load->view('fixed/footer');
    }
    public function printinvoice()
    {

    }
    public function odeme_gecmisi()
    {
        $tid = $this->input->get('id');



        $tip = $this->input->get('tip');

        $data['id'] = $tid;

        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);

        if ($data['invoice']) $data['products'] = $this->invocies->invoice_gecmisi($tid,$tip);

        if ($data['invoice']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);



        ini_set('memory_limit', '64M');

        $html = $this->load->view('invoices/view-gecmis-'.LTR, $data, true);

        $header = $this->load->view('invoices/header-print-masraf-' . LTR, $data, true);

        //PDF Rendering

        $this->load->library('pdf');



        $pdf = $this->pdf->load_split();

        $pdf->SetHTMLHeader($header);

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #' . $data['invoice']['invoice_no'] . '</div>');



        $pdf->WriteHTML($html);



        $file_name = preg_replace( '/[^A-Za-z0-9]+/', '-', 'Invoice__'.$data['invoice']['name'].'_'. $data['invoice']['tid']);

        if ($this->input->get('d')) {



            $pdf->Output($file_name. '.pdf', 'D');

        } else {

            $pdf->Output($file_name . '.pdf', 'I');

        }
    }

    public function alt_masraf_list()
    {
        $id=$this->input->post('masraf_id');
        $invoice_list=$this->ihracat->alt_gider_kalemleri_masraf_id($id);
        $data=array();
        foreach ($invoice_list as $l)
        {
            $data[]=array(
                'name'=>$l->name,
                'id'=>$l->id
            );
        }

        echo json_encode($data);
    }

    public function masraf_detay()
    {
        $id = $this->input->get('id');
        $name=masraf_name($id);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = $name.' Detay Raporu';
        $data['ana_gider_kalemleri']=$this->ihracat->ana_gider_kalemleri();
        $data['masraf_id']=$id;
        $data['alt_gider_kalemleri']=$this->ihracat->alt_gider_kalemleri();
        $this->load->view('fixed/header', $head);
        $this->load->view('cost/masraf_detay',$data);
        $this->load->view('fixed/footer');
    }

    public function masraf_detay_ajax()
    {

        $id=$this->input->post('masraf_id');
        $sorgu= $this->db->query('SELECT * FROM geopos_cost WHERE id='.$id)->row();
        $string='';
        if($sorgu->parent_id!=0)
        {
            $string='alt_masraf';
        }
        else
        {
            $string='masraf';
        }
        $list = $this->ihracat->get_datatables_masraf_detay($string,$id,$this->limited);
        $para_birimi = para_birimi_ogren('tumu');
        $data = array();
        $no = $this->input->post('start');
        $bakiye=0;
        $alacak_toplam=0;
        $borc_toplam=0;
        $total=0;

        foreach ($list as $invoices) {
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


            if($invoices->type_value=='fatura')
            {
                $borc=$invoices->borc*$carpim;
                $alacak=$invoices->alacak*$carpim;
                $total=$invoices->subtotal;
            }
            else
            {
                $borc=$invoices->borc*$carpim;
                $alacak=$invoices->alacak*$carpim;
                $total=$invoices->total;
            }



            if ($invoices->transactions == 'expense') {

                $alacak_toplam += $total*$carpim;
            } elseif ($invoices->transactions == 'income') {
                $borc_toplam += $total*$carpim;
            }
            $bakiye += ($borc-$alacak);

            $row[] = dateformat($invoices->invoicedate);
            $row[] = $invoices->product;
            $row[] = $invoices->invoice_no;
            $row[] = $this->lang->line($invoices->odeme_tipi);
            $row[] = amountFormat($borc,$para_birimi);
            $row[] = amountFormat($alacak,$para_birimi);

            $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");
            $data[] = $row;
        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->ihracat->count_all_masraf_detay($string,$id),

            "recordsFiltered" => $this->ihracat->count_all_masraf_detay($string,$id,$this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);
    }

    public function action_gider_dagitim()
    {

        $stok_toplam_azn_price=$this->input->post('toplam_azn_price');
        $ihracat_id=$this->input->post('ihracat_id');
        $toplam_quantitiy=$this->input->post('toplam_quantitiy');
        $toplam_gider=$this->input->post('toplam_gider');
        $prodindex=0;
        $productlist=array();
        $productlist_price=array();

        $pid=$this->input->post('product_id');
        foreach ($pid as $key => $value)
        {
            $product_id=$this->input->post('product_id');
            $dagilim_sekli=$this->input->post('dagilim_sekli');
            $dagilim_oran=$this->input->post('dagilim_oran');
            $birim_fiyati=$this->input->post('birim_fiyati');
            $birim_alis_fiyati=$this->input->post('alis_fiyati');
            $quantity=$this->input->post('quantity');
            $tutar=$this->input->post('tutar');

            $operator="guncel_maliyet_price+$birim_fiyati[$key]";

            $this->db->set('guncel_maliyet_price', "$operator", FALSE);

            $this->db->where('pid', $product_id[$key]);


            $this->db->update('geopos_products');


            $dagilim_sekli_d=2;
            if($dagilim_sekli[$key]=='Manuel')
            {
                $dagilim_sekli_d=1;
            }
            if($product_id[$key]!=0)
            {
                $loc=$this->aauth->get_user()->loc;
                $data = array(

                    'ihracat_id' => $ihracat_id,

                    'product_id' => $product_id[$key],

                    'dagilim_sekli' => $dagilim_sekli_d,

                    'dagilim_oran' => $dagilim_oran[$key],

                    'quantity' => $quantity[$key],

                    'birim_fiyati_maliyeti' => $birim_fiyati[$key],

                    'birim_alis_maliyet_fiyati' => $birim_alis_fiyati[$key]+$birim_fiyati[$key],

                    'toplam_tutar_maliyeti' => $tutar[$key],

                    'toplam_alis_maliyet_fiyati' => ($birim_alis_fiyati[$key]+$birim_fiyati[$key])*$quantity[$key],

                    'user_id' => $this->aauth->get_user()->id
                );

                $data2 = array(

                    'ihracat_id' => $ihracat_id,
                    'date' => datefordatabase(date('d-M-Y')),
                    'product_id' => $product_id[$key],
                    'price' => $birim_fiyati[$key],
                    'subtotal' => $tutar[$key],
                    'loc' => $loc
                );

                $productlist[$prodindex] = $data;
                $productlist_price[$prodindex] = $data2;


                $prodindex++;

            }

        }

        if ($prodindex > 0) {

            $this->db->insert_batch('geopos_ihracat_maliyet_dagitim', $productlist);
            $this->db->insert_batch('geopos_product_price', $productlist_price);




            $this->db->set(array('stok_toplam_azn_price' => $stok_toplam_azn_price,
                'stok_toplam_quantitiy' => $toplam_quantitiy
            , 'toplam_gider' => $toplam_gider));

            $this->db->where('id', $ihracat_id);

            $this->db->update('geopos_ihracat');
            echo json_encode(array('status' =>
                'Success', 'message' => "Gider Başarıyla İşlenmiştir.
                "));


        }

        else {

            echo json_encode(array('status' => 'Error', 'message' =>

                "Hata Oluştu Lüften Yazılıma Bildiriniz."));


        }


    }
    public function test()
    {
        log_mesaj('geopos_ihale_items_firma',1,"saddas","sdas","sddsfds");
    }


    public function ajax_ihracat_giderleri()
    {
        $gumrukcu_firma_id= $this->input->post('gumrukcu_firma_id');
        $ihracat_id= $this->input->post('ihracat_id');
        $invoicess=ihracat_giderleri( $ihracat_id,$gumrukcu_firma_id);

        $data=array();
        foreach ($invoicess as $ih_prd)
        {
            $row = array();

            $row[] =dateformat($ih_prd->invoicedate);
            $row[] = $ih_prd->invoice_type_desc;
            $row[] = $ih_prd->product;

            $row[] = amountFormat(($ih_prd->subtotal+$ih_prd->totaltax)*$ih_prd->kur_degeri);


            $row[] = $ih_prd->notes;


            $data[] = $row;
        }


        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => 0,

            "recordsFiltered" => 0,

            "data" => $data

        );

        //output to json format

        echo json_encode($output);

    }

    public function ajax_gumrukcu_giderleri()
    {
        $gumrukcu_firma_id= $this->input->post('gumrukcu_firma_id');
        $ihracat_id= $this->input->post('ihracat_id');
        $invoicess=gumrukcu_tahsilat_odeme( $ihracat_id,$gumrukcu_firma_id);
        $no=0;
        $bakiye=0;
        $alacak_toplam=0;
        $borc_toplam=0;
        $total=0;
        $para_birimi='tumu';
        $data=array();
        foreach ($invoicess as $invoices)
        {

            $no++;
            $carpim=$invoices->kur_degeri;
            $borc=$invoices->borc*$carpim;
            $alacak=$invoices->alacak*$carpim;
            $total=$invoices->total;
            if ($invoices->transactions == 'expense') {

                $alacak_toplam += $total*$carpim;
            } elseif ($invoices->transactions == 'income') {
                $borc_toplam += $total*$carpim;
            }
            $bakiye += ($borc-$alacak);


            $row = array();

            $row[] =dateformat($invoices->invoicedate);
            $row[] = $invoices->description;
            $row[] = $invoices->invoice_no;
            $row[] = $this->lang->line($invoices->odeme_tipi);
            $row[] = amountFormat($borc,$para_birimi);
            $row[] =amountFormat($alacak,$para_birimi);
            $row[] =amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");


            $data[] = $row;
        }


        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => 0,

            "recordsFiltered" => 0,

            "data" => $data

        );

        //output to json format

        echo json_encode($output);

    }


}

