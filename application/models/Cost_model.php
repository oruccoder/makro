<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 4.02.2020
 * Time: 12:59
 */


defined('BASEPATH') OR exit('No direct script access allowed');



class Cost_model extends CI_Model

{

    var $table='geopos_cost';
    var $table_customer ='geopos_customers';
    var $table_employe ='geopos_employees';
    var $table_invoice ='geopos_invoices';
    var $column_order = array('(SELECT `geopos_cost`.`name` FROM `geopos_cost` Where `geopos_cost`.`id`=(SELECT `geopos_cost`.`parent_id` FROM `geopos_cost` Where `geopos_cost`.`id`=`geopos_invoice_items`.`pid` ) )','(SELECT name FROM geopos_cost Where geopos_cost.id=geopos_invoice_items.pid )','total_qty', 'subtotal', 'total_tax', 'total');
    var $column_search = array('(SELECT `geopos_cost`.`name` FROM `geopos_cost` Where `geopos_cost`.`id`=(SELECT `geopos_cost`.`parent_id` FROM `geopos_cost` Where `geopos_cost`.`id`=`geopos_invoice_items`.`pid` ) )', '((SELECT name FROM geopos_cost Where geopos_cost.id=geopos_invoice_items.pid ))');
    var $order = array('geopos_invoices.tid' => 'desc');

