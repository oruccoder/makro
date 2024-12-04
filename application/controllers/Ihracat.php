<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 11.02.2020
 * Time: 15:45
 */
?>
<?php
class Ihracat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ihracat_model', 'ihracat');
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
        $head['title'] = 'İhracat Dosyaları';
        $this->load->view('fixed/header', $head);
        $this->load->view('ihracat/index');
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
        $head['title'] = 'Yeni İhracat Dosyası';
        $data['accounts']=$this->ihracat->acc_list();
        $data['customer']=$this->ihracat->cari_list();
        $this->load->view('fixed/header', $head);
        $this->load->view('ihracat/yeni_dosya',$data);
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
        $cari_id=$this->input->post('cari_id');
        $description=$this->input->post('description');
        $gumrukcu_firma_id=$this->input->post('gumrukcu_firma_id');
        $status=$this->input->post('status');
        $cari_unvan=masraf_cari_personel_fatura(1,$cari_id);
        $gumrukcu_firma_unvan=masraf_cari_personel_fatura(1,$gumrukcu_firma_id);
        //Sonraki Aşama
        $odeme_durumu=$this->input->post('odeme_durumu');
        $account=$this->input->post('account');
        $tutar=$this->input->post('tutar');
        $kdv_orani=$this->input->post('kdv_orani');
        $para_birimi=$this->input->post('para_birimi');
        $kur_degeri=$this->input->post('kur_degeri');
        $method=account_method_ogren($account)['name'];
        $holder=account_method_ogren($account)['holder'];

        if ($this->ihracat->addinvoice(
            $dosya_no,$baslama_tarihi,
            $bitis_tarihi,
            $cari_id,
            $description,
            $gumrukcu_firma_id,
            $cari_unvan,
            $gumrukcu_firma_unvan,$status,
            $this->aauth->get_user()->id,
            $this->aauth->get_user()->loc))
        {

            $lid = $this->db->insert_id();

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('dosya_ekleme') . "
                <a href='" . base_url() . "ihracat/yeni_dosya' class='btn btn-indigo btn-sm'>
                    <span class='icon-plus-circle' aria-hidden='true'></span>
                     " . $this->lang->line('New') . "  </a> 
                <a href='" . base_url() . 'ihracat/view?id=' . $lid . "' class='btn btn-primary btn-xs'>
                    <span class='icon-eye'></span>  
                    " . $this->lang->line('View') . "</a> 
                <a href='" . base_url() . "ihracat' class='btn btn-indigo btn-sm'>
                    <span class='icon-list-ul' aria-hidden='true'></span>
                </a>"));

        }


    }

    public function ajax_list()
    {
        $list = $this->ihracat->get_datatables($this->limited);




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
            $row[] = '<a href="' . base_url("ihracat/view?id=$invoices->id") . '" class="btn btn-success btn-sm" ">'.$invoices->dosya_no.'</a>';
            $row[] = dateformat($invoices->baslangic_tarihi);
            $row[] = dateformat($invoices->bitis_tarihi);
            $row[] = $status_string;

            $row[] = $invoices->cari_unvan;


            $row[] = $invoices->description;



            $row[] = '<a href="' . base_url("ihracat/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View">
            <i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("ihracat/edit_dosya?id=$invoices->id") . '" 
            class="btn btn-info btn-sm"  title="Download"><span class="fa fa-edit"></span></a> 
            <a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-sm delete-object">
            <span class="fa fa-trash"></span></a>';


            $data[] = $row;

        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->ihracat->count_all($this->limited),

            "recordsFiltered" => $this->ihracat->count_filtered($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);
    }

    public function view()
    {
        $data=array();
        $head=array();
        $data['accounts']=$this->ihracat->acc_list();
        $id = $this->input->get('id');
        $data['invoices']=$this->ihracat->dosya_details($id);
        $data['ihracat_id']=$id;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Dosya Detayları';
        $this->load->view('fixed/header', $head);
        $this->load->view('ihracat/dosya_view',$data);
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

