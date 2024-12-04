<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lojistikgun Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->helper('cookie');
        $this->load->database('default');
        $this->load->model('communication_model');
        $this->load->model('lojistikgun_model', 'lojistik');
        $this->load->model('lojistikcar_model', 'lojistik_car');
        $this->load->library("Common");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function ajax_list()
    {

        $lojistik_id = $this->input->post('id');
        $list = $this->lojistik->get_datatables_details($lojistik_id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {

            $islem= "<button class='btn btn-warning update_gun' lojistik_id ='$lojistik_id'  gun_id='$prd->id' type='button'><i class='fa fa-edit'></i></button>&nbsp;";
            $islem.= "&nbsp;<button class='btn btn-danger delete_gun'  lojistik_id ='$lojistik_id'  gun_id='$prd->id' type='button'><i class='fa fa-trash'></i></button>&nbsp;";
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $prd->arac_name;
            $row[] = $prd->gun_sayisi;
            $row[] = amountFormat($prd->unit_price);
            $row[] = amountFormat($prd->total_price);
            $row[] = $islem;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->lojistik->count_all($lojistik_id),
            "recordsFiltered" => $this->lojistik->count_filtered($lojistik_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function create_gun(){
        $lojistik_id = $this->input->post('lojistik_id');
        $arac_id = $this->input->post('arac_id');
        $sf_lokasyon_id = $this->input->post('sf_lokasyon_id');
        $desc = $this->input->post('desc');
        $gun_sayisi = $this->input->post('gun_sayisi');
        $price = $this->input->post('price');
        $this->db->trans_start();

        $total_price = floatval($price)*floatval($gun_sayisi);
        $data = array(
            'lojistik_id' => $lojistik_id,
            'gun_sayisi' => $gun_sayisi,
            'unit_price' => $price,
            'total_price' => $total_price,
            'desc' => $desc,
            'lsf_id' => $sf_lokasyon_id,
            'arac_id' => $arac_id,
            'aauth_id' => $this->aauth->get_user()->id,
        );
        if($this->db->insert(' lojistik_to_gun ', $data)){
            $last_id = $this->db->insert_id();

            $details = $this->db->query("SELECT * FROM lojistik_satinalma_talep Where id=$lojistik_id")->row();

            $this->aauth->applog("Lojistik Gün Sayısı Oluşturuldu : " . $last_id.' Lojistik ID : '.$lojistik_id, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Bilgiler Eklendi"));
            $this->db->trans_complete();

        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }

    }

    public function gun_get_info_edit(){
        $lojistik_id = $this->input->post('lojistik_id');
        $gun_id = $this->input->post('gun_id');


        $location_details=[];
        $query2 = $this->db->query("SELECT sf_item_id FROM satinalma_location  Where satinalma_location.lojistik_id=$lojistik_id GROUP BY `satinalma_location`.`sf_item_id`");
        if($query2->num_rows()){
            foreach ($query2->result() as $value){
                $location_details[]=[
                    'id'=>$value->sf_item_id,
                    'location'=>location_name($value->sf_item_id)
                ];
            }
        }
        $araclar = $this->lojistik->satinalma_araclar($lojistik_id);
        $gun_details = $this->db->query("SELECT * FROM  lojistik_to_gun  Where id=$gun_id")->row();
        echo json_encode((array('status'=>'Status','items'=>$location_details,'araclar'=>$araclar,'gun_details'=>$gun_details)));
    }

    public function update_gun(){
        $gun_id = $this->input->post('gun_id');
        $lojistik_id = $this->input->post('lojistik_id');
        $arac_id = $this->input->post('arac_id');
        $sf_lokasyon_id = $this->input->post('sf_lokasyon_id');
        $desc = $this->input->post('desc');
        $gun_sayisi = $this->input->post('gun_sayisi');
        $price = $this->input->post('price');
        $this->db->trans_start();
        $total_price = floatval($price)*floatval($gun_sayisi);
        $data = array(
            'lojistik_id' => $lojistik_id,
            'gun_sayisi' => $gun_sayisi,
            'unit_price' => $price,
            'total_price' => $total_price,
            'desc' => $desc,
            'lsf_id' => $sf_lokasyon_id,
            'arac_id' => $arac_id,
        );
        $this->db->set($data);
        $this->db->where('id',$gun_id);
        if($this->db->update(' lojistik_to_gun ', $data)){
            $last_id = $gun_id;
            $this->aauth->applog("Lojistik Gün Düzenlendi : " . $last_id.' Lojistik ID : '.$lojistik_id, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Bilgiler Düzenlendi"));
            $this->db->trans_complete();
        }
        else {
            $this->db->trans_rollback();
            echo json_encode(array('status' => 'Error', 'message' =>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."));
        }

    }

    public function gun_sil(){
        $lojistik_id = $this->input->post('lojistik_id');
        $gun_id = $this->input->post('gun_id');
        if( $this->db->delete('lojistik_to_gun', array('id' => $gun_id)))
        {
            $this->aauth->applog("Lojistik Gün Bilgisi Silindi : " . $gun_id.' Lojistik ID : '.$lojistik_id, $this->aauth->get_user()->username);
            echo json_encode(array('status' => 'Success', 'message' =>"Başarılı Bir Şekilde Silindi"));
        }
    }

    public function gun_get_info(){
        $lojistik_id = $this->input->post('lojistik_id');

        $location_details=[];
        $query2 = $this->db->query("SELECT sf_item_id FROM satinalma_location  Where satinalma_location.lojistik_id=$lojistik_id GROUP BY `satinalma_location`.`sf_item_id`");
        if($query2->num_rows()){
            foreach ($query2->result() as $value){
                $location_details[]=[
                  'id'=>$value->sf_item_id,
                  'location'=>location_name($value->sf_item_id)
              ];
            }
        }



        $araclar = $this->lojistik->satinalma_araclar($lojistik_id);
        echo json_encode((array('status'=>'Status','items'=>$location_details,'araclar'=>$araclar)));
    }


    public function ajax_list_personel()
    {

        $lojistik_id = $this->input->post('id');
        $list = $this->lojistik->get_datatables_details_personel($lojistik_id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = personel_details($prd->user_id);
            $row[] = arac_view($prd->arac_id)->name;
            $row[] = arac_history_status($prd->status)->name;
            $row[] = $prd->created_at;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->lojistik->count_all_personel($lojistik_id),
            "recordsFiltered" => $this->lojistik->count_filtered_personel($lojistik_id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
}
