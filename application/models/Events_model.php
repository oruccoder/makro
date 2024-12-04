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



class Events_model extends CI_Model

{


    var $column_order = array(null,'kurum_firma', 'yetkkili_kisi', 'title', 'yetkkili_kisi', 'start','end');

    var $column_search = array('title', 'description', 'kurum_firma','yetkkili_kisi','telefon');

    var $notecolumn_order = array(null,'kurum_firma', 'yetkkili_kisi', 'title', 'yetkkili_kisi', 'start','end');

    var $notecolumn_search =array('title', 'description', 'kurum_firma','yetkkili_kisi','telefon');


    var $order = array('id' => 'DESC');


    /*Read the data from DB */

    public function getEvents($start, $end,$user_id,$loc)

    {



        //eğer personel ıd içinde veya user_id içinde kullanıcının ıd mevcut ise veya pers_id boş ise etkinliği kendisi oluşturmuş ise
        // ajandada görünecek
        // değilse gözükmeyecek

        $sql = $this->db->query("SELECT  `id`, title,description,`color` ,`start`,`end`,`allDay`,`rel`,`rid`,`etkinlik_saati` ,`etkinlik_saati_rel`,`etkinlik_saati_bitis` ,`etkinlik_saati_bitis_rel`,`pers_id` ,`user_id` ,`loc`,kurum_firma,yetkkili_kisi,telefon,status  FROM geopos_events where ( pers_id LIKE '%$user_id%' or user_id=$user_id ) ORDER BY geopos_events.etkinlik_saati ASC");

        $query = $sql->result();
        return $query;

    }



    /*Create new events */



    public function addEvent($title, $start, $end, $description, $color,$etlinlik_saati,$etkinlik_saati_rel,$personel_l,$user_id,$loc,$etkinlik_saati_bitis,$etkinlik_saati_bitis_rel,$kurum_firma,$yetkkili_kisi,$telefon,$status=0,$cari_id,$adres_id=1)

    {





        $data = array(

            'title' => $title,
            'start' => $start,
            'end' => $end,
            'etkinlik_saati' => $etlinlik_saati,
            'etkinlik_saati_rel' => $etkinlik_saati_rel,
            'etkinlik_saati_bitis' => $etkinlik_saati_bitis,
            'etkinlik_saati_bitis_rel' => $etkinlik_saati_bitis_rel,
            'kurum_firma' => $kurum_firma,
            'yetkkili_kisi' => $yetkkili_kisi,
            'telefon' => $telefon,
            'description' => $description,
            'pers_id' => $personel_l,
            'color' => $color,
            'status' => $status,
            'user_id' => $user_id,
            'loc' => $loc,
            'customer_id' => $cari_id,
            'adres_id' => $adres_id,

        );



        if ($this->db->insert('geopos_events', $data)) {


            $attachmenttrue = false;

            $attachment = '';

            $subject='Randevu Bildirimi';
            $message='Merhaba, Yeni bir randevu oluşturulmuştur.Sizinde dahil olduğunuz randevuları görebilmeniz için ajandanızı kontrol ediniz.';


            $this->load->model('communication_model');

            $personels_ids=explode(',',$personel_l);
            for ($i=0;$i<count($personels_ids);$i++)
            {
                $pers_id = intval( $personels_ids[$i]);


                $userss= $this->db->query("SELECT * FROM `geopos_users` WHERE id=$pers_id")->row_array();
                $mail=$userss['email'];




                $this->communication_model->send_email($mail, $subject, $subject, $message, $attachmenttrue, $attachment);
            }


            return true;

        } else {

            return false;

        }

    }



    /*Update  event */

    public function get_event($id)
    {

        $sql = "SELECT * FROM  geopos_events WHERE id = ?";

       return $this->db->query($sql,  $id)->row();
    }




    public function updateEvent($id, $title, $start, $end, $description, $color,$etkinlik_saati,$etkinlik_saati_rel,$personel_l,
                                $user_id,$loc,$status,$etkinlik_saati_bitis,$etkinlik_saati_bitis_rel,$kurum_firma,$yetkkili_kisi,$telefon,$cari_id,
    $g_etkinlik_saati_baslangic,$g_etkinlik_saati_bitis,$g_etkinlik_saati_bitis_rel,$g_etkinlik_saati_baslangic_rel)
    {

        $data = array(

            'title' => $title,
            'start' => $start,
            'end' => $end,
            'etkinlik_saati' => $etkinlik_saati,
            'etkinlik_saati_rel' => $etkinlik_saati_rel,
            'etkinlik_saati_bitis' => $etkinlik_saati_bitis,
            'etkinlik_saati_bitis_rel' => $etkinlik_saati_bitis_rel,
            'kurum_firma' => $kurum_firma,
            'yetkkili_kisi' => $yetkkili_kisi,
            'telefon' => $telefon,
            'description' => $description,
            'pers_id' => $personel_l,
            'color' => $color,
            'user_id' => $user_id,
            'loc' => $loc,
            'status' => $status,
            'customer_id' => $cari_id,
            'g_baslama_date' => $g_etkinlik_saati_baslangic,
            'g_bitis_date' => $g_etkinlik_saati_bitis,
            'g_baslama_date_rel' => $g_etkinlik_saati_baslangic_rel,
            'g_bitis_date_rel' => $g_etkinlik_saati_bitis_rel,

        );

        $this->db->set($data);

        $this->db->where('id', $id);

        $this->db->update('geopos_events');

        return true;

    }





    /*Delete event */



    public function deleteEvent()

    {



        $sql = "DELETE FROM geopos_events WHERE id = ?";

        $this->db->query($sql, array($_GET['id']));

        return ($this->db->affected_rows() != 1) ? false : true;

    }



    /*Update  event */



    public function dragUpdateEvent()

    {



        $sql = "UPDATE geopos_events SET  geopos_events.start = ? ,geopos_events.end = ?  WHERE id = ?";

        $this->db->query($sql, array($_POST['start'], $_POST['end'], $_POST['id']));

        return ($this->db->affected_rows() != 1) ? false : true;





    }


    private function _rand_datatables_query()

    {



        $this->db->from('geopos_events');
        if($this->input->post('cid'))
        {

            $this->db->where('customer_id', $this->input->post('cid'));
        }


            $user_id = $this->aauth->get_user()->id;
//            $this->db->where('user_id', $user_id);



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

        }

        $this->db->order_by('etkinlik_saati','desc');

    }



    function randevu_datatables()

    {

        $this->_rand_datatables_query();

        if ($this->input->post('length') != -1)

            $this->db->limit($this->input->post('length'), $this->input->post('start'));

        $query = $this->db->get();

        return $query->result();

    }



    function randevu_count_filtered()

    {

        $this->_rand_datatables_query();

        $query = $this->db->get();

        return $query->num_rows();

    }



    public function randevu_count_all()

    {

        $this->_rand_datatables_query();

        $query = $this->db->get();

        return $query->num_rows();

    }




}
