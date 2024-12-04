<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 4.02.2020
 * Time: 12:58
 */
?>
<?php
class Raporlar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('controller_model', 'cont');
        $this->load->library("Aauth");
        $this->load->library("Custom");
        $this->load->model('employee_model', 'employee');
        $this->load->model('raporlar_model', 'raporlar');
        $this->load->model('communication_model');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $this->limited = '';


    }

    public function bordro_edit_count(){

        $result = $this->raporlar->bordro_edit_count();
        if($result['status']){
            json_encode(array('status' => 'Success','count'=>$result['count']));
        }
        else {
            json_encode(array('status' => 'Error','count'=>0));
        }

    }

    public function edit_salary_report()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Bordro Düzenlemesi Olan Personeller';
        $this->load->view('fixed/header', $head);
        $this->load->view('raporlar/edit_salary_report');
        $this->load->view('fixed/footer');
    }
    public function razi_report()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Razı Personel Raporu';
        $this->load->view('fixed/header', $head);
        $this->load->view('raporlar/razi_report');
        $this->load->view('fixed/footer');
    }
    public function avans_report()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Personel Avans Raporu';
        $this->load->view('fixed/header', $head);
        $this->load->view('raporlar/avans_report');
        $this->load->view('fixed/footer');
    }


    public function ajax_razi_report(){

        $ay = $this->input->post('ay');
        $yil=$this->input->post('yil');
        $list=$this->raporlar->ajax_razi_report($ay,$yil);

        $data = array();
        $no = $this->input->post('start');


        foreach ($list as $invoices) {
            $odenecek_meblaq=0;
            $odenen_meblaq=0;
            $kasa=0;
            if($invoices->bank_pay_odenis==1){
                $odenecek_meblaq=$invoices->odenilecek_meblaq;
            }

            if($invoices->razi_aktarma_durumu==1){
                $total = $this->db->query("SELECT * From geopos_invoices Where invoice_type_id = 50 and csd=$invoices->personel_id and maas_ay=$invoices->hesaplama_ayi and maas_yil=$invoices->hesaplama_yili");
                if($total->num_rows()){
                    $odenen_meblaq=$total->row()->total;
                    $kasa=$total->row()->account;
                }
                else {
                    $odenen_meblaq=0;
                }

            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->name;
            $row[] = month_name($invoices->hesaplama_ayi).' '.$invoices->hesaplama_yili;
            $row[] = amountFormat($odenecek_meblaq);
            $row[] = amountFormat($odenen_meblaq);
            $row[] = $kasa;
            $data[] = $row;



        }


        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->raporlar->ajax_razi_report_count($ay,$yil),
            "recordsFiltered" => $this->raporlar->ajax_razi_report_filter($ay,$yil),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function ajax_avans_report(){

        $ay = $this->input->post('ay');
        $yil=$this->input->post('yil');
        $list=$this->raporlar->ajax_avans_report($ay,$yil);

        $data = array();
        $no = $this->input->post('start');


        foreach ($list as $invoices) {
            $odenen_meblaq=0;
            $kasa='';
            if($invoices->nakit_aktarma_durumu==1){
                $total = $this->db->query("SELECT * From geopos_invoices Where invoice_type_id = 51 and csd=$invoices->personel_id and maas_ay=$invoices->hesaplama_ayi and maas_yil=$invoices->hesaplama_yili");
                if($total->num_rows()){
                    $odenen_meblaq=$total->row()->total;
                    $kasa=$total->row()->account;
                }
                else {
                    $odenen_meblaq=0;
                }

            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->name;
            $row[] = month_name($invoices->hesaplama_ayi).' '.$invoices->hesaplama_yili;
            $row[] = amountFormat($invoices->toplam_avans);
            $row[] = amountFormat($invoices->banka_avans);
            $row[] = amountFormat($invoices->nakit_avans);
            $row[] = amountFormat($invoices->aylik_kesinti);
            $row[] = amountFormat($invoices->aylik_kesinti_nakit);
            $row[] = amountFormat($invoices->nakit_geri_odenen);
            $row[] = amountFormat($odenen_meblaq);
            $row[] = $kasa;
            $row[] = $invoices->id;
            $data[] = $row;



        }


        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->raporlar->ajax_avans_report_count($ay,$yil),
            "recordsFiltered" => $this->raporlar->ajax_avans_report_filter($ay,$yil),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function ajax_edit_report(){

        $list=$this->raporlar->ajax_edit_report();

        $data = array();
        $no = $this->input->post('start');


        foreach ($list as $invoices) {

            $check ="<input type='checkbox' edit_id='$invoices->id' class='form-control one_select'  style='width: 30px;' >";;
            $islem='<button class="btn btn-info view" edit_id="'.$invoices->id.'"><i class="fa fa-eye"></i></button>';
            $no++;
            $row = array();
            $row[] = $check;
            $row[] = $invoices->name;
            $row[] = month_name($invoices->hesaplama_ayi).' '.$invoices->hesaplama_yili;
            $row[] = personel_details($invoices->aauth_id);
            $row[] = $invoices->created_at;
            $row[] = $islem;
            $row[] = $invoices->id;
            $data[] = $row;



        }


        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->raporlar->ajax_edit_report_count(),
            "recordsFiltered" => $this->raporlar->ajax_edit_report_filter(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit_details_info(){
        $edit_id = $this->input->post("edit_id");
        $rep_id = $this->db->query("SELECT * FROM salary_edit_table Where id=$edit_id")->row()->rep_id;
        $old_data=[];
        $new_data=[];

        $list = $this->db->query('SELECT salary_report.*,geopos_employees.name as pers_name FROM `salary_report` INNER JOIN geopos_employees ON salary_report.personel_id = geopos_employees.id WHERE salary_report.id='.$rep_id);
        if($list->num_rows()){
            $old_data[]=[
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

        $list_edit = $this->db->query('SELECT * From salary_edit_table WHERE id='.$edit_id);
        if($list_edit->num_rows()){
            $new_data[]=[
                'rep_id'=>$list_edit->row()->rep_id,
                'toplam_avans'=>$list_edit->row()->toplam_avans,
                'banka_avans'=>$list_edit->row()->banka_avans,
                'nakit_avans'=>$list_edit->row()->nakit_avans,
                'aylik_kesinti'=>$list_edit->row()->aylik_kesinti,
                'aylik_kesinti_nakit'=>$list_edit->row()->aylik_kesinti_nakit,
                'nakit_geri_odenen'=>$list_edit->row()->nakit_geri_odenen,
                'odenilecek_meblaq'=>$list_edit->row()->odenilecek_meblaq,
                'banka_hakedis'=>$list_edit->row()->banka_hakedis,
                'nakit_odenilecek'=>$list_edit->row()->nakit_odenilecek,
                'nakit_hakedis'=>$list_edit->row()->nakit_hakedis,
            ];
        }

        echo json_encode(array('status' => 'Success','old_data'=>$old_data,'new_data'=>$new_data));
    }

    public function edit_details_update(){
        $i=0;
        $this->db->trans_start();
        $details = $this->input->post("details");
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
                'aauth_id '=>$this->aauth->get_user()->id,
            ];
            $this->db->set($data);
            $this->db->where('id', $items['edit_id']);
            $this->db->update('salary_edit_table', $data);
            $i++;
            $this->aauth->applog(floatval($items['edit_id'])." Edit ID.  Genel Müdür Tarafından Edit Tablosuna Güncelleme Yapıldı",$this->aauth->get_user()->username);

        }
        if($i){
            $this->db->trans_complete();

            echo json_encode(array('status' => 'Success', 'message' =>
                "Başarıyla Güncellendi"));

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>
                "Hata Aldınız"));
        }
    }

    public function edit_table_status(){
        $this->db->trans_start();
        $i=0;
        $status = $this->input->post("status");
        $desc = $this->input->post("desc");
        $edit_table_id = $this->input->post("edit_table_id");
        foreach ($edit_table_id as $items)
        {
            $data=['status'=>$status,'desc'=>$desc];
            $this->db->set($data);
            $this->db->where('id', $items);
            $this->db->update('salary_edit_table', $data);
            $edit_table_details = $this->db->query("SELECT * FROM salary_edit_table Where id=$items")->row();
            $data_update=
                [
                    'nakit_hakedis'=>$edit_table_details->nakit_hakedis,
                    'nakit_odenilecek'=>$edit_table_details->nakit_odenilecek,
                    'banka_hakedis'=>$edit_table_details->banka_hakedis,
                    'odenilecek_meblaq'=>$edit_table_details->odenilecek_meblaq,
                    'nakit_geri_odenen'=>$edit_table_details->nakit_geri_odenen,
                    'aylik_kesinti_nakit'=>$edit_table_details->aylik_kesinti_nakit,
                    'aylik_kesinti'=>$edit_table_details->aylik_kesinti,
                    'nakit_avans'=>$edit_table_details->nakit_avans,
                    'banka_avans'=>$edit_table_details->banka_avans ,
                    'toplam_avans'=>$edit_table_details->toplam_avans
                ];
            $this->db->set($data_update);
            $this->db->where('id', $edit_table_details->rep_id);
            $this->db->update('salary_report', $data_update);
            $i++;
            $this->aauth->applog(floatval($items)." Edit ID.  Genel Müdür Tarafından Güncelleme Yapıldı.Durum:".$status,$this->aauth->get_user()->username);
        }
        if(count($edit_table_id)==$i){
            $this->db->trans_complete();
            echo json_encode(array('status' => 'Success', 'message' =>
                "Başarıyla Güncellendi"));
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>
                "Hata Aldınız"));
        }
    }

    public function kdv_bekleyen_faturalar()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'KDV Ödenememiş Faturalar';
        $this->load->view('fixed/header', $head);
        $this->load->view('raporlar/kdv_bekleyen_faturalar');
        $this->load->view('fixed/footer');
    }
    public function ajax_kdv_bekleyen_faturalar()
    {
        $list = $this->raporlar->ajax_kdv_bekleyen_faturalar();
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $invoices) {

            $proje_name=proje_name($invoices->proje_id);
            $notes='Proje Adı : '.$proje_name.' &#013;Not : '.$invoices->notes;
            $tool="data-toggle='tooltip' data-placement='top' data-html='true' title='$notes'";
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' class='form-control invoice_ids' name='invoice_ids[]' value='$invoices->id'>";
            $row[] = dateformat($invoices->invoicedate);
            $row[] = invoice_type_id($invoices->invoice_type_id);
            $row[] =  "<a href='/invoices/view?id=$invoices->id' >"."<span data-toggle='tooltip' data-placement='top' data-html='true' title='".$notes."'>".$invoices->invoice_no."</span></a>";
            $row[] = "<a href='/projects/explore?id=$invoices->proje_id' >".proje_code($invoices->proje_id)."</a>";
            $row[] = "<a href='/customers/view?id=$invoices->csd' >".$invoices->name."</a>";
            $row[] = $invoices->notes;
            $row[] = amountFormat($invoices->subtotal,$invoices->para_birimi);
            $row[] = amountFormat($invoices->tax,$invoices->para_birimi);
            $row[] = amountFormat($invoices->total,$invoices->para_birimi);
            $row[] = '<span class="st-' . $invoices->status . '">' . invoice_status_ogren($invoices->status) . '</span>';
            $row[] = customer_details($invoices->alt_cari_id)['company'];
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->id") . '" class="btn btn-success btn-sm" title="View"><i class="fa fa-eye"></i></a>
                    &nbsp;<a href="' . base_url("invoices/printinvoice?id=$invoices->id") . '&d=1" class="btn btn-info btn-sm"  title="Download"><span class="fa fa-download"></span></a>
                    <a target="_blank"  href="' . base_url("/employee/view?id=$invoices->eid") .'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" data-html="true" title="'.personel_details($invoices->eid).'"><i class="fa fa-user"></i></a>
                    <button class="btn btn-danger btn-sm cancel" invoice_id="'.$invoices->id.'" title="Iptal Et"><i class="fa fa-ban"></i></button>
                    
                    ';


            $data[] = $row;



        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->raporlar->kdv_bekleyen_count($this->limited),

            "recordsFiltered" => $this->raporlar->kdv_bekleyen_filter($this->limited),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);
    }
}
