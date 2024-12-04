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

class Events extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();

        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $this->load->model('events_model');

    }


    public function index()
    {
        $this->load->view('fixed/header');
        $this->load->view('events/cal');
        $this->load->view('fixed/footer');


    }

    public function list_randevu()
    {
        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'Randevuler';

        $this->load->view('fixed/header', $head);

        $this->load->view('events/list_randevu');

        $this->load->view('fixed/footer');

    }

    public function randevu_load()
    {
        $list = $this->events_model->randevu_datatables();

        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $note)
        {
            $s='';
            if($note->status==0)
            {
                $s='Bekliyor';
            }
            else if($note->status==1)
            {
                $s='Görüşme Tamamlandı';
            }
            else if($note->status==2)
            {
                $s='Onaylandı';
            }
            $row = array();

            $no++;

            $row[] = $no;

            $row[] = personel_details($note->pers_id);
            $row[] = $note->kurum_firma;

            $row[] = $note->yetkkili_kisi;
            $row[] = $note->title;
            $row[] = $note->start;
            $row[] = $note->end;
            $row[] = $s;
            // $row[] = '<a href="editnote?id=' . $note->id . '" class="btn btn-info btn-sm"><span class="icon-eye"></span> ' . $this->lang->line('View') . '</a> <a class="btn btn-danger btn-sm delete-object" href="#" data-object-id="' . $note->id . '"> <i class="icon-trash "></i> </a>';
            $row[] = '<a href="/events/editrandevu?id=' . $note->id . '" class="btn btn-info btn-sm">Düzenle</a> ';
            $row[] = $note->g_baslama_date;
            $row[] = $note->g_bitis_date;
            $data[] = $row;
        }

        $output = array(

            "draw" => $_POST['draw'],

            "recordsTotal" => $this->events_model->randevu_count_all(),

            "recordsFiltered" => $this->events_model->randevu_count_filtered(),

            "data" => $data,

        );

        echo json_encode($output);

    }

    public function addrandevu()
    {
        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'Randevu Ekle';

        $this->load->view('fixed/header', $head);

        $this->load->view('events/addrandevu');

        $this->load->view('fixed/footer');
    }

   public function editrandevu()
    {
        $id=$this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;

        $head['title'] = 'Randevu Düzenle';

        $this->load->view('fixed/header', $head);

        $data['details']=$this->events_model->get_event($id);


        $this->load->view('events/editrandevu',$data);

        $this->load->view('fixed/footer');
    }

    /*Get all Events */

    public function getEvents()
    {
        $start = $this->input->get('start');
        $end = $this->input->get('end');
        $user_id = $this->aauth->get_user()->id;
        $loc = $this->aauth->get_user()->loc;

        $result = $this->events_model->getEvents($start, $end,$user_id,$loc);

        echo json_encode($result);
    }

    public function addEventT()
    {
       // $query=$this->db->query("")

        $baslangic = $this->input->post('baslangic',true);
        $date =explode('T',$baslangic);
        $etkinlik_saati =  $date[0].' '.$date[1].':00';
        $etkinlik_saati_rel =  $date[1];


        $bitis = $this->input->post('bitis',true);
        $date_b =explode('T',$bitis);
        $etkinlik_saati_bitis =  $date_b[0].' '.$date_b[1].':00';
        $etkinlik_saati_bitis_rel =  $date_b[1];



        $bas=$date[0].' '.$date[1];
        $bit=$date_b[0].' '.$date_b[1];

        $kontrol_bas=$this->db->query("SELECT * FROM geopos_events Where etkinlik_saati='$bas'");
        $kontrol_bit=$this->db->query("SELECT * FROM geopos_events Where etkinlik_saati_bitis='$bit'");

        if($kontrol_bas->num_rows()>0)
        {
            echo json_encode(array('status' => 'Error', 'message' => 'Seçtiğiniz Randevu Başlangıç Tarihi Doludur'));
        }
        else if($kontrol_bit->num_rows()>0)
        {
            echo json_encode(array('status' => 'Error', 'message' => 'Seçtiğiniz Randevu Bitiş Tarihi Doludur'));
        }
        else
            {
                $title = $this->input->post('title',true);




                $kurum_firma = $this->input->post('kurum_firma',true);
                $yetkkili_kisi = $this->input->post('yetkkili_kisi',true);
                $telefon = $this->input->post('telefon',true);
                $cari_id = $this->input->post('cari_id',true);
                $adres_id = $this->input->post('adres_id',true);


                $personel_l = $this->input->post('personel_l',true);
                $status = $this->input->post('status',true);

                $description = $this->input->post('description',true);
                $color = '#3a87ad';
                $user_id = $this->aauth->get_user()->id;
                $loc = $this->aauth->get_user()->loc;


                $result = $this->events_model->addEvent($title, $etkinlik_saati, $etkinlik_saati_bitis, $description, $color,$etkinlik_saati,$etkinlik_saati_rel,$personel_l,$user_id,$loc,$etkinlik_saati_bitis,$etkinlik_saati_bitis_rel,$kurum_firma,$yetkkili_kisi,$telefon,$status,$cari_id,$adres_id);

                if ($result) {

                    echo json_encode(array('status' => 'Success', 'message' => 'Başarıyla Oluşturuldu'));

                } else {

                    echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

                }
            }




    }

    public function updateEventT()
    {
        $g_etkinlik_saati_baslangic='';
        $g_etkinlik_saati_bitis='';
        $g_etkinlik_saati_bitis_rel='';
        $g_etkinlik_saati_baslangic_rel='';
       // $query=$this->db->query("")

        $id = $this->input->post('id',true);
        $baslangic = $this->input->post('baslangic',true);
        $date =explode('T',$baslangic);

        $etkinlik_saati =  $date[0].' '.$date[1].':00';
        $etkinlik_saati_rel =  $date[1];


        $bitis = $this->input->post('bitis',true);
        $date_b =explode('T',$bitis);
        $etkinlik_saati_bitis =  $date_b[0].' '.$date_b[1].':00';
        $etkinlik_saati_bitis_rel =  $date_b[1];


        if($this->input->post('g_baslangic')!='')
        {
            $g_bitis = $this->input->post('g_bitis',true);
            $g_date_b =explode('T',$g_bitis);
            $g_etkinlik_saati_bitis =  $g_date_b[0].' '.$g_date_b[1].':00';
            $g_etkinlik_saati_bitis_rel =  $g_date_b[1];


            $g_baslangic = $this->input->post('g_baslangic',true);
            $g_date_baslangic =explode('T',$g_baslangic);
            $g_etkinlik_saati_baslangic =  $g_date_baslangic[0].' '.$g_date_baslangic[1].':00';
            $g_etkinlik_saati_baslangic_rel =  $g_date_baslangic[1];
        }
        else
            {
                $g_etkinlik_saati_baslangic=$etkinlik_saati;
                $g_etkinlik_saati_bitis=$etkinlik_saati_bitis;
                $g_etkinlik_saati_bitis_rel=$etkinlik_saati_bitis_rel;
                $g_etkinlik_saati_baslangic_rel=$etkinlik_saati_rel;
            }



        $title = $this->input->post('title',true);




        $kurum_firma = $this->input->post('kurum_firma',true);
        $yetkkili_kisi = $this->input->post('yetkkili_kisi',true);
        $telefon = $this->input->post('telefon',true);
        $personel_l = $this->input->post('personel_l',true);
        $status = $this->input->post('status',true);
        $cari_id = $this->input->post('cari_id',true);
        $description = $this->input->post('description',true);
        $color = '#3a87ad';
        $user_id = $this->aauth->get_user()->id;
        $loc = $this->aauth->get_user()->loc;

        $personel_yen = $this->input->post('personel_yen');

        if($status==2)
        {
            $detay = $this->db->query("SELECT * FROM geopos_events WHERE  id=$id")->row();

            $pers_id=$detay->pers_id;
            $pers_name = personel_details($pers_id);
            $tel_no=$detay->telefon;
            $yetkili=$detay->yetkkili_kisi;
            $etkinlik_saati=dateformat($detay->start).' '.$detay->etkinlik_saati_rel;
            $etkinlik_saati_bitis=dateformat($detay->end).' '.$detay->etkinlik_saati_bitis_rel;

            $mesaj = "Sayın ".$yetkili." ".$etkinlik_saati." ile ".$etkinlik_saati_bitis." arasında ". $pers_name." ile randevunuz basarıyla olusturulmustur.Randevu saatinden 15 dk once orada olunuz.Iyi Gunler Dileriz.";

            if(isset($personel_yen))
            {
                foreach ($personel_yen as $key=>$pers)
                {
                    $this->db->set('pers_id', $personel_yen[$key]);
                    $this->db->where('event_id', $id);
                    $this->db->update('geopos_events_pers');

                    $mobile_ = personel_detailsa($personel_yen[$key])['phone'];
                    $namess = personel_detailsa($personel_yen[$key])['name'];
                    $mesajt = "Sayın ".$namess." ".$etkinlik_saati." ile ".$etkinlik_saati_bitis." arasında ". $pers_name." ile randevunuz olusturulmustur.Randevu saatinden 10 dk once orada olunuz.";

                    $this->mesaj_gonder($mobile_,$mesajt);

                }
            }

            $randevu_sahibi_tel = personel_detailsa($personel_l)['phone'];
            $randevu_sahibi_name = personel_detailsa($personel_l)['name'];

            if($personel_l!=61)
            {
                $mesaj_rand = "Sayın ".$randevu_sahibi_name." Lokman Biter Tarafından, ".$etkinlik_saati." ile ".$etkinlik_saati_bitis." arasında ". $detay->yetkkili_kisi." ile randevunuz basarıyla olusturulmustur.Iyi Gunler Dileriz.";

                $mesages = $this->mesaj_gonder($randevu_sahibi_tel,$mesaj_rand);
            }


            $mesages = $this->mesaj_gonder($tel_no,$mesaj);



        }

        else if($status==3)
        {
            $detay = $this->db->query("SELECT * FROM geopos_events WHERE  id=$id")->row();

            $pers_id=$detay->pers_id;
            $pers_name = personel_details($pers_id);
            $tel_no=$detay->telefon;
            $yetkili=$detay->yetkkili_kisi;
            $etkinlik_saati=dateformat($detay->start).' '.$detay->etkinlik_saati_rel;
            $etkinlik_saati_bitis=dateformat($detay->end).' '.$detay->etkinlik_saati_bitis_rel;

            $mesaj = "Sayın ".$yetkili." randevunuz ertelenmistir. ".$etkinlik_saati." ile ".$etkinlik_saati_bitis." arasında ". $pers_name." ile randevunuz basarıyla olusturulmustur.Randevu saatinden 15 dk once orada olunuz.Iyi Gunler Dileriz.";

            if(isset($personel_yen))
            {
                foreach ($personel_yen as $key=>$pers)
                {
                    $this->db->set('pers_id', $personel_yen[$key]);
                    $this->db->where('event_id', $id);
                    $this->db->update('geopos_events_pers');

                    $mobile_ = personel_detailsa($personel_yen[$key])['phone'];
                    $namess = personel_detailsa($personel_yen[$key])['name'];
                    $mesajt = "Sayın ".$namess." randevunuz ertelenmistir. ".$etkinlik_saati." ile ".$etkinlik_saati_bitis." arasında ". $pers_name." ile randevunuz olusturulmustur.Randevu saatinden 10 dk once orada olunuz.";

                    $this->mesaj_gonder($mobile_,$mesajt);

                }
            }

            $randevu_sahibi_tel = personel_detailsa($personel_l)['phone'];
            $randevu_sahibi_name = personel_detailsa($personel_l)['name'];

            if($personel_l!=61)
            {
                $mesaj_rand = "Sayın ".$randevu_sahibi_name." Lokman Biter Tarafından, ".$etkinlik_saati." ile ".$etkinlik_saati_bitis." arasında ". $detay->yetkkili_kisi." ile randevunuz ertelenmistir.Iyi Gunler Dileriz.";

                $mesages = $this->mesaj_gonder($randevu_sahibi_tel,$mesaj_rand);
            }


            $mesages = $this->mesaj_gonder($tel_no,$mesaj);



        }

        else if($status==4)
        {
            $detay = $this->db->query("SELECT * FROM geopos_events WHERE  id=$id")->row();

            $pers_id=$detay->pers_id;
            $pers_name = personel_details($pers_id);
            $tel_no=$detay->telefon;
            $yetkili=$detay->yetkkili_kisi;
            $etkinlik_saati=dateformat($detay->start).' '.$detay->etkinlik_saati_rel;
            $etkinlik_saati_bitis=dateformat($detay->end).' '.$detay->etkinlik_saati_bitis_rel;

            $mesaj = "Sayın ".$yetkili.". ".$etkinlik_saati." ile ".$etkinlik_saati_bitis." arasında ". $pers_name." ile randevunuz yogunluk nedeni ile iptal edilmistir..Iyi Gunler Dileriz.";

            if(isset($personel_yen))
            {
                foreach ($personel_yen as $key=>$pers)
                {
                    $this->db->set('pers_id', $personel_yen[$key]);
                    $this->db->where('event_id', $id);
                    $this->db->update('geopos_events_pers');

                    $mobile_ = personel_detailsa($personel_yen[$key])['phone'];
                    $namess = personel_detailsa($personel_yen[$key])['name'];
                    $mesajt = "Sayın ".$namess." ".$etkinlik_saati." ile ".$etkinlik_saati_bitis." arasında ". $pers_name." ile randevunuz yogunluk nedeni ile iptal edilmistir..Iyi Gunler Dileriz.";

                    $this->mesaj_gonder($mobile_,$mesajt);

                }
            }

            $randevu_sahibi_tel = personel_detailsa($personel_l)['phone'];
            $randevu_sahibi_name = personel_detailsa($personel_l)['name'];

            if($personel_l!=61)
            {
                $mesaj_rand = "Sayın ".$randevu_sahibi_name." Lokman Biter Tarafından, ".$etkinlik_saati." ile ".$etkinlik_saati_bitis." arasında ". $detay->yetkkili_kisi." ile randevunuz yogunluk nedeni ile iptal edilmistir.";

                $mesages = $this->mesaj_gonder($randevu_sahibi_tel,$mesaj_rand);
            }


            $mesages = $this->mesaj_gonder($tel_no,$mesaj);



        }


        $result = $this->events_model->updateEvent($id, $title, $etkinlik_saati, $etkinlik_saati_bitis, $description,
            $color,$etkinlik_saati,$etkinlik_saati_rel,$personel_l,$user_id,$loc,$status,$etkinlik_saati_bitis,
            $etkinlik_saati_bitis_rel,$kurum_firma,$yetkkili_kisi,$telefon,$cari_id,$g_etkinlik_saati_baslangic,
            $g_etkinlik_saati_bitis,$g_etkinlik_saati_bitis_rel,$g_etkinlik_saati_baslangic_rel);

        if ($result) {



            echo json_encode(array('status' => 'Success', 'message' => 'Başarıyla Güncellendi'));

        } else {

            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));

        }


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

    /*Add new event */
    public function addEvent()
    {




        $personel_id=array();
        $title = $this->input->post('title',true);
        $start = $this->input->post('start',true);
        $etkinlik_saati = $this->input->post('etkinlik_saati',true);
        $etkinlik_saati_rel = $this->input->post('etkinlik_saati',true);


        $etkinlik_saati_bitis = $this->input->post('etkinlik_saati_bitis',true);
        $etkinlik_saati_bitis_rel = $this->input->post('etkinlik_saati_bitis',true);

        $kurum_firma = $this->input->post('kurum_firma',true);
        $yetkkili_kisi = $this->input->post('yetkkili_kisi',true);
        $telefon = $this->input->post('telefon',true);


        $personel_l = $this->input->post('personel_l',true);
        $end = $this->input->post('end',true);
        $description = $this->input->post('description',true);
        $color = $this->input->post('color');
        $user_id = $this->aauth->get_user()->id;
        $loc = $this->aauth->get_user()->loc;







        $format_start=date_ajanda($start);
        $etkinlik_saati=$format_start.' '.$etkinlik_saati.':00';
        $etkinlik_saati_bitis=$format_start.' '.$etkinlik_saati_bitis.':00';

        $result = $this->events_model->addEvent($title, $etkinlik_saati, $etkinlik_saati_bitis, $description, $color,$etkinlik_saati,$etkinlik_saati_rel,$personel_l,$user_id,$loc,$etkinlik_saati_bitis,$etkinlik_saati_bitis_rel,$kurum_firma,$yetkkili_kisi,$telefon);

    }

    /*Update Event */
    /*Update Event */
    public function updateEvent()
    {
        $id = $this->input->post('id');

        $personel_id=array();
        $title = $this->input->post('title',true);
        $start = $this->input->post('start',true);
        $etkinlik_saati = $this->input->post('etkinlik_saati',true);
        $status = $this->input->post('status',true);
        $etkinlik_saati_rel = $this->input->post('etkinlik_saati',true);

        $etkinlik_saati_bitis = $this->input->post('etkinlik_saati_bitis',true);
        $etkinlik_saati_bitis_rel = $this->input->post('etkinlik_saati_bitis',true);

        $kurum_firma = $this->input->post('kurum_firma',true);
        $yetkkili_kisi = $this->input->post('yetkkili_kisi',true);
        $telefon = $this->input->post('telefon',true);

        $personel_l = $this->input->post('personel_l',true);
        $end = $this->input->post('end',true);
        $description = $this->input->post('description',true);
        $color = $this->input->post('color');
        $user_id = $this->aauth->get_user()->id;
        $loc = $this->aauth->get_user()->loc;




        $this->db->select('*');

        $this->db->from('geopos_events');

        $this->db->order_by('id', 'DESC');

        $this->db->where('user_id', $user_id);
        $this->db->where('id', $id);

        $querys = $this->db->get();
        $format_start=date_ajanda($start);
        $format_end=date_ajanda($end);



        if($querys->num_rows()>0)
        {
           /* $query=$this->db->query('SELECT * FROM geopos_events WHERE  id='.$id)->row_array();
            $start=$query['start'];



            $format_start=date_ajanda($start);
            $etkinlik_saati2=$format_start.' '.$etkinlik_saati.':00';
           */


            $etkinlik_saati=$format_start.' '.$etkinlik_saati.':00';
            $etkinlik_saati_bitis=$format_start.' '.$etkinlik_saati_bitis.':00';

            $result = $this->events_model->updateEvent($id, $title, $etkinlik_saati, $etkinlik_saati_bitis, $description, $color,$etkinlik_saati,$etkinlik_saati_rel,$personel_l,$user_id,$loc,$status,$etkinlik_saati_bitis,$etkinlik_saati_bitis_rel,$kurum_firma,$yetkkili_kisi,$telefon);

        }
        else
        {
            echo 'Yetkiniz Bulunmamaktadır';

            exit;
        }


    }

    /*Delete Event*/
    public function deleteEvent()
    {
        $result = $this->events_model->deleteEvent();
        echo $result;
    }

    public function dragUpdateEvent()
    {

        $result = $this->events_model->dragUpdateEvent();
        echo $result;
    }
    public function pers_name()
    {

        $pers_id = $this->input->post('pers_id', true);
        $query=$this->db->query('SELECT * FROM geopos_employees WHERE  id='.$pers_id)->row_array();
        $name=$query['name'];
        echo $name;
    }

}
