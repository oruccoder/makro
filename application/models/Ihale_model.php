<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 11.02.2020
 * Time: 16:00
 */
?>
<?php


defined('BASEPATH') OR exit('No direct script access allowed');



class Ihale_model extends CI_Model

{

    var $table='geopos_ihale';
    var $table_customer ='geopos_customers';
    var $table_employe ='geopos_employees';
    var $table_invoice ='geopos_invoices';


    var $column_order = array('dosya_no','baslangic_tarihi','bitis_tarihi','status','description');
    var $column_search = array('dosya_no','baslangic_tarihi','bitis_tarihi','status','description');


    var $table_malzeme='geopos_talep_items';
    var $column_order_malzeme = array('product_name','qty','unit','price','subtotal');
    var $column_search_malzeme = array('product_name','qty','unit','price','subtotal');
    var $order_malzeme = array('geopos_talep_items.id' => 'desc');

    public function dosya_details($id)
    {
        $this->db->select('*');

        $this->db->from($this->table);

        $this->db->where('id',$id);

        $query = $this->db->get();
        return $query->row();
    }
    public function alt_gider_kalemleri()
    {
        $this->db->select('*');

        $this->db->from($this->table);

        $this->db->where_not_in('parent_id',0);


        $query = $this->db->get();
        return $query->result();
    }

    public function ihale_stoklari($id)
    {
        $this->db->select('*');

        $this->db->from("geopos_ihale_items");

        $this->db->where('ihale_id',$id);


        $query = $this->db->get();
        return $query->result();
    }