    public function ana_gider_kalemleri()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('parent_id',0);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_cost.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }
        $query = $this->db->get();
        return $query->result();
    }


    public function edit_trans($id)
    {
        $this->db->select('`geopos_invoices`.*, `geopos_invoices`.`id` as `inv_id`');

        $this->db->from('geopos_invoices');
        //$this->db->join('geopos_invoice_items','geopos_invoice_items.tid =geopos_invoices.id');

        $this->db->where('geopos_invoices.id',$id);


        $query = $this->db->get();
        return $query->row();

    }
    public function alt_gider_kalemleri()
    {
        $this->db->select('*');

        $this->db->from($this->table);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_cost.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }



        $query = $this->db->get();
        return $query->result();
    }

    public function new_gider($id,$gider_kalemi,$unit=9)
    {
        $loc=0;


        $data = array('parent_id' => $id, 'name' => $gider_kalemi,'loc'=>$loc,'unit'=>$unit,'loc'=>$this->session->userdata('set_firma_id'));

        if($this->db->insert($this->table, $data))
        {
            $last_id=$this->db->insert_id();
            $this->aauth->applog("Gider Kalemi Oluşturuldu $gider_kalemi ID ".$last_id,$this->aauth->get_user()->username);
            kont_kayit(16,$last_id);
            return true;
        }
        else
        {
            return false;
        }
    }
    public function edit_gider($gider_kalemi,$alt_id,$unit=9)
    {
        $this->db->set('name', "'$gider_kalemi'", FALSE);
        $this->db->set('unit', "'$unit'", FALSE);

        $this->db->where('id', $alt_id);
        if($this->db->update($this->table))
        {

            $this->aauth->applog("Gider Kalemi Düzenlendi $gider_kalemi ID ".$alt_id,$this->aauth->get_user()->username);
            kont_kayit(17,$alt_id);
            return true;
        }
        else
        {
            return false;
        }
    }
    public function cost_delete($id)
    {
        if($this->db->delete($this->table, array('id' => $id)))
        {
            return $this->db->delete($this->table, array('parent_id' => $id));
        }
    }
    public function acc_list()

    {

        $this->db->select('id,acn,holder,account_type');

        $this->db->from('geopos_accounts');
        $this->db->where('status',1);
        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_accounts.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }



        $query = $this->db->get();

        return $query->result_array();

    }
    public function cari_list()
    {
        $this->db->select('*');

        $this->db->from($this->table_customer);


        $query = $this->db->get();
        return $query->result();
    }
    public function personel_list()
    {
        $loc = $this->session->userdata('set_firma_id');
        $whr='';
        $query=$this->db->query("SELECT `geopos_employees`.* FROM  `geopos_employees` JOIN `geopos_users` ON

        `geopos_employees`.`id`=`geopos_users`.`id` where geopos_employees.loc=$loc ");
        return $query->result();
    }

    public function invoice_list()
    {
        $whr='';

        $loc=$this->session->userdata('set_firma_id');
        $query=$this->db->query("SELECT `geopos_invoices`.*,geopos_invoices.subtotal-geopos_invoices.last_balance as kalan  FROM  `geopos_invoices` JOIN `geopos_invoice_type` ON
      `geopos_invoices`.`invoice_type_id`=`geopos_invoice_type`.`id` WHERE loc=$loc and `geopos_invoice_type`.`type_value` = 'fatura' and `geopos_invoices`.`last_balance` NOT IN(geopos_invoices.subtotal) ");
        return $query->result();
    }

    public function addinvoice($tip,$odeme_durumu,$masraf_id,$belge_no,$description,$cari_personel_fatura_id,
                               $account, $tutar,$kdv_orani, $odeme_tarihi,$islem_date,$para_birimi,$kur_degeri,
                               $user_id,$loc_id,$payer,$holder,$proje_id,$paymethod,$odenen_tutar,$bolum_id,$asama_id,$task_id)
    {

        $transok = true;
        $this->db->trans_start();
        $subtotal=$tutar/(1+($kdv_orani/100));

        $holder=account_method_ogren($account)['holder'];

        $data = array(

            'invoice_no' => $belge_no,

            'invoicedate' => $islem_date,

            'total' =>$tutar,
            'subtotal' =>$subtotal,

            'tax_oran' => $kdv_orani,

            'notes' => $description,

            'csd' => $cari_personel_fatura_id,

            'eid' => $user_id,

            'loc' => $loc_id,

            'invoice_type_id' => 21,

            'invoice_type_desc' => 'Masraf',

            'payer' => $payer,

            'acid' => $account,
            'account' => $holder,


            'credit' => $tutar,

            'para_birimi' => $para_birimi,

            'kur_degeri' => $kur_degeri,


            'masraf_id' => $masraf_id,
            'method' => $paymethod,
            'cari_pers_type' => 7,

            'odeme_durumu' => $odeme_durumu,
            'refer' => $tip,
            'proje_id' => $proje_id,
            'bolum_id' => $bolum_id,
            'asama_id' => $asama_id,
            'task_id' => $task_id

        );


        if($this->db->insert('geopos_invoices', $data))
        {

            $last_id = $this->db->insert_id();

            $total_tax=$tutar*($kdv_orani/100);

            $data_items = array(

                'tid' => $last_id,

                'pid' => $masraf_id,

                'product' => masraf_name($masraf_id),

                'code' => masraf_name($masraf_id),

                'qty' => 1,

                'price' => $tutar,


                'tax' => $kdv_orani,

                'discount' => 0,

                'subtotal' => $tutar,

                'totaltax' => $total_tax,

                'totaldiscount' => 0,

                'product_des' => '',

                'unit' => 9,

                'invoice_type_id' => 21,


                'proje_id' => $proje_id,

                'invoice_type_desc' => 'Masraf',
            );
            $this->db->insert('geopos_invoice_items', $data_items);
            $item_id=$this->db->insert_id();


            if($proje_id!=0)
            {
                $this->db->insert('geopos_project_items_gider', $data_items);
                $item_id_gider=$this->db->insert_id();
            }



            if($odeme_durumu==1 || $odeme_durumu==2)
            {




                $type = array(1, 2,19,20,17,18,21,24,37);
                $invoice_details=$this->db->query("SELECT * FROM geopos_invoices Where id=$item_id")->row();
                if(isset($invoice_details))
                {
                    if(in_array($invoice_details->invoice_type_id,$type)) {


                        $this->db->set('last_balance', "$odenen_tutar", FALSE);
                        $this->db->where('id', $item_id);
                        $this->db->update('geopos_invoice_items');
                    }
                }


                if($proje_id!=0) {
                    $this->db->set('last_balance', "$odenen_tutar", FALSE);
                    $this->db->where('id', $item_id_gider);
                    $this->db->update('geopos_project_items_gider');
                }
                $this->db->set('account', "'$holder'", FALSE);
                $this->db->set('method', "$paymethod", FALSE);
                $this->db->set('invoiceduedate', "'$odeme_tarihi'", FALSE);
                $this->db->where('id', $last_id);
                $this->db->update('geopos_invoices');
                $data2 = array(

                    'invoice_no' => $belge_no,
                    'tid' => $last_id,

                    'invoicedate' => $odeme_tarihi,

                    'total' =>$odenen_tutar,

                    'tax_oran' => $kdv_orani,

                    'notes' => $description,

                    //'csd' => $cari_personel_fatura_id,
                    'csd' => $masraf_id,

                    'eid' => $user_id,

                    'loc' => $loc_id,

                    'invoice_type_id' => 4,
                    'cari_pers_type' => 7,

                    'invoice_type_desc' => 'Ödeme',

                    'payer' => $payer,

                    'acid' => $account,
                    'account' => $holder,
                    'method' => $paymethod,

                    'credit' => $odenen_tutar,

                    'para_birimi' => $para_birimi,

                    'kur_degeri' => $kur_degeri,

                    'masraf_id' => $masraf_id,
                    'refer' => $tip,
                    'proje_id' => $proje_id,
                    'odeme_durumu' => $odeme_durumu

                );
                $this->db->insert('geopos_invoices', $data2);

                $t_id=$this->db->insert_id();

                $this->add_masraf_transaction(
                    'add',
                    $last_id,
                    $t_id,
                    $tutar,
                    $para_birimi,
                    $kur_degeri,
                    $paymethod,
                    $tip,
                    '');


            }

            $this->db->trans_complete();
            return true;

        }
        else
        {
            $this->db->trans_rollback();
            return false;
        }

    }

    public function add_masraf_transaction($string,$invoice_id,$lid,$amount,$para_birimi,$kur_degeri,$paymethod,$tip,$image)
    {


        $this->db->select('*');

        $this->db->from('geopos_invoices');

        $this->db->where('id', $invoice_id);

        $query = $this->db->get();

        $invoices = $query->row_array();

        $odenen_tutar=$invoices['last_balance']+$invoices['kdv_last_balance'];

        if($odenen_tutar==$invoices['total'])
        {
            $this->db->set('odeme_durumu', "3", FALSE);
            $this->db->where('id', $invoice_id);

            $this->db->update('geopos_invoices');
        }



        if($string=='add')
        {
            $data = array(

                'invoice_id' => $invoice_id,
                'transaction_id' => $lid,
                'total' => $amount,
                'kur_degeri' => $kur_degeri,
                'para_birimi' => $para_birimi,
                'method' => $paymethod,
                'tip' => $tip

            );


            return $this->db->insert('geopos_invoice_transactions', $data);
        }
        else
        {
            $data = array(

                'invoice_id' => $invoice_id,
                'transaction_id' => $lid,
                'total' => $amount,
                'kur_degeri' => $kur_degeri,
                'para_birimi' => $para_birimi,
                'method' => $paymethod,
                'tip' => $tip

            );
            $this->db->set($data);

            $this->db->where('transaction_id', $lid);

            $this->db->update('geopos_invoice_transactions',$data);
        }


    }

    public function edit_invoice($trans_id,$id,$tip,$odeme_durumu,$masraf_id,$belge_no,$description,$cari_personel_fatura_id,
                                 $account, $tutar,$kdv_orani, $odeme_tarihi,$islem_date,$para_birimi,$kur_degeri,
                                 $user_id,$loc_id,$payer,$holder,$proje_id,$paymethod,$odenen_tutar,$bolum_id,$asama_id,$task_id)
    {


        $subtotal=$tutar/(1+($kdv_orani/100));

        $holder=account_method_ogren($account)['holder'];

        $data = array(

            'invoice_no' => $belge_no,

            'invoicedate' => $islem_date,

            'total' =>$tutar,
            'subtotal' =>$subtotal,

            'tax_oran' => $kdv_orani,

            'notes' => $description,

            'csd' => $cari_personel_fatura_id,

            'eid' => $user_id,

            'loc' => $loc_id,

            'invoice_type_id' => 21,

            'invoice_type_desc' => 'Masraf',

            'payer' => $payer,

            'acid' => $holder,
            'account' => $account,
            'method' => $paymethod,

            'credit' => $tutar,

            'para_birimi' => $para_birimi,

            'kur_degeri' => $kur_degeri,
            'refer' => $tip,

            'masraf_id' => $masraf_id,

            'odeme_durumu' => $odeme_durumu,
            'proje_id' => $proje_id,
            'bolum_id' => $bolum_id,
            'asama_id' => $asama_id,
            'task_id' => $task_id,

        );
        $this->db->set($data);
        $this->db->where('id', $id);

        if($this->db->update('geopos_invoices', $data))
        {
            $this->db->delete('geopos_invoice_items', array('tid' => $id));

            $last_id = $id;


            $total_tax=$tutar*($kdv_orani/100);

            $data_items = array(

                'tid' => $last_id,

                'pid' => $masraf_id,

                'product' => masraf_name($masraf_id),

                'code' => masraf_name($masraf_id),

                'qty' => 1,

                'price' => $tutar,


                'tax' => $kdv_orani,

                'discount' => 0,

                'subtotal' => $tutar,

                'totaltax' => $total_tax,

                'totaldiscount' => 0,

                'product_des' => '',

                'unit' => 9,
                'refer' => $tip,

                'invoice_type_id' => 21,

                'proje_id' => $proje_id,

                'invoice_type_desc' => 'Masraf',
            );
            $this->db->insert('geopos_invoice_items', $data_items);


            if($odeme_durumu==1)
            {

                $this->db->set('account', "'$holder'", FALSE);
                $this->db->set('method', "'$paymethod'", FALSE);
                $this->db->set('invoiceduedate', "'$odeme_tarihi'", FALSE);
                $this->db->where('id', $last_id);
                $this->db->update('geopos_invoices');


                $data2 = array(

                    'invoice_no' => $belge_no,
                    'tid' => $last_id,
                    'invoicedate' => $odeme_tarihi,

                    'total' =>$odenen_tutar,

                    'tax_oran' => $kdv_orani,

                    'notes' => $description,

                    'csd' => $cari_personel_fatura_id,

                    'eid' => $user_id,

                    'loc' => $loc_id,

                    'invoice_type_id' => 4,

                    'invoice_type_desc' => 'Ödeme',

                    'payer' => $payer,

                    'acid' => $account,
                    'acid' => $holder,
                    'method' => $paymethod,

                    'debit' => $odenen_tutar,
                    'refer' => $tip,
                    'proje_id' => $proje_id,

                    'para_birimi' => $para_birimi,

                    'kur_degeri' => $kur_degeri,

                    'masraf_id' => $masraf_id,

                    'odeme_durumu' => $odeme_durumu,

                );

                $this->db->set($data);
                $this->db->where('id', $trans_id);
                $this->db->update('geopos_invoices', $data2);

                $this->add_masraf_transaction(
                    'edit',
                    $last_id,
                    $trans_id,
                    $tutar,
                    $para_birimi,
                    $kur_degeri,
                    $paymethod,
                    $tip,
                    '');
            }
            return true;
        }

    }
    function get_datatables($opt = '')

    {

        $this->_get_datatables_query($opt);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();






        return $query->result();

    }
    private function _get_datatables_query($opt = '')

    {

        if ($_POST['length'] != -1)
        {

            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $type=array(21,24);


        $this->db->select('geopos_invoices.id,
geopos_invoice_items.`pid`,
SUM(geopos_invoice_items.`subtotal`*geopos_invoices.kur_degeri) as subtotal,
SUM(geopos_invoice_items.`totaltax`*geopos_invoices.kur_degeri) as total_tax,
(SUM(geopos_invoice_items.subtotal+geopos_invoice_items.`totaltax`))*geopos_invoices.kur_degeri as total,
SUM(geopos_invoice_items.qty) as total_qty,
geopos_invoice_items.unit,
(SELECT geopos_cost.name FROM geopos_cost Where geopos_cost.id=geopos_invoice_items.pid ) as cost_parent_name,
(SELECT geopos_cost.parent_id FROM geopos_cost Where geopos_cost.id=geopos_invoice_items.pid ) as inv_parent_id,
(SELECT geopos_cost.id FROM geopos_cost Where geopos_cost.id=inv_parent_id ) as masraf_id,
(SELECT geopos_cost.name FROM geopos_cost Where geopos_cost.id=inv_parent_id ) as cost_name');

        $this->db->from($this->table_invoice);



        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_invoices.invoicedate) >=', datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where('DATE(geopos_invoices.invoicedate) <=', datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
        }

        if ($this->input->post('masraf_id')!=0) // if datatable send POST for search
        {
            $this->db->where('(SELECT geopos_cost.id FROM geopos_cost Where geopos_cost.id=(SELECT geopos_cost.parent_id FROM geopos_cost Where geopos_cost.id=geopos_invoice_items.pid))=', $this->input->post('masraf_id')); //2019-11-23 14:28:57

        }

        if ($this->input->post('alt_masraf_id')!=0) // alt masraf ID
        {
            $this->db->where('(SELECT geopos_cost.id FROM geopos_cost Where geopos_cost.id=(SELECT geopos_cost.id FROM geopos_cost Where geopos_cost.id=geopos_invoice_items.pid))=', $this->input->post('alt_masraf_id')); //2019-11-23 14:28:57

        }

        if ($this->input->post('odeme_durumu'))
        {
            $this->db->where('geopos_invoices.odeme_durumu=', $this->input->post('odeme_durumu')); //0-3
        }



        $this->db->join('geopos_invoice_items','geopos_invoices.id=geopos_invoice_items.tid');

        $this->db->where_in('geopos_invoices.invoice_type_id',$type);

        $this->db->where('geopos_invoice_items.pid!=',0);



        if($this->session->userdata('set_firma_id')){
            $this->db->where('geopos_invoices.loc =', $this->session->userdata('set_firma_id')); //2019-11-23 14:28:57
        }

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

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->order)) {

            $order = $this->order;

            $this->db->order_by(key($order), $order[key($order)]);

        }

        $this->db->group_by("geopos_invoice_items.pid");


    }
    public function count_all($opt = '')

    {

        $this->db->select('geopos_invoices.id');

        $this->db->from($this->table_invoice);

        $this->db->where('geopos_invoices.i_class', 0);

        $this->db->where('geopos_invoices.invoice_type_id', 21);

        if ($opt) {

            $this->db->where('geopos_invoices.eid', $opt);



        }


        $this->db->join('geopos_invoice_items','geopos_invoices.id=geopos_invoice_items.tid');

        $this->db->group_by("geopos_invoice_items.pid");

        return $this->db->count_all_results();

    }

    public function count_all_masraf_detay($string,$id)

    {

        $whre='';



        if($string=='alt_masraf')
        {
            $query = $this->db->query("SELECT geopos_invoices.id as inv_id,'Masraf Faturası' as description,geopos_invoices.invoicedate,geopos_invoices.invoice_no,'fatura' as type_value,
                          IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,geopos_invoice_items.product,
                       0 as borc,
                         geopos_invoice_items.subtotal  as alacak,
                        geopos_invoices.total,
                        geopos_invoice_items.totaltax,
                        geopos_invoices.subtotal,
                        geopos_invoices.kur_degeri,
                        'expense'as transactions,
                        geopos_invoices.invoice_type_id,
                        'masraf' as type,
                        geopos_invoice_items.pid
                       FROM geopos_invoices
                       LEFT JOIN geopos_invoice_type ON geopos_invoices.invoice_type_id=geopos_invoice_type.id
                       LEFT JOIN geopos_invoice_items ON geopos_invoice_items.tid=geopos_invoices.id
                       WHERE  geopos_invoice_items.pid=$id and (geopos_invoice_items.invoice_type_id=21 or  geopos_invoice_items.invoice_type_id=24 )   $whre")->result();
            return count($query);
        }
        else
        {
            $prodindex=0;
            $productlist = new stdClass();
            $sorgu=$this->db->query('SELECT * FROM geopos_cost WHERE parent_id='.$id)->result();
            foreach ($sorgu as $prd)
            {
                $pid=$prd->id;
                $query= $this->db->query(" SELECT * FROM  (

                        SELECT 'Masraf Faturası' as description,geopos_invoices.invoicedate,geopos_invoices.invoice_no,'fatura' as type_value,
                          IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,geopos_invoice_items.product,
                       0 as borc,
                         geopos_invoice_items.subtotal  as alacak,
                        geopos_invoices.total,
                        geopos_invoices.subtotal,
                        geopos_invoices.kur_degeri,
                        'expense'as transactions,
                        geopos_invoices.invoice_type_id,
                        'masraf' as type,
                        geopos_invoice_items.pid
                       FROM geopos_invoices
                       LEFT JOIN geopos_invoice_type ON geopos_invoices.invoice_type_id=geopos_invoice_type.id
                       LEFT JOIN geopos_invoice_items ON geopos_invoice_items.tid=geopos_invoices.id
                       WHERE (geopos_invoice_items.pid=$pid and geopos_invoices.invoice_type_id=21) $whre



                       UNION
                        SELECT 'Ödeme' as description,geopos_invoices.invoicedate,geopos_invoices.invoice_no,'transaction' as type_value,
                          IF(geopos_invoice_transactions.`method`!='', geopos_invoice_transactions.`method`, 'null') as odeme_tipi,geopos_invoice_items.product,
                        geopos_invoice_items.last_balance as borc,
                        0 as alacak,
                        geopos_invoices.total,
                        geopos_invoices.subtotal,
                        geopos_invoices.kur_degeri,
                        'income'as transactions,
                        geopos_invoices.invoice_type_id,
                        'masraf_odemesi' as type,
                        geopos_invoice_items.pid
                       FROM geopos_invoices
                       INNER JOIN geopos_invoice_transactions ON geopos_invoices.id = geopos_invoice_transactions.invoice_id
                       INNER JOIN geopos_invoice_items ON geopos_invoice_items.tid=geopos_invoices.id

                       WHERE geopos_invoice_items.invoice_type_id=21 and geopos_invoice_items.pid=$pid $whre

                       group by geopos_invoice_items.id
                       ) as tbl ORDER BY tbl.invoicedate

                       ")->result_array();

                if(isset($query))
                {


                    $productlist = (object) array_merge(
                        (array) $productlist, (array) $query);

                    $prodindex++;
                }
            }



            return count((array)$productlist);;

        }


    }
    function count_filtered($opt = '')

    {

        $this->_get_datatables_query($opt);

        if ($opt) {

            $this->db->where('eid', $opt);

        }



        $query = $this->db->get();

        return $query->num_rows();

    }

    function giderview($id)
    {
        $this->db->select('*');

        $this->db->from($this->table_invoice);

        $this->db->where('id',$id);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function alt_gider_kalemleri_masraf_id($id)
    {
        $this->db->select('*');

        $this->db->from($this->table);

        $this->db->where('parent_id',$id);

        $query = $this->db->get();
        return $query->result();
    }

    function get_datatables_masraf_detay($string,$id,$opt = '')

    {


        return  $this->_get_datatables_query_masraf_detay($string,$id,$opt);

    }

    private function _get_datatables_query_masraf_detay($string,$id,$opt = '')

    {




        if ($_POST['length'] != -1)
        {

            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $whre='';
        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $whre.='AND DATE(geopos_invoices.invoicedate) >="'.datefordatabasefilter($this->input->post('start_date')).'"'; //2019-11-23 14:28:57
            $whre.=' AND DATE(geopos_invoices.invoicedate) <="'.datefordatabasefilter($this->input->post('end_date')).'"';  //2019-11-24 14:28:57
        }

        if ($_POST['search']['value']) // if datatable send POST for search

        {
            $val=$_POST['search']['value'];
            $whre.="AND  geopos_invoice_items.product LIKE '%$val%' ";
        }

        if($string=='alt_masraf')
        {
            /*return $this->db->query(" SELECT * FROM  (

                SELECT geopos_invoices.id as inv_id,'Masraf Faturası' as description,geopos_invoices.invoicedate,geopos_invoices.invoice_no,'fatura' as type_value,
                          IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,geopos_invoice_items.product,
                       0 as borc,
                         geopos_invoice_items.subtotal  as alacak,
                        geopos_invoices.total,
                        geopos_invoice_items.totaltax,
                        geopos_invoices.subtotal,
                        geopos_invoices.kur_degeri,
                        'expense'as transactions,
                        geopos_invoices.invoice_type_id,
                        'masraf' as type,
                        geopos_invoice_items.pid
                       FROM geopos_invoices
                       LEFT JOIN geopos_invoice_type ON geopos_invoices.invoice_type_id=geopos_invoice_type.id
                       LEFT JOIN geopos_invoice_items ON geopos_invoice_items.tid=geopos_invoices.id
                       WHERE  geopos_invoice_items.pid=$id and (geopos_invoice_items.invoice_type_id=21 or  geopos_invoice_items.invoice_type_id=24 )   $whre



                       UNION
                        SELECT geopos_invoices.id as inv_id,'Ödeme' as description,geopos_invoices.invoicedate,geopos_invoices.invoice_no,'transaction' as type_value,
                          IF(geopos_invoice_transactions.`method`!='', geopos_invoice_transactions.`method`, 'null') as odeme_tipi,geopos_invoice_items.product,
                        geopos_invoice_transactions.total as borc,
                        0 as alacak,
                        geopos_invoices.total,
                        geopos_invoices.subtotal,
                        geopos_invoice_items.totaltax,
                        geopos_invoices.kur_degeri,
                        'income'as transactions,
                        geopos_invoices.invoice_type_id,
                        'masraf_odemesi' as type,
                        geopos_invoice_items.pid
                       FROM geopos_invoices
                       INNER JOIN geopos_invoice_transactions ON geopos_invoices.id = geopos_invoice_transactions.invoice_id
                       INNER JOIN geopos_invoice_items ON geopos_invoice_items.tid=geopos_invoices.id

                       WHERE  (geopos_invoices.invoice_type_id=21 or  geopos_invoices.invoice_type_id=24 ) and geopos_invoice_items.pid=$id $whre

                       group by geopos_invoice_items.id
                       ) as tbl ORDER BY tbl.invoicedate ASC

                       ")->result(); */

            if ($this->input->post('length') != -1)
            {
                $limit='LIMIT '.$this->input->post('start').',' .$this->input->post('length');
            }

            return $this->db->query("SELECT geopos_invoices.id as inv_id,'Masraf Faturası' as description,geopos_invoices.invoicedate,geopos_invoices.invoice_no,'fatura' as type_value,
                          IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,geopos_invoice_items.product,
                       0 as borc,
                         geopos_invoice_items.subtotal  as alacak,
                        geopos_invoices.total,
                        geopos_invoice_items.totaltax,
                        geopos_invoices.subtotal,
                        geopos_invoices.kur_degeri,
                        'expense'as transactions,
                        geopos_invoices.invoice_type_id,
                        'masraf' as type,
                        geopos_invoice_items.pid
                       FROM geopos_invoices
                       LEFT JOIN geopos_invoice_type ON geopos_invoices.invoice_type_id=geopos_invoice_type.id
                       LEFT JOIN geopos_invoice_items ON geopos_invoice_items.tid=geopos_invoices.id
                       WHERE  geopos_invoice_items.pid=$id and (geopos_invoice_items.invoice_type_id=21 or  geopos_invoice_items.invoice_type_id=24 )   $whre $limit")->result();




        }
        else
        {
            $prodindex=0;
            $productlist = new stdClass();
            $sorgu=$this->db->query('SELECT * FROM geopos_cost WHERE parent_id='.$id)->result();
            foreach ($sorgu as $prd)
            {
                $pid=$prd->id;
                $query= $this->db->query(" SELECT * FROM  (

                        SELECT geopos_invoices.id as inv_id,'Masraf Faturası' as description,geopos_invoices.invoicedate,geopos_invoices.invoice_no,'fatura' as type_value,
                          IF(geopos_invoices.method!='',geopos_invoices.method, 'null') as odeme_tipi,geopos_invoice_items.product,
                       0 as borc,
                         geopos_invoice_items.subtotal  as alacak,
                        geopos_invoices.total,
                        geopos_invoices.subtotal,
                        geopos_invoices.kur_degeri,
                        'expense'as transactions,
                        geopos_invoices.invoice_type_id,
                        'masraf' as type,
                        geopos_invoice_items.pid
                       FROM geopos_invoices
                       LEFT JOIN geopos_invoice_type ON geopos_invoices.invoice_type_id=geopos_invoice_type.id
                       LEFT JOIN geopos_invoice_items ON geopos_invoice_items.tid=geopos_invoices.id
                       WHERE (geopos_invoice_items.pid=$pid and (geopos_invoice_items.invoice_type_id=21 or  geopos_invoice_items.invoice_type_id=24 )) $whre



                       UNION
                        SELECT geopos_invoices.id as inv_id,'Ödeme' as description,geopos_invoices.invoicedate,geopos_invoices.invoice_no,'transaction' as type_value,
                          IF(geopos_invoice_transactions.`method`!='', geopos_invoice_transactions.`method`, 'null') as odeme_tipi,geopos_invoice_items.product,
                        geopos_invoice_items.last_balance as borc,
                        0 as alacak,
                        geopos_invoices.total,
                        geopos_invoices.subtotal,
                        geopos_invoices.kur_degeri,
                        'income'as transactions,
                        geopos_invoices.invoice_type_id,
                        'masraf_odemesi' as type,
                        geopos_invoice_items.pid
                       FROM geopos_invoices
                       INNER JOIN geopos_invoice_transactions ON geopos_invoices.id = geopos_invoice_transactions.invoice_id
                       INNER JOIN geopos_invoice_items ON geopos_invoice_items.tid=geopos_invoices.id

                       WHERE (geopos_invoice_items.invoice_type_id=21 or  geopos_invoice_items.invoice_type_id=24 ) and geopos_invoice_items.pid=$pid $whre

                       group by geopos_invoice_items.id
                       ) as tbl ORDER BY tbl.invoicedate

                       ")->result();

                if(isset($query))
                {


                    $productlist = (object) array_merge(
                        (array) $productlist, (array) $query);

                    $prodindex++;
                }
            }



            return $productlist;

        }




    }
    private function array_to_obj($array, &$obj)
    {
        foreach ($array as $key => $value)
        {
            if (is_array($value))
            {
                $obj->$key = new stdClass();
                $this->array_to_obj($value, $obj->$key);
            }
            else
            {
                $obj->$key = $value;
            }
        }
        return $obj;
    }

    private function arrayToObject($array)
    {
        $object= new stdClass();
        return $this->array_to_obj($array,$object);
    }
}
