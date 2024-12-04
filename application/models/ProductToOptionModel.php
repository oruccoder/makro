<?php

use Mpdf\Tag\Input;

defined('BASEPATH') or exit('No direct script access allowed');


class ProductToOptionModel extends CI_Model
{

    var $column_order = array('product_to_options.product_id', 'product_to_options.product_option_value_id', 'product_to_options.description');

    var $column_search = array('product_to_options.product_id', 'product_to_options.product_option_value_id', 'product_to_options.description');

    // var $column_search_transfer = [
    //     'stock_transfer.code',
    //     'stock_transfer.out_warehouse_id',
    //     'stock_transfer.in_warehouse_id',
    //     'geopos_products.product_name',
    //     'stock_transfer_items.qty',
    //     'geopos_units.name',
    //     'stock_transfer_item_notification.new_qty',
    //     'stock_transfer_items.desc',
    //     'geopos_employees.name'
    // ];

    // var $order = array('stock_transfer.id' => 'DESC');
    // var $mahsul = array('products.id' => 'DESC');


    public function __construct()
    {
        parent::__construct();
    }


    public function get_datatables_query_details_list()
    {
        $this->_get_datatables_query_details_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();
    }


    private function _get_datatables_query_details_list()
    {

        $this->db->select('product_to_options.* , products.name as product_name , product_option_value.name as product_option_value_name');
        $this->db->from('product_to_options');
        $this->db->where('product_to_options.deleted_at', NULL, FALSE);

        $this->db->join('products', 'product_to_options.product_id = products.id', 'left');
        $this->db->where('products.deleted_at', NULL, FALSE);

        $this->db->join('product_option_value', 'product_to_options.product_option_value_id = product_option_value.id', 'left');
        $this->db->where('product_option_value.deleted_at', NULL, FALSE);

        // products.id as main_product_id , product_option_value.id as main_product_option_value_id , products.description as product_description , product_option_value.description as product_option_value_description
        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, $_POST['search']['value']);
                } else {

                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;
        }

        $search = $this->input->post('order');

        if ($search) {

            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->urun)) {

            $this->db->order_by($this->urun);
        }
    }


    public function count_filtered()
    {
        $this->_get_datatables_query_details_list();
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_all()
    {
        $this->_get_datatables_query_details_list();
        return $this->db->count_all_results();
    }


    public function get_datatables_query_transfer_list()
    {
        $this->_get_datatables_query_transfer_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();
    }


    private function _get_datatables_query_transfer_list()
    {

        $this->db->select('stock_transfer_items.id as item_id,stock_transfer.id as stock_id,stock_transfer_item_notification.type,stock_transfer_item_notification.id,stock_transfer.code,stock_transfer.out_warehouse_id,stock_transfer.in_warehouse_id,geopos_products.product_name,stock_transfer_items.qty,geopos_units.name as unit_name,stock_transfer_item_notification.new_qty,stock_transfer_items.`desc`,geopos_employees.name as pers_name');
        $this->db->from('stock_transfer_item_notification');
        $this->db->join('stock_transfer', 'stock_transfer_item_notification.stock_id=stock_transfer.id');
        $this->db->join('stock_transfer_items', 'stock_transfer_item_notification.stock_item_id=stock_transfer_items.id');
        $this->db->join('geopos_units', 'stock_transfer_items.unit_id=geopos_units.id');
        $this->db->join('geopos_products', 'stock_transfer_items.product_id=geopos_products.pid');
        $this->db->join('geopos_employees', 'stock_transfer.aauth_id = geopos_employees.id');
        $this->db->where('stock_transfer_item_notification.staff_id', $this->aauth->get_user()->id);
        $this->db->where('stock_transfer_item_notification.staff_status', 1);
        $this->db->where('stock_transfer_item_notification.status', 0);
        $i = 0;

        foreach ($this->column_search_transfer as $item) // loop column

        {
            if ($_POST['search']['value']) // if datatable send POST for search

            {
                if ($i === 0) // first loop

                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.

                    $this->db->like($item, $_POST['search']['value']);
                } else {

                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search_transfer) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;
        }
        $this->db->order_by('`stock_transfer_item_notification`.`id` DESC');
    }


    public function count_all_transfer()
    {
        $this->_get_datatables_query_transfer_list();
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_filtered_transfer()
    {
        $this->_get_datatables_query_transfer_list();
        return $this->db->count_all_results();
    }


    public function stock_transfer_notification_create($stock_id, $type, $new_qty = 0, $status = 0, $staff_id, $staff_status = null)
    {
        $item_details = $this->details_item($stock_id);
        $details = $this->details($stock_id);
        $product_list = [];
        $i = 0;
        foreach ($item_details as $value) {
            $data = array(
                'stock_id' => $stock_id,
                'stock_item_id' => $value->id,
                'type' => $type,
                'new_qty' => $new_qty,
                'status' => $status,
                'staff_status' => $staff_status,
                'staff_id' => $staff_id,
                'aauth_id' => $this->aauth->get_user()->id
            );
            $product_list[$i] = $data;
            $i++;
        }

        if ($i) {
            $this->db->insert_batch('stock_transfer_item_notification', $product_list);
            $this->aauth->applog("Stok Bildirimi OLuşturuldu  " . $details->code, $this->aauth->get_user()->username);
            return [
                'status' => 1,
                'id' => $stock_id
            ];
        } else {
            return [
                'status' => 0,
                'id' => 0
            ];
        }
    }


    public function create_save()
    {

        $data = array(
            'product_id' =>  $this->input->post('product_id'),
            'product_option_value_id' => $this->input->post('product_option_value_id'),
            'description' =>  $this->input->post('description'),
            'created_at' => date('Y-m-d H:i:s'),
        );


        if ($this->db->insert('product_to_options', $data)) {
            return [
                'status' => 1,
            ];
        } else {
            return [
                'status' => 0,
            ];
        }
    }


    public function update()
    {

        $id =  $this->input->post('id');

        $data = array(
            'product_id' =>  $this->input->post('product_id'),
            'product_option_value_id' => $this->input->post('product_option_value_id'),
            'description' => $this->input->post('description'),
            'updated_at' => date('Y-m-d H:i:s'),
        );


        if ($this->db->where(['id' => $id])->update('product_to_options', $data)) {
            return [
                'status' => 1,
            ];
        } else {
            return [
                'status' => 0,
            ];
        }
    }


    public function delete()
    {
        $id =  $this->input->post('id');

        if ($this->db->where(['id' => $id])->update('product_to_options', ['deleted_at' => date('Y-m-d H:i:s')])) {
            return [
                'status' => 1,
            ];
        } else {
            return [
                'status' => 0,
            ];
        }
    }


    public function details_item($id)
    {
        $this->db->select('*');
        $this->db->from('product_to_options');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }


    public function details($id)
    {
        $this->db->select('*');
        $this->db->from('product_to_options');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }



    // public function getValue($id)
    // {

    //     $this->db->select('product_options.* , product_option_value.id as value_id , product_option_value.name as value_name , product_option_value.description as value_description');
    //     $this->db->from('product_options');
    //     $this->db->where('product_options.id', $id);
    //     $this->db->join('product_option_value', 'product_options.id = product_option_value.product_option_id', 'left');
    //     $this->db->where('product_option_value.deleted_at', NULL, FALSE);

    //     $query = $this->db->get();

    //     return $query->result();
    // }





























    public function transfer_update()
    {
        $product_details =  $this->input->post('product_details');
        $tip =  $this->input->post('tip'); //1 onay 2 iptal

        $product_list = [];
        $index = 0;


        foreach ($product_details as $items) {

            $stock_id = $items['stock_id'];
            $this->aauth->applog("Stok Transfer Talebi Güncellendi NT_ID" . $items['notifation_id'], $this->aauth->get_user()->username);
            $data_new_update = [
                'new_qty' => $items['new_qty'],
                'staff_status' => null,
                'status' => $tip,
                'id' => $items['notifation_id']
            ];
            $product_list[$index] = $data_new_update;
            $index++;
            $this->db->update_batch('stock_transfer_item_notification', $product_list, 'id');

            if ($items['type_id'] == 2) // Giriş İse Stok Güncellemesi
            {

                if ($tip == 1) // Kabul edildiyse
                {
                    $notifation_details = $this->notifation_details($items['notifation_id']);
                    $item_details = $this->item_details($notifation_details->stock_item_id);
                    $details = $this->details($item_details->stock_transfer_id);
                    $giris_depo_id = $details->in_warehouse_id;
                    $cikis_depo_id = $details->out_warehouse_id;
                    stock_update_new($item_details->product_id, $item_details->unit_id, $items['new_qty'], 1, $giris_depo_id, $this->aauth->get_user()->id, $item_details->stock_transfer_id, 4);
                    stock_update_new($item_details->product_id, $item_details->unit_id, $items['new_qty'], 0, $cikis_depo_id, $this->aauth->get_user()->id, $item_details->stock_transfer_id, 4);
                }
            } elseif ($items['type_id'] == 1) { // Çıkış Güncellemesi ise giriş deposuna mail bildir
                $data_update = array(
                    'staff_status' => 1
                );
                $this->db->where('stock_id=', $stock_id);
                $this->db->where('status', 0);
                $this->db->update('stock_transfer_item_notification', $data_update);

                // İptal varsa
                $iptal_kontrol = $this->db->query("SELECT * FROM stock_transfer_item_notification Where status=2");
                if ($iptal_kontrol->num_rows()) {
                    foreach ($iptal_kontrol as $result) {
                        $data_new_update = [
                            'staff_status' => null,
                        ];
                        $this->db->where("id", $result->id);
                        $this->db->update('stock_transfer_item_notification', $data_new_update);
                    }
                }
                // İptal varsa
            }
        }


        //$this->stocktransfer->send_mail($staff_id_cikis,'Mahsul Giriş Talebi','Yeni Bir Giriş Talebi Oluşturuldu İncelemek İçin Bildirimler Bölümüne Bakınız');



        if ($index) {
            return [
                'status' => 1,
                'message' => 'Başarılı Bir Şekilde Stok Transfer Talebi Güncellendi',
            ];
        } else {
            return [
                'status' => 0,
                'message' => 'Hata Aldınız.Lütfen Yöneyiciye Başvurun.',
                'id' => 0
            ];
        }
    }

    public function bildirim_olustur()
    {
        $talep_id = $this->input->post('talep_id');
        $this->db->set('bildirim_durumu', 1);
        $this->db->where('id', $talep_id);
        if ($this->db->update('stock_transfer')) {
            $this->aauth->applog("Stok Transfer Talep Bildirimi Oluşturuldu  : Talep ID : " . $talep_id, $this->aauth->get_user()->username);
            return 1;
        } else {
            return 0;
        }
    }


    public function notifation_details($id)
    {
        $this->db->select('*');
        $this->db->from('stock_transfer_item_notification');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function item_details($id)
    {
        $this->db->select('*');
        $this->db->from('stock_transfer_items');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function send_mail($user_id, $subject, $message)
    {
        $message .= "<br><br><br><br>";
        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
        $proje_sorumlusu_email = personel_detailsa($user_id)['email'];
        //$recipients = array($proje_sorumlusu_email);
        //$this->communication_model->onay_mail($recipients, $subject, $message, false,'', 'gider_talep_onay_maili');
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.yandex.com',
            'smtp_port' => 465,
            'smtp_user' => 'Makro2000 ERP',
            'smtp_pass' => 'bulut220618',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => true,
        ];
        $this->load->library('Email', $config);

        $this->email->from('info@makropro.az');
        $this->email->to($proje_sorumlusu_email);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }
}
