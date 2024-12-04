<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 4.02.2020
 * Time: 12:58
 */
?>
<?php
class Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('controller_model', 'cont');
        $this->load->library("Aauth");
        $this->load->library("Custom");
        $this->load->model('employee_model', 'employee');
        $this->load->model('communication_model');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $this->limited = '';



    }

    public function index()
    {
        if (!$this->aauth->premission(80)->read) {
            exit('<h3>Bu bölüme giriş izniniz yoktur!</h3>');

        }
        {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Kontroller Ekranı';
            $this->load->view('fixed/header', $head);
            $this->load->view('cont/index');
            $this->load->view('fixed/footer');
        }
    }
    public function personel_takip()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Takip';
        $this->load->view('fixed/header', $head);
        $this->load->view('cont/personel_takip');
        $this->load->view('fixed/footer');
    }
    public function holidays()
    {
        if (!$this->aauth->premission(37)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Tatil Günleri';
        $this->load->view('fixed/header', $head);
        $this->load->view('cont/holidays');
        $this->load->view('fixed/footer');
    }

    public function envanter()
    {
        if (!$this->aauth->premission(94)) {

            exit('<h3>Bu bölüme giriş izniniz yoktur!</h3>');

        }
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Envanter Listesi';
        $this->load->view('fixed/header', $head);
        $this->load->view('cont/envanter');
        $this->load->view('fixed/footer');
    }
    public function ajax_list()

    {
        $list = $this->cont->get_datatables($this->limited);
        $data = array();
        $no = $this->input->post('start');
        $this->session->set_userdata('test', 1);
        foreach ($list as $invoices) {

            $cont_pers="<select class='form-control cont_pers_id'>";
            if($invoices->cont_pers_id==0)
            {
                $cont_pers.="<option value='0'>Personel Seçiniz</option>";
                foreach (controller_users() as $pers)
                {
                    $id=$pers->user_id;
                    $name=$pers->name;
                    $cont_pers.="<option value='$id'>$name</option>";
                }
                $cont_pers.="</select>";

            }
            else
            {

                foreach (controller_users() as $pers)
                {
                    $id=$pers->user_id;
                    $name=$pers->name;
                    if($invoices->cont_pers_id==$id)
                    {
                        $cont_pers.="<option selected value='$id'>$name</option>";
                    }
                    else
                    {
                        $cont_pers.="<option value='$id'>$name</option>";
                    }


                }
                $cont_pers.="</select>";
            }
            $cont_pers.="</select>";



            $cont_status="<select class='form-control cont_status' data-cont_id='$invoices->id'>";

            foreach (controller_status() as $result)
            {
                $id=$result['id'];
                $name=$result['name'];
                if($invoices->cont_status==$id)
                {
                    $cont_status.="<option selected value='$id'>$name</option>";
                }
                else
                {
                    $cont_status.="<option value='$id'>$name</option>";
                }


            }
            $cont_status.="</select>";

            $row = array();

            $desc='Açıklama Oluşturulmamış';
            if(!empty($invoices->aciklama))
            {
                $desc=$invoices->aciklama;
            }

            $row[] = $invoices->talep_no."<input class='id' value='$invoices->id' type='hidden'>";
            $row[] = $invoices->kayit_tarihi;

            $row[] = $invoices->kullanici_adi;
            $row[] =  $invoices->islem_tipi;
            $row[] =  "<a href='$invoices->islem_link' target='_blank' class='btn btn-success'><i class='fa fa-eye'></i> İşlemi Görüntüle</a>";;
            $row[] =  $cont_status;
            $row[] = $cont_pers;
            $row[] =  "<button class='btn btn-info cont_info' data-cont_id='$invoices->id'><i class='fa fa-eye'></i></button>";



            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>
                    &nbsp;<a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>
                    <a href="#" data-object-id="' . $invoices->id . '" class="btn btn-danger btn-sm delete-object"><span class="fas fa-trash"></span></a>
                    <a target="_blank"  href="' . base_url("/employee/view?id=$invoices->kullanici_id") .'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" data-html="true" title="'.personel_details($invoices->kullanici_id).'"><i class="fa fa-user"></i></a>';


            $data[] = $row;



        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cont->count_all($this->limited),
            "recordsFiltered" => $this->cont->count_filtered($this->limited),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function ajax_list_cont_history(){
        $list = $this->cont->get_datatables_history();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->created_at;
            $row[] = $invoices->description;
            $row[] = $invoices->pers_name;
            $row[] =  $invoices->st_name;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cont->count_all_history(),
            "recordsFiltered" => $this->cont->count_filtered_history(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function ajax_list_envanter()

    {



        $list = $this->cont->get_datatables_envanter($this->limited);



        $data = array();



        $no = $this->input->post('start');

        $this->session->set_userdata('test', 1);

        $i = 1;
        foreach ($list as $invoices) {

            $row = array();
            $row[] = $i;
            $row[] = $invoices->proje;
            $row[] = $invoices->departman;
            $row[] = $invoices->personel;
            $row[] =  $invoices->product;
            $row[] =  $invoices->miktar;
            $row[] =  amountFormat($invoices->price);
            $data[] = $row;

            $i++;

        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->cont->count_envanter_all($this->limited),

            "recordsFiltered" => $this->cont->count_envanter_filtered($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }


    public function holidays_ajax()

    {



        $list = $this->cont->get_datatables_holidays($this->limited);



        $data = array();



        $no = $this->input->post('start');

        $this->session->set_userdata('test', 1);

        $i = 1;
        foreach ($list as $invoices) {
            $row = array();
            $row[] = $i;
            $row[] = $invoices->date;
            $row[] = $invoices->description;
            $row[] = '<button class="btn btn-danger btn-sm delete_job"  type="button" id="'.$invoices->id.'"><i class="fas fa-ban"></i></button> &nbsp;<button class="btn btn-warning btn-sm update"  type="button" id="'.$invoices->id.'"><i class="fas fa-edit"></i></button>';
            $data[] = $row;

            $i++;

        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->cont->count_holidays_all($this->limited),

            "recordsFiltered" => $this->cont->count_holidays_filtered($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }

    function daysBetween($dt1, $dt2) {
        return date_diff(
            date_create($dt2),
            date_create($dt1)
        )->format('%a');
    }

    public function personel_takip_ajax_()

    {

        $salary_config = $this->config->item('salary');

        $list = $this->cont->get_datatables_personel_takip_bordro_list($this->limited);



        $data = array();



        $no = $this->input->post('start');

        $this->session->set_userdata('test', 1);

        $i = 1;

        foreach ($list as $invoices) {



            $banka_durum='Bekliyor';
            $nakit_durum='Bekliyor';
                if($invoices->banka_hakedis==0){
                    $banka_durum='-';
                }
                else {
                    if($invoices->bank_pay_odenis==1){
                        $banka_durum='Ödendi';
                    }
                }

                if($invoices->nakit_hakedis==0){

                    $nakit_durum='-';

                }
                else {
                    if($invoices->cache_pay_odenis==1){
                        $nakit_durum='Ödendi';
                    }
                }

            $razi_total = 0;
            if($invoices->salary_type==3 || $invoices->salary_type == 9) {

                $razi_total = $invoices->odenilecek_meblaq;

            }





            $row = array();
//            $row[] = $i;
//            $row[] = $invoices->proje_name;
//            $row[] = $invoices->name;
//            $row[] =  amountFormat($invoices->salary);
//            $row[] = $invoices->is_gunu;
//            $row[] = "<button class='btn btn-success btn-sm job_report' personel_id='$invoices->personel_id' hesaplama_ayi='$invoices->hesaplama_ayi' hesaplama_yili='$invoices->hesaplama_yili'>$invoices->calisilan_gun_sayisi_</button>";
//            $row[] =  amountFormat($invoices->banka_hesaplanan);
//            $row[] =  $invoices->mezuniyet;
//            $row[] =  amountFormat($invoices->mezuniyet_hesap);
//            $row[] =  amountFormat($invoices->hastalik_amouth);
//            $row[] =  amountFormat($invoices->cemi);
//            $row[] =  amountFormat($invoices->dsmf_isveren);
//            $row[] =  amountFormat($invoices->issizlik_isveren);
//            $row[] =  amountFormat($invoices->icbari_sigorta_isveren);
//            $row[] =  amountFormat($invoices->dsmf_isci);
//            $row[] =  amountFormat($invoices->issizlik_isci);
//            $row[] =  amountFormat($invoices->icbari_sigorta_isci);
//            $row[] =  amountFormat($invoices->gelir_vergisi);
//            $row[] =  amountFormat($invoices->odenilecek_meblaq);
//            $row[] =  amountFormat($invoices->banka_avans);
//            $row[] =  amountFormat($invoices->nakit_avans);
//            $row[] =  amountFormat($invoices->banka_hakedis);
//            $row[] =  amountFormat($invoices->prim_tutar);
//            $row[] =  amountFormat($invoices->ceza_tutar);
//            $row[] =  amountFormat($invoices->nakit_hakedis);
//            $row[] =  $invoices->odenisli_izin_count;
//            $row[] =  $invoices->oz_hesabina_count;
//            $row[] =  amountFormat($razi_total);
//            $row[] =  $banka_durum;
//            $row[] =  $nakit_durum;
//            $row[] =  '';
            //$row[] =  '<button '.$disabled.' type="button" tip="personel_maas_odemesi" hakedis="'.round($hakettigi_maas,2).'" gun_say = "'.$invoices->gun_say.'" data-id="'.$invoices->id.'" data-toggle="modal" data-remote="false" class="odeme_emri_button btn btn-info">Ödeme Emri Ver</button>';

            $net_maas = net_maas_hesaplama($invoices->personel_id,$invoices->is_gunu);
            $check ="<input type='checkbox' rep_id='$invoices->id' class='form-control one_select'  style='width: 30px;' >";;
            $row = array();
            $row[] = personel_details($invoices->personel_id);
            $row[] = $invoices->proje_name;
            $row[] = $invoices->is_gunu;
            $row[] = $invoices->calisilan_gun_sayisi_;
            $row[] = amountFormat($invoices->salary);
            //$row[] = amountFormat($invoices->salary-$invoices->kesinti);
            $row[] = amountFormat($net_maas);
            $row[] =  amountFormat($invoices->hastalik_amouth);
            $row[] =  amountFormat($invoices->mezuniyet_hesap);
            $row[] =  $invoices->mezuniyet;
            $row[] =  amountFormat($invoices->kesinti);
            $row[] =  amountFormat($invoices->toplam_avans);
            $row[] =  amountFormat($invoices->banka_avans);
            $row[] =  amountFormat($invoices->nakit_avans);
//            $row[] =  amountFormat($invoices->banka_avans);
//            $row[] =  amountFormat($invoices->nakit_avans);
            $row[] = amountFormat($invoices->aylik_kesinti);
            $row[] = amountFormat($invoices->aylik_kesinti_nakit);
            $row[] = amountFormat($invoices->nakit_geri_odenen);
            $row[] =  amountFormat($invoices->prim_tutar);
            $row[] =  amountFormat($invoices->ceza_tutar);
            $row[] =  amountFormat($invoices->odenilecek_meblaq);
            $row[] =  amountFormat($invoices->banka_hakedis);
            $row[] =  amountFormat($invoices->nakit_odenilecek);
            $row[] =  amountFormat($invoices->nakit_hakedis);
            $row[] =  amountFormat($razi_total);
            $row[] =  $banka_durum;
            $row[] =  $nakit_durum;
            $row[] =  $check;
            $data[] = $row;

            $i++;



        }






        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->cont->count_personel_takip_all($this->limited),

            "recordsFiltered" => $this->cont->count_personel_takip_filtered($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }

    public function ceil_(){
        echo round(1343.50,2);
    }
    public function personel_takip_ajax()

    {

        $salary_config = $this->config->item('salary');

        //$list = $this->cont->get_datatables_personel_takip($this->limited);
        $list = $this->cont->get_datatables_personel_takip();




        $data = array();



        $no = $this->input->post('start');

        $this->session->set_userdata('test', 1);

        $i = 1;
        $date = new DateTime('now');


        $start =  $date->format('Y-m-01 00:00:00');
        $end =  $date->format('Y-m-t 00:00:00');

        $start_izin =  $date->format('Y-m-01');
        $end_izin =  $date->format('Y-m-t');

        $m= $date->format('m');
        $y= $date->format('Y');

        if($this->input->post('hesap_yil')){
            $y = $this->input->post('hesap_yil');
        }

        if($this->input->post('start_date')){

            $m = $this->input->post('start_date');
            $start =  $date->format($y.'-'.$m.'-01 00:00:00');
            $end =  $date->format($y.'-'.$m.'-t 00:00:00');

            $start_izin =  $date->format($y.'-'.$m.'-01');
            $end_izin =  $date->format($y.'-'.$m.'-t');

        }



        $total_pazar = $this->total_sundays($m,$y);

        $total_ay_sayisi_ = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
        $total_ay_sayisi = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);

        $tatil_hesaplama = tatil_gunleri($m,$y);
        if($tatil_hesaplama){
            $total_ay_sayisi=floatval($total_ay_sayisi_)-$tatil_hesaplama;
        }


        $is_gunu = 30;





        foreach ($list as $invoices) {

            $resmi_olmayan_is_gunu = $this->db->query("SELECT COUNT(id) as gun_say FROM employee_start_job WHERE employee_start_job.er=0 and employee_start_job.deleted_at is null and employee_start_job.status=1 and employee_start_job.user_id=$invoices->personel_id and
            (employee_start_job.created_at >= '$start' and employee_start_job.created_at  <= '$end')")->row()->gun_say;

            $vade_date_start=$y.'-'.$m.'-01';
            $vade_date_end=$y.'-'.$m.'-'.$total_ay_sayisi_;

//            $nakit_avans=$this->db->query("SELECT IF(SUM(total),SUM(total),0) as total FROM `geopos_invoices` WHERE  maas_ay=$m and maas_yil=$y and `csd` = $invoices->id AND `invoice_type_id` = 14 AND `method` = '1' ORDER BY `invoicedate` ASC")->row()->total;
//            $nakit_borc=$this->db->query("SELECT IF(SUM(total),SUM(total),0) as total FROM `salary_credit` WHERE `vade_date` BETWEEN '$vade_date_start' AND '$vade_date_end'  and `personel_id` = $invoices->id AND `type` = 2 AND `method` = '1' and status=1 ")->row()->total;
//
            $nakit_borc=0;
            $nakit_avans=0;
            $nakit_avas_kalan=0;

            $banka_avans=0;
            $banka_total_borc=0;
            $banka_borc=0;

//            $banka_avans=$this->db->query("SELECT IF(SUM(total),SUM(total),0) as total FROM `geopos_invoices` WHERE  maas_ay=$m and maas_yil=$y and  `csd` = $invoices->id AND `invoice_type_id` = 14 AND `method` = '3'  ORDER BY `invoicedate` ASC")->row()->total;
//            $banka_borc=$this->db->query("SELECT IF(SUM(total),SUM(total),0) as total FROM `salary_credit` WHERE `vade_date` BETWEEN '$vade_date_start' AND '$vade_date_end'  and `personel_id` = $invoices->id AND `type` = 2 AND `method` = '3' and status=1")->row()->total;
//            $banka_total_borc=$this->db->query("SELECT IF(SUM(total),SUM(total),0) as total FROM `salary_credit` WHERE  `personel_id` = $invoices->id AND `type` = 2 AND `method` = '3' and bank_status=1")->row()->total;
//

            $start = $y.'-'.$m.'-01';
            $end = $y.'-'.$m.'-'.$total_ay_sayisi_;
            $personel_mezuniyet = personel_mezuniyet_x($invoices->personel_id,1,$start,$end);

            $bordro_kontrol=$this->db->query("SELECT * FROM salary_report WHERE hesaplama_ayi = $m and  hesaplama_yili = $y and  personel_id = $invoices->id ");
                $start = $y.'-'.$m.'-01';
                $end = $y.'-'.$m.'-'.$total_ay_sayisi_;
                $personel_hastaliks = personel_mezuniyet_x($invoices->personel_id,2,$start,$end);


                $gunluk_nakit=0;
                $gunluk_banka=0;
                $hakettigi_maas=0;
                $nakit_hakedis=0;
                $banka_hakedis=0;
                $dsmf_isveren=0;
                $dsmf_isci=0;
                $icbari_sigorta_isveren=0;
                $icbari_sigorta_isci=0;
                $gelir_vergisi=0;
                $banka_salary=$invoices->bank_salary;
                $salary=$invoices->total_maas;
                $mezuniyet_hesap = 0;
                $hastalik_amouth = $personel_hastaliks['tutar'];
                $calisilan_gun_sayisi = $invoices->gun_say;
                $calisilan_gun_sayisi_ = $invoices->gun_say;
                $hesap =0;
                $cemi =0;
                $issizlik_isveren =0;
                $issizlik_isci =0;
                $odenilecek_meblaq =0;
                $kesinti =0;
                $hesaplanan =0;
                $fark =0;
                $banka_hesaplanan =0;

                $odenisli_izin_count =0;
                $odenisli_izin=$this->db->query("SELECT * FROM `geopos_izinler` WHERE emp_id = $invoices->id and  izin_tipi='Ödenişli' and `bas_date` BETWEEN '$start_izin' AND '$end_izin' ");
                if($odenisli_izin->num_rows()>0){
                    foreach ($odenisli_izin->result() as $items){
                        $odenisli_izin_count += intval($this->daysBetween($items->bas_date,$items->bitis_date));
                    }
                }

                $oz_hesabina_count =0;
                $oz_esabina_izin=$this->db->query("SELECT * FROM `geopos_izinler` WHERE emp_id = $invoices->id and  izin_tipi='Öz Hesabına' and `bas_date` BETWEEN '$start_izin' AND '$end_izin' ");
                if($oz_esabina_izin->num_rows()>0){
                    foreach ($oz_esabina_izin->result() as $items){
                        $oz_hesabina_count += intval($this->daysBetween($items->bas_date,$items->bitis_date));
                    }
                }

                $odenisli_izin_count=0;
                $oz_hesabina_count=0;
                if($invoices->s_type==6 || $invoices->s_type==2 || $invoices->s_type==3 || $invoices->s_type==8 || $invoices->s_type == 9 || $invoices->s_type == 10 || $invoices->s_type == 12 ) // Aylık Nakit / Banka veya Aylık Banka
                {

                    $is_gunu = floatval($total_ay_sayisi)-floatval($total_pazar);
                    if($invoices->s_type==8){
                       if($is_gunu < $calisilan_gun_sayisi){
                           $fark = $calisilan_gun_sayisi-$is_gunu;
                           if($banka_salary > 0){
                               $banka_hesaplanan= floatval($banka_salary)/floatval($is_gunu)*floatval($is_gunu);

                               $start = $y.'-'.$m.'-01';
                               $end = $y.'-'.$m.'-'.$total_ay_sayisi_;
                               $personel_mezuniyet = personel_mezuniyet_x($invoices->personel_id,1,$start,$end);


                               if($personel_mezuniyet>0){
                                   $hesap = ( floatval($banka_salary)/floatval($salary_config['mezuniyet_oran']))  * floatval($personel_mezuniyet);
                                   $mezuniyet_hesap = round( $hesap,3);
                               }
                               $cemi = floatval($mezuniyet_hesap)+floatval($banka_hesaplanan)+floatval($hastalik_amouth);

                               $cemi=round($cemi,2);


                               if((floatval($cemi)-floatval($hastalik_amouth)) > $salary_config['salary_200']){
                                   $dsmf_isveren = floatval($salary_config['200_buyuk_toplam']) + (floatval($cemi)-floatval($hastalik_amouth)-floatval($salary_config['salary_200']))*floatval($salary_config['200_buyuk_oran']);
                               }
                               else {
                                   $dsmf_isveren = (floatval($cemi)-floatval($hastalik_amouth))*floatval($salary_config['200_kucuk_oran']);
                               }

                               $dsmf_isveren=round($dsmf_isveren,2);

                               $issizlik_isveren = round(($cemi-$hastalik_amouth) * ($salary_config['issizlik_oran']/100),3);
                               $issizlik_isci =  ($cemi-$hastalik_amouth)*($salary_config['issizlik_oran']/100);

                               $issizlik_isveren=round($issizlik_isveren,2);
                               $issizlik_isci=round($issizlik_isci,2);

                               if($cemi<=floatval($salary_config['icbari_tavan'])){
                                   $icbari_sigorta_isveren = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
                                   $icbari_sigorta_isci = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
                               }
                               elseif($cemi>$salary_config['icbari_tavan']) {
                                   $icbari_sigorta_isveren = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*$salary_config['icbari_tavan_orani']/100;
                                   $icbari_sigorta_isci = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*$salary_config['icbari_tavan_orani']/100;
                               }
                               $icbari_sigorta_isci=round($icbari_sigorta_isci,2);
                               $icbari_sigorta_isveren=round($icbari_sigorta_isveren,2);



                               if(($cemi-floatval($hastalik_amouth)) > floatval($salary_config['salary_200'])){
                                   $dsmf_isci = floatval($salary_config['dsmf_isci_float']) + (floatval($cemi-$hastalik_amouth)-floatval($salary_config['salary_200']))*(floatval($salary_config['dsmf_isci_oran_max'])/100);
                               }
                               else {
                                   $dsmf_isci = (floatval($cemi)-floatval($hastalik_amouth))*(floatval($salary_config['dsmf_isci_oran_min'])/100);

                               }

                               $dsmf_isci=round($dsmf_isci,2);

                               if($cemi > $salary_config['icbari_tavan']){
                                   $gelir_vergisi = ($cemi-$salary_config['icbari_tavan'])*(floatval($salary_config['gelir_vergi_oran'])/100);
                               }
                               else {
                                   $gelir_vergisi=0;
                               }

                               $gelir_vergisi=round($gelir_vergisi,2);
                               $kesinti=floatval($dsmf_isci)+floatval($gelir_vergisi)+floatval($icbari_sigorta_isci)+floatval($issizlik_isci);
                               $odenilecek_meblaq = floatval($cemi)-floatval($kesinti);
                               if($calisilan_gun_sayisi==0){
                                   $odenilecek_meblaq = 0;
                               }

                           }
                           $nakit_hakedis = $fark*(floatval($invoices->salary_day)+floatval($personel_mezuniyet));
                       }
                       else {
                           if($banka_salary > 0){
                               $banka_hesaplanan= floatval($banka_salary)/$is_gunu*$calisilan_gun_sayisi;

                               $start = $y.'-'.$m.'-01';
                               $end = $y.'-'.$m.'-'.$total_ay_sayisi_;
                               $personel_mezuniyet = personel_mezuniyet_x($invoices->personel_id,1,$start,$end);

                               if($personel_mezuniyet>0){
                                   $hesap = ( floatval($banka_salary)/floatval($salary_config['mezuniyet_oran']))  * floatval($personel_mezuniyet);
                                   $mezuniyet_hesap = round( $hesap,3);

                               }
                               $cemi = floatval($mezuniyet_hesap)+floatval($banka_hesaplanan)+floatval($hastalik_amouth);
                               $cemi=round($cemi,2);



                               if((floatval($cemi)-floatval($hastalik_amouth)) > $salary_config['salary_200']){
                                   $dsmf_isveren = $salary_config['200_buyuk_toplam'] + ($cemi-$hastalik_amouth-$salary_config['salary_200'])*$salary_config['200_buyuk_oran'];
                               }
                               else {
                                   $dsmf_isveren = ($cemi-$hastalik_amouth)*$salary_config['200_kucuk_oran'];
                               }

                               $dsmf_isveren=round($dsmf_isveren,2);

                               $issizlik_isveren = round($cemi * ($salary_config['issizlik_oran']/100),3);
                               $issizlik_isci =  floatval($cemi)*(floatval($salary_config['issizlik_oran'])/100);

                               $issizlik_isci=round($issizlik_isci,2);
                               $issizlik_isveren=round($issizlik_isveren,2);


                               if($cemi<=floatval($salary_config['icbari_tavan'])){
                                   $icbari_sigorta_isveren = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
                                   $icbari_sigorta_isci = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
                               }
                               elseif($cemi>$salary_config['icbari_tavan']) {
                                   $icbari_sigorta_isveren = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*($salary_config['icbari_tavan_orani']/100);
                                   $icbari_sigorta_isci = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*($salary_config['icbari_tavan_orani']/100);
                               }

                               $icbari_sigorta_isveren=round($icbari_sigorta_isveren,2);
                               $icbari_sigorta_isci=round($icbari_sigorta_isci,2);


                               if((floatval($cemi)-floatval($hastalik_amouth)) > floatval($salary_config['salary_200'])){
                                   $dsmf_isci= $salary_config['dsmf_isci_float'] + ($cemi-$hastalik_amouth-$salary_config['salary_200'])*($salary_config['dsmf_isci_oran_max']/100);

                               }
                               else {
                                   $dsmf_isci = ($cemi-$hastalik_amouth)*(floatval($salary_config['dsmf_isci_oran_min'])/100);

                               }

                               $dsmf_isci=round($dsmf_isci,2);


                               if($cemi > $salary_config['icbari_tavan']){
                                   $gelir_vergisi = ($cemi-$salary_config['icbari_tavan'])*(floatval($salary_config['gelir_vergi_oran'])/100);
                               }
                               else {
                                   $gelir_vergisi=0;
                               }

                               $gelir_vergisi=round($gelir_vergisi,2);

                               $kesinti=floatval($dsmf_isci)+floatval($gelir_vergisi)+floatval($icbari_sigorta_isci)+floatval($issizlik_isci);
                               $odenilecek_meblaq = floatval($cemi)-floatval($kesinti);
                               if($calisilan_gun_sayisi==0){
                                   $odenilecek_meblaq = 0;
                               }

                           }
						    $nakit_hakedis = $calisilan_gun_sayisi*(floatval($invoices->salary_day)+floatval($personel_mezuniyet));
                       }


                    }
                    else {

                        if($banka_salary > 0){

                            if($invoices->s_type == 12){
                                $salary=$calisilan_gun_sayisi*floatval($invoices->salary_day);
                                $banka_salary= $calisilan_gun_sayisi*floatval($invoices->salary_day);;

                            }
                            $banka_hesaplanan= floatval($banka_salary)/$is_gunu*$calisilan_gun_sayisi;

                            $start = $y.'-'.$m.'-01';
                            $end = $y.'-'.$m.'-'.$total_ay_sayisi_;
                            $personel_mezuniyet = personel_mezuniyet_x($invoices->personel_id,1,$start,$end);


                            if($personel_mezuniyet >0){
                                $hesap = ( floatval($banka_salary)/floatval($salary_config['mezuniyet_oran']))  * floatval($personel_mezuniyet);
                                $mezuniyet_hesap = round( $hesap,2);
                            }



                            $cemi = floatval($mezuniyet_hesap)+floatval($banka_hesaplanan)+floatval($hastalik_amouth);

                            $cemi=round($cemi,2);



                            if((floatval($cemi)-floatval($hastalik_amouth)) > $salary_config['salary_200']){
                                $dsmf_isveren = $salary_config['200_buyuk_toplam'] + ($cemi-$hastalik_amouth-$salary_config['salary_200'])*$salary_config['200_buyuk_oran'];
                            }
                            else {
                                $dsmf_isveren = ($cemi-$hastalik_amouth)*$salary_config['200_kucuk_oran'];
                            }

                            $dsmf_isveren=round($dsmf_isveren,2);

                            $issizlik_isveren = round(($cemi-$hastalik_amouth) * ($salary_config['issizlik_oran']/100),3);
                            $issizlik_isveren=round($issizlik_isveren,2);
                            $issizlik_isci =  floatval(($cemi-$hastalik_amouth))*($salary_config['issizlik_oran']/100);
                            $issizlik_isci=round($issizlik_isci,2);


                            if($cemi<=floatval($salary_config['icbari_tavan'])){
                                $icbari_sigorta_isveren = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
                                $icbari_sigorta_isci = ($cemi-$hastalik_amouth)*($salary_config['icbari_taban_orani']/100);
                            }
                            elseif($cemi>$salary_config['icbari_tavan']) {
                                $icbari_sigorta_isveren = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*$salary_config['icbari_tavan_orani']/100;
                                $icbari_sigorta_isci = $salary_config['icbari_tavan_float']+($cemi-$salary_config['icbari_tavan'])*$salary_config['icbari_tavan_orani']/100;
                            }


                            $icbari_sigorta_isci=round($icbari_sigorta_isci,2);
                            $icbari_sigorta_isveren=round($icbari_sigorta_isveren,2);

                            if(($cemi-$hastalik_amouth) > floatval($salary_config['salary_200'])){
                                $dsmf_isci = $salary_config['dsmf_isci_float'] + ($cemi-$hastalik_amouth-$salary_config['salary_200'])*$salary_config['dsmf_isci_oran_max']/100;
                            }
                            else {
                                $dsmf_isci = ($cemi-$hastalik_amouth)*floatval($salary_config['dsmf_isci_oran_min'])/100;

                            }

                            $dsmf_isci=round($dsmf_isci,2);

                            if($cemi > $salary_config['icbari_tavan']){
                                $gelir_vergisi = ($cemi-$salary_config['icbari_tavan'])*floatval($salary_config['gelir_vergi_oran'])/100;
                            }
                            else {
                                $gelir_vergisi=0;
                            }

                            $gelir_vergisi=round($gelir_vergisi,2);

                            $kesinti=floatval($dsmf_isci)+floatval($gelir_vergisi)+floatval($icbari_sigorta_isci)+floatval($issizlik_isci);
                            $odenilecek_meblaq = floatval($cemi)-floatval($kesinti);
                            if($calisilan_gun_sayisi==0 && $mezuniyet_hesap==0){
                                $odenilecek_meblaq = 0;
                            }

                        }
                    }





                }


                else if($invoices->s_type == 1 || $invoices->s_type == 2){
                    $calisilan_gun_sayisi = floatval($calisilan_gun_sayisi)+floatval($personel_mezuniyet);

                    $gunluk = $salary/$is_gunu;
                    if($salary == $banka_salary){
                        $nakit_hakedis = 0;
                    }
                    else {


                        $nakit_hakedis=($gunluk*$calisilan_gun_sayisi)-$nakit_avans-$banka_avans;
                    }

                    $banka_avans=0;
                }
                if($invoices->s_type == 4 || $invoices->s_type == 9 || $invoices->s_type == 10){
                    $calisilan_gun_sayisi = floatval($calisilan_gun_sayisi)+floatval($personel_mezuniyet);

                    $gunluk = $invoices->salary_day;
                    if($invoices->s_type == 10){
                        $gunluk = $salary/$is_gunu;
                        $nakit_hakedis=($gunluk*$calisilan_gun_sayisi)-$nakit_avans-$banka_avans;
                    }
                    else {
                        $nakit_hakedis=($gunluk*$calisilan_gun_sayisi)-$nakit_avans-$banka_avans;
                    }
                    $banka_avans=0;
                }





                $disabled='';
                if($invoices->gun_say==0){
                    $disabled='disabled';
                }


                $banka_hakedis = floatval($odenilecek_meblaq)-floatval($banka_avans);



                if($invoices->s_type==6 || $invoices->s_type==2){ // Aylık hem Nakit hem banka
                    $gunluk = $salary / $is_gunu;
                    $fark = $is_gunu-$calisilan_gun_sayisi;
                    $totals=0;
                    if($fark > 0){
                        $totals = $fark*$gunluk+$kesinti;
                    }

                    $nakit_hakedis = (($salary/$is_gunu)*$calisilan_gun_sayisi)-$banka_hakedis-floatval($nakit_avans);
//                    $nakit_hakedis = $salary-$banka_hakedis-floatval($nakit_avans);

                    if($nakit_hakedis < 0 || $salary == $banka_salary) {
                        $nakit_hakedis = 0;
                    }
                }


                $date = new DateTime('now');

                $hesaplama_ayi= $date->format('m');
                $hesaplama_yili= $date->format('Y');
                if($this->input->post('start_date')){

                    $hesaplama_ayi = $this->input->post('start_date');
                }

                if($this->input->post('hesap_yil')){

                    $hesaplama_yili = $this->input->post('hesap_yil');
                }
                $date_now = $date->format($hesaplama_yili.'-'.$m.'-d');
                $check='';
                $color="background-color: #b1b1b1;color: #484848;";



                $razi_total = 0;
                $salary_type_kontrol = $this->db->query("SELECT * FROM personel_salary WHERE personel_id=$invoices->id and status=1")->row()->salary_type;
                if($salary_type_kontrol==3 || $invoices->s_type == 9 || $invoices->s_type == 10){
                    $razi_total = $odenilecek_meblaq;
                }

                $filter_Date = $date->format('Y-'.$m.'-'.$total_ay_sayisi_.' 23:59:59');
                $filter_Date_s = $date->format('Y-'.$m.'-01  00:00:00');
                //echo "SELECT SUM(total) as total FROM geopos_invoices Where invoicedate  BETWEEN '$filter_Date_s' AND '$filter_Date' AND invoice_type_id = 15 and  csd=$invoices->id";die();
                $prim = $this->db->query("SELECT SUM(total) as total FROM geopos_invoices Where invoicedate  BETWEEN '$filter_Date_s' AND '$filter_Date' AND invoice_type_id = 15 and  csd=$invoices->id")->row()->total;
                $ceza = $this->db->query("SELECT SUM(total) as total FROM geopos_invoices Where invoicedate  BETWEEN '$filter_Date_s' AND '$filter_Date' AND  invoice_type_id = 53 and  csd=$invoices->id")->row()->total;

                $nakit_hakedis=$nakit_hakedis-$ceza-floatval($banka_avans);
                $odenilecek_meblaq=$odenilecek_meblaq+$prim;
                if($nakit_hakedis < 0) {
                    $nakit_hakedis = 0;
                }


                if($invoices->salary_proje_id==75){
                    $carp = $calisilan_gun_sayisi_+$resmi_olmayan_is_gunu;
                    $nakit_hakedis_=floatval($invoices->net_salary)/30 * floatval($carp);
                    $nakit_hakedis=floatval($nakit_hakedis_)-floatval($nakit_borc);
                }


                $nakit_odeme = round($nakit_hakedis,2);
                $total_nakit_avans=0;
                $total_banka_avans=0;

                $total_banka_borc=0;
                $total_nakit_borc=0;
                $total_nakit_alacak=0;
                $total_banka_alacak=0;

                if(!$bordro_kontrol->num_rows()){

                    $borc_total = $this->personel_borc_ogren($invoices->personel_id);
                    $pers_bakiye=$this->personel_bakiye($invoices->personel_id);


                    if($pers_bakiye['nakit_bakiye_status']==1){
                        $total_nakit_avans=$pers_bakiye['nakit_bakiye'];
                    }
                    if($pers_bakiye['banka_bakiye_status']==1){
                        $total_banka_avans=$pers_bakiye['banka_bakiye'];
                    }


                    if($pers_bakiye['nakit_bakiye_status']==0){
                        $total_nakit_alacak=$pers_bakiye['nakit_bakiye'];
                    }
                    if($pers_bakiye['banka_bakiye_status']==0){
                        $total_banka_alacak=$pers_bakiye['banka_bakiye'];
                    }

                    if($borc_total['nakit_bakiye_status']==1){
                        $total_nakit_borc=$borc_total['nakit_bakiye'];
                    }
                    if($borc_total['banka_bakiye_status']==1){
                        $total_banka_borc=$borc_total['banka_bakiye'];
                    }


                    $total_nakit_avans+=$total_nakit_borc;
                    $total_banka_avans+=$total_banka_borc;


                    //$nakit_avas_kalan=floatval($nakit_avans);
                    $nakit_avas_kalan=floatval($total_nakit_avans);
                    $banka_avans_kalan=floatval($banka_borc)+floatval($banka_avans);
                    //$nakit_odeme = floatval($nakit_odeme)-floatval($nakit_borc);
                    $nakit_odeme = floatval($nakit_odeme)-floatval($total_nakit_avans);

                    if($nakit_odeme<0){
                        $nakit_odeme=0;
                    }
                    $nakit_hakedis=floatval($nakit_hakedis)-floatval($nakit_borc)+floatval($total_nakit_alacak);


//                    if($banka_total_borc){
//                        if($banka_total_borc > $banka_hakedis){
//                            $nakit_hakedis=$nakit_hakedis+(floatval($banka_hakedis)-floatval($banka_borc));
//                            $nakit_odeme=$nakit_odeme+(floatval($banka_hakedis)-floatval($banka_borc));
//                            $banka_hakedis=0;
//                        }
//                        else{
//
//                            if($banka_total_borc==0){
//                                $nakit_hakedis=$nakit_hakedis-floatval($banka_borc);
//                                $nakit_odeme=$nakit_odeme-floatval($banka_borc);
//                            }
//                            else {
//                                if($invoices->s_type!=2){
//                                    $nakit_hakedis=$nakit_hakedis+floatval($banka_borc);
//                                    $nakit_odeme=$nakit_odeme+floatval($banka_borc);
//                                }
//
//                            }
//                            $banka_hakedis=floatval($banka_hakedis)-floatval($banka_total_borc);
//                        }
//                        $nakit_hakedis=round($nakit_hakedis,2);
//
//
//                    }



                    $check ="<input type='checkbox' class='form-control one_select' nakit_borc='$nakit_borc' 
banka_borc='$banka_borc' razi_total='$razi_total' nakit_odenilecek='$nakit_odeme'  prim='$prim' ceza='$ceza' 
hesaplama_yili='$hesaplama_yili' hesaplama_ayi ='$hesaplama_ayi' proje_id='$invoices->salary_proje_id' 
personel_id='$invoices->id'  salary='$salary' is_gunu='$is_gunu'  calisilan_gun_sayisi_='$calisilan_gun_sayisi_'  
banka_hesaplanan='$banka_hesaplanan' mezuniyet='$invoices->mezuniyet'  mezuniyet_hesap='$mezuniyet_hesap' 
hastalik_amouth='$hastalik_amouth' cemi='$cemi' dsmf_isveren='$dsmf_isveren'  issizlik_isveren='$issizlik_isveren' 
icbari_sigorta_isveren='$icbari_sigorta_isveren' dsmf_isci='$dsmf_isci'  issizlik_isci='$issizlik_isci'  
icbari_sigorta_isci='$icbari_sigorta_isci'   gelir_vergisi='$gelir_vergisi'  odenilecek_meblaq='$odenilecek_meblaq' 
banka_avans='$banka_avans_kalan'  nakit_avans='$nakit_avas_kalan' banka_hakedis='$banka_hakedis' kesinti='$kesinti' 
nakit_hakedis='$nakit_hakedis' odenisli_izin_count='$odenisli_izin_count' oz_hesabina_count='$oz_hesabina_count' 
value='$invoices->id' style='width: 30px;' >";;
                    $color='';
                    if($invoices->is_cikis_date){
                        $color="background-color: #b10000;color: #ffffff;";
                    }
                    if($invoices->mezuniyet_start_date){

                        $start_date = $invoices->mezuniyet_start_date;
                        $mezuniyet_date = date('Y-m-d', strtotime( $start_date . " +".$invoices->mezuniyet." days"));

                        if($start_date < $date_now &&  $mezuniyet_date > $date_now ){

                            $color.="background-color: #00a1b1;color: #ffffff;";
                        }

                    }

                }



                $row = array();
                $row[] = $invoices->name;
                $row[] = $check;
                $row[] =  $invoices->proje_name;
                $row[] =  amountFormat($salary);
                $row[] = $is_gunu;
                $row[] = "<button class='bg-success text-white job_report border border-success' personel_id='$invoices->id' hesaplama_ayi='$hesaplama_ayi' hesaplama_yili='$hesaplama_yili'>$calisilan_gun_sayisi_</button>";
                $row[] =  amountFormat($banka_hesaplanan);
                $row[] =  $invoices->mezuniyet;
                $row[] =  amountFormat($mezuniyet_hesap);
                $row[] =  amountFormat($hastalik_amouth);
                $row[] =  amountFormat($cemi);
                $row[] =  amountFormat($dsmf_isveren);
                $row[] =  amountFormat($issizlik_isveren);
                $row[] =  amountFormat($icbari_sigorta_isveren);
                $row[] =  amountFormat($dsmf_isci);
                $row[] =  amountFormat($issizlik_isci);
                $row[] =  amountFormat($icbari_sigorta_isci);
                $row[] =  amountFormat($gelir_vergisi);
                $row[] =  amountFormat($odenilecek_meblaq);
                $row[] =  amountFormat($total_banka_avans);
                $row[] =  amountFormat($total_nakit_avans);
                $row[] =  amountFormat($banka_hakedis);
                $row[] =  amountFormat($prim);
                $row[] =  amountFormat($ceza);
                $row[] =  amountFormat($nakit_hakedis);
                $row[] =  $odenisli_izin_count;
                $row[] =  $oz_hesabina_count;
                $row[] =  amountFormat($razi_total);
//                $row[] =  amountFormat($total_nakit_borc);
                $row[] =  amountFormat($nakit_avas_kalan);
                $row[] =  amountFormat($banka_borc);
                $row[] =  $color;
                //$row[] =  '<button '.$disabled.' type="button" tip="personel_maas_odemesi" hakedis="'.round($hakettigi_maas,2).'" gun_say = "'.$invoices->gun_say.'" data-id="'.$invoices->id.'" data-toggle="modal" data-remote="false" class="odeme_emri_button btn btn-info">Ödeme Emri Ver</button>';

                $data[] = $row;

                $i++;



        }






        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->cont->count_personel_takip_all(),

            "recordsFiltered" => $this->cont->count_personel_takip_filtered(),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);



    }

    function turkcetarih_formati($format, $datetime = 'now'){
        $z = date("$format", strtotime($datetime));
        $gun_dizi = array(
            'Monday'    => 'Pazartesi',
            'Tuesday'   => 'Salı',
            'Wednesday' => 'Çarşamba',
            'Thursday'  => 'Perşembe',
            'Friday'    => 'Cuma',
            'Saturday'  => 'Cumartesi',
            'Sunday'    => 'Pazar',
            'January'   => 'Ocak',
            'February'  => 'Şubat',
            'March'     => 'Mart',
            'April'     => 'Nisan',
            'May'       => 'Mayıs',
            'June'      => 'Haziran',
            'July'      => 'Temmuz',
            'August'    => 'Ağustos',
            'September' => 'Eylül',
            'October'   => 'Ekim',
            'November'  => 'Kasım',
            'December'  => 'Aralık',
            'Mon'       => 'Pts',
            'Tue'       => 'Sal',
            'Wed'       => 'Çar',
            'Thu'       => 'Per',
            'Fri'       => 'Cum',
            'Sat'       => 'Cts',
            'Sun'       => 'Paz',
            'Jan'       => 'Oca',
            'Feb'       => 'Şub',
            'Mar'       => 'Mar',
            'Apr'       => 'Nis',
            'Jun'       => 'Haz',
            'Jul'       => 'Tem',
            'Aug'       => 'Ağu',
            'Sep'       => 'Eyl',
            'Oct'       => 'Eki',
            'Nov'       => 'Kas',
            'Dec'       => 'Ara',
        );
        foreach($gun_dizi as $en => $tr){
            $z = str_replace($en, $tr, $z);
        }
        if(strpos($z, 'Mayıs') !== false && strpos($format, 'F') === false) $z = str_replace('Mayıs', 'May', $z);
        return $z;
    }

    public function personel_salary_report_ajax_odenis(){
        $list = $this->cont->get_datatables_personel_bordro_odenis($this->limited);

        $data = array();
        $no = $this->input->post('start');
        $this->session->set_userdata('test', 1);

        $aaut_id=$this->aauth->get_user()->id;


        $i = 1;
        foreach ($list as $invoices) {

            $nakit_durum=$invoices->alacak_durum_nakit;
            if($nakit_durum){
                $nakit_durum='<span class="badge badge-success">Nakit Alacaklandırıldı</span>';
            }
            else {
                $nakit_durum='';
            }
            $banka_durum =$invoices->alacak_durum;

            if($banka_durum){
                $banka_durum='<span class="badge badge-success">Banka Alacaklandırıldı</span>';
            }
            else {
                $banka_durum='';
            }




            $count = $this->db->query("SELECT COUNT(salary_report.id) as count FROM `salary_report` INNER JOIN  salary_onay on salary_report.id =salary_onay.salary_report_id WHERE salary_report.proje_id=$invoices->proje_id and salary_report.hesaplama_ayi='$invoices->hesaplama_ayi' and salary_onay.user_id = $aaut_id and (salary_onay.banka_status=0 or salary_onay.nakit_status=0) ")->row()->count;
            $row = array();
            $row[] = "<input type='checkbox' class='form-control one_select' hesaplama_ayi='$invoices->hesaplama_ayi' proje_id='$invoices->proje_id' report_id='$invoices->id' style='width: 30px;' >";;
            if($this->input->post('status')){
                $desc='';
                if($invoices->bank_payment_status==1){
                    $desc.=' (Banka Onaylı) ';
                }
                if($invoices->cache_payment_status==1){
                    $desc.=' (Nakit Onaylı)';
                }

                $row[] = personel_details($invoices->personel_id). ' '.$desc;
            }
            else {
                $row[] = personel_details($invoices->personel_id). ' <button class="btn btn-success project_personel_salary btn-sm" hesaplama_ayi="'.$invoices->hesaplama_ayi.'" proje_id="'.$invoices->proje_id.'">'.$count.' Personel</button>';
            }

            $t=date('Y-'.$invoices->hesaplama_ayi.'-d');
            $date  = $this->turkcetarih_formati('F',$t);

            $razi_total = 0;
            $report_details = $this->db->query("SELECT salary_report.* FROM `salary_report` INNER JOIN  salary_onay on salary_report.id =salary_onay.salary_report_id WHERE
            salary_report.proje_id=$invoices->proje_id and salary_report.hesaplama_ayi='$invoices->hesaplama_ayi' and
            (salary_onay.banka_status=0 or salary_onay.nakit_status=0) ")->result();
            foreach ($report_details as $items){
                $salary_type_kontrol = $this->db->query("SELECT * FROM personel_salary WHERE personel_id=$items->personel_id and status=1")->row()->salary_type;
                if($salary_type_kontrol==3){

                    $razi_total += $items->odenilecek_meblaq;

                }
            }






            $row[] =  $banka_durum;
            $row[] =  $nakit_durum;
            $row[] =$date;
            $row[] = amountFormat($invoices->salary);
            $row[] = $invoices->is_gunu;
            $row[] =  amountFormat($invoices->banka_hesaplanan);
            $row[] = amountFormat($invoices->cemi);
            $row[] = amountFormat($invoices->dsmf_isveren);
            $row[] =  amountFormat($invoices->issizlik_isveren);
            $row[] =  amountFormat($invoices->icbari_sigorta_isveren);
            $row[] =  amountFormat($invoices->dsmf_isci);
            $row[] =  amountFormat($invoices->issizlik_isci);
            $row[] =  amountFormat($invoices->icbari_sigorta_isci);
            $row[] =  amountFormat($invoices->gelir_vergisi);
            $row[] =  amountFormat($invoices->odenilecek_meblaq);
            $row[] =  amountFormat($invoices->banka_avans);
            $row[] =  amountFormat($invoices->nakit_avans);
            $row[] =  amountFormat($invoices->banka_hakedis);
            $row[] =  amountFormat($invoices->nakit_odenilecek);
            $row[] =  $invoices->odenisli_izin_count;
            $row[] =  $invoices->oz_hesabina_count;
            $row[] =  $invoices->salary_type_name;
            $row[] =  amountFormat($invoices->bank_salary);
            $row[] =  amountFormat($razi_total);
            $data[] = $row;

            $i++;

        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->cont->count_personel_bordro_all_odenis($this->limited),

            "recordsFiltered" => $this->cont->count_personel_bordro_all_odenis_filter($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);

    }

    public function personel_salary_report_ajax(){
        $list = $this->cont->get_datatables_personel_bordro($this->limited);

        $data = array();



        $no = $this->input->post('start');

        $this->session->set_userdata('test', 1);


        $aaut_id=$this->aauth->get_user()->id;


        $i = 1;
        foreach ($list as $invoices) {




            $count = $this->db->query("SELECT COUNT(salary_report.id) as count FROM `salary_report` INNER JOIN  salary_onay on salary_report.id =salary_onay.salary_report_id WHERE salary_report.proje_id=$invoices->proje_id and salary_report.hesaplama_ayi='$invoices->hesaplama_ayi' and salary_onay.user_id = $aaut_id  and  (salary_onay.banka_status=0 or salary_onay.nakit_status=0) ")->row()->count;
            $row = array();
            $row[] = "<input type='checkbox' class='form-control one_select'  hesaplama_ayi='$invoices->hesaplama_ayi' proje_id='$invoices->proje_id' hesaplama_yili='$invoices->hesaplama_yili' style='width: 30px;'  >";;
            if($this->input->post('status')){
                $desc='';
                if($invoices->bank_payment_status==1){
                    $desc.=' (Banka Onaylı) ';
                }
                if($invoices->cache_payment_status==1){
                    $desc.=' (Nakit Onaylı)';
                }

                $row[] = $invoices->proje_name. ' '.$desc;
            }
            else {
                $row[] = $invoices->proje_name. ' <button class="btn btn-success project_personel_salary btn-sm" hesaplama_ayi="'.$invoices->hesaplama_ayi.'" hesaplama_yili="'.$invoices->hesaplama_yili.'" proje_id="'.$invoices->proje_id.'">'.$count.' Personel</button>';
            }

            $t=date('Y-'.$invoices->hesaplama_ayi.'-d');
            $date  = $this->turkcetarih_formati('F',$t);

            $razi_total = 0;
            $report_details = $this->db->query("SELECT salary_report.* FROM `salary_report` INNER JOIN  salary_onay on salary_report.id =salary_onay.salary_report_id WHERE
            salary_report.proje_id=$invoices->proje_id and salary_report.hesaplama_ayi='$invoices->hesaplama_ayi' and
            (salary_onay.banka_status=0 or salary_onay.nakit_status=0) ")->result();
            foreach ($report_details as $items){
                $salary_type_kontrol = $this->db->query("SELECT * FROM personel_salary WHERE personel_id=$items->personel_id and status=1")->row()->salary_type;
                if($salary_type_kontrol==3){

                    $razi_total += $items->odenilecek_meblaq;

                }
            }






            $row[] =$date;
            $row[] = amountFormat($invoices->salary);
            $row[] = $invoices->is_gunu;
            $row[] =  amountFormat($invoices->banka_hesaplanan);
            $row[] = amountFormat($invoices->cemi);
            $row[] = amountFormat($invoices->dsmf_isveren);
            $row[] =  amountFormat($invoices->issizlik_isveren);
            $row[] =  amountFormat($invoices->icbari_sigorta_isveren);
            $row[] =  amountFormat($invoices->dsmf_isci);
            $row[] =  amountFormat($invoices->issizlik_isci);
            $row[] =  amountFormat($invoices->icbari_sigorta_isci);
            $row[] =  amountFormat($invoices->gelir_vergisi);
            $row[] =  amountFormat($invoices->odenilecek_meblaq);
            $row[] =  amountFormat($invoices->banka_avans);
            $row[] =  amountFormat($invoices->nakit_avans);
            $row[] =  amountFormat($invoices->banka_hakedis);
            $row[] =  amountFormat($invoices->nakit_hakedis);
            $row[] =  $invoices->odenisli_izin_count;
            $row[] =  $invoices->oz_hesabina_count;
            $row[] =  amountFormat($razi_total);
            $data[] = $row;

            $i++;

        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->cont->count_envanter_all($this->limited),

            "recordsFiltered" => $this->cont->count_personel_bordro_all($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);

    }


    public function personel_project_ajax_salary(){
        $list = $this->cont->get_datatables_personel_salary($this->limited);

        $data = array();


        $user_id  = $this->aauth->get_user()->id;

        $no = $this->input->post('start');

        $this->session->set_userdata('test', 1);


        $i = 1;
        foreach ($list as $invoices) {

            $onay_kontrol = $this->db->query("SELECT * FROM salary_onay Where  salary_report_id=$invoices->id and (salary_onay.banka_status = 0 or salary_onay.nakit_status=0) and user_id =$user_id")->num_rows();
            if($onay_kontrol){
                $salary_info =$this->db->query("select * from personel_salary Where personel_id = $invoices->personel_id and status=1")->row();

                $razi_total=0;
                $start = $invoices->hesaplama_yili.'-'.$invoices->hesaplama_ayi.'-01';
                $total_ay_sayisi_ = cal_days_in_month( CAL_GREGORIAN,intval($invoices->hesaplama_ayi), $invoices->hesaplama_yili);
                $end = $invoices->hesaplama_yili.'-'.$invoices->hesaplama_ayi.'-'.$total_ay_sayisi_;


                $mezuniyet=personel_mezuniyet_x($invoices->personel_id,1,$start,$end);
                if($mezuniyet){
                    $mezuniyet=$mezuniyet;
                }
                else {
                    $mezuniyet=0;
                }
                $borc_total = $this->personel_borc_ogren($invoices->personel_id);
                if($invoices->personel_id==61){
                    $borc = 0;
                }

                $pers_name=personel_details($invoices->personel_id);
                $pers_bakiye=$this->personel_bakiye($invoices->personel_id);


                $total_nakit_avans=0;
                $total_banka_avans=0;

                $total_banka_borc=0;
                $total_nakit_borc=0;
                $total_nakit_alacak=0;
                $total_banka_alacak=0;

                if($pers_bakiye['nakit_bakiye_status']==1){
                    $total_nakit_avans=$pers_bakiye['nakit_bakiye'];
                }
                if($pers_bakiye['banka_bakiye_status']==1){
                    $total_banka_avans=$pers_bakiye['banka_bakiye'];
                }


                if($pers_bakiye['nakit_bakiye_status']==0){
                    $total_nakit_alacak=$pers_bakiye['nakit_bakiye'];
                }
                if($pers_bakiye['banka_bakiye_status']==0){
                    $total_banka_alacak=$pers_bakiye['banka_bakiye'];
                }

                if($borc_total['nakit_bakiye_status']==0){
                    $total_nakit_borc=$borc_total['nakit_bakiye'];
                }
                if($borc_total['banka_bakiye_status']==1){
                    $total_banka_borc=$borc_total['banka_bakiye'];
                }


                $style='';
                $toplam_borc = $total_banka_borc+$total_nakit_borc+$total_banka_avans+$total_nakit_avans;

                if($toplam_borc>0){
                    $style='background: #dd4646;color: white;';
                }


                $total_nakit_avans+=$total_nakit_borc;
                $total_banka_avans+=$total_banka_borc;

                //$bhak=$invoices->banka_hakedis+$invoices->banka_avans;
                $bhak=$invoices->banka_hakedis;
                $bhak_v=$invoices->odenilecek_meblaq;
                $nhak=$invoices->nakit_hakedis+$invoices->nakit_avans;

                $banka_odenecek = floatval($invoices->banka_hakedis)-floatval($total_banka_avans);

                if($toplam_borc > $banka_odenecek){
                    $style='background: #7fc4ff;color: white;';
                }

                $nakit_h_t=0;
                $nhak=0;

//            $nakit_h_t=floatval($total_nakit_alacak)+floatval($invoices->nakit_odenilecek);
//
//            if($invoices->proje_id==75){
//                $nakit_h_t=floatval($total_nakit_alacak)+floatval($invoices->nakit_odenilecek);
//            }

                if($invoices->nakit_odenilecek > 0){
                    $nakit_h_t=floatval($invoices->nakit_odenilecek);
                }
                else {
                    $nakit_h_t=floatval($total_nakit_alacak)+floatval($invoices->nakit_odenilecek);
                }



                $nhak=$nakit_h_t;

                $total_banka_avans_val=0;
                if($total_banka_avans>0){
                    $total_banka_avans_val = $total_banka_avans;
                }


                if($total_banka_avans > ($invoices->salary-$invoices->kesinti) ){
                    $total_banka_avans_val = $invoices->salary-$invoices->kesinti;
                    $banka_odenecek=0;
                }

                if($invoices->aylik_kesinti > 0){
                    $total_banka_avans_val = $invoices->aylik_kesinti;
                }

                $total_banka_avans_val = $invoices->aylik_kesinti;


                if($invoices->salary_type==3){
                    $razi_total=$invoices->banka_hakedis;
                }

                $brut_maas=0;



                if($salary_info->salary_type==6 || $salary_info->salary_type==1){
                    $brut_maas = $invoices->salary;
                }
                else {
                    $brut_maas = $invoices->salary-$invoices->kesinti;;
                }

                $net_maas = net_maas_hesaplama($invoices->personel_id,$invoices->is_gunu);

                $kelbecer_farki = amountFormat(kelbecer_farki($invoices->personel_id));


                $banka_odenecek=$banka_odenecek+$invoices->prim_tutar;
                $row = array();
                $row[] = personel_details($invoices->personel_id);
                $row[] = $invoices->is_gunu;
                $row[] = $invoices->calisilan_gun_sayisi_;
                $row[] = amountFormat($invoices->salary);
               // $row[] = amountFormat($brut_maas);
                $row[] = amountFormat($net_maas);
                $row[] =  amountFormat($invoices->hastalik_amouth);
                $row[] =  amountFormat($invoices->mezuniyet_hesap);
                $row[] =  $mezuniyet;
                $row[] =  amountFormat($invoices->kesinti);
                $row[] =  amountFormat($toplam_borc);
                $row[] =  amountFormat($total_banka_avans);
                $row[] =  amountFormat($total_nakit_avans);
//            $row[] =  amountFormat($invoices->banka_avans);
//            $row[] =  amountFormat($invoices->nakit_avans);
                $row[] =  "<input class='form-control kesinti_maas' minlength='0' type='number' pers_name='$pers_name' value='$total_banka_avans_val' repid='$invoices->id'><input type='hidden' class='text_totals' toplam_avans='".$toplam_borc."' toplam_banka_avans='".$total_banka_avans."' total_nakit_avans='".$total_nakit_avans."' banka_odenecek='".$banka_odenecek."'  nakit_odenecek='".$nhak."'>";
                $row[] =  "<input class='form-control kesinti_n_maas' minlength='0' type='number' pers_name='$pers_name' value='$invoices->aylik_kesinti_nakit' repid='$invoices->id'>";
                $row[] =  "<input class='form-control nakit_geri_odeme' minlength='0' type='number' razi_total='$razi_total' proje_id='$invoices->proje_id' hesaplama_ayi='$invoices->hesaplama_ayi' pers_name='$pers_name' value='$invoices->nakit_geri_odenen' repid='$invoices->id'>";
                $row[] =  amountFormat($invoices->prim_tutar);
                $row[] =  amountFormat($invoices->ceza_tutar);
                $row[] =  '<span class="banka_hakedis" b_hak="'.$banka_odenecek.'" banka_hakedis="'.$bhak.'" bank_odenecek="'.$bhak_v.'">'.amountFormat($bhak_v).'<span>';
                $row[] =  '<span class="nakit_hakedis" nakit_hakedis="'.floatval($nhak).'" >'.amountFormat($nakit_h_t).'<span>';
                $row[] = $kelbecer_farki;
                $row[] =  '<button class="btn btn-success btn-sm tekrar_bordro" proje_id="'.$invoices->proje_id.'" hesaplama_ayi="'.$invoices->hesaplama_ayi.'" rep_id="'.$invoices->id.'"><i class="fa fa-question"></i> Tekrar Bordro</button>';
                $row[] =  $style;
//            $row[] =  $invoices->odenisli_izin_count;
//            $row[] =  $invoices->oz_hesabina_count;
                $data[] = $row;

                $i++;
            }



        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->cont->count_personel_salary_all_($this->limited),

            "recordsFiltered" => $this->cont->count_personel_salary_filter_($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);

    }


    public function tekrar_bordro(){
        $this->db->trans_start();
        $rep_id=$this->input->post('rep_id');
        $desc=$this->input->post('desc');
        $select = $this->db->query('SELECT * FROM `salary_report`  WHERE `salary_report`.`id` ='.$rep_id)->row();
        $personel_name = personel_details($select->personel_id);
        $user_name = personel_details($this->aauth->get_user()->id);
        $maas_ayi = $select->hesaplama_ayi;
        $maas_yili = $select->hesaplama_yili;


        $del1 = $this->db->query('DELETE FROM `salary_report` WHERE `salary_report`.`id` ='.$rep_id);
        $del2 = $this->db->query('DELETE FROM `salary_onay` WHERE salary_onay.salary_report_id ='.$rep_id);

        $proje_text=$personel_name.' Personeli İçin '.$user_name.' Adlı Yetkili Bordroyu Yenilemenizi Talep Etmiştir.'.'Açıklama : '.$desc.' Bordro Yılı : '.$maas_yili.' Bordro Ayı : '.$maas_ayi;
        $subject = 'Bordro Yenileme!';
        $message = 'Sayın Yetkili <br>' . $proje_text;
        $message .= "<br><br><br><br>";

        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

        //1007
        $pers_id=1007;
        $email = personel_detailsa($pers_id)['email'];
        $recipients = array($email);

        if($del1 && $del2 && $this->onay_mailleri($subject, $message, $recipients, 'avans_talep_onay_maili')){
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success', 'message' =>
                "Başarıyla Tekrar Bordro İstendi"));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Errorr', 'message' =>
                "Hata Aldınız Yöneticiye Başvurun"));
        }

    }


    public function personel_job_report(){
        $list = $this->cont->get_datatables_personel_job($this->limited);

        $data = array();

        $hesaplama_ayi=$this->input->post('hesaplama_ayi');
        $hesaplama_yili=$this->input->post('hesaplama_yili');

        $no = $this->input->post('start');

        $this->session->set_userdata('test', 1);


        $i = 1;
        foreach ($list as $invoices) {
            $resmi_g='';
            if($invoices->er==0){
                $resmi_g="Resmi Olmayan Çalışma Günü";
            }
            else {
                $resmi_g="Resmi Olan Çalışma Günü";
            }
            $row = array();
            $row[] = $i;
            $row[] ="<input type='checkbox' class='form-control one_select_job'  personel_id='$invoices->user_id' hesaplama_ayi='$hesaplama_ayi' hesaplama_yili='$hesaplama_yili' id='$invoices->id' value='$invoices->id' style='width: 30px;' >";;;
            $row[] = $invoices->created_at;
            $row[] = personel_details($invoices->staff_id);
            $row[] = $resmi_g;
            $row[] = '<button class="btn btn-danger btn-sm delete_job" personel_id="'.$invoices->user_id.'" hesaplama_ayi="'.$hesaplama_ayi.'" hesaplama_yili="'.$hesaplama_yili.'" type="button" id="'.$invoices->id.'">İptal Et</button>';
            $data[] = $row;

            $i++;

        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->cont->count_personel_job_filter_($this->limited),

            "recordsFiltered" => $this->cont->count_personel_job_all_($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);

    }

    function total_sundays($month,$year)
    {
        $sundays=0;
        $total_days=cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for($i=1;$i<=$total_days;$i++)
            if(date('N',strtotime($year.'-'.$month.'-'.$i))==7)
                $sundays++;
        return $sundays;
    }



    public function pers_update()
    {

        if (!$this->aauth->premission(80)->write) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $this->db->trans_start();
            $result = $this->cont->pers_update();
            if($result['status']){

                echo json_encode(array('status' => 200, 'message' =>$result['messages']));
                $this->db->trans_complete();
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['messages']));
            }
        }


    }

    public function desc_update()
    {

        $this->cont->desc_update();

    }
    public function cont_status_update()
    {
        $this->cont->cont_status_update();
    }

    public function desc()
    {
        $id = $this->input->post('id');
        $data = $this->cont->details($id);
        $this->load->view('cont/desc_view', $data);
    }

    function isWeekend($date) {
        return (date('N', strtotime($date)) > 6);
    }

    public function holidays_add(){
        if (!$this->aauth->premission(37)->write) {
            echo json_encode(array('status' => 'Errorr', 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $desc = $this->input->post('desc');
            $date_create=$this->input->post('start_date');
            $baslangic_gunu = date('d', strtotime("$date_create"));
            $baslangic_ayi = date('m', strtotime("$date_create"));
            $baslangic_yili = date('Y', strtotime("$date_create"));
            $data_items=[
                'month'=>$baslangic_ayi,
                'day'=>$baslangic_gunu,
                'year'=>$baslangic_yili,
                'date'=>$date_create,
                'user_id'=>$this->aauth->get_user()->id,
                'description'=>$desc,
                'loc'=>$this->session->userdata('set_firma_id'),
            ];
            if($this->db->insert('holidays', $data_items)){
                echo json_encode(array('status' => 'Success', 'message' =>
                    "Giriş Başarıyla Yapıldı"));
            }
            else {
                echo json_encode(array('status' => 'Errorr', 'message' =>
                    "Hata Aldınız Yöneticiye Başvurun"));
            }
        }


    }

    public function personel_takip_add()
    {
        $job_status = $this->input->post('job_status');
        $er = $this->input->post('er');
        $ero = $this->input->post('ero');
        $desc = $this->input->post('desc');
        $pers_id = $this->input->post('pers_id');
        $proje_id = $this->input->post('proje_id');


        $mezuniyet = $this->input->post('mezuniyet');
        $hastalik = $this->input->post('hastalik');
        $hestalik_tutar = $this->input->post('hestalik_tutar');



        $date_create=$this->input->post('start_date');
        $date_bitis=$this->input->post('end_date');

        $fark =  $this->daysBetween($date_create,$date_bitis);
        $baslangic_gunu = date('d', strtotime("$date_create"));
        $baslangic_ayi = date('m', strtotime("$date_create"));
        $baslangic_yili = date('Y', strtotime("$date_create"));

        $items='';


        if($pers_id == 0){

            $items = $this->db->query("SELECT * FROM personel_salary Where proje_id = $proje_id and status=1")->result();
            foreach ($items as $user_id)
            {
                for ($i=0; $i <= $fark; $i++){
                    $kayit_date =  $baslangic_yili.'-'.$baslangic_ayi.'-'.floatval($baslangic_gunu+$i).' H:i:s';

                    if($hastalik){
                        if(!tatil_kontrol($baslangic_yili,$baslangic_ayi,floatval($baslangic_gunu+$i))){
                            if($this->isWeekend($baslangic_yili.'-'.$baslangic_ayi.'-'.floatval($baslangic_gunu+$i))!=1) {
                                $data_items = [
                                    'created_at' => $kayit_date,
                                    'personel_id' => $user_id->personel_id,
                                    'mezuniyer_st' => 0,
                                    'hastalik_st' => 1,
                                    'hastalik_tutar' => $hestalik_tutar,
                                ];
                                $this->db->insert('salary_grad', $data_items);
                            }
                        }
                    }
                    if($mezuniyet){
                        if(!tatil_kontrol($baslangic_yili,$baslangic_ayi,floatval($baslangic_gunu+$i))){
                            if($this->isWeekend($baslangic_yili.'-'.$baslangic_ayi.'-'.floatval($baslangic_gunu+$i))!=1) {
                                $data_items = [
                                    'created_at' => $kayit_date,
                                    'personel_id' => $user_id->personel_id,
                                    'mezuniyer_st' => 1,
                                    'hastalik_st' => 0,
                                    'hastalik_tutar' => 0,
                                ];
                                $this->db->insert('salary_grad', $data_items);
                            }
                        }
                    }
                    if($er == 1  || $ero ==1){
                        $data_items=[
                            'created_at'=>$kayit_date,
                            'user_id'=>$user_id->personel_id,
                            'staff_id'=>$this->aauth->get_user()->id,
                            'status'=>$job_status,
                            'description'=>$desc,
                            'er'=>$er,
                        ];
                        $this->db->insert('employee_start_job', $data_items);
                    }



//                    if(!tatil_kontrol($baslangic_yili,$baslangic_ayi,floatval($baslangic_gunu+$i))){
//                        if($this->isWeekend($baslangic_yili.'-'.$baslangic_ayi.'-'.floatval($baslangic_gunu+$i))!=1){
//                            $data_items=[
//                                'created_at'=>$kayit_date,
//                                'user_id'=>$user_id->personel_id,
//                                'staff_id'=>$this->aauth->get_user()->id,
//                                'status'=>$job_status,
//                                'description'=>$desc
//                            ];
//                            $this->db->insert('employee_start_job', $data_items);
//                        }
//                    }




                }
            }

        }
        else {
            $items = explode(',',$pers_id);
            foreach ($items as $user_id)
            {
                for ($i=0; $i <= $fark; $i++){
                    $kayit_date =  $baslangic_yili.'-'.$baslangic_ayi.'-'.floatval($baslangic_gunu+$i).' H:i:s';
                    if($hastalik){
                        if(!tatil_kontrol($baslangic_yili,$baslangic_ayi,floatval($baslangic_gunu+$i))){
                            if($this->isWeekend($baslangic_yili.'-'.$baslangic_ayi.'-'.floatval($baslangic_gunu+$i))!=1) {
                                $data_items = [
                                    'created_at' => $kayit_date,
                                    'personel_id' => $user_id,
                                    'mezuniyer_st' => 0,
                                    'hastalik_st' => 1,
                                    'hastalik_tutar' => $hestalik_tutar,
                                ];
                                $this->db->insert('salary_grad', $data_items);
                            }
                        }
                    }
                    if($mezuniyet){
                        if(!tatil_kontrol($baslangic_yili,$baslangic_ayi,floatval($baslangic_gunu+$i))){
                            if($this->isWeekend($baslangic_yili.'-'.$baslangic_ayi.'-'.floatval($baslangic_gunu+$i))!=1) {
                                $data_items = [
                                    'created_at' => $kayit_date,
                                    'personel_id' => $user_id,
                                    'mezuniyer_st' => 1,
                                    'hastalik_st' => 0,
                                    'hastalik_tutar' => 0,
                                ];
                                $this->db->insert('salary_grad', $data_items);
                            }
                        }
                    }
                    if($er == 1 ||  $ero ==1){
                    $data_items=[
                        'created_at'=>$kayit_date,
                        'user_id'=>$user_id,
                        'staff_id'=>$this->aauth->get_user()->id,
                        'status'=>$job_status,
                        'description'=>$desc,
                        'er'=>$er,
                    ];
                    $this->db->insert('employee_start_job', $data_items);
                    }
//                    if(!tatil_kontrol($baslangic_yili,$baslangic_ayi,floatval($baslangic_gunu+$i))){
//                        if($this->isWeekend($baslangic_yili.'-'.$baslangic_ayi.'-'.floatval($baslangic_gunu+$i))!=1){
//                            $data_items=[
//                                'created_at'=>$kayit_date,
//                                'user_id'=>$user_id,
//                                'staff_id'=>$this->aauth->get_user()->id,
//                                'status'=>$job_status,
//                                'description'=>$desc
//                            ];
//                            $this->db->insert('employee_start_job', $data_items);
//                        }
//                    }
                }
            }

        }




        echo json_encode(array('status' => 'Success', 'message' =>
            "Giriş Başarıyla Yapıldı"));

    }

    public function all_delete_job(){
        $job_id = $this->input->post('job_id');
        $i=0;
        foreach ($job_id as $items)
        {
            $this->db->query("UPDATE employee_start_job set deleted_at = NOW()  WHERE  id = $items");
            $this->aauth->applog("İş Girişi İptal Edildi $items ID ",$this->aauth->get_user()->username);


            $i++;
        }
        if($i > 0){
            echo json_encode(array('status' => 'Success', 'message' =>
                "Giriş Başarıyla Yapıldı"));
        }
        else{
            echo json_encode(array('status' => 'Error', 'message' =>
                "Hata Aldınız"));

        }
    }

    public function cancel_holidays(){
        if (!$this->aauth->premission(37)->delete) {
            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $id = $this->input->post('id');
            if($this->db->query("UPDATE holidays set deleted_at = NOW()  WHERE  id = $id")){
                $this->aauth->applog("Tatil Girişi İptal Edildi $id ID ",$this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' =>
                    "Giriş Başarıyla Yapıldı"));
            }
            else{
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Hata Aldınız"));

            }
        }

    }

    public function bordro_iptal(){

            $this->db->trans_start();


            $proje_details = $this->input->post('proje_details');
            $desc = $this->input->post('desc');
            $count = count($proje_details);
            $say=0;
            $user_name = personel_details($this->aauth->get_user()->id);

            foreach ($proje_details as $prj){

                $proje_id=$prj['proje_id'];
                $proje_code = proje_code($proje_id);
                $hesaplama_ayi=$prj['hesaplama_ayi'];
                $hesaplama_yili=$prj['hesaplama_yili'];

                $this->db->query("DELETE FROM `salary_report` WHERE proje_id=$proje_id and hesaplama_ayi=$hesaplama_ayi and hesaplama_yili=$hesaplama_yili");
                $this->aauth->applog("Bordro İptal Edildi. Proje Kodu :  $proje_code  hesaplama ayı : $hesaplama_ayi hesaplama yılı : $hesaplama_yili ",$this->aauth->get_user()->username);

                $proje_text=$proje_code.' Proje Kodu İçin '.$user_name.' Adlı Yetkili Bordroyu Yenilemenizi Talep Etmiştir.'.'Açıklama : '.$desc.' Bordro Yılı : '.$hesaplama_yili.' Bordro Ayı : '.$hesaplama_ayi;
                $subject = 'Bordro Yenileme!';
                $message = 'Sayın Yetkili <br>' . $proje_text;
                $message .= "<br><br><br><br>";

                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                //1007
                $pers_id=1007;
                $email = personel_detailsa($pers_id)['email'];
                $recipients = array($email);
                $this->onay_mailleri($subject, $message, $recipients, 'avans_talep_onay_maili');

                $say++;
            }




            if($say==$count){
                $this->db->trans_complete();
                echo json_encode(array('status' => 200, 'message' =>
                    "Başarıyla İptal Edildi"));
            }

            else{
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>
                    "Hata Aldınız"));

            }


    }

    public function holidays_update(){
        if (!$this->aauth->premission(37)->update) {


            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $id = $this->input->post('id');
            $desc = $this->input->post('desc');
            $date_create=$this->input->post('start_date');
            $baslangic_gunu = date('d', strtotime("$date_create"));
            $baslangic_ayi = date('m', strtotime("$date_create"));
            $baslangic_yili = date('Y', strtotime("$date_create"));
            $data_items=[
                'month'=>$baslangic_ayi,
                'day'=>$baslangic_gunu,
                'year'=>$baslangic_yili,
                'date'=>$date_create,
                'user_id'=>$this->aauth->get_user()->id,
                'description'=>$desc
            ];
            $this->db->set($data_items);
            $this->db->where('id', $id);
            if($this->db->update('holidays', $data_items)){
                $this->aauth->applog("Tatil Güncellendi  $id ID ",$this->aauth->get_user()->username);
                echo json_encode(array('status' => 'Success', 'message' =>
                    "Giriş Başarıyla Yapıldı"));
            }
            else{
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Hata Aldınız"));

            }
        }

    }

    public function holidays_info(){
        $id = $this->input->post('id');
        $details = $this->db->query("SELECT * FROM holidays Where id = $id")->row();

        echo json_encode(array('status' => 'Success', 'details' =>$details));
    }

    public function bordro_emri(){
        $personel = $this->input->post('personel_details');
        $productlist = [];
        $salary = [];
        $prodindex = 0;



        foreach ($personel as $items)
        {
            $pers_id = $items['personel_id'];
            $salary_type_kontrol = $this->db->query("SELECT * FROM personel_salary WHERE personel_id=$pers_id and status=1")->row()->salary_type;
            $toplam_avas = floatval($items['nakit_avans'])+floatval($items['banka_avans']);
            $data=[
                'hesaplama_ayi'=>$items['hesaplama_ayi'],
                'hesaplama_yili'=>$items['hesaplama_yili'],
                'nakit_odenilecek'=>round($items['nakit_odenilecek'],2),
                'prim_tutar'=>$items['prim'],
                'ceza_tutar'=>$items['ceza'],
                'proje_id'=>$items['proje_id'],
                'personel_id'=>$items['personel_id'],
                'salary'=>$items['salary'],
                'is_gunu'=>$items['is_gunu'],
                'calisilan_gun_sayisi_'=>$items['calisilan_gun_sayisi_'],
                'banka_hesaplanan'=>$items['banka_hesaplanan'],
                'mezuniyet'=>$items['mezuniyet'],
                'mezuniyet_hesap'=>$items['mezuniyet_hesap'],
                'hastalik_amouth'=>$items['hastalik_amouth'],
                'cemi'=>$items['cemi'],
                'dsmf_isveren'=>$items['dsmf_isveren'],
                'issizlik_isveren'=>$items['issizlik_isveren'],
                'icbari_sigorta_isveren'=>$items['icbari_sigorta_isveren'],
                'dsmf_isci'=>$items['dsmf_isci'],
                'issizlik_isci'=>$items['issizlik_isci'],
                'icbari_sigorta_isci'=>$items['icbari_sigorta_isci'],
                'gelir_vergisi'=>$items['gelir_vergisi'],
                'odenilecek_meblaq'=>$items['odenilecek_meblaq'],
                'banka_avans'=>$items['banka_avans'],
                'toplam_avans'=>$toplam_avas,
                'nakit_avans'=>$items['nakit_avans'],
                'banka_hakedis'=>$items['banka_hakedis'],
                'nakit_hakedis'=>$items['nakit_hakedis'],
                'odenisli_izin_count'=>$items['odenisli_izin_count'],
                'oz_hesabina_count'=>$items['oz_hesabina_count'],
                'kesinti'=>$items['kesinti'],
                'nakit_borc'=>$items['nakit_borc'],
                'banka_borc'=>$items['banka_borc'],
                'salary_type'=>$salary_type_kontrol,
                'emp_id'=>$this->aauth->get_user()->id
            ];
            if($this->db->insert('salary_report', $data)) {
                $las_id = $this->db->insert_id();
                $prj_id = $items['proje_id'];
                $firs_id=$this->db->query("SELECT * FROM maas_onay_sort WHERE proje_id =$prj_id and sort = 0")->row()->user_id;
                $data_onay = [
                    'salary_report_id'=>$las_id,
                    'user_id'=>$firs_id
                ];
                $this->db->insert('salary_onay', $data_onay);
                $prodindex++;

                $hesaplama_ayi=$items['hesaplama_ayi'];
                $date = new DateTime('now');
                $y= $items['hesaplama_yili'];
                $total_ay_sayisi = cal_days_in_month( CAL_GREGORIAN,intval($hesaplama_ayi), $y);
                $date_S = $y.'-'.$hesaplama_ayi.'-'.$total_ay_sayisi;

            }

        }
        if ($prodindex > 0) {

            echo json_encode(array('status' => 'Success', 'message' =>
                "Giriş Başarıyla Yapıldı"));
        }
        else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Hata Aldınız"));

        }


    }

    public function bordro_odeme_emri(){

        $pers_id = $this->input->post('pers_id');
        $method = $this->input->post('method');
        $proje_id_arry = $this->input->post('proje_id');
        $proje_text = '';

        $aut_id = $this->aauth->get_user()->id;


        $staff_id=0;


        foreach ($proje_id_arry as $item){
            $proje_id = $item['proje_id'];
            $hesaplama_ayi = $item['hesaplama_ayi'];
            $hesaplama_yili = $item['hesaplama_yili'];
            $talep_details = $this->db->query("SELECT * FROM geopos_projects WHERE id = $proje_id ")->row();
            if($method==1) // Nakit Emir
            {
                $nakit_durum = $this->db->query("SELECT * FROM `salary_report` INNER JOIN salary_onay ON salary_report.id = salary_onay.salary_report_id  Where salary_report.proje_id = $proje_id and salary_report.hesaplama_ayi = $hesaplama_ayi and salary_report.hesaplama_yili = $hesaplama_yili and salary_onay.nakit_status = 0 ");
                if($nakit_durum->num_rows()){
                    $nakit_durum = $this->db->query("SELECT salary_report.* FROM `salary_report` INNER JOIN salary_onay ON salary_report.id = salary_onay.salary_report_id  Where salary_report.proje_id = $proje_id and salary_report.hesaplama_ayi = $hesaplama_ayi  and salary_report.hesaplama_yili = $hesaplama_yili  and salary_onay.nakit_status = 0 ");
                    foreach ($nakit_durum->result() as $items){
                        $repor_id = $items->id;
                        $this->db->query("UPDATE salary_onay set nakit_status = 1  WHERE  salary_report_id = $items->id");

                        $salary_type_kontrol = $this->db->query("SELECT * FROM personel_salary WHERE personel_id=$items->personel_id and status=1")->row()->salary_type;
                        if($salary_type_kontrol == 1 || $salary_type_kontrol==4){
                            $this->db->query("UPDATE salary_onay set banka_status=1  WHERE id =$repor_id");
                        }
                        if($salary_type_kontrol == 8){
                            if($items->nakit_hakedis == 0){
                                $this->db->query("UPDATE salary_onay set banka_status=1  WHERE id =$repor_id");
                            }
                        }
                    }
                }
                else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        $talep_details->name." Projesine Nakit Ödeme Emri Daha Önceden Verilmiştir."));
                    exit();

                }



            }
            else if($method==2) // Banka Emri
            {
                $banka_durum = $this->db->query("SELECT salary_report.* FROM `salary_report` INNER JOIN salary_onay ON salary_report.id = salary_onay.salary_report_id  Where salary_report.proje_id = $proje_id and salary_report.hesaplama_ayi = $hesaplama_ayi  and salary_report.hesaplama_yili = $hesaplama_yili  and salary_onay.banka_status = 0 ");

                if($banka_durum->num_rows()){

                    foreach ($banka_durum->result() as $items){
                        $repor_id = $items->id;
                        $this->db->query("UPDATE salary_onay set banka_status = 1  WHERE  salary_report_id = $items->id");

                        $salary_type_kontrol = $this->db->query("SELECT * FROM personel_salary WHERE personel_id=$items->personel_id and status=1")->row()->salary_type;
                        if($salary_type_kontrol == 2 || $salary_type_kontrol==3){
                            $this->db->query("UPDATE salary_onay set nakit_status=1  WHERE id =$repor_id");
                        }
                    }

                }
                else {
                    echo json_encode(array('status' => 'Error', 'message' =>
                        $talep_details->name." Projesine Banka Ödeme Emri Daha Önceden Verilmiştir."));
                    exit();
                }

            }
            else if($method==3){
                $nakit_durum = $this->db->query("SELECT * FROM `salary_report` INNER JOIN salary_onay ON salary_report.id = salary_onay.salary_report_id  Where salary_report.proje_id = $proje_id and salary_report.hesaplama_ayi = $hesaplama_ayi and salary_report.hesaplama_yili = $hesaplama_yili and salary_onay.nakit_status = 0 ");
                if($nakit_durum->num_rows()){
                    $nakit_durum = $this->db->query("SELECT salary_report.* FROM `salary_report` INNER JOIN salary_onay ON salary_report.id = salary_onay.salary_report_id  Where salary_report.proje_id = $proje_id and salary_report.hesaplama_ayi = $hesaplama_ayi  and salary_report.hesaplama_yili = $hesaplama_yili  and salary_onay.nakit_status = 0 ");
                    foreach ($nakit_durum->result() as $items){
                        $repor_id = $items->id;

                        $onay_kontrol = $this->db->query("SELECT * FROM salary_onay Where  salary_report_id=$repor_id and (salary_onay.banka_status = 0 or salary_onay.nakit_status=0) and user_id =$aut_id")->num_rows();
                        if($onay_kontrol)
                        {
                            $this->db->query("UPDATE salary_onay set nakit_status = 1  WHERE  salary_report_id = $items->id");

                            $salary_type_kontrol = $this->db->query("SELECT * FROM personel_salary WHERE personel_id=$items->personel_id and status=1")->row()->salary_type;
                            if($salary_type_kontrol == 1 || $salary_type_kontrol==4){
                                $this->db->query("UPDATE salary_onay set banka_status=1  WHERE id =$repor_id");
                            }
                            if($salary_type_kontrol == 8){
                                if($items->nakit_hakedis == 0){
                                    $this->db->query("UPDATE salary_onay set banka_status=1  WHERE id =$repor_id");
                                }
                            }
                        }

                    }
                }
                $banka_durum = $this->db->query("SELECT salary_report.* FROM `salary_report` INNER JOIN salary_onay ON salary_report.id = salary_onay.salary_report_id  Where salary_report.proje_id = $proje_id and salary_report.hesaplama_ayi = $hesaplama_ayi  and salary_report.hesaplama_yili = $hesaplama_yili  and salary_onay.banka_status = 0 ");
                if($banka_durum->num_rows()){

                    foreach ($banka_durum->result() as $items){
                        $repor_id = $items->id;
                        $onay_kontrol = $this->db->query("SELECT * FROM salary_onay Where  salary_report_id=$repor_id and (salary_onay.banka_status = 0 or salary_onay.nakit_status=0) and user_id =$aut_id")->num_rows();
                        if($onay_kontrol)
                        {
                            $this->db->query("UPDATE salary_onay set banka_status = 1  WHERE  salary_report_id = $items->id");

                            $salary_type_kontrol = $this->db->query("SELECT * FROM personel_salary WHERE personel_id=$items->personel_id and status=1")->row()->salary_type;
                            if($salary_type_kontrol == 2 || $salary_type_kontrol==3){
                                $this->db->query("UPDATE salary_onay set nakit_status=1  WHERE id =$repor_id");
                            }
                        }
                    }

                }
            }

            $sort_kontol = $this->db->query("SELECT * FROM `maas_onay_sort` where user_id = $aut_id and proje_id = $proje_id");
            if($sort_kontol->num_rows()){
                $sort = $sort_kontol->row()->sort;
                $kontrol_sort = floatval($sort)+floatval(1);
                $staff = $this->db->query("SELECT * FROM `maas_onay_sort` where sort = $kontrol_sort and proje_id = $proje_id");
                if($staff->num_rows()){
                    $staff_id = $staff->row()->user_id;
                    $insert_data_sql = $this->db->query("SELECT * FROM `salary_report`  Where salary_report.proje_id = $proje_id and salary_report.hesaplama_ayi = $hesaplama_ayi and salary_report.hesaplama_yili = $hesaplama_yili")->result();
                    foreach ($insert_data_sql as $items){
                      $onay_kontrol = $this->db->query("SELECT * FROM `salary_onay` where user_id = $staff_id and salary_report_id = $items->id");
                      if(!$onay_kontrol->num_rows()){
                              $data_onay = [
                                  'salary_report_id'=>$items->id,
                                  'user_id'=>$staff_id
                              ];
                              $this->db->insert('salary_onay', $data_onay);
                      }

                   }
                }
                else {
                    $prs_id=0;
                     $odeme_yapacak_pers = $this->db->query("SELECT * FROM `salary_report`  Where salary_report.proje_id = $proje_id and salary_report.hesaplama_ayi = $hesaplama_ayi and salary_report.hesaplama_yili = $hesaplama_yili LIMIT 1")->row();
                     if($odeme_yapacak_pers->pay_set_id){
                         $prs_id = $odeme_yapacak_pers->pay_set_id;
                     }
                     else {
                         $prs_id = $this->input->post('pers_id');
                     }

                    // Ödeme zamanı
                      $salary_odeme_kontrol = [
                          'proje_id'=>$proje_id,
                          'hesaplama_ayi'=>$hesaplama_ayi,
                          'hesaplama_yili'=>$hesaplama_yili,
                          'user_id'=>$prs_id
                      ];
                       $this->db->insert('salary_odeme_kontrol', $salary_odeme_kontrol);

                }
            }

            if(isset($pers_id)) {
                $this->db->query("UPDATE salary_report set pay_set_id=$pers_id  WHERE  proje_id = $proje_id and hesaplama_ayi = $hesaplama_ayi  and hesaplama_yili = $hesaplama_yili ");
            }
            $proje_text.=$talep_details->name.'<br>';
        }


        if($staff_id){
            $subject = 'Bordro Kontrolü!';
            $message = 'Sayın Yetkili <br>' . $proje_text . '  İçin Bordro Onayınız Beklenmektedir.';
            $message .= "<br><br><br><br>";

            $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

            $email = personel_detailsa($staff_id)['email'];
            $recipients = array($email);
            $this->onay_mailleri($subject, $message, $recipients, 'avans_talep_onay_maili');
        }

        if(isset($pers_id)){
            $subject = 'Ödeme Emri!';
            $message = 'Sayın Yetkili <br>' . $proje_text . ' Projelere Emek Hakkı İçin Ödeme Emri Verildi';
            $message .= "<br><br><br><br>";

            $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

            $email = personel_detailsa($pers_id)['email'];
            $recipients = array($email);
            if($this->onay_mailleri($subject, $message, $recipients, 'avans_talep_onay_maili')){
                echo json_encode(array('status' => 'Success', 'message' =>
                    "Başarıyla Ödeme Emri Verildi"));
            }
            else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Hata Aldınız"));
            }
        }

        else {
            echo json_encode(array('status' => 'Success', 'message' =>
                "Başarıyla Oluşturuldu"));
        }



    }

    public function onay_mailleri($subject, $message, $recipients, $tip)
    {

        $attachmenttrue = false;
        $attachment = '';


        $this->communication_model->onay_mail($recipients, $subject, $message, $attachmenttrue, $attachment, $tip);
        return 1;

    }

    public function ajax_account_emp(){
        $emp_id =$this->aauth->get_user()->id;
        $list = $this->db->query('SELECT geopos_accounts.* FROM `geopos_accounts` INNER JOIN geopos_employees ON geopos_accounts.eid = geopos_employees.id WHERE geopos_accounts.eid='.$emp_id.' and  geopos_accounts.status = 1 and geopos_accounts.eid is NOT Null');
        $account=[];
        if($list->num_rows()){
            $account=$list->result();
        }
        else {
            if($this->aauth->get_user()->id == 174){
                $account = $this->db->query('SELECT geopos_accounts.* FROM `geopos_accounts` INNER JOIN geopos_employees ON geopos_accounts.eid = geopos_employees.id WHERE   geopos_accounts.status = 1 and geopos_accounts.eid is NOT Null')->result();

            }
        }
        echo json_encode(array('status' => 'Success', 'item' => $account));
    }

    public function ajax_account_bordro_nakit(){
        $rep_id = $this->input->post('rep_id');
        $emp_id =$this->aauth->get_user()->id;
        $list = $this->db->query('SELECT geopos_accounts.* FROM `geopos_accounts` INNER JOIN geopos_employees ON geopos_accounts.eid = geopos_employees.id WHERE geopos_accounts.eid='.$emp_id.' and  geopos_accounts.status = 1 and geopos_accounts.eid is NOT Null');
        $account=[];
        if($list->num_rows()){
            $account=$list->result();
        }
        else {
            if($this->aauth->get_user()->id = 174){
                $account = $this->db->query('SELECT geopos_accounts.* FROM `geopos_accounts` INNER JOIN geopos_employees ON geopos_accounts.eid = geopos_employees.id WHERE   geopos_accounts.status = 1 and geopos_accounts.eid is NOT Null')->result();

            }
        }

        $toplam_tutar=0;
        $nakit=[];
        foreach ($rep_id as $report_id){
            $list = $this->db->query('SELECT salary_report.*,geopos_employees.name as pers_name FROM `salary_report` INNER JOIN geopos_employees ON salary_report.personel_id = geopos_employees.id WHERE salary_report.nakit_geri_odenen > 0 and  salary_report.id='.$report_id);
            if($list->num_rows()){
                $nakit[]=['name'=>$list->row()->pers_name,'tutar'=>amountFormat($list->row()->nakit_geri_odenen)];
                $toplam_tutar+=$list->row()->nakit_geri_odenen;
            }


        }

        echo json_encode(array('status' => 'Success', 'item' => $account,'nakit'=>$nakit,'toplam_tutar'=>amountFormat($toplam_tutar)));
    }
    public function ajax_account_bordro_razi(){
        $rep_id = $this->input->post('rep_id');
        $emp_id =$this->aauth->get_user()->id;
        $list = $this->db->query('SELECT geopos_accounts.* FROM `geopos_accounts` INNER JOIN geopos_employees ON geopos_accounts.eid = geopos_employees.id WHERE geopos_accounts.eid='.$emp_id.' and  geopos_accounts.status = 1 and geopos_accounts.eid is NOT Null');
        $account=[];
        if($list->num_rows()){
            $account=$list->result();
        }
        else {
            if($this->aauth->get_user()->id = 174){
                $account = $this->db->query('SELECT geopos_accounts.* FROM `geopos_accounts` INNER JOIN geopos_employees ON geopos_accounts.eid = geopos_employees.id WHERE   geopos_accounts.status = 1 and geopos_accounts.eid is NOT Null')->result();

            }
        }

        $toplam_tutar=0;
        $nakit=[];
        foreach ($rep_id as $report_id){
            $list = $this->db->query('SELECT salary_report.*,geopos_employees.name as pers_name FROM `salary_report` INNER JOIN geopos_employees ON salary_report.personel_id = geopos_employees.id WHERE salary_report.salary_type = 3 and  salary_report.id='.$report_id);
            if($list->num_rows()){
                $nakit[]=['name'=>$list->row()->pers_name,'tutar'=>amountFormat($list->row()->odenilecek_meblaq),'rep_id'=>$report_id];
                $toplam_tutar+=$list->row()->odenilecek_meblaq;
            }


        }

        echo json_encode(array('status' => 'Success', 'item' => $account,'nakit'=>$nakit,'toplam_tutar'=>amountFormat($toplam_tutar)));
    }
    public function ajax_account_bordro_edit(){
        $rep_id = $this->input->post('rep_id');
        $emp_id =$this->aauth->get_user()->id;
        $list = $this->db->query('SELECT geopos_accounts.* FROM `geopos_accounts` INNER JOIN geopos_employees ON geopos_accounts.eid = geopos_employees.id WHERE geopos_accounts.eid='.$emp_id.' and  geopos_accounts.status = 1 and geopos_accounts.eid is NOT Null');
        $account=[];
        if($list->num_rows()){
            $account=$list->result();
        }
        else {
            if($this->aauth->get_user()->id = 174){
                $account = $this->db->query('SELECT geopos_accounts.* FROM `geopos_accounts` INNER JOIN geopos_employees ON geopos_accounts.eid = geopos_employees.id WHERE   geopos_accounts.status = 1 and geopos_accounts.eid is NOT Null')->result();

            }
        }

        $toplam_tutar=0;
        $nakit=[];
        foreach ($rep_id as $report_id){
            $list = $this->db->query('SELECT salary_report.*,geopos_employees.name as pers_name FROM `salary_report` INNER JOIN geopos_employees ON salary_report.personel_id = geopos_employees.id WHERE salary_report.id='.$report_id);
            if($list->num_rows()){
                $nakit[]=[
                    'rep_id'=>$list->row()->id,
                    'name'=>$list->row()->pers_name,
                    'toplam_avans'=>$list->row()->toplam_avans,
                    'banka_avans'=>$list->row()->banka_avans,
                    'nakit_avans'=>$list->row()->nakit_avans,
                    'aylik_kesinti'=>$list->row()->aylik_kesinti,
                    'aylik_kesinti_nakit'=>$list->row()->aylik_kesinti_nakit,
                    'nakit_geri_odenen'=>$list->row()->nakit_geri_odenen,
                    'odenilecek_meblaq'=>$list->row()->odenilecek_meblaq,
                    'banka_hakedis'=>$list->row()->banka_hakedis,
                    'nakit_odenilecek'=>$list->row()->nakit_odenilecek,
                    'nakit_hakedis'=>$list->row()->nakit_hakedis,
                ];
            }


        }

        echo json_encode(array('status' => 'Success', 'item' => $account,'nakit'=>$nakit));
    }


    public function salary_edit_confirm(){

        $kont = 0;
        $details = $this->input->post("details");
        foreach ($details as $items){

            $edit_control = $this->db->query("SELECT * FROM salary_report Where edit_status = 1 and id =".$items['rep_id']);
            if($edit_control->num_rows()) {
                $kont++;
            }
        }
        if($kont==0){
            $code=rand(1,99999);
            $data=[
                'codes'=>$code,
            ];
            $this->db->insert('sms_confirm', $data);
            $last_id = $this->db->insert_id();
            $phone = "502862000";
            $meesage ='Bordo Düzenleme Icin Dogrulama Kodu :  '.$code;
            $tel=str_replace(" ","",$phone);
            $domain="https://sms.atatexnologiya.az/bulksms/api";
            $operation='submit';
            $login='makro2000';
            $password="makro!sms";
            $title='MAKRO2000';
            $bulkmessage=$meesage;
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

            $result = curl_exec($ch);
            curl_close($ch);
            echo json_encode(array('confirm_id'=>$last_id,'status' => 'Success', 'message' =>
                "Başarıyla Sms Gönderildi"));
        }
        else {
            echo json_encode(array('status' => 'Errorr', 'message' =>
                "Onayda Bekleyen Düzenlemeleriniz Mevcuttur."));
            exit();
        }

    }
    public function salary_edit_report(){
        $this->db->trans_start();
        $code = $this->input->post("code");
        $confirm_id = $this->input->post("last_id");
        $details = $this->input->post("details");
        $i=0;
        $code_kontrol = $this->db->query("SELECT * FROM sms_confirm Where codes=$code and `deleted_at` IS NULL");
        if($code_kontrol->num_rows()){
            foreach ($details as $items){
                    $data=[
                        'rep_id'=>$items['rep_id'],
                        'nakit_hakedis'=>$items['nakit_hakedis'],
                        'nakit_odenilecek'=>$items['nakit_odenilecek'],
                        'banka_hakedis'=>$items['banka_hakedis'],
                        'odenilecek_meblaq'=>$items['odenilecek_meblaq'],
                        'nakit_geri_odenen'=>$items['nakit_geri_odenen'],
                        'aylik_kesinti_nakit'=>$items['aylik_kesinti_nakit'],
                        'aylik_kesinti'=>$items['aylik_kesinti'],
                        'nakit_avans'=>$items['nakit_avans'],
                        'banka_avans'=>$items['banka_avans'],
                        'toplam_avans'=>$items['toplam_avans'],
                        'status'=>1,
                        'aauth_id '=>$this->aauth->get_user()->id,
                    ];
                    $this->db->insert('salary_edit_table', $data);
                    $i++;
                    $this->db->query("UPDATE salary_report set edit_status = 1  WHERE id =".$items['rep_id']);
            }
            if(count($details)==$i){

                $user_name = personel_details($this->aauth->get_user()->id);
                $proje_text="Bazı Personellerin Onaylanmış Bordroları ".$user_name." Tarafından Düzenlendi İncelemeniz ve Onayınız Gerekmektedir.";
                $subject = 'Bordro Düzenleme!';
                $message = 'Sayın Yetkili <br>' . $proje_text;
                $message .= "<br><br><br><br>";

                $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
             ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');

                //61
                $pers_id=61;
                $email = personel_detailsa($pers_id)['email'];
                $recipients = array($email);

                if($this->onay_mailleri($subject, $message, $recipients, 'avans_talep_onay_maili')){
                    $this->db->query("UPDATE sms_confirm set deleted_at= NOW()  WHERE id =$confirm_id");
                    $this->db->trans_complete();
                    echo json_encode(array('status' => 'Success', 'message' =>
                        "Başarıyla Tekrar Düzenleme İstendi"));
                }
                else {
                    $this->db->trans_rollback();
                    echo json_encode(array('status' => 'Errorr', 'message' =>
                        "Hata Aldınız Yöneticiye Başvurun"));
                }
            }
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>
                "Hata Aldınız Doğrulama Kodu Yanlış"));
        }


    }

    public function personel_maas_alacaklandirma()
    {
        $method = $this->input->post('method');
        $report_id_array = $this->input->post('report_id');
        $proje_text = '';
        $say = 0;

        $date = new DateTime('now');
        $start = $date->format('Y-m-d H:');


        $sny = 0;
        foreach ($report_id_array as $report_id) {

            $kontrol_detils = $this->db->query("SELECT * FROM salary_report Where id = $report_id")->row();
            $m= $kontrol_detils->hesaplama_ayi;
            $y= $kontrol_detils->hesaplama_yili;
            $total_ay_sayisi_ = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
            $sny++;
            $d = date('Y-'.$m.'-'.$total_ay_sayisi_.' H:i:s',strtotime('+'.$sny.' minutes'));

            if ($method == 1) // Nakit
            {
                $kontrol = $this->db->query("SELECT * FROM salary_report Where id = $report_id");
                if ($kontrol_detils->nakit_hakedis > 0) {
                    if($kontrol->row()->alacak_durum_nakit==0){
                        $data_nakit = array(
                            'invoicedate' => $d,
                            'invoiceduedate' => $d,
                            'total' =>$kontrol_detils->nakit_hakedis,
                            'payer' =>personel_details($kontrol_detils->personel_id),
                            'notes' => 'Nakit Hakediş',
                            'csd'=>$kontrol_detils->personel_id,
                            'eid'=>$this->aauth->get_user()->id,
                            'invoice_type_id'=>13,
                            'cari_pers_type'=>2,
                            'method'=>1,
                            'invoice_type_desc'=>'Maaş Alacağı'
                        );
                        $this->db->insert('geopos_invoices', $data_nakit);

//                        if($kontrol_detils->aylik_kesinti_nakit > 0) {
//                            $data_nakit_kesinti = array(
//                                'invoicedate' => $d,
//                                'invoiceduedate' => $d,
//                                'total' => $kontrol_detils->aylik_kesinti_nakit,
//                                'payer' => personel_details($kontrol_detils->personel_id),
//                                'notes' => 'Personel Kesinti',
//                                'csd' => $kontrol_detils->personel_id,
//                                'eid' => $this->aauth->get_user()->id,
//                                'invoice_type_id' => 67,
//                                'cari_pers_type' => 2,
//                                'method' => 1,
//                                'invoice_type_desc' => 'Personel Kesinti'
//                            );
//                            $this->db->insert('geopos_invoices', $data_nakit_kesinti);
//                        }

                        $say++;
                        $this->db->query("UPDATE salary_report set alacak_durum_nakit = 1  WHERE id =$report_id");


                    }
                }
                else {
                    $this->db->query("UPDATE salary_report set alacak_durum_nakit = 1  WHERE id =$report_id");
                }

            }
            else if ($method == 2) // Banka
            {
                $kontrol_banka = $this->db->query("SELECT * FROM salary_report Where  id =$report_id");
                if ($kontrol_detils->banka_hakedis > 0) {
                if($kontrol_banka->row()->alacak_durum==0){
                        $data_banka = array(
                            'invoicedate' => $d,
                            'invoiceduedate' => $d,
                            'total' =>$kontrol_detils->banka_hakedis,
                            'payer' =>personel_details($kontrol_detils->personel_id),
                            'notes' => 'Banka Hakediş',
                            'csd'=>$kontrol_detils->personel_id,
                            'eid'=>$this->aauth->get_user()->id,
                            'invoice_type_id'=>31,
                            'cari_pers_type'=>2,
                            'method'=>3,
                            'invoice_type_desc'=>'Maaş Alacağı Banka'
                        );
                        $this->db->insert('geopos_invoices', $data_banka);
                        $this->db->query("UPDATE salary_report set alacak_durum = 1  WHERE id =$report_id");

                        $say++;
                    }
                }
                else {
                    $this->db->query("UPDATE salary_report set alacak_durum = 1  WHERE id =$report_id");
                }




            }


        }
        if($say){
            echo json_encode(array('status' => 'Success', 'message' =>
                "Başarıyla ".$say." Kişi Alacaklandırıldı"));
        }
        else {
            echo json_encode(array('status' => 'Success', 'message' =>
                "Hata Aldınız"));
        }
    }

    public function personel_maas_odeme(){
        $acid = $this->input->post('acid');
        $method = $this->input->post('method');
        $report_id_array = $this->input->post('report_id');
        $proje_text = '';
        $say=0;

        $date = new DateTime('now');
        $start =  $date->format('Y-m-d H:');


        $sny=0;
        foreach ($report_id_array as $report_id) {

            $kontrol_detils = $this->db->query("SELECT * FROM salary_report Where id = $report_id")->row();
            $m= $kontrol_detils->hesaplama_ayi;
            $y= $kontrol_detils->hesaplama_yili;
            $total_ay_sayisi_ = cal_days_in_month( CAL_GREGORIAN,intval($m), $y);
            $sny++;
            $d = date('Y-m-d H:i:s',strtotime('+'.$sny.' minutes'));

            if($kontrol_detils->nakit_geri_odenen > 0 ){
                $this->sms_bidirimi($kontrol_detils->nakit_geri_odenen,$kontrol_detils->personel_id);
            }

            if ($method == 1) // Nakit
            {
                $kontrol = $this->db->query("SELECT * FROM salary_report Where id = $report_id");
                if($kontrol->row()->cache_pay_odenis==0){
                    $items_ = $this->db->query("SELECT salary_report.* FROM salary_report  Where salary_report.id=$report_id");
                    if($items_->num_rows()){
                        $items=$items_->row();
                        if ($items->nakit_hakedis > 0) {


                            $data = [
                                'total' => $items->nakit_odenilecek,
                                'invoicedate' => $d,
                                'debit' => $items->nakit_odenilecek,
                                'csd' => $items->personel_id,
                                'eid' => $this->aauth->get_user()->id,
                                'invoice_type_id' => 12,
                                'invoice_type_desc' => 'Maaş Ödemesi',
                                'cari_pers_type' => 2,
                                'payer' => personel_details($items->personel_id),
                                'acid' => $acid,
                                'method' => 1,
                                'account' => account_details($acid)->holder,
                                'maas_ay' => $items->hesaplama_ayi,
                                'maas_yil' => $items->hesaplama_yili,
                            ];
                            $this->db->insert('geopos_invoices', $data);
                            $say++;
                            $this->db->query("UPDATE salary_report set cache_pay_odenis = 1  WHERE id =$report_id");

                        }
                        else{
                            $this->db->query("UPDATE salary_report set cache_pay_odenis = 1  WHERE id =$report_id");
                        }
                        $vade_date_start=$y.'-'.$m.'-01';
                        $vade_date_end=$y.'-'.$m.'-'.$total_ay_sayisi_;
                        $nakit_borc=$this->db->query("SELECT * FROM `salary_credit` WHERE `vade_date` BETWEEN '$vade_date_start' AND '$vade_date_end'  and `personel_id` = $items->personel_id AND `method` = 1 ");


                        $salary_type_kontrol = $this->db->query("SELECT * FROM personel_salary WHERE personel_id=$items->personel_id and status=1")->row()->salary_type;
                        if($salary_type_kontrol == 1 || $salary_type_kontrol ==4 || $items->banka_hakedis==0){
                            $this->db->query("UPDATE salary_report set bank_pay_odenis = 1  WHERE id =$report_id");

                            //banka borc durumu
                            $vade_date_start=$y.'-'.$m.'-01';
                            $vade_date_end=$y.'-'.$m.'-'.$total_ay_sayisi_;
                            $banka_borc=$this->db->query("SELECT * FROM `salary_credit` WHERE `vade_date` BETWEEN '$vade_date_start' AND '$vade_date_end'  and `personel_id` = $items->personel_id AND `method` = 3");
                        }

                    }
                }
                else {
                    $this->db->query("UPDATE salary_report set cache_pay_odenis = 1  WHERE id =$report_id");
                }

            }
            else if ($method == 2) // Banka
            {
                $kontrol_banka = $this->db->query("SELECT * FROM salary_report Where  id =$report_id");
                if($kontrol_banka->row()->bank_pay_odenis==0){
                    $items_ = $this->db->query("SELECT salary_report.* FROM salary_report  Where salary_report.id=$report_id ");
                    if($items_->num_rows()){
                        $items=$items_->row();
                        if($items->banka_hakedis>0)
                        {
                            $data = [
                                'total' => $items->odenilecek_meblaq,
                                'debit' => $items->banka_hakedis,
                                'invoicedate' => $d,
                                'csd' => $items->personel_id,
                                'eid' => $this->aauth->get_user()->id,
                                'invoice_type_id' => 49,
                                'method' => 3,
                                'cari_pers_type' => 2,
                                'invoice_type_desc' => 'Banka Maaş Ödemesi',
                                'payer' => personel_details($items->personel_id),
                                'acid' => $acid,
                                'account' => account_details($acid)->holder,
                                'maas_ay' => $items->hesaplama_ayi,
                                'maas_yil' => $items->hesaplama_yili,
                            ];
                            $this->db->insert('geopos_invoices', $data);
                            $say++;
                            $this->db->query("UPDATE salary_report set bank_pay_odenis=1  WHERE id =$report_id");

                            $salary_type_kontrol = $this->db->query("SELECT * FROM personel_salary WHERE personel_id=$items->personel_id and status=1")->row()->salary_type;
                            $vade_date_start=$y.'-'.$m.'-01';
                            $vade_date_end=$y.'-'.$m.'-'.$total_ay_sayisi_;
                            $banka_borc=$this->db->query("SELECT * FROM `salary_credit` WHERE `vade_date` BETWEEN '$vade_date_start' AND '$vade_date_end'  and `personel_id` = $items->personel_id AND `method` = 3 ");


                        if($salary_type_kontrol == 2 || $salary_type_kontrol==3 || $salary_type_kontrol==9 || $items->nakit_hakedis==0){
                            $this->db->query("UPDATE salary_report set cache_pay_odenis=1  WHERE id =$report_id");

                            //nakit borc durumu
                            $vade_date_start=$y.'-'.$m.'-01';
                            $vade_date_end=$y.'-'.$m.'-'.$total_ay_sayisi_;
                            $nakit_borc=$this->db->query("SELECT * FROM `salary_credit` WHERE `vade_date` BETWEEN '$vade_date_start' AND '$vade_date_end'  and `personel_id` = $items->personel_id  AND `method` = 1 ");


                        }
                    }
                        else {
                            $this->db->query("UPDATE salary_report set bank_pay_odenis=1  WHERE id =$report_id");
                        }


                }

                    }
                else {
                    $this->db->query("UPDATE salary_report set bank_pay_odenis=1  WHERE id =$report_id");
                }

        }


        }


        if($say){
            $proje_id = $kontrol_detils->proje_id;
            $kontrol = $this->db->query("SELECT * FROM `salary_report` Where proje_id = $proje_id and hesaplama_ayi=$m and hesaplama_yili=$y");
            if($kontrol->num_rows()){
                $i=0;
                foreach ($kontrol->result() as $ites){
                    if($ites->bank_pay_odenis == 0 || $ites->cache_pay_odenis == 0){
                        $i++;
                    }
                }
                if($i==0){
                    //projedeki tüm personellerin tüm maaşı odenmiştir.
                    $this->db->query("UPDATE salary_odeme_kontrol set status = 1 WHERE  proje_id = $proje_id and hesaplama_ayi=$m and hesaplama_yili=$y");

                    //projedeki tüm personellerin tüm maaşı odenmiştir.

                }
            }
            echo json_encode(array('status' => 'Success', 'message' =>
                "Başarıyla Ödendi"));
            exit();
        }
        else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Daha Önce Ödeme Yapılmıştır!"));
            exit();
        }
    }


    public function sms_bidirimi($tutar,$pers_id){
        $details = personel_detailsa($pers_id);
        $name = $details['name'];
        $phone = $details['phone'];
        $meesage ='Sayın '.$name.' Sirkete toplam borcunuzdan dolayi bu ay icin geri ödemeniz beklenen tutar '.amountFormat($tutar).' Muhasebe departmanına ödeme yapınız.İyi Calısmalar';
        $tel=str_replace(" ","",$phone);

        $domain="https://sms.atatexnologiya.az/bulksms/api";
        $operation='submit';
        $login='makro2000';
        $password="makro!sms";
        $title='MAKRO2000';
        $bulkmessage=$meesage;
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



    public function update_salary_report(){
        $odenecek_meblaq_banka =  $this->input->post('kalan');
        $kesilecek_tutar = $this->input->post('val');
        $repid = $this->input->post('repid');


        if($this->db->query("UPDATE salary_report set banka_hakedis = $odenecek_meblaq_banka,aylik_kesinti=$kesilecek_tutar  WHERE  id = $repid")){
            $this->aauth->applog("Kesikecek Tutar Güncellendi ",$this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                "Başarıyla Yapıldı"));
        }
        else{
            echo json_encode(array('status' => 'Error', 'message' =>
                "Hata Aldınız"));

        }
    }
    public function update_salary_report_nakit_maas(){
        $odenecek_meblaq_banka =  $this->input->post('kalan');
        $kesilecek_tutar = $this->input->post('val');
        $repid = $this->input->post('repid');


        if($this->db->query("UPDATE salary_report set nakit_hakedis = $odenecek_meblaq_banka,aylik_kesinti_nakit=$kesilecek_tutar  WHERE  id = $repid")){
            $this->aauth->applog("Kesikecek Tutar Güncellendi ",$this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                "Başarıyla Yapıldı"));
        }
        else{
            echo json_encode(array('status' => 'Error', 'message' =>
                "Hata Aldınız"));

        }
    }

    public function update_salary_report_nakit(){
        $kesilecek_tutar = $this->input->post('val');
        $repid = $this->input->post('repid');


        if($this->db->query("UPDATE salary_report set aylik_kesinti=$kesilecek_tutar  WHERE  id = $repid")){
            $this->aauth->applog("Kesikecek Tutar Güncellendi ",$this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>
                "Başarıyla Yapıldı"));
        }
        else{
            echo json_encode(array('status' => 'Error', 'message' =>
                "Hata Aldınız"));

        }
    }
    public function personel_bakiye($id){

        $nakit_borc=0;
        $nakit_bakiye=0;
        $nakit_alacak=0;
        $banka_alacak=0;
        $banka_borc=0;
        $banka_bakiye=0;
        $result = $this->db->query("SELECT geopos_invoices.id,geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoices.id as invoice_id,
                  IF(geopos_invoices.method!='',geopos_invoices.method, 0) as odeme_tipi,
                IF(geopos_invoice_type.transactions='income',geopos_invoices.total,0) as borc,
                IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,0) as alacak,
                geopos_invoices.total,geopos_invoices.kur_degeri,
                geopos_invoice_type.transactions,geopos_invoices.notes  FROM geopos_invoices
                LEFT JOIN geopos_invoice_type on geopos_invoices.invoice_type_id=geopos_invoice_type.id
                Where geopos_invoices.csd=$id  and geopos_invoice_type.id IN (12,13,14,31,49,53,26,15) and geopos_invoices.`invoicedate` > '2020-12-31 23:59:59'
                ORDER BY invoicedate ASC");
        if($result->num_rows()){
            foreach ($result->result() as $ites){
                if($ites->odeme_tipi){
                    if($ites->odeme_tipi==1) // Nakit
                    {
                        $nakit_borc+=$ites->borc;
                        $nakit_alacak+=$ites->alacak;
                    }
                    elseif($ites->odeme_tipi==3){ //banka
                        $banka_borc+=$ites->borc;
                        $banka_alacak+=$ites->alacak;
                    }
                }
                else {

                        if($ites->notes=='Banka Hakediş'){ //banka
                            $banka_borc+=$ites->borc;
                            $banka_alacak+=$ites->alacak;
                        }
                        else {

                                $nakit_borc+=$ites->borc;
                                $nakit_alacak+=$ites->alacak;
                        }
                }
            }


        }

        $nb = floatval($nakit_borc)-floatval($nakit_alacak);
        $bb = floatval($banka_borc)-floatval($banka_alacak);
        // 1 = Borçlu 0 == Alacaklı

        $status_n = $nb > 0 ? 1 : 0;
        $status_b = $bb > 0 ? 1 : 0;

        $n_tutar =round(floatval($nakit_borc)-floatval($nakit_alacak),2);
        $b_tutar =round(floatval($banka_borc)-floatval($banka_alacak),2);
        $data=[
            'nakit_bakiye'=>abs($n_tutar),
            'nakit_bakiye_status'=>$status_n,
            'banka_bakiye'=>abs($b_tutar),
            'banka_bakiye_status'=>$status_b,
        ];

      return $data;
    }

    public function personel_borc_ogren_(){


        $cid=664;
        $nakit_borc=0;
        $nakit_bakiye=0;
        $nakit_alacak=0;
        $banka_alacak=0;
        $banka_borc=0;
        $banka_bakiye=0;

        $result = $this->db->query("SELECT geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoice_type.id as type_id,geopos_invoices.id as invoice_id,
                  IF(geopos_invoices.method!='',geopos_invoices.method, 0) as odeme_tipi,
                IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,0) as alacak,
                IF(geopos_invoice_type.transactions='income',geopos_invoices.total,0) as borc,
                geopos_invoices.total,geopos_invoices.kur_degeri,
                geopos_invoice_type.transactions,geopos_invoices.notes  FROM geopos_invoices
                LEFT JOIN geopos_invoice_type on geopos_invoices.invoice_type_id=geopos_invoice_type.id
                Where geopos_invoices.csd=$cid  and geopos_invoice_type.id IN (52,51,34,63) and geopos_invoices.`invoicedate` > '2021-01-30 23:59:59'
                ORDER BY invoicedate ASC");
        if($result->num_rows()) {
            foreach ($result->result() as $ites) {

                if($ites->odeme_tipi){
                    if($ites->odeme_tipi==1) // Nakit
                    {
                        $nakit_borc+=$ites->borc;
                        $nakit_alacak+=$ites->alacak;
                    }
                    elseif($ites->odeme_tipi==3){ //banka
                        $banka_borc+=$ites->borc;
                        $banka_alacak+=$ites->alacak;
                    }
                }
                else {

                    $banka_borc=0;
                    $banka_alacak=0;
                    $nakit_borc=0;
                    $nakit_alacak=0;
                }


            }
        }

        $nb = floatval($nakit_borc)-floatval($nakit_alacak);
        $bb = floatval($banka_borc)-floatval($banka_alacak);
        // 1 = Borçlu 0 == Alacaklı

        $status_n = $nb > 0 ? 1 : 0;
        $status_b = $bb > 0 ? 1 : 0;

        $n_tutar =round(floatval($nakit_borc)-floatval($nakit_alacak),2);
        $b_tutar =round(floatval($banka_borc)-floatval($banka_alacak),2);
        $data=[
            'nakit_bakiye'=>abs($n_tutar),
            'nakit_bakiye_status'=>$status_n,
            'banka_bakiye'=>abs($b_tutar),
            'banka_bakiye_status'=>$status_b,
        ];

        echo "<pre>";print_r($data) ;
    }

    public function personel_borc_ogren($cid){


        $nakit_borc=0;
        $nakit_bakiye=0;
        $nakit_alacak=0;
        $banka_alacak=0;
        $banka_borc=0;
        $banka_bakiye=0;

        $result = $this->db->query("SELECT geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoice_type.id as type_id,geopos_invoices.id as invoice_id,
                  IF(geopos_invoices.method!='',geopos_invoices.method, 0) as odeme_tipi,
                IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,0) as borc,
                IF(geopos_invoice_type.transactions='income',geopos_invoices.total,0) as alacak,
                geopos_invoices.total,geopos_invoices.kur_degeri,
                geopos_invoice_type.transactions,geopos_invoices.notes  FROM geopos_invoices
                LEFT JOIN geopos_invoice_type on geopos_invoices.invoice_type_id=geopos_invoice_type.id
                Where geopos_invoices.csd=$cid  and geopos_invoice_type.id IN (52,51,34,63) and geopos_invoices.`invoicedate` > '2021-01-30 23:59:59'
                ORDER BY invoicedate ASC");
        if($result->num_rows()) {
            foreach ($result->result() as $ites) {

                if($ites->odeme_tipi){
                    if($ites->odeme_tipi==1) // Nakit
                    {
                        $nakit_borc+=$ites->borc;
                        $nakit_alacak+=$ites->alacak;
                    }
                    elseif($ites->odeme_tipi==3){ //banka
                        $banka_borc+=$ites->borc;
                        $banka_alacak+=$ites->alacak;
                    }
                }
                else {

                    $banka_borc=0;
                    $banka_alacak=0;
                    $nakit_borc=0;
                    $nakit_alacak=0;
                }


            }
        }

        $nb = floatval($nakit_alacak)-floatval($nakit_borc);
        $bb = floatval($banka_alacak)-floatval($nakit_borc);
        // 1 = Borçlu 0 == Alacaklı

        $status_n = $nb > 0 ? 1 : 0;
        $status_b = $bb > 0 ? 1 : 0;

        $n_tutar =round(floatval($nakit_borc)-floatval($nakit_alacak),2);
        $b_tutar =round(floatval($banka_borc)-floatval($banka_alacak),2);
        $data=[
            'nakit_bakiye'=>abs($n_tutar),
            'nakit_bakiye_status'=>$status_n,
            'banka_bakiye'=>abs($b_tutar),
            'banka_bakiye_status'=>$status_b,
        ];

        return $data;
    }


    public function personel_bakiye_report(){

        $id=845;
        $nakit_borc=0;
        $nakit_bakiye=0;
        $nakit_alacak=0;
        $banka_alacak=0;
        $banka_borc=0;
        $banka_bakiye=0;
        $result = $this->db->query("SELECT geopos_invoices.id,geopos_invoice_type.description,geopos_invoices.invoicedate,geopos_invoices.id as invoice_id,
                  IF(geopos_invoices.method!='',geopos_invoices.method, 0) as odeme_tipi,
                IF(geopos_invoice_type.transactions='income',geopos_invoices.total,0) as borc,
                IF(geopos_invoice_type.transactions='expense',geopos_invoices.total,0) as alacak,
                geopos_invoices.total,geopos_invoices.kur_degeri,
                geopos_invoice_type.transactions,geopos_invoices.notes  FROM geopos_invoices
                LEFT JOIN geopos_invoice_type on geopos_invoices.invoice_type_id=geopos_invoice_type.id
                Where geopos_invoices.csd=$id  and geopos_invoice_type.id IN (12,13,14,31,49,53,26,15) and geopos_invoices.`invoicedate` > '2020-12-31 23:59:59'
                ORDER BY invoicedate ASC");
        if($result->num_rows()){
            foreach ($result->result() as $ites){
                if($ites->odeme_tipi){
                    if($ites->odeme_tipi==1) // Nakit
                    {
                        $nakit_borc+=$ites->borc;
                        $nakit_alacak+=$ites->alacak;
                    }
                    elseif($ites->odeme_tipi==3){ //banka
                        $banka_borc+=$ites->borc;
                        $banka_alacak+=$ites->alacak;
                    }
                }
                else {

                        if($ites->notes=='Banka Hakediş'){ //banka
                            $banka_borc+=$ites->borc;
                            $banka_alacak+=$ites->alacak;
                        }
                        else {

                                $nakit_borc+=$ites->borc;
                                $nakit_alacak+=$ites->alacak;
                        }
                }
            }


        }

        $nb = floatval($nakit_borc)-floatval($nakit_alacak);
        $bb = floatval($banka_borc)-floatval($banka_alacak);
        // 1 = Borçlu 0 == Alacaklı

        $status_n = $nb > 0 ? 1 : 0;
        $status_b = $bb > 0 ? 1 : 0;

        $n_tutar =round(floatval($nakit_borc)-floatval($nakit_alacak),2);
        $b_tutar =round(floatval($banka_borc)-floatval($banka_alacak),2);
        $data=[
            'nakit_bakiye'=>abs($n_tutar),
            'nakit_bakiye_status'=>$status_n,
            'banka_bakiye'=>abs($b_tutar),
            'banka_bakiye_status'=>$status_b,
        ];

     echo "<pre>";print_r($data);

    }

    public function update_salary_all(){
        $i=0;

        $toplam_avans=0;
        $toplam_banka_avans=0;
        $total_nakit_avans=0;
        $kesinti_banka=0;
        $kesinti_nakit=0;
        $nakit_geri_odeme=0;
        $nakit_odenecek=0;
        $bankadan_odenecek=0;
        $banka_hakedis=0;
        $yil=0;
        $ay=0;
        $razi_total=0;
        $proje_id=0;

        $this->db->trans_start();
        $details = $this->input->post('details');
        foreach ($details as $items){


            $details_ = $this->db->query("SELECT * FROM salary_report Where id =".$items['id'])->row();
            $yil=$details_->hesaplama_yili;
            $ay=$details_->hesaplama_ayi;
            $salary_type=$details_->salary_type;
            $proje_id=$details_->proje_id;
            $personel_id=$details_->personel_id;


            $borc_total = $this->personel_borc_ogren($personel_id);
            $pers_bakiye=$this->personel_bakiye($personel_id);


            $total_nakit_avans=0;
            $total_banka_avans=0;
            $total_banka_borc=0;
            $total_nakit_borc=0;
            $total_nakit_alacak=0;
            $total_banka_alacak=0;

            if($pers_bakiye['nakit_bakiye_status']==1){
                $total_nakit_avans=$pers_bakiye['nakit_bakiye'];
            }
            if($pers_bakiye['banka_bakiye_status']==1){
                $total_banka_avans=$pers_bakiye['banka_bakiye'];
            }


            if($pers_bakiye['nakit_bakiye_status']==0){
                $total_nakit_alacak=$pers_bakiye['nakit_bakiye'];
            }
            if($pers_bakiye['banka_bakiye_status']==0){
                $total_banka_alacak=$pers_bakiye['banka_bakiye'];
            }

            if($borc_total['nakit_bakiye_status']==0){
                $total_nakit_borc=$borc_total['nakit_bakiye'];
            }
            if($borc_total['banka_bakiye_status']==1){
                $total_banka_borc=$borc_total['banka_bakiye'];
            }

            $toplam_borc = $total_banka_borc+$total_nakit_borc+$total_banka_avans+$total_nakit_avans;

            $bankadan_odenecek = floatval($details_->banka_hakedis)-floatval($items['kesinti_banka']);
            $nakit_odenilcek = floatval($details_->nakit_hakedis)-floatval($items['kesinti_nakit']);

            $data_items=[
                'toplam_avans'=>$toplam_borc,
                'banka_avans'=>floatval($total_banka_borc)+floatval($total_banka_avans),
                'nakit_avans'=>floatval($total_nakit_borc)+floatval($total_nakit_avans),
                'aylik_kesinti'=>$items['kesinti_banka'],
                'aylik_kesinti_nakit'=>$items['kesinti_nakit'],
                'nakit_geri_odenen'=>$items['nakit_geri_odeme'],
                'nakit_odenilecek'=>$nakit_odenilcek,
                'odenilecek_meblaq'=>$bankadan_odenecek
            ];
            $this->db->set($data_items);
            $this->db->where('id', $items['id']);
            if($this->db->update('salary_report', $data_items)){
                $toplam_avans+=$toplam_borc;
                $toplam_banka_avans+=floatval($total_banka_borc)+floatval($total_banka_avans);
                $total_nakit_avans+=floatval($total_nakit_borc)+floatval($total_nakit_avans);
                $kesinti_banka+=$items['kesinti_banka'];
                $kesinti_nakit+=$items['kesinti_nakit'];
                $nakit_geri_odeme+=$items['nakit_geri_odeme'];
                $nakit_odenecek+=$nakit_odenilcek;
                $bankadan_odenecek+=$bankadan_odenecek;
                $banka_hakedis+=$details_->banka_hakedis;
                $this->aauth->applog("Bordro Güncellendi  ".$items['id']." ID ",$this->aauth->get_user()->username);
                $i++;
            }

        }
        if($i > 0){

            $this->db->delete('salary_total_report', array('hesaplama_yili' => $yil,'hesaplama_ayi'=>$ay,'proje_id'=>$proje_id));
            $data_items_total=[
                'toplam_avans'=>$toplam_avans,
                'proje_id'=>$proje_id,
                'banka_avans'=>$toplam_banka_avans,
                'nakit_avans'=>$total_nakit_avans,
                'aylik_kesinti'=>$kesinti_banka,
                'aylik_kesinti_nakit'=>$kesinti_nakit,
                'nakit_geri_odenen'=>$nakit_geri_odeme,
                'nakit_odenilecek'=>$nakit_odenecek,
                'odenilecek_meblaq'=>$bankadan_odenecek,
                'banka_hakedis'=>$banka_hakedis,
                'hesaplama_yili'=>$yil,
                'hesaplama_ayi'=>$ay,
                'razi_total'=>$razi_total,
            ];
            $this->db->insert('salary_total_report', $data_items_total);
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success', 'message' =>
                "Başarıyla Yapıldı"));
        }
        else{
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>
                "Hata Aldınız"));

        }
    }
    public function create_nakit_kasa(){
        $this->db->trans_start();
        $details = $this->input->post('rep_id');
        $account_id = $this->input->post('account_id');
        $data=[];
        $productlist=[];
        $prodindex=0;
        $not=0;
        $personel_name='';
        $toplam_tutar=0;
        $date = new DateTime('now');
        $m= $date->format('m');
        $y= $date->format('Y');
        $account_name = account_details($account_id)->holder;
        foreach ($details as $rep_id) {
            $salary_details =$this->db->query("Select * From salary_report Where id = $rep_id")->row();
            if($salary_details->nakit_aktarma_durumu==0){
                if($salary_details->nakit_geri_odenen>0){
                    $data=[
                        'total'=>$salary_details->nakit_geri_odenen,
                        'notes'=>'Borca İstinaden Geri Ödeme',
                        'csd'=>$salary_details->personel_id,
                        'eid'=>$this->aauth->get_user()->id,
                        'invoice_type_id'=>51,
                        'invoice_type_desc'=>'Personel Borç Ödeme',
                        'payer'=>personel_details($salary_details->personel_id),
                        'acid'=>$account_id,
                        'account'=>account_details($account_id)->holder,
                        'method'=>1,
                        'proje_id'=>35,
                        'bolum_id'=>59,
                        'cari_pers_type'=>2,
                        'maas_ay'=>$salary_details->hesaplama_ayi,
                        'maas_yil'=>$salary_details->hesaplama_yili,
                    ];

                    $productlist[$prodindex] = $data;
                    $prodindex++;
                    $toplam_tutar+=floatval($salary_details->nakit_geri_odenen);

                    $this->db->query("UPDATE salary_report set nakit_aktarma_durumu = 1  WHERE  id = $salary_details->id");
                }

            }
            else {
                $not++;
                $personel_name.='</br>'.personel_details($salary_details->personel_id);
            }


        }
        $not_message='';
        if($not){
            $not_message=$not.' Adet Personelin Daha Önceden Aktarımı Sağlandı'.'.Nakitleri Aktarılan Pesonel İsimleri : '.$personel_name;
        }
        if ($prodindex > 0) {
            $this->db->insert_batch('geopos_invoices', $productlist);
            $this->aauth->applog(floatval($prodindex)." Adet ".$m." . Aya Ait Nakit Geri Ödenecekler ".$account_name." Kasasına ".amountFormat($toplam_tutar)." Aktarıldı ",$this->aauth->get_user()->username);
            $this->db->trans_complete();

            echo json_encode(array('status' => 'Success', 'message' =>
                "Başarıyla Giriş Yapıldı".$not_message));
        }
        else{
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>
                "İşlem Durduruldu. ".$not_message));

        }
    }

    public function create_razi_kasa(){

        $this->db->trans_start();
        $details = $this->input->post('details');
        $account_id = $this->input->post('account_id');
        $hesap_ay = $this->input->post('hesap_ay');
        $hesap_yil = $this->input->post('hesap_yil');
        $data=[];
        $productlist=[];
        $productlist_=[];
        $prodindex=0;
        $prodindex_=0;
        $not=0;
        $personel_name='';
        $toplam_tutar=0;
        $date = new DateTime('now');
        $m= $date->format('m');
        $y= $date->format('Y');
        $account_name = account_details($account_id)->holder;
        foreach ($details as $items) {
            $rep_id =$items['rep_id'];
            $value =$items['value'];
            $salary_details =$this->db->query("Select * From salary_report Where id = $rep_id and hesaplama_ayi = $hesap_ay and hesaplama_yili = $hesap_yil")->row();
            if($salary_details->razi_aktarma_durumu==0){
                    $data=[
                        'total'=>$value,
                        'notes'=>'Razı Geri Ödeme',
                        'csd'=>$salary_details->personel_id,
                        'eid'=>$this->aauth->get_user()->id,
                        'invoice_type_id'=>50,
                        'invoice_type_desc'=>'Personel Razı',
                        'payer'=>personel_details($salary_details->personel_id),
                        'acid'=>$account_id,
                        'account'=>account_details($account_id)->holder,
                        'method'=>1,
                        'proje_id'=>35,
                        'bolum_id'=>59,
                        'cari_pers_type'=>2,
                        'maas_ay'=>$salary_details->hesaplama_ayi,
                        'maas_yil'=>$salary_details->hesaplama_yili,
                    ];

                    $productlist[$prodindex] = $data;
                    $prodindex++;
                    $toplam_tutar+=floatval($salary_details->nakit_geri_odenen);
                    $this->db->query("UPDATE salary_report set razi_aktarma_durumu = 1  WHERE  id = $salary_details->id");


                    // PErsonel Ekstresi İçin
                        $dataekstre=[
                            'total'=>$salary_details->odenilecek_meblaq,
                            'notes'=>'Razı Geri Ödeme',
                            'csd'=>$salary_details->personel_id,
                            'eid'=>$this->aauth->get_user()->id,
                            'invoice_type_id'=>66,
                            'invoice_type_desc'=>'Personel Razı Ödemesi',
                            'payer'=>personel_details($salary_details->personel_id),
                            'acid'=>$account_id,
                            'account'=>account_details($account_id)->holder,
                            'method'=>1,
                            'proje_id'=>35,
                            'bolum_id'=>59,
                            'cari_pers_type'=>2,
                            'maas_ay'=>$salary_details->hesaplama_ayi,
                            'maas_yil'=>$salary_details->hesaplama_yili,
                        ];

                        $productlist_[$prodindex_] = $dataekstre;
                        $prodindex_++;
                    // PErsonel Ekstresi İçin
            }
            else {
                $not++;
                $personel_name.='</br>'.personel_details($salary_details->personel_id);
            }


        }
        $not_message='';
        if($not){
            $not_message=$not.' Adet Personelin Daha Önceden Aktarımı Sağlandı'.'.Aktarılan Pesonel İsimleri : '.$personel_name;
        }
        if ($prodindex > 0) {
            $this->db->insert_batch('geopos_invoices', $productlist);
            $this->db->insert_batch('geopos_invoices', $productlist_);
            $this->aauth->applog(floatval($prodindex)." Adet ".$m." . Aya Ait Nakit Geri Ödenecekler ".$account_name." Kasasına ".amountFormat($toplam_tutar)." Aktarıldı ",$this->aauth->get_user()->username);
            $this->db->trans_complete();

            echo json_encode(array('status' => 'Success', 'message' =>
                "Başarıyla Giriş Yapıldı".$not_message));
        }
        else{
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>
                "İşlem Durduruldu. ".$not_message));

        }
    }

    public function cost_control(){
        $id =  $this->input->post('id');
        $type =  $this->input->post('type');
        $cost = $this->db->query("Select * From geopos_controller  Where type_id = $type and islem_id=$id");
        if($cost->num_rows()){
            $pers_name = personel_details($cost->row()->cont_pers_id);
            if($this->aauth->get_user()->id==$cost->row()->cont_pers_id){
                echo json_encode(array('status' => 200,'status_id'=>5,'cont_id'=>$cost->row()->id));
            }
            else {
                if($cost->row()->cont_status==1) // Bekliyor
                {

                    echo json_encode(array('status' => 410,'status_id'=>1,'cont_id'=>$cost->row()->id, 'message' =>"Bu Əməliyyat Nəzarət İş Siyahısındadır.Nəzarət Heyəti : ".$pers_name));
                }
                elseif($cost->row()->cont_status==2) // incelemede
                {
                    echo json_encode(array('status' => 410,'status_id'=>2,'cont_id'=>$cost->row()->id, 'message' =>"Bu Əməliyyat Nəzarət Təftişindədir.Nəzarət Heyəti : ".$pers_name));
                }
                elseif($cost->row()->cont_status==3) // Onaylandı
                {
                    echo json_encode(array('status' => 200,'status_id'=>3,'cont_id'=>$cost->row()->id));
                }
                elseif($cost->row()->cont_status==4) // İptal Edildi
                {
                    $personel_name = personel_details($cost->row()->cont_pers_id);
                    $description = $cost->row()->aciklama;
                    echo json_encode(array('status' => 410,'status_id'=>4,'cont_id'=>$cost->row()->id, 'message' =>"Bu Əməliyyat Nəzarət Heyəti tərəfindən ləğv edilib.Nəzarət Heyəti : ".$personel_name.' Açıklama : '.$description));
                }
                elseif($cost->row()->cont_status==5) // Kapatıldı
                {
                    echo json_encode(array('status' => 200,'status_id'=>5,'cont_id'=>$cost->row()->id));
                }
                elseif($cost->row()->cont_status==6) // Düzeliş
                {
                    if($cost->row()->view==0){
                        $personel_name = personel_details($cost->row()->cont_pers_id);
                        $description = $cost->row()->aciklama;
                        echo json_encode(array('status' => 410,'status_id'=>6,'cont_id'=>$cost->row()->id, 'message' =>"Bu Əməliyyat Nəzarət Heyəti tərəfindən Düzəltmə Tələb Edildi.Nəzarət Heyəti : ".$personel_name.' Açıklama : '.$description));

                    }
                }
            }

        }
    }

    public function cost_control_update_new(){
        $this->db->trans_start();
        $status =  $this->input->post('status');
        $id =  $this->input->post('id');
        $type =  $this->input->post('type');
        $cont_id =  $this->input->post('cont_id');
        if($status==1){ // Düzeliş edilmesi için mtden geldi
            $view =  $this->input->post('view');

            if( kont_history($cont_id,'Talep Düzeliş edilmek üzere kapatıldı.Bildirim Başlatığında Tekrar İnceleme Olacaktır.',5)){
                $this->db->query("UPDATE geopos_controller set cont_status=5, view=$view WHERE  id = $cont_id");
                $this->db->delete('talep_onay_new', array('talep_id' => $id,'type'=>1));
                $this->db->query("UPDATE talep_form set bildirim_durumu=0 WHERE  id = $id");
                $this->db->trans_complete();
                echo json_encode(array('status' => 200, 'message' =>
                    "Başarıyla Düzenleme Moduna Alındı"));
            }
            else {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>
                    "History Oluşamadı"));
            }
        }
    }

    public function cost_status_change(){
        $this->db->trans_start();
        $cont_id =  $this->input->post('cont_id');
        $status_id =  $this->input->post('status_id');
        $desc =  $this->input->post('desc');

        $upd='';
        if($status_id==4 || $status_id==5 ||  $status_id==6 ){
          $upd=", aciklama='$desc'";
        }

        if($this->db->query("UPDATE geopos_controller set cont_status=$status_id $upd WHERE  id = $cont_id")){
            //History Kayıt
            if(kont_history($cont_id,$desc,$status_id)){
                $this->db->trans_complete();

                echo json_encode(array('status' => 200, 'message' =>
                    "Başarıyla Giriş Yapıldı"));

            }
            else{
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>
                    "History Oluşamadı"));

            }
            //History Kayıt
        }
        else{
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>
                "Hata Aldınız Yöndeticiye Başvurun"));

        }

    }


}
