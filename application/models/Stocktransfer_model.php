<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Stocktransfer_model extends CI_Model
{
    var $table_news = 'stock_io ';

    var $column_order = array('stock_transfer.id', 'code', 'out_warehouse_id', 'in_warehouse_id','geopos_employees.name as pers_name');

    var $column_search = array('stock_transfer.id', 'code', 'out_warehouse_id', 'in_warehouse_id','geopos_employees.name as pers_name');
    var $column_search_transfer = ['stock_transfer.code',
        'stock_transfer.out_warehouse_id',
        'stock_transfer.in_warehouse_id',
        'geopos_products.product_name',
        'stock_transfer_items.qty',
        'geopos_units.name',
        'stock_transfer_item_notification.new_qty',
        'stock_transfer_items.desc',
        'geopos_employees.name'];

    var $column_search_transfer_talep=['talep_form.code','geopos_products.product_name','warehouse_teslimat_transfer.qty','geopos_units.name','geopos_employees.name'];
    var $order = array('stock_transfer.id' => 'DESC');

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

        $this->db->select('stock_transfer.*,geopos_employees.name as pers_name');
        $this->db->from('stock_transfer');
        $this->db->join('geopos_employees','stock_transfer.aauth_id=geopos_employees.id');
        $i = 0;


        if($this->session->userdata('set_firma_id')){
            $this->db->where('stock_transfer.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }


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
        $this->db->order_by('`stock_transfer`.`id` DESC');

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

        $this->db->select('stock_transfer_items.option_id,stock_transfer_items.option_value_id,stock_transfer_items.id as item_id,stock_transfer.id as stock_id,stock_transfer_item_notification.type,stock_transfer_item_notification.id,stock_transfer.code,stock_transfer.out_warehouse_id,stock_transfer.in_warehouse_id,geopos_products.product_name,stock_transfer_items.qty,geopos_units.name as unit_name,stock_transfer_item_notification.new_qty,stock_transfer_items.`desc`,geopos_employees.name as pers_name');
        $this->db->from('stock_transfer_item_notification');
        $this->db->join('stock_transfer','stock_transfer_item_notification.stock_id=stock_transfer.id');
        $this->db->join('stock_transfer_items','stock_transfer_item_notification.stock_item_id=stock_transfer_items.id');
        $this->db->join('geopos_units','stock_transfer_items.unit_id=geopos_units.id');
        $this->db->join('geopos_products','stock_transfer_items.product_id=geopos_products.pid');
        $this->db->join('geopos_employees','stock_transfer.aauth_id = geopos_employees.id');
        $this->db->where('stock_transfer_item_notification.staff_id',$this->aauth->get_user()->id);
        $this->db->where('stock_transfer_item_notification.staff_status',1);
        $this->db->where('stock_transfer_item_notification.status',0);
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


    //malzeme talep
    public function get_datatables_query_talep_transfer_list()

    {
        $this->_get_datatables_query_talep_transfer_list();

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();

        return $query->result();

    }
    private function _get_datatables_query_talep_transfer_list()

    {

        $this->db->select('wt.id as wt_id,wt.status,tf.code,wt.teslim_edilecek_warehouse_id,wt.warehouse_id,p.product_name,wt.qty,gu.name as unit_name,ge.name as pers_name');
        $this->db->from('warehouse_teslimat_transfer as wt');
        $this->db->join('geopos_products p','wt.product_id = p.pid');
        $this->db->join('geopos_employees ge','wt.aauth_id = ge.id');
        $this->db->join('geopos_units gu','wt.unit_id = gu.id');
        $this->db->join('talep_form tf','wt.form_id = tf.id');
        $this->db->where('wt.user_id',$this->aauth->get_user()->id);
        $i = 0;

        foreach ($this->column_search_transfer_talep as $item) // loop column

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

                if (count($this->column_search_transfer_talep) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracke
            }

            $i++;

        }
        $this->db->order_by('`wt`.`id` DESC');

    }
    public function count_all_talep_transfer()
    {
        $this->_get_datatables_query_talep_transfer_list();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_filtered_talep_transfer()
    {
        $this->_get_datatables_query_talep_transfer_list();
        return $this->db->count_all_results();
    }
    //malzeme talep


    public function stock_transfer_notification_create($stock_id,$type,$new_qty=0,$status=0,$staff_id,$staff_status=null)
    {
        $item_details = $this->details_item($stock_id);
        $details = $this->details($stock_id);
        $product_list=[];
        $i=0;
        foreach ($item_details as $value){
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
            $product_list[$i]=$data;
            $i++;
        }

            if($i){
                $this->db->insert_batch('stock_transfer_item_notification', $product_list);
                $this->aauth->applog("Stok Bildirimi OLuşturuldu  ".$details->code, $this->aauth->get_user()->username);
                return [
                    'status'=>1,
                    'id'=>$stock_id
                ];

            }
            else {
                return [
                    'status'=>0,
                    'id'=>0
                ];
            }
    }

    public function create_save(){

        $code = numaric(25);
        $product_details = $this->input->post('collection');
        $data = array(
            'code' => $code,
            'out_warehouse_id' =>  $this->input->post('out_warehouse'),
            'in_warehouse_id' => $this->input->post('in_warehouse'),
            'loc' =>  $this->session->userdata('set_firma_id'),
            'aauth_id' => $this->aauth->get_user()->id
        );
        if ($this->db->insert('stock_transfer', $data)) {
            $last_id = $this->db->insert_id();
            $this->db->set('deger', "deger+1",FALSE);
            $this->db->where('tip', 25);
            $this->db->update('numaric');
            $product_list=[];
            $index=0;
            if($product_details){
                foreach ($product_details as $items){

                    $options_id='';
                    $value_id='';
                    $i=0;
                    if($items['value_id']){
                        $value_id= $items['value_id'];
                        if($value_id!==0){
                            $option_details = $this->db->query("select * from product_option_value Where id  IN ($value_id)")->result();
                            foreach ($option_details as $option_items){
                                if ($i === array_key_last($option_details)) {// first loop
                                    $options_id.=$option_items->product_option_id;
                                }
                                else {
                                    $options_id.=$option_items->product_option_id.',';
                                }
                                $i++;
                            }
                        }
                    }



                    $data_item_insert = [
                        'stock_transfer_id'=>$last_id,
                        'unit_id'=>$items['unit_id'],
                        'qty'=>$items['qty'],
                        'product_id'=>$items['product_id'],
                        'desc'=>$items['desc'],
                        'option_id' => option_sort($options_id),
                        'option_value_id'=> option_sort($value_id),

                    ];
                    $product_list[$index]=$data_item_insert;
                    $index++;
                }
                $this->db->insert_batch('stock_transfer_items', $product_list);

                if($index){

                    $this->aauth->applog("Stok Transfer Talebi Yapıldı ".$code, $this->aauth->get_user()->username);
                    return [
                        'status'=>1,
                        'id'=>$last_id
                    ];

                }
                else {
                    return [
                        'status'=>0,
                        'id'=>0
                    ];
                }
            }
        }

    }


    public function update(){

        $transfer_id =  $this->input->post('transfer_id');
        $details = $this->details($transfer_id);
        if($details->bildirim_durumu){
            return [
                'status'=>0,
                'message'=>'Bildirim Başlatılmış Talepte Güncelleme Yapılamaz',
                'id'=>$transfer_id
            ];
        }
        else {
            $code = $details->code;

            $product_details = $this->input->post('collection');
            $data = array(
                'out_warehouse_id' =>  $this->input->post('out_warehouse'),
                'in_warehouse_id' => $this->input->post('in_warehouse'),
            );
            $this->db->where('id', $transfer_id);
            if ($this->db->update('stock_transfer', $data)) {
                $this->db->delete('stock_transfer_items', array('stock_transfer_id' => $transfer_id));
                $product_list=[];
                $index=0;
                if($product_details){



                    foreach ($product_details as $items){

                        $options_id='';
                        $value_id='';
                        $i=0;
                        if($items['value_id']){
                            $value_id= $items['value_id'];
                            if($value_id!==0){
                                $option_details = $this->db->query("select * from product_option_value Where id  IN ($value_id)")->result();
                                foreach ($option_details as $option_items){
                                    if ($i === array_key_last($option_details)) {// first loop
                                        $options_id.=$option_items->product_option_id;
                                    }
                                    else {
                                        $options_id.=$option_items->product_option_id.',';
                                    }
                                    $i++;
                                }
                            }
                        }

                        $data_item_insert = [
                            'stock_transfer_id'=>$transfer_id,
                            'unit_id'=>$items['unit_id'],
                            'qty'=>$items['qty'],
                            'product_id'=>$items['product_id'],
                            'desc'=>$items['desc'],
                            'option_id'         => option_sort($options_id),
                            'option_value_id'         => option_sort($value_id),

                        ];
                        $product_list[$index]=$data_item_insert;
                        $index++;
                    }
                    $this->db->insert_batch('stock_transfer_items', $product_list);

                    if($index){

                        $this->aauth->applog("Stok Transfer Talebi Güncellendi ".$code, $this->aauth->get_user()->username);
                        return [
                            'status'=>1,
                            'message'=>'Başarılı Bir Şekilde Stok Transfer Talebi Güncellendi',
                            'id'=>$transfer_id
                        ];

                    }
                    else {
                        return [
                            'status'=>0,
                            'message'=>'Hata Aldınız.Lütfen Yöneyiciye Başvurun.',
                            'id'=>0
                        ];
                    }
                }
            }
        }


    }

    public function transfer_update(){
        $product_details =  $this->input->post('product_details');
        $tip =  $this->input->post('tip'); //1 onay 2 iptal

        $product_list=[];
        $index=0;


        foreach ($product_details as $items){

            $stock_id = $items['stock_id'];
            $this->aauth->applog("Stok Transfer Talebi Güncellendi NT_ID".$items['notifation_id'], $this->aauth->get_user()->username);
            $data_new_update=[
                'new_qty'=>$items['new_qty'],
                'staff_status'=>null,
                'status'=>$tip,
                'id'=>$items['notifation_id']
            ];
            $product_list[$index]=$data_new_update;
            $index++;
            $this->db->update_batch('stock_transfer_item_notification', $product_list,'id');

            if($items['type_id']==2) // Giriş İse Stok Güncellemesi
            {

                if($tip==1) // Kabul edildiyse
                {
                    $notifation_details = $this->notifation_details($items['notifation_id']);
                    $item_details = $this->item_details($notifation_details->stock_item_id);
                    $details = $this->details($item_details->stock_transfer_id);
                    $giris_depo_id=$details->in_warehouse_id;
                    $cikis_depo_id=$details->out_warehouse_id;
                    stock_update_new($item_details->product_id,$item_details->unit_id,$items['new_qty'],1,$giris_depo_id,$this->aauth->get_user()->id,$item_details->stock_transfer_id,4);
                    $stock_id = $this->db->insert_id();
                    stock_update_options_new($stock_id,$item_details->option_id,$item_details->option_value_id);
                    stock_update_new($item_details->product_id,$item_details->unit_id,$items['new_qty'],0,$cikis_depo_id,$this->aauth->get_user()->id,$item_details->stock_transfer_id,4);
                    $stock_id_new = $this->db->insert_id();
                    stock_update_options_new($stock_id_new,$item_details->option_id,$item_details->option_value_id);
                }
              }
            elseif($items['type_id']==1){ // Çıkış Güncellemesi ise giriş deposuna mail bildir
                $data_update = array(
                    'staff_status' => 1
                );
                $this->db->where('stock_id=', $stock_id);
                $this->db->where('status', 0);
                $this->db->update('stock_transfer_item_notification', $data_update);

                // İptal varsa
                    $iptal_kontrol = $this->db->query("SELECT * FROM stock_transfer_item_notification Where status=2");
                    if($iptal_kontrol->num_rows()){
                        foreach ($iptal_kontrol as $result){
                            $data_new_update=[
                                'staff_status'=>null,
                            ];
                            $this->db->where("id",$result->id);
                            $this->db->update('stock_transfer_item_notification', $data_new_update);
                        }
                    }
                // İptal varsa
              }
        }


        //$this->stocktransfer->send_mail($staff_id_cikis,'Mahsul Giriş Talebi','Yeni Bir Giriş Talebi Oluşturuldu İncelemek İçin Bildirimler Bölümüne Bakınız');



        if($index){
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Stok Transfer Talebi Güncellendi',
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız.Lütfen Yöneyiciye Başvurun.',
                'id'=>0
            ];
        }
    }

    public function talep_transfer_update(){
        $product_details =  $this->input->post('product_details');
        $tip =  $this->input->post('tip');

        $index=0;
        foreach ($product_details as $items){
            if($tip==1){
                $data = [
                    'status'=> $tip,  //1 onay 2 İptal
                    'stock_fis_id'=>$this->input->post('stock_fis_id')
                ];

            }
            else {
                $data = [
                    'status'=> $tip,  //1 onay 2 İptal
                ];
            }

            $this->db->set($data);
            $this->db->where('id',$items['wt_id']);
            $this->db->update('warehouse_teslimat_transfer', $data);
            $index++;
        }
        if($index){
            return [
                'status'=>1,
                'message'=>'Başarılı Bir Şekilde Stok Transfer Talebi Güncellendi',
            ];
        }
        else {
            return [
                'status'=>0,
                'message'=>'Hata Aldınız.Lütfen Yöneyiciye Başvurun.',
                'id'=>0
            ];
        }
    }

    public function bildirim_olustur(){

        $talep_id = $this->input->post('talep_id');
        $this->db->set('bildirim_durumu',1);
        $this->db->where('id', $talep_id);
        if($this->db->update('stock_transfer')){
            $this->aauth->applog("Stok Transfer Talep Bildirimi Oluşturuldu  : Talep ID : ".$talep_id, $this->aauth->get_user()->username);

            // Mail ile Bildirime
            $transfer_id = $this->input->post('talep_id');
            $details = $this->details($transfer_id);
            $cikis_depo_details = warehouse_details($details->out_warehouse_id);
            $giris_depo_details = warehouse_details($details->in_warehouse_id);
            $cikis_depo=$cikis_depo_details->title;
            $giris_depo=$giris_depo_details->title;

            $staff_id_cikis =  $cikis_depo_details->pers_id;
            $staff_id_giris =  $giris_depo_details->pers_id;
            if($staff_id_cikis==0 || $staff_id_giris==0){
                $depo_message='';
                if($staff_id_cikis==0){
                    $depo_message= 'Seçilen Çıkış Deposunun Sorumlu Personeli Mevcut değildir';
                }
                else if($staff_id_giris==0){
                    $depo_message= 'Seçilen Giriş Deposunun Sorumlu Personeli Mevcut değildir';
                }
                return [
                    'status'=>410,
                    'message'=>$depo_message
                ];
            }
            else
            {
                //first out warehouse
                $this->send_mail($staff_id_cikis,'Mahsul Çıxış Talebi','Yeni Bir Çıkış Talebi Oluşturuldu İncelemek İçin Bildirimler Bölümüne Bakınız');
                //first out warehous
                $result = $this->stock_transfer_notification_create($transfer_id,1,0,0,$staff_id_cikis,1);
                if($result['status']){
                    //giriş için kayıt
                    $response = $this->stock_transfer_notification_create($transfer_id,2,0,0,$staff_id_giris);
                    //giriş için kayıt

                    return [
                        'status'=>200,
                        'message'=>"Başarılı Bir Şekilde Stok Bildirimi Oluşturuldu"
                    ];

                }
                else {
                    return [
                        'status'=>410,
                        'message'=>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."
                    ];
                }
            }

            // Mail ile Bildirime
        }
        else {
            return [
                'status'=>410,
                'message'=>"Hata Aldınız.Lütfen Yöneyiciye Başvurun."
            ];
        }
    }


    public function details_item($transfer_id){
        $this->db->select('*');
        $this->db->from('stock_transfer_items');
        $this->db->where('stock_transfer_id',$transfer_id);
        $query = $this->db->get();
        return $query->result();
    }
    public function details($transfer_id){
        $this->db->select('*');
        $this->db->from('stock_transfer');
        $this->db->where('id',$transfer_id);
        $query = $this->db->get();
        return $query->row();
    }
    public function notifation_details($id){
        $this->db->select('*');
        $this->db->from('stock_transfer_item_notification');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    public function item_details($id){
        $this->db->select('*');
        $this->db->from('stock_transfer_items');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    public function send_mail($user_id,$subject,$message){
        $message .= "<br><br><br><br>";
        $message .= '<br><br><h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
 <address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
              ' . $this->lang->line('Phone') . ' : ' . $this->config->item('phone') . '<br>  ' . $this->lang->line('Email') . ' : ' . $this->config->item('email');
        $proje_sorumlusu_email = personel_detailsa($user_id)['email'];
        //$recipients = array($proje_sorumlusu_email);
        //$this->communication_model->onay_mail($recipients, $subject, $message, false,'', 'gider_talep_onay_maili');
        $config=[
            'protocol'=>'smtp',
            'smtp_host'=>'ssl://smtp.yandex.com',
            'smtp_port'=>465,
            'smtp_user'=>'Makro2000 ERP',
            'smtp_pass'=>'bulut220618',
            'mailtype'=>'html',
            'charset'=>'iso-8859-1',
            'wordwrap'=>true,
        ];
        $this->load->library('Email',$config);

        $this->email->from('info@makropro.az');
        $this->email->to($proje_sorumlusu_email);
        $this->email->subject($subject);
        $this->email->message($message);

        if( $this->email->send()){
            return true;
        }
        else {
            return false;
        }

    }

    public function get_trasnfers($id)
    {
        //echo $id; die();
        $this->db->select('stock_transfer.*')
            ->from('stock_transfer')
            ->join('stock_transfer_items', 'stock_transfer.id  = stock_transfer_items.stock_transfer_id')
//            ->join('geopos_warehouse', 'stock_transfer.out_warehouse_id = geopos_warehouse.id', 'left')
//            ->join('geopos_warehouse', 'stock_transfer.in_warehouse_id = geopos_warehouse.id', 'left')
            ->where('stock_transfer.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_products($id)
    {
         $this->db->select('stock_transfer_items.*')
            ->from('stock_transfer_items')
            ->join('geopos_products', 'stock_transfer_items.product_id = geopos_products.pid')
            ->where('stock_transfer_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

}
