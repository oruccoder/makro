<?php


defined('BASEPATH') or exit('No direct script access allowed');


class MahsulModel extends CI_Model
{
    var $table_news = 'stock_io ';

    var $column_order = array('products.name', 'products.code', 'products.description', 'products.barcode');

    var $column_search = array('products.code', 'products.name', 'geopos_product_cat.title', 'products.description', 'products.barcode');

    var $column_search_transfer = [
        'stock_transfer.code',
        'stock_transfer.out_warehouse_id',
        'stock_transfer.in_warehouse_id',
        'geopos_products.product_name',
        'stock_transfer_items.qty',
        'geopos_units.name',
        'stock_transfer_item_notification.new_qty',
        'stock_transfer_items.desc',
        'geopos_employees.name'
    ];

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

        $this->db->select('products.*,geopos_product_cat.title as cat_title');
        $this->db->from('products');
        $this->db->join('geopos_product_cat', 'products.category_id=geopos_product_cat.id');
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
        } else if (isset($this->mahsul)) {

            $this->db->order_by($this->mahsul);
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
        // $code = numaric(25);
        $product_details = $this->input->post('collection');
        $data = array(
            // 'code' => $code,
            'name' =>  $this->input->post('product_name'),
            'category_id' => $this->input->post('cat_id'),
            'unit_id' => 1,   //$this->input->post('unit_id'),
            'parent_id' => 1, //$this->input->post('parent_id'),
            'image' => 'grgregegergecsd',    //$this->input->post('image'),
            'description' => $this->input->post('product_description'),
            'code' => 423423,  //$this->input->post('code'),
            'barcode' => 432423, //$this->input->post('barcode'),
            'type' => $this->input->post('pro_type'),
        );

        $this->db->insert('products', $data);

        // if ($this->db->insert('products', $data)) {
        //     $last_id = $this->db->insert_id();
            // $this->db->set('deger', "deger+1", FALSE);
            // $this->db->where('tip', 25);
            // $this->db->update('numaric');
            // $product_list = [];
            // $index = 0;
            // if ($product_details) {
            //     foreach ($product_details as $items) {
            //         $data_item_insert = [
            //             'stock_transfer_id' => $last_id,
            //             'unit_id' => $items['unit_id'],
            //             'qty' => $items['qty'],
            //             'product_id' => $items['product_id'],
            //             'desc' => $items['desc'],
            //         ];

            //         $product_list[$index] = $data_item_insert;
            //         $index++;
            //     }
            //     $this->db->insert_batch('stock_transfer_items', $product_list);

            //     if ($index) {

            //         $this->aauth->applog("Stok Transfer Talebi Yapıldı", $this->aauth->get_user()->username);
            //         return [
            //             'status' => 1,
            //             'id' => $last_id
            //         ];
            //     } else {
            //         return [
            //             'status' => 0,
            //             'id' => 0
            //         ];
            //     }
            // }
        // }
    }



    public function update()
    {

        $transfer_id =  $this->input->post('transfer_id');
        $details = $this->details($transfer_id);
        if ($details->bildirim_durumu) {
            return [
                'status' => 0,
                'message' => 'Bildirim Başlatılmış Talepte Güncelleme Yapılamaz',
                'id' => $transfer_id
            ];
        } else {
            $code = $details->code;

            $product_details = $this->input->post('collection');
            $data = array(
                'out_warehouse_id' =>  $this->input->post('out_warehouse'),
                'in_warehouse_id' => $this->input->post('in_warehouse'),
            );
            $this->db->where('id', $transfer_id);
            if ($this->db->update('stock_transfer', $data)) {
                $this->db->delete('stock_transfer_items', array('stock_transfer_id' => $transfer_id));
                $product_list = [];
                $index = 0;
                if ($product_details) {
                    foreach ($product_details as $items) {
                        $data_item_insert = [
                            'stock_transfer_id' => $transfer_id,
                            'unit_id' => $items['unit_id'],
                            'qty' => $items['qty'],
                            'product_id' => $items['product_id'],
                            'desc' => $items['desc'],

                        ];
                        $product_list[$index] = $data_item_insert;
                        $index++;
                    }
                    $this->db->insert_batch('stock_transfer_items', $product_list);

                    if ($index) {

                        $this->aauth->applog("Stok Transfer Talebi Güncellendi " . $code, $this->aauth->get_user()->username);
                        return [
                            'status' => 1,
                            'message' => 'Başarılı Bir Şekilde Stok Transfer Talebi Güncellendi',
                            'id' => $transfer_id
                        ];
                    } else {
                        return [
                            'status' => 0,
                            'message' => 'Hata Aldınız.Lütfen Yöneyiciye Başvurun.',
                            'id' => 0
                        ];
                    }
                }
            }
        }
    }

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


    public function details_item($transfer_id)
    {
        $this->db->select('*');
        $this->db->from('stock_transfer_items');
        $this->db->where('stock_transfer_id', $transfer_id);
        $query = $this->db->get();
        return $query->result();
    }
    public function details($transfer_id)
    {
        $this->db->select('*');
        $this->db->from('stock_transfer');
        $this->db->where('id', $transfer_id);
        $query = $this->db->get();
        return $query->row();
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
