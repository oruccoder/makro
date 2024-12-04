<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 4.02.2020
 * Time: 12:58
 */
?>
<?php
class Cost extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cost_model', 'cost');
        $this->load->model('invoices_model', 'invocies');
        $this->load->library("Aauth");
        $this->load->library("Custom");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if (!$this->aauth->premission(30)->read) {

            exit('<h3>Giriş Yetkiniz Bulunmamaktadır</h3>');

        }

        if ($this->aauth->get_user()->roleid == 2) {

            $this->limited = $this->aauth->get_user()->id;

        } else {

            $this->limited = '';

        }
    }

    public function index()
    {
        if (!$this->aauth->premission(30)->read) {

            exit('<h3>Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Giderler';
        $data['ana_gider_kalemleri']=$this->cost->ana_gider_kalemleri();
        $data['alt_gider_kalemleri']=$this->cost->alt_gider_kalemleri();
        $this->load->view('fixed/header', $head);
        $this->load->view('cost/index',$data);
        $this->load->view('fixed/footer');
    }
    public function gider_kalemleri()
    {
        if (!$this->aauth->premission(30)->read) {

            exit('<h3>Giriş Yetkiniz Bulunmamaktadır</h3>');

        }

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
        $unit = $this->input->post('unit');
        if($type==0) //Yeni gider Ekle
        {
            if (!$this->aauth->premission(30)->write) {


                echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));

            }
            else {
                if ($this->cost->new_gider($id,$gider_kalemi,$unit))
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

        }
        else
        {
            if (!$this->aauth->premission(30)->update) {


                echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));

            }
            else {
                //düzenle
                if ($this->cost->edit_gider($gider_kalemi,$alt_id,$unit))
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

    }

    public function delete_i()
    {
        if (!$this->aauth->premission(30)->delete) {


            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
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
            if (!$this->aauth->premission(30)->write) {


                echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));

            }
            else {
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


        }
        else
        {
            if (!$this->aauth->premission(30)->update) {


                echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));

            }
            else {
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

    }
    public function yeni_gider()
    {
        if (!$this->aauth->premission(30)->write) {

            exit('<h3>Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Yeni Gider Ekle';
        $data['ana_gider_kalemleri']=$this->cost->ana_gider_kalemleri();
        $data['alt_gider_kalemleri']=$this->cost->alt_gider_kalemleri();
        $data['accounts']=$this->cost->acc_list();
        $this->load->view('fixed/header', $head);
        $this->load->view('cost/yeni_gider',$data);
        $this->load->view('fixed/footer');
    }

    public function edit_trans()
    {
        $id=$this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Gider İşlemi Düzenle';
        $data['ana_gider_kalemleri']=$this->cost->ana_gider_kalemleri();
        $data['alt_gider_kalemleri']=$this->cost->alt_gider_kalemleri();
        $data['accounts']=$this->cost->acc_list();
        $data['edit_data']=$this->cost->edit_trans($id);

        $data['ana_gider_kalemi']=ana_masraf_ogren($data['edit_data']->masraf_id)->id;
        $this->load->view('fixed/header', $head);
        $this->load->view('cost/edit_gider',$data);
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

    public function project_list()
    {
        $invoice_list=all_projects();
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

    public function action()
    {
        $transok = true;
        $this->db->trans_start();

        $tip=$this->input->post('tip');
        $odeme_durumu=$this->input->post('odeme_durumu');
        $masraf_id=$this->input->post('masraf_id');
        $islem_date=$this->input->post('islem_date');
        $islem_date = datefordatabase($islem_date);
        $belge_no=$this->input->post('belge_no');
        $description=$this->input->post('description');
        $cari_personel_fatura_id=($this->input->post('cari_personel_fatura'))?$this->input->post('cari_personel_fatura'):0;
        $odeme_tarihi=$this->input->post('odeme_tarihi');
        $odeme_tarihi = datefordatabase($odeme_tarihi);
        $account=$this->input->post('account');
        $tutar=$this->input->post('tutar');
        $kdv_orani=$this->input->post('kdv_orani');
        $para_birimi=$this->input->post('para_birimi');
        $kur_degeri=$this->input->post('kur_degeri');
        $proje_id=$this->input->post('proje_id');
        $bolum_id=$this->input->post('bolum_id');
        $asama_id  = $this->input->post('asama_id');
        $task_id  = $this->input->post('task_id');

        $paymethod=$this->input->post('paymethod');
        $odenen_tutar=$this->input->post('odenen_tutar');


        $payer=masraf_cari_personel_fatura($tip,$cari_personel_fatura_id);
        if(empty($payer)){
            $payer=masraf_name($masraf_id);
        }
        $holder=account_method_ogren($account)['holder'];

        $loc=$this->session->userdata('set_firma_id');
        if ($this->cost->addinvoice(
            $tip,$odeme_durumu,
            $masraf_id,
            $belge_no,
            $description,
            $cari_personel_fatura_id,
            $account,
            $tutar,
            $kdv_orani,
            $odeme_tarihi,
            $islem_date,$para_birimi,$kur_degeri,
            $this->aauth->get_user()->id, $loc,$payer,$holder,$proje_id,$paymethod,$odenen_tutar,$bolum_id,$asama_id,$task_id))
        {

            $lid = $this->db->insert_id();

        }
        else
        {


            echo json_encode(array('status' => 'Error', 'message' =>

                "Zorunlu Alanları Doldurunuz!"));

            $transok = false;
        }


        if ($transok) {



            $this->db->trans_complete();

            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('masraf_gideri_isleme') . " </a> <a href='" . base_url() . 'transactions/view?id=' . $lid . "' class='btn btn-primary btn-xs'><span class='icon-eye'></span>  " . $this->lang->line('View') . "</a>"));


        } else {

            $this->db->trans_rollback();

        }


    }
    public function edit_action()
    {
        $tip=$this->input->post('tip');
        $odeme_durumu=$this->input->post('odeme_durumu');
        $masraf_id=$this->input->post('masraf_id');
        $islem_date=$this->input->post('islem_date');
        $islem_date = datefordatabase($islem_date);
        $belge_no=$this->input->post('belge_no');
        $description=$this->input->post('description');
        $cari_personel_fatura_id=$this->input->post('cari_personel_fatura');
        $odeme_tarihi=$this->input->post('odeme_tarihi');
        $odeme_tarihi = datefordatabase($odeme_tarihi);
        $account=$this->input->post('account');
        $tutar=$this->input->post('tutar');
        $kdv_orani=$this->input->post('kdv_orani');
        $para_birimi=$this->input->post('para_birimi');
        $kur_degeri=$this->input->post('kur_degeri');
        $proje_id=$this->input->post('proje_id');
        $bolum_id=$this->input->post('bolum_id');
        $asama_id  = $this->input->post('asama_id');
        $task_id  = $this->input->post('task_id');


        $paymethod=$this->input->post('paymethod');
        $odenen_tutar=$this->input->post('odenen_tutar');

        $payer=masraf_cari_personel_fatura($tip,$cari_personel_fatura_id);
        $holder=account_method_ogren($account)['holder'];
        $lid = $this->input->post('inv_id');
        $trans_id = $this->input->post('trans_id');
        if ($this->cost->edit_invoice(
            $trans_id,
            $lid,
            $tip,$odeme_durumu,
            $masraf_id,
            $belge_no,
            $description,
            $cari_personel_fatura_id,
            $account,
            $tutar,
            $kdv_orani,
            $odeme_tarihi,
            $islem_date,$para_birimi,$kur_degeri,
            $this->aauth->get_user()->id, $this->aauth->get_user()->loc,$payer,$holder,$proje_id,$paymethod,$odenen_tutar,$bolum_id,$asama_id,$task_id))
        {



			    $this->aauth->applog("Gider İşlemi Düzenlendi $trans_id Transaction ",$this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>

                $this->lang->line('masraf_gideri_isleme') . "  <a href='" . base_url() . "transactions/add' class='btn btn-indigo btn-sm'><span class='icon-plus-circle' aria-hidden='true'></span> " . $this->lang->line('New') . "  </a> <a href='" . base_url() . 'transactions/view?id=' . $lid . "' class='btn btn-primary btn-xs'><span class='icon-eye'></span>  " . $this->lang->line('View') . "</a> <a href='" . base_url() . "transactions' class='btn btn-indigo btn-sm'><span class='icon-list-ul' aria-hidden='true'></span></a>"));

        }


    }

    public function ajax_list()
    {
        $list = $this->cost->get_datatables($this->limited);




        $data = array();



        $no = $this->input->post('start');

        foreach ($list as $invoices) {
            if($invoices->cost_name!=''){
                $no++;

                $row = array();

                $row[] = $no;
                $row[] = '<a href="' . base_url("cost/masraf_detay?id=$invoices->masraf_id") . '" class="btn btn-success btn-sm" ">'.$invoices->cost_name.'</a>';
                $row[] = '<a href="' . base_url("cost/masraf_detay?id=$invoices->pid") . '" class="btn btn-info btn-sm" ">'.$invoices->cost_parent_name.'</a>';
                $row[] = masraf_gider_count($invoices->pid);
                $row[] = amountFormat($invoices->subtotal);

                $row[] = amountFormat($invoices->total_tax);


                $row[] = amountFormat($invoices->total);



                //$row[] = '<a href="' . base_url("cost/view?id=$invoices->pid") . '" class="btn btn-success btn-sm" title="View">
                //<i class="fa fa-eye"></i></a>&nbsp;<a href="' . base_url("cost/printinvoice?id=$invoices->id") . '&d=1"
                //class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>
                //<a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-sm delete-object">
                //<span class="fa fa-trash"></span></a>';


                $data[] = $row;
            }



        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->cost->count_all($this->limited),

            "recordsFiltered" => $this->cost->count_filtered($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);
    }

    public function view()
    {
        $data=array();
        $head=array();
        $data['accounts']=$this->cost->acc_list();
        $id = $this->input->get('id');
        $data['invoice']=$this->cost->giderview($id);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Gider Göster';
        $this->load->view('fixed/header', $head);
        $this->load->view('cost/view',$data);
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
        $invoice_list=$this->cost->alt_gider_kalemleri_masraf_id($id);
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
        $data['ana_gider_kalemleri']=$this->cost->ana_gider_kalemleri();
        $data['masraf_id']=$id;
        $data['alt_gider_kalemleri']=$this->cost->alt_gider_kalemleri();
        $this->load->view('fixed/header', $head);
        $this->load->view('cost/masraf_detay',$data);
        $this->load->view('fixed/footer');
    }

    public function masraf_detay_ajax()
    {

        $id = $this->input->post('masraf_id');
        $sorgu = $this->db->query('SELECT * FROM geopos_cost WHERE id=' . $id)->row();
        $string = '';
        if ($sorgu->parent_id != 0) {
            $string = 'alt_masraf';
        } else {
            $string = 'masraf';
        }
        $list = $this->cost->get_datatables_masraf_detay($string, $id, $this->limited);


        $para_birimi = para_birimi_ogren('tumu');
        $data = array();
        $lists_q = array();
        $no = $this->input->post('start');
        $bakiye = 0;
        $alacak_toplam = 0;
        $borc_toplam = 0;
        $total = 0;


        foreach ($list as $lst)
        {


            $fatura_toplami=$lst->total;
            $alacak=$lst->alacak;


            $q_ = $this->db->query("SELECT geopos_invoice_transactions.transaction_id as inv_id,'Ödeme' as description,geopos_invoices.invoicedate,geopos_invoices.invoice_no,'transaction' as type_value,
                          IF(geopos_invoice_transactions.`method`!='', geopos_invoice_transactions.`method`, 'null') as odeme_tipi,geopos_invoice_items.product,
                        ((geopos_invoice_transactions.total/$fatura_toplami)*$alacak) as borc,
                        0 as alacak,
                        geopos_invoices.total,
                        geopos_invoices.subtotal,
                        geopos_invoice_items.totaltax,
                        geopos_invoices.kur_degeri,
                        'income'as transactions,
                        geopos_invoices.invoice_type_id,
                        'masraf_odemesi' as type,
                        geopos_invoice_items.pid
                        FROM `geopos_invoice_transactions` INNER JOIN
                        geopos_invoices ON geopos_invoices.id=geopos_invoice_transactions.invoice_id
                        INNER JOIN geopos_invoice_items ON geopos_invoice_items.tid=geopos_invoices.id
                        WHERE geopos_invoice_transactions.invoice_id=$lst->inv_id and geopos_invoice_items.pid=$lst->pid");
            if ($q_->num_rows() > 0) {

                $q_s = $q_->result();
                foreach ($q_s as $q_rows) {

                    $lists_q[] = $q_rows;
                }
            }
        }





        $list=array_merge($lists_q,$list);

        uasort ($list , function($a, $b)
        {
            return strcmp($a->inv_id, $b->inv_id);
        });


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
                $total=$invoices->total;
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
            $row[] = account_type_sorgu($invoices->odeme_tipi);
            $row[] = amountFormat($borc,$para_birimi);
            $row[] = amountFormat($alacak,$para_birimi);

            $row[] = amountFormat(abs($bakiye),$para_birimi).($bakiye>0?" (B)":" (A)");

            $row[] = '<a href="' . base_url("transactions/view?id=$invoices->inv_id") . '" class="btn btn-success btn-sm" title="View">
            <i class="fa fa-eye"></i></a></a>
            ';
            $data[] = $row;
        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->cost->count_all_masraf_detay($string,$id),

            "recordsFiltered" => $this->cost->count_all_masraf_detay($string,$id),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);
    }

    public function sortByScore ($a, $b)
    {

    }
}