    public function new_gider($id,$gider_kalemi)
    {
        $loc=0;
        if ($this->aauth->get_user()->loc) {

            $loc=$this->aauth->get_user()->loc;

        }

        $data = array('parent_id' => $id, 'name' => $gider_kalemi,'loc'=>$loc);

        if($this->db->insert($this->table, $data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function edit_gider($gider_kalemi,$alt_id)
    {
        $this->db->set('name', "'$gider_kalemi'", FALSE);

        $this->db->where('id', $alt_id);
        if($this->db->update($this->table))
        {
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

    public function stok_delete($id)
    {
        return $this->db->delete("geopos_ihale_items", array('id' => $id));

    }
    public function cari_delete($id)
    {
        return $this->db->delete("geopos_ihale_to_cari", array('id' => $id));

    }
    public function acc_list()

    {

        $this->db->select('id,acn,holder,account_type');

        $this->db->from('geopos_accounts');

        if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

            $this->db->or_where('loc', 0);

        }

        $query = $this->db->get();

        return $query->result_array();

    }
    public function cari_list()
    {
        $this->db->select('*');

        $this->db->from($this->table_customer);
        if ($this->aauth->get_user()->loc) {

            $this->db->where('loc', $this->aauth->get_user()->loc);

            $this->db->or_where('loc', 0);

        }

        $query = $this->db->get();
        return $query->result();
    }
    public function personel_list()
    {
        $whr='';
        if ($this->aauth->get_user()->loc) {

            $whr='WHERE geopos_users.loc ='.$this->aauth->get_user()->loc;
        }

        $query=$this->db->query("SELECT `geopos_employees`.* FROM  `geopos_employees` JOIN `geopos_users` ON

        `geopos_employees`.`id`=`geopos_users`.`id` $whr ");
        return $query->result();
    }

    public function invoice_list()
    {
        $whr='';
        if ($this->aauth->get_user()->loc) {

            $whr='loc ='.$this->aauth->get_user()->loc.' AND';
        }

        $query=$this->db->query("SELECT `geopos_invoices`.*,geopos_invoices.subtotal-geopos_invoices.last_balance as kalan  FROM  `geopos_invoices` JOIN `geopos_invoice_type` ON
      `geopos_invoices`.`invoice_type_id`=`geopos_invoice_type`.`id` WHERE $whr `geopos_invoice_type`.`type_value` = 'fatura' and `geopos_invoices`.`last_balance` NOT IN(geopos_invoices.subtotal) ");
        return $query->result();
    }

    public function addinvoice($dosya_no,
                               $baslama_tarihi,
                               $bitis_tarihi,
                               $description,
                               $status,
                               $ihale_sekli,
                               $user_id,$proje_id)
    {



        $data = array(
            'dosya_no' => $dosya_no,
            'baslangic_tarihi' => $baslama_tarihi,
            'bitis_tarihi' =>$bitis_tarihi,
            'description' => $description,
            'status' => $status,
            'emp_id' => $user_id,
            'ihale_sekli' => $ihale_sekli,
            'proje_id' => $proje_id,

        );


        if($this->db->insert('geopos_ihale', $data))
        {
            return true;
        }

    }

    public function edit_invoice($ihracat_id,$dosya_no,$baslama_tarihi,
                                 $bitis_tarihi,
                                 $cari_id,
                                 $description,
                                 $gumrukcu_firma_id,
                                 $cari_unvan,
                                 $gumrukcu_firma_unvan,$status,$user_id,$loc_id)
    {


        $this->db->set(array
            (
                'dosya_no' => $dosya_no,

                'baslangic_tarihi' => $baslama_tarihi,

                'bitis_tarihi' =>$bitis_tarihi,
                'cari_id' =>$cari_id,

                'cari_unvan' => $cari_unvan,

                'description' => $description,

                'gumrukcu_firma_id' => $gumrukcu_firma_id,

                'gumrukcu_firma_unvan' => $gumrukcu_firma_unvan,

                'loc' => $loc_id,

                'status' => $status,
            )
        );

        $this->db->where('id', $ihracat_id);


        if($this->db->update('geopos_ihale'))
        {
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


        $this->db->select('*');

        $this->db->from($this->table);



        if ($this->input->post('start_date') && $this->input->post('end_date')) // if datatable send POST for search
        {
            $this->db->where('DATE(geopos_ihale.baslangic_tarihi) >=', datefordatabasefilter($this->input->post('start_date'))); //2019-11-23 14:28:57
            $this->db->where('DATE(geopos_ihale.bitis_tarihi) <=', datefordatabasefilter($this->input->post('end_date')));  //2019-11-24 14:28:57
        }


        if ($this->input->post('kapama_durumu'))
        {
            $this->db->where('geopos_ihale.status=', $this->input->post('kapama_durumu')); //0-3
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



        $this->db->order_by('geopos_ihale.id','DESC');



    }
    public function count_all($opt = '')

    {

        $this->db->select('geopos_ihale.id');

        $this->db->from($this->table);




        return $this->db->count_all_results();

    }

    public function count_filtered($opt = '')

    {

        $this->_get_datatables_query();


        $query = $this->db->get();

        return $query->num_rows();

    }

    public function count_all_masraf_detay($string,$id)

    {

        $whre='';



        if($string=='alt_masraf')
        {
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
                       WHERE (geopos_invoice_items.pid=$id and geopos_invoices.invoice_type_id=21) $whre



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

                       WHERE geopos_invoice_items.invoice_type_id=21 and geopos_invoice_items.pid=$id $whre

                       group by geopos_invoice_items.id
                       ) as tbl ORDER BY tbl.invoicedate

                       ")->result_array();
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
            return $this->db->query(" SELECT * FROM  (

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
                       WHERE (geopos_invoice_items.pid=$id and geopos_invoices.invoice_type_id=21) $whre



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

                       WHERE geopos_invoice_items.invoice_type_id=21 and geopos_invoice_items.pid=$id $whre

                       group by geopos_invoice_items.id
                       ) as tbl ORDER BY tbl.invoicedate

                       ")->result();
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

    function get_datatables_talepler($opt = '')

    {

        $this->_get_datatables_query_talepler($opt);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();




        return $query->result();

    }
    private function _get_datatables_query_talepler($opt = '')

    {
        $id=$this->input->post('malzeme_talep_id');

        if ($_POST['length'] != -1)
        {

            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $this->db->select('*');

        $this->db->from($this->table_malzeme);


        $j = 0;

        if(isset($id))
        {
            foreach ($id as $key=>$value)
            {
                if ($j === 0) // first loop

                {
                    $this->db->or_where('geopos_talep_items.tip',$id[$key]);


                } else {

                    $this->db->or_where('geopos_talep_items.tip',$id[$key]);

                }

            }
        }
        else
        {
            $this->db->where('geopos_talep_items.tip',0);
        }










        $i = 0;



        foreach ($this->column_search_malzeme as $item) // loop column

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



                if (count($this->column_search_malzeme) - 1 == $i) //last loop

                    $this->db->group_end(); //close bracket

            }

            $i++;

        }



        if (isset($_POST['order'])) // here order processing

        {

            $this->db->order_by($this->column_order_malzeme[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);

        } else if (isset($this->order_malezeme)) {

            $order = $this->order_malezeme;

            $this->db->order_by(key($order), $order[key($order)]);

        }



    }
    public function count_all_talepler($opt = '')

    {

        $id=$this->input->post('malzeme_talep_id');
        $this->db->select('geopos_talep_items.id');

        $this->db->from($this->table_malzeme);

        if ($opt) {

            $this->db->where('geopos_ihale.emp_id', $opt);
        }

        $j=0;
        if(isset($id))
        {
            foreach ($id as $key=>$value)
            {
                if ($j === 0) // first loop

                {
                    $this->db->or_where('geopos_talep_items.tip',$id[$key]);


                } else {

                    $this->db->or_where('geopos_talep_items.tip',$id[$key]);

                }

            }
        }
        else
        {
            $this->db->where('geopos_talep_items.tip',0);
        }



        return $this->db->count_all_results();

    }

    function count_filtered_talepler($opt = '')

    {

        $this->_get_datatables_query_talepler($opt);

        if ($opt) {

            $this->db->where('eid', $opt);

        }



        $query = $this->db->get();

        return $query->num_rows();

    }


    function get_datatables_stoklar($opt = '')

    {

        $this->_get_datatables_query_stoklar($opt);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();




        return $query->result();

    }
    private function _get_datatables_query_stoklar($opt = '')

    {
        $id=$this->input->post('dosya_id');

        if ($_POST['length'] != -1)
        {

            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $this->db->select('*');

        $this->db->from("geopos_ihale_items");

        $this->db->where('geopos_ihale_items.ihale_id',$id);



    }
    public function count_all_stoklar($opt = '')

    {

        $id=$this->input->post('dosya_id');
        $this->db->select('geopos_ihale_items.id');

        $this->db->from("geopos_ihale_items");

        $this->db->where('geopos_ihale_items.ihale_id',$id);


        return $this->db->count_all_results();

    }
    function count_filtered_stoklar($opt = '')

    {

        $this->_get_datatables_query_talepler($opt);

        if ($opt) {

            $this->db->where('eid', $opt);

        }



        $query = $this->db->get();

        return $query->num_rows();

    }



    function get_datatables_firmalar($opt = '')

    {

        $this->_get_datatables_query_firmalar($opt);

        if ($_POST['length'] != -1)

            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();




        return $query->result();

    }
    private function _get_datatables_query_firmalar($opt = '')

    {
        $id=$this->input->post('dosya_id');

        if ($_POST['length'] != -1)
        {

            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $this->db->select('geopos_ihale_items_firma.*,geopos_customers.company,geopos_customers.address,geopos_customers.phone');

        $this->db->from("geopos_ihale_items_firma");
        $this->db->join("geopos_customers","geopos_ihale_items_firma.firma_id=geopos_customers.id");
        $this->db->where('geopos_ihale_items_firma.ihale_id',$id);
        $this->db->group_by('geopos_ihale_items_firma.firma_id');



    }
    public function count_all_firmalar($opt = '')

    {

        $id=$this->input->post('dosya_id');
        $this->db->select('geopos_ihale_items_firma.id');

        $this->db->from("geopos_ihale_items_firma");
        $this->db->join("geopos_customers","geopos_ihale_items_firma.firma_id=geopos_customers.id");

        $this->db->where('geopos_ihale_items_firma.ihale_id',$id);
        $this->db->group_by('geopos_ihale_items_firma.firma_id');


        return $this->db->count_all_results();

    }
    function count_filtered_firmalar($opt = '')

    {

        $this->_get_datatables_query_firmalar($opt);

        if ($opt) {

            $this->db->where('eid', $opt);

        }



        $query = $this->db->get();

        return $query->num_rows();

    }

    public function product_detail($ihale_id,$firma_id,$oturum_id=1)
    {
        return $this->db->query("SELECT geopos_ihale_items.*,geopos_ihale_items_firma.item_id,geopos_ihale_items_firma.fiyat,geopos_ihale_items_firma.nakliye_durumu,geopos_ihale_items_firma.odeme,geopos_ihale_items_firma.ulke,geopos_ihale_items_firma.aciklama FROM geopos_ihale_items_firma
        INNER JOIN geopos_ihale_items ON geopos_ihale_items_firma.item_id=geopos_ihale_items.id
        Where geopos_ihale_items_firma.firma_id=$firma_id
        and geopos_ihale_items_firma.ihale_id=$ihale_id and geopos_ihale_items_firma.oturum=$oturum_id")->result();
    }


    public function priceUpdate(){
        $data = [
            'id' => $this->input->post('id'),
            'fiyat' => $this->input->post('price')
        ];

        $update = $this->db->set($data)->where('id',$this->input->post('id'))->update('geopos_ihale_items_firma');

        if($update){
            echo json_encode([
                'status'  => 'Success',
                'message' => $this->lang->line('UPDATED')
            ]);
        } else {
            echo json_encode([
                'status'  => 'Error',
                'message' => $this->lang->line('ERROR')
            ]);
        }
    }
}
