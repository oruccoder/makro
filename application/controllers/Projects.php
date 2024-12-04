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


class Projects Extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->library("Aauth");

        $this->load->model('projects_model', 'projects');
        $this->load->model('projebolumleri_model', 'bolum');
        $this->load->model('projeiskalemleri_model', 'iskalemleri');

        $this->load->model('tools_model', 'tools');



        if (!$this->aauth->is_loggedin()) {

            redirect('/user/', 'refresh');

        }





    }



    //todo section


    public function is_kalemleri()
    {

        $proje_id= $this->input->get('id');
        $detay= $this->input->get('detay');
        $detay=isset($detay)?$detay:0;



        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'İş Kalemleri';

        $data['totalt'] = $this->projects->project_count_all();
        $data['proje_id'] = $proje_id;
        $data['detay'] = $detay;

        $data['bolumler']=$this->db->query("SELECT * FROM geopos_project_bolum WHERE pid=$proje_id")->result();



        $this->load->view('fixed/header', $head);

        $this->load->view('projects/is_kalemleri', $data);

        $this->load->view('fixed/footer');
    }

    public function asamalar_list()
    {
        $bolum_id=$this->input->post('bolum_id');
        $proje_id=$this->input->post('proje_id');
        $invoice_list=$this->db->query("SELECT * FROM geopos_milestones WHERE pid=$proje_id and bolum_id=$bolum_id")->result();
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

    public function bolumler_list_ajax()
    {
        $proje_id=$this->input->post('proje_id');
        $invoice_list =  $this->projects->bolumler_list($proje_id);


        echo json_encode($invoice_list);
    }



    public function is_kalemi_guncelle()
    {
        if($this->input->post())
        {
            $ids=$this->input->post('todo_id');

            $productlist = array();
            $prodindex = 0;

            foreach ($ids as $key=>$todo_id)
            {
                $todo_id = $this->input->post('todo_id')[$key];
                $gorulmus_is_qty = $this->input->post('gorulmus_is_qty')[$key];
                $old_gorulmus_is_qty = $this->input->post('old_gorulmus_is_qty')[$key];
                $tutar_2 = $this->input->post('tutar_2_inp')[$key];
                $old_tutar_2 = $this->input->post('old_tutar_2')[$key];
                $is_kalemi_status = $this->input->post('is_kalemi_status')[$key];

                if($gorulmus_is_qty>0)
                {
                    $data=array(
                        'id'=>$todo_id,
                        'is_kalemi_durumu'=>$is_kalemi_status,
                        'gorulmus_is_qty'=>$gorulmus_is_qty+$old_gorulmus_is_qty,
                        'total_2'=>$tutar_2+$old_tutar_2,
                        'son_gorulmus_is'=>$gorulmus_is_qty,
                    );
                    $productlist[$prodindex] = $data;

                    $prodindex++;
                }

            }

            if ($prodindex > 0) {

                $this->db->update_batch('geopos_todolist', $productlist,'id');


                foreach ($productlist as $productlists)
                {
                    $id=$productlists['id'];
                    $kullanici= $this->aauth->get_user()->username;
                    $durum_id=$productlists['is_kalemi_durumu'];
                    $is_kalem_adi=$this->db->query("SELECT * FROM geopos_todolist where id=$id")->row()->name;
                    $proje_id=$this->db->query("SELECT * FROM geopos_todolist where id=$id")->row()->proje_id;
                    $is_kalem_id=$productlists['id'];
                    $durum=$this->db->query("SELECT * FROM geopos_is_kalemleri_status where id=$durum_id")->row()->name;
                    $gorulmus_is_qtyy=$productlists['gorulmus_is_qty'];
                    $metin="İş Kalemi Adı :$is_kalem_adi | Yeni Miktar : $gorulmus_is_qtyy | Yeni Durum : $durum | $kullanici ";
                    $this->projects->add_activity($metin, $proje_id,$is_kalem_id,$productlists['son_gorulmus_is']);
                }

                echo json_encode(array('status' => 'Success', 'message' =>

                    "Başarıyla güncellendi."));




            } else {

                echo json_encode(array('status' => 'Error', 'message' =>

                    "Lütfen ürün listesinden ürün seçin. Ürünleri eklemediyseniz, Ürün yöneticisi bölümüne gidin."));



            }
        }
    }

    public function ajax_list_is_kalemleri()
    {
        $detay = $this->input->post('detay');
        $pid = $this->input->post('pid');

        $list = $this->projects->task_datatables($pid);

        $data = array();

        $no = $this->input->post('start');

        $sim='';




        if($detay==1)
        {
            foreach ($list as $task) {

                $kalan=$task->quantity-$task->gorulmus_is_qty;

                if($task->simeta_status==1)
                {
                    $sim="İş Listesinde Var";
                }
                else
                {
                    $sim="İş Listesinde Yok";
                }

                $no++;

                $style='';
                $old_tutar2=$task->total_2;
                $old_gorulmus_is_qty=$task->gorulmus_is_qty;


                if($old_gorulmus_is_qty > $task->quantity)
                {
                    $style="background-color: red;color: white;";
                }

                if($old_gorulmus_is_qty == $task->quantity)
                {
                    $style="background-color: #0c6b98;color: white;";
                }
                if($old_gorulmus_is_qty < $task->quantity)
                {
                    $style="background-color: #4b5453;color: white;";
                }
                $row = array();
                $metin='';
                $i=0;
                $logs=$this->db->query("SELECT * FROM `geopos_project_meta` WHERE key3=$task->id  ORDER BY `geopos_project_meta`.`id` DESC")->result();
                foreach ($logs as $log)
                {
                    $i++;
                    $metin.=$i.'-) '.$log->value.'&#013;';
                }
                $row[] = "<input type='checkbox' class='form-control' value='$task->id' name='todolist_id[]'>";
                $row[] =   $task->bolum_adi;
                $row[] =   task_to_asama($task->parent_id);
                $row[] =   $task->asama_adi;
                $row[] = "<span data-toggle='tooltip' data-placement='top' data-html='true' title='".$metin."'>".$task->name."</span>";
                $row[] = $task->quantity;
                $row[] = units_($task->unit)['name'];
                $row[] = $kalan;
                $row[] = amountFormat($task->fiyat);
                $row[] = $task->oran;
                $row[] = amountFormat($task->toplam_fiyat);
                $row[]=$old_gorulmus_is_qty;
                $row[]=$this->gorulmus_isler_detay($task->id,1,$task->unit);
                $row[]=amountFormat($old_tutar2);
                $row[] = is_kalemleri_status_id($task->is_kalemi_durumu)['name'];
                $row[] = $sim;

                $row[]=$style;

                $data[] = $row;

            }
        }
        else
        {
            foreach ($list as $task) {

                if($task->simeta_status==1)
                {
                    $sim="İş Listesinde Var";
                }
                else
                {
                    $sim="İş Listesinde Yok";
                }

                $no++;


                $html="<select class='form-control is_kalemi_status' name='is_kalemi_status[]'><option value='0'>Seçiniz</option>";
                foreach (is_kalemleri_status() as $sta)
                {
                    if($task->is_kalemi_durumu==$sta->id)
                    {
                        $html.="<option selected value='$sta->id'>$sta->name</option>";
                    }
                    else
                    {
                        $html.="<option value='$sta->id'>$sta->name</option>";
                    }

                }
                $html.="</select>";
                $id=$task->id;
                $old_tutar2=$task->total_2;
                $old_gorulmus_is_qty=$task->gorulmus_is_qty;
                $row = array();

                $kalan=$task->quantity-$task->gorulmus_is_qty;
                $row[] = $no;
                $row[] =   $task->bolum_adi;
                $row[] =   task_to_asama($task->parent_id);
                $row[] =   $task->asama_adi;
                $row[] =$task->name;
                $row[] =  $task->quantity;
                $row[] = units_($task->unit)['name'];
                $row[] = $kalan;
                $row[] = "<input type='hidden' class='fiyat' name='fiyat[]' value='$task->fiyat'>".amountFormat($task->fiyat);
                $row[] = $task->oran."<input type='hidden' class='oran' name='oran[]' value='$task->oran'>";
                $row[] = amountFormat($task->toplam_fiyat);
                $row[]="<input type='hidden' name='todo_id[]' value='$id'><input type='hidden' name='old_gorulmus_is_qty[]' value='$old_gorulmus_is_qty'><input name='gorulmus_is_qty[]' value='0' class='gorulmus_is_qty form-control'>";
                $row[]=$this->gorulmus_isler_detay($task->id,2,$task->unit);
                $row[]="<input type='hidden' name='tutar_2_inp[]' class='tutar_2_inp' value='0'><input type='hidden' name='old_tutar_2[]' value='$old_tutar2'><input name='tutar_2[]' value='0' disabled class='tutar_2 form-control'>";

                $row[] = is_kalemleri_status_id($task->is_kalemi_durumu)['name'];
                $row[] = $sim;
                $row[] = $html;



                $row[] = '<a class="btn-info btn-sm" href="' . base_url('projects') . '/edittask?id=' . $task->id . '" data-object-id="' . $task->id . '"> <i class="icon-pencil"></i> </a>&nbsp;<a class="btn-success btn-sm delete-custom" data-did="3" href="#"  data-object-id="' . $task->id . '"> <i class="icon-trash"></i> </a>';



                $row[]='';

                $data[] = $row;

            }
        }





        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->iskalemleri->task_count_all($pid),

            "recordsFiltered" => $this->iskalemleri->task_count_filtered($pid),

            "data" => $data,

        );

        echo json_encode($output);
    }

    public function index()

    {
        if (!$this->aauth->premission(4)->read) {
            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');
        }

        $data['project_status'] = $this->projects->project_status();

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'Proje Listesi';

        $data['totalt'] = $this->projects->project_count_all();



        $this->load->view('fixed/header', $head);

        $this->load->view('projects/index', $data);

        $this->load->view('fixed/footer');



    }

    private function gorulmus_isler_detay($id,$durum,$birim)
    {
        $sql=$this->db->query("SELECT * FROM geopos_project_meta WHERE key3=$id ORDER BY `geopos_project_meta`.`id` ASC");
        $html='';
        if($durum==1)
        {
            if($sql->num_rows()>0)
            {
                $html='<select class="form_control" multiple name="'.$id.'[]">';
                $i=0;
                foreach ($sql->result() as $rows)
                {
                    $i++;
                    $unit=units_($birim)['code'];
                    $date=dateformat($rows->c_date);
                    $total=round($rows->total,2);
                    $html.="<option value='$rows->id'>$i-) $total $unit - $date</option>";
                }
                $html.="<select>";
            }
        }


        return $html;
    }

    public function is_kalemleri_durumlari()
    {

        $data['cat'] = is_kalemleri_status();
        $head['title'] = "İş Kalemi Durumlaru";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('projects/is_kalemleri_durumlari', $data);

        $this->load->view('fixed/footer');
    }

    public function delete_is_kalemi_durumu()
    {


        $id = $this->input->post('deleteid');

        if ($id) {
            $kontrol=$this->db->query("SELECT * FROM geopos_todolist Where is_kalemi_durumu=$id");
            if($kontrol->num_rows()>0)
            {
                echo json_encode(array('status' => 'Error', 'message' => 'Bu Durumu Kullanan İşlemler Mevcut!'));
            }
            else
            {

                $this->db->delete('geopos_is_kalemleri_status', array('id' => $id));

                echo json_encode(array('status' => 'Success', 'message' => 'Başarıyla Silindi'));
            }


        } else {

            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

        }


    }

    public function edit_is_kalemi_durumlari()
    {
        if ($this->input->post()) {

            $cid = $this->input->post('catid');

            $cat_name = $this->input->post('product_cat_name',true);



            if ($cat_name) {

                $this->projects->editiskalemstatus($cid, $cat_name);

            }

        } else {

            $catid = $this->input->get('id');

            $this->db->select('*');

            $this->db->from('geopos_is_kalemleri_status');

            $this->db->where('id', $catid);

            $query = $this->db->get();

            $data['is_kalemi_durumlari'] = $query->row_array();


            $head['usernm'] = $this->aauth->get_user()->username;

            $this->load->view('fixed/header', $head);

            $this->load->view('projects/edit_is_kalemi_durumlari', $data);

            $this->load->view('fixed/footer');

        }
    }

    public function add_is_kalemi_durumu()
    {
        if ($this->input->post()) {


            $cat_name = $this->input->post('status_name');

            if ($cat_name) {



                $this->projects->addiskalemstatus($cat_name);

            }

        } else {


            $head['title'] = "İş Kalemi Durumu Ekle";

            $head['usernm'] = $this->aauth->get_user()->username;

            $this->load->view('fixed/header', $head);

            $this->load->view('projects/add_is_kalemi_durumu');

            $this->load->view('fixed/footer');

        }
    }

    public function service_product_list()

    {


        $head['title'] = "Proje Ürünleri";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('projects/products_services');

        $this->load->view('fixed/footer');



    }

    public function maliyet_raporu($proje_id)
    {
        $data=array();
        $explore= $this->projects->explore($proje_id);
        $data['insaat_gideri']=array(
            'total'=>gider_hesapla('İnşaat Giderleri',$proje_id)['total'],
            'tax'=>gider_hesapla('İnşaat Giderleri',$proje_id)['tax']
        );

        $data['maas']=array('total'=>gider_hesapla('Maaş',$proje_id)['total'],'tax'=>gider_hesapla('Maaş',$proje_id)['tax']);
        $data['kiran']=array('total'=>gider_hesapla('Kıran',$proje_id)['total'],'tax'=>gider_hesapla('Kıran',$proje_id)['tax']);
        $data['tasoron']=array('total'=>gider_hesapla('Taşöron',$proje_id)['total'],'tax'=>gider_hesapla('Taşöron',$proje_id)['tax']);
        $data['demirbas']=array('total'=>gider_hesapla('Demirbaş',$proje_id)['total'],'tax'=>gider_hesapla('Demirbaş',$proje_id)['tax']);
        $data['fehle']=array('total'=>gider_hesapla('Fəhlə',$proje_id)['total'],'tax'=>gider_hesapla('Fəhlə',$proje_id)['tax']);
        $data['yol']=array('total'=>gider_hesapla('Yol',$proje_id)['total'],'tax'=>gider_hesapla('Yol',$proje_id)['tax']);
        $data['iscilik']=array('total'=>gider_hesapla('İşçilik',$proje_id)['total'],'tax'=>gider_hesapla('İşçilik',$proje_id)['tax']);
        $data['fatura']=array('total'=>proje_faturalari($proje_id)['total'],'tax'=>proje_faturalari($proje_id)['tax']);
        $data['kurulum']=array('total'=>gider_hesapla('Kurulum',$proje_id)['total'],'tax'=>gider_hesapla('Kurulum',$proje_id)['tax']);
        $data['kiralama']=array('total'=>gider_hesapla('Kiralama',$proje_id)['total'],'tax'=>gider_hesapla('Kiralama',$proje_id)['tax']);
        $data['ortak_giderler']=array('total'=>gider_hesapla('Ortak Giderler',$proje_id)['total'],'tax'=>gider_hesapla('Ortak Giderler',$proje_id)['tax']);
        $data['ozel_giderler']=array('total'=>gider_hesapla('Özel Giderler',$proje_id)['total'],'tax'=>gider_hesapla('Özel Giderler',$proje_id)['tax']);

        $data['nakit_komisyon']=nakit_komisyonlari_proje($proje_id);
        $data['banka_komisyon']=banka_komisyonlari_proje($proje_id);
        $data['edit_data']= $explore['project'];
        // echo "<pre>";print_r($data['edit_data']);die();
        $this->load->view('projects/maliyet_raporu',$data);
    }

    public function product_list()
    {
        $catid = $this->input->get('id');



        if ($catid > 0) {

            $list = $this->projects->get_datatables($catid);

        } else {

            $list = $this->projects->get_datatables();

        }

        $data = array();

        $no = $this->input->post('start');


        foreach ($list as $prd) {

            $no++;

            $row = array();


            $pid = $prd->pid;


            $row[] = $no;


            $row[] = '<span class="avatar-lg align-baseline"><img class="myImg" resim_yolu="' . base_url() . 'userfiles/product/' . $prd->image . '" src="' . base_url() . 'userfiles/product/thumbnail/' . $prd->image . '" ></span> &nbsp;' . $prd->product_name;

            $row[] = toplam_rulo_adet($prd->pid)['toplam_adet'].' '.$prd->unit;
            $row[] = toplam_rulo_adet($prd->pid)['rezerve_qty'].' '.$prd->unit;

            $row[] = $prd->product_code;
            $row[] = $prd->kalite;
            $row[] = $prd->uretim_yeri;

            $row[]= $prd->title;

            $row[] = amountFormat($prd->product_price);

            $row[] = '

            <div class="btn-group">
                        <button type="button" class="btn btn btn-primary dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i>  </button>
                        <div class="dropdown-menu">&nbsp;
                            <a href="' . base_url() . 'products/edit?id=' . $pid . '"  class="btn btn-purple btn-sm"><span class="fa fa-edit"></span>' . $this->lang->line('Edit') . '</a>
                            <div class="dropdown-divider"></div>&nbsp;
                            <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span>' . $this->lang->line('Delete') . '</a>
                              <div class="dropdown-divider"></div>&nbsp;
                               <a href="#" data-object-id="' . $pid . '" class="btn btn-info btn-sm  clone-object"><span class="fa fa-clone"></span>Kopyala</a>
                                <div class="dropdown-divider"></div>&nbsp;
                                <a href="#" data-object-id="' . $pid . '" class="btn btn-success btn-sm  view-object"> <span class="icon-eye"></span>Göster</a>
                                  <div class="dropdown-divider"></div>&nbsp;
                                    <a href="#" data-object-id="' . $pid . '" class="btn btn-warning btn-sm view-bilgi"><span class="fa fa-eye">Bilgiler</span> </a>
                                    <div class="dropdown-divider"></div>&nbsp;
                                    <a class="btn btn-pink  btn-sm" href="' . base_url() . 'products/sales_product?id=' . $pid . '" target="_blank"> <span class="fa fa-pie-chart"></span> Satış Raporu</a>
                        </div>
                </div>';
            $row[] = '

            <a href="' . base_url() . 'products/barcode?id=' . $pid . '" class="btn btn-info btn-xs"><span class="fa fa-barcode"></span></a>

            <a href="' . base_url() . 'products/poslabel?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="fa fa-barcode"></span> </a>
            ';


            $row[] = '<input type="checkbox" name="sec[]" class="sec" value="' . $pid . '" />';
            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->projects->count_all($catid),

            "recordsFiltered" => $this->projects->count_filtered($catid),

            "data" => $data,

        );

        //output to json format

        echo json_encode($output);

    }



    public function explore()

    {


        if (!$this->aauth->premission(4)->read) {

            exit('<h3>Üzgünüm!Giriş Yetkiniz Bulunmamaktadır</h3>');

        }
        $id = $this->input->get('id');

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'Proje Detayları';

        $data['totalt'] = $this->iskalemleri->task_count_all($id);

        $explore = $this->projects->explore($id);

        $data['thread_list'] = $this->projects->task_thread($id);

        $data['milestones'] = $this->projects->milestones_list($id);

        $data['personel'] = $this->projects->list_project_employee($id);

        $data['bolumler'] = $this->projects->bolumler_list($id);

        $data['activities'] = $this->projects->activities($id);

        $data['p_files'] = $this->projects->p_files($id);

        $data['comments_list'] = $this->projects->comments_thread($id);
        $data['new_maliyet'] = $this->new_maliyet($id);

        $data['emp'] = $this->projects->list_project_employee($id);
        $data['task_status'] = $this->projects->task_status();



        $data['project'] = $explore['project'];

        // $data['customer']=$explore['customer'];

        $data['invoices'] = $explore['invoices'];



        $this->load->view('fixed/header', $head);

        $this->load->view('projects/explore', $data);

        $this->load->view('fixed/footer');



    }



    public function addproject()

    {


        if (!$this->aauth->premission(4)->update) {


            echo json_encode(array('status' => 'Error', 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            if ($this->input->post()) {



                $name = $this->input->post('name',true);

                $status = $this->input->post('status',true);

                $priority = $this->input->post('priority',true);

                $progress = $this->input->post('progress',true);

                $customer = $this->input->post('customer',true);

                $sdate = $this->input->post('sdate',true);

                $edate = $this->input->post('edate',true);

                $tag = $this->input->post('tags',true);

                $phase = $this->input->post('phase',true);

                $content = $this->input->post('content');

                $budget = $this->input->post('worth');
                $sozlesme_tutari = $this->input->post('sozlesme_tutari');

                $customerview = $this->input->post('customerview');

                $customercomment = $this->input->post('customercomment');

                $link_to_cal = $this->input->post('link_to_cal');

                $color = $this->input->post('color');

                $ptype = $this->input->post('ptype');

                $employee = $this->input->post('employee');

                $project_adresi = $this->input->post('project_adresi');
                $project_sehir = $this->input->post('project_sehir');
                $project_yetkili_adi = $this->input->post('project_yetkili_adi');
                $project_yetkili_no = $this->input->post('project_yetkili_no');
                $sozlesme_numarasi = $this->input->post('sozlesme_numarasi');
                $proje_muduru = $this->input->post('proje_muduru');
                $project_yetkili_email = $this->input->post('project_yetkili_email');
                $sozlesme_date = $this->input->post('sozlesme_date');

                $proje_muduru_id = $this->input->post('proje_muduru_id');
                $proje_sorumlusu_id = $this->input->post('proje_sorumlusu_id');
                $muhasebe_muduru_id = $this->input->post('muhasebe_muduru_id');
                $genel_mudur_id = $this->input->post('genel_mudur_id');
                $code = $this->input->post('code');

                $sdate = datefordatabase($sdate);

                $edate = datefordatabase($edate);

                $sozlesme_date = datefordatabase($sozlesme_date);



                if ($this->projects->addproject(
                    $name,
                    $status,
                    $priority,
                    $progress,
                    $customer,
                    $sdate,
                    $edate,
                    $tag,
                    $phase,
                    $content,
                    $budget,
                    $customerview,
                    $customercomment,
                    $link_to_cal,
                    $color,
                    $ptype,
                    $employee,
                    $project_adresi,
                    $project_sehir,
                    $project_yetkili_adi,
                    $project_yetkili_no,
                    $sozlesme_tutari,
                    $sozlesme_numarasi,
                    $proje_muduru,
                    $project_yetkili_email,
                    $sozlesme_date,
                    $proje_sorumlusu_id,
                    $proje_muduru_id,
                    $muhasebe_muduru_id,
                    $genel_mudur_id,
                    $code,

                )) {

                    echo json_encode(array('status' => 'Success', 'message' => 'Proje ' . $this->lang->line('ADDED')));

                } else {

                    echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

                }



            }
            else {

                $this->load->model('employee_model', 'employee');

                $head['usernm'] = $this->aauth->get_user()->username;

                $data['emp'] = $this->employee->list_employee();

                $data['project_status'] = $this->projects->project_status();

                $data['project_derece'] = $this->projects->project_derece();

                $head['title'] = 'Yeni Proje';

                $this->load->view('fixed/header', $head);

                $this->load->view('projects/addproject', $data);

                $this->load->view('fixed/footer');

            }
        }






    }



    //edit project



    public function update_proje(){

        if($this->aauth->get_user()->id==21){
            $pid = $this->input->post('p_id');

            $name = $this->input->post('name',true);

            $status = $this->input->post('status',true);

            $priority = $this->input->post('priority');

            $progress = $this->input->post('progress');

            $customer = $this->input->post('customer');

            $sdate = $this->input->post('sdate');

            $edate = $this->input->post('edate');

            $tag = $this->input->post('tags');

            $phase = $this->input->post('phase');

            $content = $this->input->post('content');

            $budget = $this->input->post('worth');

            $sozlesme_tutari = $this->input->post('sozlesme_tutari');

            $customerview = $this->input->post('customerview');

            $customercomment = $this->input->post('customercomment');

            $link_to_cal = $this->input->post('link_to_cal');

            $color = $this->input->post('color');

            $ptype = $this->input->post('ptype');

            $employee = $this->input->post('employee');
            $project_adresi = $this->input->post('project_adresi');
            $project_sehir = $this->input->post('project_sehir');
            $project_yetkili_adi = $this->input->post('project_yetkili_adi');
            $project_yetkili_no = $this->input->post('project_yetkili_no');
            $sozlesme_numarasi = $this->input->post('sozlesme_numarasi');

            $project_yetkili_email = $this->input->post('project_yetkili_email');
            $sozlesme_date = $this->input->post('sozlesme_date');

            $proje_muduru = $this->input->post('proje_muduru_id');
            $proje_sorumlusu_id =$this->input->post('proje_sorumlusu_id');
            $muhasebe_muduru_id= $this->input->post('muhasebe_muduru_id');
            $genel_mudur_id= $this->input->post('genel_mudur_id');

            $sdate = datefordatabase($sdate);

            $edate = datefordatabase($edate);
            $sozlesme_date = datefordatabase($sozlesme_date);

            if ($this->projects->editproject($pid, $name, $status, $priority, $progress, $customer, $sdate, $edate, $tag, $phase, $content, $budget, $customerview, $customercomment, $link_to_cal, $color, $ptype, $employee,  $project_adresi,
                $project_sehir,
                $project_yetkili_adi,
                $project_yetkili_no,$sozlesme_tutari,$sozlesme_numarasi,$proje_muduru,$project_yetkili_email,$sozlesme_date,
                $proje_sorumlusu_id,$muhasebe_muduru_id,$genel_mudur_id
            )) {

                echo json_encode(array('status' => 'Success', 'message' => 'Proje Başarıyla Güncellendi'));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => 'Hata Aldınız'));

            }
        }
        else{
            echo json_encode(array('status' => 'Error', 'message' => 'Yetkiniz Yoktur'));
        }

    }







    //tasks section



    public function addtask()

    {

        $this->load->model('employee_model', 'employee');

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'Görev Ekle';

        $data['prid'] = $this->input->get('id');

        $data['bolumler'] = $this->projects->bolumler_list($data['prid']);
        $data['hizmetler'] = $this->projects->hizmetler_list($data['prid']);

        $data['milestones'] = $this->projects->milestones($data['prid']);

        $data['emp'] = $this->employee->list_project_employee($data['prid']);
        $data['cari'] = $this->projects->customer_details();
        $data['task_status'] = $this->projects->task_status();



        $this->load->view('fixed/header', $head);

        $this->load->view('projects/addtask', $data);

        $this->load->view('fixed/footer');



    }




    public function edit_asama()

    {



        if ($this->input->post()) {

            $name = $this->input->post('name');
            $asama_id = $this->input->post('asama_id');
            $customer = $this->input->post('customer');

            $stdate = $this->input->post('staskdate');

            $tdate = $this->input->post('taskdate');

            $content = $this->input->post('content');

            $color = $this->input->post('color');

            $prid = $this->input->post('project');

            $bolum = $this->input->post('bolum');
            $parent_id = $this->input->post('parent_id');

            $pers_id = $this->input->post('pers_id');

            $butce = $this->input->post('butce');

            $stdate = datefordatabase($stdate);

            $tdate = datefordatabase($tdate);

            $olcu_birimi = $this->input->post('olcu_birimi');
            $quantity = $this->input->post('quantity');
            $fiyat = $this->input->post('fiyat');
            $total=$this->input->post('toplam_fiyat');




            if ($this->projects->update_asaama($olcu_birimi,$quantity,$fiyat,$total,$name, $stdate, $tdate, $content, $color, $prid,$bolum,$pers_id,$butce,$customer,$asama_id,$parent_id)) {

                kont_kayit(40,$asama_id);
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . '&nbsp; Projeye Geri Dön <a href="' . base_url("projects/explore?id=" . $prid) . '" class="btn btn-primary btn-xs"><i class="icon-eye"></i> ' . $this->lang->line('Yes') . '</a>'));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

            }



        } else {



            $this->load->model('employee_model', 'employee');

            $head['usernm'] = $this->aauth->get_user()->username;

            $data['emp'] = $this->employee->list_employee();



            $asama_id=$this->input->get('id');

            $data['prid'] = $this->db->query("SELECT pid FROM geopos_milestones WHERE id=$asama_id")->row()->pid;

            $data['personel'] = $this->projects->list_project_employee($data['prid']);

            $data['bolumler'] = $this->projects->bolumler($data['prid']);

            $data['edit_data'] = $this->projects->asama_details($asama_id);

            $head['title'] = 'Aşama Düzenle';





            $this->load->view('fixed/header', $head);

            $this->load->view('projects/edit_asama_v', $data);

            $this->load->view('fixed/footer');

        }



    }


    public function addactivity()

    {



        if ($this->input->post()) {

            $name = $this->input->post('name');

            $prid = $this->input->post('project');



            if ($this->projects->add_activity($name, $prid)) {

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . '&nbsp; Return to project <a href="' . base_url("projects/explore?id=" . $prid) . '" class="btn btn-primary btn-xs"><i class="icon-eye"></i> ' . $this->lang->line('Yes') . '</a>'));

            } else {

                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

            }



        } else {



            $this->load->model('employee_model', 'employee');

            $head['usernm'] = $this->aauth->get_user()->username;

            $data['emp'] = $this->employee->list_employee();

            $head['title'] = 'Add activity';

            $data['prid'] = $this->input->get('id');



            $this->load->view('fixed/header', $head);

            $this->load->view('projects/addactivity', $data);

            $this->load->view('fixed/footer');

        }



    }



    public function edittask()

    {


        $this->load->model('employee_model', 'employee');

        $id = $this->input->get('id');

        $data['task'] = $this->projects->viewtask($id);
        $asama_id=$data['task']['asama_id'];

        $proje_id=$this->db->query("SELECT * FROM geopos_milestones where id=$asama_id")->row()->pid;

        $data['bolumler'] = $this->projects->bolumler_list($proje_id);
        $data['hizmetler'] = $this->projects->hizmetler_list($proje_id);

        $data['milestones'] = $this->projects->milestones($proje_id);
        $data['proje_id'] = $proje_id;


        $data['emp'] = $this->employee->list_employee();
        $data['cari'] = $this->projects->customer_details();
        $data['task_status'] = $this->projects->task_status();







        $head['usernm'] = $this->aauth->get_user()->username;



        $head['title'] = 'Düzenle';





        $data['emp'] = $this->employee->list_employee($id);

        $this->load->view('fixed/header', $head);

        $this->load->view('projects/edittask', $data);

        $this->load->view('fixed/footer');





    }

    public function all_gider()
    {

        $pid = $this->input->post('pid');

        $list = $this->projects->all_gider_datatables($pid);
        $data = array();

        $no = $this->input->post('start');




        $invoice_id=0;
        $invoice_id_kontrol=0;


        foreach ($list as $task) {


            $kur_degeri=$task->kur_degeri;


            $odenen=0;
            $kalan=0;
            $no++;

            $style='';
            $bolum_to_asama='';
            $total=0;

            if(isset($task->butce))
            {
                if($task->butce < bolum_invoice($task->id,$pid))
                {
                    $style="background-color: red;color: white;";

                }


            }
            $tip='';
            $invoice_gider='';
            $sub_total=0;
            $odeme_sekli='-';
            $odeme_durumu='-';
            $firma_adi='-';

            $odenen = amountFormat($task->last_balance);
            $kalan_num=$task->subtotal-$task->last_balance;

            $odenen_num=$task->last_balance;
            $kalan = amountFormat($kalan_num);


            $kdv_odenen = amountFormat($task->kdv_last_balance);
            $kdv_kalan_num=$task->totaltax-$task->kdv_last_balance;

            $kdv_odenen_num=$task->kdv_last_balance;
            $kdv_kalan = amountFormat($kdv_kalan_num);

            if($task->invoice_type_id==21 || $task->invoice_type_id==24)
            {

                $firma_adi=$task->company;

                /*

                if($task->refer==1)//cari
                {
                    $firma_adi=$task->company;
                }
                else if($task->refer==2)//personel
                {
                    $firma_adi=personel_details($task->csd);
                }
                else if($task->refer==3)//fatura
                {
                    $firma_adi=$task->invoice_no;
                }

                */

                $tip=ana_masraf_name($task->pid);

                $sub_total=amountFormat($task->price*$task->qty);
                if($kalan_num==0)
                {
                    $odeme_sekli=account_type_sorgu($task->method);
                    $odeme_durumu='Ödendi';

                }

                else if($kalan_num >0 && $kalan_num < $task->subtotal)
                {
                    $odeme_sekli=account_type_sorgu($task->method);
                    $odeme_durumu='Kısmi Ödeme';
                }
                else
                {
                    $odeme_sekli=account_type_sorgu($task->method);
                    $odeme_durumu='Ödenmedi';
                }
                $invoice_gider='/transactions/print_t?id='.$task->tid;

            }

            else  if($task->invoice_type_id==58) // Transfer
            {

                $firma_adi=depo_name($task->depo_id).' - Transfer';
                $details = $this->db->query("SELECT * FROM geopos_stok_cikis where id = $task->tid")->row();



                /*

                if($task->refer==1)//cari
                {
                    $firma_adi=$task->company;
                }
                else if($task->refer==2)//personel
                {
                    $firma_adi=personel_details($task->csd);
                }
                else if($task->refer==3)//fatura
                {
                    $firma_adi=$task->invoice_no;
                }

                */

                $item_details = $this->db->query("SELECT * FROM `geopos_invoice_items` INNER JOIN geopos_invoices ON geopos_invoice_items.tid = geopos_invoices.id  WHERE `pid` = $task->pid ORDER BY `geopos_invoice_items`.`price` DESC LIMIT 1")->row();

                $tip=$task->product;

                $sub_total=amountFormat($task->price*$task->qty);
                if($kalan_num==0)
                {
                    $odeme_sekli=account_type_sorgu($item_details->method);
                    $odeme_durumu='Ödendi';

                }

                else if($kalan_num >0 && $kalan_num < $task->subtotal)
                {
                    $odeme_sekli=account_type_sorgu($item_details->method);
                    $odeme_durumu='Kısmi Ödeme';
                }
                else
                {
                    $odeme_sekli=account_type_sorgu($item_details->method);
                    $odeme_durumu='Ödenmedi';
                }
                $invoice_gider='/transactions/print_t?id='.$task->tid;

            }
            else if($task->invoice_type_id==29 || $task->invoice_type_id==30 ){
                $kontrol=$this->db->query("select * from invoice_to_forma_2 where forma_2_id=$task->tid")->num_rows();
                if($kontrol){
                    continue;
                }
            }


            else
            {
                $invoice_gider='/invoices/printinvoice?id='.$task->tid;
                if(isset($task->pid))
                {
                    if($task->invoice_type_id==35)
                    {
                        $tip=$task->item_desc;
                    }
                    else
                    {

                        $tip=product_detail($task->pid)['cat_name'];
                    }

                }

                $sub_total=amountFormat($task->price*$task->qty*$kur_degeri);
                $odeme_sekli=account_type_sorgu($task->method);
                if($kalan_num==0)
                {
                    $odeme_durumu='Ödendi';
                }
                else if($kalan_num > 0 && $kalan_num < $task->subtotal)
                {
                    $odeme_durumu='Kısmi Ödeme';
                }
                else
                {
                    $odeme_durumu='Ödenmedi';
                }


                $firma_adi=$task->company;

            }

            $nakit_komisyon=amountFormat(0);
            $banka_komisyon=amountFormat(0);
            if($task->method==1)
            {
                $nakit_komisyon=amountFormat($task->subtotal*6/1000);
            }
            else if($task->method==3)
            {
                //alış faturası ise


                if($task->invoice_type_id==2)
                {


                    $invoice_sub=fatura_details($task->tid)->subtotal; //780




                    $invoice_dis=fatura_details($task->tid)->discount; // 0


                    $net_toplam=$invoice_sub-$invoice_dis;



                    $oran=($net_toplam*0.12/100);
                    $banka_komisyon_=($oran/$net_toplam) * ($task->subtotal-$task->discount);
                    $banka_komisyon=amountFormat($banka_komisyon_);

                }



            }



            $sub_total_n=$task->price*$task->qty;
            $total_tax=$sub_total_n*($task->product_tax/100);
            $row = array();

            $row[] = $no;

            $row[] =dateformat($task->invoicedate);
            $row[] = $firma_adi;
            $row[] = $task->invoice_no;
            //$row[] =$tip;
            $row[] =$task->product;
            $row[] =$task->notes;
            $row[] =amountFormat($task->price*$kur_degeri);
            $row[] =amountFormat_s($task->qty).' '.units_($task->unit)['name'];



//            $row[] = $task->product_tax; // Kdv Oranı
            $row[] = amountFormat(($sub_total_n)*$kur_degeri);
//            $row[] = amountFormat($total_tax*$kur_degeri);
//            $row[] = amountFormat(($sub_total_n)*$kur_degeri);
            $row[] = $odeme_sekli;
//            $row[] = $odeme_durumu;
//            $row[] = $odenen;
//            $row[] = $kalan;
//            $row[] = $kdv_odenen;
//            $row[] = $kdv_kalan;
//            $row[] = ''; //Gümrük Nakit Ödemeler
//            $row[] = ''; //Gümrük Köçürme
//            $row[] = $nakit_komisyon; //Nakit Komisyon
//            $row[] = $banka_komisyon; //Banka Komisyon
//            $row[] = amountFormat(($total_tax+$sub_total_n)*$kur_degeri); //Toplam
            $row[] = '<a class="btn-info btn-sm" target="_blank" href="' . $invoice_gider . '" data-object-id="' . $task->tid . '"> <i class="icon-eye"></i> </a>';
            $row[]=$style;
            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->bolum->bolum_count_all($pid),

            "recordsFiltered" => $this->bolum->bolum_count_filtered($pid),

            "data" => $data,

        );

        echo json_encode($output);
    }

    public function new_maliyet($pid)
    {

        $list = $this->projects->all_gider_datatables($pid);
        $data = array();

        $no = $this->input->post('start');



        $new_maliyet = 0;

        $invoice_id=0;
        $invoice_id_kontrol=0;


        foreach ($list as $task) {


            $kur_degeri=$task->kur_degeri;


            $odenen=0;
            $kalan=0;
            $no++;

            $style='';
            $bolum_to_asama='';
            $total=0;

            if(isset($task->butce))
            {
                if($task->butce < bolum_invoice($task->id,$pid))
                {
                    $style="background-color: red;color: white;";

                }


            }
            $tip='';
            $invoice_gider='';
            $sub_total=0;
            $odeme_sekli='-';
            $odeme_durumu='-';
            $firma_adi='-';

            $odenen = amountFormat($task->last_balance);
            $kalan_num=$task->subtotal-$task->last_balance;

            $odenen_num=$task->last_balance;
            $kalan = amountFormat($kalan_num);


            $kdv_odenen = amountFormat($task->kdv_last_balance);
            $kdv_kalan_num=$task->totaltax-$task->kdv_last_balance;

            $kdv_odenen_num=$task->kdv_last_balance;
            $kdv_kalan = amountFormat($kdv_kalan_num);

            if($task->invoice_type_id==21 || $task->invoice_type_id==24)
            {

                $firma_adi=$task->company;

                /*

                if($task->refer==1)//cari
                {
                    $firma_adi=$task->company;
                }
                else if($task->refer==2)//personel
                {
                    $firma_adi=personel_details($task->csd);
                }
                else if($task->refer==3)//fatura
                {
                    $firma_adi=$task->invoice_no;
                }

                */

                $tip=ana_masraf_name($task->pid);

                $sub_total=amountFormat($task->price*$task->qty);
                if($kalan_num==0)
                {
                    $odeme_sekli=account_type_sorgu($task->method);
                    $odeme_durumu='Ödendi';

                }

                else if($kalan_num >0 && $kalan_num < $task->subtotal)
                {
                    $odeme_sekli=account_type_sorgu($task->method);
                    $odeme_durumu='Kısmi Ödeme';
                }
                else
                {
                    $odeme_sekli=account_type_sorgu($task->method);
                    $odeme_durumu='Ödenmedi';
                }
                $invoice_gider='/transactions/print_t?id='.$task->tid;

            }

            else  if($task->invoice_type_id==58) // Transfer
            {

                $firma_adi=depo_name($task->depo_id).' - Transfer';
                $details = $this->db->query("SELECT * FROM geopos_stok_cikis where id = $task->tid")->row();



                /*

                if($task->refer==1)//cari
                {
                    $firma_adi=$task->company;
                }
                else if($task->refer==2)//personel
                {
                    $firma_adi=personel_details($task->csd);
                }
                else if($task->refer==3)//fatura
                {
                    $firma_adi=$task->invoice_no;
                }

                */

                $item_details = $this->db->query("SELECT * FROM `geopos_invoice_items` INNER JOIN geopos_invoices ON geopos_invoice_items.tid = geopos_invoices.id  WHERE `pid` = $task->pid ORDER BY `geopos_invoice_items`.`price` DESC LIMIT 1")->row();

                $tip=$task->product;

                $sub_total=amountFormat($task->price*$task->qty);
                if($kalan_num==0)
                {
                    $odeme_sekli=account_type_sorgu($item_details->method);
                    $odeme_durumu='Ödendi';

                }

                else if($kalan_num >0 && $kalan_num < $task->subtotal)
                {
                    $odeme_sekli=account_type_sorgu($item_details->method);
                    $odeme_durumu='Kısmi Ödeme';
                }
                else
                {
                    $odeme_sekli=account_type_sorgu($item_details->method);
                    $odeme_durumu='Ödenmedi';
                }
                $invoice_gider='/transactions/print_t?id='.$task->tid;

            }

            else if($task->invoice_type_id==29 || $task->invoice_type_id==30 ){
                $kontrol=$this->db->query("select * from invoice_to_forma_2 where forma_2_id=$task->tid")->num_rows();
                if($kontrol){
                    continue;
                }
            }


            else
            {
                $invoice_gider='/invoices/printinvoice?id='.$task->tid;
                if(isset($task->pid))
                {
                    if($task->invoice_type_id==35)
                    {
                        $tip=$task->item_desc;
                    }
                    else
                    {

                        $tip=product_detail($task->pid)['cat_name'];
                    }

                }

                $sub_total=amountFormat($task->price*$task->qty*$kur_degeri);
                $odeme_sekli=account_type_sorgu($task->method);
                if($kalan_num==0)
                {
                    $odeme_durumu='Ödendi';
                }
                else if($kalan_num > 0 && $kalan_num < $task->subtotal)
                {
                    $odeme_durumu='Kısmi Ödeme';
                }
                else
                {
                    $odeme_durumu='Ödenmedi';
                }


                $firma_adi=$task->company;

            }

            $nakit_komisyon=amountFormat(0);
            $banka_komisyon=amountFormat(0);
            if($task->method==1)
            {
                $nakit_komisyon=amountFormat($task->subtotal*6/1000);
            }
            else if($task->method==3)
            {
                //alış faturası ise


                if($task->invoice_type_id==2)
                {


                    $invoice_sub=fatura_details($task->tid)->subtotal; //780




                    $invoice_dis=fatura_details($task->tid)->discount; // 0


                    $net_toplam=$invoice_sub-$invoice_dis;



                    $oran=($net_toplam*0.12/100);
                    $banka_komisyon_=($oran/$net_toplam) * ($task->subtotal-$task->discount);
                    $banka_komisyon=amountFormat($banka_komisyon_);

                }



            }



            $sub_total_n=$task->price*$task->qty;
            $total_tax=$sub_total_n*($task->product_tax/100);
            $row = array();

            $totals = ($total_tax+$sub_total_n)*$kur_degeri;
            $new_maliyet+=$totals;

        }

        return $new_maliyet;
    }

    public function all_gider_()
    {

        $pid = $this->input->post('pid');

        $list = $this->projects->all_gider_datatables($pid);
        $data = array();

        $no = $this->input->post('start');



        $invoice_id=0;
        $invoice_id_kontrol=0;

        foreach ($list as $task) {


            $kur_degeri=$task->kur_degeri;


            $odenen=0;
            $kalan=0;
            $no++;

            $style='';
            $bolum_to_asama='';
            $total=0;

            if(isset($task->butce))
            {
                if($task->butce < bolum_invoice($task->id,$pid))
                {
                    $style="background-color: red;color: white;";

                }


            }
            $tip='';
            $invoice_gider='';
            $sub_total=0;
            $odeme_sekli='-';
            $odeme_durumu='-';
            $firma_adi='-';
            $invoice_no=$task->invoice_no;
            $notes=$task->notes;

            $odenen = amountFormat($task->last_balance);
            $kalan_num=$task->subtotal-$task->last_balance;

            $odenen_num=$task->last_balance;
            $kalan = amountFormat($kalan_num);


            $kdv_odenen = amountFormat($task->kdv_last_balance);
            $kdv_kalan_num=$task->totaltax-$task->kdv_last_balance;

            $kdv_odenen_num=$task->kdv_last_balance;
            $kdv_kalan = amountFormat($kdv_kalan_num);

            if($task->invoice_type_id==21 || $task->invoice_type_id==24)
            {

                $firma_adi=$task->company;

                /*

                if($task->refer==1)//cari
                {
                    $firma_adi=$task->company;
                }
                else if($task->refer==2)//personel
                {
                    $firma_adi=personel_details($task->csd);
                }
                else if($task->refer==3)//fatura
                {
                    $firma_adi=$task->invoice_no;
                }

                */

                $tip=ana_masraf_name($task->pid);

                $sub_total=amountFormat($task->price*$task->qty);
                if($kalan_num==0)
                {
                    $odeme_sekli=account_type_sorgu($task->method);
                    $odeme_durumu='Ödendi';

                }

                else if($kalan_num >0 && $kalan_num < $task->subtotal)
                {
                    $odeme_sekli=account_type_sorgu($task->method);
                    $odeme_durumu='Kısmi Ödeme';
                }
                else
                {
                    $odeme_sekli=account_type_sorgu($task->method);
                    $odeme_durumu='Ödenmedi';
                }
                $invoice_gider='/transactions/print_t?id='.$task->tid;

            }
            else  if($task->invoice_type_id==58) // Transfer
            {

                $firma_adi=depo_name($task->depo_id);
                $details = $this->db->query("SELECT * FROM geopos_stok_cikis where id = $task->tid")->row();
                $invoice_no=$details->fis_no;
                $notes = $details->fis_note;


                /*

                if($task->refer==1)//cari
                {
                    $firma_adi=$task->company;
                }
                else if($task->refer==2)//personel
                {
                    $firma_adi=personel_details($task->csd);
                }
                else if($task->refer==3)//fatura
                {
                    $firma_adi=$task->invoice_no;
                }

                */

                $item_details = $this->db->query("SELECT * FROM `geopos_invoice_items` INNER JOIN geopos_invoices ON geopos_invoice_items.tid = geopos_invoices.id  WHERE `pid` = $task->pid ORDER BY `geopos_invoice_items`.`price` DESC LIMIT 1")->row();

                $tip=$task->product;

                $sub_total=amountFormat($task->price*$task->qty);
                if($kalan_num==0)
                {
                    $odeme_sekli=account_type_sorgu($item_details->method);
                    $odeme_durumu='Ödendi';

                }

                else if($kalan_num >0 && $kalan_num < $task->subtotal)
                {
                    $odeme_sekli=account_type_sorgu($item_details->method);
                    $odeme_durumu='Kısmi Ödeme';
                }
                else
                {
                    $odeme_sekli=account_type_sorgu($item_details->method);
                    $odeme_durumu='Ödenmedi';
                }
                $invoice_gider='/transactions/print_t?id='.$task->tid;

            }

            else
            {

                $invoice_gider='/invoices/printinvoice?id='.$task->tid;
                if(isset($task->pid))
                {
                    if($task->invoice_type_id==35)
                    {
                        $tip=$task->item_desc;
                    }
                    else  if($task->invoice_type_id==29 || $task->invoice_type_id==30)
                    {
                        $tip=$task->invoice_desc;
                    }
                    else
                    {

                        $tip=product_detail($task->pid)['cat_name'];
                    }

                }



                $sub_total=amountFormat($task->price*$task->qty*$kur_degeri);
                $odeme_sekli=account_type_sorgu($task->method);
                if($kalan_num==0)
                {
                    $odeme_durumu='Ödendi';
                }
                else if($kalan_num > 0 && $kalan_num < $task->subtotal)
                {
                    $odeme_durumu='Kısmi Ödeme';
                }
                else
                {
                    $odeme_durumu='Ödenmedi';
                }


                $firma_adi=$task->company;

            }

            $nakit_komisyon=amountFormat(0);
            $banka_komisyon=amountFormat(0);
            if($task->method==1)
            {
                $nakit_komisyon=amountFormat($task->subtotal*6/1000);
            }
            else if($task->method==3)
            {
                //alış faturası ise


                if($task->invoice_type_id==2)
                {


                    $invoice_sub=fatura_details($task->tid)->subtotal; //780




                    $invoice_dis=fatura_details($task->tid)->discount; // 0


                    $net_toplam=$invoice_sub-$invoice_dis;



                    $oran=($net_toplam*0.12/100);
                    $banka_komisyon_=($oran/$net_toplam) * ($task->subtotal-$task->discount);
                    $banka_komisyon=amountFormat($banka_komisyon_);

                }



            }


            $invoice_details = $this->db->query("SELECT * FROM geopos_invoices Where id =$task->tid")->row();
            $transaction = $this->db->query("SELECT SUM(total) as odenen,method FROM geopos_invoice_transactions Where invoice_id = $task->tid and method != 4")->row();
            $transaction_kdv = $this->db->query("SELECT SUM(total) as kdv_odenen FROM geopos_invoice_transactions Where invoice_id = $task->tid and method = 4")->row();

            $banka_komisyon=0;
            $nakit_komisyon=0;
            if($transaction->method==3){
                $oran=($invoice_details->subtotal*0.12/100);
                $banka_komisyon_=@($oran/$invoice_details->subtotal) * ($invoice_details->subtotal-$invoice_details->discount);
                $banka_komisyon=amountFormat($banka_komisyon_);


            }
            if($transaction->method==1 || $transaction->method==8 || $transaction->method==5)
            {
                $nakit_komisyon=amountFormat($invoice_details->subtotal*6/1000);
            }


            $sub_total_n=$invoice_details->subtotal;
            $total_tax=$invoice_details->tax;



            $row = array();

            $row[] = $no;

            $row[] =dateformat($task->invoicedate);
            $row[] = $firma_adi;
            $row[] = $invoice_no;
            $row[] =$tip;
            $row[] =$notes;
            $row[] ='';
            $row[] ='';
            $row[] =amountFormat($invoice_details->subtotal);
            $row[] = $invoice_details->tax_oran; // Kdv Oranı
            $row[] =amountFormat($invoice_details->total*$kur_degeri); // Net Toplam
            $row[] = amountFormat($total_tax*$kur_degeri);
            $row[] = amountFormat(($total_tax+$sub_total_n)*$kur_degeri);
            $row[] = $odeme_sekli;
            $row[] = $odeme_durumu;
            $row[] = amountFormat($transaction->odenen);
            $row[] = amountFormat(floatval($invoice_details->total)-floatval($transaction->odenen));
            $row[] = $transaction_kdv->kdv_odenen;
            $row[] = $kdv_kalan;
            $row[] = ''; //Gümrük Nakit Ödemeler
            $row[] = ''; //Gümrük Köçürme
            $row[] = $nakit_komisyon; //Nakit Komisyon
            $row[] = $banka_komisyon; //Banka Komisyon
            $row[] = amountFormat(($total_tax+$sub_total_n)*$kur_degeri); //Toplam
            $row[] = '<a class="btn-info btn-sm" target="_blank" href="' . $invoice_gider . '" data-object-id="' . $task->tid . '"> <i class="icon-eye"></i> </a>';
            $row[]=$style;
            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->bolum->bolum_count_all($pid),

            "recordsFiltered" => $this->bolum->bolum_count_filtered($pid),

            "data" => $data,

        );

        echo json_encode($output);
    }

    public function proje_bolumleri()
    {

        $pid = $this->input->post('pid');

        $list = $this->projects->bolumler_datatables($pid);

        $data = array();

        $no = $this->input->post('start');



        foreach ($list as $task) {

            $no++;

            $style='';
            $bolum_to_asama='';
            $total=0;

            $edit = "<button bolum_id='$task->id' class='btn btn-warning edit-bolum'><i class='fa fa-edit'></i></button>&nbsp;<button data-id='$task->id' class='btn btn-danger delete-bolum'><i class='fa fa-trash'></i></button>";


            if(isset($task->butce))
            {
                if($task->butce < bolum_invoice($task->id,$pid))
                {
                    $style="background-color: red;color: white;";

                }


            }

            $row = array();

            $row[] = $no;

            $row[] = $task->name;
            $row[] = amountFormat($task->butce);
            $row[] = amountFormat(bolum_invoice($task->id,$pid));

            $row[] = $edit;
            $row[]=$style;
            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->bolum->bolum_count_all($pid),

            "recordsFiltered" => $this->bolum->bolum_count_filtered($pid),

            "data" => $data,

        );

        echo json_encode($output);
    }

    public function proje_bolum_ajax()
    {
        $pid = $this->input->post('pid');
        $bolumler=$this->db->query("SELECT * FROM `geopos_project_bolum` Where pid=$pid")->result();
        echo json_encode($bolumler);

    }

    public function asama_bilgi_ajax()
    {
        $id = $this->input->post('asama_id');
        $detay=$this->db->query("SELECT * FROM `geopos_milestones` Where id=$id")->row();
        echo json_encode($detay);

    }

    public function proje_asamalari_ajax()
    {
        $pid = $this->input->post('proje_id');
        $asama_id = $this->input->post('asama_id');
        $whr='';
        if($asama_id!=0){
            $whr = "and  parent_id=$asama_id ";
        }
        $bolum_id = $this->input->post('bolum_id');
        $asamalar=$this->db->query("SELECT * FROM `geopos_milestones` Where bolum_id=$bolum_id  $whr and pid=$pid")->result();
        echo json_encode($asamalar);

    }

    public function proje_ana_asamalari_ajax()
    {
        $pid = $this->input->post('proje_id');
        $bolum_id = $this->input->post('bolum_id');
        $asamalar=$this->db->query("SELECT * FROM `geopos_milestones` Where parent_id=0 and bolum_id=$bolum_id and pid=$pid")->result();
        echo json_encode($asamalar);

    }
    public function proje_is_kalemleri_ajax()
    {
        $pid = $this->input->post('asama_id');
        $proje_id = $this->input->post('proje_id');
        $gorevler=$this->db->query("SELECT * FROM `geopos_todolist` Where asama_id=$pid and rid=$proje_id")->result();
        echo json_encode($gorevler);

    }




    public function yeni_proje_urunu_ekle($name,$tip,$unit)
    {
        $product_name = $name;
        $product_code =$name;
        $product_price =0;
        $factoryprice = 0;
        $taxrate =0;
        $disrate = 0;
        $product_qty = 0;
        $product_qty_alert = 0;
        $product_desc = $name;
        $image = '';
        $barcode = rand(100, 999) . '-' . rand(0, 9) . '-' . rand(1000000, 9999999) . '-' . rand(0, 9);;
        $product_type=1;
        if($tip==1)
        {
            $product_type=7;


        }
        else
        {
            $product_type=1;
        }
        return $this->projects->addnew_todo($product_name,
            $product_code, $product_price, $factoryprice, $taxrate,
            $disrate, $product_qty, $product_qty_alert, $product_desc,
            $image, $unit, $barcode,$product_type);
    }


    public function update_task()

    {

        $task_id = $this->input->post('task_id');

        $gorev_tipi = $this->input->post('gorev_tipi');
        $olcu_birimi = $this->input->post('unit');
        $proje_id = $this->input->post('proje_id');

        if(is_numeric($this->input->post('name')))

        {
            $new_prd_id=$this->input->post('name');
            $name = product_name($this->input->post('name'));
        }
        else
        {
            $new_prd_id=$this->yeni_proje_urunu_ekle($this->input->post('name'),$gorev_tipi,$olcu_birimi);
            $name = $this->input->post('name');
        }


        $oran = $this->input->post('oran');
        $status = $this->input->post('status');

        $priority = $this->input->post('priority');

        $stdate = $this->input->post('staskdate');

        $tdate = $this->input->post('taskdate');

        $employee = $this->input->post('employee');

        $content = $this->input->post('content');

        $prid =$proje_id;

        $milestone = $this->input->post('milestone');


        $quantity = $this->input->post('quantity');
        $fiyat = $this->input->post('fiyat');

        $total=$this->input->post('toplam_fiyat');
        $cari_id = $this->input->post('cari_id');
        $simeta_status = $this->input->post('simeta_status');







        $assign = $this->aauth->get_user()->id;

        $stdate = datefordatabase($stdate);

        $tdate = datefordatabase($tdate);


        // $out=$this->projects->addtask($name, $status, $priority, $stdate, $tdate, $employee, $assign, $content, $prid, $milestone);

        // print_r($out);


        if ($this->projects->updateTask($oran,$new_prd_id,$name, $status, $priority, $stdate, $tdate, $employee, $assign, $content, $prid, $milestone,$quantity,$fiyat,$olcu_birimi,$total,$cari_id,$gorev_tipi,$task_id,$proje_id,$simeta_status)) {


            kont_kayit(36,$task_id);


            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('New Task Added') . '&nbsp; Projeye Geri Dön <a href="' . base_url("projects/explore?id=" . $proje_id) . '" class="btn btn-primary btn-xs"><i class="icon-eye"></i> ' . $this->lang->line('Yes') . '</a>'));



        } else {

            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

        }



    }



    public function set_task()

    {

        $id = $this->input->post('tid');

        $stat = $this->input->post('stat');

        $this->tools->settask($id, $stat);

        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED'), 'pstatus' => 'Success'));





    }



    public function view_task()

    {

        $id = $this->input->post('tid');



        $task = $this->tools->viewtask($id);



        echo json_encode(array('name' => $task['name'], 'description' => $task['description'], 'employee' => $task['emp'], 'assign' => $task['assign'], 'priority' => $task['priority']));

    }



    public function projects_stats()

    {



        $project = $this->input->get('id');

        //echo $project;

        $this->projects->project_stats($project);





    }



    public function delete_i()

    {

        $id = $this->input->post('deleteid');



        if ($this->projects->deleteproject($id)) {

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

        }

    }





    public function project_load_list()

    {

        $cday = $this->input->get('cday');



        $list = $this->projects->project_datatables();

        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $project) {

            $no++;

            $text=$project->name;
//            if(isset($project->name)){
//                if(strlen($project->name) > 25){
//                    $text =  substr_replace("$project->name", "...", 25);
//                }
//
//            }


            $name = '<a class="btn btn-outline-info" href="' . base_url() . 'projects/explore?id=' . $project->id . '">' .$text  . '</a>';



            $row = array();

            $row[] = $no;
            $row[] = $project->code;

            $row[] = $name;

            $row[] = dateformat($project->sdate);

            $row[] = $project->customer;

            $row[] = project_status($project->status);
            $row[] = '<a href="' . base_url() . 'projects/explore?id=' . $project->id . '" class="btn btn-primary btn-sm rounded" data-id="' . $project->id . '" data-stat="0"><i class="fa fa-eye"></i></a>
        <a class="btn btn-info btn-sm edit_proje" type="button" proje_id="' . $project->id . '"> <i class="icon-pencil"></i> </a>
        <button class="btn btn-warning btn-sm maas_sort" type="button" proje_id="' . $project->id . '"> <i class="fa fa-filter"></i> </button>
        &nbsp;';

            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->projects->project_count_all($cday),

            "recordsFiltered" => $this->projects->project_count_filtered($cday),

            "data" => $data,

        );

        echo json_encode($output);

    }





    public function pendingtasks()

    {

        $tasks = $this->projects->pending_tasks();



        $tlist = '';

        $tc = 0;

        foreach ($tasks as $row) {





            $tlist .= '<a href="javascript:void(0)" class="list-group-item">

                      <div class="media">

                        <div class="media-left valign-middle"><i class="icon-bullhorn2 icon-bg-circle bg-cyan"></i></div>

                        <div class="media-body">

                          <h6 class="media-heading">' . $row['name'] . '</h6>

                          <p class="notification-text font-small-2 text-muted">Due date is ' . $row['duedate'] . '.</p><small>

                            Start <time  class="media-meta text-muted">' . $row['start'] . '</time></small>

                        </div>

                      </div></a>';

            $tc++;

        }



        echo json_encode(array('tasks' => $tlist, 'tcount' => $tc));





    }



    //tasks





    public function todo_load_list_forma2()

    {

        $pid = $this->input->post('pid');

        $list = $this->projects->task_datatables($pid);

        $data = array();

        $no = $this->input->post('start');




        foreach ($list as $task) {

            $no++;

            $name = '<a class="check text-default" data-id="' . $task->id . '" data-stat="Due"> <i class="icon-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';

            if ($task->status == 'Done') {

                $name = '<a class="check text-success" data-id="' . $task->id . '" data-stat="Done"> <i class="icon-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';

            }

            if($task->gorev_tipi==1)
            {
                $tip='Hizmet';
            }
            else
            {
                $tip='Stok';
            }

            $style='';

            if(isset($task->toplam_fiyat))
            {
                if($task->toplam_fiyat < is_kalemleri_invoice($task->id,$pid))
                {
                    $style="background-color: red;color: white;";

                }


            }

            $ana_asama_adi=task_to_asama($task->asama_id);
            $ana_asama_id=$task->asama_id;
            $unit_n=units_($task->unit)['name'];

            $row = array();

            $row[] = "<input type='checkbox' class='form-control task_id'
            proje_bolum_id ='$task->bolum_id'
            proje_bolum_name ='$task->bolum_adi'
            ana_asama_id='$ana_asama_id'
            ana_asama_name='$ana_asama_adi'
            hizmet_name='$task->name'
            birim_fiyati='$task->fiyat'
            quantity_='$task->quantity'
            total_fiyat='$task->toplam_fiyat'
            unit_id='$task->unit'
            unit_name='$unit_n'

             value='$task->id'>";
            $row[] =   $tip;
            $row[] =   $task->name;

            $row[] = $task->bolum_adi;
            $row[] = task_to_asama($task->parent_id);
            $row[] = task_to_asama($task->asama_id);
            $row[] = amountFormat($task->fiyat);
            $row[] = units_($task->unit)['name'];
            $row[] = $task->quantity;
            $row[] = round($task->oran).' %';
            $row[] = amountFormat($task->toplam_fiyat);
            /* $row[] = dateformat($task->start);

            $row[] = dateformat($task->duedate);*/

            $row[] = amountFormat(invoice_task_total($task->id));
            $row[] = personel_details($task->eid);
            $row[] = customer_details($task->cari_id)['company'];

            $row[] = is_kalemleri_status_id($task->is_kalemi_durumu)['name'];


            $row[]=$style;

            $data[] = $row;

        }



        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->iskalemleri->task_count_all($pid),

            "recordsFiltered" => $this->iskalemleri->task_count_filtered($pid),

            "data" => $data,

        );

        echo json_encode($output);

    }





    public function file_handling()

    {

        $id = $this->input->get('id');

        $this->load->library("Uploadhandler_generic", array(

            'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/project/', 'upload_url' => base_url() . 'userfiles/project/'

        ));

        $files = (string)$this->uploadhandler_generic->filenaam();

        if ($files != '') {

            $fid = rand(100, 9999);

            $this->projects->meta_insert($id, 9, $fid, $files);

        }





    }



    public function set_note()

    {

        $id = $this->input->post('nid');

        $stat = $this->input->post('content');

        $this->projects->setnote($id, $stat);

        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED'), 'pstatus' => 'Success'));





    }



    public function delete_file()

    {

        $fileid = $this->input->post('object_id');

        $pid = $this->input->post('project_id');

        $this->projects->deletefile($pid, $fileid);





        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));





    }



    public function delete_milestone()

    {

        $mid = $this->input->post('object_id');



        $this->projects->deletemilestone($mid);





        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));





    }





    //comm section



    public function addcomment()

    {

        $comment = $this->input->post('content');

        $pid = $this->input->post('nid');

        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'Add Comment';



        if ($this->projects->add_comment($comment, $pid, $this->aauth->get_user()->id)) {

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED')));

        } else {



            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));



        }





    }



    public function progress()

    {

        $pid = $this->input->post('pid');

        $val = $this->input->post('val');

        $this->projects->progress($pid, $val);



    }



    public function task_stats()

    {

        $id = $this->input->get('id');

        $this->projects->task_stats(intval($id));



    }

    public function service_product()

    {


        $this->load->model('units_model', 'units');
        $this->load->model('products_model', 'products');
        $data['units'] = $this->products->units();

        $head['title'] = "Yeni Ürün/Hizmet";

        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);

        $this->load->view('projects/product-add', $data);

        $this->load->view('fixed/footer');

    }

    public function addproduct()

    {

        $product_name = $this->input->post('product_name',true);
        $product_code = $this->input->post('product_code');
        $product_price = $this->input->post('product_price');
        $factoryprice = $this->input->post('fproduct_price');
        $taxrate = $this->input->post('product_tax',true);
        $disrate = $this->input->post('product_disc',true);
        $product_qty = $this->input->post('product_qty',true);
        $product_qty_alert = $this->input->post('product_qty_alert');
        $product_desc = $this->input->post('product_desc',true);
        $image = $this->input->post('image');
        $unit = $this->input->post('unit',true);
        $barcode = $this->input->post('barcode');
        $product_type = $this->input->post('product_type');
        $this->projects->addnew($product_name,
            $product_code, $product_price, $factoryprice, $taxrate,
            $disrate, $product_qty, $product_qty_alert, $product_desc,
            $image, $unit, $barcode,$product_type);


    }



    public function forma2_session()
    {
        if($_POST)
        {
            $data=array();
            $todo_list_id=$this->input->post('todolist_id');

            foreach ($todo_list_id as $key=>$value)
            {
                $gorulmus_is_forma2=$this->input->post("$value");

                $data[]=array('id'=>$value,'meta_id'=>$gorulmus_is_forma2);

            }

            $this->session->set_userdata('forma2', $data);

        }
    }

    public function session_oku()
    {
        $form_data = $this->session->userdata('forma2');
        echo "<pre>";print_r($form_data);

    }

    public function session_sil()
    {
        $this->session->unset_userdata('forma2');


    }

    public function asamalar_list_ajax()
    {
        $bolum_id=$this->input->post('bolum_id');
        $proje_id=$this->input->post('proje_id');
        $invoice_list=asama_list_rows($proje_id,$bolum_id);

        echo json_encode(array('status' => 'Success',
            'birimler'=>$invoice_list
        ));

    }

    public function update_stock(){
        $this->db->trans_start();
        $result = $this->projects->update_stock();
        if($result['status']){
            echo json_encode(array('status' => 200, 'message' =>$result['message']));
            $this->db->trans_complete();
        }
        elseif($result['status']==0) {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 410, 'message' =>$result['message']));
        }
    }

    public function salary_sort_update(){
        $this->db->trans_start();
        if (!$this->aauth->premission(73)->update) {
            echo json_encode(array('status' => 410, 'message' =>'Yetkiniz Bulunmamaktadır'));

        }
        else {
            $result = $this->projects->salary_sort_update();
            if($result['code']==200){
                $this->aauth->applog("Maaş onay Sıralaması Değiştirildi  : Proje ID : ".$this->input->post('proje_id'), $this->aauth->get_user()->username);
                echo json_encode(array('status' => 200, 'message' =>$result['text']));
                $this->db->trans_complete();
            }
            elseif($result['status']==410) {
                $this->db->trans_rollback();
                echo json_encode(array('status' => 410, 'message' =>$result['text']));
            }
        }

    }

    public function get_parent_list(){

        $id=$this->input->post('asama_id');
        $details = $this->db->query("SELECT * FROM geopos_milestones Where parent_id = $id");
        if($details->num_rows()){
            echo json_encode(array('status' => 200, 'items' =>$details->result()));
        }
        else {
            echo json_encode(array('status' => 410));
        }

    }
    public function get_parent_list_asama(){

        $id=$this->input->post('bolum_id');
        $details = $this->db->query("Select * From geopos_milestones Where bolum_id = $id");
        if($details->num_rows()){
            echo json_encode(array('status' => 200, 'items' =>$details->result()));
        }
        else {
            echo json_encode(array('status' => 410));
        }

    }


    public function proje_info(){

        $id=$this->input->post('proje_id');
        $details = $this->projects->details($id);
        echo json_encode(array('status' => 200, 'items' =>$details));
    }
    public function maas_sort_info(){

        $id=$this->input->post('proje_id');
        $details = $this->projects->maas_sort_info($id);
        echo json_encode(array('status' => 200, 'items' =>$details));
    }

}
